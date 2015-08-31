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
		if(id==4)
			h = h + 50;
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
    return nd; //.toLocaleString();

}

function getCurrentTime() {
    var cT = calcTime(timeZone);
    var currentTime = new Date(cT);
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
	hours = hours;
	$('#span-time').html(hours + ":" + minutes + ':' + sec +'&nbsp;');
	$('#popup-time').html(day + "-" + mes[parseInt(month) + 1] + "-" + year + ' ' + hours + ":" + minutes + ':' + sec);
	setTimeout("getCurrentTime()", 1000);
}

function getCTime() {
    var cT = calcTime(timeZone);
    var currentTime = new Date(cT);
	var hours = currentTime.getHours()
	var minutes = currentTime.getMinutes()
	var sec = currentTime.getSeconds()
	
	if (minutes < 10)	minutes = "0" + minutes
	if (sec < 10)	sec = "0" + sec
	
	var currentDate = new Date()
  	var day = currentDate.getDate()
  	var month = currentDate.getMonth()
  	var year = currentDate.getFullYear();
	hours = hours;
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
function UpdateArea(_n, pts, _areaid, _avail, _gfgid, _col) {
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
        url: "AddAreaNew.php?id=" + _areaid + '&p=' + ptsNew + '&n=' + _n + '&avail=' + _avail + '&gfgid=' + _gfgid + '&av=' + _av + '&in=' + _in + '&out=' + _out + '&in1=' + chk_1_in + '&out1=' + chk_1_out + '&in2=' + chk_2_in + '&out2=' + chk_2_out + '&e=' + em + '&ph=' + ph + '&l=' + lang,
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
    for (var i = 1; i <= 3; i++) {
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
    var _utl = 'n=' + areaName + '&av=' + _av + '&in=' + _in + '&avail=' + avail + '&ppgid=' + $('#gfGroup dt a')[0].title + '&out=' + _out + '&in1=' + chk_1_in + '&out1=' + chk_1_out + '&in2=' + chk_2_in + '&out2=' + chk_2_out + '&e=' + em + '&ph=' + ph + '&p=' + ptsNew + '&l=' + lang;

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
            AddAreaToArray(ret, areaID);
            map.zoomToExtent(ret[0].geometry.bounds);
            HideWait();
        }
    });
}
function DrawZoneOnLive2(areaID, _color){
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
    if (tf == 0) { PleaseDrawAreaAgain2(areaID, _color) }
}
function DrawZoneOnLiveSettings(areaID, _color){
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
    if (tf == 0) { PleaseDrawAreaAgainSettings(areaID, _color) }
}
function PleaseDrawAreaAgainSettings(areaID, _color) {
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
            onFeatureSelect(ret[0].layer.features[0]);
            EditPoly();
            //var bounds = new OpenLayers.Bounds();
            //bounds.extend(ret[0].layer.getDataExtent());
            map.zoomToExtent(ret[0].layer.getDataExtent());
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
                        //Maps[z].zoomToExtent(ArrAreasPoly[z][i].layer.getDataExtent());
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
            //map.zoomToExtent(ret[0].layer.getDataExtent());
            HideWait();
        }
    });
}
function PleaseDrawAreaAgain2(areaID, _color) {
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
        url: "getVehicleArea.php?",
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
        ClearArrayAlpha();
        return
    } else {
        ShowWait();
        ShowHideTrajectory = true;
        var s = 1;
        for(var z= 0; z < Vehicles.length; z++)
        {
        	if (PathPerVeh[Vehicles[z].ID] == undefined || PathPerVeh[Vehicles[z].ID] == "") {
        		PathPerVeh[Vehicles[z].ID] = [];
        		get10Points1(Vehicles[z].ID, Vehicles[z].Reg, -1);
        	}
        }
        while (document.getElementById("1_checkRow" + s) != null) {
            tmpCheckGroup[1][s] = 1;
            s++;
        }
        $('#icon-draw-path').css({ backgroundPosition: '0px 0px' });
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


function getLeftList(tlang) {
	ShowWait();
	$.ajax({
	    url: "getLeftList.php?l="+tlang,
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
	        setTimeout("getLeftList("+tlang+");", 2000);
	    }
	});

}
function changeOrder(newOrder) {
    var $divs = $('.menu-container'),
        $parent = $divs.eq(0).parent();
    for (var ii = 0; ii < newOrder.length; ii++) {
        $parent.append($divs.eq(newOrder[ii] - 1));
    }
}
function getLeftListDisabled() {
    ShowWait()
    $.ajax({
        url: "getLeftListD.php?l=" + lang,
        context: document.body,
        success: function (data) {
            var _html = $('#div-menu').html()
            $('#div-menu').html(_html + data);
            ShowWait()
		    $.ajax({
		        url: "getMenuOrder.php?uid=" + _userId,
		        context: document.body,
		        success: function (data) {
            		var temp = data.replace("\r", "");
            		temp = temp.replace("\n", "")
            		if(temp == "")
            			temp = "12345";
		            changeOrder(temp);
		            $('#div-menu').css({ display: 'block' });
		            $("#div-menu").sortable({
		            	revert: true,
				        axis: 'y',
				        cursor: 'ns-resize',
				        stop: function (event, div) {
				        	ShowWait()
				        	var tmp = "";
				        	for(var i=0; i < $('#div-menu')[0].children.length; i++)
				        	{
				        		tmp += parseInt($('#div-menu')[0].children[i].id.substring($('#div-menu')[0].children[i].id.indexOf("-")+1,$('#div-menu')[0].children[i].id.length), 10);
				        	}
				        	//setCookie(_userId + "_menuOrder", tmp, 14);
				        	$.ajax({
						        url: "updateMenuOrder.php?uid=" + _userId + "&order=" + tmp,
						        context: document.body,
						        success: function (data) {
						        	HideWait();
				           	}});
				        }
			        });
			        $("#div-menu").disableSelection();
		            HideWait();
           }});
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
            $('#div-border-4').css({ width: ($('#div-map-4')[0].offsetWidth + _w[3]) + 'px', left: ($('#div-map-4')[0].offsetLeft) + 250 + 'px' });
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
        var size = new OpenLayers.Size(24, 24);
        var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -size.h); };
        var icon = new OpenLayers.Icon('../images/pin-1.png', size, null, calculateOffset);

        var ll = new OpenLayers.LonLat(parseFloat(_ppp[0]), parseFloat(_ppp[1])).transform(new OpenLayers.Projection("EPSG:4326"), Maps[num].getProjectionObject())
        //if (MapType[num] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_ppp[0]), parseFloat(_ppp[1])) }
        var MyMar = new OpenLayers.Marker(ll, icon)
        var markers = Markers[num];
        markers.addMarker(MyMar);
        MyMar.events.element.style.zIndex = 666
        tmpSearchMarker = MyMar;
        if (_ppp[7] == "1")
            var _color = 'ff0000';
        else
            var _color = _ppp[7];
        //var _bgimg = 'http://gps.mk/new/pin/?color=' + _color + '&type=0';
        //tmpSearchMarker.events.element.innerHTML = '<div style="background: transparent url(' + _bgimg + ') no-repeat; width: 24px; height: 24px; font-size:4px"></div>';
        tmpSearchMarker.events.element.style.cursor = 'pointer';
        tmpSearchMarker.events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + _ppp[2] + "<br /></strong>" + dic("Group", lang) + ": <strong style=\"font-size: 12px;\">" + _ppp[8] + "</strong>')");
        tmpSearchMarker.events.element.setAttribute("onclick", "EditPOI('" + _ppp[0] + "', '" + _ppp[1] + "', '" + _ppp[2] + "', '" + _ppp[3] + "', '" + _ppp[4] + "', '" + _ppp[5] + "', '" + _ppp[6] + "', '-1', '" + _ppp[10] + "', '" + _ppp[11] + "', '" + _ppp[12] + "')");
        $(tmpSearchMarker.events.element).mouseout(function () { HidePopup() });
   	}
}

