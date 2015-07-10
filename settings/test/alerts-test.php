<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php opendb();?>

<?php

	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);  // [josip] za error reports

	header("Content-type: text/html; charset=utf-8");
	opendb();
	$clientID = session("client_id");
	$userID = session("user_id");
	$roleID = session('role_id');

	$Allow = getPriv("employees", $userID);
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);

	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	$yourbrowser1 = (bool) strpos($ua['userAgent'], "Macintosh");

	addlog(47);

	// glavni promelivi ----------------------------------

	$clienttypeid = dlookup("select clienttypeid from clients where id = " . $clientID);

	$getQueryClient = pg_fetch_array(query("select * from clients where id=" . $clientID));
	$allowedfm = $getQueryClient["allowedfm"];
	$allowedrouting = $getQueryClient["allowedrouting"];

	$getQueryUser = pg_fetch_array(query("select * from users where id=" . $userID));
	$metric =$getQueryUser["metric"];
		if ($metric == 'mi') {
			$value = 0.621371;
			$unitSpeed = "mph";
		} else {
			$value = 1;
			$unitSpeed = "Km/h";
		}
	$snooze = $getQueryUser["snooze"];

	$alarmTypes = pg_fetch_all(query("select * from alarmtypes where isactive='1' order by alarmgroup,code"));

// -------------------------------------------
function pp($a) { // pretty print za array();
    echo '<pre>'.print_r($a,1).'</pre>';
}
// pp($alarmTypes);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>



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

<style type="text/css">
	html {
		overflow: auto;
		-webkit-overflow-scrolling: touch;
	}
	body {
        /*height: 100%;*/  /* da se promeni */
        overflow: auto;
        -webkit-overflow-scrolling: touch;
        -moz-overflow-scrolling: touch;
	}
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; }
	.ui-autocomplete-input {
		margin: 0;
		padding: 0.48em 0 0.47em 0.45em;
		width: 82%;
		height: 25px;
	}

	.del-btn, .edit-btn {
		height:22px;
		width:30px
	}
	/*iminja na kolonite*/
	.th-row {
		height:25px;
		text-align:center;
		font-weight:bold;
		background-color:#E5E3E3;
		border:1px dotted #2f5185;
	}
	.td-row {
		text-align:center;
		height: 30px;
		background-color: #fff;
		border: 1px dotted #B8B8B8;
	}
	.align-center {
	    margin-left: auto;
	    margin-right: auto;
	    width: 95%;
	}
	.la {
		text-align: left;
		padding-left: 10px;
		padding-right: 10px;
	}
	.ra {
		text-align: right;
	}
</style>



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
    $(function () {
        $("#comboboxVlez").combobox();
        $("#toggle").click(function () {
            $("#comboboxVlez").toggle();
        });
    });
    $(function () {
        $("#comboboxIzlez").combobox();
        $("#toggle").click(function () {
            $("#comboboxIzlez").toggle();
        });
    });

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

</head>
<body>

<!-- tabela za naslov -->
<div class="align-center text2" style="padding-top: 25px;">
<table width="100%">
	<tr>
	    <td width="50%" align="left"><div class="textTitle" ><?php echo dic_("Settings.Alerts")?></div></td>
	    <td width="50%" align="right" colspan="5"><button  id="add5" onclick="addAlerts()"><?php dic("Settings.Add") ?></button></td>
	</tr>
</table>
</div>

<br><br>

<?php (($clienttypeid == 6) ? $colspan = 9 : $colspan = 8);

