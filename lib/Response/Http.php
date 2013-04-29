<?php 

class Response_Http implements Response_Interface {
	
	protected $_data = array();
	protected $_view;
	protected $_layout;
	
	public function set($key, $value){
		$this->_data[$key] = $value;
	}

	public function setArgs(array $args){
		$this->_data = array_merge($this->_data,$args);
	}
	
	public function setView($path = ''){
		$this->_view = $path;
	}

	public function setLayout($path = ''){
		$this->_layout = $path;
	}

	public function showView(array $args, $view, $layout){
		$this->setArgs($args);
		$this->setView($view);
		$this->setLayout($layout);
		return $this->renderResponse();
	}

	public function renderResponse(){
		$data = $this->_data;
		ob_start();
		require_once $this->_view;
		$content = ob_get_clean();
		
		ob_start();
		require_once $this->_layout;
		return ob_get_clean();
	}

}
