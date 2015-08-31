<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="print.css" type="text/css" media="print" />
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.8.14.custom.css">	

	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>

	<script type="text/javascript" src="../js/iScroll.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="routes.js"></script>
	
<?php

	$id = getQUERY("id");
	opendb();
	$sqlP = "";
	$sqlP .= "select '('||v.Code ||') - '|| v.Registration vozilo, d1.FullName sofer1, d2.FullName sofer2, d3.FullName sofer3, d4.FullName sofer4, d1.jobposition jobpos1, d2.jobposition jobpos2, d3.jobposition jobpos3, d4.jobposition jobpos4, w1.name weapon1, w2.name weapon2, w3.name weapon3, w4.name weapon4, j1.name job1, j2.name job2, j3.name job3, j4.name job4, h.Datetime, h.startdate, u.FullName korisnik, u.metric, ";
	$sqlP .= " h.tostay, h.pause1, h.pause2, h.pause3, h.pause4, h.pause5, h.totalkm, h.totaltime, cli.name clientname, rc.name culture, ro.name operation, rmat.name material, rmech.name mechanization ";
	$sqlP .= "from rNalogHeder h ";
	$sqlP .= "left outer join Vehicles v on v.ID=h.vehicleID ";
	$sqlP .= "left outer join Drivers d1 on h.DriverId1=d1.ID ";
	$sqlP .= "left outer join Drivers d2 on h.DriverId2=d2.ID ";
	$sqlP .= "left outer join Drivers d3 on h.DriverId3=d3.ID ";
	$sqlP .= "left outer join Drivers d4 on h.DriverId4=d4.ID ";
	$sqlP .= "left outer join jobs j1 on h.job1=j1.id ";
	$sqlP .= "left outer join jobs j2 on h.job2=j2.id ";
	$sqlP .= "left outer join jobs j3 on h.job3=j3.id ";
	$sqlP .= "left outer join jobs j4 on h.job4=j4.id ";
	$sqlP .= "left outer join weapons w1 on h.weaponid1=w1.id ";
	$sqlP .= "left outer join weapons w2 on h.weaponid2=w2.id ";
	$sqlP .= "left outer join weapons w3 on h.weaponid3=w3.id ";
	$sqlP .= "left outer join weapons w4 on h.weaponid4=w4.id ";
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

table.sample {
	border-width: 0px 0px 0px 0px;
	border-spacing: 0px;
	border-style: none none none none;
	border-color: white white white white;
	border-collapse: collapse;
	background-color: white;
}
table.sample th {
	border-width: 1px 1px 1px 1px;
	padding: 1px 1px 1px 1px;
	border-style: solid solid solid solid;
	border-color: black black black black; 
	background-color: white;
	-moz-border-radius: 0px 0px 0px 0px;
}
table.sample td {
	border-width: 1px 1px 1px 1px;
	padding: 1px 1px 1px 1px;
	border-style: solid solid solid solid;
	border-color: black black black black;
	background-color: white;
	-moz-border-radius: 0px 0px 0px 0px;
}
</style>


<style type="text/css">
table.sample1 {
	border-width: 1px 1px 1px 1px;
	border-spacing: 0px;
	border-style:solid solid solid solid;
	
	border-collapse: collapse;
	background-color: white;
}
table.sample1 th {
	border-width: 0px 0px 0px 0px;
	padding: 1px 1px 1px 1px;
	border-style:none none none none;
	border-color: white white white white;
	background-color: white;
	-moz-border-radius: 0px 0px 0px 0px;
}
table.sample1 td {
	border-width: 0px 0px 0px 0px;
	padding: 1px 1px 1px 1px;
	border-style: none none none none;
	border-color: white white white white;
	background-color: white;
	-moz-border-radius: 0px 0px 0px 0px;
}

@page { margin: 0; }


