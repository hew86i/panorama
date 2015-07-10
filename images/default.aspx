<%@ Page Language="VB" ContentType="text/html" ResponseEncoding="utf-8" CodeFile="../Default.aspx.vb" Inherits="_Default"%>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Panorama GPS</title>
	<link rel="stylesheet" type="text/css" href="styleGM.css">
	<link rel="stylesheet" type="text/css" href="styleOSM.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.8.14.custom.css">	
    <link rel="stylesheet" href="mlColorPicker.css" type="text/css" media="screen" charset="utf-8" />
	<LINK REL="SHORTCUT ICON" HREF="../images/icon.ico">

	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
	
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="./live.js"></script>
	<script type="text/javascript" src="./live1.js"></script>

    <script type="text/javascript" src="./mlColorPicker.js"></script>
	
	<script type="text/javascript" src="../js/OpenLayers.js"></script>

</head>
<%
	if IsNumeric(cstr(nnull(session("user_id")))) = false then response.Redirect("../sessionexpired/?l=" & cLang)

	dim Allow as boolean = getPriv("LiveTracking", session("user_id"))
	if allow = false then response.redirect("../?l=" & cLang & "&err=permission")


	dim sqlV as string = ""
	if session("Role_id") = "2" then 
		sqlV = "select id from draft.dbo.vehicles where clientID=" & session("client_id") 
	else
		sqlV = "select vehicleID from draft.dbo.UserVehicles where userID=" & session("user_id") & "" 
	end if
	dim strVhList as string = ""
	dim strVhListID as string = ""
	
	dim dsVehicles as new data.dataset
	dsVehicles = loaddataset("select * from Vehicles where id in (" & sqlV & ") order by numberofvehicle")
	dim dsCP as new data.dataset
	'dsCP = loaddataset("select v.numberofvehicle, v.registration, cp.* from vehicles v left outer join geonet.dbo.currentposition cp on cp.alarmid=v.id where v.id in (" & sqlV & ")  order by 1")
	for each dr in dsVehicles.tables(0).rows
		strVhList &= ", '(<strong>" & dr("numberofvehicle") & "</strong>)&nbsp;&nbsp;" & trim(dr("registration")) & "'"
		strVhListID &= ", " & dr("numberofvehicle")
	next
	strVhList = mid(strVhList,3)
	strVhListID = mid(strVhListID,3)
	
	dim dsStartLL as new data.dataset
	dsStartLL = loaddataset("select * from cities where id = (select top 1 CityID from clients where id=" & session("client_id") & ")")
	dim sLon as string= "21.432767"
	dim sLat as string = "41.996434"
	if dsStartLL.tables(0).rows.count>0 then
		sLon = replace(cstr(dsStartLL.tables(0).rows(0).item("longitude")),",",".")
		sLat = replace(cstr(dsStartLL.tables(0).rows(0).item("latitude")),",",".")
		
	end if
	
	dim CPosition = GetCurrentPosition(session("Role_id"), session("client_id"), session("user_id"))
	dim ClientTypeID = dlookup("select ClientTypeID from Clients where id=" & session("client_id"))
	dim allPOI as integer = dlookup("select count(*) from pinpoints where clientID=" & session("client_id"))
	dim allPOIs as string = "false"
	if allPOI<1000 then allPOIs = "true" 
	
	dim DefMap = nnull(dlookup("select DefMap from UserSettings where UserID=" & session("user_id")),1).ToString()
	if DefMap = "1" then defMap = "GOOGLE"
	if DefMap = "2" then defMap = "OSM"
	if DefMap = "3" then defMap = "BING"
	if DefMap = "4" then defMap = "YAHOO"
	if DefMap = "5" then defMap = "GOOGLES"
	
	dim dsAllMaps = new data.dataset()
	dsAllMaps = loaddataset("select AMapsGoogle, AMapsOMS, AMapsBing, AMapsYahoo, Satellite from usersettings where userID=" & session("user_id"))
	dim AllowedMaps = ""
	if dsAllMaps.tables(0).rows.count>0 then
			if nnull(dsAllMaps.tables(0).rows(0).item(0),true) = true then AllowedMaps &= "1" else AllowedMaps &= "0"
            If NNull(dsAllMaps.tables(0).rows(0).item(1), True) = True Then AllowedMaps &= "1" Else AllowedMaps &= "0"
            if nnull(dsAllMaps.tables(0).rows(0).item(2), False) = true then 
                AllowedMaps &= "1"
                %><script src="http://ecn.dev.virtualearth.net/mapcontrol/mapcontrol.ashx?v=6.2&amp;mkt=en-us"></script><%
            Else
                AllowedMaps &= "0"
            End If
            If NNull(dsAllMaps.tables(0).rows(0).item(3), False) = True Then
                AllowedMaps &= "1"
                %><script src="http://api.maps.yahoo.com/ajaxymap?v=3.0&appid=euzuro-openlayers"></script><%
            Else
                AllowedMaps &= "0"
            End If
        
        
                                                                                                                   'if nnull(dsAllMaps.tables(0).rows(0).item(2),true) = true then AllowedMaps &= "1" else AllowedMaps &= "0"
                                                                                                                   'if nnull(dsAllMaps.tables(0).rows(0).item(3),true) = true then AllowedMaps &= "1" else AllowedMaps &= "0"
			if nnull(dsAllMaps.tables(0).rows(0).item(4),"1") = "1" then AllowedMaps &= "1" else AllowedMaps &= "0"
			  
	else
		AllowedMaps = "11111"
	end if


	dim AllowAddPoi = getPriv("AddPOI", session("user_id"))
	dim AllowViewPoi = getPriv("ViewPOI", session("user_id"))
	dim AllowAddZone = getPriv("AddZones", session("user_id"))
	dim AllowViewZone = getPriv("ViewZones", session("user_id"))
	
	
	dim cntz = dlookup("select count(*) from ClientAreas where ClientID=" & session("client_id"))
