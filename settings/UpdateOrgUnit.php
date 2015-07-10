<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php
    
    $id = getQUERY('id');
    $code = getQUERY('code');
    $name = getQUERY('name');
    $desc = getQUERY('desc');
    
	opendb();
    RunSQL("UPDATE organisation set code='" . $code . "', Name='" . $name . "', Description='" . $desc . "' where id=" . $id);
    closedb(); 
	  
?>