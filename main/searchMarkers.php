<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
    header("Expires: Mon, 20 Jul 2000 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", FALSE);
    header("Pragma: no-cache");
	set_time_limit(0);
	
	opendb();
	
	$name = str_replace("'", "''", NNull($_GET['name'], ''));
	
	$str2 = " lower(pp.name) LIKE lower('%".$name."%')";
	
	$str1123 = "";
	$str1123 = "select st_y(ST_transform(pp.geom, 4326)) latitude, coalesce(pp.userid, 329) userid, st_x(ST_Transform(pp.geom, 4326)) longitude, pp.name, coalesce(pp.available, 1) available,";
	$str1123 .= " pp.groupid, pp.id, coalesce(ppg.fillcolor, '000000') color, ppg.name groupname, '1' image, pp.radius, pp.active ";
	$str1123 .= " from pointsofinterest pp left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id";
	$str1123 .= " where " . $str2 . " and pp.active='1' and pp.type=1 and pp.clientid=" . session("client_id") . " ORDER BY pp.id DESC";
	//echo $str1123;
	//echo "<br /><br /><br />";
	//echo "select ca.id, ppg.fillcolor color from pointsofinterest ca left outer join pointsofinterestgroups ppg on ca.groupid=ppg.id where ca.type=2 and ca.clientid=" . session("client_id") . " and lower(ca.name) LIKE lower('%".$name."%')";
	//exit;
	$ds123 = query($str1123);
	
	$str = "";
	$_canch = "";
	
	while($row = pg_fetch_array($ds123))
	{
		$_canch = "1";
		$str .= "#" . str_replace(",", ".", $row["longitude"]."") . "|" . str_replace(",", ".", $row["latitude"]."") . "|" . str_replace("|", "", str_replace("#", "", $row["name"])) . "|" . $row["available"] . "|" . $row["groupid"] . "|" . $row["id"] . "|" . "" . "|" . str_replace("|", "", str_replace("#", "", $row["color"])) . "|" . str_replace("|", "", str_replace("#", "", $row["groupname"])) . "|" . $row["image"] . "|" . $_canch . "|" . "" . "|" . str_replace("|", "", str_replace("#", "", $row["radius"]));
 	}

	$str1123 = "";
	$str1123 = "select coalesce(pp.userid, 329) userid, pp.name, coalesce(pp.available, 1) available,";
	$str1123 .= " pp.groupid, pp.id, coalesce(ppg.fillcolor, '000000') color, ppg.name groupname, '1' image, pp.radius, pp.active ";
	$str1123 .= " from pointsofinterest pp left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id";
	$str1123 .= " where " . $str2 . " and pp.active='1'  and pp.type=2 and pp.clientid=" . session("client_id") . " ORDER BY pp.id DESC";

	$dsv = query($str1123);
	$str .= "$$";
	while($row = pg_fetch_array($dsv))
	{
		$_canch = "1";
		$str .= "#" . "|" . str_replace("|", "", str_replace("#", "", $row["name"])) . "|" . $row["available"] . "|" . $row["groupid"] . "|" . $row["id"] . "|" . "" . "|" . str_replace("|", "", str_replace("#", "", $row["color"])) . "|" . str_replace("|", "", str_replace("#", "", $row["groupname"])) . "|" . $row["image"] . "|" . $_canch . "|" . "" . "|" . str_replace("|", "", str_replace("#", "", $row["radius"]));
	}
	
	$str1123 = "";
	$str1123 = "select coalesce(pp.userid, 329) userid, pp.name, coalesce(pp.available, 1) available,";
	$str1123 .= " pp.groupid, pp.id, coalesce(ppg.fillcolor, '000000') color, ppg.name groupname, '1' image, pp.radius, pp.active ";
	$str1123 .= " from pointsofinterest pp left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id";
	$str1123 .= " where " . $str2 . " and pp.active='1'  and pp.type=3 and pp.clientid=" . session("client_id") . " ORDER BY pp.id DESC";

	$dsv = query($str1123);
	$str .= "$$";
	while($row = pg_fetch_array($dsv))
	{
		$_canch = "1";
		$str .= "#" . "|" . str_replace("|", "", str_replace("#", "", $row["name"])) . "|" . $row["available"] . "|" . $row["groupid"] . "|" . $row["id"] . "|" . "" . "|" . str_replace("|", "", str_replace("#", "", $row["color"])) . "|" . str_replace("|", "", str_replace("#", "", $row["groupname"])) . "|" . $row["image"] . "|" . $_canch . "|" . "" . "|" . str_replace("|", "", str_replace("#", "", $row["radius"]));
	}

	if($str == "$$")
	    $str = "**";
	echo $str;
    //print base64_encode(gzencode($str));
	closedb();
?>