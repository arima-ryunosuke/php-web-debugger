<?php
namespace ryunosuke\WebDebugger\Html;

use function ryunosuke\WebDebugger\array_each;
use function ryunosuke\WebDebugger\arrayval;

class ArrayTable extends AbstractHtml
{
    /**
     * @param string $caption テーブルキャプション
     * @param iterable $values テーブル表示する配列
     * @param array $styles 個別スタイル
     */
    public function __construct($caption, iterable $values, array $styles = [])
    {
        // キーの和集合をヘッダとする
        $headers = array_keys(array_each($values, function (&$carry, $v) {
            $carry += arrayval($v, false);
        }, []));

        ob_start();
        // @formatter:off
        ?>
<table class="debug_table array_table">
<?php if ($caption): ?>
<caption><?= $this->escapeHtml($caption) ?></caption>
<?php endif; ?>

<thead>
<tr>
<th class="nowrap">#</th>
<?php foreach ($headers as $header) : ?>
<th class="nowrap"><?= $this->escapeHtml($header) ?></th>
<?php endforeach; ?>
</tr>
</thead>

<tbody>
<?php foreach ($values as $n => $row) : ?>
<tr>
<td class="nowrap _index"><?= $this->export($n) ?></td>
<?php foreach ($headers as $header) : ?>
<?php if (\ryunosuke\WebDebugger\attr_exists($header, $row)): ?>
<td class="nowrap <?= $header ?>" style="<?= isset($styles[$n][$header]) ? $styles[$n][$header] : '' ?>"><?= $this->export($row[$header]) ?></td>
<?php else: ?>
<td class="nowrap">&nbsp;</td>
<?php endif; ?>
<?php endforeach; ?>
</tr>
<?php endforeach; ?>
</tbody>
</table>
        <?php
        // @formatter:on
        $this->string = trim(ob_get_clean());
    }
}
