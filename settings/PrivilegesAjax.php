<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php

	$userID = str_replace("'", "''", NNull($_GET['uid'], ''));
	opendb();

	$ds = query("select allowedrouting, allowedfm from clients where id=" . session("client_id"));
	$allowedR = pg_fetch_result($ds, 0, "allowedrouting");
	$allowedF = pg_fetch_result($ds, 0, "allowedfm");

	$dsSett = query("select * from privilegessettings where userid=" . $userID);
	$insertpoi = "";
	$viewpoi = "";
	$insertzone = "";
	$viewzone = "";
	$dashboard = "";
	$fleetreport = "";
	$livetracking = "";
	$overview = "";
	$shortreport = "";
	$detailreport = "";
	$idlingreport = "";
	$visitedpoi = "";
	$reconstruction = "";
	$distance = "";
	$activity = "";
	$maxspeed = "";
	$speedlimit = "";
	$exportexcel = "";
	$exportpdf = "";
	$sendmail = "";
	$schedule = "";
	$generalsettings = "";
	$usersettings = "";
	$groupspoi = "";
	$vehicles = "";
	$ounits = "";
	$employees = "";
	$worktime = "";
	$privilegesuser = "";
	$routesnew = "";
	$routespredefined = "";
	$routescurrent = "";
	$routesfuture = "";
	$routesall = "";
	$routessearch = "";
	$fmounits = "";
	$fmvehicles = "";
	$fmemployees = "";
	$fmchangetires = "";
	$fmcurrentmileage = "";
	$fmcosts = "";
	$fmoverview = "";
	$fmreportcosts = "";
	$fmreportchangetires = "";
	$fmreportperformed = "";
	$fmothercosts = "";
	$fmreportfuel = "";
	$fm = "";
	$fmalerttires = "";
	$fmalertservice = "";
	$fmalertreg = "";
	$reports = "";
	$settings = "";
	$routes = "";
	if(pg_num_rows($dsSett) != 0)
	{
		$reports = pg_fetch_result($dsSett, 0, "reports");
		$settings = pg_fetch_result($dsSett, 0, "settings");
		$routes = pg_fetch_result($dsSett, 0, "routes");
		$insertpoi = pg_fetch_result($dsSett, 0, "addpoi");
		$viewpoi = pg_fetch_result($dsSett, 0, "viewpoi");
		$insertzone = pg_fetch_result($dsSett, 0, "addzones");
		$viewzone = pg_fetch_result($dsSett, 0, "viewzones");
		$livetracking = pg_fetch_result($dsSett, 0, "livetracking");
		$dashboard = pg_fetch_result($dsSett, 0, "dashboard"); 
		$fleetreport = pg_fetch_result($dsSett, 0, "fleetreport");
		$overview = pg_fetch_result($dsSett, 0, "overview"); 
		$shortreport = pg_fetch_result($dsSett, 0, "shortreport");
		$detailreport = pg_fetch_result($dsSett, 0, "detailreport");
		$idlingreport = pg_fetch_result($dsSett, 0, "idlingreport");
		$visitedpoi = pg_fetch_result($dsSett, 0, "visitedpoi");
		$reconstruction = pg_fetch_result($dsSett, 0, "reconstruction");
		$distance = pg_fetch_result($dsSett, 0, "distance"); 
		$activity = pg_fetch_result($dsSett, 0, "activity");
		$maxspeed = pg_fetch_result($dsSett, 0, "maxspeed");
		$speedlimit = pg_fetch_result($dsSett, 0, "speedlimit");
		$exportexcel = pg_fetch_result($dsSett, 0, "exportexcel"); 
		$exportpdf = pg_fetch_result($dsSett, 0, "exportpdf");
		$sendmail = pg_fetch_result($dsSett, 0, "sendmail");
		$schedule = pg_fetch_result($dsSett, 0, "schedule");
		$generalsettings = pg_fetch_result($dsSett, 0, "generalsettings"); 
		$usersettings = pg_fetch_result($dsSett, 0, "usersettings");
		$groupspoi = pg_fetch_result($dsSett, 0, "groupspoi");
		$vehicles = pg_fetch_result($dsSett, 0, "vehicles");
		$ounits = pg_fetch_result($dsSett, 0, "ounits"); 
		$employees = pg_fetch_result($dsSett, 0, "employees");
		$worktime = pg_fetch_result($dsSett, 0, "worktime");
		$privilegesuser = pg_fetch_result($dsSett, 0, "privilegesuser");
		$routesnew = pg_fetch_result($dsSett, 0, "routesnew"); 
		$routespredefined = pg_fetch_result($dsSett, 0, "routespredefined");
		$routescurrent = pg_fetch_result($dsSett, 0, "routescurrent"); 
		$routesfuture = pg_fetch_result($dsSett, 0, "routesfuture");
		$routesall = pg_fetch_result($dsSett, 0, "routesall");
		$routessearch = pg_fetch_result($dsSett, 0, "routessearch");
		$fm = pg_fetch_result($dsSett, 0, "fm");
		$fmounits = pg_fetch_result($dsSett, 0, "fmounits");
		$fmvehicles = pg_fetch_result($dsSett, 0, "fmvehicles");
		$fmemployees = pg_fetch_result($dsSett, 0, "fmemployees");
		$fmchangetires = pg_fetch_result($dsSett, 0, "fmchangetires"); 
		$fmcurrentmileage = pg_fetch_result($dsSett, 0, "fmcurrentmileage");
		$fmcosts = pg_fetch_result($dsSett, 0, "fmcosts");
		$fmoverview = pg_fetch_result($dsSett, 0, "fmoverview");
		$fmreportcosts = pg_fetch_result($dsSett, 0, "fmreportcosts");
		$fmreportchangetires = pg_fetch_result($dsSett, 0, "fmreportchangetires");
		$fmreportperformed = pg_fetch_result($dsSett, 0, "fmreportperformed");
		$fmothercosts = pg_fetch_result($dsSett, 0, "fmothercosts");
		$fmreportfuel = pg_fetch_result($dsSett, 0, "fmreportfuel");
		$fmalerttires = pg_fetch_result($dsSett, 0, "fmalerttires"); 
		$fmalertservice = pg_fetch_result($dsSett, 0, "fmalertservice");
		$fmalertreg = pg_fetch_result($dsSett, 0, "fmalertreg");
	}
	if($reports){
        $reports = "checked='checked'";
	}
	if($settings){
        $settings = "checked='checked'";
	}
	if($routes){
        $routes = "checked='checked'";
	}
	if($insertpoi){
        $insertpoi = "checked='checked'";
	}
    if($viewpoi){
        $viewpoi = "checked='checked'";
	}
    if($insertzone){
        $insertzone = "checked='checked'";
	}
    if($viewzone){
        $viewzone = "checked='checked'";
	}
	if($livetracking){
        $livetracking = "checked='checked'";
	}
	if($dashboard){
		$dashboard = "checked='checked'";
	}
    if($fleetreport){
        $fleetreport = "checked='checked'";
	}
	if($overview){
        $overview = "checked='checked'";
	}
    if($shortreport){
        $shortreport = "checked='checked'";
	}
    if($detailreport){
        $detailreport = "checked='checked'";
	}
    if($idlingreport){
        $idlingreport = "checked='checked'";
    }
	if($visitedpoi){
        $visitedpoi = "checked='checked'";
	}
    if($reconstruction){
        $reconstruction = "checked='checked'";
	}
    if($insertpoi){
        $insertpoi = "checked='checked'";
	}
    if($activity){
        $activity = "checked='checked'";
	}
    if($maxspeed){
        $maxspeed = "checked='checked'";
	}
    if($speedlimit){
        $speedlimit = "checked='checked'";
    }
    if($exportexcel){
        $exportexcel = "checked='checked'";
	}
    if($exportpdf){
        $exportpdf = "checked='checked'";
	}
    if($sendmail){
        $sendmail = "checked='checked'";
	}
    if($schedule){
        $schedule = "checked='checked'";
	}
    if($generalsettings){
        $generalsettings = "checked='checked'";
	}
    if($usersettings){
        $usersettings = "checked='checked'";
	}
    if($groupspoi){
        $groupspoi = "checked='checked'";
	}
    if($vehicles){
        $vehicles = "checked='checked'";
    }
	if($ounits){
        $ounits = "checked='checked'";
	}
    if($employees){
        $employees = "checked='checked'";
	}
    if($worktime){
        $worktime = "checked='checked'";
	}
    if($privilegesuser){
        $privilegesuser = "checked='checked'";
	}
    if($routesnew){
        $routesnew = "checked='checked'";
	}
    if($routespredefined){
        $routespredefined = "checked='checked'";
	}
    if($routescurrent){
        $routescurrent = "checked='checked'";
	}
    if($routesfuture){
        $routesfuture = "checked='checked'";
	}
    if($routesall){
        $routesall = "checked='checked'";
	}
    if($routessearch){
        $routessearch = "checked='checked'";
	}
    if($fm){
        $fm = "checked='checked'";
	}
    if($fmounits){
        $fmounits = "checked='checked'";
	}
    if($fmvehicles){
        $fmvehicles = "checked='checked'";
	}
	if($fmemployees){
        $fmemployees = "checked='checked'";
	}
    if($fmalerttires){
        $fmalerttires = "checked='checked'";
	}
    if($fmalertservice){
        $fmalertservice = "checked='checked'";
	}
    if($fmalertreg){
        $fmalertreg = "checked='checked'";
	}
    if($fmoverview){
        $fmoverview = "checked='checked'";
	}
	if($fmreportcosts){
        $fmreportcosts = "checked='checked'";
	}
	if($fmreportchangetires){
        $fmreportchangetires = "checked='checked'";
	}
	if($fmreportperformed){
        $fmreportperformed = "checked='checked'";
	}
	if($fmothercosts){
        $fmothercosts = "checked='checked'";
	}
	if($fmreportfuel){
        $fmreportfuel = "checked='checked'";
	}
    if($fmchangetires){
        $fmchangetires = "checked='checked'";
	}
    if($fmcurrentmileage){
        $fmcurrentmileage = "checked='checked'";
	}
    if($fmcosts){
        $fmcosts = "checked='checked'";
	}
