<?php

function autoload($class)
{
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . "/../lib/$class.php";
    if(file_exists($file)) {
        require_once($file);
        return true;
    }    
}

spl_autoload_register("autoload");
