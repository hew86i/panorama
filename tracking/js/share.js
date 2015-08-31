// ******  share.js  ******
var legendStr
var AllowAddPoi = 'true'
var AllowViewPoi = 'true'
var AllowAddZone = 'true'
var AllowViewZone = 'true'
var AllowViewPath = 'true'
var AllowUSettings = 'true'
var AllowCSettings = 'true'
var AllowPSettings = 'true'
var overId;
//alert(document.location.pathname + "\n\r" + document.location.href);
if(document.location.href.indexOf("lang") == -1 && document.location.href.indexOf("essionexpired") == -1 && document.location.href.indexOf("dmin") == -1 && document.location.href.indexOf("racking") == -1 && document.location.href.indexOf("ettings") == -1 && document.location.href.indexOf("eport") == -1 && document.location.href.indexOf("fm") == -1 && document.location.href.indexOf("oute") == -1)
	var _point = ".";
else
	var _point = "..";
var xmlDoc;
xmlDoc = loadXMLDoc(_point + "/lang/" + lang + ".xml");

$(document).ready(function () {
    $(document.body).click(function(event) { HideWindows(event)});
    $(document.body).mousemove(function(event) { FindActivBoard(event)});
    $(document.body).mouseout(function(event) { FindActivBoard(event)});
    setElementToCenter();
    setRoundIE();	
	$('#txtusername').focus()
	if (Browser()=='iPad') {	document.addEventListener('DOMContentLoaded', loaded, false);}
	
	$('#icon-en').mousemove(function(event) {ShowPopup(event, '' + dic("en", lang) +'')});
	$('#icon-fr').mousemove(function(event) {ShowPopup(event, '' + dic("fr", lang) +'')});
	$('#icon-logout').mousemove(function(event) {ShowPopup(event, '' + dic("logout", lang) +'')});
	$('#icon-home').mousemove(function(event) {ShowPopup(event, '' + dic("home", lang) +'')});
	$('#icon-rep').mousemove(function(event) {ShowPopup(event, '' + dic("reports", lang) +'')});
	$('#icon-live').mousemove(function(event) {ShowPopup(event, '' + dic("live", lang) +'')});
	$('#icon-sett').mousemove(function(event) {ShowPopup(event, '' + dic("sett", lang) +'')});
	$('#icon-help').mousemove(function(event) {ShowPopup(event, '' + dic("help", lang) +'')});
	$('#reloadPage').mousemove(function(event) {ShowPopup(event, '' + dic("resSett", lang) +'')});
	$('#sepList').mousemove(function(event) {ShowPopup(event, '' + dic("sepScreen", lang) +'')});
	$('#poi').mousemove(function(event) {ShowPopup(event, '' + dic("addPoi", lang) +'')});
	$('#a-split').mousemove(function(event) {ShowPopup(event, '' + dic("splitScr", lang) +'')});
	$('#a-split').click(function(event) {ShowSeparators(event);HidePopup();});
	
	$('#a-AddPOI').mousemove(function(event) {ShowPopup(event, '' + dic("addPoi1", lang) +'')});
	
	if (AllowAddPoi == 'true' || AllowAddPoi == '1') {
		$('#a-AddPOI').click(function(event) {ButtonAddPOIClick(event);HidePopup();});
	} else {
		$('#a-AddPOI').css({opacity:0.3, cursor:'default'})
	}
	$('#icon-poi').mousemove(function(event) {ShowPopup(event, '' + dic("showPoi", lang) +'')});
    $('#icon-poi-down').mousemove(function(event) {ShowPopup(event, '' + dic("chooseGroupPoi", lang) +'')});
	
    $('#icon-draw-zone').mousemove(function(event) {ShowPopup(event, '' + dic("showGeoFence", lang) +'')});
    $('#icon-zone-down').mousemove(function(event) {ShowPopup(event, '' + dic("chooseGroupGF", lang) +'')});
    $('#icon-draw-zone').mouseout(function() {HidePopup()});
    $('#icon-zone-down').mouseout(function() {HidePopup()});

    if (AllowViewZone == 'true' || AllowViewZone == '1') {
        $('#icon-zone-down').click(function(event) {ShowPoiGroup("getGroup.php","div-AreasUp", "div-Areas", "icon-zone-down", 2, 1, ShowHideZone, "275"); HidePopup();});
        $('#icon-draw-zone').click(function(event) {LoadAllZone(); HidePopup();});
    }else{
        $('#icon-zone-down').css({opacity:0.3, cursor:'default'});
        $('#icon-draw-zone').css({opacity:0.3, cursor:'default'});
    }
    if (AllowViewPath == 'true' || AllowViewPath == '1') {
        $('#icon-draw-path').click(function(event) {OnClickSHTrajectory()});
        $('#icon-draw-path-down').click(function(event) {ShowPoiGroup("getVehicles.php","div-VehicleUp", "div-Vehicle", "icon-draw-path-down", 1, 0, ShowHideTrajectory, "330");HidePopup();});
    }else{
        $('#icon-draw-path-down').css({opacity:0.3, cursor:'default'});
        $('#icon-draw-path').css({opacity:0.3, cursor:'default'});
    }

    $('#activeBoard').click(function(event) {ShowActiveBoard(); HidePopup(); });
    $('#activeBoard').mousemove(function(event) {ShowPopup(event, '' + dic("actScr", lang) +'')});
    $('#activeBoard').mouseout(function() {HidePopup()});

	if (AllowViewPoi == 'true' || AllowViewPoi == '1') {
		$('#icon-poi').click(function(event) {LoadAllPOI('All');HidePopup();});
        $('#icon-poi-down').click(function(event) {ShowPoiGroup("getGroup.php","div-poiGroupUp", "div-poiGroup", "icon-poi-down", 3, 1, ShowPOI, "225");HidePopup();});
	} else {
		$('#icon-poi').css({opacity:0.3, cursor:'default'});
        $('#icon-poi-down').css({opacity:0.3, cursor:'default'});
	}
	
    

	$('#icon-logout').mousemove(function(event) {ShowPopup(event, '' + dic("logout", lang) +'')});
	$('#icon-legenda').mousemove(function(event) {
        ShowPopupL(event, legendStr)
    });
	$('#span-time').mousemove(function(event) {ShowPopup(event, getCTime())});
	
	
	
	$('#icon-en').mouseout(function() {HidePopup()});
	$('#icon-fr').mouseout(function() {HidePopup()});
	$('#icon-logout').mouseout(function() {HidePopup()});
	$('#icon-home').mouseout(function() {HidePopup()});
	$('#icon-rep').mouseout(function() {HidePopup()});
	$('#icon-live').mouseout(function() {HidePopup()});
	$('#icon-sett').mouseout(function() {HidePopup()});
	$('#icon-help').mouseout(function() {HidePopup()});
	$('#reloadPage').mouseout(function() {HidePopup()});
	$('#sepList').mouseout(function() {HidePopup()});
	$('#poi').mouseout(function() {HidePopup()});
	$('#a-split').mouseout(function() {HidePopup()});
	$('#a-AddPOI').mouseout(function() {HidePopup()});
	$('#icon-logout').mouseout(function() {HidePopup()});
	$('#icon-legenda').mouseout(function() {HidePopup()});
	$('#span-time').mouseout(function() {HidePopup()});
	$('#icon-poi').mouseout(function() {HidePopup()});
    $('#icon-poi-down').mouseout(function() {HidePopup()});
});

