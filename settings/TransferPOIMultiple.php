<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php opendb();

?>
<script> 
		lang = '<?php echo $cLang?>';
</script>
	 <?php
	
	$id = str_replace("'", "''", NNull($_GET['selektirani'], ''));
	?>
	<p><?php echo dic("Settings.SelectPOI")?></p>
    
	<br><br>
				<div align = "left">
				<label class="text5"> <?php echo dic("Tracking.Group")?>:</label>
                <?php $find = query("SELECT id,name from pointsofinterestgroups where clientid = " . Session("client_id")."order by name");
                $n = 1;
                ?>
            
			    <select id="GroupNameMultiple" class="combobox text2">
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
