<?php
/**
 * Design pattern : Factory
 * Permet d'initialiser d'autre class
 */
namespace lib;

class i18n{

    public $_langpath;
    public static $_lang;
    public static $_translations;
    public static $_fallback = "en_CA";
    public static $_langs;

    public function __construct($lang){
        $this->setDefault();
        self::$_lang = $lang;

    }

    public function setDefault(){
        $this->_langpath = \lib\App::$_lang_path;
    }

    public function init() {
        if(self::$_lang != "en_CA" && self::$_lang != "fr_CA"){

            $session = \lib\Session::getInstance();
            $session->write("lang", "en_CA");
            self::$_lang = "en_CA";
        }

        $path = $this->_langpath . self::$_lang .".php";
        $langs = glob($this->_langpath . "*.{php}", GLOB_BRACE);
        $listLangs=array();
        foreach($langs as $lang){

            $listLangs[]=trim(basename($lang),".php");
        }
        self::$_langs = $listLangs;

        if (file_exists($path)) {
            self::$_translations[self::$_lang] = require($path);
           
        }else{
             throw new \Exception("Translation file didnt exist");
        }

        $path = $this->_langpath . self::$_fallback .".php";

        if (file_exists($path)) {
            self::$_translations[self::$_fallback] = require($path);
           
        }else{
             throw new \Exception("Falback file didnt exist");
        }

    }

    public static function translate($key){
        if(array_key_exists($key, self::$_translations[self::$_lang])){
            return self::$_translations[self::$_lang][$key];
        }else if(array_key_exists($key, self::$_translations[self::$_fallback])){
            return self::$_translations[self::$_fallback][$key];
        }else{
            return "translation not found";
        }

    }

}

