<?php

include('proc/config.php');

if(isset($_GET['image'])){
	$image = clean($_GET['image']);
}else{
	$image = "default.png";
}
?>

<img src="images/imgBank/<?php echo $image;?>" width="100%" height="100%"/>
