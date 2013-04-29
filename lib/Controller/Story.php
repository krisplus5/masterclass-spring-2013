<?php

class Controller_Story extends Controller_Base {
    
    protected $story_model;
    protected $comment_model;
    
	protected function _loadModels(){
		$this->story_model = new Model_Story($this->config);
		$this->comment_model = new Model_Comment($this->config);
	}

    public function index() {
        if(!isset($_GET['id'])) {
            header("Location: /");
            exit;
        }
        
        $story = $this->story_model->getStory($_GET['id']);
        if(count($story) < 1) {
            header("Location: /");
            exit;
        }
                
        $comments = $this->comment_model->getStoryComments($_GET['id']);

		$details = array('story'=>$story,'comments'=>$comments,'comment_count'=>count($comments),'authenticated'=>$this->session->isAuthenticated());

		$response = new Response_Http();
 
        return $response->showView(($details),
			$this->config['views']['view_path'] . '/story_list.php',
			$this->config['views']['layout_path'] . '/layout.phtml');
    }
    
    public function create() {
        if(!$this->session->isAuthenticated()) {
            header("Location: /user/login");
            exit;
        }
        
        $error = '';
		$details = array('headline'=>'','url'=>'');

        if(isset($_POST['create'])) {
        	
        	if(isset($_POST['headline'])){
	        	$details['headline'] = $_POST['headline'];
			}
			if(isset($_POST['url'])){
				$details['url'] = $_POST['url'];
			}
        	
            if($details['headline']=='' || $details['url']=='' || !filter_var($details['url'], FILTER_VALIDATE_URL)) {
				$error = 'You did not fill in all the fields or the URL did not validate.';       
            } else {
                $args = array(
                   $details['headline'],
                   $details['url'],
                   $this->session->username,
				);
				$id = $this->story_model->createStory($args);
				header("Location: /story/?id=$id");
				exit;
            }
        }
		$details = array_merge($details,array('error'=>$error));
        
		$response = new Response_Http();
 
        return $response->showView(($details),
			$this->config['views']['view_path'] . '/story_form.php',
			$this->config['views']['layout_path'] . '/layout.phtml');
    }
    
}