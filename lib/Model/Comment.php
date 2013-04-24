<?php

class Model_Comment extends Model_Base {
    
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

}