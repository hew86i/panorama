<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
   	$poiid = getQUERY("poiid");
    
	opendb();
	
	//echo dlookup("select pp.id||'|'||pp.name||'|'||st_y(st_centroid(geom))||'|'||st_x(st_centroid(geom))||'|'||1 from pointsofinterest pp where id = " . $poiid);

	echo dlookup("(select PP.ID||'|'||PP.Name||'|'||st_y(st_centroid(geom))||'|'||st_x(st_centroid(geom))||'|'||PP.type from pointsofinterest PP 
 where pp.active='1' and (PP.type=3 or PP.type=2) and PP.ID in (".$poiid.")) union 
 (select PP.ID||'|'||PP.Name||'|'||ST_X(ST_Transform(pp.geom,4326))||'|'||ST_Y(ST_Transform(pp.geom,4326))||'|'||PP.type 
 from pointsofinterest PP where pp.active='1' and PP.type=1 
 and PP.ID in (".$poiid.")) order by 1");

	closedb();
?>
