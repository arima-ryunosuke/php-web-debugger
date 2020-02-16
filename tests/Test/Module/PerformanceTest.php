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
        $module->setting(['profile' => true]);
        require __DIR__ . '/Performance/profiler.php';

        $module->time('a');
        usleep(10000);
        $module->time('b');

        $stored = $module->gather();
        $this->assertArrayHasKey('Performance', $stored);
        $this->assertArrayHasKey('Timeline', $stored);
        $this->assertArrayHasKey('Profile', $stored);
        $this->assertEquals("a ～ b", $stored['Timeline'][0]['name']);
        $this->assertCount(3, $stored['Profile'][0]['caller']);
        $this->assertCount(2, $stored['Profile'][1]['caller']);
        $this->assertCount(1, $stored['Profile'][2]['caller']);
    }

    function test_render()
    {
        $module = new Performance();
        $module->initialize();
        $module->setting(['profile' => true]);
        $module->time('a');
        $module->time('b');
        require __DIR__ . '/Performance/profiler.php';

        $htmls = $module->render($module->gather());
        $this->assertContains('<caption>Performance', $htmls);
        $this->assertContains('<caption>Timeline', $htmls);
        $this->assertContains('<caption>Profile', $htmls);
    }

    function test_console()
    {
        $module = new Performance();
        $module->initialize();
        $module->setting(['profile' => true]);
        require __DIR__ . '/Performance/profiler.php';

        $consoled = $module->console($module->gather());
        $this->assertArrayHasKey('hashtable', $consoled['Performance']);
        $this->assertArrayHasKey('table', $consoled['Timeline']);
        $this->assertArrayHasKey('table', $consoled['Profile']);
    }
}
