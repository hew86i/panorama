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

</head>
	<script>
		lang = '<?php echo $cLang?>'
	</script>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	<script type="text/javascript" src="reports.js"></script>
    <link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="../js/jquery-ui.js"></script>
    
    <script>
  		if (<?php echo nnull(is_numeric(nnull(getQUERY("uid"))), 0) ?> == 0){
  			if (<?php echo nnull(is_numeric(nnull(session("user_id"))), 0) ?> == 0)
  				top.window.location = "../sessionexpired/?l=" + '<?php echo $cLang ?>';
  		} 
  	</script>
  	
  	<style>
  
  		.divTitle {
  			font-weight: bold; 
  			font-size:12px; 
  			border:1px solid #009900; 
  			background-color:#DBFDEA;	
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
  		
  		.tabTitle {
		    /* fallback */
		    width: 100%;
		    /* minus scroll bar width */
		    width: -webkit-calc(100% - 12px);
		    width:    -moz-calc(100% - 12px);
		    width:         calc(100% - 12px);
		}
		
  		/*table.scroll {
		    width: 100%;
		}
		
		table.scroll th,
		table.scroll td,
		table.scroll tr,
		table.scroll thead,
		table.scroll tbody { /*display: block;*/}
		
		/*table.scroll thead tr {
		    /* fallback */
		    /*width: 97%;
		    /* minus scroll bar width */
		    /*width: -webkit-calc(100% - 16px);
		    width:    -moz-calc(100% - 16px);
		    width:         calc(100% - 16px);
		}
		
		table.scroll tr:after {
		    content: ' ';
		    display: block;
		    visibility: hidden;
		    clear: both;
		}
		
		table.scroll tbody {
			height:300px;
		    overflow-y: auto;
		    overflow-x: hidden;
		}
		
		table.scroll tbody td,
		table.scroll thead th {
		    /*float: left;*/
		/*}
		
		thead tr th { 
		    height: 30px;
		    line-height: 30px;
		    /*text-align: left;*/
		/*}
		
		tbody {}
		
		tbody td:last-child, thead th:last-child {
		}*/
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
?>
<body style="margin:0px 0px 0px 0px; padding:0px 0px 0px 0px">
	
	
	
<div style="height: 300px; width: 98%; margin-top: 5px; overflow-x:hidden;overflow-y:auto;">

<table width="100%">
	
<tr>
	<td height=30px width=100px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div>Возило</div></td>
	<td height=30px width=100px style="font-size:11px;" align="center" class="corner5 text5 divTitle">Возач</div></td>
	<td height=30px width=80px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div>Одометар</div></td>
	<td height=30px width=110px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div>Локација</div></td>
	<td height=30px width=110px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div>Тои</div></td>
	<td height=30px width=110px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div>Зона</div></td>
	<td height=30px width=110px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div>Време</div></td>
	<td height=30px width=90px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div>Вк.растојание</div></td>
	<td height=30px width=70px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div>Брзина</div></td>
	<?php
	if ($clientType == 2) {
	?>
	<td height=30px width=60px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div>Бр.тури</div></td>
	<td height=30px width=100px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div>Цена</div></td>
	<!--td height=30px width=60px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div>Тек.тура</div></td-->
	<?php	
	}
	?>
	
	<?php
	if ($clientType == 2) {
	?>
	<td height=30px width=80px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div>Таксиметар</div></td>
	<td height=30px width=60px style="font-size:11px" align="center" class="corner5 text5 divTitle"><div>Патници</div></td>
	<?php	
	}
	?>
</tr>
			
