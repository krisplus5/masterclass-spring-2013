<?php 

class Model_Base {

    protected $db;
    protected $last_query;
    protected $last_insert_id;
    
    public function __construct($config) {
        $this->config = $config;
        $this->db = new Database_Mysql($config['database']);
    }

	protected function insert($sql, array $args = array()){
		$result = $this->_do_insert_or_delete($sql, $args);
        $this->last_insert_id = $this->db->lastInsertId();
        return $result;
	}

	protected function fetch($sql, array $args = array()){
		$stmt = $this->_do_prepare_and_query($sql, $args);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	protected function fetchAll($sql, array $args = array()){
		$stmt = $this->_do_prepare_and_query($sql, $args);
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

    protected function _do_insert_or_delete($sql, array $args = array()) {
        $stmt = $this->db->prepare($sql);
        $this->last_query = $stmt;
        return $stmt->execute($args);
    }

	protected function _do_prepare_and_query($sql, array $args = array()){
		$stmt = $this->db->prepare($sql);
		$stmt->execute($args);
		$this->last_query = $stmt;
		return $stmt;
	}

	protected function lastInsertId(){
		return $this->last_insert_id;
	}

}