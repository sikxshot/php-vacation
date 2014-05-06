<?php

/*

function file_name_exists($file) {		
	return (file_exists($file) ? true : false);		
}

function file_is_writeable($file) {		
	return (is_writable($file) ? true : false);
}

*/	

function redirect_to( $location = NULL ) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function file_is_readable($file) {
    return (is_readable($file) ? true : false );
}

function lstrip($string, $charlist) {
    // removes everything from start of string to last occurence of char in charlist
    $charlist = str_split($charlist);

    foreach ($charlist as $char) {
        $pos = max(strrpos($string, $char), $pos);
    }

    $string_stripped = substr($string, $pos + 1);

    return $string_stripped;

 }

?>