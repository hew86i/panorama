<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	$yourbrowser1 = (bool) strpos($ua['userAgent'], "Macintosh");
?>
<?php
	opendb();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
	<link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../live/style.css">

	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/roundIE.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	<style type="text/css">
	<?php
	if($yourbrowser == "1")
	{?>
		html { 
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch; 

		}
		body {
		    height: 100%;
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch;
		}
		
	<?php
	}
	?>
	</style>
    <script type="text/javascript" src="../pdf/pdf.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="fm.js"></script>
	<script type="text/javascript" src="../js/highcharts.src.js"></script>
  
    <link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="../js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
    <script src="../js/jquery-ui.js"></script>
    <style>
   
    </style>
	<style type="text/css"> 
 		body{ overflow-y:auto }
	</style>
	
	 <style>
		.textboxCalendarSett {
			border:1px solid #ccc; height:25px; padding-left:5px; padding-right:5px; width:122px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px;			
		}
    </style>
    

 	<body>
 	<?php
 	  $id = str_replace("'", "''", NNull($_GET['id'], ''));
      $LastDay = DateTimeFormat(addDay(-1), "d-m-Y");
	?>
    <div align = "center">
    <br>
    <table width="80%" border="0" cellspacing = "2" cellpadding = "2">
    <tr>
    <td align="center" class="text2"><?php dic("Settings.BeginDateLic") ?>: </td>
    <td align="center" class="text2"><?php dic("Settings.EndDateLic") ?>:</td>
    </tr>
    <tr>
    <td align="center" class="text2">
    <input id="pocetok" type="text" style="z-index: 999" value="<?php echo  $LastDay ?>" class="textboxCalendarSett">
 	</td>
 	<td align="center" class="text2">
 	<input id="kraj" type="text" style="z-index: 999" value="<?php echo $LastDay ?>" class="textboxCalendarSett">
 	</td>
 	</tr>
 	</table>	
   	
    <table width="80%" border="0" cellspacing = "2" cellpadding = "2" style="margin-top:30px;">
	<tr>
		<td align = "left" valign = "middle" colspan="9" height="22px" width = "100%" class="text2" style="color:#fff; font-weight:bold; font-size:14px;  padding-left:7px; background-color:#f7962b; font-weight:bold;" > <?php dic("Settings.Vehicles")?></td>
	</tr>
	<tr>
		<td align = "center" width="15%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.Code")?> </td>
		<td align = "center" width="25%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Registration")?> </td>
		<td align = "center" width="50%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.Model")?> </td>
		<td align = "center" width="10%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.ChooseButton")?> </td>
	</tr>
	
	<?php
		$cnt=1;
		$checked = "";
		$najdeno = query("select * from vehicleslicense where clientid = " . Session("client_id") . " and (select coalesce(active, '0') from vehicles where id = vehicleid)='1'");
		
		$vozila = "select * from vehicles where active='1' and clientid = " . Session("client_id"). " order by code";
		$vozila2 = query($vozila);
		
		while ($red = pg_fetch_array($vozila2))
		{
 		?>
		<tr>
			<td align = "center" width="15%" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
				<?php echo $red["code"] ?>
			</td>
			<td align = "center" width="25%" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
				<?php echo $red["registration"] ?>
			</td>
			<td align = "center" width="50%" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
				<?php echo $red["model"]?>
			</td>
			<td align = "center" width="10%" cheight="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
				<input type = "radio" id = "odberi<?php echo $cnt?>" name = "edno"  value="<?php echo $red["id"]?> " />
			</td>
		</tr>
		<script>
		</script>
		<?php
		$cnt++;
		}
		?>
		</table>
	</div>
	<?php closedb();?>
</body>
</html>


<script>
		//$(document).ready(function () {
		    $('#pocetok').datepicker({
			dateFormat: 'dd-mm-yy',
		        showOn: "button",
		        buttonImage: "../images/cal1.png",
		        buttonImageOnly: true,
		        hourGrid: 4,
		        minuteGrid: 10
		    });
		    
		    $('#kraj').datepicker({
		    	dateFormat: 'dd-mm-yy',
		        showOn: "button",
		        buttonImage: "../images/cal1.png",
		        buttonImageOnly: true,
		        hourGrid: 4,
		        minuteGrid: 10
		    });		     
		//});
</script>
