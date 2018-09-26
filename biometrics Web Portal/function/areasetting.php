<?php


include('../proc/config.php');

if(isset($_POST['update'])){
	$idno = $_POST['id'];
	$area = clean($_POST['area']);
	$type = clean($_POST['type']);

	$sql = "UPDATE tbl_arealist  SET AreaName = '$area',AreaType='$type' WHERE ID='$idno'";
	$res = mysql_query($sql) or die(mysql_error());
	if($res){
		echo 1;
	}
}

if(isset($_POST['remove'])){
	$idno = $_POST['id'];

	$sql = "DELETE FROM tbl_arealist WHERE ID='$idno'";
	$res = mysql_query($sql) or die(mysql_error());
	if($res){
		echo 1;
	}
}

if(isset($_POST['add'])){
	$area = clean($_POST['area']);
	$type = clean($_POST['type']);

	$sql = "INSERT INTO tbl_arealist (AreaName,AreaType) VALUES ('$area','$type')";
	$res = mysql_query($sql) or die(mysql_error());
	if($res){
		echo 1;
	}
}

?>