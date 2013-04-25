<?php

interface Database_Statement_Interface {

	public function __construct(Database_Mysql $db, PDOStatement $stmt);
  
 	public function fetch($fetchtype);
    
    public function fetchAll($fetchtype);
    
	public function rowCount();

	public function execute(array $params);

}