<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	header("Content-type: text/html; charset=utf-8");
?>

<?php
    $id = getQUERY('id');
    $table = getQUERY('table');
    $item = str_replace("'", "''",getQUERY('item'));
    $range = getQUERY('range');
    $name = "name"; //name param of ItemCheck query

    if($table == "clubcards") { $name = 'cardname';}

	opendb();

	$ItemCheck = dlookup("SELECT count(*) FROM " . $table . " WHERE clientid = ".Session("client_id")." and " . $name . " = '" . $item. "' and " . $name . " not in (select " . $name . " from ". $table ." where id=" . $id . ")");

	// ima takov item vo baza
	if($ItemCheck > 0) {
		print 0;
		exit();
	// ako ne e za mehanizacija napravi update
	} elseif($range == "" || $table != "route_mechanisation") {
		$qR = "UPDATE " . $table . " SET ".$name."='" . $item . "' where id=" . $id;
		echo $qR;
		RunSQL($qR);
	// samo za mehanizacija
	} else {
		$qRM = "UPDATE " . $table . " SET ".$name."='" . $item . "', range=" . (int)$range . " where id=" . $id;
		echo $qRM;
	    RunSQL($qRM);
	}

	closedb();

?>