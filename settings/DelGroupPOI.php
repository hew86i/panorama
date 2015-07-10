<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>


<?php
	opendb();
	
	$groupid = str_replace("'", "''", NNull($_GET['groupid'], ''));
	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	
	$cntRows = dlookup("select count(*) from pointsofinterest where groupid=" . $id." and clientid = " . Session("client_id"));
	
	if($id==$groupid)
	{
		echo 1;
	}
	else
	{
			
		if($cntRows>0)
		{
			RunSQL("Delete from pointsofinterestgroups where id = " . $id . " and clientid =" . Session("client_id"));
			RunSQL("update pointsofinterest set groupid=" . $groupid . " where groupid= " . $id . " and clientid =" . Session("client_id"));
		}
		if($cntRows==0)
		{
			RunSQL("Delete from pointsofinterestgroups where id = " . $id . " and clientid =" . Session("client_id"));
		}
		
	}
	closedb();

?>