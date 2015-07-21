<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
	header("Content-type: text/html; charset=utf-8");
?>
 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
	<script type="text/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<link rel="stylesheet" type="text/css" href="../style.css">
		<link rel="stylesheet" type="text/css" href="styleGM.css">
	<link rel="stylesheet" type="text/css" href="styleOSM.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.8.14.custom.css">	

	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="../tracking/live.js"></script>
	<script type="text/javascript" src="../tracking/live1.js"></script>
    <script type="text/javascript" src="../js/Raphael.js"></script>
    <script type="text/javascript">
	$(document).ready(function () {
	
	jQuery('body').bind('touchmove', function(e){e.preventDefault()});
	
	});
	</script>
	
	<script type="text/javascript" src="../js/OpenLayers.js"></script>
    <!--Marjan-->
    <link rel="stylesheet" href="../css/mlColorPicker.css" type="text/css" media="screen" charset="utf-8" />
    <script type="text/javascript" src="../js/mlColorPicker.js"></script>
     
	<!--Marjan-->
	<script type="text/javascript">
		top.ShowWait();
	</script>

<?php
    
   	opendb();
	
	$DefMap = nnull(dlookup("select defaultmap from users where id=".session("user_id")),1);
    $cntz = dlookup("select count(*) from pointsofinterest where clientid=".session("client_id"));
    $dsStartLL = query("select * from cities where id = (select cityid from clients where id=".session("client_id")." limit 1)");
	
	$idGroup = getQUERY("id");
    
    $cntRows1 = dlookup("select count(*) from pointsofinterest where type = 1 and groupid=" . $idGroup);
    $cntRows2 = dlookup("select count(*) from pointsofinterest where type = 2 and groupid=" . $idGroup);

    $glavnoQuery = query("select st_x(st_transform(geom, 4326)) lon, st_y(st_transform(geom, 4326)) lat, type,groupid from pointsofinterest where type = 1 and groupid =". $idGroup);
	
	$type = pg_fetch_result($glavnoQuery, 0, "type");

	
	if($type=="1")
	{
		
	$dsPp = query("select id,st_x(st_transform(geom, 4326)) lon, st_y(st_transform(geom, 4326)) lat, type,groupid from pointsofinterest where type = 1 and groupid =". $idGroup);
	$idTocka = pg_fetch_result($dsPp, 0, "id");
	$boicka = pg_fetch_result($dsPp, 0, "groupid");

	if($boicka == "1")
		$boja2 = "ff0000";
	else
	{
		$boja = query("select * from pointsofinterestgroups where clientid=".session("client_id")." and id = ".$boicka."");
		$boja2 = pg_fetch_result($boja, 0, "fillcolor");
	}
	
	$sLon = pg_fetch_result($dsPp, 0, "lon");
	$sLat = pg_fetch_result($dsPp, 0, "lat");
	
	}
	else
	{
	$dsPp1 = query("select id,st_x(st_centroid(geom)) lat, st_y(st_centroid(geom)) lon,groupid from pointsofinterest where type = 2 and groupid =". $idGroup);
	$idZona= pg_fetch_result($dsPp1, 0, "id");
	$boicka = pg_fetch_result($dsPp1, 0, "groupid");
	if($boicka == "1")
		$boja2 = "ff0000";
	else
	{
		$boja = query("select * from pointsofinterestgroups where clientid=".session("client_id")." and id = ".$boicka."");
		$boja2 = pg_fetch_result($boja, 0, "fillcolor");
	}
	
	$sLon = pg_fetch_result($dsPp1, 0, "lon");
	$sLat = pg_fetch_result($dsPp1, 0, "lat");
	}
	
	/*$sLon = "21.432767";
	$sLat = "41.996434";
	if (pg_num_rows($dsStartLL) > 0 ) {
		$sLon = pg_fetch_result($dsStartLL, 0, 'longitude');
		$sLat = pg_fetch_result($dsStartLL, 0, 'latitude');
	}*/
	
    
    $AllowedMaps = "11111";
	$AllowAddPoi = getPriv("AddPOI", session("user_id"));
	$AllowViewPoi = getPriv("ViewPOI", session("user_id"));
	$AllowAddZone = getPriv("AddZones", session("user_id"));
	$AllowViewZone = getPriv("ViewZones", session("user_id"));

?>

<script>
	AllowAddPoi = '<?php echo $AllowAddPoi?>'
	AllowViewPoi = '<?php echo $AllowViewPoi?>'
	AllowAddZone = '<?php echo $AllowAddZone?>'
	AllowViewZone = '<?php echo $AllowViewZone?>'
</script>

 <body>
<div id="div-map" style="width:100%; height:100%">

</div>
<!--Marjan-->
    <a id="a-AddPOI" style="display: none;" href="javascript:"></a>&nbsp;
 <div id="dialog-message" title="<?php echo dic("Tracking.Message")?>" style="display:none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px; padding-left: 23px;"></div>
	</p>
    <div id="DivInfoForAll" style="font-size:11px; padding-left: 23px;"><input id="InfoForAll" type="checkbox" /><?php echo dic("Tracking.InfoMsg")?></div>
</div>
<div id="dialog-message1" title="<?php dic("Reports.Warning")?>" style="display:none">
	 <p>
		<span class="ui-icon ui-icon-circle-minus" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox1" style="font-size:14px"></div>
	</p>
