<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="../style.css">

	<script type="text/javascript" src="../js/jquery.js"></script>
	
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	
    <script type="text/javascript" src="../tracking/live.js"></script>
	<script type="text/javascript" src="../tracking/live1.js"></script>
	<script type="text/javascript" src="routes.js"></script>
	<script type="text/javascript" src="./js/highcharts.src.js"></script>

	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="../js/jquery-ui.js"></script>
	<script src="../report/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>


</head>
<?php

	
	$name = getQUERY("name");
	$dtfrom = getQUERY("dtfrom");
	$dtto = getQUERY("dtto");
	$vozilo = getQUERY("vozilo");
	$sofer = getQUERY("sofer");
	$alarm = getQUERY("alarm");
	$poiid = getQUERY("poiid");
	if($alarm == "/")
		$alarm = 0;
	/*echo "name=".$name."<br/>";
	echo "dtfrom=".$dtfrom."<br/>";
	echo "dtto=".$dtto."<br/>";
	echo "vozilo=".$vozilo."<br/>";
	echo "sofer=".$sofer."<br/>";
	echo "alarm=".$alarm."<br/>";
	echo "poiid=".$poiid."<br/>";
	exit;*/
	$user_id = session("user_id");
	opendb();
	
	$dsAll = query("select u.cityid, defaultmap, datetimeformat, timezone, metric, cl.clienttypeid, ci.latitude, ci.longitude, cl.allowedrouting, cl.allowedfm, cl.allowedmess, cl.allowedalarms from users u left outer join clients cl on cl.id = u.clientid left outer join cities ci on ci.id = cl.cityid where u.id = " . session("user_id"));
	$clientUnit = pg_fetch_result($dsAll, 0, "metric");;//dlookup("select metric from users where id=" . session("user_id"));
	$datetimeformat = pg_fetch_result($dsAll, 0, 'datetimeformat');
	$datfor = explode(" ", $datetimeformat);
	$dateformat = $datfor[0];
	$timeformat =  $datfor[1];
	if ($timeformat == 'h:i:s') $timeformat = $timeformat . " A";
	if ($timeformat == "H:i:s") {
		$tf = " H:i";
	}	else {
		$tf = " h:i A";
	}
	$datejs = str_replace('d', 'dd', $dateformat);	
	$datejs = str_replace('m', 'mm', $datejs);
	$datejs = str_replace('Y', 'yy', $datejs);

	
	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	
	//echo $tmpDT1."<br/>";
	//echo $tmpDT."<br/>";
	//exit;
	//drNalog = dsNalog.tables(0).rows(0)
?>

<body style="margin:0px 0px 0px 0px; padding:0px 0px 0px 0px" onResize="SetHeightLite()">

