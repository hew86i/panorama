<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php header("Content-type: text/html; charset=utf-8"); ?>
<?php
    opendb();

    $uid = Session("user_id");
    $cid = Session("client_id");
    $ClientType = "";
    $sqlV = "";

    $Allow = getPriv("generalsettings", $uid);
    if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
    $dsCT = query("select ClientTypeID from clients where id = ". $cid);
    if (pg_num_rows($dsCT) > 0) {
        $ClientType = nnull(pg_fetch_result($dsCT, 0, 0)."", "1");
    }
    if(is_numeric(nnull($uid)) == false){
      echo header ("Location: ../sessionexpired/?l=" . $cLang);
    }
    if (Session("Role_id") == "2"){
        $sqlV = "select id from vehicles where clientID=" . $cid;
    }
    else{
        $sqlV = "select vehicleID from UserVehicles where userID=" . $uid . "";
    }

    if (dlookup("SELECT count(*) FROM vehicledetailscolumns where userid = " . $uid) == 0) {
        if ($ClientType == 2) {
            $r = runSQL("insert into vehicledetailscolumns (userid, clientid) values(".$uid.", ".$cid .")");
        } else {
            $r = runSQL("insert into vehicledetailscolumns (userid, clientid, ddriver, dtime, dodometer, dspeed, dlocation, dpoi, dzone, dntours, dprice, dtaximeter, dpassengers)
            values(".$uid.", ".$cid.", '1', '1', '1', '1', '1', '1', '1', '0', '0', '0', '0')");
        }
    }
    $dsSett = query("select * from users where id = " . session("user_id"));

    $dsVehDetCol = query("SELECT * FROM vehicledetailscolumns where userid = " . $uid);
    $dsClient = query("SELECT * FROM clients where id = " . $cid);

    $getFullUser = pg_fetch_array($dsSett);  // ke se setira ednas i ke se koristi podolu namesto dsSett
    $getFullVeh = pg_fetch_array($dsVehDetCol);
    $getFullClient = pg_fetch_assoc($dsClient);
?>

<html>
<head>
    <script type="application/javascript">
        lang = '<?php echo $cLang?>';
    </script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">  <!-- [treba da se koristi custom] -->
    <link rel="stylesheet" type="text/css" href="../style.css">
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/settings.js"></script>
    <script type="text/javascript" src="../js/share.js"></script>
    <script type="text/javascript" src="../js/OpenLayers.js"></script>
    <link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
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
    .va {
      display: flex;
      flex-direction: row;
    }

    .va > [class^="col-"],
    .va > [class*=" col-"] {
      display: flex;
      align-items: center;
    }

    .row {
        font-family:Arial, Helvetica, sans-serif;
        font-size:12px;
        color:#2f5185;
        text-decoration: none;
        padding-top: 15px;
        padding-left: 25px;
        font-weight: bold;
    }
    .fwn {
        font-weight: normal;
    }
    .ntp {
        padding-top: 4px;
    }
    .taxi-cena {
        color: #2F5185;
        font-family: Arial,Helvetica,sans-serif; font-size: 11px;
        height:25px;
        border: 1px solid #CCCCCC;
        border-radius: 5px 5px 5px 5px;
        width:161px; padding-left:5px;
    }
    .naslov-red {
        font-size: large;
    }
    .fixed{
      top:0;
      position:fixed;
      width:auto;
      display:none;
      border:none;
    }
    .pl {float:left !important;}
    .pr {float:right !important;}

    .ui-dialog-titlebar-close {
        visibility: hidden;
    }
    </style>

<script>
/*function resizeTbl(){
    scrolify($('#tb_culture'));
    scrolify($('#tb_operation'));
    scrolify($('#tb_material'));
    scrolify($('#tb_mechanisation'));
}
$( document ).ready(function() {
    resizeTbl();
});*/
</script>

</head>
<body>
<div class="container-fluid">
    <!-- *************************** OPSTI PODESUVANJA I KOPCHINJA ******************************************** -->
    <div class="row">
      <div class="col-xs-4 naslov-red">
            <?php echo strtoupper(dic("Settings.GeneralSett"))?>
      </div>
      <div class="col-xs-7">
            <div class="pr">
                <button id="btnUpdate"  onclick="ResetUserSettings('<?php echo $getFullUser["id"]?>') "><?php dic("Settings.DefaultValuesLTRMenu")?></button>
                <button id="btnSave"  onclick="AddUserSettings()"><?php dic("Settings.SaveSettings")?></button>
            </div>
      </div>
    </div>
    <p></p>
    <!-- [vtor_red] -->
    <div class="row va">
        <div class="col-xs-2">  <!-- [grad label]  -->
             <?php echo dic("Tracking.City"); ?>
        </div>
        <div class="col-xs-2">  <!-- [drop down grad] -->
            <select id="city" onchange="promeni()" class="combobox text2" style="width: 161px; font-size: 12px; position: relative; top: 0px; z-index: 999; visibility: visible;">
                <option id="0" value="0"><?php echo dic("Admin.SelectCity") ?></option>
            <?php
                $ds1=query("select * from cities where countryid = (select countryid from cities where id=".$getFullUser["cityid"].")");
                while($dr = pg_fetch_array($ds1))
                {
                    $restOption = ' id="'. $dr["id"] . '" value="' . $dr["countryid"] . '"'; ?>
                        <option <?php echo ((($dr["id"] == $getFullUser["cityid"]) ? "selected" : "") . $restOption); ?>><?php echo transliterate($dr["name"],$cLang) ?></option>
                <?php  //end while
                }
            ?>
            </select>
            &nbsp;<button id="addCity" onclick="addCity()" style="height:27px; width:28px"></button>
        </div>
        <div class="col-xs-2">  <!-- [labela mapa] -->
           <?php strtoupper(dic("Settings.DefMap"))?>
        </div>
        <div class="col-xs-5">  <!-- [radio mapa] -->
           <div id="Def-Map">
            <?php $DefMap = $getFullUser["defaultmap"]; ?>
                <input type="radio" id="DMRadio1" name="radio" value="GOOGLEM" <?php echo (($DefMap == "GOOGLEM") ? "checked='checked'" : ""); ?> /><label for="DMRadio1"><?php if($DefMap == "GOOGLEM"){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;  Google <?php }else{?>Google<?php }?></label>
                <input type="radio" id="DMRadio2" name="radio" value="OSMM" <?php echo (($DefMap == "OSMM") ? "checked='checked'" : ""); ?> /><label for="DMRadio2"><?php if($DefMap == "OSMM"){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp; OSM <?php }else{?>OSM<?php }?></label>
                <input type="radio" id="DMRadio3" name="radio" value="BINGM" <?php echo (($DefMap == "BINGM") ? "checked='checked'" : ""); ?> /><label for="DMRadio3"><?php if($DefMap == "BINGM"){?> <img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;  Bing <?php }else{?>Bing<?php }?></label>
                <input type="radio" id="DMRadio4" name="radio" value="YAHOOM" <?php echo (($DefMap == "YAHOOM") ? "checked='checked'" : ""); ?> /><label for="DMRadio4"><?php if($DefMap == "YAHOOM"){?> <img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp; Geonet <?php }else{?>Geonet<?php }?></label>
                <input type="radio" id="DMRadio5" name="radio" value="GOOGLES" <?php echo (($DefMap == "GOOGLES") ? "checked='checked'" : ""); ?> /><label for="DMRadio5"><?php if($DefMap == "GOOGLES"){?> <img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp; Satellite <?php }else{?>Satellite<?php }?></label>
            </div>
        </div>
    </div>  <!-- [vtor_red].END -->

    <!-- [tret_red] -->
    <div class="row va">
        <div class="col-xs-2">  <!-- [country label]  -->
           <?php echo dic("Tracking.Country")?>
        </div>
        <div class="col-xs-2">  <!-- [drop down country ] -->
            <select id="country" class="combobox text2" disabled="disabled">
                <option value="0"><?php echo dic("Tracking.Country") ?></option>
                <?php
                    $ds3=query("select * from countries order by name");
                    while($dr = pg_fetch_array($ds3))
                    {
                ?>
                        <option value="<?=$dr["id"]?>"><?= transliterate($dr["name"],$cLang)?></option>
                <?php
                    }
                ?>
            </select>
        </div>
        <div class="col-xs-2">  <!-- [labela date time] -->
            <?php strtoupper(dic("Settings.TimeFormat"))?>
        </div>
        <div class="col-xs-3">  <!-- [drop down date time] -->
            <select id="cbDate" class="combobox text2">
                <?php $dat = explode(" ", $getFullUser["datetimeformat"]); ?>    <!-- dat[0] e fomatot na datumot a dat[1] e formatot na vremeto -->
                    <option value="d-m-Y" <?php echo (($dat[0] == "d-m-Y") ? "selected='selected'" : ""); ?>>dd-MM-yyyy</option>
                    <option value="Y-m-d" <?php echo (($dat[0] == "Y-m-d") ? "selected='selected'" : ""); ?>>yyyy-MM-dd</option>
                    <option value="m-d-Y" <?php echo (($dat[0] == "m-d-Y") ? "selected='selected'" : ""); ?>>MM-dd-yyyy</option>
            </select>&nbsp;
            <select id="cbTime" class="combobox text2">
                 <option value="24 Hour Time" <?php echo (($dat[1] == "H:i:s") ? "selected='selected'" : ""); ?>><?php dic("Settings.24Time")?></option>
                 <option value="12 Hour Time" <?php echo (($dat[1] == "h:i:s") ? "selected='selected'" : ""); ?>><?php dic("Settings.12Time")?></option>
            </select>
        </div>
    </div>  <!-- [tret_red].END -->

    <!-- [chetvrt_red] -->
    <div class="row va">
        <div class="col-xs-2">  <!-- [labela snooze] -->
            <?php dic("Settings.SnoozeRepetition")?>
        </div>
        <div class="col-xs-2">  <!-- [snooze drop down] -->
            <select id = "Snooze" style="font-size: 11px; position: relative; top: 0px ;visibility: visible;" class="combobox text2">
                <?php $snoozeTime = explode(" ", $getFullUser["snooze"]); ?>
                <option value = "0" <?php echo (($snoozeTime[0] == "0") ? "selected='selected'" : ""); ?> ><?php echo dic("Settings.NoRepetition")?></option>
                <?php
                for($i=2; $i<=10; $i=$i+2) {
                        echo "<option value=\"" . $i . "\" " . (($snoozeTime[0] == $i) ? "selected='selected'" : "") . ">" . $i . " " . dic_("Reports.Minutes") . "</option>";
                 } ?>
             </select>
        </div>
        <div class="col-xs-2">  <!-- [labela snooze volume] -->
            <?php dic("Settings.SnoozeVolume")?>
        </div>
        <div class="col-xs-2">  <!-- [snooze volume drop down] -->
            <select id="snoozevolume" style="font-size: 11px; position: relative; top: 0px ;visibility: visible;" class="combobox text2">
                <?php $snzv = $getFullUser["snoozevolume"];
                for($i=0; $i<=10; $i++) {
                    echo "<option value=\"" . $i . "\" " . (($snzv == $i) ? "selected='selected'" : "") . ">" . $i . "</option>";
             } ?>
             </select>
        </div>
    </div>  <!-- [chetvrt_red].END -->

</div>  <!-- [END] OPSTI PODESUVANJA I KOPCHINJA -->
    <!--p></p>  <!-- igra uloga na spacing pred linijata za podelba -1 -->
    <!--div style="border-top:1px dotted #95B1d7"></div-->

<div class="container-fluid">
    <!-- *************************** MERNI EDINICI ******************************************** -->
    <!--div class="row va">
        <div class="col-xs-6 naslov-red">
            <?php echo strtoupper(dic("Settings.UnitMeasurements"))?>   <!-- NASLOV MERNI EDINICI -->
        <!--/div>
    </div>
    <p></p-->    <!-- [spacing line] tamu se koristi &nbsp;-->

    <!-- [vtor_red] -->
    <div class="row va">
        <div class="col-xs-2">  <!-- [labela] -->
            <?php strtoupper(dic("Settings.LiquidUnit"))?>
        </div>
        <div class="col-xs-2">  <!-- [litar galon] -->
            <select id = "tecnost"  class="combobox text2">
                <?php $LU= explode(" ", $getFullUser["liquidunit"]); ?>
                    <option value = "litar" <?php echo (($LU[0] == "litar") ? "selected='selected'" : ""); ?>><?php dic("Settings.Litres")?></option>
                    <option value = "galon" <?php echo (($LU[0] == "galon") ? "selected='selected'" : ""); ?>><?php dic("Settings.Gallons")?></option>
            </select>
        </div>
        <div class="col-xs-2">  <!-- [rastojanie label]  -->
            <?php strtoupper(dic("Settings.DistRep"))?>
        </div>
        <div class="col-xs-4">  <!-- [imperial metric] -->
            <select id = "Kilometri"  class="combobox text2">
                <?php $kilometri= explode(" ", $getFullUser["metric"]); ?>
                <option value = "Km" <?php echo (($kilometri[0] == "Km") ? "selected='selected'" : ""); ?>><?php dic("Settings.Metric")?> (km; km/h)</option>
                <option value = "mi" <?php echo (($kilometri[0] == "mi") ? "selected='selected'" : ""); ?>><?php dic("Settings.Imperial")?> (mile; mph)</option>
            </select>
        </div>
    </div>  <!-- [vtor_red].END -->

    <!-- [tret_red] -->
    <div class="row va">
        <div class="col-xs-2">  <!-- [labela valuta] -->
            <?php dic("Settings.Currency")?>
        </div>
        <div class="col-xs-2">  <!-- [drop down za valuta] -->
            <select id = "valuta" class="combobox text2">  <!-- DA SE PREPRAVI VO LOOP -->
                <?php
                    $CM = explode(" ", $getFullUser["currency"]);
                    $dsCurrency = query("select * from currency");
                    while ($drCurrency = pg_fetch_array($dsCurrency)) {
                    ?>
                        <option value="<?php echo $drCurrency['name']; ?>" <?php echo (($CM[0] == $drCurrency["name"]) ? "selected='selected'" : ""); ?>><?php dic($drCurrency['title'])?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-xs-2">  <!-- drop down za temperatura -->
            <?php dic("Settings.Temperature")?>
        </div>
        <div class="col-xs-3">
            <select name="temperatura" id="temperatura" class="combobox text2">
                <option value="C" <?php echo (($getFullUser['tempunit'] == 'C') ? "selected='selected'" : ""); ?>> °C </option>
                <option value="F" <?php echo (($getFullUser['tempunit'] == 'F') ? "selected='selected'" : ""); ?>> °F </option>
            </select>
        </div>
    </div>  <!-- [tret_red].END -->

    <!-- [chetvrt_red] -->
    <div class="row va">
        <!-- tuka ke se dodade novo podesuvanje -->
        <div class="col-xs-2"></div>
        <div class="col-xs-2"></div>

        <div class="col-xs-2">  <!-- [seledenje vo zivo label]  -->
            <?=dic_("Settings.AfterLogIn")?>
        </div>
        <div class="col-xs-3">  <!-- [radio za directlive ] -->
            <div id="div-directlive">
                <?php $directlive_ = pg_fetch_result($dsSett, 0, "directlive"); ?>
                <input type="radio" id="DMRadioDL1" name="radioDL" value="0" <?php echo (($directlive_) ? "" : "checked='checked'"); ?> /><label for="DMRadioDL1"><?=dic_("Settings.HomePage")?></label>
                <input type="radio" id="DMRadioDL2" name="radioDL" value="1" <?php echo (($directlive_) ? "checked='checked'" : ""); ?> /><label for="DMRadioDL2"><?= dic_("Settings.LiveTracking")?></label>
                <!--input type="checkbox" id="directlive" <?php echo (($directlive_) ? "checked='checked'" : "") ?>/><label for="directlive"><?php if($directlive_ == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?php dic("directlive")?> <?php }else{?> <?php dic("directlive")?> <?php }?></label-->
            </div>
        </div>
    </div>

</div>  <!-- [END] MERNI EDINICI -->

<p></p>  <!-- igra uloga na spacing pred linijata za podelba -2 -->
<div style="border-top:1px dotted #95B1d7"></div>

<div class="container-fluid">
    <!-- *************************** SLEDENJE VO ZIVO ******************************************** -->
    <div class="row va">
      <div class="col-xs-6 naslov-red">
            <?php strtoupper(dic("Settings.LiveTracking")); ?>   <!-- NASLOV SLEDENJE VO ZIVO -->
      </div>
    </div>
    <p></p>
    <!-- [vtor_red] -->
    <div class="row va">
        <div class="col-xs-2">  <!-- [labela traga] -->
            <?php strtoupper(dic("Settings.Trace"))?>
        </div>
        <div class="col-xs-2">  <!-- [sledenje minuti] -->
            <select id="TimeTrack" class="combobox text2">
                <?php $TT = explode(" ", $getFullUser["trace"]);
                    for ($i=10; $i <=180; $i=$i+10) {
                        echo '<option value="' . $i . '" ' . (($TT[0] === (string)$i) ? "selected='selected'" : "") . '>' . $i . '</option>';
                    }
                ?>
            </select>
            &nbsp;<span style="font-weight:normal"><?php echo dic_("Settings.Min")?></span>
        </div>
        <div class="col-xs-8">  <!-- [check btn za tracking ]  -->
            <div id="LiveTracking">
                <?php
                    $datet = $getFullUser["timedate"];
                    $sped = $getFullUser["speed"];
                    $loca = $getFullUser["location"];
                    $po = $getFullUser["poi"];
                ?>
                <input type="checkbox" id="datetime" <?php echo (($datet) ? "checked='checked'" : "" ); ?>/><label for="datetime"><?php if($datet == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?php dic("Settings.DateTime")?> <?php }else{?> <?php dic("Settings.DateTime")?> <?php }?> </label>
                <input type="checkbox" id="speed" <?php echo (($sped) ? "checked='checked'" : "" ); ?>/><label for="speed"><?php if($sped == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp; <?php dic("Settings.Speed")?> <?php }else{?>  <?php dic("Settings.Speed")?> <?php }?></label>
                <input type="checkbox" id="location" <?php echo (($loca) ? "checked='checked'" : "" ); ?>/><label for="location"><?php if($loca == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?php dic("Settings.Location")?> <?php }else{?>  <?php dic("Settings.Location")?> <?php }?></label>
                <input type="checkbox" id="poi" <?php echo (($po) ? "checked='checked'" : "" ); ?>/><label for="poi"><?php if($po == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?php strtoupper(dic("Settings.Poi1"))?> <?php }else{?>  <?php strtoupper(dic("Settings.Poi1"))?> <?php }?></label>
            </div>
        </div>
    </div>  <!-- [vtor_red].END -->

    <!-- [tret_red] -->
    <div class="row va">
        <div class="col-xs-2">  <!-- [labela rabota vo mesto] -->
            <?php dic("Settings.IdleWorking")?>
        </div>
        <div class="col-xs-2">  <!-- [drop down rabota vo mesto min] -->
            <select id="idleOverTime" class="combobox text2">
                <?php
                    $TTO = explode(" ", $getFullUser["idleover"]); ?>
                    <option value="0" <?php echo (($TTO[0]) ? "selected='selected'" : ""); ?>>None</option>
                    <?php
                        for($i=1; $i<=10; $i++) {
                        echo '<option value="' . $i . '" ' . (($TTO[0] === (string)$i) ? "selected='selected'" : "") . ' >' . dic_("Settings.MoreThan") . ' ' . $i . '</option>';
                        }
                    ?>
            </select>
            &nbsp;<span style="font-weight:normal"><?php echo dic_("Settings.Min")?></span>
        </div>
        <div class="col-xs-8">  <!-- []  -->
            <div id="LiveTracking1">
                <?php
                    $zon = $getFullUser["zone"];
                    $pas = $getFullUser["passengers"];
                    $tax = $getFullUser["taximeter"];
                    $ful = $getFullUser["fuel"];
                    $weather = $getFullUser["weather"];
                ?>
                    <input type="checkbox" id="zone" <?php echo (($zon) ? "checked='checked'" : ""); ?>/><label for="zone"><?php if($zon == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?php dic("Settings.Zone")?> <?php }else{?>  <?php dic("Settings.Zone")?> <?php }?></label>
                <?php if($ClientType == "2"){ ?>
                    <input type="checkbox" id="passengers" <?php echo (($pas) ? "checked='checked'" : ""); ?>/><label for="passengers"><?php if($pas == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?php dic("Settings.Passengers")?> <?php }else{?> <?php dic("Settings.Passengers")?> <?php }?></label>
                    <input type="checkbox" id="taximeter" <?php echo (($tax) ? "checked='checked'" : ""); ?>/><label for="taximeter"><?php if($tax == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?php dic("Settings.Taximeter")?> <?php }else{?> <?php dic("Settings.Taximeter")?> <?php }?></label>
                <?php } ?>
                    <!-- del za taximeter hidden input -->
                    <input type="checkbox" id="fuel" <?php echo (($ful) ? "checked='checked'" : ""); ?>/><label for="fuel"><?php if($ful == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?php dic("Settings.Fuel")?> <?php }else{?> <?php dic("Settings.Fuel")?> <?php }?></label>
                    <input type="checkbox" id="weather" <?php echo (($weather) ? "checked='checked'" : ""); ?>/><label for="weather"><?php if($weather == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?php dic("WeatherForecast")?> <?php }else{?> <?php dic("WeatherForecast")?> <?php }?></label>
                </div>
        </div>
    </div>  <!-- [tret_red].END -->

        <!-- [chetvrt_red] -->
    <div class="row va">
        <div class="col-xs-2"></div>
        <div class="col-xs-2"></div>

        <div class="col-xs-8">
            <?php
                $dForecast_ = $getFullVeh["dforecast"];
                $dDriver_ = $getFullVeh["ddriver"];
                $dTime_ = $getFullVeh["dtime"];
                $dOdometer_ = $getFullVeh["dodometer"];
                $dSpeed_ = $getFullVeh["dspeed"];
                $dLocation_ = $getFullVeh["dlocation"];
                $dPoi_ = $getFullVeh["dpoi"];
                $dZone_ = $getFullVeh["dzone"];
                if($ClientType == "2"){
                    $dNTours_ = $getFullVeh["dntours"];
                    $dPrice_ = $getFullVeh["dprice"];
                    $dTaximeter_ = $getFullVeh["dtaximeter"];
                    $dPassengers_ = $getFullVeh["dpassengers"];
                }
                ?>
            <div id="detailVehicles">
                        <?php echo dic("Tracking.VehDetails") ?><br>
                        <input type="checkbox" id="detailForecast" <?php echo (($dForecast_) ? "checked='checked'" : ""); ?>/><label for="detailForecast"><?php if($dForecast_ == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?= dic_("currdataweather")?> <?php }else{?> <?= dic_("currdataweather")?> <?php }?></label>
                        <input type="checkbox" id="detailDriver" <?php echo (($dDriver_) ? "checked='checked'" : ""); ?>/><label for="detailDriver"><?php if($dDriver_ == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?= dic_("Reports.Driver")?> <?php }else{?> <?= dic_("Reports.Driver")?> <?php }?></label>
                        <input type="checkbox" id="detailTime" <?php echo (($dTime_) ? "checked='checked'" : ""); ?>/><label for="detailTime"><?php if($dTime_ == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?= dic_("Time")?> <?php }else{?> <?= dic_("Time")?> <?php }?></label>
                        <input type="checkbox" id="detailOdometer" <?php echo (($dOdometer_) ? "checked='checked'" : ""); ?>/><label for="detailOdometer"><?php if($dOdometer_ == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?= dic_("Reports.Odometer")?> <?php }else{?> <?= dic_("Reports.Odometer")?> <?php }?></label>
                        <input type="checkbox" id="detailSpeed" <?php echo (($dSpeed_) ? "checked='checked'" : ""); ?>/><label for="detailSpeed"><?php if($dSpeed_ == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?= dic_("Speed")?> <?php }else{?> <?= dic_("Speed")?> <?php }?></label>
                        <input type="checkbox" id="detailLocation" <?php echo (($dLocation_) ? "checked='checked'" : ""); ?>/><label for="detailLocation"><?php if($dLocation_ == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?= dic_("Reports.Location")?> <?php }else{?> <?= dic_("Reports.Location")?> <?php }?></label>
                        <input type="checkbox" id="detailPoi" <?php echo (($dPoi_) ? "checked='checked'" : ""); ?>/><label for="detailPoi"><?php if($dPoi_ == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?= dic_("Settings.Poi1")?> <?php }else{?> <?= dic_("Settings.Poi1")?> <?php }?></label>
                        <input type="checkbox" id="detailZone" <?php echo (($dZone_) ? "checked='checked'" : ""); ?>/><label for="detailZone"><?php if($dZone_ == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?= dic_("GeoFence")?> <?php }else{?> <?= dic_("GeoFence")?> <?php }?></label>
                        <?php
                        if($ClientType == "2"){
                        ?>
                            <br>
                            <input type="checkbox" id="detailNTours" <?php echo (($dNTours_) ? "checked='checked'" : ""); ?>/><label for="detailNTours"><?php if($dNTours_ == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?= dic_("Reports.NoTours1")?> <?php }else{?> <?= dic_("Reports.NoTours1")?> <?php }?></label>
                            <input type="checkbox" id="detailPrice" <?php echo (($dPrice_) ? "checked='checked'" : ""); ?>/><label for="detailPrice"><?php if($dPrice_ == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?= dic_("Reports.Price")?> <?php }else{?> <?= dic_("Reports.Price")?> <?php }?></label>
                            <input type="checkbox" id="detailTaximeter" <?php echo (($dTaximeter_) ? "checked='checked'" : ""); ?>/><label for="detailTaximeter"><?php if($dTaximeter_ == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?= dic_("Reports.Taximeter")?> <?php }else{?> <?= dic_("Reports.Taximeter")?> <?php }?></label>
                            <input type="checkbox" id="detailPassengers" <?php echo (($dPassengers_) ? "checked='checked'" : ""); ?>/><label for="detailPassengers"><?php if($dPassengers_ == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?= dic_("Reports.Passengers")?> <?php }else{?> <?= dic_("Reports.Passengers")?> <?php }?></label>
                        <?php
                       }
                    ?>
            </div>
        </div>
    </div>  <!-- [chetvrt_red].END -->

    <!-- [petti_red] -->
    <?php
        $KenbasIma = dlookup("select count(*) from vehicles where clientid = " . $cid." and allowcanbas='1'");
        if($KenbasIma>0){
        ?>
        <input id = "canbasIma" type="text" style="display:none" value= "<?php echo $KenbasIma?>"></input>
    <div class="row va ntp" style="padding-top:15px">
        <div class="col-xs-2"></div>
        <div class="col-xs-2"></div>
        <div class="col-xs-8">  <!-- [checkbox btn CAN] -->
            <?php
                $cfuel = $getFullUser["cbfuel"];
                $crpm = $getFullUser["cbrpm"];
                $ctemperature = $getFullUser["cbtemp"];
                $cdistance = $getFullUser["cbdistance"];
            ?>
            <div id = "kenbas">
                CAN bus<br>
                <input type="checkbox" id="cbFuel" <?php echo (($cfuel) ? "checked='checked'" : ""); ?>/><label for="cbFuel"><?php if($cfuel == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?php dic("Settings.Fuel")?> <?php }else{?> <?php dic("Settings.Fuel")?> <?php }?></label>
                <input type="checkbox" id="RPM" <?php echo (($crpm) ? "checked='checked'" : ""); ?>/><label for="RPM"><?php if($crpm == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;RPM <?php }else{?> RPM <?php }?></label>
                <input type="checkbox" id="Temperature" <?php echo (($ctemperature) ? "checked='checked'" : ""); ?>/><label for="Temperature"><?php if($ctemperature == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?php dic("Tracking.Temp")?> <?php }else{?> <?php dic("Tracking.Temp")?> <?php }?></label>
                <input type="checkbox" id="Distance1" <?php echo (($cdistance) ? "checked='checked'" : ""); ?>/><label for="Distance1"><?php if($cdistance == 1){?><img src = "../images/stikla1.png" width="10px" height="10px"></img>&nbsp;<?php dic("Reports.PominatoRastojanie1")?> <?php }else{?> <?php dic("Reports.PominatoRastojanie1")?>  <?php }?></label>
            </div>
        <?php
        }  // [END].php $KenbasIma ------------
        ?>
        </div>
    </div>  <!-- [petti_red].END -->

</div>  <!-- [END] SLEDENJE VO ZIVO -->
    <p></p>  <!-- igra uloga na spacing pred linijata za podelba -3 -->
    <div style="border-top:1px dotted #95B1d7"></div>

<div class="container-fluid">
    <!-- *************************** BOI I STATUS NA VOZILA ******************************************** -->
    <div class="row">
        <div class="col-xs-6 naslov-red">
            <?php strtoupper(dic("Settings.VehColors"))?>
        </div>
        <div class="col-xs-4">
            <div class="pl">    <!-- se proveruva dali korisnikot e taxi kompanija i se zadava soodvetnata funcija na noclick() -->
                <button id = "reset1" onclick="<?php echo (($ClientType == "2") ? "ResetDefaultsTaxi()" : "ResetDefaults()"); ?>"><?php dic("Settings.DefaultValues")?></button>
            </div>
        </div>
    </div>
    <p></p>    <!-- [spacing line] tamu se koristi &nbsp;-->
    <!-- [vtor_red] -->
    <div class="row va ntp">
        <div class="col-xs-2 fwn">  <!-- [labela motor on] -->
           <?php dic("Settings.EngineOn")?>
        </div>
        <div class="col-xs-2 ">  <!-- [motor boja drop down] -->
            <select id="EONColor" class="combobox text2">
                <?php
                $retData = explode(" ", $getFullUser["engineon"]);
                $dsCl=query("select * from colors order by id");
                while($dr = pg_fetch_array($dsCl)) { ?>
                    <option value="<?=$dr['id']?>" <?php echo (($retData[0] == $dr["id"]) ? "selected='selected'" : "") ?>><?php dic($dr["title"])?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-xs-2 fwn">  <!-- [motor off label]  -->
            <?php dic("Settings.EngineOff")?>
        </div>
        <div class="col-xs-2">  <!-- [motor off boja drop down] -->
            <select id="EOFFColor" class="combobox text2">
                <?php
                $retData = explode(" ", $getFullUser["engineoff"]);
                $dsCl=query("select * from colors order by id");
                while($dr = pg_fetch_array($dsCl)) { ?>
                    <option value="<?=$dr['id']?>" <?php echo (($retData[0] == $dr["id"]) ? "selected='selected'" : "") ?>><?php dic($dr["title"])?></option>
                <?php } ?>
            </select>
        </div>
    </div>  <!-- [vtor_red].END -->

    <!-- [tret_red] -->
    <div class="row va ntp">
        <?php
            if ($ClientType == "2") { 
        ?>   
        <div class="col-xs-2 fwn">  <!-- [labela motor isklucen patnici ili slabi sateliti ] -->
           <?php echo dic("Settings.EngineOffPassOn")?>
        </div>
        <div class="col-xs-2">  <!-- [ motor isklucen ili slabi sateliti patnici drop down] -->
            
             <select id='EOFF-PON-Color' class="combobox text2">
                <?php
                $retData = explode(" ", ($getFullUser["engineoffpassengeron"]));
                $dsCl=query("select * from colors order by id");
                while($dr = pg_fetch_array($dsCl)) { ?>
                    <option value="<?=$dr['id']?>" <?php echo (($retData[0] == $dr["id"]) ? "selected='selected'" : "") ?>><?php dic($dr["title"])?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-xs-2 fwn">
           <?php echo dic("Settings.TaxOn")?>
        </div>
        <div class="col-xs-2">  <!-- [motor boja drop down] -->
            <select id="TONColor" class="combobox text2">
                <?php
                $retData = explode(" ", $getFullUser["taximeteron"]);
                $dsCl=query("select * from colors order by id");
                while($dr = pg_fetch_array($dsCl)) { ?>
                    <option value="<?=$dr['id']?>" <?php echo (($retData[0] == $dr["id"]) ? "selected='selected'" : "") ?>><?php dic($dr["title"])?></option>
                <?php } ?>
            </select>
        </div>

         <?php
        }    
        ?>       
    </div>  <!-- [tret_red].END -->
    <?php
        if ($ClientType != "2") { ?>    <!-- ako ne e taxi da se zatrvori divot  -->
</div>  <!-- [END]. BOI I STATUS NA VOZILA TAXI -->
    <p></p>  <!-- igra uloga na spacing pred linijata za podelba -4 -->
    <div style="border-top:1px dotted #95B1d7"></div>

    <!-- **********************************************  TAXI ***************************************************** -->
    <?php
        }
        if($ClientType == "2") {
    ?>
     <!-- ClientType za TAXI DROP DOWN MENIJA VO BOI   *********************************************************** -->
    <!-- [chetvrt_red] -->
    <div class="row va ntp">
        <div class="col-xs-2 fwn ntp">  <!-- [motor off label]  -->
            <?php dic("Settings.TaxOffPassOn")?>
        </div>
        <div class="col-xs-2">  <!-- [motor off boja drop down] -->
            <select id="TOFF-PON-Color" class="combobox text2">
                <?php
                $retData = explode(" ", $getFullUser["taximeteroffpassengeron"]);
                $dsCl=query("select * from colors order by id");
                while($dr = pg_fetch_array($dsCl)) { ?>
                    <option value="<?=$dr['id']?>" <?php echo (($retData[0] == $dr["id"]) ? "selected='selected'" : "") ?>><?php dic($dr["title"])?></option>
                <?php } ?>
            </select>
        </div>

        <div class="col-xs-2 fwn">  <!-- [labela motor on] -->
           <?php dic("Settings.Engaged")?>
        </div>
        <div class="col-xs-2">  <!-- [motor boja drop down] -->
            <select id="EColor" class="combobox text2">
                <?php
                $retData = explode(" ", $getFullUser["passiveon"]);
                $dsCl=query("select * from colors order by id");
                while($dr = pg_fetch_array($dsCl)) { ?>
                    <option value="<?=$dr['id']?>" <?php echo (($retData[0] == $dr["id"]) ? "selected='selected'" : "") ?>><?php dic($dr["title"])?></option>
                <?php } ?>
            </select>
        </div>
    </div>  <!-- [chetvrt_red].END -->
</div>  <!-- [END] BOI I STATUS NA VOZILA TAXI-->

<p></p>  <!-- igra uloga na spacing pred linijata za podelba -5 -->
<div style="border-top:1px dotted #95B1d7"></div>

<div class="container-fluid">
    <!-- *************************** TAXI CENA ******************************************** -->
    <?php
        $dsP =query("SELECT * FROM price where client_id = " . $cid);
        $getPrice = pg_fetch_array($dsP);
        // echo $cid . " ******* ";
        // echo Session('user_id'); die();
        // print_r($getPrice);
        // die();
    ?>
    <div class="row va">
        <div class="col-xs-6 naslov-red">
            <?php echo dic("Settings.TaxiPrice")?>   <!-- NASLOV TAXI CENA -->
        </div>
    </div>
    <p></p>    <!-- [spacing line] tamu se koristi -->
    <!-- [vtor_red] -->
    <div class="row va fwn">
        <div class="col-xs-2">
            <?php echo dic("Settings.Start"); ?>
        </div>
        <div class="col-xs-2">
            <input class="taxi-cena" id="start" onkeyup="CommaToDot(this.id)" value="<?php echo ((pg_num_rows($dsP) == 0) ? "" : $getPrice['start'])?>" />
            <label for="start"></label>&nbsp;<?php echo $getFullUser["currency"]; ?>
        </div>
        <div class="col-xs-2">
             &nbsp;&nbsp;&nbsp;&nbsp;km <?php echo dic("Settings.InStart")?>:
        </div>
        <div class="col-xs-2">
            <input class="taxi-cena" id="km_start" onkeyup="CommaToDot(this.id)" value="<?php echo ((pg_num_rows($dsP) == 0) ? "" : $getPrice['km_start'])?>" />
        </div>
    </div>  <!-- [vtor_red].END -->

    <!-- [tret_red] -->
    <div class="row va fwn">
        <div class="col-xs-2">
           <?php echo dic("Settings.Price")?> km:
        </div>
        <div class="col-xs-2">
            <input class="taxi-cena" id="cena_km" onkeyup="CommaToDot(this.id)" value="<?php echo ((pg_num_rows($dsP) == 0) ? "" : $getPrice['cena_km'])?>" />
            <label for="cena_km"></label>&nbsp;<?php echo $getFullUser["currency"]; ?>
        </div>
        <div class="col-xs-2">
             &nbsp;&nbsp;&nbsp;&nbsp;<?php echo dic_("Settings.WaitPrice")?>:
        </div>
        <div class="col-xs-2">
            <input class="taxi-cena" id="wait_price" onkeyup="CommaToDot(this.id)" value="<?php echo ((pg_num_rows($dsP) == 0) ? "" : $getPrice['waitprice'])?>" />
            <label for="wait_price"></label>&nbsp;<?php echo $getFullUser["currency"]; ?>
        </div>
    </div>  <!-- [tret_red].END -->
</div>  <!-- [END] TAXI CENA -->

    <p></p>  <!-- igra uloga na spacing pred linijata za podelba -51-->
    <div style="border-top:1px dotted #95B1d7"></div>

<?php
    }   // [END].[LN 559] ***************************************** TAXI ****************************************

    // ***************************************** Agricultural mechanization *************************************

    if($cid==367) { // if($ClientTypeID == 4) {    // ova se odesuva na ZKPelagonija [id=367]
    ?>

<p></p>

<div class="container-fluid">
    <div class="row va">    <!-- [red za kopcinja] -->
        <div class="col-xs-5">  <!-- [btn dodadi kultura] -->
            <button id="addCulture" onclick="AddItem('route_culture','Culture')" ><?php dic("Routes.Add")?> <?php echo mb_strtolower(dic_("Settings.Culture"),'UTF-8');?></button>
        </div>
        <div class="col-xs-1"></div>
        <div class="col-xs-5">  <!-- [btn dodadi operacija] -->
            <button id="addOperation" onclick="AddItem('route_operation','Operation')" ><?php dic("Routes.Add")?> <?php echo mb_strtolower(dic_("Settings.Operation"),'UTF-8');?></button>
        </div>
    </div>  <!-- [red za kopcinja].END -->
    <div class="row">    <!-- [red za tableite] -->
        <!-- [tabela dodadi kultura] -->
        <div class="col-xs-5">
            <?php
            $cnt = $i = 1;
            $poi = query("select * from route_culture where clientid = 367 order by id");
        if(pg_num_rows($poi)==0){
        ?>
            <br><br>    <!-- nema podatoci vo baza -->
            <div id="noData" style="padding-left:40px; font-size:30px; font-style:italic; padding-bottom:40px" class="text4">
                <?php dic("Reports.NoData1")?>
            </div>
        <?php
        }
        else
        {
        ?>
        <div style="overflow:scroll; height:390px; overflow:auto;">
            <table id="tb_culture" width="98%" border="0" style="margin-top:5px; margin-right:10px; border-collapse: separate; border-spacing: 2px;">
                <thead>
                    <tr>
                        <td align = "left" valign = "middle" colspan="9" height="22px" width = "100%" class="text2" style="color:#fff; font-weight:bold; font-size:14px;  padding-left:7px; background-color:#f7962b; font-weight:bold;" > <?php dic("Settings.Culture")?></td>
                    </tr>
                    <tr>
                        <td align = "center" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Routes.Rbr")?></td>
                        <td align = "left" width="60%" height="25px" align="center" class="text2" style="padding-left:10px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.Name")?></td>
                        <td align = "center" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Change")?></td>
                        <td align = "center" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Delete")?> </td>
                    </tr>
                </thead>
            <tbody>
        <?php
        $allRows = pg_fetch_all($poi);
            foreach ($allRows as $rowN => $value)
            { ?>
                <tr id = "redKultura<?php echo $value["id"]?>">
                <td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
                    <?php
                        echo $rowN + 1 ;
                    ?>
                </td>
                <td id="redKulturaIme<?php echo $value["id"]?>" align = "left" height="30px" class="text2" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8; ">
                    <?php
                        echo $value["name"];
                    ?>
                </td>
                <td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                    <button id="promeniKult<?php echo ($rowN + 1)?>" onclick = "EditItem(<?= $value["id"] ?>,'route_culture','redKulturaIme<?=$value["id"]?>', 'Culture')" style="height:22px; width:30px"></button>
                </td>
                <td align = "center" cheight="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
                    <button id="izbrisiKult<?php echo ($rowN + 1)?>" onclick = "DelItem(<?= $value["id"] ?>,'route_culture','redKultura<?= $value["id"] ?>','DeleteCultureSure','delEnt')" style="height:22px; width:30px"></button>
                </td>
                </tr>
                <script>
                    var i = Number('<?php echo ($rowN + 1);?>');
                    $('#promeniKult' + i).button({ icons: { primary: "ui-icon-pencil"} });
                    $('#izbrisiKult' + i).button({ icons: { primary: "ui-icon-trash"} });
                </script>
            <?php
            } ?>
                </tbody>
                </table>
        <?php }
        ?>
        </div>  <!--     KRAJ NA KULTURA      [align-left] -->
        </div>  <!-- [END].tabela kultura [row]-->

        <!-- [tabela dodadi operacija] -->
        <div class="col-xs-1"></div>
        <div class="col-xs-5">
         <?php
        $poi = query("select * from route_operation where clientid = 367 order by id");
        if(pg_num_rows($poi)==0){
        ?>
            <br><br>    <!-- nema podatoci vo baza -->
            <div id="noData" style="padding-left:40px; font-size:30px; font-style:italic; padding-bottom:40px" class="text4">
                <?php dic("Reports.NoData1")?>
            </div>
        <?php
        }
        else
        {
        ?>
        <div style="overflow:scroll; height:390px; overflow:auto;">
            <table id="tb_operation" width="98%" border="0" style="margin-top:5px; margin-right:10px; border-collapse: separate; border-spacing: 2px;">
                <thead>
                    <tr>
                        <td align = "left" valign = "middle" colspan="9" height="22px" width = "100%" class="text2" style="color:#fff; font-weight:bold; font-size:14px;  padding-left:7px; background-color:#f7962b; font-weight:bold;" > <?php dic("Settings.Operation")?></td>
                    </tr>
                    <tr>
                        <td align = "center" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Routes.Rbr")?></td>
                        <td align = "left" width="60%" height="25px" align="center" class="text2" style="padding-left:10px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.Name")?></td>
                        <td align = "center" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Change")?></td>
                        <td align = "center" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Delete")?> </td>
                    </tr>
                </thead>
            <tbody>
        <?php
        $allRows = pg_fetch_all($poi);
            foreach ($allRows as $rowN => $value)
            { ?>
                <tr id = "redOperacija<?php echo $value["id"]?>">
                <td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
                    <?php
                        echo $rowN + 1 ;
                    ?>
                </td>
                <td id="redOperacijaIme<?php echo $value["id"]?>" align = "left" height="30px" class="text2" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8; ">
                    <?php
                        echo $value["name"];
                    ?>
                </td>
                <td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                    <button id="promeniOper<?php echo ($rowN + 1)?>" onclick = "EditItem(<?= $value["id"] ?>,'route_operation','redOperacijaIme<?=$value["id"]?>', 'Operation')" style="height:22px; width:30px"></button>
                </td>
                <td align = "center" cheight="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
                    <button id="izbrisiOper<?php echo ($rowN + 1)?>" onclick = "DelItem(<?= $value["id"] ?>,'route_operation','redOperacija<?= $value["id"] ?>','DeleteOperationSure','delEnt')" style="height:22px; width:30px"></button>
                </td>
                </tr>
                <script>
                    var i = Number('<?php echo ($rowN + 1);?>');
                    $('#promeniOper' + i).button({ icons: { primary: "ui-icon-pencil"} });
                    $('#izbrisiOper' + i).button({ icons: { primary: "ui-icon-trash"} });
                </script>
            <?php
            } ?>
                </tbody>
                </table>
        <?php }
        ?>
        </div>  <!--     KRAJ NA OPERACIJA       -->
        </div>  <!-- [END].tabela dodadi operacija -->
    </div>   <!-- [END].red za tabelite -->
<!-- </div>  container -->

<br><br>

<!-- <div class="container-fluid"> -->
    <!-- vtor red za tabelite -->
    <div class="row va">
        <div class="col-xs-5">  <!-- [btn dodadi materijal] -->
            <button id="addMaterial" onclick="AddItem('route_material','Material')" ><?php dic("Routes.Add")?> <?php echo mb_strtolower(dic_("Settings.Material"),'UTF-8') ?></button>
        </div>
        <div class="col-xs-1"></div>
        <div class="col-xs-5">  <!-- [btn dodadi mehanizacija] -->
          <div class="pl">
            <button id="addMechanisation" onclick="AddItem('route_mechanisation','Mechanisation')" ><?php dic("Routes.Add")?> <?php echo mb_strtolower(dic_("Settings.AddedMechanisation"),'UTF-8') ?></button>
          </div>
        </div>
    </div>  <!-- [red za kopcinja].END -->
    <div class="row">    <!-- [red za tableite] -->
        <!-- [tabela dodadi materijal] -->
        <div class="col-xs-5">
        <?php
        $poi = query("select * from route_material where clientid = 367 order by id");
        if(pg_num_rows($poi)==0){
        ?>
            <br><br>    <!-- nema podatoci vo baza -->
            <div id="noData" style="padding-left:40px; font-size:30px; font-style:italic; padding-bottom:40px" class="text4">
                <?php dic("Reports.NoData1")?>
            </div>
        <?php
        }
        else
        {
        ?>
        <div style="overflow:scroll; height:390px; overflow:auto; " >
            <table id="tb_material" width="98%" border="0" style="margin-top:5px; margin-right:10px; border-collapse: separate; border-spacing: 2px;">
            <thead>
                <tr>
                    <td align = "left" valign = "middle" colspan="9" height="22px" width = "100%" class="text2" style="color:#fff; font-weight:bold; font-size:14px;  padding-left:7px; background-color:#f7962b; font-weight:bold;" > <?php dic("Settings.Material")?></td>
                </tr>
                <tr>
                    <td align = "center" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Routes.Rbr")?></td>
                    <td align = "left" width="21%" height="25px" align="center" class="text2" style="padding-left:10px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.Name")?></td>
                    <td align = "center" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Change")?> </td>
                    <td align = "center" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Delete")?> </td>
                </tr>
            </thead>
            <tbody>
        <?php
        $allRows = pg_fetch_all($poi);
            foreach ($allRows as $rowN => $value)
            { ?>
                <tr id = "redMaterijal<?= $value["id"] ?>">
                <td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
                    <?php
                        echo $rowN + 1 ;
                    ?>
                </td>
                <td id="redMaterijalIme<?= $value["id"]?>" align = "left" width="60%" height="30px" class="text2" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8; ">
                    <?php
                        echo $value["name"];
                    ?>
                </td>
                <td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                    <button id="promeniMater<?php echo ($rowN + 1)?>" onclick = "EditItem(<?php echo $value["id"] ?>,'route_material','redMaterijalIme<?= $value["id"]?>', 'Material')" style="height:22px; width:30px"></button>
                </td>
                <td align = "center" cheight="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
                    <button id="izbrisiMater<?php echo ($rowN + 1)?>" onclick = "DelItem(<?= $value["id"] ?>,'route_material','redMaterijal<?= $value["id"] ?>','DeleteMaterialSure','delEnt')" style="height:22px; width:30px"></button>
                </td>
                </tr>
                <script>
                    var i = Number('<?php echo ($rowN + 1);?>');
                    $('#promeniMater' + i).button({ icons: { primary: "ui-icon-pencil"} });
                    $('#izbrisiMater' + i).button({ icons: { primary: "ui-icon-trash"} });
                </script>
            <?php
            }
        }
        ?>
            </tbody>
            </table>
        </div>  <!--     div tabela       -->
        </div>  <!-- [END].tabela materijali -->

        <!-- [tabela dodadi mehanizacija] -->
        <div class="col-xs-1"></div>
        <div class="col-xs-5">
         <?php
        $poi = query("select * from route_mechanisation where clientid = 367 order by id");
        if(pg_num_rows($poi)==0){
        ?>
            <br><br>    <!-- nema podatoci vo baza -->
            <div id="noData" style="padding-left:40px; font-size:30px; font-style:italic; padding-bottom:40px" class="text4">
                <?php dic("Reports.NoData1")?>
            </div>
        <?php
        }
        else
        {
        ?>
        <div style="overflow:scroll; height:390px; overflow:auto; " >
            <table id="tb_mechanisation" width="98%" border="0" style="margin-top:5px; margin-right:10px; border-collapse: separate; border-spacing: 2px;">
            <thead>
                <tr>
                    <td align = "left" valign = "middle" colspan="9" height="22px" width = "100%" class="text2" style="color:#fff; font-weight:bold; font-size:14px;  padding-left:7px; background-color:#f7962b; font-weight:bold;" > <?php dic("Settings.AddedMechanisation")?></td>
                </tr>
                <tr>
                    <td align = "center" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Routes.Rbr")?></td>
                    <td align = "left" width="60%" height="25px" align="center" class="text2" style="padding-left:10px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.Name")?></td>
                    <td align = "center" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Change")?> </td>
                    <td align = "center" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Delete")?> </td>
                </tr>
            </thead>
            <tbody>
        <?php
        $allRows = pg_fetch_all($poi);
            foreach ($allRows as $rowN => $value)
            { ?>
                <tr id = "redMehanizacija<?= $value["id"]?>">
                <td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
                    <?php
                        echo $rowN + 1 ;
                    ?>
                </td>
                <td id="redMehanizacijaIme<?= $value["id"]?>" align = "left" width="60%" height="30px" class="text2" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8; ">
                    <?php
                        echo $value["name"];
                    ?>
                </td>
                <td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                    <button id="promeniMehan<?php echo ($rowN + 1)?>" onclick = "EditItem(<?php echo $value["id"] ?>,'route_mechanisation','redMehanizacijaIme<?= $value["id"]?>', 'Mechanisation')" style="height:22px; width:30px"></button>
                </td>
                <td align = "center" cheight="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
                    <button id="izbrisiMehan<?php echo ($rowN + 1)?>" onclick = "DelItem(<?= $value["id"] ?>,'route_mechanisation','redMehanizacija<?= $value["id"] ?>','DeleteMechanisationSure','delEnt')" style="height:22px; width:30px"></button>
                </td>
                <td id = "mechRange" style="display:none;"><?=$value["range"]?></td><!--   potrebno za edit -->
                <script>
                    var i = Number('<?php echo ($rowN + 1);?>');
                    $('#promeniMehan' + i).button({ icons: { primary: "ui-icon-pencil"} });
                    $('#izbrisiMehan' + i).button({ icons: { primary: "ui-icon-trash"} });
                </script>
            <?php
            }
        }
        ?>
            </tbody>
            </table>
        </div>  <!--     KRAJ NA MEHANIZACIJA       -->
        </div>  <!-- [END].tabela dodadi mehanizacija -->
    </div>  <!-- [END].vtor red za tabelite -->
</div>  <!-- container -->

<!-- [END]. ZKPelagonija ************************************************* -->
    <p></p>  <!-- igra uloga na spacing pred linijata za podelba -6 -->
    <div style="border-top:1px dotted #95B1d7; width:100%"></div>

<?php
    }  // [END].[LN 685] ***************************************** Agricultural mechanization *************************************
