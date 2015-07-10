<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");

	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	$yourbrowser1 = (bool) strpos($ua['userAgent'], "Macintosh");

	opendb();
	$Allow = getPriv("privilegesuser", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);

	if(is_numeric(nnull(session("user_id"))) == false){ 
	echo header ("Location: ../sessionexpired/?l=" . $cLang);
	}	

	$userID = str_replace("'", "''", NNull($_GET['uid'], ''));
	$dsUsers = query("select id, fullname, roleid from users where id=" . $userID);
	
	$ds = query("select allowedrouting, allowedfm from clients where id=" . session("client_id"));
	$allowedR = pg_fetch_result($ds, 0, "allowedrouting");
	$allowedF = pg_fetch_result($ds, 0, "allowedfm");

	$reports = "checked='checked'";
	$settings = "checked='checked'";
	$routes = "checked='checked'";
	$insertpoi = "checked='checked'";
	$viewpoi = "checked='checked'";
	$insertzone = "checked='checked'";
	$viewzone = "checked='checked'";
	$livetracking = "checked='checked'";
	$dashboard = "checked='checked'";
	$fleetreport = "checked='checked'";
	$overview = "checked='checked'";
	$shortreport = "checked='checked'";
	$detailreport = "checked='checked'";
	$idlingreport = "checked='checked'";
	$visitedpoi = "checked='checked'";
	$reconstruction = "checked='checked'";
	$insertpoi = "checked='checked'";
	$distance = "checked='checked'";
	$activity = "checked='checked'";
	$maxspeed = "checked='checked'";
	$speedlimit = "checked='checked'";
	$exportexcel = "checked='checked'";
	$exportpdf = "checked='checked'";
	$sendmail = "checked='checked'";
	$schedule = "checked='checked'";
	$generalsettings = "checked='checked'";
	$usersettings = "checked='checked'";
	$groupspoi = "checked='checked'";
	$vehicles = "checked='checked'";
	$ounits = "checked='checked'";
	$employees = "checked='checked'";
	$worktime = "checked='checked'";
	$privilegesuser = "checked='checked'";
	$routesnew = "checked='checked'";
	$routespredefined = "checked='checked'";
	$routescurrent = "checked='checked'";
	$routesfuture = "checked='checked'";
	$routesall = "checked='checked'";
	$routessearch = "checked='checked'";
	$fm = "checked='checked'";
	$fmounits = "checked='checked'";
	$fmvehicles = "checked='checked'";
	$fmemployees = "checked='checked'";
	$fmalerttires = "checked='checked'";
	$fmalertservice = "checked='checked'";
	$fmalertreg = "checked='checked'";
	$fmeditcosts = "checked='checked'";
	$fmoverview = "checked='checked'";
	$fmreportcosts = "checked='checked'";
	$fmreportchangetires = "checked='checked'";
	$fmreportperformed = "checked='checked'";
	$fmothercosts = "checked='checked'";
	$fmreportfuel = "checked='checked'";
	$fmchangetires = "checked='checked'";
	$fmcurrentmileage = "checked='checked'";
	$fmcosts = "checked='checked'";

	if(pg_fetch_result($dsUsers, 0, "roleid") == "3")
	{
		$dsSett = query("select * from privilegessettings where userid=" . $userID);
		if(pg_num_rows($dsSett) == 0)
		{
			RunSQL("insert into privilegessettings (userid) values (" . $userID . ")");
			$dsSett = query("select * from privilegessettings where userid=" . $userID);
		}
		
		$reports1 = pg_fetch_result($dsSett, 0, "reports");
		$settings1 = pg_fetch_result($dsSett, 0, "settings");
		$routes1 = pg_fetch_result($dsSett, 0, "routes");
		$insertpoi1 = pg_fetch_result($dsSett, 0, "addpoi");
		$viewpoi1 = pg_fetch_result($dsSett, 0, "viewpoi");
		$insertzone1 = pg_fetch_result($dsSett, 0, "addzones");
		$viewzone1 = pg_fetch_result($dsSett, 0, "viewzones");
		$livetracking1 = pg_fetch_result($dsSett, 0, "livetracking");
		$dashboard1 = pg_fetch_result($dsSett, 0, "dashboard"); 
		$fleetreport1 = pg_fetch_result($dsSett, 0, "fleetreport");
		$overview1 = pg_fetch_result($dsSett, 0, "overview"); 
		$shortreport1 = pg_fetch_result($dsSett, 0, "shortreport");
		$detailreport1 = pg_fetch_result($dsSett, 0, "detailreport");
		$idlingreport1 = pg_fetch_result($dsSett, 0, "idlingreport");
		$visitedpoi1 = pg_fetch_result($dsSett, 0, "visitedpoi");
		$reconstruction1 = pg_fetch_result($dsSett, 0, "reconstruction");
		$distance1 = pg_fetch_result($dsSett, 0, "distance"); 
		$activity1 = pg_fetch_result($dsSett, 0, "activity");
		$maxspeed1 = pg_fetch_result($dsSett, 0, "maxspeed");
		$speedlimit1 = pg_fetch_result($dsSett, 0, "speedlimit");
		$exportexcel1 = pg_fetch_result($dsSett, 0, "exportexcel"); 
		$exportpdf1 = pg_fetch_result($dsSett, 0, "exportpdf");
		$sendmail1 = pg_fetch_result($dsSett, 0, "sendmail");
		$schedule1 = pg_fetch_result($dsSett, 0, "schedule");
		$generalsettings1 = pg_fetch_result($dsSett, 0, "generalsettings"); 
		$usersettings1 = pg_fetch_result($dsSett, 0, "usersettings");
		$groupspoi1 = pg_fetch_result($dsSett, 0, "groupspoi");
		$vehicles1 = pg_fetch_result($dsSett, 0, "vehicles");
		$ounits1 = pg_fetch_result($dsSett, 0, "ounits"); 
		$employees1 = pg_fetch_result($dsSett, 0, "employees");
		$worktime1 = pg_fetch_result($dsSett, 0, "worktime");
		$privilegesuser1 = pg_fetch_result($dsSett, 0, "privilegesuser");
		$routesnew1 = pg_fetch_result($dsSett, 0, "routesnew"); 
		$routespredefined1 = pg_fetch_result($dsSett, 0, "routespredefined");
		$routescurrent1 = pg_fetch_result($dsSett, 0, "routescurrent"); 
		$routesfuture1 = pg_fetch_result($dsSett, 0, "routesfuture");
		$routesall1 = pg_fetch_result($dsSett, 0, "routesall");
		$routessearch1 = pg_fetch_result($dsSett, 0, "routessearch");
		$fm1 = pg_fetch_result($dsSett, 0, "fm");
		$fmounits1 = pg_fetch_result($dsSett, 0, "fmounits");
		$fmvehicles1 = pg_fetch_result($dsSett, 0, "fmvehicles");
		$fmemployees1 = pg_fetch_result($dsSett, 0, "fmemployees");
		$fmchangetires1 = pg_fetch_result($dsSett, 0, "fmchangetires"); 
		$fmcurrentmileage1 = pg_fetch_result($dsSett, 0, "fmcurrentmileage");
		$fmcosts1 = pg_fetch_result($dsSett, 0, "fmcosts");
		$fmoverview1 = pg_fetch_result($dsSett, 0, "fmoverview");
		$fmreportcosts1 = pg_fetch_result($dsSett, 0, "fmreportcosts");
		$fmreportchangetires1 = pg_fetch_result($dsSett, 0, "fmreportchangetires");
		$fmreportperformed1 = pg_fetch_result($dsSett, 0, "fmreportperformed");
		$fmothercosts1 = pg_fetch_result($dsSett, 0, "fmothercosts");
		$fmreportfuel1 = pg_fetch_result($dsSett, 0, "fmreportfuel");
		$fmalerttires1 = pg_fetch_result($dsSett, 0, "fmalerttires"); 
		$fmalertservice1 = pg_fetch_result($dsSett, 0, "fmalertservice");
		$fmalertreg1 = pg_fetch_result($dsSett, 0, "fmalertreg");
		$fmeditcosts1 = pg_fetch_result($dsSett, 0, "fmeditcosts");

		if(!$reports1){
	        $reports = "";
		}
		if(!$settings1){
	        $settings = "";
		}
		if(!$routes1){
	        $routes = "";
		}
		if(!$insertpoi1){
	        $insertpoi = "";
		}
	    if(!$viewpoi1){
	        $viewpoi = "";
		}
	    if(!$insertzone1){
	        $insertzone = "";
		}
	    if(!$viewzone1){
	        $viewzone = "";
		}
		if(!$livetracking1){
	        $livetracking = "";
		}
		if(!$dashboard1){
			$dashboard = "";
		}
	    if(!$fleetreport1){
	        $fleetreport = "";
		}
		if(!$overview1){
	        $overview = "";
		}
	    if(!$shortreport1){
	        $shortreport = "";
		}
	    if(!$detailreport1){
	        $detailreport = "";
		}
	    if(!$idlingreport1){
	        $idlingreport = "";
	    }
		if(!$visitedpoi1){
	        $visitedpoi = "";
		}
	    if(!$reconstruction1){
	        $reconstruction = "";
		}
	    if(!$insertpoi1){
	        $insertpoi = "";
		}
		if(!$distance1){
	        $distance = "";
		}
	    if(!$activity1){
	        $activity = "";
		}
	    if(!$maxspeed1){
	        $maxspeed = "";
		}
	    if(!$speedlimit1){
	        $speedlimit = "";
	    }
	    if(!$exportexcel1){
	        $exportexcel = "";
		}
	    if(!$exportpdf1){
	        $exportpdf = "";
		}
	    if(!$sendmail1){
	        $sendmail = "";
		}
	    if(!$schedule1){
	        $schedule = "";
		}
	    if(!$generalsettings1){
	        $generalsettings = "";
		}
	    if(!$usersettings1){
	        $usersettings = "";
		}
	    if(!$groupspoi1){
	        $groupspoi = "";
		}
	    if(!$vehicles1){
	        $vehicles = "";
	    }
		if(!$ounits1){
	        $ounits = "";
		}
	    if(!$employees1){
	        $employees = "";
		}
	    if(!$worktime1){
	        $worktime = "";
		}
	    if(!$privilegesuser1){
	        $privilegesuser = "";
		}
	    if(!$routesnew1){
	        $routesnew = "";
		}
	    if(!$routespredefined1){
	        $routespredefined = "";
		}
	    if(!$routescurrent1){
	        $routescurrent = "";
		}
	    if(!$routesfuture1){
	        $routesfuture = "";
		}
	    if(!$routesall1){
	        $routesall = "";
		}
	    if(!$routessearch1){
	        $routessearch = "";
		}
	    if(!$fm1){
	        $fm = "";
		}
	    if(!$fmounits1){
	        $fmounits = "";
		}
	    if(!$fmvehicles1){
	        $fmvehicles = "";
		}
		if(!$fmemployees1){
	        $fmemployees = "";
		}
	    if(!$fmalerttires1){
	        $fmalerttires = "";
		}
	    if(!$fmalertservice1){
	        $fmalertservice = "";
		}
	    if(!$fmalertreg1){
	        $fmalertreg = "";
		}
		if(!$fmeditcosts1){
	        $fmeditcosts = "";
		}
	    if(!$fmoverview1){
	        $fmoverview = "";
		}
		if(!$fmreportcosts1){
	        $fmreportcosts = "";
		}
		if(!$fmreportchangetires1){
	        $fmreportchangetires = "";
		}
		if(!$fmreportperformed1){
	        $fmreportperformed = "";
		}
		if(!$fmothercosts1){
	        $fmothercosts = "";
		}
		if(!$fmreportfuel1){
	        $fmreportfuel = "";
		}
	    if(!$fmchangetires1){
	        $fmchangetires = "";
		}
	    if(!$fmcurrentmileage1){
	        $fmcurrentmileage = "";
		}
	    if(!$fmcosts1){
	        $fmcosts = "";
		}
	}
