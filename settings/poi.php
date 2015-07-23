<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	opendb();
	$uid = session("user_id");
	$cid = session("client_id");

	$roleid = dlookup("select roleid from users where id=".$uid);

	$Allow = getPriv("groupspoi", $uid);
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
	addlog(41);

	function pp($a) {
    echo '<pre>'.print_r($a,1).'</pre>';
	}

	function comp($color) {
		preg_match("/#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})/i", $color, $out);
		$ilum = 1 - ( 0.299 * hexdec($out[1]) + 0.587 * hexdec($out[2]) + 0.114 * hexdec($out[3]))/255;
		return ($ilum >= 0.5) ? '#ffffff' : '#000000';
	}

?>

<html>

<head>

	<script type="application/javascript"> lang = '<?php echo $cLang?>'; </script>

	<link rel="stylesheet" type="text/css" href="../style.css">

	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
	<!-- <script type="text/javascript" src="../js/jquery.js"></script> -->

	<script type="text/javascript" src="../js/jquery-1.5.2.min.js"></script>

	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	<script type="text/javascript" src="../tracking/live.js"></script>
	<script type="text/javascript" src="../tracking/live1.js"></script>
	<script src="../js/jquery-ui.js"></script>
	<link rel="stylesheet" href="../js/mlColorPicker.css" type="text/css" media="screen" charset="utf-8" />
	<script type="text/javascript" src="../js/mlColorPicker.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<!-- >>>>>>>>>>>> added >>>>>>>>>>>>>>>>>>>>-->
	<script src="../js/chroma.min.js"></script>
	<script	src="./js/poi-tools.js"></script>

	<link rel="stylesheet" href="../tracking/pinIcons.css">

	<style type="text/css">

		body {
		    /*height: 100%;*/
		    /*ako se trgne 100%, ne raboti goToByScroll*/
		    overflow: auto;
		    -webkit-overflow-scrolling: touch;
		}

		.ui-button { margin-left: -1px; }
		.ui-button-icon-only .ui-button-text { padding: 0.35em; }
		.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }

		.toi-group-title table {
			width: 100%;
			border: 0;
			margin-top: 30px;
		}
		.toi-group-title td {
			background-color: #e5e3e3;
		}

		.toi-group-title .col-titles td {
			height: 22;
			text-align: center;
		}

		.col-titles td {
			background-color: #f4f3f3;
		}

		.toi-row table {
			width: 100%;
			border: 0;
		}
		.align-center {
		    margin-left: auto;
		    margin-right: auto;
		    width: 95%;
		}
		.la {
			text-align: left !important;
		}
		.ca {
			text-align: center !important;
		}
		.td-row {
			font-weight:bold;
			background-color:#;
			border:1px dotted #2f5185;
		}
		.c-or {
			color: #ff6633;
		}
		.td-row-poi {
			height: 30px;
			text-align: center;
			background-color:#fff;
			border:1px dotted #B8B8B8;
		}
		.btn-def {
			height:22px;
			width:30px;
		}

		.POI_data, .POI_data_new {
			overflow-x: hidden; /* potrebno za scroll izmestuvanjeto */
		}

		#input_container { position:relative; padding:0; margin:0; background:#ddd; }
		#search_input { height:20px; margin:0; padding-left: 30px; }
		#search_img { position:relative; top:5px; left:25px; width:17px; height:17px; margin-left: -20px; }  /* za clear button */

	</style>

</head>
<body>

<?php

	$bannedPOI = dlookup("select bannedpoi from users where id = " . $uid);

	if((int)$roleid == 2) {
		$dsPoigroups = query("select * from pointsofinterestgroups where clientid = " . $cid . " order by name");
	} else {
		$dsPoigroups = query("select * from pointsofinterestgroups where id in (select distinct groupid from pointsofinterest where clientid=". $cid ."
								and ((available=3) or (available = 2 and (select organisationid from users where id=". $uid .") =
								(select organisationid from users where id=userid) and (select organisationid from users where id=userid) <> 0)
								or (available=1 and userid=". $uid ."))) order by name");
	}

	$search = query("select count(*) from pointsofinterest where clientid = " . $cid);

