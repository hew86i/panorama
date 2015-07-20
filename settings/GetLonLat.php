<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php

	error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

	opendb();

	$id = (int)NNull($_GET['id'], 0);

	$type = (int)dlookup("select type from pointsofinterest where id=" . $id);

	if($type == 1)
	{
		$lat = dlookup("select st_y(st_transform(geom,4326)) lat from pointsofinterest where id=" . $id);
		$lon = dlookup("select st_x(st_transform(geom,4326)) lon from pointsofinterest where id=" . $id);
	}
	else
	{
		$lon = dlookup("select st_y(st_centroid(geom)) lon from pointsofinterest where id=" . $id);
		$lat = dlookup("select st_x(st_centroid(geom)) lat from pointsofinterest where id=" . $id);
	}

	echo $lon . '@' . $lat;

	closedb();

 ?>

