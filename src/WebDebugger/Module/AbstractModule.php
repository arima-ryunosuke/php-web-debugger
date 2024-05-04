<?php
namespace ryunosuke\WebDebugger\Module;

use ryunosuke\WebDebugger\Html\Raw;
use function ryunosuke\WebDebugger\arrayize;
use function ryunosuke\WebDebugger\class_shorten;

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
            $this->name = class_shorten($class);
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
     * @param array $options
     * @return $this
     */
    public final function initialize(array $options = [])
    {
        if ($this->isDisabled()) {
            return $this;
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
    public final function hook(array $request)
    {
        if ($this->isDisabled()) {
            return;
        }
        return $this->_hook($request);
    }

    protected function _hook(array $request) { }

    /**
     * モジュールの情報を返す
     */
    public final function gather(array $request)
    {
        if ($this->isDisabled()) {
            return [];
        }
        return $this->_gather($request);
    }

    protected function _gather(array $request) { }

    /**
     * info 数を返す
     *
     * @param array $stored gather の返り値
     * @return ?int
     */
    public final function getCount($stored)
    {
        if ($this->isDisabled()) {
            return null;
        }
        return $this->_getCount($stored);
    }

    protected function _getCount($stored) { return null; }

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
        return implode(",", arrayize($this->_getError($stored)));
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
        return implode("", arrayize($this->_render($stored)));
    }

    protected function _render($stored) { }

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
        $href = htmlspecialchars($array['file'] . ':' . $array['line'], ENT_QUOTES);
        $appendix = [
            '' => new Raw("<a href='javascript:void(0)' data-href='$href' title='$href'>*</a>"),
        ];
        return $appendix + $array;
    }
}
