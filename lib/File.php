<?php 

/**
* 
*/

namespace lib;


class File
{
	
	public static $_ROOT;
    public static $_WEBROOT;
    public static $_WEBROOT_LINK;

	public static function init(){
		self::$_ROOT = App::$_ROOT;
		self::$_WEBROOT = App::$_WEBROOT;
		self::$_WEBROOT_LINK = App::$_WEBROOT_LINK;
	}

    public static function file($path){
        $inc = self::$_ROOT. $path;
        if (file_exists($inc) && is_readable($inc)) {

            return $inc;

        } else {   
            
            echo ('file ['.$inc.'] does not exists or is not readable.');
            //throw new \Exception('require file ['.$inc.'] does not exists or is not readable.');
            die();
        }
    }

	public static function req_file($path){
        $inc = self::$_ROOT. $path;
        if (file_exists($inc) && is_readable($inc)) {

            return require_once($inc);

        } else {   
            
            echo ('require file ['.$inc.'] does not exists or is not readable.');
            //throw new \Exception('require file ['.$inc.'] does not exists or is not readable.');
            die();
        }
    }

    public static function inc_file($path){
        $inc = self::$_ROOT. $path;
        if (file_exists($inc) && is_readable($inc)) {

            return include_once($inc);

        } else {   
            
            echo ('include file ['.$inc.'] does not exists or is not readable.');
            //throw new \Exception('fg require file ['.$inc.'] does not exists or is not readable.');
            die();
        }
    }
}