// JavaScript Document
var myScrollMenu;
var lang = 'en'

function iPad_Refresh(){
	if (Browser()=='iPad') {
		setTimeout(function () {myScrollMenu.refresh(); myScrollContainer.refresh()}, 0);
	}
}

function OnMenuClick(id){
    var cls = document.getElementById('menu-' + id).className;
	if (cls=='menu-container-collapsed') {
		//
		document.getElementById('menu-title-'+id).className='menu-title text3'
		var h=document.getElementById('menu-container-'+id).offsetHeight
		h = h+20+20
		$('#menu-' + id).animate({ height: h + 'px' }, 'fast', function() { document.getElementById('menu-' + id).className = 'menu-container' });
		return
	} else {
		document.getElementById('menu-'+id).className='menu-container-collapsed'
		document.getElementById('menu-title-'+id).className='menu-title-collapsed text3'
		$('#menu-' + id).animate({ height: '33px' }, 'fast');
		return
	}
	iPad_Refresh()
}

function iPadSettings(){
	if (Browser()!='iPad') {
		document.getElementById('div-menu').className = 'scrollY'
	} else {
		var menuCont = $('#div-menu').html()
		$('#div-menu').html('<div id="scroll-menu-div"></div>')
		$('#scroll-menu-div').html(menuCont)
			
		myScrollMenu = new iScroll('scroll-menu-div');
		
		iPad_Refresh();
	}	
}

function getAddress(lon, lat, elID){
		return
		$.ajax({
		  url: "getGeocode.php?lat="+lat+"&lon="+lon,
		  context: document.body,
		  success: function(data){
			  $('#'+elID).html(data)
			//msgbox('')
		  }
		});	
}

function calcTime(offset) {
    offset = parseInt(offset, 10) + 1;
    // create Date object for current location
    d = new Date();

    // convert to msec
    // add local time zone offset
    // get UTC time in msec
    utc = d.getTime() + (d.getTimezoneOffset() * 60000);

    // create new Date object for different city
    // using supplied offset
    nd = new Date(utc + (3600000 * offset));

    // return time as a string
    return nd.toLocaleString();

}

function getCurrentTime() {
    var cT = calcTime(timeZone);
    var currentTime = new Date(Date(cT));
	var hours = currentTime.getHours()
	var minutes = currentTime.getMinutes()
	var sec = currentTime.getSeconds()
	
	if (minutes < 10)	minutes = "0" + minutes
	if (sec < 10)	sec = "0" + sec
	

	var currentDate = new Date()
  	var day = currentDate.getDate()
  	var month = currentDate.getMonth()
  	var year = currentDate.getFullYear()

	var mes = dic("mesec", lang).split(",");
	
	$('#span-time').html(hours + ":" + minutes + ':' + sec +'&nbsp;');
	$('#popup-time').html(day + "-" + mes[parseInt(month) + 1] + "-" + year + ' ' + hours + ":" + minutes + ':' + sec);
	setTimeout("getCurrentTime()", 1000);
}

function getCTime() {
    var cT = calcTime(timeZone);
    var currentTime = new Date(Date(cT));
	var hours = currentTime.getHours()
	var minutes = currentTime.getMinutes()
	var sec = currentTime.getSeconds()
	
	if (minutes < 10)	minutes = "0" + minutes
	if (sec < 10)	sec = "0" + sec
	
	var currentDate = new Date()
  	var day = currentDate.getDate()
  	var month = currentDate.getMonth()
  	var year = currentDate.getFullYear();

  	var mes = dic("mesec", lang).split(",");
	return '<div style="width:130px; text-align:center"><span class="text3">' + dic("CurrTimeDate", lang)  + '</span> <br><span id="popup-time">' + day + "-" + mes[parseInt(month) + 1] + "-" + year + ' ' + hours + ":" + minutes + ':' + sec + '</span></div>'
}

function OpenDrawingAreaWindow(){
	var zl = GetZoomLevel(0)
	var _lon=GetCenterOfMap(0).lon
	var _lat=GetCenterOfMap(0).lat
	
	var _w = document.body.clientWidth-60
	var _h = document.body.clientHeight-60

	$("#dialog-draw-area").dialog({ width: _w, height: _h, zIndex: 8888, modal: true, resizable: false });
	$('#ifrm-edit-areas').css({width:(_w-40)+'px', height:(_h-50)+'px'})
	document.getElementById('ifrm-edit-areas').src = 'DrawArea.aspx?zl='+zl+'&lon='+_lon+'&lat='+_lat
}

/*************************   UPDATE AREA   **********************************************/
function UpdateArea(_n, pts, _areaid, _avail, _cant, _gfgid, _col) {
    var _av = '0', _in = '0', _out = '0'
    for (var i = 0; i < VehcileIDs.length; i++) {
        if (document.getElementById('av_' + VehcileIDs[i]).checked == true) { _av = _av + ',' + VehcileIDs[i] }
        if (document.getElementById('in_' + VehcileIDs[i]).checked == true) { _in = _in + ',' + VehcileIDs[i] }
        if (document.getElementById('out_' + VehcileIDs[i]).checked == true) { _out = _out + ',' + VehcileIDs[i] }
    }
    var chk_1_in = '0', chk_1_out = '0', chk_2_in = '0', chk_2_out = '0';

    if (document.getElementById('chk_1_in').checked == true) { chk_1_in = '1' }
    if (document.getElementById('chk_1_out').checked == true) { chk_1_out = '1' }
    if (document.getElementById('chk_2_in').checked == true) { chk_2_in = '1' }
    if (document.getElementById('chk_2_out').checked == true) { chk_2_out = '1' }

    var ptsNew;
    if (pts.length > 1500)
        ptsNew = "0";
    else
        ptsNew = pts;
    var em = $('#txt_emails').val();
    var ph = $('#txt_phones').val();

    $.ajax({
        url: "AddAreaNew.php?id=" + _areaid + '&p=' + ptsNew + '&n=' + _n + '&avail=' + _avail + '&cant=' + _cant + '&gfgid=' + _gfgid + '&av=' + _av + '&in=' + _in + '&out=' + _out + '&in1=' + chk_1_in + '&out1=' + chk_1_out + '&in2=' + chk_2_in + '&out2=' + chk_2_out + '&e=' + em + '&ph=' + ph + '&l=' + lang,
        context: document.body,
        success: function (data) {
            var dat = data.split("&&@^");
            
            for (var cz = 0; cz <= cntz; cz++) {
                if (document.getElementById("zona_" + cz) != null)
                    if ($('#zona_' + cz)[0].attributes[1].nodeValue.indexOf(_areaid) != -1) {
                        $($('#zona_' + cz)[0].nextSibling).html(_n);
                        //$('#zona_' + cz)[0].nextSibling.innerHTML = _n;
                        //$('#zona_' + cz)[0].nextSibling.attributes[1].nodeValue = "DrawZoneOnLive1('" + _areaid + "', '" + _col + "', 'zona_" + cz + "')";
                        break;
                    }
            }
            $('#div-al-GeoFence').dialog('destroy');
            $('#div-enter-zone-name').dialog('destroy');
            if (ptsNew == "0") {
                var arr = new Array();
                for (var i = 1; i <= (parseInt(pts.split("^").length / 25, 10) + (pts.split("^").length / 25 > parseInt(pts.split("^").length / 25, 10) ? 1 : 0)); i++) {
                    arr[i] = "";
                    for (var j = ((i - 1) * 25) + 1; j < i * 25; j++) {
                        if (pts.split("^")[j] == undefined)
                            break;
                        arr[i] += "^" + pts.split("^")[j];
                    }
                }
                recurs(i, arr, dat[0], _areaid, dat[1], '0');
            } else {
                for (var z = 0; z < Maps.length; z++) {
                    //if (z != SelectedBoard) {
                    for (var k = 0; k < vectors[z].features.length; k++) {
                        if (vectors[z].features[k].style.name == selectedFeature[SelectedBoard].style.name) {
                            cancelFeature[z] = false;
                            controls[z].modify.deactivate();
                            if (document.getElementById("div-polygon-menu-" + z) != null)
                                removeEl(document.getElementById("div-polygon-menu-" + z).id);
                            ArrAreasPoly[z][k] = "";
                            vectors[z].features[k].destroy();
                            PleaseDrawAreaAgainSB(_areaid, dat[1], z, k);
                            break;
                        }
                    }
                    //}
                }
                HideWait();
                msgbox(dat[0]);
            }
            //cancelFeature[SelectedBoard] = false;
            //onFeatureUnselect('0');
            //selectedFeature[SelectedBoard].destroy();
            //PleaseDrawAreaAgainSB(_areaid, _col, SelectedBoard);

        }
    });
}


/*************************   ADD AREA   **********************************************/

