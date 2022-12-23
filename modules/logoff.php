<?php
session_start();
// Unset all of the session variables
$_SESSION = array();
 //destroy all Session
session_destroy();
// Redirect to the login page:
$URL_STATUS = $_SERVER['HTTP_REFERER'];
header("Location: $URL_STATUS");
exit 
?>