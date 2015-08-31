<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
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
	opendb();
	$Allow = getPriv("routesall", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
    $user_id = Session("user_id");
	
	$dsAll = query("select defaultmap, datetimeformat, timezone, metric, cl.clienttypeid, ci.latitude, ci.longitude from users u left outer join clients cl on cl.id = u.clientid left outer join cities ci on ci.id = cl.cityid where u.id = " . $user_id);

    $clientType = pg_fetch_result($dsAll, 0, "clienttypeid");
    $clientUnit = pg_fetch_result($dsAll, 0, "metric");
    
    //dim allPOI as integer = dlookup("select count(*) from pinpoints where clientID=" & session("client_id"))
    //Dim allPOIs As String = "false"
    //If allPOI < 1000 Then allPOIs = "true"
	
    $DefMap = pg_fetch_result($dsAll, 0, "defaultmap");
    
	$currDateTime = new Datetime();
    $currDateTime = $currDateTime->format("d-m-Y H:i");
	$currDateTime1 = new Datetime();
	$currDateTime1 = $currDateTime1->format("d-m-Y");
	
    $AllowedMaps = "11111";

    $cntz = dlookup("select count(*) from pointsofinterest where type=2 and clientid=" . Session("client_id"));
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
		if (confirm("Дали сакате да го избришете налогот ?")==true) {
			$('#div-nalog-'+_id).hide( 'drop', {}, 1000);
			$.ajax({
				  url: 'delNalog.php?id=' + _id,	
				   success: function(data) {
				   }									
			});
		}
		
	}
	var test111 = true;
	function msgboxRoute321(msg) {
	    $("#DivInfoForAll").css({ display: 'none' });
	    $('#div-msgbox').html(msg)
	    $("#dialog:ui-dialog").dialog("destroy");
	    $("#dialog-message").dialog({
	    	width: 400,
	        modal: true,
	        zIndex: 9999, resizable: false,
	        buttons: 
	        [
	            {
	                text: dic("yes", lang),
	            	click : function () {
		                $(this).dialog("close");
		                $('#div-promeni').dialog('close');
		                test111 = false;
		            }
	            },
				{
				    text: dic("No", lang),
	        		click: function () {
	            		$(this).dialog("close");
	        		}
	            }
	        ]
	    });	
	    HideWait();
	}
	function promeni(_id){
		test111 = true;
		document.getElementById('frm-promeni').src = 'EditNalog.php?id='+_id;
		$('#div-promeni').dialog({ width: document.body.offsetWidth - 10, height: document.body.offsetHeight - 10, beforeClose: function(event) {
			if(top.changeItem)
			{
				if(test111)
				{
					msgboxRoute321('Имате направено промена!<br/>Дали сакате да ги поништите промените?');
					return false;
				}
				else
					test111 = true;
			}
		} });
	}
	
	function printn(_id){
		document.getElementById('frm-print').src = 'PrintNalog.php?id='+_id
		$('#div-print').dialog({width:830, height:600})
	}
	function excel(_id){
		document.getElementById('frm-excel').src = 'ExcelNalog.php?id='+_id	
	}
</script>	
<body style="margin:0px 0px 0px 0px; padding:0px 0px 0px 0px" onResize="SetHeightLite()">
<div id="dialog-message" title="Предупредување" style="display:none;">
	<p>
		<span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px; padding-left: 23px;"></div>
	</p>
    <div id="DivInfoForAll" style="font-size:11px; padding-left: 23px;"><input id="InfoForAll" type="checkbox" /><?php echo dic("Tracking.InfoMsg")?></div>
