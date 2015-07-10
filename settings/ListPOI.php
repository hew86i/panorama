<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<script> 
		lang = '<?php echo $cLang?>';
</script>
<?php
	opendb();
	$id = str_replace("'", "''", NNull($_GET['id'], ''));

    $dspoi = query("select id,name from pointsofinterest where id=" . $id . " and clientid = " . Session("client_id")."order by name");
	if (pg_num_rows($dspoi) == 0)
	{
		echo dic("Settings.NemaPOI");
	}
	else
	{
	?>
	<p><?php echo dic("Settings.ChooseToDeletePoints")?></p>
	<br>
    <div id="allCheckboxes">
    <?php
        while($row = pg_fetch_array($dspoi))
		{
            $count = dlookup("select count(*) from pointsofinterest where id= " . $row["id"] . " and clientid =" . Session("client_id"));
				
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
    closedb();
?>
<script>
   $('#check_<?php echo $row["id"]?>').select;
   document.getElementById('check_<?php echo $row["id"] ?>');
   document.getElementById('check_<?php echo $row["id"] ?>');
	</script>
	
<script>
function checkAll(bx) {
  var cbs = document.getElementsByTagName('input');
  for(var i=0; i < cbs.length; i++) {
    if(cbs[i].type == 'checkbox') {
      cbs[i].checked = bx.checked;
    }
  }
}
</script>