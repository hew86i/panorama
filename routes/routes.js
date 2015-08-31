// JavaScript Document

var myScrollMenu;
var myScrollContainer;
var PrevHash = ''
var cLang = ''
var guidC=''
var guidU = ''
var today =''
var yesterday=''
var lastWeek=''
var lastMonth=''
var last10 = ''
var currentWeek = ''
var currentMonth = ''
var lastWeek1 = ''
var endOfPrevWeek = ''
var startLastMonth = ''
var endLastMonth = ''
var tttt
var testT = 0;
var lang1 = 'en'
var user_id = ''

function ShowHideLeftMenu(){
	$('#')	
}

function AjaxRoute() {
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
			var tourch = str;
			str = str.split("@%@^")[1];
			tourch = tourch.split("#");
			var arrRow = new Array();
			//debugger;
			$('.clearRow').html('');
			
			for (var j = 1; j < tourch.length; j++) {
				arrRow = tourch[j].split("|");
				//strAR = dic("Tracking.ONumber",lang)+": <span style='color:#000'>" + arrRow[4] + "</span>&nbsp;&nbsp;&nbsp;"+ dic("Tracking.Arrival",lang) + ": <span style='color:#040'>" + arrRow[1] + "</span>&nbsp;&nbsp;&nbsp;" +dic("Tracking.Departure",lang) + ": <span style='color:#800'>" + arrRow[2] + "</span>&nbsp;&nbsp;&nbsp;" + dic("Tracking.Idling",lang) +": <span style='color:#800'>" + arrRow[3] + "</span>";
				//debugger
				if(arrRow[7] != "")
					if(arrRow[7].split(" ")[1].indexOf(".") == -1)
						arrRow[7] = arrRow[7] + ".001";
				if(parseInt($('#'+arrRow[0]).parent().children()[0].value, 10) != parseInt(arrRow[4], 10) && arrRow[2] != "/")
				{
					//if($('#'+arrRow[0])[0].children[0].className != "notifyOutOfOrder")
						//AlertEvent(arrRow[7], arrRow[6].split(" - ")[1], 'unOrdered', arrRow[5]);
					var alarmorder = "<input readonly class='notifyOutOfOrder' ";
				} else
					var alarmorder = "<input readonly class='notifyInOrder' ";
				if(document.getElementById("vnz_"+arrRow[0].split("_")[0]) != null)
				{
					if(parseInt(arrRow[3].split(":")[2], 10)+parseInt(arrRow[3].split(":")[1], 10)*60+parseInt(arrRow[3].split(":")[0], 10)*3600 > parseInt(document.getElementById("vnz_"+arrRow[0].split("_")[0]).innerHTML, 10)*60)
					{
						//if($('#'+arrRow[0])[0].children[3].className != "notifyOutOfOrder")
							//AlertEvent(arrRow[7], arrRow[6].split(" - ")[1], 'stayMoreThanAllow', arrRow[5]);
						var alarmstay = "<input readonly class='notifyOutOfOrder' ";
					} else
						var alarmstay = "<input readonly class='notifyInOrder' ";
				} else
					var alarmstay = "<input readonly class='notifyInOrder' ";
				strAR = dic("Tracking.ONumber",lang)+": " + alarmorder + " value='" + arrRow[4] + "' />&nbsp;&nbsp;&nbsp;"+ dic("Tracking.Arrival",lang) + ": <span style='color:#040'>" + arrRow[1] + "</span>&nbsp;&nbsp;&nbsp;" +dic("Tracking.Departure",lang) + ": <span style='color:#800'>" + arrRow[2] + "</span>&nbsp;&nbsp;&nbsp;" + dic("Tracking.Idling",lang) +": " + alarmstay + " style='width: 50px' value='" + arrRow[3] + "' /></span>";
				//$('#'+arrRow[0]).html(strAR);
				$('#'+arrRow[0]).html(strAR);
			}

	        setTimeout("AjaxRoute();", 5000);
	    }
	}
	xmlHttp.open("GET", _page, true);
	xmlHttp.send(null);
}
function AjaxRouteNew() {
	var _page = 'getCurrentNew.php?dateS=' + txtSDate.value.split("-")[2]+"-"+txtSDate.value.split("-")[1]+"-"+txtSDate.value.split("-")[0] + '&dateE=' + txtEDate.value.split("-")[2]+"-"+txtEDate.value.split("-")[1]+"-"+txtEDate.value.split("-")[0] + '&tourid=' + txttourid.value;
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
			var tourch = str;
			str = str.split("@%@^")[1];
			tourch = tourch.split("#");
			var arrRow = new Array();
			$('.clearRow').html('');
			for (var j = 1; j < tourch.length; j++) {
				arrRow = tourch[j].split("|");
				//strAR = dic("Tracking.ONumber",lang)+": <span style='color:#000'>" + arrRow[4] + "</span>&nbsp;&nbsp;&nbsp;"+ dic("Tracking.Arrival",lang) + ": <span style='color:#040'>" + arrRow[1] + "</span>&nbsp;&nbsp;&nbsp;" +dic("Tracking.Departure",lang) + ": <span style='color:#800'>" + arrRow[2] + "</span>&nbsp;&nbsp;&nbsp;" + dic("Tracking.Idling",lang) +": <span style='color:#800'>" + arrRow[3] + "</span>";
				if(arrRow[7] != "")
					if(arrRow[7].split(" ")[1].indexOf(".") == -1)
						arrRow[7] = arrRow[7] + ".001";
				if(parseInt($('#'+arrRow[0]).parent().children()[0].value, 10) != parseInt(arrRow[4], 10) && arrRow[2] != "/")
				{
					//if($('#'+arrRow[0])[0].children[0].className != "notifyOutOfOrder")
						//AlertEvent(arrRow[7], arrRow[6].split(" - ")[1], 'unOrdered', arrRow[5]);
					var alarmorder = "<input readonly class='notifyOutOfOrder' ";
				} else
					var alarmorder = "<input readonly class='notifyInOrder' ";
				if(document.getElementById("vnz_"+arrRow[0].split("_")[0]) != null)
				{
					if(parseInt(arrRow[3].split(":")[2], 10)+parseInt(arrRow[3].split(":")[1], 10)*60+parseInt(arrRow[3].split(":")[0], 10)*3600 > parseInt(document.getElementById("vnz_"+arrRow[0].split("_")[0]).innerHTML, 10)*60)
					{
						//if($('#'+arrRow[0])[0].children[3].className != "notifyOutOfOrder")
							//AlertEvent(arrRow[7], arrRow[6].split(" - ")[1], 'stayMoreThanAllow', arrRow[5]);
						var alarmstay = "<input readonly class='notifyOutOfOrder' ";
					} else
						var alarmstay = "<input readonly class='notifyInOrder' ";
				} else
					var alarmstay = "<input readonly class='notifyInOrder' ";
				strAR = dic("Tracking.ONumber",lang)+": " + alarmorder + " value='" + arrRow[4] + "' />&nbsp;&nbsp;&nbsp;"+ dic("Tracking.Arrival",lang) + ": <span style='color:#040'>" + arrRow[1] + "</span>&nbsp;&nbsp;&nbsp;" +dic("Tracking.Departure",lang) + ": <span style='color:#800'>" + arrRow[2] + "</span>&nbsp;&nbsp;&nbsp;" + dic("Tracking.Idling",lang) +": " + alarmstay + " style='width: 50px' value='" + arrRow[3] + "' /></span>";
				//$('#'+arrRow[0]).html(strAR);
				$('#'+arrRow[0]).html(strAR);
			}
	    }
	}
	xmlHttp.open("GET", _page, true);
	xmlHttp.send(null);
}
function msgboxRoute123(msg, _id) {
    $("#DivInfoForAll").css({ display: 'none' });
    $('#div-msgbox').html(msg)
    $("#dialog:ui-dialog").dialog("destroy");
    $("#dialog-message").dialog({
    	width: 400,
        modal: true,
        zIndex: 9999, resizable: false,
        buttons: 
        [
            {
                text: dic("yes", lang),
            	click : function () {
	            	document.location.href = _id;
	                $(this).dialog("close");
	                changeItem = false;
	            }
            },
			{
			    text: dic("No", lang),
        		click: function () {
            		$(this).dialog("close");
        		}
            }
        ]
    });	
    HideWait();
}

