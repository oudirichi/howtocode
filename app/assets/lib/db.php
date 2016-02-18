<?php

try{

	$db = new PDO('mysql:host='.$default['host'].'; dbname='.$default['database'], $default['login'], $default['password']); 

	if(isset($default['encoding']) && $default['encoding']=='utf8'){
	    $db->exec("SET CHARACTER SET utf8");
	    $db->exec("SET NAMES utf8");
	}

	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	define('TIMEZONE', 'America/Montreal');
	date_default_timezone_set(TIMEZONE);

	setlocale(LC_ALL, $default['setlocale']);


	/*if ($db_to_use=="local") {
		 
		

	} else {
		setlocale(LC_ALL, 'fr_FR');
	}*/
	
	

}
catch(PDOException $e){

	echo 'Impossible de se connecter '.'<br>';
	echo $e->getMessage();
	die();
}
?>