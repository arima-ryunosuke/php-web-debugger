<?php
namespace ryunosuke\Test\WebDebugger\Html;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Html\Raw;

class RawTest extends AbstractTestCase
{
    function test___toString()
    {
        $raw = (string) new Raw('<b>bold</b>');

        // エスケープされない
        $this->assertEquals('<b>bold</b>', $raw);
    }
}
