for (var j = 0; j < allGroups.length; j++) {
    	var counter = 0;
    	var tbl = $('#POI_data_' + allGroups[j]);

		if( term !== "")
		{
		console.log("the term: " + term);
    	for(var r = 1; r <= ($("tr", tbl).length-1); r++){

    		var row = $("tr", tbl).eq(r);
				// Show only matching TR, hide rest of them
				$("tr", tbl).eq(r).hide();
	            $("td", row).eq(1).filter(function(){
	                   return $(this).text().toLowerCase().indexOf(term ) >-1;}).parent("tr").show();
	            if($("td", row).eq(1).text().toLowerCase().indexOf(term ) >-1){ counter+=1; }
 				console.log("counter is: " + counter);
    		}
	    	if (counter == 0) {
	    		$('#POI_data_' + allGroups[j]).hide();
	    		$('#POI_group' + allGroups[j]).parent().hide();

	    	}
   		}
		else
		{
			// When there is no input or clean again, show everything back
			$("tr", tbl).show();
			$('#POI_data_' + allGroups[j]).show();
			$('#POI_group' + allGroups[j]).parent().show();
		}
    	

    }



var $rows = $('#table tr');
$('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});