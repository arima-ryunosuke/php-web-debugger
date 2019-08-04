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
        $this->assertContains('<caption>foobar</caption>', $table);

        // ヘッダは和集合
        $this->assertContains('<th class="nowrap">a</th>', $table);
        $this->assertContains('<th class="nowrap">b</th>', $table);
        $this->assertContains('<th class="nowrap">c</th>', $table);

        // color:red は2個
        $this->assertEquals(2, substr_count($table, 'color:red'));
    }
}
