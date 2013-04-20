<?php

class Model_Story {

	protected $db;
    protected $config;

    public function __construct($config) {
    	$this->config = $config;
        $this->db = new Model_DBmysql($config);
    }

	public function getStory($id = 0){

        $sql = 'SELECT * FROM story WHERE id = ?';
        $params = array($id);
        
        return $this->db->get($sql,$params);
	}

	public function getStories(){

        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
        
        return $this->db->get($sql,array());
	}

	public function getStoryComments($id = 0){
        $sql = 'SELECT * FROM comment WHERE story_id = ?';
        $params = array($story['id']);

		$comments = $this->db->get($sql,$params);
        $comment_count = $this->getRowcount();

		return array('comments'=>$comments,'count'=>$comment_count);
    }

    public function create($headline, $url, $created_by) {
    	
		$sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
		$params = array($headline,$url,$created_by);
		$this->db->insert($sql,$params);

		return $this->db->getLast_id;
    }

}