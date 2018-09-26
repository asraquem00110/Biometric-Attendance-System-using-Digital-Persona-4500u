<?php
include('auth.php');
require_once('include/include-head.php');
require_once('include/include-main.php');
require_once('proc/config.php');
// print_r($_SESSION);
/*require_once('css/styles.css'); This is only set just to automatically see immediately the file :D */

// if(!isset($_SESSION['ACTIVE_ACCESS'])){
//   header('location: pg_settings.php');
// }

$_SESSION['RETURN']='pg_reports.php';

$QueTotal = "SELECT * FROM `tbl_datalogs`";
$ResTotal = mysql_query($QueTotal) or die(mysql_error());
$Total = mysql_num_rows($ResTotal);
?>
<div class="panel-group">
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-title"><span style="font-size:x-large;font-weight:bold;">REPORTS SECTION</span>
         <div class="pull-right">
         <button type="button" title="Print" class="btn btn-primary btn-md Link dontprintme" onclick="PrintNow();"><i class="nav-icons fa fa-print"></i>PRINT</button>
         </div>
      </div>
    </div>
    <?php require_once('message.php'); ?>
    <div class="panel-body">
      <div class="panel panel-primary">
        <div class="panel-heading dontprintme"><span style="font-size:x-large;font-weight:bold;">DATA LOGS</span>
        </div>
        <div class="panel-body">
          <form action="" method="post">
            <div class="row">
              <div class="col-lg-2">
                <button type="submit" class="btn btn-success dontprintme" style="font-weight:bold;"><span class="fa fa-refresh"></span></button>
              </div>
              <div class="col-lg-1 col-lg-offset-9">

                <div class="input-group">
                  <input type="search" name="Search" placeholder="Search" class="form-control dontprintme hide"/>
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-info dontprintme" style="font-weight:bold;" data-toggle="modal" data-target="#filter-modal">FILTER</button>
                  <button class="btn btn-primary dontprintme hide">GO</button>
                  </span> </div>
              </div>
            </div>
          </form>
          <br />
          <div class="table-responsive">
            <form action="pg_EditEmployee.php" method="post" id="frmDisplayInfo">
              <table class = "table table-bordered table-heading-center text-center arrow_paging" id = "tblLogs" width = "100%" style = "margin-bottom:0">
                <thead>
                <?php
                  $Display='';
                  $DataLogs = array();
                  if(isset($_POST['FilterBy'])){
                    $DataLogsPers = array();
                    if ($_POST['Filter'][9]=='PERSONNEL'){
                      // print_r($_POST);exit;
                      echo "<input type=\"hidden\" id=\"txtMode\" value='1'/>";
                      $xOr=0;
                      $QuePersonnel = "SELECT a.`UserID`,a.`FullName`,a.`TimeIn`,a.`TimeOut`,b.`Position`,b.`AccessArea`,b.`DateHired`,b.`ProjectAssigned`,b.`DateHired`,b.`AgencyCompany` FROM `tbl_datalogs` a JOIN `db_eas`.`tbl_personnel` b ON(a.`UserID`=b.`AccessID`)";
                      if($_POST['Filter'][0]<>""){ //ID Number
                        if ($xOr=="1"){
                          $QuePersonnel = $QuePersonnel . " AND a.UserID LIKE '%".$_POST['Filter'][0]."%'"; }
                        else{
                          $QuePersonnel = $QuePersonnel . " WHERE a.UserID LIKE '%".$_POST['Filter'][0]."%'";
                          $xOr="1";
                        }
                      }

                      if($_POST['Filter'][1]<>""){ //Company
                        if ($xOr=="1"){
                          $QuePersonnel = $QuePersonnel . " AND `a.UserID` LIKE '%".$_POST['Filter'][1]."%'"; }
                        else{
                          $QuePersonnel = $QuePersonnel . " WHERE `a.UserID` LIKE '%".$_POST['Filter'][1]."%'";
                          $xOr="1";
                        }
                      }

                      if(($_POST['Filter'][2]<>"") && ($_POST['Filter'][3]<>"")){ //TimeIn TimeOut
                        if ($xOr=="1"){
                          $QuePersonnel = $QuePersonnel . " AND date(a.`TimeIN`) BETWEEN date('".$_POST['Filter'][2]."') AND date('".$_POST['Filter'][3]."')"; }
                        else{
                          $QuePersonnel = $QuePersonnel . " WHERE date(a.`TimeIN`) BETWEEN date('".$_POST['Filter'][2]."') AND date('".$_POST['Filter'][3]."')";
                          $xOr="1";
                        }
                      }

                      if($_POST['Filter'][4]<>""){ //Remarks
                        if ($xOr=="1"){
                          $QuePersonnel = $QuePersonnel . " AND a.`Remarks` LIKE '%".$_POST['Filter'][4]."%'"; }
                        else{
                          $QuePersonnel = $QuePersonnel . " WHERE a.`Remarks` LIKE '%".$_POST['Filter'][4]."%'";
                          $xOr="1";
                        }
                      }

                      if($_POST['Filter'][5]<>""){ //FullName
                        if ($xOr=="1"){
                          $QuePersonnel = $QuePersonnel . " AND a.`FullName` LIKE '%".$_POST['Filter'][5]."%'"; }
                        else{
                          $QuePersonnel = $QuePersonnel . " WHERE a.`FullName` LIKE '%".$_POST['Filter'][5]."%'";
                          $xOr="1";
                        }
                      }

                      if($_POST['Filter'][6]<>""){ //Access Area
                        if ($xOr=="1"){
                          $QuePersonnel = $QuePersonnel . " AND b.`AccessArea` LIKE '%".$_POST['Filter'][6]."%'"; }
                        else{
                          $QuePersonnel = $QuePersonnel . " WHERE b.`AccessArea` LIKE '%".$_POST['Filter'][6]."%'";
                          $xOr="1";
                        }
                      }

                      if($_POST['Filter'][7]<>""){ //Status
                        if ($xOr=="1"){
                          $QuePersonnel = $QuePersonnel . " AND a.`Status` LIKE '%".$_POST['Filter'][7]."%'"; }
                        else{
                          $QuePersonnel = $QuePersonnel . " WHERE a.`Status` LIKE '%".$_POST['Filter'][7]."%'";
                          $xOr="1";
                        }
                      }

                      if($_POST['Filter'][8]<>""){ //Status
                        if ($xOr=="1"){
                          $QuePersonnel = $QuePersonnel . " AND b.`Position` LIKE '%".$_POST['Filter'][8]."%'"; }
                        else{
                          $QuePersonnel = $QuePersonnel . " WHERE b.`Position` LIKE '%".$_POST['Filter'][8]."%'";
                          $xOr="1";
                        }
                      }
// echo $QuePersonnel;exit;
                      // $QuePersonnel = "SELECT a.`FullName`,a.`TimeIn`,a.`TimeOut`,a.`AccessArea`,b.`DateHired`,b.`ProjectAssigned`,b.`DateHired`,b.`AgencyCompany` FROM `tbl_datalogs` a RIGHT JOIN `db_eas`.`tbl_personnel` b ON(a.`UserID`=b.`AccessID`) WHERE
                      // date(a.`TimeIN`) BETWEEN date('".$_POST['Filter'][2]."') AND date('".$_POST['Filter'][3]."') OR a.UserID LIKE '%".$_POST['Filter'][0]."%' OR a.`FullName` LIKE '%".$_POST['Filter'][5]."%' OR a.`AccessArea` LIKE '%".$_POST['Filter'][6]."%'
                      //   OR a.`Remarks` LIKE '%".$_POST['Filter'][4]."%' OR a.`Status` LIKE '%".$_POST['Filter'][7]."%'";
                      $ResPersonnel = mysql_query($QuePersonnel) or die(mysql_error());
                      $Display.="<th>ID Number</th>".
                                "<th>Full Name</th>".
                                "<th>Date Hired</th>".
                                "<th>Project</th>".
                                "<th>Position</th>".
                                "<th>Time In</th>".
                                "<th>Time Out</th>".
                                "<th>Access Area</th>";
                      while($RowPersonnel = mysql_fetch_array($ResPersonnel)){
                        $DataLogs[] = array(
                          $RowPersonnel['UserID'],
                          $RowPersonnel['FullName'],
                          $RowPersonnel['DateHired'],
                          $RowPersonnel['ProjectAssigned'],
                          $RowPersonnel['Position'],
                          $RowPersonnel['TimeIn'],
                          $RowPersonnel['TimeOut'],
                          $RowPersonnel['AccessArea'],
                        );
                      }

                  }elseif($_POST['Filter'][9]=='VISITOR'){
                    // print_r($_POST);exit;
                    echo "<input type=\"hidden\" id=\"txtMode\" value='2'/>";
                    $xOr=0;
                    $QuePersonnel = "SELECT a.`AccessID`,a.`FullName`,a.`TimeIn`,a.`TimeOut`,b.`Address`,b.`AccessArea`,b.`ContactPerson`,b.`VisitorType` FROM `tbl_datalogs` a JOIN `db_eas`.`tbl_visitor` b ON(a.`UserID`=b.`AccessID`)";
                    // echo $QuePersonnel;exit;
                    if($_POST['Filter'][0]<>""){ //ID Number
                      if ($xOr=="1"){
                        $QuePersonnel = $QuePersonnel . " AND a.UserID LIKE '%".$_POST['Filter'][0]."%'"; }
                  		else{
                    		$QuePersonnel = $QuePersonnel . " WHERE a.UserID LIKE '%".$_POST['Filter'][0]."%'";
                    		$xOr="1";
                      }
                    }

                    if($_POST['Filter'][1]<>""){ //Company
                      if ($xOr=="1"){
                        $QuePersonnel = $QuePersonnel . " AND `a.UserID` LIKE '%".$_POST['Filter'][1]."%'"; }
                  		else{
                    		$QuePersonnel = $QuePersonnel . " WHERE `a.UserID` LIKE '%".$_POST['Filter'][1]."%'";
                    		$xOr="1";
                      }
                    }

                    if(($_POST['Filter'][2]<>"") && ($_POST['Filter'][3]<>"")){ //TimeIn TimeOut
                      if ($xOr=="1"){
                        $QuePersonnel = $QuePersonnel . " AND date(a.`TimeIN`) BETWEEN date('".$_POST['Filter'][2]."') AND date('".$_POST['Filter'][3]."')"; }
                  		else{
                    		$QuePersonnel = $QuePersonnel . " WHERE date(a.`TimeIN`) BETWEEN date('".$_POST['Filter'][2]."') AND date('".$_POST['Filter'][3]."')";
                    		$xOr="1";
                      }
                    }

                    if($_POST['Filter'][4]<>""){ //Remarks
                      if ($xOr=="1"){
                        $QuePersonnel = $QuePersonnel . " AND a.`Remarks` LIKE '%".$_POST['Filter'][4]."%'"; }
                  		else{
                    		$QuePersonnel = $QuePersonnel . " WHERE a.`Remarks` LIKE '%".$_POST['Filter'][4]."%'";
                    		$xOr="1";
                      }
                    }

                    if($_POST['Filter'][5]<>""){ //FullName
                      if ($xOr=="1"){
                        $QuePersonnel = $QuePersonnel . " AND a.`FullName` LIKE '%".$_POST['Filter'][5]."%'"; }
                  		else{
                    		$QuePersonnel = $QuePersonnel . " WHERE a.`FullName` LIKE '%".$_POST['Filter'][5]."%'";
                    		$xOr="1";
                      }
                    }

                    if($_POST['Filter'][6]<>""){ //Access Area
                      if ($xOr=="1"){
                        $QuePersonnel = $QuePersonnel . " AND b.`AccessArea` LIKE '%".$_POST['Filter'][6]."%'"; }
                  		else{
                    		$QuePersonnel = $QuePersonnel . " WHERE b.`AccessArea` LIKE '%".$_POST['Filter'][6]."%'";
                    		$xOr="1";
                      }
                    }

                    if($_POST['Filter'][7]<>""){ //Status
                      if ($xOr=="1"){
                        $QuePersonnel = $QuePersonnel . " AND a.`Status` LIKE '%".$_POST['Filter'][7]."%'"; }
                  		else{
                    		$QuePersonnel = $QuePersonnel . " WHERE a.`Status` LIKE '%".$_POST['Filter'][7]."%'";
                    		$xOr="1";
                      }
                    }
                    // $QuePersonnel = "SELECT a.`FullName`,a.`TimeIn`,a.`TimeOut`,b.`AccessArea`,b.`ContactPerson`,b.`VisitorType` FROM `tbl_datalogs` a RIGHT JOIN `db_eas`.`tbl_visitor` b ON(a.`UserID`=b.`VisitorID`) WHERE
                    // date(a.`TimeIN`) BETWEEN date('".$_POST['Filter'][2]."') AND date('".$_POST['Filter'][3]."') OR a.UserID LIKE '%".$_POST['Filter'][0]."%' OR a.`FullName` LIKE '%".$_POST['Filter'][5]."%' OR a.`AccessArea` LIKE '%".$_POST['Filter'][6]."%'
                    //   OR a.`Remarks` LIKE '%".$_POST['Filter'][4]."%' OR a.`Status` LIKE '%".$_POST['Filter'][7]."%'";
                    // $QuePersonnel = $QuePersonnel."GROUP BY a.`TimeIn`";
                    // echo $QuePersonnel;exit;
                    $ResPersonnel = mysql_query($QuePersonnel) or die(mysql_error());
                    $Display.="<th>ID Number</th>".
                              "<th>Full Name</th>".
                              "<th>Company</th>".
                              "<th>Time In</th>".
                              "<th>Time Out</th>".
                              "<th>Access Area</th>";
                    while($RowPersonnel = mysql_fetch_array($ResPersonnel)){
                      $DataLogs[] = array(
                        $RowPersonnel['AccessID'],
                        $RowPersonnel['FullName'],
                        $RowPersonnel['Address'],
                        $RowPersonnel['TimeIn'],
                        $RowPersonnel['TimeOut'],
                        $RowPersonnel['AccessArea'],
                      );
                    }
                  }else{
                    $xOr=0;
                    $QuePersonnel = "SELECT a.`FullName`,a.`TimeIn`,a.`TimeOut`,a.`AccessArea` FROM `tbl_datalogs` a";
                    if($_POST['Filter'][0]<>""){ //ID Number
                      if ($xOr=="1"){
                        $QuePersonnel = $QuePersonnel . " AND a.UserID LIKE '%".$_POST['Filter'][0]."%'"; }
                  		else{
                    		$QuePersonnel = $QuePersonnel . " WHERE a.UserID LIKE '%".$_POST['Filter'][0]."%'";
                    		$xOr="1";
                      }
                    }

                    if($_POST['Filter'][1]<>""){ //Company
                      if ($xOr=="1"){
                        $QuePersonnel = $QuePersonnel . " AND `a.UserID` LIKE '%".$_POST['Filter'][1]."%'"; }
                  		else{
                    		$QuePersonnel = $QuePersonnel . " WHERE `a.UserID` LIKE '%".$_POST['Filter'][1]."%'";
                    		$xOr="1";
                      }
                    }

                    if(($_POST['Filter'][2]<>"") && ($_POST['Filter'][3]<>"")){ //TimeIn TimeOut
                      if ($xOr=="1"){
                        $QuePersonnel = $QuePersonnel . " AND date(a.`TimeIN`) BETWEEN date('".$_POST['Filter'][2]."') AND date('".$_POST['Filter'][3]."')"; }
                  		else{
                    		$QuePersonnel = $QuePersonnel . " WHERE date(a.`TimeIN`) BETWEEN date('".$_POST['Filter'][2]."') AND date('".$_POST['Filter'][3]."')";
                    		$xOr="1";
                      }
                    }

                    if($_POST['Filter'][4]<>""){ //Remarks
                      if ($xOr=="1"){
                        $QuePersonnel = $QuePersonnel . " AND a.`Remarks` LIKE '%".$_POST['Filter'][4]."%'"; }
                  		else{
                    		$QuePersonnel = $QuePersonnel . " WHERE a.`Remarks` LIKE '%".$_POST['Filter'][4]."%'";
                    		$xOr="1";
                      }
                    }

                    if($_POST['Filter'][5]<>""){ //FullName
                      if ($xOr=="1"){
                        $QuePersonnel = $QuePersonnel . " AND a.`FullName` LIKE '%".$_POST['Filter'][5]."%'"; }
                  		else{
                    		$QuePersonnel = $QuePersonnel . " WHERE a.`FullName` LIKE '%".$_POST['Filter'][5]."%'";
                    		$xOr="1";
                      }
                    }

                    if($_POST['Filter'][6]<>""){ //Access Area
                      if ($xOr=="1"){
                        $QuePersonnel = $QuePersonnel . " AND a.`AccessArea` LIKE '%".$_POST['Filter'][6]."%'"; }
                  		else{
                    		$QuePersonnel = $QuePersonnel . " WHERE a.`AccessArea` LIKE '%".$_POST['Filter'][6]."%'";
                    		$xOr="1";
                      }
                    }

                    if($_POST['Filter'][7]<>""){ //Status
                      if ($xOr=="1"){
                        $QuePersonnel = $QuePersonnel . " AND a.`Status` LIKE '%".$_POST['Filter'][7]."%'"; }
                  		else{
                    		$QuePersonnel = $QuePersonnel . " WHERE a.`Status` LIKE '%".$_POST['Filter'][7]."%'";
                    		$xOr="1";
                      }
                    }

                    // $QuePersonnel = "SELECT a.`FullName`,a.`TimeIn`,a.`TimeOut`,b.`AccessArea`,b.`ContactPerson`,b.`VisitorType` FROM `tbl_datalogs` a RIGHT JOIN `db_eas`.`tbl_visitor` b ON(a.`UserID`=b.`VisitorID`) WHERE
                    // date(a.`TimeIN`) BETWEEN date('".$_POST['Filter'][2]."') AND date('".$_POST['Filter'][3]."') OR a.UserID LIKE '%".$_POST['Filter'][0]."%' OR a.`FullName` LIKE '%".$_POST['Filter'][5]."%' OR a.`AccessArea` LIKE '%".$_POST['Filter'][6]."%'
                    //   OR a.`Remarks` LIKE '%".$_POST['Filter'][4]."%' OR a.`Status` LIKE '%".$_POST['Filter'][7]."%'";
                    //   echo $QuePersonnel;exit;
                    $ResPersonnel = mysql_query($QuePersonnel) or die(mysql_error());
                    $Display.="<th>FULL NAME</th>".
                              "<th>Time in</th>".
                              "<th>Time out</th>".
                              "<th>Access Area</th>";
                    while($RowPersonnel = mysql_fetch_array($ResPersonnel)){
                      $DataLogs[] = array(
                              $RowPersonnel['FullName'],
                              $RowPersonnel['TimeIn'],
                              $RowPersonnel['TimeOut'],
                              $RowPersonnel['AccessArea'],
                      );
                    }
                  }
                }else{
                    $QueLogs = "SELECT a.`FullName`,a.`TimeIn`,a.`TimeOut`,a.`AccessArea` FROM `tbl_datalogs` a";
                    $ResLogs = mysql_query($QueLogs) or die(mysql_error());
                    $Display.="<th>FULL NAME</th>".
                              "<th>Time in</th>".
                              "<th>Time out</th>".
                              "<th>Access Area</th>";
                    while($RowLogs = mysql_fetch_array($ResLogs)){
                      $DataLogs[] = array(
                              $RowLogs['FullName'],
                              $RowLogs['TimeIn'],
                              $RowLogs['TimeOut'],
                              $RowLogs['AccessArea'],
                      );

                    }


                  }
  echo $Display;
                ?>
              </thead>
                <tbody id="tbody_disp">
                </tbody>

              </table>
              <input type="hidden" name="ID" id="txtSelectedID" />
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<form action="" method="post">
<div class="modal fade" id="filter-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><span style="font:bold 22px Arial, Helvetica, sans-serif;">FILTER BY</span></h3>
      </div>
      <form role="form" id="frmFilterBy" action="" method="post">
        <div class="modal-body">
        <h4><p>This is a multiple filtering search engine, Please select your filtering choices.</p></h4>
          <div class="panel-body">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="control-label">ID NUMBER</label>
                <input type="text" class="form-control" tabindex="1" name="Filter[]">
              </div>
              <div class="form-group">
                <label class="control-label">COMPANY</label>
                <input type="text" class="form-control" tabindex="3" name="Filter[]">
              </div>
              <div class="form-group">
                <label class="control-label">DATE FROM</label>
                <input type="date" class="form-control" tabindex="5" name="Filter[]" onchange="if(this.value!=''){document.getElementsByName('Filter[]')[3].setAttribute('required','required');} else {document.getElementsByName('Filter[]')[3].removeAttribute('required');}">
              </div>
              <div class="form-group">
                <label class="control-label">DATE TO</label>
                <input type="date" class="form-control" tabindex="6" name="Filter[]">
              </div>
              <div class="form-group">
                <label class="control-label">REMARKS</label>
                <textarea rows="2" class="form-control" tabindex="8" name="Filter[]"></textarea>
              </div>

            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="control-label">FULL NAME</label>
                <input type="text" class="form-control" tabindex="2" name="Filter[]">
              </div>
              <div class="form-group">
                <label class="control-label">ACCESS AREA</label>
                <br />
               <select onChange="GetList(this);" tabindex="4" multiple class="form-control chosen chosen-select chosen-deselect" data-placeholder = "Select Access Area">
				<?php
                $res = Global_MySQL('',"SELECT * FROM `tbl_arealist`",false);
                $display='';
                while($row = mysql_fetch_assoc($res)){
                    $display .= '<option title="Type:'.$row['AreaType'].'">'.$row['AreaName'].'</option>';
                }
                echo $display;
                ?>
                </select>
                <input type="hidden" id="txtAccessArea" name="Filter[]" />
              </div>
	          <!--<div class="form-group">
                <label class="control-label">TIME IN</label>
                <input type="time" class="form-control" name="Filter[]">
              </div>
              <div class="form-group">
                <label class="control-label">TIME OUT</label>
                <input type="time" class="form-control" name="Filter[]">
              </div>-->
              <div class="form-group">
              <label class="control-label">ACCESS</label>
              <select name="Filter[]" tabindex="7" class="form-control">
              <option></option>
              <option class="text-success">GRANTED</option>
              <option class="text-danger">DENIED</option>
              </select>
              </div>
              <!-- <div class="form-group">
              <label class="control-label">COUNT BY</label>
              <select name="Filter[]" tabindex="8" class="form-control">
              <option></option>
              <option>TIME IN</option>
              <option>TIME OUT</option>
              </select>
              </div> -->
              <div class="form-group">
                <label class="control-label">POSITION</label>
                <input type="text" class="form-control" tabindex="2" name="Filter[]">
              </div>
               <div class="form-group">
               		  <label class="control-label">TYPE</label>
                      <select name="Filter[]" tabindex="8" class="form-control">
                      <option></option>
                      <option>PERSONNEL</option>
                      <option>VISITOR</option>
                      </select>
               </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="FilterBy" class="btn btn-primary">GO</button>
        </div>
      </form>
    </div>
  </div>
