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

	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	$p = str_replace("'", "''", NNull($_GET['p'], ''));
	$_n = str_replace("'", "''", NNull($_GET['n'], ''));
	
	$_avail = str_replace("'", "''", NNull($_GET['avail'], ''));
	$_gfgid = str_replace("'", "''", NNull($_GET['gfgid'], ''));
	
	
	$em = str_replace("'", "''", NNull($_GET['e'], ''));
	$ph = str_replace("'", "''", NNull($_GET['ph'], ''));
    
	$alvl = str_replace("'", "''", NNull($_GET['alvl'], ''));
	$aliz = str_replace("'", "''", NNull($_GET['aliz'], ''));
	$sidx = str_replace("'", "''", NNull($_GET['sidx'], ''));
	$oeid = str_replace("'", "''", NNull($_GET['oeid'], ''));
	$selveh = str_replace("'", "''", NNull($_GET['selveh'], ''));
    
    $_lang = str_replace("'", "''", NNull($_GET['l'], ''));
    $cLang = $_lang;

	opendb();
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
		RunSQL("update pointsofinterest set geom = ST_PolygonFromText('" . $strPoly . "', 26986), povrsina=ST_Area(ST_SetSRID(ST_PolygonFromText('" . $strPoly . "'),3035))*1000000000 where id= " . $id);
	}
    RunSQL("UPDATE pointsofinterest SET userid='" . session("user_id") . "', name = N'" . $_n . "', available='" . $_avail . "', groupid='" . $_gfgid . "' WHERE ID=" . $id);
    
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
	
	//$ida = dlookup("select id from Areas where ForeignID=" . $id);
	//runsql("delete from AreaPoints where AreaID=" . $ida);
	
	$sql3 = "select fillcolor from pointsofinterestgroups where id=" . $_gfgid;
    $dsCol = query($sql3);
    print dic("Tracking.GeoFenceModify") . "&&@^" . pg_fetch_result($dsCol, 0, "fillcolor");
    closedb();
?>