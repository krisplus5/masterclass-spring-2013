<?php

abstract class Database_Base {
	
	protected $config;
	protected $dbconfig;
	protected $dsn;
	protected $db;
	
	public function __construct ($config){
		$this->config = $config;
		$this->dbconfig = $config['database'];
	}
	
	abstract public function connect();
	
	public function prepare($sql, array $options = array()){
		return $this->db->prepare($sql, $options);
	}
	
}
