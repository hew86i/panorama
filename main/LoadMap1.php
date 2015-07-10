<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
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
	<script type="text/javascript" src="../js/iScroll.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="live.js"></script>
	<script type="text/javascript" src="live1.js"></script>
    <script type="text/javascript" src="../js/Raphael.js"></script>
	
	<script type="text/javascript" src="../js/OpenLayers.js"></script>
    <!--Marjan-->
    <link rel="stylesheet" href="../css/mlColorPicker.css" type="text/css" media="screen" charset="utf-8" />
    <script type="text/javascript" src="../js/mlColorPicker.js"></script>
     
	<!--Marjan-->
	<script type="text/javascript">
		top.ShowWait();
	</script>

<?php
    
    //$cLang = Request.QueryString("l").Split("?")(0)
    $lon = getQUERY("lon");
	$lat = getQUERY("lat");
	$reg = getQUERY("reg");
	$dat = getQUERY("dat");
	$time = getQUERY("time");
	$speed = getQUERY("speed");
    opendb();
    $DefMap = nnull(dlookup("select defaultmap from users where id=".session("user_id")),1);
    
    $ClientTypeID = dlookup("select clienttypeid from clients where id=".session("client_id"));
    $cntz = dlookup("select count(*) from pointsofinterest where active='1' and type=2 and clientid=".session("client_id"));
    
    $dsStartLL = query("select * from cities where id = (select cityid from clients where id=".session("client_id")." limit 1)");
	
	$sLon = $lon;
	$sLat = $lat;
	
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
<table id="live-table" width="100%" border="0" cellpadding="0" cellspacing="0" style="position: relative;">
	<tr>
		<td id="vehicle-list" width="250px" valign="top">
			<div id="div-menu" style="width:100%; overflow-y:auto; overflow-x:hidden">
				<div id="menu-1" class="menu-container" style="width:100%">
					<a id="menu-title-1" href="#" class="menu-title text3" onClick="OnMenuClick(1)" style="width:100%;">Основни податоци</a>
					<div id="menu-container-1" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px; overflow:auto">
					<div>
						
						</div><br><br>&nbsp;
					</div>
				</div>
				<div id="menu-2" class="menu-container" style="width:100%">
					<a id="menu-title-2" href="#" class="menu-title text3" onClick="OnMenuClick(2)" style="width:100%;">Детали</a>
					<div id="menu-container-2" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px; overflow:auto">
					<div>
						
						</div><br><br>&nbsp;
					</div>
				</div>
				<div id="menu-3" class="menu-container" style="width:100%">
					<a id="menu-title-3" href="#" class="menu-title text3" onClick="OnMenuClick(3)" style="width:100%;">Тип на аларм</a>
					<div id="menu-container-3" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px; overflow:auto">
					<div>
						
						</div><br><br>&nbsp;
					</div>
				</div>
			</div>
            <div id="race-img" style="position:absolute; left: 250px; width:8px; height:50px; background-image:url(../images/racelive.png); background-position: -8px 0px; z-index: 2000; cursor:pointer" onClick="shleft()"></div>
		</td>
		<td id="maps-container" valign="top" style="border-left: 2px Solid #387cb0"><!--groletna.aspx?t=2-->
			<div id="div-map"></div>
			
		</td>
	</tr>
</table>

</div>
<!--Marjan-->
    

