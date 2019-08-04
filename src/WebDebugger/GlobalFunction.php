<?php
namespace ryunosuke\WebDebugger;

/**
 * @codeCoverageIgnore
 * @method static int time()
 * @method static void header($header)
 * @method static void header_remove($header = null)
 * @method static array headers_list()
 * @method static bool headers_sent()
 */
class GlobalFunction
{
    private static $overriddens = [];

    /**
     * @internal
     * @param $name
     * @param \Closure $callback
     */
    public static function override($name, $callback)
    {
        self::$overriddens[$name] = $callback;
    }

    public static function __callStatic($name, $arguments)
    {
        if (isset(self::$overriddens[$name])) {
            $name = self::$overriddens[$name];
        }
        return call_user_func_array($name, $arguments);
    }

    /**
     * こんなグローバル関数は存在しないが、exit されるとテストが困難なので定義
     *
     * @param string $content
     * @return mixed
     */
    public static function response($content = '')
    {
        if (isset(self::$overriddens[__FUNCTION__])) {
            return call_user_func_array(self::$overriddens[__FUNCTION__], func_get_args());
        }
        echo $content;
        exit;
    }
}