function recurs(p1, arr, _msg, dat0, dat1, _sk) {
    p1--;
    if (p1 < 1) {
        $.ajax({
            url: "AddAreaPoints.php?ida=" + dat0,
            context: document.body,
            success: function () {
                if (_sk == "1") {
                    CancelDrawingArea(SelectedBoard);
                    PleaseDrawAreaAgain(dat0, dat1);
                } else {
                    for (var z = 0; z < Maps.length; z++) {
                        //if (z != SelectedBoard) {
                        for (var k = 0; k < vectors[z].features.length; k++) {
                            if (vectors[z].features[k].style.name == selectedFeature[SelectedBoard].style.name) {
                                cancelFeature[z] = false;
                                controls[z].modify.deactivate();
                                if (document.getElementById("div-polygon-menu-" + z) != null)
                                    removeEl(document.getElementById("div-polygon-menu-" + z).id);
                                ArrAreasPoly[z][k] = "";
                                vectors[z].features[k].destroy();
                                PleaseDrawAreaAgainSB(dat0, dat1, z, k);
                                break;
                            }
                        }
                        //}
                    }
                }
                HideWait();
                msgbox(_msg);
                return // exit condition
            }
        });
        return // exit condition
    }
    $.ajax({
        url: "AddAreaPointsTemp.php?idx=" + p1 + "&points=" + arr[p1] + "&ida=" + dat0,
        context: document.body,
        success: function () {
            recurs(p1, arr, _msg, dat0, dat1, _sk);
        }
    });
}

function SavingNewArea(pts) {
    var _av = '0', _in = '0', _out = '0'
    for (var i = 0; i < VehcileIDs.length; i++) {
        if (document.getElementById('av_' + VehcileIDs[i]).checked == true) { _av = _av + ',' + VehcileIDs[i] }
        if (document.getElementById('in_' + VehcileIDs[i]).checked == true) { _in = _in + ',' + VehcileIDs[i] }
        if (document.getElementById('out_' + VehcileIDs[i]).checked == true) { _out = _out + ',' + VehcileIDs[i] }
    }
    var areaName = $('#txt_zonename').val()
    var chk_1_in = '0', chk_1_out = '0', chk_2_in = '0', chk_2_out = '0';

    if (document.getElementById('chk_1_in').checked == true) { chk_1_in = '1' }
    if (document.getElementById('chk_1_out').checked == true) { chk_1_out = '1' }
    if (document.getElementById('chk_2_in').checked == true) { chk_2_in = '1' }
    if (document.getElementById('chk_2_out').checked == true) { chk_2_out = '1' }

    var em = $('#txt_emails').val();
    var ph = $('#txt_phones').val();
    var avail;
    for (var i = 1; i <= 2; i++) {
        if (document.getElementById("GFcheck" + i).checked) {
            avail = i;
            break;
        }
    }

    var ptsNew;
    if (pts.length > 1500)
        ptsNew = "0";
    else
        ptsNew = pts;
    var _utl = 'n=' + areaName + '&av=' + _av + '&in=' + _in + '&avail=' + avail + '&ppgid=' + $('#gfGroup dt a')[0].title + '&cant=' + $('#GFcheck3').attr('checked') + '&out=' + _out + '&in1=' + chk_1_in + '&out1=' + chk_1_out + '&in2=' + chk_2_in + '&out2=' + chk_2_out + '&e=' + em + '&ph=' + ph + '&p=' + ptsNew + '&l=' + lang;

    $.ajax({
        url: "AddArea.php?" + _utl,
        context: document.body,
        success: function (data) {
            var dat = data.split("&&@^");
			
            var d = document.getElementById("add_del_geofence");
            if (d != null) {
                var _div = document.createElement("div");
                _div.setAttribute("id", "newGF_" + dat[0]);
                _div.className = "text5";
                _div.style.width = "94%";
                _div.style.border = "1px solid #95b1d7";
                _div.style.backgroundColor = "#c6d7f2";
                _div.style.marginBottom = "5px";
                _div.style.overflow = "auto";
                d.appendChild(_div);
                var _input = document.createElement("input");
                //_input.title = dat[0];
                _input.setAttribute("id", "zona_" + (cntz + 1));
                _input.type = "checkbox";
                _input.checked = "checked";
                _input.setAttribute("onchange", "if (this.checked == true) { checkGF('1'); DrawZoneOnLive('" + dat[0] + "', '" + dat[1] + "'); } else { checkGF('0'); RemoveFeature('" + dat[0] + "'); }");
                _div.appendChild(_input);
                var _span = document.createElement("span");
                _span.style.cursor = "pointer";
                _span.innerHTML = $('#txt_zonename').val();
                _span.setAttribute("onclick", "DrawZoneOnLive1('" + dat[0] + "', '" + dat[1] + "', 'zona_" + (cntz + 1) + "')");
                _div.appendChild(_span);
                var _br = document.createElement("br");
                _div.appendChild(_br);
                var _d1 = document.createElement("div");
                _d1.setAttribute("id", "geo-fence-" + dat[0]);
                _div.appendChild(_d1);
            }
            cntz = cntz + 1;
            if (ptsNew == "0") {
                var arr = new Array();
                for (var i = 1; i <= (parseInt(pts.split("^").length / 25, 10) + (pts.split("^").length / 25 > parseInt(pts.split("^").length / 25, 10) ? 1 : 0)); i++) {
                    arr[i] = "";
                    for (var j = ((i - 1) * 25) + 1; j < i * 25; j++) {
                        if (pts.split("^")[j] == undefined)
                            break;
                        arr[i] += "^" + pts.split("^")[j];
                    }
                }
                recurs(i, arr, dat[0], dat[1], dat[2], '1');
                //function recurs(p1, arr, _msg, ida, dat0, dat1, _sk) {
            } else {
                CancelDrawingArea(SelectedBoard);
                PleaseDrawAreaAgain(dat[1], dat[2]);
                HideWait();
                msgbox(dat[0]);
            }
            $('#div-enter-zone-name').dialog('destroy');
            $('#div-al-GeoFence').dialog('destroy');
            $('#save1-button-0').css({ display: 'none' });
            $('#cancel1-button-0').css({ display: 'none' });
            $('#separator-button-0').css({ display: 'none' });
        }
    });
}

function Cancel2Click(){
		$('#edit-button-').css({color:'#ffffff', cursor:'pointer'})
		$('#save2-button-').css({display:'none'})
		$('#cancel2-button-').css({display:'none'})	
		ClearGraphic()
}
function ShowGeoFenceList() {
	if ($('#edit-button-').css("color")+''=='rgb(255, 255, 255)') {
		
//		$('#edit-button-').css({color:'#000066', cursor:'default'})
//		$('#save2-button-').css({display:'block'})
//		$('#cancel2-button-').css({display:'block'})		

		$.ajax({
		  url: "ListAreas.aspx",
		  context: document.body,
		  success: function(data){
		  	
		  		
			 $('#div-area-list').html(data)
			 $('#btnDelete').button({ icons: { primary: "ui-icon-cancel"} });
			 $('#btnEditAreaName').button({ icons: { primary: "ui-icon-pencil"} });
			 $('#div-area-list').dialog({ modal: true, width: 320, height: 340, resizable: false,
					buttons: {
						OK: function() {
							msgbox('Click on the GeoFence to make changes and after that click <strong>Save</strong> button')
							$('#edit-button-').css({color:'#000066', cursor:'default'})
							$('#save2-button-').css({display:'block'})
							$('#cancel2-button-').css({display:'block'})
							
							$( this ).dialog( "close" );
							PleaseDrawArea($('#lbAreas').val(), _color)
						},
						Cancel: function() {
							$( this ).dialog( "close" );
						}
					}// Buttons						
			 })	
		  }
		});	
	
	}
	
}
var GlobalSelectedAreaID = 0
function PleaseDrawArea(areaID, _color){
	GlobalSelectedAreaID = areaID
	$.ajax({
	  url: "getAreaPoints.php?id="+areaID,
	  context: document.body,
	  success: function(data){
		 var d = data.split("@")
		 ClearGraphic()
		 DrawPolygon(d[0], d[1], false, _color)
		 toggleControl('modify', true)
	  }
	});	
	
}

var GlobalTempArea;

function AddAreaToArray(_Feature, areaID) {
    for (var z = 0; z < Maps.length; z++) {
        if (ArrAreasPoly[z] == undefined) {
            ArrAreasPoly[z] = new Array();
            ArrAreasId[z] = new Array();
            ArrAreasCheck[z] = new Array();
        }
        ArrAreasPoly[z].push(_Feature[z]);
        ArrAreasId[z].push(areaID);
        ArrAreasCheck[z].push(1);
    }
}

function RemoveAllFeature() {
    for (var z = 0; z < Maps.length; z++) {
        if (ArrAreasId[z] != undefined) {
            for (var i = 0; i < ArrAreasId[z].length; i++) {
                try {
                    vectors[z].removeFeatures([ArrAreasPoly[z][i]]);
                    ArrAreasCheck[z][i] = 0;
                } catch (err) { }
            }
        }
    }
}

