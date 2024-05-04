<?php
namespace ryunosuke\WebDebugger;

use ryunosuke\WebDebugger\Module\AbstractModule;

class Debugger
{
    /** @var array */
    private $options;

    /** @var array */
    private $request = [];

    /** @var AbstractModule[] */
    private $modules = [];

    /** @var array */
    private $stores;

    public static function formatApplicationJson($contents)
    {
        $json = json_decode($contents, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        return null;
    }

    public static function formatApplicationXml($contents, $matches)
    {
        try {
            preg_match('#charset=(.*)#i', $matches, $misc);
            $dom = new \DOMDocument();
            $dom->loadXML($contents);
            $dom->encoding ??= $misc[1] ?? 'UTF-8';
            $dom->formatOutput = true;
            return $dom->saveXML();
        }
        catch (\Throwable $t) {
            return null;
        }
    }

    public function __construct(array $options = [])
    {
        // デフォルトオプション
        $default = [
            /** ひっかけるレスポンスヘッダー */
            'rewrite'      => [
                'text/.*'          => fn($contents) => $contents,
                'application/json' => [static::class, 'formatApplicationJson'],
                'application/xml'  => [static::class, 'formatApplicationXml'],
            ],
            /** bool PRG パターンの抑止フラグ */
            'stopprg'      => true,
            /** string ひっかけるパス */
            'fookpath'     => 'webdebugger-action',
            /** string 無視するパス */
            'ignore'       => '#\.(ico|map)$#',
            /** string リクエストファイル置き場 */
            'workdir'      => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'wd-working',
            /** string パスを開く URL とパラメータ */
            'opener'       => 'http://localhost:9090',
            'opener_query' => 'project=X&remote=true',
        ];

        // グローバル設定
        $this->options = array_replace_recursive($default, $options);

        // $request 変数
        $this->request['time'] = GlobalFunction::microtime(true);
        $this->request['id'] = GlobalFunction::date('YmdHis') . '.' . preg_replace('#^\d+\.#', '', $this->request['time']);
        $this->request['url'] = $_SERVER['REQUEST_URI'] ?? '';
        $this->request['path'] = preg_replace('#\\?.+#', '', $this->request['url']);
        $this->request['method'] = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $this->request['is_ajax'] = isset($_SERVER['HTTP_X_DEBUG_AJAX']);
        $this->request['is_internal'] = strpos($this->request['path'], $this->options['fookpath']) !== false;
        $this->request['if_modified_since'] = (int) strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'] ?? '');
        $this->request['is_ignore'] = !!preg_match($this->options['ignore'], $this->request['path']);
        $this->request['workfile'] = $this->options['workdir'] . DIRECTORY_SEPARATOR . $this->request['id'];
        $this->request['workpath'] = $this->options['fookpath'] . "/request-{$this->request['id']}";
    }

    public function initialize(array $options = [])
    {
        if ($this->request['is_ignore']) {
            return $this;
        }

        foreach ($options as $classname => $option) {
            if ($option instanceof AbstractModule) {
                $this->modules[$classname] = $option;
                unset($options[$classname]);
            }
            else {
                /** @var AbstractModule $classname */
                $module = $classname::getInstance();
                $this->modules[$classname] = $module;
            }
        }

        $module_options = json_decode($_COOKIE['WebDebuggerOptions'] ?? '{}', true);
        foreach ($this->modules as $classname => $module) {
            if (($module_options[$classname]['enable'] ?? true) === false) {
                $module->disable();
            }

            if (isset($options[$classname])) {
                $module->initialize($options[$classname]);
            }

            if (!$this->request['is_internal']) {
                $module->setting($module_options[$classname] ?? []);
            }
        }

        return $this;
    }

    public function start()
    {
        if ($this->request['is_ignore']) {
            return;
        }

        // モジュール群の fook イベント
        if ($this->request['is_internal']) {
            foreach ($this->modules as $module) {
                $fook_response = $module->fook($this->request);
                if ($fook_response) {
                    return $fook_response;
                }
            }
        }

        // リクエストファイルの返却
        if ($this->request['is_internal'] && preg_match('#request-(\d{14}\.\d+)#', $this->request['path'], $matches)) {
            $request_file = $this->options['workdir'] . DIRECTORY_SEPARATOR . $matches[1];

            // php-fpm だと fastcgi_finish_request でshutdown 関数が呼ばれるのでこの段階でファイルがないことがある
            for ($i = 0; $i < 1000 && !file_exists($request_file); $i++) {
                clearstatcache($request_file);
                usleep(10000);
            }
            if (!file_exists($request_file)) {
                return GlobalFunction::response("$request_file is not found");
            }
            $data = unserialize(file_get_contents($request_file));
            $stores = $data['stores'];

            $prepare = '';
            $module_data = [];
            foreach ($this->modules as $name => $module) {
                $prepare .= $module->prepareInner();
                if (array_key_exists($name, $stores)) {
                    $module_data[] = [
                        'class'    => $name,
                        'name'     => $module->getName(),
                        'color'    => $module->getColor(),
                        'disabled' => $module->isDisabled(),
                        'count'    => $stores[$name]['count'],
                        'error'    => $stores[$name]['error'],
                        'html'     => $stores[$name]['html'],
                    ];
                }
            }

            GlobalFunction::header('Content-Type: text/html');
            ob_start('ob_gzhandler');
            require __DIR__ . '/../template/debugger.php';
            return GlobalFunction::response(null);
        }

        // 終了時に情報を集めたりフックしたりする
        GlobalFunction::register_shutdown_function(function () {
            $this->stores = $this->stores ?? array_maps($this->modules, ['gather' => [$this->request]]);

            // 画面への出力の保存（ob_start のコールバック内では ob_ 系が使えないので終了時にレンダリングする）
            file_set_contents($this->request['workfile'], serialize([
                'request' => $this->request,
                'stores'  => array_maps($this->stores, function ($v, $k) {
                    return [
                        'count' => $this->modules[$k]->getCount($v),
                        'error' => $this->modules[$k]->getError($v),
                        'html'  => $this->modules[$k]->render($v),
                    ];
                }),
            ]));

            // ゴミの削除
            @array_map('unlink', array_slice(glob($this->options['workdir'] . '/*'), 0, -100));
        });

        // ob_start にコールバックを渡すと ob_end～ の時に呼ばれるので、レスポンスをフックできる
        ob_start(function ($buffer) {
            $this->stores = $this->stores ?? array_maps($this->modules, ['gather' => [$this->request]]);

            $headers = implode("\n", GlobalFunction::headers_list());

            // PRG パターンの抑止
            if ($this->options['stopprg'] && !$this->request['is_ajax'] && $this->request['method'] === 'POST' && preg_match('#^Location:(.+)$#mi', $headers, $matches)) {
                GlobalFunction::header_remove('Location');
                $location = htmlspecialchars(trim($matches[1]), ENT_QUOTES, 'UTF-8');
                $buffer = str_replace('http-equiv="refresh"', '', $buffer);
                $buffer = sprintf('<body><p style="padding-left:24px;font-size:40px;">Redirecting to<br /><a href="%1$s">%1$s</a></p></body>', $location) . $buffer;
            }

            // Ajax でない通常リクエストで特定ヘッダーならアグレッシブに書き換える（html 化してデバッグを容易にする）
            if (!$this->request['is_ajax']) {
                foreach ($this->options['rewrite'] as $ctype => $callback) {
                    // $ctype を preg_quote していないのでは意図的（"text/.*?" みたいに引っ掛けたい）
                    if (!preg_match('#^Content-Type:\s*text/html#mi', $headers) && preg_match("#^Content-Type:\s*($ctype.*)$#mi", $headers, $matches)) {
                        $rewritten = $callback($buffer, $matches[1]);
                        if ($rewritten !== null) {
                            $buffer = "<html><head></head><body><pre style='margin:0 20px'>" . htmlspecialchars($rewritten, ENT_QUOTES, 'UTF-8') . "</pre></body></html>";
                            GlobalFunction::header("X-Original-Content-Type: {$matches[1]}");
                            GlobalFunction::header("Content-Type: text/html");
                            $headers = implode("\n", GlobalFunction::headers_list());
                            break;
                        }
                    }
                }
            }

            // Ajax ならリクエストパスを返すのみ(ヘッダ埋め込み)
            if ($this->request['is_ajax']) {
                GlobalFunction::header("X-Debug-Ajax: " . $this->request['workpath']);
            }
            // 通常リクエストでかつ Content-type がないあるいは text/html のとき</body>に iframe を埋め込み
            elseif (!preg_match('#^Content-Type:#mi', $headers) || preg_match('#^Content-Type: text/html#mi', $headers)) {
                if (($pos = stripos($buffer, '</head>')) !== false) {
                    $prepare = "<!-- this is web debugger head injection -->\n" . implode('', array_maps($this->modules, '@prepareOuter'));
                    $buffer = substr_replace($buffer, "{$prepare}</head>", $pos, strlen('</head>'));
                }
                if (($pos = strripos($buffer, '</body>')) !== false) {
                    $width = (count($this->modules) * 20) . 'px';
                    $height = (20) . 'px';
                    $iframe = "<!-- this is web debugger body injection -->
                        <iframe
                            id='webdebugger-iframe'
                            style='
                                position: fixed;
                                left: 0;
                                bottom: 0;
                                width: {$width};
                                height: {$height};
                                border: none;
                                box-sizing: border-box;
                                background: transparent;
                                z-index: 910000;
                                overflow: visible;
                            '
                        ></iframe>
                        <style>
                        #webdebugger-iframe.fullsize {
                            width: 100% !important;
                            height: 100% !important;
                        }
                        </style>
                        <script>
                            (function(){
                                const iframe = document.getElementById('webdebugger-iframe');
                                iframe.src = '{$this->request['workpath']}';
                                iframe.onload = function() {
                                    iframe.completed = true;
                                }
                            })();
                        </script>
                    ";
                    $buffer = substr_replace($buffer, "{$iframe}</body>", $pos, strlen('</body>'));
                }
            }
            return $buffer;
        });

        return true;
    }
}
