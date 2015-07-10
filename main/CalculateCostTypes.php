<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php
 
    $newcost = getQUERY("newcost");
    
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
		
		for($i=0; $i < strlen($newcost); $i++) {
			if (strtolower($newcost[$i]) == 'g' && strtolower($newcost[$i+1]) == "j" || strtolower($newcost[$i]) == 'z' && strtolower($newcost[$i+1]) == "h" || strtolower($newcost[$i]) == 'd' && strtolower($newcost[$i+1]) == "z" || strtolower($newcost[$i]) == 'l' && strtolower($newcost[$i+1]) == "j" || strtolower($newcost[$i]) == "n" && strtolower($newcost[$i+1]) == "j" || strtolower($newcost[$i]) == 'k' && strtolower($newcost[$i+1]) == "j" || strtolower($newcost[$i]) == 'c' && strtolower($newcost[$i+1]) == "h" || strtolower($newcost[$i]) == 'd' && strtolower($newcost[$i+1]) == "j" || strtolower($newcost[$i]) == 's' && strtolower($newcost[$i+1]) == "h") {
				if ($i <> 0) $new .= str_replace($lat1, $cyr1, (strtolower($newcost[$i]) . "" . strtolower($newcost[$i+1])));
				else $new .= str_replace($lat1, $cyr1, (strtoupper($newcost[$i]) . "" . strtoupper($newcost[$i+1])));	
				
				$i++;
			}
			else {
				if ($i <> 0) $new .= str_replace($lat, $cyr, strtolower($newcost[$i]));
				else $new .= str_replace($lat, $cyr, strtoupper($newcost[$i]));
			}
		}
		$newcost = $new;
	} else {
		$newcost = ucfirst($newcost);
	}
	
	opendb();
	$costStr = "";
    $costStr .= "<option id='0' value='0'>- " . dic_('Reports.ChooseCost') . " -</option>
                <option id='Fuel' value='F'>" . dic_('Reports.Fuel') . "</option>
                <option id='Service' value='S'>" . dic_('Fm.Service') . "</option>
                <option id='Cost' value='C'>" . dic_('Fm.OthCosts') . "</option>";
	
	$dsCosts = query("select * from fmcosts where clientid= " . session("client_id"));
	while ($drCosts = pg_fetch_array($dsCosts)) {
		if ($cLang == 'mk') $cost_ = $drCosts["costname"];
		else $cost_ = cyr2lat($drCosts["costname"]);

		if ($newcost == $drCosts["costname"])
			$costStr .= "<option id=" . $drCosts["id"] . " value='" . $cost_ . "' selected>" . $cost_ . "</option>";
		else 
			$costStr .= "<option id=" . $drCosts["id"] . " value='" . $cost_ . "' >" . $cost_ . "</option>";
	}
                           
    closedb();
	
    echo $costStr;
    exit();
    

?>