?>
<html>
<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="../js/jquery-ui.js"></script>
    <style type="text/css">
	<?php
	if($yourbrowser == "1")
	{?>
		html { 
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch; 
		}
		body {
		    height: 45%;
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch;
		    
		}
	<?php
	}
	?>
	</style>
	<style type="text/css"> 
 		body{ overflow-y:auto }
	</style>
</head>
<body>
    <div class="textTitle" style="width: 700px; position: relative; float: left; padding-left:36px; padding-top:25px;"><?php echo dic("Settings.Privileges")?> <?php echo dic("Settings.ForUser")?>: <?php echo pg_fetch_result($dsUsers, 0, "fullname")?></div>
	<div id="legend" class="textTitle" style="width: 300px; position: relative; float: right; right: 65px; padding-top:25px;">
    	<div class="ui-button ui-state-default ui-widget-content" style="font-size: 11px; float: right; padding-top: 5px; width: 80px; text-align: center; height: 20px; cursor: default;"><?php echo dic("Settings.UnMarked")?></div>
    	<div class="ui-button ui-state-active ui-widget-content" style="font-size: 11px; float: right; padding-top: 5px; width: 80px; text-align: center; height: 20px; cursor: default;"><?php echo dic("Settings.Marked")?></div>
    	<div style="float: right; padding-top: 2px; position: relative; width: 85px; font-size: 17px;"><?php echo dic("Reports.Legend")?>:</div>
    </div>
	<br /><br /><br />
    <p></p>
    <table width="94%" border="0" style="margin-top:0px; margin-left:35px;">
    	<tr>
        	<td colspan="2">
        		<div style="border-top:1px dotted #95B1d7"></div>
        	</td>
        </tr>
        <tr>
            <td class="text5" width="150px" style="font-weight:bold; vertical-align: top; padding-top: 10px;">
            	<div id="livetracking1" style="margin-left: 20px;">
            		<input type="checkbox" id="livetracking" <?php echo $livetracking?> /><label for="livetracking"><?php strtoupper(dic("Settings.LiveTracking"))?></label>
        		</div>
        	</td>
            <td class="text5" valign="middle" align="left" style="vertical-align: top; padding-bottom: 10px; padding-top: 10px;">
                <div id="livetracking2" style="margin-left: 23px;"> 
                  	<input type="checkbox" id="addpoi" <?php echo $insertpoi?>/><label for="addpoi"><?php echo dic("addPoi1")?></label>
                    <input type="checkbox" id="viewpoi" <?php echo $viewpoi?>/><label for="viewpoi"><?php echo dic("Settings.ViewPoi")?></label>
                    <input type="checkbox" id="addzones" <?php echo $insertzone?>/><label for="addzones"><?php echo dic("Settings.AddGeoFence")?></label>
                    <input type="checkbox" id="viewzones" <?php echo $viewzone?>/><label for="viewzones"><?php echo dic("Settings.ViewGeoFence")?></label>
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
            	<div id="reports0" style="margin-left: 20px;">
            		<input type="checkbox" id="reports" <?php echo $reports?> /><label for="reports"><?php strtoupper(dic("Settings.Reports"))?></label>
        		</div>
        	</td>
            <td style="vertical-align: top; padding-bottom: 10px; padding-top: 10px;">
            	<table border="0">
            		<tr><td class="text5" style="font-weight:bold"><?php strtoupper(dic("Settings.SummReports"))?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="Reports1" style="margin-left: 20px;"> 
		                  	<input type="checkbox" id="dashboard" <?php echo $dashboard?> /><label for="dashboard"><?php echo dic("Reports.Dashboard")?></label>
		                    <input type="checkbox" id="fleetreport" <?php echo $fleetreport?> /><label for="fleetreport"><?php echo dic("Settings.FleetReports1")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php strtoupper(dic("Settings.VehicleReports"))?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="Reports2" style="margin-left: 20px;"> 
		                  	<input type="checkbox" id="overview" <?php echo $overview?> /><label for="overview"><?php echo dic("Settings.Overview")?></label>
		                    <input type="checkbox" id="shortreport" <?php echo $shortreport?> /><label for="shortreport"><?php echo dic("Settings.ShortReport")?></label>
		                    <input type="checkbox" id="detailreport" <?php echo $detailreport?> /><label for="detailreport"><?php echo dic("Settings.DetailReport")?></label><br /><br />
		                    <input type="checkbox" id="idlingreport" <?php echo $idlingreport?> /><label for="idlingreport"><?php echo dic("Reports.IdlingReport")?></label>
		                    <input type="checkbox" id="visitedpoi" <?php echo $visitedpoi?> /><label for="visitedpoi"><?php echo dic("Reports.VisitedPOI")?></label>
		                    <input type="checkbox" id="reconstruction" <?php echo $reconstruction?> /><label for="reconstruction"><?php echo dic("Reports.Reconstruction")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php strtoupper(dic("Settings.Analysis"))?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="Reports3" style="margin-left: 20px;"> 
		                  	<input type="checkbox" id="distance" <?php echo $distance?> /><label for="distance"><?php echo dic("Reports.DistanceTravelled")?></label>
		                    <input type="checkbox" id="activity" <?php echo $activity?> /><label for="activity"> <?php echo dic("Settings.Activity")?></label>
		                    <input type="checkbox" id="maxspeed" <?php echo $maxspeed?> /><label for="maxspeed"><?php echo dic("Settings.MaxSpeed")?></label>
		                    <input type="checkbox" id="speedlimit" <?php echo $speedlimit?> /><label for="speedlimit"><?php echo dic("Settings.SpeedLimitExcess")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php strtoupper(dic("Settings.Export"))?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="Reports4" style="margin-left: 20px;"> 
		                  	<input type="checkbox" id="exportexcel" <?php echo $exportexcel?> /><label for="exportexcel"><?php echo dic("Settings.ExportExcel")?></label>
		                    <input type="checkbox" id="exportpdf" <?php echo $exportpdf?> /><label for="exportpdf"> <?php echo dic("Settings.ExportPdf")?></label>
		                    <input type="checkbox" id="sendmail" <?php echo $sendmail?> /><label for="sendmail"><?php echo dic("Settings.SendMail")?></label>
		                    <input type="checkbox" id="schedule" <?php echo $schedule?> /><label for="schedule"><?php echo dic("Settings.ScheduleRep")?></label>
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
            	<div id="settings0" style="margin-left: 20px;">
            		<input type="checkbox" id="settings" <?php echo $settings?> /><label for="settings"><?php strtoupper(dic("Settings.Settings"))?></label>
        		</div>
			</td>
            <td class="text5" valign="middle" align="left" style="vertical-align: top; padding-bottom: 10px; padding-top: 10px;">
                <div id="SettingsSettings" style="margin-left: 23px;">
                  	<input type="checkbox" id="generalsettings" <?php echo $generalsettings?>/><label for="generalsettings"><?php echo dic("Settings.GeneralSett")?></label>
                    <input type="checkbox" id="usersettings" <?php echo $usersettings?>/><label for="usersettings"><?php echo dic("Settings.UserSett")?></label>
                    <input type="checkbox" id="groupspoi" <?php echo $groupspoi?>/><label for="groupspoi">Групи на точки од интерес</label>
                    <input type="checkbox" id="vehicles" <?php echo $vehicles?>/><label for="vehicles"><?php echo dic("Fm.Vehicles")?></label><br /><br />
                    <input type="checkbox" id="ounits" <?php echo $ounits?>/><label for="ounits"><?php echo dic("Fm.OrgUnits")?></label>
                    <input type="checkbox" id="employees" <?php echo $employees?>/><label for="employees"><?php echo dic("Fm.Employees")?></label>
                    <input type="checkbox" id="worktime" <?php echo $worktime?>/><label for="worktime"><?php echo dic("Settings.WorkTime")?></label>
                    <input type="checkbox" id="privilegesuser" <?php echo $privilegesuser?>/><label for="privilegesuser"><?php echo dic("Settings.Privileges")?></label>
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
            	<div id="routes0" style="margin-left: 20px;">
            		<input type="checkbox" id="routes" <?php echo $routes?> /><label for="routes"><?php strtoupper(dic("Main.routess"))?></label>
        		</div>
			</td>
            <td style="vertical-align: top; padding-bottom: 10px; padding-top: 10px;">
            	<table border="0">
            		<tr><td class="text5" style="font-weight:bold"><?php echo dic("Settings.Warrants")?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="Routes1" style="margin-left: 20px;">
		                  	<input type="checkbox" id="routesnew" <?php echo $routesnew?> /><label for="routesnew"><?php echo dic("Settings.NewWarrant")?></label>
		                    <input type="checkbox" id="routespredefined" <?php echo $routespredefined?> /><label for="routespredefined"><?php echo dic("Settings.PredefinedWarrants")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php strtoupper(dic("Settings.Overview"))?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="Routes2" style="margin-left: 20px;">
		                  	<input type="checkbox" id="routescurrent" <?php echo $routescurrent?> /><label for="routescurrent"><?php echo dic("Settings.WarrantsInProgress")?></label>
		                    <input type="checkbox" id="routesfuture" <?php echo $routesfuture?> /><label for="routesfuture"><?php echo dic("Settings.WarrantsFDate")?></label>
		                    <input type="checkbox" id="routesall" <?php echo $routesall?> /><label for="routesall"><?php echo dic("Settings.ALlWarrants")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php strtoupper(dic("Settings.Reports"))?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="Routes3" style="margin-left: 20px;">
		                  	<input type="checkbox" id="routessearch" <?php echo $routessearch?> /><label for="routessearch"><?php echo dic("search")?></label>
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
            	<div id="fleetmanagement" style="margin-left: 20px;">
            		<input type="checkbox" id="fm" <?php echo $fm?> /><label for="fm"><?php strtoupper(dic("Main.FleetManagement"))?></label>
        		</div>
        	</td>
            <td style="vertical-align: top; padding-bottom: 10px; padding-top: 10px;">
            	<table border="0">
            		<tr><td class="text5" style="font-weight:bold"><?php echo dic("Fm.Sifrarnici")?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="fm1" style="margin-left: 20px;">
		                  	<input type="checkbox" id="fmounits" <?php echo $fmounits?> /><label for="fmounits"><?php echo dic("Fm.OrgUnits")?></label>
		                    <input type="checkbox" id="fmvehicles" <?php echo $fmvehicles?> /><label for="fmvehicles"><?php echo dic("Fm.Vehicles")?></label>
		                    <input type="checkbox" id="fmemployees" <?php echo $fmemployees?> /><label for="fmemployees"><?php echo dic("Fm.Employees")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php echo dic("Fm.OperPerf")?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="fm2" style="margin-left: 20px;">
		                  	<input type="checkbox" id="fmchangetires" <?php echo $fmchangetires?> /><label for="fmchangetires"><?php echo dic("Fm.ChTires")?></label>
		                    <input type="checkbox" id="fmcurrentmileage" <?php echo $fmcurrentmileage?> /><label for="fmcurrentmileage"><?php echo dic("Fm.CurrKm")?></label>
		                    <input type="checkbox" id="fmcosts" <?php echo $fmcosts?> /><label for="fmcosts"><?php echo dic("Fm.Costs")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php echo dic("reports")?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="fm3" style="margin-left: 20px;"> 
		                  	<input type="checkbox" id="fmoverview" <?php echo $fmoverview?> /><label for="fmoverview"><?php echo dic("Reports.Overview")?></label>
		                  	<input type="checkbox" id="fmreportcosts" <?php echo $fmreportcosts?> /><label for="fmreportcosts"><?php echo dic("Fm.CostsReport1")?></label>
		                  	<input type="checkbox" id="fmreportchangetires" <?php echo $fmreportchangetires?> /><label for="fmreportchangetires"><?php echo dic("Fm.ReportTires")?></label>
		                  	<br /><br />
		                  	<input type="checkbox" id="fmreportperformed" <?php echo $fmreportperformed?> /><label for="fmreportperformed"><?php echo dic("Fm.ReportServices")?></label>
		                  	<input type="checkbox" id="fmothercosts" <?php echo $fmothercosts?> /><label for="fmothercosts"><?php echo dic("Fm.ReportCosts")?></label>
		                  	<input type="checkbox" id="fmreportfuel" <?php echo $fmreportfuel?> /><label for="fmreportfuel"><?php echo dic("Fm.ReportFuel")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php echo dic("Fm.Alerts")?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="fm4" style="margin-left: 20px;">
		                  	<input type="checkbox" id="fmalerttires" <?php echo $fmalerttires?> /><label for="fmalerttires"><?php echo dic("Fm.AlertTires")?></label>
		                    <input type="checkbox" id="fmalertservice" <?php echo $fmalertservice?> /><label for="fmalertservice"><?php echo dic("Fm.AlertService")?></label>
		                    <input type="checkbox" id="fmalertreg" <?php echo $fmalertreg?> /><label for="fmalertreg"><?php echo dic("Fm.AlertRegistration")?></label>
		                </div>
            		</td></tr>
            		<tr height="50px"><td class="text5" valign="bottom"" style="font-weight:bold"><?php echo dic_("Reports.Costs")?></td></tr>
            		<tr><td class="text5" valign="middle" align="left">
            			<div id="fm5" style="margin-left: 20px;">
		                  	<input type="checkbox" id="fmeditcosts" <?php echo $fmeditcosts?> /><label for="fmeditcosts"><?php echo dic_("Lang.Edit")?> / <?php echo dic_("Fm.Delete")?></label>
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
        		<button id="btnSave" onclick="AddPrivilegesSettings('<?php echo $userID?>')"><?php dic("Settings.SaveSettings")?></button>
        		<button id="btncancel3" onclick="selectall()"><?php dic("Settings.SelectAll") ?></button>
        		<button id="btncancel2" onclick="cancel()"><?php dic("Fm.Cancel") ?></button>
        	</td>
        </tr>
    </table>
	<br />
	<br />
