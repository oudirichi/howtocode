<?php

try {
	
	$debug = 1;
	require('lib/bootstrap.php');
	include "app/assets/lib/includes.php";
	require('lib/core/model.php');
	require('lib/core/controller.php');
	/*$route = new lib\Route('p');
	$params=$route->createRoute($_GET);*/



	//define('WEBROOT',str_replace('index.php','',$_SERVER['SCRIPT_NAME']));

	//define('ROOOT',str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));



	Model::init_database(lib\App::getDatabase());
	$router = new lib\Router\Router($_GET['p']);
	require lib\File::file("config/routes.php");
	$router->run();

} catch (Exception $e) {
	if($debug){
		echo $e->getMessage() . "<br>";// . " In {$e->getFile()} ({$e->getLine()})<br>";
		//echo "Trace is : " . $e->getTraceAsString();
		
	}else{

		die("Afficher 404");
	}
}