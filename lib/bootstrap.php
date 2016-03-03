<?php

// Include Autoloader to auto-include class with the namespace
require_once("Autoloader.php");

use lib\App;
// make the autoloader autoload file
lib\Autoloader::register();

// Init the application
lib\App::init();

// Getting all config URL for the project
$host = lib\File::req_file("config/environments.php");

// Start the Application with all config
lib\App::start($host);

//$db = lib\App::getDatabase();
$session = lib\Session::getInstance();


// If the language is not define. Use the En version by default
if($session->read("lang") === null){
  $session->write("lang", "en_CA");
}
$lang = $session->read("lang");

// Initalisation of the i18n
$i18n = new lib\i18n($lang);
$i18n->init();

lib\ViewHelper\HtmlHelper::setDefault();


// Function to get translation with more ease
function _i18n($key){
    return lib\i18n::translate($key);

}

function __($key){
    return lib\i18n::translate($key);

}

function link_to($name, $path, $params = null){
	return lib\ViewHelper\HtmlHelper::link_to($name, $path, $params);
}

/*
echo('dir = '.basename(dirname(__FILE__)));   
var_dump($_SERVER['HTTP_HOST']);
var_dump($_SERVER['SERVER_NAME']);
var_dump($_SERVER['HTTP_HOST']);
var_dump($_SERVER['REQUEST_URI']);
var_dump(PATHINFO_FILENAME);
 */
