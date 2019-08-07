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
        // 空配列は Holding である必要がない
        elseif (is_array($var) && count($var) === 0) {
            return "<div class='prewrap'>array(0)</div>";
        }

        // 中身。配列やオブジェクトは循環参照などでとてつもなく巨大になることがあるので堰き止める
        $content = \ryunosuke\WebDebugger\var_pretty($var, null, true);
        $guide = "";
        if (mb_strlen($content) > 1024 * 10) {
            $content = mb_substr($content, 0, 1024 * 10);
            $guide = "<br />...<em>omitted too long</em>";
        }

        // type 名の取得（array, resource, object はちょっと小細工する）
        $type = gettype($var);
        if (is_array($var)) {
            $type .= '(' . count($var) . ')';
        }
        elseif (is_resource($var)) {
            $type .= ':' . get_resource_type($var);
        }
        elseif (is_object($var)) {
            $type .= ':' . get_class($var);
        }
        return new Holding($type, $content . $guide);
    }

    protected function escapeHtml($string)
    {
        if ($string instanceof AbstractHtml) {
            return (string) $string;
        }
        return htmlspecialchars($string, ENT_QUOTES);
    }
}
