
//########## DOC READY ##################
$(document).ready(function(e) {
	BuildChosen();
    webcam.set_api_url('function/func_Uploader.php');
    webcam.set_quality(100); // JPEG quality (1 - 100)
    webcam.set_shutter_sound( true ); // play shutter click sound
    $('#my_camera').html(webcam.get_html(240, 240,240,240));
});

//########## END OF DOC READY ###########

webcam.set_hook( 'onComplete', 'my_callback_function' );
    function my_callback_function(response) {
        //alert("Success! PHP returned: " + response);
		var xCamImg = new Image;
		xCamImg.onload = function(){
			 $('#picImg').attr('src', this.src);
			 $('#myimg').val($('#picImg').attr('src'));
		}
		xCamImg.src =response;
	}
	
function BuildChosen(){
	$("#cmbAccessArea,#cmbSchedule").chosen({
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
		
	/*	var config = {
		'.chosen-select'           : {},
		'.chosen-select-deselect'  : {allow_single_deselect:true},
		'.chosen-select-no-single' : {disable_search_threshold:10},
		'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		'.chosen-select-width'     : {width:"95%"}
	}
	for (var selector in config) {
		$(selector).chosen(config[selector]);
	}*/
	
	$(".chosen-search input").change(function(){
	  $('.chosen').append("<option value='"+this.value+"'>"+this.value+"</option>");
	  $('.chosen').val(this.value); // if you want it to be automatically selected
	  $('.chosen').trigger("chosen:updated");
	});
};

$("#txtVisitType").change(function(){$('#txtAccessType').val(this.value);});
	

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

//########## END OF DOC READY ###########

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

var xImgFile='';
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#picImg').attr('src', e.target.result);
			$('#myimg').val($('#picImg').attr('src'));
			xImgFile=document.getElementById('imgload').files[0]['name'];
			$('#picImg1').val($('#txtLastID').val()+xImgFile.substring((xImgFile.indexOf('.')-1),xImgFile.length))
        }
        reader.readAsDataURL(input.files[0]);
    }
};



