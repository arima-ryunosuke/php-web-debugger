<?php
namespace ryunosuke\WebDebugger\Html;

class HashTable extends AbstractHtml
{
    /**
     * @param string $caption テーブルキャプション
     * @param iterable $values テーブル表示する配列
     * @param array $styles 個別スタイル
     * @param array $namevalue [Name => Value]
     */
    public function __construct($caption, iterable $values, array $styles = [], array $namevalue = [])
    {
        $keyvalue = $namevalue ?: ['Name' => 'Value'];
        reset($keyvalue);

        ob_start();
        // @formatter:off
        ?>
<table class="debug_table hash_table">
<?php if ($caption): ?>
<caption><?= $this->escapeHtml($caption); ?></caption>
<?php endif; ?>

<thead>
<tr>
<th><?= $this->escapeHtml(key($keyvalue)); ?></th>
<th><?= $this->escapeHtml(current($keyvalue)); ?></th>
</tr>
</thead>

<tbody>
<?php foreach ($values as $key => $value) : ?>
<tr>
<td class="nowrap" style="<?= isset($styles[$key]) ? $styles[$key] : '' ?>"><?= $this->escapeHtml($key); ?></td>
<td class="nowrap" style="<?= isset($styles[$key]) ? $styles[$key] : '' ?>"><?= $this->export($value); ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
        <?php
        // @formatter:on
        $this->string = trim(ob_get_clean());
    }
}
