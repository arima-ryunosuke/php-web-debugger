<?php

require_once __DIR__ . '/../vendor/autoload.php';

// for intellisense
if (false) {
    function dlog($value, $name = '') { }
}
if (false) {
    function dtime($name = '') { }
}

$that = new \stdClass();
$that->headers = [];

\ryunosuke\WebDebugger\GlobalFunction::override('time', function () {
    return strtotime('2000/12/24 12:34:56');
});
\ryunosuke\WebDebugger\GlobalFunction::override('header', function ($header) use ($that) {
    $that->headers[] = $header;
});
\ryunosuke\WebDebugger\GlobalFunction::override('headers_list', function () use ($that) {
    return $that->headers;
});
\ryunosuke\WebDebugger\GlobalFunction::override('header_remove', function ($header = null) use ($that) {
    if ($header === null) {
        $that->headers = [];
    }
    else {
        $excepts = preg_grep('#^' . preg_quote($header, '#') . '#u', $that->headers);
        $that->headers = array_diff($that->headers, $excepts);
    }
});
\ryunosuke\WebDebugger\GlobalFunction::override('response', function ($content = '') {
    return $content;
});
