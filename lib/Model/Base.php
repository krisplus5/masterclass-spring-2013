<?php 

class Model_Base {

    protected $db;
    
    public function __construct($config) {
        $this->config = $config;
        $this->db = new Database_Mysql($config['database']);
    }

    protected function _do_insert_or_delete($sql, array $args = array()) {
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($args);
    }

	protected function _do_prepare_and_query($sql, array $args = array()){
		$stmt = $this->db->prepare($sql);
		$stmt->execute($args);
		return $stmt;
	}

}