</body>

</html>

<script type="text/javascript">
	var clickAll = true;
	function cancel() {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "CSettings.php?l=" + '<?php echo $cLang ?>';
    }
    function selectall() {
    	if(clickAll)
    	{
    		$(":checkbox").each(function() {
				$(this).attr("checked","checked").button('refresh');
	        });
	        clickAll = false;
    	}else
    	{
    		$(":checkbox").each(function() {
				$(this).attr("checked","").button('refresh');
	        });
	        clickAll = true;
    	}
    }

    $(function () {
    	top.HideWait();
        //document.getElementById('radio1').checked = true
        $('#livetracking1').buttonset();
        $('#livetracking2').buttonset();
        $('#Reports1').buttonset();
        $('#Reports2').buttonset();
        $('#Reports3').buttonset();
        $('#Reports4').buttonset();
        $('#fm1').buttonset();
        $('#fm2').buttonset();
        $('#fm3').buttonset();
        $('#fm4').buttonset();
        $('#fm5').buttonset();
        $('#Routes1').buttonset();
        $('#Routes2').buttonset();
        $('#Routes3').buttonset();
        $('#SettingsSettings').buttonset();
        $('#fleetmanagement').buttonset();
        $('#reports0').buttonset();
        $('#settings0').buttonset();
        $('#routes0').buttonset();
        $('#btnSave').button({ icons: { primary: "ui-icon-check"} });
        $('#btncancel2').button({ icons: { primary: "ui-icon-arrowreturnthick-1-w"} });
        $('#btncancel3').button({ icons: { primary: "ui-icon-check"} });
    });
    //SettingsMeni(1)
</script>
  <?php
	closedb();
?>