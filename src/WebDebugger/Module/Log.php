<?php
namespace ryunosuke\WebDebugger\Module;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use ryunosuke\WebDebugger\GlobalFunction;
use ryunosuke\WebDebugger\Html\AbstractHtml;
use ryunosuke\WebDebugger\Html\ArrayTable;
use ryunosuke\WebDebugger\Html\Popup;
use ryunosuke\WebDebugger\Html\Raw;
use function ryunosuke\WebDebugger\arrayize;

class Log extends AbstractModule
{
    /** @var self */
    private static $instance;

    /** @var array ログ */
    private $logs = [];

    /** @var string 保存ディレクトリ */
    private $logdir;

    /** @var LoggerAwareInterface[]|Logger[] */
    private $loggers = [];

    public static function log($value, $name = '')
    {
        if (self::$instance === null) {
            throw new \DomainException('Log Module is not initialized.');
        }

        return self::$instance->_log($value, $name);
    }

    protected function _initialize(array $options = [])
    {
        $options = array_replace_recursive([
            /**
             * string グローバル関数の名前
             *
             * function を与えるとその名前でグローバル関数として定義される。
             * デフォルトは `dlog` で、何らかの任意の名前を指定しても重複しない限り問題ないはず。
             * ただし、変更した場合は IDE 等でエラーが出るので何らかの対処をしたほうがよい。
             * （`dlog` であれば tests/bootstrap.php でダミー定義してるのでエラーにはならないはず）。
             */
            'function' => 'dlog',
            /** string preserve 時の保存ディレクトリ */
            'logfile'  => sys_get_temp_dir() . '/wd-module/Log/logfile.txt',
            /**
             * psr3/monolog インスタンスを渡すとこのモジュールにもログられるようになる
             *
             * monolog はデファクトに近いので特別扱いで対応している。
             * psr3 は内部ロガーの差し替え機構が存在しないので LoggerAwareInterface のみ対応。
             * 内部ロガーを変更するので留意。
             */
            'logger'   => [],
        ], $options);

        if (!function_exists($options['function'])) {
            $funcname = $options['function'];
            $class = __CLASS__;
            eval(/** @lang */ "function $funcname(){return call_user_func_array('$class::log', func_get_args());}");
        }

        $this->logdir = dirname($options['logfile']); // for compatible
        @mkdir($this->logdir, 0777, true);

        foreach (arrayize($options['logger']) as $logger) {
            if ($logger instanceof Logger) {
                $logger->pushHandler(new class($logger->getName()) extends AbstractProcessingHandler {
                    private string $name;

                    public function __construct(string $name)
                    {
                        $this->name = $name;
                        parent::__construct(Logger::DEBUG, true);
                    }

                    protected function write(array $record): void
                    {
                        $name = $this->name;

                        // monolog ならほぼ必ず level_name 要素が生えているはずなので特別扱いする
                        if (isset($record['level_name'])) {
                            $name .= "." . $record['level_name'];
                            unset($record['level'], $record['level_name']);
                        }

                        // 原則として不要（channel は name だし datetime は独自に取ってるし・・・）
                        unset($record['channel'], $record['datetime'], $record['formatted']);

                        Log::log($record, $name);
                    }
                });
            }
            elseif ($logger instanceof LoggerAwareInterface) {
                $logger->setLogger(new class($logger) extends AbstractLogger {
                    /** @var LoggerInterface[] */
                    private array $loggers;

                    public function __construct(LoggerAwareInterface $logger)
                    {
                        // LoggerAwareInterface ならなんらかの内部ロガーを持っているはず
                        $gather = function ($member) use (&$gather) {
                            $result = [];
                            foreach ((array) $member as $field) {
                                if ($field instanceof LoggerInterface) {
                                    $result[spl_object_id($field)] = $field;
                                }
                                if (is_array($field) || is_object($field)) {
                                    $result += $gather($field);
                                }
                            }
                            return $result;
                        };
                        $loggers = $gather($logger);

                        // 持ってないなら移譲できずにロギングをぶんどることになってしまうので例外とする
                        if (!$loggers) {
                            throw new \InvalidArgumentException('LoggerAwareInterface does not have internal LoggerInterface');
                        }
                        $this->loggers = $loggers;
                    }

                    public function log($level, $message, array $context = [])
                    {
                        foreach ($this->loggers as $logger) {
                            $logger->log($level, $message, $context);
                        }

                        if ($context) {
                            $context = ['message' => $message] + $context;
                        }
                        else {
                            $context = $message;
                        }

                        Log::log($context, "psr3." . $level);
                    }
                });
            }
            else {
                throw new \InvalidArgumentException('logger must be (Logger|LoggerAwareInterface)[]');
            }

            $this->loggers[] = $logger;
        }

        self::$instance = $this;
    }

