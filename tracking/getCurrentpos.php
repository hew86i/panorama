<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	if (session('user_id') == "261") echo header( 'Location: ../sessionexpired/?l='.$cLang);
	if (!is_numeric(session('user_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
 	header("Expires: Mon, 20 Jul 2000 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", FALSE);
    header("Pragma: no-cache");
	set_time_limit(0);
	$str = "";
	opendb();
	
	if (session("role_id")."" == "2"){
		$str .= dlookup("select getcurrentposition(" . session("user_id") . ", 'select id from vehicles where clientid = " . session("client_id") . "', 'select tourid, vehicleid, vozilo, timein, timeout, diff, poiid, rbr1 from gettoursbycid(" . session("client_id") . ")')");
	} else {
		$str .= dlookup("select getcurrentposition(" . session("user_id") . ", 'select vehicleid from uservehicles where userid=" . session("user_id") . "', 'select tourid, vehicleid, vozilo, timein, timeout, diff, poiid, rbr1 from gettoursbyuid(" . session("user_id") . ")')");
	}

	
	print $str;
	closedb();
	
?>