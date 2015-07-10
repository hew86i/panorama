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
	$_idx = str_replace("'", "''", NNull($_GET['idx'], ''));
    $p = str_replace("'", "''", NNull($_GET['points'], ''));
    $_ida = str_replace("'", "''", NNull($_GET['ida'], ''));
	
	
    RunSQL("insert into addareatemp(pointsofinterestid, areapoints, index, clientid) values('" . $_ida . "', '" . $p . "', '" . $_idx . "', '" . Session("client_id") . "')");
	
	/*$tmpPoint = dlookup("select ST_AsText(geom) from pointsofinterest where id=".$_ida);
	$tmp3 =  strripos($tmpPoint, ",");
	$tmpPointNew = substr($tmpPoint, 0, $tmp3).",".$p.substr($tmpPoint, $tmp3, strlen($tmpPoint));
	echo $tmpPointNew;
	
	RunSQL("update pointsofinterest set geom = ST_PolygonFromText('" . $tmpPointNew . "') where id=75845");
	*/
	//POLYGON((42.003263 21.395151,42.003662 21.395274,42.00345 21.396808,42.003048 21.396722,42.003172 21.395778,42.003263 21.395151,42.16 21.16,42.003263 21.395151,41.04 21.04,42 22,42.003263 21.395151,41.04 21.04,42.00 22.00,42.003263 21.395151))
	
    //RunSQL("insert into AreaTempPoints(AreaID, AreaPoints, Idx, UserID, ClientID) values('" . $_ida . "', '" . $p . "', '" . $_idx . "', '" . session("user_id") . "', '" . Session("client_id") . "')");
   	closedb();
?>
