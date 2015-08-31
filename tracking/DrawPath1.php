<script>
function DrawPath1(LonArray, LatArray, DistArray, dtArray, alphaArray, vhID, VehReg) {
    if (ShowHideTrajectory==false) {return}
	
	var _lon = LonArray.split(",")
	var _lat = LatArray.split(",")

	var points = new Array();
	var styles =  new Array();
	var styles1 =  new Array(); //{'strokeWidth': '4', 'strokeColor': '#0000FF', 'strokeOpacity': '0.8', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg + '<br />' +  };
	//var styles = {'strokeWidth': '4', 'strokeColor': '#2AAEDE', 'strokeOpacity': '0.9', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg };
	//var stylesShadow = {'strokeWidth': '6', 'strokeColor': '#000000', 'strokeOpacity': '0.5' };
	var cir = _lon.length / 3
	var cir1 = cir + cir
	var cir2 = _lon.length
	var numA = 0;
	
	for (var z = 0; z < Maps.length; z++) {
		if(Maps[z] != null)
		{
			//var num2 = Math.abs(18 - Maps[z].getZoom());
			var num2 = podatok[Maps[z].getZoom()]; //Math.abs(19 - Maps[z].getZoom()) + Math.abs(18 - Maps[z].getZoom()) + Math.abs(18 - Maps[z].getZoom()) + Math.abs(18 - Maps[z].getZoom());
		    point = new OpenLayers.Geometry.Point(_lon[1], _lat[1]);
	        point.transform(
			    new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
			    Maps[z].getProjectionObject() // to Spherical Mercator Projection
		    );
	        styles.push({ 'strokeWidth': '4', 'strokeColor': '#2AAEDE', 'strokeOpacity': '0.9', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg + '<br />' + dtArray.split(",")[1] });
	        styles1.push({ 'strokeWidth': '6', 'strokeColor': '#000000', 'strokeOpacity': '0.5', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg + '<br />' + dtArray.split(",")[1] });
	        points.push(point);
	
			LastPointsLon[z][vhID] = _lon[_lon.length-1];
		    LastPointsLat[z][vhID] = _lat[_lat.length-1];
		    var _numpoints = 2;
		    for (var i = 2; i < _lon.length - 1; i++) {
		    	if((parseFloat(DistArray.split(",")[i]) < 2500))
				{
			        point = new OpenLayers.Geometry.Point(_lon[i], _lat[i]);
			        point.transform(
					    new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
					    Maps[z].getProjectionObject() // to Spherical Mercator Projection
				    );
			        styles.push({ 'strokeWidth': '4', 'strokeColor': '#2AAEDE', 'strokeOpacity': '0.9', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg + '<br />' + dtArray.split(",")[i] });
			        styles1.push({ 'strokeWidth': '6', 'strokeColor': '#000000', 'strokeOpacity': '0.5', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg + '<br />' + dtArray.split(",")[i] });
			        points.push(point);
			        if(points[_numpoints - 1] != undefined)
			        {
			        	var lineString1 = new OpenLayers.Geometry.LineString([points[_numpoints - 2], points[_numpoints - 1]]);
				        var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, styles[_numpoints - 2]);
				        var lineString2 = new OpenLayers.Geometry.LineString([points[_numpoints - 2], points[_numpoints - 1]]);
				        var lineFeature2 = new OpenLayers.Feature.Vector(lineString2, null, styles1[_numpoints - 2]);
				        vectors[z].addFeatures([lineFeature2]);
				        vectors[z].addFeatures([lineFeature1]);
				        PathPerVeh[z][vhID][PathPerVeh[z][vhID].length] = lineFeature1;
				        PathPerVehShadow[z][vhID][PathPerVehShadow[z][vhID].length] = lineFeature2;
				        lineFeature1.layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>" + dic("RouteForV", lang) + "<br /></strong>'+event.target._style.VehID)}");
				        lineFeature1.layer.events.element.setAttribute("onmouseout", "HidePopup()");
				        lineFeature2.layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>" + dic("RouteForV", lang) + "<br /></strong>'+event.target._style.VehID)}");
				        lineFeature2.layer.events.element.setAttribute("onmouseout", "HidePopup()");
			       	}
				    if(numA == 3)
	    			{
	    				drawDirection(z, _lon[i], _lat[i], vhID, VehReg, dtArray.split(",")[i], alphaArray.split(",")[i], num2);
	    				num2--;
	    				if(num2 == 0)
	    					num2 = podatok[Maps[z].getZoom()]; //Math.abs(19 - Maps[z].getZoom()) + Math.abs(18 - Maps[z].getZoom()) + Math.abs(18 - Maps[z].getZoom()) + Math.abs(18 - Maps[z].getZoom());
	    					//num2 = Math.abs(18 - Maps[z].getZoom());
	    				numA = 0;
				    } else
					{
				    	numA++;
				    }
				} else {
			        var points = new Array();
					var styles = new Array();
					_numpoints = 0;
		       }
		       _numpoints++;
		    }
		    for (var j = 0; j < Car.length; j++) {
		        if (Car[j].id == vhID) {
		            point = new OpenLayers.Geometry.Point(Car[j].lon, Car[j].lat);
		            point.transform(
						new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
						Maps[z].getProjectionObject() // to Spherical Mercator Projection
					);
		            styles.push({ 'strokeWidth': '4', 'strokeColor': '#2AAEDE', 'strokeOpacity': '0.9', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg + '<br />' + Car[j].datum.split(" ")[1] + " " + Car[j].datum.split(" ")[0] });
		            styles1.push({ 'strokeWidth': '6', 'strokeColor': '#000000', 'strokeOpacity': '0.5', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg + '<br />' + Car[j].datum.split(" ")[1] + " " + Car[j].datum.split(" ")[0] });
		            points.push(point);
		            var lineString1 = new OpenLayers.Geometry.LineString([points[i - 2], points[i - 1]]);
			        var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, styles[i - 2]);
			        var lineString2 = new OpenLayers.Geometry.LineString([points[i - 2], points[i - 1]]);
			        var lineFeature2 = new OpenLayers.Feature.Vector(lineString2, null, styles1[i - 2]);
			        vectors[z].addFeatures([lineFeature2]);
			        vectors[z].addFeatures([lineFeature1]);
			        PathPerVeh[z][vhID][PathPerVeh[z][vhID].length] = lineFeature1;
			        PathPerVehShadow[z][vhID][PathPerVehShadow[z][vhID].length] = lineFeature2;

			        lineFeature1.layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>" + dic("RouteForV", lang) + "<br /></strong>'+event.target._style.VehID)}");
			        lineFeature1.layer.events.element.setAttribute("onmouseout", "HidePopup()");
			        lineFeature2.layer.events.element.setAttribute("onmousemove", "if(event.target.id.indexOf(\'OpenLayers.Geometry.LineString\') != -1){ShowPopup(event, '<strong>" + dic("RouteForV", lang) + "<br /></strong>'+event.target._style.VehID)}");
			        lineFeature2.layer.events.element.setAttribute("onmouseout", "HidePopup()");
		        }
		    }
		}
	}
	
	return
}
</script>