function loadXMLDoc(dname)
{
	if (window.XMLHttpRequest)
	{
		xhttp=new XMLHttpRequest();
	} else
	{
		xhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xhttp.open("GET",dname,false);
	xhttp.send();
	return xhttp.responseXML;
}
function dic(key, lang) {
	var x = xmlDoc.getElementsByTagName(key)[0];
	return x.textContent;
}

function loaded() {
		document.addEventListener('touchmove', function(e){ e.preventDefault(); });
}

function Browser (){
	var b
	
	if (navigator.userAgent.indexOf("Firefox")>0) b = "Firefox";
	if (navigator.userAgent.indexOf("Safari")>0) b = "Safari";
	if (navigator.userAgent.indexOf("Chrome")>0) b = "Chrome";
	if (navigator.appName=="Microsoft Internet Explorer") b = "IE";
	if (navigator.appName=="Opera") b = "Opera";
	if (navigator.userAgent.indexOf("iPad")>0) b = "iPad";
	return b
}

function setRoundIE(){
	if (Browser()=='IE') {
	 	DD_roundies.addRule('.corner5', '5px');
		DD_roundies.addRule('.corner15', '15px');
		
	}
}

function setElementToCenter(){
	var _w = document.body.clientWidth
	var _h = document.body.clientHeight
	$('#main-container').css({ left: ((_w - 950) / 2) + 'px', height: (_h - 35) + 'px' })
	$('#footer-rights').css({left:((_w-950)/2)+'px', top:(_h-30)+'px'})
	$('#footer-legacy').css({left:(((_w-950)/2)+475)+'px', top:(_h-30)+'px'})
	$('#div-text').css({height: (_h - 170) + 'px' })
	$('#tableReports').css({height:_h+'px'})
	if (Browser()!='iPad') {$('#scroll-content-div').css({height:(_h-6)+'px'})}
	$('#vSep').css({height: _h + 'px' })
	$('#rep-menu').css({height: _h + 'px' })
}

function is_string(input){
    return typeof(input)=='string';
}



function _disable(_element) {
	if (is_string(_element) == true) {_element = document.getElementById(_element)}
	try {
		_element.disabled = true

		if (_element.childNodes && _element.childNodes.length > 0) {
			for (var x = 0; x < _element.childNodes.length; x++) {
				_disable(_element.childNodes[x]);
			}
		}
	}
	catch(E){
		
	}
}
function _enable(_element) {
	if (is_string(_element) == true) {_element = document.getElementById(_element)}
	
	try {
		_element.disabled = false
		if (_element.childNodes && _element.childNodes.length > 0) {
			for (var x = 0; x < _element.childNodes.length; x++) {
				_enable(_element.childNodes[x]);
			}
		}
	}
	catch(E){
		
	}
}

function Create(parentElement, _type, _id){
	try{
		if (_id==null) {_id=''}
		var el = document.createElement(_type)
		el.setAttribute("id", _id)
		parentElement.appendChild(el)
		return el
	}catch(err){

	}	
}

function ShowPopupL(e, txt){
	if (txt[0]=='#') {
		txt = $(txt).html()	
		txt = '<div class="div-one-vehicle-list text3 corner5" style="width:215px; margin-top:0px">'+txt+'</div>'
	}
	var divPopup = document.getElementById('div-popup');
	if (divPopup==null) {divPopup =  Create(document.body, 'div', 'div-popup')}
	$(divPopup).show()
	var _l = e.pageX-210 //document.getElementById(elID).offsetLeft
	var _t = e.pageY-175 //document.getElementById(elID).offsetTop
	
	divPopup.className='text2 corner5 shadow'
	$(divPopup).css({position:'absolute', zIndex:'9999', left:_l+'px', top:_t+'px', display:'block', border:'1px solid #1a6ea5', backgroundColor:'#e2ecfa', padding:'4px 4px 4px 4px'})
	divPopup.innerHTML = txt
	if (divPopup.offsetLeft+divPopup.offsetWidth>document.body.clientWidth) {divPopup.style.left=(document.body.clientWidth -divPopup.offsetWidth-10)+'px'}
}
function ShowPopupB(e, txt){
	var txtN = "";
    for(var i=0; i<txt.split(";").length;i++) {
		var txtN1 = $(txt.split(";")[i]).html();
		txtN += '<div class="div-one-vehicle-list text3 corner5" style="width:215px; margin-top:0px">'+txtN1+'</div>';
	}
	var divPopup = document.getElementById('div-popup')
	if (divPopup==null) {divPopup =  Create(document.body, 'div', 'div-popup')}
	$(divPopup).show()
	var _l = e.pageX+10 //document.getElementById(elID).offsetLeft
	var _t = e.pageY+25 //document.getElementById(elID).offsetTop
	
	divPopup.className='text2 corner5 shadow'
	$(divPopup).css({position:'absolute', zIndex:'9999', left:_l+'px', top:_t+'px', display:'block', border:'1px solid #1a6ea5', backgroundColor:'#e2ecfa', padding:'4px 4px 4px 4px'})
	divPopup.innerHTML = txtN
	if (divPopup.offsetLeft+divPopup.offsetWidth>document.body.clientWidth) {divPopup.style.left=(document.body.clientWidth -divPopup.offsetWidth-10)+'px'}
}
function ShowPopup(e, txt){
	
	if (txt[0]=='#') {
		txt = $(txt).html()	
		txt = '<div class="div-one-vehicle-list text3 corner5" style="width:215px; margin-top:0px">'+txt+'</div>'
	}
	var divPopup = document.getElementById('div-popup')
	if (divPopup==null) {divPopup =  Create(document.body, 'div', 'div-popup')}
	$(divPopup).show()
	var _l = e.pageX+10 //document.getElementById(elID).offsetLeft
	var _t = e.pageY+25 //document.getElementById(elID).offsetTop
	
	divPopup.className='text2 corner5 shadow'
	$(divPopup).css({position:'absolute', zIndex:'9999', left:_l+'px', top:_t+'px', display:'block', border:'1px solid #1a6ea5', backgroundColor:'#e2ecfa', padding:'4px 4px 4px 4px'})
	divPopup.innerHTML = txt
	if (divPopup.offsetLeft+divPopup.offsetWidth>document.body.clientWidth) {divPopup.style.left=(document.body.clientWidth -divPopup.offsetWidth-10)+'px'}
}
function HidePopup(){
	$('#div-popup').hide()
}

function unzip(s)
{
    var dict = {};
    var data = (s + "").split("");
    var currChar = data[0];
    var oldPhrase = currChar;
    var out = [currChar];
    var code = 4000;
    var phrase;
    for (var i=1; i<data.length; i++) {
     var currCode = data[i].charCodeAt(0);
     if (currCode < 4000) {
      phrase = data[i];
     }
     else {
     phrase = dict[currCode] ? dict[currCode] : (oldPhrase + currChar);
     }
     out.push(phrase);
     currChar = phrase.charAt(0);
     dict[code] = oldPhrase + currChar;
     code++;
     oldPhrase = phrase;
    }
    return out.join("");
}
function AdminMeni(no) { 
    //del za trganje na iframe i kreiranje na nov div tag///////////
    var elementi = document.getElementById("report-content");
    var brojac = 0;
	
	$('#stt-cont').html('');
	document.getElementById('ifr-map').src = './blanko.php';
	
	for (var i=1;i<6;i++){
    	document.getElementById("menu_set_"+i).className="repoMenu corner5 text2";
    }
    document.getElementById("menu_set_"+no).className="repoMenuSel corner5 text2"
    
    ShowWait();
    $('#stt-cont').css({display: 'none'});
    $('#ifr-map').css({display: 'block'});
    $.ajax({
        url: "./Admin"+no+".php?l="+lang,
        context: document.body,
        success: function (data) {
            HideWait();
            //$('#stt-cont').html(data)
            document.getElementById('ifr-map').src = './Admin'+no+'.php';
            $("#SaveDataradio").buttonset();
            $('#AM-div').buttonset();
            $('#Def-Lang').buttonset();
            $('#Def-Map').buttonset();
            $('#LiveTracking').buttonset();
            $('#LiveTracking1').buttonset();
            $('#Kilometri').buttonset();
        }
    });
    
}

 function getWidthHeight() {
        var h_ = document.getElementById('footer-rights-new').offsetTop
        return h_;
 }

function SettingsMeni(no) { 

	if ((no==1) && (AllowUSettings=='false')) {return}
	if ((no==2) && (AllowCSettings=='false')) {return}
	if ((no==3) && (AllowCSettings=='false')) {return}
	if ((no==4) && (AllowUSettings=='false')) {return}
	if ((no==5) && (AllowCSettings=='false')) {return}
	if ((no==6) && (AllowCSettings=='false')) {return}
	if ((no==7) && (AllowCSettings=='false')) {return}
	
	//if ((no==3) && (AllowPSettings=='false')) {return}
	
    //del za trganje na iframe i kreiranje na nov div tag///////////
    var elementi = document.getElementById("report-content");
    var brojac = 0;
    if(elementi.childNodes.length > 0){
        for(var i =0; i< elementi.childNodes.length; i++){
            if(elementi.childNodes[i].tagName == 'IFRAME'){
                $("#i-show-poi").remove();
                $("#i-show-geo").remove();
                brojac = 1;
            }
        }
        if(brojac == 1){
            var dete = document.createElement('div');
            dete.setAttribute('id', 'stt-cont1');
            dete.setAttribute('class','corner5');
            document.getElementById("report-content").appendChild(dete);
        }
    }
    
    
    
    
    
    ///////////////////////////////////////////////////////////////

    for (var i=1;i<=7;i++){document.getElementById("menu_set_"+i).className="repoMenu corner5 text2"}
    document.getElementById("menu_set_"+no).className="repoMenuSel corner5 text2"
    if (no == 1) {
        ShowWait()
        document.getElementById('ifrm-cont').src = "USettings.php?l="+lang;

       /* $.ajax({
            url: "USettings.php?l="+lang,
            context: document.body,
            success: function (data) {
                HideWait()
                $('#stt-cont').html(data)
                $("#SaveDataradio").buttonset();
                $('#AM-div').buttonset();
                $('#Def-Lang').buttonset();
                $('#Def-Map').buttonset();
                $('#LiveTracking').buttonset();
                $('#LiveTracking1').buttonset();
                $('#Kilometri').buttonset();
            }
        });*/
    }
    else {
        if(no == 2){
           ShowWait()
           document.getElementById('ifrm-cont').src = "CSettings.php?l="+lang;
            
           /* $.ajax({
                url: "CSettings.php?l="+lang,
                context: document.body,
                success: function (data) {
                    HideWait()
                    //$('#stt-cont').html(data)
                    $('#btnAdd').button({ icons: { primary: "ui-icon-plus"} });
                    $('#btnDelete').button({ icons: { primary: "ui-icon-cancel"} });
                    $('#btnEdit').button({ icons: { primary: "ui-icon-pencil"} });
                    $('#btnVehicles').button({ icons: { primary: "ui-icon-transferthick-e-w"} });
                }
            });*/
        }
        else{
             if(no == 3){
           		   document.getElementById('ifrm-cont').src = "GroupPOI.php?l="+lang;
            
                   /* $.ajax({
                        url: "GroupPOI.php?l="+lang,
                        context: document.body,
                        success: function (data) {
                            HideWait()
                             $('#stt-cont').html(data)
                             $('#btnEdit').button({ icons: { primary: "ui-icon-pencil"} });

                        }
                    });*/
                }
      				 else{"Drivers.php?l=" + '<?php echo $cLang ?>';
                if(no == 4){
                    ShowWait()
                    document.getElementById('ifrm-cont').src = "Vehicles.php?l="+lang;
                    /*$.ajax({
                        url: "Vehicles.php?l="+lang,
                        context: document.body,
                        success: function (data) {
                            HideWait()
                             $('#stt-cont').html(data)
                        

                        }
                    });*/
                }
                else{
                if(no == 5){
                    ShowWait()
                     document.getElementById('ifrm-cont').src = "Organisation.php?l="+lang;
                   /* $.ajax({
                        url: "Organisation.php?l="+lang,
                        context: document.body,
                        success: function (data) {
                            HideWait()
                             $('#stt-cont').html(data)
                        

                        }
                    });*/
                }
                
                    else{
                if(no == 6){
                    ShowWait()
                    document.getElementById('ifrm-cont').src = "Drivers.php?l="+lang;
                   /* $.ajax({
                        url: "Drivers.php?l="+lang,
                        context: document.body,
                        success: function (data) {
                            HideWait()
                             $('#stt-cont').html(data)
                        

                        }
                    });*/
                }
                else{
                if(no == 7){
                    
                    document.getElementById('ifrm-cont').src = "WorkTime.php?l="+lang;
                    /*$.ajax({
                        url: "WorkTime.php?l="+lang,
                        context: document.body,
                        success: function (data) {
                            HideWait()
                             $('#stt-cont').html(data)
                        

                        }
                    });*/
                } 
                }
               }
               }
              }
            }
           }
          }
          
                
               /* else{
                    if(no == 4){
                        ShowWait()
                        $.ajax({
                            url: "ZoneSettings.aspx?l=" + lang,
                            context: document.body,
                            success: function (data) {
                                HideWait()
                                $('#stt-cont').html(data)
                                $('#btnAddGroup').button({ icons: { primary: "ui-icon-plus"} });
                                $('#btnDeleteGroup').button({ icons: { primary: "ui-icon-cancel"} });
                                $('#btnEditGroup').button({ icons: { primary: "ui-icon-pencil"} });
                                $('#btnEditZone').button({ icons: { primary: "ui-icon-pencil"} });
                                $('#btnDelZone').button({ icons: { primary: "ui-icon-cancel"} });
                                $('#btnChangeZone').button({ icons: { primary: "ui-icon-transferthick-e-w"} });
                                $('#btnViewZone').button({ icons: { primary: "ui-icon-search"} });
                                $('#btnAllowedVehicles').button({ icons: { primary: "ui-icon-wrench"} });
                            }
                        });
                    }
                } */
           
        
    

//}

//LoadMap funkcii za POI
function LoadRightDiv() {
    var docH = document.body.clientHeight - 160;
    var docW = document.body.clientWidth - 160;
    //document.getElementById("div-chart-poi").style.height = docH - 5;
    //document.getElementById("div-chart-poi").style.width = 300;
    document.getElementById("div-chart-poi").style.left = document.body.clientWidth - 305;
    document.getElementById("div-chart-poi").style.top = 2;//document.body.clientHeight - 40;
}

function LoadPOIandGroups(){
    //ShowWait()
    $.ajax({
        url: "POI/LoadPOI.aspx",
        context: document.body,
        success: function(data){
            //HideWait();
            $("#div-chart-poi").html(data);
        }
    });
}

function LoadZoneAndGroups(){
    //ShowWait()
    $.ajax({
        url: "GeoFence/LoadZone.aspx",
        context: document.body,
        success: function(data){
            //HideWait();
            $("#div-chart-poi").html(data);
        }
    });
}

var GlobalFN = ''
function EditUserClick(id){
    ShowWait()
    $.ajax({
	    url: "EditUser.php?id="+id+"&l="+lang,
	    context: document.body,
	    success: function(data){
            HideWait()
		    $('#div-edit-user').html(data)
            $('#div-edit-user').dialog({ modal: true, width: 350, height: 250, resizable: false,
                 buttons: {
			        OK: function() {
                        var un = $('#CEUsername').val()
                        var pass = $('#CEPassword').val()
                        var fn = $('#CEFullName').val()
                        var email = $('#CEmail').val()
                        GlobalFN = fn
                        if(un==''){
                            mymsg(dic("enterUser", lang))  
                        }else{
                            if(fn==''){
                                mymsg(dic("enterFull", lang)) 
                            }else{
                                if(pass==''){
                                    mymsg(dic("enterPass", lang))  
                                }else{
                                    if(email==''){
                                        mymsg(dic("enterEmail", lang)) 
                                    }else{
                                $.ajax({
	                            url: "UpUser.php?fn="+fn+"&un="+un+"&pass="+pass+"&email="+email+"&id="+id,
	                             context: document.body,
	                              success: function(data){
		                              window.location.reload();
									}
	                            });	
                                $( this ).dialog( "close" );
                                    }
                                }
                            }
                        }
                    },
                    Cancel: function() {
				        $( this ).dialog( "close" );
			        },
                 }       
            });
	    }
	});
}

function AddButtonClick() {
	
 $('#div-add-user').dialog({ modal: true, width: 350, height: 250, resizable: false,
            buttons: {
				Add: function(data) {
                    var un = $('#CUsername').val()
                    var pass = $('#CPassword').val()
                    var fn = $('#CFullName').val()
                    var email = $('#Cmail').val()
                    var golemaBukva = /[A-Z]/.test(pass)
                    var specijalenZnak = /[*\W]/.test(pass)
                    
                    	  if(fn==''){
                                alert("Внесете целосно име")
                                //mymsg(dic("enterUser", lang))  
                            }else{
                                if(un==''){
                                    alert("Внесете корисничко име")
                                    //mymsg(dic("enterFull", lang)) 
                                }
                                else{
                                    if(pass==''){
                                        alert("Внесете лозинка")
                                        //mymsg(dic("enterPass", lang))  
                                    }
                                    else{
                                    if(pass.length<6 || golemaBukva==0 || specijalenZnak==0)
                                            {
                                            	alert("Лозинката мора да има минимум 6 карактери,1 голема буква и 1 специјален знак.")
                                            }
                                   else{
                                        if(email==''){
                                            alert("Внесете e-mail")
                                            //mymsg(dic("enterEmail", lang)) 
                                        }
                                        else{
                                    $.ajax({
		                              url: "AddUser.php?fn="+fn+"&un="+un+"&pass="+pass+"&email="+email,
		                              context: document.body,
		                              success: function(data){
		                              if(data == 1)
		                              {
		                              	alert("Веќе постои корисник со такво корисничко име! Внесете ново име.")
		                              	//return false;
		                              }
		                              else
		                              {
		                              	alert("Успешно внесен корисник!")
					    			  	$('#lbUsers').html($('#lbUsers').html()+'<option value="'+data+'")">'+fn+'</option>')
					    			  	$( this ).dialog( "close" );
					    			  	window.location.reload();
			                          }
			                         
		                              
		                              }
		                            });	
                                   
                                    
                                	 
                                   }
                                 }
                               }
                               }
                             }
                           },
       			 Close: function() {
					    $( this ).dialog( "close" );
				    }
               }
         });    
    }

    

function DelButtonClick(id) {
    var _role = document.getElementById("usr_"+id).title;
    if(_role == "3"){
        $('#div-del-user').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: {
				    Yes: function() {
                        var id = $('#lbUsers').val()
                            $.ajax({
		                        url: "DelUser.php?id="+id,
		                        context: document.body,
		                        success: function(data){
		                        $("#lbUsers option:selected").remove();
		                        window.location.reload();
								}
		                    });	
                            $( this ).dialog( "close" );
				    },
                    No: function() {
					    $( this ).dialog( "close" );
				    }
               }
         });
    } else {
        $('#div-del-admin').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: {
                    Close: function() {
					    $( this ).dialog( "close" );
				    }
               }
         });    
    }
}


