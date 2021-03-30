<?php
namespace ryunosuke\Test\WebDebugger\Module;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Html\Popup;
use ryunosuke\WebDebugger\Module\Database;

class DatabaseTest extends AbstractTestCase
{
    /**
     * @var Database\LoggablePDO
     */
    private $pdo;

    function setUp()
    {
        parent::setUp();

        $this->pdo = new Database\LoggablePDO($this->getPdoConnection());
    }

    function test_doctrineAdapter()
    {
        $connection = \Doctrine\DBAL\DriverManager::getConnection(['pdo' => $this->getPdoConnection()]);
        $adapter = Database::doctrineAdapter($connection)();

        $connection->query('select 1');
        $connection->prepare('select ?')->execute([1]);

        $logs = iterator_to_array($adapter['logger']);

        $this->assertArraySubset([
            'sql'    => 'select 1',
            'params' => [],
        ], $logs[0]);
        $this->assertArraySubset([
            'sql'    => 'select ?',
            'params' => [1],
        ], $logs[1]);
    }

    function test_initialize()
    {
        $module = new Database();

        $this->assertException(new \InvalidArgumentException('"pdo" is not PDO.'), function () use ($module) {
            $module->initialize();
        });

        $this->assertException(new \InvalidArgumentException('"logger" is not callable/traversable.'), function () use ($module) {
            $module->initialize([
                'pdo'    => $this->pdo,
                'logger' => 'hoge',
            ]);
        });

        $this->assertException(new \InvalidArgumentException('"scorer" is not callable.'), function () use ($module) {
            $module->initialize([
                'pdo'    => $this->pdo,
                'scorer' => 'hoge',
            ]);
        });
    }

    function test_finalize()
    {
        $module = new Database();

        $module->finalize();

        $this->pdo->query('select 1');
        $module->initialize([
            'pdo' => $this->pdo,
        ]);
        $module->finalize();

        $this->assertEmpty($this->pdo->getLog());
    }

    function test_fook()
    {
        $module = new Database();
        $module->initialize([
            'pdo' => $this->pdo,
        ]);

        $_POST['sql'] = 'select "hoge"';
        $response = $module->fook([
            'is_ajax' => true,
            'path'    => 'database-exec',
        ]);
        $this->assertTrue($response instanceof Popup);
        $this->assertContains("<div class='prewrap scalar'>hoge</div>", (string) $response);

        $_POST['sql'] = 'select "hoge" from dual where 0';
        $response = $module->fook([
            'is_ajax' => true,
            'path'    => 'database-exec',
        ]);
        $this->assertTrue($response instanceof Popup);
        $this->assertContains("<div class='prewrap scalar'>empty</div>", (string) $response);

        $_POST['sql'] = 'selec "hoge"';
        $response = $module->fook([
            'is_ajax' => true,
            'path'    => 'database-exec',
        ]);
        $this->assertTrue($response instanceof Popup);
        $this->assertContains('<a href="javascript:void(0)" class="popup">error</a>', (string) $response);

        $response = $module->fook(['is_ajax' => false]);
        $this->assertNull($response);
    }

    function test_gather()
    {
        $module = new Database();
        $module->initialize([
            'pdo'       => $this->pdo,
            'formatter' => false,
        ]);
        $module->setting(['explain' => 1]);
        $this->pdo->prepare('select 1')->execute();
        $stored = $module->gather([]);
        $this->assertArrayHasKey('Query', $stored);
        $this->assertArrayHasKey('summary', $stored['Query']);
        $this->assertArrayHasKey('logs', $stored['Query']);
        $module->finalize();
    }

    function test_getError()
    {
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $module = new Database();
        $module->initialize(['pdo' => $this->pdo,]);
        $module->setting(['explain' => 1]);
        $this->pdo->prepare('SELECT * FROM information_schema.TABLES')->execute();
        $error = $module->getError($module->gather([]));
        $this->assertContains('has slow query', $error);
        $module->finalize();

        $module = new Database();
        $module->initialize(['pdo' => $this->pdo,]);
        $module->setting(['explain' => 1]);
        try {
            $this->pdo->prepare('ERROR!')->execute();
        }
        catch (\Exception $ex) {
        }
        $error = $module->getError($module->gather([]));
        $this->assertEquals('has 1 quries,has error query', $error);
        $module->finalize();

        $module = new Database();
        $module->initialize(['pdo' => $this->pdo,]);
        $module->setting(['explain' => 1]);
        $this->pdo->prepare('SELECT 1')->execute();
        $error = $module->getError($module->gather([]));
        $this->assertEquals('has 1 quries', $error);
        $module->finalize();
    }

    function test_render()
    {
        $module = new Database();
        $module->initialize(['pdo' => $this->pdo,]);
        $module->setting(['explain' => 1]);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->prepare('SELECT * FROM information_schema.TABLES')->execute();
        $this->pdo->prepare('SELECT ?')->execute([1]);
        $this->pdo->prepare('SELECT :hoge')->execute(['hoge' => 1]);
        try {
            $this->pdo->prepare('ERROR !')->execute();
        }
        catch (\Exception $ex) {
        }
        $htmls = $module->render($module->gather([]));
        $this->assertContains('<caption>Query', $htmls);
        $this->assertContains('background:#fcc', $htmls);
    }

    function test_console()
    {
        $module = new Database();
        $module->initialize(['pdo' => $this->pdo,]);
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

        $module->initialize([
            'pdo' => $this->pdo,
        ]);
        $this->assertEquals("select '1', NULL, '??', '$1'", $quote('select ?, ?, ?, ?', [1, null, '??', '$1']));

        $module->initialize([
            'pdo'       => $this->pdo,
            'formatter' => 'compress',
        ]);
        $this->assertEquals("select\n  1", $format('select    1'));

        $module->initialize([
            'pdo'       => $this->pdo,
            'formatter' => 'pretty',
        ]);
        $this->assertEquals("select\n  1", $format('select    1'));

        $module->initialize([
            'pdo'       => $this->pdo,
            'formatter' => false,
        ]);
        $this->assertEquals("select    1", $format('select    1'));

        $module->initialize([
            'pdo'    => $this->pdo,
            'scorer' => [
                'rows' => [
                    '>=0' => 100,
                ]
            ],
        ]);
        $exrows = $explain("create temporary table hoge select 1", []);
        $this->assertEquals('No tables used', $exrows[0]['Extra']);
        $this->assertEquals(100, array_sum($score($exrows[0])));
    }
}
