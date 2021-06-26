<?php
namespace ryunosuke\WebDebugger\Module\Database;

/**
 * @codeCoverageIgnore
 * @deprecated
 */
class LoggablePDOStatement extends \PDOStatement
{
    /** @var LoggablePDO */
    private $pdo;

    /** @var array */
    private $params = [];

    public static function extend($parent_class)
    {
        $parent_stmt = str_replace('\\', '_', $parent_class . 'Dynamic');
        $extend_stmt = __NAMESPACE__ . '\\' . $parent_stmt;

        if (!class_exists($extend_stmt, false)) {
            $local = 'LoggablePDOStatement';
            $template = file_get_contents(__FILE__);
            $template = str_replace("class $local", "class $parent_stmt", $template);
            $template = str_replace('extends \\PDOStatement', "extends \\$parent_class", $template);
            eval("?>$template");
        }
        return $extend_stmt;
    }

    protected function __construct(...$args)
    {
        $pdo = array_pop($args);

        if (method_exists(get_parent_class(), __FUNCTION__)) {
            call_user_func_array(['parent', __FUNCTION__], $args); // @codeCoverageIgnore
        }

        $this->pdo = $pdo;
    }

    public function bindParam($parameter, &$variable, $data_type = \PDO::PARAM_STR, $length = null, $driver_options = null)
    {
        $this->params[$parameter] = &$variable;
        return parent::bindParam($parameter, $variable, $data_type, $length, $driver_options);
    }

    public function bindValue($parameter, $value, $data_type = \PDO::PARAM_STR)
    {
        $this->params[$parameter] = $value;
        return parent::bindValue($parameter, $value, $data_type);
    }

    public function execute($input_parameters = null)
    {
        $params = $input_parameters ?: array_merge($this->params);
        return $this->pdo->delegate(function (...$v) { parent::execute(...$v); }, func_get_args(), $this->queryString, $params);
    }
}
