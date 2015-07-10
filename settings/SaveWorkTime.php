<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
	opendb();
	$TIMEFROM = str_replace("'", "''", NNull($_GET['WorkTimeFrom'], ''));
	$TIMEFROM1 = str_replace("'", "''", NNull($_GET['WorkTimeFrom1'], ''));
	$TIMETO = str_replace("'", "''", NNull($_GET['WorkTimeTo'], ''));
	$TIMETO1 = str_replace("'", "''", NNull($_GET['WorkTimeTo1'], ''));
	$TIMESHIFT = str_replace("'", "''", NNull($_GET['WorkTimeShift'], ''));
	$TIMETYPE = str_replace("'", "''", NNull($_GET['WorkTimeType'], ''));
	$posledno = dlookup("select Max(id)+1 from worktime");
	
	
	if($TIMETYPE==9)
	{
	$workCheck1=dlookup("SELECT count(*) FROM worktime WHERE daytype = 6 and shift = '".$TIMESHIFT."' and clientid = " . Session("client_id"));
	$workCheck2=dlookup("SELECT count(*) FROM worktime WHERE daytype = 7 and shift = '".$TIMESHIFT."' and clientid = " . Session("client_id"));
		if($workCheck1 || $workCheck2 > 0)
		{
			echo 1;
			exit();
		}
		else 
		{
			$vnesi11 = query("INSERT into worktime(clientid,shift,daytype,timefrom,timeto) values (" . Session("client_id") . ",'" . $TIMESHIFT . "',6,'".$TIMEFROM."".$TIMEFROM1."' ,'" .$TIMETO. "" .$TIMETO1. "'); ");
			$vnesi22 = query("INSERT into worktime(clientid,shift,daytype,timefrom,timeto) values (" . Session("client_id") . ",'" . $TIMESHIFT . "',7,'".$TIMEFROM."".$TIMEFROM1."' ,'" .$TIMETO. "" .$TIMETO1. "'); ");
			exit();
		}
	}
	if($TIMETYPE==10)
	{
	$workCheck3=dlookup("SELECT count(*) FROM worktime WHERE daytype = 1 and shift = '".$TIMESHIFT."' and clientid = " . Session("client_id"));
	$workCheck4=dlookup("SELECT count(*) FROM worktime WHERE daytype = 2 and shift = '".$TIMESHIFT."' and clientid = " . Session("client_id"));
	$workCheck5=dlookup("SELECT count(*) FROM worktime WHERE daytype = 3 and shift = '".$TIMESHIFT."' and clientid = " . Session("client_id"));
	$workCheck6=dlookup("SELECT count(*) FROM worktime WHERE daytype = 4 and shift = '".$TIMESHIFT."' and clientid = " . Session("client_id"));
	$workCheck7=dlookup("SELECT count(*) FROM worktime WHERE daytype = 5 and shift = '".$TIMESHIFT."' and clientid = " . Session("client_id"));
		
		if($workCheck3 || $workCheck4 || $workCheck5 || $workCheck6 || $workCheck7 > 0)
		{
			echo 1;
		}
		else
		{
			$vnesi3 = query("INSERT into worktime(clientid,shift,daytype,timefrom,timeto) values (" . Session("client_id") . ",'" . $TIMESHIFT . "',1,'".$TIMEFROM."".$TIMEFROM1."' ,'" .$TIMETO. "" .$TIMETO1. "'); ");
			$vnesi4 = query("INSERT into worktime(clientid,shift,daytype,timefrom,timeto) values (" . Session("client_id") . ",'" . $TIMESHIFT . "',2,'".$TIMEFROM."".$TIMEFROM1."' ,'" .$TIMETO. "" .$TIMETO1. "'); ");
			$vnesi5 = query("INSERT into worktime(clientid,shift,daytype,timefrom,timeto) values (" . Session("client_id") . ",'" . $TIMESHIFT . "',3,'".$TIMEFROM."".$TIMEFROM1."' ,'" .$TIMETO. "" .$TIMETO1. "'); ");
			$vnesi6 = query("INSERT into worktime(clientid,shift,daytype,timefrom,timeto) values (" . Session("client_id") . ",'" . $TIMESHIFT . "',4,'".$TIMEFROM."".$TIMEFROM1."' ,'" .$TIMETO. "" .$TIMETO1. "'); ");
			$vnesi7 = query("INSERT into worktime(clientid,shift,daytype,timefrom,timeto) values (" . Session("client_id") . ",'" . $TIMESHIFT . "',5,'".$TIMEFROM."".$TIMEFROM1."' ,'" .$TIMETO. "" .$TIMETO1. "'); ");
			
		}
	}
	
	else
	{
	$workCheck8=dlookup("SELECT count(*) FROM worktime WHERE daytype = '".$TIMETYPE."' and shift = '".$TIMESHIFT."' and clientid = " . Session("client_id"));	
	if($workCheck8 > 0)
	{
		echo 1;
	}
	else{
			
		$vnesi = query("INSERT into worktime(clientid,shift,daytype,timefrom,timeto) values (" . Session("client_id") . ",'" . $TIMESHIFT . "','" .$TIMETYPE. "','".$TIMEFROM."".$TIMEFROM1."' ,'" .$TIMETO. "" .$TIMETO1. "'); ");
		echo 0;
	
	}
	}
	closedb();
?>