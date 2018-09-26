<?php
	//Start session
	session_start();

	if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 7200)){
		// request 30 minutes ago

		//Unset the variables stored in session
		unset($_SESSION['SESS_USER_FULL_NAME']);
		unset($_SESSION['SESS_USER_ID']);
		unset($_SESSION['SESS_USER_TYPE']);
		unset($_SESSION['LAST_ACTIVITY']);
		header("location: session-expired.php");
		exit();
	}

	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['SESS_USER_ID']) || (trim($_SESSION['SESS_USER_ID']) == '')) {
		header("location: access-denied.php");
		exit();
	}
	
	$_SESSION['LAST_ACTIVITY'] = time();//RENEW THE TIME
	unset($_SESSION['MYSQL_QUERY']);

?>