    protected function _finalize()
    {
        self::$instance = null;
        $this->loggers = [];
    }

    protected function _setting()
    {
        if (empty($this->setting['preserve'])) {
            \ryunosuke\WebDebugger\rm_rf($this->logdir, false);
        }
    }

    protected function _log($value, $name = '')
    {
        $traces = [];
        foreach (array_reverse(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)) as $trace) {
            if (isset($trace['file']) && strpos($trace['file'], __FILE__) !== false) {
                break;
            }
            if (isset($trace['class']) && is_subclass_of($trace['class'], LoggerInterface::class)) {
                $traces[] = $trace;
                break;
            }
            $traces[] = $trace;
        }
        $traces = array_reverse($traces);

        $this->logs[] = [
            'time'  => GlobalFunction::microtime(true),
            'file'  => $traces[0]['file'] ?? null,
            'line'  => $traces[0]['line'] ?? null,
            'name'  => $name,
            'log'   => $value,
            'trace' => $traces,
        ];

        return $value;
    }

    protected function _gather()
    {
        $timezone = new \DateTimeZone(date_default_timezone_get());
        array_walk($this->logs, function (&$log) use ($timezone) {
            // datetime パラメータが UNIX タイムスタンプ (例: 946684800) だったり、タイムゾーンを含んでいたり (例: 2010-01-28T15:00:00+02:00) する場合は、 timezone パラメータや現在のタイムゾーンは無視します
            $log['time'] = \DateTime::createFromFormat('U.u', $log['time'])->setTimezone($timezone)->format('Y/m/d H:i:s.v');
        });

        return [
            'Log' => $this->logs,
        ];
    }

    protected function _getCount($stored)
    {
        return count($stored['Log']);
    }

    protected function _getError($stored)
    {
        $result = [];
        if (count($stored['Log'])) {
            $result[] = 'has ' . count($stored['Log']) . ' log';
        }
        return $result;
    }

    protected function _render($stored)
    {
        $logs = [];
        if (!empty($this->setting['preserve'])) {
            foreach (glob($this->logdir . '/wd-*') as $log) {
                $logs = array_merge($logs, unserialize(file_get_contents($log)));
            }
            usort($logs, function ($a, $b) { return $a['time'] <=> $b['time']; });
        }

        foreach ($stored['Log'] as &$log) {
            $log['log'] = $log['log'] instanceof AbstractHtml ? new Raw($log['log']) : $log['log'];
            $trace = array_map([$this, 'toOpenable'], $log['trace']);
            $log['trace'] = new Popup('trace', new ArrayTable('', $trace));
            $log = $this->toOpenable($log);
        }

        if (!empty($this->setting['preserve'])) {
            file_put_contents(tempnam($this->logdir, 'wd-'), serialize($stored['Log']));
        }

        $caption = new Raw('Log <label><input name="preserve" class="debug_plugin_setting" type="checkbox">preserve</label>');

        return [
            'Log' => new ArrayTable($caption, array_merge($logs, $stored['Log'])),
        ];
    }
}
