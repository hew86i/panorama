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



var ClosePopUp = false;

var loadAjaxRec;

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
	this.gis = ''
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
    $('#div-map').css({ width: (w - 2) + 'px', height: (h - 1) + 'px', overview: 'hidden' });
    $('#div-map1').css({ width: (w - 2) + 'px', height: (h - 1) + 'px', overview: 'hidden' });
    $('#div-map2').css({ width: (w - 2) + 'px', height: (h - 1) + 'px', overview: 'hidden' });
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
            tmpCheckGroup[_num] = [];

            var _groups = JXG.decompress(data).split("#");
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
            $(divPopup).css({ position: 'static', width: 'auto', height: 'auto', left: (parseInt(_l, 10) + 2) + 'px', top: (parseInt(_t, 10) + 2) + 'px', display: 'block', backgroundColor: '#e2ecfa', padding: '4px 4px 4px 4px' })
            divPopup.style.minWidth = "200px";
            divPopup.style.maxHeight = "300px";
            divPopup.style.overflowY = "auto";

            var _html = ''
            _html += '<table id="' + _num + '_table" border="0" width="95%" >';
            _html += '<tr class="text7"><td style="border-bottom: 1px Solid #1a6ea5;">&nbsp;</td><td style="text-align: left; border-bottom: 1px Solid #1a6ea5; border-left: 1px Solid #1a6ea5;">&nbsp;&nbsp;' + _gr + '</td><td width="10%" style="text-align: center; border-bottom: 1px Solid #1a6ea5; border-left: 1px Solid #1a6ea5; ' + displ + '">' + dic("symbol", lang) + '</td></tr>';
            _html += '<tr class="text8" style="height: 10px; cursor: pointer;" onclick="CheckRow(\'All\', ' + _groups.length + ',' + _num + ')"><td><input id="' + _num + '_AllGroupCheck" onclick="CheckRow(\'All\', ' + _groups.length + ',' + _num + ')" type="checkbox" ' + _ch + ' /></td><td style="text-align: left; border-left: 1px Solid #1a6ea5;">&nbsp;&nbsp;&nbsp;' + dic("all", lang) + '</td><td width="10%" style="text-align: center; border-left: 1px Solid #1a6ea5; ' + displ + '"><div style="border: 1px Solid #1a6ea5; margin-left: 10px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 16px; height: 16px; background-color: Transparent"></div></td></tr>';
            for (var i = 1; i < _groups.length; i++) {
                _html += '<tr class="text8" style="height: 10px; cursor: pointer;" onclick="CheckRow(' + i + ', ' + _groups.length + ',' + _num + ')"><td><input id="' + _num + '_checkRow' + i + '" alt="' + _groups[i].split("|")[1] + '" onclick="CheckRow(' + i + ', ' + _groups.length + ',' + _num + ')" type="checkbox" ' + _ch + ' /></td><td style="text-align: left; border-left: 1px Solid #1a6ea5;">&nbsp;&nbsp;&nbsp;';
                if (vehnum) {
                    _html += "(" + _groups[i].split("|")[2] + ") ";
                }
                var _bgimg = 'http://gps.mk/new/pin/?color=' + _groups[i].split("|")[2] + '&type=' + _groups[i].split("|")[3];
                _html += _groups[i].split("|")[0] + '</td><td width="10%" style="text-align: center; border-left: 1px Solid #1a6ea5; ' + displ + '"><div style="margin-left: 8px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 24px; height: 24px; background: url(' + _bgimg + ') no-repeat;"></div></td></tr>';
                if (_sh)
                    tmpCheckGroup[_num][i] = 1;
            }
            _html += "</table>";
            //_html += '<tr><td style="padding-top: 10px;" colspan="3"><hr style="border: 1px solid #1A6EA5" /><input id="btnCancel1" type="button" value="Cancel" class="corner5 text2" onclick="CancelPOIGroup()" />&nbsp;<input id="btnApplay" type="button" value="OK" class="corner5 text2" onclick="ApplayPOIGroup(' + _groups.length + ')" /><td></tr>';
            divPopup.innerHTML = _html;
            var _html1 = '<br /><hr style="border: 1px solid #1A6EA5" /><div align="right"><input id="btnCancel1" type="button" value="' + dic("cancel", lang) + '" class="corner5 text8" onclick="CancelPOIGroup(\'' + _id1 + '\',\'' + _idIcon + '\',\'' + _num + '\')" />&nbsp;<input id="btnApplay" type="button" value="OK" class="corner5 text8" onclick="Applay_' + _num + '(' + _num + ',\'' + _id1 + '\')" />&nbsp;</div>';
            divPopupUp.innerHTML += _html1;
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
    var _ids = "";
    var i = 1;
    while (document.getElementById(_num + "_checkRow" + i) != null) {
        if (document.getElementById(_num + "_checkRow" + i).checked) {
            _ids += document.getElementById(_num + "_checkRow" + i).alt + ", ";
            tmpCheckGroup[_num][i] = 1;
        } else {
            tmpCheckGroup[_num][i] = 0;
            if (PathPerVeh[i] != undefined && PathPerVeh[i] != "") {
                for (var j = 0; j < PathPerVeh[i].length; j++)
                    for (var z = 0; z < 5; z++)
                        if (Boards[z] != null)
                            vectors[z].removeFeatures(PathPerVeh[i][j]);
                PathPerVeh[i] = [];
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
function CreateBoards1() {
    var Parent = document.getElementById('div-map1');

    Boards[1] = Create(Parent, 'div', 'div-map-2');
    $(Boards[1]).css({ width: '100%', height: (Parent.offsetHeight) + 'px' });
    Border[1] = Create(Parent, 'div', 'div-border-2');
    $(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[1])[0].clientWidth - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 5) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: '0px', border: '3px Solid #FF6633' });
}