@media print
{
  div.break {page-break-before: always}
}
</style>
<script type="text/javascript" src="../js/jquery.js"></script>
</head>
<body style="background-color:#FFFFFF;">
<br/>
	<table id="beforeprint" border="0"  cellspacing="0"  cellpadding="0" width="94%"  align="center" ID="Table1"> 
		<tr id="rTop" valign="middle" >
			<td align=center style="padding-bottom: 5px; padding-top: 5px;">
				<input type="button" style="width: 150px;height: 20px;font-size: 12px;" value="<?php echo dic_("Routes.Print")?>" ID="btnPrint" NAME="btnPrint">
			</td>
		</tr>
	</table>
	<script>
	$(document).ready(function() {
		$('#btnPrint').click(function() {
			$('#beforeprint').css({display: 'none'});
		    window.print();
		    $('#beforeprint').css({display: ''});
		    return false;
		})
	});
	</script>
	<table class="sample1"  border="0" cellspacing="0"  cellpadding="0" width="94%"  align="center" ID="Table8" style="margin-left: 10px; margin-top: 5px;">
		<tr>
			<td>
				<img src="../images/bank.gif" width="250"/>
			</td>
			<td width="50%" align="left" ><font size="4">Наредба за спроведување на транспорт: #<?php echo $id?></font></td>
		</tr>
		<tr valign="middle" >
			<td align=center colspan="2">
				<table border="0" cellspacing="0" cellpadding="0" width="100%"  align="center" ID="Table2">                  
					<tr>
						<td width="50%" align="left"><font size = "2"><?php echo dic_("Reports.Company")?>: <span><strong contenteditable="true"><?php echo pg_fetch_result($dsNalog, 0, "clientname")?></strong></span></font></td>
						<td align="right"><font size = "2"><?php echo dic_("Tracking.Driver")?>:&nbsp;<span ><strong class="style3" contenteditable="true"><?php echo pg_fetch_result($dsNalog, 0, "sofer1")?></strong></span></font></td>
					</tr>
					<?php 
						$SdtTmp = new Datetime(pg_fetch_result($dsNalog, 0, "datetime"));
						$SdtTmp = $SdtTmp->format("H:i:s d-m-Y");
						
						$SdtTmp11 = new Datetime(pg_fetch_result($dsNalog, 0, "startdate"));
						$SdtTmp11 = $SdtTmp11->format("H:i:s d-m-Y");
						?>
					<tr>
						<td width="50%" align="left" ><font size = "2"><?php echo dic_("Routes.StartARoute")?>: <span><strong contenteditable="true"><?php echo $SdtTmp11?></strong></span></font></td>				
						<td width="50%" align="right"><font size = "2"><?php echo dic_("Routes.Vehicle")?>:&nbsp;<span ><strong class="style3" contenteditable="true">&nbsp;Tip na vozilo</strong></span></font></td>
					</tr>
					<tr>
						<td width="50%" align="left"><font size = "2"><?php echo dic_("Routes.DateOfProduction")?>:&nbsp;<span ><strong contenteditable="true"><?=$SdtTmp?></strong></span></font></td>
						<td width="50%" align="right"><font size = "2"><?php echo dic_("Registration")?>:&nbsp;<span ><strong class="style3" contenteditable="true">&nbsp;<?php echo pg_fetch_result($dsNalog, 0, "vozilo")?></strong></span></font></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table border="0" cellspacing="0" cellpadding="0" width="94%" ID="Table5" style="margin-left: 10px; margin-bottom: 5px;">
		<tr>&nbsp; </tr>
		<tr valign="middle" align="left">
			<td contenteditable="true" width="20%" height="22" valign="top" style="font-size: 11px;"><?=pg_fetch_result($dsNalog, 0, "sofer1")?></td>
			<td contenteditable="true" width="20%" height="22" valign="top" style="font-size: 11px;"><?=pg_fetch_result($dsNalog, 0, "jobpos1")?></td>
			<td contenteditable="true" width="20%" height="22" valign="top" style="font-size: 11px;"><?=pg_fetch_result($dsNalog, 0, "job1")?></td>
			<td contenteditable="true" width="20%" height="22" valign="top" style="font-size: 11px;"><?=pg_fetch_result($dsNalog, 0, "weapon1")?></td>
			<td contenteditable="true" width="20%" height="22" valign="top" align=center style="font-size: 11px;"> ____________________________ </td>
		</tr>
		<?php
		  	if(pg_fetch_result($dsNalog, 0, "sofer2") != "")
			{
				?>
				<tr valign="middle" align="left">
					<td contenteditable="true" width="20%" height="22" valign="top" style="font-size: 11px;"><?=pg_fetch_result($dsNalog, 0, "sofer2")?></td>
					<td contenteditable="true" width="20%" height="22" valign="top" style="font-size: 11px;"><?=pg_fetch_result($dsNalog, 0, "jobpos2")?></td>
					<td contenteditable="true" width="20%" height="22" valign="top" style="font-size: 11px;"><?=pg_fetch_result($dsNalog, 0, "job2")?></td>
					<td contenteditable="true" width="20%" height="22" valign="top" style="font-size: 11px;"><?=pg_fetch_result($dsNalog, 0, "weapon2")?></td>
					<td contenteditable="true" width="20%" height="22" valign="top" align=center style="font-size: 11px;"> ____________________________ </td>
				</tr>
				<?php
			}
	  	?>
	  	<?php
		  	if(pg_fetch_result($dsNalog, 0, "sofer3") != "")
			{
				?>
				<tr valign="middle" align="left">
					<td contenteditable="true" width="20%" height="22" valign="top" style="font-size: 11px;"><?=pg_fetch_result($dsNalog, 0, "sofer3")?></td>
					<td contenteditable="true" width="20%" height="22" valign="top" style="font-size: 11px;"><?=pg_fetch_result($dsNalog, 0, "jobpos3")?></td>
					<td contenteditable="true" width="20%" height="22" valign="top" style="font-size: 11px;"><?=pg_fetch_result($dsNalog, 0, "job3")?></td>
					<td contenteditable="true" width="20%" height="22" valign="top" style="font-size: 11px;"><?=pg_fetch_result($dsNalog, 0, "weapon3")?></td>
					<td contenteditable="true" width="20%" height="22" valign="top" align=center style="font-size: 11px;"> ____________________________ </td>
				</tr>
				<?php
			}
	  	?>
	  	<?php
		  	if(pg_fetch_result($dsNalog, 0, "sofer4") != "")
			{
				?>
				<tr valign="middle" align="left">
					<td contenteditable="true" width="20%" height="22" valign="top" style="font-size: 11px;"><?=pg_fetch_result($dsNalog, 0, "sofer4")?></td>
					<td contenteditable="true" width="20%" height="22" valign="top" style="font-size: 11px;"><?=pg_fetch_result($dsNalog, 0, "jobpos4")?></td>
					<td contenteditable="true" width="20%" height="22" valign="top" style="font-size: 11px;"><?=pg_fetch_result($dsNalog, 0, "job4")?></td>
					<td contenteditable="true" width="20%" height="22" valign="top" style="font-size: 11px;"><?=pg_fetch_result($dsNalog, 0, "weapon4")?></td>
					<td contenteditable="true" width="20%" height="22" valign="top" align=center style="font-size: 11px;"> ____________________________ </td>
				</tr>
				<?php
			}
	  	?>
	 </table>
	 <table border="0" cellspacing="0" cellpadding="0" width="94%" ID="Table7" style="margin-left: 10px;">
		<tr>&nbsp; </tr>
		<tr>
			<font size="2">Опис на трасата</font>
		</tr>
		<tr>&nbsp; </tr>
	</table>
	
	<table id="printtable" class="sample" border="1"  cellspacing="0" cellpadding="0" width="94%" ID="Table3" style="margin-left: 10px;">
		<tr valign="middle" align="center" >
			<td  width="4%" style="font-size: 11px;"><?php echo dic_("Routes.Rbr")?></td>
			<td  width="12%" style="font-size: 11px;"><?php echo dic_("Tracking.City")?></td>
			<td  width="36%" style="font-size: 11px;"><?php echo dic_("Routes.From")?></td>
			<td  width="12%" style="font-size: 11px;"><?php echo dic_("Tracking.City")?></td>
			<td  width="36%" style="font-size: 11px;"><?php echo dic_("Routes.To")?></td>
		</tr>
		<?php
			//echo "select opis, rbr from rNalogDetail nd left outer join pointsofinterest poi on poi.id=nd.ppid where nd.hederID=" . $id . " and poi.active='1' order by rbr";
			//exit;
			$dsDet1 = query("select *, getgeocode(st_y(st_transform(poi.geom, 4326)), st_x(st_transform(poi.geom, 4326))) address from rNalogDetail nd left outer join pointsofinterest poi on poi.id=nd.ppid where nd.HederID=" . $id . " and poi.active='1' order by rbr");
			//$row1 = pg_fetch_array($dsDet1);
			$dsDet2 = query("select *, getgeocode(st_y(st_transform(poi.geom, 4326)), st_x(st_transform(poi.geom, 4326))) address from rNalogDetail nd left outer join pointsofinterest poi on poi.id=nd.ppid where nd.HederID=" . $id . " and poi.active='1' order by rbr offset 1");
			$br = 0;
			while($row = pg_fetch_array($dsDet2))
			{
			?>
			<tr id="row_<?=($br+1)?>" valign="middle" align="center" >
				<td  width="4%" height="15" style="font-size: 11px;"><?=($br+1)?>. </td>
				<td  width="12%" height="35" align="left" valign="top" style="font-size: 11px;"><?php echo pg_fetch_result($dsDet1, $br, "address")?></td>
				<td  width="36%" height="35" align="left" valign="top" style="font-size: 11px;"><?php echo pg_fetch_result($dsDet1, $br, "opis")?></td>
				<td  width="12%" height="35" align="left" valign="top" style="font-size: 11px;"><?php echo $row["address"]?></td>
				<td  width="36%" height="35" align="left" valign="top" style="font-size: 11px;"><?php echo $row["opis"]?></td>
			</tr>
			<script>
				var rowid = 'row_<?=($br+1)?>';
				//checktoprow(rowid);
				//$($('#'+rowid).children()[2]).html($($('#'+rowid).children()[2]).html() + '  ' + $('#'+rowid)[0].offsetTop);
			</script>
			<?php
				if(($br+1).'' == '15' or intval($br+1) % 35 == 0)
				{
					?>
					</table>
					<div class="break">&nbsp;</div>
					<table id="printtable" class="sample" border="1"  cellspacing="0" cellpadding="0" width="94%" ID="Table3" style="margin-left: 10px;">
					<?php
				}
				$br++;
			}
		?>
	</table>
	<!--div class="break">&nbsp;</div-->
	<table border="0" cellspacing="0" cellpadding="0" width="94%" ID="Table6" style="margin-left: 10px;">
		<tr>&nbsp; </tr>
		<tr align="center"> 
			<td width = "33%">&nbsp; </td>
			<td width = "33%">&nbsp; </td>
			<td align ="center" width = "34%" style="font-size: 11px;"> <?php echo dic_("Routes.Signature")?></td>
		</tr>
		<tr>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
			<td>&nbsp; </td>
		</tr>
		<tr align="center" > 
			<td width = "33%">&nbsp; </td>
			<td width = "33%">&nbsp; </td>
			<td align ="center" width = "34%" style="font-size: 11px;"> _____________________ </td>
		</tr> 
	</table>
</body>