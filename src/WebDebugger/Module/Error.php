<?php
namespace ryunosuke\WebDebugger\Module;

use ryunosuke\WebDebugger\Html\ArrayTable;
use ryunosuke\WebDebugger\Html\Popup;
use ryunosuke\WebDebugger\Html\Raw;
use function ryunosuke\WebDebugger\backtrace;

class Error extends AbstractModule
{
    /** @var bool devtools 出力フラグ */
    private $console;

    /** @var \stdClass エラーホルダ */
    private $errorHolder;

    /** @var \stdClass 例外ホルダ */
    private $exceptionHolder;

    public function __construct()
    {
        parent::__construct();

        // devtools
        $this->console = true;

        // エラーホルダ
        $this->errorHolder = new \stdClass();
        $this->errorHolder->errors = [];

        // 例外ホルダ
        $this->exceptionHolder = new \stdClass();
        $this->exceptionHolder->getter = null;
        $this->exceptionHolder->exceptions = [];
    }

    protected function _initialize(array $options = [])
    {
        $options = array_replace_recursive([
            /**
             * エラー通知を console にも出力するか
             *
             * true にすると devtools のコンソールにも出力される。
             * ハンドリングしている関係上、アイコンでしかエラーが分からずスルーされてしまうことが多いので、devtools に出せば多少気づきやすくなる。
             */
            'js_console'       => true,
            /**
             * bool デフォルトハンドラを抑制するか
             *
             * true にするとデフォルトハンドラが無効になり、画面へエラー表示が為されなくなる。
             * これは ajax 時に変な出力でレスポンスが失敗するのを防ぐことを意図しているが、通常は false にしたほうが良い。
             */
            'no_default'       => true,
            /**
             * callable|null 例外取得コールバック
             *
             * 未指定時は set_exception_handler で捕捉される。
             * 大抵のフレームワークには例外ハンドリング機構がありフレームワーク内で完結しているため、このモジュールへ例外が流れ着くことはない。
             * ただ、大抵の場合ハンドリングした例外を取得する方法が提供されているので、exception_getter にそれを返す callable を設定することでフレームワークが補足した例外をこのモジュールへ流すことが可能になる。
             */
            'exception_getter' => null,
        ], $options);

        $this->console = $options['js_console'];

        $this->errorHolder->default = $options['no_default'];
        $this->exceptionHolder->getter = $options['exception_getter'];

        // エラーハンドラ登録
        $this->errorHolder->already = set_error_handler([$this, 'errorHandler']);

        // 例外ハンドラ登録
        $this->exceptionHolder->already = null;
        if (!$this->exceptionHolder->getter) {
            $this->exceptionHolder->already = set_exception_handler([$this, 'exceptionHandler']);
        }
    }

    protected function _finalize()
    {
        // エラーハンドラ復元
        restore_error_handler();

        // 例外ハンドラ復元
        if (!$this->exceptionHolder->getter) {
            restore_exception_handler();
        }
    }

    public function errorHandler($level, $message, $file, $line)
    {
        // 既存のハンドラがあるなら呼んでおく
        if (is_callable($this->errorHolder->already)) {
            call_user_func_array($this->errorHolder->already, func_get_args());
        }
        // @付きの場合は 0 になるので無視する
        if (!(error_reporting() & $level)) {
            return false;
        }

        $namemap = [
            E_ERROR             => 'ERROR',
            E_WARNING           => 'WARNING',
            E_PARSE             => 'PARSE',
            E_NOTICE            => 'NOTICE',
            E_CORE_ERROR        => 'CORE ERROR',
            E_CORE_WARNING      => 'CORE WARNING',
            E_COMPILE_ERROR     => 'COMPILE ERROR',
            E_COMPILE_WARNING   => 'COMPILE WARNING',
            E_USER_ERROR        => 'USER ERROR',
            E_USER_WARNING      => 'USER WARNING',
            E_USER_NOTICE       => 'USER NOTICE',
            E_STRICT            => 'STRICT NOTICE',
            E_RECOVERABLE_ERROR => 'RECOVERABLE ERROR',
            E_DEPRECATED        => 'DEPRECATED',
            E_USER_DEPRECATED   => 'USER DEPRECATED',
        ];
        $level = $namemap[$level];

        $trace = backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, [
            'offset' => 2,
            'file'   => true,
        ]);

