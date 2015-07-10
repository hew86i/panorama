<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php opendb();?>

<?php
	// error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);  // [josip] za error reports

	header("Content-type: text/html; charset=utf-8");
	opendb();
	$clientID = session("client_id");
	$userID = session("user_id");
	$roleID = session('role_id');

	$Allow = getPriv("employees", $userID);
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);

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

	$qGetMobileOperators = query("select * from operators order by name");
	$getFullOperators = pg_fetch_all($qGetMobileOperators);

	$allowedSMSvEmail = $getQueryUser["allowsmsvemail"];

function pp($a) {
    echo '<pre>'.print_r($a,1).'</pre>';
}

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
        height: 100%;
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
				    },
				    select: function (event, ui) {
				        ui.item.option.selected = true;
				        self._trigger("selected", event, {
				            item: ui.item.option
				        });
				        select.trigger("change");
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
            setval : function(value) {
				this.input.val(value);
        	},
        	destroy: function () {
	            this.input.remove();
	            this.button.remove();
	            this.element.show();
	            $.Widget.prototype.destroy.call(this);
		  }
       });
	})(jQuery);

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

 var row_array = [];

</script>

</head>
<body>

<!-- tabela za naslov -->
<div class="align-center text2" style="padding-top: 25px;">
<table width="100%">
	<tr>
	    <td width="50%" align="left"><div class="textTitle" ><?php echo dic_("Settings.Alerts")?></div></td>
	    <td width="50%" align="right" colspan="5"><button  id="add5" onclick="storeAlerts()"><?php dic("Settings.Add") ?></button></td>
	</tr>
</table>
</div>

<br><br>

<?php

(($allowedSMSvEmail == 1) ? $colspan = 9 : $colspan = 8);  //novo

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

$alerts = query("select distinct uniqid from alarms where clientid=" . $clientID . "");
// go zima brojot na alerti so razlicen uniqid + 1 za ostanatite

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
<div class="align-center">
<table id="main_table" width="100%">
<thead>
	<tr>
		<td height="22px" style="color:#fff; font-weight:bold; font-size:14px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b;" colspan="<?php echo $colspan?>" class="text2">
			<?php echo dic_("Settings.ListAlertsVeh")?>
		</td>
	</tr>
	<tr>
	    <td width="3%" class="th-row"></td>
	    <td width="22%" class="text2 th-row la"><b><?php dic("Settings.TypeOfAlert") ?><b></td>
		<td width="16%" class="text2 th-row"><b><?php dic("Fm.Vehicle") ?>/<?php dic("Fm.Vehicles") ?><b></td>
		<td width="13%" class="text2 th-row la"><b><?php echo dic_("Reports.Email")?><b></td>
		<?php if ($allowedSMSvEmail == 1) { ?>
		<td width="7%" class="text2 th-row la">&nbsp;&nbsp;<b><?php echo dic_("Settings.SendviaEmail")?><b></td>
		<?php } ?>
		<td width="10%" class="text2 th-row"><b><?php dic("Settings.Sound") ?> (snooze)<b></td>
	    <td width="9%" class="text2 th-row"><b><?php echo dic_("Settings.AvailableFor")?><b></td>
	    <td width="6%" class="text2 th-row"><font color = "#ff6633"><b><?php dic("Settings.Change")?><b></font></td>
		<td width="6%" class="text2 th-row"><font color = "#ff6633"><b><?php dic("Tracking.Delete")?><b></font></td>
	</tr>
</thead>
<tbody>

<?php

