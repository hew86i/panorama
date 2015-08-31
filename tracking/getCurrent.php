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
	
	$tzone1 = dlookup("select tzone from users where id=".session("user_id"));
	
	$allowedrouting = dlookup("select allowedrouting from clients where id=".session("client_id"));
	if($allowedrouting == "1"){
		if (session("role_id")."" == "2")
		{
			$sqlD1 = "select * from gettoursbycid(" . session("client_id") . ")";
		} else {
			$sqlD1 = "select * from gettoursbyuid(" . session("user_id") . ")";
		}
		//$sqlD1 = "select * from gettoursbycid(154)";
		$dsPre1 = query($sqlD1);
		while($row = pg_fetch_array($dsPre1))
		{
			$stoenje = query("select sec2time1(" . $row["diff"] . ") diff");
			$tin = new DateTime($row["timein"]);
			$tin = $tin->format("H:i:s");
			if($row["timeout"]."" != "")
			{
				$tout = new DateTime($row["timeout"]);
				$tout = $tout->format("H:i:s");
			} else {
				$tout = "/";
			}
			if(trim($row["timein"]) != "")
			{
				$str .= "#" . $row["tourid"]."_".$row["poiid"] . "|" . $tin . "|". $tout . "|" . pg_fetch_result($stoenje, 0, "diff") . "|" . $row["rbr1"] . "|" . $row["vehicleid"] . "|" . $row["vozilo"] . "|" . $row["timeout"];
			}
		}
		$str .= "@%@^";
	}

	//$tzone = nnull(dlookup("select timezone from users where id=".session("user_id")),1);
	$tzone = 0; //$tzone - 1;
	$DFormat1 = "dd-MM-yyyy"; //nnull(dlookup("select DateFormat from usersettings where userid=" . session("user_id")),"dd-MM-yyyy");
	$TFormat1 = "24 Hour Time"; //nnull(dlookup("select TimeFormat from usersettings where userid=" . session("user_id")),"24 Hour Time");
	$TFormat = "";
	$DFormat = "";
	if($DFormat1 == "dd-MM-yyyy")
		$DFormat = "d-m-Y";
	else
		if($DFormat1 == "yyyy-MM-dd")
			$DFormat = "Y-m-d";
		else
			$DFormat = "m-d-Y";

	if($TFormat1 == "24 Hour Time")
		$TFormat = "H:i:s";
	else
		$TFormat = "h:i:s A";
	$DTFormat = $DFormat . " " . $TFormat;

    
	$dbDatum = DlookUP("select now() DateTime");
	$dtTmp111 = new Datetime($dbDatum);
	$dbDatum = $dtTmp111->format("Y-m-d H:i:s");
	$dbDatum = addToDateU($dbDatum, $tzone1, 'hour', 'Y-m-d H:i:s');
	//$dbDatum123 = DlookUP("select DATEADD(MINUTE, -30, GETDATE()) DateTime");

	
	$sqlV = "";
	if (session("role_id")."" == "2"){
		$sqlV = "select id from vehicles where clientid=".session("client_id");
	} else {
		$sqlV = "select vehicleid from uservehicles where userid=".session("user_id"); 
	}

	$ClientTypeID = dlookup("select clienttypeid from clients where id=".session("client_id"));
	
	$sqlStyles = "";
	$sqlStyles .= "SELECT c1.name engineon, c2.name engineoff, c3.name engineoffpassengeron, c4.name satelliteoff, c5.name taximeteron, c6.name taximeteroffpassengeron, c7.name passiveon, c8.name activeoff ";
	$sqlStyles .= "from users us ";
	$sqlStyles .= "left outer join statuscolors c1 on c1.id=us.engineon ";
	$sqlStyles .= "left outer join statuscolors c2 on c2.id=us.engineoff ";
	$sqlStyles .= "left outer join statuscolors c3 on c3.id=us.engineoffpassengeron ";
	$sqlStyles .= "left outer join statuscolors c4 on c4.id=us.satelliteoff ";
	$sqlStyles .= "left outer join statuscolors c5 on c5.id=us.taximeteron ";
	$sqlStyles .= "left outer join statuscolors c6 on c6.id=us.taximeteroffpassengeron ";
	$sqlStyles .= "left outer join statuscolors c7 on c7.id=us.passiveon ";
	$sqlStyles .= "left outer join statuscolors c8 on c8.id=us.activeoff ";
	$sqlStyles .= "where us.id=".session("user_id");
	$dsStyles = query($sqlStyles);

	$sql_ = "";
	$sql_ .= "select cast(v.code as integer), v.fuelcapacity, v.registration, '1' sedista, cp.* ";
	$sql_ .= "from currentposition cp ";
	$sql_ .= "left outer join vehicles v on v.id=cp.vehicleid ";
	$sql_ .= "where vehicleid in (" . $sqlV . ") order by cast(v.code as integer) asc";
	
	$ds = query($sql_);

	if($ClientTypeID == 2)
	{
		// ako e taksi kompanija
		
		while($row = pg_fetch_array($ds))
		{
			$lon = $row["longitude"];
			$lat = $row["latitude"];

			//if($row["LongOrientation"] == "W") $lon = "-" . $lon;
			//if($row["LatOrientation"] == "S") $lat = "-" . $lat;
			$stil = "";

        	$row["sedista"] = NNull($row["sedista"], 0);
        	
        	$cntIgn = dlookup("select count(portname) from vehicleport where vehicleid=" . $row["vehicleid"] . " and porttypeid=1");
			if($cntIgn == 0)
				$ign_ = "di1";
			else
				$ign_ = dlookup("select portname from vehicleport where vehicleid=" . $row["vehicleid"] . " and porttypeid=1");
			if($row[$ign_]."" == "0") $stil = pg_fetch_result($dsStyles,"EngineOFF");
			if($row[$ign_]."" == "1") $stil = pg_fetch_result($dsStyles,"EngineOn");

			//if($row["Ignition"]."" == "0" && $row["sedista"]."" <> "0") $stil = pg_fetch_result($dsStyles, 0, "EngineOFFPassengerON");
			//if($row["Ignition"]."" == "1" && $row["sedista"]."" <> "0" &&  $row["Taximeter"]."" == "0") $stil = pg_fetch_result($dsStyles,"TaximeterOFFPassengerON");
			//if($row["Ignition"]."" == "1" && $row["Taximeter"]."" == "1") $stil = odbc_result($dsStyles,"TaximeterON");
			//if($row["Ignition"]."" == "1" && $row["sedista"]."" == "0" and $row["Taximeter"]."" == "0") $stil = odbc_result($dsStyles,"EngineON");
			
			//if($row["passive"]."" == "1")
			//$stil = pg_fetch_result($dsStyles,0,"PassiveON");
			if($row["status"]."" == "0") $stil = pg_fetch_result($dsStyles, 0, "satelliteoff");
			$pass = "0";
			//if($row["passive"]."" == "1") $pass = "1";
			$tax = "1";
			
			//if($row["Taximeter"]."" == "1") $tax = "1";
			$loc = $row["poinames"];
        	$address = dlookup("select latloninarea(" . $lat . ", " . $lon . ", " . session("client_id") . ")");
			$oldDate = "0";

			//echo date_add($dbDatum, new DateInterval("T3H"));
			//echo $tzone;
			//dd-MM-yyyy HH:mm:ss
			
			//echo $dbDatum;
			//echo "<br /><br />";
			//echo date($DTFormat, strtotime($dbDatum .' '.$tzone.' hour'));
			//
			
			//$date = new DateTime($dbDatum);
			//date_add($date, new DateInterval("P0DT5H"));
			//echo '<br />'.$date->format($DTFormat).' : 0 Years, 5 Hours';
			
			//echo $date->format("d-m-Y H:i:s").'<br />';
			
			//$compressed = gzcompress('Compress me', 1);
			//echo $compressed;
			//exit();
			
			//echo date('Y-m-d', strtotime($dbDatum));
			//echo "<br />";
			//echo $dbDatum;
			//echo "<br />";
			//echo "<br />";
			//echo abs(strtotime($row["DateTime"]) - strtotime($dbDatum));
			//exit();
			
			//format(DateAdd(DateInterval.Hour, $tzone, date('Y-m-d', strtotime($row["DateTime"]))), $DTFormat)
			$dtTmp = new Datetime($row["DateTime"]);
			$dtTmp = $dtTmp->format("Y-m-d H:i:s");
			if(abs(strtotime($dtTmp) - strtotime($dbDatum))>90) 
			{
				$oldDate = "1";
			}
			$alarm = $row["alarm"];
			$zoneids = $row["zoneids"];
			
			$temper = $row["ai1"];
			$temper = ($temper * 20) - 70;
			
			$litres = $row["ai2"];
			$litres = $litres * ($row["fuelcapacity"] / 100);
			
			//$alpha .= dlookup("select getalpha(" . $lat . ", " . $lon . ", " . $lastLat . ", " . $lastLon . ")"). ",";
        	$str .= "#" . $row["code"] . "|" . $lon . "|" . $lat . "|" . $stil . "|" . $pass . "|" . date($DTFormat, strtotime($row["DateTime"] .' '.$tzone.' hour')) . "|" . $loc . "|" . intval($row["speed"]) . "|" . $tax . "|" . $row["sedista"]."" . "|" . $oldDate . "|" . $address . "|" . $row["Location"] . "|" . NNull($row["registration"]) ."|". $alarm ."|". $row["DateTime"] ."|". $row["cbfuel"] ."|". $row["cbrpm"] ."|". $row["cbtemp"] ."|". $row["cbdistance"] ."|". $temper ."|". $litres ."|". $zoneids;
		}
	}else
	{
		// Ostanati
		while($row = pg_fetch_array($ds))
		{
			$lon = $row["longitude"];
			$lat = $row["latitude"];
			//if($row["LongOrientation"] == "W") $lon = "-" . $lon;
			//if($row["LatOrientation"] == "S") $lat = "-" . $lat;
			$stil = "";
			$cntIgn = dlookup("select count(portname) from vehicleport where vehicleid=" . $row["vehicleid"] . " and porttypeid=1");
			
			$temper = $row["ai1"];
			$temper = ($temper * 20) - 70;
			//if($row[$ign_]."" == "0" && intval($row["ai2"]) == 0)
				//$litres = dlookup("select ai2 from historylog where vehicleid=" . $row["vehicleid"] . " and cast(ai2 as integer) <> 0 order by datetime desc limit 1");
			//else
				$litres = $row["ai2"];
			$litres = $litres * ($row["fuelcapacity"] / 100);
			
			if($cntIgn == 0)
				$ign_ = "di1";
			else	
				$ign_ = dlookup("select portname from vehicleport where vehicleid=" . $row["vehicleid"] . " and porttypeid=1");

			if($row[$ign_]."" == "0") $stil = pg_fetch_result($dsStyles,0,"EngineOFF");
			if($row[$ign_]."" == "1") $stil = pg_fetch_result($dsStyles,0,"EngineOn");
			if($row["status"]."" == "0") $stil = pg_fetch_result($dsStyles,0,"satelliteoff");
			$pass = "0";
			//if($row["passive"]."" == "1") $pass = "1";
        	$loc = $row["poinames"];
        	$address = dlookup("select latloninarea(" . $lat . ", " . $lon . ", " . session("client_id") . ")");
			$tax = "0";
			$oldDate = "0";		
			$dtTmp = new Datetime($row["DateTime"]);
			$dtTmp = $dtTmp->format("Y-m-d H:i:s");
			//echo $row["code"] . "<br/>";
			if(abs(strtotime($dtTmp) - strtotime($dbDatum)) > 90)
			{ 
				$oldDate = "1";
			}
			$alarm = $row["alarm"];
			$zoneids = $row["zoneids"];
			//echo $loc." - <br/>";
			//echo $dtTmp . "<br/> " . $dbDatum . "<br/> " . $oldDate."<br/><br/><br/>";
			$str .=  "#" . $row["code"] . "|" . $lon .  "|" . $lat . "|" . $stil . "|" . $pass . "|" . date($DTFormat, strtotime($row["DateTime"] .' '.$tzone.' hour')) . "|" . $loc . "|" . intval($row["speed"]) . "|" . $tax . "|" . $row["sedista"]."" . "|" . $oldDate . "|"  . $address . "|" . $row["Location"] . "|" . NNull($row["registration"]) ."|". $alarm ."|". $row["DateTime"] ."|". $row["cbfuel"] ."|". $row["cbrpm"] ."|". $row["cbtemp"] ."|". $row["cbdistance"] ."|". $temper ."|". $litres ."|". $zoneids;
		}
	}
//exit;
	//$compressed = base64_encode(gzencode($str));
	print $str;
	closedb();
	
?>