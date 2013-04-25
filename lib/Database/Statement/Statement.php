 <?php 
  
 class Database_Statement_Statement implements Database_Statement_Interface {

	protected $db;
	protected $stmt;

	public function __construct(Database_Mysql $db, PDOStatement $stmt) {
        $this->db = $db;
        $this->stmt = $stmt;
    }
  
 	public function fetch($fetchtype = PDO::FETCH_ASSOC) {
        return $this->stmt->fetch($fetchtype);
    }
    
    public function fetchAll($fetchtype = PDO::FETCH_ASSOC) {
        return $this->stmt->fetchAll($fetchtype);
    }
    
	public function rowCount() {
        if($this->stmt instanceof PDOStatement) {
            return $this->stmt->rowCount();
        }
        return 0;
    }

	public function execute(array $params = array()){
		return $this->stmt->execute($params);
	}
    
}