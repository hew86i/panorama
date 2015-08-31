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
    $clientType = pg_fetch_result($dsAll, 0, "clienttypeid");
    $clientUnit = pg_fetch_result($dsAll, 0, "metric");
    
    //dim allPOI as integer = dlookup("select count(*) from pinpoints where clientID=" & session("client_id"))
    //Dim allPOIs As String = "false"
    //If allPOI < 1000 Then allPOIs = "true"
	$user_id = Session("user_id");
	$client_id = Session("client_id");
	$roleid = Session("role_id");
	
	$DefMap = pg_fetch_result($dsAll, 0, "defaultmap");
    
	$currDateTime = new Datetime();
	$cdt1 = $currDateTime->format("Y-m-d");
	$currDateTime = $currDateTime->format("d-m-Y H:i");
	$currDateTime1 = new Datetime();
	$cdt2 = $currDateTime1->format("Y-m-d");
	$currDateTime1 = $currDateTime1->format("d-m-Y");
	
	$dateS = getQUERY("dateS");
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
		if($currDateTime2 != "")
		{
			$DateTime2 = date('d-m-Y',strtotime($currDateTime2));
			$DateTime2E = date('d-m-Y',strtotime($currDateTime2E));
		} else {
			$DateTime2 = date('d-m-Y',strtotime($currDateTime1));
			$DateTime2E = $DateTime2;
		}
		addlog(36, dic_('Routes.AllOrdersInPeriod') . " " . $currDateTime2 . ' 00:00:00 ' . dic_("Routes.To") . $currDateTime2E . ' 23:59:59');
	} else {
		$currDateTime2 = "";
		$currDateTime2E = "";
		$DateTime2 = "";
		$DateTime2E = "";
		addlog(36, 'Налог со број ' . $tourid);
	}
	if($currDateTime2 == "")
		$currDateTime2 = $cdt1;
	if($currDateTime2E == "")
		$currDateTime2E = $cdt2;
	
	$AllowedMaps = "11111";

    $cntz = dlookup("select count(*) from pointsofinterest where active='1' and type=2 and clientid=" . Session("client_id"));
    //$CurrentTime = DlookUP("select Convert(nvarchar(20), DATEADD(HOUR,(select timeZone from clients where ID=" . Session("client_id") . ") - 1,GETDATE()), 120) DateTime");
    $tzone = pg_fetch_result($dsAll, 0, "timezone");
    $tzone = $tzone - 1;

    $ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
    
?>

<style>
	.ui-autocomplete {
		max-height: 100px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
		/* add padding to account for vertical scrollbar */
		padding-right: 20px;
		width:300px;
	}
</style>
<script>
	function brisi(_id){
		if (confirm(dic("Routes.DeleteOrderQuestion",lang))==true) {
			$('#div-nalog-'+_id).hide( 'drop', {}, 1000);
			$.ajax({
				  url: 'delNalog.php?id=' + _id,	
				   success: function(data) {
						top.document.getElementById('ifrm-cont').src = top.document.getElementById('ifrm-cont').src;
				   }									
			});		
		}
		
	}
	
	function promeni(_id){
		document.getElementById('frm-promeni').src = 'EditNalogR.php?l='+lang +'&id='+_id
		//$('#div-promeni').dialog({ width: document.body.offsetWidth - 10, height: document.body.offsetHeight - 10 });
		$('#div-promeni').dialog({ width: '100%', height: document.body.offsetHeight - 10 });
	}
	
	function printn(_id){
		document.getElementById('frm-print').src = 'PrintNalog.php?l='+lang +'&id='+_id
		$('#div-print').dialog({width:document.body.offsetWidth - 10, height:document.body.offsetHeight - 10})
	}
	function excel(_id){
		document.getElementById('frm-excel').src = 'ExcelNalog.php?l='+lang +'&id='+_id	
	}
</script>	
<body style="margin:0px 0px 0px 0px; padding:0px 0px 0px 0px" onResize="SetHeightLite()">

