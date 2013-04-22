<?php

class Database_Mysql extends Database_Base {
    
 	public function connect(){
 		$this->dsn = 'mysql:host=' . $this->dbconfig['host'] . ';dbname=' . $this->dbconfig['name'];
 		$this->db = new PDO($dsn, $this->dbconfig['user'], $this->dbconfig['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 	}
	
 }