$allowed2 = 0;
$allowed3 = 0;
$strOrg = "";
if ($roleID == "2") {
	$strOrg = "select * from organisation where id in (
	select distinct organisationid from vehicles where clientid=" . $clientID . "
	and active='1' and organisationid <> 0) order by code::INTEGER";

} else {
	$strOrg = "select s.id, s.code, s.name, s.description from (select *, (select count(*) from vehicles where clientid=" . $clientID . " and organisationid=o.id) allinoe,
	(select count(*) from vehicles where id in (select vehicleid from uservehicles where userid=" . $userID . ") and organisationid=o.id) vehinoe
	 from organisation o where id in (select distinct organisationid from vehicles where id in (select vehicleid from uservehicles where
	userid=" . $userID . ") and active='1' and organisationid <> 0) order by code::INTEGER) s where s.allinoe=s.vehinoe";
}
$strCom = "";
if ($roleID == "2") {
	$strCom = "select * from vehicles where clientID=" . $clientID . " and active='1' order by cast(code as integer) asc" ;
	$allowFuel = dlookup("select count(*) from vehicles where clientID=" . $clientID . " and active='1' and allowfuel = '1'");
	$allowedRFID = dlookup("select count(*) from vehicles where clientID=" . $clientID . " and active='1' and allowrfid = '1'");
	$sqlV = "select id from vehicles where clientID=" . $clientID . " and active='1'";
} else {
	$strCom = "select * from vehicles where id in (select vehicleid from uservehicles where userid=" . $userID . ") and active='1' order by cast(code as integer) asc";
	$allowFuel = dlookup("select count(*) from vehicles where id in (select vehicleid from uservehicles where userid=" . $userID . ") and active='1' and allowfuel = '1'");
	$allowedRFID = dlookup("select count(*) from vehicles where id in (select vehicleid from uservehicles where userid=" . $userID . ") and active='1' and allowrfid = '1'");
	$sqlV = "select vehicleID from uservehicles uv left outer join vehicles v on v.id=uv.vehicleid where userID=" . $userID . " and v.active='1'";
}

$allowedCapace = dlookup("select count(*) from vehicleport where vehicleid in ($sqlV) and porttypeid=17");

if (pg_num_rows(query($strOrg)) > 0) {
	$allowed2 = 1;
}

if ((dlookup("select count(*) from vehicles where clientID=" . $clientID . " and active='1'")) == pg_num_rows(query($strCom))) {
	$allowed3 = 1;
}
    $cnt7 = 1;

