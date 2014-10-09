<?php
  // initialize project
    require_once( "/usr/local/share/php-vacation/config/init.php");
    // check that the user is logged in
    if (!$session->is_logged_in()) { redirect_to(BASE_URL.DS."index.php"); }

    function writeDotMessage($file, $str, $mode) {

        if (!$handle = fopen($file, $mode)) {
             echo "Cannot open file ($file)";
             return;
        }

        if (fwrite($handle, $str) === FALSE) {
            echo "Cannot write to file ($file)";
            return;
        }

        echo "true";

        fclose($handle);

    }


    $xml_data = new XML_Parser;

    $xpath = "//vacation";
    $idx = 0  ;
    $attribute = "enabled" ;
    $xml_data->change_attribute_value( $xpath, $idx, $attribute, $_POST['value'] );

    // set the file name "/home/username/.vacation.msg"
    $messageFileName = $_SESSION['user_env'][5].DS.'.vacation.msg';
    // set the file name "/home/username/.forward"
    $forwardFileName = $_SESSION['user_env'][5].DS.'.forward';

    // if we are enabling vacation
    if ($_POST['value'] == 1)  {
        // get the currently selected message (simple_xpath returns an array of nodes )
        $selectedMsg = $xml_data->simple_xpath("//message[@selected='1']");
        // get message header 1
        $selectedMsgDelivered = $xml_data->simple_xpath("//message[@name='".$selectedMsg[0]['name']."']/delivered");
        // get message header 2
        $selectedMsgPrecedence = $xml_data->simple_xpath("//message[@name='".$selectedMsg[0]['name']."']/precedence");
        // get the subject
        $selectedMsgSubject = $xml_data->simple_xpath("//message[@name='".$selectedMsg[0]['name']."']/subject");
        // get the message text
        $selectedMsgText = $xml_data->simple_xpath("//message[@name='".$selectedMsg[0]['name']."']/body"); 
        
        $deliv = $selectedMsgDelivered[0]."\n";
        $prec = $selectedMsgPrecedence[0]."\n";
        $sbj = $selectedMsgSubject[0]."\n\n";
        $body = $selectedMsgText[0];

        $forwardTxt = "\\".$_SESSION["username"].', "|/usr/bin/vacation ' . $_SESSION["username"].'"';

        // $initPath = 'sudo -u ' . $_SESSION["username"] . ' /usr/local/share/php-vacation/bin/php-vacation-init.sh';

        if (is_writable($messageFileName)) { 
            // write the .vacation.msg
            writeDotMessage($messageFileName,$deliv, 'w' );
            writeDotMessage($messageFileName,$prec, 'a' );
            writeDotMessage($messageFileName,$sbj, 'a' );
            writeDotMessage($messageFileName,$body, 'a' );
            // Initialize the vacation database files.  It should be used before you modify your .forward file
            system('sudo -u ' . $_SESSION["username"] . ' /usr/bin/vacation -i -r 1', $retval);
            // write the .forward file
            writeDotMessage($forwardFileName,$forwardTxt . "\n", 'w' );
        }
    } else {
        system('sudo -u ' . $_SESSION["username"] . ' /usr/bin/vacation -i -r 1', $retval);
        writeDotMessage($forwardFileName,"", 'w' );
    }
    // echo $initPath;

    // print_r($messageArray);
    
    // echo $messageFile;

?>