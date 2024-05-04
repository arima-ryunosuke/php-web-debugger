<?php
namespace ryunosuke\WebDebugger\Module;

use ryunosuke\WebDebugger\Html\ArrayTable;
use ryunosuke\WebDebugger\Html\Raw;
use function ryunosuke\WebDebugger\file_set_contents;

class History extends AbstractModule
{
    private $historyfile;

    private $maxlength;

    protected function _initialize(array $options = [])
    {
        $options = array_replace_recursive([
            /** string 履歴の保存ファイル */
            'historyfile' => sys_get_temp_dir() . '/wd-module/History/history.jsons',
            /** int 履歴の保存数 */
            'maxlength'   => 99,
        ], $options);

        $this->historyfile = $options['historyfile'];
        $this->maxlength = $options['maxlength'];
    }

    public function prepareInner()
    {
        return '
            <style>
                .debug_plugin_parts.History [name=historyrow] {
                    cursor: pointer;
                }
            </style>
            <script>
                $(function() {
                    $(document).on("change", ".debug_plugin_parts.History input[name=historyrow]", function() {
                        var $this = $(this);
                        $.get($this.val(), function(response) {
                            var thisPlugin = $(response).filter(".debug_plugin");
                            thisPlugin.find(".debug_plugin_parts.History").replaceWith($this.closest(".debug_plugin_parts.History"));
                            $(".debug_plugin").eq(0).replaceWith(thisPlugin.addClass("historied"));
                        });
                    });
                });
            </script>
        ';
    }

    protected function _gather()
    {
        $request = func_get_arg(0); // for compatible

        $files = file_exists($this->historyfile) ? file($this->historyfile, FILE_IGNORE_NEW_LINES) : [];
        $files[] = json_encode([
            'time'   => $request['time'],
            'method' => $request['method'],
            'url'    => $request['url'],
            'file'   => $request['workpath'],
        ]);
        $files = array_slice($files, -$this->maxlength);
        file_set_contents($this->historyfile, implode("\n", $files) . "\n");

        return [
            'History' => array_map(function ($json) { return json_decode($json, true); }, $files),
        ];
    }

    protected function _getCount($stored)
    {
        return count($stored['History']);
    }

    protected function _render($stored)
    {
        $histories = [];
        foreach (array_reverse($stored['History']) as $history) {
            $first = !isset($first);
            $histories[] = [
                ''         => new Raw('<label><input type="radio" name="historyrow" value="' . htmlspecialchars($history['file'], ENT_QUOTES) . '" ' . ($first ? ' checked' : '') . '></label>'),
                'datetime' => date('Y/m/d H:i:s', (int) $history['time']),
                'method'   => $history['method'],
                'url'      => $history['url'],
            ];
        }

        return new ArrayTable('history', $histories);
    }
}
