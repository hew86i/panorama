<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php

	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");

?>
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
	<style type="text/css">
	<?php
	if($yourbrowser == "1")
	{?>
		html { 
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch; 
		}
		body {
		    height: 100%;
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch;
		    
		}
	<?php
	}
	?>
	</style>
</head>

<?php

	opendb();
	if (session('user_id') == "261") echo header( 'Location: ../sessionexpired/?l='.$cLang);
	$Allow = getPriv("routesnew", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
	$id = getQUERY("id");
	
	$user_id = Session("user_id");
	$dsAll = query("select defaultmap, datetimeformat, timezone, metric, cl.clienttypeid, ci.latitude, ci.longitude from users u left outer join clients cl on cl.id = u.clientid left outer join cities ci on ci.id = cl.cityid where u.id = " . $user_id);

    $clientType = pg_fetch_result($dsAll, 0, "clienttypeid");
    $clientUnit = pg_fetch_result($dsAll, 0, "metric");
    
    //$allPOI = dlookup("select count(*) from pinpoints where clientID=" . session("client_id"));
    //$allPOIs As String = "false"
    //If allPOI < 1000 Then allPOIs = "true"
	
    $DefMap = pg_fetch_result($dsAll, 0, "defaultmap");
    	
    $currDateTime = new Datetime();
    $currDateTime = $currDateTime->format("d-m-Y H:i");
	$currDateTime1 = new Datetime();
	$currDateTime1 = $currDateTime1->format("d-m-Y");
	//dd-MM-yyyy HH:mm 
    //now()->format("Y-m-d H:i:s");

    $AllowedMaps = "11111";
    

    $cntz = dlookup("select count(*) from pointsofinterest where type=2 and clientid=" . Session("client_id"));
    //$CurrentTime = DlookUP("select Convert(nvarchar(20), DATEADD(HOUR,(select timeZone from clients where ID=" . Session("client_id") . ") - 1,GETDATE()), 120) DateTime");
    $tzone = pg_fetch_result($dsAll, 0, "timezone");
	$tzone = $tzone - 1;
 
	$AllowAddPoi = getPriv("AddPOI", Session("user_id"));
	$AllowViewPoi = getPriv("ViewPOI", Session("user_id"));
	$AllowAddZone = getPriv("AddZones", Session("user_id"));
	$AllowViewZone = getPriv("ViewZones", Session("user_id"));

	
	$dsNalog = query("select * from rnalogheder where id=" . $id . " and clientid=" . session("client_id"));
	$tmpDT0 = new DateTime(pg_fetch_result($dsNalog, 0, "startdate"));
	$tmpDT = $tmpDT0->format("d-m-Y");
	$tmpDT1 = $tmpDT0->format("H");
	//echo $tmpDT1."<br/>";
	//echo $tmpDT."<br/>";
	//exit;
	//drNalog = dsNalog.tables(0).rows(0)
?>
<script>
	AllowAddPoi = '<?php echo $AllowAddPoi?>'
	AllowViewPoi = '<?php echo $AllowViewPoi?>'
	AllowAddZone = '<?php echo $AllowAddZone?>'
	AllowViewZone = '<?php echo $AllowViewZone?>'
</script>
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
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; width: <?php if($yourbrowser == "1") { echo '95.23%'; } else { echo '95.8%'; } ?>; height: 25px; }
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
					        if (Browser()!='iPad')
					        	$('.ui-autocomplete').css({ width: '610px' });
				        	else
				        		$('.ui-autocomplete').css({ width: '500px' });
					    },
					    close: function (event, ui) {
					        input.val('');
					    },
					    select: function (event, ui) {
					        ui.item.option.selected = true;
					        self._trigger("selected", event, {
					            item: ui.item.option
					        });
					        //optimalClick = true;
                            
                            putInRoute(ui.item.option.value.split("|")[0], ui.item.option.value.split("|")[2], ui.item.option.value.split("|")[1], ui.item.value, 1, ui.item.option.value.split("|")[0]);
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
                    //input.autocomplete("widget")[0].style.left = '27px';
                    input.autocomplete("widget")[0].style.overflowX = 'hidden';
                    input.autocomplete("widget")[0].style.overflowY = 'auto';
                    input.autocomplete("widget")[0].style.maxHeight = '210px';
                    if (Browser()!='iPad')
                    	input.autocomplete("widget")[0].style.width = '610px';
                	else
                		input.autocomplete("widget")[0].style.width = '500px';
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
					    //input.autocomplete("widget")[0].style.left = '27px';
					    input.autocomplete("widget")[0].style.overflowX = 'hidden';
					    input.autocomplete("widget")[0].style.overflowY = 'auto';
					    input.autocomplete("widget")[0].style.maxHeight = '210px';
					    if (Browser()!='iPad')
					    	input.autocomplete("widget")[0].style.width = '610px';
				    	else
							input.autocomplete("widget")[0].style.width = '500px';
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
        $("#toggle").click(function () {
            $("#combobox").toggle();
        });
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
	                        if (Browser() != 'iPad' && Browser() != 'Safari')
	                        	$('#MarkersIN').children()[i].children[3].attributes[0].value = $('#MarkersIN').children()[i].children[3].attributes[0].value.substring(0, $('#MarkersIN').children()[i].children[3].attributes[0].value.lastIndexOf("_") + 1) + i + "','" + i + "')";
                        	else
                        		$('#MarkersIN').children()[i].children[3].attributes[3].value = $('#MarkersIN').children()[i].children[3].attributes[3].value.substring(0, $('#MarkersIN').children()[i].children[3].attributes[3].value.lastIndexOf("_") + 1) + i + "','" + i + "')";
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
	                        if (Browser() != 'iPad' && Browser() != 'Safari')
	                        	$('#MarkersIN').children()[i].children[3].attributes[0].value = $('#MarkersIN').children()[i].children[3].attributes[0].value.substring(0, $('#MarkersIN').children()[i].children[3].attributes[0].value.lastIndexOf("_") + 1) + i + "','" + i + "')";
                        	else
                        		$('#MarkersIN').children()[i].children[3].attributes[3].value = $('#MarkersIN').children()[i].children[3].attributes[3].value.substring(0, $('#MarkersIN').children()[i].children[3].attributes[3].value.lastIndexOf("_") + 1) + i + "','" + i + "')";
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
		str = str + '	<td width="60px" height="22px" align="center" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185"><strong>Р. бр.</strong></td>'
		str = str + '	<td class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185"><strong>&nbsp;Точка од интерст</strong></td>'
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
		str = str + '	<td height="22px" align="center" class="text3" style="background-color:#fff; color:#39ae58; font-weight:bold; border:1px dotted #B8B8B8; cursor:pointer" colspan="3" onClick="AddPOI()"><img src="../images/dodadi.png" style="cursor:pointer" align="absmiddle"> Додади нова локација</td>'
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
			buttons: {
				"Додади": function(){
					dodadi();
				},
				"Откажи": function(){$( this ).dialog( "close" );}								
			}		
		})
		//aPoiName[PoiCount] ='Тест ПОИ ' + PoiCount
		//aPoiId[PoiCount] =234
		//PoiCount = PoiCount + 1
		//genTable()
	}
	function Brisi(red){
		var r=confirm("Дали сакате да ја отсртаните локацијата " + aPoiName[red] + ' ?');
		if (r==true) {
			var tmp1 = []
			var tmp2 = []
			var cnt = 0
			for(var i=0;i<PoiCount; i++){
				if (i!=red){
					tmp1[cnt] = aPoiName[i]
					tmp2[cnt] = aPoiId[i]
					cnt = cnt + 1
				}
			}
			PoiCount = cnt
			aPoiName  = []
			aPoiId  = []
			for(var i=0;i<PoiCount; i++){
				aPoiName[i] = tmp1[i]
				aPoiId[i] = tmp2[i]			
			}
			genTable()
		} else {
		  
		} 		
	}
	function Nagore(red){
		if (red>0){
			var aa = aPoiName[red]
			var bb= aPoiId[red]
			aPoiName[red] = aPoiName[red-1]
			aPoiId[red] = aPoiId[red-1]
			aPoiName[red-1] = aa
			aPoiId[red-1] = bb
			genTable()
		}
	}
	function Nadolu(red){
		if (red<PoiCount-1){
			var aa = aPoiName[red]
			var bb= aPoiId[red]
			aPoiName[red] = aPoiName[red+1]
			aPoiId[red] = aPoiId[red+1]
			aPoiName[red+1] = aa
			aPoiId[red+1] = bb
			genTable()
		}
	}
	function CistiForma(){
		$('#txt_naslov').val('')
		$('#txt_vozilo').val(0)
		$('#txt_sofer1').val(0)
		$('#txt_sofer2').val(0)
		$('#txt_sofer3').val(0)
		$('#txt_vreme').val('00:00')
		PoiCount = 0
		aPoiName  = []
		aPoiId  = []
		//genTable()
		$('#MarkersIN').html('');
		ClearGraphic();
		PointsOfRoute = [];
		for (var j = 0; j < tmpMarkersRoute.length; j++)
		    Markers[0].removeMarker(tmpMarkersRoute[j]);
		tmpMarkersRoute = [];
		PointsOfRoute = [];
		top.HideWait()
	}
	
	var cntAjax  = 0
	var NalogID  = -1
	function SaveNalog(){
		top.ShowWait()
		var naslov = $('#txt_naslov').val()
		var vozilo = $('#txt_vozilo').val()
		var sofer1 = $('#txt_sofer1').val()
		var sofer2 = $('#txt_sofer2').val()
		var sofer3 = $('#txt_sofer3').val()
		var datum = $('#txtSDate').val()
		var vreme = $('#txt_vreme').val();
		var alarm = $('#txt_alert').val();
		var url = encodeURI("id=" + <?php echo $id?> + "&n=" + naslov + "&vo=" + vozilo + "&d1=" + sofer1 + "&d2=" + sofer2 + "&d3=" + sofer3 + "&d=" + datum + "&v=" + vreme + "&alarm=" + alarm);
		//alert(url);
		//return false;
		$.ajax({
		    url: 'UpdateNHeader.php?' + url,
		    success: function (data) {
		    	if(PointsOfRoute.length == 0)
		    	{
		    		WaitForSave();
		    	}
		        for (var i = 1; i < PointsOfRoute.length; i++) {
		            var urld = encodeURI('o=' + PointsOfRoute[i].name + '&rbr=' + (i) + '&h=' + data + '&ppid=' + PointsOfRoute[i].id);
		            $.ajax({
		                url: 'UpdateNDetail.php?' + urld,
		                success: function (data) {
		                    cntAjax = cntAjax + 1;
		                    if (cntAjax == (PointsOfRoute.length - 1))
		                        WaitForSave();
		                }
		            });
		        }
		    }
		});
	}
	function WaitForSave() {
	    //if (cntAjax == PointsOfRoute.length) {
			top.HideWait()
			CistiForma()
			$('#div-mb').dialog({
				buttons: {
					"Печати": function(){
						document.getElementById('frm-print').src = 'PrintNalog.php?id='+NalogID
						$('#div-print').dialog({width:830, height:600})
					},
					"Експортирај во Excel": function(){
						document.getElementById('frm-excel').src = 'ExcelNalog.php?id='+NalogID						
					},					
					"Затвори": function(){ top.$('#ifrm-cont')[0].contentWindow.$('#div-promeni').dialog("close"); $( this ).dialog( "close" );}								
				}
			
			})
		//} else {
//			setTimeout("WaitForSave()")
		//}
	}
	function ShowPrezemi(){
		$('#div-prez').dialog({height:370,
			buttons: {
				"Превземи": function(){
					Prevzemi()
					$( this ).dialog( "close" );
				},
				"Затвори": function(){$( this ).dialog( "close" );}								
			}	
			
		})	
	}

	function Prevzemi(){
	    var id = $('#txt_pre').val();
	    CistiForma();
	    LoadRoute(id);
	}
	
