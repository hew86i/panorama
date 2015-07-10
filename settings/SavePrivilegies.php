<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php

	$userID = getQUERY("uid");
	$lista = getQUERY("lista");

	$lista1 = explode(",", $lista);
	$list1 = '';
	for ($i = 0; $i < sizeof($lista1); $i++) {
		$list1 = $list1 . "'1'";
		if($i < (sizeof($lista1)-1))
			$list1 = $list1 . ',';
	}

	opendb();
	RunSQL("delete from privilegessettings where userID = " . $userID);

	RunSQL("insert into privilegessettings (userid," . $lista . ") values (" . $userID . "," . $list1 . ")");
	print "Ok";
	closedb();
?>