?>
<br>
<?php 
    $dsFM = query("select allowedfm from clients where id=" . session("client_id"));
    $allowedfm = pg_fetch_result($dsFM, 0, "allowedfm");
?>

<div class="container-fluid">
<!-- *************************** KLUB KARTICKI ******************************************** -->
    <div class="row ">
        <div class="col-xs-4 col-lg-3" style="font-size: medium">
            <?php dic("Settings.ClubCards")?>
        </div>
        <div class="col-xs-2 col-lg-1">
          <div class="pr">
              <button id="btnAdd1" onclick="AddItem('clubcards','ClubCardsName','AddNewClubCard')" <?php echo (($allowedfm) ? "" : "diabled='disabled'") ?>><?php dic("Tracking.Add")?></button>&nbsp;&nbsp;&nbsp;
          </div>
        </div>
    </div>
    <div class="row va">
        <div class="col-xs-6 col-lg-4">
            <?php
            if($allowedfm != 0)
            {
                $proverkaKart = query("select * from clubcards where clientid = ". $cid);
                if(pg_num_rows($proverkaKart) == 0){ ?>
                    <br>
                    <div id="noData" style="padding-left:25px; font-size:20px; font-style:italic;" class="text4">
                        <?php dic("Reports.NoData1")?>
                    </div>
                <?php
                } else {
                ?>
                <!-- TABELA -->
                <table border="0" style="margin-top:30px; border-collapse: separate; border-spacing: 2px;">
                <thead>
                    <tr>
                        <td align = "left" valign = "middle" colspan="3" height="22px" width = "100%" class="text2" style="color:#fff; font-weight:bold; font-size:14px;  padding-left:7px; background-color:#f7962b; font-weight:bold;" > <?php dic("Settings.ClubCards")?></td>
                    </tr>
                    <tr>
                        <td align = "left" width="30%" height="25px" align="center" class="text2" style="padding-left:7px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Routes.Name")?></td>
                        <td align = "center" width="5%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Change")?> </td>
                        <td align = "center" width="5%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Tracking.Delete")?> </td>
                    </tr>
                </thead>
                <tbody >
                <?php
                $allRows = pg_fetch_all(query("select * from clubcards where clientid = ". $cid." order by cardname"));
                    foreach ($allRows as $rowN => $valueRow) {
                    ?>
                      <tr id='redCard<?=$valueRow["id"]?>'>
                          <td id="redCardIme<?=$valueRow["id"]?>" align = "left" width="30%" height="30px" class="text2" style="padding-left:7px; background-color:#fff; border:1px dotted #B8B8B8;">
                            <?php echo $valueRow["cardname"]?>
                          </td>
                          <td align = "center" width="5%"  height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
                              <button id="btnEdit<?php echo ($rowN+1)?>" onclick = "EditItem(<?php echo $valueRow["id"] ?>,'clubcards','redCardIme<?=$valueRow["id"]?>', 'ClubCardsName', 'ClubCardAlreadyAllowed')" style="height:22px; width:30px"></button>
                          </td>
                          <td align = "center" width="5%"  height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
                              <button id="DelBtn<?php echo ($rowN+1)?>" onclick = "DelItem(<?= $valueRow["id"] ?>,'clubcards','redCard<?=$valueRow["id"]?>','DeleteClubCardQuastion','Settings.DeleteClubCard')" style="height:22px; width:30px"></button>
                          </td>
                      </tr>
                    <script>
                    var i = Number('<?php echo ($rowN + 1);?>');
                        $('#btnEdit' + i).button({ icons: { primary: "ui-icon-pencil"} });
                        $('#DelBtn' + i).button({ icons: { primary: "ui-icon-trash"} });
                    </script>
                    <?php
                    } //[end].foreach
                    ?>
                </tbody>
                </table>
            <?php
                }
            } ?>
        </div>  <!-- [END].tabela za karticki -->
    </div>
