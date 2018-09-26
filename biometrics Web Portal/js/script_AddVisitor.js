var xStartToggle=0;
var xEndToggle=0;
//########## DOC READY ##################
$(document).ready(function(e) {
	BuildChosen();
    $('#time-loading').html(moment().format('LL LTS'));
	setInterval(DisplayCurrentTime,1000); // Ensure your page has included moment.js unless will not work :D

    webcam.set_api_url('function/func_Uploader.php');
    webcam.set_quality(100); // JPEG quality (1 - 100)
    webcam.set_shutter_sound( true ); // play shutter click sound
    $('#my_camera').html(webcam.get_html(240, 240,240,240));
	xStartToggle=moment().format('s');
	$('#cmbAccessArea').chosen({});
	$(".chosen-container,.chosen_body").css('width','100%');
	$(".chosen-select").attr("select","ALL");
	$('select').css('width','30%');
	$.ajax({
		type:'POST',
		url:'function/func_DisplayExpected.php',
		success:function(x){
			$('#tbody_Expected').html(x.Display);
		}
	});
/*	$.ajax({
		type:'post',
		url:'function/func_CheckVIP.php',
		success:function(x){
			//$('#chkSpecialApproved')
		}
	});*/

});

//########## END OF DOC READY ###########

$('#btnCreate').click(function(e){
  var xVIS_ID = $('#txtLastID1').val();
  var xVIS_AccessID = $('#txtVIS_AccessID').val();
  var xVIS_FirstName = $('#txtVIS_FirstName').val();
  var xVIS_MiddleName = $('#txtVIS_MiddleName').val();
  var xVIS_LastName = $('#txtVIS_LastName').val();
  var xVIS_VisitorType = $('#txtVIS_VisitType').val();
  var xVIS_Address = $('#txtVIS_Address').val();
  var xVIS_ContactNo = $('#txtVIS_ContactNo').val();
  var xVIS_ContactPerson = $('#txtVIS_ContactPerson').val();
  var xVIS_AccessArea = $('#cmbAccessArea2').val();
  var xVIS_ValidID = $('#txtVIS_ValidID').val();
  var xVIS_Purpose = $('#txtVIS_Purpose').val();
  var xVIS_DateVisit = $('#txtVIS_VisitDate').val();
  var xVIS_TimeVisit = $('#txtVIS_VisitTime').val();
  var xVIS_DateVisitEnd = $('#txtVIS_VisitDate_End').val();
  var xVIS_TimeVisitEnd = $('#txtVIS_VisitTime_End').val();
  if($('#chkApproved').is(":checked")){
	xVIS_Approval = 1 ;
  }else{
    xVIS_Approval = 0 ;
  }


  $.ajax({
	 	type:'post',
		url:'function/func_AddVisitor_new.php',
		data:'&xVIS_ID='+xVIS_ID+'&xVIS_AccessID='+xVIS_AccessID
		+'&xVIS_FirstName='+xVIS_FirstName+'&xVIS_MiddleName='+xVIS_MiddleName
		+'&xVIS_LastName='+xVIS_LastName+'&xVIS_VisitorType='+xVIS_VisitorType
		+'&xVIS_Address='+xVIS_Address+'&xVIS_ContactNo='+xVIS_ContactNo
		+'&xVIS_ContactPerson='+xVIS_ContactPerson+'&xVIS_AccessArea='+xVIS_AccessArea+'&xVIS_ValidID='+xVIS_ValidID
		+'&xVIS_Purpose='+xVIS_Purpose+'&xVIS_DateVisit='+xVIS_DateVisit+'&xVIS_TimeVisit='+xVIS_TimeVisit+'&xVIS_DateVisitEnd='+xVIS_DateVisitEnd
		+'&xVIS_TimeVisitEnd='+xVIS_TimeVisitEnd+'&xVIS_Approval='+xVIS_Approval,
		success:function(response){

		}
  });
// e.preventDefault();

});


