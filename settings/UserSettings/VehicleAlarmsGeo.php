<?php include "../../include/functions.php" ?>
<?php include "../../include/db.php" ?>

<?php include "../../include/params.php" ?>
<?php include "../../include/dictionary2.php" ?>
<?php session_start()?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	opendb();
    $UserID = str_replace("'", "''", NNull($_GET['uid'], ''));
    $VeID = str_replace("'", "''", NNull($_GET['vid'], ''));

    $role = Session("role_id");
    if($role == "2" || $role == "1")
        $dsv = query("select Vehicles.ID, ClientID, Registration, NumberOfVehicle from Vehicles where ClientID = " . Session("client_id") . " order by NumberOfVehicle");
    else
        $dsv = query("select Vehicles.ID, ClientID, Registration, NumberOfVehicle from Vehicles left outer join UserVehicles on UserVehicles.VehicleID = Vehicles.ID where ClientID = " . Session("client_id") . " and UserVehicles.UserID = " . $UserID . " order by NumberOfVehicle");
    
     $ds = query("select ID, Name from ClientAreas where ClientID = " . Session("client_id"));
 ?>
 <table width="100%">
     <tr>
        <td align="right" class="text5" style="font-size:12;"><?php echo dic("Settings.Area")?>&nbsp;</td>
        <td align="left" class="text5" style="width:200px; font-size:12;">
            <select id="cbArea_<?php echo $VeID?>" style="width:200px; font-size:12;" class="combobox text2">
                <?php
                    if(odbc_num_rows($ds) > 0)
					{
				        while($row = odbc_fetch_array($ds))
						{
                ?>
		        	<option value="<?php echo $row["ID"]?>"><?php echo $row["Name"]?></option>
                <?php
                        }
                 	}
                ?>
	        </select>
        </td>
    </tr>
    <tr>
        <td align="right" class="text5" style="font-size:12;"><?php echo dic("Settings.Vehicle")?>&nbsp;</td>
        <td align="left" class="text5" style="width:200px; font-size:12;">
            <select id="cbVehicle_<?php echo $VeID?>" class="combobox text2" style="width:200px; font-size:12;">
                <?php
                    if(odbc_num_rows($dsv) > 0)
					{
				        while($row1 = odbc_fetch_array($dsv))
						{
                ?>
		        <option value="<?php echo $row1["ID"]?>"><?php echo $row1["Registration"]?> (<?php echo $row1["NumberOfVehicle"]?>)</option>
                <?php
                        }
                 	}
					closedb();
                ?>
	        </select>
        </td>
    </tr>
    <tr>
        <td align="right" class="text5" style="font-size:12;">&nbsp;</td>
        <td align="left" class="text5" style="width:200px; font-size:12;">
           <input type="checkbox" id="InArea" /><label class="text5" style="font-size:12;"><?php echo dic("Settings.AlertInGeoFence")?></label>
        </td>
    </tr>
    <tr>
        <td align="right" class="text5" style="font-size:12;">&nbsp;</td>
        <td align="left" class="text5" style="width:200px; font-size:12;">
            <input type="checkbox" id="OutArea" /><label class="text5" style="font-size:12;"><?php echo dic("Settings.AlertOutGeoFence")?></label>
        </td>
    </tr>
 </table>
<script>
    $('#AddZoneAlarm').button();
</script>