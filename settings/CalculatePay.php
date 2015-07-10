<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<?php
 
    $driverID = nnull(getQUERY("driID"), "");
    
	opendb();
	$payStr = "";
	$payStr .= "<option value='g'>Готово</option>";
    $payStr .= "<option value='f'>Фактура</option>";
    
	if ($driverID != "")            	
 		$cntCards = dlookup("select count(*) from drivercard where driverid= " . $driverID);
	else 
		$cntCards = 0;
		
	if ($cntCards > 0) {
		$dsCards = query("select * from drivercard where driverid= " . $driverID);
		while ($drCards = pg_fetch_array($dsCards)) {
			$nameCard = dlookup("select cardname from clubcards where id=" . $drCards["cardid"] . " order by cardname asc");   
			$cardID = $drCards["cardid"];
		//$payStr .= "<option value='k-" . $cardID . "' selected='selected'>" . $nameCard . "</option>";
		$payStr .= "<option value='k-" . $cardID . "' >" . $nameCard . "</option>";
		}
	} else {
		$dsCards = query("select * from clubcards where clientid= " . session("client_id") . " order by id asc");
		while ($drCards = pg_fetch_array($dsCards)) {
			$cardID = $drCards["id"];
			$payStr .= "<option value='k-" . $cardID . "'>" . $drCards["cardname"] . "</option>";
		}
	}
                           
    closedb();
	
    echo $payStr;
    exit();
    

?>