<?php

class Controller_User {

    public $db;

    public function __construct($config) {
    	$this->config = $config;
        $dbconfig = $config['database'];
        $dsn = 'mysql:host=' . $dbconfig['host'] . ';dbname=' . $dbconfig['name'];
        $this->db = new PDO($dsn, $dbconfig['user'], $dbconfig['pass']);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function create() {
        $error = null;

        // Do the create
        if(isset($_POST['create'])) {

			$user = new Model_User($config);

            if(is_null($error)) {
                $params = array(
                    $_POST['username'],
                    $_POST['email'],
                    md5($_POST['username'] . $_POST['password']),
                );
            	$error = $user->createUser($_POST,$params);

                if(isnull($error){
	                header("Location: /user/login");
	                exit;
            	}
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
        if(!isset($_SESSION['AUTHENTICATED'])) {
            header("Location: /user/login");
            exit;
        }

        if(isset($_POST['updatepw'])) {
            if(!isset($_POST['password']) || !isset($_POST['password_check']) ||
               $_POST['password'] != $_POST['password_check']) {
                $error = 'The password fields were blank or they did not match. Please try again.';
            }
            else {
                $sql = 'UPDATE user SET password = ? WHERE username = ?';
                $stmt = $this->db->prepare($sql);
                $stmt->execute(array(
                   md5($_SESSION['username'] . $_POST['password']), // THIS IS NOT SECURE.
                   $_SESSION['username'],
                ));
                $error = 'Your password was changed.';
            }
        }

        $dsql = 'SELECT * FROM user WHERE username = ?';
        $stmt = $this->db->prepare($dsql);
        $stmt->execute(array($_SESSION['username']));
        $details = $stmt->fetch(PDO::FETCH_ASSOC);

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
            $password = md5($username . $password); // THIS IS NOT SECURE. DO NOT USE IN PRODUCTION.
            $sql = 'SELECT * FROM user WHERE username = ? AND password = ? LIMIT 1';
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array($username, $password));
            if($stmt->rowCount() > 0) {
               $data = $stmt->fetch(PDO::FETCH_ASSOC);
               session_regenerate_id();
               $_SESSION['username'] = $data['username'];
               $_SESSION['AUTHENTICATED'] = true;
               header("Location: /");
               exit;
            }
            else {
                $error = 'Your username/password did not match.';
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
        session_destroy();
        header("Location: /");
    }
}