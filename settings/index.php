<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<html>
<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo dic("Settings.PanoramaGPS")?></title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="stylesheet" type="text/css" href="../rstyle.css">
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.8.14.custom.css">	
	<LINK REL="SHORTCUT ICON" HREF="../images/icon.ico">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	
    <link href="../tracking/mlColorPicker.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../tracking/mlColorPicker.js" ></script>
    <script type="text/javascript" src="../main/main.js"></script>
    <script src="../js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
    
</head>

<?php
	if (session('user_id') == "261" or session('user_id') == "779" or session('user_id') == "780" or session('user_id') == "781" or session('user_id') == "776" or session('user_id') == "777" or session('user_id') == "782" or session('user_id') == "778") echo header('Location: ../sessionexpired/?l='.$cLang);
	if (is_numeric(nnull(session("user_id"))."") == false) echo header ('Location: ../sessionexpired/?l=' . $cLang);

	opendb();
	
	$sql_ = "";
	$sqlV = "";
	if ($_SESSION['role_id'] == "2") {
		$sql_ = "select * from vehicles where id in (select id from vehicles where clientID=" . session("client_id") .  ") order by code asc";
		$sqlV = "select id from vehicles where clientID=" . session("client_id") ;
	} else {
		$sql_ = "select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") order by code asc";
		$sqlV = "select vehicleID from uservehicles where userID=" . session("user_id") . "" ;
	}
    $firstVehId = pg_fetch_result(query($sql_), 0, "id");
	
	$Allow = getPriv("settings", session("user_id"));
	if ($Allow == false) echo header ('Location: ../?l=' . $cLang . '&err=permission');
	
	$AllowUSettings = true;//getPriv("UserSettings", session("user_id"));
	$AllowCSettings = true;//getPriv("ClientSettings", session("user_id"));
	$AllowPSettings = true;//getPriv("PrivilegesUser", session("user_id"));
	
	$meni = 0;
	if ($AllowUSettings == true) {
		$meni = 1;
	}
	else {
		if ($AllowCSettings == true) {
			$meni = 2;
		} else {
			if ($AllowPSettings == true) {
				$meni = 3;
			} else {
				echo 1;
				echo header ('Location: ../?l=' . $cLang . '&err=permission') ;
			}
		}
	}
	 
 	$ds = query("select allowedrouting, allowedfm, allowedmess, allowedalarms from clients where id=" . session("client_id"));
	$allowedrouting = pg_fetch_result($ds, 0, "allowedrouting");
	$allowedFM = pg_fetch_result($ds, 0, "allowedfm");
	$allowedMess = pg_fetch_result($ds, 0, "allowedmess");
	$allowedAlarms = pg_fetch_result($ds, 0, "allowedalarms");
	$fm = '';
	$fm1 = '';
	$routes = '';
	$routes1 = '';
	$mess = '';
	$mess1 = '';
	$al = '';
	$al1 = '';
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
	if(!$allowedrouting)
	{
		$routes = 'return false;';
		$routes1 = 'opacity: 0.4;';
	}
	if(!$allowedMess)
	{
		$mess = 'return false;';
		$mess1 = 'opacity: 0.4;';
	}if(!$allowedAlarms)
	{
		$al = 'return false;';
		$al1 = 'opacity: 0.4;';
	}
		
	$dsTraceSnooze = query("select snooze from users where id=" . session("user_id"));
	$snooze = pg_fetch_result($dsTraceSnooze, 0, "snooze");

	
	$LastDay = DatetimeFormat(addDay(-1), 'd-m-Y');
	
	addlog(3);
	
