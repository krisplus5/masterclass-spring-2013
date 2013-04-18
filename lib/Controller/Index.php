<?php

class Controller_Index {

    protected $db;
    protected $config;

    public function __construct($config) {
     	$this->config = $config;
        $this->db = new $Model_MySQL($config);
    }

    public function index() {

		$stories = $this->db->getAll('SELECT * FROM story ORDER BY created_on DESC');

        $content = '<ol>';

        foreach($stories as $story) {
        	$count = $this->db->getRowcount('SELECT 1 FROM comment WHERE story_id = ?',array($story['id']));
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