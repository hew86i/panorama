<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        
        
<title></title>
        <style>
        .cornerCol {
        	-moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px;
        }
        .blink_me {
		    -webkit-animation-name: blinker;
		    -webkit-animation-duration: 1s;
		    -webkit-animation-timing-function: linear;
		    -webkit-animation-iteration-count: infinite;
		    
		    -moz-animation-name: blinker;
		    -moz-animation-duration: 1s;
		    -moz-animation-timing-function: linear;
		    -moz-animation-iteration-count: infinite;
		    
		    animation-name: blinker;
		    animation-duration: 1s;
		    animation-timing-function: linear;
		    animation-iteration-count: infinite;
		}
		
		@-moz-keyframes blinker {  
		    0% { opacity: 1.0; }
		    50% { opacity: 0.0; }
		    100% { opacity: 1.0; }
		}
		
		@-webkit-keyframes blinker {  
		    0% { opacity: 1.0; }
		    50% { opacity: 0.0; }
		    100% { opacity: 1.0; }
		}
		
		@keyframes blinker {  
		    0% { opacity: 1.0; }
		    50% { opacity: 0.0; }
		    100% { opacity: 1.0; }
		}
        body{
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }
        .fixed {
            position: absolute;
            width: calc(99% + 22px);
            top: 30px;
        }
        .fixed td, .fixed th {
            border: 1px solid #cccccc;
           
        }
        .fixed th {
            border: 1px solid #009900;
           
        }
        .fixed tr:first-child {
            display: table;
            position: fixed;
            width: calc(99% - 44px);
            z-index: 1;
            background: #FFFFFF;
            top: 49px;
	    	margin-left: -1px;          
        }
        .divTitle {
  			font-weight: bold; 
  			font-size:12px; 
  			border:1px solid #009900;
  			background-color:#AAF2AA;	
  			color:#000000;
  		}
  		.divTr {
  			font-size:12px; 
  			background-color:#f3f3f3;	
  			color:#000000;	
  			border:1px solid #cccccc;
  		}
  		.divTr1 {
  			font-size:12px; 
  			background-color:#ffffff;
  			color:#626262;
  			border:1px solid #cccccc;
  		}
  		.text5{font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#2f5185; text-decoration: none}
  		.{-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px}
  		
  		.trhover:hover td {background-color:#e3e3e3; cursor:pointer; color:#009900; border:1px solid #bfbfbf}
.ui-widget { font-family: Arial,Helvetica,sans-serif; font-size: 11px; }
.ui-widget-header { background: transparent; color: #414141; font-size: 16px; font-weight: bold; height: 30px; border:0px; border-bottom: 1px solid #CCCCCC; }
.ui-widget-header { color: #414141; }
.ui-widget-header .ui-icon {background-image: url("../css/ui-lightness/images/ui-icons_222222_256x240.png");}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default { border: 1px solid #cccccc; background-color: #f6f6f6; font-weight: normal; color: #2f5185; }
.ui-widget-overlay { background: #666666 url("../css/ui-lightness/images/ui-bg_diagonals-thick_20_666666_40x40.png") 50% 50% repeat; opacity: .50;filter:Alpha(Opacity=50); }
/*.ui-widget-overlay { background: transparent; opacity: .50;filter:Alpha(Opacity=50); }*/
/*.ui-widget-content .ui-icon {background-image: url("../css/ui-lightness/images/ui-icons_222222_256x240.png");}*/
        </style>
</head>
	<script>
		lang = '<?php echo $cLang?>'
	</script>
	
	<!--script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	<script type="text/javascript" src="reports.js"></script>
    <script src="../js/jquery-ui.js"></script-->
    
    <script>
  		if (<?php echo nnull(is_numeric(nnull(getQUERY("uid"))), 0) ?> == 0){
  			if (<?php echo nnull(is_numeric(nnull(session("user_id"))), 0) ?> == 0)
  				top.window.location = "../sessionexpired/?l=" + '<?php echo $cLang ?>';
  		} 
  	</script>
  	
  	<style>
  
  	</style>
  	
<?php
		
	if (nnull(is_numeric(nnull(getQUERY("uid"))), 0)>0){
		$uid = getQUERY("uid");
		$cid = getQUERY("cid");	
	} else {
		$uid = session("user_id");
		$cid = session("client_id");
	}

    $langArr = explode("?", getQUERY("l"));
	$cLang = $langArr[0];
	
    opendb();
		
	$dsUsersSett = query("select * from users where id = " . $uid);
	$clientType = dlookup("select clienttypeid from clients where ID=" . session("client_id")); 
	//VEHICLE DETAILS
	if (dlookup("SELECT count(*) FROM vehicledetailscolumns where userid = " . $uid) > 0) {
	$dsVehDetCol = query("select * from vehicledetailscolumns where userid = " . $uid);
	$ddriver = pg_fetch_result($dsVehDetCol, 0, 'ddriver');
	$dtime = pg_fetch_result($dsVehDetCol, 0, 'dtime');
	$dodometer = pg_fetch_result($dsVehDetCol, 0, 'dodometer');
	$dspeed = pg_fetch_result($dsVehDetCol, 0, 'dspeed');
	$dlocation = pg_fetch_result($dsVehDetCol, 0, 'dlocation');
	$dpoi = pg_fetch_result($dsVehDetCol, 0, 'dpoi');
	$dzone = pg_fetch_result($dsVehDetCol, 0, 'dzone');
	$dntours = pg_fetch_result($dsVehDetCol, 0, 'dntours');
	$dprice = pg_fetch_result($dsVehDetCol, 0, 'dprice');
	$dtaximeter = pg_fetch_result($dsVehDetCol, 0, 'dtaximeter');
	$dpassengers = pg_fetch_result($dsVehDetCol, 0, 'dpassengers');
	} else {
		$ddriver = '1';
		$dtime = '1';
		$dodometer = '1';
		$dspeed = '1';
		$dlocation = '1';
		$dpoi = '1';
		$dzone = '1';
		if ($clientType == 2) {
			$dntours = '1';
			$dprice = '1';
			$dtaximeter = '1';
			$dpassengers = '1';
		} else {
			$dntours = '0';
			$dprice = '0';
			$dtaximeter = '0';
			$dpassengers = '0';
		}
	}
	//VEHICLE DETAILS
	$metric = pg_fetch_result($dsUsersSett, 0, 'metric');
	$currency = pg_fetch_result($dsUsersSett, 0, 'currency'); 
	$currencyvalue = dlookup("select value from currency where name='" . $currency . "'"); 
	$currency = strtolower($currency);
	
	if ($metric == 'mi') {
		$metricvalue = 0.621371;
		$speedunit = "mph";
	}	
	else {
		$metricvalue = 1;
		$speedunit = "Km/h";
	}
	
	$Allow = getPriv("idlingreport", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
	
	$vh = getQUERY("v");

	$datetimeformat = pg_fetch_result($dsUsersSett, 0, 'datetimeformat');
		
	$datfor = explode(" ", $datetimeformat);
	$dateformat = $datfor[0];
	$timeformat =  $datfor[1];
	if ($timeformat == 'h:i:s') $timeformat = $timeformat . " a";
	
	if ($timeformat == "H:i:s") {
		$e_ = " 23:59";
		$e1_ = "_23:59";
		$s_ = " 00:00";
		$s1_ = "_00:00";
		$tf = " H:i";
	}	else {
		$e_ = " 11:59 PM";
		$e1_ = "_11:59_PM";
		$s_ = " 12:00 AM";
		$s1_ = "_12:00_AM";
		$tf = " h:i a";
	}		
	
    /*$sdG = DateTimeFormat(getQUERY("sd"), 'd-m-Y H:i:s');
	$edG = DateTimeFormat(getQUERY("ed"), 'd-m-Y H:i:s');
	
    $sd = DateTimeFormat(getQUERY("sd"), $dateformat) . $s_; //'01-09-2012 00:00';
    $ed = DateTimeFormat(getQUERY("ed"), $dateformat) . $e_; //'01-09-2012 23:59';

	$tzone = pg_fetch_result($dsUsersSett, 0, 'tzone');  
	$CreationDate = strtoupper(DateTimeFormat(addToDateU(now(), $tzone, "hour", "Y-m-d H:i"), $datetimeformat));*/  

	$_SESSION["user_fullname"] = pg_fetch_result($dsUsersSett, 0, 'fullname');
	$_SESSION["company"] = dlookup("select name from clients where id in (select clientid from users where id=" . $uid . " limit 1) limit 1");
	    
    If (strrpos(strtoupper(Session("user_fullname")), "DEMO") > 0)  $_SESSION["company"] = dic_("Reports.DemoCompany");
    	
	
	if ($_SESSION['role_id'] == "2") { 
        $sqlV = "select id from vehicles where clientID=" . $cid . " and active='1' and visible='1'";
	} else {
		$sqlV = "select vehicleID from uservehicles uv left outer join vehicles v on v.id=uv.vehicleid where userID=" . $uid . " and v.active='1' and v.visible='1'";
	}
	$dsVehicles = query("select * from vehicles where id in (" . $sqlV. ") order by organisationid desc, cast(code as integer) asc"); 
?>
<body>
<div id="dialog-messageHideCol" title="<?php echo dic("Tracking.Message")?>" style="display:none;">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgboxHideCol" style="font-size:14px; padding-left: 23px;"></div>
	</p>
    <div id="DivInfoForAllHideCol" style="font-size:11px; padding-left: 23px;">
    	<input id="InfoForAllHideCol" type="checkbox" /><?php echo dic("Tracking.InfoMsg")?>
    </div>
</div>

<?php
$cnt = 0;	
$lastOrgName = "";
$colspan = 8;	
if($clientType == 2) $colspan = 12;		
 
$ddriverS = ""; 
$dtimeS = ""; 
$dodometerS = ""; 
$dspeedS = ""; 
$dlocationS = ""; 
$dpoiS = ""; 
$dzoneS = ""; 
$dntoursS = ""; 
$dpriceS = ""; 
$dtaximeterS = ""; 
$dpassengersS = ""; 

if ($ddriver == '0') {$ddriverS = "display: none"; $colspan--;}
if ($dtime == '0') {$dtimeS = "display: none"; $colspan--;}
if ($dodometer == '0') {$dodometerS = "display: none"; $colspan--;}
if ($dspeed == '0') {$dspeedS = "display: none"; $colspan--;}
if ($dlocation == '0') {$dlocationS = "display: none"; $colspan--;}
if ($dpoi == '0') {$dpoiS = "display: none"; $colspan--;}
if ($dzone == '0') {$dzoneS = "display: none"; $colspan--;}
if ($clientType == 2) {
	if ($dntours == '0') {$dntoursS = "display: none"; $colspan--;}
	if ($dprice == '0') {$dpriceS = "display: none"; $colspan--;}
	if ($dtaximeter == '0') {$dtaximeterS = "display: none"; $colspan--;}
	if ($dpassengers == '0') {$dpassengersS = "display: none"; $colspan--;}
}
?>
<table class="gridView" id="table1" cellpadding="0" cellspacing="1">
        <thead>
            <tr>
                <th height=30px style="font-size:11px;" align="center" class="corner5 text5 divTitle"><strong><?= dic_("Reports.Vehicle")?></strong></th>
				<th height=30px style="font-size:11px; <?=$ddriverS?>" align="center" class="corner5 text5 divTitle colDriver">
					<strong><?= dic_("Reports.Driver")?></strong>
					<span onclick="hideColumn('colDriver')"><img class="cornerCol" src="../images/stikla4.png" height=8px style="padding:1px 0px 1px 1px; border:1px solid #2f5185; cursor: pointer; float: right; margin-right:5px; top:2px"/></span>
				</th>
				<th height=30px style="font-size:11px; <?=$dtimeS?>" align="center" class="corner5 text5 divTitle colTime">
					<strong><?= dic_("Time")?></strong>
					<span onclick="hideColumn('colTime')"><img class="cornerCol" src="../images/stikla4.png" height=8px style="padding:1px 0px 1px 1px; border:1px solid #2f5185; cursor: pointer; float: right; margin-right:5px; top:2px"/></span>
				</th>
				<th height=30px style="font-size:11px; <?=$dodometerS?>" align="center" class="corner5 text5 divTitle colOdometer">
					<strong><?= dic_("Reports.Odometer")?></strong>
					<span onclick="hideColumn('colOdometer')"><img class="cornerCol" src="../images/stikla4.png" height=8px style="padding:1px 0px 1px 1px; border:1px solid #2f5185; cursor: pointer; float: right; margin-right:5px; top:2px"/></span>
				</th>
				<th height=30px style="font-size:11px; <?=$dspeedS?>" align="center" class="corner5 text5 divTitle colSpeed">
					<strong><?= dic_("Speed")?></strong>
					<span onclick="hideColumn('colSpeed')"><img class="cornerCol" src="../images/stikla4.png" height=8px style="padding:1px 0px 1px 1px; border:1px solid #2f5185; cursor: pointer; float: right; margin-right:5px; top:2px"/></span>
				</th>
				<th height=30px style="font-size:11px; <?=$dlocationS?>" align="center" class="corner5 text5 divTitle colLocation">
					<strong><?= dic_("Reports.Location")?></strong>
					<span onclick="hideColumn('colLocation')"><img class="cornerCol" src="../images/stikla4.png" height=8px style="padding:1px 0px 1px 1px; border:1px solid #2f5185; cursor: pointer; float: right; margin-right:5px; top:2px"/></span>
				</th>
				<th height=30px style="font-size:11px; <?=$dpoiS?>" align="center" class="corner5 text5 divTitle colPoi">
					<strong><?= dic_("Settings.Poi1")?></strong>
					<span onclick="hideColumn('colPoi')"><img class="cornerCol" src="../images/stikla4.png" height=8px style="padding:1px 0px 1px 1px; border:1px solid #2f5185; cursor: pointer; float: right; margin-right:5px; top:2px"/></span>
				</th>
				<th height=30px style="font-size:11px; <?=$dzoneS?>" align="center" class="corner5 text5 divTitle colZone">
					<strong><?= dic_("GeoFence")?></strong>
					<span onclick="hideColumn('colZone')"><img class="cornerCol" src="../images/stikla4.png" height=8px style="padding:1px 0px 1px 1px; border:1px solid #2f5185; cursor: pointer; float: right; margin-right:5px; top:2px"/></span>
				</th>
				
				<?php
				if ($clientType == 2) {
				?>
				<th height=30px style="font-size:11px; <?=$dntoursS?>" align="center" class="corner5 text5 divTitle colNTours">
					<strong><?= dic_("Reports.NoTours1")?></strong>
					<span onclick="hideColumn('colNTours')"><img class="cornerCol" src="../images/stikla4.png" height=8px style="padding:1px 0px 1px 1px; border:1px solid #2f5185; cursor: pointer; float: right; margin-right:5px; top:2px"/></span>
				</th>
				<th height=30px style="font-size:11px; <?=$dpriceS?>" align="center" class="corner5 text5 divTitle colPrice">
					<strong><?= dic_("Reports.Price")?></strong>
					<span onclick="hideColumn('colPrice')"><img class="cornerCol" src="../images/stikla4.png" height=8px style="padding:1px 0px 1px 1px; border:1px solid #2f5185; cursor: pointer; float: right; margin-right:5px; top:2px"/></span>
				</th>
				<th height=30px style="font-size:11px; <?=$dtaximeterS?>" align="center" class="corner5 text5 divTitle colTaximeter">
					<strong><?= dic_("Reports.Taximeter")?></strong>
					<span onclick="hideColumn('colTaximeter')"><img class="cornerCol" src="../images/stikla4.png" height=8px style="padding:1px 0px 1px 1px; border:1px solid #2f5185; cursor: pointer; float: right; margin-right:5px; top:2px"/></span>
				</th>
				<th height=30px style="font-size:11px; <?=$dpassengersS?>" align="center" class="corner5 text5 divTitle colPassengers">
					<strong><?= dic_("Reports.Passengers")?></strong>
					<span onclick="hideColumn('colPassengers')"><img class="cornerCol" src="../images/stikla4.png" height=8px style="padding:1px 0px 1px 1px; border:1px solid #2f5185; cursor: pointer; float: right; margin-right:5px; top:2px"/></span>
				</th>
				<?php	
				}
				?>
            </tr>
        </thead>
        
        
         <tbody>
	 			
<?php
		 
      		while ($drVehicle = pg_fetch_array($dsVehicles)) {
      			$todayData = 0;
      			if ($drVehicle["organisationid"] == 0) $orgName = dic_("Reports.UngroupedVehicles");
				else $orgName = dlookup("select code || '. ' || name from organisation where id=" . $drVehicle["organisationid"] . " and clientid=" . $cid);
				
				$passrup = '';
				if ($drVehicle["deviceid"] == 15) {
					$passrup = 'ruptela';
				}
									
      			$dsCurrPos = query("select * from currentposition where vehicleid=" . $drVehicle["id"]);
      			$ignCol = "";
      			$pass = 0;
				$taxi = 0;
				$ign = "";
      			if ($clientType == 2) {
      				$dsPorts = query("select * from vehicleport where vehicleid=" . $drVehicle["id"] . " and porttypeid in (2,5,1) order by porttypeid asc");
      				$ignCol = pg_fetch_result($dsPorts, 2, "portname");
					$taxiCol = pg_fetch_result($dsPorts, 0, "portname");
					$passCol = pg_fetch_result($dsPorts, 1, "portname");
					$pass = dlookup("select getpassengers" . $passrup . "(" . pg_fetch_result($dsCurrPos, 0, $passCol) . ")");
					$taxi = pg_fetch_result($dsCurrPos, 0, $taxiCol);
      			} else {
      				$dsPorts = query("select * from vehicleport where vehicleid=" . $drVehicle["id"] . " and porttypeid in (1) order by porttypeid asc");
      				$ignCol = pg_fetch_result($dsPorts, 0, "portname");
      			}
      			$ign = pg_fetch_result($dsCurrPos, 0, $ignCol);
      			
      			if ($lastOrgName <> $orgName) {
      				$cnt = 0;
      				?>
      				<tr height="5px">
      					<td align="left" height="30px" colspan=<?= $colspan?> style="font-size:11px; font-weight: bold; border:0">
                  			<div style="height:10px"></div><div style="font-weight: bold; padding-top:8px; height: 22px; border:1px solid #80D180; background-color:#DBFDEA;" class="corner5 text5" valign:middle;="">&nbsp;&nbsp;&nbsp;<?= $orgName?></div>
                  		</td>
      				</tr>     				
      				<?php
      			}
				if ($cnt % 2 == 0) $classTr = "divTr1";
				else $classTr = "divTr";
      		?>
             		        
	        <tr class="trhover">
	            <td style="height:24px; <?php if($clientType == 2) $width=7; else $width=11; ?> width:<?=$width?>%; font-size:11px;" align="center" class="corner5 text5 <?=$classTr?>">


						<div id="vehicle-<?= $drVehicle["id"]?>" style="text-align:left; padding-left:3px; font-weight:bold">
	            			<?= $drVehicle["registration"] . " (".$drVehicle["code"].")"?>
	            			<font id="intour-<?= $drVehicle["id"]?>" style='display:none; font-size:10px; color:red'>во тура</font>	            			
	            		</div>	
	            </td>

	            <td style="<?=$ddriverS?>; <?php if($clientType == 2) $width=8; else $width=11; ?> width:<?=$width?>%; font-size:11px; padding-left:3px" align="left" class="corner5 text5 <?=$classTr?> colDriver">
		            	<?php
		            		$drivers = nnull(dlookup("select getdrivernew1('" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "', '" . DateTimeFormat(now(),"Y-m-d H:i:s") . "', " . $drVehicle["id"] . ")"), "/");
		            		//echo $drivers;
		            	?>
		            	<span id="spanDriver-<?= $drVehicle["id"]?>"><?= $drivers?></span>
	            </td>
	            <td style="<?=$dtimeS?>; <?php if($clientType == 2) $width=8; else $width=11; ?> width:<?=$width?>%; font-size:11px" align="center" class="corner5 text5 <?=$classTr?> colTime">
	            	<?php
	            	$cntH = dlookup("select count(*) from historylog where vehicleid=" . $drVehicle["id"] . " and datetime between '" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "' and '" . DateTimeFormat(now(),"Y-m-d H:i:s") . "'");
	            	$firstIgnsOn = "/";
	            	if ($cntH > 0)
	            		$firstIgnsOn = nnull(dlookup("select datetime from historylog where vehicleid=" . $drVehicle["id"] . " and datetime between '" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "' and '" . DateTimeFormat(now(),"Y-m-d H:i:s") . "' order by datetime asc limit 1"), "/");
	            	$ign1 = "";
	            	if ($firstIgnsOn <> "/") {
	            		$ign1 = DateTimeFormat($firstIgnsOn, $timeformat);
					} else {
						$ign1 = $firstIgnsOn;
					}
					?>
					
					<span id="spanIgn1-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'><?=dic("Reports.TimeFirstIgnOn")?></span>')"><?=$ign1?></span>
					
					<?php
					echo " - ";
					$dtCurrPos = pg_fetch_result($dsCurrPos, 0, "\"DateTime\"");
					$ign2 = "/";
					if (pg_fetch_result($dsCurrPos, 0, "\"DateTime\"") > DateTimeFormat(now(), 'Y-m-d 00:00:00')) {
						$todayData = 1;
						$ign2 = DateTimeFormat($dtCurrPos, $timeformat);
					}
					?>
					<span id="spanIgn2-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'><?=dic("Reports.TimeLastData")?></span>')" onmouseout="HidePopup()"><?=$ign2?></span>
					<?php
					echo "<br>";
					
					$ignTotal = "/";
					if ($firstIgnsOn <> "/")
						$ignTotal = Sec2Str(dlookup("select datediff('', '" . $firstIgnsOn . "', '" . $dtCurrPos . "')"));						
	            	?>
	            	<?=dic_("Reports.Tot")?> <span id="spanIgnTotal-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'><?=dic("Reports.TotalTimeBetween")?></span>')" onmouseout="HidePopup()"> <?=$ignTotal?></span>
	            </td>
	            <td style="<?=$dodometerS?>; <?php if($clientType == 2) $width=11; else $width=15; ?> width:<?=$width?>%; font-size:11px" align="center" class="corner5 text5 <?=$classTr?> colOdometer">
		            	<?php
	            			$all_rastojanie = dlookup("select getdistancenew('" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "', '" . DateTimeFormat(now(),"Y-m-d H:i:s") . "', " . $drVehicle["id"] . ")");
	            			//echo number_format(round($all_rastojanie*$metricvalue, 1)) . " " . $metric;	
	            		?>
		            	
		            	<?php
		            		$currOdometer = "/";
							$od1 = "/";
							$od2 = "/";
							$odTot = "/";
		            		if ($drVehicle["allowcanbas"] == '1' && $drVehicle["deviceid"] != 9 && $drVehicle["deviceid"] != 21) {
		            			$currOdometer = round(pg_fetch_result($dsCurrPos, 0, "cbdistance")/1000*$metricvalue, 1);
								$od1 = number_format($currOdometer-(round($all_rastojanie*$metricvalue, 1))) . " " . $metric;
		            			$od2 = number_format($currOdometer) . " " . $metric;
							} else {
								$cntC = dlookup("select count(*) from odometer where vehicleid=".$drVehicle["id"]);
								if ($cntC > 0) {
									/**$currOdometer = round(nnull(dlookup("select km from odometer where vehicleid=".$drVehicle["id"]),0)*$metricvalue, 1);
									$od1 = number_format($currOdometer-(round($all_rastojanie*$metricvalue, 1))) . " " . $metric;
									$od2 = number_format($currOdometer) . " " . $metric;*/
									$currOdometer = round(nnull(dlookup("select km from odometer where vehicleid=".$drVehicle["id"]),0), 1);
									$od1 = number_format($currOdometer-(round($all_rastojanie*$metricvalue, 1))) . " " . $metric;
									$od2 = number_format($currOdometer) . " " . $metric;									
								}
							}
							$odTot = number_format(round($all_rastojanie*$metricvalue, 1)) . " " . $metric;
							if ($todayData == 0) {
								$od1 = "/"; $odTot = "/";
							}
		            	?>
		            	<span id="spanOd1-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'><?=dic("Reports.OdometerStart")?></span>')" onmouseout="HidePopup()"><?=$od1?></span>-<span id="spanOd2-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'><?=dic("Reports.CurrOdometer")?></span>')" onmouseout="HidePopup()"><?=$od2?></span> <br><?=dic_("Reports.Tot")?><span id="spanOdTot-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'><?=dic("Reports.PastDistDay")?></span>')" onmouseout="HidePopup()"><?=$odTot?></span>
	            </td>
	            <td style="<?=$dspeedS?>; <?php if($clientType == 2) $width=7; else $width=11; ?> width:<?=$width?>%; font-size:11px" align="center" class="corner5 text5 <?=$classTr?> colSpeed">
	            		<span id="spanSpeed-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'><?=dic("Reports.CurrSpeed")?></span>')" onmouseout="HidePopup()">
	            			<?php
	            			if(pg_fetch_result($dsCurrPos, 0, "speed") == "/")
							{
								$speed = pg_fetch_result($dsCurrPos, 0, "speed");
							} else
							{
								if (pg_fetch_result($dsCurrPos, 0, "di1") == 0) {
									$speed = '0 Km/h';
									if($metric == "mi")
										$speed = '0 mph';
								} else {
									$speed = round(pg_fetch_result($dsCurrPos, 0, "speed"), 0) . ' Km/h';
									if($metric == "mi")
										$speed = round(round((pg_fetch_result($dsCurrPos, 0, "speed")*0.621371)*100)/100) . ' mph';
								}
							}
	            			?>
	            			<?= $speed?>
	            		</span>
	            		<br>max: <?php
						$maxspeed = nnull(round(dlookup("select MAX(speed)from rMaxSpeed where  Datetime>='" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "' and  Datetime<='" . DateTimeFormat(now(),"Y-m-d H:i:s") . "' and vehicleID=" . $drVehicle["id"])), "/");
	            		if ($maxspeed <> "/") {
							if($metric == "mi")
									$maxspeed = round(round(($maxspeed*0.621371)*100)/100) . ' mph';
							else
									$maxspeed .= " Km/h";
						}
	            	?>
	            	<span id="spanMaxSpeed-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'><?=dic("Reports.MaxSpeedDay")?></span>')" onmouseout="HidePopup()"><?=$maxspeed?></span>
	            </td>
	            <td style="<?=$dlocationS?>; <?php if($clientType == 2) $width=9; else $width=17; ?> width:<?=$width?>%; font-size:11px; padding-left:3px" align="left" class="corner5 text5 <?=$classTr?> colLocation"><span id="spanLoc-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'><?=dic("Reports.CurrLocation")?></span>')" onmouseout="HidePopup()"><?= nnull(pg_fetch_result($dsCurrPos, 0, "\"Location\""), "/") ?></span></td>
	            <td style="<?=$dpoiS?>; <?php if($clientType == 2) $width=8; else $width=12; ?> width:<?=$width?>%; font-size:11px; padding-left:3px" align="left" class="corner5 text5 <?=$classTr?> colPoi"><span id="spanPoi-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'><?=dic("Reports.CurrPoi")?></span>')" onmouseout="HidePopup()"><?= nnull(pg_fetch_result($dsCurrPos, 0, "poinames"), "/") ?></span></td>
	            <td style="<?=$dzoneS?>; <?php if($clientType == 2) $width=8; else $width=12; ?> width:<?=$width?>%; font-size:11px; padding-left:3px" align="left" class="corner5 text5 <?=$classTr?> colZone"><span id="spanZone-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'><?= dic("Reports.CurrZone")?></span>')" onmouseout="HidePopup()"><?= nnull(pg_fetch_result($dsCurrPos, 0, "zonenames"), "/") ?></span></td>
	              <?php
       			if ($clientType == 2) {
       				$dsTaxiData = query("select count(*) cnt, sum(price) price, sum(pricewith) pricewith from reporttaxi where vehicleid=" . $drVehicle["id"] . " and startdate between '" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "' and '" . DateTimeFormat(now(),"Y-m-d H:i:s") . "'");
       			?>
		            <td style="<?=$dntoursS ?>; width:6%; font-size:11px;" align="center" class="corner5 text5 <?=$classTr?> colNTours">
		            	<span id="spanCntTours-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'><?=dic("Reports.TotalToursDay")?></span>')" onmouseout="HidePopup()"><?= pg_fetch_result($dsTaxiData, 0, 'cnt') ?></span>
		            </td>
		            <td style="<?= $dpriceS?>; width:9%; font-size:11px;" align="center" class="corner5 text5 <?=$classTr?> colPrice">
	            		<span onmousemove="ShowPopup(event, '<span class=\'text5\'><?=dic("Reports.TotalPriceDay")?></span>')" onmouseout="HidePopup()"><span id="spanTotalPrice-<?= $drVehicle["id"]?>" value=<?= number_format(round(pg_fetch_result($dsTaxiData, 0, 'price') / $currencyvalue, 1))?> ><?= number_format(round(pg_fetch_result($dsTaxiData, 0, 'price') / $currencyvalue, 1))?> </span> <?= $currency ?></span>
	            		<br>
	            		<span style="color:green" onmousemove="ShowPopup(event, '<span class=\'text5\'><?=dic("Reports.TotalPriceDayTaxi")?></span>')" onmouseout="HidePopup()"><span id="spanPriceTaxi-<?= $drVehicle["id"]?>" value="<?= number_format(round(pg_fetch_result($dsTaxiData, 0, 'pricewith') / $currencyvalue, 1))?>" ><?= number_format(round(pg_fetch_result($dsTaxiData, 0, 'pricewith') / $currencyvalue, 1))?> </span> <?= $currency?></span>
	            		&nbsp;|&nbsp;
	            		<span style="color:red" onmousemove="ShowPopup(event, '<span class=\'text5\'><?=dic("Reports.TotalPriceDayWithout")?></span>')" onmouseout="HidePopup()"><span id="spanPriceWithoutTaxi-<?= $drVehicle["id"]?>" value="<?= number_format(round((pg_fetch_result($dsTaxiData, 0, 'price') - pg_fetch_result($dsTaxiData, 0, 'pricewith')) / $currencyvalue, 1))?>"><?= number_format(round((pg_fetch_result($dsTaxiData, 0, 'price') - pg_fetch_result($dsTaxiData, 0, 'pricewith')) / $currencyvalue, 1))?> </span> <?= $currency?></span>
		            </td>
	            <?php
	            	if (pg_fetch_result($dsCurrPos, 0, $taxiCol) == 1) {
	            		$stTaxi = "style='color:green;'";
					} else {
						$stTaxi = "style='color:red;'";
					}
       			?>
	            <td style="<?=$dtaximeterS ?>; width:10%; font-size:11px;" align="center" class="corner5 text5 <?=$classTr?> colTaximeter">
		            	<?php
		            	$stTaxi = "";
						$currDataTaxi = "";
		            	if (pg_fetch_result($dsCurrPos, 0, $taxiCol) == 1) {
		            		$stTaxi = "style='color:green;'";
		            		$currDataTaxi = dic_("Reports.ON1");
						} else {
							$stTaxi = "style='color:red;'";
							$currDataTaxi = dic_("Reports.OFF1");
						}
		            	?>
		            	<span id="spanTaxi-<?= $drVehicle["id"]?>" <?=$stTaxi?> onmousemove="ShowPopup(event, '<span class=\'text5\'><?=dic("Reports.CurrTaximeter")?></span>')" onmouseout="HidePopup()"><?=$currDataTaxi?></span>
	            </td>
	            <td style="<?=$dpassengersS?>; width:9%; font-size:11px;" align="center" class="corner5 text5 <?=$classTr?> colPassengers">
	            	<?php
	            	$stPass = "";
	            	if ($pass > 0) {
	            		$stPass = "style='color:green;'";
					} else {
						$stPass = "style='color:red;'";
					}
	            	?>
	            	<span id="spanPass-<?= $drVehicle["id"]?>" <?=$stPass?> onmousemove="ShowPopup(event, '<span class=\'text5\'><?=dic("Reports.CurrPassengers")?></span>')" onmouseout="HidePopup()"><?=$pass?></span>
	            </td>
	             <?php	
       			}
       			?>
	        </tr>
	        <?php
	        	$cnt++;
				$lastOrgName = $orgName;
			}
	        ?>

<!--/table-->
			</tbody>
        
        
    </table>



    <?php
    closedb();
    ?>
    
</body>
<script type="text/javascript">
	var tmp = 0;
	
	 $(document).ready(function () {
	 		 	
	 	$("#table1").freezeHeader({ 'height': '100%' });	 
		$("#table1").css({ width: '100%' });  
		
		$('#hdScrolltable1').css({height: (top.document.body.clientHeight - 185) + 'px'});
		$('#hdScrolltable1').css('overflow-y', 'auto');
		$('#ui-id-4').css('overflow-y', 'none');
		/*var p = $('#hdtable1').offset();
		debugger;
		alert(p.top)*/

		//$('#hdtable1').css('top', 'auto');
		
		
		//hdScrolltable1
		//$("#hdtable1").css({width: ($("#hdtable1").width() + 40 + 'px')});
    });
    //setCookie("154_hideColinfo", "1", -1);
    
    function chTemp(txt){
	if (txt==null) {txt = '' + dic("wait", lang) + ''}
	var wobjb = document.getElementById('div-please-wait-back')

	var _w = 200
	var _h = 30
	var _l = (document.body.clientWidth-_w)/2
	var _t = (document.body.clientHeight-_h)/3

	
	imgPath = twopoint + '/images/'
	if (wobjb == null) {
		wobjb = Create(document.body, 'div', 'div-please-wait-back')		
		$(wobjb).css({position:'absolute', width:document.body.clientWidth+'px', height:document.body.clientHeight+'px', position:'absolute', zIndex:9999, backgroundImage:'url('+imgPath+'backLoading.png)', opacity:0.2, left:'0px', top:'0px'})	
	} else {
	    $('#div-please-wait-back').show()
	}
	}
    function msgboxNHideCol(msg, _id, _class){	
    	chTemp();
    	//return;
    	
		$('#div-msgboxHideCol').html(msg)
		$( "#dialog:ui-dialog" ).dialog("destroy");
		$("#dialog-messageHideCol").dialog({
		    /*modal: true,*/
		    zIndex: 99999, 
		    resizable: false, 
		    width: 350,
		    close : function(){
            	HideWait();
         	}, 
		    buttons: {
		        Ok: function () {
		            if (document.getElementById("InfoForAllHideCol").checked)
		                setCookie(<?=$uid?> + _id, "1", 14);
		            else
		                setCookie(<?=$uid?> + _id, "0", 14);
		            document.getElementById("InfoForAllHideCol").checked = false;
		            $("#DivInfoForAllHideCol").css({ display: 'none' });
		            $(this).dialog("close");
		            $('.'+_class).hide();
		            
		            $.ajax({
		                url: 'VehDetailsHideCol.php?userid='+<?=$uid?>+'&column='+_class,
		                context: document.body,
		                success: function (data) {
		                    HideWait();
		                    msgbox(dic('directionsaved', lang) + '!!!');
		                }
		            });
            
		        }
		    }
		});
		document.getElementById("dialog-messageHideCol").parentNode.style.zIndex = 99999
	}
    function hideColumn(_class) {
    	var PPI = getCookie(<?=$uid?> + "_hideColinfo");
        if (PPI != "1") {
	    	$("#DivInfoForAllHideCol").css({ display: 'block' });
	        msgboxNHideCol(dic("hideColVehDetails", lang), "_hideColinfo", _class);
        } else {
        	$('.'+_class).hide();
        	$.ajax({
	            url: 'VehDetailsHideCol.php?userid='+<?=$uid?>+'&column='+_class,
	            context: document.body,
	            success: function (data) {
	                HideWait();
	                msgbox(dic('directionsaved', lang) + '!!!');
	            }
	        });
        }
    }
    
    document.getElementById('hdScrolltable1').onscroll=function(){
    	if($("#hdtable1").width() != 0 && tmp == 0 ) {
    		$("#hdtable1").css({width: ($("#hdtable1").width() + 2 + 'px')});
    		//$("#hdtable1").css({top: (parseInt($('#hdtable1').css('top'), 10) - 1 + 'px')});
    	}
    	if($("#hdtable1").width() == 0) {
    		tmp = 0;
    	} else {
    		tmp = 1;
    	}
    	//$("#hdtable1").css({width: ($("#hdtable1").width() + 2 + 'px')});
    	//$($($('#hdScrolltable1')[0].childNodes[0])[0].childNodes[0]).css({width: 'calc(100% + 1px)'})
    	//alert(7)
    };
</script>
</html>


