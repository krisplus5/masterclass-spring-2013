<?php 

interface Database_Interface {

	public function __construct(array $dbconfig);

	public function prepare($sql, array $options);

}