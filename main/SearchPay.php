<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<script>
		lang = '<?php echo $cLang?>'
</script>
	
<?php

	opendb();
	
	$q = getQUERY("txt");
	$q1 = $q;
	$yummy  = array('а','б','в','г','д','ѓ','е','ж','з','ѕ','и','ј','к','л','љ','м','н','њ','о','п','р','с','т','ќ','у','ф','х','ц','ч','џ','ш');
	$healthy = array('a','b','v','g','d','gj','e','zh','z','dz','i','j','k','l','lj','m','n','nj','o','p','r','s','t','kj','u','f','h','c','ch','dj','sh');
	
	$q1 = mb_strtolower($q1, 'UTF-8');
	$q1 = str_replace($healthy, $yummy, $q1);
	
	$q = mb_strtolower($q, 'UTF-8');
	$q = str_replace($yummy, $healthy, $q);
	
	
    //$txt = str_replace("'", "''", NNull($_GET['txt'], ''));
	$tpoint = str_replace("'", "''", NNull($_GET['tpoint'], ''));
	$selCost = str_replace("'", "''", NNull($_GET['selCost'], "0,"));
	$selCost = substr($selCost, 0, -1);
	$driId = str_replace("'", "''", NNull($_GET['driId'], ''));	
	

	/*$txt_ = $txt;
	$healthy = array("a", "b", "v", "g", "d", "g", "e", "z", "z", "dz", "i", "j", "k", "l", "lj", "m", "n", "nj", "o", "p", "r", "s", "t", "k", "u", "f", "h", "c", "c", "gz", "s");
	$yummy   = array("а", "б", "в", "г", "д", "ѓ", "е", "ж", "з", "ѕ", "и", "ј", "к", "л", "љ", "м", "н", "њ", "о", "п", "р", "с", "т", "ќ", "у", "ф", "х", "ц", "ч", "џ", "ш");
	$txt_ = mb_strtolower($txt_, 'UTF-8');
	$txt_ = str_replace($healthy, $yummy, $txt_);
	$txt = mb_strtolower($txt, 'UTF-8');
	$txt = str_replace($yummy, $healthy, $txt);*/
	
	
	if ($q <> "") {
		//$txt1 = mb_strtolower($txt, 'UTF-8');		
		
		$cntCards = dlookup("select count(*) from drivercard where driverid= " . $driId);	
			
		if ($cntCards > 0) {					
			$dsCards = query("select * from (select cardid id, (select cardname from clubcards where id=cardid) cardname, driverid, 4 
			from drivercard UNION select 0 id, '" . dic_("Reports.Cash") . "' cardname, " . $driId . ", 1 
			UNION select 0 id, '" . dic_("Reports.Invoice") . "' cardname, " . $driId . ", 2 ) s 
			where (lower(s.cardname) like '%" . $q . "%' or lower(s.cardname) like '%" . $q1 . "%') and s.driverid= " . $driId . " order by 4, id asc");
		} else {
			$dsCards = query("select * from (select *, 4 from clubcards 
			UNION select 0 id, '" . dic_("Reports.Cash") . "' cardname, " . session("client_id") . ", 1
			UNION select 0 id, '" . dic_("Reports.Invoice") . "' cardname, " . session("client_id") . ", 2
			) s where (lower(s.cardname) like '%" . $q . "%'	or lower(s.cardname) like '%" . $q1 . "%') and s.clientid= " . session("client_id") . " order by 4, id asc");
		}
		
		$cnt = 0;
		while ($drCard = pg_fetch_array($dsCards)) {
			$txt = mb_strtolower($drCard["cardname"], 'UTF-8');
			$healthy1 = array($q, $q1);
			$yummy1 = array('##$$'.$q.'$$##', '@@$$'.$q1.'$$@@');
			$txt = str_replace($healthy1, $yummy1, $txt);
			$healthy2 = array('##$$', '$$##', '@@$$', '$$@@');
			$yummy2 = array('<b style="color: #FF0000">', '</b>', '<b style="color: #FF0000">', '</b>');
			$txt = str_replace($healthy2, $yummy2, $txt);
			$cardName = $txt;
						
			//$colored = '<b style="color: #FF0000">' . $txt . '</b>';
			//$colored_ = '<b style="color: #FF0000">' . $txt_ . '</b>';
			
			/*$cardName = str_replace(mb_strtolower($txt, 'UTF-8'), $colored, mb_strtolower($drCard["cardname"], 'UTF-8'));
			$cardName = str_replace(mb_strtolower($txt_, 'UTF-8'), $colored_, $cardName);
			echo $cardName;
			exit;*/
			if ($drCard["id"] == 0) {
			?>
			<a id="a-x<?php echo $cnt?>" class="" onmouseover="overDiv('x<?php echo $cnt?>')" onmouseout="outDiv('x<?php echo $cnt?>')" style="cursor:pointer; color:#2F5185; width:98%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickPay('<?php echo $drCard["id"]?>')"><?php echo $cardName?></span>
			</a>
			<br>
			<?php	
			
			} else {
			?>
			<a id="a-<?php echo $drCard["id"]?>" class="" onmouseover="overDiv('<?php echo $drCard["id"]?>')" onmouseout="outDiv('<?php echo $drCard["id"]?>')" style="cursor:pointer; color:#2F5185; width:98%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickPay('<?php echo $drCard["id"]?>')"><?php echo $cardName?></span>
			</a>
			<br>
			<?php	
			}
		?>
			
		<?php
		$cnt ++;
		}
	} else {	
		$cntCards = dlookup("select count(*) from drivercard where driverid= " . $driId);
		if ($cntCards > 0) {
			$dsCards = query("select * from (select cardid id, (select cardname from clubcards where id=cardid) cardname, driverid, 4 
			from drivercard UNION select 0 id, '" . dic_("Reports.Cash") . "' cardname, " . $driId . ", 1 
			UNION select 0 id, '" . dic_("Reports.Invoice") . "' cardname, " . $driId . ", 2 ) s 
			where s.driverid= " . $driId . " order by 4, id asc");
		} else {
			$dsCards = query("select * from (select *, 4 from clubcards 
			UNION select 0 id, '" . dic_("Reports.Cash") . "' cardname, " . session("client_id") . ", 1
			UNION select 0 id, '" . dic_("Reports.Invoice") . "' cardname, " . session("client_id") . ", 2
			) s where s.clientid= " . session("client_id") . " order by 4, id asc");
		}
		
		$cnt = 0;	
		while ($drCard = pg_fetch_array($dsCards)) {
			if ($drCard["id"] == 0) {
			?>
			<a id="a-x<?php echo $cnt?>" class="" onmouseover="overDiv('x<?php echo $cnt?>')" onmouseout="outDiv('x<?php echo $cnt?>')" style="cursor:pointer; color:#2F5185; width:98%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickPay('<?php echo $drCard["id"]?>')"><?php echo mb_strtolower($drCard["cardname"], 'UTF-8')?></span>
			</a>
			<br>
			<?php	
			
			} else {
			?>
			<a id="a-<?php echo $drCard["id"]?>" class="" onmouseover="overDiv('<?php echo $drCard["id"]?>')" onmouseout="outDiv('<?php echo $drCard["id"]?>')" style="cursor:pointer; color:#2F5185; width:98%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickPay('<?php echo $drCard["id"]?>')"><?php echo mb_strtolower($drCard["cardname"], 'UTF-8')?></span>
			</a>
			<br>
			<?php	
			}
		?>
			
		<?php
		$cnt ++;
		}
	}
	closedb();
?>
