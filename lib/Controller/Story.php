<?php

class Controller_Story {

    protected $db;
    protected $config;
    protected $model;
	protected $commentmodel;
	protected $session;

    public function __construct($config) {
     	$this->config = $config;
        $this->db = new Util_MySQL($config);
		$this->model = new Model_Story($config,$this->db);
		$this->commentmodel = new Model_Comment($config,$this->db);
		$this->session = new Util_Session($config,$this->db);
    }

    public function index() {
        if(!isset($_GET['id'])) {
            header("Location: /");
            exit;
        }

		$story = $this->model->getStory($_GET['id']);

        if(count($story) < 1) {
            header("Location: /");
            exit;
        }

		$comments = $this->commentmodel->getCommentsByStory($_GET['id']);
		$comment_count = $this->commentmodel->getCommentCountByStory($_GET['id']);

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

        foreach($comments as $comment) {
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

        $error = null;
        if(isset($_POST['create'])) {

			$error = $this->model->createStory($_POST['headline'],$_POST['url'],$this->session->get('username'));
			if(is_null($error)){
				$id = $this->db->getLastID();
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