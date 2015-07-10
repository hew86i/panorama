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
      $cost = getQUERY("cost");
	
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
      	<select id="location" style="float:left; margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" >
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
           </select>
           &nbsp;&nbsp;<button id="addLoc" onClick="addLoc()" style="width:30px; height:27px;margin-top:5px" title="<?php echo dic_("Reports.AddNewExecutor")?>"></button>
      <button id="delLoc" onClick="delExecutor('location')" style="width:30px; height:27px;margin-top:5px" title="Remove executor"></button> 
</td>
     
</tr>


 <?php 
//if ($ifDriver > 0) {
?>
  <tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.Employee")?>:</td>
      <td style="padding-left:0px">
             <select id="driver" onchange="changeDriver()" style="margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" onchange="changeDriver()">
                <?php
                if ($ifDriver > 0) {
                    $drivers = "select fullname, id from drivers where id in (select driverid from vehicledriver where vehicleid=" . $vehID_ . ")";
				} else {
					$drivers = "select fullname, id from drivers where clientid=" . session("client_id");
				}
				
                    $dsDrivers = query($drivers);
					$firstDriver = pg_fetch_result($dsDrivers, 0, "id");
					
					while ($drDrivers = pg_fetch_array($dsDrivers)) {   
                     ?>
                       <option id="<?php echo $drDrivers["id"] ?>" value="<?php echo $drDrivers["id"] ?>"><?php echo $drDrivers["fullname"] ?></option>
                     <?php
                   } //end while
                                 
                  
              ?>   
           </select>
      </td>

  </tr>
<?php
//}
?>

 <tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.TermsPayment")?>:</td>
      <td style="padding-left:0px">
           <select id="pay" style="margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2">
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
						<option value="k-<?php echo $drCards["cardid"]?>" ><?php echo $nameCard?></option>
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
                
           </select>
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
       
      
       
       
       <div style="border:1px solid #CCCCCC; width:180px; margin-top:5px; float:left;height: 50px; overflow-y: auto;" class="corner5">
       	<ul id="components" style="width:155px; margin-top:18px">
       		<?php
       		$dsComp = query("select * from fmcomponents where clientid= " . session("client_id"));
			while ($drComp = pg_fetch_array($dsComp)) {
       		?>
       		<li id="li-<?php echo $drComp["id"]?>" style="float:left; height:15px;  cursor:pointer; background-color:#D5DFF0; margin:2px; padding-left: 6px; padding-right: 6px" class="corner8" onmouseover="over1(<?php echo $drComp["id"]?>)" onmouseout="out1(<?php echo $drComp["id"]?>)" onclick="clickplus(<?php echo $drComp["id"]?>)"><div ><strong><span id="span-<?php echo $drComp["id"]?>"></span></strong> <?php echo $drComp["componentname"]?></div></li>
			<?php
			}
			?>
       	</ul>
       </div>
       
       &nbsp;&nbsp;<button id="addComp" onClick="addComp()" style="margin-top:5px; width:30px; height:27px;vertical-align:top" title="<?php echo dic_("Reports.AddNewComponent")?>"></button>
      </td>
  </tr>
  
  <tr>
  	<td></td>
  	<td style="padding-left:0px">
  		 <div id="div-addcomp" style="border:1px solid #CCCCCC; margin-top:5px; width:180px;height: 70px; float:left; overflow-y: auto" class="corner5">
  			<ul id="components-" style="margin-top:18px">
       		
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
      	<select id="location" style="float:left; margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" >
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
           </select>
           &nbsp;&nbsp;<button id="addLoc" onClick="addLoc()" style="width:30px; height:27px;margin-top:5px" title="<?php echo dic_("Reports.AddNewExecutor")?>"></button>
     <button id="delLoc" onClick="delExecutor('location')" style="width:30px; height:27px;margin-top:5px" title="Remove executor"></button> 
 </td>
     
</tr>

<?php
	//if ($ifDriver > 0) {
?>
  <tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.Employee")?>:</td>
      <td style="padding-left:0px">
             <select id="driver" onchange="changeDriver()" style="margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" onchange="changeDriver()">
                <?php
                if ($ifDriver > 0) {
                    $drivers = "select fullname, id from drivers where id in (select driverid from vehicledriver where vehicleid=" . $vehID_ . ")";
				} else {
					$drivers = "select fullname, id from drivers where clientid=" . session("client_id");
				}
                    
                    $dsDrivers = query($drivers);
					$firstDriver = pg_fetch_result($dsDrivers, 0, "id");
					
					while ($drDrivers = pg_fetch_array($dsDrivers)) {   
                     ?>
                       <option id="<?php echo $drDrivers["id"] ?>" value="<?php echo $drDrivers["id"] ?>"><?php echo $drDrivers["fullname"] ?></option>
                     <?php
                   } //end while
              ?>   
             </select>
      </td>
  </tr>
  <?php
	//}
  ?>
  
<tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.TermsPayment")?>:</td>
      <td style="padding-left:0px">
           <select id="pay" style="margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2">
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
                
           </select>
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
      
       <div style="border:1px solid #CCCCCC; width:180px; margin-top:5px; float:left;height: 50px; overflow-y: auto;" class="corner5">
       	<ul id="components" style="width:155px; margin-top:18px">
       		<?php
       		opendb();
       		$dsComp = query("select * from fmcomponents where clientid= " . session("client_id"));
			while ($drComp = pg_fetch_array($dsComp)) {
       		?>
       		<li id="li-<?php echo $drComp["id"]?>" style="float:left; height:15px;  cursor:pointer; background-color:#D5DFF0; margin:2px; padding-left: 6px; padding-right: 6px" class="corner8" onmouseover="over1(<?php echo $drComp["id"]?>)" onmouseout="out1(<?php echo $drComp["id"]?>)" onclick="clickplus(<?php echo $drComp["id"]?>)"><div ><strong><span id="span-<?php echo $drComp["id"]?>"></span></strong> <?php echo $drComp["componentname"]?></div></li>
			<?php
			}
			?>
       	</ul>
       </div>
       
       &nbsp;&nbsp;<button id="addComp" onClick="addComp()" style="margin-top:5px; width:30px; height:27px;vertical-align:top" title="<?php echo dic_("Reports.AddNewComponent")?>"></button>
      </td>
  </tr>
  
  <tr>
  	<td></td>
  	<td style="padding-left:0px">
  		 <div id="div-addcomp" style="border:1px solid #CCCCCC; margin-top:5px; width:180px;height: 70px; float:left; overflow-y: auto" class="corner5">
  			<ul id="components-" style="margin-top:18px">
       		
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
      	<select id="location" style="float:left; margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" >
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
           </select>
           &nbsp;&nbsp;<button id="addLoc" onClick="addLoc()" style="width:30px; height:27px;margin-top:5px" title="<?php echo dic_("Reports.AddNewExecutor")?>"></button>
     <button id="delLoc" onClick="delExecutor('location')" style="width:30px; height:27px;margin-top:5px" title="Remove executor"></button> 
 </td>
     
</tr>

<?php
//if ($ifDriver > 0) {
?>
  <tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.Employee")?>:</td>
      <td style="padding-left:0px">
             <select id="driver" onchange="changeDriver()" style="margin-top:5px;width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" onchange="changeDriver()">
                <?php
                   if ($ifDriver > 0) {
	                    $drivers = "select fullname, id from drivers where id in (select driverid from vehicledriver where vehicleid=" . $vehID_ . ")";
					} else {
						$drivers = "select fullname, id from drivers where clientid=" . session("client_id");
					}
	                   
                    $dsDrivers = query($drivers);
					$firstDriver = pg_fetch_result($dsDrivers, 0, "id");
					
					while ($drDrivers = pg_fetch_array($dsDrivers)) {   
                     ?>
                       <option id="<?php echo $drDrivers["id"] ?>" value="<?php echo $drDrivers["id"] ?>"><?php echo $drDrivers["fullname"] ?></option>
                     <?php
                   } //end while
                                 
                  
              ?>   
           </select>
      </td>
  </tr>
  <?php
 // }
  ?>
<tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.TermsPayment")?>:</td>
      <td style="padding-left:0px">
           <select id="pay" style="margin-top:5px;width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2">
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
                
           </select>
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
      <td width=240px style="padding-left:0px"><input id="datetime" type="text" class="textboxCalender2 text2" value="<?php echo $dt?>" onchange="changeKm(this.value)" /></td>
     
   
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
      	<select id="location" style="float:left; margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" >
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
           </select>
           &nbsp;&nbsp;<button id="addLoc" onClick="addLoc()" style="width:30px; height:27px;margin-top:5px" title="<?php echo dic_("Reports.AddNewExecutor")?>"></button>
<button id="delLoc" onClick="delExecutor('location')" style="width:30px; height:27px;margin-top:5px" title="Remove executor"></button>     
 </td>
     
</tr>

