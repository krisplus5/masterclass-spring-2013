<$php

class Model_Session{

	public function __construct($config){
		session_start();
	}

	public function getValue($name){
		return $_SESSION[$name];
	}

	public function setValue($name,$val){
		$_SESSION[$name] = $val;
	}

	public function authenticate(){
		$_SESSION['AUTHENTICATED'] = true;
	}

	public function unauthenticate(){
		unset($_SESSION['AUTHENTICATED']);
	}

	public function isAuthenticated(){
		return $_SESSION['AUTHENTICATED'];
	}

	public function regenerate(){
		session_regenerate_id();
	}

	public function destroy(){
		unset($_SESSION);
		session_destroy();
	}

}
