<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php

	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	$workFrom = str_replace("'", "''", NNull($_GET['WorkTimeFrom'], ''));
	$workFrom4 = str_replace("'", "''", NNull($_GET['WorkTimeFrom4'], ''));
	$workTo = str_replace("'", "''", NNull($_GET['WorkTimeTo'], ''));
	$workTo4 = str_replace("'", "''", NNull($_GET['WorkTimeTo4'], ''));
	$workShift = str_replace("'", "''", NNull($_GET['WorkTimeShift'], ''));
	$workDay = str_replace("'", "''", NNull($_GET['WorkTimeType'], ''));
	
	opendb();
	
	$workCheck1=dlookup("SELECT count(*) FROM worktime WHERE daytype = ". $workDay ." and shift = '".$workShift."' and clientid = " . Session("client_id")."and id not in (select id from users where id=" . $id . ")");
	
	if($workCheck1>0)
	{
		echo 1;
	}
	else 
	{
		$updt = query("update worktime set shift = '" . $workShift . "', daytype='" . $workDay . "', timefrom='" . $workFrom . "".$workFrom4 ."',timeto='" . $workTo . "". $workTo4 ."' where id = " . $id . "  and clientid = " . Session("client_id"));
    }
    closedb();
?>