function AddUserSettings(){
   /* var AppSettings = '0'
    if( document.getElementById("SDradio1").checked == true){AppSettings=1}
    if( document.getElementById("SDradio2").checked == true){AppSettings=2}
    if( document.getElementById("SDradio3").checked == true){AppSettings=3}
    var DefLanguage = '0'
    if( document.getElementById("DLRadio1").checked == true){DefLanguage=1}
    if( document.getElementById("DLRadio2").checked == true){DefLanguage=2}
    if( document.getElementById("DLRadio3").checked == true){DefLanguage=3}*/
    /*var AMapsGoogle='0'
    if(document.getElementById("AMcheck1").checked == true){AMapsGoogle='1'}
    var AMapsOMS='0'
    if(document.getElementById("AMcheck2").checked == true){AMapsOMS='1'}
    var AMapsBing='0'
    if(document.getElementById("AMcheck3").checked == true){AMapsBing='1'}
    var AMapsYahoo='0'
    if(document.getElementById("AMcheck4").checked == true){AMapsYahoo='1'}
    var Satellite='0'
    if(document.getElementById("AMcheck5").checked == true){Satellite='1'}*/
   // debugger;
    var DateFormat = 'dd-MM-yyyy'
    DateFormat= $('#cbDate').val()
    var datetimeformat="";
    if($('#cbTime').val() == "24 Hour Time")
    	var _t = "HH:mm:ss";
	else
		var _t = "hh:mm:ss";
	datetimeformat = $('#cbDate').val() + " " + _t;
 	
    var DefMap = '0'
    if(document.getElementById("DMRadio1").checked == true){DefMap='GOOGLEM'}
    if(document.getElementById("DMRadio2").checked == true){DefMap='OSMM'}
    if(document.getElementById("DMRadio3").checked == true){DefMap='BINGM'}
    if(document.getElementById("DMRadio4").checked == true){DefMap='YAHOOM'}
    //if(document.getElementById("DMRadio5").checked == true){DefMap=5}
    //var TimeFormat = '24 Hour Time'
    //TimeFormat= $('#cbTime').val()*/
    
    var EngineON=0
    EngineON = $('#EONColor').val()
    var EngineOFF=0
    EngineOFF = $('#EOFFColor').val()
    var EngineOFFPassengerON=0
    EngineOFFPassengerON = $('#EOFF-PON-Color').val()
    var SatelliteOFF=0
    SatelliteOFF = $('#LSColor').val()
    var taximeteron=0
    taximeteron = $('#TONColor').val()
    var TaximeterOFFPassengerON=0
    TaximeterOFFPassengerON = $('#TOFF-PON-Color').val()
    var PassiveON=0
    PassiveON = $('#EColor').val()
    //novite setinzi so se vo sredina
    var datetime='0'
    if( document.getElementById("datetime").checked == true){datetime=1}
    var speed='0'
    if( document.getElementById("speed").checked == true){speed=1}
    var location='0'
    if( document.getElementById("location").checked == true){location=1}
    var poi='0'
    if( document.getElementById("poi").checked == true){poi=1}
    var zone='0'
    if( document.getElementById("zone").checked == true){zone=1}
    var passengers='0'
    if( document.getElementById("passengers").checked == true){passengers=1}
    var taximeter='0'
    if( document.getElementById("taximeter").checked == true){taximeter=1}
    var fuel='0'
    if( document.getElementById("fuel").checked == true){fuel=1}
    var active='0'
    if( document.getElementById("cbOnOff").checked == true){active=1}

    var trace =0
    trace = $('#TimeTrack').val()
    var idleOver =0
    idleOver = $('#idleOverTime').val()
    var Kilometri ='km'
    if( document.getElementById("metric").checked == true){Kilometri="km"}
    if( document.getElementById("imperial").checked == true){Kilometri="metric"}
    var show = '1'
    if(document.getElementById("cbOnOff").checked == true){show = '1'} else {show = '0'}
	var start='0'
	start = $('#start').val()
    var km_start='0'
    km_start = $('#km_start').val()
    var cena_km='0'
    cena_km = $('#cena_km').val()
    
    var string = "SaveUserSettings.php?datetimeformat="+datetimeformat+"&DefMap="+DefMap+"&EngineON="+EngineON+"&EngineOFF="+EngineOFF+"&EngineOFFPassengerON="+EngineOFFPassengerON+"&SatelliteOFF="+SatelliteOFF+"&taximeteron="+taximeteron+"&TaximeterOFFPassengerON="+TaximeterOFFPassengerON+"&datetime="+datetime+"&PassiveON="+PassiveON+"&speed="+speed+"&location="+location+"&poi="+poi+"&zone="+zone+"&passengers="+passengers+"&taximeter="+taximeter+"&fuel="+fuel+"&trace="+trace+"&idleOver="+idleOver+"&metric="+Kilometri+"&active="+active+"&start="+start+"&km_start="+km_start+"&cena_km="+cena_km;
	$.ajax({
        url: string,
        context: document.body,
        success: function(data){
            //mymsg(dic("succSaved", lang))  
            alert("Успешно зачувано.")
            window.location.reload();
        }
    });
}
//function OnOffChange(){
//    if(document.getElementById("cbOnOff").checked == true){
//        document.getElementById("laOnOff").InnerHTML = 'ON';
//    }   
//    if(document.getElementById("cbOnOff").checked == false){
//        document.getElementById("laOnOff").InnerHTML = 'OFF';
//    }  
//}

