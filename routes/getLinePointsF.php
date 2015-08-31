<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
	
	$_lon1 = getQUERY("lon1");
	$_lat1 = getQUERY("lat1");
	$_lon2 = getQUERY("lon2");
	$_lat2 = getQUERY("lat2");
    opendb();
	
	$cntItem = dlookup("select count(*) from line_history_fast where lon1='".$_lon1."' and lat1='" . $_lat1 . "' and lon2='" . $_lon2 . "' and lat2='" . $_lat2 . "'");
	if($cntItem > 0)
	{
		$dsLine = query("select id, linestr from line_history_fast where lon1='".$_lon1."' and lat1='" . $_lat1 . "' and lon2='" . $_lon2 . "' and lat2='" . $_lat2 . "'");
		print pg_fetch_result($dsLine, 0, "linestr") . '^$' . pg_fetch_result($dsLine, 0, "id");
	} else
	{
		//$line = getLineCoordsF($_lon1, $_lat1, $_lon2, $_lat2);
		$url = 'http://open.mapquestapi.com/directions/v2/route?key=Fmjtd%7Cluubn1682g%2C25%3Do5-90as5f&callback=renderAdvancedNarrative&outFormat=json&routeType=fastest&timeType=1&enhancedNarrative=false&maxLinkId=10000&shapeFormat=raw&generalize=0&locale=en_GB&unit=k&drivingStyle=2&highwayEfficiency=21.0&from=' . $_lat1 . ',' . $_lon1 . '&to=' . $_lat2 . ',' . $_lon2;
		$items = '';
		$obj = file_get_contents($url);
		$json = between('(', ')', $obj);
		$jsonData = rtrim($json, "\0");
		$results = json_decode($jsonData); 
		$dist = $results->route->distance;
		$time = $results->route->time;
		$lonlat =  $results->route->shape->shapePoints;
		for ($i = 0; $i < sizeof($lonlat); $i++) {
			$items .= "%@";
    		$items .= $lonlat[$i+1] . "#" . $lonlat[$i];
			$i++;
		}
		
		$fin = $items."^$".$dist."^$".$time;
		$_id = dlookup("insert into line_history_fast (lon1, lat1, lon2, lat2, linestr) values ('".$_lon1."','".$_lat1."','".$_lon2."','".$_lat2."','".$fin."') RETURNING id;");
		print $fin . '^$' . $_id;
	}
	function after ($this, $inthat)
    {
        if (!is_bool(strpos($inthat, $this)))
        return substr($inthat, strpos($inthat,$this)+strlen($this));
    };
	function before ($this, $inthat)
    {
        return substr($inthat, 0, strpos($inthat, $this));
    };
	function before_last ($this, $inthat)
    {
        return substr($inthat, 0, strrevpos($inthat, $this));
    };
	function between ($this, $that, $inthat)
    {
        return before_last ($that, after($this, $inthat));
    };
	function strrevpos($instr, $needle)
	{
	    $rev_pos = strpos (strrev($instr), strrev($needle));
	    if ($rev_pos===false) return false;
	    else return strlen($instr) - $rev_pos - strlen($needle);
	};
	closedb();
    
?>
