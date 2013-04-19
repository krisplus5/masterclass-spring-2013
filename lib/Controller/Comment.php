<?php

class Controller_Comment {

	protected $db;
    protected $config;
    protected $model;
    protected $session;

    public function __construct($config) {
      	$this->config = $config;
        $this->db = new Util_MySQL($config);
		$this->model = new Model_Comment($config,$this->db);
		$this->session = new Util_Session($config,$this->db);
    }

    public function create() {
        if($this->session->isAuthenticated()) {
            die('not auth');
            header("Location: /");
            exit;
        }

		$this->model->createComment($this->session->get('username'),$_POST['story_id'],filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        header("Location: /story/?id=" . $_POST['story_id']);
    }

}