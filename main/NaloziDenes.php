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
	
	<script type="text/javascript" src="../routes/routes.js"></script>
	<script type="text/javascript" src="./js/highcharts.src.js"></script>

	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="../js/jquery-ui.js"></script>
	<script src="../report/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="../tracking/live.js"></script>
	<script type="text/javascript" src="../tracking/live1.js"></script>
    <script type="text/javascript" src="../js/OpenLayers.js"></script>
    

</head>
<?php

	$tpoint = getQUERY("tpoint");

	if (session('user_id') == "261") echo header( 'Location: ' . $tpoint . '/sessionexpired/?l='.$cLang);
	opendb();
	$user_id = Session("user_id");
	$client_id = Session("client_id");
	$roleid = Session("role_id");
	$currDateTime = new Datetime();
	$currDateTime = $currDateTime->format("d-m-Y H:i");
	$currDateTime1 = new Datetime();
	$currDateTime1 = $currDateTime1->format("d-m-Y");
	
	$clientUnit = dlookup("select metric from users where id=" . session("user_id"));
	
	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
?>
<body style="margin:0px 0px 0px 0px; padding:0px 0px 0px 0px" onResize="SetHeightLite()">

<div id="report-content" style="width:100%; text-align:left; height:500px; background-color:#fff; overflow-y:auto; overflow-x:hidden" class="corner5">
	
	<div style="padding: 10px 10px 10px 20px; width:500px" class="textTitle">
		<?php echo dic_("Routes.TodaysOrders") ?>&nbsp;&nbsp;&nbsp;&nbsp;
	</div>
    <div class="corner5" style="width:<?php if($yourbrowser == "1") { echo '95%'; } else { echo '96.5%'; } ?>; padding:10px 10px 10px 10px; border:1px solid #bbb; background-color:#fafafa; margin-left:1%">
		<?php
			if($roleid == "2")
			{
				$sqlD = "select * from gettoursbycid(" . $client_id . ")";
			} else {
				$sqlD = "select * from gettoursbyuid(" . $user_id . ")";
			}
			//$sqlD = "select * from gettoursbycid(154)";
			$dsPre = query($sqlD);
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
				if($row["timeout"]."" != "")
				{
					$tout = new DateTime($row["timeout"]);
					$tout = $tout->format("H:i:s");
				} else {
					$tout = "/";
				}
				if(trim($row["timein"]) != "")
				{
					$str = "<span class='clearRow' id='" . $row["tourid"] . "_" . $row["poiid"] . "' style='float:right; font-size:11px'>" .  dic_("Tracking.ONumber")  .": <span style='color:#000'>" . $row["rbr1"] . "</span>&nbsp;&nbsp;&nbsp;". dic_("Tracking.Arrival"). ": <span style='color:#040'>" . $tin . "</span>&nbsp;&nbsp;&nbsp;" .dic_("Tracking.Departure") . ": <span style='color:#800'>" . $tout . "</span>&nbsp;&nbsp;&nbsp;".dic_("Tracking.Idling") .": <span style='color:#800'>" . pg_fetch_result($stoenje, 0, "diff") . "</span></span>";
				} else {
					$str = "<span class='clearRow' id='" . $row["tourid"] . "_" . $row["poiid"] . "' style='float:right; font-size:11px'></span>";
				}
				$dtTmp = new Datetime($row["startdate"]);
				$dtTmp = $dtTmp->format("H:i d-m-Y");
		
				if($currtid != $lasttid)
				{
				?>
				<br />
				<div class="corner5 text5" style="font-size:16px; width:<?php if($yourbrowser == "1") { echo '94.5%'; } else { echo '96%'; } ?>; padding:5px 5px 5px 10px; border:1px solid #009900; background-color:#DBFDEA; margin-left:<?php if($yourbrowser == "1") { echo '10px'; } else { echo '20px'; } ?>">
					<strong><?php echo $row["vozilo"]?></strong><strong style="float:right"><?php echo dic_("Tracking.OrderNum") ?>: <?php echo $row["tourid"]?>&nbsp;&nbsp;&nbsp;</strong>
					<table style="font-size:11px;" border="0" width="100%">
					<tr>
						<td width="210px" style="padding-left: 10px;">Почеток на налогот: <strong style="color:#800"><?php echo $dtTmp?></strong></td>
						<td style="padding-left: 10px;">Креиран од: <strong style="color:#800"><?php echo $row["korisnik"]?></strong></td>
						<td style="padding-left: 10px;">Вкупно <?php if($clientUnit == "mi") { echo dic("Route.Miles"); } else { echo dic("Fm.Km");} ?>: <strong style="color:#800"><?php echo number_format((float)$row["totalkm"], 2, '.', '')?>&nbsp;<?php if($clientUnit == "mi") { echo dic("Route.Miles"); } else { echo "km";} ?></strong></td>
						<td style="padding-left: 10px;">Вкупно време: <strong style="color:#800"><?php echo Sec2Str1($row["totaltime"])?></strong></td>
					</tr>
					<?php
			  			if($row["tostay"] != "0")
						{
					  	?>
						  <tr>
							<td align="left" style="padding-left: 10px;" colspan="3" valign="middle" class="style2">Време на задржување по локација: <strong id="vnz_<?php echo $row["tourid"]?>" style="color:#800"><?php echo $row["tostay"]?>&nbsp;min</strong></td>
							<td align="right" valign="middle" class="style2">&nbsp;</td>
						  </tr>
					  	<?php
					  	}
			  		?>
			  		<tr>
					  	<td colspan="4" style="padding-left: 10px;">
							<table cellpadding="0" style="font-size:11px;" cellspacing="0" border="0">
						  		<tr>
									<td align="left" valign="middle">Прв корисник: <strong style="color:#800"><?php echo $row["s1"]?></strong></td>
									<?php
									  	if($row["s2"] != "")
										{
											?>
											<td style="padding-left: 30px" align="left" valign="middle">Втор корисник: <strong style="color:#800"><?php echo $row["s2"]?></strong></td>
											<?php
										}
										if($row["s3"] != "")
										{
											?>
											<td style="padding-left: 30px" align="left" valign="middle">Трет корисник: <strong style="color:#800"><?php echo $row["s3"]?></strong></td>
											<?php
										}
								  	?>
								</tr>
							</table>
						</td>
					</tr>
					<?php
				  	if($row["pause1"] != "0")
					{
					  ?>
					  <tr>
					  	<td colspan="4" style="padding-left: 10px;">
							<table cellpadding="0" style="font-size:11px;" cellspacing="0" border="0">
								<tr>
									<td class="style2">Прва Пауза: <strong style="color:#800"><?php echo $row["pause1"]?>&nbsp;min</strong></td>
									<?php
									  	if($row["pause2"] != "0")
										{
											?>
											<td style="padding-left: 30px" class="style2">Втора Пауза: <strong style="color:#800"><?php echo $row["pause2"]?>&nbsp;min</strong></td>
											<?php
										}
										if($row["pause3"] != "0")
										{
											?>
											<td style="padding-left: 30px" class="style2">Трета Пауза: <strong style="color:#800"><?php echo $row["pause3"]?>&nbsp;min</strong></td>
											<?php
										}
										if($row["pause4"] != "0")
										{
											?>
											<td style="padding-left: 30px" class="style2">Четврта Пауза: <strong style="color:#800"><?php echo $row["pause4"]?>&nbsp;min</strong></td>
											<?php
										}
										if($row["pause5"] != "0")
										{
											?>
											<td style="padding-left: 30px" class="style2">Петта Пауза: <strong style="color:#800"><?php echo $row["pause5"]?>&nbsp;min</strong></td>
											<?php
										}
								  	?>
								</tr>
							</table>
						</td>
						<!--td height="30px" align="left" valign="middle" class="style2">Прва Пауза: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "pause1")?>&nbsp;min</strong></td>
						<td height="30px" align="right" valign="middle" class="style2">&nbsp;</td-->
					  	</tr>
					  <?php } ?>
					<!--tr><td colspan="4" style="padding-left: 10px;">Прв Возач: <strong style="color:#800"><?php echo $row["sofer1"]?>&nbsp;&nbsp;&nbsp;&nbsp;</strong>Втор Возач: <strong style="color:#800"><?php echo $row["sofer2"]?>&nbsp;&nbsp;&nbsp;&nbsp;</strong>Трет Возач: <strong style="color:#800"><?php echo $row["sofer3"]?></strong></td></tr-->
				</table>
					<!--span style="font-size:11px; margin-left:30px; ">Почеток на налогот: <strong style="color:#800"><?php echo $row["startdate"]?></strong></span>
					<span style="font-size:11px; margin-left:30px; ">Креиран од: <strong style="color:#800"><?php echo $row["korisnik"]?></strong></span>				
					<span style="font-size:11px; margin-left:30px; ">Прв Возач: <strong style="color:#800"><?php echo $row["s1"]?>&nbsp;&nbsp;&nbsp;&nbsp;</strong>Втор Возач: <strong><?php echo $row["s2"]?>&nbsp;&nbsp;&nbsp;&nbsp;</strong>Трет Возач: <strong><?php echo $row["s3"]?></strong></span><br-->
				</div>
				<?php
				}
				?>
				<div class="corner5 text5" style="font-size:12px; width:<?php if($yourbrowser == "1") { echo '90%'; } else { echo '92%'; } ?>; padding:2px 2px 2px 10px; border:1px solid #CCCCCC; background-color:#F3F3F3; margin-left:<?php if($yourbrowser == "1") { echo '28px'; } else { echo '50px'; } ?>; margin-top:5px">
					<span><?php echo $row["rbr"]?></span>.&nbsp;&nbsp;&nbsp;<?php echo $row["name"]?>
					<?php echo $str?>
				</div>
			
		<?php
				$lasttid = $currtid;
			}
		?>
		<br />
	</div>		
</div>
	<div id="div-promeni" style="display:none">
		<iframe id="frm-promeni" frameborder="0" scrolling="yes" style="width:100%; height:100%; overflow: hidden"></iframe>
	</div>
	<div id="div-print" style="display:none">
		<iframe id="frm-print" frameborder="0" scrolling="no" style="width:800px; height:1200px"></iframe>
	</div>
	<iframe id="frm-excel" frameborder="0" scrolling="no" style="display:none"></iframe>
</body>
</html>

<script type="text/javascript">
    lang = '<?php echo $cLang?>';
	SetHeightLite()
	iPadSettingsLite()
	if (Browser()=='iPad') {top.iPad_Refresh()}
	//setTimeout("LoadMaps();", 1000);
</script>