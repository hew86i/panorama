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
	// echo " - " . "SELECT count(*) FROM " . $table . " WHERE clientid = ".Session("client_id")." and " . $name . " = '" . $item ."'";
	$ItemCheck = dlookup("SELECT count(*) FROM " . $table . " WHERE clientid = ".Session("client_id")." and " . $name . " = '" . $item ."'");

	// ima takov item vo baza
	if($ItemCheck > 0) {
		print 0;
		exit();
	// ako ne e za mehanizacija napravi update
	} elseif($range == "" || $table != "route_mechanisation") {
		$qR = "INSERT INTO " . $table . " (id, ". $name .", clientid) values((select Max(id)+1 from " . $table."), '" . $item . "', '" . Session("client_id") . "')";
		echo $qR;
		RunSQL($qR);
		// $res = pg_fetch_assoc(Query("select * from " . $table . " where ".$name."='" . $item . "'"));

	// samo za mehanizacija
	} else {
		$qRM = "INSERT INTO " . $table . " (id, ". $name .", range, clientid) values((select Max(id)+1 from " . $table."), '" . $item . "','". $range ."', '" . Session("client_id") . "')";
		echo $qRM;
	    RunSQL($qRM);
	}

	closedb();

?>