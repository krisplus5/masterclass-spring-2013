<?php

class Controller_User extends Controller_Base {
    
	protected function _loadModels(){
		$this->model = new Model_User($this->config);
	}

    public function create() {
        $error = null;
 		$details = array('username'=>'','email'=>'','password'=>'','password_check'=>'');
        
        // Do the create
        if($this->request->get('create')) {
			$details = array('username'=>$this->request->get('username'),'email'=>$this->request->get('email'),'password'=>$this->request->get('password'),'password_check'=>$this->request->get('password_check'));

            if(empty($details['username']) || empty($details['email']) ||
               empty($details['password']) || empty($details['password_check'])) {
                $error = 'You did not fill in all required fields.';
            }
            
			if(is_null($error)) {
				if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)) {
					$error = 'Your email address is invalid';
				}
			}
            
			if(is_null($error)) {
				if($details['password'] != $details['password_check']) {
					$error = "Your passwords didn't match.";
				}
			}
            
			if(is_null($error)) {

				if($this->model->checkUsername($details['username']) > 0) {
					$error = 'Your chosen username already exists. Please choose another.';
				}
			}
            
            if(is_null($error)) {
                $params = array(
                    $details['username'],
                    $details['email'],
                    md5($details['username'] . $details['password']),
				);
				$this->model->createUser($params);

	        	$response = new Response_HttpRedirect();
	        	$response->setUrl('/user/login');
	        	return $response->renderResponse();
			}
		}
		$details = array_merge(array('error'=>$error),$details);

		$response = new Response_Http();
 
        return $response->showView(($details),
			$this->config['views']['view_path'] . '/user_create.php',
			$this->config['views']['layout_path'] . '/layout.phtml');
    }
    
    public function account() {
        $error = null;
        if(!$this->session->isAuthenticated()) {
         	$response = new Response_HttpRedirect();
        	$response->setUrl('/user/login');
        	return $response->renderResponse();
        }
        
        if($this->request->get('updatepw')) {
            if($this->request->get('password')=='' || $this->request->get('password_check')=='' ||
               $this->request->get('password') != $this->request->get('password_check')) {
                $error = 'The password fields were blank or they did not match. Please try again.';       
            }
            else {
                $this->model->changeUserPassword($this->session->username, $this->request->get('password'));
                $error = 'Your password was changed.';
            }
        }

        $details = $this->model->getUserData($this->session->username);

		$response = new Response_Http();
        return $response->showView(array('error' => $error, 'username' => $details['username'], 'email' => $details['email']),
			$this->config['views']['view_path'] . '/user_account.php',
			$this->config['views']['layout_path'] . '/layout.phtml');
    }
    
    public function login() {
        $error = null;
  		$details = array('user'=>'','pass'=>'');
        
        // Do the login
        if($this->request->get('login')) {
	  		$details = array('user'=>$this->request->get('user'),'pass'=>$this->request->get('pass'));
            $username = $details['user'];
            $password = $details['pass'];
            $result = $this->model->authenticateUser($username, $password);
            if($result['authenticated']) {
				$data = $result['user'];
				$this->session->regenerate();
				$this->session->authenticate();
				$this->session->__set('username',$data['username']);
 
				$response = new Response_HttpRedirect();
	        	$response->setUrl('/');
	        	return $response->renderResponse();
            }
            else {
                $error = 'Your username/password did not match.';
            }
        }
        
        $details = array_merge($details,array('error'=>$error));
        
		$response = new Response_Http();
        return $response->showView(($details),
			$this->config['views']['view_path'] . '/login.php',
			$this->config['views']['layout_path'] . '/layout.phtml');
        
    }
    
    public function logout() {
        // Log out, redirect
        $this->session->destroy();
        	$response = new Response_HttpRedirect();
        	$response->setUrl('/');
        	return $response->renderResponse();
    }
}