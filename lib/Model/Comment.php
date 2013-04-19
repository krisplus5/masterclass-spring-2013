<?php

class Model_Comment {

    protected $db;
    protected $config;

    public function __construct($config,$db) {
     	$this->config = $config;
        $this->db = $db;
    }

	public function getCommentsForStory($storyID){

		return $this->db->getOne('SELECT * FROM comment WHERE story_id = ?',array($storyID));
	}

	public function createComment($created_by,$story_id,$comment){

 		if(strlen($comment) > 0){
            $filteredcomment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
			$this->db->insert($sql,array($this->session->get('username'),$story_id,$filteredcomment));
		}

	}

	public function getCommentsByStory($storyid){

		$count = 0;
		$sql = 'SELECT id, created_by, comment FROM comment WHERE story_id = ?';
		$data = $this->db->getAll($sql,array($storyid));
		$count = $this->db->getRowcount();

		return array('data'=>$data,'rowcount'=>$count);
	}

}