?>
	<script>
		lang = '<?php echo $cLang?>';
	</script>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="../js/jquery-ui.js"></script>
    <style type="text/css">
 		body{ overflow-y:auto }
	</style>

    <table width="100%" border="0" style="margin-top:0px; margin-left:35px;">
    	<tr>
        	<td colspan="2">
        		<div style="border-top:1px dotted #95B1d7"></div>
        	</td>
        </tr>
        <tr>
            <td class="text5" width="150px" style="font-weight:bold; vertical-align: top; padding-top: 10px;">
            	<div id="livetracking1_<?php echo $userID?>" style="margin-left: 20px;">
            		<input type="checkbox" id="livetracking_<?php echo $userID?>" <?php echo $livetracking?> /><label for="livetracking_<?php echo $userID?>"><?php strtoupper(dic("Settings.LiveTracking"))?></label>
        		</div>
        	</td>
            <td class="text5" valign="middle" align="left" style="vertical-align: top; padding-bottom: 10px; padding-top: 10px;">
                <div id="livetracking2_<?php echo $userID?>" style="margin-left: 23px;"> 
                  	<input type="checkbox" id="addpoi_<?php echo $userID?>" <?php echo $insertpoi?>/><label for="addpoi_<?php echo $userID?>"><?php echo dic("addPoi1")?></label>
                    <input type="checkbox" id="viewpoi_<?php echo $userID?>" <?php echo $viewpoi?>/><label for="viewpoi_<?php echo $userID?>"><?php echo dic("Settings.ViewPoi")?></label>
                    <input type="checkbox" id="addzones_<?php echo $userID?>" <?php echo $insertzone?>/><label for="addzones_<?php echo $userID?>"><?php echo dic("Settings.AddGeoFence")?></label>
                    <input type="checkbox" id="viewzones_<?php echo $userID?>" <?php echo $viewzone?>/><label for="viewzones_<?php echo $userID?>"><?php echo dic("Settings.ViewGeoFence")?></label>
                </div>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
        		<div style="border-top:1px dotted #95B1d7"></div>
        	</td>
        </tr>
        <tr>
            <td class="text5" style="font-weight:bold; vertical-align: top; padding-top: 10px;">
            	<div id="reports0_<?php echo $userID?>" style="margin-left: 20px;">
            		<input type="checkbox" id="reports_<?php echo $userID?>" <?php echo $reports?> /><label for="reports_<?php echo $userID?>"><?php strtoupper(dic("Settings.Reports"))?></label>
        		</div>
        	</td>
            <td style="vertical-align: top; padding-bottom: 10px; padding-top: 10px;">
            	<table border="0">
            		<tr><td class="text5" style="font-weight:bold"><?php strtoupper(dic("Settings.SummReports"))?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="Reports1_<?php echo $userID?>" style="margin-left: 20px;"> 
		                  	<input type="checkbox" id="dashboard_<?php echo $userID?>" <?php echo $dashboard?> /><label for="dashboard_<?php echo $userID?>"><?php echo dic("Reports.Dashboard")?></label>
		                    <input type="checkbox" id="fleetreport_<?php echo $userID?>" <?php echo $fleetreport?> /><label for="fleetreport_<?php echo $userID?>"><?php echo dic("Settings.FleetReports1")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php strtoupper(dic("Settings.VehicleReports"))?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="Reports2_<?php echo $userID?>" style="margin-left: 20px;"> 
		                  	<input type="checkbox" id="overview_<?php echo $userID?>" <?php echo $overview?> /><label for="overview_<?php echo $userID?>"><?php echo dic("Settings.Overview")?></label>
		                    <input type="checkbox" id="shortreport_<?php echo $userID?>" <?php echo $shortreport?> /><label for="shortreport_<?php echo $userID?>"><?php echo dic("Settings.ShortReport")?></label>
		                    <input type="checkbox" id="detailreport_<?php echo $userID?>" <?php echo $detailreport?> /><label for="detailreport_<?php echo $userID?>"><?php echo dic("Settings.DetailReport")?></label><br /><br />
		                    <input type="checkbox" id="idlingreport_<?php echo $userID?>" <?php echo $idlingreport?> /><label for="idlingreport_<?php echo $userID?>"><?php echo dic("Reports.IdlingReport")?></label>
		                    <input type="checkbox" id="visitedpoi_<?php echo $userID?>" <?php echo $visitedpoi?> /><label for="visitedpoi_<?php echo $userID?>"><?php echo dic("Reports.VisitedPOI")?></label>
		                    <input type="checkbox" id="reconstruction_<?php echo $userID?>" <?php echo $reconstruction?> /><label for="reconstruction_<?php echo $userID?>"><?php echo dic("Reports.Reconstruction")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php strtoupper(dic("Settings.Analysis"))?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="Reports3_<?php echo $userID?>" style="margin-left: 20px;"> 
		                  	<input type="checkbox" id="distance_<?php echo $userID?>" <?php echo $distance?> /><label for="distance_<?php echo $userID?>"><?php echo dic("Reports.DistanceTravelled")?></label>
		                    <input type="checkbox" id="activity_<?php echo $userID?>" <?php echo $activity?> /><label for="activity_<?php echo $userID?>"> <?php echo dic("Settings.Activity")?></label>
		                    <input type="checkbox" id="maxspeed_<?php echo $userID?>" <?php echo $maxspeed?> /><label for="maxspeed_<?php echo $userID?>"><?php echo dic("Settings.MaxSpeed")?></label>
		                    <input type="checkbox" id="speedlimit_<?php echo $userID?>" <?php echo $speedlimit?> /><label for="speedlimit_<?php echo $userID?>"><?php echo dic("Settings.SpeedLimitExcess")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php strtoupper(dic("Settings.Export"))?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="Reports4_<?php echo $userID?>" style="margin-left: 20px;"> 
		                  	<input type="checkbox" id="exportexcel_<?php echo $userID?>" <?php echo $exportexcel?> /><label for="exportexcel_<?php echo $userID?>"><?php echo dic("Settings.ExportExcel")?></label>
		                    <input type="checkbox" id="exportpdf_<?php echo $userID?>" <?php echo $exportpdf?> /><label for="exportpdf_<?php echo $userID?>"> <?php echo dic("Settings.ExportPdf")?></label>
		                    <input type="checkbox" id="sendmail_<?php echo $userID?>" <?php echo $sendmail?> /><label for="sendmail_<?php echo $userID?>"><?php echo dic("Settings.SendMail")?></label>
		                    <input type="checkbox" id="schedule_<?php echo $userID?>" <?php echo $schedule?> /><label for="schedule_<?php echo $userID?>"><?php echo dic("Settings.ScheduleRep")?></label>
		                </div>
            		</td></tr>
            	</table>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
        		<div style="border-top:1px dotted #95B1d7"></div>
        	</td>
        </tr>
        <tr>
            <td class="text5" width="130px" style="font-weight:bold; vertical-align: top; padding-top: 10px;">
            	<div id="settings0_<?php echo $userID?>" style="margin-left: 20px;">
            		<input type="checkbox" id="settings_<?php echo $userID?>" <?php echo $settings?> /><label for="settings_<?php echo $userID?>"><?php strtoupper(dic("Settings.Settings"))?></label>
        		</div>
			</td>
            <td class="text5" valign="middle" align="left" style="vertical-align: top; padding-bottom: 10px; padding-top: 10px;">
                <div id="SettingsSettings_<?php echo $userID?>" style="margin-left: 23px;">
                  	<input type="checkbox" id="generalsettings_<?php echo $userID?>" <?php echo $generalsettings?>/><label for="generalsettings_<?php echo $userID?>"><?php echo dic("Settings.GeneralSett")?></label>
                    <input type="checkbox" id="usersettings_<?php echo $userID?>" <?php echo $usersettings?>/><label for="usersettings_<?php echo $userID?>"><?php echo dic("Settings.UserSett")?></label>
                    <input type="checkbox" id="groupspoi_<?php echo $userID?>" <?php echo $groupspoi?>/><label for="groupspoi_<?php echo $userID?>">Групи на точки од интерес</label>
                    <input type="checkbox" id="vehicles_<?php echo $userID?>" <?php echo $vehicles?>/><label for="vehicles_<?php echo $userID?>"><?php echo dic("Fm.Vehicles")?></label><br /><br />
                    <input type="checkbox" id="ounits_<?php echo $userID?>" <?php echo $ounits?>/><label for="ounits_<?php echo $userID?>"><?php echo dic("Fm.OrgUnits")?></label>
                    <input type="checkbox" id="employees_<?php echo $userID?>" <?php echo $employees?>/><label for="employees_<?php echo $userID?>"><?php echo dic("Fm.Employees")?></label>
                    <input type="checkbox" id="worktime_<?php echo $userID?>" <?php echo $worktime?>/><label for="worktime_<?php echo $userID?>"><?php echo dic("Settings.WorkTime")?></label>
                    <input type="checkbox" id="privilegesuser_<?php echo $userID?>" <?php echo $privilegesuser?>/><label for="privilegesuser_<?php echo $userID?>"><?php echo dic("Settings.Privileges")?></label>
                </div>
            </td>
        </tr>
        <?php
		if($allowedR == '1')
		{
			?>
        <tr>
        	<td colspan="2">
        		<div style="border-top:1px dotted #95B1d7"></div>
        	</td>
        </tr>
        <tr>
            <td class="text5" style="font-weight:bold; vertical-align: top; padding-top: 12px;">
            	<div id="routes0_<?php echo $userID?>" style="margin-left: 20px;">
            		<input type="checkbox" id="routes_<?php echo $userID?>" <?php echo $routes?> /><label for="routes_<?php echo $userID?>"><?php strtoupper(dic("Main.routess"))?></label>
        		</div>
			</td>
            <td style="vertical-align: top; padding-bottom: 10px; padding-top: 10px;">
            	<table border="0">
            		<tr><td class="text5" style="font-weight:bold"><?php echo dic("Settings.Warrants")?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="Routes1_<?php echo $userID?>" style="margin-left: 20px;">
		                  	<input type="checkbox" id="routesnew_<?php echo $userID?>" <?php echo $routesnew?> /><label for="routesnew_<?php echo $userID?>"><?php echo dic("Settings.NewWarrant")?></label>
		                    <input type="checkbox" id="routespredefined_<?php echo $userID?>" <?php echo $routespredefined?> /><label for="routespredefined_<?php echo $userID?>"><?php echo dic("Settings.PredefinedWarrants")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php strtoupper(dic("Settings.Overview"))?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="Routes2_<?php echo $userID?>" style="margin-left: 20px;">
		                  	<input type="checkbox" id="routescurrent_<?php echo $userID?>" <?php echo $routescurrent?> /><label for="routescurrent_<?php echo $userID?>"><?php echo dic("Settings.WarrantsInProgress")?></label>
		                    <input type="checkbox" id="routesfuture_<?php echo $userID?>" <?php echo $routesfuture?> /><label for="routesfuture_<?php echo $userID?>"><?php echo dic("Settings.WarrantsFDate")?></label>
		                    <input type="checkbox" id="routesall_<?php echo $userID?>" <?php echo $routesall?> /><label for="routesall_<?php echo $userID?>"><?php echo dic("Settings.ALlWarrants")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php strtoupper(dic("Settings.Reports"))?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="Routes3_<?php echo $userID?>" style="margin-left: 20px;">
		                  	<input type="checkbox" id="routessearch_<?php echo $userID?>" <?php echo $routessearch?> /><label for="routessearch_<?php echo $userID?>"><?php echo dic("search")?></label>
		                </div>
            		</td></tr>
            	</table>
            </td>
        </tr>
        <?php
        }
		if($allowedF == '1')
		{
			?>
        <tr>
        	<td colspan="2">
        		<div style="border-top:1px dotted #95B1d7"></div>
        	</td>
        </tr>
        <tr>
            <td class="text5" style="font-weight:bold; vertical-align: top; padding-top: 12px;">
            	<div id="fleetmanagement_<?php echo $userID?>" style="margin-left: 20px;">
            		<input type="checkbox" id="fm_<?php echo $userID?>" <?php echo $fm?> /><label for="fm_<?php echo $userID?>"><?php strtoupper(dic("Main.FleetManagement"))?></label>
        		</div>
        	</td>
            <td style="vertical-align: top; padding-bottom: 10px; padding-top: 10px;">
            	<table border="0">
            		<tr><td class="text5" style="font-weight:bold"><?php echo dic("Fm.Sifrarnici")?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="fm1_<?php echo $userID?>" style="margin-left: 20px;">
		                  	<input type="checkbox" id="fmounits_<?php echo $userID?>" <?php echo $fmounits?> /><label for="fmounits_<?php echo $userID?>"><?php echo dic("Fm.OrgUnits")?></label>
		                    <input type="checkbox" id="fmvehicles_<?php echo $userID?>" <?php echo $fmvehicles?> /><label for="fmvehicles_<?php echo $userID?>"><?php echo dic("Fm.Vehicles")?></label>
		                    <input type="checkbox" id="fmemployees_<?php echo $userID?>" <?php echo $fmemployees?> /><label for="fmemployees_<?php echo $userID?>"><?php echo dic("Fm.Employees")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php echo dic("Fm.OperPerf")?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="fm2_<?php echo $userID?>" style="margin-left: 20px;">
		                  	<input type="checkbox" id="fmchangetires_<?php echo $userID?>" <?php echo $fmchangetires?> /><label for="fmchangetires_<?php echo $userID?>"><?php echo dic("Fm.ChTires")?></label>
		                    <input type="checkbox" id="fmcurrentmileage_<?php echo $userID?>" <?php echo $fmcurrentmileage?> /><label for="fmcurrentmileage_<?php echo $userID?>"><?php echo dic("Fm.CurrKm")?></label>
		                    <input type="checkbox" id="fmcosts_<?php echo $userID?>" <?php echo $fmcosts?> /><label for="fmcosts_<?php echo $userID?>"><?php echo dic("Fm.Costs")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php echo dic("reports")?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="fm3_<?php echo $userID?>" style="margin-left: 20px;"> 
		                  	<input type="checkbox" id="fmoverview_<?php echo $userID?>" <?php echo $fmoverview?> /><label for="fmoverview_<?php echo $userID?>"><?php echo dic("Reports.Overview")?></label>
		                  	<input type="checkbox" id="fmreportcosts_<?php echo $userID?>" <?php echo $fmreportcosts?> /><label for="fmreportcosts_<?php echo $userID?>"><?php echo dic("Fm.CostsReport1")?></label>
		                  	<input type="checkbox" id="fmreportchangetires_<?php echo $userID?>" <?php echo $fmreportchangetires?> /><label for="fmreportchangetires_<?php echo $userID?>"><?php echo dic("Fm.ReportTires")?></label>
		                  	<br /><br />
		                  	<input type="checkbox" id="fmreportperformed_<?php echo $userID?>" <?php echo $fmreportperformed?> /><label for="fmreportperformed_<?php echo $userID?>"><?php echo dic("Fm.ReportServices")?></label>
		                  	<input type="checkbox" id="fmothercosts_<?php echo $userID?>" <?php echo $fmothercosts?> /><label for="fmothercosts_<?php echo $userID?>"><?php echo dic("Fm.ReportCosts")?></label>
		                  	<input type="checkbox" id="fmreportfuel_<?php echo $userID?>" <?php echo $fmreportfuel?> /><label for="fmreportfuel_<?php echo $userID?>"><?php echo dic("Fm.ReportFuel")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php echo dic("Fm.Alerts")?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="fm4_<?php echo $userID?>" style="margin-left: 20px;">
		                  	<input type="checkbox" id="fmalerttires_<?php echo $userID?>" <?php echo $fmalerttires?> /><label for="fmalerttires_<?php echo $userID?>"><?php echo dic("Fm.AlertTires")?></label>
		                    <input type="checkbox" id="fmalertservice_<?php echo $userID?>" <?php echo fmalertservice?> /><label for="fmalertservice_<?php echo $userID?>"><?php echo dic("Fm.AlertService")?></label>
		                    <input type="checkbox" id="fmalertreg_<?php echo $userID?>" <?php echo $fmalertreg?> /><label for="fmalertreg_<?php echo $userID?>"><?php echo dic("Fm.AlertRegistration")?></label>
		                </div>
            		</td></tr>
            	</table>
            </td>
        </tr>
        <?php
		}
		?>
		<tr>
        	<td colspan="2">
        		<div style="border-top:1px dotted #95B1d7"></div>
        	</td>
        </tr>
		<tr>
        	<td colspan="2" style="height: 100px; padding-left: 22px;">
        		<button style="font-size: 11px;" id="btnSave_<?php echo $userID?>" onclick="AddPrivilegesSettings('<?php echo $userID?>')"><?php dic("Settings.SaveSettings")?></button>
        	</td>
        </tr>
    </table>

<script type="text/javascript">
	lang = '<?php echo $cLang?>';
	var userid='<?php echo $userID?>';
	$('#livetracking1_' + userid).buttonset();
    $('#livetracking2_' + userid).buttonset();
    $('#Reports1_' + userid).buttonset();
    $('#Reports2_' + userid).buttonset();
    $('#Reports3_' + userid).buttonset();
    $('#Reports4_' + userid).buttonset();
    $('#fm1_' + userid).buttonset();
    $('#fm2_' + userid).buttonset();
    $('#fm3_' + userid).buttonset();
    $('#fm4_' + userid).buttonset();
    $('#Routes1_' + userid).buttonset();
    $('#Routes2_' + userid).buttonset();
    $('#Routes3_' + userid).buttonset();
    $('#SettingsSettings_' + userid).buttonset();
    $('#fleetmanagement_' + userid).buttonset();
    $('#reports0_' + userid).buttonset();
    $('#settings0_' + userid).buttonset();
    $('#routes0_' + userid).buttonset();
    $('#btnSave_' + userid).button({ icons: { primary: "ui-icon-check"} });
	
</script>
<?php closedb();?>