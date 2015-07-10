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
		
	if ($q <> "") {
		//$txt1 = mb_strtolower($txt, 'UTF-8');	
			
		$dsCost = query("select * from (select *, 4 cnt from fmcosts
		UNION select 0 id, " . session("client_id") . " clientid, '" . dic_("Reports.Fuel") . "' costname, 1 cnt
		UNION select 0 id, " . session("client_id") . " clientid, '" . dic_("Fm.Service") . "' costname, 2 cnt
		UNION select 0 id, " . session("client_id") . " clientid, '" .  dic_("Fm.OthCosts") . "' costname, 3 cnt
		) s where lower(s.costname) like '%" . $q . "%'	or lower(s.costname) like '%" . $q1 . "%' and s.clientid=" . session("client_id") . " order by 4 asc, s.costname asc");
		//$cnt = 0;
		while ($drCost = pg_fetch_array($dsCost)) {
			$txt = mb_strtolower($drCost["costname"], 'UTF-8');
			$healthy1 = array($q, $q1);
			$yummy1 = array('##$$'.$q.'$$##', '@@$$'.$q1.'$$@@');
			$txt = str_replace($healthy1, $yummy1, $txt);
			$healthy2 = array('##$$', '$$##', '@@$$', '$$@@');
			$yummy2 = array('<b style="color: #FF0000">', '</b>', '<b style="color: #FF0000">', '</b>');
			$txt = str_replace($healthy2, $yummy2, $txt);
			$costName = $txt;
			
			//$colored = '<b style="color: #FF0000">' . $txt . '</b>';
			//$costName = str_replace(mb_strtolower($txt, 'UTF-8'), $colored, mb_strtolower($drCost["costname"], 'UTF-8'));
			
			if ($drCost["id"] == 0) {
		?>
				<a id="a-0<?php echo $drCost["cnt"]?>" class=""onmouseover="overDiv('0<?php echo $drCost["cnt"]?>')" onmouseout="outDiv('0<?php echo $drCost["cnt"]?>')" style="cursor:pointer; color:#2F5185; width:98%; display: inline-block;  float:left; padding-left:3px" onclick="">
					<span onclick="OnCLickCost('<?php echo $drCost["id"]?>')"><?php echo $costName?></span>
				</a>
				
				<br>
				<?php
				
			} else {
				?>
				<a id="a-<?php echo $drCost["id"]?>" class=""onmouseover="overDiv(<?php echo $drCost["id"]?>)" onmouseout="outDiv(<?php echo $drCost["id"]?>)" style="cursor:pointer; color:#2F5185; width:98%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickCost('<?php echo $drCost["id"]?>')"><?php echo $costName?></span><span id="x-<?php echo $drCost["id"]?>" onclick="deleteCost(<?php echo $drCost["id"]?>, '<?php echo $drCost["costname"]?>')" title="<?php echo dic_("Reports.DelCostType")?>" style="margin-right: 3px; margin-top: 2px; float:right; width: 9px; height: 9px; background-image: url('<?php echo $tpoint?>/images/x-mark1.png'); display:none;" />
				</a>
				
				<br>
				<?php
			}
		?>
		
		<!--div id="div-<?php echo $drCost["id"]?>" class="" style="cursor:pointer;" onmouseover="overDiv(<?php echo $drCost["id"]?>)" onmouseout="outDiv(<?php echo $drCost["id"]?>)"-->
			
		<!--/div-->
			
		<?php
		//$cnt++;
		}
	} else {
			
		$dsCost = query("select * from (select *, 4 cnt from fmcosts
		UNION select 0 id, " . session("client_id") . " clientid, '" . dic_("Reports.Fuel") . "' costname, 1 cnt
		UNION select 0 id, " . session("client_id") . " clientid, '" . dic_("Fm.Service") . "' costname, 2 cnt
		UNION select 0 id, " . session("client_id") . " clientid, '" .  dic_("Fm.OthCosts") . "' costname, 3 cnt
		) s where s.clientid=" . session("client_id") . " order by 4 asc, s.costname asc");
		
		//$cnt = 0;
		while ($drCost = pg_fetch_array($dsCost)) {
			if ($drCost["id"] == 0) {
				?>
				<a id="a-0<?php echo $drCost["cnt"]?>" class="" onmouseover="overDiv('0<?php echo $drCost["cnt"]?>')" onmouseout="outDiv('0<?php echo $drCost["cnt"]?>')" style="cursor:pointer; color:#2F5185; width:98%; display: inline-block;  float:left; padding-left:3px" onclick="">
					<span onclick="OnCLickCost('<?php echo $drCost["id"]?>')"><?php echo mb_strtolower($drCost["costname"], 'UTF-8')?></span>
				</a>
				
				<br>
				<?php
				
			} else {
				?>
				<a id="a-<?php echo $drCost["id"]?>" class="" onmouseover="overDiv(<?php echo $drCost["id"]?>)" onmouseout="outDiv(<?php echo $drCost["id"]?>)" style="cursor:pointer; color:#2F5185; width:98%; display: inline-block;  float:left; padding-left:3px" onclick="">
					<span onclick="OnCLickCost('<?php echo $drCost["id"]?>')"><?php echo mb_strtolower($drCost["costname"], 'UTF-8')?></span><span id="x-<?php echo $drCost["id"]?>" onclick="deleteCost(<?php echo $drCost["id"]?>, '<?php echo $drCost["costname"]?>')" title="<?php echo dic_("Reports.DelCostType")?>" style="margin-right: 3px; margin-top: 2px; float:right; width: 9px; height: 9px; background-image: url('<?php echo $tpoint?>/images/x-mark1.png'); display:none;" />
				</a>
				
				<br>
				<?php
			}
		?>
		
		<!--div id="div-<?php echo $drCost["id"]?>" class="" style="cursor:pointer;" onmouseover="overDiv(<?php echo $drCost["id"]?>)" onmouseout="outDiv(<?php echo $drCost["id"]?>)"-->
		<!--/div-->
		
		<?php
		//$cnt++;
		}
	}
	closedb();
?>
