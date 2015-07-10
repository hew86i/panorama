<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
	
	$tpoint = getQUERY("tpoint");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
	<script>
			lang = '<?php echo $cLang?>'
	</script>
	
	<style type="text/css">
	.list-item-select{background-color: #14a3bc; color:#FFFFFF; cursor:pointer }
	.div-select {background-color: #F57A49; color:#FFFFFF;}
	.comp {
		display: inline-block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 120px; 
	}
	</style>
	
	<?php

	$messid = getQUERY("messid");
	$fromto = getQUERY("fromto");

	$tpoint = getQUERY("tpoint");
	
	if($tpoint == '.')
	{
		?>
		<script type="text/javascript" src="./main/main.js"></script>
  		<?php
	} else {
		?>
		<script type="text/javascript" src="../main/main.js"></script>
  		<?php
	}
?>
	
  
 <!-- <script src="../report/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>-->


 <body>
 	
 	<style>
	ul 
	{
		list-style-type: none;
		list-style-position:inside;
		position:relative; 
		left:-30px;
		top:-10px;
	}
	
	</style>

 
  <?php
  
      $dt = getQUERY("dt");//DateTimeFormat(addDay(-1), "d-m-Y");
      $vehID_ = getQUERY("vehid");
	 
	  opendb();
	
      $reg = "";//dlookup("select registration from vehicles where id=" . $vehID);
      
      $cLang = getQUERY("l");
    $cost = str_replace("_", " ", getQUERY("cost"));
	  
	if ($cost == mb_strtolower(dic_("Reports.Fuel"), 'UTF-8')) $cost = "Fuel";
	if ($cost == mb_strtolower(dic_("Fm.Service"), 'UTF-8')) $cost = "Service";
	if ($cost == mb_strtolower(dic_("Fm.OthCosts"), 'UTF-8')) $cost = "Cost";
	
	  $ifDriver = dlookup("select count(*) from vehicledriver where vehicleid=" . $vehID_);
	$currency = dlookup("select currency from users where id=" . session('user_id')); 
$currencyvalue = dlookup("select value from currency where name='" . $currency . "'"); 
$currency = strtolower($currency);

$liqunit1 = dlookup("select liquidunit from users where id=" . session('user_id'));
	if ($liqunit1 == 'galon') {
		$liqvalue = 0.264172;
		$liqunit = "gal";
	}
	else {
		$liqvalue = 1;
		$liqunit = "lit";
	}
$metric = dlookup("select metric from users where id=" . session('user_id'));
	if ($metric == 'mi') $metricvalue = 0.621371;
	else $metricvalue = 1;
	
	  if ($cost == "Fuel") {
   ?>


  
  <table class="text2_" align="center" width=430px style="margin-left:60px">

	  <tr style="height:35px;">
             <td colspan=3><div style="border-bottom:1px solid #bebebe; width:420px"></div></td>
      </tr>
      
<?php
 	$sql_ = "";
    If ($_SESSION['role_id'] == "2") {
        $sql_ = "select * from vehicles where clientID=" . $_SESSION['client_id'] . " order by code";
    } Else {
        $sql_ = "select * from vehicles where id in (select vehicleID from UserVehicles where userID=" . $_SESSION['user_id'] . ") order by code";
    }
	

    $dsVehicles = query($sql_);

?>
<!--<tr>
	<td width=200px ><strong>Возило:</strong></td>
	<td width=200px style="padding-left: 10px">
		 <select id="cbVehicles" style="width:180px; font-size:12;font-family:Arial, Helvetica, sans-serif;" class="combobox text2" onchange="changeKm('', '')">	
		 	<?php
		 	while ($dr = pg_fetch_array($dsVehicles)) {  
                                  
							?>
                            <option id="<?php echo $dr["id"]?>" value="<?php echo $dr["registration"]?>"><?php echo $dr["registration"]?> (<?php echo $dr["code"]?>) <?php echo $dr["alias"]?></option>
					<?php
                                } //end while
		 	?>
		 </select>
	</td>
</tr>-->

  <tr >
      <td width=160px style="font-weight:bold;"><?php echo dic_("Reports.Date")?>:</td>
      <td width=240px style="padding-left:0px">
             <input id="datetime" type="text" class="textboxCalender2 text2" value="<?php echo $dt?>" onchange="changeKm(this.value)" />
      </td>
  </tr>

 


  <tr >
      <td style="font-weight:bold;"><?php dic("Reports.PrevFuel")?> (<?php echo $liqunit?>):</td>
      <td style="padding-left:0px">
             <input id="litersLast" onkeyup = "keyUp('litersLast');" type="text" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
      </td>
     
  </tr>

  <tr >
      <td style="font-weight:bold;"><?php dic("Fm.Dotur") ?> (<?php echo $liqunit?>):</td>
      <td style="padding-left:0px">
             <input id="liters" onkeyup = "keyUp('liters');" type="text" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
             <span style="color:red; font-size:14px;">&nbsp;*</span>
      </td>
     
  </tr>

 <tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.Odometer")?> (<?php echo $metric?>):</td>
      <?php
          $LastDay = DatetimeFormat(addDay(-1), 'd-m-Y');
	    $proKm = 0;
	    $dt = DateTimeFormat(nnull($dt, "01-01-1900"), "Y-m-d". " 00:00:00");
		
		opendb();
		
		$testCurrkm = dlookup("select count(*) from currkm where vehicleid=" . $vehID_);
		$lastDateKm = "";
		if ($testCurrkm > 0) {
			$lastDateKm = dlookup("select datetime from currkm where vehicleid=" . $vehID_);
		}
		
	    $pastKm = 0;
	    $Km = 0;
	    
	    If (DateTimeFormat($dt, "Y-m-d". " 00:00:00") == "1900-01-01 00:00:00") {
	        If ($lastDateKm <> "") {
	            $pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_ . " and Datetime >= '" . DateTimeFormat($lastDateKm, "Y-m-d 23:59:59") . "' and Datetime <= '" . DateTimeFormat($LastDay, "Y-m-d" . " 23:59:59") . "'"), 0);
	            $Km = nnull(dlookup("select km from currkm where vehicleid=" . $vehID_), 0);
	            $proKm = $pastKm + $Km;
	        } Else {
	            $proKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_), 0);
	        }
	    } Else {
	        If ($lastDateKm <> "") {
	        	if ($lastDateKm <= $dt) {
	        		$pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_ . " and Datetime >= '" . DateTimeFormat($lastDateKm, "Y-m-d 23:59:59") . "' and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "'"), 0);
		            $Km = nnull(dlookup("select km from currkm where vehicleid=" . $vehID_), 0);
		            $proKm = $pastKm + $Km;
	        	} else {
	        		$proKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_ . " and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "' "), 0);
	        	}
	            /*$pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehId . " and Datetime >= '" . DateTimeFormat($lastDateKm, "Y-m-d H:i:s") . "' and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "'"), 0);
	            $Km = nnull(dlookup("select km from currkm where vehicleid=" . $vehId), 0);
	            $proKm = $pastKm + $Km;*/
	        } Else {
	            $proKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_ . " and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "' "), 0);
	        }
	    }
       ?>
      <td style="padding-left:0px">
             <input id="km" value="<?php echo number_format(round($proKm * $metricvalue, 0)) ?>" onkeyup = "keyUp('km');" type="text" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
      </td>
      
  </tr>
  
  <tr>
	
     <td style="font-weight:bold;"><?php echo dic_("Reports.Executor")?>:</td>
      <td style="padding-left:0px">
      	 <input id="searchExe" type="text" onkeyup="OnKeyPressSearchExe(event.keyCode)" onclick="OnKeyPressSearchExe()" onblur="hideSearchExe()" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
    	 <div class="corner5" style="color:#2F5185; opacity:1; padding:5px; background-color:#fff; display:none; position:absolute; border:1px solid #CCCCCC; width:170px;height: 74px; float:left; overflow-y: auto; z-index:999999" id="listExe">
		<?php
		$locations = "select * from fmlocations where clientid=" . session("client_id") . " order by locationname asc";
		$dsLocations = query($locations);
		while ($drLocations = pg_fetch_array($dsLocations)) {
			?>
			<a id="a-F" class="" onmouseover="overDiv('F')" onmouseout="outDiv('F')" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickCost('F')"><?php echo dic_("Reports.Fuel")?></span>
			</a>
			<br>
			<?php						
		} 
		?>
		
		
		
		
      	<?php
      	/*$dsComp = query("select * from fmcomponents where clientid=" . session("client_id"));
		while ($drComp = pg_fetch_array($dsComp)) {
			?>
			<a id="a-<?php echo $drComp["id"]?>" class="" onmouseover="overDiv(<?php echo $drComp["id"]?>)" onmouseout="outDiv(<?php echo $drComp["id"]?>)" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickComp('<?php echo $drComp["id"]?>')"><?php echo mb_strtolower($drComp["componentname"], 'UTF-8')?></span><span id="x-<?php echo $drComp["id"]?>" onclick="deleteCost(<?php echo $drComp["id"]?>)" title="<?php echo dic_("Reports.DelComp1")?>" style="margin-right: 3px; margin-top: 2px; float:right; width: 9px; height: 9px; background-image: url('<?php echo $tpoint?>/images/x-mark1.png'); display:none;" />
			</a>
			<br>
			<?php
		}*/
      	?>
    	</div>
      	<!--select id="location" data-placeholder="" style="float:left; margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" >
                <?php
                
                    $locations = "select * from fmlocations where clientid=" . session("client_id") . " order by locationname asc";
				
                    $dsLocations = query($locations);
					
					while ($drLocations = pg_fetch_array($dsLocations)) { 
if ($cLang == 'mk') $loc_ = $drLocations["locationname"];
else $loc_ = cyr2lat($drLocations["locationname"]);
  
                     ?>
                       <option id="<?php echo $drLocations["id"] ?>" value="<?php echo $drLocations["id"] ?>"><?php echo $loc_ ?></option>
                     <?php
                   } //end while
                                 
                  
              ?>   
           </select-->
           &nbsp;&nbsp;<button id="addLoc" onClick="addLoc()" style="width:30px; height:27px;margin-top:5px" title="<?php echo dic_("Reports.AddNewExecutor")?>"></button>
<!--button id="delLoc" onClick="delExecutor('location')" style="width:30px; height:27px;margin-top:5px" title="Remove executor"></button-->   
      </td>
     
</tr>


 <?php 
