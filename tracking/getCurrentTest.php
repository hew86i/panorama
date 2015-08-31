<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	
	opendb();
	
	$strSQL = "select u.id,u.clientid,u.username,c.name,u.tzone,u.cityid usercity,c.cityid clientcity, ci.name, ci1.name, ci1.name,ci1.latitude, ci1.longitude";
	$strSQL .= " from users u";
	$strSQL .= " left outer join clients c on c.id=u.clientid";
	$strSQL .= " left outer join cities ci on ci.id=u.cityid";
	$strSQL .= " left outer join cities ci1 on ci1.id=c.cityid";
	//$strSQL .= " where clientid in (329,338,359,127,354,361,357,298,325,358,360,246,363,362,365,364)";
	$strSQL .= " where (ci1.countryid=1 and u.tzone<>0) or (ci1.countryid<>1)";
	$strSQL .= " order by clientid";
	$ds = query($strSQL);
	$ok = 1;
	$br = 1;
	while($row = pg_fetch_array($ds))
	{
		$latC = $row["latitude"];
		$longC = $row["longitude"];
		$url = "http://ws.geonames.org/timezone?lat=" . $latC . "&lng=" . $longC;
		$xml = simplexml_load_file($url);
		$tzoneUser = $xml->timezone->dstOffset;
		$url1 = "http://ws.geonames.org/timezone?lat=41.995900&lng=21.431500";
		$xml1 = simplexml_load_file($url1);
		$tzoneLocal = $xml1->timezone->dstOffset;
		$tzone1 = $tzoneUser - $tzoneLocal;
		/*print_r($xml);
		echo "<br/>";
		print_r($xml1);
		echo "<br/>";*/
		
		if($tzoneUser == "" || $tzoneLocal == "")
		{
			print_r($xml);
			echo "<br/><br/>";
			echo $br.".   userid=" . $row["id"] . " tzone=" . $tzone1 . "<br/><br/><br/><br/>";
			$ok = 0;
			$br++;
		}else
		{
			RunSQL("update users set tzone=" . $tzone1 . " where id=" . $row["id"]);
		}
	}
	if($ok == 1){
		echo "Uspecno azuriranje na vremenski zoni za korisnicite!!!";
	}
	else {
		echo "Error!!!";
	}
	
	closedb();
	
?>