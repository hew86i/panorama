<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php

	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	$yourbrowser1 = (bool) strpos($ua['userAgent'], "Macintosh");

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<link href="./css/kiklop.core.css" rel="stylesheet">
	<link href="./css/default.css" rel="stylesheet">
	<link href="./css/tfm.css" rel="stylesheet">
	<link rel="stylesheet" href="../tracking/mlColorPicker.css" type="text/css" media="screen" charset="utf-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="../style.css">

	<script type="text/javascript" src="../js/jquery.js"></script>
	
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	
    <script type="text/javascript" src="../tracking/live.js"></script>
	<script type="text/javascript" src="../tracking/live1.js"></script>

	<script type="text/javascript" src="routes.js"></script>
	<script type="text/javascript" src="./js/highcharts.src.js"></script>

	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="../js/jquery-ui.js"></script>
	<script src="../report/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="../js/OpenLayers.js"></script>
    <script src="js/optimized.js" type="text/javascript"></script>
    <script src="js/advanced.js" type="text/javascript"></script>
	<script src="../js/jsxcompressor.js"></script>
	<script type="text/javascript" src="../tracking/mlColorPicker.js"></script>
	<script src="./js1/kiklop.textbox.js"></script>
	<script src="./js1/tfm.core.js"></script>
	<style type="text/css">
	<?php
	if($yourbrowser == "1")
	{?>
		html { 
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch; 
		}
		body {
		    height: 100%;
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch;
		    
		}
	<?php
	}
	?>
		.ui-accordion{
			border-top: 0 none;
		    display: block;
		    margin-bottom: 2px;
		    margin-top: -2px;
		    overflow: auto;
		    padding: 0px;
		    position: relative;
		    top: 1px;
		    width: 250px;
		}
		.ui-widget-content{
			width: auto;
			background-color: #fff;
		}
		.ui-accordion-content {
			padding: 0px;
		}
		.ui-accordion .ui-accordion-header
		{
			border: 1px solid #CCCCCC;
			background-color: transparent;
			color: #2F5185;
		    padding: 3px;
		    opacity: 1;
		}
		.ui-accordion .ui-accordion-header .ui-icon {
			left: 225px;
		}
		.ui-state-default .ui-icon {
			background-image: url("../css/ui-lightness/images/ui-icons_228ef1_256x240.png")
		}
		.ui-state-active .ui-icon {
			background-image: url("../css/ui-lightness/images/ui-icons_228ef1_256x240.png")
		}
		.ui-accordion .ui-accordion-content {
			padding: 0px;
			border: 0px;
			top: 2px;
		}
		.ui-dialog { position: fixed; }	
	</style>
	<link rel="stylesheet" href="../tracking/pinIcons.css">
</head>

<?php

	opendb();
	if (session('user_id') == "261") echo header( 'Location: ../sessionexpired/?l='.$cLang);
	$Allow = getPriv("routesnew", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
	
	$id = getQUERY("id");
	$user_id = Session("user_id");
	$dsAll = query("select defaultmap, datetimeformat, timezone, metric, cl.clienttypeid, ci.latitude, ci.longitude, cl.allowedrouting, cl.allowedfm, cl.allowedmess, cl.allowedalarms from users u left outer join clients cl on cl.id = u.clientid left outer join cities ci on ci.id = cl.cityid where u.id = " . $user_id);
	$allowedrouting = pg_fetch_result($dsAll, 0, "allowedrouting");
	$allowedFM = pg_fetch_result($dsAll, 0, "allowedfm");
	$allowedMess = pg_fetch_result($dsAll, 0, "allowedmess");
	$allowedAlarms = pg_fetch_result($dsAll, 0, "allowedalarms");
	$metric = pg_fetch_result($dsAll, 0, "metric");
	
	$datetimeformat = pg_fetch_result($dsAll, 0, 'datetimeformat');
	$datfor = explode(" ", $datetimeformat);
	$dateformat = $datfor[0];
	$timeformat =  $datfor[1];
	if ($timeformat == 'h:i:s') $timeformat = $timeformat . " A";
	if ($timeformat == "H:i:s") {
		$tf = " H:i";
	}	else {
		$tf = " h:i A";
	}
	$datejs = str_replace('d', 'dd', $dateformat);	
	$datejs = str_replace('m', 'mm', $datejs);
	$datejs = str_replace('Y', 'yy', $datejs);
	$clientType = pg_fetch_result($dsAll, 0, "clienttypeid");
	$clientUnit = pg_fetch_result($dsAll, 0, "metric");
    
    //$allPOI = dlookup("select count(*) from pinpoints where clientID=" . session("client_id"));
    //$allPOIs As String = "false"
    //If allPOI < 1000 Then allPOIs = "true"
	
    $DefMap = pg_fetch_result($dsAll, 0, "defaultmap");
    	
	$currDateTime = new Datetime();
	$currDateTime = $currDateTime->format($dateformat . " " . $tf);
	$currDateTime1 = new Datetime();
	$currDateTime1 = $currDateTime1->format($dateformat);
	//dd-MM-yyyy HH:mm 
    //now()->format("Y-m-d H:i:s");

    $AllowedMaps = "11111";
    
	addlog(32, '');

    $cntz = dlookup("select count(*) from pointsofinterest where active='1' and type=2 and clientid=" . Session("client_id"));
    //$CurrentTime = DlookUP("select Convert(nvarchar(20), DATEADD(HOUR,(select timeZone from clients where ID=" . Session("client_id") . ") - 1,GETDATE()), 120) DateTime");
    $tzone = pg_fetch_result($dsAll, 0, "timezone");
	$tzone = $tzone - 1;
 
	$AllowAddPoi = getPriv("AddPOI", Session("user_id"));
	$AllowViewPoi = getPriv("ViewPOI", Session("user_id"));
	$AllowAddZone = getPriv("AddZones", Session("user_id"));
	$AllowViewZone = getPriv("ViewZones", Session("user_id"));
	
	$dsNalog = query("select * from rnaloghederpre where id=" . $id . " and clientid=" . session("client_id"));
	
	$naslov = pg_fetch_result($dsNalog, 0, "name");
	$alarm = pg_fetch_result($dsNalog, 0, "alarm");
	$totalkm = pg_fetch_result($dsNalog, 0, "totalkm");
	$totaltime = pg_fetch_result($dsNalog, 0, "totaltime");
	$vozilo = pg_fetch_result($dsNalog, 0, "vehicleid");
	
	$routeCallback = pg_fetch_result($dsNalog, 0, "routecallback");
	$routeType = pg_fetch_result($dsNalog, 0, "routetype");
		
	$driverid1 = pg_fetch_result($dsNalog, 0, "driverid1");
	$driverid2 = pg_fetch_result($dsNalog, 0, "driverid2");
	$driverid3 = pg_fetch_result($dsNalog, 0, "driverid3");
	
	$tostay = pg_fetch_result($dsNalog, 0, "tostay");
	
	$culID = pg_fetch_result($dsNalog, 0, "culid");
	$pause1 = pg_fetch_result($dsNalog, 0, "pause1");
	$pause2 = pg_fetch_result($dsNalog, 0, "pause2");
	$pause3 = pg_fetch_result($dsNalog, 0, "pause3");
	$pause4 = pg_fetch_result($dsNalog, 0, "pause4");
	$pause5 = pg_fetch_result($dsNalog, 0, "pause5");
	
	$tmpDT0 = new DateTime(pg_fetch_result($dsNalog, 0, "startdate"));
	$tmpDT = $tmpDT0->format("d-m-Y");
	$tmpDT1 = $tmpDT0->format("H");

	$pauseTemp = array(5,10,15,20,25,30,35,40,45,50,55,60);
	
?>
<script>
	AllowAddPoi = '<?php echo $AllowAddPoi?>'
	AllowViewPoi = '<?php echo $AllowViewPoi?>'
	AllowAddZone = '<?php echo $AllowAddZone?>'
	AllowViewZone = '<?php echo $AllowViewZone?>'
</script>
<style>
	
	.ui-autocomplete {
		max-height: 100px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
		/* add padding to account for vertical scrollbar */
		padding-right: 20px;
		z-index: 4000;
	}
</style>
<style type="text/css">
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; width: 89%; height: 25px; }
</style>

