<?php
namespace ryunosuke\Test\WebDebugger\Module;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Module\Variable;

class VariableTest extends AbstractTestCase
{
    function test_getCount()
    {
        $module = new Variable();
        $module->initialize([
            'array' => [
                ['id' => 1, 'name' => 'nameA', 'group' => 'X'],
                ['id' => 2, 'name' => 'nameB', 'group' => 'Y'],
                ['id' => 3, 'name' => 'nameC', 'group' => 'X'],
            ],
        ]);
        $stored = $module->gather([]);
        $this->assertEquals(3, $module->getCount($stored));
    }

    function test_gather()
    {
        $module = new Variable();
        $module->initialize([
            'closure' => function () {
                return [1, 2, 3];
            },
            'hash'    => ['a' => 'A', 'b' => ['B']],
            'array'   => [
                ['id' => 1, 'name' => 'nameA', 'group' => 'X'],
                ['id' => 2, 'name' => 'nameB', 'group' => 'Y'],
                ['id' => 3, 'name' => 'nameC', 'group' => 'X'],
            ],
            'objects' => new \ArrayObject([
                new \ArrayObject(['id' => 1, 'name' => 'nameA', 'group' => 'X']),
                new \ArrayObject(['id' => 2, 'name' => 'nameB', 'group' => 'Y']),
                new \ArrayObject(['id' => 3, 'name' => 'nameC', 'group' => 'Z']),
            ]),
            'list'    => ['a', 'b'],
            'string'  => 'this is string',
        ]);
        $stored = $module->gather([]);
        $this->assertEquals([
            "closure" => [1, 2, 3],
            "hash"    => ["a" => "A", "b" => ["B"],],
            "array"   => [
                ["id" => 1, "name" => "nameA", "group" => "X"],
                ["id" => 2, "name" => "nameB", "group" => "Y"],
                ["id" => 3, "name" => "nameC", "group" => "X"],
            ],
            'objects' => new \ArrayObject([
                new \ArrayObject(['id' => 1, 'name' => 'nameA', 'group' => 'X']),
                new \ArrayObject(['id' => 2, 'name' => 'nameB', 'group' => 'Y']),
                new \ArrayObject(['id' => 3, 'name' => 'nameC', 'group' => 'Z']),
            ]),
            "list"    => ["a", "b"],
            "string"  => "this is string",
        ], $stored);
    }

    function test_render()
    {
        $module = new Variable();
        $module->initialize([
            'hash'    => ['a' => 'A', 'b' => ['B']],
            'array'   => [
                ['id' => 1, 'name' => 'nameA', 'group' => 'X'],
                ['id' => 2, 'name' => 'nameB', 'group' => 'Y'],
                ['id' => 3, 'name' => 'nameC', 'group' => 'X'],
            ],
            'objects' => new \ArrayObject([
                new \ArrayObject(['id' => 1, 'name' => 'nameA', 'group' => 'X']),
                new \ArrayObject(['id' => 2, 'name' => 'nameB', 'group' => 'Y']),
                new \ArrayObject(['id' => 3, 'name' => 'nameC', 'group' => 'Z']),
            ]),
            'mixed' => [
                ['hoge_id' => 1, 'hoge_name' => 'nameA'],
                ['fuga_id' => 2, 'fuga_name' => 'nameB'],
            ],
            'empty'   => new \ArrayObject([]),
            'list'    => ['a', 'b'],
            "string"  => "this is string",
        ]);
        $htmls = $module->render($module->gather([]));
        $this->assertStringContainsString('<caption>hash', $htmls);
        $this->assertStringContainsString('<caption>array', $htmls);
        $this->assertStringContainsString('<caption>objects', $htmls);
        $this->assertStringContainsString('id</th>', $htmls);
        $this->assertStringContainsString('name</th>', $htmls);
        $this->assertStringContainsString('group</th>', $htmls);
        $this->assertStringContainsString('ArrayObject#', $htmls);
        $this->assertStringContainsString('hoge_id</span>', $htmls);
        $this->assertStringContainsString('fuga_name</span>', $htmls);
        $this->assertStringContainsString('array(2)</a>', $htmls);
        $this->assertStringContainsString('this is string', $htmls);
    }

    function test_console()
    {
        $module = new Variable();
        $module->initialize([
            'hash'    => ['a' => 'A', 'b' => ['B']],
            'array'   => [
                ['id' => 1, 'name' => 'nameA', 'group' => 'X'],
                ['id' => 2, 'name' => 'nameB', 'group' => 'Y'],
                ['id' => 3, 'name' => 'nameC', 'group' => 'X'],
            ],
            'objects' => new \ArrayObject([
                new \ArrayObject(['id' => 1, 'name' => 'nameA', 'group' => 'X']),
                new \ArrayObject(['id' => 2, 'name' => 'nameB', 'group' => 'Y']),
                new \ArrayObject(['id' => 3, 'name' => 'nameC', 'group' => 'Z']),
            ]),
            'empty'   => new \ArrayObject([]),
            'list'    => ['a', 'b'],
            "string"  => "this is string",
        ]);
        $consoles = $module->console($module->gather([]));
        $this->assertArrayHasKey('hashtable', $consoles['hash']);
        $this->assertArrayHasKey('table', $consoles['array']);
        $this->assertArrayHasKey('table', $consoles['objects']);
        $this->assertArrayHasKey('hashtable', $consoles['']);
        $this->assertArrayHasKey('empty', $consoles['']['hashtable']);
        $this->assertArrayHasKey('list', $consoles['']['hashtable']);
        $this->assertArrayHasKey('string', $consoles['']['hashtable']);
    }
}
