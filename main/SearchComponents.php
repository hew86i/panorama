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
	
    $txt = str_replace("'", "''", NNull($_GET['txt'], ''));
	$tpoint = str_replace("'", "''", NNull($_GET['tpoint'], ''));
	$selComp = str_replace("'", "''", NNull($_GET['selComp'], "0,"));
	$selComp = substr($selComp, 0, -1);
		
	if ($txt <> "") {
		$txt1 = mb_strtolower($txt, 'UTF-8');			
		$dsComp = query("select * from fmcomponents where lower(componentname) like '%" . $txt1 . "%' and id not in (" . $selComp . ") and clientid=" . session("client_id"));
	
		while ($drComp = pg_fetch_array($dsComp)) {
			$colored = '<b style="color: #FF0000">' . $txt . '</b>';
			$compName = str_replace(mb_strtolower($txt, 'UTF-8'), $colored, mb_strtolower($drComp["componentname"], 'UTF-8'));
		?>
		
		<!--div id="div-<?php echo $drComp["id"]?>" class="" style="cursor:pointer;" onmouseover="overDiv(<?php echo $drComp["id"]?>)" onmouseout="outDiv(<?php echo $drComp["id"]?>)"-->
			<a id="a-<?php echo $drComp["id"]?>" class=""onmouseover="overDiv(<?php echo $drComp["id"]?>)" onmouseout="outDiv(<?php echo $drComp["id"]?>)" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickComp('<?php echo $drComp["id"]?>')"><?php echo $compName?></span><span id="x-<?php echo $drComp["id"]?>" onclick="deleteComp(<?php echo $drComp["id"]?>)" title="<?php echo dic_("Reports.DelComp1")?>" style="margin-right: 3px; margin-top: 2px; float:right; width: 9px; height: 9px; background-image: url('<?php echo $tpoint?>/images/x-mark1.png'); display:none;" />
			</a>
			
			<br>
		<!--/div-->
				
		<?php
		}
	} else {
		$dsComp = query("select * from fmcomponents where id not in (" . $selComp . ") and clientid=" . session("client_id"));
		while ($drComp = pg_fetch_array($dsComp)) {
		?>
		
		<!--div id="div-<?php echo $drComp["id"]?>" class="" style="cursor:pointer;" onmouseover="overDiv(<?php echo $drComp["id"]?>)" onmouseout="outDiv(<?php echo $drComp["id"]?>)"-->
			<a id="a-<?php echo $drComp["id"]?>" class="" onmouseover="overDiv(<?php echo $drComp["id"]?>)" onmouseout="outDiv(<?php echo $drComp["id"]?>)" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickComp('<?php echo $drComp["id"]?>')"><?php echo mb_strtolower($drComp["componentname"], 'UTF-8')?></span><span id="x-<?php echo $drComp["id"]?>" onclick="deleteComp(<?php echo $drComp["id"]?>)" title="<?php echo dic_("Reports.DelComp1")?>" style="margin-right: 3px; margin-top: 2px; float:right; width: 9px; height: 9px; background-image: url('<?php echo $tpoint?>/images/x-mark1.png'); display:none;" />
			</a>
			
			<br>
		<!--/div-->
		
		<?php
		}
	}
	closedb();
?>