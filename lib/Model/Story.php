<?php

class Model_Story {

    protected $db;
    protected $config;

    public function __construct($config,$db) {
     	$this->config = $config;
        $this->db = $db;
    }

	protected function validateStory(array $story=array()){
		$error = null;

		if(!isset($story['headline']) || !isset($story['url']) ||
			!filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL)) {
               $error = 'You did not fill in all the fields or the URL did not validate.';
		}
		return $error;
	}

	public function getStory(int $storyID = 0){

		return = $this->db->getOne('SELECT * FROM story WHERE id = ?',array($storyID));
	}

	public function getStories(){

		return = $this->db->getAll('SELECT * FROM story ORDER BY created_on DESC');
	}

	public function createStory(string $headline='', string $url='', string $created_by=''){
		$error = null;

		$error = $this->validateStory(array('headline'=>$headline,'url'=>$url,'created_by'=>$created_by);

		if(is_null($error)){
			$error = $this->db->insert('',array($headline,$url,$created_by);
		}

		return $error;
	}
