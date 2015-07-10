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

	$totalInbox = dlookup("select count(*) from messages where clientid=" . session("client_id") . " and toid=" . session("user_id"));
	$totalUnreadInbox = dlookup("select count(*) from messages where clientid=" . session("client_id") . " and checked='0' and toid=" . session("user_id"));
?>
	<thead style="position: fixed; margin-top: -7px; z-index: 1">
	<tr>
		<td>
			<div id="countincomingmess" style="width:238px; height:20px; font-size:14px; border:1px solid #CCCCCC; margin-left:5px; margin-right:0px" class="textSubTitle subtitle corner5">&nbsp;<?php echo dic_("Reports.Inbox")?> [<span id="spanUnread"><?php echo $totalUnreadInbox?></span>/<?php echo $totalInbox?>]</div>
		</td>
	</tr>
	</thead>
	<tbody style="position: relative; display: block; margin-top: 25px;">
<?php
    $messinbox = "select * from messages where toid=" . session("user_id") . " and clientid=" . session("client_id") . " order by checked asc, datetime desc";
	$dsMessInbox = query($messinbox);   
	$c = 0;
	while ($drMessInbox = pg_fetch_array($dsMessInbox)) { 
	?>
  	<tr id="inbox-tr-<?php echo $c?>" >
  		<td>
		  	<table class="text2_ garminmessclick" onclick="rowclickgarmin(this)" style="margin-left: 5px; width: 237px;">
			<?php
				if($drMessInbox["toobject"] == 'colleague') {
	  				$from = dlookup("select fullname from users where id=" . $drMessInbox["fromid"]);
	  			} else {
	  				$from = dlookup("select registration from vehicles where id=" . $drMessInbox["fromid"]);
				}
				$img = $tpoint . "/images/messageunread.png";
				$size = "width=14px height=14px";
				if ($drMessInbox["checked"] == 1) {
					$img = $tpoint . "/images/messageread.png";
					$size = "width=12px height=12px";
				}	
				$color = "color:#8c8c8c";
				if ($drMessInbox["checked"] == 0) $color = "color:blue";
			?>
				<tr style="cursor:pointer" onclick="loadMess(<?php echo $drMessInbox["id"]?>, 'inbox', '<?= $drMessInbox["toobject"]?>')">
					<td style="color: #8c8c8c"><?=$totalInbox?></td>
					<td>
						<table class="text2_" width=100% id="table-<?php echo $drMessInbox["id"]?>" style="<?php echo $color?>">
							<tr >
								<td width=5% valign="top">
									
									<img id="img-<?php echo $drMessInbox["id"]?>" <?php echo $size?> src="<?php echo $img?>" style="">
								</td>
					  			<td width=65% ><strong id="inbox-name-<?php echo $c?>"><?php echo $from?></strong></td>
					  			<td width=35% id="inbox-datetime-<?php echo $c?>"><?php echo DateTimeFormat($drMessInbox["datetime"], $dateformat)?></td>
					  		</tr>
					  		<!--<tr><td colspan=3 id="inbox-subject-<?php echo $c?>"><?php echo $drMessInbox["subject"]?></td></tr>-->
					  		<tr><td colspan=3 style="font-style:italic" id="inbox-body-<?php echo $c?>"><?php echo substr($drMessInbox["body"], 0, 70)?> ...</td></tr>
						</table>
					</td>
				</tr>
		  	</table>
  		</td>
	</tr>
	<tr id="inbox-trr-<?php echo $c?>" style="height:1px;">
        <td><div style="border-bottom:1px dotted #bebebe; width:93%; margin-left:8px"></div></td>
  	</tr>
	<?php			
		$c ++;
		$totalInbox--;
	}   
	if (pg_num_rows($dsMessInbox) == 0) {
	?>
		<tr style="height:10px;">
			<td><div class="text2_" style="margin-left:8px">- <?php echo dic_("Reports.Empty")?> -</div></td>
		</tr>
	<?php
	}
	?>
	</tbody>
	<?php
    closedb();

    exit();
    
?>
