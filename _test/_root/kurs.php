<?php include "include/db.php" ?>
<?php include "include/functions.php" ?>
<?php include "include/params.php" ?>

<?php header("Content-type: text/html; charset=utf-8"); ?>

<?php
	opendb();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/settings.js"></script>
</head>
<body>

<?php

class nbrm{

	private $client;

	public function __construct(){

		$this->client = new SoapClient("http://www.nbrm.mk/klservice/kurs.asmx?wsdl");
	}

	public function getER(){

		$params = array(
				'StartDate' => date('d.m.Y'),
				'EndDate' => date('d.m.Y')
			);

		$res = $this->client->GetExchangeRate($params);
		$xml = simplexml_load_string($res->GetExchangeRateResult);
		$output = array();

		foreach($xml->KursZbir as $valuta){
			$output[] = (array)$valuta;
		}	

		return $output;
	}

	public function getCurrencies(){

		$params = array(
				'StartDate' => date('d.m.Y'),
				'EndDate' => date('d.m.Y')
			);

		$res = $this->client->GetExchangeRate($params);
		$xml = simplexml_load_string($res->GetExchangeRateResult);
		$output = array();

		foreach($xml->KursZbir as $valuta){
			$output[(string)$valuta->Oznaka] = (string)$valuta->NazivMak;
		}	

		return $output;
	}

	public function getCurrencyValue($id){
		$params = array(
				'StartDate' => date('d.m.Y'),
				'EndDate' => date('d.m.Y')
			);

		$res = $this->client->GetExchangeRate($params);
		$xml = simplexml_load_string($res->GetExchangeRateResult);
		$output = '';

		foreach($xml->KursZbir as $valuta){
			if($valuta->Oznaka == $id){
				$output = (string)$valuta->Sreden;
			}
		}

		return $output;
	}
}

$nbrm = new nbrm;

echo '<pre>';

 print_r($nbrm->getCurrencies());
 print_r(round($nbrm->getCurrencyValue('EUR'),2));

$getCurrTb = pg_fetch_assoc(query("select * from currency"));

print_r($getCurrTb);

/*while ($giC = pg_fetch_assoc(query("select * from currency"))) {
	$name = $giC['name'];
	$value = $giC['value'];
	echo $name . "--";

}*/

echo '</pre>';

// RunSQL("UPDATE currency SET ")







closedb();

?>

</body>
</html>