<?php

	// Database connection string
	//$ConnStr = "Driver={SQL Server};Server=92.55.94.2;Database=draft;uid=sa;pwd=G30net#";
	
	if(ReadCookies("DefaultLanguage") == "")
	{
		include('ip2locationlite.class.php');

		//Load the class
		$ipLite = new ip2location_lite;
		$ipLite->setKey('6fd5f186e30b05cfb5da94f5d9f073a66242543b9521cd5969c7fd903fa1b878');
		
		//Language variable
		$locations = $ipLite->getCountry("217.16.79.81");
		//$locations = $ipLite->getCountry(getIP());
		//$errors = $ipLite->getError();
	 	
		//Getting the result
		if (!empty($locations) && is_array($locations)) {
		  foreach ($locations as $field => $val) {
		    if($field == "countryCode")
		    	$defLang = $val;
		  }
		}
		if($defLang == "US")
			$defLang = "en";
		$defLang = strtolower($defLang);
		WriteCookies("DefaultLanguage", $defLang, 14);
	} else {
		$defLang = strtolower(ReadCookies("DefaultLanguage"));
	}
	
	if($_SERVER['HTTP_HOST'] == "panorama.gps-ks.com")
		$defLang = "al";
	
	if (isset($_GET["l"])) {
		if (($_GET["l"]!="mk") && ($_GET["l"]!="en") && ($_GET["l"]!="fr") && ($_GET["l"]!="al")) {
			$cLang = $defLang;
		} else {
			$cLang=$_GET["l"];
		};
	} else
		$cLang = $defLang;

	//Copyright string
	$CopyrightString = "© 2013 Geonet GPS Solution | Geonet Linux Dev Team";
	$CopyrightLink = "http://www.gps.mk";
	
	
	//Main Address of application
	$RootPath = "http://app.panopticsoft.com/";
	
	function getIP() {
	    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
	        $ip = getenv("HTTP_CLIENT_IP");
	    } else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
	        $ip = getenv("HTTP_X_FORWARDED_FOR");
	    } else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
	        $ip = getenv("REMOTE_ADDR");
	    } else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
	        $ip = $_SERVER['REMOTE_ADDR'];
	    } else {
	        $ip = "unknown";
	    }
	    return($ip);
	}
	
	function GetCurrentPosition($RoleID, $ClientID, $UserID){
		//if($RoleID == "2")
		$sqlV = "";
        if($RoleID == "2"){
            $sqlV = "select id from vehicles where clientid=" . $ClientID;
        } else {
            $sqlV = "select vehicleid from uservehicles where userid=" . $UserID . "";
        }

        $ClientTypeID = dlookup("select clienttypeid from clients where id=" . $ClientID);
        
        
        $sqlStyles = "";
		$sqlStyles .= "SELECT c1.name engineon, c2.name engineoff, c3.name engineoffpassengeron, c4.name satelliteoff, c5.name taximeteron, c6.name taximeteroffpassengeron, c7.name passiveon, c8.name activeoff ";
		$sqlStyles .= "from users us ";
		$sqlStyles .= "left outer join statuscolors c1 on c1.id=us.engineon ";
		$sqlStyles .= "left outer join statuscolors c2 on c2.id=us.engineoff ";
		$sqlStyles .= "left outer join statuscolors c3 on c3.id=us.engineoffpassengeron ";
		$sqlStyles .= "left outer join statuscolors c4 on c4.id=us.satelliteoff ";
		$sqlStyles .= "left outer join statuscolors c5 on c5.id=us.taximeteron ";
		$sqlStyles .= "left outer join statuscolors c6 on c6.id=us.taximeteroffpassengeron ";
		$sqlStyles .= "left outer join statuscolors c7 on c7.id=us.passiveon ";
		$sqlStyles .= "left outer join statuscolors c8 on c8.id=us.activeoff ";
        $sqlStyles .= "where us.id=" . $UserID;
        $dsStyles = query($sqlStyles);
		//$dsStyles = query("SELECT [c1].[name] [EngineON] from [UserSettings] [us] left outer join [Colors] [c1] on [c1].[id] = [us].[EngineON] where [us].[id]=506");
        
        //echo "select * from (SELECT c1.name EngineON from UserSettings us left outer join Colors c1 on c1.id=us.EngineON where us.UserId=506) t";
        //echo  odbc_field_name($dsStyles, 1) ;

        //exit;   

        $sql = "";
        //$sql .= "select  v.numberofvehicle, v.registration, geonet.dbo.fn_seats_goran(seats) sedista, cp.* ";
        $sql .= "select cast(v.code as integer), v.registration, '1' sedista, cp.* ";
        $sql .= "from currentposition cp ";
        $sql .= "left outer join vehicles v on v.id=cp.vehicleid ";
        $sql .= "where vehicleid in (" . $sqlV . ") order by cast(v.code as integer) asc";
 		
        $ds = query($sql);
        $str = "";
        
        if($ClientTypeID == 2)
		{
            //ako e taksi kompanija
            while($row = pg_fetch_array($ds))
			{
                $lon = $row["longitude"];
				$lat = $row["latitude"];
	
				//if($row["LongOrientation"] == "W") $lon = "-" . $lon;
				//if($row["LatOrientation"] == "S") $lat = "-" . $lat;
				$stil = "";


                $row["sedista"] = NNull($row["sedista"], 0);
                
				/*if($row["Ignition"]."" == "0" && $row["sedista"]."" == "0")*/ $stil = pg_fetch_result($dsStyles, 0, "EngineOFF");
                
                //if($row["Ignition"]."" == "0" && $row["sedista"]."" <> "0") $stil = pg_fetch_result($dsStyles, 0, "EngineOFFPassengerON");
                
                //if($row["Ignition"]."" == "1" && $row["sedista"]."" <> "0" &&  $row["Taximeter"]."" == "0") $stil = pg_fetch_result($dsStyles, 0, "TaximeterOFFPassengerON");
				//if($row["Ignition"]."" == "1" && $row["Taximeter"]."" == "1") $stil = pg_fetch_result($dsStyles, 0, "TaximeterON");
				//if($row["Ignition"]."" == "1" && $row["sedista"]."" == "0" and $row["Taximeter"]."" == "0") $stil = pg_fetch_result($dsStyles, 0, "EngineON");
                //if($row["passive"]."" == "1") $stil = pg_fetch_result($dsStyles, 0, "PassiveON");
				if($row["status"]."" == "0") $stil = pg_fetch_result($dsStyles, 0, "SatelliteOFF");

                $str .= "#" . $row["code"] . "|" . $lon . "|" . $lat . "|" . "Gray" . "|" . $row["registration"];

            }
        } else {
            // Ostanati
            while($row = pg_fetch_array($ds))
			{
                $lon = $row["longitude"];
				$lat = $row["latitude"];
	
				//if($row["LongOrientation"] == "W") $lon = "-" . $lon;
				//if($row["LatOrientation"] == "S") $lat = "-" . $lat;
				$stil = "";

                /*if($row["Ignition"]."" == "0") */ $stil = pg_fetch_result($dsStyles, 0, "EngineON");
            	//if($row["Ignition"]."" == "1") $stil = pg_fetch_result($dsStyles, 0, "EngineOFF");
                //if($row["status"] == "1") $stil = pg_fetch_result($dsStyles, 0, "SatelliteOFF");
            	$str .= "#" . $row["code"] . "|" . $lon . "|" . $lat . "|" . "Gray" . "|" . $row["registration"];
            }
		}
		return $str;
	}
	function getLocation($lon, $lat)
	{
	    try{
	    	$myServer = "92.55.94.2";
			$myUser = "sa";
			$myPass = "G30net#";
			$myDB = "gis";
			$dbh = odbc_connect("Driver={SQL Server};Server=$myServer;Database=$myDB", $myUser, $myPass) or die (odbc_errormsg());
	        $sql = "declare @ppDescription nvarchar(250); exec gis.dbo.getLocation '" . str_replace(",", "", $lon."") . "', '" . str_replace(",", "", $lat."") . "', @ppDescription output; select @ppDescription";
			//Dim URL As String = "h ttp://nominatim.openstreetmap.org/reverse?format=xml&lat=" & Replace(CStr(lat), ",", "") & "&lon=" & Replace(CStr(lon), ",", "") & "&zoom=18&addressdetails=0"
	        $rez = odbc_exec($dbh, $sql);
			$rez1 = odbc_result($rez,1);
			odbc_close($dbh);
	        return $rez1;
	    } catch (Exception $e) {
	        return "";
		}
	}
	function SearchLocation($name)
	{
     	//$name = urlencode( ':-:location:-:' );
		$baseUrl = 'http://nominatim.openstreetmap.org/search?format=json&q=';
		$data = file_get_contents( "{$baseUrl}{$name}&limit=20&addressdetails=1" );
		foreach ( json_decode( $data ) as $elem )
		{
			$Lat = $elem->lat == ""? 0 : $elem->lat;
            $Lon = $elem->lon == ""? 0 : $elem->lon;
            $street = $elem->display_name;
            $type = $elem->type;
			$class = $elem->class;
			$icon = $elem->icon;
			$country = $elem->address->country;
			$city = $elem->address->city;
			$countryCode = $elem->address->country_code;
			$suburb = $elem->address->suburb;
			$administrative = $elem->address->administrative;
			$items .= "@*@" . $Lon . "@*@" . $Lat . "@*@" . $street . "@*@" . $type . "@*@" . $class . "@*@" . $icon . "@*@" . $country . "@*@" . $city . "@*@" . $countryCode . "@*@" . $suburb . "@*@" . $administrative;
            $items .= "&@&";
		}
		return $items;
    }
	function SearchLocationByLonLat($lon1,$lat1)
	{
		$z = 18;
		$baseUrl = 'http://nominatim.openstreetmap.org/reverse?format=json&';
		$data = file_get_contents( "{$baseUrl}lat={$lat1}&lon={$lon1}&zoom={$z}" );
		$data = json_decode($data);
		$str1 = $data->display_name;
		//echo $str1;
		return $str1;
	}
	function get_url_contents($url){
	        $crl = curl_init();
	        $timeout = 50;
	        curl_setopt ($crl, CURLOPT_URL,$url);
	        curl_setopt($ch, CURLOPT_HEADER, false);
	        curl_setopt ($crl, CURLOPT_RETURNTRANSFER, true);
	        //curl_setopt ($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
	        $ret = curl_exec($crl);
	        curl_close($crl);
	        return $ret;
	}
	function getLineCoords($lon1, $lat1, $lon2, $lat2)
	{
        $url = 'http://open.mapquestapi.com/directions/v1/route?callback=renderAdvancedNarrative&outFormat=xml&routeType=shortest&timeType=1&enhancedNarrative=false&maxLinkId=10000&shapeFormat=raw&generalize=0&locale=en_GB&unit=k&drivingStyle=2&highwayEfficiency=21.0&from=' . $lat1 . ',' . $lon1 . '&to=' . $lat2 . ',' . $lon2;
		//$url = 'http://routes.cloudmade.com/8ee2a50541944fb9bcedded5165f09d9/api/0.3/41.998002727149,21.423526567776,42.01566400011,21.4628549540437/car.js?units=km&lang=mk';
		//$res = simplexml_load_file($url);   
		$items = '';
		$xml = simplexml_load_file($url);     
		$lonlat = $xml->route->shape->shapePoints->latLng;
		
    	for ($i = 0; $i < sizeof($lonlat); $i++) {
			$items .= "%@";
    		$items .= $lonlat[$i]->lng . "#" . $lonlat[$i]->lat;
		}
		$dist = $xml->route->distance;
		$time = $xml->route->time;
		return $items."^$".$dist."^$".$time;
    }
	function getLineCoordsF($lon1, $lat1, $lon2, $lat2)
	{
        $url = 'http://open.mapquestapi.com/directions/v1/route?callback=renderAdvancedNarrative&outFormat=xml&routeType=fastest&timeType=1&enhancedNarrative=false&maxLinkId=10000&shapeFormat=raw&generalize=0&locale=en_GB&unit=k&drivingStyle=2&highwayEfficiency=21.0&from=' . $lat1 . ',' . $lon1 . '&to=' . $lat2 . ',' . $lon2;
		//http://open.mapquestapi.com/directions/v0/route?callback=renderAdvancedNarrative&outFormat=xml&routeType=fastest&timeType=1&enhancedNarrative=false&maxLinkId=10000&shapeFormat=raw&generalize=0&locale=en_GB&unit=k&drivingStyle=2&highwayEfficiency=21.0&from=42.005173,21.440799&to=41.99653,21.403635
		//$url = 'http://routes.cloudmade.com/8ee2a50541944fb9bcedded5165f09d9/api/0.3/41.998002727149,21.423526567776,42.01566400011,21.4628549540437/car.js?units=km&lang=mk';
		//$res = simplexml_load_file($url);   
		$items = '';
		$xml = simplexml_load_file($url);     
		$lonlat = $xml->route->shape->shapePoints->latLng;
		
    	for ($i = 0; $i < sizeof($lonlat); $i++) {
			$items .= "%@";
    		$items .= $lonlat[$i]->lng . "#" . $lonlat[$i]->lat;
		}
		$dist = $xml->route->distance;
		$time = $xml->route->time;
		return $items."^$".$dist."^$".$time;
    }
	function getLineCoordsF1($lon1, $lat1, $lon2, $lat2)
	{
        $url = 'http://open.mapquestapi.com/directions/v1/route?callback=renderAdvancedNarrative&outFormat=xml&routeType=shortest&timeType=1&enhancedNarrative=false&maxLinkId=10000&shapeFormat=raw&generalize=0&locale=en_GB&unit=k&drivingStyle=2&highwayEfficiency=21.0&from=' . $lat1 . ',' . $lon1 . '&to=' . $lat2 . ',' . $lon2;
		//$url = 'http://routes.cloudmade.com/8ee2a50541944fb9bcedded5165f09d9/api/0.3/41.998002727149,21.423526567776,42.01566400011,21.4628549540437/car.js?units=km&lang=mk';
		//$res = simplexml_load_file($url);   
		$items = '';
		$xml = simplexml_load_file($url);     
		$lonlat = $xml->route->shape->shapePoints->latLng;
    	for ($i = 0; $i < sizeof($lonlat); $i++) {
			$items .= "%@";
    		$items .= $lonlat[$i]->lng . "#" . $lonlat[$i]->lat;
		}
		return $items;
    }
?>