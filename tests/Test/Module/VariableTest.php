<?php
namespace ryunosuke\Test\WebDebugger\Module;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Module\Variable;

class VariableTest extends AbstractTestCase
{
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
        $stored = $module->gather();
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
            'empty'   => new \ArrayObject([]),
            'list'    => ['a', 'b'],
            "string"  => "this is string",
        ]);
        $htmls = $module->render($module->gather());
        $this->assertContains('<caption>hash', $htmls);
        $this->assertContains('<caption>array', $htmls);
        $this->assertContains('<caption>objects', $htmls);
        $this->assertContains('id</th>', $htmls);
        $this->assertContains('name</th>', $htmls);
        $this->assertContains('group</th>', $htmls);
        $this->assertContains('object:ArrayObject</a>', $htmls);
        $this->assertContains('array(2)</a>', $htmls);
        $this->assertContains('this is string', $htmls);
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
        $consoles = $module->console($module->gather());
        $this->assertArrayHasKey('hashtable', $consoles['hash']);
        $this->assertArrayHasKey('table', $consoles['array']);
        $this->assertArrayHasKey('table', $consoles['objects']);
        $this->assertArrayHasKey('hashtable', $consoles['']);
        $this->assertArrayHasKey('empty', $consoles['']['hashtable']);
        $this->assertArrayHasKey('list', $consoles['']['hashtable']);
        $this->assertArrayHasKey('string', $consoles['']['hashtable']);
    }
}
