<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
    
    header("Expires: Mon, 20 Jul 2000 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", FALSE);
    header("Pragma: no-cache");
	set_time_limit(0);
	opendb();

	$lat = str_replace("'", "''", NNull($_GET['lat'], ''));
	$lon = str_replace("'", "''", NNull($_GET['lon'], ''));
	
	//echo "select getGeocode(" . $lat . "," . $lon . ") geocode";
	$temp = query("select getGeocode('" . $lat . "','" . $lon . "') geocode");
	
	echo pg_fetch_result($temp, 0, "geocode");
	
  	closedb();  
	
?>
