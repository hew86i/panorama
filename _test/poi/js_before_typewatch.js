// ---------------------------------------------------------------------
// ----------------------   SEARCH   -----------------------------------

// globalni promenlivi
times = {prev: 0, last: 0};
s_params = {oldLength: 0, newLength: 0, oldText: '', newText: '', run_once: true};
doneSearching = false;
diff_treshhold = 350;
nokey_treshhold = 1200;

function filter(term){ // gi vrakja site redovi (obj) koi go sodrzat term vo .name
	var ret = [];
	$.each(toi,function(i,v){
		var name = v.name;
		if(name.toLowerCase().indexOf(term) >= 0){
		ret.push(v);
		}
	});
	return ret;
}

function searchWords (filtered){

	$.each(filtered, function(i,red){
		// console.log("pending: "+red.id);
		// $('#poiid_'+red.id).length === 0 && bese vo uslov
		if( $('.new-data#poiid_'+red.id).length === 0) {
			// append_data(red);
			$('#POI_data_'+ red.groupid + ' table').append(append_data(red));
			$('#POI_group'+red.groupid).show();
			$('#POI_data_'+red.groupid+' .col-titles').show();
		}
	});
	$('.new-data').show();
	buttonIcons();
	doneSearching = true;
	setTimeout(function(){ $('#search_input').focus() },100);
}

function hide_data(data){
	$('.data-rows').hide(); // hide data rows
	$('.col-titles').hide(); // hide column titles
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
			 	data.id +
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


	// $('#POI_data_'+ data.groupid + ' table').append(html);
	return html;

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

$(document).ready(function () {

    prikazi();
    color_title(); // promena na boite

    $('#kopce').button({ icons: { primary: "ui-icon-plus"} });
    $('#clear-input').button({ icons: { primary: "ui-icon-minus"} });
	$('#brisiGrupno').button({ icons: { primary: "ui-icon-trash"} });
	$('#prefrliGrupno').button({ icons: { primary: "ui-icon-refresh"} });
	$('#neaktivniGrupno').button({ icons: { primary: "ui-icon-cancel"} });
	$('#AktivirajGrupno').button({ icons: { primary: "ui-icon-circle-check"} });
	$('#prikaziPovekeNegrupirani').button({ icons: { primary: "ui-icon-arrowthick-1-s"} });

	buttonIcons();
    top.HideWait();
    timer_trigger = false;

    $.each(numOfPoints, function(index,value){
		if(value !== 0) {
			first_expand(allGroups[index]);
			return false;
		}
    });

	// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
	// 			S C R O L L   E V E N T

	// align_elements();

    $(".POI_data").scroll(function() {

		item_id = ($(this)[0].id).split('_');
		currGroup = Number(item_id[2]);
		item = $('#POI_data_' + currGroup);

		var groupPos = find_group(GroupsInfo,currGroup);
    	// console.log( "Scrolling within div id: " + item_id);
    	// console.log( "isReady: " + (isReady && (item.scrollTop() + item.innerHeight() >= (item[0].scrollHeight - 120))) );
		if(isReady && (item.scrollTop() + item.innerHeight() >= (item[0].scrollHeight - 120))) {
			isReady = false;
        	console.log('scrolling near bottom -- begin fetching data...');
        	if(GroupsInfo[groupPos].haveData && GroupsInfo[groupPos].numPOI > GroupsInfo[groupPos].offset) {
        		// var groupPos = find_group(GroupsInfo,currGroup);
	        	fetchData(limit,GroupsInfo[groupPos].offset,currGroup);
	        	goToByScroll("POI_group" + currGroup,10);
	        	console.log("[scroll event] have data: "+GroupsInfo[groupPos].haveData+ " - fetching...");
	        } else {
	        	console.log("[scroll event] no data / reset");
	        	dataOffset=0;
	        }
        }

	});

	$('#search_input').keyup(function(event){

		console.log(s_params);

		term = $('#search_input').val();
		if(term.length == 0) $('#search_img').attr('src','../images/lupa3.png');

		var from_timer = (typeof(event.originalEvent) == 'undefined') ? true : false;

		if (from_timer) {
			s_params.run_once = false;
			searchWords(filter(term));
			return false;
		} else s_params.run_once = true;

		times.prev = times.last;
		times.last = event.timeStamp;

		s_params.oldLength = s_params.newLength;
		s_params.newLength = term.length;

		s_params.newText = term;

		diff = (times.prev !== 0) ? times.last - times.prev : 0;
		// console.log("diff: "+diff);

		filtered = [];
		if(term !== '') {

			s_params.oldText = s_params.newText;

			$('.new-data').remove(); // izbrisi prethodni filtrirani i prikazani

	    	filtered = filter(term);
	    	console.log("found: "+ filtered.length + " .............");
	    	// console.log(s_params);
	    	// console.log(filtered);
	    	$('#search_img').attr('src','../images/ajax-loader.gif');

			// console.log("------------------------------------------------------------------");

			hide_data(); // hide group data
			$('.toi-group-title table').hide(); // hide group titles


			if(timer_trigger && diff > diff_treshhold){
				timer_trigger = false;
				console.log("conditions are right! -> displaing res");
				console.log(filtered);
				searchWords(filtered);
			}

			// $('#POI_data_1 table tr').eq(0).hide();
			// $('#POI_data_'+ v).css({ overflowY: 'hidden'});

		} else if (s_params.newLength == 0 && s_params.oldLength > 0){

			$('.data-rows').show();  // prikazi postoecki redovi
			$('.new-data').remove();  // filtrirani podatoci izbrisi od DOM
			$('.toi-group-title table').show(); // naslovite
		}

	});

	$('#search_input').blur(function(){
		if($(this).val() == '') {
			$('.data-rows').show();  // prikazi postoecki redovi
			$('.new-data').remove();  // filtrirani podatoci izbrisi od DOM
			$('.toi-group-title table').show(); // naslovite
		}
		$('#search_img').attr('src','../images/lupa3.png');
		timer_trigger = false;
		clearInterval(Timer);
	});

	$('#search_input').focus(function(){

		Timer = setInterval(function(){

			console.log("timer....");

			if(times.last > 0 && s_params.run_once && ((Date.now()-times.last) > nokey_treshhold )){
				timer_trigger = true;
				console.log(">"+nokey_treshhold);

				$('#search_input').keyup();
			}
			if(doneSearching) {
				doneSearching = false;
				$('#search_img').attr('src','../images/lupa3.png');
			}
		},50);

	});

    // ke se vcitaat site tocki vo JSON format
	setTimeout(function(){
		fetch_all();
		console.log("fetch all");
	},400);


});