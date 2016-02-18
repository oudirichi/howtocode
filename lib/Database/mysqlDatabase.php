<?php
/**
 * PDO::FETCH_ASSOC: retourne un tableau indexé par le nom de la colonne comme retourné dans le jeu de résultats
 * PDO::FETCH_BOTH (défaut): retourne un tableau indexé par les noms de colonnes et aussi par les numéros de colonnes, commençant à l'index 0, comme retournés dans le jeu de résultats
 * PDO::FETCH_OBJ : retourne un objet anonyme avec les noms de propriétés qui correspondent aux noms des colonnes retournés dans le jeu de résultats
 *
 *
 */

namespace lib\Database;

class mysqlDatabase extends Database implements iDatabase{

	public $table;
	protected $id;

	protected $db;


	private $fields = [];
    private $conditions = [];
    private $from = [];


	public function __construct($conf){
		
		
        try {
			$this->db = new \PDO("mysql:dbname={$conf['database']};host={$conf['host']}", $conf['login'], $conf['password']);
			
			if(isset($conf['encoding']) && $conf['encoding']=='utf8'){
				$this->db->exec("SET CHARACTER SET utf8");
				$this->db->exec("SET NAMES utf8");
			}
			
			//$this->db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
			$this->db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE,\PDO::FETCH_ASSOC);

			$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			//$this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
        	
        } catch (\Exception $e) {
        	echo 'Impossible de se connecter '.'<br>';
			echo $e->getMessage();
			die();
        }
	}


	//FLUENT

    public function select(){
        $this->fields = func_get_args();
        return $this;
    }

    public function where(){
        foreach(func_get_args() as $arg){
            $this->conditions[] = $arg;
        }
        return $this;
    }

    public function params(){
        foreach(func_get_args() as $arg){
            $this->params[] = $arg;
        }
        return $this;
    }

    public function from($table, $alias = null){
        if(is_null($alias)){
            $this->from[] = $table;
        }else{
            $this->from[] = "$table AS $alias";
        }
        return $this;
    }

    public function __toString(){
        return $this->getQuery();
    }

    public function getQuery(){
        $query= 'SELECT '. implode(', ', $this->fields)
              . ' FROM ' . implode(', ', $this->from)
              . ' WHERE ' . implode(' AND ', $this->conditions);

        $this->fields = [];
    	$this->conditions = [];
    	$this->from = [];

        return $query;
    }

/*
    public function execQuery(){
        $query = 'SELECT '. implode(', ', $this->fields)
	            . ' FROM ' . implode(', ', $this->from)
	            . ' WHERE ' . implode(' AND ', $this->conditions);

	            
	 	$this->fields = [];
    	$this->conditions = [];
    	$this->from = [];
    	$bind = $this->params;
    	$this->params = [];

    	if(!empty($bind)){
			$req = $this->db->prepare($query);
			$req->execute($bind);
		}else{
			$req = $this->db->query($query);
		}

		return $req->fetch(\PDO::FETCH_OBJ);

    }*/

    // FIN FLUENT




	public function prepare($query){
		return $this->db->prepare($query);
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

    public function lastInsertId(){
        return $this->db->lastInsertId();
    }

	public function query($query, $params = false){

		if($params){
			$req = $this->db->prepare($query);
			$req->execute($params);
		}else{
			$req = $this->db->query($query);
		}
		return $req;
	}

	/**
	 * [find description]
	 * @param  string $type [description]
	 * @param  array  $data [description]
	 * @return [type]       [description]
	 *
	 * EXEMPLE
	 *         $model->find('first',array(
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

		$req = $this->db->prepare($sql);
		$req ->execute($bind);



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

	public function all($table = null){
		return $this->db->query("SELECT * FROM " . $table)->fetchAll(\PDO::FETCH_OBJ);
	}

	public function first($table = null){
		$query = "SELECT * FROM " . $table;
		return $this->db->query("SELECT * FROM " . $table);
	}

	public function last($table = null){
		return $this->db->query("SELECT * FROM " . $table . " ORDER BY id DESC")->fetch(\PDO::FETCH_OBJ);
	}

	

	/**
     * Fetch column
     * 
     * @access public
     * @return array
     */
    public function getColumns ($table = null)
    {

        $result = $this->db->query(sprintf("SHOW COLUMNS FROM %s;", $table));
        
        if ($result === false)
            throw new \Exception(sprintf('Unable to fetch the column names. %s.', $conn->error));
        return $result->fetchAll(\PDO::FETCH_ASSOC);

    }


	/**
     * Fetch column names
     * 
     * @access public
     * @return array
     */
    public function getColumnNames ($table = null)
    {

    	$data = $this->getColumns($table);
       
        $ret = array();
        foreach ($data as $value) {
        	$ret[] = $value['Field'];
        }

        return $ret;
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
