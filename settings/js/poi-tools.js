

// ------- GLOBAL VARs -----------
haveData = true;
limit = 20;
dataOffset = 0;
currGroup = 0;	// momentalna grupa
GroupsInfo = [];	// tuka ke se cuvaat infromacii za grupite so poveke POI
isReady = true;	 // se odnesuva na scroll eventot i dali e zavrsen ajax call-ot
filter_have_data = true;

// -------------------------------

function fetchData(limit,offset,gpid) {
	// Loading();
	var groupPos = find_group(GroupsInfo,gpid);
	var isExpanded = (GroupsInfo[groupPos].firstExpand == true) ? 1 : 0;

	GroupsInfo[groupPos].firstExpand = true;
	console.log("GetPOIOffset.php?limit=" + limit + "&offset=" + offset + "&groupid=" + gpid + "&expanded=" + isExpanded + "&l=" + lang);
	$.ajax({
	    url: "GetPOIOffset.php?limit=" + limit + "&offset=" + offset + "&groupid=" + gpid + "&expanded=" + isExpanded + "&l=" + lang,
	    context: document.body,

	    success: function(data) {
	    	// HideWait();
	    	console.log("fetchData:" + limit + ", " + offset + ", " + gpid);

	    	if(Number(data) === 0) {
	    		console.log("NO DATA");
	    		dataOffset = 0;
	    		haveData = false;
	    		GroupsInfo[groupPos].haveData = false;
	    	} else {
	    		var getData = data;
	    		haveData = (getData < limit) ? false : true;

	    		$('#POI_data_' + gpid + ' table tbody').append(getData);
	    		$('#POI_data_' + gpid).show();
	    		buttonIcons();
	    		dataOffset+=limit;
	    		GroupsInfo[groupPos].haveData = haveData;
	    		GroupsInfo[groupPos].offset+=limit;
	    	}

	    isReady = true;
		goToByScroll("POI_group" + gpid,10);
	    }

	});
}

function show_group(_id) {

	currGroup = _id;

	var groupData = $('#POI_data_' + currGroup);
	var currPoints = numOfPoints[allGroups.indexOf(currGroup)];

	var inx = find_group(GroupsInfo,currGroup);

	if(inx == -1) { // ako ne e otvorena grupata

		GroupsInfo.push({gpid:currGroup, offset:0, numPOI: currPoints, expanded: false, clicked: false});
		inx = find_group(GroupsInfo,currGroup);
	}

	// ako se naogja vo rezim na prebaruvanje

	if($('#search_input').val() != '') {
		goToByScroll("POI_group" + currGroup,10);
		$('#POI_data_new_' + currGroup).slideToggle(100);
		return false;
	}

	// zastani tuka ako e vo rezim na prebaruvanje

	if(GroupsInfo[inx].expanded === false) {
		GroupsInfo[inx].expanded = true;
		if(currPoints !== 0) {
			$('#POI_group'+ currGroup +' .expand-icon').html("▼");
			$('#POI_group_header'+currGroup).show();
		}
	}
	else {
		GroupsInfo[inx].expanded = false;
		$('#POI_group'+ currGroup +' .expand-icon').html("▶");
		$('#POI_group_header'+currGroup).hide();


	}

	if(GroupsInfo[inx].clicked === false) {

		GroupsInfo[inx].clicked = true;
		dataOffset = 0;
		console.log("first DATA FETCH...");

		if(currPoints > limit) {

			GroupsInfo[inx].haveData = true;
			GroupsInfo[inx].firstExpand = false;
			groupData.css({ height: '500px',overflowY: 'auto'});

		} else {
			GroupsInfo[inx].haveData = false;
			GroupsInfo[inx].firstExpand = false;

		}

		fetchData(limit,dataOffset,currGroup);
		adjustWidth(currGroup);
		return false;

	}

	goToByScroll("POI_group" + currGroup,10);

	$('#POI_data_' + currGroup).slideToggle(100);


}

function first_expand(groupid){

	var currPoints = numOfPoints[allGroups.indexOf(groupid)];

	GroupsInfo.push({gpid:groupid, offset:0, numPOI: currPoints,});
	var inx = find_group(GroupsInfo,groupid);

	if (currPoints === 0) {
		console.log("ungrouped poi - empty");
	}
	else {
		GroupsInfo[inx].expanded = true;
		GroupsInfo[inx].firstExpand = false;

		$('#POI_group' + groupid + ' .expand-icon').html("▼");
		$('#POI_group_header'+groupid).show();

		GroupsInfo[inx].clicked = true;
		dataOffset = 0;

		console.log("first DATA FETCH...");

		if(currPoints > limit) {
			$('#POI_data_' + groupid).css({ height: '500px',overflowY: 'scroll'});
			adjustWidth(groupid);
		}

		fetchData(limit,dataOffset,groupid);


	}

}

