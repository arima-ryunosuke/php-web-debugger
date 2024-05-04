<?php
namespace ryunosuke\WebDebugger\Module;

use ryunosuke\WebDebugger\GlobalFunction;
use ryunosuke\WebDebugger\Html\ArrayTable;
use ryunosuke\WebDebugger\Html\Raw;
use function ryunosuke\WebDebugger\file_list;

class Directory extends AbstractModule
{
    private $directries = [];

    public function prepareInner()
    {
        return '
            <script>
                $(function() {
                    $(document).on("click", ".deletedirfile", function() {
                        var $this = $(this);
                        $.post("deletedirfile", {
                            fullpath: $this.data("fullpath"),
                        }).done(function(response, text, jqXHR) {
                            $this.closest("tr").remove();
                        }).fail(function() {
                            console.log(arguments);
                            alert("failed. see console");
                        });
                    });
                    $(document).on("click", ".cleardirfile", function() {
                        var $this = $(this);
                        $.post("cleardirfile", {
                            dirname: $this.parent().find(".dirname").text(),
                        }).done(function(response, text, jqXHR) {
                            $this.closest("table").find("tbody tr").remove();
                        }).fail(function() {
                            console.log(arguments);
                            alert("failed. see console");
                        });
                    });
                });
            </script>
        ';
    }

    protected function _initialize(array $directries = [])
    {
        /**
         * 漁るディレクトリ
         *
         * - list: 表示するかの bool を返すクロージャを指定する
         *   - デフォルトは隠しファイル以外
         * - head: 一覧の際のサマリ文字列を返すクロージャを指定する
         *   - デフォルトは先頭 128 バイト
         */
        foreach ($directries as $dirname => $callback) {
            $dirname = realpath($dirname);
            if ($dirname) {
                $callback += [
                    'list' => fn($path) => basename($path)[0] !== '.',
                    'head' => fn($path) => file_get_contents($path, false, null, 0, 128),
                ];
                $this->directries[realpath($dirname)] = $callback;
            }
        }
    }

    protected function _finalize()
    {
        $this->directries = [];
    }

    protected function _hook(array $request)
    {
        if ($request['is_ajax'] && strpos($request['path'], 'deletedirfile') !== false) {
            unlink($_POST['fullpath']);
            return GlobalFunction::response("ok");
        }

        if ($request['is_ajax'] && strpos($request['path'], 'cleardirfile') !== false && isset($this->directries[$_POST['dirname']])) {
            $callback = $this->directries[$_POST['dirname']];
            foreach (file_list($_POST['dirname'], ['relative' => false]) as $fullpath) {
                if ($callback['list']($fullpath)) {
                    unlink($fullpath);
                }
            }
            return GlobalFunction::response("ok");
        }
    }

    protected function _gather(array $request)
    {
        $data = [];
        foreach ($this->directries as $dirname => $callback) {
            $data[$dirname] = [];
            foreach (file_list($dirname, ['relative' => true]) as $subpath) {
                $fullpath = $dirname . DIRECTORY_SEPARATOR . $subpath;
                if ($callback['list']($fullpath)) {
                    $data[$dirname][$fullpath] = [
                        'path'  => $subpath,
                        'head'  => $callback['head']($fullpath),
                        'size'  => filesize($fullpath),
                        'mtime' => date('Y/m/d H:i:s', filemtime($fullpath)),
                    ];
                }
            }
        }
        return $data;
    }

    protected function _getCount($stored): ?int
    {
        return array_sum(array_map('count', $stored) ?: [0]);
    }

    protected function _getHtml($stored): string
    {
        $result = [];
        foreach ($stored as $dirname => $files) {
            $data = [];
            foreach ($files as $fullpath => $file) {
                $file[''] = new Raw('<button type="button" class="deletedirfile" data-fullpath=' . htmlspecialchars($fullpath, ENT_QUOTES) . '>delete</button>');
                $data[] = $file;
            }
            $caption = new Raw('<span class="dirname">' . htmlspecialchars($dirname, ENT_QUOTES) . '</span>' . '<button type="button" class="cleardirfile" style="float:right">clear</button>');
            $result[] = new ArrayTable($caption, $data);
        }
        return implode('', $result);
    }
}
