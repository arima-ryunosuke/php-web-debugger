<?php
namespace ryunosuke\Test\WebDebugger\Module;

use Doctrine\DBAL\Connection;
use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Html\Popup;
use ryunosuke\WebDebugger\Module\Doctrine;

class DoctrineTest extends AbstractTestCase
{
    /**
     * @var Connection
     */
    private $connection;

    function setUp(): void
    {
        parent::setUp();

        $this->connection = $this->getConnection();
        $this->connection->setNestTransactionsWithSavepoints(true);
    }

    function test_initialize()
    {
        $module = new Doctrine();

        $this->assertException(new \InvalidArgumentException('"connection" is not Doctrine\DBAL\Connection.'), function () use ($module) {
            $module->initialize();
        });

        $this->assertException(new \InvalidArgumentException('"logger" is not callable/traversable.'), function () use ($module) {
            $module->initialize([
                'connection' => $this->connection,
                'logger'     => 'hoge',
            ]);
        });

        $this->assertException(new \InvalidArgumentException('"scorer" is not callable.'), function () use ($module) {
            $module->initialize([
                'connection' => $this->connection,
                'scorer'     => 'hoge',
            ]);
        });
    }

    function test_hook()
    {
        $module = new Doctrine();
        $module->initialize(['connection' => $this->connection]);

        $_POST['sql'] = 'select "hoge"';
        $response = $module->hook([
            'is_ajax' => true,
            'path'    => 'doctrine-exec',
        ]);
        $this->assertTrue($response instanceof Popup);
        $this->assertStringContainsString("<div class='prewrap scalar'>hoge</div>", (string) $response);

        $_POST['sql'] = 'select "hoge" from dual where 0';
        $response = $module->hook([
            'is_ajax' => true,
            'path'    => 'doctrine-exec',
        ]);
        $this->assertTrue($response instanceof Popup);
        $this->assertStringContainsString("<div class='prewrap scalar'>empty</div>", (string) $response);

        $_POST['sql'] = 'selec "hoge"';
        $response = $module->hook([
            'is_ajax' => true,
            'path'    => 'doctrine-exec',
        ]);
        $this->assertTrue($response instanceof Popup);
        $this->assertStringContainsString('<a href="javascript:void(0)" class="popup">error</a>', (string) $response);

        $response = $module->hook(['is_ajax' => false]);
        $this->assertNull($response);
    }

    function test_gather()
    {
        $module = new Doctrine();
        $module->initialize(['connection' => $this->connection, 'formatter' => false]);
        $module->setting(['explain' => 1]);
        $this->connection->beginTransaction();
        $this->connection->beginTransaction();
        $this->connection->prepare('select 1')->executeQuery();
        $this->connection->rollBack();
        $this->connection->commit();
        $stored = $module->gather([]);
        $this->assertArrayHasKey('Query', $stored);
        $this->assertArrayHasKey('summary', $stored['Query']);
        $this->assertArrayHasKey('logs', $stored['Query']);
        $this->assertNotContains('"SAVEPOINT"', array_column($stored['Query']['logs'], 'sql'));
    }

    function test_getError()
    {
        $module = new Doctrine();
        $module->initialize(['connection' => $this->connection]);
        $module->setting(['explain' => 1]);
        $this->connection->prepare('SELECT * FROM information_schema.TABLES ORDER BY information_schema.TABLES.TABLE_NAME')->executeQuery();
        $error = implode(',', $module->getError($module->gather([])));
        $this->assertStringContainsString('has slow query', $error);

        $module = new Doctrine();
        $module->initialize(['connection' => $this->connection]);
        $module->setting(['explain' => 1]);
        $this->connection->prepare('SELECT 1')->executeQuery();
        $error = implode(',', $module->getError($module->gather([])));
        $this->assertEquals('has 1 quries', $error);
    }

    function test_getHtml()
    {
        $module = new Doctrine();
        $module->initialize(['connection' => $this->connection]);
        $module->setting(['explain' => 1]);
        $this->connection->prepare('SELECT * FROM information_schema.TABLES')->executeQuery();
        $stmt = $this->connection->prepare('SELECT ?');
        $stmt->bindValue(1, 1);
        $stmt->executeQuery();
        $stmt = $this->connection->prepare('SELECT :hoge');
        $stmt->bindValue('hoge', 1);
        $stmt->executeQuery();
        try {
            $this->connection->executeQuery('ERROR!');
        }
        catch (\Exception $ex) {
        }
        $htmls = $module->getHtml($module->gather([]));
        $this->assertStringContainsString('<caption>Query', $htmls);
    }

    function test_misc()
    {
        $module = new Doctrine();

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

        $module->initialize(['connection' => $this->connection, 'formatter' => 'compress']);
        $this->assertEquals("select\n  1", $format('select    1'));

        $module->initialize(['connection' => $this->connection, 'formatter' => 'pretty']);
        $this->assertEquals("select\n  1", $format('select    1'));

        $module->initialize(['connection' => $this->connection, 'formatter' => false]);
        $this->assertEquals("select    1", $format('select    1'));

        $module->initialize([
                'connection' => $this->connection,
                'scorer'     => [
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
