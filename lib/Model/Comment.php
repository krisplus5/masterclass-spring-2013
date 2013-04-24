<?php

class Model_Comment {
    
    public function __construct($config) {
        $this->config = $config;
        $this->db = new Database_Mysql($config['database']);
    }
    
    public function getCommentCountForStory($story_id) {
        $comment_sql = 'SELECT * FROM comment WHERE story_id = ?';
        $stmt = $this->_do_prepare_and_query($comment_sql, array($story_id));
        return $stmt->rowCount();
    }
    
    public function getStoryComments($story_id) {
        $comment_sql = 'SELECT * FROM comment WHERE story_id = ?';
        $stmt = $this->_do_prepare_and_query($comment_sql, array($story_id));
        return $stmt->fetchAll();
    }
    
    public function createComment(array $params = array()) {
        $sql = 'INSERT INTO comment (created_by, created_on, story_id, comment) VALUES (?, NOW(), ?, ?)';
        return $this->_do_insert_or_delete($sql, $params);
    }

    protected function _do_insert_or_delete($sql, array $args = array()) {
        $stmt = $this->db->prepare($sql);
        $this->last_query = $stmt;
        return $stmt->execute($args);
    }

	protected function _do_prepare_and_query($sql, array $args = array()){
		$stmt = $this->db->prepare($sql);
		$stmt->execute($args);
		$this->last_query = $stmt;
		return $stmt;
	}


}