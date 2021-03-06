﻿<?php include "../include/functions.php" ?>
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
    
	if (!is_numeric(session('user_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
	if (!is_numeric(session('client_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
    
    $name = str_replace("'", "''", NNull($_GET['name'], ''));
	
    //$str3 = " and (ca.userid in (select id from users where organisationid in (select organisationid from users where id=" . session("user_id") . ")) or ca.userid=" . session("user_id") . " or ca.available = 3)";
    //echo "select ca.id, ppg.fillcolor color from pointsofinterest ca left outer join pointsofinterestgroups ppg on ca.groupid=ppg.id where ca.type=2 and ca.clientid=" . session("client_id") . " and lower(ca.name) LIKE lower('%".$name."%')";
	//exit;
    $dsv = query("select ca.id, ppg.fillcolor color from pointsofinterest ca left outer join pointsofinterestgroups ppg on ca.groupid=ppg.id where ca.type=2 and ca.clientid=" . session("client_id") . " and lower(ca.name) LIKE lower('%".$name."%')");
    
    $str = "";
    while($row = pg_fetch_array($dsv))
	{
        $str .= "@" . $row["id"] . "|" . $row["color"];
    }
    if($str == "")
        $str = "#^*";

	echo $str;
    //print base64_encode(gzencode($str));
	closedb();
?>