<script>

	
	lang = '<?php echo $cLang?>';
	var geocoder = new google.maps.Geocoder();
	$("#gfGroup dt a").click(function() {
        $("#gfGroup dd ul").toggle();
    });
    
	$(function () {
	    $("#MarkersIN").sortable({
	        revert: true,
	        axis: 'y',
	        cursor: 'ns-resize',
	        stop: function (event, div) {
	        	testKiki(event, div)
	        }
	    });
	    $("div, div").disableSelection();
	});
	
	function testKiki(event, div) {
	            if ($('#test1').attr('checked'))
	                var file = "getLinePoints";
	            else
	                var file = "getLinePointsF";

	            if (div.item[0].previousSibling == null)
	                var prev = -1;
	            else
	                var prev = parseInt(div.item[0].previousSibling.id.substring(div.item[0].previousSibling.id.lastIndexOf("_") + 1, div.item[0].previousSibling.id.length), 10);
	            if (div.item[0].nextSibling == null)
	                var next = -1;
	            else
	                var next = parseInt(div.item[0].nextSibling.id.substring(div.item[0].nextSibling.id.lastIndexOf("_") + 1, div.item[0].nextSibling.id.length), 10);
	            var curr = parseInt(div.item[0].id.substring(div.item[0].id.lastIndexOf("_") + 1, div.item[0].id.length), 10);
	            //alert(curr + " | " + prev + " | " + next);
	            if (next == -1 && prev == -1) return false;
	            if ((next - curr == 1) && (curr - prev == 1)) {
	                return false;
	            }
	            else {
	                if (curr > next && next != -1) {
	                    var currTMPMR = tmpMarkersRoute[curr];
	                    var currPOR = PointsOfRoute[curr + 1];
	                    var pom;
	                    var pom1;
	                    if (curr == ($('#MarkersIN').children().length - 1))
	                        tmpMarkersRoute[curr].events.element.children[0].style.backgroundColor = '#0066FF';
	                    for (var i = next; i <= curr; i++) {
	                        if (i < (curr - 1)) {
	                            for (var j = 0; j < lineFeatureRoute[i + 1].length; j++) {
	                                lineFeatureRoute[i + 1][j].style.VehID = "<br /><strong>" + dic("From", lang) + ": (" + (i + 2) + ")</strong> " + PointsOfRoute[i + 1].name + "<br /><strong>" + dic("To", lang) + ": (" + (i + 3) + ")</strong> " + PointsOfRoute[i + 2].name;
	                            }
	                        }
	                        pom = tmpMarkersRoute[i];
	                        pom1 = PointsOfRoute[i + 1];
	                        currTMPMR.events.element.children[0].innerHTML = (i + 1) + currTMPMR.events.element.children[0].innerHTML.substring(currTMPMR.events.element.children[0].innerHTML.indexOf("<"), currTMPMR.events.element.children[0].innerHTML.length);
	                        tmpMarkersRoute[i] = currTMPMR;
	                        PointsOfRoute[i + 1] = currPOR;
	                        currTMPMR = pom;
	                        currPOR = pom1;
	                        
	                        $('#MarkersIN').children()[i].id = $('#MarkersIN').children()[i].id.substring(0, $('#MarkersIN').children()[i].id.lastIndexOf("_") + 1) + i;
	                        $('#MarkersIN').children()[i].children[4].id = $('#MarkersIN').children()[i].children[4].id.substring(0, $('#MarkersIN').children()[i].children[4].id.lastIndexOf("_") + 1) + i;
	                        if (Browser() != 'iPad' && Browser() != 'Safari')
	                        	$('#MarkersIN').children()[i].children[4].attributes[0].value = $('#MarkersIN').children()[i].children[4].attributes[0].value.substring(0, $('#MarkersIN').children()[i].children[4].attributes[0].value.lastIndexOf("_") + 1) + i + "','" + i + "')";
                        	else
                        		$('#MarkersIN').children()[i].children[4].attributes[3].value = $('#MarkersIN').children()[i].children[4].attributes[3].value.substring(0, $('#MarkersIN').children()[i].children[4].attributes[3].value.lastIndexOf("_") + 1) + i + "','" + i + "')";
	                    }
	                    if (prev == -1) {
	                        tmpMarkersRoute[0].events.element.children[0].style.backgroundColor = '#00CC33';
	                        tmpMarkersRoute[1].events.element.children[0].style.backgroundColor = '#0066FF';
	                    }
	                    if (curr == ($('#MarkersIN').children().length - 1))
	                        tmpMarkersRoute[curr].events.element.children[0].style.backgroundColor = '#FF0000';

	                    if (prev != -1) {
	                        vectors[0].removeFeatures(lineFeatureRoute[next]);
	                        lineFeatureRoute[next] = "";
	                        DrawLine_Route1(PointsOfRoute[next].lon, PointsOfRoute[next].lat, PointsOfRoute[next + 1].lon, PointsOfRoute[next + 1].lat, next, 0, "<br /><strong>" + dic("From", lang) + ": (" + next + ")</strong> " + PointsOfRoute[next].name + "<br /><strong>" + dic("To", lang) + ": (" + (next + 1) + ")</strong> " + PointsOfRoute[next + 1].name, file);
	                    }
	                    vectors[0].removeFeatures(lineFeatureRoute[curr]);
	                    lineFeatureRoute[curr] = "";
	                    for (var i = curr; i > (next + 1); i--) {
	                        lineFeatureRoute[i] = lineFeatureRoute[i - 1];
	                    }
	                    lineFeatureRoute[next + 1] = "";
	                    DrawLine_Route1(PointsOfRoute[next + 1].lon, PointsOfRoute[next + 1].lat, PointsOfRoute[next + 2].lon, PointsOfRoute[next + 2].lat, next + 1, 0, "<br /><strong>" + dic("From", lang) + ": (" + (next + 1) + ")</strong> " + PointsOfRoute[next + 1].name + "<br /><strong>" + dic("To", lang) + ": (" + (next + 2) + ")</strong> " + PointsOfRoute[next + 2].name, file);
	                    if (curr != ($('#MarkersIN').children().length - 1)) {
	                        vectors[0].removeFeatures(lineFeatureRoute[curr + 1]);
	                        lineFeatureRoute[curr + 1] = "";
	                        DrawLine_Route1(PointsOfRoute[curr + 1].lon, PointsOfRoute[curr + 1].lat, PointsOfRoute[curr + 2].lon, PointsOfRoute[curr + 2].lat, curr + 1, 0, "<br /><strong>" + dic("From", lang) + ": (" + (curr + 1) + ")</strong> " + PointsOfRoute[curr + 1].name + "<br /><strong>" + dic("To", lang) + ": (" + (curr + 2) + ")</strong> " + PointsOfRoute[curr + 2].name, file);
	                    }

	                } else {
	                    var currTMPMR = tmpMarkersRoute[curr];
	                    var currPOR = PointsOfRoute[curr + 1];
	                    var pom;
	                    var pom1;
	                    for (var i = prev; i >= curr; i--) {
	                        if (i > (curr + 1)) {
	                            for (var j = 0; j < lineFeatureRoute[i].length; j++) {
	                                lineFeatureRoute[i][j].style.VehID = "<br /><strong>" + dic("From", lang) + ": (" + (i - 1) + ")</strong> " + PointsOfRoute[i].name + "<br /><strong>" + dic("To", lang) + ": (" + i + ")</strong> " + PointsOfRoute[i + 1].name;
	                            }
	                        }
	                        //debugger;
	                        pom = tmpMarkersRoute[i];
	                        pom1 = PointsOfRoute[i + 1];
	                        currTMPMR.events.element.children[0].innerHTML = (i + 1) + currTMPMR.events.element.children[0].innerHTML.substring(currTMPMR.events.element.children[0].innerHTML.indexOf("<"), currTMPMR.events.element.children[0].innerHTML.length);
	                        tmpMarkersRoute[i] = currTMPMR;
	                        PointsOfRoute[i + 1] = currPOR;
	                        currTMPMR = pom;
	                        currPOR = pom1;
	                        if (next == -1) {
	                            pom.events.element.children[0].style.backgroundColor = '#FF0000';
	                            tmpMarkersRoute[i].events.element.children[0].style.backgroundColor = '#00CC33';
	                        }
	                        /*if (curr == 0)
	                        tmpMarkersRoute[0].events.element.children[0].style.backgroundColor = '#0066FF';
	                        //if (curr == 0 && i > 0)
	                        //tmpMarkersRoute[i].events.element.children[0].style.backgroundColor = '#0066FF';*/
	                        if (curr == 0 && i == 0)
	                            tmpMarkersRoute[i].events.element.children[0].style.backgroundColor = '#00CC33';
	                        else
	                            tmpMarkersRoute[i].events.element.children[0].style.backgroundColor = '#0066FF';
	                        $('#MarkersIN').children()[i].id = $('#MarkersIN').children()[i].id.substring(0, $('#MarkersIN').children()[i].id.lastIndexOf("_") + 1) + i;
	                        $('#MarkersIN').children()[i].children[4].id = $('#MarkersIN').children()[i].children[4].id.substring(0, $('#MarkersIN').children()[i].children[4].id.lastIndexOf("_") + 1) + i;
	                        if (Browser() != 'iPad' && Browser() != 'Safari')
	                        	$('#MarkersIN').children()[i].children[4].attributes[0].value = $('#MarkersIN').children()[i].children[4].attributes[0].value.substring(0, $('#MarkersIN').children()[i].children[4].attributes[0].value.lastIndexOf("_") + 1) + i + "','" + i + "')";
                        	else
                        		$('#MarkersIN').children()[i].children[4].attributes[3].value = $('#MarkersIN').children()[i].children[4].attributes[3].value.substring(0, $('#MarkersIN').children()[i].children[4].attributes[3].value.lastIndexOf("_") + 1) + i + "','" + i + "')";
	                    }

	                    if (curr != 0) {
	                        vectors[0].removeFeatures(lineFeatureRoute[curr]);
	                        vectors[0].removeFeatures(lineFeatureRoute[curr + 1]);
	                        lineFeatureRoute[curr] = "";
	                        DrawLine_Route1(PointsOfRoute[curr].lon, PointsOfRoute[curr].lat, PointsOfRoute[curr + 1].lon, PointsOfRoute[curr + 1].lat, curr, 0, "<br /><strong>" + dic("From", lang) + ": (" + curr + ")</strong> " + PointsOfRoute[curr].name + "<br /><strong>" + dic("To", lang) + ": (" + (curr + 1) + ")</strong> " + PointsOfRoute[curr + 1].name, file);
	                    } else
	                        vectors[0].removeFeatures(lineFeatureRoute[curr + 1]);
	                    for (var i = (curr + 1); i < prev; i++) {
	                        lineFeatureRoute[i] = lineFeatureRoute[i + 1];
	                    }
	                    lineFeatureRoute[prev] = "";
	                    DrawLine_Route1(PointsOfRoute[prev].lon, PointsOfRoute[prev].lat, PointsOfRoute[prev + 1].lon, PointsOfRoute[prev + 1].lat, prev, 0, "<br /><strong>" + dic("From", lang) + ": (" + prev + ")</strong> " + PointsOfRoute[prev].name + "<br /><strong>" + dic("To", lang) + ": (" + (prev + 1) + ")</strong> " + PointsOfRoute[prev + 1].name, file);
	                    if (next != -1) {
	                        vectors[0].removeFeatures(lineFeatureRoute[next]);
	                        lineFeatureRoute[next] = "";
	                        DrawLine_Route1(PointsOfRoute[next].lon, PointsOfRoute[next].lat, PointsOfRoute[next + 1].lon, PointsOfRoute[next + 1].lat, next, 0, "<br /><strong>" + dic("From", lang) + ": (" + next + ")</strong> " + PointsOfRoute[next].name + "<br /><strong>" + dic("To", lang) + ": (" + (next + 1) + ")</strong> " + PointsOfRoute[next + 1].name, file);
	                    }

	                }
	                if (PointsOfRoute[1] != undefined) {
	                    $('#IDMarker_' + PointsOfRoute[1].id + '_0')[0].children[2].value = "/";
	                    $('#IDMarker_' + PointsOfRoute[1].id + '_0')[0].children[3].value = "/";
	                }
	                //doOptimized('route', 'renderRoute');

	            }
	            PointsOfRouteBefore = PointsOfRoute;
	            for(var i=0; i < $('#MarkersIN')[0].children.length; i++) {
	            	if (i == 0) {
	            		$($('#MarkersIN')[0].children[i]).css('background-color', '#BCEBA0')
	            	} else {
	            		if (i == $('#MarkersIN')[0].children.length-1) {
	            			$($('#MarkersIN')[0].children[i]).css('background-color', '#FAC3C3')
	            		} else {
	            			$($('#MarkersIN')[0].children[i]).css('background-color', '')
	            		}
	            	}					
	            }
	           
	}
	 //   });
	//});
	var aPoiName  = []
	var aPoiId  = []
	var PoiCount = 0
	var PointsOfRoute = [];
	
	function CistiForma(){
		haveStartPoi = false;
		haveEndPoi = false;
		$("#startRoutePoi").removeAttr('checked');
		$("#endRoutePoi").removeAttr('checked');
		
		/*za ZKPelagonija*/
		if (document.getElementById('culture'))
			document.getElementById('culture').selectedIndex = 0;
		if (document.getElementById('operation'))	
			document.getElementById('operation').selectedIndex = 0;
		if (document.getElementById('material'))	
			document.getElementById('material').selectedIndex = 0;
		if (document.getElementById('mechanisation'))	
			document.getElementById('mechanisation').selectedIndex = 0;
		/*za ZKPelagonija*/
		
		$('#txt_naslov').val('')
		$('#txt_vozilo').val(0)
		$('#txt_sofer1').val(0)
		$('#txt_sofer2').val(0)
		$('#txt_sofer3').val(0)
		
		$('#txt_vreme').val('00:00');
		
		$('#txt_alert').val("/");
		$('#txt_alertWait').val("/");
		$('#txt_pause1').val(0);
		$('#txt_pause2').val(0);
		$('#txt_pause3').val(0);
		$('#txt_pause4').val(0);
		$('#txt_pause5').val(0);
		PoiCount = 0
		aPoiName  = []
		aPoiId  = []
		//genTable()
		$('#MarkersIN').html('');
		$('#PauseOnRoute').html('');
		$('#IDMarker_Total').css({ display: 'none' });
		$('#IDMarker_Total')[0].children[0].value = "/";
		$('#IDMarker_Total')[0].children[1].value = "/";
		ClearGraphicRoute();
		PointsOfRoute = [];
		for (var j = 0; j < tmpMarkersRoute.length; j++)
		    Markers[0].removeMarker(tmpMarkersRoute[j]);
		tmpMarkersRoute = [];
		PointsOfRoute = [];
		top.HideWait()
	}
	function ClearGraphicRoute() {
	    for (var z = 0; z < Maps.length; z++) {
	        if (vectors[z] != null) {
	            vectors[z].removeAllFeatures();
	            ArrAreasCheck[z] = [];
	        }
	    }
	    //if (ArrLineFeature != undefined && ArrLineFeature != '')
	        //vectors[0].addFeatures(ArrLineFeature);
	}
	function CistiForma1() {
		//$('#txt_naslov').val('')
		//$('#txt_vozilo').val(0)
		//$('#txt_sofer1').val(0)
		//$('#txt_sofer2').val(0)
		//$('#txt_sofer3').val(0)
		//$('#txt_vreme').val('00:00');
		
		//$('#txt_alert').val("/");
		//$('#txt_alertWait').val("/");
		//$('#txt_pause1').val(0);
		//$('#txt_pause2').val(0);
		//$('#txt_pause3').val(0);
		//$('#txt_pause4').val(0);
		//$('#txt_pause5').val(0);
		PoiCount = 0
		aPoiName  = []
		aPoiId  = []
		//genTable()
		$('#MarkersIN').html('');
		$('#PauseOnRoute').html('');
		$('#IDMarker_Total').css({ display: 'none' });
		$('#IDMarker_Total')[0].children[0].value = "/";
		$('#IDMarker_Total')[0].children[1].value = "/";
		ClearGraphicRoute();
		PointsOfRoute = [];
		for (var j = 0; j < tmpMarkersRoute.length; j++)
		    Markers[0].removeMarker(tmpMarkersRoute[j]);
		tmpMarkersRoute = [];
		PointsOfRoute = [];
		top.HideWait()
	}
	
	var cntAjax  = 0
	var NalogID  = -1
	function msgboxRoute(msg) {
	    $("#DivInfoForAll").css({ display: 'none' });
	    $('#div-msgbox').html(msg)
	    $("#dialog:ui-dialog").dialog("destroy");
	    $("#dialog-message").dialog({
	        modal: true,
	        zIndex: 9999, resizable: false,
	        buttons: {
	            Ok: function () {
	                $(this).dialog("close");
	            }
	        }
	    });
	}
	function SaveNalog(){
				
		/*za ZKPelagonija*/
		var culid = '';
		//$('#1culture').find('#culture').val()
		if (document.getElementById('culture'))
			if ($('#culture').children(":selected").val() != undefined)
				culid = $('#culture').children(":selected").val();
		if (document.getElementById('operation'))
			if ($('#operation').children(":selected").val() != undefined)
				operid = $('#operation').children(":selected").val();
		if (document.getElementById('material'))
			if ($('#material').children(":selected").val() != undefined)
				matid = $('#material').children(":selected").val();
		if (document.getElementById('mechanisation'))
			if ($('#mechanisation').children(":selected").val() != undefined)
				mechid = $('#mechanisation').children(":selected").val();
		/*za ZKPelagonija*/
		
		var naslov = $('#txt_naslov').val()
		var predefined = false;
		if(naslov != '')
			predefined = true;
		var vozilo = $('#txt_vozilo').val()
		var sofer1 = $('#txt_sofer1').val()
		var sofer2 = $('#txt_sofer2').val()
		var sofer3 = $('#txt_sofer3').val()
		
		//var datum = $('#txtSDate').val()
		var datum = formatdate13($('#txtSDate').val(), '<?=$dateformat?>');
		var vreme = $('#txt_vreme').val();
		var sY = datum.split("-")[0];
		var sM = datum.split("-")[1];
		if(sM.charAt(0) === '0') sM = sM.substr(1);
		var sD = datum.split("-")[2];
		if(sD.charAt(0) === '0') sD = sD.substr(1);
    		
    	var sH = vreme.split(":")[0];
		if(sH.charAt(0) === '0') sH = sH.substr(1);
    	var sMm = vreme.split(":")[1];
		if(sMm.charAt(0) === '0') sMm = sMm.substr(1);

		var dateC = new Date();
		var sY1 = dateC.getFullYear();
		var sM1 = dateC.getMonth();
		var sD1 = dateC.getDate();
		var date1 = new Date(sY1, sM1, sD1, 0, 0);
		var date2 = new Date(sY, sM-1, sD, sH, sMm);	
		var timeDiff = parseInt((date2.getTime() - date1.getTime())/1000/60);
		var alarm = $('#txt_alert').val();
		var zadrz = $('#txt_alertWait').val();
		var pause1 = $('#txt_pause1').val();
		var pause2 = $('#txt_pause2').val();
		var pause3 = $('#txt_pause3').val();
		var pause4 = $('#txt_pause4').val();
		var pause5 = $('#txt_pause5').val();
		
		var totalKm = parseFloat($('#IDMarker_Total')[0].children[0].value, 10);
		var totalTime = Str2Sec($('#IDMarker_Total')[0].children[1].value);
		
		if(PointsOfRoute.length == 2)
		{
			totalKm = 0;
			totalTime = 0;
		}

		if (timeDiff < 0) {
			$('#txtSDate').css({ border: '' });
			$('#txt_vreme').css({ border: '' });
		}
		if(vozilo == "0" || sofer1 == "0" || PointsOfRoute.length == 0 || culid == "0" || haveStartPoi == false || haveEndPoi == false || timeDiff < 0)
		{	
			
			msgboxRoute(dic("Routes.NoenteredReqData",lang));
			
			if(vozilo == "0")
			{
				$('#txt_vozilo').attr({ class: $('#txt_vozilo').attr('class') + ' shadow' });
				$('#txt_vozilo').css({ border: '2px solid Red' });
			}
			if(sofer1 == "0")
			{
				$('#txt_sofer1').attr({ class: $('#txt_sofer1').attr('class') + ' shadow' });
				$('#txt_sofer1').css({ border: '2px solid Red' });
			}
			if(PointsOfRoute.length == 0 || haveStartPoi == false || haveEndPoi == false)
			{
				$('#MarkersIN').parent().attr({ class: $('#MarkersIN').parent().attr('class') + ' shadow' });
				$('#MarkersIN').parent().css({ border: '2px solid Red' });
			}	
			if (timeDiff < 0) {
				$('#txtSDate').css({ border: '2px solid Red' });
				$('#txt_vreme').css({ border: '2px solid Red' });
			}
			
			if (vozilo != "0" && sofer1 != "0" && PointsOfRoute.length != 0 && culid != "0") {
				if (timeDiff < 0) {
					msgboxRoute(dic("Routes.OldRoute"), lang);
				} else {	
				if(haveStartPoi == false && haveEndPoi == false) {
					msgboxRoute(dic("Routes.NoSEPoi"), lang);
				} else {
					if(haveStartPoi == false) {
						msgboxRoute(dic("Routes.NoSPoi"), lang);
					} else {
						if(haveEndPoi == false) {
							msgboxRoute(dic("Routes.NoEPoi"), lang);
						}
						}
					}
				}
			}
		}	
		else
		{
			
			top.ShowWait();
			
			var routeCallback = "";
			var routeType = "";
			if ($("#opt").is(':checked') == true) {
	        	if ($("#Label1").hasClass("ui-state-active") == true) {
	        		routeCallback = "optimized";
	        		routeType = "shortest";
	        	} else {
	        		routeCallback = "optimized";
	        		routeType = "fastest";
	        	}
	        } else {	
	        	if ($("#Label1").hasClass("ui-state-active") == true) {
	        		routeCallback = "";
	        		routeType = "shortest";
	        	} else {
	        		routeCallback = "";
	        		routeType = "fastest";
	        	}
	        }
	        
			var url = encodeURI("n=" + naslov + "&vo=" + vozilo + "&predefined=" + predefined + "&d1=" + sofer1 + "&d2=" + sofer2 + "&d3=" + sofer3 + "&d=" + datum + "&v=" + vreme + "&alarm=" + alarm + "&zadrz=" + zadrz + "&pause1=" + pause1 + "&pause2=" + pause2 + "&pause3=" + pause3 + "&pause4=" + pause4 + "&pause5=" + pause5 + "&totalkm=" + totalKm + "&totaltime=" + totalTime + "&culid=0" + "&routeType=" + routeType + "&routeCallback=" + routeCallback);
			//alert(url);
			//debugger
			
			$.ajax({
			    url: 'SaveNHeaderNew.php?' + url,
			    success: function (data) {
			    	
			    	data = data.replace(/\r/g,'').replace(/\n/g,'');

			    	NalogID = data.split('^*')[0];
			    	NalogIDPre = data.split('^*')[1];

			 		 //gi vrti site kulturi
		 		 	var i=1;
					//for (var i = 1; i <= cntDivs; i++) {
						var cul = $('#' + i + 'culture').find('#culture').val();
						var oper = $('#' + i + 'culture').find('#operation').val();
						var mat = $('#' + i + 'culture').find('#material').val();
						var mech = $('#' + i + 'culture').find('#mechanisation').val();
						//alert(oper)
						//alert($('#' + i + 'culture').find('#culture').val() + ";" + $('#' + i + 'culture').find('#operation').val() + ";" + $('#' + i + 'culture').find('#material').val() + ";" + $('#' + i + 'culture').find('#mechanisation').val());
						//alert('SaveNewCulture.php?cul=' + cul + '&oper=' + oper + '&mat=' + mat + '&mech=' + mech)
						//alert('SaveNewCulture.php?cul=' + cul + '&oper=' + oper + '&mat=' + mat + '&mech=' + mech + '&nalogid=' + NalogID + '&numCul=' + i)
						$.ajax({
			                //url: 'SaveNewCulture.php?cul=' + cul + '&oper=' + oper + '&mat=' + mat + '&mech=' + mech + '&nalogid=' + NalogID + '&numCul=' + i,
			                url: 'SaveNewCulture.php?cul=' + cul + '&oper=' + oper + '&mat=' + mat + '&mech=' + mech + '&nalogid=' + NalogID + '&nalogidpre=' + NalogIDPre + '&numCul=' + i,
			                success: function (data) {
			                    //alert(data)
			                }
			            });
					//}
					//
					
			        for (var i = 1; i < PointsOfRoute.length; i++) {
			        	if(i==1)
			        	{
			        		var pointkm = 0;
			        		var pointtime = 0;
			        	} else
			        	{
			        		var pointkm = parseFloat($('#IDMarker_'+PointsOfRoute[i].id+"_"+(i-1))[0].children[2].value);
			        		var pointtime = $('#IDMarker_'+PointsOfRoute[i].id+"_"+(i-1))[0].children[3].value;
			        		pointtime = Str2Sec(pointtime.substring(0, pointtime.indexOf("(")-1));
			        	}
			            var urld = encodeURI('o=' + PointsOfRoute[i].name + '&rbr=' + (i) + '&h=' + NalogID + '&h1=' + NalogIDPre + "&predefined=" + predefined + '&ppid=' + PointsOfRoute[i].id + '&pointkm='+pointkm+'&pointtime=' + pointtime);
			           
			            $.ajax({
			                url: 'SaveNDetail.php?' + urld,
			                success: function (data) {
			                    cntAjax = cntAjax + 1;
			                    if (cntAjax == (PointsOfRoute.length - 1))
			                        WaitForSave();
			                }
			            });
			        }
			    }
			});
		}
	}
	function WaitForSave() {
	    //if (cntAjax == PointsOfRoute.length) {
			top.HideWait();
			CistiForma();
			//top.document.getElementById('ifrm-cont').src = top.document.getElementById('ifrm-cont').src;
			$('#newroutenum').html(NalogID);
			$('#div-mb').dialog({ width: 450, height: 240,
				buttons: 
				[
				{
					text:dic("print",lang),
					click: function(){
						document.getElementById('frm-print').src = 'PrintNalog.php?id='+NalogID+ '&l='+ lang;
						$('#div-print').dialog({width:document.body.offsetWidth - 10, height:document.body.offsetHeight - 10})
						}
					},
					{
						text:dic("Routes.ExportToExcel",lang),
						click: function(){
						document.getElementById('frm-excel').src = 'ExcelNalog.php?id='+NalogID+ '&l='+ lang;				
					}
					},		
					{
						text:dic("Tracking.Close",lang),			
						click: function(){ $( this ).dialog( "close" ); top.document.getElementById('ifrm-cont').src = top.document.getElementById('ifrm-cont').src; CistiForma();}								
				}
				]
			
			})
		//} else {
//			setTimeout("WaitForSave()")
		//}
	}
	var tmpDownload = "";
	function ShowPrezemi(){
		tmpDownload = 0;
		$('#div-prez').dialog({height:400, modal: true,
			buttons: 
			[
			{
				text:dic("Routes.Download",lang),
				click: function(){
					Prevzemi()
					$( this ).dialog( "close" );
					$("#opt").attr('checked', false);
					$("#Label1").addClass("ui-state-active");
					$("#Label2").removeClass("ui-state-active");
					$("#Label3").removeClass("ui-state-active");
				}
			},
			{
				text:dic("cancel",lang),
				click: function(){$( this ).dialog( "close" );}								
			}
			]	
			
		})	
	}
	function ShowPrezemi1(){
		tmpDownload = 1;
		$('#div-prez').dialog({height:400, modal: true,
			buttons: 
			[
			{
				text:dic("Routes.Download",lang),
				click: function(){
					parent.document.getElementById('ifrm-cont').src = 'NovNalogPre.php?l=' + lang + '&id=' + $('#txt_pre').val();
					$( this ).dialog( "close" );
				}
			},
			{
				text:dic("cancel",lang),
				click: function(){$( this ).dialog( "close" );}								
			}
			]	
			
		})	
	}

	function Prevzemi1(){
	    CistiForma1();
	    if (tmpDownload == 1) {
	    	parent.document.getElementById('ifrm-cont').src = 'NovNalogPre.php?l=' + lang + '&id=' + $('#txt_pre').val();
	    }
	    if (tmpDownload == 0) {
	    	LoadRoutePre($('#txt_pre').val());
	    }
	    $('#div-prez').dialog("close");
	}
	function Prevzemi(){
	    var id = $('#txt_pre').val();
	    CistiForma1();
	    LoadRoutePre(id);
	}
	
	function uncheck(_id)
	{
		if(_id == '#MarkersIN')
		{
			$('#MarkersIN').parent().attr({ class: $('#MarkersIN').parent().attr('class').replace(' shadow', '') });
			$('#MarkersIN').parent().css({ border: '1px dotted #B8B8B8' });
		} else
		{
			$('#'+_id).attr({ class: $('#'+_id).attr('class').replace(' shadow', '') });
			$('#'+_id).css({ border: '1px solid #CCCCCC' });
		}
	}
	function unchange()
	{
		var naslov = $('#txt_naslov').val()
		var vozilo = $('#txt_vozilo').val()
		var sofer1 = $('#txt_sofer1').val()
		var sofer2 = $('#txt_sofer2').val()
		var sofer3 = $('#txt_sofer3').val()
		
		var alarm = $('#txt_alert').val();
		var zadrz = $('#txt_alertWait').val();
		var pause1 = $('#txt_pause1').val();
		var pause2 = $('#txt_pause2').val();
		var pause3 = $('#txt_pause3').val();
		var pause4 = $('#txt_pause4').val();
		var pause5 = $('#txt_pause5').val();
		if(currdt != $('#txtSDate').val() || $('#txt_vreme').val() != "00:00" || vozilo != "0" || alarm != "/" || zadrz != "/" || sofer1 != "0" || sofer2 != "0" || sofer3 != "0" || pause1 != "0" || pause2 != "0" || pause3 != "0" || pause4 != "0" || pause5 != "0" || PointsOfRoute.length != 0)
		{
			top.changeItem = true;
		} else
		{
			top.changeItem = false;
		}
	}
