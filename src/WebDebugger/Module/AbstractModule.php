<?php
namespace ryunosuke\WebDebugger\Module;

use ryunosuke\WebDebugger\Html\Raw;

abstract class AbstractModule
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $color;

    /** @var bool */
    protected $disabled = false;

    /** @var array */
    protected $setting = [];

    /**
     * メソッドチェーンしたいのでビルダを定義
     *
     * @param string $name
     * @return static
     */
    public static function getInstance($name = null)
    {
        $instance = new static();

        if ($name) {
            $instance->name = $name;
        }

        return $instance;
    }

    /**
     * コンストラクタ
     *
     * $name, $color が設定されていないならクラス名に基づいて適当に設定する。
     */
    public function __construct()
    {
        $class = get_class($this);

        if (!isset($this->name)) {
            $this->name = \ryunosuke\WebDebugger\class_shorten($class);
        }
        if (!isset($this->color)) {
            $this->color = '#' . substr(md5($class), 0, 6);
        }
    }

    /**
     * モジュールの名前を返す
     *
     * 名前はキーとしても使われるので他のモジュールと重複してはならない。
     *
     * @return string
     */
    public function getName() { return $this->name; }

    /**
     * モジュールの色を返す
     *
     * @return string
     */
    public function getColor() { return $this->color; }

    /**
     * 無効状態か返す
     *
     * @return bool
     */
    public function isDisabled() { return !!$this->disabled; }

    /**
     * 無効状態にする
     *
     * @return bool
     */
    public function disable() { return $this->disabled = true; }

    /**
     * 共通（iframe外側）部分で何か定義したいときはそれを返すように定義する
     *
     * @return string html
     */
    public function prepareOuter() { return ""; }

    /**
     * 共通（iframe内側）部分で何か定義したいときはそれを返すように定義する
     *
     * @return string html
     */
    public function prepareInner() { return ""; }

    /**
     * モジュールの初期化
     *
     * @param array|\Closure $options
     * @return $this
     */
    public final function initialize($options = [])
    {
        if ($this->isDisabled()) {
            return $this;
        }
        if ($options instanceof \Closure) {
            $options = $options();
        }
        $this->_initialize($options);
        return $this;
    }

    protected function _initialize(array $options) { }

    /**
     * モジュールの後処理
     */
    public final function finalize()
    {
        if ($this->isDisabled()) {
            return $this;
        }
        $this->_finalize();
        return $this;
    }

    protected function _finalize() { }

    /**
     * 個別セッティング
     *
     * initialize による静的な設定ではなく COOKIE による動的な設定ができる。
     *
     * @param array $setting
     */
    public final function setting($setting)
    {
        if ($this->isDisabled()) {
            return;
        }
        $this->setting = $setting;
        $this->_setting();
    }

    protected function _setting() { }

    /**
     * リクエスト時に必ず通るメソッド
     *
     * 条件チェックさえすれば何をしても構わない。
     *
     * @param array $request
     */
    public final function fook(array $request)
    {
        if ($this->isDisabled()) {
            return;
        }
        return $this->_fook($request);
    }

    protected function _fook(array $request) { }

    /**
     * モジュールの情報を返す
     */
    public final function gather()
    {
        if ($this->isDisabled()) {
            return [];
        }
        return $this->_gather();
    }

    protected function _gather() { }

    /**
     * エラーを返す
     *
     * @param array $stored gather の返り値
     * @return string
     */
    public final function getError($stored)
    {
        if ($this->isDisabled()) {
            return;
        }
        return implode(",", \ryunosuke\WebDebugger\arrayize($this->_getError($stored)));
    }

    protected function _getError($stored) { }

    /**
     * html を返す
     *
     * @param array $stored gather の返り値
     * @return string
     */
    public final function render($stored)
    {
        if ($this->isDisabled()) {
            return;
        }
        return implode("", \ryunosuke\WebDebugger\arrayize($this->_render($stored)));
    }

    protected function _render($stored) { }

    /**
     * Console 用配列を返す
     *
     * @param array $stored gather の返り値
     * @return array|null null の時は http ヘッダを送出しない
     */
    public final function console($stored)
    {
        if ($this->isDisabled()) {
            return null;
        }
        return (array) $this->_console($stored);
    }

    protected function _console($stored) { }

    /**
     * パスを開く列を追加する
     *
     * @param array $array
     * @return array
     */
    protected function toOpenable($array)
    {
        if (!is_array($array) || !isset($array['file'], $array['line'])) {
            return $array;
        }
        $href = htmlspecialchars(http_build_query([
            'file' => $array['file'],
            'line' => $array['line'],
        ]), ENT_QUOTES);
        $title = htmlspecialchars($array['file'] . '#' . $array['line'], ENT_QUOTES);
        $appendix = [
            '' => new Raw("<a href='javascript:void(0)' data-href='$href' title='$title'>*</a>"),
        ];
        return $appendix + $array;
    }
}
