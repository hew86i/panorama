<?php include "include/db.php" ?>
<?php include "include/functions.php" ?>
<?php include "include/params.php" ?>

<?php header("Content-type: text/html; charset=utf-8"); ?>

<?php
	opendb();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/settings.js"></script>
</head>
<body>

<?php

$base = "http://api.geonames.org/timezoneJSON?&username=hew86i&";
$getCitis = pg_fetch_all(query("select * from cities"));

foreach ($getCitis as $key => $city) {
	$id = $city["id"];
	$lat = $city["latitude"];
	$lng = $city["longitude"];
	$url = $base . "lat=" . $lat . "&lng=" . $lng;

	$jsondata = file_get_contents($url);
	$obj = json_decode($jsondata,true);
	RunSQL("UPDATE cities SET ctzone=". $obj['gmtOffset'] . " where id=" . $id);
	}
	echo "....done";
	closedb();
?>

</body>
</html>