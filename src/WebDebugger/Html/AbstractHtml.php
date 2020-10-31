<?php
namespace ryunosuke\WebDebugger\Html;

abstract class AbstractHtml
{
    protected $string;

    public function __toString()
    {
        return (string) $this->string;
    }

    /**
     * 末端値の表示用変換
     *
     * @param mixed $var
     * @return Holding|string
     */
    protected function export($var)
    {
        // AbstractHtml 系はそのまま
        if ($var instanceof AbstractHtml) {
            return (string) $var;
        }
        // null,bool はそのまま
        elseif (is_null($var) || is_bool($var)) {
            return "<div class='prewrap simple'>" . ($var === null ? 'null' : ($var ? 'true' : 'false')) . "</div>";
        }
        // 数値は右寄せ
        elseif (is_numeric($var)) {
            return "<div class='prewrap numeric'>" . $this->escapeHtml($var) . "</div>";
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
        return \ryunosuke\WebDebugger\var_pretty($var, [
            'return'   => true,
            'context'  => 'html',
            'maxdepth' => 10,
            'maxcount' => 100,
            'maxlength' => 1024 * 24,
            'callback' => function (&$string, $var, $nest) {
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

    protected function escapeHtml($string)
    {
        if ($string instanceof AbstractHtml) {
            return (string) $string;
        }
        return htmlspecialchars($string, ENT_QUOTES);
    }
}
