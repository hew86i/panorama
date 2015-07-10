<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
	
	$name = str_replace("'", "''", NNull($_GET['name'], ''));
	$color = str_replace("'", "''", NNull($_GET['color'], ''));
	
	opendb();
	$posledno = dlookup("select Max(id)+1 from pointsofinterestgroups");	
    $vnes = query("insert into pointsofinterestgroups(id,clientid,name,fillcolor,strokecolor) values('" . $posledno . "'," . Session("client_id") . ",'" . $name . "','#" . $color . "','#000000'); ");
	closedb();
?>