<?php

class Model_Comment {

    protected $db;
    protected $config;

    public function __construct($config,$db) {
     	$this->config = $config;
        $this->db = $db;
    }

	public function getCommentsForStory(int $storyID = 0){

		return = $this->db->getOne('SELECT * FROM comment WHERE story_id = ?',array($storyID));
	}

	public function createComment(string $created_by='',int $story_id=0,string $comment=''){

        if(!isset($_SESSION['AUTHENTICATED'])) {
            die('not auth');
            header("Location: /");
            exit;
        }

		if(strlen($comment) > 0){
            $filteredcomment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
	        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
			$this->db->insert($sql,array($_SESSION['username'],$story_id,$filteredcomment));
		}

	}

	public function getCommentsByStory(int $storyid=0){

		$count = 0;
		$sql = 'SELECT id, created_by, comment FROM comment WHERE story_id = ?';
		$data $this->db->getAll($sql,array($storyid));
		$count = $this->db->getRowcount();

		return array('data'=>$data,'rowcount'=>$count);
	}

}
