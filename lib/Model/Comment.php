<?php

class Model_Comment{

	protected $db;
    protected $config;

    public function __construct($config) {
    	$this->config = $config;
        $this->db = new Model_DBmysql($config);
    }

    public function create($sql,array $params=array()) {
		$this->db->insert($sql,$params);
    }

}