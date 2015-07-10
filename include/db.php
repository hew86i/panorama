<?php
    global $dbhandle;
    function opendb(){
		extract($GLOBALS, EXTR_REFS);
		//$myServer = "localhost";
		$myServer = "192.168.2.151";
		$myUser = "postgres";
		$myPass = "a5ed56c81d";
		$myDB = "gis";
		$dbhandle = pg_connect("dbname=$myDB user=$myUser password=$myPass host=$myServer port=5432");
		/*extract($GLOBALS, EXTR_REFS);
		//$myServer = "localhost";
		$myServer = "144.76.225.247";
		$myUser = "postgres";
		$myPass = "yy3sTeX6AAPJ3x";
		$myDB = "gis";
		$dbhandle = pg_connect("dbname=$myDB user=$myUser password=$myPass host=$myServer port=5432");*/
	}

	function closedb(){
		extract($GLOBALS, EXTR_REFS);
		pg_close($dbhandle);
	}

	function query($sql){
		extract($GLOBALS, EXTR_REFS);
		$rezultat = pg_query($dbhandle, $sql);
		return $rezultat;
	}
    function dlookup($sql){
		extract($GLOBALS, EXTR_REFS);
		$rez = pg_query($dbhandle, $sql);
    	//$row = odbc_fetch_row($rez);
		$ret = pg_fetch_result($rez,0,0);

		return $ret;
	}
	function RunSQL($sql)
	{
		extract($GLOBALS, EXTR_REFS);
		$stmt = pg_query($dbhandle, $sql);
		$truefalse = pg_result_status($stmt);
        return $truefalse;
    }
?>
