<?php
namespace ryunosuke\WebDebugger\Html;

class ArrayTable extends AbstractHtml
{
    /**
     * @param string $caption テーブルキャプション
     * @param array $values テーブル表示する配列
     * @param array $styles 個別スタイル
     */
    public function __construct($caption, array $values, array $styles = [])
    {
        // キーの和集合をヘッダとする
        $headers = array_keys(array_reduce($values, function ($carry, $item) { return $carry + $item; }, []));

        ob_start();
        ?>
        <table class="debug_table array_table">
            <?php if ($caption): ?>
                <caption><?= $this->escapeHtml($caption) ?></caption>
            <?php endif; ?>

            <thead>
            <tr>
                <?php foreach ($headers as $header) : ?>
                    <th class="nowrap"><?= $this->escapeHtml($header) ?></th>
                <?php endforeach; ?>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($values as $n => $row) : ?>
                <tr>
                    <?php foreach ($headers as $header) : ?>
                        <?php if (array_key_exists($header, $row)): ?>
                            <td class="nowrap <?= $header ?>"
                                style="<?= isset($styles[$n][$header]) ? $styles[$n][$header] : '' ?>"
                            >
                                <?= $this->export($row[$header]) ?>
                            </td>
                        <?php else: ?>
                            <td class="nowrap">&nbsp;</td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php
        $this->string = ob_get_clean();
    }
}
