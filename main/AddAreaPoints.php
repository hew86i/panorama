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
    $_ida = str_replace("'", "''", NNull($_GET['ida'], ''));
	
    $dsAP = query("select areapoints from addareatemp where pointsofinterestid=" . $_ida . " order by index asc");
    
    $strArrPoints = "";
    while ($row = pg_fetch_array($dsAP)){
       $strArrPoints .= $row["areapoints"]."";
    }
    $a = explode("^", $strArrPoints);
	$strPoly = "POLYGON((";
    for($i=1;$i<sizeof($a);$i++)
	{
        $b = explode("@", $a[$i]);
		$strPoly .= $b[1] . " " . $b[0]. ",";
        //RunSQL("insert into AreaPoints(AreaID, Longitude, Latitude) values (" . $_ida . ", '" . $b[0] . "', '" . $b[1] . "')");
	}
	$strPoly = substr($strPoly, 0, strlen($strPoly)-1)."))";
	
    //$_id = DlookUP("select ForeignID from Areas where ID=" . $_ida);
    RunSQL("update pointsofinterest set geom = ST_PolygonFromText('" . $strPoly . "', 26986), povrsina=ST_Area(ST_SetSRID(ST_PolygonFromText('" . $strPoly . "'),3035))*1000000000 where id= " . $_ida);
    RunSQL("delete from addareatemp where pointsofinterestid=" . $_ida);
	closedb();
?>
