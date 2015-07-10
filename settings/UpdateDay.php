<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php


	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	$imePraznik = str_replace("'", "''", NNull($_GET['imePraznik'], ''));
	$tipDen = str_replace("'", "''", NNull($_GET['tipDen'], ''));
	
	$color = str_replace("'", "''", NNull($_GET['boja'], ''));  
	$tipPraznik = str_replace("'", "''", NNull($_GET['tipPraznik'], ''));
		
	opendb();	
	$datum = DateTimeFormat(dlookup("select datum from companydays where id = " . $id), 'Y-m-d');
	//$den = str_replace("'", "''", NNull($_GET['den'], ''));
	$den = dlookup("select getdayofweek(cast('".$datum."' as date))");	

	
	/*$dayCheck1=dlookup("SELECT count(*) FROM companydays WHERE datum = ". $datum ." and clientid = " . Session("client_id")."and id not in (select id from companydays where id=" . $id . ")");
	
	if($dayCheck1>0)
	{
		echo 1;
	}
	else 
	{*/
		if($tipDen==8)
		{
			$updt = query("update companydays set dayname = '" . $imePraznik . "', typeofday='" . $den . "', datum='" . $datum . "',companyholiday='" . $tipDen . "',cellcolor='#" . $color . "',typeofholiday='" . $tipPraznik . "'  where id = " . $id . "  and clientid = " . Session("client_id"));
		}
		else
		{
			$updt = query("update companydays set dayname = '" . $imePraznik . "', typeofday='" . $den . "', datum='" . $datum . "',companyholiday='" . $tipDen . "',cellcolor='#" . $color . "',typeofholiday='0'  where id = " . $id . "  and clientid = " . Session("client_id"));	
		}
	//}
    closedb();
?>


