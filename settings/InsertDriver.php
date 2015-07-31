<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php
    opendb();
    
    $zaIdto = dlookup("select Max(id)+1 from drivers");
    
    $name = getQUERY("name");
    $code = getQUERY("code");
    $orgUnit = getQUERY("orgUnit");
    
	$dUsername = getQUERY("dUsername");
	$dPassword = getQUERY("dPassword");
    $db = DateTimeFormat(getQUERY("dateBorn"), 'Y-m-d');
    $dlnumber = getQUERY("dlnumber");

    $gender = getQUERY("gender");
    $rfId = getQUERY("rfId");
    
    $sc = DateTimeFormat(getQUERY("startCom"), 'Y-m-d');
    
    $durContract = getQUERY("durContract");
    
    $fl = DateTimeFormat(getQUERY("firstLicence"), 'Y-m-d');
       
    $le = getQUERY("licenceExpire");
 
    $interLicence = getQUERY("interLicence");
    
    $ie = DateTimeFormat(getQUERY("IntLicExp"), 'Y-m-d');
   
    $licCategories = getQUERY("categories");
   
   
    $CheckCode=dlookup("SELECT count(*) FROM drivers WHERE code = '".$code."' and clientid = " . Session("client_id"));
   
   	if($CheckCode > 0)
		{
			echo "existcode";
			exit();
		}
	else
		{

    $vnesi = runSQL("INSERT INTO drivers (id, clientid, fullname, organisationid, code, borndate, gender, startincompany, jobcontract, 
    rfid, licensetype, firstlicense, licenseexp, interlicense, interlicenseexp, dlnumber) 
    VALUES ('" . $zaIdto . "', " . Session("client_id") . ", '" . $name . "', " . intval($orgUnit) . ", '" . $code . "', '" . DateTimeFormat($db, "Y-m-d") . "', 
    '" . $gender . "', '" . DateTimeFormat($sc, "Y-m-d") . "', " . $durContract . ", '" . $rfId . "', '" . $licCategories . "', 
    '" . DateTimeFormat($fl, "Y-m-d") . "', '" . DateTimeFormat($le, "Y-m-d") . "', '" . $interLicence . "', '" . DateTimeFormat($ie, "Y-m-d") . "', '".$dlnumber."')");

if (dlookup("select count(*) from clients where allowdriverasuser='1' and id=".Session("client_id")) > 0)
	runSQL("insert into driverasuser(clientid, driverid, username, password) values (" . session("client_id") . ", " . $zaIdto . ", '" . $dUsername . "', '" . $dPassword . "')");
		}
	closedb();
	
?>