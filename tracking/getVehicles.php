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
	
	$sqlV = "";
    if(session("role_id") == "2")
        $sqlV = "select id from vehicles where clientid=" . session("client_id");
	else
        $sqlV = "select vehicleid from uservehicles where userid=" . session("user_id") . "";

    $str1 = "";
    $str1 = "select registration, id, cast(code as integer) from vehicles where id in (" . $sqlV . ") order by code";
    opendb();
    $ds = query($str1);
	$str = "";
	$trace = dlookup("select trace from users where id=" . session("user_id"));
	while ($row = pg_fetch_array($ds)){
        $str .= "#" . str_replace("|", "", str_replace("#", "", $row["registration"])) . "|" . $row["id"] . "|" . str_replace("|", "", str_replace("#", "", $row["code"])) . "|" . $trace;
	}
	print $str;
	//print base64_encode(gzencode($str));
	closedb();
?>
