<?php
 // initialize project
    require_once( "/usr/local/share/php-vacation/config/init.php");
    // check that the user is logged in
    if (!$session->is_logged_in()) { redirect_to(BASE_URL.DS."index.php"); }

    $xml_data = new XML_Parser;
    $xpath = "//message[@selected='1']";
    // update_element_text('//message[@active="102"]', 'subject', 'changed again 12345', 0)
    $xml_data->update_element_text($xpath,"subject", $_POST['txtSubject']);
    $xml_data->update_element_text($xpath,"body", $_POST['txtAreaMessage']);
    
?>