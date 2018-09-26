<?php
include('auth.php');
require_once('include/include-head.php');
require_once('include/include-main.php');
require_once('proc/config.php');

if(isset($_POST['btnSubmit'])){

	if($_POST['btnSubmit']=='Update'){

    if(isset($_POST['txtSchedule'])){
      $scheduledays = implode(",",$_POST['txtSchedule']);
    }else{
      $scheduledays = "";
    }

		$img = $_POST['myimg'];;
	  $ProfilePic='';

		if ($_POST['imgload'] == ''){
			$QueGetCurrentPic = stripslashes("SELECT `Image` FROM `tbl_personnel` WHERE `EntryID` = '".$_POST['ID']."'");

			$ResGetCurrentPic = mysql_query($QueGetCurrentPic) or die(mysql_error());
			while($RowGetCurrentPic = mysql_fetch_array($ResGetCurrentPic)){
     
				 $ProfilePic = $RowGetCurrentPic['Image'];
			}

		}else{
      
			$ProfilePic = $_POST['imgload'];
      $ProfilePic = $_POST['txtKey'].'_imageUser.png'; 
		}

    if($img == ""){
      $ProfilePic = $_POST['txtKey'].'_imageUser.png'; 
    }

		$QueUpdateEmp = stripslashes("UPDATE `tbl_personnel` SET `EmployeeID` = '".$_POST['txtPersonnelID']."', `AccessID` = '".$_POST['txtAccessID']."
      ', `FullName` = '".$_POST['txtFullName']."',`DateHired` = '".$_POST['txtDateHired']."',`Position` = '".$_POST['txtPosition']."',`AgencyCompany` = '".$_POST['txtAgency']."'
		,`ProjectAssigned` = '".$_POST['txtProject']."',`ContactNo` = '".$_POST['txtContact']."',`AccessArea` = '".$_POST['accessArea']."'
		,`Remarks` = '".$_POST['txtRemarks']."',`schedule_dates` = '".$scheduledays."',`TimeIN` = '".$_POST['txtTimeIn']."',`TimeOut` = '".$_POST['txtTimeOut']."',`Image` = '".$ProfilePic."'
			WHERE `EntryID` = '".$_POST['txtKey']."'");

		$ResUpdateEmp = mysql_query($QueUpdateEmp) or die(mysql_error());
		
		if($img!=''){

			define('UPLOAD_DIR','images/imgBank/');
			$txtID =$_POST['txtData'][0];

			$img = str_replace('data:image/png;base64,','',$img);
			$img = str_replace('data:image/jpeg;base64,','',$img);
			$img = str_replace(' ','+',$img);
			$data = base64_decode($img);
			$file = UPLOAD_DIR.$ProfilePic;
			$success = file_put_contents($file,$data);
		}
		$_SESSION['success-message']='Updating Personnel Information Successful!';
	}
} else if( (isset($_POST['btnDelete'])) && ($_POST['btnDelete']=='Delete')){
   $ID = $_POST['ID'];

	if (isset($_POST['txtResignationDate'])){
		Global_MySQL('',"UPDATE `tbl_personnel` SET `Status`='Resigned',`Remarks`='".$_POST['txtResignationDate']."' WHERE `EntryID`='".$ID."'",false);
	}elseif(isset($_POST['txtReasons_invest'])){
		Global_MySQL('',"UPDATE `tbl_personnel` SET `Status`='For Security Investigation',`Remarks`='".$_POST['txtReasons_invest']."' WHERE `EntryID`='".$ID."'",false);
	}elseif(isset($_POST['txtReasons_terminated'])){
		Global_MySQL('',"UPDATE `tbl_personnel` SET `Status`='Terminated',`Remarks`='".$_POST['txtReasons_terminated']."' WHERE `EntryID`='".$ID."'",false);
	}

	$_SESSION['success-message']='Deactivating Personnel Successful!';

} else if(isset($_POST['btnDelete']) && $_POST['btnDelete']=='Activate'){
    $ID = $_POST['ID'];
	if (isset($_POST['txtResignationDate'])){
		Global_MySQL('',"UPDATE `tbl_personnel` SET `Status`='',`Remarks`='".$_POST['txtResignationDate']."' WHERE `EntryID`='".$ID."'",false);
	}elseif(isset($_POST['txtReasons_invest'])){
		Global_MySQL('',"UPDATE `tbl_personnel` SET `Status`='',`Remarks`='".$_POST['txtReasons_invest']."' WHERE `EntryID`='".$ID."'",false);
	}elseif(isset($_POST['txtReasons_terminated'])){
		Global_MySQL('',"UPDATE `tbl_personnel` SET `Status`='',`Remarks`='".$_POST['txtReasons_terminated']."' WHERE `EntryID`='".$ID."'",false);
	}
	$_SESSION['success-message']='Activating Personnel Successful!';
}
Disp:

if(isset($_POST['ID'])){
   $ID = $_POST['ID'];
}else{
   $ID = $_GET['xRef'];
}
 

  $res = Global_MySQL('',"SELECT * FROM `tbl_personnel` WHERE `EntryID`='".$ID."'",false);
  $ResCnt=mysql_num_rows($res);
  if($ResCnt!=0){
  while($row = mysql_fetch_assoc($res)){$MyData = $row;}

  } else { $_SESSION['error-message']='Account not existing or not found.'; header('location: '.$_SESSION['RETURN']);}

?>


<form id="frmRegister" action="" method="post">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <div class="panel-title"><span style="font-size:large;font-weight:bold">EDIT INFORMATION</span></div>
    </div>
    <div class="panel-body">
     <?php include_once('message.php'); ?>
      <div class="table-responsive">

      <div class="row">
            <div class="col-lg-3 col-lg-offset-1">
              Image
              <center>

								<input type="hidden" name="txtKey" value="<?php echo $MyData['EntryID']; ?>"/>
			  <img src="images/imgBank/<?php echo $MyData['Image']; ?>" alt="" name="picImg" width = "240" height = "240" border="5" class="img-responsive img-thumbnail" id="picImg" style="cursor:pointer;" onClick="OpenFileDiag()"/>
              <input <?php if($MyData['Status']=='Resigned'){echo 'disabled';} ?> type="file" style="display:none;" title="Open Image" id = "imgload" onchange = "readURL(this)" name = "imgload" accept="image/png, image/jpeg"/>
              <input type="hidden" name="myimg" id="myimg"/>
              </center>
            </div>
          	<div class="col-lg-3 col-lg-offset-1">
              Preview
              <center>
              <div style="display:none;" id="my_camera"></div>
              </center>
            </div>
          	<div class="col-lg-1 col-lg-offset-1">
            <input <?php if($MyData['Status']=='Resigned'){echo 'disabled';} ?> type="checkbox" checked data-width="100" data-toggle="toggle"
            data-on="<i class='fa fa-file'>&nbsp;</i>File" data-off="<i class='fa fa-camera'>&nbsp;</i>Camera"
            onChange="ToggleCamera(this);" /><br><br>
            <button type="button" <?php if($MyData['Status']=='Resigned'){echo 'disabled';} ?> id="btnCam" class="btn btn-success" onClick="OpenFileDiag();">Capture Image</button><br><br>
						<?php

						
						?>
	        <input type="hidden" name="ID" value="<?php echo $ID; ?>"/>
            </div>
	        </div>

        <br />
          <table class="table table-condensed" id = "tblUpdEmp">

          <tr>
           <th>PERSONNEL ID</th>
            <td colspan="3" ><input required type="text" <?php if($MyData['Status']=='Resigned'){echo 'disabled';} ?> id="txtPersonnelID" name="txtPersonnelID" class="form-control" value="<?php echo $MyData['EmployeeID']; ?>" /></td>

            <th>ACCESS ID</th>
            <td colspan="3" ><input required type="text" <?php if($MyData['Status']=='Resigned'){echo 'disabled';} ?> name="txtAccessID" class="form-control" value="<?php echo $MyData['AccessID']; ?>" /></td>
            <!--<th>PASSWORD</th>
            <td><input type="password" <?php //if($MyData['Status']=='Resigned'){echo 'disabled';} ?> class="form-control" onChange="$('#txtPassword').val(this.value);" value="<?php// echo $MyData['Password']; ?>" /></td>-->
         
          </tr>
         <tr>

            <!--<input required <?php if($MyData['Status']=='Resigned'){echo 'disabled';} ?> name="txtData[]" type="text" class="form-control hidden" value="<?php echo $FullName; ?>"/>	           -->
          </tr>
          <tr>
          	<th>FULL NAME</th>
            <td><input required <?php if($MyData['Status']=='Resigned'){echo 'disabled';} ?> name="txtFullName" type="text" class="form-control" value="<?php echo $MyData['FullName']; ?>"/></td>
          </tr>
          <tr>


            <th>DATE HIRED</th>
            <td colspan="3"><input name="txtDateHired" <?php if($MyData['Status']=='Resigned'){echo 'disabled';} ?> type="date" class="form-control" value="<?php echo $MyData['DateHired']; ?>"/></td>

             <th>POSITION</th>
            <td colspan="3"><input required <?php if($MyData['Status']=='Resigned'){echo 'disabled';} ?> name="txtPosition" type="text" class="form-control" value="<?php echo $MyData['Position']; ?>"/></td>
          </tr>

          <tr>
          <th>AGENCY / COMPANY</th>
            <td colspan="3"><input required <?php if($MyData['Status']=='Resigned'){echo 'disabled';} ?> name="txtAgency" class="form-control" value="<?php echo $MyData['AgencyCompany']; ?>"/></td>

			<th>PROJECT ASSIGNED</th>
            <td colspan="3"><input required <?php if($MyData['Status']=='Resigned'){echo 'disabled';} ?> name="txtProject" type="text" class="form-control" value="<?php echo $MyData['ProjectAssigned']; ?>"/></td>

          </tr>
          <tr>
            <th>CONTACT NO.</th>
            <td colspan="3"><input type="text" <?php if($MyData['Status']=='Resigned'){echo 'disabled';} ?> name="txtContact" class="form-control" value="<?php echo $MyData['ContactNo']; ?>"/></td>

             <input type="hidden" name="accessArea" id="accessArea">
       	   <th>ACCESS AREA</th><td width="30%"> <select id = "cmbAccessArea" name = "txtAccessArea" multiple class="form-control chosen chosen-select chosen-deselect" data-placeholder = "Select Access Area" required>
              <option></option>
          <?php
                $arealist = array();
              $sql = "SELECT AreaName FROM tbl_arealist ORDER BY AreaName";
              $result = mysql_query($sql) or die(mysql_error());
              if(mysql_num_rows($result)){
                while($row=mysql_fetch_assoc($result)){
                  $arealist[]=$row['AreaName'];
                }
              }         
                           

                            foreach($arealist as $area)
                            {
                                echo in_array($area, explode(",",$MyData['AccessArea'])) ? '<option selected>'.$area.'</option>' : '<option>'.$area.'</option>';
                            }
                    ?>
                </select></td>
            <input type="hidden" id="txtAccessArea" name="txtAccessArea" value="<?php echo $xAccessRoom; ?>" /> <!--ACCESS AREA DATA-->
            <!--ACCESS AREA DATA-->
          </tr>
          <tr>
            <input type="hidden" id="picImg1" name="txtData[]" value="<?php echo $MyData['Image']; ?>" />
            <!--<th>STATUS</th>-->
            <!--<td><input type="text" name="txtData[]" class="form-control" value="<?php echo $MyData['Status']; ?>"/></td>-->
            <th>REMARKS</th>
            <td colspan="6"><textarea name="txtRemarks" <?php if($MyData['Status']=='Resigned'){echo 'disabled';} ?> cols="20" rows="2" class="form-control"><?php echo $MyData['Remarks']; ?></textarea></td>
          </tr>
            <tr>
                <th colspan = "6" style = "text-align:center;">REGULAR SCHEDULE</th>
            </tr>
            <tr>
                <th>TIME IN</th>
                <td colspan="3"><input type = "time" class = "form-control" name = "txtTimeIn" value = "<?php echo $MyData['TimeIN']; ?>"/></td>
                <th>TIME OUT</th>
                <td colspan="3"><input type = "time" class = "form-control" name = "txtTimeOut" value = "<?php echo $MyData['TimeOut']; ?>"/></td>
            </tr>
            <tr>
                <th>SCHEDULE DAYS</th>
                <td colspan = "6">
                    <input type="hidden" name="txtData[]" id="txtPassword"  value="<?php echo $MyData['Password']; ?>" />

                    <select id = "cmbSchedule" name = "txtSchedule[]" multiple class="form-control chosen chosen-select chosen-deselect" data-placeholder = "Select Days">
                        <?php
                            $schedules = array(
                                'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
                            );

                            foreach($schedules as $days)
                            {
                                echo in_array($days, explode(",",$MyData['schedule_dates'])) ? '<option selected>'.$days.'</option>' : '<option>'.$days.'</option>';
                            }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
      </div>
    </div>
    <div class="modal-footer">
      <button type="submit" <?php if($MyData['Status']=='Resigned'){echo 'disabled';} ?> class="btn btn-md btn-primary" name="btnSubmit" title="Update Status" value="Update">Update</button>
	  <button type="button" data-toggle="modal" data-target="#remove-modal" style="text-decoration:none" title="<?php if($MyData['Status']=='Resigned'){echo 'Activate';} else { echo 'Deactivate'; } ?> this Employee" class="btn btn-md btn-danger pull-left">
	  <?php if($MyData['Status']=='Resigned'){echo 'Activate';} else { echo 'Deactivate'; } ?></button>
      <a style="text-decoration:none" onclick="window.location = '<?php echo $_SESSION['RETURN']; ?>';" class="btn btn-md btn-danger">Cancel</a>
    </div>
  </div>

  <div class="modal fade dontprintme" id="remove-modal" role="dialog">
  <div class="modal-dialog modal-md">
  <div class="modal-content">
  <div class="modal-header">
   <button type="button" class="close" data-dismiss="modal">&times;</button>
   <h3 class="modal-title"><?php if($MyData['Status']=='Resigned'){echo 'ACTIVATE';} else { echo 'DEACTIVATE'; } ?> EMPLOYEE</h3>
  </div>
  <div class="modal-body">
  	<select class="form-control chosen chosen-select chosen-deselect" id="txtDeactivateType" data-placeholder = "Select Type">
    	<option value="Resigned">RESIGNED</option>
        <option value="Investigation">FOR SECURTIY INVESTIGATION</option>
        <option value="Terminated">TERMINATED</option>
    </select>

    <div id="remarks_container">
    	 <br/>
        <div id="div_resigned" class="hidden">
        	<h5><strong>Resignation Date :</strong></h5>
            <input class="form-control" type="date" name="txtResignationDate" />
        </div>
        <div id="div_investigation" class="hidden">
        	<h5><strong>Remarks :</strong></h5>
            <textarea name="txtReasons_invest" rows="5" cols="5" class="form-control"></textarea>
        </div>
        <div id="div_terminated" class="hidden">
        	<h5><strong>Remarks :</strong></h5>
            <textarea name="txtReasons_terminated" rows="5" cols="5" class="form-control"></textarea>
        </div>
    </div>


  </div>
  <div class="modal-footer">
      <button type="submit" id="btnDelete" name="btnDelete" value="<?php if($MyData['Status']=='Resigned'){echo 'Activate';} else { echo 'Delete'; } ?>" class="btn btn-primary">Submit Report</button>
  </div>
  </div>
  </div>
  </div>

</form>


<script>

$(document).ready(function(e) {


    $(document).ready(function(){
      var accessArea = document.getElementById('accessArea');
      accessArea.value = $('#cmbAccessArea').val();
    })

    document.getElementById('cmbAccessArea').onchange = function(){
      var accessArea = document.getElementById('accessArea');
      accessArea.value = $('#cmbAccessArea').val();
    }

	xDeactivateType = $('#txtDeactivateType').val();
	if($('#btnDelete').val()=="Activate"){
		$('#div_resigned').addClass('hidden');
		$('#div_investigation').addClass('hidden');
		$('#div_terminated').addClass('hidden');
	}else{
		M_DisplayRemarks(xDeactivateType);
	}
    $(".chosen,.chosen_body").chosen({width: "100%"});

    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
        '.chosen-select-width'     : {width:"100%"}
    };

    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

});