</div>  <!-- [END]. KLUB KARTICKI -->
<p></p>
<div style="border-top:1px dotted #95B1d7"></div>

<!-- ************************ AVTOMATSKO ODJAVUVANJE NA DODELINI VOZACI PO VOZILA *************************-->
    <?php
    $chechIfDrivers = dlookup("select count(*) from drivers where clientid=".$cid);
    if($chechIfDrivers > 0) {
    ?>
<div class="container-fluid">
    <div class="row va">
        <div class="col-xs-10" style="font-size: medium">
            <?php echo dic("Settings.AutomResetDriver")
            ?>
        </div>
    </div>
    <div class="row va">
        <div class="col-xs-3">
            <?php echo dic("Settings.OptionsResetDriver")?>
        </div>
        <div class="col-xs-5">
            <select id="resetdriver" class="combobox text2" style="width:220px">
                <?php
                $ResetDriverdata = pg_fetch_all(query("select * from resetdriver order by id asc"));
                foreach ($ResetDriverdata as $value) {

                    $rdtID = dlookup("select resetdrivertypeid from clients where id = " . $cid);
                    ?>
                    <option <?php echo (($value['id'] == $rdtID) ? "selected" : ""); ?> value=<?php echo $value['id']?>><?php echo dic($value['title'])?></option>
                <?php
                }
                ?>
            </select>
        </div>
    </div>
</div>

    <?php
    }   // [END].AVTOMATSKO ODJAVUVANJE NA DODELINI VOZACI PO VOZILA
    ?>
