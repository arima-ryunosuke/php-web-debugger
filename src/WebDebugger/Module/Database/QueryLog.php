<?php
namespace ryunosuke\WebDebugger\Module\Database;

class QueryLog
{
    public $sql, $params, $time, $trace, $message;

    public function __construct($sql, $params = [])
    {
        $this->sql = $sql;
        $this->params = $params;
        $this->time = microtime(true);
        $this->trace = \ryunosuke\WebDebugger\backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, [
            'file' => function ($file) {
                return strpos($file, 'WebDebugger') === false;
            },
        ]);
    }

    public function done()
    {
        $this->time = (microtime(true) - $this->time);
    }

    public function fail(\Exception $ex)
    {
        $this->time = null;
        $this->message = $ex->getMessage();
    }
}
