<?php  
	require_once( "/usr/local/share/php-vacation/config/init.php");
?>

<?php
global $user;
global $session;
global $testing;

if ($session->is_logged_in ()) {
	redirect_to ( "vacation.php" );
}

	// initalize some variables
	$message = '';

	// only process the form if the login field has data
	if (!empty($_POST["username"])) {

    // clean up post data
		$post_username = htmlspecialchars($_POST["username"]) ;
		$post_password = htmlspecialchars($_POST["password"]) ;

    // call authenticate method in Class User
		$login_result = User::authenticate($serverParam, $post_username, $post_password ) ;
    
    // if we return a valid username...
    if ($login_result['username']) {
      $session->login ( $login_result ) ;
      $session->username = ( $login_result['username'] );
      redirect_to('vacation.php');
    } else {
      // username/password combo was not found in the database
      $message = $login_result['error'] ;
    }

	}
?>


<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Vacation: Web Admin</title>
  <script type="text/javascript" src="js/ifoldie.js">
  </script>
	<link href="css/login.css" media="all" type="text/css" rel="stylesheet">
</head>

<body>
<div id="modal" class="effect">
  <div id="heading">Newwave: Cyan Mail Login!</div>
  <div id="content">
    <div id="form">
      <form name="form_login" id="form_login" method="POST" action="index.php" accept-charset="UTF-8">
        <label for="username">Login</label>
        <input type="text" name="username" id="username">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <input type="submit" value="Login" id="submit">
      </form>
    <span class="error"><?php echo $message; ?></span>
    </div> <!-- end div form -->
    
    <div id="img"><img src="<?php echo $mainLogo ?>" alt="Logo"> </div>
  </div> <!-- end div content -->
</div>
</body>
</html>

