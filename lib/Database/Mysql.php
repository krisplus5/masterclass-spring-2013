<?php

class Database_Mysql extends Database_Base {

 	public function _connect(){
 		$dsn = 'mysql:host=' . $this->dbconfig['host'] . ';dbname=' . $this->dbconfig['name'];
 		$this->db = new PDO($dsn, $this->dbconfig['user'], $this->dbconfig['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 	}
	
    public function prepare($sql, array $options = array()) {
        $stmt = $this->db->prepare($sql, $options);
		return new Database_Statement($this, $stmt);
    }
    
    protected function lastInsertId() {
        return $this->db->lastInsertId();
    }

}