function SetHeight(){
	var _h = document.body.clientHeight
	var _l = (document.body.clientWidth-100)/2
	$('#report-content').css({height:(_h-60)+'px'})
	$('#ifrm-cont').css({height:(_h-60)+'px'})
	$('#div-menu').css({height:(_h-32)+'px'})
	$('#div-loading').css({left:(_l)+'px'})

	
}


function SetHeightRec(){
	var _h = document.body.clientHeight
	$('#speed-graph').css({top:(_h-100)+'px'})

	
}
function SetHeightLite(){
	
	var ifrm =top.document.getElementById('ifrm-cont') 
	var _h = 0
	if (ifrm!=null){
		_h = ifrm.offsetHeight
	} else {
		_h = document.body.clientHeight
	}
	var _w = document.body.clientWidth
	top.$('#ifrm-cont').css({ overflow: 'hidden' });
	$('#report-content').css({height:(_h)+'px'})
}
function SetHeightLite111(){
	
	var ifrm =top.document.getElementById('ifrm-cont') 
	var _h = 0
	if (ifrm!=null){
		_h = ifrm.offsetHeight
	} else {
		_h = document.body.clientHeight
		var _h = document.body.offsetHeight;
	}
	var _w = document.body.clientWidth
	top.$('#ifrm-cont').css({ overflowX: 'hidden', overflowY: 'scroll' });
	//$('#report-content').css({height:(_h)+'px'})
    $('#div-map').css({ height: (_h - 100) + 'px' });
    $('#div-map-1').css({ height: (_h - 100) + 'px' });
}
function SetHeightLite112(){
	
	var ifrm =top.document.getElementById('ifrm-cont') 
	var _h = 0
	if (ifrm!=null){
		_h = ifrm.offsetHeight
	} else {
		_h = document.body.clientHeight
		var _h = document.body.offsetHeight;
	}
	var _w = document.body.clientWidth
	top.$('#ifrm-cont').css({ overflowX: 'hidden', overflowY: 'scroll' });
	
	
    $('#div-map').css({ height: (_h - 100) + 'px' });
    $('#div-map-1').css({ height: (_h - 100) + 'px' });
	
	$('#div-layer-NormalFast-0').css({ left: ($('#div-map-1')[0].offsetWidth - 140) + 'px' })
	$('#div-layer-icons-0').css({ width: ($('#div-map-1')[0].offsetWidth - 200) + 'px' })
	//$('#report-content').css({height:(document.body.offsetHeight - 20) + 'px'})
	//top.$('#ifrm-cont').css({height:(document.body.offsetHeight+38) + 'px'})
}

function iPadSettingsLite(){
	if (Browser()!='iPad') {
		//document.getElementById('div-menu').className = 'scrollY'
	} else {

		
		var RepCont = $('#report-content').html()
		$('#report-content').html('<div id="scroll-cont-div"></div>')
		$('#scroll-cont-div').html(RepCont)
			
		myScrollContainer = new iScroll('scroll-cont-div');
		iPad_Refresh();
	}	
}

function iPadSettings(){
	if (Browser()!='iPad') {
		document.getElementById('div-menu').className = 'scrollY'
	} else {
		var menuCont = $('#div-menu').html()
		$('#div-menu').html('<div id="scroll-menu-div"></div>')
		$('#scroll-menu-div').html(menuCont)
			
		myScrollMenu = new iScroll('scroll-menu-div');
		
		
		var RepCont = $('#report-content').html()
		$('#report-content').html('<div id="scroll-cont-div"></div>')
		$('#scroll-cont-div').html(RepCont)
			
		myScrollContainer = new iScroll('scroll-cont-div');
		iPad_Refresh();
	}	
}

function ShowHideLeftMenu(){
	var _w = document.getElementById('td-menu').offsetWidth
	if (_w>249){
		$('#race-img').css({backgroundPosition:'0px 0px'})
		$('#div-menu').css({display:'none'})
		$('#td-menu').css({width:'0px'})
		iPad_Refresh()
		return
	} else {
		$('#race-img').css({backgroundPosition:'-8px 0px'})
		$('#div-menu').css({display:'block'})
		$('#td-menu').css({width:'250px'})
		iPad_Refresh()
		return	
	}
}

