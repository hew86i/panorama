var HOST_URL = 'http://open.mapquestapi.com';
var APP_KEY = 'Fmjtd%7Cluua21622q%2C2l%3Do5-h4a50';

var SAMPLE_ADVANCED_POST = HOST_URL + '/directions/v0/route?callback=renderAdvancedNarrative';
var advancedOptions = '';
var shapePointsElev;

var ELEVATION_CHART = '/elevation/v1/getElevationChart?';

function showAdvancedURL(_lon2, _lat2, _lon1, _lat1) {
	advancedOptions = SAMPLE_ADVANCED_POST;
	var inFormat = 'kvp';
	var outFormat = 'json';
	var routeType = "shortest";
	var dateType = "1";
	var timeType = "1";
	var timeTypeMulti = "1";
	var date = "02/02/2012";
	var localTime = "12:00";
	var locale = "en_US";
    var unit = "k";
   // var avoidTimedConditions = document.getElementById('avoidTimedConditions');
   // var ambiguities = document.getElementById('ambiguities').value;
    var shapeFormat = "raw";
    var generalize = "0";
    var narrativeType = "default";
    //var enhancedNarrative = document.getElementById('enhancedNarrative');
   // if (ambiguities == "wonky") {
    //   ambiguities = '';
    //}
    var from = _lat2 + "," + _lon2;
    var to = _lat1 + "," + _lon1;
    var drivingStyle = "2";
    var highwayEfficiency = "21.0";    
    
    //  As of 2009/08/03, ambiguities flag is *always* done via KVP. -MAR
   // if (ambiguities.length > 0) {
   //     advancedOptions += '&ambiguities=' + ambiguities;
   // }

    
    var isoLocal;
    if (routeType == 'multimodal') {
       isoLocal = getISOTime();
    }
    
    if (inFormat == 'kvp') {
//        var count = 0;
//        for (count = 0; document.getElementById('avoids' + count); count++) {
//            var foo = document.getElementById('avoids' + count)
//            if (foo.checked) {
//                advancedOptions += '&avoids=' + foo.value;
//            }
//        }
      //  if (avoidTimedConditions.checked) {
      //  		advancedOptions += '&avoidTimedConditions=' + 'true';
      // }
      //  else advancedOptions += '&avoidTimedConditions=' + 'false';
        
        advancedOptions += '&outFormat=' + outFormat;
        advancedOptions += '&routeType=' + routeType;

		if (routeType == 'multimodal') {
			document.getElementById('timeMultimodal').style.display = "";
			document.getElementById('timeOther').style.display = "none";
			
			advancedOptions += '&timeType=' + timeTypeMulti;
			if (timeTypeMulti == '2') {
				document.getElementById('dateType').disabled = false;
				advancedOptions += '&dateType=' + dateType;
				if (dateType == '0') {
					document.getElementById('date').disabled = false;
					document.getElementById('localTime').disabled = false;
					advancedOptions += '&date=' + date;
					advancedOptions += '&localTime=' + localTime;
				} else {
					document.getElementById('date').disabled = true;
					document.getElementById('localTime').disabled = false;
					advancedOptions += '&localTime=' + localTime;
				}
			} else {
				document.getElementById('dateType').disabled = true;
				document.getElementById('date').disabled = true;
				document.getElementById('localTime').disabled = true;
			}
		} else {
			//document.getElementById('timeOther').style.display = "";
			//document.getElementById('timeMultimodal').style.display = "none";
			
			advancedOptions += '&timeType=' + timeType;
			if (timeType == '2') {
				document.getElementById('dateType').disabled = false;
				advancedOptions += '&dateType=' + dateType;
				if (dateType == '0') {
					document.getElementById('date').disabled = false;
					document.getElementById('localTime').disabled = false;
					advancedOptions += '&date=' + date;
					advancedOptions += '&localTime=' + localTime;
				} else {
					document.getElementById('date').disabled = true;
					document.getElementById('localTime').disabled = false;
					advancedOptions += '&localTime=' + localTime;
				}
			} else {
				//document.getElementById('dateType').disabled = true;
				//document.getElementById('date').disabled = true;
				//document.getElementById('localTime').disabled = true;
			}
		}
		
        /*if (isoLocal) {
           advancedOptions += '&isoLocal=' + isoLocal;
           advancedOptions += '&timeType=2';
        }*/
        //displayMultimodalMessage(isoLocal != null);

		if (narrativeType != 'default') {
		    advancedOptions += '&narrativeType=' + narrativeType;
		}
		//        if (enhancedNarrative.checked) {
		//        		advancedOptions += '&enhancedNarrative=' + 'true';
		//        }
		//else

		advancedOptions += '&enhancedNarrative=' + 'false';

        if (shapeFormat != '[none]') {
            advancedOptions += '&shapeFormat=' + shapeFormat;
            advancedOptions += '&generalize=' + generalize;
        }
        advancedOptions += '&locale=' + locale;
        advancedOptions += '&unit=' + unit;
        advancedOptions += '&from=' + from;
        if (to.length > 0) {
           advancedOptions += '&to=' + to;
        }
        advancedOptions += '&drivingStyle=' + drivingStyle;
        advancedOptions += '&highwayEfficiency=' + highwayEfficiency;        
    } else if (inFormat == 'json') {	
        advancedOptions += '&outFormat=' + outFormat;
        advancedOptions += '&inFormat=json';
        advancedOptions += "&json=";
        var jsonText = '{';
        jsonText += 'locations:[' + from + '';
        if (to.length > 0) {
            jsonText += ',' + to;
        }
        jsonText += ']';
        var count = 0;
        var avoids = '';
        for (count = 0; document.getElementById('avoids' + count); count++) {
            var foo = document.getElementById('avoids' + count)
            if (foo.checked) {
                if (avoids.length > 0) {
                    avoids += ',';
                }
                avoids += foo.value;
            }
        }
        jsonText += ',options:{';
        jsonText += 'avoids:[' + avoids + ']';

      //  if (avoidTimedConditions.checked) {
      //  		jsonText += ',avoidTimedConditions:' + 'true';
      //  }
      //  else jsonText += ',avoidTimedConditions:' + 'false';
        
        if (shapeFormat != '[none]') {
            jsonText += ',shapeFormat:' + shapeFormat;
            jsonText += ',generalize:' + generalize;
        }
        jsonText += ',routeType:' + routeType;  

		if (routeType == 'multimodal') {
			document.getElementById('timeMultimodal').style.display = "";
			document.getElementById('timeOther').style.display = "none";
			
			jsonText += ',timeType:' + timeTypeMulti;
			if (timeTypeMulti == '2') {
				document.getElementById('dateType').disabled = false;
				jsonText += ',dateType:' + dateType;
				if (dateType == '0') {
					document.getElementById('date').disabled = false;
					document.getElementById('localTime').disabled = false;
					jsonText += ',date:"' + date + '"';
					jsonText += ',localTime:"' + localTime + '"';
				} else {
					document.getElementById('date').disabled = true;
					document.getElementById('localTime').disabled = false;
					jsonText += ',localTime:"' + localTime + '"';
				}
			} else {
				document.getElementById('dateType').disabled = true;
				document.getElementById('date').disabled = true;
				document.getElementById('localTime').disabled = true;
			}
		} else {
			document.getElementById('timeOther').style.display = "";
			document.getElementById('timeMultimodal').style.display = "none";
			
			jsonText += ',timeType:' + timeType;
			if (timeType == '2') {
				document.getElementById('dateType').disabled = false;
				jsonText += ',dateType:' + dateType;
				if (dateType == '0') {
					document.getElementById('date').disabled = false;
					document.getElementById('localTime').disabled = false;
					jsonText += ',date:"' + date + '"';
					jsonText += ',localTime:"' + localTime + '"';
				} else {
					document.getElementById('date').disabled = true;
					document.getElementById('localTime').disabled = false;
					jsonText += ',localTime:"' + localTime + '"';
				}
			} else {
				document.getElementById('dateType').disabled = true;
				document.getElementById('date').disabled = true;
				document.getElementById('localTime').disabled = true;
			}
		}
		
        jsonText += ',locale:' + locale;
        jsonText += ',unit:' + unit;

		/*if (isoLocal) {
           jsonText += ',isoLocal:' + isoLocal;
           jsonText += ',timeType:2';
        }*/
        displayMultimodalMessage(isoLocal != null);

        if (narrativeType != 'default') {
            jsonText += ',narrativeType:' + narrativeType;
        }
        jsonText += ',enhancedNarrative:' + enhancedNarrative.checked;
        jsonText += ',drivingStyle: ' + drivingStyle;
        jsonText += ',highwayEfficiency: ' + highwayEfficiency;
        jsonText += '}}';
        advancedOptions += jsonText;
    } else if (inFormat == 'xml') {
        advancedOptions += '&outFormat=' + outFormat;
        advancedOptions += '&inFormat=xml';
        advancedOptions += "&xml=";
        var xmlText = '<route>';
        xmlText += '<locations>';
        xmlText += '<location>' + from + '</location>';
        if (to.length > 0) {
           xmlText += '<location>' + to + '</location>';
        }
        xmlText += '</locations>';
        var count = 0;
        var avoids = '<avoids>';
        for (count = 0; document.getElementById('avoids' + count); count++) {
            var foo = document.getElementById('avoids' + count)
            if (foo.checked) {
                avoids += '<avoid>' + foo.value + '</avoid>';
            }
        }
        avoids += '</avoids>'
        xmlText += '<options>';
        xmlText += avoids;
       // if (avoidTimedConditions.checked) {
      //  		xmlText += '<avoidTimedConditions>' + 'true' + '</avoidTimedConditions>';
       // }
       // else xmlText += '<avoidTimedConditions>' + 'false' + '</avoidTimedConditions>';
        
        if (shapeFormat != '[none]') {
            xmlText += '<shapeFormat>' + shapeFormat + '</shapeFormat>';
            xmlText += '<generalize>' + generalize + '</generalize>';
        }
        xmlText += '<routeType>' + routeType + '</routeType>';  

		if (routeType == 'multimodal') {
			document.getElementById('timeMultimodal').style.display = "";
			document.getElementById('timeOther').style.display = "none";

			xmlText += '<timeType>' + timeTypeMulti + '</timeType>';
			if (timeTypeMulti == '2') {
				document.getElementById('dateType').disabled = false;
				xmlText += '<dateType>' + dateType + '</dateType>';
				if (dateType == '0') {
					document.getElementById('date').disabled = false;
					document.getElementById('localTime').disabled = false;
					xmlText += '<date>' + date + '</date>';
					xmlText += '<localTime>' + localTime + '</localTime>';
				} else {
					document.getElementById('date').disabled = true;
					document.getElementById('localTime').disabled = false;
					xmlText += '<localTime>' + localTime + '</localTime>';
				}
			} else {
				document.getElementById('dateType').disabled = true;
				document.getElementById('date').disabled = true;
				document.getElementById('localTime').disabled = true;
			}
		} else {
			document.getElementById('timeOther').style.display = "";
			document.getElementById('timeMultimodal').style.display = "none";

			xmlText += '<timeType>' + timeType + '</timeType>';
			if (timeType == '2') {
				document.getElementById('dateType').disabled = false;
				xmlText += '<dateType>' + dateType + '</dateType>';
				if (dateType == '0') {
					document.getElementById('date').disabled = false;
					document.getElementById('localTime').disabled = false;
					xmlText += '<date>' + date + '</date>';
					xmlText += '<localTime>' + localTime + '</localTime>';
				} else {
					document.getElementById('date').disabled = true;
					document.getElementById('localTime').disabled = false;
					xmlText += '<localTime>' + localTime + '</localTime>';
				}
			} else {
				document.getElementById('dateType').disabled = true;
				document.getElementById('date').disabled = true;
				document.getElementById('localTime').disabled = true;
			}
		}

        xmlText += '<locale>' + locale + '</locale>';
        xmlText += '<unit>' + unit + '</unit>'

		/*if (isoLocal) {
           jsonText += '<isoLocal>' + isoLocal + '</isoLocal>';
           jsonText += '<timeType>2</timeType>';
        }*/
        displayMultimodalMessage(isoLocal != null);

        if (narrativeType != 'default') {
            xmlText += '<narrativeType>' + narrativeType + '</narrativeType>';
        }
        xmlText += '<enhancedNarrative>' + enhancedNarrative.checked + '</enhancedNarrative>';
        xmlText += '<drivingStyle>' + drivingStyle + '</drivingStyle>';
        xmlText += '<highwayEfficiency>' + highwayEfficiency + '</highwayEfficiency>';
        xmlText += '</options>';
        xmlText += '</route>'
        advancedOptions += xmlText;
    }
    
    //var safe = advancedOptions;
    //document.getElementById('advancedSampleUrl').innerHTML = safe.replace(/</g, '&lt;').replace(/>/g, '&gt;');;
};