<div id="report-content" style="width:100%; text-align:left; height:500px; background-color:#fff; overflow-y:auto; overflow-x:hidden" class="corner5">
	<div style="padding-left:40px; padding-top:10px; width:500px" class="textTitle">
		<?php echo dic_("Routes.AllOrders")?>&nbsp;&nbsp;&nbsp;&nbsp;
	</div><br>
    <div id="likeapopup" style="visibility: hidden; position: absolute; left: -1000px; z-index: 999; border: 2px solid Orange; width: 452px; height: 450px; background: none repeat scroll 0% 0% white;">
        <div id="div-map" style="width: 450px; height: 400px; border:1px dotted #2f5185; z-index: 1; position: relative;"></div>
	    <div id="radioBtnDiv" style="position: relative; float: left; width: 350px; top: 10px; left: 10px;">
            <input type="radio" runat="server" name="testGroup" value="1" id="test1" style="cursor:hand;width: 70px;" checked /><label id="Label1" for="test1" style="cursor:hand;" runat="server"><?php echo dic("Routes.Normal")?></label>
            <input type="radio" runat="server" name="testGroup" value="2" id="test2" style="cursor:hand;width: 70px;" /><label id="Label2" for="test2" style="cursor:hand;" runat="server"><?php echo dic("Routes.Fast")?></label>
        </div>
        <div style="position: relative; float: right; width: 70px; top: 10px; right: 10px;" onclick="closwin()">
        	<input type="text" id="Close" value="<?php echo dic("Settings.Close")?>" style="width: 70px" />
    	</div>
    </div>
    <script type="text/javascript">
        $('#test1').button();
        $('#test2').button();
        $('#Close').button();
        $("input[name='testGroup']", $('#radioBtnDiv')).change(
            function (e) {
                // your stuffs go here
                //if ($('#MarkersIN')[0].children.length > 1) {
                ReDrawRoute($(this).val());
                //}
            });
    </script>
	<div class="corner5" style="position: relative; z-index: 99; width:95%; padding:10px 10px 10px 10px; border:1px solid #bbb; background-color:#fafafa; margin-left:1%">
			<div style="position: relative; width: 100%; padding: 18px 0px 50px 33px;">
				<div style="width: 360px; position: relative; float: left;">
					<span class="text2" style="margin-left: 20px;"><?php echo dic_("Routes.From")?>:</span>&nbsp;
					<input id="txtSDate" type="text" width="80px" class="textboxCalender corner5 text2" onclick="clearvalue('1')" value="<?php echo DateTimeFormat($DateTime2, $dateformat)?>" style="width: 105px;position: relative; top: -1px; margin-left: 5px"/>
					<span class="text2" style="margin-left: 5px;"><?php echo dic_("Routes.To")?>:</span>&nbsp;
					<input id="txtEDate" type="text" width="80px" class="textboxCalender corner5 text2" value="<?php echo DateTimeFormat($DateTime2E, $dateformat)?>" style="width: 105px;position: relative; top: -1px; margin-left: 5px"/>
				</div>
				<div style="width: 5px; color: #2F5185; position: relative; font-size: 32px; top: -8px; float: left;">|</div>
				<div style="width: 250px; position: relative; float: left; margin-left: 25px;">
					<span class="text2" style="margin-left: 20px;"><?php echo dic_("Routes.NumberOfOrder")?>:</span>&nbsp;
					<input id="txttourid" type="text" width="80px" class="textboxCalender corner5 text2" onclick="clearvalue('2')" value="<?php echo $tourid?>" style="width: 105px;position: relative; top: -1px; margin-left: 5px"/>
				</div>
				<div style="width: 5px; color: #2F5185; position: relative; float: left; font-size: 32px; top: -8px;">|</div>
				<div style="width: 110px; position: relative; float: left; margin-left: 30px">
					<input type="text" onclick="loadtourbydate('<?=$dateformat?>')" readonly="true" id="searchtour" value="<?php echo dic("Routes.Search")?>" style="width: 82px; margin-left: 20px;" />
				</div>
			</div>
			<script type="text/javascript">
				$('#searchtour').button();
			</script>
			<?php
				if($roleid == "2")
				{
					if($tourid == "")
						$sqlD = "select * from gettoursbycidbydatetime(" . $client_id . ", '" . $currDateTime2 . " 00:00:00', '" . $currDateTime2E . " 23:59:59') order by tourid desc, rbr asc";
					else
						$sqlD = "select * from gettoursbycidbytourid(" . $client_id . ", " . $tourid . ") order by tourid desc, rbr asc";
				} else {
					if($tourid == "")
						$sqlD = "select * from gettoursbyuidbydatetime(" . $user_id . ", '" . $currDateTime2 . " 00:00:00', '" . $currDateTime2E . " 23:59:59') order by tourid desc, rbr asc";
					else
						$sqlD = "select * from gettoursbyuidbytourid(" . $user_id . ", " . $tourid . ") order by tourid desc, rbr asc";
				}

				//while($row = pg_fetch_array($dsPre))
				//{

				$dsPre = query($sqlD);
				$lasttid = 0;
				$currtid = 0;
				$counter = 0;
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
						$str = "<span class='clearRow' id='" . $row["tourid"] . "_" . $row["poiid"] . "' style='padding-right: 10px; float:right; font-size:11px'>Реден Број: <span style='color:#000'>" . $row["rbr1"] . "</span>&nbsp;&nbsp;&nbsp;Пристигнување: <span style='color:#040'>" . $tin . "</span>&nbsp;&nbsp;&nbsp;Поаѓање: <span style='color:#800'>" . $tout . "</span>&nbsp;&nbsp;&nbsp;Стоење: <span style='color:#800'>" . pg_fetch_result($stoenje, 0, "diff") . "</span></span>";
					} else {
						$str = "<span class='clearRow' id='" . $row["tourid"] . "_" . $row["poiid"] . "' style='padding-right: 10px; float:right; font-size:11px'></span>";
					}
					$dtTmp = new Datetime($row["startdate"]);
					$dtTmp = $dtTmp->format("H:i d-m-Y");
					
					$datum = $row["startdate"];
					if($row["startdate"] == now())
						$datum = '<?php echo dic_("Routes.Today")?>';
					else
						$datum = $dtTmp;
					if($row["startdate"] < now())
					{
						$border = "#990000";
						$bck = "#FED6DC";
					}
					
					$imeruta = dlookup("select name from rNalogHeder where id=" . $row["tourid"]);
				if($currtid != $lasttid)
				{
				?>
				<?php
				if ($counter > 0) {
					?>
					
					</div>
					<br />
					
					<?php
				}
				?>
				<div class="corner5 text5" style="font-size:16px; width:<?php if($yourbrowser == "1") { echo '630px'; } else { echo '800px'; } ?>; padding:5px 5px 5px 10px; border:1px solid <?php echo $border?>; background-color:<?php echo $bck?>; margin-left:<?php if($yourbrowser == "1") { echo '10px'; } else { echo '20px'; } ?>">
					
					<button style="border:0; background-color:transparent; position: relative; left:-9px; top: -3px; width: 15px" id="btn-hide<?= $counter?>" value="+" onclick="hideDiv(<?= $counter?>)">&nbsp;</button>
					
					
					<strong><?php echo $row["vozilo"]?> (<?php echo $imeruta?>)</strong><strong style="float:right"><?php echo dic_("Routes.OrderNumber")?>: <?php echo $row["tourid"]?>&nbsp;&nbsp;&nbsp;</strong>
					<table style="font-size:11px;" border="0" width="100%">
					<tr>
						<td width="220px" style="padding-left: 10px;"><?php echo dic_("Tracking.BeginningOrder")?>: <strong style="color:#800"><?php echo DateTimeFormat($datum, $tf . " " . $dateformat)?></strong></td>
						<td style="padding-left: 10px;"><?php echo dic_("Routes.CreatedBy")?>: <strong style="color:#800"><?php echo $row["korisnik"]?></strong></td>
						<td style="padding-left: 10px;"><?php echo dic_("Reports.Total")?> <?php if($clientUnit == "mi") { echo dic("Route.Miles"); } else { echo dic("Fm.Km");} ?>: <strong style="color:#800"><?php echo number_format((float)$row["totalkm"], 2, '.', '')?>&nbsp;<?php if($clientUnit == "mi") { echo dic("Route.Miles"); } else { echo "km";} ?></strong></td>
						<td style="padding-left: 10px;"><?php echo dic_("Reports.TotalTime")?>: <strong style="color:#800"><?php echo Sec2Str1($row["totaltime"])?></strong></td>
					</tr>
					<?php
			  			if($row["tostay"] != "0")
						{
					  	?>
						  <tr>
							<td align="left" style="padding-left: 10px;" colspan="3" valign="middle" class="style2"><?php echo dic_("Tracking.RetentionTimeLocation")?>: <strong id="vnz_<?php echo $row["tourid"]?>" style="color:#800"><?php echo $row["tostay"]?>&nbsp;<?php echo dic_("Settings.Min")?></strong></td>
							<td align="right" valign="middle" class="style2">&nbsp;</td>
						  </tr>
					  	<?php
					  	}
			  		?>
			  		<tr>
					  	<td colspan="4" style="padding-left: 10px;">
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
					</tr>
					<?php
				  	if($row["pause1"] != "0")
					{
					  ?>
					  <tr>
					  	<td colspan="4" style="padding-left: 10px;">
							<table cellpadding="0" style="font-size:11px;" cellspacing="0" border="0">
								<tr>
									<td class="style2"><?php echo dic_("Tracking.FirstPause")?>: <strong style="color:#800"><?php echo $row["pause1"]?>&nbsp;<?php echo dic_("Settings.Min")?></strong></td>
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
					  	<?php
					  	}
					  	if(session("client_id") == 367)
						{ ?>
					  	<tr>
							<td width="220px" style="padding-left: 10px;"><?= dic("Settings.Culture")?>: <strong style="color:#800"><?php echo $row["culture"]?></strong></td>
							<td style="padding-left: 10px;"><?= dic("Settings.Operation")?>: <strong style="color:#800"><?php echo $row["operation"]?></strong></td>
							<td style="padding-left: 10px;"><?= dic("Settings.Material")?>: <strong style="color:#800"><?php echo $row["material"]?></strong></td>
							<td style="padding-left: 10px;"><?= dic("Routes.AddedMechanisation")?>: <strong style="color:#800"><?php echo $row["mechanization"]?></strong></td>
						</tr>
					  <?php } ?>
					<!--tr><td colspan="4" style="padding-left: 10px;">Прв Возач: <strong style="color:#800"><?php echo $row["sofer1"]?>&nbsp;&nbsp;&nbsp;&nbsp;</strong>Втор Возач: <strong style="color:#800"><?php echo $row["sofer2"]?>&nbsp;&nbsp;&nbsp;&nbsp;</strong>Трет Возач: <strong style="color:#800"><?php echo $row["sofer3"]?></strong></td></tr-->
				</table>
					<!--span style="font-size:11px; margin-left:30px; ">Почеток на налогот: <strong style="color:#800"><?php echo $row["startdate"]?></strong></span>
					<span style="font-size:11px; margin-left:30px; ">Креиран од: <strong style="color:#800"><?php echo $row["korisnik"]?></strong></span>				
					<span style="font-size:11px; margin-left:30px; ">Прв Возач: <strong style="color:#800"><?php echo $row["s1"]?>&nbsp;&nbsp;&nbsp;&nbsp;</strong>Втор Возач: <strong><?php echo $row["s2"]?>&nbsp;&nbsp;&nbsp;&nbsp;</strong>Трет Возач: <strong><?php echo $row["s3"]?></strong></span><br-->
					<button onClick="brisi(<?php echo $row["tourid"]?>)" class="text5" style="font-size:11px; margin-left:30px"><?php echo dic("Routes.Delete")?></button>
					<button onClick="promeni(<?php echo $row["tourid"]?>)" class="text5" style="font-size:11px; margin-left:5px"><?php echo dic("Routes.Mod")?></button>
					<button onClick="printn(<?php echo $row["tourid"]?>)" class="text5" style="font-size:11px; margin-left:5px"><?php echo dic("Routes.Print")?></button>
					<?php if($yourbrowser != "1") { ?><button onClick="excel(<?php echo $row["tourid"]?>)" class="text5" style="font-size:11px; margin-left:5px"><?php echo dic("Tracking.ExportToExcel")?></button><?php } ?>
					<button onClick="resizeDiv(event);LoadRoute(<?php echo $row["tourid"]?>);" class="text5" style="font-size:11px; margin-left:5px"><?php echo dic("Routes.Map")?></button>
				</div>
				<div id="detail<?= $counter?>">
				<?php
				}
				?>
				<div class="corner5 text5" style="font-size:12px; width:<?php if($yourbrowser == "1") { echo '570px'; } else { echo '750px'; } ?>; padding:2px 2px 2px 10px; border:1px solid #CCCCCC; background-color:#F3F3F3; margin-left:<?php if($yourbrowser == "1") { echo '28px'; } else { echo '50px'; } ?>; margin-top:5px">
					<input disabled style="position: relative; border: 0px none; background: none repeat scroll 0% 0% transparent; width: 310px;" value="<?php echo $row["rbr"]?>.&nbsp;&nbsp;<?php echo $row["name"]?>" class="text5">
					<?php echo $str?>
				</div>
			
		<?php
				$lasttid = $currtid;
				$counter++;
			}
			?>
				
			<?php
			if($counter == 0)
			{
		?>
		
		 <div id="noData" style="width: 90%; padding-left:40px; font-size:30px; font-style:italic; padding-bottom:10px" class="text4">
	         <?php echo dic_("Routes.NotCreatedOrder")?>
	    </div>
		<?php
			}
			?>
	</div>
	
	<br>
	<div id="footer-rights-new" class="textFooter" style="padding:10px 10px 10px 10px">

	</div>
	<br>    