//if ($ifDriver > 0) {
?>
  <tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.Employee")?>:</td>
      <td style="padding-left:0px">
      	
      		 <input id="searchDri" type="text" onkeyup="OnKeyPressSearchDri(event.keyCode)" onclick="OnKeyPressSearchDri()" onblur="hideSearchDri()" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
		    	 <div class="corner5" style="color:#2F5185; opacity:1; padding:5px; background-color:#fff; display:none; position:absolute; border:1px solid #CCCCCC; width:170px;height: 74px; float:left; overflow-y: auto; z-index:10011" id="listDri">
				<?php
				if ($ifDriver > 0) {
                    $drivers = "select fullname, id from drivers where id in (select driverid from vehicledriver where vehicleid=" . $vehID_ . ") order by fullname asc";
				} else {
					$drivers = "select fullname, id from drivers where clientid=" . session("client_id") . " order by fullname asc";
				}
				$dsDrivers = query($drivers);
				$firstDriver = pg_fetch_result($dsDrivers, 0, "id");
				while ($drDrivers = pg_fetch_array($dsDrivers)) {   

                  ?>
                    <a id="a-F" class="" onmouseover="overDiv('F')" onmouseout="outDiv('F')" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
						<span onclick="OnCLickCost('F')">---</span>
					</a>
					<br>
                     <?php
                   } //end while
				?>
				
				
				    	
             <!--select id="driver" data-placeholder="" onchange="changeDriver()" style="margin-top:5px;width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" onchange="changeDriver()">
                <?php
                    if ($ifDriver > 0) {
	                    $drivers = "select fullname, id from drivers where id in (select driverid from vehicledriver where vehicleid=" . $vehID_ . ") order by fullname asc";
					} else {
						$drivers = "select fullname, id from drivers where clientid=" . session("client_id") . " order by fullname asc";
					}
                   
                    $dsDrivers = query($drivers);
					$firstDriver = pg_fetch_result($dsDrivers, 0, "id");
					
					while ($drDrivers = pg_fetch_array($dsDrivers)) {   

                     ?>
                       <option id="<?php echo $drDrivers["id"] ?>" value="<?php echo $drDrivers["id"] ?>"><?php echo $drDrivers["fullname"] ?></option>
                     <?php
                   } //end while
                                 
                  
              ?>   
           </select-->
      </td>

  </tr>
<?php
//}
?>

 <tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.TermsPayment")?>:</td>
      <td style="padding-left:0px">
      	<?php
      	/*$cntCards = dlookup("select count(*) from drivercard where driverid= " . $firstDriver);
		if ($cntCards > 0) {
			$dsCards = query("select * from (select cardid id, (select cardname from clubcards where id=cardid) cardname, driverid, 4 
			from drivercard UNION select 0 id, '" . dic_("Reports.Cash") . "' cardname, " . $firstDriver . ", 1 
			UNION select 0 id, '" . dic_("Reports.Invoice") . "' cardname, " . $firstDriver . ", 2 ) s 
			where s.driverid= " . $firstDriver . " order by 4, id asc");
		} else {
			$dsCards = query("select * from (select *, 4 from clubcards 
			UNION select 0 id, '" . dic_("Reports.Cash") . "' cardname, " . session("client_id") . ", 1
			UNION select 0 id, '" . dic_("Reports.Invoice") . "' cardname, " . session("client_id") . ", 2
			) s where s.clientid= " . session("client_id") . " order by 4, id asc");
		}*/
      	?>
      	 <input id="searchPay" type="text" onkeyup="OnKeyPressSearchPay(event.keyCode)" onclick="OnKeyPressSearchPay()" onblur="hideSearchPay()" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
		    	 <div class="corner5" style="color:#2F5185; opacity:1; padding:5px; background-color:#fff; display:none; position:absolute; border:1px solid #CCCCCC; width:170px;height: 74px; float:left; overflow-y: auto; z-index:10011" id="listPay">
				<?php
											
					/*while ($drCard = pg_fetch_array($dsCards)) {
					?>
						<a id="a-<?php echo $drCard["id"]?>" class="" onmouseover="overDiv('<?php echo $drCard["id"]?>')" onmouseout="outDiv('<?php echo $drCard["id"]?>')" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
							<span onclick="OnCLickPay('<?php echo $drCard["id"]?>')"><?php echo mb_strtolower($drCard["cardname"], 'UTF-8')?></span>
						</a>
						<br>
					<?php
					}*/
				?>
 	  </td>
 	 
  </tr>
 

 <tr >
      <td style="font-weight:bold;"><?php dic("Reports.Iznos") ?> (<?php echo $currency?>):</td>
      <td style="padding-left:0px">
             <input id="price" type="text" onkeyup = "keyUp('price');" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
      		<span style="color:red; font-size:14px;">&nbsp;*</span>
      </td>
      
  </tr>
 <tr><td colspan=2 style="color:red; font-size:10px; font-style: italic; padding-right:62px" align="right"> <?php echo dic_("Reports.ReqFields")?> &nbsp;<span style="color:red; font-size:14px;">*</span></td></tr>
  </table>
<?php
} else {
	if ($cost == "Service") {
		opendb();
	?>
	<table align="center" class="text2_" width=430px style="margin-left:60px">
	
<tr style="height:35px;">
             <td colspan=2><div style="border-bottom:1px solid #bebebe; width:420px"></div></td>
      </tr>

  <!--<tr >
       <td width=100px style="font-weight:bold; "><?php dic("Fm.Vehicle")?>:</td>
      <td  width=200px style="padding-left:10px">
          <select id="cbVehicles" onchange="changeKm('', '')" style="margin-top:4px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 0; visibility: visible;" class="combobox text2" onchange="changeKm()">
             <?php
             	 opendb();
				 
                 $vehicles = "select registration, id from vehicles where clientid =" . Session("client_id") . " order by code asc";
                 $dsVehicles = query($vehicles);
                 $first =  pg_fetch_result($dsVehicles, 0, "id");
				 while ($drVehicles = pg_fetch_array($dsVehicles)) {
             ?>
                     <option id="<?php echo $drVehicles["id"] ?>" value="<?php echo $drVehicles["id"] ?>"><?php echo $drVehicles["registration"]?></option>
              <?php
                 } //end while
              ?>   
           </select>
      </td>


  </tr>-->

  <tr>
  	<td width=160px style="font-weight:bold; "><?php echo dic_("Reports.Date")?>:</td>
      <td width=240px style="padding-left:0px">
             <input id="datetime" type="text" class="textboxCalender2 text2" value="<?php echo $dt?>" onchange="changeKm(this.value)" />
      </td>
   </tr>

  

<tr>
	<td style="font-weight:bold; "><?php dic("Fm.Tip")?>:</td>
    <td style="padding-left:0px">
         <input type="radio" name="type" value="1" checked=checked /><?php dic("Fm.Regular") ?>
         <input type="radio" name="type" value="0"  style="margin-left:20px; margin-top:5px;" /><?php dic("Fm.Associate")?>
    </td>   
</tr>


  <tr>
  <td style="font-weight:bold;"><?php dic("Fm.Desc")?>:</td>
      <td style=" padding-left:0px">
      	<input id="desc" type="text" size=22 style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
      	<span style="color:red; font-size:14px;">&nbsp;*</span>
      	</td>
 
  </tr>

  <!-- <tr>
  <td style="font-weight:bold; padding-bottom:75px"><?php dic("Fm.Components")?>:</td>
      <td style="padding-left:10px">
       <textarea id="components" style=" margin-top:5px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; width:180px; height:80px; padding:5px; overflow-Y:autox"></textarea>
      &nbsp;&nbsp;<button id="addComp" onClick="addComp()" style="width:30px; height:27px;margin-top:5px; vertical-align:top" title="Додади нова компонента"></button>
      </td>
  </tr>-->

<tr>
  <td style="font-weight:bold; margin-top:5px; vertical-align: top"><?php dic("Fm.Components")?>:</td>
      <td style="padding-left:0px">
       
       <!--<div style="border:1px solid #CCCCCC; width:88px; float:left;margin-top:5px;height: 70px; overflow-y: auto;" class="corner5">
       	<ul id="components">
       		<?php
       		$dsComp = query("select * from fmcomponents where clientid= " . session("client_id"));
			while ($drComp = pg_fetch_array($dsComp)) {
       		?>
       		<li id="li-<?php echo $drComp["id"]?>" style="width: 55px; height:22px;  cursor:pointer" onmouseover="over(<?php echo $drComp["id"]?>)" onmouseout="out(<?php echo $drComp["id"]?>)" onclick="clickplus(<?php echo $drComp["id"]?>)"><div style="padding-top: 5px"><strong><span id="span-<?php echo $drComp["id"]?>">+</span></strong> <?php echo $drComp["componentname"]?></div></li>
			<?php
			}
			?>
       	</ul>
       </div>-->
      
       <input id="searchComp" type="text" onkeyup="OnKeyPressSearchComp(event.keyCode)" onclick="OnKeyPressSearchComp()" onblur="hideSearchComp()" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
    	 <div class="corner5" style="color:#2F5185; opacity:1; padding:5px; background-color:#fff; display:none; position:absolute; border:1px solid #CCCCCC; width:170px;height: 74px; float:left; overflow-y: auto; z-index:999999" id="listComp">
      	<?php
      	$dsComp = query("select * from fmcomponents where clientid=" . session("client_id"));
		while ($drComp = pg_fetch_array($dsComp)) {
			?>
			<!--div id="div-<?php echo $drComp["id"]?>" class="" style="cursor:pointer;" onmouseover="overDiv(<?php echo $drComp["id"]?>)" onmouseout="outDiv(<?php echo $drComp["id"]?>)"-->
			<a id="a-<?php echo $drComp["id"]?>" class="" onmouseover="overDiv(<?php echo $drComp["id"]?>)" onmouseout="outDiv(<?php echo $drComp["id"]?>)" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickComp('<?php echo $drComp["id"]?>')"><?php echo mb_strtolower($drComp["componentname"], 'UTF-8')?></span><span id="x-<?php echo $drComp["id"]?>" onclick="deleteComp(<?php echo $drComp["id"]?>)" title="<?php echo dic_("Reports.DelComp1")?>" style="margin-right: 3px; margin-top: 2px; float:right; width: 9px; height: 9px; background-image: url('<?php echo $tpoint?>/images/x-mark1.png'); display:none;" />
			</a>
			
			<br>
			<!--/div-->
			<?php
		}
      	?>
    	  </div>
       
       &nbsp;&nbsp;<button id="addComp" onClick="addComp()" style="margin-top:5px; width:30px; height:27px;vertical-align:top" title="<?php echo dic_("Reports.AddNewComponent")?>"></button>
      </td>
  </tr>
  
  <tr>
  	<td style="padding-left:0px" colspan=2>
  		 <div id="div-addcomp" style="color:#2F5185; border:1px solid #CCCCCC; margin-top:5px; width:350px;height: 80px; float:left; overflow-y: auto; position: relative: z-index:0" class="corner5">
  			<ul id="components-" style="color:#2F5185;margin-top:18px; position: relative; left: -32px; width: 325px;">
       		
       	</ul>
       </div>
<span style="color:red; font-size:14px; position: relative; top:5px">&nbsp;*</span>
  	</td>
  </tr>
  <!--<tr>
  	<td></td>
  	<td style="padding-left:10px">
  		 <div style="border:1px solid #CCCCCC; width:180px;margin-top:5px;height: 70px; overflow-y: auto" class="corner5">
  			<ul id="components-">
       		
       	</ul>
       </div>
  	</td>
  </tr>-->

 <tr>
        <?php
         $LastDay = DatetimeFormat(addDay(-1), 'd-m-Y');
	    $proKm = 0;
	    $dt = DateTimeFormat(nnull($dt, "01-01-1900"), "Y-m-d". " 00:00:00");
		
		
		
		$testCurrkm = dlookup("select count(*) from currkm where vehicleid=" . $vehID_);
		$lastDateKm = "";
		if ($testCurrkm > 0) {
			$lastDateKm = dlookup("select datetime from currkm where vehicleid=" . $vehID_);
		}
		
	    $pastKm = 0;
	    $Km = 0;
	    
	    If (DateTimeFormat($dt, "Y-m-d". " 00:00:00") == "1900-01-01 00:00:00") {
	        If ($lastDateKm <> "") {
	            $pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_ . " and Datetime >= '" . DateTimeFormat($lastDateKm, "Y-m-d 23:59:59") . "' and Datetime <= '" . DateTimeFormat($LastDay, "Y-m-d" . " 23:59:59") . "'"), 0);
	            $Km = nnull(dlookup("select km from currkm where vehicleid=" . $vehID_), 0);
	            $proKm = $pastKm + $Km;
	        } Else {
	            $proKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_), 0);
	        }
	    } Else {
	        If ($lastDateKm <> "") {
	        	if ($lastDateKm <= $dt) {
	        		$pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_ . " and Datetime >= '" . DateTimeFormat($lastDateKm, "Y-m-d 23:59:59") . "' and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "'"), 0);
		            $Km = nnull(dlookup("select km from currkm where vehicleid=" . $vehID_), 0);
		            $proKm = $pastKm + $Km;
	        	} else {
	        		$proKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_ . " and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "' "), 0);
	        	}
	            /*$pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehId . " and Datetime >= '" . DateTimeFormat($lastDateKm, "Y-m-d H:i:s") . "' and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "'"), 0);
	            $Km = nnull(dlookup("select km from currkm where vehicleid=" . $vehId), 0);
	            $proKm = $pastKm + $Km;*/
	        } Else {
	            $proKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_ . " and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "' "), 0);
	        }
	    }
          
         ?>
 	  <td style="font-weight:bold"><?php echo dic_("Reports.Odometer")?> (<?php echo $metric?>):</td>
      <td style="padding-left:0px"><input id="km" onkeyup = "keyUp('km');" value="<?php echo number_format(round($proKm * $metricvalue, 0)) ?>"  type="text" size=22 style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/></td>
  

  </tr>
  
