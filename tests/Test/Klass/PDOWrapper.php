<?php
namespace ryunosuke\Test\WebDebugger\Klass;

class PDOWrapper
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO('sqlite::memory:');
    }

    public function getPDO()
    {
        return $this->pdo;
    }
}
