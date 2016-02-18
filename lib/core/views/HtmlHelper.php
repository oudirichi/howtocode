<?php

class HtmlHelper{

	protected $_csspath;
	protected $scriptpath;

	public function __construct(){
	
		$this->_csspath="/oudiaide/assets/css";
		$this->_scriptpath="/assets/js";

		$this->fetch=array();
	
	}

	/**
	 * [css description]
	 * @param  [string]/[array] $path 		recois le ou les fichiers a inclure
	 * @return [string]       				retourne une string avec le link
	 */
	
	/**
	 * [usage]
	 * 
	 * un fichier
	 * <?= $Html->css("template"); ?>
	 * 
	 * plusieurs fichiers
	 *<?= $Html->css(array('template','bootstrap','facebook')); ?>
	 **/
	public function css($path=null){
		
		//Si il est vide, retourne rien 
		
		if(empty($path)){
			return;
		}

		$out='';

		//si path est un tableau, alors ajoute et contatene les elements dans la variable
		if (is_array($path)) {
			$out = '';
			foreach ($path as $v) {
				$out.= '<link rel="stylesheet" type="text/css" href="';
			$out.="$this->_csspath/$v.css";
			$out.='">';
			}
			return $out;
			
		}
		//si path est uniquement un string
		if($path!=""){
			$out.= '<link rel="stylesheet" type="text/css" href="';
			$out.="$this->_csspath/$path.css";
			$out.='">';
			return $out;

		}
	}

	/**
	 * [script description]
	 * @param  [string]/[array] $path 		recois le ou les fichiers a inclure
	 * @return [string]       				retourne une string avec le script
	 */
	
	/**
	 * [usage]
	 * 
	 * un fichier
	 * <?= $Html->script("jquery"); ?>
	 * 
	 * plusieurs fichiers
	 *<?= $Html->script(array('jquery','toggle','navbar')); ?>
	 **/

	public function script($path=null){

		//Si il est vide, retourne rien 
		if(empty($path)){
			return;
		}

		$out='';

		//si path est un tableau, alors ajoute contatene les elements dans la variable
		if (is_array($path)) {
			$out = '';
			foreach ($path as $v) {
				$out .= '<script type="text/javascript" src="/assets/js/';
				$out.="$v.js";
				$out.='"></script>';
			}
			return $out;
			
		}
		//si path est uniquement un string
		if($path!=""){
			$out .= '<script type="text/javascript" src="/assets/js/';
				$out.="$path.js";
				$out.='"></script>';
			return $out;
		}
	}

	/**
	 * [charset description]
	 * @param  [string] $charset        recois une string du charset à utiliser, par défaut il est en utf-8
	 * @return [string]                   retourne une string
	 */
	
	/**
	 * [usage]
	 * 
	 * encodage défini
	 * <?= $Html->charset("utf-8"); ?>
	 * <?= $Html->charset("ISO-8859-1"); ?>
	 * 
	 * par défaut
	 * <?= $Html->charset(); ?>
	 **/

	public function charset($charset=null){
	
		if(!empty($charset)){
			//<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			$out = '<meta http-equiv="Content-Type" content="text/html; charset=';
			$out .= "$charset";
			$out .= '" />';
			return $out;
		}else{
			$out = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
			return $out;
		}
	}

}