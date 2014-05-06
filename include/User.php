<?php
class User {

	public $username;
	public $password;

	public static function authenticate($serverParam, $username, $password) {
		// login to IMAP server
		// $mbox = imap_open("{".$serverParam."}INBOX", $username, $password, OP_HALFOPEN,1) ;
		$mbox = imap_open("{".$serverParam."}INBOX", $username, $password) ;
		
		// test whether user logged in correctly
	  	if(empty($mbox)) {
	  		// fail gracefully IMAP error codes (https://tools.ietf.org/html/rfc5530)
			$result['username'] = false ;
			$result['error'] = imap_last_error() ;
		} else {
			// set variable if sucessful
			$result['username'] = $username ;
			$result['error'] = imap_last_error() ;
		}

		imap_close($mbox) ;
		return $result ;
	}
}

?>