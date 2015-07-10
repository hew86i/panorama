// JavaScript Document


//alert(document.location.pathname + "\n\r" + document.location.href);
if(document.location.href.indexOf("lang") == -1 && document.location.href.indexOf("essionexpired") == -1 && document.location.href.indexOf("dmin") == -1 && document.location.href.indexOf("racking") == -1 && document.location.href.indexOf("ettings") == -1 && document.location.href.indexOf("eport") == -1 && document.location.href.indexOf("fm") == -1 && document.location.href.indexOf("oute") == -1)
	var _point = ".";
else
	var _point = "..";

var twopoint = _point;

var veh = '';
var vehnum = '';

var livetracking = false;
var boundsDir;
var PointsOfRouteBefore = [];
var engineon = 'Green';
var engineoff = 'Red';
var engineoffpassengeron = 'RedBlue';
var satelliteoff = 'Yellow';
var taximeteron = 'DarkBlue';
var taximeteroffpassengeron = 'LightBlue';
var passiveon = 'Orange';
var activeoff = 'Gray';
var nocommunication = 'GrayLC';

var allowweather = '1';

var clientid = '';
var LastServerCommunication = null;
var ws = null;
var iszooming = false;
var allowbuttons = true;

var allowgarmin = 0;

var SelectedSpliter = 0;
var LastSelectedSpliter = 0
var ActivedBoard = 0
var LastActivedBoard = 0
var IsDrag = false
var Axe = ''
var xAxes = -10
var yAxes = -10
var lastTop = 50
var lastLeft = 110
var DefMapType = 'GOOGLES'    //  GOOGLE, GOOGLES, OSM, YAHOO, BING
var MapType = []           //  GOOGLE, OSM, Yahoo, Bing

var AllowAddPolygon = '1';
var AllowViewPolygon = '1';

var FollowActive = [];
FollowActive[0] = false;
FollowActive[1] = false;
FollowActive[2] = false;
FollowActive[3] = false;

var CircleVeh = [];
var CircleRadius = [];
var CircleLon = [];
var CircleLat = [];

var ClosePopUp = true;

var FirstLoad = true;

reloadMarker = false;

var _index = 1;
var TimerRec;

var loadAjaxRec;

var traektorija = 180;
var traceForUser = 10;
var snooze = 10;

var RecOn = false;
var RecOnNew = false;
var RecOnNewAll = false;

var metric = 'Km';
var liq = 'litar'
var tempunit = 'C';

var SelectedBoard = 0;

var SpeedRec = 1000;
var PlayForwardRec = true;
var PlayBackRec = false;

var PlayForwardJumpRec = false;
var PlayBacJumpkRec = false;

var TIMEOUTREC;
var clickedDay = 0;
var IndexRec = 1;
var _pts = [];

var resetScreen = []
resetScreen[0] = false;
resetScreen[1] = false;
resetScreen[2] = false;
resetScreen[3] = false;

var FollowAllVehicles = [];
FollowAllVehicles[0] = false;
FollowAllVehicles[1] = false;
FollowAllVehicles[2] = false;
FollowAllVehicles[3] = false;

var lineFeatureRoute = [];
var lineFeatureDirections = [];
var lonlatFeatureDirections = [];

var optimalClick = true;

var PathPerVeh = [];
PathPerVeh[0] = [];
PathPerVeh[1] = [];
PathPerVeh[2] = [];
PathPerVeh[3] = [];
var PathPerVehShadow = [];
PathPerVehShadow[0] = [];
PathPerVehShadow[1] = [];
PathPerVehShadow[2] = [];
PathPerVehShadow[3] = [];

var htmlDriversList = "";

var Border = []
var Boards = []
var Maps = []
var Markers = []
var tmpMarkers = []
var tmpMarkersRec = []
var tmpMarkersRoute = []
var tmpMarkersName = []
var tmpMarkerStreet;
var tmpMarkerDirectionS;
var tmpMarkerDirectionE;

var tmpMarkersTrajectory = []
tmpMarkersTrajectory[0] = [];
tmpMarkersTrajectory[1] = [];
tmpMarkersTrajectory[2] = [];
tmpMarkersTrajectory[3] = [];


var tmpSearchMarker;

var ArrAreasPoly = [];
var ArrAreasId = [];
var ArrAreasCheck = [];

var ArrPolygons = [];
var ArrPolygonsId = [];
var ArrPolygonsCheck = [];

var existdatainlive = true;

var tmpCheckGroup = [];

var timeZone;
var idOfClickVeh = "";

var cancelFeature = []
cancelFeature[0] = false;
cancelFeature[1] = false;
cancelFeature[2] = false;
cancelFeature[3] = false;

var MapsLL = []
var MapsZL = []
var StartLat = 41.996434
var StartLon = 21.432767
var DefMapZoom = 14
var tmp
var tm1
var tm2
var apiKey = "AqTGBsziZHIJYYxgivLBf0hVdrAk9mWO5cQcb8Yux8sW5M8c8opEC2lZqKR1ZZXf";
var Vehicles = []
var Car = []
var CarRec;
var CarStr = ""
var SaveLocal = true
var SaveGlobal = true
var Timers = [];
Timers[0] = [];
Timers[1] = [];
Timers[2] = [];
Timers[3] = [];

var TimersData = [];
TimersData[0] = [];
TimersData[1] = [];
TimersData[2] = [];
TimersData[3] = [];


var AjaxStarted = false
var RecStarted = false
var Routing = false

var InitLoad = false
var InitLoad1 = true

var VehicleList = []
var VehicleListID = []
var AddPOI = false
var AddGarmin = false
var AddStartDirection = false;
var AddEndDirection = false;
var VehClick = false
var AddFirstPosition = false;

var ShowVehiclesMenu = true;
var LoadCurrentPosition = true;
var ShowPOI = false
var OpenForDrawing = false
var controls = [];
var vectors = [];
var VehcileIDs = []

var VehcileIDsWS = '';

var AllowedMaps = "11111"

var LastPointsLon = []
var LastPointsLat = []

LastPointsLon[0] = []
LastPointsLat[0] = []
LastPointsLon[1] = []
LastPointsLat[1] = []
LastPointsLon[2] = []
LastPointsLat[2] = []
LastPointsLon[3] = []
LastPointsLat[3] = []

var ShowHideTrajectory = false
var ShowAreaIcons = false

var ShowHideZone = false;
var lang = 'en'

function kescape(_tekst){
    _tekst = escape(_tekst).replace(/\+/g, '%plus%');
    return _tekst;
}

function CarType(_id, _color, _lon, _lat, _reg){
	this.id = parseInt(_id, 10);
	this.color = _color
	this.lon = _lon
	this.lat = _lat
	this.reg = _reg
	this.map0 = true
	this.map1 = true
	this.map2 = true
	this.map3 = true
	this.passive = '0'
	this.datum = '&nbsp;'
	this.location = '&nbsp;'
	this.address = '&nbsp;'
	this.same = false
	this.speed = '0 Km/h'
	if(metric == "mi")
		this.speed = '0 mph'
	this.taxi = '0'
	this.sedista = '0'
	this.olddate = '0'
	this.gis = '';
	this.alarm = '';
	this.fulldt = '&nbsp;';
	this.cbfuel = '0';
	this.cbrpm = '0';
	this.cbtemp = '0';
	this.cbdistance = '0';
	this.temperature = '0';
	this.litres = '0';
	this.zoneids = '';
	this.odometar = '0';
	this.service = '';
	this.status = '';
	this.zonedt = '';
	this.ignition = '';
	this.noconnection = false;
	this.pumpa = '0'
	this.kapaci = '0'
	this.rpm = '0'
	this.driver = '/'
	this.sopatnik = ''
	this.engineblock = '0'
	this.battery = '/'
	this.inputvoltage = '/'
	this.geolock = '0'
	this.radius = '0'
	this.ultrasonic = '0'
	this.digalka = '0'
	this.datediff = ''
}
function CarType_rec(_id, _color, _lon, _lat, _reg, _num){
    this.id = _id
    this.color = _color
    this.lon = _lon
    this.lat = _lat
    this.reg = _reg
    this.map0 = true;
    this.map1 = true
    this.map2 = true
    this.map3 = true
    this.passive = '0'
    this.datum = '&nbsp;'
    this.location = '&nbsp;'
    this.address = '&nbsp;'
    this.same = false
    this.speed = '0 Km/h'
    if(metric == "mi")
    	this.speed = '0 mph'
    this.taxi = '0'
    this.sedista = '0'
    this.olddate = '0'
    this.gis = ''
    this.status = ''
}
function ParseCarStr_rec() {
    if(CarStr == "")
        return false;
    var c = CarStr.split("#");
    //for (var i=1; i<c.length; i++){
	    var p = c[1].split("|")
	    var _car = new CarType_rec(p[0], p[3], p[1], p[2], p[8], 1);
	    Car[Car.length] = _car
    //}
}
function ParseCarStr() {
    var c = CarStr.split("#");
    for (var i=1; i<c.length; i++){
		var p = c[i].split("|")
		var _car = new CarType(p[0], p[3], p[1], p[2], p[4]);
		Car[Car.length] = _car
	}
}

function VehicleClass(_id, _color, _longitude, _latitude, _reg){
	this.ID=_id
	this.Color = _color
	this.Lon = parseFloat(_longitude)
	this.Lat = parseFloat(_latitude)
	this.Reg = _reg
	this.Direction = null
	this.Marker = null
	this.Map = -1
	this.angle=0
	this.el = null
	this.trajec = 0;
}
function msgboxW(msg) {
    $('#div-msgbox1').html(msg)
    $("#dialog:ui-dialog").dialog("destroy");
    $("#dialog-message1").dialog({
        modal: true,
        zIndex: 9999, resizable: false,
        buttons: {
            Ok: function () {
                $(this).dialog("close");
            }
        }
    });
}
function msgbox(msg) {
    $("#DivInfoForAll").css({ display: 'none' });
    $('#div-msgbox').html(msg)
    $("#dialog:ui-dialog").dialog("destroy");
    $("#dialog-message").dialog({
        modal: true,
        zIndex: 9999, resizable: false,
        buttons: {
            Ok: function () {
                if (document.getElementById("InfoForAll").checked)
                    setCookie(_userId + "_poiinfo", "1", 14);
                else
                    setCookie(_userId + "_poiinfo", "0", 14);
                document.getElementById("InfoForAll").checked = false;
                $(this).dialog("close");
            }
        }
    });
}
function msgboxN(msg, _id){
	$('#div-msgbox').html(msg)
	$( "#dialog:ui-dialog" ).dialog("destroy");
	$("#dialog-message").dialog({
	    modal: true,
	    zIndex: 9999, resizable: false,
	    buttons: {
	        Ok: function () {
	            if (document.getElementById("InfoForAll").checked)
	                setCookie(_userId + _id, "1", 14);
	            else
	                setCookie(_userId + _id, "0", 14);
	            document.getElementById("InfoForAll").checked = false;
	            $("#DivInfoForAll").css({ display: 'none' });
	            $(this).dialog("close");
	        }
	    }
	});
}
function setLiveHeight() {
    var h = document.body.clientHeight;
    var w = document.body.clientWidth;

    $('#live-table').css({ height: (h - 32) + 'px' });
    $('#maps-container').css({ height: (w - 250) + 'px' });
    $('#maps-borders').css({ height: (h - 32) + 'px' });
    $('#div-map').css({ width: (w - 250) + 'px', height: (h - 33) + 'px', overview: 'hidden' });
    $('#div-menu').css({ height: (h - 33) + 'px' });
    //alert(document.body.offsetHeight + "  |  " + document.body.clientHeight + "  |  " + document.body.scrollHeight);
    if (Browser() == "Chrome")
        var _plus = 66;
    else
        var _plus = 33;
    if($('body').width() < 935)
    {
        $('#div-layer-icons-0').css({width: ($('#div-map-1').width() - 50) + 'px'});
        $('#div-layer-icons-1').css({width: ($('#div-map-2').width() - 50) + 'px'});
        $('#div-layer-icons-2').css({width: ($('#div-map-3').width() - 50) + 'px'});
        $('#div-layer-icons-3').css({width: ($('#div-map-4').width() - 50) + 'px'});
    } else {
        $('#div-layer-icons-0').css({width: 'auto'});
        $('#div-layer-icons-1').css({width: 'auto'});
        $('#div-layer-icons-2').css({width: 'auto'});
        $('#div-layer-icons-3').css({width: 'auto'});
    }
    $('#icon-legenda').css({ top: (document.body.offsetHeight - document.body.clientHeight + _plus) * (-1) + 'px' });
    //for (var i=0;i<5;i++){if (Boards[i]!=null) { setSwitcherHeight(Boards[i], i)}}
    SetBorderDimension();
    if ($('#iFrmS')[0].contentWindow != undefined) { 
	    if ($('#iFrmS').css('display') != 'none') {
	    		var bh = document.body.clientHeight - 55 - 50;
			var hStep = bh/5;    
			$('#top1').css({width: (document.body.clientWidth - 310) + 'px'});

			$('#iFrmS')[0].contentWindow.$('#hdScrolltable1').css({height: (top.document.body.clientHeight - 185) + 'px'});
			$('#iFrmS')[0].contentWindow.$('#hdtable1').css({width: (top.document.body.clientWidth - 375) + 'px'});
			$('#iFrmS')[0].contentWindow.$('#table1').css({width: (top.document.body.clientWidth - 375) + 'px'});

		   	$('#top1').css({height: bh +'px'});
			$('#topmiddle1').css({height: bh+'px'});
			$('#iFrmS').css({height: (document.getElementById('topmiddle1').offsetHeight) + 'px'});
			
			//$('#iFrmS')[0].contentWindow.$('#temp1').css({width: (document.body.clientWidth - 363) + 'px'});
			//$('#iFrmS')[0].contentWindow.$('#temp1').css({height: (top.document.body.clientHeight - 185) + 'px'});
	    }  
    } 
}
function setLiveHeightAlarm() {
    var h = document.body.clientHeight;
    var w = document.body.clientWidth;

    $('#live-table').css({ height: h + 'px' });
    $('#maps-container').css({ height: (w - 250) + 'px' });
    $('#maps-borders').css({ height: h + 'px' });
    $('#div-map').css({ width: (w - 250) + 'px', height: (h - 1) + 'px', overview: 'hidden' });
    $('#div-menu').css({ height: (h - 1) + 'px' });
    //alert(document.body.offsetHeight + "  |  " + document.body.clientHeight + "  |  " + document.body.scrollHeight);
    if (Browser() == "Chrome")
        var _plus = 66;
    else
        var _plus = 33;
    $('#icon-legenda').css({ top: (document.body.offsetHeight - document.body.clientHeight + _plus) * (-1) + 'px' });
    //for (var i=0;i<5;i++){if (Boards[i]!=null) { setSwitcherHeight(Boards[i], i)}}
    //SetBorderDimension();
}
function ButtonAddPOIClick(e, num) {
    if (num != undefined) {
        if ($('#add-21-' + num).html().indexOf(dic("Poi", lang)) != -1) {
            AddPOI = true
            for (var i = 0; i < Boards.length; i++) {
                if (Boards[i] != null) {
                    Boards[i].style.cursor = 'crosshair'
                }
            }
            $('#add-21-' + num).html("&nbsp;&nbsp;" + dic("cancel", lang) + "");
            var PPI = getCookie(_userId + "_poiinfo");
            if (PPI != "1") {
                $("#DivInfoForAll").css({ display: 'block' });
                msgboxN(dic("OneClick", lang), "_poiinfo");
            }
            return
        } else {
            AddPOI = false;
            for (var i = 0; i < Boards.length; i++) {
                if (Boards[i] != null) {
                    Boards[i].style.cursor = 'default';
                    //$('#add-2-' + i).html("&nbsp;&nbsp;" + dic("Poi", lang));
                    $('#add-21-' + i).html("&nbsp;&nbsp;" + dic("Poi", lang) + "");
                }
            }
            //$('#div-addPoi-' + num)[0].textContent = "Add POI +";
        }
    } else {
        for (var i = 0; i < 4; i++) {
            if (Boards[i] != null) {
                Boards[i].style.cursor = 'default';
                $('#add-21-' + i).html("&nbsp;&nbsp;" + dic("Poi", lang) + "");
            }
        }
    }
}
function ButtonAddStartDirectionClick(e, num) {
    if (num != undefined) {
        if (!AddStartDirection) {
            AddStartDirection = true;
            $('#clickstartaddress').attr('src', '../images/minus.png');
            ButtonAddEndDirectionClick();
            for (var i = 0; i < Boards.length; i++) {
                if (Boards[i] != null) {
                    Boards[i].style.cursor = 'crosshair'
                }
            }
            var DirectionInfo = getCookie(_userId + "_directioninfo");
            if (DirectionInfo != "1") {
                $("#DivInfoForAll").css({ display: 'block' });
                msgboxN(dic("OneClickDirection", lang), "_directioninfo");
            }
            return
        } else {
            AddStartDirection = false;
            $('#clickstartaddress').attr('src', '../images/plus.png');
            for (var i = 0; i < Boards.length; i++) {
                if (Boards[i] != null) {
                    Boards[i].style.cursor = 'default';
                }
            }
        }
    } else {
        for (var i = 0; i < 4; i++) {
            if (Boards[i] != null) {
                Boards[i].style.cursor = 'default';
            }
        }
        AddStartDirection = false;
        $('#clickstartaddress').attr('src', '../images/plus.png');
    } 
}
function ButtonAddEndDirectionClick(e, num) {
    if (num != undefined) {
        if (!AddEndDirection) {
            AddEndDirection = true;
            ButtonAddStartDirectionClick();
            $('#clickendaddress').attr('src', '../images/minus.png');
            for (var i = 0; i < Boards.length; i++) {
                if (Boards[i] != null) {
                    Boards[i].style.cursor = 'crosshair'
                }
            }
            var DirectionInfo = getCookie(_userId + "_directioninfo");
            if (DirectionInfo != "1") {
                $("#DivInfoForAll").css({ display: 'block' });
                msgboxN(dic("OneClickDirection", lang), "_directioninfo");
            }
            return
        } else {
            AddEndDirection = false;
            $('#clickendaddress').attr('src', '../images/plus.png');
            for (var i = 0; i < Boards.length; i++) {
                if (Boards[i] != null) {
                    Boards[i].style.cursor = 'default';
                }
            }
        }
    } else {
        for (var i = 0; i < 4; i++) {
            if (Boards[i] != null) {
                Boards[i].style.cursor = 'default';
            }
        }
        AddEndDirection = false;
        $('#clickendaddress').attr('src', '../images/plus.png');
    } 
}
function ButtonAddGarminClick(e, num) {
    if (num != undefined) {
        if ($('#add-31-' + num).html().indexOf(dic("garmin", lang)) != -1) {
            AddGarmin = true
            for (var i = 0; i < Boards.length; i++) {
                if (Boards[i] != null) {
                    Boards[i].style.cursor = 'crosshair'
                }
            }
            $('#add-31-' + num).html("&nbsp;&nbsp;" + dic("cancel", lang) + "");
            
            return
        } else {
            AddGarmin = false;
            for (var i = 0; i < Boards.length; i++) {
                if (Boards[i] != null) {
                    Boards[i].style.cursor = 'default';
                    //$('#add-2-' + i).html("&nbsp;&nbsp;" + dic("Poi", lang));
                    $('#add-31-' + i).html("&nbsp;&nbsp;" + dic("garmin", lang));
                }
            }
        }
    } else {
        for (var i = 0; i < 4; i++) {
            if (Boards[i] != null) {
                Boards[i].style.cursor = 'default';
                $('#add-31-' + i).html("&nbsp;&nbsp;" + dic("garmin", lang));
            }
        }
    } 
}

function CheckRow(_t, _max, _num) {
    if (_t == "All") {
    	if(_num == 1 && parseInt($('#trajectoryvalue').val(), 10) > traektorija)
    	{
    		for (var i = 1; i < _max; i++)
                document.getElementById(1 + "_checkRow" + i).checked = false;
            document.getElementById(_num + "_AllGroupCheck").checked = false;
    	} else
    	{
	        if (document.getElementById(_num + "_AllGroupCheck").checked) {
	            for (var i = 1; i < _max; i++)
	                document.getElementById(_num + "_checkRow" + i).checked = false;
	            document.getElementById(_num + "_AllGroupCheck").checked = false;
	        } else {
	            for (var i = 1; i < _max; i++)
	                document.getElementById(_num + "_checkRow" + i).checked = true;
	            document.getElementById(_num + "_AllGroupCheck").checked = true;
	        }
    	}
    }
    else {
    	if(_num == 1 && parseInt($('#trajectoryvalue').val(), 10) > traektorija)
    	{
    		var chr = document.getElementById(_num + "_checkRow" + _t).checked;
    		for (var i = 1; i < _max; i++)
                document.getElementById(1 + "_checkRow" + i).checked = false;
            document.getElementById(_num + "_AllGroupCheck").checked = false;
	        if (chr)
	            document.getElementById(_num + "_checkRow" + _t).checked = false;
	        else
	        	document.getElementById(_num + "_checkRow" + _t).checked = true;
    	} else {
	        document.getElementById(_num + "_AllGroupCheck").checked = false;
	        if (document.getElementById(_num + "_checkRow" + _t).checked)
	            document.getElementById(_num + "_checkRow" + _t).checked = false;
	        else
	        	document.getElementById(_num + "_checkRow" + _t).checked = true;
    	}
    }
}

function ShowPoiGroup(_file, _id1, _id2, _idIcon, _num, _tf, _sh, _left) {
    if (_tf == "1") {
        var displ = "display: block;";
        var vehnum = false;
    }
    else {
        var displ = "display: none;";
        var vehnum = true;
    }
    var tmpEl = document.getElementById(_id1);
    if (tmpEl != null) {
        if ($('#' + _id1).css('display') == 'block') {
            $('#' + _id1).css({ display: 'none' });
            $('#' + _idIcon).css({ backgroundPosition: '0px -144px' });
        } else {
            $('#' + _id1).css({ display: 'block' });
            $('#' + _idIcon).css({ backgroundPosition: '0px -168px' });
            var count = 0;
            for (var j = 1; j < tmpCheckGroup[_num].length; j++)
                if (tmpCheckGroup[_num][j] == 1) {
                    document.getElementById(_num + "_checkRow" + j).checked = true;
                    count++;
                } else {
                    document.getElementById(_num + "_checkRow" + j).checked = false;
                }
            if (count == (tmpCheckGroup[_num].length - 1) && count != 0)
                document.getElementById(_num + "_AllGroupCheck").checked = true;
            else
                document.getElementById(_num + "_AllGroupCheck").checked = false;
        }
        return false;
    }
    ShowWait();
    $.ajax({
        url: _file,
        context: document.body,
        success: function (data) {
            if (_sh)
                var _ch = "checked";
            else
                var _ch = "";
            data = data.replace(/\r/g,'').replace(/\n/g,'');
            tmpCheckGroup[_num] = [];
            var _groups = data.split("#");
            //$('#icon-loading').css({ visibility: 'hidden' });
            HideWait();
            $('#' + _idIcon).css({ backgroundPosition: '0px -168px' });
            var divPopupUp = document.getElementById(_id1)
            if (divPopupUp == null) { divPopupUp = Create(document.body, 'div', _id1) }

            var divPopup = document.getElementById(_id2)
            if (divPopup == null) { divPopup = Create(divPopupUp, 'div', _id2) }
            $(divPopup).show();
            $(divPopupUp).show();
            var _l = _left //document.getElementById(elID).offsetLeft
            var _t = 35 //document.getElementById(elID).offsetTop
            if (_num == 1)
                var _gr = dic("Vehicles", lang);
            else
                var _gr = dic("group", lang);
            divPopupUp.className = 'text8 corner5 shadow';
            $(divPopupUp).css({ position: 'absolute', zIndex: '9998', width: 'auto', height: 'auto', left: _l + 'px', top: _t + 'px', display: 'block', border: '1px solid #1a6ea5', backgroundColor: '#e2ecfa', padding: '4px 4px 4px 4px' })
            divPopupUp.style.minWidth = "200px";

            divPopup.className = 'text8';
            $(divPopup).css({ position: 'static', width: 'auto', height: 'auto', overflowY: 'auto', overflowX: 'hidden', left: (parseInt(_l, 10) + 2) + 'px', top: (parseInt(_t, 10) + 2) + 'px', display: 'block', backgroundColor: '#e2ecfa', padding: '4px 4px 4px 4px' })
            divPopup.style.minWidth = "200px";
            divPopup.style.maxHeight = "300px";
            //divPopup.style.overflowY = "auto";
            var _html = ''
            _html += '<table id="' + _num + '_table" border="0" width="300px" >';
            _html += '<tr class="text7"><td style="border-bottom: 1px Solid #1a6ea5;">&nbsp;</td><td style="text-align: left; border-bottom: 1px Solid #1a6ea5; border-left: 1px Solid #1a6ea5;">&nbsp;&nbsp;' + _gr + '</td><td width="100%" style="text-align: center; border-bottom: 1px Solid #1a6ea5; border-left: 1px Solid #1a6ea5; ' + displ + '">' + dic("symbol", lang) + '</td></tr>';
            _html += '<tr class="text8" style="height: 10px; cursor: pointer;" onclick="CheckRow(\'All\', ' + _groups.length + ',' + _num + ')"><td width="10%"><input id="' + _num + '_AllGroupCheck" onclick="CheckRow(\'All\', ' + _groups.length + ',' + _num + ')" type="checkbox" ' + _ch + ' /></td><td width="80%" style="text-align: left; border-left: 1px Solid #1a6ea5;">&nbsp;&nbsp;&nbsp;' + dic("all", lang) + '</td><td width="10%" style="text-align: center; border-left: 1px Solid #1a6ea5; ' + displ + '"><div style="border: 1px Solid #1a6ea5; margin-left: 10px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 16px; height: 16px; background-color: Transparent"></div></td></tr>';
            for (var i = 1; i < _groups.length; i++) {
                _html += '<tr class="text8" style="height: 10px; cursor: pointer;" onclick="CheckRow(' + i + ', ' + _groups.length + ',' + _num + ')"><td width="10%"><input id="' + _num + '_checkRow' + i + '" alt="' + _groups[i].split("|")[1] + '" onclick="CheckRow(' + i + ', ' + _groups.length + ',' + _num + ')" type="checkbox" ' + _ch + ' /></td><td width="80%" style="text-align: left; border-left: 1px Solid #1a6ea5;">&nbsp;&nbsp;&nbsp;';
                if (vehnum) {
                    _html += "(" + _groups[i].split("|")[2] + ") ";
                }
                //var _bgimg = 'http://80.77.159.246:88/new/pin/?color=' + _groups[i].split("|")[2] + '&type=0';
                //var  _bgimg = '../images/pin-1.png';
                if(_groups[i].split("|")[1] == "1")
                	var grname = dic("Settings.NotGroupedItems", lang);
            	else
            		grname = _groups[i].split("|")[0];
                _html += grname + '</td><td width="10%" style="text-align: center; border-left: 1px Solid #1a6ea5; ' + displ + '"><div style="margin-left: 10px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 18px; height: 18px; background-color: #'+_groups[i].split("|")[2]+';"></div></td></tr>';
                if (_sh)
                    tmpCheckGroup[_num][i] = 1;
            }
            _html += "</table>";
            //_html += '<tr><td style="padding-top: 10px;" colspan="3"><hr style="border: 1px solid #1A6EA5" /><input id="btnCancel1" type="button" value="Cancel" class="corner5 text2" onclick="CancelPOIGroup()" />&nbsp;<input id="btnApplay" type="button" value="OK" class="corner5 text2" onclick="ApplayPOIGroup(' + _groups.length + ')" /><td></tr>';
            divPopup.innerHTML = _html;
            var _html1 = '<br /><hr style="border: 1px solid #1A6EA5" /><div align="right">';
            if (_num == 1)
            {
            	_html1 += '<div id="trajectoryslider" style="height: 10px; width: 240px; position: absolute; margin-top: 2px; left: 14px;"></div><input disabled class="text2_" id="trajectoryvalue" style="width: 40px; height: 20px; position: relative; text-align: center; top: -2px; left: -7px;" />';
            	_html1 += '<br><input id="btnCancel1" type="button" value="' + dic("cancel", lang) + '" class="corner5 text8" onclick="CancelPOIGroupTraj(\'' + _id1 + '\',\'' + _idIcon + '\',\'' + _num + '\',\'' + data.split("#")[1].split("|")[3] + '\')" />&nbsp;<input id="btnApplay" type="button" value="OK" class="corner5 text8" onclick="Applay_' + _num + '(' + _num + ',\'' + _id1 + '\')" />&nbsp;</div>';
        	} else
        		_html1 += '<input id="btnCancel1" type="button" value="' + dic("cancel", lang) + '" class="corner5 text8" onclick="CancelPOIGroup(\'' + _id1 + '\',\'' + _idIcon + '\',\'' + _num + '\')" />&nbsp;<input id="btnApplay" type="button" value="OK" class="corner5 text8" onclick="Applay_' + _num + '(' + _num + ',\'' + _id1 + '\')" />&nbsp;</div>';
            divPopupUp.innerHTML += _html1;
            if(_num == 1)
            {
            	$('#trajectoryvalue').val(data.split("#")[1].split("|")[3]);
	            $('#trajectoryslider').slider({
					value:data.split("#")[1].split("|")[3],
					min: 10,
					max: 1440,
					step: 10,
					animate: true,
					slide: function( event, ui ) {
						// /SpeedRec = 1000 - Math.abs(parseInt(ui.value, 10));
						//debugger;
						if(parseInt(ui.value, 10) > traektorija)
						{
							if($('#1_table').find('input:checked').length > 1)
							{
								for (var i = 1; i < _groups.length; i++)
									document.getElementById(1 + "_checkRow" + i).checked = false;
							}
				            document.getElementById(1 + "_AllGroupCheck").checked = false;
						}
						$('#trajectoryvalue').val(parseInt(ui.value, 10));
						$(ui.handle).blur();
					},
					change: function( event, ui ) { $(ui.handle).blur(); }
					}
				);
				//trajectoryslider
				$('#trajectoryslider').mousemove(function (event) { ShowPopup(event, dic("lenoftraj1", lang) + '<br>' + dic("Reports.Over", lang) + ' ' + traektorija + ' ' + dic("lenoftraj2", lang)) });
    			$('#trajectoryslider').mouseout(function () { HidePopup() });
			}
            if (divPopup.offsetLeft + divPopup.offsetWidth > document.body.clientWidth) { divPopup.style.left = (document.body.clientWidth - divPopup.offsetWidth - 10) + 'px' }
        }
    });
}
function ShowSeparators(e){
	var tmpEl = document.getElementById('div-spliter')
	if (tmpEl!=null){
		$('#div-spliter').remove()
		document.getElementById('a-split').style.backgroundPosition=((-1)*24*SelectedSpliter)+'px 0px'
		return false
	}

	var divPopup = document.getElementById('div-spliter');
	if (divPopup==null) {divPopup =  Create(document.body, 'div', 'div-spliter')}
	$(divPopup).show()
	var _l = 270 //document.getElementById(elID).offsetLeft
	var _t = 40 //document.getElementById(elID).offsetTop

	document.getElementById('a-split').style.backgroundPosition=((-1)*24*SelectedSpliter)+'px -24px'
	
	divPopup.className='text2 corner5 shadow'
	$(divPopup).css({position:'absolute', zIndex:'9000', width:'230px', height:'170px', left:_l+'px', top:_t+'px', display:'block', border:'1px solid #1a6ea5', backgroundColor:'#e2ecfa', padding:'4px 4px 4px 4px'})
	var _html = ''
	_html = _html + '<a id="a-spl-0" href="javascript:" onClick="SelectSeparators(0,0)"></a>'
	_html = _html + '<a id="a-spl-1" href="javascript:" onClick="SelectSeparators(1,0)"></a>'
	_html = _html + '<a id="a-spl-2" href="javascript:" onClick="SelectSeparators(2,0)"></a>'
	_html = _html + '<a id="a-spl-3" href="javascript:" onClick="SelectSeparators(3,0)"></a>'
	_html = _html + '<a id="a-spl-4" href="javascript:" onClick="SelectSeparators(4,0)"></a>'
	_html = _html + '<a id="a-spl-5" href="javascript:" onClick="SelectSeparators(5,0)"></a>'
	_html = _html + '<a id="a-spl-6" href="javascript:" onClick="SelectSeparators(6,0)"></a>'
	_html = _html + '<a id="a-spl-7" href="javascript:" onClick="SelectSeparators(7,0)"></a>'
	_html = _html + '<div id="div-split-mini"></div><br>'
	_html = _html + '<div align="right"><input id="btnCancel1" type="button" value="' + dic("cancel", lang) + '" class="corner5 text2" onclick="CancelSpliter()" />&nbsp;<input id="btnApplay" type="button" value="OK" class="corner5 text2" onclick="ApplaySpliter()" />&nbsp;</div>'
	
	
	divPopup.innerHTML = _html
	$('#div-split-mini').mouseup(function(event) {MyMouseUp(event)});
	$('#div-split-mini').mousemove(function(event) {MyMouseMove(event)});

	document.getElementById('a-spl-' + SelectedSpliter).style.backgroundPosition = ((-1) * 24 * SelectedSpliter) + 'px -24px';

	SelectSeparators(SelectedSpliter, "0");
	if (divPopup.offsetLeft+divPopup.offsetWidth>document.body.clientWidth) {divPopup.style.left=(document.body.clientWidth -divPopup.offsetWidth-10)+'px'}	
}

function AddSPliters(_start){
	if (LastSelectedSpliter != SelectedSpliter) {
	    if (_start == "1") {
	        lastTop = getCookie(_userId + "_lastTop") == "" ? "50" : getCookie(_userId + "_lastTop");
	        lastLeft = getCookie(_userId + "_lastLeft") == "" ? "110" : getCookie(_userId + "_lastLeft");
        } else {
	        lastTop = 50;
	        lastLeft = 110;
	    }
	}
	if (SelectedSpliter==0) {$('#div-split-mini').html('')}
	if (SelectedSpliter==1) {
		var h = '<div id="div-hspl" style="top:'+lastTop+'px"></div>'
		$('#div-split-mini').html(h)
		$('#div-hspl').mousedown(function(event) {MyMouseDown(event, 'h')});
	}
	if (SelectedSpliter==2) {
		var h = '<div id="div-vspl" style="LEFT:'+lastLeft+'px"></div>'
		$('#div-split-mini').html(h)
		$('#div-vspl').mousedown(function(event) {MyMouseDown(event, 'v')});			
	}
	if (SelectedSpliter==3) {
		var h = '<div id="div-hspl" style="top:'+lastTop+'px"></div>'
		h = h +'<div id="div-vspl1" style="left:'+lastLeft+'px"></div>'
		$('#div-split-mini').html(h)
		$('#div-hspl').mousedown(function(event) {MyMouseDown(event, 'h')});	
		$('#div-vspl1').mousedown(function(event) {MyMouseDown(event, 'v')});	
	}	
	if (SelectedSpliter==4) {
		var h = '<div id="div-hspl" style="top:'+lastTop+'px"></div>'
		h = h +'<div id="div-vspl2" style="left:'+lastLeft+'px"></div>'
		$('#div-split-mini').html(h)
		$('#div-hspl').mousedown(function(event) {MyMouseDown(event, 'h')});	
		$('#div-vspl2').mousedown(function(event) {MyMouseDown(event, 'v')});		
	}
	if (SelectedSpliter==5) {
		var h = '<div id="div-hspl1" style="top:'+lastTop+'px"></div>'
		h = h +'<div id="div-vspl" style="left:'+lastLeft+'px"></div>'
		$('#div-split-mini').html(h)
		$('#div-hspl1').mousedown(function(event) {MyMouseDown(event, 'h')});	
		$('#div-vspl').mousedown(function(event) {MyMouseDown(event, 'v')});	
	}
	if (SelectedSpliter==6) {
		var h = '<div id="div-hspl2" style="top:'+lastTop+'px"></div>'
		h = h +'<div id="div-vspl" style="left:'+lastLeft+'px"></div>'
		$('#div-split-mini').html(h)
		$('#div-hspl2').mousedown(function(event) {MyMouseDown(event, 'h')});	
		$('#div-vspl').mousedown(function(event) {MyMouseDown(event, 'v')});			
	}
	if (SelectedSpliter==7) {
		var h = '<div id="div-hspl" style="top:'+lastTop+'px"></div>'
		h = h +'<div id="div-vspl" style="left:'+lastLeft+'px"></div>'
		$('#div-split-mini').html(h)
		$('#div-hspl').mousedown(function(event) {MyMouseDown(event, 'h')});
		$('#div-vspl').mousedown(function(event) {MyMouseDown(event, 'v')});
	}
}

function MyMouseUp(e){
	IsDrag = false
	document.getElementById('div-split-mini').style.cursor='default'
	Axe = ''
}
function MyMouseDown(e, _oska){
	IsDrag = true
	Axe = _oska
	if (_oska=='h') {document.getElementById('div-split-mini').style.cursor='n-resize'}
	if (_oska=='v') {document.getElementById('div-split-mini').style.cursor='w-resize'}
	
}
function MyMouseMove(e) {
    //alert('Mouse DOWN')
    if (IsDrag == true) {
        if ((Axe == 'h') && (SelectedSpliter == '1')) {
            var y = parseInt(document.getElementById('div-hspl').style.top)
            var dY = e.pageY - yAxes
            document.getElementById('div-hspl').style.top = (y + dY) + 'px';
            lastTop = y + dY
            SetMapDimension()
        }
        if ((Axe == 'v') && (SelectedSpliter == '2')) {
            var x = parseInt(document.getElementById('div-vspl').style.left)
            var dX = e.pageX - xAxes
            document.getElementById('div-vspl').style.left = (x + dX) + 'px';
            lastLeft = x + dX;
            SetMapDimension()
        }
        if ((Axe == 'h') && (SelectedSpliter == '3')) {
            var y = parseInt(document.getElementById('div-hspl').style.top)
            var dY = e.pageY - yAxes
            document.getElementById('div-hspl').style.top = (y + dY) + 'px'
            document.getElementById('div-vspl1').style.height = (y + dY) + 'px'
            lastTop = y + dY
            SetMapDimension()
        }
        if ((Axe == 'v') && (SelectedSpliter == '3')) {
            var x = parseInt(document.getElementById('div-vspl1').style.left)
            var dX = e.pageX - xAxes
            document.getElementById('div-vspl1').style.left = (x + dX) + 'px'
            lastLeft = x + dX
            SetMapDimension()
        }
        if ((Axe == 'h') && (SelectedSpliter == '4')) {
            var y = parseInt(document.getElementById('div-hspl').style.top)
            var dY = e.pageY - yAxes
            document.getElementById('div-hspl').style.top = (y + dY) + 'px'
            document.getElementById('div-vspl2').style.height = (100 - y + dY) + 'px'
            document.getElementById('div-vspl2').style.top = (y + dY) + 'px'
            lastTop = y + dY
            SetMapDimension()
        }
        if ((Axe == 'v') && (SelectedSpliter == '4')) {
            var x = parseInt(document.getElementById('div-vspl2').style.left)
            var dX = e.pageX - xAxes
            document.getElementById('div-vspl2').style.left = (x + dX) + 'px'
            lastLeft = x + dX
            SetMapDimension()
        }
        if ((Axe == 'h') && (SelectedSpliter == '5')) {
            var y = parseInt(document.getElementById('div-hspl1').style.top)
            var dY = e.pageY - yAxes
            document.getElementById('div-hspl1').style.top = (y + dY) + 'px'
            lastTop = y + dY
            SetMapDimension()
        }
        if ((Axe == 'v') && (SelectedSpliter == '5')) {
            var x = parseInt(document.getElementById('div-vspl').style.left)
            var dX = e.pageX - xAxes
            document.getElementById('div-vspl').style.left = (x + dX) + 'px'
            document.getElementById('div-hspl1').style.width = (x + dX) + 'px'
            lastLeft = x + dX
            SetMapDimension()
        }
        if ((Axe == 'h') && (SelectedSpliter == '6')) {
            var y = parseInt(document.getElementById('div-hspl2').style.top)
            var dY = e.pageY - yAxes
            document.getElementById('div-hspl2').style.top = (y + dY) + 'px'
            lastTop = y + dY
            SetMapDimension()
        }
        if ((Axe == 'v') && (SelectedSpliter == '6')) {
            var x = parseInt(document.getElementById('div-vspl').style.left)
            var dX = e.pageX - xAxes
            document.getElementById('div-vspl').style.left = (x + dX) + 'px'
            document.getElementById('div-hspl2').style.left = (x + dX) + 'px'
            document.getElementById('div-hspl2').style.width = (220 - x + dX) + 'px'
            lastLeft = x + dX
            SetMapDimension()
        }
        if ((Axe == 'h') && (SelectedSpliter == '7')) {
            var y = parseInt(document.getElementById('div-hspl').style.top)
            var dY = e.pageY - yAxes
            document.getElementById('div-hspl').style.top = (y + dY) + 'px'
            lastTop = y + dY
            SetMapDimension()
        }
        if ((Axe == 'v') && (SelectedSpliter == '7')) {
            var x = parseInt(document.getElementById('div-vspl').style.left)
            var dX = e.pageX - xAxes
            document.getElementById('div-vspl').style.left = (x + dX) + 'px'
            lastLeft = x + dX
            SetMapDimension()
        }
        setCookie(_userId + "_lastTop", lastTop, 14);
        setCookie(_userId + "_lastLeft", lastLeft, 14);
    }
    xAxes = e.pageX
    yAxes = e.pageY
}

function Applay_1(_num, _id) {
    //ClearGraphic();
	
    if(ShowHideTrajectory)
    	OnClickSHTrajectory();
    var _ids = "";
    var i = 1;
    btnCancel1.attributes[1].value = "CancelPOIGroupTraj('div-VehicleUp','icon-draw-path-down','1','" + $('#trajectoryvalue').val() + "')";
    traceForUser = $('#trajectoryvalue').val();
    if(parseInt(traceForUser, 10) > traektorija)
    {
    	while (document.getElementById(_num + "_checkRow" + i) != null || i != -1) {
    		if(document.getElementById(_num + "_checkRow" + i) == null)
    		{
    			break;
    		} else
			{
	        	if (document.getElementById(_num + "_checkRow" + i).checked) {
	        		_ids =  document.getElementById(_num + "_checkRow" + i).alt;
	        		tmpCheckGroup[_num][i] = 1;
	        		i = -1;
	        		break;
	        	} else
	        	{
	        		tmpCheckGroup[_num][i] = 0;
	    		}
	        	i++;
			}
        }
        if (_ids == "") {
        	ClearGraphic();
        	if(_pts.length > 1)
        		goToPointIdxNew(_pts.length - 1);
        	ShowHideTrajectory = false;
        	document.getElementById('icon-draw-path').style.backgroundPosition = '0px -24px';
        } else {
        	ShowHideTrajectory = true;
            document.getElementById('icon-draw-path').style.backgroundPosition = '0px 0px';
        }
        loadrecinlive(_ids, parseInt(traceForUser, 10));
        $('#' + _id).css({ display: 'none' });
    	document.getElementById('icon-draw-path-down').style.backgroundPosition = '0px -144px';
    } else {
	    while (document.getElementById(_num + "_checkRow" + i) != null) {
	        if (document.getElementById(_num + "_checkRow" + i).checked) {
	        	if (PathPerVeh[0][Vehicles[i-1].ID] == undefined || PathPerVeh[0][Vehicles[i-1].ID] == "") {
	        		for (var z = 0; z < 4; z++)
	                    if (Boards[z] != null)
	                    {
	        				PathPerVeh[z][Vehicles[i-1].ID] = [];
	        				PathPerVehShadow[z][Vehicles[i-1].ID] = [];
	        			}
	        		get10Points1(Vehicles[i-1].ID, Vehicles[i-1].Reg, $('#trajectoryvalue').val());
	        	}
	            _ids += document.getElementById(_num + "_checkRow" + i).alt + ", ";
	            tmpCheckGroup[_num][i] = 1;
	        } else {
	            tmpCheckGroup[_num][i] = 0;
	            if (PathPerVeh[0][Vehicles[i-1].ID] != undefined && PathPerVeh[0][Vehicles[i-1].ID] != "") {
	                for (var j = 0; j < PathPerVeh[0][Vehicles[i-1].ID].length; j++)
	                    for (var z = 0; z < 4; z++)
	                        if (Boards[z] != null)
	                        {
	                            vectors[z].removeFeatures(PathPerVeh[z][Vehicles[i-1].ID][j]);
	                            vectors[z].removeFeatures(PathPerVehShadow[z][Vehicles[i-1].ID][j]);
							}
	                for (var z = 0; z < 4; z++)
	                    if (Boards[z] != null)
	                    {
	        				PathPerVeh[z][Vehicles[i-1].ID] = [];
	        				PathPerVehShadow[z][Vehicles[i-1].ID] = [];
	        			}
	            }
	        }
	        i++;
	    }
	    
	    _ids = _ids.substring(0, _ids.length - 2);
	    if (_ids == "") {
	    	ClearGraphic();
	        ShowHideTrajectory = false;
	        for (var z = 0; z < 4; z++)
	            if (Boards[z] != null)
	            {
					PathPerVeh[z] = [];
	        		PathPerVehShadow[z] = [];
				}
	        document.getElementById('icon-draw-path').style.backgroundPosition = '0px -24px';
	    } else {
	    	
	        ShowHideTrajectory = true;
	        document.getElementById('icon-draw-path').style.backgroundPosition = '0px 0px';
	        //LoadPath(_ids);
	    }
	    $('#' + _id).css({ display: 'none' });
	    document.getElementById('icon-draw-path-down').style.backgroundPosition = '0px -144px';
    }
}

function Applay_2(_num, _id) {
    RemoveAllFeature();
    for (var cz = 0; cz <= cntz; cz++)
        if (document.getElementById("zona_" + cz) != null)
            $('#zona_' + cz)[0].checked = false;

    var _ids = "";
    var i = 1;

    while (document.getElementById(_num + "_checkRow" + i) != null) {
        if (document.getElementById(_num + "_checkRow" + i).checked) {
            _ids += document.getElementById(_num + "_checkRow" + i).alt + ", ";
            tmpCheckGroup[_num][i] = 1;
        } else {
            tmpCheckGroup[_num][i] = 0;
        }
        i++;
    }
    _ids = _ids.substring(0, _ids.length - 2);
    if (_ids == "") {
        ShowHideZone = false;
        if (document.getElementById('icon-draw-zone') != null)
            document.getElementById('icon-draw-zone').style.backgroundPosition = '0px -72px';
        else
            if (document.getElementById('div-gfimg') != null)
                document.getElementById('div-gfimg').style.backgroundColor = 'Red';
    } else {
        ShowHideZone = true;
        if (document.getElementById('icon-draw-zone') != null)
            document.getElementById('icon-draw-zone').style.backgroundPosition = '0px -48px';
        else
            if (document.getElementById('div-gfimg') != null)
                document.getElementById('div-gfimg').style.backgroundColor = '#00ff00';
        LoadZone(_ids);
    }
    $('#' + _id).css({ display: 'none' });
    if (document.getElementById('icon-zone-down') != null)
        document.getElementById('icon-zone-down').style.backgroundPosition = '0px -144px';
        else
            $('#div-allgf').html('|&nbsp;&nbsp;&nbsp;▼');
}
function Applay_3(_num, _id) {
    if (tmpMarkers[0] != undefined) {
        for (var j = 0; j < tmpMarkers[0].length; j++) {
            //removeMarker
            try {
                for (var i = 0; i < 5; i++) {
                    if (Boards[i] != null) {
                        Markers[i].removeMarker(tmpMarkers[i][j]);
                    }
                }
            } catch (err) { }
            try {
                for (var i = 0; i < 5; i++) {
                    if (Boards[i] != null) {
                        tmpMarkers[i][j].destroy()
                    }
                }
            } catch (err) { }
        }
    }
    for (var i = 0; i < 5; i++)
        if (Boards[i] != null)
            tmpMarkers[i] = [];
    var _ids = "";
    var i = 1;
    while (document.getElementById(_num + "_checkRow" + i) != null) {
        if (document.getElementById(_num + "_checkRow" + i).checked) {
            _ids += document.getElementById(_num + "_checkRow" + i).alt + ", ";
            tmpCheckGroup[_num][i] = 1;
        } else {
            tmpCheckGroup[_num][i] = 0;
        }
        i++;
    }
    _ids = _ids.substring(0, _ids.length - 2);
    if (_ids == "") {
        ShowPOI = false;
        if (document.getElementById('icon-poi') != null)
            document.getElementById('icon-poi').style.backgroundPosition = '0px -120px';
        else
            if (document.getElementById('div-poiimg') != null)
                document.getElementById('div-poiimg').style.backgroundColor = 'Red';
    } else {
        ShowPOI = true;
        if (document.getElementById('icon-poi') != null)
            document.getElementById('icon-poi').style.backgroundPosition = '0px -96px';
        else
            if (document.getElementById('div-poiimg') != null)
                document.getElementById('div-poiimg').style.backgroundColor = '#00ff00';
        LoadPOI(_ids);
    }
    $('#' + _id).css({ display: 'none' });
    if (document.getElementById('icon-poi') != null)
        document.getElementById('icon-poi-down').style.backgroundPosition = '0px -144px';
    else
        $('#div-allpoi').html('|&nbsp;&nbsp;&nbsp;▼');
}
function CancelPOIGroupTraj(_id, _idIcon, num, _val) {
    checkCheck(num);
    $('#' + _id).css({ display: 'none' });
    if(num == 1)
    {
    	$('#trajectoryvalue').val(_val);
    	$('#trajectoryslider').slider({
			value:_val,
			min: 10,
			max: 1440,
			step: 10,
			animate: true,
			slide: function( event, ui ) {
				$('#trajectoryvalue').val(parseInt(ui.value, 10));
				$(ui.handle).blur();
			},
			change: function( event, ui ) { $(ui.handle).blur(); }
			}
		);
    }
    $('#' + _idIcon).css({ backgroundPosition: '0px -144px' });
}
function CancelPOIGroup(_id, _idIcon, num) {
    checkCheck(num);
    $('#' + _id).css({ display: 'none' });
    if (num == 3)
        $('#div-allpoi').html('|&nbsp;&nbsp;&nbsp;▼');
    else
        if (num == 2)
            $('#div-allgf').html('|&nbsp;&nbsp;&nbsp;▼');
    $('#' + _idIcon).css({ backgroundPosition: '0px -144px' });
}

function ApplaySpliter(){
    ShowWait();
    CreateBoards();
	$('#div-spliter').remove()
	LoadMaps();
	ShowActiveBoard();
	for (var i = 0; i < Boards.length; i++) {
	    if (Boards[i] != null) {
	        zoomWorldScreen(Maps[i], DefMapZoom);
	        //resetScreen[i] = true;
	    }
	}
}

function CancelSpliter(){
	SelectedSpliter = LastSelectedSpliter
	$('#div-spliter').remove()
	document.getElementById('a-split').style.backgroundPosition=((-1)*24*SelectedSpliter)+'px 0px'
}

function SelectSeparators(_sel, _start){
    LastSelectedSpliter = SelectedSpliter;
	SelectedSpliter = _sel;
	setCookie(_userId + "_SelectedSpliter", _sel, 14);
	AddSPliters(_start);
	//$('#div-spliter').remove()
	document.getElementById('a-split').style.backgroundPosition = ((-1) * 24 * SelectedSpliter) + 'px 0px';
}

function ClearAllBoards(){
	for (var i=0;i<5;i++){
		Boards[i] = null
		Markers[i] = null
		if (MapType[i]==null) {MapType[i] = DefMapType}
	}	
	document.getElementById('div-map').innerHTML = ''
}

function CreateBoards() {
    var Parent = document.getElementById('div-map');

	ClearAllBoards();

	$('#div-activeBoard').remove();

	if (SelectedSpliter==0){
	    Boards[0] = Create(Parent, 'div', 'div-map-1');
	    $(Boards[0]).css({ width: '100%', height: (Parent.offsetHeight) + 'px' });
	    Border[0] = Create(Parent, 'div', 'div-border-1');
	    //$(Border[0]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 5) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: (Browser() == "Firefox" ? '32' : '0') + 'px', border: '3px Solid #FF6633' });
	    $(Border[0]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 5) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: '0px', border: '3px Solid #FF6633' });
	}
	if (SelectedSpliter == 1) {
	    var y = parseInt(document.getElementById('div-hspl').style.top);
	    var p1 = parseFloat(y / 100);
	    var p2 = 1 - p1;
	    Boards[0] = Create(Parent, 'div', 'div-map-1');
	    $(Boards[0]).css({ width: (100) + '%', height: (100 * p1) + '%', borderBottom: '1px solid #1a6ea5', overflow: 'hidden' });
	    Border[0] = Create(Parent, 'div', 'div-border-1');
	    //$(Border[0]).css({ position: 'absolute', display: 'block', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 6) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: (Browser() == "Firefox" ? '32' : '0') + 'px', border: '3px Solid #FF6633' });
	    $(Border[0]).css({ position: 'absolute', display: 'block', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 6) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: '0px', border: '3px Solid #FF6633' });
	    Boards[1] = Create(Parent, 'div', 'div-map-2');
	    $(Boards[1]).css({ width: (100) + '%', height: (100 * p2) + '%', borderTop: '1px solid #1a6ea5', overflow: 'hidden' });
	    Border[1] = Create(Parent, 'div', 'div-border-2');
	    //$(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[1])[0].clientWidth - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 7) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: ($(Boards[1])[0].offsetTop + (Browser() == "Firefox" ? 33 : 1)) + 'px', border: '3px Solid #FF6633' });
	    $(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[1])[0].clientWidth - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 7) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: ($(Boards[1])[0].offsetTop + 1) + 'px', border: '3px Solid #FF6633' });
	}
	if (SelectedSpliter==2){
	    var x = parseInt(document.getElementById('div-vspl').style.left);
		var p1 = parseFloat(x / 220);
		var p2 = 1 - p1;
		Boards[0] = Create(Parent, 'div', 'div-map-1');
		$(Boards[0]).css({ width: ((100 * p1)) + '%', height: (100) + '%', borderRight: '2px solid #1a6ea5', overflow: 'hidden' });
		$(Boards[0]).css("float", "left");
		Border[0] = Create(Parent, 'div', 'div-border-1');
		//$(Border[0]).css({ position: 'absolute', display: 'block', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 5) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: (Browser() == "Firefox" ? '32' : '0') + 'px', border: '3px Solid #FF6633' });
		$(Border[0]).css({ position: 'absolute', display: 'block', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 5) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: '0px', border: '3px Solid #FF6633' });

		Boards[1] = Create(Parent, 'div', 'div-map-2');
		$(Boards[1]).css({ width: (99 * p2) + '%', height: (100) + '%', borderLeft: '#1px solid #1a6ea5', overflow: 'hidden' });
		$(Boards[1]).css("float", "left");
		Border[1] = Create(Parent, 'div', 'div-border-2');
		$(Border[1]).css({ left: ($(Boards[1])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3)) + 'px' });
		//$(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[1]).css('left'), 10) - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 5) + 'px', top: (Browser() == "Firefox" ? '32' : '0') + 'px', border: '3px Solid #FF6633' });
		$(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[1]).css('left'), 10) - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 5) + 'px', top: '0px', border: '3px Solid #FF6633' });
		//$(Border[1]).css({ width: (document.body.clientWidth - parseInt($(Border[1]).css('left'), 10) - 6) + 'px' });
	}	
	if (SelectedSpliter==3){
		var x = parseInt(document.getElementById('div-vspl1').style.left)
		var p1 = parseFloat(x/220)
		var p2 = 1-p1
		
		var y = parseInt(document.getElementById('div-hspl').style.top)
		var pp1 = parseFloat(y/100)
		var pp2 = 1-pp1
		
		Boards[0] = Create(Parent, 'div', 'div-map-1')
		$(Boards[0]).css({width:((100*p1))+'%', height:(100*pp1)+'%', borderRight:'1px solid #1a6ea5', overflow:'hidden'})
		$(Boards[0]).css("float", "left");
		Border[0] = Create(Parent, 'div', 'div-border-1');
		//$(Border[0]).css({ position: 'absolute', display: 'block', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 6) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: (Browser() == "Firefox" ? '32' : '0') + 'px', border: '3px Solid #FF6633' });
		$(Border[0]).css({ position: 'absolute', display: 'block', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 6) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: '0px', border: '3px Solid #FF6633' });

		Boards[1] = Create(Parent, 'div', 'div-map-2')
		$(Boards[1]).css({width:(99*p2)+'%', height:(100*pp1)+'%', borderLeft:'1px solid #1a6ea5', overflow:'hidden'})
		$(Boards[1]).css("float", "left");
		Border[1] = Create(Parent, 'div', 'div-border-2');
		$(Border[1]).css({ left: ($(Boards[1])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 251 : 4)) + 'px' });
		//$(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[1]).css('left'), 10) - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 6) + 'px', top: (Browser() == "Firefox" ? '32' : '0') + 'px', border: '3px Solid #FF6633' });
		$(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[1]).css('left'), 10) - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 6) + 'px', top: '0px', border: '3px Solid #FF6633' });

		Boards[2] = Create(Parent, 'div', 'div-map-3')
		$(Boards[2]).css({width:(100)+'%', height:(100*pp2)+'%', borderTop:'2px solid #1a6ea5', overflow:'hidden'})
		$(Boards[2]).css("float", "left");
		Border[2] = Create(Parent, 'div', 'div-border-3');
		//$(Border[2]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[2])[0].clientWidth - 6) + 'px', height: ($(Boards[2])[0].clientHeight - 7) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: ($(Boards[2])[0].offsetTop + (Browser() == "Firefox" ? 34 : 2)) + 'px', border: '3px Solid #FF6633' });
		$(Border[2]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[2])[0].clientWidth - 6) + 'px', height: ($(Boards[2])[0].clientHeight - 7) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: ($(Boards[2])[0].offsetTop + 2) + 'px', border: '3px Solid #FF6633' });
	}	
	if (SelectedSpliter==4){
	    var x = parseInt(document.getElementById('div-vspl2').style.left);
	    var p1 = parseFloat(x / 220);
	    var p2 = 1 - p1;

	    var y = parseInt(document.getElementById('div-hspl').style.top);
	    var pp1 = parseFloat(y / 100);
	    var pp2 = 1 - pp1;
		Boards[0] = Create(Parent, 'div', 'div-map-1')
		$(Boards[0]).css({width:(100)+'%', height:(100*pp1)+'%', borderBottom:'2px solid #1a6ea5', overflow:'hidden'})
		$(Boards[0]).css("float","left")
		Border[0] = Create(Parent, 'div', 'div-border-1');
		//$(Border[0]).css({ position: 'absolute', display: 'block', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 6) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: (Browser() == "Firefox" ? '32' : '0') + 'px', border: '3px Solid #FF6633' });
		$(Border[0]).css({ position: 'absolute', display: 'block', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 6) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: '0px', border: '3px Solid #FF6633' });

		Boards[1] = Create(Parent, 'div', 'div-map-2')
		$(Boards[1]).css({width:((100*p1))+'%', height:(100*pp2)+'%', borderRight:'1px solid #1a6ea5', overflow:'hidden'})
		$(Boards[1]).css("float", "left");
		Border[1] = Create(Parent, 'div', 'div-border-2');
		//$(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[1])[0].clientWidth - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 7) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: ($(Boards[1])[0].offsetTop + (Browser() == "Firefox" ? 32 : 0)) + 'px', border: '3px Solid #FF6633' });
		$(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[1])[0].clientWidth - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 7) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: $(Boards[1])[0].offsetTop + 'px', border: '3px Solid #FF6633' });

		Boards[2] = Create(Parent, 'div', 'div-map-3')
		$(Boards[2]).css({width:(99*p2)+'%', height:(100*pp2)+'%', borderLeft:'1px solid #1a6ea5', overflow:'hidden'})
		$(Boards[2]).css("float", "left");
		Border[2] = Create(Parent, 'div', 'div-border-3');
		$(Border[2]).css({ left: ($(Boards[2])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 251 : 4)) + 'px' });
		//$(Border[2]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px', height: ($(Boards[2])[0].clientHeight - 7) + 'px', top: ($(Boards[2])[0].offsetTop + (Browser() == "Firefox" ? 32 : 0)) + 'px', border: '3px Solid #FF6633' });
		$(Border[2]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px', height: ($(Boards[2])[0].clientHeight - 7) + 'px', top: $(Boards[2])[0].offsetTop + 'px', border: '3px Solid #FF6633' });
	}
	if (SelectedSpliter==5){
		var x = parseInt(document.getElementById('div-vspl').style.left)
		var p1 = parseFloat(x/220)
		var p2 = 1-p1
		tmp = Create(Parent, 'div', 'div-map-tmp')
		$(tmp).css({width:((100*p1))+'%', height:(100)+'%', borderRight:'1px solid #1a6ea5', overflow:'hidden'})
		$(tmp).css("float","left")

		var y = parseInt(document.getElementById('div-hspl1').style.top);
		var pp1 = parseFloat(y / 100);
		var pp2 = 1 - pp1;

		Boards[0] = Create(tmp, 'div', 'div-map-1');
		$(Boards[0]).css({ width: (100) + '%', height: (100 * pp1) + '%', borderBottom: '1px solid #1a6ea5', overflow: 'hidden' });
		Border[0] = Create(Parent, 'div', 'div-border-1');
		//$(Border[0]).css({ position: 'absolute', display: 'block', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 6) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: (Browser() == "Firefox" ? '32' : '0') + 'px', border: '3px Solid #FF6633' });
		$(Border[0]).css({ position: 'absolute', display: 'block', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 6) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: '0px', border: '3px Solid #FF6633' });

		Boards[1] = Create(tmp, 'div', 'div-map-2');
		$(Boards[1]).css({ width: (100) + '%', height: (100 * pp2) + '%', borderTop: '1px solid #1a6ea5', overflow: 'hidden' });
		Border[1] = Create(Parent, 'div', 'div-border-2');
		//$(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[1])[0].clientWidth - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 7) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3) + 'px', top: ($(Boards[1])[0].offsetTop + (Browser() == "Firefox" ? 33 : 1)) + 'px', border: '3px Solid #FF6633' });
		$(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[1])[0].clientWidth - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 7) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3) + 'px', top: ($(Boards[1])[0].offsetTop + 1) + 'px', border: '3px Solid #FF6633' });

		Boards[2] = Create(Parent, 'div', 'div-map-3');
		$(Boards[2]).css({ width: (99 * p2) + '%', height: (100) + '%', borderLeft: '1px solid #1a6ea5', overflow: 'hidden' });
		$(Boards[2]).css("float", "left");
		Border[2] = Create(Parent, 'div', 'div-border-3');
		$(Border[2]).css({ left: ($(Boards[2])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 251 : 4)) + 'px' });
		//$(Border[2]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px', height: ($(Boards[2])[0].clientHeight - 5) + 'px', top: (Browser() == "Firefox" ? '32' : '0') + 'px', border: '3px Solid #FF6633' });
		$(Border[2]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px', height: ($(Boards[2])[0].clientHeight - 5) + 'px', top: '0px', border: '3px Solid #FF6633' });
	}	
	if (SelectedSpliter==6){
		var x = parseInt(document.getElementById('div-vspl').style.left)
		var p1 = parseFloat(x/220)
		var p2 = 1-p1
		
		Boards[0] = Create(Parent, 'div', 'div-map-1')
		$(Boards[0]).css({width:(99*p1)+'%', height:(100)+'%', borderRight:'2px solid #1a6ea5', overflow:'hidden'})
		$(Boards[0]).css("float", "left");
		Border[0] = Create(Parent, 'div', 'div-border-1');
		//$(Border[0]).css({ position: 'absolute', display: 'block', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 5) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: (Browser() == "Firefox" ? '32' : '0') + 'px', border: '3px Solid #FF6633' });
		$(Border[0]).css({ position: 'absolute', display: 'block', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 5) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: '0px', border: '3px Solid #FF6633' });
		
		tmp = Create(Parent, 'div', 'div-map-tmp')
		$(tmp).css({width:((100*p2))+'%', height:(100)+'%', overflow:'hidden'})
		$(tmp).css("float","left")
		
		var y = parseInt(document.getElementById('div-hspl2').style.top)
		var pp1 = parseFloat(y/100)
		var pp2 = 1-pp1
		
		Boards[1] = Create(tmp, 'div', 'div-map-2')
		$(Boards[1]).css({ width: (100) + '%', height: (100 * pp1) + '%', borderBottom: '1px solid #1a6ea5', overflow: 'hidden' });
		Border[1] = Create(Parent, 'div', 'div-border-2');
		$(Border[1]).css({ left: ($(Boards[1])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 2)) + 'px' });
		//$(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[1]).css('left'), 10) - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 6) + 'px', top: (Browser() == "Firefox" ? '32' : '0') + 'px', border: '3px Solid #FF6633' });
		$(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[1]).css('left'), 10) - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 6) + 'px', top: '0px', border: '3px Solid #FF6633' });

		Boards[2] = Create(tmp, 'div', 'div-map-3')
		$(Boards[2]).css({ width: (100) + '%', height: (100 * pp2) + '%', borderTop: '1px solid #1a6ea5', overflow: 'hidden' });
		Border[2] = Create(Parent, 'div', 'div-border-3');
		$(Border[2]).css({ left: ($(Boards[2])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3)) + 'px' });
		//$(Border[2]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px', height: ($(Boards[2])[0].clientHeight - 7) + 'px', top: ($(Boards[2])[0].offsetTop + (Browser() == "Firefox" ? 33 : 1)) + 'px', border: '3px Solid #FF6633' });
		$(Border[2]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px', height: ($(Boards[2])[0].clientHeight - 7) + 'px', top: ($(Boards[2])[0].offsetTop + 1) + 'px', border: '3px Solid #FF6633' });
	}
	if (SelectedSpliter==7){
		var x = parseInt(document.getElementById('div-vspl').style.left)
		var p1 = parseFloat(x/220)
		var p2 = 1-p1
		
		tmp1 = Create(Parent, 'div', 'div-map-tmp1')
		$(tmp1).css({width:(99*p1)+'%', height:(100)+'%', borderRight:'1px solid #1a6ea5', overflow:'hidden'})
		$(tmp1).css("float","left")
		
		tmp2 = Create(Parent, 'div', 'div-map-tmp1')
		$(tmp2).css({width:((100*p2))+'%', height:(100)+'%', borderLeft:'1px solid #1a6ea5', overflow:'hidden'})
		$(tmp2).css("float","left")
		
		
		var y = parseInt(document.getElementById('div-hspl').style.top)
		var pp1 = parseFloat(y/100)
		var pp2 = 1-pp1
		
		Boards[0] = Create(tmp1, 'div', 'div-map-1')
		$(Boards[0]).css({ width: (100) + '%', height: (100 * pp1) + '%', borderBottom: '1px solid #1a6ea5', overflow: 'hidden' });
		Border[0] = Create(Parent, 'div', 'div-border-1');
		//$(Border[0]).css({ position: 'absolute', display: 'block', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 6) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: (Browser() == "Firefox" ? '32' : '0') + 'px', border: '3px Solid #FF6633' });
		$(Border[0]).css({ position: 'absolute', display: 'block', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 6) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: '0px', border: '3px Solid #FF6633' });

		Boards[1] = Create(tmp2, 'div', 'div-map-2')
		$(Boards[1]).css({ width: (100) + '%', height: (100 * pp1) + '%', borderBottom: '1px solid #1a6ea5', overflow: 'hidden' });
		Border[1] = Create(Parent, 'div', 'div-border-2');
		$(Border[1]).css({ left: ($(Boards[1])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3)) + 'px' });
		//$(Border[2]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px', height: ($(Boards[2])[0].clientHeight - 6) + 'px', top: (Browser() == "Firefox" ? '32' : '0') + 'px', border: '3px Solid #FF6633' });
		$(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[1]).css('left'), 10) - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 6) + 'px', top: '0px', border: '3px Solid #FF6633' });

		Boards[2] = Create(tmp1, 'div', 'div-map-3')
		$(Boards[2]).css({ width: (100) + '%', height: (100 * pp2) + '%', borderTop: '1px solid #1a6ea5', overflow: 'hidden' });
		Border[2] = Create(Parent, 'div', 'div-border-3');
		//$(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[1])[0].clientWidth - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 7) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3) + 'px', top: ($(Boards[1])[0].offsetTop + (Browser() == "Firefox" ? 33 : 1)) + 'px', border: '3px Solid #FF6633' });
		$(Border[2]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[2])[0].clientWidth - 6) + 'px', height: ($(Boards[2])[0].clientHeight - 7) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3) + 'px', top: ($(Boards[2])[0].offsetTop + 1) + 'px', border: '3px Solid #FF6633' });
		
        Boards[3] = Create(tmp2, 'div', 'div-map-4');
        $(Boards[3]).css({ width: (100) + '%', height: (100 * pp2) + '%', borderTop: '1px solid #1a6ea5', overflow: 'hidden' });
        Border[3] = Create(Parent, 'div', 'div-border-4');
        $(Border[3]).css({ left: ($(Boards[3])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3)) + 'px' });
        //$(Border[3]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[3]).css('left'), 10) - 6) + 'px', height: ($(Boards[3])[0].clientHeight - 7) + 'px', top: ($(Boards[3])[0].offsetTop + (Browser() == "Firefox" ? 33 : 1)) + 'px', border: '3px Solid #FF6633' });
        $(Border[3]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[3]).css('left'), 10) - 6) + 'px', height: ($(Boards[3])[0].clientHeight - 7) + 'px', top: ($(Boards[3])[0].offsetTop + 1) + 'px', border: '3px Solid #FF6633' });
	}
	for (var i = 0; i < Boards.length; i++) {
	    if (Boards[i] != null) {
	        resetScreen[i] = true;
	    }
	}
}

function SetBorderDimension() {
    if (SelectedSpliter == 0) {
        if (Border[0] != undefined) {
            $(Border[0]).css({ width: (document.body.clientWidth - parseInt($(Border[0]).css('left'), 10) - 6) + 'px' });
            $(Border[0]).css({ height: (document.body.clientHeight - parseInt($(Border[0]).css('top'), 10) - 6) + 'px' });
        }
    }
    if (SelectedSpliter == 1) {
        $(Border[0]).css({ height: ($(Boards[0])[0].offsetHeight - 7) + 'px' });
        $(Border[0]).css({ width: (document.body.clientWidth - parseInt($(Border[0]).css('left'), 10) - 6) + 'px' });
        //$(Border[1]).css({ top: ($(Boards[0])[0].offsetHeight + (Browser() == "Firefox" ? 33 : 1)) + 'px' });
        $(Border[1]).css({ top: ($(Boards[0])[0].offsetHeight + 1) + 'px' });
        $(Border[1]).css({ height: ($(Boards[1])[0].offsetHeight - 7) + 'px' });
        $(Border[1]).css({ width: (document.body.clientWidth - parseInt($(Border[1]).css('left'), 10) - 6) + 'px' });
    }
    if (SelectedSpliter == 2) {
        $(Border[0]).css({ width: ($(Boards[0])[0].offsetWidth - 8) + 'px' });
        $(Border[0]).css({ height: (document.body.clientHeight - parseInt($(Border[0]).css('top'), 10) - 6) + 'px' });
        $(Border[1]).css({ left: ($(Boards[1])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3)) + 'px' });
        $(Border[1]).css({ width: (document.body.clientWidth - parseInt($(Border[1]).css('left'), 10) - 6) + 'px' });
        $(Border[1]).css({ height: (document.body.clientHeight - parseInt($(Border[1]).css('top'), 10) - 6) + 'px' });
    }
    if (SelectedSpliter == 3) {
        $(Border[0]).css({ width: ($(Boards[0])[0].offsetWidth - 7) + 'px' });
        $(Border[0]).css({ height: ($(Boards[0])[0].offsetHeight - 6) + 'px' });
        $(Border[1]).css({ left: ($(Boards[1])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 251 : 4)) + 'px' });
        $(Border[1]).css({ width: (document.body.clientWidth - parseInt($(Border[1]).css('left'), 10) - 6) + 'px' });
        $(Border[1]).css({ height: ($(Boards[1])[0].offsetHeight - 6) + 'px' });
        //$(Border[2]).css({ top: ($(Boards[0])[0].offsetHeight + (Browser() == "Firefox" ? 34 : 2)) + 'px' });
        $(Border[2]).css({ top: ($(Boards[0])[0].offsetHeight + 2) + 'px' });
        $(Border[2]).css({ height: ($(Boards[2])[0].offsetHeight - 9) + 'px' });
        $(Border[2]).css({ width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px' });
    }
    if (SelectedSpliter == 4) {
        $(Border[0]).css({ height: ($(Boards[0])[0].offsetHeight - 8) + 'px' });
        $(Border[0]).css({ width: (document.body.clientWidth - parseInt($(Border[0]).css('left'), 10) - 6) + 'px' });
        $(Border[1]).css({ width: ($(Boards[1])[0].offsetWidth - 7) + 'px' });
        //$(Border[1]).css({ top: ($(Boards[0])[0].offsetHeight + (Browser() == "Firefox" ? 32 : 0)) + 'px' });
        $(Border[1]).css({ top: $(Boards[0])[0].offsetHeight + 'px' });
        $(Border[1]).css({ height: ($(Boards[1])[0].offsetHeight - 7) + 'px' });
        //$(Border[2]).css({ top: ($(Boards[0])[0].offsetHeight + (Browser() == "Firefox" ? 32 : 0)) + 'px' });
        $(Border[2]).css({ top: $(Boards[0])[0].offsetHeight + 'px' });
        $(Border[2]).css({ height: ($(Boards[2])[0].offsetHeight - 7) + 'px' });
        $(Border[2]).css({ left: ($(Boards[2])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 251 : 4)) + 'px' });
        $(Border[2]).css({ width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px' });
    }
    if (SelectedSpliter == 5) {
        $(Border[0]).css({ width: ($(Boards[0])[0].offsetWidth - 6) + 'px' });
        $(Border[0]).css({ height: ($(Boards[0])[0].offsetHeight - 7) + 'px' });
        $(Border[1]).css({ width: ($(Boards[1])[0].offsetWidth - 6) + 'px' });
        //$(Border[1]).css({ top: ($(Boards[0])[0].offsetHeight + (Browser() == "Firefox" ? 33 : 1)) + 'px' });
        $(Border[1]).css({ top: ($(Boards[0])[0].offsetHeight + 1) + 'px' });
        $(Border[1]).css({ height: ($(Boards[1])[0].offsetHeight - 8) + 'px' });
        $(Border[2]).css({ left: ($(Boards[2])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 251 : 4)) + 'px' });
        $(Border[2]).css({ width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px' });
        $(Border[2]).css({ height: (document.body.clientHeight - parseInt($(Border[2]).css('top'), 10) - 6) + 'px' });
    }
    if (SelectedSpliter == 6) {
        $(Border[0]).css({ width: ($(Boards[0])[0].offsetWidth - 8) + 'px' });
        $(Border[0]).css({ height: (document.body.clientHeight - parseInt($(Border[0]).css('top'), 10) - 6) + 'px' });
        $(Border[1]).css({ left: ($(Boards[1])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 2)) + 'px' });
        $(Border[1]).css({ width: (document.body.clientWidth - parseInt($(Border[1]).css('left'), 10) - 6) + 'px' });
        $(Border[1]).css({ height: ($(Boards[1])[0].offsetHeight - 7) + 'px' });
        //$(Border[2]).css({ top: ($(Boards[1])[0].offsetHeight + (Browser() == "Firefox" ? 33 : 1)) + 'px' });
        $(Border[2]).css({ top: ($(Boards[1])[0].offsetHeight + 1) + 'px' });
        $(Border[2]).css({ height: ($(Boards[2])[0].offsetHeight - 8) + 'px' });
        $(Border[2]).css({ left: ($(Boards[2])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3)) + 'px' });
        $(Border[2]).css({ width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px' });
    }
    if (SelectedSpliter == 7) {
        $(Border[0]).css({ width: ($(Boards[0])[0].offsetWidth - 6) + 'px' });
        $(Border[0]).css({ height: ($(Boards[0])[0].offsetHeight - 7) + 'px' });
        $(Border[1]).css({ width: ($(Boards[1])[0].offsetWidth - 6) + 'px' });
        //$(Border[1]).css({ top: ($(Boards[0])[0].offsetHeight + (Browser() == "Firefox" ? 33 : 1)) + 'px' });
        $(Border[1]).css({ top: ($(Boards[0])[0].offsetHeight + 1) + 'px' });
        $(Border[1]).css({ height: ($(Boards[1])[0].offsetHeight - 8) + 'px' });
        $(Border[2]).css({ left: ($(Boards[2])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3)) + 'px' });
        $(Border[2]).css({ width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px' });
        $(Border[2]).css({ height: ($(Boards[2])[0].offsetHeight - 7) + 'px' });
        //$(Border[3]).css({ top: ($(Boards[0])[0].offsetHeight + (Browser() == "Firefox" ? 33 : 1)) + 'px' });
        $(Border[3]).css({ top: ($(Boards[0])[0].offsetHeight + 1) + 'px' });
        $(Border[3]).css({ height: ($(Boards[3])[0].offsetHeight - 8) + 'px' });
        $(Border[3]).css({ left: ($(Boards[3])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3)) + 'px' });
        $(Border[3]).css({ width: (document.body.clientWidth - parseInt($(Border[3]).css('left'), 10) - 6) + 'px' });
    }
}

function SetMapDimension(){
	if (LastSelectedSpliter==SelectedSpliter){
		if (SelectedSpliter==1){
		    var y = parseInt(document.getElementById('div-hspl').style.top);
		    var p1 = parseFloat(y / 100);
		    var p2 = 1 - p1;
		    $(Boards[0]).css({ width: (100) + '%', height: (100 * p1) + '%', borderBottom: '1px solid #1a6ea5' });
		    $(Border[0]).css({ height: ($(Boards[0])[0].offsetHeight - 7) + 'px' });
			$(Boards[1]).css({ width: (100) + '%', height: (100 * p2) + '%', borderTop: '1px solid #1a6ea5' });
			$(Border[1]).css({ top: ($(Boards[0])[0].offsetHeight + 33) + 'px' });
            $(Border[1]).css({ height: ($(Boards[1])[0].offsetHeight - 7) + 'px' });
		}
		if (SelectedSpliter==2){
		    var x = parseInt(document.getElementById('div-vspl').style.left);
		    var p1 = parseFloat(x / 220);
		    var p2 = 1 - p1;
			$(Boards[0]).css({ width: ((100 * p1)) + '%', height: (100) + '%', borderRight: '2px solid #1a6ea5' });
			$(Boards[0]).css("float", "left");
			$(Border[0]).css({ width: ($(Boards[0])[0].offsetWidth - 8) + 'px' });

			$(Boards[1]).css({ width: (99 * p2) + '%', height: (100) + '%', borderLeft: '#1px solid #1a6ea5' });
			$(Boards[1]).css("float", "left");
			$(Border[1]).css({ left: ($(Boards[1])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3)) + 'px' });
			$(Border[1]).css({ width: (document.body.clientWidth - parseInt($(Border[1]).css('left'), 10) - 6) + 'px' });
		}
		if (SelectedSpliter==3){
		    var x = parseInt(document.getElementById('div-vspl1').style.left);
		    var p1 = parseFloat(x / 220);
		    var p2 = 1 - p1;

		    var y = parseInt(document.getElementById('div-hspl').style.top);
		    var pp1 = parseFloat(y / 100);
		    var pp2 = 1 - pp1;

		    $(Boards[0]).css({ width: ((100 * p1)) + '%', height: (100 * pp1) + '%', borderRight: '1px solid #1a6ea5' });
		    $(Boards[0]).css("float", "left");
		    $(Border[0]).css({ width: ($(Boards[0])[0].offsetWidth - 7) + 'px' });
		    $(Border[0]).css({ height: ($(Boards[0])[0].offsetHeight - 6) + 'px' });

		    $(Boards[1]).css({ width: (99 * p2) + '%', height: (100 * pp1) + '%', borderLeft: '1px solid #1a6ea5' });
		    $(Boards[1]).css("float", "left");
		    $(Border[1]).css({ left: ($(Boards[1])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 251 : 4)) + 'px' });
		    $(Border[1]).css({ width: (document.body.clientWidth - parseInt($(Border[1]).css('left'), 10) - 6) + 'px' });
		    $(Border[1]).css({ height: ($(Boards[1])[0].offsetHeight - 6) + 'px' });

		    $(Boards[2]).css({ width: (100) + '%', height: (100 * pp2) + '%', borderTop: '2px solid #1a6ea5' });
		    $(Boards[2]).css("float", "left");
		    $(Border[2]).css({ top: ($(Boards[0])[0].offsetHeight + 34) + 'px' });
		    $(Border[2]).css({ height: ($(Boards[2])[0].offsetHeight - 9) + 'px' });
		}
		if (SelectedSpliter==4){
			var x = parseInt(document.getElementById('div-vspl2').style.left)
			var p1 = parseFloat(x/220)
			var p2 = 1-p1
			
			var y = parseInt(document.getElementById('div-hspl').style.top)
			var pp1 = parseFloat(y/100)
			var pp2 = 1-pp1

			$(Boards[0]).css({ width: (100) + '%', height: (100 * pp1) + '%', borderBottom: '2px solid #1a6ea5' });
			$(Boards[0]).css("float", "left");
			$(Border[0]).css({ height: ($(Boards[0])[0].offsetHeight - 8) + 'px' });

			$(Boards[1]).css({ width: ((100 * p1)) + '%', height: (100 * pp2) + '%', borderRight: '1px solid #1a6ea5' });
			$(Boards[1]).css("float", "left");
			$(Border[1]).css({ width: ($(Boards[1])[0].offsetWidth - 7) + 'px' });
			$(Border[1]).css({ top: ($(Boards[0])[0].offsetHeight + 32) + 'px' });
			$(Border[1]).css({ height: ($(Boards[1])[0].offsetHeight - 7) + 'px' });

			$(Boards[2]).css({ width: (99 * p2) + '%', height: (100 * pp2) + '%', borderLeft: '1px solid #1a6ea5' });
			$(Boards[2]).css("float", "left");
			$(Border[2]).css({ top: ($(Boards[0])[0].offsetHeight + 32) + 'px' });
			$(Border[2]).css({ height: ($(Boards[2])[0].offsetHeight - 7) + 'px' });
			$(Border[2]).css({ left: ($(Boards[2])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 251 : 4)) + 'px' });
			$(Border[2]).css({ width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px' });
		}
		if (SelectedSpliter==5){
		    var x = parseInt(document.getElementById('div-vspl').style.left);
		    var p1 = parseFloat(x / 220);
		    var p2 = 1 - p1;

		    $(tmp).css({ width: ((100 * p1)) + '%', height: (100) + '%', borderRight: '1px solid #1a6ea5' });
		    $(tmp).css("float", "left");

		    var y = parseInt(document.getElementById('div-hspl1').style.top);
		    var pp1 = parseFloat(y / 100);
		    var pp2 = 1 - pp1;

		    $(Boards[0]).css({ width: (100) + '%', height: (100 * pp1) + '%', borderBottom: '1px solid #1a6ea5' });
		    $(Border[0]).css({ width: ($(Boards[0])[0].offsetWidth - 6) + 'px' });
		    $(Border[0]).css({ height: ($(Boards[0])[0].offsetHeight - 7) + 'px' });

		    $(Boards[1]).css({ width: (100) + '%', height: (100 * pp2) + '%', borderTop: '1px solid #1a6ea5' });
		    $(Border[1]).css({ width: ($(Boards[1])[0].offsetWidth - 6) + 'px' });
		    $(Border[1]).css({ top: ($(Boards[0])[0].offsetHeight + 33) + 'px' });
		    $(Border[1]).css({ height: ($(Boards[1])[0].offsetHeight - 8) + 'px' });

		    $(Boards[2]).css({ width: (99 * p2) + '%', height: (100) + '%', borderLeft: '1px solid #1a6ea5' });
		    $(Boards[2]).css("float", "left");
		    $(Border[2]).css({ left: ($(Boards[2])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 251 : 4)) + 'px' });
		    $(Border[2]).css({ width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px' });
		}
		if (SelectedSpliter==6){
		    var x = parseInt(document.getElementById('div-vspl').style.left);
		    var p1 = parseFloat(x / 220);
		    var p2 = 1 - p1;

		    $(Boards[0]).css({ width: (99 * p1) + '%', height: (100) + '%', borderRight: '2px solid #1a6ea5' });
		    $(Boards[0]).css("float", "left");
		    $(Border[0]).css({ width: ($(Boards[0])[0].offsetWidth - 8) + 'px' });

		    $(tmp).css({ width: ((100 * p2)) + '%', height: (100) + '%', backgroundColor: '#ff0000' });
		    $(tmp).css("float", "left");

		    var y = parseInt(document.getElementById('div-hspl2').style.top);
		    var pp1 = parseFloat(y / 100);
		    var pp2 = 1 - pp1;

			$(Boards[1]).css({ width: (100) + '%', height: (100 * pp1) + '%', borderBottom: '1px solid #1a6ea5' });
			$(Border[1]).css({ left: ($(Boards[1])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 2)) + 'px' });
			$(Border[1]).css({ width: (document.body.clientWidth - parseInt($(Border[1]).css('left'), 10) - 6) + 'px' });
			$(Border[1]).css({ height: ($(Boards[1])[0].offsetHeight - 7) + 'px' });

			$(Boards[2]).css({ width: (100) + '%', height: (100 * pp2) + '%', borderTop: '1px solid #1a6ea5' });
			$(Border[2]).css({ top: ($(Boards[1])[0].offsetHeight + 33) + 'px' });
			$(Border[2]).css({ height: ($(Boards[2])[0].offsetHeight - 8) + 'px' });
			$(Border[2]).css({ left: ($(Boards[2])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3)) + 'px' });
			$(Border[2]).css({ width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px' });
		}
		if (SelectedSpliter==7){
			var x = parseInt(document.getElementById('div-vspl').style.left)
			var p1 = parseFloat(x/220)
			var p2 = 1-p1
			
			$(tmp1).css({width:(99*p1)+'%', height:(100)+'%', borderRight:'1px solid #1a6ea5'})
			$(tmp1).css("float","left")
			$(tmp2).css({width:((100*p2))+'%', height:(100)+'%', borderLeft:'1px solid #1a6ea5'})
			$(tmp2).css("float","left")
			
			var y = parseInt(document.getElementById('div-hspl').style.top)
			var pp1 = parseFloat(y/100)
			var pp2 = 1-pp1

			$(Boards[0]).css({ width: (100) + '%', height: (100 * pp1) + '%', borderBottom: '1px solid #1a6ea5' });
			$(Border[0]).css({ width: ($(Boards[0])[0].offsetWidth - 6) + 'px' });
			$(Border[0]).css({ height: ($(Boards[0])[0].offsetHeight - 7) + 'px' });

			$(Boards[1]).css({ width: (100) + '%', height: (100 * pp2) + '%', borderTop: '1px solid #1a6ea5' });
			$(Border[1]).css({ width: ($(Boards[1])[0].offsetWidth - 6) + 'px' });
			$(Border[1]).css({ top: ($(Boards[0])[0].offsetHeight + 33) + 'px' });
			$(Border[1]).css({ height: ($(Boards[1])[0].offsetHeight - 8) + 'px' });

			$(Boards[2]).css({ width: (100) + '%', height: (100 * pp1) + '%', borderBottom: '1px solid #1a6ea5' });
			$(Border[2]).css({ left: ($(Boards[2])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3)) + 'px' });
			$(Border[2]).css({ width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px' });
			$(Border[2]).css({ height: ($(Boards[2])[0].offsetHeight - 7) + 'px' });

			$(Boards[3]).css({ width: (100) + '%', height: (100 * pp2) + '%', borderTop: '1px solid #1a6ea5' });
			$(Border[3]).css({ top: ($(Boards[0])[0].offsetHeight + 33) + 'px' });
			$(Border[3]).css({ height: ($(Boards[3])[0].offsetHeight - 8) + 'px' });
			$(Border[3]).css({ left: ($(Boards[3])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3)) + 'px' });
			$(Border[3]).css({ width: (document.body.clientWidth - parseInt($(Border[3]).css('left'), 10) - 6) + 'px' });
		}
		
		
		
	}
	
}


// ****** MAPS *****************************************************************************************
function eventClick(e) {
    if (AddStartDirection == true) {
        clearDirectionS();
        var lonlat = map.getLonLatFromViewPortPx(e.xy).transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"))
        if (parseInt(lonlat.lon) == 0) { lonlat = map.getLonLatFromViewPortPx(e.xy) }
        AddMarkerDestinationS1(lonlat.lon, lonlat.lat)
        AddStartDirection = false;
        ButtonAddStartDirectionClick();
        VehClick = false;
    }
    if (AddEndDirection == true) {
        clearDirectionE();
        var lonlat = map.getLonLatFromViewPortPx(e.xy).transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"))
        if (parseInt(lonlat.lon) == 0) { lonlat = map.getLonLatFromViewPortPx(e.xy) }
        AddMarkerDestinationE1(lonlat.lon, lonlat.lat)
        AddEndDirection = false;
        ButtonAddEndDirectionClick();
        VehClick = false;
    }
    if (AddGarmin == true) {
        $('#loadingGarmin').css({ display: "none" });
        $('#garminAddress').val('');
        $('#loadinggarminAddress').css({ visibility: "visible" });
        $('#div-Add-Garmin').attr("title", dic("garmin", lang));
        var lonlat = map.getLonLatFromViewPortPx(e.xy).transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"))
        if (parseInt(lonlat.lon) == 0) { lonlat = map.getLonLatFromViewPortPx(e.xy) }
        //$('#div-Add-Garmin').attr("title", '');
        $('#btnAddGarmin').attr("value", dic("add", lang));

        $.ajax({
            url: twopoint + "/main/getGeocode.php?lon=" + lonlat.lon + "&lat=" + lonlat.lat + "&tpoint=" + twopoint,
            context: document.body,
            success: function (data) {
                $('#garminAddress').val(data);
                $('#loadinggarminAddress').css({ visibility: "hidden" });
                //HideWait();
            }
        });
        //document.getElementById("btnDeletePOI").setAttribute("onclick", "DeleteGroup()");
        document.getElementById("btnAddGarmin").setAttribute("onclick", "ButtonAddGarmin()");
        
        $('#btnAddGarmin').button();
        $('#btnCancelGarmin').button()
        $('#garminLat').val(lonlat.lat)
        $('#garminLon').val(lonlat.lon)
        $('#garminName').val('');
        
        $("#div-Add-Garmin").dialog({ modal: true, width: 430, height: 380, zIndex: 9999, resizable: false });
        $('#garminName').focus();
        AddGarmin = false;
        ButtonAddGarminClick();
        VehClick = false;
    }
    if (AddPOI == true) {
    	if (AllowAddPoi == false) { return false }
        $('#poiAddress').val('');
        $('#loadingAddress').css({ visibility: "visible" });
        $('#APcheck1').attr({ checked: 'checked' });
        $('#APcheck2').attr({ checked: '' });
        $('#APcheck3').attr({ checked: '' });
		var lonlat = map.getLonLatFromViewPortPx(e.xy).transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"))
		if (parseInt(lonlat.lon) == 0) { lonlat = map.getLonLatFromViewPortPx(e.xy) }
		$('#div-Add-POI').attr("title", dic("addPoi1", lang));
		$('#btnAddPOI').attr("value", dic("add", lang));
		$('#poiAvail').buttonset();
		$('#AddGroup').button();
		/*var latLng = new google.maps.LatLng(lonlat.lat,lonlat.lon);
		if (geocoder) {
			geocoder.geocode({ 'latLng': latLng}, function (results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					$('#poiAddress').val(results[0].formatted_address);
				}
				else {
					$('#poiAddress').val(status);
				}
			});
		}
        $('#loadingAddress').css({ visibility: "hidden" });*/
		$.ajax({
		    url: twopoint + "/main/getGeocode.php?lon=" + lonlat.lon + "&lat=" + lonlat.lat + "&tpoint=" + twopoint,
		    context: document.body,
		    success: function (data) {
		        $('#poiAddress').val(data);
		        $('#loadingAddress').css({ visibility: "hidden" });
		        //HideWait();
		    }
		});
		document.getElementById("btnDeletePOI").setAttribute("onclick", "DeleteGroup()");
		document.getElementById("btnAddPOI").setAttribute("onclick", "ButtonAddEditPOIokClick()");
		$('#btnDeletePOI').button();
		$('#btnDeletePOI').css({ display: 'none' });
		$('#btnAddPOI').button();
		$('#btnCancelPOI').button()
		$('#poiLat').val(lonlat.lat)
		$('#poiLon').val(lonlat.lon)
		$('#poiName').val('');
		$('#additionalInfo').val('');
		$(".dropdown dt a")[0].title = "";
		$(".dropdown dt a span").html(dic("selGroup", lang));
		$(".dropdownRadius dt a")[0].title = "";
		$(".dropdownRadius dt a span").html(dic("selRadius", lang));
        $("#div-Add-POI").dialog({ modal: true, width: 430, height: 440, zIndex: 9999, resizable: false });
		$('#poiName').focus();
		AddPOI = false;
		if (!VehClick)
		    ButtonAddPOIClick();
		VehClick = false;
	}
	if (AddFirstPosition == true) {
		var lonlat = map.getLonLatFromViewPortPx(e.xy).transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"))
		if (parseInt(lonlat.lon) == 0) { lonlat = map.getLonLatFromViewPortPx(e.xy) }
		//alert(lonlat.lon + "  " + lonlat.lat)
		//AddFirstPosition = false;
		$('#txtLon').val(lonlat.lon)
		$('#txtLat').val(lonlat.lat)
	}
}
function dragFinish(_v) {
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
    var _ll = _v.geometry.getBounds().getCenterLonLat();
    _ll.transform(Maps[0].getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
    if(_v.style.type == 's') {
        AddMarkerDestinationS1(_ll.lon, _ll.lat);
    }else{
        AddMarkerDestinationE1(_ll.lon, _ll.lat);
    }
}
function AddMarkerDestinationS1 (_lon, _lat) {
    $('#direcitonAddress').val('');
    $('#directionLon').val('');
    $('#directionLat').val('');
    $('#loadingDirectionAddress').css({ display: "block" });
    $.ajax({
        url: twopoint + "/main/getGeocode.php?lon=" + _lon + "&lat=" + _lat + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
            $('#direcitonAddress').val(data);
            $('#loadingDirectionAddress').css({ display: "none" });
            if (tmpMarkerDirectionS == undefined)
                AddMarkerDirectionS(_lon, _lat, 0, data.replace(/\r/g,'').replace(/\n/g,''));
        }
    });
    $('#directionLat').val(_lat)
    $('#directionLon').val(_lon)
    /*debugger;
    var input = '41.99425, 21.42234';
    var latlngStr = input.split(',', 2);*/
    var lat = parseFloat(_lat).toFixed(6);
    var lng = parseFloat(_lon).toFixed(6);

    var latlng = new google.maps.LatLng(lat, lng);

    geocoder.geocode({'latLng': latlng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                $('#fromDirection').val(results[0].formatted_address)
            }
        } else {
            $('#fromDirection').val("Geocoder failed due to: " + status);
        }
    });

}
function AddMarkerDirectionS(lon, lat, num, _name) {
    if (tmpMarkerDirectionS != undefined) {
        vectors[0].removeFeatures(tmpMarkerDirectionS);
    }
    var point = new OpenLayers.Geometry.Point(lon, lat);
    point.transform(
        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
        Maps[0].getProjectionObject() // to Spherical Mercator Projection
    );
    tmpMarkerDirectionS = new OpenLayers.Feature.Vector(point, null, {
        externalGraphic: "../images/pinStart.png",
        graphicWidth: 23,
        graphicHeight: 40,
        fillOpacity: 1,
        cursor: 'move',
        type: 's'
    });
    vectors[0].addFeatures([tmpMarkerDirectionS]);
    
    toggleControl('drag', true, 0);
}
function AddMarkerDestinationE1 (_lon, _lat) {
    $('#direcitonAddressEnd').val('');
    $('#directionLonEnd').val('');
    $('#directionLatEnd').val('');
    $('#loadingDirectionAddressEnd').css({ display: "block" });
    $.ajax({
        url: twopoint + "/main/getGeocode.php?lon=" + _lon + "&lat=" + _lat + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
            $('#direcitonAddressEnd').val(data);
            $('#loadingDirectionAddressEnd').css({ display: "none" });
            if (tmpMarkerDirectionE == undefined)
                AddMarkerDirectionE(_lon, _lat, 0, data.replace(/\r/g,'').replace(/\n/g,''));
        }
    });
    $('#directionLatEnd').val(_lat)
    $('#directionLonEnd').val(_lon)
    var latlng = new google.maps.LatLng(_lat, _lon);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                $('#toDirection').val(results[0].formatted_address)
            }
        } else {
            $('#toDirection').val("Geocoder failed due to: " + status);
        }
    });
}
function AddMarkerDirectionE(lon, lat, num, _name) {
    if (tmpMarkerDirectionE != undefined) {
        vectors[0].removeFeatures(tmpMarkerDirectionE);
    }
    var point = new OpenLayers.Geometry.Point(lon, lat);
    point.transform(
        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
        Maps[0].getProjectionObject() // to Spherical Mercator Projection
    );
    tmpMarkerDirectionE = new OpenLayers.Feature.Vector(point, null, {
        externalGraphic: "../images/pinEnd.png",
        graphicWidth: 23,
        graphicHeight: 40,
        fillOpacity: 1,
        cursor: 'move',
        type: 'e'
    });
    vectors[0].addFeatures([tmpMarkerDirectionE]);
    toggleControl('drag', true, 0);
}
function validateDirectionForm(_from) {
    var _ret = true;
    if($("#vozilcaDirection").find('option:selected').val() == '-1' || _from == '1') {
        if($('#directionLon').val() != '' && $('#directionLat').val() != '' && $('#directionLatEnd').val() != '' && $('#directionLonEnd').val() != '' && $('#direcitonAddressEnd').val() != '' && $('#direcitonAddress').val() != '' && $('#toDirection').val() != '' && $('#fromDirection').val() != '') {
            _ret = true;
        } else {
            if($('#fromDirection').val() == '' && $('#toDirection').val() == '') {
                $('#fromDirection').attr('required', 'required');
                $('#toDirection').attr('required', 'required');
                _ret = false;
            } else {
                _ret = false;
                if($('#fromDirection').val() == '')
                    $('#fromDirection').attr('required', 'required');
                if($('#toDirection').val() == '')
                    $('#toDirection').attr('required', 'required');
                    
                if($('#directionLon').val() == "" && $('#directionLatEnd').val() == "" && $('#fromDirection').val() != '' && $('#toDirection').val() != '')
                    msgboxW(dic('invaliddestination', lang));
                else
                    if($('#directionLon').val() == "" && $('#fromDirection').val() != '')
                        msgboxW(dic('invalidstartposition', lang));
                    else
                        if($('#directionLatEnd').val() == "" && $('#toDirection').val() != '')
                            msgboxW(dic('invalidendposition', lang));
            }
        }
    } else {
        if($('#directionLatEnd').val() != '' && $('#directionLonEnd').val() != '' && $('#direcitonAddressEnd').val() != '' && $('#toDirection').val() !== '') {
            _ret = true;
        } else {
            _ret = false;
            if($('#toDirection').val() == '')
                    $('#toDirection').attr('required', 'required');
            else
                if($('#directionLatEnd').val() == "")
                    msgboxW(dic('invalidendposition', lang));
        }
    }
    return _ret;
}
function GetDirections(_from){
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
    if(validateDirectionForm(_from)) {
        if($("#vozilcaDirection").find('option:selected').val() == '-1' || _from == '1' || $("#vozilcaDirection")[0] == undefined) {
            if($('#directionLon').val() != '' && $('#directionLat').val() != '' && $('#directionLatEnd').val() != '' && $('#directionLonEnd').val() != '' && $('#direcitonAddressEnd').val() != '' && $('#direcitonAddress').val() != '') {
                ShowWait();
                boundsDir = new OpenLayers.Bounds();
                var _name = '<strong>Кратка ' + dic("Route", lang).toLowerCase() + '</strong><br>Од: ' + $('#direcitonAddress').val() + '<br>До: ' + $('#direcitonAddressEnd').val();
                DrawLine_Directions($('#directionLon').val(), $('#directionLat').val(), $('#directionLonEnd').val(), $('#directionLatEnd').val(), _name, 'getLinePoints', 0, '#0000FF');
                var _name = '<strong>Брза ' + dic("Route", lang).toLowerCase() + '</strong><br>Од: ' + $('#direcitonAddress').val() + '<br>До: ' + $('#direcitonAddressEnd').val();
                DrawLine_Directions($('#directionLon').val(), $('#directionLat').val(), $('#directionLonEnd').val(), $('#directionLatEnd').val(), _name, 'getLinePointsF', 1, '#FF0000');
            }
        } else {
            if($('#directionLatEnd').val() != '' && $('#directionLonEnd').val() != '' && $('#direcitonAddressEnd').val() != '') {
                ShowWait();
                boundsDir = new OpenLayers.Bounds();
                for(var i=0; i<Car.length; i++) {
                    if(Car[i].id == $("#vozilcaDirection").find('option:selected').val()){
                        var _name = '<strong>' + dic("ShortRoute", lang) + '</strong><br>' + dic("From", lang) + ': ' + Car[i].gis + '<br>' + dic("To", lang) + ': ' + $('#direcitonAddressEnd').val();
                        DrawLine_Directions(Car[i].lon, Car[i].lat, $('#directionLonEnd').val(), $('#directionLatEnd').val(), _name, 'getLinePoints', 0, '#0000FF');
                        var _name = '<strong>' + dic("FastRoute", lang) + '</strong><br>' + dic("From", lang) + ': ' + Car[i].gis + '<br>' + dic("To", lang) + ': ' + $('#direcitonAddressEnd').val();
                        DrawLine_Directions(Car[i].lon, Car[i].lat, $('#directionLonEnd').val(), $('#directionLatEnd').val(), _name, 'getLinePointsF', 1, '#FF0000');
                        break;
                    }
                }
            }
        }
    }
}
function SaveDirections(_from) {
    if(validateDirectionForm(_from)) {
        if($('#ResultDirectionsF').css('display') == 'block' && $('#ResultDirectionsF').html() != '' && $('#ResultDirections').css('display') == 'block' && $('#ResultDirections').html() != '') {
            ShowWait();
            var _url = '../main/SaveDirection.php?directionname=' + kescape('') + '&startgoogleaddress=' + kescape($('#fromDirection').val());
            _url += '&startgeocodeaddress=' + kescape($('#direcitonAddress').val()) + '&startlongitude=' + $('#directionLon').val();
            _url += '&startlatitude=' + $('#directionLat').val() + '&endgoogleaddress=' + kescape($('#toDirection').val());
            _url += '&endgeocodeaddress=' + kescape($('#direcitonAddressEnd').val()) + '&endlongitude=' + $('#directionLonEnd').val();
            _url += '&endlatitude=' + $('#directionLatEnd').val() + '&shortlineid=' + lonlatFeatureDirections[0];
            _url += '&fastlineid=' + lonlatFeatureDirections[1];
            $.ajax({
                url: _url,
                context: document.body,
                success: function (data) {
                    HideWait();
                    msgbox(dic('directionsaved', lang) + '!!!');
                }
            });
        } else {
            msgboxW(dic('incorrectcalculation', lang));
        }
    }
}
function DrawLine_Directions(_lon2, _lat2, _lon1, _lat1, _name, _file, _ordNum, _color) {
    $.ajax({
        url: '../routes/' + _file + ".php?lon1=" + _lon2 + "&lat1=" + _lat2 + "&lon2=" + _lon1 + "&lat2=" + _lat1,
        context: document.body,
        success: function (data) {
            data = data.replace(/\r/g,'').replace(/\n/g,'');
            //var datTemp = data.substring(data.indexOf("route_geometry") + 18, data.indexOf("route_instructions") - 4).split("],[");
            var datTemp = data.split("^$")[0].split("%@");
            var _min = Sec2StrDir(data.split("^$")[2]);
            var mmetric = ' km';
            var kilom = data.split("^$")[1];
            if(metric == 'mi')
            {
                mmetric = ' miles';
                kilom = data.split("^$")[1] * 0.621371;
            }
            var _km = Math.round(kilom * 100)/ 100 + mmetric;
            if(_ordNum == 0) {
                $('#ResultDirectionsTable').css({ display: 'block' });
                $('#ResultDirections').css({ display: 'block' });
                $('#ResultDirections').html(dic('Time', lang) + ': ' + _min + '<br>' + dic('Routes.Distance', lang) + ': ' + _km);
            } else {
                $('#ResultDirectionsF').css({ display: 'block' });
                $('#ResultDirectionsF').html(dic('Time', lang) + ': ' + _min + '<br>' + dic('Routes.Distance', lang) + ': ' + _km);
            }
            var _lon = new Array();
            var _lat = new Array();
            _lon[0] = _lon2;
            _lat[0] = _lat2;
            var ii = 1;
            for (var i = 1; i < datTemp.length; i++) {
                _lon[ii] = datTemp[i].split("#")[0];
                _lat[ii] = datTemp[i].split("#")[1];
                ii++;
            }
            _lon[ii] = _lon1;
            _lat[ii] = _lat1;

            var points = new Array();
            var styles = new Array();

            var debelina = 3;
            var opac = 0.7;
            
            for (var _j = 0; _j < _lon.length; _j++) {
                point = new OpenLayers.Geometry.Point(_lon[_j], _lat[_j]);
                point.transform(
                        new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
                        Maps[0].getProjectionObject() // to Spherical Mercator Projection
                    );
                styles.push({ 'strokeWidth': debelina, 'strokeColor': _color, 'strokeOpacity': opac, 'VehID': _name });
                points.push(point);
                boundsDir.extend(point);
            }
            lonlatFeatureDirections[_ordNum] = data.split("^$")[3];
            lineFeatureDirections[_ordNum] = [];
            for (var i = 0; i < (points.length - 1); i++) {
                var lineString1 = new OpenLayers.Geometry.LineString([points[i], points[i + 1]]);
                lineFeatureDirections[_ordNum][i] = new OpenLayers.Feature.Vector(lineString1, null, styles[i]);
                vectors[0].addFeatures([lineFeatureDirections[_ordNum][i]]);
                lineFeatureDirections[_ordNum][i].layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, event.target._style.VehID)}");
                lineFeatureDirections[_ordNum][i].layer.events.element.setAttribute("onmouseout", "HidePopup()");
            }
            if(_ordNum == 1) {
                setTimeout("HideWait();", 500);
                Maps[0].zoomToExtent(boundsDir);
            }
        }
    });
}
function hideCant(_bool, _Cant) {
    if (_bool == "1")
        $('#' + _Cant).css({ visibility: 'hidden' });
    else
        $('#' + _Cant).css({ visibility: 'visible' });
}
function EditPOI(lon, lat, name, avail, ppgid, id, desc, num, addinfo, radiusID) {
    $('#poiAddress').val('');
    $('#loadingAddress').css({ visibility: "visible" });
    $('#div-Add-POI').attr("title", dic("EditPoi", lang));
    $('#btnAddPOI').attr("value", dic("Update", lang));
    $('#numPoi').val(num);
    if (desc == "") {
        /*var latLng = new google.maps.LatLng(lat,lon);

		if (geocoder) {
			geocoder.geocode({ 'latLng': latLng}, function (results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					$('#poiAddress').val(results[0].formatted_address);
				}
				else {
					$('#poiAddress').val(status);
				}
			});
		}
        $('#loadingAddress').css({ visibility: "hidden" });*/
        $.ajax({
            url: twopoint + "/main/getGeocode.php?lon=" + lon + "&lat=" + lat + "&tpoint=" + twopoint,
            context: document.body,
            success: function (data) {
                $('#poiAddress').val(data);
                //HideWait();
                $('#loadingAddress').css({ visibility: "hidden" });
            }
        });
    
    } else {
        $('#poiAddress').val(desc);
        //HideWait();
        $('#loadingAddress').css({ visibility: "hidden" });
    }
    for (var i = 0; i < $("#poiRadius dd ul li").length; i++) {
        if ($("#poiRadius dd ul li a")[i].id == "RadiusID_" + radiusID) {
            var text = $($("#poiRadius dd ul li a")[i]).html();
            $("#poiRadius dt a")[0].title = "RadiusID_" + radiusID;
            //document.getElementById("groupidTEst").title = ppgid;
            $("#poiRadius dt a span").html(text);
            break;
        }
    }
    for (var i = 0; i < $("#poiGroup dd ul li").length; i++) {
        if ($("#poiGroup dd ul li a")[i].id == ppgid) {
            var text = $($("#poiGroup dd ul li a")[i]).html();
            $("#poiGroup dt a")[0].title = ppgid;
            document.getElementById("groupidTEst").title = ppgid;
            $("#poiGroup dt a span").html(text);
            break;
        }
    }
    $('#APcheck' + avail).attr({ checked: 'checked' });
    $('#AddGroup').button();
    $('#poiAvail').buttonset();
    //$('#poiCant').buttonset();
    /*if (canch == "False" || canch == "0") {
        document.getElementById("btnDeletePOI").setAttribute("onclick", "CantDeletePOI()");
        document.getElementById("btnAddPOI").setAttribute("onclick", "CantDeletePOI()");
    } else {
        document.getElementById("btnDeletePOI").setAttribute("onclick", "DeleteGroup()");
        document.getElementById("btnAddPOI").setAttribute("onclick", "ButtonAddEditPOIokClick()");
    }*/
    $('#btnDeletePOI').css({ display: 'block' });
    $('#btnDeletePOI').button();
    $('#btnAddPOI').button();
    $('#btnCancelPOI').button();
    $('#poiLat').val(lat);
    $('#poiLon').val(lon);
    $('#idPoi').val(id);
    $('#additionalInfo').val(addinfo);
    $('#poiName').val(name);
    $("#div-Add-POI").dialog({ modal: true, width: 430, height: 440, zIndex: 9999, resizable: false });
}
function CantDeletePOI() {
    msgbox(dic("CantModifyPOI", lang));
}
function CantDeleteGF() {
    msgbox(dic("CantModifyGF", lang));
}
function changecolor() {
    $("#colorPicker1").css("background-color", $("#clickAny").val());
}
function changecolorSettings() {
    $("#colorPicker4").css("background-color", $("#clickAny").val());
}
function clearItem() {
    $("#clickAny").val("");
}
function ChangeIconsColor(_color) {
    for (var p = 0; p < 22; p++)
        document.getElementById("GroupIconImg" + p).src = 'http://80.77.159.246:88/new/pin/?color=' + _color + '&type=' + p;
    setTimeout('$("#tblIconsPOI").css({ visibility: "visible" }); $("#loadingIconsPOI").css({ visibility: "hidden" });', 1500);
}
function AddGroup(_tbl) {
    $('#GroupName').val('');
    $("#colorPicker1").css("background-color", "transparent");
    $("#GroupIcon0").attr({ checked: 'checked' });
    $("#clickAny").val('');
    for (var p = 0; p < 22; p++)
        document.getElementById("GroupIconImg" + p).src = 'http://80.77.159.246:88/new/pin/?color=ffffff&type=' + p;
    $('#btnAddGroup').button();
    $('#btnCancelGroup').button();
    $("#colorPicker1").mlColorPicker({ 'onChange': function (val) {
        $("#colorPicker1").css("background-color", "#" + val);
        $("#clickAny").val("#" + val);
        if (_tbl == 1) {
            $("#tblIconsPOI").css({ visibility: "hidden" });
            $("#loadingIconsPOI").css({ visibility: "visible" });
            ChangeIconsColor(val);
        }
    }
    });
    $("#div-Add-Group").dialog({ modal: true, width: 400, zIndex: 10000, resizable: false });
    if (_tbl == 1) {
        $('#tblIconsPOI').css('display', 'block');
        $('#spanIconsPOI').css('display', 'block');
        $('#div-Add-Group').css('height', 'auto');
    }
    else {
        $('#tblIconsPOI').css('display', 'none');
        $('#spanIconsPOI').css('display', 'none');
        $('#div-Add-Group').css('height', '190px');
    }
    $('#GroupName').focus();
}
function ButtonAddGroupOkClick() {
    if (($('#GroupName').val() != '') && ($('#clickAny').val() != '')) {
        $('#loading1').css({ display: "block" });
        for (var i = 0; i < 22; i++)
            if ($('#GroupIcon' + i)[0].checked) {
                var _img = i;
                break;
            }
        //alert("AddGroupNew.php?groupName=" + String($('#GroupName').val()) + "&fcolor=" + String($("#clickAny").val().substring(1, $("#clickAny").val().length)) + "&img=" + _img + "&l=" + lang);
        $.ajax({
            url: twopoint + "/main/AddGroupNew.php?groupName=" + String($('#GroupName').val()) + "&fcolor=" + String($("#clickAny").val().substring(1, $("#clickAny").val().length)) + "&img=" + _img + "&l=" + lang + "&tpoint=" + twopoint,
            context: document.body,
            success: function (data) {
                if (data.indexOf("Error") == -1) {
                    $('#div-Add-Group').dialog('destroy');
                    $('#loading1').css({ display: "none" });
                    
                    var _bgimg = 'http://80.77.159.246:88/new/pin/?color=' + $("#clickAny").val().substring(1, $("#clickAny").val().length) + '&type=' + _img;
                    $("#poiGroup dd ul").append('<li><a id="' + data.split("@@%%")[1] + '" href="#">&nbsp;&nbsp;' + $('#GroupName').val() + '<div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 24px; height: 24px; background: url(' + _bgimg + ') no-repeat; position: relative; float: left;"></div></a></li>');
                    $("#gfGroup dd ul").append('<li><a id="' + data.split("@@%%")[1] + '" href="#">&nbsp;&nbsp;' + $('#GroupName').val() + '<div class="flag" style="margin-top: -1px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 18px; height: 18px; background-color: #' + $("#clickAny").val().substring(1, $("#clickAny").val().length) + '; position: relative; float: left;"></div></a></li>');

                    $("#poiGroup dd ul li a").click(function () {
                        var text = $(this).html();
                        $("#poiGroup dt a")[0].title = this.id;
                        $("#poiGroup dt a span").html(text);
                        $("#poiGroup dd ul").hide();
                    });
                    $("#gfGroup dd ul li a").click(function () {
                        var text = $(this).html();
                        $("#gfGroup dt a")[0].title = this.id;
                        $("#gfGroup dt a span").html(text);
                        $("#gfGroup dd ul").hide();
                    });


                    $("#poiGroup dt a")[0].title = data.split("@@%%")[1];
                    $("#gfGroup dt a")[0].title = data.split("@@%%")[1];
                    document.getElementById("groupidTEst").title = data.split("@@%%")[1];
                    $("#poiGroup dt a span").html($($("#poiGroup dd ul li")[$("#gfGroup dd ul li").length - 1].children[0]).html());
                    $("#gfGroup dt a span").html($($("#gfGroup dd ul li")[$("#gfGroup dd ul li").length - 1].children[0]).html());

                    msgbox(data.split("@@%%")[3]);

                    if (document.getElementById("div-AreasUp") != null) {
                        $('#div-AreasUp').remove();
                    }
                    if (document.getElementById("div-poiGroupUp") != null) {
                        $('#div-poiGroupUp').remove();
                    }
                } else
                    msgbox(data);
            }
        });
    } else {
        msgbox(dic("ReqFields", lang));
    }
}
function DeleteGroup() {
    $('#btnCancelDelGroup').button();
    $('#btnYesDelGroup').button();
    $("#div-ver-DelGroup").dialog({ modal: true, width: 350, height: 155, zIndex: 9999, resizable: false });
}
function ButtonDeletePOIokClick() {
    $.ajax({
        url: twopoint + "/main/DeletePOI.php?id=" + $('#idPoi').val() + "&l=" + lang + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
            msgbox(data);
            $('#div-Add-POI').dialog('destroy');
            for (var i = 0; i < 4; i++)
                if (Boards[i] != null)
                {
				    if($('#numPoi').val() != -1)
                    	$(tmpMarkers[i][$('#numPoi').val()].events.element).remove();
                	else
                    	$(tmpSearchMarker.events.element).remove();
               	}
        }
    });
}

function ButtonAddEditPOIokClick() {
	if (AllowAddPoi == false) { return false }
    if (document.getElementById("groupidTEst").title != '')
        var _title = document.getElementById("groupidTEst").title;
    else
        if ($(".dropdown dt a")[0].title != '')
            var _title = $(".dropdown dt a")[0].title;
        else
            var _title = '';
        if (($('#poiLat').val() != '') && ($('#poiLon').val() != '') && ($('#poiName').val() != '') && (_title != '') && ($(".dropdownRadius dt a")[0].title != '')) {
        $('#loading').css({ display: "block" });
        //ShowWait();
        var avail;
        for (var i = 1; i <= 3; i++)
            if (document.getElementById("APcheck" + i).checked) {
                avail = i;
                break;
            }
        var _radius = $(".dropdownRadius dt a")[0].title.substring($(".dropdownRadius dt a")[0].title.lastIndexOf("_")+1, $(".dropdownRadius dt a")[0].title.length);
        if ($('#btnAddPOI').val() == dic("Update", lang)) {
            //alert("EditPoiNew.php?lat=" + $('#poiLat').val() + "&lon=" + $('#poiLon').val() + "&name=" + $('#poiName').val() + "&avail=" + avail + "&ppgid=" + _title + "&id=" + $('#idPoi').val() + "&description=" + $('#poiAddress').val() + "&additional=" + $('#additionalInfo').val() + "&l=" + lang + "&radius=" + _radius);
            $.ajax({
                url: twopoint + "/main/EditPoiNew.php?lat=" + $('#poiLat').val() + "&lon=" + $('#poiLon').val() + "&name=" + $('#poiName').val() + "&avail=" + avail + "&ppgid=" + _title + "&id=" + $('#idPoi').val() + "&description=" + $('#poiAddress').val() + "&additional=&l=" + lang + "&radius=" + _radius + "&tpoint=" + twopoint,
                context: document.body,
                success: function (data) {
                	data = data.replace(/\r/g,'').replace(/\n/g,'');
                	var _col = data.split("@@%%")[1].split("|@")[0];
                	var _img = data.split("@@%%")[1].split("|@")[1];
                    if (data.indexOf(dic("Error", lang)) == -1) {
                        var _bgimg = 'url("http://80.77.159.246:88/new/pin/?color=' + String(_col.substring(1, _col.length)) + '&type='+_img+'")';
                        for (var i = 0; i < 4; i++)
                            if (Boards[i] != null) {
                            	if($('#numPoi').val() != -1){
                            		
                            		if(_title != "1")
                            		{
                            			var groupName = $(".dropdown dt a span")[0].textContent.substring(2, $(".dropdown dt a span")[0].textContent.length);
                            			Markers[i].removeMarker(tmpMarkers[i][$('#numPoi').val()]);
                            			var size = new OpenLayers.Size(24, 24);
        								var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
                                		var icon = new OpenLayers.Icon('./blank.png', size, null, calculateOffset);
                                		var ll = new OpenLayers.LonLat(parseFloat($('#poiLon').val()), parseFloat($('#poiLat').val())).transform(new OpenLayers.Projection("EPSG:4326"), Maps[i].getProjectionObject())
								        var UpdateMar = new OpenLayers.Marker(ll, icon);
								        Markers[i].addMarker(UpdateMar);
								        tmpMarkers[i][$('#numPoi').val()] = UpdateMar;
                                		tmpMarkers[i][$('#numPoi').val()].events.element.children[0].style.backgroundImage = _bgimg;
                                	} else
                        			{
                        	
                            			var groupName = dic("Settings.NotGroupedItems", lang);
                        				Markers[i].removeMarker(tmpMarkers[i][$('#numPoi').val()]);
                                		var size = new OpenLayers.Size(24, 24);
        								var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
                                		var icon = new OpenLayers.Icon(twopoint + '/images/pin-1.png', size, null, calculateOffset);
                                		var ll = new OpenLayers.LonLat(parseFloat($('#poiLon').val()), parseFloat($('#poiLat').val())).transform(new OpenLayers.Projection("EPSG:4326"), Maps[i].getProjectionObject())
                                		var UpdateMar = new OpenLayers.Marker(ll, icon);
                                		Markers[i].addMarker(UpdateMar);
                                		tmpMarkers[i][$('#numPoi').val()] = UpdateMar;
                                		tmpMarkers[i][$('#numPoi').val()].events.element.children[0].style.backgroundImage = '';
                                	}
                                	tmpMarkers[i][$('#numPoi').val()].events.element.style.cursor = 'pointer';
	                                tmpMarkers[i][$('#numPoi').val()].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + $('#poiName').val() + "<br /></strong>" + dic("Group", lang) + ": <strong style=\"font-size: 12px;\">" + groupName + "</strong>')")
	                                tmpMarkers[i][$('#numPoi').val()].events.element.setAttribute("onclick", "EditPOI('" + $('#poiLon').val() + "', '" + $('#poiLat').val() + "', '" + $('#poiName').val() + "', '" + avail + "', '" + _title + "', '" + $('#idPoi').val() + "', '" + $('#poiAddress').val() + "', '" + $('#numPoi').val() + "', '" + $('#additionalInfo').val() + "', '" + _radius + "')");
	                                $(tmpMarkers[i][$('#numPoi').val()].events.element).mouseout(function () { HidePopup() });
                               	}else
                           	{
                               		//if(_title != "1")
                               		tmpSearchMarker.events.element.children[0].style.backgroundImage = _bgimg;
                               		//else
                                	//tmpSearchMarker.events.element.children[0].style.backgroundImage = '';
                                	var _cant = $('#APcheck3').attr('checked') == true ? "False" : "True";
                                	tmpSearchMarker.events.element.attributes[3].nodeValue = "EditPOI('" + $('#poiLon').val() + "', '" + $('#poiLat').val() + "', '" + $('#poiName').val() + "', '" + avail + "', '" + _title + "', '" + $('#idPoi').val() + "', '" + $('#poiAddress').val() + "', '" + $('#numPoi').val() + "', '" + $('#additionalInfo').val() + "', '" + _radius + "')";
                                	tmpSearchMarker.events.element.attributes[2].nodeValue = "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + $('#poiName').val() + "<br /></strong>" + dic("Group", lang) + ": <strong style=\"font-size: 12px;\">" + $(".dropdown dt a span")[0].textContent.substring(2, $(".dropdown dt a span")[0].textContent.length) + "</strong>')";
                               	}
                            }
                        msgbox(data.split("@@%%")[2]);
                    } else
                        msgbox(data);
                    $('#div-Add-POI').dialog('destroy');
                    $('#loading').css({ display: "none" });
                    //HideWait();
                    //msgbox('')
                }
            });
        } else {
        	//alert("AddPoi.php?lat=" + $('#poiLat').val() + "&lon=" + $('#poiLon').val() + "&name=" + $('#poiName').val() + "&avail=" + avail + "&ppgid=" + _title + "&description=" + $('#poiAddress').val() + "&additional=" + $('#additionalInfo').val() + "&l=" + lang + "&radius=" + _radius);
            //return false;
            $.ajax({
                url: twopoint + "/main/AddPoi.php?lat=" + $('#poiLat').val() + "&lon=" + $('#poiLon').val() + "&name=" + $('#poiName').val() + "&avail=" + avail + "&ppgid=" + _title + "&description=" + $('#poiAddress').val() + "&additional=&l=" + lang + "&radius=" + _radius + "&tpoint=" + twopoint,
                context: document.body,
                success: function (data) {
                    if (data.indexOf("Error") == -1) {
                        msgbox(data.split("@@%%")[2]);
                        //if (ShowPOI == true) {
                        var _ppp = data.split("@@%%")[1].split("|");
                        
                        for (var z = 0; z < Maps.length; z++) {
                            if (Boards[z] != null) {
                                if (tmpMarkers[z] == undefined)
                                    tmpMarkers[z] = [];
                                var size = new OpenLayers.Size(24, 24);
                                var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
                                
                                if(_ppp[4] == '1')
	                            	var icon = new OpenLayers.Icon(twopoint + '/images/pin-1.png', size, null, calculateOffset);
	                            else
	                            	var icon = new OpenLayers.Icon('./blank.png', size, null, calculateOffset);

                                var ll = new OpenLayers.LonLat(parseFloat(_ppp[0]), parseFloat(_ppp[1])).transform(new OpenLayers.Projection("EPSG:4326"), Maps[z].getProjectionObject())
                                // GLOBSY MAPS
								//if (MapType[z] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_ppp[0]), parseFloat(_ppp[1])) }
                                var MyMar = new OpenLayers.Marker(ll, icon)
                                var markers = Markers[z];
                                markers.addMarker(MyMar);
                                MyMar.events.element.style.zIndex = 666
                                tmpMarkers[z][tmpMarkers[z].length] = MyMar;
                                var _bgimg = 'http://80.77.159.246:88/new/pin/?color=' +  _ppp[7] + '&type=' + _ppp[13];

								var groupName = _ppp[8];
								if(_ppp[4] == "1")
                            		groupName = dic("Settings.NotGroupedItems", lang);
                                tmpMarkers[z][tmpMarkers[z].length - 1].events.element.style.cursor = 'pointer';
								if(_ppp[4] != "1")
									tmpMarkers[z][tmpMarkers[z].length - 1].events.element.innerHTML = '<div style="background: transparent url(' + _bgimg + ') no-repeat; width: 24px; height: 24px; font-size:4px"></div>';
                                tmpMarkers[z][tmpMarkers[z].length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + $('#poiName').val() + "<br /></strong>" + dic("Group", lang) + ": <strong style=\"font-size: 12px;\">" + groupName + "</strong>')")
                                tmpMarkers[z][tmpMarkers[z].length - 1].events.element.setAttribute("onclick", "EditPOI('" + _ppp[0] + "', '" + _ppp[1] + "', '" + _ppp[2] + "', '" + _ppp[3] + "', '" + _ppp[4] + "', '" + _ppp[5] + "', '" + _ppp[6] + "', '" + (tmpMarkers[z].length - 1) + "', '" + _ppp[11] + "', '" + _ppp[12] + "')");
                                $(tmpMarkers[z][tmpMarkers[z].length - 1].events.element).mouseout(function () { HidePopup() });
                            }
                        }
                    } else
                        msgbox(data);
                    $('#div-Add-POI').dialog('destroy');
                    $('#loading').css({ display: "none" });
                }
            });
        }
    } else {
        msgbox(dic("ReqFields", lang));
    }
}
function ButtonAddGarmin() {
    if($('#garminName').val() != "" && $("#vozilca").find('option:selected').attr('id') != "0") {
        $('#loadingGarmin').css({ display: "block" });
        $.ajax({
            url: twopoint + "/main/AddGarmin.php?vehid=" + $("#vozilca").find('option:selected').attr('id') + "&lat=" + $('#garminLat').val() + "&lon=" + $('#garminLon').val() + "&description=" + kescape($('#garminAddress').val()) + "&name=" + kescape($('#garminName').val()) + "&tpoint=" + twopoint,
            context: document.body,
            success: function (data) {
                if(ws != null) {
                    ws.send('stopposition', $("#vozilca").find('option:selected').val() + '$*^' + $('#garminName').val() + '$*^' + data.replace(/\r/g, '').replace(/\n/g, '') + '$*^' + $('#garminLat').val() + '$*^' + $('#garminLon').val());
                    $('#menu-container-5').prepend('<div id="garminList-' + $("#vozilca").find('option:selected').attr('id')  + '-' + data.replace(/\r/g, '').replace(/\n/g, '') + '" style="overflow: hidden; opacity: 0.5;" class="div-one-vehicle-list text3 corner5"></div>');
                    $('#garminList-' + $("#vozilca").find('option:selected').attr('id')  + '-' + data.replace(/\r/g, '').replace(/\n/g, '')).load('./getGarminInfo.php?gid=' + data.replace(/\r/g, '').replace(/\n/g, ''));
                }
            }
        });
    } else {
        $('#errAddGarmin').css({display: 'block'});
    }
}
function ButtonAddCanned(_id, _gsmnum, _from) {
    if(_from == '0') {
        var isCheck = $('#txtCannedToAll').is(':checked');
        var _text = $('#txtCanned').val();
        var _toid = '';
    } else {
        isCheck = false;
        var _text = $("#txtCannedReg").find('option:selected').val() + ': ';
        var _toid = $("#txtCannedReg").find('option:selected').attr('id');
    }
    ShowWait();
    $.ajax({
        url: twopoint + "/main/AddCanned.php?action=add&vehid=" +_id + "&allcheck=" + isCheck + "&toid=" + _toid + "&name=" + kescape(_text) + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
            if(ws != null) {
                if(isCheck) {
                    var result = data.replace(/\r/g, '').replace(/\n/g, '');
                    result = result.split('*');
                    for(var i=1; i<result.length; i++) {
                        ws.send('quickmess', result[i].split('|')[0] + '$*^' + _text + '$*^' + result[i].split('|')[1]);
                    }
                } else {
                    ws.send('quickmess', _gsmnum + '$*^' + _text + '$*^' + data.replace(/\r/g, '').replace(/\n/g, ''));
                }
                $('#predefmess').load('../main/PredefinedMess.php?id=' + _id, function(){
                    $("#txtCannedReg").load('../tracking/garminReloadReg.php?id=' + _id, function(){
                        HideWait(); 
                    });
                });
            }
        }
    });
}
function refreshEstimation(_gsm, _code) {
    if(ws != null) {
        $('#vh-img-garminref-' + _code).attr('width', '22');
        $('#vh-img-garminref-' + _code).attr('src', $('#vh-img-garminref-' + _code).attr('src').replace('png', 'gif'));
        ws.send('estimation', _gsm);
    }
}
function checkGarmin(_gsm) {
    if(ws != null) {
        ws.send('checkgarmin', _gsm);
    }
}
function newImageFromCamera(_gsm, _code) {
	//return;
    if(ws != null) {
    	$('#vh-img-newimage').css({display: 'block'});   
    	$("#cameraNew").attr("disabled", "disabled");
     	$("#cameraNew").css({cursor: 'default', color: '#bbb'});
        //$('#vh-img-newimage-' + _code).css({display: 'block'});
        ws.send('newimagefromcamera', _gsm);
    }
}
function openCameraWindow(_gsm, _code, _lastphotopath, _lastphototime, _checkcamera) {
	//openCameraWindow('433332115', '101', '433332115_20150408145655.jpg', '08-04-2015 15:56:58', 3)
	//openCameraWindow('433332115', '101', '433332115_20150408145655.jpg', '08-04-2015 15:56:58', 3)
	//openCameraWindow('433332115', '101', fdasfas.jpg, '08-04-2015 15:15:15', 3)
	//alert($('#camera-433332115').get(0).attributes.onclick.nodeValue);
	//openCameraWindow('433332115', '101', 'fdasfas.jpg', '08-04-2015 15:15:15', 1)
	/*var cl = $('#camera-3269').get(0).attributes.onclick.nodeValue;
	alert(cl)
	var cl1 = cl.split(',')[0] + ',' + cl.split(',')[1] + ', ' + '\'fdasfas.jpg\'' + ', ' + '\'08-04-2015 15:15:15\'' + ', ' + (parseInt(cl.split(',')[4].split(")")[0])+1) + ")";
	alert(cl1)*/
	//openCameraWindow('433332115', '101', '433332115_20150408145655.jpg', '08-04-2015 15:56:58', 1)
	//openCameraWindow('433332115', '101', 'fdasfas.jpg', '08-04-2015 15:15:15',2)
	//$('#camera-3269').get(0).attributes.onclick.nodeValue = cl1;
	/*$("#camera-3269").click(function(){
 		 cl1;
	});*/
   // debugger;	 
	if (_lastphotopath == "") {
		$('#cameraImg').hide();
		$('#cam01').hide();
		$('#cam02').hide();
		$('#cameraTime').hide();
		$('#cameraName').html('<font style="font-weight:normal; font-style:italic; padding-top:5px; color:#ff6600">'+dic("Reports.VehNoPhoto",lang)+'</font>');		
	} else {
		$('#cameraImg').show();
		$('#cam01').show();
		$('#cam02').show();
		$('#cameraTime').show();
    $('#cameraName').html(_lastphotopath);
    $('#cameraTime').html(_lastphototime);
    $('#cameraImg').attr("src", "../cam/"+_lastphotopath);
	}
    $('#dialog-cameraW').dialog({ zIndex: 9999, modal: true, height: 570, width: 800});   
     $('#tmpCamera').html('<input type="button" onclick="" class="BlackText corner5" id="cameraNew" value=\''+dic("Reports.NewPhoto", lang)+'\' style="position: relative"/><br><font id="fontCam" style="font-size:10px"><span id="camNo">' + _checkcamera + '</span> / 3</font>');
	 document.getElementById('fontCam').setAttribute("title", dic("Reports.Max3Photos",lang));
     $('#cameraNew').button();
     if (_checkcamera < 3) {
     $("#cameraNew").click(function(){
     		 $.ajax({
	            url: "InsertCamera.php?gsm="+_gsm,
	                context: document.body,
	                success: function (data) {
	                	data = data.replace(/\r/g,'').replace(/\n/g,'');
	                	if (data >= 3) {
	                		document.getElementById('cameraNew').setAttribute("title", dic("Reports.LimitPhotos",lang));
	                		$("#cameraNew").attr("disabled", "disabled");
     						$("#cameraNew").css({cursor: 'default', color: '#bbb'});
     						$("#cameraNew").click(function(){});
	                	}
	            }
	        });
        newImageFromCamera(_gsm, _code);
     });
     } else {
     	document.getElementById('cameraNew').setAttribute("title", dic("Reports.LimitPhotos",lang));
     	$("#cameraNew").attr("disabled", "disabled");
     	$("#cameraNew").css({cursor: 'default', color: '#bbb'});
     }
}
var podatok = [];
podatok[18] = 1;
podatok[17] = 1;
podatok[16] = 1;
podatok[15] = 3;
podatok[14] = 6;
podatok[13] = 12;
podatok[12] = 20;
podatok[11] = 25;
podatok[10] = 30;
podatok[9] = 35;
podatok[8] = 50;
podatok[7] = 60;
podatok[6] = 0;
podatok[5] = 0;
podatok[4] = 0;
podatok[3] = 0;
podatok[2] = 0;
podatok[1] = 0;
/*
	podatok=53  zum=5  	mapa=0
	podatok=49  zum=6  	mapa=0
	podatok=45  zum=7  	mapa=0
	podatok=41  zum=8  	mapa=0
	podatok=37  zum=9  	mapa=0
	podatok=33  zum=10  mapa=0
	podatok=29  zum=11  mapa=0
	podatok=25  zum=12  mapa=0
	podatok=21  zum=13  mapa=0
	podatok=17  zum=14  mapa=0
	podatok=13  zum=15  mapa=0
	podatok=9  	zum=16  mapa=0
	podatok=5  	zum=17  mapa=0
	podatok=1  	zum=18  mapa=0
*/
function zoomeend()
{
	iszooming = false;
}
function mapEvent(event) {
    //ResetTimers()
    iszooming = true;
    setTimeout("zoomeend()", 3000);
    resetScreen[SelectedBoard] = true;
    ResetTimersStep(SelectedBoard);
    if(tmpMarkersTrajectory[SelectedBoard] != "")
    {
		var num2 = podatok[Maps[SelectedBoard].getZoom()]; //Math.abs(19 - Maps[SelectedBoard].getZoom()) + Math.abs(18 - Maps[SelectedBoard].getZoom()) + Math.abs(18 - Maps[SelectedBoard].getZoom()) + Math.abs(18 - Maps[SelectedBoard].getZoom());
		//alert("podatok=" + num2 + "  zum=" + Maps[SelectedBoard].getZoom() + "  mapa=" + SelectedBoard);
		for(var i = 0; i < tmpMarkersTrajectory[SelectedBoard].length; i++)
	    {
			if(num2 == 1)
	        	tmpMarkersTrajectory[SelectedBoard][i].display(true);
	    	else
	    		tmpMarkersTrajectory[SelectedBoard][i].display(false);
	    	num2--;
	    	if(num2 == 0)
				num2 = podatok[Maps[SelectedBoard].getZoom()]; //Math.abs(19 - Maps[SelectedBoard].getZoom()) + Math.abs(18 - Maps[SelectedBoard].getZoom()) + Math.abs(18 - Maps[SelectedBoard].getZoom()) + Math.abs(18 - Maps[SelectedBoard].getZoom());
	    }
    }
}

 var selectControl; 
 var selectedFeature = new Array();

 function EditPoly() {
     //SelectedBoard = parseInt(this.map.div.id.substring(this.map.div.id.length - 1, this.map.div.id.length), 10) - 1;
     $('#popupSelSave-'+SelectedBoard).css({ display: 'block' });
     $('#popupSelCancel-' + SelectedBoard).css({ display: 'block' });
     controls[SelectedBoard].modify.activate();
     controls[SelectedBoard].modify.selectControl.clickFeature(selectedFeature[SelectedBoard]);
     if (selectedFeature[SelectedBoard]._lastHighlighter == undefined)
         controls[SelectedBoard].modify.selectControl.clickFeature(selectedFeature[SelectedBoard]);
 }
 function removeEl(_el) {
     var d = document.getElementById(_el).parentNode;
     var old = document.getElementById(_el);
     d.removeChild(old);
 }
 function DeleteGeoFence() {
     $('#btnCancelDelGF').button();
     $('#btnYesDelGF').button();
     $("#div-ver-DelGeoF").dialog({ modal: true, width: 350, height: 155, zIndex: 9999, resizable: false });
 }
 function ButtonDeleteGFokClick() {
     ShowWait();
     $.ajax({
         url: twopoint + "/main/DeleteArea.php?id=" + selectedFeature[SelectedBoard].style.areaid + "&tpoint=" + twopoint,
         context: document.body,
         success: function (data) {
         	if(selectedFeature[SelectedBoard].style.Type == "2")
         	{
            	for (var cz = 0; cz <= cntz; cz++) {
                	if (document.getElementById("zona_" + cz) != null)
                    	if ($('#zona_' + cz)[0].attributes[1].nodeValue.indexOf(selectedFeature[SelectedBoard].style.areaid) != -1) {
                        	var d = $('#zona_' + cz)[0].parentElement.parentElement;
                         	var old = $('#zona_' + cz)[0].parentElement;
                         	d.removeChild(old);
                         	break;
                     	}
             	}
         	}
            for (var z = 0; z < Maps.length; z++) {
				for (var k = 0; k < vectors[z].features.length; k++) {
					if (vectors[z].features[k].style.name == selectedFeature[SelectedBoard].style.name) {
                        cancelFeature[z] = false;
                        controls[z].modify.deactivate();
                        if(selectedFeature[SelectedBoard].style.Type == "2")
                        {
                        	if (document.getElementById("div-polygon-menu-" + z) != null)
                            	removeEl(document.getElementById("div-polygon-menu-" + z).id);
                        	ArrAreasPoly[z][k] = "";
                        	ArrAreasId[z][k] = "";
                    	} else
                    	{
                    		ArrPolygons[z][k] = "";
                        	ArrPolygonsId[z][k] = "";
                    	}
                        vectors[z].features[k].destroy();
                    	break;
                	}
            	}
            }
            HideWait();
            if(selectedFeature[SelectedBoard].style.Type == "2")
            	msgbox(dic("GFWSD", lang));
        	else
        		msgbox(dic("deletePolygon", lang));
            //onFeatureUnselect('0');
            //selectedFeature[SelectedBoard].destroy();
         }
     });
 }
 function UpdateGeoFence(_type) {
     for (var i = 0; i < $("#gfGroup dd ul li").length; i++) {
         if ($("#gfGroup dd ul li a")[i].id == selectedFeature[SelectedBoard].style.GroupId) {
             var text = $($("#gfGroup dd ul li a")[i]).html();
             $("#gfGroup dt a")[0].title = selectedFeature[SelectedBoard].style.GroupId;
             $("#gfGroup dt a span").html(text);
             break;
         }
     }
     $('#GFcheck' + selectedFeature[SelectedBoard].style.available).attr({ checked: 'checked' });
     $('#txt_zonename').val(selectedFeature[SelectedBoard].style.name);
     //$('#txt_phones').val(selectedFeature[SelectedBoard].style.AlarmsH.split("^@@")[5]);
     //$('#txt_emails').val(selectedFeature[SelectedBoard].style.AlarmsH.split("^@@")[4]);
     
     document.getElementById('vozila').selectedIndex = 0;
     OptionsChangeVehicle();
     
     $('#alVlez').attr('checked', false);
     $('#alIzlez').attr('checked', false);
    
     $('#alVlez').click(function(){ $(this).blur(); });
	 $('#alIzlez').click(function(){ $(this).blur(); });
    
     
     $('#txt_zonename').focus();
     $('#txt_phones').val('');
     $('#txt_emails').val('');
     $('#alertINOUT').buttonset();
     $('#gfAvail').buttonset();
     $('#AddGroup1').button();
     //controls[0].modify.deactivate();
     
	if(_type == "2")
		var mes = '<font class="text2" style="font-size: 18px"><b>'+dic("updateGF", lang)+'</b></font>';
	else
		var mes = '<font class="text2" style="font-size: 18px"><b>'+dic("updatePolygon", lang)+'</b></font>';

     $('#div-enter-zone-name').attr('title', '<font class="text2" style="font-size: 18px"><b>'+dic("updateGF", lang)+'</b></font>');
     $('#div-enter-zone-name').dialog({ modal: true, zIndex: 9999, width: 642, height: 460, resizable: false,
         buttons: 
         [
            {
                text: dic("Update", lang),
                click: function () {
                	if (AllowAddZone == false) { return false }
                    if ($('#txt_zonename').val() == '') {
                        msgbox(dic("EnterGFName", lang));
                        return false
                    }
                    if ($('#gfGroup dt a')[0].title == '') {
                        msgbox(dic("SelectGroup", lang));
                        return false
                    }
                    if($('#alVlez').attr('checked') || $('#alIzlez').attr('checked'))
                    {
                    	if($('#vozila').attr('selectedIndex') == 0)
                    	{
                    		msgbox("Немате изберено група на која ке се внесе алармот!");
                        	return false;
                    	}
                    	if($('#txt_emails').val() == "" && $('#txt_phones').val() == "")
                    	{
                    		msgbox(dic("Settings.AlertsEmailHaveTo",lang));
                        	return false;
                    	}
                    }
                    if($('#txt_emails').val().length > 0 && !validacija())
                    {
                    	msgbox(dic("uncorrEmail",lang));
                    	return false;
                    }
                    if ($('#txt_phones').val() != '') {
                        var _alGF = document.getElementById("div-al-GeoFence");
                        if (_alGF == null)
                            CreateAlGeoFence();
                        $('#btnCancelAlGeoFence').button();
                        $('#btnYesAlGeoFence').button();
                        $('#alGeoFencePass').val('');
                        $('#div-al-GeoFence').dialog({ modal: true, zIndex: 9999, resizable: false,
                            buttons: 
                            [
                                {
                                    text: "Ok",
                                    click: function () {
                                        ShowWait();
                                        $.ajax({
                                            url: twopoint + "/main/checkPassword.php?pass=" + encodeURIComponent($('#alGeoFencePass').val()) + "&tpoint=" + twopoint,
                                            context: document.body,
                                            success: function (data) {
                                                if (data.indexOf("Wrong") != -1) {
                                                    msgbox(dic("WrongPass", lang));
                                                    HideWait();
                                                } else {
                                                    var strPoints = ''
                                                    for (var i = 0; i < selectedFeature[SelectedBoard].geometry.components[0].components.length; i++) {
                                                    	if(i == (selectedFeature[SelectedBoard].geometry.components[0].components.length - 1))
						                            	{
						                            		strPoints = strPoints + '^' + selectedFeature[SelectedBoard].geometry.components[0].components[0].x + '@' + selectedFeature[SelectedBoard].geometry.components[0].components[0].y;
						                                } else
						                                {
                                                        	var _point = selectedFeature[SelectedBoard].geometry.components[0].components[i]
                                                        	_point.transform(Maps[0].getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
                                                        	strPoints = strPoints + '^' + _point.x + '@' + _point.y;
                                                    	}
                                                    }
                                                    var avail;
                                                    for (var i = 1; i <= 3; i++)
                                                        if (document.getElementById("GFcheck" + i).checked) {
                                                            avail = i;
                                                            break;
                                                        }
                                                    //var tboja = $("#gfGroup dt a span div")[0].style.backgroundImage;
                                                    var _col = $("#gfGroup dt a span div")[0].style.backgroundColor;
                                                    UpdateArea($('#txt_zonename').val(), strPoints, selectedFeature[SelectedBoard].style.areaid, avail, $("#gfGroup dt a")[0].title, _col, _type);
                                                    //SavingNewArea(strPoints);
                                                    //CancelDrawingArea(num);
                                                }

                                            }
                                        });
                                    }
                                },
                                {
                                    text: dic("cancel", lang),
                                    click: function () {
                                        $('#div-al-GeoFence').dialog('destroy');
                                        $('#txt_phones').val('');
                                    }
                                }
                            ]
                        });
                    } else {
                        ShowWait();
                        var strPoints = ''
                        for (var i = 0; i < selectedFeature[SelectedBoard].geometry.components[0].components.length; i++) {
                        	if(i == (selectedFeature[SelectedBoard].geometry.components[0].components.length - 1))
	                    	{
	                    		strPoints = strPoints + '^' + selectedFeature[SelectedBoard].geometry.components[0].components[0].x + '@' + selectedFeature[SelectedBoard].geometry.components[0].components[0].y;
	                        } else
	                        {
                            	var _point = selectedFeature[SelectedBoard].geometry.components[0].components[i]
                            	_point.transform(Maps[0].getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
                            	strPoints = strPoints + '^' + _point.x + '@' + _point.y;
                        	}
                        }
                        var avail;
                        for (var i = 1; i <= 3; i++)
                            if (document.getElementById("GFcheck" + i).checked) {
                                avail = i;
                                break;
                            }
                        //var tboja = $("#gfGroup dt a span div")[0].style.backgroundImage;
                        var _col = $("#gfGroup dt a span div")[0].style.backgroundColor;
                        UpdateArea($('#txt_zonename').val(), strPoints, selectedFeature[SelectedBoard].style.areaid, avail, $("#gfGroup dt a")[0].title, _col, _type);
                        //SavingNewArea(strPoints);
                        //CancelDrawingArea(num)
                    }
                }
             }, //Update
             {
                text: dic("cancel", lang),
                click: function () {
                     //CancelDrawingArea() 
                     $('#div-enter-zone-name').dialog('destroy');
                 } // Cancel
             }
        ] // Buttons
        ,
        "title": mes
     });
 }
 function onFeatureSelect(feature) {
     if (feature.geometry.id.indexOf("LineString") == -1) {
         if (document.getElementById("div-polygon-menu-" + SelectedBoard) != null)
             if ($('#div-polygon-menu-' + SelectedBoard)[0].textContent.indexOf(feature.style.name) != -1)
                 return false;
         if (selectedFeature[SelectedBoard] != undefined) {
             if (selectedFeature[SelectedBoard].id != feature.id)
                 if (document.getElementById("div-polygon-menu-" + SelectedBoard) != null)
                     removeEl(document.getElementById("div-polygon-menu-" + SelectedBoard).id);
                 else
                     if (!controls[SelectedBoard].modify.active)
                         if (document.getElementById("div-polygon-menu-" + SelectedBoard) != null)
                             removeEl(document.getElementById("div-polygon-menu-" + SelectedBoard).id);
         }
         selectedFeature[SelectedBoard] = feature;
         /*if (feature.style.CantChange == "False") {
             var _onclickE = "CantDeleteGF()";
             var _onclickD = "CantDeleteGF()";
         }
         else {*/
             var _onclickE = "EditPoly()";
             var _onclickD = "DeleteGeoFence()";
         //}
         var _html = "<div class=\"text7\" style=\"color: White\">" + dic("Name", lang) + ": <font class=\"text9\" style=\"color: White\">" + feature.style.name + "</font></div><br/>";
         _html += "<input type=\"button\" id=\"popupEdit-" + SelectedBoard + "\" style=\"padding: 3px; margin-right: 5px;\" onclick=\"" + _onclickE + "\" value=\"" + dic("Edit", lang) + "\" />";
         _html += "<input type=\"button\" id=\"popupDelete-" + SelectedBoard + "\" style=\"padding: 3px; margin-right: 5px;\" onclick=\"" + _onclickD + "\" value=\"" + dic("Delete", lang) + "\" />";
         _html += "<input type=\"button\" id=\"popupCancel-" + SelectedBoard + "\" style=\"padding: 3px;\" onclick=\"onFeatureUnselect('0', " + feature.style.Type + ")\" value=\"" + dic("cancel", lang) + "\" /><br />";

         _html += "<input type=\"button\" id=\"popupSelSave-" + SelectedBoard + "\" style=\"float: left; margin-right: 4px; padding: 0px; margin-top: 7px;\" onclick=\"UpdateGeoFence(" + feature.style.Type + ")\" value=\"" + dic("Save", lang) + "\" />";
         _html += "<input type=\"button\" id=\"popupSelCancel-" + SelectedBoard + "\" style=\"float: left; padding: 0px; margin-top: 7px;\" onclick=\"onFeatureUnselect('1', " + feature.style.Type + ")\" value=\"" + dic("cancel", lang) + "\" />";
         var _wid = Boards[SelectedBoard].clientWidth;
         var PolygonMenu = Create($(Boards[SelectedBoard]).children()[0], 'div', 'div-polygon-menu-' + SelectedBoard);
         //var _w = lang == 'en'? '140' : '175';

         $(PolygonMenu).css({ display: 'block', position: 'absolute', zIndex: '7999', backgroundColor: '#387cb0', color: '#fff', left: '50px', top: ($('#div-layer-icons-0').height() + 40) + 'px', padding: '12px 15px 12px 15px', width: lang == 'en' ? '137' : '177' + 'px', cursor: 'pointer', textAlign: 'left' });
         PolygonMenu.className = 'corner15';

         PolygonMenu.innerHTML = '<div style="height:2px"></div>' + _html + '<div style="height:2px"></div>';

         $('#popupEdit-' + SelectedBoard).button();
         $('#popupDelete-' + SelectedBoard).button();
         $('#popupCancel-' + SelectedBoard).button();
         $('#popupSelSave-' + SelectedBoard).button();
         $('#popupSelCancel-' + SelectedBoard).button();
         $('#popupSelSave-' + SelectedBoard).css({ display: 'none' });
         $('#popupSelCancel-' + SelectedBoard).css({ display: 'none' });
     } else {
         feature.style.VehID;

         if (document.getElementById("div-polygon-menu-" + SelectedBoard) != null)
             if ($('#div-polygon-menu-' + SelectedBoard)[0].textContent.indexOf(feature.style.name) != -1)
                 return false;
         if (selectedFeature[SelectedBoard] != undefined) {
             if (selectedFeature[SelectedBoard].id != feature.id)
                 if (document.getElementById("div-polygon-menu-" + SelectedBoard) != null)
                     removeEl(document.getElementById("div-polygon-menu-" + SelectedBoard).id);
                 else
                     if (!controls[SelectedBoard].modify.active)
                         if (document.getElementById("div-polygon-menu-" + SelectedBoard) != null)
                             removeEl(document.getElementById("div-polygon-menu-" + SelectedBoard).id);
         }
         selectedFeature[SelectedBoard] = feature;
         var _html = "<div class=\"text7\" style=\"color: White\">" + dic("Name", lang) + ": <font class=\"text9\" style=\"color: White\">" + feature.style.VehID + "</font></div><br/>";
         //_html += "<input type=\"button\" id=\"popupEdit-" + SelectedBoard + "\" style=\"padding: 3px; margin-right: 5px;\" onclick=\"EditPoly()\" value=\"" + dic("Edit", lang) + "\" />";
         //_html += "<input type=\"button\" id=\"popupDelete-" + SelectedBoard + "\" style=\"padding: 3px; margin-right: 5px;\" onclick=\"DeleteGeoFence()\" value=\"" + dic("Delete", lang) + "\" />";
         _html += "<input type=\"button\" id=\"popupCancel-" + SelectedBoard + "\" style=\"padding: 3px;\" onclick=\"onFeatureUnselect('0')\" value=\"" + dic("cancel", lang) + "\" /><br />";

         //_html += "<input type=\"button\" id=\"popupSelSave-" + SelectedBoard + "\" style=\"float: left; margin-right: 4px; padding: 0px; margin-top: 7px;\" onclick=\"UpdateGeoFence()\" value=\"" + dic("Save", lang) + "\" />";
         //_html += "<input type=\"button\" id=\"popupSelCancel-" + SelectedBoard + "\" style=\"float: left; padding: 0px; margin-top: 7px;\" onclick=\"onFeatureUnselect('1')\" value=\"" + dic("cancel", lang) + "\" />";
         var _wid = Boards[SelectedBoard].clientWidth;
         var PolygonMenu = Create($(Boards[SelectedBoard]).children()[0], 'div', 'div-polygon-menu-' + SelectedBoard);
         //var _w = lang == 'en'? '140' : '175';

         $(PolygonMenu).css({ display: 'block', position: 'absolute', zIndex: '7999', backgroundColor: '#387cb0', color: '#fff', left: '50px', top: '35px', padding: '12px 15px 12px 15px', width: lang == 'en' ? '140' : '175' + 'px', cursor: 'pointer', textAlign: 'left' });
         PolygonMenu.className = 'corner15';

         PolygonMenu.innerHTML = '<div style="height:2px"></div>' + _html + '<div style="height:2px"></div>';

         //$('#popupEdit-' + SelectedBoard).button();
         //$('#popupDelete-' + SelectedBoard).button();
         $('#popupCancel-' + SelectedBoard).button();
         //$('#popupSelSave-' + SelectedBoard).button();
         //$('#popupSelCancel-' + SelectedBoard).button();
         //$('#popupSelSave-' + SelectedBoard).css({ display: 'none' });
         //$('#popupSelCancel-' + SelectedBoard).css({ display: 'none' });
     }
 }
 function onFeatureUnselect(_bool, _type) {
     //document.getElementById("testText").value += "   |   " + SelectedBoard;
     controls[SelectedBoard].modify.deactivate();
     if (document.getElementById("div-polygon-menu-" + SelectedBoard) != null)
         removeEl(document.getElementById("div-polygon-menu-" + SelectedBoard).id);
     if (_bool == "1") {
         onFeatureSelect(selectedFeature[SelectedBoard]);
     }
     if (cancelFeature[SelectedBoard]) {
         if (selectedFeature[SelectedBoard].style != null) {
             var _areaid = selectedFeature[SelectedBoard].style.areaid;
             var _col = selectedFeature[SelectedBoard].style.fillColor;
             selectedFeature[SelectedBoard].destroy();
             PleaseDrawAreaAgainSB(_areaid, _col, SelectedBoard, _type);

             cancelFeature[SelectedBoard] = false;
         }
     }
 }
 
 function onFeatureModify(feature) {
     if (selectedFeature[SelectedBoard] != undefined)
         if (feature.id != selectedFeature[SelectedBoard].id) {
             controls[SelectedBoard].modify.deactivate();
             controls[SelectedBoard].modify.activate();
         }
 }
 function onFeatureUnmodify(feature) {
     if (selectedFeature[SelectedBoard] != undefined && selectedFeature[SelectedBoard] != "")
         if (feature.id != selectedFeature[SelectedBoard].id) {
             controls[SelectedBoard].modify.deactivate();
             controls[SelectedBoard].modify.activate();
             controls[SelectedBoard].modify.selectControl.clickFeature(selectedFeature[SelectedBoard]);
         }
 }
 function onFeatureStartModify(feature) {
     cancelFeature[SelectedBoard] = true;
 }

function mapmovestart()
{
	//PauseClickNew();
}

function LoadMaps() {
     for (var i = 0; i < 4; i++) {
         if (Boards[i] != null) {
             map = new OpenLayers.Map({ div: Boards[i].id, allOverlays: true,
                 eventListeners: {
                     "zoomend": mapEvent,
                     "movestart": mapmovestart,
                     "click": function (e) { eventClick(e) }
                 }, maxExtent: new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34),
                 maxResolution: 156543.0399,
                 numZoomLevels: 19,
                 units: 'm',
                 projection: new OpenLayers.Projection("EPSG:900913"),
                 displayProjection: new OpenLayers.Projection("EPSG:4326")
             });
             var layer;
             
             if (MapType[i] == 'GOOGLEM') { layer = new OpenLayers.Layer.Google("Google Streets") }
             if (MapType[i] == 'GOOGLES') { layer = new OpenLayers.Layer.Google("Google Satellite", { type: google.maps.MapTypeId.HYBRID }) }
             if (MapType[i] == 'GOOGLEP') { layer = new OpenLayers.Layer.Google("Google Physical", { type: google.maps.MapTypeId.TERRAIN }) }

             if (MapType[i] == 'OSMM') { layer = new OpenLayers.Layer.OSM() }
             if (MapType[i] == 'OSMS') { layer = new OpenLayers.Layer.OSM("OpenStreetMap (Tiles@Home)", "http://tah.openstreetmap.org/Tiles/tile/${z}/${x}/${y}.png") }

			 //GLOBSY MAPS
			 if (MapType[i] == 'YAHOOM') { layer = new OpenLayers.Layer.WMS( "OpenLayers WMS", "http://144.76.225.247:8080/geoserver/gwc/service/wms", {'layers': 'GeonetMaps', format: 'image/png'}); }
             if (MapType[i] == 'YAHOOS') { layer = new OpenLayers.Layer.Google("Google Satellite", { type: google.maps.MapTypeId.HYBRID }) }
             if (MapType[i] == 'YAHOOP') { layer = new OpenLayers.Layer.Google("Google Physical", { type: google.maps.MapTypeId.TERRAIN }) }

             if (MapType[i] == 'BINGM') { layer = new OpenLayers.Layer.Bing({ key: apiKey, type: "Road", metadataParams: { mapVersion: "v1"} }) }
             if (MapType[i] == 'BINGS') { layer = new OpenLayers.Layer.Bing({ key: apiKey, type: "AerialWithLabels", wrapDateLine: true }) }
             map.addLayers([layer]);

			// style the sketch fancy
			var sketchSymbolizers = {
				"Line": {
					strokeWidth: 3,
					strokeOpacity: 1,
					strokeColor: "#666666",
					strokeDashstyle: "dash"
				}
			};
			var style123 = new OpenLayers.Style();
			style123.addRules([
				new OpenLayers.Rule({symbolizer: sketchSymbolizers})
			]);
			var styleMap123 = new OpenLayers.StyleMap({"default": style123}); 

             //if (OpenForDrawing==true){   //CVETKOSKI
             var renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
             renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;
             vectors[i] = new OpenLayers.Layer.Vector("Vector Layer", {
                 renderers: renderer
             });
             map.addLayer(vectors[i]);

             selectControl = new OpenLayers.Control.SelectFeature(vectors[i],
             {
                 onSelect: onFeatureSelect,
                 onUnselect: onFeatureUnselect
             });
             modifyControl = new OpenLayers.Control.ModifyFeature(vectors[i],
             {
                 onModificationStart: onFeatureModify,
                 onModificationEnd: onFeatureUnmodify,
                 onModification: onFeatureStartModify
             });
             controls[i] = {
                 polygon: new OpenLayers.Control.DrawFeature(vectors[i], OpenLayers.Handler.Polygon),
                 modify: modifyControl,
                 line: new OpenLayers.Control.Measure(
                    OpenLayers.Handler.Path, {
                        persist: true,
                        geodesic: true,
                        handlerOptions: {
                            layerOptions: {
                                renderers: renderer,
                                styleMap: styleMap123
                            }
                        }
                    }
                ),
                select: selectControl, // new OpenLayers.Control.SelectFeature(vectors[i])
                drag: new OpenLayers.Control.DragFeature(vectors[i], {
                    onStart: function(feature) {
                        if(feature.style.type != 's' && feature.style.type != 'e') {
                            toggleControl('drag', false, 0);
                            toggleControl('drag', true, 0);
                        }
                    },
                    onComplete: function(feature) {
                        dragFinish(feature)   
                    }
                })
             }

             controls[i]['line'].events.on({
                 "measure": handleMeasurements,
                 "measurepartial": handleMeasurements
             });

             vectors[i].events.on({
                 "sketchcomplete": function report(event) {
                     selectedFeature[SelectedBoard] = event.feature;
                     toggleControl('modify', true, parseInt(this.map.div.id.substring(this.map.div.id.length - 1, this.map.div.id.length), 10) - 1);
                     event.feature.layer = this;
                     controls[parseInt(this.map.div.id.substring(this.map.div.id.length - 1, this.map.div.id.length), 10) - 1].modify.selectControl.clickFeature(event.feature);

                     //controls[parseInt(this.map.div.id.substring(this.map.div.id.length - 1, this.map.div.id.length), 10) - 1].select.activate();
                     //controls[parseInt(this.map.div.id.substring(this.map.div.id.length - 1, this.map.div.id.length), 10) - 1].select.toggle = true;
                     //controls[parseInt(this.map.div.id.substring(this.map.div.id.length - 1, this.map.div.id.length), 10) - 1].modify.selectFeature(event.feature);
                     //controls[parseInt(this.map.div.id.substring(this.map.div.id.length - 1, this.map.div.id.length), 10) - 1].select.clickFeature(event.feature);
                 }
             });

             for (var key in controls[i]) {
                 map.addControl(controls[i][key]);
             }

             if(metric == "mi")
             	map.controls[6].displaySystem = "english";

             controls[i].select.activate();
             
             //}
             var markers = new OpenLayers.Layer.Markers("Markers");
             map.addLayer(markers);
             Markers[i] = markers

             if (MapType[i] == 'YAHOOM') {
                // GLOBSY MAPS
				//map.setCenter(new OpenLayers.LonLat(StartLon, StartLat), DefMapZoom);
				map.setCenter(new OpenLayers.LonLat(StartLon, StartLat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject()), DefMapZoom);
             
			 } else {
                 map.setCenter(new OpenLayers.LonLat(StartLon, StartLat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject()), DefMapZoom);
             }
             $('.olControlAttribution').css({ bottom: '7px', right: '', left: '3px' });
             Maps[i] = map;
             
             if(allowbuttons)
             	AddLayerSwitcher(Boards[i], i);
			 
			 if (Routing == true) { AddLayerRoute(Boards[i], i); }

             //if (AjaxStarted == false) { Ajax() }
             if (RecStarted == true) { RecStert(1) }
         }

     }
     
     InitLoad = true
     for (var vc = 0; vc < Vehicles.length; vc++) {
         Vehicles[vc].Marker.display(false)
     }
     Vehicles = null
     Vehicles = []
     setTimeout("ResetTimers()", 500);
     InitLoad = false;

     if (ShowPOI) {
		 ArrPolygons = [];
         ArrPolygonsId = [];
         ArrPolygonsCheck = [];
         var tmpEl = document.getElementById("div-poiGroupUp");
         if (tmpEl != null) {
             if ($('#3_AllGroupCheck').attr('checked')) {
                 ShowPOI = false;
                 LoadAllPOI('All', i);
             } else {
                 Applay_3(3, "div-poiGroupUp");
             }
         } else {
             ShowPOI = false;
             LoadAllPOI('All', i);
         }
     }
     if(RecOnNewAll)
        top.SetHeight();
     if (ShowHideZone) {
         ArrAreasPoly = [];
         ArrAreasId = [];
         ArrAreasCheck = [];
         var tmpEl = document.getElementById("div-AreasUp");
         if (tmpEl != null) {
             if ($('#2_AllGroupCheck').attr('checked')) {
                 ShowHideZone = false;
                 LoadAllZone();
             } else {
                 Applay_2(2, "div-AreasUp");
             }
         } else {
             ShowHideZone = false;
             LoadAllZone();
         }
     }
     if (ShowHideTrajectory) {
         var tmpEl = document.getElementById("div-VehicleUp");
         if (tmpEl != null) {
             if ($('#1_AllGroupCheck').attr('checked')) {
                 ShowHideTrajectory = false;
                 OnClickSHTrajectory();
             } else {
                 Applay_1(1, "div-VehicleUp");
             }
         } else {
             ShowHideTrajectory = false;
             OnClickSHTrajectory();
         }
     }
	 if (Routing == false && RecOnNewAll == false) { 
	     map.events.register('mouseover', map, function(e) {
	     	if(true)
	     	{
				var $elements = GetAllElementsAt(e.pageX, e.pageY);
				veh = '';
				vehnum = '';
				countofveh = 0;
			    //$("label").html("Found:=" + $elements.length + "<br />");
		
			    for(var pop=0; pop<$elements.length; pop++)
			    {
			    	//if($elements[pop][0].id.indexOf("OL_Icon_") != -1)
			    	//{
			    		if($elements[pop][0].innerHTML.indexOf("92.55") == -1 && $elements[pop][0].innerHTML.indexOf("pin-1.png") == -1)
			    		{
				    		if($elements[pop][0].id.indexOf("innerImage") != -1)
				    		{
				    			veh += "#vehicleList-" + $elements[pop].children().html() + ";";
				    		}
				    		else
				    		{
				    			veh += "#vehicleList-" + $elements[pop].children().children().html() + ";";
				    		}
				    		countofveh++;
				    		vehnum = pop;
				    	}
			    	//}
			    }
			    if($elements[vehnum] != undefined && veh != '')
			    {
			    	if(countofveh > 4)
			    		$elements[vehnum][0].setAttribute("onmousemove", "ShowPopupB1(event, '" + veh.substring(0, veh.length - 1) + "')");
			    	else
			    		$elements[vehnum][0].setAttribute("onmousemove", "ShowPopupB(event, '" + veh.substring(0, veh.length - 1) + "')");
		        	$elements[vehnum][0].setAttribute("onmouseout", "HidePopup()");
		        }
			    /*$("label").html(veh);
			    $elements.each(function() {
			    	if($(this)[0].id.indexOf("OL_Icon_") != -1)
			    	{
			    		if($(this)[0].id.indexOf("innerImage") != -1)
			    		{
			    			if(veh.indexOf("#vehicleList-" + $(this).children().html() + ";") == -1)
			    			{
			    				veh += "#vehicleList-" + $(this).children().html() + ";";
			    				countofveh++;
			    			}
			    		}
			    		else
			    		{
			    			if(veh.indexOf("#vehicleList-" + $(this).children().children().html() + ";") == -1)
			    			{
			    				veh += "#vehicleList-" + $(this).children().children().html() + ";";
			    				countofveh++;
			    			}
			    		}
			    		vehnum = $(this)[0];
			    	}
			    });
			    if(vehnum != '' && veh != '')
			    {
			    	if(countofveh > 4)
			    		vehnum.setAttribute("onmousemove", "ShowPopupB1(event, '" + veh.substring(0, veh.length - 1) + "')");
			    	else
			    		vehnum.setAttribute("onmousemove", "ShowPopupB(event, '" + veh.substring(0, veh.length - 1) + "')");
		        	vehnum.setAttribute("onmouseout", "HidePopup()");
		        }*/
			}
		});
	}
}
 

function GetAllElementsAt(x, y, e) {
    var $elements = $('.sitevozila').map(function() {
        var $this = $(this.parentNode.parentNode);
        var offset = $this.offset();
        var l = offset.left;
        var t = offset.top;
        var h = $this.height();
        var w = $this.width();

        var maxx = l + w;
        var maxy = t + h;
		/*if($this[0].id.indexOf("OL_Icon_") != -1)
			if($this.children().children()[0] != undefined)
				if($this.children().children()[0].tagName == "STRONG")
        			$("ul").append("<li>" + $this[0].id + " (" + $this[0].tagName + ")" + " [l:=" + l + ",t:=" + t + ",h:=" + h + ",w:=" + w + ",maxx:=" + maxx + ",maxy:=" + maxy + "]</li>");
		*/
        return (y <= maxy && y >= t) && (x <= maxx && x >= l) ? $this : null;
    });

    return $elements;
}
 
 function funkcija1() {
     alert(1);
 }
 function handleMeasurements(event) {
     var geometry = event.geometry;
     var units = event.units;
     var order = event.order;
     var measure = event.measure;
     var out = "";
     if (order == 1) {
         out += dic("Measure", lang) + ": " + measure.toFixed(3) + " " + units;
     } else {
         out += dic("Measure", lang) + ": " + measure.toFixed(3) + " " + units + "<sup>2</" + "sup>";
     }
     for (var i = 0; i < 4; i++)
         if (document.getElementById('outputMeasure-' + i) != null)
             $('#outputMeasure-'+i).html(out);
 }
 
 function toggleControl(_key, _checked, num) {
     //polygon
     for (key in controls[num]) {
         var control = controls[num][key];
         if ((_key == key) && _checked) {
             control.activate();
         } else {
             control.deactivate();
         }
     }
 }
function toggleControl1(element, num) {
    if (!controls[num][element].active) {
        controls[num][element].activate();
        controls[num][element].setImmediate(true);
        $('#div-addRuler-' + num)[0].textContent = dic("cancel", lang);
        $('#div-addRuler-' + num)[0].className = "cornerAdd text3";
        $('#div-addRuler-' + num)[0].style.borderBottom = '1px Solid White';
        var mmetric = "km";
        if(metric == 'mi')
        	mmetric = "mi";
        $('#outputMeasure-' + num).html(dic("Measure", lang) +": 0.000 "+mmetric);
        $('#outputMeasure-' + num).css({ display: 'block' });
    } else {
        controls[num][element].setImmediate(false);
        controls[num][element].deactivate();
        $('#div-addRuler-' + num)[0].className = "corner15 text3";
        $('#div-addRuler-' + num)[0].style.borderBottom = '';
        $('#outputMeasure-' + num).css({ display: 'none' });
        //document.getElementById('outputMeasure').value = "";
        $('#div-addRuler-' + num)[0].textContent = dic("Ruler", lang);
    }
}

function ClearGraphic(_t) {
    for (var z = 0; z < Maps.length; z++) {
        if (vectors[z] != null) {
            vectors[z].removeAllFeatures();
            if(_t != undefined)
            {
            	if(_t == "2")
            	{
            		if (ArrAreasCheck[z] != undefined) {
		                for (var i = 0; i < ArrAreasCheck[z].length; i++)
		                    if (ArrAreasCheck[z][i] == 1)
		                        vectors[z].addFeatures([ArrAreasPoly[z][i]]);
		            }
            	} else
            	{
            		if (ArrPolygonsCheck[z] != undefined) {
		                for (var i = 0; i < ArrPolygonsCheck[z].length; i++)
		                    if (ArrPolygonsCheck[z][i] == 1)
		                        vectors[z].addFeatures([ArrPolygons[z][i]]);
		            }
            	}
            } else
          	{
          		if (ArrAreasCheck[z] != undefined) {
	                for (var i = 0; i < ArrAreasCheck[z].length; i++)
	                    if (ArrAreasCheck[z][i] == 1)
	                        vectors[z].addFeatures([ArrAreasPoly[z][i]]);
	            }
          	}  
        }
    }
    if (ArrLineFeature != undefined && ArrLineFeature != '')
        vectors[0].addFeatures(ArrLineFeature);
}
function ClearGraphicRedraw(_t) {
    var z = 0;
    if (vectors[z] != null) {
        vectors[z].removeAllFeatures();
            
		if (ArrAreasCheck[z] != undefined) {
            for (var i = 0; i < ArrAreasCheck[z].length; i++)
                if (ArrAreasCheck[z][i] == 1)
                    vectors[z].addFeatures([ArrAreasPoly[z][i]]);
       	}
		if (ArrPolygonsCheck[z] != undefined) {
            for (var i = 0; i < ArrPolygonsCheck[z].length; i++)
                if (ArrPolygonsCheck[z][i] == 1)
                    vectors[z].addFeatures([ArrPolygons[z][i]]);
        }
    }
    if (ArrLineFeature != undefined && ArrLineFeature != '')
        vectors[0].addFeatures(ArrLineFeature);
}
function ClearArrayAlpha() {
    for (var tmpMR = 0; tmpMR < tmpMarkersRec.length; tmpMR++) {
        Markers[0].removeMarker(tmpMarkersRec[tmpMR]);
        tmpMarkersRec[tmpMR].destroy();
    }
    tmpMarkersRec = [];
}
function ClearArrayTrajectory() {
	for (var z = 0; z < Maps.length; z++) {
		if(Maps[z] != null)
	    {
	    	for (var tmpTR = 0; tmpTR < tmpMarkersTrajectory[z].length; tmpTR++) {
		        Markers[z].removeMarker(tmpMarkersTrajectory[z][tmpTR]);
		        tmpMarkersTrajectory[z][tmpTR].destroy();
		    }
		    tmpMarkersTrajectory[z] = [];
	    }
   }
}
function DrawPolygon(LonArray, LatArray, movemap, _color, _name, _areaid, _avail, _cant, _gfgid, _alarmsH, _alarmsVeh, _type) {
    if (movemap == null) { movemap = true }
    
    site_style = { 'strokeWidth': 1, 'strokeColor': '#FF0000', 'fillOpacity': 0.5, 'fillColor': _color, 'name': _name, 'areaid': _areaid, 'available': _avail, 'CantChange': _cant, 'GroupId': _gfgid, 'AlarmsH': _alarmsH, 'AlarmsVeh': _alarmsVeh, 'Type': _type }
	var _lon = LonArray.split(",")
	var _lat = LatArray.split(",")
	var site_points = new Array();
	var polygonFeature = new Array();
	for (var z = 0; z < Maps.length; z++) {
	    site_points[z] = new Array();
	    for (i in _lon) {
	        point = new OpenLayers.Geometry.Point(_lon[i], _lat[i]);
	        point.transform(
			new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
			Maps[z].getProjectionObject() // to Spherical Mercator Projection
		  );
	        site_points[z].push(point);
	    }
	    site_points[z].push(site_points[z][0]);

	    var linear_ring = new OpenLayers.Geometry.LinearRing(site_points[z]);
	    polygonFeature[z] = new OpenLayers.Feature.Vector(
				new OpenLayers.Geometry.Polygon([linear_ring]), null, site_style);
	    vectors[z].addFeatures([polygonFeature[z]]);
	    if(_type == "2")
	    {
			if(ArrAreasPoly[z] != undefined)
				if(ArrAreasPoly[z].length >= cntz)
					HideWait();
			if(cntz == 0)
	    		HideWait();
		} else
			HideWait();
	    
	    if (movemap == true) { setCenterMap(_lon[0], _lat[0], 15, z) }
	}
    return polygonFeature
}
function DrawPolygonSB(LonArray, LatArray, movemap, _color, _name, _areaid, _avail, _cant, _gfgid, _alarmsH, _alarmsVeh, _sb, _type) {
    if (movemap == null) { movemap = true }

    site_style = { 'strokeWidth': 1, 'strokeColor': '#FF0000', 'fillOpacity': 0.5, 'fillColor': _color, 'name': _name, 'areaid': _areaid, 'available': _avail, 'CantChange': _cant, 'GroupId': _gfgid, 'AlarmsH': _alarmsH, 'AlarmsVeh': _alarmsVeh, 'Type': _type }
    var _lon = LonArray.split(",")
    var _lat = LatArray.split(",")
    var site_points = new Array();
    var polygonFeature = new Array();
    site_points[_sb] = new Array();
    for (i in _lon) {
        point = new OpenLayers.Geometry.Point(_lon[i], _lat[i]);
        point.transform(
			new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
			Maps[_sb].getProjectionObject() // to Spherical Mercator Projection
		  );
        site_points[_sb].push(point);
    }
    site_points[_sb].push(site_points[_sb][0]);

    var linear_ring = new OpenLayers.Geometry.LinearRing(site_points[_sb]);
    polygonFeature[_sb] = new OpenLayers.Feature.Vector(
				new OpenLayers.Geometry.Polygon([linear_ring]), null, site_style);
    vectors[_sb].addFeatures([polygonFeature[_sb]]);

    if (movemap == true) { setCenterMap(_lon[0], _lat[0], 15, _sb) }

    return polygonFeature;
}
function DrawPathAgain(LonArray, LatArray, vhID, _j, _i, VehReg) {
    if (ShowHideTrajectory == false) { return }
    //document.getElementById("testText").value = vhID;
    if (resetScreen[_j]) { return false; }
    
    if (PathPerVeh[0][vhID] == undefined || PathPerVeh[0][vhID] == "") {
    	return false;
        //PathPerVeh[vhID] = [];
        //ShowWait();
        //get10Points(vhID, VehReg);
    } else {
    	for (var j = 0; j < Car.length; j++) {
	        if (Car[j].id == vhID) {
	            var CarDT = Car[j].datum.split(" ")[1] + " " + Car[j].datum.split(" ")[0];
	            break;
	        }
	    }
	    
        var _lon = LonArray.split(",")
        var _lat = LatArray.split(",")

        var points = new Array();
        var styles = new Array();
        var styles1 = new Array();
		            
        var cir = _lon.length / 3
        var cir1 = cir + cir
        var cir2 = _lon.length

        var debelina = 4;
        var opac = 0.9;
        for (i in _lon) {

            point = new OpenLayers.Geometry.Point(_lon[i], _lat[i]);
            point.transform(
				new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
				Maps[_j].getProjectionObject() // to Spherical Mercator Projection
			  );
            styles.push({ 'strokeWidth': debelina, 'strokeColor': '#2AAEDE', 'strokeOpacity': opac, 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg + '<br />' + CarDT })
            styles1.push({ 'strokeWidth': '6', 'strokeColor': '#000000', 'strokeOpacity': '0.5', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg + '<br />' + CarDT })
            points.push(point)
            //debelina = debelina - 0.5
            //opac = opac - 0.05
        }
        LastPointsLon[_j][vhID] = _lon[1]
        LastPointsLat[_j][vhID] = _lat[1]
		
		//drawDirection(_j, _lon[1], _lat[1], vhID, VehReg, CarDT, alfaaa, 1);
        for (var i = 0; i < _lon.length-1; i++) {
            var lineString1 = new OpenLayers.Geometry.LineString([points[i], points[i + 1]]);
            var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, styles[i]);
            var lineString2 = new OpenLayers.Geometry.LineString([points[i], points[i + 1]]);
            var lineFeature2 = new OpenLayers.Feature.Vector(lineString2, null, styles1[i]);
            PathPerVeh[_j][vhID][PathPerVeh[_j][vhID].length] = lineFeature1;
            PathPerVehShadow[_j][vhID][PathPerVehShadow[_j][vhID].length] = lineFeature2;
            vectors[_j].addFeatures([lineFeature2]);
            vectors[_j].addFeatures([lineFeature1]);
            
            lineFeature1.layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>" + dic("RouteForV", lang) + "<br /></strong>'+event.target._style.VehID)}");
            lineFeature1.layer.events.element.setAttribute("onmouseout", "HidePopup()");
            lineFeature2.layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>" + dic("RouteForV", lang) + "<br /></strong>'+event.target._style.VehID)}");
            lineFeature2.layer.events.element.setAttribute("onmouseout", "HidePopup()");
        }
        //document.getElementById("testText").value = (PathPerVeh[vhID].length / 25);
        //if(vhID == "6")
//        	debugger;
    	
    	//PathPerVeh[vhID][PathPerVeh[vhID].length-1].style.VehID
    	
    	if(PathPerVeh[_j][vhID][0].style.VehID.split("<br />").length == 2)
    	{
        	vectors[_j].removeFeatures(PathPerVeh[_j][vhID][0]);
        	vectors[_j].removeFeatures(PathPerVehShadow[_j][vhID][0]);
        	PathPerVeh[_j][vhID] = PathPerVeh[_j][vhID].splice(1, PathPerVeh[_j][vhID].length);
        	PathPerVehShadow[_j][vhID] = PathPerVehShadow[_j][vhID].splice(1, PathPerVehShadow[_j][vhID].length);
        }
        //if ((PathPerVeh[vhID].length / 25) > 10) {
        var boolCheck = true;
        
        while(boolCheck)
        {
        	var _dtMtraject = tmpMarkersTrajectory[_j][0].events.element.attributes[2].value;
        	_dtMtraject = _dtMtraject.substring(_dtMtraject.lastIndexOf("/>")+2,_dtMtraject.indexOf("</strong>"));
        	var _dtTraj = new Date(_dtMtraject.split(" ")[1].split("-")[2], _dtMtraject.split(" ")[1].split("-")[1], _dtMtraject.split(" ")[1].split("-")[0], _dtMtraject.split(" ")[0].split(":")[0], _dtMtraject.split(" ")[0].split(":")[1], _dtMtraject.split(" ")[0].split(":")[2]);
        	var _dt = PathPerVeh[_j][vhID][0].style.VehID.substring(PathPerVeh[_j][vhID][0].style.VehID.lastIndexOf("<br />")+6, PathPerVeh[_j][vhID][0].style.VehID.length);
        	var _dt1 = new Date(_dt.split(" ")[1].split("-")[2], _dt.split(" ")[1].split("-")[1], _dt.split(" ")[1].split("-")[0], _dt.split(" ")[0].split(":")[0], _dt.split(" ")[0].split(":")[1], _dt.split(" ")[0].split(":")[2]);
        	var _dt2 = new Date(CarDT.split(" ")[1].split("-")[2], CarDT.split(" ")[1].split("-")[1], CarDT.split(" ")[1].split("-")[0], CarDT.split(" ")[0].split(":")[0], CarDT.split(" ")[0].split(":")[1], CarDT.split(" ")[0].split(":")[2]);
        	var dtdiff = get_time_difference(_dt1, _dt2);
			if((dtdiff.hours*60)+(dtdiff.minutes) >= traceForUser)
			{
				//if(_j == 1)
					//debugger;
            	vectors[_j].removeFeatures(PathPerVeh[_j][vhID][0]);
            	vectors[_j].removeFeatures(PathPerVehShadow[_j][vhID][0]);
            	PathPerVeh[_j][vhID][0] = "";
            	PathPerVeh[_j][vhID] = PathPerVeh[_j][vhID].splice(1, PathPerVeh[_j][vhID].length);
            	PathPerVehShadow[_j][vhID][0] = "";
            	PathPerVehShadow[_j][vhID] = PathPerVehShadow[_j][vhID].splice(1, PathPerVehShadow[_j][vhID].length);
            	if(_dtTraj <= _dt1)
            	{
            		Markers[_j].removeMarker(tmpMarkersTrajectory[_j][0]);
	            	tmpMarkersTrajectory[_j][0] = "";
	            	tmpMarkersTrajectory[_j] = tmpMarkersTrajectory[_j].splice(1, tmpMarkersTrajectory[_j].length);
            	}
        	} else
        	{
        		boolCheck = false;
        	}
        }
        
        
        //}
        //if (true)
        //    get10Points();
        HideWait();
        return
    }
}

function get10Points(vhID, VehReg) {
    $.ajax({
        url: "getVehPath.php?numofveh=" + vhID,
        context: document.body,
        success: function (data) {
        	HideWait();
            //ClearGraphic();
            //var d = JXG.decompress(data).split("#");
            data = data.replace(/\r/g,'').replace(/\n/g,'');
            var dLL = data.split("#");
            DrawPath(dLL[1], dLL[0], vhID, VehReg);
            
        }
    });
}
function DrawPath(LonArray, LatArray, vhID, VehReg) {
    //if (LastPointsLon != "") return false;

    if (ShowHideTrajectory==false) {return}
	
	var _lon = LonArray.split(",")
	var _lat = LatArray.split(",")
	
	var points = new Array();
	var styles = new Array();
	var cir = _lon.length / 3
	var cir1 = cir + cir
	var cir2 = _lon.length
	
	for (var z = 0; z < Maps.length; z++) {
	    for (var j = 0; j < Vehicles.length; j++) {
	        if (Vehicles[j].ID == vhID) {
	            if (Vehicles[j].Color == 'Red') { return }
	            var lonLat = new OpenLayers.LonLat(Vehicles[j].Marker.lonlat.lon, Vehicles[j].Marker.lonlat.lat).transform(Maps[z].getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
	            point = new OpenLayers.Geometry.Point(lonLat.lon, lonLat.lat);
	            point.transform(
				new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
				Maps[z].getProjectionObject() // to Spherical Mercator Projection
			);
	            styles.push({ 'strokeWidth': 3, 'strokeColor': '#0000FF', 'strokeOpacity': '1', 'VehID': dic("Number", lang) + ' ' + vhID +'<br />' + VehReg });
	            points.push(point)
	        }
	    }

	    var debelina = 3
	    var opac = 0.7

//	    for (i in _lon) {
//	        if (i > 0) {
//	            point = new OpenLayers.Geometry.Point(_lon[i], _lat[i]);
//	            point.transform(
//				    new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
//				    Maps[z].getProjectionObject() // to Spherical Mercator Projection
//			    );
//	            styles.push({ 'strokeWidth': '3', 'strokeColor': '#0000FF', 'strokeOpacity': '1' });
//	            points.push(point);
//	            //debelina = debelina - 0.5
//	            //opac = opac - 0.05
//	        }
//	    }
	    //document.getElementById("testText").value = LastPointsLon[vhID] + " | " + _lon[1];
        LastPointsLon[z][vhID] = _lon[1];
	    LastPointsLat[z][vhID] = _lat[1];

	    for (var i = 1; i < _lon.length - 1; i++) {
	        //DrawLine_Path(_lon[i], _lat[i], _lon[i + 1], _lat[i + 1]);
	        point = new OpenLayers.Geometry.Point(_lon[i], _lat[i]);
	        point.transform(
				    new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
				    Maps[z].getProjectionObject() // to Spherical Mercator Projection
			    );
	        styles.push({ 'strokeWidth': '3', 'strokeColor': '#0000FF', 'strokeOpacity': '1', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg });
	        points.push(point);
	        
	        var lineString1 = new OpenLayers.Geometry.LineString([points[i - 1], points[i]]);
	        var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, styles[i - 1])
	        vectors[z].addFeatures([lineFeature1]);
	        PathPerVeh[vhID][PathPerVeh[vhID].length] = lineFeature1;
	        //PathPerVeh[vhID][PathPerVeh[vhID].length] = lineFeature1;

	        lineFeature1.layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>" + dic("RouteForV", lang) + "<br /></strong>'+event.target._style.VehID)}");
	        lineFeature1.layer.events.element.setAttribute("onmouseout", "HidePopup()");
	    }
	}
	
	return
}

function get10Points1(vhID, VehReg, _val) {
    $.ajax({
        url: "getVehPath.php?numofveh=" + vhID + "&valtraj=" + _val,
        context: document.body,
        success: function (data) {
        	HideWait();
            data = data.replace(/\r/g,'').replace(/\n/g,'');
            var dLL = data.split("#");
			DrawPath1(dLL[1], dLL[0], dLL[2], dLL[3], dLL[4], vhID, VehReg);
        }
    });
}
function DrawPath1(LonArray, LatArray, DistArray, dtArray, alphaArray, vhID, VehReg) {
    if (ShowHideTrajectory==false) {return}
	
	var _lon = LonArray.split(",")
	var _lat = LatArray.split(",")

	var points = new Array();
	var styles =  new Array();
	var styles1 =  new Array(); //{'strokeWidth': '4', 'strokeColor': '#0000FF', 'strokeOpacity': '0.8', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg + '<br />' +  };
	//var styles = {'strokeWidth': '4', 'strokeColor': '#2AAEDE', 'strokeOpacity': '0.9', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg };
	//var stylesShadow = {'strokeWidth': '6', 'strokeColor': '#000000', 'strokeOpacity': '0.5' };
	var cir = _lon.length / 3
	var cir1 = cir + cir
	var cir2 = _lon.length
	var numA = 0;
	
	for (var z = 0; z < Maps.length; z++) {
		if(Maps[z] != null)
		{
			//var num2 = Math.abs(18 - Maps[z].getZoom());
			var num2 = podatok[Maps[z].getZoom()]; //Math.abs(19 - Maps[z].getZoom()) + Math.abs(18 - Maps[z].getZoom()) + Math.abs(18 - Maps[z].getZoom()) + Math.abs(18 - Maps[z].getZoom());
		    point = new OpenLayers.Geometry.Point(_lon[1], _lat[1]);
	        point.transform(
			    new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
			    Maps[z].getProjectionObject() // to Spherical Mercator Projection
		    );
	        styles.push({ 'strokeWidth': '4', 'strokeColor': '#2AAEDE', 'strokeOpacity': '0.9', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg + '<br />' + dtArray.split(",")[1] });
	        styles1.push({ 'strokeWidth': '6', 'strokeColor': '#000000', 'strokeOpacity': '0.5', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg + '<br />' + dtArray.split(",")[1] });
	        points.push(point);
	
			LastPointsLon[z][vhID] = _lon[_lon.length-1];
		    LastPointsLat[z][vhID] = _lat[_lat.length-1];
		    var _numpoints = 2;
		    for (var i = 2; i < _lon.length - 1; i++) {
		    	if((parseFloat(DistArray.split(",")[i]) < 2500))
				{
			        point = new OpenLayers.Geometry.Point(_lon[i], _lat[i]);
			        point.transform(
					    new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
					    Maps[z].getProjectionObject() // to Spherical Mercator Projection
				    );
			        styles.push({ 'strokeWidth': '4', 'strokeColor': '#2AAEDE', 'strokeOpacity': '0.9', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg + '<br />' + dtArray.split(",")[i] });
			        styles1.push({ 'strokeWidth': '6', 'strokeColor': '#000000', 'strokeOpacity': '0.5', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg + '<br />' + dtArray.split(",")[i] });
			        points.push(point);
			        if(points[_numpoints - 1] != undefined)
			        {
			        	var lineString1 = new OpenLayers.Geometry.LineString([points[_numpoints - 2], points[_numpoints - 1]]);
				        var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, styles[_numpoints - 2]);
				        var lineString2 = new OpenLayers.Geometry.LineString([points[_numpoints - 2], points[_numpoints - 1]]);
				        var lineFeature2 = new OpenLayers.Feature.Vector(lineString2, null, styles1[_numpoints - 2]);
				        vectors[z].addFeatures([lineFeature2]);
				        vectors[z].addFeatures([lineFeature1]);
				        PathPerVeh[z][vhID][PathPerVeh[z][vhID].length] = lineFeature1;
				        PathPerVehShadow[z][vhID][PathPerVehShadow[z][vhID].length] = lineFeature2;
				        lineFeature1.layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>" + dic("RouteForV", lang) + "<br /></strong>'+event.target._style.VehID)}");
				        lineFeature1.layer.events.element.setAttribute("onmouseout", "HidePopup()");
				        lineFeature2.layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>" + dic("RouteForV", lang) + "<br /></strong>'+event.target._style.VehID)}");
				        lineFeature2.layer.events.element.setAttribute("onmouseout", "HidePopup()");
			       	}
				    if(numA == 3)
	    			{
	    				drawDirection(z, _lon[i], _lat[i], vhID, VehReg, dtArray.split(",")[i], alphaArray.split(",")[i], num2);
	    				num2--;
	    				if(num2 == 0)
	    					num2 = podatok[Maps[z].getZoom()]; //Math.abs(19 - Maps[z].getZoom()) + Math.abs(18 - Maps[z].getZoom()) + Math.abs(18 - Maps[z].getZoom()) + Math.abs(18 - Maps[z].getZoom());
	    					//num2 = Math.abs(18 - Maps[z].getZoom());
	    				numA = 0;
				    } else
					{
				    	numA++;
				    }
				} else {
			        var points = new Array();
					var styles = new Array();
					_numpoints = 0;
		       }
		       _numpoints++;
		    }
		    for (var j = 0; j < Car.length; j++) {
		        if (Car[j].id == vhID) {
		            point = new OpenLayers.Geometry.Point(Car[j].lon, Car[j].lat);
		            point.transform(
						new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
						Maps[z].getProjectionObject() // to Spherical Mercator Projection
					);
		            styles.push({ 'strokeWidth': '4', 'strokeColor': '#2AAEDE', 'strokeOpacity': '0.9', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg + '<br />' + Car[j].datum.split(" ")[1] + " " + Car[j].datum.split(" ")[0] });
		            styles1.push({ 'strokeWidth': '6', 'strokeColor': '#000000', 'strokeOpacity': '0.5', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg + '<br />' + Car[j].datum.split(" ")[1] + " " + Car[j].datum.split(" ")[0] });
		            points.push(point);
		            var lineString1 = new OpenLayers.Geometry.LineString([points[i - 2], points[i - 1]]);
			        var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, styles[i - 2]);
			        var lineString2 = new OpenLayers.Geometry.LineString([points[i - 2], points[i - 1]]);
			        var lineFeature2 = new OpenLayers.Feature.Vector(lineString2, null, styles1[i - 2]);
			        vectors[z].addFeatures([lineFeature2]);
			        vectors[z].addFeatures([lineFeature1]);
			        PathPerVeh[z][vhID][PathPerVeh[z][vhID].length] = lineFeature1;
			        PathPerVehShadow[z][vhID][PathPerVehShadow[z][vhID].length] = lineFeature2;

			        lineFeature1.layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>" + dic("RouteForV", lang) + "<br /></strong>'+event.target._style.VehID)}");
			        lineFeature1.layer.events.element.setAttribute("onmouseout", "HidePopup()");
			        lineFeature2.layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>" + dic("RouteForV", lang) + "<br /></strong>'+event.target._style.VehID)}");
			        lineFeature2.layer.events.element.setAttribute("onmouseout", "HidePopup()");
		        }
		    }
		}
	}
	
	return
}
function drawDirectionLive(z, _lon, _lat, _vhID, _VehReg, _dtTrajec, _alphaA, _i)
{
	var size = new OpenLayers.Size(16, 16);
    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -(size.h / 2)); };
    var iconAlpha = "sDesno";
    if(parseInt(_alphaA, 10) >= 22 && parseInt(_alphaA, 10) < 67)
    	iconAlpha = "sDesnoGore";
	else
		if(parseInt(_alphaA, 10) >= 67 && parseInt(_alphaA, 10) < 112)
    		iconAlpha = "sGore";
		else
    		if(parseInt(_alphaA, 10) >= 112 && parseInt(_alphaA, 10) < 157)
    			iconAlpha = "sLevoGore";
			else
	    		if(parseInt(_alphaA, 10) >= 157 && parseInt(_alphaA, 10) < 202)
	    			iconAlpha = "sLevo";
    			else
	    			if(parseInt(_alphaA, 10) >= 202 && parseInt(_alphaA, 10) < 247)
	    				iconAlpha = "sLevoDolu";
    				else
		    			if(parseInt(_alphaA, 10) >= 247 && parseInt(_alphaA, 10) < 292)
		    				iconAlpha = "sDole";
	    				else
		    				if(parseInt(_alphaA, 10) >= 292 && parseInt(_alphaA, 10) < 337)
		    					iconAlpha = "sDesnoDolu";
	    					else
		    					if(parseInt(_alphaA, 10) >= 337 && parseInt(_alphaA, 10) < 22)
		    						iconAlpha = "sDesno";
    var icon = new OpenLayers.Icon(twopoint + '/images/' + iconAlpha + '.png', size, null, calculateOffset);
    if (Maps[z] != null) {
        var ll = new OpenLayers.LonLat(parseFloat(_lon), parseFloat(_lat)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[z].getProjectionObject())
        //if (MapType[0] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
        var MyMar = new OpenLayers.Marker(ll, icon);
        var markers = Markers[z];
        markers.addMarker(MyMar);
        MyMar.events.element.style.zIndex = 666;
        tmpMarkersTrajectory[z][tmpMarkersTrajectory[z].length] = MyMar;
        if(Vehicles[_i].trajec == 1)
        	tmpMarkersTrajectory[z][tmpMarkersTrajectory[z].length-1].display(true);
    	else
    		tmpMarkersTrajectory[z][tmpMarkersTrajectory[z].length-1].display(false);
		Vehicles[_i].trajec--;
		if(Vehicles[_i].trajec == 0)
			Vehicles[_i].trajec = podatok[Maps[z].getZoom()];

        //tmpMarkersTrajectory[tmpMarkersTrajectory.length - 1].events.element.innerHTML = '<div class="gnPOI" style="background-color: ' + _color + '"; display:box; font-size:4px"></div>';
        //tmpMarkersTrajectory[tmpMarkersTrajectory.length - 1].events.element.style.cursor = 'pointer';
        tmpMarkersTrajectory[z][tmpMarkersTrajectory[z].length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong >" + dic("Number", lang) + ' ' + _vhID + '<br />' + _VehReg + '<br />' + _dtTrajec + "</strong>')");
        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong >" + defDT + "</strong>')");
        $(tmpMarkersTrajectory[z][tmpMarkersTrajectory[z].length - 1].events.element).mouseout(function () { HidePopup() });
        //tmpMarkersTrajectory[tmpMarkersTrajectory.length - 1].events.element.addEventListener('click', function (e) { AddPOI = true; VehClick = true; });
    }
}
function drawDirection(z, _lon, _lat, _vhID, _VehReg, _dtTrajec, _alphaA, _zoom)
{
	var size = new OpenLayers.Size(16, 16);
    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -(size.h / 2)); };
    var iconAlpha = "sDesno";
    if(parseInt(_alphaA, 10) >= 22 && parseInt(_alphaA, 10) < 67)
    	iconAlpha = "sDesnoGore";
	else
		if(parseInt(_alphaA, 10) >= 67 && parseInt(_alphaA, 10) < 112)
    		iconAlpha = "sGore";
		else
    		if(parseInt(_alphaA, 10) >= 112 && parseInt(_alphaA, 10) < 157)
    			iconAlpha = "sLevoGore";
			else
	    		if(parseInt(_alphaA, 10) >= 157 && parseInt(_alphaA, 10) < 202)
	    			iconAlpha = "sLevo";
    			else
	    			if(parseInt(_alphaA, 10) >= 202 && parseInt(_alphaA, 10) < 247)
	    				iconAlpha = "sLevoDolu";
    				else
		    			if(parseInt(_alphaA, 10) >= 247 && parseInt(_alphaA, 10) < 292)
		    				iconAlpha = "sDole";
	    				else
		    				if(parseInt(_alphaA, 10) >= 292 && parseInt(_alphaA, 10) < 337)
		    					iconAlpha = "sDesnoDolu";
	    					else
		    					if(parseInt(_alphaA, 10) >= 337 && parseInt(_alphaA, 10) < 22)
		    						iconAlpha = "sDesno";
    var icon = new OpenLayers.Icon(twopoint + '/images/' + iconAlpha + '.png', size, null, calculateOffset);
    if (Maps[z] != null) {
        var ll = new OpenLayers.LonLat(parseFloat(_lon), parseFloat(_lat)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[z].getProjectionObject())
        //if (MapType[0] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
        var MyMar = new OpenLayers.Marker(ll, icon);
        var markers = Markers[z];
        markers.addMarker(MyMar);
        MyMar.events.element.style.zIndex = 666;
        tmpMarkersTrajectory[z][tmpMarkersTrajectory[z].length] = MyMar;
        if(_zoom == 1)
        	tmpMarkersTrajectory[z][tmpMarkersTrajectory[z].length-1].display(true);
    	else
    		tmpMarkersTrajectory[z][tmpMarkersTrajectory[z].length-1].display(false);
        //tmpMarkersTrajectory[tmpMarkersTrajectory.length - 1].events.element.innerHTML = '<div class="gnPOI" style="background-color: ' + _color + '"; display:box; font-size:4px"></div>';
        //tmpMarkersTrajectory[tmpMarkersTrajectory.length - 1].events.element.style.cursor = 'pointer';
        tmpMarkersTrajectory[z][tmpMarkersTrajectory[z].length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong >" + dic("Number", lang) + ' ' + _vhID + '<br />' + _VehReg + '<br />' + _dtTrajec + "</strong>')");
        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong >" + defDT + "</strong>')");
        $(tmpMarkersTrajectory[z][tmpMarkersTrajectory[z].length - 1].events.element).mouseout(function () { HidePopup() });
        //tmpMarkersTrajectory[tmpMarkersTrajectory.length - 1].events.element.addEventListener('click', function (e) { AddPOI = true; VehClick = true; });
    }
}
function DrawLine_Path(_lon2, _lat2, _lon1, _lat1) {
    $.ajax({
        url: "getLinePoints.aspx?lon1=" + _lon2 + "&lat1=" + _lat2 + "&lon2=" + _lon1 + "&lat2=" + _lat1,
        context: document.body,
        success: function (data) {
            var _lon = new Array();
            var _lat = new Array();
            _lon[0] = _lon2;
            _lat[0] = _lat2;
            var i = 1;
            while (data.indexOf("</lng>") != -1) {
                _lon[i] = data.substring(data.indexOf("<lng>") + 5, data.indexOf("</lng>"));
                _lat[i] = data.substring(data.indexOf("<lat>") + 5, data.indexOf("</lat>"));
                i++;
                data = data.substring(data.indexOf("</lng>") + 5, data.length);
            }
            _lon[i] = _lon1;
            _lat[i] = _lat1;
            var points = new Array();
            var styles = new Array();
            var debelina = 3;
            var opac = 0.7;
            for (var _j = 0; _j < _lon.length; _j++) {
                point = new OpenLayers.Geometry.Point(_lon[_j], _lat[_j]);
                point.transform(
			            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
			            Maps[0].getProjectionObject() // to Spherical Mercator Projection
		            );
                styles.push({ 'strokeWidth': debelina, 'strokeColor': '#0000FF', 'strokeOpacity': opac });
                points.push(point);
            }
            for (var i = 1; i < points.length - 2; i++) {
                var lineString1 = new OpenLayers.Geometry.LineString([points[i], points[i + 1]]);
                var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, styles[i]);
                vectors[0].addFeatures([lineFeature1]);
            }
        }
    });
}


function DrawPath_RecTMP(_lon2, _lat2, _lon1, _lat1) {
    //alert(_lon2 + "  |  " + _lat2 + "  |  " + _lon1 + "  |  " + _lat1 + "  |  " + _ordNum + "  |  " + _name + "  |  " + _file + "  |  " + _len);
    //alert(_file + ".php?lon1=" + _lon2 + "&lat1=" + _lat2 + "&lon2=" + _lon1 + "&lat2=" + _lat1 + "&len=" + _len);
    //return false;
    $.ajax({
        url: "getLinePointsF1.php?lon1=" + _lon2 + "&lat1=" + _lat2 + "&lon2=" + _lon1 + "&lat2=" + _lat1,
        context: document.body,
        success: function (data) {
        	data = data.replace(/\r/g,'').replace(/\n/g,'');
            //var datTemp = data.substring(data.indexOf("route_geometry") + 18, data.indexOf("route_instructions") - 4).split("],[");
            var datTemp = data.split("%@");
            var _lon = new Array();
            var _lat = new Array();
            _lon[0] = _lon2;
            _lat[0] = _lat2;
            var ii = 1;
            for (var i = 1; i < datTemp.length; i++) {
                _lon[ii] = datTemp[i].split("#")[0];
                _lat[ii] = datTemp[i].split("#")[1];
                ii++;
            }
            _lon[ii] = _lon1;
            _lat[ii] = _lat1;

            var points = new Array();
            var styles = new Array();

            var debelina = 4;
            var opac = 0.7;
            var styles = {'strokeWidth': '4', 'strokeColor': '#0000FF', 'strokeOpacity': '0.8', 'strokeDashstyle': 'dot' };
            for (var _j = 0; _j < _lon.length; _j++) {
                point = new OpenLayers.Geometry.Point(_lon[_j], _lat[_j]);
                point.transform(
			            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
			            Maps[0].getProjectionObject() // to Spherical Mercator Projection
		            );
                //styles.push({ 'strokeWidth': debelina, 'strokeColor': '#0000FF', 'strokeOpacity': opac });
                points.push(point);
            }
            
			var lineString1 = new OpenLayers.Geometry.LineString(points);
    		var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, styles);
    		vectors[0].addFeatures([lineFeature1]);
    		
            //var lineString1 = new OpenLayers.Geometry.LineString([points[i], points[i + 1]]);
            //lineFeatureRoute[_ordNum][i] = new OpenLayers.Feature.Vector(lineString1, null, styles[i]);
            //vectors[0].addFeatures([lineFeatureRoute[_ordNum][i]]);
        }
    });
}

var ArrLineFeature;
function DrawPath_Rec(LonArray, LatArray, DistArray, DTArray, alphaArray, alarmsArray, idlingArray, DTArrayDiff, parkingArray, vhID, VehReg) {
    
    //if (ShowHideTrajectory == false) { return }
    var _lon = LonArray.split(",")
    var _lat = LatArray.split(",")

    var points = new Array();
    var styles = {'strokeWidth': '4', 'strokeColor': '#2AAEDE', 'strokeOpacity': '0.9', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg };
	var stylesShadow = {'strokeWidth': '6', 'strokeColor': '#000000', 'strokeOpacity': '0.5' };
    if (MapType[0] == 'YAHOOM') {
        // GLOBSY MAPS
		//Maps[0].setCenter(new OpenLayers.LonLat(_lon[0], _lat[0]), zl);
		Maps[0].setCenter(new OpenLayers.LonLat(_lon[0], _lat[0]).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject()), DefMapZoom);
    
    } else {
        Maps[0].setCenter(new OpenLayers.LonLat(_lon[0], _lat[0]).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject()), DefMapZoom);
    }

    var cir = _lon.length / 3
    var cir1 = cir + cir
    var cir2 = _lon.length

    var debelina = 6
    var opac = 0.7

    /*for (i in _lon) {
        if (i > 0 && i < _lon.length - 2) {

            point = new OpenLayers.Geometry.Point(_lon[i], _lat[i]);
            point.transform(
				new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
				Maps[0].getProjectionObject() // to Spherical Mercator Projection
			  );
            points.push(point);
        }
    }*/
	var numA = 0;
	var num2 = podatok[Maps[0].getZoom()]; //Math.abs(19 - Maps[0].getZoom()) + Math.abs(18 - Maps[0].getZoom()) + Math.abs(18 - Maps[0].getZoom()) + Math.abs(18 - Maps[0].getZoom());
	for (var _j = 0; _j < _lon.length; _j++) {
		//if(parseInt(DistArray.split(",")[_j], 10) > 1500)
///			debugger; ((parseInt(diffDTArray.split(",")[_j], 10) * 40) < 6000) || 
		if((parseFloat(DistArray.split(",")[_j]) < 2500))
		{
	        var defDT = DTArray.split(",")[_j];
	        defDT = defDT.split(" ")[1].split(".")[0] + " " + defDT.split(" ")[0].split("-")[2] + "-" + defDT.split(" ")[0].split("-")[1] + "-" + defDT.split(" ")[0].split("-")[0];
	        point = new OpenLayers.Geometry.Point(_lon[_j], _lat[_j]);
	    		point.transform(
	            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
	            Maps[0].getProjectionObject() // to Spherical Mercator Projection
	        );
	        //styles.push({ 'strokeWidth': debelina, 'strokeColor': '#0000FF', 'strokeOpacity': opac });
	        points.push(point);
	        
	        if(numA == 3)
	        {
	        	if(parseInt(DistArray.split(",")[_j], 10) > 300)
	        		num2 = 1;
	        	drawDirection(0, _lon[_j], _lat[_j], vhID, VehReg, defDT, alphaArray.split(",")[_j], num2);
	        	num2--;
				if(num2 == 0)
					num2 = podatok[Maps[0].getZoom()]; //Math.abs(19 - Maps[0].getZoom()) + Math.abs(18 - Maps[0].getZoom()) + Math.abs(18 - Maps[0].getZoom()) + Math.abs(18 - Maps[0].getZoom());
	        	numA = 0;
	        } else
        	{
	        	numA++;
	        }
	        if(alarmsArray.split(",")[_j] != "")
	        {
	        	var size = new OpenLayers.Size(25, 23);
			    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -(size.h / 2)); };
		        var icon = new OpenLayers.Icon(twopoint + '/images/alarm1.png', size, null, calculateOffset);
			    if (Maps[0] != null) {
			        var ll = new OpenLayers.LonLat(parseFloat(_lon[_j]), parseFloat(_lat[_j])).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject())
			        //if (MapType[0] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
			        var MyMar = new OpenLayers.Marker(ll, icon);
			        var markers = Markers[0];
			        markers.addMarker(MyMar);
			        MyMar.events.element.style.zIndex = 999
			        tmpMarkersRec[tmpMarkersRec.length] = MyMar;
			        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.innerHTML = '<div class="gnPOI" style="background-color: ' + _color + '"; display:box; font-size:4px"></div>';
			        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.style.cursor = 'pointer';
			        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong >Аларм: " + dic(alarmsArray.split(",")[_j], lang) + "<br/ >" + defDT + "</strong>')");
			        $(tmpMarkersRec[tmpMarkersRec.length - 1].events.element).mouseout(function () { HidePopup() });
			        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.addEventListener('click', function (e) { OpenMapAlarm2(DTArray.split(",")[_j], VehReg, alarmsArray.split(",")[_j], $vh, '1'); });
			        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onclick", "OpenMapAlarm2('" + DTArray.split(",")[_j] + "', '" + VehReg + "', '" + alarmsArray.split(",")[_j] + "', " + $vh + ", '1')");
		       }
	        }
	        //debugger;
	        if(parkingArray.split(",")[_j] != "" && idlingArray.split(",")[_j] != "")
	        {
	        	if(parkingArray.split(",")[_j].split("|")[0].indexOf(".") == -1)
	        		var parkingDT1 = parkingArray.split(",")[_j].split("|")[0] + ".001";
        		else
        			var parkingDT1 = parkingArray.split(",")[_j].split("|")[0];
        		if(parkingArray.split(",")[_j].split("|")[1].indexOf(".") == -1)
        			var parkingDT2 = parkingArray.split(",")[_j].split("|")[1] + ".001"; //.substring(0,parkingArray.split(",")[_j].split("|")[1].indexOf(".")))
    			else
    				var parkingDT2 = parkingArray.split(",")[_j].split("|")[1];
				if(DTArrayDiff.split(",")[_j].indexOf(".") == -1)
        			var parkingDT3 = DTArrayDiff.split(",")[_j] + ".001"; //.substring(0,parkingArray.split(",")[_j].split("|")[1].indexOf(".")))
    			else
    				var parkingDT3 = DTArrayDiff.split(",")[_j];
	        	CreateMarkerIgnition_RecNew(_lon[_j], _lat[_j], parkingDT1.substring(0,parkingDT1.indexOf(".")), parkingDT2.substring(0,parkingDT2.indexOf(".")), parkingDT3.substring(0,parkingDT3.indexOf(".")));
	        } else
        	{
	        	if(idlingArray.split(",")[_j] != "")
		        {
		        	var defDTDiff = DTArrayDiff.split(",")[_j];
		        	defDTDiff = defDTDiff.split(" ")[1].split(".")[0] + " " + defDTDiff.split(" ")[0].split("-")[2] + "-" + defDTDiff.split(" ")[0].split("-")[1] + "-" + defDTDiff.split(" ")[0].split("-")[0];
		        	var size = new OpenLayers.Size(48, 48);
				    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2) - 1, -size.h + 3 ); };
			        var icon = new OpenLayers.Icon(twopoint + '/images/idle1.png', size, null, calculateOffset);
				    if (Maps[0] != null) {
				        var ll = new OpenLayers.LonLat(parseFloat(_lon[_j]), parseFloat(_lat[_j])).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject())
				        //if (MapType[0] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
				        var MyMar = new OpenLayers.Marker(ll, icon);
				        var markers = Markers[0];
				        markers.addMarker(MyMar);
				        MyMar.events.element.style.zIndex = 999
				        tmpMarkersRec[tmpMarkersRec.length] = MyMar;
				        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.innerHTML = '<div class="gnPOI" style="background-color: ' + _color + '"; display:box; font-size:4px"></div>';
				        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.style.cursor = 'pointer';
				        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 12px;\">" + dic("STOS", lang) + ": " + defDT + "<br />" + dic("ETOS", lang) + ": " + defDTDiff + "<br />" + dic("TTOS", lang) + " " + dic("Reports.WithIgnOn", lang) + ": " + Sec2Str(idlingArray.split(",")[_j]) + "</strong>')");
				        $(tmpMarkersRec[tmpMarkersRec.length - 1].events.element).mouseout(function () { HidePopup() });
				        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.addEventListener('click', function (e) { OpenMapAlarm2(DTArray.split(",")[_j], VehReg, alarmsArray.split(",")[_j], $vh, '1'); });
				        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onclick", "OpenMapAlarm2('" + DTArray.split(",")[_j] + "', '" + VehReg + "', '" + alarmsArray.split(",")[_j] + "', " + $vh + ", '1')");
			       }
		        }
		        if(parkingArray.split(",")[_j] != "")
		        {
		        	if(parkingArray.split(",")[_j].split("|")[0].indexOf(".") == -1)
		        		var parkingDT1 = parkingArray.split(",")[_j].split("|")[0] + ".001";
	        		else
	        			var parkingDT1 = parkingArray.split(",")[_j].split("|")[0];
	        		if(parkingArray.split(",")[_j].split("|")[1].indexOf(".") == -1)
	        			var parkingDT2 = parkingArray.split(",")[_j].split("|")[1] + ".001"; //.substring(0,parkingArray.split(",")[_j].split("|")[1].indexOf(".")))
        			else
        				var parkingDT2 = parkingArray.split(",")[_j].split("|")[1];
		        	CreateMarkerIgnition_Rec(_lon[_j], _lat[_j], parkingDT1.substring(0,parkingDT1.indexOf(".")), parkingDT2.substring(0,parkingDT2.indexOf(".")));
		        }
	        }
		} else
		{
      		var lineString1 = new OpenLayers.Geometry.LineString(points);
      		var lineString2 = new OpenLayers.Geometry.LineString(points);
    		var lineFeature2 = new OpenLayers.Feature.Vector(lineString2, null, styles);
    		var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, stylesShadow);
    		
    		//ArrLineFeature += lineFeature1;
    		vectors[0].addFeatures([lineFeature1]);
    		vectors[0].addFeatures([lineFeature2]);
    		var points = new Array();
    		//DrawPath_RecTMP(21.111231, 44.255282, 21.055183, 44.428877);
    		//DrawPath_RecTMP(_lon[_j], _lat[_j], _lon[_j+1], _lat[_j+1]);
		}
		if(_j == (_lon.length-1))
		{
			var lineString1 = new OpenLayers.Geometry.LineString(points);
      		var lineString2 = new OpenLayers.Geometry.LineString(points);
    		var lineFeature2 = new OpenLayers.Feature.Vector(lineString2, null, styles);
    		var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, stylesShadow);
    		
    		//ArrLineFeature += lineFeature1;
    		vectors[0].addFeatures([lineFeature1]);
    		vectors[0].addFeatures([lineFeature2]);
		}
    }
    ArrLineFeature = vectors[0].features;
    /*for (var i = 1; i < points.length - 2; i++) {
        var lineString1 = new OpenLayers.Geometry.LineString([points[i], points[i + 1]]);
        var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, styles[i]);
        vectors[0].addFeatures([lineFeature1]);

    var lineString1 = new OpenLayers.Geometry.LineString(points);
    var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, styles)
	
    vectors[0].addFeatures([lineFeature1]);*/
	//vectors[0].setZIndex( 23 );
    //ArrLineFeature = lineFeature1;
    return
}
function CreateMarkerIgnition_RecNew(_lonn, _latt, _date, _date1, _date2) {
	//_date + _date1 Parking
	//_date + _date2 Idl
    var size = new OpenLayers.Size(64, 48);
    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2) - 1, -size.h + 3 ); };
    var icon = new OpenLayers.Icon(twopoint + '/images/ParkingIdling1.png', size, null, calculateOffset);
    if (Maps[0] != null) {
        var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject());
        
        if(Browser() == "Chrome")
        {
        	var _dt = _date.split(/\-|\s/);
        	var _dt1 = new Date(_dt.slice(0, 3).join('-') + ' ' + _dt[3]);
        	var _dtT = _date1.split(/\-|\s/);
        	var _dtT1 = new Date(_dtT.slice(0, 3).join('-') + ' ' + _dtT[3]);
        	var _diffDT = get_time_difference(_dtT1, _dt1);
        	var _dtT2 = _date2.split(/\-|\s/);
        	var _dtT3 = new Date(_dtT2.slice(0, 3).join('-') + ' ' + _dtT2[3]);
        	var _diffDT1 = get_time_difference(_dt1, _dtT3);
    	} else
    	{
    		if(Browser() == "Safari")
    		{
    			var _dt = _date.split(/\-|\s/);
        		var _dt1 = new Date(parseInt(_dt[0], 10), parseInt(_dt[1], 10), parseInt(_dt[2], 10), parseInt(_dt[3].split(":")[0], 10), parseInt(_dt[3].split(":")[1], 10), parseInt(_dt[3].split(":")[2], 10));
        		var _dtT = _date1.split(/\-|\s/);
        		var _dtT1 = new Date(parseInt(_dtT[0], 10), parseInt(_dtT[1], 10), parseInt(_dtT[2], 10), parseInt(_dtT[3].split(":")[0], 10), parseInt(_dtT[3].split(":")[1], 10), parseInt(_dtT[3].split(":")[2], 10));
        		var _diffDT = get_time_difference(_dtT1, _dt1);
        		var _dtT2 = _date2.split(/\-|\s/);
        		var _dtT3 = new Date(parseInt(_dtT2[0], 10), parseInt(_dtT2[1], 10), parseInt(_dtT2[2], 10), parseInt(_dtT2[3].split(":")[0], 10), parseInt(_dtT2[3].split(":")[1], 10), parseInt(_dtT2[3].split(":")[2], 10));
        		var _diffDT1 = get_time_difference(_dt1, _dtT3);
    		} else
    		{
    			var _dt = _date.split(/\-|\s/);
        		var _dt1 = new Date(_dt.slice(0, 3).reverse().join('/') + ' ' + _dt[3]);
        		var _dtT = _date1.split(/\-|\s/);
        		var _dtT1 = new Date(_dtT.slice(0, 3).reverse().join('/') + ' ' + _dtT[3]);
        		var _diffDT = get_time_difference(_dtT1, _dt1);
        		var _dtT2 = _date2.split(/\-|\s/);
        		var _dtT3 = new Date(_dtT2.slice(0, 3).reverse().join('/') + ' ' + _dtT2[3]);
        		var _diffDT1 = get_time_difference(_dt1, _dtT3);
        	}
    	}
        if (_diffDT.days == 0 && _diffDT.hours == 0 && _diffDT.minutes == 0)
            var _zero = " < " + _MinMin + " min";
        else
            var _zero = "";
        if (_diffDT1.days == 0 && _diffDT1.hours == 0 && _diffDT1.minutes == 0)
            var _zero1 = " < " + _MinMin + " min";
        else
            var _zero1 = "";
        var _NewCreateDateTime = _dt[3].split(":")[0] + ":" + _dt[3].split(":")[1] + " " + _dt[2] + "-" + _dt[1] + "-" + _dt[0];
    	var _NewCreateDateTime1 = _dtT[3].split(":")[0] + ":" + _dtT[3].split(":")[1] + " " + _dtT[2] + "-" + _dtT[1] + "-" + _dtT[0];
    	var _NewCreateDateTime2 = _dtT2[3].split(":")[0] + ":" + _dtT2[3].split(":")[1] + " " + _dtT2[2] + "-" + _dtT2[1] + "-" + _dtT2[0];
        
        var lonLatMarker = new OpenLayers.LonLat(_lonn, _latt).transform(Maps[0].displayProjection, Maps[0].projection);
        var feature = new OpenLayers.Feature(markers, lonLatMarker);
        //if (MapType[0] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
        var MyMar = new OpenLayers.Marker(ll, icon)
        var markers = Markers[0];
        var markerClick = function (evt) {
            if (this.popup == null) {
                var popup = new OpenLayers.Popup.FramedCloud("Popup",
                    lonLatMarker,
                    new OpenLayers.Size(185, 33),
                //"<div class='text1' style='overflow: hidden; font-size:.8em; position: absolute; top: -1px;'><strong style='font-size: 12px;'>Почеток: " + _date1 + "<br />Крај: " + _date + "<br />Вкупно стоење: " + (_diffDT.days != 0 ? (_diffDT.days + " days") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " m") : "") + " " + (_diffDT.seconds != 0 ? (_diffDT.seconds + " s") : "") + "</strong></div>", null, true);
                    "<div class='text1' style='overflow: hidden; font-size:.8em; position: relative; left: -2px; top: -8px; width: 125px; height: 135px; margin-right: -15px; margin-bottom: -22px;'><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"" + dic("STOS", lang) + "\")' onmouseout='HidePopup()' src='"+twopoint+"/images/startRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime1 + "<br /><img onmousemove='ShowPopup(event, \"" + dic("ETOS", lang) + "\")' onmouseout='HidePopup()' src='"+twopoint + "/images/endRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime + "<br /><img onmousemove='ShowPopup(event, \"" + dic("TTOS", lang) + " со исклучен мотор\")' onmouseout='HidePopup()' src='"+twopoint + "/images/sum1.png' style='height: 16px; width: 16px; position: relative; top: 4px;' />: " + _zero + (_diffDT.days != 0 ? (_diffDT.days + " day(s)") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " min") : "") + "</strong><br/><br/><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"" + dic("STOS", lang) + "\")' onmouseout='HidePopup()' src='"+twopoint + "/images/startRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime + "<br /><img onmousemove='ShowPopup(event, \"" + dic("ETOS", lang) + "\")' onmouseout='HidePopup()' src='"+twopoint + "/images/endRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime2 + "<br /><img onmousemove='ShowPopup(event, \"" + dic("TTOS", lang) + " со вклучен мотор\")' onmouseout='HidePopup()' src='"+twopoint + "/images/sum1.png' style='height: 16px; width: 16px; position: relative; top: 4px;' />: " + _zero1 + (_diffDT1.days != 0 ? (_diffDT1.days + " day(s)") : "") + " " + (_diffDT1.hours != 0 ? (_diffDT1.hours + " h") : "") + " " + (_diffDT1.minutes != 0 ? (_diffDT1.minutes + " min") : "") + "</strong></div>", null, true);
                this.popup = popup;
                this.popup.contentDiv.style.overflow = 'hidden';
                map.addPopup(this.popup);
                this.popup.div.style.opacity = '0.7';
                this.popup.div.setAttribute("onmousemove", "MouseOverPopup(this)");
                this.popup.div.setAttribute("onmouseout", "MouseEndPopup(this)");
                this.popup.show();
            } else {
                this.popup.toggle();
            }
            OpenLayers.Event.stop(evt);
        };
        if (parseInt(_diffDT.minutes, 10) > parseInt(_MinMin, 10) || parseInt(_diffDT1.minutes, 10) > parseInt(_MinMin, 10)) {
            MyMar.events.register("mousedown", feature, markerClick);
        }
        markers.addMarker(MyMar);
        MyMar.events.element.style.zIndex = 999;
        tmpMarkersRec[tmpMarkersRec.length] = MyMar;
        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.innerHTML = '<div class="gnPOI" style="background-color: #ff0000"; display:box; font-size:4px"></div>';
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.style.cursor = 'pointer';
        var popup = new OpenLayers.Popup.FramedCloud("Popup",
                lonLatMarker,
                new OpenLayers.Size(500, 500),
                //"<div class='text1' style='overflow: hidden; font-size:.8em; position: relative; left: -2px; top: -8px; width: 107px; height: 70px; margin-right: -10px; margin-bottom: -20px;'><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"Почетно време на застанување\")' onmouseout='HidePopup()' src='../images/startRec.png' style='height: 20px; width: 19px; position: relative; top: 5px;' />: " + _NewCreateDateTime1 + "<br /><img onmousemove='ShowPopup(event, \"Крајно време на застанување\")' onmouseout='HidePopup()' src='../images/endRec.png' style='height: 20px; width: 19px; position: relative; top: 5px;' />: " + _NewCreateDateTime + "<br /><img onmousemove='ShowPopup(event, \"Вкупно време на стоење\")' onmouseout='HidePopup()' src='../images/sum1.png' style='height: 19px; width: 19px; position: relative; top: 5px;' />: " + _zero + (_diffDT.days != 0 ? (_diffDT.days + " d") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " m") : "") + "</strong></div>", null, true);
                //"<div class='text1' style='overflow: hidden; font-size:.8em; position: relative; left: -2px; top: -8px; width: 125px; height: 59px; margin-right: -15px; margin-bottom: -22px;'><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"" + dic("STOS", lang) + "\")' onmouseout='HidePopup()' src='../images/startRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime1 + "<br /><img onmousemove='ShowPopup(event, \"" + dic("ETOS", lang) + "\")' onmouseout='HidePopup()' src='../images/endRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime + "<br /><img onmousemove='ShowPopup(event, \"" + dic("TTOS", lang) + "\")' onmouseout='HidePopup()' src='../images/sum1.png' style='height: 16px; width: 16px; position: relative; top: 4px;' />: " + _zero + (_diffDT.days != 0 ? (_diffDT.days + " day(s)") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " min") : "") + "</strong></div>", null, true);
                "<div class='text1' style='overflow: hidden; font-size:.8em; position: relative; left: -2px; top: -8px; width: 125px; height: 135px; margin-right: -15px; margin-bottom: -22px;'><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"" + dic("STOS", lang) + "\")' onmouseout='HidePopup()' src='"+twopoint+"/images/startRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime1 + "<br /><img onmousemove='ShowPopup(event, \"" + dic("ETOS", lang) + "\")' onmouseout='HidePopup()' src='"+twopoint+"/images/endRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime + "<br /><img onmousemove='ShowPopup(event, \"" + dic("TTOS", lang) + " со исклучен мотор\")' onmouseout='HidePopup()' src='"+twopoint+"/images/sum1.png' style='height: 16px; width: 16px; position: relative; top: 4px;' />: " + _zero + (_diffDT.days != 0 ? (_diffDT.days + " day(s)") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " min") : "") + "</strong><br/><br/><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"" + dic("STOS", lang) + "\")' onmouseout='HidePopup()' src='"+twopoint+"/images/startRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime + "<br /><img onmousemove='ShowPopup(event, \"" + dic("ETOS", lang) + "\")' onmouseout='HidePopup()' src='"+twopoint+"/images/endRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime2 + "<br /><img onmousemove='ShowPopup(event, \"" + dic("TTOS", lang) + " со вклучен мотор\")' onmouseout='HidePopup()' src='"+twopoint+"/images/sum1.png' style='height: 16px; width: 16px; position: relative; top: 4px;' />: " + _zero1 + (_diffDT1.days != 0 ? (_diffDT1.days + " day(s)") : "") + " " + (_diffDT1.hours != 0 ? (_diffDT1.hours + " h") : "") + " " + (_diffDT1.minutes != 0 ? (_diffDT1.minutes + " min") : "") + "</strong></div>", null, true);
        this.popup = popup;
        this.popup.contentDiv.style.overflow = 'hidden';
        if (parseInt(_diffDT.minutes, 10) > parseInt(_MinMin, 10) || parseInt(_diffDT1.minutes, 10) > parseInt(_MinMin, 10)) {
            map.addPopup(this.popup);

            this.popup.div.style.opacity = '0.7';
            this.popup.div.setAttribute("onmousemove", "MouseOverPopup(this)");
            this.popup.div.setAttribute("onmouseout", "MouseEndPopup(this)");
            this.popup.hide();
        }
        //tmpMarkersRec[tmpMarkersRec.length - 1].feature = feature;
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 12px;\">" + dic("STOS", lang) + ": " + _NewCreateDateTime1 + "<br />" + dic("ETOS", lang) + ": " + _NewCreateDateTime + "<br />" + dic("TTOS", lang) + " " + dic("Reports.WithIgnOff", lang) + ": " + _zero + (_diffDT.days != 0 ? (_diffDT.days + " day(s)") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " min") : "") + "</strong><br/><br/><strong style=\"font-size: 12px;\">" + dic("STOS", lang) + ": " + _NewCreateDateTime + "<br />" + dic("ETOS", lang) + ": " + _NewCreateDateTime2 + "<br />" + dic("TTOS", lang) + " " + dic("Reports.WithIgnOn", lang) + ": " + _zero1 + (_diffDT1.days != 0 ? (_diffDT1.days + " day(s)") : "") + " " + (_diffDT1.hours != 0 ? (_diffDT1.hours + " h") : "") + " " + (_diffDT1.minutes != 0 ? (_diffDT1.minutes + " min") : "") + "</strong>')");
        $(tmpMarkersRec[tmpMarkersRec.length - 1].events.element).mouseout(function () { HidePopup() });
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.addEventListener('click', function (e) { AddPOI = true; VehClick = true; });
    }
}
function DrawPath_old(LonArray, LatArray){
	site_style1 = {'strokeWidth': 7, 'strokeColor': '#0000FF', 'strokeOpacity': '0.7'}
	site_style2 = {'strokeWidth': 5, 'strokeColor': '#0000FF', 'strokeOpacity': '0.5'}
	site_style3 = {'strokeWidth': 3, 'strokeColor': '#0000FF', 'strokeOpacity': '0.3'}
	
	var _lon = LonArray.split(",")
	var _lat = LatArray.split(",")
	
	var points1 = new Array();
	var points2 = new Array();
	var points3 = new Array();
	
	var cir = _lon.length / 3
	var cir1 = cir + cir
	var cir2 = _lon.length
	
	for (i in _lon) {
		point = new OpenLayers.Geometry.Point(_lon[i], _lat[i]);
		point.transform(
			new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
			Maps[0].getProjectionObject() // to Spherical Mercator Projection
		  );
		if (i<cir) {points1.push(point);}
		if (i=cir) {points2.push(lastp);}
		if (i<cir1 && i>cir) {points2.push(point);}
		if (i=cir1) {points3.push(lastp);}
		if (i<cir2 && i>cir1) {points3.push(point);}
		lastp = point
		//site_points.push(point);
	}
	
	
	
	var lineString1 = new OpenLayers.Geometry.LineString(points1);
	var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, site_style1)
	
	var lineString2 = new OpenLayers.Geometry.LineString(points2);
	var lineFeature2 = new OpenLayers.Feature.Vector(lineString2, null, site_style2)
	
	var lineString3 = new OpenLayers.Geometry.LineString(points3);
	var lineFeature3 = new OpenLayers.Feature.Vector(lineString3, null, site_style3)
	
	vectors[0].addFeatures([lineFeature1]);
	vectors[0].addFeatures([lineFeature2]);
	vectors[0].addFeatures([lineFeature3]);
	
	
	return 

}

function AddPOIButton(el, num) {
    if (AllowAddPoi == false) { return false }
    var h = el.offsetHeight - 10
    var AddPOIBtn = Create($(el).children()[0], 'div', 'div-addPoi-' + num)

    $(AddPOIBtn).css({ display: 'block', position: 'absolute', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', left: '340px', top: '7px', padding: '2px 5px 2px 5px', width: '60px', cursor: 'pointer', textAlign: 'center' })
    AddPOIBtn.className = 'corner15 text3'
    AddPOIBtn.innerHTML = dic("addPoi1", lang) + '&nbsp;&nbsp;<strong>+</strong>'

    $(AddPOIBtn).click(function (event) { ButtonAddPOIClick(event, num) });

}

function ShowRoutes(el, num) {
    if (AllowShowRoutes == false) { return false }

    var layerRoutes = Create(el, 'div', 'div-layer-Routes-' + num);
    $(layerRoutes).css({ position: 'relative', float: 'left', zIndex: '8008', left: '20px', width: '105px', height: '25px' });
    layerRoutes.className = 'corner15 text3';


    var h = el.offsetHeight - 10
    var AddRoutesBtn = Create(layerRoutes, 'div', 'div-addRoutes-' + num)

    $(AddRoutesBtn).css({ display: 'block', position: 'relative', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 5px', width: '85px', cursor: 'pointer', textAlign: 'center' })
    AddRoutesBtn.className = 'corner15 text3'
    AddRoutesBtn.innerHTML = dic("SelectRoute", lang);

    var btnListOfRoutes = Create(layerRoutes, 'div', 'ListOfRoutes-' + num)
    $(btnListOfRoutes).css({ display: 'none', position: 'absolute', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', paddingTop: '5px', paddingBottom: '5px', width: '155px', height: 'auto', textAlign: 'center' })
    btnListOfRoutes.className = 'cornerAdd1 text3';
    $(btnListOfRoutes).html('<img id="imgRoutesLoading-0" src="' + twopoint + '/images/ajax-loader.gif" style="display: block; position: relative; cursor: pointer; z-index: 8000; left: 130px; width: 17px;">');
    $.ajax({
        url: twopoint + "/routes/LoadAllRoute.aspx?day=" + todayNew,
        context: document.body,
        success: function (data) {
            if (data == "") {
                $(btnListOfRoutes).html(dic("InfoRoute4", lang));
            } else {
                var _html = "";
                for (var i = 0; i < data.split("#").length - 1; i++) {
                    _html += '<div id="rout_' + data.split("#")[i].split("@%")[0] + '" onmousemove="ShowPopup(event, \'' + dic("Name", lang) + ': ' + data.split("#")[i].split("@%")[1] + '<br>' + dic("Start", lang) + ': ' + data.split("#")[i].split("@%")[2] + '<br>' + dic("Registration", lang) + ': ' + data.split("#")[i].split("@%")[3] + '<br>' + dic("Number", lang) + ': ' + data.split("#")[i].split("@%")[4] + '\')" onmouseout="HidePopup()" style="cursor: pointer;" class="routesMenu corner15" onclick="LoadRouteLive(' + data.split("#")[i].split("@%")[0] + ', \'' + data.split("#")[i].split("@%")[0] + ' - ' + data.split("#")[i].split("@%")[1] + '\')"><font style="font-size: 14px;">○</font>&nbsp;' + data.split("#")[i].split("@%")[0] + ' - ' + data.split("#")[i].split("@%")[1] + '</div>';
                }
                $(btnListOfRoutes).html(_html);
            }
            HideWait();
        }
    });
    $(AddRoutesBtn).click(function (event) {
        ShowHideRouteList(num);
    });
    if (Browser()!='iPad') {
    	$(AddRoutesBtn).mousemove(function (event) { ShowPopup(event, dic("SelectRoute", lang)) });
    	$(AddRoutesBtn).mouseout(function () { HidePopup() });
    }
}
function ShowHideRouteList(num) {
    if ($('#ListOfRoutes-'+num).css('display') == "none") {
        $('#div-addRoutes-' + num)[0].className = 'cornerAdd text3';
        $('#div-addRoutes-' + num)[0].style.borderBottom = '1px solid White';
        $('#ListOfRoutes-' + num).css({ display: 'block' });
    }
    else {
        $('#div-addRoutes-' + num)[0].className = 'corner15 text3';
        $('#div-addRoutes-' + num)[0].style.borderBottom = '0px';
        $('#ListOfRoutes-' + num).css({ display: 'none' });
    }
}
function AddRuler(el, num) {
    //if (AllowAddRuler == false) { return false }

    var layerRuler = Create(el, 'div', 'div-layer-Ruler-' + num);
    $(layerRuler).css({ position: 'relative', float: 'left', zIndex: '8008', left: '20px', width: '70px', height: '25px' });
    layerRuler.className = 'corner15 text3';

    
    var h = el.offsetHeight - 10
    var AddRulerBtn = Create(layerRuler, 'div', 'div-addRuler-' + num)

    $(AddRulerBtn).css({ display: 'block', position: 'relative', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 5px', width: '50px', cursor: 'pointer', textAlign: 'center' })
    AddRulerBtn.className = 'corner15 text3'
    AddRulerBtn.innerHTML = dic("Ruler", lang);

    var btnCancelNewArea = Create(layerRuler, 'div', 'outputMeasure-' + num)
    $(btnCancelNewArea).css({ display: 'none', position: 'absolute', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', paddingTop: '5px', width: '140px', height: '20px', textAlign: 'center' })
    btnCancelNewArea.className = 'cornerAdd1 text3'

    $(AddRulerBtn).click(function (event) { toggleControl1('line', num) });
    if (Browser()!='iPad') {
    	$(AddRulerBtn).mousemove(function (event) { ShowPopup(event, dic("RulerMeasure", lang)) });
    	$(AddRulerBtn).mouseout(function () { HidePopup() });
	}
}

function AddSearchButton(el, num) {
    //if (ShowVehiclesMenu == false) { return false }

    var layerSearchButton = Create(el, 'div', 'div-layer-SearchButton-' + num);
    $(layerSearchButton).css({ position: 'relative', float: 'left', zIndex: '8007', left: '20px', width: '90px', height: '25px' });
    layerSearchButton.className = 'corner15 text3';

    var h = el.offsetHeight - 10
    var AddSearchBtn = Create(layerSearchButton, 'div', 'div-addSearch-' + num)

    $(AddSearchBtn).css({ display: 'block', position: 'relative', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 5px', width: '70px', cursor: 'pointer', textAlign: 'center' })
    AddSearchBtn.className = 'corner15 text3';
    AddSearchBtn.innerHTML = dic("search", lang);

	var AddSearchBtns = Create(layerSearchButton, 'div', 'div-addSearchNew-' + num)
	$(AddSearchBtns).css({ display: 'none', position: 'relative', borderRadius: '0px 10px 0px 0px', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 3px', width: '240px', cursor: 'pointer', textAlign: 'center' })
    
    var ulSearch = Create(AddSearchBtns, 'ul', 'tabSearch-' + num);
    $(ulSearch).css({ position: 'relative', border: '0px', borderRadius: '0px 10px 0px 0px', zIndex: '8000', color: '#387CB0', paddingRight: '50px', width: '185px', height: '24px', textAlign: 'left' })
    ulSearch.className = 'text3 search-options';
    
    var liSearch1 = Create(ulSearch, 'li', 'tab1');
    liSearch1.className = 'text3 selected';
    var aSearch1 = Create(liSearch1, 'a', 'tab1_a');
    aSearch1.innerHTML = dic("Streets", lang);
    $(aSearch1).click(function (event) { setSearchOptions(1, num) });
    if (Browser()!='iPad') {
    	$(aSearch1).mousemove(function (event) { ShowPopup(event, dic("searchStreetsByName", lang)) });
    	$(aSearch1).mouseout(function() {HidePopup()});
	}
    
//    var liSearch2 = Create(ulSearch, 'li', 'tab2');
//    liSearch2.className = 'text3';
//    var aSearch2 = Create(liSearch2, 'a', 'tab2_a');
//    aSearch2.innerHTML = 'Point';
//    $(aSearch2).click(function (event) { setSearchOptions(2, num) });
//    $(aSearch2).mousemove(function(event) {ShowPopup(event, 'Search name by longitude/latitude')});
//    $(aSearch2).mouseout(function() {HidePopup()});
    
    var liSearch2 = Create(ulSearch, 'li', 'tab2');
    liSearch2.className = 'text3';
    var aSearch2 = Create(liSearch2, 'a', 'tab2_a');
    aSearch2.innerHTML = dic("Pois", lang);
    $(aSearch2).click(function (event) { setSearchOptions(2, num) });
    if (Browser()!='iPad') {
    	$(aSearch2).mousemove(function (event) { ShowPopup(event, dic("search", lang) + " " + dic("Pois", lang)) });
    	$(aSearch2).mouseout(function() {HidePopup()});
	}

	var textSearch = Create(AddSearchBtns, 'input', 'textSearch-' + num); //1px solid #387CB0
    $(textSearch).css({ position: 'relative', border: '0px', borderRadius: '0px 0px 0px 0px', zIndex: '8000', backgroundColor: '#FFF', color: '#387CB0', paddingLeft: '5px', paddingRight: '50px', width: '242px', height: '24px', textAlign: 'left' })
    textSearch.className = 'text3';
    //$(textSearch).attr("onkeydown", "searchLoc('textSearch-'+" + num + ", event," + num + ")");
    //$(textSearch)[0].setAttribute("onkeydown", "searchItems1('textSearch-'+" + num + ", event," + num + ")");

    $("#textSearch-" + num).autocomplete({
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
            setCenterMap(ui.item.longitude, ui.item.latitude, 18, num);
            AddMarkerS(ui.item.longitude, ui.item.latitude, num, ui.item.label);
        },
        open: function () { $("#textSearch-" + num).autocomplete("widget").width(350) }
    });

    var imgSearch = Create(AddSearchBtns, 'img', 'imgSearchLoading-' + num);
    $(imgSearch).attr("src", twopoint + "/images/ajax-loader.gif");
    $(imgSearch).css({ display: 'none', position: 'absolute', cursor: 'pointer', zIndex: '8000', left: '199px', top: '30px', width: '17px' });

    var imgSearch = Create(AddSearchBtns, 'img', 'imgSearch-' + num);
    $(imgSearch).attr("src", twopoint + "/images/zoom.png");
    $(imgSearch).css({ position: 'absolute', cursor: 'pointer', display: 'none', zIndex: '8000', left: '219px', top: '29px', width: '23px' });
    $(imgSearch)[0].setAttribute("onclick", "searchItems11('textSearch-'+" + num + ", " + num + ")");

    var btnSearch = Create(layerSearchButton, 'div', 'outputSearch-' + num);
    $(btnSearch).css({ display: 'none', position: 'absolute', zIndex: '8000', borderTop: '1px Solid', maxHeight: (window.innerHeight - 165) + 'px', overflowY: 'auto', backgroundColor: '#387cb0', top: '71px', color: '#fff', padding: '10px', paddingBottom: '20px', width: '228px', height: 'auto', textAlign: 'left' })
    btnSearch.className = 'cornerS text3';

    $(AddSearchBtn).click(function (event) { SearchName(num, 0) });
    if (Browser()!='iPad') {
    	$(AddSearchBtn).mousemove(function (event) { ShowPopup(event, dic("searchByName", lang)) });
    	$(AddSearchBtn).mouseout(function () { HidePopup() });
	}
}
function setSearchOptions(idElement, num){
	/* Total Tabs above the input field (in this case there are 3 tabs: web, images, videos) */
	tot_tab = 3;
	tab = document.getElementById('tab' + idElement);
	$("#textSearch-" + num).val('');
	
	if (idElement == 2) {
	    $("#imgSearch-" + num).css({ display: "block" });
	    $("#textSearch-" + num).autocomplete("disable");
	    $("#textSearch-" + num)[0].setAttribute("onkeydown", "searchItems2('textSearch-'+" + num + ", event, " + num + ")");
	    $("#imgSearch-" + num)[0].setAttribute("onclick", "searchItems21('textSearch-'+" + num + ", " + num + ")");
	} else {
        $("#outputSearch-" + num).css({ display: "none" });
	    $("#imgSearch-" + num).css({ display: "none" });
	    $("#textSearch-" + num)[0].setAttribute("onkeydown", "");
	    $("#textSearch-" + num).autocomplete("enable");
	}
	for(var i=1; i<3; i++){
		if(i==idElement){
			/*set class for active tab */
			tab.setAttribute("class","selected");

			/*var nV = $('#textSearch-' + num)[0].attributes[3].nodeValue;
			var nV1 = nV.substring(0, nV.indexOf("(")-1) + i + nV.substring(nV.indexOf("("), nV.length);
			$('#textSearch-' + num)[0].attributes[3].nodeValue = nV1;
			var nVS = $('#imgSearch-' + num)[0].attributes[3].nodeValue;
			var nVS1 = nVS.substring(0, nVS.indexOf("(")-2) + i + nVS.substring(nVS.indexOf("(")-1, nVS.length);
			$('#imgSearch-' + num)[0].attributes[3].nodeValue = nVS1;*/
			/*set value for the hidden input element */
			//search_option.value = idElement;
		} else {
			/*unset class for non active tabs */
			document.getElementById('tab'+i).setAttribute("class","");
		}
	}
	$('#textSearch-' + num).focus();
}
function SearchName(num, _c) {
    if ($('#div-addSearch-' + num)[0].textContent.indexOf(dic("search", lang)) != -1) {
        if (_c != 1) {
            if (tmpMarkerStreet != undefined) {
                Markers[num].removeMarker(tmpMarkerStreet);
            }
            if (tmpSearchMarker != undefined) {
		        Markers[num].removeMarker(tmpSearchMarker);
		    }
		    RemoveAllFeature();
		    RemoveAllFeaturePoly()
        }
        $('#div-addSearch-' + num)[0].textContent = dic("cancel", lang);
        $('#div-addSearch-' + num)[0].className = 'cornerAdd text3';
        $('#div-addSearch-' + num)[0].style.borderBottom = '1px Solid White';
        $('#textSearch-' + num).val('');
        $('#div-addSearchNew-' + num).css({ display: 'block' });
        $('#textSearch-' + num).focus();
        if (ShowHideZone == true)
        	LoadAllZone()
    } else {
        if (_c != 1) {
            if (tmpMarkerStreet != undefined) {
                Markers[num].removeMarker(tmpMarkerStreet);
            }
            if (tmpSearchMarker != undefined) {
		        Markers[num].removeMarker(tmpSearchMarker);
		    }
		    RemoveAllFeature();
		    RemoveAllFeaturePoly()
        }
        $('#div-addSearchNew-' + num).css({ display: 'none' });
        $('#outputSearch-' + num).css({ display: 'none' });
        $('#imgSearchLoading-' + num).css({ display: 'none' });
        $('#div-addSearch-' + num)[0].textContent = dic("search", lang);
        $('#div-addSearch-' + num)[0].className = 'corner15 text3';
        $('#div-addSearch-' + num)[0].style.borderBottom = '';
    }
}

function AddVehicleToFollow(el, num){
    if (ShowVehiclesMenu == false) { return false }

    var layerVehicleToFollow = Create(el, 'div', 'div-layer-VehicleToFollow-' + num);
    $(layerVehicleToFollow).css({ position: 'relative', float: 'left', zIndex: '8006', left: '20px', width: '80px', height: '25px' });
    layerVehicleToFollow.className = 'corner15 text3';

	var h = el.offsetHeight-10
	var VehcileToFollow = Create(layerVehicleToFollow, 'div', 'div-vehicle-tofollow-' + num);
	$(VehcileToFollow).css({ display: 'block', position: 'relative', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 5px', width: '60px', cursor: 'pointer', textAlign: 'center' })
	VehcileToFollow.className = 'corner15 text3'
	VehcileToFollow.innerHTML = dic("vehToFollow", lang) + '&nbsp;&nbsp;▼'

	var layerListF = Create(layerVehicleToFollow, 'div', 'div-vehicleF-list-' + num)
	$(layerListF).css({ display: 'block', position: 'absolute', zIndex: '7999', backgroundColor: '#e2ecfa', border: '1px solid #1a6ea5', color: '#fff', padding: '2px 5px 2px 10px', width: '200px', height: '310px', cursor: 'pointer', textAlign: 'center', overflowX: 'hidden', overflowY: 'scroll', display: 'none' })
	var str = '<label class="menu_vehicle" style="text-align: left; margin-left: -5px; font-size: 12px;">&nbsp;<input onChange="VehicleFListClick(' + num + ', -1);VehicleListClickAllF(' + num + ', this.id)" id="f-vehicle-' + num + '--1" type="checkbox" />&nbsp;' + dic("allVehicles", lang) + '</label>'
	
	for (var i = 0; i < VehicleListNotOENum.length; i++) {
		str += '<label class="menu_vehicle" style="text-align: left; margin-left: -5px; font-size: 12px;">&nbsp;<input class="fselectOE-' + num + '-' + VehicleListNotOENum[i]+'" onChange="VehicleFListClick(' + num + ', ' + VehicleListNotOENum[i] + ')" id="f-vehicle-' + num + '-' + VehicleListNotOENum[i] + '" type="checkbox" />&nbsp;' + VehicleListNotOEName[i] + '</label>';
	}	
	var selector = '';
	for (var i = 0; i < VehicleListOENum.length; i++) {
		str += '<div class="menu_vehicle_OE"><div id="f1-vehicle-' + num + '-' + VehicleListOENum[i] + '" class="plusminus1">-</div><input class="inputOEfAll-'+num+'" style="position: absolute;" onChange="VehicleListClickOEF(' + num + ', ' + VehicleListOENum[i] + ')" id="f-vehicle-' + num + '-' + VehicleListOENum[i] + '" type="checkbox" /><div style="padding-left: 22px;" class="collapsibleF'+num+'" onclick="plusminus(\'f1-vehicle-' + num + '-' + VehicleListOENum[i] + '\')" id="fsection-' + num + '-' + (i+1) + '"><strong>' + VehicleListOEName[0].split(",")[i] + '</strong></div><div class="container"><div class="content" id="foperation-' + num + '-' + VehicleListOENum[i] + '"></div></div></div>';
		selector += 'fsection-' + num + '-' + (i+1) + ',';
	}
	layerListF.innerHTML = str;  //'<div style="height:10px"></div><div id="layer-1-'+num+'" onclick="SelectMapLayer('+num+', 1)" class="menu_layer">&nbsp;&nbsp;Google Maps</div><div id="layer-2-'+num+'" onclick="SelectMapLayer('+num+', 2)" class="menu_layer">&nbsp;&nbsp;Open Street Maps</div><div id="layer-3-'+num+'" onclick="SelectMapLayer('+num+', 3)" class="menu_layer">&nbsp;&nbsp;Bing Maps</div><div id="layer-4-'+num+'" onclick="SelectMapLayer('+num+', 4)" class="menu_layer">&nbsp;&nbsp;Yahoo Maps</div>'
	for (var i = 0; i < VehicleList.length; i++) {
	    var ch = getCheckVehicle(num, VehicleListID[i])
	    var chs = ''
	    if (ch == true) { chs = ' checked="true" ' }
	    $('#foperation-' + num + '-' + VehicleListOEID[i]).html($('#foperation-' + num + '-' + VehicleListOEID[i]).html() + '<label class="menu_vehicle">&nbsp;<input class="fselectOE-' + num + '-' + VehicleListOEID[i]+'" onChange="VehicleFListClick(' + num + ', ' + VehicleListID[i] + ')" id="f-vehicle-' + num + '-' + VehicleListID[i] + '" type="checkbox" />&nbsp;' + VehicleList[i] + '</label>');
	    //str = str + '<label class="menu_vehicle">&nbsp;<input onChange="VehicleFListClick(' + num + ', ' + VehicleListID[i] + ')" id="f-vehicle-' + num + '-' + VehicleListID[i] + '" type="checkbox" />&nbsp;' + VehicleList[i] + '</label>';
	}
	$('.collapsibleF'+num).collapsible({
		defaultOpen: selector.substring(0,selector.length-1)
	});
	$(VehcileToFollow).click(function (event) { ShowHideVehicleFList(num) });
	if (Browser()!='iPad') {
		$(VehcileToFollow).mousemove(function (event) { ShowPopup(event, dic("ListVehicles", lang) + '<br /><font style=\"font-size: 8px\">*' + dic("FollowVehicles", lang) + '</font>') });
		$(VehcileToFollow).mouseout(function () { HidePopup() });
	}
}
function plusminus(_id){
	if($('#'+_id).html() == "-")
		$('#'+_id).fadeOut('slow',function(){
			$('#'+_id)[0].className = "plusminus2";
			$('#'+_id).html("+").fadeIn('slow');
		});
	else
		$('#'+_id).fadeOut('slow',function(){
			$('#'+_id)[0].className = "plusminus1";
			$('#'+_id).html("-").fadeIn('slow');
		});
}

function AddVehicleChooser(el, num) {
    if (ShowVehiclesMenu == false) { return false }

    var layerVehicleChooser = Create(el, 'div', 'div-layer-VehicleChooser-' + num);
    $(layerVehicleChooser).css({ position: 'relative', float: 'left', zIndex: '8005', left: '20px', width: '80px', height: '25px' });
    layerVehicleChooser.className = 'corner15 text3';

    var h = el.offsetHeight - 10
    var VehcileChooser = Create(layerVehicleChooser, 'div', 'div-vehicle-chooser-' + num)
    $(VehcileChooser).css({ display: 'block', position: 'relative', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 5px', width: '60px', cursor: 'pointer', textAlign: 'center' })
    VehcileChooser.className = 'corner15 text3'
    VehcileChooser.innerHTML = dic("Vehicles", lang) + '&nbsp;&nbsp;▼'

    var layerList = Create(layerVehicleChooser, 'div', 'div-vehicle-list-' + num)
    $(layerList).css({ display: 'block', position: 'absolute', zIndex: '7999', backgroundColor: '#e2ecfa', border: '1px solid #1a6ea5', color: '#fff', padding: '2px 5px 2px 10px', width: '200px', height: '310px', cursor: 'pointer', textAlign: 'center', overflowX: 'hidden', overflowY: 'scroll', display: 'none' })
    var str = '<label class="menu_vehicle" style="text-align: left; margin-left: -5px; font-size: 12px;">&nbsp;<input onChange="VehicleListClick(' + num + ', -1);VehicleListClickAll(' + num + ', this.id)" id="cb-vehicle-' + num + '--1" type="checkbox" checked="true" />&nbsp;' + dic("allVehicles", lang) + '</label>'
	for (var i = 0; i < VehicleListNotOENum.length; i++) {
		var ch = getCheckVehicle(num, VehicleListNotOENum[i])
        var chs = ''
        if (ch == true) { chs = ' checked="true" ' }
		str += '<label class="menu_vehicle" style="text-align: left; margin-left: -5px; font-size: 12px;">&nbsp;<input class="selectOE-' + num + '-' + VehicleListNotOENum[i]+'" onChange="VehicleListClick(' + num + ', ' + VehicleListNotOENum[i] + ')" id="cb-vehicle-' + num + '-' + VehicleListNotOENum[i] + '" type="checkbox" ' + chs + ' />&nbsp;' + VehicleListNotOEName[i] + '</label>';
	}
	var selector = '';
	for (var i = 0; i < VehicleListOENum.length; i++) {
		str += '<div class="menu_vehicle_OE"><div id="1vehicle-' + num + '-' + VehicleListOENum[i] + '" class="plusminus1">-</div><input class="inputOEAll-'+num+'" checked="true" style="position: absolute;" onChange="VehicleListClickOE(' + num + ', ' + VehicleListOENum[i] + ')" id="cb-vehicleOE-' + num + '-' + VehicleListOENum[i] + '" type="checkbox" /><div style="padding-left: 22px;" class="collapsible'+num+'" onclick="plusminus(\'1vehicle-' + num + '-' + VehicleListOENum[i] + '\')" id="section-' + num + '-' + (i+1) + '"><strong>' + VehicleListOEName[0].split(",")[i] + '</strong></div><div class="container"><div class="content" id="operation-' + num + '-' + VehicleListOENum[i] + '"></div></div></div>';
		selector += 'section-' + num + '-' + (i+1) + ',';
	}
    layerList.innerHTML = str; //'<div style="height:10px"></div><div id="layer-1-'+num+'" onclick="SelectMapLayer('+num+', 1)" class="menu_layer">&nbsp;&nbsp;Google Maps</div><div id="layer-2-'+num+'" onclick="SelectMapLayer('+num+', 2)" class="menu_layer">&nbsp;&nbsp;Open Street Maps</div><div id="layer-3-'+num+'" onclick="SelectMapLayer('+num+', 3)" class="menu_layer">&nbsp;&nbsp;Bing Maps</div><div id="layer-4-'+num+'" onclick="SelectMapLayer('+num+', 4)" class="menu_layer">&nbsp;&nbsp;Yahoo Maps</div>'
	for (var i = 0; i < VehicleList.length; i++) {
        var ch = getCheckVehicle(num, VehicleListID[i])
        var chs = ''
        if (ch == true) { chs = ' checked="true" ' }
        $('#operation-' + num + '-' + VehicleListOEID[i]).html($('#operation-' + num + '-' + VehicleListOEID[i]).html() + '<label class="menu_vehicle">&nbsp;<input class="selectOE-' + num + '-' + VehicleListOEID[i]+'" onChange="VehicleListClick(' + num + ', ' + VehicleListID[i] + ')" id="cb-vehicle-' + num + '-' + VehicleListID[i] + '" type="checkbox" ' + chs + ' />&nbsp;' + VehicleList[i] + '</label>');
    }
    $('.collapsible'+num).collapsible({
		defaultOpen: selector.substring(0,selector.length-1)
	});
    $(VehcileChooser).click(function (event) { ShowHideVehicleList(num) });
    if (Browser()!='iPad') {
    	$(VehcileChooser).mousemove(function (event) { ShowPopup(event, dic("ListVehicles", lang) + '<br /><font style=\"font-size: 8px\">*' + dic("ChooseVehicles", lang) + '</font>') });
    	$(VehcileChooser).mouseout(function () { HidePopup() });
	}
}

function getCheckVehicle(_mapNo, vID){
	for (var j=0; j<Car.length;j++){
		if (Car[j].id==vID) {
			if 	(_mapNo==0) return Car[j].map0
			if 	(_mapNo==1) return Car[j].map1
			if 	(_mapNo==2) return Car[j].map2
			if 	(_mapNo==3) return Car[j].map3
			
		}
	}
}
function ShowHideVehicleFList(num) {
    var disp = document.getElementById('div-vehicleF-list-' + num).style.display
    if (disp == 'none') {
        $('#div-vehicle-tofollow-' + num).html(dic("vehToFollow", lang) + "&nbsp;&nbsp;▲");
        document.getElementById('div-vehicleF-list-' + num).style.display = 'block'
        return
    } else {
        $('#div-vehicle-tofollow-' + num).html(dic("vehToFollow", lang) + "&nbsp;&nbsp;▼");
        document.getElementById('div-vehicleF-list-' + num).style.display = 'none'
    }
}
function ShowHideVehicleList(num) {
    var disp = document.getElementById('div-vehicle-list-' + num).style.display
    if (disp == 'none') {
        $('#div-vehicle-chooser-' + num).html(dic("Vehicles", lang) + "&nbsp;&nbsp;▲");
        document.getElementById('div-vehicle-list-' + num).style.display = 'block'
        return
    } else {
        $('#div-vehicle-chooser-' + num).html(dic("Vehicles", lang) + "&nbsp;&nbsp;▼");
        document.getElementById('div-vehicle-list-' + num).style.display = 'none'
    }
}
function VehicleFListClick(num, vID) {
    if (vID == -1) {
        if (document.getElementById('f-vehicle-' + num + '--1').checked) {
            document.getElementById('div-vehicle-tofollow-' + num).style.color = '#14D61A';
            FollowAllVehicles[SelectedBoard] = true;
            FollowActive[num] = true;
            for (var i = 0; i < Vehicles.length; i++)
            {
                if (Vehicles[i].Map == num) {
	                if (!$('#f-vehicle-' + num + '-' + Vehicles[i].ID).attr('disabled'))
	                {
	                    $('#f-vehicle-' + num + '-' + Vehicles[i].ID).attr({ checked: true });
	                }
	                if(Vehicles[i].Marker.events.element.children[2] != undefined)
                	{
                		//$(Vehicles[i].Marker.events.element.children[3]).remove();
        				$(Vehicles[i].Marker.events.element.children[2]).remove();
    				}
                	Vehicles[i].Marker.events.element.innerHTML += '<div class="impuls3_'+num+' gnMarkerPulsing' + Vehicles[i].Color + '"></div>';
                }
           }
			zoomWorldScreen(Maps[SelectedBoard], Maps[SelectedBoard].zoom);
			setTimeout("switchClass12_"+num+"("+num+");", 10);
        } else {
            document.getElementById('div-vehicle-tofollow-' + num).style.color = '#FFFFFF';
            FollowAllVehicles[SelectedBoard] = false;
            FollowActive[num] = false;
            for (var i = 0; i < Vehicles.length; i++)
            {
                if (Vehicles[i].Map == num) {
                	$('#f-vehicle-' + num + '-' + Vehicles[i].ID).attr({ checked: false });
                	if(Vehicles[i].Marker.events.element.children[2] != undefined)
                	{
						//$(Vehicles[i].Marker.events.element.children[3]).remove();
        				$(Vehicles[i].Marker.events.element.children[2]).remove();
    				}
                }
        	}
        }
    } else {
        if (document.getElementById('f-vehicle-' + num + '-' + vID).checked) {
            document.getElementById('div-vehicle-tofollow-' + num).style.color = '#14D61A';
            var ll = Maps[SelectedBoard].getCenter().transform(new OpenLayers.Projection("EPSG:4326"), Maps[SelectedBoard].getProjectionObject());
            for (var i = 0; i < Vehicles.length; i++)
                if (Vehicles[i].ID == vID && Vehicles[i].Map == num) {
                	Vehicles[i].Marker.events.element.innerHTML += '<div class="impuls3_'+num+' gnMarkerPulsing' + Vehicles[i].Color + '"></div>';
                	if(!FollowActive[num])
                	{
                		FollowActive[num] = true;
                		setTimeout("switchClass12_"+num+"("+num+");", 10);
            		}
                    setCenterMap(Vehicles[i].Lon, Vehicles[i].Lat, 16, SelectedBoard);
                    break;
                }
        } else {
          	var _b = true;
            for (var i = 0; i < VehicleListID.length; i++)
            {
                if (document.getElementById('f-vehicle-' + num + '-' + VehicleListID[i]).checked) {
                    _b = false;
                    break;
                }
			}
            for (var i = 0; i < Vehicles.length; i++)
            {
                if (Vehicles[i].ID == vID && Vehicles[i].Map == num) {
	                if(Vehicles[i].Marker.events.element.children[2] != undefined)
                	{
	                	//$(Vehicles[i].Marker.events.element.children[3]).remove();
	        			$(Vehicles[i].Marker.events.element.children[2]).remove();
	                }
	                break;
                }
            }
            if (_b)
            {
                document.getElementById('div-vehicle-tofollow-' + num).style.color = '#FFFFFF';
                FollowActive[num] = false;
            }
        }
    }
}
function VehicleListClickOE(num, OEID) {
	if($('#cb-vehicleOE-'+num+'-'+OEID).attr('checked'))
		$('.selectOE-' + num + '-' + OEID).attr({ checked: true });
	else
		$('.selectOE-' + num + '-' + OEID).attr({ checked: false });
	for (var j=0; j<$('.selectOE-' + num + '-' + OEID).length;j++){
		VehicleListClick(num, $('.selectOE-' + num + '-' + OEID)[j].id.substring($('.selectOE-' + num + '-' + OEID)[j].id.lastIndexOf("-")+1,$('.selectOE-' + num + '-' + OEID)[j].id.length));
	}
}
function VehicleListClickOEF(num, OEID) {
	if($('#f-vehicle-'+num+'-'+OEID).attr('checked'))
		$('.fselectOE-' + num + '-' + OEID).attr({ checked: true });
	else
		$('.fselectOE-' + num + '-' + OEID).attr({ checked: false });
	for (var j=0; j<$('.fselectOE-' + num + '-' + OEID).length;j++){
		VehicleFListClick(num, $('.fselectOE-' + num + '-' + OEID)[j].id.substring($('.fselectOE-' + num + '-' + OEID)[j].id.lastIndexOf("-")+1,$('.fselectOE-' + num + '-' + OEID)[j].id.length));
	}
}
function VehicleListClickAll(num,_id){
	if($('#'+_id).attr('checked'))
		$('.inputOEAll-'+num).attr({ checked: true });
	else
		$('.inputOEAll-'+num).attr({ checked: false });
}
function VehicleListClickAllF(num,_id){
	if($('#'+_id).attr('checked'))
		$('.inputOEfAll-'+num).attr({ checked: true });
	else
		$('.inputOEfAll-'+num).attr({ checked: false });
}
function VehicleListClick(num, vID) {
	if (vID == -1){
	    for (var i = 0; i < VehicleListID.length; i++) {
	        if (!$('#cb-vehicle-' + num + '-' + VehicleListID[i]).attr('disabled')) {
	            document.getElementById('cb-vehicle-' + num + '-' + VehicleListID[i]).checked = document.getElementById('cb-vehicle-' + num + '--1').checked;
	            VehicleListClick(num, VehicleListID[i]);
	        }
	    }
	    if(ShowHideTrajectory)
	    	OnClickSHTrajectory();
	} else {
		for (var j=0; j<Car.length;j++){
				if (Car[j].id==vID+''){
					if (num==0) {
						Car[j].map0=document.getElementById('cb-vehicle-'+num+'-'+vID).checked
						for (var v=0; v<Vehicles.length; v++){
							if ((Vehicles[v].ID==Car[j].id) && (Vehicles[v].Map==0)){Vehicles[v].Marker.display(Car[j].map0)}
						}
						if(tmpCheckGroup != '')
						{
                    		if(tmpCheckGroup[num+1] != undefined)
                    		{
								if(tmpCheckGroup[num+1][j+1] == 1)
								{
									tmpCheckGroup[num+1][j+1] = 0;
						            if (PathPerVeh[num][Car[j].id] != undefined && PathPerVeh[num][Car[j].id] != "") {
						                for (var k = 0; k < PathPerVeh[num][Car[j].id].length; k++)
						                    for (var z = 0; z < 4; z++)
						                        if (Boards[z] != null)
						                        {
						                            vectors[z].removeFeatures(PathPerVeh[z][Car[j].id][k]);
						                            vectors[z].removeFeatures(PathPerVehShadow[z][Car[j].id][k]);
												}
						                for (var z = 0; z < 4; z++)
						                    if (Boards[z] != null)
						                    {
						        				PathPerVeh[z][Car[j].id] = [];
						        				PathPerVehShadow[z][Car[j].id] = [];
						        			}
						            }
						            for(var l=0; l<tmpMarkersTrajectory[num].length-1; l++)
						            {
						            	if(tmpMarkersTrajectory[num][l].events.element.attributes[2].value.indexOf(dic("Number", lang) + ' ' + Car[j].id) != -1)
						            	{
						            		Markers[num].removeMarker(tmpMarkersTrajectory[num][l]);
		        							tmpMarkersTrajectory[num][l].destroy();
		        							tmpMarkersTrajectory[num].splice(l, 1);
		        							l--;
						            	}
						            }
								}
							}
						} else
						{
							if(ShowHideTrajectory)
							{
								if (PathPerVeh[num][Car[j].id] != undefined && PathPerVeh[num][Car[j].id] != "") {
					                for (var k = 0; k < PathPerVeh[num][Car[j].id].length; k++)
					                    for (var z = 0; z < 4; z++)
					                        if (Boards[z] != null)
					                        {
					                            vectors[z].removeFeatures(PathPerVeh[z][Car[j].id][k]);
					                            vectors[z].removeFeatures(PathPerVehShadow[z][Car[j].id][k]);
											}
					                for (var z = 0; z < 4; z++)
					                    if (Boards[z] != null)
					                    {
					        				PathPerVeh[z][Car[j].id] = [];
					        				PathPerVehShadow[z][Car[j].id] = [];
					        			}
					            }
								for(var l=0; l<tmpMarkersTrajectory[num].length-1; l++)
					            {
					            	if(tmpMarkersTrajectory[num][l].events.element.attributes[2].value.indexOf(dic("Number", lang) + ' ' + Car[j].id) != -1)
					            	{
					            		Markers[num].removeMarker(tmpMarkersTrajectory[num][l]);
	        							tmpMarkersTrajectory[num][l].destroy();
	        							tmpMarkersTrajectory[num].splice(l, 1);
	        							l--;
					            	}
					            }
							}
						}
					}
					if (num==1) {
						Car[j].map1=document.getElementById('cb-vehicle-'+num+'-'+vID).checked
						for (var v=0; v<Vehicles.length; v++){
							if ((Vehicles[v].ID==Car[j].id) && (Vehicles[v].Map==1)){Vehicles[v].Marker.display(Car[j].map1)}
						}
					}
					if (num==2) {
						Car[j].map2=document.getElementById('cb-vehicle-'+num+'-'+vID).checked
						for (var v=0; v<Vehicles.length; v++){
							if ((Vehicles[v].ID==Car[j].id) && (Vehicles[v].Map==2)){Vehicles[v].Marker.display(Car[j].map2)}
						}						
					}
					if (num==3) {
						Car[j].map3=document.getElementById('cb-vehicle-'+num+'-'+vID).checked
						for (var v=0; v<Vehicles.length; v++){
							if ((Vehicles[v].ID==Car[j].id) && (Vehicles[v].Map==3)){Vehicles[v].Marker.display(Car[j].map3)}
						}						
					}
				}
		}
	}
}

function ShowGFButton(el, num) {
    if (ShowGFBtn) {
        var h = el.offsetHeight - 10
		if (Browser() != 'iPad') {
        	var layerGFButton = Create(el, 'div', 'div-layer-GFButton-' + num);
        	$(layerGFButton).css({ position: 'relative', float: 'left', left: '20px', zIndex: '8003', width: '150px', height: '25px' });
        	layerGFButton.className = 'corner15 text3';

        	var layerGF = Create(layerGFButton, 'div', 'div-layer-gfb')
		
	        $(layerGF).css({ display: 'block', position: 'relative', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 15px', width: '120px', cursor: 'pointer', textAlign: 'left' })
	        layerGF.className = 'corner15 text3'
	        $('#div-layer-gfb').html(dic("showGeoFence", lang) + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
	
	        var layerGF1 = Create(layerGFButton, 'div', 'div-allgf');
	        $(layerGF1).css({ display: 'block', position: 'absolute', zIndex: '8001', fontSize: '11px', backgroundColor: 'transparent', color: '#fff', left: '112px', top: '1px', width: '15px', cursor: 'pointer' })
	        $('#div-allgf').html('|&nbsp;&nbsp;&nbsp;▼');
	
	        var layerGF2 = Create(layerGFButton, 'div', 'div-gfimg');
	        $(layerGF2).css({ display: 'block', position: 'absolute', zIndex: '8001', borderRadius: '100px', backgroundColor: 'red', left: '5px', top: '5px', height: '7px', width: '7px' });
	
	        $(layerGF).click(function (event) { LoadAllZone(); HidePopup(); });
	        $(layerGF1).click(function (event) {
	            if ($('#div-GFUp').css('display') == 'block')
	                $('#div-allgf').html('|&nbsp;&nbsp;&nbsp;▼');
	            else
	                $('#div-allgf').html('|&nbsp;&nbsp;&nbsp;▲');
	            ShowPoiGroup(twopoint + "/main/getGroup.php?tpoint=" + twopoint, "div-GFUp", "div-GF", "div-gfimg", 2, 1, ShowHideZone, "490");
	            HidePopup();
	        });
	        
	    	$(layerGF).mousemove(function (event) { ShowPopup(event, dic("showGeoFence", lang)) });
	    	$(layerGF1).mousemove(function (event) { ShowPopup(event, dic("chooseGroupGF", lang)) });
	    	$(layerGF).mouseout(function () { HidePopup() });
	    	$(layerGF1).mouseout(function () { HidePopup() });
		} else
		{
			var layerGFButton = Create(el, 'div', 'div-layer-GFButton-' + num);
        	$(layerGFButton).css({ position: 'relative', float: 'left', left: '20px', zIndex: '8003', width: '50px', height: '25px' });
        	layerGFButton.className = 'corner15 text3';

        	var layerGF = Create(layerGFButton, 'div', 'div-layer-gfb')
			$(layerGF).html('<a id="icon-draw-zone" style="left: 0px; top: 0px" href="javascript:"></a><a id="icon-zone-down" style="left: 22px; top: 0px" href="javascript:"></a>&nbsp;');
		}
    }
}

function ShowPOIButton(el, num) {
    if (ShowPOIBtn) {
        var h = el.offsetHeight - 10
		if (Browser() != 'iPad') {
        	var layerPOIButton = Create(el, 'div', 'div-layer-POIButton-' + num);
        	$(layerPOIButton).css({ position: 'relative', float: 'left', left: '20px', zIndex: '8004', width: '130px', height: '25px' });
        	layerPOIButton.className = 'corner15 text3';

        	var layerPOI = Create(layerPOIButton, 'div', 'div-layer-poib')
		
	        $(layerPOI).css({ display: 'block', position: 'relative', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 15px', width: '100px', cursor: 'pointer', textAlign: 'left' })
	        layerPOI.className = 'corner15 text3';
	        $('#div-layer-poib').html(dic("showPOIbtn", lang) + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
	
	        var layerPOI1 = Create(layerPOIButton, 'div', 'div-allpoi');
	        $(layerPOI1).css({ display: 'block', position: 'absolute', zIndex: '8001', fontSize: '11px', backgroundColor: 'transparent', color: '#fff', left: '92px', top: '1px', width: '15px', cursor: 'pointer' })
	        $('#div-allpoi').html('|&nbsp;&nbsp;&nbsp;▼');
	
	        var layerPOI2 = Create(layerPOIButton, 'div', 'div-poiimg');
	        $(layerPOI2).css({ display: 'block', position: 'absolute', zIndex: '8001', borderRadius: '100px', backgroundColor: 'red', left: '5px', top: '5px', height: '7px', width: '7px' });
	
	        $(layerPOI).click(function (event) { LoadAllPOI('All', num); HidePopup(); });
	        $(layerPOI1).click(function (event) {
	            if ($('#div-poiGUp').css('display') == 'block')
	                $('#div-allpoi').html('|&nbsp;&nbsp;&nbsp;▼');
	            else
	                $('#div-allpoi').html('|&nbsp;&nbsp;&nbsp;▲');
	            ShowPoiGroup(twopoint + "/main/getGroup.php?tpoint=" + twopoint, "div-poiGUp", "div-poiG", "div-poiimg", 3, 1, ShowPOI, "360");
	            HidePopup();
	        });
	
			
        	$(layerPOI).mousemove(function (event) { ShowPopup(event, dic("showPoi", lang)) });
        	$(layerPOI1).mousemove(function (event) { ShowPopup(event, dic("chooseGroupPoi", lang)) });
        	$(layerPOI).mouseout(function () { HidePopup() });
        	$(layerPOI1).mouseout(function () { HidePopup() });
    	} else
    	{
			var layerPOIButton = Create(el, 'div', 'div-layer-POIButton-' + num);
        	$(layerPOIButton).css({ position: 'relative', float: 'left', left: '20px', zIndex: '8004', width: '50px', height: '25px' });
        	layerPOIButton.className = 'corner15 text3';

        	var layerPOI = Create(layerPOIButton, 'div', 'div-layer-poib')
		
    		$(layerPOI).html('<a id="icon-poi" style="left: 0px; top: 0px" href="javascript:"></a><a id="icon-poi-down" style="left: 22px; top: 0px" href="javascript:"></a>&nbsp;');
		}
    }
}

function AddNewButton(el, num) {

    var layerNewButton = Create(el, 'div', 'div-layer-NewButton-' + num);
    $(layerNewButton).css({ position: 'relative', float: 'left', left: '20px', zIndex: '8009', width: '90px', height: '25px' });
    layerNewButton.className = 'corner15 text3';


    var btnAddArea = Create(layerNewButton, 'div', 'addNew-button-' + num)
    $(btnAddArea).css({ display: 'block', position: 'absolute', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 5px', width: '70px', cursor: 'pointer', textAlign: 'center' })
    btnAddArea.className = 'corner15 text3'
    btnAddArea.innerHTML = ' + ' + dic("add", lang) + '&nbsp;&nbsp;▼'

    var layerList = Create(layerNewButton, 'div', 'div-add-list-' + num)
    $(layerList).css({ display: 'none', position: 'absolute', zIndex: '7999', backgroundColor: '#387cb0', color: '#fff', top: '19px', padding: '2px 5px 2px 5px', width: '140px', cursor: 'pointer', textAlign: 'left' });
    layerList.className = 'cornerAdd1 text3';
    var strList = '';
    if(allowgarmin > 0)
        strList = strList + '<div id="add-31-' + num + '" onclick="ButtonAddGarminClick(event,' + num + ')" style="" class="menuAdd_layer">&nbsp;&nbsp;' + dic("garmin", lang) + '</div>';
    if (AllowAddZone == "true" || AllowAddZone == "1") {
	    strList = strList + '<div id="add-1-' + num + '" onclick="StartDrawingNewPolygon(' + num + ', 2)" style="" class="menuAdd_layer">&nbsp;&nbsp;' + dic("GeoFence", lang) + '</div>';
	    strList = strList + '<div id="save2-button-' + num + '" onclick="SaveNewArea(' + num + ', 2)" style="left: 10px; margin: -2px 2px 2px 0px; padding: 2px 12px 2px 5px;" class="menuAdd_layer1">&nbsp;&nbsp;' + dic("Save", lang) + '</div>';
	    strList = strList + '<div id="separator2-button-' + num + '" style="width: 1px; top: -1px; left: 9px;" class="menuAdd_layer1"><strong>|</strong></div>';
	    strList = strList + '<div id="cancel2-button-' + num + '" onclick="CancelDrawingArea(' + num + ', 2)" style="left: 10px; margin: -2px 2px 2px 2px; padding: 2px 10px 2px 2px;" class="menuAdd_layer1">&nbsp;&nbsp;' + dic("cancel", lang) + '</div>';
    }
    
    strList = strList + '<div id="add-2-' + num + '" style="margin-bottom: 7px;" onclick="AddPOIPolygon(' + num + ')" class="menuAdd_layer">&nbsp;&nbsp;' + dic("Pois", lang) + '</div>';
    
    if (AllowAddPoi == "true" || AllowAddPoi == "1") {
        strList = strList + '<div id="add-21-' + num + '" onclick="" style="margin-top: -5px; left: 10px; display: none;" class="menuAdd_layer">&nbsp;&nbsp;' + dic("Poi", lang) + '</div>';
	}
    if (AllowAddPolygon == "true" || AllowAddPolygon == "1") {
        strList = strList + '<div id="add-22-' + num + '" onclick="StartDrawingNewPolygon(' + num + ', 3)" style="margin-top: 0px; margin-bottom: 7px; left: 11px; display: none;" class="menuAdd_layer">&nbsp;&nbsp;' + dic("Settings.Polygon", lang) + '</div>';
	    strList = strList + '<div id="save3-button-' + num + '" onclick="SaveNewArea(' + num + ', 3)" style="left: 20px; margin: -8px 2px 2px 0; padding: 2px 12px 2px 5px;" class="menuAdd_layer1">&nbsp;&nbsp;' + dic("Save", lang) + '</div>';
	    strList = strList + '<div id="separator3-button-' + num + '" style="width: 1px; top: -6px; left: 19px;" class="menuAdd_layer1"><strong>|</strong></div>';
	    strList = strList + '<div id="cancel3-button-' + num + '" onclick="CancelDrawingArea(' + num + ', 3)" style="left: 20px; margin: -7px 2px -2px; padding: 2px 10px 2px 2px;" class="menuAdd_layer1">&nbsp;&nbsp;' + dic("cancel", lang) + '</div>';
    }
    layerList.innerHTML = '<div style="height:2px"></div>' + strList + '<div style="height:2px"></div>';
    $(btnAddArea).click(function (event) { ShowAddList(num) });
    $('#add-21-' + num).click(function (event) { ButtonAddPOIClick(event, num) });
    

    if (Browser()!='iPad') {
    	$(btnAddArea).mousemove(function (event) { ShowPopup(event, '' + dic("AddGFPoi", lang) + '') });
    	$(btnAddArea).mouseout(function () { HidePopup() });
	}
}
function AddPOIPolygon(num)
{
	if($('#add-21-' + num).css('display') == 'none')
	{
		$('#add-21-' + num).css({ display: 'block' });
		$('#add-22-' + num).css({ display: 'block' });
	} else
	{
		$('#add-21-' + num).css({ display: 'none' });
		$('#add-22-' + num).css({ display: 'none' });
		CancelDrawingArea(num, 3);
		Boards[num].style.cursor = 'default';
        $('#add-21-' + num).html("&nbsp;&nbsp;" + dic("Poi", lang) + "");
	}
}

function ShowAddList(num) {
    var disp = document.getElementById('div-add-list-' + num).style.display;
    if (disp == 'none') {
        $('#addNew-button-' + num).html(" + " + dic("add", lang) + "&nbsp;&nbsp;▲");
        document.getElementById('div-add-list-' + num).style.display = 'block'
        document.getElementById('addNew-button-' + num).className = 'cornerAdd text3';
        document.getElementById('addNew-button-' + num).style.borderBottom = '1px Solid White';
    } else {
        $('#addNew-button-' + num).html(" + " + dic("add", lang) + "&nbsp;&nbsp;▼");
        document.getElementById('div-add-list-' + num).style.display = 'none';
        document.getElementById('addNew-button-' + num).className = 'corner15 text3';
        document.getElementById('addNew-button-' + num).style.borderBottom = '';
    }
}

function AddDrawButton(el, num) {
    //if (ShowAreaIcons == false) return 
    //if (OpenForDrawing==true){

    var btnAddArea = Create($(el).children()[0], 'div', 'add-button-' + num)
    $(btnAddArea).css({ display: 'block', position: 'absolute', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', left: '200px', top: '7px', padding: '2px 5px 2px 5px', width: '120px', cursor: 'pointer', textAlign: 'center' })
    btnAddArea.className = 'corner15 text3'
    btnAddArea.innerHTML = ' + ' + dic("AddGF", lang) + ''
    btnAddArea.setAttribute("onclick", "StartDrawingNewArea(" + num + ")");

    var btnSaveNewArea = Create($(el).children()[0], 'div', 'save1-button-' + num)
    $(btnSaveNewArea).css({ display: 'none', position: 'absolute', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', left: '200px', top: '29px', padding: '2px 5px 2px 5px', width: '55px', cursor: 'pointer', textAlign: 'center' })
    btnSaveNewArea.className = 'corner15 text3'
    btnSaveNewArea.innerHTML = 'Save'
    btnSaveNewArea.setAttribute("onclick", "SaveNewArea(" + num + ")");


    var btnCancelNewArea = Create($(el).children()[0], 'div', 'cancel1-button-' + num)
    $(btnCancelNewArea).css({ display: 'none', position: 'absolute', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', left: '265px', top: '29px', padding: '2px 5px 2px 5px', width: '55px', cursor: 'pointer', textAlign: 'center' })
    btnCancelNewArea.className = 'corner15 text3'
    btnCancelNewArea.innerHTML = 'Cancel'
    btnCancelNewArea.setAttribute("onclick", "CancelDrawingArea(" + num + ")");

    //if (JustSave == false) {

    //		    var btnModifyArea = Create($(el).children()[0], 'div', 'edit-button-')
    //		    $(btnModifyArea).css({ display: 'block', position: 'absolute', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', left: '340px', top: '57px', padding: '2px 5px 2px 5px', width: '130px', cursor: 'pointer', textAlign: 'center' })
    //		    btnModifyArea.className = 'corner15 text3'
    //		    btnModifyArea.innerHTML = ' Modify existing GeoFence'
    //		    btnModifyArea.setAttribute("onclick", "ShowGeoFenceList()")

    //		    var btnSaveArea = Create($(el).children()[0], 'div', 'save2-button-')
    //		    $(btnSaveArea).css({ display: 'none', position: 'absolute', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', left: '340px', top: '79px', padding: '2px 5px 2px 5px', width: '60px', cursor: 'pointer', textAlign: 'center' })
    //		    btnSaveArea.className = 'corner15 text3'
    //		    btnSaveArea.innerHTML = 'Save'
    //		    btnSaveArea.setAttribute("onclick", "SaveModifyArea()")


    //		    var btnCancelArea = Create($(el).children()[0], 'div', 'cancel2-button-')
    //		    $(btnCancelArea).css({ display: 'none', position: 'absolute', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', left: '410px', top: '79px', padding: '2px 5px 2px 5px', width: '60px', cursor: 'pointer', textAlign: 'center' })
    //		    btnCancelArea.className = 'corner15 text3'
    //		    btnCancelArea.innerHTML = 'Cancel'
    //		    btnCancelArea.setAttribute("onclick", "Cancel2Click()")



    //		    var btnModifyAlarms = Create($(el).children()[0], 'div', 'edit-button-')
    //		    $(btnModifyAlarms).css({ display: 'block', position: 'absolute', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', left: '490px', top: '57px', padding: '2px 5px 2px 5px', width: '90px', cursor: 'pointer', textAlign: 'center' })
    //		    btnModifyAlarms.className = 'corner15 text3'
    //		    btnModifyAlarms.innerHTML = ' Modify alarms'
    //		    btnModifyAlarms.setAttribute("onclick", "ShowGeoFenceListAlarms()")
    //}

    //} //end prviot if
}

function CancelDrawingArea(num, _n) {
    $('#add-button-' + num).css({ color: '#ffffff', cursor: 'pointer' })
    $('#save'+_n+'-button-' + num).css({ display: 'none' });
    $('#cancel'+_n+'-button-' + num).css({ display: 'none' });
    $('#separator'+_n+'-button-' + num).css({ display: 'none' });
    ClearGraphic(_n)
    toggleControl('polygon', false, num);
    controls[num].select.activate();
}
function CreateAlGeoFence() {
    /*
        <div id="div-al-GeoFence" style="display: none;" title="Alert GeoFence">
	        <span class="ui-icon ui-icon-alert" style="position: absolute; left: 11px; top: 7px;"></span>
            <div align="center" style="font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;Test TEst TEst</div><br />
            <span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;">Enter password: </span>
            <input id="alGeoFencePass" type="password" class="textboxCalender corner5" style="width:150px" /><br /><br />
        </div>
    */

    var _temp = document.createElement('div');
    _temp.setAttribute("id", "div-al-GeoFence");
    _temp.title = dic("alerttGF", lang);
    _temp.style.display = "none";
    document.body.appendChild(_temp);

    var _temp1 = document.createElement("span");
    _temp1.className = "ui-icon ui-icon-alert";
    _temp1.style.position = "absolute";
    _temp1.style.top = "12px";
    _temp1.style.left = "15px";
    _temp.appendChild(_temp1);

    _temp1 = document.createElement('div');
    _temp1.style.fontsize = "14px";
    _temp1.style.width = "250px";
    _temp1.style.paddingLeft = "20px";
    _temp1.style.paddingBottom = "15px";
    _temp1.style.textAlign = "center";
    _temp1.innerHTML = dic("dinara5", lang);
    _temp.appendChild(_temp1);

    _temp1 = document.createElement("span");
    _temp1.style.paddingTop = "7px";
    _temp1.style.marginLeft = "15px";
    _temp1.style.width = "90px";
    _temp1.innerHTML = dic("EnterPass", lang);
    _temp.appendChild(_temp1);

    _temp1 = document.createElement('input');
    _temp1.setAttribute("id", "alGeoFencePass");
    _temp1.type = "password";
    _temp1.marginLeft = "5px";
    _temp1.className = "textboxCalender corner5";
    _temp1.style.width = "150px";
    _temp.appendChild(_temp1);
}

function validacija(){
	var emails = $('#txt_emails').val();
	var emailovi = emails.split(",");
	var izlez;
	emailovi.forEach(function (mejl) {
		var filter = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
			izlez = filter.test(mejl.trim());
		});
	return izlez;
}

function SaveNewArea(num, _n) {
    if (vectors[num].features.length == 0) {
        msgbox(dic("NoGF", lang));
        return
    }
    
    document.getElementById('vozila').selectedIndex = 0;
    OptionsChangeVehicle();
    
    
    $('#GFcheck1').attr({ checked: 'checked' });
    $('#GFcheck2').attr({ checked: '' });
    $('#GFcheck3').attr({ checked: '' });
    
    
    $('#alVlez').attr('checked', false);
    $('#alIzlez').attr('checked', false);
    
    $('#alVlez').click(function(){ $(this).blur(); });
	$('#alIzlez').click(function(){ $(this).blur(); });
    
    $('#txt_zonename').val('');
    $('#txt_phones').val('');
    $('#txt_emails').val('');
    $('#gfAvail').buttonset();
    $('#AddGroup1').button();
    $('#alertINOUT').buttonset();
    $("#gfGroup dt a")[0].title = "";
    $("#gfGroup dt a span").html(dic("selGroup", lang));
    $('#txt_zonename').focus();
    controls[num].modify.deactivate();
    //debugger;
    //if(_n == "1")
    	//$('#div-enter-zone-name').attr('title', '<font class="text2" style="font-size: 18px"><b>'+dic("AddGF", lang)+'</b></font>');
	//else
		//$('#div-enter-zone-name').attr('title', '<font class="text2" style="font-size: 18px"><b>Нов полигон</b></font>');
	if(_n == "2")
		var mes = '<font class="text2" style="font-size: 18px"><b>'+dic("AddGF", lang)+'</b></font>';
	else
		var mes = '<font class="text2" style="font-size: 18px"><b>'+dic("AddPolygon", lang)+'</b></font>';
    $('#div-enter-zone-name').dialog({ modal: true, zIndex: 9999, width: 620, height: 460, resizable: false,
        buttons:
            [
                {
                    text: dic("Save", lang),
                    click: function () {
                    	if (AllowAddZone == false) { return false }
                        if ($('#txt_zonename').val() == '') {
                            msgbox(dic("EnterGFName", lang))
                            return false
                        }
						
                        if ($('#gfGroup dt a')[0].title == '') {
                            msgbox(dic("SelectGroup", lang))
                            return false
                        }
                        if($('#alVlez').attr('checked') || $('#alIzlez').attr('checked'))
                        {
                        	if($('#vozila').attr('selectedIndex') == 0)
                        	{
                        		msgbox("Немате изберено група на која ке се внесе алармот!");
                            	return false;
                        	}
                        	if($('#txt_emails').val() == "" && $('#txt_phones').val() == "")
                        	{
                        		msgbox(dic("Settings.AlertsEmailHaveTo",lang));
                            	return false;
                        	}
                        }
                        if($('#txt_emails').val().length > 0 && !validacija())
                        {
                        	msgbox(dic("uncorrEmail",lang));
                        	return false;
                        }
                        if ($('#txt_phones').val() != '') {
                            var _alGF = document.getElementById("div-al-GeoFence");
                            if (_alGF == null)
                                CreateAlGeoFence();
                            $('#btnCancelAlGeoFence').button();
                            $('#btnYesAlGeoFence').button();
                            $('#alGeoFencePass').val('');
                            $('#div-al-GeoFence').dialog({ modal: true, zIndex: 9999, resizable: false,
                                buttons:
                                [
                                    {
                                        text: "Ok",
                                        click: function () {
                                            ShowWait();
                                            $.ajax({
                                                url: twopoint + "/main/checkPassword.php?pass=" + encodeURIComponent($('#alGeoFencePass').val()) + "&tpoint=" + twopoint,
                                                context: document.body,
                                                success: function (data) {
                                                    if (data.indexOf("Wrong") != -1) {
                                                        HideWait();
                                                        msgbox(dic("WrongPass", lang));
                                                    } else {
                                                        /*var strPoints = 'POLYGON((';
							                            for (var i = 0; i < selectedFeature[SelectedBoard].geometry.components[0].components.length; i++) {
							                                if(i == (selectedFeature[SelectedBoard].geometry.components[0].components.length - 1))
							                            	{
							                            		strPoints += selectedFeature[SelectedBoard].geometry.components[0].components[0].y + ' ' + selectedFeature[SelectedBoard].geometry.components[0].components[0].x;
							                                } else
							                                {	
							                                	var _point = selectedFeature[SelectedBoard].geometry.components[0].components[i]
							                                	_point.transform(Maps[num].getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
							                                	strPoints += _point.y + ' ' + _point.x + ",";
							                                }
							                            }
							                            strPoints += "))";*/
							                           	var strPoints = ''
	                                                    for (var i = 0; i < selectedFeature[SelectedBoard].geometry.components[0].components.length; i++) {
	                                                    	if(i == (selectedFeature[SelectedBoard].geometry.components[0].components.length - 1))
							                            	{
							                            		strPoints = strPoints + '^' + selectedFeature[SelectedBoard].geometry.components[0].components[0].x + '@' + selectedFeature[SelectedBoard].geometry.components[0].components[0].y;
							                                } else
							                                {
	                                                        	var _point = selectedFeature[SelectedBoard].geometry.components[0].components[i]
	                                                        	_point.transform(Maps[0].getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
	                                                        	strPoints = strPoints + '^' + _point.x + '@' + _point.y;
                                                        	}
	                                                    }
                                                        SavingNewArea(strPoints, _n);
                                                    }

                                                }
                                            });
                                        }
                                    },
                                    {
                                        text: dic("cancel", lang),
                                        click: function () {
                                            $('#div-al-GeoFence').dialog('destroy');
                                            $('#txt_phones').val('');
                                        }
                                    }
                                ]
                            });
                        } else {
                            ShowWait();
                            /*var strPoints = 'POLYGON((';
                            for (var i = 0; i < selectedFeature[SelectedBoard].geometry.components[0].components.length; i++) {
                                if(i == (selectedFeature[SelectedBoard].geometry.components[0].components.length - 1))
                            	{
                            		strPoints += selectedFeature[SelectedBoard].geometry.components[0].components[0].y + ' ' + selectedFeature[SelectedBoard].geometry.components[0].components[0].x;
                                } else
                                {	
                                	var _point = selectedFeature[SelectedBoard].geometry.components[0].components[i]
                                	_point.transform(Maps[num].getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
                                	strPoints += _point.y + ' ' + _point.x + ",";
                                }
                            }
                            strPoints += "))";*/
                           
                           	var strPoints = ''
                            for (var i = 0; i < selectedFeature[SelectedBoard].geometry.components[0].components.length; i++) {
                            	if(i == (selectedFeature[SelectedBoard].geometry.components[0].components.length - 1))
                        		{
                        			strPoints = strPoints + '^' + selectedFeature[SelectedBoard].geometry.components[0].components[0].x + '@' + selectedFeature[SelectedBoard].geometry.components[0].components[0].y;
                                } else
                                {
                                	var _point = selectedFeature[SelectedBoard].geometry.components[0].components[i]
                                	_point.transform(Maps[0].getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
                                	strPoints = strPoints + '^' + _point.x + '@' + _point.y;
                                }
                            }
                            
                            SavingNewArea(strPoints, _n);
                        }
                    }

                }, //Save
                {
                text: dic("cancel", lang),
                click: function () {
                    //CancelDrawingArea() 
                    controls[num].modify.activate();
                    controls[num].modify.selectControl.clickFeature(selectedFeature[num]);

                    $('#div-enter-zone-name').dialog('destroy');
                }
            } // Cancel
            ] // Buttons
            ,
            "title": mes
    })
    //CancelDrawingArea()
}
function StartDrawingNewArea(num){
    if ($('#addNew-button-' + num).css("color") + '' == 'rgb(255, 255, 255)') {
        var GFI = getCookie(_userId + "_gfinfo");
        if (GFI != "1") {
            $("#DivInfoForAll").css({ display: 'block' });
            msgboxN(dic("ClickDraw", lang) + '<br><br>' + dic("EndDraw", lang), "_gfinfo");
        }
        onFeatureUnselect('0');
        for (var i = 0; i < 4; i++)
            if (Boards[i] != null && i != num)
                CancelDrawingArea(i);
        //$('#add-button-' + num).css({ color: '#000066', cursor: 'default' });
        $('#save1-button-' + num).css({ display: 'block' });
        $('#cancel1-button-' + num).css({ display: 'block' });
        $('#separator-button-' + num).css({ display: 'block' });
        
        ClearGraphic();
        toggleControl('polygon', true, num);
    } else {
        //$('#add-button-').css({color:'#ffffff', cursor:'pointer'})
        //$('#save1-button-').css({display:'none'})
        //$('#cancel1-button-').css({display:'none'})		
    }
	
}
function StartDrawingNewPolygon(num, _n){
	if(_n == "2")
		CancelDrawingArea(num, 3);
	else
		CancelDrawingArea(num, 2);
    if ($('#addNew-button-' + num).css("color") + '' == 'rgb(255, 255, 255)') {
        var GFI = getCookie(_userId + "_gfinfo");
        if (GFI != "1") {
            $("#DivInfoForAll").css({ display: 'block' });
            msgboxN(dic("ClickDraw", lang) + '<br><br>' + dic("EndDraw", lang), "_gfinfo");
        }
        onFeatureUnselect('0', _n);
        for (var i = 0; i < 4; i++)
            if (Boards[i] != null && i != num)
                CancelDrawingArea(i, _n);
        //$('#add-button-' + num).css({ color: '#000066', cursor: 'default' });
        $('#save'+_n+'-button-' + num).css({ display: 'block' });
        $('#cancel'+_n+'-button-' + num).css({ display: 'block' });
        $('#separator'+_n+'-button-' + num).css({ display: 'block' });
        
        ClearGraphic(_n);
        toggleControl('polygon', true, num);
    }
	
}

function AddLayerRoute(el, num) {
	if(Browser() == 'iPad')
		var _le = '520';
	else
		var _le = $('#div-map-1')[0].offsetWidth - 100;
    var layerButton = Create($(el).children()[0], 'div', 'div-layer-NormalFast-' + num);
    $(layerButton).css({ display: 'block', position: 'absolute', zIndex: '7000', backgroundColor: 'transparent', color: '#fff', left: _le + 'px', top: '20px', width: '224px', height: 'auto', textAlign: 'left' });
    layerButton.className = 'text3';
	
	$(layerButton).html('<input type="checkbox" id="opt" style="position:relative; left:-5px"/><label id="Label3" for="opt" style="position:relative; top:-1px; width:102px">'+dic("Routes.Optimized")+'</label><br><div id="radioBtnDiv"><input type="radio" runat="server" name="testGroup" value="1" id="test1" checked /><label id="Label1" for="test1" style="cursor:hand; width:50px" runat="server">'+dic("Routes.Short")+'</label><input type="radio" runat="server" name="testGroup" value="2" id="test2" /><label id="Label2" for="test2" style="cursor:hand; width:50px" runat="server">' + dic("Routes.Fast") + '</label></div>');
	$('#Label1').mousemove(function (event) { ShowPopup(event, dic("Routes.ShortestTooltip",lang)) });
    $('#Label1').mouseout(function () { HidePopup() })
    
    $('#Label2').mousemove(function (event) { ShowPopup(event, dic("Routes.FastestTooltip",lang)) });
    $('#Label2').mouseout(function () { HidePopup() })
    
	$('#Label3').mousemove(function (event) { ShowPopup(event, dic("Routes.OptimizedTooltip",lang)) });
    $('#Label3').mouseout(function () { HidePopup() })
	$('#test1').button();
    $('#test2').button();
    $('#opt').button();
    $("input[name='testGroup']", $('#radioBtnDiv')).change(
    function (e) {
        // your stuffs go here
        $("#Label1").removeClass("ui-state-focus");	
        $("#Label2").removeClass("ui-state-focus");	
        
        if ($('#MarkersIN')[0].children.length > 1) {
            ReDrawRoute1($(this).val());
        }
    });
    //var layerButton1 = Create(layerButton, 'div', 'div-layer-NormalFast');
    //$(layerButton1).css({ position: 'relative', float: 'left', zIndex: '8008', left: '20px', width: '80px', height: '25px' });
    //layerButton1.className = 'corner15 text3';
    
}

function AddLayerSwitcher(el, num) {
    if (parseInt(el.offsetWidth, 10) < 650)
        var _w = parseInt(el.offsetWidth, 10) - 50;
    else
        if (ShowGFBtn)
            var _w = 650;
        else
            var _w = 610;
    
    var layerSwitcher = Create($(el).children()[0], 'div', 'div-layer-icons-' + num);
    if(RecOn)
		_t = '10px';
	else
		if(RecOnNew || RecOnNewAll)
			_t = '10px';
		else
			_t = '25px';

	if ((Browser() == 'iPad' && ShowGFBtn))
		_w = 650;
	if(Routing == true)
		_w = $('#div-map-1')[0].offsetWidth - 150;
		
    $(layerSwitcher).css({ display: 'block', position: 'absolute', zIndex: '8000', backgroundColor: 'transparent', color: '#fff', left: '35px', top: _t, width: _w + 'px', height: 'auto', textAlign: 'left' });
    layerSwitcher.className = 'corner15 text3';

    AddMapType(layerSwitcher, num);
    AddNewButton(layerSwitcher, num);
    AddRuler(layerSwitcher, num);
    AddSearchButton(layerSwitcher, num);
    AddVehicleToFollow(layerSwitcher, num);
    AddVehicleChooser(layerSwitcher, num);
    ShowPOIButton(layerSwitcher, num);
    ShowGFButton(layerSwitcher, num);
    AddDirections(layerSwitcher, num);
    if(RecOnNewAll)
        AddRecNewLayer(layerSwitcher, num);
}
function PlayForwardNew(){
	if (!PlayForwardRec || PlayBackRec) {
		$('#PlayForwardNew').css({ backgroundColor: '#FFFFFF', color: '#387cb0' });
		$('#PlayBackNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
		$('#PauseNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
        PlayForwardRec = true;
        PlayBackRec = false;
        RecStert(IndexRec);
    }
}
function PlayBackNew(){
	if (!PlayBackRec || PlayForwardRec) {
		$('#PlayBackNew').css({ backgroundColor: '#FFFFFF', color: '#387cb0' });
		$('#PauseNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
		$('#PlayForwardNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
        PlayBackRec = true;
        PlayForwardRec = false;
        RecStartBack(IndexRec - 2);
    }
}
function PauseClickNew()
{
	$('#PauseNew').css({ backgroundColor: '#FFFFFF', color: '#387cb0' });
	$('#PlayBackNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
	$('#PlayForwardNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
	PlayForwardRec = false;
    PlayBackRec = false;
}
function PlayForwardNew1(){
	if (!PlayForwardRec || PlayBackRec) {
		$('#PlayForwardNew').css({ backgroundColor: '#FFFFFF', color: '#387cb0' });
		$('#PlayBackNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
		$('#PauseNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
        PlayForwardRec = true;
        PlayBackRec = false;
        RecStertNew(IndexRec);
        //moveCharPlay();
    }
}
function PlayBackNew1(){
	if (!PlayBackRec || PlayForwardRec) {
		$('#PlayBackNew').css({ backgroundColor: '#FFFFFF', color: '#387cb0' });
		$('#PauseNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
		$('#PlayForwardNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
        PlayBackRec = true;
        PlayForwardRec = false;
        RecStartBackNew(IndexRec - 1);
        //moveCharBack();
    }
}
function PauseClickNew1()
{
	$('#PauseNew').css({ backgroundColor: '#FFFFFF', color: '#387cb0' });
	$('#PlayBackNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
	$('#PlayForwardNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
	PlayForwardRec = false;
    PlayBackRec = false;
    window.clearTimeout(TIMEOUTREC);
    //moveCharPause();
}
function AddLayerPlayNew(el, num) {

    if (parseInt(el.offsetWidth, 10) < 550)
        var _w = parseInt(el.offsetWidth, 10) - 50;
    else
        if (ShowGFBtn)
            var _w = 755;
        else
            var _w = 655;
    
	var _top = 40;
	
    var layerSwitcherF = Create($(el).children()[0], 'div', 'div-layer-playsF-' + num);
    $(layerSwitcherF).css({ display: 'block', position: 'absolute', zIndex: '7000', backgroundColor: 'transparent', color: '#fff', left: '35px', top: _top+'px', width: _w + 'px', height: 'auto', textAlign: 'left' });
    layerSwitcherF.className = 'corner15 text3';

	var layerSwitcher007 = Create(layerSwitcherF, 'div', 'div-layer-plays007-' + num);
    $(layerSwitcher007).css({ display: 'block', position: 'absolute', borderRadius: '15px 15px 15px 15px',  zIndex: '7000', backgroundColor: '#387cb0', color: '#fff', left: '19px', top: '0px', width: '63px', padding: '2px 5px', height: '15px', textAlign: 'left' });
    layerSwitcher007.className = 'text3';
	layerSwitcher007.innerHTML = '<div id="PlayBackNew" onclick="PlayBackNew1()" style="font-size: 14px; float: left; top: -1px; left: -4px; position: relative; cursor: pointer; background-color: #; border-radius: 15px 0px 0px 15px; color: #FFFFFF; height: 17px; width: 17px; padding-left: 5px;">◀</div>';
	layerSwitcher007.innerHTML += '<div id="PauseNew" onclick="PauseClickNew1()" style="font-size: 14px; float: left; top: -1px; left: -3px; position: relative; cursor: pointer; background-color: #; color: #FFFFFF; height: 17px; width: 14px; padding-left: 9px; padding-right: 2px;">||</div>';
	layerSwitcher007.innerHTML += '<div id="PlayForwardNew" onclick="PlayForwardNew1()" style="font-size: 14px; float: right; top: -18px; left: 4px; position: relative; cursor: pointer; background-color: #FFFFFF; border-radius: 0 15px 15px 0; color: #387CB0; height: 17px; width: 9px; padding-left: 6px; padding-right: 7px;">▶</div>';

	var layerSwitcher = Create(layerSwitcherF, 'div', 'div-layer-plays-' + num);
    $(layerSwitcher).css({ display: 'block', position: 'absolute', borderRadius: '15px 15px 15px 15px',  zIndex: '7000', backgroundColor: '#387cb0', color: '#fff', left: '105px', top: '5px', width: '150px', height: '7px', textAlign: 'left' });
    layerSwitcher.className = 'text3';
	
	$(layerSwitcher).slider({
		value:600,
		min: 200,
		max: 1000,
		step: 1,
		animate: true,
		slide: function( event, ui ) {
			SpeedRec = 1000 - Math.abs(parseInt(ui.value, 10));
			//debugger;
			$(ui.handle).blur();
		},
		change: function( event, ui ) { $(ui.handle).blur(); }
		}
	);
	//$(layerSwitcher)[0].children[0].innerHTML = '<div style="font-size: 12px; position: relative; top: -3px;">▶ <font style="position: relative; top: 1px;">x200</font></div>';
	$($(layerSwitcher)[0].children[0]).css({ cursor: 'pointer', opacity: '1', top: '-4px', border: '1px solid #387cb0' });
	$($(layerSwitcher)[0].children[0]).mousemove(function () { $(this).css({ border: '1px solid White' }) });
	$($(layerSwitcher)[0].children[0]).mouseout(function () { $(this).css({ border: '1px solid #387cb0' }) });
    /*PlayBack(layerSwitcher, num, '<strong>x3</strong> ◀', '200', dic("back", lang) + ' x3');
    PlayBack(layerSwitcher, num, '<strong>x2</strong> ◀', '500', dic("back", lang) + ' x2');
    PlayBack(layerSwitcher, num, '◀', '1000', dic("back", lang));
    Pause(layerSwitcher, num);
    Play(layerSwitcher, num, '▶', '1000', dic("forward", lang));
    Play(layerSwitcher, num, '▶ <strong>x2</strong>', '500', dic("forward", lang) + ' x2');
    Play(layerSwitcher, num, '▶ <strong>x3</strong>', '200', dic("forward", lang) + ' x3');*/
	
    AddVehicleToFollow(layerSwitcher, num);
    AddVehicleChooser(layerSwitcher, num);
}
function AddLayerPlay(el, num) {

    if (parseInt(el.offsetWidth, 10) < 550)
        var _w = parseInt(el.offsetWidth, 10) - 50;
    else
        if (ShowGFBtn)
            var _w = 755;
        else
            var _w = 655;
    
	var _top = 40;
	
    var layerSwitcherF = Create($(el).children()[0], 'div', 'div-layer-playsF-' + num);
    $(layerSwitcherF).css({ display: 'block', position: 'absolute', zIndex: '7000', backgroundColor: 'transparent', color: '#fff', left: '35px', top: _top+'px', width: _w + 'px', height: 'auto', textAlign: 'left' });
    layerSwitcherF.className = 'corner15 text3';

	var layerSwitcher007 = Create(layerSwitcherF, 'div', 'div-layer-plays007-' + num);
    $(layerSwitcher007).css({ display: 'block', position: 'absolute', borderRadius: '15px 15px 15px 15px',  zIndex: '7000', backgroundColor: '#387cb0', color: '#fff', left: '19px', top: '0px', width: '63px', padding: '2px 5px', height: '15px', textAlign: 'left' });
    layerSwitcher007.className = 'text3';
	layerSwitcher007.innerHTML = '<div id="PlayBackNew" onclick="PlayBackNew()" style="font-size: 14px; float: left; top: -1px; left: -4px; position: relative; cursor: pointer; background-color: #; border-radius: 15px 0px 0px 15px; color: #FFFFFF; height: 17px; width: 17px; padding-left: 5px;">◀</div>';
	layerSwitcher007.innerHTML += '<div id="PauseNew" onclick="PauseClickNew()" style="font-size: 14px; float: left; top: -1px; left: -3px; position: relative; cursor: pointer; background-color: #; color: #FFFFFF; height: 17px; width: 14px; padding-left: 9px; padding-right: 2px;">||</div>';
	layerSwitcher007.innerHTML += '<div id="PlayForwardNew" onclick="PlayForwardNew()" style="font-size: 14px; float: right; top: -18px; left: 4px; position: relative; cursor: pointer; background-color: #FFFFFF; border-radius: 0 15px 15px 0; color: #387CB0; height: 17px; width: 9px; padding-left: 6px; padding-right: 7px;">▶</div>';

	var layerSwitcher = Create(layerSwitcherF, 'div', 'div-layer-plays-' + num);
    $(layerSwitcher).css({ display: 'block', position: 'absolute', borderRadius: '15px 15px 15px 15px',  zIndex: '7000', backgroundColor: '#387cb0', color: '#fff', left: '105px', top: '5px', width: '150px', height: '7px', textAlign: 'left' });
    layerSwitcher.className = 'text3';
	
	$(layerSwitcher).slider({
		value:600,
		min: 200,
		max: 1000,
		step: 1,
		animate: true,
		slide: function( event, ui ) {
			SpeedRec = 1000 - Math.abs(parseInt(ui.value, 10));
			//debugger;
			$(ui.handle).blur();
		},
		change: function( event, ui ) { $(ui.handle).blur(); }
		}
	);
	//$(layerSwitcher)[0].children[0].innerHTML = '<div style="font-size: 12px; position: relative; top: -3px;">▶ <font style="position: relative; top: 1px;">x200</font></div>';
	$($(layerSwitcher)[0].children[0]).css({ cursor: 'pointer', opacity: '1', top: '-4px', border: '1px solid #387cb0' });
	$($(layerSwitcher)[0].children[0]).mousemove(function () { $(this).css({ border: '1px solid White' }) });
	$($(layerSwitcher)[0].children[0]).mouseout(function () { $(this).css({ border: '1px solid #387cb0' }) });
    /*PlayBack(layerSwitcher, num, '<strong>x3</strong> ◀', '200', dic("back", lang) + ' x3');
    PlayBack(layerSwitcher, num, '<strong>x2</strong> ◀', '500', dic("back", lang) + ' x2');
    PlayBack(layerSwitcher, num, '◀', '1000', dic("back", lang));
    Pause(layerSwitcher, num);
    Play(layerSwitcher, num, '▶', '1000', dic("forward", lang));
    Play(layerSwitcher, num, '▶ <strong>x2</strong>', '500', dic("forward", lang) + ' x2');
    Play(layerSwitcher, num, '▶ <strong>x3</strong>', '200', dic("forward", lang) + ' x3');*/
	
    AddVehicleToFollow(layerSwitcher, num);
    AddVehicleChooser(layerSwitcher, num);
}
function Pause(el, num) {
    //if (AllowAddRuler == false) { return false }

    var layerPause = Create(el, 'div', 'div-layer-Pause-' + num);
    $(layerPause).css({ position: 'relative', float: 'left', zIndex: '7008', left: '10px', width: '45px', height: '1px' });
    layerPause.className = 'corner15 text3';

    var h = el.offsetHeight - 10
    var AddPauseBtn = Create(layerPause, 'div', 'div-addPause-' + num)

    $(AddPauseBtn).css({ display: 'block', position: 'relative', zIndex: '7000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 5px', width: '30px', height: '1px', cursor: 'pointer', textAlign: 'center' })
    AddPauseBtn.className = 'corner15 text3'
    AddPauseBtn.innerHTML = '<div style="font-size: 17px; position: relative; top: -5px;">■</div>';
    $(AddPauseBtn).click(function (event) {
        for (var i = 0; i < $('#div-layer-plays-0')[0].children.length; i++) {
            if ($('#div-layer-plays-0')[0].children[i].children[0].id == event.target.id || $('#div-layer-plays-0')[0].children[i].children[0].id == event.target.parentNode.id) {
                var col = '387cb0';
                var bgC = 'fff';
                var bord = '1px solid #387CB0';
            } else {
                var col = 'fff';
                var bgC = '387cb0';
                var bord = '';
            }
            $('#' + $('#div-layer-plays-0')[0].children[i].children[0].id).css({ backgroundColor: '#' + bgC, border: bord, color: '#' + col });
        }
        PlayForwardRec = false;
        PlayBackRec = false;
    });
    if (Browser()!='iPad') {
    	$(AddPauseBtn).mousemove(function (event) { ShowPopup(event, dic("pause", lang)) });
    	$(AddPauseBtn).mouseout(function () { HidePopup() });
	}
}
function Play(el, num, icon, time, popup) {
    //if (AllowAddRuler == false) { return false }

    var layerPlay = Create(el, 'div', 'div-layer-Play-' + time);
    $(layerPlay).css({ position: 'relative', float: 'left', zIndex: '7008', left: '10px', width: '45px', height: '1px' });
    layerPlay.className = 'corner15 text3';


    var h = el.offsetHeight - 10
    var AddPlayBtn = Create(layerPlay, 'div', 'div-addPlay-' + time)

    /*if (time == '1000') {
        var col = '387cb0';
        var bgC = 'fff';
        var bord = '1px solid #387CB0';
    } else {*/
        var col = 'fff';
        var bgC = '387cb0';
        var bord = '';
    //}

    $(AddPlayBtn).css({ display: 'block', position: 'relative', zIndex: '7000', backgroundColor: '#'+bgC, border: bord, color: '#' + col, padding: '2px 5px 2px 5px', width: '30px', height: '1px', cursor: 'pointer', textAlign: 'center' })
    AddPlayBtn.className = 'corner15 text3'
    AddPlayBtn.innerHTML = icon;

    $(AddPlayBtn).click(function (event) {
        for (var i = 0; i < $('#div-layer-plays-0')[0].children.length; i++) {
            if ($('#div-layer-plays-0')[0].children[i].children[0].id == event.target.id || $('#div-layer-plays-0')[0].children[i].children[0].id == event.target.parentNode.id) {
                var col = '387cb0';
                var bgC = 'fff';
                var bord = '1px solid #387CB0';
            } else {
                var col = 'fff';
                var bgC = '387cb0';
                var bord = '';
            }
            $('#' + $('#div-layer-plays-0')[0].children[i].children[0].id).css({ backgroundColor: '#' + bgC, border: bord, color: '#' + col });
        }
        SpeedRec = time;
        if (!PlayForwardRec || PlayBackRec) {
            PlayForwardRec = true;
            PlayBackRec = false;
            RecStert(IndexRec);
        }
    });
    if (Browser()!='iPad') {
    	$(AddPlayBtn).mousemove(function (event) { ShowPopup(event, popup) });
    	$(AddPlayBtn).mouseout(function () { HidePopup() });
	}
}
function PlayBack(el, num, icon, time, popup) {
    //if (AllowAddRuler == false) { return false }

    var layerPlay = Create(el, 'div', 'div-layer-PlayBack-' + time);
    $(layerPlay).css({ position: 'relative', float: 'left', zIndex: '7008', left: '10px', width: '45px', height: '1px' });
    layerPlay.className = 'corner15 text3';


    var h = el.offsetHeight - 10
    var AddPlayBtn = Create(layerPlay, 'div', 'div-addPlayBack-' + time)

    $(AddPlayBtn).css({ display: 'block', position: 'relative', zIndex: '7000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 5px', width: '30px', height: '1px', cursor: 'pointer', textAlign: 'center' })
    AddPlayBtn.className = 'corner15 text3'
    AddPlayBtn.innerHTML = icon;

    $(AddPlayBtn).click(function (event) {
        for (var i = 0; i < $('#div-layer-plays-0')[0].children.length; i++) {
            if ($('#div-layer-plays-0')[0].children[i].children[0].id == event.target.id || $('#div-layer-plays-0')[0].children[i].children[0].id == event.target.parentNode.id) {
                var col = '387cb0';
                var bgC = 'fff';
                var bord = '1px solid #387CB0';
            } else {
                var col = 'fff';
                var bgC = '387cb0';
                var bord = '';
            }
            $('#' + $('#div-layer-plays-0')[0].children[i].children[0].id).css({ backgroundColor: '#' + bgC, border: bord, color: '#' + col });
        }
        SpeedRec = time;
        if (!PlayBackRec || PlayForwardRec) {
            PlayBackRec = true;
            PlayForwardRec = false;
            RecStartBack(IndexRec - 2);
        }
    });
    if (Browser()!='iPad') {
    	$(AddPlayBtn).mousemove(function (event) { ShowPopup(event, popup) });
    	$(AddPlayBtn).mouseout(function () { HidePopup() });
	}
}

function AddBaloon(el, num) {
    var layerBaloon = Create($(el).children()[0], 'div', 'div-layer-baloon-0');
    $(layerBaloon).css({ display: 'block', position: 'absolute', zIndex: '7000', backgroundColor: 'transparent', color: '#fff', left: (document.body.clientWidth - 238) + 'px', top: '52px', width: '248px', height: 'auto', textAlign: 'left' });
}

function AddClosePopUpButton(el, num) {
    var layerCB = Create(el, 'div', 'div-layer-ClosePopUp-' + num);
    $(layerCB).css({ display: 'block', position: 'relative', float: 'right', right: '0px', zIndex: '7000', backgroundColor: 'transparent', top: '0px', width: '80px', height: 'auto' });
    layerCB.className = 'corner15 text3';

    var layerCB1 = Create(layerCB, 'div', 'div-layer-ClosePopup');
    $(layerCB1).css({ position: 'relative', zIndex: '8008', width: '80px', height: '25px' });
    layerCB1.className = 'corner15 text3';
    var AddCPBtn = Create(layerCB1, 'div', 'div-addCPB')
    var col = 'fff';
    var bgC = '387cb0';
    var bord = '';
    $(AddCPBtn).css({ display: 'block', position: 'relative', zIndex: '8000', backgroundColor: '#' + bgC, border: bord, color: '#' + col, padding: '2px 5px 2px 5px', width: '60px', cursor: 'pointer', textAlign: 'center' })
    AddCPBtn.className = 'corner15 text3';
    AddCPBtn.innerHTML = dic('show', lang);
    $(AddCPBtn).click(function (event) {
        if (!ClosePopUp) {
            for (var i = 0; i < map.popups.length; i++)
            	if($($(map.popups[i].div).children().children()[5]).css('display') != 'none')
                	map.popups[i].hide();
            ClosePopUp = true;
            $('#div-addCPB').html(dic('show', lang));
        } else {
            for (var i = 0; i < map.popups.length; i++)
            	if($($(map.popups[i].div).children().children()[5]).css('display') != 'none')
                	map.popups[i].show();
            ClosePopUp = false;
            $('#div-addCPB').html(dic('hide', lang));
        }
    });
}
function AddRecLayer(el, num) {
    var layerRight = Create($(el).children()[0], 'div', 'div-layer-right-' + num);
    $(layerRight).css({ display: 'block', position: 'absolute', zIndex: '7000', backgroundColor: 'transparent', float: 'right', right: '0px', top: '10px', width: '170px', height: 'auto' });
    layerRight.className = 'corner15 text3';

    AddClosePopUpButton(layerRight, 0);
    AddPrintButton(layerRight, 0);
    if(RecMVeh == '1')
        AddDetailButton(layerRight, 0);
}
function AddPrintButton(el, num) {
    var layerPrint = Create(el, 'div', 'div-layer-Print-' + num);
    $(layerPrint).css({ display: 'block', position: 'relative', float: 'right', zIndex: '7000', backgroundColor: 'transparent', right: '5px', top: '0px', width: '75px', height: 'auto' });
    layerPrint.className = 'corner15 text3';

    var layerPrint1 = Create(layerPrint, 'div', 'div-layer-Print');
    $(layerPrint1).css({ position: 'relative', zIndex: '8008', width: '70px', height: '25px' });
    layerPrint1.className = 'corner15 text3';
    var AddPrintBtn = Create(layerPrint1, 'div', 'div-addPrintB')
    var col = 'fff';
    var bgC = '387cb0';
    var bord = '';
    $(AddPrintBtn).css({ display: 'block', position: 'relative', zIndex: '8000', backgroundColor: '#' + bgC, border: bord, color: '#' + col, padding: '2px 5px 2px 5px', width: '60px', cursor: 'pointer', textAlign: 'center' })
    AddPrintBtn.className = 'corner15 text3';
    AddPrintBtn.innerHTML = dic('print', lang);
    $(AddPrintBtn).click(function (event) {
        window.print();
    });
}
function AddDetailButton(el, num) {
    var layerCB = Create(el, 'div', 'div-layer-hidedetail-' + num);
    $(layerCB).css({ display: 'block', position: 'relative', float: 'right', zIndex: '7000', backgroundColor: 'transparent', width: '80px', height: 'auto' });
    layerCB.className = 'corner15 text3';

    var layerCB1 = Create(layerCB, 'div', 'div-layer-hidedetail');
    $(layerCB1).css({ position: 'relative', zIndex: '8008', width: '80px', height: '25px' });
    layerCB1.className = 'corner15 text3';
    var AddCPBtn = Create(layerCB1, 'div', 'div-detail-ballon')
    var col = 'fff';
    var bgC = '387cb0';
    var bord = '';
    $(AddCPBtn).css({ display: 'block', position: 'relative', zIndex: '8000', backgroundColor: '#' + bgC, border: bord, color: '#' + col, padding: '2px 5px 2px 5px', width: '60px', cursor: 'pointer', textAlign: 'center' })
    AddCPBtn.className = 'corner15 text3';
    if(allowedDetail == "1")
    {
    	AddCPBtn.innerHTML = dic('hide', lang);
    	//$('#div-detail-ballon').css({ borderRadius: '10px 10px 0 0' });
    } else
	{
    	AddCPBtn.innerHTML = dic('show', lang);
    	//$('#div-detail-ballon').css({ borderRadius: '15px' });
    }
    $(AddCPBtn).click(function (event) {
        if(allowedDetail == "0")
        {
            $('#div-detail-ballon').html(dic('hide', lang));
            setCookie("detail_"+_userId, "1", 14);
            allowedDetail = "1";
            changebaloon123(IndexRec)
        } else {
            $('#div-detail-ballon').html(dic('show', lang));
            setCookie("detail_"+_userId, "0", 14);
            allowedDetail = "0";
            changebaloon123(IndexRec)
        }
    });
}
function AddDaysButton(el, num, days, vh, sd, sdB, ed, br) {
    if (parseInt(el.offsetWidth, 10) < 550)
        var _w = parseInt(el.offsetWidth, 10) - 50;
    else
        if (ShowGFBtn)
            var _w = 755;
        else
            var _w = 655;
	if (Browser() == 'iPad')
    	_w = '250'
	var _top = 70;   
    var layerDays = Create($(el).children()[0], 'div', 'div-layer-days-' + num);
    $(layerDays).css({ display: 'block', position: 'absolute', zIndex: '7000', backgroundColor: 'transparent', color: '#fff', left: '35px', top: _top+'px', width: _w + 'px', height: 'auto', textAlign: 'left' });
    layerDays.className = 'corner15 text3';
    var dat = "";
    var bool = true;
    var bool1 = false;
    for (var i = 0; i <= days; i++) {
        if (bool) {
            if (br.split(",")[i] == "1") {
                bool1 = true;
                bool = false;
            }
        }
        /*var dayT = (parseInt(sdB.split(" ")[0].split("-")[2], 10) + i);
        if (dayT < 10)
            dayT = "0" + dayT;
        
        dat = sdB.split(" ")[0].split("-")[0] + "-" + sdB.split(" ")[0].split("-")[1] + "-" + dayT + " " + sdB.split(" ")[1];*/
        
        if (i != 0) {
            var month = (parseInt(sdB.split(" ")[0].split("-")[1], 10) - 1) < 10 ? "0" + (parseInt(sdB.split(" ")[0].split("-")[1], 10) - 1) : (parseInt(sdB.split(" ")[0].split("-")[1], 10) - 1);
            var dtmp = new Date(sdB.split(" ")[0].split("-")[0], month, sdB.split(" ")[0].split("-")[2], sdB.split(" ")[1].split(":")[0], sdB.split(" ")[1].split(":")[1]);
            var dAdd = DateAdd("d", i, dtmp);
            var dat = String(dAdd.getFullYear()) + "-" + String((dAdd.getMonth() + 1) < 10 ? "0" + (dAdd.getMonth() + 1) : (dAdd.getMonth() + 1)) + "-" + String(dAdd.getDate() < 10 ? "0" + dAdd.getDate() : dAdd.getDate()) + " " + String(dAdd.getHours() < 10 ? "0" + dAdd.getHours() : dAdd.getHours()) + ":" + String(dAdd.getMinutes() < 10 ? "0" + dAdd.getMinutes() : dAdd.getMinutes());
        }
        
        if (br.split(",").length == 1)
            ChooseDay(layerDays, num, i, sd, ed, vh, br.split(",")[i], bool1);
        else
            if (i == 0)
                ChooseDay(layerDays, num, i, sdB, sdB.split(" ")[0] + " 23:59", vh, br.split(",")[i], bool1);
            else
                if (i == days)
                    ChooseDay(layerDays, num, i, ed.split(" ")[0] + " 00:00", ed, vh, br.split(",")[i], bool1);
                else
                    ChooseDay(layerDays, num, i, dat.split(" ")[0], dat.split(" ")[0], vh, br.split(",")[i], bool1);
        bool1 = false;
    }
}
function DateAdd(timeU, byMany, dateObj) {
    var millisecond = 1;
    var second = millisecond * 1000;
    var minute = second * 60;
    var hour = minute * 60;
    var day = hour * 24;
    var year = day * 365;

    var newDate;
    var dVal = dateObj.valueOf();
    switch (timeU) {
        case "ms": newDate = new Date(dVal + millisecond * byMany); break;
        case "s": newDate = new Date(dVal + second * byMany); break;
        case "mi": newDate = new Date(dVal + minute * byMany); break;
        case "h": newDate = new Date(dVal + hour * byMany); break;
        case "d": newDate = new Date(dVal + day * byMany); break;
        case "y": newDate = new Date(dVal + year * byMany); break;
    }
    return newDate;
}
function ChooseDay(el, num, _day, _day1, popup, vh, br, boo) {
    //if (AllowAddRuler == false) { return false }

    var layerDay = Create(el, 'div', 'div-layer-Day-' + _day);
    $(layerDay).css({ position: 'relative', float: 'left', zIndex: '8008', left: '20px', width: '60px', height: '25px' });
    layerDay.className = 'corner15 text3';

    var h = el.offsetHeight - 10
    var AddDayBtn = Create(layerDay, 'div', 'div-addDay-' + _day)
    if (boo) {
        var col = '387cb0';
        var bgC = 'fff';
        var bord = '1px solid #387CB0';
    } else {
        var col = 'fff';
        var bgC = '387cb0';
        var bord = '';
    }
    $(AddDayBtn).css({ display: 'block', position: 'relative', zIndex: '8000', backgroundColor: '#'+bgC, border: bord, color: '#' + col, padding: '2px 5px 2px 5px', width: '40px', cursor: 'pointer', textAlign: 'center' })
    AddDayBtn.className = 'corner15 text3';
    var _tmpDay = _day1.split(" ")[0];
    //AddDayBtn.innerHTML = _tmpDay.split("-")[2] + "-" + _tmpDay.split("-")[1] + "-" + _tmpDay.split("-")[0];  // parseInt(_day, 10) + 1;
    AddDayBtn.innerHTML = _tmpDay.split("-")[2] + " " + mesec[parseInt(_tmpDay.split("-")[1], 10)];
    if (parseInt(br, 10) == 0)
        AddDayBtn.style.backgroundColor = 'Gray';

    $(AddDayBtn).click(function (event) {
        if (parseInt(br, 10) == 0)
            return false;
        for (var i = 0; i < $('#div-layer-days-0')[0].children.length; i++) {
            if (!($('#div-addDay-' + i).css('backgroundColor') == "Gray" || $('#div-addDay-' + i).css('backgroundColor') == "gray")) {
                if (i == parseInt(event.target.id.substring(event.target.id.lastIndexOf("-")+1,event.target.id.length), 10)) {
                    var col = '387cb0';
                    var bgC = 'fff';
                    var bord = '1px solid #387CB0';
                    $('#div-addDay-' + i).css({ backgroundColor: '#' + bgC, border: bord, color: '#' + col });
                    clickedDay = i;
                } else {
                    var col = 'fff';
                    var bgC = '387cb0';
                    var bord = '';
                    $('#div-addDay-' + i).css({ backgroundColor: '#' + bgC, border: bord, color: '#' + col });
                }
            }
        }
        if (RecOn)
        	drawRecPerDay(_day1, popup, vh);
		if (RecOnNew)
        	drawRecPerDayNew(_day1, popup, vh);
    });

    if (Browser()!='iPad') {
    	$(AddDayBtn).mousemove(function (event) { if (event.target.innerHTML == "1") { ShowPopup(event, _day1) } else { ShowPopup(event, popup) } });
    	$(AddDayBtn).mouseout(function () { HidePopup() });
	}
}

function drawRecPerDay(_day1, _day2, vh) {
    Vehicles[0].Marker.display(false);
    vectors[0].removeAllFeatures();

	while(map.popups.length > 0)
    	map.popups[0].destroy();

    for (var tmpMR = 0; tmpMR < tmpMarkersRec.length; tmpMR++) {
        Markers[0].removeMarker(tmpMarkersRec[tmpMR]);
        tmpMarkersRec[tmpMR].destroy();
    }
    tmpMarkersRec = [];
    ClearArrayTrajectory();
    CharY.remove();
    CharSpeed.remove();
    if(allowfuel == "1")
    	CharFuel.remove();
	if(allowtemp == "1")
    	CharTemp.remove();
    PlayForwardRec = false;
    PlayBackRec = false;
    
    if (_day1.split(" ")[1] != undefined)
        _d1 = _day1;
    else
        _d1 = _day1 + " 00:00";
    if (_day2.split(" ")[1] != undefined)
        _d2 = _day2;
    else
        _d2 = _day2 + " 23:59";
    for(var i=1; i<=25; i++)
    	$('#casovi'+i).html("&nbsp;");
	$('#gnInfoChar').html('');
    ShowWait();

    $.ajax({
        url: twopoint + "/report/getHistoryByDay.php?v=" + vh + "&sd=" + _d1 + "&ed=" + _d2 + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
        	if(_d1 >= '2013-05-30 00:00')
        		allowtemp = "1";
    		else
    			allowtemp = "0";
            //data = JXG.decompress(data);
            window.clearTimeout(TIMEOUTREC);
            PlayForwardRec = false;
        	PlayBackRec = false;
            data = data.replace(/\r/g,'').replace(/\n/g,'');
            CarStr = data.split("@")[0];
            var strLon1 = data.split("@")[1].substring(0,data.split("@")[1].length-1);
        	var strLat1 = data.split("@")[2].substring(0,data.split("@")[2].length-1);
        	var strDist = data.split("@")[6].substring(0,data.split("@")[6].length-1);
        	var strdiffDT = data.split("@")[7].substring(0,data.split("@")[7].length-1);
        	var strAlpha = data.split("@")[8].substring(0,data.split("@")[8].length-1);
        	var strAlarms = data.split("@")[9].substring(0,data.split("@")[9].length-1);
        	var strIdling = data.split("@")[10].substring(0,data.split("@")[10].length-1);
        	var strdiffDT1 = data.split("@")[11].substring(0,data.split("@")[11].length-1);
        	var strParking = data.split("@")[13].substring(0,data.split("@")[13].length-1);
        	strDistStartStop = data.split("@")[12];
            DrawPath_Rec(strLon1, strLat1, strDist, strdiffDT, strAlpha, strAlarms, strIdling, strdiffDT1, strParking, Car[0].id, Car[0].reg);
            pointType = []

            firstLon = 0
            firstLat = 0
            lastLon = 0
            lastLat = 0
            countDivTable = 0
            first = 0
            tableI = 0

            _lonArr = ''
            _latArr = ''
            _lonArrZ = ''
            _latArrZ = ''
            imagePrev = ""
            numberDiff = 0

            count = 1;
            _pts = []
            _PointCount = 0

            CharDown = false
            _color = []
            _Times
            _PointMax = 0
            //var _pts
            paper
            SLeft = 10
            _speed = []
            _temperature = []
            _lon1 = []
            _lat1 = []

            _PointsH = []
            _StepH = []

            _PointsH[1] = 25
            _PointsH[2] = 25
            _PointsH[3] = 25
            _PointsH[4] = 25
            _PointsH[5] = 21
            _PointsH[6] = 25
            _PointsH[7] = 22

            _StepH[1] = 1
            _StepH[2] = 2
            _StepH[3] = 3
            _StepH[4] = 4
            _StepH[5] = 6
            _StepH[6] = 6
            _StepH[7] = 8

            _ignition = []
            _datetime = []
            lastDiv = 0
            lastColor
            xStep = 0.1
            tipRec = 0;
			//2012-09-01 23:59
			
            pocetenDatum = _d1;//.split(" ")[0].split("-")[2] + "-" + _d1.split(" ")[0].split("-")[1] + "-" + _d1.split(" ")[0].split("-")[0] + " " + _d1.split(" ")[1] + ":00";
            kraenDatum = _d2;//.split(" ")[0].split("-")[2] + "-" + _d2.split(" ")[0].split("-")[1] + "-" + _d2.split(" ")[0].split("-")[0] + " " + _d2.split(" ")[1] + ":00";

            _maxSpeed = data.split("@")[3];
            _maxFuel = data.split("@")[4];
            _firstFuel = data.split("@")[5];
            
            _maxTemp = data.split("@")[14];
            _minTemp = data.split("@")[15];
            _firstTemp = data.split("@")[16];
            
            test24(CarStr.substring(1, CarStr.length));

            PlayForwardRec = true;
            Vehicles[0].Marker.display(true);
            RecStert(1);
            zoomWorldScreen(Maps[0], DefMapZoom);
            HideWait();
        }
    });
}
function drawRecPerDayNew(_day1, _day2, vh) {
    Vehicles[0].Marker.display(false);
    vectors[0].removeAllFeatures();

	while(map.popups.length > 0)
    	map.popups[0].destroy();

    for (var tmpMR = 0; tmpMR < tmpMarkersRec.length; tmpMR++) {
        Markers[0].removeMarker(tmpMarkersRec[tmpMR]);
        tmpMarkersRec[tmpMR].destroy();
    }
    tmpMarkersRec = [];
    ClearArrayTrajectory();
    PlayForwardRec = false;
    PlayBackRec = false;
    
    if (_day1.split(" ")[1] != undefined)
        _d1 = _day1;
    else
        _d1 = _day1 + " 00:00";
    if (_day2.split(" ")[1] != undefined)
        _d2 = _day2;
    else
        _d2 = _day2 + " 23:59";
    if(chart != undefined)
    	chart.clear();
    $('#raphaelIgn').html('');
    $('#raphaelIgn').css({ height: '175px'});
    ShowWait();

    $.ajax({
        url: twopoint + "/report/getHistoryByDayNew.php?v=" + vh + "&sd=" + _d1 + "&ed=" + _d2 + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
        	
            //data = JXG.decompress(data);
            _pts = []
            window.clearTimeout(TIMEOUTREC);
            PlayForwardRec = false;
        	PlayBackRec = false;
            data = data.replace(/\r/g,'').replace(/\n/g,'');
            
            datenew = data.split("@")[12];
			ignitionNew = data.split("@")[11];
            
            datet = "";
            datet = data.split("@")[4];
            
            CarStr = data.split("@")[0];
            _pts = CarStr.substring(1,CarStr.length).split("#");
            var strLon1 = data.split("@")[1].substring(0,data.split("@")[1].length-1);
        	var strLat1 = data.split("@")[2].substring(0,data.split("@")[2].length-1);
        	var strDist = data.split("@")[3].substring(0,data.split("@")[3].length-1);
        	var strdiffDT = data.split("@")[4].substring(0,data.split("@")[4].length-1);
        	var strAlpha = data.split("@")[5].substring(0,data.split("@")[5].length-1);
        	var strAlarms = data.split("@")[6].substring(0,data.split("@")[6].length-1);
        	var strIdling = data.split("@")[7].substring(0,data.split("@")[7].length-1);
        	var strdiffDT1 = data.split("@")[8].substring(0,data.split("@")[8].length-1);
        	var strParking = data.split("@")[10].substring(0,data.split("@")[10].length-1);
        	strDistStartStop = data.split("@")[9];
            DrawPath_Rec(strLon1, strLat1, strDist, strdiffDT, strAlpha, strAlarms, strIdling, strdiffDT1, strParking, Car[0].id, Car[0].reg);
			CreateMarkerStartEnd(_pts[0].split("|")[1], _pts[0].split("|")[2], _pts[0].split("|")[4], _pts[_pts.length-1].split("|")[1], _pts[_pts.length-1].split("|")[2], _pts[_pts.length-1].split("|")[4], strDistStartStop);
        
			
			chartData1 = [];
		    chartData2 = [];
		    
		    ignition = [];
		    
		    maxSpeedRec = 0;
		    maxTemp = 0;
		    minTemp = 0;
		    maxSpeedRec1 = 0;
		    maxTemp1 = 0;
		    minTemp1 = 0;
			chart;
            
            count = 1;
            
            _PointCount = 0

            pocetenDatum = _d1;//.split(" ")[0].split("-")[2] + "-" + _d1.split(" ")[0].split("-")[1] + "-" + _d1.split(" ")[0].split("-")[0] + " " + _d1.split(" ")[1] + ":00";
            kraenDatum = _d2;//.split(" ")[0].split("-")[2] + "-" + _d2.split(" ")[0].split("-")[1] + "-" + _d2.split(" ")[0].split("-")[0] + " " + _d2.split(" ")[1] + ":00";

            //test24(CarStr.substring(1, CarStr.length));
            generateChartData();
        	createStockChart();

            PlayForwardRec = true;
            Vehicles[0].Marker.display(true);
            RecStertNew(0);
            zoomWorldScreen(Maps[0], DefMapZoom);
            HideWait();
        }
    });
}
function AddRecNewLayer(el, num) {
    Create(el, 'br', '');
    var layerReconstruction = Create(el, 'div', 'div-layer-recitem-' + num);
    $(layerReconstruction).css({ display: 'block', position: 'relative', float: 'left', width: '100%', zIndex: '8000', backgroundColor: 'transparent', height: 'auto' });
    layerReconstruction.className = 'corner15 text3';
}
function AddDirections(el, num) {

    var layerDirections = Create(el, 'div', 'div-layer-Directions-' + num);
    $(layerDirections).css({ position: 'relative', float: 'left', left: '20px', zIndex: '8002', width: '80px', height: '25px' });
    layerDirections.className = 'corner15 text3';

    var h = el.offsetHeight - 10
    //alert($(el).children()[0].id)

    var layerGetDirections = Create(layerDirections, 'div', 'div-layer-GetDirections-' + num);
    if(lang == 'mk')
        var _wdir = '65'
    else
        var _wdir = '58'
    $(layerGetDirections).css({ display: 'block', position: 'absolute', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 15px', width: _wdir + 'px', cursor: 'pointer', textAlign: 'left' })
    layerGetDirections.className = 'corner15 text3'

    $('#div-layer-GetDirections-' + num).html(dic("directions", lang));
    
    $(layerGetDirections).click(function (event) {
        clearDirectionS();
        clearDirectionE();
        $("#vozilcaDirection").val(-1);
        $("#div-Directions").css({display: 'block'});
    });

}
function AddMapType(el, num) {

    var layerMapType = Create(el, 'div', 'div-layer-MapType-' + num);
    $(layerMapType).css({ position: 'relative', float: 'left', left: '20px', zIndex: '8010', width: '120px', height: '25px' });
    layerMapType.className = 'corner15 text3';

    var h = el.offsetHeight - 10
    //alert($(el).children()[0].id)

    var layerSwitcher = Create(layerMapType, 'div', 'div-layer-switch-' + num);

    $(layerSwitcher).css({ display: 'block', position: 'absolute', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 15px', width: '90px', cursor: 'pointer', textAlign: 'left' })
    layerSwitcher.className = 'corner15 text3'

    //layerSwitcher.innerHTML = 'Google Maps&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;▼'
    if (MapType[num] == 'GOOGLEM' || MapType[num] == 'GOOGLES' || MapType[num] == 'GOOGLEP') $('#div-layer-switch-' + num).html('Google&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
    if (MapType[num] == 'OSMM' || MapType[num] == 'OSMS') $('#div-layer-switch-' + num).html('Open Street&nbsp;')
    if (MapType[num] == 'BINGM' || MapType[num] == 'BINGS') $('#div-layer-switch-' + num).html('Bing&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')
    if (MapType[num] == 'YAHOOM' || MapType[num] == 'YAHOOS' || MapType[num] == 'YAHOOP') $('#div-layer-switch-' + num).html('Geonet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')

    var layerList = Create(layerMapType, 'div', 'div-layer-list-' + num)
    $(layerList).css({ display: 'block', position: 'absolute', zIndex: '7999', backgroundColor: '#e2ecfa', border: '1px solid #1a6ea5', borderRadius: '0px 0px 5px 5px', color: '#fff', left: '10px', top: '10px', padding: '2px 5px 2px 5px', width: '78px', cursor: 'pointer', textAlign: 'center', display: 'none' })
    //OVDE   AllowedMaps
    var strList = '';
    if (AllowedMaps[0] == '1') { strList = strList + '<div id="layer-1-' + num + '" onclick="SelectMapLayer(' + num + ', 1)" class="menu_layer">&nbsp;&nbsp;Google</div>' }
    if (AllowedMaps[1] == '1') { strList = strList + '<div id="layer-2-' + num + '" onclick="SelectMapLayer(' + num + ', 2)" class="menu_layer">&nbsp;&nbsp;Open Street</div>' }
    if (AllowedMaps[2] == '1') { strList = strList + '<div id="layer-3-' + num + '" onclick="SelectMapLayer(' + num + ', 3)" class="menu_layer">&nbsp;&nbsp;Bing</div>' }
    if (AllowedMaps[3] == '1') { strList = strList + '<div id="layer-4-' + num + '" onclick="SelectMapLayer(' + num + ', 4)" class="menu_layer">&nbsp;&nbsp;Geonet</div>' }

    layerList.innerHTML = '<div style="height:10px"></div>' + strList;

    $(layerSwitcher).click(function (event) { ShowLayerList(num) });

    if (Browser()!='iPad') {
    	$(layerSwitcher).mousemove(function (event) { ShowPopup(event, '' + dic("switchMap", lang) + '') });
    	$(layerSwitcher).mouseout(function () { HidePopup() });
	}

    var layerType = Create(layerMapType, 'div', 'div-type-' + num);
    $(layerType).css({ display: 'block', position: 'absolute', zIndex: '8001', fontSize: '11px', backgroundColor: 'transparent', color: '#fff', left: '80px', top: '1px', width: '15px', cursor: 'pointer' })
    $(layerType).html('|&nbsp;&nbsp;&nbsp;▼');

    $(layerType).click(function (event) { SelectTypeMapLayer(num) });
    if (Browser()!='iPad') {
    	$(layerType).mousemove(function (event) { ShowPopup(event, '' + dic("switchTypeMap", lang) + '') });
    	$(layerType).mouseout(function () { HidePopup() });
	}

    var layerTypeList = Create(layerMapType, 'div', 'div-layerType-list-' + num);
    $(layerTypeList).css({ display: 'block', position: 'absolute', zIndex: '7999', backgroundColor: '#e2ecfa', border: '1px solid #1a6ea5', borderRadius: '0px 0px 5px 5px', color: '#fff', left: '10px', top: '10px', padding: '2px 5px 2px 5px', width: '78px', cursor: 'pointer', textAlign: 'center', display: 'none' })
    var strList = '';
    strList = strList + '<div id="layerType-1-' + num + '" onclick="SelectMapLayer(' + num + ', 11)" class="menu_layer">&nbsp;&nbsp;Maps</div>';
    strList = strList + '<div id="layerType-2-' + num + '" onclick="SelectMapLayer(' + num + ', 12)" class="menu_layer">&nbsp;&nbsp;Satellite</div>';
    strList = strList + '<div id="layerType-3-' + num + '" onclick="SelectMapLayer(' + num + ', 13)" class="menu_layer">&nbsp;&nbsp;Terrain</div>';

    layerTypeList.innerHTML = '<div style="height:10px"></div>' + strList;
}

function SelectTypeMapLayer(num) {
    var disp = document.getElementById('div-layerType-list-'+num).style.display;
    if (disp == 'none') {
        $('#div-type-' + num).html("|&nbsp;&nbsp;&nbsp;▲");
        document.getElementById('div-layerType-list-' + num).style.display = 'block';
        if (MapType[num].indexOf('YAHOO') != -1) {
            //$('#layerType-3-' + num).css({ display: 'none' });
            if (MapType[num] == 'YAHOOM') { $('#layerType-1-' + num).html('▪&nbsp;Maps') } else { $('#layerType-1-' + num).html('&nbsp;&nbsp;Maps') }
            if (MapType[num] == 'YAHOOS') { $('#layerType-2-' + num).html('▪&nbsp;Satellite	') } else { $('#layerType-2-' + num).html('&nbsp;&nbsp;Satellite') }
            if (MapType[num] == 'YAHOOP') { $('#layerType-3-' + num).html('▪&nbsp;Terrain	') } else { $('#layerType-3-' + num).html('&nbsp;&nbsp;Terrain') }
            //$('#layerType-2-' + num).css({ display: 'none' });
            //$('#layerType-3-' + num).css({ display: 'none' });
            //if (MapType[num] == 'YAHOOS') { $('#layerType-2-' + num).html('▪&nbsp;Old Maps') } else { $('#layerType-2-' + num).html('&nbsp;&nbsp;Old Maps') }
        }
        else {
            if (MapType[num].indexOf('BING') != -1) {
                $('#layerType-3-' + num).css({ display: 'none' });
            }
            if (MapType[num].indexOf('OSM') != -1) {
                $('#layerType-2-' + num).css({ display: 'none' });
                $('#layerType-3-' + num).css({ display: 'none' });
            }

            if (MapType[num] == 'GOOGLEM' || MapType[num] == 'OSMM' || MapType[num] == 'BINGM') { $('#layerType-1-' + num).html('▪&nbsp;Maps') } else { $('#layerType-1-' + num).html('&nbsp;&nbsp;Maps') }
            if (MapType[num] == 'GOOGLES' || MapType[num] == 'BINGS') { $('#layerType-2-' + num).html('▪&nbsp;Satellite') } else { $('#layerType-2-' + num).html('&nbsp;&nbsp;Satellite') }
            if (MapType[num] == 'GOOGLEP') { $('#layerType-3-' + num).html('▪&nbsp;Terrain') } else { $('#layerType-3-' + num).html('&nbsp;&nbsp;Terrain') }
        }
        return
    } else {
        $('#div-type-' + num).html("|&nbsp;&nbsp;&nbsp;▼");
        document.getElementById('div-layerType-list-' + num).style.display = 'none';
    }
}
function ShowLayerList(num) {
    var disp = document.getElementById('div-layer-list-' + num).style.display;
    if (disp == 'none') {
        document.getElementById('div-layer-list-' + num).style.display = 'block';
        if (MapType[num] == 'GOOGLEM' || MapType[num] == 'GOOGLES' || MapType[num] == 'GOOGLEP') { $('#layer-1-' + num).html('▪&nbsp;Google') } else { $('#layer-1-' + num).html('&nbsp;&nbsp;Google') }
        if (MapType[num] == 'OSMM' || MapType[num] == 'OSMS') { $('#layer-2-' + num).html('▪&nbsp;Open Street') } else { $('#layer-2-' + num).html('&nbsp;&nbsp;Open Street') }
        if (MapType[num] == 'BINGM' || MapType[num] == 'BINGS') { $('#layer-3-' + num).html('▪&nbsp;Bing') } else { $('#layer-3-' + num).html('&nbsp;&nbsp;Bing') }
        if (MapType[num] == 'YAHOOM' || MapType[num] == 'YAHOOS' || MapType[num] == 'YAHOOP') { $('#layer-4-' + num).html('▪&nbsp;Geonet') } else { $('#layer-4-' + num).html('&nbsp;&nbsp;Geonet') }
        return
    } else {
        document.getElementById('div-layer-list-' + num).style.display = 'none'
    }
}

function SelectMapLayer(num, l) {
    var ll = GetCenterOfMap(num);
    var zl = GetZoomLevel(num)
	if(MapType[num] == "BINGM" || MapType[num] == 'BINGS')
		zl++;
    if (l == 1) { MapType[num] = 'GOOGLE' + MapType[num].substring(MapType[num].length - 1, MapType[num].length) }
    if (l == 2) { MapType[num] = 'OSMM' }
    if (l == 3) { if (MapType[num].substring(MapType[num].length - 1, MapType[num].length) == 'P') { MapType[num] = 'BINGM' } else { MapType[num] = 'BING' + MapType[num].substring(MapType[num].length - 1, MapType[num].length) } }
    if (l == 4) { if (MapType[num].substring(MapType[num].length - 1, MapType[num].length) == 'S') { MapType[num] = 'YAHOOM' } else { MapType[num] = 'YAHOO' + MapType[num].substring(MapType[num].length - 1, MapType[num].length) } }
    if (l == 11) {
        if (MapType[num].substring(MapType[num].length - 1, MapType[num].length) == 'S' || MapType[num].substring(MapType[num].length - 1, MapType[num].length) == 'P') {
            MapType[num] = MapType[num].substring(0, MapType[num].length - 1) + 'M';
        }
    }
    if (l == 12) {
        if (MapType[num].substring(MapType[num].length - 1, MapType[num].length) == 'M' || MapType[num].substring(MapType[num].length - 1, MapType[num].length) == 'P') {
            MapType[num] = MapType[num].substring(0, MapType[num].length - 1) + 'S';
        }
    }
    if (l == 13) { 
    	//MapType[num] = 'GOOGLEP';
    	if (MapType[num].substring(MapType[num].length - 1, MapType[num].length) == 'M' || MapType[num].substring(MapType[num].length - 1, MapType[num].length) == 'S') {
            MapType[num] = MapType[num].substring(0, MapType[num].length - 1) + 'P';
        } 
    }

    Boards[num].innerHTML = ''

    map = new OpenLayers.Map({ div: Boards[num].id, allOverlays: true,
        eventListeners: {
            "zoomend": mapEvent,
            "movestart": mapmovestart,
            "click": function (e) { eventClick(e) }
        }, maxExtent: new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34),
        maxResolution: 156543.0399,
        numZoomLevels: 19,
        units: 'm',
        projection: new OpenLayers.Projection("EPSG:900913"),
        displayProjection: new OpenLayers.Projection("EPSG:4326")
    });

    var layer;
    if (MapType[num] == 'GOOGLEM') { layer = new OpenLayers.Layer.Google("Google Streets") }
    if (MapType[num] == 'GOOGLES') { layer = new OpenLayers.Layer.Google("Google Satellite", { type: google.maps.MapTypeId.HYBRID }) }
    if (MapType[num] == 'GOOGLEP') { layer = new OpenLayers.Layer.Google("Google Physical", { type: google.maps.MapTypeId.TERRAIN }) }

    if (MapType[num] == 'OSMM') { layer = new OpenLayers.Layer.OSM() }
    //if (MapType[num] == 'OSMS') { layer = new OpenLayers.Layer.OSM("MapQuest") }

	// GLOBSY MAPS
    //if (MapType[num] == 'YAHOOM') { layer = new OpenLayers.Layer.Yahoo("Yahoo Street") }
    if (MapType[num] == 'YAHOOM') { layer = new OpenLayers.Layer.WMS( "OpenLayers WMS", "http://144.76.225.247:8080/geoserver/gwc/service/wms", {'layers': 'GeonetMaps', format: 'image/png'}); }
    if (MapType[num] == 'YAHOOS') { layer = new OpenLayers.Layer.Google("Google Satellite", { type: google.maps.MapTypeId.HYBRID }) }
    if (MapType[num] == 'YAHOOP') { layer = new OpenLayers.Layer.Google("Google Physical", { type: google.maps.MapTypeId.TERRAIN }) }

    if (MapType[num] == 'BINGM') { layer = new OpenLayers.Layer.Bing({ key: apiKey, type: "Road", metadataParams: { mapVersion: "v1"} }) }
    if (MapType[num] == 'BINGS') { layer = new OpenLayers.Layer.Bing({ key: apiKey, type: "AerialWithLabels", wrapDateLine: true }) }

    map.addLayers([layer]);

    if (MapType[num] == 'YAHOOM') {
        
		//GLOBSY MAPS
		//map.setCenter(new OpenLayers.LonLat(ll.lon, ll.lat), 14);
		map.setCenter(new OpenLayers.LonLat(ll.lon, ll.lat).transform(
			new OpenLayers.Projection("EPSG:4326"),
			map.getProjectionObject()
		), zl);
    } else {
        map.setCenter(new OpenLayers.LonLat(ll.lon, ll.lat).transform(
			new OpenLayers.Projection("EPSG:4326"),
			map.getProjectionObject()
		), zl);
    }

	// style the sketch fancy
	var sketchSymbolizers = {
		"Line": {
			strokeWidth: 3,
			strokeOpacity: 1,
			strokeColor: "#666666",
			strokeDashstyle: "dash"
		}
	};
	var style123 = new OpenLayers.Style();
	style123.addRules([
		new OpenLayers.Rule({symbolizer: sketchSymbolizers})
	]);
	var styleMap123 = new OpenLayers.StyleMap({"default": style123}); 

    var renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
    renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;
    vectors[num] = new OpenLayers.Layer.Vector("Vector Layer", {
        renderers: renderer
    });
    map.addLayer(vectors[num]);

    selectControl = new OpenLayers.Control.SelectFeature(vectors[num],
    {
        onSelect: onFeatureSelect,
        onUnselect: onFeatureUnselect
    });
    modifyControl = new OpenLayers.Control.ModifyFeature(vectors[num],
    {
        onModificationStart: onFeatureModify,
        onModificationEnd: onFeatureUnmodify,
        onModification: onFeatureStartModify
    });

    controls[num] = {
        polygon: new OpenLayers.Control.DrawFeature(vectors[num], OpenLayers.Handler.Polygon),
        modify: modifyControl,
        line: new OpenLayers.Control.Measure(
            OpenLayers.Handler.Path, {
                persist: true,
                geodesic: true,
                handlerOptions: {
                    layerOptions: {
                        renderers: renderer,
                        styleMap: styleMap123
                    }
                }
                /*displaySystemUnits: {
				 geographic: ['dd'],
				 english: ['mi', 'ft', 'in'],
				 metric: ['km', 'm'],
				 myCustomUnits: ['mi', 'mi']
				}*/
            }
        ),
        select: selectControl,
        drag: new OpenLayers.Control.DragFeature(vectors[i], {
            onStart: function(feature) {
                if(feature.style.type != 's' && feature.style.type != 'e') {
                    toggleControl('drag', false, 0);
                    toggleControl('drag', true, 0);
                }
            },
            onComplete: function(feature) {
                dragFinish(feature)   
            }
        })
    }

    controls[num]['line'].events.on({
        "measure": handleMeasurements,
        "measurepartial": handleMeasurements
    });

    vectors[num].events.on({
        "sketchcomplete": function report(event) {
            selectedFeature[SelectedBoard] = event.feature;
            toggleControl('modify', true, parseInt(this.map.div.id.substring(this.map.div.id.length - 1, this.map.div.id.length), 10) - 1);
            event.feature.layer = this;
            controls[parseInt(this.map.div.id.substring(this.map.div.id.length - 1, this.map.div.id.length), 10) - 1].modify.selectControl.clickFeature(event.feature);
        }
    });

    for (var key in controls[num]) {
        map.addControl(controls[num][key]);
    }
    controls[num].select.activate();
    
	if(metric == "mi")
		map.controls[6].displaySystem = "english";

    //}
    $('.olControlAttribution').css({ bottom: '7px', right: '', left: '3px' });
    Maps[num] = map;
    AddLayerSwitcher(Boards[num], num);

    var markers = new OpenLayers.Layer.Markers("Markers");
    map.addLayer(markers);
    Markers[num] = markers;
    var _br = 0;
    for (var vc = 0; vc < Vehicles.length; vc++) {
        if (Vehicles[vc].Map == num) {
            Vehicles[vc] = "";
            for (var j = vc; j < Vehicles.length-1; j++) {
                Vehicles[j] = Vehicles[j + 1];
                Vehicles[j + 1] = "";
            }
            _br++;
            vc--;
        }
    }
	if(!RecOnNewAll)
	{
		map.events.register('mouseover', map, function(e) {
	     	if(true)
	     	{
				var $elements = GetAllElementsAt(e.pageX, e.pageY);
				veh = '';
				vehnum = '';
				countofveh = 0;
		
			    for(var pop=0; pop<$elements.length; pop++)
			    {
		    		if($elements[pop][0].innerHTML.indexOf("92.55") == -1 && $elements[pop][0].innerHTML.indexOf("pin-1.png") == -1)
		    		{
			    		if($elements[pop][0].id.indexOf("innerImage") != -1)
			    		{
			    			veh += "#vehicleList-" + $elements[pop].children().html() + ";";
			    		}
			    		else
			    		{
			    			veh += "#vehicleList-" + $elements[pop].children().children().html() + ";";
			    		}
			    		countofveh++;
			    		vehnum = pop;
			    	}
			    }
			    if($elements[vehnum] != undefined && veh != '')
			    {
			    	if(countofveh > 4)
			    		$elements[vehnum][0].setAttribute("onmousemove", "ShowPopupB1(event, '" + veh.substring(0, veh.length - 1) + "')");
			    	else
			    		$elements[vehnum][0].setAttribute("onmousemove", "ShowPopupB(event, '" + veh.substring(0, veh.length - 1) + "')");
		        	$elements[vehnum][0].setAttribute("onmouseout", "HidePopup()");
		        }
			}
		});
	}

    var _iii = Vehicles.length;
    Vehicles = Vehicles.slice(0, (_iii - _br));
    //Vehicles = [];
    ResetTimersStep(num);
    if (RecOn) {
        if (PlayForwardRec == false && PlayBackRec == false)
            var dbf1 = true;
        else
            var dbf1 = false;
        PFR1 = PlayForwardRec; PBR1 = PlayBackRec;
        PlayForwardRec = false;
        PlayBackRec = false;
        window.clearTimeout(TIMEOUTREC);
        AddLayerPlay(Boards[0], 0);
        var vh = VehcileIDs[0];
        AddDaysButton(Boards[0], 0, days, vh, sd, sdB, ed, bool);
        AddRecLayer(Boards[0], 0);
        for (var i = 0; i < $('#div-layer-days-0')[0].children.length; i++) {
            if ($('#div-addDay-' + i).css('backgroundColor') != "Gray") {
                if (i == parseInt(clickedDay, 10)) {
                    var col = '387cb0';
                    var bgC = 'fff';
                    var bord = '1px solid #387CB0';
                    $('#div-addDay-' + i).css({ backgroundColor: '#' + bgC, border: bord, color: '#' + col });
                    clickedDay = i;
                } else {
                    var col = 'fff';
                    var bgC = '387cb0';
                    var bord = '';
                    $('#div-addDay-' + i).css({ backgroundColor: '#' + bgC, border: bord, color: '#' + col });
                }
            }
        }
        //vectors[0].addFeatures(ArrLineFeature);
        DrawPath_Rec(strLon, strLat, strDist, strDTArray, strAlpha, strAlarms, strIdling, strDTArrayDiff, strParking, Car[0].id, Car[0].reg);
        
        pointType = []
        firstLon = 0
        firstLat = 0
        lastLon = 0
        lastLat = 0
        countDivTable = 0
        first = 0
        tableI = 0

        _lonArr = ''
        _latArr = ''
        _lonArrZ = ''
        _latArrZ = ''
        imagePrev = ""
        numberDiff = 0

        count = 1;
        _pts = []
        _PointCount = 0

        CharDown = false
        _color = []
        _Times
        _PointMax = 0
        //var _pts
        paper
        SLeft = 10
        _speed = []
        _lon1 = []
        _lat1 = []

        _PointsH = []
        _StepH = []

        _PointsH[1] = 25
        _PointsH[2] = 25
        _PointsH[3] = 25
        _PointsH[4] = 25
        _PointsH[5] = 21
        _PointsH[6] = 25
        _PointsH[7] = 22

        _StepH[1] = 1
        _StepH[2] = 2
        _StepH[3] = 3
        _StepH[4] = 4
        _StepH[5] = 6
        _StepH[6] = 6
        _StepH[7] = 8

        _ignition = []
        _datetime = []
        lastDiv = 0;
        lastColor
        xStep = 0.1
        tipRec = 0;

        test24(CarStr.substring(1, CarStr.length));

        GoToPoint(IndexRec, PFR1, PBR1, dbf1);
        zoomWorldScreen(Maps[0], DefMapZoom);
    }
	if (RecOnNew) {
        if (PlayForwardRec == false && PlayBackRec == false)
            var dbf1 = true;
        else
            var dbf1 = false;
        PFR1 = PlayForwardRec; PBR1 = PlayBackRec;
        PlayForwardRec = false;
        PlayBackRec = false;
        window.clearTimeout(TIMEOUTREC);
        AddLayerPlay(Boards[0], 0);
        var vh = VehcileIDs[0];
        AddDaysButton(Boards[0], 0, days, vh, sd, sdB, ed, bool);
        AddRecLayer(Boards[0], 0);
        for (var i = 0; i < $('#div-layer-days-0')[0].children.length; i++) {
            if ($('#div-addDay-' + i).css('backgroundColor') != "Gray") {
                if (i == parseInt(clickedDay, 10)) {
                    var col = '387cb0';
                    var bgC = 'fff';
                    var bord = '1px solid #387CB0';
                    $('#div-addDay-' + i).css({ backgroundColor: '#' + bgC, border: bord, color: '#' + col });
                    clickedDay = i;
                } else {
                    var col = 'fff';
                    var bgC = '387cb0';
                    var bord = '';
                    $('#div-addDay-' + i).css({ backgroundColor: '#' + bgC, border: bord, color: '#' + col });
                }
            }
        }
        //vectors[0].addFeatures(ArrLineFeature);
        DrawPath_Rec(strLon, strLat, strDist, strDTArray, strAlpha, strAlarms, strIdling, strDTArrayDiff, strParking, Car[0].id, Car[0].reg);
        CreateMarkerStartEnd(_pts[0].split("|")[1], _pts[0].split("|")[2], _pts[0].split("|")[4], _pts[_pts.length-1].split("|")[1], _pts[_pts.length-1].split("|")[2], _pts[_pts.length-1].split("|")[4], strDistStartStop);
        
        //_PointCount = 0

        //generateChartData();
		//createStockChart();
		goToPointIdx();
        //GoToPoint(IndexRec, PFR1, PBR1, dbf1);
        zoomWorldScreen(Maps[0], DefMapZoom);
    }
    if (RecOnNewAll) {
        if (PlayForwardRec == false && PlayBackRec == false)
            var dbf1 = true;
        else
            var dbf1 = false;
        PFR1 = PlayForwardRec; PBR1 = PlayBackRec;
        PlayForwardRec = false;
        PlayBackRec = false;
        window.clearTimeout(TIMEOUTREC);
        
        AddLayerPlayNewRec($('#div-layer-recitem-0')[0], 0);
        var vh = VehcileIDs[0];
        AddDaysButtonNewRec($('#div-layer-recitem-0')[0], 0, days, vh, sd, sdB, ed, bool);

        AddRecLayer(Boards[0], 0);
        
        AddBaloon(Boards[0], 0);
        
        getVehBaloon(VehcileIDs, lang);
        
        for (var i = 0; i < $('#div-layer-days-0')[0].children.length; i++) {
            if ($('#div-addDay-' + i).css('backgroundColor') != "Gray") {
                if (i == parseInt(clickedDay, 10)) {
                    var col = '387cb0';
                    var bgC = 'fff';
                    var bord = '1px solid #387CB0';
                    $('#div-addDay-' + i).css({ backgroundColor: '#' + bgC, border: bord, color: '#' + col });
                    clickedDay = i;
                } else {
                    var col = 'fff';
                    var bgC = '387cb0';
                    var bord = '';
                    $('#div-addDay-' + i).css({ backgroundColor: '#' + bgC, border: bord, color: '#' + col });
                }
            }
        }
        //vectors[0].addFeatures(ArrLineFeature);
        //DrawPath_Rec(strLon, strLat, strDist, strDTArray, strAlpha, strAlarms, strIdling, strDTArrayDiff, strParking, Car[0].id, Car[0].reg);
        //CreateMarkerStartEnd(_pts[0].split("|")[1], _pts[0].split("|")[2], _pts[0].split("|")[4], _pts[_pts.length-1].split("|")[1], _pts[_pts.length-1].split("|")[2], _pts[_pts.length-1].split("|")[4], strDistStartStop);
        generatePathValues();
        //_PointCount = 0
		
		//goToPointIdxNew(_PointCount);
        
        //generateChartData();
		//createStockChart();
		//goToPointIdx();
        //GoToPoint(IndexRec, PFR1, PBR1, dbf1);
        //zoomWorldScreen(Maps[0], DefMapZoom);

        if (MapType[num] == 'YAHOOM') {
            
            //GLOBSY MAPS
            //map.setCenter(new OpenLayers.LonLat(ll.lon, ll.lat), 14);
            map.setCenter(new OpenLayers.LonLat(ll.lon, ll.lat).transform(
                new OpenLayers.Projection("EPSG:4326"),
                map.getProjectionObject()
            ), zl);
        } else {
            map.setCenter(new OpenLayers.LonLat(ll.lon, ll.lat).transform(
                new OpenLayers.Projection("EPSG:4326"),
                map.getProjectionObject()
            ), zl);
        }
    }
    if (ShowPOI) {
        var tmpEl = document.getElementById("div-poiGroupUp");
        if (tmpEl != null) {
            if ($('#3_AllGroupCheck').attr('checked')) {
                ShowPOI = false;
                LoadAllPOI('All', num);
            } else {
                Applay_3(3, "div-poiGroupUp");
            }
        } else {
            ShowPOI = false;
            LoadAllPOI('All', num);
        }
    }
    if (ShowHideZone) {
        var tmpEl = document.getElementById("div-AreasUp");
        if (tmpEl != null) {
            if ($('#2_AllGroupCheck').attr('checked')) {
                ShowHideZone = false;
                LoadAllZone();
            } else {
                Applay_2(2, "div-AreasUp");
            }
        } else {
            ShowHideZone = false;
            LoadAllZone();
        }
    }
    if (ShowHideTrajectory) {
        var tmpEl = document.getElementById("div-VehicleUp");
        if (tmpEl != null) {
            if ($('#1_AllGroupCheck').attr('checked')) {
                ShowHideTrajectory = false;
                OnClickSHTrajectory();
            } else {
                Applay_1(1, "div-VehicleUp");
            }
        } else {
            ShowHideTrajectory = false;
            OnClickSHTrajectory();
        }
    }
    
    if (loadAjaxRec != undefined) {
        LoadDataAjax(loadAjaxRec.substring(loadAjaxRec.indexOf("'") + 1, loadAjaxRec.lastIndexOf("'")));
        counter = count - 1;
    }

    //    if (ShowPOI == true) {
    //        //LoadPOI()
    //    }

    //	for (var c=0; c<Car.length;c++){
    //		var _car = Car[c]
    //		//CreateVehicle(num, _car.id, _car.color, _car.lon, _car.lat)	
    //		for (var j=0;j<5;j++){
    //				if (Maps[j] != null) {
    //					CreateVehicle(j, _car.id, _car.color, _car.lon, _car.lat)
    //				}
    //			}
    //	}
    if(reloadMarker)
	{
		addPoi1(StartLon, StartLat, regLM, datumLM, timeLM, speedLM, this.Maps[0].layers[2], this.Maps[0]);
	}
}

function CreateVehicle(_mapNo, _vehicleNo, _color, _lon, _lat, map0, map1, map2, map3, _reg, _status, _speed, _nocomm){
    //if (Maps[_mapNo]==null) {return false}
    
	var vIndex  = Vehicles.length
	var Vehicle
	var Postoi = false;
	for (var _v=0; _v<Vehicles.length; _v++){
		if ((Vehicles[_v].ID==_vehicleNo) && (Vehicles[_v].Map==_mapNo)) {Vehicle=Vehicles[_v]; vIndex=_v; Postoi=true}
	}
	var MyM
	if (Vehicle ==null) {Vehicle = new VehicleClass(_vehicleNo, _color, _lon, _lat, _reg)}
	Vehicle.Map = _mapNo
	Vehicle.Lon = _lon
	Vehicle.Lat = _lat
	Vehicle.Reg = _reg
	Vehicle.trajec =  podatok[Maps[_mapNo].getZoom()];

    var markers = Markers[_mapNo]
	if (markers ==null) return
	var map = Maps[_mapNo]
	size = new OpenLayers.Size(44, 44);
    calculateOffset = function(size) {return new OpenLayers.Pixel(-(size.w/2), -size.h/2); };
    icon = new OpenLayers.Icon('./blank.png', size, null, calculateOffset);
	if (Postoi==false) {
		var ll = new OpenLayers.LonLat(_lon, _lat).transform(new OpenLayers.Projection("EPSG:4326"), Maps[_mapNo].getProjectionObject())
		//if (MapType[_mapNo] == 'YAHOOM') { var ll = new OpenLayers.LonLat(_lon, _lat) }
		MyM = new OpenLayers.Marker(ll, icon)
		markers.addMarker(MyM);
	} else {
		MyM = Vehicles[vIndex].Marker
		//var ll = new OpenLayers.LonLat(_lon, _lat).transform(new OpenLayers.Projection("EPSG:4326"), Maps[_mapNo].getProjectionObject());
		//var newPx = Maps[_mapNo].getPixelFromLonLat(ll);
		//MyM.moveTo(ll)
	}
    
	if (_mapNo==0) {MyM.display(map0)}
	if (_mapNo==1) {MyM.display(map1)}
	if (_mapNo==2) {MyM.display(map2)}
	if (_mapNo==3) {MyM.display(map3)}
	
	MarkerColor = _color
	var el = MyM.events.element
	el.style.zIndex = 7777

	if(el.innerHTML.indexOf("gnMarker") == -1)
	{
		//el.innerHTML = '<div style="visibility: hidden;" class="impuls1"></div><div style="visibility: hidden;" class="impuls3 gnMarkerPulsing' + MarkerColor + '"></div><div class="gnMarker' + MarkerColor + ' text3"><strong>' + _vehicleNo + '</strong></div>';
		el.innerHTML = '<div class="gnMarker' + MarkerColor + ' text3"><strong class="sitevozila">' + _vehicleNo + '</strong></div>';
		el.innerHTML += '<div class="gnMarkerPointerRed" style="height:6px; width:6px; position:absolute; display:box; font-size:4px"></div>';
	} else
	{
		el.children[0].className = "gnMarker" + MarkerColor + " text3";
		if(el.children[2] != undefined)
		{
			//el.children[2].className = "impuls1_"++" gnMarkerBorder" + MarkerColor;
			el.children[2].className = "impuls3_"+_mapNo+" gnMarkerPulsing" + MarkerColor;
		}
	}

	$('#img-vehicle-' + _mapNo + '-' + _vehicleNo).remove();
	/*if(_status == '0')
	{
		//Vehicles[i].Marker.events.element.innerHTML += ;
		$($(el).children()[0]).append('<div id="img-vehicle-' + _mapNo + '-' + _vehicleNo + '" style="height: 16px; background-image: url(\'../images/nosignal.png\'); position: absolute; width: 16px; z-index: 9; left: 12px; top: 12px;"></div>');
	} else
	{*/
		if(_nocomm)
		{
			$($(el).children()[0]).append('<div id="img-vehicle-' + _mapNo + '-' + _vehicleNo + '" style="height: 16px; background-image: url(\'../images/nocommunication.png\'); position: absolute; width: 16px; z-index: 9; left: 12px; top: 12px;"></div>');
		}
	//}
	// Ova ne treba ako miruva //el.innerHTML += '<div class="gnMarkerPointer' + MarkerColor + '" style="left:' + 20 + 'px; top:' + 6 + 'px; height:6px; width:6px; position:absolute; display:box; font-size:4px"></div>'			
	//debugger;

	//setInterval($(".impuls").animate({left:'250px'});
	/*var glow = $('.impuls1');
	var glow1 = $('.impuls2');
	setInterval(function(){
	    glow.hasClass('glow') ? glow.removeClass('glow') : glow.addClass('glow');
	    glow1.hasClass('glow') ? glow1.removeClass('glow') : glow1.addClass('glow');
	}, 1500);*/
	
	//if (Browser()!='iPad') {
		//el.setAttribute("onmousemove","ShowPopup(event, '#vehicleList-"+_vehicleNo+"')")
		//el.setAttribute("onmouseout", "HidePopup()");
	//}
	el.addEventListener('click', function(e) { AddPOI = true; VehClick = true; });

	Vehicle.Marker = MyM
	Vehicle.el = el
	if(RecOnNewAll == false)
	   $(Vehicle.el).css({transition: 'all 2s ease-in-out'});
	
	Vehicles[vIndex] = Vehicle
	if (InitLoad==true) {
	    if (Vehicle.Marker.onScreen() == false) { Maps[_mapNo].zoomOut() }
	}
}

function ResetTimers() {
    for (var c = 0; c < Car.length; c++) {
        var _car = Car[c];
        for (var j = 0; j < 5; j++) {
            if (Maps[j] != null) {
                /*for (var i = 0; i < Vehicles.length; i++) {
                    for (var cc = 1; cc <= 25; cc++) {
                        if (Timers[j][i] != null) {
                            if (Timers[j][i][cc] != null)
                                window.clearTimeout(Timers[j][i][cc])
                        }
                    }
                    Timers[j][i] = null;
                    Timers[j][i] = [];
                }*/
                CreateVehicle(j, _car.id, _car.color, _car.lon, _car.lat, _car.map0, _car.map1, _car.map2, _car.map3, _car.reg, _car.status, _car.speed, _car.noconnection);
            }
        }
    }
    //if (ShowPOI == true) {
        //LoadPOI()
    //}
}

function ResetTimersStep(num) {

    /*for (var i = 0; i < Vehicles.length; i++) {
        for (var cc = 1; cc <= 25; cc++) {
            if (Timers[num][i] != null) {
                if (Timers[num][i][cc] != null)
                    window.clearTimeout(Timers[num][i][cc]);
            }
        }
        Timers[num][i] = null;
        Timers[num][i] = [];
    }*/
    for (var c = 0; c < Car.length; c++) {
        var _car = Car[c];
        if (Maps[num] != null)
            CreateVehicle(num, _car.id, _car.color, _car.lon, _car.lat, _car.map0, _car.map1, _car.map2, _car.map3, _car.reg, _car.status, _car.speed, _car.noconnection);
    }
    //iszooming = false;
    //if (ShowPOI == true) {
        //LoadPOI();
    //}
}

function switchClass12_0(num)
{
	if(FollowActive[num])
	{
		if($(".impuls3_"+num)[0] != undefined)
		{
			//$(".impuls1_"+num).switchClass("impuls1_"+num, "impuls2_"+num, 600);
			$(".impuls3_"+num).switchClass("impuls3_"+num, "impuls4_"+num, 600);
		} else
		{
			//$(".impuls2_"+num).switchClass("impuls2_"+num, "impuls1_"+num, 600);	
			$(".impuls4_"+num).switchClass("impuls4_"+num, "impuls3_"+num, 600);
		}
		setTimeout("switchClass12_0(0)", 1200);
	}
}
function switchClass12_1(num)
{
	if(FollowActive[num])
	{
		//debugger;
		if($(".impuls3_"+num)[0] != undefined)
		{
			//$(".impuls1_"+num).switchClass("impuls1_"+num, "impuls2_"+num, 600);
			$(".impuls3_"+num).switchClass("impuls3_"+num, "impuls4_"+num, 600);
		} else
		{
			//$(".impuls2_"+num).switchClass("impuls2_"+num, "impuls1_"+num, 600);	
			$(".impuls4_"+num).switchClass("impuls4_"+num, "impuls3_"+num, 600);
		}
		setTimeout("switchClass12_1(1)", 1200);
	}
}
function switchClass12_2(num)
{
	if(FollowActive[num])
	{
		//debugger;
		if($(".impuls3_"+num)[0] != undefined)
		{
			//$(".impuls1_"+num).switchClass("impuls1_"+num, "impuls2_"+num, 600);
			$(".impuls3_"+num).switchClass("impuls3_"+num, "impuls4_"+num, 600);
		} else
		{
			//$(".impuls2_"+num).switchClass("impuls2_"+num, "impuls1_"+num, 600);	
			$(".impuls4_"+num).switchClass("impuls4_"+num, "impuls3_"+num, 600);
		}
		setTimeout("switchClass12_2(2)", 1200);
	}
}
function switchClass12_3(num)
{
	if(FollowActive[num])
	{
		//debugger;
		if($(".impuls3_"+num)[0] != undefined)
		{
			//$(".impuls1_"+num).switchClass("impuls1_"+num, "impuls2_"+num, 600);
			$(".impuls3_"+num).switchClass("impuls3_"+num, "impuls4_"+num, 600);
		} else
		{
			//$(".impuls2_"+num).switchClass("impuls2_"+num, "impuls1_"+num, 600);	
			$(".impuls4_"+num).switchClass("impuls4_"+num, "impuls3_"+num, 600);
		}
		setTimeout("switchClass12_3(3)", 1200);
	}
}
var MarkerJump = [8,20,40,80,150,300,500];
function MoveMarker(_vehicleNo, newLon, newLat, _color, map0, map1, map2, map3, _dt, _status, _speed, _nocomm) {
    for (var i = 0; i < Vehicles.length; i++) {
        for (var j = 0; j < 4; j++) {
            //Timers[j] = [];
            if (Boards[j] != null) {
                if ((Vehicles[i].ID == _vehicleNo) && (Vehicles[i].Map == j)) {
                    if (Vehicles[i].el.style.display == "none")
                        return false;

                    var lonLat = new OpenLayers.LonLat(newLon, newLat).transform(new OpenLayers.Projection("EPSG:4326"), Maps[j].getProjectionObject());
                    // GLOBSY MAPS
					//if (MapType[j] == 'YAHOOM') { lonLat = new OpenLayers.LonLat(newLon, newLat) }

                    var newPx = Maps[j].getPixelFromLonLat(lonLat);

                    var p01 = Maps[j].getPixelFromLonLat(Vehicles[i].Marker.lonlat);
                    var p02 = Maps[j].getPixelFromLonLat(lonLat);
                    var p1 = Maps[j].getLayerPxFromViewPortPx(p01);
                    var p2 = Maps[j].getLayerPxFromViewPortPx(p02);

                    var dX = p2.x - p1.x;
                    var dY = p2.y - p1.y;
                    var alfa = Math.round(Math.atan2((-1) * dY, dX) * (180 / Math.PI));
                    alfa = 0 - alfa
                    var alfa1 = 0 - alfa;
                    if ((dX == 0) && (dY == 0)) {
                        alfa = Vehicles[i].angle
                    }
                    if(tmpCheckGroup != '')
                    	if(tmpCheckGroup[1] != undefined)
                    		if (tmpCheckGroup[1][Vehicles[i].ID] == 1)
                    		{
                    			if(alfa1 < 0) {
									alfa1 = 180 + (180 - alfa1 * (-1));
								}
								drawDirectionLive(j, newLon, newLat, Vehicles[i].ID, Vehicles[i].Reg, _dt, alfa1, i);
							}
                    var radius = 14;
                    var pi = 3.14159;
                    var cosAlfa = Math.cos(alfa * (pi / 180));
                    var sinAlfa = Math.sin(alfa * (pi / 180));
                    var nPozX = ((cosAlfa * radius) - 4) + 24;
                    var nPozY = ((sinAlfa * radius) - 4) + 24;
                    Vehicles[i].Color = _color;
                    //Vehicles[i].el.innerHTML = '<div style="visibility: hidden;" class="impuls1"></div><div style="visibility: hidden;" class="impuls3 gnMarkerPulsing' + _color + '"></div><div class="gnMarker' + _color + ' text3"><strong>' + _vehicleNo + '</strong></div></div>'

                    Vehicles[i].el.children[0].className = "gnMarker" + _color + " text3";
                    Vehicles[i].el.children[1].className = "gnMarkerPointer" + _color;
                    
                    Vehicles[i].el.children[1].style.left = nPozX + 'px';
                    Vehicles[i].el.children[1].style.top = nPozY + 'px';
                    
					$('#img-vehicle-' + j + '-' + _vehicleNo).remove();
					/*if(_status == '0')
					{
						//Vehicles[i].Marker.events.element.innerHTML += ;
						$($(Vehicles[i].Marker.events.element).children()[0]).append('<div id="img-vehicle-' + j + '-' + _vehicleNo + '" style="height: 16px; background-image: url(\'../images/nosignal.png\'); position: absolute; width: 16px; z-index: 9; left: 12px; top: 12px;"></div>');
					} else
					{*/
						if(_nocomm)
						{
							$($(Vehicles[i].Marker.events.element).children()[0]).append('<div id="img-vehicle-' + j + '-' + _vehicleNo + '" style="height: 16px; background-image: url(\'../images/nocommunication.png\'); position: absolute; width: 16px; z-index: 9; left: 12px; top: 12px;"></div>');
						}
					//}

                	if(Vehicles[i].el.children[2] != undefined)
					{
						//Vehicles[i].el.children[2].className = "impuls1_0 gnMarkerBorder" + _color;
						Vehicles[i].el.children[2].className = "impuls3_" + j + " gnMarkerPulsing" + _color;
					}
                    //Vehicles[i].el.innerHTML += '<div class="gnMarkerPointer' + _color + '" style="left:' + nPozX + 'px; top:' + nPozY + 'px; height:6px; width:6px; position:absolute; display:box; font-size:4px"></div>'
                    //Vehicles[i].el.innerHTML += '<div class="gnMarkerPointer' + _color + '" style="left:' + nPozX + 'px; top:' + nPozY + 'px; height:6px; width:6px; position:absolute; display:box; font-size:4px"></div>'
                    //}
                    
                    if (j == 0) { Vehicles[i].Marker.display(map0) }
                    if (j == 1) { Vehicles[i].Marker.display(map1) }
                    if (j == 2) { Vehicles[i].Marker.display(map2) }
                    if (j == 3) { Vehicles[i].Marker.display(map3) }

                    if (parseInt(Maps[j].zoom, 10) > 11) {
                        var ztemp = MarkerJump[parseInt(Maps[j].zoom, 10) - 12];
                        if (Math.abs(p1.x - p2.x) > ztemp)
                            var jump = true;
                        else
                            if(Math.abs(p1.y - p2.y) > ztemp)
                                var jump = true;
                            else
                                var jump = false;
                    }
//                    if (j == 0)
//                        if (Vehicles[i].ID == "35") {
//                            document.getElementById("testText").value = Vehicles[i].ID + "   |   " + Math.abs(p1.x - p2.x) + "   |    " + Math.abs(p1.y - p2.y) + "   Z=" + Maps[j].zoom + "   |   " + jump;
//                        }
                    if(RecOnNewAll)
                    {
                    	MoveMoveMarkerStep(i, p2.x, p2.y, j);
                    } else
	              	{
	                	//if (resetScreen[j] || jump) {
                	    if(true) {
	                        //if(i == 5)
	                            //debugger;
	                        /*
	                         	$(Vehicles[i].el).fadeOut("fast");
	                        	setTimeout("MoveMoveMarkerStep(" + i + ", " + p2.x + ", " + p2.y + ", " + j + ");", 200);
	                         */
							//$(Vehicles[i].el).css({ display: 'none' });
	                        MoveMoveMarkerStep(i, p2.x, p2.y, j);
	                    } else {
	                   	//if(RecOnNewAll)
	                   	//{
	                   		//MoveMoveMarkerStep(i, p2.x, p2.y, j);
	                   	//} else
	               		//{
	                        
	                        
                            //Timers[j][i] = null;
	                        //Timers[j][i] = [];
	                        //ResetTimersVeh(j, i);
	                        
	                        for (var cc = 1; cc <= 25; cc++) {
                                if (Timers[j][i] != null) {
                                    if (Timers[j][i][cc] != null && Timers[j][i][cc] != "") {
                                        if(cc==25) {
                                            MoveMoveMarkerStep(i, parseFloat(TimersData[j][i][cc].split(',')[0]), parseFloat(TimersData[j][i][cc].split(',')[1]), j);
                                            p1.x = parseFloat(TimersData[j][i][cc].split(',')[0]);
                                            p1.y = parseFloat(TimersData[j][i][cc].split(',')[1]);
                                        }
                                        window.clearTimeout(Timers[j][i][cc]);
                                    }
                                }
                            }
                            Timers[j][i] = null;
                            Timers[j][i] = [];
                            TimersData[j][i] = null;
                            TimersData[j][i] = [];
                            
                            var stepX = (p2.x - p1.x) / 25;
                            var stepY = (p2.y - p1.y) / 25;
                            var tmr = 0;
    
                            var stepT = 3000 / 25;
	                        
	                        
	                        var pom1 = p1;

	                        if ((stepX == 0) && (stepY == 0)) {
	                        	if($('#div-please-wait').css('display') == "block")
	                        		HideWait();
	                    	} else {
	                            for (var cc = 1; cc <= 25; cc++) {
	
	                                pom1.x = pom1.x + (stepX);
	                                pom1.y = pom1.y + (stepY);
	                                TimersData[j][i][cc] = pom1.x + "," + pom1.y;
	                                Timers[j][i][cc] = window.setTimeout("MoveMoveMarker(" + i + "," + pom1.x + "," + pom1.y + "," + j + ", " + cc + ")", tmr);
	                                tmr = tmr + stepT;
	                            }
	                        }
	                    }
	                }

                    Vehicles[i].Lon = newLon
                    Vehicles[i].Lat = newLat
                    Vehicles[i].angle = alfa

                    if(_speed != undefined)
                    {
                    	if(_speed < 5)
                    	{
                    		setTimeout("Vehicles[" + i + "].el.children[1].style.display = 'none';", 3000);
                    	} else
                    	{
                    		Vehicles[i].el.children[1].style.display = 'block';
                    	}
                    }

                    //Vehicles[i].Marker.moveTo(newPx)
                }
            }
        }
    }
}
function MoveMarkerBack(_vehicleNo, newLon, newLat, _color, map0, map1, map2, map3, _dt, _status, _speed, _nocomm) {
    for (var i = 0; i < Vehicles.length; i++) {
        for (var j = 0; j < 5; j++) {
            //Timers[j] = [];
            if (Boards[j] != null) {
                if ((Vehicles[i].ID == _vehicleNo) && (Vehicles[i].Map == j)) {
                    if (Vehicles[i].el.style.display == "none")
                        return false;

                    var lonLat = new OpenLayers.LonLat(newLon, newLat).transform(new OpenLayers.Projection("EPSG:4326"), Maps[j].getProjectionObject());
                    //GLOBSY MAPS
					//if (MapType[j] == 'YAHOOM') { lonLat = new OpenLayers.LonLat(newLon, newLat) }

                    var newPx = Maps[j].getPixelFromLonLat(lonLat);

                    var p01 = Maps[j].getPixelFromLonLat(Vehicles[i].Marker.lonlat);
                    var p02 = Maps[j].getPixelFromLonLat(lonLat);
                    var p1 = Maps[j].getLayerPxFromViewPortPx(p01);
                    var p2 = Maps[j].getLayerPxFromViewPortPx(p02);

                    var dX = p2.x - p1.x;
                    var dY = p2.y - p1.y;
                    var alfa = Math.round(Math.atan2((-1) * dY, dX) * (180 / Math.PI));
                    alfa = 0 - alfa
                    if ((dX == 0) && (dY == 0)) {
                        alfa = Vehicles[i].angle
                    }
                    alfa = alfa - 180;
                    var radius = 14;
                    var pi = 3.14159;
                    var cosAlfa = Math.cos(alfa * (pi / 180));
                    var sinAlfa = Math.sin(alfa * (pi / 180));
                    var nPozX = ((cosAlfa * radius) - 4) + 24;
                    var nPozY = ((sinAlfa * radius) - 4) + 24;
                    Vehicles[i].Color = _color;
                    //Vehicles[i].el.innerHTML = '<div style="visibility: hidden;" class="impuls1"></div><div style="visibility: hidden;" class="impuls3 gnMarkerPulsing' + _color + '"></div><div class="gnMarker' + _color + ' text3"><strong>' + _vehicleNo + '</strong></div>'
                    //Vehicles[i].el.innerHTML = '<div class="gnMarker' + _color + ' text3"><strong>' + _vehicleNo + '</strong></div>'

                    Vehicles[i].el.children[0].className = "gnMarker" + _color + " text3";
                    Vehicles[i].el.children[1].className = "gnMarkerPointer" + _color;
                    Vehicles[i].el.children[1].style.left = nPozX + 'px';
                    Vehicles[i].el.children[1].style.top = nPozY + 'px';
                    if(_speed != undefined)
                    {
                    	if(_speed < 5)
                    	{
                    		Vehicles[i].el.children[1].style.display = 'none';
                    	} else
                    	{
                    		Vehicles[i].el.children[1].style.display = 'block';
                    	}
                    }
                    $('#img-vehicle-' + j + '-' + _vehicleNo).remove();
					/*if(_status == '0')
					{
						//Vehicles[i].Marker.events.element.innerHTML += ;
						$($(Vehicles[i].Marker.events.element).children()[0]).append('<div id="img-vehicle-' + j + '-' + _vehicleNo + '" style="height: 16px; background-image: url(\'../images/nosignal.png\'); position: absolute; width: 16px; z-index: 9; left: 12px; top: 12px;"></div>');
					} else
					{*/
						if(_nocomm)
						{
							$($(Vehicles[i].Marker.events.element).children()[0]).append('<div id="img-vehicle-' + j + '-' + _vehicleNo + '" style="height: 16px; background-image: url(\'../images/nocommunication.png\'); position: absolute; width: 16px; z-index: 9; left: 12px; top: 12px;"></div>');
						}
					//}
                    
                    if(Vehicles[i].el.children[2] != undefined)
					{
						//Vehicles[i].el.children[2].className = "impuls1_0 gnMarkerBorder" + _color;
						Vehicles[i].el.children[2].className = "impuls3_"+j+" gnMarkerPulsing" + _color;
					}
                    
                    //if ((dX == 0) && (dY == 0)) {
                        //Vehicles[i].el.innerHTML += '<div class="gnMarkerPointer' + _color + '" style="left:' + nPozX + 'px; top:' + nPozY + 'px; height:6px; width:6px; position:absolute; display:box; font-size:4px"></div>'
                    //} else {
                        //Vehicles[i].el.innerHTML += '<div class="gnMarkerPointer' + _color + '" style="left:' + nPozX + 'px; top:' + nPozY + 'px; height:6px; width:6px; position:absolute; display:box; font-size:4px"></div>'
                    //}

                    if (j == 0) { Vehicles[i].Marker.display(map0) }
                    if (j == 1) { Vehicles[i].Marker.display(map1) }
                    if (j == 2) { Vehicles[i].Marker.display(map2) }
                    if (j == 3) { Vehicles[i].Marker.display(map3) }

                    if (parseInt(Maps[j].zoom, 10) > 11) {
                        var ztemp = MarkerJump[parseInt(Maps[j].zoom, 10) - 12];
                        if (Math.abs(p1.x - p2.x) > ztemp)
                            var jump = true;
                        else
                            if (Math.abs(p1.y - p2.y) > ztemp)
                                var jump = true;
                            else
                                var jump = false;
                    }
                    //                    if (j == 0)
                    //                        if (Vehicles[i].ID == "35") {
                    //                            document.getElementById("testText").value = Vehicles[i].ID + "   |   " + Math.abs(p1.x - p2.x) + "   |    " + Math.abs(p1.y - p2.y) + "   Z=" + Maps[j].zoom + "   |   " + jump;
                    //                        }
                    if(RecOnNewAll)
                    {
                    	MoveMoveMarkerStep(i, p2.x, p2.y, j);
                    } else
                	{
	                    //if (resetScreen[j] || parseInt(Maps[j].zoom, 10) < 12 || jump) {
                        if(true) {
	                        //if(i == 5)
	                        //debugger;
	                        //$(Vehicles[i].el).css({ display: 'none' });
	                        MoveMoveMarkerStep(i, p2.x, p2.y, j);
	                    } else {
	                        var stepX = (p2.x - p1.x) / 25;
	                        var stepY = (p2.y - p1.y) / 25;
	                        var tmr = 0;
	
	                        var stepT = 3000 / 25;
	                        //Timers[j][i] = [];
	                        //ResetTimersVeh(j, i);
	                        var pom1 = p1;
	
	                        if ((stepX == 0) && (stepY == 0)) { } else {
	                            for (var cc = 1; cc <= 25; cc++) {
	
	                                pom1.x = pom1.x + (stepX);
	                                pom1.y = pom1.y + (stepY);
	                                Timers[j][i][cc] = window.setTimeout("MoveMoveMarker(" + i + "," + pom1.x + "," + pom1.y + "," + j + ", " + cc + ")", tmr);
	                                tmr = tmr + 120;
	                            }
	                        }
                    }
                    }

                    Vehicles[i].Lon = newLon
                    Vehicles[i].Lat = newLat
                    Vehicles[i].angle = alfa

                    //Vehicles[i].Marker.moveTo(newPx)			

                }
            }
        }
    }
}
function createDirection_Rec(prevLon, prevLat, newLon, newLat) {

    var lonLat = new OpenLayers.LonLat(newLon, newLat).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject());
    //if (MapType[0] == 'YAHOOM') { lonLat = new OpenLayers.LonLat(newLon, newLat) }

    var prevlonLat = new OpenLayers.LonLat(prevLon, prevLat).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject());
    //if (MapType[0] == 'YAHOOM') { prevlonLat = new OpenLayers.LonLat(prevLon, prevLat) }

    
    var p01 = Maps[0].getPixelFromLonLat(prevlonLat);
    var p02 = Maps[0].getPixelFromLonLat(lonLat);
    var p1 = Maps[0].getLayerPxFromViewPortPx(p01);
    var p2 = Maps[0].getLayerPxFromViewPortPx(p02);

    var dX = p2.x - p1.x;
    var dY = p2.y - p1.y;
    var alfa = Math.round(Math.atan2((-1) * dY, dX) * (180 / Math.PI));

    if ((dX == 0) && (dY == 0)) {
    //alert("stop")
        return
    }
    if (alfa < 0) {alfa = 360 + alfa }
    var imagee = twopoint + "/images/"

    if (alfa > 22 && alfa <= 67) {
        imagee += "sDesnoGore.png"
    }
    if (alfa > 67 && alfa <= 112) {
        imagee += "sGore.png"
    }
    if (alfa > 112 && alfa <= 157) {
        imagee += "sLevoGore.png"
    }
    if (alfa > 157 && alfa <= 202) {
        imagee += "sLevo.png"
    }
    if (alfa > 202 && alfa <= 247) {
        imagee += "sLevoDolu.png"
    }
    if (alfa > 247 && alfa <= 292) {
        imagee += "sDole.png"
    }
    if (alfa > 292 && alfa <= 337) {
        imagee += "sDesnoDolu.png"
    }
    if (alfa > 337 || alfa <= 22) {
        imagee += "sDesno.png"
    }
    if (imagee != imagePrev) {
        if (numberDiff < 10) {
            numberDiff += 1
        } else {

            var size = new OpenLayers.Size(16, 16);
            var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h + 5); };
            var icon = new OpenLayers.Icon(imagee, size, null, calculateOffset);

            if (Maps[0] != null) {
                var ll = new OpenLayers.LonLat(parseFloat(prevLon), parseFloat(prevLat)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject())
                //if (MapType[0] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(prevLon), parseFloat(prevLat)) }
                var MyMar = new OpenLayers.Marker(ll, icon)
                var markers = Markers[0];

                markers.addMarker(MyMar);
                MyMar.events.element.style.zIndex = 666
                tmpMarkersRec[tmpMarkersRec.length] = MyMar;

            }
            numberDiff = 0
        }
    }
    imagePrev = imagee
    return alfa
}


function MoveMarker_Rec(newLon, newLat, _color) {
    var lonLat = new OpenLayers.LonLat(newLon, newLat).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject());
    //if (MapType[0] == 'YAHOOM') { lonLat = new OpenLayers.LonLat(newLon, newLat) }
    //alert(document.body.clientWidth + "   " + document.body.clientHeight)
    var newPx = Maps[0].getPixelFromLonLat(lonLat);
    var newp1 = Maps[0].getLayerPxFromViewPortPx(newPx);

    if (newPx.x < 0 || newPx.x > document.body.clientWidth || newPx.y < 0 || newPx.y > document.body.clientHeight) {
        if (MapType[0] == 'YAHOOM') {
            //Maps[0].setCenter(new OpenLayers.LonLat(newLon, newLat), Maps[0].getZoom());
			Maps[0].setCenter(new OpenLayers.LonLat(newLon, newLat).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject()), Maps[0].getZoom());
        
		} else {
            Maps[0].setCenter(new OpenLayers.LonLat(newLon, newLat).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject()), Maps[0].getZoom());
        }
    }
    tmpMarkersRec[tmpMarkersRec.length - 1].moveTo(newp1);
    tmpMarkersRec[tmpMarkersRec.length - 1].events.element.innerHTML = '<div class="gnPOI2" style="background-color: #' + _color + '"; display:box; font-size:4px"></div>';
}

function MoveMoveMarkerStep(_i, pX, pY, _j){
    //var lonLat = new OpenLayers.LonLat(pX, pY).transform(Maps[0].getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
    
    var pom1 = new OpenLayers.Pixel(pX, pY);
	Vehicles[_i].Marker.moveTo(pom1);
	var lonLat = new OpenLayers.LonLat(Vehicles[_i].Marker.lonlat.lon, Vehicles[_i].Marker.lonlat.lat).transform(Maps[_j].getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
	var carID = Vehicles[_i].ID + '';
	var VehReg = Vehicles[_i].Reg;

	if(!RecOnNewAll)
		//setTimeout("$(Vehicles[" + _i + "].el).fadeIn('slow');", 1000);
	//if (LastPointsLon.length > 0) {
	    if (tmpCheckGroup[1] != undefined) {
	    	//if(carID == "6")
					//debugger;
	        if (tmpCheckGroup[1][Vehicles[_i].ID] == 1) {
	        	
	            //document.getElementById("testText").value = VehReg;
	            if(RecOnNewAll)
	            	DrawPathAgain(LastPointsLon[_j][carID] + ',' + lonLat.lon, LastPointsLat[_j][carID] + ',' + lonLat.lat, carID, _j, _i, VehReg);
	            else
	            	if(document.getElementById('cb-vehicle-' + _j + '-' + Vehicles[_i].ID).checked)
                		DrawPathAgain(LastPointsLon[_j][carID] + ',' + lonLat.lon, LastPointsLat[_j][carID] + ',' + lonLat.lat, carID, _j, _i, VehReg);
	        }
	        else
	            var nothing = "";
	    } else {
	        //document.getElementById("testText").value = VehReg + " - 1";
	        if(RecOnNewAll)
	        	DrawPathAgain(LastPointsLon[_j][carID] + ',' + lonLat.lon, LastPointsLat[_j][carID] + ',' + lonLat.lat, carID, _j, _i, VehReg);
	        else
	        	if(document.getElementById('cb-vehicle-' + _j + '-' + Vehicles[_i].ID).checked)
	        		DrawPathAgain(LastPointsLon[_j][carID] + ',' + lonLat.lon, LastPointsLat[_j][carID] + ',' + lonLat.lat, carID, _j, _i, VehReg);
	    }
	//}
}
function MoveMoveMarker(_i, pX, pY, _j, _cc) {
    //var lonLat = new OpenLayers.LonLat(pX, pY).transform(Maps[0].getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
    if (resetScreen[_j]) { return false; }

    //if (_i == 8)
    //    document.getElementById("testText").value = Vehicles[_i].ID + "  =   " + pX + "  |  " + pY;

    if (Vehicles[_i] != undefined) {
        var pom1 = new OpenLayers.Pixel(pX, pY);
        Vehicles[_i].Marker.moveTo(pom1);
        var lonLat = new OpenLayers.LonLat(Vehicles[_i].Marker.lonlat.lon, Vehicles[_i].Marker.lonlat.lat).transform(Maps[_j].getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
        var carID = Vehicles[_i].ID + '';
        var VehReg = Vehicles[_i].Reg;
        Timers[_j][_i][_cc] = '';
        if(TimersData[_j][_i] != undefined)
            TimersData[_j][_i][_cc] = '';
        //if (LastPointsLon.length > 0) {
            if (tmpCheckGroup[1] != undefined) {
                if (tmpCheckGroup[1][Vehicles[_i].ID] == 1) {
                    //document.getElementById("testText").value = VehReg;
                    if(RecOnNewAll)
                    	DrawPathAgain(LastPointsLon[_j][carID] + ',' + lonLat.lon, LastPointsLat[_j][carID] + ',' + lonLat.lat, carID, _j, _i, VehReg);
                    else
                    	if(document.getElementById('cb-vehicle-' + _j + '-' + Vehicles[_i].ID).checked)
                    		DrawPathAgain(LastPointsLon[_j][carID] + ',' + lonLat.lon, LastPointsLat[_j][carID] + ',' + lonLat.lat, carID, _j, _i, VehReg);
                }
                else
                    var nothing = "";
            } else {
                //document.getElementById("testText").value = VehReg + " - 1";
                if(RecOnNewAll)
                	DrawPathAgain(LastPointsLon[_j][carID] + ',' + lonLat.lon, LastPointsLat[_j][carID] + ',' + lonLat.lat, carID, _j, _i, VehReg);
                else
                	if(document.getElementById('cb-vehicle-' + _j + '-' + Vehicles[_i].ID).checked)
                		DrawPathAgain(LastPointsLon[_j][carID] + ',' + lonLat.lon, LastPointsLat[_j][carID] + ',' + lonLat.lat, carID, _j, _i, VehReg);
            }
        //}
    }
}

function GetCenterOfMap(num){
	var lonlat
	
	if (Maps[num].getProjectionObject()!= "EPSG:4326") {
	    if (MapType[num] == 'YAHOOM') {
			//lonlat = Maps[num].getExtent().getCenterLonLat()
			lonlat = Maps[num].getExtent().getCenterLonLat().transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));	
		
		} else {
			lonlat = Maps[num].getExtent().getCenterLonLat().transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));	
		}
		
	} else {
		lonlat = Maps[num].getExtent().getCenterLonLat()
	}
	return lonlat
}

function GetZoomLevel(num){
		return Maps[num].getZoom()
}

function ParseCarStrAjax(str){
    var c = str.split("#");
	for (var i=1; i<c.length; i++){
		var p = c[i].split("|");
		var _car = new CarType(p[0], p[3], p[1], p[2], p[13]);
		_car.passive = p[4];
		_car.datum = p[5];
		_car.location = p[6];
		if(p[7] == "/")
		{
			_car.speed=p[7];
		} else
		{
			_car.speed=parseInt(p[7], 10) + ' Km/h';
			if(metric == "mi")
				_car.speed = Math.round((parseFloat(p[7])*0.621371)*100)/100+' mph';
		}
		_car.taxi=p[8];
		_car.sedista=p[9];
		_car.olddate = p[10];
		_car.address = p[11];
		_car.gis = p[12];
		_car.alarm = p[14];
		_car.fulldt = p[15];
		_car.cbfuel = p[16];
		_car.cbrpm = p[17];
		_car.cbtemp = p[18];
		_car.cbdistance = p[19];
		_car.temperature = p[20];
		_car.litres = p[21];
		_car.zoneids = p[22];
		_car.odometar = p[23];
        if (metric == "mi") _car.odometar = Math.round(p[23] * 0.621371);
		_car.service = p[24];
        if (metric == "mi") _car.service = Math.round(p[24] * 0.621371);
		_car.status = p[25];
		_car.zonedt = p[26];

		for (var j =0; j<Car.length; j++){
			if (Car[j].id == p[0]) {
				var m0=Car[j].map0
				var m1=Car[j].map1
				var m2=Car[j].map2
				var m3=Car[j].map3
				if ((_car.lon == Car[j].lon) && (_car.lat == Car[j].lat) && (_car.datum == Car[j].datum)){
					_car.same = true
				} else {
					_car.same = false
				}
				_car.map0 = m0; _car.map1 = m1; _car.map2 = m2; _car.map3 = m3; 	
				Car[j]=_car; 
			}
		}
	}
}

function Ajax() {
    AjaxStarted = true;
    //getVehicleArea()
    
	if (LoadCurrentPosition == false) {return false}
	
	if(FirstLoad)
		var _page = './getCurrentposzone.php';
	else
		var _page = './getCurrentpos.php';

	var xmlHttp; var str = ''
	var el = this._Element
	try { xmlHttp = new XMLHttpRequest(); } catch (e) {
		try
	  { xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); }
		catch (e) { try { xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) { alert("Your browser does not support AJAX!"); return false; } }
	}

	xmlHttp.onreadystatechange = function () {
	    if (xmlHttp.readyState == 4) {
	        str = xmlHttp.responseText;
	        str = str.replace(/\r/g,'').replace(/\n/g,'');
	        //str = JXG.decompress(str);
	        //debugger;
	        
			if(str.indexOf("@%@^") != -1)
			{
				if(document.getElementById("iFrmS") != null)
				{
					if($('#iFrmS')[0].contentWindow.document.getElementById('report-content') != null)
					{
						if($('#iFrmS')[0].contentWindow.document.URL.indexOf('Nalozi') != -1 )
						{
							var tourch = str.split("@%@^")[0];
							str = str.split("@%@^")[1];
							tourch = tourch.split("#");
							var arrRow = new Array();
							//$('#iFrmS')[0].contentWindow.$('.clearRow').html('');
							$('#iFrmS')[0].contentWindow.document.getElementsByClassName("clearRow").innerHTML = '';
							for (var j = 1; j < tourch.length; j++) {
								arrRow = tourch[j].split("|");
								//if($('#iFrmS')[0].contentWindow.$('#'+arrRow[0])[0].children[2].innerHTML.indexOf(":") = -1)
								//{
									if(arrRow[7] != "")
										if(arrRow[7].split(" ")[1].indexOf(".") == -1)
											arrRow[7] = arrRow[7] + ".001";
									if($('#iFrmS')[0].contentWindow.$('#'+arrRow[0]).parent().children()[0] != undefined)
									{
										if(parseInt($('#iFrmS')[0].contentWindow.$('#'+arrRow[0]).parent().children()[0].innerHTML, 10) != parseInt(arrRow[4], 10) && arrRow[2] != "/")
										{
											if($('#iFrmS')[0].contentWindow.$('#'+arrRow[0])[0].children[0].className != "notifyOutOfOrder")
												AlertEvent(arrRow[7], arrRow[6].split(" - ")[1], 'unOrdered', arrRow[5]);
											var alarmorder = "<input readonly class='notifyOutOfOrder' ";
										} else
											var alarmorder = "<input readonly class='notifyInOrder' ";
									} else
										var alarmorder = "<input readonly class='notifyInOrder' ";
									if($('#iFrmS')[0].contentWindow.document.getElementById("vnz_"+arrRow[0].split("_")[0]) != null)
									{
										if(parseInt(arrRow[3].split(":")[2], 10)+parseInt(arrRow[3].split(":")[1], 10)*60+parseInt(arrRow[3].split(":")[0], 10)*3600 > parseInt($('#iFrmS')[0].contentWindow.document.getElementById("vnz_"+arrRow[0].split("_")[0]).innerHTML, 10)*60)
										{
											if($('#iFrmS')[0].contentWindow.$('#'+arrRow[0])[0].children[3].className != "notifyOutOfOrder")
												AlertEvent(arrRow[7], arrRow[6].split(" - ")[1], 'stayMoreThanAllow', arrRow[5]);
											var alarmstay = "<input readonly class='notifyOutOfOrder' ";
										} else
											var alarmstay = "<input readonly class='notifyInOrder' ";
									} else
										var alarmstay = "<input readonly class='notifyInOrder' ";
									strAR = dic("Tracking.ONumber",lang)+": " + alarmorder + " value='" + arrRow[4] + "' />&nbsp;&nbsp;&nbsp;"+ dic("Tracking.Arrival",lang) + ": <span style='color:#040'>" + arrRow[1] + "</span>&nbsp;&nbsp;&nbsp;" +dic("Tracking.Departure",lang) + ": <span style='color:#800'>" + arrRow[2] + "</span>&nbsp;&nbsp;&nbsp;" + dic("Tracking.Idling",lang) +": " + alarmstay + " style='width: 50px' value='" + arrRow[3] + "' /></span>";
									$('#iFrmS')[0].contentWindow.$('#'+arrRow[0]).html(strAR);
								//}
							}
						}
					}
				}
			}
			var str1 = str.split("^^@@")[1];
			str = str.split("^^@@")[0];

			if (str1 == 0 || allowedMess != '1') {
				$('#mailNew').css({ visibility: 'hidden' });
			} else {
				$('#mailNew').html(str1);
				$('#mailNew').css({ visibility: 'visible' });
			}
	        ParseCarStrAjax(str)
	        
	        var tmr = 0;
			//AlertEvent('2013-03-22 09:40:06.548','SK-0005-AB','alarmpanic', '2061')
			//AlertEvent(Car[3].fulldt, Car[3].reg, "alarmpanic", VehcileIDs[3]);
			
			//$('.allzones').html("");
			for (var j = 0; j < Car.length; j++) {
				var svc = document.getElementById('div-sv-' + Car[j].id);
				
	        	if(!Car[j].same || $('#vh-small-'+Car[j].id).attr('class').indexOf('Gray') != -1)
        		{
	        		if(AlarmsTypeArray.indexOf("," + Car[j].alarm + ",") != -1)
	        			AlertEvent(Car[j].fulldt, Car[j].reg, Car[j].alarm, VehcileIDs[j]);

	        		if (svc != null)
	        		{
	        			if(!(svc.className.replace("gnMarkerList", "").replace(" text3", "") == Car[j].color && Car[j].color == "Red"))
	        			{
        					MoveMarker(Car[j].id, parseFloat(Car[j].lon), parseFloat(Car[j].lat), Car[j].color, Car[j].map0, Car[j].map1, Car[j].map2, Car[j].map3, Car[j].datum, Car[j].status, parseInt(Car[j].speed, 10));
        				}
        			}
	           	} 
	            if (svc != null) {
	            	/*if(Car[j].status == '0')
	            	{
	            		$('#img-pass-' + Car[j].id).remove();
	            		$('#img-sv-' + Car[j].id).remove();
	            		$('#img-small-' + Car[j].id).remove();
	            		$('#div-pass-' + Car[j].id).append('<img id="img-pass-' + Car[j].id + '" style="height: 13px; position: relative; width: 13px; margin-left: 11px; margin-top: -4px;" src="../images/nosignal.png">');
	            		$('#div-sv-' + Car[j].id).append('<img id="img-sv-' + Car[j].id + '" style="height: 13px; position: relative; width: 13px; margin-left: 11px; margin-top: -4px;" src="../images/nosignal.png">');
	            		$('#vh-small-' + Car[j].id).append('<img id="img-small-' + Car[j].id + '" style="height: 13px; width: 13px; top: -3px; position: relative; left: 6px;" src="../images/nosignal.png">');
	            	} else
	            	{
	            		$('#img-pass-' + Car[j].id).remove();
	            		$('#img-sv-' + Car[j].id).remove();
	            		$('#img-small-' + Car[j].id).remove();
	            	}*/
	                svc.className = 'gnMarkerList' + Car[j].color + ' text3'
	                if (Car[j].passive == '0') { $('#div-pass-' + Car[j].id).css({ opacity: '0.3' }) } else { $('#div-pass-' + Car[j].id).css({ opacity: '1' }) }
	                $('#vh-date-' + Car[j].id).html(Car[j].datum)
	                if (Car[j].olddate == '1') { $('#vh-date-' + Car[j].id).css("color", "#FF0000") } else { $('#vh-date-' + Car[j].id).css("color", "009933") }

	                document.getElementById('vh-small-' + Car[j].id).className = 'gnMarkerList' + Car[j].color + ' text3'
	                if (Car[j].same == false) { getAddress(Car[j].lon, Car[j].lat, 'vh-location-' + Car[j].id) }

	                if (parseInt(Car[j].cbfuel, 10) == 0 && parseInt(Car[j].cbrpm, 10) == 0 && (parseInt(Car[j].cbtemp, 10) == 0 || parseInt(Car[j].cbtemp, 10) == -40) && parseInt(Car[j].cbdistance, 10) == 0)
	                	$('#vh-canbus-' + Car[j].id).css({ display: "none" });
                	else
                	{
                		$('#vh-canbus-' + Car[j].id).css({ display: "block" });
		                if (parseInt(Car[j].cbfuel, 10) == 0)
		                    $('#vh-cbfuel1-' + Car[j].id).css({ display: "none" });
		                else
							{
								$('#vh-cbfuel1-' + Car[j].id).css({ display: "block" });
								if(liq == 'galon')
								   $('#vh-cbfuel-' + Car[j].id).html(Math.round(100*parseInt((Car[j].cbfuel * 0.264172), 10)/100) + ' gal');
							    else
								$('#vh-cbfuel-' + Car[j].id).html(Math.round(100*parseInt(Car[j].cbfuel, 10)/100) + ' L');
							}

		                if (parseInt(Car[j].cbrpm, 10) == 0)
		                    $('#vh-cbrpm1-' + Car[j].id).css({ display: "none" });
		                else
							{
								$('#vh-cbrpm1-' + Car[j].id).css({ display: "block" });
								$('#vh-cbrpm-' + Car[j].id).html(Math.round(Car[j].cbrpm) + ' rpm');
							}
		                if (parseInt(Car[j].cbtemp, 10) == 0)
		                    $('#vh-cbtemp1-' + Car[j].id).css({ display: "none" });
		                else
							{
								$('#vh-cbtemp1-' + Car[j].id).css({ display: "block" });
								$('#vh-cbtemp-' + Car[j].id).html(Math.round(converttemp(Car[j].cbtemp, tempunit)) + ' °' + tempunit);
							}
							
						if (parseInt(Car[j].cbdistance, 10) == 0)
		                    $('#vh-cbdistance1-' + Car[j].id).css({ display: "none" });
		                else
							{
								$('#vh-cbdistance1-' + Car[j].id).css({ display: "block" });
								var mmetric = ' Km';
								var kilom = Math.round(parseInt(Car[j].cbdistance, 10)/1000);
								if(metric == 'mi')
								{
									mmetric = ' miles';
									kilom = Math.round(Math.round(parseInt(Car[j].cbdistance, 10)/1000) * 0.621371);
								}
								if(Car[j].service != "")
								{
									if(parseInt(Car[j].service, 10) < 300)
										var _service = ' (<font style="color: Red;">'+commaSeparateNumber(Car[j].service)+' '+mmetric+'</font>)';
									else
										var _service = " ("+commaSeparateNumber(Car[j].service)+" "+mmetric+")";
								} else
								{
									var _service = "";
								}
								$('#vh-cbdistance-' + Car[j].id).html(commaSeparateNumber(kilom) + mmetric + _service);
								if(_service != "")
								{
									$('#vh-cbdistance-' + Car[j].id).mousemove(function (event) {
										if(parseInt($('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")).replace(".", ""), 10) < 300)
											var nexserv = '<font style="color: Red;">' + $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")) + '</font>';
										else
											var nexserv = $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")"));
					                    ShowPopup(event, dic('Reports.Past', lang) + ' ' + mmetric + ': <b>' + $('#'+this.id).html().substring(0, $('#'+this.id).html().indexOf("(")-1) + '</b><br/>Преостануваат <b>' + nexserv + '</b> до следен сервис!');
					                });
								} else
								{
									$('#vh-cbdistance-' + Car[j].id).mousemove(function (event) {
					                    ShowPopup(event, dic('Reports.Past', lang) + ' ' + mmetric + ': <b>' + $('#'+this.id).html() + '</b>');
					                });
								}
				                $('#vh-cbdistance-' + Car[j].id).mouseout(function () { HidePopup() });
							}
					}
					
					if(clientid == '367')
					{
						if(Car[j].zoneids != "")
		                {
		                	for(var z = 0; z < Car[j].zoneids.split(";").length; z++)
		                	{
		                		if(document.getElementById("div_zone_"+Car[j].zoneids.split(";")[z]+"_"+Car[j].id) != null)
		                		{
		                			$("div_zone_"+Car[j].zoneids.split(";")[z]+"_"+Car[j].id).remove()
		                		} else
		                		{
		                			var str = '';
			                		var cname = document.getElementById('vh-small-' + Car[j].id).className;
			                		str += '<div id="div_zone_'+Car[j].zoneids.split(";")[z]+'_'+Car[j].id+'" style="float:left; width:16px; height:16px; margin-left:2px; margin-bottom:2px; cursor:pointer" onclick="FindVehicleOnMap0(' + Car[j].id + ')" class="' + cname + '">' + Car[j].id + '</div>';
			                		$('#geo-fence-' + Car[j].zoneids.split(";")[z]).html($('#geo-fence-' + Car[j].zoneids.split(";")[z]).html() + str);
		                		}
	                		}
		                } else
	                	{
	                		for(var z = 0; z < Car[j].zoneids.split(";").length; z++)
		                	{
		                		if(document.getElementById("div_zone_"+Car[j].zoneids.split(";")[z]+"_"+Car[j].id) != null)
		                		{
		                			$("div_zone_"+Car[j].zoneids.split(";")[z]+"_"+Car[j].id).remove()
		                		}
		                	}
		                }
					} else
					{
						for (var q=0; q<$('#add_del_geofence').children().length; q++)
		                {
		                	var geoid = $($('#add_del_geofence').children()[q]).children()[2].id.split("-")[2];
		                	
		                	if(Car[j].zoneids == "")
		                	{
		                		$("#div_zone_"+geoid+"_"+Car[j].id).remove();
		                	} else
		                	{
		                		var imavozona = false;
		                		for(var z = 0; z < Car[j].zoneids.split(";").length; z++)
		                		{
		                			if(Car[j].zoneids.split(";")[z] == geoid)
		                			{
		                				imavozona = true;
		                				break;
		                			}
		                		}
	                			if(imavozona)
	                			{
	                				if(document.getElementById("div_zone_"+geoid+"_"+Car[j].id) == null)
	                				{
	                					var str = '';
		                				var cname = document.getElementById('vh-small-' + Car[j].id).className;
		                				if(Car[j].zonedt == '/')
		                					var zoneindt = Car[j].fulldt;
		                				else
		                					var zoneindt = Car[j].zonedt;
		                				str += '<div onmousemove="ShowPopup(event, \'Влез во зона: ' + formatdt1(zoneindt) + '\');" onmouseout="HidePopup()" id="div_zone_'+geoid+'_'+Car[j].id+'" style="float:left; width:16px; height:16px; margin-left:2px; margin-bottom:2px; cursor:pointer" onclick="FindVehicleOnMap0(' + Car[j].id + ')" class="' + cname + '">' + Car[j].id + '<input type="hidden" value="'+zoneindt+'"/></div>';
		                				if(FirstLoad)
		                				{
		                					if(Car[j].zonedt > $($('#geo-fence-' + geoid).children()[$('#geo-fence-' + geoid).children().length-1]).children().val())
			                				{
			                					$('#geo-fence-' + geoid).html($('#geo-fence-' + geoid).html() + str);
			                				} else
			                				{
			                					for(var t = $('#geo-fence-' + geoid).children().length-1; t >= 0; t--)
				                				{
				                					if(Car[j].zonedt > $($('#geo-fence-' + geoid).children()[t]).children().val())
				                					{
				                						break;
				                					}
				                				}
				                				var t = t + 1;
				                				$($('#geo-fence-' + geoid).children()[t]).before(str);
			                				}
		                				} else
		                				{
		                					$('#geo-fence-' + geoid).html($('#geo-fence-' + geoid).html() + str);
		                				}
	                				} else
	                				{
	                					var cname = document.getElementById('vh-small-' + Car[j].id).className;
	                					$("#div_zone_"+geoid+"_"+Car[j].id).removeAttr('class');
										$("#div_zone_"+geoid+"_"+Car[j].id).attr('class', '');
										$("#div_zone_"+geoid+"_"+Car[j].id)[0].className = cname;
	                				}
	                			} else
	                			{
	                				$("#div_zone_"+geoid+"_"+Car[j].id).remove();
	                			}
		                	}
		                }
					}
	                
	                if (Car[j].location == "")
	                    $('#vh-pp-pic-' + Car[j].id).css({ display: "none" });
	                else
	                    $('#vh-pp-pic-' + Car[j].id).css({ display: "block" });
                    
	                $('#vh-pp-' + Car[j].id).html(Car[j].location.replace(/;/g,";</br>"));
	                $('#vh-pp-pic-' + Car[j].id).mousemove(function (event) {
	                    ShowPopup(event, '<img src=\''+twopoint + '/images/poiButton.png\' style=\'position: relative; float: left; top: 2px; \' /><div style=\'position: relative; float: left; margin-left: 7px; padding-right: 3px;\'>' + dic('Poi', lang) + ':<br /><strong style="font-size: 14px;">' + $('#vh-pp-' + this.id.substring(this.id.lastIndexOf("-") + 1, this.id.length)).html() + '</strong></div>');
	                });
	                $('#vh-pp-pic-' + Car[j].id).mouseout(function () { HidePopup() });

	                if (Car[j].address == "")
	                    $('#vh-address-pic-' + Car[j].id).css({ display: "none" });
	                else
	                    $('#vh-address-pic-' + Car[j].id).css({ display: "block" });
	                Car[j].address = Car[j].address.replace(";", "<br>");
	                $('#vh-address-' + Car[j].id).html(Car[j].address);
	                $('#vh-address-pic-' + Car[j].id).mousemove(function (event) {
	                    ShowPopup(event, '<img src=\''+twopoint + '/images/areaImg.png\' style=\'position: relative; float: left; top: 2px; \' /><div style=\'position: relative; float: left; margin-left: 7px; padding-right: 3px;\'>' + dic('GFVeh', lang) + '<br /><strong style="font-size: 14px;">' + $('#vh-address-' + this.id.substring(this.id.lastIndexOf("-") + 1, this.id.length)).html() + '</strong></div>');
	                });
	                $('#vh-address-pic-' + Car[j].id).mouseout(function () { HidePopup() });
	                if (Car[j].gis == "")
	                    $('#vh-location-pic-' + Car[j].id).css({ display: "none" });
	                else
                    	$('#vh-location-pic-' + Car[j].id).css({ display: "block" });
	                $('#vh-location-' + Car[j].id).html(Car[j].gis);
	                $('#vh-location-pic-' + Car[j].id).mousemove(function (event) {
	                    ShowPopup(event, '<img src=\''+twopoint + '/images/shome.png\' style=\'position: relative; float: left; top: 2px; \' /><div style=\'position: relative; float: left; margin-left: 7px; padding-right: 3px;\'>' + dic('Street', lang) + '<br /><strong style="font-size: 14px;">' + $('#vh-location-' + this.id.substring(this.id.lastIndexOf("-") + 1, this.id.length)).html() + '</strong></div>');
	                });
	                $('#vh-location-pic-' + Car[j].id).mouseout(function () { HidePopup() });
					//var tmpsp = Car[j].speed
					//if(metric == 'mi')
						//tmpsp = Math.round(parseFloat(tmpsp) * 0.621371 * 100)/100 + ' miles';
						
					$('#vh-temp-' + Car[j].id).html(Math.round(converttemp(Car[j].temperature, tempunit) * 100)/100 + ' °' + tempunit);
					if(liq == 'galon')
						//$('#vh-litres-' + Car[j].id).html(Math.round(Car[j].litres * 100)/100 + ' L');
					    $('#vh-litres-' + Car[j].id).html(Math.round(100*parseInt((Car[j].litres * 0.264172), 10)/100) + ' gal');
				    else
					$('#vh-litres-' + Car[j].id).html(Math.round(Car[j].litres * 100)/100 + ' L');
					var mmetric = ' Km';
					if(metric == 'mi')
						mmetric = ' miles';

					if (parseInt(Car[j].cbfuel, 10) == 0 && parseInt(Car[j].cbrpm, 10) == 0 && (parseInt(Car[j].cbtemp, 10) == 0 || parseInt(Car[j].cbtemp, 10) == -40) && parseInt(Car[j].cbdistance, 10) == 0)
					{
						$('#vh-up-odometar-' + Car[j].id).css({ display: "block" });
						if(Car[j].odometar == "0")
						{
							$('#vh-odometar-' + Car[j].id).html('/');
						} else
						{
							if(Car[j].service != "")
							{
								if(parseInt(Car[j].service, 10) < 300)
									var _service = ' (<font style="color: Red;">'+commaSeparateNumber(Car[j].service)+' '+mmetric+'</font>)';
								else
									var _service = " ("+commaSeparateNumber(Car[j].service)+" "+mmetric+")";
							} else
							{
								var _service = "";
							}
							var currkm = commaSeparateNumber(Car[j].odometar) + mmetric;
							$('#vh-odometar-' + Car[j].id).html(currkm + _service);

							if(_service != "")
							{
								$('#vh-odometar-' + Car[j].id).mousemove(function (event) {
									if(parseInt($('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")).replace(".", ""), 10) < 300)
										var nexserv = '<font style="color: Red;">' + $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")) + '</font>';
									else
										var nexserv = $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")"));
				                    ShowPopup(event, dic('Reports.Past', lang) + ' ' + mmetric + ': <b>' + $('#'+this.id).html().substring(0, $('#'+this.id).html().indexOf("(")-1) + '</b><br/>Преостануваат <b>' + nexserv + '</b> до следен сервис!');
				                });
							} else
							{
								$('#vh-odometar-' + Car[j].id).mousemove(function (event) {
				                    ShowPopup(event, dic('Reports.Past', lang) + ' ' + mmetric + ': <b>' + $('#'+this.id).html() + '</b>');
				                });
							}
			                $('#vh-odometar-' + Car[j].id).mouseout(function () { HidePopup() });
						}
					} else
					{
						if (parseInt(Car[j].cbdistance, 10) == 0)
						{
							$('#vh-up-odometar-' + Car[j].id).css({ display: "block" });
							if(Car[j].odometar == "0")
							{
								$('#vh-odometar-' + Car[j].id).html('/');
							} else
							{
								if(Car[j].service != "")
								{
									if(parseInt(Car[j].service, 10) < 300)
										var _service = ' (<font style="color: Red;">'+commaSeparateNumber(Car[j].service)+' '+mmetric+'</font>)';
									else
										var _service = " ("+commaSeparateNumber(Car[j].service)+" "+mmetric+")";
								} else
								{
									var _service = "";
								}
								var currkm = commaSeparateNumber(Car[j].odometar) + mmetric;
								$('#vh-odometar-' + Car[j].id).html(currkm + _service);
								
								if(_service != "")
								{
									$('#vh-odometar-' + Car[j].id).mousemove(function (event) {
										if(parseInt($('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")).replace(".", ""), 10) < 300)
											var nexserv = '<font style="color: Red;">' + $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")) + '</font>';
										else
											var nexserv = $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")"));
					                    ShowPopup(event, dic('Reports.Past', lang) + ' ' + mmetric + ': <b>' + $('#'+this.id).html().substring(0, $('#'+this.id).html().indexOf("(")-1) + '</b><br/>Преостануваат <b>' + nexserv + '</b> до следен сервис!');
					                });
								} else
								{
									$('#vh-odometar-' + Car[j].id).mousemove(function (event) {
					                    ShowPopup(event, dic('Reports.Past', lang) + ' ' + mmetric + ': <b>' + $('#'+this.id).html() + '</b>');
					                });
								}
				                $('#vh-odometar-' + Car[j].id).mouseout(function () { HidePopup() });
							}
						} else
						{
							$('#vh-up-odometar-' + Car[j].id).css({ display: "none" });
						}
					}
					
					
	                $('#vh-speed-' + Car[j].id).html(Car[j].speed);
	                //if (Car[j].location == '') { $('#vh-pp-' + Car[j].id).css("borderTop", '0px') } else { $('#vh-pp-' + Car[j].id).css("borderTop", '1px dotted #333') }
	                tmr = tmr + 100
	                if(Car[j].sedista == "/")
	                {
	                	_imgsedista = '<img src="../images/nosignal.png" onmousemove="ShowPopup(event, \'Потребна проверка на сензори на седишта\')" onmouseout="HidePopup()" style="width: 11px; position: relative; margin-top: 0px; margin-left: 2px; height: 11px; margin-bottom: -2px;" id="img-senzor-'+Car[j].id+'">';
	                	$('#vh-sedista-' + Car[j].id).html(_imgsedista);
	                } else
                	{
	                	$('#vh-sedista-' + Car[j].id).html(Car[j].sedista);
	                }
	                
	                if (Car[j].taxi == '1') { $('#div-taxi-' + Car[j].id).css('color', '#009933') } else { $('#div-taxi-' + Car[j].id).css('color', '#FF0000') }
	            }
	            //AnimateMarker(Car[j].id, parseFloat(Car[j].lon), parseFloat(Car[j].lat), Car[j].color)
	        }
	        FirstLoad = false;
	        //checkVehicesOnMap()
	        for (var i = 0; i < 4; i++) {
	            if (Boards[i] != null) {
	                resetScreen[i] = false;
	                
	                if (FollowAllVehicles[i]) {
	                    zoomWorldScreen(Maps[i], Maps[i].zoom);
	                }
	                else {
	                    var _ch = new Array();
	                    var _chNum = 0;
	                    var bounds = new OpenLayers.Bounds();
	                    for (var br = 0; br < VehicleListID.length; br++) {
	                    	if(document.getElementById('f-vehicle-' + i + '-' + VehicleListID[br]) != null)
		                        if (document.getElementById('f-vehicle-' + i + '-' + VehicleListID[br]).checked) {
		                            for (var z = 0; z < Maps[i].layers[2].markers.length; z++)
		                                if (Maps[i].layers[2].markers[z].icon.imageDiv.textContent == VehicleListID[br]) {
		                                	bounds.extend(Maps[i].layers[2].markers[z].lonlat);
		                                    _ch[_chNum] = z;
		                                    _chNum++;
		                                    break;
		                                }
		                        }
	                        //Vehicles[br].el.setAttribute("onmousemove", "ShowPopup(event, '#vehicleList-" + Vehicles[br].ID + "')");
	                        //Vehicles[br].el.setAttribute("onmouseout", "HidePopup()");
	                    }
	                    if (_chNum > 0)
	                    	Maps[i].zoomToExtent(bounds);
	                    //map.zoomToExtent(new OpenLayers.Bounds(Vehicles[0].Marker.lonlat.lon,Vehicles[0].Marker.lonlat.lat,Vehicles[1].Marker.lonlat.lon,Vehicles[1].Marker.lonlat.lat,Vehicles[2].Marker.lonlat.lon,Vehicles[2].Marker.lonlat.lat));
	                    /*if (_chNum > 0 && _chNum < 2) {
	                        if (!Maps[i].layers[2].markers[_ch[_chNum - 1]].onScreen()) {
	                            Maps[i].setCenter(Maps[i].layers[2].markers[_ch[_chNum - 1]].lonlat, Maps[i].zoom);
	                        }
	                    } else
							if (_chNum > 1) {
	                            zoomMapVeh(Maps[i], _ch);
	                        }*/
	                }
	                var dist = new Array();
	                var distNum = new Array();
	                var distVeh = new Array();
	                //var dist = "";
	                var distTmp;
	                var distBool = true;
	                var br = 0;
	                dist[0] = "";
	                distNum[0] = "";
	                distVeh[0] = "";
	                for (var x = 0; x < Vehicles.length - 1; x++) {
	                    if (Vehicles[x].Map == i) {
	                    	if (Browser()!='iPad') {
	                        	Vehicles[x].el.setAttribute("onmousemove", "ShowPopup(event, '#vehicleList-" + Vehicles[x].ID + "')");
	                        	Vehicles[x].el.setAttribute("onmouseout", "HidePopup()");
                        	}
	                        for (var y = 1; y < Vehicles.length; y++) {
	                            if (Vehicles[y].Map == i) {

	                                vehX = Maps[i].getPixelFromLonLat(Vehicles[x].Marker.lonlat);
	                                vehY = Maps[i].getPixelFromLonLat(Vehicles[y].Marker.lonlat);
	                                distTmp = Math.round(vehX.distanceTo(vehY));
	                                if (distTmp <= 20 && (Vehicles[x].Marker.events.element.id != Vehicles[y].Marker.events.element.id)) {
	                                    //dist += "[" + x + "," + y + "],";
	                                    for (var z = 0; z < dist.length; z++) {
	                                        if (x == dist[z].split(",")[0]) {
	                                            if (dist[z] == "") {
	                                                dist[z] += x + "," + y + ",";
	                                                distNum[z] += Vehicles[x].Marker.events.element.children[0].textContent + "," + Vehicles[y].Marker.events.element.children[0].textContent + ",";
	                                                distVeh[z] += "#vehicleList-" + Vehicles[x].Marker.events.element.children[0].textContent + ";" + "#vehicleList-" + Vehicles[y].Marker.events.element.children[0].textContent + ";";
	                                            } else {
	                                                dist[z] += y + ",";
	                                                distNum[z] += Vehicles[y].Marker.events.element.children[0].textContent + ",";
	                                                distVeh[z] += "#vehicleList-" + Vehicles[y].Marker.events.element.children[0].textContent + ";";
	                                            }
	                                            distBool = false;
	                                            break;
	                                        } else {
	                                            for (var h = 0; h < dist[z].split(",").length; h++) {
	                                                if (x == dist[z].split(",")[h] || y == dist[z].split(",")[h]) {
	                                                    distBool = false;
	                                                    break;
	                                                }
	                                            }
	                                        }
	                                    }
	                                    if (distBool) {
	                                        dist[dist.length] = x + "," + y + ",";
	                                        distNum[distNum.length] = Vehicles[x].Marker.events.element.children[0].textContent + "," + Vehicles[y].Marker.events.element.children[0].textContent + ",";
	                                        distVeh[distVeh.length] = "#vehicleList-" + Vehicles[x].Marker.events.element.children[0].textContent + ";" + "#vehicleList-" + Vehicles[y].Marker.events.element.children[0].textContent + ";";
	                                    }
	                                    distBool = true;
	                                }
	                            }
	                        }
	                    }
	                }
	                //document.getElementById("testText").value += dist + "  - ";
	                
	                if (dist != "") {
	                    for (var x = 0; x < dist.length; x++) {
	                        for (var y = 0; y < dist[x].split(",").length - 1; y++) {
	                            //debugger; //#vehicleList-" + Vehicles[br].ID + "
	                            //document.getElementById("testText").value += dist + "  - ";
	                            //Maps[i].layers[2].markers[dist[x].split(",")[y]]
	                            if((dist[x].split(",").length - 1) > 4)
	                            {
	                            	Vehicles[dist[x].split(",")[y]].Marker.events.element.setAttribute("onmousemove", "ShowPopupB1(event, '" + distVeh[x].substring(0, distVeh[x].length - 1) + "')");
                            	} else
                            	{
                            		Vehicles[dist[x].split(",")[y]].Marker.events.element.setAttribute("onmousemove", "ShowPopupB(event, '" + distVeh[x].substring(0, distVeh[x].length - 1) + "')");
                        		}
	                            //Maps[i].layers[2].markers[dist[x].split(",")[y]]
	                            Vehicles[dist[x].split(",")[y]].Marker.events.element.setAttribute("onmouseout", "HidePopup()");
	                        }
	                    }
	                }
	            }
	        }
	        /*resetScreen[0] = false;
	        resetScreen[1] = false;
	        resetScreen[2] = false;
	        resetScreen[3] = false;*/
			if(InitLoad1)
			{
				for(var i=0; i<Maps.length; i++){
			        if(Maps[i] != null)
			        {
			        	if(Boards[i] != null)
			        	{
			        		if(Maps[i].layers[2].getDataExtent() != null)
			        		{
			            		zoomWorldScreen(Maps[i], DefMapZoom);
			            		InitLoad1 = false;
			            		HideWait();
			            	}
			            }
		            }
			    }
			}
			
	        setTimeout("Ajax();", 5000);
	    }
	}
	xmlHttp.open("GET", _page, true);
	xmlHttp.send(null);
}
function commaSeparateNumber(val){
	while (/(\d+)(\d{3})/.test(val.toString())){
		val = val.toString().replace(/(\d+)(\d{3})/, '$1'+'.'+'$2');
	}
    return val;
}
function RecStertNew(i) {
    if (!PlayForwardRec) return false;
    IndexRec = i;
    if (_pts != "") {
        if(String(new Date(datet.split(",")[_PointCount].replace(" ","T"))) == String(chart.endDate))
        {
        	PauseClickNew1();
        	return false;
        }
        _PointCount = parseInt(i, 10);

        IndexRec = _PointCount;
        
		moveCharPlay(IndexRec);
		
        var CarMove = _pts[_PointCount].split("|");
        MoveMarker(CarMove[0], parseFloat(CarMove[1]), parseFloat(CarMove[2]), CarMove[3], Car[0].map0, Car[0].map1, Car[0].map2, Car[0].map3);

        if (PlayForwardRec && i < _pts.length)
            TIMEOUTREC = setTimeout("RecStertNew(" + (_PointCount + 1) + ");", SpeedRec);
        if (Maps[0].layers[2].markers[0] != undefined)
            if (!Maps[0].layers[2].markers[0].onScreen())
                Maps[0].setCenter(Maps[0].layers[2].markers[0].lonlat, Maps[0].zoom);
    } else {
        setTimeout("RecStertNew(" + i + ");", SpeedRec);
    }
}

function RecStartBackNew(i) {
    if (!PlayBackRec) return false;
    IndexRec = i;
    if (_pts != "") {
    	if(new Date(datet.split(",")[_PointCount].replace(" ","T")) < chart.startDate)
        {
        	PauseClickNew1();
        	return false;
        }
        _PointCount = parseInt(i, 10);
        if (_PointCount < 0) _PointCount = 0
        
        IndexRec = _PointCount;
        
		moveCharBack(IndexRec);
		
        var CarMove = _pts[_PointCount].split("|");
        MoveMarkerBack(CarMove[0], parseFloat(CarMove[1]), parseFloat(CarMove[2]), CarMove[3], Car[0].map0, Car[0].map1, Car[0].map2, Car[0].map3);

        if (PlayBackRec && i > 0)
            TIMEOUTREC = setTimeout("RecStartBackNew(" + (_PointCount - 1) + ");", SpeedRec);
        if (Maps[0].layers[2].markers[0] != undefined)
            if (!Maps[0].layers[2].markers[0].onScreen())
                Maps[0].setCenter(Maps[0].layers[2].markers[0].lonlat, Maps[0].zoom);
        
    } else {
        setTimeout("RecStartBackNew(" + i + ");", SpeedRec);
    }
}
function RecStert(i) {
	
    if (!PlayForwardRec) return false;
    IndexRec = i;
    if (_pts != "") {
        var stp = 1
        var stp1 = 200 / _PointMax
        if (stp == 0) { stp = 1 }
        var l = parseInt(document.getElementById('gnScroll').style.left);
        if (l < 210) {
            _PointCount = parseInt(i, 10);
            while (pointType[_PointCount] == 0) {
                _PointCount++
            }
            if (_PointCount > _PointMax) _PointCount = _PointMax
            if (_pts[_PointCount] == undefined) return false;
            var _p = _pts[_PointCount].split(';')
            MoveCharC(_PointCount)
            SLeft = SLeft + stp1
            document.getElementById('gnScroll').style.left = (SLeft) + 'px'
            //setTimeout('PlayF()', SpeedRec)
        }
        IndexRec = _PointCount;
        //var CarMove = CarStr.split("#")[i].split("|");
        var CarMove = _pts[_PointCount].split("|");
        MoveMarker(CarMove[0], parseFloat(CarMove[1]), parseFloat(CarMove[2]), CarMove[3], Car[0].map0, Car[0].map1, Car[0].map2, Car[0].map3);

        //$('#vh-date-' + CarMove[0]).html(CarMove[4] + '&nbsp;')
        //document.getElementById('vh-small-' + CarMove[0]).className = 'gnMarkerList' + CarMove[3] + ' text3'
        //$('#vh-speed-' + CarMove[0]).html(CarMove[5]);
        //$('#vh-sedista-' + CarMove[0]).html(CarMove[7])
        //if (CarMove[6] == '1') { $('#div-taxi-' + CarMove[0]).css('color', '#009933') } else { $('#div-taxi-' + CarMove[0]).css('color', '#FF0000') }

        if (PlayForwardRec && i < _pts.length)
            TIMEOUTREC = setTimeout("RecStert(" + (_PointCount + 1) + ");", SpeedRec);
        if (Maps[0].layers[2].markers[0] != undefined)
            if (!Maps[0].layers[2].markers[0].onScreen())
                Maps[0].setCenter(Maps[0].layers[2].markers[0].lonlat, Maps[0].zoom);
    } else {
        setTimeout("RecStert(" + i + ");", SpeedRec);
    }
}

function RecStartBack(i) {
    if (!PlayBackRec) return false;
    IndexRec = i;

    if (_pts != "") {
        
        var stp = 1
        var stp1 = 200 / _PointMax
        if (stp == 0) { stp = 1 }
        var l = parseInt(document.getElementById('gnScroll').style.left);
        if (l > 10) {
            _PointCount = parseInt(i, 10);
            while (pointType[_PointCount] == 0) {
                _PointCount--
            }
            if (_PointCount < 0) _PointCount = 0
            if (_pts[_PointCount] == undefined) return false;
            var _p = _pts[_PointCount].split(';')
            MoveCharC(_PointCount)
            SLeft = SLeft - stp1
            document.getElementById('gnScroll').style.left = (SLeft) + 'px'
            //setTimeout('PlayF()', SpeedRec)
        }
        IndexRec = _PointCount;

        //var CarMove = CarStr.split("#")[i].split("|");
        var CarMove = _pts[_PointCount].split("|");
        MoveMarkerBack(CarMove[0], parseFloat(CarMove[1]), parseFloat(CarMove[2]), CarMove[3], Car[0].map0, Car[0].map1, Car[0].map2, Car[0].map3);

        //$('#vh-date-' + CarMove[0]).html(CarMove[4] + '&nbsp;')
        //document.getElementById('vh-small-' + CarMove[0]).className = 'gnMarkerList' + CarMove[3] + ' text3'
        //$('#vh-speed-' + CarMove[0]).html(CarMove[5]);
        //$('#vh-sedista-' + CarMove[0]).html(CarMove[7])
        //if (CarMove[6] == '1') { $('#div-taxi-' + CarMove[0]).css('color', '#009933') } else { $('#div-taxi-' + CarMove[0]).css('color', '#FF0000') }
        if (PlayBackRec && i > 0)
            TIMEOUTREC = setTimeout("RecStartBack(" + (_PointCount - 1) + ");", SpeedRec);
        if (Maps[0].layers[2].markers[0] != undefined)
            if (!Maps[0].layers[2].markers[0].onScreen())
                Maps[0].setCenter(Maps[0].layers[2].markers[0].lonlat, Maps[0].zoom);
        
    } else {
        setTimeout("RecStartBack(" + i + ");", SpeedRec);
    }
}

function getBorder(num){
	var ext = Maps[num].getExtent().transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"))
	var _bottom = ext.bottom
	var _top = ext.top
	var _left = ext.left
	var _right = ext.right
	
//select * from pinpoints 
//where clientID=133
//and Longitude>20.923741333009 and Longitude<21.019528381348
//and Latitude>41.988438006966 and Latitude<42.025747855451
	alert(_bottom +' ' + _top +' ' + _left +' ' + _right)
}

function runEffect(_id) {
    idOfClickVeh = _id;
    // get effect type from 
    var selectedEffect = 'pulsate';

    // most effect types need no options passed by default
    var options = {};
    // some effects have required parameters
    if (selectedEffect === "scale") {
        options = { percent: 0 };
    } else if (selectedEffect === "transfer") {
        options = { to: "#button", className: "ui-effects-transfer" };
    } else if (selectedEffect === "size") {
        options = { to: { width: 200, height: 60} };
    }

    // run the effect
    $("#" + _id).effect(selectedEffect, options, 500, callback);
    $("#" + idOfClickVeh)[0].style.zIndex = '8888';
};

// callback function to bring a hidden box back
function callback() {
    setTimeout(function () {
        $("#" + idOfClickVeh)[0].style.zIndex = '7777';
    }, 1000);
};


function FindVehicleOnMap0(vID) {
    for (var j = 0; j < $('#quickbuttons').children().length; j++) {
        if ($('#quickbuttons').children()[j].title == "checked") {
            for (var i = 0; i < Vehicles.length; i++) {
                if ((Vehicles[i].ID == vID) && (Vehicles[i].Map == j) && document.getElementById('cb-vehicle-' + Vehicles[i].Map + '-' + Vehicles[i].ID).checked) {
                    // Ako e markerot vidliv
                    var ll = Maps[j].getCenter().transform(new OpenLayers.Projection("EPSG:4326"), Maps[j].getProjectionObject());
                    setCenterMapNew(Vehicles[i].Lon, Vehicles[i].Lat, 16, j, i);
                    runEffect(Vehicles[i].el.id);
                }
            }
        }
    }
}
function setCenterMapNew(lon, lat, zl, numMap, _i) {
    if (MapType[numMap] == 'YAHOOM') {
        //Maps[numMap].setCenter(new OpenLayers.LonLat(lon, lat), zl);
		Maps[numMap].setCenter(new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), Maps[numMap].getProjectionObject()), zl);
    } else {
        Maps[numMap].setCenter(new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), Maps[numMap].getProjectionObject()), zl);
    }
    Vehicles[_i].trajec = podatok[Maps[numMap].getZoom()];
}
function setCenterMap(lon, lat, zl, numMap) {
    if (MapType[numMap] == 'YAHOOM') {
        //Maps[numMap].setCenter(new OpenLayers.LonLat(lon, lat), zl);
		Maps[numMap].setCenter(new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), Maps[numMap].getProjectionObject()), zl);
    
    } else {
        Maps[numMap].setCenter(new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), Maps[numMap].getProjectionObject()), zl);
    }
}

function setCenterMap0(lon, lat, zl) {
    for (var j = 0; j < $('#quickbuttons').children().length; j++) {
        if ($('#quickbuttons').children()[j].title == "checked") {
            if (MapType[0] == 'YAHOOM') {
				Maps[j].setCenter(new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), Maps[j].getProjectionObject()), zl);
                //Maps[j].setCenter(new OpenLayers.LonLat(lon, lat), zl);
            } else {
                Maps[j].setCenter(new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), Maps[j].getProjectionObject()), zl);
            }
        }
    }
}


function ChangePassiveStatus(_code, vID){
	var op = $('#div-pass-'+_code).css("opacity") + ''
	if (op == '0.3') {
		$('#div-pass-'+_code).css({opacity:'1'});
		$.ajax({url: "setPassive.php?q=1&nov=" + vID, context: document.body});
		return
	}else{
		$('#div-pass-'+_code).css({opacity:'0.3'});
		$.ajax({url: "setPassive.php?q=0&nov=" + vID, context: document.body});
		return
	}
}

function LoadAllPOI(_id, num) {
    if (ShowPOI == false) {
    	for(var i=0; i<4; i++)
    		if(Markers[i] != null)
    		{
    			if (tmpSearchMarker != undefined)
        			Markers[i].removeMarker(tmpSearchMarker);
        	}
        var s = 1;
        while (document.getElementById("3_checkRow" + s) != null) {
            tmpCheckGroup[3][s] = 1;
            s++;
        }
        LoadPOI(_id);
        ShowPOI = true;
        if (document.getElementById('icon-poi') != null)
            document.getElementById('icon-poi').style.backgroundPosition = '0px -96px';
        else
            if (document.getElementById('div-poiimg') != null)
                document.getElementById('div-poiimg').style.backgroundColor = '#00ff00';
        return
    } else {
        var s = 1;
        while (document.getElementById("3_checkRow" + s) != null) {
            tmpCheckGroup[3][s] = 0;
            s++;
        }
        if (tmpMarkers[0] != undefined) {
            for (var j = 0; j < tmpMarkers[0].length; j++) {
                //removeMarker
                try {
                    for (var i = 0; i < 5; i++) {
                        if (Maps[i] != null) {
                            Markers[i].removeMarker(tmpMarkers[i][j]);
                        }
                    }
                } catch (err) { }
                try {

                    for (var i = 0; i < 5; i++) {
                        if (Maps[i] != null) {
                            tmpMarkers[i][j].destroy();
                        }
                    }
                } catch (err) { }
            }
        }
        RemoveAllFeaturePoly();
        for (var i = 0; i < 5; i++)
            if (Maps[i] != null)
                tmpMarkers[i] = [];
        ShowPOI = false;
        if (document.getElementById('icon-poi') != null)
            document.getElementById('icon-poi').style.backgroundPosition = '0px -120px';
        else
            if (document.getElementById('div-poiimg') != null)
                document.getElementById('div-poiimg').style.backgroundColor = 'Red';
    }
}

function LoadPOI(_id) {
    ShowWait();
    $.ajax({
        url: twopoint + "/main/getPOI.php?id=" + _id + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
        	data = data.replace(/\r/g,'').replace(/\n/g,'');
            var _pp = data.split('#');
            if (_pp != "@")
            {
                for (var i = 0; i < 4; i++) {
                    if (Boards[i] != null) {
                        if (tmpMarkers[i] != undefined) {
                            for (var j = 0; j < tmpMarkers[i].length; j++) {
                                try {
                                    Markers[i].removeMarker(tmpMarkers[i][j]);
                                } catch (err) { }
                                try {
                                    tmpMarkers[i][j].destroy();
                                } catch (err) { }
                            }
                        }
                        tmpMarkers[i] = [];
                        for (var j = 1; j < _pp.length; j++) {
                            var _ppp = _pp[j].split('|');
                            var size = new OpenLayers.Size(24, 24);
                            var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
                            if(_ppp[3] == '1')
                            	var icon = new OpenLayers.Icon(twopoint + '/images/pin-1.png', size, null, calculateOffset);
                            else
                            var icon = new OpenLayers.Icon('./blank.png', size, null, calculateOffset);

                            var ll = new OpenLayers.LonLat(parseFloat(_ppp[0]), parseFloat(_ppp[1])).transform(new OpenLayers.Projection("EPSG:4326"), Maps[i].getProjectionObject())
                            //if (MapType[i] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_ppp[0]), parseFloat(_ppp[1])) }
                            var MyMar = new OpenLayers.Marker(ll, icon)
                            var markers = Markers[i];
                            markers.addMarker(MyMar);
                            MyMar.events.element.style.zIndex = 666
                            tmpMarkers[i][tmpMarkers[i].length] = MyMar;
                            /*if (_ppp[7] == "1")
                                var _color = 'ff0000';
                            else
                                var _color = _ppp[7];*/
                            var _bgimg = 'http://80.77.159.246:88/new/pin/?color=' + _ppp[5] + '&type=' + _ppp[9];
                            //debugger;
                            if(_ppp[3] != '1')
                            	tmpMarkers[i][tmpMarkers[i].length - 1].events.element.innerHTML = '<div style="background: transparent url(' + _bgimg + ') no-repeat; width: 24px; height: 24px; font-size:4px"></div>';
                            tmpMarkers[i][tmpMarkers[i].length - 1].events.element.style.cursor = 'pointer';
                            //tmpMarkers[tmpMarkers.length - 1].events.element.style.backgroundColor = '#' + _ppp[7];
                            //alert(_ppp[6]);
							var groupName = _ppp[6];
							if(_ppp[3] == "1")
                            	groupName = dic("Settings.NotGroupedItems", lang);
                            tmpMarkers[i][tmpMarkers[i].length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + _ppp[2] + "<br /></strong>" + dic("Group", lang) + ": <strong style=\"font-size: 12px;\">" + groupName + "</strong>')");
                            tmpMarkers[i][tmpMarkers[i].length - 1].events.element.setAttribute("onclick", "EditPOI('" + _ppp[0] + "', '" + _ppp[1] + "', '" + _ppp[2] + "', " + _ppp[8] + ", '" + _ppp[3] + "', '" + _ppp[4] + "', '', '" + (tmpMarkers[i].length - 1) + "', '/', '" + _ppp[7] + "')");
                            //$(tmpMarkers[tmpMarkers.length-1].events.element).mousemove(function(event) {alert(j)});
                            $(tmpMarkers[i][tmpMarkers[i].length - 1].events.element).mouseout(function () { HidePopup() });
                        }
                    }
                }
            }
            $.ajax({
		        url: twopoint + "/main/getVehPathsPoly.php?id=" + _id + "&tpoint=" + twopoint,
		        context: document.body,
		        success: function (data) {
		        	data = data.replace(/\r/g,'').replace(/\n/g,'');
		            if(data.indexOf("#^*") == -1) {
		            	var d = data.split("@");
		                for (var i = 1; i < d.length; i++) {
		                    DrawZoneOnLivePoly(d[i].split("|")[0], d[i].split("|")[1]);
		                }
		            } else {
		                HideWait();
		            }
		        }
		    });
            //map.zoomToExtent(map.layers[2].getDataExtent());
            $('#div-poiGroupUp').css({ display: 'none' });
        }
    });
    if (_id == undefined)
        HideWait();
}

function LoadPOIPetar(_id) {
    ShowWait();
    $.ajax({
        url: twopoint + "/main/getPOI.php?id=" + _id + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
        	data = data.replace(/\r/g,'').replace(/\n/g,'');
        	
            var _pp = data.split('#');
            if (_pp != "@")
                for (var i = 0; i < 4; i++) {
                    if (Boards[i] != null) {
                        if (tmpMarkers[i] != undefined) {
                            for (var j = 0; j < tmpMarkers[i].length; j++) {
                                try {
                                    Markers[i].removeMarker(tmpMarkers[i][j]);
                                } catch (err) { }
                                try {
                                    tmpMarkers[i][j].destroy();
                                } catch (err) { }
                            }
                        }
                        tmpMarkers[i] = [];
                        for (var j = 1; j < _pp.length; j++) {
                            var _ppp = _pp[j].split('|');
                            var size = new OpenLayers.Size(24, 24);
                            var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
                            //var icon = new OpenLayers.Icon('./blank.png', size, null, calculateOffset);
                            var icon = new OpenLayers.Icon(twopoint + '/images/pin-1.png', size, null, calculateOffset);

                            var ll = new OpenLayers.LonLat(parseFloat(_ppp[0]), parseFloat(_ppp[1])).transform(new OpenLayers.Projection("EPSG:4326"), Maps[i].getProjectionObject())
                            //if (MapType[i] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_ppp[0]), parseFloat(_ppp[1])) }
                            var MyMar = new OpenLayers.Marker(ll, icon)
                            var markers = Markers[i];
                            markers.addMarker(MyMar);
                            MyMar.events.element.style.zIndex = 666
                            tmpMarkers[i][tmpMarkers[i].length] = MyMar;
                            /*if (_ppp[7] == "1")
                                var _color = 'ff0000';
                            else
                                var _color = _ppp[7];*/
                            var _bgimg = 'http://80.77.159.246:88/new/pin/?color=' + _ppp[5] + '&type=0';
                            //debugger;
                            //tmpMarkers[i][tmpMarkers[i].length - 1].events.element.innerHTML = '<div style="background: transparent url(' + _bgimg + ') no-repeat; width: 24px; height: 24px; font-size:4px"></div>';
                            tmpMarkers[i][tmpMarkers[i].length - 1].events.element.style.cursor = 'pointer';
                            //tmpMarkers[tmpMarkers.length - 1].events.element.style.backgroundColor = '#' + _ppp[7];
                            //alert(_ppp[6]);
							var groupName = _ppp[6];
							if(_ppp[3] == "1")
                            	groupName = dic("Settings.NotGroupedItems", lang);
                            tmpMarkers[i][tmpMarkers[i].length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + _ppp[2] + "<br /></strong>" + dic("Group", lang) + ": <strong style=\"font-size: 12px;\">" + groupName + "</strong>')");
                            tmpMarkers[i][tmpMarkers[i].length - 1].events.element.setAttribute("onclick", "EditPOI('" + _ppp[0] + "', '" + _ppp[1] + "', '" + _ppp[2] + "', " + _ppp[8] + ", '" + _ppp[3] + "', '" + _ppp[4] + "', '', '" + (tmpMarkers[i].length - 1) + "', '/', '" + _ppp[7] + "')");
                            //$(tmpMarkers[tmpMarkers.length-1].events.element).mousemove(function(event) {alert(j)});
                            $(tmpMarkers[i][tmpMarkers[i].length - 1].events.element).mouseout(function () { HidePopup() });
                        }
                    }
                }
            HideWait();
            map.zoomToExtent(map.layers[2].getDataExtent());
            $('#div-poiGroupUp').css({ display: 'none' });
        }
    });
    if (_id == undefined)
        HideWait();
}

function LoadPOIbyID(_id) {
    ShowWait();
    $.ajax({
        url: twopoint + "/main/getPOIbyID.php?id=" + _id + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
            var _pp = data.split('#');
            if (_pp != "@")
                for (var i = 0; i < 4; i++) {
                    if (Boards[i] != null) {
                        if (tmpMarkers[i] != undefined) {
                            for (var j = 0; j < tmpMarkers[i].length; j++) {
                                try {
                                    Markers[i].removeMarker(tmpMarkers[i][j]);
                                } catch (err) { }
                                try {
                                    tmpMarkers[i][j].destroy();
                                } catch (err) { }
                            }
                        }
                        tmpMarkers[i] = [];
                        for (var j = 1; j < _pp.length; j++) {
                            var _ppp = _pp[j].split('|');
                            var size = new OpenLayers.Size(24, 24);
                            var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
                            var icon = new OpenLayers.Icon(twopoint + '/images/pin-1.png', size, null, calculateOffset);

                            var ll = new OpenLayers.LonLat(parseFloat(_ppp[0]), parseFloat(_ppp[1])).transform(new OpenLayers.Projection("EPSG:4326"), Maps[i].getProjectionObject())
                            //if (MapType[i] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_ppp[0]), parseFloat(_ppp[1])) }
                            var MyMar = new OpenLayers.Marker(ll, icon)
                            var markers = Markers[i];
                            markers.addMarker(MyMar);
                            MyMar.events.element.style.zIndex = 666
                            tmpMarkers[i][tmpMarkers[i].length] = MyMar;
                            /*if (_ppp[7] == "1")
                                var _color = 'ff0000';
                            else
                                var _color = _ppp[7];*/
                            //var _bgimg = 'http://80.77.159.246:88/new/pin/?color=' + _ppp[5] + '&type=0';
                            //debugger;
                            //tmpMarkers[i][tmpMarkers[i].length - 1].events.element.innerHTML = '<div style="background: transparent url(' + _bgimg + ') no-repeat; width: 24px; height: 24px; font-size:4px"></div>';
                            tmpMarkers[i][tmpMarkers[i].length - 1].events.element.style.cursor = 'pointer';
                            //tmpMarkers[tmpMarkers.length - 1].events.element.style.backgroundColor = '#' + _ppp[7];
                            tmpMarkers[i][tmpMarkers[i].length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + _ppp[2] + "<br /></strong>" + dic("Group", lang) + ": <strong style=\"font-size: 12px;\">" + _ppp[6] + "</strong>')");
                            tmpMarkers[i][tmpMarkers[i].length - 1].events.element.setAttribute("onclick", "EditPOI('" + _ppp[0] + "', '" + _ppp[1] + "', '" + _ppp[2] + "', " + _ppp[8] + ", '" + _ppp[3] + "', '" + _ppp[4] + "', '', '" + (tmpMarkers[i].length - 1) + "', '/', '" + _ppp[7] + "')");
                            //$(tmpMarkers[tmpMarkers.length-1].events.element).mousemove(function(event) {alert(j)});
                            $(tmpMarkers[i][tmpMarkers[i].length - 1].events.element).mouseout(function () { HidePopup() });
                        }
                    }
                }
            HideWait();
            $('#div-poiGroupUp').css({ display: 'none' });
        }
    });
    if (_id == undefined)
        HideWait();
}



function CreateMarkerSE_Rec(_lonn, _latt, _ign, _dat, se) {
    var size = new OpenLayers.Size(64, 48);
    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
    if (se == 1 && se == '1') {
        var icon = new OpenLayers.Icon(twopoint + '/images/Start.png', size, null, calculateOffset);
    }
    else {
        var icon = new OpenLayers.Icon(twopoint + '/images/Stop.png', size, null, calculateOffset);
    }
    if (Maps[0] != null) {
        var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject())
        //if (MapType[0] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
        var MyMar = new OpenLayers.Marker(ll, icon)
        var markers = Markers[0];

        markers.addMarker(MyMar);
        MyMar.events.element.style.zIndex = 666
        tmpMarkersRec[tmpMarkersRec.length] = MyMar;
        if (_ign == "0" || _ign == 0)
            var _color = '#ff0000';
        else
            var _color = '#008800';
        //tmpMarkers[tmpMarkers.length - 1].events.element.innerHTML = '<div class="gnPOI2" style="display:box; font-size:4px"></div>';
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.style.cursor = 'pointer';
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 12px;\">" + _dat + "</strong>')");
        $(tmpMarkersRec[tmpMarkersRec.length - 1].events.element).mouseout(function () { HidePopup() });
    }
}

function CreateMarker_Rec(_lonn, _latt, _ign, _dat, _speedd) {
    var size = new OpenLayers.Size(16, 16);
    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
    var icon = new OpenLayers.Icon('./blank.png', size, null, calculateOffset);

    if (Maps[0] != null) {
        var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject())
        //if (MapType[0] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
        var MyMar = new OpenLayers.Marker(ll, icon)
        var markers = Markers[0];
        markers.addMarker(MyMar);
        MyMar.events.element.style.zIndex = 666
        tmpMarkersRec[tmpMarkersRec.length] = MyMar;
        if (_ign == "0" || _ign == 0)
            var _color = '#ff0000';
        else
            var _color = '#008800';
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.innerHTML = '<div class="gnPOI2" style="background-color: ' + _color + '"; display:box; font-size:4px"></div>';
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.style.cursor = 'pointer';
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 12px;\">" + _dat + "<br /> " + _speedd + " km/h </strong>')");
        $(tmpMarkersRec[tmpMarkersRec.length - 1].events.element).mouseout(function () { HidePopup() });
    }
}

function MouseOverPopup(_th) {
    _th.style.opacity = "1";
    _th.style.zIndex = "3000";
};
function MouseEndPopup(_th) {
    _th.style.opacity = "0.7";
    _th.style.zIndex = "753";
};

function CreateMarkerIgnition_Rec(_lonn, _latt, _date, _date1) {
    var size = new OpenLayers.Size(48, 48);
    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2) - 1, -size.h + 3 ); };
    var icon = new OpenLayers.Icon(twopoint + '/images/Parking1.png', size, null, calculateOffset);
    //var _NewCreateDateTime = _date.split(" ")[0].split("-")[0] + "/" + _date.split(" ")[0].split("-")[1] + "/" + _date.split(" ")[0].split("-")[2].substring(2, 4) + " " + _date.split(" ")[1].split(":")[0] + ":" + _date.split(" ")[1].split(":")[1];
    //var _NewCreateDateTime1 = _date1.split(" ")[0].split("-")[0] + "/" + _date1.split(" ")[0].split("-")[1] + "/" + _date1.split(" ")[0].split("-")[2].substring(2, 4) + " " + _date1.split(" ")[1].split(":")[0] + ":" + _date1.split(" ")[1].split(":")[1];
    if (Maps[0] != null) {
        var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject());
        
        if(Browser() == "Chrome")
        {
        	var _dt = _date.split(/\-|\s/);
        	var _dt1 = new Date(_dt.slice(0, 3).join('-') + ' ' + _dt[3]);
        	var _dtT = _date1.split(/\-|\s/);
        	var _dtT1 = new Date(_dtT.slice(0, 3).join('-') + ' ' + _dtT[3]);
        	var _diffDT = get_time_difference(_dtT1, _dt1);
    	} else
    	{
    		if(Browser() == "Safari")
    		{
    			var _dt = _date.split(/\-|\s/);
        		var _dt1 = new Date(parseInt(_dt[0], 10), parseInt(_dt[1], 10), parseInt(_dt[2], 10), parseInt(_dt[3].split(":")[0], 10), parseInt(_dt[3].split(":")[1], 10), parseInt(_dt[3].split(":")[2], 10));
        		var _dtT = _date1.split(/\-|\s/);
        		var _dtT1 = new Date(parseInt(_dtT[0], 10), parseInt(_dtT[1], 10), parseInt(_dtT[2], 10), parseInt(_dtT[3].split(":")[0], 10), parseInt(_dtT[3].split(":")[1], 10), parseInt(_dtT[3].split(":")[2], 10));
        		var _diffDT = get_time_difference(_dtT1, _dt1);
    		} else
    		{
    			var _dt = _date.split(/\-|\s/);
        		var _dt1 = new Date(_dt.slice(0, 3).reverse().join('/') + ' ' + _dt[3]);
        		var _dtT = _date1.split(/\-|\s/);
        		var _dtT1 = new Date(_dtT.slice(0, 3).reverse().join('/') + ' ' + _dtT[3]);
        		var _diffDT = get_time_difference(_dtT1, _dt1);
        	}
    	}
        if (_diffDT.days == 0 && _diffDT.hours == 0 && _diffDT.minutes == 0)
            var _zero = " < " + _MinMin + "min";
        else
            var _zero = "";
        
        var _NewCreateDateTime = _dt[3].split(":")[0] + ":" + _dt[3].split(":")[1] + " " + _dt[2] + "-" + _dt[1] + "-" + _dt[0];
    	var _NewCreateDateTime1 = _dtT[3].split(":")[0] + ":" + _dtT[3].split(":")[1] + " " + _dtT[2] + "-" + _dtT[1] + "-" + _dtT[0];
        
        var lonLatMarker = new OpenLayers.LonLat(_lonn, _latt).transform(Maps[0].displayProjection, Maps[0].projection);
        var feature = new OpenLayers.Feature(markers, lonLatMarker);
        //if (MapType[0] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
        var MyMar = new OpenLayers.Marker(ll, icon)
        var markers = Markers[0];
        var markerClick = function (evt) {
            if (this.popup == null) {
                var popup = new OpenLayers.Popup.FramedCloud("Popup",
                    lonLatMarker,
                    new OpenLayers.Size(185, 33),
                //"<div class='text1' style='overflow: hidden; font-size:.8em; position: absolute; top: -1px;'><strong style='font-size: 12px;'>Почеток: " + _date1 + "<br />Крај: " + _date + "<br />Вкупно стоење: " + (_diffDT.days != 0 ? (_diffDT.days + " days") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " m") : "") + " " + (_diffDT.seconds != 0 ? (_diffDT.seconds + " s") : "") + "</strong></div>", null, true);
                    "<div class='text1' style='overflow: hidden; font-size:.8em; position: relative; left: -2px; top: -8px; width: 125px; height: 59px; margin-right: -15px; margin-bottom: -22px;'><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"" + dic("STOS", lang) + "\")' onmouseout='HidePopup()' src='" + twopoint + "/images/startRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime1 + "<br /><img onmousemove='ShowPopup(event, \"" + dic("ETOS", lang) + "\")' onmouseout='HidePopup()' src='" + twopoint + "/images/endRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime + "<br /><img onmousemove='ShowPopup(event, \"" + dic("TTOS", lang) + "\")' onmouseout='HidePopup()' src='" + twopoint + "/images/sum1.png' style='height: 16px; width: 16px; position: relative; top: 4px;' />: " + _zero + (_diffDT.days != 0 ? (_diffDT.days + " day(s)") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " min") : "") + "</strong></div>", null, true);
                this.popup = popup;
                this.popup.contentDiv.style.overflow = 'hidden';
                map.addPopup(this.popup);
                this.popup.div.style.opacity = '0.7';
                this.popup.div.setAttribute("onmousemove", "MouseOverPopup(this)");
                this.popup.div.setAttribute("onmouseout", "MouseEndPopup(this)");
                this.popup.show();
            } else {
                this.popup.toggle();
            }
            OpenLayers.Event.stop(evt);
        };
        if (parseInt(_diffDT.minutes, 10) > parseInt(_MinMin, 10)) {
            MyMar.events.register("mousedown", feature, markerClick);
        }
        markers.addMarker(MyMar);
        MyMar.events.element.style.zIndex = 999;
        tmpMarkersRec[tmpMarkersRec.length] = MyMar;
        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.innerHTML = '<div class="gnPOI" style="background-color: #ff0000"; display:box; font-size:4px"></div>';
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.style.cursor = 'pointer';
        var popup = new OpenLayers.Popup.FramedCloud("Popup",
                lonLatMarker,
                new OpenLayers.Size(500, 500),
                "<div class='text1' style='overflow: hidden; font-size:.8em; position: relative; left: -2px; top: -8px; width: 125px; height: 59px; margin-right: -15px; margin-bottom: -22px;'><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"" + dic("STOS", lang) + "\")' onmouseout='HidePopup()' src='" + twopoint + "/images/startRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime1 + "<br /><img onmousemove='ShowPopup(event, \"" + dic("ETOS", lang) + "\")' onmouseout='HidePopup()' src='" + twopoint + "/images/endRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime + "<br /><img onmousemove='ShowPopup(event, \"" + dic("TTOS", lang) + "\")' onmouseout='HidePopup()' src='" + twopoint + "/images/sum1.png' style='height: 16px; width: 16px; position: relative; top: 4px;' />: " + _zero + (_diffDT.days != 0 ? (_diffDT.days + " day(s)") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " min") : "") + "</strong></div>", null, true);
        this.popup = popup;
        this.popup.contentDiv.style.overflow = 'hidden';
        if (parseInt(_diffDT.minutes, 10) > parseInt(_MinMin, 10)) {
            map.addPopup(this.popup);

            this.popup.div.style.opacity = '0.7';
            this.popup.div.setAttribute("onmousemove", "MouseOverPopup(this)");
            this.popup.div.setAttribute("onmouseout", "MouseEndPopup(this)");
            //this.popup.contentDiv.style.width = '230px';
            //this.popup.div.style.height = '99px';
            //this.popup.div.style.width = '240px';
            //this.popup.positionBlocks.tl.offset.x = this.popup.positionBlocks.tl.offset.x - 10;
            //this.popup.positionBlocks.bl.offset.x = this.popup.positionBlocks.bl.offset.x - 10;
            //this.popup.positionBlocks.tr.offset.x = this.popup.positionBlocks.tr.offset.x + 10;
            //this.popup.positionBlocks.br.offset.x = this.popup.positionBlocks.br.offset.x + 10;
            this.popup.hide();
        }
        //tmpMarkersRec[tmpMarkersRec.length - 1].feature = feature;
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 12px;\">" + dic("STOS", lang) + ": " + _NewCreateDateTime1 + "<br />" + dic("ETOS", lang) + ": " + _NewCreateDateTime + "<br />" + dic("TTOS", lang) + ": " + _zero + (_diffDT.days != 0 ? (_diffDT.days + " day(s)") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " min") : "") + "</strong>')");
        $(tmpMarkersRec[tmpMarkersRec.length - 1].events.element).mouseout(function () { HidePopup() });
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.addEventListener('click', function (e) { AddPOI = true; VehClick = true; });
    }
}
function CreateMarkerIgnition_Rec1(_lonn, _latt, _time, _date, _date1) {
    var size = new OpenLayers.Size(11, 11);
    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h + 5); };
    var icon = new OpenLayers.Icon('./blank.png', size, null, calculateOffset);

    if (Maps[0] != null) {
        var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject());
        if(Browser() == "Chrome")
        {
        	var _dt = _date.split(/\-|\s/);
        	var _dt1 = new Date(_dt.slice(0, 3).join('-') + ' ' + _dt[3]);
        	var _dtT = _date1.split(/\-|\s/);
        	var _dtT1 = new Date(_dtT.slice(0, 3).join('-') + ' ' + _dtT[3]);
        	var _diffDT = get_time_difference(_dtT1, _dt1);
    	} else
    	{
    		var _dt = _date.split(/\-|\s/);
        	var _dt1 = new Date(_dt.slice(0, 3).reverse().join('/') + ' ' + _dt[3]);
        	var _dtT = _date1.split(/\-|\s/);
        	var _dtT1 = new Date(_dtT.slice(0, 3).reverse().join('/') + ' ' + _dtT[3]);
        	var _diffDT = get_time_difference(_dtT1, _dt1);
    	}
        if (_diffDT.days == 0 && _diffDT.hours == 0 && _diffDT.minutes == 0)
            var _zero = " < " + _MinMin + "min";
        else
            var _zero = "";
        
        var _NewCreateDateTime = _dt[3].split(":")[0] + ":" + _dt[3].split(":")[1] + " " + _dt[2] + "-" + _dt[1] + "-" + _dt[0];
    	var _NewCreateDateTime1 = _dtT[3].split(":")[0] + ":" + _dtT[3].split(":")[1] + " " + _dtT[2] + "-" + _dtT[1] + "-" + _dtT[0];
        
        var lonLatMarker = new OpenLayers.LonLat(_lonn, _latt).transform(Maps[0].displayProjection, Maps[0].projection);
        var feature = new OpenLayers.Feature(markers, lonLatMarker);
        //if (MapType[0] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
        var MyMar = new OpenLayers.Marker(ll, icon)
        var markers = Markers[0];
        var markerClick = function (evt) {
            if (this.popup == null) {
                var popup = new OpenLayers.Popup.FramedCloud("Popup",
                    lonLatMarker,
                    new OpenLayers.Size(185, 33),
                //"<div class='text1' style='overflow: hidden; font-size:.8em; position: absolute; top: -1px;'><strong style='font-size: 12px;'>Почеток: " + _date1 + "<br />Крај: " + _date + "<br />Вкупно стоење: " + (_diffDT.days != 0 ? (_diffDT.days + " days") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " m") : "") + " " + (_diffDT.seconds != 0 ? (_diffDT.seconds + " s") : "") + "</strong></div>", null, true);
                    "<div class='text1' style='overflow: hidden; font-size:.8em; position: relative; left: -2px; top: -8px; width: 125px; height: 59px; margin-right: -15px; margin-bottom: -22px;'><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"" + dic("STOS", lang) + "\")' onmouseout='HidePopup()' src='" + twopoint + "/images/startRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime1 + "<br /><img onmousemove='ShowPopup(event, \"" + dic("ETOS", lang) + "\")' onmouseout='HidePopup()' src='" + twopoint + "/images/endRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime + "<br /><img onmousemove='ShowPopup(event, \"" + dic("TTOS", lang) + "\")' onmouseout='HidePopup()' src='" + twopoint + "/images/sum1.png' style='height: 16px; width: 16px; position: relative; top: 4px;' />: " + _zero + (_diffDT.days != 0 ? (_diffDT.days + " day(s)") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " min") : "") + "</strong></div>", null, true);
                this.popup = popup;
                this.popup.contentDiv.style.overflow = 'hidden';
                map.addPopup(this.popup);
                this.popup.div.style.opacity = '0.7';
                this.popup.div.setAttribute("onmousemove", "MouseOverPopup(this)");
                this.popup.div.setAttribute("onmouseout", "MouseEndPopup(this)");
                this.popup.show();
            } else {
                this.popup.toggle();
            }
            OpenLayers.Event.stop(evt);
        };
        if (parseInt(_diffDT.minutes, 10) > parseInt(_MinMin, 10)) {
            MyMar.events.register("mousedown", feature, markerClick);
        }
        markers.addMarker(MyMar);
        MyMar.events.element.style.zIndex = 999
        tmpMarkersRec[tmpMarkersRec.length] = MyMar;
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.innerHTML = '<div class="gnPOI" style="background-color: #BBBBBB"; display:box; font-size:4px"></div>';
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.style.cursor = 'pointer';
        var popup = new OpenLayers.Popup.FramedCloud("Popup",
                lonLatMarker,
                new OpenLayers.Size(500, 500),
                "<div class='text1' style='overflow: hidden; font-size:.8em; position: relative; left: -2px; top: -8px; width: 125px; height: 59px; margin-right: -15px; margin-bottom: -22px;'><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"" + dic("STOS", lang) + "\")' onmouseout='HidePopup()' src='" + twopoint + "/images/startRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime1 + "<br /><img onmousemove='ShowPopup(event, \"" + dic("ETOS", lang) + "\")' onmouseout='HidePopup()' src='" + twopoint + "/images/endRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime + "<br /><img onmousemove='ShowPopup(event, \"" + dic("TTOS", lang) + "\")' onmouseout='HidePopup()' src='" + twopoint + "/images/sum1.png' style='height: 16px; width: 16px; position: relative; top: 4px;' />: " + _zero + (_diffDT.days != 0 ? (_diffDT.days + " day(s)") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " min") : "") + "</strong></div>", null, true);
        this.popup = popup;
        this.popup.contentDiv.style.overflow = 'hidden';
        if (parseInt(_diffDT.minutes, 10) > parseInt(_MinMin, 10)) {
            map.addPopup(this.popup);

            this.popup.div.style.opacity = '0.7';
            this.popup.div.setAttribute("onmousemove", "MouseOverPopup(this)");
            this.popup.div.setAttribute("onmouseout", "MouseEndPopup(this)");
            //this.popup.contentDiv.style.width = '230px';
            //this.popup.div.style.height = '99px';
            //this.popup.div.style.width = '240px';
            //this.popup.positionBlocks.tl.offset.x = this.popup.positionBlocks.tl.offset.x - 10;
            //this.popup.positionBlocks.bl.offset.x = this.popup.positionBlocks.bl.offset.x - 10;
            //this.popup.positionBlocks.tr.offset.x = this.popup.positionBlocks.tr.offset.x + 10;
            //this.popup.positionBlocks.br.offset.x = this.popup.positionBlocks.br.offset.x + 10;
            this.popup.hide();
        }
        //tmpMarkersRec[tmpMarkersRec.length - 1].feature = feature;
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 12px;\">" + dic("STOS", lang) + ": " + _NewCreateDateTime1 + "<br />" + dic("ETOS", lang) + ": " + _NewCreateDateTime + "<br />" + dic("TTOS", lang) + ": " + _zero + (_diffDT.days != 0 ? (_diffDT.days + " day(s)") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " min") : "") + "</strong>')");
        $(tmpMarkersRec[tmpMarkersRec.length - 1].events.element).mouseout(function () { HidePopup() });
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.addEventListener('click', function (e) { AddPOI = true; VehClick = true; });
    }
}
function CreateMarkerStartEnd(_lonn1, _latt1, _date1, _lonn2, _latt2, _date2, strDistStartStop) {
	if(parseFloat(strDistStartStop) < 50)
	{
		var size = new OpenLayers.Size(112, 48);
	    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2) - 2, (-size.h / 2) - 20); };
	    var icon = new OpenLayers.Icon(twopoint + '/images/startstop.png', size, null, calculateOffset);
	    var imgS = 'startRec';
	    var imgE = 'endRec';
	    var _textS = dic("Start", lang) + ":<br />";
	    var _textE = dic("End", lang) + ":<br />";
	    
	    if (Maps[0] != null) {
	        var ll = new OpenLayers.LonLat(parseFloat(_lonn1), parseFloat(_latt1)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject())
	        //if (MapType[0] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
	        var MyMar = new OpenLayers.Marker(ll, icon)
	        var markers = Markers[0];
	
	        markers.addMarker(MyMar);
	        MyMar.events.element.style.zIndex = 999
	        tmpMarkersRec[tmpMarkersRec.length] = MyMar;
	        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.innerHTML = '<div class="gnPOI" style="background-color: ' + _color + '"; display:box; font-size:4px"></div>';
	        
	        var popup = new OpenLayers.Popup.FramedCloud("Popup",
	            ll,
	            new OpenLayers.Size(500, 500),
	            "<div class='text1' style='overflow: hidden; font-size:.8em; position: relative; left: -2px; top: -3px; width: 125px; height: 55px; margin-right: -15px; margin-bottom: -22px;'><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"" + _textS + "\")' onmouseout='HidePopup()' src='" + twopoint + "/images/" + imgS + ".png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _date1.split(/\-|\s/)[3].split(":")[0] + ":" + _date1.split(/\-|\s/)[3].split(":")[1] + " " + _date1.split(/\-|\s/)[2] + "-" + _date1.split(/\-|\s/)[1]+ "-" + _date1.split(/\-|\s/)[0] + "</strong><br/><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"" + _textE + "\")' onmouseout='HidePopup()' src='" + twopoint + "/images/" + imgE + ".png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _date2.split(/\-|\s/)[3].split(":")[0] + ":" + _date2.split(/\-|\s/)[3].split(":")[1] + " " + _date2.split(/\-|\s/)[2] + "-" + _date2.split(/\-|\s/)[1]+ "-" + _date2.split(/\-|\s/)[0] + "</strong></div>", null, true);
	        this.popup = popup;
	        this.popup.contentDiv.style.overflow = 'hidden';
	        map.addPopup(this.popup);
	        this.popup.div.style.opacity = '0.7';
	        this.popup.div.setAttribute("onmousemove", "MouseOverPopup(this)");
	        this.popup.div.setAttribute("onmouseout", "MouseEndPopup(this)");
	        this.popup.hide();
	        
	        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.style.cursor = 'pointer';
	        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 12px;\">" + _textS + _date1 + "<br />" + _textE + _date2 + "</strong>')");
	        $(tmpMarkersRec[tmpMarkersRec.length - 1].events.element).mouseout(function () { HidePopup() });
	        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.addEventListener('click', function (e) { AddPOI = true; VehClick = true; });
	    }
	} else
	{
		var size = new OpenLayers.Size(64, 48);
	    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2) - 2, (-size.h / 2) - 20); };
	    var icon1 = new OpenLayers.Icon(twopoint + '/images/Start.png', size, null, calculateOffset);
	    var icon2 = new OpenLayers.Icon(twopoint + '/images/Stop.png', size, null, calculateOffset);
	    var imgS = 'startRec';
	    var imgE = 'endRec';
	    var _textS = dic("Start", lang) + ":<br />";
	    var _textE = dic("End", lang) + ":<br />";
	    
	    if (Maps[0] != null) {
	        var ll = new OpenLayers.LonLat(parseFloat(_lonn1), parseFloat(_latt1)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject())
	        //if (MapType[0] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
	        var MyMar = new OpenLayers.Marker(ll, icon1)
	        var markers = Markers[0];
	
	        markers.addMarker(MyMar);
	        MyMar.events.element.style.zIndex = 999
	        tmpMarkersRec[tmpMarkersRec.length] = MyMar;
	        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.innerHTML = '<div class="gnPOI" style="background-color: ' + _color + '"; display:box; font-size:4px"></div>';
	        
	        var popup = new OpenLayers.Popup.FramedCloud("Popup",
	            ll,
	            new OpenLayers.Size(500, 500),
	            "<div class='text1' style='overflow: hidden; font-size:.8em; position: relative; left: -2px; top: -3px; width: 125px; height: 35px; margin-right: -15px; margin-bottom: -22px;'><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"" + _textS + "\")' onmouseout='HidePopup()' src='" + twopoint + "/images/" + imgS + ".png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _date1.split(/\-|\s/)[3].split(":")[0] + ":" + _date1.split(/\-|\s/)[3].split(":")[1] + " " + _date1.split(/\-|\s/)[2] + "-" + _date1.split(/\-|\s/)[1]+ "-" + _date1.split(/\-|\s/)[0] + "</strong></div>", null, true);
	        this.popup = popup;
	        this.popup.contentDiv.style.overflow = 'hidden';
	        map.addPopup(this.popup);
	        this.popup.div.style.opacity = '0.7';
	        this.popup.div.setAttribute("onmousemove", "MouseOverPopup(this)");
	        this.popup.div.setAttribute("onmouseout", "MouseEndPopup(this)");
	        this.popup.hide();
	        
	        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.style.cursor = 'pointer';
	        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 12px;\">" + _textS + _date1 + "</strong>')");
	        $(tmpMarkersRec[tmpMarkersRec.length - 1].events.element).mouseout(function () { HidePopup() });
	        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.addEventListener('click', function (e) { AddPOI = true; VehClick = true; });
	        
	        var ll = new OpenLayers.LonLat(parseFloat(_lonn2), parseFloat(_latt2)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject())
	        //if (MapType[0] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
	        var MyMar = new OpenLayers.Marker(ll, icon2)
	        var markers = Markers[0];
	
	        markers.addMarker(MyMar);
	        MyMar.events.element.style.zIndex = 999
	        tmpMarkersRec[tmpMarkersRec.length] = MyMar;
	        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.innerHTML = '<div class="gnPOI" style="background-color: ' + _color + '"; display:box; font-size:4px"></div>';
	        
	        var popup = new OpenLayers.Popup.FramedCloud("Popup",
	            ll,
	            new OpenLayers.Size(500, 500),
	            "<div class='text1' style='overflow: hidden; font-size:.8em; position: relative; left: -2px; top: -3px; width: 125px; height: 35px; margin-right: -15px; margin-bottom: -22px;'><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"" + _textE + "\")' onmouseout='HidePopup()' src='" + twopoint + "/images/" + imgE + ".png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _date2.split(/\-|\s/)[3].split(":")[0] + ":" + _date2.split(/\-|\s/)[3].split(":")[1] + " " + _date2.split(/\-|\s/)[2] + "-" + _date2.split(/\-|\s/)[1]+ "-" + _date2.split(/\-|\s/)[0] + "</strong></div>", null, true);
	        this.popup = popup;
	        this.popup.contentDiv.style.overflow = 'hidden';
	        map.addPopup(this.popup);
	        this.popup.div.style.opacity = '0.7';
	        this.popup.div.setAttribute("onmousemove", "MouseOverPopup(this)");
	        this.popup.div.setAttribute("onmouseout", "MouseEndPopup(this)");
	        this.popup.hide();
	        
	        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.style.cursor = 'pointer';
	        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 12px;\">" + _textE + _date2 + "</strong>')");
	        $(tmpMarkersRec[tmpMarkersRec.length - 1].events.element).mouseout(function () { HidePopup() });
	        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.addEventListener('click', function (e) { AddPOI = true; VehClick = true; });
	    }
	}
}

function LoadZone(_id) {
    ShowWait();
    $.ajax({
        url: twopoint + "/main/getVehPaths.php?id=" + _id + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
        	data = data.replace(/\r/g,'').replace(/\n/g,'');
            if(data.indexOf("#^*") == -1) {
            	var d = data.split("@");
                for (var i = 1; i < d.length; i++) {
                    for (var cz = 0; cz <= cntz; cz++) {
                        if (document.getElementById("zona_" + cz) != null)
                            if ($('#zona_' + cz)[0].attributes[1].nodeValue.indexOf(d[i].split("|")[0]) != -1)
                                $('#zona_' + cz)[0].checked = true;
                    }
                    DrawZoneOnLive(d[i].split("|")[0], d[i].split("|")[1]);
                    //if(i >= cntz)
                    	//HideWait();
                }
            } else {
                HideWait();
            }
            $('#div-AreasUp').css({ display: 'none' });
        }
    });
}
function ShowActiveBoard() {
    var tmpEl = document.getElementById("div-activeBoard");
    if (tmpEl != null) {
        if ($("#div-activeBoard").css('display') == "block") {
            $("#div-activeBoard").css({ display: "none" });
            $('#activeBoard').css("backgroundPosition", "0px 0px");
        } else {
            $("#div-activeBoard").css({ display: "block" });
            $('#activeBoard').css("backgroundPosition", "0px -24px");
        }
        return false;
    }
    var divPopup = document.getElementById('div-activeBoard')
    if (divPopup == null) { divPopup = Create(document.body, 'div', 'div-activeBoard') }
    $(divPopup).show();

    var _l = 270 //document.getElementById(elID).offsetLeft
    var _t = 40 //document.getElementById(elID).offsetTop


    divPopup.className = 'text2 corner5 shadow'
    $(divPopup).css({ position: 'absolute', zIndex: '9000', width: '150px', height: '60px', left: _l + 'px', top: _t + 'px', display: 'none', border: '1px solid #1a6ea5', backgroundColor: '#e2ecfa', padding: '4px 4px 4px 4px' })

    _html = ''
    _html = _html + '<div id="ActiveHeader" class="text7" style="font-size: 12px;">&nbsp;&nbsp;&nbsp;' + dic("ChooseActScr", lang) + '</div><hr style="border: 1px solid #1A6EA5" />';
    _html = _html + '<div id="quickbuttons" class="menu-container-qb-" style="font-size: 5px;">';
    if (SelectedSpliter == 0)
        _html = _html + '<div id="ActiveW1" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: 0px -24px;"></div>';
    else
        if (SelectedSpliter == 1) {
            _html = _html + '<div id="ActiveW1" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -24px -24px;"></div>';
            _html = _html + '<div id="ActiveW2" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -48px 0px;"></div>';
        } else
            if (SelectedSpliter == 2) {
                _html = _html + '<div id="ActiveW1" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -72px -24px;"></div>';
                _html = _html + '<div id="ActiveW2" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -96px 0px;"></div>';
            } else
                if (SelectedSpliter == 3) {
                    _html = _html + '<div id="ActiveW1" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -120px -24px;"></div>';
                    _html = _html + '<div id="ActiveW2" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -144px 0px;"></div>';
                    _html = _html + '<div id="ActiveW3" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -168px 0px;"></div>';
                } else
                    if (SelectedSpliter == 4) {
                        _html = _html + '<div id="ActiveW1" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -192px -24px;"></div>';
                        _html = _html + '<div id="ActiveW2" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -216px 0px;"></div>';
                        _html = _html + '<div id="ActiveW3" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -240px 0px;"></div>';
                    } else
                        if (SelectedSpliter == 5) {
                            _html = _html + '<div id="ActiveW1" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -264px -24px;"></div>';
                            _html = _html + '<div id="ActiveW2" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -288px 0px;"></div>';
                            _html = _html + '<div id="ActiveW3" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -312px 0px;"></div>';
                        } else
                            if (SelectedSpliter == 6) {
                                _html = _html + '<div id="ActiveW1" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -336px -24px;"></div>';
                                _html = _html + '<div id="ActiveW2" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -360px 0px;"></div>';
                                _html = _html + '<div id="ActiveW3" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -384px 0px;"></div>';
                            } else
                                if (SelectedSpliter == 7) {
                                    _html = _html + '<div id="ActiveW1" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -408px -24px;"></div>';
                                    _html = _html + '<div id="ActiveW2" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -432px 0px;"></div>';
                                    _html = _html + '<div id="ActiveW3" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -456px 0px;"></div>';
                                    _html = _html + '<div id="ActiveW4" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(' + twopoint + '/images/activew.png); background-position: -480px 0px;"></div>';
                                }

    _html = _html + '</div>'

    divPopup.innerHTML = _html

    $('#quickbuttons').children()[0].title = "checked";

    if (divPopup.offsetLeft + divPopup.offsetWidth > document.body.clientWidth) { divPopup.style.left = (document.body.clientWidth - divPopup.offsetWidth - 10) + 'px' }
    setTimeout("HideWait();msgInfo()", 2000);
}
function msgInfo() {
    if (parseInt(SelectedSpliter, 10) > 3)
    {
        var SCI = getCookie(_userId + "_screeninfo");
        if (SCI != "1") {
            $("#DivInfoForAll").css({ display: 'block' });
            msgboxN(dic("spleetScreenInfo", lang), "_screeninfo");
        }
    }
}

function ActiveWindow(id) {
    if (Math.abs(parseInt($('#' + id).css('backgroundPosition').substring($('#' + id).css('backgroundPosition').indexOf(" ") + 1, $('#' + id).css('backgroundPosition').length), 10)) > 0) {
        var bgp = $('#' + id).css('backgroundPosition').substring(0, $('#' + id).css('backgroundPosition').indexOf(" ")) + " " + "0px";
        $('#' + id).css("backgroundPosition", bgp);
        $('#' + id)[0].title = "";
        SelectBoard(parseInt(id.substring(id.length - 1, id.length), 10), false);
    } else {
        var bgp = $('#' + id).css('backgroundPosition').substring(0, $('#' + id).css('backgroundPosition').indexOf(" ")) + " " + "-24px";
        $('#' + id).css("backgroundPosition", bgp);
        $('#' + id)[0].title = "checked";
        SelectBoard(parseInt(id.substring(id.length - 1, id.length), 10), true);
    }
}
function SelectActiveBoard(_sel) {
    if (_sel == 0) { $('#div-active-mini').html('') }
    if (_sel == 1) {
        var h = '<div id="div-act-hspl" style="top:' + lastTop + 'px"></div>'
        $('#div-active-mini').html(h)
    }
    if (_sel == 2) {
        var h = '<div id="div-act-vspl" style="LEFT:' + lastLeft + 'px"></div>'
        $('#div-active-mini').html(h)
    }
    if (_sel == 3) {
        var h = '<div id="div-act-hspl" style="top:' + lastTop + 'px"></div>'
        h = h + '<div id="div-act-vspl1" style="left:' + lastLeft + 'px"></div>'
        $('#div-active-mini').html(h)
    }
    if (_sel == 4) {
        var h = '<div id="div-act-hspl" style="top:' + lastTop + 'px"></div>'
        h = h + '<div id="div-act-vspl2" style="left:' + lastLeft + 'px"></div>'
        $('#div-active-mini').html(h)
    }
    if (_sel == 5) {
        var h = '<div id="div-act-hspl1" style="top:' + lastTop + 'px"></div>'
        h = h + '<div id="div-act-vspl" style="left:' + lastLeft + 'px"></div>'
        $('#div-active-mini').html(h)
    }
    if (_sel == 6) {
        var h = '<div id="div-act-hspl2" style="top:' + lastTop + 'px"></div>'
        h = h + '<div id="div-act-vspl" style="left:' + lastLeft + 'px"></div>'
        $('#div-active-mini').html(h)
    }
    if (_sel == 7) {
        var h = '<div id="div-act-hspl" style="top:' + lastTop + 'px"></div>'
        h = h + '<div id="div-act-vspl" style="left:' + lastLeft + 'px"></div>'
        $('#div-active-mini').html(h)
    }
}

function checkCheck(num) {
    if (tmpCheckGroup[num] == "") {
        var i = 1;
        while (document.getElementById(num + "_checkRow" + i) != null) {
            document.getElementById(num + "_checkRow" + i).checked = false;
            i++;
        }
        document.getElementById(num + "_AllGroupCheck").checked = false;
    } else {
        var countCh = 0;
        for (var i = 1; i < tmpCheckGroup[num].length; i++) {
            if (tmpCheckGroup[num][i] == 1) {
                document.getElementById(num + "_checkRow" + i).checked = true;
                countCh++;
            }
            else {
                document.getElementById(num + "_checkRow" + i).checked = false;
            }
        }
    }
}
function checkGF(_num) {
    if (_num == 1) {
        if (document.getElementById('icon-draw-zone') != null)
            document.getElementById('icon-draw-zone').style.backgroundPosition = '0px -48px';
        else
            if (document.getElementById('div-gfimg') != null)
                document.getElementById('div-gfimg').style.backgroundColor = '#00ff00';
        ShowHideZone = true;
    } else {
        var cnt = 0;
        for (var cz = 0; cz <= cntz; cz++)
            if (document.getElementById("zona_" + cz) != null)
                if (!($('#zona_' + cz)[0].checked))
                    cnt++;
        if ((cnt - 1) == cntz)
            if (document.getElementById('icon-draw-zone') != null)
                document.getElementById('icon-draw-zone').style.backgroundPosition = '0px -72px';
            else
            	if (document.getElementById('div-gfimg') != null)
                {
                	document.getElementById('div-gfimg').style.backgroundColor = 'Red';
            		ShowHideZone = false;
            	}
    }
    
}

function SelectBoard(_sb, _onoff) {
    if (_onoff) {
        $('#div-border-' + _sb).css({ display: 'block' });
    } else {
        $('#div-border-' + _sb).css({ display: 'none' });
    }
}

function CreateMarker_Route(_lonn, _latt, _color, _dat, _type, _name, _len, _id) {
    var i = 0;
    var size = new OpenLayers.Size(16, 16);
    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
    var icon = new OpenLayers.Icon('./blank.png', size, null, calculateOffset);
    if (Maps[0] != null) {
        var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[i].getProjectionObject())
        //if (MapType[i] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
        var MyMar = new OpenLayers.Marker(ll, icon)
        var markers = Markers[i];
        markers.addMarker(MyMar);
        MyMar.events.element.style.zIndex = 666
        tmpMarkersRoute[tmpMarkersRoute.length] = MyMar;

        if (parseInt(_len, 10) > 1) {
            tmpMarkersRoute[tmpMarkersRoute.length - 2].events.element.children[0].style.backgroundColor = '#0066FF';
        }
        tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.innerHTML = '<div class="corner5" style="color: White; width: 14px; text-align: center; height: 14px; background: #' + _color + '; font-size: 11px;">' + (parseInt(_len, 10) + 1) + '<input id="hidLon_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _lonn + '" /><input id="hidLat_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _latt + '" /><input id="hidID_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _id + '" /></div>';
        tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.style.cursor = 'pointer';
        tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '" + dic("Poi", lang) + ":<br /><strong style=\"font-size: 14px;\">" + _name + "</strong>')");
        //tmpMarkersRoute[i][tmpMarkersRoute[i].length - 1].events.element.setAttribute("onclick", "EditPOI('" + _ppp[0] + "', '" + _ppp[1] + "', '" + _ppp[2] + "', '" + _ppp[3] + "', '" + _ppp[4] + "', '" + _ppp[5] + "', '" + _ppp[6] + "', '" + (tmpMarkersRoute[i].length - 1) + "', '" + _ppp[10] + "', '" + _ppp[11] + "')");
        $(tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element).mouseout(function () { HidePopup() });
    }
    if (tmpMarkersRoute.length > 1) {
        //debugger;
//        var _n = 2;
//        var _bool = true;
//        while (_bool) {
//            if ($('#hidLon_' + (tmpMarkersRoute.length - _n)).val() != undefined)
//                _bool = false;
//            else
//                _n++;
//        }
        //document.getElementById("testText").value = "   |   " + (tmpMarkersRoute.length - 1);
        
        if ($('#test1').attr('checked'))
            var file = "getLinePoints";
        else
            var file = "getLinePointsF";
        DrawLine_RouteNew(PointsOfRoute[_len].lon, PointsOfRoute[_len].lat, PointsOfRoute[_len + 1].lon, PointsOfRoute[_len + 1].lat, _len, "<br /><strong>" + dic("From", lang) + ": (" + _len + ")</strong> " + PointsOfRoute[_len].name + "<br /><strong>" + dic("To", lang) + ": (" + (_len + 1) + ")</strong> " + PointsOfRoute[_len + 1].name, file, _len);
    }
}
function CreateMarker_RouteKiki(_seQ1, _lonn, _latt, _color, _dat, _type, _name, _len, _id) {
	//alert(_color)
	var tempL = 0;
    var i = 0;
    var size = new OpenLayers.Size(16, 16);  
  
    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
    var icon = new OpenLayers.Icon('./blank.png', size, null, calculateOffset);
    if (Maps[0] != null) {
        var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[i].getProjectionObject())
        //if (MapType[i] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
        var MyMar = new OpenLayers.Marker(ll, icon)
        var markers = Markers[i];
        markers.addMarker(MyMar);
        MyMar.events.element.style.zIndex = 666
		       		
       tmpMarkersRoute[tmpMarkersRoute.length] = MyMar;

		
        if (parseInt(_len, 10) > 1) {
            tmpMarkersRoute[tmpMarkersRoute.length - 2].events.element.children[0].style.backgroundColor = '#0066FF';
        }
        
        var ch = 0;

		//tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.innerHTML = '<div class="corner5" style="color: White; width: 14px; text-align: center; height: 14px; background: red; font-size: 11px;">' + (parseInt(_len, 10) + 1) + '<input id="hidLon_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _lonn + '" /><input id="hidLat_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _latt + '" /><input id="hidID_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _id + '" /></div>';
        if (tmpMarkersRoute.length - 1 > 0 && _seQ1 == 0) {
	        for(var i=0; i<tmpMarkersRoute.length - 1; i++) {
	        	//alert(tmpMarkersRoute[tmpMarkersRoute.length - 1].lonlat.lon + " " + tmpMarkersRoute[i].lonlat.lon  + " " +  tmpMarkersRoute[tmpMarkersRoute.length - 1].lonlat.lat  + " " +  tmpMarkersRoute[i].lonlat.lat)
	        	if (tmpMarkersRoute[tmpMarkersRoute.length - 1].lonlat.lon == tmpMarkersRoute[i].lonlat.lon && tmpMarkersRoute[tmpMarkersRoute.length - 1].lonlat.lat == tmpMarkersRoute[i].lonlat.lat) {
	        		ch = 1;
	        		//if (ch == 1) {
	        			tempL = 1;
			        	tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.innerHTML = '<div class="corner5" style="color: White; width: 14px; text-align: center; height: 14px; background: #' + _color + '; font-size: 11px;">' + (parseInt(_len, 10) + 1) + '<input id="hidLon_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _lonn + '" /><input id="hidLat_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _latt + '" /><input id="hidID_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _id + '" /></div>';
			        	tmpMarkersRoute[i].events.element.children[0].style.borderRadius = "5px 0 0 5px";
			        	tmpMarkersRoute[i].events.element.children[0].style.borderRight = "1px solid #ffffff";
			        	
			        //} /*else {
			        	//tempL = 0;
			        	//tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.innerHTML = '<div class="corner5" style="color: White; width: 14px; text-align: center; height: 14px; background: #' + _color + '; font-size: 11px;">' + (parseInt(_len, 10) + 1) + '<input id="hidLon_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _lonn + '" /><input id="hidLat_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _latt + '" /><input id="hidID_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _id + '" /></div>';
			       // }*/
			     // break;
	        	} else {
	        		//tempL = 0;
			        tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.innerHTML = '<div class="corner5" style="color: White; width: 14px; text-align: center; height: 14px; background: #' + _color + '; font-size: 11px;">' + (parseInt(_len, 10) + 1) + '<input id="hidLon_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _lonn + '" /><input id="hidLat_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _latt + '" /><input id="hidID_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _id + '" /></div>';
	        	}
	        }  
        } else {
        	if (_color == "00CC33" && _seQ1 == 1) {
        		//tempL = 1;
	        	tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.innerHTML = '<div class="corner5" style="color: White; width: 14px; text-align: center; height: 14px; background: #' + _color + '; font-size: 11px;">' + (parseInt(_len, 10) + 1) + '<input id="hidLon_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _lonn + '" /><input id="hidLat_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _latt + '" /><input id="hidID_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _id + '" /></div>';
	       		tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.children[0].style.borderRadius = "5px 0 0 5px";
	       		tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.children[0].style.borderRight = "1px solid #ffffff";
	        } else {
	        	//tempL = 0;	        	
	        	tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.innerHTML = '<div class="corner5" style="color: White; width: 14px; text-align: center; height: 14px; background: #' + _color + '; font-size: 11px;">' + (parseInt(_len, 10) + 1) + '<input id="hidLon_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _lonn + '" /><input id="hidLat_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _latt + '" /><input id="hidID_' + (tmpMarkersRoute.length - 1) + '" type="hidden" value="' + _id + '" /></div>';
	        }
	        
	        if (_seQ1 == 1) {
        		if (_color == "00CC33") {
        			tempL = 0;        			
        		} else {
        			tempL = 1;
        		}
        	}
        }
		
		
		if (tempL == 1) {		
			tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.children[0].style.width = "24px"
			tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.children[0].style.textAlign = "right"
			tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.children[0].style.paddingRight = "4px"
			tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.children[0].style.zIndex = "665"
			tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.style.zIndex = "665"
		}
		
       		
        tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.style.cursor = 'pointer';
        tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '" + dic("Poi", lang) + ":<br /><strong style=\"font-size: 14px;\">" + _name + "</strong>')");
        //tmpMarkersRoute[i][tmpMarkersRoute[i].length - 1].events.element.setAttribute("onclick", "EditPOI('" + _ppp[0] + "', '" + _ppp[1] + "', '" + _ppp[2] + "', '" + _ppp[3] + "', '" + _ppp[4] + "', '" + _ppp[5] + "', '" + _ppp[6] + "', '" + (tmpMarkersRoute[i].length - 1) + "', '" + _ppp[10] + "', '" + _ppp[11] + "')");
        $(tmpMarkersRoute[tmpMarkersRoute.length - 1].events.element).mouseout(function () { HidePopup() });
        //debugger;
    }
    if (tmpMarkersRoute.length > 1) {
        //debugger;
//        var _n = 2;
//        var _bool = true;
//        while (_bool) {
//            if ($('#hidLon_' + (tmpMarkersRoute.length - _n)).val() != undefined)
//                _bool = false;
//            else
//                _n++;
//        }
        //document.getElementById("testText").value = "   |   " + (tmpMarkersRoute.length - 1);
        
        if ($('#test1').attr('checked'))
            var file = "getLinePoints";
        else
            var file = "getLinePointsF";   
         
        
        DrawLine_RouteNew(PointsOfRoute[_len].lon, PointsOfRoute[_len].lat, PointsOfRoute[_len + 1].lon, PointsOfRoute[_len + 1].lat, _len, "<br /><strong>" + dic("From", lang) + ": (" + _len + ")</strong> " + PointsOfRoute[_len].name + "<br /><strong>" + dic("To", lang) + ": (" + (_len + 1) + ")</strong> " + PointsOfRoute[_len + 1].name, file, _len);
    }
}
function Sec2StrPause(sec){
	var h = parseInt(sec/3600)
	sec = sec % 3600
	var m = parseInt(sec/60)
	sec = sec % 60
	var r = ''
	if (h>0){
		r = h + " h " + m + " min " // + sec + " sec"
	} else {
		if (m>0) {
			 r = m + " min " //+ sec + " sec"
		} else {
			r = sec + " sec"
		}
	}
	return r
}
function Sec2Str(sec){
	var h = parseInt(sec/3600)
	sec = sec % 3600
	var m = parseInt(sec/60)
	sec = sec % 60
	var r = ''
	if (h>0){
		r = h + " h " + m + " min " + sec + " sec"
	} else {
		if (m>0) {
			 r = m + " min " + sec + " sec"
		} else {
			r = sec + " sec"
		}
	}
	return r
}
function Sec2StrDir(sec){
    var h = parseInt(sec/3600)
    sec = sec % 3600
    var m = parseInt(sec/60)
    sec = sec % 60
    var r = ''
    if (h>0){
        r = h + " h " + m + " min";
    } else {
        if (m>0) {
             r = m + " min"
        } else {
            r = sec + " sec"
        }
    }
    return r
}
function Str2Sec(str){
	if(str == "/")
		return 0;
	var finsec = 0;
	var br = 0;
	for(var sec = str.split(" ").length-1; sec >= 0; sec--)
	{
		sec--;
		var seese1 = 1;
		for(var seese=0; seese < br; seese++)
			seese1 = seese1*60;
		br++;
		finsec += parseInt(str.split(" ")[sec], 10)*seese1;
	}
	return finsec
}
function DrawLine_RouteNew(_lon2, _lat2, _lon1, _lat1, _ordNum, _name, _file, _len) {
    //alert(_lon2 + "  |  " + _lat2 + "  |  " + _lon1 + "  |  " + _lat1 + "  |  " + _ordNum + "  |  " + _name + "  |  " + _file + "  |  " + _len);
    //alert(_file + ".php?lon1=" + _lon2 + "&lat1=" + _lat2 + "&lon2=" + _lon1 + "&lat2=" + _lat1 + "&len=" + _len);
    //return false;
    $.ajax({
        url: _file + ".php?lon1=" + _lon2 + "&lat1=" + _lat2 + "&lon2=" + _lon1 + "&lat2=" + _lat1 + "&len=" + _len,
        context: document.body,
        success: function (data) {
        	data = data.replace(/\r/g,'').replace(/\n/g,'');
            //var datTemp = data.substring(data.indexOf("route_geometry") + 18, data.indexOf("route_instructions") - 4).split("],[");
            var datTemp = data.split("^$")[0].split("%@");
            var chechLoadAll = true;
            
            if($('#IDMarker_' + PointsOfRoute[_len + 1].id + '_' + _len)[0] != undefined)
            {
            	var mmetric = ' km';
				var kilom = data.split("^$")[1];
				if(metric == 'mi')
				{
					mmetric = ' miles';
					kilom = data.split("^$")[1] * 0.621371;
				}
            	$('#IDMarker_' + PointsOfRoute[_len + 1].id + '_' + _len)[0].children[2].value = Math.round(kilom * 100)/ 100 + mmetric; //Math.round((parseInt(data.substring(data.indexOf("distance") + 10, data.indexOf("total_time") - 2), 10) / 1000)) + " km";
            	//var _min = Math.round((parseInt(data.substring(data.indexOf("total_time") + 12, data.indexOf("start_point") - 2), 10) / 60));
            	var _min = " )";
            	if($('#txt_alertWait').val() != "/")
            		_min = " min )";
            	$('#IDMarker_' + PointsOfRoute[_len + 1].id + '_' + _len)[0].children[3].value = Sec2Str(data.split("^$")[2]) + " ( " + $('#txt_alertWait').val() + _min; //~ ~(_min / 60) < 1 ? _min + " min" : (~ ~(_min / 60) + " h " + (_min % 60) + " min");
            	var totalkm = 0;
            	var totaltime = 0;
            	for(var bb = 0; bb < $('#MarkersIN')[0].children.length; bb++)
            	{
            		if($('#MarkersIN')[0].children[bb].children[2].value != "/")
            		{
	            		totalkm += parseFloat($('#MarkersIN')[0].children[bb].children[2].value,10);
            			totaltime += Str2Sec($('#MarkersIN')[0].children[bb].children[3].value.substring(0,$('#MarkersIN')[0].children[bb].children[3].value.indexOf("(")-1));
            		}
            		if(bb>0)
            			if($('#MarkersIN')[0].children[bb].children[2].value == "/")
            				chechLoadAll = false;
        		}
        		if($('#MarkersIN')[0].children.length == 0)
        			chechLoadAll = false;
        		for(var bb = 0; bb < $('#PauseOnRoute')[0].children.length; bb++)
            	{
        			totaltime += Str2Sec($('#PauseOnRoute')[0].children[bb].children[2].value + "0 sec");
        		}
        		if($('#txt_alertWait').val() != "/")
	            	totaltime += parseInt($('#txt_alertWait').val(), 10)*60*(parseInt($('#MarkersIN')[0].children.length, 10)-1);
            	$('#IDMarker_Total')[0].children[0].value = Math.round(totalkm * 100)/ 100 + mmetric;
            	$('#IDMarker_Total')[0].children[1].value = Sec2Str(totaltime);
        	}
            var _lon = new Array();
            var _lat = new Array();
            _lon[0] = _lon2;
            _lat[0] = _lat2;
            var ii = 1;
            for (var i = 1; i < datTemp.length; i++) {
                _lon[ii] = datTemp[i].split("#")[0];
                _lat[ii] = datTemp[i].split("#")[1];
                ii++;
            }
            _lon[ii] = _lon1;
            _lat[ii] = _lat1;

            var points = new Array();
            var styles = new Array();

            var debelina = 3;
            var opac = 0.7;
            for (var _j = 0; _j < _lon.length; _j++) {
                point = new OpenLayers.Geometry.Point(_lon[_j], _lat[_j]);
                point.transform(
			            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
			            Maps[0].getProjectionObject() // to Spherical Mercator Projection
		            );
                styles.push({ 'strokeWidth': debelina, 'strokeColor': '#0000FF', 'strokeOpacity': opac, 'VehID': _name });
                points.push(point);
            }

            lineFeatureRoute[_ordNum] = [];

            for (var i = 0; i < points.length - 1; i++) {
                var lineString1 = new OpenLayers.Geometry.LineString([points[i], points[i + 1]]);
                lineFeatureRoute[_ordNum][i] = new OpenLayers.Feature.Vector(lineString1, null, styles[i]);
                vectors[0].addFeatures([lineFeatureRoute[_ordNum][i]]);
                lineFeatureRoute[_ordNum][i].layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>" + dic("Route", lang) + "</strong>'+event.target._style.VehID)}");
                lineFeatureRoute[_ordNum][i].layer.events.element.setAttribute("onmouseout", "HidePopup()");
            }
            
            if(chechLoadAll)
            {
            	setTimeout("HideWait();", 500);
            	top.changeItem = false;
            	loadpauseonroute()
            }
            //if (optimalClick) {
            //if (document.getElementById('optimizedNarrative') == null)
            //return false;
            //$('#optimizedNarrative').html('');
            //$('#optimizedNarrative').css({ display: 'block' });
            //doOptimized('route', 'renderRoute');
            //}
            //doAdvanced(PointsOfRoute[1].lon, PointsOfRoute[1].lat, PointsOfRoute[PointsOfRoute.length - 1].lon, PointsOfRoute[PointsOfRoute.length - 1].lat);
        }
    });
}
function loadpauseonroute()
{
	if(document.getElementById("txt_pause1") == null)
		return false;
	if(pause1 != "0")
	{
		updatePause(pause1, 1);
		txt_pause1.value = pause1;
	}
	if(txt_pause1.value != "0")
	{
		updatePause(txt_pause1.value, 1);
		//txt_pause1.value = pause1;
	}
	if(pause2 != "0")
	{
		AddPause();
		txt_pause2.value = pause2;
		updatePause(pause2, 2);
	}
	if(txt_pause2.value != "0")
	{
		//AddPause();
		//txt_pause2.value = pause2;
		updatePause(txt_pause2.value, 2);
	}
	if(pause3 != "0")
	{
		AddPause();
		updatePause(pause3, 3);
		txt_pause3.value = pause3;
	}
	if(txt_pause3.value != "0")
	{
		//AddPause();
		updatePause(txt_pause3.value, 3);
		//txt_pause3.value = pause3;
	}
	if(pause4 != "0")
	{
		AddPause();
		updatePause(pause4, 4);
		txt_pause4.value = pause4;
	}
	if(txt_pause4.value != "0")
	{
		//AddPause();
		updatePause(txt_pause4.value, 4);
		//txt_pause4.value = pause4;
	}
	if(pause5 != "0")
	{
		AddPause();
		updatePause(pause5, 5);
		txt_pause5.value = pause5;
	}
	if(txt_pause5.value != "0")
	{
		//AddPause();
		updatePause(txt_pause5.value, 5);
		//txt_pause5.value = pause5;
	}
	if(tostay != "0")
	{
		updateTotal(tostay);
		txt_alertWait.value = tostay;
	}
}
function DrawLine_Route(_lon2, _lat2, _lon1, _lat1, _ordNum, _name) {
	//alert("getLinePoints.php?lon1=" + _lon2 + "&lat1=" + _lat2 + "&lon2=" + _lon1 + "&lat2=" + _lat1);
    //return false;
    $.ajax({
        url: "getLinePoints.php?lon1=" + _lon2 + "&lat1=" + _lat2 + "&lon2=" + _lon1 + "&lat2=" + _lat1,
        context: document.body,
        success: function (data) {
            //var datTemp = data.substring(data.indexOf("route_geometry") + 18, data.indexOf("route_instructions") - 4).split("],[");
            var datTemp = data.split("%@");
            var _lon = new Array();
            var _lat = new Array();
            _lon[0] = _lon2;
            _lat[0] = _lat2;
            var ii = 1;
            for (var i = 1; i < datTemp.length; i++) {
                _lon[ii] = datTemp[i].split("#")[0];
                _lat[ii] = datTemp[i].split("#")[1];
                ii++;
            }
            _lon[ii] = _lon1;
            _lat[ii] = _lat1;

            var points = new Array();
            var styles = new Array();

            var debelina = 3;
            var opac = 0.7;
            for (var _j = 0; _j < _lon.length; _j++) {
                point = new OpenLayers.Geometry.Point(_lon[_j], _lat[_j]);
                point.transform(
			            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
			            Maps[0].getProjectionObject() // to Spherical Mercator Projection
		            );
                styles.push({ 'strokeWidth': debelina, 'strokeColor': '#0000FF', 'strokeOpacity': opac, 'VehID': _name });
                points.push(point);
            }

            lineFeatureRoute[_ordNum] = [];

            for (var i = 0; i < points.length - 1; i++) {
                var lineString1 = new OpenLayers.Geometry.LineString([points[i], points[i + 1]]);
                lineFeatureRoute[_ordNum][i] = new OpenLayers.Feature.Vector(lineString1, null, styles[i]);
                vectors[0].addFeatures([lineFeatureRoute[_ordNum][i]]);
                lineFeatureRoute[_ordNum][i].layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>" + dic("Route", lang) + "</strong>'+event.target._style.VehID)}");
                lineFeatureRoute[_ordNum][i].layer.events.element.setAttribute("onmouseout", "HidePopup()");
            }

            //if (optimalClick) {
                //if (document.getElementById('optimizedNarrative') == null)
                    //return false;
                //$('#optimizedNarrative').html('');
                //$('#optimizedNarrative').css({ display: 'block' });
                //doOptimized('route', 'renderRoute');
            //}
            //doAdvanced(PointsOfRoute[1].lon, PointsOfRoute[1].lat, PointsOfRoute[PointsOfRoute.length - 1].lon, PointsOfRoute[PointsOfRoute.length - 1].lat);
        }
    });
}
function DrawLine_Route1(_lon2, _lat2, _lon1, _lat1, _ordNum, _sw, _name, _file) {
    ShowWait();
    //alert(_file + ".php?lon1=" + _lon2 + "&lat1=" + _lat2 + "&lon2=" + _lon1 + "&lat2=" + _lat1);
    //return false;
    $.ajax({
        url: _file + ".php?lon1=" + _lon2 + "&lat1=" + _lat2 + "&lon2=" + _lon1 + "&lat2=" + _lat1,
        context: document.body,
        success: function (data) {
        	data = data.replace(/\r/g,'').replace(/\n/g,'');
            //var datTemp = data.substring(data.indexOf("route_geometry") + 18, data.indexOf("route_instructions") - 4).split("],[");
            var datTemp = data.split("^$")[0].split("%@");
            var chechLoadAll = true;
            if($('#IDMarker_' + PointsOfRoute[parseInt(_ordNum, 10) + 1].id + '_' + _ordNum)[0] != undefined)
            {
	            var mmetric = ' km';
				var kilom = data.split("^$")[1];
				if(metric == 'mi')
				{
					mmetric = ' miles';
					kilom = data.split("^$")[1] * 0.621371;
				}
	            $('#IDMarker_' + PointsOfRoute[parseInt(_ordNum, 10) + 1].id + '_' + _ordNum)[0].children[2].value = Math.round(kilom * 100)/ 100 + mmetric; //Math.round((parseInt(data.substring(data.indexOf("distance") + 10, data.indexOf("total_time") - 2), 10) / 1000)) + " km";
	            //var _min = Math.round((parseInt(data.substring(data.indexOf("total_time") + 12, data.indexOf("start_point") - 2), 10) / 60));
	            var _min = " )";
            	if($('#txt_alertWait').val() != "/")
            		_min = " min )";
	            $('#IDMarker_' + PointsOfRoute[parseInt(_ordNum, 10) + 1].id + '_' + _ordNum)[0].children[3].value = Sec2Str(data.split("^$")[2]) + " ( " + $('#txt_alertWait').val() + _min; //~ ~(_min / 60) < 1 ? _min + " min" : (~ ~(_min / 60) + " h " + (_min % 60) + " min");
	            var totalkm = 0;
	            var totaltime = 0;
	            for(var bb = 0; bb < $('#MarkersIN')[0].children.length; bb++)
	           	{
	            	if($('#MarkersIN')[0].children[bb].children[2].value != "/")
	            	{
	            		totalkm += parseFloat($('#MarkersIN')[0].children[bb].children[2].value,10);
	            		totaltime += Str2Sec($('#MarkersIN')[0].children[bb].children[3].value.substring(0,$('#MarkersIN')[0].children[bb].children[3].value.indexOf("(")-1));
	            	}
	            	if(bb>0)
            			if($('#MarkersIN')[0].children[bb].children[2].value == "/")
            				chechLoadAll = false;
	            }
	            if($('#MarkersIN')[0].children.length == 0)
        			chechLoadAll = false;
	            for(var bb = 0; bb < $('#PauseOnRoute')[0].children.length; bb++)
            	{
        			totaltime += Str2Sec($('#PauseOnRoute')[0].children[bb].children[2].value + "0 sec");
        		}
	            $('#IDMarker_Total')[0].children[0].value = Math.round(totalkm * 100)/ 100 + mmetric;
	            if($('#txt_alertWait').val() != "/")
	            	totaltime += parseInt($('#txt_alertWait').val(), 10)*60*(parseInt($('#MarkersIN')[0].children.length, 10)-1);
	            $('#IDMarker_Total')[0].children[1].value = Sec2Str(totaltime);
			}
            var _lon = new Array();
            var _lat = new Array();
            _lon[0] = _lon2;
            _lat[0] = _lat2;
            var ii = 1;
            for (var i = 1; i < datTemp.length; i++) {
                _lon[ii] = datTemp[i].split("#")[0];
                _lat[ii] = datTemp[i].split("#")[1];
                ii++;
            }
            _lon[ii] = _lon1;
            _lat[ii] = _lat1;

            var points = new Array();
            var styles = new Array();

            var debelina = 3;
            var opac = 0.7;
            for (var _j = 0; _j < _lon.length; _j++) {
                point = new OpenLayers.Geometry.Point(_lon[_j], _lat[_j]);
                point.transform(
			            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
			            Maps[0].getProjectionObject() // to Spherical Mercator Projection
		            );
                styles.push({ 'strokeWidth': debelina, 'strokeColor': '#0000FF', 'strokeOpacity': opac, 'VehID': _name });
                points.push(point);
            }

            lineFeatureRoute[_ordNum] = [];
            for (var i = 0; i < points.length - 1; i++) {
                var lineString1 = new OpenLayers.Geometry.LineString([points[i], points[i + 1]]);
                lineFeatureRoute[_ordNum][i] = new OpenLayers.Feature.Vector(lineString1, null, styles[i]);
                vectors[0].addFeatures([lineFeatureRoute[_ordNum][i]]);
                lineFeatureRoute[_ordNum][i].layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>" +dic("Route",lang) + "</strong>'+event.target._style.VehID)}");
                lineFeatureRoute[_ordNum][i].layer.events.element.setAttribute("onmouseout", "HidePopup()");
            }
            if (_sw == 1) {
                for (var i = parseInt(_ordNum, 10) + 1; i < lineFeatureRoute.length - 1; i++) {
                    lineFeatureRoute[i] = lineFeatureRoute[i + 1];
                    lineFeatureRoute[i + 1] = "";
                }
                lineFeatureRoute = lineFeatureRoute.slice(0, i).concat(lineFeatureRoute.slice(i + 1));
            }
            if(chechLoadAll)
            	setTimeout("HideWait();", 500);
        }
    });
}
var TMOO;
var TMOO1;
var _idVehOpt;
var _idVehOpt1;
var _idVehList;
var _bl = false;
function OpenOptionsForVeh(event, _id, _id1, _bin) {
    if (_bin == 1) {
        if ($('#divOpt-' + _id).css("display") == "none") {
        	
            $('#divOpt-' + _id).css({ top: '' });
            $('#' + _id1)[0].style.backgroundImage = "url('" + twopoint + "/images/keyBlue1.png')";
            $('#divOpt-' + _id).css({ display: 'block', cursor: 'pointer' });
            //if (window.innerHeight - event.clientY < 115)
                $('#divOpt-' + _id).css({ top: (parseInt(event.clientY, 10) - 25) + 'px' });
        } else {
            $('#' + _id1)[0].style.backgroundImage = "url('" + twopoint + "/images/keyBlue.png')";
            $('#divOpt-' + _id).css({ display: 'none', cursor: 'default' });
        }
        //loadDrivList(_drivList);
    }
}
function loadDrivList(_drivID) {
    if ($('#' + _drivID).html() != "") {
        $('#' + _drivID).html(htmlDriversList);
        $(".dropdownDrivers dd ul li a").click(function (e) {
            var text = $(this).html();
            text = text.replace("150", "93");
            $(".dropdownDrivers dt a")[0].title = this.id;
            $(".dropdownDrivers dt a").attr({ 'title': this.id });

            $(".dropdownDrivers dt a span").html(text);
            $(".dropdownDrivers dd ul").hide();
        });
    }
}
function MouseOverOptions(_id, _id1) {
    if (_idVehOpt != _id || _bl) {
        window.clearTimeout(TMOO);
        window.clearTimeout(TMOO1);
        //$('#' + _idVehOpt).fadeOut('fast');
        $('#' + _idVehOpt).css({ display: 'none' });
        $('#divOpt-' + _idVehOpt1).css({ display: 'none' });
        $('#vehicleList-' + _idVehList).css({ border: '2px solid #BBBBBB' });
        _idVehOpt = _id;
        _idVehOpt1 = _id1;
        _idVehList = _id.substring(_id.lastIndexOf("-") + 1, _id.length);
        //document.getElementById("testText").value = _id.substring(_id.lastIndexOf("-") + 1, _id.length) + " | " + _id1;
        TMOO = window.setTimeout("ShowSettVeh()", 10);
        _bl = false;
        $('#' + _idVehOpt)[0].style.backgroundImage = "url('" + twopoint + "/images/keyBlue.png')";
        //2px solid #FF6600
    }
}
function ShowSettVeh() {
    $('#' + _idVehOpt).css({display: 'block'});  // fadeIn('fast');
    $('#vehicleList-' + _idVehList).css({ border: '2px solid #387CB0' });
    TMOO1 = window.setTimeout("HideSettVeh()", 20);
}
function HideSettVeh() {
    
    if ($('#divOpt-' + _idVehOpt1).css("display") == 'none') {
        var _ch = checkOver(_idVehOpt);
        if (!_ch) {
            window.clearTimeout(TMOO1);
            //$('#' + _idVehOpt).fadeOut('fast');
            $('#' + _idVehOpt).css({ display: 'none' });
            $('#vehicleList-' + _idVehList).css({ border: '2px solid #BBBBBB' });
            _bl = true;
        }
        else
        {
            window.clearTimeout(TMOO1);
            TMOO1 = window.setTimeout("HideSettVeh()", 20);
        }
    }
}
function MouseOutOptions(_id1) {
    if ($('#divOpt-' + _idVehOpt1).css("display") == 'none') {
        window.clearTimeout(TMOO);
        //$('#' + _idVehOpt).fadeOut('fast');
        $('#' + _idVehOpt).css({ display: 'none' });
        $('#vehicleList-' + _idVehList).css({ border: '2px solid #BBBBBB' });
        $('#divOpt-' + _idVehOpt1).css({ display: 'none' });
        $('#' + _id1)[0].style.backgroundImage = "url('" + twopoint + "/images/keyBlue.png')";
    }
}

function checkOver(_idVO) {
    var numOver1 = _idVO.substring(_idVO.lastIndexOf("-") + 1, _idVO.length);
    if (overId.indexOf("vh-") != -1)
        if (overId.substring(overId.lastIndexOf("-") + 1, overId.length) == numOver1)
            return true
        else
            return false
    else
        if (overId.indexOf("vehicleList") != -1)
            if (overId.substring(overId.lastIndexOf("-") + 1, overId.length) == numOver1)
                return true
            else
                return false
        else
            if (overId.indexOf("vehOption") != -1)
                if (overId.substring(overId.lastIndexOf("-") + 1, overId.length) == numOver1)
                    return true
                else
                    return false
            else
                if (overId.indexOf("div-taxi") != -1)
                    if (overId.substring(overId.lastIndexOf("-") + 1, overId.length) == numOver1)
                        return true
                    else
                        return false
}
function FuelSett(e, _id, _dis) {
    
    if (e.target.parentNode.id.indexOf("FuelSett-") != -1)
        if ($('#fuel-item-' + _id + _dis).css('display') == 'none') {
            $('#fuel-item-' + _id + _dis).css({ display: 'block' });
            $('#inp1-' + _id + _dis).val('');
            $('#inp2-' + _id + _dis).val('');
            //$('#DriversCombo-' + _id + _dis + ' span input').val(dic("SelectDriver", lang));
            //$('#VehiclesComboInput-' + _id).val('Izberete vozac');
            //$('#VehiclesComboInput-' + _id).attr({ value: 'Izberete vozac' });
            $('#inp1-' + _id + _dis).focus();
        }
        else {
            $('#fuel-item-' + _id + _dis).css({ display: 'none' });
        }
}
function DrivSett(e, _id, _dis) {
    if (e.target.parentNode.id.indexOf("DriverSett-") != -1)
        if ($('#driv-item-' + _id + _dis).css('display') == 'none')
            $('#driv-item-' + _id + _dis).css({ display: 'block' });
        else
            $('#driv-item-' + _id + _dis).css({ display: 'none' });
}

function EnableDisable(_alid, _vehlist, _load) {
    if ($('#menu-4').html() == null) {
        setTimeout("EnableDisable(" + _alid + ", " + _vehlist + ", '" + _load + "')", 1000);
    } else {
    	if(_load == "1")
    	{
    		$.ajax({
	            url: "UpdateActive.php?id=" + _alid + "&a=0" + "&load=" + _load,
	            context: document.body,
	            success: function (data) {
	                for (var i = 0; i < Vehicles.length; i++) {
	                    if (Vehicles[i].ID == _vehlist) {
	                        Vehicles[i].Marker.display(false);
	                    }
	                }
	                for (var i = 0; i < Car.length; i++) {
	                    if (Car[i].id == _vehlist) {
	                        Car[i].map0 = false;
	                        Car[i].map1 = false;
	                        Car[i].map2 = false;
	                        Car[i].map3 = false;
	                    }
	                }
	                $('#f-vehicle-0-' + _vehlist).attr({ checked: false });
	                $('#f-vehicle-1-' + _vehlist).attr({ checked: false });
	                $('#f-vehicle-2-' + _vehlist).attr({ checked: false });
	                $('#f-vehicle-3-' + _vehlist).attr({ checked: false });
	
	                var _b0 = _b1 = _b2 = _b3 = true;
	                for (var i = 0; i < VehicleListID.length; i++) {
	                    if ($('#f-vehicle-0-' + VehicleListID[i]).attr('checked')) {
	                        _b0 = false;
	                    }
	                    if ($('#f-vehicle-1-' + VehicleListID[i]).attr('checked')) {
	                        _b1 = false;
	                    }
	                    if ($('#f-vehicle-2-' + VehicleListID[i]).attr('checked')) {
	                        _b2 = false;
	                    }
	                    if ($('#f-vehicle-3-' + VehicleListID[i]).attr('checked')) {
	                        _b3 = false;
	                    }
	                }
	                if (_b0)
	                    $('#div-vehicle-tofollow-0').css({ color: '#FFFFFF' });
	                if (_b1)
	                    $('#div-vehicle-tofollow-1').css({ color: '#FFFFFF' });
	                if (_b2)
	                    $('#div-vehicle-tofollow-2').css({ color: '#FFFFFF' });
	                if (_b3)
	                    $('#div-vehicle-tofollow-3').css({ color: '#FFFFFF' });
	
	                $('#f-vehicle-0-' + _vehlist).attr({ disabled: true });
	                $('#f-vehicle-1-' + _vehlist).attr({ disabled: true });
	                $('#f-vehicle-2-' + _vehlist).attr({ disabled: true });
	                $('#f-vehicle-3-' + _vehlist).attr({ disabled: true });
	
	                $('#cb-vehicle-0-' + _vehlist).attr({ checked: false });
	                $('#cb-vehicle-1-' + _vehlist).attr({ checked: false });
	                $('#cb-vehicle-2-' + _vehlist).attr({ checked: false });
	                $('#cb-vehicle-3-' + _vehlist).attr({ checked: false });
	
	                $('#cb-vehicle-0-' + _vehlist).attr({ disabled: true });
	                $('#cb-vehicle-1-' + _vehlist).attr({ disabled: true });
	                $('#cb-vehicle-2-' + _vehlist).attr({ disabled: true });
	                $('#cb-vehicle-3-' + _vehlist).attr({ disabled: true });
	
	                $('#vehicleList-' + _vehlist).css({ display: 'none' });
	                $('#div-sv-' + _vehlist).css({ display: 'none' });
	                $('#div-pass-' + _vehlist).css({ display: 'none' });
	                $('#vehicleList-' + _vehlist + '-disable').css({ display: 'block' });
	                /*if ($('#menu-title-6').attr('className').indexOf("collapsed") != -1)
	                {
	                OnMenuClick(6);
	                OnMenuClick(6);
	                }
	                else {
	                
	                OnMenuClick(6);
	                }*/
	            }
	        });
    	} else
    	{
    		for (var i = 0; i < Vehicles.length; i++) {
                if (Vehicles[i].ID == _vehlist) {
                    Vehicles[i].Marker.display(false);
                }
            }
            for (var i = 0; i < Car.length; i++) {
                if (Car[i].id == _vehlist) {
                    Car[i].map0 = false;
                    Car[i].map1 = false;
                    Car[i].map2 = false;
                    Car[i].map3 = false;
                }
            }
            $('#f-vehicle-0-' + _vehlist).attr({ checked: false });
            $('#f-vehicle-1-' + _vehlist).attr({ checked: false });
            $('#f-vehicle-2-' + _vehlist).attr({ checked: false });
            $('#f-vehicle-3-' + _vehlist).attr({ checked: false });

            var _b0 = _b1 = _b2 = _b3 = true;
            for (var i = 0; i < VehicleListID.length; i++) {
                if ($('#f-vehicle-0-' + VehicleListID[i]).attr('checked')) {
                    _b0 = false;
                }
                if ($('#f-vehicle-1-' + VehicleListID[i]).attr('checked')) {
                    _b1 = false;
                }
                if ($('#f-vehicle-2-' + VehicleListID[i]).attr('checked')) {
                    _b2 = false;
                }
                if ($('#f-vehicle-3-' + VehicleListID[i]).attr('checked')) {
                    _b3 = false;
                }
            }
            if (_b0)
                $('#div-vehicle-tofollow-0').css({ color: '#FFFFFF' });
            if (_b1)
                $('#div-vehicle-tofollow-1').css({ color: '#FFFFFF' });
            if (_b2)
                $('#div-vehicle-tofollow-2').css({ color: '#FFFFFF' });
            if (_b3)
                $('#div-vehicle-tofollow-3').css({ color: '#FFFFFF' });

            $('#f-vehicle-0-' + _vehlist).attr({ disabled: true });
            $('#f-vehicle-1-' + _vehlist).attr({ disabled: true });
            $('#f-vehicle-2-' + _vehlist).attr({ disabled: true });
            $('#f-vehicle-3-' + _vehlist).attr({ disabled: true });

            $('#cb-vehicle-0-' + _vehlist).attr({ checked: false });
            $('#cb-vehicle-1-' + _vehlist).attr({ checked: false });
            $('#cb-vehicle-2-' + _vehlist).attr({ checked: false });
            $('#cb-vehicle-3-' + _vehlist).attr({ checked: false });

            $('#cb-vehicle-0-' + _vehlist).attr({ disabled: true });
            $('#cb-vehicle-1-' + _vehlist).attr({ disabled: true });
            $('#cb-vehicle-2-' + _vehlist).attr({ disabled: true });
            $('#cb-vehicle-3-' + _vehlist).attr({ disabled: true });

            $('#vehicleList-' + _vehlist).css({ display: 'none' });
            $('#div-sv-' + _vehlist).css({ display: 'none' });
            $('#div-pass-' + _vehlist).css({ display: 'none' });
            $('#vehicleList-' + _vehlist + '-disable').css({ display: 'block' });
            /*if ($('#menu-title-6').attr('className').indexOf("collapsed") != -1)
            {
            OnMenuClick(6);
            OnMenuClick(6);
            }
            else {
            
            OnMenuClick(6);
            }*/
    	}
    }
}
function EnableDisableDISABLE(_alid, _vehlist) {
    $.ajax({
        url: "UpdateActive.php?id=" + _alid + "&a=1&load=1",
        context: document.body,
        success: function (data) {
            //msgbox(data);
            $('#fuel-item-' + _alid + '-disable').css({ display: 'none' });
            //HideWait();

            for (var i = 0; i < Vehicles.length; i++) {
                if (Vehicles[i].ID == _vehlist) {
                    Vehicles[i].Marker.display(true);
                }
            }
            for (var i = 0; i < Car.length; i++) {
                if (Car[i].id == _vehlist) {
                    Car[i].map0 = true;
                    Car[i].map1 = true;
                    Car[i].map2 = true;
                    Car[i].map3 = true;
                }
            }
            $('#f-vehicle-0-' + _vehlist).attr({ checked: false });
            $('#f-vehicle-1-' + _vehlist).attr({ checked: false });
            $('#f-vehicle-2-' + _vehlist).attr({ checked: false });
            $('#f-vehicle-3-' + _vehlist).attr({ checked: false });

            $('#f-vehicle-0-' + _vehlist).attr({ disabled: false });
            $('#f-vehicle-1-' + _vehlist).attr({ disabled: false });
            $('#f-vehicle-2-' + _vehlist).attr({ disabled: false });
            $('#f-vehicle-3-' + _vehlist).attr({ disabled: false });

            $('#cb-vehicle-0-' + _vehlist).attr({ checked: true });
            $('#cb-vehicle-1-' + _vehlist).attr({ checked: true });
            $('#cb-vehicle-2-' + _vehlist).attr({ checked: true });
            $('#cb-vehicle-3-' + _vehlist).attr({ checked: true });

            $('#cb-vehicle-0-' + _vehlist).attr({ disabled: false });
            $('#cb-vehicle-1-' + _vehlist).attr({ disabled: false });
            $('#cb-vehicle-2-' + _vehlist).attr({ disabled: false });
            $('#cb-vehicle-3-' + _vehlist).attr({ disabled: false });

            $('#vehicleList-' + _vehlist).css({ display: 'block' });
            $('#vehicleList-' + _vehlist + '-disable').css({ display: 'none' });
            $('#div-sv-' + _vehlist).css({ display: 'block' });
            $('#div-pass-' + _vehlist).css({ display: 'block' });
            /*if ($('#menu-title-4').attr('className').indexOf("collapsed") != -1) {
                OnMenuClick(4);
                OnMenuClick(4);
            } else {

                OnMenuClick(4);
            }*/
        }
    });
}
var TMOOdis;
var TMOO1dis;
var _idVehOptdis;
var _idVehOpt1dis;
var _idVehListdis;
var _bldis = false;
function OpenOptionsForVehDISABLE(event, _id, _id1, _bin) {
    if (_bin == 1) {
        if ($('#divOpt-' + _id + '-disable').css("display") == "none") {
            $('#divOpt-' + _id + '-disable').css({ top: '' });
            $('#' + _id1)[0].style.backgroundImage = "url('" + twopoint + "/images/keyBlue1.png')";
            $('#divOpt-' + _id + '-disable').css({ display: 'block', cursor: 'pointer' });
            if (window.innerHeight - event.clientY < 115)
                $('#divOpt-' + _id + '-disable').css({ top: (parseInt(event.clientY, 10) - 105) + 'px' });
        } else {
            $('#' + _id1)[0].style.backgroundImage = "url('" + twopoint + "/images/keyBlue.png')";
            $('#divOpt-' + _id + '-disable').css({ display: 'none', cursor: 'default' });
        }
    }
}
function MouseOverOptionsDISABLE(_id, _id1) {
    if (_idVehOptdis != _id || _bldis) {
        window.clearTimeout(TMOOdis);
        window.clearTimeout(TMOO1dis);

        $('#' + _idVehOptdis).css({ display: 'none' });
        $('#divOpt-' + _idVehOpt1dis + '-disable').css({ display: 'none' });
        $('#vehicleList-' + _idVehListdis + '-disable').css({ border: '2px solid #BBBBBB' });
        _idVehOptdis = _id;
        _idVehOpt1dis = _id1;
        _idVehListdis = _id.substring(_id.indexOf("-") + 1, _id.lastIndexOf("-"));

        TMOOdis = window.setTimeout("ShowSettVehDISABLE()", 10);
        _bldis = false;
        $('#' + _idVehOptdis)[0].style.backgroundImage = "url('" + twopoint + "/images/keyBlue.png')";
    }
}
function ShowSettVehDISABLE() {
    $('#' + _idVehOptdis).css({ display: 'block' });  // fadeIn('fast');
    $('#vehicleList-' + _idVehListdis + '-disable').css({ border: '2px solid #387CB0' });
    TMOO1dis = window.setTimeout("HideSettVehDISABLE()", 20);
}
function HideSettVehDISABLE() {
    if ($('#divOpt-' + _idVehOpt1dis + '-disable').css("display") == 'none') {
        var _ch = checkOver(_idVehOptdis);
        if (!_ch) {
            window.clearTimeout(TMOO1dis);
            $('#' + _idVehOptdis).css({ display: 'none' });
            $('#vehicleList-' + _idVehListdis + '-disable').css({ border: '2px solid #BBBBBB' });
            _bldis = true;
        }
        else {
            window.clearTimeout(TMOO1dis);
            TMOO1dis = window.setTimeout("HideSettVehDISABLE()", 20);
        }
    }
}
function MouseOutOptionsDISABLE(_id1) {
    if ($('#divOpt-' + _idVehOpt1dis + '-disable').css("display") == 'none') {
        window.clearTimeout(TMOOdis);
        $('#' + _idVehOptdis).css({ display: 'none' });
        $('#vehicleList-' + _idVehListdis + '-disable').css({ border: '2px solid #BBBBBB' });
        $('#divOpt-' + _idVehOpt1dis + '-disable').css({ display: 'none' });
        $('#' + _id1)[0].style.backgroundImage = "url('" + twopoint + "/images/keyBlue.png')";
    }
}

function AddFuel(_alid, _dis) {
    //var _alid = event.target.id.substring(event.target.id.lastIndexOf("-") + 1, event.target.id.length);
    if ($('#DriversSett-' + _alid + _dis).val() != "" && $('#inp1-' + _alid + _dis).val() != "" && $('#inp2-' + _alid + _dis).val() != "") {
        ShowWait();
        $.ajax({
            url: "AddFuelSettings.php?alid=" + _alid + "&drivID=" + $('#DriversSett-' + _alid + _dis).val() + "&litri=" + $('#inp1-' + _alid + _dis).val() + "&iznos=" + $('#inp2-' + _alid + _dis).val(),
            context: document.body,
            success: function (data) {
                msgbox(data);
                $('#fuel-item-' + _alid + _dis).css({ display: 'none' });
                HideWait();
            }
        });
    } else {
        msgbox(dic("ReqFields", lang));
    }
}
function CloseSett(_id, _dis) {
    $('#divOpt-' + _id + _dis).css({ display: 'none' });
    if (_dis == "")
        _bl = true;
    else
        _bldis = true;
}
function loadDriversList() {
    $.ajax({
        url: "getDriversList.aspx",
        context: document.body,
        success: function (data) {
            htmlDriversList = data;
        }
    });
}
function formatdatetime(_dt) {
    if(datetimeformat != undefined) {
        if(datetimeformat == "d-m-Y H:i:s") {
            return _dt.split(' ')[0].split('-')[2] + '-' + _dt.split(' ')[0].split('-')[1] + '-' + _dt.split(' ')[0].split('-')[0] + ' ' + _dt.split(" ")[1];
        } else
            if(datetimeformat == "d-m-Y h:i:s A") {
                return _dt.split(' ')[0].split('-')[2] + '-' + _dt.split(' ')[0].split('-')[1] + '-' + _dt.split(' ')[0].split('-')[0] + ' ' + _dt.split(" ")[1];
            } else
                if(datetimeformat == "d-m-Y h:i:s") {
                    return _dt.split(' ')[0].split('-')[2] + '-' + _dt.split(' ')[0].split('-')[1] + '-' + _dt.split(' ')[0].split('-')[0] + ' ' + _dt.split(" ")[1];
                } else
                    if(datetimeformat == "m-d-Y h:i:s A") {
                        return _dt.split(' ')[0].split('-')[2] + '-' + _dt.split(' ')[0].split('-')[1] + '-' + _dt.split(' ')[0].split('-')[0] + ' ' + _dt.split(" ")[1];
                    } else
                        return _dt;
    }
}
function formatdatetimeusa(_dt) {
    
    return _dt.split(' ')[0].split('-')[2] + '-' + _dt.split(' ')[0].split('-')[0] + '-' + _dt.split(' ')[0].split('-')[1] + ' ' + _dt.split(" ")[1];
}

function setStopPositionCenter(lon, lat, text) {
    setCenterMap(lon, lat, 18, 0);
    AddMarkerS(lon, lat, 0, text.replace(/\r/g,'').replace(/\n/g,''), "");
}
