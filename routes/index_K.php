<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
	if (session('user_id') == "261") echo header( 'Location: ../sessionexpired/?l='.$cLang);
	if (is_numeric(nnull(session("user_id")) == false)) echo header('Location: ../sessionexpired/?l=' . $cLang);
	opendb();
	$ds = query("select allowedrouting, allowedfm from clients where id=" . session("client_id"));
	
	$sqlV = "";
	if (session("role_id") == "2") {
		$sqlV = "select id from vehicles where clientID=" . session("client_id") ;
	} else{
		$sqlV = "select vehicleID from uservehicles where userID=" . session("user_id") . "" ;
	}
	
	$allowedR = pg_fetch_result($ds, 0, "allowedrouting");
	if ($allowedR==FALSE) {echo header( 'Location: ../?l='.$cLang."&err=permission");}
	$allowedFM = pg_fetch_result($ds, 0, "allowedfm");
	$fm = '';
	$fm1 = '';
	$routes = '';
	$routes1 = '';
	$tv = '';
	$tv1 = '';
	if(true)
	{
		$tv = 'return false;';
		$tv1 = 'opacity: 0.4;';
	}
	if(!$allowedFM)
	{
		$fm = 'return false;';
		$fm1 = 'opacity: 0.4;';
	}
	if(!$allowedR)
	{
		$routes = 'return false;';
		$routes1 = 'opacity: 0.4;';
	}

	$Allow = getPriv("routes", session("user_id"));	
	if ($Allow==FALSE) {echo header( 'Location: ../?l='.$cLang."&err=permission");}
	
	$dsTraceSnooze = query("select snooze, metric from users where id=" . session("user_id"));
	$snooze = pg_fetch_result($dsTraceSnooze, 0, "snooze");
	$metric = pg_fetch_result($dsTraceSnooze, 0, "metric");
	closedb();

	addlog(5);
?>
<html>
<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo dic("Reports.PanoramaGPS")?></title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.8.14.custom.css">	
	<LINK REL="SHORTCUT ICON" HREF="../images/icon.ico">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>

	<script type="text/javascript" src="../js/iScroll.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="routes.js"></script>
    <link rel="stylesheet" type="text/css" href="../js/spineditcontrol.css">
    <link rel="stylesheet" type="text/css" href="../js/content.css">	
    <script src="js/spineditcontrol.js" type="text/javascript"></script>
    <script src="js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
    
    <script type="text/javascript" src="../main/main.js"></script>
    
</head>

<body onResize="SetHeight()">
<div id="dialog-message" title="Предупредување" style="display:none">
	<p>
		<span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px; padding-left: 23px;"></div>
	</p>
    <div id="DivInfoForAll" style="font-size:11px; padding-left: 23px;"><input id="InfoForAll" type="checkbox" /><?php echo dic("Tracking.InfoMsg")?></div>
</div>
	<script>
		
		function chechchange(_id)
		{
			if(changeItem)
			{
				msgboxRoute123('Имате направено промена!<br/>Дали сакате да ги поништите промените?', _id);
			}
			else
			{
				document.location.href = _id;
			}
		}
	</script>
