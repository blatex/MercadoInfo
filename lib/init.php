<?php

// Possui toda a inicialização do sistema

//set_include_path(ROOT);
//spl_autoload_extensions('.php');

//spl_autoload_register(function ($className){
//    spl_autoload(strtolower(str_replace("\\", "/", $className)));
//});

set_include_path(ROOT);
spl_autoload_extensions('.php');
spl_autoload_register();


// C:\wamp\www\jornal\config\config.php
require_once ROOT . DS . 'config' . DS . 'config.php';

function __($key, $default = '') {
    return \Lib\Lang::get($key, $default);
}