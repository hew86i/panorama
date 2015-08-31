<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary.php" ?>
<?php session_start()?>
<?php
    
    set_time_limit(0);
	opendb();
	$ret = RunSQL("insert into ClientAreas(Name, ClientID, ColorBackground, ColorBorder, Active, GroupID, Available, CanChange, UserID) Values(N'sdafsd', '154', '', '', 1, 115, 2, 1, 227)");
	
	$ID = dlookup("select top 1 ID from ClientAreas order by ID desc");

    echo $ID;
	closedb();
	exit;
	
?>
