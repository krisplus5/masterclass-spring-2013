<?php

class Controller_User {

    protected $db;
    protected $config;
    protected $model;
	protected $session;

    public function __construct($config) {
    	$this->config = $config;
        $this->db = new Util_MySQL($config);
		$this->model = new Model_User($config,$this->db);
		$this->session = new Util_Session($config,$this->db);
    }

    public function create() {
        $error = null;

        // Do the create
        if(isset($_POST['create'])) {

			$error = $model->createUser($_POST['username'],$_POST['email'],$_POST['password']);

			if(is_null($error)){
				header("Location: /user/login");
				exit;
			}
        }

        // Show the create form
        $content = '
            <form method="post">
                ' . $error . '<br />
                <label>Username</label> <input type="text" name="username" value="" /><br />
                <label>Email</label> <input type="text" name="email" value="" /><br />
                <label>Password</label> <input type="password" name="password" value="" /><br />
                <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
                <input type="submit" name="create" value="Create User" />
            </form>
        ';

		require $this->config['views']['layout_path'] . '/layout.phtml';

    }

    public function account() {
        $error = null;
        
        if(!$this->session->isAuthenticated()){
            header("Location: /user/login");
            exit;
        }

        if(isset($_POST['updatepw'])) {
			$error = $this->model->changePassword($this->session->get('username'),$_POST['password'],$_POST['password_check']);
			if(is_null($error)){
				$error = 'Your password was changed.';
			}
        }

		$details = $this->model->getUser($this->session->get('username'));

        $content = '
        ' . $error . '<br />

        <label>Username:</label> ' . $details['username'] . '<br />
        <label>Email:</label>' . $details['email'] . ' <br />

         <form method="post">
                ' . $error . '<br />
            <label>Password</label> <input type="password" name="password" value="" /><br />
            <label>Password Again</label> <input type="password" name="password_check" value="" /><br />
            <input type="submit" name="updatepw" value="Create User" />
        </form>';

		require $this->config['views']['layout_path'] . '/layout.phtml';

    }

    public function login() {
        $error = null;

        // Do the login
        if(isset($_POST['login'])) {

			$username = $_POST['user'];
			$password = $_POST['pass'];
	
			$error = $this->session->authenticate($username,$password);

            if(!is_null($error)) {
               header("Location: /");
               exit;
            }
        }

        $content = '
            <form method="post">
                ' . $error . '<br />
                <label>Username</label> <input type="text" name="user" value="" />
                <label>Password</label> <input type="password" name="pass" value="" />
                <input type="submit" name="login" value="Log In" />
            </form>
        ';

		require $this->config['views']['layout_path'] . '/layout.phtml';

    }

    public function logout() {
        // Log out, redirect
		$this->session->unauthenticate();
        header("Location: /");
    }
}
