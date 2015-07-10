<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>
lang = '<?php echo $cLang?>';
</script>

	
	<?php
		opendb();
	    $id = str_replace("'", "''", NNull($_GET['id'], ''));
		$dsedit = query("select * from route_culture where id=" . $id . " and clientid = " . Session("client_id"));
	?>

		<br><br>
		<table align = "center">
            <tr>
                <td class="text5" style="font-weight:bold; font-size = 15px ;"><?php dic("Settings.NameOfThe") ?> <?php dic("Settings.Culture") ?>:</td>
                <td>
                     <input id="kulturaPromeni" type="text" value="<?php echo pg_fetch_result($dsedit,0,"name")?>" class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>
                </td>
            </tr>
   		</table>
   		
   		
   		
<?php
   closedb();
?>