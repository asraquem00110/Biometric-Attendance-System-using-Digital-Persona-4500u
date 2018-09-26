<?php

include('../proc/config.php');


if(isset($_POST['add'])){
	$fullname = clean($_POST['fullname']);
	$username = clean($_POST['username']);
	$level = clean($_POST['level']);
	$email = clean($_POST['email']);
	$password = clean($_POST['password']);

	$sql = "INSERT INTO tb_user (full_name,user_name,userlevel,email_add,pass_word) VALUES ('$fullname','$username','$level','$email','$password')";
	$res = mysql_query($sql) or die(mysql_error());
	if($res){
		echo 1;
	}
}

if(isset($_POST['remove'])){
	$idno = $_POST['id'];

	$sql = "DELETE FROM tb_user WHERE IDno='$idno'";
	$res = mysql_query($sql) or die(mysql_error());
	if($res){
		echo 1;
	}
}


if(isset($_POST['update'])){
	$id = $_POST['id'];
	$fullname = clean($_POST['fullname']);
	$username = clean($_POST['username']);
	$level = clean($_POST['level']);
	$email = clean($_POST['email']);
	$password = clean($_POST['password']);

	$sql = "UPDATE tb_user SET full_name ='$fullname',user_name='$username',userlevel='$level',email_add='$email',pass_word='$password' WHERE IDno='$id'";
	$res = mysql_query($sql) or die(mysql_error());
	if($res){
		echo 1;
	}
}


?>