?>
<script>
	AllowUSettings = '<?php echo strtolower($AllowUSettings."")?>';
	AllowCSettings = '<?php echo strtolower($AllowCSettings."")?>';
	AllowPSettings = '<?php echo strtolower($AllowPSettings."")?>';
	lang = '<?php echo $cLang?>';
    (function ($) {
        $.widget("ui.combobox", {
            _create: function () {
                var self = this,
					select = this.element.hide(),
					selected = select.children(":selected"),
					value = selected.val() ? selected.text() : "";
                var input = this.input = $("<input>")
					.insertAfter(select)
					.val(value)
					.autocomplete({
					    delay: 0,
					    minLength: 0,
					    source: function (request, response) {
					        var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
					        response(select.children("option").map(function () {
					            var text = $(this).text();
					            if (this.value && (!request.term || matcher.test(text)))
					                return {
					                    label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>"),
					                    value: text,
					                    option: this
					                };
					        }));
					    },
					    select: function (event, ui) {
					        ui.item.option.selected = true;
					        self._trigger("selected", event, {
					            item: ui.item.option
					        });
					    },
					    change: function (event, ui) {
					        if (!ui.item) {
					            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex($(this).val()) + "$", "i"),
									valid = false;
					            select.children("option").each(function () {
					                if ($(this).text().match(matcher)) {
					                    this.selected = valid = true;
					                    return false;
					                }
					            });
					            if (!valid) {
					                // remove invalid value, as it didn't match anything
					                $(this).val("");
					                select.val("");
					                input.data("autocomplete").term = "";
					                return false;
					            }
					        }
					    }
					})
					.addClass("ui-widget ui-widget-content ui-corner-left");

                input.data("autocomplete")._renderItem = function (ul, item) {
                    return $("<li></li>")
						.data("item.autocomplete", item)
						.append("<a>" + item.label + "</a>")
						.appendTo(ul);
                };

                this.button = $("<button type='button'>&nbsp;</button>")
					.attr("tabIndex", -1)
					.attr("title", "Show All Items")
					.insertAfter(input)
					.button({
					    icons: {
					        primary: "ui-icon-triangle-1-s"
					    },
					    text: false
					})
					.removeClass("ui-corner-all")
					.addClass("ui-corner-right ui-button-icon")
					.click(function () {
					    // close if already visible
					    if (input.autocomplete("widget").is(":visible")) {
					        input.autocomplete("close");
					        return;
					    }

					    // work around a bug (likely same cause as #5265)
					    $(this).blur();

					    // pass empty string as value to search for, displaying all results
					    input.autocomplete("search", "");
					    input.focus();
					});
            },

            destroy: function () {
                this.input.remove();
                this.button.remove();
                this.element.show();
                $.Widget.prototype.destroy.call(this);
            }
        });
    })(jQuery);
</script>
<script type="text/javascript">
	$(document).ready(function () {
	
	jQuery('body').bind('touchmove', function(e){e.preventDefault()});
	
	});
</script>

