<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?
       
    $kod = getQUERY('kod');
    $orgUnit = getQUERY('orgUnit');
    $desc = getQUERY('desc');
   
    opendb();
   
    //insert na nova o.e. vo baza, vo tabelata organisation
    RunSQL("INSERT INTO organisation (clientID, code, name, description) VALUES (" . Session("client_id") . ", '" . $kod . "', '" . $orgUnit . "', '" . $desc . "')");
    
	closedb();
	
?>