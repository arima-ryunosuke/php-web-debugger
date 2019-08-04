<?php
namespace ryunosuke\WebDebugger\Module;

use ryunosuke\WebDebugger\Html\ArrayTable;
use ryunosuke\WebDebugger\Html\HashTable;

class Smarty extends AbstractModule
{
    /** @var \Smarty */
    private $smarty;

    /** @var \stdClass */
    private $backup;

    /** @var callable */
    private $template_provider;

    /** @var callable */
    private $variable_provider;

    protected function _initialize(array $options = [])
    {
        $options = array_replace_recursive([
            /** \Smarty Smarty インスタンス */
            'smarty'             => null,
            /**
             * bool debugging の自動設定フラグ
             *
             * $smarty->debugging = true にすると付属のデバッギングコンソールが起動するが、個人的にあまり好きではない。
             * 消したいんだが、 $smarty->debugging = false にすると今度はコンパイル履歴が取られなくなる。
             * ので debug.tpl を差し替えて表示されないようにすると同時に debugging を true にする。
             * これはそれをやるかどうかのフラグ。
             */
            'auto_debugging'     => true,
            /**
             * callable テンプレートマッピング提供クロージャ
             *
             * Smarty 3.1.23 未満は \Smarty_Internal_Debug::$template_data で取得できる。
             * Smarty 3.1.29 未満は \Smarty_Internal_Debug::$template_data で取得できる。ただし配列構造が異なる。
             * Smarty 3.1.29 以降は $smarty->_debug で取得できる。
             *
             * このように Smarty の内部構造は結構頻繁に変更されるので、その保険的な意味合いでオプションで注入できるようにしている。
             * 基本的には null で問題ない。
             */
            'templates_provider' => null,
            /** callable 変数提供クロージャ */
            'variables_provider' => null,
        ], $options);

        $this->smarty = $options['smarty'];

        if (!$this->smarty instanceof \Smarty) {
            throw new \InvalidArgumentException('"smarty" is not Smarty.');
        }

        if ($options['auto_debugging']) {
            $this->backup = new \stdClass();
            $this->backup->debugging = $this->smarty->debugging;
            $this->backup->debug_tpl = $this->smarty->debug_tpl;
            $this->smarty->debugging = true;
            $this->smarty->debug_tpl = __DIR__ . '/Smarty/debug.tpl';
        }

        if (!is_callable($options['templates_provider'])) {
            $version = vsprintf('%01d%02d%03d', explode('.', \Smarty::SMARTY_VERSION));
            // @codeCoverageIgnoreStart
            if ($version < 301023) {
                $options['templates_provider'] = function (\Smarty $smarty) {
                    $tpls = [];
                    /** @noinspection PhpUndefinedFieldInspection */
                    foreach (\Smarty_Internal_Debug::$template_data as $key => $vals) {
                        $tpls[] = [
                            'key'          => $key,
                            'file'         => $vals['name'],
                            'compile_time' => $vals['compile_time'],
                            'render_time'  => $vals['render_time'],
                            'cache_time'   => $vals['cache_time'],
                        ];
                    }
                    return $tpls;
                };
            }
            elseif ($version < 301029) {
                $options['templates_provider'] = function (\Smarty $smarty) {
                    $tpls = [];
                    /** @noinspection PhpUndefinedFieldInspection */
                    foreach (\Smarty_Internal_Debug::$template_data as $data) {
                        foreach ($data as $key => $vals) {
                            $tpls[] = [
                                'key'          => $key,
                                'file'         => $vals['name'],
                                'compile_time' => $vals['compile_time'],
                                'render_time'  => $vals['render_time'],
                                'cache_time'   => $vals['cache_time'],
                            ];
                        }
                    }
                    return $tpls;
                };
            }
            // @codeCoverageIgnoreEnd
            else {
                $options['templates_provider'] = function (\Smarty $smarty) {
                    $_debug = $smarty->_debug;
                    if (!$_debug) {
                        return [];
                    }
                    $tpls = [];
                    foreach ($_debug->template_data as $data) {
                        foreach ($data as $key => $vals) {
                            $tpls[] = [
                                'key'          => $key,
                                'file'         => $vals['name'],
                                'compile_time' => $vals['compile_time'],
                                'render_time'  => $vals['render_time'],
                                'cache_time'   => $vals['cache_time'],
                                'total_time'   => $vals['total_time'],
                            ];
                        }
                    }
                    return $tpls;
                };
            }
        }

        if (!is_callable($options['variables_provider'])) {
            $options['variables_provider'] = function (\Smarty $smarty) {
                // @codeCoverageIgnoreStart
                $variables = (array) $smarty->getTemplateVars();
                // Smarty は割りとアグレッシブに変更を加えてくるので isset しておく
                if (isset($smarty->template_objects)) {
                    foreach ($smarty->template_objects as $tobject) {
                        // Smarty は割りとアグレッシブに（略
                        if ($tobject instanceof \Smarty_Internal_Data) {
                            $variables += (array) $tobject->getTemplateVars(null, null, false);
                        }
                    }
                }
                return $variables;
                // @codeCoverageIgnoreEnd
            };
        }

        $this->template_provider = $options['templates_provider'];
        $this->variable_provider = $options['variables_provider'];
    }

    protected function _finalize()
    {
        if ($this->backup instanceof \stdClass) {
            $this->smarty->debugging = $this->backup->debugging;
            $this->smarty->debug_tpl = $this->backup->debug_tpl;
        }
    }

    protected function _gather()
    {
        return [
            'Templates' => call_user_func($this->template_provider, $this->smarty),
            'Variables' => call_user_func($this->variable_provider, $this->smarty),
        ];
    }

    protected function _render($stored)
    {
        foreach ($stored['Templates'] as &$tpl) {
            $tpl['line'] = 1;
            $tpl = $this->toOpenable($tpl);
            unset($tpl['line']);
        }
        return [
            'Templates' => new ArrayTable('Templates', $stored['Templates']),
            'Variables' => new HashTable('Variables', $stored['Variables']),
        ];
    }
}
