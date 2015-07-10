<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
	
	function createXls() {
		$page = getQUERY("page");
		$from = getQUERY("from");
		$page1 = $page;
		$req = getQUERY("req");
		$req1 = str_replace("**", "&", $req);
		$url = "";
	
			$temp = explode("&",$req1);
			$cid = getQUERY("c");
			$uid = getQUERY("u");
			$sd =  substr($temp[1], 3);
			$ed =  substr($temp[2], 3);
			$lang = substr($temp[0], 2);

			opendb();
			
			/* format na datum */
			$datetimeformat = dlookup("select datetimeformat from users where id=" . $uid);//'Y-m-d h:i:s a'; //
			$datfor = explode(" ", $datetimeformat);
			$dateformat = $datfor[0];
			$timeformat =  $datfor[1];
			if ($timeformat == "H:i:s") {
				$e_ = " 23:59";
				$e1_ = "_23:59";
				$s_ = " 00:00";
				$s1_ = "_00:00";
				$tf = " H:i";
			}	else {
				$e_ = " 11:59 PM";
				$e1_ = "_11:59_PM";
				$s_ = " 12:00 AM";
				$s1_ = "_12:00_AM";
				$tf = " h:i a";
			}	
			$sdG = DateTimeFormat($sd, 'd-m-Y H:i:s');
			$edG = DateTimeFormat($ed, 'd-m-Y H:i:s');
			/* format na datum */
								
			$nameXls = $page1. '_' . $cid . '_' . DateTimeFormat($sdG, $dateformat) . $s1_ . '_' . DateTimeFormat($edG, $dateformat) . $e1_ . '.xls';
			$url = $page . "1.php?l=" . $lang . "&u=" . $uid . "&c=" . $cid . "&sd=" . DateTimeFormat($sd, "d-m-Y") . "%2000:00:00&ed=" . DateTimeFormat($ed, "d-m-Y") . "%2023:59:00&from=s";
				
		closedb();

		if ($from == "s") {
			$handle = fopen('../savePDF/' . $nameXls, 'w+') or die('Cannot open file:  '.$nameXls);
			$data = file_get_contents("http://panorama.gps.mk/settings/" . $url);
			fwrite($handle, $data);
			fclose($handle);
			echo $nameXls;
		}


	}

	createXls();
	
?>
