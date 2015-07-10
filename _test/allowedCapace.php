if (dlookup("select count(*) from vehicleport where vehicleid in (" . $sqlV . ") and porttypeid=15") > 0 and dlookup("select count(*) from vehicleport where vehicleid in (" . $sqlV . ") and porttypeid=7") > 0) {



if ($_SESSION['role_id'] == "2") {
	$sqlV = "select id from vehicles where clientID=" . $client_id . " and active='1'";
} else {
	$sqlV = "select vehicleID from uservehicles uv left outer join vehicles v on v.id=uv.vehicleid where userID=" . $user_id . " and v.active='1'";
}

select count(*) from vehicleport where vehicleid in (
$sqlV
) and porttypeid=17