</div>
<div id="dialog-draw-area" title="<?php echo dic("Tracking.DrawArea")?>" style="display:none">
	<iframe src="" id="ifrm-edit-areas" scrolling="no" frameborder="0" style="border:0px dotted #387cb0"></iframe>
</div>
<div id="div-Add-Group" style="display: none;" title="<?php echo dic("Tracking.AddGroup")?>">
	<span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.GroupName")?></span><input id="GroupName" type="text" class="textboxCalender corner5" style="width:220px" /><br /><br />
    <span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.Color")?></span>
    <div id="colorPicker2">
		<span id="colorPicker1" style="cursor: pointer; float:left; border:1px solid black; width:20px; height:20px;margin:5px;"></span>
		<input id="clickAny" type="text" class="textboxCalender corner5" onchange="changecolor()" value="" style="width:120px" />
	</div>
    <img id="loadingIconsPOI" style="visibility: hidden; width: 140px; position: absolute; left: 125px; top: 180px;" src="../images/loading_bar1.gif" alt="" />
    <br><br>
    <span id="spanIconsPOI" style="display:block; width:90px; float:left; margin-left:20px; position: relative; top: 70px;"><?php echo dic("General.Icon")?></span>
    <table id="tblIconsPOI" border="0" style="width: 268px; text-align: center; position: relative; top: -10px; left: -15px;">
        <tr>
        <?php
            for ($icon=0; $icon <= 7; $icon++) { 
        ?>
            <td><img id="GroupIconImg<?php echo $icon?>" src="http://80.77.159.246:88/new/pin/?color=ffffff&type=<?php echo $icon?>" alt="" /></td>
        <?php
            }
        ?>
        </tr>
        <tr>
        <?php
            for ($icon=0; $icon <= 7; $icon++) { 
                if($icon == 0)
                {
                    ?>
                    <td><input style="cursor: pointer;" id="GroupIcon<?php echo $icon?>" name="GroupIcon" checked type="radio" /></td>
                    <?php
                } else
				{
                    ?>
                    <td><input style="cursor: pointer;" id="GroupIcon<?php echo $icon?>" name="GroupIcon" type="radio" /></td>
                    <?php
                }
            
            }
        ?>
        </tr>
        <tr>
        <?php
            for ($icon=8; $icon <= 14; $icon++) { 
            ?>
            <td  style="padding-top: 20px"><img id="GroupIconImg<?php echo $icon?>" src="http://80.77.159.246:88/new/pin/?color=ffffff&type=<?php echo $icon?>" alt="" /></td>
            <?php
            }
            ?>
        </tr>
        <tr>
        <?php
            for ($icon=8; $icon <= 14; $icon++) { 
            ?>
            <td><input style="cursor: pointer;" id="GroupIcon<?php echo $icon?>" name="GroupIcon" type="radio" /></td>
            <?php
            }
            ?>
        </tr>
        <tr>
        <?php
            for ($icon=15; $icon <= 21; $icon++) { 
            ?>
            <td  style="padding-top: 20px"><img id="GroupIconImg<?php echo $icon?>" src="http://80.77.159.246:88/new/pin/?color=ffffff&type=<?php echo $icon?>" alt="" /></td>
            <?php
            }
            ?>
        </tr>
        <tr>
        <?php
            for ($icon=15; $icon <= 21; $icon++) { 
            ?>
            <td><input style="cursor: pointer;" id="GroupIcon<?php echo $icon?>" name="GroupIcon" type="radio" /></td>
            <?php
            }
            ?>
        </tr>
    </table>
    <br /><br />
	<div align="right" style="display:block; width:330px">
        <img id="loading1" style="display: none; width: 150px; position: absolute; left: 32px; margin-top: 7px;" src="../images/loading_bar1.gif" alt="" />
		<input type="button" class="BlackText corner5" id="btnAddGroup" value="<?php echo dic("Tracking.Add")?>" onclick="ButtonAddGroupOkClick()" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnCancelGroup" value="<?php echo dic("Tracking.Cancel")?>" onclick="$('#div-Add-Group').dialog('destroy');" />
	</div><br />
</div>
<div id="div-ver-DelGroup" style="display: none;" title="<?php echo dic("Tracking.DeletePoi")?>">
	<span class="ui-icon ui-icon-alert" style="position: absolute; left: 11px; top: 7px;"></span>
    <div align="center" style="font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo dic("Tracking.DeleteThisPoi")?></div><br />
	<div align="center" style="display:block;">
		<input type="button" class="BlackText corner5" id="btnYesDelGroup" value="<?php echo dic("Tracking.Yes")?>" onclick="$('#div-ver-DelGroup').dialog('destroy'); ButtonDeletePOIokClick()" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnCancelDelGroup" value="<?php echo dic("Tracking.No")?>" onclick="$('#div-ver-DelGroup').dialog('destroy');" />
	</div><br />
</div>
<div id="div-ver-DelGeoF" style="display: none;" title="<?php echo dic("Tracking.DeleteGF")?>">
	<div style="background: url('../images/izv.png')"></div>
    <div align="center" style="font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo dic("Tracking.DeleteThisGeoFence")?></div><br />
	<div align="center" style="display:block;">
		<input type="button" class="BlackText corner5" id="btnYesDelGF" value="<?php echo dic("Tracking.Yes")?>" onclick="$('#div-ver-DelGeoF').dialog('destroy'); ButtonDeleteGFokClick()" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnCancelDelGF" value="<?php echo dic("Tracking.No")?>" onclick="$('#div-ver-DelGeoF').dialog('destroy');" />
	</div><br />
