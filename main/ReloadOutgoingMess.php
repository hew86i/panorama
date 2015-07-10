<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
		
    opendb();
	$datetimeformat = dlookup("select datetimeformat from users where id=" . session("user_id"));
	$datfor = explode(" ", $datetimeformat);
	$dateformat = $datfor[0];
	$timeformat =  $datfor[1];
	if ($timeformat == 'h:i:s') $timeformat = $timeformat . " a";
	$tpoint = '..';

	$totalSent = dlookup("select count(*) from messages where clientid=" . session("client_id") . " and fromid=" . session("user_id"));
	?>
	<thead style="position: fixed; margin-top: -7px; z-index: 1">
		<tr>
			<td>
				<div style="width:238px; height:20px; font-size:14px; border:1px solid #CCCCCC; margin-left:5px; margin-right:0px; margin-top:2px" class="textSubTitle subtitle corner5">&nbsp;<?php echo dic_("Reports.Sentbox")?> [<?php echo $totalSent?>]</div>
			</td>
		</tr>
	</thead>
	<tbody style="position: relative; display: block; margin-top: 25px;">
	<?php
    $messinbox = "select * from messages where clientid=" . session("client_id") . " and fromid=" . session("user_id") . " order by datetime desc";   
	$dsMessInbox = query($messinbox);   
	$cc = 0;
	while ($drMessInbox = pg_fetch_array($dsMessInbox)) {
		if($drMessInbox["flag"] == "0")
		{
			$opac = '0.5';
			$img = 'nosignal.png';
			$imgwidth = '13';
			$imgheight = '13';
		} else {
			$opac = '1';
			$img = 'messagesent.png';
			$imgwidth = '17';
			$imgheight = '11';
		}
	?>
	<tr id="sent-tr-<?php echo $cc?>"><td>
		<table id="tbl-<?php echo $drMessInbox["garminid"]?>" class="text2_ garminmessclick" onclick="rowclickgarmin(this)" style="margin-left: 5px; width: 237px; opacity: <?=$opac?>">
		<?php
	  		if ($drMessInbox["toobject"] == 'user' || $drMessInbox["toobject"] == 'colleague') {
	  			$to = dlookup("select fullname from users where id=" . $drMessInbox["toid"]);
	  		} else {
	  			$to = dlookup("select registration from vehicles where id=" . $drMessInbox["toid"]);
	  		}
		?>
			<tr  style="cursor:pointer;" onclick="loadMess(<?php echo $drMessInbox["id"]?>, 'sentbox', '<?= $drMessInbox["toobject"]?>')" >
				<td style="color: #8c8c8c"><?=$totalSent?></td>
				<td>
					<table class="text2_" width=100%>
						<tr style="color:#8c8c8c;">
							<td width=5% valign="top">
								<img id="img-<?php echo $drMessInbox["garminid"]?>" width="<?=$imgwidth?>px" height="<?=$imgheight?>px" src="<?php echo $tpoint?>/images/<?=$img?>" style="">
							</td>
				  			<td width=65%><strong id="sent-name-<?php echo $cc?>"><?php echo $to?></strong></td>
				  			<td width=35% id="sent-datetime-<?php echo $cc?>"><?php echo DateTimeFormat($drMessInbox["datetime"], $dateformat)?></td>
				  		</tr>
				  		<!--<tr style="color:#8c8c8c"><td id="sent-subject-<?php echo $cc?>" colspan=3 ><?php echo $drMessInbox["subject"]?></td></tr>-->
				  		<tr style="color:#8c8c8c"><td id="sent-body-<?php echo $cc?>" colspan=3 style="font-style:italic;"><?php echo substr($drMessInbox["body"], 0, 70)?> ...</td></tr>
					</table>
				</td>
			</tr>
	  	</table>
	</td></tr>
	<tr id="sent-trr-<?php echo $cc?>" style="height:1px;">
		<td><div style="border-bottom:1px dotted #bebebe; width:93%; margin-left:8px"></div></td>
	</tr>
	<?php		
		$cc ++;
		$totalSent--;
	}       
	if (pg_num_rows($dsMessInbox) == 0) { ?>
		<tr style="height:10px;">
			<td><div class="text2_" style="margin-left:8px">- <?php echo dic_("Reports.Empty")?> -</div></td>
		</tr>
	<?php } ?> 
	</tbody>
    <?php 
    closedb();
    exit();
?>
