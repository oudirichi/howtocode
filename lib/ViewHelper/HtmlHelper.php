<?php

namespace lib\ViewHelper;

class HtmlHelper{

	protected static $_csspath;
	protected static $_scriptpath;

	public function __construct(){
		self::$_csspath = \lib\App::$_css_path;
		self::$_scriptpath= \lib\App::$_script_path;
	}

	public static function setDefault(){
		self::$_csspath = \lib\App::$_css_path;
		self::$_scriptpath= \lib\App::$_script_path;
	}

	public static function setScript($path){
		self::$_csspath = \lib\App::$_css_path;
		
	}

	public static function setCss($path){
		self::$_csspath = \lib\App::$_css_path;
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
	public static function css($path=null){
		//Si il est vide, retourne rien

		if(empty($path)){
			return;
		}

		$out='';

		//si path est un tableau, alors ajoute et contatene les elements dans la variable
		if (is_array($path)) {
			$out = '';
			$format = '<link rel="stylesheet" type="text/css" href="'. self::$_csspath .'%s.css">';
			foreach ($path as $v) {
				if ($v[0]=="/") {
					$out.= sprintf($format, "$v");

				}else{
					$out.= sprintf($format, "/$v");
				}


			}
			return $out;

		}
		//si path est uniquement un string
		if($path!=""){
			$out.= '<link rel="stylesheet" type="text/css" href="';
			if ($v[0]=="/") {
					$out.= self::$_csspath . "{$v}.css";
				}else{
					$out.= self::$_csspath . "/{$v}.css";
				}
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

	public static function script($path=null){

		//Si il est vide, retourne rien
		if(empty($path)){
			return;
		}

		$out='';

		//si path est un tableau, alors ajoute contatene les elements dans la variable
		if (is_array($path)) {
			$out = '';
			foreach ($path as $v) {
				$out .= '<script type="text/javascript" src="';

				if ($v[0]=="/") {
					$out.= self::$_scriptpath . "{$v}.js";
				}else{
					$out.= self::$_scriptpath . "/{$v}.js";
				}
				$out.='"></script>';
			}
			return $out;

		}
		//si path est uniquement un string
		if($path!=""){
			$out .= '<script type="text/javascript" src="';
				if ($v[0]=="/") {
					$out.= self::$_scriptpath . "{$v}.js";
				}else{
					$out.= self::$_scriptpath . "/{$v}.js";
				}
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

	public static function link_to($name, $path, $params = null){
		$out = '<a href="%s"%s>%s</a>';
		if($path == "/")
    		$path = \lib\App::$_WEBROOT_LINK;
	    else
	    	$path = \lib\App::$_WEBROOT_LINK.$path;

	    $params_out = "";

	    if (is_array($params)) {

	    	foreach ($params as $k => $v) {
	    		if(is_array($v)){
	    			$params_out .= sprintf(' %s="%s"', $k, implode(" ", $v));
	    			//$params_out .= ' '.$k.'="'.implode(" ", $v).'"';
	    		}else{
	    			$params_out .= sprintf(' %s="%s"', $k, $v);
	    		}
	    	}
	    }else if($params){
	    	$params_out = " ".$params;
	    }
	    $out = sprintf($out, $path,$params_out,$name);
	    return $out;
	}

}