</div>
	<div id="div-promeni" title="<?php echo dic("Routes.MOrder")?>" style="display:none">
		<iframe id="frm-promeni" frameborder="0" scrolling="yes" style="width:100%; height:100%; overflow-y: auto; overflow-x: hidden"></iframe>
	</div>
	<div id="div-print" title="<?php echo dic("Routes.PrintingOrder")?>" style="display:none">
		<iframe id="frm-print" frameborder="0" scrolling="no" style="width:100%; height:1200px"></iframe>
	</div>
	<iframe id="frm-excel" frameborder="0" scrolling="no" style="display:none"></iframe>
</body>
</html>



<script type="text/javascript">

	function hideDiv(_cnt) {
		if($('#detail'+_cnt).css('display') == 'none') {
			$('#detail'+_cnt).fadeIn("slow", function() {});
			$("#btn-hide"+_cnt).button({
	            icons: {primary: "ui-icon-triangle-1-s"}
        	});
		} else {
       		$('#detail'+_cnt).fadeOut("slow", function() {});
			$("#btn-hide"+_cnt).button({
	            icons: {primary: "ui-icon-triangle-1-e"}
       		});
		}
		$("#btn-hide"+_cnt).removeClass("ui-state-focus");
	}
	top.changeItem = false;
	allowbuttons = false;
	pause1 = '0';
	pause2 = '0';
	pause3 = '0';
	pause4 = '0';
	pause5 = '0';
	
	tostay = '0';

    lang = '<?php echo $cLang?>';

    var clientUnit = '<?php echo $clientUnit?>';

    AllowedMaps = '<?php echo $AllowedMaps?>';
    DefMapType = '<?php echo $DefMap?>';
    var cntz = parseInt('<?php echo ($cntz-1)?>');

    LoadCurrentPosition = false;
    JustSave = false;

    ShowAreaIcons = true
    OpenForDrawing = false;
    ShowVehiclesMenu = false;
    ShowPOIBtn = true;
    ShowGFBtn = true;
    var RecOn = false;
    var RecOnNew = false;
    var PointsOfRoute = [];
    CreateBoards();


