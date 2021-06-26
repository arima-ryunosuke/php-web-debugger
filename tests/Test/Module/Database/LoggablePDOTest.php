<?php
namespace ryunosuke\Test\WebDebugger\Module\Database;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\Test\WebDebugger\Klass\PDOWrapper;
use ryunosuke\WebDebugger\Module\Database\LoggablePDO;

class LoggablePDOTest extends AbstractTestCase
{
    /**
     * @var LoggablePDO
     */
    private $pdo;

    function setUp(): void
    {
        parent::setUp();

        $this->pdo = new LoggablePDO($this->getPdoConnection());
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_replace()
    {
        LoggablePDO::replace(PDOWrapper::class, 'getPDO');
        $wrapper = new PDOWrapper();
        $this->assertInstanceOf(LoggablePDO::class, $wrapper->getPDO());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    function test_reflect()
    {
        $wrapper = new PDOWrapper();
        LoggablePDO::reflect($wrapper, 'pdo');
        $this->assertInstanceOf(LoggablePDO::class, $wrapper->getPDO());

        $wrapper = new PDOWrapper();
        LoggablePDO::reflect($wrapper);
        $this->assertInstanceOf(LoggablePDO::class, $wrapper->getPDO());
    }

    function test_begin_commit_rollback()
    {
        $this->pdo->beginTransaction();
        $this->pdo->commit();
        $this->pdo->beginTransaction();
        $this->pdo->rollBack();

        $queries = $this->pdo->getLog();
        $this->assertEquals([
            'BEGIN',
            'COMMIT',
            'BEGIN',
            'ROLLBACK',
        ], array_column($queries, 'sql'));
    }

    function test_exec()
    {
        $this->pdo->exec('select "query"');

        try {
            $this->pdo->exec('ERROR!!');
        }
        catch (\Exception $ex) {
        }

        $queries = $this->pdo->getLog();
        $this->assertEquals([
            'select "query"',
            'ERROR!!',
        ], array_column($queries, 'sql'));
        $this->assertEquals([
            [],
            [],
        ], array_column($queries, 'params'));
    }

    function test_query()
    {
        $this->pdo->query('select "query"');

        try {
            $this->pdo->query('ERROR!!');
        }
        catch (\Exception $ex) {
        }

        $queries = $this->pdo->getLog();
        $this->assertEquals([
            'select "query"',
            'ERROR!!',
        ], array_column($queries, 'sql'));
        $this->assertEquals([
            [],
            [],
        ], array_column($queries, 'params'));
    }

    function test_prepare()
    {
        $stmt = $this->pdo->prepare('select ?');
        $stmt->execute(['hoge']);
        $stmt->execute(['fuga']);

        try {
            $this->pdo->prepare('ERROR!!');
        }
        catch (\Exception $ex) {
        }

        try {
            $this->pdo->prepare('select ?, ?')->execute([1]);
        }
        catch (\Exception $ex) {
        }

        $queries = $this->pdo->getLog();
        $this->assertEquals([
            'select ?',
            'select ?',
            'ERROR!!',
            'select ?, ?',
        ], array_column($queries, 'sql'));
        $this->assertEquals([
            ['hoge'],
            ['fuga'],
            [],
            [1],
        ], array_column($queries, 'params'));
    }

    function test_clearLog()
    {
        $stmt = $this->pdo->prepare('select ?');
        $stmt->execute(['hoge']);
        $stmt->execute(['fuga']);

        $this->pdo->clearLog();
        $this->assertEmpty($this->pdo->getLog());
    }
}