<p></p>  <!-- igra uloga na spacing pred linijata za podelba -4 -->
<div style="border-top:1px dotted #95B1d7"></div>

<!-- ****************************** KOPCINJA ZA SNIMI NA KRAJ ******************** -->
<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-offset-4 col-xs-7">
            <div align="right">
                <button id="btnUpdate1"  onclick="ResetUserSettings('<?php echo $getFullUser["id"]?>') "><?php dic("Settings.DefaultValuesLTRMenu")?></button>
                <button id="btnSave1"  onclick="AddUserSettings()"><?php dic("Settings.SaveSettings")?></button>
            </div>
        </div>
    </div>
</div>
<p></p>
<p></p>

<!-- ***************************************************************************** -->
<!--                                DEL ZA DIJALOZI                                -->
<!-- ***************************************************************************** -->

<div id="div-update-menu-lineup" style="display:none" title="<?php echo dic("Settings.Action")?>"><?php echo dic("Settings.MenuLineupQuestion")?>
</div>

<div id="div-add-club-cards" style="display:none" title="<?php echo dic("Settings.AddNewClubCard")?>">
    <table>
        <tr>
            <td class="text5" style="font-weight:bold; font-size = 10px ;"><?php echo dic("Settings.NameClubCard")?>: </td>
            <td>
                <input id="CardName" type="text" class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>
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
<input id = "klienttip" type="text" style="visibility:hidden" value= "<?php echo $ClientType?>"></input>

