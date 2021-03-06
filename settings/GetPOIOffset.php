<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php

	error_reporting(E_ALL & ~E_NOTICE);

	opendb();

	$cid = Session("client_id");
	$uid = Session("user_id");

	$roleid = dlookup("select roleid from users where id=".$uid);

	$limit = 20;
	$offset = 0;

	$limit = str_replace("'", "''", NNull($_GET['limit'], ''));
	$offset = str_replace("'", "''", NNull($_GET['offset'], ''));
	$groupid = str_replace("'", "''", NNull($_GET['groupid'], ''));
	$isExpanded = NNull($_GET['expanded'], '');
	$isFetchAll = (int)NNull($_GET['all'], 0);
	$getInactive = (int)NNull($_GET['getInactive'], 0);

	if($isFetchAll == 1) {

		// >>>>>>>>>>> fetch all POI >>>>>>>>>>>>>
		$go = 1;
		$rows = array();

		$qSt_3 = "select p.id,p.groupid,p.name,p.type,p.radius,p.povrsina,p.userid,p.available,p.description,u.fullname from pointsofinterest p
				left join users u on p.userid=u.id
				where p.clientid=". $cid ." and p.active = '1' and ((p.available=3) or
				(p.available = 2 and (select organisationid from users where id=". $uid .") = (select organisationid from users where id=userid) and (select organisationid from users where id=userid) <> 0) or
				(available=1 and userid=". $uid .")) order by p.groupid asc, p.id asc";

		$qSt_2 = "select p.id,p.groupid,p.name,p.type,p.radius,p.povrsina,p.userid,p.available,p.description,u.fullname from pointsofinterest p left join users u on p.userid=u.id where p.clientid=". $cid . " and p.active = '1' order by p.groupid asc, p.id asc";


		$gal = ((int)$roleid == 2) ? $qSt_2 : $qSt_3;
		$getall = query($gal);

		$c = 1;
		while ($r = pg_fetch_assoc($getall)) {

			if($r['groupid'] == $go) {
				$r['tblindex'] = $c;
				$rows[] = $r;
				$go = $r['groupid'];
			} else {
				$c=1;
				$r['tblindex'] = $c;
				$rows[] = $r;
				$go = $r['groupid'];
			}
			$c++;
		}

    	echo json_encode($rows);
		exit;
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	}

	// >>>>>>>>>>> fetch all inactive >>>>>>>>>>>>>

	if($getInactive == 1) {

		$inactiveRows = array();

		$iqSt_3 = "select p.id,p.groupid,p.name,p.type,p.radius,p.povrsina,p.userid,p.available,u.fullname from pointsofinterest p
				left join users u on p.userid=u.id
				where p.clientid=". $cid ." and p.active = '0' and ((p.available=3) or
				(p.available = 2 and (select organisationid from users where id=". $uid .") = (select organisationid from users where id=userid) and (select organisationid from users where id=userid) <> 0) or
				(available=1 and userid=". $uid .")) order by p.groupid asc, p.id asc";

		$iqSt_2 = "select p.id,p.groupid,p.name,p.type,p.radius,p.povrsina,p.userid,p.available,u.fullname from pointsofinterest p left join users u on p.userid=u.id where p.clientid=". $cid . " and p.active = '0' order by p.groupid asc, p.id asc";

		$igal = ((int)$roleid == 2) ? $iqSt_2 : $iqSt_3;
		$igetall = query($igal);

		$ic = 1;
		while ($ir = pg_fetch_assoc($igetall)) {
			$ir['tblindex'] = $ic++;
			$inactiveRows[] = $ir;
		}

		echo json_encode($inactiveRows);
		exit;
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	}

	// >>>>>>>>>>>>>>>>>>>>>>>>>  F E T C H     B Y    O F F S E T    >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

	$qGetpoi_user = "select * from pointsofinterest where clientid=". $cid ." and active = '1' and groupid= ". (int)$groupid ." and ((available=3) or (available=2 and (select organisationid from users where id=". $uid .") =
					(select organisationid from users where id=userid) and (select organisationid from users where id=userid) <> 0)
					or (available=1 and userid=". $uid .")) order by id limit ". (int)$limit ." offset " . (int)$offset;

	$gGetpoi_admin =  "select * from pointsofinterest where clientid=" . $cid . " and active = '1' and groupid=" . (int)$groupid . " order by id limit ". (int)$limit ." offset " . (int)$offset;

	$qGp = ((int)$roleid == 2) ? $gGetpoi_admin : $qGetpoi_user;

	$qGetpoi = query($qGp);

	$rowN= 1 + $offset;

	$bannedPOI = dlookup("select bannedpoi from users where id=" . $uid);

	if (pg_num_rows($qGetpoi) == 0) {
		echo 0;
		exit;
	}
	else {

	while($row = pg_fetch_assoc($qGetpoi)) {

	?>

	<tr class="data-rows"  id="poiid_<?php echo $row["id"];?>">
		<td width="4%" class="text2 td-row-poi">
			<div class="toggle">
			 	<?php echo $rowN; $rowN++?>
			</div>
		</td>

		<td width="38%" class="text2 td-row-poi la" style="padding-left:8px">
		<div class="toggle">

			<input type="checkbox" class="case" id="<?php echo $row["id"];?>" onclick="prikazi()"/>&nbsp;
			<?php   if($row["type"] == 1) { ?> <img src = "../images/poiButton.png" height="25px" width = "25px"  style="position: relative;top:7px;"></img>
			<?php } if($row["type"] == 2) { ?> <img src = "../images/zoneButton.png" height="25px" width = "25px"  style="position: relative;top:7px;"></img>
			<?php } if($row["type"] == 3) { ?> <img src = "../images/areaImg.png" height="25px" width = "25px"  style="position: relative;top:7px;"></img> <?php } ?>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<span class='poi-id-name' style="position: relative;bottom:8px;">
				<b><?php echo $row['name'] ?></b>
				&nbsp;
				<?php
				if($row["type"] == 2 || $row["type"] == 3){

					$povrsina = (float)round($row['povrsina'],2,PHP_ROUND_HALF_DOWN);

					if ($povrsina < 1000){ ?> (<?php echo $povrsina;?> m2)<?php }
					if ($povrsina > 1000 && $povrsina < 1000000){ ?>(<?php echo round($povrsina/1000,2)?> ha)<?php }
					if ($povrsina > 1000000){ ?>(<?php echo round($povrsina/1000000,2)?> km2)<?php } ?>
				<?php } ?>
			</span><br>
			<span style="padding-left: 71px;">
			<?php
				if($row["userid"] == 0) { ?>
					<span style="margin-left:86px"></span>
				<?php
				}
				else {
					$userfullname = pg_fetch_array(query("select * from users where id = ".$row["userid"]));
					echo "(" . $userfullname["fullname"] . ")";
				}

				?>

			</span>
		</div>
		</td>
		<td width="13%" class="text2 td-row-poi">
		<div class="toggle">
			<?php
				if($row["type"] == 1) echo dic("Settings.POI");
				if($row["type"] == 2) echo dic("Reports.GeoFence");
				if($row["type"] == 3) echo dic("Settings.Polygon");
			?>
			<br>
			<b>(<?php echo $row["radius"]?> m)</b>
		</div>
		</td>
		<td width="13%" class="text2 td-row-poi">
		<div class="toggle">
			<?php
				if($row["available"] == 1) echo "<b>".dic_("Routes.User")."</b>";
				if($row["available"] == 2) echo "<b>".dic_("Reports.OrgUnit")."</b>";
				if($row["available"] == 3) echo "<b>".dic_("Settings.Company")."</b>";
			?>
		</div>
		</td>

		<td width="8%" class="text2 td-row-poi">
			<div class="toggle"><button class="btn-refresh-ui btn-def" id="btnprivilegesz<?php echo $rowN?>" onclick="edit_poi('<?php echo $row["id"]?>','<?php echo $cLang?>')"></button></div>
		</td>
		<td width="8%" class="text2 td-row-poi">
			<div class="toggle"><button class="btn-search-ui btn-def" id="btnMapPoiUngroup<?php echo $rowN?>" onclick = "OpenMapAlarm1('<?php echo $row["id"]?>', '<?php echo $row["name"]?>', '<?php echo $row["type"]?>');"></button></div>
		</td>
		<td width="8%" class="text2 td-row-poi">
			<div class="toggle"><button class="btn-penci-ui btn-def" id="btnEditPoiUngroup<?php echo $rowN?>" <?php  if($row["type"] ==1){?> onclick="edit_poi_dialog('<?php echo $row["name"]?>','<?php echo $row["available"]?>','<?php echo $row["groupid"]?>','<?php echo $row["id"]?>','<?php echo $row["description"]?>','1','','<?php echo $row["radius"]?>');" <?php  } if($row["type"]==2 || $row["type"]==3 ){ ?> onclick = "OpenMapAlarm2('<?php echo $row["id"]?>', '<?php echo $row["name"]?>', '<?php echo $row["type"]?>');" <?php }?>></button></div>
		</td>
		<td width="8%" class="text2 td-row-poi">
			<div class="toggle"><button class="btn-trash-ui btn-def" id="btnDeletez<?php echo $rowN?>"  onclick="DeletePOI('<?php echo $row["id"]?>','<?php echo $cLang?>')"></button></div>
		</td>
	</tr>
<?php }
//end while
}
closedb();

?>

