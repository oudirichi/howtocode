<?php

class adminController extends Controller{

	var $layout='sbadmin';
	private $db;
	private $viewBlock;

	function __construct(){
		//$this->viewBlock = new \lib\ViewHelper\ViewBlock();
	}

	public function index(){
		$this->loadModel('User');
		$this->User->isAdmin();


		$d=array();


		$this->set($d);
		$this->render('index');

	}

	public function tutoriel(){
		//var_dump($_SERVER);
		$this->loadModel('Tutoriel');
		$d=array();
		$d['page'] = "Tutoriel";
		$d['title_for_layout'] = "Tutoriel";

		$d['description'] = "";
		$d['keywords'] = "";


		$d['tutoriel'] = $this->Tutoriel->all_tutoriels();


		/*$select = $this->db->query("SELECT c.name,c.link,c.icon,c.description FROM info_category c
									INNER JOIN info_tutoriels t ON t.id_category=c.id
									WHERE t.online=1
									GROUP BY c.name,t.online
									HAVING COUNT(t.online)>=1
								  ");

		$d['tutoriel']=$select->fetchAll();*/

		$this->set($d);
		$this->render('liste_tutoriel');

	}

	function edit_tutoriel($id=null){
		$this->loadModel('Tutoriel');
		$d=array();
		$d['title_for_layout']= "edition tutoriel";

		
		if($id==null){
			$render = "liste_tutoriel";
			$d['tutoriel'] = $this->Tutoriel->available_tutoriels($category);
			//var_dump($da);die;
			//$d= array_merge($d,$da);

		}else{
			$render = "view_tutoriel";
			$id_category = array_search($category, $list_cat);
			$da=$this->Tutoriel->tuto($id_category,$slug);
			$d= array_merge($d,$da);
		}

		$this->set($d);
		$this->render($render);
	}

	function delete_tutoriel($id){
		
	}

	function formation($category, $slug=null){
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
