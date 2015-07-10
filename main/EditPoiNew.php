<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
    set_time_limit(0);
	opendb();

    $_id = str_replace("'", "''", NNull($_GET['id'], ''));
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
    //echo "UPDATE pointsofinterest SET geom=ST_GeomFromText('POINT(" . $lat . " " . $lon . ")',900913), name=N'" . $_name . "', available=" . $_avail . ", groupid=" . $_ppgid . ", radius=" . $_radius . " WHERE ID=" . $_id;
    //exit;
	$sql1 = "UPDATE pointsofinterest SET userid='" . session("user_id") . "', geom=ST_Transform(ST_GeomFromText('POINT(" . $lon . " " . $lat . ")',4326),26986), name=N'" . $_name . "', available=" . $_avail . ", groupid=" . $_ppgid . ", radius=" . $_radius . " WHERE ID=" . $_id;
    $ret = RunSQL($sql1);
	
    if($ret == "1")
	{
        $dsc = query("select fillcolor, image from pointsofinterestgroups where id=" . $_ppgid);
        print "@@%%" . pg_fetch_result($dsc, 0, 'fillcolor') . "|@" . pg_fetch_result($dsc, 0, 'image') . "@@%%";
        print dic("Tracking.ThePoi");
        print " (<strong>" . $_name . "</strong>) ";
        print dic("Tracking.SucUpd");
    } else
        print dic("Tracking.Error");
?>
