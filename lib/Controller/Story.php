<?php

class Controller_Story extends Controller_Base {
    
    protected $story_model;
    protected $comment_model;
    
	protected function _loadModels(){
		$this->story_model = new Model_Story($this->config);
		$this->comment_model = new Model_Comment($this->config);
	}

    public function index() {
        if(!$this->request->get('id')) {
        	$response = new Response_HttpRedirect();
        	$response->setUrl('/');
        	return $response->renderResponse();
        }
        
        $story = $this->story_model->getStory($this->request->get('id'));
        if(count($story) < 1) {
        	$response = new Response_HttpRedirect();
        	$response->setUrl('/');
        	return $response->renderResponse();
        }
                
        $comments = $this->comment_model->getStoryComments($this->request->get('id'));

		$details = array('story'=>$story,'comments'=>$comments,'comment_count'=>count($comments),'authenticated'=>$this->session->isAuthenticated());

		$response = new Response_Http();
 		$response->setArgs(array('isAuthenticated'=>$this->session->isAuthenticated()));
 
        return $response->showView(($details),
			$this->config['views']['view_path'] . '/story_list.php',
			$this->config['views']['layout_path'] . '/layout.phtml');
    }
    
    public function create() {
        if(!$this->session->isAuthenticated()) {
         	$response = new Response_HttpRedirect();
        	$response->setUrl('/');
        	return $response->renderResponse();
        }
        
        $error = '';
		$details = array('headline'=>'','url'=>'');

        if($this->request->get('create')) {
        	
        	$details['headline'] = $this->request->get('headline');
			$details['url'] = $this->request->get('url');
        	
            if($details['headline']=='' || $details['url']=='' || !filter_var($details['url'], FILTER_VALIDATE_URL)) {
				$error = 'You did not fill in all the fields or the URL did not validate.';       
            } else {
                $args = array(
                   $details['headline'],
                   $details['url'],
                   $this->session->username,
				);
				$id = $this->story_model->createStory($args);

				$response = new Response_HttpRedirect();
                $response->setUrl("/story/?id=$id");
				return $response->renderResponse();
            }
        }
        
		$details = array_merge($details,array('error'=>$error));
        
		$response = new Response_Http();
		$response->setArgs(array('isAuthenticated'=>$this->session->isAuthenticate()));
 
        return $response->showView(($details),
			$this->config['views']['view_path'] . '/story_form.php',
			$this->config['views']['layout_path'] . '/layout.phtml');
    }
    
}