</script>

<body style="margin:0px 0px 0px 0px; overflow: auto; padding:0px 0px 0px 0px" onResize="SetHeightLite111()">

<div id="report-content" style="width:100%; text-align:left; height: 990px; background-color:#fff; overflow: hidden" class="corner5">
	<div class="corner5" style="width:<?php if($yourbrowser == "1") { echo '96%'; } else { echo '95%'; } ?>; padding:10px 10px 10px <?php if($yourbrowser == "1") { echo '5px'; } else { echo '10px'; } ?>; border:1px solid #bbb; background-color:#fafafa; margin-left:1%">
		
			<span class="text2"><?php echo dic("Routes.NName")?></span>&nbsp;<input id="txt_naslov" type="text" class="textboxCalender corner5 text1" style="width: <?php if($yourbrowser == "1") { echo '300px'; } else { echo '400px'; } ?>; font-weight:bold" value="<?php echo pg_fetch_result($dsNalog, 0, "name")?>" onclick="$(this).focus();" />
			<span class="text2" style="margin-left:<?php if($yourbrowser == "1") { echo '28px'; } else { echo '50px'; } ?>"><?php echo dic("Routes.CreationDate")?></span>&nbsp;<input type="text" class="textboxCalender corner5 text2" readonly="" style="width:150px; background-color:#E4E4E4; font-weight:bold; text-align:center" value="<?php echo $currDateTime?>">
			<span class="text2" style="margin-left:10px">Корисник</span>&nbsp;<input type="text" class="textboxCalender corner5 text2" readonly="" style="width:250px; background-color:#E4E4E4; font-weight:bold; text-align:center" value="<?php echo session("user_fullname")?>"><br><br>
			
			<span class="text2"><?php echo dic("Routes.Vehicle")?></span>&nbsp;
			<select id="txt_vozilo" class="textboxCalender corner5 text2" style="width:400px; margin-left:20px; padding-top:5px; padding-bottom:3px" onchange="FilterByVeh()" onclick="$(this).focus();">
     		   		<option value="0"><?php echo dic("Routes.SelectVeh")?></option>
					<?php														    
					    $dsVeh = query("select v.id, '(' || code || ') ' || rtrim(Registration) || ' - ' || model naziv  from Vehicles v where v.clientid=" . session("client_id") . " order by code asc");
						while($row = pg_fetch_array($dsVeh))
						{
							if($row["id"] == pg_fetch_result($dsNalog, 0, "vehicleid"))
							{
								echo "<option selected='selected' value='" . $row["id"] . "'>" . $row["naziv"] . "</option>";															
							} else {
								echo "<option value='" . $row["id"] . "'>" . $row["naziv"] . "</option>";
							}
						}
					?>
			   </select>
			<br><br>

			<span class="text2"><?php echo dic("Routes.First")?> <?php echo dic("Routes.Driver")?></span>&nbsp;<select id="txt_sofer1" class="textboxCalender corner5 text2" style="width:<?php if($yourbrowser == "1") { echo '150px'; } else { echo '185px'; } ?>; padding-top:5px; padding-bottom:3px; margin-left:8px" onclick="$(this).focus();">
															<option value="0"><?php echo dic("Routes.Choose")?> <?php echo dic("Routes.First")?> <?php echo dic("Routes.Driver")?></option>
															<?php
															$dsDriver = query("select ID, code, FullName from Drivers where clientID=" . session("client_id") . " order by FullName");
															while($row = pg_fetch_array($dsDriver))
															{
						if($row["id"] == pg_fetch_result($dsNalog, 0, "driverid1"))
							echo "<option selected='selected' value='" . $row["id"] . "'>" . $row["code"] . " - " . $row["fullname"] . "</option>";
						else
																echo "<option value='" . $row["id"] . "'>" . $row["code"] . " - " . $row["fullname"] . "</option>";
															}
															?>
													  </select><?php if($yourbrowser == "1") { ?>&nbsp;&nbsp;<?php } else { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
			<span class="text2" ><?php echo dic("Routes.Second")?> <?php echo dic("Routes.Driver")?></span>&nbsp;<select id="txt_sofer2" class="textboxCalender corner5 text2" style="width:<?php if($yourbrowser == "1") { echo '150px'; } else { echo '185px'; } ?>; padding-top:5px; padding-bottom:3px; margin-left:<?php if($yourbrowser == "1") { echo '3px'; } else { echo '10px'; } ?>" onclick="$(this).focus();">
															<option value="0"><?php echo dic("Routes.Choose")?> <?php echo dic("Routes.Second")?> <?php echo dic("Routes.Driver")?></option>
															<?php
															$dsDriver = query("select ID, code, FullName from Drivers where clientID=" . session("client_id") . " order by FullName");
															while($row = pg_fetch_array($dsDriver))
															{
						if($row["id"] == pg_fetch_result($dsNalog, 0, "driverid2"))
							echo "<option selected='selected' value='" . $row["id"] . "'>" . $row["code"] . " - " . $row["fullname"] . "</option>";
						else
																echo "<option value='" . $row["id"] . "'>" . $row["code"] . " - " . $row["fullname"] . "</option>";
															}
															?>
													  </select><?php if($yourbrowser == "1") { ?>&nbsp;&nbsp;<?php } else { ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php } ?>
			<span class="text2"><?php echo dic("Routes.Third")?> <?php echo dic("Routes.Driver")?></span>&nbsp;<select id="txt_sofer3" class="textboxCalender corner5 text2" style="width:<?php if($yourbrowser == "1") { echo '150px'; } else { echo '185px'; } ?>; padding-top:5px; padding-bottom:3px; margin-left:<?php if($yourbrowser == "1") { echo '3px'; } else { echo '10px'; } ?>" onclick="$(this).focus();">
															<option value="0"><?php echo dic("Routes.Choose")?> <?php echo dic("Routes.Third")?> <?php echo dic("Routes.Driver")?></option>
															<?php
															$dsDriver = query("select ID, code, fullname from Drivers where clientID=" . session("client_id") . " order by FullName");
															while($row = pg_fetch_array($dsDriver))
															{
						if($row["id"] == pg_fetch_result($dsNalog, 0, "driverid3"))
							echo "<option selected='selected' value='" . $row["id"] . "'>" . $row["code"] . " - " . $row["fullname"] . "</option>";
						else
																echo "<option value='" . $row["id"] . "'>" . $row["code"] . " - " . $row["fullname"] . "</option>";
															}
															?>
							</select><br><br>
			<span class="text2"><?php echo dic("Routes.StartDatetime") ?></span>&nbsp;<input id="txtSDate" id="txt_datum" type="text" width="80px" class="textboxCalender corner5 text2" value="<?php echo $tmpDT?>" style="margin-left: 18px" />
			
			<select class="textboxCalender corner5 text2" id="txt_vreme" style="width:70px; padding-top:5px; padding-bottom:3px; margin-left:-10px" onclick="$(this).focus();">
				<?php
					for($i=0; $i<24;$i++)
					{
						if($i == intval($tmpDT1))
						{
							if($i < 10)
								$i = "0".$i;
							echo "<option selected='selected' value='" . $i . ":00'>" . $i . ":00</option>";
						} else {
							if($i < 10)
								$i = "0".$i;
							echo "<option value='" . $i . ":00'>" . $i . ":00</option>";
						}
					}
				?>
			</select>
            &nbsp;&nbsp;&nbsp;
            <span class="text2" id="alerti"><?php echo dic("Routes.Alarm")?></span>&nbsp;
			
			<select class="textboxCalender corner5 text2" id="txt_alert" style="width: 70px; padding-top: 5px; padding-bottom: 3px; position: relative; top: -1px; margin-left: 2px;" onclick="$(this).focus();">
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
			</select>&nbsp;&nbsp;<span class="text2"><?php echo dic("Routes.Minutes")?></span><br />
            <br />
			<div style="margin-left:5px; width:<?php if($yourbrowser == "1") { echo '668px'; } else { echo '800px'; } ?>" class="text4">
				<button id="btn-prezemi" onClick="ShowPrezemi()" style="float:right"><?php echo dic("Routes.DL")?></button>
			</div><br />
			<table width="<?php if($yourbrowser == "1") { echo '672px'; } else { echo '807px'; } ?>" id="tbl-poi" border="0" style="position: relative; z-index: 1;">
				<tr>
                    <td id="widthR" align="center" class="text3" style="background-color: transparent; color:#39ae58; font-weight:bold; cursor:pointer" colspan="4">
                        <table width="100%" border="0">
                        	<tr>
                        		<td width="20%"><strong class="text2">Избор на локација: </strong></td>
                        		<td width="80%">
                        			<div class="ui-widget" style="height: 25px; width: 100%;">
				                        <select id="combobox">
					                        <option value="">Select one...</option>
			                                <?php
			                                    //$dsPP = query("select * from pointsofinterest where clientId=" . session("client_id") . " order by Name asc");
												$str3 = " and (pp.userid in (select id from users where organisationid in (select organisationid from users where id=" . session("user_id") . ")) or pp.userid=" . session("user_id") . " or pp.available = 3)";
											    $str1 = "";
												$str1 .= " select ST_X(ST_Transform(pp.geom,4326)) lat, ST_Y(ST_Transform(pp.geom,4326)) long, pp.name, pp.available, ";
												$str1 .= " pp.groupid, pp.id, ppg.fillcolor color, ppg.name groupname, pp.radius from pointsofinterest pp "; 
												$str1 .= " left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id  ";
												$str1 .= " where pp.clientid=" . session("client_id") ." and type=1 " . $str3 . " ORDER BY pp.id DESC";
												$dsPP = query($str1);
			                                    while($row = pg_fetch_array($dsPP)) {
			                                ?>
					                            <option value="<?php echo $row["id"] ?>|<?php echo $row["lat"] ?>|<?php echo $row["long"] ?>"><?php echo $row["name"]?></option>
			                                <?
			                                    }
			                                ?>
				                        </select>
			                        </div>
                        		</td>
                        	</tr>
                        </table>
                        
                    </td>
                </tr>
                <tr>
					<!--td width="60px" height="22px" align="center" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185"><strong>Р. бр.</strong></td-->
					<td width="51%" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185"><strong>&nbsp;<?php echo dic("Routes.Pois")?></strong></td>
                    <td width="20%" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185"><strong>&nbsp;<?php echo dic("Routes.Distance")?></strong></td>
                    <td width="20%" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185"><strong>&nbsp;<?php echo dic("Routes.Time")?></strong></td>
					<td align="center" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185"><strong><?php echo dic("Routes.Operations")?></strong></td>
				</tr>
				<tr>
					<td height="30px" align="center" class="text3" style="background-color:#fff; color:#39ae58; font-weight:bold; border:1px dotted #B8B8B8; cursor:pointer" colspan="4">
                        <div id="MarkersIN" style="position: relative; background: transparent; top: 0px; opacity:0.9; z-index:999; bottom:2px; overflow-X: hidden; overflow-Y: auto;  height: auto; max-height: 300px; width: 100%;" class="text9 corner5"></div>
                        <!--div onClick="AddPOI()"><img src="../images/dodadi.png" style="cursor:pointer" align="absmiddle"> Додади нова локација</div-->
                    </td>
				</tr>
			</table>
            <div id="radioBtnDiv" style="width: <?php if($yourbrowser == "1") { echo '667px'; } else { echo '800px'; } ?>; padding-bottom: 8px; padding-top: 5px; margin-left: 3px;">
                <input type="radio" runat="server" name="testGroup" value="1" id="test1" checked /><label id="Label1" for="test1" style="cursor:hand" runat="server"><?php echo dic("Routes.Normal")?></label>
                <input type="radio" runat="server" name="testGroup" value="2" id="test2" /><label id="Label2" for="test2" style="cursor:hand" runat="server"><?php echo dic("Routes.Fast")?></label>
                <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" runat="server" name="testGroup1" value="3" id="test3" /><label id="Label3" for="test3" style="cursor:hand" runat="server">Оптимален пат</label-->
                <!--input type="radio" runat="server" name="testGroup1" value="4" id="test4" /><label id="Label4" for="test4" style="cursor:hand" runat="server">Нормално</label-->
            </div>
            <script type="text/javascript">
                $('#test1').button();
                $('#test2').button();
                $('#test3').button();
                $('#test4').button();
                $("input[name='testGroup']", $('#radioBtnDiv')).change(
                    function (e) {
                        // your stuffs go here
                        if ($('#MarkersIN')[0].children.length > 1) {
                            ReDrawRoute($(this).val());
                        }
                    });
            </script>
			<div id="div-map" style="width: <?php if($yourbrowser == "1") { echo '665px'; } else { echo '800px'; } ?>; height: 400px; border:1px dotted #2f5185; position: relative; z-index: 1; position: relative; left: 3px;"></div>
			<div id="optimizedNarrative" class="text9 corner15" style="display: none; right: 55px; overflow: hidden; width: 500px; height: 400px; position: absolute; background: none repeat scroll 0% 0% white; z-index: 10; opacity: 0.9; top: 35px;"></div>
		<br /><br />
		&nbsp;<button id="btn-save" onClick="SaveNalog()"><?php echo dic("Routes.Save")?></button>
		&nbsp;<button id="btn-clear" onClick="CistiForma()"><?php echo dic("Routes.Clear")?></button>
		
	</div>
	<br>
	<div id="footer-rights-new" class="textFooter" style="padding:10px 10px 10px 10px">
	</div>
	<div id="div-mb" style="display:none" title="Порака...">
		<br><br>
		<span class="text4" style="padding:20px 20px 20px 20px; font-size:16px"><?php echo dic("Routes.SuccAddRoute")?></span>
	</div>
	<br><br>
	<div id="div-print" style="display:none">
		<iframe id="frm-print" frameborder="0" scrolling="no" style="width:800px; height:1200px"></iframe>
	</div>
	<div id="div-prez" style="display:none">
		<select id="txt_pre" style="width:270; font-size:14px"  size="15" class="text5">
			<?php
				
				$dsPre = query("select id, name from rNalogheder where Name<>'' and clientID=" . session("client_id"));
				
				while($row = pg_fetch_array($dsPre)) {
			?>
			<option value="<?php echo $row["id"]?>"><?php echo $row["name"]?></option>
			<?php
				}
			?>
		</select>
	</div>
</div>
<iframe id="frm-excel" frameborder="0" scrolling="no" style="display:none"></iframe>
</body>
</html>



<script type="text/javascript">
    lang = '<?php echo $cLang?>';
    
    var clientUnit = '<?php echo $clientUnit?>';

    AllowedMaps = '<?php echo $AllowedMaps?>';
	DefMapType = '<?php echo $DefMap?>';
	var cntz = parseInt('<?php echo ($cntz-1)?>');

    LoadCurrentPosition = false;
    JustSave = false;

    ShowAreaIcons = true
    OpenForDrawing = false;
    ShowVehiclesMenu = false;
	if(AllowViewPoi == "1")
    	ShowPOIBtn = true;
	else
		ShowPOIBtn = false;
    if(AllowViewZone == "1")
    	ShowGFBtn = true;
	else
		ShowGFBtn = false;
    var RecOn = false;

	$("#test3").click(function (event) {
        optimalClick = false;
        var _len = parseInt($('#MarkersIN')[0].children.length, 10);
        if (_len < 2) return false;
        $('#optimizedNarrative').css({ display: 'block' });
        var _ids = "";
        for (var i = 0; i < _len; i++)
            _ids += $('#MarkersIN')[0].children[i].id.substring($('#MarkersIN')[0].children[i].id.indexOf("_") + 1, $('#MarkersIN')[0].children[i].id.lastIndexOf("_")) + ",";
        _ids = _ids.substring(0, _ids.length - 1);
        ShowWait();
        $('#MarkersIN').html('');
        ClearGraphic();
        for (var j = 0; j < tmpMarkersRoute.length; j++)
            Markers[0].removeMarker(tmpMarkersRoute[j]);
        tmpMarkersRoute = [];
        doOptimized('optimizedroute', 'renderOptimized');
        HideWait();
    });
	$("#test4").click(function (event) {
        optimalClick = false;
        var _len = parseInt($('#MarkersIN')[0].children.length, 10);
        if (_len < 2) return false;
        $('#optimizedNarrative').html('');
        $('#optimizedNarrative').css({ display: 'block' });
        var _ids = "";
        for (var i = 0; i < _len; i++)
            _ids += $('#MarkersIN')[0].children[i].id.substring($('#MarkersIN')[0].children[i].id.indexOf("_") + 1, $('#MarkersIN')[0].children[i].id.lastIndexOf("_")) + ",";
        _ids = _ids.substring(0, _ids.length - 1);
        ShowWait();
        $('#MarkersIN').html('');
        ClearGraphic();
        for (var j = 0; j < tmpMarkersRoute.length; j++)
            Markers[0].removeMarker(tmpMarkersRoute[j]);
        tmpMarkersRoute = [];
        doOptimized('route', 'renderRoute');
        HideWait();
    });
    
	$('#btn-save').button({icons: {primary: "ui-icon-check"}});
	$('#btn-clear').button({icons: {primary: "ui-icon-close"}});
	$('#btn-prezemi').button({icons: {primary: "ui-icon-link"}});

	if (Browser()!='iPad') {
		$('#alerti').mousemove(function (event) { ShowPopup(event, dic("alarm", lang)) });
		$('#alerti').mouseout(function (event) { HidePopup(); });
	}
	CreateBoards();
    LoadMaps();
    SetHeightLite111()
    //iPadSettingsLite()
    top.HideLoading()
    $('#txtSDate').datepicker({
		dateFormat: 'dd-mm-yy',
		showOn: "button",
		buttonImage: "../images/cal1.png",
		buttonImageOnly: true
	});
	var id = '<?php echo $id?>';
    LoadRoute(id);
    if (Browser()=='iPad') {top.iPad_Refresh()}

    //stoenje
    $(document).ready(function () {
    	if (Browser()!='iPad')
        	$('.ui-autocomplete').css({ width: '610px' });
    	else
    		$('.ui-autocomplete').css({ width: '500px' });
        $('#div-map').css({ height: '402px' });
        top.HideWait();
    });

    function FilterByVeh() {
    	
        $.ajax({
            url: 'filterbyveh.php?id=' + txt_vozilo.value,
            success: function (data) {
                if (data == "Zero") {
                    txt_sofer1.disabled = true;
                    txt_sofer2.disabled = true;
                    txt_sofer3.disabled = true;
                } else {
                    //var dat = JXG.decompress(data);
                    var dat = data;
                    txt_sofer1.disabled = false;
                    txt_sofer2.disabled = false;
                    txt_sofer3.disabled = false;
                    var _opt = "<option value='0'>Избери прв возач</option>";
                    for (var i = 0; i < dat.split("%@").length - 1; i++) {
                        _opt += "<option value='" + dat.split("%@")[i].split("|")[0] + "'>" + dat.split("%@")[i].split("|")[1] + " - " + dat.split("%@")[i].split("|")[2] + "</option>";
                    }
                    $('#txt_sofer1').empty();
                    $('#txt_sofer1').html(_opt);
                    $('#txt_sofer2').empty();
                    $('#txt_sofer2').html(_opt);
                    $('#txt_sofer3').empty();
                    $('#txt_sofer3').html(_opt);
                }
            }
        });
    }

</script>
<?php
	closedb();
?>