function AddPriviliges(){
    var AddPOI ='0'
    if( document.getElementById("LTAPOI").checked == true){AddPOI=1}
    var ViewPOI ='0'
    if( document.getElementById("LTVPOI").checked == true){ViewPOI=1}
    var AddZones ='0'
    if( document.getElementById("LTAZ").checked == true){AddZones=1}
    var ViewZones ='0'
    if( document.getElementById("LTVZ").checked == true){ViewZones=1}
    var Dashboard ='0'
    if( document.getElementById("RDash").checked == true){Dashboard=1}
    var FleetReport ='0'
    if( document.getElementById("RFleet").checked == true){FleetReport=1}
    var Overview ='0'
    if( document.getElementById("ROver").checked == true){Overview=1}
    var ShortReport ='0'
    if( document.getElementById("RShort").checked == true){ShortReport=1}
    var DetailReport ='0'
    if( document.getElementById("RDetail").checked == true){DetailReport=1}
    var VisitedPOI ='0'
    if( document.getElementById("RPOI").checked == true){VisitedPOI=1}
    var Reconstruction ='0'
    if( document.getElementById("RRecon").checked == true){Reconstruction=1}
    var Distance ='0'
    if( document.getElementById("RDist").checked == true){Distance=1}
    var Activity ='0'
    if( document.getElementById("RActivity").checked == true){Activity=1}
    var MaxSpeed ='0'
    if( document.getElementById("RMAx").checked == true){MaxSpeed=1}
    var TaxiReport ='0'
    //if( document.getElementById("RTaxi").checked == true){TaxiReport=1}
    var GeoFenceReport ='0'
    if( document.getElementById("RGeoFence").checked == true){GeoFenceReport=1}
    var SpeedLimit ='0'
    if( document.getElementById("RSpeed").checked == true){SpeedLimit=1}
    var ExportExcel ='0'
    if( document.getElementById("RExel").checked == true){ExportExcel=1}
    var ExportPdf ='0'
    if( document.getElementById("RPdf").checked == true){ExportPdf=1}
    var SendMail ='0'
    if( document.getElementById("RSend").checked == true){SendMail=1}
    var Schedule ='0'
    if( document.getElementById("RShe").checked == true){Schedule=1}
    var uid = 0
    var cbLive = 0
    if(document.getElementById("cbLive").checked == true){cbLive=1}
    var cbReports = 0
    if(document.getElementById("cbReports").checked == true){cbReports=1}
    var cbSettings = 0
    if(document.getElementById("cbSettings").checked == true){cbSettings=1}
    var USet = 0
    if(document.getElementById('USet').checked == true){USet=1}
    var CSet = 0
    if(document.getElementById('CSet').checked == true){CSet=1}
    var Priv = 0
    if(document.getElementById('Priv').checked == true){Priv=1}
    var POI = 0
    if(document.getElementById('POI').checked == true){POI=1}
     var GeoFence = 0
    if(document.getElementById('GeoFence').checked == true){GeoFence=1}
    if($('#lbUsers').val()==null)
    {
       mymsg(dic("selUser", lang)) 
       return
    }
    uid = $('#lbUsers').val()
    var string = "SavePrivilegies.php?uid="+uid+"&AddPOI="+AddPOI+"&ViewPOI="+ViewPOI+"&AddZones="+AddZones+"&ViewZones="+ViewZones+"&Dashboard="+Dashboard+"&FleetReport="+FleetReport+"&Overview="+Overview+"&ShortReport="+ShortReport+"&DetailReport="+DetailReport+"&VisitedPOI="+VisitedPOI+"&Reconstruction="+Reconstruction+"&Distance="+Distance+"&Activity="+Activity+"&MaxSpeed="+MaxSpeed+"&SpeedLimit="+SpeedLimit+"&ExportExcel="+ExportExcel+"&ExportPdf="+ExportPdf+"&SendMail="+SendMail+"&Schedule="+Schedule+"&cbLive="+cbLive+"&cbReports="+cbReports+"&cbSettings="+cbSettings+"&USet="+USet+"&CSet="+CSet+"&Priv="+Priv+"&TaxiReport="+TaxiReport+"&GeoFenceReport="+GeoFenceReport+"&POI="+POI+"&GeoFence="+GeoFence;
    $.ajax({
        url: string, 
        context: document.body,
        success: function(data){
            mymsg(dic("succSaved", lang))   
        }
    });
}
function checkedAll(frmname)
{
	 
	 var valus= document.getElementById(frmname);
	 if (checked==false)
	 {
	 	checked=true;
	 }
	 else
	 {
	 	checked = false;
	 }
	 for (var i =0; i < $('#chfind_'+frmname).children().children().length; i++)
	 {
	 	$('#chfind_'+frmname).children().children()[i].children[0].children[0].checked = checked;
	 }
}

function SearchPOI(){
    var element = document.getElementById('search')
    var list = document.getElementById('div-lbPOI')
    var id = 0
    var str = ''

//    if(list.childNodes.length > 0){
//        for(var i=0;i<list.childNodes.length;i++){
//            alert(list.childNodes[i].tagName)
//        }
//    }
    if(element.value == ''){
         if(list.childNodes.length > 0){
            for(var k=0;k<list.childNodes.length;k++){
                if(list.childNodes[k].tagName == 'INPUT'){
                    id = list.childNodes[k].alt
                    $('#box_'+id).show()
                    $('#chfind_'+id).show()
                }
            }
         }
    }else{
        if(list.childNodes.length > 0){
            for(var j=0;j<list.childNodes.length;j++){
                //alert(list.childNodes[i].tagName)
                if(list.childNodes[j].tagName == 'INPUT'){
                    id = list.childNodes[j].alt
                    //alert(id)
                }
                if(list.childNodes[j].tagName == 'LABEL'){
                    str = $('#chfind_'+id).html()
                    var baraj = element.value
                    //alert(RegExp)
                    if(str.search(new RegExp(baraj, "i")) == -1){
                        $('#box_'+id).hide()
                        $('#chfind_'+id).hide()
                    }else{
                        $('#box_'+id).show()
                        $('#chfind_'+id).show()   
                    }
                }
                //alert(element.value)
                //alert(str.search(/element.value/i))
                
            }
       }
    }
}

function ShowVehicles(_uid)
{
    var uid = _uid;
    var selected = ''
    ShowWait()
    $.ajax({
        url: "UserVehicles.php?uid="+uid+"&l=" + lang,
        context: document.body,
        success: function(data){
            HideWait()
            $('#div-vehicles-user').html(data)
            $('#div-vehicles-user').dialog({  modal: true, width: 800, height: 600, resizable: false,
                 buttons: {
				    Yes: function() {
              		 
              		   var inputs = document.getElementsByTagName("input");
					         for (var i = 0; i < inputs.length; i++) {
                                 if (inputs[i].type == "checkbox") {

                                     if (inputs[i].checked && inputs[i].value != "*") {
                                         selected += inputs[i].value + "*"
                                     }
                                 }
                             }
                      
                            if (selected != "") {
                                 $.ajax({
                                     url: "InsertUserVehicles.php?selected=" + selected + "&uid="+uid,
                                context: document.body,
		                        success: function(){
                                    window.location.reload();
		                        }
		                    });	
                         $( this ).dialog( "close" );
                        }
                    },
                    Cancel: function() {
					    $( this ).dialog( "close" );
				    },
                }
               
            })
        }
    });
}
function AddPriButtonClick() {
    var uid = $('#lbPUsers').val()
    ShowWait()
    $.ajax({
        url: "Privilegies.php?uid="+uid,
        context: document.body,
        success: function(data){
            HideWait()
            $('#div-priv-user').html(data)
        }
    });
}

function mymsg(msg){
	$('#div-msgbox').html(msg)
	$( "#dialog:ui-dialog" ).dialog( "destroy" );	
	$( "#dialog-message" ).dialog({ height: 170, width: 300,
		modal: true,
        resizable: false,
		zIndex: 9999 ,
		buttons: {
			Ok: function() {
				$( this ).dialog( "close" );
			}
		}
	});
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
	var cls = document.getElementById('menu-'+id).className;
	if (cls=='menu-container-collapsed') {
		//
		document.getElementById('menu-title-'+id).className='menu-title text3'
		var h=document.getElementById('menu-container-'+id).offsetHeight
		h = h+20+20
		$('#menu-'+id).animate({height:h+'px'},'fast', function(){document.getElementById('menu-'+id).className='menu-container'});
		return
	} else {
		document.getElementById('menu-'+id).className='menu-container-collapsed'
		document.getElementById('menu-title-'+id).className='menu-title-collapsed text3'
		$('#menu-'+id).animate({height:'33px'},'fast');
		return
	}
	iPad_Refresh()
}

