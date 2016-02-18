<?php
namespace lib;

class Autoloader
{
    /**
     * Enregistrer notre autoloader
     */
    static function register(){
        spl_autoload_register(array(__CLASS__,'autoload'));
    }

    /**
     * Inclure le fichier correspondant à notre classe
     * @param $class string (le nom de la classe à inclure)
     */
    static function autoload($class){
        $prefix = __NAMESPACE__ . '\\';
        if(strpos($class,$prefix) !==0) return;

        /* Remove prefix */
        $class = str_replace($prefix,'', $class);
        /* Change "\" to "/" */
        $class = str_replace('\\', '/', $class);
        $file = dirname(__FILE__) .'/'. $class . '.php';
        if (is_file($file)) {
            require_once($file);
        }
    }

}