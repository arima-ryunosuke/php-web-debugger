<?php
namespace ryunosuke\Test\WebDebugger\Module;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Module\AbstractModule;
use ryunosuke\WebDebugger\Module\Performance;

function namespace_func() { }

class AbstractModuleTest extends AbstractTestCase
{
    /** @var AbstractModule */
    private $mock;

    function setUp(): void
    {
        parent::setUp();

        $this->mock = $this->getMockForAbstractClass('ryunosuke\\WebDebugger\\Module\\AbstractModule');
    }

    private function invoke($method, $var)
    {
        $method = new \ReflectionMethod($this->mock, $method);
        $method->setAccessible(true);

        return $method->invoke($this->mock, $var);
    }

    function test_getInstance()
    {
        $module = Performance::getInstance('RRR');
        $this->assertEquals('RRR', $module->getName());
    }

    function test_initialize()
    {
        $module = Performance::getInstance('RRR');
        $module->initialize(['function' => 'dummy_global_function']);
        $this->assertTrue(function_exists('dummy_global_function'));
        $module->finalize();
    }

    function test_disable()
    {
        $module = Performance::getInstance('RRR');
        $module->disable();

        $this->assertTrue($module->isDisabled());
        $this->assertIsObject($module->initialize());
        $this->assertIsObject($module->finalize());
        $this->assertEmpty($module->gather([]));
        $this->assertNull($module->hook([]));
        $this->assertNull($module->getCount([]));
        $this->assertNull($module->getError([]));
        $this->assertNull($module->render([]));
    }

    function test_toOpenable()
    {
        $this->assertEquals('scalr', $this->invoke('toOpenable', 'scalr'));
        $this->assertEquals(['simple', 'array'], $this->invoke('toOpenable', ['simple', 'array']));
        $this->assertEquals([
            ''     => "<a href='javascript:void(0)' data-href='filename:99' title='filename:99'>*</a>",
            'file' => 'filename',
            'line' => 99,
        ], $this->invoke('toOpenable', [
            'file' => 'filename',
            'line' => 99,
        ]));
    }
}
