<?php

class Model_User {

    protected $config;
	protected $db;

    public function __construct($config) {
     	$this->config = $config;
        $this->db = new Model_MySQL($config);
    }

	public function createUser($data){

		$error = null;
		$params = array();

		//validate()
		$error = $this->validate($data);

		if(isnull($error)) {
			$params = array(
				$data['username'],
				$data['email'],
				md5($data['username'] . $data['password']),
			);

			$this->db->runSQL('INSERT INTO user (username, email, password) VALUES (?, ?, ?)',$params);
		}

		return $error;

	}

	protected function validate($data){

		$error = null;

		if(empty($data['username']) || empty($data['email']) ||
		   empty($data['password']) || empty($data['password_check'])) {
			$error = 'You did not fill in all required fields.';
		}

		if(is_null($error)) {
			if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
				$error = 'Your email address is invalid';
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

	public function changePassword($username, $password){

		$sql = 'UPDATE user SET password = ? WHERE username = ?';
		$params = array(
			md5($username . $password), // THIS IS NOT SECURE.
			$username,
		);

		return $this->db->insert($sql,$params);
	}


	public function authUser(){}

	public function getUser(){}

}