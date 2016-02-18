<?php


class Connexion{

	

	public function dbConnect(){
		
		$db= new PDO('mysql:host=localhost;dbname=oudiaide','root','');
		$db->exec('SET NAMES utf8');
		$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		
		return $db;			
		
	}
	
}
class Model{

	public $table='rs_tutoriels';
	public $id;

	public $db;
	
	public function __construct()
    {
        
		$this->db = new Connexion();
		$this->db = $this->db->dbConnect();
	
    }

	public function read($id,$fields=null){

		if($fields==null){
			$fields = "*";
		}
		
		$req = $this->db->query("SELECT $fields FROM ".$this ->table." WHERE id=".$id);
		
		$data = array();
		while($data = $req->fetch(PDO::FETCH_OBJ)){
			foreach ($data as $k => $v) {
				$this -> $k = $v;
			}
		}
	}

	public function save($data){
		

		$result = "";

		foreach ($data as $k => $v) {
			if($k != "id"){
			$result .="$k='$v',";
			}
		}

		$result = substr($result,0,-1);

		if(isset($data["id"]) && !empty($data["id"])){
			$req = $db->exec("UPDATE ".$this -> table." SET ".$result." WHERE id=".$data["id"]);
		}else{

			

			unset($data["id"]);

			$result2 = "";

			foreach ($data as $k => $v) {
				$result2 .="$k,";
			}
			$result2 = substr($result2,0,-1);

			$result3 = "";
			foreach ($data as $v) {
				$result3 .="'$v',";
			}
			$result3 = substr($result3,0,-1);

			$req = $db->exec("INSERT INTO ".$this -> table." (".$result2.") VALUES (".$result3.")");
		}

		if(!isset($data["id"])){
			$id = $this ->id;
			$id = PDO::lastInsertId();
		}
		else {
			$this ->id = $data["id"];
		}
	}

	public function find($data){
		

		$conditions = "1=1";
		$fields = "*";
		$limit = "";
		$order = "id DESC";

		if(isset($data["conditions"])) { $conditions = $data["conditions"]; }
		if(isset($data["fields"])) { $fields = $data["fields"]; }
		if(isset($data["limit"])) { $limit = "LIMIT ".$data["limit"]; }
		if(isset($data["order"])) { $order = $data["order"]; }

		$req = $this->db->query("SELECT $fields FROM ".$this -> table." WHERE $conditions ORDER BY $order $limit");

		$d = array();
		while($data = $req->fetch(PDO::FETCH_ASSOC)){
			$d[] = $data;
		}
		return $d;
	}

	public function delete($id = null){
		

		if($id == null) { $id = $this -> id; }
		$req = $$this->db->exec("DELETE FROM ".$this -> table." WHERE id=$id");
	}

	static function load($name){
		require("$name.php");
		return new $name();
	}
}
?>
