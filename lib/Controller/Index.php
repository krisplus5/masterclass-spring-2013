<?php

class Controller_Index {

    protected $db;
    protected $config;
    protected $storymodel;

    public function __construct($config) {
     	$this->config = $config;
		$this->db = new Util_DBmysql($config);
		$this->storymodel = new Model_Story($config,$this->db);
    }

    public function index() {

		$stories = $this->storymodel->getStories();
        
        $content = '<ol>';
        
		if($stories){
	        foreach($stories as $story) {
	            $count = $this->comment_model->getCommentCountForStory($story['id']);
	            $content .= '
	                <li>
	                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
	                <span class="details">' . $story['created_by'] . ' | <a href="/story/?id=' . $story['id'] . '">' . $comments['count'] . ' Comments</a> | 
	                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
	                </li>
	            ';
	        }
		}
		
        $content .= '</ol>';

		require $this->config['views']['layout_path'] . '/layout.phtml';

    }
}