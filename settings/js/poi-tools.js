

// ------- GLOBAL VARs -----------
lang = '<?php echo $cLang?>';
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
	    		var getData = data; //data.split("@");
	    		haveData = (getData < limit) ? false : true;

	    		$('#POI_data_' + gpid + ' table tbody').append(getData);
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

	if(GroupsInfo[inx].expanded === false) {
		GroupsInfo[inx].expanded = true;
		if(currPoints !== 0) {
			$('#POI_group'+ currGroup +' .expand-icon').html("▼");
		}
	}
	else {
		GroupsInfo[inx].expanded = false;
		$('#POI_group'+ currGroup +' .expand-icon').html("▶");

	}
	// ako se naogja vo rezim na prebaruvanje

	if($('#search_input').val() != '') {
		goToByScroll("POI_group" + currGroup,10);
		$('#POI_data_new_' + currGroup).slideToggle("slow");
		return false;
	}

	// zastani tuka ako e vo rezim na prebaruvanje

	if(GroupsInfo[inx].clicked === false) {

		GroupsInfo[inx].clicked = true;
		dataOffset = 0;
		console.log("first DATA FETCH...");

		if(currPoints !== 0) {
			var cp = $('.proto-col tr').clone();
			$('#POI_data_' + currGroup + ' table').append(cp);
		}

		if(currPoints > limit) {

			GroupsInfo[inx].haveData = true;
			GroupsInfo[inx].firstExpand = false;
			groupData.css({ height: '500px',overflowY: 'auto'});

		} else {
			GroupsInfo[inx].haveData = false;
			GroupsInfo[inx].firstExpand = false;

		}

		fetchData(limit,dataOffset,currGroup);

		return false;

	}

	goToByScroll("POI_group" + currGroup,10);

	$('#POI_data_' + currGroup).slideToggle("slow");


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

		var cp = $('.proto-col tr').clone();
		$('#POI_data_' + groupid + ' table').append(cp);

		$('#POI_group' + groupid + ' .expand-icon').html("▼");

		GroupsInfo[inx].clicked = true;
		dataOffset = 0;

		console.log("first DATA FETCH...");

		if(currPoints > 20) $('#POI_data_' + groupid).css({ height: '500px',overflowY: 'scroll'});

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
	$('html,body').stop().animate({ scrollTop: ($("#"+id).offset().top - offset)}, 500);
}

function TopScroll() {
	$('html, body').animate({scrollTop: (0)}, 'slow');
}

// eksperimentalna fukcija (doc.ready())
function color_title() {

    for (var i = 0; i < allGroups.length; i++) {
    	var get_color = $('#slider_'+allGroups[i]);
    	var selector = $('#POI_group'+allGroups[i]);
    	var selector_right = $('#POI_group'+allGroups[i]+' tr td:first-child');

    	var bg_effect = chroma(get_color.css('background-color')).desaturate().hex();
    	var border_effect = chroma(get_color.css('background-color')).darken(20).hex();

    	selector.css('background-color',bg_effect);
    	selector.css({"border-color": border_effect, "border-width":"1px", "border-style":"solid"});
    	if (allGroups[i] != 1) selector_right.css({"border-right-color": 'white', "border-right-width":"1px", "border-right-style":"solid"});

    }
}

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

function edit_poi(id){
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

function align_elements() {
	$.each(allGroups,function(i,v){
		// console.log(i+"--"+v);
		var groupTitle = $('#POI_group'+v);
		var groupTable = $('#POI_data_'+v);
		var ml = parseInt(groupTable.css('margin-left'));
		var diff = groupTitle.width()-groupTable.width();
		groupTable.css('margin-left', ml+diff);
		groupTable.width(groupTitle.width()+ 3 * Math.abs(diff));
	});
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
		$('#POI_data_'+gi.id).after('<div id="POI_data_new_'+gi.id+'" class="POI_data_new align-center toi-row"><table><tbody></tbody></table></div>');
		if(gi.count > limit) {
			$('#POI_data_new_' + gi.id).css({ height: '500',overflowY: 'scroll'});
			gi.offset = limit;  // kolku se prikazani
		}

		var cp = $('.proto-col tr').clone();
		$('#POI_data_new_'+gi.id+' table').append(cp);

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
	setTimeout(function(){ $('#search_input').focus() },50);
}

function hide_data(){ $('.POI_data').hide(); }

function show_original_data(){

	$.each(allGroups,function(i,v){
		$('#POI_group'+v+' .num-of-poi').html("("+numOfPoints[i]+")"); // promeni go brojot na tocki vo naslov
	});

	$.each(GroupsInfo,function(i,g_info){
		if(g_info.haveData) setScroll(g_info.numPOI,g_info.gpid);
	});

	$('.POI_data_new').remove();
	$('.toi-group-title table').show();

	$('.POI_data').show();

}

function clear_input() {
	$('#search_input').val('');
	$('#search_input').blur();
}

function append_data(data,cnt){

var img_row = '';
var tip = '';
var editp = '';
if(data.type == 1) { img_row = "poiButton.png"; tip = dic("Settings.POI",lang); editp = "EditPOI('"+data.id+"')";}
if(data.type == 2) { img_row = "zoneButton.png"; tip = dic("Settings.GeoFence",lang); editp = "OpenMapAlarm2('"+data.id+"')";}
if(data.type == 3) { img_row = "areaImg.png"; tip = dic("Settings.Polygon",lang); editp = "OpenMapAlarm2('"+data.id+"')";}

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

			"<input type='checkbox' class='case' id='"+data.id+"' onclick='prikazi()'/>&nbsp;"+
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
	filtered_in_group = filtered.slice(filter_info[index].pos, filter_info[index].count+filter_info[index].pos);

	if( filter_have_data && (item.scrollTop() + item.innerHeight() >= (item[0].scrollHeight - 120))) {

    	delay(function(){
    		console.log('scrolling near bottom -- begin displaying data...');

    		var offset = filter_info[index].offset;

    		console.log(offset);
    		if(filtered_in_group.slice(offset,offset+limit) !== 0) {
    			displayMoreData(currGroup,filtered_in_group.slice(offset,offset+limit));
    			filter_have_data = true;
    		} else filter_have_data = false;

    		buttonIcons();
    		filter_info[index].offset+=limit;
    	},300);
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

// ------------------------------------------------------------------------------