SetHeightLite()
iPadSettingsLite()
top.HideLoading()
$('#txtSDate').datepicker({
			dateFormat: '<?=$datejs?>',
			showOn: "button",
			buttonImage: "../images/cal1.png",
			buttonImageOnly: true,
			onSelect: function () {
	            clearvalue('1');
	        }
		});
$('#txtEDate').datepicker({
			dateFormat: '<?=$datejs?>',
			showOn: "button",
			buttonImage: "../images/cal1.png",
			buttonImageOnly: true,
			onSelect: function () {
	            clearvalue('1');
	        }
		});

if (Browser()=='iPad') {top.iPad_Refresh()}

//stoenje
$(document).ready(function () {
    $('#div-map').css({ height: '402px' });
    
    for (var i = 0; i < <?= $counter?>; i++) {
    	$('#btn-hide' + i).button({icons: {primary: "ui-icon-triangle-1-s "}});
    }
    top.HideWait();
});
function resizeDiv(e) {
    /*if (parseInt($('#likeapopup').css('width'), 10) - 100 > e.clientY)
        $('#likeapopup').css({ top: e.clientY + 'px' });
    else
        $('#likeapopup').css({ top: e.clientY - (parseInt($('#likeapopup').css('width'), 10) - e.clientY + 50) + 'px' });
    $('#likeapopup').css({ left: (e.clientX + 50) + 'px' });*/
    $('#likeapopup').css({ top: ((document.body.offsetHeight / 2) - ((parseInt($('#likeapopup').css('height'), 10) / 2))) + 'px' });
    $('#likeapopup').css({ left: ((document.body.offsetWidth / 2) - ((parseInt($('#likeapopup').css('width'), 10) / 2))) + 'px' });
    //$('#likeapopup').css({ display: 'block' });
    $('#likeapopup').css({ visibility: 'visible' });
    $('#div-map').css({ display: 'block' });
}
setTimeout("LoadMaps();", 1000);
//AjaxRouteNew();
function clearvalue(_num)
{
	if(_num == "1")
	{
		$('#txttourid').val('');
	} else
	{
		$('#txtSDate').val('');
		$('#txtEDate').val('');
	}
}
</script>