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
	opendb();
	$sqlV = "";
    if(session("role_id") == "2")
        $sqlV = "select id from draft.dbo.vehicles where clientID=" . session("client_id");
	else
        $sqlV = "select vehicleID from draft.dbo.UserVehicles where userID=" . session("user_id") . "";

    $dsv = query("select numberofvehicle, id from vehicles where id in (" . $sqlV . ") order by numberofvehicle");
    
    
    $str = "";
    while ($row = odbc_fetch_array($dsv)){
    	$str .= "@" . $row["numberofvehicle"] . ":";
    	
    	$ds = query("exec geonet_wh.dbo.getLast10Position " . $row["id"]);
	
		while ($row1 = odbc_fetch_array($ds)){
			 $str .= odbc_result($ds, 1) . "#" . odbc_result($ds, 2);
		}
    }
	//print $str;
    print base64_encode(gzencode($str));
	closedb();
?>