</div>

<div id="div-Add-POI" style="display: none;">
	<br />
	<table style="font-size: 11px; color: rgb(65, 65, 65); font-family: Arial,Helvetica,sans-serif; margin-left: 20px;" cellpadding="0" cellspacing="0" border="0">
    	<tr>
    		<td width="90px"><?php echo dic("Tracking.Latitude")?></td>
    		<td>
    			<input id="poiLat" type="text" class="textboxCalender corner5" style="width:120px" />
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
			        <input type="radio" id="APcheck1" name="radio" /><label for="APcheck1"><?php echo dic("Tracking.User")?></label>
			        <input type="radio" id="APcheck2" name="radio" /><label for="APcheck2"><?php echo dic("Tracking.OrgU")?></label>
			        <input type="radio" id="APcheck3" name="radio" /><label for="APcheck3"><?php echo dic("Tracking.Company")?></label>
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
			                <li><a id="RadiusID_50" href="#">50&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></a></li>
			                <li><a id="RadiusID_70" href="#">70&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></a></li>
			                <li><a id="RadiusID_100" href="#">100&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></a></li>
			                <li><a id="RadiusID_150" href="#">150&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></a></li>
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
					$dsUG = query("SELECT id, name, fillcolor FROM pointsofinterestgroups WHERE id=1");
			        ?>
			        <dt><a href="#" title="" id="groupidTEst" class="combobox1"><span><?php echo dic("Tracking.SelectGroup")?></span></a></dt>
			        <dd>
			            <ul>
			                <li><a id="<?php echo pg_fetch_result($dsUG, 0, "id")?>" href="#">&nbsp;&nbsp;<?php echo dic("Settings.NotGroupedItems")?>
			                	<img style="height: 18px; position: relative; width: 18px; float: left; top: -5px; margin-right: 6px;" src="../images/pin-1.png">
		                	</a></li>
			                <?php
								$dsGroup1 = query("select id, name, fillcolor, image from pointsofinterestgroups where id <> 1 and clientid=".session("client_id"));
			                    while ($row1 = pg_fetch_array($dsGroup1)) {
			                    	$_color = substr($row1["fillcolor"], 1, strlen($row1["fillcolor"]));
			                ?>
			                <li><a id="<?php echo $row1["id"]?>" href="#">&nbsp;&nbsp;<?php echo $row1["name"]?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 24px; height: 24px; background: url('http://80.77.159.246:88/new/pin/?color=<?php echo $_color?>&type=<?php echo $row1["image"]?>') no-repeat; position: relative; float: left;"></div></a></li>
			                <?php
			                    }
			                ?>
			            </ul>
			        </dd>
			    </dl>
    			<input type="button" id="AddGroup" style="left: 20px; top: 1px;" onclick="AddGroup('1')" value="+" />
    		</td>
    	</tr>
	</table>
    <br /><br />
    <input type="hidden" id="idPoi" value="" />
    <input type="hidden" id="numPoi" value="" />
	<div align="right" style="display:block; width:380px; height: 30px; padding-top: 5px; position: relative; float: right; right: 15px;">
        <img id="loading" style="display: none; width: 140px; position: absolute; left: 10px; margin-top: 7px;" src="../images/loading_bar1.gif" alt="" />
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnCancelPOI" value="<?php echo dic("Tracking.Cancel")?>" onclick="$('#div-Add-POI').dialog('destroy');" />        
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnAddPOI" value="<?php echo dic("Tracking.Add")?>" onclick="ButtonAddEditPOIokClick()" />
		<input type="button" style="display: none; position: relative; float: right; " class="BlackText corner5"  id="btnDeletePOI" value="<?php echo dic("Tracking.Delete")?>" onclick="DeleteGroup()" />
	</div><br /><br />
