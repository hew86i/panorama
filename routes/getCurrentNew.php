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
	
	$user_id = Session("user_id");
	$client_id = Session("client_id");
	$roleid = Session("role_id");
	
	$dateE = getQUERY("dateS");
	$dateE = getQUERY("dateE");
	$tourid = getQUERY("tourid");
	if($tourid == "")
	{
		if($dateS == "")
		{
			if($roleid == "2")
			{
				if(dlookup("select count(*) from rNalogHeder where clientid=" . $client_id . " and startdate < cast(now() as date) + cast('1 day' as interval)") > 0)
					$currDateTime2 = dlookup("select cast(startdate as date) from rNalogHeder where clientid=" . $client_id . " and startdate < cast(now() as date) + cast('1 day' as interval) order by startdate desc limit 1");
				else
					$currDateTime2 = "";
			} else {
				if(dlookup("select count(*) from rNalogHeder where userid=" . $user_id . " and startdate < cast(now() as date) + cast('1 day' as interval)") > 0)
					$currDateTime2 = dlookup("select cast(startdate as date) from rNalogHeder where userid=" . $user_id . " and startdate < cast(now() as date) + cast('1 day' as interval) order by startdate desc limit 1");
				else
					$currDateTime2 = "";
			}
			$currDateTime2E = $currDateTime2;
		} else {
			$currDateTime2 = $dateS;
			$currDateTime2E = $dateE;
		}
	}
	
	$allowedrouting = dlookup("select allowedrouting from clients where id=".session("client_id"));
	if($allowedrouting == "1"){
		if (session("role_id")."" == "2")
		{
			if($tourid == "")
				$sqlD1 = "select * from gettoursbycidbydatetime(" . $client_id . ", '" . $currDateTime2 . " 00:00:00', '" . $currDateTime2E . " 23:59:59') order by tourid desc, rbr asc";
			else
				$sqlD1 = "select * from gettoursbycidbytourid(" . $client_id . ", " . $tourid . ") order by tourid desc, rbr asc";
		} else {
			if($tourid == "")
				$sqlD1 = "select * from gettoursbyuidbydatetime(" . $user_id . ", '" . $currDateTime2 . " 00:00:00', '" . $currDateTime2E . " 23:59:59') order by tourid desc, rbr asc";
			else
				$sqlD1 = "select * from gettoursbyuidbytourid(" . $user_id . ", " . $tourid . ") order by tourid desc, rbr asc";
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