<body onResize="SetHeightSettingsPetar()">
<div id="rep"></div>
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="min-width: 717px;">
	<tr>
		<td class="resmenucol3" width="35%" height="32px" style="background-image:url(../images/traka.png); border-bottom:1px solid #999">
			&nbsp;<span class="reslogo1"><img src="../images/tiniLogo.png" border="0" align="absmiddle" />&nbsp;
			&nbsp;<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;</span>
			<a id="icon-home" href="../?l=<?php echo $cLang?>"><img src="../images/shome.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-live" href="../tracking/?l=<?php echo $cLang?>"><img src="../images/smap.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-rep"  href="../report/?l=<?php echo $cLang?>#rep/menu_1_1" ><img src="../images/sdocument.png" border="0" align="absmiddle" /></a>&nbsp;			
			<a id="icon-route" onclick="<?php echo $routes?>" style="<?php echo $routes1?>" href="../routes/?l=<?php echo $cLang?>" ><img src="../images/srouting.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-tv"  onclick="<?php echo $tv?>" style="<?php echo $tv1?>" href="../tv/?l=<?php echo $cLang?>#tv/menu_2_1" ><img src="../images/stv.png" border="0" align="absmiddle" /></a>&nbsp;
			&nbsp;<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;
		</td>
		<td width="65%" height="32px" style="background-image:url(../images/traka.png); border-bottom:1px solid #999" align="right" class="text2 resmenucol4">
			<span class="rescompany1"><?php echo dic("Settings.Company")?>: <strong><?php echo session("company")?></strong>&nbsp;&nbsp;&nbsp;<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;</span>
			<span class="resuser1"><?php echo dic("Settings.User")?>: <strong><?php echo session("user_fullname")?></strong>&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;</span>
			<!--a>
				<div id="alertsNew" class="corner5" style="background-color: Red; color: White; height: 13px; left: 0px; float: left; z-index: 134354; width: 13px; top: 0px; text-align: center;">1</div>
			</a-->
			<a id="icon-alert" style="position: relative; left: 15px; margin-left: -10px;<?php echo $al1?>">
				<img src="../images/warning1.png" onclick="<?php echo $al?>ShowHideAlerts()" border="0" align="absmiddle" style="cursor: pointer;" />
		        <span id="alertsNew" class="notify corner5"  style="visibility: hidden;"  disabled onclick="<?php echo $al?>ShowHideAlerts()">0</span>
				<!--input id="alertsNew" class="notify corner5" onclick="ShowHideAlerts()" style="visibility: hidden;" value="0" disabled /-->
			</a>&nbsp;
			<!--a>
				<div id="alertsNew" class="corner5" style="background-color: Red; color: White; height: 13px; left: 0px; float: left; z-index: 134354; width: 13px; top: 0px; text-align: center;">1</div>
			</a-->
			<a id="icon-mail" style="position: relative; left: 15px; margin-left: -10px;<?php echo $mess1?>">
				<img src="../images/mail.png" onclick="<?php echo $mess?>ShowHideMail()" border="0" align="absmiddle" style="cursor: pointer;" />
		        <span id="mailNew" class="notify corner5"  style="visibility: hidden;"  disabled onclick="<?php echo $mess?>ShowHideMail()">0</span>
				<!--input id="mailNew" class="notify corner5" onclick="ShowHideMail()" style="visibility: hidden;" value="0" disabled /-->
			</a>&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<a id="icon-costs" style="position: relative; left: 15px; margin-left: -10px;<?php echo $fm1?>">
				<img src="../images/cost24.png" onclick="<?php echo $fm?>costVehicle123('1', '<?php echo $firstVehId?>', 'SK-0001-AB')" border="0" align="absmiddle" style="cursor: pointer;" />
				<input id="costNew" class="notify corner5" onclick="<?php echo $fm?>ShowHideMail()" style="visibility: hidden;" value="0" disabled />
			</a>&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<a id="icon-sett"><img src="../images/ssettings.png" border="0" align="absmiddle" style="opacity:0.4"/></a>&nbsp;
			<a id="icon-help"><img src="../images/shelp.png" border="0" align="absmiddle" /></a>&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<a id="icon-logout" href="../logout/?l=<?php echo $cLang?>"><img width="24px" src="../images/exitNew1.png" border="0" align="absmiddle" /></a>&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</table>

	<audio id="soundHandle" loop="loop" style="display: none;"></audio>
	<div id="div-costMain" style="display:none" title="<?php echo dic("Reports.AddingCost")?>"></div>
	<div id="div-showMessage" style="display:none" title="<?php echo dic("Routes.ShowMessages")?>"></div>
	<div id="div-costnewMain" style="display:none" title="<?php echo dic("Reports.AddingNewCost")?>"></div>
	<div id="div-del-cost" style="display:none" title="Бришење на трошок"></div>
	<div id="div-locMain" style="display:none" title="<?php echo dic("Reports.AddNewExecutor")?>"></div>
	<div id="div-compMain" style="display:none" title="<?php echo dic("Reports.AddNewComponent")?>"></div>
	
