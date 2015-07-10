<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<link rel="stylesheet" href="../js/mlColorPicker.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="../js/mlColorPicker.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" type="text/css" href="../style.css">

	<script type="text/javascript" src="../js/settings.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>

	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
	<script src="../js/jquery-ui.js"></script>
	<style type="text/css"> 
    	body{ overflow-y:auto;}
 	    body{ overflow-x:auto;}
    </style>
	
	<?php 
	
	$id = str_replace("'", "''", NNull($_GET['id'], ''));

	opendb();
	?>

	
	<br><br><br>
	
	<table align = "center" width = "100%">
	<tr>
	<td style="font-weight:bold" class ="text2" width="50%" align = "right"><?php dic("Settings.EnterNameForHoliday")?>: </td>
	<td style="font-weight:bold" class ="text2" width="50%" align = "left">
	
	<?php 
		
		$rezultat = query("select * from companydaysholiday where id = ". $id ." and clientid =" . Session("client_id")."");
		$ime = pg_fetch_result($rezultat, 0 , "nameholiday")
	?>
		
		<input id= "promeniTipPraznik" type="text" size="32" value = "<?php echo $ime?>"></input>
    
    </td>
    </tr>
    </table>

    
	<?php
	closedb();
	?>	