%>
<script>
	AllowAddPoi = '<%=lcase(AllowAddPoi.toString())%>'
	AllowViewPoi = '<%=lcase(AllowViewPoi.toString())%>'
	AllowAddZone = '<%=lcase(AllowAddZone.toString())%>'
	AllowViewZone = '<%=lcase(AllowViewZone.toString())%>'

</script>
<body onResize="setLiveHeight()">



<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td  width="50%" height="32px" style="background-image:url(../images/traka.png); border-bottom:1px solid #999">
			&nbsp;<img src="../images/tiniLogo.png" border="0" align="absmiddle" />&nbsp;
			&nbsp;<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;
			<a id="icon-home" href="../?l=<%=cLang%>"><img src="../images/shome.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-rep"  href="../report/?l=<%=cLang%>#rep/menu_1_1" ><img src="../images/sdocument.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-live" href=""><img src="../images/sMap.png" border="0" align="absmiddle" style="opacity:0.4" /></a>&nbsp;			
			<a id="icon-sett" href="../settings/?l=<%=cLang%>"><img src="../images/ssettings.png" border="0" align="absmiddle" /></a>&nbsp;
			<a id="icon-help" href="../texts/help.aspx?l=<%=cLang%>"><img src="../images/shelp.png" border="0" align="absmiddle" /></a>&nbsp;
			&nbsp;<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;
			
            <a id="activeBoard" href="javascript:"></a>&nbsp;
			<a id="a-AddPOI" href="javascript:"></a>&nbsp;
			<a id="icon-poi" href="javascript:"></a>
            <a id="icon-poi-down" href="javascript:"></a>&nbsp;
			<a id="icon-draw-zone" href="javascript:"></a>
            <a id="icon-zone-down" href="javascript:"></a>&nbsp;
			<a id="icon-draw-path" href="javascript:"></a>
            <a id="icon-draw-path-down" href="javascript:"></a>&nbsp;
            
			<a id="a-split" href="javascript:"></a>&nbsp;
			
		</td>
		<td width="50%" height="32px" style="background-image:url(../images/traka.png); border-bottom:1px solid #999" align="right" class="text2" valign="middle">
			<a id="icon-leg" href="javascript:"><img src="../images/legenda.png" border="0" align="absmiddle" /></a>&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			Company: <strong><%=session("company")%></strong>&nbsp;&nbsp;&nbsp;<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			User: <strong><%=session("user_fullname")%></strong>&nbsp;&nbsp;&nbsp;&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;
			<a id="span-time" style="cursor:help">22:55:36&nbsp;</a>&nbsp;
			<img src="../images/sep.png" border="0" align="absmiddle" />&nbsp;&nbsp;			
			<a id="icon-logout" href="../logout/?l=<%=cLang%>"><img src="../images/exit.png" border="0" align="absmiddle" /></a>&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
