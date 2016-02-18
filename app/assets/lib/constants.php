<?php
  /*define('root',realpath($_SERVER["DOCUMENT_ROOT"]));
  $root = realpath($_SERVER["DOCUMENT_ROOT"]); */

  
  define('DS',DIRECTORY_SEPARATOR);
  
  //define('WWW_ROOT',dirname(dirname(__FILE__)));  //C:\wamp\www\assets
  define('WWW_ROOT',dirname(dirname(dirname(__FILE__))));  //C:\wamp\www\assets

	//basename(__FILE__); nom avec extention de chaque page genre quetes.php
	$directory = basename(WWW_ROOT);			  //
	$url = explode($directory, $_SERVER['REQUEST_URI']);  //Chaque page du site

	define('WEBROOT',str_replace('index.php','',$_SERVER['SCRIPT_NAME']));
	/*if(count($url)==1){
		if(!defined('WEBROOT')){
			define('WEBROOT','/');
		}
	}else{
		if(!defined('WEBROOT')){
			define('WEBROOT', $url[0] . $directory . '/');
		}
	}	*/

	define('IMAGES', WWW_ROOT . DIRECTORY_SEPARATOR . 'img'); //C:\wamp\www\assets\img
	
	
	define('rs_images','/runescape/images');
	define('rs_videos','/runescape/videos');

	$list_pages=array('','competences','quetes','mini-jeux','mini-quetes','taches','general','boss','saisonnier');
	
?>