if($search == 0 && pg_num_rows($dsPoigroups) == 0){ ?>

	<br><br>

	<div id="noData" style="padding-left:40px; font-size:30px; font-style:italic; padding-bottom:40px" class="text4">
		<?php dic("Reports.NoData1")?>
	</div>

<?php }
else
{ ?>

<!-- *************************** HEADER *********************** -->
<div class="align-center" style="padding-top:30px;">
	<span class="textTitle"><?php echo dic("Settings.Pois")?></span>
</div>

<div class="align-center">
	<table width="100%" style="margin-top:20px;">

		<tr class="text2">
			<td width = "70%" align = "left" valign = "middle">
				<button id="kopce" onclick="AddGroup(1)" style="margin-left:1px"><?php echo dic("Reports.AddGroup")?></button>&nbsp;&nbsp;&nbsp;
			</td>
			<td width ="30%" align = "right" valign="middle">
				<div class="input_container">
					<!--button id="clear-input" onclick="clear_input()">Clear</button-->
					<img id="search_img" src="../images/search_find.png"></img>
					<input id="search_input" name="filter" type="text" placeholder="<?php echo dic ("search")?>" size=22 style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:200px;"/>&nbsp;
				</div>
			</td>
		</tr>

		<tr style="height:5px;" class="text2"><td colspan="2"></td></tr>

		<tr id="trGrupno" style="height: 33px; display: none" class="text2">
			<td colspan="2" width = "100%" align = "left" valign = "middle">
				<button id="brisiGrupno" onclick="brisiGrupaMarkeri()" style="margin-left:1px"><?php echo dic("Settings.DeleteMultiplePOI")?></button>&nbsp;&nbsp;&nbsp;
				<button id="prefrliGrupno" onclick="prefrliGrupaMarkeri()" style="margin-left:1px"><?php echo dic("Settings.TransferMultiplePOI")?></button>&nbsp;&nbsp;&nbsp;
				<button id="neaktivniGrupno" onclick="neaktivniGrupaMarkeri()" style="margin-left:1px"><?php echo dic("Settings.DeactivateMultiplePOI")?></button>&nbsp;&nbsp;&nbsp;
			</td>
		</tr>
	</table>
</div>

<!-- ************************************ NEGRUPIRANI TOCKI TITLE ****************************************** -->
<?php

	if((int)$roleid == 2) {
		$numPointsU = dlookup("select count(*) from pointsofinterest where clientid=" . $cid . "and active = '1' and groupid=1");
	} else {
		$numPointsU = dlookup("select count(*) from pointsofinterest where clientid=". $cid ." and active = '1' and groupid=1 and ((available=3) or (available = 2 and (select organisationid from users where id=". $uid .") =
						(select organisationid from users where id=userid) and (select organisationid from users where id=userid) <> 0)	or (available=1 and userid=". $uid .")) ");
	}

if($numPointsU != 0) { ?>

<div class="align-center toi-group-title">
<table id="POI_group1" class="title-group" style="border-spacing:2px">
		<tr>
			<td align = "left" colspan="8" valign = "middle" height="40px" width = "100%" class="text2" style="font-weight:bold; font-size:14px;  padding-left:7px; cursor: pointer; font-weight:bold;" id="slider_1" onclick="show_group(1)">
				<span class="expand-icon" style="font-size:18px">▶</span>
				<img src="../images/pin-1.png" style="height: 18px; position: relative; width: 18px; left:5px; top:2px">
				<span style="position:relative; left: 10px;"><?php echo dic("Settings.NotGroupedItems")?>
				<span class="num-of-poi" style="position:relative;">(<?php echo $numPointsU ?>)</span>
			</td>
		</tr>
</table>
<table id="POI_group_header1" class="col-titles" style="display:none; margin-top:0px">
	<!-- [change] -->
	<tr>
		<td width="4%"  class="text2 td-row ca"><?php dic("Fm.Rbr")?></td>
		<td width="38%" valign ="middle" class="text2 la td-row" style="padding-left:8px">
			<span style="padding-left: 75px;"><?php echo dic("Routes.Name")?></span><br>
			<span style="padding-left: 75px;">(<?php dic("Routes.CreatedBy")?>)</span>&nbsp;&nbsp;
		</td>
		<td width="13%" class="text2 td-row ca" ><?php dic("Settings.TypeOfPoi")?><br> (<?php dic("Tracking.Radius")?>)</td>
		<td width="13%" class="text2 td-row ca" ><?php dic("Reports.AvailableFor")?></td>
		<td width="8%"  class="text2 td-row c-or ca" ><?php dic("Settings.TransferPOI")?></td>
		<td width="8%"  class="text2 td-row c-or ca" ><?php dic("Routes.Overview")?></td>
		<td width="8%"  class="text2 td-row c-or ca" ><?php dic("Routes.Mod")?></td>
		<td width="8%"  class="text2 td-row c-or ca" ><?php dic("Fm.Delete")?></td>
	</tr>
</table>

</div>  <!-- [end]. toi-group-title -->

<?php } ?>  <!-- [end]. dali ima negrupirani tocki -->

<div id="POI_data_1" class="POI_data align-center toi-row">
<table>
	<tbody>
	<!-- FETCH NEW DATA -->
	</tbody>
</table>
</div>

<script type="text/javascript">
	allGroups = [1]; // se zacuvuvaat site id-a na grupite
	numOfPoints = [Number('<?php echo $numPointsU ?>')];  // broj na tocki po grupa
</script>

<!-- ******************************************************************************************************* -->

<?php

