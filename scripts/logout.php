<?php 
	session_start();
	unset($_SESSION["userID"]);
	$_SESSION = array();
	session_destroy();
	header("Location: ../login.php"); /* Redirect browser */
	exit();
?>