</script>

<body style="margin:0px 0px 0px 0px; overflow: auto; padding:0px 0px 0px 0px" onResize="SetHeightLite112()">
<div id="dialog-message" title="<?php echo dic_("Reports.Warning")?>" style="display:none; text-align: center;">
	<p>
		<span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px; padding-left: 23px;"></div>
	</p>
    <div id="DivInfoForAll" style="font-size:11px; padding-left: 23px;"><input id="InfoForAll" type="checkbox" /><?php echo dic("Tracking.InfoMsg")?></div>
</div>
<div id="dialog-message1" title="<?php dic("Reports.Warning")?>" style="display:none">
	 <p>
		<span class="ui-icon ui-icon-circle-minus" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox1" style="font-size:14px"></div>
	</p>
</div>
<div id="dialog-draw-area" title="<?php echo dic("Tracking.DrawArea")?>" style="display:none">
	<iframe src="" id="ifrm-edit-areas" scrolling="no" frameborder="0" style="border:0px dotted #387cb0"></iframe>
</div>
<div id="insertStartEnd" style="display:none; font-size:12px; text-align: left" class="text2" title="<?= dic("Routes.EnterStartEnd")?>">
	<span class="text2"><?= dic("Routes.ToBeEntered")?>:</span><br><br>
	<div id="divStartRoute" style="position: relative; float:left"><input type="checkbox" id="startRoutePoi" /> <span class="text2"><?= dic("Routes.StartPoiRoute")?> </span></div>
	<div id="divMidRoute" style="position: relative; float:left; top: 7px" class="text2">&nbsp;<?= dic("Routes.And")?></div>
	<div id="divEndRoute" style="position: relative; float:left"><input type="checkbox" id="endRoutePoi" /> <span class="text2"><?= dic("Routes.EndPoiRoute")?></span></div>
</div>
<div id="div-Add-Group" style="display: none;" title="<?php echo dic("Tracking.AddGroup")?>">
	<span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.GroupName")?></span><input id="GroupName" type="text" class="textboxCalender corner5" style="width:220px" /><br /><br />
    <span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.Color")?></span>
    <div id="colorPicker2">
		<span id="colorPicker1" style="cursor: pointer; float:left; border:1px solid black; width:20px; height:20px;margin:5px;"></span>
		<input id="clickAny" type="text" class="textboxCalender corner5" onchange="changecolor()" value="" style="width:120px; display: none;" />
		<br><br>
	</div>
    <img id="loadingIconsPOI" style="visibility: hidden; width: 140px; position: absolute; left: 125px; top: 180px;" src="../images/loading_bar1.gif" alt="" />
    <br><br>
    <span id="spanIconsPOI" style="display:block; width:90px; float:left; margin-left:20px; position: relative; top: 70px;"><?php echo dic("General.Icon")?></span>
    <table id="tblIconsPOI" border="0" style="width: 268px; text-align: center; position: relative; top: -10px; left: -15px;">
        <tr>
        	<td>
        		<span id="GroupIconImg0" class="iconpin icon-poi-0"></span>
    		</td>
    		<td>
        		<span id="GroupIconImg1" class="iconpin icon-poi-1"></span>
        	</td>
    		<td>
        		<span id="GroupIconImg2" class="iconpin icon-poi-2"></span>
    		</td>
    		<td>
        		<span id="GroupIconImg3" class="iconpin icon-poi-3"></span>
        	</td>
    		<td>
        		<span id="GroupIconImg4" class="iconpin icon-poi-4"></span>
        	</td>
        	<td>
        		<span id="GroupIconImg5" class="iconpin icon-poi-5"></span>
        	</td>
        	<td>
        		<span id="GroupIconImg6" class="iconpin icon-poi-6"></span>
        	</td>
        	<td>
        		<span id="GroupIconImg7" class="iconpin icon-poi-7"></span>
    		</td>
    	</tr>
    	<tr>
    		<td><input style="cursor: pointer;" id="GroupIcon0" name="GroupIcon" value="0" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon1" name="GroupIcon" value="1" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon2" name="GroupIcon" value="2" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon3" name="GroupIcon" value="3" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon4" name="GroupIcon" value="4" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon5" name="GroupIcon" value="5" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon6" name="GroupIcon" value="6" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon7" name="GroupIcon" value="7" type="radio" /></td>
    	</tr>
        <tr>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg8" class="iconpin icon-poi-8"></span>
        	</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg9" class="iconpin icon-poi-9"></span>
    		</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg10" class="iconpin icon-poi-10"></span>
        	</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg11" class="iconpin icon-poi-11"></span>
        	</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg12" class="iconpin icon-poi-12"></span>
        	</td>
        	<td style="padding-top: 20px">
        		<span id="GroupIconImg13" class="iconpin icon-poi-13"></span>
        	</td>
        	<td style="padding-top: 20px">
        		<span id="GroupIconImg14" class="iconpin icon-poi-14"></span>
        	</td>
        	<td style="padding-top: 20px">
        		<span id="GroupIconImg15" class="iconpin icon-poi-15"></span>
    		</td>
        </tr>
        <tr>
    		<td><input style="cursor: pointer;" id="GroupIcon8" name="GroupIcon" value="8" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon9" name="GroupIcon" value="9" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon10" name="GroupIcon" value="10" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon11" name="GroupIcon" value="11" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon12" name="GroupIcon" value="12" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon13" name="GroupIcon" value="13" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon14" name="GroupIcon" value="14" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon15" name="GroupIcon" value="15" type="radio" /></td>
        </tr>
        <tr>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg16" class="iconpin icon-poi-16"></span>
        	</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg17" class="iconpin icon-poi-17"></span>
        	</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg18" class="iconpin icon-poi-18"></span>
        	</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg19" class="iconpin icon-poi-19"></span>
        	</td>
        	<td style="padding-top: 20px">
        		<span id="GroupIconImg20" class="iconpin icon-poi-20"></span>
        	</td>
        	<td style="padding-top: 20px">
        		<span id="GroupIconImg21" class="iconpin icon-poi-21"></span>
    		</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg22" class="iconpin icon-poi-22"></span>
    		</td>
    		<td style="padding-top: 20px">
        		<span id="GroupIconImg23" class="iconpin icon-poi-23"></span>
        	</td>
        </tr>
        <tr>
    		<td><input style="cursor: pointer;" id="GroupIcon16" name="GroupIcon" value="16" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon17" name="GroupIcon" value="17" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon18" name="GroupIcon" value="18" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon19" name="GroupIcon" value="19" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon20" name="GroupIcon" value="20" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon21" name="GroupIcon" value="21" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon22" name="GroupIcon" value="22" type="radio" /></td>
    		<td><input style="cursor: pointer;" id="GroupIcon23" name="GroupIcon" value="23" type="radio" /></td>
        </tr>
    </table>
    <br /><br />
	<div align="right" style="display:block; width:330px">
        <img id="loading1" style="display: none; width: 150px; position: absolute; left: 32px; margin-top: 7px;" src="../images/loading_bar1.gif" alt="" />
		<!--input type="button" class="BlackText corner5" id="btnAddGroup" value="<?php echo dic("Tracking.Add")?>" onclick="ButtonAddGroupOkClick()" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnCancelGroup" value="<?php echo dic("Tracking.Cancel")?>" onclick="$('#div-Add-Group').dialog('destroy');" /-->
	</div><br />
</div>
<div id="div-ver-DelGroup" style="display: none;" title="<?php echo dic("Tracking.DeletePoi")?>">
	<span class="ui-icon ui-icon-alert" style="position: absolute; left: 11px; top: 7px;"></span>
    <div align="center" style="font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo dic("Tracking.DeleteThisPoi")?></div><br />
	<div align="center" style="display:block;">
		<input type="button" class="BlackText corner5" id="btnYesDelGroup" value="<?php echo dic("Tracking.Yes")?>" onclick="$('#div-ver-DelGroup').dialog('destroy'); ButtonDeletePOIokClick()" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnCancelDelGroup" value="<?php echo dic("Tracking.No")?>" onclick="$('#div-ver-DelGroup').dialog('destroy');" />
	</div><br />
</div>
<div id="div-ver-DelGeoF" style="display: none;" title="<?php echo dic("Tracking.DeleteGF")?>">
	<div style="background: url('../images/izv.png')"></div>
    <div align="center" style="font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo dic("Tracking.DeleteThisGeoFence")?></div><br />
	<div align="center" style="display:block;">
		<input type="button" class="BlackText corner5" id="btnYesDelGF" value="<?php echo dic("Tracking.Yes")?>" onclick="$('#div-ver-DelGeoF').dialog('destroy'); ButtonDeleteGFokClick()" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnCancelDelGF" value="<?php echo dic("Tracking.No")?>" onclick="$('#div-ver-DelGeoF').dialog('destroy');" />
	</div><br />
</div>

<div id="div-Add-POI" style="display: none;">
	<br />
	<table style="font-size: 11px; color: rgb(65, 65, 65); font-family: Arial,Helvetica,sans-serif; margin-left: 20px;" cellpadding="0" cellspacing="0" border="0">
    	<tr>
    		<td width="90px"><?php echo dic("Tracking.Latitude")?></td>
    		<td>
    			<input id="poiLat" type="text" class="textboxCalender corner5" style="width:120px" />
    		</td>
		</tr>
		<tr height="50px">
    		<td width="90px"><?php echo dic("Tracking.Longitude")?></td>
    		<td>
    			<input id="poiLon" type="text" class="textboxCalender corner5" style="width:120px" />
    		</td>
		</tr>
		<tr>
    		<td width="90px"><?php echo dic("Tracking.Address")?></td>
    		<td>
    			<input id="poiAddress" type="text" class="textboxCalender corner5" style="width:269px; position: relative; float: left;" /><img id="loadingAddress" style="visibility: hidden; position: relative; float: left; top: 2px;" width="25px" src="../images/loadingP1.gif" border="0" align="absmiddle" />
    		</td>
		</tr>
		<tr height="50px">
    		<td width="90px"><?php echo dic("Tracking.NamePoi")?></td>
    		<td>
    			<input id="poiName" type="text" class="textboxCalender corner5" style="width:269px" />
    		</td>
		</tr>
		<tr>
    		<td width="90px"><?php echo dic("Tracking.AvailableFor")?></td>
    		<td>
    			<div id="poiAvail" class="corner5" style="font-size: 10px">
			        <input type="radio" id="APcheck1" name="radio" /><label for="APcheck1"><?php echo dic("Tracking.User")?></label>
			        <input type="radio" id="APcheck2" name="radio" /><label for="APcheck2"><?php echo dic("Tracking.OrgU")?></label>
			        <input type="radio" id="APcheck3" name="radio" /><label for="APcheck3"><?php echo dic("Tracking.Company")?></label>
			    </div>
    		</td>
		</tr>
		<tr height="50px">
    		<td width="90px"><?php echo dic("Tracking.Radius")?></td>
    		<td>
    			<dl id="poiRadius" class="dropdownRadius" style="width: 70px; margin: 0px;">
			        <dt><a href="#" title="" class="combobox1"><span><?php echo dic("Tracking.SelectRadius")?></span></a></dt>
			        <dd>
			            <ul>
			                <li><a id="RadiusID_50" href="#">50&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></a></li>
			                <li><a id="RadiusID_70" href="#">70&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></a></li>
			                <li><a id="RadiusID_100" href="#">100&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></a></li>
			                <li><a id="RadiusID_150" href="#">150&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></a></li>
			            </ul>
			        </dd>
			    </dl>
    		</td>
		</tr>
    	<tr>
    		<td width="90px"><?php echo dic("Tracking.Group")?></td>
    		<td>
    			<dl id="poiGroup" class="dropdown" style="width: 150px; position: relative; float: left; padding: 0px; margin: 0px;">
			    <?php
					$dsUG = query("SELECT id, name, fillcolor FROM pointsofinterestgroups WHERE id=1");
			        ?>
			        <dt><a href="#" title="" id="groupidTEst" class="combobox1"><span><?= dic("Tracking.SelectGroup")?></span></a></dt>
			        <dd>
			            <ul>
			                <li><a id="<?php echo pg_fetch_result($dsUG, 0, "id")?>" href="#">&nbsp;<span style="margin-left: 0px; display: inline-block; padding-left: 0px; margin-top: 3px;"><?php echo dic("Settings.NotGroupedItems")?></span>
			                	<img style="height: 18px; position: relative; width: 18px; float: left; left: 3px; top: -1px; margin-right: 7px;" src="../images/pin-1.png">
		                	</a></li>
			                <?php
								$dsGroup1 = query("select id, name, fillcolor, image from pointsofinterestgroups where id <> 1 and clientid=".session("client_id")." order by name asc");
			                    while ($row1 = pg_fetch_array($dsGroup1)) {
			                    	$_color = substr($row1["fillcolor"], 1, strlen($row1["fillcolor"]));
			                ?>
			                <li><a id="<?php echo $row1["id"]?>" href="#">&nbsp;<span style="margin-left: 0px; display: inline-block; padding-left: 0px; margin-top: 3px;"><?php echo $row1["name"]?></span><span class="iconpin20 icon-poi-<?= $row1["image"]?>" style="padding-left: 0px; padding-right: 0px; text-align: center; margin-top: -2px; width: 25px; position: relative; float: left; color: <?= $_color?>; text-shadow: 0px 0px 1px black;"></span></a></li>
			                <?php
			                    }
			                ?>
			            </ul>
			        </dd>
			    </dl>			    
    			<input type="button" id="AddGroup" style="float: right; right: 20px; top: 1px; height: 28px" onclick="AddGroup('1')" value="+" />
    		</td>
    	</tr>
	</table>
    <br /><br />
    <input type="hidden" id="idPoi" value="" />
    <input type="hidden" id="numPoi" value="" />
	<div align="right" style="display:block; width:380px; height: 30px; padding-top: 5px; position: relative; float: right; right: 15px;">
        <img id="loading" style="display: none; width: 140px; position: absolute; left: 10px; margin-top: 7px;" src="../images/loading_bar1.gif" alt="" />
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnCancelPOI" value="<?php echo dic("Tracking.Cancel")?>" onclick="window.scrollTo(0, dialogPosition); $('#div-Add-POI').dialog('destroy');" />        
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnAddPOI" value="<?php echo dic("Tracking.Add")?>" onclick="ButtonAddEditPOIokClick()" />
		<input type="button" style="display: none; position: relative; float: right; " class="BlackText corner5"  id="btnDeletePOI" value="<?php echo dic("Tracking.Delete")?>" onclick="DeleteGroup()" />
	</div><br /><br />
