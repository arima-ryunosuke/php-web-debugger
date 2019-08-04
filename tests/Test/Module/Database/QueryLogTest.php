<?php
namespace ryunosuke\Test\WebDebugger\Module\Database;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Module\Database\QueryLog;

class QueryLogTest extends AbstractTestCase
{
    function test_all()
    {
        $log = new QueryLog('hoge', [1, 2, 3]);
        $this->assertEquals('hoge', $log->sql);
        $this->assertEquals([1, 2, 3], $log->params);

        $log->done();
        $this->assertNotNull($log->time);
        $this->assertEquals('', $log->message);

        $log->fail(new \Exception('error'));
        $this->assertNull($log->time);
        $this->assertEquals('error', $log->message);
    }
}
