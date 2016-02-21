<?php

class UsersController extends Controller{

	var $layout='sbadmin';
	private $db;

	function __construct(){

	}


	public function login(){

		$this->loadModel('User');
		if($this->User->user()){
			//return $this->account();
			lib\App::redirect('users/account');
		}


		$d['title_for_layout'] = "titre";

		

		$isConnected = $this->User->connectFromCookie();


		  if($isConnected){
			 App::redirect('users/account');
		  }


		  if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {

		  	$user = $this->User->login($_POST['username'], $_POST['password'], isset($_POST['remember']));

		    $session = lib\Session::getInstance();
		    if($user){
		    	$session->setFlash('success','Vous êtes maintenant connecté');
		    	lib\App::redirect('users/account');
		    }else{
		  		$session->setFlash('danger',"Identifiant ou mot de passe incorrecte. Il se peut aussi que votre compte n'est pas validé");
		        /*header('Location:' . "login");
				die();*/
		        lib\App::redirect('users/login');
		    }
		  }

		$this->set($d);
		$this->render('login');

	}
	public function logout(){
		$this->loadModel('User');
		$this->User->logout();
		lib\Session::getInstance()->setFlash('success', 'Vous êtes maintenant déconnecté');
		lib\App::redirect('users/login');
	}

	public function register(){
		$d['title_for_layout'] = "titre";
		$this->loadModel('User');

		

		if (!empty($_POST)) {

			$_POST['email'] = strtolower($_POST['email']);

			$errors = $this->User->isValid($_POST);
		 	

		 	if(empty($errors)){
		 		$this->User->register($_POST['username'], $_POST['password'], $_POST['email']);
		 		lib\Session::getInstance()->setFlash('success', 'Un email de confirmation vous a été envoyé pour valider votre compte');
		 		unset($_POST);
				lib\App::redirect('users/login');
		 	}else{
		 		$d['errors'] = $errors;
		 	}

		}
		$this->set($d);
		$this->render('register');

	}

	public function confirm($id = null, $token = null){

		if ($id !==null && $token !==null) {
			$user_id = $id;
			$token = $token;
		}else{
			//lib\App::$_WEBROOT
			lib\App::redirect("users/login");
		}

		$this->loadModel('User');

		if($this->User->confirm($user_id, $token)){

		lib\Session::getInstance()->setFlash('success', "Votre compte a bien été validé");
		$_POST = array();
		lib\App::redirect('users/account');

		}else{

		lib\Session::getInstance()->setFlash('danger', "Ce token n'est plus valide");
		$_POST = array();
		lib\App::redirect('users/login');

		}
	}

	public function account(){
		$d['title_for_layout'] = "titre";
		$this->loadModel('User');
		$this->User->restrict();
		$this->User->isAdmin();

		if (!empty($_POST)) {
			$validator = new lib\ArrayValidator($_POST);
	        $validator->isConfirmed('password');
	        if ($validator->isValid()) {
				$this->User->updatePassword($_POST);
				lib\Session::getInstance()->setFlash('success', "Votre mot de passe a bien été été mis a jour");
			}else{
				lib\Session::getInstance()->setFlash('danger', "Les mot de passes ne correspondent pas");
			}
			$_POST = array();
		}

		$this->set($d);
		$this->render('account');

	}

	public function forget(){
		$d['title_for_layout'] = "titre";
		$this->loadModel('User');
		if (!empty($_POST) && !empty($_POST['email'])) {


			$session = lib\Session::getInstance();

			if($this->User->resetPassword($_POST['email'])){

			  $session->setFlash('success', 'Les instructions de rappel de mot de passe vous ont été envoyées par email');        
			  lib\App::redirect('login');

			} else {

			   $session->setFlash('danger', "Aucun compte ne correspond a cette adresse, il se peut que votre compte ne soit pas confirmé.");   
			}
			$this->set($d);
		}

		$this->render('forget');

	}

	public function reset($id = null, $token = null){


		$session = lib\Session::getInstance();

		if ($id !==null && $token !==null) {

			$this->loadModel('User');

		    
		    
		    $user = $this->User->checkResetToken($id, $token);
		    if($user){

		      if (!empty($_POST)) {
		        $validator = new lib\ArrayValidator($_POST);
		        $validator->isConfirmed('password');
		        if ($validator->isValid()) {
		        	$this->User->updatePassword($_POST,$user);
		          
					lib\Session::getInstance()->setFlash('success', "Votre mot de passe a bien été modifié");
					lib\App::redirect('account');

		        }
		      }

		    }else{
		      lib\Session::getInstance()->setFlash('danger', "Ce token n'est pas valide");
		      lib\App::redirect('login');
		    }

		}else{
			lib\App::redirect('login');

		}
		$this->render('reset');
	}
//http://localhost:82/DevMVC2/users/reset/3/RQgS62kR3z1lRrghMzlHS8WMrv7uPL2pPA0yNfo3WgCuTk6XzxHK0Lti3Zg5


}