<?php
			$cnt = 0;				 
      		while ($drVehicle = pg_fetch_array($dsVehicles)) {
      			if ($cnt%2==0) $classTr = "divTr";
				else $classTr = "divTr1";
				
				$passrup = '';
				if ($drVehicle["deviceid"] == 15) {
					$passrup = 'ruptela';
				}
									
      			$dsCurrPos = query("select * from currentposition where vehicleid=" . $drVehicle["id"]);
      			if ($clientType == 2) {
      				$dsPorts = query("select * from vehicleport where vehicleid=" . $drVehicle["id"] . " and porttypeid in (2,5) order by porttypeid asc");
					$taxiCol = pg_fetch_result($dsPorts, 0, "portname");
					$passCol = pg_fetch_result($dsPorts, 1, "portname");
      			}
      		?>
	        <tr>
	            <td width=100px style="font-size:11px" align="center" class="corner5 text5 <?=$classTr?>">
	            	<div>
	            		<?= $drVehicle["registration"] . " (" . $drVehicle["code"] .")"?>
	            	</div>
	            </td>
	            <td width=100px style="font-size:11px; padding-left: 3px" class="corner5 text5 <?=$classTr?>">
	            	<div>
		            	<?php
		            		$drivers = nnull(dlookup("select getdrivernew1('" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "', '" . DateTimeFormat(now(),"Y-m-d H:i:s") . "', " . $drVehicle["id"] . ")"), "/");
		            		echo $drivers;
		            	?>
	            	</div>
	            </td>
	            <td width=80px style="font-size:11px" align="center" class="corner5 text5 <?=$classTr?>">
	            	<div>
		            	<?php
		            		if ($drVehicle["allowcanbas"] == '1') echo number_format(round(pg_fetch_result($dsCurrPos, 0, "cbdistance")*$metricvalue, 1)) . " " . $metric;
							else {
								$cntC = dlookup("select count(*) from odometer where vehicleid=".$drVehicle["id"]);
								if ($cntC > 0) echo number_format(round(nnull(dlookup("select km from odometer where vehicleid=".$drVehicle["id"]),0)*$metricvalue, 1)) . " " . $metric;				
								else echo "/";
							}
		            	?>
	            	</div>
	            </td>
	            <td width=110px style="font-size:11px; padding-left: 3px" class="corner5 text5 <?=$classTr?>"><div><?= nnull(pg_fetch_result($dsCurrPos, 0, "\"Location\""), "/") ?></div></td>
	            <td width=110px style="font-size:11px; padding-left: 3px" class="corner5 text5 <?=$classTr?>"><div><?= nnull(pg_fetch_result($dsCurrPos, 0, "poinames"), "/") ?></div></td>
	            <td width=110px style="font-size:11px; padding-left: 3px" class="corner5 text5 <?=$classTr?>"><div><?= nnull(pg_fetch_result($dsCurrPos, 0, "zonenames"), "/") ?></div></td>
	            <td width=110px style="font-size:11px" align="center" class="corner5 text5 <?=$classTr?>">
	            	<div>
	            	<?php
	            	$cntH = dlookup("select count(*) from historylog where vehicleid=" . $drVehicle["id"] . " and datetime between '" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "' and '" . DateTimeFormat(now(),"Y-m-d H:i:s") . "'");
	            	$firstIgnsOn = "/";
	            	if ($cntH > 0)
	            		$firstIgnsOn = nnull(dlookup("select datetime from historylog where vehicleid=" . $drVehicle["id"] . " and datetime between '" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "' and '" . DateTimeFormat(now(),"Y-m-d H:i:s") . "' order by datetime asc limit 1"), "/");
	            	if ($firstIgnsOn <> "/") echo DateTimeFormat($firstIgnsOn, $timeformat);
					else echo $firstIgnsOn;
					echo " - ";
					$dtCurrPos = pg_fetch_result($dsCurrPos, 0, "\"DateTime\"");
					echo DateTimeFormat($dtCurrPos, $timeformat);
					echo "<br>";
					if ($firstIgnsOn <> "/")
						echo "Вк. " . Sec2Str(dlookup("select datediff('', '" . $firstIgnsOn . "', '" . $dtCurrPos . "')"));
					else 
						echo  "Вк. /";
						
	            	?>
	            	</div>
	            </td>
	            <td width=90px style="font-size:11px" align="center" class="corner5 text5 <?=$classTr?>">
	            	<div>
	            	<?php
	            		$all_rastojanie = dlookup("select getdistancenew('" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "', '" . DateTimeFormat(now(),"Y-m-d H:i:s") . "', " . $drVehicle["id"] . ")");
	            		echo number_format(round($all_rastojanie*$metricvalue, 1)) . " " . $metric;	
	            	?>
	            	</div>
	            </td>
	            <td width=70px style="font-size:11px;" align="center" class="corner5 text5 <?=$classTr?>">
	            	<div>
	            		<?= round(pg_fetch_result($dsCurrPos, 0, "speed")) . " Km/h" ?>
	            		<br>max: <?php
						$maxspeed = nnull(round(dlookup("select MAX(speed)from rMaxSpeed where  Datetime>='" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "' and  Datetime<='" . DateTimeFormat(now(),"Y-m-d H:i:s") . "' and vehicleID=" . $drVehicle["id"])), "/");
	            		echo $maxspeed;
	            		if ($maxspeed <> "/")	echo " Km/h";
	            	?>
	            	</div>
	            </td>
	            <!--td width=80px style="font-size:11px" align="center" class="corner5 text5 <?=$classTr?>">
	            	<div>
	            	<?php
						$maxspeed = nnull(round(dlookup("select MAX(speed)from rMaxSpeed where  Datetime>='" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "' and  Datetime<='" . DateTimeFormat(now(),"Y-m-d H:i:s") . "' and vehicleID=" . $drVehicle["id"])), "/");
	            		echo $maxspeed;
	            		if ($maxspeed <> "/")	echo " Km/h";
	            	?>
	            	</div>
	            </td-->
	            <?php
       			if ($clientType == 2) {
       				$dsTaxiData = query("select count(*) cnt, sum(price) price, sum(pricewith) pricewith from reporttaxi where vehicleid=" . $drVehicle["id"] . " and startdate between '" . DateTimeFormat(now(),"Y-m-d 00:00:00") . "' and '" . DateTimeFormat(now(),"Y-m-d H:i:s") . "'");
       			?>
		            <td width=60px style="font-size:11px" align="center" class="corner5 text5 <?=$classTr?>"><div><?= pg_fetch_result($dsTaxiData, 0, 'cnt') ?></div></td>
		            <td width=100px style="font-size:11px" align="center" class="corner5 text5 <?=$classTr?>">
		            	<div>
		            		<?= number_format(round(pg_fetch_result($dsTaxiData, 0, 'price') / $currencyvalue, 1)) . " " . $currency ?>
		            		<br><font style="color:green"><?= number_format(round(pg_fetch_result($dsTaxiData, 0, 'pricewith') / $currencyvalue, 1))  . " " . $currency?></font>
		            		&nbsp;|&nbsp;<font style="color:red"><?= number_format(round((pg_fetch_result($dsTaxiData, 0, 'price') - pg_fetch_result($dsTaxiData, 0, 'pricewith')) / $currencyvalue, 1))  . " " . $currency?></font>
		            	</div>
		            </td>
		            <!--td width=60px style="font-size:11px" align="center" class="corner5 text5 <?=$classTr?>"><div>
		            	<?php
		            	if (pg_fetch_result($dsCurrPos, 0, $taxiCol) == 1 && dlookup("select getpassengers" . $passrup . "(" . pg_fetch_result($dsCurrPos, 0, $passCol) . ")") > 0)
		            		echo "во тура?";//"select * from taxitourdata(" . $drVehicle["id"] . ", (select cast(to_char(now() + cast('-1 hour' as interval), 'YYYY-MM-DD HH24:MI:SS') as timestamp)), cast(now() as timestamp))";
						else echo "/";
		            	//$currTour = dlookup("select * from taxitourdata(" . $drVehicle["id"] . ", (select cast(to_char(now() + cast('-1 hour' as interval), 'YYYY-MM-DD HH24:MI:SS') as timestamp)), cast(now() as timestamp))");
		            	//echo $currTour;
		            	?>
		            </div></td-->
	            <?php
	            	if (pg_fetch_result($dsCurrPos, 0, $taxiCol) == 1) {
	            		$stTaxi = "style='color:green;'";
					} else {
						$stTaxi = "style='color:red;'";
					}
       			?>
	            <td width=80px style="font-size:11px" align="center" class="corner5 text5 <?=$classTr?>">
	            	<div <?=$stTaxi?>>
		            	<?php
		            	$stTaxi = "";
		            	if (pg_fetch_result($dsCurrPos, 0, $taxiCol) == 1) {
		            		echo dic_("Reports.ON1");
						} else {
							echo dic_("Reports.OFF1");
						}
		            	?>
	            	</div>
	            </td>
	            <td width=60px style="font-size:11px" align="center" class="corner5 text5 <?=$classTr?>">
	            	<?php
	            	$stPass = "";
					$pass = dlookup("select getpassengers" . $passrup . "(" . pg_fetch_result($dsCurrPos, 0, $passCol) . ")");
	            	if ($pass > 0) {
	            		$stPass = "style='color:green;'";
					} else {
						$stPass = "style='color:red;'";
					}
	            	?>
	            	<div <?=$stPass?>>
		            	<?php
						echo $pass;
		            	?>
	            	</div>
	            </td>
	             <?php	
       			}
       			?>
	        </tr>
	        <?php
	        	$cnt++;
			}
	        ?>

</table>
</div>	
	

<!--/div-->
    <?php
    closedb();
    ?>
    
</body>
<script type="text/javascript">
	 $(document).ready(function () {
        if ($("#tempTable").height() > 300) {
        	$('#tempTD').removeAttr("style");
        }
        //if ($(document).height() > $(window).height()) {
    });
</script>
</html>


