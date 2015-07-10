<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	
	opendb();
	
	$imePraznik = str_replace("'", "''", NNull($_GET['tipPraznik'], ''));
	
			
	$proverka = query("select * from companydaysholiday where clientid = " . Session("client_id"));
	
	if(pg_num_rows($proverka)==0)
	{
		
		$vnes = query("insert into companydaysholiday(id,clientid,nameholiday,holidayid) values(1," . Session("client_id").",N'" . $imePraznik . "',1)");	
	
	}
	else
	{
			
		$posledno = dlookup("select Max(id)+1 from companydaysholiday");
		$praznikID = dlookup("select Max(holidayid)+1 from companydaysholiday");	
	   	$vnes = query("insert into companydaysholiday(id,clientid,nameholiday,holidayid) values('" . $posledno . "'," . Session("client_id").",N'" . $imePraznik . "','" . $praznikID . "')");                           
	
	}
	closedb();
?>