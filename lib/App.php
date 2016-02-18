<?php
/**
 * Design pattern : Factory
 * Permet d'initialiser d'autre class
 */
namespace lib;

class App{

    static $db = null;
    static $_ENV;
    static $_HOSTS;
    static $_HOST_CONF;
    public static $_ROOT;
    public static $_WEBROOT;
    public static $_WEBROOT_LINK;
    public static $_script_path;
    public static $_css_path;
    public static $_assets_path;
    public static $_lang_path;
    public static $_element_path;
    public static $_DB_TYPE = ["mysql"];
    /*static $ROOT;
    static $WEBROOT;*/

    static function getDatabase($params = null){

        
        $db_class = 'lib\\Database\\%sDatabase';

        if(!self::$db){
            $key = array_search(self::$_HOST_CONF['type'], self::$_DB_TYPE);
            if($key === false){
                throw new Exception(sprintf("cant find the type '%s' in database.", self::$_HOST_CONF['type']));
                die("error with the type of database");
            }

            $dbType = sprintf($db_class, self::$_DB_TYPE[$key]);
            self::$db = new $dbType(self::$_HOST_CONF);
        }

        if($params === null)
            return self::$db;
        else{
            $key = array_search($params['type'], self::$_DB_TYPE);
            if($key === false){
                die("error with the type of database");
            }else{
                 $dbType = sprintf($db_class, self::$_DB_TYPE[$key]);
                return new $dbType($params);
            }
        }
    }

    static function config(){

        echo "lol";
    }

    static function getAuth(){
        return new Auth(Session::getInstance(), ['restriction_msg' => "Vous n'avez pas le droit d'accéder à cette page"]);

    }

    static function redirect($page){



        header('Location:' . self::$_WEBROOT_LINK . $page);
        die();
    }

    static function abort($page){
      self::redirect($page);

    }

    static function init(){
        //define ROOT
        $root = dirname(dirname(__FILE__)).'/';
        $root = str_replace('\\', '/', $root);
        self::$_ROOT = $root;
        //define WEBROOT
        $directory = basename($root);
        $url = explode($directory, $_SERVER['REQUEST_URI']);
        if(count($url)==1){
            self::$_WEBROOT = $_SERVER['HTTP_HOST'] . '/';
            self::$_WEBROOT_LINK = "/";

        }else{
            $part = ($url[0] == '/') ? $_SERVER['HTTP_HOST'] . '/' : $_SERVER['HTTP_HOST'].$url[0];
            self::$_WEBROOT = $part . $directory . '/';
            self::$_WEBROOT_LINK = $url[0] . $directory . '/';
        }
        
        self::$_css_path = self::$_WEBROOT_LINK . "app/assets/css";
        self::$_script_path = self::$_WEBROOT_LINK . "app/assets/js";
        self::$_assets_path = self::$_WEBROOT_LINK . "app/assets/";
        self::$_lang_path = self::$_ROOT . "config/locales/";
        self::$_element_path = self::$_ROOT . "app/views/Elements/";

        File::init();

    }

    static function start($host){
        
        self::$_HOSTS = $host;

        //Environment
        $env = array_search(self::$_WEBROOT, $host);
        if($env !== false){
            self::$_ENV = $env;
            $path_config = self::$_ROOT . 'config/database/'.$env.'.php';

            self::$_HOST_CONF = require $path_config;
        }else{
            //throw new \Exception('Current URL dont match any of host in config. The current URL is : ' . ROOT);
            echo ('Current URL dont match any of host in lib/config/config.php. The current URL is : ' . self::$_WEBROOT);
            die();
        }

        $path_env = self::$_ROOT . 'config/environments/'. self::$_ENV .'.php';
        include $path_env;
        Session::getInstance();

    }

}
