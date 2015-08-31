<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/javascript">
		lang = '<?php echo $cLang?>';
		
	</script>
<?php

	$id = getQUERY("id");
	opendb();
	$sqlP = "";
	$sqlP .= "select '('||v.Code ||') - '|| v.Registration vozilo, d1.FullName sofer1, d2.FullName sofer2, d3.FullName sofer3, h.Datetime, h.startdate, u.FullName korisnik, u.metric, ";
	$sqlP .= " h.tostay, h.pause1, h.pause2, h.pause3, h.pause4, h.pause5, h.totalkm, h.totaltime, cli.name clientname, rc.name culture, ro.name operation, rmat.name material, rmech.name mechanization ";
	$sqlP .= "from rNalogHeder h ";
	$sqlP .= "left outer join Vehicles v on v.ID=h.vehicleID ";
	$sqlP .= "left outer join Drivers d1 on h.DriverId1=d1.ID ";
	$sqlP .= "left outer join Drivers d2 on h.DriverId2=d2.ID ";
	$sqlP .= "left outer join Drivers d3 on h.DriverId3=d3.ID ";
	$sqlP .= "left outer join Users u on u.id=h.userID ";
	$sqlP .= "left outer join route_defculture rdc on rdc.id=h.culid ";
	$sqlP .= "left outer join route_culture rc on rc.id=rdc.culid ";
	$sqlP .= "left outer join route_operation ro on ro.id=rdc.operid ";
	$sqlP .= "left outer join route_material rmat on rmat.id=rdc.matid ";
	$sqlP .= "left outer join route_mechanisation rmech on rmech.id=rdc.mechid ";
	$sqlP .= "left outer join clients cli on cli.id=u.clientid ";
	$sqlP .= "where h.id=" . $id;
	$dsNalog = query($sqlP);	
	
	//echo $sqlP;
	//exit;
?>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif; font-size: 16px;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif; font-size: 12px;
}
.style3 {
	font-family: Arial, Helvetica, sans-serif; font-size: 14px;
}

