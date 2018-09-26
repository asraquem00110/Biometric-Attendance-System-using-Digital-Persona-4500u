<?php
include('auth.php');
require_once('include/include-head.php');
require_once('include/include-main.php');
require_once('proc/config.php');

?>
<!--<link href="dist/bootstrap/css/bootstrap.min.css" rel="stylesheet">-->

<div class="col col-md-12">
<div class="panel-group">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="panel-title">
                <span style="font-size:x-large;font-weight:bold;">&nbsp;</span>

                  <div class="col col-md-4 pull-left">
                    <table width="100%">
                        <tr>
                           
                            <td width="31.5%"><button class="btn btn-default" onclick="getDatalogs()"><span class="fa fa-refresh"></span> REFRESH</button></td>
                            <td><button class="btn btn-info" id="showFilterModal"><span class="fa fa-filter"></span> FILTER</button></td>
                        </tr>
                    </table>
                </div>

                <div class="col col-md-3 pull-right">
                    <table width="100%">
                        <tr>
                            <td align="right"><button class="btn btn-success" id="exportExcel"><span class="fa fa-file-excel-o"></span> EXPORT EXCEL</button></td>
                        </tr>
                    </table>

                </div>
              
            </div>
        </div>

        <div class="panel-body">
            
            <table class="table table-bordered table-hover" id="datalogs">
                <thead>
                    <tr>
                        <th>ACCESS ID</th>
                        <th>FULLNAME</th>
                        <th>TIMERECORD</th>
                        <th>IN/OUT</th>
                        <th>STATUS</th>
                        <th>ACCESS AREA</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
</div>



<div class="modal fade" id="filterModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><span style="font:bold 22px Arial, Helvetica, sans-serif;">FILTER BY</span></h3>
      </div>
        <div class="modal-body">
        <h4><p>This is a multiple filtering search engine, Please select your filtering choices.</p></h4>
          <div class="panel-body">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="control-label">ACCESS NO</label>
                <input type="text" class="form-control" tabindex="1" id="accessnumber">
              </div>
              <div class="form-group">
                <label class="control-label">COMPANY</label>
                <input type="text" class="form-control" tabindex="3" id="company">
              </div>

               <div class="form-group">
                <label class="control-label">IN/OUT</label>
                <select class="form-control" id="in_out">
                    <option></option>
                    <option>IN</option>
                    <option>OUT</option>
                </select>
              </div>

              <div class="form-group">
                <label class="control-label">DATE FROM</label>
                <input type="date" name="datefrom" class="form-control" id="datefrom" value="<?php echo date("Y-m-d",time());?>">
              </div>
              <div class="form-group">
                <label class="control-label">DATE TO</label>
                <input type="date" name="datefrom" class="form-control" id="dateto" value="<?php echo date("Y-m-d",time());?>">
              </div>
            <!--   <div class="form-group">
                <label class="control-label">REMARKS</label>
                <textarea rows="2" class="form-control" tabindex="8" name="Filter[]"></textarea>
              </div> -->

            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="control-label">FULL NAME</label>
                <input type="text" class="form-control" tabindex="2" id="fullname">
              </div>

               <div class="form-group">
                <label class="control-label">PROJECT</label>
                    <select class="form-control" id="txtProject">
                                <option></option>
                                <?php
                                  $sql = "SELECT DISTINCT(ProjectAssigned) FROM tbl_personnel";
                                  $res = mysql_query($sql) or die(mysql_error());
                                  if(mysql_num_rows($res)>0){
                                    while($row=mysql_fetch_assoc($res)){
                                      echo '<option>'.$row['ProjectAssigned'].'</option>';
                                    }
                                  }

                                ?>
                     </select>
              </div>

              <div class="form-group">
                <label class="control-label">ACCESS AREA</label>
                <br />
               <select tabindex="4" multiple class="form-control chosen chosen-select chosen-deselect" data-placeholder = "Select Access Area" id="accessarea">
                <?php
                $res = Global_MySQL('',"SELECT * FROM `tbl_arealist`",false);
                $display='';
                while($row = mysql_fetch_assoc($res)){
                    $display .= '<option title="Type:'.$row['AreaType'].'">'.$row['AreaName'].'</option>';
                }
                echo $display;
                ?>
                </select>
               
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
              <select id="accesstype" tabindex="7" class="form-control">
              <option></option>
              <option class="text-success">GRANTED</option>
              <option class="text-danger">DENIED</option>
              </select>
              </div>
     
            </div>
          </div>
        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-default pull-left" id="cancelHide"><span class="fa fa-close"></span> Close</button>
         <button type="button" class="btn btn-success pull-right" id="proceedFilter"><span class="fa fa-check"></span> FILTER</button>
        </div>
    </div>
  </div>
