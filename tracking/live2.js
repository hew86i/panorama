// JavaScript Document
var myScrollMenu;
var lang = 'en'
var haveStartPoi = false;
var haveEndPoi = false;

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
		  url: twopoint + "/main/getGeocode.php?lat="+lat+"&lon="+lon + "&tpoint=" + twopoint,
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
function getCurrentTimeFirst() {
	offset = parseInt(timeZone, 10) + 1;
    // create Date object for current location

    d = new Date(_currTime.split(" ")[0].split("-")[0], parseInt(_currTime.split(" ")[0].split("-")[1], 10) - 1, _currTime.split(" ")[0].split("-")[2], _currTime.split(" ")[1].split(":")[0], _currTime.split(" ")[1].split(":")[1], _currTime.split(" ")[1].split(":")[2]);

    // convert to msec
    // add local time zone offset
    // get UTC time in msec
    utc = d.getTime() + (d.getTimezoneOffset() * 60000);

    // create new Date object for different city
    // using supplied offset
    nd = new Date(utc + (3600000 * offset));

    // return time as a string
    //return nd; //.toLocaleString();
    var currentTime = d;
    var hours = currentTime.getHours()
	var minutes = currentTime.getMinutes()
	var sec = currentTime.getSeconds()
	
	if (parseInt(minutes, 10) < 10)	minutes = "0" + minutes
	if (parseInt(sec, 10) < 10)	sec = "0" + sec

	//var currentDate = new Date()
  	var day = currentTime.getDate()
  	var month = currentTime.getMonth()
  	var year = currentTime.getFullYear()
  	var ampm = '';
    if(datetimeformat.indexOf(' A') != -1)
        var ampm = ' AM';
	var mes = dic("mesec", lang).split(",");
	if(parseInt(hours, 10) == 0)
		hours = 23;
	if(parseInt(hours, 10) < 10)
		hours = '0' + hours;
	var timeformat = hours + ":" + minutes + ':' + sec + ampm ;
	$('#span-time').html(timeformat+'&nbsp;');
	var dateformat = day + "-" + mes[parseInt(month, 10) + 1] + "-" + year;
	if(datetimeformat.split(" ")[0] == 'm-d-Y')
	   dateformat = mes[parseInt(month, 10) + 1] + "-" + day + "-" + year;
	else
	   if(datetimeformat.split(" ")[0] == 'Y-m-d')
            dateformat = year + '-' + mes[parseInt(month, 10) + 1] + "-" + day;
	$('#popup-time').html(dateformat + ' ' + timeformat);
	var mo = (parseInt(month, 10) + 1);
	if(mo < 10)
		mo = '0' + mo;
	if(parseInt(day, 10) < 10)
		day = '0' + day;
	$('#datetimenow').val(year + "-" + mo + "-" + day + " " + timeformat);
	setTimeout("getCurrentTime()", 1000);
}

