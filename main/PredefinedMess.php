<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
		
opendb();
$id = getQUERY("id");
$gsmnum = dlookup("select gsmnumber from vehicles where id=" . $id);
$quckmess = query("select * from quickmessage where vehicleid = ".$id." order by messageid asc");
if(pg_num_rows($quckmess) == 0)
{
?>	
	<tr><td>
		<div id="noDataquickmess" style="padding: 40px; font-size:20px; font-style:italic;" class="text4">
			<?php dic("Reports.NoData1")?>
		</div>
	</td></tr>
<?php
}
else
{
	while ($row3 = pg_fetch_array($quckmess)) {
		$opac = '1';
		$dis = 'none';
		if($row3["flag"] == "0") {
			$opac = '0.5';
			$dis = 'block';
		}
	?>
	<tr style="opacity: <?=$opac?>">
		<td align="left" width="53px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:10px">
			<img title="" style="display: <?=$dis?>; position: absolute; margin-left: 18px;" width="13px" src="../images/nosignal.png" />
			<?= $row3["messageid"] ?>
		</td>
		<td align="left" width="80%" height="30px" class="text2" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8;">
			<?= $row3["body"] ?>
		</td>
		<!--td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
			<button id="btnEditQM<?= $row3["id"] ?>"  onclick="EditQuickMessClick('<?= $row3["body"]?>', <?= $row3["id"]?>, <?= $row3["messageid"]?>, '<?= $gsmnum?>')" style="height:25px; width:30px"></button>
		</td-->
		<td align="center" width="10%" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
			<button id="DelBtnQM<?= $row3["id"] ?>"  onclick="DeleteQuickmessClick(<?= $row3["messageid"]?>, '<?= $gsmnum?>')" style="height:25px; width:30px"></button>
		</td>
		 <script>
			//$('#btnEditQM' + '<?= $row3["id"] ?>').button({ icons: { primary: "ui-icon-pencil"} })
	   		$('#DelBtnQM' + '<?= $row3["id"] ?>').button({ icons: { primary: "ui-icon-trash"} })
		 </script>
	 </tr>
	<?php }
}
closedb();
exit();    
?>