function iPad_Refresh(){
	if (Browser()=='iPad') {
		setTimeout(function () {myScrollMenu.refresh(); myScrollContainer.refresh()}, 0);
	}
}

function OnMenuClick(id){
	var cls = document.getElementById('menu-'+id).className
	if (cls=='menu-container-collapsed') {
		//
		document.getElementById('menu-title-'+id).className='menu-title text3'
		var h=document.getElementById('menu-container-'+id).offsetHeight
		h = h+20+20
		$('#menu-'+id).animate({height:h+'px'},'fast', function(){document.getElementById('menu-'+id).className='menu-container'})
		return
	} else {
		document.getElementById('menu-'+id).className='menu-container-collapsed'
		document.getElementById('menu-title-'+id).className='menu-title-collapsed text3'
		$('#menu-'+id).animate({height:'33px'},'fast')
		return
	}
	iPad_Refresh()
}

function checkHash(_tf) {
    var ifEqual = 0
    var ifFirst = 1
    var h = location.hash
    if (h == null) { h = '' }
    if (PrevHash == null) { PrevHash = '' }
    h = h.replace('#rep/', '')
    PrevHash = PrevHash.replace('#rep/', '')
    if ((h != '') && (h != PrevHash)) {
        
        var objPrev = null
        var objCurr = null
        objPrev = document.getElementById(PrevHash)
        objCurr = document.getElementById(h)


        if (_tf == 'False') {
            //alert(11)
            if (objPrev != null) { objPrev.className = 'repoMenu1 corner5 text2' }
            if (objCurr != null) { objCurr.className = 'repoMenu1 corner5 text2' }
        }
        else {
            if (_tf == 'True') {
                //alert(12)
                if (objPrev != null) { objPrev.className = 'repoMenu corner5 text2' }
                if (objCurr != null) { objCurr.className = 'repoMenuSel corner5 text2' }
            }
            else {
                if (objPrev != null) {
                    if (objPrev.className != 'repoMenu1 corner5 text2')
                        if (objPrev != null) {
                            //alert(13);
                            ifFirst = 0;
                            var prev = ""
                            prev = document.getElementById(PrevHash).attributes[2].nodeValue.split("_")[1]
                            var curr = ""
                            curr = document.getElementById(h).attributes[2].nodeValue.split("_")[1]
                            if (prev == curr) {
                                ifEqual = 1
                            }

                            objPrev.className = 'repoMenu corner5 text2'
                        }
                }
                if (objCurr != null) {
                    if (objCurr.className != 'repoMenu1 corner5 text2')
                        if (objCurr != null) {
                            //alert(14);
                            objCurr.className = 'repoMenuSel corner5 text2'
                        }
                }
            }
        }
        PrevHash = h
    }
    if ((h == '') && (h == PrevHash)) {
        //alert(2)
        ifFirst = 1;
        PrevHash = 'menu_1_1';
        location.hash = '#rep/' + PrevHash
        var objCurr = null
        objCurr = document.getElementById(PrevHash)
        if (objCurr != null) {
            //alert(21);
            objCurr.className = 'repoMenuSel corner5 text2'
        }
    }

    LoadData(1, 1, ifEqual, ifFirst)
}

$(window).bind('hashchange', function (event) {
    //alert(1)
    if (event.target.location.pathname.indexOf("LoadMap.php") != -1)
        return false;
    checkHash()

    //LoadData()
});

function ShowLoading(){
	$('#div-loading').show('fast')
}

function HideLoading(){
	$('#div-loading').hide('fast')
}

function NalogSearch(_dtformat){
	if (_dtformat == undefined) _dtformat = 'd-m-Y';
	document.getElementById('frm-reports').src = 'temp.php';
	name = $('#txt_naslov').val();
	dtfrom = $('#txtSDate').val();
	dtfrom = formatdate13(dtfrom, _dtformat);//dtfrom = dtfrom.split("-")[2]+"-"+dtfrom.split("-")[1]+"-"+dtfrom.split("-")[0];
	dtto = $('#txtEDate').val();
	dtto = formatdate13(dtto, _dtformat);//dtto = dtto.split("-")[2]+"-"+dtto.split("-")[1]+"-"+dtto.split("-")[0];
	vozilo = $('#txt_vozilo').val();
	sofer = $('#txt_sofer1').val();
	alarm = $('#txt_alert').val();
	poiid = $('#combobox').val().split("|")[0];
	/*if(name == "" && vozilo == "0" && sofer == "0" && alarm == "0" && poiid == "")
	{
		alert("Немате внесено параметри за пребарување");
	} else
	{*/
		//alert('getReports.php?name=' + name + '&dtfrom=' + dtfrom + '&dtto=' + dtto + '&vozilo=' + vozilo + '&sofer=' + sofer + '&alarm=' + alarm + '&poiid=' + poiid)
		document.getElementById('frm-reports').src = 'getReports.php?name=' + name + '&dtfrom=' + dtfrom + '&dtto=' + dtto + '&vozilo=' + vozilo + '&sofer=' + sofer + '&alarm=' + alarm + '&poiid=' + poiid+'&l='+lang;
		$('#div-reports').dialog({ width: document.body.offsetWidth - 5, height: document.body.offsetHeight - 8 });
	//}
}

function setCalenders_() {
    
    $('#txtSDate').datetimepicker({
        dateFormat: 'dd-mm-yy',
        showOn: "button",
        buttonImage: "../images/cal1.png",
        buttonImageOnly: true,
        hourGrid: 4,
        minuteGrid: 10,
        onSelect: function () {
            setDateRangeCustom();
        }
    });

    $('#txtEDate').datetimepicker({
        dateFormat: 'dd-mm-yy',
        showOn: "button",
        buttonImage: "../images/cal1.png",
        buttonImageOnly: true,
        hourGrid: 4,
        minuteGrid: 10,
        onSelect: function () {
            setDateRangeCustom();
        }
    });

    $('#txtVehicles').change(function () { });
    $('#txtDateRange').change(function () { setDateRange() });
}
function setCalenders(){
	

}

