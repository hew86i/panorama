<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="../style.css">

	<script type="text/javascript" src="../js/jquery.js"></script>
	
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	
    <script type="text/javascript" src="../tracking/live.js"></script>
	<script type="text/javascript" src="../tracking/live1.js"></script>

	<script type="text/javascript" src="routes.js"></script>
	<script type="text/javascript" src="./js/highcharts.src.js"></script>

	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="../js/jquery-ui.js"></script>
	<script src="../report/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="../js/OpenLayers.js"></script>
    <script src="js/optimized.js" type="text/javascript"></script>
    <script src="js/advanced.js" type="text/javascript"></script>
	<script src="../js/jsxcompressor.js"></script>

</head>

<?php

	opendb();
	$Allow = getPriv("routessearch", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
	$user_id = Session("user_id");
	
	$dsAll = query("select defaultmap, datetimeformat, timezone, metric, cl.clienttypeid, ci.latitude, ci.longitude from users u left outer join clients cl on cl.id = u.clientid left outer join cities ci on ci.id = cl.cityid where u.id = " . $user_id);

	$datetimeformat = pg_fetch_result($dsAll, 0, 'datetimeformat');
	$datfor = explode(" ", $datetimeformat);
	$dateformat = $datfor[0];
	$timeformat =  $datfor[1];
	if ($timeformat == 'h:i:s') $timeformat = $timeformat . " A";
	if ($timeformat == "H:i:s") {
		$tf = " H:i";
	}	else {
		$tf = " h:i A";
	}
	$datejs = str_replace('d', 'dd', $dateformat);	
	$datejs = str_replace('m', 'mm', $datejs);
	$datejs = str_replace('Y', 'yy', $datejs);
    $clientType = pg_fetch_result($dsAll, 0, "clienttypeid");
	$clientUnit = pg_fetch_result($dsAll, 0, "metric");
    
    //$allPOI = dlookup("select count(*) from pinpoints where clientID=" . session("client_id"));
    //$allPOIs As String = "false"
    //If allPOI < 1000 Then allPOIs = "true"
	
    $DefMap = pg_fetch_result($dsAll, 0, "defaultmap");
    	
    $currDateTime0 = new Datetime();
	$currDateTime = $currDateTime0->format("d-m-Y H:i");
	$currDateTime1 = $currDateTime0->format($dateformat);
	$currDateTime2 = $currDateTime0->format($dateformat);
	$currDateTime2 = addToDateU($currDateTime, -1, 'days', $dateformat);
	
	//dd-MM-yyyy HH:mm 
    //now()->format("Y-m-d H:i:s");

    $AllowedMaps = "11111";
    

	$cntz = dlookup("select count(*) from pointsofinterest where active='1' and type=2 and clientid=" . Session("client_id"));
    //$CurrentTime = DlookUP("select Convert(nvarchar(20), DATEADD(HOUR,(select timeZone from clients where ID=" . Session("client_id") . ") - 1,GETDATE()), 120) DateTime");
    $tzone = pg_fetch_result($dsAll, 0, "timezone");
	$tzone = $tzone - 1;
 
    //$AllowAddPoi = getPriv("AddPOI", Session("user_id"))
    //$AllowViewPoi = getPriv("ViewPOI", Session("user_id"))
    //$AllowAddZone = getPriv("AddZones", Session("user_id"))
    //$AllowViewZone = getPriv("ViewZones", Session("user_id"))
	
	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	addlog(37, '');
?>

<style>
	.ui-autocomplete {
		max-height: 100px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
		/* add padding to account for vertical scrollbar */
		padding-right: 20px;
		z-index: 4000;
	}
</style>
<style type="text/css">
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; width: <?php if($yourbrowser == "1") { echo '90%'; } else { echo '96.6937%'; } ?>; height: 25px; }
</style>
<script type="text/javascript">
    (function ($) {
        $.widget("ui.combobox", {
            _create: function () {
                var self = this,
					    select = this.element.hide(),
					    selected = select.children(":selected"),
					    value = selected.val() ? selected.text() : "";
                var input = this.input = $("<input>")
					.insertAfter(select)
					.val("")
					.autocomplete({
					    delay: 0,
					    minLength: 0,
					    source: function (request, response) {
					        var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
					        response(select.children("option").map(function () {
					            var text = $(this).text();
					            if (this.value && (!request.term || matcher.test(text))) {
					                return {
					                    label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>"),
					                    value: text,
					                    option: this
					                };
					            }
					        }));
					        $('.ui-autocomplete').css({ width: (parseInt($('#widthR').css('width'), 10) - 24) + 'px' });
					    },
					    close: function (event, ui) {
					        //input.val('');
					    },
					    select: function (event, ui) {
					        ui.item.option.selected = true;
					        self._trigger("selected", event, {
					            item: ui.item.option
					        });
					        //optimalClick = true;
                            $(this).val(ui.item.value);

                            //putInRoute(ui.item.option.value.split("|")[0], ui.item.option.value.split("|")[2], ui.item.option.value.split("|")[1], ui.item.value, 1, ui.item.option.value.split("|")[0]);
					    },
					    change: function (event, ui) {
					        if (!ui.item) {
					            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex($(this).val()) + "$", "i"),
									valid = false;
					            select.children("option").each(function () {
					                if ($(this).text().match(matcher)) {
					                    this.selected = valid = true;
					                    return false;
					                }
					            });
					            if (!valid) {
					                // remove invalid value, as it didn't match anything
					                $(this).val("");
					                select.val("");
					                input.data("autocomplete").term = "";
					                return false;
					            }
					        }
					    }
					})
					.addClass("ui-widget ui-widget-content ui-corner-left");
                	input.data("autocomplete")._renderItem = function (ul, item) {
                    input.autocomplete("widget")[0].style.zIndex = '2000';
                    input.autocomplete("widget")[0].style.overflowX = 'hidden';
                    input.autocomplete("widget")[0].style.overflowY = 'auto';
                    input.autocomplete("widget")[0].style.maxHeight = '210px';
                    input.autocomplete("widget")[0].style.width = (parseInt($('#widthR').css('width'), 10) - 24) + 'px'
                    return $("<li></li>")
						.data("item.autocomplete", item)
						.append("<a>" + item.label + "</a>")
						.appendTo(ul);
                };

                this.button = $("<button type='button'>&nbsp;</button>")
					.attr("tabIndex", -1)
					.attr("title", dic("show", lang) + " " + dic("all", lang) + " " + dic("Pois", lang))
					.insertAfter(input)
					.button({
					    icons: {
					        primary: "ui-icon-triangle-1-s"
					    },
					    text: false
					})
					.removeClass("ui-corner-all")
					.addClass("ui-corner-right ui-button-icon")
					.click(function () {
					    // close if already visible
					    if (input.autocomplete("widget").is(":visible")) {
					        input.autocomplete("close");
					        return;
					    }

					    // work around a bug (likely same cause as #5265)
					    $(this).blur();

					    // pass empty string as value to search for, displaying all results
					    input.autocomplete("search", "");
					    input.focus();

					    input.autocomplete("widget")[0].style.zIndex = '2000';
					    input.autocomplete("widget")[0].style.overflowX = 'hidden';
					    input.autocomplete("widget")[0].style.overflowY = 'auto';
					    input.autocomplete("widget")[0].style.maxHeight = '210px';
					    input.autocomplete("widget")[0].style.width = (parseInt($('#widthR').css('width'), 10) - 24) + 'px';

					});
            },

            destroy: function () {
                this.input.remove();
                this.button.remove();
                this.element.show();
                $.Widget.prototype.destroy.call(this);

            }
        });
    })(jQuery);

    $(function () {
        $("#combobox").combobox();
    });
	</script>

