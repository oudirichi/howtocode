<?php



class Controller {

	var $vars=array();
	var $layout='default';
	var $model;
	public $rended = false;


	private $_element_path = null;

	/*function __construct(){
		$this->_element_path = \lib\App::$_element_path;
		var_dump(\lib\App::$_element_path);die;
	}*/
		
	public function element($name, $vars = null){
		if($vars){
			extract($vars);
		}
		
		if(!$this->_element_path){ 
			$this->_element_path = \lib\App::$_element_path; 
		}

		$path = $this->_element_path . $name . ".php";
		if (file_exists($path)) {
			ob_start();
			require($path);
			$content = ob_get_clean();
			return $content;
			
		}else{
			throw new \Exception(sprintf("The Element [%s] can't be loaded.", $name));
		}	
	}


	function set($d){
		$this->vars=array_merge($this->vars,$d);

	}
	/*function render(){
		extract($this->vars);
	}*/
	function render($filename){
		$this->rended = true;
		extract($this->vars);
		$class_name = str_replace("Controller", "", get_class($this));
		
		//$file = lib\App::$_ROOT.sprintf("app/views/%s/%s.php",$class_name,$filename);
		$file = lib\App::$_ROOT.'app/views/'. strtolower($class_name) .'/'.$filename.'.php';
		if (!is_file($file)) {
			throw new \Exception(sprintf("The view %s cant be found", $filename));
		}

		ob_start();
		require($file);
		$content_for_layout = ob_get_clean();

		if($this->layout==false){
			echo $content_for_layout;
		}else{
			$template = lib\App::$_ROOT.'app/views/Layouts/'.$this->layout.'.php';
			if (!is_file($template)) {
				throw new \Exception(sprintf("The Layout %s cant be found", $this->layout));
			}
			require($template);
		}

	}

	function loadModel($name){
		$file = lib\App::$_ROOT.'app/models/'.strtolower($name).'.php';
        if (is_file($file)) {
			require_once($file);
			$this->$name = new $name();
		}else{
			throw new \Exception(sprintf("Cant load the model %s", $name));
		}
	}
}
