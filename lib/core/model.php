<?php


/**
 * CLass Model, permet de gérer tout. Celui-ci inclue la connection et les helpers
 **/
class Model{


	public $table;
	public $id;

	protected $db;
	protected static $dataBase = null;


	
	public function __construct()
    {

    	if(self::$dataBase)
        	$this->db = self::$dataBase;
        else
        	throw new Exception("Database is not initialise");
		/*$this->db = new Connexion();
		$this->db = $this->db->dbConnect();*/
		/*global $db;
		$this->db = $db;*/
	
	
    }

    public static function init_database($db){
    	if(!self::$dataBase)
    		self::$dataBase = $db;
    }

    public function all(){
    	return $this->db->all($this->table);
    }

   /* public static function first(){
    	return $this->db->first($this->table);
    }

    public function last(){
    	return $this->db->last($this->table);
    }*/

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

	public function query($type='first',$query,$bindings){

		$stmt = $this->db->prepare($query);
		//$stmt ->execute($bindings);

		if ($type==='first') 
		{
			$stmt ->execute($bindings);
			$results = $stmt->fetch();

		}else if($type==='all')
		{	
			$stmt ->execute($bindings);
			$results = $stmt->fetchAll();
	
		}else if($type==='count'){

			$results = $stmt ->execute($bindings)->fetchColumn();

		}

		//$results = $stmt->fetchAll();

		return $results ? $results : false;

	}
			
	
	/**
	 * [find2 description]
	 * @param  string $type [description]
	 * @param  array  $data [description]
	 * @return [type]       [description]
	 *
	 * EXEMPLE
	 *         $model->find2('first',array(
		* 	                            'conditions'   => array("nom_rs" => $user),
		*	                            "fields"       => array("id_user"),//array
		*	                            "fields"       => "id_user", //string
		*                               "order"        => "title, id_user ASC",
		*                               "limit"        => "15, 10"
		*                               
     *      ));
	 */
	public function find($type='first', $data = array()){

		$bind=array();
		

		/**
		 * Fields
		 */
		if(isset($data["fields"])){
			if(is_array($data['fields'])){

				$fields= implode(', ', $data['fields']);

			}else if(is_string($data['fields'])){
				
					$fields=$data['fields'];
			}else{
					$fields=$this->db->quote($data['fields']);
			}
			
		}else{
			$fields="*";
		}

		/**
		 * Condition
		 */
		if(isset($data["conditions"]) && is_array($data['conditions'])){

			$cond_prep=array();
			foreach ($data['conditions'] as $k => $v) {
				$bind[]=$v;
				array_push($cond_prep, "$k=?");
			}
			$conditions=implode(', ', $cond_prep);

		}else{
			$conditions="1=1";
		}

		/**
		* Order
		* 
		*/

		if(isset($data["order"]) && is_array($data['order'])){

			$order_prep=array();
			$order="ORDER BY ";
			foreach ($data['order'] as $k => $v) {
				array_push($order_prep, "$k $v");
			}
			$order.=implode(', ', $order_prep);

		}else if(isset($data["order"]) && is_string($data['order'])){
			$order="ORDER BY ".$data['order'];
		}else{
			$order="";
		}

		/**
		 * Limit
		 */
		if(isset($data["limit"])){

			if(is_int($data['limit']) || is_string($data['limit'])){
				$limit="LIMIT ".$data['limit'];
			}else{
				$limit="";
			}

		}else{
			$limit="";
		}





		$sql="SELECT $fields FROM ".$this -> table." WHERE $conditions $order $limit";



		if ($type==='first') 
		{

			//$req = $this->db->query("SELECT $fields FROM ".$this -> table." WHERE $conditions ORDER BY $order $limit");

			return $req->fetch(PDO::FETCH_ASSOC);
			

		}else if($type==='all')
		{	
			
			//$req = $this->db->query("SELECT $fields FROM ".$this -> table." WHERE $conditions ORDER BY $order $limit");

			return $req->fetchAll(PDO::FETCH_ASSOC);



		}else if($type==='count'){

			//return $req = $this->db->query("SELECT COUNT($fields) AS total FROM ".$this -> table." WHERE $conditions $limit")
			return $req->rowCount();

		}

		
	}
	
}










/**
 *
 *
 * $model->table="rs_tutoriels";
 *       var_dump($model->find2('all',array(
 *                                   //'conditions' => array("title" => "divination"),
 *                                   "fields" => array("*"),
  *                                  //"order" => "title, id_user ASC",
 *                                   "limit" => "5"
  *          )));die();
  *
  * 
  *      $sql = "SELECT * FROM rs_xp_tracker WHERE nom_rs=?";
  *      var_dump($model->query('first',$sql,array($user)));die();
 */