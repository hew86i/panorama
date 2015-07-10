<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php
 
    $compname = getQUERY("compname");
    
	if ($cLang == "mk") {
		$new = "";
		$cyr  = array('а','б','в','г','д','ѓ','е','ж','з','ѕ','и','ј','к','л','љ','м','н','њ','о','п','р','с','т','ќ','у','ф','х','ц','ч','џ','ш',
		'А','Б','В','Г','Д','Ѓ','Е','Ж','З','Ѕ','И','Ј','К','Л','Љ','М','Н','Њ','О','П','Р','С','Т','Ќ','У','Ф','Х','Ц','Ч','Џ','Ш');
		$lat = array('a','b','v','g','d','gj','e','zh','z','dz','i','j','k','l','lj','m','n','nj','o','p','r','s','t','kj','u','f','h','c','ch','dj','sh',
		'A','B','V','G','D','DJ','E','ZH','Z','DZ','I','J','K','L','LJ','M','N','NJ','O','P','R','S','T','KJ','U','F','H','C','CH','DJ','SH');
		
		$cyr1  = array('ѓ','ж','ѕ','љ','њ','ќ','ч','џ','ш',
		'Ѓ','Ж','Ѕ','Љ','Њ','Ќ','Ч','Џ','Ш');
		$lat1 = array('gj','zh','dz', 'lj', 'nj','kj', 'ch','dj','sh',
		'DJ','ZH','DZ','LJ','NJ','KJ','CH','DJ','SH');
		
		$low = array('а','б','в','г','д','ѓ','е','ж','з','ѕ','и','ј','к','л','љ','м','н','њ','о','п','р','с','т','ќ','у','ф','х','ц','ч','џ','ш');
		$upper = array('А','Б','В','Г','Д','Ѓ','Е','Ж','З','Ѕ','И','Ј','К','Л','Љ','М','Н','Њ','О','П','Р','С','Т','Ќ','У','Ф','Х','Ц','Ч','Џ','Ш');
		
		for($i=0; $i < strlen($compname); $i++) {
			if (strtolower($compname[$i]) == 'g' && strtolower($compname[$i+1]) == "j" || strtolower($compname[$i]) == 'z' && strtolower($compname[$i+1]) == "h" || strtolower($compname[$i]) == 'd' && strtolower($compname[$i+1]) == "z" || strtolower($compname[$i]) == 'l' && strtolower($compname[$i+1]) == "j" || strtolower($compname[$i]) == "n" && strtolower($compname[$i+1]) == "j" || strtolower($compname[$i]) == 'k' && strtolower($compname[$i+1]) == "j" || strtolower($compname[$i]) == 'c' && strtolower($compname[$i+1]) == "h" || strtolower($compname[$i]) == 'd' && strtolower($compname[$i+1]) == "j" || strtolower($compname[$i]) == 's' && strtolower($compname[$i+1]) == "h") {
				if ($i <> 0) $new .= str_replace($lat1, $cyr1, (strtolower($compname[$i]) . "" . strtolower($compname[$i+1])));
				else $new .= str_replace($lat1, $cyr1, (strtoupper($compname[$i]) . "" . strtoupper($compname[$i+1])));
				$i++;
			}
			else {
				if ($i <> 0) $new .= str_replace($lat, $cyr, strtolower($compname[$i]));
				else $new .= str_replace($lat, $cyr, strtoupper($compname[$i]));
			}
		}
		$compname = $new;
	} else {
		$compname = ucfirst($compname);
	}
	
		
	opendb();
	$compStr = "";
    $compid = dlookup("select id from fmcomponents where componentname = '" . $compname . "' and clientid=" . session("client_id"));
	//$dsComponents = query("select * from fmcomponents where clientid= " . session("client_id"));
	//while ($drComponents = pg_fetch_array($dsComponents)) {
		//if ($compname == $drComponents["componentname"])
		//	$compStr .= "<option value='" . $drComponents["componentname"] . "' selected>" . $drComponents["componentname"] . "</option>";
		//else 
			//$compStr .= "<li style='height:22px'><strong>+</strong> " . $compname . "</li>";
			$compStr .= "<li id='li-" . $compid . "' value='li-" . $compid . "' style='width:135px; margin:2px; height:15px; padding-left:6px; padding-right:6px; cursor:pointer'
			 onmouseover='over1(" .  $compid. ")' onmouseout='out1(" .  $compid. ")' 
			 onclick='clickminus(" .  $compid. ")'>
			 <div class='comp' title='" . $compname . "'><strong><span id='span-" . $compid . "'>-</span></strong> " . $compname . "</div></li>";
	//}
                           
    closedb();
	
    echo $compStr;
    exit();
    

?>