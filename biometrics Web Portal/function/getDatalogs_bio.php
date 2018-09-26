<?php

include('../proc/config.php');
$data=array();
if(isset($_GET['search'])){

	$datefrom = $_GET['datefrom'];
	$dateto = $_GET['dateto'];
	$accessno = clean($_GET['accessno']);
	$fullname = clean($_GET['fullname']);
	$company = clean($_GET['company']);
	$accessarea = clean($_GET['accessarea']);
	$accesstype = clean($_GET['accesstype']);
	$project = clean($_GET['project']);
	$inout = $_GET['inout'];
	$otherquery = "";

	$accessno == "" ? $otherquery.="" : $otherquery.=" AND a.AccessID LIKE '%".$accessno."%'";
	$fullname == "" ? $otherquery.="" : $otherquery.=" AND a.FullName LIKE '%".$fullname."%'";
	$company == "" ? $otherquery.="" : $otherquery.=" AND a.Company LIKE '%".$company."%'";
	$accesstype == "" ? $otherquery.="" : $otherquery.=" AND a.Status LIKE '%".$accesstype."%'";
	$project == "" ? $otherquery.="" : $otherquery.=" AND b.ProjectAssigned LIKE '%".$project."%'";
	$inout == "" ? $otherquery.="" : $otherquery.=" AND a.TimeFlag = '$inout'";

	if($accessarea <> "null"){
		
		$aArea = explode(",",$accessarea);

		for($x=0;$x<count($aArea);$x++){
			if($x==0){
				$otherquery.=" AND (a.AccessArea LIKE '%".$aArea[$x]."%' ";
			}else{
				$otherquery.=" OR a.AccessArea LIKE '%".$aArea[$x]."%' ";
			}
		}

		$otherquery.=")";
		
	}

	
	$sql="SELECT a.* FROM tbl_in_out a LEFT JOIN tbl_personnel b ON a.refno = b.EntryID WHERE DATE(a.TimeRecord) BETWEEN '$datefrom' AND '$dateto' ".$otherquery."";

}else{
	// $sql = "SELECT * FROM tbl_in_out ORDER BY DATE(TimeRecord) DESC";
	$sql = "SELECT * FROM tbl_in_out WHERE YEAR(TimeRecord) = YEAR(NOW()) AND MONTH(TimeRecord) = MONTH(NOW()) ORDER BY IDno DESC";

}

	$result = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($result)>0){
		while($row=mysql_fetch_assoc($result)){
			$row['Status'] == "ACCESS GRANTED" ? $status = '<span style="color:green">ACCESS GRANTED</span>' : $status = '<span style="color:maroon">ACCESS DENIED</span>';
			$data[]=array(
					'<center><span>'.$row['AccessID'].'</span></center>',
					'<center><span>'.$row['FullName'].'</span></center>',
					'<center><span>'.$row['TimeRecord'].'</span></center>',
					'<center><span>'.$row['TimeFlag'].'</span></center>',
					'<center>'.$status.'</center>',
					'<center><span>'.$row['AccessArea'].'</span></center>',
			);
		}
	}

$output = array(
	'aaData'=> $data,
);

echo json_encode($output);
?>