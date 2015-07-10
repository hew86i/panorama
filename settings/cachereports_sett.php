<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php
	
	opendb();
	
	$cid = getQUERY("cid");
	$clienttypeid = dlookup("select clienttypeid from clients where id = " . $cid);
	$holidays = nnull(getQUERY("holidays") , '');
	
	if ($holidays == 1) {
		$dsNonworkingdays = query("select * from nonworkingdays where active='1' and datetime between '".DateTimeFormat(now(), 'Y') . '-01-01'." 00:00:00' and '".DateTimeFormat(now(), 'Y') . '-12-31'." 23:59:59'");
		while ($drHoliday = pg_fetch_array($dsNonworkingdays)) {
			$sdH = DateTimeFormat($drHoliday["datetime"], 'Y-m-d 00:00:00');
			$edH = DateTimeFormat($drHoliday["datetime"], 'Y-m-d 23:59:59');
			
			//$r = runsql("insert into test1(lastitem, dt) values ('".$sdH . " - ".$edH . "', '1900-01-01')");
			$ret = query("select cachereportsparams('".$sdH."', '".$edH."', ' clientid = ".$cid."')");
						
			if ($clienttypeid == 2) {
				$ret = query("select cachetaxiparams1('".$sdH."', '".$edH."', ' clientid = ".$cid."')");
				$ret = query("select cachetaxiparams2('".$sdH."', '".$edH."', ' clientid = ".$cid."')");
			}
		}
	} else {
		$date = nnull(getQUERY("date") , '');
						
		if ($date <> '') {
			$date = DateTimeFormat($date, 'Y-m-d');
			$sd = $date . " 00:00:00";
			$ed = $date . " 23:59:59";
			
			$ret = query("select cachereportsparams('".$sd."', '".$ed."', ' clientid = ".$cid."')");			
			
			if ($clienttypeid == 2) {
				$ret = query("select cachetaxiparams1('".$sd."', '".$ed."', ' clientid = ".$cid."')");
				$ret = query("select cachetaxiparams2('".$sd."', '".$ed."', ' clientid = ".$cid."')");
			}
		} else {
			$dayType = getQUERY("dayType");
			$from = '00:00:00';//getQUERY("from");
			$to = '23:59:59';//getQUERY("to");
					
			$f = addToDate(now(), -1, "months");
			while ($f < now()) {
				//ponedelnik-nedela
				if($dayType >= 1 and $dayType <= 7) {
					if ($dayType == 7) {
						if (DateTimeFormat($f, 'w') == 0) {
							$ret = query("select cachereportsparams('".DateTimeFormat($f, 'Y-m-d')." " . $from . "', '".DateTimeFormat($f, 'Y-m-d')." " . $to . "', ' clientid = ".$cid."')");
							if ($clienttypeid == 2) {
								$ret = query("select cachetaxiparams1('".DateTimeFormat($f, 'Y-m-d')." " . $from . "', '".DateTimeFormat($f, 'Y-m-d')." " . $to . "', ' clientid = ".$cid."')");
								$ret = query("select cachetaxiparams2('".DateTimeFormat($f, 'Y-m-d')." " . $from . "', '".DateTimeFormat($f, 'Y-m-d')." " . $to . "', ' clientid = ".$cid."')");
							}
						}
					} else {
						if (DateTimeFormat($f, 'w') == $dayType) {
							$ret = query("select cachereportsparams('".DateTimeFormat($f, 'Y-m-d')." " . $from . "', '".DateTimeFormat($f, 'Y-m-d')." " . $to . "', ' clientid = ".$cid."')");
							if ($clienttypeid == 2) {
								$ret = query("select cachetaxiparams1('".DateTimeFormat($f, 'Y-m-d')." " . $from . "', '".DateTimeFormat($f, 'Y-m-d')." " . $to . "', ' clientid = ".$cid."')");
								$ret = query("select cachetaxiparams2('".DateTimeFormat($f, 'Y-m-d')." " . $from . "', '".DateTimeFormat($f, 'Y-m-d')." " . $to . "', ' clientid = ".$cid."')");
							}
						}
					}
					
				} else {
					//vikend
					if ($dayType == 9) {
						if (DateTimeFormat($f, 'w') == 6 or DateTimeFormat($f, 'w') == 0) {
							$ret = query("select cachereportsparams('".DateTimeFormat($f, 'Y-m-d')." " . $from . "', '".DateTimeFormat($f, 'Y-m-d')." " . $to . "', ' clientid = ".$cid."')");
							if ($clienttypeid == 2) {
								$ret = query("select cachetaxiparams1('".DateTimeFormat($f, 'Y-m-d')." " . $from . "', '".DateTimeFormat($f, 'Y-m-d')." " . $to . "', ' clientid = ".$cid."')");
								$ret = query("select cachetaxiparams2('".DateTimeFormat($f, 'Y-m-d')." " . $from . "', '".DateTimeFormat($f, 'Y-m-d')." " . $to . "', ' clientid = ".$cid."')");
							}
						}
					} else {
						//delnik
						if ($dayType == 10) {
							if (DateTimeFormat($f, 'w') >= 1 and DateTimeFormat($f, 'w') <= 5) {
								$ret = query("select cachereportsparams('".DateTimeFormat($f, 'Y-m-d')." " . $from . "', '".DateTimeFormat($f, 'Y-m-d')." " . $to. "', ' clientid = ".$cid."')");
								if ($clienttypeid == 2) {
									$ret = query("select cachetaxiparams1('".DateTimeFormat($f, 'Y-m-d')." " . $from . "', '".DateTimeFormat($f, 'Y-m-d')." " . $to . "', ' clientid = ".$cid."')");
									$ret = query("select cachetaxiparams2('".DateTimeFormat($f, 'Y-m-d')." " . $from . "', '".DateTimeFormat($f, 'Y-m-d')." " . $to . "', ' clientid = ".$cid."')");
								}
							}
						}
					}
				}
				$f = addToDate($f, 1, "days");
			}
		}
	}
	closedb();
	
?>

