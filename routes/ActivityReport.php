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
	if (session('user_id') == "261") echo header( 'Location: ../sessionexpired/?l='.$cLang);
	opendb();
	$Allow = getPriv("routescurrent", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
    $user_id = Session("user_id");
	
	$dsAll = query("select defaultmap, datetimeformat, timezone, metric, cl.clienttypeid, ci.latitude, ci.longitude from users u left outer join clients cl on cl.id = u.clientid left outer join cities ci on ci.id = cl.cityid where u.id = " . $user_id);

    $clientType = pg_fetch_result($dsAll, 0, "clienttypeid");
	//if($clienttypeid!= "4")
		//echo header ('Location: ../permission/?l=' . $cLang);
    $clientUnit = pg_fetch_result($dsAll, 0, "metric");

	$user_id = Session("user_id");
	$client_id = Session("client_id");
	$roleid = Session("role_id");
	
   $ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
    
?>

<body style="margin:0px 0px 0px 0px; padding:0px 0px 0px 0px" onResize="SetHeightLite()">

<div id="report-content" style="width:100%; text-align:left; height:85%; background-color:#fff; overflow-y:auto; overflow-x:hidden" class="corner5">
	<div style="padding-left:40px; padding-top:10px; width:500px" class="textTitle">
		<?= dic("Routes.RouteAct")?>&nbsp;&nbsp;&nbsp;&nbsp;
	</div><br>
    
    
	<div class="corner5" style="margin-bottom:16px; position: relative; z-index: 99; width:95%; padding:10px 10px 10px 10px; border:1px solid #bbb; background-color:#fafafa; margin-left:1%">
			<div style="position: relative; width: 100%; padding: 18px 0px 50px 0px;">
				<div style="width: 331px; position: relative; float: left;">
					<span class="text2" style="margin-left: 20px;"><?php echo dic_("Routes.From")?>:</span>&nbsp;
					<input id="txtSDate" type="text" width="80px" class="textboxCalender corner5 text2" value="<?php echo DateTimeFormat(addDay(-1), 'd-m-Y')?>" style="width: 105px;position: relative; top: -1px; margin-left: 5px"/>
					<span class="text2" style="margin-left: 5px;"><?php echo dic_("Routes.To")?>:</span>&nbsp;
					<input id="txtEDate" type="text" width="80px" class="textboxCalender corner5 text2" value="<?php echo DateTimeFormat(addDay(-1), 'd-m-Y')?>" style="width: 105px;position: relative; top: -1px; margin-left: 5px"/>
				</div>
				
				<div style="width: 232px; position: relative; float: left; margin-left: 4px;">
					<span class="text2" style="margin-left: 20px;"><?php echo dic_("Routes.Vehicle")?>:</span>&nbsp;
					<select id="selVeh" class="combobox text2" style="width: 160px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;">
						<?php
						if ($roleid == "2") { 
					        $sqlV = "select * from vehicles where clientID=" . $client_id . " and active='1' order by cast(code as integer) asc";
						} else {
							$sqlV = "select * from vehicles where id in (select vehicleID from uservehicles uv left outer join vehicles v on v.id=uv.vehicleid where userID=" . $user_id . " and v.active='1')  order by cast(code as integer) asc";
						}
						$dsVehicles = query($sqlV);
						while ($drVehicle = pg_fetch_array($dsVehicles)) {
							?>
							<option value='<?= $drVehicle["id"]?>'><?= $drVehicle["registration"] . ' ( ' . $drVehicle["code"] . ' )' ?></option>
							<?php
						}
						?>
					</select>
				</div>
				
				<div style="width: 232px; position: relative; float: left; margin-left: 4px;">
					<span class="text2" style="margin-left: 20px;"><?= dic("Settings.Culture")?>:</span>&nbsp;
					<select id="selCul" class="combobox text2" style="width: 160px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;">
						<option value='0'>- <?= dic("Routes.SelectCulture")?> -</option>
						<?php
						
					    $sqlC = "select * from route_culture where clientid = " . $client_id . " order by name asc";
						
						$dsCultures = query($sqlC);
						while ($drCulture = pg_fetch_array($dsCultures)) {
							?>
							<option value='<?= $drCulture["id"]?>'><?= $drCulture["name"]?></option>
							<?php
						}
						?>
					</select>
				</div>
				
				<div style="width: 110px; position: relative; float: left; margin-left: 30px; top:2px">
					<input type="text" onclick="loadreport()" readonly="true" id="searchtour" value="<?= dic("show")?>" style="width: 70px; margin-left: 20px;" />
				</div>
			</div>
			
			
			<div id="content"></div>
		</div>
	</div>
</body>
</html>



<script type="text/javascript">
$('#searchtour').button();
SetHeightLite()
iPadSettingsLite()
top.HideLoading()

$('#txtSDate').datepicker({
			dateFormat: 'dd-mm-yy',
			showOn: "button",
			buttonImage: "../images/cal1.png",
			buttonImageOnly: true,
			
		});
$('#txtEDate').datepicker({
			dateFormat: 'dd-mm-yy',
			showOn: "button",
			buttonImage: "../images/cal1.png",
			buttonImageOnly: true,
			
		});

if (Browser()=='iPad') {top.iPad_Refresh()}

//stoenje
$(document).ready(function () {
    $('#div-map').css({ height: '402px' });
    loadreport();
    
    //top.HideWait();
});
//top.ShowWait();
//$("#content").load('ActivityReportContent.php?vehid=2495&culid=0&sd=01-03-2014&ed=03-03-2014');
function loadreport() {
	$("#content").html('');
	top.ShowWait();
	 $("#content").load('ActivityReportContent.php?vehid=' + $("#selVeh").val() + '&culid=' + $("#selCul").val() + '&sd=' + $('#txtSDate').val() + '&ed=' + $('#txtEDate').val() + '&l=' + lang);
}


</script>