<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php

	set_time_limit(0);
	opendb();
	$n = str_replace("'", "''", NNull($_GET['n'], ''));
	$av = str_replace("'", "''", NNull($_GET['av'], ''));
    $_in = str_replace("'", "''", NNull($_GET['in'], ''));
    $_out = str_replace("'", "''", NNull($_GET['out'], ''));
	$in1 = str_replace("'", "''", NNull($_GET['in1'], ''));
	$out1 = str_replace("'", "''", NNull($_GET['out1'], ''));
    $in2 = str_replace("'", "''", NNull($_GET['in2'], ''));
    $out2 = str_replace("'", "''", NNull($_GET['out2'], ''));
	$em = str_replace("'", "''", NNull($_GET['e'], ''));
	$ph = str_replace("'", "''", NNull($_GET['ph'], ''));
    $p = str_replace("'", "''", NNull($_GET['p'], ''));

    $_avail = str_replace("'", "''", NNull($_GET['avail'], ''));
	$_ppgid = str_replace("'", "''", NNull($_GET['ppgid'], ''));

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

    $sql1 = "insert into pointsofinterest(clientid, groupid, name, geom, type, radius, available, userid, povrsina) Values('" . session("client_id") . "', " . $_ppgid . ", N'" . $n . "', ST_PolygonFromText('".$strPoly."', 26986), 2, '50', '" . $_avail . "', '" . session("user_id") . "', ST_Area(ST_SetSRID(ST_PolygonFromText('".$strPoly."'),3035))*1000000000)";
	$dsID = query($sql1);
	
	$id = dlookup("select id from pointsofinterest where clientid=" . session("client_id") . " order by id desc limit 1");

    /*$s = "insert into AreasAlarmsHeader(areaID, all_allowed_in, all_allowed_out, all_notallowed_in, all_notallowed_out, emails, phones) ";
    $s .= "Values ('" . $id . "', " . $in1 . ", " . $out1 . ", " . $in2 . ", " . $out2 . ", N'" . $em . "', N'" . $ph . "')";
    RunSQL($s);

    $av_arr = explode(",", $av);
    for($i=1; $i < sizeof($av_arr); $i++)
	{
        RunSQL("insert into AreasAlarmsDetail(areaID, vehicleID, [type]) values(" . $id . ", " . $av_arr[$i] . " ,1)");
    }

    $in_arr = explode(",", $_in);
    for($i=1; $i < sizeof($in_arr); $i++)
	{
        RunSQL("insert into AreasAlarmsDetail(areaID, vehicleID, [type]) values(" . $id . ", " . $in_arr[$i] . " ,2)");
    }

    $out_arr = explode(",", $_out);
    for($i=1; $i < sizeof($out_arr); $i++)
	{
        RunSQL("insert into AreasAlarmsDetail(areaID, vehicleID, [type]) values(" . $id . ", " . $out_arr[$i] . " ,3)");
    }*/
    
	$sql3 = "select fillcolor from pointsofinterestgroups where id=" . $_ppgid;
    $dsCol = query($sql3);
    $str = dic("Tracking.GeoFenceRecord")."&&@^";
    $str .= "".$id."&&@^".pg_fetch_result($dsCol, 0, "fillcolor")."";
    print $str;
	closedb();
?>
