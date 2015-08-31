<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
	

	$_lon1 = getQUERY("lon1");
	$_lat1 = getQUERY("lat1");
	$_lon2 = getQUERY("lon2");
	$_lat2 = getQUERY("lat2");
    
    
    // Dim _lon1 As String = "21.424884"
    // Dim _lat1 As String = "41.995976"
    // Dim _lon2 As String = "21.42207"
    // Dim _lat2 As String = "42.002685"
    
    
	print getLineCoordsF1($_lon1, $_lat1, $_lon2, $_lat2);
    
?>
