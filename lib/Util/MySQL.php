<?php

class Util_MySQL {

    protected $db;
    protected $config;
    protected $last_query;
    protected $last_id = 0;

    public function __construct($config) {
     	$this->config = $config;
        $dbconfig = $config['database'];
        $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
        $this->db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

	protected function _runSQL($sql, array $params){

		$stmt = $this->db->prepare($sql);
		$stmt->execute($params);
		$this->last_query = $stmt;
		return $stmt;
	}

    public function getAll($sql,array $params){

		$result = $this->_runSQL($sql,$params);
		return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($sql,array $params){

		$result = $this->_runSQL($sql,$params);
		return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($sql,array $params){

    	$this->_runSQL($sql,$params);
    	$this->last_id = $this->db->lastInsertId();
    	
    	return 0;
    }

	public function getRowcount($sql,array $params){

		if($this->last_query instanceof PDOStatement){
			return $this->last_query->rowCount();
		}
		return 0;
	}

	public function getLastID(){

		return $this->last_id;
	}

	public function getLastQuery(){

		return $this->last_query;
	}


}