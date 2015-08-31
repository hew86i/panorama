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

var loadAjaxRec;

var traceForUser = 10;
var snooze = 10;

var SelectedBoard = 0;

var SpeedRec = 1000;
var PlayForwardRec = true;
var PlayBackRec = false;

var PlayForwardJumpRec = false;
var PlayBacJumpkRec = false;

var TIMEOUTREC;
var clickedDay = 0;
var IndexRec = 1;

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
	this.taxi = '0'
	this.sedista = '0'
	this.olddate = '0'
	this.gis = '';
	this.alarm = '';
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
            $(divPopup).css({ position: 'static', width: 'auto', height: 'auto', overflow: 'hidden', left: (parseInt(_l, 10) + 2) + 'px', top: (parseInt(_t, 10) + 2) + 'px', display: 'block', backgroundColor: '#e2ecfa', padding: '4px 4px 4px 4px' })
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
        	if (PathPerVeh[Vehicles[i-1].ID] == undefined || PathPerVeh[Vehicles[i-1].ID] == "") {
        		PathPerVeh[Vehicles[i-1].ID] = [];
        		get10Points1(Vehicles[i-1].ID, Vehicles[i-1].Reg, $('#trajectoryvalue').val());
        	}
            _ids += document.getElementById(_num + "_checkRow" + i).alt + ", ";
            tmpCheckGroup[_num][i] = 1;
        } else {
            tmpCheckGroup[_num][i] = 0;
            if (PathPerVeh[Vehicles[i-1].ID] != undefined && PathPerVeh[Vehicles[i-1].ID] != "") {
                for (var j = 0; j < PathPerVeh[Vehicles[i-1].ID].length; j++)
                    for (var z = 0; z < 5; z++)
                        if (Boards[z] != null)
                            vectors[z].removeFeatures(PathPerVeh[Vehicles[i-1].ID][j]);
                PathPerVeh[Vehicles[i-1].ID] = [];
            }
        }
        i++;
    }
    
    _ids = _ids.substring(0, _ids.length - 2);
    if (_ids == "") {
    	ClearGraphic();
        ShowHideTrajectory = false;
        PathPerVeh = [];
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
	                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    p: '29px', padding: '2px 5px 2px 5px', width: '55px', cursor: 'pointer', textAlign: 'center' })
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

function CancelDrawingArea(num) {
    $('#add-button-' + num).css({ color: '#ffffff', cursor: 'pointer' })
    $('#save1-button-' + num).css({ display: 'none' });
    $('#cancel1-button-' + num).css({ display: 'none' });
    $('#separator-button-' + num).css({ display: 'none' });
    ClearGraphic()
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
function SaveNewArea(num) {
    if (vectors[num].features.length == 0) {
        msgbox(dic("NoGF", lang));
        return
    }
    $('#GFcheck1').attr({ checked: 'checked' });
    $('#GFcheck2').attr({ checked: '' });
    $('#GFcheck3').attr({ checked: '' });
    $('#gfCant').css({ visibility: 'visible' });

    $('#chk_1_in').attr({ checked: '' });
    $('#chk_1_out').attr({ checked: '' });
    $('#chk_2_in').attr({ checked: '' });
    $('#chk_2_out').attr({ checked: '' });
    for (var i = 0; i < VehcileIDs.length - 1; i++) {
        $('#av_' + VehcileIDs[i]).attr({ checked: '' });
        $('#in_' + VehcileIDs[i]).attr({ checked: '' });
        $('#out_' + VehcileIDs[i]).attr({ checked: '' });
    }
    $('#txt_zonename').val('');
    $('#txt_phones').val('');
    $('#txt_emails').val('');
    $('#gfAvail').buttonset();
    $('#AddGroup1').button();
    $("#gfGroup dt a")[0].title = "";
    $("#gfGroup dt a span").html(dic("selGroup", lang));
    $('#txt_zonename').focus();
    controls[num].modify.deactivate();
    $('#div-enter-zone-name').attr("title", dic("AddGF", lang));
    $('#div-enter-zone-name').dialog({ modal: true, zIndex: 9999, width: 642, height: 585, resizable: false,
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
                                                url: "checkPassword.php?pass=" + $('#alGeoFencePass').val(),
                                                context: document.body,
                                                success: function (data) {
                                                    if (data.indexOf("Wrong") != -1) {
                                                        HideWait();
                                                        msgbox(dic("WrongPass", lang));
                                                    } else {
                                                        /*var strPoints = 'POLYGON((';
							                            for (var i = 0; i < selectedFeature[SelectedBoard].geometry.components[