<!-- *************************************************************************************************** -->
<!-- ************************** END *********************************************** -->
</body>
</html>

<script>

function promeni()
{
    var odgrad=$("#city option:selected").val();
    var drzava=document.getElementById('country');
    drzava.disabled=false;
      for(var j=0;j<drzava.options.length;j++)
      {
          if(odgrad==drzava.options[j].value)
          {
            drzava.options[j].selected = true; //.setAttribute("selected", "selected",true);
          }
     }
     drzava.disabled=true;
}

$(function () {
    $("#SaveDataradio").buttonset();
    $('#AM-div').buttonset();
    $('#Def-Lang').buttonset();
    $('#Def-Map').buttonset();
    $('#div-directlive').buttonset();
    $('#LiveTracking').buttonset();
    $('#LiveTracking1').buttonset();
    $('#detailVehicles').buttonset();
    $('#kenbas').buttonset();
    $('#Kilometri').buttonset();
    $('#radio').buttonset();
    $('#btnSave').button({ icons: { primary: "ui-icon-check"} });
    $('#btnSave1').button({ icons: { primary: "ui-icon-check"} });
    $('#reset1').button({ icons: { primary: "ui-icon-refresh"} });
    $('#reset2').button({ icons: { primary: "ui-icon-refresh"} });
    $('#cbOnOff').button();
    $('#btnUpdate').button({ icons: { primary: "ui-icon-refresh"} });
    $('#btnUpdate1').button({ icons: { primary: "ui-icon-refresh"} });
    $('#btnAdd1').button({ icons: { primary: "ui-icon-plus"} });
    promeni();
});
top.HideWait();

