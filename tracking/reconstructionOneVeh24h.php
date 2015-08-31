<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
	
	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	$yourbrowser1 = (bool) strpos($ua['userAgent'], "Macintosh");
	$yourbrowser2 = (bool) strpos($ua['userAgent'], "Safari");
	$yourbrowser3 = (bool) strpos($ua['userAgent'], "Chrome");

    if (session('user_id') == "261") echo header( 'Location: ../sessionexpired/?l='.$cLang);
	if (!is_numeric(session('user_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
    $user_id = session("user_id");
	$client_id = session("client_id");
    
    opendb();
	
	
	$dsAll = query("select defaultmap, datetimeformat, timezone, idleover, metric, cl.clienttypeid, ci.latitude, ci.longitude, cl.allowedrouting, cl.allowedfm, cl.allowedmess, cl.allowedalarms from users u left outer join clients cl on cl.id = u.clientid left outer join cities ci on ci.id = cl.cityid where u.id = " . $user_id);
	$allowedrouting = pg_fetch_result($dsAll, 0, "allowedrouting");
	$allowedFM = pg_fetch_result($dsAll, 0, "allowedfm");
	$allowedMess = pg_fetch_result($dsAll, 0, "allowedmess");
	$allowedAlarms = pg_fetch_result($dsAll, 0, "allowedalarms");
	
	$vh = nnull(getQUERY("v"), "0");
	
	$mins = nnull(getQUERY("mins"), "0");
 	
	$DefMap = pg_fetch_result($dsAll, 0, "defaultmap");
	$clientUnit = pg_fetch_result($dsAll, 0, "metric");
	
    //$DefMap = "GOOGLEM";
    $CPosition = "";
	$strLon= "";
	$strLat = "";
	$AllowedMaps = "";
    
   	$MinMin = 1;
	
	$strTaxi = "";
	$strPas = "";
    
	$sLon = "21.432767";
	$sLat = "41.996434";

	$isEmpty = 0;


	$cntIgn = dlookup("select count(portname) from vehicleport where vehicleid=" . $vh . " and porttypeid=1");
	if($cntIgn == 0)
		$ign = "di1";
	else	
		$ign = dlookup("select portname from vehicleport where vehicleid=" . $vh . " and porttypeid=1");
	
	
	//$sdF = ReturnDateN(utf8_urldecode(getQUERY("sd")));
	//$sd4 = ReturnDateN(utf8_urldecode(getQUERY("ed")));

	$checkIgn = dlookup("select count(*) from historylog where DateTime >= now() + cast('-" . $mins . " minutes' as interval) and Datetime <= now() and vehicleid=" . $vh . " and " . $ign . "='1'");
	$checkCnt = dlookup("select count(*) from historylog where DateTime >= now() + cast('-" . $mins . " minutes' as interval) and Datetime <= now() and vehicleid=" . $vh);
	
	$dt1 = '';
	$ign1 = '';
	$dsReconstruction = '';
	$strVehcileID = "";
	
	if($checkIgn > 0 && $checkCnt > 5)
	{
        $isEmpty = 1;

        $DTFormat = "Y-m-d H:i:s";

		$ClientTypeID = pg_fetch_result($dsAll, 0, "clienttypeid");
		$MinMin = pg_fetch_result($dsAll, 0, "idleover");
       
       	$dsReconstruction1 = query("select * from rshortreport where vehicleid in (" . $vh . ") and Datetime>=now() + cast('-" . $mins . " minutes' as interval) and Datetime<=now() order by datetime asc");
		while ($row1 = pg_fetch_array($dsReconstruction1)) {
			$dt1 .= "," . $row1["datetime"];
			$ign1 .= "," . $row1["ignition"];
		}

		$dsVehicles = query("select cast(code as integer), registration, organisationid, id from vehicles where id in (".$vh.") order by code");
		while($row = pg_fetch_array($dsVehicles))
		{
			$strVehcileID .= ",".$row["id"];
		}
		
		if (strlen($strVehcileID)>0) {
			$strVehcileID = substr($strVehcileID,1);	
		}

		$dsReconstruction = dlookup("select getreconstruction24h(" . $vh . ", cast((now() + cast('-" . $mins . " minutes' as interval)) as timestamp), cast(now() as timestamp), " . $user_id . ")");
		
		
		if($dsReconstruction == "")
			$isEmpty = 0;
		
        
	    $AllowedMaps = "1111";

?>

<div id="tabs" style="width: 100%; height:0px; left:0px; position:absolute; z-index:9999; background:none; border:none;">
	<ul style=" background:none; border:none;">
		<!--li style=" z-index:9999; top: -5px;"><a href="#tabs-1" style="color: White; font-family: Arial, Helvetica, sans-serif;font-size: 13px;" onClick="MinTabs(this.id)"><?php echo dic("Reports.SpeedChart")?></a><div onClick="MinTabs(this.id)" id="MinTabsID" style="position: relative; float: right; right: 2px; cursor: pointer; background: url('../images/rec_down.png') no-repeat scroll 0px 0px transparent; height: 31px; width: 15px; top: -3px;"></div></li>
		<li style=" z-index:9999"><a href="#tabs-2"></a></li-->
	</ul>
	<div id="tabs-1">
	    <div id="gnInfoChar2" class="shadow" style="overflow:hidden; position:absolute; top: 0px; z-index:9998; width: calc(100% - 5px); height:215px; left:0px; border-top: 0px solid #387CB0; background-Color:#FFFFFF;">
            <div id="chartdiv" style="width: 97%; height:275px; position: absolute; z-index: 5; left: 20px; top: -10px;"></div>
			<?php
			if($yourbrowser3 == "1")
			{
			?>
				<div id="raphaelIgn" style="display: block; z-index: 4; width: 92.6%; top: 6px; position: absolute; opacity: 0.65; height: 39px; left: 60px;"></div>
			<?php
			} else
			{
				if($yourbrowser2 == "1")
				{
				?>
					<table id="raphaelIgn" width="95%" cellpadding="0" cellspacing="0" style="opacity: 0.65; height:39px; display:block; position: absolute; z-index: 4; top: 6px; left: 35px"></table>
				<?php
				} else {
				?>
					<div id="raphaelIgn" style="display: block; z-index: 4; width: 92.6%; top: 6px; position: absolute; opacity: 0.65; height: 38px; left: 60px;"></div>
				<?php
				}
			} ?>
			<!--div id="chartdiv111" style="background-color: transparent; border: 0px none; height: 180px; left: 18px; position: absolute; top: 24px; width: 95.3%; z-index: 15;"></div-->
        </div>
	</div>

</div>
<?php
	 } else
        ob_clean();
?>

<script type="text/javascript">

    function MinTabs() {
        if($('#MinTabsID')[0].style.backgroundImage.indexOf("down") != -1)
        {
            $('#MinTabsID')[0].style.backgroundImage = $('#MinTabsID')[0].style.backgroundImage.replace("down", "up");
            $('#MinTabsID')[0].style.right = '7px';
            parseInt($('#gnInfoChar2').css('height'), 10)
            $('#gnInfoChar2').css({display: 'none'});
            $('#tabs').css({top: (parseInt($('#tabs').css('top'), 10) + parseInt($('#gnInfoChar2').css('height'), 10) - 33) + 'px'});
        } else
        {
            $('#MinTabsID')[0].style.backgroundImage = $('#MinTabsID')[0].style.backgroundImage.replace("up", "down");
            $('#MinTabsID')[0].style.right = '2px';
            $('#gnInfoChar2').css({display: 'block'});
            $('#tabs').css({top: (parseInt($('#tabs').css('top'), 10) - parseInt($('#gnInfoChar2').css('height'), 10) + 33)+ 'px'});
        }
    }

	var allowedDetail = '1';
	
    var first = 0
    var tableI = 0
    //var tableStr = '<table style="cursor:pointer;">' 

    var counter = 0
    _lonArr = ''
    _latArr = ''
    _lonArrZ = ''
    _latArrZ = ''

	metric = '<?php echo $clientUnit?>';
	if (metric == 'mi') speedunit = "mph";
    else speedunit = "Km/h";
	
	//$('#tabs').css({top: (document.body.clientHeight - 350) + 'px'});

    function getSeconds(strTime){
        var strTimes = strTime.split(":")
        var h = 0
        var m = 0
        var s = 0


        if(strTimes[0].charAt(0) == 0 && strTimes[0].charAt(0) == '0'){
            h = parseInt(strTimes[0].charAt(1), 10);
        }
        else{
            h = parseInt(strTimes[0], 10);
        }
        if(strTimes[1].charAt(0) == 0 && strTimes[1].charAt(0) == '0'){
            m = parseInt(strTimes[1].charAt(1), 10);
        }
        else{
            m = parseInt(strTimes[1], 10);
        }
        if(strTimes[2].charAt(0) == 0 && strTimes[2].charAt(0) == '0'){
            s = parseInt(strTimes[2].charAt(1), 10);
        }
        else{
            s = parseInt(strTimes[2], 10);
        }
        var sec = h*3600 + m*60 + s
        return sec
    }

    function setTime_sec(sec){
    
        var _strTime = ""
        var hours = ""
        var minutes = ""
        var seconds = ""
    
        sec = parseInt(sec, 10)

        hours = parseInt(sec/3600, 10)
        sec = sec-(hours*3600)
        minutes = parseInt(sec/60, 10)
        seconds = parseInt(sec%60, 10)

        if(hours<10)
        {
            hours = "0" + hours
        }
        if(minutes<10)
        {
            minutes = "0" + minutes
        }
        if(seconds<10)
        {
            seconds = "0" + seconds
        }
    
        _strTime = hours + ":" + minutes + ":" + seconds

        return _strTime
    }

    SpeedRec = 1000;

    lang = '<?php echo $cLang?>'

    //debugger;
    var isEmpty = '<?php echo $isEmpty ?>';
    
	var datenew = '<?php echo $dt1?>';
	var ignitionNew = '<?php echo $ign1?>';
    
    var chartData = [];
    
    var maxSpeedRec = 0;
    var maxSpeedRec1 = 0;
    var minOdom;
    var minOdomDT;
    var maxOdom;
    var maxOdomDT;
    
    if(isEmpty == 1 || isEmpty == "1")
    {
    	var strItems = '<?php echo $dsReconstruction?>';
    	var datet = strItems.split("@")[5].substring(0,strItems.split("@")[5].length-1);
    	
		var geocoder = new google.maps.Geocoder();

        var _PointCount = 0
        
        //var _pts
        
        var _MinMin = '<?php echo $MinMin ?>';

        
        //Marjan

        $(function () {
            $("#tabs").tabs();
            //$("#tabs1").tabs();
        });
		
		var mesec = dic("mesec", lang).split(",");

        
        //VehcileIDs = [< ?php echo $strVehcileID?>];
		var vehicleid = '<?=$vh?>';
		var carnum;
			
		CarStr = strItems.split("@")[0];
        _pts = CarStr.substring(1,CarStr.length).split("#");

        ParseCarStr_rec1(vehicleid);
        

        AllowedMaps = '<?php echo $AllowedMaps?>'
        DefMapType = '<?php echo $DefMap?>'

        AjaxStarted = false;
        RecStarted = false;
        OpenForDrawing = true;
        LoadCurrentPosition = false;
        ShowVehiclesMenu = false;
        AllowShowRoutes = false;

        if(AllowViewPoi == "1")
	    	ShowPOIBtn = true;
		else
			ShowPOIBtn = false;
	    if(AllowViewZone == "1")
	    	ShowGFBtn = true;
		else
			ShowGFBtn = false;
		
		RecOn = false;
		RecOnNew = false;
		RecOnNewAll = true;
		
		//AddLayerPlayNewRec(Boards[0], 0);

        //AddDaysButtonNewRec(Boards[0], 0, days, $vh, sd, sdB, ed, bool, hours);
        //AddClosePopUpButton(Boards[0], 0);
        //AddPrintButton(Boards[0], 0);
        //AddDetailButton(Boards[0], 0);
        
        //AddBaloon(Boards[0], 0);
        
        //getVehBaloon(VehcileIDs, lang);
        
        generatePathValues();
        
        if (Browser() == 'iPad') { iPad_Refresh() }

        zoomWorldScreen(Maps[0], DefMapZoom);
        
        
        //AmCharts.ready(function () {
        	generateChartData1();
			createSerialChart();
		//});
		existdatainlive = true;
    } else {
        lang = '<?php echo $cLang?>';
        alert('<?php echo dic("Reports.NoData")?>');
        existdatainlive = false;
    }

</script>
<?php
	closedb();
?>