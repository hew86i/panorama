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
	opendb();

	if (!is_numeric(session('user_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
	if (!is_numeric(session('client_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
    
    $_id = str_replace("'", "''", NNull($_GET['id'], ''));
	
	if (session("role_id")."" == "2"){
		$str3 = "";
	} else {
		$str3 = " and (pp.userid in (select id from users where organisationid in (select organisationid from users where id=" . session("user_id") . ")) or pp.userid=" . session("user_id") . " or pp.available = 3)";
	}
	
    $str2 = "";
    if($_id != "All")
        $str2 = " and pp.groupid in (" . $_id . ")";
    
    //$str3 = " and (pp.userid in (select id from users where organisationid in (select organisationid from users where id=" . session("user_id") . ")) or pp.userid=" . session("user_id") . " or pp.available = 3)";
    /*$str1 = "";
    $str1 = "select top 1000 pp.longitude, ISNULL(pp.UserID, " . session("client_id") . ") as UserID, pp.latitude, pp.name, pp.description, ISNULL(pp.available, 2) as available, pp.pinpointgroupid, pp.id, ISNULL(ppg.Color, '000000') AS Color, ppg.GroupName, ppg.Image, pp.CanChange, pp.AddInfo, pp.RadiusID from pinpoints pp ";
    $str1 .= " left outer join PinPointGroups ppg on pp.PinPointGroupID=ppg.ID ";
    $str1 .= " where " . $sqlV . " " . $str2 . " ORDER BY ID DESC";*/
    $str1 = "";
    $str1 .= " select ST_X(ST_Transform(pp.geom,4326)) long, ST_Y(ST_Transform(pp.geom,4326)) lat, pp.name, pp.available, pp.active, ";
	$str1 .= " pp.groupid, pp.id, ppg.fillcolor color, ppg.name groupname, pp.radius, ppg.image from pointsofinterest pp "; 
	$str1 .= " left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id  ";
	$str1 .= " where pp.clientid=" . session("client_id") ." " . $str2 . " and pp.active='1' and type=1 " . $str3 . " ORDER BY pp.id DESC";
	// select * from pointsofinterest where clientid = 154
	// and (userid in (select id from users where organisationid in (select organisationid from users where id=506)) or available = 1 or available = 3)
    //echo $str1;
    //exit;
    $ds = query($str1);
    $str = "";
    $_canch = "";
    while($row = pg_fetch_array($ds))
	{
     	$_canch = "1";   	
        //if($row["UserID"] == session("user_id") || session("role_id") == "2")
            //$_canch = "1";
		//else
            //$_canch = $row["CanChange"];
        $str .= "#" . str_replace(",", ".", $row["long"]."") . "|" . str_replace(",", ".", $row["lat"]."") . "|" . str_replace("|", "", str_replace("#", "", $row["name"])) . "|" . $row["groupid"] . "|" . $row["id"] . "|" . str_replace("|", "", str_replace("#", "", $row["color"])) . "|" . str_replace("|", "", str_replace("#", "", $row["groupname"])) . "|" . str_replace("|", "", str_replace("#", "", $row["radius"])) . "|" . $row["available"] . "|" . $row["image"];
    }
	
    if($str == "")
        $str = "@";
	echo $str;
   	//echo base64_encode(gzencode($str));
	closedb();
?>