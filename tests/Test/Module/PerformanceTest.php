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

    function test_getCount()
    {
        $module = new Performance();
        $module->initialize();

        $module->time('a');
        $module->time('b');

        $stored = $module->gather([]);
        $this->assertEquals(1, $module->getCount($stored));
    }

    function test_getError()
    {
        $module = new Performance();
        $module->initialize();

        $module->time('a');
        $module->time('b');

        $stored = $module->gather([]);
        $this->assertEquals('has 1 timeline', $module->getError($stored));
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

        $stored = $module->gather([]);
        $this->assertArrayHasKey('Performance', $stored);
        $this->assertArrayHasKey('OPcache', $stored);
        $this->assertArrayHasKey('Timeline', $stored);
        $this->assertArrayHasKey('Profile', $stored);
        $this->assertTrue($stored['OPcache']['opcache_enabled']);
        $this->assertEquals(99, $stored['OPcache']['scripts']['path/to/file1']['hits']);
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

        $htmls = $module->render($module->gather([]));
        $this->assertStringContainsString('<caption>Performance', $htmls);
        $this->assertStringContainsString('<caption>OPcache', $htmls);
        $this->assertStringContainsString('<caption>Timeline', $htmls);
        $this->assertStringContainsString('<caption>Profile', $htmls);
    }
}
