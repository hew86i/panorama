<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
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

 <?php
        $cLang = getQUERY("l");
        $compId = getQUERY("compId");
		opendb();
		$compname = dlookup("select componentname from fmcomponents where id = " . $compId);
		
  		$tpoint = getQUERY("tpoint");
		if($tpoint == '.')
	{
		?>
		<script type="text/javascript" src="./main/main.js"></script>
  		<?php
	} else {
		?>
		<script type="text/javascript" src="../main/main.js"></script>
  		<?php
	}
?>		 

 <body>

 <script>
  		if (!<?php echo is_numeric(session('user_id')) ?>)
  			top.window.location = "<?php echo $tpoint?>/sessionexpired/?l=" + '<?php echo $cLang ?>';
 </script>
 
  
<div align=left style='padding-top:10px; margin-left:10px'>
<table style='font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:normal; color:#2f5185; text-decoration: none;'>
   
    <tr >
        <td><?php echo dic_("Reports.SureDelComp")?> <b><?php echo $compname?></b>?</td>
	<tr>
	</table>
</div>

<?php
    	closedb();
    ?>
</body>

<script>

   
</script>
</html>
