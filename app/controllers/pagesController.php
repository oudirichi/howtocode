<?php

class PagesController extends Controller{

	var $layout='sbadmin';
	private $db;
	private $viewBlock;

	function __construct(){
		//parent::__construct();
		$this->viewBlock = new \lib\ViewHelper\ViewBlock();
		/*global $db;
		$this->db = $db;*/
	}

	public function index(){

		//$this->loadModel('Page');
		$this->loadModel('User');
		
		/*$user = new User();
		$u = User::first();
		$u->save();die;*/
		//var_dump($this->User->first());die;
		/*$u = new User;
		$au= $u->all();
		var_dump($au);die;
		$Page = new Page();
		$Page->foundPage();*/


		$this->element("something", ["var" => "lol"]);



		$d=array();
		$d['nom'] = "alex";
		$d['title_for_layout'] = "titre";



		$this->set($d);
		$this->render('index');

	}


}
