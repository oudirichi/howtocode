<?php



class User extends Model{


  protected static $table_name = "users";

	private $auth = null;
	private $session = null;
	private $options = [
      'restriction_msg' => "Vous n'avez pas le droit d'accéder à cette page"
  	];



  public $id;
  public $username;
  public $email;
  public $password;
  public $confirmation_token;
  public $confirmed_at;
  public $reset_token;
  public $reset_at;
  public $remember_token;

	function __construct($options = []){
    parent::__construct();
		$this->table = self::$table_name;

    $this->options = array_merge( $this->options, $options);
    $this->db = lib\App::getDatabase();
    $this->session = lib\Session::getInstance();
	}

	private function isUniq($field, $value){
		$query = $this->db->select("id")->from($this->table)->where("$field = ?")->getQuery();
		return !$this->db->query($query, [$value])->fetch();
		
		//return !$this->db->query("SELECT id FROM $this->table WHERE $field = ?", [$value])->fetch();
	}

	


	public function isValid($arr){

  	$errors = array();

  	$validator = new lib\arrayValidator($arr);
  	$validator->isAlpha('username',"Votre pseudo n'est pas valide (alphanumerique)");
		$this->isUniq('username', $arr['username'], 'Ce pseudo est déjà prit');
	 	if($validator->isValid()){
	 		if($this->isUniq('username', $arr['username']) === false){
	 			$errors['username'] = 'Ce pseudo est déjà prit';
	 		}
	  }

	 	$validator->isEmail('email', "Votre email n'est pas valide");
	 	if($validator->isValid()){
	 		if($this->isUniq('email', $arr['email']) === false){
	 			$errors['email'] = 'Cet email est déjà utilisé pour un autre compte';
	 		}
	 	}
    
	  $validator->isConfirmed('password', "Vous devez rentrer un mot de passe valide");
		
	  if($validator->isValid() ===false || !empty($errors)){
	  	$errors = $errors + $validator->getErrors();
	  }

	  return $errors;
	}

	public function foundPage(){
		echo "Appel de la fonction du model : foundPage<br>";
	}


  public function hashPassword($password){
    return password_hash($password, PASSWORD_BCRYPT);
  }

  public function register($username, $password, $email){

  	$password = $this->hashPassword($password);
  	$token = lib\Str::random(60);

  	$this->db->query("INSERT INTO $this->table SET username = ?, password = ?, email = ?, confirmation_token = ?", [
						$username,
						$password,
						strtolower($email),
						$token
					]);

  	$user_id = $this->db->lastInsertId();
  	mail($email, 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\n". lib\App::$_WEBROOT . "users/confirm/$user_id/$token");

  }

  public function confirm($user_id, $token){

    $user = $this->db->query("SELECT * FROM $this->table WHERE id = ?", [$user_id])->fetch(PDO::FETCH_OBJ);
    if($user && $user->confirmation_token == $token){

      $this->db->query("UPDATE $this->table SET confirmation_token = NULL, confirmed_at = NOW() WHERE id = ?", [$user_id]);
      $user->confirmation_token = null;
      $user->confirmed_at = date("Y-m-d H:i:s");
      $this->connect($user);
      return true;

    }

    return false;

  }

  public function restrict(){
    if(!$this->session->read('auth')){
       $this->session->setFlash('danger', $this->options['restriction_msg']);
       lib\App::redirect("users/login");

    }

  }

  public function user(){
    if(!$this->session->read('auth')){
      return false;

    }
    return $this->session->read('auth');
  }

  private function connect($user){
    $this->session->write('auth',$user);
  }

  public function connectFromCookie(){

    if(isset($_COOKIE['remember']) && !$this->user()){

      $remember_token = $_COOKIE['remember'];
      $parts = explode('==', $remember_token);

      $user_id = $parts[0];
      $user = $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = ?', [$user_id])->fetch(PDO::FETCH_OBJ);

      if($user){

        $expected = $user->id . '==' . $user->remember_token . sha1($user->id . 'remember_key');
        if ($expected == $remember_token) {

          
          $this->connect($user);
          $this->session->getFlashes(); /*supprimer le message d'erreur s'il n'y a pas de session*/
          setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);
        }else{
          setcookie('remember', null, -1);
        }
        
      }else{
        setcookie('remember', null, -1);
      }
    }
  }

  public function login($username, $password, $remember = false){

    $user = $this->db->query('SELECT * FROM ' . $this->table . ' WHERE (username = :username OR email = :username) AND confirmed_at is NOT NULL', ['username' => $username])->fetch(PDO::FETCH_OBJ);

    if($user !== false && password_verify($password, $user->password)){

      $this->connect($user);

      if ($remember) {
        $this->remember($user->id);
        
      }

      return $user;

    }else{
      return false;
    }

  }


  private function remember($user_id){
    $remember_token = lib\Str::random(250);
    $this->db->query('UPDATE ' . $this->table . ' SET remember_token = ? WHERE id = ?', [$remember_token, $user_id]);
    setcookie('remember', $user_id . '==' . $remember_token . sha1($user_id . 'remember_key'), time() + 60 * 60 * 24 * 7);

  }

  public function logout(){
    setcookie('remember', NULL, -1);
    $this->session->delete('auth');
  }

  public function resetPassword($email){

    $user = $this->db->query('SELECT * FROM ' . $this->table . ' WHERE email = ? AND confirmed_at is NOT NULL', [$email])->fetch(PDO::FETCH_OBJ);

    if($user){

      $reset_token = lib\Str::random(60);

      $this->db->query('UPDATE '. $this->table. ' SET reset_token = ?, reset_at = NOW() WHERE id = ?', [$reset_token, $user->id]);

      mail($email, 'Réinitialisation de votre mot de passe', "Afin de réinitialisation votre mot de passe merci de cliquer sur ce lien\n\n" . lib\App::$_WEBROOT . "users/reset.php?" . $user->id . "/". $reset_token);
      return $user;
      

    }
    return false;
  }

  public function checkResetToken($user_id, $token){
    return $this->db->query('SELECT * FROM '. $this->table . ' WHERE id = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)', [$user_id, $token])->fetch(PDO::FETCH_OBJ);

  }


  public function updatePassword($arr, $user = null){
  	if($user === null)
  		$user_id = $_SESSION['auth']->id;
  	else{
  		$user_id = $user->id;
  	}

  	$password = $this->hashPassword($arr['password']);
  	$this->db->prepare('UPDATE '. $this->table . ' SET password = ?, reset_at = NULL, reset_token = NULL WHERE id = ?')->execute([$password, $user_id]);

  	if($user !== null){
  		$this->connect($user);
  	}

  }


}