</div>
</form>
<?php include_once('include/include-body.php');//included links here (body) ?>
<script src="dist/dataTables/js/jquery.dataTables.min.js"></script>
<script src="dist/dataTables/js/dataTables.bootstrap.min.js"></script>
<script src="dist/highcharts/js/export-csv/export-csv.js"></script>
<script src="js/script_Reports.js"></script>

<script>
var dataSetLogs='';
	dataSetLogs = <?php echo json_encode($DataLogs); ?>;
</script>
<script src = "js/settings/dataTableScript.js"></script> <!-- Include DataTable Configurations -->
<script>
    dataTableSettings('#tblLogs', dataSetLogs);
</script>

<script>
function PrintNow(){
  var xData = dataSetLogs;
  if(xData == '')
      return;
  JSONToCSVConvertor_TID(xData, "EAS REPORT", true);
}

function JSONToCSVConvertor_TID(JSONData, ReportTitle, ShowLabel) {
  //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
  var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

  var CSV = '';
  //Set Report title in first row or line

  CSV += ReportTitle + '\r\n\n';

  //This condition will generate the Label/Header
  if (ShowLabel) {
      var row = "";

      //This loop will extract the label from 1st index of on array
      for (var index in arrData[0]) {
        if ($('#txtMode').val() == 1){
          if(index==0){
             row += "ID Number" + ',';
          }else if(index==1){
             row += "Full Name" + ',';
          }else if(index==2){
             row += "Date Hired" + ',';
          }else if(index==3){
             row += "Project" + ',';
          }else if(index==4){
             row += "Position" + ',';
          }else if(index==5){
             row += "Time In" + ',';
          }else if(index==6){
             row += "Time Out" + ',';
          }else if(index==7){
             row += "Access Area" + ',';
          }
        }else if($('#txtMode').val() == 2){
          if(index==0){
             row += "ID Number" + ',';
          }else if(index==1){
             row += "Full Name" + ',';
          }else if(index==2){
             row += "Company" + ',';
          }else if(index==3){
             row += "Time In" + ',';
          }else if(index==4){
             row += "Time Out" + ',';
          }else if(index==5){
             row += "Access Area" + ',';
          }
        }else{
          if(index==0){
             row += "FullName" + ',';
          }else if(index==1){
             row += "Time In" + ',';
          }else if(index==2){
             row += "Time Out" + ',';
          }else if(index==3){
             row += "Access Area" + ',';
          }
        }

          //Now convert each value to string and comma-seprated


      }

      //row = row.slice(0, -1);


      //append Label row with line break
      CSV += row + '\r\n';
  }

  //1st loop is to extract each row
  for (var i = 0; i < arrData.length; i++) {
      var row = "";

      //2nd loop will extract each column and convert it in string comma-seprated
      for (var index in arrData[i]) {
      if(arrData[i][index] === null){
        arrData[i][index] = "";
      }
      var xVal = arrData[i][index].toString();
          row += '"' + xVal + '",';
      }

      row.slice(0, row.length - 1);

      //add a line break after each row
      CSV += row + '\r\n';
  }
// CSV += "ATPI EAS" + ',';
// CSV += "REPORT" + '\r'; //HERE
  if (CSV == '') {
      alert("Invalid data");
      return;
  }

  //Generate a file name
  var fileName = "";
  //this will remove the blank-spaces from the title and replace it with an underscore
  fileName += ReportTitle.replace(/ /g,"_");

  //Initialize file format you want csv or xls
  var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);

  // Now the little tricky part.
  // you can use either>> window.open(uri);
  // but this will not work in some browsers
  // or you will not get the correct file extension

  //this trick will generate a temp <a /> tag
  var link = document.createElement("a");
  link.href = uri;

  //set the visibility hidden so it will not effect on your web-layout
  link.style = "visibility:hidden";
  link.download = fileName + ".csv";

  //this part will append the anchor tag and remove it after automatic click
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);

}
</script>
