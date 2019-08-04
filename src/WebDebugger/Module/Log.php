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

    /** @var string 保存ディレクトリ */
    private $logfile;

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

        $this->logfile = $options['logfile'];
    }

    protected function _finalize()
    {
        self::$instance = null;
    }

    protected function _setting()
    {
        if (empty($this->setting['preserve']) && file_exists($this->logfile)) {
            unlink($this->logfile);
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

        $log = [
            'time'  => date('Y/m/d H:i:s', GlobalFunction::time()),
            'file'  => $traces[0]['file'] ?? null,
            'line'  => $traces[0]['line'] ?? null,
            'name'  => $name,
            'log'   => $value,
            'trace' => $traces,
        ];

        @mkdir(dirname($this->logfile), 0777, true);
        file_put_contents($this->logfile, json_encode($log, JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND | LOCK_EX);

        return $value;
    }

    protected function _gather()
    {
        $logs = [];
        if (file_exists($this->logfile)) {
            $logs = array_map(function ($log) { return json_decode($log, true); }, file($this->logfile));
        }

        return [
            'Log' => $logs,
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
        foreach ($stored['Log'] as &$log) {
            $trace = array_map([$this, 'toOpenable'], $log['trace']);
            $log['trace'] = new Popup('trace', new ArrayTable('', $trace));
            $log = $this->toOpenable($log);
        }
        $caption = new Raw('Log <label><input name="preserve" class="debug_plugin_setting" type="checkbox">preserve</label>');
        return [
            'Log' => new ArrayTable($caption, $stored['Log']),
        ];
    }

    protected function _console($stored)
    {
        return [
            'Log' => ['table' => $stored['Log']],
        ];
    }
}
