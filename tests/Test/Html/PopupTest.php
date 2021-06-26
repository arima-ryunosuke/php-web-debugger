<?php
namespace ryunosuke\Test\WebDebugger\Html;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Html\Popup;

class PopupTest extends AbstractTestCase
{
    function test___toString()
    {
        $popup = (string) new Popup('foobar', '<b>bold</b>');

        $this->assertStringContainsString('<a href="javascript:void(0)" class="popup">foobar</a>', $popup);
        $this->assertStringContainsString('<div class="extends popupdiv"><b>bold</b></div>', $popup);
    }
}
