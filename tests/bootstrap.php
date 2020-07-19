<?php

$autoload = __DIR__.'/../vendor/autoload.php';

if (! file_exists($autoload)) {
    throw new RuntimeException('Install composer dependencies to run test suite');
}

require_once $autoload;

if (! function_exists('dd')) {
    function dd()
    {
        array_map(function($x) { 
            dump($x); 
        }, func_get_args());
        die;
    }
 }
 