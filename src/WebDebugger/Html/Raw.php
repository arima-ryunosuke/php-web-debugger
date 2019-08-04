<?php
namespace ryunosuke\WebDebugger\Html;

class Raw extends AbstractHtml
{
    public function __construct($string)
    {
        $this->string = is_string($string) ? $string : $this->export($string);
    }
}
