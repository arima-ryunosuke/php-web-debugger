<?php

require __DIR__ . '/../vendor/autoload.php';

// example 実行用に PDO を用意
$pdo = new \ryunosuke\WebDebugger\Module\Database\LoggablePDO(new \PDO('mysql:dbname=information_schema', 'root', ''));
$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

// デバッガを初期化・登録
$debugger = new \ryunosuke\WebDebugger\Debugger([
    // オプションはソースを参照
]);

$debugger->initialize([
    // モジュールオプションはソースを参照
    \ryunosuke\WebDebugger\Module\Ajax::class        => [],
    \ryunosuke\WebDebugger\Module\Error::class       => [],
    \ryunosuke\WebDebugger\Module\Server::class      => [],
    \ryunosuke\WebDebugger\Module\Database::class    => ['pdo' => $pdo],
    \ryunosuke\WebDebugger\Module\Performance::class => [],
    \ryunosuke\WebDebugger\Module\Log::class         => [],
    \ryunosuke\WebDebugger\Module\Variable::class    => ['server' => function () { return $_SERVER; }],
    \ryunosuke\WebDebugger\Module\History::class     => [],
])->start();