function SetHeightSettings(){
	var _h = document.body.clientHeight;
	var _l = (document.body.clientWidth-100)/2;
	$('#report-content').css({height:(_h-105)+'px'});
	$('#ifrm-cont').css({height:(_h-95)+'px'});
	$('#div-menu').css({height:(_h-32)+'px'});
	$('#div-loading').css({left:(_l)+'px'});
    $('#optimizedNarrative').css({left: (document.body.clientWidth - parseInt($('#optimizedNarrative').css('width'), 10) - 12)+'px'});
    $('#advancedNarrative').css({left: (document.body.clientWidth - parseInt($('#advancedNarrative').css('width'), 10) - 12)+'px'});
    $('#showElevationChart').css({left: (document.body.clientWidth - parseInt($('#showElevationChart').css('width'), 10) - 12)+'px'});
    $('#showElevationChart').css({top: '440px'});
}

function EnableDisableSettings(no){
    if(no==1){
        if(document.getElementById('cbLive').checked == true){
            //$('#LTAPOI').button("enable", "refresh")
            document.getElementById("LTAPOI").disabled = false;
            document.getElementById("LTVPOI").disabled = false;
            document.getElementById("LTAZ").disabled = false;
            document.getElementById("LTVZ").disabled = false;
        }else{
            //$('#LTAPOI').button("disable", "refresh");
            document.getElementById("LTAPOI").disabled = true;
            document.getElementById("LTVPOI").disabled = true;
            document.getElementById("LTAZ").disabled = true;
            document.getElementById("LTVZ").disabled = true;
        }
    }
    if(no==2){
        if(document.getElementById('cbReports').checked == true){
            document.getElementById("RDash").disabled = false;
            document.getElementById("RFleet").disabled = false;
            document.getElementById("ROver").disabled = false;
            document.getElementById("RShort").disabled = false;
            document.getElementById("RDetail").disabled = false;
            document.getElementById("RPOI").disabled = false;
            document.getElementById("RRecon").disabled = false;
            document.getElementById("RDist").disabled = false;
            document.getElementById("RActivity").disabled = false;
            document.getElementById("RMAx").disabled = false;
            //document.getElementById("RTaxi").disabled = false;
            document.getElementById("RGeoFence").disabled = false;
            document.getElementById("RSpeed").disabled = false;
            document.getElementById("RExel").disabled = false;
            document.getElementById("RPdf").disabled = false;
            document.getElementById("RSend").disabled = false;
            document.getElementById("RShe").disabled = false;
        }else{
            document.getElementById("RDash").disabled = true;
            document.getElementById("RFleet").disabled = true;
            document.getElementById("ROver").disabled = true;
            document.getElementById("RShort").disabled = true;
            document.getElementById("RDetail").disabled = true;
            document.getElementById("RPOI").disabled = true;
            document.getElementById("RRecon").disabled = true;
            document.getElementById("RDist").disabled = true;
            document.getElementById("RActivity").disabled = true;
            document.getElementById("RMAx").disabled = true;
            //document.getElementById("RTaxi").disabled = true;
            document.getElementById("RGeoFence").disabled = true;
            document.getElementById("RSpeed").disabled = true;
            document.getElementById("RExel").disabled = true;
            document.getElementById("RPdf").disabled = true;
            document.getElementById("RSend").disabled = true;
            document.getElementById("RShe").disabled = true;
        }
    }
    if(no==3){
        if(document.getElementById('cbSettings').checked == true){
            document.getElementById("USet").disabled = false;
            document.getElementById("CSet").disabled = false;
            document.getElementById("Priv").disabled = false;
            document.getElementById("POI").disabled = false;
            document.getElementById("GeoFence").disabled = false;
        }else{
            document.getElementById("USet").disabled = true;
            document.getElementById("CSet").disabled = true;
            document.getElementById("Priv").disabled = true;
            document.getElementById("POI").disabled = true;
            document.getElementById("GeoFence").disabled = true;
        }
    }
}
function ShowWait(txt){
	if (txt==null) {txt = '' + dic("wait", lang) + ''}
	var wobj = document.getElementById('div-please-wait')
	var wobjb = document.getElementById('div-please-wait-back')
	var wobjc = document.getElementById('div-please-wait-close')
	
	var _w = 200
	var _h = 30
	var _l = (document.body.clientWidth-_w)/2
	var _t = (document.body.clientHeight-_h)/3

	
	imgPath = '../images/'
	if (wobj == null) {
		wobj = Create(document.body, 'div', 'div-please-wait')
		wobjb = Create(document.body, 'div', 'div-please-wait-back')
		wobjc = Create(document.body, 'div', 'div-please-wait-close')
		//wobjc.src = './images/smallClose.png'
		$(wobjc).css({position:'absolute', width:'16px', height:'16px', left:(_l+_w-10)+'px', top:(_t+12)+'px',zIndex:19999, cursor:'pointer', display:'block', backgroundImage:'url('+imgPath+'closeSmall.png)', backgroundPosition:'0px -16px'})
		$(wobjb).css({position:'absolute', width:document.body.clientWidth+'px', height:document.body.clientHeight+'px', position:'absolute', zIndex:19997, backgroundImage:'url('+imgPath+'backLoading.png)', opacity:0.2, left:'0px', top:'0px'})
		$(wobj).css({width:_w+'px', height:_h+'px', zIndex:'19998', border:'1px solid #5C8CB9', backgroundColor:'#fff', position:'absolute', left:_l+'px', top:_t+'px', padding:'5px 5px 5px 5px'})
		wobj.className='corner5 shadow'
		$(wobj).show()
		$(wobj).html('<img src="'+imgPath+'ajax-loader.gif" style="width:31; height:31" align="absmiddle">&nbsp;<span class="text1" style="color:#5C8CB9; font-weight:bold; font-size:11px">'+txt+'</span>')
		$(wobjc).mousemove(function(event) {ShowPopup(event, dic("cancelOper", lang)); $('#div-please-wait-close').css("backgroundPosition","0px 0px")  });
		$(wobjc).mouseout(function() {HidePopup(); $('#div-please-wait-close').css("backgroundPosition","0px -16px") });
		$(wobjc).click(function(event) {HideWait()});
	
	} else {
	    $('#div-please-wait').show()
	    $('#div-please-wait-back').show()
	    $('#div-please-wait-close').show()
	}
}


function HideWait(){
    $('#div-please-wait').hide()
	$('#div-please-wait-back').hide()
	$('#div-please-wait-close').hide()
	
}

function ShowPOI() {
    var gid = $('#lbGroups').val()
    //alert(gid)
    ShowWait()
    $.ajax({
        url: "POI.aspx?gid="+gid,
        context: document.body,
        success: function(data){
            HideWait()
            $('#div-lbPOI').html(data)
        }
    });
}

function AddGroupButtonClick() {
    $('#div-Add-Group').dialog({ modal: true, width: 350, height: 170, resizable: false,
            buttons: {
				Add: function() {
                    var gn = $('#GroupName').val()
                    var color = $('#clickAny').val()
                    color = color.replace("#","")
                    if (gn=='') {
                        mymsg(dic("enterGroupName", lang))     
                    } else {
                       $.ajax({
		                    url: "AddGroup.aspx?gn="+gn+"&color="+color,
		                    context: document.body,
		                    success: function(data){
			                    $('#lbGroups').html($('#lbGroups').html()+'<option value="'+data+'")">'+gn+'</option>')
		                    }
		                });	
                        $( this ).dialog( "close" ); 
                    }
				},
                Cancel: function() {
					$( this ).dialog( "close" );
				},

			}

     });
}

var GlobalGN = ''
function EditGroupClick(){
     if($('#lbGroups').val()==null){
        mymsg(dic("selGroupEdit", lang)) 
        return
     }
     if($('#lbGroups').val()==1){
        mymsg(dic("groupCannotMod", lang)) 
        return
     }
        var id = $('#lbGroups').val()
        $.ajax({
		    url: "EditGroup.aspx?id="+id,
		    context: document.body,
		    success: function(data){
			    $('#div-Edit-Group').html(data)
                $('#div-Edit-Group').dialog({ modal: true, width: 350, height: 170, resizable: false,
                     buttons: {
				        OK: function() {
                            var gn = $('#GroupName1').val()
                            var color = $('#clickAny1').val()
                            color = color.replace("#","")
                            GlobalGN = gn
                            if(gn==''){
                                mymsg(dic("enterGroupName", lang))    
                            }else{
                                $.ajax({
		                            url: "UpGroup.aspx?gn="+gn+"&color="+color+"&id="+id,
		                            context: document.body,
		                            success: function(data){
                                        $('#gr_'+data).html(GlobalGN)
		                            }
		                        });	
                                $( this ).dialog( "close" );
                            }
                        },
                        Cancel: function() {
					        $( this ).dialog( "close" );
				        },
                     }       
                });
		    }
		});
       
}

function DelGroupButtonClick() {
    if($('#lbGroups').val()==null)
    {
        mymsg(dic("selGroupDel", lang)) 
        return
    }
    if($('#lbGroups').val()==1){
        mymsg(dic("groupCannotMod", lang)) 
        return
     }

    $('#div-del-group').dialog({ modal: true, width: 350, height: 170, resizable: false,
            buttons: {
				'Delete Only Group': function() {
                    var id = $('#lbGroups').val()
                        $.ajax({
		                    url: "DelGroup.aspx?id="+id+"&b=1",
		                    context: document.body,
		                    success: function(data){
			                   $('#gr_'+data).remove()
		                    }
		                });	
                        $( this ).dialog( "close" );
				},
                'Delete With POI': function() {
                    var id = $('#lbGroups').val()
                        $.ajax({
		                    url: "DelGroup.aspx?id="+id+"&b=2",
		                    context: document.body,
		                    success: function(data){
			                   $('#gr_'+data).remove()
		                    }
		                });	
                        $( this ).dialog( "close" );
				},
                No: function() {
					$( this ).dialog( "close" );
				}
           }
     });
}

function SelectAll(){
    var element = document.getElementById('checkAll')
    var list = document.getElementById('div-lbPOI')
    if(element.checked == true){
        if(list.childNodes.length > 0){
            for(var i=0;i<list.childNodes.length;i++){
                if(list.childNodes[i].tagName == 'INPUT'){
                    list.childNodes[i].checked = true
                }
            }
        }
    }
    else{
        if(list.childNodes.length > 0){
            for(var i=0;i<list.childNodes.length;i++){
                list.childNodes[i].checked = false
            }
        }
    }
}

