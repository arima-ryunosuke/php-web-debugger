<?php
namespace ryunosuke\Test\WebDebugger\Html;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Html\ArrayTable;

class ArrayTableTest extends AbstractTestCase
{
    function test___toString()
    {
        $table = (string) new ArrayTable('foobar',
            [
                ['a' => 'A'],
                ['b' => 'B'],
                ['c' => 'C'],
                ['a' => 'A', 'b' => 'B', 'c' => 'C'],
            ],
            [
                0 => ['b' => 'color:red'], // 無視される
                1 => ['b' => 'color:red'],
                3 => ['b' => 'color:red'],
            ]
        );

        // caption は foobar
        $this->assertStringContainsString('<caption>foobar</caption>', $table);

        // ヘッダは和集合
        $this->assertStringContainsString('<th class="nowrap">a</th>', $table);
        $this->assertStringContainsString('<th class="nowrap">b</th>', $table);
        $this->assertStringContainsString('<th class="nowrap">c</th>', $table);

        // color:red は2個
        $this->assertEquals(2, substr_count($table, 'color:red'));
    }

    function test_collection()
    {
        $table = (string) new ArrayTable('foobar', new \ArrayObject([
                new \ArrayObject(['a' => 'A']),
                new \ArrayObject(['b' => 'B']),
                new \ArrayObject(['c' => 'C']),
                new \ArrayObject(['a' => 'A', 'b' => 'B', 'c' => 'C']),
            ])
        );

        // caption は foobar
        $this->assertStringContainsString('<caption>foobar</caption>', $table);

        // ヘッダは和集合
        $this->assertStringContainsString('<th class="nowrap">a</th>', $table);
        $this->assertStringContainsString('<th class="nowrap">b</th>', $table);
        $this->assertStringContainsString('<th class="nowrap">c</th>', $table);
    }
}
