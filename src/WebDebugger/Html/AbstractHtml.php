<?php
namespace ryunosuke\WebDebugger\Html;

use function ryunosuke\WebDebugger\var_pretty;

abstract class AbstractHtml
{
    protected string $string;

    public function __toString(): string
    {
        return $this->string;
    }

    protected function export($var): string
    {
        // AbstractHtml 系はそのまま
        if ($var instanceof AbstractHtml) {
            return (string) $var;
        }
        // null,bool はそのまま
        elseif (is_null($var) || is_bool($var)) {
            return "<div class='prewrap simple'>" . ($var === null ? 'null' : ($var ? 'true' : 'false')) . "</div>";
        }
        // 数値は右寄せとフォーマット
        elseif (is_numeric($var)) {
            $var = strval($var);
            [, $dec] = explode('.', $var, 2) + [1 => ''];
            return "<div class='prewrap numeric'>" . $this->escapeHtml(number_format($var, min(strlen($dec), 6))) . "</div>";
        }
        // その他のスカラー値は普通に表示
        elseif (is_scalar($var)) {
            return "<div class='prewrap scalar'>" . $this->escapeHtml($var) . "</div>";
        }
        // その他のスカラー値は普通に表示
        elseif (is_resource($var)) {
            return "<div class='prewrap resource'>" . $this->escapeHtml(get_resource_type($var) . " $var") . "</div>";
        }

        // 中身。配列やオブジェクトは循環参照などでとてつもなく巨大になることがあるのである程度制限する（注入できるようにしたい）
        /** @noinspection PhpUndefinedClassInspection */
        /** @noinspection PhpUndefinedNamespaceInspection */
        return var_pretty($var, [
            'return'       => true,
            'context'      => 'html',
            'maxdepth'     => 10,
            'maxcount'     => 255,
            'maxlength'    => 1024 * 24,
            'limit'        => 1024 * 1024,
            'table'        => fn($v, $nest) => "<div class='tableofarraydiv' style='margin-left:{$nest}em'>" . (new ArrayTable('', $v)) . "</div>",
            'excludeclass' => [
                \Psr\SimpleCache\CacheInterface::class,
            ],
            'callback'     => function (&$string, $var, $nest) {
                if (is_array($var) && count($var) === 0) {
                    $string = '[]';
                }
                elseif (is_array($var)) {
                    $string = new Holding('array(' . count($var) . ')', $string);
                }
                elseif (is_object($var)) {
                    $string = new Holding(get_class($var) . '#' . spl_object_id($var), $string);
                }
            },
        ]);
    }

    protected function escapeHtml($string): string
    {
        if ($string instanceof AbstractHtml) {
            return (string) $string;
        }
        return htmlspecialchars($string, ENT_QUOTES);
    }
}
