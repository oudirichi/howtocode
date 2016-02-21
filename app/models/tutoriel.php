<?php

class Tutoriel extends Model{
	protected static $table_name = "info_category";

	function __construct(){
	    parent::__construct();
		$this->table = self::$table_name;
	    $this->db = lib\App::getDatabase();
	    $this->session = lib\Session::getInstance();
	}

  	public function categories(){
	    $categories = $this->db->query("SELECT * FROM info_category")->fetchAll(PDO::FETCH_OBJ);
	    $out = [];
	    foreach ($categories as $category) {
	    	$out[$category->id] = $category->name;
	    }
	    return $out;
  	}
  	
}
?>