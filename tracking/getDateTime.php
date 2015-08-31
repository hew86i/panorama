<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
    opendb();
	$dsFormats = query("select timezone, datetimeformat from users where id=" . session("user_id"));
	$TimeZone = pg_fetch_result($dsFormats, 0, 'timezone');
	$FormatDT = pg_fetch_result($dsFormats, 0, 'datetimeformat');
	$FormatDT = explode(" ", $FormatDT);
	if($FormatDT[1] == 'h:i:s')
		$timeformat = 'HH12:MI:SS AM';
	else
		$timeformat = 'HH24:MI:SS';
	if($FormatDT[0] == 'm-d-Y')
		$dateformat = 'MM-DD-YYYY';
	else
		$dateformat = 'YYYY-MM-DD';
	$CurrentTime = DlookUP("select to_char(now() + cast('" . ($TimeZone-1) . " hour' as interval), '" . $dateformat . " " . $timeformat . "') DateTime");
	echo $CurrentTime;
	closedb();
?>
