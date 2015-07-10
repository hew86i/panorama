<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php 
       
    $newcost = getQUERY("newcost");
	$retnewcost = getQUERY("newcost");
	opendb();
	
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
		$retnewcost = $new;
		$newcost = $new;
		
	} else {
		$retnewcost = $newcost;
		$newcost = ucfirst($newcost);
		
	}
	//echo $newcost;
	
	$ifExist = dlookup("select count(*) from fmcosts where costname='" . $newcost . "' and clientid=" . Session("client_id"));
	
	if ($ifExist == 0) {
		
    	$idInsert = dlookup("INSERT INTO fmcosts (clientid, costname) VALUES (" . Session("client_id") . ", '" . $newcost . "') returning id");
		echo $idInsert . "-" . $retnewcost;
	}
	else 
		echo 0;
	
    closedb();
?>