function RemoveFeature(areaID) {
    for (var z = 0; z < Maps.length; z++) {
        if (ArrAreasId[z] != undefined) {
            for (var i = 0; i < ArrAreasId[z].length; i++) {
                if (ArrAreasId[z][i] == areaID) {
                    try {
                        vectors[z].removeFeatures([ArrAreasPoly[z][i]]);
                        ArrAreasCheck[z][i] = 0;
                    } catch (err) { }
                }
            }
        }
    }
}
function DrawZoneOnLive1(areaID, _color, _id) {
    $('#' + _id).attr({ checked: true });
    var tf = 0;
    if (ArrAreasId != "") {
        for (var z = 0; z < Maps.length; z++) {
            if (ArrAreasId[z] != undefined) {
                for (var i = 0; i < ArrAreasId[z].length; i++) {
                    if (ArrAreasId[z][i] == areaID) {
                        vectors[z].addFeatures([ArrAreasPoly[z][i]]);
                        controls[z].select.activate();
                        ArrAreasCheck[z][i] = 1;
                        tf = 1;
                        //Maps[z].zoomToExtent(ArrAreasPoly[z][i].layer.getDataExtent());
                        Maps[z].zoomToExtent(ArrAreasPoly[z][i].geometry.bounds);
                    }
                }
            }
        }
        HideWait();
    }
    if (tf == 0) { PleaseDrawAreaAgain1(areaID, _color) }
}
//polygonFeature
function PleaseDrawAreaAgain1(areaID, _color) {
    GlobalTempArea = areaID;
    $.ajax({
        url: "getAreaPoints.php?id=" + areaID,
        context: document.body,
        success: function (data) {
            var d = data.split("%^")[0].split("@");
            var _name = data.split("%^")[1];
            var _avail = data.split("%^")[2];
            var _cant = data.split("%^")[3];
            var _gfgid = data.split("%^")[4];
            var _alarmsH = data.split("%^")[5];
            var _alarmsVeh = data.split("%^")[6];
            var ret = DrawPolygon(d[0], d[1], false, _color, _name, areaID, _avail, _cant, _gfgid, _alarmsH, _alarmsVeh);
            AddAreaToArray(ret, areaID);
            map.zoomToExtent(ret[0].geometry.bounds);
            HideWait();
        }
    });
}
function DrawZoneOnLive(areaID, _color){
    var tf = 0;
    if (ArrAreasId != "") {
        for (var z = 0; z < Maps.length; z++) {
            if (ArrAreasId[z] != undefined) {
                for (var i = 0; i < ArrAreasId[z].length; i++) {
                    if (ArrAreasId[z][i] == areaID) {
                        vectors[z].addFeatures([ArrAreasPoly[z][i]]);
                        controls[z].select.activate();
                        ArrAreasCheck[z][i] = 1;
                        tf = 1;
                        Maps[z].zoomToExtent(ArrAreasPoly[z][i].layer.getDataExtent());
                    }
                }
            }
        }
        HideWait();
    }
    if (tf == 0) { PleaseDrawAreaAgain(areaID, _color) }
}
//polygonFeature
function PleaseDrawAreaAgain(areaID, _color) {
    GlobalTempArea = areaID;
    $.ajax({
        url: "getAreaPoints.php?id=" + areaID,
        context: document.body,
        success: function (data) {
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
            AddAreaToArray(ret, areaID);
            //debugger;
            //var bounds = new OpenLayers.Bounds();
            //bounds.extend(ret[0].layer.getDataExtent());
            map.zoomToExtent(ret[0].layer.getDataExtent());
            HideWait();
        }
    });
}
//polygonFeature
function PleaseDrawAreaAgainSB(areaID, _color, _sb, _k) {
    GlobalTempArea = areaID;
    $.ajax({
        url: "getAreaPoints.php?id=" + areaID,
        context: document.body,
        success: function (data) {
        	data = data.replace("\r\n", "");
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
            
            var ret = DrawPolygonSB(_lon, _lat, false, _color, _name, areaID, _avail, _cant, _gfgid, _alarmsH, _alarmsVeh, _sb);
            ArrAreasPoly[_sb][_k] = ret[_sb];
            ArrAreasId[_sb][_k] = areaID;
            //var bounds = new OpenLayers.Bounds();
            //for (var x in ret[0].layer.selectedFeatures) {
            //bounds.extend(ret[0].geometry.getBounds());
            //}
            //var center = bounds.getCenterLonLat(); <-- you don't really need this if you want to zoom. But it will give you the center lat long coords.
            map.zoomToExtent(ret[0].layer.getDataExtent());
            //AddAreaToArray(ret, areaID);
            HideWait();
        }
    });
}

function SaveModifyArea(){
	var strPoints = ''
	for(var i=0; i<vectors[0].features[0].geometry.components[0].components.length-1; i++){
		var _point =  vectors[0].features[0].geometry.components[0].components[i]
		_point.transform(Maps[0].getProjectionObject(), new OpenLayers.Projection("EPSG:4326") );
		strPoints = strPoints+'^'+_point.x+'@'+_point.y
	}	
	$.ajax({
	  url: "AddAreaNew.aspx?id="+GlobalSelectedAreaID+'&p='+strPoints,
	  context: document.body,
	  success: function(data){
		 Cancel2Click()
		 msgbox(data)
	  }
	});

}
/*************************   EDIT AREA   **********************************************/
function ShowGeoFenceListAlarms(){	

		$.ajax({
		  url: "ListAreas.aspx",
		  context: document.body,
		  success: function(data){
			 $('#div-area-list').html(data)
			 $('#btnDelete').button({ icons: { primary: "ui-icon-cancel"} });
			 $('#btnEditAreaName').button({ icons: { primary: "ui-icon-pencil"} });

			 $('#div-area-list').dialog({ modal: true, width: 320, height: 340, resizable: false,
					buttons: {
						OK: function() {
							//PleaseDrawArea($('#lbAreas').val())
							$( this ).dialog( "close" );
							ChangeAlarms($('#lbAreas').val())
						},
						Cancel: function() {
							$( this ).dialog( "close" );
						}
					}// Buttons						
			 })	
		  }
		  
		});	
}


function ChangeAlarms(areaID){
	//div-edit-zone-
	GlobalSelectedAreaID= areaID
	$.ajax({
		  url: "GetEditArea.aspx?id="+areaID,
		  context: document.body,
		  success: function(data){
			 $('#div-edit-zone-').html(data)
			 $('#div-edit-zone-').dialog({ modal: true, zIndex: 9999, width: 590, height: 530, resizable: false,
					buttons: {
						Update: function() {
							//SavingEditingArea()
							$( this ).dialog( "close" );
						},
						Cancel: function() {
							$( this ).dialog( "close" );
						}
					}// Buttons						
			 })	
		  }
		  
		});	
	
	
}

function SavingEditingArea(){

	var _av='0', _in='0', _out='0'
	
	for (var i=0; i<VehcileIDs.length; i++){
		if (document.getElementById('av1_'+VehcileIDs[i]).checked==true) {_av = _av +','+ VehcileIDs[i]}
		if (document.getElementById('in1_'+VehcileIDs[i]).checked==true) {_in = _in +','+ VehcileIDs[i]}
		if (document.getElementById('out1_'+VehcileIDs[i]).checked==true) {_out = _out +','+ VehcileIDs[i]}
	}

	var chk_1_in ='0', chk_1_out ='0', chk_2_in ='0', chk_2_out ='0'
	
	if (document.getElementById('chk_1_in1').checked==true) {chk_1_in ='1'}
	if (document.getElementById('chk_1_out1').checked==true) {chk_1_out ='1'}
	if (document.getElementById('chk_2_in1').checked==true) {chk_2_in ='1'}
	if (document.getElementById('chk_2_out1').checked==true) {chk_2_out ='1'}
	
	var em = $('#txt_emails1').val(); var ph = $('#txt_phones1').val(); 
	
	var _utl = 'id='+GlobalSelectedAreaID+'&av='+_av+'&in='+_in+'&out='+_out+'&in1='+chk_1_in+'&out1='+chk_1_out+'&in2='+chk_2_in+'&out2='+chk_2_out+'&e='+em+'&ph='+ph
	$.ajax({
	  url: "EditArea.aspx?"+_utl,
	  context: document.body,
	  success: function(data){
		 msgbox(data)
	  }
	});	

}


/*************************   GET VEHICLE AREA   **********************************************/

