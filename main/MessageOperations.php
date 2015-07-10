<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php
	opendb();
	
	$action = nnull(getQUERY("action"), "");
	if($action == 'delete')
	{
		
	}
	
	if($action == 'read')
	{
	
	}
	
    closedb();

    exit();
    
?>