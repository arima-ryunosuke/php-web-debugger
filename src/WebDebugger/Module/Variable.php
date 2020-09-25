<?php
namespace ryunosuke\WebDebugger\Module;

use ryunosuke\WebDebugger\Html\ArrayTable;
use ryunosuke\WebDebugger\Html\HashTable;

class Variable extends AbstractModule
{
    private $provider = [];

    protected function _initialize(array $options = [])
    {
        $this->provider = $options;
    }

    protected function _gather()
    {
        $data = [];
        foreach ($this->provider as $name => $provider) {
            if ($provider instanceof \Closure) {
                $provider = $provider();
            }

            $data[$name] = $provider;
        }
        return $data;
    }

    protected function _getCount($stored)
    {
        return array_sum(array_map('count', $stored));
    }

    protected function _render($stored)
    {
        $result = [];
        $others = [];
        foreach ($stored as $name => $data) {
            switch ($this->detectType($data)) {
                default:
                    $others[$name] = $data;
                    break;

                case 'array':
                    $result[$name] = new ArrayTable($name, $data);
                    break;

                case 'hash':
                    $result[$name] = new HashTable($name, $data);
                    break;
            }
        }
        if ($others) {
            $result[] = new HashTable('', $others);
        }
        return $result;
    }

    protected function _console($stored)
    {
        $result = [];
        $others = [];
        foreach ($stored as $name => $data) {
            switch ($this->detectType($data)) {
                default:
                    $others[$name] = $data;
                    break;

                case 'array':
                    $result[$name] = ['table' => $data];
                    break;

                case 'hash':
                    $result[$name] = ['hashtable' => $data];
                    break;
            }
        }
        if ($others) {
            $result[''] = ['hashtable' => $others];
        }
        return $result;
    }

    private function detectType($value)
    {
        // iterable なら HashTable か ArrayTable にできる可能性がある
        if (is_iterable($value)) {
            // ただし、空っぽだと何も判断できない
            if (\ryunosuke\WebDebugger\is_countable($value) && count($value) === 0) {
                return null;
            }
            // 連想配列は hash 確定
            if (is_array($value) && \ryunosuke\WebDebugger\is_hasharray($value)) {
                return 'hash';
            }
            // ここまで来たら配列の配列の可能性があるのでキーの共通項をチェックする
            foreach ($value as $v) {
                // キーを得る必要があるので iterable でなければならない
                if (!is_iterable($v)) {
                    return null;
                }
                $v = \ryunosuke\WebDebugger\arrayval($v, false);
                $keys = $keys ?? $v;
                // 共通項が異なるならきっと何らかのごちゃまぜ配列なんだろう
                if (count(array_intersect_key($keys, $v)) !== count($keys)) {
                    return null;
                }
            }
            return 'array';
        }
        return null;
    }
}
