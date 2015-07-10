<?php include "../../include/functions.php" ?>
<?php include "../../include/db.php" ?>

<?php include "../../include/params.php" ?>
<?php include "../../include/dictionary2.php" ?>
<?php session_start()?>
<?php
	opendb();
    $uid = str_replace("'", "''", NNull($_GET['uid'], ''));
    //$role = str_replace("'", "''", NNull($_GET['role'], '3'));

        $dsp = query("select PrivilegesSettings.*, users.RoleID from PrivilegesSettings left outer join users on users.id = PrivilegesSettings.userID where userID = " . $uid);
    
    $ClientType = "";
    
    $dsCT = query("select ClientTypeID from Clients where id = " . Session("client_id"));
    if(odbc_num_rows($dsCT) > 0)
	{
        $ClientType = NNull(odbc_result($dsCT,"ClientTypeID"), "1");    
    }
    
    $Sadmin = "";
    $DisAdmin = "";
    $CBadmin = "";
    $role = "";
    if(odbc_num_rows($dsp) > 0)
	{
        $role = NNull(odbc_result($dsp,"RoleID"), "3");
    } else
	{
        $role = "3";
    }

    if($role == "2")
    {
        $Sadmin = "checked=checked";
        $CBadmin = "";
        $DisAdmin = "disabled = disabled";
    } else
	{
        $Sadmin = "";
        $DisAdmin = "";
    }
