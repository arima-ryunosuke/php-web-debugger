<?php
namespace ryunosuke\WebDebugger\Html;

class Holding extends AbstractHtml
{
    public function __construct($title, $content, bool $firstopen = false)
    {
        ob_start();
        // @formatter:off
        ?>
<a href="javascript:void(0)" class="holding<?= $firstopen ? ' opened' : '' ?>"><?= $this->escapeHtml($title); ?></a><span class="extends holdingdiv"<?= $firstopen ? ' style="display:inline"' : '' ?>> <?= $content; ?></span>
        <?php
        // @formatter:on
        $this->string = trim(ob_get_clean());
    }
}
