<?php 

abstract class Controller_Base {

    protected $model;
    protected $config = array();
    protected $session;
    protected $request;

    public function __construct(array $config = array(), Session_Interface $session, Request_Interface $request) {
        $this->config = $config;
        $this->session = $session;
        $this->_loadModels();
		$this->request = $request;
    }
    
    abstract protected function _loadModels();

}