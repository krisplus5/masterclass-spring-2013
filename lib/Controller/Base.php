<?php 

abstract class Controller_Base {

    protected $model;
    protected $config = array();
    protected $session;

    public function __construct(array $config = array(), Session_Interface $session, Request_Interface $request) {
        $this->config = $config;
        $this->session = $session;
        $this->_loadModels();
    }
    
    abstract protected function _loadModels();

}