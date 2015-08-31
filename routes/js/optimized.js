var HOST_URL = 'http://open.mapquestapi.com';
var APP_KEY = 'Fmjtd%7Cluua21622q%2C2l%3Do5-h4a50';

var action = 'optimizedroute';

var OPTIMIZED_URL = HOST_URL + '/directions/v2/' + action + '?callback=renderOptimized';
//h ttp://open.mapquestapi.com/directions/v0/optimizedroute?callback=renderOptimized&json={locations:[{latLng:{lat:51.524410144966154,lng:-0.12989273652335526}},{latLng:{lat:51.54495915136182,lng:-0.16518885449221493}},{latLng:{lat:51.52061842826141,lng:-0.1495479641837033}},{latLng:{lat:51.52850609658769,lng:-0.20170525707760403}}]}

var LOCATIONS = '{locations:[{latLng:{lat:41.982967,lng:21.481180}},{latLng:{lat:41.982568,lng:21.434925}},{latLng:{lat:41.983071,lng:21.408225}},{latLng:{lat:41.997800,lng:21.403600}},{latLng:{lat:41.999857,lng:21.419087}},{latLng:{lat:42.003717,lng:21.467182}}]}';

OPTIMIZED_URL += '&unit=k&json=' + LOCATIONS.replace(' ', '').replace('\n','');

//h ttp://open.mapquestapi.com/directions/v0/optimizedroute?callback=renderOptimized&json={locations:[{latLng:{lat:51.524410144966154,lng:-0.12989273652335526}},{latLng:{lat:51.54495915136182,lng:-0.16518885449221493}},{latLng:{lat:51.52061842826141,lng:-0.1495479641837033}},{latLng:{lat:51.52850609658769,lng:-0.20170525707760403}}]}
//h ttp://open.mapquestapi.com/directions/v0/route?callback=renderOptimized&json={locations:[{latLng:{lat:51.524410144966154,lng:-0.12989273652335526}},{latLng:{lat:51.54495915136182,lng:-0.16518885449221493}},{latLng:{lat:51.52061842826141,lng:-0.1495479641837033}},{latLng:{lat:51.52850609658769,lng:-0.20170525707760403}}]}

function doOptimized(_action, _render, _routetype) {	
    var script = document.createElement('script');
    script.type = 'text/javascript';
    //var newURL = OPTIMIZED_URL.replace('YOUR_KEY_HERE', APP_KEY);
    var location = "{locations:[";
    for (var i = 1; i < PointsOfRoute.length; i++)
        location += "{latLng:{lat:" + PointsOfRoute[i].lat + ",lng:" + PointsOfRoute[i].lon + "}},";
    location = location.substring(0, location.length - 1);
    location += "]}";
    PointsOfRouteBefore = PointsOfRoute;
    
    var newURL = HOST_URL + "/directions/v2/" + _action + "?key="+ APP_KEY + "&routeType=" + _routetype + "&callback=" + _render + "&unit=k&json=" + location;
    
    //newURL = newURL.replace('ACTION', action);
    //debugger;
    script.src = newURL;
    document.body.appendChild(script);
};

function showOptimizedURL() {
    //action = document.getElementById('optimizedOn').checked ? "optimizedroute" : "route";
    action = "optimizedroute";
    var html = 'REQUEST URL:\n';
    html += '\n' + HOST_URL + '/directions/v2/';
    html += action;
    html += '\nREQUEST BODY:\n';
    html += LOCATIONS;
    document.getElementById('optimizedSampleUrl').innerHTML = html;
}