while ($poiRow = pg_fetch_assoc($dsPoigroups)) {

if($poiRow['id'] != 1) {  // za da gi otfrli negrupiranite

	if((int)$roleid == 2) {
		$numTocki = dlookup("select count(*) from pointsofinterest where clientid=" . $cid . " and active = '1'and groupid=" . $poiRow['id']);
	} else {
		$numTocki = dlookup("select count(*) from pointsofinterest where clientid=". $cid ." and active = '1' and groupid = ". $poiRow['id'] ." and ((available=3) or (available = 2 and (select organisationid from users where id=". $uid .") =
						(select organisationid from users where id=userid) and (select organisationid from users where id=userid) <> 0)	or (available=1 and userid=". $uid .")) ");
	}

?>

<!-- ************************************** GROUP TITLE ***************************************************** -->
<div class="align-center toi-group-title grouped-title">
<table id="POI_group<?php echo $poiRow['id']?>" class="title-group" style="">
	<tr>
		<td align = "left" colspan="8" valign = "middle" height="40px" width = "76%" class="text2" style="font-weight:bold; font-size:14px;  padding-left:7px; cursor: pointer; font-weight:bold;" id="slider_<?php echo $poiRow['id']?>" onclick="show_group(<?php echo $poiRow['id']?>)">
			<span class="expand-icon" style="float: left; font-size:18px">▶</span>&nbsp;
			<span class="iconpin20 icon-poi-<?= $poiRow["image"]?>" style="padding-left: 5px; padding-right: 0px; text-align: center; margin-top: -2px; width: 25px; position: relative; color: <?= substr($poiRow["fillcolor"], 1, strlen($poiRow["fillcolor"]))?>; text-shadow: 0px 0px 1px black;"></span>
			<!--div  class="poi-box" style="margin-left: 10px; border-radius: 5px; width: 18px; height: 18px; float: left; background-color:<?php echo $poiRow["fillcolor"]?>;"></div-->
			<span class="ime-na-grupa" style="position:relative; left: 3px;"><?php echo $poiRow['name']?></span>
			<span class="num-of-poi" style="position:relative; margin-left: 10px">(<?php echo $numTocki ?>)</span>
		</td>

		<td align = "center" valign = "middle" height="40px" class="text2" width = "8%" style="font-weight:bold; font-size:14px; font-weight:bold;" >
			<button id="btnGroupMap<?php echo $poiRow['id']?>" class="btn-search-ui" onclick="OpenMapAlarm3('<?php echo $poiRow["id"]?>','<?php echo $cLang?>')" style="height:22px; width:30px"></button>
		</td>
		<td align = "center" valign = "middle" height="40px" class="text2" width = "8%" style="font-weight:bold; font-size:14px; font-weight:bold;" >
			<button id="btnEdit<?php echo $poiRow['id']?>" class="btn-penci-ui" onclick="AddGroup('<?php echo $poiRow["id"]?>','<?php echo $cLang?>')" style="height:22px; width:30px"></button>
		</td>
		<td align = "center" valign = "middle" height="40px" class="text2" width = "8%" style="font-weight:bold; font-size:14px; font-weight:bold;" >
			<button id="btnVehicles<?php echo $poiRow['id']?>" class="btn-trash-ui" onclick="DeleteGroup('<?php echo $poiRow["id"]?>','<?php echo $cLang?>', <?php echo $numTocki?>)" style="height:22px; width:30px"></button>
		</td>

	</tr>

</table>
<table id="POI_group_header<?php echo $poiRow['id']?>" class="col-titles" style="margin-top:0px; display:none">
	<!-- [change] -->
	<tr >
		<td width="4%"  class="text2 td-row ca"><?php dic("Fm.Rbr")?></td>
		<td width="38%" valign ="middle" class="text2 la td-row" style="padding-left:8px">
			<span style="padding-left: 75px;"><?php echo dic("Routes.Name")?></span><br>
			<span style="padding-left: 75px;">(<?php dic("Routes.CreatedBy")?>)</span>&nbsp;&nbsp;
		</td>
		<td width="13%" class="text2 td-row ca" ><?php dic("Settings.TypeOfPoi")?><br> (<?php dic("Tracking.Radius")?>)</td>
		<td width="13%" class="text2 td-row ca" ><?php dic("Reports.AvailableFor")?></td>
		<td width="8%"  class="text2 td-row c-or ca" ><?php dic("Settings.TransferPOI")?></td>
		<td width="8%"  class="text2 td-row c-or ca" ><?php dic("Routes.Overview")?></td>
		<td width="8%"  class="text2 td-row c-or ca" ><?php dic("Routes.Mod")?></td>
		<td width="8%"  class="text2 td-row c-or ca" ><?php dic("Fm.Delete")?></td>
	</tr>
</table>
</div>  <!-- [end]. toi-group-title -->

<div id="POI_data_<?php echo $poiRow['id'] ?>" class="POI_data align-center toi-row">
<table  cellspacing = "2" cellpadding = "2">
	<tbody>
		<!-- FETCH NEW DATA -->
	</tbody>
</table>
</div>

<script type="text/javascript">
	allGroups.push(Number('<?php echo $poiRow["id"]?>'));
	numOfPoints.push(Number('<?php echo $numTocki ?>'));
</script>

<!-- ******************************************************************************************************* -->
	<?php

		} // end if

	} // [end].while

	?>


