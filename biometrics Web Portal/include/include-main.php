
<nav class="navbar navbar-inverse navbar-fixed-top dontprintme" role="navigation">
	      <div class="container-fluid">

			<!--Logo-->
			<div class = "navbar-header">
				<button type = "button" class = "navbar-toggle" data-toggle = "collapse" data-target = ".navbar-collapse">
					<span class = "icon-bar"></span>
					<span class = "icon-bar"></span>
					<span class = "icon-bar"></span>
				</button>


			<a class="navbar-brand" href="report_menu.php">&nbsp; BIOMETRICS ACCESS SYSTEM</a>
			</div>
            <form action="" method="post" id="frmNav">
            <div class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
			    <?php
				if($_SESSION['ACCESSLEVEL']=='Admin') {

					echo '<li><a href="pg_accounts.php" title="See data logs."><i class="nav-icons fa fa-users"></i>Accounts</a></li>';

					  echo '<li><a href="report_menu.php" title="See data logs."><i class="nav-icons fa fa-list"></i>Reports</a></li>';
					  echo '<li><a href="pg_settings.php"><i class="nav-icons fa fa-cog"></i>Settings</a></li>';
 	                  echo "<li><a href=\"logout.php\" style='cursor:pointer' onClick=$('#frmNav').submit();><i class='nav-icons fa fa-sign-out'></i>Logout</a></li>";
				 } else {
					echo '<li><a style="cursor:pointer" data-toggle="modal" data-target="#login-modal"><i class="nav-icons fa fa-sign-in"></i>Login</a></li>';
				 }
				?>
                <input type="hidden" name='LOGOUT' id="btnLogout" />
	          </ul>
	        </div>
            </form>
	      </div>
</nav>
<body style="height:100%;">
<div class="container-fluid">
<div class="row">
<br>
