<?php
  session_start();
  $_SESSION['LAST_ACTIVITY'] = time();
  
  if(@(isset($_SESSION['SESS_USER_ID']) || !(trim($_SESSION['SESS_USER_ID']) == ''))){
    header("location: report_menu.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>BIOMETRICS</title>
   <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
  </head>

  <body style="z-index: -1;">
    <div class="container" style="margin-top: 30pt;">
	
        <div class="login-panel panel panel-default col-md-4 col-md-offset-4">
		
            <div class="panel-body">
           

          <h1 align="center"><strong>BIOMETRICS</strong></h1>

            <form class="form-signin text-center" method="post" role="form">
              <h2 class="form-signin-heading">Please sign in</h2>

              <div id="page-alert" class="alert alert-danger" data-alert="alert">
                <span id="page-alert-message"></span>
              </div>

                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input type="text" class="form-control" name="username" placeholder="Username"  autofocus>
                  <span class="span-user-error"></span>
                </div>
                <br/>
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input type="password" class="form-control" name="password" placeholder="Password" >
                  <span class="span-passowrd-error"></span>
                </div>
                <br/>
              <button class="form-btn btn btn-lg btn-primary btn-block" type="button">Sign in</button>
            </form>

            <p class="text-center">Don't have account? Please contact your admin.</p>

          </div>
        </div>
    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="js/access.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        // $.backstretch("assets/img/bg.jpg", {speed: 500});
         $.backstretch("assets/img/.jpg", {speed: 500});
    </script>
  </body>
</html>
