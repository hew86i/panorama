<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php include "../include/lzw.inc.php" ?>
<?php
	if (session('user_id') == "261") echo header( 'Location: ../sessionexpired/?l='.$cLang);
 	header("Expires: Mon, 20 Jul 2000 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", FALSE);
    header("Pragma: no-cache");
	set_time_limit(0);
	$str = "";
	opendb();
	
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
	}

	print $str;
	closedb();
	
?>