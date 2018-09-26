$(document).ready(function() {

    //ALERT
    $("#page-alert").hide();

    //show alert
    function showAlert(){
        $("#page-alert").fadeIn("slow");
    }

    $('.form-btn').click(function(){

        var errorMessage = "";
        var errFlag = "";

        if($('input[name=username]').val() == "" || $('input[name=password]').val() == ""){
            
            if($('input[name=username]').val() == ""){
                errFlag = 1;
            }

            if($('input[name=password]').val() == ""){
                errFlag = 2;
            }

            switch(errFlag) {
                case 1:
                    errorMessage = "Username is required.";
                    break;
                case 2:
                    errorMessage = "Password is required.";
                    break;
                default:
                    errorMessage = "Username and password is required.";
            } 

            
            $('#page-alert-message').html(errorMessage);
            showAlert();
        }else{
            
            //ajax to send datas
            $.ajax({
              type: 'POST',
              url: 'proc/process-login-users.php',
              data: $('.form-signin').serialize(),
              success: function(msg){
                if(msg==1){
                    window.location.href = "report_menu.php"; 
                }else{
                    $('#page-alert-message').html("Wrong username and password combination!");
                    showAlert();
                }   
            },
            error: function(){
              alert('wrong');
            }
          });//end ajax


        }
            
    
    });

});