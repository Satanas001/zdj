<?php
namespace App ;

class Autoloader
{
    static function register()
    {
        spl_autoload_register([
            __CLASS__, 
            'autoload'
        ]) ;
    }

    static function autoload($class)
    {
        // $class contains the entire namespace of the class
        // Suppression of « App\ » in $class
        $class = str_replace(__NAMESPACE__ . '\\', '', $class) ;

        // Replacing « \ » with « / » in $class
        $class = str_replace('\\', '/', $class) ;
        
        // Creation of the filename of the class
        $file = __DIR__ . '/' . $class . '.php' ;
        
        if (file_exists($file)) {
            require_once $file ;
        }
    }
}