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
    $name = getQUERY("name");
    $code = getQUERY("code");
    $orgUnit = getQUERY("orgUnit");
    
    $bd = DateTimeFormat(getQUERY("bornDate"), 'Y-m-d'); //born date
    
    $gender = getQUERY("gender");
    $rfId = getQUERY("rfId");
    
    $contract = getQUERY("contract");
    If (is_numeric($contract) == false) {
        $contract = 0;
    }
    
    $sc = DateTimeFormat(getQUERY("startCom"), 'Y-m-d'); //start date in company
    
    $categories = getQUERY("categories");
    
    $fl = DateTimeFormat(getQUERY("firstLic"), 'Y-m-d'); //first license
    
    $le = DateTimeFormat(getQUERY("licExp"), 'Y-m-d'); //license expire
       
    $interLic = getQUERY("interLic");
    $ie = DateTimeFormat(getQUERY("IntLicExp"), 'Y-m-d'); //international license expire
   
	opendb();
    $removed = getQUERY("removed");
    If ($removed <> "") {
        $remArr = explode(";", $removed);
		for ($i = 0; $i < count($remArr)-1; $i ++) {
			RunSQL("delete from vehicledriver where id=" . $remArr[$i]);
		}
    }
    
    
    $CheckCode=dlookup("SELECT count(*) FROM drivers WHERE code = '" . $code. "' and clientid = " . Session("client_id")." and code not in (select code from drivers where id=" . $id . ")");
   
   	if($CheckCode > 0)
		{
			echo 1;
			exit();
		}
	else
		{
   	      
    RunSQL("UPDATE drivers set fullname='" . $name . "', code='" . $code . "', borndate='" . $bd . "', 
    gender='" . $gender . "', startincompany='" . $sc . "', jobcontract=" . $contract . ", 
    rfid= '" . $rfId . "', licensetype='" . $categories . "', firstlicense='" . $fl . "', 
    licenseexp= '" . $le . "', interlicense=B'" . $interLic . "', interlicenseexp='" . $ie . "', 
    organisationid = " . $orgUnit . " where id=" . $id);
		}
	closedb();
?>