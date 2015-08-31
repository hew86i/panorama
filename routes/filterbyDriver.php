<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
	
	$id = getQUERY("id");
	opendb();
    $dsPre = query("select id, code, name from weapons where clientid=" . Session("client_id") . " and id in (select weaponid from weapondriver where driverid=" . $id . ") order by name");
    if(pg_num_rows($dsPre) > 0)
	{
        $str = "";
        while($row = pg_fetch_array($dsPre))
		{
            $str .= $row["id"] . "|" . $row["code"] . "|" . $row["name"];
            $str .= "%@";
        }
       	//$compressed = base64_encode(gzencode($str));
		print $str;
    } else
        print "Zero";
    closedb();
?>