function BuildChosen(){

	$("#cmbAccessArea2").chosen({
		width:'100%',
		no_results_text: 'Invalid Text',
		single_backstroke_delete:false
	});

	$("#txtVisitType").chosen({
		width:'100%',
		create_option:true,
		persistent_create_option:true,
		skip_no_results:true,
		create_option_text:'etc..',
		no_results_text: 'etc...',
		disable_search:true
	});

	$(".chosen-search input").change(function(){
	  $('.chosen').append("<option value='"+this.value+"'>"+this.value+"</option>");
	  $('.chosen').val(this.value); // if you want it to be automatically selected
	  $('.chosen').trigger("chosen:updated");
	});




};

$("#txtVisitType").change(function(){$('#txtAccessType').val(this.value);});

		/*$('#registration-modal').on('hidden.bs.modal', function () {
     $('.chosen').chosen('destroy');
	 BuildChosen();
});*/

webcam.set_hook( 'onComplete', 'my_callback_function' );
    function my_callback_function(response) {
        //alert("Success! PHP returned: " + response);
		var xCamImg = new Image;
		xCamImg.onload = function(){
			 $('#picImg').attr('src', this.src);
		}
		xCamImg.src =response;
	}

function DisplayCurrentTime(){
	$('#time-loading').html(moment().format('LL LTS'));
	xEndToggle = parseInt(moment().format('s'));
	if(Math.abs((xStartToggle-xEndToggle))>=30){$('#chkInOut').prop('checked',true).change();}
}



function ToggleCamera(Btn){
	if($('input[type="checkbox"]').prop('checked')==false){
	$('#btnCam').removeAttr('disabled');
	$('#my_camera').show(2500);
	$('#btnCam').attr('onClick',"webcam.snap();");
	} else {
	$('#my_camera').hide('slow');
	$('#btnCam').attr('onClick',"OpenFileDiag()");
	}
}

var xDataMulti;
function GetList(obj){
	xDataMulti = $(obj).val();
	if(xDataMulti!=null){
	xDataMulti = xDataMulti.join();
	$('#txtAccessArea').val(xDataMulti);
	}
};



function OpenFileDiag(){
$('#imgload').click();
};

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#picImg').attr('src', e.target.result);

        }
        reader.readAsDataURL(input.files[0]);
    }
};

var xFileName='';
function AddVisitor(){
	event.preventDefault();
	if(document.getElementById('imgload').files.length>0){
	 xFileName =document.getElementById('imgload').files[0]['name'];
     xFileName = xFileName.substring(xFileName.length-4,xFileName.length);
	} else {
	  xFileName = ".png";
	}
	$('#picImg1').val('VST_'+$('#txtLastID').val()+xFileName);
	$.ajax({
		type:'POST',
		url:'function/func_AddVisitor.php',
		data:$('#frmRegister').serialize()+'&myimg='+$('#picImg').attr('src'),
		success:function(response){
		$('#txtID').val(response.ID);
		$('#frmReceipt').submit();
		//window.location.href = response['url'];
		}

	})
};


function ReplenishPass(){
	var xLastID = $('#txtLastID').val();
	var xNewID = $('#txtNextID').val();
	var xTargetID = $('#txtTargetID').val();
	var xNewDateTimeVisit = $('#txtVIS_VisitDate_Rep').val() +' '+$('#txtVIS_VisitTime_Rep').val();
	var xNewDateTimeVisitEnd = $('#txtVIS_VisitDate_End_Rep').val() +' '+$('#txtVIS_VisitTime_End_Rep').val();
	$.ajax({
		type:'post',
		url:'function/func_ReplenishAccess.php',
		data:'&LastID='+xLastID+'&NewID='+xNewID+'&xTargetID='+xTargetID+'&DateStart='+xNewDateTimeVisit+'&DateEnd='+xNewDateTimeVisitEnd,
		success:function(x){

		}
	});
}
/*
$('#btnSubmit').on('click',function(e){
	var xLastID = $('#txtLastID').val();
	var xNewID = $('#txtNextID').val();
	var xNewDateTimeVisit = $('#txtVIS_VisitDate_Rep').val() +' '+$('#txtVIS_VisitTime_Rep').val();
	var xNewDateTimeVisitEnd = $('#txtVIS_VisitDate_End_Rep').val() +' '+$('#txtVIS_VisitTime_End_Rep').val();

	$.ajax({
		type:'post',
		url:'function/func_ReplenishAccess.php',
		data:'&LastID='+xLastID+'&NewID='+xNewID+'&DateStart='+xNewDateTimeVisit+'&DateEnd='+xNewDateTimeVisitEnd,
		success:function(x){

		}
	});
});*/

