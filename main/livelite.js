
var twopoint = '.';
if(window.location.href.indexOf("localhost") != -1)
{
	if(window.location.pathname.replace(/\//g, '').replace(/panorama/g, '') != "")
		twopoint = '..'
} else
{
	if(window.location.pathname.replace(/\//g, '') != "")
		twopoint = '..'
}

var DefMapType = 'GOOGLES'    //  GOOGLE, GOOGLES, OSM, YAHOO, BING
var MapType = []           //  GOOGLE, OSM, Yahoo, Bing

var Border = [];
var Boards = [];
var Maps = [];
var Markers = [];
var Vehicles = [];
var Car = [];
var Position = "";

var Timers = [];
Timers[0] = [];
Timers[1] = [];
Timers[2] = [];
Timers[3] = [];

var controls = [];
var vectors = [];
var InitLoad = false;

var DefMapZoom = 14;

function ParseCarStrFirst() {
    var c = Position.split("#");
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
function CarType(_id, _color, _lon, _lat, _reg){
	this.id = _id
	this.color = _color
	this.lon = _lon
	this.lat = _lat
	this.reg = _reg
	this.map0 = true
	this.map1 = false
	this.map2 = false
	this.map3 = false
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
function ParseCarStr(str){
	var c = str; 
	var p = c.split("|")
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
	_car.alarm = p[14];
	for (var j =0; j<Car.length; j++) {
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

function setLiveHeightAlarm() {
    var h = document.body.clientHeight;
    var w = document.body.clientWidth;
	//alert(h + "   " + w + "   -   " + document.body.offsetHeight + "  " + document.body.clientHeight);
	$('#live-table').css({ height: (h - 1) + 'px' });
    $('#div-map').css({ width: (w - 250) + 'px', height: (h - 1) + 'px', overview: 'hidden' });
    $('#div-menu').css({ height: (h - 50) + 'px' });
    if (Browser() == 'iPad') {
		$('#live-table').css({border: '1px solid #BBBBBB'});
    }
    if (Browser() == "Chrome")
        var _plus = 66;
    else
        var _plus = 33;
    $('#icon-legenda').css({ top: (document.body.offsetHeight - document.body.clientHeight + _plus) * (-1) + 'px' });
	//$('#icon-legenda').css({ top: (document.body.offsetHeight - document.body.clientHeight + 33) * (-1) + 'px' });
}
function ClearAllBoards() {
	Boards[0] = null
	Markers[0] = null
	if (MapType[0]==null) { MapType[0] = DefMapType }
	document.getElementById('div-map').innerHTML = '';
}
function CreateBoards() {
    var Parent = document.getElementById('div-map');

	ClearAllBoards();

	$('#div-activeBoard').remove();

    Boards[0] = Create(Parent, 'div', 'div-map-1');
    $(Boards[0]).css({ width: '100%', height: (Parent.offsetHeight) + 'px' });
    Border[0] = Create(Parent, 'div', 'div-border-1');
    //$(Border[0]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 5) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: (Browser() == "Firefox" ? '32' : '0') + 'px', border: '3px Solid #FF6633' });
    $(Border[0]).css({ position: 'absolute', display: 'none', zIndex: 998, background: 'transparent', width: ($(Boards[0])[0].clientWidth - 6) + 'px', height: ($(Boards[0])[0].clientHeight - 5) + 'px', left: (parseInt($('#race-img').css('left'), 10) > 200 ? '250' : '3') + 'px', top: '0px', border: '3px Solid #FF6633' });
}
function mapEvent(event) {
    //ResetTimers()
    //resetScreen[SelectedBoard] = true;
    //ResetTimersStep(0);
}
function eventClick(e) {
}
function LoadMaps() {
     for (var i = 0; i < 1; i++) {
         if (Boards[i] != null) {
             map = new OpenLayers.Map({ div: Boards[i].id, allOverlays: true,
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
             
             if (MapType[i] == 'GOOGLEM') { layer = new OpenLayers.Layer.Google("Google Streets") }
             if (MapType[i] == 'GOOGLES') { layer = new OpenLayers.Layer.Google("Google Satellite", { type: google.maps.MapTypeId.HYBRID }) }
             if (MapType[i] == 'GOOGLEP') { layer = new OpenLayers.Layer.Google("Google Physical", { type: google.maps.MapTypeId.TERRAIN }) }

             if (MapType[i] == 'OSMM') { layer = new OpenLayers.Layer.OSM() }
             if (MapType[i] == 'OSMS') { layer = new OpenLayers.Layer.OSM("OpenStreetMap (Tiles@Home)", "http://tah.openstreetmap.org/Tiles/tile/${z}/${x}/${y}.png") }

			 //GLOBSY MAPS
			 if (MapType[i] == 'YAHOOM') { layer = new OpenLayers.Layer.WMS( "OpenLayers WMS", "http://144.76.225.247:8080/geoserver/gwc/service/wms", {'layers': 'GeonetMaps', format: 'image/png'}); }
             //if (MapType[i] == 'YAHOOM') { layer = new OpenLayers.Layer.Yahoo("Yahoo Street") }
             if (MapType[i] == 'YAHOOS') { layer = new OpenLayers.Layer.WMS( "OpenLayers WMS", "./map.aspx", {'layers': 'basic'}); }

             if (MapType[i] == 'BINGM') { layer = new OpenLayers.Layer.Bing({ key: apiKey, type: "Road", metadataParams: { mapVersion: "v1"} }) }
             if (MapType[i] == 'BINGS') { layer = new OpenLayers.Layer.Bing({ key: apiKey, type: "AerialWithLabels", wrapDateLine: true }) }
             map.addLayers([layer]);

             //if (OpenForDrawing==true){   //CVETKOSKI
             var renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
             renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;
             vectors[i] = new OpenLayers.Layer.Vector("Vector Layer", {
                 renderers: renderer
             });
             map.addLayer(vectors[i]);

             /*selectControl = new OpenLayers.Control.SelectFeature(vectors[i],
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
                        handlerOptions: {
                            layerOptions: {
                                renderers: renderer
                            }
                        }
                    }
                ),
                select: selectControl // new OpenLayers.Control.SelectFeature(vectors[i])
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
             controls[i].select.activate();*/
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
             //AddLayerSwitcher(Boards[i], i);

             //if (AjaxStarted == false) { Ajax() }
             //if (RecStarted == true) { RecStert(1) }
         }

     }
     InitLoad = true
     for (var vc = 0; vc < Vehicles.length; vc++) {
         Vehicles[vc].Marker.display(false)
     }
     Vehicles = null
     Vehicles = []
     ResetTimers()
     InitLoad = false;
}
function ResetTimers() {
    for (var c = 0; c < Car.length; c++) {
        var _car = Car[c];
        for (var j = 0; j < 1; j++) {
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

	if(el.innerHTML.indexOf("gnMarker") == -1)
	{
		//el.innerHTML = '<div style="visibility: hidden;" class="impuls1"></div><div style="visibility: hidden;" class="impuls3 gnMarkerPulsing' + MarkerColor + '"></div><div class="gnMarker' + MarkerColor + ' text3"><strong>' + _vehicleNo + '</strong></div>';
		el.innerHTML = '<div class="gnMarker' + MarkerColor + ' text3"><strong>' + _vehicleNo + '</strong></div>';
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
	// Ova ne treba ako miruva //el.innerHTML += '<div class="gnMarkerPointer' + MarkerColor + '" style="left:' + 20 + 'px; top:' + 6 + 'px; height:6px; width:6px; position:absolute; display:box; font-size:4px"></div>'			
	//debugger;

	//setInterval($(".impuls").animate({left:'250px'});
	/*var glow = $('.impuls1');
	var glow1 = $('.impuls2');
	setInterval(function(){
	    glow.hasClass('glow') ? glow.removeClass('glow') : glow.addClass('glow');
	    glow1.hasClass('glow') ? glow1.removeClass('glow') : glow1.addClass('glow');
	}, 1500);*/
	
	//el.setAttribute("onmousemove","ShowPopup(event, '#vehicleList-"+_vehicleNo+"')")
	//el.setAttribute("onmouseout", "HidePopup()");
	//el.addEventListener('click', function(e) { AddPOI = true; VehClick = true; });

	Vehicle.Marker = MyM
	Vehicle.el = el
	Vehicles[vIndex] = Vehicle
	if (InitLoad==true) {
	    if (Vehicle.Marker.onScreen() == false) { Maps[_mapNo].zoomOut() }
	}
}
function zoomWorld(_t, _z) {
    if (vectors[0].features != "") {
        if(_t.map.layers[2].getDataExtent() < _t.map.layers[1].getDataExtent())
            _t.map.zoomToExtent(_t.map.layers[2].getDataExtent());
        else
            _t.map.zoomToExtent(_t.map.layers[1].getDataExtent());
    } else {
    	if(_t.map.layers[2].getDataExtent() != null)
        	_t.map.zoomToExtent(_t.map.layers[2].getDataExtent());
    	else
    		_t.map.setCenter(new OpenLayers.LonLat(StartLon, StartLat).transform(new OpenLayers.Projection("EPSG:4326"), _t.map.getProjectionObject()), _z);
//        _t.map.setCenter(new OpenLayers.LonLat(StartLon, StartLat).transform(new OpenLayers.Projection("EPSG:4326"), _t.map.getProjectionObject()), _z);
//        for (var i = 0; i < _t.map.layers[2].markers.length; i++)
//            if (_t.map.layers[2].markers[i].events.element.style.display != "none")
//                if (String(_t.map.layers[2].markers[i].lonlat.lon) != "NaN")
//                    if (!_t.map.layers[2].markers[i].onScreen()) {
//                        zoomWorld(_t, (_z - 1));
//                    }
    }
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
                
                $(this).dialog("close");
            }
        }
    });
}
function closeAlarmWindow()
{
	var _idC = _vehid+"_"+_dt.split(" ")[0].split("-")[0]+"_"+_dt.split(" ")[0].split("-")[1]+"_"+_dt.split(" ")[0].split("-")[2]+"_"+_dt.split(" ")[1].split(":")[0]+"_"+_dt.split(" ")[1].split(":")[1]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[0]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[1];
	if($("#alarmZabeleska").val() == '')
	{
		top.msgbox("Немате внесено забелешка!!!");
		$('#alarmZabeleska').attr({ className: 'shadow corner5' });
		$('#alarmZabeleska').css({ borderColor: 'Red' });
		$('#alarmZabeleska').focus();
		return false;
	} else
	{
		top.ShowWait();
		var note = $("#alarmZabeleska").val();
		$.ajax({
	        url: twopoint + "/main/UpdateNoteAndReadStatusForAlarm.php?dt=" + _dt + "&type=" + _type + "&reg=" + _reg + "&note=" + note,
	        context: document.body,
	        success: function (data) {
	        	if(data == "NotOk")
	        		top.msgbox("Алармот не е внесен прописно во базата!!!");
	        	if(top.document.getElementById("alarms") != null)
	        	{
		        	var c2 = 0;
		        	var c1 = 0;
		        	for(var i=0; i < top.$('#alarms').children().length; i++)
		        	{
		        		if(top.$('#alarms').children()[i].children[0].children[0].id == "alarm-small-"+_idC)
		        			c1 = i;
		        		if(top.$('#alarms').children()[i].children[0].children[0].style.backgroundImage.indexOf("yes1") != -1)
		        			c2 = i;
	        			
	        		}
	        		top.$('#alarms').children()[c1].attributes[0].value = top.$('#alarms').children()[c1].attributes[0].value.replace("OpenMapAlarm1","OpenMapAlarm2");
	        		if(c2==0)
	        			$(top.$('#alarms').children()[top.$('#alarms').children().length-1]).after($(top.$('#alarms').children()[c1]));
	    			else
	        			$(top.$('#alarms').children()[c2]).before($(top.$('#alarms').children()[c1]));
		        	top.$('#alarm-small-'+_idC).css({ backgroundImage: 'url("' + twopoint + '/images/yes1.png")' });
	        	}
	        	top.AlertEventHide1(_num, _dt, _reg, _type, _vehid);
	        	top.HideWait();
	        	top.$('#dialog-map').dialog('destroy');
	        }
		});
	}
}
function closeAlarmWindow1()
{
	//if(top.$('#dialog-map').length == 0)
		parent.$('#dialog-map').dialog('destroy');
	//else
//		top.$('#dialog-map').dialog('destroy');
}
function PleaseDrawArea(areaID, _color) {
    $.ajax({
        url: twopoint + "/main/getAreaPoints.php?id=" + areaID,
        context: document.body,
        success: function (data) {
            //var d = data.split("%^")[0].split("@");
            var d = data.split("%^")[0];
            d = d.substring(d.indexOf("((")+2, d.indexOf("))")).split(",");
            var _lon = ""; var _lat = "";
            for(var i=0; i<d.length; i++)
            {
            	_lon += d[i].split(" ")[1] + (i == (d.length-1) ? "" : ",");
            	_lat += d[i].split(" ")[0] + (i == (d.length-1) ? "" : ",");
            }
            var _name = data.split("%^")[1];
            var _avail = data.split("%^")[2];
            var _cant = data.split("%^")[3];
            var _gfgid = data.split("%^")[4];
            var _alarmsH = data.split("%^")[5];
            var _alarmsVeh = data.split("%^")[6];
            var ret = DrawPolygon(_lon, _lat, false, _color, _name, areaID, _avail, _cant, _gfgid, _alarmsH, _alarmsVeh);
            map.zoomToExtent(ret[0].geometry.bounds);
            HideWait();
        }
    });
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