<tr>
	
     <td style="font-weight:bold;"><?php echo dic_("Reports.Executor")?>:</td>
      <td style="padding-left:0px">
      	 <input id="searchExe" type="text" onkeyup="OnKeyPressSearchExe(event.keyCode)" onclick="OnKeyPressSearchExe()" onblur="hideSearchExe()" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
    	 <div class="corner5" style="color:#2F5185; opacity:1; padding:5px; background-color:#fff; display:none; position:absolute; border:1px solid #CCCCCC; width:170px;height: 74px; float:left; overflow-y: auto; z-index:999999" id="listExe">
		<?php
		$locations = "select * from fmlocations where clientid=" . session("client_id") . " order by locationname asc";
		$dsLocations = query($locations);
		while ($drLocations = pg_fetch_array($dsLocations)) {
			?>
			<a id="a-F" class="" onmouseover="overDiv('F')" onmouseout="outDiv('F')" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickCost('F')"><?php echo dic_("Reports.Fuel")?></span>
			</a>
			<br>
			<?php						
		} 
		?>
		
		
		
		
      	<?php
      	/*$dsComp = query("select * from fmcomponents where clientid=" . session("client_id"));
		while ($drComp = pg_fetch_array($dsComp)) {
			?>
			<a id="a-<?php echo $drComp["id"]?>" class="" onmouseover="overDiv(<?php echo $drComp["id"]?>)" onmouseout="outDiv(<?php echo $drComp["id"]?>)" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickComp('<?php echo $drComp["id"]?>')"><?php echo mb_strtolower($drComp["componentname"], 'UTF-8')?></span><span id="x-<?php echo $drComp["id"]?>" onclick="deleteCost(<?php echo $drComp["id"]?>)" title="<?php echo dic_("Reports.DelComp1")?>" style="margin-right: 3px; margin-top: 2px; float:right; width: 9px; height: 9px; background-image: url('<?php echo $tpoint?>/images/x-mark1.png'); display:none;" />
			</a>
			<br>
			<?php
		}*/
      	?>
    	</div>
      	<!--select id="location" data-placeholder="" style="float:left; margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" >
                <?php
                
                    $locations = "select * from fmlocations where clientid=" . session("client_id") . " order by locationname asc";
				
                    $dsLocations = query($locations);
					
					while ($drLocations = pg_fetch_array($dsLocations)) { 
if ($cLang == 'mk') $loc_ = $drLocations["locationname"];
else $loc_ = cyr2lat($drLocations["locationname"]);
  
                     ?>
                       <option id="<?php echo $drLocations["id"] ?>" value="<?php echo $drLocations["id"] ?>"><?php echo $loc_ ?></option>
                     <?php
                   } //end while
                                 
                  
              ?>   
           </select-->
           &nbsp;&nbsp;<button id="addLoc" onClick="addLoc()" style="width:30px; height:27px;margin-top:5px" title="<?php echo dic_("Reports.AddNewExecutor")?>"></button>
<!--button id="delLoc" onClick="delExecutor('location')" style="width:30px; height:27px;margin-top:5px" title="Remove executor"></button-->   
      </td>
     
</tr>

<?php
	//if ($ifDriver > 0) {
?>
  <tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.Employee")?>:</td>
      <td style="padding-left:0px">
      	
      		 <input id="searchDri" type="text" onkeyup="OnKeyPressSearchDri(event.keyCode)" onclick="OnKeyPressSearchDri()" onblur="hideSearchDri()" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
		    	 <div class="corner5" style="color:#2F5185; opacity:1; padding:5px; background-color:#fff; display:none; position:absolute; border:1px solid #CCCCCC; width:170px;height: 74px; float:left; overflow-y: auto; z-index:10011" id="listDri">
				<?php
				if ($ifDriver > 0) {
                    $drivers = "select fullname, id from drivers where id in (select driverid from vehicledriver where vehicleid=" . $vehID_ . ") order by fullname asc";
				} else {
					$drivers = "select fullname, id from drivers where clientid=" . session("client_id") . " order by fullname asc";
				}
				$dsDrivers = query($drivers);
				$firstDriver = pg_fetch_result($dsDrivers, 0, "id");
				while ($drDrivers = pg_fetch_array($dsDrivers)) {   

                  ?>
                    <a id="a-F" class="" onmouseover="overDiv('F')" onmouseout="outDiv('F')" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
						<span onclick="OnCLickCost('F')">---</span>
					</a>
					<br>
                     <?php
                   } //end while
				?>
				
				
				    	
             <!--select id="driver" data-placeholder="" onchange="changeDriver()" style="margin-top:5px;width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" onchange="changeDriver()">
                <?php
                    if ($ifDriver > 0) {
	                    $drivers = "select fullname, id from drivers where id in (select driverid from vehicledriver where vehicleid=" . $vehID_ . ") order by fullname asc";
					} else {
						$drivers = "select fullname, id from drivers where clientid=" . session("client_id") . " order by fullname asc";
					}
                   
                    $dsDrivers = query($drivers);
					$firstDriver = pg_fetch_result($dsDrivers, 0, "id");
					
					while ($drDrivers = pg_fetch_array($dsDrivers)) {   

                     ?>
                       <option id="<?php echo $drDrivers["id"] ?>" value="<?php echo $drDrivers["id"] ?>"><?php echo $drDrivers["fullname"] ?></option>
                     <?php
                   } //end while
                                 
                  
              ?>   
           </select-->
      </td>
  </tr>
  <?php
	//}
  ?>
  
<tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.TermsPayment")?>:</td>
      <td style="padding-left:0px">
      	<input id="searchPay" type="text" onkeyup="OnKeyPressSearchPay(event.keyCode)" onclick="OnKeyPressSearchPay()" onblur="hideSearchPay()" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
		    	 <div class="corner5" style="color:#2F5185; opacity:1; padding:5px; background-color:#fff; display:none; position:absolute; border:1px solid #CCCCCC; width:170px;height: 74px; float:left; overflow-y: auto; z-index:10011" id="listPay">
           <!--select id="pay" data-placeholder="" style="margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 10010; visibility: visible;" class="combobox text2">
                 <option value="g"><?php echo dic_("Reports.Cash")?></option>
                 <option value="f"><?php echo dic_("Reports.Invoice")?></option>
                 <?php	
                 	 //if ($ifDriver > 0)
                 		$cntCards = dlookup("select count(*) from drivercard where driverid= " . $firstDriver);
					 //else 
					//	 $cntCards = 0;
				 
					if ($cntCards > 0) {
						$dsCards = query("select * from drivercard where driverid= " . $firstDriver);
						while ($drCards = pg_fetch_array($dsCards)) {
							$nameCard = dlookup("select cardname from clubcards where id=" . $drCards["cardid"]);   
						?>
						<option value="k-<?php echo $drCards["cardid"]?>"  ><?php echo $nameCard?></option>
						<?php
						}
					} else {
						$dsCards = query("select * from clubcards where clientid= " . session("client_id") . " order by id asc");
						while ($drCards = pg_fetch_array($dsCards)) {
						?>
						<option value="k-<?php echo $drCards["id"]?>"><?php echo $drCards["cardname"]?></option>
						<?php
						}
					}
                 
                 ?>
                
           </select-->
 	  </td>
  </tr>
  
  <tr>
  	
 	 <td style="font-weight:bold;"><?php dic("Reports.Iznos") ?> (<?php echo $currency?>):</td>
      <td style="padding-left:0px"><input id="price" onkeyup = "keyUp('price');"  type="text" size=22 style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
      	<span style="color:red; font-size:14px;">&nbsp;*</span>
      </td>

  </tr>