function setDateRangeCustom(){
	document.getElementById('txtDateRange').selectedIndex = 7
}
function setDateRange() {
    
    var dr = $('#txtDateRange').val()

    
	if (dr+''=='0') {
	    $('#txtSDate').datepicker("setDate", yesterday + " 00:00")
	    $('#txtEDate').datepicker("setDate", yesterday + " 23:59")
		//LoadData()
    }

	if (dr + '' == '1') {
	    $('#txtSDate').datepicker("setDate", today + " 00:00")
	    $('#txtEDate').datepicker("setDate", today + " 23:59")
	    //LoadData()
	}

    if (dr + '' == '2') {
        $('#txtSDate').datepicker("setDate", currentWeek + " 00:00")
        $('#txtEDate').datepicker("setDate", today + " 23:59")
        //LoadData()
    }
	if (dr+''=='3') {
	    $('#txtSDate').datepicker("setDate", lastWeek1 + " 00:00")
	    $('#txtEDate').datepicker("setDate", endOfPrevWeek + " 23:59")
		//LoadData()
    }
    if (dr + '' == '4') {
        $('#txtSDate').datepicker("setDate", last10 + " 00:00")
        $('#txtEDate').datepicker("setDate", yesterday + " 23:59")
        //LoadData()
    }
    if (dr + '' == '5') {
        $('#txtSDate').datepicker("setDate", currentMonth + " 00:00")
        $('#txtEDate').datepicker("setDate", today + " 23:59")
        //LoadData()
    }
	if (dr+''=='6') {
	    $('#txtSDate').datepicker("setDate", startLastMonth + " 00:00")
	    $('#txtEDate').datepicker("setDate", endLastMonth + " 23:59")
		//LoadData()
	}
}

function LoadData(_i, _j, _equal, _first){

    ShowWait();

	var page = ''
	var report = ''
	if (PrevHash == 'menu_1_1') {page = 'NovNalogR.php?l=' + lang}
	if (PrevHash == 'menu_1_2') {page = 'PredefiniraniNalozi.php?l=' + lang}
	if (PrevHash == 'menu_2_1') {page = 'NaloziDenes.php?l=' + lang}
	if (PrevHash == 'menu_2_2') {page = 'NaloziUtre.php?l=' + lang}
	if (PrevHash == 'menu_2_3') {page = 'SiteNaloziNew.php?l=' + lang}
	if (PrevHash == 'menu_3_1') {page = 'Reports.php?l=' + lang}
	if (PrevHash == 'menu_3_2') {page = 'ActivityReport.php?l=' + lang}

	var _elID = '#report-content'
	if (Browser()=='iPad') {_elID='#scroll-cont-div'}
	if(document.getElementById('ifrm-cont') == null)
	{
		HideWait();
	} else
		document.getElementById('ifrm-cont').src = page //+ '?l=' + cLang + '&uid=' + guidU + '&cid=' + guidC + '&sd=' + sDate + '&ed=' + eDate + '&v=' + Vhc + '&vehNum=' + vehicleNum
}
function OpenMap(lat, lon, reg, dat, time, speed){
//	$( "#dialog-map" ).dialog({modal: true, height:400, width:500});
//	$("#dialog-map").gMap({ markers: [{ latitude: lat,
//                              longitude: lon}],
//                          zoom: 12
//                      });

    $('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; border:0px" src=""></iframe>');
    //alert('LoadMap.aspx?lon=' + lon + '&lat=' + lat);
    document.getElementById('iframemaps').src = 'LoadMap.aspx?lon=' + lon + '&lat=' + lat + '&reg=' + reg + '&dat=' + dat + '&time=' + time + '&speed=' + speed + '&l=' + cLang;
    $('#dialog-map').dialog({ modal: true, height: 650, width: 800
    });
       /*             
	$.ajax({
	    url: 'LoadMap.aspx?lon=' + lon + '&lat=' + lat,
	    context: document.body,
	    success: function (data) {
	    }
	});*/
                   
}

function loadtourbydate(_dtformat){
	if (_dtformat == undefined) _dtformat = 'd-m-Y';
	ShowWait();
	if($('#txttourid').val() == "")
		_num = "1";
	else
		_num = "0";
	if(_num == "1")
	{
		dateS = formatdate13(txtSDate.value, _dtformat);//txtSDate.value.split("-")[2]+"-"+txtSDate.value.split("-")[1]+"-"+txtSDate.value.split("-")[0];
		dateE = formatdate13(txtEDate.value, _dtformat);//txtEDate.value.split("-")[2]+"-"+txtEDate.value.split("-")[1]+"-"+txtEDate.value.split("-")[0];
		tid = "";
	} else
	{
		dateS = "";
		dateE = "";
		tid = txttourid.value;
	}
	//alert('SiteNaloziNew.php?date=' + date + '&tourid=' + tid + '&l=' + lang)
	var _elID = '#report-content'
	if (Browser()=='iPad') {_elID='#scroll-cont-div'}
	top.document.getElementById('ifrm-cont').src = 'SiteNaloziNew.php?dateS=' + dateS + '&dateE=' + dateE + '&tourid=' + tid + '&l=' + lang
	
}

