<?php
   define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', 'biometrics');
	date_default_timezone_set('Asia/Taipei');
	$CurTime = date('Y-m-d H:i:s');
    $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
     

    if(!$link){
        die('Failed to connect to server: ' . mysql_error());
    }
  
    //Select database
    $db = mysql_select_db(DB_DATABASE);
    
	if(!$db){
        die("Unable to select database");
    }
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}


function getDateRange($startDate, $endDate, $format="Y-m-d")
{
	//Create output variable
	$datesArray = array();
	//Calculate date range
	$total_days = round(abs(strtotime($endDate) - strtotime($startDate)) / 86400, 0) + 1;
	if($total_days<0) { return false; }
	//Populate array of weekdays and counts
	for($day=0; $day<$total_days; $day++)
	{
		$datesArray[] = date($format, strtotime("{$startDate} + {$day} days"));
	}
	//Return results array
	return $datesArray;
}


?>