<script>

	
	lang = '<?php echo $cLang?>';

	$(function () {
	    $("#MarkersIN").sortable({
	        revert: true,
	        axis: 'y',
	        cursor: 'ns-resize',
	        stop: function (event, div) {
	            if ($('#test1').attr('checked'))
	                var file = "getLinePoints";
	            else
	                var file = "getLinePointsF";

	            if (div.item[0].previousSibling == null)
	                var prev = -1;
	            else
	                var prev = parseInt(div.item[0].previousSibling.id.substring(div.item[0].previousSibling.id.lastIndexOf("_") + 1, div.item[0].previousSibling.id.length), 10);
	            if (div.item[0].nextSibling == null)
	                var next = -1;
	            else
	                var next = parseInt(div.item[0].nextSibling.id.substring(div.item[0].nextSibling.id.lastIndexOf("_") + 1, div.item[0].nextSibling.id.length), 10);
	            var curr = parseInt(div.item[0].id.substring(div.item[0].id.lastIndexOf("_") + 1, div.item[0].id.length), 10);
	            //alert(curr + " | " + prev + " | " + next);
	            if (next == -1 && prev == -1) return false;
	            if ((next - curr == 1) && (curr - prev == 1)) {
	                return false;
	            }
	            else {
	                if (curr > next && next != -1) {
	                    var currTMPMR = tmpMarkersRoute[curr];
	                    var currPOR = PointsOfRoute[curr + 1];
	                    var pom;
	                    var pom1;
	                    if (curr == ($('#MarkersIN').children().length - 1))
	                        tmpMarkersRoute[curr].events.element.children[0].style.backgroundColor = '#0066FF';
	                    for (var i = next; i <= curr; i++) {
	                        if (i < (curr - 1)) {
	                            for (var j = 0; j < lineFeatureRoute[i + 1].length; j++) {
	                                lineFeatureRoute[i + 1][j].style.VehID = "<br /><strong>" + dic("From", lang) + ": (" + (i + 2) + ")</strong> " + PointsOfRoute[i + 1].name + "<br /><strong>" + dic("To", lang) + ": (" + (i + 3) + ")</strong> " + PointsOfRoute[i + 2].name;
	                            }
	                        }
	                        pom = tmpMarkersRoute[i];
	                        pom1 = PointsOfRoute[i + 1];
	                        currTMPMR.events.element.children[0].innerHTML = (i + 1) + currTMPMR.events.element.children[0].innerHTML.substring(currTMPMR.events.element.children[0].innerHTML.indexOf("<"), currTMPMR.events.element.children[0].innerHTML.length);
	                        tmpMarkersRoute[i] = currTMPMR;
	                        PointsOfRoute[i + 1] = currPOR;
	                        currTMPMR = pom;
	                        currPOR = pom1;
	                        $('#MarkersIN').children()[i].id = $('#MarkersIN').children()[i].id.substring(0, $('#MarkersIN').children()[i].id.lastIndexOf("_") + 1) + i;
	                        $('#MarkersIN').children()[i].children[3].id = $('#MarkersIN').children()[i].children[3].id.substring(0, $('#MarkersIN').children()[i].children[3].id.lastIndexOf("_") + 1) + i;
	                        $('#MarkersIN').children()[i].children[3].attributes[0].value = $('#MarkersIN').children()[i].children[3].attributes[0].value.substring(0, $('#MarkersIN').children()[i].children[3].attributes[0].value.lastIndexOf("_") + 1) + i + "','" + i + "')";
	                    }
	                    if (prev == -1) {
	                        tmpMarkersRoute[0].events.element.children[0].style.backgroundColor = '#00CC33';
	                        tmpMarkersRoute[1].events.element.children[0].style.backgroundColor = '#0066FF';
	                    }
	                    if (curr == ($('#MarkersIN').children().length - 1))
	                        tmpMarkersRoute[curr].events.element.children[0].style.backgroundColor = '#FF0000';

	                    if (prev != -1) {
	                        vectors[0].removeFeatures(lineFeatureRoute[next]);
	                        lineFeatureRoute[next] = "";
	                        DrawLine_Route1(PointsOfRoute[next].lon, PointsOfRoute[next].lat, PointsOfRoute[next + 1].lon, PointsOfRoute[next + 1].lat, next, 0, "<br /><strong>" + dic("From", lang) + ": (" + next + ")</strong> " + PointsOfRoute[next].name + "<br /><strong>" + dic("To", lang) + ": (" + (next + 1) + ")</strong> " + PointsOfRoute[next + 1].name, file);
	                    }
	                    vectors[0].removeFeatures(lineFeatureRoute[curr]);
	                    lineFeatureRoute[curr] = "";
	                    for (var i = curr; i > (next + 1); i--) {
	                        lineFeatureRoute[i] = lineFeatureRoute[i - 1];
	                    }
	                    lineFeatureRoute[next + 1] = "";
	                    DrawLine_Route1(PointsOfRoute[next + 1].lon, PointsOfRoute[next + 1].lat, PointsOfRoute[next + 2].lon, PointsOfRoute[next + 2].lat, next + 1, 0, "<br /><strong>" + dic("From", lang) + ": (" + (next + 1) + ")</strong> " + PointsOfRoute[next + 1].name + "<br /><strong>" + dic("To", lang) + ": (" + (next + 2) + ")</strong> " + PointsOfRoute[next + 2].name, file);
	                    if (curr != ($('#MarkersIN').children().length - 1)) {
	                        vectors[0].removeFeatures(lineFeatureRoute[curr + 1]);
	                        lineFeatureRoute[curr + 1] = "";
	                        DrawLine_Route1(PointsOfRoute[curr + 1].lon, PointsOfRoute[curr + 1].lat, PointsOfRoute[curr + 2].lon, PointsOfRoute[curr + 2].lat, curr + 1, 0, "<br /><strong>" + dic("From", lang) + ": (" + (curr + 1) + ")</strong> " + PointsOfRoute[curr + 1].name + "<br /><strong>" + dic("To", lang) + ": (" + (curr + 2) + ")</strong> " + PointsOfRoute[curr + 2].name, file);
	                    }

	                } else {
	                    var currTMPMR = tmpMarkersRoute[curr];
	                    var currPOR = PointsOfRoute[curr + 1];
	                    var pom;
	                    var pom1;
	                    for (var i = prev; i >= curr; i--) {
	                        if (i > (curr + 1)) {
	                            for (var j = 0; j < lineFeatureRoute[i].length; j++) {
	                                lineFeatureRoute[i][j].style.VehID = "<br /><strong>" + dic("From", lang) + ": (" + (i - 1) + ")</strong> " + PointsOfRoute[i].name + "<br /><strong>" + dic("To", lang) + ": (" + i + ")</strong> " + PointsOfRoute[i + 1].name;
	                            }
	                        }
	                        //debugger;
	                        pom = tmpMarkersRoute[i];
	                        pom1 = PointsOfRoute[i + 1];
	                        currTMPMR.events.element.children[0].innerHTML = (i + 1) + currTMPMR.events.element.children[0].innerHTML.substring(currTMPMR.events.element.children[0].innerHTML.indexOf("<"), currTMPMR.events.element.children[0].innerHTML.length);
	                        tmpMarkersRoute[i] = currTMPMR;
	                        PointsOfRoute[i + 1] = currPOR;
	                        currTMPMR = pom;
	                        currPOR = pom1;
	                        if (next == -1) {
	                            pom.events.element.children[0].style.backgroundColor = '#FF0000';
	                            tmpMarkersRoute[i].events.element.children[0].style.backgroundColor = '#00CC33';
	                        }
	                        /*if (curr == 0)
	                        tmpMarkersRoute[0].events.element.children[0].style.backgroundColor = '#0066FF';
	                        //if (curr == 0 && i > 0)
	                        //tmpMarkersRoute[i].events.element.children[0].style.backgroundColor = '#0066FF';*/
	                        if (curr == 0 && i == 0)
	                            tmpMarkersRoute[i].events.element.children[0].style.backgroundColor = '#00CC33';
	                        else
	                            tmpMarkersRoute[i].events.element.children[0].style.backgroundColor = '#0066FF';
	                        $('#MarkersIN').children()[i].id = $('#MarkersIN').children()[i].id.substring(0, $('#MarkersIN').children()[i].id.lastIndexOf("_") + 1) + i;
	                        $('#MarkersIN').children()[i].children[3].id = $('#MarkersIN').children()[i].children[3].id.substring(0, $('#MarkersIN').children()[i].children[3].id.lastIndexOf("_") + 1) + i;
	                        $('#MarkersIN').children()[i].children[3].attributes[0].value = $('#MarkersIN').children()[i].children[3].attributes[0].value.substring(0, $('#MarkersIN').children()[i].children[3].attributes[0].value.lastIndexOf("_") + 1) + i + "','" + i + "')";
	                    }

	                    if (curr != 0) {
	                        vectors[0].removeFeatures(lineFeatureRoute[curr]);
	                        vectors[0].removeFeatures(lineFeatureRoute[curr + 1]);
	                        lineFeatureRoute[curr] = "";
	                        DrawLine_Route1(PointsOfRoute[curr].lon, PointsOfRoute[curr].lat, PointsOfRoute[curr + 1].lon, PointsOfRoute[curr + 1].lat, curr, 0, "<br /><strong>" + dic("From", lang) + ": (" + curr + ")</strong> " + PointsOfRoute[curr].name + "<br /><strong>" + dic("To", lang) + ": (" + (curr + 1) + ")</strong> " + PointsOfRoute[curr + 1].name, file);
	                    } else
	                        vectors[0].removeFeatures(lineFeatureRoute[curr + 1]);
	                    for (var i = (curr + 1); i < prev; i++) {
	                        lineFeatureRoute[i] = lineFeatureRoute[i + 1];
	                    }
	                    lineFeatureRoute[prev] = "";
	                    DrawLine_Route1(PointsOfRoute[prev].lon, PointsOfRoute[prev].lat, PointsOfRoute[prev + 1].lon, PointsOfRoute[prev + 1].lat, prev, 0, "<br /><strong>" + dic("From", lang) + ": (" + prev + ")</strong> " + PointsOfRoute[prev].name + "<br /><strong>" + dic("To", lang) + ": (" + (prev + 1) + ")</strong> " + PointsOfRoute[prev + 1].name, file);
	                    if (next != -1) {
	                        vectors[0].removeFeatures(lineFeatureRoute[next]);
	                        lineFeatureRoute[next] = "";
	                        DrawLine_Route1(PointsOfRoute[next].lon, PointsOfRoute[next].lat, PointsOfRoute[next + 1].lon, PointsOfRoute[next + 1].lat, next, 0, "<br /><strong>" + dic("From", lang) + ": (" + next + ")</strong> " + PointsOfRoute[next].name + "<br /><strong>" + dic("To", lang) + ": (" + (next + 1) + ")</strong> " + PointsOfRoute[next + 1].name, file);
	                    }

	                }
	                if (PointsOfRoute[1] != undefined) {
	                    $('#IDMarker_' + PointsOfRoute[1].id + '_0')[0].children[1].value = "/";
	                    $('#IDMarker_' + PointsOfRoute[1].id + '_0')[0].children[2].value = "/";
	                }
	                //doOptimized('route', 'renderRoute');

	            }
	        }
	    });
	    $("div, div").disableSelection();
	});

	var aPoiName  = []
	var aPoiId  = []
	var PoiCount = 0
	var PointsOfRoute = [];
	function genTable(){
		
		var str  = ''
		str = str + '<tr>'
		str = str + '	<td width="60px" height="22px" align="center" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185"><strong><?php echo dic_("Routes.Rbr")?></strong></td>'
		str = str + '	<td class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185"><strong>&nbsp;<?php echo dic_("Routes.Poi")?></strong></td>'
		str = str + '	<td width="100px" align="center" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185"><strong>&nbsp;</strong></td>'
		str = str + '</tr>'
		for(var i=0;i<PoiCount; i++){
			str = str + '<tr>'
			str = str + '	<td height="22px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8">'+(i+1)+'</td>'
			str = str + '	<td class="text2" style="background-color:#fff; border:1px dotted #B8B8B8">&nbsp;'+aPoiName[i]+'</td>'
			str = str + '	<td align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8">'
			if (i>0) {
				str = str + '		<img src="../images/nagore.png" style="cursor:pointer" onclick="Nagore('+i+')" align="absmiddle">'
			} else {
				str = str + '		<img src="../images/nagore.png" style="opacity:0.4" align="absmiddle">'
			}
			if (i<PoiCount-1) {
				str = str + '		<img src="../images/nadolu.png" style="cursor:pointer" onclick="Nadolu('+i+')" align="absmiddle">'
			} else {
				str = str + '		<img src="../images/nadolu.png" style="opacity:0.4" align="absmiddle">'
			}
			str = str + '		&nbsp;&nbsp;&nbsp;<img src="../images/brisi.png" style="cursor:pointer" onclick="Brisi('+i+')" align="absmiddle">'			
			str = str + '	</td>'
			str = str + '</tr>'
		}		
		str = str + '<tr>'
		str = str + '	<td height="22px" align="center" class="text3" style="background-color:#fff; color:#39ae58; font-weight:bold; border:1px dotted #B8B8B8; cursor:pointer" colspan="3" onClick="AddPOI()"><img src="../images/dodadi.png" style="cursor:pointer" align="absmiddle"><?php echo dic_("Routes.AddNewLocation")?></td>'
		str = str + '</tr>'
		$('#tbl-poi').html(str)
	}
	function dodadi(){
		if($('#tags').val()!=''){
            aPoiName[PoiCount] =$('#tags').val()
			aPoiId[PoiCount] =0
			PoiCount = PoiCount + 1
			genTable()
			$('#div-addpoi').dialog( "close" );
		}
		
	}
	
	function AddPOI(){
		$('#tags').val('')
		$('#div-addpoi').dialog({width:350,  
			buttons: 
			[
			{
				text:dic("Routes.Add",lang),
				click: function(){
					dodadi();
				}
			},
			{
				text:dic("cancel",lang),
				click: function(){$( this ).dialog( "close" );}								
			}		
			]
		})
		//aPoiName[PoiCount] ='Тест ПОИ ' + PoiCount
		//aPoiId[PoiCount] =234
		//PoiCount = PoiCount + 1
		//genTable()
	}
	
	function CistiForma(){
		$('#txt_naslov').val('')
		$('#txt_vozilo').val(0)
		$('#txt_sofer1').val(0);
		txt_sofer1.disabled = true;
		$('#txt_alert').val('/')
		$('.ui-autocomplete-input').val('');
		top.HideWait()
	}
	
	var cntAjax  = 0
	var NalogID  = -1
	
	
	function ShowPrezemi(){
		$('#div-prez').dialog({height:370,
			buttons:
			[
			 {
			 	text:dic("Routes.Download",lang),
				click: function(){
					Prevzemi()
					$( this ).dialog( "close" );
				}
			},
			{
				text:dic("Tracking.Close",lang),
				click: function(){$( this ).dialog( "close" );}								
			}	
			]
		})	
	}