<div id="icon-legenda" style="position: relative; cursor: help; float: right; z-index: 3000; margin-right: 10px;"><img src="../images/legenda.png" border="0" align="absmiddle" /></div>

 <div id="dialog-message" title="<?php echo dic("Tracking.Message")?>" style="display:none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px; padding-left: 23px;"></div>
	</p>
    <div id="DivInfoForAll" style="font-size:11px; padding-left: 23px;"><input id="InfoForAll" type="checkbox" /><?php echo dic("Tracking.InfoMsg")?></div>
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
    <img id="loadingIconsPOI" style="visibility: hidden; width: 150px; position: absolute; left: 32px; top: 185px;" src="../images/loading_bar1.gif" alt="" />
    <br><br>
    <span id="spanIconsPOI" style="display:block; width:90px; float:left; margin-left:20px; position: relative; top: 9px;"><?php echo dic("General.Icon")?></span>
    <table id="tblIconsPOI" border="0" style="width: 268px; text-align: center; position: relative; top: -10px; left: -15px;">
        <tr>
        <?php
            for ($icon=0; $icon <= 0; $icon++) { 
        ?>
            <td><img id="GroupIconImg<?php echo $icon?>" src="http://gps.mk/new/pin/?color=ffffff&type=<?php echo $icon?>" alt="" /></td>
        <?php
            }
        ?>
        </tr>
        <tr>
        <?php

            for ($icon=0; $icon <= 0; $icon++) { 
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
    </table>
    <br /><br />
	<div align="right" style="display:block; width:330px">
        <img id="loading1" style="display: none; width: 150px; position: absolute; left: 32px; margin-top: 7px;" src="../images/loading_bar1.gif" alt="" />
		<input type="button" class="BlackText corner5" id="btnCancelGroup" value="<?php echo dic("Tracking.Cancel")?>" onclick="$('#div-Add-Group').dialog('destroy');" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnAddGroup" value="<?php echo dic("Tracking.Add")?>" onclick="ButtonAddGroupOkClick()" />
	</div><br />
</div>
<div id="div-ver-DelGroup" style="display: none;" title="<?php echo dic("Tracking.DeletePoi")?>">
	<span class="ui-icon ui-icon-alert" style="position: absolute; left: 11px; top: 7px;"></span>
    <div align="center" style="font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo dic("Tracking.DeleteThisPoi")?></div><br />
	<div align="center" style="display:block;">
		<input type="button" class="BlackText corner5" id="btnCancelDelGroup" value="<?php echo dic("Tracking.No")?>" onclick="$('#div-ver-DelGroup').dialog('destroy');" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnYesDelGroup" value="<?php echo dic("Tracking.Yes")?>" onclick="$('#div-ver-DelGroup').dialog('destroy'); ButtonDeletePOIokClick()" />
	</div><br />
</div>
<div id="div-ver-DelGeoF" style="display: none;" title="<?php echo dic("Tracking.DeleteGF")?>">
	<div style="background: url('../images/izv.png')"></div>
    <div align="center" style="font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo dic("Tracking.DeleteThisGeoFence")?></div><br />
	<div align="center" style="display:block;">
		<input type="button" class="BlackText corner5" id="btnCancelDelGF" value="<?php echo dic("Tracking.No")?>" onclick="$('#div-ver-DelGeoF').dialog('destroy');" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnYesDelGF" value="<?php echo dic("Tracking.Yes")?>" onclick="$('#div-ver-DelGeoF').dialog('destroy'); ButtonDeleteGFokClick()" />
	</div><br />
</div>

<div id="div-Add-POI" style="display: none;">
	<span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.Latitude")?> </span><input id="poiLat" type="text" class="textboxCalender corner5" style="width:120px" /><br /><br />
	<span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.Longitude")?> </span><input id="poiLon" type="text" class="textboxCalender corner5" style="width:120px" /><br /><br />
    <span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.Address")?></span><input id="poiAddress" type="text" class="textboxCalender corner5" style="width:269px" /><img id="loadingAddress" style="visibility: hidden;" width="25px" src="../images/loadingP1.gif" border="0" align="absmiddle" /><br /><br />
	<span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.NamePoi")?></span><input id="poiName" type="text" class="textboxCalender corner5" style="width:269px" /><br /><br />
    <!--span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.AddInfo")?></span><input id="additionalInfo" type="text" class="textboxCalender corner5" style="width:269px" /><br /><br /-->
    <span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.AvailableFor")?> </span>
    <div id="poiAvail" class="corner5" style="font-size: 10px">
        <input type="radio" id="APcheck1" name="radio" /><label for="APcheck1">Корисник</label>
        <input type="radio" id="APcheck2" name="radio" /><label for="APcheck2">Организациона единица</label>
        <input type="radio" id="APcheck3" name="radio" /><label for="APcheck3">Компанија</label>
    </div>
    <br />
    <span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.Radius")?> </span>
    <dl id="poiRadius" class="dropdownRadius" style="width: 70px; position: relative; float: left; top: -11px;">
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
    <br /><br /><br /><br />
    <span style="display:block; width:90px; float:left; margin-left:20px; position: relative; top: -3px;"><?php echo dic("Tracking.Group")?> </span>
    <dl id="poiGroup" class="dropdown" style="width: 150px; position: relative; float: left; top: -10px; padding: 0px; margin: 0px;">
    <?php
		$dsUG = query("SELECT id, name, fillcolor, '0' image FROM pointsofinterestgroups WHERE id=1");
        ?>
        <dt><a href="#" title="" id="groupidTEst" class="combobox1"><span><?php echo dic("Tracking.SelectGroup")?></span></a></dt>
        <dd>
            <ul>
                <li><a id="<?php echo pg_fetch_result($dsUG, 0, "id")?>" href="#">&nbsp;&nbsp;<?php echo pg_fetch_result($dsUG, 0, "name")?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 24px; height: 24px; background: url('http://gps.mk/new/pin/?color=<?php echo pg_fetch_result($dsUG, 0, "fillcolor")?>&type=<?php echo pg_fetch_result($dsUG, 0, "image")?>') no-repeat; position: relative; float: left;"></div></a></li>
                <?php
					$dsGroup1 = query("select id, name, fillcolor, '0' image from pointsofinterestgroups where clientid=".session("client_id"));
                    while ($row1 = pg_fetch_array($dsGroup1)) {
                    	$_color = substr($row1["fillcolor"], 1, strlen($row1["fillcolor"]));
                ?>
                <li><a id="<?php echo $row1["id"]?>" href="#">&nbsp;&nbsp;<?php echo $row1["name"]?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 24px; height: 24px; background: url('http://gps.mk/new/pin/?color=<?php echo $_color?>&type=<?php echo $row1["image"]?>') no-repeat; position: relative; float: left;"></div></a></li>
                <?php
                    }
                ?>
            </ul>
        </dd>
    </dl>
    <input type="button" id="AddGroup" style="left: 30px; top: -8px;" onclick="AddGroup('1')" value="+" />
    <br /><br />
    <input type="hidden" id="idPoi" value="" />
    <input type="hidden" id="numPoi" value="" />
	<div align="right" style="display:block; width:380px; height: 30px; padding-top: 5px;">
        <img id="loading" style="display: none; width: 140px; position: absolute; left: 20px; margin-top: 7px;" src="../images/loading_bar1.gif" alt="" />
        <input type="button" style="display: none; position: relative; float: right;" class="BlackText corner5"  id="btnDeletePOI" value="<?php echo dic("Tracking.Delete")?>" onclick="DeleteGroup()" />
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnCancelPOI" value="<?php echo dic("Tracking.Cancel")?>" onclick="$('#div-Add-POI').dialog('destroy');" />&nbsp;&nbsp;
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnAddPOI" value="<?php echo dic("Tracking.Add")?>" onclick="ButtonAddEditPOIokClick()" />
	</div><br /><br />
</div>
<div id="div-enter-zone-name" style="display:none">
	<?php echo dic("Tracking.GFName")?>:&nbsp;<input id="txt_zonename" type="text" value="" class="textboxcalender corner5 text5" style="width: 301px; height: 22px; font-size: 11px; position: relative; float: right; right: 220px;"/><br />
    <span style="display:block; width:90px; float:left; padding-top: 25px;"><?php echo dic("Tracking.AvailableFor")?>: </span>
    <div id="gfAvail" class="corner5" style="font-size: 10px; position: relative; float: left; left: 9px; top: 10px;">
        <input type="radio" id="GFcheck1" name="radio" /><label for="GFcheck1">Корисник</label>
        <input type="radio" id="GFcheck2" name="radio" /><label for="GFcheck2">Организациона единица</label>
        <input type="radio" id="GFcheck3" name="radio" /><label for="GFcheck3">Компанија</label>
    </div>
    <br /><br /><br />
	<span style="display:block; width:90px; float:left; padding-top:20px;"><?php echo dic("Tracking.Group")?>:</span>
    <dl id="gfGroup" class="dropdown" style="width: 150px; position: relative; float: left; left: 8px; top: 2px;">
	    <?php
		$dsUG1 = query("SELECT id, name, fillcolor, '1' as image FROM pointsofinterestgroups WHERE id=1");
        ?>
        <dt><a href="#" title="" class="combobox1"><span><?php echo dic("Tracking.SelectGroup")?></span></a></dt>
        <dd>
            <ul>
                <li><a id="<?php echo pg_fetch_result($dsUG1, 0, "id")?>" href="#">&nbsp;<?php echo pg_fetch_result($dsUG1, 0, "name")?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 18px; height: 18px; background-color: <?php echo pg_fetch_result($dsUG1, 0, "fillcolor")?>; position: relative; float: left;"></div></a></li>
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
    <input type="button" id="AddGroup1" style="left: 30px; top: 15px;" onclick="AddGroup('0')" value="+" />
    <br />
	<div style="width:620px; height:180px; background-color:#c6d7f2; border:1px solid #95b1d7; overflow-h:hidden; overflow-y:auto">
        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-size: 11px">
		<?php
			$strVehcileID = "";
			$dsvv = query("select cast(code as integer), id, registration from vehicles where clientid=".session("client_id")." order by code");
            while ($row = pg_fetch_array($dsvv))
            {
            	$strVehcileID .= ",".$row["id"];
		?>
            <tr>
                <td><strong>(<?php echo $row["code"]?>) <?php echo $row["registration"]?></strong></td>
                <td><label><input type="checkbox" id="av_<?php echo $row["id"]?>" /><?php echo dic("Tracking.AllowedInGeoFence")?></label></td>
                <td><label><input type="checkbox" id="in_<?php echo $row["id"]?>"/><?php echo dic("Tracking.AlertEnter")?></label></td>
                <td><label><input type="checkbox" id="out_<?php echo $row["id"]?>"/><?php echo dic("Tracking.AlertExit")?></label></td>
            </tr>
		<?php
			}
			if (strlen($strVehcileID)>0) {
				$strVehcileID = substr($strVehcileID,1);	
			}
		?>
        </table>
	</div>
	<label><input type="checkbox" id="chk_1_in" /><?php echo dic("Tracking.AlertAllowEnter")?></label><br />
	<label><input type="checkbox" id="chk_1_out"/><?php echo dic("Tracking.AlertAllowExit")?></label><br />
	<label><input type="checkbox" id="chk_2_in" /><?php echo dic("Tracking.AlertNotAllowEnter")?></label><br />
	<label><input type="checkbox" id="chk_2_out"/><?php echo dic("Tracking.AlertNotAllowExit")?></label><br />
	<div style="display:block; height:10px"></div>

	<strong><?php echo dic("Tracking.AlertEmail")?>: <span style="font-size:10px; color:#666">(<?php echo dic("Tracking.Example")?>: John@google.com, Marc@yahoo.com)</span>:</strong><br />
	<input id="txt_emails" type="text" value="" class="textboxcalender corner5 text5" style="width:622px; height:22px; font-size:11px"/><br />
	<div style="display:block; height:10px"></div>
	<strong><?php echo dic("Tracking.AlertPhone")?>: <span style="font-size:10px; color:#666">(<?php echo dic("Tracking.MacExample")?>: 075100000, 071100000)</span>:</strong><br />
	<input id="txt_phones" type="text" value="" class="textboxcalender corner5 text5" style="width:622px; height:22px; font-size:11px"/><br />
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
<?php

	$sqlStyles = "";
	
	$sqlStyles .= "SELECT c1.name engineon, c2.name engineoff, c3.name engineoffpassengeron, c4.name satelliteoff, c5.name taximeteron, c6.name taximeteroffpassengeron, c7.name passiveon, c8.name activeoff ";
	$sqlStyles .= "from users us ";
	$sqlStyles .= "left outer join statuscolors c1 on c1.id=us.engineon ";
	$sqlStyles .= "left outer join statuscolors c2 on c2.id=us.engineoff ";
	$sqlStyles .= "left outer join statuscolors c3 on c3.id=us.engineoffpassengeron ";
	$sqlStyles .= "left outer join statuscolors c4 on c4.id=us.satelliteoff ";
	$sqlStyles .= "left outer join statuscolors c5 on c5.id=us.taximeteron ";
	$sqlStyles .= "left outer join statuscolors c6 on c6.id=us.taximeteroffpassengeron ";
	$sqlStyles .= "left outer join statuscolors c7 on c7.id=us.passiveon ";
	$sqlStyles .= "left outer join statuscolors c8 on c8.id=us.activeoff ";
	$sqlStyles .= "where us.id=".session("user_id");
	
	
	$dsSt = query($sqlStyles);

?>
</html>


<script type="text/javascript">
   var lang = '<?php echo $cLang ?>';
   
    //Marjan
    $("#gfGroup dd ul li a").click(function() {
        var text = $(this).html();
        $("#gfGroup dt a")[0].title = this.id;
        document.getElementById("groupidTEst").title = this.id;
        $("#gfGroup dt a span").html(text);
        $("#gfGroup dd ul").hide();
        //$("#result").html("Selected value is: " + getSelectedValue("sample"));
    });
    
    $('#div-mainalerts').css({ height: (document.body.clientHeight - 75) + 'px' });
    
    $('#race-img').css({ top: (document.body.clientHeight / 2 - 35) + 'px' });
    $(".dropdown dt a").click(function() {
        $(".dropdown dd ul").toggle();
    });
    $(".dropdown dd ul li a").click(function() {
        var text = $(this).html();
        $(".dropdown dt a")[0].title = this.id;
        document.getElementById("groupidTEst").title = this.id;
        $(".dropdown dt a span").html(text);
        $(".dropdown dd ul").hide();
        //$("#result").html("Selected value is: " + getSelectedValue("sample"));
    });
    
    $(".dropdownRadius dt a").click(function() {
        $(".dropdownRadius dd ul").toggle();
    });
    $(".dropdownRadius dd ul li a").click(function() {
        var text = $(this).html();
        $(".dropdownRadius dt a")[0].title = this.id;
        
        $(".dropdownRadius dt a span").html(text);
        $(".dropdownRadius dd ul").hide();
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


	legendStr = '<table border="0" cellpadding="0" cellspacing="0" width="200px">'
	legendStr = legendStr + '<tr><td width="20px" height="20px" colspan="2" class="text3"><?php echo dic("Tracking.Legend")?></td></tr>'
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "EngineON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.EngineOn")?></td></tr>'
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "EngineOFF")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.EngineOff")?></td></tr>'
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><img style="height: 14px; width: 14px; top: 0px; position: relative; left: 0px;" src="../images/nosignal.png"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.LowSat")?></td></tr>'
	var CTUD = '<?php echo $ClientTypeID ?>';
    
    if(parseInt(CTUD, 10) == 2)
    {
		legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "EngineOFFPassengerON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.EngineOffPassOn")?></td></tr>'
		legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "TaximeterON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.Engaged")?></td></tr>'
		legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "TaximeterOFFPassengerON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.TaxOffPassOn")?></td></tr>'
		legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<?php echo pg_fetch_result($dsSt, 0, "PassiveON")?>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2"><?php echo dic("Tracking.TaxOn")?></td></tr>'
	}
	legendStr = legendStr + '</table>'

    StartLat = '<?php echo $sLat?>';
    StartLon = '<?php echo $sLon?>';

    var _userId = '506';
	setLiveHeightAlarm();
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
    CreateBoards()

    LoadMaps();
    //LoadPOIbyID('217190');


</script>