</table>
<%--<div id="ShowList" class="menu-title-slide text6" onclick="ShowHideLeftMenu1()" style="display: none; cursor: pointer;">▶</div>--%>
<table id="live-table" width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td id="vehicle-list" width="250px" valign="top">
			<div id="div-menu" style="width:100%; overflow-y:auto; overflow-x:hidden">
				<%--<a id="menu-title-0" href="#" onclick="ShowHideLeftMenu1()" class="menu-title text3">◀</a>--%>
				
				<%if ClientTypeID=2 then%>
				<div id="menu-1" class="menu-container" style="width:100%">
					<a id="menu-title-1" href="#" class="menu-title text3" onClick="OnMenuClick(1)" style="width:100%">Engaged</a>
                    <%--<div id="quickbuttons" class="menu-container-qb" style="font-size: 5px;">
                        <input type="checkbox" id="QBcheck1" checked /><label for="QBcheck1">1</label>
                    </div>--%>
					<div id="menu-container-1" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px; overflow:auto">
					<div>
						<%
							for each dr in dsVehicles.tables(0).rows
						%>
							<li id="div-pass-<%=dr("numberofvehicle")%>" onClick="ChangePassiveStatus(<%=dr("numberofvehicle")%>)" onMouseOver="ShowPopup(event, 'Click to change engaged status of vehicle <%=dr("numberofvehicle")%>')" onMouseOut="HidePopup()" style="float:left; display:inherit; padding-top:2px; height:16px; margin-left:5px; margin-top:5px; cursor:pointer; opacity:0.3" class="gnMarkerListOrange text3"><strong><%=dr("numberofvehicle")%></strong></li>
						<%
							next
						%>	
						</div><br><br>&nbsp;
					</div>
				</div>
				<%end if%>
				<div id="menu-3" class="menu-container" style="width:100%">
					<a id="menu-title-3" href="#" class="menu-title text3" onClick="OnMenuClick(3)" style="width:100%">Quick view</a>
					<div id="menu-container-3" style="width:230px; padding-left:10px; padding-bottom:10px; padding-top:10px; overflow:auto">
						<div>
						<%
							for each dr in dsVehicles.tables(0).rows
						%>
							<li id="div-sv-<%=dr("numberofvehicle")%>" onClick="FindVehicleOnMap0(<%=dr("numberofvehicle")%>)" onMouseOver="ShowPopup(event, 'Click to find vehicle number <%=dr("numberofvehicle")%>')" onMouseOut="HidePopup()" style="float:left; display:inherit; padding-top:2px; height:16px; margin-left:5px; margin-top:5px; cursor:pointer" class="gnMarkerListRed text3"><strong><%=dr("numberofvehicle")%></strong></li>
						<%
							next
						%>	
						</div>
						<br><br>&nbsp;
					</div>
				</div>	
					
			</div>
            <div id="race-img" style="position:absolute; left: 250px; width:8px; height:50px; background-image:url(../images/racelive.png); background-position: -8px 0px; z-index: 1000000; cursor:pointer" onClick="shleft()"></div>
		</td>
		<td id="maps-container" valign="top" style="border-left: 2px Solid #387cb0">
			<div id="div-map">
					
					
			</div>
			
		</td>
	</tr>
</table>
<div id="dialog-message" title="Message...">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px"></div>
	</p>
</div>
<div id="dialog-draw-area" title="Drawing areas" style="display:none">
	<iframe src="" id="ifrm-edit-areas" scrolling="no" frameborder="0" style="border:0px dotted #387cb0"> </iframe>
</div>

<div id="div-Add-Group" title="Add Group">
	<span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;">Name of Group</span><input id="GroupName" type="text" class="textboxCalender corner5" style="width:220px" /><br><br>
    <span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;">Color</span>
    <div id="colorPicker2">
		<span id="colorPicker1" style="cursor: pointer; float:left; border:1px solid black; width:20px; height:20px;margin:5px;"></span>
		<input id="clickAny" type="text" class="textboxCalender corner5" onchange="changecolor()" value="" style="width:120px" />
	</div>
    <br><br>
	<div align="right" style="display:block; width:330px">
        <img id="loading1" style="display: none; width: 150px; position: absolute; left: 32px; margin-top: 7px;" src="../Images/loading_bar1.gif" alt="" />
		<input type="button" class="BlackText corner5" id="btnCancelGroup" value="Cancel" onclick="$('#div-Add-Group').dialog('destroy');" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnAddGroup" value="Add" onclick="ButtonAddGroupOkClick()" />
	</div><br>
</div>