var GlobalPOIN=''
function BtnEditPOI(){
    var list = document.getElementById('div-lbPOI')
    var count = 0
    var broj =0
    var element=''
    if(list.childNodes.length > 0){
        for(var i=0;i<list.childNodes.length;i++){
            if(list.childNodes[i].checked == true){
                count += 1
                broj = i
            }
        }
        if(count > 1 || count == 0){
            mymsg(dic("mustOnePoiMod", lang)) 
            return
        }else{
            if(count == 1){
                var id = list.childNodes[broj].alt
                $.ajax({
		            url: "EditPOI.aspx?id="+id,
		            context: document.body,
		            success: function(data){
			            $('#div-Edit-POI').html(data)
                        $('#div-Edit-POI').dialog({ modal: true, width: 350, height: 170, resizable: false,
                             buttons: {
				                OK: function() {
                                    var poin = $('#POIName').val()
                                    GlobalPOIN = poin
                                    if(poin==''){
                                        mymsg(dic("enterPoi", lang))  
                                    }else{
                                        $.ajax({
		                                    url: "UpPOI.aspx?poin="+poin+"&id="+id,
		                                    context: document.body,
		                                    success: function(data){
                                                $('#lab_'+data).text(GlobalPOIN)
		                                    }
		                                });	
                                        $( this ).dialog( "close" );
                                    }
                                },
                                Cancel: function() {
					                $( this ).dialog( "close" );
				                },
                             }       
                        });
		            }
		        });
            }
        }
    }
}

function BtnDelPOI() {
    var list = document.getElementById('div-lbPOI')
    var count = 0
    if(list.childNodes.length > 0){
        for(var i=0;i<list.childNodes.length;i++){
            if(list.childNodes[i].checked == true){
                count += 1
            }
        }
    }
    if(count == 0){
        mymsg(dic("mustPoiDel", lang)) 
        return
    }

    $('#div-del-POI').dialog({ modal: true, width: 350, height: 170, resizable: false,
            buttons: {
				Yes: function() {
                    for(var j=0;j<list.childNodes.length;j++){
                        if(list.childNodes[j].checked == true){
                            var id = list.childNodes[j].alt
                            $.ajax({
		                        url: "DelPOI.aspx?id="+id,
		                        context: document.body,
		                        success: function(data){
			                        $('#poi_'+data).remove()
                                    $('#lab_'+data).remove()
		                        }
		                    });
                        }
                    }
                    $( this ).dialog( "close" );
				},
                No: function() {
					$( this ).dialog( "close" );
				}
           }
     });
}

function BtnChangeGroup() {
    var list = document.getElementById('div-lbPOI')
    var count = 0
    if(list.childNodes.length > 0){
        for(var i=0;i<list.childNodes.length;i++){
            if(list.childNodes[i].checked == true){
                count += 1
            }
        }
    }
    if(count == 0){
        mymsg(dic("mustPoi", lang)) 
        return
    }

    $.ajax({
		url: "ChangeGroup.aspx",
		context: document.body,
		success: function(data){
			$('#div-Change-Group').html(data)
            $('#div-Change-Group').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: {
				    Yes: function() {
                        for(var j=0;j<list.childNodes.length;j++){
                            if(list.childNodes[j].checked == true){
                                var id = list.childNodes[j].alt
                                var gid = $('#cbGroup').val()
                                $.ajax({
		                            url: "UpPOIGroup.aspx?id="+id+"&gid="+gid,
		                            context: document.body,
		                            success: function(data){
			                            $('#poi_'+data).remove()
                                        $('#lab_'+data).remove()
		                            }
		                        });
                            }
                        }
                        $( this ).dialog( "close" );
				    },
                    No: function() {
					    $( this ).dialog( "close" );
				    }
               }
            });
        }
    });
}

function ClearSearch()
{
    var element = document.getElementById('search')
    element.value = ''
    SearchPOI()
}

//delot za Zoni (GeoFence)/////////////////////////////////////////////////////////////////////////////////
function ShowZones() {
    var gid = $('#lbGroups').val()
    ShowWait()
    $.ajax({
        url: "Zones.aspx?gid="+gid,
        context: document.body,
        success: function(data){
            HideWait()
            $('#div-lbZones').html(data)
        }
    });
}


var GlobalZone=''
function BtnEditZone(){
    var list = document.getElementById('div-lbZones')
    var count = 0
    var broj =0
    var element=''
    if(list.childNodes.length > 0){
        for(var i=0;i<list.childNodes.length;i++){
            if(list.childNodes[i].checked == true){
                count += 1
                broj = i
            }
        }
        if(count > 1 || count == 0){
            mymsg(dic("mustGeoFenceMod", lang)) 
            return
        }else{
            if(count == 1){
                var id = list.childNodes[broj].alt
                $.ajax({
		            url: "EditZone.aspx?id="+id,
		            context: document.body,
		            success: function(data){
			            $('#div-Edit-Zone').html(data)
                        $('#div-Edit-Zone').dialog({ modal: true, width: 370, height: 170, resizable: false,
                             buttons: {
				                OK: function() {
                                    var poin = $('#ZoneName').val()
                                    GlobalZone = poin
                                    if(poin==''){
                                        mymsg(dic("enterGFName", lang))   
                                    }else{
                                        $.ajax({
		                                    url: "UpZone.aspx?poin="+poin+"&id="+id,
		                                    context: document.body,
		                                    success: function(data){
                                                $('#labZ_'+data).text(GlobalZone)
		                                    }
		                                });	
                                        $( this ).dialog( "close" );
                                    }
                                },
                                Cancel: function() {
					                $( this ).dialog( "close" );
				                },
                             }       
                        });
		            }
		        });
            }
        }
    }
}

function btnDelZone() {
    var list = document.getElementById('div-lbZones')
    var count = 0
    if(list.childNodes.length > 0){
        for(var i=0;i<list.childNodes.length;i++){
            if(list.childNodes[i].checked == true){
                count += 1
            }
        }
    }
    if(count == 0){
        mymsg(dic("MustGFDel", lang)) 
        return
    }

    $('#div-del-Zone').dialog({ modal: true, width: 350, height: 170, resizable: false,
            buttons: {
				Yes: function() {
                    for(var j=0;j<list.childNodes.length;j++){
                        if(list.childNodes[j].checked == true){
                            var id = list.childNodes[j].alt
                            $.ajax({
		                        url: "DelZone.aspx?id="+id,
		                        context: document.body,
		                        success: function(data){
			                        $('#zone_'+data).remove()
                                    $('#labZ_'+data).remove()
		                        }
		                    });
                        }
                    }
                    $( this ).dialog( "close" );
				},
                No: function() {
					$( this ).dialog( "close" );
				}
           }
     });
}

function BtnChangeGroupZone() {
    var list = document.getElementById('div-lbZones')
    var count = 0
    if(list.childNodes.length > 0){
        for(var i=0;i<list.childNodes.length;i++){
            if(list.childNodes[i].checked == true){
                count += 1
            }
        }
    }
    if(count == 0){
        mymsg(dic("MustGF", lang)) 
        return
    }

    $.ajax({
		url: "ChangeGroupZone.aspx",
		context: document.body,
		success: function(data){
			$('#div-Change-Group-Zone').html(data)
            $('#div-Change-Group-Zone').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: {
				    Yes: function() {
                        for(var j=0;j<list.childNodes.length;j++){
                            if(list.childNodes[j].checked == true){
                                var id = list.childNodes[j].alt
                                var gid = $('#cbGroupZone').val()
                                $.ajax({
		                            url: "UpZoneGroup.aspx?id="+id+"&gid="+gid,
		                            context: document.body,
		                            success: function(data){
			                            $('#zone_'+data).remove()
                                        $('#labZ_'+data).remove()
		                            }
		                        });
                            }
                        }
                        $( this ).dialog( "close" );
				    },
                    No: function() {
					    $( this ).dialog( "close" );
				    }
               }
            });
        }
    });
}

function DelGroupButtonClick1() {
    if($('#lbGroups').val()==null)
    {
        mymsg(dic("SelGrDel", lang)) 
        return
    }
    if($('#lbGroups').val()==1){
        mymsg(dic("groupCannotMod", lang)) 
        return
     }

    $('#div-del-group').dialog({ modal: true, width: 350, height: 170, resizable: false,
            buttons: {
				'Delete Only Group': function() {
                    var id = $('#lbGroups').val()
                        $.ajax({
		                    url: "DelGroup.aspx?id="+id+"&b=1",
		                    context: document.body,
		                    success: function(data){
			                   $('#gr_'+data).remove()
		                    }
		                });	
                        $( this ).dialog( "close" );
				},
                'Delete With GeoFence': function() {
                    var id = $('#lbGroups').val()
                        $.ajax({
		                    url: "DelGroup.aspx?id="+id+"&b=3",
		                    context: document.body,
		                    success: function(data){
			                   $('#gr_'+data).remove()
		                    }
		                });	
                        $( this ).dialog( "close" );
				},
                No: function() {
					$( this ).dialog( "close" );
				}
           }
     });
}

function SelectAllZones(){
    var element = document.getElementById('checkAllZone');
    var list = document.getElementById('div-lbZones');
    if(element.checked == true){
        if(list.childNodes.length > 0){
            for(var i=0;i<list.childNodes.length;i++){
                if(list.childNodes[i].tagName == 'INPUT'){
                    list.childNodes[i].checked = true;
                }
            }
        }
    }
    else{
        if(list.childNodes.length > 0){
            for(var i=0;i<list.childNodes.length;i++){
                list.childNodes[i].checked = false
            }
        }
    }
}

//function SearchZone(){
//    var element = document.getElementById('searchZone')
//    var list = document.getElementById('div-lbZones')
//    var id = 0
//    var str = ''

