<?php
// A class to help work with Sessions
// In our case, primarily to manage logging users in and out

// Keep in mind when working with sessions that it is generally 
// inadvisable to store DB-related objects in sessions

class Session {
	
	public $logged_in=false;
	public $username;
	// Array ( [0] => james [1] => x [2] => 1003 [3] => 1003 [4] => James,,, [5] => /home/james [6] => /bin/bash ) 
	public $user_env = array();

	function __construct() {
		session_start();
		$this->check_login();
	    if($this->logged_in) {
	      // actions to take right away if user is logged in
	    } else {
	      // actions to take right away if user is not logged in
	    }
	}
	
  	public function is_logged_in() {
  		return $this->logged_in;
 	 }

	public function login($user) {
	    // database should find user based on username/password
		if($user) {
			$this->username = $_SESSION['username'] = $user['username'];
			$this->user_env = $_SESSION['user_env'] = $this->get_user_env();
			$_SESSION['xmlfile'] = $_SESSION['user_env'][5] . DS . ".php-vacation.d" . DS . "messages.xml";
			$this->logged_in = true;
		}
	}
  
  	public function logout() {
	    unset($_SESSION['username']);
	    unset($this->username);
	    $this->logged_in = false;
  	}

	private function check_login() {
	    if(isset($_SESSION['username'])) {
	      $this->username = $_SESSION['username'];
	      $this->logged_in = true;
	    } else {
	      unset($this->username);
	      $this->logged_in = false;
	    }
    }

    private function get_user_env() {
		$pattern = "/^".$this->username."/i" ;
		$handle = fopen("/etc/passwd", "r") ;
		if ($handle) {
		    while (($line = fgets($handle)) !== false) {
		    	if (preg_match($pattern, $line)) {
					$env = explode(":",$line);
					return $env ;
				}
		    }
		} else {
		    // error opening the file.
		}
    }

  }

$session = new Session();

?>