function find_group (obj_arr, value) {
	var rez = -1;
	for(var i=0; i < obj_arr.length; i++){
		if(obj_arr[i].gpid == value) rez = i;
	}
	return rez;
}

function get_index (obj_arr, value) {
	var rez = -1;
	for(var i=0; i < obj_arr.length; i++){
		if(obj_arr[i].id == value) rez = i;
	}
	return rez;
}

Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};

function getTopOffset(id) {
	var eTop = $('#'+id).offset().top;
	var result = eTop - $(window).scrollTop();
	return (result > 0) ? result : 0 ;
}

function goToByScroll (id, offset){

	$('body,html').stop(true,true).animate({ scrollTop: ($("#"+id).offset().top - offset)}, 500);
}

function TopScroll() {
	$('body, html').stop(true,true).animate({scrollTop: 0}, 450);
}

// >>>>>>>>>>>>>>>>>>>>>> color functions  >>>>>>>>>>>>>>>>>>>>>>>
function color_title() {

    for (var i = 0; i < allGroups.length; i++) {
    	var get_color = $('#slider_'+allGroups[i]);
    	var selector = $('#POI_group'+allGroups[i]);

    	var bg_effect = chroma(get_color.css('background-color')).desaturate().hex();
    	var border_effect = chroma(get_color.css('background-color')).darken(20).hex();

    	selector.css('background-color',bg_effect);
    	selector.css({"border-color": border_effect, "border-width":"1px", "border-style":"solid"});


    }
}

function shadeColor(color, percent) {
    var f=parseInt(color.slice(1),16),t=percent<0?0:255,p=percent<0?percent*-1:percent,R=f>>16,G=f>>8&0x00FF,B=f&0x0000FF;
    return "#"+(0x1000000+(Math.round((t-R)*p)+R)*0x10000+(Math.round((t-G)*p)+G)*0x100+(Math.round((t-B)*p)+B)).toString(16).slice(1);
}

function blendColors(c0, c1, p) {
    var f=parseInt(c0.slice(1),16),t=parseInt(c1.slice(1),16),R1=f>>16,G1=f>>8&0x00FF,B1=f&0x0000FF,R2=t>>16,G2=t>>8&0x00FF,B2=t&0x0000FF;
    return "#"+(0x1000000+(Math.round((R2-R1)*p)+R1)*0x10000+(Math.round((G2-G1)*p)+G1)*0x100+(Math.round((B2-B1)*p)+B1)).toString(16).slice(1);
}

// RGB version --------------------------------------------

function shadeRGBColor(color, percent) {
    var f=color.split(","),t=percent<0?0:255,p=percent<0?percent*-1:percent,R=parseInt(f[0].slice(4)),G=parseInt(f[1]),B=parseInt(f[2]);
    return "rgb("+(Math.round((t-R)*p)+R)+","+(Math.round((t-G)*p)+G)+","+(Math.round((t-B)*p)+B)+")";
}

function blendRGBColors(c0, c1, p) {
    var f=c0.split(","),t=c1.split(","),R=parseInt(f[0].slice(4)),G=parseInt(f[1]),B=parseInt(f[2]);
    return "rgb("+(Math.round((parseInt(t[0].slice(4))-R)*p)+R)+","+(Math.round((parseInt(t[1])-G)*p)+G)+","+(Math.round((parseInt(t[2])-B)*p)+B)+")";
}

function shade_boxes(){
	for (var i = 1; i < allGroups.length; i++) {
		var select_box_color = $('#POI_group'+ allGroups[i] +' .poi-box').css('background-color');
		$('#POI_group'+ allGroups[i] +' .poi-box').css({"border-color": shadeRGBColor(select_box_color,-0.35), "border-width":"1px", "border-style":"solid"});
	}
}

// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>


function timedRefresh(timeoutPeriod) {
	setTimeout("location.reload(true);",timeoutPeriod);
}

function msgboxPetar(msg) {
	$("#DivInfoForAll").css({ display: 'none' });
	$('#div-msgbox').html(msg);
	$("#dialog:ui-dialog").dialog("destroy");
	$("#dialog-message").dialog({
	    modal: true,
	    zIndex: 9999, resizable: false,
	    buttons: {
	        Ok: function () {
	            if ($("#InfoForAll").checked)
	                setCookie(_userId + "_poiinfo", "1", 14);
	            else
	            $("#InfoForAll").checked = false;
	            $(this).dialog("close");
	        }
	    }
	});
}

function buttonIcons() {
	$('.btn-refresh-ui').button({ icons: { primary: "ui-icon-refresh"} });
	$('.btn-search-ui').button({ icons: { primary: "ui-icon-search"} });
	$('.btn-penci-ui').button({ icons: { primary: "ui-icon-pencil"} });
	$('.btn-trash-ui').button({ icons: { primary: "ui-icon-trash"} });

}

