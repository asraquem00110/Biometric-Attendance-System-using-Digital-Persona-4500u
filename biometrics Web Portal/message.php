<?php
	if(isset($_SESSION['success-message'])){
		?>
        <div id="MsgAlert" class="alert alert-dismissible alert-success dontprintme alert-sm" style = "text-align:center;display:none;">
        	<button type="button" class="close" data-dismiss="alert">×</button>
        	<?php echo $_SESSION['success-message']?>
        </div>

		<?php
		$_SESSION['success-message'] = null;
	}
	
	if(isset($_SESSION['notify-message'])){
		?>
        <div id="MsgAlert" class="alert alert-dismissible alert-info dontprintme alert-sm" style = "text-align:center;display:none;">
        	<button type="button" class="close" data-dismiss="alert">×</button>
        	<?php echo $_SESSION['notify-message']?>
        </div>

		<?php
		$_SESSION['notify-message'] = null;
	}

	
	if(isset($_SESSION['error-message'])){
		?> 

        <div id="MsgAlert" class="alert alert-dismissible alert-danger dontprintme" style = "text-align:center;display:none;">
        	<button type="button" class="close" data-dismiss="alert">×</button>
			<?php echo $_SESSION['error-message']?>
        </div>        

<?php
		$_SESSION['error-message'] = null;
	}
	
	if(isset($_SESSION['error-message2'])){
		?> 

        <div id="MsgAlert" class="alert alert-lg alert-dismissible alert-danger dontprintme text-center" style = "display:none;">
        	<button type="button" class="close" data-dismiss="alert">×</button>
			<h3><?php echo $_SESSION['error-message2']?></h3>
        </div>        

<?php
		$_SESSION['error-message2'] = null;
	}	
	

	