<tr><td colspan=2 style="color:red; font-size:10px; font-style: italic; padding-right:62px" align="right"> <?php echo dic_("Reports.ReqFields")?> &nbsp;<span style="color:red; font-size:14px;">*</span></td></tr>
 
  </table>
	<?php	
	} else {
		if ($cost == "Cost") {
		 opendb();
	?>
	 <table align="center" class="text2_" width=430px style="margin-left:60px">

<tr style="height:35px;">
             <td colspan=2><div style="border-bottom:1px solid #bebebe; width:420px"></div></td>
      </tr>

  <!--<tr >
  	<td width=100px style="font-weight:bold; "><?php dic("Fm.Vehicle")?>:</td>
      <td width=200px style="padding-left:10px">
          <select id="cbVehicles" onchange="changeKm('', '')" style="margin-top:4px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 0; visibility: visible;" class="combobox text2">
                             <?php
                                 $vehicles = "select registration, id from vehicles where clientid =" . Session("client_id") . " order by code asc";
                                 $dsVehicles = query($vehicles);
                                 $first = pg_fetch_result($dsVehicles, 0, "id");
                                                                                 
                                 $proKm = 0;
                                 $lastDateKm = dlookup("select datetime from currkm where vehicleid=" . $first);
                                 $pastKm = 0;
                                 $Km = 0;
            
                                 If ($lastDateKm <> "") {
						              $pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $first . " and Datetime >= '" . DateTimeFormat($lastDateKm, "Y-m-d 23:59:59") . "' and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "'"), 0);
						              $Km = nnull(dlookup("select km from currkm where vehicleid=" . $first), 0);
						              $proKm = $pastKm + $Km;
						          } Else {
						              $proKm = NNull(DlookUP("select SUM(distance)/1000 from rshortreport where vehicleid=" . $first), 0);
						          }
                                         
								 while ($drVehicles = pg_fetch_array($dsVehicles)) {       
                               ?>
                                        <option id="<?php echo $drVehicles["id"] ?>" value="<?php echo $drVehicles["id"] ?>"><?php echo $drVehicles["registration"]?>
                               	<?php
                                  } //end while
                                  
                                  closedb();
                                ?>   
           </select>
      </td>
      <td></td><td></td>
      </tr>-->


  <tr>
  	   <td width=160px style="font-weight:bold; "><?php dic("Fm.Date")?>:</td>
      <td width=240px style="padding-left:0px"><input id="datetime" type="text" class="textboxCalender2 text2" value="<?php echo $dt?>" onchange="changeKm(this.value)" /></td>
     
   
  </tr>



  
  <tr>
  <td style="font-weight:bold;"><?php dic("Fm.Desc")?>:</td>
      <td colspan=3 style="padding-left:0px"><input id="desc" type="text" size=22 style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
      	<span style="color:red; font-size:14px;">&nbsp;*</span>
      </td>
 
  </tr>

  <tr>
  <td style="font-weight:bold; margin-top:5px; vertical-align: top"><?php dic("Fm.Components")?>:</td>
      <td style="padding-left:0px">
       
       <!--<div style="border:1px solid #CCCCCC; width:88px; float:left;margin-top:5px;height: 70px; overflow-y: auto;" class="corner5">
       	<ul id="components">
       		<?php
       		$dsComp = query("select * from fmcomponents where clientid= " . session("client_id"));
			while ($drComp = pg_fetch_array($dsComp)) {
       		?>
       		<li id="li-<?php echo $drComp["id"]?>" style="width: 55px; height:22px;  cursor:pointer" onmouseover="over(<?php echo $drComp["id"]?>)" onmouseout="out(<?php echo $drComp["id"]?>)" onclick="clickplus(<?php echo $drComp["id"]?>)"><div style="padding-top: 5px"><strong><span id="span-<?php echo $drComp["id"]?>">+</span></strong> <?php echo $drComp["componentname"]?></div></li>
			<?php
			}
			?>
       	</ul>
       </div>-->
      
       <input id="searchComp" type="text" onkeyup="OnKeyPressSearchComp(event.keyCode)" onclick="OnKeyPressSearchComp()" onblur="hideSearchComp()" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
    	 <div class="corner5" style="color:#2F5185; opacity:1; padding:5px; background-color:#fff; display:none; position:absolute; border:1px solid #CCCCCC; width:170px;height: 74px; float:left; overflow-y: auto; z-index:999999" id="listComp">
      	<?php
      	$dsComp = query("select * from fmcomponents where clientid=" . session("client_id"));
		while ($drComp = pg_fetch_array($dsComp)) {
			?>
			<!--div id="div-<?php echo $drComp["id"]?>" class="" style="cursor:pointer;" onmouseover="overDiv(<?php echo $drComp["id"]?>)" onmouseout="outDiv(<?php echo $drComp["id"]?>)"-->
			<a id="a-<?php echo $drComp["id"]?>" class="" onmouseover="overDiv(<?php echo $drComp["id"]?>)" onmouseout="outDiv(<?php echo $drComp["id"]?>)" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickComp('<?php echo $drComp["id"]?>')"><?php echo mb_strtolower($drComp["componentname"], 'UTF-8')?></span><span id="x-<?php echo $drComp["id"]?>" onclick="deleteComp(<?php echo $drComp["id"]?>)" title="<?php echo dic_("Reports.DelComp1")?>" style="margin-right: 3px; margin-top: 2px; float:right; width: 9px; height: 9px; background-image: url('<?php echo $tpoint?>/images/x-mark1.png'); display:none;" />
			</a>
			
			<br>
			<!--/div-->
			<?php
		}
      	?>
    	  </div>
       
       &nbsp;&nbsp;<button id="addComp" onClick="addComp()" style="margin-top:5px; width:30px; height:27px;vertical-align:top" title="<?php echo dic_("Reports.AddNewComponent")?>"></button>
      </td>
  </tr>
  
  <tr>
  	<td style="padding-left:0px" colspan=2>
  		 <div id="div-addcomp" style="color:#2F5185; border:1px solid #CCCCCC; margin-top:5px; width:350px;height: 80px; float:left; overflow-y: auto; position: relative: z-index:0" class="corner5">
  			<ul id="components-" style="color:#2F5185;margin-top:18px; position: relative; left: -32px; width: 325px;">
       		
       	</ul>
       </div>
<span style="color:red; font-size:14px; position: relative; top:5px">&nbsp;*</span>
  	</td>
  </tr>

<tr>
	<td style="font-weight:bold; "><?php dic("Reports.Odometer")?> (<?php echo $metric?>):</td>
	<?php
	
        $LastDay = DatetimeFormat(addDay(-1), 'd-m-Y');
	    $proKm = 0;
	    $dt = DateTimeFormat(nnull($dt, "01-01-1900"), "Y-m-d". " 00:00:00");
		
		opendb();
		$testCurrkm = dlookup("select count(*) from currkm where vehicleid=" . $vehID_);
		$lastDateKm = "";
		if ($testCurrkm > 0) {
			$lastDateKm = dlookup("select datetime from currkm where vehicleid=" . $vehID_);
		}
		
	    $pastKm = 0;
	    $Km = 0;
	    
	    If (DateTimeFormat($dt, "Y-m-d". " 00:00:00") == "1900-01-01 00:00:00") {
	        If ($lastDateKm <> "") {
	            $pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_ . " and Datetime >= '" . DateTimeFormat($lastDateKm, "Y-m-d 23:59:59") . "' and Datetime <= '" . DateTimeFormat($LastDay, "Y-m-d" . " 23:59:59") . "'"), 0);
	            $Km = nnull(dlookup("select km from currkm where vehicleid=" . $vehID_), 0);
	            $proKm = $pastKm + $Km;
	        } Else {
	            $proKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_), 0);
	        }
	    } Else {
	        If ($lastDateKm <> "") {
	        	if ($lastDateKm <= $dt) {
	        		$pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_ . " and Datetime >= '" . DateTimeFormat($lastDateKm, "Y-m-d 23:59:59") . "' and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "'"), 0);
		            $Km = nnull(dlookup("select km from currkm where vehicleid=" . $vehID_), 0);
		            $proKm = $pastKm + $Km;
	        	} else {
	        		$proKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_ . " and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "' "), 0);
	        	}
	            /*$pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehId . " and Datetime >= '" . DateTimeFormat($lastDateKm, "Y-m-d H:i:s") . "' and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "'"), 0);
	            $Km = nnull(dlookup("select km from currkm where vehicleid=" . $vehId), 0);
	            $proKm = $pastKm + $Km;*/
	        } Else {
	            $proKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_ . " and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "' "), 0);
	        }
	    }
          
         ?>
      <td style="padding-left:0px"><input id="km" onkeyup = "keyUp('km');" disabled value="<?php echo number_format(round($proKm * $metricvalue, 0)) ?>" type="text" size=22 style="margin-top:5px;color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/></td>

</tr>

<tr>
	
     <td style="font-weight:bold;"><?php echo dic_("Reports.Executor")?>:</td>
      <td style="padding-left:0px">
      	 <input id="searchExe" type="text" onkeyup="OnKeyPressSearchExe(event.keyCode)" onclick="OnKeyPressSearchExe()" onblur="hideSearchExe()" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
    	 <div class="corner5" style="color:#2F5185; opacity:1; padding:5px; background-color:#fff; display:none; position:absolute; border:1px solid #CCCCCC; width:170px;height: 74px; float:left; overflow-y: auto; z-index:999999" id="listExe">
		<?php
		opendb();
		$locations = "select * from fmlocations where clientid=" . session("client_id") . " order by locationname asc";
		$dsLocations = query($locations);
		while ($drLocations = pg_fetch_array($dsLocations)) {
			?>
			<a id="a-F" class="" onmouseover="overDiv('F')" onmouseout="outDiv('F')" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickCost('F')"><?php echo dic_("Reports.Fuel")?></span>
			</a>
			<br>
			<?php						
		} 
		?>
		
		
		
		
      	<?php
      	/*$dsComp = query("select * from fmcomponents where clientid=" . session("client_id"));
		while ($drComp = pg_fetch_array($dsComp)) {
			?>
			<a id="a-<?php echo $drComp["id"]?>" class="" onmouseover="overDiv(<?php echo $drComp["id"]?>)" onmouseout="outDiv(<?php echo $drComp["id"]?>)" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickComp('<?php echo $drComp["id"]?>')"><?php echo mb_strtolower($drComp["componentname"], 'UTF-8')?></span><span id="x-<?php echo $drComp["id"]?>" onclick="deleteCost(<?php echo $drComp["id"]?>)" title="<?php echo dic_("Reports.DelComp1")?>" style="margin-right: 3px; margin-top: 2px; float:right; width: 9px; height: 9px; background-image: url('<?php echo $tpoint?>/images/x-mark1.png'); display:none;" />
			</a>
			<br>
			<?php
		}*/
      	?>
    	</div>
      	<!--select id="location" data-placeholder="" style="float:left; margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" >
                <?php
                
                    $locations = "select * from fmlocations where clientid=" . session("client_id") . " order by locationname asc";
				
                    $dsLocations = query($locations);
					
					while ($drLocations = pg_fetch_array($dsLocations)) { 
if ($cLang == 'mk') $loc_ = $drLocations["locationname"];
else $loc_ = cyr2lat($drLocations["locationname"]);
  
                     ?>
                       <option id="<?php echo $drLocations["id"] ?>" value="<?php echo $drLocations["id"] ?>"><?php echo $loc_ ?></option>
                     <?php
                   } //end while
                                 
                  
              ?>   
           </select-->
           &nbsp;&nbsp;<button id="addLoc" onClick="addLoc()" style="width:30px; height:27px;margin-top:5px" title="<?php echo dic_("Reports.AddNewExecutor")?>"></button>
<!--button id="delLoc" onClick="delExecutor('location')" style="width:30px; height:27px;margin-top:5px" title="Remove executor"></button-->   
      </td>
     
</tr>

<?php
//if ($ifDriver > 0) {
?>
  <tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.Employee")?>:</td>
      <td style="padding-left:0px">
      	
      		 <input id="searchDri" type="text" onkeyup="OnKeyPressSearchDri(event.keyCode)" onclick="OnKeyPressSearchDri()" onblur="hideSearchDri()" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
		    	 <div class="corner5" style="color:#2F5185; opacity:1; padding:5px; background-color:#fff; display:none; position:absolute; border:1px solid #CCCCCC; width:170px;height: 74px; float:left; overflow-y: auto; z-index:10011" id="listDri">
				<?php
				if ($ifDriver > 0) {
                    $drivers = "select fullname, id from drivers where id in (select driverid from vehicledriver where vehicleid=" . $vehID_ . ") order by fullname asc";
				} else {
					$drivers = "select fullname, id from drivers where clientid=" . session("client_id") . " order by fullname asc";
				}
				$dsDrivers = query($drivers);
				$firstDriver = pg_fetch_result($dsDrivers, 0, "id");
				while ($drDrivers = pg_fetch_array($dsDrivers)) {   

                  ?>
                    <a id="a-F" class="" onmouseover="overDiv('F')" onmouseout="outDiv('F')" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
						<span onclick="OnCLickCost('F')">---</span>
					</a>
					<br>
                     <?php
                   } //end while
				?>
				
				
				    	
             <!--select id="driver" data-placeholder="" onchange="changeDriver()" style="margin-top:5px;width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" onchange="changeDriver()">
                <?php
                    if ($ifDriver > 0) {
	                    $drivers = "select fullname, id from drivers where id in (select driverid from vehicledriver where vehicleid=" . $vehID_ . ") order by fullname asc";
					} else {
						$drivers = "select fullname, id from drivers where clientid=" . session("client_id") . " order by fullname asc";
					}
                   
                    $dsDrivers = query($drivers);
					$firstDriver = pg_fetch_result($dsDrivers, 0, "id");
					
					while ($drDrivers = pg_fetch_array($dsDrivers)) {   

                     ?>
                       <option id="<?php echo $drDrivers["id"] ?>" value="<?php echo $drDrivers["id"] ?>"><?php echo $drDrivers["fullname"] ?></option>
                     <?php
                   } //end while
                                 
                  
              ?>   
           </select-->
      </td>
  </tr>
  <?php
 // }
  ?>
<tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.TermsPayment")?>:</td>
      <td style="padding-left:0px">
      	<input id="searchPay" type="text" onkeyup="OnKeyPressSearchPay(event.keyCode)" onclick="OnKeyPressSearchPay()" onblur="hideSearchPay()" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
		    	 <div class="corner5" style="color:#2F5185; opacity:1; padding:5px; background-color:#fff; display:none; position:absolute; border:1px solid #CCCCCC; width:170px;height: 74px; float:left; overflow-y: auto; z-index:10011" id="listPay">
		    	 	
           <!--select id="pay" data-placeholder="" style="margin-top:5px;width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 10010; visibility: visible;" class="combobox text2">
                 <option value="g"><?php echo dic_("Reports.Cash")?></option>
                 <option value="f"><?php echo dic_("Reports.Invoice")?></option>
                 <?php	
                 	 //if ($ifDriver > 0)
                 		$cntCards = dlookup("select count(*) from drivercard where driverid= " . $firstDriver);
					 //else 
						 //$cntCards = 0;
				 
					if ($cntCards > 0) {
						$dsCards = query("select * from drivercard where driverid= " . $firstDriver);
						while ($drCards = pg_fetch_array($dsCards)) {
							$nameCard = dlookup("select cardname from clubcards where id=" . $drCards["cardid"]);   
						?>
						<option value="k-<?php echo $drCards["cardid"]?>"  ><?php echo $nameCard?></option>
						<?php
						}
					} else {
						$dsCards = query("select * from clubcards where clientid= " . session("client_id") . " order by id asc");
						while ($drCards = pg_fetch_array($dsCards)) {
						?>
						<option value="k-<?php echo $drCards["id"]?>"><?php echo $drCards["cardname"]?></option>
						<?php
						}
					}
                 	
                 ?>
                
           </select-->
 	  </td>
  </tr>
  
  <tr>
  	 
  <td style="font-weight:bold;"><?php dic("Reports.Iznos") ?> (<?php echo $currency?>):</td>
      <td style="padding-left:0px"><input id="price" onkeyup = "keyUp('price');" type="text" size=22 style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
      	<span style="color:red; font-size:14px;">&nbsp;*</span>
      </td>

  </tr>
<tr><td colspan=2 style="color:red; font-size:10px; font-style: italic; padding-right:62px" align="right"> <?php echo dic_("Reports.ReqFields")?> &nbsp;<span style="color:red; font-size:14px;">*</span></td></tr>
  </table>
	<?php	
	} else {
		?>
	
	<table align="center" class="text2_" width=430px style="margin-left:60px">

<tr style="height:35px;">
             <td colspan=2><div style="border-bottom:1px solid #bebebe; width:420px"></div></td>
      </tr>

  <!--<tr >
  	<td width=100px style="font-weight:bold; "><?php dic("Fm.Vehicle")?>:</td>
      <td width=200px style="padding-left:10px">
          <select id="cbVehicles" onchange="changeKm('', '')" style="margin-top:4px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 0; visibility: visible;" class="combobox text2">
                             <?php
                                 $vehicles = "select registration, id from vehicles where clientid =" . Session("client_id") . " order by code asc";
                                 $dsVehicles = query($vehicles);
                                 $first = pg_fetch_result($dsVehicles, 0, "id");
                                                                                 
                                 $proKm = 0;
                                 $lastDateKm = dlookup("select datetime from currkm where vehicleid=" . $first);
                                 $pastKm = 0;
                                 $Km = 0;
            
                                 If ($lastDateKm <> "") {
						              $pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $first . " and Datetime >= '" . DateTimeFormat($lastDateKm, "Y-m-d 23:59:59") . "' and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "'"), 0);
						              $Km = nnull(dlookup("select km from currkm where vehicleid=" . $first), 0);
						              $proKm = $pastKm + $Km;
						          } Else {
						              $proKm = NNull(DlookUP("select SUM(distance)/1000 from rshortreport where vehicleid=" . $first), 0);
						          }
                                         
								 while ($drVehicles = pg_fetch_array($dsVehicles)) {       
                               ?>
                                        <option id="<?php echo $drVehicles["id"] ?>" value="<?php echo $drVehicles["id"] ?>"><?php echo $drVehicles["registration"]?>
                               	<?php
                                  } //end while
                                  
                                  closedb();
                                ?>   
           </select>
      </td>
      <td></td><td></td>
      </tr>-->


  <tr>
  	   <td width=160px style="font-weight:bold; "><?php echo dic_("Reports.Date")?>:</td>
      <td width=240px style="padding-left:0px">
      	<input id="datetime" type="text" class="textboxCalender2 text2" value="<?php echo $dt?>" onchange="changeKm(this.value)" /></td>
     
   
  </tr>


<tr>
	<td style="font-weight:bold; "><?php dic("Reports.Odometer")?> (<?php echo $metric?>):</td>
	<?php
	
          $LastDay = DatetimeFormat(addDay(-1), 'd-m-Y');
	    $proKm = 0;
	    $dt = DateTimeFormat(nnull($dt, "01-01-1900"), "Y-m-d". " 00:00:00");
		
		opendb();
		
		$testCurrkm = dlookup("select count(*) from currkm where vehicleid=" . $vehID_);
		$lastDateKm = "";
		if ($testCurrkm > 0) {
			$lastDateKm = dlookup("select datetime from currkm where vehicleid=" . $vehID_);
		}
		
	    $pastKm = 0;
	    $Km = 0;
	    
	    If (DateTimeFormat($dt, "Y-m-d". " 00:00:00") == "1900-01-01 00:00:00") {
	        If ($lastDateKm <> "") {
	            $pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_ . " and Datetime >= '" . DateTimeFormat($lastDateKm, "Y-m-d 23:59:59") . "' and Datetime <= '" . DateTimeFormat($LastDay, "Y-m-d" . " 23:59:59") . "'"), 0);
	            $Km = nnull(dlookup("select km from currkm where vehicleid=" . $vehID_), 0);
	            $proKm = $pastKm + $Km;
	        } Else {
	            $proKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_), 0);
	        }
	    } Else {
	        If ($lastDateKm <> "") {
	        	if ($lastDateKm <= $dt) {
	        		$pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_ . " and Datetime >= '" . DateTimeFormat($lastDateKm, "Y-m-d 23:59:59") . "' and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "'"), 0);
		            $Km = nnull(dlookup("select km from currkm where vehicleid=" . $vehID_), 0);
		            $proKm = $pastKm + $Km;
	        	} else {
	        		$proKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_ . " and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "' "), 0);
	        	}
	            /*$pastKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehId . " and Datetime >= '" . DateTimeFormat($lastDateKm, "Y-m-d H:i:s") . "' and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "'"), 0);
	            $Km = nnull(dlookup("select km from currkm where vehicleid=" . $vehId), 0);
	            $proKm = $pastKm + $Km;*/
	        } Else {
	            $proKm = nnull(dlookup("select SUM(distance)/1000 from rshortreport where vehicleid=" . $vehID_ . " and Datetime <= '" . DateTimeFormat($dt, "Y-m-d" . " 23:59:59") . "' "), 0);
	        }
	    }
          
         ?>
      <td style="padding-left:0px"><input id="km" disabled value="<?php echo number_format(round($proKm * $metricvalue, 0)) ?>" type="text" size=22 style="margin-top:5px;color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/></td>

</tr>

<tr>
	
     <td style="font-weight:bold;"><?php echo dic_("Reports.Executor")?>:</td>
      <td style="padding-left:0px">
      	 <input id="searchExe" type="text" onkeyup="OnKeyPressSearchExe(event.keyCode)" onclick="OnKeyPressSearchExe()" onblur="hideSearchExe()" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
    	 <div class="corner5" style="color:#2F5185; opacity:1; padding:5px; background-color:#fff; display:none; position:absolute; border:1px solid #CCCCCC; width:170px;height: 74px; float:left; overflow-y: auto; z-index:999999" id="listExe">
		<?php
		$locations = "select * from fmlocations where clientid=" . session("client_id") . " order by locationname asc";
		$dsLocations = query($locations);
		while ($drLocations = pg_fetch_array($dsLocations)) {
			?>
			<a id="a-F" class="" onmouseover="overDiv('F')" onmouseout="outDiv('F')" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickCost('F')"><?php echo dic_("Reports.Fuel")?></span>
			</a>
			<br>
			<?php						
		} 
		?>
		
		
		
		
      	<?php
      	/*$dsComp = query("select * from fmcomponents where clientid=" . session("client_id"));
		while ($drComp = pg_fetch_array($dsComp)) {
			?>
			<a id="a-<?php echo $drComp["id"]?>" class="" onmouseover="overDiv(<?php echo $drComp["id"]?>)" onmouseout="outDiv(<?php echo $drComp["id"]?>)" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickComp('<?php echo $drComp["id"]?>')"><?php echo mb_strtolower($drComp["componentname"], 'UTF-8')?></span><span id="x-<?php echo $drComp["id"]?>" onclick="deleteCost(<?php echo $drComp["id"]?>)" title="<?php echo dic_("Reports.DelComp1")?>" style="margin-right: 3px; margin-top: 2px; float:right; width: 9px; height: 9px; background-image: url('<?php echo $tpoint?>/images/x-mark1.png'); display:none;" />
			</a>
			<br>
			<?php
		}*/
      	?>
    	</div>
      	<!--select id="location" data-placeholder="" style="float:left; margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" >
                <?php
                
                    $locations = "select * from fmlocations where clientid=" . session("client_id") . " order by locationname asc";
				
                    $dsLocations = query($locations);
					
					while ($drLocations = pg_fetch_array($dsLocations)) { 
if ($cLang == 'mk') $loc_ = $drLocations["locationname"];
else $loc_ = cyr2lat($drLocations["locationname"]);
  
                     ?>
                       <option id="<?php echo $drLocations["id"] ?>" value="<?php echo $drLocations["id"] ?>"><?php echo $loc_ ?></option>
                     <?php
                   } //end while
                                 
                  
              ?>   
           </select-->
           &nbsp;&nbsp;<button id="addLoc" onClick="addLoc()" style="width:30px; height:27px;margin-top:5px" title="<?php echo dic_("Reports.AddNewExecutor")?>"></button>
<!--button id="delLoc" onClick="delExecutor('location')" style="width:30px; height:27px;margin-top:5px" title="Remove executor"></button-->   
      </td>
     
</tr>

