<?php

class Util_DBmysql {

	protected $config;
	protected $db;
	protected $last_query;
	protected $last_id = 0;
	
	public function __construct($config){
		$this->config = $config;
		$dbconfig = $config['database'];
		$dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
		$this->db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}


	public function get($sql, array $params){
		$stmt = $this->setupQuery($sql,$params);
		return $stmt->fetch(PDO::FETCH_ASSOC);	
	}

	public function insert($sql, array $params){
		$result = $this->perform($sql,$params);
		$this->last_id = $this->db->lastInsertId();
	}

	public function delete($sql, array $params){
		return $this->perform($sql,$params);
	}

	public function getRowcount(){
		if($this->last_query instanceof PDOStatement){
			return $this->last_query->rowCount();
		}
		return 0;
	}

	public function getLast_id(){
		return $this->last_id;
	}

	protected function getLast_query($sql, array $params){
		$stmt = $this->db->prepare($sql);
		$stmt->execute($params);
		
		$this->last_query = $stmt;
		return $stmt;
	}

	protected function setupQuery($sql, array $params){
		$stmt = $this->db->prepare($sql);
		$stmt->execute($params);
		$this->last_query = $stmt;
		return $stmt;
	}

	protected function perform($sql, array $params){
		$stmt = $this->db->prepare($sql);
		$this->last_query = $stmt;
		return $stmt->execute($params);
	}

}