<div id="rep"></div>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td  width="35%" height="32px" style="background-image:url(../images/traka.png); border-bottom:1px solid #999">
			&nbsp;<img src="../images/tiniLogo.png" border="0" align="absmiddle" />&nbsp;
			&nbsp;<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;
			<a id="icon-home" onclick="chechchange('../?l=<?php echo $cLang?>');" style="cursor: pointer;"><img src="../images/shome.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-live" onclick="chechchange('../tracking/?l=<?php echo $cLang?>');" style="cursor: pointer;"><img src="../images/smap.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-rep" onclick="chechchange('../report/?l=<?php echo $cLang?>#rep/menu_1_1');" style="cursor: pointer;"><img src="../images/sdocument.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-route"><img src="../images/srouting.png" border="0" align="absmiddle" style="opacity:0.4" /></a>&nbsp;
			<a id="icon-tv" onclick="<?php echo $tv?> chechchange('../tv/?l=<?php echo $cLang?>#tv/menu_2_1');" style="<?php echo $tv1?> cursor: pointer;"><img src="../images/stv.png" border="0" align="absmiddle" /></a>&nbsp;
			&nbsp;<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;
		</td>
		<td width="65%" height="32px" style="background-image:url(../images/traka.png); border-bottom:1px solid #999" align="right" class="text2">
			<?php echo dic("Reports.Company")?>: <strong><?php echo session("company")?></strong>&nbsp;&nbsp;&nbsp;<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<?php echo dic("Reports.User")?>: <strong><?php echo session("user_fullname")?></strong>&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<!--a>
				<div id="alertsNew" class="corner5" style="background-color: Red; color: White; height: 13px; left: 0px; float: left; z-index: 134354; width: 13px; top: 0px; text-align: center;">1</div>
			</a-->
			<a id="icon-alert" style="position: relative; left: 15px; margin-left: -10px; opacity: 1">
				<img src="../images/warning1.png" onclick="ShowHideAlerts()" border="0" align="absmiddle" style="cursor: pointer;" />
				<input id="alertsNew" class="notify corner5" onclick="ShowHideAlerts()" style="visibility: hidden;" value="0" disabled />
			</a>&nbsp;
			<!--a>
				<div id="alertsNew" class="corner5" style="background-color: Red; color: White; height: 13px; left: 0px; float: left; z-index: 134354; width: 13px; top: 0px; text-align: center;">1</div>
			</a-->
			<a id="icon-mail" style="position: relative; left: 15px; margin-left: -10px; opacity: 0.4">
				<img src="../images/mail.png" onclick="ShowHideMail()" border="0" align="absmiddle" style="cursor: pointer;" />
				<input id="mailNew" class="notify corner5" onclick="ShowHideMail()" style="visibility: hidden;" value="0" disabled />
			</a>&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<a id="icon-costs" style="position: relative; left: 15px; margin-left: -10px;<?php echo $fm1?>">
				<img src="../images/cost24.png" onclick="<?php echo $fm?>costVehicle123('1', '2058', 'SK-0001-AB')" border="0" align="absmiddle" style="cursor: pointer;" />
				<input id="costNew" class="notify corner5" onclick="ShowHideMail()" style="visibility: hidden;" value="0" disabled />
			</a>&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<a id="icon-sett" onclick="chechchange('../settings/?l=<?php echo $cLang?>');" style="cursor: pointer;"><img src="../images/ssettings.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-help"><img src="../images/shelp.png" border="0" align="absmiddle" /></a>&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<a id="icon-logout" onclick="chechchange('../logout/?l=<?php echo $cLang?>');" style="cursor: pointer;"><img src="../images/exit.png" border="0" align="absmiddle" /></a>&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</table>
<div id="dialog-map" style="display:none; z-index: 9999" title="<?php echo dic_("Reports.ViewOnMap")?>"></div>
<audio id="soundHandle" loop="loop" style="display: none;"></audio>
<div id="div-costMain" style="display:none" title="Додавање нов трошок"></div>
<div id="div-costnewMain" style="display:none" title="Додавање нов тип на трошок"></div>
<div id="div-locMain" style="display:none" title="Додавање нов извршител"></div>
<div id="div-compMain" style="display:none" title="Додавање новa компонента"></div>
<div id="div-mainalerts" onmouseover="clearTimeOutAlertView()" onmouseout="setTimeOutAlertView()" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; border: 0px; right: 35px; float: right; position: absolute; z-index: 9999; top: 43px; width: 315px; overflow-x: hidden; overflow-y: auto;"></div>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td id="td-menu" width="250px" style="background-color:#efefef;" valign="top">
			<div id="div-menu" style="width:100%; overflow-y:auto; overflow-x:hidden">
				
				<div id="menu-1" class="menu-container" style="">
					<a id="menu-title-1" class="menu-title text3" onClick="OnMenuClick(1)">Налози</a>
					<div id="menu-container-1" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px;">               
						<a id="menu_1_1" onclick="chechchange('#rep/menu_1_1');" style="cursor: pointer;" class="repoMenu corner5 text2">▪ Нов налог</a>
						<a id="menu_1_2" onclick="chechchange('#rep/menu_1_2');" style="cursor: pointer;" class="repoMenu corner5 text2">▪ Предефинирани налози</a>						
					</div>
				</div>
				<div id="menu-2" class="menu-container" style="">
					<a id="menu-title-2" class="menu-title text3" onClick="OnMenuClick(2)">Преглед</a>
					<div id="menu-container-2" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px;">               
						<a id="menu_2_1" onclick="chechchange('#rep/menu_2_1');" style="cursor: pointer;" class="repoMenu corner5 text2">▪ Налози во тек</a>
						<a id="menu_2_2" onclick="chechchange('#rep/menu_2_2');" style="cursor: pointer;" class="repoMenu corner5 text2">▪ Налози со иден датум</a>						
						<a id="menu_2_3" onclick="chechchange('#rep/menu_2_3');" style="cursor: pointer;" class="repoMenu corner5 text2">▪ Сите налози</a>						
					</div>
				</div>
				<div id="menu-3" class="menu-container" style="">
					<a id="menu-title-3" class="menu-title text3" onClick="OnMenuClick(3)">Извештаи</a>
					<div id="menu-container-3" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px;">               
						<a id="menu_3_1" onclick="chechchange('#rep/menu_3_1');" style="cursor: pointer;" class="repoMenu corner5 text2">▪ Пребарувања</a>
					</div>
				</div>
			</div>
		</td>
		<td width="4px" style=" background-color:#efefef;">&nbsp;</td>
		<td id="race-td" width="9px" style="border-left:1px solid #cccccc;">
			<div id="race-img" style="width:8px; height:50px; background-image:url(../images/race.png); background-position:-8px 0px; cursor:pointer" onClick="ShowHideLeftMenu()"></div>
		</td>
		<td height="100%" valign="top" >
			<div style="width:100%; height:5px;"></div>	
				
			<div style="width:100%; height:5px;"></div>
			<div id="report-content" style="width:98%; text-align:left; height:500px; margin-left:10px; border:1px solid #bbb; background-color:#fafafa; overflow: hidden" class="corner5">
				
					<iframe id="ifrm-cont" src="temp.php" width="100%" frameborder="0" scrolling="yes" style='overflow-x: hidden; overflow-y: scroll; -webkit-overflow-scrolling: touch;' ></iframe>
							
			</div>
		</td>
	</tr>