</div>
<div id="div-Directions" class="text2_ corner5 shadow" style="display: none; opacity: 0.9; z-index: 9996; background-color: white; float: right; position: fixed; right: 20px; bottom: 5px; width: 310px; min-height: 315px; height: auto;">
	<div class="textSubTitle" style="text-align: center; padding-top: 10px; height: 25px; border-bottom: 1px solid #ccc;"><?=dic('CalculatingDistance')?></div>
	<table class="text2_" style="font-size: 11px; color: rgb(65, 65, 65); margin-top: 5px; font-family: Arial,Helvetica,sans-serif; margin-left: 20px;" cellpadding="0" cellspacing="0" border="0">
		
		<tr style="height:5px;">
	         <td><div style="border-bottom: 1px dotted rgb(190, 190, 190); margin-left: -5px; width: 278px;"></div></td>
	    </tr>
		<tr height="67px">
    		<td>
    			<input id="fromDirection" onmousemove="ShowPopup(event, '<?=dic('search')?>' + ' ' + '<?=dic('Reports.Mo')?>'.toLowerCase() + ' ' + '<?=dic('Tracking.Address')?>'.toLowerCase())" onmouseout="HidePopup()" type="text" class="textboxCalender corner5 text2_" placeholder="<?=dic('ChooseStartingPoint')?>" style="border-bottom: 0px none; width: 236px; border-radius: 5px 0px 0px; border-right: 0px none;" />
    			<span onclick="ButtonAddStartDirectionClick(event, 0)" onmousemove="ShowPopup(event, '<?=dic('clickforstartpoint')?>')" onmouseout="HidePopup()" style="float: right; cursor: pointer; right: 22px; padding: 4px 6px 2px 5px; position: absolute; border: 1px solid #ccc; height: 21px; border-radius: 0px 5px 0px 0px;"><img id="clickstartaddress" src="../images/plus.png" width="20px" /></span>
    			<input id="direcitonAddress" onclick="javascript: $('#fromDirection').focus();" readonly="readonly" type="text" class="textboxCalender corner5 text2_" style="width: 269px; position: relative; float: left; border-radius: 0px 0px 5px 5px; background-color: #e9e9e9;" /><img id="loadingDirectionAddress" style="float: right; position: absolute; display: none; right: 25px;" width="25px" src="../images/smallref.gif" border="0" align="absmiddle" />
    			<input id="directionLon" type="hidden" value="" class="textboxCalender corner5 text2_" style="width:120px" />
    			<input id="directionLat" type="hidden" value="" class="textboxCalender corner5 text2_" style="width:120px" />
    		</td>
		</tr>
		<tr style="height:5px;">
	         <td>
	         	<div style="border-bottom: 1px dotted rgb(190, 190, 190); margin-left: -5px; width: 269px;"></div>
	         	<img onclick="SwitchPoints()" onmousemove="ShowPopup(event, '<?=dic('ReverseDestinationa')?>')" onmouseout="HidePopup()" width="8" height="11" src="../images/downMenu1.png" style="cursor: pointer; float: right; opacity: 0.25; position: absolute; right: 14px; margin-top: -5px;">
	         	<img onclick="SwitchPoints()" onmousemove="ShowPopup(event, '<?=dic('ReverseDestinationa')?>')" onmouseout="HidePopup()" width="8" height="11" src="../images/upMenu1.png" style="cursor: pointer; float: right; opacity: 0.25; position: absolute; margin-top: -5px; right: 7px;">
	         </td>
	    </tr>
	    <tr height="67px">
    		<td>
    			<input id="toDirection" onmousemove="ShowPopup(event, '<?=dic('search')?>' + ' ' + '<?=dic('Reports.Mo')?>'.toLowerCase() + ' ' + '<?=dic('Tracking.Address')?>'.toLowerCase())" onmouseout="HidePopup()" type="text" class="textboxCalender corner5 text2_" placeholder="<?=dic('ChooseDestination')?>" style="border-bottom: 0px none; width: 236px; border-radius: 5px 0px 0px; border-right: 0px none;" />
    			<span onclick="ButtonAddEndDirectionClick(event, 0)" onmousemove="ShowPopup(event, '<?=dic('clickforendpoint')?>')" onmouseout="HidePopup()" style="float: right; cursor: pointer; right: 22px; padding: 4px 6px 2px 5px; position: absolute; border: 1px solid #ccc; height: 21px; border-radius: 0px 5px 0px 0px;"><img id="clickendaddress" src="../images/plus.png" width="20px" /></span>
    			<input id="direcitonAddressEnd" onclick="javascript: $('#toDirection').focus();" readonly="readonly" type="text" class="textboxCalender corner5 text2_" style="width: 269px; position: relative; float: left; border-radius: 0px 0px 5px 5px; background-color: #e9e9e9;" /><img id="loadingDirectionAddressEnd" style="float: right; position: absolute; display: none; right: 25px;" width="25px" src="../images/smallref.gif" border="0" align="absmiddle" />
    			<input id="directionLonEnd" type="hidden" value="" class="textboxCalender corner5 text2_" style="width:120px" />
    			<input id="directionLatEnd" type="hidden" value="" class="textboxCalender corner5 text2_" style="width:120px" />
    		</td>
		</tr>
		<tr style="height:5px;">
	         <td>
	         	<table id="ResultDirectionsTable" cellpadding="0" cellspacing="0" class="text2_" style="display: none; padding: 7px;">
	         		<tr>
	         			<td style="border-bottom: 1px dotted #2f5185">
	         				<span style="position: relative; float: left;"><?=dic('ShortRoute')?></span>
	         				<hr width="20px" style="position: relative; float: left; left: 10px; top: -1px; border-color: #0000FF; border-width: 4px 0px 0px;">
	         			</td>
	         			<td style="border-bottom: 1px dotted #2f5185; border-left: 1px dotted #2f5185; padding-left: 5px;">
         					<span style="position: relative; float: left;"><?=dic('FastRoute')?></span>
         					<hr width="20px" style="position: relative; float: left; left: 10px; top: -1px; border-color: #FF0000; border-width: 4px 0px 0px;">
     					</td>
	         		</tr>
	         		<tr>
	         			<td><div id="ResultDirections" style="display: none; width: 122px; height: auto;"></div></td>
	         			<td style="border-left: 1px dotted #2f5185; padding: 5px;"><div id="ResultDirectionsF" style="display: none; width: 127px; height: auto;"></div></td>
	         		</tr>
	         	</table>
	         </td>
	    </tr>
		<tr style="height:5px;">
	         <td><div style="border-bottom: 1px dotted rgb(190, 190, 190); margin-left: -5px; width: 278px;"></div></td>
	    </tr>
	</table>
    <br />
	<div align="right" style="display:block; width:270px; height: 30px; padding-top: 5px; position: relative; float: right; right: 20px;">
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnCancelDirections" value="<?php echo dic("Tracking.Close")?>" onclick="$('#div-Directions').css({display: 'none'}); clearDirectionS(); clearDirectionE(); ButtonAddEndDirectionClick(); ButtonAddStartDirectionClick();" />        
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnDirections" value="<?=dic('calculate')?>" onclick="GetDirections('0')" />
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnSaveDirections" value="<?=dic('Save')?>" onclick="SaveDirections('0')" />
	</div><br /><br />
