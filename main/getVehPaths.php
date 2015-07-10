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
    
	if (!is_numeric(session('user_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
	if (!is_numeric(session('client_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
    
    $_id = str_replace("'", "''", NNull($_GET['id'], ''));
	
    $str2 = "";
    if($_id != "All")
        $str2 = " AND ca.groupid in (" . $_id . ")";
	
	$str3 = "";
	if (session("role_id")."" != "2")
		$str3 = " and (ca.userid in (select id from users where organisationid in (select organisationid from users where id=" . session("user_id") . ")) or ca.userid=" . session("user_id") . " or ca.available = 3)";
    
    $dsv = query("select ca.id, ca.active, ppg.fillcolor color from pointsofinterest ca left outer join pointsofinterestgroups ppg on ca.groupid=ppg.id where ca.active='1' and (ca.type=2) and ca.clientid=" . session("client_id") ." " . $str2 . " " . $str3);
    
    $str = "";
    while($row = pg_fetch_array($dsv))
	{
        $str .= "@" . $row["id"] . "|" . $row["color"];
    }
    if($str == "")
        $str = "#^*";

	echo $str;
    //print base64_encode(gzencode($str));
	closedb();
?>