        $this->errorHolder->errors[] = compact('file', 'line', 'level', 'message', 'trace');

        return $this->errorHolder->default;
    }

    /**
     * @param \Exception $ex
     */
    public function exceptionHandler($ex)
    {
        // 既存のハンドラがあるなら呼んでおく
        // @codeCoverageIgnoreStart
        if (is_callable($this->exceptionHolder->already)) {
            call_user_func_array($this->exceptionHolder->already, func_get_args());
        }
        // @codeCoverageIgnoreEnd

        $exceptions = [];
        do {
            $exceptions[] = [
                'file'    => $ex->getFile(),
                'line'    => $ex->getLine(),
                'class'   => get_class($ex),
                'message' => $ex->getMessage(),
                'code'    => $ex->getCode(),
                'trace'   => array_map(function ($trace) {
                    // 大きくなりがちなので明示的に伏せる
                    unset($trace['args']);
                    return $trace;
                }, $ex->getTrace()),
            ];
        } while ($ex = $ex->getPrevious());
        $this->exceptionHolder->exceptions = array_reverse($exceptions);
    }

    protected function _gather(array $request): array
    {
        // set_exception_handler を使ってないならここで取得
        if ($this->exceptionHolder->getter) {
            $ex = call_user_func($this->exceptionHolder->getter);
            if ($ex instanceof \Exception) {
                $this->exceptionHandler($ex);
            }
        }

        $error_summary = '';
        if ($this->errorHolder->errors) {
            $error_summary = " (" . count($this->errorHolder->errors) . " errors)";
        }
        $ex_summary = '';
        if ($this->exceptionHolder->exceptions) {
            $ex_summary = " (" . count($this->exceptionHolder->exceptions) . " exceptions)";
        }

        return [
            'Error'     => [
                'summary' => $error_summary,
                'data'    => $this->errorHolder->errors,
            ],
            'Exception' => [
                'summary' => $ex_summary,
                'data'    => $this->exceptionHolder->exceptions,
            ],
        ];
    }

    protected function _getCount($stored): ?int
    {
        return count($stored['Error']['data']) + ($stored['Exception']['data'] ? 1 : 0);
    }

    protected function _getError($stored): array
    {
        $result = [];
        if ($c = count($stored['Error']['data'])) {
            $result[] = "has $c error";
        }
        if ($c = count($stored['Exception']['data'])) {
            $result[] = "has $c exception";
        }
        return $result;
    }

    protected function _getHtml($stored): string
    {
        $result = [];

        if ($this->console) {
            $result['Console'] = '<script>';
            if (count($stored['Error']['data'])) {
                $result['Console'] .= '(window.parent ?? window).console.error(' . json_encode($stored['Error']['summary']) . ');';
                $result['Console'] .= '(window.parent ?? window).console.table(' . json_encode($stored['Error']['data']) . ', ' . json_encode(['file', 'line', 'level', 'message']) . ');';
            }
            if (count($stored['Exception']['data'])) {
                $result['Console'] .= '(window.parent ?? window).console.error(' . json_encode($stored['Exception']['summary']) . ');';
                $result['Console'] .= '(window.parent ?? window).console.table(' . json_encode($stored['Exception']['data']) . ');';
            }
            $result['Console'] .= '</script>';
        }

        foreach ($stored as $category => $data) {
            foreach ($data['data'] as &$row) {
                $row['trace'] = array_map([$this, 'toOpenable'], $row['trace']);
                $table = new ArrayTable('', $row['trace']);
                $row['trace'] = new Popup('trace', $table);
            }
            $caption = new Raw('<pre>' . htmlspecialchars($category . $data['summary'], ENT_QUOTES) . '</pre>');
            $result[$category] = new ArrayTable($caption, array_map([$this, 'toOpenable'], $data['data']));
        }
        return implode('', $result);
    }
}