</div>
<div id="report-content" style="width:100%; text-align:left; height:500px; background-color:#fff; overflow-y:auto; overflow-x:hidden" class="corner5">
	<div style="padding-left:40px; padding-top:10px; width:500px" class="textTitle">
		Сите налози&nbsp;&nbsp;&nbsp;&nbsp;
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
			<?php
				$sqlD = "";
					//$sqlD .= "select h.id, v.Code ||'-'|| v.Registration vozilo, d1.FullName sofer1, h.name, d2.FullName sofer2, d3.FullName sofer3, h.Datetime, h.startDate, u.FullName korisnik ";
					$sqlD .= "select h.id, '('||v.Code ||') - '|| v.Registration vozilo, d1.FullName sofer1, h.name, d2.FullName sofer2, d3.FullName sofer3, h.Datetime, h.startDate, u.FullName korisnik, ";
					$sqlD .= " h.tostay, h.pause1, h.pause2, h.pause3, h.pause4, h.pause5, h.totalkm, h.totaltime ";
					$sqlD .= "from rNalogHeder h ";
					$sqlD .= "left outer join Vehicles v on v.ID=h.vehicleID ";
					$sqlD .= "left outer join Drivers d1 on h.DriverId1=d1.ID ";
					$sqlD .= "left outer join Drivers d2 on h.DriverId2=d2.ID ";
					$sqlD .= "left outer join Drivers d3 on h.DriverId3=d3.ID ";
					$sqlD .= "left outer join Users u on u.id=h.userID ";
					$sqlD .= " where h.clientID=" . Session("client_id") . " order by StartDate desc";
					
				
					$dsPre = query($sqlD);
				while($row = pg_fetch_array($dsPre))
				{
					$border = "#009900";
					$bck = "#DBFDEA";
					//'dim border as string = "#990000"  'RED
					//'dim bck as string = "#FED6DC"		'RED
					$datum = $row["startdate"];
					$SdtTmp = new Datetime($row["startdate"]);
					$SdtTmp = $SdtTmp->format("H:i d-m-Y");
					if($row["startdate"] == now())
						$datum = "Денес";
					else
						$datum = $SdtTmp;
					if($row["startdate"] < now())
					{
						$border = "#990000";
						$bck = "#FED6DC";
					}
			?>
			<div id="div-nalog-<?php echo $row["id"]?>">
			<div class="corner5 text5" style="font-size:16px; width:<?php if($yourbrowser == "1") { echo '630px'; } else { echo '800px'; } ?>; padding:5px 5px 5px 10px; border:1px solid <?php echo border?>; background-color:<?php echo $bck?>; margin-left:<?php if($yourbrowser == "1") { echo '10px'; } else { echo '20px'; } ?>">
				<strong><?php echo $row["vozilo"]?> (<?php echo $row["name"]?>)</strong><strong style="float:right">Налог број: <?php echo $row["id"]?>&nbsp;</strong><br>
				<table style="font-size:11px;" border="0" width="100%">
					<tr>
						<td width="210px" style="text-align: right">Почеток на налогот: <strong style="color:#800"><?php echo $datum?></strong></td>
						<td width="24%" style="padding-left: 5px;">Креиран од: <strong style="color:#800"><?php echo $row["korisnik"]?></strong></td>
						<td width="24%" style="padding-left: 10px;">Вкупно <?php if($clientUnit == "mi") { echo dic("Route.Miles"); } else { echo dic("Fm.Km");} ?>: <strong style="color:#800"><?php echo number_format((float)$row["totalkm"], 2, '.', '')?>&nbsp;<?php if($clientUnit == "mi") { echo dic("Route.Miles"); } else { echo "km";} ?></strong></td>
						<td width="24%" style="padding-left: 10px;">Вкупно време: <strong style="color:#800"><?php echo Sec2Str1($row["totaltime"])?></strong></td>
					</tr>
					<tr>
						<td style="text-align: right">Крај на налогот: <strong style="color:#800;"><?php echo $SdtTmp ?></strong></td>
						<td colspan="3" style="padding-left: 5px;">
							<table cellpadding="0" style="font-size:11px;" cellspacing="0" border="0">
						  		<tr>
									<td align="left" valign="middle">Прв корисник: <strong style="color:#800"><?php echo $row["sofer1"]?></strong></td>
									<?php
									  	if($row["sofer2"] != "")
										{
											?>
											<td style="padding-left: 30px" align="left" valign="middle">Втор корисник: <strong style="color:#800"><?php echo $row["sofer2"]?></strong></td>
											<?php
										}
										if($row["sofer3"] != "")
										{
											?>
											<td style="padding-left: 30px" align="left" valign="middle">Трет корисник: <strong style="color:#800"><?php echo $row["sofer3"]?></strong></td>
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
							<td align="left" style="padding-left: 10px;" colspan="4" valign="middle" class="style2">Време на задржување по локација: <strong style="color:#800"><?php echo $row["tostay"]?>&nbsp;min</strong></td>
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
				</table>
				<!--span style="font-size:11px; margin-left:30px; ">Почеток на налогот: <strong style="color:#800"><?php echo $datum?>&nbsp;&nbsp;&nbsp;<?php echo $row["startdate"]?></strong></span>
				<span style="font-size:11px; margin-left:30px; ">Креиран од: <strong style="color:#800"><?php echo $row["korisnik"]?></strong></span>				
				<span style="font-size:11px; margin-left:30px; ">Возачи: <strong style="color:#800"><?php echo $row["sofer1"]?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo $row["sofer2"]?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo $row["sofer3"]?></strong></span-->
				
				<button onClick="brisi(<?php echo $row["id"]?>)" class="text5" style="font-size:11px; margin-left:30px"><?php echo dic("Routes.Delete")?></button>
				<button onClick="promeni(<?php echo $row["id"]?>)" class="text5" style="font-size:11px; margin-left:5px"><?php echo dic("Routes.Mod")?></button>
				<button onClick="printn(<?php echo $row["id"]?>)" class="text5" style="font-size:11px; margin-left:5px"><?php echo dic("Routes.Print")?></button>
				<?php if($yourbrowser != "1") { ?><button onClick="excel(<?php echo $row["id"]?>)" class="text5" style="font-size:11px; margin-left:5px"><?php echo dic("Tracking.ExportToExcel")?></button><?php } ?>
				<button onClick="resizeDiv(event);LoadRoute(<?php echo $row["id"]?>);" class="text5" style="font-size:11px; margin-left:5px"><?php echo dic("Routes.Map")?></button>
			</div>
			<?php
				$dsPreD = query("select opis, rbr, fromtime, totime, rbr1 from rNalogDetail where hederID=" . $row["id"] . " order by rbr");
				while($row1 = pg_fetch_array($dsPreD))
				{
					$str = "";
					if(trim($row1["fromtime"]) != "")
						$str = "<span style='float:right; font-size:11px'>Реден Број: <span style='color:#000'>". $row1["rbr1"] . "</span>&nbsp;&nbsp;&nbsp;Пристигнување: <span style='color:#040'>" . $row1["fromtime"] . "</span>&nbsp;&nbsp;&nbsp;Поаѓање: <span style='color:#800'>" . $row1["toTime"] . "</span></span>";
					
			?>
			<div class="corner5 text5" style="font-size:12px; width:<?php if($yourbrowser == "1") { echo '590px'; } else { echo '750px'; } ?>; padding:2px 2px 2px 10px; border:1px solid #CCCCCC; background-color:#F3F3F3; margin-left:<?php if($yourbrowser == "1") { echo '30px'; } else { echo '50px'; } ?>; margin-top:5px">
				<?php echo $row1["rbr"]?>.&nbsp;&nbsp;&nbsp;<?php echo $row1["opis"]?>
				
				<?php echo $str?>
			</div>
			<?php
				}
			?>
			
			<br>
			</div>
			<?php
				}
			?>
	</div>
	
	<br><br>

	<br>
	<div id="footer-rights-new" class="textFooter" style="padding:10px 10px 10px 10px">

	</div>
	<br>    
	
		
</div>
	<div id="div-promeni" title="Промена на налог" style="display:none">
		<iframe id="frm-promeni" frameborder="0" scrolling="yes" style="width:100%; height:100%; overflow-y: auto; overflow-x: hidden"></iframe>
	</div>
	<div id="div-print" title="Печатење на налог" style="display:none">
		<iframe id="frm-print" frameborder="0" scrolling="no" style="width:800px; height:1200px"></iframe>
	</div>
	<iframe id="frm-excel" frameborder="0" scrolling="no" style="display:none"></iframe>
</body>
</html>



<script type="text/javascript">

	top.changeItem = false;

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
    //LoadMaps();
		
    SetHeightLite()
    iPadSettingsLite()
    top.HideLoading()
    $('#txtSDate').datepicker({
			    dateFormat: 'dd-mm-yy',
			    showOn: "button",
			    buttonImage: "../images/cal1.png",
			    buttonImageOnly: true
		    });

    if (Browser()=='iPad') {top.iPad_Refresh()}

    //stoenje
    $(document).ready(function () {
    	jQuery('body').bind('touchmove', function(e){e.preventDefault()});
        $('#div-map').css({ height: '402px' });
        //$('#likeapopup').css({ display: 'none' });
        top.HideWait();
    });

    function resizeDiv(e) {
        /*if (parseInt($('#likeapopup').css('width'), 10) > e.clientY)
            $('#likeapopup').css({ top: e.clientY + 'px' });
        else
            $('#likeapopup').css({ top: (e.clientY - parseInt($('#likeapopup').css('width'), 10)) + 'px' });
        $('#likeapopup').css({ left: (e.clientX + 50) + 'px' });*/
        $('#likeapopup').css({ top: ((document.body.offsetHeight / 2) - ((parseInt($('#likeapopup').css('height'), 10) / 2))) + 'px' });
        $('#likeapopup').css({ left: ((document.body.offsetWidth / 2) - ((parseInt($('#likeapopup').css('width'), 10) / 2))) + 'px' });
        //$('#likeapopup').css({ display: 'block' });
        $('#likeapopup').css({ visibility: 'visible' });
        $('#div-map').css({ display: 'block' });
    }
    setTimeout("LoadMaps();", 1000);
</script>