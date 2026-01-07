<?php
namespace ryunosuke\Test\WebDebugger\Module;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Module\Link;
use ryunosuke\WebDebugger\Module\Log;

class LinkTest extends AbstractTestCase
{
    function test_initialize()
    {
        $module = new Link();

        $this->assertFalse(function_exists('fugafuga'));
        $this->assertException(new \DomainException(), function () use ($module) { $module->link(''); });

        $module->initialize([
            'function' => 'fugafuga',
        ]);

        $this->assertTrue(function_exists('fugafuga'));
        /** @noinspection PhpUndefinedFunctionInspection */
        fugafuga('');
        $module->link(''); // not thrown

        $module->finalize();
        $this->assertException(new \DomainException(), function () use ($module) { $module->link(null); });
    }

    function test_lifecycle()
    {
        $module = new Link();
        $module->initialize([
            'static' => [
                'link1' => 'http://example.com/static/1',
                'link2' => [
                    'name'        => 'custom name',
                    'href'        => 'http://example.com/static/2',
                    'description' => 'this is description',
                ],
                'link3' => fn() => 'http://example.com/static/3',
            ],
        ]);
        $module->setting([]);

        $module->link('http://example.com/dynamic/1');

        $stored = $module->gather([]);
        $this->assertEquals([
            "static"  => [
                [
                    "name"        => "link1",
                    "href"        => "http://example.com/static/1",
                    "description" => "",
                ],
                [
                    "name"        => "custom name",
                    "href"        => "http://example.com/static/2",
                    "description" => "this is description",
                ],
                [
                    "name"        => "link3",
                    "href"        => "http://example.com/static/3",
                    "description" => "",
                ],
            ],
            "dynamic" => [
                [
                    "name"        => "link-0",
                    "href"        => "http://example.com/dynamic/1",
                    "description" => "",
                ],
            ],
        ], $stored);

        $this->assertEquals(4, $module->getCount($stored));

        $htmls = $module->getHtml($module->gather([]));
        $this->assertStringContainsString("href='http://example.com/static/1'", $htmls);
        $this->assertStringContainsString("href='http://example.com/static/2'", $htmls);
        $this->assertStringContainsString("href='http://example.com/static/3'", $htmls);
        $this->assertStringContainsString("href='http://example.com/dynamic/1'", $htmls);

        $this->assertStringContainsString("<div class='prewrap scalar'>custom name</div>", $htmls);
        $this->assertStringContainsString("<div class='prewrap scalar'>this is description</div>", $htmls);
    }
}
