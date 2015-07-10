<?php include "../../include/functions.php" ?>
<?php include "../../include/db.php" ?>

<?php include "../../include/params.php" ?>
<?php include "../../include/dictionary2.php" ?>
<?php session_start()?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	opendb();
    
    if (!is_numeric(session('user_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);    
    
    $sqlSch = "";
    if(Session("role_id") == "2")
        $sqlSch = "select * from vehicles where clientID=" . Session("client_id") . " order by numberofvehicle";
    else
        $sqlSch = "select * from vehicles where id in (select vehicleID from UserVehicles where userID=" . Session("user_id") . ") order by numberofvehicle";
	
    $dsVehicles = query($sqlSch);
 
?>
<table>
    <tr>
        <td align="right" class="text5" style="font-size:12;"><?php echo dic("Settings.Reports")?>: </td>
        <td align="left" class="text5" style="font-size:12;" colspan="3">
        <?php
            if(Session("role_id") == "2")
			{
        ?>
            <select id="cbReports"  style="width:220px; font-size:12;" class="combobox text2">		
                    <option value="Dashboard"><?php echo dic("Settings.Dashboard")?></option>
                    <option value="FleetReport"><?php echo dic("Settings.FleetReport")?></option>
                    <option value="Overview"><?php echo dic("Settings.Overview")?></option>
                    <option value="ShortReport"><?php echo dic("Settings.ShortReport")?></option>
                    <option value="DetailReport"><?php echo dic("Settings.DetailReport")?></option>
                    <option value="VisitedPointsOfInterest"><?php echo dic("Settings.VisitedPoi")?></option>
                    <option value="Reconstruction"><?php echo dic("Settings.Reconstruction")?></option>
					<option value="TaxiReport"><?php echo dic("Settings.TaxiReport")?></option>
					<option value="DistanceTravelled"><?php echo dic("Settings.DistTrav")?></option>
                    <option value="Activity"><?php echo dic("Settings.Activity")?></option>
                    <option value="MaxSpeed"><?php echo dic("Settings.MaxSpeed")?></option>
                    <option value="SpeedLimitExcess"><?php echo dic("Settings.SpeedLimitExcess")?></option>
				</select>
        <?php
        } else
		{
            $dsr = query("SELECT * FROM draft.dbo.PrivilegesSettings where  userID = " . Session("user_id"));
        	if(odbc_num_rows($dsr) > 0)
			{
                $Dashboard = "";
                $FleetReport = "";
                $Overview = "";
                $ShortReport = "";
                $DetailReport = "";
                $VisitedPointsOfInterest = "";
                $Reconstruction = "";
                $TaxiReport = "";
                $DistanceTravelled = "";
                $Activity = "";
                $MaxSpeed = "";
                $SpeedLimitExcess = "";
                
                if(odbc_result($dsr,"Dashboard") == "1")
                    $Dashboard = "<option value='Dashboard'>" . dic("Settings.Dashboard") . "</option>";
                
                if(odbc_result($dsr,"FleetReport") == "1")
                    $FleetReport = "<option value='FleetReport'>" . dic("Settings.FleetReport") . "</option>";
                
                if(odbc_result($dsr,"Overview") == "1")
                    $Overview = "<option value='Overview'>" . dic("Settings.Overview") . "</option>";
                
                if(odbc_result($dsr,"ShortReport") == "1")
                    $ShortReport = "<option value='ShortReport'>" . dic("Settings.ShortReport") . "</option>";
                
                if(odbc_result($dsr,"DetailReport") == "1")
                    $DetailReport = "<option value='DetailReport'>" . dic("Settings.DetailReport") . "</option>";
                
                if(odbc_result($dsr,"VisitedPOI") == "1")
                    $VisitedPointsOfInterest = "<option value='VisitedPointsOfInterest'>" . dic("Settings.VisitedPoi") . "</option>";
                
                if(odbc_result($dsr,"Reconstruction") == "1")
                    $Reconstruction = "<option value='Reconstruction'>" . dic("Settings.Reconstruction") . "</option>";
                
                if(odbc_result($dsr,"TaxiReport") == "1")
                    $TaxiReport = "<option value='TaxiReport'>" . dic("Settings.TaxiReport") . "</option>";
                
                if(odbc_result($dsr,"Distance") == "1")
                    $DistanceTravelled = "<option value='DistanceTravelled'>" . dic("Settings.DistTrav") . "</option>";
                
                if(odbc_result($dsr,"Activity") == "1")
                    $Activity = "<option value='Activity'>" . dic("Settings.Activity") . "</option>";
                
                if(odbc_result($dsr,"MaxSpeed") == "1")
                    $MaxSpeed = "<option value='MaxSpeed'>" . dic("Settings.MaxSpeed") . "</option>";
                
                if(odbc_result($dsr,"SpeedLimit") == "1")
                    $SpeedLimitExcess = "<option value='SpeedLimitExcess'>" . dic("Settings.SpeedLimitExcess") . "</option>";
                
            
        ?>
                 <select id="cbReports"  style="width:220px; font-size:12;" class="combobox text2">		
                    <?php echo $Dashboard ?>
                    <?php echo $FleetReport ?>
                    <?php echo $Overview ?>
                    <?php echo $ShortReport ?>
                    <?php echo $DetailReport ?>
                    <?php echo $VisitedPointsOfInterest ?>
                    <?php echo $Reconstruction ?>
					<?php echo $TaxiReport ?>
					<?php echo $DistanceTravelled ?>
                    <?php echo $Activity ?>
                    <?php echo $MaxSpeed ?>
                    <?php echo $SpeedLimitExcess ?>
				</select>
        <?php
        		}
    		}
        ?>
        </td>
    </tr>
    <tr>
        <td align="right" class="text5" style="font-size:12;"><?php echo dic("Settings.Vehicle")?>: </td>
        <td align="left" class="text5" style="font-size:12;" colspan="3">
            <select id="cbVehicles" style="width:220px; font-size:12;" class="combobox text2">		
					<option value="all"><?php echo dic("Settings.AllVehicles")?></option>
					<?php
						while($row = odbc_fetch_array($dsVehicles))
						{
					?>
						    <option value="<?php echo $row["Registration"]?>"><?php echo $row["Registration"]?>(<?php echo $row["NumberOfVehicle"]?>)</option>
					<?php
						}
					?>
				</select>
        </td>
    </tr>
    <tr>
        <td align="right" class="text5" style="font-size:12;"><?php echo dic("Settings.Period")?>: </td>
        <td align="left" class="text5" style="font-size:12;" colspan="3">
            <select id="cbPeriod" style="width:220px; font-size:12;" onchange="PeriodChange()" class="combobox text2">		
					<option value="Daily"><?php echo dic("Settings.Daily")?></option>
					<option value="Weekly"><?php echo dic("Settings.Weekly")?></option>
                    <option value="Monthly"><?php echo dic("Settings.Monthly")?></option>
			</select>
        </td>
    </tr>
    <tr id="div-Day" style="display:none;">
        <td align="right" class="text5" style="font-size:12;"><?php echo dic("Settings.Day")?>: </td>
        <td align="left" class="text5" style="font-size:12;" colspan="3">
            <select id="cbDay" style="width:220px; font-size:12;" class="combobox text2">		
				<option value="Monday"><?php echo dic("Settings.Monday")?></option>
				<option value="Tuesday"><?php echo dic("Settings.Tuesday")?></option>
                <option value="Wednesday"><?php echo dic("Settings.Wednesday")?></option>
                <option value="Thursday"><?php echo dic("Settings.Thursday")?></option>
                <option value="Friday"><?php echo dic("Settings.Friday")?></option>
                <option value="Saturday"><?php echo dic("Settings.Saturday")?></option>
                <option value="Sunday"><?php echo dic("Settings.Sunday")?></option>
		    </select>
        </td>
    </tr>
     <tr id="div-Date" style="display:none;">
        <td align="right" class="text5" style="font-size:12;"><?php echo dic("Settings.Day")?>: </td>
        <td align="left" class="text5" style="width:200px; font-size:12;" colspan="3">
            <select id="cbDate1" style="width:220px; font-size:12;" class="combobox text2">
            <?php
                $br = 0;
                for($br=1; $br <= 31; $br++)
                {
            ?>		
					    <option value="<?php echo $br?>"><?php echo $br?></option>
            <?php
                }                
            ?>
		    </select>
        </td>
    </tr>
    <tr>
        <td align="right" class="text5" style="font-size:12;"><?php echo dic("Settings.Time")?>: </td>
        <td align="left" style="font-size:12; width:99px;" >
            <select id="cbTimeHours" style="width:99px; font-size:12;" class="combobox text2">		
					<?php
					    for($i = 0; $i <= 23; $i++)
						{
					        if($i < 10)
							{
					?>
						<option value="0<?php echo $i?>">0<?php echo $i?></option>                    
                    <?php
							} else
							{
                        ?>
                        <option value="<?php echo $i?>"><?php echo $i?></option>      
                		<?php
                        	}
                    	}
					?>
			</select>
        </td>
        <td align="center" style="width:2;">&nbsp;&nbsp;:</td>
        <td style="width:99px;">
            <select id="cbTimeMinutes" style="width:99px; font-size:12;" class="combobox text2">		
					<?php
					    for($j = 0; $j <= 59; $j++)
						{
					        if($j < 10)
							{
					?>
						<option value="0<?php echo $j?>">0<?php echo $j?></option>                    
                    <?php
							} else
							{
                        ?>
                        <option value="<?php echo $j?>"><?php echo $j?></option>      
                <?php
                        	}
						}
					?>
			</select>
        </td>
    </tr>
    


    <tr>
        <td align="right" class="text5" style="font-size:12;" valign="top"><?php echo dic("Settings.Email")?>: </td>
        <td align="left" class="text5" style="width:200px; font-size:12;" colspan="3">
            <div id="div-email">
            <?php
            $role = Session("role_id");
            $email = DlookUP("select Isnull(Email,'') from Users where ID=" . Session("user_id"));
            
        ?>
              <input type="checkbox" checked="checked" id="cb_<?php echo Session("user_id")?>" alt="<?php echo Session("user_id")?>" style="display:none" />
             <input type="text" style="width:220;" id="email_<?php echo Session("user_id")?>" class="textboxcalender corner5 text3" value="<?php echo $email?>" /></p>
             <script>                 $('#email_<?php echo Session("user_id")?>').text();</script>

        <?php
            if($role == "2")
			{
                $ds = query("select id, email, fullname from Users where ClientID=" . Session("client_id") . " and RoleID=3");
                if(odbc_num_rows($ds) > 0)
				{
			        while($row2 = odbc_fetch_array($ds))
					{
        ?>
            <input type="checkbox" checked="checked" id="cb_<?php echo $row2["id"]?>" alt="<?php echo $row2["id"]?>"><label class="text5"><?php echo $row2["fullname"]?></label></input></br>
            <input type="text" style="width:220;" class="textboxcalender corner5 text3" id="email_<?php echo $row2["id"]?>" value="<?php echo $row2["email"]?>" /></p>
            <script>                $('#email_<?php echo $row2["id"]?>').text();</script>
        <?php
            }}}
        ?>
            </div>
        </td>
    </tr>

</table>
<script>
//    $('#cbReports').combobox();
//    $('#cbVehicles').combobox();
//    $('#cbPeriod').combobox();
//    $('#cbDay').combobox();
//    $('#cbDate').combobox();
//    $('#cbTimeHours').combobox();
//    $('#cbTimeHours').css('width','50px');
//    $('#cbTimeMinutes').combobox();
//    $('#cbTimeMinutes').css('width','50px');

function PeriodChange() {
    var per = $('#cbPeriod').val()
    if (per == "Weekly") {
        document.getElementById('div-Day').style.display = '';
        document.getElementById('div-Date').style.display = 'none';
    } 
    if (per == "Monthly") {
        document.getElementById('div-Date').style.display = '';
        document.getElementById('div-Day').style.display = 'none';
    }
    if (per == "Daily") {
        document.getElementById('div-Day').style.display = 'none';
        document.getElementById('div-Date').style.display = 'none';
    }
}
</script>