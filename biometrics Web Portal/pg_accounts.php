<style>
	.chosen-select{
		width: 100% !important;
	}

</style>
<?php
include('auth.php');
require_once('include/include-head.php');
require_once('include/include-main.php');
require_once('proc/config.php');
/*require_once('css/styles.css'); This is only set just to automatically see immediately the file :D */

if(isset($_POST['biometricsID'])){

    $biometricsID = clean($_POST['biometricsID']);
    $employeeID = clean($_POST['employeeid']);
    $fullname = clean($_POST['fullname']);
    $datehired = clean($_POST['datehired']);
    $position = clean($_POST['position']);
    $company = clean($_POST['company']);
    $project = clean($_POST['project']);
    $timein = clean($_POST['timein']);
    $timeout = clean($_POST['timeout']);
    $schedule = clean($_POST['txtSchedule']);
    $AccessArea = clean($_POST['txtaccessArea']);

    $sql = "INSERT INTO tbl_personnel (EmployeeID,AccessID,Fullname,DateHired,Position,AgencyCompany,ProjectAssigned,AccessArea,TimeIN,TimeOut,schedule_dates) VALUES('$employeeID','$biometricsID','$fullname','$datehired','$position','$company','$project','$AccessArea','$timein','$timeout','$schedule')";
    $res = mysql_query($sql) or die(mysql_error());
    if($res){}

}

?>
    <div class="col col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><strong style="font-size: 14pt"><span class="glyphicon glyphicon-user"></span> ACCOUNTS</strong></div>
            <div class="panel-body">
                <div style="margin-bottom: 30pt;">
            <!--     <button class="btn btn-md btn-primary pull-left"><span class="glyphicon glyphicon-plus"></span></button>
 -->                  <button class="btn btn-md btn-primary pull-right" id="showAddModal"><span class="glyphicon glyphicon-plus"></span> NEW</button>
                </div>
                <table class="table table-bordered" id="accounts">
                    <thead>
                        <tr>
                            <th>BIOMETRIC ID</th>
                            <th>EMPLOYEE ID</th>
                            <th>FULL NAME</th>
                            <th>DATE HIRED</th>
                            <th>POSITION</th>
                            <th>COMPANY</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="AddModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"></div>
            <div class="modal-body">
                <form class="form-horizontal" action="" method="POST">
                   
                    <div class="col col-md-6">
                    <div class="form-group">
                        <label>BIOMETRICS ID</label>
                        <input type="text" name="biometricsID" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>EMPLOYEE ID</label>
                        <input type="text" name="employeeid" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>FULL NAME</label>
                        <input type="text" name="fullname" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>DATE HIRED</label>
                        <input type="date" name="datehired" class="form-control">
                    </div>

                     <div class="form-group">
                        <label>POSITION</label>
                        <input type="text" name="position" class="form-control">
                    </div>

                         <div class="form-group">
                        <label>COMPANY</label>
                        <input type="text" name="company" class="form-control">
                    </div>

                     <div class="form-group">
                        <label>PROJECT</label>
                        <input type="text" name="project" class="form-control">
                    </div>

                </div>

                 <div class="col col-md-6">
                

                    <div class="form-group">
                        <label>AREA</label>
                        <select id = "AccessArea" name = "AccessArea" multiple class="form-control chosen chosen-select chosen-deselect" data-placeholder = "Select Access Area" required>
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
                            
                            ?>
                            <?php foreach($arealist as $area):?>
                                <option><?php echo $area;?></option>
                            <?php endforeach ?>
                        </select>
                        <input type="hidden" name="txtaccessArea" id="txtaccessArea">
                    </div>

                      <div class="form-group">
                        <label>TIME IN</label>
                        <input type="time" name="timein" class="form-control">
                    </div>

                     <div class="form-group">
                        <label>TIME OUT</label>
                        <input type="time" name="timeout" class="form-control">
                    </div>

                         <div class="form-group">
                        <label>SCHEDULE</label>
                        <select id = "Schedule" name = "Schedule" multiple class="form-control chosen chosen-select chosen-deselect" data-placeholder = "Select Access Area" required>
                                  <option></option>
                                  <option>Monday</option>
                                    <option>Tuesday</option>
                                    <option>Wednesday</option>
                                    <option>Thursday</option>
                                    <option>Friday</option>
                                    <option>Saturday</option>
                                    <option>Sunday</option>
                        </select>
                        <input type="hidden" name="txtSchedule" id="txtSchedule">
                    </div>

                </div>
                   
                
            </div>
            <div class="modal-footer">
                <button class="submit btn btn-md btn-primary">SAVE</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    document.addEventListener("DOMContentLoaded",function(){
        getAccounts();
    },false);
   
    function getAccounts(){
         $('#accounts').dataTable({
            'bProcessing': true,
            'sAjaxSource': 'function/getAccounts.php',
            'sAjaxDataProp': "data",
            'lengthMenu': [[15,50,100,200,500,-1],[15,50,100,200,500,'ALL']],
            'destroy': true,
            "order": [[ 2, "desc" ]],
        })
    }

    $(document).on('click','#showAddModal',function(){
        $('#AddModal').modal('show');
    });

   $(".chosen,.chosen_body").chosen({width: "100%"});

      $(document).ready(function(){
      var accessArea = document.getElementById('txtaccessArea');
      accessArea.value = $('#AccessArea').val();

      var schedule = document.getElementById('txtSchedule');
      schedule.value = $('#Schedule').val();


    })

    document.getElementById('AccessArea').onchange = function(){
      var accessArea = document.getElementById('txtaccessArea');
      accessArea.value = $('#AccessArea').val();
    }

     document.getElementById('Schedule').onchange = function(){
      var schedule = document.getElementById('txtSchedule');
      schedule.value = $('#Schedule').val();
    }

</script>