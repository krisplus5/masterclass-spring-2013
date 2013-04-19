<?php

class Controller_Comment {

	protected $db;
    protected $config;
    protected $model;

    public function __construct($config) {
    	$this->config = $config;
        $this->db = new $Model_MySQL($config);
		$this->model = new Model_Comment($config,$db);
    }

    public function create() {
        if(!isset($_SESSION['AUTHENTICATED'])) {
            die('not auth');
            header("Location: /");
            exit;
        }

        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(
            $_SESSION['username'],
            $_POST['story_id'],
            filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
        ));
        header("Location: /story/?id=" . $_POST['story_id']);
    }

}