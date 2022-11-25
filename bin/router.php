<?php

function stdout($message)
{
    if (!is_string($message)) {
        $message = json_encode($message, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
    file_put_contents("php://stdout", "$message\n");
}

// load config
$config = (function () {
    $config_files = [
        $_SERVER['DOCUMENT_ROOT'] . '/config.php',
        __DIR__ . '/config.php',
    ];
    foreach ($config_files as $config_file) {
        if (is_readable($config_file)) {
            return require_once $config_file;
        }
    }
    stdout('no config file[config.php|config.dist.php]');
    exit;
})();

// parse request
[$exec, $file, $line] = (function () use ($config) {
    $exec = $config['exec_path'];
    $path = strstr($_SERVER['REQUEST_URI'] . '?', '?', true);
    [$file, $line] = explode(':', $path, 2);

    foreach ($config['path_map'] as $remote => $local) {
        $file = str_replace($remote, $local, $file);
    }
    return [sprintf($exec, escapeshellarg($file), escapeshellarg($line)), $file, $line];
})();

// exec command
[$rc, $output] = (function () use ($exec) {
    ob_start();
    passthru("$exec 2>&1", $rc);
    $output = trim(ob_get_clean());
    mb_convert_variables(mb_internal_encoding(), mb_detect_encoding($output, 'UTF-8,sjis-win'), $output);
    stdout("$exec => $rc:$output");
    return [$rc, $output];
})();

// send response
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE");
header("Access-Control-Max-Age: 3600");
header('Content-Type: application/json');
echo json_encode(compact('exec', 'file', 'line', 'rc', 'output'));