<!-- ************************************ NEAKTIVNI TOCKI TITLE ******************************************** -->
<?php

	if((int)$roleid == 2) {
			$numPointsInactive = dlookup("select count(*) from pointsofinterest where clientid=" . $cid . "and active = '0'");
	} else {
		$numPointsInactive = dlookup("select count(*) from pointsofinterest where clientid=". $cid ." and active = '0' and ((available=3) or (available = 2 and (select organisationid from users where id=". $uid .") =
						(select organisationid from users where id=userid) and (select organisationid from users where id=userid) <> 0)	or (available=1 and userid=". $uid .")) ");
	}

	$dividerStyle="display:none; ";

	if($numPointsInactive != 0) $dividerStyle=" ";
?>

<div id="divider" style="<?php echo $dividerStyle ?>border-bottom:1px solid #bebebe; padding-top:30px;width: 95%;" class="align-center"></div>

<div class="align-center text2" >
	<button id = "AktivirajGrupno" onclick="aktivirajGrupaMarkeri()" style="display:none; height: 25px; margin-left:1px; margin-top: 30px;"><?php dic("Settings.ActivateMultiplePOI")?></button>
</div>

<?php

if($numPointsInactive != 0) { ?>

<div class="align-center toi-group-title">
<table id="POI_group_inactive" class="title-group" style="border-spacing:2px">
		<tr>
			<td align = "left" colspan="8" valign = "middle" height="40px" width = "100%" class="text2" style="font-weight:bold; font-size:14px;  padding-left:7px; cursor: pointer; font-weight:bold;" id="slider_inactive">
				<span class="expand-icon" style="font-size:18px">▼</span>
				<span style="position:relative; left: 10px;"><?php echo dic("Settings.InactivePOIHeader")?>
				<span class="num-of-poi" style="position:relative;">(<?php echo $numPointsInactive ?>)</span>
			</td>
		</tr>
</table>
<table id="POI_group_header_inactive" class="col-titles" style="margin-top:0px">
	<!-- [change] -->
	<tr>
		<td width="4%"  class="text2 td-row ca"><?php dic("Fm.Rbr")?></td>
		<td width="38%" valign ="middle" class="text2 la td-row" style="padding-left:8px">
			<span style="padding-left: 75px;"><?php echo dic("Routes.Name")?></span><br>
			<span style="padding-left: 75px;">(<?php dic("Routes.CreatedBy")?>)</span>&nbsp;&nbsp;
		</td>
		<td width="13%" class="text2 td-row ca" ><?php dic("Settings.TypeOfPoi")?><br> (<?php dic("Tracking.Radius")?>)</td>
		<td width="13%" class="text2 td-row ca" ><?php dic("Reports.AvailableFor")?></td>
		<td width="8%"  class="text2 td-row c-or ca" ><?php dic("Settings.TransferPOI")?></td>
		<td width="8%"  class="text2 td-row c-or ca" ><?php dic("Routes.Overview")?></td>
		<td width="8%"  class="text2 td-row c-or ca" ><?php dic("Routes.Mod")?></td>
		<td width="8%"  class="text2 td-row c-or ca" ><?php dic("Fm.Delete")?></td>
	</tr>
</table>

</div>  <!-- [end]. toi-group-title -->

<?php } ?>  <!-- [end]. dali ima negrupirani tocki -->

<div id="POI_data_inactive" class="align-center toi-row">
<table>
	<tbody>
	<!-- FETCH INACTIVE DATA -->
	</tbody>
</table>
</div>

<!-- ******************************************************************************************************* -->

<br><br><br><br><br>

<?php

}
// END. GLAVEN ELSE
?>

<!-- ************************************************* DIALOGS ***********************************************-->

<div id="dialog-map" style="display:none" title="<?php echo dic_("Reports.ViewOnMap")?>"></div>

<div id="div-add-color" style="display:none" title="<?php echo dic("Reports.AddGroup")?>">
<table>
	<tr>
    	<td class="text5" style="font-weight:bold"><?php echo dic("Tracking.GroupName")?></td>
        <td>
            <input id="GroupNameName"  type="text" class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>
       	</td>
    </tr>
    <tr>
        <td class="text5" style="font-weight:bold"><?php echo dic("Settings.ChooseColor")?></td>
        <td>
   			<div id="Color">
			<span id="Color1" onclick="changecolor()" style="cursor: pointer; float:left; border:1px solid black; width:30px; height:30px;margin:5px;"></span>
   			</div>
		</td>
	</tr>
</table>
</div>