<?php
//if ($ifDriver > 0) {
?>
  <tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.Employee")?>:</td>
      <td style="padding-left:0px">
             <select id="driver" onchange="changeDriver()" style="margin-top:5px;width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" onchange="changeDriver()">
                <?php
                    if ($ifDriver > 0) {
	                    $drivers = "select fullname, id from drivers where id in (select driverid from vehicledriver where vehicleid=" . $vehID_ . ")";
					} else {
						$drivers = "select fullname, id from drivers where clientid=" . session("client_id");
					}
                   
                    $dsDrivers = query($drivers);
					$firstDriver = pg_fetch_result($dsDrivers, 0, "id");
					
					while ($drDrivers = pg_fetch_array($dsDrivers)) {   

                     ?>
                       <option id="<?php echo $drDrivers["id"] ?>" value="<?php echo $drDrivers["id"] ?>"><?php echo $drDrivers["fullname"] ?></option>
                     <?php
                   } //end while
                                 
                  
              ?>   
           </select>
      </td>
  </tr>
  <?php
  //}
  ?>
<tr >
      <td style="font-weight:bold;"><?php echo dic_("Reports.TermsPayment")?>:</td>
      <td style="padding-left:0px">
           <select id="pay" style="margin-top:5px;width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2">
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
                
           </select>
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
	
	document.getElementById('div-locMain').title = dic("Reports.AddNewExecutor")
	 $.ajax({
            url: "../main/AddLocation.php?l=" + lang,
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
	                   			$.ajax({
	                                url: "../main/InsertLocation.php?locname=" + locname + "&l=" + lang,
	                                context: document.body,
	                                success: function (data) {
	                                	if (data != 0) {
	                                	//mymsg("Успешно додадовте нов тип на трошок !!!")
	                                   $('#div-locMain').dialog("close");
	                                  
	                                    $.ajax({
			                                url: "../main/CalculateLocations.php?locname=" + locname + "&l=" + lang,
			                                context: document.body,
			                                success: function (data) {
			                                	if (document.getElementById('location'))
			                                    	document.getElementById('location').innerHTML = data;
			                                }
			                            });
	                            		} else {
	                            			alert(dic("Reports.AlreadyExecutor") + " '" + locname + "' !!!")
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
                         	 //$('#div-cost').parent().css('z-Index', 1002);
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
            url: "../main/AddComponent.php?l=" + '<?php echo $cLang?>',
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
                         		
                   			$.ajax({
                                url: "../main/InsertComponent.php?compname=" + compname,
                                context: document.body,
                                success: function (data) {
                                	if (data != 0) {
                                	//mymsg("Успешно додадовте нов тип на трошок !!!")
                                   //$(this).dialog("close");
                                   $('#div-compMain').dialog("close");
                                    $.ajax({
		                                url: "../main/CalculateComponents.php?compname=" + compname,
		                                context: document.body,
		                                success: function (data) {
		                                	//alert(data)
		                                    //document.getElementById('components').innerHTML += data;
		                                    	$("#components-").append(data);
		                                }
		                            });
                            		} else {
                            			alert(dic("Reports.AlreadyComponent") + " '" + compname + "' !!!");
                            		}
                                }
                            });
                         }
                   },
                       {
                         text: dic("cancel"),
                         click: function () {
                         	$(this).dialog("close");
                         	 //$('#div-cost').parent().css('z-Index', 1002);
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
		var charsAllowed="0123456789,";
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
            url: "../main/CalculateCurrKm.php?vehId=" + veh + "&dt=" + '' + dt + '',
            context: document.body,
            success: function (data) {
                document.getElementById('km').value = data;
            }
        });
		
		if ( document.getElementById('driver')) {
			$.ajax({
	            url: "../main/CalculateDrivers.php?vehId=" + veh + '',
	            context: document.body,
	            success: function (data) {
	                document.getElementById('driver').innerHTML = data;
	            }
	        });
		}
		
        
    }
    

    function delExecutor(idSelect) {
	
	alert("дали сте сигурни???? ако да - >")
	var id = $("#" + idSelect + " option:selected").attr("id");
		 $.ajax({
		        url: "../main/Delete.php?table=fmlocations&id=" + id,
		        context: document.body,
		        success: function (data) {
				 $.ajax({
                                url: "../main/CalculateLocations.php?locname=&l=" + lang,
                                context: document.body,
                                success: function (data) {
                                	if (document.getElementById('location'))
                                    	document.getElementById('location').innerHTML = data;
                                }
                            });
		        }
		    });
}

  function changeDriver(){
	var driverID = $("#driver").children(":selected").attr("id");
	$.ajax({
        url: "../main/CalculatePay.php?driID=" + driverID + '',
        context: document.body,
        success: function (data) {
            document.getElementById('pay').innerHTML = data;
        }
    });
}
    setDates2();
    top.HideWait();

</script>


</html>
