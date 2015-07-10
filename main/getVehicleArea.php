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
	
	if (!is_numeric(session('user_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
	if (!is_numeric(session('client_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
	
    $sqlV = "";
    if(session("role_id") == "2")
        $sqlV = "select id from vehicles where clientID=" . session("client_id");
	else
        $sqlV = "select vehicleID from UserVehicles where userID=" . session("user_id") . "";
    
	//$ds = query("select v.code, cp.longitude, cp.latitude from currentposition cp left outer join vehicles v on v.id=cp.vehicleid where v.id in (" . $sqlV . ")");

	$ds1 = query("select id,st_astext(geom) geom, active from pointsofinterest where active='1' and type=2 and clientid=" . session("client_id"));
	$str = "";
	//if(!($ds1))
	//{
		while ($row = pg_fetch_array($ds1)){
			print "#" . $row["id"] . ":";
			$ds = query("select v.code, cp.longitude, cp.latitude from currentposition cp left outer join vehicles v on v.id=cp.vehicleid where v.id in (" . $sqlV . ")");
			$vh = "";
			while ($row1 = pg_fetch_array($ds)){
				$_ch = query("select ST_GeomFromText('POINT(" . $row1["latitude"] . " " . $row1["longitude"] . ")',26986) <@ st_geomfromtext('" . $row["geom"] . "') ch");
				//echo pg_fetch_result($_ch, 0, "ch");
				if(pg_fetch_result($_ch, 0, "ch") == "t")
					$vh .= "," . $row1["code"];
			}
			print $vh;
			
		}
		print $str;
	//}
  
?>