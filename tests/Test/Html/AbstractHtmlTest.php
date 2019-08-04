<?php
namespace ryunosuke\Test\WebDebugger\Html;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Html\AbstractHtml;
use ryunosuke\WebDebugger\Html\Raw;

class AbstractHtmlTest extends AbstractTestCase
{
    /** @var AbstractHtml */
    private $mock;

    function setUp()
    {
        parent::setUp();

        $this->mock = $this->getMockForAbstractClass('ryunosuke\\WebDebugger\\Html\\AbstractHtml');
    }

    private function export($var)
    {
        $export = new \ReflectionMethod($this->mock, 'export');
        $export->setAccessible(true);

        return $export->invoke($this->mock, $var);
    }

    function test_export_html()
    {
        $this->assertEquals('<b>bold</b>', $this->export(new Raw('<b>bold</b>')));
    }

    function test_export_null()
    {
        $this->assertEquals("<div class='prewrap simple'>null</div>", $this->export(null));
    }

    function test_export_scalar()
    {
        $this->assertEquals("<div class='prewrap scalar'>test</div>", $this->export('test'));
        $this->assertEquals("<div class='prewrap numeric'>123</div>", $this->export(123));
    }

    function test_export_empty()
    {
        $this->assertEquals("<div class='prewrap'>array(0)</div>", $this->export([]));
    }

    function test_export_array()
    {
        $export = (string) $this->export([1, 2, 3]);
        $this->assertContains('<a href="javascript:void(0)" class="holding">array(3)</a>', $export);
        $this->assertContains("[1, 2, 3]", $export);
    }

    function test_export_resource()
    {
        $export = (string) $this->export(STDIN);
        $this->assertContains('<a href="javascript:void(0)" class="holding">resource:stream</a>', $export);
        $this->assertContains("Resource id #1 of type (stream)", $export);
    }

    function test_export_object()
    {
        $export = (string) $this->export(new \stdClass());
        $this->assertContains('<a href="javascript:void(0)" class="holding">object:stdClass</a>', $export);
        $this->assertContains("stdClass#", $export);
    }

    function test_export_toolong()
    {
        $export = (string) $this->export(range(0, 2000));
        $this->assertContains("omitted too long", $export);
    }
}
