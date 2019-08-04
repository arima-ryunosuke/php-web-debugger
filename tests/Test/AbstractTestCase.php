<?php
namespace ryunosuke\Test\WebDebugger;

abstract class AbstractTestCase extends \PHPUnit\Framework\TestCase
{
    protected function getPdoConnection()
    {
        $host = defined('PDO_HOST') ? constant('PDO_HOST') : $this->markTestIncomplete();
        $port = defined('PDO_PORT') ? constant('PDO_PORT') : $this->markTestIncomplete();
        $username = defined('PDO_USERNAME') ? constant('PDO_USERNAME') : $this->markTestIncomplete();
        $password = defined('PDO_PASSWORD') ? constant('PDO_PASSWORD') : $this->markTestIncomplete();
        return new \PDO("mysql:host=$host;port=$port", $username, $password);
    }

    public static function assertException(\Exception $e, callable $callback)
    {
        try {
            call_user_func_array($callback, array_slice(func_get_args(), 2));
        }
        catch (\Throwable $ex) {
            self::assertInstanceOf(get_class($e), $ex);
            self::assertEquals($e->getCode(), $ex->getCode());
            if (strlen($e->getMessage()) > 0) {
                self::assertContains($e->getMessage(), $ex->getMessage());
            }
            return;
        }
        self::fail(get_class($e) . ' is not thrown.');
    }
}
