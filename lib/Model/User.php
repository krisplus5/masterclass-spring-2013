<?php

class Model_User {

    protected $config;
	protected $db;

    public function __construct($config) {
     	$this->config = $config;
        $this->db = new Util_MySQL($config);
    }

	protected function validatePassword(array $data){

		$error = null;

		if(empty($data['password']) || empty($data['password_check'])){
			$error = 'You did not fill in all required fields.';
		}else if($data['password'] != $data['password_check']){
			$error = 'The password fields did not match. Please try again.';
		}else if(empty($data['password']) || empty($data['password_check'])) {
			$error = 'The password fields were blank or they did not match. Please try again.';
		}

		return $error;
	}

	protected function validateUser($data){

		$error = null;

		if(empty($data['username']) || empty($data['email']) ||
		   empty($data['password']) || empty($data['password_check'])) {
			$error = 'You did not fill in all required fields.';
		}

		if(is_null($error)) {
			if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
				$error = 'Your email address is invalid.';
			}
		}

		if(is_null($error)) {
			if($data['password'] != $data['password_check']) {
				$error = "Your passwords didn't match.";
			}
		}

		if(is_null($error)) {
			$count = $this->db->getRowcount('SELECT 1 FROM user WHERE username = ?',array($data->username));
			if($count > 0) {
				$error = 'Your chosen username already exists. Please choose another.';
			}
		}

		return $error;
	}

	public function hashPassword($salt,$password){

		return md5($salt . $password);	// THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
	}

	public function createUser($username,$email,$password){

		$error = null;
		$params = array();

		//validate()
		$data = array('username'=>$username,'email'=>$email,'password'=>$password);
		$error = $this->validateUser($data);

		if(isnull($error)) {
			$params = array(
				$data['username'],
				$data['email'],
				$this->hashPassword($data['username'],$data['password']),
			);

			$this->db->insert('INSERT INTO user (username, email, password) VALUES (?, ?, ?)',$params);
		}

		return $error;
	}

	public function changePassword($username, $password, $password_check){

		$error = null;
		$data = array('password'=>$password,'password_check'=>$password_check);

		$error = $this->validatePassword($data);

		if(is_null($error)){
			$sql = 'UPDATE user SET password = ? WHERE username = ?';
			$params = array($this->hashPassword($username,$password),$username);
			$this->db->insert($sql,$params);
		}

		return $error;
	}

	public function getUser($username){

		return $this->db->getOne('SELECT * FROM user WHERE username = ?',array($username));
	}

}