<div id="div-Add-POI" title="Add POI">
	<span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;">Latitude </span><input id="poiLat" type="text" class="textboxCalender corner5" style="width:120px" /><br><br>
	<span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;">Longitude </span><input id="poiLon" type="text" class="textboxCalender corner5" style="width:120px" /><br><br>
    <span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;">Address</span><input id="poiAddress" type="text" class="textboxCalender corner5" style="width:220px" /><img id="loadingAddress" style="visibility: hidden;" width="25px" src="../images/loadingP1.gif" border="0" align="absmiddle" /><br><br>
	<span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;">Name of POI</span><input id="poiName" type="text" class="textboxCalender corner5" style="width:220px" /><br><br>
    <span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;">Available for </span>
        <div id="poiAvail" class="corner5" style="font-size: 10px">
            <input type="radio" id="APcheck1" name="radio" checked="checked" /><label for="APcheck1">Only me</label>
            <input type="radio" id="APcheck2" name="radio" /><label for="APcheck2">All Users</label>
            <input type="radio" id="APcheck3" name="radio" /><label for="APcheck3">Can't change</label>
        </div>
    <br />
    <span style="display:block; width:90px; float:left; margin-left:20px; padding-top:7px;">Group </span>

    <dl id="poiGroup" class="dropdown" style="width: 150px; position: relative; float: left; top: -11px;">
    <%
        Dim dsUG As New Data.DataSet
        dsUG = Loaddataset("SELECT ID, GroupName, Color FROM PinPointGroups WHERE ID=1")
        %>
        <dt><a href="#" title="" class="combobox1"><span>Please select group</span></a></dt>
        <dd>
            <ul>
                <li><a id="<%=dsUG.Tables(0).Rows(0).Item("ID")%>" href="#">&nbsp;&nbsp;<%= dsUG.Tables(0).Rows(0).Item("GroupName")%><div class="flag" style="margin-top: 2px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 14px; height: 14px; background-color: <%=dsUG.Tables(0).Rows(0).Item("Color") %>; position: relative; float: left;"></div></a></li>
                <%
                    Dim dsGroup1 As New Data.DataSet
                    dsGroup1 = Loaddataset("SELECT ID, GroupName, Color FROM PinPointGroups WHERE ClientID=" & Session("client_id"))
                    For Each dr In dsGroup1.tables(0).rows
                %>
                <li><a id="<%=dr("id") %>" href="#">&nbsp;&nbsp;<%=dr("GroupName") %><div class="flag" style="margin-top: 2px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 14px; height: 14px; background-color: <%=dr("Color") %>; position: relative; float: left;"></div></a></li>
                <%
                    Next
                %>
            </ul>
        </dd>
    </dl>
    <input type="button" id="AddGroup" style="left: 30px" onclick="AddGroup()" value="+" />
    <br /><br /><br />
    <input type="hidden" id="idPoi" value="" />
    <input type="hidden" id="numPoi" value="" />
	<div align="right" style="display:block; width:328px">
        <img id="loading" style="display: none; width: 150px; position: absolute; left: 32px; margin-top: 7px;" src="../Images/loading_bar1.gif" alt="" />
		<input type="button" class="BlackText corner5" id="btnCancelPOI" value="Cancel" onclick="$('#div-Add-POI').dialog('destroy');" />&nbsp;&nbsp;
		<input type="button" class="BlackText corner5" id="btnAddPOI" value="Add" onclick="ButtonAddEditPOIokClick()" />
	</div><br><br>
</div>

<table border="0" cellpadding="0" cellspacing="0" width="170px">
	<tr><td width="20px" height="20px" colspan="2" class="text3">Legend</td></tr>
	<tr><td width="20px" height="20px"><div class="gnMarkerListLightBlue" style="width:16px; height:16px"></div></td><td width="150px" height="20px" class="text2">Ova e nekakov status</td></tr>
</table>

