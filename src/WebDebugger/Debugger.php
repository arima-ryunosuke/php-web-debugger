<?php
namespace ryunosuke\WebDebugger;

use ryunosuke\WebDebugger\Module\AbstractModule;

class Debugger
{
    /** @var array */
    private $options = [];

    /** @var array */
    private $request = [];

    /** @var AbstractModule[] */
    private $modules = [];

    public function __construct(array $options = [])
    {
        // デフォルトオプション
        $default = [
            /** array 表示形態（html: DOM 埋め込み, console: ChromeLogger）複数指定可 */
            'rtype'    => ['html', 'console'],
            /** bool PRG パターンの抑止フラグ */
            'stopprg'  => true,
            /** string ひっかけるパス */
            'fookpath' => 'webdebugger-action',
            /** string 無視するパス */
            'ignore'   => '#\.(ico|map)$#',
            /** string リクエストファイル置き場 */
            'workdir'  => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'wd-working',
            /** string パスを開く URL */
            'opener'   => 'http://localhost:9999/exec',
        ];

        // グローバル設定
        $this->options = array_replace_recursive($default, $options);

        // $request 変数
        $this->request['path'] = preg_replace('#\\?.+#', '', $_SERVER['REQUEST_URI'] ?? '');
        $this->request['method'] = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $this->request['is_ajax'] = isset($_SERVER['HTTP_X_REQUESTED_WITH']);
        $this->request['is_internal'] = strpos($this->request['path'], $this->options['fookpath']) !== false;
        $this->request['if_modified_since'] = (int) strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE'] ?? '');
        $this->request['is_ignore'] = !!preg_match($this->options['ignore'], $this->request['path']);
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
        if ($this->request['is_internal'] && preg_match('#request-((\d{8})(\d{6}).(\d+))#', $this->request['path'], $matches)) {
            $request_dir = $this->options['workdir'] . DIRECTORY_SEPARATOR . $matches[2];
            $request_file = $request_dir . DIRECTORY_SEPARATOR . $matches[1];

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
            return GlobalFunction::response(ob_get_clean());
        }

        // 必要そうな変数群
        $today = date('Ymd');
        $request_dir = $this->options['workdir'] . DIRECTORY_SEPARATOR . $today;
        $request_id = $today . date('His') . '.' . preg_replace('#^\d+\.#', '', microtime(true));
        $request_file = $request_dir . DIRECTORY_SEPARATOR . $request_id;
        $request_path = "{$this->options['fookpath']}/request-{$request_id}?from-iframe=1";

        // 終了時に情報を集めたりフックしたりする
        GlobalFunction::register_shutdown_function(function () use ($request_file) {
            $response_type = (array) (is_callable($this->options['rtype']) ? ($this->options['rtype'])() : $this->options['rtype']);
            $html_enable = in_array('html', $response_type);
            $console_enable = in_array('console', $response_type);
            $stores = array_map_method($this->modules, 'gather');

            // 画面への出力の保存（ob_start のコールバック内では ob_ 系が使えないので終了時にレンダリングする）
            if ($html_enable) {
                file_set_contents($request_file, serialize([
                    'request' => $this->request,
                    'stores'  => array_kmap($stores, function ($v, $k) {
                        return [
                            'count' => $this->modules[$k]->getCount($v),
                            'error' => $this->modules[$k]->getError($v),
                            'html'  => $this->modules[$k]->render($v),
                        ];
                    }),
                ]));
            }

            // js コンソールへの出力
            if ($console_enable) {
                ChromeLogger::groupCollapsed($this->request['method'] . ' ' . $this->request['path']);
                foreach ($this->modules as $name => $module) {
                    $fires = $module->console($stores[$name]);
                    if ($fires !== null) {
                        ChromeLogger::groupCollapsed($module->getName());
                        foreach ($fires as $title => $fire) {
                            ChromeLogger::info($title);
                            foreach ($fire as $method => $data) {
                                ChromeLogger::$method($data);
                            }
                        }
                        ChromeLogger::groupEnd();
                    }
                }
                ChromeLogger::groupEnd();
                ChromeLogger::send();
            }
        });

        // ob_start にコールバックを渡すと ob_end～ の時に呼ばれるので、レスポンスをフックできる
        ob_start(function ($buffer) use ($request_file, $request_path) {
            $headers = implode("\n", GlobalFunction::headers_list());

            // PRG パターンの抑止
            if ($this->options['stopprg'] && !$this->request['is_ajax'] && $this->request['method'] === 'POST' && preg_match('#^Location:(.+)$#mi', $headers, $matches)) {
                GlobalFunction::header_remove('Location');
                $location = htmlspecialchars(trim($matches[1]), ENT_QUOTES, 'UTF-8');
                $buffer = str_replace('http-equiv="refresh"', '', $buffer);
                $buffer = sprintf('<body><p style="padding-left:24px;font-size:40px;">Redirecting to<br /><a href="%1$s">%1$s</a></p></body>', $location) . $buffer;
            }

            // Ajax ならリクエストパスを返すのみ(ヘッダ埋め込み)
            if ($this->request['is_ajax']) {
                GlobalFunction::header("X-Debug-Ajax: " . $request_path);
            }
            // 通常リクエストでかつ Content-type がないあるいは text/html のとき</body>に iframe を埋め込み
            elseif (file_exists($request_file) && !preg_match('#^Content-Type:#mi', $headers) || preg_match('#^Content-Type: text/html#mi', $headers)) {
                if (($pos = strripos($buffer, '</body>')) !== false) {
                    $width = (20) . 'px';
                    $height = (count($this->modules) * 20) . 'px';
                    $iframe = "
                        <iframe
                            id='webdebugger-iframe'
                            style='
                                position: fixed;
                                left: 0;
                                top: 0;
                                width: {$width};
                                height: {$height};
                                border: none;
                                box-sizing: border-box;
                                background: transparent;
                                z-index: 910000;
                                overflow: visible;
                            '
                        ></iframe>
                        <script>
                            (function(){
                                const iframe = document.getElementById('webdebugger-iframe');
                                iframe.src = '{$request_path}';
                                iframe.onload = function() {
                                    iframe.completed = true;
                                }
                            })();
                        </script>
                    ";
                    $prepare = implode('', array_map_method($this->modules, 'prepareOuter'));
                    $buffer = substr_replace($buffer, "{$prepare}{$iframe}</body>", $pos, strlen('</body>'));
                }
            }
            return $buffer;
        });

        return true;
    }
}
