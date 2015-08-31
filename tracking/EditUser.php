<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php include "../include/db.php" ?>

<?php
header("Content-type: text/html; charset=utf-8"); 
opendb();
  $userid=$_GET["id"];
  $clientid=$_GET["clientid"];
  $fn = str_replace("'", "''", NNull($_GET['fn'], ''));
  $un = str_replace("'", "''", NNull($_GET['un'], ''));
  $timezone = str_replace("'", "''", NNull($_GET['timezone'], ''));
  $password = getQUERY("password");
  $mapa = $_GET['mapa'];
  $dateformat=getQUERY("dateformat");
  //echo $dateformat ;
  //$dateformat = str_replace("'", "''", NNull($_GET['dateformat'], '')); 
  //$timeformat = str_replace("'", "''", NNull($_GET['timeformat'], '')); 
  $timeformat=getQUERY("timeformat");
  //echo $timeformat;
  $roleid = str_replace("'", "''", NNull($_GET['roleid'], ''));
  $organisationid = str_replace("'", "''", NNull($_GET['organisationid'], ''));
  $activ=str_replace("'", "''", NNull($_GET['activ'], ''));
  $metric = str_replace("'", "''", NNull($_GET['metric'], ''));
  
  $city = str_replace("'", "''", NNull($_GET['city'], ''));

	$dsAll = query("select longitude, latitude from cities where id=" . $city );
	$latC = pg_fetch_result($dsAll, 0, "latitude");
	$longC = pg_fetch_result($dsAll, 0, "longitude");
	$url = "http://ws.geonames.org/timezone?lat=" . $latC . "&lng=" . $longC;
	$xml = simplexml_load_file($url);
	$tzoneUser = $xml->timezone->dstOffset;
	$url = "http://ws.geonames.org/timezone?lat=41.995900&lng=21.431500";
	$xml = simplexml_load_file($url);
	$tzoneLocal = $xml->timezone->dstOffset;
	$tzone = $tzoneUser - $tzoneLocal;
  
  if($mapa=='Google')
  {
  	$mapa='GOOGLEM';
  }
  if($mapa=='Bing')
  {
  	$mapa="BINGM";
  }
  if($mapa=='OSM')
  {
  	$mapa='OSMM';
  }
  if($mapa=='Geonet' || $mapa=='Изберете основна мапа')
  {
  	$mapa="YAHOOM";
  }
  if($dateformat=='0')
  {
  	$dateformat='d-m-Y';
  }
  else {
      $dateformat="". $dateformat ."";
  }
  if($timeformat=='0')
  {
  	$timeformat='H:i:s';
  }
  /*if($timeformat=='24h')
	{
		$timeformat="HH:mm:ss";
	}  
   if($timeformat=='12h')
   {
   		$timeformat="hh:mm:ss";
   }*/
  $zaedno="". $dateformat . " " . $timeformat .  "";
 // echo $zaedno;
  //exit;
 if($organisationid=='')
 {
 	$organisationid='null';
 }
 else {
     $organisationid= "" . $organisationid ."";
	 
 }
  ////*!!!!!!!! na nivo na cela aplikacija !!!!!!!
  $ImeBaza= dlookup("select username from users where id=" .$userid);
  if(strcmp($ImeBaza,$un)==0)
  {
  	$edituser=RunSQL("update users set organisationid=" . $organisationid . ", fullname='" . $fn . "',username='" . $un . "', password='" . $password . "', roleid=" . $roleid . ", active='" . $activ . "', timezone=" . $timezone . ", metric='" . $metric . "', datetimeformat='" . $zaedno . "', defaultmap='" . $mapa .  "', tzone='" . $tzone . "', cityid='" . $city . "' where clientid=" . $clientid . " and id=" . $userid);		 	 
		//print 'OK';
		//exit;
  }
  ///*******************
  else
  	{
  		$usernames=dlookup("SELECT count(*) FROM users WHERE username LIKE '" . $un  . "'");
  		if($usernames>=1)
		{
			print '1';
			exit;
		}
		else {
			  	$edituser=RunSQL("update users set organisationid=" . $organisationid . ", fullname='" . $fn . "',username='" . $un . "', password='" . $password . "', roleid=" . $roleid . ", active='" . $activ . "', timezone=" . $timezone . ", metric='" . $metric . "', datetimeformat='" . $zaedno . "', defaultmap='" . $mapa .  "' where clientid=" . $clientid . " and id=" . $userid);		 	 
			}	
	}
	closedb();
	?>