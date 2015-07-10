<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php include "../include/db.php" ?>
<?php session_start()?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<?php
		opendb();
		$cost = getQUERY("cost");
		?>
	<body>
		<div class="text5" style="font-size: 13px"><?php echo dic_('Reports.SureDelCost')?> <strong><?php echo $cost?></strong>?</div>
	</body>
	
</html>
