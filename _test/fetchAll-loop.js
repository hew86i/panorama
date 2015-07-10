$.each(allGroups,function(i,v){

	console.log("["+i+","+v+"]");

	if(find_group(GroupsInfo,v) == -1) {  // ako ne e otvorena grupata

	var currPoints = numOfPoints[i];

	GroupsInfo.push({gpid:v, offset:0, numPOI: currPoints,});
	var inx = find_group(GroupsInfo,v);


	GroupsInfo[inx].expanded = true;
	GroupsInfo[inx].firstExpand = false;
	GroupsInfo[inx].clicked = true;
	dataOffset = 0;

	if(currPoints > 20) $('#POI_data_' + v).css({ height: '500px',overflowY: 'scroll'});

	console.log("new fetchData("+currPoints+","+0+","+v+")" );
	fetchData(numOfPoints[i],0,v,true);
	$('#POI_data_' + v).hide();
	} else {
		console.log("fetchData("+numOfPoints[i]+","+GroupsInfo[find_group(GroupsInfo,v)].offset+","+v+")" );
		fetchData(numOfPoints[i],GroupsInfo[find_group(GroupsInfo,v)].offset,v,true);

	}
});