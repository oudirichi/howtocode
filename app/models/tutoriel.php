<?php

class Tutoriel extends Model{
	protected static $table_name = "info_tutoriels";

	function __construct(){
	    parent::__construct();
		$this->table = self::$table_name;
	    $this->db = lib\App::getDatabase();
	    $this->session = lib\Session::getInstance();
	}

  	public function categories(){
	    return $this->db->query("SELECT * FROM info_category")->fetchAll(PDO::FETCH_ASSOC);
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
  	function available_tutoriels($category = null){
  		if(!$category){

	    	$select = $this->db->query("SELECT t.id, t.slug, t.title, c.name,c.link,c.icon FROM info_category c
	                  INNER JOIN $this->table t ON t.id_category=c.id
	                  WHERE t.online=1
	                  ");
  		}else{

  			$select = $this->db->query("SELECT t.id, t.slug, t.title, c.name,c.link,c.icon FROM info_category c
	                  INNER JOIN $this->table t ON t.id_category=c.id
	                  WHERE t.online=1 
	                  AND c.link = ?
	                  ", [$category]);

  		}

    	return $select->fetchAll(PDO::FETCH_OBJ);
  }

  function all_tutoriels($category = null){
  		if(!$category){

	    	$select = $this->db->query("SELECT t.id, t.slug, t.title, c.name,c.link,c.icon FROM info_category c
	                  INNER JOIN $this->table t ON t.id_category=c.id
	                  ");
  		}else{

  			$select = $this->db->query("SELECT t.id, t.slug, t.title, c.name,c.link,c.icon FROM info_category c
	                  INNER JOIN $this->table t ON t.id_category=c.id
	                  WHERE c.link = ?
	                  ", [$category]);

  		}

    	return $select->fetchAll(PDO::FETCH_OBJ);
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

  function create($title, $content, $slug, $id_category, $online){
  	$this->db->query("INSERT INTO $this->table SET title = ?, content = ?, slug = ?, id_category = ?, online=?", [
						$title,
						$content,
						$slug,
						$id_category,
						$online
					]);

  	return $this->db->lastInsertId();

  }

  function update($id, $title, $content, $slug, $id_category, $online){
  	$this->db->query("UPDATE $this->table SET title = ?, content = ?, slug = ?, id_category = ?, online=? WHERE id=?", [
						$title,
						$content,
						$slug,
						$id_category,
						$online,
						$id
					]);
  }

  function delete($id){
  	$this->db->query("DELETE FROM $this->table WHERE id = ?", [
						$id
					]);
  }
  	
}
