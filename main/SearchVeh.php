<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>	
<?php

	opendb();
	
    //$txt = mb_strtoupper(str_replace("'", "''", NNull(urldecode($_GET['txt']), '')), 'UTF-8'); //str_replace("%20%", " ", $_GET['txt']);//'(1) SK-0001-AB';//str_replace("'", "''", NNull($_GET['txt'], ''));
	$q = urldecode($_GET['txt']);
	$q1 = $q;
	$yummy  = array('а','б','в','г','д','ѓ','е','ж','з','ѕ','и','ј','к','л','љ','м','н','њ','о','п','р','с','т','ќ','у','ф','х','ц','ч','џ','ш');
	$healthy = array('a','b','v','g','d','gj','e','zh','z','dz','i','j','k','l','lj','m','n','nj','o','p','r','s','t','kj','u','f','h','c','ch','dj','sh');
	
	$q1 = mb_strtolower($q1, 'UTF-8');
	$q1 = str_replace($healthy, $yummy, $q1);
	
	$q = mb_strtolower($q, 'UTF-8');
	$q = str_replace($yummy, $healthy, $q);	
		
	$tpoint = str_replace("'", "''", NNull($_GET['tpoint'], ''));
	$selCost = str_replace("'", "''", NNull($_GET['selCost'], "0,"));
	$selCost = substr($selCost, 0, -1);
		
	if ($q <> "") {
		//$txt1 = trim($txt);	
		//$txt2 = '%'.trim($txt).'%';			
		$dsVeh1 = query("select * from vehicles where clientid = " . session("client_id") . " 
		and (lower('(' || code || ') ' || registration) like '%".trim($q)."%' or lower('(' || code || ') ' || registration) like '%".trim($q1)."%') order by cast(code as integer) asc");
								
		while ($drVeh = pg_fetch_array($dsVeh1)) {		
			$txt = mb_strtolower('(' . $drVeh["code"] . ') ' . $drVeh["registration"], 'UTF-8');
			$healthy1 = array($q, $q1);
			$yummy1 = array('##$$'.$q.'$$##', '@@$$'.$q1.'$$@@');
			$txt = str_replace($healthy1, $yummy1, $txt);
			$healthy2 = array('##$$', '$$##', '@@$$', '$$@@');
			$yummy2 = array('<b style="color: #FF0000">', '</b>', '<b style="color: #FF0000">', '</b>');
			$txt = str_replace($healthy2, $yummy2, $txt);
						
			$costName = mb_strtoupper($txt, 'UTF-8');
			
			//$colored = '<b style="color: #FF0000">' . $txt1 . '</b>';
			//$costName = str_replace($txt1, $colored, "(" . $drVeh["code"] . ") " . $drVeh["registration"]);
		?>
				<a id="a-v<?php echo $drVeh["id"]?>" class="" onmouseover="overDiv('v<?php echo $drVeh["id"]?>')" onmouseout="outDiv('v<?php echo $drVeh["id"]?>')" style="cursor:pointer; color:#2F5185; width:98%; display: inline-block;  float:left; padding-left:3px" onclick="">
					<span onclick="OnCLickVeh('<?php echo $drVeh["id"]?>')"><?php echo $costName?></span>
				</a>
				
				<br>

			
		<?php
		}
	} else {
			
		$dsVeh1 = query("select * from vehicles where clientid = " . session("client_id") . " order by cast(code as integer) asc");
		while ($drVeh = pg_fetch_array($dsVeh1)) {
		?>
				<a id="a-v<?php echo $drVeh["id"]?>" class="" onmouseover="overDiv('v<?php echo $drVeh["id"]?>')" onmouseout="outDiv('v<?php echo $drVeh["id"]?>')" style="cursor:pointer; color:#2F5185; width:98%; display: inline-block;  float:left; padding-left:3px" onclick="">
					<span onclick="OnCLickVeh('<?php echo $drVeh["id"]?>')">(<?php echo $drVeh["code"]?>) <?php echo $drVeh["registration"]?></span>
				</a>
				
				<br>
				<?php
		?>
		
		<!--div id="div-<?php echo $drCost["id"]?>" class="" style="cursor:pointer;" onmouseover="overDiv(<?php echo $drCost["id"]?>)" onmouseout="outDiv(<?php echo $drCost["id"]?>)"-->
		<!--/div-->
		
		<?php
		}
	}
	closedb();
?>