</script>

<body style="margin:0px 0px 0px 0px; padding:0px 0px 0px 0px" onResize="SetHeightLite111()">

<div id="report-content" style="width:100%; text-align:left; height:100%; background-color:#fff; overflow-y:hidden; overflow-x:hidden" class="corner5">
	<br>
	<div style="padding-left:40px; padding-top:10px; width:500px" class="textTitle">
		<?php echo dic_("Routes.RoutesReport")?>&nbsp;&nbsp;&nbsp;&nbsp;
	</div><br>
	<div class="corner5" style="width:95%; height:75%; padding:10px 10px 10px 10px; border:1px solid #bbb; background-color:#fafafa; margin-left:1%">
		
			<div style="margin-left:5px" class="text4"><strong><?php echo dic_("Routes.SearchOrderBy")?>:</strong></div><br>
			<span class="text2"><?php echo dic_("Routes.NumberOfOrder")?></span>&nbsp;<input id="txt_naslov" type="text" class="textboxCalender corner5 text1" style="width:400px; margin-left:11px; font-weight:bold" value="" onclick="$(this).focus();" />
			<br><br>
			<span class="text2"><?php echo dic("Routes.Vehicle")?></span>&nbsp;
			<select id="txt_vozilo" class="textboxCalender corner5 text2" style="width:400px; margin-left:39px; padding-top:5px; padding-bottom:3px" onchange="FilterByVeh()" onclick="$(this).focus();">
     		   		<option value="0"><?php echo dic("Routes.SelectVeh")?></option>
					<?php														    
					    $dsVeh = query("select v.id, '(' || code || ') ' || rtrim(Registration) || ' - ' || model naziv  from Vehicles v where v.clientid=" . session("client_id") . " ORDER BY code::INTEGER");
						while($row = pg_fetch_array($dsVeh))
						{
								?>
							<option value="<?php echo $row["id"]?>"><?php echo $row["naziv"]?></option>
							<?php
						}
					?>
			   </select>
			<br><br>
			
            
            <span class="text2" id="pois"><?php echo dic_("Settings.Poi1")?></span>&nbsp;
			<table width="<?php if($yourbrowser == "1") { echo '420px'; } else { echo '807px'; } ?>" id="tbl-poi" style="position: relative; float left; top: -22px; margin-left: 77px;">
				<tr>
                    <td id="widthR" align="center" class="text3" style="background-color: transparent; color:#39ae58; font-weight:bold; cursor:pointer" colspan="4">
                        <div class="ui-widget" style="height: 25px; width: 100%;">
	                        <select id="combobox" onclick="$(this).focus();">
		                        <option value=""><?php echo dic_("Routes.SelectOne")?>...</option>
                                <?php
                                    //$dsPP = query("select * from pointsofinterest where clientId=" . session("client_id") . " order by Name asc");
									/*$str3 = " and (pp.userid in (select id from users where organisationid in (select organisationid from users where id=" . session("user_id") . ")) or pp.userid=" . session("user_id") . " or pp.available = 3)";
								    $str1 = "";
									$str1 .= " select ST_X(ST_Transform(pp.geom,4326)) long, ST_Y(ST_Transform(pp.geom,4326)) lat, pp.name, pp.available, ";
									$str1 .= " pp.groupid, pp.id, ppg.fillcolor color, ppg.name groupname, pp.radius from pointsofinterest pp "; 
									$str1 .= " left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id  ";
									$str1 .= " where pp.clientid=" . session("client_id") ." and type=1 " . $str3 . " ORDER BY pp.id DESC";*/
									
									$str3 = " and (pp.userid in (select id from users where organisationid in (select organisationid from users where id=" . session("user_id") . ")) or pp.userid=" . session("user_id") . " or pp.available = 3)";
								    $str1 = "";
									$str1 .= " (select ST_X(ST_Transform(pp.geom,4326)) long, ST_Y(ST_Transform(pp.geom,4326)) lat, pp.name, pp.available, pp.type, ";
									$str1 .= " pp.groupid, pp.id, ppg.fillcolor color, ppg.name groupname, pp.radius from pointsofinterest pp "; 
									$str1 .= " left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id  ";
									$str1 .= " where pp.active='1' and pp.clientid=" . session("client_id") ." and type=1 and pp.groupid <> 240 " . $str3 . " ORDER BY pp.id DESC)";
									
									$str1 .= " union ";
									
									$str1 .= " (select st_y(st_centroid(geom)) long, st_x(st_centroid(geom)) lat, pp.name, pp.available, pp.type, ";
									$str1 .= " pp.groupid, pp.id, ppg.fillcolor color, ppg.name groupname, pp.radius from pointsofinterest pp "; 
									$str1 .= " left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id ";
									$str1 .= " where pp.active='1' and pp.clientid=" . session("client_id") ." and type=2 " . $str3 . " ORDER by pp.id DESC)";
									
									$str1 .= " union ";
									
									$str1 .= " (select st_y(st_centroid(geom)) long, st_x(st_centroid(geom)) lat, pp.name, pp.available, pp.type, ";
									$str1 .= " pp.groupid, pp.id, ppg.fillcolor color, ppg.name groupname, pp.radius from pointsofinterest pp "; 
									$str1 .= " left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id ";
									$str1 .= " where pp.active='1' and pp.clientid=" . session("client_id") ." and type=3 " . $str3 . " ORDER by pp.id DESC)";
									
									$dsPP = query($str1);
                                    while($row = pg_fetch_array($dsPP)) {
                                ?>
		                            <option value="<?php echo $row["id"] ?>|<?php echo $row["lat"] ?>|<?php echo $row["long"] ?>"><?php echo $row["name"]?></option>
                                <?php
                                    }
                                ?>
	                        </select>
                        </div>
                    </td>
                </tr>
			</table>
			<?php
				$dsDriver = query("select ID, code, FullName from Drivers where clientID=" . session("client_id") . " order by FullName");
			?>
			<span class="text2"><?php echo dic_("Routes.User")?></span>&nbsp;<select disabled id="txt_sofer1" class="textboxCalender corner5 text2" style="width:289px; padding-top:5px; padding-bottom:3px; margin-left:30px" onclick="$(this).focus();">
					<option value="0"><?php echo dic("Routes.SelectUser")?></option>
					<?php
					while($row = pg_fetch_array($dsDriver))
					{
						echo "<option value='" . $row["id"] . "'>" . $row["code"] . " - " . $row["fullname"] . "</option>";
					}
					?>
			  </select><br><br>
			<span class="text2"><?php echo dic_("Routes.From")?></span>&nbsp;-&nbsp;<span class="text2"><?php echo dic_("Routes.To")?>:</span>&nbsp;<input id="txtSDate" type="text" width="80px" class="textboxCalender corner5 text2" value="<?php echo $currDateTime2?>" style="margin-left:36px"/>
			-<input id="txtEDate" type="text" width="80px" class="textboxCalender corner5 text2" value="<?php echo $currDateTime1?>" style="margin-left:20px"/>
			<br /><br />
			<!--span class="text2" id="alerti"><?php echo dic("Routes.Alarm")?></span>&nbsp;
			
			<select class="textboxCalender corner5 text2" id="txt_alert" style="width: 70px; padding-top: 5px; padding-bottom: 3px; position: relative; top: -1px; margin-left: 42px;" onclick="$(this).focus();">
				<option value="0">/</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="15">15</option>
				<option value="20">20</option>
				<option value="30">30</option>
				<option value="40">40</option>
				<option value="50">50</option>
				<option value="60">60</option>
			</select>&nbsp;&nbsp;<span class="text2"><?php echo dic("Routes.Minutes")?></span><br /-->
			<span class="text2" id="alerti"><?php echo dic("Routes.Alarm")?></span>&nbsp;
			<select class="textboxCalender corner5 text2" id="txt_alert" style="width: 50px; padding-top: 5px; padding-bottom: 3px; position: relative; top: -1px; margin-top: 5px; margin-left: 40px;" onclick="$(this).focus();">
				<option value="/">/</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="15">15</option>
				<option value="20">20</option>
				<option value="30">30</option>
				<option value="40">40</option>
				<option value="50">50</option>
				<option value="60">60</option>
			</select>&nbsp;&nbsp;<span class="text2" style="position: relative; top: 6px;"><img id="alertiImg" src="../images/infocircle.png" /></span>
			<!--br /><br />
			<span class="text2" id="alertiWait" style="margin-left: 0px;">Задржување</span>&nbsp;
			<select class="textboxCalender corner5 text2" id="txt_alertWait" style="width: 50px; padding-top: 5px; padding-bottom: 3px; position: relative; top: -1px; margin-top: 5px; margin-left: 9px;" onclick="$(this).focus();">
				<option value="/">/</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="15">15</option>
				<option value="20">20</option>
				<option value="30">30</option>
				<option value="40">40</option>
				<option value="50">50</option>
				<option value="60">60</option>
			</select>&nbsp;&nbsp;<span class="text2" style="position: relative; top: 5px;"><img id="alertiWaitImg" src="../images/infocircle.png" /></span-->
            <br />
			<br />
			<br />
		<button id="btn-search" onClick="NalogSearch('<?=$dateformat?>')"><?php echo dic_("Routes.Search")?></button>
		<button id="btn-clear" onClick="CistiForma()"><?php echo dic_("Routes.Clear")?></button>
		
		<br><br>
	</div>
	
	<br><br>

	<br>
	<div id="footer-rights-new" class="textFooter" style="padding:10px 10px 10px 10px"></div>
	
	<div id="div-reports" style="display:none" title="<?php echo dic_("Routes.SearchOrdersTitle")?>">
		<iframe id="frm-reports" frameborder="0" scrolling="yes" style="width:100%; height:100%; overflow: hidden"></iframe>
	</div>
	<br><br>

