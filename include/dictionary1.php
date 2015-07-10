<?php

	global $Dic;

	$Dic = new DOMDocument();
	$Dic->load('./lang/'.$cLang.'.xml');

	//$Dic = new DOMDocument();
	//$Dic->load('./language/'.$cLang.'.xml');

	function dic($key){
		extract($GLOBALS, EXTR_REFS);
		if($Dic->getElementsByTagName($key)->length == 0)
		{
			print $key;
		}
		else {
			$trans = $Dic->getElementsByTagName($key)->item(0)->nodeValue;
			$trans = str_replace("(br)", "<br />", $trans);
			$trans = str_replace("(br /)", "<br />", $trans);
			$trans = str_replace("(b)", "<b>", $trans);
			$trans = str_replace("(/b)", "</b>", $trans);
			print $trans;
		}
		
	};
	
	function dic_($key){
		extract($GLOBALS, EXTR_REFS);
		if($Dic->getElementsByTagName($key)->length == 0)
		{
			return $key;
		}
		else {
			$trans = $Dic->getElementsByTagName($key)->item(0)->nodeValue;
			$trans = str_replace("(br)", "<br />", $trans);
			$trans = str_replace("(br /)", "<br />", $trans);
			$trans = str_replace("(b)", "<b>", $trans);
			$trans = str_replace("(/b)", "</b>", $trans);
			return $trans;
		}
	};
	
?>