//    if(element.value == ''){
//         if(list.childNodes.length > 0){
//            for(var k=0;k<list.childNodes.length;k++){
//                if(list.childNodes[k].tagName == 'INPUT'){
//                    id = list.childNodes[k].alt
//                    $('#zone_'+id).show()
//                    $('#labZ_'+id).show()
//                }
//            }
//         }
//    }else{
//        if(list.childNodes.length > 0){
//            for(var j=0;j<list.childNodes.length;j++){
//                //alert(list.childNodes[i].tagName)
//                if(list.childNodes[j].tagName == 'INPUT'){
//                    id = list.childNodes[j].alt
//                    //alert(id)
//                }
//                if(list.childNodes[j].tagName == 'LABEL'){
//                    str = $('#labZ_'+id).html()
//                    var baraj = element.value
//                    //alert(RegExp)
//                    if(str.search(new RegExp(baraj, "i")) == -1){
//                        $('#zone_'+id).hide()
//                        $('#labZ_'+id).hide()
//                    }else{
//                        $('#zone_'+id).show()
//                        $('#labZ_'+id).show()   
//                    }
//                }
//                //alert(element.value)
//                //alert(str.search(/element.value/i))
//                
//            }
//       }
//    }
//}

function ClearSearchZone()
{
    var element = document.getElementById('searchZone')
    element.value = ''
    SearchZone()
}

function AllowedVehicles()
{
    var list = document.getElementById('div-lbZones')
    var count = 0
    var broj =0
    var element=''
    var vehicles = '0'

    if(list.childNodes.length > 0){
        for(var i=0;i<list.childNodes.length;i++){
            if(list.childNodes[i].checked == true){
                count += 1
                broj = i
            }
        }
        if(count > 1 || count == 0){
            mymsg(dic("MustSelGFAdd", lang)) 
            return
        }else{
            if(count == 1){
                var aid = list.childNodes[broj].alt
                ShowWait()
                $.ajax({
                    url: "ZoneVehicles.aspx?aid="+aid,
                    context: document.body,
                    success: function(data){
                        HideWait()
                        $('#div-vehicles-user').html(data)
                        $('#div-vehicles-user').dialog({  modal: true, width: 300, height: 280, resizable: false,
                            buttons: {
                                OK: function(){
                                    var _vehicles = document.getElementById("div-vehicles-user")
                        
                                    if(_vehicles.childNodes.length > 0)
                                    {
                                        for (var x = 0; x < _vehicles.childNodes.length; x++)
                                        {
                                            if(_vehicles.childNodes[x].childNodes.length > 0)
                                            {
                                                if(_vehicles.childNodes[x].childNodes[0].checked == true)
                                                { vehicles = vehicles + ';' + _vehicles.childNodes[x].childNodes[0].id}
                                            }
                                        }
                                        $.ajax({
		                                    url: "InsertZoneVehicles.aspx?ve="+vehicles+"&aid="+aid,
		                                    context: document.body,
		                                    success: function(){
                                    
		                                    }
		                                });	
                                        $( this ).dialog( "close" );
                                    }
                                },
                                Cancel: function() {
					                $( this ).dialog( "close" );
				                },
                            }
                        })
                    }
                });
            }
        }
    }
}
function checkID(e, _id){
    
    if(e.target.id == _id)
        return true;
    else
        if(e.target.parentNode == null)
            return false;
        else
            if(e.target.parentNode.id == _id)
                return true;
            else
                if(e.target.parentNode.parentNode == null)
                        return false;
                else
                    if(e.target.parentNode.parentNode.id == _id)
                        return true;
                    else
                        if(e.target.parentNode.parentNode.parentNode == null)
                            return false;
                        else
                            if(e.target.parentNode.parentNode.parentNode.id == _id)
                                return true;
                            else
                                if(e.target.parentNode.parentNode.parentNode.parentNode == null)
                                    return false;
                                else
                                    if(e.target.parentNode.parentNode.parentNode.parentNode.id == _id)
                                        return true;
                                    else
                                        if(e.target.parentNode.parentNode.parentNode.parentNode.parentNode == null)
                                            return false;
                                        else
                                            if(e.target.parentNode.parentNode.parentNode.parentNode.parentNode.id == _id)
                                                return true;
                                            else
                                                if(e.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode == null)
                                                    return false;
                                                else
                                                    if(e.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.id == _id)
                                                        return true;
                                                    else
                                                        return false;
}
var divElById1, divElById2, _index;
function getElById(_el1, _el2){
    divElById1 = null;
    if(document.getElementById(_el1) != null)
    {
        divElById1 = document.getElementById(_el1);
        divElById2 = document.getElementById(_el2);
        _index = 1;
    } 
    if(document.getElementById("ifrm-cont") != null)
    {
        divElById1 = document.getElementById("ifrm-cont").contentWindow.document.getElementById(_el1);
        divElById2 = document.getElementById("ifrm-cont").contentWindow.document.getElementById(_el2);
        _index = 2;
    }
    if(document.getElementById("iframemaps") != null)
    {
        divElById1 = document.getElementById("iframemaps").contentWindow.document.getElementById(_el1);
        divElById2 = document.getElementById("iframemaps").contentWindow.document.getElementById(_el2);
        _index = 3;
    }
    if(document.getElementById("i-show-geo") != null)
    {
        divElById1 = document.getElementById("i-show-geo").contentWindow.document.getElementById(_el1);
        divElById2 = document.getElementById("i-show-geo").contentWindow.document.getElementById(_el2);
        _index = 4;
    }
    if(document.getElementById("i-show-poi") != null)
    {
        divElById1 = document.getElementById("i-show-poi").contentWindow.document.getElementById(_el1);
        divElById2 = document.getElementById("i-show-poi").contentWindow.document.getElementById(_el2);
        _index = 5;
    }
}
function closeDiv(e, num){
    if (divElById1 != null && e.target.id != divElById2.id)
        if ($(divElById1).css('display') == "block") {
            var bool = checkID(e, divElById1.id);
            if(!bool)
            {
                if(_index == 1)
                    checkCheck(num);
                else
                    if(_index == 2)
                        document.getElementById("ifrm-cont").contentWindow.checkCheck(num);
                    else
                        if(_index == 3)
                            document.getElementById("iframemaps").contentWindow.checkCheck(num);
                        else
                            if(_index == 4)
                                document.getElementById("i-show-geo").contentWindow.checkCheck(num);
                            else
                                if(_index == 5)
                                    document.getElementById("i-show-poi").contentWindow.checkCheck(num);
                $(divElById1).css({ display: 'none' });
                //alert(divElById2.id);
                if(divElById2.id.indexOf("icon") != -1)
                    $(divElById2).css({ backgroundPosition: '0px -144px' });
                else
                    $(divElById2).html('|&nbsp;&nbsp;&nbsp;▼');
            }
        }
}
function FindActivBoard(e)
{
    overId = e.target.id;
    if(overId == "")
        overId = e.target.parentNode.id;
    if(overId == "")
        overId = e.target.parentNode.parentNode.id;
    var _ab;
    if(e.target.id.indexOf("div-map-") != -1)
        _ab = e.target.id;
    else
        if(e.target.parentNode == null || e.target.parentNode.id == undefined)
            _ab = -1;
        else
            if(e.target.parentNode.id.indexOf("div-map-") != -1)
                _ab = e.target.parentNode.id;
            else
                if(e.target.parentNode.parentNode == null || e.target.parentNode.parentNode.id == undefined)
                    _ab = -1;
                else
                    if(e.target.parentNode.parentNode.id.indexOf("div-map-") != -1)
                        _ab = e.target.parentNode.parentNode.id;
                    else
                        if(e.target.parentNode.parentNode.parentNode == null || e.target.parentNode.parentNode.parentNode.id == undefined)
                            _ab = -1;
                        else
                            if(e.target.parentNode.parentNode.parentNode.id.indexOf("div-map-") != -1)
                                _ab = e.target.parentNode.parentNode.parentNode.id;
                            else
                                if(e.target.parentNode.parentNode.parentNode.parentNode == null || e.target.parentNode.parentNode.parentNode.parentNode.id == undefined)
                                    _ab = -1;
                                else
                                    if(e.target.parentNode.parentNode.parentNode.parentNode.id.indexOf("div-map-") != -1)
                                        _ab = e.target.parentNode.parentNode.parentNode.parentNode.id;
                                    else
                                        if(e.target.parentNode.parentNode.parentNode.parentNode.parentNode == null || e.target.parentNode.parentNode.parentNode.parentNode.parentNode.id == undefined)
                                            _ab = -1;
                                        else
                                            if(e.target.parentNode.parentNode.parentNode.parentNode.parentNode.id.indexOf("div-map-") != -1)
                                                _ab = e.target.parentNode.parentNode.parentNode.parentNode.parentNode.id;
                                            else
                                                if(e.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode == null || e.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.id == undefined)
                                                    _ab = -1;
                                                else
                                                    if(e.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.id.indexOf("div-map-") != -1)
                                                        _ab = e.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.id;
                                                    else
                                                        if(e.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode == null || e.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.id == undefined)
                                                            _ab = -1;
                                                        else
                                                            if(e.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.id.indexOf("div-map-") != -1)
                                                                    _ab = e.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.id;
                                                            else
                                                                _ab = -1;
    //document.getElementById("testText").value = _ab + "   |   " + SelectedBoard;
    if(_ab != -1)
    {
        _SB = parseInt(_ab.substring(_ab.length - 1, _ab.length), 10) - 1;
        //SelectBoard(_SB);
        SelectedBoard = _SB;
    }
    //document.getElementById("testText").value = _ab + "   |   " + SelectedBoard;
}
function HideWindows(e) {
    if(!(checkID(e, "div-chart-poi")) && !(checkID(e, "Routes")) && !(checkID(e, "MarkersIN")) && $("#div-chart-poi").css('display') == 'block' && e.target.id != "NewR")
        $("#div-chart-poi").css({ display: 'none' });
    
    FindActivBoard(e);
    if (document.getElementById("div-spliter") != null && e.target.id != "a-split")
        if ($('#div-spliter').css('display') == "block") {
            if ((e.target.id.indexOf("div-vspl") == -1) && (e.target.id.indexOf("a-spl") == -1) && (e.target.id.indexOf("div-hspl") == -1) && (e.target.id.indexOf("div-spliter") == -1) && (e.target.id.indexOf("div-split-mini") == -1) && (e.target.parentNode.id.indexOf("div-spliter") == -1))
            {
                $('#div-spliter').css({ display: 'none' });
                CancelSpliter();
            }
        }
    if (document.getElementById("div-activeBoard") != null && e.target.id != "activeBoard")
        if ($('#div-activeBoard').css('display') == "block")
            if ((e.target.id.indexOf("div-activeBoard") == -1) && (e.target.parentNode.id.indexOf("div-activeBoard") == -1) && (e.target.id.indexOf("ActiveW") == -1) && (e.target.id.indexOf("ActiveHeader") == -1)) {
                $('#div-activeBoard').css({ display: 'none' });
                $('#activeBoard').css({ backgroundPosition: '0px 0px' });
            }
    getElById("div-poiGUp", "div-allpoi");
    closeDiv(e, 3);
    getElById("div-GFUp", "div-allgf");
    closeDiv(e, 2);
    getElById("div-poiGroupUp", "icon-poi-down");
    closeDiv(e, 3);
    getElById("div-AreasUp", "icon-zone-down");
    closeDiv(e, 2);
    getElById("div-VehicleUp", "icon-draw-path-down");
    closeDiv(e, 1);

    for (var i = 0; i < 4; i++) {
        getElById("div-layer-switch-" + i, "div-layer-list-" + i);
        if (divElById1 != null) {
            if (e.target.id != divElById1.id)
                if ($(divElById2).css('display') == "block") {
                    if (e.target.id.indexOf(divElById2.id) == -1 && e.target.parentNode.id.indexOf(divElById2.id) == -1)
                    {
                        if(_index == 1)
                            ShowLayerList(i);
                        else
                            if(_index == 2)
                                document.getElementById("ifrm-cont").contentWindow.ShowLayerList(i);
                            else
                                if(_index == 3)
                                    document.getElementById("iframemaps").contentWindow.ShowLayerList(i);
                                else
                                    if(_index == 4)
                                        document.getElementById("i-show-geo").contentWindow.ShowLayerList(i);
                                    else
                                        if(_index == 5)
                                            document.getElementById("i-show-poi").contentWindow.ShowLayerList(i);
                    }
                }
            getElById("div-type-" + i, "div-layerType-list-" + i);
            if (e.target.id != divElById1.id)
                if ($(divElById2).css('display') == "block") {
                    if (e.target.id.indexOf(divElById2.id) == -1 && e.target.parentNode.id.indexOf(divElById2.id) == -1)
                    {
                        if(_index == 1)
                            SelectTypeMapLayer(i);
                        else
                            if(_index == 2)
                                document.getElementById("ifrm-cont").contentWindow.SelectTypeMapLayer(i);
                            else
                                if(_index == 3)
                                    document.getElementById("iframemaps").contentWindow.SelectTypeMapLayer(i);
                                else
                                    if(_index == 4)
                                        document.getElementById("i-show-geo").contentWindow.SelectTypeMapLayer(i);
                                    else
                                        if(_index == 5)
                                            document.getElementById("i-show-poi").contentWindow.SelectTypeMapLayer(i);
                    }
                }
            getElById("div-vehicle-chooser-" + i, "div-vehicle-list-" + i);
            if(divElById1 != null)
            {
                if (e.target.id != divElById1.id)
                    if ($(divElById2).css('display') == "block") {
                        if ((e.target.id.indexOf(divElById2.id) == -1) && (e.target.parentNode.id.indexOf(divElById2.id) == -1) && (e.target.parentNode.parentNode.id.indexOf(divElById2.id) == -1) && (e.target.parentNode.parentNode.parentNode.id.indexOf(divElById2.id) == -1) && (e.target.parentNode.parentNode.parentNode.parentNode.id.indexOf(divElById2.id) == -1) && (e.target.parentNode.parentNode.parentNode.parentNode.parentNode.id.indexOf(divElById2.id) == -1)) {
                            
                            if(_index == 1)
                                ShowHideVehicleList(i);
                            else
                                if(_index == 2)
                                    document.getElementById("ifrm-cont").contentWindow.ShowHideVehicleList(i);
                                else
                                    if(_index == 3)
                                        document.getElementById("iframemaps").contentWindow.ShowHideVehicleList(i);
                                    else
                                        if(_index == 4)
                                            document.getElementById("i-show-geo").contentWindow.ShowHideVehicleList(i);
                                        else
                                            if(_index == 5)
                                                document.getElementById("i-show-poi").contentWindow.ShowHideVehicleList(i);
                        }
                    }
            }
            getElById("div-vehicle-tofollow-" + i, "div-vehicleF-list-" + i);
            if(divElById1 != null)
            {
                if (e.target.id != divElById1.id)
                    if ($(divElById2).css('display') == "block") {
                        if ((e.target.id.indexOf(divElById2.id) == -1) && (e.target.parentNode.id.indexOf(divElById2.id) == -1) && (e.target.parentNode.parentNode.id.indexOf(divElById2.id) == -1)) {
                            if(_index == 1)
                                ShowHideVehicleFList(i);
                            else
                                if(_index == 2)
                                    document.getElementById("ifrm-cont").contentWindow.ShowHideVehicleFList(i);
                                else
                                    if(_index == 3)
                                        document.getElementById("iframemaps").contentWindow.ShowHideVehicleFList(i);
                                    else
                                        if(_index == 4)
                                            document.getElementById("i-show-geo").contentWindow.ShowHideVehicleFList(i);
                                        else
                                            if(_index == 5)
                                                document.getElementById("i-show-poi").contentWindow.ShowHideVehicleFList(i);
                        }
                    }
            }
            getElById("addNew-button-" + i, "div-add-list-" + i);
            if (e.target.id != divElById1.id)
                if ($(divElById2).css('display') == "block") {
                    if($('#save1-button-'+i).css('display') != "block") {
                        if (e.target.id.indexOf(divElById2.id) == -1 && e.target.parentNode.id.indexOf(divElById2.id) == -1 && e.target.parentNode.parentNode.id.indexOf(divElById2.id) == -1)
                        {
                            if(_index == 1)
                                ShowAddList(i);
                            else
                                if(_index == 2)
                                    document.getElementById("ifrm-cont").contentWindow.ShowAddList(i);
                                else
                                    if(_index == 3)
                                        document.getElementById("iframemaps").contentWindow.ShowAddList(i);
                                    else
                                        if(_index == 4)
                                            document.getElementById("i-show-geo").contentWindow.ShowAddList(i);
                                        else
                                            if(_index == 5)
                                                document.getElementById("i-show-poi").contentWindow.ShowAddList(i);
                        }
                    }
                }
            getElById("div-addRuler-" + i, "outputMeasure-" + i);
            if (e.target.id != divElById1.id)
                if ($(divElById2).css('display') == "block") {
                    if (e.target.id.indexOf(divElById2.id) == -1)
                    {
                        if(_index == 1)
                            toggleControl1('line', i);
                        else
                            if(_index == 2)
                                document.getElementById("ifrm-cont").contentWindow.toggleControl1('line', i);
                            else
                                if(_index == 3)
                                    document.getElementById("iframemaps").contentWindow.toggleControl1('line', i);
                                else
                                    if(_index == 4)
                                        document.getElementById("i-show-geo").contentWindow.toggleControl1('line', i);
                                    else
                                        if(_index == 5)
                                            document.getElementById("i-show-poi").contentWindow.toggleControl1('line', i);
                    }
                }
            getElById("div-addSearch-" + i, "div-addSearchNew-" + i);
            if (e.target.id != divElById1.id)
                if ($(divElById2).css('display') == "block") {
                    if (e.target.id.indexOf(divElById2.id) == -1 && e.target.id.indexOf("textSearch") == -1 && e.target.id.indexOf("imgSearch") == -1 && e.target.id.indexOf("outputSearch-" + i) == -1 && e.target.id.indexOf("imgSearchLoading") == -1 && e.target.id.indexOf("tab") == -1)
                    {
                        if(_index == 1)
                            SearchName(i, 1);
                        else
                            if(_index == 2)
                                document.getElementById("ifrm-cont").contentWindow.SearchName(i, 1);
                            else
                                if(_index == 3)
                                    document.getElementById("iframemaps").contentWindow.SearchName(i, 1);
                                else
                                    if(_index == 4)
                                        document.getElementById("i-show-geo").contentWindow.SearchName(i, 1);
                                    else
                                        if(_index == 5)
                                            document.getElementById("i-show-poi").contentWindow.SearchName(i, 1);
                    }
                }
        }
    }
}

