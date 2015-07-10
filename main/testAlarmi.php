<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
	
	//list($d, $m, $y) = explode('-', $dat);
	//$a = explode(" ", $y);
	//$d1 = explode(":", $a[1]);
	//$d2 = explode(".", $d1[2]);
	//echo $dat . "<br />";
	//echo $d . "_" . $m . "_" . $a[0] . "_" . $d1[0] . "_" . $d1[1] . "_" . $d2[0] . "_" . $d2[1];
	//exit;
	opendb();
	$dsvv = query("select * from alarmtypes order by code asc");
	?>
	<table border="1">
	<?php
        while ($row = pg_fetch_array($dsvv))
        {
	?>
        <tr>
            <td style="padding: 5px"><?php echo $row["id"]?></td>
            <td style="padding: 5px"><?php dic($row["name"])?></td>
            <td style="padding: 5px"><?php echo $row["code"]?></td>
        </tr>
	<?php
		}
	?>
	</table>
	<?php
	closedb();
?>