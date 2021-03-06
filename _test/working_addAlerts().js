function addAlerts() {

    //document.getElementById('div-add-alerts').title = dic("Settings.AddAlerts");
    $('#div-add-alerts').dialog({
        modal: true,
        width: 590,
        height: 500,
        resizable: false,
        title: dic("Settings.AddAlerts"),
        open: function() {

    	    $(function () {
		        $("#combobox").combobox();
		        $("#toggle").click(function () {
		            $("#combobox").toggle();
		        });
		    });
		    $(function () {
		        $("#comboboxVlez").combobox();
		        $("#toggle").click(function () {
		            $("#comboboxVlez").toggle();
		        });
		    });
		    $(function () {
		        $("#comboboxIzlez").combobox();
		        $("#toggle").click(function () {
		            $("#comboboxIzlez").toggle();
		        });
		    });
  			ClearDialog();	// se povukuva za da se iscisti od prethodno ako ne e povikano window.reload
  			OptionsChangeVehicle();
        },
        close: function() {
        	$("#combobox").combobox('destroy');
        	$("#comboboxVlez").combobox('destroy');
        	$("#comboboxIzlez").combobox('destroy');
        	console.log("destroyed...");
        },
        buttons: [{
            text: dic('Settings.Add', lang),
            click: function(data) {

                var tipNaAlarm = $('#TipNaAlarm').val();
                var email = $('#emails').val();
                var sms = '';
                if (Number('<?php echo $clienttypeid ?>') == 6) sms = $('#sms').val();
                var zvukot = $('#zvukot').val();
                var ImeNaTocka = $('#combobox').val();
                var ImeNaTockaProverka = document.getElementById('combobox').selectedIndex;
                var ImeNaZonaIzlez = $('#comboboxIzlez').val();
                var ImeNaZonaIzlezProverka = document.getElementById('comboboxIzlez').selectedIndex;
                var ImeNaZonaVlez = $('#comboboxVlez').val();
                var ImeNaZonaVlezProverka = document.getElementById('comboboxVlez').selectedIndex;
                var orgEdinica = '';
                if(document.getElementById('vozila').selectedIndex == 2) { orgEdinica=$('#oEdinica').val(); } else orgEdinica=null;
                var odbraniVozila = $("#vozila option:selected").val(); // mozni vrednosti 1,2,3
                var NadminataBrzina = $('#brzinata').val();
                var vreme = $('#vreme').val();
                var alarmSelect = document.getElementById('TipNaAlarm').selectedIndex;
                var voziloOdbrano = $('#voziloOdbrano').val();
                var dostapno = getCheckedRadio('radio');

                //------------------------------------------------------------------------//
                ////////////////////////////////////////////////////////////////////////////


                var validation = [];

                if(email === '') validation.push("Settings.AlertsEmailHaveTo");
                if(email.length > 0 && !validacija()) validation.push("uncorrEmail");

	 			if(Number(odbraniVozila) === 0) validation.push("Settings.SelectAlert1");

	 			if(tipNaAlarm == 7 && !isNormalInteger(NadminataBrzina)){
	 				validation.push("Settings.InsertSpeedOver");
	 			}
	 			if(tipNaAlarm == 8 && ImeNaZonaVlezProverka == ""){
	 				validation.push("Settings.SelectEnterGeoF");
	 			}
	 			if(tipNaAlarm === 9 && ImeNaZonaIzlezProverka == ""){
	 				validation.push("Settings.SelectExitGeoF");
				}
	 			if(tipNaAlarm == 10){
	 				if (ImeNaTockaProverka == "") validation.push("Settings.SelectPOI2");
	 				else {
		 				if(!isNum(vreme)) validation.push("Settings.InsertRetTime");
	 				}
	 			}
	 			if(tipNaAlarm == 18 && (isChecked("remindKm") === false && isChecked("remindDays") === false)) validation.push("Settings.RemindMeMustOne");

	 			if (sms !== "") {
                    // document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS", lang);
                    $('#div-tip-praznik').dialog({
                        modal: true,
                        width: 300,
                        height: 230,
                        resizable: false,
                        title : dic("Settings.ConfSMS", lang),
                        buttons: [{
                            text: dic("Reports.Confirm"),
                            click: function() {
                                pass = encodeURIComponent($('#dodTipPraznik').val());
                                tipPraznikID = document.getElementById("dodTipPraznik");
                                if (pass === "") {
                                    msgboxPetar(dic("Settings.InsertPass", lang));
                                    tipPraznikID.focus();
                                } else {
                                    $.ajax({
                                        url: "checkPassword2.php?pass=" + pass + "&l=" + lang,
                                        context: document.body,
                                        success: function(data) {
                                            if (data == 1) {
                                                msgboxPetar(dic("Settings.VaildPassSucAlert", lang));
                                            } else {
                                                msgboxPetar(dic("Settings.Incorrectpass", lang));
                                                exit;
                                            }
                                        }
                                    });
                                }
                            }
                        }, {
                            text: dic("Fm.Cancel", lang),
                            click: function() {
                                $(this).dialog("close");
                            }
                        }]
                    });
                }

	 			//------------------------------[END] validation ------------------------------------//
                ///////////////////////////////////////////////////////////////////////////////////////

	 			console.log(validation);
	 			console.log(validation.length);

				var remindme = '';
			  	if (tipNaAlarm == 17 || tipNaAlarm == 18 || tipNaAlarm == 20) {
			  		var fmvalueDays = "";

			  		if (tipNaAlarm == 18) {
			  			if ($('#remindDays').is(':checked')) {
			  				fmvalueDays = $('#fmvalueDays').val() + " days";
			  			}
			  		} else {
			  			if ($('#fmvalueDays').val() != "") {
				  			fmvalueDays = $('#fmvalueDays').val() + " days";
				  		}
			  		}

				  	var fmvalueKm = "";
				  	if ($('#rmdKm').css('display') != 'none') {
				  		if (tipNaAlarm == 18) {
				  			if ($('#remindKm').is(':checked')) {
				  				if (fmvalueDays != "")
				  					fmvalueKm += "; " + Math.round($('#fmvalueKm').val()/ Number('<?php echo $value?>')) + " Km";
				  				else
				  					fmvalueKm = Math.round($('#fmvalueKm').val()/ Number('<?php echo $value?>')) + " Km";
				  			}
				  		} else {
				  			if ($('#fmvalueKm').val() != "") {
					  			if (fmvalueKm != "")
					  				fmvalueKm += "; " + Math.round($('#fmvalueKm').val()/ Number('<?php echo $value?>')) + " Km";
					  			else
					  				fmvalueKm = Math.round($('#fmvalueKm').val()/ Number('<?php echo $value?>')) + " Km";
					  		}
				  		}
				  	}
			  		remindme = fmvalueDays + fmvalueKm;
			  	}

			  	var qurl = "addAlertMain.php?tipNaAlarm=" + tipNaAlarm + "&email=" + email + "&sms=" + sms + "&zvukot=" + zvukot + "&ImeNaTocka=" + ImeNaTocka + "&ImeNaZonaIzlez=" + ImeNaZonaIzlez + "&ImeNaZonaVlez=" + ImeNaZonaVlez + "&NadminataBrzina=" + NadminataBrzina + "&vreme=" + vreme + "&dostapno=" + dostapno + "&orgEdinica=" + orgEdinica + "&odbraniVozila=" + odbraniVozila + "&voziloOdbrano=" + voziloOdbrano + "&remindme=" + remindme;

			  	console.log(qurl);

	 			if (validation.length === 0) {
		 			$.ajax({
		                    url: qurl,
		                    context: document.body,
		                    success: function(data) {
		                    	console.log(data);
		                        msgboxPetar(dic("Settings.SuccAdd", lang));
		                        // window.location.reload();
		                    }
		                });
	 			} else {
	 				msgboxPetar(dic(validation[0],lang));
	 			}

             }
        }, {
            text: dic('cancel', lang),
            click: function() {
                $(this).dialog("close");
            }
        }
        ]
    });
}