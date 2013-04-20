<?php

class Controller_Story {

    protected $config;
	protected $db;
	protected $model;
	protected $session;    

    public function __construct($config) {
 		$this->config = $config;
    	$this->db = new Util_Database_Mysql($config);
		$this->model = new Model_Story($config,$this->db);
		$this->session = new Util_Session();
    }

    public function index() {
        if(!isset($_GET['id'])) {
            header("Location: /");
            exit;
        }

		$story = $this->model->getStory($_GET['id']);
        if($this->db->getRowcount() < 1) {
            header("Location: /");
            exit;
        }

		$comments = $this->model->getStoryComments($story['id']);
		$comment_count = $comments['count'];

        $content = '
            <a class="headline" href="' . $story['url'] . '">' . $story['headline'] . '</a><br />
            <span class="details">' . $story['created_by'] . ' | ' . $comment_count . ' Comments |
            ' . date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
        ';

		if($this->session->isAuthenticated()) {
            $content .= '
            <form method="post" action="/comment/create">
            <input type="hidden" name="story_id" value="' . $_GET['id'] . '" />
            <textarea cols="60" rows="6" name="comment"></textarea><br />
            <input type="submit" name="submit" value="Submit Comment" />
            </form>
            ';
        }

        foreach($comments['comments'] as $comment) {
            $content .= '
                <div class="comment"><span class="comment_details">' . $comment['created_by'] . ' | ' .
                date('n/j/Y g:i a', strtotime($story['created_on'])) . '</span>
                ' . $comment['comment'] . '</div>
            ';
        }

		require $this->config['views']['layout_path'] . '/layout.phtml';

    }

    public function create() {
    	
		if($this->session->isAuthenticated()) {
            header("Location: /user/login");
            exit;
        }

        $error = '';
        if(isset($_POST['create'])) {
            if(!isset($_POST['headline']) || !isset($_POST['url']) ||
               !filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL)) {
                $error = 'You did not fill in all the fields or the URL did not validate.';
            } else {
            	$id = $this->model->create($_POST['headline'],$_POST['url'],$this->session->get('username'));

                header("Location: /story/?id=$id");
                exit;
            }
        }

        $content = '
            <form method="post">
                ' . $error . '<br />

                <label>Headline:</label> <input type="text" name="headline" value="" /> <br />
                <label>URL:</label> <input type="text" name="url" value="" /><br />
                <input type="submit" name="create" value="Create" />
            </form>
        ';

		require $this->config['views']['layout_path'] . '/layout.phtml';

    }

}