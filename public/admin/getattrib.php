<?php
  // initialize project
    require_once( "/usr/local/share/php-vacation/config/init.php");
    // check that the user is logged in
    if (!$session->is_logged_in()) { redirect_to(BASE_URL.DS."index.php"); }

    $sxe = new XML_Parser;

    // Is there an active forward message
    $query = $sxe->get_attribute_value($_POST['value']) ;
    echo($query);
?>