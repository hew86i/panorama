<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	 header("Content-type: text/html; charset=utf-8");
	//set_time_limit(0);
	opendb();
	
	$id = $_GET['id'];
	
 ?>
<option id="0" selected value="<?=dic_('SelectVeh')?>"><?=dic_("SelectVeh")?></option>
<?php
if (session("role_id")."" == "2") {
	$tovehicles = "select * from vehicles where clientid=" . session("client_id") . " and allowgarmin='1' and id <> " . $id . " and id not in (select toid from quickmessage where vehicleid=" . $id . " and toid is not null)";
} else {
	$tovehicles = "select * from vehicles where id in (select distinct vehicleid from uservehicles where userid=(" . session("user_id") . ")) and allowgarmin='1' and id <> " . $id . " and id not in (select toid from quickmessage where vehicleid=" . $id . " and toid is not null)";
}
$dsVehicles = query($tovehicles);
while ($drVehicles = pg_fetch_array($dsVehicles)) {
?>
      <option id="<?= $drVehicles["id"] ?>" value="<?=$drVehicles["registration"]?>"><?= $drVehicles["registration"]?> (<?= $drVehicles["code"]?>)</option>
<?php } //end while ?>
<?php
closedb();
?>
