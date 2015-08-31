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
	$numCul = getQUERY("numCul");
	
	$sqlUpdateC = "update route_defculture set culid=" . $cul . ", operid=" . $oper . ", matid=" . $mat . ", mechid=" . $mech ;
	$sqlUpdateC .= " where headerid=" . $nalogid;
	//echo $sqlUpdateC;
	//exit;
	$dsInsert = query($sqlUpdateC);
	
	closedb();
?>