function renderAdvancedNarrative(response) {
    var legs;
    var html = '';
    var i = 0;
    var j = 0;
    var trek;
    var maneuver;
    var ruleOrder = new Array();  //for Enhanced Narrative

    if (response.info.statuscode && (response.info.statuscode != 0)) {
        var text = "Whoops!  There was an error during the request:\n";
        if (response.info.messages) {
            for (i = 0; i < response.info.messages.length; i++) {
                text += response.info.messages[i] + "\n";
            }
        }
        alert(text);
        return;
    }

    if (response.route.shape && response.route.shape.shapePoints) {
	   shapePointsElev = response.route.shape.shapePoints;
	}
    
    if (response.collections) { // Location ambiguities!
        html = "<p>Whoops!  Ambiguous addresses found in request:</p><ol>";
        for (i = 0; i < response.collections.length; i++) {
            var collection = response.collections[i];
            for (j = 0; j < collection.length; j++) {
                html += '<li>';
                html += ' ' + (collection[j].adminArea5 || ' ');  
                html += ' ' + (collection[j].adminArea4 || ' ');  
                html += ' ' + (collection[j].adminArea3 || ' ');  
                html += ' ' + (collection[j].adminArea2 || ' ');  
                html += ' ' + (collection[j].adminArea1 || ' ');  
                html += '</li>';
            }
        }
        html += '</ol>';
        document.getElementById('advancedNarrative').innerHTML = html;
        return;        
    }
        
    legs = response.route.legs;
    
    if (response.route.distance) {
        html += '<button id="testElevation" class="buttonEl" onclick="doElevation();">Show Elevation Chart</button>&nbsp;&nbsp;';
        html += "Your trip is <b> " + response.route.distance.toFixed(2) + "</b> miles.";
//        if (response.route.fuelUsed) {
//           html += '<p>Total fuel used was approximately <b>' + response.route.fuelUsed.toFixed(2) + '</b> gallons.</p>';    
//        }
    }
    html += '<div id="closeAdvanced" onmousemove="javascript: $(\'#closeAdvanced\').css(\'backgroundPosition\', \'0px 0px\');" onmouseout="javascript: $(\'#closeAdvanced\').css(\'backgroundPosition\', \'0px 16px\');" onclick="javascript: $(\'#advancedNarrative\').css({ display: \'none\'}); $(\'#showElevationChart\').css({ display: \'none\'})" style="position: relative; float: right; display: block; background-image: url(\'../../Images/closeSmall.png\'); width: 16px; height: 16px; background-position: 0 16px; right: 5px; top: 5px; cursor: pointer;"></div>';
    html += '<br><table><tr><th colspan=2>Narrative</th>'
    html += '<th colspan=1>Distance</th></tr><tbody>'
    
    var unit = response.route.options.unit;
    if (unit) {
        if (unit == 'K') {
            unit = 'km';
        } else if (unit == 'M') {
            unit = 'miles';
        }
    }
    
    for (; i < legs.length; i++) {
        for (j = 0; j < legs[i].maneuvers.length; j++) {
        	var last = legs[i].maneuvers.length - 1;
            maneuver = legs[i].maneuvers[j];
                        
            html += '<tr>';
            html += '<td>&nbsp;';
            if (maneuver.iconUrl) {
                html += '<img src="' + maneuver.iconUrl + '">  '; 
            } 
            for (k = 0; k < maneuver.signs.length; k++) {
                var sign = maneuver.signs[k];
                if (sign && sign.url) {
                    html += '<img src="' + sign.url + '">  '; 
                }
            }
                        
            html += '</td>'
            //added following because we're only using lat/lngs currently
            if (j == last){
            	html += '<td>' + maneuver.narrative.replace(maneuver.narrative, "Welcome to your destination.")  
            }
            else {
            	html += '<td>' + maneuver.narrative 
            }
            notes = maneuver.maneuverNotes;
            if (notes.length > 0){
            	for (n = 0; n < notes.length; n++) {
                	ruleOrder.push(notes[n]);
                }
            	ruleOrder.sort(sortByRuleId);
	            for (n = 0; n < ruleOrder.length; n++) {
	            	html += '<br>'+ ruleOrder[n].manNote;
	            }
            	ruleOrder = new Array();	
            }

            html += '</td>'

            if (unit && maneuver.distance) {
                maneuver.distance = 
                html += '<td>  (' + maneuver.distance.toFixed(2) + ' ' + unit + ')'
                html += '</td>';
            }
            else {
	            html += '<td>  &nbsp; '
	            html += '</td>';
            }
                        
            html += '</tr>';
        }
    }

    html += '</tbody></table>';
    
//    if (response.route.shape && response.route.shape.shapePoints) {
//        var points = response.route.shape.shapePoints;
//        if (response.route.options.shapeFormat && 
//                ((response.route.options.shapeFormat == "cmp") ||
//                 (response.route.options.shapeFormat == "cmp6"))) {
//            html += '<br><table><tr><th>Shape Points (compressed)</th></tr><tbody>'
//            html += '<tr><td><pre class="code">';
//            while (points.length > 80) {
//                html += points.substring(0,80) + '\n';
//                points = points.substring(80);
//            }
//            html += '</td></tr>';
//            html += '</tbody></table>';
//        } else {
//            html += '<br><table><tr><th>Shape Points {latitude, longitude}</th></tr><tbody>'
//            html += '<tr><td>';
//            for (i = 0; i < points.length; i += 2) {
//               if (i > 0) {
//                   html += ', ';
//               }
//               html += '{' + points[i+1] + ', ' + points[i] + '}';
//               if (!((i+2) % 6)) {
//                   html += "<br>";
//               }
//            }
//            html += '</td></tr>';
//            html += '</tbody></table>';
//        }
//    }
    
    document.getElementById('advancedNarrative').innerHTML = html;
	document.getElementById('advancedNarrative').style.display = "block";
	document.getElementById('showElevationChart').style.display = "none";
}


