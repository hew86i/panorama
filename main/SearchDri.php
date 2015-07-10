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
	$ifDriver = str_replace("'", "''", NNull($_GET['ifDriver'], ''));
	$vehID_ = str_replace("'", "''", NNull($_GET['vehid'], ''));
		
	if ($q <> "") {
		//$txt1 = mb_strtolower($txt, 'UTF-8');		
		
		if ($ifDriver > 0) {
            $drivers = "select * from drivers where id in (select driverid from vehicledriver where vehicleid=" . $vehID_ . ") and (lower(fullname) like '%" . $q . "%' or lower(fullname) like '%" . $q1 . "%') order by fullname asc";
		} else {
			$drivers = "select * from drivers where clientid=" . session("client_id") . " and (lower(fullname) like '%" . $q . "%' or lower(fullname) like '%" . $q1 . "%') order by fullname asc";
		}
       
        $dsDrivers = query($drivers);
		$firstDriver = pg_fetch_result($dsDrivers, 0, "id");
		
		while ($drDrivers = pg_fetch_array($dsDrivers)) {
			$txt = mb_strtolower($drDrivers["fullname"], 'UTF-8');
			$healthy1 = array($q, $q1);
			$yummy1 = array('##$$'.$q.'$$##', '@@$$'.$q1.'$$@@');
			$txt = str_replace($healthy1, $yummy1, $txt);
			$healthy2 = array('##$$', '$$##', '@@$$', '$$@@');
			$yummy2 = array('<b style="color: #FF0000">', '</b>', '<b style="color: #FF0000">', '</b>');
			$txt = str_replace($healthy2, $yummy2, $txt);
			$costName = $txt;
			   
			//$colored = '<b style="color: #FF0000">' . $txt . '</b>';
			//$costName = str_replace(mb_strtolower($txt, 'UTF-8'), $colored, mb_strtolower($drDrivers["fullname"], 'UTF-8'));
			
				?>
				<a id="a-<?php echo $drDrivers["id"]?>" class=""onmouseover="overDiv(<?php echo $drDrivers["id"]?>)" onmouseout="outDiv(<?php echo $drDrivers["id"]?>)" style="cursor:pointer; color:#2F5185; width:98%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickDri('<?php echo $drDrivers["id"]?>')"><?php echo $costName?></span>
				</a>
				
				<br>
				<?php
       } //end while
       
	} else {
	
		if ($ifDriver > 0) {
            $drivers = "select * from drivers where id in (select driverid from vehicledriver where vehicleid=" . $vehID_ . ") order by fullname asc";
		} else {
			$drivers = "select * from drivers where clientid=" . session("client_id") . " order by fullname asc";
		}
      
        $dsDrivers = query($drivers);
		$firstDriver = pg_fetch_result($dsDrivers, 0, "id");
		
		while ($drDrivers = pg_fetch_array($dsDrivers)) {   
			$costName = mb_strtolower($drDrivers["fullname"], 'UTF-8');		
				?>
				<a id="a-<?php echo $drDrivers["id"]?>" class=""onmouseover="overDiv(<?php echo $drDrivers["id"]?>)" onmouseout="outDiv(<?php echo $drDrivers["id"]?>)" style="cursor:pointer; color:#2F5185; width:98%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickDri('<?php echo $drDrivers["id"]?>')"><?php echo $costName?></span>
				</a>
				
				<br>
				<?php
       } //end while
       
	}
	closedb();
?>
