<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	opendb();
	$uid = session("user_id");
	$cid = session("client_id");

	$fetchOffset = 0;

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

	<script type="text/javascript">	lang = '<?php echo $cLang?>';</script>

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

	<!-- >> added -->
	<script src="../js/chroma.min.js"></script>
	<script	src="./js/poi-tools.js"></script>

	<style type="text/css">

		html {
		    overflow: auto;
		    -webkit-overflow-scrolling: touch;
		}
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

		#input_container { position:relative; padding:0; margin:0; background:#ddd; }
		#search_input { height:20px; margin:0; padding-left: 30px; }
		#search_img { position:relative; top:5px; left:25px; width:17px; height:17px; margin-left: -20px; }  /* za clear button */

	</style>

</head>
<body>

<?php

	$bannedPOI = dlookup("select bannedpoi from users where id = " . $uid);

	$dsPoigroups = query("SELECT * from pointsofinterestgroups where clientid = " . $cid . " order by name");
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
		<tr>
			<td></td>
			<td align="right" valign="middle">

			<?php
			if ($bannedPOI == '0') {
			?>
				<div id="noData" style="font-size:11px; font-style:normal;" class="text4">
				<?php echo dic_("Routes.ExportToExcel")?>&nbsp;
				<a href = "excel.php?l=<?php echo $cLang?>"><input align = "top" style="padding-top:3px;position:relative; bottom:4px; " valign = "middle" type="image" width = "15px" height = "15px" src="../images/eExcel.png"></input></a>
				</div>
			<?php
			} else {
			?>
				<div id="noData" style="font-size:11px; font-style:normal; opacity:0.4" class="text4">
				<?php echo dic_("Routes.ExportToExcel")?>&nbsp;
				<input align = "top" style="cursor:default; padding-top:3px;position:relative; bottom:4px; " valign = "middle" type="image" width = "15px" height = "15px" src="../images/eExcel.png"></input>
				</div>
			<?php
			}
			?>

			</td>
		</tr>

		<tr class="text2">
			<td width = "70%" align = "left" valign = "middle">
				<button id="kopce" onclick="AddColor()" style="margin-left:1px"><?php echo dic("Reports.AddGroup")?></button>&nbsp;&nbsp;&nbsp;
			</td>
			<td width ="30%" align = "right" valign="middle">
				<div class="input_container">
					<button id="clear-input" onclick="clear_input()">Clear</button>
					<img id="search_img" src="../images/search_find.png"></img>
					<input id="search_input" name="filter" type="text" placeholder="<?php echo dic ("search")?>" size=22 style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:200px;"/>&nbsp;
				</div>
			</td>
		</tr>

		<tr style="height:5px;" class="text2"><td colspan="2"></td></tr>

		<tr style="height: 33px;" class="text2" >
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

$numPointsU = dlookup("select count(*) from pointsofinterest where clientid=" . $cid . "and groupid=1");

	// $numPOI = dlookup("select count(*) from pointsofinterest where clientid=" . $cid . "and groupid=1 and type=1");
	// $numZONE = dlookup("select count(*) from pointsofinterest where clientid=" . $cid . "and groupid=1 and type=2");
	// $numAREA = dlookup("select count(*) from pointsofinterest where clientid=" . $cid . "and groupid=1 and type=3");

