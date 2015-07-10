<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php

	opendb();
	
	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	$ime = str_replace("'", "''", NNull($_GET['name'], ''));
	$prezime = str_replace("'", "''", NNull($_GET['lastname'], ''));
	$email = str_replace("'", "''", NNull($_GET['email'], ''));
	$telefon = str_replace("'", "''", NNull($_GET['phone'], ''));
	$username = str_replace("'", "''", NNull($_GET['username'], ''));
	$pomosno = str_replace("'", "''", NNull($_GET['pomosno'], ''));
	
	$userCheck=dlookup("SELECT count(*) FROM users WHERE username = '" . $username. "' and username not in (select username from users where id=" . $id . ")");
	
	if($userCheck > 0)
	{
		echo 1;
	}
	elseif($pomosno==1)
	{
		$password = str_replace("'", "''", NNull($_GET['passwordstar'], ''));
		$updt = query("update users set fullname = '" . $ime . " ". $prezime ."', username='" . $username . "', password='" . $password . "', email='" . $email . "', phone = '".$telefon."'  where id = " . $id . "  and clientid = " . Session("client_id"));
    	print $id;
	}
	else
	{
		$passwordNov = str_replace("'", "''", NNull($_GET['passwordNov'], ''));
		$updt = query("update users set fullname = '" . $ime . " ". $prezime ."', username='" . $username . "', password='" . $passwordNov . "', email='" . $email . "', phone = '".$telefon."'  where id = " . $id . "  and clientid = " . Session("client_id"));
    	print $id;
	}
    closedb();
?>