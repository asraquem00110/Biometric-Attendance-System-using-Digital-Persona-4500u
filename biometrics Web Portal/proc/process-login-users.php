<?php
//import database & sanitize function
require_once('config.php');
	

//Sanitize the POST values
$username = clean($_POST['username']);
//$password = md5(clean($_POST['password']));
// $password = md5(clean($_POST['password']));
$password = clean($_POST['password']);

//Create query
$qry = "SELECT * FROM tb_user WHERE user_name='$username' AND pass_word='$password'";
$result = mysql_query($qry);

if(mysql_num_rows($result) > 0) {

	$row = mysql_fetch_assoc($result);
	//CREATE SESSION AND START SESSION
	session_start();
	$_SESSION['SESS_USER_FULL_NAME'] = $row['full_name'];
	$_SESSION['SESS_USER_ID'] = $row['IDno'];
	$_SESSION['SESS_USER_NAME'] = $row['user_name'];
	$_SESSION['ACCESSLEVEL'] = $row['userlevel'];
	$_SESSION['LAST_ACTIVITY'] = time();//START SESSION

	session_write_close();

	echo 1;
	
}else{
	echo 0;
}



?>

