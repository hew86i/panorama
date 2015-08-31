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
	
	//$_numofveh = str_replace("'", "''", NNull($_GET['numofveh'], ''));
    
    /*$dsAll = query("select ci.latitude, ci.longitude from clients c left outer join cities ci on ci.id = c.cityid where c.id =" . session("client_id"));
	$latC = pg_fetch_result($dsAll, 0, "latitude");
	$longC = pg_fetch_result($dsAll, 0, "longitude");
	$url = "http://ws.geonames.org/timezone?lat=" . $latC . "&lng=" . $longC;
	$xml = simplexml_load_file($url);
	$tzoneUser = $xml->timezone->dstOffset;
	$url = "http://ws.geonames.org/timezone?lat=41.995900&lng=21.431500";
	$xml = simplexml_load_file($url);
	$tzoneLocal = $xml->timezone->dstOffset;
	$tzone1 = $tzoneUser - $tzoneLocal;*/
    
    $dsUserSett = query("select tzone, datetimeformat from users where id=".session("user_id"));
	$tzone1 = pg_fetch_result($dsUserSett, 0, "tzone");
	$FormatDT = pg_fetch_result($dsUserSett, 0, 'datetimeformat');
	$FormatDT1 = explode(" ", $FormatDT);
	$dateformat = $FormatDT1[0];
	$timeformat =  $FormatDT1[1];
	if ($timeformat == 'h:i:s') $timeformat = $timeformat . " A";
	
	$numveh = getQUERY("numofveh");
	$valtraj = getQUERY("valtraj");
	if($valtraj != -1)
		RunSQL("update users set trace = " . $valtraj . " where id=" . session("user_id"));
	
    $dsv = query("select id from vehicles where clientid=" . session("client_id") . " and code='" . $numveh . "'");
    
    $str = "";
    
	$strSQL = "select latitude, longitude, datetime from historylog where vehicleid = " . pg_fetch_result($dsv, 0, "id");
	$strSQL .= " and datetime > (select datetime from historylog where vehicleid = " . pg_fetch_result($dsv, 0, "id") . " and datetime <= now() + cast('" . $tzone1 . " hour' as interval) order by datetime desc limit 1)+cast('-' || (select trace from users where id=" . session("user_id") . ") || ' min' as interval)";
	$strSQL .= " and datetime <= now() + cast('" . $tzone1 . " hour' as interval) order by datetime asc";

	$ds = query($strSQL); //"select latitude, longitude from historylog where vehicleid = " . pg_fetch_result($dsv, 0, "id") . " order by datetime desc");
	$str1 = "";
	$str2 = "";
	$dist = "";
	$dt = "";
	$alpha = "";
	$lastdt = "";
	$lastLon = "";
	$lastLat = "";
	while ($row = pg_fetch_array($ds)){
		$dtTmp = new Datetime($row["datetime"]);
		$dtTmp = $dtTmp->format($timeformat . " " . $dateformat);
		$str1 .= "," . $row["longitude"];
		$str2 .= "," . $row["latitude"];
		if($lastLon != "")
		{
			$dist .= "," . dlookup("select dist_lonlat(" . $row["latitude"] . ", " . $row["longitude"] . ", " . $lastLat . ", " . $lastLon . ")");
			$alpha .= "," . dlookup("select getalpha(" . $row["latitude"] . ", " . $row["longitude"] . ", " . $lastLat . ", " . $lastLon . ")");
			$dt .= "," . $dtTmp;// . " - " . $lastdt;
		}
		$lastLon = $row["longitude"];
		$lastLat = $row["latitude"];
		$lastdt = $dtTmp;
	}
	$str = $str2 . "#" . $str1 . "#" . $dist . "#" . $dt . "#" . $alpha;
    print $str;
    //print base64_encode(gzencode($str));
	closedb();
?>