<?php
//header('Content-type: application/json');
require_once('../proc/config.php');

$img = $_POST['myimg'];
$xEMP_AccessID = clean($_POST['xEMP_AccessID']);

clean($_POST['xEMP_PersonnelID']) =='' ? $xEMP_ID = "EMP_".$_POST['xEMP_AccessID'] : $xEMP_ID = clean($_POST['xEMP_PersonnelID']);

$xEMP_DateHired = clean($_POST['xEMP_DateHired']);
$xEMP_LastName =clean($_POST['xEMP_LastName']);
$xEMP_MiddleName =clean($_POST['xEMP_MiddleName']);
$xEMP_FirstName =clean($_POST['xEMP_FirstName']);
$xEMP_FullName = $xEMP_FirstName." " .$xEMP_MiddleName." ".$xEMP_LastName;
$xEMP_Agency = clean($_POST['xEMP_Agency']);
$xEMP_Proj = clean($_POST['xEMP_Proj']);
$xEMP_Position = clean($_POST['xEMP_Position']);
$xEMP_Contact = clean($_POST['xEMP_Contact']);
$xEMP_Access = clean($_POST['xEMP_Access']);
$xEMP_Remarks = clean($_POST['xEMP_Remarks']);
$xEMP_TimeIn = clean($_POST['xEMP_TimeIn']);
$xEMP_TimeOut =clean($_POST['xEMP_TimeOut']);
$xEMP_Sched = clean($_POST['xEMP_Sched']);
$xEMP_Img = clean($_POST['xEMP_Img']);


$QueAddNewEmployee = "INSERT INTO `tbl_personnel` (`EmployeeID`,`AccessID`,`FullName`,`LastName`,`FirstName`,`MiddleName`,`DateHired`,`AgencyCompany`,`ProjectAssigned`,`Position`,`ContactNo`,`AccessArea`,`Image`,`Remarks`,`TimeIN`,`TimeOut`,`schedule_dates`) VALUES
('".$xEMP_ID."','".$xEMP_AccessID."','".$xEMP_FullName."','".$xEMP_LastName."','".$xEMP_FirstName."','".$xEMP_MiddleName."','".$xEMP_DateHired."','".$xEMP_Agency."','".$xEMP_Proj."','".$xEMP_Position."','".$xEMP_Contact."','".$xEMP_Access."',
'".$img."','".$xEMP_Remarks."','".$xEMP_TimeIn."','".$xEMP_TimeOut."','".$xEMP_Sched."')";
$ResAddNewEmployee = mysql_query($QueAddNewEmployee) or die (mysql_error());
//####################################################
//Uploading to server.
if($img!=''){
			if($img=='images/user/default-user.png'){
			  $success = copy('images/user/default-user.png',"images/imgBank/".$_POST['myimg']);
			} else {
			define('UPLOAD_DIR','../images/imgBank/');

			$img = str_replace('data:image/png;base64,','',$xEMP_Img);
			$img = str_replace('data:image/jpeg;base64,','',$img);
			$img = str_replace(' ','+',$img);
			$data = base64_decode($img);
			$file = UPLOAD_DIR.$_POST['myimg'];
			file_put_contents($file,$data);
			}
		}
if($success){
	header('Content-type: application/json');
    $response['result']="Accept";
	$response['url'] = "pg_employees.php";
	$response['msg'] = "Successful registration!";
	session_start();
	$_SESSION['success-message']="Successful registration!";
} else {
	Error2:
	header('Content-type: application/json');
	$response['url'] = "error.php";
	$response['result']="Error";
	$response['msg'] = "Cannot Procced! Please select an image first by clicking the picture.";
}

$sql = "DELETE FROM tbl_personnel WHERE AccessID = ''";
$res = mysql_query($sql) or die(mysql_error());
if($res){}
echo json_encode($response);
unset($response);
die();
Error1:
	header('Content-type: application/json');
	$response['url'] = "error.php";
	$response['result']="Error";
	$response['msg'] = "Please complete all the details!";
	echo json_encode($response);
	unset($response);
?>