?>
<style>
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }
</style>
<table width="100%">
<?php
    if(odbc_num_rows($dsp) == 0)
    {
        $Sadmin = "checked=checked";
        $DisAdmin = "";
        $CBadmin = "checked=checked";
?>
    <tr>
        <td  class="text5"><input type="checkbox" id="cbLive" onchange="EnableDisableSettings(1)" checked="checked" <?php echo $DisAdmin?>/><strong style="font-size:14px"> <?php echo strtoupper(dic("Settings.LiveTracking"))?></strong></td>
        <td align="right">
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <div id="div-priv-LT" class="text5" style="margin-left:30px;">
                <input type="checkbox" id="LTAPOI" checked="checked"/><label for="LTAPOI"><?php echo dic("Settings.AddPoi")?></label>
                <input type="checkbox" id="LTVPOI" checked="checked"/><label for="LTVPOI"><?php echo dic("Settings.ViewPoi")?></label>
                <input type="checkbox" id="LTAZ" checked="checked"/><label for="LTAZ"><?php echo dic("Settings.AddGeoFence")?></label>
                <input type="checkbox" id="LTVZ" checked="checked"/><label for="LTVZ"><?php echo dic("Settings.ViewGeoFence")?></label>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td  class="text5" colspan="2"><input type="checkbox" id="cbReports" onchange="EnableDisableSettings(2)" checked="checked" <?php echo $DisAdmin?>/><strong style="font-size:14px"> <?php echo strtoupper(dic("Settings.Reports"))?></strong></td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom:1px dotted #95B1d7; padding-bottom:10px" >
            <div id="div-pri-reports" class="text5" style="margin-left:30px;">
                <label class="text5" style="font-weight:bold;"><?php echo dic("Settings.SummReports")?></label><br /> 
                <input type="checkbox" id="RDash" checked="checked"/><label for="RDash"><?php echo dic("Settings.Dashboard")?></label>
                <input type="checkbox" id="RFleet" checked="checked"/><label for="RFleet"><?php echo dic("Settings.FleetReport")?></label>
                
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom:1px dotted #95B1d7; padding-bottom:10px">
            <div id="div-pri-reports1" class="text5" style="margin-left:30px;">
                <label class="text5" style="font-weight:bold;"><?php echo dic("Settings.VehicleReports")?></label><br />
                <input type="checkbox" id="ROver" checked="checked"/><label for="ROver"><?php echo dic("Settings.Overview")?></label>
                <input type="checkbox" id="RShort" checked="checked"/><label for="RShort"><?php echo dic("Settings.ShortReport")?></label>
                <input type="checkbox" id="RDetail" checked="checked"/><label for="RDetail"><?php echo dic("Settings.DetailReport")?></label>
                <input type="checkbox" id="RPOI" checked="checked"/><label for="RPOI"><?php echo dic("Settings.VisitedPoi")?></label></p>
                <input type="checkbox" id="RRecon" checked="checked"/><label for="RRecon"><?php echo dic("Settings.Reconstruction")?></label>
                <?php
                    if($ClientType == "2")
					{
                ?>
                    <input type="checkbox" id="RTaxi" checked="checked"/><label for="RTaxi"><?php echo dic("Settings.TaxiReport")?></label>
                <?php
                	}
                ?>
                <input type="checkbox" id="RGeoFence" checked="checked"/><label for="RGeoFence"><?php echo dic("Settings.GeoFenceReport")?></label>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom:1px dotted #95B1d7; padding-bottom:10px">
            <div id="div-pri-reports2" class="text5" style="margin-left:30px;">
                <label class="text5" style="font-weight:bold;"><?php echo dic("Settings.Analysis")?></label><br />
                <input type="checkbox" id="RDist" checked="checked"/><label for="RDist"><?php echo dic("Settings.DistTrav")?></label>
                <input type="checkbox" id="RActivity" checked="checked"/><label for="RActivity"><?php echo dic("Settings.Activity")?></label>
                <input type="checkbox" id="RMAx" checked="checked"/><label for="RMAx"><?php echo dic("Settings.MaxSpeed")?></label>
                <input type="checkbox" id="RSpeed" checked="checked"/><label for="RSpeed"><?php echo dic("Settings.SpeedLimitExcess")?></label>
                
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom:1px dotted #95B1d7; padding-bottom:10px">
            <div id="div-pri-reports3" class="text5" style="margin-left:30px;">
                <label class="text5" style="font-weight:bold;"><?php echo dic("Settings.Export")?></label><br />
                <input type="checkbox" id="RExel" checked="checked"/><label for="RExel"><?php echo dic("Settings.ExportExcel")?></label>
                <input type="checkbox" id="RPdf" checked="checked"/><label for="RPdf"><?php echo dic("Settings.ExportPdf")?></label>
                <input type="checkbox" id="RSend" checked="checked"/><label for="RSend"><?php echo dic("Settings.SendMail")?></label>
                <input type="checkbox" id="RShe" checked="checked"/><label for="RShe"><?php echo dic("Settings.ScheduleRep")?></label>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td class="text5" colspan="2"><input type="checkbox" id="cbSettings" onchange="EnableDisableSettings(3)" checked="checked" <?php echo $DisAdmin?>/><strong style="font-size:14px"> <?php echo strtoupper(dic("Settings.Settings"))?></strong></td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom:1px dotted #95B1d7; padding-bottom:10px">
            <div id="div-enable-settings" class="text5" style="margin-left:30px;">
                <input type="checkbox" id="USet" checked="checked"/><label for="USet"><?php echo dic("Settings.GeneralSett")?></label>
                <input type="checkbox" id="CSet" checked="checked"/><label for="CSet"><?php echo dic("Settings.UserSett")?></label>
                <input type="checkbox" id="Priv" checked="checked"/><label for="Priv"><?php echo dic("Settings.Privileges")?></label>
                <input type="checkbox" id="POI" checked="checked"/><label for="POI"><?php echo dic("Settings.Poi")?></label><br />
                <input type="checkbox" id="GeoFence" checked="checked"/><label for="GeoFence"><?php echo dic("Settings.GeoFence")?></label>
            </div>
        </td>
    </tr>
<?php
} else
{
    if($role == "2")
	{
        $Sadmin = "checked=checked";
        $DisAdmin = "disabled = disabled";
    } else
	{
        $Sadmin = "";
        $DisAdmin = "";
    }
?>
    <tr>
    <?php
        $LiveTracking = "";
        $LiveTracking = NNull(odbc_result($dsp,"LiveTracking"), "0");
        if($LiveTracking == "0")
            $LiveTracking = "";
        else
            $LiveTracking = "checked=checked";

        if($role == "2")
            $LiveTracking = "";

    ?>
        <td  class="text5"><input type="checkbox" id="cbLive" onchange="EnableDisableSettings(1)" <?php echo $LiveTracking?> <?php echo $DisAdmin?>/><strong style="font-size:14px"> <?php echo strtoupper(dic("Settings.LiveTracking"))?></strong></td>
        <td align="right">
            
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <div id="div-priv-LT" class="text5" style="margin-left:30px;">
            <?php
                $LTAPOI = "";
                $LTVPOI = "";
                $LTAZ = "";
                $LTVZ = "";
                $LTAPOI = NNull(odbc_result($dsp,"AddPOI"), "0");
                $LTVPOI = NNull(odbc_result($dsp,"ViewPOI"), "0");
                $LTAZ = NNull(odbc_result($dsp,"AddZones"), "0");
                $LTVZ = NNull(odbc_result($dsp,"ViewZones"), "0");
                if($LTAPOI == "0")
                    $LTAPOI = "";
                else
                    $LTAPOI = "checked=checked";
                if($LTVPOI == "0")
                    $LTVPOI = "";
                else
                    $LTVPOI = "checked=checked";
                if($LTAZ == "0")
                    $LTAZ = "";
                else
                    $LTAZ = "checked=checked";
                if($LTVZ == "0")
                    $LTVZ = "";
                else
                    $LTVZ = "checked=checked";
                if($role == "2")
                {
            ?>
                <input type="checkbox" id="LTAPOI" checked="checked" /><label for="LTAPOI"><?php echo dic("Settings.AddPoi")?></label>
                <input type="checkbox" id="LTVPOI" checked="checked" /><label for="LTVPOI"><?php echo dic("Settings.ViewPoi")?></label>
                <input type="checkbox" id="LTAZ" checked="checked" /><label for="LTAZ"><?php echo dic("Settings.AddGeoFence")?></label>
                <input type="checkbox" id="LTVZ" checked="checked" /><label for="LTVZ"><?php echo dic("Settings.ViewGeoFence")?></label>
            <?php
				} else
				{
            ?>    
                <input type="checkbox" id="LTAPOI" <?php echo $LTAPOI?>/><label for="LTAPOI"><?php echo dic("Settings.AddPoi")?></label>
                <input type="checkbox" id="LTVPOI" <?php echo $LTVPOI?>/><label for="LTVPOI"><?php echo dic("Settings.ViewPoi")?></label>
                <input type="checkbox" id="LTAZ" <?php echo $LTAZ?>/><label for="LTAZ"><?php echo dic("Settings.AddGeoFence")?></label>
                <input type="checkbox" id="LTVZ" <?php echo $LTVZ?>/><label for="LTVZ"><?php echo dic("Settings.ViewGeoFence")?></label>
            <?php
            	}
            ?>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    <?php
        $Reports = "";
        $Reports = NNull(odbc_result($dsp,"Reports"), "0");
        if($Reports == "0")
            $Reports = "";
        else
            $Reports = "checked=checked";
        if($role == "2")
            $Reports = "";
    ?>
        <td  class="text5" colspan="2"><input type="checkbox" id="cbReports" onchange="EnableDisableSettings(2)" <?php echo $Reports?> <?php echo $DisAdmin?>/><strong style="font-size:14px"> <?php echo strtoupper(dic("Settings.Reports"))?></strong></td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom:1px dotted #95B1d7; padding-bottom:10px">
            <div id="div-pri-reports" class="text5" style="margin-left:30px;">
            <?php
                $RDash = "";
                $RFleet = "";
                $ROver = "";
                $RShort = "";
                $RDetail = "";
                $RDash = NNull(odbc_result($dsp,"Dashboard"), "0");
                $RFleet = NNull(odbc_result($dsp,"FleetReport"), "0");
                $ROver = NNull(odbc_result($dsp,"Overview"), "0");
                $RShort = NNull(odbc_result($dsp,"ShortReport"), "0");
                $RDetail = NNull(odbc_result($dsp,"DetailReport"), "0");
                if($RDash == "0")
                    $RDash = "";
                else
                    $RDash = "checked=checked";
                if($RFleet == "0")
                    $RFleet = "";
                else
                    $RFleet = "checked=checked";
                if($ROver == "0")
                    $ROver = "";
                else
                    $ROver = "checked=checked";
                if($RShort == "0")
                    $RShort = "";
                else
                    $RShort = "checked=checked";
                if($RDetail = "0")
                    $RDetail = "";
                else
                    $RDetail = "checked=checked";
            ?>
                <label class="text5" style="font-weight:bold;"><?php echo dic("Settings.SummReports")?></label><br />
             <?php
                 if($role == "2")
				 {
             ?>
                <input type="checkbox" id="RDash" checked="checked" /><label for="RDash"><?php echo dic("Settings.Dashboard")?></label>
                <input type="checkbox" id="RFleet" checked="checked" /><label for="RFleet"><?php echo dic("Settings.FleetReport")?></label>
             <?php
                 } else
			 	{
             ?>
                <input type="checkbox" id="RDash" <?php echo $RDash?>/><label for="RDash"><?php echo dic("Settings.Dashboard")?></label>
                <input type="checkbox" id="RFleet" <?php echo $RFleet?>/><label for="RFleet"><?php echo dic("Settings.FleetReport")?></label>
            <?php
            	}
            ?>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom:1px dotted #95B1d7; padding-bottom:10px">
            <div id="div-pri-reports1" class="text5" style="margin-left:30px;">
            <?php
                $RPOI = "";
                $RRecon = "";
                $RDist = "";
                $RActivity = "";
                $RMAx = "";
                $RTaxi = "";
                $RGeo = "";
                $RPOI = NNull(odbc_result($dsp,"VisitedPOI"), "0");
                $RRecon = NNull(odbc_result($dsp,"Reconstruction"), "0");
                $RDist = NNull(odbc_result($dsp,"Distance"), "0");
                $RActivity = NNull(odbc_result($dsp,"Activity"), "0");
                $RMAx = NNull(odbc_result($dsp,"MaxSpeed"), "0");
                $RTaxi = NNull(odbc_result($dsp,"TaxiReport"), "0");
                $RGeo = NNull(odbc_result($dsp,"GeoFenceReport"), "0");
                if($RPOI == "0")
                    $RPOI = "";
                else
                    $RPOI ="checked=checked";
                if($RRecon == "0")
                    $RRecon = "";
                else
                    $RRecon = "checked=checked";
                if($RDist == "0")
                    $RDist = "";
                else
                    $RDist = "checked=checked";
                if($RActivity == "0")
                    $RActivity = "";
                else
                    $RActivity = "checked=checked";
                if($RMAx == "0")
                    $RMAx = "";
                else
                    $RMAx = "checked=checked";
                if($RTaxi == "0")
                    $RTaxi = "";
                else
                    $RTaxi = "checked=checked";
                if($RGeo == "0")
                    $RGeo = "";
                else
                    $RGeo = "checked=checked";
                if($role == "2")
				{
                    $ROver = "checked=checked";
                    $RShort = "checked=checked";
                    $RDetail = "checked=checked";
                    $RPOI = "checked=checked";
                    $RRecon = "checked=checked";
                    $RTaxi = "checked=checked";
                    $RGeo = "checked=checked";
				}
            ?>
                <label class="text5" style="font-weight:bold;"><?php echo dic("Settings.VehicleReports")?></label><br />
                <input type="checkbox" id="ROver" <?php echo $ROver?>/><label for="ROver"><?php echo dic("Settings.Overview")?></label>
                <input type="checkbox" id="RShort" <?php echo $RShort?>/><label for="RShort"><?php echo dic("Settings.ShortReport")?></label>
                <input type="checkbox" id="RDetail" <?php echo $RDetail?>/><label for="RDetail"><?php echo dic("Settings.DetailReport")?></label>
                <input type="checkbox" id="RPOI" <?php echo $RPOI?>/><label for="RPOI"><?php echo dic("Settings.VisitedPoi")?></label></p>
                <input type="checkbox" id="RRecon" <?php echo $RRecon?>/><label for="RRecon"><?php echo dic("Settings.Reconstruction")?></label>
                <?php
                    if($ClientType == "2")
					{
                ?>
                    <input type="checkbox" id="RTaxi" <?php echo $RTaxi?>/><label for="RTaxi"><?php echo dic("Settings.TaxiReport")?></label>
                <?php
					}
                ?>
                <input type="checkbox" id="RGeoFence" <?php echo $RGeo?>/><label for="RGeoFence"><?php echo dic("Settings.GeoFenceReport")?></label>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom:1px dotted #95B1d7; padding-bottom:10px">
            <div id="div-pri-reports2" class="text5" style="margin-left:30px;">
            <?php
                $RSpeed  = "";
                $RExel  = "";
                $RPdf  = "";
                $RSend  = "";
                $RShe  = "";
                $RSpeed = NNull(odbc_result($dsp,"SpeedLimit"), "0");
                $RExel = NNull(odbc_result($dsp,"ExportExcel"), "0");
                $RPdf = NNull(odbc_result($dsp,"ExportPdf"), "0");
                $RSend = NNull(odbc_result($dsp,"SendMail"), "0");
                $RShe = NNull(odbc_result($dsp,"Schedule"), "0");
                If ($RSpeed = "0")
                    $RSpeed = "";
                else
                    $RSpeed = "checked=checked";
                if ($RExel == "0")
                    $RExel = "";
                else
                    $RExel = "checked=checked";
                if ($RPdf == "0")
                    $RPdf = "";
                else
                    $RPdf = "checked=checked";
                if($RSend == "0")
                    $RSend = "";
                else
                    $RSend = "checked=checked";
                if ($RShe == "0")
                    $RShe = "";
                else
                    $RShe = "checked=checked";
                
                if($role == "2")
				{
                    $RDist = "checked=checked";
                    $RActivity = "checked=checked";
                    $RMAx = "checked=checked";
                    $RSpeed = "checked=checked";
                }
            ?>
                <label class="text5" style="font-weight:bold;"><?php echo dic("Settings.Analysis")?></label><br />
                <input type="checkbox" id="RDist" <?php echo $RDist?>/><label for="RDist"><?php echo dic("Settings.DistTrav")?></label>
                <input type="checkbox" id="RActivity" <?php echo $RActivity?>/><label for="RActivity"><?php echo dic("Settings.Activity")?></label>
                <input type="checkbox" id="RMAx" <?php echo $RMAx?>/><label for="RMAx"><?php echo dic("Settings.MaxSpeed")?></label>
                <input type="checkbox" id="RSpeed" <?php echo $RSpeed?>/><label for="RSpeed"><?php echo dic("Settings.SpeedLimitExcess")?></label>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom:1px dotted #95B1d7; padding-bottom:10px">
            <div id="div-pri-reports3" class="text5" style="margin-left:30px;">
                <label class="text5" style="font-weight:bold;"><?php echo dic("Settings.Export")?></label><br />
                <?php
                    if($role == "2")
                 	{
					    $RExel = "checked=checked";
                        $RPdf = "checked=checked";
                        $RSend = "checked=checked";
                        $RShe = "checked=checked";
                    }
                ?>
                <input type="checkbox" id="RExel" <?php echo $RExel?>/><label for="RExel"><?php echo dic("Settings.ExportExcel")?></label>
                <input type="checkbox" id="RPdf" <?php echo $RPdf?>/><label for="RPdf"><?php echo dic("Settings.ExportPdf")?></label>
                <input type="checkbox" id="RSend" <?php echo $RSend?>/><label for="RSend"><?php echo dic("Settings.SendMail")?></label>
                <input type="checkbox" id="RShe" <?php echo $RShe?>/><label for="RShe"><?php echo dic("Settings.ScheduleRep")?></label>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    <?php
        $Settings  = "";
        $Settings = NNull(odbc_result($dsp,"Settings"), "0");
        if($Settings == "0")
            $Settings = "";
        else
            $Settings = "checked=checked";
        if($role == "2")
            $Settings = "";
    ?>
        <td class="text5" colspan="2"><input type="checkbox" id="cbSettings" onchange="EnableDisableSettings(3)" <?php echo $Settings?> <?php echo $DisAdmin?>/><strong style="font-size:14px"> <?php echo strtoupper(dic("Settings.Settings"))?></strong></td>
    </tr>
    <tr>
        <td colspan="2" style="border-bottom:1px dotted #95B1d7; padding-bottom:10px">
            <div id="div-enable-settings" class="text5" style="margin-left:30px;">
            <?php
                $USet  = "";
                $CSet  = "";
                $Priv  = "";
                $POI  = "";
                $GeoFence  = "";
                $USet = NNull(odbc_result($dsp,"UserSettings"), "0");
                $CSet = NNull(odbc_result($dsp,"ClientSettings"), "0");
                $Priv = NNull(odbc_result($dsp,"PrivilegesUser"), "0");
                $POI = NNull(odbc_result($dsp,"POI"), "0");
                $GeoFence = NNull(odbc_result($dsp,"GeoFence"), "0");
                if($USet == "0")
                    $USet = "";
                else
                    $USet = "checked=checked";
                if($CSet == "0")
                    $CSet = "";
                else
                    $CSet = "checked=checked";
                if ($Priv == "0")
                    $Priv = "";
                else
                    $Priv = "checked=checked";
                if ($POI == "0")
                    $POI = "";
                else
                    $POI = "checked=checked";
                if ($GeoFence == "0")
                    $GeoFence = "";
                else
                    $GeoFence = "checked=checked";
                
                if($role == "2")
				{
                    $USet = "checked=checked";
                    $CSet = "checked=checked";
                    $Priv = "checked=checked";
                    $POI = "checked=checked";
                    $GeoFence = "checked=checked";
                }
            ?>
                <input type="checkbox" id="USet" <?php echo $USet?>/><label for="USet"><?php echo dic("Settings.GeneralSett")?></label>
                <input type="checkbox" id="CSet" <?php echo $CSet?>/><label for="CSet"><?php echo dic("Settings.UserSett")?></label>
                <input type="checkbox" id="Priv" <?php echo $Priv?>/><label for="Priv"><?php echo dic("Settings.Privileges")?></label>
                <input type="checkbox" id="POI" <?php echo $POI?>/><label for="POI"><?php echo dic("Settings.Poi")?></label><br />
                <input type="checkbox" id="GeoFence" <?php echo $GeoFence?>/><label for="GeoFence"><?php echo dic("Settings.GeoFence")?></label>
            </div>
        </td>
    </tr>
<?php
}
?>
</table>
<div id="ButtonSave">
    &nbsp;<button id="btnSavePri" onclick="AddPriviliges()"><?php echo dic("Settings.SaveSettings")?></button><br><br>
          <span class="text3" style="color:#f00; font-size:10px">* <strong><?php echo dic("Settings.Note")?></strong>: <?php echo dic("Settings.SetPriv")?></span>
</div>
<script>
    $(function () {
//        $("#div-priv-LT").buttonset();
//        $('#div-pri-reports').buttonset();
//        $('#div-pri-reports1').buttonset();
//        $('#div-pri-reports2').buttonset();
//        $('#div-pri-reports3').buttonset();
//        $('#div-enable-settings').buttonset();
//        $('#btnSavePri').button({ icons: { primary: "ui-icon-check"} });
        EnableDisableSettings(1);
        EnableDisableSettings(2);
        EnableDisableSettings(3);
        $('#btnSavePri').button({ icons: { primary: "ui-icon-check"} });
    });
</script>
<?php
	closedb();
?>