$('#txtDeactivateType').on('change',function(){
	M_DisplayRemarks(this.value);
});

function M_DisplayRemarks(xChecker){
	if(xChecker=="Resigned"){
		$('#div_resigned').removeClass('hidden');
		$('#div_investigation').addClass('hidden');
		$('#div_terminated').addClass('hidden');
	}else if(xChecker=="Investigation"){
		$('#div_resigned').addClass('hidden');
		$('#div_investigation').removeClass('hidden');
		$('#div_terminated').addClass('hidden');
	}else if(xChecker=="Terminated"){
		$('#div_resigned').addClass('hidden');
		$('#div_investigation').addClass('hidden');
		$('#div_terminated').removeClass('hidden');
	}
}
var xLinkedTicket_IsValid = 0;
$('#txtPersonnelID').on('keyup',function(x){
	var xNewEmpID = $(this).val();
	$.ajax ({
		url:'function/func_empid-validation.php',
		type:'post',
		data:'&xNewEmpID='+xNewEmpID,
		success:function(x){
		  if (x!=1){
			$('#txtPersonnelID').css("border-color","#F00");
			xLinkedTicket_IsValid=0;
		  }else{
		  $('#txtPersonnelID').css("border-color",defaultStatus);
		  xLinkedTicket_IsValid=1;
		  }
		}
	});
});

</script>
<script src="js/script_EditPersonnel.js"></script>
