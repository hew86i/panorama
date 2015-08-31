<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
	
	$_lon1 = getQUERY("lon1");
	$_lat1 = getQUERY("lat1");
	$_lon2 = getQUERY("lon2");
	$_lat2 = getQUERY("lat2");
    opendb();
	
	$cntItem = dlookup("select count(*) from line_history_fast where lon1='".$_lon1."' and lat1='" . $_lat1 . "' and lon2='" . $_lon2 . "' and lat2='" . $_lat2 . "'");
	if($cntItem > 0)
	{
		$dsLine = query("select id, linestr from line_history_fast where lon1='".$_lon1."' and lat1='" . $_lat1 . "' and lon2='" . $_lon2 . "' and lat2='" . $_lat2 . "'");
		print pg_fetch_result($dsLine, 0, "linestr") . '^$' . pg_fetch_result($dsLine, 0, "id");
	} else
	{
		$line = getLineCoordsF($_lon1, $_lat1, $_lon2, $_lat2);
		$_id = dlookup("insert into line_history_fast (lon1, lat1, lon2, lat2, linestr) values ('".$_lon1."','".$_lat1."','".$_lon2."','".$_lat2."','".$line."') RETURNING id;");
		print $line . '^$' . $_id;
	}
	
	closedb();
    
?>
