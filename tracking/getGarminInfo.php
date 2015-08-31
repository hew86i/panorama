<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	 header("Content-type: text/html; charset=utf-8");
	//set_time_limit(0);
	opendb();
	
	$gid = $_GET['gid'];
	//$dsGarmin = query('select * from stopstatus where garminid=' . $gid);
	$dsGarmin = query("select *, (select datetimeformat from users where id=toid) datetimeformat, (select code from vehicles where id = toid) veh_code, (select registration from vehicles where id = toid) registration from stopstatus where garminid=" . $gid);
	$row = pg_fetch_array($dsGarmin);
	$dtformat = $row["datetimeformat"];
	$StartDatetime = new DateTime($row["dtstart"]);
	$EndDatetime = new DateTime($row["dtend"]);
	$DelDatetime = new DateTime($row["dtdelete"]);
	
	$longitude = $row["longitude"];
	$latitude = $row["latitude"];
	$location = $row["location"];
	$opacity = 'opacity: 1';
	if($row["flag"] == 1){
		$image = '<img src="../images/no1.png"  />';	
		if($row["status"] == 100){
			$status = 'Активна';	
		} 
		else if($row["status"] == 101){
			$image = '<img src="../images/yes1.png"  />';
			$status = 'Завршена';
		}
		else if($row["status"] == 102){
			$status = 'Не прочитана';
		}
		else if($row["status"] == 103){
			$status = 'Прочитана';
		} if($row["status"] == 104){
			$status = 'Избришана';
		} 
	} else {
		$opacity = 'opacity: 0.5';
		$image = '<img src="../images/nosignal.png"  />';
	}
 ?>
 
	<div>
		<div onClick="setStopPositionCenter(<?= $longitude?>,<?= $latitude?>,'<?=$row["text"]?>')" style="float:left; width:16px; height:16px; margin-left:2px; margin-bottom:2px; cursor:pointer"><?= $image; ?></div>
		<div onClick="setStopPositionCenter(<?= $longitude?>,<?= $latitude?>,'<?=$row["text"]?>')" style="color: #000000; width: 125px; text-overflow: ellipsis; white-space: nowrap; height: 14px; overflow: hidden; float:left; padding-top:2px; padding-left:3px; font-weight:bold; cursor:pointer"><?= $row["registration"]; ?> (<?= $row["veh_code"] ?>)</div>
		<div id="vh-garminList-status-<?php echo $row["code"]?>" style="width: 65px; position: relative; right: 2px; top: 2px; float:right; text-align:right; color:#000000; font-size:10px;" >
			<?= $status; ?>
		</div>
	</div>
	<div id="vh-garminList-text-<?php echo $row["code"]?>" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">
		Текст: <?= $row["text"] ?>
	</div>
	<div id="vh-garminList-location-<?php echo $row["code"]?>" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">
		Локација: <?= $location; ?>
	</div>
<?php if($row["dtstart"] != ''){ ?>
	<div id="vh-garminList-start-<?php echo $row["code"]?>" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">
		Почеток: <?= $StartDatetime->format($dtformat).''?>
	</div>
<?php }
	if($row["dtend"] != ''){ ?>
	<div id="vh-garminList-end-<?php echo $row["code"]?>" style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">
		Крај: <?= $EndDatetime->format($dtformat).''?>
	</div>
<?php } 
	if($row["dtdelete"] != ''){ ?>
	<div id="vh-garminList-delete-<?php echo $row["code"]?>"style="height: 12px; background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">
		Избришана: <?= $DelDatetime->format($dtformat).''?>
	</div>
<?php }

closedb();
?>