function getCurrentTime() {
    //var cT = calcTime(timeZone);
    var _dt = $('#datetimenow').val();
    //new Date(t.setSeconds(t.getSeconds() + 10))
    var currentTime = new Date(_dt.split(" ")[0].split("-")[0], parseInt(_dt.split(" ")[0].split("-")[1], 10) - 1, _dt.split(" ")[0].split("-")[2], _dt.split(" ")[1].split(":")[0], _dt.split(" ")[1].split(":")[1], _dt.split(" ")[1].split(":")[2]);
	currentTime = new Date(currentTime.setSeconds(currentTime.getSeconds() + 1));
	var hours = currentTime.getHours()
	var minutes = currentTime.getMinutes()
	var sec = currentTime.getSeconds()
	
	if (parseInt(minutes, 10) < 10)	minutes = "0" + minutes
	if (parseInt(sec, 10) < 10)	sec = "0" + sec

	//var currentDate = new Date()
  	var day = currentTime.getDate()
  	var month = currentTime.getMonth()
  	var year = currentTime.getFullYear()
  	var ampm = '';
    if(datetimeformat.indexOf(' A') != -1)
        var ampm = ' AM';

	var mes = dic("mesec", lang).split(",");
	if(parseInt(hours, 10) == 0)
		hours = 23;
	//else
		//hours = hours-1;
	if(parseInt(hours, 10) < 10)
		hours = '0' + hours;
	var timeformat = hours + ":" + minutes + ':' + sec + ampm ;
	$('#span-time').html(timeformat +'&nbsp;');
	var dateformat = day + "-" + mes[parseInt(month, 10) + 1] + "-" + year;
    if(datetimeformat.split(" ")[0] == 'm-d-Y')
       dateformat = mes[parseInt(month, 10) + 1] + "-" + day + "-" + year;
    else
       if(datetimeformat.split(" ")[0] == 'Y-m-d')
            dateformat = year + '-' + mes[parseInt(month, 10) + 1] + "-" + day;
	$('#popup-time').html(dateformat + ' ' + timeformat);
	var mo = (parseInt(month, 10) + 1);
	if(mo < 10)
		mo = '0' + mo;
	if(parseInt(day, 10) < 10)
		day = '0' + day;
	
	$('#datetimenow').val(year + "-" + mo + "-" + day + " " + timeformat);
	setTimeout("getCurrentTime()", 1000);
}
function getCTime() {
    //var cT = calcTime(timeZone);
    var _dt = $('#datetimenow').val();
    //var currentTime = new Date(cT);
    var currentTime = new Date(_dt.split(" ")[0].split("-")[0], parseInt(_dt.split(" ")[0].split("-")[1], 10) - 1, _dt.split(" ")[0].split("-")[2], _dt.split(" ")[1].split(":")[0], _dt.split(" ")[1].split(":")[1], _dt.split(" ")[1].split(":")[2]);
	
	var hours = currentTime.getHours()
	var minutes = currentTime.getMinutes()
	var sec = currentTime.getSeconds()
	
	if (parseInt(minutes, 10) < 10)	minutes = "0" + minutes
	if (parseInt(sec, 10) < 10)	sec = "0" + sec
	
	//var currentDate = new Date()
  	var day = currentTime.getDate()
  	var month = currentTime.getMonth()
  	var year = currentTime.getFullYear();
  	var ampm = '';
    if(datetimeformat.indexOf(' A') != -1)
        var ampm = ' AM';
	if(parseInt(hours, 10) == 0)
		hours = 23;
	//else
		//hours = hours-1;
	if(parseInt(hours, 10) < 10)
		hours = '0' + hours;
  	var mes = dic("mesec", lang).split(",");
  	
  	var timeformat = hours + ":" + minutes + ':' + sec + ampm ;
  	
    var dateformat = day + "-" + mes[parseInt(month, 10) + 1] + "-" + year;
    if(datetimeformat.split(" ")[0] == 'm-d-Y')
       dateformat = mes[parseInt(month, 10) + 1] + "-" + day + "-" + year;
    else
       if(datetimeformat.split(" ")[0] == 'Y-m-d')
            dateformat = year + '-' + mes[parseInt(month, 10) + 1] + "-" + day;
	return '<div style="width:130px; text-align:center"><span class="text3">' + dic("CurrTimeDate", lang)  + '</span> <br><span id="popup-time">' + dateformat + ' ' + timeformat + '</span></div>'
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
function UpdateArea(_n, pts, _areaid, _avail, _gfgid, _col, _type) {
    
	var alVl = $('#alVlez').attr('checked');
    var alIz = $('#alIzlez').attr('checked');
    
    var sIdx = $('#vozila').attr('selectedIndex');
    
    var oEid = "";
    if(sIdx == 2)
    	oEid = $('#oEdinica').find('option:selected').val();
    var selVeh = "";
    if(sIdx == 1)
    	selVeh = $('#voziloOdbrano').find('option:selected').val();

    var ptsNew;
    if (pts.length > 1500)
        ptsNew = "0";
    else
        ptsNew = pts;
    var em = $('#txt_emails').val();
    var ph = $('#txt_phones').val();

    $.ajax({
        url: twopoint + "/main/AddAreaNew.php?id=" + _areaid + '&p=' + ptsNew + '&n=' + _n + '&avail=' + _avail + '&gfgid=' + _gfgid + '&e=' + em + '&ph=' + ph + '&l=' + lang + '&alvl=' + alVl + '&aliz=' + alIz + '&sidx=' + sIdx + '&oeid=' + oEid + '&selveh=' + selVeh + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
        	data = data.replace(/\r/g,'').replace(/\n/g,'');
            var dat = data.split("&&@^");
            if(_type == "2")
            {
	            for (var cz = 0; cz <= cntz; cz++) {
	                if (document.getElementById("zona_" + cz) != null)
	                    if ($('#zona_' + cz)[0].attributes[1].nodeValue.indexOf(_areaid) != -1) {
	                        $($('#zona_' + cz)[0].nextSibling).html(_n);
	                        //$('#zona_' + cz)[0].nextSibling.innerHTML = _n;
	                        //$('#zona_' + cz)[0].nextSibling.attributes[1].nodeValue = "DrawZoneOnLive1('" + _areaid + "', '" + _col + "', 'zona_" + cz + "')";
	                        break;
	                    }
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
                recurs(i, arr, dat[0], _areaid, dat[1], '0', _type);
            } else {
                for (var z = 0; z < Maps.length; z++) {
                    //if (z != SelectedBoard) {
                    for (var k = 0; k < vectors[z].features.length; k++) {
                        if (vectors[z].features[k].style.name == selectedFeature[SelectedBoard].style.name) {
                            cancelFeature[z] = false;
                            controls[z].modify.deactivate();
                            if(_type == "2")
                            {
	                            if (document.getElementById("div-polygon-menu-" + z) != null)
	                                removeEl(document.getElementById("div-polygon-menu-" + z).id);
	                            ArrAreasPoly[z][k] = "";
                           	} else
							{
                           		ArrPolygons[z][k] = "";
                           	}
                           
							vectors[z].features[k].destroy();
                           	PleaseDrawAreaAgainSB(_areaid, dat[1], z, k, _type);
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

function recurs(p1, arr, _msg, dat0, dat1, _sk, _type) {
    p1--;
    if (p1 < 1) {
        $.ajax({
            url: twopoint + "/main/AddAreaPoints.php?ida=" + dat0 + "&tpoint=" + twopoint,
            context: document.body,
            success: function () {
                if (_sk == "1") {
                    CancelDrawingArea(SelectedBoard, _type);
                    if(_type == "2")
                    	PleaseDrawAreaAgain(dat0, dat1);
                	else
                		PleaseDrawAreaAgainPoly(dat0, dat1);
                } else {
                    for (var z = 0; z < Maps.length; z++) {
                        //if (z != SelectedBoard) {
                        for (var k = 0; k < vectors[z].features.length; k++) {
                            if (vectors[z].features[k].style.name == selectedFeature[SelectedBoard].style.name) {
                                cancelFeature[z] = false;
                                controls[z].modify.deactivate();
                                if(_type == "2")
                                {
                                	if (document.getElementById("div-polygon-menu-" + z) != null)
                                    	removeEl(document.getElementById("div-polygon-menu-" + z).id);
                                	ArrAreasPoly[z][k] = "";	
                                } else
                                ArrPolygons[z][k] = "";
                                
                                vectors[z].features[k].destroy();
                                PleaseDrawAreaAgainSB(dat0, dat1, z, k, _type);
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
        url: twopoint + "/main/AddAreaPointsTemp.php?idx=" + p1 + "&points=" + arr[p1] + "&ida=" + dat0 + "&tpoint=" + twopoint,
        context: document.body,
        success: function () {
            recurs(p1, arr, _msg, dat0, dat1, _sk, _type);
        }
    });
}

function SavingNewArea(pts, _type) {
	
    var alVl = $('#alVlez').attr('checked');
    var alIz = $('#alIzlez').attr('checked');
    
    var sIdx = $('#vozila').attr('selectedIndex');
    
    var oEid = "";
    if(sIdx == 2)
    	oEid = $('#oEdinica').find('option:selected').val();
    var selVeh = "";
    if(sIdx == 1)
    	selVeh = $('#voziloOdbrano').find('option:selected').val();

    var areaName = $('#txt_zonename').val()
    
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
    var _utl = 'n=' + areaName + '&type=' + _type + '&avail=' + avail + '&ppgid=' + $('#gfGroup dt a')[0].title + '&e=' + em + '&ph=' + ph + '&p=' + ptsNew + '&l=' + lang + '&alvl=' + alVl + '&aliz=' + alIz + '&sidx=' + sIdx + '&oeid=' + oEid + '&selveh=' + selVeh;

	$.ajax({
        url: twopoint + "/main/AddAreaTemp.php?" + _utl + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
        	data = data.replace(/\r/g,'').replace(/\n/g,'');
            var dat = data.split("&&@^");
			if(_type == "2")
			{
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
			}
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
                recurs(i, arr, dat[0], dat[1], dat[2], '1', _type);
                //function recurs(p1, arr, _msg, ida, dat0, dat1, _sk) {
            } else {
                CancelDrawingArea(SelectedBoard, _type);
                if(_type == "2")
                	PleaseDrawAreaAgain(dat[1], dat[2]);
            	else
            		PleaseDrawAreaAgainPoly(dat[1], dat[2]);
                HideWait();
                msgbox(dat[0]);
            }
            $('#div-enter-zone-name').dialog('destroy');
            $('#div-al-GeoFence').dialog('destroy');
            if(_type == "2")
            {
            	$('#save1-button-0').css({ display: 'none' });
	            $('#cancel1-button-0').css({ display: 'none' });
	            $('#separator1-button-0').css({ display: 'none' });
            } else
			{
            	$('#save2-button-0').css({ display: 'none' });
	            $('#cancel2-button-0').css({ display: 'none' });
	            $('#separator2-button-0').css({ display: 'none' });
            }
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
	  url: twopoint + "/main/getAreaPoints.php?id="+areaID + "&tpoint=" + twopoint,
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
function AddAreaToArrayPoly(_Feature, areaID) {
    for (var z = 0; z < Maps.length; z++) {
        if (ArrPolygons[z] == undefined) {
            ArrPolygons[z] = new Array();
            ArrPolygonsId[z] = new Array();
            ArrPolygonsCheck[z] = new Array();
        }
        ArrPolygons[z].push(_Feature[z]);
        ArrPolygonsId[z].push(areaID);
        ArrPolygonsCheck[z].push(1);
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
function RemoveAllFeaturePoly() {
    for (var z = 0; z < Maps.length; z++) {
        if (ArrPolygonsId[z] != undefined) {
            for (var i = 0; i < ArrPolygonsId[z].length; i++) {
                try {
                    vectors[z].removeFeatures([ArrPolygons[z][i]]);
                    ArrPolygonsCheck[z][i] = 0;
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
        url: twopoint + "/main/getAreaPoints.php?id=" + areaID + "&tpoint=" + twopoint,
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
            var ret = DrawPolygon(_lon, _lat, false, _color, _name, areaID, _avail, _cant, _gfgid, _alarmsH, _alarmsVeh, "2");
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
        url: twopoint + "/main/getAreaPoints.php?id=" + areaID + "&tpoint=" + twopoint,
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
            var ret = DrawPolygon(_lon, _lat, false, _color, _name, areaID, _avail, _cant, _gfgid, _alarmsH, _alarmsVeh, "2");
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

function DrawZoneOnLivePoly(areaID, _color){
    var tf = 0;
    if (ArrPolygonsId != "") {
        for (var z = 0; z < Maps.length; z++) {
            if (ArrPolygonsId[z] != undefined) {
                for (var i = 0; i < ArrPolygonsId[z].length; i++) {
                    if (ArrPolygonsId[z][i] == areaID) {
                        vectors[z].addFeatures([ArrPolygons[z][i]]);
                        controls[z].select.activate();
                        ArrPolygonsCheck[z][i] = 1;
                        tf = 1;
                        //Maps[z].zoomToExtent(ArrAreasPoly[z][i].layer.getDataExtent());
                    }
                }
            }
        }
        HideWait();
    }
    if (tf == 0) { PleaseDrawAreaAgainPoly(areaID, _color) }
}
//polygonFeature
function PleaseDrawAreaAgainPoly(areaID, _color) {
    GlobalTempArea = areaID;
    $.ajax({
        url: twopoint + "/main/getAreaPoints.php?id=" + areaID + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
        	data = data.replace(/\r/g,'').replace(/\n/g,'');
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
            var ret = DrawPolygon(_lon, _lat, false, _color, _name, areaID, _avail, _cant, _gfgid, _alarmsH, _alarmsVeh, "3");
            AddAreaToArrayPoly(ret, areaID);
            //debugger;
            //var bounds = new OpenLayers.Bounds();
            //bounds.extend(ret[0].layer.getDataExtent());
            //map.zoomToExtent(ret[0].layer.getDataExtent());
            //HideWait();
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
        url: twopoint + "/main/getAreaPoints.php?id=" + areaID + "&tpoint=" + twopoint,
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
            var ret = DrawPolygon(_lon, _lat, false, _color, _name, areaID, _avail, _cant, _gfgid, _alarmsH, _alarmsVeh, "2");
            AddAreaToArray(ret, areaID);
            //debugger;
            //var bounds = new OpenLayers.Bounds();
            //bounds.extend(ret[0].layer.getDataExtent());
            //map.zoomToExtent(ret[0].layer.getDataExtent());
            //HideWait();
        }
    });
}
function PleaseDrawAreaAgain2(areaID, _color) {
    GlobalTempArea = areaID;
    $.ajax({
        url: twopoint + "/main/getAreaPoints.php?id=" + areaID + "&tpoint=" + twopoint,
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
            var ret = DrawPolygon(_lon, _lat, false, _color, _name, areaID, _avail, _cant, _gfgid, _alarmsH, _alarmsVeh, "2");
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
function PleaseDrawAreaAgainSB(areaID, _color, _sb, _k, _type) {
    GlobalTempArea = areaID;
    $.ajax({
        url: twopoint + "/main/getAreaPoints.php?id=" + areaID + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
        	data = data.replace(/\r/g,'').replace(/\n/g,'');
        	//data = data.replace("\r\n", "");
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
            var ret = DrawPolygonSB(_lon, _lat, false, _color, _name, areaID, _avail, _cant, _gfgid, _alarmsH, _alarmsVeh, _sb, _type);
            if(_type == "2")
            {
            	ArrAreasPoly[_sb][_k] = ret[_sb];
            	ArrAreasId[_sb][_k] = areaID;
            } else
			{
            	ArrPolygons[_sb][_k] = ret[_sb];
            	ArrPolygonsId[_sb][_k] = areaID;
            }
            
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
    for (var z1 = 0; z1 < 4; z1++)
        if (Boards[z1] != null)
        {
			PathPerVeh[z1] = [];
    		PathPerVehShadow[z1] = [];
		}
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
        ClearArrayTrajectory();
        if($('#trajectory24h').css('display') != 'none')
    	{
        	goToPointIdxNew(_pts.length - 1);
        	$('#div-layer-playsF-0').css({display: 'none'})
    		$('#trajectory24h').css({display: 'none'})
    		$('#trajectory24h').html('');
    	}
        return
    } else {
        ShowWait();
        ShowHideTrajectory = true;
        var s = 1;
        for(var z= 0; z < Vehicles.length; z++)
        {
        	if(document.getElementById('cb-vehicle-' + Vehicles[z].Map + '-' + Vehicles[z].ID).checked)
        	{
	        	if (PathPerVeh[0][Vehicles[z].ID] == undefined || PathPerVeh[0][Vehicles[z].ID] == "") {
	        		for (var z1 = 0; z1 < 4; z1++)
			            if (Boards[z1] != null)
			            {
							PathPerVeh[z1][Vehicles[z].ID] = [];
	        				PathPerVehShadow[z1][Vehicles[z].ID] = [];
						}
	        		get10Points1(Vehicles[z].ID, Vehicles[z].Reg, -1);
	        	}
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
                //CancelDrawingArea(i, "2");
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
        {
            if (document.getElementById("zona_" + cz) != null)
            {
                $('#zona_' + cz)[0].checked = true;
           }
       }
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
function pad(n) {
    return (n < 10) ? ("0" + n) : n;
}
function number_format(_num){
	
    var filtered_number = _num;//.replace(/[^0-9]/gi, '');
    var breakpoint = 1;
    var formated_number = '';
    for(i = 1; i <= filtered_number.toString().length; i++){
        if(breakpoint > 3){
            breakpoint = 1;
            formated_number = ',' + formated_number;
        }
        var next_letter = i + 1;
        formated_number = filtered_number.toString().substring((filtered_number.toString().length) - i, (filtered_number.toString().length) - (i - 1)) + formated_number; 

        breakpoint++;
    }

    return formated_number;
}
/*function ParseVehicleWS(_podatoci) {
	var c = _podatoci.split("#");
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
				_car.speed = Math.round(Math.round((parseFloat(p[7])*0.621371)*100)/100)+' mph';
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
		_car.service = p[24];
		_car.status = p[25];
		_car.zonedt = p[26];
		_car.ignition = p[28];
		_car.kapaci = p[29];
		_car.pumpa = p[30];
		_car.rpm = p[31];
		_car.driver = p[32];
		_car.sopatnik = p[33];
		_car.engineblock = p[35];
		_car.battery = p[36];
		_car.inputvoltage = p[38];
		_car.ultrasonic = p[39];
		_car.digalka = p[40];
		if(p[37] == "0")
		{
		    _car.geolock = "0";
            _car.radius = "0";
		} else {
		    _car.geolock = p[37].split("-")[0];
		    _car.radius = p[37].split("-")[1];
		}
		
		if(_car.ignition == '1' && _car.olddate == '1')
			_car.noconnection = true;
		else
			_car.noconnection = false;
		
		for (var j =0; j<Car.length; j++) {
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
				_car.datediff = Car[j].datediff;	
				Car[j]=_car; 
			}
		}
		
		//fixed
		if (p[42] != "/") {
			$('#iFrmS')[0].contentWindow.$('#intour-'+p[27]).addClass("blink_me");
			$('#iFrmS')[0].contentWindow.$('#intour-'+p[27]).css({display: "block"});
						
			$('#iFrmS')[0].contentWindow.$('#spanTotalPrice-'+p[27]).html(number_format(parseInt($('#iFrmS')[0].contentWindow.$('#spanTotalPrice-'+p[27])[0].attributes[0].nodeValue.replace(",", ""))+parseInt(p[42])));
			$('#iFrmS')[0].contentWindow.$('#spanPriceTaxi-'+p[27]).html(number_format(parseInt($('#iFrmS')[0].contentWindow.$('#spanPriceTaxi-'+p[27])[0].attributes[0].nodeValue.replace(",", ""))+parseInt(p[43])));
			$('#iFrmS')[0].contentWindow.$('#spanPriceWithoutTaxi-'+p[27]).html(number_format(parseInt($('#iFrmS')[0].contentWindow.$('#spanPriceWithoutTaxi-'+p[27])[0].attributes[0].nodeValue.replace(",", ""))+(parseInt(p[42])-parseInt(p[43]))));
		} else {
			$('#iFrmS')[0].contentWindow.$('#intour-'+p[27]).removeClass("blink_me");
			$('#iFrmS')[0].contentWindow.$('#intour-'+p[27]).css({display: "none"});
		}
				
		if (p[44] == 1) {
			$('#iFrmS')[0].contentWindow.$('#spanCntTours-'+p[27]).html(parseInt($('#iFrmS')[0].contentWindow.$('#spanCntTours-'+p[27]).html()) + 1);
		}
			
		
		if ($('#iFrmS')[0].contentWindow) {
			$('#iFrmS')[0].contentWindow.$('#spanSpeed-'+p[27]).html(_car.speed);
			if ($('#iFrmS')[0].contentWindow.$('#spanMaxSpeed-'+p[27]).html() != null) {
				if (parseInt((_car.speed).split(" ")[0]) > parseInt(($('#iFrmS')[0].contentWindow.$('#spanMaxSpeed-'+p[27]).html()).split(" ")[0]) || ($('#iFrmS')[0].contentWindow.$('#spanMaxSpeed-'+p[27]).html()) == "/")
					if (p[7] > 0)
						$('#iFrmS')[0].contentWindow.$('#spanMaxSpeed-'+p[27]).html(_car.speed);
				
			}
			$('#iFrmS')[0].contentWindow.$('#spanDriver-'+p[27]).html(_car.driver);
			
			if (p[12] == "") $('#iFrmS')[0].contentWindow.$('#spanLoc-'+p[27]).html("/");	
			else $('#iFrmS')[0].contentWindow.$('#spanLoc-'+p[27]).html(p[12]);		
				
			if (_car.address == "") $('#iFrmS')[0].contentWindow.$('#spanZone-'+p[27]).html("/");	
			else $('#iFrmS')[0].contentWindow.$('#spanZone-'+p[27]).html(_car.address);		
			
			if (_car.location == "") $('#iFrmS')[0].contentWindow.$('#spanPoi-'+p[27]).html("/");
			else $('#iFrmS')[0].contentWindow.$('#spanPoi-'+p[27]).html(_car.location);
				
			if (p[5].split(" ")[1] != "") {
				if ($('#iFrmS')[0].contentWindow.$('#spanIgn1-'+p[27]).html() == "/" && _car.ignition == "1") {
					$('#iFrmS')[0].contentWindow.$('#spanIgn1-'+p[27]).html(p[5].split(" ")[1]);
				}	
				$('#iFrmS')[0].contentWindow.$('#spanIgn2-'+p[27]).html(p[5].split(" ")[1]);
								
				if ($('#iFrmS')[0].contentWindow.$('#spanIgn1-'+p[27]).html() != "/" && $('#iFrmS')[0].contentWindow.$('#spanIgn2-'+p[27]).html() != "/") {
					var now = new Date().getFullYear() + "-" + pad((new Date().getMonth()+1)) + "-" + pad(new Date().getDate());
					var tempDt = Sec2StrDir(dateDiff123(now + " " + $('#iFrmS')[0].contentWindow.$('#spanIgn1-'+p[27]).html(), now + " " + $('#iFrmS')[0].contentWindow.$('#spanIgn2-'+p[27]).html()));
					$('#iFrmS')[0].contentWindow.$('#spanIgnTotal-'+p[27]).html(tempDt);
				}
			}
		
			$('#iFrmS')[0].contentWindow.$('#spanPass-'+p[27]).html(_car.sedista);
			if (_car.sedista == 0) $('#iFrmS')[0].contentWindow.$('#spanPass-'+p[27]).css({color: "red"});
			else $('#iFrmS')[0].contentWindow.$('#spanPass-'+p[27]).css({color: "green"});
						
			if (_car.taxi == 0) {
				$('#iFrmS')[0].contentWindow.$('#spanTaxi-'+p[27]).html(dic("Reports.OFF1", lang));
				$('#iFrmS')[0].contentWindow.$('#spanTaxi-'+p[27]).css({color: "red"});
			} else {
				$('#iFrmS')[0].contentWindow.$('#spanTaxi-'+p[27]).html(dic("Reports.ON1", lang));
				$('#iFrmS')[0].contentWindow.$('#spanTaxi-'+p[27]).css({color: "green"});
			}
			
			var odometerCurrData = "/";
			if(metric == "mi")
				odometerCurrData = number_format(Math.round(parseFloat(_car.odometar)*0.621371)) + " mi";
			else
				odometerCurrData = number_format(Math.round(_car.odometar)) + " Km";
			if (_car.odometar != "") {
				$('#iFrmS')[0].contentWindow.$('#spanOd2-'+p[27]).html(odometerCurrData);
				if ($('#iFrmS')[0].contentWindow.$('#spanOd1-'+p[27]).html() == "/") {
					$('#iFrmS')[0].contentWindow.$('#spanOd1-'+p[27]).html(odometerCurrData);
				}
				if ($('#iFrmS')[0].contentWindow.$('#spanOd1-'+p[27]).html() != "/") {
					var odometerTotal = 1;//parseInt(($('#iFrmS')[0].contentWindow.$('#spanOd2-'+p[27]).html()).toString().replace(',', '').split( )[0]) - parseInt(($('#iFrmS')[0].contentWindow.$('#spanOd1-'+p[27]).html()).toString().replace(',', '').split( )[0]);
					if(metric == "mi")
						odometerTotal = number_format(Math.round(parseFloat(odometerTotal)*0.621371)) + " mi";
					else
						odometerTotal = number_format(Math.round(odometerTotal)) + " Km";
					$('#iFrmS')[0].contentWindow.$('#spanOdTot-'+p[27]).html(odometerTotal)
				}
			}
		}
	}
}*/
function ParseVehicleWS1(_podatoci){
	//alert(_podatoci);
	var c = _podatoci.split("#");
	for (var i=1; i<c.length; i++){
		var p = c[i].split("|");
		var _car = new CarType(p[0], p[3], p[1], p[2], p[13]);
		//_car.passive = p[4];
		_car.datum = p[5];
		//_car.location = p[6];
		if(p[7] == "/")
		{
			_car.speed=p[7];
		} else
		{
			_car.speed=parseInt(p[7], 10) + ' Km/h';
			if(metric == "mi")
				_car.speed = Math.round(Math.round((parseFloat(p[7])*0.621371)*100)/100)+' mph';
		}

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
		
		//fixed
		if (p[42] != "/") {
			$('#intour-'+p[27]).addClass("blink_me");
			$('#intour-'+p[27]).css({display: "block"});
						
			$('#spanTotalPrice-'+p[27]).html(number_format(parseInt($('#spanTotalPrice-'+p[27])[0].attributes[0].nodeValue.replace(",", ""))+parseInt(p[42])));
			$('#spanPriceTaxi-'+p[27]).html(number_format(parseInt($('#spanPriceTaxi-'+p[27])[0].attributes[0].nodeValue.replace(",", ""))+parseInt(p[43])));
			$('#spanPriceWithoutTaxi-'+p[27]).html(number_format(parseInt($('#spanPriceWithoutTaxi-'+p[27])[0].attributes[0].nodeValue.replace(",", ""))+(parseInt(p[42])-parseInt(p[43]))));
		} else {
			$('#intour-'+p[27]).removeClass("blink_me");
			$('#intour-'+p[27]).css({display: "none"});
		}
				
		if (p[44] == 1) {
			$('#spanCntTours-'+p[27]).html(parseInt($('#spanCntTours-'+p[27]).html()) + 1);
		}

		//if ($('#iFrmS')[0].contentWindow) {
			$('#spanSpeed-'+p[27]).html(_car.speed);
			if ($('#spanMaxSpeed-'+p[27]).html() != null) {
				if (parseInt((_car.speed).split(" ")[0]) > parseInt(($('#spanMaxSpeed-'+p[27]).html()).split(" ")[0]) || ($('#spanMaxSpeed-'+p[27]).html()) == "/")
					if (p[7] > 0)
						$('#spanMaxSpeed-'+p[27]).html(_car.speed);
				
			}
			$('#spanDriver-'+p[27]).html(p[32]);
			
			if (p[12] == "") $('#spanLoc-'+p[27]).html("/");	
			else $('#spanLoc-'+p[27]).html(p[12]);		
				
			if (p[11] == "") $('#spanZone-'+p[27]).html("/");	
			else $('#spanZone-'+p[27]).html(p[11]);		
			
			if (p[6] == "") $('#spanPoi-'+p[27]).html("/");
			else $('#spanPoi-'+p[27]).html(p[6]);
				
			if (p[5].split(" ")[1] != "") {
				if ($('#spanIgn1-'+p[27]).html() == "/" && p[28] == "1") {
					$('#spanIgn1-'+p[27]).html(p[5].split(" ")[1]);
				}	
				$('#spanIgn2-'+p[27]).html(p[5].split(" ")[1]);
								
				if ($('#spanIgn1-'+p[27]).html() != "/" && $('#spanIgn2-'+p[27]).html() != "/") {
					var now = new Date().getFullYear() + "-" + pad((new Date().getMonth()+1)) + "-" + pad(new Date().getDate());
					var tempDt = Sec2StrDir(dateDiff123(now + " " + $('#spanIgn1-'+p[27]).html(), now + " " + $('#spanIgn2-'+p[27]).html()));
					$('#spanIgnTotal-'+p[27]).html(tempDt);
				}
			}
		
			if (p[9] == "/") {
				$('#spanPass-'+p[27]).html('<img id="img-senzor-11" style="width: 11px; position: relative; margin-top: 0px; margin-left: 2px; height: 11px; margin-bottom: -2px;" onmouseout="HidePopup()" onmousemove="ShowPopup(event, \'Потребна проверка на сензори на седишта\')" src="../images/nosignal.png">');
			} else {
				$('#spanPass-'+p[27]).html(p[9]);
				if (p[9] == 0) $('#spanPass-'+p[27]).css({color: "red"});
				else $('#spanPass-'+p[27]).css({color: "green"});
			}	
			
						
			if (p[8] == 0) {
				$('#spanTaxi-'+p[27]).html(dic("Reports.OFF1", lang));
				$('#spanTaxi-'+p[27]).css({color: "red"});
			} else {
				$('#spanTaxi-'+p[27]).html(dic("Reports.ON1", lang));
				$('#spanTaxi-'+p[27]).css({color: "green"});
			}
			
			var odometerCurrData = "/";
			if(metric == "mi")
				odometerCurrData = number_format(Math.round(parseFloat(p[23])*0.621371)) + " mi";
			else
				odometerCurrData = number_format(Math.round(p[23])) + " Km";
			if (p[23] != "") {
				$('#spanOd2-'+p[27]).html(odometerCurrData);
				if ($('#spanOd1-'+p[27]).html() == "/") {
					$('#spanOd1-'+p[27]).html(odometerCurrData);
				}
				if ($('#spanOd1-'+p[27]).html() != "/") {
					var odometerTotal = parseInt(($('#iFrmS')[0].contentWindow.$('#spanOd2-'+p[27]).html()).toString().replace(',', '').split( )[0]) - parseInt(($('#iFrmS')[0].contentWindow.$('#spanOd1-'+p[27]).html()).toString().replace(',', '').split( )[0]);
					if(metric == "mi")
						odometerTotal = number_format(Math.round(parseFloat(odometerTotal)*0.621371)) + " mi";
					else
						odometerTotal = number_format(Math.round(odometerTotal)) + " Km";
					$('#spanOdTot-'+p[27]).html(odometerTotal)
				}
			}
		//}
	}
}
function getPosNew(_podatoci){
	if(iszooming){return false;}
	ParseVehicleWS(_podatoci)
    var tmr = 0;
	var kola = [];
	var patnici;

	for (var j = 1; j <= _podatoci.split("#").length-1; j++) {
		for (var po =0; po<Car.length; po++) {
			if (Car[po].id == _podatoci.split("#")[j].split("|")[0]) {
				kola = Car[po];
				break;
			}
		}

        if($('#naredba1_' +_podatoci.split("#")[j].split("|")[27]).length > 0)
        {
            if($('#naredba2_' + _podatoci.split("#")[j].split("|")[27]).children().html() == "Moto-block" && kola.engineblock == "1")
            {
                $('#naredba2_' + _podatoci.split("#")[j].split("|")[27] + ' span').text("Moto-deblock");
                $('#naredba2_' + _podatoci.split("#")[j].split("|")[27]).css({ backgroundColor: '#387cb0', color: '#ffffff' });
            }
            if($('#naredba2_' + _podatoci.split("#")[j].split("|")[27]).children().html() == "Moto-deblock" && kola.engineblock == "0")
            {
                $('#naredba2_' + _podatoci.split("#")[j].split("|")[27] + ' span').text("Moto-block");
                $('#naredba2_' + _podatoci.split("#")[j].split("|")[27]).css({ backgroundColor: '#f6f6f6', color: '#2f5185' });
            } 
        }
        if(kola.geolock == "1")
        {
            $('#naredba3_' + _podatoci.split("#")[j].split("|")[27]).css({ backgroundColor: '#387cb0', color: '#ffffff' });
            if(CircleVeh[_podatoci.split("#")[j].split("|")[27]] == undefined)
            {
                drawCircle(_podatoci.split("#")[j].split("|")[27], _podatoci.split("#")[j].split("|")[37].split("-")[2], _podatoci.split("#")[j].split("|")[37].split("-")[3], kola.radius);
            }
        } else {
            $('#naredba3_' + _podatoci.split("#")[j].split("|")[27]).css({ backgroundColor: '#f6f6f6', color: '#2f5185' });;
        }
		var svc = document.getElementById('div-sv-' + kola.id);
		if(kola.sedista == '/')
			patnici = 0;
		else
			patnici = parseInt(kola.sedista, 10);
		if (kola.ignition == '0' && patnici == 0)
		{
			kola.color = engineoff;
		}
		if (kola.ignition == '0' && patnici > 0)
		{
			kola.color = engineoffpassengeron;
		}
		if (kola.ignition == '1' && patnici > 0 && kola.taxi == '0')
		{
			kola.color = taximeteroffpassengeron;
		}
		if (kola.ignition == '1' && kola.taxi == '1')
		{
			kola.color = taximeteron;
		}
		if (kola.ignition == '1' && patnici == 0 && kola.taxi == '0')
		{
			kola.color = engineon;
		}
		if (kola.passive == '1')
		{
			kola.color = passiveon;
		}
		if(kola.ignition == '1' && kola.olddate == '1')
		{
			var lostcomm = true;
			kola.color = nocommunication;
		} else
			var lostcomm = false;
    	if(!kola.same) // || $('#vh-small-'+kola.id).attr('class').indexOf('Gray') != -1)
		{
    		if(AlarmsTypeArray.indexOf("," + kola.alarm + ",") != -1)
    			AlertEvent(kola.fulldt, kola.reg, kola.alarm, VehcileIDs[j]);

    		//if (svc != null)
    		//{
    			//if(!(svc.className.replace("gnMarkerList", "").replace(" text3", "") == kola.color && kola.color == "Red"))
    			//{
			MoveMarker(kola.id, parseFloat(kola.lon), parseFloat(kola.lat), kola.color, kola.map0, kola.map1, kola.map2, kola.map3, kola.datum, kola.status, parseInt(kola.speed, 10), lostcomm);
				//}
			//}
       	} 
        if (svc != null) {
        	/*if(kola.status == '0')
        	{
        		$('#img-pass-' + kola.id).remove();
        		$('#img-sv-' + kola.id).remove();
        		$('#img-small-' + kola.id).remove();
        		$('#div-pass-' + kola.id).append('<img id="img-pass-' + kola.id + '" style="height: 13px; position: relative; width: 13px; margin-left: 11px; margin-top: -4px;" src="../images/nosignal.png">');
        		$('#div-sv-' + kola.id).append('<img id="img-sv-' + kola.id + '" style="height: 13px; position: relative; width: 13px; margin-left: 11px; margin-top: -4px;" src="../images/nosignal.png">');
        		$('#vh-small-' + kola.id).append('<img id="img-small-' + kola.id + '" style="height: 13px; width: 13px; top: -3px; position: relative; left: 6px;" src="../images/nosignal.png">');
        	} else
        	{*/
        		$('#img-pass-' + kola.id).remove();
        		$('#img-sv-' + kola.id).remove();
        		$('#img-small-' + kola.id).remove();
        		if(lostcomm)
        		{
        			$('#div-pass-' + kola.id).append('<img id="img-pass-' + kola.id + '" style="height: 13px; position: relative; width: 13px; margin-left: 11px; margin-top: -4px;" src="../images/nocommunication.png">');
        			$('#div-sv-' + kola.id).append('<img id="img-sv-' + kola.id + '" style="height: 13px; position: relative; width: 13px; margin-left: 11px; margin-top: -4px;" src="../images/nocommunication.png">');
        			$('#vh-small-' + kola.id).append('<img id="img-small-' + kola.id + '" style="height: 13px; width: 13px; top: -3px; position: relative; left: 6px;" src="../images/nocommunication.png">');
        		}
        	//}
            svc.className = 'gnMarkerList' + kola.color + ' text3'
            if (kola.passive == '0') { $('#div-pass-' + kola.id).css({ opacity: '0.3' }) } else { $('#div-pass-' + kola.id).css({ opacity: '1' }) }
            $('#vh-date-' + kola.id).html(kola.datum)
            if (kola.olddate == '1') { $('#vh-date-' + kola.id).css("color", "#FF0000") } else { $('#vh-date-' + kola.id).css("color", "009933") }

            document.getElementById('vh-small-' + kola.id).className = 'gnMarkerList' + kola.color + ' text3'
            if (kola.same == false) { getAddress(kola.lon, kola.lat, 'vh-location-' + kola.id) }

            if (parseInt(kola.cbfuel, 10) != 0) {
				$('#vh-cbfuel1-' + kola.id).css({ display: "block" });
				$('#vh-cbfuel-' + kola.id).html(Math.round(100*parseInt(kola.cbfuel, 10)/100) + ' L');
			} else {
                if(parseInt($('#vh-cbfuel-' + kola.id).html(), 10) == 0)
                    $('#vh-cbfuel1-' + kola.id).css({ display: "none" });
			}

            if (parseInt(kola.cbrpm, 10) != 0) {
				$('#vh-cbrpm1-' + kola.id).css({ display: "block" });
				$('#vh-cbrpm-' + kola.id).html(Math.round(kola.cbrpm) + ' rpm');
			} else {
                if(parseInt($('#vh-cbrpm-' + kola.id).html(), 10) == 0 || kola.ignition == '0')
                    $('#vh-cbrpm1-' + kola.id).css({ display: "none" });
                else {
                    if($('#vh-cbrpm-' + kola.id)[0] != undefined)
                        if($('#vh-cbrpm-' + kola.id).html().indexOf('(') == -1)
                            $('#vh-cbrpm-' + kola.id).html('(' + $('#vh-cbrpm-' + kola.id).html() + ')');
                } 
            }
            if (parseInt(kola.cbtemp, 10) != 0) {
				$('#vh-cbtemp1-' + kola.id).css({ display: "block" });
				$('#vh-cbtemp-' + kola.id).html(Math.round(kola.cbtemp) + ' °C');
			} else {
                if(parseInt($('#vh-cbtemp-' + kola.id).html(), 10) == 0 || kola.ignition == '0')
                    $('#vh-cbtemp1-' + kola.id).css({ display: "none" });
            }
				
			if (parseInt(kola.cbdistance, 10) != 0) {
				$('#vh-cbdistance1-' + kola.id).css({ display: "block" });
				var mmetric = ' Km';
				var kilom = Math.round(parseInt(kola.cbdistance, 10)/1000);
				if(metric == 'mi')
				{
					mmetric = ' miles';
					kilom = Math.round(Math.round(parseInt(kola.cbdistance, 10)/1000) * 0.621371);
				}
				if(kola.service != "")
				{
					if(parseInt(kola.service, 10) < 300)
						var _service = ' (<font style="color: Red;">'+commaSeparateNumber(kola.service)+' '+mmetric+'</font>)';
					else
						var _service = " ("+commaSeparateNumber(kola.service)+" "+mmetric+")";
				} else
				{
					var _service = "";
				}
				$('#vh-cbdistance-' + kola.id).html(commaSeparateNumber(kilom) + mmetric + _service);
				if(_service != "")
				{
					$('#vh-cbdistance-' + kola.id).mousemove(function (event) {
						if(parseInt($('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")).replace(".", ""), 10) < 300)
							var nexserv = '<font style="color: Red;">' + $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")) + '</font>';
						else
							var nexserv = $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")"));
	                    ShowPopup(event, 'Изминати километри: <b>' + $('#'+this.id).html().substring(0, $('#'+this.id).html().indexOf("(")-1) + '</b><br/>Преостануваат <b>' + nexserv + '</b> до следен сервис!');
	                });
				} else
				{
					$('#vh-cbdistance-' + kola.id).mousemove(function (event) {
	                    ShowPopup(event, 'Изминати километри: <b>' + $('#'+this.id).html() + '</b>');
	                });
				}
                $('#vh-cbdistance-' + kola.id).mouseout(function () { HidePopup() });
			} else {
                if(parseInt($('#vh-cbdistance-' + kola.id).html(), 10) == 0)
                    $('#vh-cbdistance1-' + kola.id).css({ display: "none" });
            }
			if ($('#vh-cbfuel1-' + kola.id).css('display') == 'none' && $('#vh-cbrpm1-' + kola.id).css('display') == 'none' && $('#vh-cbtemp1-' + kola.id).css('display') == 'none' && $('#vh-cbdistance1-' + kola.id).css('display') == 'none') {
                $('#vh-canbus-' + kola.id).css({ display: "none" });
            } else {
                $('#vh-canbus-' + kola.id).css({ display: "block" });
            }
			
			if(clientid == '367')
			{
				if(kola.zoneids != "")
                {
                	for(var z = 0; z < kola.zoneids.split(";").length; z++)
                	{
                		if(document.getElementById("div_zone_"+kola.zoneids.split(";")[z]+"_"+kola.id) != null)
                		{
                			$("div_zone_"+kola.zoneids.split(";")[z]+"_"+kola.id).remove()
                		} else
                		{
                			var str = '';
	                		var cname = document.getElementById('vh-small-' + kola.id).className;
	                		str += '<div id="div_zone_'+kola.zoneids.split(";")[z]+'_'+kola.id+'" style="float:left; width:16px; height:16px; margin-left:2px; margin-bottom:2px; cursor:pointer" onclick="FindVehicleOnMap0(' + kola.id + ')" class="' + cname + '">' + kola.id + '</div>';
	                		$('#geo-fence-' + kola.zoneids.split(";")[z]).html($('#geo-fence-' + kola.zoneids.split(";")[z]).html() + str);
                		}
            		}
                } else
            	{
            		for(var z = 0; z < kola.zoneids.split(";").length; z++)
                	{
                		if(document.getElementById("div_zone_"+kola.zoneids.split(";")[z]+"_"+kola.id) != null)
                		{
                			$("div_zone_"+kola.zoneids.split(";")[z]+"_"+kola.id).remove()
                		}
                	}
                }
			} else
			{
				for (var q=0; q<$('#add_del_geofence').children().length; q++)
                {
                	var geoid = $($('#add_del_geofence').children()[q]).children()[2].id.split("-")[2];
                	
                	if(kola.zoneids == "")
                	{
                		$("#div_zone_"+geoid+"_"+kola.id).remove();
                	} else
                	{
                		var imavozona = false;
                		for(var z = 0; z < kola.zoneids.split(";").length; z++)
                		{
                			if(kola.zoneids.split(";")[z] == geoid)
                			{
                				imavozona = true;
                				break;
                			}
                		}
            			if(imavozona)
            			{
            				if(document.getElementById("div_zone_"+geoid+"_"+kola.id) == null)
            				{
            					var str = '';
                				var cname = document.getElementById('vh-small-' + kola.id).className;
                				if(kola.zonedt == '/')
                					var zoneindt = kola.fulldt;
                				else
                					var zoneindt = kola.zonedt;
                				str += '<div onmousemove="ShowPopup(event, \'Влез во зона: ' + formatdt1(zoneindt) + '\');" onmouseout="HidePopup()" id="div_zone_'+geoid+'_'+kola.id+'" style="float:left; width:16px; height:16px; margin-left:2px; margin-bottom:2px; cursor:pointer" onclick="FindVehicleOnMap0(' + kola.id + ')" class="' + cname + '">' + kola.id + '<input type="hidden" value="'+zoneindt+'"/></div>';
                				if(FirstLoad)
                				{
                					if(kola.zonedt > $($('#geo-fence-' + geoid).children()[$('#geo-fence-' + geoid).children().length-1]).children().val())
	                				{
	                					$('#geo-fence-' + geoid).html($('#geo-fence-' + geoid).html() + str);
	                				} else
	                				{
	                					for(var t = $('#geo-fence-' + geoid).children().length-1; t >= 0; t--)
		                				{
		                					if(kola.zonedt > $($('#geo-fence-' + geoid).children()[t]).children().val())
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
            					var cname = document.getElementById('vh-small-' + kola.id).className;
            					$("#div_zone_"+geoid+"_"+kola.id).removeAttr('class');
								$("#div_zone_"+geoid+"_"+kola.id).attr('class', '');
								$("#div_zone_"+geoid+"_"+kola.id)[0].className = cname;
            				}
            			} else
            			{
            				$("#div_zone_"+geoid+"_"+kola.id).remove();
            			}
                	}
                }
			}
			if(FirstLoad == false){
			    if(kola.driver != undefined)
				    $('#vh-driver-' + kola.id).html(kola.driver)
            }
            if (kola.location == "")
                $('#vh-pp-pic-' + kola.id).css({ display: "none" });
            else
                $('#vh-pp-pic-' + kola.id).css({ display: "block" });
            
            $('#vh-pp-' + kola.id).html(kola.location.replace(/;/g,";</br>"));
            $('#vh-pp-pic-' + kola.id).mousemove(function (event) {
                ShowPopup(event, '<img src=\''+twopoint + '/images/poiButton.png\' style=\'position: relative; float: left; top: 2px; \' /><div style=\'position: relative; float: left; margin-left: 7px; padding-right: 3px;\'>' + dic('Poi', lang) + ':<br /><strong style="font-size: 14px;">' + $('#vh-pp-' + this.id.substring(this.id.lastIndexOf("-") + 1, this.id.length)).html() + '</strong></div>');
            });
            $('#vh-pp-pic-' + kola.id).mouseout(function () { HidePopup() });

            if (kola.address == "")
                $('#vh-address-pic-' + kola.id).css({ display: "none" });
            else
                $('#vh-address-pic-' + kola.id).css({ display: "block" });
            kola.address = kola.address.replace(";", "<br>");
            $('#vh-address-' + kola.id).html(kola.address);
            $('#vh-address-pic-' + kola.id).mousemove(function (event) {
                ShowPopup(event, '<img src=\''+twopoint + '/images/areaImg.png\' style=\'position: relative; float: left; top: 2px; \' /><div style=\'position: relative; float: left; margin-left: 7px; padding-right: 3px;\'>' + dic('GFVeh', lang) + '<br /><strong style="font-size: 14px;">' + $('#vh-address-' + this.id.substring(this.id.lastIndexOf("-") + 1, this.id.length)).html() + '</strong></div>');
            });
            $('#vh-address-pic-' + kola.id).mouseout(function () { HidePopup() });
            if (kola.gis == "")
                $('#vh-location-pic-' + kola.id).css({ display: "none" });
            else
            	$('#vh-location-pic-' + kola.id).css({ display: "block" });
            $('#vh-location-' + kola.id).html(kola.gis);
            $('#vh-location-pic-' + kola.id).mousemove(function (event) {
                ShowPopup(event, '<img src=\''+twopoint + '/images/shome.png\' style=\'position: relative; float: left; top: 2px; \' /><div style=\'position: relative; float: left; margin-left: 7px; padding-right: 3px;\'>' + dic('Street', lang) + '<br /><strong style="font-size: 14px;">' + $('#vh-location-' + this.id.substring(this.id.lastIndexOf("-") + 1, this.id.length)).html() + '</strong></div>');
            });
            $('#vh-location-pic-' + kola.id).mouseout(function () { HidePopup() });
			//var tmpsp = kola.speed
			//if(metric == 'mi')
				//tmpsp = Math.round(parseFloat(tmpsp) * 0.621371 * 100)/100 + ' miles';
				
			$('#vh-temp-' + kola.id).html(Math.round(kola.temperature * 100)/100 + ' °C');
			$('#vh-litres-' + kola.id).html(Math.round(Math.round(kola.litres * 100)/100) + ' L');
			$('#vh-ultrasonic-' + kola.id).html(Math.round(Math.round(kola.ultrasonic * 100)/100) + ' L');
			var mmetric = ' Km';
			if(metric == 'mi')
				mmetric = ' miles';

			if (parseInt(kola.cbfuel, 10) == 0 && parseInt(kola.cbrpm, 10) == 0 && (parseInt(kola.cbtemp, 10) == 0 || parseInt(kola.cbtemp, 10) == -40) && parseInt(kola.cbdistance, 10) == 0)
			{
				$('#vh-up-odometar-' + kola.id).css({ display: "block" });
				if(kola.odometar == "0")
				{
					$('#vh-odometar-' + kola.id).html('/');
				} else
				{
					if(kola.service != "")
					{
						if(parseInt(kola.service, 10) < 300)
							var _service = ' (<font style="color: Red;">'+commaSeparateNumber(kola.service)+' '+mmetric+'</font>)';
						else
							var _service = " ("+commaSeparateNumber(kola.service)+" "+mmetric+")";
					} else
					{
						var _service = "";
					}
					var currkm = commaSeparateNumber(parseInt(kola.odometar, 10)) + mmetric;
					$('#vh-odometar-' + kola.id).html(currkm + _service);

					if(_service != "")
					{
						$('#vh-odometar-' + kola.id).mousemove(function (event) {
							if(parseInt($('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")).replace(".", ""), 10) < 300)
								var nexserv = '<font style="color: Red;">' + $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")) + '</font>';
							else
								var nexserv = $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")"));
		                    ShowPopup(event, 'Изминати километри: <b>' + $('#'+this.id).html().substring(0, $('#'+this.id).html().indexOf("(")-1) + '</b><br/>Преостануваат <b>' + nexserv + '</b> до следен сервис!');
		                });
					} else
					{
						$('#vh-odometar-' + kola.id).mousemove(function (event) {
		                    ShowPopup(event, 'Изминати километри: <b>' + $('#'+this.id).html() + '</b>');
		                });
					}
	                $('#vh-odometar-' + kola.id).mouseout(function () { HidePopup() });
				}
			} else
			{
				if (parseInt(kola.cbdistance, 10) == 0)
				{
					$('#vh-up-odometar-' + kola.id).css({ display: "block" });
					if(kola.odometar == "0")
					{
						$('#vh-odometar-' + kola.id).html('/');
					} else
					{
						if(kola.service != "")
						{
							if(parseInt(kola.service, 10) < 300)
								var _service = ' (<font style="color: Red;">'+commaSeparateNumber(kola.service)+' '+mmetric+'</font>)';
							else
								var _service = " ("+commaSeparateNumber(kola.service)+" "+mmetric+")";
						} else
						{
							var _service = "";
						}
						var currkm = commaSeparateNumber(parseInt(kola.odometar, 10)) + mmetric;
						$('#vh-odometar-' + kola.id).html(currkm + _service);
						
						if(_service != "")
						{
							$('#vh-odometar-' + kola.id).mousemove(function (event) {
								if(parseInt($('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")).replace(".", ""), 10) < 300)
									var nexserv = '<font style="color: Red;">' + $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")) + '</font>';
								else
									var nexserv = $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")"));
			                    ShowPopup(event, 'Изминати километри: <b>' + $('#'+this.id).html().substring(0, $('#'+this.id).html().indexOf("(")-1) + '</b><br/>Преостануваат <b>' + nexserv + '</b> до следен сервис!');
			                });
						} else
						{
							$('#vh-odometar-' + kola.id).mousemove(function (event) {
			                    ShowPopup(event, 'Изминати километри: <b>' + $('#'+this.id).html() + '</b>');
			                });
						}
		                $('#vh-odometar-' + kola.id).mouseout(function () { HidePopup() });
					}
				} else
				{
					$('#vh-up-odometar-' + kola.id).css({ display: "none" });
				}
			}
			
			// weather
			if(allowweather == '1') {
    			if(_podatoci.split("#")[j].split("|")[41] != undefined) {
        			if(_podatoci.split("#")[j].split("|")[41] != "") {
        			    var _weather = _podatoci.split("#")[j].split("|")[41].split("@@@");
        			    if(_weather[3] == "" || parseInt(_weather[0], 10) > 50)
                        {
                            $('#row0-' + kola.id).css({ display: 'none' });
                            $('#weather-' + kola.id).css({display: 'block'});
                            $('#weather-link-' + kola.id).attr('href', 'http://www.wunderground.com/cgi-bin/findweather/getForecast?query=' + kola.lat + ',' + kola.lon);
                            $('#row4-table-' + kola.id).css({paddingBottom: '0px'});
                            $('#row4-' + kola.id).css({ display: '' });
                        } else {
                            $('#row0-' + kola.id).css({ display: 'block' });
                            if(metric.toLowerCase() == 'km') {
                                $('#weather-temp-' + kola.id).html(parseInt(_weather[3], 10) + ' °C');
                                $('#weather-temp-' + kola.id)[0].setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + dic('feelslike', lang) + ": " + parseInt(_weather[5], 10) + " °C</strong>')");
                                $('#weather-feelslike-' + kola.id).html(parseInt(_weather[5], 10) + ' °C');
                            } else {
                                $('#weather-temp-' + kola.id).html(parseInt(_weather[4], 10) + ' F');
                                $('#weather-temp-' + kola.id)[0].setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + dic('feelslike', lang) + ": " + parseInt(_weather[6], 10) + " F</strong>')");
                                $('#weather-feelslike-' + kola.id).html(parseInt(_weather[6], 10) + ' F');
                            }
                            $('#weather-temp-' + kola.id).mouseout(function () { HidePopup() });
                            $('#weather-weather-' + kola.id).html(_weather[7]);
                            $('#weather-humidity-' + kola.id).html(_weather[8]);
                            if(metric.toLowerCase() == 'km')
                                $('#weather-wind-' + kola.id).html(_weather[9] + ' km/h');
                            else
                                $('#weather-wind-' + kola.id).html(_weather[10] + ' mph');
                            $('#weather-img-' + kola.id).attr('src', _weather[12]);
                            $('#weather-link-' + kola.id).attr('href', _weather[13]);
                            $('#row4-table-' + kola.id).css({paddingBottom: '5px'});
                            $('#weather-' + kola.id).css({display: 'block'});
                            if(_weather[2] != '') {
                                var _sdt = new Date(_weather[2] * 1000);
                                var tmpdt = _sdt.getFullYear() + '-' + onenum(parseInt(_sdt.getMonth(), 10) + 1) + '-' + onenum(_sdt.getDate()) + ' ' + onenum(_sdt.getHours()) + ':' + onenum(_sdt.getMinutes()); // + ':' + onenum(_sdt.getSeconds());
                                tmpdt = formatdatetime(tmpdt);
                            } else {
                                var tmpdt = '/';
                            }
                            $('#weather-time-' + kola.id).html(tmpdt);
                        }
        			} else {
        			    $('#weather-' + kola.id).css({display: 'none'});
        			}
    			} else {
    			    $('#weather-' + kola.id).css({display: 'none'});
    			}
			}
			/*if(kola.datediff != '') {
                if(dateDiff123(kola.fulldt, kola.datediff) > 7200) {
                    getWeather(kola.id, kola.lon, kola.lat, _podatoci.split("#")[j].split("|")[27]);
                    Car[po].datediff = kola.fulldt;
                }
            } else {
                getWeather(kola.id, kola.lon, kola.lat, _podatoci.split("#")[j].split("|")[27]);
                Car[po].datediff = kola.fulldt;
            }*/
			// weather
			
            $('#vh-speed-' + kola.id).html(' ' + kola.speed + ' ');
            if(kola.battery != '/' && kola.battery != undefined){
                if(parseInt(kola.battery, 10) != 0)
                    $('#vh-battery-' + kola.id).html(' ' + parseInt(kola.battery, 10) + ' %');
                else
                    $('#vh-battery-' + kola.id).html(' / ');
            } else
                $('#vh-battery-' + kola.id).html(' / ');
            if(kola.inputvoltage != '/' && kola.inputvoltage != undefined){
                if(parseInt(kola.inputvoltage, 10) != 0)
                    $('#vh-inputvoltage-' + kola.id).html(' ' + parseFloat(kola.inputvoltage).toFixed(2) + ' V');
                else
                    $('#vh-inputvoltage-' + kola.id).html(' / ');
            } else
                $('#vh-inputvoltage-' + kola.id).html(' / ');
            //if (kola.location == '') { $('#vh-pp-' + kola.id).css("borderTop", '0px') } else { $('#vh-pp-' + kola.id).css("borderTop", '1px dotted #333') }
            tmr = tmr + 100
            if(kola.sedista == "/")
            {
            	_imgsedista = '<img src="../images/nosignal.png" onmousemove="ShowPopup(event, \'Потребна проверка на сензори на седишта\')" onmouseout="HidePopup()" style="width: 11px; position: relative; margin-top: 0px; margin-left: 2px; height: 11px; margin-bottom: -2px;" id="img-senzor-'+kola.id+'">';
            	$('#vh-sedista-' + kola.id).html(_imgsedista);
            } else
        	{
            	$('#vh-sedista-' + kola.id).html(kola.sedista);
            }
            
            if (kola.taxi == '1') { $('#div-taxi-' + kola.id).css('color', '#009933') } else { $('#div-taxi-' + kola.id).css('color', '#FF0000') }
            if (kola.digalka == '1') { $('#div-hoist-' + kola.id).css('color', '#009933') } else { $('#div-hoist-' + kola.id).css('color', '#FF0000') }
            
            if (kola.kapaci == '1') { $('#div-kapaci-' + kola.id).css('color', '#009933') } else { $('#div-kapaci-' + kola.id).css('color', '#FF0000') }
            if (kola.pumpa == '1') { $('#div-pumpa-' + kola.id).css('color', '#009933') } else { $('#div-pumpa-' + kola.id).css('color', '#FF0000') }
            if (kola.sopatnik == '1') { $('#div-sovozac-' + kola.id).css('color', '#009933') } else { $('#div-sovozac-' + kola.id).css('color', '#FF0000') }
            $('#vh-rpm-' + kola.id).html(kola.rpm);
        }
        //AnimateMarker(kola.id, parseFloat(kola.lon), parseFloat(kola.lat), kola.color)
    }
    FirstLoad = false;
    //checkVehicesOnMap()
    /*for (var i = 0; i < 4; i++) {
        if (Boards[i] != null) {
            resetScreen[i] = false;
            if (FollowAllVehicles[i]) {
                zoomWorldScreen(Maps[i], Maps[i].zoom);
            }
       	}
  	}*/
  	
  	
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
            /*var dist = new Array();
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
            }*/
        }
    }
    
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
}
function onenum(_num){
    return parseInt(_num, 10) < 10 ? '0'+parseInt(_num, 10) : parseInt(_num, 10); 
}

function getWeather(_id, _lon, _lat, _vehid) {
    return;
    var _ll = lang.toUpperCase();
    var _url = urlForWeather.replace('##LAT##', _lat).replace('##LON##', _lon).replace('##LANG##', _ll);
    $.ajax({
        url: _url,
        type: "GET",
        dataType: "jsonp",
        async: false,
        success: function (msg) {
            var urlinsert = "./weatherStations.php?";
            urlinsert += "city=" + kescape(msg.current_observation.observation_location.city);
            urlinsert += "&country=" + msg.current_observation.observation_location.country;
            urlinsert += "&elevation=" + kescape(msg.current_observation.observation_location.elevation);
            urlinsert += "&fullname=" + kescape(msg.current_observation.observation_location.full);
            urlinsert += "&lon=" + msg.current_observation.observation_location.longitude;
            urlinsert += "&lat=" + msg.current_observation.observation_location.latitude;
            urlinsert += "&otime=" + msg.current_observation.observation_epoch;
            if(metric.toLowerCase() == 'km') {
                urlinsert += "&temp=" + msg.current_observation.temp_c;
                urlinsert += "&feelslike=" + msg.current_observation.feelslike_c;
                urlinsert += "&wind=" + msg.current_observation.wind_kph;
                urlinsert += "&visibility=" + msg.current_observation.visibility_km;
            } else {
                urlinsert += "&temp=" + msg.current_observation.temp_f;
                urlinsert += "&feelslike=" + msg.current_observation.feelslike_f;
                urlinsert += "&wind=" + msg.current_observation.wind_mph;
                urlinsert += "&visibility=" + msg.current_observation.visibility_mi;
            }
            urlinsert += "&weather=" + kescape(msg.current_observation.weather);
            urlinsert += "&humidity=" + msg.current_observation.relative_humidity;
            urlinsert += "&icon=" + kescape(msg.current_observation.icon);
            urlinsert += "&iconurl=" + kescape(msg.current_observation.icon_url);
            $.ajax({
                url: urlinsert,
                context: document.body,
                success: function (data) { 
                    
                    if(msg.current_observation.temp_c == null)
                    {
                        $('#weather-' + _id).css({display: 'none'});
                    } else {
                        if(metric.toLowerCase() == 'km') {
                            $('#weather-temp-' + _id).html(parseInt(msg.current_observation.temp_c, 10) + ' °C');
                            $('#weather-temp-' + _id)[0].setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + dic('feelslike', lang) + ": " + parseInt(msg.current_observation.feelslike_c, 10) + " °C</strong>')");
                            $('#weather-feelslike-' + _id).html(parseInt(msg.current_observation.feelslike_c, 10) + ' °C');
                        } else {
                            $('#weather-temp-' + _id).html(parseInt(msg.current_observation.temp_f, 10) + ' F');
                            $('#weather-temp-' + _id)[0].setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 14px;\">" + dic('feelslike', lang) + ": " + parseInt(msg.current_observation.feelslike_f, 10) + " F</strong>')");
                            $('#weather-feelslike-' + _id).html(parseInt(msg.current_observation.feelslike_f, 10) + ' F');
                        }
                        $('#weather-temp-' + _id).mouseout(function () { HidePopup() });
                        $('#weather-weather-' + _id).html(msg.current_observation.weather);
                        $('#weather-humidity-' + _id).html(msg.current_observation.relative_humidity);
                        if(metric.toLowerCase() == 'km')
                            $('#weather-wind-' + _id).html(msg.current_observation.wind_kph + ' km/h');
                        else
                            $('#weather-wind-' + _id).html(msg.current_observation.wind_mph + ' mph');
                        $('#weather-img-' + _id).attr('src', msg.current_observation.icon_url);
                        $('#weather-' + _id).css({display: 'block'});
                        if(msg.current_observation.observation_epoch != '') {
                            var _sdt = new Date(msg.current_observation.observation_epoch * 1000);
                            var tmpdt = _sdt.getFullYear() + '-' + onenum(parseInt(_sdt.getMonth(), 10) + 1) + '-' + onenum(_sdt.getDate()) + ' ' + onenum(_sdt.getHours()) + ':' + onenum(_sdt.getMinutes()); // + ':' + onenum(_sdt.getSeconds());
                            tmpdt = formatdatetime(tmpdt);
                        } else {
                            var tmpdt = '/';
                        }
                        $('#weather-time-' + _id).html(tmpdt);
                    }
                }
            });
             /*$('#weather-temp-' + _id).html(parseInt(msg.data.current_condition[0].temp_C, 10) + ' °C');
             $('#weather-weather-' + _id).html(msg.data.current_condition[0].weatherDesc[0].value);
             $('#weather-humidity-' + _id).html(msg.data.current_condition[0].humidity + ' %');
             $('#weather-wind-' + _id).html(msg.data.current_condition[0].windspeedKmph + ' Kmph');
             $('#weather-img-' + _id).attr('src', msg.data.current_condition[0].weatherIconUrl[0].value);
             $('#weather-' + _id).css({display: 'block'});
             //var _sdt = new Date(msg.dt * 1000);
             //var tmpdt = _sdt.getFullYear() + '-' + onenum(parseInt(_sdt.getMonth(), 10) + 1) + '-' + onenum(_sdt.getDate()) + ' ' + onenum(_sdt.getHours()) + ':' + onenum(_sdt.getMinutes()) + ':' + onenum(_sdt.getSeconds());
             tmpdt = formatdatetime(msg.data.time_zone[0].localtime);
             $('#weather-time-' + _id).html(tmpdt);*/
             //$('#weather-time-' + _id).html(msg.data.current_condition[0].observation_time);
        },
        error: function (err) {
            $('#weather-' + _id).css({display: 'none'});
        }
    });
}

function getPosNew1(_podatoci){
	//_podatoci = "#5|20.952515|42.002388|Red|0|25-03-2015 13:41:48||11.088000|0|1|0||146, Тетово, Македонија|TE-6703-AB|0|2015-03-25 13:41:48.34|0.00000000000000000000|0.000000|0.000000|0.000000|0.000000|0.000000||31851.368016||1|/|2288|1|0|0|0 rpm|/|0|075254804|0|/|0|/|0|0|1.30@@@7@@@1427284469@@@9@@@49@@@9@@@49@@@Слаб дожд@@@80%@@@17@@@10@@@rain@@@http://icons.wxug.com/i/c/k/rain.gif@@@http://www.wunderground.com/cgi-bin/findweather/getForecast?query=42.013336,20.964943";
	//if(iszooming){return false;}
	ParseVehicleWS1(_podatoci)
}


function ShowHideRow(_id) {
    if($('#row2-' + _id).css('display') == 'none') {
        $('#row1-' + _id).css({ display: '' });
        $('#row2-' + _id).css({ display: '' });
        $('#row3-' + _id).css({ display: '' });
        $('#row4-' + _id).css({ display: '' });
    } else {
        $('#row1-' + _id).css({ display: 'none' });
        $('#row2-' + _id).css({ display: 'none' });
        $('#row3-' + _id).css({ display: 'none' });
        $('#row4-' + _id).css({ display: 'none' });
    }
}
function ConnectToServer(){
	ws = $.websocket("ws://144.76.225.247:8088/", {			
	events: {
			message: function(e) { 
				//$('#content').append(e.data + '<br>')
				HideWait();
			 	getPosNew(e.data);
				LastServerCommunication = new Date();
			},
			reload: function(e) {
                var feed = e.data+'';
                if(feed == 'reload')
                    location.reload();
            },
			feedback: function(e) {
                HideWait();
                var feed = e.data+'';
                feed = feed.split("|");
                $('#div-engineblockwaiting').dialog('close');
                if(feed[1] == 'MotorBlocked'){
                    $.ajax({
                        url: "InsertActivities.php?action=block&vehid="+feed[0],
                            context: document.body,
                            success: function (data) {
                        }
                    });
                    $('#naredba2_'+feed[0] + ' span').text("Moto-deblock");
                    $('#naredba2_'+feed[0]).css({ backgroundColor: '#387cb0', color: '#ffffff' });
                }
                if(feed[1] == 'MotorDeBlocked'){
                    $.ajax({
                        url: "InsertActivities.php?action=deblock&vehid="+feed[0],
                            context: document.body,
                            success: function (data) {
                        }
                    });
                    $('#naredba2_'+feed[0] + ' span').text("Moto-block");
                    $('#naredba2_'+feed[0]).css({ backgroundColor: '#f6f6f6', color: '#2f5185' });                    
                }
                if(feed[1] == 'AlarmSent'){
                    $.ajax({
                        url: "InsertActivities.php?action=alarm&vehid="+feed[0],
                            context: document.body,
                            success: function (data) {
                        }
                    });
                }
                if(feed[1] == 'GeoLockOn'){
                    $.ajax({
                        url: "InsertActivities.php?action=geolock&vehid="+feed[0]+"&status=1&radius="+CircleRadius[feed[0]]+"&longitude="+CircleLon[feed[0]]+"&latitude="+CircleLat[feed[0]],
                            context: document.body,
                            success: function (data) {
                        }
                    });
                    $('#naredba3_'+feed[0]).css({ backgroundColor: '#387cb0', color: '#ffffff' });
                }
                if(feed[1] == 'GeoLockOff'){
                    $.ajax({
                        url: "InsertActivities.php?action=geolock&vehid="+feed[0]+"&status=0&radius=50&longitude=0&latitude=0",
                            context: document.body,
                            success: function (data) {
                        }
                    });
                    $('#naredba3_'+feed[0]).css({ backgroundColor: '#f6f6f6', color: '#2f5185' });
                }
                $('#div-feedbackblock').html(feed[1]);
                $('#div-feedbackblock').dialog({ modal: true, width: 280, height: 220, resizable: false, zIndex: 9998,
                    buttons: 
                    [{
                        text:'Ok',
                        click: function() {
                            $( this ).dialog( "close" );
                        }
                    }]
                });
                LastServerCommunication = new Date();
            },
			pong: function(e) { 					
				LastServerCommunication = new Date();
			},
			login: function(e){
				LastServerCommunication = new Date();
				if (e.data=="WhoAreYou"){
				    if(clientid != '' && VehcileIDsWS != '') {
					   ws.send('login','{"clientid":"'+clientid+'","vehicles":"'+VehcileIDsWS+'"}');
				    } 
				}	
				if (e.data=="LoginIsOK"){
					HideConnectionLost();
				}	
			}
		}
	});
}
function ConnectToServer1(){
	//alert(999)
	ws = $.websocket("ws://144.76.225.247:8088/", {	
	//ws = $.websocket("ws://192.168.2.13:8088/", {			
	events: {
			message: function(e) { 
				//$('#content').append(e.data + '<br>')
				//alert("-1-" + e.data)
				HideWait();
				//debugger;
			 	getPosNew1(e.data);
				LastServerCommunication = new Date();
			},
			feedback: function(e) {
            },
			pong: function(e) { 					
				LastServerCommunication = new Date();
			},
			login: function(e){
				LastServerCommunication = new Date();
				if (e.data=="WhoAreYou"){
				    if(clientid != '' && VehcileIDsWS != '') {
					   ws.send('login','{"clientid":"'+clientid+'","vehicles":"'+VehcileIDsWS+'"}');
				    } 
				}	
				if (e.data=="LoginIsOK"){
					HideConnectionLost();
				}	
			}
		}
	});
}
function IsConnected(){
	if (ws==null){
		//ConnectionLost('Изгубена конекција!');
		ConnectToServer()
		LastServerCommunication = new Date();			
	} else {
		ws.send('ping',"");
		var currentdate = new Date(); 
		var ddiff = currentdate - LastServerCommunication
		if(ddiff>5*1000){
			ConnectionLost('Изгубена конекција!');
			ws.close();
			ws = null
		}
	}
	setTimeout("IsConnected()",3000)
}

function IsConnected1(){
	if (ws==null){
		//ConnectionLost('Изгубена конекција!');
		ConnectToServer1()
		LastServerCommunication = new Date();			
	} else {
		ws.send('ping',"");
		var currentdate = new Date(); 
		var ddiff = currentdate - LastServerCommunication
		if(ddiff>5*1000){
			ConnectionLost('Изгубена конекција!');
			ws.close();
			ws = null
		}
	}
	setTimeout("IsConnected1()",3000)
}
function motoblock(_gsmnum, _id){
    if($($('#'+_id).children()[0]).html() == 'Moto-block')
    {
        $('#div-ask-engineblock').dialog({ modal: true, width: 280, height: 220, resizable: false, zIndex: 9998,
            buttons: 
            [{
                text:dic("Settings.Yes"),
                click: function() {
                    if(hex_md5($('#txtBlock').val()) == passwordforblock)
                    {
                        //ShowWait();
                        $('#txtBlock').val('');
                        //$('#'+_id + ' span').text("Moto-deblock");
                        //$('#'+_id).css({ backgroundColor: '#387cb0', color: '#ffffff' });
                        ws.send('commandfromapp', _gsmnum + '|*@AT+GTOUT=##PASS##,0,0,0,1,,,,,,,,,,FFFF$|*@2');
                        $( this ).dialog( "close" );
                        $.ajax({
                            url: "AddLog.php?id=51&desc=" + _gsmnum,
                                context: document.body,
                                success: function (data) {
                            }
                        });
                        $('#div-engineblockwaiting').dialog({ dialogClass: 'no-close', modal: true, width: 450, height: 220, resizable: false, zIndex: 9998,
                            buttons: 
                            [{
                                text:dic("Tracking.Cancel",lang),
                                click: function() {
                                    $(this).dialog( "close" );
                                }
                            }],
                            close: function(ev, ui) {  }
                        });
                        
                    } else {
                        alert('Wrong password!');
                    }
                }
            },
            {
                text:dic("Settings.No",lang),
                click: function() {
                    $( this ).dialog( "close" );
                }
            }]
        });
    } else {
        $('#div-ask-enginedeblock').dialog({ modal: true, width: 280, height: 220, resizable: false, zIndex: 9998,
            buttons: 
            [{
                text:dic("Settings.Yes"),
                click: function() {
                    if(hex_md5($('#txtDeBlock').val()) == passwordforblock)
                    {
                        ShowWait();
                        $('#txtDeBlock').val('');
                        //$('#'+_id + ' span').text("Moto-block");
                        //$('#'+_id).css({ backgroundColor: '#f6f6f6', color: '#2f5185' });
                        ws.send('commandfromapp', _gsmnum + '|*@AT+GTOUT=##PASS##,0,0,0,0,,,,,,,,,,FFFF$|*@3');
                        $.ajax({
                            url: "AddLog.php?id=52&desc=" + _gsmnum,
                                context: document.body,
                                success: function (data) {
                            }
                        });
                        $( this ).dialog( "close" );
                    } else {
                        alert('Wrong password!');
                    }
                }
            },
            {
                text:dic("Settings.No",lang),
                click: function() {
                    $( this ).dialog( "close" );
                }
            }]
        });
    }
}
function motoalarm(_gsmnum){
    $('#div-ask-motoalarm').dialog({ modal: true, width: 311, height: 150, resizable: false, zIndex: 9998,
        buttons: 
        [{
            text:dic("Settings.Yes"),
            click: function() {
                ShowWait();
                $.ajax({
                    url: "CheckBlockStatus.php?gsmnum=" + _gsmnum,
                        context: document.body,
                        success: function (data) {
                            data = data.replace(/\r/g,'').replace(/\n/g,'');
                            ws.send('commandfromapp', _gsmnum + '|*@AT+GTOUT=##PASS##,1,5,3,'+data+',,,,,,,,,,FFFF$|*@1');
                        }
                });
                $( this ).dialog( "close" );
            }
        },
        {
            text:dic("Settings.No",lang),
            click: function() {
                $( this ).dialog( "close" );
            }
        }]
    });
}
function removeCircle(_id){
    map.removeLayer(CircleVeh[_id]);
    CircleVeh[_id] = undefined;
    CircleRadius[_id] =undefined;
    CircleLon[_id] = undefined;
    CircleLat[_id] = undefined;
}
function drawCircle(_id, _lon, _lat, _radius){
    if(CircleVeh[_id] != undefined && CircleVeh[_id] != null)
        map.removeLayer(CircleVeh[_id]);
    var ll = new OpenLayers.LonLat(parseFloat(_lon), parseFloat(_lat)).transform(new OpenLayers.Projection("EPSG:4326"), map.getProjectionObject());

    var defaultStyle = new OpenLayers.Style({ 'strokeWidth': 1, 'strokeColor': '#FF0000', 'fillOpacity': 0.5, 'fillColor': '#000000' });
    var styleMap = new OpenLayers.StyleMap({'default': defaultStyle });        
    CircleVeh[_id] = new OpenLayers.Layer.Vector("Overlay", {styleMap: styleMap });
    var point = new OpenLayers.Geometry.Point(ll.lon, ll.lat);

    var mycircle = OpenLayers.Geometry.Polygon.createRegularPolygon
    (
        point,
        _radius,
        40,
        0
    );
    var featurecircle = new OpenLayers.Feature.Vector(mycircle);
    var featurePoint = new OpenLayers.Feature.Vector(point);
    
    CircleVeh[_id].addFeatures([featurePoint, featurecircle]);
    
    map.addLayer(CircleVeh[_id]);
    CircleRadius[_id] = _radius;
    CircleLon[_id] = _lon;
    CircleLat[_id] = _lat;
}
function geolock(_gsmnum, _id, _code){
    if($('#naredba3_'+_id).css('backgroundColor') == "rgb(56, 124, 176)")
    {
        $('#div-ask-geolockoff').dialog({ modal: true, width: 311, height: 190, resizable: false, zIndex: 9998,
            buttons: 
            [{
                text:dic("Settings.Yes"),
                click: function() {
                    ShowWait();
                    removeCircle(_id);
                    ws.send('commandfromapp', _gsmnum + '|*@AT+GTGEO=##PASS##,0,0,0,0,50,30,0,0,0,0,,,,,FFFF$|*@5');
                    $.ajax({
                        url: "AddLog.php?id=54&desc=" + _gsmnum,
                            context: document.body,
                            success: function (data) {
                        }
                    });
                    $( this ).dialog( "close" );
                }
            },
            {
                text:dic("Settings.No",lang),
                click: function() {
                    $( this ).dialog( "close" );
                }
            }]
        });
    } else {
        $('#div-ask-geolockon').dialog({ modal: true, width: 311, height: 220, resizable: false, zIndex: 9998,
            buttons: 
            [{
                text:dic("Settings.Yes"),
                click: function() {
                    for(var i=0; i < Car.length; i++)
                        if(Car[i].id == _code)
                        {
                            var lon = Car[i].lon;
                            var lat = Car[i].lat;
                            break;
                        }
                    ShowWait();
                    drawCircle(_id, lon, lat, $('#txtRadius').val());
                    ws.send('commandfromapp', _gsmnum + '|*@AT+GTGEO=##PASS##,0,2,'+lon+','+lat+','+$('#txtRadius').val()+',30,0,0,0,0,,,,,FFFF$|*@4');
                    $.ajax({
                        url: "AddLog.php?id=53&desc=" + _gsmnum,
                            context: document.body,
                            success: function (data) {
                        }
                    });
                    $( this ).dialog( "close" );
                }
            },
            {
                text:dic("Settings.No",lang),
                click: function() {
                    $( this ).dialog( "close" );
                }
            }]
        });
    }
}
function dateDiff123(_dt1, _dt2){
	var year1 = _dt1.split(" ")[0].split("-")[0];
	var month1 = _dt1.split(" ")[0].split("-")[1];
	var day1 = _dt1.split(" ")[0].split("-")[2];
	var hours1 = _dt1.split(" ")[1].split(":")[0];
	var min1 = _dt1.split(" ")[1].split(":")[1];
	var sec1 = _dt1.split(" ")[1].split(":")[2];

	var year2 = _dt2.split(" ")[0].split("-")[0];
	var month2 = _dt2.split(" ")[0].split("-")[1];
	var day2 = _dt2.split(" ")[0].split("-")[2];
	var hours2 = _dt2.split(" ")[1].split(":")[0];
	var min2 = _dt2.split(" ")[1].split(":")[1];
	var sec2 = _dt2.split(" ")[1].split(":")[2];

	var t1 = new Date(year1, month1, day1, hours1, min1, sec1, 0);
	var t2 = new Date(year2, month2, day2, hours2, min2, sec2, 0);
	var dif = t1.getTime() - t2.getTime()

	var Seconds_from_T1_to_T2 = dif / 1000;
	var Seconds_Between_Dates = Math.abs(Seconds_from_T1_to_T2);
	return Seconds_Between_Dates;
}
function CheckForLostConn(){
	$.ajax({
	    url: './getDateTime.php',
	    context: document.body,
	    success: function (data) {
	    	data = data.replace(/\r/g,'').replace(/\n/g,'');
			$('#datetimenow').val(data);
			for (var i = 0; i < Car.length; i++) {
				var kola = Car[i];
				if($('#vh-date-' + kola.id).css("color") != "rgb(255, 0, 0)")
				{
					var _date = kola.fulldt.split(".")[0];
					var _date1 = $('#datetimenow').val();
					var ddiff = dateDiff123(_date, _date1);
		
					if(ddiff > 290)
					{
						$('#vh-date-' + kola.id).css("color", "#FF0000");
						if(kola.ignition == '1')
						{
							Car[i].color = nocommunication;
							Car[i].noconnection = true;
		
				    		for (var j = 0; j < Vehicles.length; j++) {
				    			if (Vehicles[j].el.style.display != "none") {
						        	for (var z = 0; z < 4; z++) {
						            	if (Boards[z] != null) {
						                	if ((Vehicles[j].ID == kola.id) && (Vehicles[j].Map == z)) {
						                		$('#img-vehicle-' + z + '-' + kola.id).remove();
						                		Vehicles[j].Color = nocommunication;
		                    					Vehicles[j].el.children[0].className = "gnMarker" + nocommunication + " text3";
		                    					Vehicles[j].el.children[1].className = "gnMarkerPointer" + nocommunication;
				    							$($(Vehicles[j].Marker.events.element).children()[0]).append('<div id="img-vehicle-' + z + '-' + kola.id + '" style="height: 16px; background-image: url(\'../images/nocommunication.png\'); position: absolute; width: 16px; z-index: 9; left: 12px; top: 12px;"></div>');
						                	}
						               }
						           }
						       }
						    }
				    		
			        		$('#img-pass-' + kola.id).remove();
			        		$('#img-sv-' + kola.id).remove();
			        		$('#img-small-' + kola.id).remove();
			        		
		        			$('#div-pass-' + kola.id).append('<img id="img-pass-' + kola.id + '" style="height: 13px; position: relative; width: 13px; margin-left: 11px; margin-top: -4px;" src="../images/nocommunication.png">');
		        			$('#div-sv-' + kola.id).append('<img id="img-sv-' + kola.id + '" style="height: 13px; position: relative; width: 13px; margin-left: 11px; margin-top: -4px;" src="../images/nocommunication.png">');
		        			$('#vh-small-' + kola.id).append('<img id="img-small-' + kola.id + '" style="height: 13px; width: 13px; top: -3px; position: relative; left: 6px;" src="../images/nocommunication.png">');
				
							document.getElementById('div-sv-' + kola.id).className = 'gnMarkerList' + nocommunication + ' text3'
							document.getElementById('vh-small-' + kola.id).className = 'gnMarkerList' + nocommunication + ' text3'
				        }
					}
				}
			}
			setTimeout("CheckForLostConn()", 5000);
	    },
	    error: function () {
	        setTimeout("CheckForLostConn()", 2000);
	    }
	});
}
/*function getLeftList(tlang) {
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
	        //Ajax();
	        setTimeout("IsConnected()",3000);
	        setTimeout("CheckForLostConn()", 120000);
	    },
	    error: function () {
	        HideWait();
	        setTimeout("getLeftList("+tlang+");", 2000);
	    }
	});
}*/
function testKiki() {
   LoadCurrentPosition = true
    AjaxStarted = false
    //Ajax();
    setTimeout("IsConnected1()",3000);
    setTimeout("CheckForLostConn()", 120000);
}
function changeOrder(newOrder) {
    var $divs = $.merge($('.menu-container-collapsed'),$('.menu-container')),
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
            		//var temp = data.replace("\r", "");
            		//temp = temp.replace("\n", "");
            		var temp = data.replace(/\r/g,'').replace(/\n/g,'');
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
        $('#searchVeh').css({ width: '1px' });
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
        $('#searchVeh').css({ width: '248px' });
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
        var icon = new OpenLayers.Icon(twopoint + '/images/pin-1.png', size, null, calculateOffset);

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
        //var _bgimg = 'http://80.77.159.246:88/new/pin/?color=' + _color + '&type=0';
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
        url: twopoint + "/main/searchMarkers.php?name=" + $('#' + _id).val() + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
        	data = data.replace(/\r/g,'').replace(/\n/g,'');
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
				var j = 1;
				if(data.split("$$")[0] != "")
                {
	                for (var i = 1; i < _pp.length; i++) {
	                    _items[i] = "";
	                    _items[i] += "<img width='18px' src=\'" + twopoint + "/images/poiButton.png\' />  <strong style='font-size: 14px;'>"+dic("Poi", lang)+"</strong><br />";
	                    _items[i] += "<strong style='font-size: 14px;'>" + dic("Name", lang) + ":</strong> " + _pp[i].split("|")[2] + "<br />";
	                    //_items[i] += "<strong style='font-size: 14px;'>" + dic("AddInfo", lang) + "</strong> " + _pp[i].split("|")[6] + "<br />";
	                    _items[i] += "<strong style='font-size: 14px;'>" + dic("Group", lang) + "</strong> " + _pp[i].split("|")[8] + "<br />";
	                    _html += "<a id='searchMarker-" + i + "' style='cursor: pointer;' onmouseover='this.style.textDecoration=\"underline\"' onmouseout='this.style.textDecoration=\"\"' onclick='setCenterMap(" + _pp[i].split("|")[0] + ", " + _pp[i].split("|")[1] + ", 18, " + num + "); AddMarkerS2(" + num + ", \"" + escape(_pp[i]) + "\")'>" + (i) + ". <img width='14px' style='position: relative; top: 4px;' src=\'" + twopoint + "/images/poiButton.png\' /> " + _pp[i].split("|")[2] + "</a><br/>";
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
	                    _items[j] += "<img width='18px' src=\'" + twopoint + "/images/areaImg.png\' />  <strong style='font-size: 14px;'>"+dic("GeoFence", lang)+"</strong><br />";
	                    _items[j] += "<strong style='font-size: 14px;'>" + dic("Name", lang) + ":</strong> " + _pp[_br].split("|")[1] + "<br />";
	                    //_items[i] += "<strong style='font-size: 14px;'>" + dic("AddInfo", lang) + "</strong> " + _pp[i].split("|")[6] + "<br />";
	                    _items[j] += "<strong style='font-size: 14px;'>" + dic("Group", lang) + "</strong> " + _pp[_br].split("|")[7] + "<br />";
	                    _html += "<a id='searchMarker-" + j + "' style='cursor: pointer;' onmouseover='this.style.textDecoration=\"underline\"' onmouseout='this.style.textDecoration=\"\"' onclick='DrawZoneByName("+_pp[_br].split("|")[4]+"); DrawZoneOnLive("+_pp[_br].split("|")[4]+", \"#"+_pp[_br].split("|")[6]+"\")'>" + (j) + ". <img width='14px' style='position: relative; top: 4px;' src=\'" + twopoint + "/images/areaImg.png\' /> " + _pp[_br].split("|")[1] + "</a><br/>";
	                    if (i < _pp[_br].length - 2)
	                        _html += "<br/>";
                        _br++;
	                }
                }
                if(data.split("$$")[2] != "")
                {
	                var _pp = data.split("$$")[2].split("#");
	                var _br = 1;
	                for (var z = j; z < ((j-1)+_pp.length); z++) {
	                    _items[z] = "";
	                    _items[z] += "<img width='18px' src=\'" + twopoint + "/images/poiButton.png\' />  <strong style='font-size: 14px;'>"+dic("Poi", lang)+"</strong><br />";
	                    _items[z] += "<strong style='font-size: 14px;'>" + dic("Name", lang) + ":</strong> " + _pp[_br].split("|")[1] + "<br />";
	                    //_items[i] += "<strong style='font-size: 14px;'>" + dic("AddInfo", lang) + "</strong> " + _pp[i].split("|")[6] + "<br />";
	                    _items[z] += "<strong style='font-size: 14px;'>" + dic("Group", lang) + "</strong> " + _pp[_br].split("|")[7] + "<br />";
	                    _html += "<a id='searchMarker-" + j + "' style='cursor: pointer;' onmouseover='this.style.textDecoration=\"underline\"' onmouseout='this.style.textDecoration=\"\"' onclick='DrawZoneOnLivePoly("+_pp[_br].split("|")[4]+", \"#"+_pp[_br].split("|")[6]+"\")'>" + (z) + ". <img width='14px' style='position: relative; top: 4px;' src=\'" + twopoint + "/images/poiButton.png\' /> " + _pp[_br].split("|")[1] + "</a><br/>";
	                    if (j < _pp[_br].length - 2)
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
	        url: twopoint + "/main/searchMarkers.php?name=" + $('#' + _id).val() + "&tpoint=" + twopoint,
            context: document.body,
            success: function (data) {
            	data = data.replace(/\r/g,'').replace(/\n/g,'');
            	if(data == "**")
            	{
            		$('#outputSearch-' + num).html(dic("Reports.NoData1", lang));
	                $('#outputSearch-' + num).css({ display: 'block' });
            		$('#imgSearchLoading-' + num).css({ display: 'none' });
            	} else {
            		
	                var _html = "";
	                var _items = new Array();
					var i = 1;
					var j = 1;
					if(data.split("$$")[0] != "")
	                {
	                	var _pp = data.split("$$")[0].split("#");
		                for (var i = 1; i < _pp.length; i++) {
		                    _items[i] = "";
		                    _items[i] += "<img width='18px' src=\'" + twopoint + "/images/poiButton.png\' />  <strong style='font-size: 14px;'>"+dic("Poi", lang)+"</strong><br />";
		                    _items[i] += "<strong style='font-size: 14px;'>" + dic("Name", lang) + ":</strong> " + _pp[i].split("|")[2] + "<br />";
		                    //_items[i] += "<strong style='font-size: 14px;'>" + dic("AddInfo", lang) + "</strong> " + _pp[i].split("|")[6] + "<br />";
		                    _items[i] += "<strong style='font-size: 14px;'>" + dic("Group", lang) + "</strong> " + _pp[i].split("|")[8] + "<br />";
		                    _html += "<a id='searchMarker-" + i + "' style='cursor: pointer;' onmouseover='this.style.textDecoration=\"underline\"' onmouseout='this.style.textDecoration=\"\"' onclick='setCenterMap(" + _pp[i].split("|")[0] + ", " + _pp[i].split("|")[1] + ", 18, " + num + "); AddMarkerS2(" + num + ", \"" + escape(_pp[i]) + "\")'>" + (i) + ". <img width='14px' style='position: relative; top: 4px;' src=\'" + twopoint + "/images/poiButton.png\' /> " + _pp[i].split("|")[2] + "</a><br/>";
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
		                    _items[j] += "<img width='18px' src=\'" + twopoint + "/images/areaImg.png\' />  <strong style='font-size: 14px;'>"+dic("GeoFence", lang)+"</strong><br />";
		                    _items[j] += "<strong style='font-size: 14px;'>" + dic("Name", lang) + ":</strong> " + _pp[_br].split("|")[1] + "<br />";
		                    //_items[i] += "<strong style='font-size: 14px;'>" + dic("AddInfo", lang) + "</strong> " + _pp[i].split("|")[6] + "<br />";
		                    _items[j] += "<strong style='font-size: 14px;'>" + dic("Group", lang) + "</strong> " + _pp[_br].split("|")[7] + "<br />";
		                    _html += "<a id='searchMarker-" + j + "' style='cursor: pointer;' onmouseover='this.style.textDecoration=\"underline\"' onmouseout='this.style.textDecoration=\"\"' onclick='DrawZoneByName("+_pp[_br].split("|")[4]+"); DrawZoneOnLive("+_pp[_br].split("|")[4]+", \"#"+_pp[_br].split("|")[6]+"\")'>" + (j) + ". <img width='14px' style='position: relative; top: 4px;' src=\'" + twopoint + "/images/areaImg.png\' /> " + _pp[_br].split("|")[1] + "</a><br/>";
		                    if (i < _pp[_br].length - 2)
		                        _html += "<br/>";
	                        _br++;
		                }
	                }
	                if(data.split("$$")[2] != "")
	                {
		                var _pp = data.split("$$")[2].split("#");
		                var _br = 1;
		                for (var z = j; z < ((j-1)+_pp.length); z++) {
		                    _items[z] = "";
		                    _items[z] += "<img width='18px' src=\'" + twopoint + "/images/poiButton.png\' />  <strong style='font-size: 14px;'>"+dic("Poi", lang)+"</strong><br />";
		                    _items[z] += "<strong style='font-size: 14px;'>" + dic("Name", lang) + ":</strong> " + _pp[_br].split("|")[1] + "<br />";
		                    //_items[i] += "<strong style='font-size: 14px;'>" + dic("AddInfo", lang) + "</strong> " + _pp[i].split("|")[6] + "<br />";
		                    _items[z] += "<strong style='font-size: 14px;'>" + dic("Group", lang) + "</strong> " + _pp[_br].split("|")[7] + "<br />";
		                    _html += "<a id='searchMarker-" + j + "' style='cursor: pointer;' onmouseover='this.style.textDecoration=\"underline\"' onmouseout='this.style.textDecoration=\"\"' onclick='DrawZoneOnLivePoly("+_pp[_br].split("|")[4]+", \"#"+_pp[_br].split("|")[6]+"\")'>" + (z) + ". <img width='14px' style='position: relative; top: 4px;' src=\'" + twopoint + "/images/poiButton.png\' /> " + _pp[_br].split("|")[1] + "</a><br/>";
		                    if (j < _pp[_br].length - 2)
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
		        url: twopoint + "/main/searchGeocodeByLonLat.php?lon=" + lon + "&lat=" + lat + "&tpoint=" + twopoint,
		        context: document.body,
		        success: function (data) {
		            setCenterMap(lon, lat, 18, num);
		            AddMarkerS(lon, lat, num, data.replace(/\r/g,'').replace(/\n/g,''), "");
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
	        url: twopoint + "/main/searchGeocodeByLonLat.php?lon=" + lon + "&lat=" + lat + "&tpoint=" + twopoint,
	        context: document.body,
	        success: function (data) {
	            setCenterMap(lon, lat, 18, num);
	            AddMarkerS(lon, lat, num, data.replace(/\r/g,'').replace(/\n/g,''), "");
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
            url: twopoint + "/main/searchGeocode.php?name=" + $('#' + _id).val() + "&tpoint=" + twopoint,
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
        url: twopoint + "/main/searchGeocode.php?name=" + $('#' + _id).val() + "&tpoint=" + twopoint,
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
    _icon ="../images/icon.png";
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

    //if(_icon == "" || _icon == undefined)
    	//tmpMarkerStreet.events.element.innerHTML = '<div class="corner5" style="color: White; width: 14px; text-align: center; height: 14px; background: #' + _color + '; font-size: 11px; padding: 0px 1px 1px 0px;">○</div>';
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
        url: twopoint + "/routes/LoadRoute.php?id=" + _id + "&tpoint=" + twopoint,
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


function putInRouteKiki(_id, _lon, _lat, _name, _yesno, _idRoute, _type, _backColor, _seQ, callback) {
	//_seQ = 0;
	
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

	var markerCol = "0066ff";
	if (_backColor == "#BCEBA0") markerCol = "00CC33";
	if (_backColor == "#FAC3C3") markerCol = "FF0000";
		
	if (_len < 1) {
		CreateMarker_RouteKiki(_seQ, _lon, _lat, markerCol, '', 1, _name, _len, _id, _idRoute);
	} else {
		CreateMarker_RouteKiki(_seQ, _lon, _lat, markerCol, '', 3, _name, _len, _id, _idRoute);
	}
       
	if(_type != undefined)
    {
    	if(_type == "2")
    		PleaseDrawAreaAgain(_id, '#00CC33');
		else
			if(_type == "3")
	    		PleaseDrawAreaAgainPoly(_id, '#00CC33');
	}
	//alert(_len)
    if($('#MarkersIN')[0] != undefined) {
        if (Browser() != 'iPad')
        	var _html = '<div class="text8 corner5" onmousemove="ShowPopup(event, \'' + dic("Name", lang) + ': ' + _name + '\')" onmouseout="HidePopup();" ondblclick="setCenterMap(' + _lon + ', ' + _lat + ', 17,0)" style="background-color:'+_backColor+'; cursor: pointer; font-size:12; width:97%; padding:2px 2px 2px 7px; height:45px; background-image: url(\'images/updown.png\'); background-position: right center; background-repeat: no-repeat; background-origin: content-box; margin-bottom: 7px; margin-top: 7px;" id="IDMarker_' + _id + '_' + _len + '">';
    	else
    		var _html = '<div class="text8 corner5" onclick="setCenterMap(' + _lon + ', ' + _lat + ', 17,0)" style="background-color:'+_backColor+'; cursor: pointer; font-size:12; width:97%; padding:2px 2px 2px 7px; height:26px; background-image: url(\'images/updown.png\'); background-position: right bottom; background-repeat: no-repeat; background-origin: content-box; margin-bottom: 5px; margin-top: 5px;" id="IDMarker_' + _id + '_' + _len + '">';
        _html += '<input type="text" class="text9" readonly="readonly" value="' + _name + '" style="font-weight: bold; font-size: 11px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; cursor: pointer; width: 100%; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" /><br/>';
        _html += '<input type="text" class="text9" readonly="readonly" value="/" style="font-size: 11px; cursor: pointer; width: 21%; padding-left: 2px; text-align: left; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" />';
        _html += '<input type="text" class="text9" readonly="readonly" value="/" style="font-size: 11px; cursor: pointer; width: 54%; text-align: left; padding-left: 5px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" />';
        _html += '<button style="display: inline-block; float:right; width:29px; margin-top: -4px; position: absolute; right: 52px;" id="MLBtnDel_' + _id + '_' + _len + '" value="Delete" onclick="BtnDeleteMarkerFromList(\'IDMarker_' + _id + '_' + _len + '\',\'' + (tmpMarkersRoute.length - 1) + '\')">&nbsp;</button>';
        _html += '</div>';
     
        $('#MarkersIN').append(_html);
        $('#IDMarker_Total').css({ display: 'block' });
        $('#report-content').css({ height: (parseInt($('#report-content').css('height'), 10) + 30) + 'px' });
        $('#MLBtnDel_' + _id + '_' + _len).button({ icons: { primary: "ui-icon-trash"} });
        unchange();
    }    	
	//setTimeout(function(){ zoomMapRoute(Maps[0], 16); }, 1000);
	
	setTimeout(function(){ zoomWorldScreen(Maps[0], Maps[0].zoom); }, 3000);
	//zoomWorldScreen(Maps[0], 15)
	
	if(callback) callback(1);
	var ret = 1;
	return ret;
}
function putInRoute(_id, _lon, _lat, _name, _yesno, _idRoute, _type) {
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
    var backCol = "";    
    if (_len < 1)
        CreateMarker_Route(_lon, _lat, '00CC33', '', 1, _name, _len, _id, _idRoute);
    else
        CreateMarker_Route(_lon, _lat, 'FF0000', '', 3, _name, _len, _id, _idRoute);
    if(_type != undefined)
    {
    	if(_type == "2")
    		PleaseDrawAreaAgain(_id, '#00CC33');
		else
			if(_type == "3")
	    		PleaseDrawAreaAgainPoly(_id, '#00CC33');
	}
    if($('#MarkersIN')[0] != undefined) {
	        if (Browser() != 'iPad')
	        	var _html = '<div class="text8 corner5" onmousemove="ShowPopup(event, \'' + dic("Name", lang) + ': ' + _name + '\')" onmouseout="HidePopup();" ondblclick="setCenterMap(' + _lon + ', ' + _lat + ', 17,0)" style="background-color:'+backCol+'; cursor: pointer; font-size:12; width:97%; padding:2px 2px 2px 7px; height:45px; background-image: url(\'images/updown.png\'); background-position: right center; background-repeat: no-repeat; background-origin: content-box; margin-bottom: 7px; margin-top: 7px;" id="IDMarker_' + _id + '_' + _len + '">';
	    	else
	    		var _html = '<div class="text8 corner5" onclick="setCenterMap(' + _lon + ', ' + _lat + ', 17,0)" style="background-color:'+backCol+'; cursor: pointer; font-size:12; width:97%; padding:2px 2px 2px 7px; height:26px; background-image: url(\'images/updown.png\'); background-position: right bottom; background-repeat: no-repeat; background-origin: content-box; margin-bottom: 5px; margin-top: 5px;" id="IDMarker_' + _id + '_' + _len + '">';
	        _html += '<input type="text" class="text9" readonly="readonly" value="' + _name + '" style="font-weight: bold; font-size: 11px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; cursor: pointer; width: 100%; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" /><br/>';
	        _html += '<input type="text" class="text9" readonly="readonly" value="/" style="font-size: 11px; cursor: pointer; width: 21%; padding-left: 2px; text-align: left; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" />';
	        _html += '<input type="text" class="text9" readonly="readonly" value="/" style="font-size: 11px; cursor: pointer; width: 54%; text-align: left; padding-left: 5px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" />';
	        _html += '<button style="display: inline-block; float:right; width:29px; margin-top: -4px; position: absolute; right: 52px;" id="MLBtnDel_' + _id + '_' + _len + '" value="Delete" onclick="BtnDeleteMarkerFromList(\'IDMarker_' + _id + '_' + _len + '\',\'' + (tmpMarkersRoute.length - 1) + '\')">&nbsp;</button>';
	        _html += '</div>';
	     
	        $('#MarkersIN').append(_html);

	        $('#IDMarker_Total').css({ display: 'block' });
	        $('#report-content').css({ height: (parseInt($('#report-content').css('height'), 10) + 30) + 'px' });
	        $('#MLBtnDel_' + _id + '_' + _len).button({ icons: { primary: "ui-icon-trash"} });
	        unchange();
	    }    	
    //}
    
    if ($('#MarkersIN')[0] != undefined) {
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
    ClearGraphicRedraw();
    //PointsOfRoute = [];
    //for (var j = 0; j < tmpMarkersRoute.length; j++)
        //Markers[0].removeMarker(tmpMarkersRoute[j]);
    //tmpMarkersRoute = [];
    //PointsOfRoute = [];
    for (var i = 1; i < PointsOfRoute.length; i++) {
    	//putInRoute(PointsOfRoute[i].id, PointsOfRoute[i].lon, PointsOfRoute[i].lat, PointsOfRoute[i].name, 0);
    	var backCol = "";
        if (i == 1) {
    		backCol = "#BCEBA0";
    	} else {
    		if (i == (PointsOfRoute.length-1)) {
    			backCol = "#FAC3C3";
    		} else {
    			backCol = "#ffffff"
    		}
    	}
        putInRouteKiki(PointsOfRoute[i].id, PointsOfRoute[i].lon, PointsOfRoute[i].lat, PointsOfRoute[i].name, 0, 0, 0, backCol, 0, '');
    }
    /*if(_file == 1)
        var file = "getLinePoints";
    else
        var file = "getLinePointsF";
    for(var i = 1; i < PointsOfRoute.length - 1; i++)
        DrawLine_RouteNew(PointsOfRoute[i].lon, PointsOfRoute[i].lat, PointsOfRoute[i + 1].lon, PointsOfRoute[i + 1].lat, i, "<strong>" + dic("From", lang) + ": (" + i + ")</strong> " + PointsOfRoute[i].name + "<br /><strong>" + dic("To", lang) + ": (" + (i + 1) + ")</strong> " + PointsOfRoute[i + 1].name, file, i);*/
	top.HideWait();
}
function ReDrawRoute1(_file) {
	/*if ($("#opt").is(':checked') == true) {
    	if ($("#Label1").hasClass("ui-state-active") == true) {
    		alert("opt; normal");
    	} else {
    		alert("opt; fast");
    	}
    } else {	
    	if ($("#Label1").hasClass("ui-state-active") == true) {
    		alert("not opt; normal")
    	} else {
    		alert("not opt; fast")
    	}
    }*/
    ClearGraphicRedraw();
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
        url: twopoint + "/main/LoadRoute.php?id=" + _id + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
            //var _dat = JXG.decompress(data);
            var _dat = data;
            _dat = _dat.replace(/\r/g,'').replace(/\n/g,'');
            if(_dat != "notok")
            {
	            PointsOfRoute = [];
	            var backCol = "";
	            for (var i = 1; i < _dat.split("#@")[0].split("#").length; i++) {
	            	if (i == 1) {
	            		backCol = "#BCEBA0";
	            	} else {
	            		if (i == (_dat.split("#@")[0].split("#").length-1)) {
	            			backCol = "#FAC3C3";
	            		} else {
	            			backCol = "#ffffff"
	            		}
	            	}
	            	var tmpPoiRet = _dat.split("#@")[0].split("#")[i].split("|")[5];
	            	if (tmpPoiRet == 0) tmpPoiRet = "/";     
	                //putInRoute(_dat.split("#@")[0].split("#")[i].split("|")[2], _dat.split("#@")[0].split("#")[i].split("|")[0], _dat.split("#@")[0].split("#")[i].split("|")[1], _dat.split("#@")[0].split("#")[i].split("|")[3], 1, _id, _dat.split("#@")[0].split("#")[i].split("|")[4]);
	                putInRouteKiki(_dat.split("#@")[0].split("#")[i].split("|")[2], _dat.split("#@")[0].split("#")[i].split("|")[0], _dat.split("#@")[0].split("#")[i].split("|")[1], _dat.split("#@")[0].split("#")[i].split("|")[3], 1, _id, _dat.split("#@")[0].split("#")[i].split("|")[4], backCol, 0, tmpPoiRet);
	            }
	            zoomWorldScreen(Maps[0], 16);
            } else
            HideWait();
            if(_dat.split("#@")[0].split("#").length == 2)
            	HideWait();
            if ($('#MarkersIN')[0] != undefined) {	
            if ($('#MarkersIN')[0].children.length > 0) {
			   	haveStartPoi = true;  	
			   	if ($('#MarkersIN')[0].children.length > 1) {
			   		haveEndPoi = true;  
			   	}		
		    }	
		    }
        }
    });
}
function LoadRoutePre(_id) {
    ShowWait();
    ClearRouteScreen();
    $.ajax({
        url: twopoint + "/main/LoadRoutePre.php?id=" + _id + "&tpoint=" + twopoint,
        context: document.body,
        success: function (data) {
            var _dat = data;
            _dat = _dat.replace(/\r/g,'').replace(/\n/g,'');
            if(_dat != "notok")
            {
	            PointsOfRoute = [];
	            var backCol = "";
	            for (var i = 1; i < _dat.split("#@")[0].split("#").length; i++) {
	            	if (i == 1) {
	            		backCol = "#BCEBA0";
	            	} else {
	            		if (i == (_dat.split("#@")[0].split("#").length-1)) {
	            			backCol = "#FAC3C3";
	            		} else {
	            			backCol = "#ffffff"
	            		}
	            	}	
	            	var tmpPoiRet = _dat.split("#@")[0].split("#")[i].split("|")[5];
	            	if (tmpPoiRet == 0) tmpPoiRet = "/";            	
	            	//putInRoute(_dat.split("#@")[0].split("#")[i].split("|")[2], _dat.split("#@")[0].split("#")[i].split("|")[0], _dat.split("#@")[0].split("#")[i].split("|")[1], _dat.split("#@")[0].split("#")[i].split("|")[3], 1, _id, _dat.split("#@")[0].split("#")[i].split("|")[4]);
	                putInRouteKiki(_dat.split("#@")[0].split("#")[i].split("|")[2], _dat.split("#@")[0].split("#")[i].split("|")[0], _dat.split("#@")[0].split("#")[i].split("|")[1], _dat.split("#@")[0].split("#")[i].split("|")[3], 1, _id, _dat.split("#@")[0].split("#")[i].split("|")[4], backCol, 0, tmpPoiRet);
	            }
	            zoomWorldScreen(Maps[0], 16);
            } else
            HideWait();
            if(_dat.split("#@")[0].split("#").length == 2)
            	HideWait();
            if ($('#MarkersIN')[0] != undefined) {	
            if ($('#MarkersIN')[0].children.length > 0) {
			   	haveStartPoi = true;  	
			   	if ($('#MarkersIN')[0].children.length > 1) {
			   		haveEndPoi = true;  
				   	}		
			   	}		
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


/*function searchVehicle (term){
    var suche = term.value.toLowerCase();
    for (var k=0; k < $('#menu-container-2')[0].children.length; k++) {
		ele = $('#menu-container-2')[0].children[k].children[1].children[1].innerHTML.replace(/<[^>]+>/g,"");
		if (ele.toLowerCase().indexOf(suche)>=0 )
		    $('#menu-container-2')[0].children[k].style.display = '';
		else 
			$('#menu-container-2')[0].children[k].style.display = 'none';
	}
}
function searchByDriver (term){
    var suche = term.value.toLowerCase();
    for (var k=0; k < $('#menu-container-2')[0].children.length; k++) {
		ele = $('#menu-container-2')[0].children[k].children[4].children[0].innerHTML.replace(/<[^>]+>/g,"");
		if (ele.toLowerCase().indexOf(suche)>=0 )
		    $('#menu-container-2')[0].children[k].style.display = '';
		else 
			$('#menu-container-2')[0].children[k].style.display = 'none';
	}
}*/
function searchVehicle(term)
{
	var suche = transliterate(term.value).toLowerCase();
    var s=0;
    var cont=0;
    var dolzina=0;
    var niza=[];
    var ima=[];
    var zoni=[];
    var alarmi=[];
    var detailk=[];
    var br=0;
	var mySplitResult = suche.split(" ");
	//zbor po zbor 
	if(mySplitResult[mySplitResult.length-1] == "")
		mySplitResult = mySplitResult.splice(0, mySplitResult.length-1);
	if(mySplitResult.length == 0)
		mySplitResult[0] = "";
	while(s < mySplitResult.length){
	  for(cont=1;cont<7;cont++){
	  	if(document.getElementById('menu-container-'+cont) != null)
	 	{
			var dolzina=$('#menu-container-'+cont)[0].children[0].children.length;
			for(var m=0;m<dolzina;m++){
			 if(cont==1 || cont==6)
			 {
			   ele= $('#menu-container-'+cont)[0].children[0].children[m].innerHTML.replace(/<[^>]+>/g,"")
			   if (transliterate(ele).toLowerCase().indexOf(mySplitResult[s])>=0)
				{
					ima.push(m);
				}
			 } //Kraj na Angazirani i Brz Pregled
			 ///Meni za ZOni	
				if(cont==4){
					ele2=$('#menu-container-'+cont)[0].children[0].children[m].children[2].innerHTML.replace(/<[^>]+>/g,"")	
					ele= $('#menu-container-'+cont)[0].children[0].children[m].children[1].innerHTML.replace(/<[^>]+>/g,"")
					if (transliterate(ele).toLowerCase().indexOf(mySplitResult[s])>=0 ||transliterate(ele2).toLowerCase().indexOf(mySplitResult[s])>=0 )
					{
						zoni.push(m);
				   	}
				} //kraj na if cont==4
				//za Alarmi	
			if(cont==3)
			{
				 //var dol= $('#menu-container-'+cont)[0].children[0].children.length;
		    	//for(var i=0;i<dol;i++)
		    	//{
		    		eleAREG= $('#menu-container-'+cont)[0].children[0].children[m].children[0].children[1].innerHTML.replace(/<[^>]+>/g,"");
					eleAData=$('#menu-container-'+cont)[0].children[0].children[m].children[1].innerHTML.replace(/<[^>]+>/g,"");
					eleAAlarm=$('#menu-container-'+cont)[0].children[0].children[m].children[2].children[0].innerHTML.replace(/<[^>]+>/g,"");
					if (transliterate(eleAREG).toLowerCase().indexOf(mySplitResult[s])>=0 || transliterate(eleAData).toLowerCase().indexOf(mySplitResult[s])>=0 ||transliterate(eleAAlarm).toLowerCase().indexOf(mySplitResult[s])>=0)
					{
						alarmi.push(m)
				   	}
				//}
			}//kraj na if cont==3
			//kraj za ALArmi
			
			}//kraj for za m
			
			//****** vtoro meni za detali na vozilo +
				if(cont==2 ){
					for (var k=0; k < $('#menu-container-'+cont)[0].children.length; k++) {
						 var dol= $('#menu-container-'+cont)[0].children[k].children.length;
				    	for(var i=1;i<dol;i++)
				    	{
				    		//za vtorototo meni DETALI ZA VOZILA
				    		if(i==1)
				    		{
				    			ele = $('#menu-container-'+cont)[0].children[k].children[i].children[0].innerHTML.replace(/<[^>]+>/g,"");
								ele2 = $('#menu-container-'+cont)[0].children[k].children[i].children[1].innerHTML.replace(/<[^>]+>/g,"");
								if (transliterate(ele).toLowerCase().indexOf(mySplitResult[s])>=0 || transliterate(ele2).toLowerCase().indexOf(mySplitResult[s])>=0)
								{
									detailk.push(k);
							   	}
				    		}
				    		if(i>3){
				    		//debugger;
								ele = $('#menu-container-'+cont)[0].children[k].children[i].children[0].innerHTML.replace(/<[^>]+>/g,"");
								// /alert(transliterate(ele).toLowerCase().indexOf(mySplitResult[s]))
								if (transliterate(ele).toLowerCase().indexOf(mySplitResult[s])>=0)
								{
									detailk.push(k);
							   	}
							}else
							{
								ele = $('#menu-container-'+cont)[0].children[k].children[i].innerHTML.replace(/<[^>]+>/g,"");
								if (transliterate(ele).toLowerCase().indexOf(mySplitResult[s])>=0)
								{
									//$('#menu-container-'+cont)[0].children[k].style.display = '';
									//baremednas++;
									detailk.push(k);
							   	}
							} 
						}//kraj na for i
					}// kraj na for na k
			}//kraj if cont==2	
		}
	 }
	s++;
	}//kraj while
	//alert(ima)
	// /alert("detali"+detailk)
	
for(cont=1;cont<7;cont++){
	if(document.getElementById('menu-container-'+cont) != null)
	{
		if(suche==''){
			$('#menu-'+cont)[0].style.display = '';
		}
		else
		{
			$('#menu-'+cont)[0].style.display = '';
		}
		
			//za brz pregled
		if(cont==1){
			if(ima.length==0)
			{
				if(suche==''){
						$('#menu-'+cont)[0].style.display = '';
					}
					else{
						$('#menu-'+cont)[0].style.display = 'none';
					}
			}
			else{			
			//$('#menu-'+cont)[0].style.display = '';
			var dolzina=$('#menu-container-'+cont)[0].children[0].children.length;
			for(var m=0;m<dolzina;m++){
				for(var i=0;i<ima.length;i++)
				{
		           if(m==ima[i])
					{
						$('#menu-container-'+cont)[0].children[0].children[ima[i]].style.display = 'block';
			           	br=0;
					}
					if(m!=ima[i])
				    {
				         br++;
				         if(br==ima.length)
				         {
			        		$('#menu-container-'+cont)[0].children[0].children[m].style.display = 'none';
							br=0;				         		
				         }
				     }	
				}
			}// KRAJ ANGAZIRANI i brz Pregled
			}
		}//kraj na if cont1 ili cont=6
			if(cont==6)
			{
				if(ima.length==0)
				{
					if(suche==''){
						$('#menu-'+cont)[0].style.display = '';
					}
					else{
						$('#menu-'+cont)[0].style.display = 'none';
					}
				}
			else{		
			//var dolzina=$('#menu-container-'+cont)[0].children[0].children.length;
			for(var m=0;m<dolzina;m++){
				for(var i=0;i<ima.length;i++)
				{
		           if(m==ima[i])
						{
							$('#menu-container-'+cont)[0].children[0].children[ima[i]].style.display = 'block';
			           		br=0;
						}
						 if(m!=ima[i])
				         {
				         	br++;
				         	if(br==ima.length)
				         	{
			        			$('#menu-container-'+cont)[0].children[0].children[m].style.display = 'none';
								br=0;				         		
				         	}
				     	 }	
				}
			 }	
			}// KRAJ ANGAZIRANI i brz Pregled
		}//kraj ii cont==6
		//zoni
			if(cont==4)
			{
				if(zoni.length==0)
				{
					if(suche==''){
						$('#menu-'+cont)[0].style.display = '';
					}
					else{
						$('#menu-'+cont)[0].style.display = 'none';
					}
				}
				else{
				var dolzina=$('#menu-container-'+cont)[0].children[0].children.length;
				for(var m=0;m<dolzina;m++){
					for(var i=0;i<zoni.length;i++)
					{
						if(m==zoni[i])
						{
			           		$('#menu-container-'+cont)[0].children[0].children[zoni[i]].style.display = '';
							br=0;
						}
						 if(m!=zoni[i])
				         {
				         	br++;
				         	if(br==zoni.length){
			           			$('#menu-container-'+cont)[0].children[0].children[m].style.display = 'none';
			           			br=0;
			           		}
				     	 }
					}
				}
			}
			
		}//kraj if cont==4 kraj zoni
		//Alarmi
		if(cont==3){
			if(alarmi.length==0)
			{
				if(suche==''){
				$('#menu-'+cont)[0].style.display = '';
				}
				else{
					$('#menu-'+cont)[0].style.display = 'none';
				}
			}	
			else
			{
			var dolzina= $('#menu-container-'+cont)[0].children[0].children.length;
		    	for(var m=0;m<dolzina;m++)
		    	{
		    		for(var i=0;i<alarmi.length;i++)
					{
						if(m==alarmi[i])
						{
							$('#menu-container-'+cont)[0].children[0].children[alarmi[i]].style.display = '';
							br=0;
						}
						 if(m!=alarmi[i])
				         {
				         	br++;
				         	if(br==alarmi.length){
								$('#menu-container-'+cont)[0].children[0].children[m].style.display = 'none';
								br=0;
							}
				     	 }
					}
		    	}
		    }
		}//kraj if cont==3 Alarmi
		//za NEAKTIVNI
			if(cont==5)
			{
				if(suche=='')
				 	 $('#menu-'+cont)[0].style.display = '';
				  else
				  	$('#menu-'+cont)[0].style.display = 'none';
			}//kraj NEAKTIVNI
		//DEtalen pregled	
		if(cont==2){
			if(detailk.length==0){
				if(suche==''){
						$('#menu-'+cont)[0].style.display = '';
					}
					else{
						$('#menu-'+cont)[0].style.display = 'none';
					}
			}
			else
			{
				for (var k=0; k < $('#menu-container-'+cont)[0].children.length; k++) {
					for(i=0;i<detailk.length;i++)
					{
						if(k==detailk[i])
						{
			           			$('#menu-container-'+cont)[0].children[detailk[i]].style.display = '';
			           			br=0;
						}
						 if(k!=detailk[i])
				         {
				         	br++;
				         	if(br==detailk.length)
				         	{
				         		$('#menu-container-'+cont)[0].children[k].style.display = 'none';
								br=0;				         		
				         	}
				     	 }	
					}
				}	
			}
		}//Kraj detalen pregled
					
		}//kraj za if posle for 
	}//kraj na for za CONT
}

function OptionsChangeVehicle() {

	var odberi = document.getElementById('vozila').selectedIndex;
	
    if (odberi == "1")
    {
        document.getElementById('ednoVozilo').style.display = '';
    }
    if (odberi == "2")
    {
        document.getElementById('OrganizacionaEdinica').style.display = '';
    }
    if(odberi != "1")
    {
        document.getElementById('ednoVozilo').style.display = 'none';
  	}
  	if(odberi != "2")
    {
        document.getElementById('OrganizacionaEdinica').style.display = 'none';
	}	
}
function pencilnew(_code){
	$('#img-pencil-'+ _code).css({display: 'block'});
}
function pencilnewout(_code){
	$('#img-pencil-'+ _code).css({display: 'none'});
}
function fncAddOdometer(_id, _code){
	$('#txtOdometer').val('');
	$('#addodometer').dialog({ modal: true, width: 370, height: 200, resizable: false, zIndex: 9998,
		buttons: 
    	[{
        	text:dic("Insert"),
		    click: function() {
                promeniOdometar(_id, _code);
              	$(this).dialog("close");
            }
		}]
	});
}
function promeniOdometar(id, code){
	var odometarVrednost = $('#txtOdometer').val().replace(/\,/g,'').replace(/\./g,'');
	
	if(odometarVrednost=="")
	{
		msgbox("Мора да внесете километри за одометарот.")
	}
	else
	{
		ShowWait();
		$.ajax({
		    url: "UpdateOdometar.php?id="+ id+"&odometarVrednost="+odometarVrednost,
		    context: document.body,
		    success: function(data){
		    	data = data.replace(/\r/g,'').replace(/\n/g,'');
		    	var mmetric = ' Km';
				if(metric == 'mi')
					mmetric = ' miles';
			    if(data == 1)
			    {
			    	$('#div-ask-confirmation').dialog({ modal: true, width: 370, height: 190, resizable: false,
		        	buttons: 
		        	[{
	                	text:dic("Settings.Yes"),
					    click: function() {
	                            $.ajax({
						        url: "UpdateOdometar2.php?id="+ id+"&odometarVrednost="+odometarVrednost,
						        context: document.body,
						        success: function(data){
						        	msgbox(dic("Settings.SuccChanged",lang))
						        	var currkm = commaSeparateNumber(odometarVrednost) + mmetric;
									$('#vh-odometar-' + code).html(currkm);
					    		}
				       	       });	
	                          $( this ).dialog( "close" );
	                        }
					},
				    {
					    text:dic("Settings.No",lang),
	                    click: function() {
						    $( this ).dialog( "close" );
					    }
					}]
	           		});
		    	} else
		    	{
				    if(data == 0)
				    {
				    	$.ajax({
				        url: "UpdateOdometar2.php?id="+ id+"&odometarVrednost="+odometarVrednost,
				        context: document.body,
				        success: function(data){
				        	msgbox(dic("Settings.SuccChanged",lang))
				        	var currkm = commaSeparateNumber(odometarVrednost) + mmetric;
							$('#vh-odometar-' + code).html(currkm);
						}
				       });
				    } else
				    {
				    	//$('#vh-odometar-'+id).val(odometarVrednost + ' Km');
				    	var currkm = commaSeparateNumber(odometarVrednost) + mmetric;
						$('#vh-odometar-' + code).html(currkm);
				    }
			    }
		    	HideWait();
		    }
		});	
	}
}
function formatdt1(dt)
{
	dt = dt.split(" ")[1].split(".")[0] + " " + dt.split(" ")[0].split("-")[2] + "-" + dt.split(" ")[0].split("-")[1] + "-" + dt.split(" ")[0].split("-")[0];
	return dt;
	
}
