<?php
namespace ryunosuke\Test\WebDebugger\Module;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Module\Performance;

class PerformanceTest extends AbstractTestCase
{
    function test_initialize()
    {
        $module = new Performance();
        $module->finalize();

        $this->assertFalse(function_exists('dddtime'));
        $this->assertException(new \DomainException(), function () use ($module) { $module->time(); });

        $module->initialize([
            'function' => 'dddtime',
        ]);

        $this->assertTrue(function_exists('dddtime'));
        /** @noinspection PhpUndefinedFunctionInspection */
        dddtime(1);
        $module->time(); // not thrown

        $module->finalize();
        $this->assertException(new \DomainException(), function () use ($module) { $module->time(); });
    }

    function test_gather()
    {
        $module = new Performance();
        $module->initialize();

        $module->time('a');
        usleep(10000);
        $module->time('b');

        $stored = $module->gather();
        $this->assertArrayHasKey('Performance', $stored);
        $this->assertArrayHasKey('Timeline', $stored);
        $this->assertEquals("a ～ b", $stored['Timeline'][0]['name']);
    }

    function test_render()
    {
        $module = new Performance();
        $module->initialize();
        $module->time('a');
        $module->time('b');

        $htmls = $module->render($module->gather());
        $this->assertContains('<caption>Performance', $htmls);
        $this->assertContains('<caption>Timeline', $htmls);
    }

    function test_console()
    {
        $module = new Performance();
        $module->initialize();
        $consoled = $module->console($module->gather());
        $this->assertArrayHasKey('hashtable', $consoled['Performance']);
    }
}
