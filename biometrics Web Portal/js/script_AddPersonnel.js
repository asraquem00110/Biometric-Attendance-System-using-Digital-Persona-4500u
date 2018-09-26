var xSelectedID='';
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
	$('#txtEnterID').focus();
});

//########## END OF DOC READY ###########

function BuildChosen(){
	$("#cmbAccessArea").chosen({
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
function AddEmployee(){
	event.preventDefault();
	if(document.getElementById('imgload').files.length>0){
	 xFileName =document.getElementById('imgload').files[0]['name'];
     xFileName = xFileName.substring(xFileName.length-4,xFileName.length);
	} else {
	  xFileName = ".png";
	}

	$('#picImg1').val($('#txtLastID').val()+xFileName);
	$.ajax({
		type:'POST',
		url:'function/func_AddPersonnel.php',
		data:$('#frmRegister').serialize()+'&myimg='+$('#picImg').attr('src'),
		success:function(response){
		window.location.href = response['url'];
		}

	})
};

function CheckID(){
	$.ajax({
		type:'POST',
		url:'function/func_CheckPersonnelID.php',
		data:'&ID='+$('#txtEnterID').val()+'&Access='+xCurrentAccess+'&Password='+$('#txtPassword').val()+'&ChkIn='+$('#chkInOut').prop('checked'),
		success:function(result){
			// e.preventDefault();
			switch (parseInt(result.resFlag)){
			case 0:
			case 1:
			case 4:
				xSelectedID = $('#txtEnterID').val();
				$('#ID').val(xSelectedID);
				$('#frmInfo').hide();
				$('#MainTable').hide();
				$('#mainImg').hide();
				$('#txtEnterID').val('');
				$('#txtPassword').val('');
				$('#Display').html('');
	            $('#Display').append(result.res);
				$('#lblTimeIN').html(result.TimeIN);
				$('#lblTimeOUT').html(result.TimeOUT);
				$('#mainImg').attr('src',"images/imgBank/"+result.Img);
				$('#frmInfo').fadeIn();
				$('#MainTable').fadeIn();
				$('#mainImg').fadeIn();
				$('#btnEdit').fadeIn();
				//$('#lblRegistration').hide();
				if(parseInt(result.resFlag)==4){
				// if(parseInt(result.resFlag)==4 || parseInt(result.resFlag)==1){
				$('#EmpTitle').removeClass('panel-primary').addClass('panel-danger');
				$('#EmpTitle .panel-title>span').html('PERSONNEL INFORMATION - Invalid Access!');
				} else {
				if($('#EmpTitle').hasClass('panel-danger')){$('#EmpTitle').removeClass('panel-danger').addClass('panel-primary');}
				$('#EmpTitle .panel-title>span').html('PERSONNEL INFORMATION');
				}
				window.history.replaceState('','',window.location.pathname);
			break;
            default:
				window.location.href = "pg_employees.php?Retry="+parseInt(result.resFlag);
			}
		}
	});
}

$('#txtEnterID').on('keyup',function(e){
 if(e.keyCode==13){	CheckID(); }
});

$('#txtPassword').on('keyup',function(e){
 if(e.keyCode==13){	CheckID(); }
});