function prikazi() {

	var checked = $("input[class=case]:checked").length;
	if (checked === 0)
	{
		document.getElementById('brisiGrupno').style.display = 'none';
		document.getElementById('prefrliGrupno').style.display = 'none';
		document.getElementById('neaktivniGrupno').style.display = 'none';
	}
	else
	{
		document.getElementById('brisiGrupno').style.display = '';
		document.getElementById('prefrliGrupno').style.display = '';
		document.getElementById('neaktivniGrupno').style.display = '';
	}
}

function prikaziInactive()
{
	var checked = $("input[class=caseInactive]:checked").length;

	if (checked == 0)
	{
		document.getElementById('AktivirajGrupno').style.display = 'none';
	}
	else
	{
		document.getElementById('AktivirajGrupno').style.display = '';
	}
}

function changecolor()
	{
		$("#Color1").mlColorPicker({ 'onChange': function (val) {
    	$("#Color1").css("background-color", "" + val);
		}
	});
}

function Loading(txt){
	if (txt==null) {txt = '' + dic("wait", lang) + ''};
	var wobj = document.getElementById('div-please-wait');
	var wobjb = document.getElementById('div-please-wait-back');
	var wobjc = document.getElementById('div-please-wait-close');
	
	var _w = 200;
	var _h = 30;
	var _l = (document.body.clientWidth-_w)/2;
	var _t = (document.body.clientHeight-_h)/3;

	
	imgPath = twopoint + '/images/';
	if (wobj == null) {
		wobj = Create(document.body, 'div', 'div-please-wait');
		wobjb = Create(document.body, 'div', 'div-please-wait-back');
		wobjc = Create(document.body, 'div', 'div-please-wait-close');
		//wobjc.src = './images/smallClose.png'
		$(wobjc).css({position:'fixed', width:'16px', height:'16px', left:(_l+_w-10)+'px', top:(_t+12)+'px',zIndex:19999, cursor:'pointer', display:'block', backgroundImage:'url('+imgPath+'closeSmall.png)', backgroundPosition:'0px -16px'})
		$(wobjb).css({position:'fixed', width:document.body.clientWidth+'px', height:document.body.clientHeight+'px', position:'fixed', zIndex:19997, backgroundImage:'url('+imgPath+'backLoading.png)', opacity:0.2, left:'0px', top:'0px'})
		$(wobj).css({width:_w+'px', height:_h+'px', zIndex:'19998', border:'1px solid #5C8CB9', backgroundColor:'#fff', position:'fixed', left:_l+'px', top:_t+'px', padding:'5px 5px 5px 5px'})
		wobj.className='corner5 shadow'
		$(wobj).show()
		$(wobj).html('<img src="'+imgPath+'ajax-loader.gif" style="width:31; height:31" align="absmiddle">&nbsp;<span class="text1" style="color:#5C8CB9; font-weight:bold; font-size:11px">'+txt+'</span>')
		if (Browser() != 'iPad') {
			$(wobjc).mousemove(function(event) {ShowPopup(event, dic("cancelOper", lang)); $('#div-please-wait-close').css("backgroundPosition","0px 0px")  });
			$(wobjc).mouseout(function() {HidePopup(); $('#div-please-wait-close').css("backgroundPosition","0px -16px") });
		}
		$(wobjc).click(function(event) {HideWait()});

	} else {
	    $('#div-please-wait').show()
	    $('#div-please-wait-back').show()
	    $('#div-please-wait-close').show()
	}

}

// ------------------------------------------------------------------------------
// -------------------------- DODADENI ------------------------------------------

function AddColor(lang) {
document.getElementById('div-add-color').title = dic("Reports.AddGroup")
$('#div-add-color').dialog({ modal: true, width: 350, height: 280, resizable: false,
		buttons:
        [
        {
        	text:dic("Settings.Add",lang),
			click: function() {

                var name = $('#GroupNameName').val()
                var color = $('#FillColor').val()

                if (name=='')
                {
                	alert(dic("Settings.noGroupName", lang))
                }
                else
                {
                    if (color=='')
                    {
                        alert(dic("Settings.ChooseColor", lang))
                    }
                    else
                    {
								  $.ajax({
	                              url: "AddColor.php?name="+name+"&color="+color, 
	                              context: document.body,
	                              success: function(data){
	                              	alert(dic("Settings.AddedGroup"),lang)
		                            window.location.reload();
	                              }
	                            });	
                                $( this ).dialog( "close" );
                              }
                            }
                          }
                  		},
              		  {
              			text:dic("cancel",lang),
         		click: function() {
				$( this ).dialog( "close" );
			},
		 }
	  ]
   });
}

