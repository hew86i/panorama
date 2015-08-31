<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php

	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	$yourbrowser1 = (bool) strpos($ua['userAgent'], "Macintosh");

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
	$dsAll = query("select defaultmap, datetimeformat, timezone, metric, cl.clienttypeid, ci.latitude, ci.longitude, cl.allowedrouting, cl.allowedfm, cl.allowedmess, cl.allowedalarms from users u left outer join clients cl on cl.id = u.clientid left outer join cities ci on ci.id = cl.cityid where u.id = " . $user_id);
	$allowedrouting = pg_fetch_result($dsAll, 0, "allowedrouting");
	$allowedFM = pg_fetch_result($dsAll, 0, "allowedfm");
	$allowedMess = pg_fetch_result($dsAll, 0, "allowedmess");
	$allowedAlarms = pg_fetch_result($dsAll, 0, "allowedalarms");

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
	
	$naslov = pg_fetch_result($dsNalog, 0, "name");
	$alarm = pg_fetch_result($dsNalog, 0, "alarm");
	$totalkm = pg_fetch_result($dsNalog, 0, "totalkm");
	$totaltime = pg_fetch_result($dsNalog, 0, "totaltime");
	$vozilo = pg_fetch_result($dsNalog, 0, "vehicleid");
	
	
	$driverid1 = pg_fetch_result($dsNalog, 0, "driverid1");
	$driverid2 = pg_fetch_result($dsNalog, 0, "driverid2");
	$driverid3 = pg_fetch_result($dsNalog, 0, "driverid3");
	
	$tostay = pg_fetch_result($dsNalog, 0, "tostay");
	
	$pause1 = pg_fetch_result($dsNalog, 0, "pause1");
	$pause2 = pg_fetch_result($dsNalog, 0, "pause2");
	$pause3 = pg_fetch_result($dsNalog, 0, "pause3");
	$pause4 = pg_fetch_result($dsNalog, 0, "pause4");
	$pause5 = pg_fetch_result($dsNalog, 0, "pause5");
	
	$tmpDT0 = new DateTime(pg_fetch_result($dsNalog, 0, "startdate"));
	$tmpDT = $tmpDT0->format("d-m-Y");
	$tmpDT1 = $tmpDT0->format("H");
	//echo $tmpDT1."<br/>";
	//echo $tmpDT."<br/>";
	//exit;
	//drNalog = dsNalog.tables(0).rows(0)
	$pauseTemp = array(5,10,15,20,25,30,35,40,45,50,55,60);
	
	if(pg_fetch_result($dsNalog, 0, "culid") != "0")
	{
		$dsNalogCul = query("select * from route_defculture where id=" . pg_fetch_result($dsNalog, 0, "culid"));
	
		$culture = pg_fetch_result($dsNalogCul, 0, "culid");
		$operation = pg_fetch_result($dsNalogCul, 0, "operid");
		$material = pg_fetch_result($dsNalogCul, 0, "matid");
		$mechanization = pg_fetch_result($dsNalogCul, 0, "mechid");
	}
	
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
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; width: <?php if($yourbrowser == "1") { echo '93.8%'; } else { echo '94.8%'; } ?>; height: 25px; }
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
                            uncheck('#MarkersIN');
                            putInRoute(ui.item.option.value.split("|")[0], ui.item.option.value.split("|")[2], ui.item.option.value.split("|")[1], ui.item.value, 1, ui.item.option.value.split("|")[0], ui.item.option.value.split("|")[3]);
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
		str = str + '	<td height="22px" align="center" class="text3" style="background-color:#fff; color:#39ae58; font-weight:bold; border:1px dotted #B8B8B8; cursor:pointer" colspan="3" onClick="AddPOI()"><img src="../images/dodadi.png" style="cursor:pointer" align="absmiddle"> <?php echo dic_("Routes.AddNewLocation")?></td>'
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
	function Brisi(red){
		var r=confirm(dic("Routes.DeleteLocationQ",lang) + aPoiName[red] + ' ?');
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
		
		/*za ZKPelagonija*/
		if (document.getElementById('culture'))
			document.getElementById('culture').selectedIndex = 0;
		if (document.getElementById('operation'))	
			document.getElementById('operation').innerHTML = 0;
		if (document.getElementById('material'))	
			document.getElementById('material').innerHTML = 0;
		if (document.getElementById('mechanisation'))	
			document.getElementById('mechanisation').innerHTML = 0;
		/*za ZKPelagonija*/
		
		$('#txt_naslov').val('')
		$('#txt_vozilo').val(0)
		$('#txt_sofer1').val(0)
		$('#txt_sofer2').val(0)
		$('#txt_sofer3').val(0)
		$('#txt_vreme').val('00:00');
		
		$('#txt_alert').val("/");
		$('#txt_alertWait').val("/");
		$('#txt_pause1').val(0);
		$('#txt_pause2').val(0);
		$('#txt_pause3').val(0);
		$('#txt_pause4').val(0);
		$('#txt_pause5').val(0);
		PoiCount = 0
		aPoiName  = []
		aPoiId  = []
		//genTable()
		$('#MarkersIN').html('');
		$('#PauseOnRoute').html('');
		$('#IDMarker_Total').css({ display: 'none' });
		$('#IDMarker_Total')[0].children[1].value = "/";
		$('#IDMarker_Total')[0].children[2].value = "/";
		ClearGraphicRoute();
		PointsOfRoute = [];
		for (var j = 0; j < tmpMarkersRoute.length; j++)
		    Markers[0].removeMarker(tmpMarkersRoute[j]);
		tmpMarkersRoute = [];
		PointsOfRoute = [];
		top.HideWait()
	}
	function ClearGraphicRoute() {
	    for (var z = 0; z < Maps.length; z++) {
	        if (vectors[z] != null) {
	            vectors[z].removeAllFeatures();
	            ArrAreasCheck[z] = [];
	        }
	    }
	    //if (ArrLineFeature != undefined && ArrLineFeature != '')
	        //vectors[0].addFeatures(ArrLineFeature);
	}
	function CistiForma1() {
		//$('#txt_naslov').val('')
		//$('#txt_vozilo').val(0)
		//$('#txt_sofer1').val(0)
		//$('#txt_sofer2').val(0)
		//$('#txt_sofer3').val(0)
		//$('#txt_vreme').val('00:00');
		
		//$('#txt_alert').val("/");
		//$('#txt_alertWait').val("/");
		//$('#txt_pause1').val(0);
		//$('#txt_pause2').val(0);
		//$('#txt_pause3').val(0);
		//$('#txt_pause4').val(0);
		//$('#txt_pause5').val(0);
		PoiCount = 0
		aPoiName  = []
		aPoiId  = []
		//genTable()
		$('#MarkersIN').html('');
		$('#PauseOnRoute').html('');
		$('#IDMarker_Total').css({ display: 'none' });
		$('#IDMarker_Total')[0].children[1].value = "/";
		$('#IDMarker_Total')[0].children[2].value = "/";
		ClearGraphicRoute();
		PointsOfRoute = [];
		for (var j = 0; j < tmpMarkersRoute.length; j++)
		    Markers[0].removeMarker(tmpMarkersRoute[j]);
		tmpMarkersRoute = [];
		PointsOfRoute = [];
		top.HideWait()
	}
	
	var cntAjax  = 0
	var NalogID  = -1
	function msgboxRoute(msg) {
	    $("#DivInfoForAll").css({ display: 'none' });
	    $('#div-msgbox').html(msg)
	    $("#dialog:ui-dialog").dialog("destroy");
	    $("#dialog-message").dialog({
	        modal: true,
	        zIndex: 9999, resizable: false,
	        buttons: {
	            Ok: function () {
	                $(this).dialog("close");
	            }
	        }
	    });
	}
	function SaveNalog(){
				
		/*za ZKPelagonija*/
				
		//$('#1culture').find('#culture').val()
		if (document.getElementById('culture'))
			if ($('#culture').children(":selected").val() != undefined)
				culid = $('#culture').children(":selected").val();
		if (document.getElementById('operation'))
			if ($('#operation').children(":selected").val() != undefined)
				operid = $('#operation').children(":selected").val();
		if (document.getElementById('material'))
			if ($('#material').children(":selected").val() != undefined)
				matid = $('#material').children(":selected").val();
		if (document.getElementById('mechanisation'))
			if ($('#mechanisation').children(":selected").val() != undefined)
				mechid = $('#mechanisation').children(":selected").val();
		/*za ZKPelagonija*/
		
		var naslov = $('#txt_naslov').val()
		var vozilo = $('#txt_vozilo').val()
		var sofer1 = $('#txt_sofer1').val()
		var sofer2 = $('#txt_sofer2').val()
		var sofer3 = $('#txt_sofer3').val()
		var datum = $('#txtSDate').val()
		var vreme = $('#txt_vreme').val();
		var alarm = $('#txt_alert').val();
		var zadrz = $('#txt_alertWait').val();
		var pause1 = $('#txt_pause1').val();
		var pause2 = $('#txt_pause2').val();
		var pause3 = $('#txt_pause3').val();
		var pause4 = $('#txt_pause4').val();
		var pause5 = $('#txt_pause5').val();
		var totalKm = parseFloat($('#IDMarker_Total')[0].children[1].value, 10);
		var totalTime = Str2Sec($('#IDMarker_Total')[0].children[2].value);
		
		if(PointsOfRoute.length == 2)
		{
			totalKm = 0;
			totalTime = 0;
		}

		if(naslov == "" || vozilo == "0" || sofer1 == "0" || PointsOfRoute.length == 0)
		{
			msgboxRoute(dic("Routes.NoenteredReqData",lang));
			if(naslov == "")
			{
				$('#txt_naslov').attr({ class: $('#txt_naslov').attr('class') + ' shadow' });
				$('#txt_naslov').css({ border: '2px solid Red' });
			}
			if(vozilo == "0")
			{
				$('#txt_vozilo').attr({ class: $('#txt_vozilo').attr('class') + ' shadow' });
				$('#txt_vozilo').css({ border: '2px solid Red' });
			}
			if(sofer1 == "0")
			{
				$('#txt_sofer1').attr({ class: $('#txt_sofer1').attr('class') + ' shadow' });
				$('#txt_sofer1').css({ border: '2px solid Red' });
			}
			if(PointsOfRoute.length == 0)
			{
				$('#MarkersIN').parent().attr({ class: $('#MarkersIN').parent().attr('class') + ' shadow' });
				$('#MarkersIN').parent().css({ border: '2px solid Red' });
			}
		}
		else
		{
			top.ShowWait()
			var url = encodeURI("id=" + <?php echo $id?> + "&n=" + naslov + "&vo=" + vozilo + "&d1=" + sofer1 + "&d2=" + sofer2 + "&d3=" + sofer3 + "&d=" + datum + "&v=" + vreme + "&alarm=" + alarm + "&zadrz=" + zadrz + "&pause1=" + pause1 + "&pause2=" + pause2 + "&pause3=" + pause3 + "&pause4=" + pause4 + "&pause5=" + pause5 + "&totalkm=" + totalKm + "&totaltime=" + totalTime);
			//alert(url);
			//return false;
			$.ajax({
		    url: 'UpdateNHeader.php?' + url,
			    success: function (data) {
			    	
			    	data = data.replace("\r", "").replace("\n", "");
			    	data = data.replace("\r", "").replace("\n", "");
			    	NalogID = data;

			 		 //gi vrti site kulturi
		 		 	var i=1;
					//for (var i = 1; i <= cntDivs; i++) {
						var cul = $('#' + i + 'culture').find('#culture').val();
						var oper = $('#' + i + 'culture').find('#operation').val();
						var mat = $('#' + i + 'culture').find('#material').val();
						var mech = $('#' + i + 'culture').find('#mechanisation').val();

						$.ajax({
			                url: 'UpdateNCulture.php?cul=' + cul + '&oper=' + oper + '&mat=' + mat + '&mech=' + mech + '&nalogid=' + NalogID + '&numCul=' + i,
			                success: function (data) {
			                    //alert(data)
			                }
			            });
					//}
					//

			    	
			    	if(PointsOfRoute.length == 0)
			    	{
			    		WaitForSave();
			    	}
			        for (var i = 1; i < PointsOfRoute.length; i++) {
			        	if(i==1)
			        	{
			        		var pointkm = 0;
			        		var pointtime = 0;
			        	} else
			        	{
			        		var pointkm = parseFloat($('#IDMarker_'+PointsOfRoute[i].id+"_"+(i-1))[0].children[1].value);
			        		var pointtime = $('#IDMarker_'+PointsOfRoute[i].id+"_"+(i-1))[0].children[2].value;
			        		pointtime = Str2Sec(pointtime.substring(0, pointtime.indexOf("(")-1));
			        	}
			            var urld = encodeURI('o=' + PointsOfRoute[i].name + '&rbr=' + (i) + '&h=' + data + '&ppid=' + PointsOfRoute[i].id + '&pointkm='+pointkm+'&pointtime=' + pointtime);
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
	}
	function WaitForSave() {
	    //if (cntAjax == PointsOfRoute.length) {
			top.HideWait();
			CistiForma();
			$('#newroutenum').html(NalogID);
			$('#div-mb').dialog({ width: 450, height: 240,
				buttons:
				[
				 {
				 	text:dic("Routes.Print",lang),
					click: function(){
						document.getElementById('frm-print').src = 'PrintNalog.php?id='+NalogID+'&l='+lang;
						$('#div-print').dialog({width:830, height:600})
					}
					},
					{
						text:dic("Routes.ExportToExcel",lang),
						click: function(){
						document.getElementById('frm-excel').src = 'ExcelNalog.php?id='+NalogID+'&l='+lang;	
						}				
					},		
					{
						text:dic("Tracking.Close",lang),			
						click: function(){
							top.$('#ifrm-cont')[0].contentWindow.$('#div-promeni').dialog("close");
							$( this ).dialog( "close" );
							top.$('#ifrm-cont')[0].contentWindow.location.reload();
						}								
				}
				]
			
			})
		//} else {
//			setTimeout("WaitForSave()")
		//}
	}
	function ShowPrezemi(){
		$('#div-prez').dialog({height:370,
			buttons:[ 
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

	function Prevzemi(){
	    var id = $('#txt_pre').val();
	    CistiForma1();
	    LoadRoute(id);
	}
	function uncheck(_id)
	{
		if(_id == '#MarkersIN')
		{
			$('#MarkersIN').parent().attr({ class: $('#MarkersIN').parent().attr('class').replace(' shadow', '') });
			$('#MarkersIN').parent().css({ border: '1px dotted #B8B8B8' });
		} else
		{
			$('#'+_id).attr({ class: $('#'+_id).attr('class').replace(' shadow', '') });
			$('#'+_id).css({ border: '1px solid #CCCCCC' });
		}
	}
	function unchange()
	{
		
	}
	function unchange1()
	{
		var naslovCheck = $('#txt_naslov').val()
		var voziloCheck = $('#txt_vozilo').val()
		var sofer1Check = $('#txt_sofer1').val()
		var sofer2Check = $('#txt_sofer2').val()
		var sofer3Check = $('#txt_sofer3').val()
		var alarmCheck = $('#txt_alert').val();
		var zadrzCheck = $('#txt_alertWait').val();
		var pause1Check = $('#txt_pause1').val();
		var pause2Check = $('#txt_pause2').val();
		var pause3Check = $('#txt_pause3').val();
		var pause4Check = $('#txt_pause4').val();
		var pause5Check = $('#txt_pause5').val();
		if(naslov != naslovCheck || currdt != $('#txtSDate').val() || $('#txt_vreme').val() != "00:00" || vozilo != voziloCheck || alarm != alarmCheck || tostay != zadrzCheck || driverid1 != sofer1Check || driverid2 != sofer2Check || driverid3 != sofer3Check || pause1 != pause1Check || pause2 != pause2Check || pause3 != pause3Check || pause4 != pause4Check || pause5 != pause5Check || parseFloat(totalkm) != parseFloat($('#IDMarker_Total').children()[1].value))
		{
			top.changeItem = true;
		} else
		{
			top.changeItem = false;
		}
	}
</script>

<body style="margin:0px 0px 0px 0px; overflow: auto; padding:0px 0px 0px 0px" onResize="SetHeightLite111()">
<div id="dialog-message" title="<?php echo dic_("Reports.Warning")?>" style="display:none">
	<p>
		<span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px; padding-left: 23px;"></div>
	</p>
    <div id="DivInfoForAll" style="font-size:11px; padding-left: 23px;"><input id="InfoForAll" type="checkbox" /><?php echo dic("Tracking.InfoMsg")?></div>
</div>

<div id="dialog-draw-area" title="<?php echo dic("Tracking.DrawArea")?>" style="display:none">
	<iframe src="" id="ifrm-edit-areas" scrolling="no" frameborder="0" style="border:0px dotted #387cb0"></iframe>
</div>
<div id="div-Add-Group" style="display: none;" title="<?php echo dic("Tracking.AddGroup")?>">
	<span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.GroupName")?></span><input id="GroupName" type="text" class="textboxCalender corner5" style="width:220px" /><br /><br />
    <span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;"><?php echo dic("Tracking.Color")?></span>
    <div id="colorPicker2">
		<span id="colorPicker1" style="cursor: pointer; float:left; border:1px solid black; width:20px; height:20px;margin:5px;"></span>
		<input id="clickAny" type="text" class="textboxCalender corner5" onchange="changecolor()" value="" style="width:120px" />
	</div>
    <img id="loadingIconsPOI" style="visibility: hidden; width: 150px; position: absolute; left: 32px; top: 185px;" src="../images/loading_bar1.gif" alt="" />
    <br><br>
    <span id="spanIconsPOI" style="display:none; width:90px; float:left; margin-left:20px; position: relative; top: 9px;"><?php echo dic("General.Icon")?></span>
    <table id="tblIconsPOI" border="0" style="display: none; width: 268px; text-align: center; position: relative; top: -10px; left: -15px;">
        <tr>
        <?php
            for ($icon=0; $icon <= 0; $icon++) { 
        ?>
            <td><img id="GroupIconImg<?php echo $icon?>" src="http://gps.mk/new/pin/?color=ffffff&type=<?php echo $icon?>" alt="" /></td>
        <?php
            }
        ?>
        </tr>
        <tr>
        <?php

            for ($icon=0; $icon <= 0; $icon++) { 
                if($icon == 0)
                {
                    ?>
                    <td><input style="cursor: pointer;" id="GroupIcon<?php echo $icon?>" name="GroupIcon" checked type="radio" /></td>
                    <?php
                } else
				{
                    ?>
                    <td><input style="cursor: pointer;" id="GroupIcon<?php echo $icon?>" name="GroupIcon" type="radio" /></td>
                    <?php
                }
            
            }
        ?>
        </tr>
        <!--tr>
        <?php
            for ($icon=8; $icon <= 14; $icon++) { 
            ?>
            <td  style="padding-top: 20px"><img id="GroupIconImg<?php echo $icon?>" src="http://gps.mk/new/pin/?color=ffffff&type=<?php echo $icon?>" alt="" /></td>
            <?php
            }
            ?>
        </tr>
        <tr>
        <?php
            for ($icon=8; $icon <= 14; $icon++) { 
            ?>
            <td><input style="cursor: pointer;" id="GroupIcon<?php echo $icon?>" name="GroupIcon" type="radio" /></td>
            <?php
            }
            ?>
        </tr>
        <tr>
        <?php
            for ($icon=15; $icon <= 21; $icon++) { 
            ?>
            <td  style="padding-top: 20px"><img id="GroupIconImg<?php echo $icon?>" src="http://gps.mk/new/pin/?color=ffffff&type=<?php echo $icon?>" alt="" /></td>
            <?php
            }
            ?>
        </tr>
        <tr>
        <?php
            for ($icon=15; $icon <= 21; $icon++) { 
            ?>
            <td><input style="cursor: pointer;" id="GroupIcon<?php echo $icon?>" name="GroupIcon" type="radio" /></td>
            <?php
            }
            ?>
        </tr-->
    </table>
    <br /><br />
	<div align="right" style="display:block; width:330px">
        <img id="loading1" style="display: none; width: 150px; position: absolute; left: 32px; margin-top: 7px;" src="../images/loading_bar1.gif" alt="" />
		<input type="button" class="BlackText corner5" id="btnAddGroup" value="<?php echo dic("Tracking.Add")?>" onclick="ButtonAddGroupOkClick()" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnCancelGroup" value="<?php echo dic("Tracking.Cancel")?>" onclick="$('#div-Add-Group').dialog('destroy');" />
	</div><br />
</div>
<div id="div-ver-DelGroup" style="display: none;" title="<?php echo dic("Tracking.DeletePoi")?>">
	<span class="ui-icon ui-icon-alert" style="position: absolute; left: 11px; top: 7px;"></span>
    <div align="center" style="font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo dic("Tracking.DeleteThisPoi")?></div><br />
	<div align="center" style="display:block;">
		<input type="button" class="BlackText corner5" id="btnYesDelGroup" value="<?php echo dic("Tracking.Yes")?>" onclick="$('#div-ver-DelGroup').dialog('destroy'); ButtonDeletePOIokClick()" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnCancelDelGroup" value="<?php echo dic("Tracking.No")?>" onclick="$('#div-ver-DelGroup').dialog('destroy');" />
	</div><br />
</div>
<div id="div-ver-DelGeoF" style="display: none;" title="<?php echo dic("Tracking.DeleteGF")?>">
	<div style="background: url('../images/izv.png')"></div>
    <div align="center" style="font-size:14px">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo dic("Tracking.DeleteThisGeoFence")?></div><br />
	<div align="center" style="display:block;">
		<input type="button" class="BlackText corner5" id="btnYesDelGF" value="<?php echo dic("Tracking.Yes")?>" onclick="$('#div-ver-DelGeoF').dialog('destroy'); ButtonDeleteGFokClick()" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnCancelDelGF" value="<?php echo dic("Tracking.No")?>" onclick="$('#div-ver-DelGeoF').dialog('destroy');" />
	</div><br />
</div>

<div id="div-Add-POI" style="display: none;">
	<br />
	<table style="font-size: 11px; color: rgb(65, 65, 65); font-family: Arial,Helvetica,sans-serif; margin-left: 20px;" cellpadding="0" cellspacing="0" border="0">
    	<tr>
    		<td width="90px"><?php echo dic("Tracking.Latitude")?></td>
    		<td>
    			<input id="poiLat" type="text" class="textboxCalender corner5" style="width:120px" />
    		</td>
		</tr>
		<tr height="50px">
    		<td width="90px"><?php echo dic("Tracking.Longitude")?></td>
    		<td>
    			<input id="poiLon" type="text" class="textboxCalender corner5" style="width:120px" />
    		</td>
		</tr>
		<tr>
    		<td width="90px"><?php echo dic("Tracking.Address")?></td>
    		<td>
    			<input id="poiAddress" type="text" class="textboxCalender corner5" style="width:269px; position: relative; float: left;" /><img id="loadingAddress" style="visibility: hidden; position: relative; float: left; top: 2px;" width="25px" src="../images/loadingP1.gif" border="0" align="absmiddle" />
    		</td>
		</tr>
		<tr height="50px">
    		<td width="90px"><?php echo dic("Tracking.NamePoi")?></td>
    		<td>
    			<input id="poiName" type="text" class="textboxCalender corner5" style="width:269px" />
    		</td>
		</tr>
		<tr>
    		<td width="90px"><?php echo dic("Tracking.AvailableFor")?></td>
    		<td>
    			<div id="poiAvail" class="corner5" style="font-size: 10px">
			        <input type="radio" id="APcheck1" name="radio" /><label for="APcheck1"><?php echo dic("Tracking.User")?></label>
			        <input type="radio" id="APcheck2" name="radio" /><label for="APcheck2"><?php echo dic("Tracking.OrgU")?></label>
			        <input type="radio" id="APcheck3" name="radio" /><label for="APcheck3"><?php echo dic("Tracking.Company")?></label>
			    </div>
    		</td>
		</tr>
		<tr height="50px">
    		<td width="90px"><?php echo dic("Tracking.Radius")?></td>
    		<td>
    			<dl id="poiRadius" class="dropdownRadius" style="width: 70px; margin: 0px;">
			        <dt><a href="#" title="" class="combobox1"><span><?php echo dic("Tracking.SelectRadius")?></span></a></dt>
			        <dd>
			            <ul>
			                <li><a id="RadiusID_50" href="#">50&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></a></li>
			                <li><a id="RadiusID_70" href="#">70&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></a></li>
			                <li><a id="RadiusID_100" href="#">100&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></a></li>
			                <li><a id="RadiusID_150" href="#">150&nbsp;<?php if($metric == "mi") { echo "yards"; } else { echo dic("Tracking.Meters"); } ?></a></li>
			            </ul>
			        </dd>
			    </dl>
    		</td>
		</tr>
    	<tr>
    		<td width="90px"><?php echo dic("Tracking.Group")?></td>
    		<td>
    			<dl id="poiGroup" class="dropdown" style="width: 150px; position: relative; float: left; padding: 0px; margin: 0px;">
			    <?php
					$dsUG = query("SELECT id, name, fillcolor, '0' image FROM pointsofinterestgroups WHERE id=1");
			        ?>
			        <dt><a href="#" title="" id="groupidTEst" class="combobox1"><span><?php echo dic("Tracking.SelectGroup")?></span></a></dt>
			        <dd>
			            <ul>
			                <li><a id="<?php echo pg_fetch_result($dsUG, 0, "id")?>" href="#">&nbsp;&nbsp;<?php echo dic("Settings.NotGroupedItems")?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 24px; height: 24px; background: url('http://gps.mk/new/pin/?color=<?php echo pg_fetch_result($dsUG, 0, "fillcolor")?>&type=<?php echo pg_fetch_result($dsUG, 0, "image")?>') no-repeat; position: relative; float: left;"></div></a></li>
			                <?php
								$dsGroup1 = query("select id, name, fillcolor, '0' image from pointsofinterestgroups where clientid=".session("client_id"));
			                    while ($row1 = pg_fetch_array($dsGroup1)) {
			                    	$_color = substr($row1["fillcolor"], 1, strlen($row1["fillcolor"]));
			                ?>
			                <li><a id="<?php echo $row1["id"]?>" href="#">&nbsp;&nbsp;<?php echo $row1["name"]?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 24px; height: 24px; background: url('http://gps.mk/new/pin/?color=<?php echo $_color?>&type=<?php echo $row1["image"]?>') no-repeat; position: relative; float: left;"></div></a></li>
			                <?php
			                    }
			                ?>
			            </ul>
			        </dd>
			    </dl>
    			<input type="button" id="AddGroup" style="left: 20px; top: 1px;" onclick="AddGroup('0')" value="+" />
    		</td>
    	</tr>
	</table>
    <br /><br />
    <input type="hidden" id="idPoi" value="" />
    <input type="hidden" id="numPoi" value="" />
	<div align="right" style="display:block; width:380px; height: 30px; padding-top: 5px; position: relative; float: right; right: 15px;">
        <img id="loading" style="display: none; width: 140px; position: absolute; left: 10px; margin-top: 7px;" src="../images/loading_bar1.gif" alt="" />
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnCancelPOI" value="<?php echo dic("Tracking.Cancel")?>" onclick="$('#div-Add-POI').dialog('destroy');" />        
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnAddPOI" value="<?php echo dic("Tracking.Add")?>" onclick="ButtonAddEditPOIokClick()" />
		<input type="button" style="display: none; position: relative; float: right; " class="BlackText corner5"  id="btnDeletePOI" value="<?php echo dic("Tracking.Delete")?>" onclick="DeleteGroup()" />
	</div><br /><br />
</div>
<div id="div-enter-zone-name" style="display:none">
	<div align = "center">
 		<table cellpadding="3" width="100%" style="font-size: 11px">
			<tr>
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.GFName")?>:</td>
				<td width = "75%" style="font-weight:bold" class ="text2">
					<input id="txt_zonename" type="text" value="" class="textboxcalender corner5 text5" style="width:365px;" />
				</td>
			</tr>
			<tr width = "75%" style="font-weight:bold" class ="text2">
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.AvailableFor")?>:</td>
				<td>
					<div id="gfAvail" class="corner5">
				        <input type="radio" id="GFcheck1" name="radio" /><label for="GFcheck1"><?php echo dic("Tracking.User")?></label>
				        <input type="radio" id="GFcheck2" name="radio" /><label for="GFcheck2"><?php echo dic("Tracking.OrgU")?></label>
				        <input type="radio" id="GFcheck3" name="radio" /><label for="GFcheck3"><?php echo dic("Tracking.Company")?></label>
				        <script>
				    		$('#GFcheck1').click(function(){ $(this).blur(); });
				    		$('#GFcheck2').click(function(){ $(this).blur(); });
				    		$('#GFcheck3').click(function(){ $(this).blur(); });
				    </script>
				    </div>
				</td>
			</tr>
			<tr>
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic("Tracking.Group")?>:</td>
				<td width = "75%" style="font-weight:bold" class ="text2">
					<dl id="gfGroup" class="dropdown" style="width: 150px; position: relative; float: left; margin: 0px;">
				    <?php
					$dsUG1 = query("SELECT id, name, fillcolor, '1' as image FROM pointsofinterestgroups WHERE id=1");
			        ?>
			        <dt><a href="#" title="" class="combobox1"><span class ="text2"><?php echo dic("Tracking.SelectGroup")?></span></a></dt>
			        <dd>
			            <ul>
			                <li><a id="<?php echo pg_fetch_result($dsUG1, 0, "id")?>" href="#">&nbsp;<?php echo dic("Settings.NotGroupedItems")?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 18px; height: 18px; background-color: <?php echo pg_fetch_result($dsUG1, 0, "fillcolor")?>; position: relative; float: left;"></div></a></li>
			                <?php
			                    $dsGroup2 = query("SELECT id, name, fillcolor, '1' as image FROM pointsofinterestgroups WHERE clientid=".session("client_id"));
			                    while ($row = pg_fetch_array($dsGroup2)) {
			                ?>
			                <li><a id="<?php echo $row["id"]?>" href="#">&nbsp;&nbsp;<?php echo $row["name"]?><div class="flag" style="margin-top: -1px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 18px; height: 18px; background-color: <?php echo $row["fillcolor"]?>; position: relative; float: left;"></div></a></li>
			                <?php
								}
			                ?>
			            </ul>
			        </dd>
			    </dl>
			    <input type="button" id="AddGroup1" style="position: relative; float: left; left: 20px; top: 1px;" onclick="AddGroup('0')" value="+" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<hr width="100%" style="opacity: 0.3; border-left: 0px none; border-width: 2px 0px 0px; border-style: dotted none none; border-color: -moz-use-text-color;">
				</td>
			</tr>
			<?php
				if(!$allowedAlarms) 
				{ ?>
					<tr>
						<td colspan="2">
							<table cellpadding="3" onclick="return false;" width="100%" style="font-size: 11px; opacity: 0.5;">
								<tr>
									<td>
				<? } ?>
			<tr>
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Tracking.AlertFor")?>:</td>
			    <td width = "75%" style="font-weight:bold" class ="text2">
				    <div id="alertINOUT" class="corner5">
				        <input type="checkbox" id="alVlez" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> name="checkbox" /><label for="alVlez"><?php echo dic_("Tracking.Enter1")?></label>
				        <input type="checkbox" id="alIzlez" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> name="checkbox" /><label for="alIzlez"><?php echo dic_("Tracking.Exit")?></label>
				    </div>
				</td>
		    </tr>
     		<tr>
				<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Tracking.GroupOFAlerts")?>:</td>
			    <td width = "75%" style="font-weight:bold" class ="text2">
				    <div class="ui-widget" style="height: 25px; width: 100%;">
					    <select id="vozila" style="width: 365px;" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> class="combobox text2" onchange="OptionsChangeVehicle()" onclick="$(this).focus();">
					    	<option value="0"><?php echo dic_("Tracking.SelectOption")?></option>
					        <option value="1"><?php echo dic_("Tracking.OneVehicle")?></option>
					        <option value="2"><?php echo dic_("Tracking.VehInOrgU")?></option>
					        <option value="3"><?php echo dic_("Tracking.AllVehCompany")?></option>
					    </select>
					</div>
				</td>
		    </tr>
			<tr id="ednoVozilo" style="display:none;">
		     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Tracking.SelectVeh")?>:</td>
		     <td width = "75%" style="font-weight:bold" class ="text2">
		     <div class="ui-widget" style="height: 25px; width: 100%;">
		     <select id="voziloOdbrano" style="width: 365px;" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> class="combobox text2" onclick="$(this).focus();">
		     	<?php
		        	$str1 = "";
					$str1 .= "select * from vehicles where clientid=" . session("client_id") ." ORDER BY code::INTEGER";
					$dsPP = query($str1);
		            while($row = pg_fetch_array($dsPP)) {
		        ?>
		            <option value="<?php echo $row["id"] ?>"><?php echo $row["registration"]?>&nbsp;(<?php echo $row["code"]?>)</option>
		        <?
		            }
		        ?>
		     </select>
			 </div>
			 </td>   
		     </tr>
     
		     <tr id="OrganizacionaEdinica" style="display:none;">
		     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Tracking.SelectOrg.Unit")?>:</td>
		     <td width = "75%" style="font-weight:bold" class ="text2">
		     <div class="ui-widget" style="height: 25px; width: 100%">
		     <select id="oEdinica" style="width: 365px;" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> class="combobox text2" onclick="$(this).focus();">
		     	<?php
		        	$str2 = "";
					$str2 .= "select * from organisation where clientid=" . session("client_id") ." order by code::INTEGER";
					$dsPP2 = query($str2);
					$brojRedovi = dlookup("select count(*) from organisation where clientid=" . session("client_id"));
		            while($row2 = pg_fetch_array($dsPP2)) {
		        ?>
		            <option value="<?php echo $row2["id"] ?>"><?php if ($brojRedovi>0){ echo $row2["name"]?>&nbsp;(<?php echo $row2["code"]?> <?php }else{ echo dic_("Settings.NoOrgU").".";}?>)</option>
		        <?
		            }
		        ?>
		     </select>
			 </div>
			 </td>
		     </tr>
		     
     	     <tr>
		     	<td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic_("Tracking.Emails")?></td>
		     	<td width = "75%" style="font-weight:bold" class ="text2">
		     		<input id = "txt_emails" class="textboxcalender corner5 text5" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> type="text" style = "width:365px" onclick="$(this).focus();"></input>
	     		</td>
		     </tr>
		     <tr>
		     	<td width = "25%"></td>	
		     	<td width = "75%" style="font-weight:bold ; " class ="text2"><font color = RED style="font-size = 10px"><?php echo dic_("Reports.SchNote")?></font></td>
		     </tr>
		     <tr>
		     	<td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic_("Settings.SMS")?></td>
		     	<td width = "75%" style="font-weight:bold" class ="text2"><input id = "txt_phones" class="textboxcalender corner5 text5" <?php if(!$allowedAlarms) { echo 'disabled'; } ?> type="text" style = "width:365px" onclick="$(this).focus();"></input></td>
		     </tr>
	     <? if(!$allowedAlarms)
			{
				?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<?
			}?>
		 
	   	 </table>
     </div>
     
	<!--label><input type="checkbox" id="chk_1_in" /><?php echo dic("Tracking.AlertAllowEnter")?></label><br />
	<label><input type="checkbox" id="chk_1_out"/><?php echo dic("Tracking.AlertAllowExit")?></label><br />
	<label><input type="checkbox" id="chk_2_in" /><?php echo dic("Tracking.AlertNotAllowEnter")?></label><br />
	<label><input type="checkbox" id="chk_2_out"/><?php echo dic("Tracking.AlertNotAllowExit")?></label><br />
	<div style="display:block; height:10px"></div>

	<strong><?php echo dic("Tracking.AlertEmail")?>: <span style="font-size:10px; color:#666">(<?php echo dic("Tracking.Example")?>: John@google.com, Marc@yahoo.com)</span>:</strong><br />
	<input id="txt_emails" type="text" value="" class="textboxcalender corner5 text5" style="width:622px; height:22px; font-size:11px"/><br />
	<div style="display:block; height:10px"></div>
	<strong><?php echo dic("Tracking.AlertPhone")?>: <span style="font-size:10px; color:#666">(<?php echo dic("Tracking.MacExample")?>: 075100000, 071100000)</span>:</strong><br />
	<input id="txt_phones" type="text" value="" class="textboxcalender corner5 text5" style="width:622px; height:22px; font-size:11px"/><br /-->
</div>

<div id="report-content" style="width:100%; text-align:left; height:990px; background-color:#fff; overflow: hidden" class="corner5">
	<div class="corner5" style="width:<?php if($yourbrowser == "1") { echo '96%'; } else { echo '95%'; } ?>; padding:10px 10px 10px <?php if($yourbrowser == "1") { echo '5px'; } else { echo '10px'; } ?>; border:1px solid #bbb; background-color:#fafafa; margin-left:1%">
		<table width="<?php if($yourbrowser == "1") { echo '675px'; } else { echo '805px'; } ?>" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<span class="text2"><?php echo dic("Routes.NName")?></span>&nbsp;<input id="txt_naslov" type="text" class="textboxCalender corner5 text1" style="width: <?php if($yourbrowser == "1") { echo '200px'; } else { echo '400px'; } ?>; font-weight:bold" value="<?php echo pg_fetch_result($dsNalog, 0, "name")?>" onclick="$(this).focus();" onkeydown="uncheck(this.id); unchange1()" />
				</td>
				<td>
					<?php if($yourbrowser != "1") { ?>
						<span class="text2" style="margin-left: <?php if($yourbrowser == "1") { echo '30px'; } else { echo '70px'; } ?>;"><?php echo dic("Routes.StartDatetime")?></span>&nbsp;
					<?php }?>
					<input id="txtSDate" type="text" width="80px" onchange="unchange1()" class="textboxCalender corner5 text2" value="<?php echo $currDateTime1?>" style="width: 105px;position: relative; top: -1px; margin-left:<?php if($yourbrowser == "1") { echo '5px'; } else { echo '15'; } ?>"/>
					<select class="textboxCalender corner5 text2" id="txt_vreme" onchange="unchange1()" style="width:70px; position: relative; top: -1px; padding-top:5px; padding-bottom:3px; margin-left:<?php if($yourbrowser == "1") { echo '-10px'; } else { echo '-10px'; } ?>" onclick="$(this).focus();">
						<option value="00:00">00:00</option>
						<option value="01:00">01:00</option>
						<option value="02:00">02:00</option>
						<option value="03:00">03:00</option>
						<option value="04:00">04:00</option>
						<option value="05:00">05:00</option>
						<option value="06:00">06:00</option>
						<option value="07:00">07:00</option>
						<option value="08:00">08:00</option>
						<option value="09:00">09:00</option>
						<option value="10:00">10:00</option>
						<option value="11:00">11:00</option>
						<option value="12:00">12:00</option>
						<option value="13:00">13:00</option>
						<option value="14:00">14:00</option>
						<option value="15:00">15:00</option>
						<option value="16:00">16:00</option>
						<option value="17:00">17:00</option>
						<option value="18:00">18:00</option>
						<option value="19:00">19:00</option>
						<option value="20:00">20:00</option>
						<option value="21:00">21:00</option>
						<option value="22:00">22:00</option>
						<option value="23:00">23:00</option>				
					</select>
					<?php if($yourbrowser == "1") { ?>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button id="btn-save1" onClick="SaveNalog()"><?php echo dic("Routes.Save")?></button>
						&nbsp;<button id="btn-clear1" onClick="CistiForma()"><?php echo dic_("Routes.Delete")?></button>
					<?php }?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="28%">
								<span class="text2"><?php echo dic("Routes.Vehicle")?></span>&nbsp;
								<select id="txt_vozilo" class="textboxCalender corner5 text2" style="width:<?php if($yourbrowser == "1") { ?>120px<?php } else { ?>155px<?php } ?>; margin-top: 2px; margin-left:5px; padding-top:5px; padding-bottom:3px" onchange="FilterByVeh(); uncheck(this.id); unchange1()" onclick="$(this).focus();">
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
							</td>
							<td width="72%"><!--width: <?php if($yourbrowser == "1") { echo '495px'; } else { echo '610px'; } ?>;-->
								<table id="promenakolona" class="text2" border="0" style="height: 30px; position: relative; float: left; top: 0px;">
									<tr>
										<td height="30px" align="left" style="width: 40px; padding-left: <?php if($yourbrowser == "1") { echo '5px'; } else { echo '7px'; } ?>;">
											<?php echo dic_("Routes.User")?>
										</td>
										<td style="width: <?php if($yourbrowser == "1") { echo '119px'; } else { echo '155px'; } ?>">
											<select id="txt_sofer1" class="textboxCalender corner5 text2" style="width:<?php if($yourbrowser == "1") { echo '119px'; } else { echo '155px'; } ?>; padding-top:5px; padding-bottom:3px;" onchange="uncheck(this.id); unchange1()" onclick="$(this).focus();">
												<option value="0"><?php echo dic("Routes.SelectUser")?> </option>
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
										  	</select>
										</td>
										<td style="width: 29px">
											<button style="width:29px;" id="PlusDriver" value="+" onclick="AddDriver()">&nbsp;</button>
											<script>
											  	jQuery.moveColumn = function (table, from, to) {
												    var rows = jQuery('tr', table);
												    var cols;
												    rows.each(function() {
												        cols = jQuery(this).children('th, td');
												        cols.eq(from).insertBefore(cols.eq(to));
												    });
												}
											  	$('#PlusDriver').button({ icons: { primary: "ui-icon-plus"} });
											  	function AddDriver()
											  	{
											  		var tbl = jQuery('#promenakolona');
											  		if($('#txt_sofer2').css('display') == 'none')
												  	{
														jQuery.moveColumn(tbl, 4, 2);
												  		$('#txt_sofer2').css({ display: 'block'});
												  		$('#MinusDriver2').css({ display: 'block'});
												  	}else
												  	{
												  		$('#txt_sofer3').css({ display: 'block'});
												  		jQuery.moveColumn(tbl, 5, 3);
												  		jQuery.moveColumn(tbl, 5, 4);
												  		$('#PlusDriver').css({ display: 'none'});
												  	}
												  	$('#PlusDriver').attr({ class: $('#PlusDriver').attr('class').replace('ui-state-hover', 'ui-state') });
											  	}
											</script>
										</td>
										<td style="width: 29px">
											<button style="width:29px; display: none;" id="MinusDriver2" value="-" onclick="DelDriver()">&nbsp;</button>
											<script>
												$('#MinusDriver2').button({ icons: { primary: "ui-icon-minus"} });
											  	function DelDriver()
											  	{
											  		var tbl = jQuery('#promenakolona');
											  		if($('#txt_sofer3').css('display') == 'block')
												  	{
												  		$('#txt_sofer3').css({ display: 'none'});
												  		jQuery.moveColumn(tbl, 5, 3);
												  		jQuery.moveColumn(tbl, 5, 4);
												  		$('#PlusDriver').css({ display: 'block'});
												  		txt_sofer3.selectedIndex = 0;
												  	}else
												  	{
												  		$('#txt_sofer2').css({ display: 'none'});
												  		jQuery.moveColumn(tbl, 3, 2);
												  		jQuery.moveColumn(tbl, 4, 3);
												  		$('#MinusDriver2').css({ display: 'none'});
												  		txt_sofer2.selectedIndex = 0;
												  	}
												  	$('#MinusDriver2').attr({ class: $('#MinusDriver2').attr('class').replace('ui-state-hover', 'ui-state') });
											  	}
											</script>
										</td>
										<td style="width: <?php if($yourbrowser == "1") { echo '119px'; } else { echo '155px'; } ?>">
											<select id="txt_sofer2" onchange="unchange1()" class="textboxCalender corner5 text2" style="display: none; width:<?php if($yourbrowser == "1") { echo '119px'; } else { echo '155px'; } ?>; padding-top:5px; padding-bottom:3px;" onclick="$(this).focus();">
													<option value="0"><?php echo dic("Routes.SelectUser")?></option>
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
											</select>
										</td>
										<td style="width: <?php if($yourbrowser == "1") { echo '119px'; } else { echo '155px'; } ?>">
											<select id="txt_sofer3" onchange="unchange1()" class="textboxCalender corner5 text2" style="display: none; width:<?php if($yourbrowser == "1") { echo '119px'; } else { echo '155px'; } ?>; padding-top:5px; padding-bottom:3px;" onclick="$(this).focus();">
												<option value="0"><?php echo dic("Routes.SelectUser")?></option>
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
											</select>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="<?php if($yourbrowser == "1") { echo '43%'; } else { echo '38%'; } ?>">
								<span class="text2" id="alerti"><?php echo dic("Routes.Alarm")?></span>&nbsp;
								<select class="textboxCalender corner5 text2" id="txt_alert" onchange="unchange1()" style="width: 50px; padding-top: 5px; padding-bottom: 3px; position: relative; top: -1px; margin-top: 5px; margin-left: 8px;" onclick="$(this).focus();">
									<option value="/">/</option>
									<option value="5" <?php if($alarm == "5") { echo 'selected'; } ?>>5</option>
									<option value="10" <?php if($alarm == "10") { echo 'selected'; } ?>>10</option>
									<option value="15" <?php if($alarm == "15") { echo 'selected'; } ?>>15</option>
									<option value="20" <?php if($alarm == "20") { echo 'selected'; } ?>>20</option>
									<option value="30" <?php if($alarm == "35") { echo 'selected'; } ?>>30</option>
									<option value="45" <?php if($alarm == "45") { echo 'selected'; } ?>>45</option>
									<option value="60" <?php if($alarm == "60") { echo 'selected'; } ?>>60</option>
								</select>&nbsp;&nbsp;<span class="text2" style="position: relative; top: 6px;"><img id="alertiImg" src="../images/infocircle.png" /></span>
								<span class="text2" id="alertiWait" style="margin-left: <?php if($yourbrowser == "1") { echo '5px'; } else { echo '10px'; } ?>;"><?php echo dic_("Routes.Retention")?></span>&nbsp;
								<select class="textboxCalender corner5 text2" onchange="updateTotal(this.value); unchange1()" id="txt_alertWait" style="width: 50px; padding-top: 5px; padding-bottom: 3px; position: relative; top: -1px; margin-top: 5px; margin-left: 2px;" onclick="$(this).focus();">
									<option value="/">/</option>
									<option value="5" <?php if($tostay == "5") { echo 'selected'; } ?>>5</option>
									<option value="10" <?php if($tostay == "10") { echo 'selected'; } ?>>10</option>
									<option value="15" <?php if($tostay == "15") { echo 'selected'; } ?>>15</option>
									<option value="20" <?php if($tostay == "20") { echo 'selected'; } ?>>20</option>
									<option value="30" <?php if($tostay == "30") { echo 'selected'; } ?>>30</option>
									<option value="45" <?php if($tostay == "45") { echo 'selected'; } ?>>45</option>
									<option value="60" <?php if($tostay == "60") { echo 'selected'; } ?>>60</option>
								</select>&nbsp;&nbsp;<span class="text2" style="position: relative; top: 5px;"><img id="alertiWaitImg" src="../images/infocircle.png" /></span>
							</td>
							<td width="<?php if($yourbrowser == "1") { echo '57%'; } else { echo '62%'; } ?>"> <!--width: <?php if($yourbrowser == "1") { echo '410px'; } else { echo '450px'; } ?>;-->
								<table id="pauzapromenakolona" class="text2" border="0" style="height: 30px; position: relative; float: left; top: 2px;">
									<tr>
										<td height="30px" align="left" style="width: 40px; padding-left: <?php if($yourbrowser == "1") { echo '3px'; } else { echo '7px'; } ?>;">
											<?php echo dic_("Settings.AlarmPause")?>
										</td>
										<td style="width: <?php if($yourbrowser == "1") { echo '45px'; } else { echo '55px'; } ?>">
											<select id="txt_pause1" onchange="updatePause(this.value, 1); unchange1()" class="textboxCalender corner5 text2" style="width:<?php if($yourbrowser == "1") { echo '45px'; } else { echo '55px'; } ?>; padding-top:5px; padding-bottom:3px;" onclick="$(this).focus();">
												<option value="0">/</option>
												<?php
												for($i=0; $i<sizeof($pauseTemp); $i++)
												{
													echo "<option value='" . $pauseTemp[$i] . "'>" . $pauseTemp[$i] . "</option>";
												}
												?>
										  	</select>
										</td>
										<td style="width: 29px">
											<button style="width:29px;" id="PlusPause" value="+" onclick="AddPause()">&nbsp;</button>
											<script>
											  	jQuery.moveColumn = function (table, from, to) {
												    var rows = jQuery('tr', table);
												    var cols;
												    rows.each(function() {
												        cols = jQuery(this).children('th, td');
												        cols.eq(from).insertBefore(cols.eq(to));
												    });
												}
											  	$('#PlusPause').button({ icons: { primary: "ui-icon-plus"} });
											  	function AddPause()
											  	{
											  		var tbl = jQuery('#pauzapromenakolona');
											  		if($('#txt_pause2').css('display') == 'none')
												  	{
														
														jQuery.moveColumn(tbl, 5, 2);
														jQuery.moveColumn(tbl, 5, 3);
														jQuery.moveColumn(tbl, 4, 3);
														//jQuery.moveColumn(tbl, 5, 3);
												  		$('#txt_pause2').css({ display: 'block'});
												  		$('#txt_pause2')[0].selectedIndex = 0
												  		$('#MinusPause').css({ display: 'block'});
												  		
												  	}else
												  		if($('#txt_pause3').css('display') == 'none')
												  		{
												  			jQuery.moveColumn(tbl, 6, 3);
												  			jQuery.moveColumn(tbl, 5, 4);
												  			jQuery.moveColumn(tbl, 5, 4);
												  			$('#txt_pause3').css({ display: 'block'});
												  			$('#txt_pause3')[0].selectedIndex = 0
											  			} else
												  			if($('#txt_pause4').css('display') == 'none')
													  		{
													  			jQuery.moveColumn(tbl, 7, 4);
													  			jQuery.moveColumn(tbl, 6, 5);
													  			jQuery.moveColumn(tbl, 6, 5);
													  			$('#txt_pause4').css({ display: 'block'});
													  			$('#txt_pause4')[0].selectedIndex = 0
												  			} else
													  			if($('#txt_pause5').css('display') == 'none')
														  		{
														  			jQuery.moveColumn(tbl, 8, 5);
														  			jQuery.moveColumn(tbl, 7, 6);
														  			jQuery.moveColumn(tbl, 8, 7);
														  			$('#txt_pause5').css({ display: 'block'});
														  			$('#txt_pause5')[0].selectedIndex = 0
														  			$('#PlusPause').css({ display: 'none'});
													  			}
													$('#PlusPause').attr({ class: $('#PlusPause').attr('class').replace('ui-state-hover', 'ui-state') });
											  	}
											</script>
										</td>
										<td>
											<img id="pauseImg" src="../images/infocircle.png" />
										</td>
										<td style="width: 29px">
											<button style="width:29px; display: none;" id="MinusPause" value="-" onclick="DelPause()">&nbsp;</button>
											<script>
												$('#MinusPause').button({ icons: { primary: "ui-icon-minus"} });
											  	function DelPause()
											  	{
											  		var tbl = jQuery('#pauzapromenakolona');
									  				if($('#txt_pause5').css('display') == 'block')
												  	{
												  		$('#txt_pause5').css({ display: 'none'});
												  		jQuery.moveColumn(tbl, 8, 5);
												  		jQuery.moveColumn(tbl, 7, 6);
												  		jQuery.moveColumn(tbl, 8, 7);
												  		updatePause("0", 5);
												  		$('#PlusPause').css({ display: 'block'});
												  		txt_pause5.selectedIndex = 0;
												  	}else
													  	if($('#txt_pause4').css('display') == 'block')
													  	{
													  		jQuery.moveColumn(tbl, 5, 4);
													  		jQuery.moveColumn(tbl, 6, 5);
													  		jQuery.moveColumn(tbl, 7, 6);
													  		updatePause("0", 4);
													  		$('#txt_pause4').css({ display: 'none'});
													  		txt_pause4.selectedIndex = 0;
													  	}else
														  	if($('#txt_pause3').css('display') == 'block')
														  	{
														  		jQuery.moveColumn(tbl, 4, 3);
														  		jQuery.moveColumn(tbl, 5, 4);
														  		jQuery.moveColumn(tbl, 6, 5);
														  		updatePause("0", 3);
														  		$('#txt_pause3').css({ display: 'none'});
														  		txt_pause3.selectedIndex = 0;
														  	}else
																if($('#txt_pause2').css('display') == 'block')
																{
																	updatePause("0", 2);												
																	$('#txt_pause2').css({ display: 'none'});
																	jQuery.moveColumn(tbl, 3, 2);
																	jQuery.moveColumn(tbl, 4, 3);
																	jQuery.moveColumn(tbl, 5, 3);
																	$('#MinusPause').css({ display: 'none'});
																	txt_pause2.selectedIndex = 0;
																}
													$('#MinusPause').attr({ class: $('#MinusPause').attr('class').replace('ui-state-hover', 'ui-state') });
											  	}
											</script>
										</td>
										<td style="width: <?php if($yourbrowser == "1") { echo '45px'; } else { echo '55px'; } ?>">
											<select id="txt_pause2" onchange="updatePause(this.value, 2); unchange1()" class="textboxCalender corner5 text2" style="display: none; width:<?php if($yourbrowser == "1") { echo '45px'; } else { echo '55px'; } ?>; padding-top:5px; padding-bottom:3px;" onclick="$(this).focus();">
													<option value="0">/</option>
													<?php
													for($i=0; $i<sizeof($pauseTemp); $i++)
													{
														echo "<option value='" . $pauseTemp[$i] . "'>" . $pauseTemp[$i] . "</option>";
													}
													?>
											</select>
										</td>
										<td style="width: <?php if($yourbrowser == "1") { echo '45px'; } else { echo '55px'; } ?>">
											<select id="txt_pause3" onchange="updatePause(this.value, 3); unchange1()" class="textboxCalender corner5 text2" style="display: none; width:<?php if($yourbrowser == "1") { echo '45px'; } else { echo '55px'; } ?>; padding-top:5px; padding-bottom:3px;" onclick="$(this).focus();">
												<option value="0">/</option>
												<?php
													for($i=0; $i<sizeof($pauseTemp); $i++)
													{
														echo "<option value='" . $pauseTemp[$i] . "'>" . $pauseTemp[$i] . "</option>";
													}
												?>
											</select>
										</td>
										<td style="width: <?php if($yourbrowser == "1") { echo '45px'; } else { echo '55px'; } ?>">
											<select id="txt_pause4" onchange="updatePause(this.value, 4); unchange1()" class="textboxCalender corner5 text2" style="display: none; width:<?php if($yourbrowser == "1") { echo '45px'; } else { echo '55px'; } ?>; padding-top:5px; padding-bottom:3px;" onclick="$(this).focus();">
													<option value="0">/</option>
													<?php
													for($i=0; $i<sizeof($pauseTemp); $i++)
													{
														echo "<option value='" . $pauseTemp[$i] . "'>" . $pauseTemp[$i] . "</option>";
													}
													?>
											</select>
										</td>
										<td style="width: <?php if($yourbrowser == "1") { echo '45px'; } else { echo '55px'; } ?>">
											<select id="txt_pause5" onchange="updatePause(this.value, 5); unchange1()" class="textboxCalender corner5 text2" style="display: none; width:<?php if($yourbrowser == "1") { echo '45px'; } else { echo '55px'; } ?>; padding-top:5px; padding-bottom:3px;" onclick="$(this).focus();">
												<option value="0">/</option>
												<?php
													for($i=0; $i<sizeof($pauseTemp); $i++)
													{
														echo "<option value='" . $pauseTemp[$i] . "'>" . $pauseTemp[$i] . "</option>";
													}
												?>
											</select>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td></tr>
		<?php
				if (session("client_id") == 367) {
				?>
				<tr>
					<td colspan="4" style="padding-top:15px;">
						<div style="border-bottom:1px solid green; width:100%"></div>
					</td>
				</tr>
				<?php
				}
				?>
		</table><!--style="<?php if($yourbrowser1 == "1" || $yourbrowser == "1") { echo 'position: relative; top: -40px'; } ?>"--> 
		
		<?php
		if (session("client_id") == 367) {
		?>
		<div id="cultures">
			<div id="1culture">
		<table width="<?php if($yourbrowser == "1") { echo '537px'; } else { echo '645px'; } ?>">
			
			
			<tr class="text2">
				<td width=25% id="tdcul" style="padding-top:10px;">Култура</td>
				<td width=25% id="tdoper" style=" padding-left:3px; padding-top:10px;">Операција</td>
				<td width=25% id="tdmat" style="padding-left:3px; padding-top:10px;">Материјал</td>
				<td width=25% id="tdmech" style="padding-left:3px; padding-top:10px;">Прикл. механизација</td>
				
			</tr>
			<tr class="text2">
				<td>
					<select id="culture" onchange="changeCulture()" class="textboxCalender corner5 text2" style="width:<?php if($yourbrowser == "1") { echo '145px'; } else { echo '155px'; } ?>; padding-top:5px; padding-bottom:3px;" onclick="$(this).focus();">
						<option id=0 value="0">-Изберете-</option>
						<?php
						$dsCultures = query("select * from route_culture where clientid=" . session("client_id"));
						
						while ($drCultures = pg_fetch_array($dsCultures)) {
							if($drCultures["id"] == $culture)
							{
								?>
									<option selected id=<?php echo $drCultures["id"]?> value=<?php echo $drCultures["id"]?>><?php echo $drCultures["name"]?></option>
								<?php
							} else {
						?>
							<option id=<?php echo $drCultures["id"]?> value=<?php echo $drCultures["id"]?>><?php echo $drCultures["name"]?></option>
						<?php
							}
						}
						?>
					</select>	
				</td>
				<td>
					<select id="operation"  onchange="changeOperation()" class="textboxCalender corner5 text2" style="width:<?php if($yourbrowser == "1") { echo '145px'; } else { echo '155px'; } ?>; padding-top:5px; padding-bottom:3px; margin-left:3px" onclick="$(this).focus();">
						<option id=0 value="0">-Изберете-</option>
						<?php
						$dsOperations = query("select * from route_operation where clientid=" . session("client_id"));
						
						while ($drOperations = pg_fetch_array($dsOperations)) {
							if($drOperations["id"] == $operation)
							{
								?>
									<option selected id=<?php echo $drOperations["id"]?> value=<?php echo $drOperations["id"]?>><?php echo $drOperations["name"]?></option>
								<?php
							} else {
						?>
							<option id=<?php echo $drOperations["id"]?> value=<?php echo $drOperations["id"]?>><?php echo $drOperations["name"]?></option>
						<?php
							}
						}
						?>
					</select>
				</td>
				<td>
					<select id="material" onchange="changeMaterial()" class="textboxCalender corner5 text2" style="width:<?php if($yourbrowser == "1") { echo '145px'; } else { echo '155px'; } ?>; padding-top:5px; padding-bottom:3px; margin-left:3px" onclick="$(this).focus();">
						<option id=0 value="0">-Изберете-</option>
						<?php
						$dsMaterials = query("select * from route_material where clientid=" . session("client_id"));
						
						while ($drMaterials = pg_fetch_array($dsMaterials)) {
							if($drMaterials["id"] == $material)
							{
								?>
									<option selected id=<?php echo $drMaterials["id"]?> value=<?php echo $drMaterials["id"]?>><?php echo $drMaterials["name"]?></option>
								<?php
							} else {
							?>
								<option id=<?php echo $drMaterials["id"]?> value=<?php echo $drMaterials["id"]?>><?php echo $drMaterials["name"]?></option>
							<?php
							}
						}
						?>
					</select>
				</td>
				<td>
					<select id="mechanisation" class="textboxCalender corner5 text2" style="width:<?php if($yourbrowser == "1") { echo '145px'; } else { echo '155px'; } ?>; padding-top:5px; padding-bottom:3px; margin-left:3px" onclick="$(this).focus();">
						<option id=0 value="0">-Изберете-</option>
						<?php
						$dsMechanisations = query("select * from route_mechanisation where clientid=" . session("client_id"));
						
						while ($drMechanisations = pg_fetch_array($dsMechanisations)) {
							if($drMechanisations["id"] == $mechanization)
							{
								?>
									<option selected id=<?php echo $drMechanisations["id"]?> value=<?php echo $drMechanisations["id"]?>><?php echo $drMechanisations["name"]?></option>
								<?php
							} else {
						?>
							<option id=<?php echo $drMechanisations["id"]?> value=<?php echo $drMechanisations["id"]?>><?php echo $drMechanisations["name"]?></option>
						<?php
							}
						}
						?>
					</select>
				</td>
				
			</tr>
		</table>
		
			<table width="<?php if($yourbrowser == "1") { echo '665px'; } else { echo '807px'; } ?>" id="tbl-poi" border="0">
				<tr>
                    <td id="widthR" align="center" class="text3" style="background-color: transparent; color:#39ae58; font-weight:bold; cursor:pointer" colspan="4">
                        <table width="100%" border="0">
                        	<tr>
                        		<td width="16%"><strong class="text2"><?php echo dic_("Routes.SelectLocation")?>: </strong></td>
                        		<td width="<?php if($yourbrowser == "1") { echo '64%'; } else { echo '65%'; } ?>">
                        			<div class="ui-widget" style="height: 25px; width: 100%;">
				                        <select id="combobox">
					                        <option value=""><?php echo dic_("Routes.SelectOne")?>...</option>
			                                <?php
			                                    //$dsPP = query("select * from pointsofinterest where clientId=" . session("client_id") . " order by Name asc");
												$str3 = " and (pp.userid in (select id from users where organisationid in (select organisationid from users where id=" . session("user_id") . ")) or pp.userid=" . session("user_id") . " or pp.available = 3)";
											    $str1 = "";
												/*$str1 .= " select ST_X(ST_Transform(pp.geom,4326)) long, ST_Y(ST_Transform(pp.geom,4326)) lat, pp.name, pp.available, ";
												$str1 .= " pp.groupid, pp.id, ppg.fillcolor color, ppg.name groupname, pp.radius from pointsofinterest pp "; 
												$str1 .= " left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id  ";
												$str1 .= " where pp.clientid=" . session("client_id") ." and type=1 " . $str3 . " ORDER BY pp.id DESC";*/
												
												$str1 .= " (select ST_X(ST_Transform(pp.geom,4326)) long, ST_Y(ST_Transform(pp.geom,4326)) lat, pp.name, pp.available, pp.type, ";
												$str1 .= " pp.groupid, pp.id, ppg.fillcolor color, ppg.name groupname, pp.radius from pointsofinterest pp "; 
												$str1 .= " left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id  ";
												$str1 .= " where pp.clientid=" . session("client_id") ." and type=1 and pp.groupid <> 240 " . $str3 . " ORDER BY pp.id DESC)";
												
												$str1 .= " union ";
												
												$str1 .= " (select st_y(st_centroid(geom)) long, st_x(st_centroid(geom)) lat, pp.name, pp.available, pp.type, ";
												$str1 .= " pp.groupid, pp.id, ppg.fillcolor color, ppg.name groupname, pp.radius from pointsofinterest pp "; 
												$str1 .= " left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id ";
												$str1 .= " where pp.clientid=" . session("client_id") ." and type=2 " . $str3 . " ORDER by pp.id DESC)";
												
												$str1 .= " union ";
												
												$str1 .= " (select st_y(st_centroid(geom)) long, st_x(st_centroid(geom)) lat, pp.name, pp.available, pp.type, ";
												$str1 .= " pp.groupid, pp.id, ppg.fillcolor color, ppg.name groupname, pp.radius from pointsofinterest pp "; 
												$str1 .= " left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id ";
												$str1 .= " where pp.clientid=" . session("client_id") ." and type=3 " . $str3 . " ORDER by pp.id DESC)";
												
												$dsPP = query($str1);
			                                    while($row = pg_fetch_array($dsPP)) {
			                                ?>
					                            <option value="<?php echo $row["id"] ?>|<?php echo $row["lat"] ?>|<?php echo $row["long"] ?>|<?php echo $row["type"] ?>"><?php echo $row["name"]?></option>
			                                <?
			                                    }
			                                ?>
				                        </select>
			                        </div>
                        		</td>
                        		<td width="20%"><button id="btn-prezemi" onClick="ShowPrezemi()" style="float:right; right: -5px;"><?php echo dic("Routes.DL")?></button></td>
                        	</tr>
                        </table>
                    </td>
                </tr>
                <tr>
					<!--td width="60px" height="22px" align="center" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185"><strong>Р. бр.</strong></td-->
					<td width="51%" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185"><strong>&nbsp;<?php echo dic("Routes.Pois")?></strong></td>
                    <td width="20%" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185; padding-left: 47px;"><strong>&nbsp;<?php echo dic("Routes.Distance")?></strong></td>
                    <td width="20%" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185; padding-left: 50px;"><strong>&nbsp;<?php echo dic("Routes.Time")?></strong></td>
					<td align="center" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185"><strong><?php echo dic("Routes.Operations")?></strong></td>
				</tr>
				<tr>
					<td height="30px" align="center" class="text3" style="background-color:#fff; color:#39ae58; font-weight:bold; border:1px dotted #B8B8B8; cursor:pointer" colspan="4">
                        <div id="MarkersIN" style="position: relative; background: transparent; top: 0px; opacity:0.9; z-index:999; bottom:2px; overflow-X: hidden; overflow-Y: auto;  height: auto; max-height: 300px; width: 100%;" class="text9 corner5"></div>
                        <!--div onClick="AddPOI()"><img src="../images/dodadi.png" style="cursor:pointer" align="absmiddle"> Додади нова локација</div-->
						<div id="PauseOnRoute" style="position: relative; background: transparent; top: 0px; opacity:0.9; z-index:999; bottom:2px; overflow-X: hidden; overflow-Y: auto;  height: auto; max-height: 300px; width: 100%;" class="text9 corner5"></div>
                        <div id="IDMarker_Total" style="display: none; cursor: pointer; border-top: 1px dotted #B8B8B8; border-radius: 0px; font-size:12; width:97%; padding:2px 2px 2px 7px; height:26px; background-position: right center; background-repeat: no-repeat; background-origin: content-box;" class="text8 corner5">
                    		<input type="text" style="cursor: pointer; width: 50%; text-align: right; right: 20px; position: relative; float: left; font-size: 12px; font-weight: bold; margin-top: 4px; background: transparent; border: 0px;" value="Total :" readonly="readonly" class="text2" />
                    		<input type="text" style="font-size: 11px; cursor: pointer; width: 20%; padding-left: 56px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" value="/" readonly="readonly" class="text9">
                    		<input type="text" style="font-size: 11px; cursor: pointer;  text-align: center; width: 20%; padding-left: 9px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" value="/" readonly="readonly" class="text9">
                		</div>
                    </td>
				</tr>
			</table>
		</div>
		
		<div id="div-map" style="width: <?php if($yourbrowser == "1" || $yourbrowser == "1") { echo '655px'; } else { echo '800px'; } ?>; height: 400px; border:1px dotted #2f5185; position: relative; z-index: 1; left: 3px;"></div>
		<div id="optimizedNarrative" class="text9 corner15" style="display: none; right: 55px; overflow: hidden; width: 500px; height: 400px; position: absolute; background: none repeat scroll 0% 0% white; z-index: 10; opacity: 0.9; top: 35px;"></div>
		<?php if($yourbrowser1 != "1" || $yourbrowser == "1") { ?><br /><br /><?php } ?> 
		&nbsp;<button id="btn-save" onClick="SaveNalog()"><?php echo dic("Routes.Save")?></button>
		&nbsp;<button id="btn-clear" onClick="CistiForma()"><?php echo dic("Routes.Clear")?></button>
		
	</div>
	<?php
		} else {
			?>
			<table width="<?php if($yourbrowser == "1") { echo '665px'; } else { echo '807px'; } ?>" id="tbl-poi" border="0">
				<tr>
                    <td id="widthR" align="center" class="text3" style="background-color: transparent; color:#39ae58; font-weight:bold; cursor:pointer" colspan="4">
                        <table width="100%" border="0">
                        	<tr>
                        		<td width="16%"><strong class="text2"><?php echo dic_("Routes.SelectLocation")?>: </strong></td>
                        		<td width="<?php if($yourbrowser == "1") { echo '64%'; } else { echo '65%'; } ?>">
                        			<div class="ui-widget" style="height: 25px; width: 100%;">
				                        <select id="combobox">
					                        <option value=""><?php echo dic_("Routes.SelectOne")?>...</option>
			                                <?php
			                                    //$dsPP = query("select * from pointsofinterest where clientId=" . session("client_id") . " order by Name asc");
												$str3 = " and (pp.userid in (select id from users where organisationid in (select organisationid from users where id=" . session("user_id") . ")) or pp.userid=" . session("user_id") . " or pp.available = 3)";
											    $str1 = "";
												/*$str1 .= " select ST_X(ST_Transform(pp.geom,4326)) long, ST_Y(ST_Transform(pp.geom,4326)) lat, pp.name, pp.available, ";
												$str1 .= " pp.groupid, pp.id, ppg.fillcolor color, ppg.name groupname, pp.radius from pointsofinterest pp "; 
												$str1 .= " left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id  ";
												$str1 .= " where pp.clientid=" . session("client_id") ." and type=1 " . $str3 . " ORDER BY pp.id DESC";*/
												
												$str1 .= " (select ST_X(ST_Transform(pp.geom,4326)) long, ST_Y(ST_Transform(pp.geom,4326)) lat, pp.name, pp.available, pp.type, ";
												$str1 .= " pp.groupid, pp.id, ppg.fillcolor color, ppg.name groupname, pp.radius from pointsofinterest pp "; 
												$str1 .= " left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id  ";
												$str1 .= " where pp.clientid=" . session("client_id") ." and type=1 and pp.groupid <> 240 " . $str3 . " ORDER BY pp.id DESC)";
												
												$str1 .= " union ";
												
												$str1 .= " (select st_y(st_centroid(geom)) long, st_x(st_centroid(geom)) lat, pp.name, pp.available, pp.type, ";
												$str1 .= " pp.groupid, pp.id, ppg.fillcolor color, ppg.name groupname, pp.radius from pointsofinterest pp "; 
												$str1 .= " left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id ";
												$str1 .= " where pp.clientid=" . session("client_id") ." and type=2 " . $str3 . " ORDER by pp.id DESC)";
												
												$str1 .= " union ";
												
												$str1 .= " (select st_y(st_centroid(geom)) long, st_x(st_centroid(geom)) lat, pp.name, pp.available, pp.type, ";
												$str1 .= " pp.groupid, pp.id, ppg.fillcolor color, ppg.name groupname, pp.radius from pointsofinterest pp "; 
												$str1 .= " left outer join pointsofinterestgroups ppg on pp.groupid=ppg.id ";
												$str1 .= " where pp.clientid=" . session("client_id") ." and type=3 " . $str3 . " ORDER by pp.id DESC)";
												
												$dsPP = query($str1);
			                                    while($row = pg_fetch_array($dsPP)) {
			                                ?>
					                            <option value="<?php echo $row["id"] ?>|<?php echo $row["lat"] ?>|<?php echo $row["long"] ?>|<?php echo $row["type"] ?>"><?php echo $row["name"]?></option>
			                                <?
			                                    }
			                                ?>
				                        </select>
			                        </div>
                        		</td>
                        		<td width="20%"><button id="btn-prezemi" onClick="ShowPrezemi()" style="float:right; right: -5px;"><?php echo dic("Routes.DL")?></button></td>
                        	</tr>
                        </table>
                    </td>
                </tr>
                <tr>
					<!--td width="60px" height="22px" align="center" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185"><strong>Р. бр.</strong></td-->
					<td width="51%" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185"><strong>&nbsp;<?php echo dic("Routes.Pois")?></strong></td>
                    <td width="20%" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185; padding-left: 47px;"><strong>&nbsp;<?php echo dic("Routes.Distance")?></strong></td>
                    <td width="20%" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185; padding-left: 50px;"><strong>&nbsp;<?php echo dic("Routes.Time")?></strong></td>
					<td align="center" class="text2" style="background-color:#E5E3E3; border:1px dotted #2f5185"><strong><?php echo dic("Routes.Operations")?></strong></td>
				</tr>
				<tr>
					<td height="30px" align="center" class="text3" style="background-color:#fff; color:#39ae58; font-weight:bold; border:1px dotted #B8B8B8; cursor:pointer" colspan="4">
                        <div id="MarkersIN" style="position: relative; background: transparent; top: 0px; opacity:0.9; z-index:999; bottom:2px; overflow-X: hidden; overflow-Y: auto;  height: auto; max-height: 300px; width: 100%;" class="text9 corner5"></div>
                        <!--div onClick="AddPOI()"><img src="../images/dodadi.png" style="cursor:pointer" align="absmiddle"> Додади нова локација</div-->
						<div id="PauseOnRoute" style="position: relative; background: transparent; top: 0px; opacity:0.9; z-index:999; bottom:2px; overflow-X: hidden; overflow-Y: auto;  height: auto; max-height: 300px; width: 100%;" class="text9 corner5"></div>
                        <div id="IDMarker_Total" style="display: none; cursor: pointer; border-top: 1px dotted #B8B8B8; border-radius: 0px; font-size:12; width:97%; padding:2px 2px 2px 7px; height:26px; background-position: right center; background-repeat: no-repeat; background-origin: content-box;" class="text8 corner5">
                    		<input type="text" style="cursor: pointer; width: 50%; text-align: right; right: 20px; position: relative; float: left; font-size: 12px; font-weight: bold; margin-top: 4px; background: transparent; border: 0px;" value="Total :" readonly="readonly" class="text2" />
                    		<input type="text" style="font-size: 11px; cursor: pointer; width: 20%; padding-left: 56px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" value="/" readonly="readonly" class="text9">
                    		<input type="text" style="font-size: 11px; cursor: pointer;  text-align: center; width: 20%; padding-left: 9px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" value="/" readonly="readonly" class="text9">
                		</div>
                    </td>
				</tr>
			</table>
		
		<div id="div-map" style="width: <?php if($yourbrowser == "1" || $yourbrowser == "1") { echo '655px'; } else { echo '800px'; } ?>; height: 400px; border:1px dotted #2f5185; position: relative; z-index: 1; left: 3px;"></div>
		<div id="optimizedNarrative" class="text9 corner15" style="display: none; right: 55px; overflow: hidden; width: 500px; height: 400px; position: absolute; background: none repeat scroll 0% 0% white; z-index: 10; opacity: 0.9; top: 35px;"></div>
		<?php if($yourbrowser1 != "1" || $yourbrowser == "1") { ?><br /><br /><?php } ?> 
		&nbsp;<button id="btn-save" onClick="SaveNalog()"><?php echo dic("Routes.Save")?></button>
		&nbsp;<button id="btn-clear" onClick="CistiForma()"><?php echo dic("Routes.Clear")?></button>
		<?php
		}
		?>
	<br><br>

	<br>
	<div id="footer-rights-new" class="textFooter" style="padding:10px 10px 10px 10px">

	</div>
	
	<div id="div-mb" style="display:none" title="<?php echo dic_("Routes.UpdateRoute")?>">
		<br><br>
		<span class="text4" style="padding:20px 20px 20px 20px; font-size:16px">
			<span class="ui-icon ui-icon-check" style="float:left; margin:0 7px 50px 0;"></span>
			<?php echo dic_("Routes.RouteTOrderNum")?> <font id="newroutenum"></font> <?php echo dic_("Tracking.SucUpd")?><br>
		</span>
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
    
    top.changeItem = false;
    var currdt = '<?php echo $currDateTime1?>';
    
    var clientUnit = '<?php echo $clientUnit?>';
    metric = '<?php echo $clientUnit?>';

	var _userId = '<?php echo session("user_id")?>';

    AllowedMaps = '<?php echo $AllowedMaps?>';
	DefMapType = '<?php echo $DefMap?>';
	var cntz = parseInt('<?php echo ($cntz-1)?>');

	naslov = '<?php echo $naslov?>';
	alarm = '<?php echo $alarm?>';
	totalkm = '<?php echo $totalkm?>';
	totaltime = '<?php echo $totaltime?>';
	
	vozilo = '<?php echo $vozilo?>';
	
	pause1 = '<?php echo $pause1?>';
	pause2 = '<?php echo $pause2?>';
	pause3 = '<?php echo $pause3?>';
	pause4 = '<?php echo $pause4?>';
	pause5 = '<?php echo $pause5?>';
	
	tostay = '<?php echo $tostay?>';
	
	driverid1 = '<?php echo $driverid1?>';
	driverid2 = '<?php echo $driverid2?>';
	driverid3 = '<?php echo $driverid3?>';
	
	if(driverid2 != "0")
		AddDriver();
	if(driverid3 != "0")
		AddDriver();
    LoadCurrentPosition = false;
    JustSave = false;
	
	Routing = true;
	
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
    var RecOnNew = false;

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
        ClearGraphicRoute();
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
        ClearGraphicRoute();
        for (var j = 0; j < tmpMarkersRoute.length; j++)
            Markers[0].removeMarker(tmpMarkersRoute[j]);
        tmpMarkersRoute = [];
        doOptimized('route', 'renderRoute');
        HideWait();
    });
    
	$('#btn-save').button({icons: {primary: "ui-icon-check"}});
	$('#btn-clear').button({icons: {primary: "ui-icon-close"}});
	$('#btn-save1').button({icons: {primary: "ui-icon-check"}});
	$('#btn-clear1').button({icons: {primary: "ui-icon-close"}});
	$('#btn-prezemi').button({icons: {primary: "ui-icon-link"}});

	if (Browser()!='iPad') {
		$('#alertiImg').mousemove(function (event) { ShowPopup(event, dic("alarm", lang)) });
		$('#alertiImg').mouseout(function (event) { HidePopup(); });
		$('#alertiWaitImg').mousemove(function (event) { ShowPopup(event, dic("Routes.RetainingXminPOI",lang)) });
		$('#alertiWaitImg').mouseout(function (event) { HidePopup(); });
		$('#pauseImg').mousemove(function (event) { ShowPopup(event, dic("Routes.BreaksRoute",lang)) });
		$('#pauseImg').mouseout(function (event) { HidePopup(); });
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

	function updateTotal(total)
	{
		if(total == "/")
			var tot = 0;
		else
			var tot = total;
		var currentMin = 0;
		if($('#IDMarker_Total').css('display') != 'none')
		{
			for(var bb = 0; bb < $('#MarkersIN')[0].children.length; bb++)
	        	if($('#MarkersIN')[0].children[bb].children[2].value != "/")
	        	{
	        		if($('#MarkersIN')[0].children[bb].children[2].value.substring($('#MarkersIN')[0].children[bb].children[2].value.indexOf("(")+2,$('#MarkersIN')[0].children[bb].children[2].value.indexOf(")")-1) != "/")
	        			var currentMin = parseInt($('#MarkersIN')[0].children[bb].children[2].value.substring($('#MarkersIN')[0].children[bb].children[2].value.indexOf("(")+2,$('#MarkersIN')[0].children[bb].children[2].value.lastIndexOf("min")-1),10);
        			else
        				var currentMin = 0;
	        		$('#MarkersIN')[0].children[bb].children[2].value = $('#MarkersIN')[0].children[bb].children[2].value.substring(0, $('#MarkersIN')[0].children[bb].children[2].value.indexOf("(")-1) + ((tot == 0) ? " ( / )" : " ( " + tot + " min )");
	        	}
        	if($('#MarkersIN')[0].children.length == 0)
        		$('#IDMarker_Total')[0].children[2].value = Sec2Str((tot*60) + (parseInt($('#txt_pause1').val(), 10)*60) + (parseInt($('#txt_pause2').val(), 10)*60) + (parseInt($('#txt_pause3').val(), 10)*60) + (parseInt($('#txt_pause4').val(), 10)*60) + (parseInt($('#txt_pause5').val(), 10)*60));
        	else
				$('#IDMarker_Total')[0].children[2].value = Sec2Str(Str2Sec($('#IDMarker_Total')[0].children[2].value)+(tot*60)-(currentMin*60));
		}
	}
	function updatePause(pause, _num){
		if(pause == "0")
			var pau = 0;
		else
			var pau = pause;
		if ($('#PauseOnRoute')[0] != undefined) {
	        var _html = '<div class="text8 corner5" style="cursor: pointer; font-size:12; width:97%; padding:2px 2px 2px 7px; height:26px; background-position: right center; background-repeat: no-repeat; background-origin: content-box;" id="IDMarker_pause'+_num+'">';
	        _html += '<input type="text" class="text9" readonly="readonly" value="'+ dic("pause",lang) + ' '  + _num + '" style="font-size: 11px; cursor: pointer; width: 50%; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" />';
	        _html += '<input type="text" class="text9" readonly="readonly" value="/" style="font-size: 11px; cursor: pointer; width: 20%; padding-left: 56px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" />';
	        _html += '<input type="text" class="text9" readonly="readonly" value="/" style="font-size: 11px; cursor: pointer; width: 20%; text-align: center; padding-left: 10px; position: relative; float: left; margin-top: 4px; background: transparent; border: 0px;" />';
	        _html += '</div>';
	        var current = 0;
	        if(document.getElementById("IDMarker_pause"+_num) == null)
	        	$('#PauseOnRoute').append(_html);
        	else
        		current = Str2Sec($('#IDMarker_pause'+_num)[0].children[2].value + "0 sec");
	       	$('#IDMarker_pause'+_num)[0].children[2].value = Sec2StrPause(pau*60);
	        $('#IDMarker_Total').css({ display: 'block' });
	        if(pau == "0")
	        {
	        	$('#IDMarker_pause'+_num).remove();
	        	$('#IDMarker_Total')[0].children[2].value = Sec2Str(Str2Sec($('#IDMarker_Total')[0].children[2].value)+(pau*60)-(current));
	        } else
				$('#IDMarker_Total')[0].children[2].value = Sec2Str(Str2Sec($('#IDMarker_Total')[0].children[2].value)+(pau*60)-(current));
	        $('#report-content').css({ height: (parseInt($('#report-content').css('height'), 10) + 30) + 'px' });
	    }
	}
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
                    var _opt = "<option value='0'><?php echo dic_("Routes.SelectUser")?></option>";
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

	function changeCulture() {
		 /*$('#operation').show();
		 $('#tdoper').show();
		 
		 var culid = $('#culture').children(":selected").val();
		// if ($('#culture').children(":selected").attr("id") != -1) {
			 $.ajax({
	            url: "CalculateOperations.php?cultureid=" + culid,
	            context: document.body,
	            success: function (data) {
	                document.getElementById('operation').innerHTML = data;
	            }
	        });
     	// } else {
       		//$('#operation').hide();
			//$('#tdoper').hide();
       //  }
       
		// document.getElementById('material').innerHTML = "";
		// document.getElementById('mechanisation').innerHTML = "";
		 //$('#material').hide();
		 //$('#tdmat').hide();
		 //$('#mechanisation').hide();
		 //$('#tdmech').hide();*/
	}
	
	function changeOperation() {
		/* $('#material').show();
		 $('#tdmat').show();
		 
		 var culid = $('#culture').children(":selected").val();
		 var operid = $('#operation').children(":selected").val();
	
		//if ($('#operation').children(":selected").attr("id") != -1) {
			 $.ajax({
	            url: "CalculateMaterials.php?cultureid=" + culid + "&operationid=" + operid,
	            context: document.body,
	            success: function (data) {
	                document.getElementById('material').innerHTML = data;
	            }
	        });
      	//}  else {
       		//$('#material').hide();
			//$('#tdmat').hide();
        // }
         
		//document.getElementById('mechanisation').innerHTML = "";
		//$('#mechanisation').hide();
		//$('#tdmech').hide();*/
	}
	
	function changeMaterial() {
		/* $('#mechanisation').show();
		 $('#tdmech').show();
		 
		 var culid = $('#culture').children(":selected").val();
		 var operid = $('#operation').children(":selected").val();
		 var matid = $('#material').children(":selected").val();
	
		 //if ($('#material').children(":selected").attr("id") != -1) {
			 $.ajax({
	            url: "CalculateMechanisation.php?cultureid=" + culid + "&operationid=" + operid + "&materialid=" + matid,
	            context: document.body,
	            success: function (data) {
	                document.getElementById('mechanisation').innerHTML = data;
	            }
	        });
     	// } else {
      		//$('#mechanisation').hide();
			//$('#tdmech').hide();
     	// }*/
	}

</script>
<?php
	closedb();
?>