<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	opendb();

	$id = str_replace("'", "''", NNull($_GET['id1'], ''));
	$name = str_replace("'", "''", NNull($_GET['GroupName'], ''));
	$color = str_replace("'", "''", NNull($_GET['ColorName'], ''));
	$image = str_replace("'", "''", NNull($_GET['image'], '0'));

	echo "update pointsofinterestgroups set fillcolor = '" . $color . "', name ='" . $name . "', strokecolor = '#000000', image = ".(int)$image." where id = '" . $id . "' and clientid =" . Session("client_id");

	RunSQL("update pointsofinterestgroups set fillcolor = '" . $color . "', name ='" . $name . "', strokecolor = '#000000', image = ".(int)$image." where id = '" . $id . "' and clientid =" . Session("client_id"));
	closedb();
?>
