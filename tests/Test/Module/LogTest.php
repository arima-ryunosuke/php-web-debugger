<?php
namespace ryunosuke\Test\WebDebugger\Module;

use Monolog\Logger;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Module\Log;

class LogTest extends AbstractTestCase
{
    function test_initialize()
    {
        $module = new Log();

        $this->assertFalse(function_exists('hogehoge'));
        $this->assertException(new \DomainException(), function () use ($module) { $module->log(0); });

        $module->initialize([
            'function' => 'hogehoge',
        ]);

        $this->assertTrue(function_exists('hogehoge'));
        /** @noinspection PhpUndefinedFunctionInspection */
        hogehoge(1);
        $module->log(2); // not thrown

        $module->finalize();
        $this->assertException(new \DomainException(), function () use ($module) { $module->log(null); });
    }

    function test_gather()
    {
        $module = new Log();
        $module->initialize();
        $module->setting([]);

        $module->log('xxx'); // 行数が変わるとテストがコケる

        $stored = $module->gather([]);
        $this->assertArrayHasKey('Log', $stored);
        $actual = $stored['Log'][0];
        $this->assertArrayHasKey('trace', $actual);
        unset($actual['trace']);
        $this->assertEquals([
            'file' => __FILE__,
            'line' => 39,
            'name' => "",
            'log'  => "xxx",
            'time' => '2000/12/24 12:34:56.123',
        ], $actual);
    }

    function test_getCount()
    {
        $module = new Log();
        $module->initialize();
        $module->setting([]);

        $this->assertEquals(0, $module->getCount($module->gather([])));

        $module->log('hoge');
        $this->assertEquals(1, $module->getCount($module->gather([])));
    }

    function test_getErrors()
    {
        $module = new Log();
        $module->initialize();
        $module->setting([]);

        $this->assertEquals('', $module->getError($module->gather([])));

        $module->log('hoge');
        $this->assertEquals('has 1 log', $module->getError($module->gather([])));
    }

    function test_preserve()
    {
        $logfile = sys_get_temp_dir() . '/hoge/log.txt';

        $module = new Log();
        $module->initialize(['logfile' => $logfile]);
        $module->setting([]);
        $module->log('xxx');
        $this->assertCount(0, glob(dirname($logfile) . '/*'));

        $module = new Log();
        $module->initialize(['logfile' => $logfile]);
        $module->setting(['preserve' => 1]);
        $module->log('xxx');
        $this->assertCount(0, glob(dirname($logfile) . '/*'));
        $module->render($module->gather([]));
        $this->assertCount(1, glob(dirname($logfile) . '/*'));

        $module = new Log();
        $module->initialize(['logfile' => $logfile]);
        $module->setting(['preserve' => 1]);
        $module->log('xxx');
        $module->render($module->gather([]));
        $this->assertCount(2, glob(dirname($logfile) . '/*'));
    }

    function test_render()
    {
        $module = new Log();
        $module->initialize();
        $module->setting([]);

        $module->log('xxx');
        $module->log('<b>bold</b>');

        $htmls = $module->render($module->gather([]));
        $this->assertStringContainsString('<caption>Log', $htmls);
        $this->assertStringContainsString('&lt;b&gt;bold&lt;/b&gt;', $htmls);
    }

    function test_thridparty()
    {
        $monolog = new Logger('app');
        $psr3log = new class() extends AbstractLogger implements LoggerAwareInterface {
            private LoggerInterface $internalLogger;


            public function log($level, $message, array $context = []): void
            {
                $this->internalLogger->log($level, $message, $context);
            }

            public function setLogger(LoggerInterface $logger): void
            {
                $this->internalLogger = $logger;
            }
        };
        $psr3log->setLogger(new class() extends AbstractLogger {
            public function log($level, $message, array $context = []): void
            {
                // noop
            }
        });

        $module = new Log();
        $module->initialize([
            'logger' => [$monolog, $psr3log],
        ]);
        $module->setting([]);

        $monolog->info('monolog');
        $psr3log->info('psr3log');
        $psr3log->notice('psr3log', ['data' => [1, 2, 3]]);

        $logs = $module->gather([]);
        $this->assertCount(3, $logs['Log']);

        $this->assertEquals('app.INFO', $logs['Log'][0]['name']);
        $this->assertEquals([
            'message' => 'monolog',
            'context' => [],
            'extra'   => [],
        ], $logs['Log'][0]['log']);

        $this->assertEquals('psr3.info', $logs['Log'][1]['name']);
        $this->assertEquals('psr3log', $logs['Log'][1]['log']);

        $this->assertEquals('psr3.notice', $logs['Log'][2]['name']);
        $this->assertEquals([
            'message' => 'psr3log',
            'data'    => [1, 2, 3],
        ], $logs['Log'][2]['log']);
    }

    function test_thridparty_misc()
    {
        $psr3log = new class() extends AbstractLogger implements LoggerAwareInterface {
            private LoggerInterface $internalLogger;


            public function log($level, $message, array $context = []): void
            {
                $this->internalLogger->log($level, $message, $context);
            }

            public function setLogger(LoggerInterface $logger): void
            {
                $this->internalLogger = $logger;
            }
        };

        $module = new Log();

        $this->assertException(new \InvalidArgumentException('logger must be'), function () use ($module) {
            $module->initialize([
                'logger' => 'invalid',
            ]);
        });

        $this->assertException(new \InvalidArgumentException('does not have internal'), function () use ($module, $psr3log) {
            $module->initialize([
                'logger' => $psr3log,
            ]);
        });
    }
}
