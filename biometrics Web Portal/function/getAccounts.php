<?php

include('../proc/config.php');
$data = array();

$sql = "SELECT * FROM tbl_personnel";
$res = mysql_query($sql) or die(mysql_error());

if(mysql_num_rows($res)>0){
	while($row=mysql_fetch_assoc($res)){
		$data[] = array(
			'<a href="pg_EditEmployee2.php?xRef='.$row['EntryID'].'">'.$row['AccessID'].'</a>',
			$row['EmployeeID'],
			$row['FullName'],
			$row['DateHired'],
			$row['Position'],
			$row['AgencyCompany'],
		);
	}
}

$output = array(
	'aaData'=> $data,
);

echo json_encode($output);