//##############################
// ACCESS SEQUENCE - OPERATION
//##############################
function SubmitForm(){
	$('#frmExpected').submit();
}
$('#txtEnterID').on('keyup',function(e){
var xTargetAccess ='';
 if(e.keyCode==13 && this.value!=''){
	 var xID = this.value;
	 $('#txtTargetID').val(this.value);
	 $.ajax({
		 type:'post',
		 url:'function/func_GetAccess.php',
		 data:'&xTargetID='+$('#txtTargetID').val(),
		 success:function(x){
			 // e.preventDefault();
			 xTargetAccess = x.Display;
		 }

	 });
	 $.ajax({
		type:'POST',
		url:'function/func_CheckVisitorID.php',
		data:'&ID='+xID+'&Access='+xTargetAccess+'&ChkIn='+$('#chkInOut').prop('checked'),
		success:function(result){
			// e.preventDefault();
			switch (parseInt(result.resFlag)){
			case 0:
			case 1:

				xSelectedID = $('#txtEnterID').val();
				$('#frmInfo').hide();
				$('#MainTable').hide();
				$('#mainImg').hide();
				$('#txtEnterID').val('');
				$('#Display').html('');
				$('#Display').append(result.res);
				$('#lblTimeIN').html(result.TimeIN);
				$('#lblTimeOUT').html(result.TimeOUT);
				$('#mainImg').attr('src',"images/imgBank/"+result.Img);
				$('#frmInfo').fadeIn();
				$('#MainTable').fadeIn();
				$('#mainImg').fadeIn();
				// $('#btnEdit').fadeIn();

				if(parseInt(result.resFlag)==1){
					$('#VstTitle').removeClass('panel-primary').addClass('panel-danger');
					$('#VstTitle .panel-title>span').html('VISITOR INFORMATION - Invalid Access!');
				} else {
					if($('#VstTitle').hasClass('panel-danger')){$('#VstTitle').removeClass('panel-danger').addClass('panel-primary');}
					$('#VstTitle .panel-title>span').html('VISITOR INFORMATION');
				}
				window.history.replaceState('','',window.location.pathname);
			break;
						 default:
				window.location.href = "pg_visitors.php?Retry="+parseInt(result.resFlag);
			}
		}
	});

	$.ajax({
		type:'POST',
		url:'function/func_DisplayExpected.php',
		success:function(x){
			//$('#frmExpected').submit();
				$('#tbody_Expected').html(x.Display);
		}
	});
	$.ajax({
		type:'POST',
		url:'function/func_CheckVisitorExp.php',
		data:'&ID='+this.value,
		success:function(x){
			switch (parseInt(x.ResFlag)){
			case 0:
				$('#ExprDisplay').addClass('hidden');
				$('#btnRep').addClass('hidden');
				break;
			case 1:

				xSelectedID = $('#txtEnterID').val();

				$('#ID').val(xSelectedID);
				$('#frmInfo').hide();
				$('#MainTable').hide();
				$('#mainImg').hide();
				$('#txtEnterID').val('');
				$('#VstTitle').removeClass('panel-primary');
				$('#VstTitle').addClass('panel-danger');
				$('#ExprDisplay').removeClass('hidden');
				$('#frmInfo').fadeIn();
				$('#MainTable').fadeIn();
				$('#mainImg').fadeIn();
				// $('#btnEdit').fadeIn();
				$('#btnRep').removeClass('hidden');

				$('#VstTitle.panel-title>span').html('VISITOR INFORMATION - Invalid Access!');
				window.history.replaceState('','',window.location.pathname);
				break;
				default:
				window.location.href = "pg_visitors.php?Retry="+parseInt(result.resFlag);
			}
		}
	});

 }
});
