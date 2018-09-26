<?php

include('../proc/config.php');
$data = array();
$personnel = clean($_POST['personnel']);

$sql = "SELECT EntryID FROM tbl_personnel WHERE FullName LIKE '%$personnel%' OR AccessID LIKE '%$personnel%'";
$result = mysql_query($sql) or die(mysql_error());

if(mysql_num_rows($result)>0){
	while($row=mysql_fetch_assoc($result)){
		$data[]=$row;
	}
}

echo json_encode($data);

?>