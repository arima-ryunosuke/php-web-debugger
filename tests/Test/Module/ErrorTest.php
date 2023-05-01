<?php
namespace ryunosuke\Test\WebDebugger\Module;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Module\Error;

class ErrorTest extends AbstractTestCase
{
    function test_initialize()
    {
        $noop = static function () { };
        set_error_handler($noop);
        $module = new Error();
        $module->initialize([
            'no_default'       => true,
            'exception_getter' => function () { return new \Exception('test'); },
        ]);
        $this->assertNotSame($noop, set_error_handler(function () { }));
        $module->finalize();
    }

    function test_finalize()
    {
        $error_handler = set_error_handler(function () { });
        $ex_handler = set_exception_handler(function () { });
        restore_error_handler();
        restore_exception_handler();

        $module = new Error();
        $module->initialize();
        $module->finalize();

        $this->assertEquals($error_handler, set_error_handler(function () { }));
        $this->assertEquals($ex_handler, set_exception_handler(function () { }));
        restore_error_handler();
        restore_exception_handler();
    }

    function test_gather()
    {
        set_error_handler(function () { });
        $module = new Error();
        $module->initialize([
            'exception_getter' => function () { return new \Exception('test'); },
        ]);
        $a = [];
        $a['t'] = $a['undefined'];
        $a['t'] = @$a['undefined'];
        $stored = $module->gather([]);
        $module->finalize();
        restore_error_handler();

        $this->assertArrayHasKey('Error', $stored);
        $this->assertArrayHasKey('summary', $stored['Error']);
        $this->assertArrayHasKey('data', $stored['Error']);
        $this->assertArrayHasKey('Exception', $stored);
        $this->assertArrayHasKey('summary', $stored['Exception']);
        $this->assertArrayHasKey('data', $stored['Exception']);

        $this->assertEquals(' (1 errors)', $stored['Error']['summary']);
        $this->assertEquals(' (Exception): test', $stored['Exception']['summary']);

        return $stored;
    }

    /**
     * @depends test_gather
     * @param $stored
     */
    function test_gather_getCount($stored)
    {
        $module = new Error();
        $count = $module->getCount($stored);
        $this->assertEquals(2, $count);
    }

    /**
     * @depends test_gather
     * @param $stored
     */
    function test_gather_getError($stored)
    {
        $module = new Error();
        $error = $module->getError($stored);
        $this->assertStringContainsString('has 1 error', $error);
        $this->assertStringContainsString('has exception', $error);
    }

    /**
     * @depends test_gather
     * @param $stored
     */
    function test_gather_render($stored)
    {
        $module = new Error();
        $htmls = $module->render($stored);
        $this->assertStringContainsString('<caption><pre>Error', $htmls);
        $this->assertStringContainsString('<caption><pre>Exception', $htmls);
    }
}