/*ResetDefaults1() [joips].se koristi za resetiranje na vrednosti na boi kaj obicni korisnici*/

function ResetDefaults() {
    document.getElementById("EONColor").selectedIndex = 3;
    //document.getElementById("EColor").selectedIndex = 7;
    document.getElementById("EOFFColor").selectedIndex = 1;
    //document.getElementById("LSColor").selectedIndex = 4;
}

/*ResetDefaults1() [joips].se koristi za resetiranje na vrednosti na boi kaj TAXI korinsnici */

function ResetDefaultsTaxi() {
    ResetDefaults();
    document.getElementById("TONColor").selectedIndex = 2;
    document.getElementById("EOFF-PON-Color").selectedIndex = 8;
    document.getElementById("TOFF-PON-Color").selectedIndex = 0;
    document.getElementById("EColor").selectedIndex = 7;
}

function intFormat(n) {
    var regex = /(\d)((\d{3},?)+)$/;
    n = n.split(',').join('');
    
    while(regex.test(n)) {
    n = n.replace(regex, '$1,$2');
    }
    return n;
}

function CommaToDot(id) {
    var charsAllowed="0123456789,.";
    var allowed;
    
    for(var i=0;i<document.getElementById(id).value.length;i++){       
        allowed=false;
        for(var j=0;j<charsAllowed.length;j++){
            if( document.getElementById(id).value.charAt(i)==charsAllowed.charAt(j) ){ allowed=true; }
        }
        if(allowed==false){ document.getElementById(id).value = document.getElementById(id).value.replace(document.getElementById(id).value.charAt(i),""); i--; }
    }
    document.getElementById(id).value = intFormat(document.getElementById(id).value)
}

