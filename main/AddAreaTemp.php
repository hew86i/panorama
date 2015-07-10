<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php

	set_time_limit(0);
	opendb();
	$n = str_replace("'", "''", NNull($_GET['n'], ''));
	$_avail = str_replace("'", "''", NNull($_GET['avail'], ''));
	$_ppgid = str_replace("'", "''", NNull($_GET['ppgid'], ''));
	$em = str_replace("'", "''", NNull($_GET['e'], ''));
	$ph = str_replace("'", "''", NNull($_GET['ph'], ''));
	$p = str_replace("'", "''", NNull($_GET['p'], ''));

	$alvl = str_replace("'", "''", NNull($_GET['alvl'], ''));
	$aliz = str_replace("'", "''", NNull($_GET['aliz'], ''));
	$sidx = str_replace("'", "''", NNull($_GET['sidx'], ''));
	$oeid = str_replace("'", "''", NNull($_GET['oeid'], ''));
	$selveh = str_replace("'", "''", NNull($_GET['selveh'], ''));
	
	$type = str_replace("'", "''", NNull($_GET['type'], ''));

	$_lang = str_replace("'", "''", NNull($_GET['l'], ''));
	$cLang = $_lang;
	
	$strPoly = "POLYGON((";
	if($p != '0'){
		
        $a = explode("^", $p);
        for($i=1;$i<sizeof($a);$i++)
		{
            $b = explode("@", $a[$i]);
			$strPoly .= $b[1] . " " . $b[0]. ",";
            //RunSQL("insert into AreaPoints(AreaID, Longitude, Latitude) values (" . $ida . ", '" . $b[0] . "', '" . $b[1] . "')");
        }
		$strPoly = substr($strPoly, 0, strlen($strPoly)-1)."))";
	}else
	{
		$strPoly = "POLYGON((42.003263 21.395151,41.04 21.04,42 22,41.04 21.04,42.00 22.00,42.003263 21.395151))";
	}

    $sql1 = "insert into pointsofinterest(clientid, groupid, name, geom, type, radius, available, userid, povrsina) Values ('" . session("client_id") . "', " . $_ppgid . ", N'" . $n . "', ST_PolygonFromText('".$strPoly."', 26986), '" . $type . "', '50', '" . $_avail . "', '" . session("user_id") . "', ST_Area(ST_SetSRID(ST_PolygonFromText('".$strPoly."'),3035))*1000000000)";
	$id = dlookup($sql1 . " RETURNING id");
	
	//$id = dlookup("select id from pointsofinterest where clientid=" . session("client_id") . " and type=2 order by id desc limit 1");
	
	$today = getdate();
	$q = ''.$today[0];
				
	if($alvl == "true")
	{
		
		$snooze = dlookup("select snooze from users where id=" . session("user_id"));
		$sqlAl1 = "";
		if($sidx == "1")
		{
			$sqlAl1 .= "insert into alarms (alarmtypeid, settings, available, emails, sms, soundid, snooze, clientid, vehicleid, poiid, typeofgroup) ";
			$sqlAl1 .= " Values ('8', '" . $oeid . "', '" . $_avail . "', '" . $em . "', '" . $ph . "', 1, '" . $snooze . "', '" . session("client_id") . "', '" . $selveh . "', '" . $id . "', '" . $sidx . "')";
			$dsAl1 = query($sqlAl1);
			$sqlAl1 = "";
		} else
			if($sidx == "2")
			{
				$dsVehByOE = query("select id from vehicles where organisationid=" . $oeid);
				while($row = pg_fetch_array($dsVehByOE))
				{
					$sqlAl1 .= "insert into alarms (alarmtypeid, settings, available, emails, sms, soundid, snooze, clientid, vehicleid, poiid, uniqid, typeofgroup) ";
					$sqlAl1 .= " Values ('8', '" . $oeid . "', '" . $_avail . "', '" . $em . "', '" . $ph . "', 1, '" . $snooze . "', '" . session("client_id") . "', '" . $row["id"] . "', '" . $id . "', '" . $q . "', '" . $sidx . "')";
					$dsAl1 = query($sqlAl1);
					$sqlAl1 = "";
				}
			} else
			{
				$dsVehByCID = query("select id from vehicles where clientid=" . session("client_id"));
				while($row = pg_fetch_array($dsVehByCID))
				{
					$sqlAl1 .= "insert into alarms (alarmtypeid, settings, available, emails, sms, soundid, snooze, clientid, vehicleid, poiid, uniqid, typeofgroup) ";
					$sqlAl1 .= " Values ('8', '" . $oeid . "', '" . $_avail . "', '" . $em . "', '" . $ph . "', 1, '" . $snooze . "', '" . session("client_id") . "', '" . $row["id"] . "', '" . $id . "', '" . $q . "', '" . $sidx . "')";
					$dsAl1 = query($sqlAl1);
					$sqlAl1 = "";
				}
			}
	}
	if($aliz == "true")
	{
		$q = $q + 1;
		$snooze = dlookup("select snooze from users where id=" . session("user_id"));
		$sqlAl1 = "";
		if($sidx == "1")
		{
			$sqlAl1 .= "insert into alarms (alarmtypeid, settings, available, emails, sms, soundid, snooze, clientid, vehicleid, poiid, typeofgroup) ";
			$sqlAl1 .= " Values ('9', '" . $oeid . "', '" . $_avail . "', '" . $em . "', '" . $ph . "', 1, '" . $snooze . "', '" . session("client_id") . "', '" . $selveh . "', '" . $id . "', '" . $sidx . "')";
			$dsAl1 = query($sqlAl1);
			$sqlAl1 = "";
		} else
			if($sidx == "2")
			{
				$dsVehByOE = query("select id from vehicles where organisationid=" . $oeid);
				while($row = pg_fetch_array($dsVehByOE))
				{
					$sqlAl1 .= "insert into alarms (alarmtypeid, settings, available, emails, sms, soundid, snooze, clientid, vehicleid, poiid, uniqid, typeofgroup) ";
					$sqlAl1 .= " Values ('9', '" . $oeid . "', '" . $_avail . "', '" . $em . "', '" . $ph . "', 1, '" . $snooze . "', '" . session("client_id") . "', '" . $row["id"] . "', '" . $id . "', '" . $q . "', '" . $sidx . "')";
					$dsAl1 = query($sqlAl1);
					$sqlAl1 = "";
				}
			} else
			{
				$dsVehByCID = query("select id from vehicles where clientid=" . session("client_id"));
				while($row = pg_fetch_array($dsVehByCID))
				{
					$sqlAl1 .= "insert into alarms (alarmtypeid, settings, available, emails, sms, soundid, snooze, clientid, vehicleid, poiid, uniqid, typeofgroup) ";
					$sqlAl1 .= " Values ('9', '" . $oeid . "', '" . $_avail . "', '" . $em . "', '" . $ph . "', 1, '" . $snooze . "', '" . session("client_id") . "', '" . $row["id"] . "', '" . $id . "', '" . $q . "', '" . $sidx . "')";
					$dsAl1 = query($sqlAl1);
					$sqlAl1 = "";
				}
			}
	}

	$sql3 = "select fillcolor from pointsofinterestgroups where id=" . $_ppgid;
	$dsCol = query($sql3);
	if($type == "2")
		$str = dic("Tracking.GeoFenceRecord")."&&@^";
	else
		$str = dic("successfullyPolygon")."&&@^";
	$str .= "".$id."&&@^".pg_fetch_result($dsCol, 0, "fillcolor")."";
	print $str;
	closedb();
?>
