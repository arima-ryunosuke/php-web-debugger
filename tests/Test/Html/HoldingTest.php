<?php
namespace ryunosuke\Test\WebDebugger\Html;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Html\Holding;

class HoldingTest extends AbstractTestCase
{
    function test___toString()
    {
        $holding = (string) new Holding('foobar', '<b>bold</b>');

        $this->assertContains('<a href="javascript:void(0)" class="holding">foobar</a>', $holding);
        $this->assertContains('<div class="extends holdingdiv"><b>bold</b></div>', $holding);
    }
}
