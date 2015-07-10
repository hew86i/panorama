<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
    $id = str_replace("'", "''", NNull($_GET['id'], ''));
    opendb();
	$dsedit = query("select * from pointsofinterestgroups where clientid = " . Session("client_id"). " and id = ".$id."");
	print pg_fetch_result($dsedit,0,"name") . "$$" . pg_fetch_result($dsedit,0,"fillcolor");
	closedb();
?>