$all_alerts = query("select a.*,at.name, at.description, v.registration, cast(v.code as integer) code, v.id vid from alarms a left join alarmtypes at on a.alarmtypeid=at.id left join vehicles v on a.vehicleid=v.id
				where a.clientid=". $clientID ." and at.id <> 11
				order by cast(a.uniqid as integer) desc, alarmtypeid, code asc");

$alarmRowInfo = array();	// glavna promenliva kade ke bidata zacuvani vrednostite za redovite koi treba da bidat prikazani
$lastvar = array();			// se cuvaat promenlivi od prethodniot red + celiot prethoden red
$lastrow = '';				// se cuva posledniot red
$vehReg = '';				// promelniva za cuvanje na registracii na vozila (edno ili povekje)
$Title = '';				// naslov na organizaciona edinica ili na grupata
$lastuniqid='';				//inicijalna vrednost
$cntUniqID = 0;

$cntAllowVeh='';

function formatregistration($fontVeh, $row) {
	return '<span style="color:'.$fontVeh.'">'.$row["registration"]. ' ('.$row["code"].'); </span> ';
}

function formatvehicles($Title, $allow, $vehReg) {
	return $Title . " (". $allow .")<br><div>" . $vehReg . "</div>";
}

// -------------------------------------- LOOP za generirawe na redovite ----------------------------------------------------
// --------------------------------------------------------------------------------------------------------------------------
while ($alertrow = pg_fetch_array($all_alerts,null,PGSQL_ASSOC)) {
if($alertrow["vid"] <> "") {  // gi otfrla site koi imaat prazni vid

// -------------------------------------------------- boja na vozilata i check --------------------------------------------
	if ($roleID == "2") {
			$checkVeh = dlookup("select count(*) from vehicles where clientID=" . $clientID . " and active='1' and id=". $alertrow["vid"]);
		}
		else {
			$checkVeh = dlookup("select count(*) from vehicles where id in (select vehicleid from uservehicles where vehicleid=" .  $alertrow["vid"] . " and userid=" . $userID . ") and active='1'");
		}
		($checkVeh == 0) ? $fontVeh = "red" : $fontVeh="";
// --------------------------------------------------[END] boja na vozilata i check ----------------------------------------

if($alertrow["uniqid"]=="") { // nema uniqid

	$vehReg .= '<span style="color:'.$fontVeh.'">'.$alertrow["registration"]. ' ('.$alertrow["code"].') </span> ';
		array_push($alarmRowInfo, array(
			'data' => $alertrow,
			'vreg'	=> $vehReg
		));

	$vehReg="";

} else { //ima uniqid

		// ----------------------------- Title and cntAllowVeh --------------------------------------------------------------
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
		// -------------------------------[end] Title and cntAllowVeh ------------------------------------------------------------

	if($lastuniqid == "") $lastuniqid = $alertrow["uniqid"]; // inicijalna vrednost za prv uniqid

	if($alertrow["uniqid"] == $lastuniqid) {

		$cntUniqID++; // izbroj go redot

		$vehReg .= formatRegistration($fontVeh, $alertrow);
		$lastrow = $alertrow;

	}
	if($alertrow["uniqid"] != $lastuniqid) {

		$row = '';
		$vehRegTemp = formatvehicles($lastvar['title'], $lastvar['cntallowveh'], $vehReg);

		if($cntUniqID == 1) {
			$row = $lastvar['row'];
		}else {
			$row = $lastrow;
		}

		array_push($alarmRowInfo, array(
				'data' => $row,
				'vreg'	=> $vehRegTemp
			));

		$vehReg = formatRegistration($fontVeh, $alertrow);
		$cntUniqID = 1; //reset bidejke eden veke e pronajden
	}

}  // else ako ima uniqid

	$lastvar = array('title' => $Title, 'fontveh' => $fontVeh, 'cntallowveh' => $cntAllowVeh, 'row' => $alertrow);
	$lastuniqid = $alertrow["uniqid"];

} // glaven if za vid <> ""
} // end while fetch

if($lastuniqid != "") {	// proverka poradi toa sto moze da ne postoi nitu eden red so uniqid

	$vehRegTemp = formatvehicles($lastvar['title'], $lastvar['cntallowveh'], $vehReg);
	array_push($alarmRowInfo, array(
					'data' => $lastvar['row'],  //currrow
					'vreg'	=> $vehRegTemp
				));
}

?>
 <!-- zacuvaj gi podatocite za site redovi vo JS  -->
<script type="text/javascript">
	row_array = <?php echo json_encode($alarmRowInfo); ?>;
	getMO = <?php echo json_encode($getFullOperators); ?>;
</script>

<?php

/////////////////////////////////////// END LOOP /////////////////////////////////////////

$rowCnt = 0;	// broj na red vo tabelata

foreach ($alarmRowInfo as $tableRow)
{  //w3

$condVeh = ($tableRow['data']['uniqid'] != "") ? $cntAllowVeh : $checkVeh;

if ($condVeh > 0) //da se smeni
{  //w6

// REDOVI NA TABELATA --------------------------------------------------------

	$rowCnt++;
	?>
	<tr id="<?php echo $tableRow['data']['id'] ?>">
		<td class="text2 td-row la"><?php echo $rowCnt?></td>
		<td class="text2 td-row la">
			<b> <?php dic($tableRow['data']["name"]) ?></b>
			<br>
		<?php

		if ($tableRow['data']["alarmtypeid"] == 17){
			if ($tableRow['data']["remindme"] != "") {
				$arr = explode(" ", $tableRow['data']["remindme"]);
				if ($arr[1] == "days") $remindme = $arr[0] . " " . dic_("Reports.Days_");
				else {
					$remindme = round($arr[0] * $value,0) . " " . $metric;
				}
				echo " (". $remindme ." " . dic_("Settings.Before") . ")";
			}

		}

		if ($tableRow['data']["alarmtypeid"] == 18){
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

		if ($tableRow['data']["alarmtypeid"] == 20){
			if ($tableRow['data']["remindme"] != "") {

			$arr = explode(" ", $tableRow['data']["remindme"]);
				if ($arr[1] == "days") $remindme = $arr[0] . " " . dic_("Reports.Days_");
				else {
					$remindme = round($arr[0] * $value,0) . " " . $metric;
				}
				echo " (". $remindme ." " . dic_("Settings.Before") . ")";
			}
		}

		if ($tableRow['data']["alarmtypeid"] == 7){
			echo "(". round($tableRow['data']['speed'] * $value) . " " .$unitSpeed.")";
		}

		if ($tableRow['data']["alarmtypeid"] == 10){
			echo "(" . dlookup("select name from pointsofinterest where id = ".$tableRow['data']["poiid"]) . ")<br>(" . $tableRow['data']['timeofpoi'] . " " . dic_("Settings.minutes") . ")";
		}

		if ($tableRow['data']["alarmtypeid"] == 9){
			echo "(" . dlookup("select name from pointsofinterest where id = ".$tableRow['data']["poiid"]) . ")";
		}

		if ($tableRow['data']["alarmtypeid"] == 8){
			echo "(" . dlookup("select name from pointsofinterest where id = " . $tableRow['data']["poiid"]) . ")";

		}
		?>

		</td>

		<td class="text2 td-row" style="color:<?php echo $fontVeh?>; cursor:pointer" onclick="hideVeh(<?php echo $tableRow['data']["id"] ?>)">
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
		if ($allowedSMSvEmail == 1) { ?>
			<td class="text2 td-row la">
			<?php
				if($tableRow['data']["smsviaemail"] != null) {
					$gsse = explode('@',$tableRow['data']["smsviaemail"]);
					echo $gsse[0] . "<br>";
				echo "(<b>" . dlookup("select name from operators where email='" . $gsse[1] . "'") . "</b>)";
				} else echo "/";
			?>
			</td>
		<?php
		}
		?>
		<td class="text2 td-row">
			<?php echo dic_("Settings.Sound") . "  " . $tableRow['data']["soundid"];
			echo (($snooze == 0) ? dic("Settings.NoRepetition") : " (" . $snooze . " " . dic_("Reports.Minutes") . ")"); ?>
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
			<button id="btnEditA<?php echo $rowCnt?>" class="edit-btn" <?php echo $styleDisabled?> onclick="storeAlerts(true,<?php echo $tableRow['data']["id"]?>)" style="height:22px; width:30px <?php echo $styleBtn ?>"></button>
		</td>
		<td class="text2 td-row">
			<button id="DelBtnA<?php echo $rowCnt?>" class="del-btn" <?php echo $styleDisabled?> onclick="DeleteAlertClick(<?php echo $tableRow['data']["id"]?>)" style="height:22px; width:30px <?php echo $styleBtn ?>"></button>
		</td>
	</tr>
	<?php
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
<br><br><br><br>

<div id="dialog-message" title="<?php echo dic("Reports.Message")?>" style="display:none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px"></div>
	</p>
</div>

<!-- **************************************   ADD DIALOG   ******************************************** -->

<div id="dialog-alerts" style="display:none" title="<?php dic("Settings.AddAlerts") ?>">
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

				if($alarmRow['id'] == 48 && $allowFuel == 0) $alarmRow['check'] = 1;	// alarm za dozvoleno gorivo
				if($alarmRow['id'] == 23 && $allowedRFID == 0) $alarmRow['check'] = 1;	// alarm za RFID
				if($alarmRow['id'] == 5  && $allowedCapace == 0) $alarmRow['check'] = 1;  // za dali e dozvoleno kapace za korivo

				if($alarmRow['alarmgroup'] == "2-RoutesCombo" && $allowedrouting == 0) $alarmRow['check'] = 1;
				if($alarmRow['alarmgroup'] == "3-FleetManagement"  && $allowedfm == 0) $alarmRow['check'] = 1;
				if($alarmRow['alarmgroup'] == "5-MotoAlarms"  && $clienttypeid != 6) $alarmRow['check'] = 1;
				// [END]. proverki --------------------------------------------------------------------------------------

				if($alarmRow["alarmgroup"] == $alarmgroup) {
					// prikazi gi site od ist alarmgroup
					?>
						<option value="<?php echo $alarmRow['id'] ?>" <?php if($alarmRow["check"]==1) echo "disabled='disabled'" ?>><?php dic($alarmRow['name']) ?></option>
					<?php
				} else {
					// promeni go
					$alarmgroup = $alarmRow["alarmgroup"];
					$alarmgroupShow = explode('-', $alarmgroup);
					// prikazi ja taa grupa kako disabled vo option
					?>
						<option disabled="disabled">----------------------<?php dic("Settings." . $alarmgroupShow[1]) ?>----------------------</option>
						<option value="<?php echo $alarmRow['id'] ?>" <?php if($alarmRow["check"]==1) echo "disabled='disabled'" ?>><?php dic($alarmRow['name']) ?></option>
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
						$str1 .= "select * from pointsofinterest where clientid=" . $clientID ." and type=1 and active = '1' ORDER BY name";
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
						$str2 .= "select * from pointsofinterest where clientid=" . $clientID ." and (type=2 or type=3) and active = '1' ORDER BY name";
						$dsPP2 = query($str2);

						while($row2 = pg_fetch_array($dsPP2)) {
						?>
							<option value="<?php echo $row2["id"] ?>" ><?php echo $row2["name"]?></option>
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
						$str3 .= "select * from pointsofinterest where clientid=" . $clientID ." and (type=2 or type=3) and active = '1' ORDER BY name";
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
			<td width = "75%" style="font-weight:bold" class ="text2"><input id = "brzinata" class="textboxcalender corner5 text5" type="text" size="10"></input>&nbsp;<?php echo $unitSpeed ?></td>
		</tr>
		<tr>
			<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Settings.InsertAler")?>:</td>
			<td width = "75%" style="font-weight:bold" class ="text2">
			<div class="ui-widget" style="height: 25px; width: 100%;">
			<select id="vozila" style="width: 365px;" class="combobox text2" onchange="OptionsChangeVehicle()">
				<option value="0"><?php echo dic_("Tracking.SelectOption")?></option>
				<option value="1"><?php echo dic_("Tracking.OneVehicle")?></option>
				<?php
				if (pg_num_rows(query($strOrg)) > 0) { ?>
					<option value="2"><?php echo dic_("Tracking.VehInOrgU")?></option> <?php }

				if ((dlookup("select count(*) from vehicles where clientID=" . $clientID . " and active='1'")) == pg_num_rows(query($strCom))) { ?>
					<option value="3"><?php echo dic_("Tracking.AllVehCompany") ?></option>
				<?php }	?>
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
				$dsPP2 = query($strOrg);

				$brojRedovi = pg_num_rows($dsPP2);
				while($row2 = pg_fetch_array($dsPP2)) {
				?>
				<option value="<?php echo $row2["id"] ?>"><?php if ($brojRedovi>0){ echo $row2["name"]?>&nbsp;(<?php echo $row2["code"]?><?php }else{ echo dic_("Settings.NoOrgU");}?>)</option>
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

		<!-- *************************** SMS VIA EMAIL ******************************************* -->

		<tr class="SMSemail" style="display:none">
			<td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic_("Tracking.SMSNumber")?></td>
			<td width = "75%" style="font-weight:bold" class ="text2"><input id = "smsviaemail" class="textboxcalender corner5 text5" type="text" style = "width:365px"></input></td>
		</tr>
		<tr class="SMSemail" style="display:none;">
			<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Tracking.MobileOperator")?>:</td>
			<td width = "75%" style="font-weight:bold" class ="text2">
				<div class="ui-widget" style="height: 25px; width: 100%">
				<select id="mobilenoperator" style="width: 365px;" class="combobox text2">
					<option value="0" selected="selected"><?php echo dic_("Settings.MobileOperator")?></option>
					<?php

					while($operator = pg_fetch_array($qGetMobileOperators)) {
					?>
					<option value="<?php echo $operator["id"] ?>"><?php echo $operator["name"]; ?></option>
					<?
					}
					?>
				</select>
				</div>
			</td>
		</tr>

		<!-- *************************** SMS VIA EMAIL ******************************************* -->
		<tr>
			<td width = "25%" valign="middle" style="font-weight:bold" class ="text2" align="left"><?php dic("Settings.Sound")?></td>
			<td width = "75%" valign="middle">
			<select id = "zvukot" style="font-size: 11px; position: relative; top: 0px ;visibility: visible; float:left" class="combobox text2">
			<option value = "1"><?php dic("Settings.Sound")?> 1</option>

			<option value = "2"><?php dic("Settings.Sound")?> 2</option>
			<option value = "3"><?php dic("Settings.Sound")?> 3</option>
			<option value = "4"><?php dic("Settings.Sound")?> 4</option>
			<option value = "5"><?php dic("Settings.Sound")?> 5</option>

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

function email_validate( value) {
    var emailovi = value.split(",");
    var izlez;
    emailovi.forEach(function(mejl) {
        var filter = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
        izlez = filter.test(mejl.trim());
    });
    return izlez;
}

function validate_phone( value ) {
	var US_format = new RegExp(/^\d{10}$/);
	return US_format.test(value);
}
// koga nasokata e zapis vo baza (klient - > server)
function convertMetric( edinica, vrednost) {
	return (edinica.toLowerCase() == 'mi') ?  (Number(vrednost) * 1.60934) : Number(vrednost);
}

function isNum( obj ) {
    return !jQuery.isArray( obj ) && (obj - parseFloat( obj ) + 1) >= 0;
}

function isNormalInteger(str) {
    var n = ~~Number(str);
    return String(n) === str && n > 0;
}

function isChecked( obj ) {		// samo za id
	return ($('#'+obj).is(':checked'));
}

function hideVeh(id) {
	$('#'+ id + " td:nth-child(3) div").slideToggle(280);
}

function get_operator_id (obj_arr, mobilenoperator) {
	for(i=0; i<obj_arr.length; ++i){
		if(obj_arr[i].id == mobilenoperator) {
			return i;
		}
	}
}

function get_operator_email (obj_arr, operatoremail) {
	for(i=0; i<obj_arr.length; ++i){
		if(obj_arr[i].email === operatoremail) {
			return i;
		}
	}
}

function timed_refresh (delay) {
	setTimeout(function(){
	   	window.location.reload(1);
	}, delay);
}

function smschange() {
	console.log("change happened!");
	if(smsviaemail.value == "") $("#mobilenoperator option[value='0']").attr('selected','selected');
}
// --------------- MAIN FUNCTION -------------------------

function storeAlerts(isEdit, _id) {

	if (typeof(isEdit)==='undefined') isEdit = false;	// default value for addAlert
   	if (typeof(_id)==='undefined') _id = 0;

   	if(isEdit){

		for(i=0; i<row_array.length; ++i){
			if(row_array[i].data.id == Number(_id)) {
				objID = i;
			}
		}
   		console.log(row_array[objID].data);
   	}

    $('#dialog-alerts').dialog({
        modal: true,
        width: 590,
        height: 525,
        resizable: false,
        title: (isEdit) ? dic("Settings.ChangeAlert",lang) : dic("Settings.AddAlerts",lang) ,
        open: function() {

        	var win = $(window);
            $(this).parent().css({   position:'absolute',
            	left: (win.width() - $(this).parent().outerWidth())/2,
            	top: (win.height() - $(this).parent().outerHeight())/2
            });

        	allowedSMSviaEmail = Number('<?php echo $allowedSMSvEmail; ?>');
   			if(allowedSMSviaEmail == 1) $('.SMSemail').show();

    	    $(function () {
		        $("#combobox").combobox();
		        if(isEdit) {
		        	$("#combobox").combobox('setval',$('#combobox option[value="'+ row_array[objID].data.poiid +'"]').text());
		        	$("select#combobox").val(row_array[objID].data.poiid);
		    	}
		        $("#toggle").click(function () {
		            $("#combobox").toggle();
		        });
		    });
		    $(function () {
		        $("#comboboxVlez").combobox();
		        if(isEdit) {
		        	$("#comboboxVlez").combobox('setval',$('#comboboxVlez option[value="'+ row_array[objID].data.poiid +'"]').text());
		        	$("select#comboboxVlez").val(row_array[objID].data.poiid);
		        }
		        $("#toggle").click(function () {
		            $("#comboboxVlez").toggle();
		        });
		    });
		    $(function () {
		        $("#comboboxIzlez").combobox();
		        if(isEdit) {
		        	$("#comboboxIzlez").combobox('setval',$('#comboboxIzlez option[value="'+ row_array[objID].data.poiid +'"]').text());
		        	$("select#comboboxIzlez").val(row_array[objID].data.poiid);
		        }
		        $("#toggle").click(function () {
		            $("#comboboxIzlez").toggle();
		        });
		    });
  			if(isEdit) {

  				$("#TipNaAlarm option[value="+row_array[objID].data.alarmtypeid+"]").attr('selected','selected');
		    	$('#TipNaAlarm').attr('disabled', 'disabled');
		    	OptionsChangeAlarmType();
		    	$('#brzinata').val(Math.round(row_array[objID].data.speed * Number('<?php echo $value ?>')));
		    	$('#vreme').val(row_array[objID].data.timeofpoi);
		    	if(row_array[objID].data.uniqid == null) {	// edno vozilo
		    		$("#vozila option[value='1']").attr('selected','selected');
		    	} else {
		    		if (row_array[objID].data.settings == null || row_array[objID].data.settings == "") {
		    			$("#vozila option[value='3']").attr('selected','selected');
		    		} else {
		    			$("#vozila option[value='2']").attr('selected','selected');
		    		}
		    	}

		    	OptionsChangeVehicle();

		    	$("#voziloOdbrano option[value="+row_array[objID].data.vid+"]").attr('selected','selected');
		    	$("#oEdinica option[value="+row_array[objID].data.settings+"]").attr('selected','selected');

		    	if(row_array[objID].data.remindme !== null){

		    		if(row_array[objID].data.remindme.indexOf(";") != -1){ // ako ima ";"
		    			var gservice = row_array[objID].data.remindme.split(";");
		    			$("#fmvalueDays").val(gservice[0].split(" ")[0]);
		    			var fmvaluemetric = gservice[1].trim().split(" ")[0];
		    			$('#fmvalueKm').val(Math.round(fmvaluemetric * Number('<?php echo $value ?>')));
		    			$('#remindDays').attr('checked',true);
		    			$('#remindKm').attr('checked',true);
		    		} else {
		    			if(row_array[objID].data.remindme.indexOf("days") != -1) { // ima samo denovi
		    				$("#fmvalueDays").val(row_array[objID].data.remindme.split(" ")[0]);
		    				$('#remindDays').attr('checked',true);
		    			}
		    			if(row_array[objID].data.remindme.indexOf("Km") != -1) { // ima samo Km
		    				var fmvaluemetric2 = row_array[objID].data.remindme.split(" ")[0];
		    				$('#fmvalueKm').val(Math.round(fmvaluemetric2 * Number('<?php echo $value ?>')));
							$('#remindKm').attr('checked',true);
							$('#remindDays').attr('checked',false);
							$("#fmvalueDays").val("");
		    			}
		    		}
		    	}

		    	$('#emails').val(row_array[objID].data.emails);

		    	// ako e dozvolena ovaa opcija
		    	if(allowedSMSviaEmail == 1 && row_array[objID].data.smsviaemail != null && row_array[objID].data.smsviaemail != "") {
		    		var getSMS = row_array[objID].data.smsviaemail.split('@');
		    		$('#smsviaemail').val(getSMS[0]);
		    		$("#mobilenoperator option[value='"+getMO[get_operator_email(getMO,getSMS[1])].id+"']").attr('selected','selected');
		    	}

		    	$('#GFcheck' + row_array[objID].data.available).attr('checked',true);
		    	$('input:radio[name=radio]').button('refresh');
  			}

  			else {	// ako ne e edit (dodavanje)
  				ClearDialog();	// se povukuva za da se iscisti od prethodno ako ne e povikano window.reload
  				OptionsChangeVehicle();
  			}
        },
        close: function() {
        	$("#combobox").combobox('destroy');
        	$("#comboboxVlez").combobox('destroy');
        	$("#comboboxIzlez").combobox('destroy');
        	ClearDialog();
        	console.log("destroyed...");
        },
        buttons: [{
            text: (isEdit) ? dic('Fm.Mod', lang) : dic('Settings.Add', lang),
            click: function(data) {

            	smschange();
                var tipNaAlarm = $('#TipNaAlarm').val();
                var email = $.map($('#emails').val().split(","), $.trim);	//clear the whitespaces in between
                var sms = '';
                if (Number('<?php echo $clienttypeid ?>') == 6) sms = $('#sms').val();
                var zvukot = $('#zvukot').val();
                var ImeNaTocka = $('#combobox').val();
                var ImeNaTockaProverka = document.getElementById('combobox').selectedIndex;
                var ImeNaZonaIzlez = $('#comboboxIzlez').val();
                var ImeNaZonaIzlezProverka = document.getElementById('comboboxIzlez').selectedIndex;
                var ImeNaZonaVlez = $('#comboboxVlez').val();
                var ImeNaZonaVlezProverka = document.getElementById('comboboxVlez').selectedIndex;
                var orgEdinica = '';
                if(document.getElementById('vozila').selectedIndex == 2) { orgEdinica=$('#oEdinica').val(); } else orgEdinica=null;
                var odbraniVozila = $("#vozila option:selected").val(); // mozni vrednosti 1,2,3
                var NadminataBrzina = convertMetric('<?php echo $metric ?>', $('#brzinata').val());
                var vreme = $('#vreme').val();
                var alarmSelect = document.getElementById('TipNaAlarm').selectedIndex;
                var voziloOdbrano = $('#voziloOdbrano').val();
                var dostapno = getCheckedRadio('radio');
                var valueDays = $('#fmvalueDays').val();
                var valueKm = convertMetric('<?php echo $metric ?>', $('#fmvalueKm').val());
                var mobilenoperator = (allowedSMSviaEmail == 1) ? $('#mobilenoperator').val(): "";
                var smsviaemail = (allowedSMSviaEmail == 1) ? $('#smsviaemail').val(): "";

                //------------------------------------------------------------------------//
                ////////////////////////////////////////////////////////////////////////////


                var validation = [];

                if(email === '') validation.push("Settings.AlertsEmailHaveTo");
                if(email.length > 0 && !email_validate($('#emails').val())) validation.push("uncorrEmail");

                if(allowedSMSviaEmail == 1 && smsviaemail !== "") {
                	if(!validate_phone(smsviaemail)) validation.push("Settings.InvalidPhoneFormat");
                	if(mobilenoperator == 0) validation.push("Settings.MobileOperator");
                }

	 			if(Number(odbraniVozila) === 0) validation.push("Settings.SelectAlert1");

	 			if(tipNaAlarm == 7 && !isNormalInteger(Math.round(NadminataBrzina).toString())){
	 				validation.push("Settings.InsertSpeedOver");
	 			}
	 			if(tipNaAlarm == 8 && ImeNaZonaVlezProverka == ""){
	 				validation.push("Settings.SelectEnterGeoF");
	 			}
	 			if(tipNaAlarm === 9 && ImeNaZonaIzlezProverka == ""){
	 				validation.push("Settings.SelectExitGeoF");
				}
	 			if(tipNaAlarm == 10){
	 				if (ImeNaTockaProverka == "") validation.push("Settings.SelectPOI2");
	 				else {
		 				if(!isNum(vreme)) validation.push("Settings.InsertRetTime");
	 				}
	 			}
	 			if((tipNaAlarm == 17 || tipNaAlarm == 20) && !isNormalInteger(valueDays)){
	 				validation.push("Settings.InsertValidTime");
	 			}

	 			if(tipNaAlarm == 18) {
	 				if(isChecked("remindKm") === false && isChecked("remindDays") === false) validation.push("Settings.RemindMeMustOne");
	 				if(isChecked("remindDays") === true && !isNormalInteger(Math.round(valueDays).toString())) validation.push("Settings.InsertValidTime");
	 				if(isChecked("remindKm") === true && !isNormalInteger(Math.round(valueKm).toString())) validation.push("Settings.InsertValidLength");
	 			}

	 			// if (sms !== "") {

     //                $('#div-tip-praznik').dialog({
     //                    modal: true,
     //                    width: 300,
     //                    height: 230,
     //                    resizable: false,
     //                    title : dic("Settings.ConfSMS", lang),
     //                    buttons: [{
     //                        text: dic("Reports.Confirm"),
     //                        click: function() {
     //                            pass = encodeURIComponent($('#dodTipPraznik').val());
     //                            tipPraznikID = document.getElementById("dodTipPraznik");
     //                            if (pass === "") {
     //                                msgboxPetar(dic("Settings.InsertPass", lang));
     //                                tipPraznikID.focus();
     //                            } else {
     //                                $.ajax({
     //                                    url: "checkPassword2.php?pass=" + pass + "&l=" + lang,
     //                                    context: document.body,
     //                                    success: function(data) {
     //                                        if (data == 1) {
     //                                            msgboxPetar(dic("Settings.VaildPassSucAlert", lang));
     //                                        } else {
     //                                            msgboxPetar(dic("Settings.Incorrectpass", lang));
     //                                            exit;
     //                                        }
     //                                    }
     //                                });
     //                            }
     //                        }
     //                    }, {
     //                        text: dic("Fm.Cancel", lang),
     //                        click: function() {
     //                            $(this).dialog("close");
     //                        }
     //                    }]
     //                });
     //            }

	 			//------------------------------[END] validation ------------------------------------//
                ///////////////////////////////////////////////////////////////////////////////////////

	 			console.log(validation);
	 			console.log(validation.length);

				var remindme = '';
			  	if (tipNaAlarm == 17 || tipNaAlarm == 18 || tipNaAlarm == 20) {
			  		var fmvalueDays = "";

			  		if (tipNaAlarm == 18) {
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
				  		if (tipNaAlarm == 18) {
				  			if ($('#remindKm').is(':checked')) {
				  				if (fmvalueDays != "")
				  					fmvalueKm += "; " + Math.round($('#fmvalueKm').val()/ Number('<?php echo $value?>')) + " Km";
				  				else
				  					fmvalueKm = Math.round($('#fmvalueKm').val()/ Number('<?php echo $value?>')) + " Km";
				  			}
				  		} else {
				  			if ($('#fmvalueKm').val() != "") {
					  			if (fmvalueKm != "")
					  				fmvalueKm += "; " + Math.round($('#fmvalueKm').val()/ Number('<?php echo $value?>')) + " Km";
					  			else
					  				fmvalueKm = Math.round($('#fmvalueKm').val()/ Number('<?php echo $value?>')) + " Km";
					  		}
				  		}
				  	}
			  		remindme = fmvalueDays + fmvalueKm;
			  	}

	 			// get and construct the sms via email format
	 			var sendSMS = '';
	 			if(validation.length === 0 && allowedSMSviaEmail == 1 && Number(mobilenoperator.value) != 0 && smsviaemail != "") sendSMS = smsviaemail + "@" + getMO[get_operator_id(getMO,Number(mobilenoperator))].email;
				console.log("SEND SMS: " + sendSMS);

			  	var qurl = "storeAlert.php?tipNaAlarm=" + tipNaAlarm + "&email=" + email + "&sms=" + sms + "&zvukot=" + zvukot + "&ImeNaTocka=" + ImeNaTocka + "&ImeNaZonaIzlez=" + ImeNaZonaIzlez + "&ImeNaZonaVlez=" + ImeNaZonaVlez + "&NadminataBrzina=" + NadminataBrzina + "&vreme=" + vreme + "&dostapno=" + dostapno + "&orgEdinica=" + orgEdinica + "&odbraniVozila=" + odbraniVozila + "&voziloOdbrano=" + voziloOdbrano + "&remindme=" + remindme + "&sendviaEmail=" + sendSMS;

			  	if(isEdit) {
			  		var uniqid = row_array[objID].data.uniqid;
			  		qurl += "&isEdit=true&uniqid=" + uniqid + "&id=" + _id;
			  	}

	 			if (validation.length === 0) {


			  		console.log(qurl);
		 			$.ajax({
		                    url: qurl,
		                    context: document.body,
		                    success: function(data) {
		                    	console.log(data);
		                    	var t;
		                    	if (isEdit) t = dic("Admin.SuccUpdate", lang);
		                    	else t = dic("Settings.SuccAdd", lang);	
		                    	t = t.substr(0,1).toUpperCase() + t.substr(1);

		                    	msgboxPetar(t);
		                        
		                        timed_refresh(1600);
		                    }
		                });
	 			} else {
	 				msgboxPetar(dic(validation[0],lang));
	 			}

             }
        }, {
            text: dic('cancel', lang),
            click: function() {
                $(this).dialog("close");
            }
        }
        ]
    });
}

function ClearDialog() {
	$("#TipNaAlarm option[value='1']").attr('selected','selected');
	OptionsChangeAlarmType();
	$('#TipNaAlarm').attr('disabled', false);
	$('#vozila option').attr('selected',false);
	$("#voziloOdbrano").val($("#voziloOdbrano option:first").val());
	$('#oEdinica option').attr('selected',false);
	$('#vreme').val("");
	$("#fmvalueDays").val("5");
	$("#fmvalueKm").val("");
	$('#emails').val("");
	$('#remindKm').attr('checked',false);
	$('#brzinata').val("");

	$("#smsviaemail").val("");
	$("#mobilenoperator option[value='0']").attr('selected','selected');

	$('#GFcheck1').attr('checked',true);
	$('input:radio[name=radio]').button('refresh');
}

function OptionsChangeAlarmType() {

	  	var tipNaAlarm = $('#TipNaAlarm').val();
		console.log("tip na alarm: " + tipNaAlarm);

		document.getElementById('noteFmAlarm').style.display = "none";
   		document.getElementById('textFmAlarm').innerHTML = "";

	    if (tipNaAlarm == 10) {
	        document.getElementById('toi-div').style.display = '';
	        document.getElementById('toi-div-2').style.display = '';
	    }
	    if (tipNaAlarm == 9) {
	        document.getElementById('zi-div').style.display = '';
	    }
	    if (tipNaAlarm == 8) {
	        document.getElementById('zv-div').style.display = '';
	    }
	    if (tipNaAlarm == 7)  {
	        document.getElementById('nadminuvanjeBrzina').style.display = '';
	    }
		if (tipNaAlarm == 17 || tipNaAlarm == 18 || tipNaAlarm == 20) {
	        document.getElementById('fm').style.display = '';
	        document.getElementById('rmdD').style.display = '';

	        if (tipNaAlarm == 18) {
	        	document.getElementById('rmdKm').style.display = '';
	        	document.getElementById('remindDays').style.display = '';
	        } else {
	        	document.getElementById('rmdKm').style.display = 'none';
	        	document.getElementById('remindDays').style.display = 'none';
	        }
	        document.getElementById('noteFmAlarm').style.display="";
	        if (tipNaAlarm == 17) {
	       		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo1", lang);
	        }
	        if (tipNaAlarm == 18) {
	       		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo2", lang);
	        }
	        if (tipNaAlarm == 20) {
	       		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo3", lang);
	        }
   		}

	    if(tipNaAlarm != 10) {
	        document.getElementById('toi-div').style.display = 'none';
	        document.getElementById('toi-div-2').style.display = 'none';
	  	}
	  	if(tipNaAlarm != 09) {
	        document.getElementById('zi-div').style.display = 'none';
		}
		if(tipNaAlarm != 08) {
	        document.getElementById('zv-div').style.display = 'none';
		}
		if(tipNaAlarm != 07) {
	        document.getElementById('nadminuvanjeBrzina').style.display = 'none';
		}
		if(tipNaAlarm != 17 && tipNaAlarm != 18 && tipNaAlarm != 20) {
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
	                    // msgboxPetar(dic("Settings.SuccDeleted",lang));
	                    $('#' + id).fadeOut(400, function(){
	                    	$(this).remove();
	                    	});
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

$(document).ready(function(){

	$('.del-btn').button({ icons: { primary: "ui-icon-trash"} });
	$('.edit-btn').button({ icons: { primary: "ui-icon-pencil"} });

   	$('#add5').button({ icons: { primary: "ui-icon-plusthick"} });
   	$('#play').button({ icons: { primary: "ui-icon-play"} });
    $('#pause').button({ icons: { primary: "ui-icon-pause"} });
    $('#poglasno').button({ icons: { primary: "ui-icon-plus"} });
    $('#potivko').button({ icons: { primary: "ui-icon-minus"} });
    $('#gfAvail').buttonset();

    $('#main_table tr td:nth-child(3) div').hide();

   	// setDates();
    top.HideWait();

});

</script>

</html>

<?php closedb(); ?>
