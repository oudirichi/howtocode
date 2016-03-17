<?php

class adminController extends Controller{

	var $layout='sbadmin';
	private $db;
	private $viewBlock;

	function __construct(){
		$this->loadModel('User');
	}

	public function index(){
		
		$this->User->isAdmin();
		$d=array();
		$this->set($d);
		$this->render('index');

	}

	public function tutoriel(){
		$this->User->isAdmin();
		$this->loadModel('Tutoriel');
		$d=array();
		$d['page'] = "Tutoriel";
		$d['title_for_layout'] = "Tutoriel";

		$d['description'] = "";
		$d['keywords'] = "";

		$d['tutoriel'] = $this->Tutoriel->all_tutoriels();

		$this->set($d);
		$this->render('liste_tutoriel');

	}

	function edit_tutoriel($id=null){
		$this->User->isAdmin();
		$this->loadModel('Tutoriel');
		$d=array();
		$d['title_for_layout']= "edition tutoriel";

		$render = "edit_tutoriel";
		$d['arr_categories'] = $this->Tutoriel->categories();
		$d['tutoriel'] = false;
		
		if($id!=null){

			$d['tutoriel'] = $this->Tutoriel->get($id,"array");
		}
		$_POST = $d['tutoriel'];
		$this->set($d);
		$this->render($render);
	}

	function new_tutoriel(){
		$this->User->isAdmin();
		$this->loadModel('Tutoriel');
		$title = $_POST['title'];
		$content = $_POST['content'];
		$slug = $_POST['slug'];
		$id_category = $_POST['classification'];
		$online = $_POST['online'];

		$this->Tutoriel->create($title, $content, $slug, $id_category, $online);
		$session = lib\Session::getInstance();
		$session->setFlash('success','Le tutoriel a bien été ajouté');
		$_POST = array();
		unset($_SESSION['POST']);
		\lib\App::redirect("admin/tutoriel");
	}

	function update_tutoriel($id){
		$this->User->isAdmin();
		$this->loadModel('Tutoriel');
		$title = $_POST['title'];
		$content = $_POST['content'];
		$slug = $_POST['slug'];
		$id_category = $_POST['classification'];
		$online = $_POST['online'];

		$this->Tutoriel->update($id, $title, $content, $slug, $id_category, $online);
		$session = lib\Session::getInstance();
		$session->setFlash('success','Le tutoriel a bien été modifé');
		$_POST = array();
		unset($_SESSION['POST']);
		\lib\App::redirect("admin/tutoriel");

	}
	function delete_tutoriel($id){
		$this->User->isAdmin();
		$this->loadModel('Tutoriel');

		$this->Tutoriel->delete($id);
		$session = lib\Session::getInstance();
		$session->setFlash('success','Le tutoriel a bien été supprimé');
		$_POST = array();
		unset($_SESSION['POST']);
		\lib\App::redirect("admin/tutoriel");

	}

	function formation($category, $slug=null){
		$this->User->isAdmin();
		$this->loadModel('Formation');
		$d=array();
		$d['action']= $category;
		$d['title_for_layout']= $category;

		$list_cat = $this->Formation->slug_categories();


		if(!in_array($category, $list_cat)){
			lib\App::redirect('formation/');
		}
		
		if($slug==null){
			$render = "liste_formation";
			$d['tutoriel'] = $this->Formation->available_formations($category);

		}else{
			$render = "view_formation";
			$key = array_search($category, $list_cat); // $key = 2;
			$da=$this->Formation->tuto($key,$slug);
			$d= array_merge($d,$da);
		}

		$this->set($d);
		$this->render($render);
	}


}