function getVehicleArea() {
    //getPaths()
    $.ajax({
        url: "getVehicleArea.aspx?",
        context: document.body,
        success: function (data) {
            var d = data.split("#");
            for (var i = 1; i < data.length; i++) {
                try {
                    var a = d[i].split(":")
                    $('#geo-fence-' + a[0]).html("")

                    if (a.length == 2) {
                        var b = a[1].split(",")
                        var str = ''
                        for (var j = 1; j < b.length; j++) {
                            var cname = document.getElementById('vh-small-' + b[j]).className
                            str = str + '<div style="float:left; width:16px; height:16px; margin-left:2px; margin-bottom:2px; cursor:pointer" onclick="FindVehicleOnMap0(' + b[j] + ')" class="' + cname + '">' + b[j] + '</div>'
                        }
                        $('#geo-fence-' + a[0]).html(str)
                    }
                } catch (errrr) { }
            }
        }
    });
}

function DeleteArea(){
	
	$('#div-msgbox').html('Do you want to delete this GeoFence')
	$('#dialog-message').dialog({ modal: true, width: 320, height: 180, resizable: false,
			buttons: {
				Yes: function() {
					var id = $('#lbAreas').val()
					$('#area_list_'+id).remove()
					$( this ).dialog( "close" );
					$.ajax({
					  url: "DeleteArea.aspx?id="+id,
					  context: document.body,
					  success: function(data){
						 msgbox(data)
					  }
					});	
				},
				No: function() {
					$( this ).dialog( "close" );
				}
			}// Buttons						
	 })	
}
function EditAreaName(){
	var selid = $('#lbAreas').val()
	var _zname = $('#area_list_'+selid).html()
	$('#div-msgbox').html('GeoFence name&nbsp;<input id="txt_area_name" type="text"  value="'+_zname+'" class="textboxcalender corner5 text5" style="width:230px; height:22px; font-size:11px"/>')
	$('#dialog-message').dialog({ modal: true, width: 320, height: 180, resizable: false,
			buttons: {
				Save: function() {
					var id = $('#lbAreas').val()
					var _name = $('#txt_area_name').val()
					//UpdateAreaName.aspx
					$.ajax({
					  url: "UpdateAreaName.aspx?id="+id+"&n="+_name,
					  context: document.body,
					  success: function(data){
					  	$('#area_list_'+$('#lbAreas').val()).html($('#txt_area_name').val())
						 msgbox(data)
					  }
					});						
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}// Buttons						
	 })	
}

/**********************GET PATHS ***********/

var GlobalDrawPath = 1;
function getPaths() {
    //return false;
    //if (LastPointsLon != "") return false;
    if (ShowHideTrajectory == false) { return }
    $.ajax({
        url: "getPaths.php",
        context: document.body,
        success: function (data) {
            ClearGraphic();
            var d = unzip(data).split("@");
            for (var i = 1; i < d.length; i++) {
                var a = d[i].split(":");
                var b = a[1].split("#");
                if (tmpCheckGroup[1] != undefined) {
                    if (tmpCheckGroup[1][i] == 1) {
                        DrawPath(b[1], b[0], a[0]);
                    } else {
                        var _nothing = "";
                    }
                } else {
                    DrawPath(b[1], b[0], a[0]);
                }
            }
            HideWait();
        }
    });
}

function OnClickSHTrajectory(){
    PathPerVeh = [];
    if (ShowHideTrajectory == true) {
        ShowHideTrajectory = false;
        var s = 1;
        while (document.getElementById("1_checkRow" + s) != null) {
            tmpCheckGroup[1][s] = 0;
            s++;
        }
        $('#icon-draw-path').css({ backgroundPosition: '0px -24px' });
        ClearGraphic();
        return
    } else {
        ShowWait();
        var s = 1;
        while (document.getElementById("1_checkRow" + s) != null) {
            tmpCheckGroup[1][s] = 1;
            s++;
        }
        $('#icon-draw-path').css({ backgroundPosition: '0px 0px' });
        ShowHideTrajectory = true;
        return
    }
}

function LoadAllZone() {
    if (ShowHideZone == true) {
        ShowHideZone = false;
        for (var cz = 0; cz <= cntz; cz++)
            if (document.getElementById("zona_" + cz) != null)
                $('#zona_' + cz)[0].checked = false;

        var s = 1;
        while (document.getElementById("2_checkRow" + s) != null) {
            tmpCheckGroup[2][s] = 0;
            s++;
        }
        if (document.getElementById('icon-draw-zone') != null)
            $('#icon-draw-zone').css({ backgroundPosition: '0px -72px' });
        else
            if (document.getElementById('div-gfimg') != null)
                document.getElementById('div-gfimg').style.backgroundColor = 'Red';
        RemoveAllFeature();
        for (var i = 0; i < 4; i++)
            if (Maps[i] != null) {
                CancelDrawingArea(i);
                controls[i].modify.deactivate();
                if (document.getElementById("div-polygon-menu-" + i) != null)
                    removeEl(document.getElementById("div-polygon-menu-" + i).id);
            }
        return
    } else {
        var s = 1;
        while (document.getElementById("2_checkRow" + s) != null) {
            tmpCheckGroup[2][s] = 1;
            s++;
        }
        for (var cz = 0; cz <= cntz; cz++)
            if (document.getElementById("zona_" + cz) != null)
                $('#zona_' + cz)[0].checked = true;
        if (document.getElementById('icon-draw-zone') != null)
            $('#icon-draw-zone').css({ backgroundPosition: '0px -48px' });
        else
            if (document.getElementById('div-gfimg') != null)
                document.getElementById('div-gfimg').style.backgroundColor = '#00ff00';
        ShowHideZone = true;
        LoadZone('All');
        return
    }
}


function getLeftList() {
	ShowWait()
	$.ajax({
	    url: "getLeftList.php?l="+lang,
	    context: document.body,
	    success: function (data) {
	        getLeftListDisabled();
	        var _html = $('#div-menu').html()
	        $('#div-menu').html(_html + data)
	        for (var cz = 0; cz <= cntz; cz++) {
	            if (document.getElementById("zona_" + cz) != null)
	                document.getElementById('zona_' + cz).checked = false;
	        }
	        LoadCurrentPosition = true
	        AjaxStarted = false
	        Ajax();
	        HideWait();
	    },
	    error: function () {
	        HideWait();
	        setTimeout("getLeftList();", 2000);
	    }
	});

}
function getLeftListDisabled() {
    ShowWait()
    $.ajax({
        url: "getLeftListD.php?l=" + lang,
        context: document.body,
        success: function (data) {
            var _html = $('#div-menu').html()
            $('#div-menu').html(_html + data);
            HideWait();
        },
        error: function () {
            HideWait();
            setTimeout("getLeftListDisabled();", 2000);
        }
    });

}
function shleft() {
    if (parseInt($('#race-img').css('left'), 10) > 200) {
        document.getElementById("vehicle-list").style.width = '3px';
        var w = document.body.clientWidth
        $('#div-menu').css({ width: '1px' });
        $('#div-map').css({ width: (w - 3) + 'px' });
        var _l1 = 3;
        var _w = new Array();
        if (SelectedSpliter == "0")
            _w[0] = -6;
        else
            if (SelectedSpliter == "1") {
                _w[0] = -6;
                _w[1] = -6;
            }
            else
                if (SelectedSpliter == "2") {
                    _w[0] = -8;
                    _w[1] = 0;
                }
                else
                    if (SelectedSpliter == "3") {
                        _w[0] = -7;
                        _w[1] = 0;
                        _w[2] = -6;
                    }
                    else
                        if (SelectedSpliter == "4") {
                            _w[0] = -6;
                            _w[1] = -7;
                            _w[2] = 2;
                        }
                        else
                            if (SelectedSpliter == "5") {
                                _w[0] = -6;
                                _w[1] = -6;
                                _w[2] = -2;
                            }
                            else
                                if (SelectedSpliter == "6") {
                                    _w[0] = -8;
                                    _w[1] = -2;
                                    _w[2] = -2;
                                }
                                else
                                    if (SelectedSpliter == "7") {
                                        _w[0] = -6;
                                        _w[1] = -6;
                                        _w[2] = 0;
                                        _w[3] = 0;
                                    }
        if ($('#div-map-1')[0] != undefined)
            $('#div-border-1').css({ width: ($('#div-map-1')[0].offsetWidth + _w[0]) + 'px', left: _l1 + 'px' });
        if ($('#div-map-2')[0] != undefined)
            $('#div-border-2').css({ width: ($('#div-map-2')[0].offsetWidth + _w[1]) + 'px', left: ($('#div-map-2')[0].offsetLeft) + (SelectedSpliter == "3" ? 4 : _l1) + 'px' });
        if ($('#div-map-3')[0] != undefined)
            $('#div-border-3').css({ width: ($('#div-map-3')[0].offsetWidth + _w[2]) + 'px', left: ($('#div-map-3')[0].offsetLeft) + ((SelectedSpliter == "4" || SelectedSpliter == "5") ? 4 : _l1) + 'px' });
        if ($('#div-map-4')[0] != undefined)
            $('#div-border-4').css({ width: ($('#div-map-4')[0].offsetWidth + _w[3]) + 'px', left: ($('#div-map-4')[0].offsetLeft) + _l1 + 'px' });
        $('#race-img').css({ backgroundPosition: '0px 0px' });
        $('#race-img').css({ left: '3px' });
        setCookie(_userId + "_shLeft", "0", 14);
        //CreateBoards();
        //LoadMaps();
        //ShowActiveBoard();
    } else {
        document.getElementById("vehicle-list").style.width = '248px';
        var w = document.body.clientWidth;
        var _w = new Array();
        if (SelectedSpliter == "0")
            _w[0] = -6;
        else
            if (SelectedSpliter == "1") {
                _w[0] = -6;
                _w[1] = -6;
            }
            else
                if (SelectedSpliter == "2") {
                    _w[0] = -8;
                    _w[1] = -1;
                }
                else
                    if (SelectedSpliter == "3") {
                        _w[0] = -7;
                        _w[1] = -1;
                        _w[2] = -6;
                    }
                    else
                        if (SelectedSpliter == "4") {
                            _w[0] = -6;
                            _w[1] = -7;
                            _w[2] = 0;
                        }
                        else
                            if (SelectedSpliter == "5") {
                                _w[0] = -6;
                                _w[1] = -6;
                                _w[2] = -3;
                            }
                            else
                                if (SelectedSpliter == "6") {
                                    _w[0] = -8;
                                    _w[1] = -3;
                                    _w[2] = -3;
                                }
                                else
                                    if (SelectedSpliter == "7") {
                                        _w[0] = -6;
                                        _w[1] = -6;
                                        _w[2] = -2;
                                        _w[3] = -2;
                                    }
        $('#div-menu').css({ width: '248px' });
        $('#div-map').css({ width: (w - 250) + 'px' });
        if ($('#div-map-1')[0] != undefined)
            $('#div-border-1').css({ width: ($('#div-map-1')[0].offsetWidth + _w[0]) + 'px', left: '250px' });
        if ($('#div-map-2')[0] != undefined)
            $('#div-border-2').css({ width: ($('#div-map-2')[0].offsetWidth + _w[1]) + 'px', left: ($('#div-map-2')[0].offsetLeft) + (SelectedSpliter == "3" ? 251 : 250) + 'px' });
        if ($('#div-map-3')[0] != undefined)
            $('#div-border-3').css({ width: ($('#div-map-3')[0].offsetWidth + _w[2]) + 'px', left: ($('#div-map-3')[0].offsetLeft) + ((SelectedSpliter == "4" || SelectedSpliter == "5") ? 251 : 250) + 'px' });
        if ($('#div-map-4')[0] != undefined)
            $('#div-border-4').css({ width: ($('#div-map-4')[0].offsetWidth + _w[3]) + 'px', left: ($('#div-map-3')[0].offsetLeft) + 250 + 'px' });
        $('#race-img').css({ backgroundPosition: '-8px 0px' });
        $('#race-img').css({ left: '250px' });
        setCookie(_userId + "_shLeft", "1", 14);
        //CreateBoards();
        //LoadMaps();
        //ShowActiveBoard();
    }

}

function AddMarkerS2(num, _pp) {
	if (tmpSearchMarker != undefined) {
        Markers[num].removeMarker(tmpSearchMarker);
    }
	if (Boards[num] != null) {
		tmpSearchMarker = "";
        var _ppp = unescape(_pp).split('|');
        var size = new OpenLayers.Size(16, 16);
        var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
        var icon = new OpenLayers.Icon('./blank.png', size, null, calculateOffset);

        var ll = new OpenLayers.LonLat(parseFloat(_ppp[0]), parseFloat(_ppp[1])).transform(new OpenLayers.Projection("EPSG:4326"), Maps[num].getProjectionObject())
        if (MapType[num] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_ppp[0]), parseFloat(_ppp[1])) }
        var MyMar = new OpenLayers.Marker(ll, icon)
        var markers = Markers[num];
        markers.addMarker(MyMar);
        MyMar.events.element.style.zIndex = 666
        tmpSearchMarker = MyMar;
        if (_ppp[7] == "1")
            var _color = 'ff0000';
        else
            var _color = _ppp[7];
        var _bgimg = 'http://gps.mk/new/pin/?color=' + _color + '&type=' + _ppp[9];
        tmpSearchMarker.events.element.innerHTML = '<div style="background: transparent url(' + _bgimg + ') no-repeat; width: 24px; height: 24px; font-size:4px"></div>';
        tmpSearchMarker.events.element.style.cursor = 'pointer';
        tmpSearchMarker.events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + _ppp[2] + "<br /></strong>" + dic("AddInfo", lang) + ": <strong style=\"font-size: 12px;\">" + _ppp[11] + "</strong><br />" + dic("Group", lang) + ": <strong style=\"font-size: 12px;\">" + _ppp[8] + "</strong>')");
        tmpSearchMarker.events.element.setAttribute("onclick", "EditPOI('" + _ppp[0] + "', '" + _ppp[1] + "', '" + _ppp[2] + "', '" + _ppp[3] + "', '" + _ppp[4] + "', '" + _ppp[5] + "', '" + _ppp[6] + "', '-1', '" + _ppp[10] + "', '" + _ppp[11] + "', '" + _ppp[12] + "')");
        $(tmpSearchMarker.events.element).mouseout(function () { HidePopup() });
   	}
}

