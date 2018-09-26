<?php

include('../proc/config.php');
session_start();

$modifyUser = $_SESSION['SESS_USER_FULL_NAME'];
$modifyTime = date("Y-m-d H:i:s",time());

$idno = $_POST['idno'];
$status = $_POST['status'];

$sql = "SELECT Logs FROM tbl_in_out WHERE IDno = '$idno'";
$res = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_assoc($res);

$logs = $row['Logs'];

if($logs==''){
	$newLogs = $modifyUser." || ".$status. " || ".$modifyTime;
}else{
	$newLogs = $logs."<br/>".$modifyUser." || ".$status. " || ".$modifyTime;
}

$sql = "UPDATE tbl_in_out SET Approved_Status = '$status', Logs = '$newLogs' WHERE IDno = '$idno'";
$res = mysql_query($sql) or die(mysql_error());
if($res){
	echo '1';
}

?>