</div>
<div id="div-enter-zone-name" style="display:none">
	<div align = "center">
 		<table cellpadding="3" width="100%" style="font-size: 11px">
			<tr>
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.GFName")?>:</td>
				<td width = "75%" style="font-weight:bold" class ="text2">
					<input id="txt_zonename" type="text" value="" class="textboxcalender corner5 text5" style="width:365px;" />
				</td>
			</tr>
			<tr width = "75%" style="font-weight:bold" class ="text2">
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.AvailableFor")?>:</td>
				<td>
					<div id="gfAvail" class="corner5">
				        <input type="radio" id="GFcheck1" name="radio" /><label for="GFcheck1"><?php echo dic("Tracking.User")?></label>
				        <input type="radio" id="GFcheck2" name="radio" /><label for="GFcheck2"><?php echo dic("Tracking.OrgU")?></label>
				        <input type="radio" id="GFcheck3" name="radio" /><label for="GFcheck3"><?php echo dic("Tracking.Company")?></label>
				        <script>
				    		$('#GFcheck1').click(function(){ $(this).blur(); });
				    		$('#GFcheck2').click(function(){ $(this).blur(); });
				    		$('#GFcheck3').click(function(){ $(this).blur(); });
				    </script>
				    </div>
				</td>
			</tr>
			<tr>
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.Group")?>:</td>
				<td width = "75%" style="font-weight:bold" class ="text2">
					<dl id="gfGroup" class="dropdown" style="width: 150px; position: relative; float: left; margin: 0px;">
				    <?php
					$dsUG1 = query("SELECT id, name, fillcolor, '1' as image FROM pointsofinterestgroups WHERE id=1");
			        ?>
			        <dt><a href="#" title="" class="combobox1"><span class ="text2"><?php echo dic("Tracking.SelectGroup")?></span></a></dt>
			        <dd>
			            <ul>
			                <li><a id="<?php echo pg_fetch_result($dsUG1, 0, "id")?>" href="#">&nbsp;<?php echo dic("Settings.NotGroupedItems")?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 18px; height: 18px; background-color: <?php echo pg_fetch_result($dsUG1, 0, "fillcolor")?>; position: relative; float: left;"></div></a></li>
			                <?php
			                    $dsGroup2 = query("SELECT id, name, fillcolor, '1' as image FROM pointsofinterestgroups WHERE clientid=".session("client_id"));
			                    while ($row = pg_fetch_array($dsGroup2)) {
			                ?>
			                <li><a id="<?php echo $row["id"]?>" href="#">&nbsp;&nbsp;<?php echo $row["name"]?><div class="flag" style="margin-top: -1px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 18px; height: 18px; background-color: <?php echo $row["fillcolor"]?>; position: relative; float: left;"></div></a></li>
			                <?php
								}
			                ?>
			            </ul>
			        </dd>
			    </dl>
			    <input type="button" id="AddGroup1" style="position: relative; float: left; left: 20px; top: 1px;" onclick="AddGroup('0')" value="+" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<hr width="100%" style="opacity: 0.3; border-left: 0px none; border-width: 2px 0px 0px; border-style: dotted none none; border-color: -moz-use-text-color;">
				</td>
			</tr>
			<?php
				if(!$allowedAlarms) 
				{ ?>
					<tr>
						<td colspan="2">
							<table cellpadding="3" onclick="return false;" width="100%" style="font-size: 11px; opacity: 0.5;">
								<tr>
									<td>
				<?php } ?>
			<tr>
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Tracking.AlertFor")?>:</td>
			    <td width = "75%" style="font-weight:bold" class ="text2">
				    <div id="alertINOUT" class="corner5">
				        <input type="checkbox" id="alVlez" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> name="checkbox" /><label for="alVlez"><?php echo dic_("Tracking.Enter1")?></label>
				        <input type="checkbox" id="alIzlez" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> name="checkbox" /><label for="alIzlez"><?php echo dic_("Tracking.Exit")?></label>
				    </div>
				</td>
		    </tr>
     		<tr>
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Tracking.GroupOFAlerts")?>:</td>
			    <td width = "75%" style="font-weight:bold" class ="text2">
				    <div class="ui-widget" style="height: 25px; width: 100%;">
					    <select id="vozila" style="width: 365px;" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> class="combobox text2" onchange="OptionsChangeVehicle()" onclick="$(this).focus();">
					    	<option value="0"><?php echo dic_("Tracking.SelectOption")?></option>
					        <option value="1"><?php echo dic_("Tracking.OneVehicle")?></option>
					        <option value="2"><?php echo dic_("Tracking.VehInOrgU")?></option>
					        <option value="3"><?php echo dic_("Tracking.AllVehCompany")?></option>
					    </select>
					</div>
				</td>
		    </tr>
			<tr id="ednoVozilo" style="display:none;">
		     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Tracking.SelectVeh")?>:</td>
		     <td width = "75%" style="font-weight:bold" class ="text2">
		     <div class="ui-widget" style="height: 25px; width: 100%;">
		     <select id="voziloOdbrano" style="width: 365px;" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> class="combobox text2" onclick="$(this).focus();">
		     	<?php
		        	$str1 = "";
					$str1 .= "select * from vehicles where clientid=" . session("client_id") ." ORDER BY code::INTEGER";
					$dsPP = query($str1);
		            while($row = pg_fetch_array($dsPP)) {
		        ?>
		            <option value="<?php echo $row["id"] ?>"><?php echo $row["registration"]?>&nbsp;(<?php echo $row["code"]?>)</option>
		        <?php
		            }
		        ?>
		     </select>
			 </div>
			 </td>   
		     </tr>
     
		     <tr id="OrganizacionaEdinica" style="display:none;">
		     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Tracking.SelectOrg.Unit")?>:</td>
		     <td width = "75%" style="font-weight:bold" class ="text2">
		     <div class="ui-widget" style="height: 25px; width: 100%">
		     <select id="oEdinica" style="width: 365px;" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> class="combobox text2" onclick="$(this).focus();">
		     	<?php
		        	$str2 = "";
					$str2 .= "select * from organisation where clientid=" . session("client_id") ." order by code::INTEGER";
					$dsPP2 = query($str2);
					$brojRedovi = dlookup("select count(*) from organisation where clientid=" . session("client_id"));
		            while($row2 = pg_fetch_array($dsPP2)) {
		        ?>
		            <option value="<?php echo $row2["id"] ?>"><?php if ($brojRedovi>0){ echo $row2["name"]?>&nbsp;(<?php echo $row2["code"]?> <?php }else{ echo dic("Settings.NoOrgU");}?>)</option>
		        <?php
		            }
		        ?>
		     </select>
			 </div>
			 </td>
		     </tr>
		     
     	     <tr>
		     	<td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic_("Tracking.Emails")?></td>
		     	<td width = "75%" style="font-weight:bold" class ="text2">
		     		<input id = "txt_emails" class="textboxcalender corner5 text5" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> type="text" style = "width:365px" onclick="$(this).focus();"></input>
	     		</td>
		     </tr>
		     <tr>
		     	<td width = "25%"></td>	
		     	<td width = "75%" style="font-weight:bold ; " class ="text2"><font color = RED style="font-size = 10px"><?php echo dic_("Reports.SchNote")?></font></td>
		     </tr>
		     <tr>
		     	<td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic_("Settings.SMS")?></td>
		     	<td width = "75%" style="font-weight:bold" class ="text2"><input id = "txt_phones" class="textboxcalender corner5 text5" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> type="text" style = "width:365px" onclick="$(this).focus();"></input></td>
		     </tr>
	     
		 <?php if(!$allowedAlarms)
			{
				?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<?php
			}?>
	   	 </table>
     </div>
</div>
<div id="div-Directions" class="text2_ corner5 shadow" style="display: none; opacity: 0.9; z-index: 9996; background-color: white; float: right; position: fixed; right: 20px; bottom: 5px; width: 310px; min-height: 315px; height: auto;">
	<div class="textSubTitle" style="text-align: center; padding-top: 10px; height: 25px; border-bottom: 1px solid #ccc;"><?=dic('CalculatingDistance')?></div>
	<table class="text2_" style="font-size: 11px; color: rgb(65, 65, 65); margin-top: 5px; font-family: Arial,Helvetica,sans-serif; margin-left: 20px;" cellpadding="0" cellspacing="0" border="0">
		
		<tr style="height:5px;">
	         <td><div style="border-bottom: 1px dotted rgb(190, 190, 190); margin-left: -5px; width: 278px;"></div></td>
	    </tr>
		<tr height="67px">
    		<td>
    			<input id="fromDirection" onmousemove="ShowPopup(event, '<?=dic('search')?>' + ' ' + '<?=dic('Reports.Mo')?>'.toLowerCase() + ' ' + '<?=dic('Tracking.Address')?>'.toLowerCase())" onmouseout="HidePopup()" type="text" class="textboxCalender corner5 text2_" placeholder="<?=dic('ChooseStartingPoint')?>" style="border-bottom: 0px none; width: 236px; border-radius: 5px 0px 0px; border-right: 0px none;" />
    			<span onclick="ButtonAddStartDirectionClick(event, 0)" onmousemove="ShowPopup(event, '<?=dic('clickforstartpoint')?>')" onmouseout="HidePopup()" style="float: right; cursor: pointer; right: 21px; padding: 2px 6px 2px 5px; position: absolute; border: 1px solid #ccc; height: 21px; border-radius: 0px 5px 0px 0px;"><img id="clickstartaddress" src="../images/plus.png" width="20px" /></span>
    			<input id="direcitonAddress" onclick="javascript: $('#fromDirection').focus();" readonly="readonly" type="text" class="textboxCalender corner5 text2_" style="width: 269px; position: relative; float: left; border-radius: 0px 0px 5px 5px; background-color: #e9e9e9;" /><img id="loadingDirectionAddress" style="float: right; position: absolute; display: none; right: 25px;" width="25px" src="../images/smallref.gif" border="0" align="absmiddle" />
    			<input id="directionLon" type="hidden" value="" class="textboxCalender corner5 text2_" style="width:120px" />
    			<input id="directionLat" type="hidden" value="" class="textboxCalender corner5 text2_" style="width:120px" />
    		</td>
		</tr>
		<tr style="height:5px;">
	         <td>
	         	<div style="border-bottom: 1px dotted rgb(190, 190, 190); margin-left: -5px; width: 269px;"></div>
	         	<img onclick="SwitchPoints()" onmousemove="ShowPopup(event, '<?=dic('ReverseDestinationa')?>')" onmouseout="HidePopup()" width="8" height="11" src="../images/downMenu1.png" style="cursor: pointer; float: right; opacity: 0.25; position: absolute; right: 14px; margin-top: -5px;">
	         	<img onclick="SwitchPoints()" onmousemove="ShowPopup(event, '<?=dic('ReverseDestinationa')?>')" onmouseout="HidePopup()" width="8" height="11" src="../images/upMenu1.png" style="cursor: pointer; float: right; opacity: 0.25; position: absolute; margin-top: -5px; right: 7px;">
	         </td>
	    </tr>
	    <tr height="67px">
    		<td>
    			<input id="toDirection" onmousemove="ShowPopup(event, '<?=dic('search')?>' + ' ' + '<?=dic('Reports.Mo')?>'.toLowerCase() + ' ' + '<?=dic('Tracking.Address')?>'.toLowerCase())" onmouseout="HidePopup()" type="text" class="textboxCalender corner5 text2_" placeholder="<?=dic('ChooseDestination')?>" style="border-bottom: 0px none; width: 236px; border-radius: 5px 0px 0px; border-right: 0px none;" />
    			<span onclick="ButtonAddEndDirectionClick(event, 0)" onmousemove="ShowPopup(event, '<?=dic('clickforendpoint')?>')" onmouseout="HidePopup()" style="float: right; cursor: pointer; right: 21px; padding: 2px 6px 2px 5px; position: absolute; border: 1px solid #ccc; height: 21px; border-radius: 0px 5px 0px 0px;"><img id="clickendaddress" src="../images/plus.png" width="20px" /></span>
    			<input id="direcitonAddressEnd" onclick="javascript: $('#toDirection').focus();" readonly="readonly" type="text" class="textboxCalender corner5 text2_" style="width: 269px; position: relative; float: left; border-radius: 0px 0px 5px 5px; background-color: #e9e9e9;" /><img id="loadingDirectionAddressEnd" style="float: right; position: absolute; display: none; right: 25px;" width="25px" src="../images/smallref.gif" border="0" align="absmiddle" />
    			<input id="directionLonEnd" type="hidden" value="" class="textboxCalender corner5 text2_" style="width:120px" />
    			<input id="directionLatEnd" type="hidden" value="" class="textboxCalender corner5 text2_" style="width:120px" />
    		</td>
		</tr>
		<tr style="height:5px;">
	         <td>
	         	<table id="ResultDirectionsTable" cellpadding="0" cellspacing="0" class="text2_" style="display: none; padding: 7px;">
	         		<tr>
	         			<td style="border-bottom: 1px dotted #2f5185">
	         				<span style="position: relative; float: left;"><?=dic('ShortRoute')?></span>
	         				<hr width="20px" style="position: relative; float: left; left: 10px; top: -1px; border-color: #0000FF; border-width: 4px 0px 0px;">
	         			</td>
	         			<td style="border-bottom: 1px dotted #2f5185; border-left: 1px dotted #2f5185; padding-left: 5px;">
         					<span style="position: relative; float: left;"><?=dic('FastRoute')?></span>
         					<hr width="20px" style="position: relative; float: left; left: 10px; top: -1px; border-color: #FF0000; border-width: 4px 0px 0px;">
     					</td>
	         		</tr>
	         		<tr>
	         			<td><div id="ResultDirections" style="display: none; width: 122px; height: auto;"></div></td>
	         			<td style="border-left: 1px dotted #2f5185; padding: 5px;"><div id="ResultDirectionsF" style="display: none; width: 127px; height: auto;"></div></td>
	         		</tr>
	         	</table>
	         </td>
	    </tr>
		<tr style="height:5px;">
	         <td><div style="border-bottom: 1px dotted rgb(190, 190, 190); margin-left: -5px; width: 278px;"></div></td>
	    </tr>
	</table>
    <br />
	<div align="right" style="display:block; width:270px; height: 30px; padding-top: 5px; position: relative; float: right; right: 20px;">
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnCancelDirections" value="<?php echo dic("Tracking.Close")?>" onclick="$('#div-Directions').css({display: 'none'}); clearDirectionS(); clearDirectionE(); ButtonAddEndDirectionClick(); ButtonAddStartDirectionClick();" />        
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnDirections" value="<?=dic('calculate')?>" onclick="GetDirections('0')" />
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnSaveDirections" value="<?=dic('Save')?>" onclick="SaveDirections('0')" />
	</div><br /><br />
