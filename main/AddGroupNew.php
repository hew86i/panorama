<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
    
    header("Expires: Mon, 20 Jul 2000 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", FALSE);
    header("Pragma: no-cache");
	set_time_limit(0);
	opendb();
	
	$groupName = str_replace("'", "''", NNull($_GET['groupName'], ''));
	$fcolor = str_replace("'", "''", NNull($_GET['fcolor'], ''));
	$scolor = "#000000"; //str_replace("'", "''", NNull($_GET['scolor'], ''));
    $img = str_replace("'", "''", NNull($_GET['img'], ''));
	$_lang = str_replace("'", "''", NNull($_GET['l'], ''));
	$cLang = $_lang;
	//$getMaxId = query("select max(id)+1 max from pointsofinterestgroups");

	$sqlAddG = "insert into pointsofinterestgroups (clientid, name, fillcolor, strokecolor, image) Values ('" . session("client_id") . "', '" . $groupName . "', '#" . $fcolor . "', '" . $scolor . "', " . $img . ")";
    $ret = RunSQL($sqlAddG);
	if($ret."" == "1")
    {
        $ret1 = query("SELECT id FROM pointsofinterestgroups ORDER BY ID DESC limit 1");
        print "@@%%".pg_fetch_result($ret1, 0, 'id')."@@%%".$img."@@%%".dic_("Tracking.TheGroup")."<strong>".$groupName."</strong> ".dic_("Tracking.SucAdd");
    } else {
        print dic("Tracking.Error");
    }
    closedb();
?>
