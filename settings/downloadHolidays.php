<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	
	opendb();
	$t = getQUERY("t");
		
	$cntCompanyHoliday = dlookup("select count(*) from companydaysholiday where clientid=".session("client_id")." and holidayid=1");
	if ($cntCompanyHoliday == 0) {
		$ret = RunSQL("insert into companydaysholiday (clientid, nameholiday, holidayid) values (".session("client_id").", 'Државен', 1)");		
	} 
		
	if ($t == 1) {
		$sqlCompanyDays = "insert into companydays (clientid, dayname, typeofday, datum, companyholiday, cellcolor, typeofholiday)
		select ".session("client_id").", description, (select getdayofweek(cast(datetime as date))), datetime1, 8, '#ff9933', 1 
		from nonworkingdays where description not in (select dayname from companydays where clientid=".session("client_id")." and datum >= '".DateTimeFormat(now(), 'Y') . '-01-01'."' and datum <= '".DateTimeFormat(now(), 'Y') . '-12-31'."')
		and active='1'";
		$ret1 = RunSQL($sqlCompanyDays);
	} else {
		$sqlCompanyDays1 = "delete from companydays where clientid=".session("client_id")." and datum >= '".DateTimeFormat(now(), 'Y') . '-01-01'."' and datum <= '".DateTimeFormat(now(), 'Y') . '-12-31'."' and companyholiday = 8";
		$ret2 = RunSQL($sqlCompanyDays1);
	}
	closedb();
	
?>