<?php

class PagesController extends Controller{

	var $layout='sbadmin';
	private $db;
	private $viewBlock;

	function __construct(){
		//$this->viewBlock = new \lib\ViewHelper\ViewBlock();
	}

	public function index(){
		$this->loadModel('User');


		$d=array();


		$this->set($d);
		$this->render('index');

	}


}
