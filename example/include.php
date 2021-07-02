<?php

require __DIR__ . '/../vendor/autoload.php';

// example 実行用に Connection を用意
$connection = \Doctrine\DBAL\DriverManager::getConnection([
    'url' => 'mysql://root:@localhost/information_schema',
]);

// デバッガを初期化・登録
$debugger = new \ryunosuke\WebDebugger\Debugger([
    // オプションはソースを参照
]);

$debugger->initialize([
    // モジュールオプションはソースを参照
    \ryunosuke\WebDebugger\Module\Ajax::class        => [],
    \ryunosuke\WebDebugger\Module\Error::class       => [],
    \ryunosuke\WebDebugger\Module\Server::class      => [],
    \ryunosuke\WebDebugger\Module\Database::class    => \ryunosuke\WebDebugger\Module\Database::doctrineAdapter($connection),
    \ryunosuke\WebDebugger\Module\Performance::class => [],
    \ryunosuke\WebDebugger\Module\Log::class         => [],
    \ryunosuke\WebDebugger\Module\Variable::class    => ['server' => function () { return $_SERVER; }],
    \ryunosuke\WebDebugger\Module\History::class     => [],
])->start();
