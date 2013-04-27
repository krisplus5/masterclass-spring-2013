<?php 

class response_HttpRedirect implements Response_Interface{

	protected $_url = '';

	public function setUrl($url){
		$this->_url = $url;
	}
	
	public function renderResponse(){
		header("Location: " . $this->_url);	
	}

}