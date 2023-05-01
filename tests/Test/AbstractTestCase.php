<?php
namespace ryunosuke\Test\WebDebugger;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;

abstract class AbstractTestCase extends \PHPUnit\Framework\TestCase
{
    protected function getConnection()
    {
        $dsn = defined('DOCTRINE_DSN') ? constant('DOCTRINE_DSN') : $this->markTestIncomplete();
        $parser = new DsnParser();
        static $connections = [];
        return $connections[$dsn] ??= DriverManager::getConnection($parser->parse($dsn));
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
                self::assertStringContainsString($e->getMessage(), $ex->getMessage());
            }
            return;
        }
        self::fail(get_class($e) . ' is not thrown.');
    }
}
