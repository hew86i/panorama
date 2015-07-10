<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
    
    header("Expires: Mon, 20 Jul 2000 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", FALSE);
    header("Pragma: no-cache");
	set_time_limit(0);
    $str1 = "";
    $str1 = "select id, name groupname, fillcolor color, '0' image from pointsofinterestgroups where clientid=" . session("client_id") . " or clientid=1 order by id asc";
    opendb();
    $ds = query($str1);
	$str = "";
	while ($row = pg_fetch_array($ds)){
        $str .= "#" . str_replace("|", "", str_replace("#", "", $row["groupname"])) . "|" . $row["id"] . "|" . str_replace("|", "", str_replace("#", "", $row["color"])) . "|" . $row["image"];
	}
	print $str;
	//print base64_encode(gzencode($str));
	closedb();
?>
