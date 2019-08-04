<?php
namespace ryunosuke\Test\WebDebugger;

use ryunosuke\WebDebugger\ChromeLogger;
use ryunosuke\WebDebugger\GlobalFunction;

class ChromeLoggerTest extends AbstractTestCase
{
    function tearDown()
    {
        parent::tearDown();

        GlobalFunction::header_remove();
    }

    function test___call()
    {
        $this->expectException(get_class(new \BadMethodCallException()));
        $logger = new ChromeLogger();
        /** @noinspection PhpUndefinedMethodInspection */
        $logger->hoge('log');
    }

    function test___callStatic()
    {
        ChromeLogger::info('test');
        ChromeLogger::send();
        $this->assertContains('X-ChromeLogger-Data', implode("\n", GlobalFunction::headers_list()));
    }

    function test_stack()
    {
        $logger = new ChromeLogger();
        $logger->log('log');
        $logger->info('info');
        $logger->warn('warn');
        $logger->error('error');
        $logger->table([[1]]);
        $logger->table([]);
        $logger->hashtable(['k' => 'v']);
        $logger->hashtable([[1]]);
        $logger->group('group');
        $logger->groupCollapsed('groupCollapsed');
        $logger->groupEnd();

        $logger->send();
        $this->assertContains('X-ChromeLogger-Data', implode("\n", GlobalFunction::headers_list()));

        $this->assertEquals([
            [
                ['log'],
                null,
                'log',
            ],
            [
                ['info'],
                null,
                'info',
            ],
            [
                ['warn'],
                null,
                'warn',
            ],
            [
                ['error'],
                null,
                'error',
            ],
            [
                [[[1]]],
                null,
                'table',
            ],
            [
                ['(empty)'],
                null,
                'log',
            ],
            [
                [['k' => ['(value)' => 'v']]],
                null,
                'table',
            ],
            [
                [[['(value)' => "array (\n  0 => 1,\n)"]]],
                null,
                'table',
            ],
            [
                ['group'],
                null,
                'group',
            ],
            [
                ['groupCollapsed'],
                null,
                'groupCollapsed',
            ],
            [
                [null],
                null,
                'groupEnd',
            ],
        ], $logger->clear());

        $this->assertEquals([], $logger->clear());
    }
}