function searchItems21(_id, num){
	if($('#' + _id).val() == "")
		return false;
	$('#imgSearchLoading-' + num).css({ display: 'block' });
    $.ajax({
        url: "searchMarkers.php?name=" + $('#' + _id).val(),
        context: document.body,
        success: function (data) {
            var _pp = JXG.decompress(data).split('#');
            var _html = "";
            var _items = new Array();
            
            for (var i = 1; i < _pp.length; i++) {
            	_items[i] = "";
            	_items[i] += "<strong style='font-size: 14px;'>"+dic("Name", lang)+":</strong> " + _pp[i].split("|")[2] + "<br />";
        		_items[i] += "<strong style='font-size: 14px;'>" + dic("AddInfo", lang) + "</strong> " + _pp[i].split("|")[6] + "<br />";
        		_items[i] += "<strong style='font-size: 14px;'>"+dic("Group", lang)+"</strong> " + _pp[i].split("|")[8] + "<br />";
                _html += "<a id='searchMarker-"+ i +"' style='cursor: pointer;' onmouseover='this.style.textDecoration=\"underline\"' onmouseout='this.style.textDecoration=\"\"' onclick='setCenterMap(" + _pp[i].split("|")[0] + ", " + _pp[i].split("|")[1] + ", 18, " + num + "); AddMarkerS2(" + num + ", \"" + escape(_pp[i]) + "\")'>" + (i + 1) + ". " + _pp[i].split("|")[2] + "</a><br/>";
                if (i < _pp[i].length - 2)
                    _html += "<br/>";
            }
            $('#outputSearch-' + num).html(_html);
            $('#outputSearch-' + num).css({ display: 'block' });
            $('#imgSearchLoading-' + num).css({ display: 'none' });
            for(var i=0; i<_items.length;i++){
            	$('#searchMarker-'+i).mousemove(function(event) {ShowPopup(event, '' + _items[this.id.substring(this.id.lastIndexOf("-")+1,this.id.length)] +'')});
            	$('#searchMarker-'+i).mouseout(function() {HidePopup()});
            }
        }
    });
}
function searchItems2(_id, e, num) {
    if (e.keyCode == 13) {
        if ($('#' + _id).val() == "")
            return false;
        $('#imgSearchLoading-' + num).css({ display: 'block' });
        $.ajax({
	        url: "searchMarkers.php?name=" + $('#' + _id).val(),
            context: document.body,
            success: function (data) {
	            var _pp = JXG.decompress(data).split('#');
                var _html = "";
                var _items = new Array();

                for (var i = 1; i < _pp.length; i++) {
                    _items[i] = "";
                    _items[i] += "<strong style='font-size: 14px;'>" + dic("Name", lang) + ":</strong> " + _pp[i].split("|")[2] + "<br />";
                    _items[i] += "<strong style='font-size: 14px;'>" + dic("AddInfo", lang) + "</strong> " + _pp[i].split("|")[6] + "<br />";
                    _items[i] += "<strong style='font-size: 14px;'>" + dic("Group", lang) + "</strong> " + _pp[i].split("|")[8] + "<br />";
                    _html += "<a id='searchMarker-" + i + "' style='cursor: pointer;' onmouseover='this.style.textDecoration=\"underline\"' onmouseout='this.style.textDecoration=\"\"' onclick='setCenterMap(" + _pp[i].split("|")[0] + ", " + _pp[i].split("|")[1] + ", 18, " + num + "); AddMarkerS2(" + num + ", \"" + escape(_pp[i]) + "\")'>" + (i + 1) + ". " + _pp[i].split("|")[2] + "</a><br/>";
                    if (i < _pp[i].length - 2)
                        _html += "<br/>";
                }
                $('#outputSearch-' + num).html(_html);
                $('#outputSearch-' + num).css({ display: 'block' });
                $('#imgSearchLoading-' + num).css({ display: 'none' });
                for (var i = 0; i < _items.length; i++) {
                    $('#searchMarker-' + i).mousemove(function (event) { ShowPopup(event, '' + _items[this.id.substring(this.id.lastIndexOf("-") + 1, this.id.length)] + '') });
                    $('#searchMarker-' + i).mouseout(function () { HidePopup() });
                }
            }
        });
    }
    if (e.keyCode == 27) {
        SearchName(num, 0);
    }
}
function isFloat (n) {
  return n===+n && n!==(n|0);
}
function searchItems3(_id, e, num) {
	if($('#' + _id).val() == "")
		return false;
    if (e.keyCode == 13) {
        var lon = parseFloat($('#' + _id).val().substring($('#' + _id).val().indexOf(",")+1, $('#' + _id).val().length));
		var lat = parseFloat($('#' + _id).val().substring(0, $('#' + _id).val().indexOf(",")));
		if(isFloat(lon) && isFloat(lat))
		{
			$('#' + _id).val(lat+", "+lon);
			$('#imgSearchLoading-' + num).css({ display: 'block' });
			$.ajax({
		        url: "searchGeocodeByLonLat.php?lon=" + lon + "&lat=" + lat,
		        context: document.body,
		        success: function (data) {
		            setCenterMap(lon, lat, 18, num);
		            AddMarkerS(lon, lat, num, data.replace("\r\n",""), "");
		            $('#imgSearchLoading-' + num).css({ display: 'none' });
			        }
			    });
		} else {
			$('#' + _id).val('Wrong format!!!');
			return false;
		}
    }
    if (e.keyCode == 27) {
        SearchName(num, 0);
    }
}
function searchItems31(_id, num){
	if($('#' + _id).val() == "")
		return false;
	var lon = parseFloat($('#' + _id).val().substring($('#' + _id).val().indexOf(",")+1, $('#' + _id).val().length));
	var lat = parseFloat($('#' + _id).val().substring(0, $('#' + _id).val().indexOf(",")));
	if(isFloat(lon) && isFloat(lat))
	{
		$('#' + _id).val(lat+", "+lon);
		$('#imgSearchLoading-' + num).css({ display: 'block' });
		$.ajax({
	        url: "searchGeocodeByLonLat.php?lon=" + lon + "&lat=" + lat,
	        context: document.body,
	        success: function (data) {
	            setCenterMap(lon, lat, 18, num);
	            AddMarkerS(lon, lat, num, data.replace("\r\n",""), "");
	            $('#imgSearchLoading-' + num).css({ display: 'none' });
	        }
	    });
	} else {
		$('#' + _id).val('Wrong format!!!');
		return false;
	}  
}
function searchItems1(_id, e, num) {
    if (e.keyCode == 13) {
    	if($('#' + _id).val() == "")
			return false;
        $('#imgSearchLoading-' + num).css({ display: 'block' });
        $.ajax({
            url: "searchGeocode.php?name=" + $('#' + _id).val(),
            context: document.body,
            success: function (data) {
                //$('#textSearch-' + num)[0].className = 'cornerS1 text3';
                var _html = "";
                var _items = new Array();
                for (var i = 0; i < data.split("&@&").length - 1; i++) {
                	_items[i] = "";
                	_items[i] += "<strong style='font-size: 14px;'>Name:</strong> " + data.split("&@&")[i].split("@*@")[3] + "<br />";
                	if(data.split("&@&")[i].split("@*@")[4] != "")
                		_items[i] += "<strong style='font-size: 14px;'>Type:</strong> " + data.split("&@&")[i].split("@*@")[4] + "<br />";
                	if(data.split("&@&")[i].split("@*@")[5] != "")
                		_items[i] += "<strong style='font-size: 14px;'>Class:</strong> " + data.split("&@&")[i].split("@*@")[5] + "<br />";
                	if(data.split("&@&")[i].split("@*@")[6] != "")
                		_items[i] += "<strong style='font-size: 14px;'>Icon:</strong> <img alt='' style='background-color: White;' src='" + data.split("&@&")[i].split("@*@")[6] + "' /><br />";
                	_items[i] += "<strong style='font-size: 14px;'>Country:</strong> " + data.split("&@&")[i].split("@*@")[7] + "<br />";
                	if(data.split("&@&")[i].split("@*@")[8] != "")
                		_items[i] += "<strong style='font-size: 14px;'>City:</strong> " + data.split("&@&")[i].split("@*@")[8] + "<br />";
            		if(data.split("&@&")[i].split("@*@")[9] != "")
                		_items[i] += "<strong style='font-size: 14px;'>Country code:</strong> " + data.split("&@&")[i].split("@*@")[9] + "<br />";
                	if(data.split("&@&")[i].split("@*@")[10] != "")
                		_items[i] += "<strong style='font-size: 14px;'>Suburb:</strong> " + data.split("&@&")[i].split("@*@")[10] + "<br />";
                	if(data.split("&@&")[i].split("@*@")[11] != "")
                		_items[i] += "<strong style='font-size: 14px;'>Administrative:</strong> " + data.split("&@&")[i].split("@*@")[11] + "<br />"; 
                    _html += "<a id='searchData-"+ i +"' style='cursor: pointer;' onmouseover='this.style.textDecoration=\"underline\"' onmouseout='this.style.textDecoration=\"\"' text-decoration: underline;' onclick='setCenterMap(" + data.split("&@&")[i].split("@*@")[1] + ", " + data.split("&@&")[i].split("@*@")[2] + ", 18, " + num + "); AddMarkerS1(" + data.split("&@&")[i].split("@*@")[1] + ", " + data.split("&@&")[i].split("@*@")[2] + ", " + num + ", \"" + escape(_items[i]) + "\", \"" + data.split("&@&")[i].split("@*@")[6] + "\")'>" + (i + 1) + ". " + data.split("&@&")[i].split("@*@")[3] + "</a><br/>";
                    if (i < data.split("&@&").length - 2)
                        _html += "<br/>";
                }
                $('#outputSearch-' + num).html(_html);
                $('#outputSearch-' + num).css({ display: 'block' });
                $('#imgSearchLoading-' + num).css({ display: 'none' });
                for(var i=0; i<_items.length;i++){
                	$('#searchData-'+i).mousemove(function(event) {ShowPopup(event, '' + _items[this.id.substring(this.id.lastIndexOf("-")+1,this.id.length)] +'')});
                	$('#searchData-'+i).mouseout(function() {HidePopup()});
                }
            }
        });
    }
    if (e.keyCode == 27) {
        SearchName(num, 0);
    }
}

