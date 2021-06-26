<?php
/** @noinspection PhpDeprecationInspection */
/** @noinspection PhpMissingParentConstructorInspection */
namespace ryunosuke\WebDebugger\Module\Database;

/**
 * @codeCoverageIgnore
 * @deprecated
 */
class LoggablePDO extends \PDO
{
    /** @var \PDO */
    private $pdo;

    /** @var QueryLog[] */
    private $logs = [];

    /**
     * 対象クラスの PDO を返すようなメソッドを強制的に LoggablePDO を返すように置き換える
     *
     * @param string $class 置換対象クラス名
     * @param string $method 置換対象メソッド名
     */
    public static function replace($class, $method)
    {
        \ryunosuke\WebDebugger\class_replace($class, [
            $method => function () {
                return new \ryunosuke\WebDebugger\Module\Database\LoggablePDO(parent::{__FUNCTION__}(...func_get_args())); // @codeCoverageIgnore
            },
        ]);
    }

    /**
     * 対象オブジェクトの PDO プロパティを強制的に LoggablePDO に置き換える
     *
     * @param object $object 置換対象オブジェクト
     * @param string $property 置換対象プロパティ名（null 指定時は全プロパティから PDO を探す）
     */
    public static function reflect($object, $property = null)
    {
        $refclass = new \ReflectionObject($object);
        $properties = $property === null ? $refclass->getProperties() : [$refclass->getProperty($property)];
        foreach ($properties as $p) {
            $p->setAccessible(true);
            $v = $p->getValue($object);
            if ($v instanceof \PDO) {
                $p->setValue($object, new LoggablePDO($v));
            }
        }
    }

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $stmt_class = $this->pdo->getAttribute(\PDO::ATTR_STATEMENT_CLASS);
        $class_name = $stmt_class[0] ?? 'PDOStatement';
        $class_args = $stmt_class[1] ?? [];

        $loggable_stmt = LoggablePDOStatement::extend($class_name);
        $class_args[] = $this;

        $this->pdo->setAttribute(\PDO::ATTR_STATEMENT_CLASS, [$loggable_stmt, $class_args]);
    }

    public function __get($name) { return $this->pdo->$name; }

    public function __set($name, $value) { $this->pdo->$name = $value; }

    public function __call($name, $args) { return $this->pdo->$name(...$args); }

    public function getAttribute($attribute) { return $this->pdo->getAttribute($attribute); }

    public function setAttribute($attribute, $value) { return $this->pdo->setAttribute($attribute, $value); }

    public function errorCode() { return $this->pdo->errorCode(); }

    public function errorInfo() { return $this->pdo->errorInfo(); }

    public function quote($string, $parameter_type = \PDO::PARAM_STR) { return $this->pdo->quote($string, $parameter_type); }

    public function lastInsertId($name = null) { return $this->pdo->lastInsertId($name); }

    public function inTransaction() { return $this->pdo->inTransaction(); }

    public function beginTransaction()
    {
        return $this->delegate([$this->pdo, __FUNCTION__], func_get_args(), 'BEGIN');
    }

    public function commit()
    {
        return $this->delegate([$this->pdo, __FUNCTION__], func_get_args(), 'COMMIT');
    }

    public function rollBack()
    {
        return $this->delegate([$this->pdo, __FUNCTION__], func_get_args(), 'ROLLBACK');
    }

    public function exec($statement)
    {
        return $this->delegate([$this->pdo, __FUNCTION__], func_get_args(), $statement);
    }

    public function query($statement, $mode = \PDO::ATTR_DEFAULT_FETCH_MODE, $arg3 = null, array $ctorargs = [])
    {
        return $this->delegate([$this->pdo, __FUNCTION__], func_get_args(), $statement);
    }

    public function prepare($statement, $driver_options = [])
    {
        // prepare は stmt に移譲できるので消す。が、シンタックスエラー等の場合は stmt まで行かずに即死するので消えなくてよい
        $result = $this->delegate([$this->pdo, __FUNCTION__], func_get_args(), $statement);
        array_pop($this->logs);
        return $result;
    }

    public function delegate($callable, $args, $statement, $params = [])
    {
        $this->logs[] = $log = new QueryLog($statement, $params);
        try {
            $result = $callable(...$args);
            $log->done();
            return $result;
        }
        catch (\Exception $e) {
            $log->fail($e);
            throw $e;
        }
    }

    public function getLog()
    {
        return array_map(function ($v) { return (array) $v; }, $this->logs);
    }

    public function clearLog()
    {
        $this->logs = [];
    }
}
