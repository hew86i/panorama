<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
	
	$id = getQUERY("id");
	opendb();
    $dsPre = query("select id, code, fullname from Drivers where clientid=" . Session("client_id") . " and id in (select driverid from VehicleDriver where VehicleID=" . $id . ") order by FullName");
    if(pg_num_rows($dsPre) > 0)
	{
        $str = "";
        while($row = pg_fetch_array($dsPre))
		{
            $str .= $row["id"] . "|" . $row["code"] . "|" . $row["fullname"];
            $str .= "%@";
        }
       	//$compressed = base64_encode(gzencode($str));
		print $str;
    } else
        print "Zero";
    closedb();
?>