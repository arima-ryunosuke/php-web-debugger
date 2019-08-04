<?php
namespace ryunosuke\WebDebugger\Html;

class Popup extends AbstractHtml
{
    public function __construct($title, $content)
    {
        ob_start();
        ?>
        <a href="javascript:void(0)" class="popup"><?= $this->escapeHtml($title); ?></a>
        <div class="extends popupdiv"><?= $content; ?></div>
        <?php
        $this->string = ob_get_clean();
    }
}
