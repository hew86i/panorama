<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo dic("Reports.PanoramaGPS")?></title>
	
	
    
    
<style>
        body{
            margin: 0;
            padding: 0;
            font-family: sans-serif;
        }
        .fixed {
            position: absolute;
            width: 100%;
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
            width: 100%;
            z-index: 1;
            background: #FFFFFF;
            margin-top: -32px;
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
  			border:1px solid #cccccc; 
  			background-color:#f3f3f3;	
  			color:#000000;	
  		}
  		.divTr1 {
  			font-size:12px; 
  			border:1px solid #cccccc; 
  			background-color:#ffffff;
  			color:#626262;
  		}
  		.text5{font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#2f5185; text-decoration: none}
  		.corner5{-moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px}
  		
        </style>

	<!--link rel="stylesheet" type="text/css" href="styleGM.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script src="../amcharts/amcharts.js" type="text/javascript"></script>
	<link rel="stylesheet" href="../amcharts/style.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.8.14.custom.css">
    <link rel="stylesheet" href="mlColorPicker.css" type="text/css" media="screen" charset="utf-8" /-->


	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	<script type="text/javascript" src="reports.js"></script>
    <link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="../js/jquery-ui.js"></script>
    
	<LINK REL="SHORTCUT ICON" HREF="../images/icon.ico">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script src="../js/jquery.json-2.2.min.js"></script>
	<script src="../js/jquery.websocket-0.0.1.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="../js/md5.js"></script>
	
	<script type="text/javascript" src="./live.js"></script>
	<script type="text/javascript" src="./live2.js"></script>
	<script type="text/javascript" src="../main/main.js"></script>

	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

    <script type="text/javascript" src="./mlColorPicker.js"></script>
	<script type="text/javascript" src="../js/OpenLayers.js"></script>
	<script src="../js/jsxcompressor.js"></script>
	
	<script type="text/javascript" src="../js/jquery.collapsible.js"></script>
	<script src="../js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="newchartOneVeh24h.js"></script>
	
</head>

<?php
	if (session('user_id') == "261" or session('user_id') == "779" or session('user_id') == "780" or session('user_id') == "781" or session('user_id') == "776" or session('user_id') == "777" or session('user_id') == "782" or session('user_id') == "778") echo header('Location: ../sessionexpired/?l='.$cLang);
	if (!is_numeric(session('user_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
	
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
	
    $sdG = DateTimeFormat(getQUERY("sd"), 'd-m-Y H:i:s');
	$edG = DateTimeFormat(getQUERY("ed"), 'd-m-Y H:i:s');
	
    $sd = DateTimeFormat(getQUERY("sd"), $dateformat) . $s_; //'01-09-2012 00:00';
    $ed = DateTimeFormat(getQUERY("ed"), $dateformat) . $e_; //'01-09-2012 23:59';

	$tzone = pg_fetch_result($dsUsersSett, 0, 'tzone');  
	$CreationDate = strtoupper(DateTimeFormat(addToDateU(now(), $tzone, "hour", "Y-m-d H:i"), $datetimeformat));  

	$_SESSION["user_fullname"] = pg_fetch_result($dsUsersSett, 0, 'fullname');
	$_SESSION["company"] = dlookup("select name from clients where id in (select clientid from users where id=" . $uid . " limit 1) limit 1");
	    
    If (strrpos(strtoupper(Session("user_fullname")), "DEMO") > 0)  $_SESSION["company"] = dic_("Reports.DemoCompany");
    	
	$clientType = dlookup("select clienttypeid from clients where ID=" . session("client_id"));  
	
	if ($_SESSION['role_id'] == "2") { 
        $sqlV = "select id from vehicles where clientID=" . $cid . " and active='1'";
	} else {
		$sqlV = "select vehicleID from uservehicles uv left outer join vehicles v on v.id=uv.vehicleid where userID=" . $uid . " and v.active='1'";
	}
	$dsVehicles = query("select * from vehicles where id in (" . $sqlV. ") order by organisationid desc, cast(code as integer) asc"); 
	 
	$strVhList = "";
	$strVhListID = "";	
	$strVehcileID = "";
	
	while($row = pg_fetch_array($dsVehicles))
	{
		$strVehcileID .= ",".$row["id"];
		$strVhList .= ", '(<strong>".$row["code"]."</strong>)&nbsp;&nbsp;".trim($row["registration"]," ")."'";
		$strVhListID .= ", ".$row["code"];
	}
	
	if (strlen($strVehcileID)>0) {
		$strVehcileID = substr($strVehcileID,1);	
	}
	
	$strVhList = substr($strVhList,1);
	$strVhListID = substr($strVhListID,1);		
?>

<body style="margin:0px 0px 0px 0px; padding:0px 0px 0px 0px">	
<table class="fixed" style="margin-top:0px;">
<tr>
	<th <?php if($clientType == 2) $width=8; else $width=11; ?> width=<?=$width?>% height=30px style="font-size:11px" align="center" class="corner5 text5 divTitle"><?= dic_("Reports.Vehicle")?></th>
	<th <?php if($clientType == 2) $width=8; else $width=11; ?> width=<?=$width?>% height=30px style="font-size:11px" align="center" class="corner5 text5 divTitle"><?= dic_("Reports.Driver")?></th>
	<th <?php if($clientType == 2) $width=9; else $width=11; ?> width=<?=$width?>% height=30px style="font-size:11px" align="center" class="corner5 text5 divTitle"><?= dic_("Time")?></th>
	<th <?php if($clientType == 2) $width=15; else $width=15; ?> width=<?=$width?>% height=30px style="font-size:11px" align="center" class="corner5 text5 divTitle"><?= dic_("Reports.Odometer")?></th>
	<th <?php if($clientType == 2) $width=7; else $width=11; ?> width=<?=$width?>% height=30px style="font-size:11px" align="center" class="corner5 text5 divTitle"><?= dic_("Speed")?></th>
	<th <?php if($clientType == 2) $width=10; else $width=17; ?> width=<?=$width?>% height=30px style="font-size:11px" align="center" class="corner5 text5 divTitle"><?= dic_("Reports.Location")?></th>
	<th <?php if($clientType == 2) $width=9; else $width=12; ?> width=<?=$width?>% height=30px style="font-size:11px" align="center" class="corner5 text5 divTitle"><?= dic_("Settings.Poi1")?></th>
	<th <?php if($clientType == 2) $width=9; else $width=12; ?> width=<?=$width?>% height=30px style="font-size:11px" align="center" class="corner5 text5 divTitle"><?= dic_("GeoFence")?></th>
	
	<?php
	if ($clientType == 2) {
	?>
	<th width=6% height=30px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div><?= dic_("Reports.NoTours1")?></div></td>
	<th width=9% height=30px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div><?= dic_("Reports.Price")?></div></td>
	<th width=5% height=30px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div><?= dic_("Reports.Taximeter")?></div></td>
	<th width=5% height=30px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div><?= dic_("Reports.Passengers")?></div></td>
	<?php	
	}
	?>
</tr>
			
<?php
			$cnt = 0;	
			$lastOrgName = "";
			$colspan = 8;	
			if($clientType == 2) $colspan = 12;		
			$dsVehicles = query("select * from vehicles where id in (" . $sqlV. ") order by organisationid desc, cast(code as integer) asc"); 
			 
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
                  		<div style="height:10px"></div><div style="padding-top:8px; height: 22px; border:1px solid #80D180; background-color:#DBFDEA;" class="corner5 text5" valign:middle;="">&nbsp;&nbsp;&nbsp;<?= $orgName?></div></td>
      				</tr>
      				<?php
      			}
				if ($cnt % 2 == 0) $classTr = "divTr1";
				else $classTr = "divTr";
				
				
				?>
      			<script type="text/javascript">

      			</script>
	        <tr>
	            <td <?php if($clientType == 2) $width=8; else $width=11; ?> width=<?=$width?>% style="font-size:11px" align="center" class="corner5 text5 <?=$classTr?>">
	            		<span id="vehicle-<?= $drVehicle["id"]?>">
	            			<?= $drVehicle["registration"] . " (" . $drVehicle["code"] .")"?>
	            			<font id="intour-<?= $drVehicle["id"]?>" style='display:none; font-size:10px; color:red'>во тура</font>	            			
	            		</span>	
	            </td>
	            <td <?php if($clientType == 2) $width=8; else $width=11; ?> width=<?=$width?>% style="font-size:11px; padding-left:3px" align="left" class="corner5 text5 <?=$classTr?>">
		            	<?php
		            		$drivers = nnull(dlookup("select getdrivernew1('" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "', '" . DateTimeFormat(now(),"Y-m-d H:i:s") . "', " . $drVehicle["id"] . ")"), "/");
		            		//echo $drivers;
		            	?>
		            	<span id="spanDriver-<?= $drVehicle["id"]?>"><?= $drivers?></span>
	            </td>
	            <td <?php if($clientType == 2) $width=9; else $width=11; ?> width=<?=$width?>% style="font-size:11px" align="center" class="corner5 text5 <?=$classTr?>">
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
					
					<span id="spanIgn1-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'>Време на прво палење на мотор</span>')" onmouseout="HidePopup()"><?=$ign1?></span>
					
					<?php
					echo " - ";
					$dtCurrPos = pg_fetch_result($dsCurrPos, 0, "\"DateTime\"");
					$ign2 = "/";
					if (pg_fetch_result($dsCurrPos, 0, "\"DateTime\"") > DateTimeFormat(now(), 'Y-m-d 00:00:00')) {
						$todayData = 1;
						$ign2 = DateTimeFormat($dtCurrPos, $timeformat);
					}
					?>
					<span id="spanIgn2-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'>Време на последен пристигнат податок</span>')" onmouseout="HidePopup()"><?=$ign2?></span>
					<?php
					echo "<br>";
					
					$ignTotal = "/";
					if ($firstIgnsOn <> "/")
						$ignTotal = Sec2Str(dlookup("select datediff('', '" . $firstIgnsOn . "', '" . $dtCurrPos . "')"));						
	            	?>
	            	Вк. <span id="spanIgnTotal-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'>Вкупно време меѓу прво палење на мотор и последен пристигнат податок</span>')" onmouseout="HidePopup()"> <?=$ignTotal?></span>
	            </td>
	            <td <?php if($clientType == 2) $width=15; else $width=15; ?> width=<?=$width?>% style="font-size:11px" align="center" class="corner5 text5 <?=$classTr?>">
		            	<?php
	            			$all_rastojanie = dlookup("select getdistancenew('" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "', '" . DateTimeFormat(now(),"Y-m-d H:i:s") . "', " . $drVehicle["id"] . ")");
	            			//echo number_format(round($all_rastojanie*$metricvalue, 1)) . " " . $metric;	
	            		?>
		            	
		            	<?php
		            		$currOdometer = "/";
							$od1 = "/";
							$od2 = "/";
							$odTot = "/";
		            		if ($drVehicle["allowcanbas"] == '1') {
		            			$currOdometer = round(pg_fetch_result($dsCurrPos, 0, "cbdistance")*$metricvalue, 1);
								$od1 = number_format($currOdometer-(round($all_rastojanie*$metricvalue, 1))) . " " . $metric;
		            			$od2 = number_format($currOdometer) . " " . $metric;
							} else {
								$cntC = dlookup("select count(*) from odometer where vehicleid=".$drVehicle["id"]);
								if ($cntC > 0) {
									$currOdometer = round(nnull(dlookup("select km from odometer where vehicleid=".$drVehicle["id"]),0)*$metricvalue, 1);
									$od1 = number_format($currOdometer-(round($all_rastojanie*$metricvalue, 1))) . " " . $metric;
									$od2 = number_format($currOdometer) . " " . $metric;				
								}
							}
							$odTot = number_format(round($all_rastojanie*$metricvalue, 1)) . " " . $metric;
							if ($todayData == 0) {
								$od1 = "/"; $odTot = "/";
							}
		            	?>
		            	<span id="spanOd1-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'>Почетна вредност на одометарот</span>')" onmouseout="HidePopup()"><?=$od1?></span> - 
		            	<span id="spanOd2-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'>Моментална вредност на одометарот</span>')" onmouseout="HidePopup()"><?=$od2?></span> <br>Вк. 
		            	<span id="spanOdTot-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'>Поминато растојание во текот на денот</span>')" onmouseout="HidePopup()"><?=$odTot?></span>
	            </td>
	            <td <?php if($clientType == 2) $width=7; else $width=11; ?> width=<?=$width?>% style="font-size:11px" align="center" class="corner5 text5 <?=$classTr?>">
	            		<span id="spanSpeed-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'>Моментална брзина</span>')" onmouseout="HidePopup()">
	            			<?php
	            			if(pg_fetch_result($dsCurrPos, 0, "speed") == "/")
							{
								$speed = pg_fetch_result($dsCurrPos, 0, "speed");
							} else
							{
								$speed = round(pg_fetch_result($dsCurrPos, 0, "speed"), 0) . ' Km/h';
								if($metric == "mi")
									$speed = round(round((parseFloat(pg_fetch_result($dsCurrPos, 0, "speed"))*0.621371)*100)/100) . ' mph';
							}
	            			?>
	            			<?= $speed?>
	            		</span>
	            		<br>max: <?php
						$maxspeed = nnull(round(dlookup("select MAX(speed)from rMaxSpeed where  Datetime>='" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "' and  Datetime<='" . DateTimeFormat(now(),"Y-m-d H:i:s") . "' and vehicleID=" . $drVehicle["id"])), "/");
	            		if ($maxspeed <> "/")	$maxspeed .= " Km/h";
	            	?>
	            	<span id="spanMaxSpeed-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'>Максимална постигната брзина во текот на денот</span>')" onmouseout="HidePopup()"><?=$maxspeed?></span>
	            </td>
	            <td <?php if($clientType == 2) $width=10; else $width=17; ?> width=<?=$width?>% style="font-size:11px; padding-left:3px" align="left" class="corner5 text5 <?=$classTr?>"><span id="spanLoc-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'>Моментална локација</span>')" onmouseout="HidePopup()"><?= nnull(pg_fetch_result($dsCurrPos, 0, "\"Location\""), "/") ?></span></td>
	            <td <?php if($clientType == 2) $width=9; else $width=12; ?> width=<?=$width?>% style="font-size:11px; padding-left:3px" align="left" class="corner5 text5 <?=$classTr?>"><span id="spanPoi-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'>Моментална посетена точка од интерес</span>')" onmouseout="HidePopup()"><?= nnull(pg_fetch_result($dsCurrPos, 0, "poinames"), "/") ?></span></td>
	            <td <?php if($clientType == 2) $width=9; else $width=12; ?> width=<?=$width?>% style="font-size:11px; padding-left:3px" align="left" class="corner5 text5 <?=$classTr?>"><span id="spanZone-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'>Моментална посетена зона</span>')" onmouseout="HidePopup()"><?= nnull(pg_fetch_result($dsCurrPos, 0, "zonenames"), "/") ?></span></td>
	              <?php
       			if ($clientType == 2) {
       				$dsTaxiData = query("select count(*) cnt, sum(price) price, sum(pricewith) pricewith from reporttaxi where vehicleid=" . $drVehicle["id"] . " and startdate between '" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "' and '" . DateTimeFormat(now(),"Y-m-d H:i:s") . "'");
       			?>
		            <td width=6% style="font-size:11px;" align="center" class="corner5 text5 <?=$classTr?>">
		            	<span id="spanCntTours-<?= $drVehicle["id"]?>" onmousemove="ShowPopup(event, '<span class=\'text5\'>Вкупен број на тури во текот на денот</span>')" onmouseout="HidePopup()"><?= pg_fetch_result($dsTaxiData, 0, 'cnt') ?></span>
		            </td>
		            <td width=9% style="font-size:11px;" align="center" class="corner5 text5 <?=$classTr?>">
	            		<span onmousemove="ShowPopup(event, '<span class=\'text5\'>Вкупна цена од сите тури во текот на денот</span>')" onmouseout="HidePopup()"><span id="spanTotalPrice-<?= $drVehicle["id"]?>" value=<?= number_format(round(pg_fetch_result($dsTaxiData, 0, 'price') / $currencyvalue, 1))?> ><?= number_format(round(pg_fetch_result($dsTaxiData, 0, 'price') / $currencyvalue, 1))?> </span> <?= $currency ?></span>
	            		<br>
	            		<span style="color:green" onmousemove="ShowPopup(event, '<span class=\'text5\'>Вкупна цена од сите тури со вклучен таксиметар</span>')" onmouseout="HidePopup()"><span id="spanPriceTaxi-<?= $drVehicle["id"]?>" value="<?= number_format(round(pg_fetch_result($dsTaxiData, 0, 'pricewith') / $currencyvalue, 1))?>" ><?= number_format(round(pg_fetch_result($dsTaxiData, 0, 'pricewith') / $currencyvalue, 1))?> </span> <?= $currency?></span>
	            		&nbsp;|&nbsp;
	            		<span style="color:red" onmousemove="ShowPopup(event, '<span class=\'text5\'>Вкупна цена од сите тури без вклучен таксиметар</span>')" onmouseout="HidePopup()"><span id="spanPriceWithoutTaxi-<?= $drVehicle["id"]?>" value="<?= number_format(round((pg_fetch_result($dsTaxiData, 0, 'price') - pg_fetch_result($dsTaxiData, 0, 'pricewith')) / $currencyvalue, 1))?>"><?= number_format(round((pg_fetch_result($dsTaxiData, 0, 'price') - pg_fetch_result($dsTaxiData, 0, 'pricewith')) / $currencyvalue, 1))?> </span> <?= $currency?></span>
		            </td>
	            <?php
	            	if (pg_fetch_result($dsCurrPos, 0, $taxiCol) == 1) {
	            		$stTaxi = "style='color:green;'";
					} else {
						$stTaxi = "style='color:red;'";
					}
       			?>
	            <td width=5% style="font-size:11px;" align="center" class="corner5 text5 <?=$classTr?>">
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
		            	<span id="spanTaxi-<?= $drVehicle["id"]?>" <?=$stTaxi?> onmousemove="ShowPopup(event, '<span class=\'text5\'>Моментална состојба на таксиметарот</span>')" onmouseout="HidePopup()"><?=$currDataTaxi?></span>
	            </td>
	            <td width=5% style="font-size:11px;" align="center" class="corner5 text5 <?=$classTr?>">
	            	<?php
	            	$stPass = "";
	            	if ($pass > 0) {
	            		$stPass = "style='color:green;'";
					} else {
						$stPass = "style='color:red;'";
					}
	            	?>
	            	<span id="spanPass-<?= $drVehicle["id"]?>" <?=$stPass?> onmousemove="ShowPopup(event, '<span class=\'text5\'>Моментален број на патници во возилото</span>')" onmouseout="HidePopup()"><?=$pass?></span>
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
</table>	
</body>

<script type="text/javascript">
    clientid = '<?=session("client_id")?>';

	testKiki();

	VehicleList = [<?php echo $strVhList?>];
	VehicleListID = [<?php echo $strVhListID?>];
    VehcileIDs = [<?php echo $strVehcileID?>];
	VehcileIDsWS = '<?php echo $strVehcileID?>';

</script>
<?php
	closedb();
?>
</html>
