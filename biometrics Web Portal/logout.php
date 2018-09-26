<?php
	//Start session
	session_start();

	//Unset the variables stored in session
	unset($_SESSION['SESS_USER_FULL_NAME']);
	unset($_SESSION['SESS_USER_ID']);
	unset($_SESSION['SESS_USER_NAME']);
	unset($_SESSION['LAST_ACTIVITY']);
	
	//redirect to login
	header("location: index.php");
	exit();
?>