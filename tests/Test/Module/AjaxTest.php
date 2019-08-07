<?php
namespace ryunosuke\Test\WebDebugger\Module;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Module\Ajax;

class AjaxTest extends AbstractTestCase
{
    function test_prepareOuter()
    {
        $module = new Ajax();
        $this->assertContains('fetch', $module->prepareOuter());
    }

    function test_gather()
    {
        $_SERVER['REQUEST_URI'] = '/';
        $module = new Ajax();
        $module->initialize();
        $stored = $module->gather();
        $this->assertArrayHasKey('datetime', $stored);
        $this->assertArrayHasKey('url', $stored);
        $this->assertArrayHasKey('GET', $stored);
        $this->assertArrayHasKey('POST', $stored);
        $this->assertArrayHasKey('COOKIE', $stored);
    }

    function test_render()
    {
        $_SERVER['REQUEST_URI'] = '/';
        $module = new Ajax();
        $htmls = $module->render($module->gather());
        $this->assertContains('<caption>AjaxRequest', $htmls);
    }
}
