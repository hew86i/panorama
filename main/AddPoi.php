<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
    set_time_limit(0);
	opendb();

	$lon = str_replace("'", "''", NNull($_GET['lon'], ''));
    $lat = str_replace("'", "''", NNull($_GET['lat'], ''));
	$_name = str_replace("'", "''", NNull($_GET['name'], ''));
	$_description = str_replace("'", "''", NNull($_GET['description'], ''));
	$_additional = str_replace("'", "''", NNull($_GET['additional'], ''));
	$_avail = str_replace("'", "''", NNull($_GET['avail'], ''));
	$_ppgid = str_replace("'", "''", NNull($_GET['ppgid'], ''));
	$_lang = str_replace("'", "''", NNull($_GET['l'], ''));
	$_radius = str_replace("'", "''", NNull($_GET['radius'], ''));
    $cLang = $_lang;
    //ST_GeomFromText('POINT(41.996814 21.48046)')
    $sqlAddPoi = "insert into pointsofinterest(clientid, groupid, name, type, geom, radius, available, userid) Values('" . session("client_id") . "','" . $_ppgid . "', N'" . $_name . "', '1', ST_Transform(ST_GeomFromText('POINT(" . $lon . " " . $lat . ")',4326),26986), " . $_radius . "," . $_avail . ", '" . session("user_id") . "')";
    //echo $sqlAddPoi;																																										ST_Transform(ST_GeomFromText('POINT('||_latitude||' '||_longitude||')',4326),26986)
    //exit;
    $ret = RunSQL($sqlAddPoi);
    //$ret = 1;
    if($ret == "1") {
        $str1 = "";
        /*$str1 = "select pp.longitude, pp.latitude, pp.name, pp.description, pp.available, pp.pinpointgroupid, pp.id, ISNULL(ppg.Color, '000000') AS Color, ppg.GroupName, ppg.Image, pp.CanChange, pp.AddInfo, pp.RadiusID from pinpoints pp ";
        $str1 .= " left outer join PinPointGroups ppg on pp.PinPointGroupID=ppg.ID ";
        $str1 .= " where pp.clientID=" . session("client_id") . " ORDER BY ID DESC";*/
		$str1 = "select pp.id, ST_X(ST_Transform(pp.geom,4326)) long, ST_Y(ST_Transform(pp.geom,4326)) lat, pp.name, pp.available, ";
		$str1 .= " pp.groupid, pp.id, ppg.fillcolor color, ppg.name groupname, pp.radius, ppg.image from pointsofinterest pp ";
		$str1 .= " left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id ";
		$str1 .= " where pp.clientid=" . session("client_id") . " and type=1 ORDER BY pp.id DESC limit 1";


        $ds = query($str1);
        $str = "";
        while($row = pg_fetch_array($ds))
		{
            $str .= str_replace(",", ".", $row["long"]."") . "|" . str_replace(",", ".", $row["lat"]."") . "|" . str_replace("|", "", str_replace("#", "", $row["name"])) . "|" . $row["available"] . "|" . $row["groupid"] . "|" . $row["id"] . "|" . "/" . "|" . str_replace("|", "", str_replace("#", "", $row["color"])) . "|" . str_replace("|", "", str_replace("#", "", $row["groupname"])) . "|" . "0" . "|" . "1" . "|" . "/" . "|" . str_replace("|", "", str_replace("#", "", $row["radius"])) . "|" . $row["image"];
        }
		//echo $str;
		//exit;
		
        print "@@%%";
        //print base64_encode(gzencode($str));
		print $str;
       print "@@%%";
       print dic("Tracking.ThePoi");
       print " (<strong>";
       print $_name;
       print "</strong>) ";
       print dic("Tracking.SucAdd");
    } else
    {
        print dic("Tracking.Error");
    }
?>