function searchItems21(_id, num) {
	if($('#' + _id).val() == "")
		return false;
	$('#imgSearchLoading-' + num).css({ display: 'block' });
    $.ajax({
        url: "searchMarkers.php?name=" + $('#' + _id).val(),
        context: document.body,
        success: function (data) {
        	data = data.replace("\r\n","");
        	if(data == "**")
        	{
        		$('#outputSearch-' + num).html(dic("Reports.NoData1", lang));
                $('#outputSearch-' + num).css({ display: 'block' });
        		$('#imgSearchLoading-' + num).css({ display: 'none' });
        	} else {
	            var _pp = data.split("$$")[0].split("#");
	            var _html = "";
	            var _items = new Array();
				var i = 1;
				if(data.split("$$")[0] != "")
                {
	                for (var i = 1; i < _pp.length; i++) {
	                    _items[i] = "";
	                    _items[i] += "<img width='18px' src=\'../images/poiButton.png\' />  <strong style='font-size: 14px;'>"+dic("Poi", lang)+"</strong><br />";
	                    _items[i] += "<strong style='font-size: 14px;'>" + dic("Name", lang) + ":</strong> " + _pp[i].split("|")[2] + "<br />";
	                    //_items[i] += "<strong style='font-size: 14px;'>" + dic("AddInfo", lang) + "</strong> " + _pp[i].split("|")[6] + "<br />";
	                    _items[i] += "<strong style='font-size: 14px;'>" + dic("Group", lang) + "</strong> " + _pp[i].split("|")[8] + "<br />";
	                    _html += "<a id='searchMarker-" + i + "' style='cursor: pointer;' onmouseover='this.style.textDecoration=\"underline\"' onmouseout='this.style.textDecoration=\"\"' onclick='setCenterMap(" + _pp[i].split("|")[0] + ", " + _pp[i].split("|")[1] + ", 18, " + num + "); AddMarkerS2(" + num + ", \"" + escape(_pp[i]) + "\")'>" + (i) + ". <img width='14px' style='position: relative; top: 4px;' src=\'../images/poiButton.png\' /> " + _pp[i].split("|")[2] + "</a><br/>";
	                    if (i < _pp[i].length - 2)
	                        _html += "<br/>";
	                }
                }
                if(data.split("$$")[1] != "")
                {
	                var _pp = data.split("$$")[1].split("#");
	                var _br = 1;
	                for (var j = i; j < ((i-1)+_pp.length); j++) {
	                    _items[j] = "";
	                    _items[j] += "<img width='18px' src=\'../images/areaImg.png\' />  <strong style='font-size: 14px;'>"+dic("GeoFence", lang)+"</strong><br />";
	                    _items[j] += "<strong style='font-size: 14px;'>" + dic("Name", lang) + ":</strong> " + _pp[_br].split("|")[1] + "<br />";
	                    //_items[i] += "<strong style='font-size: 14px;'>" + dic("AddInfo", lang) + "</strong> " + _pp[i].split("|")[6] + "<br />";
	                    _items[j] += "<strong style='font-size: 14px;'>" + dic("Group", lang) + "</strong> " + _pp[_br].split("|")[7] + "<br />";
	                    _html += "<a id='searchMarker-" + j + "' style='cursor: pointer;' onmouseover='this.style.textDecoration=\"underline\"' onmouseout='this.style.textDecoration=\"\"' onclick='DrawZoneByName("+_pp[_br].split("|")[4]+"); DrawZoneOnLive("+_pp[_br].split("|")[4]+", \"#"+_pp[_br].split("|")[6]+"\")'>" + (j) + ". <img width='14px' style='position: relative; top: 4px;' src=\'../images/areaImg.png\' /> " + _pp[_br].split("|")[1] + "</a><br/>";
	                    if (i < _pp[_br].length - 2)
	                        _html += "<br/>";
                        _br++;
	                }
                }
                $('#outputSearch-' + num).html(_html);
                $('#outputSearch-' + num).css({ display: 'block' });
                $('#imgSearchLoading-' + num).css({ display: 'none' });
                for (var i = 0; i < _items.length; i++) {
                    $('#searchMarker-' + i).mousemove(function (event) { ShowPopup(event, '' + _items[this.id.substring(this.id.lastIndexOf("-") + 1, this.id.length)] + '') });
                    $('#searchMarker-' + i).mouseout(function () { HidePopup() });
                }
           }
        }
    });
}
function DrawZoneByName(_id){
	var s = 1;
    //while (document.getElementById("2_checkRow" + s) != null) {
        //tmpCheckGroup[2][s] = 1;
        //s++;
    //}
    for (var cz = 0; cz <= cntz; cz++)
        if (document.getElementById("zona_" + cz) != null)
        	if($('#zona_' + cz)[0].attributes[1].value.indexOf(_id) != -1)
            	$('#zona_' + cz)[0].checked = true;
    if (document.getElementById('icon-draw-zone') != null)
        $('#icon-draw-zone').css({ backgroundPosition: '0px -48px' });
    else
        if (document.getElementById('div-gfimg') != null)
            document.getElementById('div-gfimg').style.backgroundColor = '#00ff00';
    ShowHideZone = true;
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
            	data = data.replace("\r\n","");
            	if(data == "**")
            	{
            		$('#outputSearch-' + num).html(dic("Reports.NoData1", lang));
	                $('#outputSearch-' + num).css({ display: 'block' });
            		$('#imgSearchLoading-' + num).css({ display: 'none' });
            	} else {
            		var _pp = data.split("$$")[0].split("#");
	                var _html = "";
	                var _items = new Array();
					var i = 1;
					if(data.split("$$")[0] != "")
	                {
		                for (var i = 1; i < _pp.length; i++) {
		                    _items[i] = "";
		                    _items[i] += "<img width='18px' src=\'../images/poiButton.png\' />  <strong style='font-size: 14px;'>"+dic("Poi", lang)+"</strong><br />";
		                    _items[i] += "<strong style='font-size: 14px;'>" + dic("Name", lang) + ":</strong> " + _pp[i].split("|")[2] + "<br />";
		                    //_items[i] += "<strong style='font-size: 14px;'>" + dic("AddInfo", lang) + "</strong> " + _pp[i].split("|")[6] + "<br />";
		                    _items[i] += "<strong style='font-size: 14px;'>" + dic("Group", lang) + "</strong> " + _pp[i].split("|")[8] + "<br />";
		                    _html += "<a id='searchMarker-" + i + "' style='cursor: pointer;' onmouseover='this.style.textDecoration=\"underline\"' onmouseout='this.style.textDecoration=\"\"' onclick='setCenterMap(" + _pp[i].split("|")[0] + ", " + _pp[i].split("|")[1] + ", 18, " + num + "); AddMarkerS2(" + num + ", \"" + escape(_pp[i]) + "\")'>" + (i) + ". <img width='14px' style='position: relative; top: 4px;' src=\'../images/poiButton.png\' /> " + _pp[i].split("|")[2] + "</a><br/>";
		                    if (i < _pp[i].length - 2)
		                        _html += "<br/>";
		                }
	                }
	                if(data.split("$$")[1] != "")
	                {
		                var _pp = data.split("$$")[1].split("#");
		                var _br = 1;
		                for (var j = i; j < ((i-1)+_pp.length); j++) {
		                    _items[j] = "";
		                    _items[j] += "<img width='18px' src=\'../images/areaImg.png\' />  <strong style='font-size: 14px;'>"+dic("GeoFence", lang)+"</strong><br />";
		                    _items[j] += "<strong style='font-size: 14px;'>" + dic("Name", lang) + ":</strong> " + _pp[_br].split("|")[1] + "<br />";
		                    //_items[i] += "<strong style='font-size: 14px;'>" + dic("AddInfo", lang) + "</strong> " + _pp[i].split("|")[6] + "<br />";
		                    _items[j] += "<strong style='font-size: 14px;'>" + dic("Group", lang) + "</strong> " + _pp[_br].split("|")[7] + "<br />";
		                    _html += "<a id='searchMarker-" + j + "' style='cursor: pointer;' onmouseover='this.style.textDecoration=\"underline\"' onmouseout='this.style.textDecoration=\"\"' onclick='DrawZoneByName("+_pp[_br].split("|")[4]+"); DrawZoneOnLive("+_pp[_br].split("|")[4]+", \"#"+_pp[_br].split("|")[6]+"\")'>" + (j) + ". <img width='14px' style='position: relative; top: 4px;' src=\'../images/areaImg.png\' /> " + _pp[_br].split("|")[1] + "</a><br/>";
		                    if (i < _pp[_br].length - 2)
		                        _html += "<br/>";
	                        _br++;
		                }
	                }
	                $('#outputSearch-' + num).html(_html);
	                $('#outputSearch-' + num).css({ display: 'block' });
	                $('#imgSearchLoading-' + num).css({ display: 'none' });
	                for (var i = 0; i < _items.length; i++) {
	                    $('#searchMarker-' + i).mousemove(function (event) { ShowPopup(event, '' + _items[this.id.substring(this.id.lastIndexOf("-") + 1, this.id.length)] + '') });
	                    $('#searchMarker-' + i).mouseout(function () { HidePopup() });
	                }
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
			$('#' + _id).val(dic("Tracking.WrongFormat",lang));
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
		$('#' + _id).val(dic("Tracking.WrongFormat",lang));
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
                	_items[i] += "<strong style='font-size: 14px;'>"+ dic("Name",lang) +":</strong> " + data.split("&@&")[i].split("@*@")[3] + "<br />";
                	if(data.split("&@&")[i].split("@*@")[4] != "")
                		_items[i] += "<strong style='font-size: 14px;'>"+dic("Tracking.Type",lang)+":</strong> " + data.split("&@&")[i].split("@*@")[4] + "<br />";
                	if(data.split("&@&")[i].split("@*@")[5] != "") 
                		_items[i] += "<strong style='font-size: 14px;'>"+ dic("Tracking.Class",lang)+ ":</strong> " + data.split("&@&")[i].split("@*@")[5] + "<br />";
                	if(data.split("&@&")[i].split("@*@")[6] != "")
                		_items[i] += "<strong style='font-size: 14px;'>"+ dic("Tracking.Icon",lang)+":</strong> <img alt='' style='background-color: White;' src='" + data.split("&@&")[i].split("@*@")[6] + "' /><br />";
                	_items[i] += "<strong style='font-size: 14px;'>"+dic("Tracking.Country",lang)+":</strong> " + data.split("&@&")[i].split("@*@")[7] + "<br />";
                	if(data.split("&@&")[i].split("@*@")[8] != "")
                		_items[i] += "<strong style='font-size: 14px;'>"+dic("Tracking.City",lang)+":</strong> " + data.split("&@&")[i].split("@*@")[8] + "<br />";
            		if(data.split("&@&")[i].split("@*@")[9] != "")
                		_items[i] += "<strong style='font-size: 14px;'>"+dic("Tracking.Country",lang)+" "+ dic("Tracking.Code",lang) + ":</strong> " + data.split("&@&")[i].split("@*@")[9] + "<br />";
                	if(data.split("&@&")[i].split("@*@")[10] != "")
                		_items[i] += "<strong style='font-size: 14px;'>"+dic("Tracking.Suburb",lang)+":</strong> " + data.split("&@&")[i].split("@*@")[10] + "<br />";
                	if(data.split("&@&")[i].split("@*@")[11] != "")
                		_items[i] += "<strong style='font-size: 14px;'>"+dic("Tracking.Administrative",lang)+":</strong> " + data.split("&@&")[i].split("@*@")[11] + "<br />"; 
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
            	_items[i] += "<strong style='font-size: 14px;'>"+ dic("Name",lang) +":</strong> " + data.split("&@&")[i].split("@*@")[3] + "<br />";
            	if(data.split("&@&")[i].split("@*@")[4] != "")
            		_items[i] += "<strong style='font-size: 14px;'>"+dic("Tracking.Type",lang)+":</strong> " + data.split("&@&")[i].split("@*@")[4] + "<br />";
            	if(data.split("&@&")[i].split("@*@")[5] != "")
            		_items[i] += "<strong style='font-size: 14px;'>"+ dic("Tracking.Class",lang)+ ":</strong> " + data.split("&@&")[i].split("@*@")[5] + "<br />";
            	if(data.split("&@&")[i].split("@*@")[6] != "")
            		_items[i] += "<strong style='font-size: 14px;'>"+ dic("Tracking.Icon",lang)+":</strong> <img alt='' style='background-color: White;' src='" + data.split("&@&")[i].split("@*@")[6] + "' /><br />";
            	_items[i] += "<strong style='font-size: 14px;'>Country:</strong> " + data.split("&@&")[i].split("@*@")[7] + "<br />";
            	if(data.split("&@&")[i].split("@*@")[8] != "")
            		_items[i] += "<strong style='font-size: 14px;'>"+dic("Tracking.City",lang)+":</strong> " + data.split("&@&")[i].split("@*@")[8] + "<br />";
        		if(data.split("&@&")[i].split("@*@")[9] != "")
            		_items[i] += "<strong style='font-size: 14px;'>"+dic("Tracking.Country",lang)+" "+ dic("Tracking.Code",lang) + ":</strong> " + data.split("&@&")[i].split("@*@")[9] + "<br />";
            	if(data.split("&@&")[i].split("@*@")[10] != "")
            		_items[i] += "<strong style='font-size: 14px;'>"+dic("Tracking.Suburb",lang)+":</strong> " + data.split("&@&")[i].split("@*@")[10] + "<br />";
            	if(data.split("&@&")[i].split("@*@")[11] != "")
            		_items[i] += "<strong style='font-size: 14px;'>"+dic("Tracking.Administrative",lang)+":</strong> " + data.split("&@&")[i].split("@*@")[11] + "<br />";
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

    //ClearRouteScreen();
    $.ajax({
        url: "../routes/LoadRoute.php?id=" + _id,
        context: document.body,
        success: function (data) {
            //var _dat = JXG.decompress(data);
            var _dat = data;
            if(_dat != "notok")
            {
	            PointsOfRoute = [];
	            for (var i = 1; i < _dat.split("#@")[0].split("#").length; i++) {
	                putInRoute(_dat.split("#@")[0].split("#")[i].split("|")[2], _dat.split("#@")[0].split("#")[i].split("|")[0], _dat.split("#@")[0].split("#")[i].split("|")[1], _dat.split("#@")[0].split("#")[i].split("|")[3], 1, _idRoute);
	            }
	            zoomWorldScreen(Maps[0], 16);
           	}
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
        if (Browser() != 'iPad')
        	var _html = '<div class="text8 corner5" onmousemove="ShowPopup(event, \'' + dic("Name", lang) + ': ' + _name + '\')" onmouseout="HidePopup()" ondblclick="setCenterMap(' + _lon + ', ' + _lat + ', 17,0)" style="cursor: pointer; font-size:12; width:97%; padding:2px 2px 2px 7px; height:26px; background-image: url(\'images/updown.png\'); background-position: right center; background-repeat: no-repeat; background-origin: content-box;" id="IDMarker_' + _id + '_' + _len + '">';
    	else
    		var _html = '<div class="text8 corner5" onclick="setCenterMap(' + _lon + ', ' + _lat + ', 17,0)" style="cursor: pointer; font-size:12; width:97%; padding:2px 2px 2px 7px; height:26px; background-image: url(\'images/updown.png\'); background-position: right center; background-repeat: no-repeat; background-origin: content-box;" id="IDMarker_' + _id + '_' + _len + '">';
        _html += '<input type="text" class="text9" readonly="readonly" value="' + _name + '" style="font-size: 11px; cursor: pointer; width: 50%; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" />';
        _html += '<input type="text" class="text9" readonly="readonly" value="/" style="font-size: 11px; cursor: pointer; width: 20%; padding-left: 56px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" />';
        _html += '<input type="text" class="text9" readonly="readonly" value="/" style="font-size: 11px; cursor: pointer; width: 20%; text-align: center; padding-left: 10px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" />';
        _html += '<button style="float:right; width:29px; right: 30px;" id="MLBtnDel_' + _id + '_' + _len + '" value="Delete" onclick="BtnDeleteMarkerFromList(\'IDMarker_' + _id + '_' + _len + '\',\'' + (tmpMarkersRoute.length - 1) + '\')">&nbsp;</button>';
        _html += '</div>';
        $('#MarkersIN').append(_html);
        $('#IDMarker_Total').css({ display: 'block' });
        $('#report-content').css({ height: (parseInt($('#report-content').css('height'), 10) + 30) + 'px' });
        $('#MLBtnDel_' + _id + '_' + _len).button({ icons: { primary: "ui-icon-trash"} });
        unchange();
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
        url: "LoadRoute.php?id=" + _id,
        context: document.body,
        success: function (data) {
            //var _dat = JXG.decompress(data);
            var _dat = data;
            if(_dat != "notok")
            {
	            PointsOfRoute = [];
	            for (var i = 1; i < _dat.split("#@")[0].split("#").length; i++) {
	                putInRoute(_dat.split("#@")[0].split("#")[i].split("|")[2], _dat.split("#@")[0].split("#")[i].split("|")[0], _dat.split("#@")[0].split("#")[i].split("|")[1], _dat.split("#@")[0].split("#")[i].split("|")[3], 1, _id);
	            }
	            zoomWorldScreen(Maps[0], 16);
            }
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
    //alert('ChangeVehDriv.php?idVeh=' + _idVeh + '&idDriv=' + _idCh + '&l=' + lang);
    //return false;
    $.ajax({
        url: 'ChangeVehDriv.php?idVeh=' + _idVeh + '&idDriv=' + _idCh + '&l=' + lang,
        success: function (data) {
            if (data.indexOf("Ok") != -1) {
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
function HideShowTopPanel(cntTP){
	if (TopPanelVisible==true) {
		var bh = document.body.clientHeight - 55 - 50
		var hStep = bh/5
		if (cntTP!=5){
			cntTP = cntTP + 1
			document.getElementById('top1').style.height= (hStep*cntTP) +'px'
			document.getElementById('topmiddle1').style.height= (hStep*cntTP)+'px'
			setTimeout("HideShowTopPanel("+cntTP+")",20);
		} else {
			document.getElementById('top1').style.height= bh +'px'
			document.getElementById('topmiddle1').style.height= bh+'px'
			document.getElementById('strelkatop').style.backgroundImage='URL(../images/gores.png)'
			TopPanelVisible = false;
			document.getElementById('iFrmS').style.height = (document.getElementById('topmiddle1').offsetHeight) + 'px'
			document.getElementById('iFrmS').style.display = ''
			//document.getElementById('iFrmS').src = document.getElementById('iFrmS').src
		}
	} else {
		var bh = document.body.clientHeight - 55 - 50
		var hStep = bh/5
		if (cntTP!=5){
			cntTP = cntTP + 1
			var tmp = 5-cntTP
			document.getElementById('iFrmS').style.display = 'none'
			document.getElementById('top1').style.height= (hStep*tmp) +'px'
			//document.getElementById('top1').style.height= (hStep*tmp) +'5px'
			document.getElementById('topmiddle1').style.height= (hStep*tmp)+'px'
			setTimeout("HideShowTopPanel("+cntTP+")",20)	
		} else {
			document.getElementById('top1').style.height= '5px'
			document.getElementById('topmiddle1').style.height= '1px'	
			document.getElementById('strelkatop').style.backgroundImage='URL(../images/dolus.png)'
			TopPanelVisible = true;
			
		}
	}
}
function clearTimeOutAlertView(){
	window.clearTimeout(TimerAlarms);
}
function setTimeOutAlertView(){
	TimerAlarms = window.setTimeout("$('#div-mainalerts').fadeOut('slow');", 3000);
}
function ShowHideMail(){
	
}
function ShowHideAlerts(){
	if($('#div-mainalerts').css('display') == "block")
	{
		$('#div-mainalerts').fadeOut('slow');
	} else
	{
		$('#div-mainalerts').fadeIn('slow');
		window.clearTimeout(TimerAlarms);
		TimerAlarms = window.setTimeout("$('#div-mainalerts').fadeOut('slow');", 3000);
	}
}
function opacityIn(_num){
	$('#div-alerts_'+_num).css({ opacity: '1' });
}
function opacityOut(_num){
	$('#div-alerts_'+_num).css({ opacity: '0.7' });
}
function AlertEventHide(_num, _dt, _reg, _type, _vehid){
	if (parseInt($('#alertsNew').val(), 10) <= 1)
	{
		//$('#alertsNew').css({ visibility: 'hidden' });
		//$('#alertsNew').val(0);
		//$('#div-alerts_' + _num).fadeOut('slow', function(){ $(this).remove(); });
		//$(document).attr({title: $(document).attr('title').substring($(document).attr('title').indexOf(" ")+1,$(document).attr('title').length) });
		OpenMapAlarm1(_dt , _reg, _type, _vehid, _num);
		return;
	}
	//$('#div-alerts_' + _num).fadeOut('slow', function(){ $(this).remove(); });
	//$('#alertsNew').val(parseInt($('#alertsNew').val(), 10) - 1);
	//$(document).attr({title: '('+parseInt($('#alertsNew').val(), 10)+')' + $(document).attr('title').substring($(document).attr('title').indexOf(" "),$(document).attr('title').length) });
	OpenMapAlarm1(_dt , _reg, _type, _vehid, _num);
}
function AlertEvent(_dt, _reg, _type, _vehid){
	_num = "1";
	if(_num == "1"){
		if (Browser() == 'iPad')
			var _op = '1';
		else
			var _op = '0.7';
		$('#div-mainalerts').fadeIn('slow');
		window.clearTimeout(TimerAlarms);
		TimerAlarms = window.setTimeout("$('#div-mainalerts').fadeOut('slow');", 3000);
		var _idC = _vehid+"_"+_dt.split(" ")[0].split("-")[0]+"_"+_dt.split(" ")[0].split("-")[1]+"_"+_dt.split(" ")[0].split("-")[2]+"_"+_dt.split(" ")[1].split(":")[0]+"_"+_dt.split(" ")[1].split(":")[1]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[0]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[1];
		var _dtFormat = _dt.split(" ")[0].split("-")[2] + "-" + _dt.split(" ")[0].split("-")[1] + "-" + _dt.split(" ")[0].split("-")[0] + " " + _dt.split(" ")[1].split(":")[0]+":"+_dt.split(" ")[1].split(":")[1]+":"+_dt.split(" ")[1].split(":")[2].split(".")[0];
		var alertLeftList = '<div id="alarmList" style="overflow: hidden" class="div-one-vehicle-list text3 corner5" onclick="OpenMapAlarm1(\''+_dt+'\', \''+_reg+'\', \''+_type+'\', '+_vehid+', ' + ($('#alarms').children().length+1) + ')">';
		alertLeftList += '<div style="width: 91px; float:left;">';
		alertLeftList += '<div id="alarm-small-'+_idC+'" onMouseOver="ShowPopup(event, \''+dic("Tracking.Read",lang) + '/' +dic("",lang) + ' ' +dic("Tracking.Unread",lang) +' ' + dic("From",lang)+ ' ' + dic("Tracking.User",lang) +'\')" onMouseOut="HidePopup()" style="float:left; width:12px; height:12px; margin-left:5px; background-image: url(\'../images/no1.png\'); margin-top:1px; margin-bottom:2px; cursor:pointer"></div>';
		alertLeftList += '<div style="color: #000000; width: 68px; height: 14px; overflow: hidden; float:left; padding-top:2px; padding-left:3px; font-weight:bold; cursor:pointer" >'+_reg+'</div>';
		alertLeftList += '</div>';
		alertLeftList += '<div id="vh-date-" style="width:105px; position: relative; top: 2px; float:right; text-align:right; color:#000000; font-size:10px;">';
		alertLeftList += _dtFormat + '&nbsp;</div>';
		alertLeftList += '<div id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">';
		alertLeftList += dic("Tracking.Alarm",lang)+': <span style="font-weight: bold">' + dic(_type, lang) + '</span>';
		alertLeftList += '</div></div>';
		$($('#alarms').children()[0]).before(alertLeftList);
		
		if ($('#alertsNew').css('visibility') == "hidden")
		{
			$('#alertsNew').css({ visibility: 'visible' });
			var mt = '';
			$('#alertsNew').val(parseInt($('#alertsNew').val(), 10) + 1);
			$(document).attr({title: '('+$('#alertsNew').val()+') '+$(document).attr('title') });
			var alertIn = '<div onmouseover="opacityIn('+parseInt($('#alertsNew').val(), 10)+')" onmouseout="opacityOut('+parseInt($('#alertsNew').val(), 10)+')" id="div-alerts_'+parseInt($('#alertsNew').val(), 10)+'" class="corner15 shadowalerts" onclick="AlertEventHide('+parseInt($('#alertsNew').val(), 10) + ',\'' +_dt + '\',\'' + _reg + '\',\'' + _type + '\',\'' + _vehid + '\')" style="display: none; cursor: pointer; color: #fff; float: left; '+mt+'; height: 80px; padding-top: 10px; padding-left: 10px; background-color: #387CB0; position: relative; opacity: ' + _op + '; width: 290px;">';
			alertIn += '<font style="font-family: arial; font-size: 18px; font-weight: bold; top: 7px; left: 35px; position: absolute;">' + _reg + '</font>';
			alertIn += '<div class="ui-icon1 ui-icon-circle-close"></div><br/>';
			alertIn += '<div style="font-size: 14px; width: 279px; height: 50px; position: relative; top: -8px;"><strong style="margin-left: 15px;">'+ dic("Tracking.Alarm",lang) +': </strong> ' + dic(_type, lang) + '<br />';
			alertIn += '<strong style="margin-left: 15px;position: relative; top: 5px;">'+ dic("Tracking.Date",lang)+': </strong> <font style="position: relative; top: 5px;"> ' + _dt + '</font></div></div>';
			$('#div-mainalerts').html($('#div-mainalerts').html() + alertIn);
			$('#div-alerts_'+parseInt($('#alertsNew').val(), 10)).fadeIn('slow');
		} else
		{
			var mt = 'margin-bottom: 15px';
			$('#alertsNew').val(parseInt($('#alertsNew').val(), 10) + 1);
			$(document).attr({title: '('+parseInt($('#alertsNew').val(), 10)+')' + $(document).attr('title').substring($(document).attr('title').indexOf(" "),$(document).attr('title').length) });
			var alertIn = '<div onmouseover="opacityIn('+(parseInt($('#div-mainalerts').children()[0].id.substring($('#div-mainalerts').children()[0].id.lastIndexOf("_")+1,$('#div-mainalerts').children()[0].id.length), 10)+1)+')" onmouseout="opacityOut('+(parseInt($('#div-mainalerts').children()[0].id.substring($('#div-mainalerts').children()[0].id.lastIndexOf("_")+1,$('#div-mainalerts').children()[0].id.length), 10)+1)+')" id="div-alerts_'+(parseInt($('#div-mainalerts').children()[0].id.substring($('#div-mainalerts').children()[0].id.lastIndexOf("_")+1,$('#div-mainalerts').children()[0].id.length), 10)+1)+'" class="corner15 shadowalerts" onclick="AlertEventHide('+(parseInt($('#div-mainalerts').children()[0].id.substring($('#div-mainalerts').children()[0].id.lastIndexOf("_")+1,$('#div-mainalerts').children()[0].id.length), 10)+1) + ',\'' +_dt + '\',\'' + _reg + '\',\'' + _type + '\',\'' + _vehid + '\')" style="display: none; cursor: pointer; color: #fff; float: left; '+mt+'; height: 80px; padding-top: 10px; padding-left: 10px; background-color: #387CB0; position: relative; opacity: ' + _op + '; width: 290px;">';
			alertIn += '<font style="font-family: arial; font-size: 18px; font-weight: bold; top: 7px; left: 35px; position: absolute;">' + _reg + '</font>';
			alertIn += '<div class="ui-icon1 ui-icon-circle-close"></div><br/>';
			alertIn += '<div style="font-size: 14px; width: 279px; height: 50px; position: relative; top: -8px;"><strong style="margin-left: 15px;">Аларм: </strong> ' + dic(_type, lang) + '<br />';
			alertIn += '<strong style="margin-left: 15px;position: relative; top: 5px;">'+dic("Tracking.Date",lang)+': </strong> <font style="position: relative; top: 5px;"> ' + _dt + '</font></div></div>';
			$('#div-alerts_'+parseInt($('#div-mainalerts').children()[0].id.substring($('#div-mainalerts').children()[0].id.lastIndexOf("_")+1,$('#div-mainalerts').children()[0].id.length), 10)).before(alertIn);
			$('#div-alerts_'+parseInt($('#div-mainalerts').children()[0].id.substring($('#div-mainalerts').children()[0].id.lastIndexOf("_")+1,$('#div-mainalerts').children()[0].id.length), 10)).fadeIn('slow');
		}
	}
	pulsate10= 0;
	startplay();
	runEffect123('alertsNew');
	/* else
	{
		if (parseInt($('#alertsNew').val(), 10) <= 1)
		{
			$('#alertsNew').css({ visibility: 'hidden' });
			$('#alertsNew').val(0);
			$('#div-alerts_1').fadeOut('slow', function(){ $('#div-alerts_1').remove(); });
			return;
		}
		$('#div-alerts_' + parseInt($('#alertsNew').val(), 10)).fadeOut('slow', function(){ $(this).remove(); });
		$('#alertsNew').val(parseInt($('#alertsNew').val(), 10) - 1);
	}*/
}
function OpenMapAlarm(_dt, _reg, _type, _vehid){
	var _idC = _vehid+"_"+_dt.split(" ")[0].split("-")[0]+"_"+_dt.split(" ")[0].split("-")[1]+"_"+_dt.split(" ")[0].split("-")[2]+"_"+_dt.split(" ")[1].split(":")[0]+"_"+_dt.split(" ")[1].split(":")[1]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[0]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[1];
    $('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; z-index: 9999; border:0px" src=""></iframe>');
    document.getElementById('iframemaps').src = 'LoadMap.php?datetime=' + _dt + '&reg=' + _reg + '&type=' + _type + '&l=' + lang;
    if (Browser() == 'iPad') {
    	_w = 800;
    	_h = 500;
	} else {
		_w = 1000;
    	_h = 700;
	}
    $('#dialog-map').dialog({ modal: true, height: _h, width: _w, zIndex: 9999, beforeClose: function(event, ui) {
    	if(document.getElementById("iframemaps").contentWindow.$("#alarmZabeleska").val() == '')
    	{
    		
			document.getElementById("iframemaps").contentWindow.$('#alarmZabeleska').attr({ className: 'shadow corner5' });
			document.getElementById("iframemaps").contentWindow.$('#alarmZabeleska').css({ borderColor: 'Red' });
			document.getElementById("iframemaps").contentWindow.$('#alarmZabeleska').focus();
    		msgbox("Немате внесено забелешка!!!");
    		return false;
		} else
		{
			var note = document.getElementById("iframemaps").contentWindow.$("#alarmZabeleska").val();
			$.ajax({
		        url: "UpdateNoteAndReadStatusForAlarm.php?dt=" + _dt + "&type=" + _type + "&reg=" + _reg + "&note=" + note,
		        context: document.body,
		        success: function (data) {
		        	$('#alarm-small-'+_idC).css({ backgroundImage: 'url("../images/yes1.png")' });
		        }
			});
		}
	} });
}
function AlertEventHide1(_num, _dt, _reg, _type, _vehid){
	if (parseInt($('#alertsNew').val(), 10) <= 1)
	{
		$('#alertsNew').css({ visibility: 'hidden' });
		$('#alertsNew').val(0);
		$('#div-alerts_' + _num).fadeOut('slow', function(){ $(this).remove(); });
		$(document).attr({title: $(document).attr('title').substring($(document).attr('title').indexOf(" ")+1,$(document).attr('title').length) });
		//OpenMapAlarm(_dt , _reg, _type, _vehid);
		return;
	}
	$('#div-alerts_' + _num).fadeOut('slow', function(){ $(this).remove(); });
	$('#alertsNew').val(parseInt($('#alertsNew').val(), 10) - 1);
	$(document).attr({title: '('+parseInt($('#alertsNew').val(), 10)+')' + $(document).attr('title').substring($(document).attr('title').indexOf(" "),$(document).attr('title').length) });
	//OpenMapAlarm(_dt , _reg, _type, _vehid);
}
function AlertEvent1(_dt, _reg, _type, _vehid, _num){
	if (Browser() == 'iPad')
		var _op = '1';
	else
		var _op = '0.7';
	window.clearTimeout(TimerAlarms);
	$('#div-mainalerts').fadeIn('slow');
	TimerAlarms = window.setTimeout("$('#div-mainalerts').fadeOut('slow');", 3000);
	if ($('#alertsNew').css('visibility') == "hidden")
	{
		$('#alertsNew').css({ visibility: 'visible' });
		var mt = 'margin-bottom: 15px';
		$('#alertsNew').val(parseInt($('#alertsNew').val(), 10) + 1);
		$(document).attr({title: '('+$('#alertsNew').val()+') '+$(document).attr('title') });
		var alertIn = '<div onmouseover="opacityIn('+parseInt(_num, 10)+')" onmouseout="opacityOut('+parseInt(_num, 10)+')" id="div-alerts_'+parseInt(_num, 10)+'" class="corner15 shadowalerts" onclick="AlertEventHide('+parseInt(_num, 10) + ',\'' +_dt + '\',\'' + _reg + '\',\'' + _type + '\',\'' + _vehid + '\')" style="display: none; cursor: pointer; color: #fff; float: left; '+mt+'; height: 80px; padding-top: 10px; padding-left: 10px; background-color: #387CB0; position: relative; opacity: ' + _op + '; width: 290px;">';
		alertIn += '<font style="font-family: arial; font-size: 18px; font-weight: bold; top: 7px; left: 35px; position: absolute;">' + _reg + '</font>';
		alertIn += '<div class="ui-icon1 ui-icon-circle-close"></div><br/>';
		alertIn += '<div style="font-size: 14px; width: 279px; height: 50px; position: relative; top: -8px;"><strong style="margin-left: 15px;">'+dic("Tracking.Alarm",lang)+': </strong> ' + dic(_type, lang) + '<br />';
		alertIn += '<strong style="margin-left: 15px;position: relative; top: 5px;">'+ dic("Tracking.Date",lang)+': </strong> <font style="position: relative; top: 5px;"> ' + _dt.split(" ")[1].substring(0,_dt.split(" ")[1].indexOf("."))+" "+_dt.split(" ")[0].split("-")[2]+"-"+_dt.split(" ")[0].split("-")[1]+"-"+_dt.split(" ")[0].split("-")[0] + '</font></div></div>';
		$('#div-mainalerts').html($('#div-mainalerts').html() + alertIn);
		$('#div-alerts_'+parseInt(_num, 10)).fadeIn('slow');
	} else
	{
		var mt = 'margin-bottom: 15px';
		$('#alertsNew').val(parseInt($('#alertsNew').val(), 10) + 1);
		$(document).attr({title: '('+parseInt($('#alertsNew').val(), 10)+')' + $(document).attr('title').substring($(document).attr('title').indexOf(" "),$(document).attr('title').length) });
		var alertIn = '<div onmouseover="opacityIn('+parseInt(_num, 10)+')" onmouseout="opacityOut('+parseInt(_num, 10)+')" id="div-alerts_'+parseInt(_num, 10)+'" class="corner15 shadowalerts" onclick="AlertEventHide('+parseInt(_num, 10) + ',\'' +_dt + '\',\'' + _reg + '\',\'' + _type + '\',\'' + _vehid + '\')" style="display: none; cursor: pointer; color: #fff; float: left; '+mt+'; height: 80px; padding-top: 10px; padding-left: 10px; background-color: #387CB0; position: relative; opacity: ' + _op + '; width: 290px;">';
		alertIn += '<font style="font-family: arial; font-size: 18px; font-weight: bold; top: 7px; left: 35px; position: absolute;">' + _reg + '</font>';
		alertIn += '<div class="ui-icon1 ui-icon-circle-close"></div><br/>';
		alertIn += '<div style="font-size: 14px; width: 279px; height: 50px; position: relative; top: -8px;"><strong style="margin-left: 15px;">'+dic("Tracking.Alarm",lang)+': </strong> ' + dic(_type, lang) + '<br />';
		alertIn += '<strong style="margin-left: 15px;position: relative; top: 5px;">'+dic("Tracking.Date",lang)+': </strong> <font style="position: relative; top: 5px;"> ' + _dt.split(" ")[1].substring(0,_dt.split(" ")[1].indexOf("."))+" "+_dt.split(" ")[0].split("-")[2]+"-"+_dt.split(" ")[0].split("-")[1]+"-"+_dt.split(" ")[0].split("-")[0] + '</font></div></div>';
		$('#div-alerts_'+(parseInt(_num, 10)+1)).after(alertIn);
		$('#div-alerts_'+parseInt(_num, 10)).fadeIn('slow');
	}
	if(parseInt($('#alertsNew').val(), 10) == 1)
	{
		startplay();
		runEffect123('alertsNew');
	}
}
var pulsate10 = 0;
function runEffect123(_id) {
	if(pulsate10 == 1)
	{
		pauseplay();
		return false;
	}
	pulsate10++;
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
    $("#" + _id).effect(selectedEffect, options, 500, callback123);
    
};

// callback function to bring a hidden box back
function callback123() {
    runEffect123('alertsNew');
};
function OpenMapAlarm1(_dt, _reg, _type, _vehid, _num){
	var _idC = _vehid+"_"+_dt.split(" ")[0].split("-")[0]+"_"+_dt.split(" ")[0].split("-")[1]+"_"+_dt.split(" ")[0].split("-")[2]+"_"+_dt.split(" ")[1].split(":")[0]+"_"+_dt.split(" ")[1].split(":")[1]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[0]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[1];
    $('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; z-index: 9999; border:0px" src=""></iframe>');
    document.getElementById('iframemaps').src = '../tracking/LoadMap.php?datetime=' + _dt + '&reg=' + _reg + '&type=' + _type + '&l=' + lang + '&num=' + _num;
    if (Browser() == 'iPad') {
    	_w = 800;
    	_h = 500;
	} else {
		_w = 1000;
    	_h = 700;
	}
    $('#dialog-map').dialog({ modal: true, height: _h, width: _w, zIndex: 9999, beforeClose: function(event, ui) {
    	if(document.getElementById("iframemaps").contentWindow.$("#alarmZabeleska").val() == '')
    	{
    		document.getElementById("iframemaps").contentWindow.$('#alarmZabeleska').attr({ className: 'shadow corner5' });
			document.getElementById("iframemaps").contentWindow.$('#alarmZabeleska').css({ borderColor: 'Red' });
			document.getElementById("iframemaps").contentWindow.$('#alarmZabeleska').focus();
    		msgbox(dic("Tracking.NotEnteredNotice",lang));
    		return false;
		} else
		{
			ShowWait();
			var note = document.getElementById("iframemaps").contentWindow.$("#alarmZabeleska").val();
			$.ajax({
		        url: "UpdateNoteAndReadStatusForAlarm.php?dt=" + _dt + "&type=" + _type + "&reg=" + _reg + "&note=" + note,
		        context: document.body,
		        success: function (data) {	
		        	var c2 = 0;
		        	var c1 = 0;
		        	for(var i=0; i < $('#alarms').children().length; i++)
		        	{
		        		if($('#alarms').children()[i].children[0].children[0].id == "alarm-small-"+_idC)
		        			c1 = i;
		        		if($('#alarms').children()[i].children[0].children[0].style.backgroundImage.indexOf("yes1") != -1)
		        			c2 = i;
	        			
	        		}
	        		$('#alarms').children()[c1].attributes[0].value = $('#alarms').children()[c1].attributes[0].value.replace("OpenMapAlarm1","OpenMapAlarm2");
	        		if(c2==0)
	        			$($('#alarms').children()[$('#alarms').children().length-1]).after($($('#alarms').children()[c1]));
        			else
	        			$($('#alarms').children()[c2]).before($($('#alarms').children()[c1]));
		        	$('#alarm-small-'+_idC).css({ backgroundImage: 'url("../images/yes1.png")' });
		        	AlertEventHide1(_num, _dt, _reg, _type, _vehid);
		        	HideWait();
		        }
			});
		}
	} });
}
function OpenMapAlarm2(_dt, _reg, _type, _vehid, _num){
	var _idC = _vehid+"_"+_dt.split(" ")[0].split("-")[0]+"_"+_dt.split(" ")[0].split("-")[1]+"_"+_dt.split(" ")[0].split("-")[2]+"_"+_dt.split(" ")[1].split(":")[0]+"_"+_dt.split(" ")[1].split(":")[1]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[0]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[1];
    $('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; z-index: 9999; border:0px" src=""></iframe>');
    document.getElementById('iframemaps').src = '../tracking/LoadMapZ.php?datetime=' + _dt + '&reg=' + _reg + '&type=' + _type + '&l=' + lang + '&num=' + _num;
    if (Browser() == 'iPad') {
    	_w = 800;
    	_h = 500;
	} else {
		_w = 1000;
    	_h = 700;
	}
    $('#dialog-map').dialog({ modal: true, height: _h, width: _w, zIndex: 9999 });
}
function OpenMapAlarm3(_dt, _reg, _type, _vehid, _num){
	var _idC = _vehid+"_"+_dt.split(" ")[0].split("-")[0]+"_"+_dt.split(" ")[0].split("-")[1]+"_"+_dt.split(" ")[0].split("-")[2]+"_"+_dt.split(" ")[1].split(":")[0]+"_"+_dt.split(" ")[1].split(":")[1]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[0]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[1];
    $('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; z-index: 9999; border:0px" src=""></iframe>');
    document.getElementById('iframemaps').src = '../report/LoadMapAlarm.php?datetime=' + _dt + '&reg=' + _reg + '&type=' + _type + '&l=' + lang + '&num=' + _num;
    if (Browser() == 'iPad') {
    	_w = 800;
    	_h = 500;
	} else {
		_w = 1000;
    	_h = 700;
	}
    $('#dialog-map').dialog({ modal: true, height: _h, width: _w, zIndex: 9999 });
}
function searchVehicle (term){
    var suche = term.value.toLowerCase();
    for (var k=0; k < $('#menu-container-4')[0].children.length; k++) {
		ele = $('#menu-container-4')[0].children[k].children[1].children[1].innerHTML.replace(/<[^>]+>/g,"");
		if (ele.toLowerCase().indexOf(suche)>=0 )
		    $('#menu-container-4')[0].children[k].style.display = '';
		else 
			$('#menu-container-4')[0].children[k].style.display = 'none';
	}
}
function searchByDriver (term){
    var suche = term.value.toLowerCase();
    for (var k=0; k < $('#menu-container-4')[0].children.length; k++) {
		ele = $('#menu-container-4')[0].children[k].children[4].children[0].innerHTML.replace(/<[^>]+>/g,"");
		if (ele.toLowerCase().indexOf(suche)>=0 )
		    $('#menu-container-4')[0].children[k].style.display = '';
		else 
			$('#menu-container-4')[0].children[k].style.display = 'none';
	}
}
var snoozeTmp = 0;
function snoozeAlarm() {
	if(snoozeTmp == (snooze*60))
	{
		startplay();
		runEffect123('alertsNew');
	} else
	{
		snoozeTmp++;
		setTimeout("snoozeAlarm()", 1000);
	}
}

function pauseplay()
{
	soundHandle = document.getElementById('soundHandle');
  	soundHandle.pause();
  	pulsate10= 0;
  	snoozeTmp = 0;
  	snoozeAlarm();
}
function startplay()
{
	soundHandle = document.getElementById('soundHandle');
  	soundHandle.src = 'sound/Small_Blink.ogg';
  	soundHandle.play();
}

function closedialog()
{
	$('#dialog-map').dialog('destroy');
}
function costVehicleW (i, id, reg) {
	document.getElementById('div-cost').title = "Додавање трошок - " + reg;
	ShowWait()
	$.ajax({
        url: 'AddCostW.php?l=' + lang + '&vehid=' + id,
        context: document.body,
        success: function (data) {
        	HideWait();
            $('#div-cost').html(data);
            $('#div-cost').dialog({ modal: true, height: 680, width: 510,
							zIndex: 9001 ,
                buttons:
                 [
                     {
                         text: dic("add", '<?php echo $cLang ?>'),
                         click: function () {
            		        if($("#costtype").children(":selected").attr("id") == "Fuel") {
            		        	var dt = document.getElementById("datetime").value;
            		        	var driver = "";
            		        	if (document.getElementById("driver"))
            		        		driver = document.getElementById("driver").value;
	                            var km = (document.getElementById("km").value).replace(",", "");
	                            var liters = document.getElementById("liters").value;
	                            var litersLast = document.getElementById("litersLast").value;
	                            var price = (document.getElementById("price").value).replace(",", "");
								var veh = id;
								var pay = document.getElementById("pay").value;
								var loc = document.getElementById("location").value;
								
								//alert("InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&price=" + price + "&vehID=" + veh)
								document.getElementById('liters').style.border = "1px solid #cccccc"
								document.getElementById('price').style.border = "1px solid #cccccc"
								
								if (liters == "") {
									alert("Внесете дотур на гориво !!!")
									document.getElementById('liters').style.border = "1px solid red"
									document.getElementById('liters').select()
								}
								if (price == "") {
									alert("Внесете износ на трошокот за гориво !!!")
									document.getElementById('price').style.border = "1px solid red"
									if (liters == "") document.getElementById('liters').select()
									else document.getElementById('price').select()
								}
								
								
								
	                          
	                          $.ajax({
						           url: 'CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt,
						           context: document.body,
						           success: function (data) {
						           		if (Math.abs(km - data) > (data * 20/100)) {
						           			var msg = "<div>Километрите кои ги внесовте во полето Одометар (" + km + " Km) драстично се разликуваат од километрите пресметани преку GPS (" + data + " Km).<br>Дали сте сигурни дека трошокот е направен на <font style='color:#FF6633;font-weight:bold'>" + km + " Km</font>?</div>";
						           			$('#div-msgbox1').html(msg)
											$( "#dialog:ui-dialog" ).dialog( "destroy" );	
											$( "#dialog-message1" ).dialog({ height: 220, width: 440,
												modal: true,
										        resizable: false,
												zIndex: 9999 ,
												buttons: {
													"Да": function() {
														if (price != "" && liters != "") {
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														      $.ajax({
		                                url: "InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&loc=" + loc + "&price=" + price + "&vehID=" + veh + '&pay=' + pay,
		                                context: document.body,
		                                success: function (data) {
		                                    $(this).dialog("close");
		                                    mymsg("Успешно додадовте трошок за гориво !!!")
		                                    location.reload();
		                                }
		                            });
														        
														        $.ajax({
														              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
													},
													"Откажи": function() {
														$( this ).dialog( "close" );
														document.getElementById('km').value = data;
													},
												}
											});
						           		} else {
						           				if (price != "" && liters != "") {
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														     $.ajax({
		                                url: "InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&loc=" + loc + "&price=" + price + "&vehID=" + veh + '&pay=' + pay,
		                                context: document.body,
		                                success: function (data) {
		                                    $(this).dialog("close");
		                                    mymsg("Успешно додадовте трошок за гориво !!!")
		                                    location.reload();
		                                }
		                            }); 
														        
														        $.ajax({
														              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
						           		}
						           		
						           	}
						           });
	                          
	                          
	                          
            		        } else {
            		        	if ($("#costtype").children(":selected").attr("id") == "Service") {
            		        		var dt = document.getElementById("datetime").value;
            		        		var driver = "";
                		        	if (document.getElementById("driver"))
                		        		driver = document.getElementById("driver").value;
							        var veh = id;
							        var km = (document.getElementById("km").value).replace(",", "");
							        var type = $('input[name=type]:radio:checked').val();
							        var loc = document.getElementById("location").value;
							        var desc = document.getElementById("desc").value;
							        //var comp = document.getElementById("components").value;
							        var comp= "";
							        for (var i=0; i < $('#components-').children().length; i++) {
										comp += ($('#components-').children()[i].id).split("li-")[1] + ";";
									}
							        var price = (document.getElementById("price").value).replace(",", "");
							        var pay = document.getElementById("pay").value;
							        
							        document.getElementById('desc').style.border = "1px solid #cccccc"
									document.getElementById('price').style.border = "1px solid #cccccc"
								
								if (desc == "") {
									alert("Внесете опис на сервисот !!!")
									document.getElementById('desc').style.border = "1px solid red"
									document.getElementById('desc').select()
								}
								if (price == "") {
									alert("Внесете износ на трошокот за сервис !!!")
									document.getElementById('price').style.border = "1px solid red"
									if (liters == "") document.getElementById('liters').select()
									else document.getElementById('price').select()
								}
								
								
								$.ajax({
						           url: 'CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt,
						           context: document.body,
						           success: function (data) {
						           		if (Math.abs(km - data) > (data * 20/100)) {
						           			var msg = "<div>Километрите кои ги внесовте во полето Одометар (" + km + " Km) драстично се разликуваат од километрите пресметани преку GPS (" + data + " Km).<br>Дали сте сигурни дека трошокот е направен на <font style='color:#FF6633;font-weight:bold'>" + km + " Km</font>?</div>";
						           			$('#div-msgbox1').html(msg)
											$( "#dialog:ui-dialog" ).dialog( "destroy" );	
											$( "#dialog-message1" ).dialog({ height: 220, width: 440,
												modal: true,
										        resizable: false,
												zIndex: 9999 ,
												buttons: {
													"Да": function() {
														if (price != "" && desc != "") {
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														      $.ajax({
														              url: "InsertService.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
														              context: document.body,
														              success: function (data) {
														                $(this).dialog("close");
														                mymsg("Успешно додадовте трошок за сервис !!!")
								                                    	location.reload();   
														              }
														        }); 
														        
														        $.ajax({
														              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
													},
													"Откажи": function() {
														$( this ).dialog( "close" );
														document.getElementById('km').value = data;
													},
												}
											});
						           		} else {
						           				if (price != "" && desc != "") {
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														      $.ajax({
														              url: "InsertService.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
														              context: document.body,
														              success: function (data) {
														                $(this).dialog("close");
														                mymsg("Успешно додадовте трошок за сервис !!!")
								                                    	location.reload();   
														              }
														        }); 
														        
														        $.ajax({
														              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
						           		}
						           		
						           	}
						           });
	           	
																		
								
            		        	} else {
            		        		 if($("#costtype").children(":selected").attr("id") == "Cost") {
            		        		var dt = document.getElementById("datetime").value;
            		        		var driver = "";
                		        	if (document.getElementById("driver"))
                		        		driver = document.getElementById("driver").value;
							        var veh = id;
							        var km = (document.getElementById("km").value).replace(",", "");
							        var desc = document.getElementById("desc").value;
							        var comp = "";//document.getElementById("components").value;
							        for (var i=0; i < $('#components-').children().length; i++) {
										comp += ($('#components-').children()[i].id).split("li-")[1] + ";";
									}
									
							        var price = (document.getElementById("price").value).replace(",", "");
							        var pay = document.getElementById("pay").value;
							        var loc = document.getElementById("location").value;
							        
							    document.getElementById('desc').style.border = "1px solid #cccccc"
									document.getElementById('price').style.border = "1px solid #cccccc"
								
								if (desc == "") {
									alert("Внесете опис на останатиот трошок !!!")
									document.getElementById('desc').style.border = "1px solid red"
									document.getElementById('desc').select()
								}
								if (price == "") {
									alert("Внесете износ на останатиот трошок !!!")
									document.getElementById('price').style.border = "1px solid red"
									if (liters == "") document.getElementById('liters').select()
									else document.getElementById('price').select()
								}
								
								
								
								
								$.ajax({
						           url: 'CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt,
						           context: document.body,
						           success: function (data) {
						           		if (Math.abs(km - data) > (data * 20/100)) {
						           			var msg = "<div>Километрите кои ги внесовте во полето Одометар (" + km + " Km) драстично се разликуваат од километрите пресметани преку GPS (" + data + " Km).<br>Дали сте сигурни дека трошокот е направен на <font style='color:#FF6633;font-weight:bold'>" + km + " Km</font>?</div>";
						           			$('#div-msgbox1').html(msg)
											$( "#dialog:ui-dialog" ).dialog( "destroy" );	
											$( "#dialog-message1" ).dialog({ height: 220, width: 440,
												modal: true,
										        resizable: false,
												zIndex: 9999 ,
												buttons: {
													"Да": function() {
														if (price != "" && desc != "") {
																																
																//alert("InsertCost.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&comp=" + htmlstring + "&price=" + price + "&pay=" + pay)
														     	$.ajax({
														          url: "InsertCost.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&loc=" + loc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
														              context: document.body,
														              success: function (data) {
														                    $(this).dialog("close");
														                    mymsg("Успешно додадовте останат трошок !!!")
								                                    		location.reload();
														              }
														        }); 
							  																        
														        $.ajax({
														              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
													},
													"Откажи": function() {
														$( this ).dialog( "close" );
														document.getElementById('km').value = data;
													},
												}
											});
						           		} else {
						           			if (price != "" && desc != "") {
																																
													//alert("InsertCost.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&comp=" + htmlstring + "&price=" + price + "&pay=" + pay)
											     	$.ajax({
											          url: "InsertCost.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&loc=" + loc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
											              context: document.body,
											              success: function (data) {
											                    $(this).dialog("close");
											                    mymsg("Успешно додадовте останат трошок !!!")
					                                    		location.reload();
											              }
											        }); 
				  																        
											        $.ajax({
											              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
											              context: document.body,
											              success: function (data) {
											    
											              }
											        }); 
											        
					                           }
						           		}
						           		
						           	}
						           });
						           
						           
								
								  } else {
								  	if($("#costtype").children(":selected").attr("id") == "0")
								  	{
								  		mymsg("Немате избрано ниту еден трошок за внес !!!");
								  	} else {
								  		var costtypeid = $("#costtype").children(":selected").attr("id");
								  		var dt = document.getElementById("datetime").value;
								  		var km = (document.getElementById("km").value).replace(",", "");
								  		var loc = document.getElementById("location").value;
								  		var driver = "";
	                		        	if (document.getElementById("driver"))
	                		        		driver = document.getElementById("driver").value;
	                		        	var pay = document.getElementById("pay").value;
                		        		var price = (document.getElementById("price").value).replace(",", "");
                		        		var veh = id;
                		        		if (price != "") {
                		        			$.ajax({
									          url: "InsertNewCost.php?costtypeid=" + costtypeid + "&dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&loc=" + loc + "&price=" + price + "&pay=" + pay,
									              context: document.body,
									              success: function (data) {
									                    $(this).dialog("close");
									                    mymsg("Успешно додадовте трошок !!!")
			                                    		location.reload();
									              }
									        }); 
                		        		}	else {
                		        			alert("Внесете износ на трошокот !!!")
											document.getElementById('price').style.border = "1px solid red"
											if (liters == "") document.getElementById('liters').select()
											else document.getElementById('price').select()
                		        		}
								  	}
								  	
								  }              		        	}
            		        }
                         }
                     },
                     {
                         text: dic("cancel", '<?php echo $cLang ?>'),
                         click: function () {
                             //$('#div-cost').dialog("destroy");
                             $( this ).dialog( "close" );
                         }
                     }
                 ]
            });
        }
    });
}
function costVehicle123 (i, id, reg) {
	document.getElementById('div-cost').title = "Додавање трошок";
	ShowWait()
	$.ajax({
        url: 'AddCost.php?l=' + lang + '&vehid=' + id,
        context: document.body,
        success: function (data) {
        	HideWait();
            $('#div-cost').html(data);
            $('#div-cost').dialog({ modal: true, height: 680, width: 510,
							zIndex: 9001 ,
                buttons:
                 [
                     {
                         text: dic("add", '<?php echo $cLang ?>'),
                         click: function () {
            		        if($("#costtype").children(":selected").attr("id") == "Fuel") {
            		        	var dt = document.getElementById("datetime").value;
            		        	var driver = "";
            		        	if (document.getElementById("driver"))
            		        		driver = document.getElementById("driver").value;
	                            var km = (document.getElementById("km").value).replace(",", "");
	                            var liters = document.getElementById("liters").value;
	                            var litersLast = document.getElementById("litersLast").value;
	                            var price = (document.getElementById("price").value).replace(",", "");
								var veh = id;
								var pay = document.getElementById("pay").value;
								var loc = document.getElementById("location").value;
								
								//alert("InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&price=" + price + "&vehID=" + veh)
								document.getElementById('liters').style.border = "1px solid #cccccc"
								document.getElementById('price').style.border = "1px solid #cccccc"
								
								if (liters == "") {
									alert("Внесете дотур на гориво !!!")
									document.getElementById('liters').style.border = "1px solid red"
									document.getElementById('liters').select()
								}
								if (price == "") {
									alert("Внесете износ на трошокот за гориво !!!")
									document.getElementById('price').style.border = "1px solid red"
									if (liters == "") document.getElementById('liters').select()
									else document.getElementById('price').select()
								}
								
								
								
	                          
	                          $.ajax({
						           url: 'CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt,
						           context: document.body,
						           success: function (data) {
						           		if (Math.abs(km - data) > (data * 20/100)) {
						           			var msg = "<div>Километрите кои ги внесовте во полето Одометар (" + km + " Km) драстично се разликуваат од километрите пресметани преку GPS (" + data + " Km).<br>Дали сте сигурни дека трошокот е направен на <font style='color:#FF6633;font-weight:bold'>" + km + " Km</font>?</div>";
						           			$('#div-msgbox1').html(msg)
											$( "#dialog:ui-dialog" ).dialog( "destroy" );	
											$( "#dialog-message1" ).dialog({ height: 220, width: 440,
												modal: true,
										        resizable: false,
												zIndex: 9999 ,
												buttons: {
													"Да": function() {
														if (price != "" && liters != "") {
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														      $.ajax({
		                                url: "InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&loc=" + loc + "&price=" + price + "&vehID=" + veh + '&pay=' + pay,
		                                context: document.body,
		                                success: function (data) {
		                                    $(this).dialog("close");
		                                    mymsg("Успешно додадовте трошок за гориво !!!")
		                                    location.reload();
		                                }
		                            });
														        
														        $.ajax({
														              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
													},
													"Откажи": function() {
														$( this ).dialog( "close" );
														document.getElementById('km').value = data;
													},
												}
											});
						           		} else {
						           				if (price != "" && liters != "") {
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														     $.ajax({
		                                url: "InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&loc=" + loc + "&price=" + price + "&vehID=" + veh + '&pay=' + pay,
		                                context: document.body,
		                                success: function (data) {
		                                    $(this).dialog("close");
		                                    mymsg("Успешно додадовте трошок за гориво !!!")
		                                    location.reload();
		                                }
		                            }); 
														        
														        $.ajax({
														              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
						           		}
						           		
						           	}
						           });
	                          
	                          
	                          
            		        } else {
            		        	if ($("#costtype").children(":selected").attr("id") == "Service") {
            		        		var dt = document.getElementById("datetime").value;
            		        		var driver = "";
                		        	if (document.getElementById("driver"))
                		        		driver = document.getElementById("driver").value;
							        var veh = id;
							        var km = (document.getElementById("km").value).replace(",", "");
							        var type = $('input[name=type]:radio:checked').val();
							        var loc = document.getElementById("location").value;
							        var desc = document.getElementById("desc").value;
							        //var comp = document.getElementById("components").value;
							        var comp= "";
							        for (var i=0; i < $('#components-').children().length; i++) {
										comp += ($('#components-').children()[i].id).split("li-")[1] + ";";
									}
							        var price = (document.getElementById("price").value).replace(",", "");
							        var pay = document.getElementById("pay").value;
							        
							        document.getElementById('desc').style.border = "1px solid #cccccc"
									document.getElementById('price').style.border = "1px solid #cccccc"
								
								if (desc == "") {
									alert("Внесете опис на сервисот !!!")
									document.getElementById('desc').style.border = "1px solid red"
									document.getElementById('desc').select()
								}
								if (price == "") {
									alert("Внесете износ на трошокот за сервис !!!")
									document.getElementById('price').style.border = "1px solid red"
									if (liters == "") document.getElementById('liters').select()
									else document.getElementById('price').select()
								}
								
								
								$.ajax({
						           url: 'CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt,
						           context: document.body,
						           success: function (data) {
						           		if (Math.abs(km - data) > (data * 20/100)) {
						           			var msg = "<div>Километрите кои ги внесовте во полето Одометар (" + km + " Km) драстично се разликуваат од километрите пресметани преку GPS (" + data + " Km).<br>Дали сте сигурни дека трошокот е направен на <font style='color:#FF6633;font-weight:bold'>" + km + " Km</font>?</div>";
						           			$('#div-msgbox1').html(msg)
											$( "#dialog:ui-dialog" ).dialog( "destroy" );	
											$( "#dialog-message1" ).dialog({ height: 220, width: 440,
												modal: true,
										        resizable: false,
												zIndex: 9999 ,
												buttons: {
													"Да": function() {
														if (price != "" && desc != "") {
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														      $.ajax({
														              url: "InsertService.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
														              context: document.body,
														              success: function (data) {
														                $(this).dialog("close");
														                mymsg("Успешно додадовте трошок за сервис !!!")
								                                    	location.reload();   
														              }
														        }); 
														        
														        $.ajax({
														              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
													},
													"Откажи": function() {
														$( this ).dialog( "close" );
														document.getElementById('km').value = data;
													},
												}
											});
						           		} else {
						           				if (price != "" && desc != "") {
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														      $.ajax({
														              url: "InsertService.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
														              context: document.body,
														              success: function (data) {
														                $(this).dialog("close");
														                mymsg("Успешно додадовте трошок за сервис !!!")
								                                    	location.reload();   
														              }
														        }); 
														        
														        $.ajax({
														              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
						           		}
						           		
						           	}
						           });
	           	
																		
								
            		        	} else {
            		        		 if($("#costtype").children(":selected").attr("id") == "Cost") {
            		        		var dt = document.getElementById("datetime").value;
            		        		var driver = "";
                		        	if (document.getElementById("driver"))
                		        		driver = document.getElementById("driver").value;
							        var veh = id;
							        var km = (document.getElementById("km").value).replace(",", "");
							        var desc = document.getElementById("desc").value;
							        var comp = "";//document.getElementById("components").value;
							        for (var i=0; i < $('#components-').children().length; i++) {
										comp += ($('#components-').children()[i].id).split("li-")[1] + ";";
									}
									
							        var price = (document.getElementById("price").value).replace(",", "");
							        var pay = document.getElementById("pay").value;
							        var loc = document.getElementById("location").value;
							        
							    document.getElementById('desc').style.border = "1px solid #cccccc"
									document.getElementById('price').style.border = "1px solid #cccccc"
								
								if (desc == "") {
									alert("Внесете опис на останатиот трошок !!!")
									document.getElementById('desc').style.border = "1px solid red"
									document.getElementById('desc').select()
								}
								if (price == "") {
									alert("Внесете износ на останатиот трошок !!!")
									document.getElementById('price').style.border = "1px solid red"
									if (liters == "") document.getElementById('liters').select()
									else document.getElementById('price').select()
								}
								
								
								
								
								$.ajax({
						           url: 'CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt,
						           context: document.body,
						           success: function (data) {
						           		if (Math.abs(km - data) > (data * 20/100)) {
						           			var msg = "<div>Километрите кои ги внесовте во полето Одометар (" + km + " Km) драстично се разликуваат од километрите пресметани преку GPS (" + data + " Km).<br>Дали сте сигурни дека трошокот е направен на <font style='color:#FF6633;font-weight:bold'>" + km + " Km</font>?</div>";
						           			$('#div-msgbox1').html(msg)
											$( "#dialog:ui-dialog" ).dialog( "destroy" );	
											$( "#dialog-message1" ).dialog({ height: 220, width: 440,
												modal: true,
										        resizable: false,
												zIndex: 9999 ,
												buttons: {
													"Да": function() {
														if (price != "" && desc != "") {
																																
																//alert("InsertCost.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&comp=" + htmlstring + "&price=" + price + "&pay=" + pay)
														     	$.ajax({
														          url: "InsertCost.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&loc=" + loc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
														              context: document.body,
														              success: function (data) {
														                    $(this).dialog("close");
														                    mymsg("Успешно додадовте останат трошок !!!")
								                                    		location.reload();
														              }
														        }); 
							  																        
														        $.ajax({
														              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
													},
													"Откажи": function() {
														$( this ).dialog( "close" );
														document.getElementById('km').value = data;
													},
												}
											});
						           		} else {
						           			if (price != "" && desc != "") {
																																
													//alert("InsertCost.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&comp=" + htmlstring + "&price=" + price + "&pay=" + pay)
											     	$.ajax({
											          url: "InsertCost.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&loc=" + loc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
											              context: document.body,
											              success: function (data) {
											                    $(this).dialog("close");
											                    mymsg("Успешно додадовте останат трошок !!!")
					                                    		location.reload();
											              }
											        }); 
				  																        
											        $.ajax({
											              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
											              context: document.body,
											              success: function (data) {
											    
											              }
											        }); 
											        
					                           }
						           		}
						           		
						           	}
						           });
						           
						           
								
								  } else {
								  	if($("#costtype").children(":selected").attr("id") == "0")
								  	{
								  		mymsg("Немате избрано ниту еден трошок за внес !!!");
								  	} else {
								  		var costtypeid = $("#costtype").children(":selected").attr("id");
								  		var dt = document.getElementById("datetime").value;
								  		var km = (document.getElementById("km").value).replace(",", "");
								  		var loc = document.getElementById("location").value;
								  		var driver = "";
	                		        	if (document.getElementById("driver"))
	                		        		driver = document.getElementById("driver").value;
	                		        	var pay = document.getElementById("pay").value;
                		        		var price = (document.getElementById("price").value).replace(",", "");
                		        		var veh = id;
                		        		if (price != "") {
                		        			$.ajax({
									          url: "InsertNewCost.php?costtypeid=" + costtypeid + "&dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&loc=" + loc + "&price=" + price + "&pay=" + pay,
									              context: document.body,
									              success: function (data) {
									                    $(this).dialog("close");
									                    mymsg("Успешно додадовте трошок !!!")
			                                    		location.reload();
									              }
									        }); 
                		        		}	else {
                		        			alert("Внесете износ на трошокот !!!")
											document.getElementById('price').style.border = "1px solid red"
											if (liters == "") document.getElementById('liters').select()
											else document.getElementById('price').select()
                		        		}
								  	}
								  	
								  }              		        	}
            		        }
                         }
                     },
                     {
                         text: dic("cancel", '<?php echo $cLang ?>'),
                         click: function () {
                             //$('#div-cost').dialog("destroy");
                             $( this ).dialog( "close" );
                         }
                     }
                 ]
            });
        }
    });
}
