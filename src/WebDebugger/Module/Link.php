<?php
namespace ryunosuke\WebDebugger\Module;

use ryunosuke\WebDebugger\Html\ArrayTable;
use ryunosuke\WebDebugger\Html\DefinitionList;
use ryunosuke\WebDebugger\Html\Raw;
use function ryunosuke\WebDebugger\array_maps;
use function ryunosuke\WebDebugger\is_stringable;
use const ENT_QUOTES;

class Link extends AbstractModule
{
    /** @var self */
    private static $instance;

    private array $links = [];

    public static function link($href, $name = '', $description = '')
    {
        if (self::$instance === null) {
            throw new \DomainException('Log Module is not initialized.');
        }

        if (!strlen($name)) {
            $name = 'link-' . count(self::$instance->links['dynamic']);
        }

        self::$instance->links['dynamic'][] = [
            'name'        => $name,
            'href'        => $href,
            'description' => $description,
        ];
    }

    protected function _initialize(array $options = [])
    {
        $options = array_replace_recursive([
            /**
             * string グローバル関数の名前
             *
             * function を与えるとその名前でグローバル関数として定義される。
             * デフォルトは `dlink` で、何らかの任意の名前を指定しても重複しない限り問題ないはず。
             * ただし、変更した場合は IDE 等でエラーが出るので何らかの対処をしたほうがよい。
             * （`dlink` であれば tests/bootstrap.php でダミー定義してるのでエラーにはならないはず）。
             */
            'function' => 'dlink',
            /** array 静的リンク */
            'static'   => [],
            /** array 動的リンク */
            'dynamic'  => [],
        ], $options);

        if (!function_exists($options['function'])) {
            $funcname = $options['function'];
            $class    = __CLASS__;
            eval(/** @lang */
            "function $funcname(){return call_user_func_array('$class::link', func_get_args());}");
        }

        $this->links['static']  = $options['static'];
        $this->links['dynamic'] = $options['dynamic'];

        self::$instance = $this;
    }

    protected function _finalize()
    {
        self::$instance = null;
        $this->links = [];
    }

    protected function _gather(array $request): array
    {
        $links = [];
        foreach ($this->links as $type => $data) {
            $links[$type] = array_values(array_maps($data, function ($v, $k) {
                if ($v instanceof \Closure) {
                    $v = $v();
                }
                if (is_stringable($v)) {
                    $v = [
                        'name'        => $k,
                        'href'        => $v,
                        'description' => '',
                    ];
                }
                return $v;
            }));
        }
        return $links;
    }

    protected function _getCount($stored): ?int
    {
        return count($stored['static']) + count($stored['dynamic']);
    }

    protected function _getHtml($stored): string
    {
        $H = fn($v) => htmlspecialchars($v, ENT_QUOTES);

        $result = [];
        foreach ($stored as $type => $data) {
            if ($data) {
                $result[] = new ArrayTable($type, array_map(fn($link) => [
                    'name'        => $link['name'],
                    'href'        => new Raw("<a href='{$H($link['href'])}' target='{$H(sha1($link['name']))}'>{$H(mb_strimwidth($link['href'], 0, 160, '...'))}</a>"),
                    'description' => $link['description'],
                ], $data));
            }
        }
        return implode('', $result);
    }
}