<?php
//if ($ifDriver > 0) {
?>
  <tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.Employee")?>:</td>
      <td style="padding-left:0px">
      	
      		 <input id="searchDri" type="text" onkeyup="OnKeyPressSearchDri(event.keyCode)" onclick="OnKeyPressSearchDri()" onblur="hideSearchDri()" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
		    	 <div class="corner5" style="color:#2F5185; opacity:1; padding:5px; background-color:#fff; display:none; position:absolute; border:1px solid #CCCCCC; width:170px;height: 74px; float:left; overflow-y: auto; z-index:10011" id="listDri">
				<?php
				if ($ifDriver > 0) {
                    $drivers = "select fullname, id from drivers where id in (select driverid from vehicledriver where vehicleid=" . $vehID_ . ") order by fullname asc";
				} else {
					$drivers = "select fullname, id from drivers where clientid=" . session("client_id") . " order by fullname asc";
				}
				$dsDrivers = query($drivers);
				$firstDriver = pg_fetch_result($dsDrivers, 0, "id");
				while ($drDrivers = pg_fetch_array($dsDrivers)) {   

                  ?>
                    <a id="a-F" class="" onmouseover="overDiv('F')" onmouseout="outDiv('F')" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
						<span onclick="OnCLickCost('F')">---</span>
					</a>
					<br>
                     <?php
                   } //end while
				?>
				
				
				    	
             <!--select id="driver" data-placeholder="" onchange="changeDriver()" style="margin-top:5px;width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" onchange="changeDriver()">
                <?php
                    if ($ifDriver > 0) {
	                    $drivers = "select fullname, id from drivers where id in (select driverid from vehicledriver where vehicleid=" . $vehID_ . ") order by fullname asc";
					} else {
						$drivers = "select fullname, id from drivers where clientid=" . session("client_id") . " order by fullname asc";
					}
                   
                    $dsDrivers = query($drivers);
					$firstDriver = pg_fetch_result($dsDrivers, 0, "id");
					
					while ($drDrivers = pg_fetch_array($dsDrivers)) {   

                     ?>
                       <option id="<?php echo $drDrivers["id"] ?>" value="<?php echo $drDrivers["id"] ?>"><?php echo $drDrivers["fullname"] ?></option>
                     <?php
                   } //end while
                                 
                  
              ?>   
           </select-->
      </td>
  </tr>
  <?php
  //}
  ?>
<tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.TermsPayment")?>:</td>
      <td style="padding-left:0px">
      	<input id="searchPay" type="text" onkeyup="OnKeyPressSearchPay(event.keyCode)" onclick="OnKeyPressSearchPay()" onblur="hideSearchPay()" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
		    	 <div class="corner5" style="color:#2F5185; opacity:1; padding:5px; background-color:#fff; display:none; position:absolute; border:1px solid #CCCCCC; width:170px;height: 74px; float:left; overflow-y: auto; z-index:10011" id="listPay">
           <!--select id="pay" data-placeholder="" style="margin-top:5px;width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 10010; visibility: visible;" class="combobox text2">
                 <option value="g"><?php echo dic_("Reports.Cash")?></option>
                 <option value="f"><?php echo dic_("Reports.Invoice")?></option>
                 <?php	
                 	 //if ($ifDriver > 0)
                 		$cntCards = dlookup("select count(*) from drivercard where driverid= " . $firstDriver);
					 //else 
						// $cntCards = 0;
				 
					if ($cntCards > 0) {
						$dsCards = query("select * from drivercard where driverid= " . $firstDriver);
						while ($drCards = pg_fetch_array($dsCards)) {
							$nameCard = dlookup("select cardname from clubcards where id=" . $drCards["cardid"]);   
						?>
						<option value="k-<?php echo $drCards["cardid"]?>"  ><?php echo $nameCard?></option>
						<?php
						}
					} else {
						$dsCards = query("select * from clubcards where clientid= " . session("client_id") . " order by id asc");
						while ($drCards = pg_fetch_array($dsCards)) {
						?>
						<option value="k-<?php echo $drCards["id"]?>"><?php echo $drCards["cardname"]?></option>
						<?php
						}
					}
                 	
                 ?>
                
           </select-->
 	  </td>
  </tr>
  
  <tr>
  	 
  <td style="font-weight:bold;"><?php dic("Reports.Iznos") ?> (<?php echo $currency?>):</td>
      <td style="padding-left:0px"><input id="price" onkeyup = "keyUp('price');" type="text" size=22 style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
      	<span style="color:red; font-size:14px;">&nbsp;*</span>
     
      </td>

  </tr>
<tr><td colspan=2 style="color:red; font-size:10px; font-style: italic; padding-right:62px" align="right"> <?php echo dic_("Reports.ReqFields")?> &nbsp;<span style="color:red; font-size:14px;">*</span></td></tr>
  </table>
  
		<?php
	}
}
}
closedb(); 

?>
</body>


<script>

    
$('#addLoc').button({ icons: { primary: "ui-icon-plus"} })
$('#delLoc').button({ icons: { primary: "ui-icon-minus"} })
$('#addComp').button({ icons: { primary: "ui-icon-plus"} })

function over1(id){
	document.getElementById("li-" + id).style.backgroundColor = "#F7962B"
	document.getElementById("li-" + id).style.color = "white"
	document.getElementById("li-" + id).style.fontWeight = "bold"
}
function out1(id){
	if (document.getElementById("li-" + id).style.cssFloat == "left")
		document.getElementById("li-" + id).style.backgroundColor = "#D5DFF0"
	else
		document.getElementById("li-" + id).style.backgroundColor = ""
	document.getElementById("li-" + id).style.color = ""
	document.getElementById("li-" + id).style.fontWeight = "normal"
}
function clickplus(id) {
	
	document.getElementById("li-" + id).style.backgroundColor = ""
	document.getElementById("li-" + id).style.color = ""
	document.getElementById("li-" + id).style.fontWeight = "normal"
	document.getElementById("li-" + id).style.cssFloat = ""
	document.getElementById("li-" + id).style.width = "135px"
	document.getElementById("li-" + id).setAttribute('class','');
	document.getElementById("li-" + id).onclick = function() { clickminus(id); }
	document.getElementById("span-" + id).innerHTML = "-";
	$("#components-").append(document.getElementById("li-" + id));
}

function clickminus(id) {
	document.getElementById("li-" + id).style.backgroundColor = "#D5DFF0"
	document.getElementById("li-" + id).style.color = ""
	document.getElementById("li-" + id).style.fontWeight = "normal"
	document.getElementById("li-" + id).style.cssFloat = "left"
	document.getElementById("li-" + id).style.width = ""
	document.getElementById("li-" + id).setAttribute('class','corner8');
	document.getElementById("li-" + id).onclick = function() { clickplus(id); }
	document.getElementById("span-" + id).innerHTML = "";
	$("#components").append(document.getElementById("li-" + id));
}

function addLoc() {
	$('#listExe').hide();
	document.getElementById('div-locMain').title = dic("Reports.AddNewExecutor")
	 $.ajax({
            url: "<?php echo $tpoint?>/main/AddLocation.php?l=" + lang + "&tpoint=<?php echo $tpoint?>",
            context: document.body,
            success: function (data) {
           
                $('#div-locMain').html(data);
                $('#div-locMain').dialog({ modal: true, height: 235, width: 400,
               	zIndex: 10002 ,
                   buttons: [
                   {
                         text: dic("add"),
                         click: function () {
                         	if (document.getElementById('locname')) {
	                         	var locname = document.getElementById('locname').value;	
	                         	if (locname == "") {
	                         		alert(dic('Reports.EnterNameExe', lang) + " !!!");
	                         		$('#locname').css({border:'1px solid red'});
                         			document.getElementById('locname').focus();	
	                         	} else {
		                   			$.ajax({
		                                url: "<?php echo $tpoint?>/main/InsertLocation.php?locname=" + locname + "&l=" + lang + "&tpoint=<?php echo $tpoint?>",
		                                context: document.body,
		                                success: function (data) {
		                                	if (data != 0) {
		                                  	 $('#div-locMain').dialog("close");
                                			$('#searchExe').val(data.split("-")[1]);
                                			$("#searchExe").attr('class', '');
											$('#searchExe').addClass(data.split("-")[0]);
										
		                                    /*$.ajax({
				                                url: "<php echo $tpoint?>/main/CalculateLocations.php?locname=" + locname + "&l=" + lang + "&tpoint=<php echo $tpoint?>",
				                                context: document.body,
				                                success: function (data) {
				                                	if (document.getElementById('location'))
				                                    	document.getElementById('location').innerHTML = data;
				                                }
				                            });*/
		                            		} else {
		                            			alert(dic("Reports.AlreadyExecutor") + " '" + locname + "' !!!")
		                            		}
		                                }
		                            });
	                           }
                           }
                         }
                   },
                       {
                         text: dic("cancel"),
                         click: function () {
                         	$(this).dialog("close");
                         }
                       }
                   ]
                   
                   
               });
            }
        });
}


function addComp() {
	
	document.getElementById('div-compMain').title = "<?php echo dic_("Reports.AddNewComponent")?>"
	 $.ajax({
            url: "<?php echo $tpoint?>/main/AddComponent.php?l=" + '<?php echo $cLang?>' + '&tpoint=<?php echo $tpoint?>',
            context: document.body,
            success: function (data) {
           
               $('#div-compMain').html(data);
               $('#div-compMain').dialog({ modal: true, height: 235, width: 400,
               	zIndex: 10002 ,
                   buttons: [
                   {
                         text: dic("add"),
                         click: function () {
                         	var compname = document.getElementById('compname').value;	
                         	if (compname == "") {
                         		alert(dic('Reports.EnterNameComp', lang) + " !!!")
                         		$('#compname').css({border:'1px solid red'});
                         		document.getElementById('compname').focus();	
                         	} else {	
                         	
	                   			$.ajax({
                                url: "<?php echo $tpoint?>/main/InsertComponent.php?compname=" + compname + '&tpoint=<?php echo $tpoint?>',
	                                context: document.body,
	                                success: function (data) {
	                                	
										data = data.replace(/\s+/g, '');
	                                	if (data != 0) {
	                                   $('#div-compMain').dialog("close");
	                                   
	                                   //var _html = compname + '<span id="x-83" style="margin-right: 3px; margin-top: 2px; float: right; width: 9px; height: 9px; background-image: url(&quot;<php echo $tpoint?>/images/x-mark.png&quot;);"></span>';
	                                   
	                                   var _html = '<span id="main-'+data+'" class="corner5" style="color:#2F5185; display:inline-block; margin-bottom:5px; margin-left:5px; background-color:#F57A49">&nbsp&nbsp;' + compname + '&nbsp&nbsp;<img src ="<?php echo $tpoint?>/images/x-mark1.png" title="<?php echo dic_("Reports.DelListComp")?>" onclick="upComp(' + data + ')" style="cursor:pointer; position:relative; top:1px"/>&nbsp&nbsp;</span>';
	                                   $("#components-").append(_html);	
	                                   /* $.ajax({
		                                url: "<php echo $tpoint?>/main/CalculateComponents.php?compname=" + compname + '&tpoint=<php echo $tpoint?>',
			                                context: document.body,
			                                success: function (data) {
			                                    	$("#components-").append(data);
			                                    	
			                                }
			                            });*/
	                            		} else {
	                            			alert(dic("Reports.AlreadyComponent") + " '" + compname + "' !!!");
	                            		}
	                                }
	                            });
                           }
                         }
                   },
                       {
                         text: dic("cancel"),
                         click: function () {
                         	$(this).dialog("close");
                         }
                       }
                   ]
                   
                   
               });
            }
        });
}


