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
	
	<script type="text/javascript" src="routes.js"></script>
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
	$sd = DateTimeFormat(getQUERY('sd'), 'Y-m-d 00:00:00');
	$ed = DateTimeFormat(getQUERY('ed'), 'Y-m-d 23:59:59');
	$vehid = getQUERY('vehid');
	$culid = getQUERY('culid');
	
	opendb();
	$metric = dlookup("select metric from users where id=" . session("user_id"));
	if ($metric == 'mi') {
		$metricvalue = 0.621371;
		$metricvalue1 = 1.0936;
		$speedunit = "mph";
		$metric1 = "yards";
	}	
	else {
		$metricvalue = 1;
		$metricvalue1 = 1;
		$speedunit = "Km/h";
		$metric1 = "m";
	}    
?>

<body style="margin:0px 0px 0px 0px; padding:0px 0px 0px 0px" onResize="SetHeightLite()">
	    
	
		
<?php
$dsActivity = query("select * from findorderactivity(" . $vehid . ", " . $culid . ", '" . $sd . "', '" . $ed . "') order by orderno, rbr asc");

$cnt = 1;
$lastNalog = '';
if (pg_num_rows($dsActivity) > 0) {
	?>
	<table width="90%" cellspacing="2" cellpadding="2" border="0" align="center" style="padding-top: <?php echo $paddingTop ?>">
        <tr>
                <td valign="bottom" height="22px" style=" " class="text2" colspan=<?php echo $colspan?>>&nbsp;</td>
        </tr>
    <?php
	while ($drActivity = pg_fetch_array($dsActivity)) {
		$reg = dlookup("select registration from vehicles where id = " . $vehid);
		if ($lastNalog == '' or $lastNalog <> $drActivity["orderno"]) {
			$nalogname1 = dlookup("select name from rnalogheder where id = " . $drActivity["orderno"]);
			$culid1 = dlookup("select culid from rnalogheder where id = " . $drActivity["orderno"]);
			$culid2 = dlookup("select culid from route_defculture where id = " . $culid1);
			$culname = dlookup("select name from route_culture where id = " . $culid2);
			$nalogname = "<font style='font-size:16px'>Налог број: <strong>" . $drActivity["orderno"] . "</strong>";
			if ($nalogname1 <> "") $nalogname .= ' (<strong>' . $nalogname1 . '</strong>)</font>';
			//$culture = dlookup("select coalesce((select name from route_culture where id = " . $drActivity["culid"] . "), '/')");
			$nalogname .= "<font style='font-style:italic'><br>Култура: <strong>" . $culname . "</strong>";
			$operation = dlookup("select coalesce((select name from route_operation where id = " . $drActivity["operid"] . "), '/')");
			$nalogname .= "<font style='font-style:italic'>&nbsp;&nbsp;&nbsp;&nbsp;Операција: <strong>" . $operation . "</strong>";
			$material = dlookup("select coalesce((select name from route_material where id = " . $drActivity["matid"] . "), '/')");
			$nalogname .= "&nbsp;&nbsp;&nbsp;&nbsp;Материјал: <strong>" . $material . "</strong>";
			$mechanisation = dlookup("select coalesce((select name from route_mechanisation where id = " . $drActivity["mechid"] . "), '/')");
			$nalogname .= "&nbsp;&nbsp;&nbsp;&nbsp;Механизација: <strong>" . $mechanisation ."</strong></font>";
		?>
		
			<tr><td colspan=8 height=25px></td></tr>
			<tr>
		    	<td valign="bottom" height="29px" style="color:#fff; font-size:14px; border:1px solid #ff6633; background-color:#f7962b; padding-bottom: 5px; padding-left: 10px " class="text2" colspan="8"><?=$nalogname?></td>
			</tr>
			<tr>
				<td width="5%" height="22px" align="center" style="background-color:#E5E3E3; border:1px dotted #2f5185" class="text2"><strong><?php dic("Reports.Rbr") ?></strong></td>
				<td width="15%" height="22px" align="center" style="background-color:#E5E3E3; border:1px dotted #2f5185" class="text2"><strong><?php dic("GeoFence") ?></strong></td>
				<td width="15%" height="22px" align="center" style="background-color:#E5E3E3; border:1px dotted #2f5185" class="text2"><strong><?= dic("Routes.TotalArea")?> (ha)</strong></td>
				<td width="15%" height="22px" align="center" style="background-color:#E5E3E3; border:1px dotted #2f5185" class="text2"><strong><?= dic("Routes.DoneArea")?> (%)</strong></td>
				<td width="15%" height="22px" align="center" style="background-color:#E5E3E3; border:1px dotted #2f5185" class="text2"><strong><?= dic("Routes.TotWorkTime")?></strong></td>
				<td width="15%" height="22px" align="center" style="background-color:#E5E3E3; border:1px dotted #2f5185" class="text2"><strong><?= dic("Routes.Downtime")?></strong></td>
				<td width="15%" height="22px" align="center" style="background-color:#E5E3E3; border:1px dotted #2f5185" class="text2"><strong><?php dic("Settings.DistTrav") ?> (<?= $metric1?>)</strong></td>
				<td width="5%" height="22px" align="center" style="background-color:#E5E3E3; border:1px dotted #2f5185" class="text2"><strong></strong></td>
			</tr>
		<?php
		}
		
		
		?>
		<tr>
			<td height="22px" align="center" style="background-color:#fff; border:1px dotted #B8B8B8" class="text2"><?php echo $drActivity["rbr"]?></td>
			<td height="22px" align="center" style="background-color:#fff; border:1px dotted #B8B8B8" class="text2"><?php echo $drActivity["zonename"]?></td>
			<td height="22px" align="center" style="background-color:#fff; border:1px dotted #B8B8B8" class="text2"><?php echo round($drActivity["povrsina"]/10000, 1)?></td>
			<td height="22px" align="center" style="background-color:#fff; border:1px dotted #B8B8B8" class="text2"><?php echo round($drActivity["sraboteno"])?></td>
			<td height="22px" align="center" style="background-color:#fff; border:1px dotted #B8B8B8" class="text2"><?php echo Sec2Str2($drActivity["totaltime"])?></td>
			<td height="22px" align="center" style="background-color:#fff; border:1px dotted #B8B8B8" class="text2"><?php echo Sec2Str2($drActivity["idletime"])?></td>
			<td height="22px" align="center" style="background-color:#fff; border:1px dotted #B8B8B8" class="text2"><?php echo number_format(round($drActivity["distance"]*$metricvalue1, 1))?></td>
			<td height="22px" align="center" style="background-color:#fff; border:1px dotted #B8B8B8" class="text2">
				<img width="24" height="24" border="0" src="../images/zoom.png" style="cursor:pointer" title="<?php echo dic_("Reports.ViewOnMap")?>" onClick="OpenMapActivity('<?= session("user_id") ?>', '<?= session("client_id") ?>', '<?= DateTimeFormat($drActivity["startdate"],"d-m-Y H:i:s")?>', '<?= DateTimeFormat($drActivity["enddate"], "d-m-Y H:i:s")?>', '<?= $reg?>', '<?= $vehid?>', <?=$drActivity["zoneid"]?>)">			
			</td>
		</tr>
		<?php
		$cnt++;
		$lastNalog = $drActivity["orderno"]; 
	}
?>
</table>
<br><br>

<?php
} else {
	?>
	<br>
		<div id="noData" style="padding-left:25px; font-size:24px; font-style:italic; padding-bottom:40px" class="text4">
     		<?php dic("Reports.NoData")?>
		 </div>
	<?php
}
?>
</body>

<?php
closedb();
?>
</html>


<script>
	top.$(document).ready(function () {
	    top.HideWait();
	});
</script>
