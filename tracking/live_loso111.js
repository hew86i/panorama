// JavaScript Document
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

var FollowActive = [];
FollowActive[0] = false;
FollowActive[1] = false;
FollowActive[2] = false;
FollowActive[3] = false;

var ClosePopUp = true;

reloadMarker = false;

var _index = 1;
var TimerRec;

var loadAjaxRec;

var traceForUser = 10;
var snooze = 10;

var metric = 'Km';

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

var tmpMarkersTrajectory = []
tmpMarkersTrajectory[0] = [];
tmpMarkersTrajectory[1] = [];
tmpMarkersTrajectory[2] = [];
tmpMarkersTrajectory[3] = [];


var tmpSearchMarker;

var ArrAreasPoly = [];
var ArrAreasId = [];
var ArrAreasCheck = [];

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
var CarStr = ""
var SaveLocal = true
var SaveGlobal = true
var Timers = [];
Timers[0] = [];
Timers[1] = [];
Timers[2] = [];
Timers[3] = [];


var AjaxStarted = false
var RecStarted = false
var Routing = false

var InitLoad = false
var VehicleList = []
var VehicleListID = []
var AddPOI = false
var VehClick = false

var ShowVehiclesMenu = true;
var LoadCurrentPosition = true;
var ShowPOI = false
var OpenForDrawing = false
var controls = [];
var vectors = [];
var VehcileIDs = []

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

function CarType(_id, _color, _lon, _lat, _reg){
	this.id = _id
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
    $('#icon-legenda').css({ top: (document.body.offsetHeight - document.body.clientHeight + _plus) * (-1) + 'px' });
    //for (var i=0;i<5;i++){if (Boards[i]!=null) { setSwitcherHeight(Boards[i], i)}}
    SetBorderDimension();
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
        if ($('#add-2-' + num).html().indexOf(dic("Poi", lang)) != -1) {
            AddPOI = true
            for (var i = 0; i < Boards.length; i++) {
                if (Boards[i] != null) {
                    Boards[i].style.cursor = 'crosshair'
                }
            }
            $('#add-2-' + num).html("&nbsp;&nbsp;" + dic("cancel", lang) + "");
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
                    $('#add-2-' + i).html("&nbsp;&nbsp;" + dic("Poi", lang) + "");
                }
            }
            //$('#div-addPoi-' + num)[0].textContent = "Add POI +";
        }
    } else {
        for (var i = 0; i < 4; i++) {
            if (Boards[i] != null) {
                Boards[i].style.cursor = 'default';
                $('#add-2-' + i).html("&nbsp;&nbsp;" + dic("Poi", lang) + "");
            }
        }
    }
}

function CheckRow(_t, _max, _num) {
    if (_t == "All") {
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
    else {
        document.getElementById(_num + "_AllGroupCheck").checked = false;
        if (document.getElementById(_num + "_checkRow" + _t).checked)
            document.getElementById(_num + "_checkRow" + _t).checked = false;
        else
        	document.getElementById(_num + "_checkRow" + _t).checked = true;
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
            data = data.replace("\r", "").replace("\n", "");
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
            $(divPopupUp).css({ position: 'absolute', zIndex: '9000', width: 'auto', height: 'auto', left: _l + 'px', top: _t + 'px', display: 'block', border: '1px solid #1a6ea5', backgroundColor: '#e2ecfa', padding: '4px 4px 4px 4px' })
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
                //var _bgimg = 'http://gps.mk/new/pin/?color=' + _groups[i].split("|")[2] + '&type=0';
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
            	_html1 += '<div id="trajectoryslider" style="height: 10px; width: 104px; position: absolute; margin-top: 4px; left: 14px;"></div><input disabled class="text2_" id="trajectoryvalue" style="width: 30px; height: 20px; position: relative; text-align: center; top: -2px; left: -7px;" />';
            	_html1 += '<input id="btnCancel1" type="button" value="' + dic("cancel", lang) + '" class="corner5 text8" onclick="CancelPOIGroupTraj(\'' + _id1 + '\',\'' + _idIcon + '\',\'' + _num + '\',\'' + data.split("#")[1].split("|")[3] + '\')" />&nbsp;<input id="btnApplay" type="button" value="OK" class="corner5 text8" onclick="Applay_' + _num + '(' + _num + ',\'' + _id1 + '\')" />&nbsp;</div>';
        	} else
        		_html1 += '<input id="btnCancel1" type="button" value="' + dic("cancel", lang) + '" class="corner5 text8" onclick="CancelPOIGroup(\'' + _id1 + '\',\'' + _idIcon + '\',\'' + _num + '\')" />&nbsp;<input id="btnApplay" type="button" value="OK" class="corner5 text8" onclick="Applay_' + _num + '(' + _num + ',\'' + _id1 + '\')" />&nbsp;</div>';
            divPopupUp.innerHTML += _html1;
            if(_num == 1)
            {
            	$('#trajectoryvalue').val(data.split("#")[1].split("|")[3]);
	            $('#trajectoryslider').slider({
					value:data.split("#")[1].split("|")[3],
					min: 10,
					max: 180,
					step: 10,
					animate: true,
					slide: function( event, ui ) {
						// /SpeedRec = 1000 - Math.abs(parseInt(ui.value, 10));
						//debugger;
						$('#trajectoryvalue').val(parseInt(ui.value, 10));
						$(ui.handle).blur();
					},
					change: function( event, ui ) { $(ui.handle).blur(); }
					}
				);
				//trajectoryslider
				$('#trajectoryslider').mousemove(function (event) { ShowPopup(event, 'Должина на траекторија во минути') });
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
			max: 180,
			step: 10,
			animate: true,
			slide: function( event, ui ) {
				// /SpeedRec = 1000 - Math.abs(parseInt(ui.value, 10));
				//debugger;
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
		    url: "getGeocode.php?lon=" + lonlat.lon + "&lat=" + lonlat.lat,
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
            url: "getGeocode.php?lon=" + lon + "&lat=" + lat,
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
    for (var p = 0; p < 1; p++)
        document.getElementById("GroupIconImg" + p).src = 'http://gps.mk/new/pin/?color=' + _color + '&type=0';
    setTimeout('$("#tblIconsPOI").css({ visibility: "visible" }); $("#loadingIconsPOI").css({ visibility: "hidden" });', 1500);
}
function AddGroup(_tbl) {
    $('#GroupName').val('');
    $("#colorPicker1").css("background-color", "transparent");
    $("#GroupIcon0").attr({ checked: 'checked' });
    $("#clickAny").val('');
    for (var p = 0; p < 1; p++)
        document.getElementById("GroupIconImg" + p).src = 'http://gps.mk/new/pin/?color=ffffff&type=0';
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
        for (var i = 0; i < 1; i++)
            if ($('#GroupIcon' + i)[0].checked) {
                var _img = i;
                break;
            }
			
            //alert("AddGroupNew.php?groupName=" + String($('#GroupName').val()) + "&fcolor=" + String($("#clickAny").val().substring(1, $("#clickAny").val().length)) + "&img=" + _img + "&l=" + lang);
            $.ajax({
                url: "AddGroupNew.php?groupName=" 