-->
</style>
<body style="background-color:#FFFFFF">
<br />
<button onClick="window.print()" style="margin-left:17px"><?php echo dic_("Routes.Print")?></button><br>&nbsp;
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td style="border:1px solid #999999;" height="1000px" align="center" valign="top">
			<table width="700" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td colspan="2" align="center" valign="middle" class="style1"><?php echo dic_("Routes.TravelOrderNumber")?>: <strong style="font-size:36px"><?php echo $id?></strong></td>
			  </tr>
			  <tr>
				<td colspan="2" align="center" valign="middle" class="style1">&nbsp;</td>
			  </tr>
			  <tr>
				<td height="30px" width="50%" align="left" valign="middle" class="style2"><?php echo dic_("Routes.Vehicle")?>: <strong class="style3">&nbsp;<?php echo pg_fetch_result($dsNalog, 0, "vozilo")?></strong></td>
				<td height="30px" width="50%" align="right" valign="middle" class="style2"><?php echo dic_("Routes.DateOfProduction")?>: <strong>
					<?php 
						$SdtTmp = new Datetime(pg_fetch_result($dsNalog, 0, "datetime"));
						$SdtTmp = $SdtTmp->format("H:i:s d-m-Y");
						echo $SdtTmp;
						$SdtTmp11 = new Datetime(pg_fetch_result($dsNalog, 0, "startdate"));
						$SdtTmp11 = $SdtTmp11->format("H:i:s d-m-Y");
						?></strong> </td>
			  </tr>
			  <tr>
			  	<td height="30px" align="left" valign="middle" class="style2"><?php echo dic_("Reports.Company")?>: <strong><?php echo pg_fetch_result($dsNalog, 0, "clientname")?></td>
				<td height="30px" align="right" valign="middle" class="style2"><?php echo dic_("Routes.StartARoute")?>: <strong><?php echo $SdtTmp11?></strong></td>
			  </tr>
			  
			  <tr>
			  	<td height="30px" align="left" valign="middle" class="style2"><?php echo dic_("Routes.PreparedBy")?>: <strong><?php echo pg_fetch_result($dsNalog, 0, "korisnik")?></strong></td>
			  	<?php
			  	if(pg_fetch_result($dsNalog, 0, "tostay") != "0")
				{
			  	?>
				<td height="30px" align="right" valign="middle" class="style2"><?php echo dic_("Tracking.RetentionTimeLocation")?>: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "tostay")?>&nbsp;<?php echo dic_("Settings.Min")?></strong></td>
				<?php
			  	}
			  	?>
			  </tr>
			  <tr>
			  	<td colspan="2" style="padding-bottom: 8px;">
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
							<td height="30px" align="left" valign="middle" class="style2"><?php echo dic_("Tracking.FirstUser")?>: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "sofer1")?></strong></td>
							<?php
							  	if(pg_fetch_result($dsNalog, 0, "sofer2") != "")
								{
									?>
									<td height="30px" align="left" valign="middle" class="style2"><?php echo dic_("Tracking.SecondUser")?>: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "sofer2")?></strong></td>
									<?php
								}
								if(pg_fetch_result($dsNalog, 0, "sofer3") != "")
								{
									?>
									<td height="30px" align="left" valign="middle" class="style2"><?php echo dic_("Tracking.ThirdUser")?>: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "sofer3")?></strong></td>
									<?php
								}
						  	?>
						</tr>
					</table>
				</td>
			</tr>
			  <?php
			  	if(pg_fetch_result($dsNalog, 0, "pause1") != "0")
				{
			  ?>
			  <tr>
			  	<td colspan="2" style="padding-bottom: 8px;">
					<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
							<td class="style2"><?php echo dic_("Tracking.FirstPause")?>: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "pause1")?>&nbsp;<?php echo dic_("Settings.Min")?></strong></td>
							<?php
							  	if(pg_fetch_result($dsNalog, 0, "pause2") != "0")
								{
									?>
									<td class="style2"><?php echo dic_("Tracking.SecondtPause")?>: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "pause2")?>&nbsp;<?php echo dic_("Settings.Min")?></strong></td>
									<?php
								}
								if(pg_fetch_result($dsNalog, 0, "pause3") != "0")
								{
									?>
									<td class="style2"><?php echo dic_("Tracking.ThirdPause")?>: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "pause3")?>&nbsp;<?php echo dic_("Settings.Min")?></strong></td>
									<?php
								}
								if(pg_fetch_result($dsNalog, 0, "pause4") != "0")
								{
									?>
									<td class="style2"><?php echo dic_("Tracking.FourthPause")?>: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "pause4")?>&nbsp;<?php echo dic_("Settings.Min")?></strong></td>
									<?php
								}
								if(pg_fetch_result($dsNalog, 0, "pause5") != "0")
								{
									?>
									<td class="style2"><?php echo dic_("Tracking.FifthPause")?>: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "pause5")?>&nbsp;<?php echo dic_("Settings.Min")?></strong></td>
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
					<td height="30px" width="50%" align="left" valign="middle" class="style2">Култура: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "culture")?></strong></td>
					<td height="30px" width="50%" align="right" valign="middle" class="style2">Операција: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "operation")?></strong></td>
				</tr>
				<tr>
					<td style="padding-bottom: 20px;" height="30px" width="50%" align="left" valign="middle" class="style2">Материјал: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "material")?></strong></td>
					<td style="padding-bottom: 20px;" height="30px" width="50%" align="right" valign="middle" class="style2">Прикл. механизација: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "mechanization")?></strong></td>
				</tr>
			  <?php }
			  ?>
				<tr>
			    <td height="30px" colspan="2" align="center" valign="middle" class="style2">
					<strong class="style2"><?php echo dic_("Routes.LocationToVisit")?></strong><br />
					<table width="650" border="1">
						<tr>
							<td width="50px" height="22px" class="style2" style="border:1px solid #666666; background-color:#CCCCCC" align="center"><strong><?php echo dic_("Routes.Rbr")?></strong></td>
							<td width="300px" height="22px" class="style2" style="border:1px solid #666666; background-color:#CCCCCC; text-align: center">&nbsp;<strong><?php echo dic_("Reports.Location")?></strong></td>
							<td width="300px" height="22px" class="style2" style="border:1px solid #666666; background-color:#CCCCCC; text-align: center;">&nbsp;<strong><?php echo dic_("Reports.Distance")?></strong></td>
							<td width="300px" height="22px" class="style2" style="border:1px solid #666666; background-color:#CCCCCC; text-align: center;">&nbsp;<strong><?php echo dic_("Reports.Vreme")?></strong></td>
							<td width="300px" height="22px" class="style2" style="border:1px solid #666666; background-color:#CCCCCC; text-align: center;">&nbsp;<strong><?php echo dic_("Tracking.Note")?></strong></td>							
						</tr>					
						<?php
							
							$dsDet = query("select * from rNalogDetail nd left outer join pointsofinterest poi on poi.id=nd.ppid where nd.HederID=" . $id . " and poi.active='1' order by rbr");
							
							while($row = pg_fetch_array($dsDet))
							{
						?>
						<tr>
							<td width="50px" height="22px" class="style2" style="border:1px solid #666666" align="center"><?php echo $row["rbr"]?></td>
							<td width="300px" height="22px" class="style2" style="border:1px solid #666666">&nbsp;<?php echo $row["opis"]?></td>
							<td width="300px" height="22px" class="style2" style="border:1px solid #666666; text-align: center;"><?php echo number_format((float)$row["poikm"], 2, '.', '')?>&nbsp;<?php if(pg_fetch_result($dsNalog, 0, "metric") == "mi") { echo dic("Route.Miles"); } else { echo "km";} ?></td>
							<td width="300px" height="22px" class="style2" style="border:1px solid #666666; text-align: center;"><?php echo Sec2Str1($row["poitime"]) ?></td>
							<td width="300px" height="22px" class="style2" style="border:1px solid #666666">&nbsp;</td>							
						</tr>											
						<?php
							}
							if(pg_fetch_result($dsNalog, 0, "pause1") != "0")
							{
								?>
								<tr>
									<td width="50px" height="22px" class="style2" style="border:1px solid #666666" align="center">&nbsp;</td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666">&nbsp;<?php echo dic_("Tracking.FirstPause")?>: </td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666; text-align: center;">/</td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666; text-align: center;"><?php echo Sec2Str1(pg_fetch_result($dsNalog, 0, "pause1")*60)?></td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666">&nbsp;</td>							
								</tr>	
								<?php
							}
							if(pg_fetch_result($dsNalog, 0, "pause2") != "0")
							{
								?>
								<tr>
									<td width="50px" height="22px" class="style2" style="border:1px solid #666666" align="center">&nbsp;</td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666">&nbsp;<?php echo dic_("Tracking.SecondtPause")?>: </td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666; text-align: center;">/</td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666; text-align: center;"><?php echo Sec2Str1(pg_fetch_result($dsNalog, 0, "pause2")*60)?></td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666">&nbsp;</td>							
								</tr>	
								<?php
							}
							if(pg_fetch_result($dsNalog, 0, "pause3") != "0")
							{
								?>
								<tr>
									<td width="50px" height="22px" class="style2" style="border:1px solid #666666" align="center">&nbsp;</td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666">&nbsp;<?php echo dic_("Tracking.ThirdPause")?>: </td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666; text-align: center;">/</td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666; text-align: center;"><?php echo Sec2Str1(pg_fetch_result($dsNalog, 0, "pause3")*60)?></td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666">&nbsp;</td>							
								</tr>	
								<?php
							}
							if(pg_fetch_result($dsNalog, 0, "pause4") != "0")
							{
								?>
								<tr>
									<td width="50px" height="22px" class="style2" style="border:1px solid #666666" align="center">&nbsp;</td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666">&nbsp;<?php echo dic("Tracking.FourthPause")?>: </td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666; text-align: center;">/</td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666; text-align: center;"><?php echo Sec2Str1(pg_fetch_result($dsNalog, 0, "pause4")*60)?></td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666">&nbsp;</td>							
								</tr>	
								<?php
							}
							if(pg_fetch_result($dsNalog, 0, "pause5") != "0")
							{
								?>
								<tr>
									<td width="50px" height="22px" class="style2" style="border:1px solid #666666" align="center">&nbsp;</td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666">&nbsp;<?php echo dic("Tracking.FifthPause")?>: </td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666; text-align: center;">/</td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666; text-align: center;"><?php echo Sec2Str1(pg_fetch_result($dsNalog, 0, "pause5")*60)?></td>
									<td width="300px" height="22px" class="style2" style="border:1px solid #666666">&nbsp;</td>							
								</tr>	
								<?php
							}
						?>
						<tr>
							<td width="50px" height="22px" class="style2" style="border:1px solid #666666">&nbsp;</td>	
							<td width="300px" height="22px" class="style2" style="border:1px solid #666666; text-align: right; padding-right: 10px;"><strong><?php echo dic("Reports.Total")?>:</strong></td>
							<td width="300px" height="22px" class="style2" style="border:1px solid #666666; text-align: center;"><?php echo number_format((float)pg_fetch_result($dsNalog, 0, "totalkm"), 2, '.', '') ?>&nbsp;<?php if(pg_fetch_result($dsNalog, 0, "metric") == "mi") { echo dic("Route.Miles"); } else { echo "km";} ?></td>	
							<td width="300px" height="22px" class="style2" style="border:1px solid #666666; text-align: center;"><?php echo Sec2Str1(pg_fetch_result($dsNalog, 0, "totaltime"))?></td>	
							<td width="300px" height="22px" class="style2" style="border:1px solid #666666">&nbsp;</td>	
						</tr>	
				  </table><br />&nbsp;</td>
		      </tr>
			  <tr>
			    <td height="30px" align="center" valign="middle" class="style2">
				</td>
				<td height="30px" align="center" valign="middle" class="style2">
				  ________________________________<br /><?php echo dic_("Routes.Signature")?> 
				</td>
				
		      </tr>
			  <tr>
			    <td height="30px" colspan="2" align="center" valign="middle" class="style2">&nbsp;</td>
		      </tr>
			</table>
		</td>
	</tr>
</table>
</body>