<div id="div-edit-poi" style="display:none" title="<?php echo dic("Settings.SwitchPOI")?>">
	<p><?php echo dic("Settings.SelectPOI")?></p>
	<br>
	<p id="checked_group_edit" style="padding-left: 20px; font-size: 12px; color:#2f5185" ></p>
	<div align = "left">
		<label class="text5"> <?php echo dic("Tracking.Group")?>:&nbsp;</label>
		<select id="GroupNameList" class="combobox text2">
		<option id="1" value = "1"><?php echo dic("Settings.NotGroupedItems"); ?></option>
		<?php
			$qSPoiGroups =query("select * from pointsofinterestgroups where clientid = ". $cid ." order by name");
			while ($poiRow = pg_fetch_assoc($qSPoiGroups)) { ?>
				<option id="<?php echo $poiRow["id"] ?>" value = "<?php echo $poiRow["id"] ?>"><?php echo $poiRow["name"] ?></option>
		<?php } ?>
		</select>
	</div>
</div>

<div id="div-inactive-poi-multiple" style="display:none" title="<?php echo dic("Settings.Action")?>"><?php echo dic("Settings.MakeInactiveQuestion")?></div>
<div id="div-active-poi-multiple" style="display:none" title="<?php echo dic("Settings.Action")?>"><?php echo dic("Settings.ActivateMarkers")?></div>

<div id="div-edit-poi-multiple" style="display:none" title="<?php echo dic("Settings.SwitchPOI")?>"></div>

<div id="div-del-poi" style="display:none" title="<?php echo dic("Tracking.DeletePoi")?>"><?php echo dic("Reports.DeletePoi")?></div>
<div id="div-del-poi-multiple" style="display:none" title="<?php echo dic("Settings.Action")?>"><?php echo dic("Reports.DeletePoiMultiple")?></div>

 <div id="dialog-message" title="<?php echo dic("Reports.Message")?>" style="display:none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px"></div>
	</p>
</div>

<div id="div-Add-POI" style="display: none;">
<br/>
<table style="font-size: 11px; color: rgb(65, 65, 65); font-family: Arial,Helvetica,sans-serif; margin-left: 20px;" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="90px"><?php echo dic("Tracking.Latitude")?></td>
		<td>
			<input id="poiLat" type="text" class="textboxCalender corner5" style="width:120px"/>
		</td>
	</tr>
	<tr height="50px">
		<td width="90px"><?php echo dic("Tracking.Longitude")?></td>
		<td>
			<input id="poiLon" type="text" class="textboxCalender corner5" style="width:120px" />
		</td>
	</tr>
	<tr>
		<td width="90px"><?php echo dic("Tracking.Address")?></td>
		<td>
			<input id="poiAddress" type="text" class="textboxCalender corner5" style="width:269px; position: relative; float: left;" /><img id="loadingAddress" style="visibility: hidden; position: relative; float: left; top: 2px;" width="25px" src="../images/loadingP1.gif" border="0" align="absmiddle" />
		</td>
	</tr>
	<tr height="50px">
		<td width="90px"><?php echo dic("Tracking.NamePoi")?></td>
		<td>
			<input id="poiName" type="text" class="textboxCalender corner5" style="width:269px" />
		</td>
	</tr>
	<tr>
		<td width="90px"><?php echo dic("Tracking.AvailableFor")?></td>
		<td>
			<div id="poiAvail" class="corner5" style="font-size: 10px">
		        <input type="radio" id="APcheck1" name="radio" /><label for="APcheck1">Корисник</label>
		        <input type="radio" id="APcheck2" name="radio" /><label for="APcheck2">Организациона единица</label>
		        <input type="radio" id="APcheck3" name="radio" /><label for="APcheck3">Компанија</label>
		    </div>
		</td>
	</tr>
	<tr height="50px">
		<td width="90px"><?php echo dic("Tracking.Radius")?></td>
		<td>
			<dl id="poiRadius" class="dropdownRadius" style="width: 70px; margin: 0px;">
		        <dt><a href="#" title="" class="combobox1"><span><?php echo dic("Tracking.SelectRadius")?></span></a></dt>
		        <dd>
		            <ul>
		                <li><a id="RadiusID_50" href="#">50&nbsp;<?php echo dic("Tracking.Meters")?></a></li>
		                <li><a id="RadiusID_70" href="#">70&nbsp;<?php echo dic("Tracking.Meters")?></a></li>
		                <li><a id="RadiusID_100" href="#">100&nbsp;<?php echo dic("Tracking.Meters")?></a></li>
		                <li><a id="RadiusID_150" href="#">150&nbsp;<?php echo dic("Tracking.Meters")?></a></li>
		            </ul>
		        </dd>
		    </dl>
		</td>
	</tr>
	<tr>
		<td width="90px"><?php echo dic("Tracking.Group")?></td>
		<td>
			<dl id="poiGroup" class="dropdown" style="width: 150px; position: relative; float: left; padding: 0px; margin: 0px;">
		    <?php
				$dsUG = query("SELECT id, name, fillcolor, '0' image FROM pointsofinterestgroups WHERE id=1");
		        ?>
		        <dt><a href="#" title="" id="groupidTEst" class="combobox1"><span><?php echo dic("Tracking.SelectGroup")?></span></a></dt>
		        <dd>
		            <ul>
		                <li><a id="<?php echo pg_fetch_result($dsUG, 0, "id")?>" href="#">&nbsp;&nbsp;<?php echo dic("Settings.NotGroupedItems")?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 24px; height: 24px; background: url('http://gps.mk/new/pin/?color=<?php echo pg_fetch_result($dsUG, 0, "fillcolor")?>&type=<?php echo pg_fetch_result($dsUG, 0, "image")?>') no-repeat; position: relative; float: left;"></div></a></li>
		                <?php
							$dsGroup1 = query("select id, name, fillcolor, '0' image from pointsofinterestgroups where clientid=".session("client_id"));
		                    while($row1 = pg_fetch_array($dsGroup1))
		                    {
		                    	$_color = substr($row1["fillcolor"], 1, strlen($row1["fillcolor"]));
		                ?>
		                <li><a id="<?php echo $row1["id"]?>" href="#">&nbsp;&nbsp;<?php echo $row1["name"]?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 24px; height: 24px; background: url('http://gps.mk/new/pin/?color=<?php echo $_color?>&type=<?php echo $row1["image"]?>') no-repeat; position: relative; float: left;"></div></a></li>
		                <?php
		                    }
		                ?>
		            </ul>
		        </dd>
		    </dl>
			<input type="button" id="AddGroup" style="right: 20px; top: 1px; float:right" onclick="AddGroup('0')" value="+" />
		</td>
	</tr>