$alerts = query("select distinct uniqid from alarms where clientid=" . $clientID . "");
if(pg_num_rows($alerts)==0){
?>
	<div id="noData" style="padding-left:43px; font-size:22px; font-style:italic; padding-bottom:40px" class="text4">
		<?php dic("Reports.NoData1")?>
	</div>
<?php
}
else // GLAVEN ELSE
{
?>

<!-- **********************************  GLAVNA TABELA  **************************** -->
<div class="align-center" style="overflow:scroll; height:700px; overflow:auto;">  <!-- da se trgne -->
<table width="100%">
<thead>
	<tr>
		<td height="22px" style="color:#fff; font-weight:bold; font-size:14px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b;" colspan="<?php echo $colspan?>" class="text2">
			<?php echo dic_("Settings.ListAlertsVeh")?>
		</td>
	</tr>
	<tr>
	    <td width="4%" class="th-row"></td>
	    <td width="24%" class="text2 th-row la"><b><?php dic("Settings.TypeOfAlert") ?><b></td>
		<td width="18%" class="text2 th-row"><b><?php dic("Fm.Vehicle") ?>/<?php dic("Fm.Vehicles") ?><b></td>
		<td width="14%" class="text2 th-row la"><b><?php echo dic_("Reports.Email")?><b></td>
		<?php if ($clienttypeid == 6) { ?>
		<td width="8%" class="text2 th-row">&nbsp;&nbsp;<b><?php echo dic_("Settings.SMS")?><b></td>
		<?php } ?>
		<td width="11%" class="text2 th-row"><b><?php dic("Settings.Sound") ?> (snooze)<b></td>
	    <td width="9%" class="text2 th-row"><b><?php echo dic_("Settings.AvailableFor")?><b></td>
	    <td width="6%" class="text2 th-row"><font color = "#ff6633"><b><?php dic("Settings.Change")?><b></font></td>
		<td width="6%" class="text2 th-row"><font color = "#ff6633"><b><?php dic("Tracking.Delete")?><b></font></td>
	</tr>
</thead>
<tbody>

<?php

$rowCnt = 0;
$all_alerts = query("select a.*,at.name, at.description, v.registration, cast(v.code as integer) code, v.id vid from alarms a left join alarmtypes at on a.alarmtypeid=at.id left join vehicles v on a.vehicleid=v.id
				where a.clientid=". $clientID ." and at.id <> 11
				order by cast(a.uniqid as integer) desc, alarmtypeid, code asc");

$alarmRowInfo = array();
$vehReg = '';				// promelniva za cuvanje na registracii na vozila (edno ili povekje)
$vehFlag = false;							// indicira dali e iscitana cela grupa so identicen uniqid
$last = false;								// se upotrebuva za formatiranje na registraciite i brojot na vozila vo org edinica
$RowsNumber = pg_num_rows($all_alerts);

function formatregistration($fontVeh, $row) {
	return '<span style="color:'.$fontVeh.'">'.$row["registration"]. ' ('.$row["code"].'); </span> ';
}

function formatvehicles($Title, $allow, $vehReg) {
	return $Title . " (". $allow .")<br>" . $vehReg;;
}

foreach ($ALL = pg_fetch_all($all_alerts) as $inx => $alertrow) {
// pp($ALL[$inx]);
// pp($alertrow);

if($alertrow["vid"] <> ""){  // gi otfrla site koi imaat prazni vid

// -------------------------------------------------- boja na vozilata i check --------------------------------------------
	if ($roleID == "2") {
			$checkVeh = dlookup("select count(*) from vehicles where clientID=" . $clientID . " and active='1' and id=". $alertrow["vid"]);
		}
		else {
			$checkVeh = dlookup("select count(*) from vehicles where id in (select vehicleid from uservehicles where vehicleid=" .  $alertrow["vid"] . " and userid=" . $userID . ") and active='1'");
		}
		($checkVeh == 0) ? $fontVeh = "red" : $fontVeh="";
// --------------------------------------------------[END] boja na vozilata i check ----------------------------------------

	if($alertrow["uniqid"] == "") {	// ako se raboti za obicen red
		echo "nema uniqid : " . $alertrow["vid"]. " " . $alertrow["description"] . "<br>";

		$vehReg .= '<span style="color:'.$fontVeh.'">'.$alertrow["registration"]. ' ('.$alertrow["code"].') </span> ';
		array_push($alarmRowInfo, array(
			'data' => $alertrow,
			'vreg'	=> $vehReg
		));

		$vehReg="";

	} else {	// redovi kade uniqid <> ""

		if ($alertrow["uniqid"] == $ALL[$inx+1]["uniqid"]){		// redovi so isti uniqid
			echo "uniqid : " . $alertrow["vid"]. " " . $alertrow["description"] . "<br>";

			$vehReg .= formatRegistration($fontVeh, $alertrow);

			if($RowsNumber == $inx+2){		// vazi samo za posledniot red

				$last = true;
				$vehFlag = true;
				$vehRegLast .= $vehReg . formatRegistration($fontVeh, $alertrow);
				if($alertrow["typeofgroup"] == 2) $TitleLast = dlookup("select name from organisation where id=" . $alertrow["settings"]);
				if($alertrow["typeofgroup"] == 3) $TitleLast = dic_("Tracking.AllVehCompany");

			}
		}

		if(($alertrow["uniqid"] != $ALL[$inx+1]["uniqid"]) or $last) {	// ako uniqid na naredniot red ne e ist so prethodniot
			echo "uniqid : " . $alertrow["vid"]. " " . $alertrow["description"] . "<br>";
			echo "kraj na ist uniqid <br>";

			if ($alertrow["typeofgroup"] == 2) {
				$Title = dlookup("select name from organisation where id=" . $alertrow["settings"]);

				if ($roleID == "2") {
					$cntAllowVeh = dlookup("select count(*) from vehicles where clientID=" . $clientID . " and organisationid = " . $alertrow["settings"] . " and active='1'") ;
				} else {
					$cntAllowVeh = dlookup("select count(*) from vehicles where id in (select vehicleid from uservehicles where userid=" . $userID . ") and organisationid = " . $alertrow["settings"] . " and active='1'");
				}
			}
			if ($alertrow["typeofgroup"] == 3) {
				$Title = dic_("Tracking.AllVehCompany");

				if ($roleID == "2") {
					$cntAllowVeh = dlookup("select count(*) from vehicles where clientID=" . $clientID . " and active='1'") ;
				} else {
					$cntAllowVeh = dlookup("select count(*) from vehicles where id in (select vehicleid from uservehicles where userid=" . $userID . ") and active='1'");
				}
			}

			if($last) {
				$vehRegTemp = formatvehicles($TitleLast, $cntAllowVeh, $vehRegLast);

			} else {
				$vehRegTemp = formatvehicles($Title, $cntAllowVeh, $vehReg);

			}
			$vehFlag = true;
			$vehReg="";

		}

	}
	if($vehFlag) {	// ako e setiran ovoj flag toa znaci deka cela grupa so ist uniqid e ischitana ($vehRegTemp)

	array_push($alarmRowInfo, array(
		'data' => $alertrow,
		'vreg'	=> $vehRegTemp
	));
	$vehFlag = false;
	}
}
}
echo "ALARMROW ----------------- <br>";
// pp($alarmRowInfo);
// -------------------------------------- LOOP za generirawe na redovite ----------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------------


foreach ($alarmRowInfo as $tableRow)
{  //w3

$condVeh = ($tableRow['data']['uniqid'] != "") ? $cntAllowVeh : $checkVeh;

if ($condVeh > 0 or true) //da se smeni
{  //w6

// REDOVI NA TABELATA --------------------------------------------------------

	$rowCnt = $rowCnt +1;
	?>
	<tr>
		<td class="text2 td-row la"><?php echo $rowCnt?></td>
		<td class="text2 td-row la">
			<b> <?php dic($tableRow['data']["name"]) ?></b>
			<br>
		<?php

		if ($tableRow['data']["alarmtypeid"] == "17"){
			if ($tableRow['data']["remindme"] != "") {
				$arr = explode(" ", $tableRow['data']["remindme"]);
				if ($arr[1] == "days") $remindme = $arr[0] . " " . dic_("Reports.Days_");
				else {
					$remindme = round($arr[0] * $value,0) . " " . $metric;
				}
				echo " (". $remindme ." " . dic_("Settings.Before") . ")";
			}

		}

		if ($tableRow['data']["alarmtypeid"] == "18"){
			if ($tableRow['data']["remindme"] != "") {

				$arr = explode("; ", $tableRow['data']["remindme"]);
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

		if ($tableRow['data']["alarmtypeid"] == "20"){
			if ($tableRow['data']["remindme"] == "") {

			$arr = explode(" ", $tableRow['data']["remindme"]);
				if ($arr[1] == "days") $remindme = $arr[0] . " " . dic_("Reports.Days_");
				else {
					$remindme = round($arr[0] * $value,0) . " " . $metric;
				}
				echo " (". $remindme ." " . dic_("Settings.Before") . ")";
			}
		}

		if ($tableRow['data']["alarmtypeid"] == "7"){
			echo "(". $tableRow['data']['speed']. "kmh)";
		}

		if ($tableRow['data']["alarmtypeid"] == "10"){
			echo "(" . dlookup("select name from pointsofinterest where id = ".$tableRow['data']["poiid"]) . ")<br>(" . $tableRow['data']['timeofpoi'] . " " . dic_("Settings.minutes") . ")";
		}

		if ($tableRow['data']["alarmtypeid"] == "9"){
			echo "(" . dlookup("select name from pointsofinterest where id = ".$tableRow['data']["poiid"]) . ")";
		}

		if ($tableRow['data']["alarmtypeid"] == "8"){
			echo "(" . dlookup("select name from pointsofinterest where id = " . $tableRow['data']["poiid"]) . ")";

		}
		?>

		</td>

		<td class="text2 td-row" style="color:<?php echo $fontVeh?>">
			<?php
				echo $tableRow['vreg'];
			?>
		</td>
		<td class="text2 td-row la" style="line-height:15px;">
			<?php
			if($tableRow['data']["emails"]!="")	echo str_replace(',', '<br>', $tableRow['data']["emails"]);
			// nema potreba od else &nbsp;
			?>
		</td>
		<?php
		if ($clienttypeid == 6) { ?>
			<td class="text2 td-row la">
			<?php echo nnull($tableRow['data']["sms"], "/")?>
			</td>
		<?php
		}
		?>
		<td class="text2 td-row">
			<?php echo dic_("Settings.Sound") . "  " . $tableRow['data']["soundid"];
			echo (($snooze == 0) ? dic("Settings.NoRepetition") : "(" . $snooze . " " . dic_("Reports.Minutes") . ")"); ?>
		</td>
		<td class="text2 td-row">
			<?php
				if($tableRow['data']["available"] == 1) {
					echo dic_("Settings.User");
				} else
				if($tableRow['data']["available"] == 2) {
					echo dic_("Reports.OrgUnit");
				} else
				if($tableRow['data']["available"] == 3) {
					echo dic_("Settings.Company");
				} else {
					?> / <?php
				}
			?>

		<?php

		$styleBtn = "";
		$styleDisabled = "";
		if ($tableRow['data']["typeofgroup"] == 2 and $allowed2 == 0 or $tableRow['data']["typeofgroup"] == 3 and $allowed3 == 0) {
			$styleBtn = "; opacity:0.5;";
			$styleDisabled = "disabled";
		}
		 ?>
		</td>
		<td class="text2 td-row">
			<button id="btnEditA<?php echo $cnt7?>" class="edit-btn" <?php echo $styleDisabled?> onclick="EditAlertClick(<?php echo $tableRow['data']["id"]?>)" style="height:22px; width:30px <?php echo $styleBtn ?>"></button>
		</td>
		<td class="text2 td-row">
			<button id="DelBtnA<?php echo $cnt7?>" class="del-btn" <?php echo $styleDisabled?> onclick="DeleteAlertClick(<?php echo $tableRow['data']["id"]?>)" style="height:22px; width:30px <?php echo $styleBtn ?>"></button>
		</td>
	</tr>
	<?php
	$cnt7++;
	}  //w6.
} //w3.

?>
</tbody>
</table>

</div>	<!-- [END] **********************************  GLAVNA TABELA  **************************** -->

<?php
}	// [END]. tabela else (za noData)
?>
<!-- ********************************* ******************************** **************************** -->
<!--                   DIALOGS                  -->

<div id="dialog-message" title="<?php echo dic("Reports.Message")?>" style="display:none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px"></div>
	</p>
</div>

<!-- **************************************   ADD DIALOG   ******************************************** -->

<div id="div-add-alerts" style="display:none" title="<?php dic("Settings.AddAlerts") ?>">
	<div align = "center">

	<table cellpadding="3" width="100%" style="padding-top: 25px;">
		<tr>
			<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php dic("Settings.TypeOfAlert") ?></td>
			<td width = "75%">
			<select id = "TipNaAlarm" style="font-size: 11px; width:365px; position: relative; top: 0px ;visibility: visible;" onchange="OptionsChangeAlarmType()" class="combobox text2">
			<?php

			$alarmgroup = "";
			foreach ($alarmTypes as $index => $alarmRow) {

				// proverki za koi opcii da bidat dozvoleni
				$alarmRow['check'] = 0;

				if($alarmRow['code'] == 'A48' && $allowFuel == 0) $alarmRow['check'] = 1;	// alarm za dozvoleno gorivo
				if($alarmRow['code'] == 'A23' && $allowedRFID == 0) $alarmRow['check'] = 1;	// alarm za RFID
				if($alarmRow['code'] == 'A05' && $allowedCapace == 0) $alarmRow['check'] = 1;  // za dali e dozvoleno kapace za korivo

				if($alarmRow['alarmgroup'] == "2-RoutesCombo" && $allowedrouting == 0) $alarmRow['check'] = 1;
				if($alarmRow['alarmgroup'] == "3-FleetManagement"  && $allowedfm == 0) $alarmRow['check'] = 1;
				if($alarmRow['alarmgroup'] == "5-MotoAlarms"  && $clienttypeid != 6) $alarmRow['check'] = 1;
				// [END]. proverki --------------------------------------------------------------------------------------

				if($alarmRow["alarmgroup"] == $alarmgroup) {
					// prikazi gi site od ist alarmgroup
					?>
						<option value="<?php echo $alarmRow['code'] ?>" <?php if($alarmRow["check"]==1) echo "disabled='disabled'" ?>><?php dic($alarmRow['name']) ?></option>
					<?php
				} else {
					// promeni go
					$alarmgroup = $alarmRow["alarmgroup"];
					$alarmgroupShow = explode('-', $alarmgroup);
					// prikazi ja taa grupa kako disabled vo option
					?>
						<option disabled="disabled">----------------------<?php dic("Settings." . $alarmgroupShow[1]) ?>----------------------</option>
						<option value="<?php echo $alarmRow['code'] ?>" <?php if($alarmRow["check"]==1) echo "disabled='disabled'" ?>><?php dic($alarmRow['name']) ?></option>
					<?php
				}
			}
			?>
			</select>
			</td>
		</tr>
		<tr id="toi-div" style="display:none;">
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
		<tr id="toi-div-2" style="display:none;">
			<td style="font-weight:bold" class ="text2" width="25%" align="left"><?php dic("Routes.RetentionTime")?></td>
			<td style="font-weight:bold" class ="text2" width="75%">
				<input id = "vreme" class="textboxcalender corner5 text5" type="text" size="5"></input>&nbsp;<?php echo dic("Reports.Minutes")?>
			</td>
		</tr>
		<tr id="zv-div" style="display:none;">
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
		<tr id="zi-div" style="display:none;">
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
			<td width = "27%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic_("Settings.RemindMe")?> <?php echo dic_("Settings.Before")?>:</td>
			<td width = "73%" style="" class ="text2">
				<span id="rmdD">
				 <input id="remindDays" type="checkbox" name="remindme" value="days" style="position: relative; top:4px; display:none" checked /> 
				 <input id = "fmvalueDays" class="textboxCalender corner5 text5" type="text" style="width:40px" value="5"> <?php echo dic_("Reports.Days_")?>
				</span>
				<span id="rmdKm" style="display: none">
				 <input id="remindKm" type="checkbox" name="remindme" value="Km" style="position: relative; top:4px; margin-left: 15px" /> 
				 <input id = "fmvalueKm" class="textboxCalender corner5 text5" type="text" style="width:40px" value="0"> <?php echo $metric?>
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
			<input type="radio" value="1" id="GFcheck1" name="radio" checked="checked" /><label for="GFcheck1"><?php echo dic_("Settings.User")?></label>
			<input type="radio" value="2" id="GFcheck2" name="radio" /><label for="GFcheck2"><?php echo dic_("Reports.OrgUnit")?></label>
			<input type="radio" value="3" id="GFcheck3" name="radio" /><label for="GFcheck3"><?php echo dic_("Settings.Company")?></label>
			</div>
			</td>
		</tr>
		</table>
	</div>
</div>

<!-- ************************************************************************************************** -->

</body>

<script>

function validacija() {
    var emails = $('#emails').val();
    var emailovi = emails.split(",");
    var izlez;
    emailovi.forEach(function(mejl) {
        var filter = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
        izlez = filter.test(mejl.trim());
    });
    return izlez;
}

function isNum( obj ) {
    return !jQuery.isArray( obj ) && (obj - parseFloat( obj ) + 1) >= 0;
}

function isChecked( obj ) {		// samo za id
	return ($('#'+obj).is(':checked'));
}

function addAlerts() {
	
    document.getElementById('div-add-alerts').title = dic("Settings.AddAlerts");
    $('#div-add-alerts').dialog({
        modal: true,
        width: 590,
        height: 500,
        resizable: false,
        buttons: [{
            text: dic('Settings.Add', lang),
            click: function(data) {
                var tipNaAlarm = $('#TipNaAlarm').val();
                var email = $('#emails').val();
                var sms = ''; //$('#sms').val()
                if ('<?php echo $clienttypeid ?>' == 6) sms = $('#sms').val();
                var zvukot = $('#zvukot').val();
                var ImeNaTocka = $('#combobox').val();
                var ImeNaTockaProverka = document.getElementById('combobox').selectedIndex;
                var ImeNaZonaIzlez = $('#comboboxIzlez').val();
                var ImeNaZonaIzlezProverka = document.getElementById('comboboxIzlez').selectedIndex;
                var ImeNaZonaVlez = $('#comboboxVlez').val();
                var ImeNaZonaVlezProverka = document.getElementById('comboboxVlez').selectedIndex;
                var orgEdinica = $('#oEdinica').val();
                var odbraniVozila = $("#vozila option:selected").val(); //document.getElementById('vozila').selectedIndex;
                var NadminataBrzina = $('#brzinata').val();
                var vreme = $('#vreme').val();
                var alarmSelect = document.getElementById('TipNaAlarm').selectedIndex;
                var voziloOdbrano = $('#voziloOdbrano').val();
                var dostapno = getCheckedRadio('radio');

                //------------------------------------------------------------------------//
                ////////////////////////////////////////////////////////////////////////////
                var qString = "AddAlert2.php?";
                var validation = [];

                if(email === '') validation.push("Settings.AlertsEmailHaveTo");
                if(email.length > 0 && !validacija()) validation.push("uncorrEmail");

	 			if(Number(odbraniVozila) === 0) validation.push("Settings.SelectAlert1");

	 			if(tipNaAlarm == "A07" && NadminataBrzina === ""){
	 				validation.push("Settings.InsertSpeedOver");
	 			}
	 			if(tipNaAlarm == "A08" && ImeNaZonaVlezProverka == ""){
	 				validation.push("Settings.SelectExitGeoF");
	 			}
	 			if(tipNaAlarm === "A09" && ImeNaZonaIzlezProverka == ""){
	 				validation.push("Settings.SelectExitGeoF");
				}
	 			if(tipNaAlarm == "A10"){
	 				if(ImeNaTockaProverka == "") validation.push("Settings.SelectPOI2");
	 				else {
		 				if(!isNum(vreme)) validation.push("Settings.InsertRetTime");
	 				}
	 			}
	 			if(tipNaAlarm == "A18" && (isChecked("remindKm") === false && isChecked("remindDays") === false)) validation.push("Settings.RemindMeMustOne");


	 			if (sms !== "") {
                    document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS", lang);
                    $('#div-tip-praznik').dialog({
                        modal: true,
                        width: 300,
                        height: 230,
                        resizable: false,
                        buttons: [{
                            text: dic("Reports.Confirm"),
                            click: function() {
                                pass = encodeURIComponent($('#dodTipPraznik').val());
                                tipPraznikID = document.getElementById("dodTipPraznik");
                                if (pass === "") {
                                    msgboxPetar(dic("Settings.InsertPass", lang));
                                    tipPraznikID.focus();
                                } else {
                                    $.ajax({
                                        url: "checkPassword2.php?pass=" + pass + "&l=" + lang,
                                        context: document.body,
                                        success: function(data) {
                                            if (data == 1) {
                                                msgboxPetar(dic("Settings.VaildPassSucAlert", lang));
												qString += "&sms=" + sms;
                                                // $.ajax({
                                                //     url: "AddAlert2.php?tipNaAlarm=" + tipNaAlarm + "&email=" + email + "&sms=" + sms + "&zvukot=" + zvukot + "&ImeNaTocka=" + ImeNaTocka + "&ImeNaZonaIzlez=" + ImeNaZonaIzlez + "&ImeNaZonaVlez=" + ImeNaZonaVlez + "&NadminataBrzina=" + NadminataBrzina + "&vreme=" + vreme + "&dostapno=" + dostapno + "&orgEdinica=" + orgEdinica + "&odbraniVozila=" + odbraniVozila + "&voziloOdbrano=" + voziloOdbrano + "&remindme=" + remindme,
                                                //     context: document.body,
                                                //     success: function(data) {
                                                //         window.location.reload();
                                                //     }
                                                // });
                                            } else {
                                                msgboxPetar(dic("Settings.Incorrectpass", lang));
                                                exit;
                                            }
                                        }
                                    });
                                }
                            }
                        }, {
                            text: dic("Fm.Cancel", lang),
                            click: function() {
                                $(this).dialog("close");
                            }
                        }]
                    });
                }


	 			console.log(validation);

	 			//------------------------------[END] validation ------------------------------------//
                ///////////////////////////////////////////////////////////////////////////////////////
             }
        }, {
            text: dic('cancel', lang),
            click: function() {
                $(this).dialog("close");
            }
        }, {
            text: "test",
            click: function() {
                console.log($('#TipNaAlarm').val());
            }
        }
        ]
    });
}

function OptionsChangeAlarmType() {

	  	var tipNaAlarm = $('#TipNaAlarm').val();
		console.log("tip na alarm: " + tipNaAlarm);
		// var selIndex = document.getElementById('TipNaAlarm').selectedIndex;
		document.getElementById('noteFmAlarm').style.display = "none";
   		document.getElementById('textFmAlarm').innerHTML = "";

	    if (tipNaAlarm == "A10") {
	        document.getElementById('toi-div').style.display = '';
	        document.getElementById('toi-div-2').style.display = '';
	    }
	    if (tipNaAlarm == "A09") {
	        document.getElementById('zi-div').style.display = '';
	    }
	    if (tipNaAlarm == "A08") {
	        document.getElementById('zv-div').style.display = '';
	    }
	    if (tipNaAlarm == "A07")  {
	        document.getElementById('nadminuvanjeBrzina').style.display = '';
	    }
		if (tipNaAlarm == "A17" || tipNaAlarm == "A18" || tipNaAlarm == "A20") {
	        document.getElementById('fm').style.display = '';
	        document.getElementById('rmdD').style.display = '';

	        if (tipNaAlarm == "A18") {
	        	document.getElementById('rmdKm').style.display = '';
	        	document.getElementById('remindDays').style.display = '';
	        } else {
	        	document.getElementById('rmdKm').style.display = 'none';
	        	document.getElementById('remindDays').style.display = 'none';
	        }
	        document.getElementById('noteFmAlarm').style.display="";
	        if (tipNaAlarm == "A17") {
	       		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo1", lang);
	        }
	        if (tipNaAlarm == "A18") {
	       		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo2", lang);
	        }
	        if (tipNaAlarm == "A20") {
	       		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo3", lang);
	        }
   		}


	    if(tipNaAlarm != "A10") {
	        document.getElementById('toi-div').style.display = 'none';
	        document.getElementById('toi-div-2').style.display = 'none';
	  	}
	  	if(tipNaAlarm != "A09") {
	        document.getElementById('zi-div').style.display = 'none';
		}
		if(tipNaAlarm != "A08") {
	        document.getElementById('zv-div').style.display = 'none';
		}
		if(tipNaAlarm != "A07") {
	        document.getElementById('nadminuvanjeBrzina').style.display = 'none';
		}
		if(tipNaAlarm != "A17" && tipNaAlarm != "A18" && tipNaAlarm != "A20") {
	        document.getElementById('fm').style.display = 'none';
	        document.getElementById('rmdKm').style.display = 'none';
		}

}

function OptionsChangeVehicle() {
	var odberi = $("#vozila option:selected").val();

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
	$('<div></div>').dialog({
	modal: true,
	width: 350,
	height: 170,
	resizable: false,
	title: dic("Settings.AlertDeleteQuestion"),
	open: function() {
      $(this).html(dic("Settings.DelAlert"));
    },
	    buttons:
	    [
	    {
	    	text:dic("Settings.Yes",lang),
		    click: function() {
	                $.ajax({
	                    url: "DelAlerts.php?id="+ id ,
	                    context: document.body,
	                    success: function(data){
	                    msgboxPetar(dic("Settings.SuccDeleted",lang));
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

function getCheckedRadio(name) {
var radios = document.getElementsByName(name);
for(var i = 0; i < radios.length; i++) {
       if(radios[i].checked === true) {
           return  radios[i].value;
       }
     }
 }


// ----------------------------- za document.ready() -----------------------------------------------------
	$('.del-btn').button({ icons: { primary: "ui-icon-trash"} });
	$('.edit-btn').button({ icons: { primary: "ui-icon-pencil"} });

   	$('#add5').button({ icons: { primary: "ui-icon-plusthick"} });
   	$('#play').button({ icons: { primary: "ui-icon-play"} });
    $('#pause').button({ icons: { primary: "ui-icon-pause"} });
    $('#poglasno').button({ icons: { primary: "ui-icon-plus"} });
    $('#potivko').button({ icons: { primary: "ui-icon-minus"} });
    $('#gfAvail').buttonset();
   	setDates();
    top.HideWait();
    // SetHeightLite();
    // iPadSettingsLite();
</script>

</html>

<?php closedb(); ?>