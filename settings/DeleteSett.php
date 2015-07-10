<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php 
       
    $table = getQUERY("table");
    $id = getQUERY("id");
	
    opendb();

    RunSQL("delete from " . $table . " where id = " . $id);
    if ($table == 'fmCosts')
	RunSQL("delete from newcosts where costtypeid = " . $id);

    closedb();
?>
