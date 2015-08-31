<script>
function DrawPath_Rec(LonArray, LatArray, DistArray, DTArray, alphaArray, alarmsArray, idlingArray, DTArrayDiff, parkingArray, vhID, VehReg) {
    
    //if (ShowHideTrajectory == false) { return }
    var _lon = LonArray.split(",")
    var _lat = LatArray.split(",")

    var points = new Array();
    var styles = {'strokeWidth': '4', 'strokeColor': '#2AAEDE', 'strokeOpacity': '0.9', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg };
	var stylesShadow = {'strokeWidth': '6', 'strokeColor': '#000000', 'strokeOpacity': '0.5' };
    if (MapType[0] == 'YAHOOM') {
        // GLOBSY MAPS
		//Maps[0].setCenter(new OpenLayers.LonLat(_lon[0], _lat[0]), zl);
		Maps[0].setCenter(new OpenLayers.LonLat(_lon[0], _lat[0]).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject()), DefMapZoom);
    
    } else {
        Maps[0].setCenter(new OpenLayers.LonLat(_lon[0], _lat[0]).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject()), DefMapZoom);
    }

    var cir = _lon.length / 3
    var cir1 = cir + cir
    var cir2 = _lon.length

    var debelina = 6
    var opac = 0.7

    /*for (i in _lon) {
        if (i > 0 && i < _lon.length - 2) {

            point = new OpenLayers.Geometry.Point(_lon[i], _lat[i]);
            point.transform(
				new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
				Maps[0].getProjectionObject() // to Spherical Mercator Projection
			  );
            points.push(point);
        }
    }*/
	var numA = 0;
	var num2 = podatok[Maps[0].getZoom()]; //Math.abs(19 - Maps[0].getZoom()) + Math.abs(18 - Maps[0].getZoom()) + Math.abs(18 - Maps[0].getZoom()) + Math.abs(18 - Maps[0].getZoom());
	for (var _j = 0; _j < _lon.length; _j++) {
		//if(parseInt(DistArray.split(",")[_j], 10) > 1500)
///			debugger; ((parseInt(diffDTArray.split(",")[_j], 10) * 40) < 6000) || 
		if((parseFloat(DistArray.split(",")[_j]) < 2500))
		{
	        var defDT = DTArray.split(",")[_j];
	        defDT = defDT.split(" ")[1].split(".")[0] + " " + defDT.split(" ")[0].split("-")[2] + "-" + defDT.split(" ")[0].split("-")[1] + "-" + defDT.split(" ")[0].split("-")[0];
	        point = new OpenLayers.Geometry.Point(_lon[_j], _lat[_j]);
	    		point.transform(
	            new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
	            Maps[0].getProjectionObject() // to Spherical Mercator Projection
	        );
	        //styles.push({ 'strokeWidth': debelina, 'strokeColor': '#0000FF', 'strokeOpacity': opac });
	        points.push(point);
	        
	        if(numA == 3)
	        {
	        	if(parseInt(DistArray.split(",")[_j], 10) > 300)
	        		num2 = 1;
	        	drawDirection(0, _lon[_j], _lat[_j], vhID, VehReg, defDT, alphaArray.split(",")[_j], num2);
	        	num2--;
				if(num2 == 0)
					num2 = podatok[Maps[0].getZoom()]; //Math.abs(19 - Maps[0].getZoom()) + Math.abs(18 - Maps[0].getZoom()) + Math.abs(18 - Maps[0].getZoom()) + Math.abs(18 - Maps[0].getZoom());
	        	numA = 0;
	        } else
        	{
	        	numA++;
	        }
	        if(alarmsArray.split(",")[_j] != "")
	        {
	        	var size = new OpenLayers.Size(25, 23);
			    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2), -(size.h / 2)); };
		        var icon = new OpenLayers.Icon(twopoint + '/images/alarm1.png', size, null, calculateOffset);
			    if (Maps[0] != null) {
			        var ll = new OpenLayers.LonLat(parseFloat(_lon[_j]), parseFloat(_lat[_j])).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject())
			        //if (MapType[0] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
			        var MyMar = new OpenLayers.Marker(ll, icon);
			        var markers = Markers[0];
			        markers.addMarker(MyMar);
			        MyMar.events.element.style.zIndex = 999
			        tmpMarkersRec[tmpMarkersRec.length] = MyMar;
			        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.innerHTML = '<div class="gnPOI" style="background-color: ' + _color + '"; display:box; font-size:4px"></div>';
			        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.style.cursor = 'pointer';
			        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong >Аларм: " + dic(alarmsArray.split(",")[_j], lang) + "<br/ >" + defDT + "</strong>')");
			        $(tmpMarkersRec[tmpMarkersRec.length - 1].events.element).mouseout(function () { HidePopup() });
			        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.addEventListener('click', function (e) { OpenMapAlarm2(DTArray.split(",")[_j], VehReg, alarmsArray.split(",")[_j], $vh, '1'); });
			        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onclick", "OpenMapAlarm2('" + DTArray.split(",")[_j] + "', '" + VehReg + "', '" + alarmsArray.split(",")[_j] + "', " + $vh + ", '1')");
		       }
	        }
	        //debugger;
	        if(parkingArray.split(",")[_j] != "" && idlingArray.split(",")[_j] != "")
	        {
	        	if(parkingArray.split(",")[_j].split("|")[0].indexOf(".") == -1)
	        		var parkingDT1 = parkingArray.split(",")[_j].split("|")[0] + ".001";
        		else
        			var parkingDT1 = parkingArray.split(",")[_j].split("|")[0];
        		if(parkingArray.split(",")[_j].split("|")[1].indexOf(".") == -1)
        			var parkingDT2 = parkingArray.split(",")[_j].split("|")[1] + ".001"; //.substring(0,parkingArray.split(",")[_j].split("|")[1].indexOf(".")))
    			else
    				var parkingDT2 = parkingArray.split(",")[_j].split("|")[1];
				if(DTArrayDiff.split(",")[_j].indexOf(".") == -1)
        			var parkingDT3 = DTArrayDiff.split(",")[_j] + ".001"; //.substring(0,parkingArray.split(",")[_j].split("|")[1].indexOf(".")))
    			else
    				var parkingDT3 = DTArrayDiff.split(",")[_j];
	        	CreateMarkerIgnition_RecNew(_lon[_j], _lat[_j], parkingDT1.substring(0,parkingDT1.indexOf(".")), parkingDT2.substring(0,parkingDT2.indexOf(".")), parkingDT3.substring(0,parkingDT3.indexOf(".")));
	        } else
        	{
	        	if(idlingArray.split(",")[_j] != "")
		        {
		        	var defDTDiff = DTArrayDiff.split(",")[_j];
		        	defDTDiff = defDTDiff.split(" ")[1].split(".")[0] + " " + defDTDiff.split(" ")[0].split("-")[2] + "-" + defDTDiff.split(" ")[0].split("-")[1] + "-" + defDTDiff.split(" ")[0].split("-")[0];
		        	var size = new OpenLayers.Size(48, 48);
				    var calculateOffset = function (size) { return new OpenLayers.Pixel(-(size.w / 2) - 1, -size.h + 3 ); };
			        var icon = new OpenLayers.Icon(twopoint + '/images/idle1.png', size, null, calculateOffset);
				    if (Maps[0] != null) {
				        var ll = new OpenLayers.LonLat(parseFloat(_lon[_j]), parseFloat(_lat[_j])).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject())
				        //if (MapType[0] == 'YAHOOM') { var ll = new OpenLayers.LonLat(parseFloat(_lonn), parseFloat(_latt)) }
				        var MyMar = new OpenLayers.Marker(ll, icon);
				        var markers = Markers[0];
				        markers.addMarker(MyMar);
				        MyMar.events.element.style.zIndex = 999
				        tmpMarkersRec[tmpMarkersRec.length] = MyMar;
				        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.innerHTML = '<div class="gnPOI" style="background-color: ' + _color + '"; display:box; font-size:4px"></div>';
				        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.style.cursor = 'pointer';
				        tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onmousemove", "ShowPopup(event, '<strong style=\"font-size: 12px;\">" + dic("STOS", lang) + ": " + defDT + "<br />" + dic("ETOS", lang) + ": " + defDTDiff + "<br />" + dic("TTOS", lang) + " со вклучен мотор: " + Sec2Str(idlingArray.split(",")[_j]) + "</strong>')");
				        $(tmpMarkersRec[tmpMarkersRec.length - 1].events.element).mouseout(function () { HidePopup() });
				        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.addEventListener('click', function (e) { OpenMapAlarm2(DTArray.split(",")[_j], VehReg, alarmsArray.split(",")[_j], $vh, '1'); });
				        //tmpMarkersRec[tmpMarkersRec.length - 1].events.element.setAttribute("onclick", "OpenMapAlarm2('" + DTArray.split(",")[_j] + "', '" + VehReg + "', '" + alarmsArray.split(",")[_j] + "', " + $vh + ", '1')");
			       }
		        }
		        if(parkingArray.split(",")[_j] != "")
		        {
		        	if(parkingArray.split(",")[_j].split("|")[0].indexOf(".") == -1)
		        		var parkingDT1 = parkingArray.split(",")[_j].split("|")[0] + ".001";
	        		else
	        			var parkingDT1 = parkingArray.split(",")[_j].split("|")[0];
	        		if(parkingArray.split(",")[_j].split("|")[1].indexOf(".") == -1)
	        			var parkingDT2 = parkingArray.split(",")[_j].split("|")[1] + ".001"; //.substring(0,parkingArray.split(",")[_j].split("|")[1].indexOf(".")))
        			else
        				var parkingDT2 = parkingArray.split(",")[_j].split("|")[1];
		        	CreateMarkerIgnition_Rec(_lon[_j], _lat[_j], parkingDT1.substring(0,parkingDT1.indexOf(".")), parkingDT2.substring(0,parkingDT2.indexOf(".")));
		        }
	        }
		} else
		{
      		var lineString1 = new OpenLayers.Geometry.LineString(points);
      		var lineString2 = new OpenLayers.Geometry.LineString(points);
    		var lineFeature2 = new OpenLayers.Feature.Vector(lineString2, null, styles);
    		var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, stylesShadow);
    		
    		//ArrLineFeature += lineFeature1;
    		vectors[0].addFeatures([lineFeature1]);
    		vectors[0].addFeatures([lineFeature2]);
    		var points = new Array();
    		//DrawPath_RecTMP(21.111231, 44.255282, 21.055183, 44.428877);
    		//DrawPath_RecTMP(_lon[_j], _lat[_j], _lon[_j+1], _lat[_j+1]);
		}
		if(_j == (_lon.length-1))
		{
			var lineString1 = new OpenLayers.Geometry.LineString(points);
      		var lineString2 = new OpenLayers.Geometry.LineString(points);
    		var lineFeature2 = new OpenLayers.Feature.Vector(lineString2, null, styles);
    		var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, stylesShadow);
    		
    		//ArrLineFeature += lineFeature1;
    		vectors[0].addFeatures([lineFeature1]);
    		vectors[0].addFeatures([lineFeature2]);
		}
    }
    ArrLineFeature = vectors[0].features;
    /*for (var i = 1; i < points.length - 2; i++) {
        var lineString1 = new OpenLayers.Geometry.LineString([points[i], points[i + 1]]);
        var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, styles[i]);
        vectors[0].addFeatures([lineFeature1]);

    var lineString1 = new OpenLayers.Geometry.LineString(points);
    var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, styles)
	
    vectors[0].addFeatures([lineFeature1]);*/
	//vectors[0].setZIndex( 23 );
    //ArrLineFeature = lineFeature1;
    return
}
</script>