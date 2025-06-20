<?php
namespace ryunosuke\WebDebugger\Module;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\SQLLogger;
use Psr\Log\AbstractLogger;
use ryunosuke\WebDebugger\GlobalFunction;
use ryunosuke\WebDebugger\Html\ArrayTable;
use ryunosuke\WebDebugger\Html\HashTable;
use ryunosuke\WebDebugger\Html\Popup;
use ryunosuke\WebDebugger\Html\Raw;
use function ryunosuke\WebDebugger\sql_bind;
use function ryunosuke\WebDebugger\sql_format;

class Doctrine extends AbstractModule
{
    /** @var Connection */
    private $connection;

    /** @var callable */
    private $logger;

    /** @var callable */
    private $formatter;

    /** @var string */
    private $explain;

    /** @var callable */
    private $scorer;

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
                        $.post("doctrine-exec", {sql: sql}, function(response) {
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
            /** Connection DBAL Connection */
            'connection' => null,
            /** logger iterable|callable クエリログを返す */
            'logger'     => null,
            /** string|callable SQL フォーマッタ（省略時は format + highlight） */
            'formatter'  => 'highlight',
            /** string explain 接頭辞 */
            'explain'    => 'EXPLAIN',
            /**
             * array|callable slow スコア算出クロージャ（省略時は explain の結果からよしなに算出）
             *
             * EXPLAIN 実行時にその結果行から「遅い」とみなす判定を下すクロージャを指定する（引数は EXPLAIN の1行）。
             * クロージャは [type => $score] 形式の配列を返す必要があり、その合計値が 1.0を超えるとき「遅い」と見なされる。
             *
             * クロージャではなく [col => [str => $score]] 形式の配列を与えた場合、EXPLAIN の1行のカラムとその包含文字列で計算する。
             */
            'scorer'     => [
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

        // dbal ありきなので先に代入
        $this->connection = $options['connection'];
        if (!$this->connection instanceof Connection) {
            throw new \InvalidArgumentException('"connection" is not Doctrine\DBAL\Connection.');
        }

        // logger が来ていない場合はデフォルトロガー
        if (!isset($options['logger'])) {
            $configration = $this->connection->getConfiguration();
            if (interface_exists(SQLLogger::class)) {
                $options['logger'] = new class() implements SQLLogger, \IteratorAggregate {
                    private $current = [];
                    private $queries = [];

                    public function startQuery($sql, ?array $params = null, ?array $types = null)
                    {
                        $this->current[] = [
                            'sql'    => $sql,
                            'params' => $params,
                            'time'   => microtime(true),
                            'trace'  => array_slice(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), 2),
                        ];
                    }

                    public function stopQuery()
                    {
                        $current = array_pop($this->current);
                        if (in_array($current['sql'], ['"SAVEPOINT"', '"ROLLBACK TO SAVEPOINT"'], true)) {
                            return;
                        }
                        $current['time'] = microtime(true) - $current['time'];
                        $this->queries[] = $current;
                    }

                    public function getIterator(): \Generator
                    {
                        yield from $this->queries;
                    }
                };
                $currentLogger = $configration->getSQLLogger();
                $configration->setSQLLogger($currentLogger ? new LoggerChain([$currentLogger, $options['logger']]) : $options['logger']);
            }
            // @codeCoverageIgnoreStart
            else {
                $options['logger'] = new class extends AbstractLogger implements \IteratorAggregate {
                    private array $queries = [];

                    public function log($level, $message, array $context = []): void
                    {
                        if ($level === 'debug') {
                            return;
                        }
                        $this->queries[] = [
                            'sql'    => $context['sql'] ?? $message,
                            'params' => array_merge($context['params'] ?? []),
                            'time'   => isset($context['time']) ? (microtime(true) - $context['time']) : null,
                            'trace'  => array_slice(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), 2),
                        ];
                    }

                    public function getIterator(): \Generator
                    {
                        yield from $this->queries;
                    }
                };
                $middleware = new Doctrine\Logging\Middleware($options['logger']);
                $configration->setMiddlewares(array_merge($configration->getMiddlewares(), [$middleware]));

                (function () use ($middleware) {
                    /** @var \ryunosuke\WebDebugger\Module\Doctrine\Logging\Driver $driver */
                    $driver = $middleware->wrap($this->driver);

                    // DriverManager::getConnection の時点で middleware は解決されているので強制的に代入しなければならない
                    $this->driver = $driver;
                    // さらに接続済みだったら wrap を模倣しなければならない
                    if ($this->_conn !== null) {
                        $this->_conn = $driver->wrap($this->_conn);
                    }
                })->bindTo($this->connection, Connection::class)();
            }
            // @codeCoverageIgnoreEnd
        }

        // formatter に非callableが来た場合はクロージャ化
        if (!is_callable($options['formatter'])) {
            $formatter = $options['formatter'];
            $options['formatter'] = function ($sql) use ($formatter) {
                if ($formatter === 'compress') {
                    return sql_format($sql, [
                        'highlight' => false,
                        'wrapsize'  => PHP_INT_MAX,
                    ]);
                }
                elseif ($formatter === 'pretty') {
                    return sql_format($sql, [
                        'highlight' => false,
                        'wrapsize'  => false,
                    ]);
                }
                elseif ($formatter === 'highlight') {
                    return sql_format($sql, [
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

        if (!is_callable($this->logger) && !$this->logger instanceof \Traversable) {
            throw new \InvalidArgumentException('"logger" is not callable/traversable.');
        }
        if (!is_callable($this->scorer)) {
            throw new \InvalidArgumentException('"scorer" is not callable.');
        }
    }

    protected function _hook(array $request)
    {
        // クエリ実行リクエストだったら実行して exit
        if ($request['is_ajax'] && isset($_POST['sql']) && strpos($request['path'], 'doctrine-exec') !== false) {
            try {
                $rows = $this->connection->executeQuery($_POST['sql'])->fetchAllAssociative();
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

    private function explain($sql, $params)
    {
        $simplequery = preg_replace('#(CREATE\s+TEMPORARY\s+TABLE.+)SELECT#uis', 'SELECT', $sql, 1, $count);
        if ($count > 0) {
            $sql = $simplequery;
        }

        $explains = [];
        try {
            $explains = $this->connection->executeQuery("$this->explain $sql", $params ?? [])->fetchAllAssociative();
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

    protected function _gather(array $request): array
    {
        $logs = [];
        $time = 0;

        foreach (is_callable($this->logger) ? ($this->logger)() : $this->logger as $log) {
            $sql = $log['sql'];
            $params = $log['params'];

            $log['sql'] = sql_bind($sql, $params, fn($v) => $this->connection->quote($v));

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
            'Connection' => [
                'params' => $this->connection->getParams(),
                'native' => $this->connection->getNativeConnection(),
                'config' => $this->connection->getConfiguration(),
            ],
            'Query'      => [
                'summary' => $summary,
                'logs'    => $logs,
            ],
        ];
    }

    protected function _getCount($stored): ?int
    {
        return count($stored['Query']['logs']);
    }

    protected function _getError($stored): array
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
        }
        return array_keys($error);
    }

    protected function _getHtml($stored): string
    {
        $styles = [];
        foreach ($stored['Query']['logs'] as $n => &$log) {
            // sql は textarea で exec ボタンを用意
            $log['sql'] = call_user_func($this->formatter, $log['sql']);
            $html = '<div contenteditable="true" spellcheck="false">' . $log['sql'] . '</div><button class="execsql">execute</button><span class="result_area"></span>';
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
        }
        $caption = new Raw('Query' . $stored['Query']['summary'] . ' <label><input name="explain" class="debug_plugin_setting" type="checkbox">explain</label>');

        return implode('', [
            new HashTable('connection', $stored['Connection']),
            new ArrayTable($caption, $stored['Query']['logs'], $styles),
        ]);
    }
}
