<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
	opendb();
	$cul = getQUERY("cul");
	$oper = getQUERY("oper");
	$mat = getQUERY("mat");
	$mech = getQUERY("mech");
	$nalogid = getQUERY("nalogid");
	$nalogidpre = getQUERY("nalogidpre");
	$numCul = getQUERY("numCul");
	
	$sqlInsert = "insert into route_defculture (clientid, culid, operid, matid, mechid, headerid) 
	values (" .  session("client_id") . ", " . $cul . ", " . $oper . ", " . $mat . ", " . $mech . ", " . $nalogid . ") ";
	//runsql($sqlInsert);
	$insertID = dlookup($sqlInsert . " RETURNING id");
	
	//$insertID = dlookup("select id from route_defculture where clientid = " .  session("client_id") . " and culid = " . $cul . " and operid = " . $oper . " 
	//and matid = " . $mat . " and mechid = " . $mech . " order by id desc");
	
	$sqlUpdate = "update rnalogheder set culid = " . $insertID . " where id=" . $nalogid;
	//echo $sqlUpdate;
	runsql($sqlUpdate);
	
	$sqlPreUpdate = "update rnaloghederpre set culid = " . $insertID . " where id=" . $nalogidpre;
	runsql($sqlPreUpdate);
	closedb();
?>