<?php

class Model_User extends Model_Base {
    
    public function createUser(array $params = array()) {
        $sql = 'INSERT INTO user (username, email, password) VALUES (?, ?, ?)';
 		return $this->_do_insert_or_delete($sql,$params);
    }
    
    public function checkUsername($username) {
        $sql = 'SELECT * FROM user WHERE username = ?';
        $stmt = $this->_do_prepare_and_query($sql, array($username));
        return $stmt->rowCount();
    }
    
    public function authenticateUser($username, $password) {
        $password = md5($username . $password); // THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
        $sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';
		$stmt = $this->_do_prepare_and_query($sql, array($username, $password));
		$user = $stmt->fetch();

        return array('authenticated' => $stmt->rowCount(), 'user' => $user);
    }
    
    public function getUserData($username) {
        $sql = 'SELECT * FROM user WHERE username = ?';
        $stmt = $this->_do_prepare_and_query($sql, array($username));    
        return $stmt->fetch();    
    }
    
    public function changeUserPassword($username, $password) {
        $sql = 'UPDATE user SET password = ? WHERE username = ?';
        $params = array(
           md5($username . $password), // THIS IS NOT SECURE. 
           $username,
        );
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

}