function OpenMap1(uid, cid, sd, ed, vn, vh) {
    var h = document.body.clientHeight * 0.9
    var w = document.body.clientWidth * 0.9
    $('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; border:0px" src=""></iframe>');
    document.getElementById('iframemaps').src = 'reconstruction.aspx?l=' + cLang + '&uid=' + uid + '&cid=' + cid + '&sd=' + sd + '&ed=' + ed + '&v=' + vh + '&vehNum=' + vn;
    $('#dialog-map').dialog({ modal: true, height: h, width: w
    });
}
function Log(userID) {
    var startDT = $('#txtSDate').val()
    var endDT = $('#txtEDate').val()
    var vehicle = ($('#txtVehicles').val()).split("#")[0]

    var rep = ''
    if (PrevHash == 'menu_1_1') { rep = "Dashboard" }
    if (PrevHash == 'menu_1_2') { rep = "Fleet report" }
    if (PrevHash == 'menu_3_1') { rep = "Overview" }
    if (PrevHash == 'menu_3_2') { rep = "Short report" }
    if (PrevHash == 'menu_3_3') { rep = "Detail report" }
    if (PrevHash == 'menu_3_4') { rep = "Visited points of interest" }
    if (PrevHash == 'menu_3_5') { rep = "Reconstruction" }
    if (PrevHash == 'menu_3_6') { rep = "Taxi report" }
    if (PrevHash == 'menu_3_7') { rep = "GeoFence report" }
    if (PrevHash == 'menu_4_1') { rep = "Distance travelled" }
    if (PrevHash == 'menu_4_2') { rep = "Activity" }
    if (PrevHash == 'menu_4_3') { rep = "Max speed" }
    if (PrevHash == 'menu_4_4') { rep = "Speed limit excess" }

    var xmlHttp; var str = ''
    try { xmlHttp = new XMLHttpRequest(); } catch (e) {
        try
			        { xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); }
        catch (e) {
            try
                    { xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e)
                    { alert("Your browser does not support AJAX!"); return false; }
        }
    }

    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4) {
            str = xmlHttp.responseText
        }
    }
    xmlHttp.open("GET", './addLog.aspx?_user=' + userID + '&_startDT=' + startDT + '&_endDT=' + endDT + '&_vehicle=' + vehicle + '&_report=' + rep, true);
    xmlHttp.send(null);
    }

    function openComparison(l, vehResults, catResults) {

        $.ajax({
            url: 'ComparisonForm.aspx?l=' + l + '&vehList=' + vehResults,
            context: document.body,
            success: function (data) {
                $('#div-comparison').html(data)
                $('#div-comparison').dialog({ modal: true, height: 450, width: 760,

                    buttons:
                     [
                         {
                             text: dic("cancel", l),
                             click: function () {
                                 $(this).dialog("close");
                             }
                         },
                         {
                             text: dic("next", l),
                             click: function () {
                                 boxes = document.cbVehicles.cb.length;
                                 txt = ""
                                 for (i = 0; i < boxes; i++) {
                                     if (document.cbVehicles.cb[i].checked) {
                                         txt = txt + document.cbVehicles.cb[i].value + ";";
                                     }
                                 }

                                 if (txt == "") { vehResults = "/"; }
                                 else { vehResults = txt; }

                                 if (vehResults.split(";").length > 2) {
                                     $(this).dialog("close");

                                     var startDT_ = document.getElementById('txtSDate').value;
                                     var endDT_ = document.getElementById('txtEDate').value;

                                     var startDT = startDT_.split(" ")[0] + "@" + startDT_.split(" ")[1];
                                     var endDT = endDT_.split(" ")[0] + "@" + endDT_.split(" ")[1];

                                     openComparison1(l, vehResults, startDT, endDT, catResults);
                                 }
                                 else {
                                     mymsg(dic("twoVeh", l));
                                 }
                             }
                         }
                     ]
                });
            }
        });
    }

    function openComparison1(l, vehResults, sd, ed, catList) {
        $.ajax({
            url: 'ComparisonForm1.aspx?l=' + l + '&catList=' + catList,
            context: document.body,
            success: function (data) {
                $('#div-comparison1').html(data);
                $('#div-comparison1').dialog({ modal: true, height: 500, width: 420,

                    buttons:
                     [
                         {
                             text: dic("cancel", l),
                             click: function () {
                                 $(this).dialog("close");
                             }
                         },
                         {
                             text: dic("back", l),
                             click: function () {
                                 $(this).dialog("close");

                                 boxes = document.cbCategories.cb.length;
                                 txt = "";
                                 for (i = 0; i < boxes; i++) {
                                     if (document.cbCategories.cb[i].checked) {
                                         txt = txt + document.cbCategories.cb[i].value + ";";
                                     }
                                 }
                                 if (txt == "") { catResults = "/"; }
                                 else { catResults = txt; }

                                 openComparison(l, vehResults, catResults);

                             }
                         },
                         {
                             text: dic("show", l),
                             click: function () {
                                 boxes = document.cbCategories.cb.length;
                                 txt = "";
                                 for (i = 0; i < boxes; i++) {
                                     if (document.cbCategories.cb[i].checked) {
                                         txt = txt + document.cbCategories.cb[i].value + ";";
                                     }
                                 }

                                 if (txt == "") { catResults = "/"; }
                                 else { catResults = txt; }

                                 if (catResults.split(";").length > 1) {
                                     $(this).dialog("close");

                                     document.getElementById('ComResults').style.borderTop = "1px solid #BBBBBB";
                                     document.getElementById('comText').innerHTML = dic("newCom", l) + " <span class='linkText_' onclick=openComparison('" + l + "')>" + dic("here", l) + "</span>.";
                                     document.getElementById('ComResults').innerHTML = '<img src="../images/ajax-loader.gif" style="width:31; height:31" align="absmiddle">&nbsp;<span class="text1" style="color:#5C8CB9; font-weight:bold; font-size:11px">' + dic("ResLoading", l) + '</span>';

                                     $("#ComResults").load('ComparisonResults.aspx?vehicles=' + vehResults + '&categories=' + catResults + '&sd=' + sd + '&ed=' + ed + '&l=' + l);
                                 }
                                 else {
                                     mymsg(dic("oneCat", l));
                                 }
                             }
                         }
                     ]

                });
            }
        });
 }
 
 function closwin()
{
	$('#likeapopup').css({ visibility: 'hidden' });
	//$('#div-map').html('');
	$('#div-map').css({ display: 'none' });
	//document.getElementById('likeapopup111').style.visibility = 'hidden';
}
 
