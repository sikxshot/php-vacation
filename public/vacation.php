<?php  
  // initialize project
	require_once( "/usr/local/share/php-vacation/config/init.php");
  // check that the user is logged in
	if (!$session->is_logged_in()) { redirect_to(BASE_URL.DS."index.php"); }

  // set initial file permissions
  exec('sudo /usr/local/share/php-vacation/bin/php-vacation.sh ' . $_SESSION['user_env'][5] . ' ' . $_SESSION['username'], $retval);

  // create the mewssages.xml file in the user's home directory 
  // via php rather than the shell script bin/php-vacation.sh
  if (is_writable($_SESSION['xmlfile'])) {
    $ermsg = 'The file ' .$_SESSION['xmlfile'].' exists and is writable';
  } else {
    if(!copy(SITE_ROOT.DS.'data'.DS.'default.xml', $_SESSION['xmlfile'])) {
      $ermsg = "failed to copy $file...\n";
    }
      // set permissions
      chmod($_SESSION['xmlfile'], 0660);
  }

  // instantiate xml object 
  $defaultXML = new XML_Parser;

  // Is vacation enabled 
  $isVacationEnabled = $defaultXML->get_attribute_value('//vacation/@enabled') ;

  // get the currently selected message (simple_xpath returns an array of nodes )
  $selectedMsg = $defaultXML->simple_xpath("//message[@selected='1']");

  // get the subject
  $selectedMsgSubject = $defaultXML->simple_xpath("//message[@name='".$selectedMsg[0]['name']."']/subject");
  // get the message text
  $selectedMsgText = $defaultXML->simple_xpath("//message[@name='".$selectedMsg[0]['name']."']/body");

  
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $title ?></title>
<script src="js/jquery.js"></script>

<!-- all the client logic sits here -->
<script src="js/vacation.js"></script>

<link href="css/site.css" media="all" type="text/css" rel="stylesheet">
</head>

<body>
<div id="container" class="effect">
  <div id="heading">
    <div id="left"><img src="images/logo-small.png" alt="Logo" height="40"></div>
    <span class='head'><?php echo $title ?></span>
    <div id="right">
      <p>You are logged in as : <?php echo $_SESSION['username'] . " | " ;?> <a href="logout.php">Logout&nbsp;</a></p>
    </div>
    <!-- <div id="middle">Newwave: Vacation Admin</div> -->
  </div>
  <div id="content">
    <div id="oooffice">

      <form id="msg_form">
      <table width="500" border="0" cellpadding="2" cellspacing="2" class="tblVacation" id="tblVacation">
        <tr>
          <th colspan="4" class="vac">Vacation Subject</th>
        </tr>
        <tr><?php
          echo "<td colspan='2'><input name='txtSubject' type='text' id='txtSubject' value='".$selectedMsgSubject[0]."' size='50' maxlength='80' class='in'>";
          ?></td>
        </tr>
        <tr colspan="2">
          <th class="vac">Vacation Message</th>
        </tr>
        <tr>
          <td colspan="3">
            <textarea name="txtAreaMessage" rows="5" id="txtAreaMessage"><?php echo $selectedMsgText[0] ?></textarea>
          </td>
        </tr>
        <tr>
          <td width="30%"><input type="submit" name="submit" id="button" value="Save Message" class="myButton"></td>
          <td width="40%" align="left"><span class='on_off'>Vacation is enabled&nbsp;&nbsp;</span></td>
          <td width="30%">
          <div class="onoffswitch" >
            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="enable" >
            <label class="onoffswitch-label" for="enable">
            <div class="onoffswitch-inner"></div>
            <div class="onoffswitch-switch"></div>
            </label>
          </div>
          </td>
        </tr>
      </table>
      </form>
    </div>
  </div>
  <div id="footer">
    <textarea cols="80" rows="6" readonly class="r_message"><?php 
    
    foreach ($retval as $key => $value) {
      echo $value . "\n";
    }
    ?>
		</textarea>
  </div>
</div>
</body>
</html>