// ascending order
function sortByRuleId(a,b) {
	return parseInt(a.ruleId) - parseInt(b.ruleId);
}


function doAdvanced(_lon2, _lat2, _lon1, _lat1) {
    document.getElementById('advancedNarrative').innerHTML = 'Pending...';
    var script = document.createElement('script');
    script.type = 'text/javascript';
    showAdvancedURL(_lon2, _lat2, _lon1, _lat1);
    var newURL = advancedOptions;
    script.src = newURL;
    document.body.appendChild(script);
};


function doElevation() {
    if (!shapePointsElev) {
        return;
    }
	document.getElementById('testElevation').style.display = "none";
	var script = document.createElement('script');
    script.type = 'text/javascript';

	var newChartURL = HOST_URL + ELEVATION_CHART;
	newChartURL += '&inFormat=kvp&shapeFormat=raw&width=425&height=350&latLngCollection=' + shapePointsElev;
	script.src = newChartURL;

	document.getElementById('showElevationChart').innerHTML = '<IMG SRC ="' + script.src + '">';    
	document.getElementById('showElevationChart').style.display = 'block';
}


function changeAmbiguity() {
    var ambiguities = document.getElementById('ambiguities').value;
    if (ambiguities.length > 0) {
        document.getElementById('from').value = 'Lancaster';
    } else {
        document.getElementById('from').value = 'Lancaster, PA';
    }
    showAdvancedURL();
}