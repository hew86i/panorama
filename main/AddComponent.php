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

 <?php
        $cLang = getQUERY("l");
       
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
 
    <?php
  
       
        opendb();
?>

<div align=left style='padding-top:25px; margin-left:45px'>
<table>
   
    <tr>
        <td style='font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:normal; color:#2f5185; text-decoration: none;'><?php echo dic_("Reports.EnterNewComp")?>:</td>
<tr>
<tr>
        <td>
            <input id="compname" type="text" class="text1-" style="border-radius: 5px 5px 5px 5px; border: 1px solid #CCCCCC; padding-left:5px; height:24px; width:270px; text-align:left; font-family:Arial, Helvetica, sans-serif; font-size:11px; font-weight:normal;" />
        </td>
    </tr>

</table>
</div>

<?php
    	closedb();
    ?>
</body>

<script>

   
</script>
</html>
