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
$that->shutdowns = [];

\ryunosuke\WebDebugger\GlobalFunction::override('time', function () {
    return strtotime('2000/12/24 12:34:56');
});
\ryunosuke\WebDebugger\GlobalFunction::override('microtime', function ($getAsFloat = false) {
    if ($getAsFloat) {
        return (float) (strtotime('2000/12/24 12:34:56') . '.123');
    }
    return "0.123 " . strtotime('2000/12/24 12:34:56');
});
\ryunosuke\WebDebugger\GlobalFunction::override('date', function ($format, $timestamp = null) {
    return date($format, $timestamp ?? strtotime('2000/12/24 12:34:56'));
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
\ryunosuke\WebDebugger\GlobalFunction::override('register_shutdown_function', function ($callback, ...$mixed) use ($that) {
    $that->shutdowns[] = function () use ($callback, $mixed) { return $callback(...$mixed); };
});
\ryunosuke\WebDebugger\GlobalFunction::override('call_shutdown_function', function () use ($that) {
    return (array_pop($that->shutdowns))();
});
\ryunosuke\WebDebugger\GlobalFunction::override('response', function ($content = '') {
    if ($content === null) {
        return ob_get_clean();
    }
    return $content;
});
\ryunosuke\WebDebugger\GlobalFunction::override('opcache_get_status', function ($include_scripts = true) {
    return [
        'opcache_enabled' => true,
        'scripts'         => [
            'path/to/file1' => [
                'full_path'           => '/full/path/to/file1',
                'hits'                => 99,
                'memory_consumption'  => 12345,
                'last_used_timestamp' => strtotime('2001/03/23 12:34:56'),
                'timestamp'           => strtotime('2001/02/13 12:34:56'),
            ],
            'path/to/file2' => [
                'full_path'           => '/full/path/to/file2',
                'hits'                => 9,
                'memory_consumption'  => 1234,
                'last_used_timestamp' => strtotime('2011/03/23 12:34:56'),
                'timestamp'           => strtotime('2011/02/13 12:34:56'),
            ],
        ],
    ];
});
