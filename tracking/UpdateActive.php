<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
    
	opendb();
	
	$id = getQUERY("id");
	$active = getQUERY("a");
	$load = getQUERY("load");
	if($load.'' == '1')
	{
		$veh = dlookup("select '(' || code || ')  - ' || registration from vehicles where id=" . $id);
		if($active.'' == '1')
			addlog(48, $veh);
		else
			addlog(49, $veh);
	}
	RunSQL("update vehicles set visible='" . $active . "' where id=" . $id);
	print "Ok";
	closedb();
?>