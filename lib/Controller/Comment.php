<?php

class Controller_Comment {

    protected $config;
	protected $db;
	protected $model;
	protected $session;    

    public function __construct($config) {
    	$this->config = $config;
    	$this->db = new Util_DBmysql($config);
		$this->model = new Model_Comment($config,$this->db);
		$this->session = new Util_Session();
    }

    public function create() {
    	if($this->session->isAuthenticated()){
            die('not auth');
            header("Location: /");
            exit;
        }

        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
		$params = array(
            $_SESSION['username'],
            $_POST['story_id'],
            filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        ));
		$this->model->create($sql,$params);

        header("Location: /story/?id=" . $_POST['story_id']);
    }

}