</body>
</html>
<%
			dim sqlStyles as string = ""
			dim cntStyles as integer = dlookup("select count(*) from UserSettings where userID=" & session("user_id"))
			if cntStyles = 0 then
				sqlStyles = "SELECT 'Green' EngineON, 'Red' EngineOFF, 'RedBlue' EngineOFFPassengerON, 'Yellow' SatelliteOFF, 'DarkBlue' TaximeterON, 'LightBlue' TaximeterOFFPassengerON, 'Orange' PassiveON, 'Gray' ActiveOFF"
			else
				sqlStyles &= "SELECT c1.name EngineON, c2.name EngineOFF, c3.name EngineOFFPassengerON, c4.name SatelliteOFF, c5.name TaximeterON, c6.name TaximeterOFFPassengerON, c7.name PassiveON, c8.name ActiveOFF "
				sqlStyles &= "from UserSettings us "
				sqlStyles &= "left outer join Colors c1 on c1.id=us.EngineON "
				sqlStyles &= "left outer join Colors c2 on c2.id=us.EngineOFF "
				sqlStyles &= "left outer join Colors c3 on c3.id=us.EngineOFFPassengerON "
				sqlStyles &= "left outer join Colors c4 on c4.id=us.SatelliteOFF "
				sqlStyles &= "left outer join Colors c5 on c5.id=us.TaximeterON "
				sqlStyles &= "left outer join Colors c6 on c6.id=us.TaximeterOFFPassengerON "
				sqlStyles &= "left outer join Colors c7 on c7.id=us.PassiveON "
				sqlStyles &= "left outer join Colors c8 on c8.id=us.ActiveOFF "
				sqlStyles &= "where userID=" & session("user_id")
			end if
			dim dsSt = new data.dataset
			dsSt = loaddataset(sqlStyles)
			dr = dsSt.tables(0).rows(0)
%>
<script type="text/javascript">


    $('#race-img').css({ top: (document.body.clientHeight / 2 - 35) + 'px' });
    $(".dropdown dt a").click(function() {
        $(".dropdown dd ul").toggle();
    });
    $(".dropdown dd ul li a").click(function() {
        var text = $(this).html();
        $(".dropdown dt a")[0].title = this.id;
        $(".dropdown dt a span").html(text);
        $(".dropdown dd ul").hide();
        //$("#result").html("Selected value is: " + getSelectedValue("sample"));
    });
                        
    function getSelectedValue(id) {
        return $("#" + id).find("dt a span.value").html();
    }

    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (! $clicked.parents().hasClass("dropdown"))
            $(".dropdown dd ul").hide();
    });

	AllowedMaps = '<%=AllowedMaps%>'
	DefMapType='<%=DefMap%>'
	var cntz = parseInt('<%=(cntz-1)%>'); 
	
	//$('#quickbuttons').buttonset();
    
	//for (var cz=0; cz<cntz; cz++){
	//	document.getElementById('zona_'+cz).checked = false
	//}
	AllPOI=<%=allPOIs%>
	
	legendStr = '<table border="0" cellpadding="0" cellspacing="0" width="200px">'
	legendStr = legendStr + '<tr><td width="20px" height="20px" colspan="2" class="text3">Legend</td></tr>'
	
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<%=dr("EngineON")%>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2">Engine ON</td></tr>'
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<%=dr("EngineOFF")%>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2">Engine OFF</td></tr>'
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<%=dr("EngineOFFPassengerON")%>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2">Engine OFF Passengers ON</td></tr>'
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<%=dr("SatelliteOFF")%>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2">Low Satellite</td></tr>'
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<%=dr("TaximeterON")%>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2">Taximeter ON</td></tr>'
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<%=dr("TaximeterOFFPassengerON")%>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2">Taximeter OFF Passengers ON</td></tr>'
	legendStr = legendStr + '	<tr><td width="20px" height="20px"><div class="gnMarkerList<%=dr("PassiveON")%>" style="width:10px; height:10px"></div></td><td width="180px" height="20px" class="text2">Engaged</td></tr>'
	
	
	
	legendStr = legendStr + '</table>'
	
	
	
	getCurrentTime()
	// OVA TREBA 
	LoadCurrentPosition = false
	getLeftList()
		
	VehicleList = [<%=strVhList%>]
	VehicleListID = [<%=strVhListID%>]
	StartLat = '<%=sLat%>'
	StartLon = '<%=sLon%>'
	CarStr = "<%=CPosition%>"
	ParseCarStr()
	setLiveHeight()
	CreateBoards()
	LoadMaps()
	iPadSettings()
	/*if (AllowAddZone=='true'){
		$('#icon-draw-zone').click(function(event) {OpenDrawingAreaWindow()});
	} else {
		$('#icon-draw-zone').css({opacity:0.3, cursor:'default'})
	}*/
	$('#icon-draw-path').mousemove(function(event) {ShowPopup(event, 'Show / Hide Trajectory for all vehicles')});
    $('#icon-draw-path-down').mousemove(function(event) {ShowPopup(event, 'Show / Hide Trajectory for vehicles')});
	$('#icon-draw-path').mouseout(function() {HidePopup()});
    $('#icon-draw-path-down').mouseout(function() {HidePopup()});
	$('#icon-draw-path').click(function(event) {OnClickSHTrajectory()});

    ShowActiveBoard();

</script>