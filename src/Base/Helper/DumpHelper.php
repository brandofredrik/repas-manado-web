<?php

if (!function_exists('dd')) {
    function dd($string)
    {
        echo '<pre>';
        var_dump($string);
        die();
        echo '</pre>';
    }
}

if (!function_exists('dd_json')) {
    function dd_je($string)
    {
        var_dump(json_encode($string));
        die();
    }
}