function prefrliGrupaMarkeri() {

	ShowWait();
	var selektirani = "";
		$('input[class="case"]').each(function () {
		    if(this.checked){
		        selektirani +=  $(this).attr('id') + ",";
		    }
	    });
	selektirani = selektirani.substring(0,selektirani.length - 1);

	$.ajax({
		url:"TransferPOIMultiple.php?selektirani="+selektirani,
		context: document.body,
		success: function(data){
			HideWait();
			$('#div-edit-poi-multiple').html(data);
			$('#div-edit-poi-multiple').dialog({
				modal: true,
				width: 350,
				height: 300,
				resizable: false,
				title: dic("Settings.SwitchPOI",lang),
				buttons:
                  [
                  {
                  	text:dic("Settings.Change",lang),
                    click: function(){

						    var groupid = $('#GroupNameMultiple option:selected').val();

							$.ajax({
                    			url : "UpPOIMultiple.php?selektirani="+selektirani+"&groupid="+groupid,
    							context: document.body,
		    					success: function(data){
		    					msgboxPetar(dic("Settings.SuccSwitched"),lang)
		    					top.ShowWait();
  								window.location.reload();
  								}
							  });
							  $( this ).dialog( "close" );
							  HideWait();
  						    }

    					},
                    {
                    	text:dic("cancel",lang),
                    	click: function() {
					    $( this ).dialog( "close" );
				  	    }
				 	}
                ]
			});
		}
	});
}

function brisiGrupaMarkeri(){

var selektirani = "";
$('input[class="case"]').each(function () {
    if(this.checked){
        selektirani +=  $(this).attr('id') + ",";
    }
});
selektirani = selektirani.substring(0,selektirani.length - 1);

	$('#div-del-poi-multiple').dialog({
		modal: true,
		width: 350,
		height: 170,
		resizable: false,
	    buttons:
	    [
	    {
	    	text:dic("Settings.Yes"),
		    click: function() {
	                $.ajax({
	                    url: "DelPOIMultiple.php?selektirani="+selektirani,
	                    context: document.body,
	                    success: function(data){
	                    msgboxPetar(dic("Settings.SuccDeleted"),lang);
	                    top.ShowWait();
	                    window.location.reload();
	                    }
	                  });
	                $( this ).dialog( "close" );
	                HideWait();
	               }
		       },
		    {
		    	text:dic("Settings.No",lang),
	        click: function() {
			    $( this ).dialog( "close" );
		    }
	     }
	 ]
	});
}

function edit_poi(id,lang){
	var html = '';
	$('#div-edit-poi').dialog({
		modal: true,
		width: 350,
		height: 300,
		resizable: false,
		title: dic("Settings.SwitchPOI", lang),
		open: function(){
			var name = $('#poiid_'+id+' .poi-id-name b').html();
			$('#checked_group_edit').html(name);
		},
		buttons:
		[
			{
				text:dic("Settings.Change",lang),
            	click: function(){
    		        var selectedGroup = $("#GroupNameList option:selected").val();

					$.ajax({
						url : "UpPOI.php?id1="+id+"&groupidVtoro="+selectedGroup,
						context: document.body,
						success: function(){
	 						msgboxPetar(dic("Settings.SuccSwitched"),lang);
		                    timedRefresh(1200)
						}
					});
				}

			},
			{
				text:dic("cancel",lang),
            	click: function() {
			    $( this ).dialog( "close" );
				}
			}
		]
	});
}

