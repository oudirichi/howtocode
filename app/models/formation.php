<?php

class Formation extends Model{
	protected static $table_name = "info_formations";

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

  	public function slug_categories(){
	    $categories = $this->db->query("SELECT * FROM info_category")->fetchAll(PDO::FETCH_OBJ);
	    $out = [];
	    foreach ($categories as $category) {
	    	$out[$category->id] = $category->link;
	    }
	    return $out;
  	}
  	/*public function getList(){
	    return $this->db->query("SELECT * FROM $this->table")->fetchAll(PDO::FETCH_OBJ);
  	}*/
  	/*public function all_categories(){
	    return $this->db->query("SELECT * FROM info_category")->fetchAll(PDO::FETCH_OBJ);
  	}*/
  	function available_formations(){
    	$select = $this->db->query("SELECT c.name,c.link,c.icon,c.description FROM info_category c
                  INNER JOIN $this->table t ON t.id_category=c.id
                  WHERE t.online=1
                  GROUP BY c.name,t.online
                  HAVING COUNT(t.online)>=1
                  ");

    	return $select->fetchAll(PDO::FETCH_OBJ);
  }


  	function getList($link){
	    $link=htmlspecialchars($link);
	    $select = $this->db->query("SELECT t.title, t.online, t.slug, t.publication, t.modification,t.online FROM $this->table t 
	                          INNER JOIN info_category c ON t.id_category=c.id  
	                          WHERE c.link=? ORDER BY title ASC", [$link]);

	    $d['tutoriel']=$select->fetchAll();

	    $d['nb_total']=count($d['tutoriel']);

	    $d['nb_online']=0;

	    foreach ($d['tutoriel'] as $v) {
	      if($v['online']==1){
	        $d['nb_online']++;
	      }
	    }

	    return $d;
	}

  	function tuto($category,$slug){
    	$category=htmlspecialchars($category);
	    $d['guide']=1;


		//Selectionne le guide avec le nom de la categorie
		$select = $this->db->query("SELECT tuto.*,cat.name
			FROM $this->table tuto
			INNER JOIN info_category cat ON cat.id=? 
			WHERE slug=? AND tuto.id_category=?",[$category,$slug, $category]);

		$d['tutoriel']=$select->fetch();


		//s'il est impossible de récupérer un guide
		if($select->rowCount() == 0){
		lib\App::redirect('formation/');
		}


		$id= (int)$d['tutoriel']['id'];
	    return $d;
  }
  	
}
?>