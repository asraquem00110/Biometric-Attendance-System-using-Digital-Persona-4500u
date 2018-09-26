<?php
include('auth.php');
require_once('include/include-head.php');
require_once('include/include-main.php');
require_once('proc/config.php');

/*require_once('css/styles.css'); This is only set just to automatically see immediately the file :D */
$personnels=array();
$sql = "SELECT * FROM tbl_personnel ORDER BY FullName ASC";
$result = mysql_query($sql) or die(mysql_error());
if(mysql_num_rows($result) > 0){
    while($row=mysql_fetch_assoc($result)){
        $personnels[]=$row;      
    }
}

    if(date('d') > 15)
    {
        $from = date('Y-m-15');
        $to = date('Y-m-t');
    }
    else
    {
        $from = date('Y-m-01');
        $to = date('Y-m-15');
    }

?>
<style type="text/css">
    #records tr td {
        border: none;
    }

    #personnelTable tr td {
        border: none;
    }
</style>

<!--<link href="dist/bootstrap/css/bootstrap.min.css" rel="stylesheet">-->
<div class="col col-md-12">
<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                <span style="font-size:x-large;font-weight:bold;">BIOMETRICS DATA</span>
            </div>
        </div>

        <div class="panel-body">
                <div class="col col-md-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">&nbsp;</div>
                        <div class="panel-body" style="height: 720px;">
                            <input type="text" name="search" placeholder="SEARCH BY NAME OR ACCESS ID" class="form-control" id="txtsearch">
                            <br/>
                            <div style="height: 420px;overflow-x: auto;border: 1px solid black;" >
                                <table class="table table-bordered table-hover table-condensed" id="personnelTable">
                                    
                                        <?php foreach($personnels as $person) :?>
                                            <tr id="person_<?php echo $person['EntryID'];?>" class="personData">
                                               <td width="10%"><input type="radio" name="rdbName" class="form-control" style="width: 15pt;height: 15pt;" value="<?php echo $person['EntryID'];?>"></td>
                                        <td><?php echo strtoupper($person['FullName']);?></td>
                                        </tr>
                                        <?php endforeach ?>
                                    
                                </table>
                            </div>
                             <br/>
                             <table class="table">
                                <tr>
                                    <td><strong>DATE FROM:</strong><input type="date" name="datefrom" class="form-control" id="datefrom" value="<?php echo $from;?>"></td>
                                </tr>
                                <tr>
                                    <td><strong>DATE TO:</strong><input type="date" name="dateto" class="form-control" id="dateto" value="<?php echo $to;?>"></td>
                                </tr>
                                <tr>
                                    <td><button class="btn btn-primary form-control" id="generate"><span>GENERATE</span></button></td>
                                </tr>
                            </table>
                           
                        </div>
                    </div>
                </div>

                <div class="col col-md-9">
                    <div class="panel panel-primary">
                        <div class="panel-heading"> 
                          <button type="button" id="printexcel" class="btn btn-success pull-right btn-xs"><span class="fa fa-file-excel-o"></span> Download Excel</button>&nbsp;</div>
                        <div class="panel-body" style="height: 720px;overflow-x: auto;">
                          <div id="individual_Report">
                            <table class="table table-bordered" id="personnelDetails" style="border: none;">
                               
                            </table>
                            <br/>
                            <table class="table" id="records">
                                <thead>
                                    <tr id="header">
                                      
                                    </tr>
                                </thead>
                                <tbody id="contentRecord">

                                </tbody>
                            </table>
                          </div>
                        </div>
                    </div>
                </div>


        </div>
    </div>
</div>
</div>



<div class="modal fade" role="dialog" id="ApprovedModal">
  <div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-header" style="background-color: green"></div>
    <div class="modal-body">
        <h3>APPROVED THIS OT?<h3>
          <span id="approvedIDno" class="hidden"></span>
    </div>
    <div class="modal-footer">
      <button class="btn btn-primary" type="button" id="approvedOT">YES</button>
      <button class="btn btn-danger" type="button" id="not_approvedOT">NO</button>
      <button class="btn btn-default" type="button" id="hideModal">CLOSE</button>
    </div>
  </div>
</div>
</div>


<script src="js/script_Reports.js"></script>

<script>
    $(document).on('click','#generate',function(){
         // var personnel = $('input[name=rdbName]:checked').map(function(){return this.value;}).get().join(",");
        GenerateReport();
    })


    function GenerateReport(){
        var personnel = $('input[name=rdbName]:checked').map(function(){return this.value;}).get();
        var datefrom = $('#datefrom').val();
        var dateto = $('#dateto').val();

        if(personnel.length==0){
             alert("Please select personnel");
        }else{
            $.ajax({
                url : 'function/generate_bioReport.php',
                type: 'POST',
                data: '&personnel='+personnel+'&datefrom='+datefrom+'&dateto='+dateto,
                success: function(x){
                    var data=JSON.parse(x);
                      $('#contentRecord').html(data[0]);
                      $('#personnelDetails').html(data[1]);
                      $('#header').html("<th style='text-align:center'>DATE</th>"+
                                      "<th style='text-align:center'>DAY</th>"+
                                      "<th style='text-align:center'>TIME IN</th>"+
                                      "<th style='text-align:center'>TIME OUT</th>"+
                                      "<th style='text-align:center'>OVERTIME</th>"+
                                      "<th style='text-align:center'>LATE</th>"+
                                      "<th style='text-align:center'>EXCESS TIME</th>"+
                                      "<th style='text-align:center'>APPROVED</th>"+
                                      "<th style='text-align:center'></th>");

                }
            }) 
        }
    }

    $(document).on('keyup','#txtsearch',function(){
       if($('#txtsearch').val()==""){
            $('.personData').removeClass('hidden');
         // $('input:radio').prop('checked',this.checked);
       }else{
            $('.personData').addClass('hidden');
            $.ajax({
                url: 'function/search_bio.php',
                type: 'POST',
                data: '&personnel='+$('#txtsearch').val(),
                success:function(x){
                    var data = JSON.parse(x);
                    var count = data.length;
                    for(x=0;x<count;x++){
                        $('#person_'+data[x]['EntryID']).removeClass('hidden');
                    }
                }
            })
       }
    })


    $(document).on('click','.approvedButton',function(){
        var idno = $(this).data('idno');
        $('#approvedIDno').text(idno);
       $("#ApprovedModal").modal('show');
    });

    $(document).on('click','#hideModal',function(){
      $("#ApprovedModal").modal('hide');
    })

    $(document).on('click','#approvedOT',function(){
      var idno = $('#approvedIDno').text();
      ApprovedOT(idno,"YES");
     
    });

    $(document).on('click','#not_approvedOT',function(){
      var idno = $('#approvedIDno').text();
      ApprovedOT(idno,"NO");
    });


    function ApprovedOT(idno,status){

      $.ajax({
        url: 'function/ApprovedOT.php',
        type: 'POST',
        data: '&idno='+idno+'&status='+status,
        success:function(x){
            GenerateReport();
            $("#ApprovedModal").modal('hide');
        }
      });
    }


    $("#printexcel").click(function(e) {

  e.preventDefault();
  var datenow = "<?php echo date('mdY',time());?>";
  //getting data from our table
  var data_type = 'data:application/vnd.ms-excel';
  var table_div = document.getElementById('individual_Report');
  table_div.removeAttribute("style")
  var table_html = table_div.outerHTML.replace(/ /g, '%20');
  
  var a = document.createElement('a');
  a.href = data_type + ', ' + table_html;
  a.download = datenow+'_Individual_Report.xls';
  a.click();

});


</script>

