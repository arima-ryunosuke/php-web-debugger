<?php
namespace ryunosuke\WebDebugger\Html;

class Holding extends AbstractHtml
{
    public function __construct($title, $content)
    {
        ob_start();
        ?>
        <a href="javascript:void(0)" class="holding"><?= $this->escapeHtml($title); ?></a>
        <div class="extends holdingdiv"><?= $content; ?></div>
        <?php
        $this->string = ob_get_clean();
    }
}
