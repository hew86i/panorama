<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php opendb();?>

<?php

	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);  // [josip] za error reports

	header("Content-type: text/html; charset=utf-8");
	opendb();

	$Allow = getPriv("employees", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);

	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	$yourbrowser1 = (bool) strpos($ua['userAgent'], "Macintosh");

	addlog(47);
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php
	if($yourbrowser == "1")
	{ ?>
	<style type="text/css">
		html { 
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch; 

		}
		body {
		    height: 100%;
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch;
		}

		.ui-button { margin-left: -1px; }
		.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
		.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; width: '<?php if($yourbrowser == "1") { echo '81%'; } else { echo '82%'; } ?>'; height: 25px; }

	</style>
	<?php
	}
	?>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	

	<link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../live/style.css">

	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/roundIE.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
    <script type="text/javascript" src="../pdf/pdf.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="fm.js"></script>
	<script type="text/javascript" src="./js/highcharts.src.js"></script>
  
    <link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
    <script src="../js/jquery-ui.js"></script>
    

    
    <script type="text/javascript">
    (function ($) {
        $.widget("ui.combobox", {
            _create: function () {
                     var self = this,
					 select = this.element.hide(),
					 selected = select.children(":selected"),
					 value = selected.val() ? selected.text() : "";
                	 var input = this.input = $("<input>")
					 .insertAfter(select)
					 .val("")
					 .autocomplete({
					    delay: 0,
					    minLength: 0,
					    source: function (request, response) {
					        var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
					        response(select.children("option").map(function () {
					            var text = $(this).text();
					            if (this.value && (!request.term || matcher.test(text))) {
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
					            }
					        }));
					        if (Browser()!='iPad')
					        	$('.ui-autocomplete').css({ width: '610px' });
				        	else
				        		$('.ui-autocomplete').css({ width: '500px' });
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
                    input.autocomplete("widget")[0].style.zIndex = '2000';
                    input.autocomplete("widget")[0].style.overflowX = 'hidden';
                    input.autocomplete("widget")[0].style.overflowY = 'auto';
                    input.autocomplete("widget")[0].style.maxHeight = '210px';
                    if (Browser()!='iPad')
                    	input.autocomplete("widget")[0].style.width = '610px';
                	else
                		input.autocomplete("widget")[0].style.width = '500px';
                    return $("<li></li>")
						.data("item.autocomplete", item)
						.append("<a>" + item.label + "</a>")
						.appendTo(ul);
                	};
					this.button = $("<button type='button'>&nbsp;</button>")
					.attr("tabIndex", -1)
					.attr("title", dic("show", lang) + " " + dic("all", lang) + " " + dic("Pois", lang))
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
					    if (input.autocomplete("widget").is(":visible")) {
					        input.autocomplete("close");
					        return;
					    }
						$(this).blur();
						 input.autocomplete("search", "");
					    input.focus();
						input.autocomplete("widget")[0].style.zIndex = '2000';
					    input.autocomplete("widget")[0].style.overflowX = 'hidden';
					    input.autocomplete("widget")[0].style.overflowY = 'auto';
					    input.autocomplete("widget")[0].style.maxHeight = '210px';
					    if (Browser()!='iPad')
					    	input.autocomplete("widget")[0].style.width = '610px';
				    	else
							input.autocomplete("widget")[0].style.width = '500px';
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

        $(function () {
        $("#combobox").combobox();
        $("#toggle").click(function () {
            $("#combobox").toggle();
        });
    });
	</script>
	
	<script type="text/javascript">
    (function ($) {
        $.widget("ui.combobox", {
            _create: function () {
                     var self = this,
					 select = this.element.hide(),
					 selected = select.children(":selected"),
					 value = selected.val() ? selected.text() : "";
                	 var input = this.input = $("<input>")
					 .insertAfter(select)
					 .val("")
					 .autocomplete({
					    delay: 0,
					    minLength: 0,
					    source: function (request, response) {
					        var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
					        response(select.children("option").map(function () {
					            var text = $(this).text();
					            if (this.value && (!request.term || matcher.test(text))) {
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
					            }
					        }));
					        if (Browser()!='iPad')
					        	$('.ui-autocomplete').css({ width: '610px' });
				        	else
				        		$('.ui-autocomplete').css({ width: '500px' });
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
                    input.autocomplete("widget")[0].style.zIndex = '2000';
                    input.autocomplete("widget")[0].style.overflowX = 'hidden';
                    input.autocomplete("widget")[0].style.overflowY = 'auto';
                    input.autocomplete("widget")[0].style.maxHeight = '210px';
                    if (Browser()!='iPad')
                    	input.autocomplete("widget")[0].style.width = '610px';
                	else
                		input.autocomplete("widget")[0].style.width = '500px';
                    return $("<li></li>")
						.data("item.autocomplete", item)
						.append("<a>" + item.label + "</a>")
						.appendTo(ul);
                	};
					this.button = $("<button type='button'>&nbsp;</button>")
					.attr("tabIndex", -1)
					.attr("title", dic("show", lang) + " " + dic("all", lang) + " " + dic("Pois", lang))
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
					    if (input.autocomplete("widget").is(":visible")) {
					        input.autocomplete("close");
					        return;
					    }
						$(this).blur();
						 input.autocomplete("search", "");
					    input.focus();
						input.autocomplete("widget")[0].style.zIndex = '2000';
					    input.autocomplete("widget")[0].style.overflowX = 'hidden';
					    input.autocomplete("widget")[0].style.overflowY = 'auto';
					    input.autocomplete("widget")[0].style.maxHeight = '210px';
					    if (Browser()!='iPad')
					    	input.autocomplete("widget")[0].style.width = '610px';
				    	else
							input.autocomplete("widget")[0].style.width = '500px';
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

        $(function () {
        $("#comboboxVlez").combobox();
        $("#toggle").click(function () {
            $("#comboboxVlez").toggle();
        });
    });
	</script>
	
	<script type="text/javascript">
    (function ($) {
        $.widget("ui.combobox", {
            _create: function () {
                     var self = this,
					 select = this.element.hide(),
					 selected = select.children(":selected"),
					 value = selected.val() ? selected.text() : "";
                	 var input = this.input = $("<input>")
					 .insertAfter(select)
					 .val("")
					 .autocomplete({
					    delay: 0,
					    minLength: 0,
					    source: function (request, response) {
					        var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
					        response(select.children("option").map(function () {
					            var text = $(this).text();
					            if (this.value && (!request.term || matcher.test(text))) {
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
					            }
					        }));
					        if (Browser()!='iPad')
					        	$('.ui-autocomplete').css({ width: '610px' });
				        	else
				        		$('.ui-autocomplete').css({ width: '500px' });
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
                    input.autocomplete("widget")[0].style.zIndex = '2000';
                    input.autocomplete("widget")[0].style.overflowX = 'hidden';
                    input.autocomplete("widget")[0].style.overflowY = 'auto';
                    input.autocomplete("widget")[0].style.maxHeight = '210px';
                    if (Browser()!='iPad')
                    	input.autocomplete("widget")[0].style.width = '610px';
                	else
                		input.autocomplete("widget")[0].style.width = '500px';
                    return $("<li></li>")
						.data("item.autocomplete", item)
						.append("<a>" + item.label + "</a>")
						.appendTo(ul);
                	};
					this.button = $("<button type='button'>&nbsp;</button>")
					.attr("tabIndex", -1)
					.attr("title", dic("show", lang) + " " + dic("all", lang) + " " + dic("Pois", lang))
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
					    if (input.autocomplete("widget").is(":visible")) {
					        input.autocomplete("close");
					        return;
					    }
						$(this).blur();
						 input.autocomplete("search", "");
					    input.focus();
						input.autocomplete("widget")[0].style.zIndex = '2000';
					    input.autocomplete("widget")[0].style.overflowX = 'hidden';
					    input.autocomplete("widget")[0].style.overflowY = 'auto';
					    input.autocomplete("widget")[0].style.maxHeight = '210px';
					    if (Browser()!='iPad')
					    	input.autocomplete("widget")[0].style.width = '610px';
				    	else
							input.autocomplete("widget")[0].style.width = '500px';
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

        $(function () {
        $("#comboboxIzlez").combobox();
        $("#toggle").click(function () {
            $("#comboboxIzlez").toggle();
        });
    });
	</script>


    </head>
    <style type="text/css"> 
 		body{ overflow-y:auto }
 		body{ overflow-x:auto }
 	</style>
    <body>
   	
   	<table <?php if($yourbrowser == "1") {?>width="98%" style="padding-left:20px;padding-top: 25px;"<?php }else{?> width="95%"  style="padding-left:40px;padding-top: 25px;"<?php } ?>class="text2">
    <tr>
    <td width="50%" align="left"><div class="textTitle" ><?php echo dic_("Settings.Alerts")?></div></td>
    <td colspan="5" width="50%" align="right" ><button  id="add5" onclick="addAlerts()"><?php dic("Settings.Add") ?></button></td>
    </tr>
    </table>	
  
    <br><br>
    
     <?php
$clienttypeid = dlookup("select clienttypeid from clients where id = " . session("client_id"));
if ($clienttypeid == 6) {
	$colspan = 9;
} else {
	$colspan = 8;
}   
    
$allowed2 = 0;
$allowed3 = 0;

$strOrg = "";
if ($_SESSION['role_id'] == "2") {
	$strOrg = "select * from organisation where id in (
	select distinct organisationid from vehicles where clientid=" . session("client_id") . " 
	and active='1' and organisationid <> 0) order by code::INTEGER";
} else {
	/*$strOrg = "select * from organisation where id in (
	select distinct organisationid from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") 
	and active='1' and organisationid <> 0) order by code::INTEGER";*/
	$strOrg = "select s.id, s.code, s.name, s.description from (
	select *, (select count(*) from vehicles where clientid=" . session("client_id") . " and organisationid=o.id) allinoe,
	(select count(*) from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and organisationid=o.id) vehinoe
	 from organisation o where id in (select distinct organisationid from vehicles where id in (select vehicleid from uservehicles where 
	userid=" . session("user_id") . ") and active='1' and organisationid <> 0) order by code::INTEGER) s where s.allinoe=s.vehinoe";
}
$strCom = "";
if ($_SESSION['role_id'] == "2") {
	$strCom = "select * from vehicles where clientID=" . session("client_id") . " and active='1' order by cast(code as integer) asc" ;
	$allowFuel = dlookup("select count(*) from vehicles where clientID=" . session("client_id") . " and active='1' and allowfuel = '1'");
} else {
	$strCom = "select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and active='1' order by cast(code as integer) asc";
	$allowFuel = dlookup("select count(*) from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and active='1' and allowfuel = '1'");
}

if (pg_num_rows(query($strOrg)) > 0) {
	$allowed2 = 1;
}

if ((dlookup("select count(*) from vehicles where clientID=" . session("client_id") . " and active='1'")) == pg_num_rows(query($strCom))) {
	$allowed3 = 1;
}

	$metric = nnull(dlookup("select metric from users where id = " . session("user_id")), "1");	
	  if ($metric == 'mi') {
		$value = 0.621371;
	  }	else {
		$value = 1;
	  }
	  If ($metric == "Km" or $metric == 'km') {
          $unitSpeed = "Km/h";
      } Else {
          $unitSpeed = "mph";
      }
        $cnt7 = 1;
		
    	//$alerts = query("select * from alarms a left join alarmtypes at on a.alarmtypeid=at.id left join vehicles v on a.vehicleid=v.id where a.clientid= " .session("client_id"). " order by a.uniqid");
		$alerts = query("select distinct uniqid from alarms where clientid=" . Session("client_id") . "");
		if(pg_num_rows($alerts)==0){
		?>	
		
		<div id="noData" style="padding-left:43px; font-size:22px; font-style:italic; padding-bottom:40px" class="text4">
 		<?php dic("Reports.NoData1")?>
		</div>	
		<?php
		}
		else
		{  //w0
		?>
		<table  <?php if($yourbrowser == "1") {?>width="98%" style="padding-left:20px;"<?php }else{?> width="95%"  style="padding-left:40px;"<?php } ?>class="text2">
        <tr>
			<td height="22px" style="color:#fff; font-weight:bold; font-size:14px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b;" colspan="<?= $colspan?>" class="text2">
				<?php echo dic_("Settings.ListAlertsVeh")?>
			</td>
        </tr>	
		<tr>
        <td width="4%" align = "center"  height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;">&nbsp;</td>
        <td align = "left" width="24%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;">&nbsp;&nbsp;<?php dic("Settings.TypeOfAlert") ?></td>
		<td align = "center" width="18%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.Vehicle") ?>/<?php dic("Fm.Vehicles") ?></td>  
		<td align = "left" width="14%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;">&nbsp;&nbsp;<?php echo dic_("Reports.Email")?></td>
		<?php
		if ($clienttypeid == 6) {
			?>
			<td align = "left" width="8%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;">&nbsp;&nbsp;<?php echo dic_("Settings.SMS")?></td>
			<?php
		}
		?>
		<td align = "center" width="11%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Sound") ?> (snooze)</td>
        <td align = "center" width="9%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php echo dic_("Settings.AvailableFor")?></td>
        <td align = "center" width="6%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><font color = "#ff6633"><?php dic("Settings.Change")?></font></td> 
		<td align = "center" width="6%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><font color = "#ff6633"><?php dic("Tracking.Delete")?></font></td>
        </tr>

        <!-- <tr>  greska e -->

		<?php
		$rowCnt = 0;
		while($row1 = pg_fetch_array($alerts))
	 		{  //w1
					if($row1["uniqid"] == "")
					{  //w2
						
						//$rowCnt = 0;
//zakomentirano na 29.08.2014 - poradi zabelska od polyesterday
//$rows = query("select a.*, at.description, v.registration, v.code, v.id vid from alarms a left join alarmtypes at on a.alarmtypeid=at.id left join vehicles v on a.vehicleid=v.id where a.clientid=" . Session("client_id") . " and a.uniqid is null order by cast(v.code as integer) asc");
						$rows = query("select a.*, at.description, v.registration, v.code, v.id vid from alarms a left join alarmtypes at on a.alarmtypeid=at.id left join vehicles v on a.vehicleid=v.id where a.clientid=" . Session("client_id") . " and a.uniqid is null and at.id <> 11 order by cast(v.code as integer) asc");
						
						while($row3 = pg_fetch_array($rows))
	 					{  //w3
if ($_SESSION['role_id'] == "2") {  //w4
	$checkVeh = dlookup("select count(*) from vehicles where clientID=" . session("client_id") . " and active='1' and id=".$row3["vid"]);
} //w4.
 else {  //w5
	$checkVeh = dlookup("select count(*) from vehicles where id in (select vehicleid from uservehicles where vehicleid=" . $row3["vid"] . " and userid=" . session("user_id") . ") and active='1'");
}  //w5.

if ($checkVeh == 0) $fontVeh = "red";
else $fontVeh = "";

if ($checkVeh > 0) {  //w6
	 						$rowCnt = $rowCnt +1;
	 						?>	 							
	 							<tr>
									<td align = "left" height="30px" class="text2" style="padding-left:10px; padding-right:10px; background-color:#fff; border:1px dotted #B8B8B8; ">
									<?php echo $rowCnt?>
									</td>
									<td align = "left" height="30px" class="text2" style="padding-left:10px;background-color:#fff; border:1px dotted #B8B8B8; ">
										<b>
										<?php							
										if ($row3["description"] == "Панично копче"){
											dic("alarmpanic");
										}
										if ($row3["description"] == "Аларм Асистенција"){
											dic("assistance");
										}
										if ($row3["description"] == "Акумулатор"){
											dic("acumulator");
										}
										if ($row3["description"] == "Аларм од возило"){
											dic("vehicleAlarm");
										}
										if ($row3["description"] == "Капаче за гориво"){
											dic("fuelCap");
										}
										if ($row3["description"] == "Нагло кочење"){
											dic("suddenBraking");
										}
										if ($row3["description"] == "Надминување на брзина"){
											dic("speedExcess");
										}
										if ($row3["description"] == "Влез во зона"){
											dic("enterZone");
										}
										if ($row3["description"] =="Излез од зона"){
											dic("leaveZone");
										}
										if ($row3["description"] == "Посета на точка од интерес"){
											dic("visitPOI");
										}
										if ($row3["description"] == "Повеќе од 30 минути без податок со вклучен мотор"){
											dic("Settings.30MinNoDataIgnON");
										}
										if ($row3["description"] == "Нередоследност"){
											dic("unOrdered");
										}
										if ($row3["description"] == "Задржување подолго од дозволеното"){
											dic("stayMoreThanAllow");
										}
										if ($row3["description"] == "Задржување надвор од локација"){
											dic("stayOutOfLocat");
										}
										if ($row3["description"] == "Напуштање на рута"){
											dic("leaveRoute");
										}
										if ($row3["description"] == "Пауза"){
											dic("pause");
										}
										if ($row3["description"] == "Истекување на регистрација"){
											dic("regExpire");
										}
										if ($row3["description"] == "Сервис"){
											dic("service");
										}
										if ($row3["description"] == "Зелен картон"){
											dic("greenCard");
										}
										if ($row3["description"] == "Полномошно"){
											dic("polnomLicense");
										}
										if ($row3["description"] == "Договор"){
											dic("agreement");
										}
										if ($row3["description"] == "Неавторизирано користење на возило"){
											dic("unauthorizedUseVehicle");
										}
										if ($row3["description"] == "Користење на возило без RFID"){
											dic("NoRFIDVehicle");
										}
										if ($row3["description"] == "Возило во дефект"){
											dic("VehicleDefect");
										}
										if ($row3["description"] == "Прекин на напојување на акумулаторот"){
											dic("acumulatorPowerSupplyInterruption");
										}
										if ($row3["description"] == "Предна лева врата"){
											dic("prednaleva");
										}
										if ($row3["description"] == "Предна десна врата"){
											dic("prednadesna");
										}
										if ($row3["description"] == "Странична врата"){
											dic("stranicnavrata");
										}
										if ($row3["description"] == "Задна врата"){
											dic("zadnavrata");
										}
										if ($row3["description"] == "Возач"){
											dic("stanatvozac");
										}
										if ($row3["description"] == "Неавторизирано придвижување"){
											dic("Settings.Tow");
										}
										if ($row3["description"] == "Слаб акумулатор"){
											dic("Settings.WeakAcc");
										}
										if ($row3["description"] == "Ненадеен пад на гориво!"){
											dic("Settings.FallFuel");
										}
										
										?>
										</b>
										<br>
<?php
if ($row3["alarmtypeid"] == "17"){  //w7
	if ($row3["remindme"] == "") {  //w8
		
	}  //w8.
	else {  //w9
		$arr = explode(" ", $row3["remindme"]);
		if ($arr[1] == "days") $remindme = $arr[0] . " " . dic_("Reports.Days_");
		else {  //w10
			$remindme = round($arr[0] * $value,0) . " " . $metric;
		}  //w10.
		echo " (". $remindme ." " . dic_("Settings.Before") . ")";
	} //w9.
}  //w7.

if ($row3["alarmtypeid"] == "18"){
	if ($row3["remindme"] == "") {
		
	} else {
		$arr = explode("; ", $row3["remindme"]);
		if(count($arr) == 1) {
			$arr1 = explode(" ", $arr[0]);
			if ($arr1[1] == "days") $remindme = $arr1[0] . " " . dic_("Reports.Days_");
			else $remindme = round($arr1[0] * $value,0) . " " . $metric;
			echo " (". $remindme ." " . dic_("Settings.Before") . ")";
		} else {
			$arr1 = explode(" ", $arr[0]);
			if ($arr1[1] == "days") $remindme = $arr1[0] . " " . dic_("Reports.Days_");
			else $remindme = round($arr1[0] * $value,0) . " " . $metric;
			
			$arr2 = explode(" ", $arr[1]);
			if ($arr2[1] == "days") $remindme1 = $arr2[0] . " " . dic_("Reports.Days_");
			else $remindme1 = round($arr2[0] * $value,0) . " " . $metric;
			
			echo " (". $remindme .", " . $remindme1 . " " . dic_("Settings.Before") . ")";
		}
	}
	
}

if ($row3["alarmtypeid"] == "20"){
	if ($row3["remindme"] == "") {
		
	} else {
		$arr = explode(" ", $row3["remindme"]);
		if ($arr[1] == "days") $remindme = $arr[0] . " " . dic_("Reports.Days_");
		else {
			$remindme = round($arr[0] * $value,0) . " " . $metric;
		}
		echo " (". $remindme ." " . dic_("Settings.Before") . ")";
	}
}
?>
<?php if ($row3["alarmtypeid"] == "7"){
		?>(<?php echo $row3['speed'];?> kmh)<?php
	}
?>
<?php if ($row3["alarmtypeid"] == "10"){
		?>(<?php 
			
			$najdiIme = query("select * from pointsofinterest where id = ".$row3["poiid"]);
			$imeto = pg_fetch_result($najdiIme, 0, "name");
			echo $imeto;
		?>)<br>
(<?php echo $row3['timeofpoi'];?> <?php echo dic_("Settings.minutes")?>)		
		
<?php }?>	

<?php if ($row3["alarmtypeid"] == "9"){
		?>(<?php 
			
			$najdiIme = query("select * from pointsofinterest where id = ".$row3["poiid"]);
			$imeto = pg_fetch_result($najdiIme, 0, "name");
			echo $imeto;
	    ?>) <?php }?>
	    
<?php if ($row3["alarmtypeid"] == "8"){
		?>(<?php 
			
			$najdiIme = query("select * from pointsofinterest where id = ".$row3["poiid"]);
			$imeto = pg_fetch_result($najdiIme, 0, "name");
			echo $imeto;
	    ?>) <?php }?>
	    
<?php



								?>	
											
									</td>

									<td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; color:<?php echo $fontVeh?>">
										<?php echo $row3["registration"]?> (<?php echo $row3["code"]?>)
									</td>
									<td align = "left" height="30px" class="text2" style="line-height:15px; padding-left:10px;background-color:#fff; border:1px dotted #B8B8B8;">
										<?php 
										if($row3["emails"]!="")
										{
											$emls = $row3["emails"];
											$emls = str_replace(',', '<br>', $emls);
											echo $emls;
										}
										else {
										?> &nbsp;
										<?php
										}
										?>
									</td>
									<?php
									if ($clienttypeid == 6) {
										?>
										<td align = "left" height="30px" class="text2" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8; ">
										<?= nnull($row3["sms"], "/")?>	
										</td>	
										<?php
									}
									?>
									<td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">


									<?php echo dic_("Settings.Sound") . " " . $row3["soundid"]; ?>		
									<?php 
									$snoozeNajdi = query("select * from users where id=" . session("user_id") ."");
									$snoozot = pg_fetch_result($snoozeNajdi, 0, "snooze");
			
									if($snoozot==0)
									{
											echo dic("Settings.NoRepetition");
										}
										else 
									{
										?> 
									<?php
										echo "(" . $snoozot . " " . dic_("Reports.Minutes") . ")";
									}
									?>
									</td>
									<td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
										<?php
										
										if($row3["available"] ==1)
										{
										?>
											<?php echo dic_("Settings.User")?>
										<?php
										}
										else if($row3["available"]==2)
										{
										?>
											<?php echo dic_("Reports.OrgUnit")?>
										<?php
										}
										else if($row3["available"]==3)
										{
										?>
											<?php echo dic_("Settings.Company")?>
										<?php
										}
										else {
											?>
											/
										<?php
										}
										?>

									</td>

									<td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
										<button id="btnEditA<?php echo $cnt7?>"  onclick="EditAlertClick(<?php echo $row3["id"]?>)" style="height:22px; width:30px"></button>
									</td>
									<td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
										<button id="DelBtnA<?php echo $cnt7?>"  onclick="DeleteAlertClick(<?php echo $row3["id"]?>)" style="height:22px; width:30px"></button>
									</td>
								</tr>
	 						<?php
	 						$cnt7++;
}  //w6.
						  } //w3.
						}  //w2.
						else  // ako uniqid ima vrednost (ne e prazno) -------------------------------
						{
						$rowsVeh = query("select v.registration, v.code, v.id vid from alarms a left join vehicles v on a.vehicleid=v.id where a.clientid=" . Session("client_id") . " and a.uniqid = " . $row1["uniqid"] . " order by cast(v.code as integer) asc");
						$registration  = "";

						//$tmp=1;
						while($row3 = pg_fetch_array($rowsVeh))
	 					{
	 						$tmpColor = '#2f5185';
	 						//if ($tmp==2) {$tmpColor='#419fe2';};
	 						//if ($tmp==3) {$tmpColor='#24a8bc';};
		 					if ($_SESSION['role_id'] == "2") {
								$checkVeh = dlookup("select count(*) from vehicles where clientID=" . session("client_id") . " and active='1' and id=".$row3["vid"]);
							} else {
								$checkVeh = dlookup("select count(*) from vehicles where id in (select vehicleid from uservehicles where vehicleid=" . $row3["vid"] . " and userid=" . session("user_id") . ") and active='1'");
							}
	if ($checkVeh == 0) $fontVeh = "red";
	else $fontVeh = "";
	if ($checkVeh > 0) {
		$registration .= '<span style="color:'.$fontVeh.'">'.$row3["registration"]. ' ('.$row3["code"].'); </span> ';
	}

	 						//$tmp=$tmp+1;
	 						//if ($tmp==4) {$tmp=1;};
						}
						//$rowCnt=0;
						//

$rows = query("select a.*, at.description, v.registration from alarms a left join alarmtypes at on a.alarmtypeid=at.id left join vehicles v on a.vehicleid=v.id where a.clientid=" . Session("client_id") . " and a.uniqid = " . $row1["uniqid"] . " limit 1");
while($row3 = pg_fetch_array($rows))
{

	if ($row3["typeofgroup"] == 2) {
		$registration = dlookup("select name from organisation where id=" . $row3["settings"]) . "<br>" . $registration;

		if ($_SESSION['role_id'] == "2") {
			$cntAllowVeh = dlookup("select count(*) from vehicles where clientID=" . session("client_id") . " and organisationid = " . $row3["settings"] . " and active='1'") ;
		} else {
			$cntAllowVeh = dlookup("select count(*) from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and organisationid = " . $row3["settings"] . " and active='1'");
		}
	}
	if ($row3["typeofgroup"] == 3) {
		$registration = dic_("Tracking.AllVehCompany") . "<br>" . $registration;

		if ($_SESSION['role_id'] == "2") {
			$cntAllowVeh = dlookup("select count(*) from vehicles where clientID=" . session("client_id") . " and active='1'") ;
		} else {
			$cntAllowVeh = dlookup("select count(*) from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and active='1'");
		}
	}

			if ($cntAllowVeh > 0) {
	 						$rowCnt = $rowCnt +1;
	 						?>
	 							<tr>
	 								<td align = "left" height="30px" class="text2" style="padding-left:10px; padding-right:10px; background-color:#fff; border:1px dotted #B8B8B8; ">
									<?php echo $rowCnt ?>
									</td>
									<td align = "left" height="30px" class="text2" style="padding-left:10px;background-color:#fff; border:1px dotted #B8B8B8; ">
										<b>
										<?php							
										if ($row3["description"] == "Панично копче"){
											dic("alarmpanic");
										}
										if ($row3["description"] == "Аларм Асистенција"){
											dic("assistance");
										}
										if ($row3["description"] == "Акумулатор"){
											dic("acumulator");
										}
										if ($row3["description"] == "Аларм од возило"){
											dic("vehicleAlarm");
										}
										if ($row3["description"] == "Капаче за гориво"){
											dic("fuelCap");
										}
										if ($row3["description"] == "Нагло кочење"){
											dic("suddenBraking");
										}
										if ($row3["description"] == "Надминување на брзина"){
											dic("speedExcess");
										}
										if ($row3["description"] == "Влез во зона"){
											dic("enterZone");
										}
										if ($row3["description"] =="Излез од зона"){
											dic("leaveZone");
										}
										if ($row3["description"] == "Посета на точка од интерес"){
											dic("visitPOI");
										}
										if ($row3["description"] == "Повеќе од 30 минути без податок со вклучен мотор"){
											dic("Settings.30MinNoDataIgnON");
										}
										if ($row3["description"] == "Нередоследност"){
											dic("unOrdered");
										}
										if ($row3["description"] == "Задржување подолго од дозволеното"){
											dic("stayMoreThanAllow");
										}
										if ($row3["description"] == "Задржување надвор од локација"){
											dic("stayOutOfLocat");
										}
										if ($row3["description"] == "Напуштање на рута"){
											dic("leaveRoute");
										}
										if ($row3["description"] == "Пауза"){
											dic("pause");
										}
										if ($row3["description"] == "Истекување на регистрација"){
											dic("regExpire");
										}
										if ($row3["description"] == "Сервис"){
											dic("service");
										}
										if ($row3["description"] == "Зелен картон"){
											dic("greenCard");
										}
										if ($row3["description"] == "Полномошно"){
											dic("polnomLicense");
										}
										if ($row3["description"] == "Договор"){
											dic("agreement");
										}
										if ($row3["description"] == "Неавторизирано користење на возило"){
											dic("unauthorizedUseVehicle");
										}
										if ($row3["description"] == "Користење на возило без RFID"){
											dic("NoRFIDVehicle");
										}
										if ($row3["description"] == "Возило во дефект"){
											dic("VehicleDefect");
										}
										if ($row3["description"] == "Прекин на напојување на акумулаторот"){
											dic("acumulatorPowerSupplyInterruption");
										}
										if ($row3["description"] == "Предна лева врата"){
											dic("prednaleva");
										}
										if ($row3["description"] == "Предна десна врата"){
											dic("prednadesna");
										}
										if ($row3["description"] == "Странична врата"){
											dic("stranicnavrata");
										}
										if ($row3["description"] == "Задна врата"){
											dic("zadnavrata");
										}
										if ($row3["description"] == "Возач"){
											dic("stanatvozac");
										}
										if ($row3["description"] == "Неавторизирано придвижување"){
											dic("Settings.Tow");
										}
										if ($row3["description"] == "Слаб акумулатор"){
											dic("Settings.WeakAcc");
										}
										if ($row3["description"] == "Ненадеен пад на гориво!"){
											dic("Settings.FallFuel");
										}
										
										?>
										</b>
										<br>


<?php
if ($row3["alarmtypeid"] == "17"){
	if ($row3["remindme"] == "") {
		
	} else {
		$arr = explode(" ", $row3["remindme"]);
		if ($arr[1] == "days") $remindme = $arr[0] . " " . dic_("Reports.Days_");
		else {
			$remindme = round($arr[0] * $value,0) . " " . $metric;
		}
		echo " (". $remindme ." " . dic_("Settings.Before") . ")";
	}
}

if ($row3["alarmtypeid"] == "18"){
	if ($row3["remindme"] == "") {
		
	} else {
		$arr = explode("; ", $row3["remindme"]);
		if(count($arr) == 1) {
			$arr1 = explode(" ", $arr[0]);
			if ($arr1[1] == "days") $remindme = $arr1[0] . " " . dic_("Reports.Days_");
			else $remindme = round($arr1[0] * $value,0) . " " . $metric;
			echo " (". $remindme ." " . dic_("Settings.Before") . ")";
		} else {
			$arr1 = explode(" ", $arr[0]);
			if ($arr1[1] == "days") $remindme = $arr1[0] . " " . dic_("Reports.Days_");
			else $remindme = round($arr1[0] * $value,0) . " " . $metric;
			
			$arr2 = explode(" ", $arr[1]);
			if ($arr2[1] == "days") $remindme1 = $arr2[0] . " " . dic_("Reports.Days_");
			else $remindme1 = round($arr2[0] * $value,0) . " " . $metric;
			
			echo " (". $remindme .", " . $remindme1 . " " . dic_("Settings.Before") . ")";
		}
	}
	
}

if ($row3["alarmtypeid"] == "20"){
	if ($row3["remindme"] == "") {
		
	} else {
		$arr = explode(" ", $row3["remindme"]);
		if ($arr[1] == "days") $remindme = $arr[0] . " " . dic_("Reports.Days_");
		else {
			$remindme = round($arr[0] * $value,0) . " " . $metric;
		}
		echo " (". $remindme ." " . dic_("Settings.Before") . ")";
	}
}

?>

										<?php if ($row3["alarmtypeid"] == "7"){
												?>(<?php echo $row3['speed'];?> kmh)<?php
											}
										?>
										<?php if ($row3["alarmtypeid"] == "10"){
												?>(<?php 
													
													$najdiIme = query("select * from pointsofinterest where id = ".$row3["poiid"]);
													$imeto = pg_fetch_result($najdiIme, 0, "name");
													echo $imeto;
												?>)<br>
										(<?php echo $row3['timeofpoi'];?> <?php echo dic_("Settings.minutes")?>)		
												
										<?php }?>	
										
										<?php if ($row3["alarmtypeid"] == "9"){
												?>(<?php 
													
													$najdiIme = query("select * from pointsofinterest where id = ".$row3["poiid"]);
													$imeto = pg_fetch_result($najdiIme, 0, "name");
													echo $imeto;
											    ?>) <?php }?>
											    
										<?php if ($row3["alarmtypeid"] == "8"){
												?>(<?php 
													
													$najdiIme = query("select * from pointsofinterest where id = ".$row3["poiid"]);
													$imeto = pg_fetch_result($najdiIme, 0, "name");
													echo $imeto;
											    ?>) <?php }?>
											    
									
											
									</td>
									<td align = "center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; line-height:16px">
										<?php echo $registration?>
									</td>
									<td align = "left" height="30px" class="text2" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8;">
										<?php 
										if($row3["emails"]!="")
										{
											echo $row3["emails"];
										}
										else {
										?> &nbsp;
										<?php
										}
										?>
									</td>
									<?php
									if ($clienttypeid == 6) {
										?>
										<td align = "left" height="30px" class="text2" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8; ">
										<?= nnull($row3["sms"], "/")?>	
										</td>	
										<?php
									}
									?>
									 
									<td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
										<?php echo dic_("Settings.Sound") . " " . $row3["soundid"]; ?>		
									<?php 
									$snoozeNajdi = query("select * from users where id=" . session("user_id") ."");
									$snoozot = pg_fetch_result($snoozeNajdi, 0, "snooze");
			
									if($snoozot==0)
									{
										echo dic("Settings.NoRepetition");
									}
									else 
									{
										?> 
									<?php
										echo "(" . $snoozot . " " . dic_("Reports.Minutes") . ")";
									}
									?>
									</td>
									<td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
										<?php
										
										if($row3["available"] ==1)
										{
										?>
											<?php echo dic_("Settings.User")?>
										<?php
										}
										else if($row3["available"]==2)
										{
										?>
											<?php echo dic_("Reports.OrgUnit")?>
										<?php
										}
										else if($row3["available"]==3)
										{
										?>
											<?php echo dic_("Settings.Company")?>
										<?php
										}
										else {
											?>
											/
										<?php
										}

$styleBtn = "";
$styleDisabled = "";
if ($row3["typeofgroup"] == 2 and $allowed2 == 0 or $row3["typeofgroup"] == 3 and $allowed3 == 0) {
	$styleBtn = "; opacity:0.5;";
	$styleDisabled = "disabled";
}									?>
										
									</td>
									    
									<td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
										<button id="btnEditA<?php echo $cnt7?>"  <?php echo $styleDisabled?> onclick="EditAlertClick(<?php echo $row3["id"]?>)" style="height:22px; width:30px <?php echo $styleBtn?>"></button>
									</td>
									<td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
										<button id="DelBtnA<?php echo $cnt7?>"  <?php echo $styleDisabled?> onclick="DeleteAlertClick(<?php echo $row3["id"]?>)" style="height:22px; width:30px <?php echo $styleBtn?>"></button>
									</td>
								</tr>
	 						<?php
	 						$cnt7++;
	 						}
						}
					}
		     	?>
		<?php
			} //w1.
		} //w0.  else za glavna tabela (noData)
		?>
        </table> <!-- [END] glavna tabela *********************************************************** -->
		
		<table style="padding-left:40px;" class="text2">
		<tr style="height:50px;">
			 <td colspan=4><div style="border-bottom:1px solid #bebebe"></div></td>
        </tr>
        
    
        <tr><td colspan=4 style="height:50px"></td></tr>
     	</table>
	<!-- nema da se koristi div-del-allowed-driver -->
     <div id="div-del-allowed-driver" style="display:none" title="<?php dic("Settings.DeletingAllowedDriver") ?>">
      	<?php dic("Settings.DeletingAllowedDriverQuestion") ?>
     </div>
     <?php
     
     $ds = query("select * from clients where id=" . session("client_id"));
	 $allowedfm = pg_fetch_result($ds, 0, "allowedfm");
	 $allowedrouting = pg_fetch_result($ds, 0, "allowedrouting");
     
     ?>
     <div id="div-add-alerts" style="display:none" title="<?php dic("Settings.AddAlerts") ?>">
     <div align = "center">
     <table cellpadding="3" width="100%" style="padding-top: 25px;">
     <tr>
     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php dic("Settings.TypeOfAlert") ?></td>
     <td width = "75%">
     <select id = "TipNaAlarm" style="font-size: 11px; width:365px; position: relative; top: 0px ;visibility: visible;" onchange="OptionsChangeAlarmType()" class="combobox text2">
      				<option disabled="disabled">----------------------<?php dic("Settings.CommonAlerts")?>----------------------</option>
   					<option value="01" selected="selected" <?php echo $t1?>><?php dic("Settings.AlarmPanic")?></option>
		            <option value="02" <?php echo $t2?>><?php dic("Settings.AlarmAssistance")?></option>
		            <option value="03" <?php echo $t3?>><?php dic("Settings.AlarmAcumulator")?></option>
		            <option value="25" <?php echo $t25?>><?php dic("acumulatorPowerSupplyInterruption")?></option>
		            <option value="24" <?php echo $t24?>><?php dic("Settings.AlarmDefect")?></option>
                    <option value="04" <?php echo $t4?>><?php dic("Settings.AlarmVehicle")?></option>
                    <option value="05" <?php echo $t5?>><?php dic("Settings.AlarmFuelCap")?></option>
                    <option value="48" <?php if($allowFuel==0){ ?>disabled="disabled" <?php }?>><?php dic("Settings.FallFuel")?></option>
                    <option value="06" <?php echo $t6?>><?php dic("Settings.AlarmSuddenBraking")?></option>
                    <option value="07" <?php echo $t7?>><?php dic("Settings.AlarmSpeedExcess")?></option>
                    <option value="08" <?php echo $t8?>><?php dic("Settings.AlarmEnterZone")?></option>
                    <option value="09" <?php echo $t9?>><?php dic("Settings.AlarmLeaveZone")?></option>
                    <option value="10" <?php echo $t10?>><?php dic("Settings.AlarmVisitPOI")?></option>
		    <!--zakomentirano na 29.08.2014 - poradi zabelska od polyesterday-->
                    <option value="11" <?php echo $t11?> style="display: none"><?php dic("Settings.30MinNoDataIgnON")?></option>
                    <option value="26" style="display: none"><?php dic("prednaleva")?></option>
                    <option value="27" style="display: none"><?php dic("prednadesna")?></option>
                    <option value="28" style="display: none"><?php dic("stranicnavrata")?></option>
                    <option value="29" style="display: none"><?php dic("zadnavrata")?></option>
                    <option value="30" style="display: none"><?php dic("stanatvozac")?></option>
                 	<option disabled="disabled">-----------------------------<?php dic("Settings.RoutesCombo")?>---------------------------</option>
		            <option value="12" <?php if($allowedrouting==0){ ?>disabled="disabled" <?php }?> <?php echo $t12?>><?php dic("Settings.AlarmUnOrdered")?></option>
		            <option value="13" <?php if($allowedrouting==0){ ?>disabled="disabled" <?php }?> <?php echo $t13?>><?php dic("Settings.AlarmStayMoreThanAllowed")?></option>
                    <option value="14" <?php if($allowedrouting==0){ ?>disabled="disabled" <?php }?> <?php echo $t14?>><?php dic("Settings.AlarmStayOutOfLocation")?></option>
                    <option value="15" <?php if($allowedrouting==0){ ?>disabled="disabled" <?php }?> <?php echo $t15?>><?php dic("Settings.AlarmLeaveRoute")?></option>
                    <option value="16" <?php if($allowedrouting==0){ ?>disabled="disabled" <?php }?> <?php echo $t16?>><?php dic("Settings.AlarmPause")?></option>
                    <option disabled="disabled">-----------------<?php dic("Main.FleetManagement")?>-----------------</option>
                    <option value="17" <?php if($allowedfm==0){ ?>disabled="disabled" <?php }?> <?php echo $t17?>><?php dic("Settings.AlarmRegExpire")?></option>
                    <option value="18" <?php if($allowedfm==0){ ?>disabled="disabled" <?php }?> <?php echo $t18?>><?php dic("Settings.AlarmService")?></option>
                    <!--option value="19" <?php if($allowedfm==0){ ?>disabled="disabled" <?php }?> <?php echo $t19?>><?php dic("Settings.AlarmGreenCard")?></option-->
                    <option value="20" <?php if($allowedfm==0){ ?>disabled="disabled" <?php }?> <?php echo $t20?>><?php dic("Settings.AlarmPolnomLicense")?></option>
		            <option disabled="disabled">-----------------------------RFID-----------------------------</option>
		            <option value="22" <?php echo $t22?>><?php dic("Settings.AlarmUnauthorizedUseVehicle")?></option> 
		            <option value="23" <?php echo $t23?>><?php dic("Settings.AlarmNoRFIDVehicle")?></option>
		            <option disabled="disabled">-------------------------<?php dic("Settings.MotoAlarms")?>-----------------------</option>
		            <option value="37" <?php if($clienttypeid!=6){ ?>disabled="disabled" <?php }?> <?php echo $t37?>><?php dic("Settings.Tow")?></option> 
		            <option value="38" <?php if($clienttypeid!=6){ ?>disabled="disabled" <?php }?> <?php echo $t38?>><?php dic("Settings.WeakAcc")?></option>
     </select>
     </td>
     </tr>
     <tr id="zonataTockata" style="display:none;">
     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("select")?> <?php echo dic_("Tracking.POI")?></td>
     <td width = "75%" style="font-weight:bold" class ="text2">
     <div class="ui-widget" style="height: 25px; width: 100%;">
     <select id="combobox" style="width: 370px;">
        <?php
        	$str1 = "";
			$str1 .= "select * from pointsofinterest where clientid=" . session("client_id") ." and type=1 and active = '1' ORDER BY name";
			$dsPP = query($str1);
            while($row = pg_fetch_array($dsPP))
            {
        	?>
            <option value="<?php echo $row["id"] ?>"><?php echo $row["name"]?></option>
        	<?
            }
        	?>
     </select>
	 </div>
	 </td>
     </tr>
     <tr id="zonataTockata2" style="display:none;">
     <td style="font-weight:bold" class ="text2" width="25%" align="left"><?php dic("Routes.RetentionTime")?></td>
     <td style="font-weight:bold" class ="text2" width="75%">
     <input id = "vreme" class="textboxcalender corner5 text5" type="text" size="5"></input>&nbsp;<?php echo dic("Reports.Minutes")?></td>
     </tr>
     <tr id="zonaVlez" style="display:none;">
     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Settings.SelectEnterGeoF")?></td>
     <td width = "75%" style="font-weight:bold" class ="text2">
     <div class="ui-widget" style="height: 25px; width: 100%;">
     <select id="comboboxVlez" style="width: 365px">
        <?php
        	$str2 = "";
			$str2 .= "select * from pointsofinterest where clientid=" . session("client_id") ." and type=2 and active = '1' ORDER BY name";
			$dsPP2 = query($str2);
            while($row2 = pg_fetch_array($dsPP2)) {
        ?>
            <option value="<?php echo $row2["id"] ?>"><?php echo $row2["name"]?></option>
        <?
            }
        ?>
     </select>
	 </div>
	 </td>
     </tr>
     <tr id="zonaIzlez" style="display:none;">
     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Settings.SelectExitGeoF")?></td>
     <td width = "75%" style="font-weight:bold" class ="text2">
     <div class="ui-widget" style="height: 25px; width: 100%;">
     <select id="comboboxIzlez" style="width: 370px">
        <?php
        	$str3 = "";
			$str3 .= "select * from pointsofinterest where clientid=" . session("client_id") ." and type=2 and active = '1' ORDER BY name";
			$dsPP3 = query($str3);
            while($row3 = pg_fetch_array($dsPP3)) {
        ?>
            <option value="<?php echo $row3["id"] ?>"><?php echo $row3["name"]?></option>
        <?
            }
        ?>
     </select>
	 </div>
	 </td>
     </tr>
     <tr id="nadminuvanjeBrzina" style="display:none;">
     <td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic("Reports.Speed")?></td>
     <td width = "75%" style="font-weight:bold" class ="text2"><input id = "brzinata" class="textboxcalender corner5 text5" type="text" size="10"></input>&nbsp;kmh</td>
     </tr>
     <tr>
     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Settings.InsertAler")?>:</td>
     <td width = "75%" style="font-weight:bold" class ="text2">
     <div class="ui-widget" style="height: 25px; width: 100%;">
     <select id="vozila" style="width: 365px;" class="combobox text2" onchange="OptionsChangeVehicle()">
     	<option value="0"><?php echo dic_("Tracking.SelectOption")?></option>
        <option value="1"><?php echo dic_("Tracking.OneVehicle")?></option>
<?php
	
	
	if (pg_num_rows(query($strOrg)) > 0) {

?>
        <option value="2"><?php echo dic_("Tracking.VehInOrgU")?></option>

	<?php
	}

	
	if ((dlookup("select count(*) from vehicles where clientID=" . session("client_id") . " and active='1'")) == pg_num_rows(query($strCom))) {

	?>
        <option value="3"><?php echo dic_("Tracking.AllVehCompany") ?></option>

	<?php
	}
	?>
     </select>
	 </div>
	 </td>
     </tr>
 
     <tr id="ednoVozilo" style="display:none;">
     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Tracking.SelectVeh")?>:</td>
     <td width = "75%" style="font-weight:bold" class ="text2">
     <div class="ui-widget" style="height: 25px; width: 100%;">
     <select id="voziloOdbrano" style="width: 365px;" class="combobox text2">
     	<?php
		
        	//$str1 = "";
		//$str1 .= "select * from vehicles where clientid=" . session("client_id") ." ORDER BY code::INTEGER";
		$dsPP = query($strCom);
            while($row = pg_fetch_array($dsPP)) {
        ?>
            <option value="<?php echo $row["id"] ?>"><?php echo $row["registration"]?>&nbsp;(<?php echo $row["code"]?>)</option>
        <?
            }
        ?>
     </select>
	 </div>
	 </td>   
     </tr>
     
     <tr id="OrganizacionaEdinica" style="display:none;">
     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Tracking.SelectOrg.Unit")?>:</td>
     <td width = "75%" style="font-weight:bold" class ="text2">
     <div class="ui-widget" style="height: 25px; width: 100%">
     <select id="oEdinica" style="width: 365px;" class="combobox text2">
     	<?php
	
        	//$str2 = "";
		//$str2 .= "select * from organisation where clientid=" . session("client_id") ." order by code::INTEGER";
		$dsPP2 = query($strOrg);
		//$brojRedovi = dlookup("select count(*) from organisation where clientid=" . session("client_id"));
		$brojRedovi = pg_num_rows($dsPP2);
            while($row2 = pg_fetch_array($dsPP2)) {
        ?>
            <option value="<?php echo $row2["id"] ?>"><?php if ($brojRedovi>0){ echo $row2["name"]?>&nbsp;(<?php echo $row2["code"]?><?php }else{ echo "Нема организациони единици.";}?>)</option>
        <?
            }
        ?>
     </select>
	 </div>
	 </td>
     </tr>

     <tr id="fm" style="display:none;">
	     <td width = "27%" style="font-weight:bold" class ="text2"  align="left"><?= dic_("Settings.RemindMe")?> <?= dic_("Settings.Before")?>:</td>
	     <td width = "73%" style="" class ="text2">
	     	<span id="rmdD">
	     	 <input id="remindDays" type="checkbox" name="remindme" value="days" style="position: relative; top:4px; display:none" checked /> 
	     	 <input id = "fmvalueDays" class="textboxCalender corner5 text5" type="text" style="width:40px" value="5"> <?= dic_("Reports.Days_")?>
	     	</span>
	     	<span id="rmdKm" style="display: none"> 
	     	 <input id="remindKm" type="checkbox" name="remindme" value="Km" style="position: relative; top:4px; margin-left: 15px" /> 
	     	 <input id = "fmvalueKm" class="textboxCalender corner5 text5" type="text" style="width:40px" value="0"> <?= $metric?>
	     	</span>
	     </td>
     </tr>

     <tr id="noteFmAlarm" style="display:none">
	     <td width = "27%"></td>
	     <td id="textFmAlarm" width = "73%" class="text2" style="color:#ff0000; font-size: 10px"></td>
     </tr>

     <tr>
     <td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic_("Tracking.Emails")?></td>
     <td width = "75%" style="font-weight:bold" class ="text2"><input id = "emails" class="textboxcalender corner5 text5" type="text" style = "width:365px"></input></td>
     </tr>
     <tr>
     <td width = "25%"></td>	
     <td width = "75%" class ="text2" style="font-size:10px"><font color = "red" ><?php echo dic_("Reports.SchNote")?></font></td>
     </tr>
     
     <?php
     if($clienttypeid == 6) {
     ?>
     	<tr>
	    	<td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic_("Settings.SMS")?></td>
	    	<td width = "75%" style="font-weight:bold" class ="text2"><input id = "sms" class="textboxcalender corner5 text5" type="text" style = "width:365px"></input></td>
	     </tr>
     <?php	
     }
     ?>
     <tr>
     <td width = "25%" valign="middle" style="font-weight:bold" class ="text2" align="left"><?php dic("Settings.Sound")?></td>
     <td width = "75%" valign="middle">
     <select id = "zvukot" style="font-size: 11px; position: relative; top: 0px ;visibility: visible; float:left" class="combobox text2">
     <option value = "1"><?php dic("Settings.Sound")?> 1</option>
     <!--
     <option value = "2"><?php dic("Settings.Sound")?> 2</option>
     <option value = "3"><?php dic("Settings.Sound")?> 3</option>
     <option value = "4"><?php dic("Settings.Sound")?> 4</option>
     <option value = "5"><?php dic("Settings.Sound")?> 5</option>
     -->
     </select>
     <audio id="demo" src="../tracking/sound/bells_alarm.ogg"></audio>
	 <button id="play" onclick="document.getElementById('demo').play()" style="position: relative; width: 35px;height: 28px; margin-left:10px;"></button>
     <button id="pause" onclick="document.getElementById('demo').pause()" style="position: relative; width: 35px;height: 28px;"></button>
     <button id="poglasno" onclick="document.getElementById('demo').volume+=0.1" style="position: relative; width: 35px;height: 28px;"></button>
     <button id="potivko" onclick="document.getElementById('demo').volume-=0.1" style="position: relative; width: 35px;height: 28px;"></button>
	 </td>
	 </tr>
	 <tr>
     <td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic_("Settings.AvailableFor1")?>:</td>
     <td width = "75%" style="font-weight:bold" class ="text2"><div id="gfAvail" class="corner5">
        <input type="radio" id="GFcheck1" name="radio" checked="checked" /><label for="GFcheck1"><?php echo dic_("Settings.User")?></label>
        <input type="radio" id="GFcheck2" name="radio" /><label for="GFcheck2"><?php echo dic_("Reports.OrgUnit")?></label>
        <input type="radio" id="GFcheck3" name="radio" /><label for="GFcheck3"><?php echo dic_("Settings.Company")?></label>
     </div>
     </td>
     </tr>
   	 </table> 	
     </div>
   	 </div>
   	 <!-- nema da treba div-del-alert -->
   	 <div id="div-del-alert" style="display:none" title="<?php echo dic("Settings.AlertDeleteQuestion")?>">
        <?php echo dic("Settings.DelAlert")?>
     </div>

     <div id="div-edit-alert" style="display:none" title="<?php dic("Settings.ChangeAlert")?>"></div>

     <div id="div-tip-praznik" style="display:none" title="<?php echo dic_("Settings.ConfSMS")?>">
     <br>
		<table align = "center" width = "100%">
			<tr>
				<td colspan = "2" class ="text2" align = "center" style="color:#414141">
					<span class="ui-icon ui-icon-alert" style="position: absolute; top: 25px; left: 15px;"></span>
				<div style="width: 250px; padding-left: 20px; padding-bottom: 10px; text-align: center;"><?php echo dic("dinara5")?></div> </td></tr>
			<tr>
				<td style="color:#414141" class ="text2" width="90px" align = "right"><?php echo dic_("EnterPass")?> </td>
				<td style="color:#414141" class ="text2" width="150px" align = "left">
					<input type="password" class="textboxCalender corner5" id="dodTipPraznik" style="width:150px">
				</td>
			</tr>
		</table>
    </div>
    
    <div id="dialog-message" title="<?php echo dic("Reports.Message")?>" style="display:none">
	 <p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px"></div>
	 </p>
	</div>
	
   	</body>
   	
   	<script>
	function msgboxPetar(msg) {
    $("#DivInfoForAll").css({ display: 'none' });
    $('#div-msgbox').html(msg);
    $("#dialog-message").dialog({
        modal: true,
        zIndex: 9999, resizable: false,
        buttons: {
            Ok: function () {
                $(this).dialog("close");
        	}
        }
    });
	}
	</script>
	
   	<script>      
   
    function addAlerts() {
 	document.getElementById('div-add-alerts').title = dic("Settings.AddAlerts")	
 	$('#div-add-alerts').dialog({ modal: true, width: 590, height: 500, resizable: false,
            buttons: 
            [
            {
             	text: dic('Settings.Add',lang),
				click: function(data) {
					
                    var tipNaAlarm = $('#TipNaAlarm').val()
                    var email = $('#emails').val()
                    var sms = '';//$('#sms').val()
                    if ('<?= $clienttypeid?>'== 6)
                    	sms = $('#sms').val();
                  
                    var zvukot = $('#zvukot').val()
                    
                    var ImeNaTocka =$('#combobox').val();
                    var ImeNaTockaProverka = document.getElementById('combobox').selectedIndex;     
                    
                    var ImeNaZonaIzlez = $('#comboboxIzlez').val()
                    var ImeNaZonaIzlezProverka = document.getElementById('comboboxIzlez').selectedIndex;
                    
                    var ImeNaZonaVlez = $('#comboboxVlez').val() 
                    var ImeNaZonaVlezProverka = document.getElementById('comboboxVlez').selectedIndex;   
                    
                    var orgEdinica = $('#oEdinica').val()
                    var odbraniVozila = $("#vozila option:selected").val();//document.getElementById('vozila').selectedIndex;
                    var NadminataBrzina = $('#brzinata').val()
                    var vreme = $('#vreme').val()
                    var alarmSelect = document.getElementById('TipNaAlarm').selectedIndex;  
   					var voziloOdbrano = $('#voziloOdbrano').val()
                    var dostapno = '1'
				    if(document.getElementById("GFcheck1").checked == true){dostapno=='1'};
				    if(document.getElementById("GFcheck2").checked == true){dostapno='2'}
				    if(document.getElementById("GFcheck3").checked == true){dostapno='3'}
				    
			
///////////////////////////
					if (alarmSelect == 28 && ($('#remindKm').is(':checked') == false && $('#remindDays').is(':checked') == false)) {
				  		msgboxPetar(dic("Settings.RemindMeMustOne",lang));
				  	} else {			  	
					  	var remindme = '';
					  	if (alarmSelect == 27 || alarmSelect == 28 || alarmSelect == 29 || alarmSelect == 30) {
					  		var fmvalueDays = "";
					  		
					  		if (alarmSelect == 28) {
					  			if ($('#remindDays').is(':checked')) {	
					  				fmvalueDays = $('#fmvalueDays').val() + " days";
					  			}
					  		} else {
					  			if ($('#fmvalueDays').val() != "") {
						  			fmvalueDays = $('#fmvalueDays').val() + " days";
						  		}
					  		}	
					  							  					  		
						  	var fmvalueKm = "";
						  	if ($('#rmdKm').css('display') != 'none') {
						  		if (alarmSelect == 28) {
						  			if ($('#remindKm').is(':checked')) {	
						  				if (fmvalueDays != "")
						  					fmvalueKm += "; " + Math.round($('#fmvalueKm').val()/ <?= $value?>) + " Km";
						  				else
						  					fmvalueKm = Math.round($('#fmvalueKm').val()/ <?= $value?>) + " Km";
						  			}
						  		} else {
						  			if ($('#fmvalueKm').val() != "") {
							  			if (fmvalueKm != "")
							  				fmvalueKm += "; " + Math.round($('#fmvalueKm').val()/ <?= $value?>) + " Km";
							  			else
							  				fmvalueKm = Math.round($('#fmvalueKm').val()/ <?= $value?>) + " Km";
							  		}
						  		}							  		
						  	}
					  		remindme = fmvalueDays + fmvalueKm;
					  	}
					
///////////////////////////////////////



	   
                    
					function validacija(){
					var emails = $('#emails').val();
					var emailovi = emails.split(",");
					var izlez;
					emailovi.forEach(function (mejl) {
					var filter = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
					izlez = filter.test(mejl.trim());
					});
					return izlez;
					}
										
                    if(email=='' && sms==''){
                        msgboxPetar(dic("Settings.AlertsEmailHaveTo",lang))
                        }else{
                   
                          	 if(email.length>0 && !validacija())
                          	 {
							 msgboxPetar(dic("uncorrEmail",lang))
							 }
							 else{
							 		if(odbraniVozila == 0) {
										msgboxPetar(dic("Settings.SelectAlert1",lang))
										//alert("Треба да одберете за што сакате да внесете аларм");
									} else {
							 			if(alarmSelect == 13) {
									 		if(ImeNaTockaProverka == ""){
									 			msgboxPetar(dic("Settings.SelectPOI2",lang))
									 			exit
									 		}
									 		if(vreme == "") {
									 			msgboxPetar(dic("Settings.InsertRetTime",lang))
									 			exit
									 		}
											if(sms!="") {
										   		document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
										        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
									                  buttons: 
									                  [
									                  {
									                  text:dic("Reports.Confirm"),
													  click: function() {
													    	
													    	pass = encodeURIComponent($('#dodTipPraznik').val());
													    	tipPraznikID = document.getElementById("dodTipPraznik");
													    	if(pass=="")
													    	{
													    		msgboxPetar(dic("Settings.InsertPass",lang))
													    		tipPraznikID.focus();
													    	}
													    	else
									                        {   
									                            $.ajax({
											                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
											                        context: document.body,
											                        success: function(data){
											                        if(data==1)	
											                        {
/*alert("AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila)*/
											                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
											                        	//alert("AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme)
											                        	$.ajax({
											                              url: "AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme,                                                     
											                              context: document.body,
											                              success: function(data){
											                              window.location.reload();
												                          }
											                            });
											                        }
											                        else
											                        {
											                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
											                        	exit;
											                        }
											                      }
											                    });	
											                   }
									                         }
													      },
													    {
													    	text:dic("Fm.Cancel",lang),
									                    click: function() {
														    $( this ).dialog( "close" );
													    }
									               }
									              ]
									   		  })
									   	
										}
							 		else{
                                    $.ajax({
			                              url: "AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme,                                                     
			                              context: document.body,
			                              success: function(data){
			                              msgboxPetar(dic("Settings.SuccAdd",lang))
						    			  window.location.reload();
				                          }
			                            });	 
                                       }
							 		}
							 		
							 		else{
							 		if(alarmSelect == 12){
							 		if(ImeNaZonaIzlezProverka == ""){
							 			msgboxPetar(dic("Settings.SelectExitGeoF",lang))
							 			exit
							 		}
							 		if(sms!="")
		                          	 {
									 
									   	document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
									        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
									                  buttons: 
									                  [
									                  {
									                  text:dic("Reports.Confirm"),
													  click: function() {
													    	
													    	pass = encodeURIComponent($('#dodTipPraznik').val());
													    	tipPraznikID = document.getElementById("dodTipPraznik");
													    	if(pass=="")
													    	{
													    		msgboxPetar(dic("Settings.InsertPass",lang))
													    		tipPraznikID.focus();
													    	}
													    	else
									                        {   
									                            $.ajax({
											                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
											                        context: document.body,
											                        success: function(data){
											                        if(data==1)	
											                        {
											                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
											                        	//alert("AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme)
											                            $.ajax({
											                              url: "AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme,                                                     
											                              context: document.body,
											                              success: function(data){
											                    		  window.location.reload();
												                          }
											                            });	
																	}
											                        else
											                        {
											                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
											                        	exit;
											                        }
											                      }
											                    });	
											                   }
									                         }
													      },
													    {
													    	text:dic("Fm.Cancel",lang),
									                    click: function() {
														    $( this ).dialog( "close" );
													    }
									               }
									              ]
									   		  })
									   	
										}
							 		else{
                                    $.ajax({
			                              url: "AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme,                                                     
			                              context: document.body,
			                              success: function(data){
			                              msgboxPetar(dic("Settings.SuccAdd",lang))
						    			  window.location.reload();
				                          }
			                            });	 
                                       }
							 		}
							 		else{
							 		if(alarmSelect == 11){
							 		if(ImeNaZonaVlezProverka == ""){
							 			msgboxPetar(dic("Settings.SelectEnterGeoF",lang))
							 			exit
							 		}
							 		if(sms!="")
		                          	 {
									 
									   	document.getElementById('div-tip-praznik').title = dic(dic("Settings.ConfSMS",lang))
									        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
									                  buttons: 
									                  [
									                  {
									                  text:dic("Reports.Confirm"),
													  click: function() {
													    	
													    	pass = encodeURIComponent($('#dodTipPraznik').val());
													    	tipPraznikID = document.getElementById("dodTipPraznik");
													    	if(pass=="")
													    	{
													    		msgboxPetar(dic("Settings.InsertPass",lang))
													    		tipPraznikID.focus();
													    	}
													    	else
									                        {   
									                            $.ajax({
											                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
											                        context: document.body,
											                        success: function(data){
											                        if(data==1)	
											                        {
											                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
											                        	//alert("AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme)
											                             $.ajax({
											                              url: "AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme,                                                     
											                              context: document.body,
											                              success: function(data){
											                        	  window.location.reload();
												                          }
											                            });
											                        	
											                        }
											                        else
											                        {
											                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
											                        	exit;
											                        }
											                      }
											                    });	
											                   }
									                         }
													      },
													    {
													    	text:dic("Fm.Cancel",lang),
									                    click: function() {
														    $( this ).dialog( "close" );
													    }
									               }
									              ]
									   		  })
									   	
										}
							 		else{
                                    $.ajax({
			                              url: "AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme,                                                     
			                              context: document.body,
			                              success: function(data){
			                              msgboxPetar(dic("Settings.SuccAdd",lang))
						    			  window.location.reload();
				                          }
			                            });	 
                                       }
							 		}
							 		
							 		else{
							 		if(alarmSelect==10)
							 		{
							 			if(NadminataBrzina=="")
							 			{
							 			msgboxPetar(dic("Settings.InsertSpeedOver",lang))
							 			}
							 			if(sms!="")
		                          	    {
									 
									   	document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
									        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
									                  buttons: 
									                  [
									                  {
									                  text:dic("Reports.Confirm"),
													  click: function() {
													    	
													    	pass = encodeURIComponent($('#dodTipPraznik').val());
													    	tipPraznikID = document.getElementById("dodTipPraznik");
													    	if(pass=="")
													    	{
													    		msgboxPetar(dic("Settings.InsertPass",lang))
													    		tipPraznikID.focus();
													    	}
													    	else
									                        {   
									                            $.ajax({
											                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
											                        context: document.body,
											                        success: function(data){
											                        if(data==1)	
											                        {
											                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
											                        	//alert("AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme)
											                            $.ajax({
											                              url: "AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme,                                                     
											                              context: document.body,
											                              success: function(data){
											                              window.location.reload();
												                          }
											                            });
											                        }
											                        else
											                        {
											                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
											                        	exit;
																	}
											                      }
											                    });	
											                   }
									                         }
													      },
													    {
													    	text:dic("Fm.Cancel",lang),
									                    click: function() {
														    $( this ).dialog( "close" );
													    }
									               }
									              ]
									   		  })
									   	
										}
							 			else{
                                    	$.ajax({
			                              url: "AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme,                                                     
			                              context: document.body,
			                              success: function(data){
			                              msgboxPetar(dic("Settings.SuccAdd",lang))
						    			  window.location.reload();
				                          }
			                            });	 
                                       }
							 		}
							 		else{
							 		if(sms!="")
		                          	    {
									 
									   	document.getElementById('div-tip-praznik').title = dic(dic("Settings.ConfSMS",lang))
									        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
									                  buttons: 
									                  [
									                  {
									                  text:dic("Reports.Confirm"),
													  click: function() {
													    	
													    	pass = encodeURIComponent($('#dodTipPraznik').val());
													    	tipPraznikID = document.getElementById("dodTipPraznik");
													    	if(pass=="")
													    	{
													    		msgboxPetar(dic("Settings.InsertPass",lang))
													    		tipPraznikID.focus();
													    	}
													    	else
									                        {   
									                            $.ajax({
											                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
											                        context: document.body,
											                        success: function(data){
											                        if(data==1)	
											                        {
											                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
											                        	//alert("AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme)
											                             $.ajax({
											                              url: "AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme,                                                     
											                              context: document.body,
											                              success: function(data){
											                              window.location.reload();
												                          }
											                           });
											                        }
											                        else
											                        {
											                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
											                        	exit;
											                        }
											                      }
											                    });	
											                   }
									                         }
													      },
													    {
													    	text:dic("Fm.Cancel",lang),
									                    click: function() {
														    $( this ).dialog( "close" );
													    }
									               }
									              ]
									   		  })
									   	
										}
										else{
                                    $.ajax({
			                              url: "AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme,                                                     
			                              context: document.body,
			                              success: function(data){
			                              msgboxPetar(dic("Settings.SuccAdd",lang))
						    			  window.location.reload();
				                          }
			                              });	 
                                         }
                                         }
                                        }
                                        }
    	                               }
    	                              }
    	                             }
    	                            }
    	                           }
    	                          }
                                },
                            {
                         	text:dic('cancel',lang),
       			 			click:function() {
					    $( this ).dialog( "close" );
					    }
	                  }
	               ]
	            });    
	   		 } 
                           
	</script>
   	
   	<script>
   	
   	function EditAlertClick(id){
    ShowWait()
    $.ajax({
	    url: "EditAlarm2.php?id="+id+"&l="+lang,
	    context: document.body,
	    success: function(data){
            HideWait()
            $('#div-edit-alert').html(data)
		    document.getElementById('div-edit-alert').title = dic("Settings.ChangeAlert")
		    var oldsms2 = $('#sms2').val();
            $('#div-edit-alert').dialog({ modal: true, width: 590, height: 500, resizable: false,
                 buttons: 
			        [
                    {
			        text: dic("Fm.Mod", lang),
                        click: function() {
			        	var tipNaAlarm2 = $('#TipNaAlarm2').val()  
	                    var email2 = $('#emails2').val()
	                    var sms2 = '';//$('#sms2').val()
	                    if (<?= $clienttypeid ?> == 6)
	                    	sms2 = $('#sms2').val()
	                    var zvukot2 = $('#zvukot2').val()
	                    
	                	var ImeNaTocka2 = $('#zonaTocka2').val()
	                	var ImeNaTockaProverka2 = document.getElementById('zonaTocka2').selectedIndex;  
	                	
	                	var ImeNaZonaIzlez2 = $('#zonataIzlezot').val()
	                	var ImeNaZonaIzlezProverka2 = document.getElementById('zonataIzlezot').selectedIndex;
	                	
	                	var ImeNaZonaVlez2 = $('#zonataVlezot').val() 
	                	var ImeNaZonaVlezProverka2 = document.getElementById('zonataVlezot').selectedIndex;   
                    	var NadminataBrzina2 = $('#brzinata2').val()
                    	var odbranataOpcija2 = document.getElementById('TipNaAlarm2').selectedIndex;
                    	if (odbranataOpcija2 == 28 && ($('#remindKm1').is(':checked') == false && $('#remindDays1').is(':checked') == false)) {
				  			msgboxPetar(dic("Settings.RemindMeMustOne",lang));
				  		} else {
	                    	var remindme1 = '';
						  	if (odbranataOpcija2 == 27 || odbranataOpcija2 == 28 || odbranataOpcija2 == 29 || odbranataOpcija2 == 30) {
						  		var fmvalueDays1 = "";
						  		if ($('#remindDays1').is(':checked')) {
						  			fmvalueDays1 = $('#fmvalueDays1').val() + " days";
						  		}
						  						  		
							  	var fmvalueKm1 = "";
							  	if ($('#rmdKm1').css('display') != 'none') {
							  		if ($('#remindKm1').is(':checked')) {
							  			if (fmvalueDays1 != "")
							  				fmvalueKm1 += "; " + Math.round($('#fmvalueKm1').val()/ <?= $value?>) + " Km";
							  			else
							  				fmvalueKm1 = Math.round($('#fmvalueKm1').val()/ <?= $value?>) + " Km";	
							  		}
							  	}
						  		remindme1 = fmvalueDays1 + fmvalueKm1;
						  	}
                    	var vreme2 = $('#vreme2').val()
                    	var orgEdinica2 = $('#oEdinica2').val();
                    	var odbraniVozila2 = document.getElementById('vozila2').selectedIndex; 
                    	var alarmSelect2 = document.getElementById('TipNaAlarm2').selectedIndex; 
                    	var voziloOdbrano2 = $('#voziloOdbrano2').val()
                    	
                
                		var dostapno2 = '1';
					    if(document.getElementById("tipKorisnik1").checked == true){dostapno2='1'}
				    	if(document.getElementById("tipKorisnik2").checked == true){dostapno2='2'}
				    	if(document.getElementById("tipKorisnik3").checked == true){dostapno2='3'}
                    	
                       
	   					function validacija2(){
						var emails2 = $('#emails2').val();
						var emailovi2 = emails2.split(",");
						var izlez2;
						emailovi2.forEach(function (mejl2) {
						var filter2 = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
						izlez2 = filter2.test(mejl2.trim());
						});
						return izlez2;
						}
	                    
	                    if(email2=='' && sms2==''){
                        msgboxPetar(dic("Settings.AlertsEmailHaveTo",lang))
                           }else{
                    		if(email2.length>0 && !validacija2())
                  			{
							msgboxPetar(dic("uncorrEmail",lang))
							}
							else{
					 		if(alarmSelect2==13){
					 		/*if(ImeNaTockaProverka2 == "0"){
							 			alert(dic("Settings.SelectPOI2",lang))
							 			exit
							 		}*/
							 		if(vreme == ""){
							 			msgboxPetar(dic("Settings.InsertRetTime",lang))
							 			exit
							 		}
					 				else{
					 					if(sms2!="" && (oldsms2 != sms2)) {
								                    		
						   		document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
						        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
					                  buttons: 
					                  [
					                  {
					                  text:dic("Reports.Confirm"),
									  click: function() {
									    	
									    	pass = encodeURIComponent($('#dodTipPraznik').val());
									    	tipPraznikID = document.getElementById("dodTipPraznik");
									    	if(pass=="")
									    	{
									    		msgboxPetar(dic("Settings.InsertPass",lang))
									    		tipPraznikID.focus();
									    	}
									    	else
					                        {   
					                            $.ajax({
							                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
							                        context: document.body,
							                        success: function(data){
							                        if(data==1)	
							                        {
							                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
							                        	$.ajax({
							                              url: "UpAlert2.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&id="+id+"&ImeNaTocka2="+ImeNaTocka2+"&vreme2="+vreme2+"&dostapno2="+dostapno2+"&orgEdinica2="+orgEdinica2+"&odbraniVozila2="+odbraniVozila2+"&voziloOdbrano2="+voziloOdbrano2+"&remindme="+remindme1,
							                              context: document.body,
							                              success: function(data){
							                              msgboxPetar(dic("Settings.SuccChanged",lang))
										    			  window.location.reload();
								                          }
							                           });	 
							                        }
							                        else
							                        {
							                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
							                        	exit;
							                        }
							                      }
							                    });	
							                   }
					                         }
									      },
									    {
									    	text:dic("Fm.Cancel",lang),
					                   		click: function() {
										    $( this ).dialog( "close" );
									    }
					               }
					              ]
					   		  })
					   		  return;
							} else {
								$.ajax({
	                              url: "UpAlert2.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&id="+id+"&ImeNaTocka2="+ImeNaTocka2+"&vreme2="+vreme2+"&dostapno2="+dostapno2+"&orgEdinica2="+orgEdinica2+"&odbraniVozila2="+odbraniVozila2+"&voziloOdbrano2="+voziloOdbrano2+"&remindme="+remindme1,
	                              context: document.body,
	                              success: function(data){
	                              msgboxPetar(dic("Settings.SuccChanged",lang))
				    			  window.location.reload();
		                          }
	                           });
							}
                               	 
                             }
                             }else{
					 		 if(alarmSelect2==12){
					 		 	/*if(ImeNaZonaIzlezProverka2 == ""){
							 			alert(dic("Settings.SelectExitGeoF",lang))
							 			exit
							 	}*/
							 	if(sms2!="" && (oldsms2 != sms2)) {
								                    		
						   		document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
						        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
					                  buttons: 
					                  [
					                  {
					                  text:dic("Reports.Confirm"),
									  click: function() {
									    	
									    	pass = encodeURIComponent($('#dodTipPraznik').val());
									    	tipPraznikID = document.getElementById("dodTipPraznik");
									    	if(pass=="")
									    	{
									    		msgboxPetar(dic("Settings.InsertPass",lang))
									    		tipPraznikID.focus();
									    	}
									    	else
					                        {   
					                            $.ajax({
							                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
							                        context: document.body,
							                        success: function(data){
							                        if(data==1)	
							                        {
							                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
							                        	$.ajax({
						                              url: "UpAlert2.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&id="+id+"&ImeNaZonaIzlez2="+ImeNaZonaIzlez2+"&dostapno2="+dostapno2+"&orgEdinica2="+orgEdinica2+"&odbraniVozila2="+odbraniVozila2+"&voziloOdbrano2="+voziloOdbrano2+"&remindme="+remindme1,
						                              context: document.body,
						                              success: function(data){
						                              msgboxPetar(dic("Settings.SuccChanged",lang))
									    			  window.location.reload();
							                          }
						                            });	
							                        }
							                        else
							                        {
							                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
							                        	exit;
							                        }
							                      }
							                    });	
							                   }
					                         }
									      },
									    {
									    	text:dic("Fm.Cancel",lang),
					                   		click: function() {
										    $( this ).dialog( "close" );
									    }
					               }
					              ]
					   		  })
					   		  return;
							} else {
								$.ajax({
	                              url: "UpAlert2.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&id="+id+"&ImeNaZonaIzlez2="+ImeNaZonaIzlez2+"&dostapno2="+dostapno2+"&orgEdinica2="+orgEdinica2+"&odbraniVozila2="+odbraniVozila2+"&voziloOdbrano2="+voziloOdbrano2+"&remindme="+remindme1,
	                              context: document.body,
	                              success: function(data){
	                              msgboxPetar(dic("Settings.SuccChanged",lang))
				    			  window.location.reload();
		                          }
	                            });	
							}
					 			 
                             }
                             else{
					 		 if(alarmSelect2==11){
					 		 /*if(ImeNaZonaVlezProverka2 == ""){
							 			alert(dic("Settings.SelectEnterGeoF",lang))
							 			exit;
							 }*/
							if(sms2!="" && (oldsms2 != sms2)) {
								                    		
						   		document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
						        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
					                  buttons: 
					                  [
					                  {
					                  text:dic("Reports.Confirm"),
									  click: function() {
									    	
									    	pass = encodeURIComponent($('#dodTipPraznik').val());
									    	tipPraznikID = document.getElementById("dodTipPraznik");
									    	if(pass=="")
									    	{
									    		msgboxPetar(dic("Settings.InsertPass",lang))
									    		tipPraznikID.focus();
									    	}
									    	else
					                        {   
					                            $.ajax({
							                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
							                        context: document.body,
							                        success: function(data){
							                        if(data==1)	
							                        {
							                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
							                        	$.ajax({
							                              url: "UpAlert2.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&id="+id+"&ImeNaZonaVlez2="+ImeNaZonaVlez2+"&dostapno2="+dostapno2+"&orgEdinica2="+orgEdinica2+"&odbraniVozila2="+odbraniVozila2+"&voziloOdbrano2="+voziloOdbrano2+"&remindme="+remindme1,
							                              context: document.body,
							                              success: function(data){
							                              msgboxPetar(dic("Settings.SuccChanged",lang))
										    			  window.location.reload();
								                          }
							                            });	 
							                        }
							                        else
							                        {
							                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
							                        	exit;
							                        }
							                      }
							                    });	
							                   }
					                         }
									      },
									    {
									    	text:dic("Fm.Cancel",lang),
					                   		click: function() {
										    $( this ).dialog( "close" );
									    }
					               }
					              ]
					   		  })
					   		  return;
							} else {
								$.ajax({
	                              url: "UpAlert2.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&id="+id+"&ImeNaZonaVlez2="+ImeNaZonaVlez2+"&dostapno2="+dostapno2+"&orgEdinica2="+orgEdinica2+"&odbraniVozila2="+odbraniVozila2+"&voziloOdbrano2="+voziloOdbrano2+"&remindme="+remindme1,
	                              context: document.body,
	                              success: function(data){
	                              msgboxPetar(dic("Settings.SuccChanged",lang))
				    			  window.location.reload();
		                          }
	                            });	 
							}
					 		 
                             }else  
					 		 {
							 if(alarmSelect2==10){
							 if(NadminataBrzina2==""){
							 		msgboxPetar(dic("Settings.InsertSpeedOver",lang))
							 }
							 else{
							 	if(sms2!="" && (oldsms2 != sms2)) {
								                    		
						   		document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
						        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
					                  buttons: 
					                  [
					                  {
					                  text:dic("Reports.Confirm"),
									  click: function() {
									    	
									    	pass = encodeURIComponent($('#dodTipPraznik').val());
									    	tipPraznikID = document.getElementById("dodTipPraznik");
									    	if(pass=="")
									    	{
									    		msgboxPetar(dic("Settings.InsertPass",lang))
									    		tipPraznikID.focus();
									    	}
									    	else
					                        {   
					                            $.ajax({
							                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
							                        context: document.body,
							                        success: function(data){
							                        if(data==1)	
							                        {
							                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
							                        	$.ajax({
							                              url: "UpAlert2.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&id="+id+"&dostapno2="+dostapno2+"&NadminataBrzina2="+NadminataBrzina2+"&orgEdinica2="+orgEdinica2+"&odbraniVozila2="+odbraniVozila2+"&voziloOdbrano2="+voziloOdbrano2+"&remindme="+remindme1,
							                              context: document.body,
							                              success: function(data){
							                              msgboxPetar(dic("Settings.SuccChanged",lang))
										    			  window.location.reload();
								                          }
							                             });
							                        }
							                        else
							                        {
							                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
							                        	exit;
							                        }
							                      }
							                    });	
							                   }
					                         }
									      },
									    {
									    	text:dic("Fm.Cancel",lang),
					                   		click: function() {
										    $( this ).dialog( "close" );
									    }
					               }
					              ]
					   		  })
					   		  return;
							} else {
								$.ajax({
	                              url: "UpAlert2.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&id="+id+"&dostapno2="+dostapno2+"&NadminataBrzina2="+NadminataBrzina2+"&orgEdinica2="+orgEdinica2+"&odbraniVozila2="+odbraniVozila2+"&voziloOdbrano2="+voziloOdbrano2+"&remindme="+remindme1,
	                              context: document.body,
	                              success: function(data){
	                              msgboxPetar(dic("Settings.SuccChanged",lang))
				    			  window.location.reload();
		                          }
	                             });
							}
                             	
                               }
                             }else{
                             	if(sms2!="" && (oldsms2 != sms2)) {
								                    		
						   		document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
						        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
					                  buttons: 
					                  [
					                  {
					                  text:dic("Reports.Confirm"),
									  click: function() {
									    	
									    	pass = encodeURIComponent($('#dodTipPraznik').val());
									    	tipPraznikID = document.getElementById("dodTipPraznik");
									    	if(pass=="")
									    	{
									    		msgboxPetar(dic("Settings.InsertPass",lang))
									    		tipPraznikID.focus();
									    	}
									    	else
					                        {   
					                            $.ajax({
							                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
							                        context: document.body,
							                        success: function(data){
							                        if(data==1)	
							                        {
							                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
							                        	$.ajax({
								                         url: "UpAlert2.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&id="+id+"&dostapno2="+dostapno2+"&orgEdinica2="+orgEdinica2+"&odbraniVozila2="+odbraniVozila2+"&voziloOdbrano2="+voziloOdbrano2+"&remindme="+remindme1,
								                         context: document.body,
								                         success: function(data){
								                         msgboxPetar(dic("Settings.SuccChanged",lang))
									                     window.location.reload();
					    	        					 }
	                                					});
							                        }
							                        else
							                        {
							                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
							                        	exit;
							                        }
							                      }
							                    });	
							                   }
					                         }
									      },
									    {
									    	text:dic("Fm.Cancel",lang),
					                   		click: function() {
										    $( this ).dialog( "close" );
									    }
					               }
					              ]
					   		  })
					   		  return;
							} else {
								$.ajax({
	                        	 url: "UpAlert2.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&id="+id+"&dostapno2="+dostapno2+"&orgEdinica2="+orgEdinica2+"&odbraniVozila2="+odbraniVozila2+"&voziloOdbrano2="+voziloOdbrano2+"&remindme="+remindme1,
		                         context: document.body,
		                         success: function(data){
		                         msgboxPetar(dic("Settings.SuccChanged",lang))
			                     window.location.reload();
					    	     }
	                            });
							}
							
                		     
	                               }
    	                          }
    	                         }
    	                         }
    	                        }
    	                       }
                              }
                            }
                          },
                    	{
                    text: dic("Fm.Cancel", lang),
                         click: function() {
				        $( this ).dialog( "close" );
			            }
                      }
                    ] 
                  })
                }      
              });
			}
   	
   	</script>
   	
   	<script>
   	
   	function OptionsChangeAlarmType() {
	
		var zonaTockata = document.getElementById('TipNaAlarm').selectedIndex;
		document.getElementById('noteFmAlarm').style.display = "none";
   		document.getElementById('textFmAlarm').innerHTML = "";

	    if (zonaTockata == "13") {
	        document.getElementById('zonataTockata').style.display = '';
	        document.getElementById('zonataTockata2').style.display = '';
	    }
	    if (zonaTockata == "12") {
	        document.getElementById('zonaIzlez').style.display = '';
	    }
	    if (zonaTockata == "11") {
	        document.getElementById('zonaVlez').style.display = '';
	    }
	    if (zonaTockata == "10")  {
	        document.getElementById('nadminuvanjeBrzina').style.display = '';
	    } 
		if (zonaTockata == "27" || zonaTockata == "28" || zonaTockata == "29" || zonaTockata == "30") {
	        document.getElementById('fm').style.display = '';
	        document.getElementById('rmdD').style.display = '';
	        
	        if (zonaTockata == "28") {
	        	document.getElementById('rmdKm').style.display = '';
	        	document.getElementById('remindDays').style.display = '';
	        } else {
	        	document.getElementById('rmdKm').style.display = 'none';
	        	document.getElementById('remindDays').style.display = 'none';
	        }
	        document.getElementById('noteFmAlarm').style.display="";
	        if (zonaTockata == "27") {
	       		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo1", lang);
	        }
	        if (zonaTockata == "28") {
	       		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo2", lang);
	        }
	        if (zonaTockata == "29") {
	       		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo3", lang);
	        }
   		} 

	    if(zonaTockata != "13") {
	        document.getElementById('zonataTockata').style.display = 'none';
	        document.getElementById('zonataTockata2').style.display = 'none';
	  	}
	  	if(zonaTockata != "12") {
	        document.getElementById('zonaIzlez').style.display = 'none';
		}
		if(zonaTockata != "11") {
	        document.getElementById('zonaVlez').style.display = 'none';
		}
		if(zonaTockata != "10") {
	        document.getElementById('nadminuvanjeBrzina').style.display = 'none';
		}
		if(zonaTockata != "27" && zonaTockata != "28" && zonaTockata != "29" && zonaTockata != "30") {
	        document.getElementById('fm').style.display = 'none';
	        document.getElementById('rmdKm').style.display = 'none';
		}
	}
   	
   	function OptionsChangeVehicle() {
		var odberi = $("#vozila option:selected").val();//document.getElementById('vozila').selectedIndex;
	
	    if (odberi == "1") {
	        document.getElementById('ednoVozilo').style.display = '';
	    }
	    if (odberi == "2") {
	        document.getElementById('OrganizacionaEdinica').style.display = '';
	    }
	    if(odberi != "1") {
	        document.getElementById('ednoVozilo').style.display = 'none';
	  	}
	  	if(odberi != "2") {
	        document.getElementById('OrganizacionaEdinica').style.display = 'none';
		}
	}
   	
   	function DeleteAlertClick(id) {
          document.getElementById('div-del-alert').title = dic("Settings.AlertDeleteQuestion")
		  $('#div-del-alert').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons:
                [
                {
                	text:dic("Settings.Yes",lang),
				    click: function() {
                            $.ajax({
		                        url: "DelAlerts.php?id="+ id ,
		                        context: document.body,
		                        success: function(data){
		                        msgboxPetar(dic("Settings.SuccDeleted",lang))
		                        window.location.reload();
								}
		                    });
                            $( this ).dialog( "close" );
                           }
				    },
				    {
				    text:dic("Settings.No",lang),
                    click: function() {
					    $( this ).dialog( "close" );
				    }
               }
               ]
          });
    }
    </script>
   	
   	<script>
   	for (var k=0; k < <?php echo $cnt7 ?>; k++) {
		$('#btnEditA'+ k).button({ icons: { primary: "ui-icon-pencil"} });
   		$('#DelBtnA' + k).button({ icons: { primary: "ui-icon-trash"} });
	}
	for (var z=0; z < <?php echo $cnt7 ?>; z++) {
		$('#btnEditB'+ z).button({ icons: { primary: "ui-icon-pencil"} });
   		$('#DelBtnB' + z).button({ icons: { primary: "ui-icon-trash"} });
	}
   	$('#add5').button({ icons: { primary: "ui-icon-plusthick"} });
   	$('#play').button({ icons: { primary: "ui-icon-play"} });
    $('#pause').button({ icons: { primary: "ui-icon-pause"} });
    $('#poglasno').button({ icons: { primary: "ui-icon-plus"} });
    $('#potivko').button({ icons: { primary: "ui-icon-minus"} });
    $('#gfAvail').buttonset();
   	setDates();
    top.HideWait();
    SetHeightLite();
    iPadSettingsLite();
   	</script>
   	
   	<?php 
   	closedb();
   	?>  
   	  	
   	</html>
