<?php

use Monolog\Logger;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

require __DIR__ . '/../vendor/autoload.php';

// example 実行用に Connection を用意
$connection = \Doctrine\DBAL\DriverManager::getConnection([
    'url' => 'mysqli://root:password@127.0.0.1/information_schema',
]);

$monolog = new Logger('app');
$psr3log = new class() extends AbstractLogger implements LoggerAwareInterface {
    private LoggerInterface $internalLogger;


    public function log($level, $message, array $context = [])
    {
        $this->internalLogger->log($level, $message, $context);
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->internalLogger = $logger;
    }
};
$psr3log->setLogger(new class() extends AbstractLogger {
    public function log($level, $message, array $context = [])
    {
        // noop
    }
});

// デバッガを初期化・登録
$debugger = new \ryunosuke\WebDebugger\Debugger([
    // オプションはソースを参照
]);

$debugger->initialize([
    // モジュールオプションはソースを参照
    \ryunosuke\WebDebugger\Module\Ajax::class        => [],
    \ryunosuke\WebDebugger\Module\Error::class       => [],
    \ryunosuke\WebDebugger\Module\Server::class      => [],
    \ryunosuke\WebDebugger\Module\Doctrine::class    => ['connection' => $connection],
    \ryunosuke\WebDebugger\Module\Performance::class => [],
    \ryunosuke\WebDebugger\Module\Log::class         => ['logger' => [$monolog, $psr3log]],
    \ryunosuke\WebDebugger\Module\Directory::class   => [sys_get_temp_dir() => []],
    \ryunosuke\WebDebugger\Module\Variable::class    => ['server' => function () { return $_SERVER; }],
    \ryunosuke\WebDebugger\Module\History::class     => [],
])->start();
