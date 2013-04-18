<?php

class Model_MySQL {

    protected $db;
    protected $config;
	protected static $instance = null;

    protected function __construct($config) {
     	$this->config = $config;
        $dbconfig = $config['database'];
        $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
        $this->db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$isInstanced = true;
   		static::$instance = new static;
    }

	protected function _runSQL($sql,array $params=array()){

		$stmt = $this->db->prepare($sql);

		return $stmt->execute($args);
	}

    public static function getInstance($config) {
    	if(!isset(static::$instance)){
    		self::__construct($config);
    	}
    	return static::$instance;
    }

    public function getAll($sql,$params){

		$result = $this->_runSQL($sql,$params);

		return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOne($sql,$params){

		$result = $this->_runSQL($sql,$params);

		return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($sql,$params){
    	return $this->_runSQL($sql,$params);
    }

	public function getRowcount($sql,$params){
		return $this->_runSQL($sql,$params)->rowCount();
	}

}