if($numPointsU != 0) { ?>

<div class="align-center toi-group-title">
<table id="POI_group1" style="border-spacing:2px">
		<tr>
			<td align = "left" colspan="8" valign = "middle" height="40px" width = "100%" class="text2" style="color:#fff; font-weight:bold; font-size:14px;  padding-left:7px; background-color:#f7962b; font-weight:bold;" id="slider_1" onclick="show_group(1)">
				<span class="expand-icon" style="font-size:18px">▶</span>
				<span style="position:relative; bottom:4px; left: 10px;"><?php echo dic("Settings.NotGroupedItems")?>
				<span class="num-of-poi">(<?php echo $numPointsU ?>)</span>
				<!-- <span style="position:relative; bottom:4px; left: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;
					<img src = "../images/poiButton.png" height="25px" width = "25px"  style="position: relative;top:7px;"> (<?php echo $numPOI ?>)</img>&nbsp;&nbsp;
					<img src = "../images/zoneButton.png" height="25px" width = "25px"  style="position: relative;top:7px;"> (<?php echo $numZONE ?>)</img>&nbsp;&nbsp;
					<img src = "../images/areaImg.png" height="25px" width = "25px"  style="position: relative;top:7px;"> (<?php echo $numAREA ?>)</img>&nbsp;&nbsp;
				</span> -->
			</td>
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
	// $('#POI_data_1 .col-titles').hide();
	allGroups = [1]; // se zacuvuvaat site id-a na grupite
	numOfPoints = [Number('<?php echo $numPointsU ?>')]  // broj na tocki po grupa
</script>

<!-- ******************************************************************************************************* -->

<?php

while ($poiRow = pg_fetch_assoc($dsPoigroups)) {

$numTocki = dlookup("select count(*) from pointsofinterest where clientid=" . $cid . "and groupid=" . $poiRow['id']);

	// $numPOI = dlookup("select count(*) from pointsofinterest where clientid=" . $cid . "and groupid=" . $poiRow['id'] . "and type=1");
	// $numZONE = dlookup("select count(*) from pointsofinterest where clientid=" . $cid . "and groupid=" . $poiRow['id'] . "and type=2");
	// $numAREA = dlookup("select count(*) from pointsofinterest where clientid=" . $cid . "and groupid=" . $poiRow['id'] . "and type=3");
?>

<!-- ************************************** GROUP TITLE ***************************************************** -->
<div class="align-center toi-group-title grouped-title">
<table id="POI_group<?php echo $poiRow['id']?>" style="table-layout:fixed;">
	<tr>
		<td align = "left" colspan="8" valign = "middle" height="40px" width = "76%" class="text2" style="color:black; font-weight:bold; font-size:14px;  padding-left:7px; font-weight:bold;" id="slider_<?php echo $poiRow['id']?>" onclick="show_group(<?php echo $poiRow['id']?>)">
			<span class="expand-icon" style="float: left; font-size:18px">▶</span>&nbsp;
			<div style="margin-left: 10px; border-radius: 5px; width: 18px; height: 18px; float: left; background-color: rgb(255, 255, 0); border: 1px solid rgb(212, 212, 6);"></div>
			<span style="position:relative; left: 10px;"><?php echo $poiRow['name']?></span>
			<span class="num-of-poi" style="margin-left: 10px">(<?php echo $numTocki ?>)</span>
			<!-- <span style="position:relative; bottom:4px; left: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;
				<img src = "../images/poiButton.png" height="25px" width = "25px"  style="position: relative;top:7px;"> (<?php echo $numPOI ?>)</img>&nbsp;&nbsp;
				<img src = "../images/zoneButton.png" height="25px" width = "25px"  style="position: relative;top:7px;"> (<?php echo $numZONE ?>)</img>&nbsp;&nbsp;
				<img src = "../images/areaImg.png" height="25px" width = "25px"  style="position: relative;top:7px;"> (<?php echo $numAREA ?>)</img>&nbsp;&nbsp;
			</span> -->
		</td>

		<td align = "center" valign = "middle" height="40px" class="text2" width = "8%" style="font-weight:bold; font-size:14px; padding-left:5px; padding-right:5px; font-weight:bold;" >
			<button id="btnGroupMap<?php echo $poiRow['id']?>" class="btn-search-ui" onclick="OpenMapAlarm3('<?php echo $poiRow["id"]?>','<?php echo $cLang?>')" style="height:22px; width:30px"></button>
		</td>
		<td align = "center" valign = "middle" height="40px" class="text2" width = "8%" style="font-weight:bold; font-size:14px; padding-left:5px; padding-right:5px; font-weight:bold;" >
			<button id="btnEdit<?php echo $poiRow['id']?>" class="btn-penci-ui" onclick="EditGroup('<?php echo $poiRow["id"]?>','<?php echo $cLang?>')" style="height:22px; width:30px"></button>
		</td>
		<td align = "center" valign = "middle" height="40px" class="text2" width = "8%" style="font-weight:bold; font-size:14px; padding-left:5px; padding-right:5px; font-weight:bold;" >
			<button id="btnVehicles<?php echo $poiRow['id']?>" class="btn-trash-ui" onclick="DeleteGroup('<?php echo $poiRow["id"]?>','<?php echo $cLang?>', <?php echo $numTocki?>)" style="height:22px; width:30px"></button>
		</td>

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
	} // [end].while

	?>
<br><br><br><br><br>
<!-- test -->

<?php

}
// END. GLAVEN ELSE
?>

