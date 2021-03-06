<?php

class formationController extends Controller{

	var $layout='sbadmin';
	private $db;

	function __construct(){
		$this->loadModel('Formation');

	}

	public function index(){
		//var_dump($_SERVER);
		$d=array();
		$d['page'] = "Formation";
		$d['title_for_layout'] = "Formation";

		$d['description'] = "";
		$d['keywords'] = "";


		$d['tutoriel'] = $this->Formation->available_formations();


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

		$list_cat = $this->Formation->slug_categories();


		if(!in_array($category, $list_cat)){
			lib\App::redirect('formation/');
		}
		
		if($slug==null){
			$render = "liste_guide";
			$d['tutoriel'] = $this->Formation->available_formations($category);

		}else{
			$render = "view_guide";
			$key = array_search($category, $list_cat); // $key = 2;
			$da=$this->Formation->tuto($key,$slug);
			$d= array_merge($d,$da);
		}

		$this->set($d);
		$this->render($render);
	}

}
