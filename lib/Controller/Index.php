<?php

class Controller_Index {

    protected $db;
    protected $config;
    protected $model;
    protected $commentmodel;

    public function __construct($config) {
     	$this->config = $config;
        $this->db = new Util_MySQL($config);
		$this->model = new Model_Story($config,$this->db);
		$this->commentmodel = new Model_Comment($config,$this->db);
    }

    public function index() {

		$stories = $this->model->getStories();

        $content = '<ol>';

        foreach($stories as $story) {
        	$count = $this->commentmodel->getCommentsByStory($story['id']);
            $content .= '
                <li>
                <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
                <span class="details">' . $story['created_by'] . ' | <a href="/story/?id=' . $story['id'] . '">' . $count . ' Comments</a> |
                ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                </li>
            ';
        }

        $content .= '</ol>';

		require $this->config['views']['layout_path'] . '/layout.phtml';

    }
}