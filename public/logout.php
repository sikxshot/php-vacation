<?php
	require_once( "/usr/local/share/php-vacation/config/init.php");
	session_destroy();
	redirect_to('index.php');
?>