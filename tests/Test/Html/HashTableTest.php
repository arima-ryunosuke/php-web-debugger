<?php
namespace ryunosuke\Test\WebDebugger\Html;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Html\HashTable;

class HashTableTest extends AbstractTestCase
{
    function test___toString()
    {
        $table = (string) new HashTable('foobar',
            [
                'a' => 'A',
                'b' => 'B',
                'c' => 'C',
            ],
            [
                'x' => 'color:red', // 無視される
                'a' => 'color:red',
                'c' => 'color:red',
            ],
            ['hoge' => 'FUGA']
        );

        // caption は foobar
        $this->assertStringContainsString('<caption>foobar</caption>', $table);

        // ヘッダは指定されたもの
        $this->assertStringContainsString('<th>hoge</th>', $table);
        $this->assertStringContainsString('<th>FUGA</th>', $table);

        // color:red は4個(th, td の両方にあたる)
        $this->assertEquals(4, substr_count($table, 'color:red'));
    }
}
