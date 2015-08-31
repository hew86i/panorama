<?php ob_start(); ?>
<?php 	header("Content-type: text/html; charset=utf-8"); ?>
<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php

	if (!is_numeric(session('user_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
	$clientid = session("client_id");
	
	$q = getQUERY("q");
	
	$q1 = $q;
	$healthy = array("a", "b", "v", "g", "d", "g", "e", "z", "z", "dz", "i", "j", "k", "l", "lj", "m", "n", "nj", "o", "p", "r", "s", "t", "k", "u", "f", "h", "c", "c", "gz", "s");
	$yummy   = array("а", "б", "в", "г", "д", "ѓ", "е", "ж", "з", "ѕ", "и", "ј", "к", "л", "љ", "м", "н", "њ", "о", "п", "р", "с", "т", "ќ", "у", "ф", "х", "ц", "ч", "џ", "ш");
	
	$q1 = mb_strtolower($q1, 'UTF-8');
	$q1 = str_replace($healthy, $yummy, $q1);
	
	$q = mb_strtolower($q, 'UTF-8');
	$q = str_replace($yummy, $healthy, $q);
	
	opendb();
	
	// Vraboteni
	// vaka treba
	//$allowedUsers = "-1,".dlookup("select getmembers(".session("user_id").", ".$wsid.")");
	
	//ama sega privremeno ke bide
	//$allowedUsers = "select userid from members where wsid=".$wsid." union all select ".session("user_id")." userid";
	
	$srcStringUser = "(select id, name fullname, type, ST_Y(ST_Transform(geom,4326)) latitude, ST_X(ST_Transform(geom,4326)) longitude "; 
	$srcStringUser .= "from pointsofinterest where type=1 and active='1' and (lower(name) like '%".$q."%' or lower(name) like '%".$q1."%') and clientid=".$clientid." order by fullname) ";
	$srcStringUser .= "union ";
	$srcStringUser .= "(select id, name fullname, type, st_x(st_centroid(geom)) latitude, st_y(st_centroid(geom)) longitude "; 
	$srcStringUser .= "from pointsofinterest where type=2 and active='1' and (lower(name) like '%".$q."%' or lower(name) like '%".$q1."%') and clientid=".$clientid." order by fullname) ";
	$srcStringUser .= "union ";
	$srcStringUser .= "(select id, name fullname, type, st_x(st_centroid(geom)) latitude, st_y(st_centroid(geom)) longitude "; 
	$srcStringUser .= "from pointsofinterest where type=3 and active='1' and (lower(name) like '%".$q."%' or lower(name) like '%".$q1."%') and clientid=".$clientid." order by fullname) ";
	
	//$srcStringUser = "select id, name fullname, type, ST_Y(ST_Transform(geom,4326)) latitude, ST_X(ST_Transform(geom,4326)) longitude from pointsofinterest where type=1 and (lower(name) like '%".$q."%' or lower(name) like '%".$q1."%') and clientid=".$clientid." order by fullname";
	$srcStringUserCount = "select count(*)  from pointsofinterest where (lower(name) like '%".$q."%' or lower(name) like '%".$q1."%') and clientid=".$clientid."";
	
	$cntPOI = dlookup($srcStringUserCount);
	if ($cntPOI>0){
		$dsUser = query($srcStringUser);
		$red = 0;
		while($row = pg_fetch_array($dsUser)){
			$valparse = $row["id"] . '|' . $row["fullname"]. '|' . $row["longitude"] . '|' . $row["latitude"] . '|' . $row["type"];
			$red = $red + 1;
			$txt = $row["fullname"];
			if($row["type"].'' == '1')
				$photo = 'poiButton';
			else
				if($row["type"].'' == '2')
					$photo = 'zoneButton';
				else
					if($row["type"].'' == '3')
						$photo = 'zoneButton';
			$healthy1 = array($q, $q1);
			//<b style="color: #FF0000">
			$yummy1 = array('##$$'.$q.'$$##', '@@$$'.$q1.'$$@@');
			$txt = str_replace($healthy1, $yummy1, $txt);
			$healthy2 = array('##$$', '$$##', '@@$$', '$$@@');
			$yummy2 = array('<b style="color: #FF0000">', '</b>', '<b style="color: #FF0000">', '</b>');
			$txt = str_replace($healthy2, $yummy2, $txt);
			?>
			<a onclick="putNewMarker('<?=$row["id"]?>')" class="kiklop-list-item" style="display: inline-block;">
				<input id="<?=$row["id"]?>" type="hidden" value="<?=$valparse?>" />
				<span style="margin-top:0px; margin-right:5px; background-color:#FFFFFF; background-image: url(../images/<?=$photo?>.png); background-size:100%" class="tfm-teams cornerBig">&nbsp;</span>
				<?=$txt?>
			</a>
			<?php
		}	
	}


	if ($cntPOI==0){
?>
<a class="list-item" style="color:#a1a1a1">
		<span onclick="" class="MyListInner" style="width:95%"><?=dic("No results were found for searched criteria")?> !</span>		
</a>

<?php
	}
	closedb();
?>
<script>
	//debugger;
	//for each (var item in $(".search-item").children()) {
	  
	//}
	//var tt= $(".search-item").get(0).offsetLeft
	//$(".MyListInner").scrollTo(0,$(".MyListInner").get(0).offsetLeft)
	
</script>