<!-- DIALOGS -->
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
		<?php
			$qSPoiGroups =query("select * from pointsofinterestgroups where clientid = 357 order by name");
			while ($poiRow = pg_fetch_assoc($qSPoiGroups)) { ?>
				<option id="<?php echo $poiRow["id"] ?>" value = "<?php echo $poiRow["id"] ?>"><?php echo $poiRow["name"] ?></option>
		<?php } ?>
		</select>
	</div>
</div>

<div id="div-del-poi" style="display:none" title="<?php echo dic("Tracking.DeletePoi")?>"><?php echo dic("Reports.DeletePoi")?></div>
<div id="div-del-poi-multiple" style="display:none" title="<?php echo dic("Settings.Action")?>"><?php echo dic("Reports.DeletePoiMultiple")?></div>

<!-- >>>>>>>>>>>>>>>>>>>>>>>> testing >>>>>>>>>>>>>>>>>>>>>> -->

<div id="fetch-data" style="display:none"></div>

<div class="proto-col" style="display: none;">
	<table>
		<tbody>
			<tr class="col-titles">
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
		</tbody>
	</table>
</div>

<!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>  JS  >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> -->

<script type="text/javascript">

$(document).ready(function () {

    prikazi();
    //color_title(); // promena na boite

    $('#kopce').button({ icons: { primary: "ui-icon-plus"} });
    $('#clear-input').button({ icons: { primary: "ui-icon-minus"} });
	$('#brisiGrupno').button({ icons: { primary: "ui-icon-trash"} });
	$('#prefrliGrupno').button({ icons: { primary: "ui-icon-refresh"} });
	$('#neaktivniGrupno').button({ icons: { primary: "ui-icon-cancel"} });
	$('#AktivirajGrupno').button({ icons: { primary: "ui-icon-circle-check"} });
	$('#prikaziPovekeNegrupirani').button({ icons: { primary: "ui-icon-arrowthick-1-s"} });

	buttonIcons();
    top.HideWait();

    $.each(numOfPoints, function(index,value){
		if(value !== 0) {
			first_expand(allGroups[index]);
			return false;
		}
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

		term = $('#search_input').val();
		if(term.length == 0) $('#search_img').attr('src','../images/search_find.png');

		filtered = [];
		if(term !== '') {

			$('#search_img').attr('src','../images/ajax-loader.gif');

			// za da ne se povtoruvaat rezultatite
			$('.POI_data_new').remove();

			delay(function(){ // after nokey_treshhold

	    		filtered = filter(term);
				$('.new-data').remove(); // izbrisi prethodni filtrirani i prikazani
		    	console.log("found: "+ filtered.length + " .............");

				hide_data(); // hide group data
				$('.toi-group-title table').hide(); // hide group titles

				displayData(filtered);

			},nokey_treshhold);

		} else {
			show_original_data();
		}

	});

	$('#search_input').focus(function(){
		if(doneSearching) {
			doneSearching = false;
			$('#search_img').attr('src','../images/search_find.png');
		}
		// potrebno za da ne se prebaruva koga input == ''
		if ($('#search_input').val() == ''){
			show_original_data();
		// inaku se registrira scroll event za filtriranite
		} else {
			$('.POI_data_new').scroll(function(event){
				scrollEventFiltered(event);
			});
		}
	});

	$('#search_input').blur(function(){
		if($(this).val() == '') {
			show_original_data();
		}
		$('#search_img').attr('src','../images/search_find.png');

	});

    // ke se vcitaat site tocki vo JSON format
	setTimeout(function(){
		fetch_all();
		console.log("fetch all");
	},400);


});

</script>

</body>

<?php closedb();?>

</html>