<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
    
    $_routeID = getQUERY("id");
    
    $str = "";
	opendb();
	//echo "select ND.rbr, PP.ID, ST_X(pp.geom) lat, ST_Y(pp.geom) long, PP.Name from pointsofinterest PP left join rNalogDetail ND on PP.ID=ND.ppid where PP.ID in (select ND.ppid from rNalogDetail ND where ND.hederID=" . $_routeID . ") and pp.clientid=" . session("client_id") . " ND.hederID=" . $_routeID . " order by ND.rbr asc";
	//exit;
    
    //$type = dlookup("select type from pointsofinterest where id = (select ppid from rNalogDetail where hederid=" . $_routeID . " limit 1)");
	
	$str1 = "";
	$str1 .= " (select ND.rbr, PP.ID, st_y(st_centroid(geom)) long, st_x(st_centroid(geom)) lat, PP.Name, PP.type "; 
	$str1 .= " from pointsofinterest PP left join rNalogDetail ND on PP.ID=ND.ppid  ";
	$str1 .= " where pp.active='1' and PP.type=2 and PP.ID in (select ND.ppid from rNalogDetail ND where ND.hederID=" . $_routeID . ") and "; 
	$str1 .= " pp.clientid=" . session("client_id") . " and ND.hederID=" . $_routeID . " order by ND.rbr asc) ";
	$str1 .= " union ";
	$str1 .= " (select ND.rbr, PP.ID, st_y(st_centroid(geom)) long, st_x(st_centroid(geom)) lat, PP.Name, PP.type "; 
	$str1 .= " from pointsofinterest PP left join rNalogDetail ND on PP.ID=ND.ppid  ";
	$str1 .= " where pp.active='1' and PP.type=3 and PP.ID in (select ND.ppid from rNalogDetail ND where ND.hederID=" . $_routeID . ") and "; 
	$str1 .= " pp.clientid=" . session("client_id") . " and ND.hederID=" . $_routeID . " order by ND.rbr asc) ";
	$str1 .= " union ";
	$str1 .= " (select ND.rbr, PP.ID, ST_X(ST_Transform(pp.geom,4326)) long, ST_Y(ST_Transform(pp.geom,4326)) lat, PP.Name, PP.type "; 
	$str1 .= " from pointsofinterest PP left join rNalogDetail ND on PP.ID=ND.ppid  ";
	$str1 .= " where pp.active='1' and PP.type=1 and PP.ID in (select ND.ppid from rNalogDetail ND where ND.hederID=" . $_routeID . ") and "; 
	$str1 .= " pp.clientid=" . session("client_id") . " and ND.hederID=" . $_routeID . " order by ND.rbr asc) order by 1";
	
	
	$dsR = query($str1);
	//$dsR = query("select ND.rbr, PP.ID, st_y(st_centroid(geom)) long, st_x(st_centroid(geom)) lat, PP.Name, PP.type from pointsofinterest PP left join rNalogDetail ND on PP.ID=ND.ppid where PP.ID in (select ND.ppid from rNalogDetail ND where ND.hederID=" . $_routeID . ") and pp.clientid=" . session("client_id") . " and ND.hederID=" . $_routeID . " order by ND.rbr asc");

    if(pg_num_rows($dsR) > 0)
	{
        while ($row = pg_fetch_array($dsR)) {
            $str .= "#" . $row["long"] . "|" . $row["lat"] . "|" . $row["id"] . "|" . $row["name"] . "|" . $row["type"];
		}
		$str .= "#@";
    } else
		$str = "notok";
    /*'Dim dsRI As Data.DataSet
    
    'Dim sql As String = ""
    'sql += "select R.Name, Convert(nvarchar(20), R.StartDateTime, 105) + ' ' + Convert(nvarchar(5), R.StartDateTime, 108) StartDateTime, D.ID DriverID, D.FullName, V.ID VehicleID, V.Registration, RA.Radius, RA.Trajectory, RA.TimeOfWait, RA.[Order]"
    'sql += " from R_Routes R left join Drivers D on D.ID=R.DriverID"
    'sql += " left Join Vehicles V on V.ID=R.VehicleID"
    'sql += " left join R_RoutesAlarms RA on RA.routeID = R.ID"
    'sql += " where R.ID = " & _routeID
    'dsRI = Loaddataset(sql)*/

    

    //'If dsRI.Tables(0).Rows.Count > 0 Then
    //'str &= dsRI.Tables(0).Rows(0).Item("Name") & "@%" & dsRI.Tables(0).Rows(0).Item("DriverID") & "@%" & dsRI.Tables(0).Rows(0).Item("FullName") & "@%" & dsRI.Tables(0).Rows(0).Item("VehicleID") & "@%" & dsRI.Tables(0).Rows(0).Item("Registration") & "@%" & dsRI.Tables(0).Rows(0).Item("Radius") & "@%" & dsRI.Tables(0).Rows(0).Item("Trajectory") & "@%" & dsRI.Tables(0).Rows(0).Item("TimeOfWait") & "@%" & dsRI.Tables(0).Rows(0).Item("Order") & "@%" & dsRI.Tables(0).Rows(0).Item("StartDateTime")
    //'End If
    
    //$compressed = base64_encode(gzencode($str));
	print $str;
	closedb();
?>