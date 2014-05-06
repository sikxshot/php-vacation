<?php  
  // initialize project
	require_once( "/usr/local/share/vacation/config/init.php");
  // check that the user is logged in
	if (!$session->is_logged_in()) { redirect_to(BASE_URL.DS."index.php"); }
?>