function searchItems11(_id, num) {
	if($('#' + _id).val() == "")
		return false;
    $('#imgSearchLoading-' + num).css({ display: 'block' });
    $.ajax({
        url: "searchGeocode.php?name=" + $('#' + _id).val(),
        context: document.body,
        success: function (data) {
            //$('#textSearch-' + num)[0].className = 'cornerS1 text3';
            var _html = "";
            var _items = new Array();
            for (var i = 0; i < data.split("&@&").length - 1; i++) {
            	_items[i] = "";
            	_items[i] += "<strong style='font-size: 14px;'>Name:</strong> " + data.split("&@&")[i].split("@*@")[3] + "<br />";
            	if(data.split("&@&")[i].split("@*@")[4] != "")
            		_items[i] += "<strong style='font-size: 14px;'>Type:</strong> " + data.split("&@&")[i].split("@*@")[4] + "<br />";
            	if(data.split("&@&")[i].split("@*@")[5] != "")
            		_items[i] += "<strong style='font-size: 14px;'>Class:</strong> " + data.split("&@&")[i].split("@*@")[5] + "<br />";
            	if(data.split("&@&")[i].split("@*@")[6] != "")
            		_items[i] += "<strong style='font-size: 14px;'>Icon:</strong> <img alt='' style='background-color: White;' src='" + data.split("&@&")[i].split("@*@")[6] + "' /><br />";
            	_items[i] += "<strong style='font-size: 14px;'>Country:</strong> " + data.split("&@&")[i].split("@*@")[7] + "<br />";
            	if(data.split("&@&")[i].split("@*@")[8] != "")
            		_items[i] += "<strong style='font-size: 14px;'>City:</strong> " + data.split("&@&")[i].split("@*@")[8] + "<br />";
        		if(data.split("&@&")[i].split("@*@")[9] != "")
            		_items[i] += "<strong style='font-size: 14px;'>Country code:</strong> " + data.split("&@&")[i].split("@*@")[9] + "<br />";
            	if(data.split("&@&")[i].split("@*@")[10] != "")
            		_items[i] += "<strong style='font-size: 14px;'>Suburb:</strong> " + data.split("&@&")[i].split("@*@")[10] + "<br />";
            	if(data.split("&@&")[i].split("@*@")[11] != "")
            		_items[i] += "<strong style='font-size: 14px;'>Administrative:</strong> " + data.split("&@&")[i].split("@*@")[11] + "<br />";
                _html += "<a id='searchData-"+ i +"' style='cursor: pointer;' onmouseover='this.style.textDecoration=\"underline\"' onmouseout='this.style.textDecoration=\"\"' onclick='setCenterMap(" + data.split("&@&")[i].split("@*@")[1] + ", " + data.split("&@&")[i].split("@*@")[2] + ", 18, " + num + "); AddMarkerS1(" + data.split("&@&")[i].split("@*@")[1] + ", " + data.split("&@&")[i].split("@*@")[2] + ", " + num + ", \"" + escape(_items[i]) + "\", \"" + data.split("&@&")[i].split("@*@")[6] + "\")'>" + (i + 1) + ". " + data.split("&@&")[i].split("@*@")[3] + "</a><br/>";
                if (i < data.split("&@&").length - 2)
                    _html += "<br/>";
            }
            $('#outputSearch-' + num).html(_html);
            $('#outputSearch-' + num).css({ display: 'block' });
            $('#imgSearchLoading-' + num).css({ display: 'none' });
            for(var i=0; i<_items.length;i++){
            	$('#searchData-'+i).mousemove(function(event) {ShowPopup(event, '' + _items[this.id.substring(this.id.lastIndexOf("-")+1,this.id.length)] +'')});
            	$('#searchData-'+i).mouseout(function() {HidePopup()});
            }
        }
    });
}
function AddMarkerS1(lon, lat, num, _name, _icon) {
    if (tmpMarkerStreet != undefined) {
        Markers[num].removeMarker(tmpMarkerStreet);
    }
    var _color = "1a6ea5"
    var size = new OpenLayers.Size(16, 16);
    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
    if(_icon != "")
	    var icon = new OpenLayers.Icon(''+_icon+'', size, null, calculateOffset);
    else
    	var icon = new OpenLayers.Icon('./blank.png', size, null, calculateOffset);
        
    var ll = new OpenLayers.LonLat(parseFloat(lon), parseFloat(lat)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[num].getProjectionObject())
    if (MapType[num] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(lon), parseFloat(lat)) }
    var MyMar = new OpenLayers.Marker(ll, icon);
    var markers = Markers[num];
    markers.addMarker(MyMar);
    MyMar.events.element.style.zIndex = 666;
    tmpMarkerStreet = MyMar;

    if(_icon == "")
    	tmpMarkerStreet.events.element.innerHTML = '<div class="corner5" style="color: White; width: 14px; text-align: center; height: 14px; background: #' + _color + '; font-size: 11px; padding: 0px 1px 1px 0px;">○</div>';
    tmpMarkerStreet.events.element.style.cursor = 'pointer';
    tmpMarkerStreet.events.element.setAttribute("onmousemove", "ShowPopup(event, \"" + unescape(_name) + "\")");
    $(tmpMarkerStreet.events.element).mouseout(function () { HidePopup() });
}
function AddMarkerS(lon, lat, num, _name, _icon) {
    if (tmpMarkerStreet != undefined) {
        Markers[num].removeMarker(tmpMarkerStreet);
    }
    var _color = "1a6ea5"
    var size = new OpenLayers.Size(16, 16);
    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
    if(_icon != "")
	    var icon = new OpenLayers.Icon(''+_icon+'', size, null, calculateOffset);
    else
    	var icon = new OpenLayers.Icon('./blank.png', size, null, calculateOffset);
        
    var ll = new OpenLayers.LonLat(parseFloat(lon), parseFloat(lat)).transform(new OpenLayers.Projection("EPSG:4326"), Maps[num].getProjectionObject())
    if (MapType[num] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(lon), parseFloat(lat)) }
    var MyMar = new OpenLayers.Marker(ll, icon);
    var markers = Markers[num];
    markers.addMarker(MyMar);
    MyMar.events.element.style.zIndex = 666;
    tmpMarkerStreet = MyMar;

    if(_icon == "")
    	tmpMarkerStreet.events.element.innerHTML = '<div class="corner5" style="color: White; width: 14px; text-align: center; height: 14px; background: #' + _color + '; font-size: 11px; padding: 0px 1px 1px 0px;">○</div>';
    tmpMarkerStreet.events.element.style.cursor = 'pointer';
    tmpMarkerStreet.events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + _name + "</strong>')");
    $(tmpMarkerStreet.events.element).mouseout(function () { HidePopup() });
}