</div>

<script src="js/script_Reports.js"></script>

<script>

    $(document).ready(function(){
        getDatalogs();
    })

    function getDatalogs(){
        $('#datalogs').dataTable({
            'bProcessing': true,
            'sAjaxSource': 'function/getDatalogs_bio.php',
            'sAjaxDataProp': "data",
            'lengthMenu': [[15,50,100,200,500,-1],[15,50,100,200,500,'ALL']],
            'destroy': true,
            "order": [[ 2, "desc" ]],
        })

          // JQUERY GET JSON RESPONSE
        // $.getJSON('function/getDatalogs_bio.php',function(result){
        //   console.log('Checkout this JSON! ', result['display']);
        // });

            // PLAIN JAVASCRIPT GET JSON RESPONSE
            // let url = 'function/getDatalogs_bio.php';

            // fetch(url)
            // .then(res => res.json())
            // .then((out) => {
            //   console.log('Checkout this JSON! ', out['display']);
            // })
            // .catch(err => { throw err });
    }

    $(document).on('click','#cancelHide',function(){
        $('#filterModal').modal('hide');
    })

      $(document).on('click','#showFilterModal',function(){
        $('#filterModal').modal('show');
    })

      $(document).on('click','#proceedFilter',function(){
        var datefrom = $('#datefrom').val();
        var dateto = $('#dateto').val();
        var accessno = $('#accessnumber').val();
        var fullname = $('#fullname').val();
        var company = $('#company').val();
        var accessarea = $('#accessarea').val();
        var accesstype = $('#accesstype').val();
        var project = $('#txtProject').val();
        var inout = $('#in_out').val();

         $('#datalogs').dataTable({
            'bProcessing': true,
            'sAjaxSource': 'function/getDatalogs_bio.php?search=true&datefrom='+datefrom+'&dateto='+dateto+'&accessno='+accessno+'&fullname='+fullname+'&company='+company+'&accessarea='+accessarea+'&accesstype='+accesstype+'&project='+project+'&inout='+inout,
            'sAjaxDataProp': "data",
            'lengthMenu': [[15,50,100,200,500,-1],[15,50,100,200,500,'ALL']],
            'destroy': true,
            "order": [[ 2, "desc" ]],
        })


          $('#filterModal').modal('hide');
      })


       // generate excel detailed
      $("#exportExcel").click(function(e) {
     
            $("#datalogs").dataTable({
                'destroy': true,
                'lengthMenu': [[-1],['ALL']],
               })
            e.preventDefault();
            var datenow = "BIOMETRICS_LOGS(<?php echo date('m_d_Y',time());?>)";
            //getting data from our table
            var data_type = 'data:application/vnd.ms-excel';
            var table_div = document.getElementById('datalogs');
            // table_div.removeAttribute("style");
            var table_html = table_div.outerHTML.replace(/ /g, '%20');
            var a = document.createElement('a');
            a.href = data_type + ', ' + table_html;
            a.download = datenow+'_Report.xls';
            a.click();
            
      });


</script>

