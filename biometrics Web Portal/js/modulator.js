function DateDiff_In_Days(Date1,Date2){
var date1 = new Date(Date1);
var date2 = new Date(Date2);
var timeDiff = date2.getTime() - date1.getTime();
var diff = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
return diff;	
}

function DateDiff_In_Hours(Date1,Date2){
var date1 = new Date(Date1);
var date2 = new Date(Date2);
var timeDiff = date2.getHours() - date1.getHours();
var diff = Math.abs(timeDiff); 
return diff;	
}

function DateDiff_In_Minutes(Date1,Date2){
var date1 = new Date(Date1);
var date2 = new Date(Date2);
var timeDiff = date2.getMinutes() - date1.getMinutes();
var diff = Math.abs(timeDiff); 
return diff;	
}

function pad(pad, str, padLeft) {
  if (typeof str === 'undefined') 
    return pad;
  if (padLeft) {
    return (pad + str).slice(-pad.length);
  } else {
    return (str + pad).substring(0, pad.length);
  }
}

function DateDiff_In_Seconds(Date1,Date2){
var date1 = new Date(Date1);
var date2 = new Date(Date2);
var timeDiff = date2.getSeconds() - date1.getSeconds();
var diff = Math.abs(timeDiff); 
return diff;	
}

function ajaxindicatorstart(){
		if($('#resultLoading').attr('id') != 'resultLoading'){
		jQuery('body').append('<div id = "resultLoading" class="loader">'+
		'<div class = "loader-container">'+
		'<svg class="circular" viewBox="25 25 50 50">'+
		'<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>'+
		'</svg>LOADING PLEASE WAIT...</div><div class="bg"></div></div>');
		
		jQuery('#resultLoading .bg').height('100%');
        jQuery('#resultLoading').fadeIn(300);
	    jQuery('body').css('cursor', 'wait');
		} 
}
	
function ajaxindicatorstop(){
	    jQuery('#resultLoading .bg').height('100%');
        jQuery('#resultLoading').fadeOut(300);
	    jQuery('body').css('cursor', 'default');
		$('#resultLoading').remove();
}