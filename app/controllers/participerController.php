<?php

class participerController extends Controller{

	var $layout='sbadmin';
	private $db;

	private $tuto_categories = array ();

	function __construct(){
		//$this->viewBlock = new \lib\ViewHelper\ViewBlock();
		$this->loadModel('Tutoriel');
		$this->loadModel('Formation');
		$this->tuto_categories = $this->Tutoriel->categories();
		$this->db = lib\App::getDatabase();
	}

	public function index(){
		$this->loadModel('User');

		$d=array();

		$this->set($d);
		$this->render('index');

	}


	function tutoriel($category = null, $slug = null){

		$d['title_for_layout'] = "Participer";
		$d['title']="Participez à la construction du site!";

		$d['description'] = "Aider nous à améliorer le site en nous envoyant des tutoriels/informations!";
		$d['keywords'] = "";


		$d["arr_categories"] = $this->tuto_categories;





			
		if($slug != null && $category != null && array_key_exists($category, $this->categories)){
			$da=$this->Runescape->tuto($this->categories[$category], $slug);
			$d= array_merge($d,$da);
			if(empty($_POST)){
				$_POST = $da['tutoriel'];
				
			}
		}
		//var_dump($d);echo "ici";die();

			/*
		*Permet de modifier et d'ajouter une categorie.
		*Csrf permet de créer une clé pour que personne fasse de truc malicieux.
		*
		*/

		/**
		*La sauvegarde
		**/

		$valid=true;

		if(isset($_POST['your_name'])){


			$message = "";


			$title = $_POST['title'];
			$content = $_POST['content'];
			$name = $_POST['your_name'];
			$email = $_POST['your_email'];
			$classification = $_POST['classification'];
			$classification = ($classification==='0') ? 0 : intval($classification);


			

			if($title == "" || !isset($title)){
				$message.="<p>Sujet vide</p>";
				$valid = false;
			}
			if($name == "" || !isset($name)){
				$message.="<p>Nom vide</p>";
				$valid = false;
			}
			if($email == "" || !isset($email)){
				$message.= "<p>Courriel vide</p>";
				$valid = false;
			}
			if($content == "" || !isset($content)){
				$message.= "<p>Ajouter du contenue</p>";
				$valid = false;
			}
			if (isset($email) && $email != "" && !preg_match("/^[a-z0-9\-_.]+@[a-z0-9\-_.]+\.[a-z]{2,3}$/i", $email)) {
				
				$valid=false;
				$message.= "Votre courriel n'est pas valide";
				//$erreuremail="Votre email n'est pas valide";
			}



			$session = lib\Session::getInstance();

			if($valid==true){
				
				

				//var_dump($content,$title,$email,$classification,$name);die();
				//$query="INSERT INTO rs_tutoriels_participer SET content=?, title=?, email=?, classification=?, name=?";
				   

				try {
					//$inid = $this->db->prepare($query);
	                //$inid->execute(array($content,$title,$email,$classification,$name));
	                $slug = $this->to_slug($title);
	                $this->Tutoriel->create($title, $content, $slug, $classification, 0);

	                if (isset($_SESSION['POST'])) {
						unset($_SESSION['POST']);
					}
					$session->setFlash('success','Le guide a bien été ajoutée');
					$_POST = array();
					unset($_SESSION['POST']);
					
					\lib\App::redirect("");

					
				} catch (Exception $e) {
					$session->setFlash('danger',"Une erreur est survenue");

					\lib\App::redirect(trim($_SERVER['REQUEST_URI']));
				}

				

			}else{
				$_SESSION['POST']=$_POST;

				
				$session->setFlash('danger',$message);
				header('Location:' . trim($_SERVER['REQUEST_URI']));
				die();
			}
		}

		if(isset($_SESSION) && isset($_SESSION['Auth'])){
			$_POST['your_name'] = $_SESSION['Auth']['username'];
			$_POST['your_email'] = $_SESSION['Auth']['email'];
			
		} 
		$this->set($d);
		$this->render('tutoriel');

	}

	function formation($category = null, $slug = null){

		$d['title_for_layout'] = "Participer";
		$d['title']="Participez à la construction du site!";

		$d['description'] = "Aider nous à améliorer le site en nous envoyant des tutoriels/informations!";
		$d['keywords'] = "";


		$d["arr_categories"] = $this->tuto_categories;





			
		if($slug != null && $category != null && array_key_exists($category, $this->categories)){
			$da=$this->Runescape->tuto($this->categories[$category], $slug);
			$d= array_merge($d,$da);
			if(empty($_POST)){
				$_POST = $da['tutoriel'];
				
			}
		}
		//var_dump($d);echo "ici";die();

			/*
		*Permet de modifier et d'ajouter une categorie.
		*Csrf permet de créer une clé pour que personne fasse de truc malicieux.
		*
		*/

		/**
		*La sauvegarde
		**/

		$valid=true;

		if(isset($_POST['your_name'])){


			$message = "";


			$title = $_POST['title'];
			$content = $_POST['content'];
			$name = $_POST['your_name'];
			$email = $_POST['your_email'];
			$classification = $_POST['classification'];
			$classification = ($classification==='0') ? 0 : intval($classification);


			

			if($title == "" || !isset($title)){
				$message.="<p>Sujet vide</p>";
				$valid = false;
			}
			if($name == "" || !isset($name)){
				$message.="<p>Nom vide</p>";
				$valid = false;
			}
			if($email == "" || !isset($email)){
				$message.= "<p>Courriel vide</p>";
				$valid = false;
			}
			if($content == "" || !isset($content)){
				$message.= "<p>Ajouter du contenue</p>";
				$valid = false;
			}
			if (isset($email) && $email != "" && !preg_match("/^[a-z0-9\-_.]+@[a-z0-9\-_.]+\.[a-z]{2,3}$/i", $email)) {
				
				$valid=false;
				$message.= "Votre courriel n'est pas valide";
				//$erreuremail="Votre email n'est pas valide";
			}



			$session = lib\Session::getInstance();

			if($valid==true){
				
				

				//var_dump($content,$title,$email,$classification,$name);die();
				//$query="INSERT INTO rs_tutoriels_participer SET content=?, title=?, email=?, classification=?, name=?";
				   

				try {
					//$inid = $this->db->prepare($query);
	                //$inid->execute(array($content,$title,$email,$classification,$name));
	                $slug = $this->to_slug($title);
	                $this->Formation->create($title, $content, $slug, $classification, 0);

	                if (isset($_SESSION['POST'])) {
						unset($_SESSION['POST']);
					}
					$session->setFlash('success','Le guide a bien été ajoutée');
					$_POST = array();
					unset($_SESSION['POST']);
					
					\lib\App::redirect("");

					
				} catch (Exception $e) {
					$session->setFlash('danger',"Une erreur est survenue");

					\lib\App::redirect(trim($_SERVER['REQUEST_URI']));
				}

				

			}else{
				$_SESSION['POST']=$_POST;

				
				$session->setFlash('danger',$message);
				header('Location:' . trim($_SERVER['REQUEST_URI']));
				die();
			}
		}

		if(isset($_SESSION) && isset($_SESSION['Auth'])){
			$_POST['your_name'] = $_SESSION['Auth']['username'];
			$_POST['your_email'] = $_SESSION['Auth']['email'];
			
		} 
		$this->set($d);
		$this->render('tutoriel');

	}

	function to_slug($string){
    	$out = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    	$out = rtrim($out,"-");
    	return $out;
	}
}