</table>
<br /><br />
<input type="hidden" id="idPoi" value="" />
<input type="hidden" id="numPoi" value="" />
<div align="right" style="display:block; width:380px; height: 30px; padding-top: 5px; position: relative; float: right; right: 15px;">
    <img id="loading" style="display: none; width: 140px; position: absolute; left: 10px; margin-top: 7px;" src="../images/loading_bar1.gif" alt="" />
	<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnCancelPOI" value="<?php echo dic("Tracking.Cancel")?>" onclick="$('#div-Add-POI').dialog('destroy');" />&nbsp;&nbsp;        
	<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnAddPOI" value="<?php echo dic("Tracking.Add")?>" onclick="ButtonAddEditPOIokClickPetar()" />
</div><br/><br/>
</div>

<div id="div-del-group" style="display:none" title="<?php echo dic("Settings.Action")?>">
<?php echo dic("Settings.QuestionForDeleteGroup1")?><br><br>
<?php echo dic("Settings.QuestionForDeleteGroup2")?><br><br>
<br>
<label class="text5"> <?php echo dic("Tracking.Group")?>:</label>
	<?php $find = query("SELECT id,name from pointsofinterestgroups where clientid = " . Session("client_id")." order by name");
	$n = 1;
	?>

	<select id="GroupName" class="combobox text2">
	<option id="<?php echo $n ?>" value = "<?php echo $n?>"><?php echo dic("Settings.NotGroupedItems")?> </option>
	<?php
	while($row3 = pg_fetch_array($find)){
	$data[] = ($row3);
	}
	foreach ($data as $row3)
	{
	?>
	<option id="<?php echo $row3["id"] ?>" value = "<?php echo $row3["id"] ?>"><?php echo $row3["name"] ?>
	</div>
	<?php
	}
	?>
	</option>
	</select>

	<div id="div-del-group1" style="display:none" title="<?php echo dic("Settings.Action")?>">
	   <?php echo dic("Settings.QuestionForDeleteGroup1")?><br><br>
	</div>
</div>
<div id="div-edit-user" style="display:none" title="<?php echo dic("Settings.ChangingGroup")?>">
<table>
        <tr>
        <td class="text5" style="font-weight:bold"><?php echo dic("Routes.Name")?></td>
        <td>
            <input id="NameGroup" type="text" value="" class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>
        </td>
	    </tr>
    	<tr>
            <td class="text5" style="font-weight:bold"><?php echo dic("Reports.Color")?></td>
        <td>
		<div id="colorPicker5">
			<span id="colorPicker4" style="cursor: pointer; float:left; border:1px solid black; width:20px; height:20px;margin:5px;"></span>
			<input id="clickAny1" type="text" class="textboxCalender corner5" onchange="changecolorSettings()" value="" style="width:120px" />
		</div>
        </td>
        </tr>
</table>
</div>

