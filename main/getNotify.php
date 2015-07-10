<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
	$tpoint = getQUERY("tpoint");
	if (session('user_id') == "261") echo header( 'Location: ' . $tpoint . '/sessionexpired/?l='.$cLang);
	set_time_limit(0);
	opendb();
	$sqlV = "";
	if (session("role_id")."" == "2"){
		$sqlV = "select id from vehicles where clientid=".session("client_id");
	} else {
		$sqlV = "select vehicleid from uservehicles where userid=".session("user_id"); 
	}
	$sql_ = "";
	$sql_ .= 'select cast(v.code as integer), v.registration, cp."DateTime", cp.alarm, cp.vehicleid ';
	$sql_ .= "from currentposition cp ";
	$sql_ .= "left outer join vehicles v on v.id=cp.vehicleid ";
	$sql_ .= "where vehicleid in (" . $sqlV . ") order by cast(v.code as integer) asc";
	$ds = query($sql_);
	$str = "";
	while($row = pg_fetch_array($ds))
	{
		$alarm = $row["alarm"];
		//if($row["vehicleid"] == "2061")
			//$alarm = "leaveRoute";
    	$str .= "#" . $row["vehicleid"] . "|" . $row["registration"] ."|". $alarm ."|". $row["DateTime"];
	}
	print $str;
	closedb();
?>