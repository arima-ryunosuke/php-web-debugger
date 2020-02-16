<?php

if (!function_exists('A')) {
    function A()
    {
        $noop = null;
        return $noop;
    }
}

if (!function_exists('B')) {
    function B()
    {
        $noop = null;
        A();
    }
}

if (!function_exists('C')) {
    function C()
    {
        $noop = null;
        A();
        B();
    }
}

if (!function_exists('X')) {
    function X()
    {
        $noop = null;
        A();
        B();
        C();
    }
}

X();