function format(comma, period) {
  comma = comma || ',';
  period = period || '.';
  var split = this.toString().split('.');
  var numeric = split[0];
  var decimal = split.length > 1 ? period + split[1] : '';
  var reg = /(\d+)(\d{3})/;
  while (reg.test(numeric)) {
    numeric = numeric.replace(reg, '$1' + comma + '$2');
    }
  return numeric + decimal;
  }

/* --------------------------------------------------------------------------------
   ------------------------- ZKPelagonija FUNKCII ---------------------------------
   ================================================================================ */
    $('#addCulture').button({ icons: { primary: "ui-icon-plusthick"} });
    $('#addOperation').button({ icons: { primary: "ui-icon-plusthick"} });
    $('#addMaterial').button({ icons: { primary: "ui-icon-plusthick"} });
    $('#addMechanisation').button({ icons: { primary: "ui-icon-plusthick"} });


function AddItem(table, type, helper) {

$('<div id="div-add-item"><div>').dialog({
    modal: true,
    width: 450,
    height: 210,
    resizable: false,
    closeOnEscape: false,
    title: dic("Settings." + ((typeof(helper)=='undefined') ? type : helper)),
    open: function() {
    var html =
        "<br><br>"+
        "<table align = \"center\">"+
            "<tr>"+
               "<td class='text5' style=\"font-weight:bold; font-size = 15px ;\">" + dic("Settings.NameOfThe") +'&nbsp;' + (dic("Settings." + type)).toLowerCase() + ":&nbsp;</td>"+
               "<td>"+
                    "<input id=\"inputAdd\" type=\"text\" class=\"textboxcalender corner5 text5\" style=\"width:200px; height:22px; font-size:11px\" />"+
                "</td>"+
            "</tr>";
    if(table == "route_mechanisation") {
        html = html +
        "<tr>"+
               "<td class='text5' style=\"font-weight:bold; font-size = 15px ;\">" + dic("Reports.Range") +'&nbsp;' + dic("Reports.Meters")+ ": </td>"+
               "<td>"+
                    "<input id=\"inputAddRange\" type=\"text\" class=\"textboxcalender corner5 text5\" style=\"width:200px; height:22px; font-size:11px\" />"+
                "</td>"+
        "</tr>";
    }
    html+="</table>";
    $(this).html(html);
    },
    buttons: [{
                text: dic("Tracking.Add", lang),
                click: function() {
                    var item = $('#inputAdd').val();
                    var range = $('#inputAddRange').val();

                    var qString = "?table=" + table + "&item=" + item;
                    if(typeof(range) != 'undefined') {
                        qString+="&range=" + range;
                    }
                    if ($('#inputAdd').val() === "") {
                        document.getElementById('inputAdd').focus();
                    } else {
                        console.log('pred ajax call : '+ $('#inputAdd').val() + ' -mehanizacija: '+range);
                        console.log('query string : ' + qString);
                        $.ajax({
                            url: "AddItem.php" + qString,
                            context: document.body,
                            success: function(data) {
                                console.log("data : " + data);
                                if (Number(data) === 0) {
                                    console.log('data e 0. Ima takvo ime vo baza');
                                    msgboxPetar(dic("Settings." + ((typeof(helper)=='undefined') ? (type.capFirstLetter() + "AlreadyUsedName") : 'ClubCardNameInUse'), lang));
                                    $("#msg-click").click(function(){
                                        $('#inputAdd').val("").focus();
                                    });
                                } else {
                                    console.log('data razlicno od 0');
                                    msgboxPetar(dic("Settings.SuccChanged", lang));
                                    $(this).dialog('destroy').remove();
                                    window.location.reload();
                                }
                            }
                        });
                    }
                }
            },
            {
                text: dic("Fm.Cancel", lang),
                click: function() {
                    $(this).dialog('destroy').remove();
            },
            }]
    });
}