</table>
<script type="text/javascript">
		$(document).ready(function () {
			jQuery('body').bind('touchmove', function(e){e.preventDefault()});
	    });
</script>
</body>
</html>
<script type="text/javascript">

	var snoozeTmp = 0;
snooze = '<?php echo $snooze?>';

metric = '<?php echo $metric?>';

	$('#alertsNew').val('0');
	$('#div-mainalerts').css({ height: (document.body.clientHeight - 75) + 'px' });

var changeItem = false;

lang = '<?php echo $cLang?>';

ShowWait()
checkHash()
SetHeight()
iPadSettings()
setCalenders()
$('#showBtn').button({ icons: { primary: "ui-icon-search"} })
ShowHideAlerts();
ShowHideMail();
snoozeAlarm();
AjaxNotify();
</script>


<?php
	opendb();
	$sqlAlarm = "";
	$sqlAlarm .= "select ah.*, v.registration from alarmshistory ah left join vehicles v on v.id=ah.vehicleid ";
	$sqlAlarm .= " where ah.vehicleid in (" . $sqlV . ") ";
	$sqlAlarm .= " and ah.datetime > cast((select now()) as date) + cast('-1 day' as interval) ";
	$sqlAlarm .= " order by read asc, datetime desc";
	$dsAlarms = query($sqlAlarm);
	$brojac = 1;
	$brojac1 = dlookup("select count(*) from alarmshistory where vehicleid in (" . $sqlV . ") and datetime > cast((select now()) as date) + cast('-1 day' as interval) and read='0'");
	while($row = pg_fetch_array($dsAlarms))
	{
		$tzDatetime = new DateTime($row["datetime"]);
		list($d, $m, $y) = explode('-', $row["datetime"]);
		$a = explode(" ", $y);
		$d1 = explode(":", $a[1]);
		$d2 = explode(".", $d1[2]);
		$idCreate = $row["vehicleid"] . "_" . $d . "_" . $m . "_" . $a[0] . "_" . $d1[0] . "_" . $d1[1] . "_" . $d2[0] . "_" . $d2[1];
		if($row["read"] == "0")
		{
			?>
			<script>
				AlertEventInit('<?php echo $row["datetime"]?>', '<?php echo $row["registration"]?>', '<?php echo $row["name"]?>', '<?php echo $row["vehicleid"]?>', '<?php echo $brojac1?>');
			</script>
			<?php
			$brojac1--;
		}
		
		$brojac++;
	}

	closedb();
	
?>
