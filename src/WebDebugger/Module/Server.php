<?php
namespace ryunosuke\WebDebugger\Module;

use ryunosuke\WebDebugger\GlobalFunction;
use ryunosuke\WebDebugger\Html\HashTable;
use ryunosuke\WebDebugger\Html\Raw;
use function ryunosuke\WebDebugger\get_uploaded_files;

class Server extends AbstractModule
{
    public function prepareInner()
    {
        return '
            <style>
                button.phpinfo {
                    background-color: #99c;
                    color: #009;
                    font-weight: bold;
                    padding: 0 6px;
                }
                .phpinfo_area table th, .phpinfo_area table td {
                    font-size: 100%;
                }
            </style>
            <script>
                $(function() {
                    $(document).on("click", ".phpinfo", function() {
                        var $this = $(this);
                        if ($this.hasClass("done")) {
                            $this.next(".phpinfo_area").html("");
                            $this.removeClass("done");
                        }
                        else {
                            $.post("phpinfo", function(response) {
                                $this.next(".phpinfo_area").html(response);
                                $this.addClass("done");
                            }, "html");
                        }
                    });
                    $(document).on("click", ".savesession", function() {
                        $.post("savesession", {
                            session: $("#session-data").val()
                        }).done(function(response, text, jqXHR) {
                            // done は成功失敗の判断ができない（使用側で200を返すかもしれない）のでヘッダで判断
                            if (jqXHR.getResponseHeader("X-Session-Invalid")) {
                                alert(response);
                                return;
                            }
                            window.parent.location.reload();
                        }).fail(function(){
                            // fail は使用側でスルーされたということだからすべて reload で良い
                            window.parent.location.reload();
                        });
                    });
                });
            </script>
        ';
    }

    protected function _hook(array $request)
    {
        if ($request['is_ajax'] && strpos($request['path'], 'phpinfo') !== false) {
            ob_start();
            phpinfo();
            $phpinfo = ob_get_clean();
            return GlobalFunction::response(new Raw($phpinfo));
        }

        if ($request['is_ajax'] && strpos($request['path'], 'savesession') !== false) {
            $sdata = $_POST['session'];
            $newsession = json_decode($sdata, true);
            if (!is_array($newsession)) {
                GlobalFunction::header('X-Session-Invalid: 1');
                return GlobalFunction::response(sprintf('json format is invalid (%s).', $sdata));
            }
            // セッションが始まっていないかもしれないのでヘッダーコールバックで行う
            header_register_callback(function () use ($newsession) {
                // @codeCoverageIgnoreStart
                // 逆に session_write_close でセッションが終わっているかもしれないので restart する
                $status = session_status() === PHP_SESSION_NONE;
                if ($status) {
                    session_start();
                }
                if (isset($_SESSION)) {
                    $_SESSION = $newsession;
                }
                if ($status) {
                    session_write_close();
                }
                // @codeCoverageIgnoreEnd
            });
            return true;
        }
    }

    protected function _gather(array $request): array
    {
        return [
            'GET'            => $_GET,
            'POST'           => $_POST,
            'FILES'          => get_uploaded_files($_FILES),
            'COOKIE'         => $_COOKIE,
            'SESSION(param)' => session_get_cookie_params(),
            'SESSION(data)'  => $_SESSION ?? [],
            'SERVER'         => $_SERVER,
        ];
    }

    protected function _getError($stored): array
    {
        $result = [];
        if (array_intersect_key($stored['GET'], $stored['POST'])) {
            $result[] = "has same key";
        }
        if (isset($stored['SERVER']['HTTPS']) && $stored['SERVER']['HTTPS'] === 'on') {
            if (!$stored['SESSION(param)']['secure']) {
                $result[] = 'has vulnerability (also sent by http)';
            }
        }
        return $result;
    }

    protected function _getCount($stored): ?int
    {
        return count($this->_getError($stored));
    }

    protected function _getHtml($stored): string
    {
        $errors = array_intersect_key($stored['GET'], $stored['POST']);
        foreach ($errors as $key => $val) {
            $errors['GET'][$key] = 'color:red';
            $errors['POST'][$key] = 'color:red';
        }
        if (isset($stored['SERVER']['HTTPS']) && $stored['SERVER']['HTTPS'] === 'on') {
            if (!$stored['SESSION(param)']['secure']) {
                $errors['SESSION(param)']['secure'] = 'color:red';
            }
        }

        $result = [
            new Raw('<button type="button" class="phpinfo">phpinfo</button><div class="phpinfo_area"></div>'),
        ];
        foreach ($stored as $category => $data) {
            if ($category === 'SESSION(data)') {
                $sdata = htmlspecialchars(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                $h = substr_count($sdata, "\n") * 16.8;
                $result[$category] = new Raw("<table class='debug_table' style='width:100%'>
                    <caption>
                        {$category}
                        <button type='button' class='savesession' style='float:right'>save</button>
                    </caption>
                    <tr>
                        <td><textarea id='session-data' style='line-height:16.8px;width:100%;height:{$h}px;' spellcheck='false'>$sdata</textarea></td>
                    </tr>
                </table>");
            }
            else {
                $result[$category] = new HashTable($category, $data, isset($errors[$category]) ? $errors[$category] : []);
            }
        }
        return implode('', $result);
    }
}
