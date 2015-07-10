<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

		<script>
			lang = '<?php echo $cLang?>'
	</script>
	<link rel="stylesheet" type="text/css" href="../style.css">



 <body>

  <?php
 
      $LastDay = DateTimeFormat(addDay(-1), "d-m-Y");
  	//	$vehID_ = getQUERY("vehid");
	  
	  opendb();
	
      $datetimeformat = dlookup("select datetimeformat from users where id=" . session("user_id"));
      $datfor = explode(" ", $datetimeformat);
      $dateformat = $datfor[0];
      $timeformat =  $datfor[1];
      if ($timeformat == 'h:i:s') $timeformat = $timeformat . " a";

      
      $gsmnum = getQUERY("gsmnum");
	  $id = getQUERY("id");
   ?>


<table width="99%" height="99%" class="text2_" style="margin:5px; overflow: hidden;">
	<tr>
    	<td height="90px">
			<font class="textTitle" style="font-size:16px;">Предефинирани пораки</font><br><br><br>
			<input id="txtCanned" class="corner5" style="width: 233px; height: 28px; padding: 5px; margin-left: 8px; color: #2f5185; border: 1px solid #ccc;" type="text" value="" placeholder="Внесете предефинирана порака" />
			<button id="addquickmess" style="margin-left: 20px; cursor: pointer;" onclick="ButtonAddCanned(<?=$id?>, '<?=$gsmnum?>', '0')"><?php dic("Settings.Add") ?></button><br>
			<input id="txtCannedToAll" type="checkbox" style="margin-left: 8px; color: #2f5185;" />&nbsp;За сите возила
			<script>
    			$('#addquickmess').button({ icons: { primary: "ui-icon-plusthick"} })
    		</script>
		</td>
    </tr>
    <tr style="height:50px;">
         <td colspan=6><div style="border-bottom:1px solid #bebebe"></div></td>
    </tr>
   	<tr>
    	<td>
			<font class="textTitle" style="font-size:16px;">Изберете возило за комуникација преку гармин</font><br><br><br>
			<select id="txtCannedReg" data-placeholder="" style="margin-right:5px; margin-left:8px; width: 235px; font-size: 11px; position: relative; top: 0px; z-index: 0; visibility: visible; background-color:white" class="combobox text2_">
				<option id="0" selected value="Изберете возило">Изберете возило</option>
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
            </select>
            <button id="addquickmess2" style="margin-left: 20px; cursor: pointer;" onclick="ButtonAddCanned(<?=$id?>, '<?=$gsmnum?>', '1')"><?php dic("Settings.Add") ?></button>
			<script>
    			$('#addquickmess2').button({ icons: { primary: "ui-icon-plusthick"} })
    		</script>
    	</td>
    </tr>
    <tr style="height:50px;">
         <td colspan=6><div style="border-bottom:1px solid #bebebe"></div></td>
    </tr>
    <tr>
    	<td>
		<?php
		    $quckmess = query("select * from quickmessage where vehicleid = ".$id." order by messageid asc"); ?>
			
			<table style="width: 100%; position: relative; display: block; overflow-x: hidden; overflow-y: auto; height: 170px;">
				<thead style="position: fixed; margin-top: -7px; z-index: 1; width: 666px;">
				<tr>
		        	<td align = "left" width="10%" height="25px" align="center" class="text2_" style="padding-left:10px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;">Број на порака</td>
					<td align = "left" width="80%" height="25px" align="center" class="text2_" style="padding-left:10px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;">Порака</td>
					<!--td align = "center" width="8%" height="25px" align="center" class="text2_" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><font color = "#ff6633"><?php dic("Settings.Change")?></font></td--> 
					<td align = "center" width="10%" height="25px" align="center" class="text2_" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><font color = "#ff6633"><?php dic("Tracking.Delete")?></font></td>
		        </tr>
		  		</thead>
		  		<tbody id="predefmess" style="position: relative; display: block; margin-top: 25px; width: 666px;">
	  			<?php
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
				?>
				<?php
				while ($row3 = pg_fetch_array($quckmess)) {
					$opac = '1';
					$dis = 'none';
					if($row3["flag"] == "0") {
						$opac = '0.5';
						$dis = 'block';
					}
		 		?>
				<tr style="opacity: <?=$opac?>">
					<td align="left" width="53px" height="30px" class="text2_" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:10px">
						<img title="" style="display: <?=$dis?>; position: absolute; margin-left: 18px;" width="13px" src="../images/nosignal.png" />
						<?= $row3["messageid"] ?>
					</td>
					<td align="left" width="80%" height="30px" class="text2_" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8;">
						<?= $row3["body"] ?>
					</td>
					<!--td align = "center" height="30px" class="text2_" style="background-color:#fff; border:1px dotted #B8B8B8; ">
						<button id="btnEditQM<?= $row3["id"] ?>"  onclick="EditQuickMessClick('<?= $row3["body"]?>', <?= $row3["id"]?>, <?= $row3["messageid"]?>, '<?= $gsmnum?>')" style="height:25px; width:30px"></button>
					</td-->
					<td align="center" width="10%" height="30px" class="text2_" style="background-color:#fff; border:1px dotted #B8B8B8; ">
						<button id="DelBtnQM<?= $row3["id"] ?>"  onclick="DeleteQuickmessClick(<?= $row3["messageid"]?>, '<?= $gsmnum?>')" style="height:25px; width:30px"></button>
					</td>
					 <script>
						//$('#btnEditQM' + '<?= $row3["id"] ?>').button({ icons: { primary: "ui-icon-pencil"} })
				   		$('#DelBtnQM' + '<?= $row3["id"] ?>').button({ icons: { primary: "ui-icon-trash"} })
					 </script>
				 </tr>
				<?php } } ?>
				</tbody>
			</table>
    	</td>
	</tr>
</table>
</body>
<?php
	closedb();
?>
</html>
<script>
	function DeleteQuickmessClick(_messid, _gsmnum){
		if(ws != null) {
			if (confirm("Дали сте сигурни дека сакате да ја избришете оваа предефинирана порака?") == true) {
				ShowWait();
				ws.send('quickmessdel', _gsmnum + '$*^' + _messid);
		   	}
	   	}
	}
	
</script>