<div id="div-Add-Group" style="display: none;">
	<span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.GroupName")?></span><input id="GroupNameAdd" type="text" class="textboxCalender corner5" style="width:220px" /><br /><br />
    <span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.Color")?></span>
    <div id="colorPicker2">
		<span id="colorPicker1" style="cursor: pointer; float:left; border:1px solid black; width:20px; height:20px;margin:5px;"></span>
		<input id="clickAny" type="text" class="textboxCalender corner5" onchange="changecolor()" value="" style="width:120px; display: none;" />
		<br><br>
	</div>
    <img id="loadingIconsPOI" style="visibility: hidden; width: 140px; position: absolute; left: 125px; top: 180px;" src="../images/loading_bar1.gif" alt="" />
    <br><br>
    <span id="spanIconsPOI" style="display:block; width:90px; float:left; margin-left:20px; position: relative; top: 70px;"><?php echo dic("General.Icon")?></span>
    <table id="tblIconsPOI" border="0" style="width: 268px; text-align: center; position: relative; top: -10px; left: -15px;">
        <tr>
        	<td>
        		<span id="GroupIconImg0" class="iconpin icon-poi-0"></span>
    		</td>
    		<td>
        		<span id="GroupIconImg1" class="iconpin icon-poi-1"></span>
        	</td>
    		<td>
        		<span id="GroupIconImg2" class="iconpin icon-poi-2"></span>
    		</td>
    		<td>
        		<span id="GroupIconImg3" class="iconpin icon-poi-3"></span>
        	</td>
    		<td>
        		<span id="GroupIconImg4" class="iconpin icon-poi-4"></span>
        	</td>
        	<td>
        		<span id="GroupIconImg5" class="iconpin icon-poi-5"></span>
        	</td>
        	<td>
        		<span id="GroupIconImg6" class="iconpin icon-poi-6"></span>
        	</td>
        	<td>
        		<span id="GroupIconImg7" class="iconpin icon-poi-7"></span>
    		</td>
    	</tr>
    	<tr>
    		<td><input style="cursor: pointer;" id="GroupIcon0" name="GroupIcon" value="0" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon1" name="GroupIcon" value="1" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon2" name="GroupIcon" value="2" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon3" name="GroupIcon" value="3" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon4" name="GroupIcon" value="4" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon5" name="GroupIcon" value="5" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon6" name="GroupIcon" value="6" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon7" name="GroupIcon" value="7" type="radio" /></td>
    	</tr>
        <tr>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg8" class="iconpin icon-poi-8"></span>
        	</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg9" class="iconpin icon-poi-9"></span>
    		</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg10" class="iconpin icon-poi-10"></span>
        	</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg11" class="iconpin icon-poi-11"></span>
        	</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg12" class="iconpin icon-poi-12"></span>
        	</td>
        	<td style="padding-top: 20px">
        		<span id="GroupIconImg13" class="iconpin icon-poi-13"></span>
        	</td>
        	<td style="padding-top: 20px">
        		<span id="GroupIconImg14" class="iconpin icon-poi-14"></span>
        	</td>
        	<td style="padding-top: 20px">
        		<span id="GroupIconImg15" class="iconpin icon-poi-15"></span>
    		</td>
        </tr>
        <tr>
    		<td><input style="cursor: pointer;" id="GroupIcon8" name="GroupIcon" value="8" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon9" name="GroupIcon" value="9" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon10" name="GroupIcon" value="10" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon11" name="GroupIcon" value="11" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon12" name="GroupIcon" value="12" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon13" name="GroupIcon" value="13" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon14" name="GroupIcon" value="14" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon15" name="GroupIcon" value="15" type="radio" /></td>
        </tr>
        <tr>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg16" class="iconpin icon-poi-16"></span>
        	</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg17" class="iconpin icon-poi-17"></span>
        	</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg18" class="iconpin icon-poi-18"></span>
        	</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg19" class="iconpin icon-poi-19"></span>
        	</td>
        	<td style="padding-top: 20px">
        		<span id="GroupIconImg20" class="iconpin icon-poi-20"></span>
        	</td>
        	<td style="padding-top: 20px">
        		<span id="GroupIconImg21" class="iconpin icon-poi-21"></span>
    		</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg22" class="iconpin icon-poi-22"></span>
    		</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg23" class="iconpin icon-poi-23"></span>
        	</td>
        </tr>
        <tr>
    		<td><input style="cursor: pointer;" id="GroupIcon16" name="GroupIcon" value="16" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon17" name="GroupIcon" value="17" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon18" name="GroupIcon" value="18" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon19" name="GroupIcon" value="19" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon20" name="GroupIcon" value="20" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon21" name="GroupIcon" value="21" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon22" name="GroupIcon" value="22" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon23" name="GroupIcon" value="23" type="radio" /></td>
        </tr>
    </table>
    <br /><br />
	<div align="right" style="display:block; width:330px">
        <img id="loading1" style="display: none; width: 150px; position: absolute; left: 32px; margin-top: 7px;" src="../images/loading_bar1.gif" alt="" />
	</div><br />
</div>


<!-- >>>>>>>>>>>>>>>>>>>>>>>> fetched data >>>>>>>>>>>>>>>>>>>>>> -->

<div id="fetch-data" style="display:none"></div>

<!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  JS  >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> -->

<script type="text/javascript">

