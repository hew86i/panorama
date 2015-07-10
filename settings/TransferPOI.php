<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php opendb();?>
<script> 
		lang = '<?php echo $cLang?>';
</script>
	 <?php
	
	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	$dspoi = query("select id,name from pointsofinterest where id =" . $id . " and clientid = " . Session("client_id")."order by name");
	if (pg_num_rows($dspoi) == 0){
			
		echo dic("Settings.NemaPOI");
	}
	else
	{
	?>
	<p><?php echo dic("Settings.SelectPOI")?></p>
    <div id="allCheckboxes2">
    <?php
        while($row = pg_fetch_array($dspoi))
		{
            $count = dlookup("select count(*) from pointsofinterest where id = " . $row["id"] . " and clientid =" . Session("client_id"));
			
            if($count == 1)
			{
	            ?>
	            <input type="checkbox" checked="checked" id="<?php echo $row["id"]?>" /><?php echo $row["name"]?> <br />
	            <?php
			} else
			{
	            ?>
			 <input type="checkbox" id="<?php echo $row["id"]?>" /><?php echo $row["name"]?> <br />
			<?php
			}
		}
		?>
	</div>
	<?php
	}
	?>
			<br><br>
				<div align = "left">
				<label class="text5"> <?php echo dic("Tracking.Group")?>:</label>
                <?php $find = query("SELECT id,name from pointsofinterestgroups where clientid = " . Session("client_id")."order by name");
                $n = 1;
                ?>

			    <select id="GroupName1" class="combobox text2">
			    <option id="<?php echo $n ?>" value = "<?php echo $n ?>"><?php echo dic("Settings.NotGroupedItems")?> </option>
			    <?php
					while($row = pg_fetch_array($find)){
    					  $data[] = ($row);
						  }
						  foreach ($data as $row){
				?>

			    <option id="<?php echo $row["id"] ?>" value = "<?php echo $row["id"] ?>"><?php echo $row["name"] ?>
				</div>
				<?php
				}
				?>
				</option>
				</select>

<?php 
closedb();
?>

<script>
function checkAll2(bx) {
  var cbs = document.getElementsByTagName('input');
  for(var i=0; i < cbs.length; i++) {
    if(cbs[i].type == 'checkbox') {
      cbs[i].checked = bx.checked;
    }
  }
}
</script>