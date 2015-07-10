<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
    set_time_limit(0);
	opendb();
	$action = getQUERY("action");
	$_name = nnull(utf8_urldecode(getQUERY('name')), "");
	if($action == 'add') {
		$vehid = getQUERY("vehid");
		$toid = getQUERY("toid");
		$allcheck = getQUERY("allcheck");
		if($allcheck.'' == "false") {
			$garminid = dlookup("select coalesce((select messageid from quickmessage where vehicleid=" . $vehid . " order by messageid desc limit 1), 0)");
			$garminid = $garminid + 1;
		    $sqlAddPoi = "insert into quickmessage (vehicleid, messageid, body, flag, toid) values";
			$sqlAddPoi .= "(" . $vehid . ", " . $garminid . ", '" . $_name . "', '0', " . $toid . ")";
			$ret = RunSQL($sqlAddPoi);
			echo $garminid;
		} else {
			if (session("role_id")."" == "2"){
				$sqlV = "select id, gsmnumber from vehicles where clientid=" . session("client_id");
			} else {
				$sqlV = "select vehicleid id, (select gsmnumber from vehicles where id=vehicleid) gsmnumber from uservehicles where userid=" . session("user_id");
			}
			$dsAllVeh = query($sqlV);
			$tmpgarmin = '';
			while($row = pg_fetch_array($dsAllVeh)) {
				$garminid = dlookup("select coalesce((select messageid from quickmessage where vehicleid=" . $row["id"] . " order by messageid desc limit 1), 0)");
				$garminid = $garminid + 1;
			    $sqlAddPoi = "insert into quickmessage (vehicleid, messageid, body, flag) values";
				$sqlAddPoi .= "(" . $row["id"] . ", " . $garminid . ", '" . $_name . "', '0')";
				$ret = RunSQL($sqlAddPoi);
				$tmpgarmin .= '*' . $row["gsmnumber"] . '|' . $garminid;
			}
			echo $tmpgarmin;
		}
	}
	if($action == 'edit') {
		$id = getQUERY("id");
		RunSQL("update quickmessage set body='" . $_name . "' where id=" . $id);
		echo 'edit';
	}
	if($action == 'delete') {
		$id = getQUERY("id");
		RunSQL("delete from  quickmessage where id=" . $id);
		echo 'delete';
	}
    closedb();
?>