function AddScheduler(index, userID, l) {
    var l = document.location.href.split("?")[1].split("&")[0].split("=")[1];
  
    var path = document.location.href.split("/")[2];
    if (path == "gps.mk" || path == "localhost") {
        path = "gps"
    }
    else
        if (path == "app.panopticsoft.com") {
            path = "app"
        }
          $.ajax({
               url: 'Scheduler.aspx?index=' + index + '&lang=' + l,
               context: document.body,
               success: function (data) {
                   $('#div-add-schedule').html(data)
                  // document.getElementById('cbReports').selectedIndex = index
                   $('#div-add-schedule').dialog({ modal: true, height: 380, width: 430,
                       buttons: {
                           Add: function () {
                               var rep = ''
                               var report = $('#cbReports').val()
                              
                               if (report == "Dashboard") { rep = "overview" }
                               if (report == "FleetReport") { rep = "FleetReport" }
                               if (report == "SummTaxi") { rep = "SummTaxiReport" }
                               if (report == "Overview") { rep = "OverviewV" }
                               if (report == "ShortReport") { rep = "ShortReport" }
                               if (report == "DetailReport") { rep = "Detail" }
                               if (report == "VisitedPointsOfInterest") { rep = "VehiclePOI" }
                               if (report == "Reconstruction") { rep = "Reconstruction" }
                               if (report == "TaxiReport") { rep = "TaxiReport" }
                               if (report == "GeoFenceReport") { rep = "GeofenceReport" }
                               if (report == "IdlingReport") { rep = "IdlingReport" }
                               if (report == "DistanceTravelled") { rep = "AnalDistance" }
                               if (report == "Activity") { rep = "AnalActivity" }
                               if (report == "MaxSpeed") { rep = "AnalSpeed" }
                               if (report == "SpeedLimitExcess") { rep = "AnalSpeedEx" }
                               var veh = $('#cbVehicles').val()
                               var range = $('#cbRange').val()
                               var per = $('#cbPeriod').val()
                               var day = $('#cbDay').val()
                               var date = $('#cbDate1').val()
                               var saati = $('#cbTimeHours').val()
                               //var minuti = $('#cbTimeMinutes').val()
                               //var uid = '<%=Session("user_id") %>'
                               _list = document.getElementById('div-email')
                               var email = ''
                               var emailID = ''
                               if (_list.childNodes.length > 0) {
                                   for (var k = 0; k < _list.childNodes.length; k++) {
                                       if (_list.childNodes[k].checked == true) {
                                           emailID = _list.childNodes[k].alt
                                           email += document.getElementById('email_' + emailID).value + ';'
                                       }
                                   }
                               }
                               //alert("schedulerSave.aspx?rep=" + rep + "&veh=" + veh + "&per=" + per + "&day=" + day + "&date1=" + date + "&sati=" + sati + "&minuti=" + minuti + "&email=" + email + "&uid=" + userID)
                               
                               $.ajax({
                                   url: "schedulerSave.aspx?rep=" + rep + "&veh=" + veh + "&range=" + range + "&per=" + per + "&day=" + day + "&date1=" + date + "&saati=" + saati + "&email=" + email + "&uid=" + userID + "&path=" + path,
                                   context: document.body,
                                   success: function (data) {
                                       //mymsg(sucAdd);
                                       mymsg(dic("SucAddSch", l));
                                   }
                               });
                               //$(this).dialog("close");
                           },
                           No: function () {
                               ShowNotification();
                               $(this).dialog("close");
                           }
                       }
                   });
               }
           });
          }

          
			   function AddEmail(index, _uid, _report, l) {
			      
			       $.ajax({
			           url: 'email1.aspx?lang=' + l,
			           context: document.body,
			           success: function (data) {
			               $('#div-add-email').html(data)

			               $('#div-add-email').dialog({ modal: true, height: 220, width: 350,
			                   buttons: {
			                       Send: function () {

			                           var email = document.getElementById('toEmail').value;
			                           var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
			                           var link = document.location.href;

			                           var xmlHttp; var str = ''
			                           try { xmlHttp = new XMLHttpRequest(); } catch (e) {
			                               try
			        { xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); }
			                               catch (e) {
			                                   try
                    { xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e)
                    { alert("Your browser does not support AJAX!"); return false; }
			                               }
			                           }
			                           tttt = this;

			                           xmlHttp.onreadystatechange = function () {
			                               if (xmlHttp.readyState == 4) {
			                                   str = xmlHttp.responseText
			                                   if (str == "True") {
			                                       document.getElementById("notification").innerHTML = dic("EmailSucSend", l);
			                                       document.getElementById("notification").style.visibility = "visible";
			                                       setTimeout("closeDialog()", 2000);
			                                   }
			                                   else {
			                                       document.getElementById("notification").innerHTML = dic("EmailNotSend", l);
			                                       document.getElementById("notification").style.visibility = "visible";
			                                       setTimeout("closeDialog()", 2000);
			                                   }
			                               }
			                           }
                                       

			                           if (document.getElementById('toEmail').value.match(emailExp)) {
			                               document.getElementById("notification").innerHTML = "<img src='../images/ajax-loader.gif' border='0' align='absmiddle' width='31' height='31' />&nbsp;<span class='text1' style='color:#5C8CB9; font-weight:bold; font-size:11px'>" + dic("Sending", l) + "</span>"
			                               document.getElementById("notification").style.visibility = "visible";
			                               //ShowWait()
			                               var x = "";
			                               x = encodeURI(link)

			                               var index = x.indexOf("&");
			                               while (index != -1) {
			                                   x = x.replace("&", "*");
			                                   index = x.indexOf("&");
			                               }

			                               xmlHttp.open("GET", './emailSend.aspx?_user=' + _uid + '&email=' + email + '&subject=' + _report + '&link=' + x, true);
			                               xmlHttp.send(null);
			                           }
			                           else {
			                               document.getElementById('toEmail').value = dic("EnterCorrForm");
			                               document.getElementById('toEmail').style.color = "#ff6633";
			                               document.getElementById('toEmail').style.fontStyle = "italic";
			                           }

			                           // $(this).dialog("close");
			                       }
                                   ,
			                       Cancel: function () {

			                           $(this).dialog("close");
			                       }
			                   }
			               });
			           }
			       });
			   }
			   function closeDialog() {
                   $(tttt).dialog("close")
               }

               function BtnDeleteMarkerFromList(_id, _num) {
	             	for (var i=0; i <= tmpMarkersRoute.length - 1; i++) {
	             		if (_num != i && tmpMarkersRoute[i].lonlat.lon == tmpMarkersRoute[_num].lonlat.lon && tmpMarkersRoute[i].lonlat.lat == tmpMarkersRoute[_num].lonlat.lat) {
	             			if (tmpMarkersRoute[_num].events.element.children[0].style.width == "14px") {
	             				tmpMarkersRoute[i].events.element.children[0].style.width = "14px"
								tmpMarkersRoute[i].events.element.children[0].style.textAlign = "center"
								tmpMarkersRoute[i].events.element.children[0].style.paddingRight = "0px"
								tmpMarkersRoute[i].events.element.children[0].style.zIndex = "666"
								tmpMarkersRoute[i].events.element.style.zIndex = "666"
	             			} else {
	             				tmpMarkersRoute[i].events.element.children[0].style.borderRadius = "5px";
	             				tmpMarkersRoute[i].events.element.children[0].style.borderRight = "0px";
	             			}
	             		}
	             	}
              	   var delStart = false;
              	   var delEnd = false;
              	   if ($("#" + _id).css("background-color") == "rgb(188, 235, 160)") {
		           	delStart = true;
              	   }
                   if ($("#" + _id).css("background-color") == "rgb(250, 195, 195)") {
                   	delEnd = true;             		
               	   }
                   for (var _br = (parseInt(_num, 10) + 1); _br < PointsOfRoute.length - 1; _br++) {
                       PointsOfRoute[_br] = PointsOfRoute[_br + 1];
                   }
                   PointsOfRoute = PointsOfRoute.slice(0, _br).concat(PointsOfRoute.slice(_br + 1));
                   //doOptimized('route', 'renderRoute');
                   Markers[0].removeMarker(tmpMarkersRoute[_num]);
                   if(ArrAreasPoly[0] != undefined)
                   		vectors[0].removeFeatures(ArrAreasPoly[0][_num]);

		   //brisenje poligon		
                   if(ArrPolygons[0] != undefined) {
	                   for (var i=0; i < ArrPolygons[0].length; i++) {
	                   		if (_id.substring(9, _id.lastIndexOf("_")) == ArrPolygons[0][i].style.areaid) {
	                   			vectors[0].removeFeatures(ArrPolygons[0][i]);
	                   		}
	                   }
                   }
	
                   var _chN = (parseInt(_num, 10) + 1) > (tmpMarkersRoute.length - 1) ? -1 : (parseInt(_num, 10) + 1);
                   var _chP = parseInt(_num, 10) - 1;
                   tmpMarkersRoute[_num] = [];
                   if (parseInt(_chP, 10) != -1 && parseInt(_chN, 10) != -1) {
                       $('#' + _id).remove();
                       vectors[0].removeFeatures(lineFeatureRoute[_num]);
                       lineFeatureRoute[_num] = "";
                       vectors[0].removeFeatures(lineFeatureRoute[_chN]);
                       lineFeatureRoute[_chN] = "";
                       if ($('#test1').attr('checked'))
                           var file = "getLinePoints";
                       else
                           var file = "getLinePointsF";
                       DrawLine_Route1(PointsOfRoute[_num].lon, PointsOfRoute[_num].lat, PointsOfRoute[_chN].lon, PointsOfRoute[_chN].lat, _num, 1, "<br /><strong>Od: (" + _num + ")</strong> " + PointsOfRoute[_num].name + "<br /><strong>Do: (" + _chN + ")</strong> " + PointsOfRoute[_chN].name, file);
                       for (var i = (parseInt(_chN, 10) - 1); i < tmpMarkersRoute.length - 1; i++) {
                           if (i < (tmpMarkersRoute.length - 2)) {
                               for (var j = 0; j < lineFeatureRoute[i + 2].length; j++) {
                                   lineFeatureRoute[i + 2][j].style.VehID = "<br /><strong>Od: (" + (i + 1) + ")</strong> " + PointsOfRoute[i + 1].name + "<br /><strong>Do: (" + (i + 2) + ")</strong> " + PointsOfRoute[i + 2].name;
                                   //var popupL = "<br /><strong>Od: (" + (i + 1) + ")</strong> " + PointsOfRoute[i + 1].name + "<br /><strong>Do: (" + (i + 2) + ")</strong> " + PointsOfRoute[i + 2].name;
                                   //lineFeatureRoute[i + 2][j].layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>Рута</strong>'+"+popupL+")}");
                                   //lineFeatureRoute[i + 2][j].layer.events.element.attributes[4].value = "if(event.target.id.indexOf('OpenLayers.Geometry.LineString') != -1){ShowPopup(event, '<strong>Рута</strong>'+" + popupL + ")}";
                               }
                           }
                           if (tmpMarkersRoute[i + 1] == "")
                               break;
                           
                           $('#MarkersIN').children()[i].id = $('#MarkersIN').children()[i].id.substring(0, $('#MarkersIN').children()[i].id.lastIndexOf("_") + 1) + i;
                           $('#MarkersIN').children()[i].children[4].id = $('#MarkersIN').children()[i].children[4].id.substring(0, $('#MarkersIN').children()[i].children[4].id.lastIndexOf("_") + 1) + i;
                           
                           	if (Browser() != 'iPad' && Browser() != 'Safari')
								$('#MarkersIN').children()[i].children[4].attributes[0].value = $('#MarkersIN').children()[i].children[4].attributes[0].value.substring(0, $('#MarkersIN').children()[i].children[4].attributes[0].value.lastIndexOf("_") + 1) + i + "','" + i + "')";
                       		else
                       		$('#MarkersIN').children()[i].children[4].attributes[3].value = $('#MarkersIN').children()[i].children[4].attributes[3].value.substring(0, $('#MarkersIN').children()[i].children[4].attributes[3].value.lastIndexOf("_") + 1) + i + "','" + i + "')";

                           tmpMarkersRoute[i + 1].events.element.children[0].innerHTML = (parseInt(tmpMarkersRoute[i + 1].events.element.children[0].textContent, 10) - 1) + tmpMarkersRoute[i + 1].events.element.children[0].innerHTML.substring(tmpMarkersRoute[i + 1].events.element.children[0].innerHTML.indexOf("<"), tmpMarkersRoute[i + 1].events.element.children[0].innerHTML.length);
                           tmpMarkersRoute[i] = tmpMarkersRoute[i + 1];
                           tmpMarkersRoute[i + 1] = [];
                           if(ArrAreasPoly[0] != undefined)
                           {
                           	ArrAreasPoly[0][i] = ArrAreasPoly[0][i+1];
                           	ArrAreasPoly[0][i+1] = [];
                           }
                       }
                       tmpMarkersRoute = tmpMarkersRoute.slice(0, i).concat(tmpMarkersRoute.slice(i + 1));
                       if(ArrAreasPoly[0] != undefined)
                       		ArrAreasPoly[0] = ArrAreasPoly[0].slice(0, i).concat(ArrAreasPoly[0].slice(i + 1));
                       setTimeout("HideWait();", 1500);
                   }
                   else {
                       $('#' + _id).remove();
                       if (parseInt(_chP, 10) != -1) {
                           vectors[0].removeFeatures(lineFeatureRoute[_num]);
                           lineFeatureRoute[_num] = "";
                           lineFeatureRoute = lineFeatureRoute.slice(0, _num).concat(lineFeatureRoute.slice(_num + 1));
                           if (parseInt(_chP, 10) != 0) {
                               tmpMarkersRoute[_chP].events.element.children[0].style.backgroundColor = '#FF0000';
                           } else {
                               lineFeatureRoute = [];
                           }
                           tmpMarkersRoute = tmpMarkersRoute.slice(0, _num).concat(tmpMarkersRoute.slice(_num + 1));
                           if(ArrAreasPoly[0] != undefined)
                           		ArrAreasPoly[0] = ArrAreasPoly[0].slice(0, _num).concat(ArrAreasPoly[0].slice(_num + 1));
                       }
                       if (parseInt(_chN, 10) != -1) {
                           vectors[0].removeFeatures(lineFeatureRoute[_chN]);
                           lineFeatureRoute[_chN] = "";
                           tmpMarkersRoute[_chN].events.element.children[0].style.backgroundColor = '#00CC33';
                           for (var i = _chN; i < lineFeatureRoute.length - 1; i++) {
                               lineFeatureRoute[i] = lineFeatureRoute[i + 1];
                               lineFeatureRoute[i + 1] = "";
                           }
                           lineFeatureRoute = lineFeatureRoute.slice(0, i).concat(lineFeatureRoute.slice(i + 1));
                           for (var i = (parseInt(_chN, 10) - 1); i < tmpMarkersRoute.length - 1; i++) {
                               if (i < (tmpMarkersRoute.length - 2)) {
                                   for (var j = 0; j < lineFeatureRoute[i + 1].length; j++) {
                                       lineFeatureRoute[i + 1][j].style.VehID = "<br /><strong>Od: (" + (i + 1) + ")</strong> " + PointsOfRoute[i + 1].name + "<br /><strong>Do: (" + (i + 2) + ")</strong> " + PointsOfRoute[i + 2].name;
                                   }
                               }
                               if (tmpMarkersRoute[i + 1] == "")
                                   break;

                               $('#MarkersIN').children()[i].id = $('#MarkersIN').children()[i].id.substring(0, $('#MarkersIN').children()[i].id.lastIndexOf("_") + 1) + i;
                               $('#MarkersIN').children()[i].children[4].id = $('#MarkersIN').children()[i].children[4].id.substring(0, $('#MarkersIN').children()[i].children[4].id.lastIndexOf("_") + 1) + i;
                               if (Browser() != 'iPad' && Browser() != 'Safari')
                               		$('#MarkersIN').children()[i].children[4].attributes[0].value = $('#MarkersIN').children()[i].children[4].attributes[0].value.substring(0, $('#MarkersIN').children()[i].children[4].attributes[0].value.lastIndexOf("_") + 1) + i + "','" + i + "')";
                           		else
                           		$('#MarkersIN').children()[i].children[4].attributes[3].value = $('#MarkersIN').children()[i].children[4].attributes[3].value.substring(0, $('#MarkersIN').children()[i].children[4].attributes[3].value.lastIndexOf("_") + 1) + i + "','" + i + "')";
                               tmpMarkersRoute[i + 1].events.element.children[0].innerHTML = (parseInt(tmpMarkersRoute[i + 1].events.element.children[0].textContent, 10) - 1) + tmpMarkersRoute[i + 1].events.element.children[0].innerHTML.substring(tmpMarkersRoute[i + 1].events.element.children[0].innerHTML.indexOf("<"), tmpMarkersRoute[i + 1].events.element.children[0].innerHTML.length);
                               tmpMarkersRoute[i] = tmpMarkersRoute[i + 1];
                               tmpMarkersRoute[i + 1] = [];
                               if(ArrAreasPoly[0] != undefined)
                               {
                               		ArrAreasPoly[0][i] = ArrAreasPoly[0][i+1];
                           	   		ArrAreasPoly[0][i+1] = [];
                           	   }
                           }
                           tmpMarkersRoute = tmpMarkersRoute.slice(0, i).concat(tmpMarkersRoute.slice(i + 1));
                           if(ArrAreasPoly[0] != undefined)
                           		ArrAreasPoly[0] = ArrAreasPoly[0].slice(0, i).concat(ArrAreasPoly[0].slice(i + 1));
                       }
                       if (parseInt(_chP, 10) == -1 && parseInt(_chN, 10) == -1) {
                           lineFeatureRoute = [];
                           tmpMarkersRoute = [];
                       }
                   }
                   $('#report-content').css({ height: (parseInt($('#report-content').css('height'), 10) - 30) + 'px' });
                   if (PointsOfRoute[1] != undefined) {
                       $('#IDMarker_' + PointsOfRoute[1].id + '_0')[0].children[2].value = "/";
                       $('#IDMarker_' + PointsOfRoute[1].id + '_0')[0].children[3].value = "/";
                   }
                   
                   	var mmetric = ' km';
					if(metric == 'mi')
					{
						mmetric = ' miles';
					}
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
		           if (delStart == true) {
              	   	$($('#MarkersIN')[0].children[0]).css('background-color', '#BCEBA0');
              	   }
                   if (delEnd == true && $('#MarkersIN')[0].children.length > 1) {
                   	$($('#MarkersIN')[0].children[$('#MarkersIN')[0].children.length-1]).css('background-color', '#FAC3C3')      		
               	   }
               	   if ($('#MarkersIN')[0].children.length <= 1) {
                   	haveEndPoi = false;  		
               	   }
               	   if ($('#MarkersIN')[0].children.length == 0) {
               	   	haveStartPoi = false;  	
                   	haveEndPoi = false;  		
               	   }
			       if ($('#MarkersIN')[0].children.length > 0)		         
		         zoomWorldScreen(Maps[0], 15);		            
               }
               
               
function OpenMapActivity(uid, cid, sd, ed, vn, vh, zoneid) {
	//alert(uid + " " + cid + " " + sd + " " + ed + " " + vn + " " + vh)
    var h = document.body.clientHeight * 0.9
    var w = document.body.clientWidth * 0.9
    top.$('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; border:0px" src=""></iframe>');
    top.document.getElementById('iframemaps').src = '../report/reconstructionOneVehStatus.php?l=' + lang + '&uid=' + uid + '&cid=' + cid + '&sd=' + sd + '&ed=' + ed + '&v=' + vh + '&vehNum=' + vn + '&zoneid=' + zoneid;
    top.$('#dialog-map').dialog({ modal: true, height: h, width: w
    });
}
