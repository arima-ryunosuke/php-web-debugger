<?php
namespace ryunosuke\Test\WebDebugger\Module;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Module\Ajax;

class AjaxTest extends AbstractTestCase
{
    function test_prepareOuter()
    {
        $module = new Ajax();
        $this->assertStringContainsString('fetch', $module->prepareOuter());
    }

    function test_gather()
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $_SERVER['REQUEST_URI'] = '/';
        $module = new Ajax();
        $module->initialize();
        $stored = $module->gather([]);
        $this->assertArrayHasKey('datetime', $stored);
        $this->assertArrayHasKey('method', $stored);
        $this->assertArrayHasKey('url', $stored);
        $this->assertArrayHasKey('GET', $stored);
        $this->assertArrayHasKey('POST', $stored);
        $this->assertArrayHasKey('COOKIE', $stored);
    }

    function test_getCount()
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $_SERVER['REQUEST_URI'] = '/';
        $module = new Ajax();

        $stored = $module->gather([]);
        $this->assertEquals(0, $module->getCount($stored));
    }

    function test_getHtml()
    {
        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $_SERVER['REQUEST_URI'] = '/';
        $module = new Ajax();
        $htmls = $module->getHtml($module->gather([]));
        $this->assertStringContainsString('<caption>AjaxRequest', $htmls);
    }
}
