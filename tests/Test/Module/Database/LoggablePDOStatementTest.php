<?php
namespace ryunosuke\Test\WebDebugger\Module\Database;

use ryunosuke\Test\WebDebugger\AbstractTestCase;
use ryunosuke\WebDebugger\Module\Database\LoggablePDO;
use ryunosuke\WebDebugger\Module\Database\LoggablePDOStatement;

class LoggablePDOStatementTest extends AbstractTestCase
{
    /**
     * @var LoggablePDO
     */
    private $pdo;

    function setUp(): void
    {
        parent::setUp();

        $this->pdo = new LoggablePDO($this->getPdoConnection());
        $this->pdo->setAttribute(\PDO::ATTR_STATEMENT_CLASS, [LoggablePDOStatement::class, [$this->pdo]]);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    function test_all()
    {
        $this->pdo->query('select "query"');

        $stmt = $this->pdo->prepare('select ?');

        $stmt->bindValue(1, 'bindValue');
        $stmt->execute();

        $param = '';
        $stmt->bindParam(1, $param);
        $param = 'bindParam';
        $stmt->execute();
        unset($param);

        $stmt->execute(['execute']);

        $queries = $this->pdo->getLog();
        $this->assertEquals([
            'select "query"',
            'select ?',
            'select ?',
            'select ?',
        ], array_column($queries, 'sql'));
        $this->assertEquals([
            [],
            ['bindValue'],
            ['bindParam'],
            ['execute'],
        ], array_column($queries, 'params'));

        try {
            $this->pdo->prepare('ERROR !')->execute();
        }
        catch (\Exception $ex) {
            $queries = $this->pdo->getLog();
            $this->assertContains('Syntax error or access violation', $queries[4]['message']);
        }
    }

    function test_extend()
    {
        $pdo = $this->getPdoConnection();
        $pdo->setAttribute(\PDO::ATTR_STATEMENT_CLASS, [CustomPDOStatement::class, ['HOGE', 'FUGA']]);
        $this->pdo = new LoggablePDO($pdo);

        /** @var CustomPDOStatement $stmt */
        $stmt = $this->pdo->query('select "query"');
        $this->assertEquals([
            'hoge' => 'HOGE',
            'fuga' => 'FUGA',
        ], $stmt->getProperty());
    }
}

class CustomPDOStatement extends \PDOStatement
{
    private $hoge, $fuga;

    protected function __construct($hoge, $fuga)
    {
        $this->hoge = $hoge;
        $this->fuga = $fuga;
    }

    public function getProperty()
    {
        return [
            'hoge' => $this->hoge,
            'fuga' => $this->fuga,
        ];
    }
}
