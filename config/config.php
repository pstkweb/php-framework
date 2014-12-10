<?php
define("BASE_RELATIVE", '/YOUR_FOLDER/');
define("BASE_FILE", $_SERVER['DOCUMENT_ROOT'] . "/YOUR_FOLDER/");
define("BASE_URL", 'http://localhost/YOUR_FOLDER/');

spl_autoload_register(function($class){
    $components = explode("\\", $class);

    $vendor = array_shift($components);
    $path = 'modele/';

    if ($vendor == "Spyc") {
        $file = $vendor;
        $dirs = "Externals/";
    } else {
        $file = array_pop($components);
        $dirs = implode('/', $components) . '/';
    }

    if (is_file("{$path}{$dirs}{$file}.php")) {
        require_once "{$path}{$dirs}{$file}.php";
    } else {
        throw new \Exception("Fichier {$path}{$dirs}{$file}.php introuvable pour {$class}.");
    }
});