</div>
<div id="div-enter-zone-name" style="display:none">
	<div align = "center">
 		<table cellpadding="3" width="100%" style="font-size: 11px">
			<tr>
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.GFName")?>:</td>
				<td width = "75%" style="font-weight:bold" class ="text2">
					<input id="txt_zonename" type="text" value="" class="textboxcalender corner5 text5" style="width:365px;" />
				</td>
			</tr>
			<tr width = "75%" style="font-weight:bold" class ="text2">
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.AvailableFor")?>:</td>
				<td>
					<div id="gfAvail" class="corner5">
				        <input type="radio" id="GFcheck1" name="radio" /><label for="GFcheck1"><?php echo dic("Tracking.User")?></label>
				        <input type="radio" id="GFcheck2" name="radio" /><label for="GFcheck2"><?php echo dic("Tracking.OrgU")?></label>
				        <input type="radio" id="GFcheck3" name="radio" /><label for="GFcheck3"><?php echo dic("Tracking.Company")?></label>
				        <script>
				    		$('#GFcheck1').click(function(){ $(this).blur(); });
				    		$('#GFcheck2').click(function(){ $(this).blur(); });
				    		$('#GFcheck3').click(function(){ $(this).blur(); });
				    </script>
				    </div>
				</td>
			</tr>
			<tr>
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.Group")?>:</td>
				<td width = "75%" style="font-weight:bold" class ="text2">
					<dl id="gfGroup" class="dropdown" style="width: 150px; position: relative; float: left; margin: 0px;">
				    <?php
					$dsUG1 = query("SELECT id, name, fillcolor, '1' as image FROM pointsofinterestgroups WHERE id=1");
			        ?>
			        <dt><a href="#" title="" class="combobox1"><span class ="text2"><?php echo dic("Tracking.SelectGroup")?></span></a></dt>
			        <dd>
			            <ul>
			                <li><a id="<?php echo pg_fetch_result($dsUG1, 0, "id")?>" href="#">&nbsp;<?php echo dic("Settings.NotGroupedItems")?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 18px; height: 18px; background-color: <?php echo pg_fetch_result($dsUG1, 0, "fillcolor")?>; position: relative; float: left;"></div></a></li>
			                <?php
			                    $dsGroup2 = query("SELECT id, name, fillcolor, '1' as image FROM pointsofinterestgroups WHERE clientid=".session("client_id"));
			                    while ($row = pg_fetch_array($dsGroup2)) {
			                ?>
			                <li><a id="<?php echo $row["id"]?>" href="#">&nbsp;&nbsp;<?php echo $row["name"]?><div class="flag" style="margin-top: -1px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 18px; height: 18px; background-color: <?php echo $row["fillcolor"]?>; position: relative; float: left;"></div></a></li>
			                <?php
								}
			                ?>
			            </ul>
			        </dd>
			    </dl>
			    <input type="button" id="AddGroup1" style="position: relative; float: left; left: 20px; top: 1px;" onclick="AddGroup('0')" value="+" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<hr width="100%" style="opacity: 0.3; border-left: 0px none; border-width: 2px 0px 0px; border-style: dotted none none; border-color: -moz-use-text-color;">
				</td>
			</tr>
			<?php
				if(!$allowedAlarms) 
				{ ?>
					<tr>
						<td colspan="2">
							<table cellpadding="3" onclick="return false;" width="100%" style="font-size: 11px; opacity: 0.5;">
								<tr>
									<td>
				<?php } ?>
					
			<tr>
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.AlertFor")?>:</td>
			    <td width = "75%" style="font-weight:bold" class ="text2">
				    <div id="alertINOUT" class="corner5">
				        <input type="checkbox" id="alVlez" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> name="checkbox" /><label for="alVlez"><?php echo dic("Tracking.Enter1")?></label>
				        <input type="checkbox" id="alIzlez" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> name="checkbox" /><label for="alIzlez"><?php echo dic("Tracking.Exit")?></label>
				    </div>
				</td>
		    </tr>
     		<tr>
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.GroupOFAlerts")?>:</td>
			    <td width = "75%" style="font-weight:bold" class ="text2">
				    <div class="ui-widget" style="height: 25px; width: 100%;">
					    <select id="vozila" style="width: 365px;" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> class="combobox text2" onchange="OptionsChangeVehicle()">
					    	<option value="0"><?php echo dic("Tracking.SelectOption")?></option>
					        <option value="1"><?php echo dic("Tracking.OneVehicle")?></option>
					        <option value="2"><?php echo dic("Tracking.VehInOrgU")?></option>
					        <option value="3"><?php echo dic("Tracking.AllVehCompany")?></option>
					    </select>
					</div>
				</td>
		    </tr>
			<tr id="ednoVozilo" style="display:none;">
		     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.SelectVeh")?>:</td>
		     <td width = "75%" style="font-weight:bold" class ="text2">
		     <div class="ui-widget" style="height: 25px; width: 100%;">
		     <select id="voziloOdbrano" style="width: 365px;" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> class="combobox text2">
		     	<?php
		        	$str1 = "";
					$str1 .= "select * from vehicles where clientid=" . session("client_id") ." ORDER BY code::INTEGER";
					$dsPP = query($str1);
		            while($row = pg_fetch_array($dsPP)) {
		        ?>
		            <option value="<?php echo $row["id"] ?>"><?php echo $row["registration"]?>&nbsp;(<?php echo $row["code"]?>)</option>
		        <?php
		            }
		        ?>
		     </select>
			 </div>
			 </td>   
		     </tr>
     
		     <tr id="OrganizacionaEdinica" style="display:none;">
		     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.SelectOrg.Unit")?>:</td>
		     <td width = "75%" style="font-weight:bold" class ="text2">
		     <div class="ui-widget" style="height: 25px; width: 100%">
		     <select id="oEdinica" style="width: 365px;" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> class="combobox text2">
		     	<?php
		        	$str2 = "";
					$str2 .= "select * from organisation where clientid=" . session("client_id") ." order by code::INTEGER";
					$dsPP2 = query($str2);
					$brojRedovi = dlookup("select count(*) from organisation where clientid=" . session("client_id"));
		            while($row2 = pg_fetch_array($dsPP2)) {
		        ?>
		            <option value="<?php echo $row2["id"] ?>"><?php if ($brojRedovi>0){ echo $row2["name"]?>&nbsp;(<?php echo $row2["code"]?> <?php }else{ echo dic("Settings.NoOrgU");}?>)</option>
		        <?php
		            }
		        ?>
		     </select>
			 </div>
			 </td>
		     </tr>
		     
     	     <tr>
		     	<td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic("Tracking.Emails")?></td>
		     	<td width = "75%" style="font-weight:bold" class ="text2">
		     		<input id = "txt_emails" class="textboxcalender corner5 text5" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> type="text" style = "width:365px"></input>
	     		</td>
		     </tr>
		     <tr>
		     	<td width = "25%"></td>	
		     	<td width = "75%" style="font-weight:bold ; " class ="text2"><font color = RED style="font-size = 10px"><?php echo dic("Reports.SchNote")?></font></td>
		     </tr>
		     <tr>
		     	<td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic("Settings.SMS")?></td>
		     	<td width = "75%" style="font-weight:bold" class ="text2"><input id = "txt_phones" class="textboxcalender corner5 text5" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> type="text" style = "width:365px"></input></td>
		     </tr>
	     	
		 <?php if(!$allowedAlarms)
			{
				?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<?php
			}?>
		 
	   	 </table>
     </div>
