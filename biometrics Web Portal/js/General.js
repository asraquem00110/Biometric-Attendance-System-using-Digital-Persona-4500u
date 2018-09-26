$(document).ready(function(){
	$('.confirmation-popout').confirmation({
		onConfirm: function (event, element) {	
			event.preventDefault();
			$.ajax({
				type:'POST',
				url:'function/func_DeletePerson.php',
				data:{id:10},
				success:function(response){
					if(response.url){
						window.location.href = response.url;
					}
				}
			})	
		}
	});		
})