</div>
<div id="report-content" style="width:100%; height: auto; padding-top: 10px; padding-bottom: 48px; text-align:left; background-color:#fff; overflow: hidden;" class="corner5">
		<table width="100%" border="0">
			
			<tr>
					<td width=10% style="padding-left:10px">
						<span class="text2" style="font-weight:bold"><?php echo dic("Routes.NName")?>:</span>
					</td>
					<td width=22%>
						<input id="txt_naslov" type="text" class="textboxCalender corner5 text1" style="width: 250px; font-weight:bold" value="<?=$naslov?>" onclick="$(this).focus();" onkeydown="uncheck(this.id); unchange()" />	
					</td>
					<td width=23%>
						<button id="predefined" onClick="predefinedChange('predefined'); ShowPrezemi1()" style="margin-left:5px"><?= dic("Routes.DownloadOrder")?></button>
						<script>
							$('#predefined').button({icons: {primary: "ui-icon-link"}});
							$('#predefined').mousemove(function(event) {ShowPopup(event, dic("Routes.PopupDO"))});
							$('#predefined').mouseout(function() {HidePopup()});
						</script>
					</td>
					<td width=45%>
						<span class="text2" style="font-weight: bold"><?php echo dic("Routes.StartDatetime")?>: </span>
						<input id="txtSDate" type="text" width="80px" onchange="unchange()" class="textboxCalender corner5 text2" value="<?php echo $currDateTime1?>" style="width: 105px;position: relative; top: -1px;"/>
						<select class="textboxCalender corner5 text2" id="txt_vreme" onchange="unchange()" style="width:77px; position: relative; top: -1px; margin-top: 2px; padding-top:5px; padding-bottom:3px; margin-left:<?php if($yourbrowser == "1") { echo '-10px'; } else { echo '-10px'; } ?>" onclick="$(this).focus();">
							<option value="00:00"><?=DateTimeFormat("00:00", $tf)?></option>
							<option value="01:00"><?=DateTimeFormat("01:00", $tf)?></option>
							<option value="02:00"><?=DateTimeFormat("02:00", $tf)?></option>
							<option value="03:00"><?=DateTimeFormat("03:00", $tf)?></option>
							<option value="04:00"><?=DateTimeFormat("04:00", $tf)?></option>
							<option value="05:00"><?=DateTimeFormat("05:00", $tf)?></option>
							<option value="06:00"><?=DateTimeFormat("06:00", $tf)?></option>
							<option value="07:00"><?=DateTimeFormat("07:00", $tf)?></option>
							<option value="08:00"><?=DateTimeFormat("08:00", $tf)?></option>
							<option value="09:00"><?=DateTimeFormat("09:00", $tf)?></option>
							<option value="10:00"><?=DateTimeFormat("10:00", $tf)?></option>
							<option value="11:00"><?=DateTimeFormat("11:00", $tf)?></option>
							<option value="12:00"><?=DateTimeFormat("12:00", $tf)?></option>
							<option value="13:00"><?=DateTimeFormat("13:00", $tf)?></option>
							<option value="14:00"><?=DateTimeFormat("14:00", $tf)?></option>
							<option value="15:00"><?=DateTimeFormat("15:00", $tf)?></option>
							<option value="16:00"><?=DateTimeFormat("16:00", $tf)?></option>
							<option value="17:00"><?=DateTimeFormat("17:00", $tf)?></option>
							<option value="18:00"><?=DateTimeFormat("18:00", $tf)?></option>
							<option value="19:00"><?=DateTimeFormat("19:00", $tf)?></option>
							<option value="20:00"><?=DateTimeFormat("20:00", $tf)?></option>
							<option value="21:00"><?=DateTimeFormat("21:00", $tf)?></option>
							<option value="22:00"><?=DateTimeFormat("22:00", $tf)?></option>
							<option value="23:00"><?=DateTimeFormat("23:00", $tf)?></option>				
						</select>
						<button id="btn-clear1" style="position: relative; float:right; margin-right:10px; margin-top:2px;" onClick="predefinedChange('btn-clear1'); CistiForma()"><?php echo dic_("Routes.Delete")?></button>
						<button id="btn-save1" style="position: relative; float:right; margin-right:10px; margin-top:2px; margin-left: 5px;" onClick="predefinedChange('btn-save1'); SaveNalog()"><?php echo dic("Routes.Save")?></button>
						
					</td>
				</tr>
				<tr>
				  <td colspan="4">
				  	<div style="border-bottom: 1px dotted #95B1d7; width: 100%; margin-bottom: 0px; margin-top: 6px; opacity:0.5"></div>
				  </td>
				</tr>

				<tr>
				  <td colspan="4">
				  	<button style="height:15px; border:0; background-color: transparent;" id="btn-hideTr" value="+" onclick="hideTr()">&nbsp;</button>
				  </td>
				</tr>
				
				<tr id="trH1">
					<td valign="top" style="font-weight: bold; padding-top:9px; padding-left:10px;" class="text2"><?php echo dic("Routes.Vehicle")?>:</td>
					<td valign="top" style="">
						<select id="txt_vozilo" class="textboxCalender corner5 text2" style="width: 220px; margin-top: 2px; padding-top:5px; padding-bottom:3px" onchange="FilterByVeh(); uncheck(this.id); unchange()" onclick="$(this).focus();">
			 		   		<option value="0"><?php echo dic("Routes.SelectVeh")?></option>
							<?php														    
							    $dsVeh = query("select v.id, '(' || code || ') ' || rtrim(Registration) || ' - ' || model naziv  from Vehicles v where v.clientid=" . session("client_id") . " ORDER BY code::INTEGER");
								while($row = pg_fetch_array($dsVeh))
								{
									if($row["id"] == $vozilo)
									{
										echo "<option selected='selected' value='" . $row["id"] . "'>" . $row["naziv"] . "</option>";															
									} else {
										echo "<option value='" . $row["id"] . "'>" . $row["naziv"] . "</option>";
									}
								}
							?>
					   </select>
					</td>
					<td valign="top" colspan=2>
						<table id="promenakolona" width=100% class="text2" border="0" cellpadding="0" cellspacing="0" style="height: 30px; position: relative; float: left; top: 2px;">
						<tr>
								<td height="30px" align="left" style="width: 250px; vertical-align: top;">
									<span style="font-weight:bold; position: relative; float:left; padding-top: 8px"><?php echo dic_("Routes.User")?>:&nbsp;&nbsp;&nbsp;</span>
									<div>
										<table width="100%" class="text2" cellpadding="0" cellspacing="0">
										<tr>
											<td width="170px">
												<select id="txt_sofer1" class="textboxCalender corner5 text2" style="position:relative; float:left;width: 155px; padding-top:5px; padding-bottom:3px;" onchange="uncheck(this.id); unchange()" onclick="$(this).focus();">
													<option value="0"><?php echo dic("Routes.SelectUser")?></option>
													<?php
													while($row = pg_fetch_array($dsDriver))
													{
														if($row["id"] == $driverid1)
															echo "<option selected='selected' value='" . $row["id"] . "'>" . $row["code"] . " - " . $row["fullname"] . "</option>";
														else
															echo "<option value='" . $row["id"] . "'>" . $row["code"] . " - " . $row["fullname"] . "</option>";
													}$dsDriver = query("select ID, code, FullName from Drivers where clientID=" . session("client_id") . " order by FullName");
													while($row = pg_fetch_array($dsDriver))
													{
														echo "<option value='" . $row["id"] . "'>" . $row["code"] . " - " . $row["fullname"] . "</option>";
													}
													?>
											  	</select>
											  	<select id="txt_sofer2" onchange="unchange()" class="textboxCalender corner5 text2" style="position:relative; float:left; display: none; width: 155px; padding-top:5px; padding-bottom:3px; margin-left:5px" onclick="$(this).focus();">
														<option value="0"><?php echo dic("Routes.SelectUser")?></option>
														<?php
														$dsDriver = query("select ID, code, FullName from Drivers where clientID=" . session("client_id") . " order by FullName");
														while($row = pg_fetch_array($dsDriver))
														{
															if($row["id"] == $driverid2)
																echo "<option selected='selected' value='" . $row["id"] . "'>" . $row["code"] . " - " . $row["fullname"] . "</option>";
															else
																echo "<option value='" . $row["id"] . "'>" . $row["code"] . " - " . $row["fullname"] . "</option>";
														}
														?>
												</select>
												<select id="txt_sofer3" onchange="unchange()" class="textboxCalender corner5 text2" style="position:relative; float:left; display: none; width: 155px; padding-top:5px; padding-bottom:3px; margin-left:5px" onclick="$(this).focus();">
													<option value="0"><?php echo dic("Routes.SelectUser")?></option>
													<?php
													$dsDriver = query("select ID, code, fullname from Drivers where clientID=" . session("client_id") . " order by FullName");
													while($row = pg_fetch_array($dsDriver))
													{
														if($row["id"] == $driverid3)
															echo "<option selected='selected' value='" . $row["id"] . "'>" . $row["code"] . " - " . $row["fullname"] . "</option>";
														else
															echo "<option value='" . $row["id"] . "'>" . $row["code"] . " - " . $row["fullname"] . "</option>";
													}
													?>
												</select>
												
												<button style="width:29px; height:29px; margin-left: 5px;" id="PlusDriver" value="+" onclick="AddDriver()">&nbsp;</button>
												<script>
												  	$('#PlusDriver').button({ icons: { primary: "ui-icon-plus"} });
												  	function AddDriver()
												  	{
												  		if($('#txt_sofer2').css('display') == 'none')
													  	{
													  		$('#txt_sofer2').css({ display: 'block'});
													  		$('#MinusDriver2').css({ display: 'inline-block'});
													  	}else
													  	{
													  		if($('#txt_sofer3').css('display') == 'none')
													  		{
														  		$('#txt_sofer3').css({ display: 'block'});
														  		$('#PlusDriver').css({ display: 'none'});
														  	}
													  	}
													  	$('#PlusDriver').attr({ class: $('#PlusDriver').attr('class').replace('ui-state-hover', 'ui-state') });
												  	}
												</script>
												<button style="width:29px; margin-left: 5px; display: none;" id="MinusDriver2" value="-" onclick="DelDriver()">&nbsp;</button>
												<script>
													$('#MinusDriver2').button({ icons: { primary: "ui-icon-minus"} });
												  	function DelDriver()
												  	{
											  			if($('#txt_sofer3').css('display') == 'block')
													  	{
													  		$('#txt_sofer3').css({ display: 'none'});
													  		$('#PlusDriver').css({ display: 'inline-block'});
													  		txt_sofer3.selectedIndex = 0;
													  	}else
													  	{
													  		$('#txt_sofer2').css({ display: 'none'});
													  		$('#MinusDriver2').css({ display: 'none'});
													  		txt_sofer2.selectedIndex = 0;
													  	}
													  	$('#MinusDriver2').attr({ class: $('#MinusDriver2').attr('class').replace('ui-state-hover', 'ui-state') });
												  	}
												</script>
												
											</td>
											</tr>
										</table>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
						
				<tr id="trH2" height="38px">
					<td valign="top" style="padding-left:10px; padding-top:15px">
						<span class="text2" id="alerti" style="font-weight: bold;"><?php echo dic("Routes.Alarm")?>:</span>
					</td>
					<td valign="top" style="padding-top:0px">
						<select class="textboxCalender corner5 text2" id="txt_alert" onchange="unchange()" style="width: 50px; padding-top: 5px; padding-bottom: 3px; position: relative; top: -4px; margin-top: 10px;" onclick="$(this).focus();">
							<option value="/">/</option>
							<option value="5" <?php if($alarm == "5") { echo 'selected'; } ?>>5</option>
							<option value="10" <?php if($alarm == "10") { echo 'selected'; } ?>>10</option>
							<option value="15" <?php if($alarm == "15") { echo 'selected'; } ?>>15</option>
							<option value="20" <?php if($alarm == "20") { echo 'selected'; } ?>>20</option>
							<option value="30" <?php if($alarm == "30") { echo 'selected'; } ?>>30</option>
							<option value="45" <?php if($alarm == "45") { echo 'selected'; } ?>>45</option>
							<option value="60" <?php if($alarm == "60") { echo 'selected'; } ?>>60</option>
						</select>
						&nbsp;&nbsp;&nbsp;<span class="text2" style="position: relative; top: 5px;"><img id="alertiImg" src="../images/infocircle.png" /></span>
					</td>
					<td valign="top" style="padding-top:0px">
						<span class="text2" id="alertiWait" style="font-weight: bold"><?php echo dic_("Routes.Retention")?>:&nbsp;&nbsp;&nbsp;</span>
						<select class="textboxCalender corner5 text2" onchange="updateTotal(this.value); unchange()" id="txt_alertWait" style="width: 50px; padding-top: 5px; padding-bottom: 3px; position: relative; top: -4px; margin-top: 10px; margin-left: 16px;" onclick="$(this).focus();">
							<option value="/">/</option>
							<option value="5" <?php if($tostay == "5") { echo 'selected'; } ?>>5</option>
							<option value="10" <?php if($tostay == "10") { echo 'selected'; } ?>>10</option>
							<option value="15" <?php if($tostay == "15") { echo 'selected'; } ?>>15</option>
							<option value="20" <?php if($tostay == "20") { echo 'selected'; } ?>>20</option>
							<option value="30" <?php if($tostay == "30") { echo 'selected'; } ?>>30</option>
							<option value="45" <?php if($tostay == "45") { echo 'selected'; } ?>>45</option>
							<option value="60" <?php if($tostay == "60") { echo 'selected'; } ?>>60</option>
						</select>
						&nbsp;&nbsp;&nbsp;<span class="text2" style="position: relative; top: 5px;"><img id="alertiWaitImg" src="../images/infocircle.png" /></span>
					</td>
					<td valign="top" style="padding-top:0px">
						<table width=100% id="pauzapromenakolona" cellpadding="0" cellspacing="0" class="text2" border="0" style="height: 30px; position: relative; float: left; top: 2px;">
						<tr>
							<td height="30px" align="left" style="vertical-align: top; padding-top: 5px">
								<span style="font-weight:bold; position: relative; float:left; padding-top: 5px"><?php echo dic_("Settings.AlarmPause")?>:&nbsp;&nbsp;&nbsp;</span>
								<div>
									<select id="txt_pause1" onchange="updatePause(this.value, 1); unchange()" class="textboxCalender corner5 text2" style="position: relative; float: left; width: 55px; float: left; padding-top:5px; padding-bottom:3px;" onclick="$(this).focus();">
										<option value="0">/</option>
										<?php
										for($i=0; $i<sizeof($pauseTemp); $i++)
										{
											echo "<option value='" . $pauseTemp[$i] . "'>" . $pauseTemp[$i] . "</option>";
										}
										?>
								  	</select>
								  	
								  	<select id="txt_pause2" onchange="updatePause(this.value, 2); unchange()" class="textboxCalender corner5 text2" style="position: relative; float: left; display: none; width: 55px; margin-left: 5px; padding-top:5px; padding-bottom:3px;" onclick="$(this).focus();">
											<option value="0">/</option>
											<?php
											for($i=0; $i<sizeof($pauseTemp); $i++)
											{
												echo "<option value='" . $pauseTemp[$i] . "'>" . $pauseTemp[$i] . "</option>";
											}
											?>
									</select>
								
									<select id="txt_pause3" onchange="updatePause(this.value, 3); unchange()" class="textboxCalender corner5 text2" style="position: relative; float: left; display: none; margin-left: 5px; width: 55px; padding-top:5px; padding-bottom:3px;" onclick="$(this).focus();">
										<option value="0">/</option>
										<?php
											for($i=0; $i<sizeof($pauseTemp); $i++)
											{
												echo "<option value='" . $pauseTemp[$i] . "'>" . $pauseTemp[$i] . "</option>";
											}
										?>
									</select>
									
									<select id="txt_pause4" onchange="updatePause(this.value, 4); unchange()" class="textboxCalender corner5 text2" style="position: relative; float: left; display: none; margin-left: 5px; width: 55px; padding-top:5px; padding-bottom:3px;" onclick="$(this).focus();">
											<option value="0">/</option>
											<?php
											for($i=0; $i<sizeof($pauseTemp); $i++)
											{
												echo "<option value='" . $pauseTemp[$i] . "'>" . $pauseTemp[$i] . "</option>";
											}
											?>
									</select>
									
									<select id="txt_pause5" onchange="updatePause(this.value, 5); unchange()" class="textboxCalender corner5 text2" style="position: relative; float: left; display: none; margin-left: 5px; width: 55px; padding-top:5px; padding-bottom:3px;" onclick="$(this).focus();">								
										<option value="0">/</option>
										<?php
											for($i=0; $i<sizeof($pauseTemp); $i++)
											{
												echo "<option value='" . $pauseTemp[$i] . "'>" . $pauseTemp[$i] . "</option>";
											}
										?>
									</select>
									
									<button style="width:29px; height:29px; display: inline-block; margin-left: 5px; float: left;" id="PlusPause" value="+" onclick="AddPause()">&nbsp;</button>
									<script>
									  	jQuery.moveColumn = function (table, from, to) {
										    var rows = jQuery('tr', table);
										    var cols;
										    rows.each(function() {
										        cols = jQuery(this).children('th, td');
										        cols.eq(from).insertBefore(cols.eq(to));
										    });
										}
									  	$('#PlusPause').button({ icons: { primary: "ui-icon-plus"} });
									  	function AddPause()
									  	{
									  		var tbl = jQuery('#pauzapromenakolona');
									  		if($('#txt_pause2').css('display') == 'none')
										  	{
												
												jQuery.moveColumn(tbl, 5, 2);
												jQuery.moveColumn(tbl, 5, 3);
												jQuery.moveColumn(tbl, 4, 3);
												//jQuery.moveColumn(tbl, 5, 3);
										  		$('#txt_pause2').css({ display: 'inline-block'});
										  		$('#txt_pause2')[0].selectedIndex = 0
										  		$('#MinusPause').css({ display: 'inline-block'});
										  		
										  	}else
										  		if($('#txt_pause3').css('display') == 'none')
										  		{
										  			jQuery.moveColumn(tbl, 6, 3);
										  			jQuery.moveColumn(tbl, 5, 4);
										  			jQuery.moveColumn(tbl, 5, 4);
										  			$('#txt_pause3').css({ display: 'inline-block'});
										  			$('#txt_pause3')[0].selectedIndex = 0
									  			} else
										  			if($('#txt_pause4').css('display') == 'none')
											  		{
											  			jQuery.moveColumn(tbl, 7, 4);
											  			jQuery.moveColumn(tbl, 6, 5);
											  			jQuery.moveColumn(tbl, 6, 5);
											  			$('#txt_pause4').css({ display: 'inline-block'});
											  			$('#txt_pause4')[0].selectedIndex = 0
										  			} else
											  			if($('#txt_pause5').css('display') == 'none')
												  		{
												  			jQuery.moveColumn(tbl, 8, 5);
												  			jQuery.moveColumn(tbl, 7, 6);
												  			jQuery.moveColumn(tbl, 8, 7);
												  			$('#txt_pause5').css({ display: 'inline-block'});
												  			$('#txt_pause5')[0].selectedIndex = 0
												  			$('#PlusPause').css({ display: 'none'});
											  			}
											$('#PlusPause').attr({ class: $('#PlusPause').attr('class').replace('ui-state-hover', 'ui-state') });
									  	}
									</script>
									<button style="width:29px;height:29px;  display: none; margin-left: 6px; float: left;" id="MinusPause" value="-" onclick="DelPause()">&nbsp;</button>
									<script>
										$('#MinusPause').button({ icons: { primary: "ui-icon-minus"} });
									  	function DelPause()
									  	{
									  		var tbl = jQuery('#pauzapromenakolona');
							  				if($('#txt_pause5').css('display') == 'inline-block')
										  	{
										  		$('#txt_pause5').css({ display: 'none'});
										  		jQuery.moveColumn(tbl, 8, 5);
										  		jQuery.moveColumn(tbl, 7, 6);
										  		jQuery.moveColumn(tbl, 8, 7);
										  		updatePause("0", 5);
										  		$('#PlusPause').css({ display: 'inline-block'});
										  		txt_pause5.selectedIndex = 0;
										  	}else
											  	if($('#txt_pause4').css('display') == 'inline-block')
											  	{
											  		jQuery.moveColumn(tbl, 5, 4);
											  		jQuery.moveColumn(tbl, 6, 5);
											  		jQuery.moveColumn(tbl, 7, 6);
											  		updatePause("0", 4);
											  		$('#txt_pause4').css({ display: 'none'});
											  		txt_pause4.selectedIndex = 0;
											  	}else
												  	if($('#txt_pause3').css('display') == 'inline-block')
												  	{
												  		jQuery.moveColumn(tbl, 4, 3);
												  		jQuery.moveColumn(tbl, 5, 4);
												  		jQuery.moveColumn(tbl, 6, 5);
												  		updatePause("0", 3);
												  		$('#txt_pause3').css({ display: 'none'});
												  		txt_pause3.selectedIndex = 0;
												  	}else
														if($('#txt_pause2').css('display') == 'inline-block')
														{
															updatePause("0", 2);												
															$('#txt_pause2').css({ display: 'none'});
															jQuery.moveColumn(tbl, 3, 2);
															jQuery.moveColumn(tbl, 4, 3);
															jQuery.moveColumn(tbl, 5, 3);
															$('#MinusPause').css({ display: 'none'});
															txt_pause2.selectedIndex = 0;
														}
											$('#MinusPause').attr({ class: $('#MinusPause').attr('class').replace('ui-state-hover', 'ui-state') });
									  	}
									</script>
									<img id="pauseImg" src="../images/infocircle.png" style="float: left; position: relative; margin-left: 17px; top: 4px;" />
									
								</div>
							</td>
						</tr>
					</table>						
					</td>
				</tr>
				
				
			
			
			
			<?php
		if (session("client_id") == 367) {
			$dsRouteDefCul = query("select * from route_defculture where id = ". $culID);
		?>
		
		<tr id="trH3">
			<td colspan=4 style="padding-left:10px;  padding-bottom: 10px;" class="text2">
				<div id="cultures">
					<div id="1culture">
				<span style="font-weight: bold;"><?= dic("Settings.Culture")?>:&nbsp;&nbsp;&nbsp;</span>
				<select id="culture" onchange="changeCulture()" class="textboxCalender corner5 text2" style="width:<?php if($yourbrowser == "1") { echo '140px'; } else { echo '150px'; } ?>; padding-top:5px; padding-bottom:3px;" onclick="$(this).focus();">
					<option id=0 value="0">-<?= dic("Routes.Select")?>-</option>
					<?php
					$dsCultures = query("select * from route_culture where clientid=" . session("client_id"));
					
							while ($drCultures = pg_fetch_array($dsCultures)) {
								if (pg_fetch_result($dsRouteDefCul, 0, "culid") == $drCultures["id"]) $selCul = "selected";
								else $selCul = "";
							?>
								<option id=<?php echo $drCultures["id"]?> value=<?php echo $drCultures["id"]?> <?= $selCul?> ><?php echo $drCultures["name"]?></option>
							<?php	
							}
							?>
						</select>
						
						<span style="font-weight: bold; padding-left:7px;"><?= dic("Settings.Operation")?>:&nbsp;</span>
						<select id="operation"  onchange="changeOperation()" class="textboxCalender corner5 text2" style="width:<?php if($yourbrowser == "1") { echo '140px'; } else { echo '150px'; } ?>; padding-top:5px; padding-bottom:3px; margin-left:3px" onclick="$(this).focus();">
							<option id=0 value="0">-<?= dic("Routes.Select")?>-</option>
							<?php
							$dsOperations = query("select * from route_operation where clientid=" . session("client_id"));
							
							while ($drOperations = pg_fetch_array($dsOperations)) {
								if (pg_fetch_result($dsRouteDefCul, 0, "operid") == $drOperations["id"]) $selOper = "selected";
								else $selOper = "";
							?>
								<option id=<?php echo $drOperations["id"]?> value=<?php echo $drOperations["id"]?> <?= $selOper?> ><?php echo $drOperations["name"]?></option>
							<?php	
							}
							?>
						</select>
						<span style="font-weight: bold; padding-left:7px;"><?= dic("Settings.Material")?>:&nbsp;</span>
						<select id="material" onchange="changeMaterial()" class="textboxCalender corner5 text2" style="width:<?php if($yourbrowser == "1") { echo '140px'; } else { echo '150px'; } ?>; padding-top:5px; padding-bottom:3px; margin-left:3px" onclick="$(this).focus();">
							<option id=0 value="0">-<?= dic("Routes.Select")?>-</option>
							<?php
							$dsMaterials = query("select * from route_material where clientid=" . session("client_id"));
							
							while ($drMaterials = pg_fetch_array($dsMaterials)) {
								if (pg_fetch_result($dsRouteDefCul, 0, "matid") == $drMaterials["id"]) $selMat = "selected";
								else $selMat = "";
							?>
								<option id=<?php echo $drMaterials["id"]?> value=<?php echo $drMaterials["id"]?> <?= $selMat?> ><?php echo $drMaterials["name"]?></option>
							<?php	
							}
							?>
						</select>
						<span style="font-weight: bold; padding-left:7px;"><?= dic("Routes.AddedMechanisation")?>:&nbsp;</span>
						<select id="mechanisation" class="textboxCalender corner5 text2" style="width:<?php if($yourbrowser == "1") { echo '140px'; } else { echo '150px'; } ?>; padding-top:5px; padding-bottom:3px; margin-left:3px" onclick="$(this).focus();">
							<option id=0 value="0">-<?= dic("Routes.Select")?>-</option>
							<?php
							$dsMechanisations = query("select * from route_mechanisation where clientid=" . session("client_id"));
							
							while ($drMechanisations = pg_fetch_array($dsMechanisations)) {
								if (pg_fetch_result($dsRouteDefCul, 0, "mechid") == $drMechanisations["id"]) $selMech = "selected";
								else $selMech = "";
							?>
								<option id=<?php echo $drMechanisations["id"]?> value=<?php echo $drMechanisations["id"]?> <?= $selMech?> ><?php echo $drMechanisations["name"]?></option>
					<?php	
					}
					?>
				</select>
					</div>
				</div>
			</td>
		</tr>
									
		<div id="optimizedNarrative" class="text9 corner15" style="display: none; right: 55px; overflow: hidden; width: 500px; height: 400px; position: absolute; background: none repeat scroll 0% 0% white; z-index: 10; opacity: 0.9; top: 35px;"></div>
							
				</td>
				</tr>
		<?php
		} 
		//else {
			?>
			<tr>
			  <td colspan="4">
			  	<div style="border-bottom: 1px dotted #95B1d7; width: 100%; margin-bottom: 0px; margin-top: 4px; opacity:0.5"></div>
			  </td>
			</tr>
			
			<tr height="20px">
				<td valign="top" style="padding-top:0px">
					<div style="top: 12px; position: relative; float:left; left:10px; font-weight:bold" class="text2"><?php echo dic_("Routes.SelectLocation")?>: </div>
				</td>
				<td colspan=3 valign="top" id="widthR" align="center" class="text3" style="text-align: left; background-color: transparent; color:#39ae58; font-weight:bold; cursor:pointer; margin-top: 0px; padding-top:7px">       		
	    			<div class="ui-widget" style="height: 25px; width: 83%; position: relative; float: left; top: 1px;">
	    				<input type="text" value="" onclick="$(this).focus()" onblur="hideSearchBox()" onfocus="" onkeydown="OnKeyPressSearch(event.keyCode)" id="txt_markers" name="txt_markers" style="width:100%; height: 25px; margin-left: 0px;" /><br>
	    				<div id="div-search-rez" class="kiklop-corner kiklop-shadow"  style="display:none; position: absolute; min-width: 500px; min-height: 40px; max-height: 240px; background-color:#fff; border: 1px solid #b2b2b2; z-index:9999; margin-left: 0px; overflow-y: auto; overflow-x:hidden"></div>
	                	<div id="div-search-rez1" class=""  style="display:none;"></div>
	                </div>
						
					<button id="btn-prezemi" onClick="ShowPrezemi()" style="position:relative; display: inline-block; float:right; margin-top: 1px; margin-right: 10px"><?= dic("Routes.DL")?></button>
				</td>
			</tr>
		
			<tr height="20px">
				<td valign="top" colspan=4>
	                <div height="auto" align="center" class="text3" style="min-height: 34px; background-color:#fff; color:#39ae58; font-weight:bold; border:1px dotted #B8B8B8; cursor:pointer; position: relative; margin-top: 6px; margin-right: 10px; margin-left:10px; margin-bottom:10px;">
		                <div id="MarkersIN" style="position: relative; background: transparent; top: 0px; opacity:0.9; z-index:999; bottom:2px; overflow-X: hidden; overflow-Y: auto;  height: auto; min-height: 34px; max-height: 240px; width: 100%;" class="text9 corner5"></div>
	                    <div id="PauseOnRoute" style="position: relative; background: transparent; top: 0px; opacity:0.9; z-index:999; bottom:2px; overflow-X: hidden; overflow-Y: auto;  height: auto; max-height: 240px; width: 100%;" class="text9 corner5"></div>
	                    <div id="IDMarker_Total" style="display: none; cursor: pointer; border-top: 1px dotted #B8B8B8; border-radius: 0px; font-size:12; width:97%; padding:2px 2px 2px 7px; height:26px; background-position: right center; background-repeat: no-repeat; background-origin: content-box;" class="text8 corner5">
	                		<input type="text" style="font-size: 11px; cursor: pointer; width: 21%; text-align: left; padding-left: 2px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" value="/" readonly="readonly" class="text9">
	                		<input type="text" style="font-size: 11px; cursor: pointer;  text-align: left; width: 54%; padding-left: 3px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" value="/" readonly="readonly" class="text9">
	                		<input type="text" style="cursor: pointer; width: 25%; text-align: right; right: 20px; position: relative; float: left; font-size: 12px; font-weight: bold; margin-top: 4px; background: transparent; border: 0px;" value="<?= dic_("Reports.Total")?>" readonly="readonly" class="text2" />
	            		</div>
	        		</div>
	        		<div id="optimizedNarrative" class="text9 corner15" style="display: none; right: 540px; overflow: hidden; width: 500px; height: 400px; position: absolute; background: none repeat scroll 0% 0% white; z-index: 10; opacity: 0.9; top: 35px;"></div>
	            </td>

			<?php
		//}
		?>
					
			</tr>				
			</table>
			
		</td>
				
			</tr>
			
			<tr>
				<td style="vertical-align: top;">
					<div id="div-map" style="width: 98%; height:700px; position: relative; z-index: 1; top: 0px; left:10px; border:1px dotted #2f5185;"></div>
				</td>
			</tr>
			
		</table>
			
	<br>
	<div id="footer-rights-new" class="textFooter" style="padding:10px 10px 10px 10px">

	</div>
	
	<div id="div-mb" style="display:none" title="<?php echo dic_("Routes.AddingNewRoute")?>">
		<br><br>
		<span class="text4" style="padding:20px 20px 20px 20px; font-size:16px">
			<span class="ui-icon ui-icon-check" style="float:left; margin:0 7px 50px 0;"></span>
			<?php echo dic_("Routes.RouteTOrderNum")?> <font id="newroutenum"></font> <?php echo dic_("Tracking.SucAdd")?><br>
		</span>
	</div>
	
	<div id="div-print" style="display:none">
		<iframe id="frm-print" frameborder="0" scrolling="no" style="width:100%; height:1200px"></iframe>
	</div>
	<div id="div-prez" title="<?php echo dic_("Routes.DL")?>" style="display:none">
		<select id="txt_pre" style="width:270; font-size:14px"  size="15" class="text5">
			<?php
				
				$dsPre = query("select id, name from rNaloghederpre where Name<>'' and clientID=" . session("client_id"));
				
				while($row = pg_fetch_array($dsPre)) {
			?>
			<option value="<?php echo $row["id"]?>"ondblclick="Prevzemi1()" ><?php echo $row["name"]?></option>
			<?php
				}
			?>
		</select>
	</div>