function intFormat(n) {
	var regex = /(\d)((\d{3},?)+)$/;
	n = n.split(',').join('');
	
	while(regex.test(n)) {
	n = n.replace(regex, '$1,$2');
	}
	return n;
}
function keyUp(id) {
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
	
    function changeKm(dt, veh) {
    	if (dt == "") dt =  document.getElementById('datetime').value;
    	veh = <?php echo $vehID_?>; //$('#cbVehicles').children(":selected").attr("id");

        $.ajax({
            url: "<?php echo $tpoint?>/main/CalculateCurrKm.php?vehId=" + veh + "&dt=" + '' + dt + '' + '&tpoint=<?php echo $tpoint?>',
            context: document.body,
            success: function (data) {
                document.getElementById('km').value = data;
            }
        });
		
		if ( document.getElementById('driver')) {
			$.ajax({
	            url: "<?php echo $tpoint?>/main/CalculateDrivers.php?vehId=" + veh + '' + '&tpoint=<?php echo $tpoint?>',
	            context: document.body,
	            success: function (data) {
	                document.getElementById('driver').innerHTML = data;
	            }
	        });
		}
		
        
    }
    
    
function delExecutor(idSelect, selectName) {

	var val = selectName;

	top.document.getElementById('div-del-cost').title = '<?php echo dic_("Reports.DelExe")?>';	

        $.ajax({
		    url: "<?php echo $tpoint?>/main/DelExecutorQuestion.php?l="+lang + "&executor=" + val + "&tpoint=<?php echo $tpoint?>",
		    context: document.body,
		    success: function(data){
   				top.$('#div-del-cost').html(data)
   				top.$('#div-del-cost').dialog({ modal: true, width: 350, height: 170, resizable: false,
               		 buttons:
				[
				{
				   text:dic("yes",lang),
                    click: function() {
                       // var id = $('#tabId1').val()
                      $.ajax({
		        url: "<?php echo $tpoint?>/main/Delete.php?table=fmlocations&id=" + idSelect + "&tpoint=<?php echo $tpoint?>",
		        context: document.body,
		        success: function (data) {
		            //document.getElementById('costtype').innerHTML = data;	
				//alert(dic('Reports.TheCost', lang) + ' "' + val + '" ' + dic('Reports.SuccDelCost', lang) + " !!!")
				
				 $.ajax({
                                url: "<?php echo $tpoint?>/main/CalculateLocations.php?l=" + lang + "&tpoint=<?php echo $tpoint?>",
                                context: document.body,
                                success: function (data) {
                                   $('#a-'+idSelect).remove();
					        	   $('#searchExe').val('');
					        	   $("#searchExe").attr('class', '');
					        	   $('#listExe').hide();
                                }
                            });
		        }
		    });
                            top.$( this ).dialog("destroy");
							}
				    },
					{
                    text:dic("no",lang),
                    click: function() {
					    top.$( this ).dialog("destroy");
				    }
					}
					],
		close: function (e) {
           		$(this).empty();
            		$(this).dialog('destroy');
       		}	
         }); 
    }
    });
	
}

  function changeDriver(){
	var driverID = $("#driver").children(":selected").attr("id");
	$.ajax({
        url: "<?php echo $tpoint?>/main/CalculatePay.php?driID=" + driverID + '' + '&tpoint=<?php echo $tpoint?>',
        context: document.body,
        success: function (data) {
            //document.getElementById('pay').innerHTML = data;
        }
    });
}
function selectComponent(_id) {
	//$("#components-").append(document.getElementById(_id));
}
    setDates2();
    top.HideWait();

function hideSearchComp() {
setTimeout(function(){$('#listComp').hide();}, 1000);
}

var selectedElement = -1;
var selectedComp = '';
function OnKeyPressSearchComp(_key){
				
		if(_key == 40 || _key == 38 || _key == 13)
		{
			if($('#listComp').children().length > 0)
			{
				if(_key == 40 && selectedElement < $('#listComp').children().length-1)
				{
					$('#listComp .list-item-select').removeClass('list-item-select');
					$($('#listComp').children()[selectedElement-1]).removeClass('div-select')
					$($('#listComp').children()[selectedElement+1]).addClass('div-select')
					$($($('#listComp').children()[selectedElement+1]).children()[0]).show();
					$('#listComp').children()[selectedElement+1].scrollIntoView(false);
					selectedElement=selectedElement+2;
				}
				if(_key == 38 && selectedElement > 0)
				{
					$('#listComp .list-item-select').removeClass('list-item-select');
					$($('#listComp').children()[selectedElement-1]).addClass('div-select')
					$($('#listComp').children()[selectedElement+1]).removeClass('div-select')
					$($($('#listComp').children()[selectedElement-1]).children()[0]).show();
					$('#listComp').children()[selectedElement-1].scrollIntoView(true);
					selectedElement=selectedElement-2;
				}
				if(_key == 13)
				{
					/*var _html = $($('#listComp .div-select')[0]).html();
					_html = _html.replace("<br>","&nbsp;&nbsp;")	
					_html = _html.replace('<b style="color: rgb(255, 0, 0);">','')
					_html = _html.replace('<b style="color: #FF0000">','')
					_html = _html.replace('</b>','')*/
					
					var compName = $($('#listComp .div-select')[0]).children()[0].innerHTML;
					compName = compName.replace('<b style="color: rgb(255, 0, 0);">','')
					compName = compName.replace('<b style="color: #FF0000">','')
					compName = compName.replace('</b>','')
					compName = compName.replace('<b style="color: #FF0000">','')
					compName = compName.replace('</b>','')
					var aId = $($('#listComp .div-select')[0]).attr("id");
					var _id = aId.split("a-")[1];
					
					var _html = '<span id="main-'+_id+'" class="corner5" style="color:#2F5185; display:inline-block; margin-bottom:5px; margin-left:5px; background-color:#F57A49">&nbsp&nbsp;' + compName + '&nbsp&nbsp;<img src ="<?php echo $tpoint?>/images/x-mark1.png" title="<?php echo dic_("Reports.DelListComp")?>" onclick="upComp(' + _id + ')" style="cursor:pointer; position:relative; top:1px"/>&nbsp&nbsp;</span>';
					selectedComp += _id + ',';
					$("#components-").append(_html);
					$('#a-'+_id).remove();	
					$('#listComp').hide();
					//var em = $($('#listComp .kiklop-list-item-select')[0]).attr("onclick");
					//em = em.substring(em.indexOf("(")+2, em.lastIndexOf(")")-1);
					//check = false;
					//AddAssignedUserFromSearch(em);
				}
			} else
			{
				//$('#txt_user_mail_id').val('');
				//var txt = $('#txt_user_mail').val();
				//$('#listComp').load('./ajax/taskassigned_search.php?q='+encodeURIComponent(txt));
			}
		} else
		{
			var txt = $('#searchComp').val()
			if(txt == '')
			{
				$.ajax({
			        url: "<?php echo $tpoint?>/main/SearchComponents.php?txt=" + txt + '&l=' + lang + '&selComp=' + selectedComp + '&tpoint=<?php echo $tpoint?>',
			        context: document.body,
			        success: function (data) {
			           $('#listComp').html(data)
			           $('#listComp').css({display:'block'});
			        }
			    });
			} else
			{
				$.ajax({
			        url: "<?php echo $tpoint?>/main/SearchComponents.php?txt=" + txt + '&l=' + lang + '&selComp=' + selectedComp + '&tpoint=<?php echo $tpoint?>',
			        context: document.body,
			        success: function (data) {
			           $('#listComp').html(data)
			           $('#listComp').css({display:'block'});
			        }
			    });
			}
			selectedElement = -1;
		}
		
	}
function OnCLickComp(_id) {
	
	selectedComp += _id + ',';
	//_id = 'a-' + _id;
	/*var _html = $($('#listComp .div-select')[0]).html();
	_html = _html.replace("<br>","&nbsp;&nbsp;")	
	_html = _html.replace('<b style="color: rgb(255, 0, 0);">','')
	_html = _html.replace('<b style="color: #FF0000">','')
	_html = _html.replace('</b>','')*/
	
	var compName = $($('#listComp .div-select')[0]).children()[0].innerHTML;
	compName = compName.replace(/<b style="color: rgb(255, 0, 0);">/g,'')
	compName = compName.replace(/<b style="color: #FF0000">/g,'')
	compName = compName.replace(/<\/b>/g,'')
	compName = compName.replace(/<b style="color: #FF0000">/g,'')
	compName = compName.replace(/<\/b>/g,'')
					
	var _html = '<span id="main-'+_id+'" class="corner5" style="color:#2F5185; display:inline-block; margin-bottom:5px; margin-left:5px; background-color:#F57A49">&nbsp&nbsp;' + compName + '&nbsp&nbsp;<img src ="<?php echo $tpoint?>/images/x-mark1.png" title="<?php echo dic_("Reports.DelListComp")?>" onclick="upComp(' + _id + ')" style="cursor:pointer; position:relative; top:1px"/>&nbsp&nbsp;</span>';
	$("#components-").append(_html);
	$('#a-'+_id).remove();	
	$('#listComp').hide();
	
}

function upComp(_idComp) {
	//debugger;
	$('#main-'+_idComp).remove()
	selectedComp = selectedComp.replace(_idComp + ',', '')
}
function overDiv(_id) {
	if ($('#x-' + _id))
		$('#x-' + _id).show()
	if ('#a-' + _id)	
		$('#a-' + _id).addClass('div-select')
}	
function outDiv(_id) {
	if ($('#x-' + _id))
		$('#x-' + _id).hide()
	if ('#a-' + _id)	
		$('#a-' + _id).removeClass('div-select')
}

function deleteComp(idComp) {
	document.getElementById('div-delComp').title = "<?php echo dic_("Reports.DelComp")?>"
	 $.ajax({
            url: "<?php echo $tpoint?>/main/DeleteComponentsForm.php?l=" + '<?php echo $cLang?>' + '&tpoint=<?php echo $tpoint?>' + '&compId=' + idComp, 
            context: document.body,
            success: function (data) {
           
               $('#div-delComp').html(data);
               $('#div-delComp').dialog({ modal: true, height: 180, width: 400,
               	zIndex: 10002 ,
                   buttons: [
                   {
                         text: '<?php echo dic_("Reports.Confirm")?>',
                         click: function () {
                         	$.ajax({
						        url: "<?php echo $tpoint?>/main/DeleteComponents.php?ids=" + idComp,
						        context: document.body,
						        success: function (data) {
						            $('#div-delComp').dialog("close");
						        }
						    });
                         }
                   },
                       {
                         text: dic("cancel"),
                         click: function () {
                         	$(this).dialog("close");
                         }
                       }
                   ]
                   
                   
               });
            }
        });
}
function hideSearchExe() {
setTimeout(function(){$('#listExe').hide();}, 1000);
}

var selectedElement1 = -1;
var selectedExe = '';
function OnKeyPressSearchExe(_key){
	if(_key == 40 || _key == 38 || _key == 13)
		{
			if($('#listExe').children().length > 0)
			{
				if(_key == 40 && selectedElement1 < $('#listExe').children().length-1)
				{
					$('#listExe .list-item-select').removeClass('list-item-select');
					$($('#listExe').children()[selectedElement1-1]).removeClass('div-select')
					$($('#listExe').children()[selectedElement1+1]).addClass('div-select')
					$($($('#listExe').children()[selectedElement1+1]).children()[0]).show();
					$('#listExe').children()[selectedElement1+1].scrollIntoView(false);
					selectedElement1=selectedElement1+2;
				}
				if(_key == 38 && selectedElement1 > 0)
				{
					$('#listExe .list-item-select').removeClass('list-item-select');
					$($('#listExe').children()[selectedElement1-1]).addClass('div-select')
					$($('#listExe').children()[selectedElement1+1]).removeClass('div-select')
					$($($('#listExe').children()[selectedElement1-1]).children()[0]).show();
					$('#listExe').children()[selectedElement1-1].scrollIntoView(true);
					selectedElement1=selectedElement1-2;
				}
				if(_key == 13)
				{
					var costName = $($('#listExe .div-select')[0]).children()[0].innerHTML;
					costName = costName.replace('<b style="color: rgb(255, 0, 0);">','')
					costName = costName.replace('<b style="color: #FF0000">','')
					costName = costName.replace('</b>','')
					costName = costName.replace('<b style="color: #FF0000">','')
					costName = costName.replace('</b>','')
					$('#searchExe').val(costName);
					$('#listExe').hide();
					
					var _id = ($($('#listExe .div-select')[0]).attr("id")).split("-");
					_CostId = _id[1];

					$("#searchExe").attr('class', '');
					$('#searchExe').addClass(_CostId);
				}
			} else
			{
			}
		} else
		{
			var txt = $('#searchExe').val()
			if(txt == '')
			{
				
				$.ajax({
			        url: "<?php echo $tpoint?>/main/SearchExe.php?txt=" + txt + '&l=' + lang + '&selCost=' + selectedCost + '&tpoint=<?php echo $tpoint?>',
			        context: document.body,
			        success: function (data) {
			           $('#listExe').html(data)
			           $('#listExe').css({display:'block'});
			        }
			    });
			} else
			{
				$.ajax({
			        url: "<?php echo $tpoint?>/main/SearchExe.php?txt=" + txt + '&l=' + lang + '&selCost=' + selectedCost + '&tpoint=<?php echo $tpoint?>',
			        context: document.body,
			        success: function (data) {
			           $('#listExe').html(data)
			           $('#listExe').css({display:'block'});
			        }
			    });
			}
			selectedElement1 = -1;
		}
} 

function OnCLickExe(_id) {
	var costName = $($('#listExe .div-select')[0]).children()[0].innerHTML;
	costName = costName.replace(/<b style="color: rgb(255, 0, 0);">/g,'')
	costName = costName.replace(/<b style="color: #FF0000">/g,'')
	costName = costName.replace(/<\/b>/g,'')
	costName = costName.replace(/<b style="color: #FF0000">/g,'')
	costName = costName.replace(/<\/b>/g,'')
	$('#searchExe').val(costName);
	$('#listExe').hide();
	var _id = ($($('#listExe .div-select')[0]).attr("id")).split("-");
	_CostId = _id[1];
	
	$("#searchExe").attr('class', '');
	$('#searchExe').addClass(_CostId);
}



function hideSearchDri() {
setTimeout(function(){$('#listDri').hide();}, 1000);
}

var selectedElement1 = -1;
var selectedExe = '';
function OnKeyPressSearchDri(_key){
	if(_key == 40 || _key == 38 || _key == 13)
		{
			if($('#listDri').children().length > 0)
			{
				if(_key == 40 && selectedElement1 < $('#listDri').children().length-1)
				{
					$('#listDri .list-item-select').removeClass('list-item-select');
					$($('#listDri').children()[selectedElement1-1]).removeClass('div-select')
					$($('#listDri').children()[selectedElement1+1]).addClass('div-select')
					$($($('#listDri').children()[selectedElement1+1]).children()[0]).show();
					$('#listDri').children()[selectedElement1+1].scrollIntoView(false);
					selectedElement1=selectedElement1+2;
				}
				if(_key == 38 && selectedElement1 > 0)
				{
					$('#listDri .list-item-select').removeClass('list-item-select');
					$($('#listDri').children()[selectedElement1-1]).addClass('div-select')
					$($('#listDri').children()[selectedElement1+1]).removeClass('div-select')
					$($($('#listDri').children()[selectedElement1-1]).children()[0]).show();
					$('#listDri').children()[selectedElement1-1].scrollIntoView(true);
					selectedElement1=selectedElement1-2;
				}
				if(_key == 13)
				{
					var costName = $($('#listDri .div-select')[0]).children()[0].innerHTML;
					costName = costName.replace('<b style="color: rgb(255, 0, 0);">','')
					costName = costName.replace('<b style="color: #FF0000">','')
					costName = costName.replace('</b>','')
					costName = costName.replace('<b style="color: #FF0000">','')
					costName = costName.replace('</b>','')
					$('#searchDri').val(costName);
					$('#listDri').hide();
					
					var _id = ($($('#listDri .div-select')[0]).attr("id")).split("-");
					_CostId = _id[1];

					$("#searchDri").attr('class', '');
					$('#searchDri').addClass(_CostId);
					
					 var driverID = $($('#searchDri')[0]).attr('class');
					$.ajax({
				        url: "<?php echo $tpoint?>/main/CalculatePay.php?driID=" + driverID + '' + '&tpoint=<?php echo $tpoint?>',
				        context: document.body,
				        success: function (data) {
				        	$('#searchPay').val('');
				           // document.getElementById('pay').innerHTML = data;
				        }
				    });
				}
			} else
			{
			}
		} else
		{
			var txt = $('#searchDri').val()
			if(txt == '')
			{
				$.ajax({
			        url: "<?php echo $tpoint?>/main/SearchDri.php?vehid="+<?php echo $vehID_?>+"&ifDriver="+<?php echo $ifDriver?>+"&txt=" + txt + '&l=' + lang + '&selCost=' + selectedCost + '&tpoint=<?php echo $tpoint?>',
			        context: document.body,
			        success: function (data) {
			           $('#listDri').html(data)
			           $('#listDri').css({display:'block'});
			           
			            var driverID = $($('#searchDri')[0]).attr('class');
						$.ajax({
					        url: "<?php echo $tpoint?>/main/CalculatePay.php?driID=" + driverID + '' + '&tpoint=<?php echo $tpoint?>',
					        context: document.body,
					        success: function (data) {
					        	$('#searchPay').val('');
					           // document.getElementById('pay').innerHTML = data;
					        }
					    });
			        }
			    });
			} else
			{
				$.ajax({
			        url: "<?php echo $tpoint?>/main/SearchDri.php?vehid="+<?php echo $vehID_?>+"&ifDriver="+<?php echo $ifDriver?>+"&txt=" + txt + '&l=' + lang + '&selCost=' + selectedCost + '&tpoint=<?php echo $tpoint?>',
			        context: document.body,
			        success: function (data) {
			           $('#listDri').html(data)
			           $('#listDri').css({display:'block'});
			           
			            var driverID = $($('#searchDri')[0]).attr('class');
						$.ajax({
					        url: "<?php echo $tpoint?>/main/CalculatePay.php?driID=" + driverID + '' + '&tpoint=<?php echo $tpoint?>',
					        context: document.body,
					        success: function (data) {
					        	$('#searchPay').val('');
					            //document.getElementById('pay').innerHTML = data;
					        }
					    });
			        }
			    });
			}
			selectedElement1 = -1;
		}
} 

function OnCLickDri(_id) {
	var costName = $($('#listDri .div-select')[0]).children()[0].innerHTML;
	costName = costName.replace(/<b style="color: rgb(255, 0, 0);">/g,'')
	costName = costName.replace(/<b style="color: #FF0000">/g,'')
	costName = costName.replace(/<\/b>/g,'')
	costName = costName.replace(/<b style="color: #FF0000">/g,'')
	costName = costName.replace(/<\/b>/g,'')
	$('#searchDri').val(costName);
	$('#listDri').hide();
	
	var _id = ($($('#listDri .div-select')[0]).attr("id")).split("-");
	_CostId = _id[1];
	
	$("#searchDri").attr('class', '');
	$('#searchDri').addClass(_CostId);
	
	var driverID = $($('#searchDri')[0]).attr('class');
	$.ajax({
        url: "<?php echo $tpoint?>/main/CalculatePay.php?driID=" + driverID + '' + '&tpoint=<?php echo $tpoint?>',
        context: document.body,
        success: function (data) {
            //document.getElementById('pay').innerHTML = data;
            $('#searchPay').val('');
        }
    });
}


function hideSearchPay() {
setTimeout(function(){$('#listPay').hide();}, 1000);
}

var selectedElement2 = -1;
var selectedPay = '';
function OnKeyPressSearchPay(_key){
	if(_key == 40 || _key == 38 || _key == 13)
		{
			if($('#listPay').children().length > 0)
			{
				if(_key == 40 && selectedElement2 < $('#listPay').children().length-1)
				{
					$('#listPay .list-item-select').removeClass('list-item-select');
					$($('#listPay').children()[selectedElement2-1]).removeClass('div-select')
					$($('#listPay').children()[selectedElement2+1]).addClass('div-select')
					$($($('#listPay').children()[selectedElement2+1]).children()[0]).show();
					$('#listPay').children()[selectedElement2+1].scrollIntoView(false);
					selectedElement2=selectedElement2+2;
				}
				if(_key == 38 && selectedElement2 > 0)
				{
					$('#listPay .list-item-select').removeClass('list-item-select');
					$($('#listPay').children()[selectedElement2-1]).addClass('div-select')
					$($('#listPay').children()[selectedElement2+1]).removeClass('div-select')
					$($($('#listPay').children()[selectedElement2-1]).children()[0]).show();
					$('#listPay').children()[selectedElement2-1].scrollIntoView(true);
					selectedElement2=selectedElement2-2;
				}
				if(_key == 13)
				{
					var costName = $($('#listPay .div-select')[0]).children()[0].innerHTML;
					costName = costName.replace('<b style="color: rgb(255, 0, 0);">','')
					costName = costName.replace('<b style="color: #FF0000">','')
					costName = costName.replace('</b>','')
					costName = costName.replace('<b style="color: #FF0000">','')
					costName = costName.replace('</b>','')
					$('#searchPay').val(costName);
					$('#listPay').hide();
					
					var _id = ($($('#listPay .div-select')[0]).attr("id")).split("-");
					_CostId = "k-" + _id[1];
					if (_id[1] == "x0") _CostId = "g";
					if (_id[1] == "x1") _CostId = "f";

					$("#searchPay").attr('class', '');
					$('#searchPay').addClass(_CostId);
				}
			} else
			{
			}
		} else
		{
			var txt = $('#searchPay').val()
			var driverID = $($('#searchDri')[0]).attr('class');
			if(txt == '')
			{
				$.ajax({
			        url: "<?php echo $tpoint?>/main/SearchPay.php?vehid="+<?php echo $vehID_?>+"&driId="+driverID+"&txt=" + txt + '&l=' + lang + '&selCost=' + selectedCost + '&tpoint=<?php echo $tpoint?>',
			        context: document.body,
			        success: function (data) {
			           $('#listPay').html(data)
			           $('#listPay').css({display:'block'});
			        }
			    });
			} else
			{
				$.ajax({
			        url: "<?php echo $tpoint?>/main/SearchPay.php?vehid="+<?php echo $vehID_?>+"&driId="+driverID+"&txt=" + txt + '&l=' + lang + '&selCost=' + selectedCost + '&tpoint=<?php echo $tpoint?>',
			        context: document.body,
			        success: function (data) {
			           $('#listPay').html(data)
			           $('#listPay').css({display:'block'});
			        }
			    });
			}
			selectedElement1 = -1;
		}
} 

function OnCLickPay(_id) {
	var costName = $($('#listPay .div-select')[0]).children()[0].innerHTML;
	costName = costName.replace(/<b style="color: rgb(255, 0, 0);">/g,'')
	costName = costName.replace(/<b style="color: #FF0000">/g,'')
	costName = costName.replace(/<\/b>/g,'')
	costName = costName.replace(/<b style="color: #FF0000">/g,'')
	costName = costName.replace(/<\/b>/g,'')
	$('#searchPay').val(costName);
	$('#listPay').hide();
	
	var _id = ($($('#listPay .div-select')[0]).attr("id")).split("-");
	_CostId = "k-" + _id[1];
	if (_id[1] == "x0") _CostId = "g";
	if (_id[1] == "x1") _CostId = "f";
	$("#searchPay").attr('class', '');
	$('#searchPay').addClass(_CostId);
}
</script>


</html>