function renderOptimized(response) {
if (clientUnit == "km" || clientUnit == "Km") {
        response.route.options.unit = 'K';
        var unitM = 1.609344;
    } else {
        response.route.options.unit = 'M';
        var unitM = 1;
    }

    var legs = response.route.legs;
    var html = '';
    var i = 0;
    var j = 0;
    var trek;
    var maneuver;
    
    var unit = response.route.options.unit;
    if (unit) {
        if (unit == 'K') {
            unit = 'km';
        } else if (unit == 'M') {
            unit = 'miles';
        }
    }
    
    if (response.route.distance) {
        html += '<p style="padding-left: 15px;">' + dic('YourTrip', lang) + '<b> ' + (response.route.distance * unitM).toFixed(2) + '</b> ' + unit + '.</p><div id="closeoptimized" onmousemove="javascript: $(\'#closeoptimized\').css(\'backgroundPosition\', \'0px 0px\');" onmouseout="javascript: $(\'#closeoptimized\').css(\'backgroundPosition\', \'0px 16px\');" onclick="javascript: $(\'#optimizedNarrative\').css({ display: \'none\'})" style="position: relative; float: right; display: block; background-image: url(\'../images/closeSmall.png\'); width: 16px; height: 16px; background-position: 0 16px; right: 8px; top: -33px; cursor: pointer;"></div>';
    }
    html += '<div style="overflow-x: hidden; overflow-y: auto; width: 495px; position: relative; top: -25px; height: 360px;">';
    html += '<table class="text2"><tr><th colspan=2>' + dic('Narrative', lang) + '</th>'
    html += '<th colspan=1>' + dic('Distance', lang) + '</th></tr><tbody>'
    
    
    for (i = 0; i < legs.length; i++) {
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
            	html += '<td>' + maneuver.narrative.replace(maneuver.narrative, dic("Welcome", lang)) 
            }
             else {
            	html += '<td>' + maneuver.narrative 
            }
            if (unit && maneuver.distance) {
                maneuver.distance =
                html += '<td style="width: 95px;">  (' + (maneuver.distance * unitM).toFixed(2) + ' ' + unit + ')'
                html += '</td>';
            }    
            else {
	            html += '<td>  &nbsp; '
	            html += '</td>';
            }
            html += '</tr>';
        }
    }

    html += '</tbody></table><div>';

    document.getElementById('optimizedNarrative').innerHTML = html;
    debugger;
    var PointsOfRouteTEMP = [];
    var num = 1;
    for (var i = 0; i < response.route.locations.length; i++) {
        for (var j = 1; j < PointsOfRoute.length; j++) {
            if (PointsOfRoute[j].lat.indexOf(String(response.route.locations[i].latLng.lat)) != -1) {
                PointsOfRouteTEMP[num] = PointsOfRoute[j];
                num++;
                break;
            }
        }
    }
    
    PointsOfRoute = PointsOfRouteTEMP;
    for (var i = 1; i < PointsOfRouteTEMP.length; i++)
        putInRoute(PointsOfRoute[i].id, PointsOfRoute[i].lon, PointsOfRoute[i].lat, PointsOfRoute[i].name, 0);
}

function renderRoute(response) {
    response.route.options.locale = "de_DE";
    if (clientUnit == "km" || clientUnit == "Km") {
        response.route.options.unit = 'K';
        var unitM = 1.609344;
    } else {
        response.route.options.unit = 'M';
        var unitM = 1;
    }
    
    var legs = response.route.legs;
    var html = '';
    var i = 0;
    var j = 0;
    var trek;
    var maneuver;

    var unit = response.route.options.unit;
    if (unit) {
        if (unit == 'K') {
            unit = 'km';
        } else if (unit == 'M') {
            unit = 'miles';
        }
    }

    if (response.route.distance) {
        html += '<p style="padding-left: 15px">' + dic('YourTrip', lang) + '<b> ' + (response.route.distance * unitM).toFixed(2) + '</b> ' + unit + '.</p><div id="closeoptimized" onmousemove="javascript: $(\'#closeoptimized\').css(\'backgroundPosition\', \'0px 0px\');" onmouseout="javascript: $(\'#closeoptimized\').css(\'backgroundPosition\', \'0px 16px\');" onclick="javascript: $(\'#optimizedNarrative\').css({ display: \'none\'})" style="position: relative; float: right; display: block; background-image: url(\'../images/closeSmall.png\'); width: 16px; height: 16px; background-position: 0 16px; right: 8px; top: -33px; cursor: pointer;"></div>';
    }
    html+= '<div style="overflow-x: hidden; overflow-y: auto; width: 495px; position: relative; top: -25px; height: 360px;">'
    html += '<table class="text2"><tr><th colspan=2>' + dic('Narrative', lang) + '</th>'
    html += '<th colspan=1>' + dic('Distance', lang) + '</th></tr><tbody>';

    for (i = 0; i < legs.length; i++) {
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
            if (j == last) {
                html += '<td>' + maneuver.narrative.replace(maneuver.narrative, dic("Welcome", lang))
            }
            else {
                html += '<td>' + maneuver.narrative
            }
            if (unit && maneuver.distance) {
                maneuver.distance =
                html += '<td style="width: 95px;">  (' + (maneuver.distance * unitM).toFixed(2) + ' ' + unit + ')'
                html += '</td>';
            }
            else {
                html += '<td>  &nbsp; '
                html += '</td>';
            }
            html += '</tr>';
        }
    }

    html += '</tbody></table></div>';

    document.getElementById('optimizedNarrative').innerHTML = html;
}