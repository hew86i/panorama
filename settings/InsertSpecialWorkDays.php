<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php
	
	
	/* 
	 * 		Овој SQL запишува во табелата  - companydays . 
	 * 
	 * 		Во таа табела колоната typeofday може да има 7 вредности, од 1 до 7 што значат 
	 * 
	 * 		1 - Понеделник, 2 - Вторник , 3 - Среда, 4 - Четврток, 5- Петок, 6 - Сабота, 7 - Недела . 
	 * 
	 * 		Колоната companyholiday може да има 2 вредности и тоа :
	 * 
	 * 		8 - Празник , доколку е запишано 8 во таа колона тоа значи дека мора да има податок и во 
	 * 
	 * 		typeofholiday колоната кадешто се запишува каков тип на празник е одбран,
	 * 
	 *		а доколку е одбрано 9 тоа значи дека е Неработен ден на компанијата и нема дополнителни информации.
	 * 
	 * 		typeofholidai има вкупно 11 вредности кои се движат од 1 до 11 и ги имаат следниве значења:
	 * 
	 * 
	 * 		1 - празник за сите граѓани на Р.М
	 *	    2 - православен празник
	 *		3 - католички празник
	 *		4 - муслимански празник
	 *		5 - празник за албанската заедница
	 *		6 - празник за српската заедница
	 *		7 - празник за ромската заедница
	 *		8 - празник за влашката заедница
	 *		9 - празник за еврејската заедница
	 *		10 - празник за бошњачката заедница
	 *		11 - празник за турската заедница
	 * 
	 */
	 
	 
	
	$imePraznik = str_replace("'", "''", NNull($_GET['imePraznik'], ''));
	$datum = DateTimeFormat(getQUERY("Datum"), 'Y-m-d');
	
	opendb();
	$tipDen = str_replace("'", "''", NNull($_GET['tipDen'], ''));
		
	//$den = str_replace("'", "''", NNull($_GET['den'], ''));
	$den = dlookup("select getdayofweek(cast('".$datum."' as date))");	
	$color = str_replace("'", "''", NNull($_GET['boja'], ''));  
	$tipPraznik = str_replace("'", "''", NNull($_GET['tipPraznik'], ''));
	
	
	
	if($tipDen==8)
	{
		$proverka = query("select * from companydays");
		if(pg_num_rows($proverka)==0)
		{
			
			$vnes = query("insert into companydays(id,clientid,dayname,typeofday,datum,companyholiday,cellcolor	,typeofholiday) values(1," . Session("client_id").",N'" . $imePraznik . "','" . $den . "','" . DateTimeFormat($datum,"Y-m-d") . "','" . $tipDen . "','#" . $color . "','" . $tipPraznik . "'); ");
		
		}
		else
		{
			
			$posledno = dlookup("select Max(id)+1 from companydays");	
	   		$vnes = query("insert into companydays(id,clientid,dayname,typeofday,datum,companyholiday,cellcolor,typeofholiday) values('" . $posledno . "'," . Session("client_id").",N'" . $imePraznik . "','" . $den . "','" . DateTimeFormat($datum,"Y-m-d") . "','" . $tipDen . "','#" . $color . "','" . $tipPraznik . "'); ");                           
			
		}
	}
	else 
	{
		
		$proverka = query("select * from companydays");
		if(pg_num_rows($proverka)==0)
		{
			
			$vnes = query("insert into companydays(id,clientid,dayname,typeofday,datum,companyholiday,cellcolor) values(1," . Session("client_id").",N'" . $imePraznik . "','" . $den . "','" . DateTimeFormat($datum,"Y-m-d") . "','" . $tipDen . "','#" . $color . "'); ");
		
		}
		else 
		{
			
			$posledno = dlookup("select Max(id)+1 from companydays");	
	   		$vnes = query("insert into companydays(id,clientid,dayname,typeofday,datum,companyholiday,cellcolor) values('" . $posledno . "'," . Session("client_id").",N'" . $imePraznik . "','" . $den . "','" . DateTimeFormat($datum,"Y-m-d") . "','" . $tipDen . "','#" . $color . "'); ");                           
			
		}
		
	}
	
	closedb();
?>