<?php
date_default_timezone_set('Asia/Taipei');
include('../proc/config.php');


function checkifApproved($idno){

	$sql = "SELECT Approved_Status,Logs FROM tbl_in_out WHERE IDno = '$idno'";
	$res = mysql_query($sql) or die(mysql_error());
	$row=mysql_fetch_assoc($res);

	return $row;
}


$personnelID = $_POST['personnel'];
$datefrom = $_POST['datefrom'];
$dateto = $_POST['dateto'];

$eachdays = getDateRange($datefrom,$dateto);
$display = "";
$personneldetails="";
$data = array();
// Get Personnel Information

$sql="SELECT * FROM tbl_personnel WHERE EntryID ='$personnelID'";
$result = mysql_query($sql) or die(mysql_error());
if(mysql_num_rows($result)>0){
	while($row=mysql_fetch_assoc($result)){

        $personneldetails.=' <tr>
            <td><strong>FULLNAME:</strong></td><td><strong>'.$row['FullName'].'</strong></td>
             <td><strong>DATE HIRED:</strong></td><td><strong>'.$row['DateHired'].'</strong></td>
             <td><strong>ACCESS ID:</strong></td><td><strong>'.$row['AccessID'].'</strong></td>
        </tr>   
         <tr>
            <td><strong>COMPANY:</strong></td><td><strong>'.$row['AgencyCompany'].'</strong></td>
            <td><strong>POSITION:</strong></td><td><strong>'.$row['Position'].'</strong></td>
            <td><strong>CONTACT NO:</strong></td><td><strong>'.$row['ContactNo'].'</strong></td>
        </tr>
         <tr>
            <td><strong>PROJECT ASSIGNED:</strong></td><td><strong>'.$row['ProjectAssigned'].'</strong></td>
            <td><strong>ACCESS AREA:</strong></td><td><strong>'.$row['AccessArea'].'</strong></td>
            <td><strong>TIME SCHEDULE:</strong></td><td><strong>'.$row['TimeIN'].' - '.$row['TimeOut'].'</strong></td>
        </tr>';

        $OfficialTimeIn = $row['TimeIN'];
        $OfficialTimeOut = $row['TimeOut'];
	}
}


