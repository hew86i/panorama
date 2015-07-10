<?php include "../../include/functions.php" ?>
<?php include "../../include/db.php" ?>
<?php include "../../include/params.php" ?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>
<?php

	$page = getQUERY("page");
	$page1 = $page;
	
	$req = getQUERY("req");
	$req1 = str_replace("**", "&", $req);

	$temp = explode("&",$req1);
	$uid = getQUERY("u");;
	$cid = getQUERY("c");;
	$sd = substr($temp[1], 3);
	$ed = substr($temp[2], 3);

	$namePDF = $page1. '_' . $cid . '_' . $sd . '_' . $ed . '.pdf';

	$namePDF1 = str_replace(" ", "_", $namePDF);
	$namePDF1 =  str_replace("(", "_", $namePDF1);
	$namePDF1 =  str_replace(")", "_", $namePDF1);
	$namePDF1 =  str_replace("__", "_", $namePDF1);

	$req1 .= "&c=" . $cid . "&u=" . $uid;
	if ($page == 'LogReport') {
		$req1 .= "&foruser=" . getQUERY("foruser");
	}

	$output = shell_exec('xvfb-run --server-args="-screen 0, 1200x800x24" wkhtmltopdf --dpi 300 "panorama.gps.mk/settings/' . $page . 'PDF.php?'. $req1 . '" --redirect-delay 10000 ../../savePDF/' . $namePDF1);
	
	echo $namePDF1;
?>
