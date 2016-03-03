<?php

class tutorielController extends Controller{

	var $layout='sbadmin';
	private $db;

	function __construct(){
		$this->loadModel('Tutoriel');

	}

	public function index(){
		//var_dump($_SERVER);
		$d=array();
		$d['page'] = "Tutoriel";
		$d['title_for_layout'] = "Tutoriel";

		$d['description'] = "";
		$d['keywords'] = "";


		$d['tutoriel'] = $this->Tutoriel->available_tutoriels();


		/*$select = $this->db->query("SELECT c.name,c.link,c.icon,c.description FROM info_category c
									INNER JOIN info_tutoriels t ON t.id_category=c.id
									WHERE t.online=1
									GROUP BY c.name,t.online
									HAVING COUNT(t.online)>=1
								  ");

		$d['tutoriel']=$select->fetchAll();*/

		$this->set($d);
		$this->render('index');

	}

	function view($category, $slug=null){	
		$d=array();
		$d['action']= $category;
		$d['title_for_layout']= $category;

		$list_cat = $this->Tutoriel->slug_categories();


		if(!in_array($category, $list_cat)){
			lib\App::redirect('formation/');
		}
		
		if($slug==null){
			$render = "liste_guide";
			$d['tutoriel'] = $this->Tutoriel->available_tutoriels($category);
			//var_dump($da);die;
			//$d= array_merge($d,$da);

		}else{
			$render = "view_guide";
			$id_category = array_search($category, $list_cat);
			$da=$this->Tutoriel->tuto($id_category,$slug);
			$d= array_merge($d,$da);
		}

		$this->set($d);
		$this->render($render);
	}

}
