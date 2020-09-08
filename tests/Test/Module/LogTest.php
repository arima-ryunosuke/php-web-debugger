<?php
namespace ryunosuke\Test\WebDebugger\Module;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Module\Log;

class LogTest extends AbstractTestCase
{
    function test_initialize()
    {
        $module = new Log();

        $this->assertFalse(function_exists('hogehoge'));
        $this->assertException(new \DomainException(), function () use ($module) { $module->log(0); });

        $module->initialize([
            'function' => 'hogehoge',
        ]);

        $this->assertTrue(function_exists('hogehoge'));
        /** @noinspection PhpUndefinedFunctionInspection */
        hogehoge(1);
        $module->log(2); // not thrown

        $module->finalize();
        $this->assertException(new \DomainException(), function () use ($module) { $module->log(null); });
    }

    function test_gather()
    {
        $module = new Log();
        $module->initialize();
        $module->setting([]);

        $module->log('xxx'); // 行数が変わるとテストがコケる

        $stored = $module->gather();
        $this->assertArrayHasKey('Log', $stored);
        $actual = $stored['Log'][0];
        $this->assertArrayHasKey('trace', $actual);
        unset($actual['trace']);
        $this->assertEquals([
            'file' => __FILE__,
            'line' => 35,
            'name' => "",
            'log'  => "xxx",
            'time' => '2000/12/24 12:34:56',
        ], $actual);
    }

    function test_getErrors()
    {
        $module = new Log();
        $module->initialize();
        $module->setting([]);

        $this->assertEquals('', $module->getError($module->gather()));

        $module->log('hoge');
        $this->assertEquals('has log', $module->getError($module->gather()));
    }

    function test_preserve()
    {
        $module = new Log();
        $module->initialize();
        $module->setting([]);
        $module->log('xxx');

        $module = new Log();
        $module->initialize();
        $module->setting(['preserve' => 1]);
        $module->log('xxx');

        $stores = $module->gather();
        $this->assertCount(2, $stores['Log']);
    }

    function test_render()
    {
        $module = new Log();
        $module->initialize();
        $module->setting([]);

        $module->log('xxx');

        $htmls = $module->render($module->gather());
        $this->assertContains('<caption>Log', $htmls);
    }

    function test_console()
    {
        $module = new Log();
        $module->initialize();
        $module->setting([]);

        $module->log('xxx');

        $consoled = $module->console($module->gather());
        $this->assertArrayHasKey('table', $consoled['Log']);
    }
}