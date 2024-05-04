<?php
namespace ryunosuke\Test\WebDebugger\Module;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Module\History;

class HistoryTest extends AbstractTestCase
{
    function test_gather()
    {
        $history = sys_get_temp_dir() . '/hoge/log.txt';
        $module = new History();
        $module->initialize(['historyfile' => $history, 'maxlength' => 3]);
        $module->setting([]);

        @unlink($history);

        $request = [
            'method'   => 'GET',
            'url'      => 'url',
            'workpath' => __FILE__,
        ];

        $module->gather(['time' => 1] + $request);
        $module->gather(['time' => 2] + $request);
        $module->gather(['time' => 3] + $request);
        $module->gather(['time' => 4] + $request);
        $module->gather(['time' => 5] + $request);
        $stored = $module->gather(['time' => 6] + $request);

        $this->assertArrayHasKey('History', $stored);
        $this->assertCount(3, $stored['History']);

        $actual = $stored['History'][0];
        $this->assertArrayHasKey('url', $actual);
        $this->assertEquals([
            'time'   => 4,
            'method' => 'GET',
            'url'    => 'url',
            'file'   => __FILE__,
        ], $actual);

        $actual = $stored['History'][2];
        $this->assertArrayHasKey('url', $actual);
        $this->assertEquals([
            'time'   => 6,
            'method' => 'GET',
            'url'    => 'url',
            'file'   => __FILE__,
        ], $actual);
    }

    function test_getCount()
    {
        $history = sys_get_temp_dir() . '/hoge/log.txt';
        $module = new History();
        $module->initialize(['historyfile' => $history]);
        $module->setting([]);

        @unlink($history);

        $request = [
            'time'     => 1234567890,
            'method'   => 'GET',
            'url'      => 'url',
            'workpath' => __FILE__,
        ];

        $this->assertEquals(1, $module->getCount($module->gather($request)));

        $module->gather($request);
        $module->gather($request);
        $module->gather($request);

        $this->assertEquals(5, $module->getCount($module->gather($request)));
    }

    function test_getHtml()
    {
        $history = sys_get_temp_dir() . '/hoge/log.txt';
        $module = new History();
        $module->initialize(['historyfile' => $history]);
        $module->setting([]);

        $htmls = $module->getHtml($module->gather([
            'time'     => 1234567890,
            'method'   => 'GET',
            'url'      => 'url',
            'workpath' => __FILE__,
        ]));
        $this->assertStringContainsString('<caption>history', $htmls);
    }
}
