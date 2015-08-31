function ParseCarStr_rec1(_vid) {
    if(CarStr == "")
        return false;
	var c1 = _pts[_pts.length-1].split("|");
	IndexRec = _pts.length-1;
	var status = c1[8];
	for(var i=0; i < VehcileIDs.length; i++)
	{
		if(VehcileIDs[i] == parseInt(_vid, 10))
		{
			carnum = i;
			break;
		}
	}
	var _car = new CarType_recNew(c1[0], c1[3], c1[1], c1[2], c1[6], _vid, status);
	Car[carnum] = _car;
}

function AddLayerPlayNewRec(el, num) {

    if (parseInt(el.offsetWidth, 10) < 550)
        var _w = parseInt(el.offsetWidth, 10) - 50;
    else
        if (ShowGFBtn)
            var _w = 755;
        else
            var _w = 655;
    
	var _th = $('#div-layer-icons-' + num).height();
    var _top = 25 + _th;
	
    var layerSwitcherF = Create($(el).children()[0], 'div', 'div-layer-playsF-' + num);
    $(layerSwitcherF).css({ display: 'none', position: 'absolute', zIndex: '7000', backgroundColor: 'transparent', color: '#fff', left: '37px', top: _top+'px', width: _w + 'px', height: 'auto', textAlign: 'left' });
    layerSwitcherF.className = 'corner15 text3';

	var layerSwitcher007 = Create(layerSwitcherF, 'div', 'div-layer-plays007-' + num);
    $(layerSwitcher007).css({ display: 'block', position: 'absolute', borderRadius: '15px 15px 15px 15px',  zIndex: '7000', backgroundColor: '#387cb0', color: '#fff', left: '19px', top: '0px', width: '63px', padding: '2px 5px', height: '15px', textAlign: 'left' });
    layerSwitcher007.className = 'text3';
	layerSwitcher007.innerHTML = '<div id="PlayBackNew" onclick="PlayBackNewRec()" style="font-size: 14px; float: left; top: -1px; left: -4px; position: relative; cursor: pointer; background-color: #; border-radius: 15px 0px 0px 15px; color: #FFFFFF; height: 17px; width: 17px; padding-left: 5px;">◀</div>';
	layerSwitcher007.innerHTML += '<div id="PauseNew" onclick="PauseClickNewRec()" style="font-size: 14px; float: left; top: -1px; left: -3px; position: relative; cursor: pointer; background-color: #; color: #FFFFFF; height: 17px; width: 14px; padding-left: 9px; padding-right: 2px;">||</div>';
	layerSwitcher007.innerHTML += '<div id="PlayForwardNew" onclick="PlayForwardNewRec()" style="font-size: 14px; float: right; top: -18px; left: 4px; position: relative; cursor: pointer; background-color: #FFFFFF; border-radius: 0 15px 15px 0; color: #387CB0; height: 17px; width: 9px; padding-left: 6px; padding-right: 7px;">▶</div>';

	var layerSwitcher = Create(layerSwitcherF, 'div', 'div-layer-plays-' + num);
    $(layerSwitcher).css({ display: 'block', position: 'absolute', borderRadius: '15px 15px 15px 15px',  zIndex: '7000', backgroundColor: '#387cb0', color: '#fff', left: '105px', top: '5px', width: '150px', height: '7px', textAlign: 'left' });
    layerSwitcher.className = 'text3';
	
	$(layerSwitcher).slider({
		value:600,
		min: 200,
		max: 1000,
		step: 1,
		animate: true,
		slide: function( event, ui ) {
			SpeedRec = 1000 - Math.abs(parseInt(ui.value, 10));
			$(ui.handle).blur();
		},
		change: function( event, ui ) { $(ui.handle).blur(); }
		}
	);
	//$(layerSwitcher)[0].children[0].innerHTML = '<div style="font-size: 12px; position: relative; top: -3px;">▶ <font style="position: relative; top: 1px;">x200</font></div>';
	$($(layerSwitcher)[0].children[0]).css({ cursor: 'pointer', opacity: '1', top: '-4px', border: '1px solid #387cb0' });
	$($(layerSwitcher)[0].children[0]).mousemove(function () { $(this).css({ border: '1px solid White' }) });
	$($(layerSwitcher)[0].children[0]).mouseout(function () { $(this).css({ border: '1px solid #387cb0' }) });
    /*PlayBack(layerSwitcher, num, '<strong>x3</strong> ◀', '200', dic("back", lang) + ' x3');
    PlayBack(layerSwitcher, num, '<strong>x2</strong> ◀', '500', dic("back", lang) + ' x2');
    PlayBack(layerSwitcher, num, '◀', '1000', dic("back", lang));
    Pause(layerSwitcher, num);
    Play(layerSwitcher, num, '▶', '1000', dic("forward", lang));
    Play(layerSwitcher, num, '▶ <strong>x2</strong>', '500', dic("forward", lang) + ' x2');
    Play(layerSwitcher, num, '▶ <strong>x3</strong>', '200', dic("forward", lang) + ' x3');*/
	
}
function PlayForwardNewRec(){
	if (!PlayForwardRec || PlayBackRec) {
		$('#PlayForwardNew').css({ backgroundColor: '#FFFFFF', color: '#387cb0' });
		$('#PlayBackNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
		$('#PauseNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
        PlayForwardRec = true;
        PlayBackRec = false;
        
        RecStartNew(IndexRec);
        //moveCharPlay();
    }
}
function PlayBackNewRec(){
	if (!PlayBackRec || PlayForwardRec) {
		$('#PlayBackNew').css({ backgroundColor: '#FFFFFF', color: '#387cb0' });
		$('#PauseNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
		$('#PlayForwardNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
        PlayBackRec = true;
        PlayForwardRec = false;
        RecBackNew(IndexRec - 1);
        //moveCharBack();
    }
}
function PauseClickNewRec()
{
	$('#PauseNew').css({ backgroundColor: '#FFFFFF', color: '#387cb0' });
	$('#PlayBackNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
	$('#PlayForwardNew').css({ backgroundColor: '#387cb0', color: '#FFFFFF' });
	PlayForwardRec = false;
    PlayBackRec = false;
    window.clearTimeout(TIMEOUTREC);
    //moveCharPause();
}

function ParseCarStr_b(_pc) {
    if(CarStr == "")
        return false;
	
	var c1 = _pts[_pc].split("|");
	
	var p = c1;
	
	var status = c1[8];
	var _car = new CarType_recNew(c1[0], c1[3], c1[1], c1[2], c1[6], VehcileIDs[carnum]);
	
	_car.passive = p[9];
	_car.datum = p[4];
	_car.location = p[10];
	
	_car.speed = parseInt(p[5], 10) + ' Km/h';
	if(metric == "mi")
		_car.speed = parseInt(p[5], 10) + ' mph';

	_car.taxi=p[19];
	_car.sedista=p[20];
	_car.address = p[11];
	
	_car.gis = p[12];

	_car.fulldt = p[17];
	_car.cbfuel = p[13];
	_car.cbrpm = p[14];
	_car.cbtemp = p[15];
	_car.cbdistance = p[15];
	
	_car.status = status;
	
	_car.olddate = p[18];
	_car.ignition = p[7];
	if(_pc == (_pts.length-1) && _car.ignition == "1" && _car.olddate == "0")
	{
		var currdt = new Date();
		currdt = currdt.getFullYear() + "-" + ((currdt.getMonth() + 1) < 10 ? "0" + (currdt.getMonth() + 1) : (currdt.getMonth() + 1)) + "-" + (currdt.getDate() < 10 ? "0" + currdt.getDate() : currdt.getDate()) + " " + (currdt.getHours() < 10 ? "0" + currdt.getHours() : currdt.getHours()) + ":" + (currdt.getMinutes() < 10 ? "0" + currdt.getMinutes() : currdt.getMinutes()) + ":" + (currdt.getSeconds() < 10 ? "0" + currdt.getSeconds() : currdt.getSeconds());
		if(dateDiff123(currdt, c1[4]) > 290)
		{
			_car.olddate = "1";
			_car.color = "GrayLC";
		}
	}
	Car[carnum] = _car;
}
function CarType_recNew(_id, _color, _lon, _lat, _reg, _vehid){
    this.id = _id
    this.color = _color;
    this.lon = _lon
    this.lat = _lat
    this.reg = _reg
    this.vehid = _vehid;
    this.map0 = true;
    this.map1 = true
    this.map2 = true
    this.map3 = true
    this.passive = '0'
    this.datum = '&nbsp;'
    this.location = '&nbsp;'
    this.address = '&nbsp;'
    this.same = false
    this.speed = '0 Km/h'
    if(metric == "mi")
    	this.speed = '0 mph'
    this.taxi = '0'
    this.sedista = '0'
    this.olddate = '0'
    this.gis = ''
    this.alarm = '';
    this.fulldt = '&nbsp;';
    this.cbfuel = '0';
	this.cbrpm = '0';
	this.cbtemp = '0';
	this.cbdistance = '0';
	this.temperature = '0';
	this.litres = '0';
	this.zoneids = '';
	this.odometar = '0';
	this.service = '';
	this.status = '';
	this.olddate = '';
	this.ignition = '';
	this.rpm = '';
}

function changebaloon123(_pc){
	if(ShowHideTrajectory) {
	ParseCarStr_b(_pc);
	
	j=carnum;
	if(Car[j].status == '0')
	{
		$('#img-small-' + Car[j].id).remove();
		$('#vh-small-' + Car[j].id).append('<img id="img-small-' + Car[j].id + '" style="height: 13px; width: 13px; top: -3px; position: relative; left: 6px;" src="../images/nosignal.png">');
	} else
	{
		$('#img-small-' + Car[j].id).remove();
		if(Car[j].ignition == '1' && Car[j].olddate == '1')
			$('#vh-small-' + Car[j].id).append('<img id="img-small-' + Car[j].id + '" style="height: 13px; width: 13px; top: -3px; position: relative; left: 6px;" src="../images/nocommunication.png">');
	}
	
		//$('#vh-date-' + Car[j].id).html(Car[j].fulldt);
		$('#vh-date-' + Car[j].id).html(formatdate13_(Car[j].datum, dateformatU_) + " " + formattime13_(Car[j].datum, timeformatU_));
	if (Car[j].olddate == '1') { $('#vh-date-' + Car[j].id).css("color", "#FF0000") } else { $('#vh-date-' + Car[j].id).css("color", "009933") }
	
	document.getElementById('vh-small-' + Car[j].id).className = 'gnMarkerList' + Car[j].color + ' text3'
	if (Car[j].same == false) { getAddress(Car[j].lon, Car[j].lat, 'vh-location-' + Car[j].id) }
	
	if (parseInt(Car[j].cbfuel, 10) == 0 && parseInt(Car[j].cbrpm, 10) == 0 && (parseInt(Car[j].cbtemp, 10) == 0 || parseInt(Car[j].cbtemp, 10) == -40) && parseInt(Car[j].cbdistance, 10) == 0)
		$('#vh-canbus-' + Car[j].id).css({ display: "none" });
	else
	{
		$('#vh-canbus-' + Car[j].id).css({ display: "block" });
	    if (parseInt(Car[j].cbfuel, 10) == 0)
	        $('#vh-cbfuel1-' + Car[j].id).css({ display: "none" });
	    else
			{
				$('#vh-cbfuel1-' + Car[j].id).css({ display: "block" });
				$('#vh-cbfuel-' + Car[j].id).html(Math.round(100*parseInt(Car[j].cbfuel, 10)/100) + ' L');
			}
	
	    if (parseInt(Car[j].cbrpm, 10) == 0)
	        $('#vh-cbrpm1-' + Car[j].id).css({ display: "none" });
	    else
			{
				$('#vh-cbrpm1-' + Car[j].id).css({ display: "block" });
				$('#vh-cbrpm-' + Car[j].id).html(Math.round(Car[j].cbrpm) + ' rpm');
			}
	    if (parseInt(Car[j].cbtemp, 10) == 0)
	        $('#vh-cbtemp1-' + Car[j].id).css({ display: "none" });
	    else
			{
				$('#vh-cbtemp1-' + Car[j].id).css({ display: "block" });
				$('#vh-cbtemp-' + Car[j].id).html(Math.round(Car[j].cbtemp) + ' °C');
			}
			
		if (parseInt(Car[j].cbdistance, 10) == 0)
	        $('#vh-cbdistance1-' + Car[j].id).css({ display: "none" });
	    else
			{
				$('#vh-cbdistance1-' + Car[j].id).css({ display: "block" });
				var mmetric = ' Km';
				var kilom = Math.round(parseInt(Car[j].cbdistance, 10)/1000);
				if(metric == 'mi')
				{
					mmetric = ' miles';
					kilom = Math.round(Math.round(parseInt(Car[j].cbdistance, 10)/1000) * 0.621371);
				}
				if(Car[j].service != "")
				{
					if(parseInt(Car[j].service, 10) < 300)
						var _service = ' (<font style="color: Red;">'+commaSeparateNumber(Car[j].service)+' '+mmetric+'</font>)';
					else
						var _service = " ("+commaSeparateNumber(Car[j].service)+" "+mmetric+")";
				} else
				{
					var _service = "";
				}
				$('#vh-cbdistance-' + Car[j].id).html(commaSeparateNumber(kilom) + mmetric + _service);
				if(_service != "")
				{
					$('#vh-cbdistance-' + Car[j].id).mousemove(function (event) {
						if(parseInt($('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")).replace(".", ""), 10) < 300)
							var nexserv = '<font style="color: Red;">' + $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")) + '</font>';
						else
							var nexserv = $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")"));
	                    ShowPopup(event, 'Изминати километри: <b>' + $('#'+this.id).html().substring(0, $('#'+this.id).html().indexOf("(")-1) + '</b><br/>Преостануваат <b>' + nexserv + '</b> до следен сервис!');
	                });
				} else
				{
					$('#vh-cbdistance-' + Car[j].id).mousemove(function (event) {
	                    ShowPopup(event, 'Изминати километри: <b>' + $('#'+this.id).html() + '</b>');
	                });
				}
	            $('#vh-cbdistance-' + Car[j].id).mouseout(function () { HidePopup() });
			}
	}
	
	//if (Car[j].location == "")
	    //$('#vh-pp-pic-' + Car[j].id).css({ display: "none" });
	//else
	$('#vh-pp-pic-' + Car[j].id).css({ display: "block" });
	
	$('#vh-pp-' + Car[j].id).html(Car[j].location.replace(/;/g,";</br>"));
	$('#vh-pp-pic-' + Car[j].id).mousemove(function (event) {
	    ShowPopup(event, '<img src=\''+twopoint + '/images/poiButton.png\' style=\'position: relative; float: left; top: 2px; \' /><div style=\'position: relative; float: left; margin-left: 7px; padding-right: 3px;\'>' + dic('Poi', lang) + ':<br /><strong style="font-size: 14px;">' + $('#vh-pp-' + this.id.substring(this.id.lastIndexOf("-") + 1, this.id.length)).html() + '</strong></div>');
	});
	$('#vh-pp-pic-' + Car[j].id).mouseout(function () { HidePopup() });
	
	//if (Car[j].address == "")
	    //$('#vh-address-pic-' + Car[j].id).css({ display: "none" });
	//else
	$('#vh-address-pic-' + Car[j].id).css({ display: "block" });
	Car[j].address = Car[j].address.replace(";", "<br>");
	$('#vh-address-' + Car[j].id).html(Car[j].address);
	$('#vh-address-pic-' + Car[j].id).mousemove(function (event) {
	    ShowPopup(event, '<img src=\''+twopoint + '/images/areaImg.png\' style=\'position: relative; float: left; top: 2px; \' /><div style=\'position: relative; float: left; margin-left: 7px; padding-right: 3px;\'>' + dic('GFVeh', lang) + '<br /><strong style="font-size: 14px;">' + $('#vh-address-' + this.id.substring(this.id.lastIndexOf("-") + 1, this.id.length)).html() + '</strong></div>');
	});
	$('#vh-address-pic-' + Car[j].id).mouseout(function () { HidePopup() });
	//if (Car[j].gis == "")
	    //$('#vh-location-pic-' + Car[j].id).css({ display: "none" });
	//else
	$('#vh-location-pic-' + Car[j].id).css({ display: "block" });
	$('#vh-location-' + Car[j].id).html(Car[j].gis);
	$('#vh-location-pic-' + Car[j].id).mousemove(function (event) {
	    ShowPopup(event, '<img src=\''+twopoint + '/images/shome.png\' style=\'position: relative; float: left; top: 2px; \' /><div style=\'position: relative; float: left; margin-left: 7px; padding-right: 3px;\'>' + dic('Street', lang) + '<br /><strong style="font-size: 14px;">' + $('#vh-location-' + this.id.substring(this.id.lastIndexOf("-") + 1, this.id.length)).html() + '</strong></div>');
	});
	$('#vh-location-pic-' + Car[j].id).mouseout(function () { HidePopup() });
	//var tmpsp = Car[j].speed
	//if(metric == 'mi')
		//tmpsp = Math.round(parseFloat(tmpsp) * 0.621371 * 100)/100 + ' miles';
		
	$('#vh-temp-' + Car[j].id).html(Math.round(Car[j].temperature * 100)/100 + ' °C');
	$('#vh-litres-' + Car[j].id).html(Math.round(Car[j].litres * 100)/100 + ' L');
	var mmetric = ' Km';
	if(metric == 'mi')
		mmetric = ' miles';
	/*
	if (parseInt(Car[j].cbfuel, 10) == 0 && parseInt(Car[j].cbrpm, 10) == 0 && (parseInt(Car[j].cbtemp, 10) == 0 || parseInt(Car[j].cbtemp, 10) == -40) && parseInt(Car[j].cbdistance, 10) == 0)
	{
		$('#vh-up-odometar-' + Car[j].id).css({ display: "block" });
		if(Car[j].odometar == "0")
		{
			$('#vh-odometar-' + Car[j].id).html('/');
		} else
		{
			if(Car[j].service != "")
			{
				if(parseInt(Car[j].service, 10) < 300)
					var _service = ' (<font style="color: Red;">'+commaSeparateNumber(Car[j].service)+' '+mmetric+'</font>)';
				else
					var _service = " ("+commaSeparateNumber(Car[j].service)+" "+mmetric+")";
			} else
			{
				var _service = "";
			}
			var currkm = commaSeparateNumber(Car[j].odometar) + mmetric;
			$('#vh-odometar-' + Car[j].id).html(currkm + _service);
	
			if(_service != "")
			{
				$('#vh-odometar-' + Car[j].id).mousemove(function (event) {
					if(parseInt($('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")).replace(".", ""), 10) < 300)
						var nexserv = '<font style="color: Red;">' + $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")) + '</font>';
					else
						var nexserv = $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")"));
	                ShowPopup(event, 'Изминати километри: <b>' + $('#'+this.id).html().substring(0, $('#'+this.id).html().indexOf("(")-1) + '</b><br/>Преостануваат <b>' + nexserv + '</b> до следен сервис!');
	            });
			} else
			{
				$('#vh-odometar-' + Car[j].id).mousemove(function (event) {
	                ShowPopup(event, 'Изминати километри: <b>' + $('#'+this.id).html() + '</b>');
	            });
			}
	        $('#vh-odometar-' + Car[j].id).mouseout(function () { HidePopup() });
		}
	} else
	{
		if (parseInt(Car[j].cbdistance, 10) == 0)
		{
			$('#vh-up-odometar-' + Car[j].id).css({ display: "block" });
			if(Car[j].odometar == "0")
			{
				$('#vh-odometar-' + Car[j].id).html('/');
			} else
			{
				if(Car[j].service != "")
				{
					if(parseInt(Car[j].service, 10) < 300)
						var _service = ' (<font style="color: Red;">'+commaSeparateNumber(Car[j].service)+' '+mmetric+'</font>)';
					else
						var _service = " ("+commaSeparateNumber(Car[j].service)+" "+mmetric+")";
				} else
				{
					var _service = "";
				}
				var currkm = commaSeparateNumber(Car[j].odometar) + mmetric;
				$('#vh-odometar-' + Car[j].id).html(currkm + _service);
				
				if(_service != "")
				{
					$('#vh-odometar-' + Car[j].id).mousemove(function (event) {
						if(parseInt($('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")).replace(".", ""), 10) < 300)
							var nexserv = '<font style="color: Red;">' + $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")")) + '</font>';
						else
							var nexserv = $('#'+this.id).html().substring($('#'+this.id).html().indexOf("(")+1, $('#'+this.id).html().indexOf(")"));
	                    ShowPopup(event, 'Изминати километри: <b>' + $('#'+this.id).html().substring(0, $('#'+this.id).html().indexOf("(")-1) + '</b><br/>Преостануваат <b>' + nexserv + '</b> до следен сервис!');
	                });
				} else
				{
					$('#vh-odometar-' + Car[j].id).mousemove(function (event) {
	                    ShowPopup(event, 'Изминати километри: <b>' + $('#'+this.id).html() + '</b>');
	                });
				}
	            $('#vh-odometar-' + Car[j].id).mouseout(function () { HidePopup() });
			}
		} else
		{
			$('#vh-up-odometar-' + Car[j].id).css({ display: "none" });
		}
	}*/
	
	
	$('#vh-speed-' + Car[j].id).html(Car[j].speed);
	//if (Car[j].location == '') { $('#vh-pp-' + Car[j].id).css("borderTop", '0px') } else { $('#vh-pp-' + Car[j].id).css("borderTop", '1px dotted #333') }

	$('#vh-sedista-' + Car[j].id).html(parseInt(Car[j].sedista, 10));
	if (Car[j].taxi == '1') { $('#div-taxi-' + Car[j].id).css('color', '#009933') } else { $('#div-taxi-' + Car[j].id).css('color', '#FF0000') }
	$('#vh-rpm-' + Car[j].id).html(Car[j].rpm);
	}
}
var popapvorekonstrukija;
function RecStartNew(i) {
    if (!PlayForwardRec) return false;
    IndexRec = i;
    if(i == _pts.length)
    {
    	PauseClickNewRec();
    	return false;
    }
    if (_pts != "") {
        
        _PointCount = parseInt(i, 10);

        IndexRec = _PointCount;
        
		moveChartNew(IndexRec);

		var CarMove = _pts[_PointCount].split("|");
		
		var status = CarMove[8];
		
		changebaloon123(_PointCount);
		
		if(Car[carnum].ignition == "1" && Car[carnum].olddate == "1")
			var nocomm = true;
		else
			var nocomm = false;
		
		MoveMarker(CarMove[0], parseFloat(CarMove[1]), parseFloat(CarMove[2]), Car[carnum].color, Car[carnum].map0, Car[carnum].map1, Car[carnum].map2, Car[carnum].map3,  CarMove[4], status, CarMove[5], nocomm);
		
        if (PlayForwardRec)
            TIMEOUTREC = setTimeout("RecStartNew(" + (_PointCount + 1) + ");", SpeedRec);
        if (Vehicles[carnum].Marker != undefined)
            if (!Vehicles[carnum].Marker.onScreen())
                Maps[0].setCenter(Vehicles[carnum].Marker.lonlat, Maps[0].zoom);
    } else {
        setTimeout("RecStartNew(" + i + ");", SpeedRec);
    }
}

function RecBackNew(i) {
    if (!PlayBackRec) return false;
    IndexRec = i;
    if (_pts != "") {
        _PointCount = parseInt(i, 10);
        if (_PointCount < 0) _PointCount = 0
        
        IndexRec = _PointCount;
        
		moveChartBack(IndexRec);

		var CarMove = _pts[_PointCount].split("|");
		
		var status = CarMove[8];

		changebaloon123(_PointCount);
		
		if(Car[carnum].ignition == "1" && Car[carnum].olddate == "1")
			var nocomm = true;
		else
			var nocomm = false;
		
		MoveMarkerBack(CarMove[0], parseFloat(CarMove[1]), parseFloat(CarMove[2]), Car[carnum].color, Car[carnum].map0, Car[carnum].map1, Car[carnum].map2, Car[carnum].map3,  CarMove[4], status, CarMove[5], nocomm);

		
        if (PlayBackRec && i > 0)
            TIMEOUTREC = setTimeout("RecBackNew(" + (_PointCount - 1) + ");", SpeedRec);
        if (Vehicles[carnum].Marker != undefined)
            if (!Vehicles[carnum].Marker.onScreen())
                Maps[0].setCenter(Vehicles[carnum].Marker.lonlat, Maps[0].zoom);
        
    } else {
        setTimeout("RecBackNew(" + i + ");", SpeedRec);
    }
}

function generateRect1(_start, _end)
{
	$('#raphaelIgn').html('');
	dt = datenew.split(",");
	var tempEnd = datet.split(",")[datet.split(",").length-2].split(".")[0];
	var tempStart = datet.split(",")[0].split(".")[0];
	if(tempEnd.split(".")[0] == _end.split(".")[0] && tempStart.split(".")[0] == _start.split(".")[0])
	{
		var startTime = getSeconds(_start.split(" ")[1]);
        var endTime = getSeconds(_end.split(" ")[1]);
        if(_end.split(" ")[0] > _start.split(" ")[0])
        	endTime = endTime + 86399;
        var x = startTime;
        var proc = 100 / (endTime-startTime);
        if(Browser() == "Safari")
        {
        	$("#raphaelIgn").html('<tr></tr>');
        }
        for (var i = 1; i < dt.length; i++) {
			var sec = getSeconds(dt[i].split(" ")[1].split(":")[0] +":"+ dt[i].split(" ")[1].split(":")[1] +":"+ dt[i].split(" ")[1].split(":")[2].split(".")[0]);
			if(_end.split(" ")[0] == dt[i].split(" ")[0] && _end.split(" ")[0] > _start.split(" ")[0])
				sec = sec + 86399;
			var w = (sec-x) * proc;
			
				//var clr = "#89A54E";
				var clr = "#1aa815";
				if (ignitionNew.split(",")[i] == "1")
					var clr = "#db2f24";
				if(Browser() == "Safari")
        		{
					var _td = '<td width="'+((w*$('#raphaelIgn')[0].clientWidth)/100)+'px" height="'+$('#raphaelIgn')[0].clientHeight+'px" style="background-color:'+clr+';"></td>';
					$("#raphaelIgn tr").html($("#raphaelIgn tr").html()+_td);
				} else
				{
					var _div = '<div style="display:block; width: '+w+'%; background-color:'+clr+'; height: 100%; float: left"></div>';
					$('#raphaelIgn').html($('#raphaelIgn').html() + _div);
				}
				x = sec;
			
		}
		if(x < endTime)
		{
			var w = (endTime-x) * proc;
			var clr = "#1aa815";
			if (ignitionNew.split(",")[i-1] == "0")
				var clr = "#db2f24";
				//var clr = "#9E312E";
			if(Browser() == "Safari")
    		{
				var _td = '<td width="'+((w*$('#raphaelIgn')[0].clientWidth)/100)+'px" height="'+$('#raphaelIgn')[0].clientHeight+'px" style="background-color:'+clr+';"></td>';
				$("#raphaelIgn tr").html($("#raphaelIgn tr").html()+_td);
			} else
			{
				var _div = '<div style="display:block; width: '+w+'%; background-color:'+clr+'; height: 100%; float: left"></div>';
				$('#raphaelIgn').html($('#raphaelIgn').html() + _div);
			}
		}
	} else
	{
		//if(tempEnd.split(".")[0] >= _end)
			//_end = dt[dt.length-1];
		var startTime = getSeconds(_start.split(" ")[1]);
        var endTime = getSeconds(_end.split(" ")[1]);
        if(_end.split(" ")[0] > _start.split(" ")[0])
        	endTime = endTime + 86399;
		var _s = 1;
		var _e = dt.length-1;
		var startBool = true;
		if(Browser() == "Safari")
        {
        	$("#raphaelIgn").html('<tr></tr>');
        }
		for (var i = 1; i < dt.length; i++) {
			var dtsec = getSeconds(dt[i].split(" ")[1]);
			if(_end.split(" ")[0] == dt[i].split(" ")[0] && _end.split(" ")[0] > _start.split(" ")[0])
				dtsec = dtsec + 86399;	
			if(startTime < dtsec && startBool)
			{
				_s = i;
				startBool = false;
			}
			if(dtsec > endTime)
			{
				_e = i-1;
				break;
			}
		}
        
        var x = startTime;
        var proc = 100 / (endTime-startTime);
        if(!startBool)
        {
			for (var i = _s; i <= _e; i++) {
				
				var sec = getSeconds(dt[i].split(" ")[1].split(":")[0] +":"+ dt[i].split(" ")[1].split(":")[1] +":"+ dt[i].split(" ")[1].split(":")[2].split(".")[0]);
				if(_end.split(" ")[0] == dt[i].split(" ")[0] && _end.split(" ")[0] > _start.split(" ")[0])
					sec = sec + 86399;
				var w = (sec-x) * proc;
				
				//var clr = "#89A54E";
				var clr = "#1aa815";
				if (ignitionNew.split(",")[i] == "1")
					var clr = "#db2f24";
				if(Browser() == "Safari")
        		{
					var _td = '<td width="'+((w*$('#raphaelIgn')[0].clientWidth)/100)+'px" height="'+$('#raphaelIgn')[0].clientHeight+'px" style="background-color:'+clr+';"></td>';
					$("#raphaelIgn tr").html($("#raphaelIgn tr").html()+_td);
				} else
				{
					var _div = '<div style="display:block; width: '+w+'%; background-color:'+clr+'; height: 100%; float: left"></div>';
					$('#raphaelIgn').html($('#raphaelIgn').html() + _div);
				}
				
				x = sec;
			}
		}
		if(x < endTime)
		{
			var w = (endTime-x) * proc;
			var clr = "#1aa815";
			if (ignitionNew.split(",")[i-1] == "0")
				var clr = "#db2f24";
				//var clr = "#9E312E";
			if(Browser() == "Safari")
    		{
				var _td = '<td width="'+((w*$('#raphaelIgn')[0].clientWidth)/100)+'px" height="'+$('#raphaelIgn')[0].clientHeight+'px" style="background-color:'+clr+';"></td>';
				$("#raphaelIgn tr").html($("#raphaelIgn tr").html()+_td);
			} else
			{
				var _div = '<div style="display:block; width: '+w+'%; background-color:'+clr+'; height: 100%; float: left"></div>';
				$('#raphaelIgn').html($('#raphaelIgn').html() + _div);
			}
		} 
	}
}
function generateChartData1()
{
    var dt = [];
    dt[0] = _pts[0].split("|")[4];
    //var firstDate = new Date(dt[0].split(" ")[0].split("-")[0], parseInt(dt[0].split(" ")[0].split("-")[1], 10)-1, dt[0].split(" ")[0].split("-")[2], dt[0].split(" ")[1].split(":")[0], dt[0].split(" ")[1].split(":")[1], dt[0].split(" ")[1].split(":")[2].split(".")[0]);
    for (var i = 0; i < _pts.length; i++) {
    	var newDateN;
    	var newDateNN;
    	dt[i] = _pts[i].split("|")[4];
    	var newDate = new Date(dt[i].split(" ")[0].split("-")[0], parseInt(dt[i].split(" ")[0].split("-")[1], 10)-1, dt[i].split(" ")[0].split("-")[2], dt[i].split(" ")[1].split(":")[0], dt[i].split(" ")[1].split(":")[1], dt[i].split(" ")[1].split(":")[2].split(".")[0]);
		if(i > 0)
		{
			if(parseInt(_pts[i].split("|")[5], 10) > 7 && parseInt(_pts[i-1].split("|")[5], 10) <= 7)
			{
				var _speed = 0;
			}
			else
				var _speed = parseInt(_pts[i].split("|")[5], 10);
		}
		
		putInChartData(newDate, "Speed", _speed);
	}
}

function putInChartData(dt, vehid, value)
{
	var obj = {};
	obj["date"] = dt;
	obj[vehid]= value;
	if(parseInt(value, 10) > parseInt(maxSpeedRec1, 10))
	{
		//obj["maxSpeed"] = "Максимална брзина: " + (Math.round(value * 100) / 100) + " " + metricUnit;
		//obj["customBullet"] = "./images/redstar.png";
		maxSpeedRec = dt;
		maxSpeedRec1 = value;
	}
	
	chartData.push(obj);
}
function putInChartData1(_i, dt, vehid1, vehid2, value1, value2)
{
	var obj = {};
	obj["date"] = dt;
	obj[vehid1]= value1;
	
	if(parseInt(_pts[_i].split("|")[7], 10) == 1)
		obj[vehid2]= value2;

	//obj["value"]= 50;
	if(parseInt(value1, 10) > parseInt(maxSpeedRec1, 10))
	{
		//obj["maxSpeed"] = "Максимална брзина: " + (Math.round(value1 * 100) / 100) + " " + metricUnit;
		//obj["customBullet"] = "./images/redstar.png";
		maxSpeedRec = dt;
		maxSpeedRec1 = value1;
	}
	chartData.push(obj);
}
var metricUnit = "Km/h";
if(metric == "mi")
	metricUnit = "mph";
var chart;

function createSerialChart()
{
	//$('#tabs').css({top: (document.body.clientHeight - 290) + 'px'});
	// SERIAL CHART    
    chart = new AmCharts.AmSerialChart();
    chart.pathToImages = "../amcharts/images/";
    chart.zoomOutButton = {
        backgroundColor: '#ff0000',
        backgroundAlpha: 0.15
    };
    chart.zoomOutText = dic("Chart.Entirely",lang);
    chart.dataProvider = chartData;
    chart.categoryField = "date";

    // listen for "dataUpdated" event (fired when chart is inited) and call zoomChart method when it happens
    //chart.addListener("dataUpdated", zoomChart);

    // AXES
    // category                
    var categoryAxis = chart.categoryAxis;
    categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
    //categoryAxis.minPeriod = "ss"; // our data is daily, so we set minPeriod to DD
    if (timeformatU_ != "H:i:s") categoryAxis.dateFormats = [{period:'ss',format:'K:NN:SS A'},{period:'mm',format:'K:NN A'},{period:'hh',format:'K:NN A'},{period:'DD',format:'MMM DD'},{period:'WW',format:'MMM DD'},{period:'MM',format:'MMM'},{period:'YYYY',format:'YYYY'}];
    categoryAxis.minPeriod = "ss"; // our data is daily, so we set minPeriod to DD
    categoryAxis.dashLength = 2;
    categoryAxis.gridAlpha = 0.15;
    categoryAxis.axisColor = "#DADADA";

    // first value axis (on the left)
    var valueAxis1 = new AmCharts.ValueAxis();
    valueAxis1.axisThickness = 2;
    valueAxis1.gridAlpha = 0.1;
    //valueAxis1.gridColor = "#FF6600";
    chart.addValueAxis(valueAxis1);
	valueAxis1.addListener('axisChanged',
        function (event) {
        	$('#raphaelIgn').css({left: (chart.div.offsetLeft + chart.chartCursor.x) + 'px'});
   			$('#raphaelIgn').css({width: chart.graphs[0].width + 'px'});
   			
   			if(Browser() != "Chrome" && Browser() != "Safari")
				chart.chartCursor.set.node.children[0].attributes[3].value = "3";
			else
				chart.chartCursor.set.node.childNodes[0].attributes[3].value = "3";
        });
	
	// second value axis (on the right) 
    var valueAxis2 = new AmCharts.ValueAxis();
    valueAxis2.position = "right"; // this line makes the axis to appear on the right
    valueAxis2.axisColor = "#FCD202";
    valueAxis2.gridAlpha = 0.1;
    //valueAxis2.gridColor = "#FCD202";
    valueAxis2.axisThickness = 2;
    chart.addValueAxis(valueAxis2);
	valueAxis2.addListener('axisChanged',
        function (event) {
        	$('#raphaelIgn').css({left: (chart.div.offsetLeft + chart.chartCursor.x) + 'px'});
   			$('#raphaelIgn').css({width: chart.graphs[0].width + 'px'});
   			
   			if(Browser() != "Chrome" && Browser() != "Safari")
				chart.chartCursor.set.node.children[0].attributes[3].value = "3";
			else
				chart.chartCursor.set.node.childNodes[0].attributes[3].value = "3";
        });

	// GUIDES are vertical (can also be horizontal) lines (or areas) marking some event.
    // first guide
    var guide1 = new AmCharts.Guide();
    guide1.date = maxSpeedRec;
    guide1.lineColor = "#CC0000";
    guide1.lineAlpha = 1;
    guide1.lineThickness = 2;
    guide1.dashLength = 3;
    guide1.inside = true;
    guide1.labelRotation = 90;
    guide1.label = (Math.round(maxSpeedRec1 * 100) / 100) + " " + speedunit;
    guide1.balloonText = dic("Settings.MaxSpeed", lang);
    categoryAxis.addGuide(guide1);
	
    // GRAPHS
    // first graph
    var graph1 = new AmCharts.AmGraph();
    graph1.valueAxis = valueAxis1; // we have to indicate which value axis should be used
    graph1.type = "smoothedLine"; // this line makes the graph smoothed line.
    graph1.lineColor = "#387CB0";
    graph1.bullet = "round";
    graph1.bulletSize = 7;
    graph1.lineThickness = 2;
    graph1.title = dic("Reports.Speed",lang);
    graph1.valueField = "Speed";
    graph1.balloonText = "[[value]] " +  speedunit;
    graph1.legendValueText = "[[value]] " + speedunit;
    //graph1.customBullet = "images/star.gif"; // bullet for all data points
    //graph1.bulletSize = 14; // bullet image should be a rectangle (width = height)
    //graph1.customBulletField = "customBullet"; // this will make the graph to display custom bullet (red star)
    //graph1.labelText = "[[maxSpeed]]"; // not all data points has townName2 specified, that's why labels are displayed only near some of the bullets.
    //graph1.customBulletField = "customBullet"; 
    graph1.hideBulletsCount = 130;
    chart.addGraph(graph1);

	
    // CURSOR
    var chartCursor = new AmCharts.ChartCursor();
    chartCursor.cursorPosition = "start";
    //chartCursor.categoryBalloonDateFormat = "JJ:NN:SS";
    if (timeformatU_ != "H:i:s") chartCursor.categoryBalloonDateFormat = "K:NN:SS A";
    else chartCursor.categoryBalloonDateFormat = "JJ:NN:SS";
    chart.addChartCursor(chartCursor);
	
	
	
	chart.chartCursor.addListener("changed", function(event){
		if(event.index != undefined)
			goToPointIdxNew(event.index);
	});
	chart.chartCursor.addListener("onHideCursor", function(event){
		if(_PointCount != undefined && _PointCount != 0 && _PointCount != 1)
		{
			_i = _PointCount;
			moveChartFromHide(_i);			
    		goToPointIdxNew(_i);
    	}
	});
	
    // SCROLLBAR
    var chartScrollbar = new AmCharts.ChartScrollbar();
    chartScrollbar.graph = graph1;
    chartScrollbar.scrollbarHeight = 30;
    chartScrollbar.autoGridCount = true;
    chartScrollbar.color = "#000000";
    //chartScrollbar.gridColor = "#00FFFF";
    chart.addChartScrollbar(chartScrollbar);

    // LEGEND
    var legend = new AmCharts.AmLegend();
    legend.marginLeft = 110;
    legend.markerType = "circle";
    chart.addLegend(legend);
	
	// WRITE
    
    chart.addListener('zoomed',
        function (event) {
        	var datetimeStr1 = event.startDate;
		   	var datetimeStr2 = event.endDate;
		   	var start = padStr(datetimeStr1.getFullYear()) + "-" +
                  padStr(1 + datetimeStr1.getMonth()) + "-" +
                  padStr(datetimeStr1.getDate()) + " " +
                  padStr(datetimeStr1.getHours()) + ":" +
                  padStr(datetimeStr1.getMinutes()) + ":" +
                  padStr(datetimeStr1.getSeconds());
		   	var end = padStr(datetimeStr2.getFullYear()) + "-" +
                  padStr(1 + datetimeStr2.getMonth()) + "-" +
                  padStr(datetimeStr2.getDate()) + " " +
                  padStr(datetimeStr2.getHours()) + ":" +
                  padStr(datetimeStr2.getMinutes()) + ":" +
                  padStr(datetimeStr2.getSeconds());
		   	//alert(start + "  " + end)
		   	generateRect1(start, end);
        });

		/*if(Browser() != "Chrome" && Browser() != "Safari")
			chart.chartCursor.set.node.children[0].attributes[3].value = "3";
		else
			chart.chartCursor.set.node.childNodes[0].attributes[3].value = "3";*/
    //$("[id=balloons]")[0].nextSibling.nextSibling.style.display = 'none';
	//$("[id=balloons]")[1].nextSibling.nextSibling.style.display = 'none';
	
	//$('#chartdiv111').click(function(event) {
    	//goToPointNew(event);
    //});

	chart.write("chartdiv");

	if(Browser() != "Chrome" && Browser() != "Safari")
		chart.chartCursor.set.node.children[0].attributes[3].value = "3";
	else
		chart.chartCursor.set.node.childNodes[0].attributes[3].value = "3";

    moveChartNew(IndexRec);
    goToPointIdxNew(IndexRec);
    
    var datetimeStr1 = chart.startDate;
   	var datetimeStr2 = chart.endDate;
   	var start = padStr(datetimeStr1.getFullYear()) + "-" +
          padStr(1 + datetimeStr1.getMonth()) + "-" +
          padStr(datetimeStr1.getDate()) + " " +
          padStr(datetimeStr1.getHours()) + ":" +
          padStr(datetimeStr1.getMinutes()) + ":" +
          padStr(datetimeStr1.getSeconds());
   	var end = padStr(datetimeStr2.getFullYear()) + "-" +
          padStr(1 + datetimeStr2.getMonth()) + "-" +
          padStr(datetimeStr2.getDate()) + " " +
          padStr(datetimeStr2.getHours()) + ":" +
          padStr(datetimeStr2.getMinutes()) + ":" +
          padStr(datetimeStr2.getSeconds());
   	//alert(start + "  " + end)
   	$('#raphaelIgn').css({left: (chart.div.offsetLeft + chart.chartCursor.x) + 'px'});
   	$('#raphaelIgn').css({width: chart.graphs[0].width + 'px'});
   	generateRect1(start, end);
   	HideWait();
	window.onresize = resizeChart();
}
function resizeChart()
{
	var chartDiv = document.getElementById("chartdiv");
	//chartDiv.style.height=document.documentElement.clientHeight+"px";
	
	//$('#raphaelIgn').css({left: (chart.div.offsetLeft + chart.chartCursor.x) + 'px'});
	//$('#raphaelIgn').css({width: chart.graphs[0].width + 'px'});
	
}
window.onresize = resizeChart;
function padStr(i) {
    return (i < 10) ? "0" + i : "" + i;
}
// this method is called when chart is first inited as we listen for "dataUpdated" event
function zoomChart() {
    // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
    chart.zoomToIndexes(10, 20);
}

function goToPointIdxNew(_i)
{
	if(_i != undefined)
	{
		//chart.chartCursor.showCursorAt(new Date(_pts[_i].split("|")[4].split(" ")[0].split("-")[0], parseInt(_pts[_i].split("|")[4].split(" ")[0].split("-")[1],10)-1, parseInt(_pts[_i].split("|")[4].split(" ")[0].split("-")[2],10), parseInt(_pts[_i].split("|")[4].split(" ")[1].split(":")[0], 10), parseInt(_pts[_i].split("|")[4].split(" ")[1].split(":")[1], 10), parseInt(_pts[_i].split("|")[4].split(" ")[1].split(":")[2], 10)));
		if(_pts[_i].split("|")[7] == "1")
		{
			if(Browser() != "Chrome" && Browser() != "Safari")
			{
				chart.chartCursor.set.node.children[0].attributes[5].value = "#008000";
				if(chart.chartCursor.categoryBalloon.set != null)
				{
					chart.chartCursor.categoryBalloon.set.node.children[0].attributes[7].value = '#008000';
				}
			} else
			{
				chart.chartCursor.set.node.childNodes[0].attributes[5].value = "#008000";
				if(chart.chartCursor.categoryBalloon.set != null)
				{
					chart.chartCursor.categoryBalloon.set.node.childNodes[0].attributes[7].value = '#008000';
				}
			}
		} else
		{
			if(Browser() != "Chrome" && Browser() != "Safari")
			{
				chart.chartCursor.set.node.children[0].attributes[5].value = '#CC0000'
				if(chart.chartCursor.categoryBalloon.set != null)
				{
					chart.chartCursor.categoryBalloon.set.node.children[0].attributes[7].value = '#CC0000';
				}
			} else
			{
				chart.chartCursor.set.node.childNodes[0].attributes[5].value = '#CC0000'
				if(chart.chartCursor.categoryBalloon.set != null)
				{
					chart.chartCursor.categoryBalloon.set.node.childNodes[0].attributes[7].value = '#CC0000';
				}
			}
		}
		_PointCount = _i;
		PauseClickNewRec();
		IndexRec = _PointCount;
		var _id = Car[carnum].id;
		var CarMove = _pts[_PointCount].split("|");
		
		var status = CarMove[8];
		
		changebaloon123(_PointCount);
		
		if(Car[carnum].ignition == "1" && Car[carnum].olddate == "1")
			var nocomm = true;
		else
			var nocomm = false;

		MoveMarker(CarMove[0], parseFloat(CarMove[1]), parseFloat(CarMove[2]), Car[carnum].color, Car[carnum].map0, Car[carnum].map1, Car[carnum].map2, Car[carnum].map3, CarMove[4], status, CarMove[5], nocomm);
	}
}

function moveChartBack(_i)
{
	chart.chartCursor.showCursorAt(new Date(_pts[_i].split("|")[4].split(" ")[0].split("-")[0], parseInt(_pts[_i].split("|")[4].split(" ")[0].split("-")[1],10)-1, parseInt(_pts[_i].split("|")[4].split(" ")[0].split("-")[2],10), parseInt(_pts[_i].split("|")[4].split(" ")[1].split(":")[0], 10), parseInt(_pts[_i].split("|")[4].split(" ")[1].split(":")[1], 10), parseInt(_pts[_i].split("|")[4].split(" ")[1].split(":")[2], 10)));
	/*if(chart.chartCursor.categoryBalloon.set == null)
	{
		_i++;
		_PointCount = _i;
		IndexRec = _i;
		chart.chartCursor.showCursorAt(new Date(_pts[_i].split("|")[4].split(" ")[0].split("-")[0], parseInt(_pts[_i].split("|")[4].split(" ")[0].split("-")[1],10)-1, parseInt(_pts[_i].split("|")[4].split(" ")[0].split("-")[2],10), parseInt(_pts[_i].split("|")[4].split(" ")[1].split(":")[0], 10), parseInt(_pts[_i].split("|")[4].split(" ")[1].split(":")[1], 10), parseInt(_pts[_i].split("|")[4].split(" ")[1].split(":")[2], 10)));
	}*/
	if(_pts[_i].split("|")[7] == "1")
	{
		if(Browser() != "Chrome" && Browser() != "Safari")
		{
			chart.chartCursor.set.node.children[0].attributes[5].value = "#008000";
			if(chart.chartCursor.categoryBalloon.set != null)
			{
				chart.chartCursor.categoryBalloon.set.node.children[0].attributes[7].value = '#008000';
			}
		} else
		{
			chart.chartCursor.set.node.childNodes[0].attributes[5].value = "#008000";
			if(chart.chartCursor.categoryBalloon.set != null)
			{
				chart.chartCursor.categoryBalloon.set.node.childNodes[0].attributes[7].value = '#008000';
			}
		}
	} else
	{
		if(Browser() != "Chrome" && Browser() != "Safari")
		{
			chart.chartCursor.set.node.children[0].attributes[5].value = '#CC0000'
			if(chart.chartCursor.categoryBalloon.set != null)
			{
				chart.chartCursor.categoryBalloon.set.node.children[0].attributes[7].value = '#CC0000';
			}
		} else
		{
			chart.chartCursor.set.node.childNodes[0].attributes[5].value = '#CC0000'
			if(chart.chartCursor.categoryBalloon.set != null)
			{
				chart.chartCursor.categoryBalloon.set.node.childNodes[0].attributes[7].value = '#CC0000';
			}
		}
	}
}
function moveChartFromHide(_i)
{
	if(String(chart.chartCursor.previousMousePosition) != "NaN")
		chart.chartCursor.showCursorAt(new Date(_pts[_i].split("|")[4].split(" ")[0].split("-")[0], parseInt(_pts[_i].split("|")[4].split(" ")[0].split("-")[1],10)-1, parseInt(_pts[_i].split("|")[4].split(" ")[0].split("-")[2],10), parseInt(_pts[_i].split("|")[4].split(" ")[1].split(":")[0], 10), parseInt(_pts[_i].split("|")[4].split(" ")[1].split(":")[1], 10), parseInt(_pts[_i].split("|")[4].split(" ")[1].split(":")[2], 10)));
	else
		IndexRec = 1;
	if(_pts[_i].split("|")[7] == "1")
	{
		if(Browser() != "Chrome" && Browser() != "Safari")
		{
			chart.chartCursor.set.node.children[0].attributes[5].value = "#008000";
			if(chart.chartCursor.categoryBalloon.set != null)
			{
				chart.chartCursor.categoryBalloon.set.node.children[0].attributes[7].value = '#008000';
			}
		} else
		{
			chart.chartCursor.set.node.childNodes[0].attributes[5].value = "#008000";
			if(chart.chartCursor.categoryBalloon.set != null)
			{
				chart.chartCursor.categoryBalloon.set.node.childNodes[0].attributes[7].value = '#008000';
			}
		}
	} else
	{
		if(Browser() != "Chrome" && Browser() != "Safari")
		{
			chart.chartCursor.set.node.children[0].attributes[5].value = '#CC0000'
			if(chart.chartCursor.categoryBalloon.set != null)
			{
				chart.chartCursor.categoryBalloon.set.node.children[0].attributes[7].value = '#CC0000';
			}
		} else
		{
			chart.chartCursor.set.node.childNodes[0].attributes[5].value = '#CC0000'
			if(chart.chartCursor.categoryBalloon.set != null)
			{
				chart.chartCursor.categoryBalloon.set.node.childNodes[0].attributes[7].value = '#CC0000';
			}
		}
	}
}
function moveChartNew(_i)
{
	if(parseInt(_i, 10) > 1)
		if(_pts[_i-1].split("|")[4].split(".")[0] == _pts[_i].split("|")[4].split(".")[0])
			return false;
	
	chart.chartCursor.showCursorAt(new Date(_pts[_i].split("|")[4].split(" ")[0].split("-")[0], parseInt(_pts[_i].split("|")[4].split(" ")[0].split("-")[1],10)-1, parseInt(_pts[_i].split("|")[4].split(" ")[0].split("-")[2],10), parseInt(_pts[_i].split("|")[4].split(" ")[1].split(":")[0], 10), parseInt(_pts[_i].split("|")[4].split(" ")[1].split(":")[1], 10), parseInt(_pts[_i].split("|")[4].split(" ")[1].split(":")[2], 10)));
	if(chart.chartCursor.categoryBalloon.set == null)
	{
		_i++;
		_PointCount = _i;
		IndexRec = _i;
		//moveChartNew(_i);
		PlayForwardNewRec();
	}
	if(_pts[_i].split("|")[7] == "1")
	{
		if(Browser() != "Chrome" && Browser() != "Safari")
		{
			chart.chartCursor.set.node.children[0].attributes[5].value = "#008000";
			if(chart.chartCursor.categoryBalloon.set != null)
			{
				chart.chartCursor.categoryBalloon.set.node.children[0].attributes[7].value = '#008000';
			}
		} else
		{
			chart.chartCursor.set.node.childNodes[0].attributes[5].value = "#008000";
			if(chart.chartCursor.categoryBalloon.set != null)
			{
				chart.chartCursor.categoryBalloon.set.node.childNodes[0].attributes[7].value = '#008000';
			}
		}
	} else
	{
		if(Browser() != "Chrome" && Browser() != "Safari")
		{
			chart.chartCursor.set.node.children[0].attributes[5].value = '#CC0000'
			if(chart.chartCursor.categoryBalloon.set != null)
			{
				chart.chartCursor.categoryBalloon.set.node.children[0].attributes[7].value = '#CC0000';
			}
		} else
		{
			chart.chartCursor.set.node.childNodes[0].attributes[5].value = '#CC0000'
			if(chart.chartCursor.categoryBalloon.set != null)
			{
				chart.chartCursor.categoryBalloon.set.node.childNodes[0].attributes[7].value = '#CC0000';
			}
		}
	}
}

function generatePathValues ()
{
	var strLon = strItems.split("@")[3].substring(0,strItems.split("@")[3].length-1);
	var strLat = strItems.split("@")[4].substring(0,strItems.split("@")[4].length-1);
	
	var strDist = strItems.split("@")[1].substring(0,strItems.split("@")[1].length-1);
	var strDTArray = datet;
	var strAlpha = strItems.split("@")[2].substring(0,strItems.split("@")[2].length-1);
	
	DrawPath_24h(strLon, strLat, strDist, strDTArray, strAlpha, Car[carnum].id, Car[carnum].reg);
}
var ArrLineFeature24h;
function DrawPath_24h(LonArray, LatArray, DistArray, DTArray, alphaArray, vhID, VehReg) {
    //if (ShowHideTrajectory == false) { return }
    var _lon = LonArray.split(",")
    var _lat = LatArray.split(",")

    var points = new Array();
    var styles = {'strokeWidth': '4', 'strokeColor': '#2AAEDE', 'strokeOpacity': '0.9', 'VehID': dic("Number", lang) + ' ' + vhID + '<br />' + VehReg };
	var stylesShadow = {'strokeWidth': '6', 'strokeColor': '#000000', 'strokeOpacity': '0.5' };
    if (MapType[0] == 'YAHOOM') {
		Maps[0].setCenter(new OpenLayers.LonLat(_lon[0], _lat[0]).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject()), DefMapZoom);
    } else {
        Maps[0].setCenter(new OpenLayers.LonLat(_lon[0], _lat[0]).transform(new OpenLayers.Projection("EPSG:4326"), Maps[0].getProjectionObject()), DefMapZoom);
    }

    var cir = _lon.length / 3
    var cir1 = cir + cir
    var cir2 = _lon.length

    var debelina = 6
    var opac = 0.7

    var numA = 0;
	var num2 = podatok[Maps[0].getZoom()];
	for (var _j = 0; _j < _lon.length; _j++) {
		if((parseFloat(DistArray.split(",")[_j]) < 2500))
		{
	        var defDT = DTArray.split(",")[_j];
	        defDT = formattime13_(defDT.split(".")[0], timeformatU_) + " " + formatdate13_(defDT.split(".")[0], dateformatU_);//defDT.split(" ")[1].split(".")[0] + " " + defDT.split(" ")[0].split("-")[2] + "-" + defDT.split(" ")[0].split("-")[1] + "-" + defDT.split(" ")[0].split("-")[0];
	      
	        //var defDT = DTArray.split(",")[_j];
	        //defDT = defDT.split(" ")[1].split(".")[0] + " " + defDT.split(" ")[0].split("-")[2] + "-" + defDT.split(" ")[0].split("-")[1] + "-" + defDT.split(" ")[0].split("-")[0];
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
					num2 = podatok[Maps[0].getZoom()];
	        	numA = 0;
	        } else
        	{
	        	numA++;
	        }
		} else
		{
      		var lineString1 = new OpenLayers.Geometry.LineString(points);
      		var lineString2 = new OpenLayers.Geometry.LineString(points);
    		var lineFeature2 = new OpenLayers.Feature.Vector(lineString2, null, styles);
    		var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, stylesShadow);
    		
    		vectors[0].addFeatures([lineFeature1]);
    		vectors[0].addFeatures([lineFeature2]);
    		var points = new Array();
		}
		if(_j == (_lon.length-1))
		{
			var lineString1 = new OpenLayers.Geometry.LineString(points);
      		var lineString2 = new OpenLayers.Geometry.LineString(points);
    		var lineFeature2 = new OpenLayers.Feature.Vector(lineString2, null, styles);
    		var lineFeature1 = new OpenLayers.Feature.Vector(lineString1, null, stylesShadow);
    		
    		vectors[0].addFeatures([lineFeature1]);
    		vectors[0].addFeatures([lineFeature2]);
		}
    }

    ArrLineFeature24h = vectors[0].features;
    return
}

function loadrecinlive(_vid, _mins)
{
	if($('#trajectory24h').css('display') == 'none' && _vid != "")
	{
		ShowWait();
		$('#div-layer-playsF-0').css({display: 'block'})
		$('#trajectory24h').css({display: 'block'})
		
		var url = './reconstructionOneVeh24h.php?v=' + _vid + '&mins=' + _mins;
		$('#trajectory24h').load(url, function(){
			if(!existdatainlive)
			{
				HideWait();
				$('#div-layer-playsF-0').css({display: 'none'})
				$('#trajectory24h').css({display: 'none'})
				$('#trajectory24h').html('');
			}
		})
	} else {
		$('#div-layer-playsF-0').css({display: 'none'})
		$('#trajectory24h').css({display: 'none'})
		$('#trajectory24h').html('');
	}
}
function kescape(_tekst){
	_tekst = escape(_tekst).replace(/\+/g, '%plus%');
	return _tekst;
}
