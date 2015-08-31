<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	opendb();
	$gid = $_GET['gid'];
	$dsGarmin = query('select *, (select code from vehicles where id=toid) code, (select gsmnumber from vehicles where id=toid) gsmnumber, (select datetimeformat from users where id=toid) datetimeformat from stopstatus where garminid=' . $gid);
	$row123 = pg_fetch_array($dsGarmin);
	$dtformat = $row123["datetimeformat"];
	$StartDatetime1 = new DateTime($row123["dtstart"]);
?>
	<img src="../images/areaSave1.png" width="14px" style="padding-top: 2px; padding-bottom: 2px; position: relative; float: left;" />
    <div id="vh-garmin-status-<?php echo $row123["code"]?>" onclick="checkGarmin('<?=$row123["gsmnumber"]?>')" style="width: 190px; position: relative; float: right; left: 5px; top: 1px;">Гармин: Активен <img src="../images/stikla2.png" width="10px" style="padding-top: 2px; padding-bottom: 2px; padding-right: 4px; position: relative; float: right;" /></div>
	<div style="width: 190px; position: relative; float: right; left: 5px; top: 1px; border-top:1px dotted #333">Име: <span id="vh-garmin-text-<?php echo $row123["code"]?>"><?= $row123["text"] ?></span></div>
	<div style="width: 190px; position: relative; float: right; left: 5px; top: 1px; border-top:1px dotted #333">Почеток: <span id="vh-garmin-start-<?php echo $row123["code"]?>"><?= $StartDatetime1->format($dtformat).''; ?></span></div>
	<div style="width: 190px; position: relative; float: right; left: 5px; top: 1px; border-top:1px dotted #333">Локација: <span id="vh-garmin-location-<?php echo $row123["code"]?>" ><?= $row123["location"]; ?></span></div>
	<div style="height: 44px; width: 190px; position: relative; float: right; left: 5px; top: 1px; border-top:1px dotted #333">Естимација:<br>&nbsp;&nbsp;Време: <span id="vh-garmin-estimationtime-<?php echo $row123["code"]?>">/</span><br>&nbsp;&nbsp;Километри: <span id="vh-garmin-estimationkm-<?php echo $row123["code"]?>">/</span><img id="vh-img-garminref-<?=$row123["code"]?>" onclick="refreshEstimation('<?=$row123["gsmnumber"]?>', '<?=$row123["code"]?>')" src="../images/smallref.png" width="17px" style="cursor: pointer; position: absolute; right: 5px; bottom: 6px;" onmouseover="ShowPopup(event, 'Кликнете за нов податок')" onmouseout="HidePopup()" /></div>
<?php
closedb();
?>