<div id="div-mainalerts" onmouseover="clearTimeOutAlertView()" onmouseout="setTimeOutAlertView()" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; border: 0px; right: 35px; float: right; position: absolute; z-index: 9999; top: 43px; width: 315px; overflow-x: hidden; overflow-y: auto;"></div>
<div id="div-delComp" style="display:none" title="<?php echo dic("Reports.DelComp")?>"></div>

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td id="td-menu" width="250px" style="background-color:#efefef;" valign="top">
			<div id="div-menu" style="width:100%; overflow-y:auto; overflow-x:hidden">
				<div id="menu-1" class="menu-container" style="">
                    <a id="menu-title-1" href="#" class="menu-title text3" onClick="OnMenuClick(1)"><?php echo dic("Settings.Settings")?></a>
					<div id="menu-container-1" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px;">
						<a id="menu_set_1" href="#settings/menu_set_1" class="repoMenu corner5 text2" onClick="SettingsMeni(1)">▪ <?php echo dic("Settings.GeneralSett")?></a>
						<a id="menu_set_2" href="#settings/menu_set_2" class="repoMenu corner5 text2" onClick="SettingsMeni(2)">▪ <?php echo dic("Settings.UserSett")?></a>
	                    <a id="menu_set_3" href="#settings/menu_set_3" class="repoMenu corner5 text2" onClick="SettingsMeni(3)">▪ <?php echo dic("Settings.Pois")?></a>
						<a id="menu_set_4" href="#settings/menu_set_4" class="repoMenu corner5 text2" onClick="SettingsMeni(4)">▪ <?php echo dic("Settings.Vehicles")?></a>
                        <a id="menu_set_5" href="#settings/menu_set_5" class="repoMenu corner5 text2" onClick="SettingsMeni(5)">▪ <?php echo dic("Fm.OrgUnits")?></a>
                        <a id="menu_set_6" href="#settings/menu_set_6" class="repoMenu corner5 text2" onClick="SettingsMeni(6)">▪ <?php echo dic("Fm.Employees")?></a>
                        <a id="menu_set_7" href="#settings/menu_set_7" class="repoMenu corner5 text2" onClick="SettingsMeni(7)">▪ <?php echo dic("Settings.WorkTime")?></a>
						<a id="menu_set_8" href="#settings/menu_set_8" class="repoMenu corner5 text2" onClick="SettingsMeni(8)">▪ <?php echo dic("Settings.Scheduler")?></a>
						<a id="menu_set_9" href="#settings/menu_set_9" class="repoMenu corner5 text2" style="<?php echo $al1?>"  onClick="<?php echo $al?>SettingsMeni(9)">▪ <?php echo dic("Settings.Alerts")?></a>
					</div>
				</div>
				<?php
                If ($_SESSION['role_id'] == 2) {
                ?>
				<div id="menu-2" class="menu-container" style="">
                    <a id="menu-title-2" href="#" class="menu-title text3" onClick="OnMenuClick(2)"><?php echo dic("Settings.Reports")?></a>
					<div id="menu-container-2" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px;">
						<a id="menu_set_10" href="#settings/menu_set_10" class="repoMenu corner5 text2" onClick="SettingsMeni(10)">▪ <?php echo dic("Reports.Log")?></a>
						<!--a id="menu_set_11" href="#settings/menu_set_11" class="repoMenu corner5 text2" style="<?php echo $mess1?>"  onClick="<?php echo $mess?>SettingsMeni(11)">▪ <?php echo dic("Settings.MessagesNew")?></a-->
	            	</div>
				</div>
				<?php } ?>
			</div>
		</td>
		<td width="4px" style=" background-color:#efefef;">&nbsp;</td>
		<td id="race-td" width="9px" style="border-left:1px solid #cccccc;">
			<div id="race-img" style="width:8px; height:50px; background-image:url(../images/race.png); background-position:-8px 0px; cursor:pointer" onClick="ShowHideLeftMenu()"></div>
		</td>
		<!--td height="100%" valign="top" >
			<div style="width:100%; height:5px;"></div>
          	<div style="width:100%; height:5px;"></div>
			<div id="report-content" style="width:98%; text-align:left; height:500px; margin-left:10px; border:1px solid #bbb; background-color:#fafafa; overflow-y:hidden" class="corner5">
            <iframe id="ifrm-cont" src="USettings.php" width="100%" frameborder="0" scrolling="yes" style="overflow-x: hidden;overflow-y: scroll"></iframe>
            </div>
		</td-->
		<td height="100%" valign="top" >
			<div style="width:100%; height:5px;"></div>	
			<div id="vremence" style="display: none; width:98%; margin-left:10px; height:35px; border:1px solid #bbbbbb; background-color:#eee; padding-top:5px" class="corner5 text2">
				<div style="display: inline; float: left; margin-left: 10px; margin-top: 7px;"><?php echo dic_("Reports.Period")?>:</div>
				<div style="display: inline; float: left; margin-left: 10px; margin-top: 2px;">
					<input id="txtNewDate" onclick="opencal()" type="text" width="180px" class="textboxCalender corner5 text2" style="width: 200px; height: 24px; cursor: pointer;" value="" />
				</div>
				<img id="imgkal" src="../images/cal.png" onclick="opencal()" style="display: inline; float: left; position: relative; margin-top: 2px; left: -25px; cursor: pointer" />
				<span id="lbl-start-date" style="display: none"><input id="txtSDate" type="text" width="80px" class="textboxCalender corner5 text2" value="<?php echo $LastDay;?>" /></span>
				<span id="lbl-end-date" style="display: none;"><input id="txtEDate" type="text" width="80px" class="textboxCalender corner5 text2" value="<?php echo $LastDay;?>" /></span>
				
				<?php if($yourbrowser == "1") { ?>&nbsp;<?php } else { ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?><button style="<?php if($yourbrowser == "1") { ?>margin-left: -20px;<?php } ?>" id="showBtn" onClick="loadReport()"><?php dic("Reports.Show")?></button>
			<div id="vehdiv" class="roundedMenu" style="z-index:99999999; background-color: #FAFAFA; border:1px solid #cccccc; width:175px; height:190px; overflow-y: auto; position: relative; display: none; max-height: 500px"></div>
			</div>		
			
			<div style="width:100%; height:5px;"></div>
			<div id="report-content" style="min-width: 560px; text-align:left; height:580px; margin-left:10px; border:1px solid #bbb; background-color:#fafafa; overflow-x:hidden ;overflow-y:auto; " class="corner5 resizberi">
				<iframe id="ifrm-cont" src="USettings.php" width="100%" frameborder="0" scrolling="yes" style="overflow-x: hidden;overflow-y: auto"></iframe>					
			</div>
		</td>
	</tr>
</table>

<div id="kalendarM" style="display: none; width: 625px; height: 168px; background-color: White; position: absolute; left: 338px; top: 68px;" class="shadow">
	<iframe id="ifrmkal" src="timeframe.php" style="width:100%; border: 0px; height: 100%" scrolling="no"></iframe>
</div>

<div id="dialog-message" title="<?php echo dic("Reports.Message")?>" style="display:none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px"></div>
	</p>
</div>
<div id="dialog-message1" title="<?php dic("Reports.Warning")?>" style="display:none">
	 <p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox1" style="font-size:14px"></div>
	</p>
</div>
<div id="div-loading" class="BlackText2 shadow"><img src="../images/loading.gif" border="0" align="absmiddle" width="16" height="16" /> <?php echo dic("Settings.Loading")?>...</div>
<div id="dialog-map" title="<?php echo dic("Reports.ViewOnMap")?>" style="display:none">
<p></p>
</div>
<div id="Loading-gif" style="display:none; width:200px; height:100px;" title="Loading...">
    <img src="../images/loading_bar1.gif" style="width:150px"/>
</div>
</body>
</html>

<script>
var seluser = 0;

	function opencal()
	{
		if($('#kalendarM').css('display') == 'none')
			$('#kalendarM').css({display:'block'});
		else
			$('#kalendarM').css({display:'none'});
		document.getElementById("txtNewDate").blur();

	

	}

	checkHash()
	var allowedMess = '<?php echo $allowedMess?>';
	var allowedAlarms = '<?php echo $allowedAlarms?>';
	if(allowedAlarms == '1')
	{
		var snoozeTmp = 0;
		snooze = '<?php echo $snooze?>';
		$('#alertsNew').val('0');
		$('#div-mainalerts').css({ height: (document.body.clientHeight - 75) + 'px' });
	}
    $(function () {
        SetHeightSettingsPetar()
        $("#radio").buttonset();
        
        //$('#btnSave').button({ icons: { primary: "ui-icon-check"} });
    });
    //SettingsMeni(<?php echo $meni?>)
    
    function test() {

    }
	$('#showBtn').button({ icons: { primary: "ui-icon-search"} })    
	if(allowedAlarms == '1')
	{    
    	ShowHideAlerts();
		//ShowHideMail();
		snoozeAlarm();
		AjaxNotify();
	}
	if(allowedMess == '1')
		AjaxMessageNotify();
</script>


<?php
if($allowedAlarms)
{
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
}
closedb();
?>