/*
    BRISENJE PODATOCI
    id= red vo tabela[baza]
    table = tabela[baza]
    trId = id ime na redot
    text = prashalen text
 */

function DelItem(id, table, trId, text, _title){

$('<div></div>').dialog({
    modal: true,
    width: 350,
    height: 170,
    resizable: false,
    title: dic(_title),
    closeOnEscape: false,
    open: function() {
      $(this).html(dic("Settings."+text));
    },
    buttons: [{
        text: dic("Settings.Yes"),
        click: function() {
            $.ajax({
                url: "DeleteItem.php?id=" + id + "&table=" + table + "&l=" + lang,
                context: document.body,
                success: function(data) {
                    msgboxPetar(dic("Settings.SuccDeleted", lang));
                    $('#' + trId).fadeOut(300, function() {
                        $(this).remove();
                    });
                }
            });
            $(this).dialog('destroy').remove();
        }
    }, {
        text: dic("Settings.No", lang),
        click: function() {
            $(this).dialog('destroy').remove();
        }
    }]
});
}
/*
    EDITIRANJE PODATOCI
    id= red vo tabela[baza]
    table = tabela[baza]
    imeId = id ime na redot
    type = prashalen text
    helper = pomosna promenliva
 */

String.prototype.capFirstLetter = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
};

function EditItem(id, table, imeId, type, helper) {

var ItemIme =  $("#"+imeId).text().trim();
console.log('ime na item : '+ItemIme);
$('<div id="div-edit-item"><div>').dialog({
    modal: true,
    width: 410,
    height: 210,
    resizable: false,
    title: dic("Settings.Edit") + " " + (dic("Settings." + type)).toLowerCase(),
    closeOnEscape: false,
    open: function() {
    var html =
        "<br><br>"+
        "<table align = \"center\">"+
            "<tr>"+
               "<td class='text5' style=\"font-weight:bold; font-size = 15px ;\">" + dic("Settings.NameOfThe") +'&nbsp;' + (dic("Settings." + type)).toLowerCase()+ ":&nbsp;</td>"+
               "<td>"+
                    "<input id=\"inputEdit\" type=\"text\" value='" + ItemIme + "' class=\"textboxcalender corner5 text5\" style=\"width:200px; height:22px; font-size:11px\" />"+
                "</td>"+
            "</tr>";
    if(table == "route_mechanisation") {
        html = html +
        "<tr>"+
               "<td class='text5' style=\"font-weight:bold; font-size = 15px ;\">" + dic("Reports.Range") +'&nbsp;' + dic("Reports.Meters")+ ": </td>"+
               "<td>"+
                    "<input id=\"inputEditRange\" type=\"text\" value='" + $("#mechRange").text().trim() + "' class=\"textboxcalender corner5 text5\" style=\"width:200px; height:22px; font-size:11px\" />"+
                "</td>"+
        "</tr>";
    }
    html+="</table>";
    $(this).html(html);
    },
    buttons: [{
                text: dic("Fm.Mod", lang),
                click: function() {
                    var item = $('#inputEdit').val();
                    var range = $('#inputEditRange').val();

                    var qString = "?id=" + id + "&table=" + table + "&item=" + item;
                    if(typeof(range) != 'undefined') {
                        qString+="&range=" + range;
                    }
                    if ($('#inputEdit').val() === "" || $('#inputEdit').val() == ItemIme) {
                        $('#inputEdit').val("").focus();
                    } else {
                        console.log('pred ajax call : '+ $('#inputEdit').val() + ' -mehanizacija: '+range);
                        console.log('query string : ' + qString);
                        $.ajax({
                            url: "EditItem.php" + qString,
                            context: document.body,
                            success: function(data) {
                                console.log("data : " + data);
                                if (Number(data) === 0) {
                                    console.log('data e 0. Ima takvo ime vo baza');
                                    msgboxPetar(dic("Settings." + ((typeof(helper)=='undefined') ? (type.capFirstLetter() + "AlreadyUsedName") : "ClubCardNameInUse"), lang));
                                    $("#msg-click").click(function(){
                                        $('#inputEdit').val("").removeAttr("value").focus();
                                    });
                                } else {
                                    console.log('data razlicno od 0');
                                    msgboxPetar(dic("Settings.SuccChanged", lang));
                                    $(this).dialog('destroy').remove();
                                    window.location.reload();
                                }
                            }
                        });
                    }
                }
            },
            {
                text: dic("Fm.Cancel", lang),
                click: function() {
                    $(this).dialog('destroy').remove();
            },
            }]
    });
}

function msgboxPetar(msg) {
$('#DivInfoForAll').css({ display: 'none' });
$('#div-msgbox').html(msg);
$("#dialog-message").dialog({
    modal: true,
    zIndex: 9999,
    resizable: false,
    closeOnEscape: false,
    buttons: {
        Ok: {
            text: "Ok",
            id: "msg-click",
            click: function () {
            $(this).dialog('close');
            }
        }
    }
});
}

function ResetUserSettings(id) {
document.getElementById('div-update-menu-lineup').title = dic("Settings.Action");
$('#div-update-menu-lineup').dialog({ modal: true, width: 350, height: 220, resizable: false, closeOnEscape: false,
buttons:
[
{
            text:dic("Settings.Yes",lang),
                click: function() {
                {
                $.ajax
                ({
                    url:"UpdateMenuOrder.php?id="+id,
                    context: document.body,
                    success: function(data){
                    msgboxPetar(dic("Settings.ResetLiveMenu"),lang);
                    window.location.reload();
                 }
                });
               }
              }
             },
            {
            text:dic("Settings.No",lang),
            click: function() {
                $(this).dialog('destroy').remove();
             }
          }
       ]
   });
}

/*function scrolify(tblAsJQueryObject, height){

    var oTbl = tblAsJQueryObject;

    // var oTblDiv = $("<div/>");
    // oTblDiv.css('height', height);
    // oTblDiv.css('overflow-y','auto');
    // oTbl.wrap(oTblDiv);

    // $("[data-item-to-remove]").remove();
    // save original width
    oTbl.attr("data-item-original-width", oTbl.width());
    oTbl.attr("data-item-to-remove",'1');
    oTbl.find('thead tr td').each(function(){
        $(this).attr("data-item-original-width",$(this).width());
    });
    oTbl.find('tbody tr:eq(0) td').each(function(){
        $(this).attr("data-item-original-width",$(this).width());
    });

    // clone the original table
    var newTbl = oTbl.clone();

    oTbl.find('thead tr').remove();

    newTbl.find('tbody tr').remove();

    oTbl.parent().parent().prepend(newTbl);
    newTbl.wrap("<div/>");

    newTbl.width(newTbl.attr('data-item-original-width'));
    newTbl.find('thead tr td').each(function(){
        $(this).width($(this).attr("data-item-original-width"));
    });
    oTbl.width(oTbl.attr('data-item-original-width'));
    oTbl.find('tbody tr:eq(0) td').each(function(){
        $(this).width($(this).attr("data-item-original-width"));
    });
}*/

$(document).ready(function () {
   $('#addCity').button({ icons: { primary: "ui-icon-plus"} });

   $('input[type=radio],input[type=checkbox], button').click(function() {
     $(this).blur();
   });
   if('<?php echo $ClientType?>' == 2) {
    CommaToDot('start');
    CommaToDot('km_start');
    CommaToDot('cena_km');
    CommaToDot('wait_price');
   }
});

function addCity() {
        var countryID = $( "#country option:selected" ).val();
        $.ajax({
            url: "addCity.php?l="+lang+"&countryID"+countryID,
            context: document.body,
            success: function(data){
                HideWait();
                top.$('#divaddCity').html(data)
                top.$('#divaddCity').dialog({  modal: true, width: 700, height: 525, resizable: false,
                    close: function(event, ui) { top.$( this ).dialog( "destroy" ); },
                    buttons: 
                    [
                        {
                            text:dic("add",lang),
                            click: function() {
                                var cityName = top.$('#txtCity').val();
                                var cityLon = top.$('#txtLon').val();
                                var cityLat = top.$('#txtLat').val();
                                var cityCountry = top.$("#country option:selected").val();
                                $.ajax({
                                    url: "InsertCity.php?cityName="+cityName+"&lon="+cityLon+"&lat="+cityLat+"&countryID="+cityCountry,
                                    context: document.body,
                                    success: function(data){
                                        data = $.trim(data);
                                        var retCityId = data.split("#")[0];
                                        var retCountryName = data.split("#")[1];
                                        top.$('#divaddCity').dialog( "close" );
                                        $('#city').append('<option id="'+retCityId+'" value="'+cityCountry+'">'+cityName+'</option>');
                                        $('#city option[id="'+retCityId+'"]').attr('selected',true);
                                        var exists = false;
                                        $('#country option').each(function(){
                                            if (this.value == cityCountry) {
                                                exists = true;
                                                return false;
                                            }
                                        });
                                        cityCountry = $.trim(cityCountry);
                                        if(exists==false) {
                                            $('#country').append('<option value="'+cityCountry+'">'+retCountryName+'</option>');
                                            $('#country option[value="'+cityCountry+'"]').attr('selected',true);
                                        } else {
                                            $('#country option[value="'+cityCountry+'"]').attr('selected',true);
                                        }
                                    }
                                });
                            }
                        }, {
                                text:dic("cancel",lang),
                                click: function() {
                                    top.$( this ).dialog( "destroy" );
                                }
                        }
                    ]
                })
            }
        });
    }
</script>
<?php closedb(); ?>
