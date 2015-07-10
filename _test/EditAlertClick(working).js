function ClearDialog() {
	$("#TipNaAlarm option[value='1']").attr('selected','selected');
	OptionsChangeAlarmType();
	$('#TipNaAlarm').attr('disabled', false);
	$('#vozila option').attr('selected',false);
	$("#voziloOdbrano").val($("#voziloOdbrano option:first").val());
	$('#oEdinica option').attr('selected',false);
	$('#vreme').val("");
	$("#fmvalueDays").val("5");
	$("#fmvalueKm").val("");
	$('#emails').val("");
	$('#GFcheck1').attr('checked',true);
	$('input:radio[name=radio]').button('refresh');
}

function EditAlertClick( _id ) {
	row_array.forEach(function (row){  // go bara redot so soodveniot _id
		if(row.data.id == _id){
		var rowInfo = row.data;

		$('#div-add-alerts').dialog({
		    modal: true,
		    width: 590,
		    height: 500,
		    resizable: false,
		    title: dic("Settings.ChangeAlert", lang),
		    open: function(){

			    $(function () {
			        $("#combobox").combobox();
			        $("#combobox").combobox('setval',$('#combobox option[value="'+ rowInfo.poiid +'"]').text());
			        $("#toggle").click(function () {
			            $("#combobox").toggle();
			        });
			    });
			    $(function () {
			        $("#comboboxVlez").combobox();
			        $("#comboboxVlez").combobox('setval',$('#comboboxVlez option[value="'+ rowInfo.poiid +'"]').text());
			        $("#toggle").click(function () {
			            $("#comboboxVlez").toggle();
			        });
			    });
			    $(function () {
			        $("#comboboxIzlez").combobox();
			        $("#comboboxIzlez").combobox('setval',$('#comboboxIzlez option[value="'+ rowInfo.poiid +'"]').text());
			        $("#toggle").click(function () {
			            $("#comboboxIzlez").toggle();
			        });
			    });

		    	$("#TipNaAlarm option[value="+rowInfo.alarmtypeid+"]").attr('selected','selected');
		    	$('#TipNaAlarm').attr('disabled', 'disabled');
		    	OptionsChangeAlarmType();
		    	$('#brzinata').val(rowInfo.speed);
		    	$('#vreme').val(rowInfo.timeofpoi);
		    	if(rowInfo.uniqid == null) {	// edno vozilo
		    		$("#vozila option[value='1']").attr('selected','selected');
		    	} else {
		    		if (rowInfo.settings == null || rowInfo.settings == "") {
		    			$("#vozila option[value='3']").attr('selected','selected');
		    		} else {
		    			$("#vozila option[value='2']").attr('selected','selected');
		    		}
		    	}

		    	OptionsChangeVehicle();

		    	$("#voziloOdbrano option[value="+rowInfo.vid+"]").attr('selected','selected');
		    	$("#oEdinica option[value="+rowInfo.settings+"]").attr('selected','selected');

		    	if(rowInfo.remindme !== null){
		    		console.log("Denovi: " + rowInfo.remindme.split(" ")[0]);
		    		$("#fmvalueDays").val(rowInfo.remindme.split(" ")[0]);
		    	}

		    	$('#emails').val(rowInfo.emails);

		    	$('#GFcheck' + rowInfo.available).attr('checked',true);
		    	$('input:radio[name=radio]').button('refresh');
		    },
		    close: function() {
		    	$("#combobox").combobox('destroy');
        		$("#comboboxVlez").combobox('destroy');
        		$("#comboboxIzlez").combobox('destroy');
        		console.log("destroyed...");
		    },
		    buttons: [{
		        text: dic('Fm.Mod', lang),
		        click: function() {

		        	console.log("tuka validacija");

		        }
		    }, {
		        text: dic('Fm.Cancel', lang),
		        click: function() {
		        	ClearDialog();
		        	$(this).dialog("close");
		        }
		    }]
		});

			console.log(row.data);
			console.log(row.vreg);

		}  //[end] GLAVEN IF == _id
	});
}