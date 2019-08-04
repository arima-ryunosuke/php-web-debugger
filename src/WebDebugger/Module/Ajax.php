<?php
namespace ryunosuke\WebDebugger\Module;

use ryunosuke\WebDebugger\Html\ArrayTable;
use ryunosuke\WebDebugger\Html\Raw;

class Ajax extends AbstractModule
{
    public function prepareOuter()
    {
        return '
            <script>
                (function() {
                    var complete = function (url) {
                        if (url) {
                            // debugger iframe が完了していない可能性があるので待つ
                            (function waitframe() {
                                var debugFrame = document.getElementById("webdebugger-iframe");
                                if (!debugFrame.completed) {
                                    setTimeout(waitframe, 111);
                                    return;
                                }
                                debugFrame.contentDocument.newRequest(url);
                            })();
                        }
                    };
                    if (typeof($) !== "undefined") {
                        $(document).ajaxComplete(function(e, xhr) {
                            complete(xhr.getResponseHeader("X-Debug-Ajax"));
                        });
                    }
                    if (typeof(window.fetch) !== "undefined") {
                        var _fetch = window.fetch;
                        window.fetch = function(input, init) {
                            if (typeof(init) !== "undefined") {
                                if (init.headers instanceof Headers) {
                                    if (!init.headers.has("X-Requested-With")) {
                                        init.headers.append("X-Requested-With", "fetch");
                                    }
                                }
                                else if (typeof(init.headers) === "undefined") {
                                    init.headers = {"X-Requested-With": "fetch"};
                                }
                                else {
                                    if (!init.headers["X-Requested-With"]) {
                                        init.headers["X-Requested-With"] = "fetch";
                                    }
                                }
                            }
                            return _fetch.call(this, input, init).then(function(response) {
                                complete(response.headers.get("X-Debug-Ajax"));
                            });
                        };
                    }
                })();
            </script>
        ';
    }

    public function prepareInner()
    {
        return '
            <style>
                .debug_plugin.ajaxed {
                    display: none;
                }
                .debug_plugin_parts.Ajax label {
                    cursor: pointer;
                }
            </style>
            <script>
                (function() {
                    var counter = 0;
                    document.newRequest = function (url) {
                        $.get(url, function(response) {
                            counter++;
                            var thisPlugin = $(response).filter(".debug_plugin");
                            var tr = thisPlugin.find(".debug_plugin_parts.Ajax").remove().find(".debug_table tbody tr:first");

                            var toggler = tr.find("input[name=ajaxrow]");
                            toggler.val(counter).removeAttr("checked");
                            $("body").append(thisPlugin.addClass("ajaxed"));
                            $(".debug_plugin_parts.Ajax .debug_table tbody").append(tr);
                            $(".debug_plugin_parts.Ajax .debug_plugin_error").text(counter);
                            if ($(".debug_plugin_parts.Ajax [name=autoswitch]").prop("checked")) {
                                toggler.click();
                            }
                        });
                    };
                })();
                $(function() {
                    $(document).on("change", ".debug_plugin_parts.Ajax input[name=ajaxrow]", function() {
                        var $this = $(this);
                        $(".debug_plugin_parts").hide();
                        $(".debug_plugin_parts.Ajax").show();
                        $(".debug_plugin").eq($this.val()).show().find(".debug_plugin_parts").show();
                    });
                });
            </script>
        ';
    }

    protected function _gather()
    {
        return [
            'datetime' => date('Y/m/d H:i:s'),
            'url'      => $_SERVER['REQUEST_URI'],
            'GET'      => $_GET,
            'POST'     => $_POST,
            'COOKIE'   => $_COOKIE,
        ];
    }

    protected function _render($stored)
    {
        $caption = new Raw('AjaxRequest <label><input name="autoswitch" class="debug_plugin_setting" type="checkbox">autoswitch</label>');
        $stored['url'] = new Raw('<label><input type="radio" name="ajaxrow" value="0" checked>' . $stored['url'] . '</label>');
        return new ArrayTable($caption, [$stored]);
    }
}
