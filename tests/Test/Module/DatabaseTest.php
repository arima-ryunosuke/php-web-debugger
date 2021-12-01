<?php
namespace ryunosuke\Test\WebDebugger\Module;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Html\Popup;
use ryunosuke\WebDebugger\Module\Database;

class DatabaseTest extends AbstractTestCase
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    private $connection;

    private $adapter;

    function setUp(): void
    {
        parent::setUp();

        $this->connection = \Doctrine\DBAL\DriverManager::getConnection([
            'driverClass' => \PDODriver::class,
            'pdo'         => $this->getPdoConnection(),
        ]);
        $this->adapter = Database::doctrineAdapter($this->connection)();
        $this->adapter['logger']->clear();
    }

    function test_initialize()
    {
        $module = new Database();

        $this->assertException(new \InvalidArgumentException('"pdo" is not PDO.'), function () use ($module) {
            $module->initialize();
        });

        $this->assertException(new \InvalidArgumentException('"logger" is not callable/traversable.'), function () use ($module) {
            $module->initialize([
                'pdo'    => $this->adapter['pdo'],
                'logger' => 'hoge',
            ]);
        });

        $this->assertException(new \InvalidArgumentException('"scorer" is not callable.'), function () use ($module) {
            $module->initialize([
                'pdo'    => $this->adapter['pdo'],
                'logger' => $this->adapter['logger'],
                'scorer' => 'hoge',
            ]);
        });
    }

    function test_fook()
    {
        $module = new Database();
        $module->initialize($this->adapter);

        $_POST['sql'] = 'select "hoge"';
        $response = $module->fook([
            'is_ajax' => true,
            'path'    => 'database-exec',
        ]);
        $this->assertTrue($response instanceof Popup);
        $this->assertStringContainsString("<div class='prewrap scalar'>hoge</div>", (string) $response);

        $_POST['sql'] = 'select "hoge" from dual where 0';
        $response = $module->fook([
            'is_ajax' => true,
            'path'    => 'database-exec',
        ]);
        $this->assertTrue($response instanceof Popup);
        $this->assertStringContainsString("<div class='prewrap scalar'>empty</div>", (string) $response);

        $_POST['sql'] = 'selec "hoge"';
        $response = $module->fook([
            'is_ajax' => true,
            'path'    => 'database-exec',
        ]);
        $this->assertTrue($response instanceof Popup);
        $this->assertStringContainsString('<a href="javascript:void(0)" class="popup">error</a>', (string) $response);

        $response = $module->fook(['is_ajax' => false]);
        $this->assertNull($response);
    }

    function test_gather()
    {
        $module = new Database();
        $module->initialize($this->adapter + ['formatter' => false]);
        $module->setting(['explain' => 1]);
        $this->connection->prepare('select 1')->executeQuery();
        $stored = $module->gather([]);
        $this->assertArrayHasKey('Query', $stored);
        $this->assertArrayHasKey('summary', $stored['Query']);
        $this->assertArrayHasKey('logs', $stored['Query']);
    }

    function test_getError()
    {
        $module = new Database();
        $module->initialize($this->adapter);
        $module->setting(['explain' => 1]);
        $this->connection->prepare('SELECT * FROM information_schema.TABLES')->executeQuery();
        $error = $module->getError($module->gather([]));
        $this->assertStringContainsString('has slow query', $error);

        $module = new Database();
        $module->initialize($this->adapter);
        $module->setting(['explain' => 1]);
        try {
            $this->connection->executeQuery('ERROR!');
        }
        catch (\Exception $ex) {
        }
        $error = $module->getError($module->gather([]));
        $this->assertEquals('has 2 quries,has slow query,has error query', $error);

        $module = new Database();
        $module->initialize($this->adapter);
        $module->setting(['explain' => 1]);
        $this->connection->prepare('SELECT 1')->executeQuery();
        $error = $module->getError($module->gather([]));
        $this->assertEquals('has 3 quries,has slow query,has error query', $error);
    }

    function test_render()
    {
        $module = new Database();
        $module->initialize($this->adapter);
        $module->setting(['explain' => 1]);
        $this->connection->prepare('SELECT * FROM information_schema.TABLES')->executeQuery();
        $this->connection->prepare('SELECT ?')->executeQuery([1]);
        $this->connection->prepare('SELECT :hoge')->executeQuery(['hoge' => 1]);
        try {
            $this->connection->executeQuery('ERROR!');
        }
        catch (\Exception $ex) {
        }
        $htmls = $module->render($module->gather([]));
        $this->assertStringContainsString('<caption>Query', $htmls);
    }

    function test_console()
    {
        $module = new Database();
        $module->initialize($this->adapter);
        $consoles = $module->console($module->gather([]));
        $this->assertArrayHasKey('table', reset($consoles));
    }

    function test_misc()
    {
        $module = new Database();

        $quote = function ($sql, $params) use ($module) {
            $ref = new \ReflectionMethod($module, 'quote');
            $ref->setAccessible(true);
            return $ref->invoke($module, $sql, $params);
        };
        $explain = function ($sql, $params) use ($module) {
            $ref = new \ReflectionMethod($module, 'explain');
            $ref->setAccessible(true);
            return $ref->invoke($module, $sql, $params);
        };
        $format = function ($sql) use ($module) {
            $ref = new \ReflectionProperty($module, 'formatter');
            $ref->setAccessible(true);
            return call_user_func($ref->getValue($module), $sql);
        };
        $score = function ($exrow) use ($module) {
            $ref = new \ReflectionProperty($module, 'scorer');
            $ref->setAccessible(true);
            return call_user_func($ref->getValue($module), $exrow);
        };

        $module->initialize($this->adapter);
        $this->assertEquals("select '1', NULL, '??', '$1'", $quote('select ?, ?, ?, ?', [1, null, '??', '$1']));

        $module->initialize($this->adapter + ['formatter' => 'compress']);
        $this->assertEquals("select\n  1", $format('select    1'));

        $module->initialize($this->adapter + ['formatter' => 'pretty']);
        $this->assertEquals("select\n  1", $format('select    1'));

        $module->initialize($this->adapter + ['formatter' => false]);
        $this->assertEquals("select    1", $format('select    1'));

        $module->initialize($this->adapter + [
                'scorer' => [
                    'rows' => [
                        '>=0' => 100,
                    ],
                ],
            ]
        );
        $exrows = $explain("create temporary table hoge select 1", []);
        $this->assertEquals('No tables used', $exrows[0]['Extra']);
        $this->assertEquals(100, array_sum($score($exrows[0])));
    }
}