</div>
<iframe id="frm-excel" frameborder="0" scrolling="no" style="display:none"></iframe>
</body>
</html>



<script type="text/javascript">

	$("#div-Directions").mousemove(function(event) {
		$(this).css({opacity: '1'});
    });
    $("#div-Directions").mouseout(function(event) {
    	$(this).css({opacity: '0.8'});
    });
    
    $('#btnDirections').button();
    $('#btnSaveDirections').button();
    $('#btnCancelDirections').button();
    $("#toDirection").autocomplete({
        //This bit uses the geocoder to fetch address values
        source: function (request, response) {
            geocoder.geocode({ 'address': request.term }, function (results, status) {
                response($.map(results, function (item) {
                    return {
                        label: item.formatted_address,
                        value: item.formatted_address,
                        latitude: item.geometry.location.lat(),
                        longitude: item.geometry.location.lng()
                    }
                }));
            })
        },
        //This bit is executed upon selection of an address
        select: function (event, ui) {
        	clearDirectionE();
        	ButtonAddEndDirectionClick();
        	setCenterMap(ui.item.longitude, ui.item.latitude, 18, 0);
        	AddMarkerDestinationE1(ui.item.longitude, ui.item.latitude);
        	//ButtonAddDirectionClick(event, 0);
            /*setCenterMap(ui.item.longitude, ui.item.latitude, 18, num);
            AddMarkerS(ui.item.longitude, ui.item.latitude, num, ui.item.label);*/
           
        },
        open: function () { clearDirectionE('0'); $("#toDirection").autocomplete("widget").width(269); }
    });
    $("#fromDirection").autocomplete({
        //This bit uses the geocoder to fetch address values
        source: function (request, response) {
            geocoder.geocode({ 'address': request.term }, function (results, status) {
                response($.map(results, function (item) {
                    return {
                        label: item.formatted_address,
                        value: item.formatted_address,
                        latitude: item.geometry.location.lat(),
                        longitude: item.geometry.location.lng()
                    }
                }));
            })
        },
        //This bit is executed upon selection of an address
        select: function (event, ui) {
        	//$("#vozilcaDirection option[value=-1]").attr('selected', 'selected');
        	$("#vozilcaDirection").val(-1);
        	clearDirectionS();
        	ButtonAddStartDirectionClick();
        	setCenterMap(ui.item.longitude, ui.item.latitude, 18, 0);
        	AddMarkerDestinationS1(ui.item.longitude, ui.item.latitude);
        },
        open: function () { clearDirectionS('0'); $("#fromDirection").autocomplete("widget").width(269); }
    });
    function clearDirectionS(_ch) {
    	$('#fromDirection').removeAttr('required');
	    if (tmpMarkerDirectionS != undefined) {
	        vectors[0].removeFeatures(tmpMarkerDirectionS);
	        tmpMarkerDirectionS = undefined;
	    }
	    if(_ch == undefined)
	    	$('#fromDirection').val('')
    	$('#direcitonAddress').val('');
    	$('#directionLat').val('');
    	$('#directionLon').val('');
    	$('#ResultDirections').css({ display: 'none' });
        $('#ResultDirections').html('');
        $('#ResultDirectionsF').css({ display: 'none' });
        $('#ResultDirectionsF').html('');
        $('#ResultDirectionsTable').css({ display: 'none' });
        if(lineFeatureDirections[0] != undefined) {
	        for (var i = 0; i < lineFeatureDirections[0].length; i++) {
	            vectors[0].removeFeatures([lineFeatureDirections[0][i]]);
	        }
	        lineFeatureDirections[0] = [];
       	}
       	if(lineFeatureDirections[1] != undefined) {
	        for (var i = 0; i < lineFeatureDirections[1].length; i++) {
	            vectors[0].removeFeatures([lineFeatureDirections[1][i]]);
	        }
	        lineFeatureDirections[1] = [];
       	}
    }
    function clearDirectionE(_ch) {
    	$('#toDirection').removeAttr('required');
    	if (tmpMarkerDirectionE != undefined) {
	        vectors[0].removeFeatures(tmpMarkerDirectionE);
	        tmpMarkerDirectionE = undefined;
	    }
	    if(_ch == undefined)
	    	$('#toDirection').val('')
	    $('#direcitonAddressEnd').val('');
    	$('#directionLatEnd').val('');
    	$('#directionLonEnd').val('');
    	$('#ResultDirections').css({ display: 'none' });
        $('#ResultDirections').html('');
        $('#ResultDirectionsF').css({ display: 'none' });
        $('#ResultDirectionsF').html('');
        $('#ResultDirectionsTable').css({ display: 'none' });
        if(lineFeatureDirections[0] != undefined) {
	        for (var i = 0; i < lineFeatureDirections[0].length; i++) {
	            vectors[0].removeFeatures([lineFeatureDirections[0][i]]);
	        }
	        lineFeatureDirections[0] = [];
       	}
       	if(lineFeatureDirections[1] != undefined) {
	        for (var i = 0; i < lineFeatureDirections[1].length; i++) {
	            vectors[0].removeFeatures([lineFeatureDirections[1][i]]);
	        }
	        lineFeatureDirections[1] = [];
       	}
    }
    function ChangeVozDir() {
    	ButtonAddStartDirectionClick();
    	clearDirectionS();
    	if($("#vozilcaDirection").find('option:selected').val() != '-1') {
	    	for(var i=0; i<Car.length; i++) {
	            if(Car[i].id == $("#vozilcaDirection").find('option:selected').val()){
	                $('#direcitonAddress').val('');
				    $('#directionLon').val('');
				    $('#directionLat').val('');
				    $('#loadingDirectionAddress').css({ display: "block" });
				    $.ajax({
				        url: twopoint + "/main/getGeocode.php?lon=" + Car[i].lon + "&lat=" + Car[i].lat + "&tpoint=" + twopoint,
				        context: document.body,
				        success: function (data) {
				            $('#direcitonAddress').val(data);
				            $('#loadingDirectionAddress').css({ display: "none" });
				            $('#fromDirection').val($("#vozilcaDirection").find('option:selected').html())
				        }
				    });
				    $('#directionLat').val(Car[i].lat)
				    $('#directionLon').val(Car[i].lon)
	                break;
	            }
	        }
       	}
    }
    function SwitchPoints() {
    	var tmpLon = $('#directionLon').val();
    	var tmpLat =  $('#directionLat').val();
    	var tmpFromDir =  $('#fromDirection').val();
    	var tmpDirAddress = $('#direcitonAddress').val();
    	vectors[0].removeFeatures(tmpMarkerDirectionS);
    	tmpMarkerDirectionS = undefined;
    	vectors[0].removeFeatures(tmpMarkerDirectionE);
	    tmpMarkerDirectionE = undefined;
	    
	    $('#directionLon').val($('#directionLonEnd').val());
	    $('#directionLat').val($('#directionLatEnd').val());
    	$('#fromDirection').val($('#toDirection').val());
    	$('#direcitonAddress').val($('#direcitonAddressEnd').val());
    	
    	$('#directionLonEnd').val(tmpLon);
	    $('#directionLatEnd').val(tmpLat);
    	$('#toDirection').val(tmpFromDir);
    	$('#direcitonAddressEnd').val(tmpDirAddress);
    	
    	AddMarkerDirectionS($('#directionLon').val(), $('#directionLat').val(), 0, $('#direcitonAddress').val());
    	AddMarkerDirectionE($('#directionLonEnd').val(), $('#directionLatEnd').val(), 0, $('#direcitonAddressEnd').val());
    	
    	$('#ResultDirections').css({ display: 'none' });
	    $('#ResultDirections').html('');
	    $('#ResultDirectionsF').css({ display: 'none' });
	    $('#ResultDirectionsF').html('');
	    $('#ResultDirectionsTable').css({ display: 'none' });
	    $("#vozilcaDirection").val(-1);
	    GetDirections('1');
    }


	//haveStartPoi = false;
	//haveEndPoi = false;
	var ttt = 1;

	$("#txt_markers").kiklopTextbox();
	var startId = '';
	var endId = '';
	var lastIds = '';
	var endVal = '';
	
	function putNewMarker(_id){	
		var _se = 0;
		if ($('#MarkersIN')[0].children.length > 0 && haveEndPoi == true) {
		   	endId = PointsOfRoute[PointsOfRoute.length-1].id; 
		} else {
			endId = 0;
		}
		   	
		   	var ret = "";	
			$.ajax({
		        url: "./LoadEndPoi.php?poiid=" + endId,
		        context: document.body,
		        success: function (data) {
		        	var _dat = data;
		        	_dat = _dat.replace(/\r/g,'').replace(/\n/g,'');
		        	if (endId == 0) endVal = '';
		            else endVal = _dat;
		                      
		            uncheck('#MarkersIN');
				
					var _val = $('#'+_id).val();      
			       				       
			        if (haveStartPoi == false || haveEndPoi == false) {
			        	if (haveStartPoi == true) {
			        		$('#divStartRoute').hide();
			        		$('#divMidRoute').hide();
			        	}
				    	else {
				    		$('#divStartRoute').show();
				    		$('#divMidRoute').hide();
				    	}
				    	if (haveStartPoi == false && haveEndPoi == false) {
				    		$('#divMidRoute').show();
				    	}
				    	if (haveEndPoi == true) $('#divEndRoute').hide();
				    	else $('#divEndRoute').show();
			        	$('#insertStartEnd').dialog({ modal: true, width: 350, height: 180, resizable: false, zIndex: 9998,
						buttons: 
				    	[{
				        	text:dic("Insert"),
						    click: function() {
						    	if ($('#startRoutePoi').is(':checked') || $('#endRoutePoi').is(':checked')) {
					              	if ($('#startRoutePoi').is(':checked')) {
					              		//alert(PointsOfRoute.length)
					              		if (endId != "" || PointsOfRoute.length > 1) {
					              			var kikiIDs = "";
					              			var kikiVals = "";
					              			for (var i=1; i < PointsOfRoute.length; i++) {
					              				kikiIDs += PointsOfRoute[i].id + ";";
					              				kikiVals += $("#" + PointsOfRoute[i].id).val() + ";";
					              			}
					              			
					              			$('#MarkersIN').html('');
											/*$('#PauseOnRoute').html('');
											$('#IDMarker_Total').css({ display: 'none' });
											$('#IDMarker_Total')[0].children[0].value = "/";
											$('#IDMarker_Total')[0].children[1].value = "/";*/
											//ClearGraphicRoute();
											//PointsOfRoute = [];
											//for (var j = 0; j < tmpMarkersRoute.length; j++)
											//    Markers[0].removeMarker(tmpMarkersRoute[j]);
											for (var j = 0; j < tmpMarkersRoute.length; j++) {
												Markers[0].removeMarker(tmpMarkersRoute[j]);
											}
											tmpMarkersRoute = [];
											PointsOfRoute = [];
					              			
					              			startId = _id;
						              		haveStartPoi = true;
						              		backCol = "#BCEBA0";
						              		if ($('#startRoutePoi').is(':checked') && $('#endRoutePoi').is(':checked')) _se = 1;
						              		putInRouteKiki(_val.split("|")[0], _val.split("|")[2], _val.split("|")[3], _val.split("|")[1], 1, _val.split("|")[0], _val.split("|")[4], backCol, _se);
								
											var arrKikiIDs = kikiIDs.split(";");
											var arrKikiVals = kikiVals.split(";");
											for (var j=0; j<arrKikiIDs.length-1; j++) {
												if (j == arrKikiIDs.length-2 && endId != "") {
													//if ($('#'+arrKikiIDs[j]).val() == undefined) {alert(arrKikiVals[j] + " " + arrKikiIDs[j] + "#3")}
													//putInRouteKiki(arrKikiVals[j].split("|")[0], $('#'+arrKikiIDs[j]).val().split("|")[2], $('#'+arrKikiIDs[j]).val().split("|")[3], $('#'+arrKikiIDs[j]).val().split("|")[1], 1, $('#'+arrKikiIDs[j]).val().split("|")[0], $('#'+arrKikiIDs[j]).val().split("|")[4], '#FAC3C3');
													if ($('#startRoutePoi').is(':checked') && $('#endRoutePoi').is(':checked')) _se = 1;
													putInRouteKiki(arrKikiVals[j].split("|")[0], arrKikiVals[j].split("|")[2], arrKikiVals[j].split("|")[3], arrKikiVals[j].split("|")[1], 1, arrKikiVals[j].split("|")[0], arrKikiVals[j].split("|")[4], '#FAC3C3', _se);	
												} else {
													//if ($('#'+arrKikiIDs[j]).val() == undefined) {alert(arrKikiVals[j] + " " + arrKikiIDs[j] + "#4")}
													//putInRouteKiki($('#'+arrKikiIDs[j]).val().split("|")[0], $('#'+arrKikiIDs[j]).val().split("|")[2], $('#'+arrKikiIDs[j]).val().split("|")[3], $('#'+arrKikiIDs[j]).val().split("|")[1], 1, $('#'+arrKikiIDs[j]).val().split("|")[0], $('#'+arrKikiIDs[j]).val().split("|")[4], '#fff');
													if ($('#startRoutePoi').is(':checked') && $('#endRoutePoi').is(':checked')) _se = 1;
													putInRouteKiki(arrKikiVals[j].split("|")[0], arrKikiVals[j].split("|")[2], arrKikiVals[j].split("|")[3], arrKikiVals[j].split("|")[1], 1, arrKikiVals[j].split("|")[0], arrKikiVals[j].split("|")[4], '#fff', _se);
												}
											}
					              		
					              			//putInRouteKiki($('#'+endId).val().split("|")[0], $('#'+endId).val().split("|")[2], $('#'+endId).val().split("|")[3], $('#'+endId).val().split("|")[1], 1, $('#'+endId).val().split("|")[0], $('#'+endId).val().split("|")[4], '#FAC3C3');
					              			//return;
					              		} else {
					              			startId = _id;
					              			haveStartPoi = true;
					              			backCol = "#BCEBA0";
					              			if ($('#startRoutePoi').is(':checked') && $('#endRoutePoi').is(':checked')) _se = 1;
					              			putInRouteKiki(_val.split("|")[0], _val.split("|")[2], _val.split("|")[3], _val.split("|")[1], 1, _val.split("|")[0], _val.split("|")[4], backCol, _se);
					              		}
					              	}
					              	if ($('#endRoutePoi').is(':checked')) {
					              		endId = _id;
					              		endVal = _val;
										haveEndPoi = true;
									    backCol = "#FAC3C3";  
									    if ($('#startRoutePoi').is(':checked') && $('#endRoutePoi').is(':checked')) _se = 1;
									    putInRouteKiki(_val.split("|")[0], _val.split("|")[2], _val.split("|")[3], _val.split("|")[1], 1, _val.split("|")[0], _val.split("|")[4],backCol, _se);
							    	}
							    	$("#startRoutePoi").removeAttr('checked');
									$("#endRoutePoi").removeAttr('checked');
									$(this).dialog("destroy");
						    	} else {
						    		alert(dic("Routes.NotSelOpt"))
						    	}
						    	
				              }	
						},
						{
				        	text:dic("cancel"),
						    click: function() {
						    	if (endId != "") {
					        		//var lastChlidTmp = $("#MarkersIN")[0].children[$("#MarkersIN")[0].children.length-1];
					    			$("#MarkersIN")[0].children[$("#MarkersIN")[0].children.length-1].remove();
									PointsOfRoute.splice(PointsOfRoute.length-1);
									Markers[0].removeMarker(tmpMarkersRoute[tmpMarkersRoute.length-1]);
									tmpMarkersRoute.splice(tmpMarkersRoute.length-1);
					    			
					    			if ($('#startRoutePoi').is(':checked') && $('#endRoutePoi').is(':checked')) _se = 1;
					    			putInRouteKiki(_val.split("|")[0], _val.split("|")[2], _val.split("|")[3], _val.split("|")[1], 1, _val.split("|")[0], _val.split("|")[4], '#fff', _se, function(ret) {
									    //if ($('#'+endId).val() == undefined) {alert(endVal + " " + endId + "#2")}
									    //putInRouteKiki($('#'+endId).val().split("|")[0], $('#'+endId).val().split("|")[2], $('#'+endId).val().split("|")[3], $('#'+endId).val().split("|")[1], 1, $('#'+endId).val().split("|")[0], $('#'+endId).val().split("|")[4], '#FAC3C3', function(ret) {
									    putInRouteKiki(endVal.split("|")[0], endVal.split("|")[2], endVal.split("|")[3], endVal.split("|")[1], 1, endVal.split("|")[0], endVal.split("|")[4], '#FAC3C3', _se, function(ret) {
									    	setTimeout(zoomWorldScreen(Maps[0], 15), 6000);
										});
									});
									
					    			//putInRouteKiki(_val.split("|")[0], _val.split("|")[2], _val.split("|")[3], _val.split("|")[1], 1, _val.split("|")[0], _val.split("|")[4], '#fff');
					        		//putInRouteKiki($('#'+endId).val().split("|")[0], $('#'+endId).val().split("|")[2], $('#'+endId).val().split("|")[3], $('#'+endId).val().split("|")[1], 1, $('#'+endId).val().split("|")[0], $('#'+endId).val().split("|")[4], '#FAC3C3');
					        		$(this).dialog("destroy");
					        	} else {
					        		if ($('#startRoutePoi').is(':checked') && $('#endRoutePoi').is(':checked')) _se = 1;
					        		putInRouteKiki(_val.split("|")[0], _val.split("|")[2], _val.split("|")[3], _val.split("|")[1], 1, _val.split("|")[0], _val.split("|")[4], '#fff', _se);
					        		$(this).dialog("destroy");
					        	}
						    }
						}
						]
					});
			        } else {
			        	
			        	if (endId != "") {
			        		//var lastChlidTmp = $("#MarkersIN")[0].children[$("#MarkersIN")[0].children.length-1];
			    			$("#MarkersIN")[0].children[$("#MarkersIN")[0].children.length-1].remove();
			    			PointsOfRoute.splice(PointsOfRoute.length-1);
			    			Markers[0].removeMarker(tmpMarkersRoute[tmpMarkersRoute.length-1]);
			    			tmpMarkersRoute.splice(tmpMarkersRoute.length-1);
			    			
			    			if ($('#startRoutePoi').is(':checked') && $('#endRoutePoi').is(':checked')) _se = 1;
			    			putInRouteKiki(_val.split("|")[0], _val.split("|")[2], _val.split("|")[3], _val.split("|")[1], 1, _val.split("|")[0], _val.split("|")[4], '#fff', _se, function(ret) {
							    putInRouteKiki(endVal.split("|")[0], endVal.split("|")[2], endVal.split("|")[3], endVal.split("|")[1], 1, endVal.split("|")[0], endVal.split("|")[4], '#FAC3C3', _se, function(ret) {
							    	setTimeout(zoomWorldScreen(Maps[0], 15), 6000);
								});
							});
									
			    			//putInRouteKiki(_val.split("|")[0], _val.split("|")[2], _val.split("|")[3], _val.split("|")[1], 1, _val.split("|")[0], _val.split("|")[4], '#fff');
			        		//putInRouteKiki($('#'+endId).val().split("|")[0], $('#'+endId).val().split("|")[2], $('#'+endId).val().split("|")[3], $('#'+endId).val().split("|")[1], 1, $('#'+endId).val().split("|")[0], $('#'+endId).val().split("|")[4], '#FAC3C3');
			        		$(this).dialog("destroy");
			        	} else {
			        		if ($('#startRoutePoi').is(':checked') && $('#endRoutePoi').is(':checked')) _se = 1;
			        		putInRouteKiki(_val.split("|")[0], _val.split("|")[2], _val.split("|")[3], _val.split("|")[1], 1, _val.split("|")[0], _val.split("|")[4], '#fff', _se);
			        		$(this).dialog("destroy");
			        	}
			        }
			        		
			        clearSearchBox();
			        $('#div-search-rez').css({display:'none'});
			        lastIds += _id + ";";
			        //alert(lastIds)
			        
		            //pom (endId, endVal, _id);
				}
			});		
		//}
							 	
	   	/*var ret = "";		   	
	    $.ajax({
	        url: "../main/LoadRoutePre.php?id=" + <= $id?> + "&tpoint=..",
	        context: document.body,
	        success: function (data) {
	            var _dat = data;
	            _dat = _dat.replace(/\r/g,'').replace(/\n/g,'');
	            if(_dat != "notok")
	            {
	            	var i = _dat.split("#@")[0].split("#").length-1;
	            	endVal = _dat.split("#@")[0].split("#")[i].split("|")[2]+"|"+_dat.split("#@")[0].split("#")[i].split("|")[3]+"|"+_dat.split("#@")[0].split("#")[i].split("|")[0]+"|"+_dat.split("#@")[0].split("#")[i].split("|")[1]+"|1";
	            	alert(endId)
	            	alert(endVal)
	            	alert(_id)
	            	pom (endId, endVal, _id);
				}
			}
		});	 */
	}
	
	function hideSearchBoxTrue(){
		$('#div-search-rez').css({display:'none'})
	}
	function hideSearchBox(){
		setTimeout("hideSearchBoxTrue()",500)
		setTimeout("clearSearchBox()",15*1000)
	}
	function clearSearchBox(){
		$("#txt_markers").val("");	
	}
	var selectedElement = -1;
	var cntUpDown1 = 1;
	var _idx = 0;
	function OnKeyPressSearch(_key){
		if(_key == 27)
		{
			clearSearchBox();
			$('#div-search-rez').css({display:'none'});
		} else{
			setTimeout(function(){
			var txt = $('#txt_markers').val()
			if(_key == 38 ||_key == 40 || _key == 13)
			{
				if($('#div-search-rez').css('display') == 'none')
				{
					$('#div-search-rez').css({display:'block'})
					$('#div-search-rez').load('./loadpointsofinterestAll.php?q='+encodeURIComponent(txt));
				} else
				{
					if(_key == 40 && selectedElement < $('#div-search-rez').children().length-1)
					{
						$('#div-search-rez .kiklop-list-item-select').removeClass('kiklop-list-item-select');
						$($('#div-search-rez').children()[selectedElement+1]).addClass('kiklop-list-item-select')

						if (_idx == 6)	{
							var st = (cntUpDown1*40);
							$("#div-search-rez").scrollTop(st);
							cntUpDown1++;
							_idx = 6;
						} else {
							if (_idx == 6)
								{_idx = 1;}
							else
								{_idx++;}
						}

						selectedElement++;
					}
					if(_key == 38 && selectedElement > 0)
					{
						$('#div-search-rez .kiklop-list-item-select').removeClass('kiklop-list-item-select');
						$($('#div-search-rez').children()[selectedElement-1]).addClass('kiklop-list-item-select')
						
						if(_idx == 1) {
							var st = ((cntUpDown1-2)*40);
							$("#div-search-rez").scrollTop(st);
							cntUpDown1--;
							_idx = 1;
							
						} else {
							if (_idx == 1)
								{_idx = 6;}
							else
								{_idx--;}
						}
						selectedElement--;
					}
					if(_key == 13)
					{
						var _idval = $($('#div-search-rez .kiklop-list-item-select')[0]).children()[0].id;
						putNewMarker(_idval);
						clearSearchBox();
						$('#div-search-rez').css({display:'none'});
					}
				}
			} else
			{
				$('#div-search-rez').css({display:'block'})
				if (txt!=''){
					$('#div-search-rez').load('./loadpointsofinterest.php?q='+encodeURIComponent(txt));
				} else {
					$('#div-search-rez').load('./loadpointsofinterestAll.php?q='+encodeURIComponent(txt));
				}
				selectedElement = -1;
				cntUpDown1 = 1;
				_idx = 0;
			}
			}, 0);
		}
	}

    lang = '<?php echo $cLang?>';
    
    var clientid = '<?php echo session("client_id")?>';
    
    top.changeItem = false;
    var currdt = '<?php echo $currDateTime1?>';
    var clientUnit = '<?php echo $clientUnit?>';
	metric = '<?php echo $clientUnit?>';

    AllowedMaps = '<?php echo $AllowedMaps?>';
	DefMapType = '<?php echo $DefMap?>';
	var cntz = parseInt('<?php echo ($cntz-1)?>');

	var _userId = '<?php echo session("user_id")?>';
	
	$("#gfGroup dd ul li a").click(function() {
        var text = $(this).html();
        $("#gfGroup dt a")[0].title = this.id;
        document.getElementById("groupidTEst").title = this.id;
        $("#gfGroup dt a span").html(text);
        $("#gfGroup dd ul").hide();
        //$("#result").html("Selected value is: " + getSelectedValue("sample"));
    });
    
    $("#poiGroup dt a").click(function() {
        $("#poiGroup dd ul").toggle();
    });
    $("#poiGroup dd ul li a").click(function() {
        var text = $(this).html();
        $("#poiGroup dt a")[0].title = this.id;
        document.getElementById("groupidTEst").title = this.id;
        $("#poiGroup dt a").html(text);
        $("#poiGroup dd ul").hide();
        //$("#result").html("Selected value is: " + getSelectedValue("sample"));
    });
    
    $(".dropdownRadius dt a").click(function() {
        $(".dropdownRadius dd ul").toggle();
    });
    $(".dropdownRadius dd ul li a").click(function() {
        var text = $(this).html();
        $(".dropdownRadius dt a")[0].title = this.id;
        
        $(".dropdownRadius dt a span").html(text);
        $(".dropdownRadius dd ul").hide();
        //$("#result").html("Selected value is: " + getSelectedValue("sample"));
    });

    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (! $clicked.parents().hasClass("dropdown"))
            $(".dropdown dd ul").hide();
	if (! $clicked.parents().hasClass("dropdownRadius"))
            $(".dropdownRadius dd ul").hide();
    });
	
	naslov = '<?php echo $naslov?>';
	alarm = '<?php echo $alarm?>';
	totalkm = '<?php echo $totalkm?>';
	totaltime = '<?php echo $totaltime?>';
	
	vozilo = '<?php echo $vozilo?>';
	
	pause1 = '<?php echo $pause1?>';
	pause2 = '<?php echo $pause2?>';
	pause3 = '<?php echo $pause3?>';
	pause4 = '<?php echo $pause4?>';
	pause5 = '<?php echo $pause5?>';
	
	tostay = '<?php echo $tostay?>';
	
	driverid1 = '<?php echo $driverid1?>';
	driverid2 = '<?php echo $driverid2?>';
	driverid3 = '<?php echo $driverid3?>';
	
	
	FilterByVeh1()

	if(driverid2 != "0")
	{
		AddDriver();
	}
	if(driverid3 != "0")
	{
		AddDriver();
	}

    LoadCurrentPosition = false;
    JustSave = false;
	
	Routing = true;
	
    ShowAreaIcons = true
    OpenForDrawing = false;
    ShowVehiclesMenu = false;
	if(AllowViewPoi == "1")
    	ShowPOIBtn = true;
	else
		ShowPOIBtn = false;
    if(AllowViewZone == "1")
    	ShowGFBtn = true;
	else
		ShowGFBtn = false;
    var RecOn = false;
    var RecOnNew = false;

	/*$("#test3").click(function (event) {
        optimalClick = false;
        var _len = parseInt($('#MarkersIN')[0].children.length, 10);
        if (_len < 2) return false;
        $('#optimizedNarrative').css({ display: 'block' });
        var _ids = "";
        for (var i = 0; i < _len; i++)
            _ids += $('#MarkersIN')[0].children[i].id.substring($('#MarkersIN')[0].children[i].id.indexOf("_") + 1, $('#MarkersIN')[0].children[i].id.lastIndexOf("_")) + ",";
        _ids = _ids.substring(0, _ids.length - 1);
        ShowWait();
        $('#MarkersIN').html('');
        ClearGraphicRoute();
        for (var j = 0; j < tmpMarkersRoute.length; j++)
            Markers[0].removeMarker(tmpMarkersRoute[j]);
        tmpMarkersRoute = [];
        doOptimized('optimizedroute', 'renderOptimized');
        HideWait();
    });*/
   
   CreateBoards();
   LoadMaps();
   //if(clientid == '367')
   SetHeightLite112()
	
   //$("#test3").click(function (event) {	
	$("#opt").click(function (event) {
		//top.ShowWait();
		$("#Label3").removeClass("ui-state-focus");	
        optimalClick = false;
        var _len = parseInt($('#MarkersIN')[0].children.length, 10);
        //!
        if (_len < 2) return false;
        //$('#optimizedNarrative').css({ display: 'block' });
        var _ids = "";
        for (var i = 0; i < _len; i++)
            _ids += $('#MarkersIN')[0].children[i].id.substring($('#MarkersIN')[0].children[i].id.indexOf("_") + 1, $('#MarkersIN')[0].children[i].id.lastIndexOf("_")) + ",";
        _ids = _ids.substring(0, _ids.length - 1);
        //ShowWait();
        $('#MarkersIN').html('');
        ClearGraphicRoute();
        for (var j = 0; j < tmpMarkersRoute.length; j++)
            Markers[0].removeMarker(tmpMarkersRoute[j]);
        tmpMarkersRoute = [];
    
        if ($("#opt").is(':checked') == true) {
        	if ($("#Label1").hasClass("ui-state-active") == true) {
        		//alert("opt; normal");
        		//doAdvanced(21.336197, 41.028362, 21.334236, 41.029748)
        		doOptimized('optimizedroute', 'renderOptimized', 'shortest');
        	} else {
        		//alert("opt; fast");
        		doOptimized('optimizedroute', 'renderOptimized', 'fastest');
        	}
        } else {
    		PointsOfRoute = PointsOfRouteBefore;
    		ReDrawRoute('getLinePoints')
        }
        //doOptimized('optimizedroute', 'renderOptimized');
        //HideWait();
    });
	$("#test4").click(function (event) {
        optimalClick = false;
        var _len = parseInt($('#MarkersIN')[0].children.length, 10);
        if (_len < 2) return false;
        $('#optimizedNarrative').html('');
        $('#optimizedNarrative').css({ display: 'block' });
        var _ids = "";
        for (var i = 0; i < _len; i++)
            _ids += $('#MarkersIN')[0].children[i].id.substring($('#MarkersIN')[0].children[i].id.indexOf("_") + 1, $('#MarkersIN')[0].children[i].id.lastIndexOf("_")) + ",";
        _ids = _ids.substring(0, _ids.length - 1);
        ShowWait();
        $('#MarkersIN').html('');
        ClearGraphicRoute();
        for (var j = 0; j < tmpMarkersRoute.length; j++)
            Markers[0].removeMarker(tmpMarkersRoute[j]);
        tmpMarkersRoute = [];
        doOptimized('route', 'renderRoute');
        HideWait();
    });
    
	$('#btn-save').button({icons: {primary: "ui-icon-check"}});
	$('#btn-clear').button({icons: {primary: "ui-icon-close"}});
	$('#btn-save1').button({icons: {primary: "ui-icon-check"}});
	$('#btn-clear1').button({icons: {primary: "ui-icon-close"}});
	$('#btn-prezemi').button({icons: {primary: "ui-icon-link"}});
	$('#btn-hideTr').button({icons: {primary: "ui-icon-triangle-1-s "}});
	
	if (Browser()!='iPad') {
		$('#alertiImg').mousemove(function (event) { ShowPopup(event, dic("alarm", lang)) });
		$('#alertiImg').mouseout(function (event) { HidePopup(); });
		$('#alertiWaitImg').mousemove(function (event) { ShowPopup(event, dic("Routes.RetainingXminPOI",lang)) });
		$('#alertiWaitImg').mouseout(function (event) { HidePopup(); });
		$('#pauseImg').mousemove(function (event) { ShowPopup(event, dic("Routes.BreaksRoute",lang)) });
		$('#pauseImg').mouseout(function (event) { HidePopup(); });
	}
	
	//else
		//SetHeightLite111()
    //iPadSettingsLite()
    top.HideLoading()
    $('#txtSDate').datepicker({
		dateFormat: '<?=$datejs?>',
		showOn: "button",
		buttonImage: "../images/cal1.png",
		buttonImageOnly: true
	});
	
	var id = '<?php echo $id?>';
    LoadRoutePre(id);

    if (Browser()=='iPad') {top.iPad_Refresh()}


    //stoenje
    $(document).ready(function () {
    	$('#div-search-rez1').load('./loadpointsofinterestAll.php?q='+encodeURIComponent(''));
    	//jQuery('body').bind('touchmove', function(e){e.preventDefault()});
    	if (Browser()!='iPad')
        	$('.ui-autocomplete').css({ width: '610px' });
    	else
    		$('.ui-autocomplete').css({ width: '500px' });
    	
        top.HideWait();
        $("#collapseculture").accordion({
			collapsible: true
		});
		$("#collapsedriver").accordion({
			collapsible: true
		});
		$("#collapsepause").accordion({
			collapsible: true
		});
		$('.ui-accordion .ui-accordion-content').css({height: 'auto'})
		
		top.HideWait();
    });

	function hideTr() {        
		if($('#trH1').css('display') == 'none') {
			$('#trH1').fadeIn("slow", function() {});
			$('#trH2').fadeIn("slow", function() {});
			if($('#trH3')) $('#trH3').fadeIn("slow", function() {});
			$("#btn-hideTr").button({
	            icons: {primary: "ui-icon-triangle-1-s"}
        	});
		} else {
       		$('#trH1').fadeOut("slow", function() {});
			$('#trH2').fadeOut("slow", function() {});
			if($('#trH3')) $('#trH3').fadeOut("slow", function() {});
			$("#btn-hideTr").button({
	            icons: {primary: "ui-icon-triangle-1-e"}
       		});
		}
	}
	
	function updateTotal(total)
	{
		if(total == "/")
			var tot = 0;
		else
			var tot = total;
		var currentMin = 0;
		if($('#IDMarker_Total').css('display') != 'none')
		{
			for(var bb = 0; bb < $('#MarkersIN')[0].children.length; bb++)
	        	if($('#MarkersIN')[0].children[bb].children[3].value != "/")
	        	{
	        		if($('#MarkersIN')[0].children[bb].children[3].value.substring($('#MarkersIN')[0].children[bb].children[3].value.indexOf("(")+2,$('#MarkersIN')[0].children[bb].children[3].value.indexOf(")")-1) != "/")
	        			var currentMin = parseInt($('#MarkersIN')[0].children[bb].children[3].value.substring($('#MarkersIN')[0].children[bb].children[3].value.indexOf("(")+2,$('#MarkersIN')[0].children[bb].children[3].value.lastIndexOf("min")-1),10);
        			else
        				var currentMin = 0;
	        		$('#MarkersIN')[0].children[bb].children[3].value = $('#MarkersIN')[0].children[bb].children[3].value.substring(0, $('#MarkersIN')[0].children[bb].children[3].value.indexOf("(")-1) + ((tot == 0) ? " ( / )" : " ( " + tot + " min )");
	        	}
        	if($('#MarkersIN')[0].children.length == 0)
        		$('#IDMarker_Total')[0].children[1].value = Sec2Str((tot*60) + (parseInt($('#txt_pause1').val(), 10)*60) + (parseInt($('#txt_pause2').val(), 10)*60) + (parseInt($('#txt_pause3').val(), 10)*60) + (parseInt($('#txt_pause4').val(), 10)*60) + (parseInt($('#txt_pause5').val(), 10)*60));
        	else
				$('#IDMarker_Total')[0].children[1].value = Sec2Str(Str2Sec($('#IDMarker_Total')[0].children[1].value)+(tot*60*(parseInt($('#MarkersIN')[0].children.length, 10)-1))-(currentMin*60*(parseInt($('#MarkersIN')[0].children.length, 10)-1)));
		}
	}
	function updatePause(pause, _num){
		if(pause == "0")
			var pau = 0;
		else
			var pau = pause;
		if ($('#PauseOnRoute')[0] != undefined) {
	        var _html = '<div class="text8 corner5" style="cursor: pointer; font-size:12; width:97%; padding:2px 2px 2px 7px; height:26px; background-position: right center; background-repeat: no-repeat; background-origin: content-box;" id="IDMarker_pause'+_num+'">';
	        _html += '<input type="text" class="text9" readonly="readonly" value="'+ dic("pause",lang) + ' '  + _num + '" style="font-size: 11px; cursor: pointer; width: 100px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" />';
	        _html += '<input type="text" class="text9" readonly="readonly" value="/" style="font-size: 11px; cursor: pointer; width: 21%; display: none; padding-left: 56px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" />';
	        _html += '<input type="text" class="text9" readonly="readonly" value="/" style="font-size: 11px; cursor: pointer; width: 30%; text-align: left; padding-left: 10px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" />';
	        _html += '</div>';
	        var current = 0;
	        if(document.getElementById("IDMarker_pause"+_num) == null)
	        	$('#PauseOnRoute').append(_html);
        	else
        		current = Str2Sec($('#IDMarker_pause'+_num)[0].children[2].value + "0 sec");
	       	$('#IDMarker_pause'+_num)[0].children[2].value = Sec2StrPause(pau*60);
	        $('#IDMarker_Total').css({ display: 'block' });
	        if(pau == "0")
	        {
	        	$('#IDMarker_pause'+_num).remove();
	        	$('#IDMarker_Total')[0].children[1].value = Sec2Str(Str2Sec($('#IDMarker_Total')[0].children[1].value)+(pau*60)-(current));
	        } else
				$('#IDMarker_Total')[0].children[1].value = Sec2Str(Str2Sec($('#IDMarker_Total')[0].children[1].value)+(pau*60)-(current));
	        //$('#report-content').css({ height: (parseInt($('#report-content').css('height'), 10) + 30) + 'px' });
	    }
	}
    function FilterByVeh() {
        $.ajax({
            url: 'filterbyveh.php?id=' + txt_vozilo.value,
            success: function (data) {
            	data = data.replace(/\r/g,'').replace(/\n/g,'');
                if (data == "Zero") {
                    txt_sofer1.disabled = true;
                    txt_sofer2.disabled = true;
                    txt_sofer3.disabled = true;
                    $('#txt_sofer2').css({display: 'none'});
                    $('#txt_sofer3').css({display: 'none'});
                    $('#MinusDriver2').css({ display: 'none'});
                    $('#PlusDriver').css({ display: 'inline-block'});
                } else {
                    var dat = data;
                    txt_sofer1.disabled = false;
                    txt_sofer2.disabled = false;
                    txt_sofer3.disabled = false;
                    var _opt = "<option value='0'>" + dic("Routes.SelectUser",lang) + "</option>";
                    for (var i = 0; i < dat.split("%@").length - 1; i++) {
                        _opt += "<option value='" + dat.split("%@")[i].split("|")[0] + "'>" + dat.split("%@")[i].split("|")[1] + " - " + dat.split("%@")[i].split("|")[2] + "</option>";
                    }
                    $('#txt_sofer1').empty();
                    $('#txt_sofer1').html(_opt);
                    $('#txt_sofer2').empty();
                    $('#txt_sofer2').html(_opt);
                    $('#txt_sofer3').empty();
                    $('#txt_sofer3').html(_opt);
                }
            }
        });
    }
    function FilterByVeh1() {
        $.ajax({
            url: 'filterbyveh.php?id=' + txt_vozilo.value,
            success: function (data) {
            	data = data.replace(/\r/g,'').replace(/\n/g,'');
                if (data == "Zero") {
                    txt_sofer1.disabled = true;
                    txt_sofer2.disabled = true;
                    txt_sofer3.disabled = true;
                    $('#txt_sofer2').css({display: 'none'});
                    $('#txt_sofer3').css({display: 'none'});
                    $('#MinusDriver2').css({ display: 'none'});
                    $('#PlusDriver').css({ display: 'inline-block'});
                } else {
                    //var dat = JXG.decompress(data);
                    var dat = data;
                    txt_sofer1.disabled = false;
                    txt_sofer2.disabled = false;
                    txt_sofer3.disabled = false;
                    
                    var did1 = '<?=$driverid1?>';
	                var did2 = '<?=$driverid2?>';
	                var did3 = '<?=$driverid3?>';

                    var _opt = "<option value='0'>" + dic("Routes.SelectUser",lang) + "</option>";
                    for (var i = 0; i < dat.split("%@").length - 1; i++) {
                    	if(dat.split("%@")[i].split("|")[0] == did1)
	                		var _sel = 'selected';
                		else
                			var _sel = '';
                        _opt += "<option "+_sel+" value='" + dat.split("%@")[i].split("|")[0] + "'>" + dat.split("%@")[i].split("|")[1] + " - " + dat.split("%@")[i].split("|")[2] + "</option>";
                    }
                    $('#txt_sofer1').empty();
                    $('#txt_sofer1').html(_opt);
                    var _opt = "<option value='0'>" + dic("Routes.SelectUser",lang) + "</option>";
                    for (var i = 0; i < dat.split("%@").length - 1; i++) {
                    	if(dat.split("%@")[i].split("|")[0] == did2)
	                		var _sel = 'selected';
                		else
                			var _sel = '';
                        _opt += "<option "+_sel+" value='" + dat.split("%@")[i].split("|")[0] + "'>" + dat.split("%@")[i].split("|")[1] + " - " + dat.split("%@")[i].split("|")[2] + "</option>";
                    }
                    $('#txt_sofer2').empty();
                    $('#txt_sofer2').html(_opt);
                    var _opt = "<option value='0'>" + dic("Routes.SelectUser",lang) + "</option>";
                    for (var i = 0; i < dat.split("%@").length - 1; i++) {
                    	if(dat.split("%@")[i].split("|")[0] == did3)
	                		var _sel = 'selected';
                		else
                			var _sel = '';
                        _opt += "<option "+_sel+" value='" + dat.split("%@")[i].split("|")[0] + "'>" + dat.split("%@")[i].split("|")[1] + " - " + dat.split("%@")[i].split("|")[2] + "</option>";
                    }
                    $('#txt_sofer3').empty();
                    $('#txt_sofer3').html(_opt);
                }
            }
        });
    }

	function changeCulture() {
		 /*$('#operation').show();
		 $('#tdoper').show();
		 
		 var culid = $('#culture').children(":selected").val();
		// if ($('#culture').children(":selected").attr("id") != -1) {
			 $.ajax({
	            url: "CalculateOperations.php?cultureid=" + culid,
	            context: document.body,
	            success: function (data) {
	                document.getElementById('operation').innerHTML = data;
	            }
	        });
     	// } else {
       		//$('#operation').hide();
			//$('#tdoper').hide();
       //  }
       
		// document.getElementById('material').innerHTML = "";
		// document.getElementById('mechanisation').innerHTML = "";
		 //$('#material').hide();
		 //$('#tdmat').hide();
		 //$('#mechanisation').hide();
		 //$('#tdmech').hide();*/
	}
	
	function changeOperation() {
		/* $('#material').show();
		 $('#tdmat').show();
		 
		 var culid = $('#culture').children(":selected").val();
		 var operid = $('#operation').children(":selected").val();
	
		//if ($('#operation').children(":selected").attr("id") != -1) {
			 $.ajax({
	            url: "CalculateMaterials.php?cultureid=" + culid + "&operationid=" + operid,
	            context: document.body,
	            success: function (data) {
	                document.getElementById('material').innerHTML = data;
	            }
	        });
      	//}  else {
       		//$('#material').hide();
			//$('#tdmat').hide();
        // }
         
		//document.getElementById('mechanisation').innerHTML = "";
		//$('#mechanisation').hide();
		//$('#tdmech').hide();*/
	}
	
	function changeMaterial() {
		/* $('#mechanisation').show();
		 $('#tdmech').show();
		 
		 var culid = $('#culture').children(":selected").val();
		 var operid = $('#operation').children(":selected").val();
		 var matid = $('#material').children(":selected").val();
	
		 //if ($('#material').children(":selected").attr("id") != -1) {
			 $.ajax({
	            url: "CalculateMechanisation.php?cultureid=" + culid + "&operationid=" + operid + "&materialid=" + matid,
	            context: document.body,
	            success: function (data) {
	                document.getElementById('mechanisation').innerHTML = data;
	            }
	        });
     	// } else {
      		//$('#mechanisation').hide();
			//$('#tdmech').hide();
     	// }*/
	}
	function predefinedChange(_id)
	{
		$("#" + _id).blur();
	}
	
	
</script>
<?php
	closedb();
?>