$(document).ready(function () {

	lang = '<?php echo $cLang ?>';
    showOptions();
    showOptionsInactive();
   	//shade_boxes();

    $('#kopce').button({ icons: { primary: "ui-icon-plus"} });
    // $('#clear-input').button({ icons: { primary: "ui-icon-minus"} });
	$('#brisiGrupno').button({ icons: { primary: "ui-icon-trash"} });
	$('#prefrliGrupno').button({ icons: { primary: "ui-icon-refresh"} });
	$('#neaktivniGrupno').button({ icons: { primary: "ui-icon-cancel"} });
	$('#AktivirajGrupno').button({ icons: { primary: "ui-icon-circle-check"} });

	buttonIcons();
    top.HideWait();
	adjustWidth();

	fetch_inactive();

    $.each(numOfPoints, function(index,value){
		if(value !== 0) {
			first_expand(allGroups[index]);
			return false;
		}
    });

    $(window).resize(function() {
    	delay(function(){
	 	   	$.each(numOfPoints, function(i, v) {
				if (v > limit) {
					console.log("rezize: "+v);
	        		adjustWidth(v);
				}
			});
    	}, 600);
    });

	// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	// 			S C R O L L   E V E N T

    $(".POI_data").scroll(function() {
		item_id = ($(this)[0].id).split('_');
		currGroup = Number(item_id[2]);
		item = $('#POI_data_' + currGroup);

		var groupPos = find_group(GroupsInfo,currGroup);
    	// console.log( "isReady: " + (isReady && (item.scrollTop() + item.innerHeight() >= (item[0].scrollHeight - 120))) );
		if(isReady && (item.scrollTop() + item.innerHeight() >= (item[0].scrollHeight - 120))) {
			isReady = false;
        	console.log('scrolling near bottom -- begin fetching data...');
        	if(GroupsInfo[groupPos].haveData && GroupsInfo[groupPos].numPOI > GroupsInfo[groupPos].offset) {
        		// var groupPos = find_group(GroupsInfo,currGroup);
	        	fetchData(limit,GroupsInfo[groupPos].offset,currGroup);
	        	goToByScroll("POI_group" + currGroup,10);
	        	console.log("[scroll event] have data: "+GroupsInfo[groupPos].haveData+ " - fetching...");
	        } else {
	        	console.log("[scroll event] no data / reset");
	        	dataOffset=0;
	        }
        }

	});

	$('#search_input').bind("input",function(event){

		term = $('#search_input').val().trim().toLowerCase();
		if(term.length == 0) $('#search_img').attr('src','../images/search_find.png');

		filtered = [];
		if(term !== '') {

			$('#search_img').attr('src','../images/ajax-loader.gif');

			// za da ne se povtoruvaat rezultatite
			$('.POI_data_new').hide();
			$('.POI_data_new').remove();

			delay(function(){ // after nokey_treshhold

	    		filtered = filter(term);
	    		// [optimisation]
	    		$('.new-data').hide();
				$('.new-data').remove(); // izbrisi prethodni filtrirani i prikazani
		    	console.log("found: "+ filtered.length + " .............");

				hideData(); // hide group data
				$('.title-group').hide(); // hide group titles
				$('.col-titles').hide();

				// Loading();
				displayData(filtered);

			},nokey_treshhold);

		} else {
			showOriginalData();
		}

	});

	$('#search_input').focus(function(){

		if(doneSearching) {
			doneSearching = false;
			$('#search_img').attr('src','../images/search_find.png');
		}
		// potrebno za da ne se prebaruva koga input == ''
		if ($('#search_input').val() === ''){
			showOriginalData();
		// inaku se registrira scroll event za filtriranite
		} else {
			$('.POI_data_new').scroll(function(event){
				scrollEventFiltered(event);
			});
		}
	});

	$('#search_input').blur(function(){
		if($(this).val() === '') {
			showOriginalData();
		}
		$('#search_img').attr('src','../images/search_find.png');

	});

    // ke se vcitaat site tocki vo JSON format
	setTimeout(function(){
		fetch_all();
		console.log("fetch all");
	},400);

	// za pravilno funcioniranje na drop down listite
	// kaj izmeni toi
	$("#gfGroup dt a").click(function() {
        $("#gfGroup dd ul").toggle();
    });

	$("#gfGroup dd ul li a").click(function() {
	    var text = $(this).html();
	    $("#gfGroup dt a")[0].title = this.id;
	    document.getElementById("groupidTEst").title = this.id;
	    $("#gfGroup dt a span").html(text);
	    $("#gfGroup dd ul").hide();
	});


	 $("#poiGroup dt a").click(function() {
        $("#poiGroup dd ul").toggle();
    });

	 $("#poiGroup dd ul li a").click(function() {
	    var text = $(this).html();
	    $("#poiGroup dt a")[0].title = this.id;
	    document.getElementById("groupidTEst").title = this.id;
	    $("#poiGroup dt a").html(text);
        $("#poiGroup dd ul").hide();
	});

	$(".dropdownRadius dt a").click(function() {
	    $(".dropdownRadius dd ul").toggle();
	});
	$(".dropdownRadius dd ul li a").click(function() {
	    var text = $(this).html();
	    $(".dropdownRadius dt a")[0].title = this.id;
	    $(".dropdownRadius dt a span").html(text);
	    $(".dropdownRadius dd ul").hide();
	});


});

</script>

</body>

<?php closedb();?>

</html>