function zoomWorld(_t, _z) {
    if (vectors[0].features != "") {
        if(_t.map.layers[2].getDataExtent() < _t.map.layers[1].getDataExtent())
            _t.map.zoomToExtent(_t.map.layers[2].getDataExtent());
        else
            _t.map.zoomToExtent(_t.map.layers[1].getDataExtent());
    } else {
        _t.map.zoomToExtent(_t.map.layers[2].getDataExtent());
//        _t.map.setCenter(new OpenLayers.LonLat(StartLon, StartLat).transform(new OpenLayers.Projection("EPSG:4326"), _t.map.getProjectionObject()), _z);
//        for (var i = 0; i < _t.map.layers[2].markers.length; i++)
//            if (_t.map.layers[2].markers[i].events.element.style.display != "none")
//                if (String(_t.map.layers[2].markers[i].lonlat.lon) != "NaN")
//                    if (!_t.map.layers[2].markers[i].onScreen()) {
//                        zoomWorld(_t, (_z - 1));
//                    }
    }
}
function zoomWorldScreen(_t, _z) {
	return false;
    if (vectors[0].features != "") {
        if (_t.layers[2].getDataExtent() < _t.layers[1].getDataExtent())
            _t.zoomToExtent(_t.layers[2].getDataExtent());
        else
            _t.zoomToExtent(_t.layers[1].getDataExtent());
    } else {
        _t.zoomToExtent(_t.layers[2].getDataExtent());
//        _t.setCenter(new OpenLayers.LonLat(StartLon, StartLat).transform(new OpenLayers.Projection("EPSG:4326"), _t.getProjectionObject()), _z);
//        for (var i = 0; i < _t.layers[2].markers.length; i++)
//            if (_t.layers[2].markers[i].events.element.style.display != "none")
//                if (String(_t.layers[2].markers[i].lonlat.lon) != "NaN")
//                    if (!_t.layers[2].markers[i].onScreen()) {
//                        zoomWorldScreen(_t, (_z - 1));
//                    }
    }
}

function zoomMapRoute(_t, _z) {
    for (var i = 0; i < _t.layers[2].markers.length; i++) {
        if (!_t.layers[2].markers[i].onScreen()) {
            _t.setCenter(_t.layers[2].markers[i].lonlat, (parseInt(_z, 10) - 1));
            zoomMapRoute(_t, (parseInt(_z, 10) - 1));
        }
    }
}
function zoomMapVeh(_t, _ch) {
    for (var i = 0; i < _ch.length; i++)
        if (!_t.layers[2].markers[_ch[i]].onScreen()) {
            _t.setCenter(_t.center, (parseInt(_t.zoom, 10) - 1));
            zoomMapVeh(_t, _ch);
        }
}

function zoomWorldRec(_t, _z) {
    _t.zoomToExtent(vectors[0].features[0].geometry.bounds);
//    _t.setCenter(new OpenLayers.LonLat(StartLon, StartLat).transform(new OpenLayers.Projection("EPSG:4326"), _t.getProjectionObject()), _z);
//    for (var i = 0; i < Markers[parseInt(_t.div.id.substring(_t.div.id.length - 1, _t.div.id.length), 10) - 1].markers.length; i++)
//        if (String(Markers[parseInt(_t.div.id.substring(_t.div.id.length - 1, _t.div.id.length), 10) - 1].markers[i].lonlat.lon) != "NaN")
//            if (!Markers[parseInt(_t.div.id.substring(_t.div.id.length - 1, _t.div.id.length), 10) - 1].markers[i].onScreen()) {
//                zoomWorldRec(_t, (_z - 1));
//            }
}

