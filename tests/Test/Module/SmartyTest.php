<?php
namespace ryunosuke\Test\WebDebugger\Module;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Module\Smarty;

class SmartyTest extends AbstractTestCase
{
    /** @var \Smarty */
    private $smarty;

    function setUp()
    {
        parent::setUp();

        $this->smarty = new \Smarty();
        $this->smarty->force_compile = true;
    }

    function test_initialize()
    {
        $module = new Smarty();
        $module->initialize(['smarty' => $this->smarty]);
        $this->assertTrue($this->smarty->debugging);

        $this->assertException(new \InvalidArgumentException('"smarty" is not Smarty.'), function () use ($module) {
            $module->initialize();
        });
    }

    function test_finalize()
    {
        $this->smarty->debugging = false;
        $module = new Smarty();
        $module->initialize(['smarty' => $this->smarty]);
        $this->assertTrue($this->smarty->debugging);

        $module->finalize();
        $this->assertFalse($this->smarty->debugging);
    }

    function test_gather()
    {
        $module = new Smarty();
        $module->initialize(['smarty' => $this->smarty]);
        $this->smarty->assign('hoge', 'HOGE');
        $this->smarty->fetch('eval:{$hoge}');
        $stored = $module->gather();
        $this->assertArrayHasKey('Templates', $stored);
        $this->assertArrayHasKey('Variables', $stored);

        $this->assertEquals('HOGE', $stored['Variables']['hoge']);
        $this->assertNotEmpty($stored['Variables']);
    }

    function test_gather_nodebug()
    {
        $this->smarty->debugging = false;
        $module = new Smarty();
        $module->initialize(['smarty' => $this->smarty, 'auto_debugging' => false]);
        $stored = $module->gather();

        $this->assertEmpty($stored['Templates']);
    }

    function test_render()
    {
        $module = new Smarty();
        $module->initialize(['smarty' => $this->smarty]);
        $this->smarty->assign('hoge', 'HOGE');
        $this->smarty->fetch('eval:{$hoge}');
        $htmls = $module->render($module->gather());
        $this->assertContains('<caption>Templates', $htmls);
        $this->assertContains('<caption>Variables', $htmls);
    }
}