$sql = "SELECT DISTINCT(DATE(TimeRecord)) as DateRecord,(SELECT Time(TimeRecord) FROM tbl_in_out WHERE refno = '$personnelID' AND DATE(TimeRecord) = DateRecord AND TimeFlag = 'IN' ORDER BY IDno ASC LIMIT 1) as FIRST_IN,(SELECT Time(TimeRecord) FROM tbl_in_out WHERE refno = '$personnelID' AND DATE(TimeRecord) = DateRecord AND TimeFlag = 'OUT' ORDER BY IDno DESC LIMIT 1) as LAST_OUT,(SELECT IDno FROM tbl_in_out WHERE refno = '$personnelID' AND DATE(TimeRecord) = DateRecord AND TimeFlag = 'IN' AND Time(TimeRecord) = FIRST_IN ORDER BY IDno ASC LIMIT 1) as FIRST_IN_IDNO,(SELECT IDno FROM tbl_in_out WHERE refno = '$personnelID' AND DATE(TimeRecord) = DateRecord AND TimeFlag = 'OUT' AND Time(TimeRecord) = LAST_OUT ORDER BY IDno ASC LIMIT 1) as LAST_OUT_IDNO FROM tbl_in_out WHERE DATE(TimeRecord) BETWEEN '$datefrom' AND '$dateto'";
$res = mysql_query($sql) or die(mysql_error());
if(mysql_num_rows($res)>0){
	while($row=mysql_fetch_assoc($res)){
		$data[]=$row;
	}
}
$detailsDisplay = '';
foreach($eachdays as $day){
		$datedis = strtotime($day);
	if(count($data) == 0){
		$detailsDisplay.='';
	}else{
	foreach($data as $bio){
		$detailsDisplay = '';
		$OT = '';
		$Status = '';
		if($bio['DateRecord']==$day){
			if($bio['FIRST_IN'] == null AND $bio['LAST_OUT']==null){
				$FI = '';
				$LO = '';
					$detailsDisplay.='<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>';
					break;
			}elseif($bio['FIRST_IN'] == null AND $bio['LAST_OUT'] != null){
				$FI = $OfficialTimeIn;
				$LO = $bio['LAST_OUT'];
			}elseif($bio['FIRST_IN'] != null AND $bio['LAST_OUT'] == null){
				$FI = $bio['FIRST_IN'];
				$LO = $OfficialTimeOut;
			}else{
				$FI = $bio['FIRST_IN'];
				$LO = $bio['LAST_OUT'];
			}

			$datebio = $bio["DateRecord"];
			$datebio = date_create($datebio);
			$datenow = date('Y-m-d',time());
			$datenow = date_create($datenow);

			$interval = date_diff($datenow,$datebio);
			$days = $interval->format('%a');

			$lateTime = "";

			$valFI = date_create($FI);
			$valOTI = date_create($OfficialTimeIn);

			if($valFI > $valOTI){
				$interval = date_diff($valOTI,$valFI);
				$lateTime = $interval->format('%H:%i:%s');
			}


			$excessTime = "";

			$valLO = date_create($LO);
			$valOTO = date_create($OfficialTimeOut);
		
			if($valLO > $valOTO){
			$interval = date_diff($valOTO,$valLO);
			$excessTime = $interval->format('%H:%i:%s');
			}

			if($excessTime <> ''){
				// If theres excess time change the time out to official time out
				$LO = $OfficialTimeOut;
				$checkifApproved = checkifApproved($bio['LAST_OUT_IDNO']);

				if($checkifApproved['Approved_Status'] != ''){
					if($checkifApproved['Approved_Status']=='YES'){
					$OT = $excessTime;
					$Status = "<a href='#' data-idno='".$bio['LAST_OUT_IDNO']."' class='approvedButton'><span style='color:green;''>YES</span></a>";
					}elseif($checkifApproved['Approved_Status']=='NO'){
						$Status = "<a href='#' data-idno='".$bio['LAST_OUT_IDNO']."' class='approvedButton'><span style='color:maroon;''>NO</span></a>";
					}


				$approvedDisButton = '<button type="button" data-idno="'.$bio['LAST_OUT_IDNO'].'" class="approvedButton btn btn-primary btn-xs"><span class="glyphicon glyphicon-check"></span> Approved OT?</button>'; 

				}else{
						if($days >= 7){
							$OT = $excessTime;
							$Status = "<a href='#' data-idno='".$bio['LAST_OUT_IDNO']."' class='approvedButton'><span style='color:red;''>EXPIRED</span></a>";
							$approvedDisButton = '';
						}else{
							$Status = "<a href='#' data-idno='".$bio['LAST_OUT_IDNO']."' class='approvedButton'><span style='color:blue;''>APPROVED OT?</span></a>";

							$approvedDisButton = '<button type="button" data-idno="'.$bio['LAST_OUT_IDNO'].'" class="approvedButton btn btn-primary btn-xs"><span class="glyphicon glyphicon-check"></span> Approved OT?</button>'; 
						}
				}

			}else{
				$approvedDisButton = '';
			}

			
			$detailsDisplay.='<td align="center">'.$FI.'</td>
			<td align="center">'.$LO.'</td>
			<td align="center">'.$OT.'</td>
			<td align="center">'.$lateTime.'</td>
			<td align="center">'.$excessTime.'</td>
			<td align="center">'.$Status.'</td>';
			break;
		}else{
			$detailsDisplay.='<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>';
		}

	}
	}
	
	$display.= '<tr><td align="center">'.$day.'</td><td align="center">'.date('D',$datedis).'</td>'.$detailsDisplay.'</tr>';
}

$data = array(
	$display,
	$personneldetails,
);

echo json_encode($data);
?>