<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php 
       
    $locname = getQUERY("locname");
	$retlocname = getQUERY("locname");
	
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
		
		for($i=0; $i < strlen($locname); $i++) {
			if (strtolower($locname[$i]) == 'g' && strtolower($locname[$i+1]) == "j" || strtolower($locname[$i]) == 'z' && strtolower($locname[$i+1]) == "h" || strtolower($locname[$i]) == 'd' && strtolower($locname[$i+1]) == "z" || strtolower($locname[$i]) == 'l' && strtolower($locname[$i+1]) == "j" || strtolower($locname[$i]) == "n" && strtolower($locname[$i+1]) == "j" || strtolower($locname[$i]) == 'k' && strtolower($locname[$i+1]) == "j" || strtolower($locname[$i]) == 'c' && strtolower($locname[$i+1]) == "h" || strtolower($locname[$i]) == 'd' && strtolower($locname[$i+1]) == "j" || strtolower($locname[$i]) == 's' && strtolower($locname[$i+1]) == "h") {
				if ($i <> 0) $new .= str_replace($lat1, $cyr1, (strtolower($locname[$i]) . "" . strtolower($locname[$i+1])));
				else $new .= str_replace($lat1, $cyr1, (strtoupper($locname[$i]) . "" . strtoupper($locname[$i+1])));
				$i++;
			}
			else {
				if ($i <> 0) $new .= str_replace($lat, $cyr, strtolower($locname[$i]));
				else $new .= str_replace($lat, $cyr, strtoupper($locname[$i]));
				
			}
		}
		$retlocname = $new;
		$locname = $new;
		
	} else {
		$retlocname = $locname;
		$locname = ucfirst($locname);
	}
	
	$ifExist = dlookup("select count(*) from fmlocations where locationname='" . $locname . "' and clientid=" . Session("client_id"));
	
	if ($ifExist == 0) {
    	$idInsert = dlookup("INSERT INTO fmlocations (clientid, locationname) VALUES (" . Session("client_id") . ", '" . $locname . "') returning id");
		echo $idInsert . "-" . $retlocname;
	}
	else 
		echo 0;

    closedb();
?>