function CreateBoards2() {
    var Parent = document.getElementById('div-map2');

    Boards[2] = Create(Parent, 'div', 'div-map-3');
    $(Boards[2]).css({ width: '100%', height: (Parent.offsetHeight) + 'px' });
    Border[2] = Create(Parent, 'div', 'div-border-3');
    $(Border[2]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[2])[0].clientWidth - 6) + 'px', height: ($(Boards[2])[0].clientHeight - 5) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: '0px', border: '3px Solid #FF6633' });
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

		Boards[1] = Create(tmp1, 'div', 'div-map-2')
		$(Boards[1]).css({ width: (100) + '%', height: (100 * pp2) + '%', borderTop: '1px solid #1a6ea5', overflow: 'hidden' });
		Border[1] = Create(Parent, 'div', 'div-border-2');
		//$(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[1])[0].clientWidth - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 7) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3) + 'px', top: ($(Boards[1])[0].offsetTop + (Browser() == "Firefox" ? 33 : 1)) + 'px', border: '3px Solid #FF6633' });
		$(Border[1]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[1])[0].clientWidth - 6) + 'px', height: ($(Boards[1])[0].clientHeight - 7) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3) + 'px', top: ($(Boards[1])[0].offsetTop + 1) + 'px', border: '3px Solid #FF6633' });

		Boards[2] = Create(tmp2, 'div', 'div-map-3')
		$(Boards[2]).css({ width: (100) + '%', height: (100 * pp1) + '%', borderBottom: '1px solid #1a6ea5', overflow: 'hidden' });
		Border[2] = Create(Parent, 'div', 'div-border-3');
		$(Border[2]).css({ left: ($(Boards[2])[0].offsetLeft + (parseInt($('#race-img').css('left'), 10) > 200 ? 250 : 3)) + 'px' });
		//$(Border[2]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px', height: ($(Boards[2])[0].clientHeight - 6) + 'px', top: (Browser() == "Firefox" ? '32' : '0') + 'px', border: '3px Solid #FF6633' });
		$(Border[2]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: (document.body.clientWidth - parseInt($(Border[2]).css('left'), 10) - 6) + 'px', height: ($(Boards[2])[0].clientHeight - 6) + 'px', top: '0px', border: '3px Solid #FF6633' });
		
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
        if (Border[1] != undefined) {
            $(Border[1]).css({ width: (document.body.clientWidth - parseInt($(Border[0]).css('left'), 10) - 6) + 'px' });
            $(Border[1]).css({ height: (document.body.clientHeight - parseInt($(Border[0]).css('top'), 10) - 6) + 'px' });
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
        $('#poiAddress').val('');
        $('#loadingAddress').css({ visibility: "visible" });
        $('#APcheck2').attr({ checked: 'checked' });
        $('#APcheck3').attr({ checked: '' });
        $('#poiCant').css({ visibility: 'visible' });
		var lonlat = map.getLonLatFromViewPortPx(e.xy).transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"))
		if (parseInt(lonlat.lon) == 0) { lonlat = map.getLonLatFromViewPortPx(e.xy) }
		$('#div-Add-POI').attr("title", dic("addPoi1", lang));
		$('#btnAddPOI').attr("value", dic("add", lang));
		$('#poiAvail').buttonset();
		$('#poiCant').buttonset();
		$('#AddGroup').button();
		var latLng = new google.maps.LatLng(lonlat.lat,lonlat.lon);
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
        $('#loadingAddress').css({ visibility: "hidden" });
		/*$.ajax({
		    url: "getGeocode.php?lon=" + lonlat.lon + "&lat=" + lonlat.lat,
		    context: document.body,
		    success: function (data) {
		        $('#poiAddress').val(data);
		        $('#loadingAddress').css({ visibility: "hidden" });
		        //HideWait();
		    }
		});*/
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
        $("#div-Add-POI").dialog({ modal: true, width: 430, zIndex: 9999, resizable: false });
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
function EditPOI(lon, lat, name, avail, ppgid, id, desc, num, canch, addinfo, radiusID) {
    hideCant(avail, 'poiCant');
    $('#poiAddress').val('');
    $('#loadingAddress').css({ visibility: "visible" });
    $('#div-Add-POI').attr("title", dic("EditPoi", lang));
    $('#btnAddPOI').attr("value", dic("Update", lang));
    $('#numPoi').val(num);
    if (desc == "") {
        var latLng = new google.maps.LatLng(lat,lon);

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
        $('#loadingAddress').css({ visibility: "hidden" });
        /*$.ajax({
            url: "getGeocode.php?lon=" + lon + "&lat=" + lat,
            context: document.body,
            success: function (data) {
                $('#poiAddress').val(data);
                //HideWait();
                $('#loadingAddress').css({ visibility: "hidden" });
            }
        });*/
    
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
    if (canch == "False" || canch == "0")
        $('#APcheck3').attr({ checked: 'checked' });
    else
        $('#APcheck3').attr({ checked: '' });
    $('#AddGroup').button();
    $('#poiAvail').buttonset();
    $('#poiCant').buttonset();
    if (canch == "False" || canch == "0") {
        document.getElementById("btnDeletePOI").setAttribute("onclick", "CantDeletePOI()");
        document.getElementById("btnAddPOI").setAttribute("onclick", "CantDeletePOI()");
    } else {
        document.getElementById("btnDeletePOI").setAttribute("onclick", "DeleteGroup()");
        document.getElementById("btnAddPOI").setAttribute("onclick", "ButtonAddEditPOIokClick()");
    }
    $('#btnDeletePOI').css({ display: 'block' });
    $('#btnDeletePOI').button();
    $('#btnAddPOI').button();
    $('#btnCancelPOI').button();
    $('#poiLat').val(lat);
    $('#poiLon').val(lon);
    $('#idPoi').val(id);
    $('#additionalInfo').val(addinfo);
    $('#poiName').val(name);
    $("#div-Add-POI").dialog({ modal: true, width: 430, zIndex: 9999, resizable: false });
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
function clearItem() {
    $("#clickAny").val("");
}
function ChangeIconsColor(_color) {
    for (var p = 0; p < 22; p++)
        document.getElementById("GroupIconImg" + p).src = 'http://gps.mk/new/pin/?color=' + _color + '&type=' + p;
    setTimeout('$("#tblIconsPOI").css({ visibility: "visible" }); $("#loadingIconsPOI").css({ visibility: "hidden" });', 1500);
}
function AddGroup(_tbl) {
    $('#GroupName').val('');
    $("#colorPicker1").css("background-color", "transparent");
    $("#GroupIcon0").attr({ checked: 'checked' });
    $("#clickAny").val('');
    for (var p = 0; p < 22; p++)
        document.getElementById("GroupIconImg" + p).src = 'http://gps.mk/new/pin/?color=ffffff&type=' + p;
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
            $.ajax({
                url: "AddGroupNew.php?groupName=" + String($('#GroupName').val()) + "&color=" + String($("#clickAny").val().substring(1, $("#clickAny").val().length)) + "&img=" + _img + "&l=" + lang,
                context: document.body,
                success: function (data) {
                    if (data.indexOf("Error") == -1) {
                        $('#div-Add-Group').dialog('destroy');
                        $('#loading1').css({ display: "none" });
                        
                        var _bgimg = 'http://gps.mk/new/pin/?color=' + $("#clickAny").val().substring(1, $("#clickAny").val().length) + '&type=' + data.split("@@%%")[2];
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
    $("#div-ver-DelGroup").dialog({ modal: true, width: 240, height: 155, zIndex: 9999, resizable: false });
}
function ButtonDeletePOIokClick() {
    $.ajax({
        url: "DeletePOI.php?id=" + $('#idPoi').val() + "&l=" + lang,
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
        for (var i = 1; i <= 2; i++)
            if (document.getElementById("APcheck" + i).checked) {
                avail = i;
                break;
            }

        var _radius = $(".dropdownRadius dt a")[0].title.substring($(".dropdownRadius dt a")[0].title.lastIndexOf("_")+1, $(".dropdownRadius dt a")[0].title.length);
        if ($('#btnAddPOI').val() == dic("Update", lang)) {
            $.ajax({
                url: "EditPoiNew.php?lat=" + $('#poiLat').val() + "&lon=" + $('#poiLon').val() + "&name=" + $('#poiName').val() + "&avail=" + avail + "&ppgid=" + _title + "&id=" + $('#idPoi').val() + "&description=" + $('#poiAddress').val() + "&cant=" + $('#APcheck3').attr('checked') + "&additional=" + $('#additionalInfo').val() + "&l=" + lang + "&radius=" + _radius,
                context: document.body,
                success: function (data) {
                    if (data.indexOf(dic("Error", lang)) == -1) {
                        var _bgimg = 'url("http://gps.mk/new/pin/?color=' + data.split("@@%%")[1] + '&type=' + data.split("@@%%")[2] + '")';
                        for (var i = 0; i < 4; i++)
                            if (Boards[i] != null) {
                            	if($('#numPoi').val() != -1){
                                	tmpMarkers[i][$('#numPoi').val()].events.element.children[0].style.backgroundImage = _bgimg;
                                	var _cant = $('#APcheck3').attr('checked') == true ? "False" : "True";
                                	tmpMarkers[i][$('#numPoi').val()].events.element.attributes[3].nodeValue = "EditPOI('" + $('#poiLon').val() + "', '" + $('#poiLat').val() + "', '" + $('#poiName').val() + "', '" + avail + "', '" + _title + "', '" + $('#idPoi').val() + "', '" + $('#poiAddress').val() + "', '" + $('#numPoi').val() + "', '" + _cant + "', '" + $('#additionalInfo').val() + "', '" + _radius + "')";
                                	tmpMarkers[i][$('#numPoi').val()].events.element.attributes[2].nodeValue = "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + $('#poiName').val() + "<br /></strong>" + dic("AddInfo", lang) + ": <strong style=\"font-size: 12px;\">" + $('#additionalInfo').val() + "</strong><br />" + dic("Group", lang) + ": <strong style=\"font-size: 12px;\">" + $(".dropdown dt a span")[0].textContent.substring(2, $(".dropdown dt a span")[0].textContent.length) + "</strong>')";
                               	}else
                               	{
                               		tmpSearchMarker.events.element.children[0].style.backgroundImage = _bgimg;
                                	var _cant = $('#APcheck3').attr('checked') == true ? "False" : "True";
                                	tmpSearchMarker.events.element.attributes[3].nodeValue = "EditPOI('" + $('#poiLon').val() + "', '" + $('#poiLat').val() + "', '" + $('#poiName').val() + "', '" + avail + "', '" + _title + "', '" + $('#idPoi').val() + "', '" + $('#poiAddress').val() + "', '" + $('#numPoi').val() + "', '" + _cant + "', '" + $('#additionalInfo').val() + "', '" + _radius + "')";
                                	tmpSearchMarker.events.element.attributes[2].nodeValue = "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + $('#poiName').val() + "<br /></strong>" + dic("AddInfo", lang) + ": <strong style=\"font-size: 12px;\">" + $('#additionalInfo').val() + "</strong><br />" + dic("Group", lang) + ": <strong style=\"font-size: 12px;\">" + $(".dropdown dt a span")[0].textContent.substring(2, $(".dropdown dt a span")[0].textContent.length) + "</strong>')";
                               	}
                            }
                        msgbox(data.split("@@%%")[3]);
                    } else
                        msgbox(data);
                    $('#div-Add-POI').dialog('destroy');
                    $('#loading').css({ display: "none" });
                    //HideWait();
                    //msgbox('')
                }
            });
        } else {
        	//alert("AddPoi.php?lat=" + $('#poiLat').val() + "&lon=" + $('#poiLon').val() + "&name=" + $('#poiName').val() + "&avail=" + avail + "&ppgid=" + _title + "&description=" + $('#poiAddress').val() + "&cant=" + $('#APcheck3').attr('checked') + "&additional=" + $('#additionalInfo').val() + "&l=" + lang + "&radius=" + _radius);
            $.ajax({
                url: "AddPoi.php?lat=" + $('#poiLat').val() + "&lon=" + $('#poiLon').val() + "&name=" + $('#poiName').val() + "&avail=" + avail + "&ppgid=" + _title + "&description=" + $('#poiAddress').val() + "&cant=" + $('#APcheck3').attr('checked') + "&additional=" + $('#additionalInfo').val() + "&l=" + lang + "&radius=" + _radius,
                context: document.body,
                success: function (data) {
                    if (data.indexOf("Error") == -1) {
                        msgbox(data.split("@@%%")[2]);
                        //if (ShowPOI == true) {
                        var _ppp = JXG.decompress(data.split("@@%%")[1]).split("|");
                        for (var z = 0; z < Maps.length; z++) {
                            if (Boards[z] != null) {
                                if (tmpMarkers[z] == undefined)
                                    tmpMarkers[z] = [];
                                var size = new OpenLayers.Size(16, 16);
                                var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
                                var icon = new OpenLayers.Icon('./blank.png', size, null, calculateOffset);

                                var ll = new OpenLayers.LonLat(parseFloat(_ppp[0]), parseFloat(_ppp[1])).transform(new OpenLayers.Projection("EPSG:4326"), Maps[z].getProjectionObject())
                                // GLOBSY MAPS
								//if (MapType[z] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_ppp[0]), parseFloat(_ppp[1])) }
                                var MyMar = new OpenLayers.Marker(ll, icon)
                                var markers = Markers[z];
                                markers.addMarker(MyMar);
                                MyMar.events.element.style.zIndex = 666
                                tmpMarkers[z][tmpMarkers[z].length] = MyMar;
                                if (_ppp[7] == "1")
                                    var _color = 'ff0000';
                                else
                                    var _color = _ppp[7];
                                var _bgimg = 'http://gps.mk/new/pin/?color=' + _color + '&type=' + _ppp[9];
                                tmpMarkers[z][tmpMarkers[z].length - 1].events.element.innerHTML = '<div style="background: transparent url(' + _bgimg + ') no-repeat; width: 24px; height: 24px; font-size:4px"></div>';
                                //tmpMarkers[tmpMarkers.length - 1].events.element.innerHTML = '<div class="gnPOI" style="background-color: ' + _color + '"; display:box; font-size:4px"></div>';
                                tmpMarkers[z][tmpMarkers[z].length - 1].events.element.style.cursor = 'pointer';
                                //tmpMarkers[tmpMarkers.length - 1].events.element.style.backgroundColor = '#' + _ppp[7];
                                tmpMarkers[z][tmpMarkers[z].length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + _ppp[2] + "<br /></strong>" + dic("AddInfo", lang) + ": <strong style=\"font-size: 12px;\">" + _ppp[11] + "</strong><br />" + dic("Group", lang) + ": <strong style=\"font-size: 12px;\">" + _ppp[8] + "</strong>')")
                                tmpMarkers[z][tmpMarkers[z].length - 1].events.element.setAttribute("onclick", "EditPOI('" + _ppp[0] + "', '" + _ppp[1] + "', '" + _ppp[2] + "', '" + _ppp[3] + "', '" + _ppp[4] + "', '" + _ppp[5] + "', '" + _ppp[6] + "', '" + (tmpMarkers[z].length - 1) + "', '" + _ppp[10] + "', '" + _ppp[11] + "', '" + _ppp[12] + "')");
                                //$(tmpMarkers[tmpMarkers.length-1].events.element).mousemove(function(event) {alert(j)});
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

function mapEvent(event) {
    //ResetTimers()
    resetScreen[SelectedBoard] = true;
    ResetTimersStep(SelectedBoard);
}

 var selectControl; 
 var selectedFeature = new Array();

 function EditPoly() {
     //SelectedBoard = parseInt(this.map.div.id.substring(this.map.div.id.length - 1, this.map.div.id.length), 10) - 1;
     //$('#popupSelSave-'+SelectedBoard).css({ display: 'block' });
     //$('#popupSelCancel-' + SelectedBoard).css({ display: 'block' });
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
     $("#div-ver-DelGeoF").dialog({ modal: true, width: 240, height: 140, zIndex: 9999, resizable: false });
 }
 function ButtonDeleteGFokClick() {
     ShowWait();
     $.ajax({
         url: "DeleteArea.php?id=" + selectedFeature[SelectedBoard].style.areaid,
         context: document.body,
         success: function (data) {
             for (var cz = 0; cz <= cntz; cz++) {
                 if (document.getElementById("zona_" + cz) != null)
                     if ($('#zona_' + cz)[0].attributes[1].nodeValue.indexOf(selectedFeature[SelectedBoard].style.areaid) != -1) {
                         var d = $('#zona_' + cz)[0].parentElement.parentElement;
                         var old = $('#zona_' + cz)[0].parentElement;
                         d.removeChild(old);
                         break;
                     }
             }
             for (var z = 0; z < Maps.length; z++) {
                 for (var k = 0; k < vectors[z].features.length; k++) {
                     if (vectors[z].features[k].style.name == selectedFeature[SelectedBoard].style.name) {
                         cancelFeature[z] = false;
                         controls[z].modify.deactivate();
                         if (document.getElementById("div-polygon-menu-" + z) != null)
                             removeEl(document.getElementById("div-polygon-menu-" + z).id);
                         ArrAreasPoly[z][k] = "";
                         ArrAreasId[z][k] = "";
                         vectors[z].features[k].destroy();
                         break;
                     }
                 }
             }
             HideWait();
             msgbox(dic("GFWSD", lang));
             //onFeatureUnselect('0');
             //selectedFeature[SelectedBoard].destroy();
         }
     });
 }
 function UpdateGeoFence() {
     hideCant(selectedFeature[SelectedBoard].style.available, 'gfCant');
     for (var i = 0; i < $("#gfGroup dd ul li").length; i++) {
         if ($("#gfGroup dd ul li a")[i].id == selectedFeature[SelectedBoard].style.GroupId) {
             var text = $($("#gfGroup dd ul li a")[i]).html();
             $("#gfGroup dt a")[0].title = selectedFeature[SelectedBoard].style.GroupId;
             $("#gfGroup dt a span").html(text);
             break;
         }
     }
     $('#GFcheck' + selectedFeature[SelectedBoard].style.available).attr({ checked: 'checked' });
     if (selectedFeature[SelectedBoard].style.CantChange == "False")
         $('#GFcheck3').attr({ checked: 'checked' });
     else
         $('#GFcheck3').attr({ checked: '' });
     $('#txt_zonename').val(selectedFeature[SelectedBoard].style.name);
     $('#txt_phones').val(selectedFeature[SelectedBoard].style.AlarmsH.split("^@@")[5]);
     $('#txt_emails').val(selectedFeature[SelectedBoard].style.AlarmsH.split("^@@")[4]);
     if (selectedFeature[SelectedBoard].style.AlarmsH.split("^@@")[0] == "1")
         $('#chk_1_in').attr({ checked: 'checked' });
     else
         $('#chk_1_in').attr({ checked: '' });
     if (selectedFeature[SelectedBoard].style.AlarmsH.split("^@@")[1] == "1")
         $('#chk_1_out').attr({ checked: 'checked' });
     else
         $('#chk_1_out').attr({ checked: '' });
     if (selectedFeature[SelectedBoard].style.AlarmsH.split("^@@")[2] == "1")
         $('#chk_2_in').attr({ checked: 'checked' });
     else
         $('#chk_2_in').attr({ checked: '' });
     if (selectedFeature[SelectedBoard].style.AlarmsH.split("^@@")[3] == "1")
         $('#chk_2_out').attr({ checked: 'checked' });
     else
         $('#chk_2_out').attr({ checked: '' });

     for (var i = 0; i < selectedFeature[SelectedBoard].style.AlarmsVeh.split("%%&").length - 1; i++) {
         if (selectedFeature[SelectedBoard].style.AlarmsVeh.split("%%&")[i].split("^@@")[1] == "1")
             $('#av_' + selectedFeature[SelectedBoard].style.AlarmsVeh.split("%%&")[i].split("^@@")[0]).attr({ checked: 'checked' });
         else
             $('#av_' + selectedFeature[SelectedBoard].style.AlarmsVeh.split("%%&")[i].split("^@@")[0]).attr({ checked: '' });
         if (selectedFeature[SelectedBoard].style.AlarmsVeh.split("%%&")[i].split("^@@")[2] == "1")
             $('#in_' + selectedFeature[SelectedBoard].style.AlarmsVeh.split("%%&")[i].split("^@@")[0]).attr({ checked: 'checked' });
         else
             $('#in_' + selectedFeature[SelectedBoard].style.AlarmsVeh.split("%%&")[i].split("^@@")[0]).attr({ checked: '' });
         if (selectedFeature[SelectedBoard].style.AlarmsVeh.split("%%&")[i].split("^@@")[3] == "1")
             $('#out_' + selectedFeature[SelectedBoard].style.AlarmsVeh.split("%%&")[i].split("^@@")[0]).attr({ checked: 'checked' });
         else
             $('#out_' + selectedFeature[SelectedBoard].style.AlarmsVeh.split("%%&")[i].split("^@@")[0]).attr({ checked: '' });
     }

     $('#txt_zonename').focus();
     //$('#txt_phones').val('');
     //$('#txt_emails').val('');
     $('#gfAvail').buttonset();
     $('#gfCant').buttonset();
     $('#AddGroup1').button();
     //controls[0].modify.deactivate();

     $('#div-enter-zone-name').attr("title", dic("updateGF", lang));
     $('#div-enter-zone-name').dialog({ modal: true, zIndex: 9999, width: 642, height: 570, resizable: false,
         buttons: 
         [
            {
                text: dic("Update", lang),
                click: function () {
                    if ($('#txt_zonename').val() == '') {
                        msgbox(dic("EnterGFName", lang));
                        return false
                    }
                    if ($('#gfGroup dt a')[0].title == '') {
                        msgbox(dic("SelectGroup", lang));
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
                                                    for (var i = 1; i <= 2; i++)
                                                        if (document.getElementById("GFcheck" + i).checked) {
                                                            avail = i;
                                                            break;
                                                        }
                                                    //var tboja = $("#gfGroup dt a span div")[0].style.backgroundImage;
                                                    var _col = $("#gfGroup dt a span div")[0].style.backgroundColor;
                                                    UpdateArea($('#txt_zonename').val(), strPoints, selectedFeature[SelectedBoard].style.areaid, avail, $('#GFcheck3').attr('checked'), $("#gfGroup dt a")[0].title, _col);
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
                        for (var i = 1; i <= 2; i++)
                            if (document.getElementById("GFcheck" + i).checked) {
                                avail = i;
                                break;
                            }
                        //var tboja = $("#gfGroup dt a span div")[0].style.backgroundImage;
                        var _col = $("#gfGroup dt a span div")[0].style.backgroundColor;
                        UpdateArea($('#txt_zonename').val(), strPoints, selectedFeature[SelectedBoard].style.areaid, avail, $('#GFcheck3').attr('checked'), $("#gfGroup dt a")[0].title, _col);
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
     });
 }
 function onFeatureSelect(feature) {
 	selectedFeature[SelectedBoard] = feature;
 	//onFeatureUnselect('0');
 	controls[0].modify.deactivate();
 	EditPoly();
     /*if (feature.geometry.id.indexOf("LineString") != -1) {
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
         if (feature.style.CantChange == "False") {
             var _onclickE = "CantDeleteGF()";
             var _onclickD = "CantDeleteGF()";
         }
         else {
             var _onclickE = "EditPoly()";
             var _onclickD = "DeleteGeoFence()";
         }
         var _html = "<div class=\"text7\" style=\"color: White\">" + dic("Name", lang) + ": <font class=\"text9\" style=\"color: White\">" + feature.style.name + "</font></div><br/>";
         _html += "<input type=\"button\" id=\"popupEdit-" + SelectedBoard + "\" style=\"padding: 3px; margin-right: 5px;\" onclick=\"" + _onclickE + "\" value=\"" + dic("Edit", lang) + "\" />";
         _html += "<input type=\"button\" id=\"popupDelete-" + SelectedBoard + "\" style=\"padding: 3px; margin-right: 5px;\" onclick=\"" + _onclickD + "\" value=\"" + dic("Delete", lang) + "\" />";
         _html += "<input type=\"button\" id=\"popupCancel-" + SelectedBoard + "\" style=\"padding: 3px;\" onclick=\"onFeatureUnselect('0')\" value=\"" + dic("cancel", lang) + "\" /><br />";

         _html += "<input type=\"button\" id=\"popupSelSave-" + SelectedBoard + "\" style=\"float: left; margin-right: 4px; padding: 0px; margin-top: 7px;\" onclick=\"UpdateGeoFence()\" value=\"" + dic("Save", lang) + "\" />";
         _html += "<input type=\"button\" id=\"popupSelCancel-" + SelectedBoard + "\" style=\"float: left; padding: 0px; margin-top: 7px;\" onclick=\"onFeatureUnselect('1')\" value=\"" + dic("cancel", lang) + "\" />";
         var _wid = Boards[SelectedBoard].clientWidth;
         var PolygonMenu = Create($(Boards[SelectedBoard]).children()[0], 'div', 'div-polygon-menu-' + SelectedBoard);
         //var _w = lang == 'en'? '140' : '175';

         $(PolygonMenu).css({ display: 'block', position: 'absolute', zIndex: '7999', backgroundColor: '#387cb0', color: '#fff', left: '50px', top: '135px', padding: '12px 15px 12px 15px', width: lang == 'en' ? '140' : '175' + 'px', cursor: 'pointer', textAlign: 'left' });
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

         $(PolygonMenu).css({ display: 'block', position: 'absolute', zIndex: '7999', backgroundColor: '#387cb0', color: '#fff', left: '50px', top: '135px', padding: '12px 15px 12px 15px', width: lang == 'en' ? '140' : '175' + 'px', cursor: 'pointer', textAlign: 'left' });
         PolygonMenu.className = 'corner15';

         PolygonMenu.innerHTML = '<div style="height:2px"></div>' + _html + '<div style="height:2px"></div>';

         //$('#popupEdit-' + SelectedBoard).button();
         //$('#popupDelete-' + SelectedBoard).button();
         $('#popupCancel-' + SelectedBoard).button();
         //$('#popupSelSave-' + SelectedBoard).button();
         //$('#popupSelCancel-' + SelectedBoard).button();
         //$('#popupSelSave-' + SelectedBoard).css({ display: 'none' });
         //$('#popupSelCancel-' + SelectedBoard).css({ display: 'none' });
     }*/
 }
 function onFeatureUnselect(_bool) {
     //document.getElementById("testText").value += "   |   " + 0;
     controls[0].modify.deactivate();
     if (document.getElementById("div-polygon-menu-" + 0) != null)
         removeEl(document.getElementById("div-polygon-menu-" + 0).id);
     if (_bool == "1") {
         onFeatureSelect(selectedFeature[0]);
     }
     if (cancelFeature[0]) {
         if (selectedFeature[0].style != null) {
             var _areaid = selectedFeature[0].style.areaid;
             var _col = selectedFeature[0].style.fillColor;
             selectedFeature[0].destroy();
             //PleaseDrawAreaAgainSB(_areaid, _col, 0);

             cancelFeature[0] = false;
         }
     }
 }
 
 function onFeatureModify(feature) {
     //if (selectedFeature[SelectedBoard] != undefined)
         //if (feature.id != selectedFeature[SelectedBoard].id) {
             controls[SelectedBoard].modify.deactivate();
             controls[SelectedBoard].modify.activate();
         //}
 }
 function onFeatureUnmodify(feature) {
     //if (selectedFeature[SelectedBoard] != undefined && selectedFeature[SelectedBoard] != "")
         //if (feature.id != selectedFeature[SelectedBoard].id) {
             controls[SelectedBoard].modify.deactivate();
             controls[SelectedBoard].modify.activate();
             controls[SelectedBoard].modify.selectControl.clickFeature(selectedFeature[SelectedBoard]);
         //}
 }
 function onFeatureStartModify(feature) {
     cancelFeature[SelectedBoard] = true;
 }

function DrawLine_OSM(osmid, _num) {
    $.ajax({
        url: "./getLonLat.php?osmid=" + osmid,
        context: document.body,
        success: function (data) {
            var dat = data.split("%^");
            var d = dat[0].substring(dat[0].indexOf(".")-2, dat[0].length-1).split(",");
            var _lonT = ""; var _latT = "";
            for(var i=0; i<d.length; i++)
            {
            	_lonT += d[i].split(" ")[0] + (i == (d.length-1) ? "" : ",");
            	_latT += d[i].split(" ")[1] + (i == (d.length-1) ? "" : ",");
            }

            $('#div-layer-wayname-'+_num).css({display: 'block'});
            $('#NameOfWay-'+_num).val(dat[1]);
            $('#HiddenIdOfWay-'+_num).val(osmid);
            //document.getElementById('nodelist').innerHTML = dat[1] + "   " + osmid;
            var _lon = new Array();
            var _lat = new Array();
            _lon = _lonT.split(",");
            _lat = _latT.split(",");
            var points = new Array();
            var styles = new Array();
            var debelina = 7;
            var opac = 0.5;
            
            for (var _j = 0; _j < _lon.length; _j++) {
                point = new OpenLayers.Geometry.Point(_lon[_j], _lat[_j]);
                point.transform(
			            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
			            Maps[_num].getProjectionObject() // to Spherical Mercator Projection
		            );
                styles.push({ 'strokeWidth': debelina, 'strokeColor': '#0000FF', 'strokeOpacity': opac });
                points.push(point);
                
            }
            for (var i = 0; i < points.length - 1; i++) {
                var lineString1 = new OpenLayers.Geometry.LineString([points[i], points[i + 1]]);
                var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, styles[i]);
                vectors[_num].addFeatures([lineFeature1]);
            }
        }
    });
}
function LoadMaps1() {
	map1 = new OpenLayers.Map({ div: Boards[1].id, allOverlays: true,
		eventListeners: {
			"zoomend": mapEvent
		}, maxExtent: new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34),
		maxResolution: 156543.0399,
		numZoomLevels: 19,
		units: 'm',
		projection: new OpenLayers.Projection("EPSG:900913"),
		displayProjection: new OpenLayers.Projection("EPSG:4326")
	});
	var layer1;
	//layer1 = new OpenLayers.Layer.WMS( "OpenLayers WMS", "http://192.168.2.51:8080/geoserver/wms", {'layers': 'geonet:Geonet_Roards'});
	//layer1 = new OpenLayers.Layer.OSM();
	//layer1 = layer = new OpenLayers.Layer.Google("Google Streets");
	layer1 = new OpenLayers.Layer.Google("Google Satellite", { type: google.maps.MapTypeId.SATELLITE })
	map1.addLayers([layer1]);
	
	//if (OpenForDrawing==true){   //CVETKOSKI
	var renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
	renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;
	vectors[1] = new OpenLayers.Layer.Vector("Vector Layer", {
		renderers: renderer
	});
	map1.addLayer(vectors[1]);
	
	map1.events.register('mouseup', map1, function (e) {
		var lonlat = map1.getCenter().transform(map1.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
		var lon = lonlat.lon;
		var lat = lonlat.lat;
		map2.setCenter(new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), map2.getProjectionObject()), 17);
	});
	
	map1.setCenter(new OpenLayers.LonLat(StartLon, StartLat).transform(new OpenLayers.Projection("EPSG:4326"), map1.getProjectionObject()), 17);
	$('.olControlAttribution').css({ display: 'none' });
	Maps[1] = map1;
}
function LoadMaps2() {
     map2 = new OpenLayers.Map({ div: Boards[2].id, allOverlays: true,
         eventListeners: {
             "zoomend": mapEvent,
             "click": function (e) { eventClick(e) }
         }, maxExtent: new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34),
         //maxResolution: 186543.0399, //za stari mapi
         maxResolution: 154543.0399, //za google
         numZoomLevels: 30,
         units: 'm',
         projection: new OpenLayers.Projection("EPSG:900913"),
         displayProjection: new OpenLayers.Projection("EPSG:4326")
     });
     var layer2;
	 layer2 = new OpenLayers.Layer.WMS( "OpenLayers WMS", "http://192.168.2.51:8080/geoserver/wms", {'layers': 'geonet:testMapa'});
	 //layer = new OpenLayers.Layer.Google("Google Streets");
     map2.addLayers([layer2]);

     //if (OpenForDrawing==true){   //CVETKOSKI
     var renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
     renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;
     vectors[2] = new OpenLayers.Layer.Vector("Vector Layer", {
         renderers: renderer
     });
     map2.addLayer(vectors[2]);
	OpenLayers.Feature.Vector.style['default'].strokeWidth = '10';
	//var lineLayer = new OpenLayers.Layer.Vector("Line Layer");
	controls[2] = {
		line: new OpenLayers.Control.DrawFeature(vectors[2], OpenLayers.Handler.Path)
	}
	for(var key in controls[2]) {
		map2.addControl(controls[2][key]);
		//controls[0][key].activate(0);
	}
	map2.events.register('mouseup', map2, function (e) {
		var lonlat = map2.getCenter().transform(map2.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
		var lon = lonlat.lon;
		var lat = lonlat.lat;
		map1.setCenter(new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), map1.getProjectionObject()), 17);
	});
	// support GetFeatureInfo
	map2.events.register('click', map2, function (e) {
		vectors[2].removeAllFeatures();
		var pixel = new OpenLayers.Pixel(e.xy.x, e.xy.y);
		var coord = map2.getLonLatFromPixel(pixel).transform(
		   new OpenLayers.Projection("EPSG:900913"),
		   new OpenLayers.Projection("EPSG:4326")
		);
		$.ajax({
        	url: "./getOSMID.php?lonlat=" + coord.lon + " " + coord.lat,
        	context: document.body,
        	success: function (data) {
				DrawLine_OSM(data, '2');
			}
		});
	});

	map2.setCenter(new OpenLayers.LonLat(StartLon, StartLat).transform(new OpenLayers.Projection("EPSG:4326"), map2.getProjectionObject()), 17);
    $('.olControlAttribution').css({ bottom: '7px', right: '', left: '3px' });
    $('.olControlPanZoom').css({ display: 'none' });
    Maps[2] = map2;
    AddLayerSwitcher(Boards[2], 2);
 }
 function LoadMaps() {
 	var format = 'image/png';
     map = new OpenLayers.Map({ div: Boards[0].id, allOverlays: true,
         eventListeners: {
             "zoomend": mapEvent,
             "click": function (e) { eventClick(e) }
         }, maxExtent: new OpenLayers.Bounds(-20037508.34, -20037508.34, 20037508.34, 20037508.34),
         maxResolution: 306543.0399, //za stari mapi
         //maxResolution: 154543.0399, //za google
         numZoomLevels: 30,
         units: 'm',
         projection: new OpenLayers.Projection("EPSG:900913"),
         displayProjection: new OpenLayers.Projection("EPSG:4326")
     });
     var layer;
	 layer = new OpenLayers.Layer.WMS( "OpenLayers WMS", "http://192.168.2.51:8080/geoserver/wms", {'layers': 'geonet:testMapa'});
	 //layer = new OpenLayers.Layer.Google("Google Streets");
     map.addLayers([layer]);

     //if (OpenForDrawing==true){   //CVETKOSKI
     var renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
     renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;
     vectors[0] = new OpenLayers.Layer.Vector("Vector Layer", {
         renderers: renderer
     });
     map.addLayer(vectors[0]);
	OpenLayers.Feature.Vector.style['default'].strokeWidth = '10';
	//var lineLayer = new OpenLayers.Layer.Vector("Line Layer");
	selectControl = new OpenLayers.Control.SelectFeature(vectors[0],
     {
         onSelect: onFeatureSelect,
         onUnselect: onFeatureUnselect
     });
	modifyControl = new OpenLayers.Control.ModifyFeature(vectors[0],
	 {
	     onModificationStart: onFeatureModify,
	     onModificationEnd: onFeatureUnmodify,
	     onModification: onFeatureStartModify
	 });
	controls[0] = {
		modify: modifyControl,
		line: new OpenLayers.Control.DrawFeature(vectors[0], OpenLayers.Handler.Path),
		select: selectControl // new OpenLayers.Control.SelectFeature(vectors[i])
	}
	
	for(var key in controls[0]) {
		map.addControl(controls[0][key]);
		//controls[0][key].activate(0);
	}
	controls[0].select.activate();
	// wire up the option button
	//var options = document.getElementById("options");
	//options.onclick = toggleControlPanel;

	map.events.register('mouseup', map, function (e) {
		var lonlat = map.getCenter().transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
		var lon = lonlat.lon;
		var lat = lonlat.lat;
		if(m != undefined)
		{
			m.LatCent = parseFloat(lat);
		    m.LonCent = parseFloat(lon);
			m.SetCenterLL(parseFloat(lon), parseFloat(lat));
		}else
		{
			map1.setCenter(new OpenLayers.LonLat(lon, lat).transform(new OpenLayers.Projection("EPSG:4326"), map1.getProjectionObject()), 17);
		}
		//m.LoadImages();
	});
	// support GetFeatureInfo
	map.events.register('click', map, function (e) {
		vectors[0].removeAllFeatures();
		//document.getElementById('nodelist').innerHTML = "Loading... please wait...";
		var pixel = new OpenLayers.Pixel(e.xy.x, e.xy.y);
		var coord = map.getLonLatFromPixel(pixel).transform(
		   new OpenLayers.Projection("EPSG:900913"),
		   new OpenLayers.Projection("EPSG:4326")
		);
		//alert("../getOSMID.php?lonlat=" + coord.lon + " " + coord.lat);
		$.ajax({
        	url: "./getOSMID.php?lonlat=" + coord.lon + " " + coord.lat,
        	context: document.body,
        	success: function (data) {
				DrawLine_OSM(data, '0');
			}
		});
		//alert("You clicked near " + coord.lat + " N, " + coord.lon + " E"); 
		/*
		var params = {
			REQUEST: "GetFeatureInfo",
			EXCEPTIONS: "application/vnd.ogc.se_xml",
			BBOX: map.getExtent().toBBOX(),
			SERVICE: "WMS",
			INFO_FORMAT: 'text/html',
			QUERY_LAYERS: map.layers[0].params.LAYERS,
			FEATURE_COUNT: 50,
			Layers: 'geonet:Geonet_Roards',
			WIDTH: map.size.w,
			HEIGHT: map.size.h,
			format: format,
			styles: map.layers[0].params.STYLES,
			srs: map.layers[0].params.SRS
		};
		
		// handle the wms 1.3 vs wms 1.1 madness
		if(map.layers[0].params.VERSION == "1.3.0") {
			params.version = "1.3.0";
			params.j = parseInt(e.xy.x);
			params.i = parseInt(e.xy.y);
		} else {
			params.version = "1.1.1";
			params.x = parseInt(e.xy.x);
			params.y = parseInt(e.xy.y);
		}
		// merge filters
		if(map.layers[0].params.CQL_FILTER != null) {
			params.cql_filter = map.layers[0].params.CQL_FILTER;
		}
		if(map.layers[0].params.FILTER != null) {
			params.filter = map.layers[0].params.FILTER;
		}
		if(map.layers[0].params.FEATUREID) {
			params.featureid = map.layers[0].params.FEATUREID;
		}
		//OpenLayers.loadURL("http://192.168.2.51:8080/geoserver/geonet/wms", params, this, setHTML, setHTML);
		OpenLayers.loadURL("test2.php", params, this, setHTML, setHTML);*/
		
		OpenLayers.Event.stop(e);
	});
	
	// sets the HTML provided into the nodelist element
	function setHTML(response){
		//document.getElementById('nodelist').innerHTML = response.responseText;
		var osm_id = response.responseText.substring(response.responseText.indexOf("<td>Geonet_Roards")+4, response.responseText.length);
		osm_id = osm_id.substring(osm_id.indexOf("<td>")+4, osm_id.length);
		osm_id = osm_id.substring(0, osm_id.indexOf("</td>"));
		DrawLine_OSM(osm_id);
	}; 

	map.setCenter(new OpenLayers.LonLat(StartLon, StartLat).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject()), 17);
    $('.olControlAttribution').css({ display: 'none', bottom: '7px', right: '', left: '3px' });
    $('.olControlPanZoom').css({ display: 'none' });
    Maps[0] = map;
    AddLayerSwitcher(Boards[0], 0);
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
        $('#outputMeasure-' + num).html(dic("Measure", lang) +": 0.000 km");
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

function ClearGraphic() {
    for (var z = 0; z < Maps.length; z++) {
        if (vectors[z] != null) {
            vectors[z].removeAllFeatures();
            if (ArrAreasCheck[z] != undefined) {
                for (var i = 0; i < ArrAreasCheck[z].length; i++)
                    if (ArrAreasCheck[z][i] == 1)
                        vectors[z].addFeatures([ArrAreasPoly[z][i]]);
            }
        }
    }
    if (ArrLineFeature != undefined && ArrLineFeature != '')
        vectors[0].addFeatures(ArrLineFeature);
}
function DrawPolygon(LonArray, LatArray, movemap, _color, _name, _areaid, _avail, _cant, _gfgid, _alarmsH, _alarmsVeh) {
    if (movemap == null) { movemap = true }
    
    site_style = { 'strokeWidth': 1, 'strokeColor': '#FF0000', 'fillOpacity': 0.5, 'fillColor': _color, 'name': _name, 'areaid': _areaid, 'available': _avail, 'CantChange': _cant, 'GroupId': _gfgid, 'AlarmsH': _alarmsH, 'AlarmsVeh': _alarmsVeh }
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

	    if (movemap == true) { setCenterMap(_lon[0], _lat[0], 15, z) }
	}
    return polygonFeature

}
function DrawPolygonSB(LonArray, LatArray, movemap, _color, _name, _areaid, _avail, _cant, _gfgid, _alarmsH, _alarmsVeh, _sb) {
    if (movemap == null) { movemap = true }

    site_style = { 'strokeWidth': 1, 'strokeColor': '#FF0000', 'fillOpacity': 0.5, 'fillColor': _color, 'name': _name, 'areaid': _areaid, 'available': _avail, 'CantChange': _cant, 'GroupId': _gfgid, 'AlarmsH': _alarmsH, 'AlarmsVeh': _alarmsVeh }
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
    if (PathPerVeh[vhID] == undefined || PathPerVeh[vhID] == "") {
        PathPerVeh[vhID] = [];
        //ShowWait();
        get10Points(vhID, VehReg);
    } else {
        var _lon = LonArray.split(",")
        var _lat = LatArray.split(",")

        var points = new Array();
        var styles = new Array();

        var cir = _lon.length / 3
        var cir1 = cir + cir
        var cir2 = _lon.length

        var debelina = 3;
        var opac = 0.7;

        for (i in _lon) {

            point = new OpenLayers.Geometry.Point(_lon[i], _lat[i]);
            point.transform(
				new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
				Maps[_j].getProjectionObject() // to Spherical Mercator Projection
			  );
            styles.push({ 'strokeWidth': debelina, 'strokeColor': '#0000FF', 'strokeOpacity': opac, 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg })
            points.push(point)
            //debelina = debelina - 0.5
            //opac = opac - 0.05

        }
        LastPointsLon[vhID] = _lon[1]
        LastPointsLat[vhID] = _lat[1]

        for (var i = 0; i < _lon.length - 1; i++) {
            var lineString1 = new OpenLayers.Geometry.LineString([points[i], points[i + 1]]);
            var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, styles[i]);
            PathPerVeh[vhID][PathPerVeh[vhID].length] = lineFeature1;
            vectors[_j].addFeatures([lineFeature1]);
            lineFeature1.layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>" + dic("RouteForV", lang) + "<br /></strong>'+event.target._style.VehID)}");
            lineFeature1.layer.events.element.setAttribute("onmouseout", "HidePopup()");
        }
        //document.getElementById("testText").value = (PathPerVeh[vhID].length / 25);
        if ((PathPerVeh[vhID].length / 25) > 10) {
            for (var i = 0; i < 25; i++) {
                vectors[_j].removeFeatures(PathPerVeh[vhID][i]);
                PathPerVeh[vhID][i] = "";
            }
            PathPerVeh[vhID] = PathPerVeh[vhID].splice(25, PathPerVeh[vhID].length);
        }
        //if (true)
        //    get10Points();
        return
    }
}

function get10Points(vhID, VehReg) {
    $.ajax({
        url: "getVehPath.php?numofveh=" + vhID,
        context: document.body,
        success: function (data) {
            //ClearGraphic();
            var d = JXG.decompress(data).split("#");
            DrawPath(d[1], d[0], vhID, VehReg);
            HideWait();
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
        LastPointsLon[vhID] = _lon[1];
	    LastPointsLat[vhID] = _lat[1];
	    
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

	        lineFeature1.layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>" + dic("RouteForV", lang) + "<br /></strong>'+event.target._style.VehID)}");
	        lineFeature1.layer.events.element.setAttribute("onmouseout", "HidePopup()");
	    }
	}
	
	return
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

var ArrLineFeature;
function DrawPath_Rec(LonArray, LatArray, vhID, VehReg) {
    
    //if (ShowHideTrajectory == false) { return }
    var _lon = LonArray.split(",")
    var _lat = LatArray.split(",")

    var points = new Array();
    var styles = {'strokeWidth': '2', 'strokeColor': '#0000FF', 'strokeOpacity': '0.8', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg };

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

    var debelina = 3
    var opac = 0.7

    for (i in _lon) {
        if (i > 0 && i < _lon.length - 2) {

            point = new OpenLayers.Geometry.Point(_lon[i], _lat[i]);
            point.transform(
				new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
				Maps[0].getProjectionObject() // to Spherical Mercator Projection
			  );
            points.push(point);
        }
    }

    var lineString1 = new OpenLayers.Geometry.LineString(points);
    var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, styles)
	
    vectors[0].addFeatures([lineFeature1]);
	//vectors[0].setZIndex( 23 );
    ArrLineFeature = lineFeature1;
    return
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
    $(btnListOfRoutes).html('<img id="imgRoutesLoading-0" src="../images/ajax-loader.gif" style="display: block; position: relative; cursor: pointer; z-index: 8000; left: 130px; width: 17px;">');
    $.ajax({
        url: "../routes/LoadAllRoute.aspx?day=" + todayNew,
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
    $(AddRoutesBtn).mousemove(function (event) { ShowPopup(event, dic("SelectRoute", lang)) });
    $(AddRoutesBtn).mouseout(function () { HidePopup() });
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
    $(AddRulerBtn).mousemove(function (event) { ShowPopup(event, dic("RulerMeasure", lang)) });
    $(AddRulerBtn).mouseout(function () { HidePopup() });
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
    $(aSearch1).mousemove(function (event) { ShowPopup(event, dic("searchStreetsByName", lang)) });
    $(aSearch1).mouseout(function() {HidePopup()});
    
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
    $(aSearch2).mousemove(function (event) { ShowPopup(event, dic("search", lang) + " " + dic("Pois", lang)) });
    $(aSearch2).mouseout(function() {HidePopup()});
    
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
    $(imgSearch).attr("src", "../images/ajax-loader.gif");
    $(imgSearch).css({ display: 'none', position: 'absolute', cursor: 'pointer', zIndex: '8000', left: '199px', top: '30px', width: '17px' });

    var imgSearch = Create(AddSearchBtns, 'img', 'imgSearch-' + num);
    $(imgSearch).attr("src", "../images/zoom.png");
    $(imgSearch).css({ position: 'absolute', cursor: 'pointer', display: 'none', zIndex: '8000', left: '219px', top: '29px', width: '23px' });
    $(imgSearch)[0].setAttribute("onclick", "searchItems11('textSearch-'+" + num + ", " + num + ")");

    var btnSearch = Create(layerSearchButton, 'div', 'outputSearch-' + num);
    $(btnSearch).css({ display: 'none', position: 'absolute', zIndex: '8000', borderTop: '1px Solid', maxHeight: (window.innerHeight - 165) + 'px', overflowY: 'auto', backgroundColor: '#387cb0', top: '71px', color: '#fff', padding: '10px', paddingBottom: '20px', width: '228px', height: 'auto', textAlign: 'left' })
    btnSearch.className = 'cornerS text3';

    $(AddSearchBtn).click(function (event) { SearchName(num, 0) });
    $(AddSearchBtn).mousemove(function (event) { ShowPopup(event, dic("searchByName", lang)) });
    $(AddSearchBtn).mouseout(function () { HidePopup() });

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
        }
        $('#div-addSearch-' + num)[0].textContent = dic("cancel", lang);
        $('#div-addSearch-' + num)[0].className = 'cornerAdd text3';
        $('#div-addSearch-' + num)[0].style.borderBottom = '1px Solid White';
        $('#textSearch-' + num).val('');
        $('#div-addSearchNew-' + num).css({ display: 'block' });
        $('#textSearch-' + num).focus();
    } else {
        if (_c != 1) {
            if (tmpMarkerStreet != undefined) {
                Markers[num].removeMarker(tmpMarkerStreet);
            }
            if (tmpSearchMarker != undefined) {
		        Markers[num].removeMarker(tmpSearchMarker);
		    }
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
	$(layerListF).css({ display: 'block', position: 'absolute', zIndex: '7999', backgroundColor: '#e2ecfa', border: '1px solid #1a6ea5', color: '#fff', padding: '2px 5px 2px 5px', width: '150px', height: '150px', cursor: 'pointer', textAlign: 'center', overflowX: 'hidden', overflowY: 'scroll', display: 'none' })
	var str = '<label class="menu_vehicle">&nbsp;<input onChange="VehicleFListClick(' + num + ', 0)" id="f-vehicle-' + num + '-0" type="checkbox" />&nbsp;' + dic("allVehicles", lang) + '</label>'
	for (var i = 0; i < VehicleList.length; i++) {
	    var ch = getCheckVehicle(num, VehicleListID[i])
	    var chs = ''
	    if (ch == true) { chs = ' checked="true" ' }
	    str = str + '<label class="menu_vehicle">&nbsp;<input onChange="VehicleFListClick(' + num + ', ' + VehicleListID[i] + ')" id="f-vehicle-' + num + '-' + VehicleListID[i] + '" type="checkbox" />&nbsp;' + VehicleList[i] + '</label>';
	}
    layerListF.innerHTML = str;  //'<div style="height:10px"></div><div id="layer-1-'+num+'" onclick="SelectMapLayer('+num+', 1)" class="menu_layer">&nbsp;&nbsp;Google Maps</div><div id="layer-2-'+num+'" onclick="SelectMapLayer('+num+', 2)" class="menu_layer">&nbsp;&nbsp;Open Street Maps</div><div id="layer-3-'+num+'" onclick="SelectMapLayer('+num+', 3)" class="menu_layer">&nbsp;&nbsp;Bing Maps</div><div id="layer-4-'+num+'" onclick="SelectMapLayer('+num+', 4)" class="menu_layer">&nbsp;&nbsp;Yahoo Maps</div>'
	$(VehcileToFollow).click(function (event) { ShowHideVehicleFList(num) });
	$(VehcileToFollow).mousemove(function (event) { ShowPopup(event, dic("ListVehicles", lang) + '<br /><font style=\"font-size: 8px\">*' + dic("FollowVehicles", lang) + '</font>') });
	$(VehcileToFollow).mouseout(function () { HidePopup() });
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
    $(layerList).css({ display: 'block', position: 'absolute', zIndex: '7999', backgroundColor: '#e2ecfa', border: '1px solid #1a6ea5', color: '#fff', padding: '2px 5px 2px 5px', width: '150px', height: '150px', cursor: 'pointer', textAlign: 'center', overflowX: 'hidden', overflowY: 'scroll', display: 'none' })
    var str = '<label class="menu_vehicle">&nbsp;<input onChange="VehicleListClick(' + num + ', 0)" id="cb-vehicle-' + num + '-0" type="checkbox" checked="true" />&nbsp;' + dic("allVehicles", lang) + '</label>'
    for (var i = 0; i < VehicleList.length; i++) {
        var ch = getCheckVehicle(num, VehicleListID[i])
        var chs = ''
        if (ch == true) { chs = ' checked="true" ' }
        str = str + '<label class="menu_vehicle">&nbsp;<input onChange="VehicleListClick(' + num + ', ' + VehicleListID[i] + ')" id="cb-vehicle-' + num + '-' + VehicleListID[i] + '" type="checkbox" ' + chs + ' />&nbsp;' + VehicleList[i] + '</label>'
    }
    layerList.innerHTML = str //'<div style="height:10px"></div><div id="layer-1-'+num+'" onclick="SelectMapLayer('+num+', 1)" class="menu_layer">&nbsp;&nbsp;Google Maps</div><div id="layer-2-'+num+'" onclick="SelectMapLayer('+num+', 2)" class="menu_layer">&nbsp;&nbsp;Open Street Maps</div><div id="layer-3-'+num+'" onclick="SelectMapLayer('+num+', 3)" class="menu_layer">&nbsp;&nbsp;Bing Maps</div><div id="layer-4-'+num+'" onclick="SelectMapLayer('+num+', 4)" class="menu_layer">&nbsp;&nbsp;Yahoo Maps</div>'
    $(VehcileChooser).click(function (event) { ShowHideVehicleList(num) });
    $(VehcileChooser).mousemove(function (event) { ShowPopup(event, dic("ListVehicles", lang) + '<br /><font style=\"font-size: 8px\">*' + dic("ChooseVehicles", lang) + '</font>') });
    $(VehcileChooser).mouseout(function () { HidePopup() });
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
function VehicleFListClick(num, vID) {
    if (vID == 0) {
        if (document.getElementById('f-vehicle-' + num + '-0').checked) {
            document.getElementById('div-vehicle-tofollow-' + num).style.color = '#14D61A';
            FollowAllVehicles[SelectedBoard] = true;
            for (var i = 0; i < VehicleListID.length; i++)
                if (!$('#f-vehicle-' + num + '-' + VehicleListID[i]).attr('disabled'))
                    $('#f-vehicle-' + num + '-' + VehicleListID[i]).attr({ checked: true });
            zoomWorldScreen(Maps[SelectedBoard], Maps[SelectedBoard].zoom);
        } else {
            document.getElementById('div-vehicle-tofollow-' + num).style.color = '#FFFFFF';
            FollowAllVehicles[SelectedBoard] = false;
            for (var i = 0; i < VehicleListID.length; i++)
                $('#f-vehicle-' + num + '-' + VehicleListID[i]).attr({ checked: false });
        }
    } else {
        if (document.getElementById('f-vehicle-' + num + '-' + vID).checked) {
            document.getElementById('div-vehicle-tofollow-' + num).style.color = '#14D61A';
            var ll = Maps[SelectedBoard].getCenter().transform(new OpenLayers.Projection("EPSG:4326"), Maps[SelectedBoard].getProjectionObject());
            for (var i = 0; i < Vehicles.length; i++)
                if (Vehicles[i].ID == vID) {
                    setCenterMap(Vehicles[i].Lon, Vehicles[i].Lat, 16, SelectedBoard);
                    break;
                }
        } else {
            var _b = true;
            for (var i = 0; i < VehicleListID.length; i++)
                if (document.getElementById('f-vehicle-' + num + '-' + VehicleListID[i]).checked) {
                    _b = false;
                    break;
                }
            if (_b)
                document.getElementById('div-vehicle-tofollow-' + num).style.color = '#FFFFFF';
        }
    }
}
function VehicleListClick(num, vID) {
	if (vID==0){
	    for (var i = 0; i < VehicleListID.length; i++) {
	        if (!$('#cb-vehicle-' + num + '-' + VehicleListID[i]).attr('disabled')) {
	            document.getElementById('cb-vehicle-' + num + '-' + VehicleListID[i]).checked = document.getElementById('cb-vehicle-' + num + '-0').checked;
	            VehicleListClick(num, VehicleListID[i]);
	        }
	    }
	} else {
		for (var j=0; j<Car.length;j++){
				if (Car[j].id==vID+''){
					if (num==0) {
						Car[j].map0=document.getElementById('cb-vehicle-'+num+'-'+vID).checked
						for (var v=0; v<Vehicles.length; v++){
							if ((Vehicles[v].ID==Car[j].id) && (Vehicles[v].Map==0)){Vehicles[v].Marker.display(Car[j].map0)}
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
            ShowPoiGroup("getGroup.php", "div-GFUp", "div-GF", "div-gfimg", 2, 1, ShowHideZone, "490");
            HidePopup();
        });

        $(layerGF).mousemove(function (event) { ShowPopup(event, dic("showGeoFence", lang)) });
        $(layerGF1).mousemove(function (event) { ShowPopup(event, dic("chooseGroupGF", lang)) });
        $(layerGF).mouseout(function () { HidePopup() });
        $(layerGF1).mouseout(function () { HidePopup() });

    }
}

function ShowPOIButton(el, num) {
    if (ShowPOIBtn) {
        var h = el.offsetHeight - 10

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
            ShowPoiGroup("getGroup.php", "div-poiGUp", "div-poiG", "div-poiimg", 3, 1, ShowPOI, "360");
            HidePopup();
        });


        $(layerPOI).mousemove(function (event) { ShowPopup(event, dic("showPoi", lang)) });
        $(layerPOI1).mousemove(function (event) { ShowPopup(event, dic("chooseGroupPoi", lang)) });
        $(layerPOI).mouseout(function () { HidePopup() });
        $(layerPOI1).mouseout(function () { HidePopup() });
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
    $(layerList).css({ display: 'none', position: 'absolute', zIndex: '7999', backgroundColor: '#387cb0', color: '#fff', top: '19px', padding: '2px 5px 2px 5px', width: '117px', cursor: 'pointer', textAlign: 'left' });
    layerList.className = 'cornerAdd1 text3';
    var strList = '';
    strList = strList + '<div id="add-1-' + num + '" onclick="StartDrawingNewArea(' + num + ', 1)" style="" class="menuAdd_layer">&nbsp;&nbsp;' + dic("GeoFence", lang) + '</div>';
    strList = strList + '<div id="save1-button-' + num + '" onclick="SaveNewArea(' + num + ', 1)" style="margin: -2px 2px 2px 0px; padding: 2px 12px 2px 5px;" class="menuAdd_layer1">&nbsp;&nbsp;' + dic("Save", lang) + '</div>';
    strList = strList + '<div id="separator-button-' + num + '" style="width: 1px; top: -1px; left: -1px;" class="menuAdd_layer1"><strong>|</strong></div>';
    strList = strList + '<div id="cancel1-button-' + num + '" onclick="CancelDrawingArea(' + num + ', 1)" style="margin: -2px 2px 2px 2px; padding: 2px 10px 2px 2px;" class="menuAdd_layer1">&nbsp;&nbsp;' + dic("cancel", lang) + '</div>';
    if (AllowAddPoi == "true" || AllowAddPoi == "1") {
        strList = strList + '<div id="add-2-' + num + '" onclick="" style="margin-bottom: 7px;" class="menuAdd_layer">&nbsp;&nbsp;' + dic("Poi", lang) + '</div>';
    }
    layerList.innerHTML = '<div style="height:2px"></div>' + strList + '<div style="height:2px"></div>';
    $(btnAddArea).click(function (event) { ShowAddList(num) });
    $('#add-2-' + num).click(function (event) { ButtonAddPOIClick(event, num) });

    $(btnAddArea).mousemove(function (event) { ShowPopup(event, '' + dic("AddGFPoi", lang) + '') });
    $(btnAddArea).mouseout(function () { HidePopup() });
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
    _temp1.innerHTML = dic("5dinara", lang);
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
    $('#GFcheck2').attr({ checked: 'checked' });
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
    $('#gfCant').buttonset();
    $('#AddGroup1').button();
    $("#gfGroup dt a")[0].title = "";
    $("#gfGroup dt a span").html(dic("selGroup", lang));
    $('#txt_zonename').focus();
    controls[num].modify.deactivate();
    $('#div-enter-zone-name').attr("title", dic("AddGF", lang));
    $('#div-enter-zone-name').dialog({ modal: true, zIndex: 9999, width: 642, height: 570, resizable: false,
        buttons:
            [
                {
                    text: dic("Save", lang),
                    click: function () {
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
                                                        SavingNewArea(strPoints);
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
                            
                            SavingNewArea(strPoints);
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
function DrawStreet()
{
	if($('#div-map').css('zIndex') == '20')
		_num = "0";
	else
		_num = "2";
	$('#NameOfWayNew-'+_num).val('');
	if(_num == "0")
	{
		if(controls[0]["line"].active)
		{
			$('#div-layer-newway-'+_num).css({display: 'none'});
			controls[0]["line"].deactivate();
			$('#lineToggleImg').attr("src", "./images/street.png");
			vectors[_num].removeAllFeatures();
		}else
		{
			LayerWayNameOff('div-layer-wayname-'+_num, _num);
			$('#div-layer-newway-'+_num).css({display: 'block'});
			controls[0]["line"].activate();
			$('#lineToggleImg').attr("src", "./images/street1.png");
		}
	} else
	{
		if(controls[2]["line"].active)
		{
			$('#div-layer-newway-'+_num).css({display: 'none'});
			controls[2]["line"].deactivate();
			$('#lineToggleImg').attr("src", "./images/street.png");
			vectors[_num].removeAllFeatures();
		}else
		{
			LayerWayNameOff('div-layer-wayname-'+_num, _num);
			$('#div-layer-newway-'+_num).css({display: 'block'});
			controls[2]["line"].activate();
			$('#lineToggleImg').attr("src", "./images/street1.png");
		}
	}
}
function changeOpacity(_id){
	if($('#div-map').css('zIndex') == '20'){
		if($('#'+_id).css('opacity') == '1')
		{
			$('#'+_id).css({opacity: '0.7'});
			$('#div-map-1').css({opacity: '0.7'});
		}else
		{
			$('#'+_id).css({opacity: '1'});
			$('#div-map-1').css({opacity: '1'});
		}
	} else {
		if($('#'+_id).css('opacity') == '1')
		{
			$('#'+_id).css({opacity: '0.7'});
			$('#div-map-3').css({opacity: '0.7'});
		}else
		{
			$('#'+_id).css({opacity: '1'});
			$('#div-map-3').css({opacity: '1'});
		}
	}
}
function changeZindex(){
	if($('#div-map').css('zIndex') == '20' || $('#div-map').css('zIndex') == '14')
	{
		if($('#div-map').css('zIndex') == '20')
			$('#div-map').css({zIndex: '14'});
		else
			$('#div-map').css({zIndex: '20'});
	}else
	{
		if($('#div-map2').css('zIndex') == '20')
			$('#div-map2').css({zIndex: '14'});
		else
			$('#div-map2').css({zIndex: '20'});
	}
}
function changeBackground(){
	$('#changeOpacity').css({opacity: '1'});
	$('#div-map-1').css({opacity: '1'});
	$('#div-map-3').css({opacity: '1'});
	controls[0]["line"].deactivate();
	controls[2]["line"].deactivate();
	$('#div-layer-newway-0').css({display: 'none'});
	$('#div-layer-newway-2').css({display: 'none'});
	$('#div-layer-wayname-0').css({display: 'none'});
	$('#div-layer-wayname-2').css({display: 'none'});
	vectors[0].removeAllFeatures();
	vectors[2].removeAllFeatures();
	$('#lineToggleImg').attr("src", "./images/street.png");
	if($('#div-map').css('zIndex') == '20')
	{
		$('#div-map').css({zIndex: '10'});
		$('#div-map2').css({zIndex: '20'});
		$('#div-map1').css({zIndex: '16'});
	}else
	{
		$('#div-map').css({zIndex: '20'});
		$('#div-map2').css({zIndex: '10'});
		$('#div-map1').css({zIndex: '5'});
	}
}

function AddLayerSwitcher(el, num) {

    if (parseInt(el.offsetWidth, 10) < 550)
        var _w = parseInt(el.offsetWidth, 10) - 50;
    else
        if (ShowGFBtn)
            var _w = 650;
        else
            var _w = 550;
    var layerSwitcher = Create($(el).children()[0], 'div', 'div-layer-icons-' + num);
    $(layerSwitcher).css({ display: 'block', position: 'absolute', zIndex: '8000', backgroundColor: 'transparent', color: '#fff', left: '35px', top: '10px', width: _w + 'px', height: 'auto', textAlign: 'left' });
    layerSwitcher.className = 'corner15 text3';

    AddWayName(layerSwitcher, num);
    AddNewWay(layerSwitcher, num);
    /*AddNewButton(layerSwitcher, num);
    AddRuler(layerSwitcher, num);
    AddSearchButton(layerSwitcher, num);
    AddVehicleToFollow(layerSwitcher, num);
    AddVehicleChooser(layerSwitcher, num);
    ShowPOIButton(layerSwitcher, num);
    ShowGFButton(layerSwitcher, num);*/
}
function AddWayName(el, num) {

    var layerWayname = Create(el, 'div', 'div-layer-wayname-' + num);
    $(layerWayname).css({ position: 'relative', display: 'none', float: 'left', left: '20px', zIndex: '8010', width: '120px', height: '25px' });
    layerWayname.className = 'corner15 text3';

    var h = el.offsetHeight - 10
    //alert($(el).children()[0].id)

    var layerWayname1 = Create(layerWayname, 'div', 'div-layer-wayname1-' + num);

    $(layerWayname1).css({ display: 'block', position: 'absolute', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 15px', width: '600px', height: '90px', cursor: 'pointer', textAlign: 'left' })
    layerWayname1.className = 'corner15 text3';
    var _html = "<div class=\"text7\" style=\"color: White; margin-left: 2px;\">" + dic("Name", lang) + ": </div>";
    _html += "<input type=\"text\" id=\"NameOfWay-" + num + "\" style=\"float: left; width: 585px; font-size: 15px; margin-right: 4px; padding: 0px; margin-top: 6px;\" class=\"text9\" value=\"\" />";
 	_html += "<input type=\"hidden\" id=\"HiddenIdOfWay-" + num + "\" class=\"text9\" value=\"\" />";
 	_html += "<input type=\"button\" id=\"popupSelSave-" + num + "\" style=\"float: left; font-size: 15px; margin-right: 4px; padding: 0px; margin-top: 7px;\" onclick=\"LayerWayNameSave('" + num + "')\" value=\"" + dic("Save", lang) + "\" />";
    _html += "<input type=\"button\" id=\"popupSelDelete-" + num + "\" style=\"float: left; font-size: 15px; padding: 0px; margin-top: 7px;\" onclick=\"DeleteStreet('" + num + "')\" value=\"" + dic("Delete", lang) + "\" />";
    _html += "<input type=\"button\" id=\"popupSelCancel-" + num + "\" style=\"float: left; font-size: 15px; padding: 0px; margin-top: 7px;\" onclick=\"LayerWayNameOff('div-layer-wayname-" + num + "', '" + num + "')\" value=\"" + dic("cancel", lang) + "\" />";

	$('#div-layer-wayname1-'+num).html('<div style="height:2px"></div>' + _html + '<div style="height:2px"></div>');
	$('#popupSelSave-'+num).button();
	$('#popupSelDelete-'+num).button();
	$('#popupSelCancel-'+num).button();
}
function AddNewWay(el, num) {

    var layerWayname = Create(el, 'div', 'div-layer-newway-'+num);
    $(layerWayname).css({ position: 'relative', display: 'none', float: 'left', left: '20px', zIndex: '8010', width: '120px', height: '25px' });
    layerWayname.className = 'corner15 text3';

    var h = el.offsetHeight - 10
    //alert($(el).children()[0].id)

    var layerWayname1 = Create(layerWayname, 'div', 'div-layer-newway1-'+num);

    $(layerWayname1).css({ display: 'block', position: 'absolute', zIndex: '8000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 15px', width: '600px', height: '90px', cursor: 'pointer', textAlign: 'left' })
    layerWayname1.className = 'corner15 text3';
    var _html = "<div class=\"text7\" style=\"color: White; margin-left: 2px;\">" + dic("Name", lang) + " на нов пат: </div>";
    _html += "<input type=\"text\" id=\"NameOfWayNew-" + num + "\" style=\"float: left; width: 585px; font-size: 15px; margin-right: 4px; padding: 0px; margin-top: 6px;\" class=\"text9\" value=\"\" />";
 	_html += "<input type=\"button\" id=\"popupSelSaveNew-" + num + "\" style=\"float: left; font-size: 15px; margin-right: 4px; padding: 0px; margin-top: 7px;\" onclick=\"LayerNewWaySave('" + num + "')\" value=\"" + dic("Save", lang) + "\" />";
    _html += "<input type=\"button\" id=\"popupSelCancelNew-" + num + "\" style=\"float: left; font-size: 15px; padding: 0px; margin-top: 7px;\" onclick=\"LayerWayNameOff('div-layer-newway-" + num + "', '" + num + "')\" value=\"" + dic("cancel", lang) + "\" />";

	$('#div-layer-newway1-'+num).html('<div style="height:2px"></div>' + _html + '<div style="height:2px"></div>');
	$('#popupSelSaveNew-'+num).button();
	$('#popupSelCancelNew-'+num).button();
}
function DeleteStreet() {
    $('#btnCancelDelWay').button();
    $('#btnYesDelWay').button();
    $("#div-Way").dialog({ modal: true, width: 240, height: 155, zIndex: 9999, resizable: false });
}
function DeleteWay()
{
	if($('#div-map').css('zIndex') == '20')
		_num = "0";
	else
		_num = "2";
	$.ajax({
        url: "DeleteWay.php?osmid=" + $('#HiddenIdOfWay-'+_num).val() + "&name=" + $('#NameOfWay-'+_num).val(),
        context: document.body,
        success: function (data) {
            alert(data);
            $('#div-layer-newway-'+_num).css({display: 'none'});
            vectors[_num].removeAllFeatures();
        }
    });
}
function LayerNewWaySave(_num)
{
	if(_num == "0")
		var strLonLat = "LINESTRING(" + map.layers[1].getFeatureBy().geometry.transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326")).getComponentsString().replace(/, /g, " ") + ")";
	else
		var strLonLat = "LINESTRING(" + map2.layers[1].getFeatureBy().geometry.transform(map2.getProjectionObject(), new OpenLayers.Projection("EPSG:4326")).getComponentsString().replace(/, /g, " ") + ")";
	//alert(_num + "  " + $('#NameOfWayNew-'+_num).val() + "   " + strLonLat)
	$.ajax({
        url: "AddNewWay.php?name=" + $('#NameOfWayNew-'+_num).val() + "&line=" + strLonLat,
        context: document.body,
        success: function (data) {
            alert(data);
            $('#div-layer-newway-'+_num).css({display: 'none'});
            //vectors[0].removeAllFeatures();
        }
    });
}
function LayerWayNameSave(_num)
{
	//onFeatureUnselect('0');
	//alert(_num + "  " + $('#HiddenIdOfWay-'+_num).val() + "   " + $('#NameOfWay-'+_num).val());
	var strLonLat = "LINESTRING("; // + map.layers[1].getFeatureBy().geometry.transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326")).getComponentsString().replace(/, /g, " ") + ")";
	var ll;
	var strLonLat1="";
	var strLonLat2="";
	debugger;
	if(_num == "0")
	{
		for(var i=0; i< map.layers[1].features.length; i++)
		{
			if(map.layers[1].features[i].geometry.CLASS_NAME == "OpenLayers.Geometry.LineString")
			{
				if(i==0)
					if(map.layers[1].features[i].modified != null)
						var first = 2;
					else
						var first = 1;
				if(map.layers[1].features[i].modified == null)
				{
					ll = new OpenLayers.LonLat(map.layers[1].features[i].geometry.components[0].x, map.layers[1].features[i].geometry.components[0].y).transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
					strLonLat1 += String(ll.lon) + " " + String(ll.lat) + ",";
				}
				if(first == 2 && map.layers[1].features[i+1].geometry.CLASS_NAME == "OpenLayers.Geometry.Point")
				{
					ll = new OpenLayers.LonLat(map.layers[1].features[i].geometry.components[1].x, map.layers[1].features[i].geometry.components[1].y).transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
					strLonLat1 += String(ll.lon) + " " + String(ll.lat) + ",";
				}
			} else
			{
				if(map.layers[1].features[i].style == null)
				{
					ll = new OpenLayers.LonLat(map.layers[1].features[i].geometry.x, map.layers[1].features[i].geometry.y).transform(map.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
					strLonLat2 += String(ll.lon) + " " + String(ll.lat) + ",";
				}
			}
		}
		debugger;
		strLonLat2 = strLonLat2.substring(0,strLonLat2.length-1);
		strLonLat1 = strLonLat1.substring(0,strLonLat1.length-1);
		if(first == 1)
			strLonLat += strLonLat1 + "," + strLonLat2 + ")";
		else
			strLonLat += strLonLat2 + "," + strLonLat1 + ")";
	} else
	{
		for(var i=0; i< map2.layers[1].features.length; i++)
		{
			if(map2.layers[1].features[i].geometry.CLASS_NAME == "OpenLayers.Geometry.LineString")
			{
				ll = new OpenLayers.LonLat(map2.layers[1].features[i].geometry.components[0].x, map2.layers[1].features[i].geometry.components[0].y).transform(map2.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
				strLonLat += String(ll.lon) + " " + String(ll.lat) + ",";
			}else
			{
				ll = new OpenLayers.LonLat(map2.layers[1].features[i].geometry.x, map2.layers[1].features[i].geometry.y).transform(map2.getProjectionObject(), new OpenLayers.Projection("EPSG:4326"));
				strLonLat += String(ll.lon) + " " + String(ll.lat) + ",";
			}
		}
		strLonLat += strLonLat.substring(0, strLonLat.length-1) + ")";
	}
	debugger;
	// 21.733316240411 42.136965767287,21.733316240411 42.136719272051,21.73404498068 42.135306646234,21.73417282985 42.135041182832,21.73459473211 42.13460506197,21.734735366197 42.134443886109,21.734837645533 42.13387502685,21.734888785201 42.133609557447,21.735297902544 42.13335356804,21.735451321548 42.133059653001,21.735464106465 42.133059653001,21.735886571544 42.132172600295,21.735464106465 42.133059653001,21.736309036622 42.131285535165
	return false;
	$.ajax({
        url: "updateNameOfWay.php?osmid=" + $('#HiddenIdOfWay-'+_num).val() + "&name=" + $('#NameOfWay-'+_num).val()+ "&line=" + strLonLat,
        context: document.body,
        success: function (data) {
            alert(data);
            $('#div-layer-wayname-'+_num).css({display: 'none'});
            vectors[_num].removeAllFeatures();
        }
    });
}
function LayerWayNameOff(_id, _num)
{
	$('#'+_id).css({display: 'none'});
	vectors[_num].removeAllFeatures();
	if(_id == 'div-layer-newway-'+_num)
		DrawStreet();
}
function AddLayerPlay(el, num) {

    if (parseInt(el.offsetWidth, 10) < 550)
        var _w = parseInt(el.offsetWidth, 10) - 50;
    else
        if (ShowGFBtn)
            var _w = 755;
        else
            var _w = 655;
    var layerSwitcher = Create($(el).children()[0], 'div', 'div-layer-plays-' + num);
    $(layerSwitcher).css({ display: 'block', position: 'absolute', zIndex: '7000', backgroundColor: 'transparent', color: '#fff', left: '35px', top: '40px', width: _w + 'px', height: 'auto', textAlign: 'left' });
    layerSwitcher.className = 'corner15 text3';

    PlayBack(layerSwitcher, num, '<strong>x3</strong> ◀', '200', dic("back", lang) + ' x3');
    PlayBack(layerSwitcher, num, '<strong>x2</strong> ◀', '500', dic("back", lang) + ' x2');
    PlayBack(layerSwitcher, num, '◀', '1000', dic("back", lang));
    Pause(layerSwitcher, num);
    Play(layerSwitcher, num, '▶', '1000', dic("forward", lang));
    Play(layerSwitcher, num, '▶ <strong>x2</strong>', '500', dic("forward", lang) + ' x2');
    Play(layerSwitcher, num, '▶ <strong>x3</strong>', '200', dic("forward", lang) + ' x3');

    AddVehicleToFollow(layerSwitcher, num);
    AddVehicleChooser(layerSwitcher, num);
}
function Pause(el, num) {
    //if (AllowAddRuler == false) { return false }

    var layerPause = Create(el, 'div', 'div-layer-Pause-' + num);
    $(layerPause).css({ position: 'relative', float: 'left', zIndex: '7008', left: '20px', width: '50px', height: '25px' });
    layerPause.className = 'corner15 text3';

    var h = el.offsetHeight - 10
    var AddPauseBtn = Create(layerPause, 'div', 'div-addPause-' + num)

    $(AddPauseBtn).css({ display: 'block', position: 'relative', zIndex: '7000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 5px', width: '30px', height: '14px', cursor: 'pointer', textAlign: 'center' })
    AddPauseBtn.className = 'corner15 text3'
    AddPauseBtn.innerHTML = '<div style="font-size: 17px; position: relative; top: -4px;">■</div>';
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
    $(AddPauseBtn).mousemove(function (event) { ShowPopup(event, dic("pause", lang)) });
    $(AddPauseBtn).mouseout(function () { HidePopup() });
}
function Play(el, num, icon, time, popup) {
    //if (AllowAddRuler == false) { return false }

    var layerPlay = Create(el, 'div', 'div-layer-Play-' + time);
    $(layerPlay).css({ position: 'relative', float: 'left', zIndex: '7008', left: '20px', width: '50px', height: '25px' });
    layerPlay.className = 'corner15 text3';


    var h = el.offsetHeight - 10
    var AddPlayBtn = Create(layerPlay, 'div', 'div-addPlay-' + time)

    if (time == '1000') {
        var col = '387cb0';
        var bgC = 'fff';
        var bord = '1px solid #387CB0';
    } else {
        var col = 'fff';
        var bgC = '387cb0';
        var bord = '';
    }

    $(AddPlayBtn).css({ display: 'block', position: 'relative', zIndex: '7000', backgroundColor: '#'+bgC, border: bord, color: '#' + col, padding: '2px 5px 2px 5px', width: '30px', cursor: 'pointer', textAlign: 'center' })
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
    $(AddPlayBtn).mousemove(function (event) { ShowPopup(event, popup) });
    $(AddPlayBtn).mouseout(function () { HidePopup() });
}
function PlayBack(el, num, icon, time, popup) {
    //if (AllowAddRuler == false) { return false }

    var layerPlay = Create(el, 'div', 'div-layer-PlayBack-' + time);
    $(layerPlay).css({ position: 'relative', float: 'left', zIndex: '7008', left: '20px', width: '50px', height: '25px' });
    layerPlay.className = 'corner15 text3';


    var h = el.offsetHeight - 10
    var AddPlayBtn = Create(layerPlay, 'div', 'div-addPlayBack-' + time)

    $(AddPlayBtn).css({ display: 'block', position: 'relative', zIndex: '7000', backgroundColor: '#387cb0', color: '#fff', padding: '2px 5px 2px 5px', width: '30px', cursor: 'pointer', textAlign: 'center' })
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
    $(AddPlayBtn).mousemove(function (event) { ShowPopup(event, popup) });
    $(AddPlayBtn).mouseout(function () { HidePopup() });
}
function AddClosePopUpButton(el, num) {
    var layerCB = Create($(el).children()[0], 'div', 'div-layer-ClosePopUp-' + num);
    $(layerCB).css({ display: 'block', position: 'absolute', zIndex: '7000', backgroundColor: 'transparent', color: '#fff', left: '35px', top: '100px', width: '200px', height: 'auto', textAlign: 'left' });
    layerCB.className = 'corner15 text3';

    var layerCB1 = Create(layerCB, 'div', 'div-layer-ClosePopup');
    $(layerCB1).css({ position: 'relative', float: 'left', zIndex: '8008', left: '20px', width: '80px', height: '25px' });
    layerCB1.className = 'corner15 text3';
    var AddCPBtn = Create(layerCB1, 'div', 'div-addCPB')
    var col = 'fff';
    var bgC = '387cb0';
    var bord = '';
    $(AddCPBtn).css({ display: 'block', position: 'relative', zIndex: '8000', backgroundColor: '#' + bgC, border: bord, color: '#' + col, padding: '2px 5px 2px 5px', width: '60px', cursor: 'pointer', textAlign: 'center' })
    AddCPBtn.className = 'corner15 text3';
    AddCPBtn.innerHTML = dic('hide', lang);
    $(AddCPBtn).click(function (event) {
        if (!ClosePopUp) {
            for (var i = 0; i < map.popups.length; i++)
                map.popups[i].hide();
            ClosePopUp = true;
            $('#div-addCPB').html(dic('show', lang));
        } else {
            for (var i = 0; i < map.popups.length; i++)
                map.popups[i].show();
            ClosePopUp = false;
            $('#div-addCPB').html(dic('hide', lang));
        }
    });
}
function AddPrintButton(el, num) {
    var layerPrint = Create($(el).children()[0], 'div', 'div-layer-Print-' + num);
    $(layerPrint).css({ display: 'block', position: 'absolute', zIndex: '7000', backgroundColor: 'transparent', color: '#fff', left: '35px', top: '130px', width: '200px', height: 'auto', textAlign: 'left' });
    layerPrint.className = 'corner15 text3';

    var layerPrint1 = Create(layerPrint, 'div', 'div-layer-Print');
    $(layerPrint1).css({ position: 'relative', float: 'left', zIndex: '8008', left: '20px', width: '80px', height: '25px' });
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
function AddDaysButton(el, num, days, vh, sd, sdB, ed, br) {
    if (parseInt(el.offsetWidth, 10) < 550)
        var _w = parseInt(el.offsetWidth, 10) - 50;
    else
        if (ShowGFBtn)
            var _w = 755;
        else
            var _w = 655;   
    var layerDays = Create($(el).children()[0], 'div', 'div-layer-days-' + num);
    $(layerDays).css({ display: 'block', position: 'absolute', zIndex: '7000', backgroundColor: 'transparent', color: '#fff', left: '35px', top: '70px', width: _w + 'px', height: 'auto', textAlign: 'left' });
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
    $(layerDay).css({ position: 'relative', float: 'left', zIndex: '8008', left: '20px', width: '80px', height: '25px' });
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
    $(AddDayBtn).css({ display: 'block', position: 'relative', zIndex: '8000', backgroundColor: '#'+bgC, border: bord, color: '#' + col, padding: '2px 5px 2px 5px', width: '60px', cursor: 'pointer', textAlign: 'center' })
    AddDayBtn.className = 'corner15 text3';
    var _tmpDay = _day1.split(" ")[0];
    AddDayBtn.innerHTML = _tmpDay.split("-")[2] + "-" + _tmpDay.split("-")[1] + "-" + _tmpDay.split("-")[0];  // parseInt(_day, 10) + 1;
    if (parseInt(br, 10) == 0)
        AddDayBtn.style.backgroundColor = 'Gray';

    $(AddDayBtn).click(function (event) {
        if (parseInt(br, 10) == 0)
            return false;
        for (var i = 0; i < $('#div-layer-days-0')[0].children.length; i++) {
            if ($('#div-addDay-' + i).css('backgroundColor') != "Gray") {
                if ((i + 1) == parseInt(event.target.innerHTML, 10)) {
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
        drawRecPerDay(_day1, popup, vh);
    });

    $(AddDayBtn).mousemove(function (event) { if (event.target.innerHTML == "1") { ShowPopup(event, _day1) } else { ShowPopup(event, popup) } });
    $(AddDayBtn).mouseout(function () { HidePopup() });
}

function drawRecPerDay(_day1, _day2, vh) {
    Vehicles[0].Marker.display(false);
    vectors[0].removeAllFeatures();
    for (var tmpMR = 0; tmpMR < tmpMarkersRec.length; tmpMR++) {
        Markers[0].removeMarker(tmpMarkersRec[tmpMR]);
        tmpMarkersRec[tmpMR].destroy();
    }
    tmpMarkersRec = [];
    CharY.remove();
    CharSpeed.remove();
    PlayForwardRec = false; PlayBackRec = false;
    if (_day1.split(" ")[1] != undefined)
        _d1 = _day1;
    else
        _d1 = _day1 + " 00:00";
    if (_day2.split(" ")[1] != undefined)
        _d2 = _day2;
    else
        _d2 = _day2 + " 23:59";
    $('#gnInfoChar').html('');
    ShowWait();
    $.ajax({
        url: "../report/getHistoryByDay.aspx?v=" + vh + "&sd=" + _d1 + "&ed=" + _d2,
        context: document.body,
        success: function (data) {
            data = unzip(data);
            CarStr = data.split("@")[0];
            DrawPath_Rec(data.split("@")[1], data.split("@")[2], Car[0].id, Car[0].reg);
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
            lastDiv = 0
            lastColor
            xStep = 0.1
            tipRec = 0;

            pocetenDatum = _d1.split(" ")[0].split("-")[2] + "-" + _d1.split(" ")[0].split("-")[1] + "-" + _d1.split(" ")[0].split("-")[0] + " " + _d1.split(" ")[1] + ":00";
            kraenDatum = _d2.split(" ")[0].split("-")[2] + "-" + _d2.split(" ")[0].split("-")[1] + "-" + _d2.split(" ")[0].split("-")[0] + " " + _d2.split(" ")[1] + ":00";

            _maxSpeed = data.split("@")[3];
            test24(CarStr.substring(1, CarStr.length));

            PlayForwardRec = true;
            Vehicles[0].Marker.display(true);
            RecStert(1);
            zoomWorldScreen(Maps[0], DefMapZoom);
            HideWait();
        }
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
    if (MapType[num] == 'YAHOOM' || MapType[num] == 'YAHOOS') $('#div-layer-switch-' + num).html('Geonet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;')

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

    $(layerSwitcher).mousemove(function (event) { ShowPopup(event, '' + dic("switchMap", lang) + '') });
    $(layerSwitcher).mouseout(function () { HidePopup() });

    var layerType = Create(layerMapType, 'div', 'div-type-' + num);
    $(layerType).css({ display: 'block', position: 'absolute', zIndex: '8001', fontSize: '11px', backgroundColor: 'transparent', color: '#fff', left: '80px', top: '1px', width: '15px', cursor: 'pointer' })
    $(layerType).html('|&nbsp;&nbsp;&nbsp;▼');

    $(layerType).click(function (event) { SelectTypeMapLayer(num) });
    $(layerType).mousemove(function (event) { ShowPopup(event, '' + dic("switchTypeMap", lang) + '') });
    $(layerType).mouseout(function () { HidePopup() });

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
            $('#layerType-3-' + num).css({ display: 'none' });
            if (MapType[num] == 'YAHOOM') { $('#layerType-1-' + num).html('▪&nbsp;New Maps') } else { $('#layerType-1-' + num).html('&nbsp;&nbsp;New Maps') }
            if (MapType[num] == 'YAHOOS') { $('#layerType-2-' + num).html('▪&nbsp;Old Maps') } else { $('#layerType-2-' + num).html('&nbsp;&nbsp;Old Maps') }
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
        if (MapType[num] == 'YAHOOM' || MapType[num] == 'YAHOOS') { $('#layer-4-' + num).html('▪&nbsp;Geonet') } else { $('#layer-4-' + num).html('&nbsp;&nbsp;Geonet') }
        return
    } else {
        document.getElementById('div-layer-list-' + num).style.display = 'none'
    }
}

function SelectMapLayer(num, l) {
    var ll = GetCenterOfMap(num);
    var zl = GetZoomLevel(num)

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
    if (l == 13) { MapType[num] = 'GOOGLEP'; }

    Boards[num].innerHTML = ''

    map = new OpenLayers.Map({ div: Boards[num].id, allOverlays: true,
        eventListeners: {
            "zoomend": mapEvent,
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
    if (MapType[num] == 'YAHOOM') { layer = new OpenLayers.Layer.WMS( "OpenLayers WMS", "http://m.gps.mk:8080/geoserver/wms", {'layers': 'macedonia'} ); }
    if (MapType[num] == 'YAHOOS') { layer = new OpenLayers.Layer.WMS( "OpenLayers WMS", "./map.aspx", {'layers': 'basic'} ); }

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
                handlerOptions: {
                    layerOptions: {
                        renderers: renderer
                    }
                }
            }
        ),
        select: selectControl
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
        AddDaysButton(Boards[0], 0, days, vh, sd, sdB, ed, bool);
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
        vectors[0].addFeatures(ArrLineFeature);
        
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
}

function CreateVehicle(_mapNo, _vehicleNo, _color, _lon, _lat, map0, map1, map2, map3, _reg){
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
			el.innerHTML = '<div class="gnMarker' + MarkerColor + ' text3"><strong>' + _vehicleNo + '</strong></div>'
			// Ova ne treba ako miruva //el.innerHTML += '<div class="gnMarkerPointer' + MarkerColor + '" style="left:' + 20 + 'px; top:' + 6 + 'px; height:6px; width:6px; position:absolute; display:box; font-size:4px"></div>'			
			
			el.setAttribute("onmousemove","ShowPopup(event, '#vehicleList-"+_vehicleNo+"')")
			el.setAttribute("onmouseout", "HidePopup()");
			el.addEventListener('click', function(e) { AddPOI = true; VehClick = true; });

			Vehicle.Marker = MyM
			Vehicle.el = el
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
                for (var i = 0; i < Vehicles.length; i++) {
                    for (var cc = 1; cc <= 25; cc++) {
                        if (Timers[j][i] != null) {
                            if (Timers[j][i][cc] != null)
                                window.clearTimeout(Timers[j][i][cc])
                        }
                    }
                    Timers[j][i] = null;
                    Timers[j][i] = [];
                }
                CreateVehicle(j, _car.id, _car.color, _car.lon, _car.lat, _car.map0, _car.map1, _car.map2, _car.map3, _car.reg)
            }
        }
    }
    //if (ShowPOI == true) {
        //LoadPOI()
    //}
}

function ResetTimersStep(num) {
    for (var i = 0; i < Vehicles.length; i++) {
        for (var cc = 1; cc <= 25; cc++) {
            if (Timers[num][i] != null) {
                if (Timers[num][i][cc] != null)
                    window.clearTimeout(Timers[num][i][cc]);
            }
        }
        Timers[num][i] = null;
        Timers[num][i] = [];
    }
    for (var c = 0; c < Car.length; c++) {
        var _car = Car[c];
        if (Maps[num] != null)
            CreateVehicle(num, _car.id, _car.color, _car.lon, _car.lat, _car.map0, _car.map1, _car.map2, _car.map3, _car.reg)
    }
    //if (ShowPOI == true) {
        //LoadPOI();
    //}
}
var MarkerJump = [6,10,25,40,70,140,280]
function MoveMarker(_vehicleNo, newLon, newLat, _color, map0, map1, map2, map3) {
    for (var i = 0; i < Vehicles.length; i++) {
        for (var j = 0; j < 5; j++) {
            Timers[j] = [];
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
                    if ((dX == 0) && (dY == 0)) {
                        alfa = Vehicles[i].angle
                    }

                    var radius = 14;
                    var pi = 3.14159;
                    var cosAlfa = Math.cos(alfa * (pi / 180));
                    var sinAlfa = Math.sin(alfa * (pi / 180));
                    var nPozX = ((cosAlfa * radius) - 4) + 24;
                    var nPozY = ((sinAlfa * radius) - 4) + 24;
                    Vehicles[i].Color = _color;
                    Vehicles[i].el.innerHTML = '<div class="gnMarker' + _color + ' text3"><strong>' + _vehicleNo + '</strong></div>'
                    if ((dX == 0) && (dY == 0)) {
                        Vehicles[i].el.innerHTML += '<div class="gnMarkerPointer' + _color + '" style="left:' + nPozX + 'px; top:' + nPozY + 'px; height:6px; width:6px; position:absolute; display:box; font-size:4px"></div>'
                    } else {
                        Vehicles[i].el.innerHTML += '<div class="gnMarkerPointer' + _color + '" style="left:' + nPozX + 'px; top:' + nPozY + 'px; height:6px; width:6px; position:absolute; display:box; font-size:4px"></div>'
                    }
                    
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
                    
                    if (resetScreen[j] || parseInt(Maps[j].zoom, 10) < 12 || jump) {
                        //if(i == 5)
                            //debugger;
                        MoveMoveMarkerStep(i, p2.x, p2.y, j);
                    } else {
                        var stepX = (p2.x - p1.x) / 25;
                        var stepY = (p2.y - p1.y) / 25;
                        var tmr = 0;

                        var stepT = 10000 / 25;
                        Timers[j][i] = [];
                        var pom1 = p1;

                        if ((stepX == 0) && (stepY == 0)) { } else {
                            for (var cc = 1; cc <= 25; cc++) {

                                pom1.x = pom1.x + (stepX);
                                pom1.y = pom1.y + (stepY);
                                Timers[j][i][cc] = window.setTimeout("MoveMoveMarker(" + i + "," + pom1.x + "," + pom1.y + "," + j + ")", tmr);
                                tmr = tmr + 200;
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
function MoveMarkerBack(_vehicleNo, newLon, newLat, _color, map0, map1, map2, map3) {
    for (var i = 0; i < Vehicles.length; i++) {
        for (var j = 0; j < 5; j++) {
            Timers[j] = [];
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
                    Vehicles[i].el.innerHTML = '<div class="gnMarker' + _color + ' text3"><strong>' + _vehicleNo + '</strong></div>'
                    if ((dX == 0) && (dY == 0)) {
                        Vehicles[i].el.innerHTML += '<div class="gnMarkerPointer' + _color + '" style="left:' + nPozX + 'px; top:' + nPozY + 'px; height:6px; width:6px; position:absolute; display:box; font-size:4px"></div>'
                    } else {
                        Vehicles[i].el.innerHTML += '<div class="gnMarkerPointer' + _color + '" style="left:' + nPozX + 'px; top:' + nPozY + 'px; height:6px; width:6px; position:absolute; display:box; font-size:4px"></div>'
                    }

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
                    
                    if (resetScreen[j] || parseInt(Maps[j].zoom, 10) < 12 || jump) {
                        //if(i == 5)
                        //debugger;
                        MoveMoveMarkerStep(i, p2.x, p2.y, j);
                    } else {
                        var stepX = (p2.x - p1.x) / 25;
                        var stepY = (p2.y - p1.y) / 25;
                        var tmr = 0;

                        var stepT = 10000 / 25;
                        Timers[j][i] = [];
                        var pom1 = p1;

                        if ((stepX == 0) && (stepY == 0)) { } else {
                            for (var cc = 1; cc <= 25; cc++) {

                                pom1.x = pom1.x + (stepX);
                                pom1.y = pom1.y + (stepY);
                                Timers[j][i][cc] = window.setTimeout("MoveMoveMarker(" + i + "," + pom1.x + "," + pom1.y + "," + j + ")", tmr);
                                tmr = tmr + 200;
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
    var imagee = "../images/"

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

	//if (LastPointsLon.length > 0) {
	    if (tmpCheckGroup[1] != undefined) {
	        if (tmpCheckGroup[1][(parseInt(_i, 10) + 1)] == 1) {
	            //document.getElementById("testText").value = VehReg;
                DrawPathAgain(LastPointsLon[carID] + ',' + lonLat.lon, LastPointsLat[carID] + ',' + lonLat.lat, carID, _j, _i, VehReg);
	        }
	        else
	            var nothing = "";
	    } else {
	        //document.getElementById("testText").value = VehReg + " - 1";
	        DrawPathAgain(LastPointsLon[carID] + ',' + lonLat.lon, LastPointsLat[carID] + ',' + lonLat.lat, carID, _j, _i, VehReg);
	    }
	//}
}
function MoveMoveMarker(_i, pX, pY, _j) {
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
        
        //if (LastPointsLon.length > 0) {
            if (tmpCheckGroup[1] != undefined) {
                if (tmpCheckGroup[1][(parseInt(_i, 10) + 1)] == 1) {
                    //document.getElementById("testText").value = VehReg;
                    DrawPathAgain(LastPointsLon[carID] + ',' + lonLat.lon, LastPointsLat[carID] + ',' + lonLat.lat, carID, _j, _i, VehReg);
                }
                else
                    var nothing = "";
            } else {
                //document.getElementById("testText").value = VehReg + " - 1";
                DrawPathAgain(LastPointsLon[carID] + ',' + lonLat.lon, LastPointsLat[carID] + ',' + lonLat.lat, carID, _j, _i, VehReg);
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
		var p = c[i].split("|")
		var _car = new CarType(p[0], p[3], p[1], p[2], p[13]);
		_car.passive = p[4]
		_car.datum = p[5]
		_car.location = p[6]
		_car.speed=p[7]+' Km/h'
		_car.taxi=p[8]
		_car.sedista=p[9]
		_car.olddate = p[10]
		_car.address = p[11]
		_car.gis = p[12]

		for (var j =0; j<Car.length; j++){
			if (Car[j].id == p[0]) {
				var m0=Car[j].map0
				var m1=Car[j].map1
				var m2=Car[j].map2
				var m3=Car[j].map3
				if ((_car.lon == Car[j].lon) && (_car.lat == Car[j].lat)){
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
	var _page = 'getCurrent.php'
	var xmlHttp; var str = ''
	var el = this._Element
	try { xmlHttp = new XMLHttpRequest(); } catch (e) {
		try
	  { xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); }
		catch (e) { try { xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) { alert("Your browser does not support AJAX!"); return false; } }
	}

	xmlHttp.onreadystatechange = function () {
	    if (xmlHttp.readyState == 4) {
	        str = xmlHttp.responseText

	        str = JXG.decompress(str);

	        ParseCarStrAjax(str)
	        var tmr = 0;

	        for (var j = 0; j < Car.length; j++) {
	            MoveMarker(Car[j].id, parseFloat(Car[j].lon), parseFloat(Car[j].lat), Car[j].color, Car[j].map0, Car[j].map1, Car[j].map2, Car[j].map3);
	            var svc = document.getElementById('div-sv-' + Car[j].id);
	            if (svc != null) {
	                svc.className = 'gnMarkerList' + Car[j].color + ' text3'
	                if (Car[j].passive == '0') { $('#div-pass-' + Car[j].id).css({ opacity: '0.3' }) } else { $('#div-pass-' + Car[j].id).css({ opacity: '1' }) }
	                $('#vh-date-' + Car[j].id).html(Car[j].datum + '&nbsp;')
	                if (Car[j].olddate == '1') { $('#vh-date-' + Car[j].id).css("color", "#FF0000") } else { $('#vh-date-' + Car[j].id).css("color", "009933") }

	                document.getElementById('vh-small-' + Car[j].id).className = 'gnMarkerList' + Car[j].color + ' text3'
	                if (Car[j].same == false) { getAddress(Car[j].lon, Car[j].lat, 'vh-location-' + Car[j].id) }

	                if (Car[j].location == "")
	                    $('#vh-pp-pic-' + Car[j].id).css({ display: "none" });
	                else
	                    $('#vh-pp-pic-' + Car[j].id).css({ display: "block" });
	                $('#vh-pp-' + Car[j].id).html(Car[j].location);
	                $('#vh-pp-pic-' + Car[j].id).mousemove(function (event) {
	                    ShowPopup(event, '<img src=\'../images/poiButton.png\' style=\'position: relative; float: left; top: 2px; \' /><div style=\'position: relative; float: left; margin-left: 7px; padding-right: 3px;\'>' + dic('Poi', lang) + ':<br /><strong style="font-size: 14px;">' + $('#vh-pp-' + this.id.substring(this.id.lastIndexOf("-") + 1, this.id.length)).html() + '</strong></div>');
	                });
	                $('#vh-pp-pic-' + Car[j].id).mouseout(function () { HidePopup() });

	                if (Car[j].address == "")
	                    $('#vh-address-pic-' + Car[j].id).css({ display: "none" });
	                else
	                    $('#vh-address-pic-' + Car[j].id).css({ display: "block" });
	                $('#vh-address-' + Car[j].id).html(Car[j].address);
	                $('#vh-address-pic-' + Car[j].id).mousemove(function (event) {
	                    ShowPopup(event, '<img src=\'../images/areaImg.png\' style=\'position: relative; float: left; top: 2px; \' /><div style=\'position: relative; float: left; margin-left: 7px; padding-right: 3px;\'>' + dic('GFVeh', lang) + '<br /><strong style="font-size: 14px;">' + $('#vh-address-' + this.id.substring(this.id.lastIndexOf("-") + 1, this.id.length)).html() + '</strong></div>');
	                });
	                $('#vh-address-pic-' + Car[j].id).mouseout(function () { HidePopup() });

	                if (Car[j].gis == "")
	                    $('#vh-location-pic-' + Car[j].id).css({ display: "none" });
	                else
	                    $('#vh-location-pic-' + Car[j].id).css({ display: "block" });
	                $('#vh-location-' + Car[j].id).html(Car[j].gis);
	                $('#vh-location-pic-' + Car[j].id).mousemove(function (event) {
	                    ShowPopup(event, '<img src=\'../images/shome.png\' style=\'position: relative; float: left; top: 2px; \' /><div style=\'position: relative; float: left; margin-left: 7px; padding-right: 3px;\'>' + dic('Street', lang) + '<br /><strong style="font-size: 14px;">' + $('#vh-location-' + this.id.substring(this.id.lastIndexOf("-") + 1, this.id.length)).html() + '</strong></div>');
	                });
	                $('#vh-location-pic-' + Car[j].id).mouseout(function () { HidePopup() });

	                $('#vh-speed-' + Car[j].id).html(Car[j].speed);
	                //if (Car[j].location == '') { $('#vh-pp-' + Car[j].id).css("borderTop", '0px') } else { $('#vh-pp-' + Car[j].id).css("borderTop", '1px dotted #333') }
	                tmr = tmr + 100
	                $('#vh-sedista-' + Car[j].id).html(Car[j].sedista)
	                if (Car[j].taxi == '1') { $('#div-taxi-' + Car[j].id).css('color', '#009933') } else { $('#div-taxi-' + Car[j].id).css('color', '#FF0000') }
	            }
	            //AnimateMarker(Car[j].id, parseFloat(Car[j].lon), parseFloat(Car[j].lat), Car[j].color)
	        }
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
	                    for (var br = 0; br < VehicleListID.length; br++) {
	                        if (document.getElementById('f-vehicle-' + i + '-' + VehicleListID[br]).checked) {
	                            for (var z = 0; z < Maps[i].layers[2].markers.length; z++)
	                                if (Maps[i].layers[2].markers[z].icon.imageDiv.textContent == VehicleListID[br]) {
	                                    _ch[_chNum] = z;
	                                    _chNum++;
	                                    break;
	                                }
	                        }
	                        //Vehicles[br].el.setAttribute("onmousemove", "ShowPopup(event, '#vehicleList-" + Vehicles[br].ID + "')");
	                        //Vehicles[br].el.setAttribute("onmouseout", "HidePopup()");
	                    }
	                    if (_chNum > 0 && _chNum < 2) {
	                        if (!Maps[i].layers[2].markers[_ch[_chNum - 1]].onScreen()) {
	                            Maps[i].setCenter(Maps[i].layers[2].markers[_ch[_chNum - 1]].lonlat, Maps[i].zoom);
	                        }
	                    } else
	                        if (_chNum > 1) {
	                            zoomMapVeh(Maps[i], _ch);
	                        }
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
	                        Vehicles[x].el.setAttribute("onmousemove", "ShowPopup(event, '#vehicleList-" + Vehicles[x].ID + "')");
	                        Vehicles[x].el.setAttribute("onmouseout", "HidePopup()");
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
	                            Vehicles[dist[x].split(",")[y]].Marker.events.element.setAttribute("onmousemove", "ShowPopupB(event, '" + distVeh[x].substring(0, distVeh[x].length - 1) + "')");
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

	        setTimeout("Ajax();", 5000);
	    }
	}
	xmlHttp.open("GET", _page, true);
	xmlHttp.send(null);
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

        $('#vh-date-' + CarMove[0]).html(CarMove[4] + '&nbsp;')
        document.getElementById('vh-small-' + CarMove[0]).className = 'gnMarkerList' + CarMove[3] + ' text3'
        $('#vh-speed-' + CarMove[0]).html(CarMove[5]);
        $('#vh-sedista-' + CarMove[0]).html(CarMove[7])
        if (CarMove[6] == '1') { $('#div-taxi-' + CarMove[0]).css('color', '#009933') } else { $('#div-taxi-' + CarMove[0]).css('color', '#FF0000') }

        if (PlayForwardRec && i < _pts.length - 1)
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

        $('#vh-date-' + CarMove[0]).html(CarMove[4] + '&nbsp;')
        document.getElementById('vh-small-' + CarMove[0]).className = 'gnMarkerList' + CarMove[3] + ' text3'
        $('#vh-speed-' + CarMove[0]).html(CarMove[5]);
        $('#vh-sedista-' + CarMove[0]).html(CarMove[7])
        if (CarMove[6] == '1') { $('#div-taxi-' + CarMove[0]).css('color', '#009933') } else { $('#div-taxi-' + CarMove[0]).css('color', '#FF0000') }
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
                if ((Vehicles[i].ID == vID) && (Vehicles[i].Map == j)) {
                    // Ako e markerot vidliv
                    var ll = Maps[j].getCenter().transform(new OpenLayers.Projection("EPSG:4326"), Maps[j].getProjectionObject());
                    setCenterMap(Vehicles[i].Lon, Vehicles[i].Lat, 16, j);
                    runEffect(Vehicles[i].el.id);
                }
            }
        }
    }
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


function ChangePassiveStatus(vID){
	var op = $('#div-pass-'+vID).css("opacity") + ''
	if (op=='0.3') {
		$('#div-pass-'+vID).css({opacity:'1'})
		$.ajax({url: "setPassive.php?q=1&nov=" + vID, context: document.body});
		return
	}else{
		$('#div-pass-'+vID).css({opacity:'0.3'})
		$.ajax({url: "setPassive.php?q=0&nov=" + vID, context: document.body});		
		return
	}
}

function LoadAllPOI(_id, num) {
    if (ShowPOI == false) {
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
        url: "getPOI.php?id=" + _id,
        context: document.body,
        success: function (data) {
            var _pp = JXG.decompress(data).split('#');
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
                            var size = new OpenLayers.Size(16, 16);
                            var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
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
                            var _bgimg = 'http://gps.mk/new/pin/?color=' + _ppp[5] + '&type=0';
                            tmpMarkers[i][tmpMarkers[i].length - 1].events.element.innerHTML = '<div style="background: transparent url(' + _bgimg + ') no-repeat; width: 24px; height: 24px; font-size:4px"></div>';
                            tmpMarkers[i][tmpMarkers[i].length - 1].events.element.style.cursor = 'pointer';
                            //tmpMarkers[tmpMarkers.length - 1].events.element.style.backgroundColor = '#' + _ppp[7];
                            tmpMarkers[i][tmpMarkers[i].length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + _ppp[2] + "<br /></strong><br />" + dic("Group", lang) + ": <strong style=\"font-size: 12px;\">" + _ppp[6] + "</strong>')");
                            tmpMarkers[i][tmpMarkers[i].length - 1].events.element.setAttribute("onclick", "EditPOI('" + _ppp[0] + "', '" + _ppp[1] + "', '" + _ppp[2] + "', '2', '" + _ppp[3] + "', '" + _ppp[4] + "', '', '" + (tmpMarkers[i].length - 1) + "', '1', '/', '" + _ppp[7] + "')");
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
    var size = new OpenLayers.Size(16, 16);
    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
    if (se == 1 && se == '1') {
        var icon = new OpenLayers.Icon('../images/StartRoute.png', size, null, calculateOffset);
    }
    else {
        var icon = new OpenLayers.Icon('../images/StopRoute.png', size, null, calculateOffset);
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

function CreateMarkerIgnition_Rec(_lonn, _latt, _time, _date, _date1) {
    var size = new OpenLayers.Size(11, 11);
    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h + 5); };
    var icon = new OpenLayers.Icon('./blank.png', size, null, calculateOffset);
    var _NewCreateDateTime = _date.split(" ")[0].split("-")[0] + "/" + _date.split(" ")[0].split("-")[1] + "/" + _date.split(" ")[0].split("-")[2].substring(2, 4) + " " + _date.split(" ")[1].split(":")[0] + ":" + _date.split(" ")[1].split(":")[1];
    var _NewCreateDateTime1 = _date1.split(" ")[0].split("-")[0] + "/" + _date1.split(" ")[0].split("-")[1] + "/" + _date1.split(" ")[0].split("-")[2].substring(2, 4) + " " + _date1.split(" ")[1].split(":")[0] + ":" + _date1.split(" ")[1].split(":")[1];
    if (Maps[0] != null) {
        var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject())
        
        var _dt = _date.split(/\-|\s/);
        var _dt1 = new Date(_dt.slice(0, 3).reverse().join('/') + ' ' + _dt[3]);
        var _dtT = _date1.split(/\-|\s/);
        var _dtT1 = new Date(_dtT.slice(0, 3).reverse().join('/') + ' ' + _dtT[3]);
        var _diffDT = get_time_difference(_dtT1, _dt1);
        if (_diffDT.days == 0 && _diffDT.hours == 0 && _diffDT.minutes == 0)
            var _zero = " < " + _MinMin + "m";
        else
            var _zero = "";
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
                    "<div class='text1' style='overflow: hidden; font-size:.8em; position: relative; left: -2px; top: -8px; width: 105px; height: 59px; margin-right: -15px; margin-bottom: -22px;'><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"" + dic("STOS", lang) + "\")' onmouseout='HidePopup()' src='../images/startRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime1 + "<br /><img onmousemove='ShowPopup(event, \"" + dic("ETOS", lang) + "\")' onmouseout='HidePopup()' src='../images/endRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime + "<br /><img onmousemove='ShowPopup(event, \"" + dic("TTOS", lang) + "\")' onmouseout='HidePopup()' src='../images/sum1.png' style='height: 16px; width: 16px; position: relative; top: 4px;' />: " + _zero + (_diffDT.days != 0 ? (_diffDT.days + " d") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " m") : "") + "</strong></div>", null, true);
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
        MyMar.events.element.style.zIndex = 666
        tmpMarkersRec[tmpMarkersRec.length] = MyMar;
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.innerHTML = '<div class="gnPOI" style="background-color: #ff0000"; display:box; font-size:4px"></div>';
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.style.cursor = 'pointer';
        var popup = new OpenLayers.Popup.FramedCloud("Popup",
                lonLatMarker,
                new OpenLayers.Size(500, 500),
                //"<div class='text1' style='overflow: hidden; font-size:.8em; position: relative; left: -2px; top: -8px; width: 107px; height: 70px; margin-right: -10px; margin-bottom: -20px;'><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"Почетно време на застанување\")' onmouseout='HidePopup()' src='../images/startRec.png' style='height: 20px; width: 19px; position: relative; top: 5px;' />: " + _NewCreateDateTime1 + "<br /><img onmousemove='ShowPopup(event, \"Крајно време на застанување\")' onmouseout='HidePopup()' src='../images/endRec.png' style='height: 20px; width: 19px; position: relative; top: 5px;' />: " + _NewCreateDateTime + "<br /><img onmousemove='ShowPopup(event, \"Вкупно време на стоење\")' onmouseout='HidePopup()' src='../images/sum1.png' style='height: 19px; width: 19px; position: relative; top: 5px;' />: " + _zero + (_diffDT.days != 0 ? (_diffDT.days + " d") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " m") : "") + "</strong></div>", null, true);
                "<div class='text1' style='overflow: hidden; font-size:.8em; position: relative; left: -2px; top: -8px; width: 105px; height: 59px; margin-right: -15px; margin-bottom: -22px;'><strong style='font-size: 12px;'><img onmousemove='ShowPopup(event, \"" + dic("STOS", lang) + "\")' onmouseout='HidePopup()' src='../images/startRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime1 + "<br /><img onmousemove='ShowPopup(event, \"" + dic("ETOS", lang) + "\")' onmouseout='HidePopup()' src='../images/endRec.png' style='height: 17px; width: 16px; position: relative; top: 4px;' />: " + _NewCreateDateTime + "<br /><img onmousemove='ShowPopup(event, \"" + dic("TTOS", lang) + "\")' onmouseout='HidePopup()' src='../images/sum1.png' style='height: 16px; width: 16px; position: relative; top: 4px;' />: " + _zero + (_diffDT.days != 0 ? (_diffDT.days + " d") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " m") : "") + "</strong></div>", null, true);
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
            this.popup.show();
        }
        //tmpMarkersRec[tmpMarkersRec.length - 1].feature = feature;
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 12px;\">" + dic("STOS", lang) + ": " + _date1.substring(0, _date1.lastIndexOf(":")) + "<br />" + dic("ETOS", lang) + ": " + _date.substring(0, _date.lastIndexOf(":")) + "<br />" + dic("TTOS", lang) + ": " + _zero + (_diffDT.days != 0 ? (_diffDT.days + " d") : "") + " " + (_diffDT.hours != 0 ? (_diffDT.hours + " h") : "") + " " + (_diffDT.minutes != 0 ? (_diffDT.minutes + " m") : "") + "</strong>')");
        $(tmpMarkersRec[tmpMarkersRec.length - 1].events.element).mouseout(function () { HidePopup() });
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.addEventListener('click', function (e) { AddPOI = true; VehClick = true; });
    }
}
function CreateMarkerStartEnd(_lonn, _latt, _time, _date, _who) {
    var size = new OpenLayers.Size(15, 15);
    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
    if (_who == "s") {
        var icon = new OpenLayers.Icon('../images/StartRoute.png', size, null, calculateOffset);
        var _color = 'Green';
        var _text = dic("Start", lang) + ":<br />";
    }
    else {
        var icon = new OpenLayers.Icon('../images/StopRoute.png', size, null, calculateOffset);
        var _color = "#ff0000";
        var _text = dic("End", lang) + ":<br />";
    }

    if (Maps[0] != null) {
        var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject())
        //if (MapType[0] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
        var MyMar = new OpenLayers.Marker(ll, icon)
        var markers = Markers[0];

        markers.addMarker(MyMar);
        MyMar.events.element.style.zIndex = 666
        tmpMarkersRec[tmpMarkersRec.length] = MyMar;
        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.innerHTML = '<div class="gnPOI" style="background-color: ' + _color + '"; display:box; font-size:4px"></div>';
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.style.cursor = 'pointer';
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 12px;\">" + _text + _date + "<br />" + _time + "</strong>')");
        $(tmpMarkersRec[tmpMarkersRec.length - 1].events.element).mouseout(function () { HidePopup() });
        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.addEventListener('click', function (e) { AddPOI = true; VehClick = true; });
    }
}

function LoadZone(_id) {
    ShowWait();
    $.ajax({
        url: "getVehPaths.php?id=" + _id,
        context: document.body,
        success: function (data) {
            var d = JXG.decompress(data).split("@");
            if (d != "#") {
                for (var i = 1; i < d.length; i++) {
                    for (var cz = 0; cz <= cntz; cz++) {
                        if (document.getElementById("zona_" + cz) != null)
                            if ($('#zona_' + cz)[0].attributes[1].nodeValue.indexOf(d[i].split("|")[0]) != -1)
                                $('#zona_' + cz)[0].checked = true;
                    }
                    DrawZoneOnLive(d[i].split("|")[0], d[i].split("|")[1]);
                }
            } else {
                HideWait();
            }
            $('#div-VehicleUp').css({ display: 'none' });
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
        _html = _html + '<div id="ActiveW1" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: 0px -24px;"></div>';
    else
        if (SelectedSpliter == 1) {
            _html = _html + '<div id="ActiveW1" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -24px -24px;"></div>';
            _html = _html + '<div id="ActiveW2" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -48px 0px;"></div>';
        } else
            if (SelectedSpliter == 2) {
                _html = _html + '<div id="ActiveW1" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -72px -24px;"></div>';
                _html = _html + '<div id="ActiveW2" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -96px 0px;"></div>';
            } else
                if (SelectedSpliter == 3) {
                    _html = _html + '<div id="ActiveW1" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -120px -24px;"></div>';
                    _html = _html + '<div id="ActiveW2" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -144px 0px;"></div>';
                    _html = _html + '<div id="ActiveW3" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -168px 0px;"></div>';
                } else
                    if (SelectedSpliter == 4) {
                        _html = _html + '<div id="ActiveW1" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -192px -24px;"></div>';
                        _html = _html + '<div id="ActiveW2" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -216px 0px;"></div>';
                        _html = _html + '<div id="ActiveW3" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -240px 0px;"></div>';
                    } else
                        if (SelectedSpliter == 5) {
                            _html = _html + '<div id="ActiveW1" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -264px -24px;"></div>';
                            _html = _html + '<div id="ActiveW2" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -288px 0px;"></div>';
                            _html = _html + '<div id="ActiveW3" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -312px 0px;"></div>';
                        } else
                            if (SelectedSpliter == 6) {
                                _html = _html + '<div id="ActiveW1" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -336px -24px;"></div>';
                                _html = _html + '<div id="ActiveW2" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -360px 0px;"></div>';
                                _html = _html + '<div id="ActiveW3" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -384px 0px;"></div>';
                            } else
                                if (SelectedSpliter == 7) {
                                    _html = _html + '<div id="ActiveW1" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -408px -24px;"></div>';
                                    _html = _html + '<div id="ActiveW2" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -456px 0px;"></div>';
                                    _html = _html + '<div id="ActiveW3" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -432px 0px;"></div>';
                                    _html = _html + '<div id="ActiveW4" onclick="ActiveWindow(this.id);" class="ActiveW" style="background-image:url(../images/activew.png); background-position: -480px 0px;"></div>';
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
                    document.getElementById('div-gfimg').style.backgroundColor = 'Red';
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
function DrawLine_RouteNew(_lon2, _lat2, _lon1, _lat1, _ordNum, _name, _file, _len) {
    //alert(_lon2 + "  |  " + _lat2 + "  |  " + _lon1 + "  |  " + _lat1 + "  |  " + _ordNum + "  |  " + _name + "  |  " + _file + "  |  " + _id + "  |  " + _len);
    $.ajax({
        url: _file + ".aspx?lon1=" + _lon2 + "&lat1=" + _lat2 + "&lon2=" + _lon1 + "&lat2=" + _lat1 + "&len=" + _len,
        context: document.body,
        success: function (data) {
            var datTemp = data.substring(data.indexOf("route_geometry") + 18, data.indexOf("route_instructions") - 4).split("],[");
            $('#IDMarker_' + PointsOfRoute[_len + 1].id + '_' + _len)[0].children[1].value = Math.round((parseInt(data.substring(data.indexOf("distance") + 10, data.indexOf("total_time") - 2), 10) / 1000)) + " km";
            var _min = Math.round((parseInt(data.substring(data.indexOf("total_time") + 12, data.indexOf("start_point") - 2), 10) / 60));
            $('#IDMarker_' + PointsOfRoute[_len + 1].id + '_' + _len)[0].children[2].value = ~ ~(_min / 60) < 1 ? _min + " min" : (~ ~(_min / 60) + " h " + (_min % 60) + " min");
            var _lon = new Array();
            var _lat = new Array();
            _lon[0] = _lon2;
            _lat[0] = _lat2;
            var ii = 1;
            for (var i = 0; i < datTemp.length; i++) {
                _lon[ii] = datTemp[i].split(",")[1];
                _lat[ii] = datTemp[i].split(",")[0];
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
function DrawLine_Route(_lon2, _lat2, _lon1, _lat1, _ordNum, _name) {

    $.ajax({
        url: "getLinePoints.php?lon1=" + _lon2 + "&lat1=" + _lat2 + "&lon2=" + _lon1 + "&lat2=" + _lat1,
        context: document.body,
        success: function (data) {
            var datTemp = data.substring(data.indexOf("route_geometry") + 18, data.indexOf("route_instructions") - 4).split("],[");
            var _lon = new Array();
            var _lat = new Array();
            _lon[0] = _lon2;
            _lat[0] = _lat2;
            var ii = 1;
            for (var i = 0; i < datTemp.length; i++) {
                _lon[ii] = datTemp[i].split(",")[1];
                _lat[ii] = datTemp[i].split(",")[0];
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
    $.ajax({
        url: _file + ".aspx?lon1=" + _lon2 + "&lat1=" + _lat2 + "&lon2=" + _lon1 + "&lat2=" + _lat1,
        context: document.body,
        success: function (data) {
            var datTemp = data.substring(data.indexOf("route_geometry") + 18, data.indexOf("route_instructions") - 4).split("],[");
            $('#IDMarker_' + PointsOfRoute[parseInt(_ordNum, 10) + 1].id + '_' + _ordNum)[0].children[1].value = Math.round((parseInt(data.substring(data.indexOf("distance") + 10, data.indexOf("total_time") - 2), 10) / 1000)) + " km";
            var _min = Math.round((parseInt(data.substring(data.indexOf("total_time") + 12, data.indexOf("start_point") - 2), 10) / 60));
            $('#IDMarker_' + PointsOfRoute[parseInt(_ordNum, 10) + 1].id + '_' + _ordNum)[0].children[2].value = ~ ~(_min / 60) < 1 ? _min + " min" : (~ ~(_min / 60) + " h " + (_min % 60) + " min");
            var _lon = new Array();
            var _lat = new Array();
            _lon[0] = _lon2;
            _lat[0] = _lat2;
            var ii = 1;
            for (var i = 0; i < datTemp.length; i++) {
                _lon[ii] = datTemp[i].split(",")[1];
                _lat[ii] = datTemp[i].split(",")[0];
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
                lineFeatureRoute[_ordNum][i].layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>Рута</strong>'+event.target._style.VehID)}");
                lineFeatureRoute[_ordNum][i].layer.events.element.setAttribute("onmouseout", "HidePopup()");
            }
            if (_sw == 1) {
                for (var i = parseInt(_ordNum, 10) + 1; i < lineFeatureRoute.length - 1; i++) {
                    lineFeatureRoute[i] = lineFeatureRoute[i + 1];
                    lineFeatureRoute[i + 1] = "";
                }
                lineFeatureRoute = lineFeatureRoute.slice(0, i).concat(lineFeatureRoute.slice(i + 1));
            }
            HideWait();
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
            $('#' + _id1)[0].style.backgroundImage = "url('../images/keyBlue1.png')";
            $('#divOpt-' + _id).css({ display: 'block', cursor: 'pointer' });
            if (window.innerHeight - event.clientY < 115)
                $('#divOpt-' + _id).css({ top: (parseInt($('#divOpt-' + _id).css('top'), 10) - 105) + 'px' });
        } else {
            $('#' + _id1)[0].style.backgroundImage = "url('../images/keyBlue.png')";
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
        $('#' + _idVehOpt)[0].style.backgroundImage = "url('../images/keyBlue.png')";
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
        $('#' + _id1)[0].style.backgroundImage = "url('../images/keyBlue.png')";
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

function EnableDisable(_alid, _vehlist) {
    if ($('#menu-6').html() == null) {
        setTimeout("EnableDisable(" + _alid + ", " + _vehlist + ")", 1000);
    } else {
        $.ajax({
            url: "UpdateActive.aspx?id=" + _alid + "&a=0",
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
    }
}
function EnableDisableDISABLE(_alid, _vehlist) {
    $.ajax({
        url: "UpdateActive.aspx?id=" + _alid + "&a=1",
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
            $('#' + _id1)[0].style.backgroundImage = "url('../images/keyBlue1.png')";
            $('#divOpt-' + _id + '-disable').css({ display: 'block', cursor: 'pointer' });
            if (window.innerHeight - event.clientY < 115)
                $('#divOpt-' + _id + '-disable').css({ top: (parseInt($('#divOpt-' + _id + '-disable').css('top'), 10) - 105) + 'px' });
        } else {
            $('#' + _id1)[0].style.backgroundImage = "url('../images/keyBlue.png')";
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
        $('#' + _idVehOptdis)[0].style.backgroundImage = "url('../images/keyBlue.png')";
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
        $('#' + _id1)[0].style.backgroundImage = "url('../images/keyBlue.png')";
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
