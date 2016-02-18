<?php

	/*
	*si nous n'avons pas besoin de la redirection, par exemple dans login, car cela
	*ferait une redirection sans fin
	*/

	/*if(!isset($auth)){	
		if(!isset($_SESSION['Auth']['id'])){
			header('Location:' . WEBROOT . 'login.php');
			die();
		}
		if($_SESSION['Auth']['admin'] == 0 ){
			header('Location:' . WEBROOT);
			die();
		}

	}*/
	
	if(!isset($auth) || $auth == 0){	
		

	}else{
		if(!isset($_SESSION['Auth']['id'])){
			header('Location:' . WEBROOT . 'utilisateur/login.php');
			die();
		}
		if(isset($admin) && $admin==1 && $_SESSION['Auth']['admin'] == 0 ){
			header('Location:' . WEBROOT);
			die();
		}
	
	}


/*
*Si le csrf n'est pas créer, on le crée (clé qui permet de sécuriser)
*/
if(!isset($_SESSION['csrf'])){
	$_SESSION['csrf'] = md5(time() + rand());
}

function csrf(){
	return 'csrf=' . $_SESSION['csrf'];
}

function csrfInput(){
	return '<input type="hidden" value="' . $_SESSION['csrf']. '" name="csrf">';
}


/*
*Vérifier si le csrf est bon
*/
function checkCsrf(){
	if(
		(isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['csrf']) ||
		(isset($_GET['csrf']) && $_GET['csrf'] == $_SESSION['csrf'])
		){
		return true;
	}
		header('Location:' . WEBROOT . 'csrf.php');
		die();
	
}


?>