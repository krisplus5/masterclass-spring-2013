<?php

class Model_User {

    protected $config;
    protected $db;

    public function __construct($config,$db,$session) {
    	$this->config = $config;
        $this->db = new Util_DBmysql($config);
		$this->session = $session;
    }

	public function get($id=0){
        $sql = 'SELECT * FROM user WHERE username = ?';
		return $this->db->get($sql,array($id));
	}

    public function create($username='', $email='', $password='') {
		$this->model->create($username,$email,$password);
		return $this->db->getLast_id();
    }

    public function changePassword($username,$password) {

        $sql = 'UPDATE user SET password = ? WHERE username = ?';
        $params = array(hashPassword($username,$password), $username);

		$this->db->insert($sql,$params);
	}

    public function authenticate($username,$password) {

        $sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';
		$params = array($username,$this->hashPassword($username,$password));
		
		$data = $this->db->get($sql,$params);
		
		if($this->db->getLast_query.rowCount() > 0){
			$this->session->authenticate();
			$this->session->regenerate();
			$this->session->set('username',$data['username']);
			$this->session->set('AUTHENTICATED',true);
        }

		return array('authenticated'=>true,$data);
    }
    
    protected function hashPassword($salt='',$password=''){
    	return(md5($password . $salt));
    }

}
