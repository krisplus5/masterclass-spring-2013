<?php 

class Util_Session {

    protected $config;
	protected $db;
	protected $model;

    public function __construct($config,$db) {
     	$this->config = $config;
		$this->db = $db;
		$this->model = new Model_User($config,$db);
    }

	public function isAuthenticated(){
		if(!isset($_SESSION['AUTHENTICATED'])){
			return true;
		}

		return false;	
	}

	public function set($key,$value){
		if($this->isAuthenticated()){
			$_SESSION[$key] = $value;		
		}
	}

	public function get($key){	
		$val = null;
		
		if($this->isAuthenticated()){
			$val = $_SESSION[$key];
		}
	
		return $val;
	}
	
	public function unauthenticate(){
		session_destroy();
	}
	
	public function authenticate($username, $password){
		$error = 'Your username/password did not match.';
		
		$hashed = $this->model->hashPassword($username,$password);
		
		$sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';
		$params = array($username,$hashed);

		$data = $this->db->getOne($sql,$params);
		$rowcount = $this->db->getRowcount($sql,$params);

		if($rowcount > 0) {
			$this->regen();
			$_SESSION['username'] = $data['username'];
			$_SESSION['AUTHENTICATED'] = true;
			$error = null;
		}
		
		return $error;
	}
	
	public function regen(){
		session_regenerate_id();
	}
}