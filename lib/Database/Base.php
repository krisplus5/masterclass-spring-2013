<?php

abstract class Database_Base implements Database_Interface {
	
	protected $dbconfig = array();
	protected $db;
	
	public function __construct (array $dbconfig = array()){
		$this->dbconfig = $dbconfig;
		$this->_connect();
	}
	
	abstract protected function _connect();
	
	abstract public function prepare($sql, array $options = array());
	
}
