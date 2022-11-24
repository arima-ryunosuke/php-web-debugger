<?php
namespace ryunosuke\WebDebugger\Module;

use ryunosuke\WebDebugger\GlobalFunction;
use ryunosuke\WebDebugger\Html\ArrayTable;
use ryunosuke\WebDebugger\Html\Popup;
use ryunosuke\WebDebugger\Html\Raw;

class Database extends AbstractModule
{
    /** @var \PDO */
    private $pdo;

    /** @var callable */
    private $logger;

    /** @var callable */
    private $formatter;

    /** @var string */
    private $explain;

    /** @var callable */
    private $scorer;

    /** @noinspection PhpDeprecationInspection */
    public static function doctrineAdapter(\Doctrine\DBAL\Connection $connection, $options = [])
    {
        return function () use ($connection, $options) {
            $pdo = $connection->getNativeConnection();

            $logger = new class($pdo) implements \Doctrine\DBAL\Logging\SQLLogger, \IteratorAggregate {
                /** @var \PDO */
                private $pdo;
                private $queries = [];

                public function __construct($pdo)
                {
                    $this->pdo = $pdo;
                }

                public function startQuery($sql, ?array $params = null, ?array $types = null)
                {
                    $this->queries[] = [
                        'sql'    => $sql,
                        'params' => $params,
                        'time'   => microtime(true),
                        'trace'  => array_slice(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), 2),
                    ];
                }

                public function stopQuery()
                {
                    $current = count($this->queries) - 1;
                    $this->queries[$current]['time'] = microtime(true) - $this->queries[$current]['time'];

                    // 成功か失敗かを得る術がないので errorInfo で確認（ただし stmt のエラーは取れないし互換性担保のために近い）
                    $error = $this->pdo->errorInfo();
                    if ($error[0] !== '00000' && strlen($error[2])) {
                        $this->queries[$current]['message'] = $error[2];
                    }
                }

                public function getIterator(): \Generator
                {
                    yield from $this->queries;
                }

                public function clear()
                {
                    $this->queries = [];
                }
            };
            $configration = $connection->getConfiguration();
            $currentLogger = $configration->getSQLLogger();
            $configration->setSQLLogger($currentLogger ? new \Doctrine\DBAL\Logging\LoggerChain([$currentLogger, $logger]) : $logger);

            return array_replace($options, [
                'pdo'    => $pdo,
                'logger' => $logger,
            ]);
        };
    }

    public function prepareInner()
    {
        return '
            <style>
                .sql [contenteditable] {
                    width: 100%;
                    max-width: 58vw;
                    border: 1px solid #ddd;
                    padding: 4px;
                    border-radius: 2px;
                    margin-bottom: 4px;
                    white-space: pre-wrap;
                }
                .sql [contenteditable] pre {
                    white-space: pre-wrap;
                }
            </style>
            <script>
                $(function() {
                    $(document).on("click", ".execsql", function() {
                        var $this = $(this);
                        var sql = $this.prevAll("[contenteditable]").text();
                        $.post("database-exec", {sql: sql}, function(response) {
                            $this.nextAll(".result_area").html(response).find(".popup").click();
                        }, "html");
                    });
                });
            </script>
        ';
    }

    protected function _initialize(array $options = [])
    {
        $options = array_replace_recursive([
            /** \PDO PDO インスタンス */
            'pdo'       => null,
            /**
             * callable|null ログ蒐集 callable
             *
             * logger オプションを省略するためには pdo に LoggablePDO インスタンスを渡す必要がある。
             * これについては LoggablePDO::replace/reflect を参照。
             * いずれにせよ何らかの方法で（フレームワークなどが握っている） PDO インスタンスを差し替える必要がある。
             * （大抵の DB Adapter には pdo インスタンスを指定する機能が存在するはず）。
             *
             * logger を渡す場合、最低限 [['sql' => $sql, 'params' => $params]] 形式の配列を返す callable/traversable である必要がある。
             * 渡す場合、大抵の DB Adapter にはクエリログを取る機能が付属しているのでそれを使うとよい。
             */
            'logger'    => null,
            /** string|callable SQL フォーマッタ（省略時は format + highlight） */
            'formatter' => 'highlight',
            /** string explain 接頭辞 */
            'explain'   => 'EXPLAIN',
            /**
             * array|callable slow スコア算出クロージャ（省略時は explain の結果からよしなに算出）
             *
             * EXPLAIN 実行時にその結果行から「遅い」とみなす判定を下すクロージャを指定する（引数は EXPLAIN の1行）。
             * クロージャは [type => $score] 形式の配列を返す必要があり、その合計値が 1.0を超えるとき「遅い」と見なされる。
             *
             * クロージャではなく [col => [str => $score]] 形式の配列を与えた場合、EXPLAIN の1行のカラムとその包含文字列で計算する。
             */
            'scorer'    => [
                // for mysql
                'type'  => [
                    'ALL'   => 1,
                    'index' => 0.8,
                ],
                'Extra' => [
                    'Using temporary'   => 0.5,
                    'Using filesort'    => 0.75,
                    'Using join buffer' => 0.5,
                ],
            ],
        ], $options);

        // pdo ありきなので先に代入（チェックは後）
        $this->pdo = $options['pdo'];

        // 管理下にある PDO なら logger は getLog で確定
        /** @noinspection PhpDeprecationInspection */
        if ($options['logger'] === null && $this->pdo instanceof \ryunosuke\WebDebugger\Module\Database\LoggablePDO) {
            $options['logger'] = [$this->pdo, 'getLog']; // @codeCoverageIgnore
        }

        // formatter に非callableが来た場合はクロージャ化
        if (!is_callable($options['formatter'])) {
            $formatter = $options['formatter'];
            $options['formatter'] = function ($sql) use ($formatter) {
                if ($formatter === 'compress') {
                    return \ryunosuke\WebDebugger\sql_format($sql, [
                        'highlight' => false,
                        'wrapsize'  => PHP_INT_MAX,
                    ]);
                }
                elseif ($formatter === 'pretty') {
                    return \ryunosuke\WebDebugger\sql_format($sql, [
                        'highlight' => false,
                        'wrapsize'  => false,
                    ]);
                }
                elseif ($formatter === 'highlight') {
                    return \ryunosuke\WebDebugger\sql_format($sql, [
                        'highlight' => true,
                        'wrapsize'  => false,
                    ]);
                }
                else {
                    return $sql;
                }
            };
        }

        // scorer に配列が来た場合はクロージャ化
        if (is_array($options['scorer'])) {
            $scoremap = $options['scorer'];
            $options['scorer'] = function ($exrow) use ($scoremap) {
                $result = [];
                foreach ($scoremap as $col => $scores) {
                    if (array_key_exists($col, $exrow)) {
                        $result[$col] = 0;
                        foreach ($scores as $str => $score) {
                            if (ctype_digit(trim($str, '<=>')) && eval("return (int) '{$exrow[$col]}'{$str};")) {
                                $result[$col] += $score;
                            }
                            if (strpos((string) $exrow[$col], $str) !== false) {
                                $result[$col] += $score;
                            }
                        }
                    }
                }
                return $result;
            };
        }

        $this->logger = $options['logger'];
        $this->formatter = $options['formatter'];
        $this->explain = $options['explain'];
        $this->scorer = $options['scorer'];

        if (!$this->pdo instanceof \PDO) {
            throw new \InvalidArgumentException('"pdo" is not PDO.');
        }
        if (!is_callable($this->logger) && !$this->logger instanceof \Traversable) {
            throw new \InvalidArgumentException('"logger" is not callable/traversable.');
        }
        if (!is_callable($this->scorer)) {
            throw new \InvalidArgumentException('"scorer" is not callable.');
        }
    }

    protected function _fook(array $request)
    {
        // クエリ実行リクエストだったら実行して exit
        if ($request['is_ajax'] && isset($_POST['sql']) && strpos($request['path'], 'database-exec') !== false) {
            try {
                $stmt = $this->pdo->query($_POST['sql']);
                $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                $rows = array_slice($rows, 0, 256) ?: [
                    ['exec' => 'empty'],
                ];
                $table = new ArrayTable('', $rows);
                $popup = new Popup('result', $table);
            }
            catch (\Exception $ex) {
                $popup = new Popup('error', new Raw('<p style="background:#ddd">' . htmlspecialchars($ex->getMessage()) . '</p>'));
            }
            return GlobalFunction::response($popup);
        }
    }

    private function quote($sql, $params)
    {
        $pos = 0;
        return preg_replace_callback('/(\?)|(:([a-z_][a-z_0-9]*))/ui', function ($m) use ($params, &$pos) {
            $name = $m[1] === '?' ? $pos++ : $m[3];
            if (array_key_exists($name, $params)) {
                return $params[$name] === null ? 'NULL' : $this->pdo->quote($params[$name]);
            }
        }, $sql);
    }

    private function explain($sql, $params)
    {
        $simplequery = preg_replace('#(CREATE\s+TEMPORARY\s+TABLE.+)SELECT#uis', 'SELECT', $sql, 1, $count);
        if ($count > 0) {
            $sql = $simplequery;
        }

        $explains = [];
        try {
            $stmt = $this->pdo->prepare("$this->explain $sql");
            $stmt->execute($params);
            $explains = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($explains as $n => $explain) {
                $explains[$n] = $explain;
                $explains[$n]['score'] = array_sum(call_user_func($this->scorer, $explain));
            }
        }
        catch (\Exception $ex) {
            //ここでコケてもどうしようもないので握りつぶす
        }
        return $explains;
    }

    protected function _gather()
    {
        $logs = [];
        $time = 0;

        foreach (is_callable($this->logger) ? ($this->logger)() : $this->logger as $n => $log) {
            $log = ['id' => $n] + $log;
            $sql = $log['sql'];
            $params = $log['params'];

            $log['sql'] = $this->quote($sql, $params);

            $t = $log['time'] ?? null;
            $time += $t;
            $log['time'] = $t === null ? 'null' : $t;

            if ($this->explain && !empty($this->setting['explain'])) {
                $log['explain'] = $this->explain($sql, $params);
            }
            $logs[] = $log;
        }

        $summary = " (" . count($logs) . " queries, $time second)";

        return [
            'Query' => [
                'summary' => $summary,
                'logs'    => $logs,
            ],
        ];
    }

    protected function _getCount($stored)
    {
        return count($stored['Query']['logs']);
    }

    protected function _getError($stored)
    {
        $error = [];
        if (count($stored['Query']['logs'])) {
            $error['has ' . count($stored['Query']['logs']) . ' quries'] = true;
        }
        foreach ($stored['Query']['logs'] as $log) {
            if (isset($log['explain'])) {
                foreach ($log['explain'] as $explain) {
                    if ($explain['score'] >= 1.0) {
                        $error['has slow query'] = true;
                        break;
                    }
                }
            }
            if (isset($log['message'])) {
                $error['has error query'] = true;
            }
        }
        return array_keys($error);
    }

    protected function _render($stored)
    {
        $result = [];
        foreach ($stored as $category => $data) {
            $styles = [];
            foreach ($data['logs'] as $n => &$log) {
                // sql は textarea で exec ボタンを用意
                $log['sql'] = call_user_func($this->formatter, $log['sql']);
                $html = '<div contenteditable="true">' . $log['sql'] . '</div><button class="execsql">execute</button><span class="result_area"></span>';
                $log['sql'] = new Raw($html);

                // explain はテーブル＋ポップアップ化
                if (isset($log['explain'])) {
                    // slow と思われる原因を赤くする
                    $styles2 = [];
                    foreach ($log['explain'] as $m => $explain) {
                        $scores = call_user_func($this->scorer, $explain);
                        foreach ($scores as $col => $score) {
                            if ($score) {
                                $styles2[$m][$col] = 'background:#fdd;';
                            }
                        }
                    }
                    $scores = array_map(function ($v) { return $v['score']; }, $log['explain']) ?: [0];
                    $max = max($scores);
                    if ($max >= 1.0) {
                        $styles[$n]['explain'] = 'background:#fdd;';
                    }
                    $title = sprintf('explain(table:%d, max:%d, avg:%.2f)', count($log['explain']), $max, array_sum($scores) / count($scores));
                    $table = new ArrayTable('', $log['explain'], $styles2);
                    $log['explain'] = new Popup($title, $table);
                }
                // trace は関連実行＋テーブル＋ポップアップ化
                if (isset($log['trace'])) {
                    $log['trace'] = array_map([$this, 'toOpenable'], $log['trace']);
                    $table = new ArrayTable('', $log['trace']);
                    $log['trace'] = new Popup('trace', $table);
                }
                // 実行に失敗した例外
                if (isset($log['message'])) {
                    $styles[$n]['sql'] = 'background:#fcc;';
                    $styles[$n]['message'] = 'background:#fcc;';
                }
            }
            $caption = new Raw($category . $data['summary'] . ' <label><input name="explain" class="debug_plugin_setting" type="checkbox">explain</label>');
            $result[$category] = new ArrayTable($caption, $data['logs'], $styles);
        }
        return $result;
    }

    protected function _console($stored)
    {
        $result = [];
        foreach ($stored as $category => $data) {
            $result[$category . $data['summary']] = ['table' => $data['logs']];
        }
        return $result;
    }
}
