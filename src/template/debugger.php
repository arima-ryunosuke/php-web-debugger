<?php

$h = function ($string) {
    return htmlspecialchars((string) $string, ENT_QUOTES, 'UTF-8');
};

/**
 * @var \ryunosuke\WebDebugger\Debugger $this
 * @var string $prepare
 * @var array $module_data
 */

?>
<html lang="">
<head>
    <title>Web Debugger</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script><?php include __DIR__ . '/debugger.js' ?></script>
    <style><?php include __DIR__ . '/debugger.css' ?></style>
    <?= $prepare ?>
</head>
<body>

<div id="js-variable">
    <input type="hidden" name="opener" value="<?= $h($this->options['opener']) ?>">
    <input type="hidden" name="opener_query" value="<?= $h($this->options['opener_query']) ?>">
</div>

<div class="debug_plugin">
    <?php foreach ($module_data as $n => $module): ?>
        <div class='debug_plugin_parts <?= $h($module['name']) ?> <?= $h($module['disabled'] ? 'disabled' : '') ?>' data-module-class="<?= $h($module['class']) ?>">
            <div class='debug_plugin_switch' style='background-color:<?= $h($module['color']) ?>;left:<?= $n * 20 ?>px'>
                <span class='debug_plugin_count'><?= $h($module['count']) ?></span>
                <span class='debug_plugin_title'>
                    <?= $h($module['name']) ?>
                    <span><?= $h(implode(',', $module['error'])) ?> </span>
                </span>
            </div>
            <div class='debug_plugin_wrap'>
                <h1 class='debug_plugin_wrap_head'>
                    <?= $h($module['name']) ?>
                    <label>
                        <input type='checkbox' name="enable" class='debug_plugin_setting' <?= $h($module['disabled'] ? '' : 'checked') ?> />
                        有効
                    </label>
                    <div style="float: right">
                        <a class="close">×</a>
                    </div>
                </h1>
                <div class='debug_plugin_wrap_body'><?= $module['html'] ?></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
