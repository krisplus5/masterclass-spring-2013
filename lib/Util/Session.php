<$php

class Util_Session{

	public function __construct(){
		session_start();
	}

	public function get($name){
		return $_SESSION[$name];
	}

	public function set($name,$val){
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