</div>

    <div id="gnInfoWindow" class="gn-corner gn-shadow" style=" overflow:hidden; position:absolute; z-index:9999; width:230px; height:130px; left:500px; border:1px solid #8ea4c1; background-Color:#ced9e7; opacity:0.8; display:none">
    	<div onClick="TrackClick(event)" class="gn-corner" style="position:absolute; left:10px; height:5px; top:20px; width:210px; border:1px solid #aaa4a1; background-color:#dddad7"></div>    
        <div id="gnScroll" class="gn-corner" onMouseDown="MouseDownScroll(event)"  onMouseUp="gnClick = false" style="position:absolute; left:10px; height:15px; top:16px; width:14px; background-image:url(images/gnScroll.png)"></div>    
        <span class = "fontMainMenu" id="txtPoints" style="position:absolute; left:160px; top:35px;"></span>
        <span id="lblTime" class = "fontMainMenu" style="position:absolute; left:20px; top:35px;"></span>
    </div>
<div>
</div>
</body>
</html>


<script type="text/javascript">
	
	var geocoder = new google.maps.Geocoder();

	$("#div-Directions").mousemove(function(event) {
		$(this).css({opacity: '1'});
    });
    $("#div-Directions").mouseout(function(event) {
    	$(this).css({opacity: '0.8'});
    });
    
    $('#btnDirections').button();
    $('#btnSaveDirections').button();
    $('#btnCancelDirections').button();
    $("#toDirection").autocomplete({
        //This bit uses the geocoder to fetch address values
        source: function (request, response) {
            geocoder.geocode({ 'address': request.term }, function (results, status) {
                response($.map(results, function (item) {
                    return {
                        label: item.formatted_address,
                        value: item.formatted_address,
                        latitude: item.geometry.location.lat(),
                        longitude: item.geometry.location.lng()
                    }
                }));
            })
        },
        //This bit is executed upon selection of an address
        select: function (event, ui) {
        	clearDirectionE();
        	ButtonAddEndDirectionClick();
        	setCenterMap(ui.item.longitude, ui.item.latitude, 18, 0);
        	AddMarkerDestinationE1(ui.item.longitude, ui.item.latitude);
        	//ButtonAddDirectionClick(event, 0);
            /*setCenterMap(ui.item.longitude, ui.item.latitude, 18, num);
            AddMarkerS(ui.item.longitude, ui.item.latitude, num, ui.item.label);*/
           
        },
        open: function () { clearDirectionE('0'); $("#toDirection").autocomplete("widget").width(269); }
    });
    $("#fromDirection").autocomplete({
        //This bit uses the geocoder to fetch address values
        source: function (request, response) {
            geocoder.geocode({ 'address': request.term }, function (results, status) {
                response($.map(results, function (item) {
                    return {
                        label: item.formatted_address,
                        value: item.formatted_address,
                        latitude: item.geometry.location.lat(),
                        longitude: item.geometry.location.lng()
                    }
                }));
            })
        },
        //This bit is executed upon selection of an address
        select: function (event, ui) {
        	//$("#vozilcaDirection option[value=-1]").attr('selected', 'selected');
        	$("#vozilcaDirection").val(-1);
        	clearDirectionS();
        	ButtonAddStartDirectionClick();
        	setCenterMap(ui.item.longitude, ui.item.latitude, 18, 0);
        	AddMarkerDestinationS1(ui.item.longitude, ui.item.latitude);
        },
        open: function () { clearDirectionS('0'); $("#fromDirection").autocomplete("widget").width(269); }
    });
    function clearDirectionS(_ch) {
    	$('#fromDirection').removeAttr('required');
	    if (tmpMarkerDirectionS != undefined) {
	        vectors[0].removeFeatures(tmpMarkerDirectionS);
	        tmpMarkerDirectionS = undefined;
	    }
	    if(_ch == undefined)
	    	$('#fromDirection').val('')
    	$('#direcitonAddress').val('');
    	$('#directionLat').val('');
    	$('#directionLon').val('');
    	$('#ResultDirections').css({ display: 'none' });
        $('#ResultDirections').html('');
        $('#ResultDirectionsF').css({ display: 'none' });
        $('#ResultDirectionsF').html('');
        $('#ResultDirectionsTable').css({ display: 'none' });
        if(lineFeatureDirections[0] != undefined) {
	        for (var i = 0; i < lineFeatureDirections[0].length; i++) {
	            vectors[0].removeFeatures([lineFeatureDirections[0][i]]);
	        }
	        lineFeatureDirections[0] = [];
       	}
       	if(lineFeatureDirections[1] != undefined) {
	        for (var i = 0; i < lineFeatureDirections[1].length; i++) {
	            vectors[0].removeFeatures([lineFeatureDirections[1][i]]);
	        }
	        lineFeatureDirections[1] = [];
       	}
    }
    function clearDirectionE(_ch) {
    	$('#toDirection').removeAttr('required');
    	if (tmpMarkerDirectionE != undefined) {
	        vectors[0].removeFeatures(tmpMarkerDirectionE);
	        tmpMarkerDirectionE = undefined;
	    }
	    if(_ch == undefined)
	    	$('#toDirection').val('')
	    $('#direcitonAddressEnd').val('');
    	$('#directionLatEnd').val('');
    	$('#directionLonEnd').val('');
    	$('#ResultDirections').css({ display: 'none' });
        $('#ResultDirections').html('');
        $('#ResultDirectionsF').css({ display: 'none' });
        $('#ResultDirectionsF').html('');
        $('#ResultDirectionsTable').css({ display: 'none' });
        if(lineFeatureDirections[0] != undefined) {
	        for (var i = 0; i < lineFeatureDirections[0].length; i++) {
	            vectors[0].removeFeatures([lineFeatureDirections[0][i]]);
	        }
	        lineFeatureDirections[0] = [];
       	}
       	if(lineFeatureDirections[1] != undefined) {
	        for (var i = 0; i < lineFeatureDirections[1].length; i++) {
	            vectors[0].removeFeatures([lineFeatureDirections[1][i]]);
	        }
	        lineFeatureDirections[1] = [];
       	}
    }
    function ChangeVozDir() {
    	ButtonAddStartDirectionClick();
    	clearDirectionS();
    	if($("#vozilcaDirection").find('option:selected').val() != '-1') {
	    	for(var i=0; i<Car.length; i++) {
	            if(Car[i].id == $("#vozilcaDirection").find('option:selected').val()){
	                $('#direcitonAddress').val('');
				    $('#directionLon').val('');
				    $('#directionLat').val('');
				    $('#loadingDirectionAddress').css({ display: "block" });
				    $.ajax({
				        url: twopoint + "/main/getGeocode.php?lon=" + Car[i].lon + "&lat=" + Car[i].lat + "&tpoint=" + twopoint,
				        context: document.body,
				        success: function (data) {
				            $('#direcitonAddress').val(data);
				            $('#loadingDirectionAddress').css({ display: "none" });
				            $('#fromDirection').val($("#vozilcaDirection").find('option:selected').html())
				        }
				    });
				    $('#directionLat').val(Car[i].lat)
				    $('#directionLon').val(Car[i].lon)
	                break;
	            }
	        }
       	}
    }
    function SwitchPoints() {
    	var tmpLon = $('#directionLon').val();
    	var tmpLat =  $('#directionLat').val();
    	var tmpFromDir =  $('#fromDirection').val();
    	var tmpDirAddress = $('#direcitonAddress').val();
    	vectors[0].removeFeatures(tmpMarkerDirectionS);
    	tmpMarkerDirectionS = undefined;
    	vectors[0].removeFeatures(tmpMarkerDirectionE);
	    tmpMarkerDirectionE = undefined;
	    
	    $('#directionLon').val($('#directionLonEnd').val());
	    $('#directionLat').val($('#directionLatEnd').val());
    	$('#fromDirection').val($('#toDirection').val());
    	$('#direcitonAddress').val($('#direcitonAddressEnd').val());
    	
    	$('#directionLonEnd').val(tmpLon);
	    $('#directionLatEnd').val(tmpLat);
    	$('#toDirection').val(tmpFromDir);
    	$('#direcitonAddressEnd').val(tmpDirAddress);
    	
    	AddMarkerDirectionS($('#directionLon').val(), $('#directionLat').val(), 0, $('#direcitonAddress').val());
    	AddMarkerDirectionE($('#directionLonEnd').val(), $('#directionLatEnd').val(), 0, $('#direcitonAddressEnd').val());
    	
    	$('#ResultDirections').css({ display: 'none' });
	    $('#ResultDirections').html('');
	    $('#ResultDirectionsF').css({ display: 'none' });
	    $('#ResultDirectionsF').html('');
	    $('#ResultDirectionsTable').css({ display: 'none' });
	    $("#vozilcaDirection").val(-1);
	    GetDirections('1');
    }


	top.HideWait();
   var lang = '<?php echo $cLang ?>';
   
    //Marjan
    var boolDDR = true;
    $(".dropdownRadius dt a").click(function() {
        if(boolDDR)
        {
            $(".dropdownRadius dd ul").toggle();
            boolDDR = false;
        }
        else
            boolDDR = true;
    });
    $(".dropdownRadius dd ul li a").click(function() {
        var text = $(this).html();
        $(".dropdownRadius dt a")[0].title = this.id;
        
        $(".dropdownRadius dt a span").html(text);
        $(".dropdownRadius dd ul").hide();
        //$("#result").html("Selected value is: " + getSelectedValue("sample"));
    });
    var boolDD = true;
    $(".dropdown dt a").click(function () {
        if(boolDD)
        {
            $(".dropdown dd ul").toggle();
            boolDD = false;
        }
        else
            boolDD = true;
    });
    $(".dropdown dd ul li a").click(function () {
        var text = $(this).html();
        $(".dropdown dt a")[0].title = this.id;
        document.getElementById("groupidTEst").title = this.id;
        if(text.indexOf("pin-1") != -1)
        	$(".dropdown dt a span").html(text.replace('top: -5px', 'top: -1px'));
        else
			$(".dropdown dt a span").html(text);
        $(".dropdown dd ul").hide();
        //$("#result").html("Selected value is: " + getSelectedValue("sample"));
    });

    var boolDDGF = true;
    $(".dropdownGF dt a").click(function () {
        if(boolDDGF)
        {
            $(".dropdownGF dd ul").toggle();
            boolDDGF = false;
        }
        else
            boolDDGF = true;
    });
    $(".dropdownGF dd ul li a").click(function () {
        var text = $(this).html();
        $(".dropdownGF dt a")[0].title = this.id;
        //document.getElementById("groupidTEst").title = this.id;
        $(".dropdownGF dt a span").html(text);
        $(".dropdownGF dd ul").hide();
        //$("#result").html("Selected value is: " + getSelectedValue("sample"));
    });

    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (! $clicked.parents().hasClass("dropdown"))
            $(".dropdown dd ul").hide();
        if (! $clicked.parents().hasClass("dropdownRadius"))
            $(".dropdownRadius dd ul").hide();
        if (! $clicked.parents().hasClass("dropdownGF"))
            $(".dropdownGF dd ul").hide();
    });

    //Marjan

    StartLat = '<?php echo $sLat?>';
    StartLon = '<?php echo $sLon?>';

    var _userId = '506';

    AllowedMaps = '<?php echo $AllowedMaps?>'
    DefMapType = '<?php echo $DefMap?>'
    var cntz = parseInt('<?php echo ($cntz-1)?>');
    VehcileIDs = ['<?php echo $strVehcileID?>'];

    OpenForDrawing = true;
    LoadCurrentPosition = false;
    ShowVehiclesMenu = false;
    if(AllowViewPoi == "1")
    	ShowPOIBtn = true;
	else
		ShowPOIBtn = false;
    if(AllowViewZone == "1")
    	ShowGFBtn = true;
	else
		ShowGFBtn = false;
    var RecOn = false;
    var RecOnNew = false;
    CreateBoards()

    LoadMaps();
   
   
   	LoadPOIPetar('<?php echo $idGroup?>');
   	
	<?php	
	$zonata = "";
	$bojata = "";
	$proveriZona = query("select * from pointsofinterest where type = 2 and groupid = ".$idGroup." and clientid=".session("client_id")."");
    while ($row = pg_fetch_array($proveriZona))
    {
       	$zonata .= ",".$row["id"];
	}
	if (strlen($zonata)>0) {
				$zonata = substr($zonata,1);	
			}
	?>
	var zonaid=['<?php echo $zonata?>'];
	for(var i=0; i < zonaid.length; i++)
	{
		DrawZoneOnLive(zonaid[i], "#ffffff");
	}
	
</script>