</div>

</body>
</html>



<script type="text/javascript">
    lang = '<?php echo $cLang?>';
    
	top.changeItem = false;
    
    var clientUnit = '<?php echo $clientUnit?>';

    AllowedMaps = '<?php echo $AllowedMaps?>';
	DefMapType = '<?php echo $DefMap?>';
	var cntz = parseInt('<?php echo ($cntz-1)?>');

    LoadCurrentPosition = false;
    JustSave = false;

    ShowAreaIcons = true
    OpenForDrawing = false;
    ShowVehiclesMenu = false;
    ShowPOIBtn = true;
    ShowGFBtn = true;
    var RecOn = false;
    var RecOnNew = false;

	$('#btn-search').button({icons: {primary: "ui-icon-check"}});
	$('#btn-clear').button({icons: {primary: "ui-icon-check"}});
	
	if (Browser()!='iPad') {
		$('#alertiImg').mousemove(function (event) { ShowPopup(event, dic("alarm", lang)) });
		$('#alertiImg').mouseout(function (event) { HidePopup(); });
		$('#alertiWaitImg').mousemove(function (event) { ShowPopup(event, dic("Routes.RetainingXminPOI",lang)) });
		$('#alertiWaitImg').mouseout(function (event) { HidePopup(); });
		$('#pauseImg').mousemove(function (event) { ShowPopup(event, dic("Routes.BreaksRoute",lang)) });
		$('#pauseImg').mouseout(function (event) { HidePopup(); });
	}

	//CreateBoards();
    //LoadMaps();
    SetHeightLite()
    //iPadSettingsLite()
    top.HideLoading()
    $('#txtSDate').datepicker({
		dateFormat: '<?=$datejs?>',
		showOn: "button",
		buttonImage: "../images/cal1.png",
		buttonImageOnly: true
	});
	$('#txtEDate').datepicker({
		dateFormat: '<?=$datejs?>',
		showOn: "button",
		buttonImage: "../images/cal1.png",
		buttonImageOnly: true
	});
    if (Browser()=='iPad') {top.iPad_Refresh()}

    //stoenje
    $(document).ready(function () {
        $('.ui-autocomplete').css({ width: (parseInt($('#widthR').css('width'), 10) - 24) + 'px' });
        top.HideWait();
    });

    function FilterByVeh() {
        $.ajax({
            url: 'filterbyveh.php?id=' + txt_vozilo.value,
            success: function (data) {
                if (data.indexOf("Zero") != -1) {
                    txt_sofer1.disabled = true;
                    //txt_sofer2.disabled = true;
                    //txt_sofer3.disabled = true;
                } else {
                    //var dat = JXG.decompress(data);
                    var dat = data;
                    txt_sofer1.disabled = false;
                    //txt_sofer2.disabled = false;
                    //txt_sofer3.disabled = false;
                    var _opt = "<option value='0'><?php echo dic("Routes.SelectUser")?></option>";
                    for (var i = 0; i < dat.split("%@").length - 1; i++) {
                        _opt += "<option value='" + dat.split("%@")[i].split("|")[0] + "'>" + dat.split("%@")[i].split("|")[1] + " - " + dat.split("%@")[i].split("|")[2] + "</option>";
                    }
                    $('#txt_sofer1').empty();
                    $('#txt_sofer1').html(_opt);
                    //$('#txt_sofer2').empty();
                    //$('#txt_sofer2').html(_opt);
                    //$('#txt_sofer3').empty();
                    //$('#txt_sofer3').html(_opt);
                }
            }
        });
    }

</script>
<?php
	closedb();
?>