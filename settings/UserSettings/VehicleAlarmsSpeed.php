<?php include "../../include/functions.php" ?>
<?php include "../../include/db.php" ?>

<?php include "../../include/params.php" ?>
<?php include "../../include/dictionary2.php" ?>
<?php session_start()?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	opendb();
    $UserID = str_replace("'", "''", NNull($_GET['uid'], ''));

    $role = Session("clientid");
    if($role == "2" || $role == "1")
        $dsv = query("select Vehicles.ID, ClientID, Registration, NumberOfVehicle from Vehicles where ClientID = " . Session("client_id") . " order by NumberOfVehicle");
    else
        $dsv = query("select Vehicles.ID, ClientID, Registration, NumberOfVehicle from Vehicles left outer join UserVehicles on UserVehicles.VehicleID = Vehicles.ID where ClientID = " . Session("client_id") . " and UserVehicles.UserID = " . $UserID . " order by NumberOfVehicle");
    
    $kilometri = "km/h";
    $ki = "1";
    $dsk = query("SELECT * FROM UserSettings where UserId = " . $UserID);
    if(odbc_num_rows($dsk) > 0)
	{
        $ki = NNull(odbc_result($dsk,"kilometri"), "1");
        if($ki == "1")
            $kilometri = "km/h";
        else
            $kilometri = "MPH";
    }
?>
<table width="100%">
    <tr>
        <td align="right" class="text5" style="font-size:12;"><?php echo dic("Settings.Vehicle")?>&nbsp;</td>
        <td align="left" class="text5" style="width:200px; font-size:12;">
            <select id="cbVehicleSpeed" class="combobox text2" style="width:200px; font-size:12;">
                <?php
                    if(odbc_num_rows($dsv) > 0)
					{
				        while($row = odbc_fetch_array($dsv))
						{
                ?>
		        		<option value="<?php echo $row["ID"]?>"><?php echo $row["Registration"]?> (<?php echo $row["NumberOfVehicle"]?>)</option>
                <?php
                        }
                 	}
					closedb();
                ?>
	        </select>
        </td>
    </tr>
    <tr>
        <td align="right" class="text5" style="font-size:12;"><?php echo dic("Settings.SpeedLimitExceed")?>&nbsp;</td>
        <td align="left" class="text5" style="width:200px; font-size:12;">
            <input type="text" id="SpeedExceed" value="" class="textboxcalender corner5 text3" style="height:22; width:160;" />&nbsp;<?php echo $kilometri?>
        </td>
    </tr>
    <tr>
        <td align="right" class="text5" style="font-size:12;" colspan="2">&nbsp;</td>
    </tr>
</table>
<script>
    $('#AddSpeedExceed').button();
</script>