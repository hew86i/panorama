<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>


<?php

    $id = getQUERY("id");
    $reg = getQUERY("reg");
    $code = getQUERY("code");
    $orgUnit = nnull(getQUERY("orgUnit"), 0);
    $model = getQUERY("model");
	$AliasName = getQUERY("prekar");
	$fuelType = getQUERY("fuelType");
    $chassis = getQUERY("chassis");
    $motor = getQUERY("motor");
	$firstReg = DateTimeFormat(getQUERY("firstReg"), "Y-m-d");
    $lastReg = DateTimeFormat(getQUERY("lastReg"), "Y-m-d");
	$greenCard = getQUERY("greenCard");
	$activity = getQUERY("activity");
	$range = str_replace(",", ".", NNull($_GET['range'], ''));
	if ($range == "") $range = 0;
	
    $capacity = getQUERY("capacity");
    If (is_numeric($capacity) == false) {
        $capacity = 0;
    }

    $kmPerYear = getQUERY("kmPerYear");
    If (is_numeric($kmPerYear) == false) {
        $kmPerYear = 0;
    }
    
    $sprTires = getQUERY("sprTires");
    If (is_numeric($sprTires) == false) {
        $sprTires = 0;
    }
    
    $winTires = getQUERY("winTires");
    If (is_numeric($winTires) == false) {
        $winTires = 0;
    }
    
    $nextService = getQUERY("nextService");
    If (is_numeric($nextService) == false) {
        $nextService = 0;
	}
  	
	$nextServiceMonths = getQUERY("nextServiceMonths");
    If (is_numeric($nextServiceMonths) == false) {
        $nextServiceMonths = 0;
	}
	
    opendb();
    $removed = getQUERY("removed");
    If ($removed <> "") {
        $remArr = explode(";", $removed);
        $removedItem = "";     
		for ($i=0; $i < count($remArr) - 1; $i ++) {
            RunSQL("Delete from vehicledriver where id=" . $remArr[$i]);
       }
    }
      
    $CheckCode=dlookup("SELECT count(*) FROM vehicles WHERE code = '" . $code. "' and clientid = " . Session("client_id")." and code not in (select code from vehicles where id=" . $id . ")");
   
   	if($CheckCode > 0)
	{
			echo 1;
			exit();
	}
	else
	{
		$beforactive = dlookup("select visible from vehicles where id=" . $id);
		if($beforactive.'' != $activity.'')
		{
			$veh = '(' . $code . ')  - ' . trim($reg);
			if($activity.'' == '1')
				addlog(48, $veh);
			else
				addlog(49, $veh);
		}
   		RunSQL("UPDATE vehicles set registration='" . trim($reg) . "', code='" . $code . "', model='" . $model . "', chassisnumber= '" . $chassis . "', motornumber='" . $motor . "', fueltypeid=" . $fuelType . ", firstregistration= '" . $firstReg . "', lastregistration='" . $lastReg . "', kmperyear=" . $kmPerYear . ", organisationid =" . $orgUnit . ", fuelcapacity=" . $capacity . ", springtires= " . $sprTires . ", wintertires=" . $winTires . ", nextservice=" . $nextService . ", nextServiceMonths=" . $nextServiceMonths . ", greencard=B'" . $greenCard . "', alias = '".$AliasName."', visible = B'".$activity."'  where id=" . $id);
		$clienttypeid = dlookup("select clienttypeid from clients where id = (select clientid from vehicles where id = " . $id . ")");
		if($clienttypeid == 4)
		{
			$Checkrange=dlookup("select count(*) from vehiclerange where vehicleid=" . $id);
			if($Checkrange > 0)
			{
				RunSQL("UPDATE vehiclerange set range=".$range." where vehicleid=".$id);
			} else
			{
				RunSQL("insert into vehiclerange (vehicleid, range) values (".$id.", " . $range . ")");
			}
		}
	}
    closedb();  
?>
