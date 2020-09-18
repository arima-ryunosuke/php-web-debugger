<?php
namespace ryunosuke\WebDebugger\Module;

use ryunosuke\WebDebugger\GlobalFunction;
use ryunosuke\WebDebugger\Html\ArrayTable;
use ryunosuke\WebDebugger\Html\Popup;
use ryunosuke\WebDebugger\Html\Raw;

class Log extends AbstractModule
{
    /** @var self */
    private static $instance;

    /** @var array ログ */
    private $logs = [];

    /** @var string 保存ディレクトリ */
    private $logdir;

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
        ], $options);

        if (!function_exists($options['function'])) {
            $funcname = $options['function'];
            $class = __CLASS__;
            eval("function $funcname(){return call_user_func_array('$class::log', func_get_args());}");
        }

        self::$instance = $this;

        $this->logdir = dirname($options['logfile']); // for compatible
        @mkdir($this->logdir, 0777, true);
    }

    protected function _finalize()
    {
        self::$instance = null;
    }

    protected function _setting()
    {
        if (empty($this->setting['preserve'])) {
            \ryunosuke\WebDebugger\rm_rf($this->logdir, false);
        }
    }

    protected function _log($value, $name = '')
    {
        $traces = \ryunosuke\WebDebugger\backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, [
            // 自身の log でもグローバルな dlog でもないものを探す
            'file' => function ($file) {
                return strpos($file, __FILE__) === false;
            },
        ]);

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

    protected function _getError($stored)
    {
        $result = [];
        if (count($stored['Log'])) {
            $result[] = 'has log';
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
            $log['log'] = new Raw($log['log']);
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

    protected function _console($stored)
    {
        return [
            'Log' => ['table' => $stored['Log']],
        ];
    }
}
