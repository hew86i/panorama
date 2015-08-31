<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
    
    header("Expires: Mon, 20 Jul 2000 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", FALSE);
    header("Pragma: no-cache");
	set_time_limit(0);
	
    $_lon1 = str_replace("'", "''", NNull($_GET['lon1'], ''));
    $_lat1 = str_replace("'", "''", NNull($_GET['lat1'], ''));
    $_lon2 = str_replace("'", "''", NNull($_GET['lon2'], ''));
    $_lat2 = str_replace("'", "''", NNull($_GET['lat2'], ''));
    
    /*$_lon1 = "21.424884";
    $_lat1 = "41.995976";
    $_lon2 = "21.42207";
    $_lat2 = "42.002685";*/
    
    $lonlat = getLineCoords($_lon1, $_lat1, $_lon2, $_lat2);
    print $lonlat;
    //Response.Write("&nbsp;")
    
?>