function DeletePOI(id,lang){

$('#div-del-poi').dialog({ modal: true, width: 350, height: 170, resizable: false,
    buttons:
    [
    {
    	text:dic("Settings.Yes"),
	    click: function() {
                $.ajax({
                    url: "DelPOI.php?id="+id,
                    context: document.body,
                    success: function(data){
                    msgboxPetar(dic("Settings.SuccDeleted"),lang);
					$('#redGrupirani' + id).fadeOut(300, function(){ $(this).remove();});
					$( this ).dialog( "close" );
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
     }
     ]
 });
}

function prefrliGrupaMarkeri()
{
	ShowWait();
	var selektirani = "";
	    $('input[class="case"]').each(function () {
	        if(this.checked){
	            selektirani +=  $(this).attr('id') + ",";
	    }
    });
	selektirani = selektirani.substring(0,selektirani.length - 1);
	$.ajax({
	url:"TransferPOIMultiple.php?selektirani="+selektirani,
    context: document.body,
    success: function(data){
    HideWait();
	$('#div-edit-poi-multiple').html(data);
	document.getElementById('div-edit-poi-multiple').title = dic("Settings.SwitchPOI");
    $('#div-edit-poi-multiple').dialog({  modal: true, width: 350, height: 300, resizable: false,
              buttons: 
              [
              {
              	text:dic("Settings.Change",lang),
                click: function(){

					    var groupid = $('#GroupNameMultiple option:selected').val();

						$.ajax({
                			url : "UpPOIMultiple.php?selektirani="+selektirani+"&groupid="+groupid,
							context: document.body,
	    					success: function(data){
	    					msgboxPetar(dic("Settings.SuccSwitched"),lang);
								timedRefresh(1400);
								}
						  });
						  $( this ).dialog( "close" );
						  HideWait();
						    }

					},
                {
                	text:dic("cancel",lang),
                	click: function() {
				    $( this ).dialog( "close" );
			  	    }
			 	}
            ]
         });
      }
    });
}

function neaktivniGrupaMarkeri()
{
var selektiraniInactive = "";
$('input[class="case"]').each(function () {
    if(this.checked){
        selektiraniInactive +=  $(this).attr('id') + ",";
    }
});
selektiraniInactive = selektiraniInactive.substring(0,selektiraniInactive.length - 1);

$('#div-inactive-poi-multiple').dialog({ modal: true, width: 350, height: 250, resizable: false,
            buttons:
            [
            {
            	text:dic("Settings.Yes"),
			    click: function() {
                        $.ajax({
	                        url: "InactiveMultiple.php?selektiraniInactive="+selektiraniInactive,
	                        context: document.body,
	                        success: function(data){
	                        msgboxPetar(dic("Settings.SuccMadeInactive"),lang);
	                        top.ShowWait();
	                        window.location.reload();
	                        }
	                     });
	                   $( this ).dialog( "close" );
                     HideWait();
                   }
			    },
			    {
			    	text:dic("Settings.No",lang),
                click: function() {
				    $( this ).dialog( "close" );
			    }
             }
         ]
     });
}

function aktivirajGrupaMarkeri()
{
var selektiraniActive = "";
$('input[class="caseInactive"]').each(function () {
    if(this.checked){
        selektiraniActive +=  $(this).attr('id') + ",";
    }
});
selektiraniActive = selektiraniActive.substring(0,selektiraniActive.length - 1);

$('#div-active-poi-multiple').dialog({ modal: true, width: 350, height: 250, resizable: false,
            buttons:
            [
            {
            	text:dic("Settings.Yes"),
			    click: function() {
                        $.ajax({
	                        url: "ActiveMultiple.php?selektiraniActive="+selektiraniActive,
	                        context: document.body,
	                        success: function(data){
	                        msgboxPetar(dic("Settings.SuccActivatedMarkers"),lang)
	                        top.ShowWait();
	                        window.location.reload();
	                        }
	                     });
	                   $(this).dialog("close");
                       HideWait();
                     }
                   },
			    {
			    	text:dic("Settings.No",lang),
                click: function() {
				    $( this ).dialog( "close" );
			    }
             }
         ]
     });
}

function edit_poi_dialog(name, avail, ppgid, id, desc, num, addinfo, radiusID) {

	var lon_lat = get_lonlat(id).split('@');
	var lon = lon_lat[0];
	var lat = lon_lat[1];

    $('#poiAddress').val('');
    $('#loadingAddress').css({ visibility: "visible" });
    $('#div-Add-POI').attr("title", dic("EditPoi", lang));
    $('#btnAddPOI').attr("value", dic("Update", lang));
    $('#numPoi').val(num);
    if (desc == "") {

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

function get_lonlat(id,callback) {
	var ret = ""
	$.ajax({
		url: "GetLonLat.php?id=" + id,
		async: false,
		context: document.body,
		success: function(data){
			var getdata = data.trim();
			if(getdata.length > 1) {
				ret = getdata;
			}
		}
	});
	return ret;
}

function EditGroup(id,lang){
	ShowWait()
	$.ajax({
	    url: "EditColor.php?id="+id+"&l="+lang,
	    context: document.body,
	    success: function(data){
            HideWait()
			$("#colorPicker4").mlColorPicker({ 'onChange': function (val) {
		    $("#colorPicker4").css("background-color", "#" + val);
		    $("#clickAny1").val("#" + val);
		    }
		    });
		    $('#NameGroup').val(data.split("$$")[0].replace("\n\n",""));
		    $('#clickAny1').val(data.split("$$")[1]);
		    changecolor()
		    document.getElementById('div-edit-user').title = dic("Settings.ChangingGroup")
	        $('#div-edit-user').dialog({ modal: true, width: 350, height: 200, resizable: false,
	             buttons:
	             [
	             {
	             	text:dic("Settings.Change",lang),
			        click: function() {
	                    var GroupName = $('#NameGroup').val()
	                    var ColorName = encodeURIComponent($('#clickAny1').val())
	                    if(GroupName==''){
	                        msgboxPetar(dic("Settings.noGroupName", lang))
	                    }else{
	                        if(ColorName==''){
	                            msgboxPetar(dic("Settings.ChooseColor", lang))
	                        }
	                        else{

	                            $.ajax({
								url: "UpGroup.php?id1="+id+"&GroupName="+GroupName+"&ColorName="+ColorName,
	                             context: document.body,
	                              success: function(data){
	                              	msgboxPetar(dic("Settings.GroupSuccessfullyChanged"),lang)
		                            window.location.reload();
									}
	                            });
	                            $( this ).dialog( "close" );
	                                }
	                              }
	                           }

	                },
	                {
	                	text:dic("cancel",lang),
	                	click: function() {
				        $( this ).dialog( "close" );
			        },
	             }
	             ]
	        });
    	}
    });
}

function DeleteGroup(id,lang, cntRows) {
if(cntRows>0){
document.getElementById('div-del-group').title = dic("Settings.Action");
$('#div-del-group').dialog({ modal: true, width: 350, height: 300, resizable: false,
buttons:
[
{
				text:dic("Settings.Delete",lang),
					click: function() {
						var groupid = $("#GroupName option:selected").val();
                        $.ajax({
                        	url:"DelGroupPOI.php?id="+id+"&groupid="+groupid,
	                        context: document.body,
	                        success: function(data){
	                        if(data == 1)
                            {
                              	msgboxPetar(dic("Settings.CantGroupDelete",lang));
                            }
                            else
                            {
                              	msgboxPetar(dic("Settings.DeletedGroup"),lang)
	                        	window.location.reload();
	                        }
	                      }
	                    });	
                        $( this ).dialog( "close" );
			   		}
			    },
			    {
			    text:dic("cancel",lang),	
                click: function() {
				    $( this ).dialog( "close" );
			    }
            }
        ]
    });
}
else
{
document.getElementById('div-del-group1').title = dic("Settings.Action");
$('#div-del-group1').dialog({ modal: true, width: 350, height: 220, resizable: false,
buttons: 
[
{
				text:dic("Settings.Delete",lang),
					click: function() {
						
                        $.ajax({
                        	url:"DelGroupPOI.php?id="+id,
	                        context: document.body,
	                        success: function(data){
	                        msgboxPetar(dic("Settings.DeletedGroup"),lang)
	                        window.location.reload();
							}
	                    });	
                        $( this ).dialog( "close" );
			   		}
			    },
			    {
			    text:dic("cancel",lang),	
                click: function() {
				    $( this ).dialog( "close" );
			    }
           }
           ]
     });
   }
}


function OpenMapAlarm1(id, name , type){
$('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; border:0px" src=""></iframe>');
document.getElementById('iframemaps').src = 'LoadMap.php?id=' + id + '&name=' + name + '&type=' + type;
$('#dialog-map').dialog({ modal: true, height: 650, width: 800 });
}

function OpenMapAlarm2(id, name , type){
$('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; border:0px" src=""></iframe>');
document.getElementById('iframemaps').src = 'LoadMap.php?id=' + id + '&name=' + name + '&type=' + type;
$('#dialog-map').dialog({ modal: true, height: 650, width: 800 });
}

function OpenMapAlarm3(id){
$('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; border:0px" src=""></iframe>');
document.getElementById('iframemaps').src = 'LoadMap2.php?id=' + id;
$('#dialog-map').dialog({ modal: true, height: 650, width: 800 });
}


/**
 * -----------------------------------------------------------------
 * 							S E A R C H
 * 							 functions
 * -----------------------------------------------------------------
 */
/*
	globalni promenvivi - search
 */
doneSearching = false;
diff_treshhold = 350;
nokey_treshhold = 750;
filter_info = [];

/**
 * 		filter(term) vrakja array od redovi koi go sodrzat term
 * 		vo sebe. Isto se potpolnuva i filter_info[] so info za
 * 		brojot na filtrirani redovi po grupa (se koristi za scroll)
 */

function filter(term){
	var ret = [];
	filter_info = [];
	var cnt = 1;  // interen counter
	var ind = 0;  // interen index
	var pos = 0;  // pozozicija na koja zavrsuva grupata
	$.each(toi,function(i,v){
		var name = v.name;
		if(name.toLowerCase().indexOf(term) >= 0){
			if(filter_info.length === 0) {
				filter_info.push({id:v.groupid, count: 1, pos: pos});
				cnt = 1;
			} else { // ne e prv element

				if(filter_info[ind].id == v.groupid){  // ista grupa
					filter_info[ind].count = ++cnt;
				} else { // nova grupa
					pos += cnt;
					filter_info.push({id:v.groupid, count: 1, pos: pos});
					cnt = 1;
					ind++;
				}
			}
			ret.push(v);
		}
	});
	return ret;
}

function setScroll(points,id) {
	if(points > limit) { $('#POI_data_' + id).css({ height: '500',overflowY: 'scroll'}); }
	else { $('#POI_data_' + id).css({ height: 'auto',overflowY: 'hidden'}); }
}

delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

function displayData(filtered){

	/*
		Prvo se vcituvaat filtriranite podatoci po grupi i se postavuva
		scroll ako n > limit. Se pojavuva naslovot i se dodava html. Potoa
		se vrtat site filtrirani tocki i se dodavaat na soodvetniot nov red
		Na kraj se prikazuvaat novokreiranite redovi, kopcinjata i se
		fokusira inputot
	 */

	$.each(filter_info,function(i,gi){

		$('#POI_group'+gi.id+' .num-of-poi').html("("+gi.count+")"); // promeni go brojot na tocki vo naslov
		$('#POI_group'+gi.id).show();
		$('#POI_group'+ gi.id +' .expand-icon').html("▼");
		$('#POI_group_header'+gi.id).show();
		$('#POI_data_'+gi.id).after('<div id="POI_data_new_'+gi.id+'" class="POI_data_new align-center toi-row"><table><tbody></tbody></table></div>');

		if(gi.count > limit) {
			$('#POI_data_new_' + gi.id).css({ height: '500',overflowY: 'scroll'});
			adjustWidth(gi.id,"#POI_data_new_");
			gi.offset = limit;  // kolku se prikazani
		}

	});

	var indx = 0;
	var cnt = 0;

	$.each(filtered, function(i,red){

		// se limitira prikazuvanjeto na grupite so nad 20 filtrirani rezultati
		if(filter_info[indx].id == red.groupid) {
			cnt++;
		} else {
			cnt = 1;
			indx++;
		}
		// console.log(indx + " ** " + cnt );
		if( $('.new-data#poiid_'+red.id).length === 0 && cnt <= limit)	$('#POI_data_new_'+ red.groupid + ' table').append(append_data(red));

	});

	$('.POI_data_new').show();  //novite podatoci

	buttonIcons();
	doneSearching = true;
	// HideWait();
	setTimeout(function(){ $('#search_input').focus() },50);
}

function hide_data(){ $('.POI_data').hide(); }

function show_original_data(){

	$('.col-titles').hide();  // potrebno za clear input - da se prikazat originalnite

	$.each(allGroups,function(i,v){
		$('#POI_group'+v+' .num-of-poi').html("("+numOfPoints[i]+")"); // promeni go brojot na tocki vo naslov
		$('#POI_group'+ v +' .expand-icon').html("▶");
	});

	// [optimisation]
	$('.POI_data_new').hide();
	$('.POI_data_new').remove();
	$('.title-group').show();

	$.each(GroupsInfo,function(i,g_info){
		if(g_info.haveData) setScroll(g_info.numPOI,g_info.gpid);
		if(g_info.expanded && g_info.numPOI > 0) {
			$('#POI_group_header'+g_info.gpid).show();  // tuka se prikazuvaat samo onie koi prethodno bile expandirani
			$('#POI_data_'+g_info.gpid).show();
		}
	});

}

function clear_input() {
	$('#search_input').val('');
	$('#search_input').blur();
}

function append_data(data,inactive){

var img_row = '';
var tip = '';
var editp = '';
var isInactive = (arguments.length == 2) ? 'prikaziInactive()' : 'prikazi()';
var isInactiveCase = (arguments.length == 2) ? 'caseInactive' : 'case';

if(data.type == 1) { img_row = "poiButton.png"; tip = dic("Settings.POI",lang); editp = "edit_poi_dialog('"+data.name+"','"+data.available+"','"+data.groupid+"','"+data.id+"','','1','','"+data.radius+"')";}
if(data.type == 2) { img_row = "zoneButton.png"; tip = dic("Settings.GeoFence",lang); editp = "OpenMapAlarm2('"+data.id+"','"+data.name+"','"+data.type+"')";}
if(data.type == 3) { img_row = "areaImg.png"; tip = dic("Settings.Polygon",lang); editp = "OpenMapAlarm2('"+data.id+"','"+data.name+"','"+data.type+"')";}

var area = round(data.povrsina,2);
if (data.type != 1) {
	if (area < 1000) area = "("+area+" m2)";
	if (area > 1000 && area < 1000000) area = "("+round(area/1000,2)+" ha)";
	if (area > 1000000) area = "("+round(area/1000000,2)+" km2)";
} else area = "";

var user = (data.userid == 0) ? "<span style='margin-left:86px'></span>" : "(" + data.fullname + ")";

var available = 0;
if(data.available == 1) available = dic("Routes.User",lang);
if(data.available == 2) available = dic("Reports.OrgUnit",lang);
if(data.available == 3) available = dic("Settings.Company",lang);

var html =
"<tr class='data-rows new-data' id='poiid_"+data.id+"'>" +
		"<td width='4%' class='text2 td-row-poi'>" +
			"<div class='toggle'>" +
			 	data.tblindex +
			"</div>" +
		"</td>" +

		"<td width='38%' class='text2 td-row-poi la' style='padding-left:8px'>" +
		"<div class='toggle'>" +

			"<input type='checkbox' class='"+isInactiveCase+"' id='"+data.id+"' onclick='"+isInactive+"'/>&nbsp;"+
			"<img src = '../images/"+img_row+"' height='25px' width = '25px'  style='position: relative;top:7px;'></img>"+
			"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+
			"<span class='poi-id-name' style='position: relative;bottom:8px;'>"+
				"<b>"+data.name+"</b>&nbsp;"+area+
			"</span><br>"+
			"<span style='padding-left: 71px;'>"+user+"</span>"+
		"</div>"+
		"</td>"+
		"<td width='13%'' class='text2 td-row-poi'>"+
		"<div class='toggle'>"+tip+
			"<br>"+
			"<b>("+data.radius+")</b>"+
		"</div>"+
		"</td>"+
		"<td width='13%'' class='text2 td-row-poi'>"+
		"<div class='toggle'>"+
			"<b>"+available+"</b>"+
		"</div>"+
		"</td>"+
		"<td width='8%' class='text2 td-row-poi'>"+
			"<div class='toggle'><button class='btn-refresh-ui btn-def' id='btnprivilegesz"+data.id+"' onclick=\"edit_poi('"+data.id+"')\"></button></div>"+
		"</td>"+
		"<td width='8%' class='text2 td-row-poi'>"+
			"<div class='toggle'><button class='btn-search-ui btn-def' id='btnMapPoiUngroup"+data.id+"' onclick=\"OpenMapAlarm1('"+data.id+"', '"+data.name+"', '"+data.type+"')\"></button></div>"+
		"</td>"+
		"<td width='8%' class='text2 td-row-poi'>"+
			"<div class='toggle'><button class='btn-penci-ui btn-def' id='btnEditPoiUngroup"+data.id+"' onclick=\""+editp+"\"></button></div>"+
		"</td>"+
		"<td width='8%' class='text2 td-row-poi'>"+
			"<div class='toggle'><button class='btn-trash-ui btn-def' id='btnDeletez"+data.id+"'  onclick=\"DeletePOI('"+data.id+"','"+lang+"')\"></button></div>"+
		"</td>"+
	"</tr>";

	return html;
}

function displayMoreData(_id,limit_data){
	console.log("--more data loading...");
	console.log(arguments);
	$.each(limit_data,function(i,rowd){
		if( $('.new-data#poiid_'+_id).length === 0) $('#POI_data_new_'+ _id + ' table').append(append_data(rowd));
	});
}


function scrollEventFiltered(event){
	// console.log(event.currentTarget.id);
	item_id = (event.currentTarget.id).split('_');
	currGroup = Number(item_id[3]);
	item = $('#'+event.currentTarget.id);

	var index = get_index(filter_info,currGroup);
	var filtered_in_group = filtered.slice(filter_info[index].pos, filter_info[index].count+filter_info[index].pos);

	if( filter_have_data && (item.scrollTop() + item.innerHeight() >= (item[0].scrollHeight - 120))) {

    	delay(function(){
    		console.log('scrolling near bottom -- begin displaying data...');

    		var offset = filter_info[index].offset;

    		console.log(offset);
    		if(filtered_in_group.slice(offset,offset+limit) !== 0) {
    			displayMoreData(currGroup,filtered_in_group.slice(offset,offset+limit));
    			filter_have_data = true;
    			goToByScroll("POI_group" + currGroup,10);
    		} else filter_have_data = false;

    		buttonIcons();
    		filter_info[index].offset+=limit;
    	},150);
    }
}

function adjustWidth(gpid, _selector) {
	var getTitleWidth = 0;
	var selector = "#POI_data_";
	if(arguments.length == 1) {
		getTitleWidth = $('#POI_group'+gpid).width();
		$(selector + gpid + ' table').width(getTitleWidth);
	}
	if(arguments.length == 2) {
		selector = _selector;
		getTitleWidth = $('#POI_group'+gpid).width();
		$(selector + gpid + ' table').width(getTitleWidth);
	}
	if(arguments.length == 0) {
		$.each(numOfPoints,function(i,v){
			if(v > limit) {
				getTitleWidth = $('#POI_group'+v).width();
	 			$(selector + allGroups[i]+ ' table').width(getTitleWidth);
			}
		});
	}
}


// ------------------------ END -------------------------------------

function round(value, decimals) {
    return Number(Math.round(value+'e'+decimals)+'e-'+decimals);
}

function fetch_all() {

	// ShowWait();
	$.ajax({
	    url: "GetPOIOffset.php?all=1",
	    context: document.body,
	    success: function(alldata) {
	    	// HideWait();
	    	$('#fetch-data').append(alldata);
	    	toi = JSON.parse(alldata);
	    }
	});
}

function fetch_inactive() {
	$.ajax({
		url: "GetPOIOffset.php?getInactive=1",
		context: document.body,
		success: function(inactive) {
			inactive_data = JSON.parse(inactive)
			$.each(inactive_data,function(i,v){
				$('#POI_data_inactive table tbody').append(append_data(v,true));
			})

	    	$('#POI_data_inactive').show();
	    	buttonIcons();
		}
	});
}

// ------------------------------------------------------------------------------