function getCookie (c_name){
	if (document.cookie.length>0){
	    c_start=document.cookie.indexOf(c_name + "=");
	    if (c_start!=-1)
	    {
	        c_start=c_start + c_name.length+1;
	        c_end=document.cookie.indexOf(";",c_start);
	        if (c_end==-1)
                c_end=document.cookie.length;
	        return unescape(document.cookie.substring(c_start,c_end));
	    }
	}
	return "";
}

function setCookie (c_name,value,expiredays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}

function GetSettings() {
	return false

	if (this.SaveSettings == true) {
	    var zoom = this.getCookie('zoom' + this.nameGM);
	    var lon = this.getCookie('lon' + this.nameGM);
	    var lat = this.getCookie('lat' + this.nameGM);
	    var gl = this.getCookie('glob' + this.nameGM);
	    //alert(zoom + "   " + lon + "   " + lat + "   " + gl);
	    if ((zoom != '' && zoom != 'undefined') && (lat != '' && lat != 'undefined') && (lon != '' && lon != 'undefined') && (gl != '' && gl != 'undefined')) {
	        this.Lon = parseFloat(lon);
	        this.Lat = parseFloat(lat);
	        this.cZoom = parseInt(zoom);
	        //this.MapMode = gl;

            //KIKI - default map
	        var mapT = "";
	        if (this.getCookie('defaultMap') == 1)
	            mapT = "GLOBSY";
	        else
	            if (this.getCookie('defaultMap') == 2)
	                mapT = "OPENSTREET";
	            else
	                mapT = "GOOGLE";

	            this.MapMode = mapT;
            //KIKI - default map
	    }
	}
}
  
function AddPrivilegesSettings(_id){
	var lista =[];
	$("input:checked").each(function() {
	      lista.push($(this)[0].id);
	});
    var string = "SavePrivilegies.php?lista=" + lista + "&uid=" + _id;
    $.ajax({
        url: string,
        context: document.body,
        success: function(data){
            //mymsg(dic("succSaved", lang))  
            alert(dic("succSaved"),lang)
            //alert("Успешно зачувано.")
            window.location.reload();
        }
    });
}