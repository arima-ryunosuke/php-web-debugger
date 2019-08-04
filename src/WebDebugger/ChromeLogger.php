<?php
namespace ryunosuke\WebDebugger;

/**
 * @method static void log($value)
 * @method static void info($value)
 * @method static void warn($value)
 * @method static void error($value)
 * @method static void table($data)
 * @method static void hashtable($data)
 * @method static void group($title)
 * @method static void groupCollapsed($title)
 * @method static void groupEnd()
 * @method static void clear()
 * @method static void send()
 */
class ChromeLogger
{
    /** @var self */
    private static $instance;

    /** @var array ChromeLogger response. see https://craig.is/writing/chrome-logger/techspecs */
    private $data = [
        'version' => '1.0.0',
        'columns' => ['log', 'backtrace', 'type'],
        'rows'    => []
    ];

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function __callStatic($name, $args)
    {
        return call_user_func_array([self::getInstance(), $name], $args);
    }

    public function __call($name, $args)
    {
        $method = '_' . trim($name, '_');
        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $args);
        }

        throw new \BadMethodCallException("'$name' is not defined.");
    }

    protected function _log($value)
    {
        return $this->stack(__FUNCTION__, func_get_args());
    }

    protected function _info($value)
    {
        return $this->stack(__FUNCTION__, func_get_args());
    }

    protected function _warn($value)
    {
        return $this->stack(__FUNCTION__, func_get_args());
    }

    protected function _error($value)
    {
        return $this->stack(__FUNCTION__, func_get_args());
    }

    protected function _table($data)
    {
        if (!$data) {
            return $this->log("(empty)");
        }

        return $this->stack(__FUNCTION__, func_get_args());
    }

    protected function _hashtable($data)
    {
        return $this->table(array_map(function ($v) {
            if (is_array($v)) {
                $v = var_export($v, true);
            }
            return ['(value)' => $v];
        }, $data));
    }

    protected function _group($title)
    {
        return $this->stack(__FUNCTION__, func_get_args());
    }

    protected function _groupCollapsed($title)
    {
        return $this->stack(__FUNCTION__, func_get_args());
    }

    protected function _groupEnd()
    {
        return $this->stack(__FUNCTION__, [null]);
    }

    protected function _clear()
    {
        $current = $this->data['rows'];
        $this->data['rows'] = [];
        return $current;
    }

    protected function _send()
    {
        if ($this->data['rows']) {
            GlobalFunction::header('X-ChromeLogger-Data: ' . base64_encode(utf8_encode(json_encode($this->data))));
        }
    }

    private function stack($type, $values)
    {
        foreach ($values as $value) {
            $this->data['rows'][] = [
                [$value],
                null,
                trim($type, '_')
            ];
        }
    }
}
