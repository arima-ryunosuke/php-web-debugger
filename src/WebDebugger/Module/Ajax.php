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
                    if (typeof(window.XMLHttpRequest) !== "undefined") {
                        var _XMLHttpRequest = window.XMLHttpRequest;
                        window.XMLHttpRequest = function() {
                            var xhr = new _XMLHttpRequest();
                            var _send = xhr.send;
                            xhr.send = function (body) {
                                this.setRequestHeader("X-Debug-Ajax", "xhr");
                                return _send.call(this, body);
                            };
                            xhr.addEventListener("loadend", function(response) {
                                complete(xhr.getResponseHeader("X-Debug-Ajax"));
                            });
                            return xhr;
                        };
                    }
                    if (typeof(window.fetch) !== "undefined") {
                        var _fetch = window.fetch;
                        window.fetch = function(input, init) {
                            if (input instanceof Request) {
                                input.headers.append("X-Debug-Ajax", "fetch");
                            }
                            if (typeof(init) === "undefined") {
                                init = {};
                            }
                            if (init.headers instanceof Headers) {
                                init.headers.append("X-Debug-Ajax", "fetch");
                            }
                            else if (typeof(init.headers) === "undefined") {
                                init.headers = {"X-Debug-Ajax": "fetch"};
                            }
                            else {
                                init.headers["X-Debug-Ajax"] = "fetch";
                            }
                            return _fetch.call(this, input, init).then(function(response) {
                                complete(response.headers.get("X-Debug-Ajax"));
                                return response;
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
                .debug_plugin_parts.Ajax [name=ajaxrow] {
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
                            $(".debug_plugin_parts.Ajax .debug_plugin_count").text(counter);
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

    protected function _gather(array $request): array
    {
        return [
            'datetime' => date('Y/m/d H:i:s'),
            'url'      => $_SERVER['REQUEST_URI'],
            'GET'      => $_GET,
            'POST'     => $_POST,
            'COOKIE'   => $_COOKIE,
        ];
    }

    protected function _getHtml($stored): string
    {
        $caption = new Raw('AjaxRequest <label><input name="autoswitch" class="debug_plugin_setting" type="checkbox">autoswitch</label>');
        $stored = ['' => new Raw('<label><input type="radio" name="ajaxrow" value="0" checked></label>')] + $stored;
        return new ArrayTable($caption, [$stored]);
    }
}