<div id="report-content" style="width:100%; text-align:left; height:100%; background-color:#fff; overflow-y:auto; overflow-x:hidden" class="corner5">
	
	<div style="padding: 10px 10px 10px 20px; width:100%" class="textTitle">
		<?php echo dic_("Routes.ParametarsFSearch")?>:&nbsp;
		<?php
			if($name != "") {
				?>
					<span style="font-size: 12px;"><?php echo dic_("Routes.NumberOfOrder")?>:&nbsp;<?php echo $name?></span>&nbsp;|
				<?php
			}
			if($vozilo != "0") {
				$dsVeh = query("select registration from vehicles where id=" . $vozilo);
				?>
					<span style="font-size: 12px;"><?php echo dic_("Routes.Vehicle") ?>:&nbsp;<?php echo pg_fetch_result($dsVeh, 0, "registration")?></span>&nbsp;|
				<?php
			}
			if($sofer != "0") {
				$dsDriv = query("select fullname from drivers where id=" . $sofer);
				?>
					<span style="font-size: 12px;"><?php echo dic_("Routes.Driver") ?>:&nbsp;<?php echo pg_fetch_result($dsDriv, 0, "fullname")?></span>&nbsp;|
				<?php
			}
			if($alarm != "0") {
				?>
					<span style="font-size: 12px;"><?php echo dic_("Routes.AlarmNumber") ?>:&nbsp;<?php echo $alarm?></span>&nbsp;|
				<?php
			}
			if($poiid != "") {
				$dspoi = query("select name from pointsofinterest where active='1' and id=" . $poiid);
				?>
					<span style="font-size: 12px;"><?php echo dic_("Routes.Poi")?>:&nbsp;<?php echo pg_fetch_result($dspoi, 0, "name")?></span>
				<?php
			}
			
		?>
	</div>
    <div class="corner5" style="width:<?php if($yourbrowser == "1") { echo '98%'; } else { echo '96.5%'; } ?>; border:1px solid #bbb; background-color:#fafafa; margin-left:1%">
		<?php
		
			$sqlRR = "select * from gethistoryofroutes('" . $name . "', '" . $dtfrom . " 00:00:00','" . $dtto . " 23:59:59','" . $vozilo . "','" . $sofer . "', '" . $alarm . "','" . $poiid . "','" . $user_id . "')";
			//echo $sqlRR;
			//exit;
			$dsPre = query($sqlRR);
			$lasttid = 0;
			$currtid = 0;
			while($row = pg_fetch_array($dsPre))
			{
				$border = "#009900";
				$bck = "#DBFDEA";
				// dim border as string = "#990000"  'RED
				// dim bck as string = "#FED6DC"		'RED
				$str = "";
				$currtid = $row["tourid"];
				$stoenje = query("select sec2time1(" . $row["diff"] . ") diff");
				$tin = new DateTime($row["timein"]);
				$tin = $tin->format("H:i:s");
				$tout = new DateTime($row["timeout"]);
				$tout = $tout->format("H:i:s");
				if(trim($row["timein"]) != "")
				{
					$str = "<span class='clearRow' id='" . $row["tourid"] . "_" . $row["poiid"] . "' style='float:right; font-size:11px'>".dic_("Routes.OrdinalNumber") .": <span style='color:#000'>" . $row["rbr1"] . "</span>&nbsp;&nbsp;&nbsp;". dic_("Routes.Arrival").  ": <span style='color:#040'>" . $tin . "</span>&nbsp;&nbsp;&nbsp;" . dic_("Routes.Departure"). ": <span style='color:#800'>" . $tout . "</span>&nbsp;&nbsp;&nbsp;". dic_("Routes.Idling").": <span style='color:#800'>" . pg_fetch_result($stoenje, 0, "diff") . "</span></span>";
				} else {
					$str = "<span class='clearRow' id='" . $row["tourid"] . "_" . $row["poiid"] . "' style='float:right; font-size:11px'></span>";
				}
				?>
				<?php
				if($currtid != $lasttid)
				{
					$SdtTmp = new Datetime($row["startdate"]);
					$SdtTmp = $SdtTmp->format($tf . " " . $dateformat);
				?>
				<br />
				<div class="corner5 text5" style="font-size:16px; width:<?php if($yourbrowser == "1") { echo '92.3%'; } else { echo '96%'; } ?>; padding:5px 5px 5px 5px; border:1px solid #009900; background-color:#DBFDEA; margin-left:20px">
					<strong><?php echo $row["vozilo"]?></strong><strong style="float:right"><?php echo dic_("Routes.OrderNumber")?>: <?php echo $row["tourid"]?>&nbsp;&nbsp;&nbsp;</strong>
					<!--button onClick="LoadRouteLive(<?php echo $row["tourid"]?>, <?php echo $row["tourid"]?> + 'Test')" class="text5" style="font-size:11px; margin-left:5px">Mapa</button-->
					<br>
					<table style="font-size:11px;" border="0" width="100%">
					<tr>
						<td width="210px" style="text-align: right"><?php echo dic_("Tracking.BeginningOrder")?>: <strong style="color:#800"><?php echo $SdtTmp ?></strong></td>
						<td width="24%" style="padding-left: 5px;"><?php echo dic_("Routes.CreatedBy")?>: <strong style="color:#800"><?php echo $row["korisnik"]?></strong></td>
						<td width="24%" style="padding-left: 10px;"><?php echo dic_("Reports.Total")?> <?php if($clientUnit == "mi") { echo dic("Route.Miles"); } else { echo dic("Fm.Km");} ?>: <strong style="color:#800"><?php echo number_format((float)$row["totalkm"], 2, '.', '')?>&nbsp;<?php if($clientUnit == "mi") { echo dic("Route.Miles"); } else { echo "km";} ?></strong></td>
						<td width="24%" style="padding-left: 10px;"><?php echo dic_("Reports.TotalTime")?>: <strong style="color:#800"><?php echo Sec2Str1($row["totaltime"])?></strong></td>
					</tr>
					<tr>
						<td style="text-align: right"><?php echo dic_("Routes.EndOrder")?>: <strong style="color:#800;"><?php echo $SdtTmp ?></strong></td>
						<td colspan="3" style="padding-left: 5px;">
							<table cellpadding="0" width="98%" style="font-size:11px; border-top: 1px solid #009900; border-bottom: 1px solid #009900;" cellspacing="0" border="0">
						  		<tr>
									<td align="left" valign="top"><?php echo dic_("Tracking.FirstUser")?>: <strong style="color:#800"><?php echo $row["s1"]?></strong>
										
									</td>
									<?php
									  	if($row["s2"] != "")
										{
											?>
											<td style="padding-left: 10px" align="left" valign="top"><?php echo dic_("Tracking.SecondUser")?>: <strong style="color:#800"><?php echo $row["s2"]?></strong>
												
											</td>
											<?php
										}
										if($row["s3"] != "")
										{
											?>
											<td style="padding-left: 10px" align="left" valign="top"><?php echo dic_("Tracking.ThirdUser")?>: <strong style="color:#800"><?php echo $row["s3"]?></strong>
												
											</td>
											<?php
										}
								  	?>
								</tr>
							</table>
						</td>
						<!--td style="padding-left: 10px;">Прв Возач: <strong style="color:#800"><?php echo $row["sofer1"]?>&nbsp;&nbsp;&nbsp;&nbsp;</strong>Втор Возач: <strong style="color:#800"><?php echo $row["sofer2"]?>&nbsp;&nbsp;&nbsp;&nbsp;</strong>Трет Возач: <strong style="color:#800"><?php echo $row["sofer3"]?></strong></td-->
					</tr>
					<?php
			  			if($row["tostay"] != "0")
						{
					  	?>
						  <tr>
							<td align="left" style="padding-left: 10px;" colspan="4" valign="middle" class="style2"><?php echo dic_("Tracking.RetentionTimeLocation")?>: <strong style="color:#800"><?php echo $row["tostay"]?>&nbsp;<?php echo dic_("Settings.Min")?></strong></td>
						  </tr>
					  	<?php
					  	}
				  	if($row["pause1"] != "0")
					{
					  ?>
					  <tr>
					  	<td colspan="4" style="padding-left: 10px;">
							<table cellpadding="0" style="font-size:11px;" cellspacing="0" border="0">
								<tr>
									<td class="style2"><?php echo dic_("Tracking.FirstPause")?>: <strong style="color:#800"><?php echo $row["pause1"]?>&nbsp;min</strong></td>
									<?php
									  	if($row["pause2"] != "0")
										{
											?>
											<td style="padding-left: 30px" class="style2"><?php echo dic_("Tracking.SecondtPause")?>: <strong style="color:#800"><?php echo $row["pause2"]?>&nbsp;<?php echo dic_("Settings.Min")?></strong></td>
											<?php
										}
										if($row["pause3"] != "0")
										{
											?>
											<td style="padding-left: 30px" class="style2"><?php echo dic_("Tracking.ThirdPause")?>: <strong style="color:#800"><?php echo $row["pause3"]?>&nbsp;<?php echo dic_("Settings.Min")?></strong></td>
											<?php
										}
										if($row["pause4"] != "0")
										{
											?>
											<td style="padding-left: 30px" class="style2"><?php echo dic_("Tracking.FourthPause")?>: <strong style="color:#800"><?php echo $row["pause4"]?>&nbsp;<?php echo dic_("Settings.Min")?></strong></td>
											<?php
										}
										if($row["pause5"] != "0")
										{
											?>
											<td style="padding-left: 30px" class="style2"><?php echo dic_("Tracking.FifthPause")?>: <strong style="color:#800"><?php echo $row["pause5"]?>&nbsp;<?php echo dic_("Settings.Min")?></strong></td>
											<?php
										}
								  	?>
								</tr>
							</table>
						</td>
						<!--td height="30px" align="left" valign="middle" class="style2">Прва Пауза: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "pause1")?>&nbsp;min</strong></td>
						<td height="30px" align="right" valign="middle" class="style2">&nbsp;</td-->
					  	</tr>
					  <?php } 
					  if(session("client_id") == 367)
						{ ?>
					  	<tr>
							<td width="210px" style="padding-left: 10px;">Култура: <strong style="color:#800"><?php echo $row["culture"]?></strong></td>
							<td style="padding-left: 10px;">Операција: <strong style="color:#800"><?php echo $row["operation"]?></strong></td>
							<td style="padding-left: 10px;">Материјал: <strong style="color:#800"><?php echo $row["material"]?></strong></td>
							<td style="padding-left: 10px;">Прикл. механизација: <strong style="color:#800"><?php echo $row["mechanization"]?></strong></td>
						</tr>
					  <?php }?>
				</table>
					<!--span style="font-size:11px; margin-left:<?php if($yourbrowser == "1") { echo '1px'; } else { echo '30px'; } ?>; ">Почеток на налогот: <strong style="color:#800"><?php echo $row["startdate"]?></strong></span>
					<span style="font-size:11px; margin-left:<?php if($yourbrowser == "1") { echo '10px'; } else { echo '30px'; } ?>; ">Креиран од: <strong style="color:#800"><?php echo $row["korisnik"]?></strong></span>				
					<span style="font-size:11px; margin-left:<?php if($yourbrowser == "1") { echo '10px'; } else { echo '30px'; } ?>; ">Прв Возач: <strong style="color:#800"><?php echo $row["s1"]?>&nbsp;&nbsp;&nbsp;&nbsp;</strong>Втор Возач: <strong style="color:#800"><?php echo $row["s2"]?>&nbsp;&nbsp;&nbsp;&nbsp;</strong>Трет Возач: <strong style="color:#800"><?php echo $row["s3"]?></strong></span><br>
					<span style="font-size:11px; margin-left:52px; ">Крај на налогот: <strong style="color:#800;"><?php echo $row["startdate"]?></strong></span-->
				</div>
				<?php
				}
				?>
				<div class="corner5 text5" style="font-size:12px; width:<?php if($yourbrowser == "1") { echo '89.5%'; } else { echo '92%'; } ?>; padding:2px 2px 2px 5px; border:1px solid #CCCCCC; background-color:#F3F3F3; margin-left:<?php if($yourbrowser == "1") { echo '30px'; } else { echo '50px'; } ?>; margin-top:5px">
					<?php echo $row["rbr"]?>.&nbsp;&nbsp;&nbsp;<?php echo $row["name"]?>
					<?php echo $str?>
				</div>
			
		<?php
				$lasttid = $currtid;
			}
		?>
		<br />
	</div>		
</div>
</body>
</html>

<?php
	closedb();
?>