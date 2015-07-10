    // ke se vcitaat site tocki vo JSON format
	setTimeout(function(){
		fetch_all();
		console.log("fetch all");
	},100);


	function fetch_all() {

	ShowWait();
	$.ajax({
	    url: "GetPOIOffset.php?all=1",
	    context: document.body,
	    success: function(alldata) {
	    	HideWait();
	    	$('#fetch-data').append(alldata);
	    }
	});
}