<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php
		
    opendb();
	if (is_numeric(session('user_id')))
		echo dlookup("select count(*) from messages where clientid=" . session("client_id") . " and checked='0' and toid=" . session("user_id"));
	else
		echo 0;
    closedb();

    exit();
    
?>
