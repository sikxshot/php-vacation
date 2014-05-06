<?php 
/* Local server settings here */ 


/* Dev settings below here */

# set error reporting
error_reporting(E_ALL); 

// imap server settings http://www.php.net/manual/en/function.imap-open.php
$serverParam = "localhost:143/imap/novalidate-cert";
// $serverParam = "localhost:110/pop3/novalidate-cert";
// $serverParam = "localhost:993/imap/ssl/novalidate-cert";

$mainLogo = "images".DS."logo-main.png";
$smalllogo = "images".DS."logo-small.png";
$title = "Newwave: Vacation Admin!";
?>