function LoadRouteLive(_id, _idRoute) {
    optimalClick = true;
    //if ($('#' + _id).html() == $('#RoutesCombo').html().substring($('#RoutesCombo').html().indexOf("<span>") + 6, $('#RoutesCombo').html().indexOf("</span>")))
      //  return false;
    ShowWait();

    //if ($('#menu-title-2')[0].className.indexOf("collapsed") != -1)
        //OnMenuClick(2, '590px');

    ClearRouteScreen();
    $.ajax({
        url: "../routes/LoadRoute.aspx?id=" + _id,
        context: document.body,
        success: function (data) {
            var _dat = unzip(data);
            PointsOfRoute = [];
            for (var i = 1; i < _dat.split("#@")[0].split("#").length; i++) {
                putInRoute(_dat.split("#@")[0].split("#")[i].split("|")[2], _dat.split("#@")[0].split("#")[i].split("|")[0], _dat.split("#@")[0].split("#")[i].split("|")[1], _dat.split("#@")[0].split("#")[i].split("|")[3], 1, _idRoute);
            }

            zoomWorldScreen(Maps[0], 16);
            setTimeout("HideWait();", 1500);
        }
    });
}
function POR(_id, _lon, _lat, _name) {
    this.id = _id;
    this.lon = _lon;
    this.lat = _lat;
    this.name = _name;
}

function putInRoute(_id, _lon, _lat, _name, _yesno, _idRoute) {
    if (_yesno == 1) {
        if (PointsOfRoute == "")
            PointsOfRoute[1] = new POR(_id, _lon, _lat, _name);
        else
            PointsOfRoute[PointsOfRoute.length] = new POR(_id, _lon, _lat, _name);
    }
    if ($('#MarkersIN')[0] != undefined)
        var _len = parseInt($('#MarkersIN')[0].children.length, 10);
    else
        var _len = parseInt((PointsOfRoute.length - 2), 10);
    if (_len < 1)
        CreateMarker_Route(_lon, _lat, '00CC33', '', 1, _name, _len, _id, _idRoute);
    else
        CreateMarker_Route(_lon, _lat, 'FF0000', '', 3, _name, _len, _id, _idRoute);
    if ($('#MarkersIN')[0] != undefined) {
        var _html = '<div class="text8 corner5" onmousemove="ShowPopup(event, \'' + dic("Name", lang) + ': ' + _name + '\')" onmouseout="HidePopup()" ondblclick="setCenterMap(' + _lon + ', ' + _lat + ', 17,0)" style="cursor: pointer; font-size:12; width:97%; padding:2px 2px 2px 7px; height:26px; background-image: url(\'images/updown.png\'); background-position: right center; background-repeat: no-repeat; background-origin: content-box;" id="IDMarker_' + _id + '_' + _len + '">';
        _html += '<input type="text" class="text9" readonly="readonly" value="' + _name + '" style="font-size: 11px; cursor: pointer; width: 50%; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" />';
        _html += '<input type="text" class="text9" readonly="readonly" value="/" style="font-size: 11px; cursor: pointer; width: 20%; padding-left: 10px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" />';
        _html += '<input type="text" class="text9" readonly="readonly" value="/" style="font-size: 11px; cursor: pointer; width: 20%; padding-left: 18px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" />';
        _html += '<button style="float:right; width:29px; right: 30px;" id="MLBtnDel_' + _id + '_' + _len + '" value="Delete" onclick="BtnDeleteMarkerFromList(\'IDMarker_' + _id + '_' + _len + '\',\'' + (tmpMarkersRoute.length - 1) + '\')">&nbsp;</button>';
        _html += '</div>';
        $('#MarkersIN').append(_html);
        $('#MLBtnDel_' + _id + '_' + _len).button({ icons: { primary: "ui-icon-trash"} });
    }
    zoomMapRoute(Maps[0], 16);
}
function ClearRouteScreen() {
    if ($('#MarkersIN')[0] != undefined) {
        //$("#VehiclesCombo")[0].title = "";
        //$("#VehiclesComboInput").val(dic("SelectVeh", lang));
        //$("#DriversComboInput").val(dic("SelectDriver", lang));
        //$("#DriversCombo")[0].title = "";
        //$("#RoutesCombo span").html(dic("SelectRoute", lang));
        //$("#RoutesCombo")[0].title = "";
        //$('#NameOfRoute').val('');
        //$('#redosled').val('');
        //$('#txtSDate').val(today);
        //$('#redosled').attr({ checked: false });
        $('#MarkersIN').html('');

        //$('#optimizedNarrative').html('');
        //$('#optimizedNarrative').css({ display: 'none' });
    }
    ClearGraphic();
    PointsOfRoute = [];
    optimalClick = true;
    for (var j = 0; j < tmpMarkersRoute.length; j++)
        Markers[0].removeMarker(tmpMarkersRoute[j]);
    tmpMarkersRoute = [];
    PointsOfRoute = [];

}
function ReDrawRoute(_file) {
    ClearGraphic();
    //PointsOfRoute = [];
    //for (var j = 0; j < tmpMarkersRoute.length; j++)
        //Markers[0].removeMarker(tmpMarkersRoute[j]);
    //tmpMarkersRoute = [];
    //PointsOfRoute = [];
    if(_file == 1)
        var file = "getLinePoints";
    else
        var file = "getLinePointsF";
    for(var i = 1; i < PointsOfRoute.length - 1; i++)
        DrawLine_RouteNew(PointsOfRoute[i].lon, PointsOfRoute[i].lat, PointsOfRoute[i + 1].lon, PointsOfRoute[i + 1].lat, i, "<strong>" + dic("From", lang) + ": (" + i + ")</strong> " + PointsOfRoute[i].name + "<br /><strong>" + dic("To", lang) + ": (" + (i + 1) + ")</strong> " + PointsOfRoute[i + 1].name, file, i);
}

function LoadRoute(_id) {
    //optimalClick = true;
    //if ($('#' + _id).html() == $('#RoutesCombo').html().substring($('#RoutesCombo').html().indexOf("<span>") + 6, $('#RoutesCombo').html().indexOf("</span>")))
        //return false;
    ShowWait();

    //if ($('#menu-title-2')[0].className.indexOf("collapsed") != -1)
    //OnMenuClick(2, '590px');

    ClearRouteScreen();
    $.ajax({
        url: "LoadRoute.aspx?id=" + _id,
        context: document.body,
        success: function (data) {
            var _dat = unzip(data);
            PointsOfRoute = [];
            for (var i = 1; i < _dat.split("#@")[0].split("#").length; i++) {
                putInRoute(_dat.split("#@")[0].split("#")[i].split("|")[2], _dat.split("#@")[0].split("#")[i].split("|")[0], _dat.split("#@")[0].split("#")[i].split("|")[1], _dat.split("#@")[0].split("#")[i].split("|")[3], 1, _id);
            }
            /*$('#NameOfRoute').val(_dat.split("#@")[1].split("@%")[0]);
            $('#VehiclesCombo').attr({ title: _dat.split("#@")[1].split("@%")[3] });
            document.getElementById("VehiclesCombo").title = _dat.split("#@")[1].split("@%")[3];

            $('#DriversCombo').attr({ title: _dat.split("#@")[1].split("@%")[1] });
            document.getElementById("DriversCombo").title = _dat.split("#@")[1].split("@%")[1];

            $("#DriversComboInput").val(_dat.split("#@")[1].split("@%")[2]);
            $("#VehiclesComboInput").val(_dat.split("#@")[1].split("@%")[4]);

            $('#txtSDate').val(_dat.split("#@")[1].split("@%")[9]);

            $('#radiusen').val(_dat.split("#@")[1].split("@%")[5]);
            $('#trajectory').val(_dat.split("#@")[1].split("@%")[6]);
            $('#vrnz').val(_dat.split("#@")[1].split("@%")[7]);

            if (_dat.split("#@")[1].split("@%")[8] == "False")
            $('#redosled').attr({ checked: false });
            else
            $('#redosled').attr({ checked: true });
            */
            zoomWorldScreen(Maps[0], 16);
            setTimeout("HideWait();", 1500);
        }
    });
}

// Simple function to calculate time difference between 2 Javascript date objects
function get_time_difference(earlierDate, laterDate) {
    var nTotalDiff = laterDate.getTime() - earlierDate.getTime();
    var oDiff = new Object();

    oDiff.days = Math.floor(nTotalDiff / 1000 / 60 / 60 / 24);
    nTotalDiff -= oDiff.days * 1000 * 60 * 60 * 24;

    oDiff.hours = Math.floor(nTotalDiff / 1000 / 60 / 60);
    nTotalDiff -= oDiff.hours * 1000 * 60 * 60;

    oDiff.minutes = Math.floor(nTotalDiff / 1000 / 60);
    nTotalDiff -= oDiff.minutes * 1000 * 60;

    oDiff.seconds = Math.floor(nTotalDiff / 1000);

    return oDiff;

}
function changeDriver(_vh_driver, _idVeh, _idCh) {
    ShowWait();
    $('#' + _vh_driver).html($('#driver-' + _idCh).html());
    $.ajax({
        url: 'ChangeVehDriv.aspx?idVeh=' + _idVeh + '&idDriv=' + _idCh + '&l=' + lang,
        success: function (data) {
            if (data == "Ok") {
                HideWait();
            }
            else {
                msgbox(data);
                $('#' + _vh_driver).html('/');
                HideWait();
            }
        }
    });
}
