<?php

class Model_Story extends Model_Base {
    
    public function getListOfStories() {
        $sql = 'SELECT * FROM story ORDER BY created_on DESC';
		return $this->fetchAll($sql);
    }
    
    public function getStory($story_id) {
        $sql = 'SELECT * FROM story WHERE id = ?';
        return $this->fetch($sql,array($story_id));
    }
    
    public function createStory(array $params = array()) {
        $sql = 'INSERT INTO story (headline, url, created_by, created_on) VALUES (?, ?, ?, NOW())';
		$this->insert($sql,$params);
		$id = $this->lastInsertId();
		return $id;
    }

}
