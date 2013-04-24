<?php

class Model_Story {
    
    protected $db; 
    protected $last_insert_id;
    protected $last_query;
    
    public function __construct($config) {
        $this->config = $config;
        $this->db = new Database_Mysql($config['database']);
    }
    
    public function getListOfStories() {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
		$stmt = $this->_do_prepare_and_query($sql);
		return $stmt->fetchAll();
    }
    
    public function getStory($story_id) {
        $sql = 'SELECT * FROM story WHERE id = ?';
        $stmt = $this->_do_prepare_and_query($sql,array($story_id));
        return $stmt->fetch();
    }
    
    public function createStory(array $params = array()) {
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
		$this->_do_insert_or_delete($sql,$params);
        return $this->last_insert_id;
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
