<?php

class Model_Comment{

	protected $db;
    protected $config;

    public function __construct($config,$db) {
    	$this->config = $config;
		$this->db = $db;
    }

    public function create($sql,array $params=array()) {
		$this->db->insert($sql,$params);
    }

}