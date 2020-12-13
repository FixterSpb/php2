<?php

    if (!function_exists('array_get')){
        function array_get(array $arr, $key, $default = null){
            return isset($arr[$key]) && $arr[$key] ? htmlspecialchars(strip_tags($arr[$key])) : $default;
        }

    }

    if (!function_exists('vdd')){
        function vdd(...$args){
            foreach ($args as $value){
                var_dump($value);
            }
            die;
        }
    }
