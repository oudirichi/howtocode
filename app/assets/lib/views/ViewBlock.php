<?php

//include 'model_pdo.php';


/**
 * Class Connexion
 * Permet de se connecter et Model l'intencie
**/

class ViewBlock{

	protected $fetch=array();
	protected $_active=array();
	protected $last_fetch=null;

		

	public function append($name,$content){
	
		if (array_key_exists($name, $this->fetch)) {
			$this->fetch[$name].=$content;
		}else{
			$this->fetch[$name]=$content;
		}	
	}

	public function fetch($name=null){
	
		if (array_key_exists($name, $this->fetch)) {
				
				echo $this->fetch[$name];
				
		}else{
			//echo "L'élément n'existe pas<br>";
		}
	}	

	public function start($name=null){	
	
		if (in_array($name, $this->_active)) {
			echo "Il y a deja un block avec le nom $name d'active";
			return;
		}
		$this->_active[] = $name;
		ob_start();
			
	}
	
	public function end(){
				
			$content = ob_get_clean();
			$active = end($this->_active);

			if (!isset($this->fetch[$active])) {
				$this->fetch[$active] = '';
			}
			$this->fetch[$active] .= $content;	
			unset($this->_active[$active]);
	}
}