<?php
	// set error reporting
	error_reporting(E_ALL); 

	// Define the core paths
	// Define them as absolute paths to make sure that require_once works as expected

	// DIRECTORY_SEPARATOR is a PHP pre-defined constant
	// (\ for Windows, / for Unix)
	defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR) ;

	defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'usr'.DS.'local'.DS.'share'.DS.'php-vacation') ;

	defined('INCLUDE_PATH') ? null : define('INCLUDE_PATH', SITE_ROOT.DS.'include') ;

	defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'lib') ;

	defined('DATA_PATH') ? null : define('DATA_PATH', SITE_ROOT.DS.'data') ;

	defined('BASE_URL') ? null : define('BASE_URL', DS.'php-vacation') ;

	// Local server IMAP settings are here
	require_once (SITE_ROOT.DS.'config/conf.php') ;

	// load basic functions next so that we can use them later
	require_once(LIB_PATH.DS.'functions.php');

	// load core objects
	require_once(INCLUDE_PATH.DS.'Session.php');
	require_once(INCLUDE_PATH.DS.'User.php');

	// load custom library
	require_once(LIB_PATH.DS.'xml_parser.php');
	
	
	

?>

