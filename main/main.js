// JavaScript Document

var TimerAlarms;
var snooze = 10;
var CarNotify = [];
var AlarmsTypeArray = ",assistance,acumulator,vehicleAlarm,fuelCap,suddenBraking,speedExcess,enterZone,leaveZone,service,visitPOI,stayMoreThanAllow,stayOutOfLocat,leaveRoute,pause,regExpire,greenCard,polnomLicense,agreement,unauthorizedUseVehicle,NoRFIDVehicle,VehicleDefect,unOrdered,alarmpanic,HalfHourNoDataIgnON,acumulatorPowerSupplyInterruption,prednaleva,prednadesna,stranicnavrata,zadnavrata,stanatvozac,odlozenablokada,zadenpanik,zadenaodlozenablokada,granicaobrtai,nacionalnamreza,taxioffpasson,tow,weakAccumulator,geolock,sosalarm,changelocation,geolockasset,mandown,weakbattery,mainpoweron,mainpoweroff,qalarmpanic,fueldown,";
var metricvalue = 1;
var metric = "Km";
var liqvalue = "1";
var currencyvalue = "1";

lang1 = lang;

if(document.location.href.indexOf("lang") == -1 && document.location.href.indexOf("essionexpired") == -1 && document.location.href.indexOf("dmin") == -1 && document.location.href.indexOf("racking") == -1 && document.location.href.indexOf("ettings") == -1 && document.location.href.indexOf("eport") == -1 && document.location.href.indexOf("fm") == -1 && document.location.href.indexOf("oute") == -1)
	var _point = ".";
else
	var _point = "..";
var twopoint = _point;

function costVehicleW (i, id, reg) {
	document.getElementById('div-costMain').title = dic("Reports.AddingCost") + " - " +  reg;
	ShowWait();
	
	$.ajax({
        url: twopoint + '/main/AddCostW.php?l=' + lang + '&vehid=' + id + '&tpoint=' + twopoint,
        context: document.body,
        success: function (data) {
        	HideWait();
            $('#div-costMain').html(data);
            $('#div-costMain').dialog({ modal: true, height: 660, width: 510,
							zIndex: 10000 ,
                buttons:
                 [
                     {
                     	 id: 'btnAddCost1_',
                         text: dic("add", '<?php echo $cLang ?>'),
                         click: function () {
                         	$('#btnAddCost1_').attr('disabled', true);
                         	setInterval(function(){$('#btnAddCost1_').attr('disabled', false)}, 4000);
                         	 var testSelected = $($('#searchCost')[0]).attr('class');
                              	
                         	if(testSelected == undefined || testSelected == "")
						  	{
						  		mymsg(dic("Reports.NotSelCost"));
						  		return false;
						  	}
						  	
            		        if(testSelected == "Fuel") {
            		        	var dt = document.getElementById("datetime").value;
            		        	var driver = "";
            		        	if (document.getElementById("searchDri"))
	            		        		//driver = document.getElementById("driver").value;
	            		        		driver = $($('#searchDri')[0]).attr('class');
	            		        		
	                            var km = (document.getElementById("km").value).replace(/\,/g,'') / metricvalue;
	                            //var liters = document.getElementById("liters").value;
	                            //var litersLast = document.getElementById("litersLast").value;
				var liters = $("#liters").val().replace(/\,/g,'');	
				var litersLast = $("#litersLast").val().replace(/\,/g,'');
	
	                            //var price = (document.getElementById("price").value).replace(/\,/g,'') * currencyvalue;
				    var price = $("#price").val().replace(/\,/g,'') * currencyvalue;

								var veh = id; //document.getElementById("vehictype").value;
								var pay = "";
            		        	if (document.getElementById("searchPay"))
	            		        		//driver = document.getElementById("driver").value;
	            		        		pay = $($('#searchPay')[0]).attr('class');
	            		        		
								var loc = $($('#searchExe')[0]).attr('class')//document.getElementById("location").value;
								
								//alert("InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&price=" + price + "&vehID=" + veh)
								document.getElementById('liters').style.border = "1px solid #cccccc"
								document.getElementById('price').style.border = "1px solid #cccccc"
								
								if (liters == "") {
									alert(dic("Reports.EnterFuelSupply"))
									document.getElementById('liters').style.border = "1px solid red"
									document.getElementById('liters').select()
								}
								if (price == "") {
									alert(dic("Reports.EnterFuelCost"))
									document.getElementById('price').style.border = "1px solid red"
									if (liters == "") document.getElementById('liters').select()
									else document.getElementById('price').select()
								}
								
	                          
	                          $.ajax({
						           url: twopoint + '/main/CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt + '&tpoint=' + twopoint,
						           context: document.body,
						           success: function (data) {
						           		if (Math.abs(km - data) > (data * 20/100)) {
											var msg = "<div><?php dic('Reports.KmOdometer')?> (" + document.getElementById("km").value + " " + '<?php echo $metric?>' + ") <?php dic('Reports.KmDifferent')?> (" + addCommas(parseInt(data.replace(",", "") * '<?php echo $metricvalue?>')) + " " + '<?php echo $metric?>' + ").<br><?php dic('Reports.SureKm')?> <font style='color:#FF6633;font-weight:bold'>" + document.getElementById("km").value + " " + '<?php echo $metric?>' + "</font>?</div>";
		           							$('#div-msgbox1').html(msg)		
									
											$( "#dialog:ui-dialog" ).dialog( "destroy" );	
											$( "#dialog-message1" ).dialog({ height: 220, width: 440,
												modal: true,
										        resizable: false,
												zIndex: 10001 ,
												buttons: {
													"Да": function() {
														if (price != "" && liters != "") {
														       $.ajax({
									                                url: twopoint + "/main/InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&loc=" + loc + "&price=" + price + "&vehID=" + veh + '&pay=' + pay + '&tpoint=' + twopoint,
									                                context: document.body,
									                                success: function (data) {
									                                    $(this).dialog("close");
									                                    if (data == 0) {
									                                    	mymsg(dic("Settings.AlreadyFuelCost"))
									                                    } else {
									                                    	mymsg(dic("Reports.SuccAddFuel"))
									                                    }
									                                    location.reload();
									                                }
									                            });
														        
														        $.ajax({
														              url: twopoint + "/main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km + '&tpoint=' + twopoint,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
													},
													"Откажи": function() {
														$( this ).dialog( "close" );
														document.getElementById('km').value = data;
													},
												}
											});
						           		} else {
						           				if (price != "" && liters != "") {
														     $.ajax({
									                                url: twopoint + "/main/InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&loc=" + loc + "&price=" + price + "&vehID=" + veh + '&pay=' + pay + '&tpoint=' + twopoint,
									                                context: document.body,
									                                success: function (data) {
									                                    $(this).dialog("close");
											                            if (data == 0) {
									                                    	mymsg(dic("Settings.AlreadyFuelCost"))
									                                    } else {
									                                    	mymsg(dic("Reports.SuccAddFuel"))
									                                    }
									                                    location.reload();
									                                }
									                            }); 
														        
														        $.ajax({
														              url: twopoint + "/main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km + '&tpoint=' + twopoint,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
								                           }
						           		}
						           	}
						           });
	                          
	                          
	                          
            		        } else {
            		        	if (testSelected == "Service") {
            		        		var dt = document.getElementById("datetime").value;
            		        		var driver = "";
                		        	if (document.getElementById("searchDri"))
	            		        		//driver = document.getElementById("driver").value;
	            		        		driver = $($('#searchDri')[0]).attr('class');
	            		        		
							        var veh = id; //document.getElementById("vehictype").value;
							         var km = (document.getElementById("km").value).replace(/\,/g,'') / metricvalue;
							        var type = $('input[name=type]:radio:checked').val();
							        var loc = $($('#searchExe')[0]).attr('class')//document.getElementById("location").value;
							        var desc = document.getElementById("desc").value;
							        //var comp = document.getElementById("components").value;
							        var comp= "";
							        for (var i=0; i < $('#components-').children().length; i++) {
										comp += ($('#components-').children()[i].id).split("main-")[1] + ";";
									}
						//var price = (document.getElementById("price").value).replace(/\,/g,'') * currencyvalue;
						var price = $("#price").val().replace(/\,/g,'') * currencyvalue;

							        var pay = "";
            		        		if (document.getElementById("searchPay"))
	            		        		//driver = document.getElementById("driver").value;
	            		        		pay = $($('#searchPay')[0]).attr('class');
							        
							        document.getElementById('desc').style.border = "1px solid #cccccc"
									document.getElementById('price').style.border = "1px solid #cccccc"
								
								if (desc == "") {
									alert("Внесете опис на сервисот !!!")
									document.getElementById('desc').style.border = "1px solid red"
									document.getElementById('desc').select()
								}
								if (price == "") {
									alert("Внесете износ на трошокот за сервис !!!")
									document.getElementById('price').style.border = "1px solid red"
									if (liters == "") document.getElementById('liters').select()
									else document.getElementById('price').select()
								}
								
								
								$.ajax({
						           url: twopoint + '/main/CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt + '&tpoint=' + twopoint,
						           context: document.body,
						           success: function (data) {
						           		if (Math.abs(km - data) > (data * 20/100)) {
						           			var msg = "<div>Километрите кои ги внесовте во полето Одометар (" + km + " Km) драстично се разликуваат од километрите пресметани преку GPS (" + data + " Km).<br>Дали сте сигурни дека трошокот е направен на <font style='color:#FF6633;font-weight:bold'>" + km + " Km</font>?</div>";
						           			$('#div-msgbox1').html(msg)
											$( "#dialog:ui-dialog" ).dialog( "destroy" );	
											$( "#dialog-message1" ).dialog({ height: 220, width: 440,
												modal: true,
										        resizable: false,
												zIndex: 10001 ,
												buttons: {
													"Да": function() {
														if (price != "" && desc != "") {
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														      $.ajax({
														              url: twopoint + "/main/InsertService.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price + "&pay=" + pay + '&tpoint=' + twopoint,
														              context: document.body,
														              success: function (data) {
														                $("#dialog-message1").dialog("close");
														                if (data == 0) {
									                                    	mymsg(dic("Settings.AlreadyServiceCost"))
									                                    } else {
									                                    	mymsg(dic("Reports.SuccAddServ"))
									                                    }
								                                    	location.reload();   
														              }
														        }); 
														        
														        $.ajax({
														              url: twopoint + "/main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km + '&tpoint=' + twopoint,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
													},
													"Откажи": function() {
														$( this ).dialog( "close" );
														document.getElementById('km').value = data;
													},
												}
											});
						           		} else {
						           				if (price != "" && desc != "") {
														      $.ajax({
														              url: twopoint + "/main/InsertService.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price + "&pay=" + pay + '&tpoint=' + twopoint,
														              context: document.body,
														              success: function (data) {
														                $("#dialog-message1").dialog("close");
														                if (data == 0) {
									                                    	mymsg(dic("Settings.AlreadyServiceCost"))
									                                    } else {
									                                    	mymsg(dic("Reports.SuccAddServ"))
									                                    }
								                                    	location.reload();   
														              }
														        }); 
														        
														        $.ajax({
														              url: twopoint + "/main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km + '&tpoint=' + twopoint,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
						           		}
						           	}
						           });
	           	
																		
								
            		        	} else {
            		        		 if(testSelected == "Cost") {
            		        		var dt = document.getElementById("datetime").value;
            		        		var driver = "";
                		        	if (document.getElementById("searchDri"))
	            		        		//driver = document.getElementById("driver").value;
	            		        		driver = $($('#searchDri')[0]).attr('class');
	            		        		
						var veh = id; //document.getElementById("vehictype").value;
							         var km = (document.getElementById("km").value).replace(/\,/g,'') / metricvalue;
							        var desc = document.getElementById("desc").value;
							        var comp = "";//document.getElementById("components").value;
							        for (var i=0; i < $('#components-').children().length; i++) {
										comp += ($('#components-').children()[i].id).split("main-")[1] + ";";
									}
									
							        var price = (document.getElementById("price").value).replace(/\,/g,'') * currencyvalue;
							        var pay = "";
            		        		if (document.getElementById("searchPay"))
	            		        		//driver = document.getElementById("driver").value;
	            		        		pay = $($('#searchPay')[0]).attr('class');
	            		        		
							        var loc = $($('#searchExe')[0]).attr('class')//document.getElementById("location").value;
							        
							    document.getElementById('desc').style.border = "1px solid #cccccc"
									document.getElementById('price').style.border = "1px solid #cccccc"
								
								if (desc == "") {
									alert("Внесете опис на останатиот трошок !!!")
									document.getElementById('desc').style.border = "1px solid red"
									document.getElementById('desc').select()
								}
								if (price == "") {
									alert("Внесете износ на останатиот трошок !!!")
									document.getElementById('price').style.border = "1px solid red"
									if (liters == "") document.getElementById('liters').select()
									else document.getElementById('price').select()
								}
								
								
								
								
								$.ajax({
						           url: twopoint + '/main/CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt + '&tpoint=' + twopoint,
						           context: document.body,
						           success: function (data) {
						           		if (Math.abs(km - data) > (data * 20/100)) {
						           			var msg = "<div>Километрите кои ги внесовте во полето Одометар (" + km + " Km) драстично се разликуваат од километрите пресметани преку GPS (" + data + " Km).<br>Дали сте сигурни дека трошокот е направен на <font style='color:#FF6633;font-weight:bold'>" + km + " Km</font>?</div>";
						           			$('#div-msgbox1').html(msg)
											$( "#dialog:ui-dialog" ).dialog( "destroy" );	
											$( "#dialog-message1" ).dialog({ height: 220, width: 440,
												modal: true,
										        resizable: false,
												zIndex: 10001 ,
												buttons: {
													"Да": function() {
														if (price != "" && desc != "") {
														     	$.ajax({
														          url: twopoint + "/main/InsertCost.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&loc=" + loc + "&comp=" + comp + "&price=" + price + "&pay=" + pay + '&tpoint=' + twopoint,
														              context: document.body,
														              success: function (data) {
														                    $(this).dialog("close");
														                    if (data == 0) {
										                                    	mymsg(dic("Settings.AlreadyOthCost"))
										                                    } else {
										                                    	mymsg(dic("Reports.SuccAddOthCost"))
										                                    }
								                                    		location.reload();
														              }
														        }); 
							  																        
														        $.ajax({
														              url: twopoint + "/main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km + '&tpoint=' + twopoint,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
													},
													"Откажи": function() {
														$( this ).dialog( "close" );
														document.getElementById('km').value = data;
													},
												}
											});
						           		} else {
						           			if (price != "" && desc != "") {
											     	$.ajax({
											          url: twopoint + "/main/InsertCost.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&loc=" + loc + "&comp=" + comp + "&price=" + price + "&pay=" + pay + '&tpoint=' + twopoint,
											              context: document.body,
											              success: function (data) {
											                    $(this).dialog("close");
											                    if (data == 0) {
							                                    	mymsg(dic("Settings.AlreadyOthCost"))
							                                    } else {
							                                    	mymsg(dic("Reports.SuccAddOthCost"))
							                                    }
					                                    		location.reload();
											              }
											        }); 
				  																        
											        $.ajax({
											              url: twopoint + "/main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km + '&tpoint=' + twopoint,
											              context: document.body,
											              success: function (data) {
											    
											              }
											        }); 
											        
					                           }
						           		}
						           		
						           	}
						           });
						           
						           
								
								  } else {
								  	if(testSelected == "0")
								  	{
								  		mymsg(dic("Reports.NotSelCost"));
								  	} else {
								  		var costtypeid = testSelected;
								  		var dt = document.getElementById("datetime").value;
								  		 var km = (document.getElementById("km").value).replace(/\,/g,'') / metricvalue;
								  		var loc = $($('#searchExe')[0]).attr('class')//document.getElementById("location").value;
								  		var driver = "";
	                		        	if (document.getElementById("searchDri"))
	            		        			//driver = document.getElementById("driver").value;
	            		        			driver = $($('#searchDri')[0]).attr('class');
	            		        		
	                		        	 var pay = "";
	            		        		if (document.getElementById("searchPay"))
		            		        		//driver = document.getElementById("driver").value;
		            		        		pay = $($('#searchPay')[0]).attr('class');
		            		        		
                		        		var price = (document.getElementById("price").value).replace(/\,/g,'') * currencyvalue;
                		      var veh = id; //document.getElementById("vehictype").value;
                		        		if (price != "") {
                		        			$.ajax({
									          url: twopoint + "/main/InsertNewCost.php?costtypeid=" + costtypeid + "&dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&loc=" + loc + "&price=" + price + "&pay=" + pay + '&tpoint=' + twopoint,
									              context: document.body,
									              success: function (data) {
									                    $(this).dialog("close");
									                    if (data == 0) {
					                                    	mymsg(dic("Settings.AlreadyCost"))
					                                    } else {
					                                    	mymsg(dic("Reports.SuccAddCost"))
					                                    }
			                                    		location.reload();
									              }
									        }); 
                		        		}	else {
                		        			alert(dic("Reports.EnterAmount"))
											document.getElementById('price').style.border = "1px solid red"
											if (liters == "") document.getElementById('liters').select()
											else document.getElementById('price').select()
                		        		}
								  	}
								  	
								  }              		        	}
            		        }
                         }
                     },
                     {
                         text: dic("cancel", '<?php echo $cLang ?>'),
                         click: function () {
                             //$('#div-cost').dialog("destroy");
                             $( this ).dialog( "close" );
                         }
                     }
                 ]
            });
        }
    });
}
function costVehicle123 (i, id, reg) {
	document.getElementById('div-costMain').title = dic("Reports.AddingCost",lang);
	ShowWait();

	$.ajax({
        url: twopoint + '/main/AddCost.php?l=' + lang + '&vehid=' + id + '&tpoint=' + twopoint,
        context: document.body,
        success: function (data) {
        	HideWait();
            $('#div-costMain').html(data);
            $('#div-costMain').dialog({ modal: true, height: 660, width: 540,
							zIndex: 9999 ,
                buttons:
                 [
                     {
                     	 id: 'btnAddCost_',
                         text: dic("add", '<?php echo $cLang ?>'),
                         click: function () {
							$('#btnAddCost_').attr('disabled', true);
							setInterval(function(){$('#btnAddCost_').attr('disabled', false)}, 4000);
							
				var testSelected1 = $($('#searchVeh_')[0]).attr('class');
                         	if(testSelected1 == undefined || testSelected1 == "")
			  	{
			  		mymsg(dic('Tracking.NoVeh'));
			  		return false;
			  	}

                         	var testSelected = $($('#searchCost')[0]).attr('class');
                         	if(testSelected == undefined || testSelected == "")
			  	{
			  		mymsg(dic("Reports.NotSelCost"));
			  		return false;
			  	}

            		        if(testSelected == "Fuel") {
            		        	var dt = document.getElementById("datetime").value;
            		        	var driver = "";
            		        	
            		        	//alert($($('#searchDri')[0]).attr('class'))
            		        	//return;
            		        	if (document.getElementById("searchDri"))
            		        		//driver = document.getElementById("driver").value;
            		        		driver = $($('#searchDri')[0]).attr('class');
            		        		//alert("insertira vo executor?????????")
            		        		//return;
            		        		
	                            var km = (document.getElementById("km").value).replace(/\,/g,'') / metricvalue;
				    var price = (document.getElementById("price").value).replace(/\,/g,'') * currencyvalue;
				    //var liters = document.getElementById("liters").value / liqvalue;
				var liters = $("#liters").val().replace(/\,/g,'') / liqvalue;	
				    //var litersLast = document.getElementById("litersLast").value / liqvalue;
				var litersLast = $("#litersLast").val().replace(/\,/g,'') / liqvalue;	
								var veh;
								if (document.getElementById("searchVeh_"))
            		        		//var veh = document.getElementById("vehictype").value;
            		        		veh = $($('#searchVeh_')[0]).attr('class');
            		        		
								var pay = "";
        		        		if (document.getElementById("searchPay"))
            		        		//driver = document.getElementById("driver").value;
            		        		pay = $($('#searchPay')[0]).attr('class');
	            		        		
								var loc = $($('#searchExe')[0]).attr('class')//document.getElementById("location").value;
								
								//alert("InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&price=" + price + "&vehID=" + veh)
								document.getElementById('liters').style.border = "1px solid #cccccc"
								document.getElementById('price').style.border = "1px solid #cccccc"
								
								if (liters == "") {
									alert(dic("Reports.EnterFuelSupply"))
									document.getElementById('liters').style.border = "1px solid red"
									document.getElementById('liters').select()
								}
								if (price == "") {
									alert(dic("Reports.EnterFuelCost"))
									document.getElementById('price').style.border = "1px solid red"
									if (liters == "") document.getElementById('liters').select()
									else document.getElementById('price').select()
								}
				  
	                          $.ajax({
						           url: twopoint + '/main/CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt + '&tpoint=' + twopoint,
						           context: document.body,
						           success: function (data) {

						           		if (Math.abs(km - data.replace(",", "")) > (data.replace(",", "") * 20/100)) {
						           			
//var msg = "<div>Километрите кои ги внесовте во полето Одометар (" + km + " Km) драстично се разликуваат од километрите пресметани преку GPS (" + data + " Km).<br>Дали сте сигурни дека трошокот е направен на <font style='color:#FF6633;font-weight:bold'>" + km + " Km</font>?</div>";
						           			var msg = "<div>" + dic('Reports.KmOdometer') + " (" + document.getElementById("km").value + " " + metric + ") " + dic('Reports.KmDifferent') + " (" + addCommas(parseInt(data.replace(",", "") * metricvalue)) + " " + metric + ").<br>" + dic('Reports.SureKm') + "<font style='color:#FF6633;font-weight:bold'> " + document.getElementById("km").value + " " + metric + "</font>?</div>";

$('#div-msgbox1').html(msg)
											$( "#dialog:ui-dialog" ).dialog( "destroy" );	
											$( "#dialog-message1" ).dialog({ height: 220, width: 440,
												modal: true,
										        resizable: false,
												zIndex: 10001 ,
												buttons: [
												{
													text: dic("yes"),
													 click: function () {
														if (price != "" && liters != "") {
															//alert(twopoint + "/main/InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&loc=" + loc + "&price=" + price + "&vehID=" + veh + '&pay=' + pay)	
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														      $.ajax({
		                                url: twopoint + "/main/InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&loc=" + loc + "&price=" + price + "&vehID=" + veh + '&pay=' + pay + '&tpoint=' + twopoint,
		                                context: document.body,
		                                success: function (data) {
											$("#dialog-message1").dialog("close");
		                                    $('#div-costMain').dialog('close');
		                                    if (data == 0) {
		                                    	mymsg(dic("Settings.AlreadyFuelCost"))
		                                    } else {
		                                    	mymsg(dic("Reports.SuccAddFuel"))
		                                    }
		                                    //location.reload();
		                                }
		                            });
														        
														        $.ajax({
														              url: twopoint + "/main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km + '&tpoint=' + twopoint,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
													}},
													{
														text: dic("cancel"),
													 click: function () {
														$( this ).dialog( "close" );
														document.getElementById('km').value = data;
													},
												}
												]
											});
						           		} else {
						           				if (price != "" && liters != "") {
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														     $.ajax({
		                                url: twopoint + "/main/InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&loc=" + loc + "&price=" + price + "&vehID=" + veh + '&pay=' + pay + '&tpoint=' + twopoint,
		                                context: document.body,
		                                success: function (data) {
											$("#dialog-message1").dialog("close");
		                                    $('#div-costMain').dialog('close');
		                                    if (data == 0) {
		                                    	mymsg(dic("Settings.AlreadyFuelCost"))
		                                    } else {
		                                    	mymsg(dic("Reports.SuccAddFuel"))
		                                    }
		                                    //location.reload();
		                                }
		                            }); 
														        
														        $.ajax({
														              url: twopoint + "/main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km + '&tpoint=' + twopoint,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
						           		}
						           		
						           	}
						           });
	                          
	                          
	                          
            		        } else {
            		        	if (testSelected == "Service") {
            		        		var dt = document.getElementById("datetime").value;
            		        		var driver = "";
                		        	if (document.getElementById("searchDri"))
	            		        		//driver = document.getElementById("driver").value;
	            		        		driver = $($('#searchDri')[0]).attr('class');
            		        		
							       var veh;
									if (document.getElementById("searchVeh_"))
            		        			//var veh = document.getElementById("vehictype").value;
            		        			veh = $($('#searchVeh_')[0]).attr('class');
            		        		
							        var km = (document.getElementById("km").value).replace(/\,/g,'') / metricvalue;
							        var type = $('input[name=type]:radio:checked').val();
							        var loc = $($('#searchExe')[0]).attr('class')//document.getElementById("location").value;
							        var desc = document.getElementById("desc").value;
							        //var comp = document.getElementById("components").value;
							        var comp= "";
							        for (var i=0; i < $('#components-').children().length; i++) {
										comp += ($('#components-').children()[i].id).split("main-")[1] + ";";
									}
							        var price = (document.getElementById("price").value).replace(/\,/g,'') * currencyvalue;
								
							        var pay = "";
            		        		if (document.getElementById("searchPay"))
	            		        		//driver = document.getElementById("driver").value;
	            		        		pay = $($('#searchPay')[0]).attr('class');
	            		        		
							        
							        document.getElementById('desc').style.border = "1px solid #cccccc"
									document.getElementById('price').style.border = "1px solid #cccccc"
								
								if (desc == "") {
									alert(dic("Reports.EnterDescServ"))
									document.getElementById('desc').style.border = "1px solid red"
									document.getElementById('desc').select()
								}
if (comp == "") {
										alert(dic("Reports.EnterLeastComp"))
										document.getElementById('div-addcomp').style.border = "1px solid red"
									}
								if (price == "") {
									alert(dic("Reports.EnterServCost"))
									document.getElementById('price').style.border = "1px solid red"
									if (liters == "") document.getElementById('liters').select()
									else document.getElementById('price').select()
								}
								
								

								$.ajax({
						           url: twopoint + '/main/CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt + '&tpoint=' + twopoint,
						           context: document.body,
						           success: function (data) {
						           
						           		if (Math.abs(km - data.replace(",", "")) > (data.replace(",", "") * 20/100)) {
						           			var msg = "<div>" + dic('Reports.KmOdometer') + " (" + document.getElementById("km").value + " " + metric + ") " + dic('Reports.KmDifferent') + " (" + addCommas(parseInt(data.replace(",", "") * metricvalue)) + " " + metric + ").<br>" + dic('Reports.SureKm') + "<font style='color:#FF6633;font-weight:bold'> " + document.getElementById("km").value + " " + metric + "</font>?</div>";
						           			$('#div-msgbox1').html(msg)
											$( "#dialog:ui-dialog" ).dialog( "destroy" );	
											$( "#dialog-message1" ).dialog({ height: 220, width: 440,
												modal: true,
										        resizable: false,
												zIndex: 10001 ,
												buttons: [{
													text: dic("yes"),
													click: function () {
														if (price != "" && desc != "" && comp != "") {
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														      $.ajax({
														              url: twopoint + "/main/InsertService.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price + "&pay=" + pay + '&tpoint=' + twopoint,
														              context: document.body,
														              success: function (data) {
																	  $("#dialog-message1").dialog("close");
														                $('#div-costMain').dialog('close');
														                if (data == 0) {
									                                    	mymsg(dic("Settings.AlreadyServiceCost"))
									                                    } else {
									                                    	mymsg(dic("Reports.SuccAddServ"))
									                                    }
								                                    	//location.reload();   
														              }
														        }); 
														        
														        $.ajax({
														              url: twopoint + "/main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km + '&tpoint=' + twopoint,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
													}},
													{
														text: dic("cancel"),
													click: function () {
														$( this ).dialog( "close" );
														document.getElementById('km').value = data;
													},
												}
												]
											});
						           		} else {
						           				if (price != "" && desc != "" && comp != "") {
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														      $.ajax({
														              url: twopoint + "/main/InsertService.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price + "&pay=" + pay + '&tpoint=' + twopoint,
														              context: document.body,
														              success: function (data) {
																	  $("#dialog-message1").dialog("close");
														               $('#div-costMain').dialog('close');
														               if (data == 0) {
									                                    	mymsg(dic("Settings.AlreadyServiceCost"))
									                                   } else {
									                                    	mymsg(dic("Reports.SuccAddServ"))
									                                   }
								                                    	//location.reload();   
														              }
														        }); 
														        
														        $.ajax({
														              url: twopoint + "/main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km + '&tpoint=' + twopoint,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
						           		}
						           		
						           	}
						           });
	           	
																		
								
            		        	} else {
            		        		 if(testSelected == "Cost") {
            		        		var dt = document.getElementById("datetime").value;
            		        		var driver = "";
                		        	if (document.getElementById("searchDri"))
	            		        		//driver = document.getElementById("driver").value;
	            		        		driver = $($('#searchDri')[0]).attr('class');
	            		        		
							        var veh;
									if (document.getElementById("searchVeh_"))
	            		        		//var veh = document.getElementById("vehictype").value;
	            		        		veh = $($('#searchVeh_')[0]).attr('class');
            		        		
							         var km = (document.getElementById("km").value).replace(/\,/g,'') / metricvalue;
							        
							        var desc = document.getElementById("desc").value;
							      
							        var comp = "";//document.getElementById("components").value;
							        for (var i=0; i < $('#components-').children().length; i++) {
										comp += ($('#components-').children()[i].id).split("main-")[1] + ";";
									}
									
							        var price = (document.getElementById("price").value).replace(/\,/g,'') * currencyvalue;
							        var pay = "";
            		        		if (document.getElementById("searchPay"))
	            		        		//driver = document.getElementById("driver").value;
	            		        		pay = $($('#searchPay')[0]).attr('class');
	            		        		
							        var loc = $($('#searchExe')[0]).attr('class')//document.getElementById("location").value;
							       
							    document.getElementById('desc').style.border = "1px solid #cccccc"
									document.getElementById('price').style.border = "1px solid #cccccc"
								
								if (desc == "") {
									alert(dic("Reports.EnterDescOthCost"))
									document.getElementById('desc').style.border = "1px solid red"
									document.getElementById('desc').select()
								}
								if (comp == "") {
										alert(dic("Reports.EnterLeastOthCost"))
										document.getElementById('div-addcomp').style.border = "1px solid red"
									}
								if (price == "") {
									alert(dic("Reports.EnterAmountOthCost"))
									document.getElementById('price').style.border = "1px solid red"
									if (liters == "") document.getElementById('liters').select()
									else document.getElementById('price').select()
								}
								
								
								
								
								$.ajax({
						           url: twopoint + '/main/CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt + '&tpoint=' + twopoint,
						           context: document.body,
						           success: function (data) {
						           		if (Math.abs(km - data.replace(",", "")) > (data.replace(",", "") * 20/100)) {
						           			var msg = "<div>" + dic('Reports.KmOdometer') + " (" + document.getElementById("km").value + " " + metric + ") " + dic('Reports.KmDifferent') + " (" + addCommas(parseInt(data.replace(",", "") * metricvalue)) + " " + metric + ").<br>" + dic('Reports.SureKm') + "<font style='color:#FF6633;font-weight:bold'> " + document.getElementById("km").value + " " + metric + "</font>?</div>";
						           			$('#div-msgbox1').html(msg)
											$( "#dialog:ui-dialog" ).dialog( "destroy" );	
											$( "#dialog-message1" ).dialog({ height: 220, width: 440,
												modal: true,
										        resizable: false,
												zIndex: 10001 ,
												buttons: {
													"Да": function() {
														if (price != "" && desc != "" && comp != "") {
														     	$.ajax({
														          url: twopoint + "/main/InsertCost.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&loc=" + loc + "&comp=" + comp + "&price=" + price + "&pay=" + pay + '&tpoint=' + twopoint,
														              context: document.body,
														              success: function (data) {
																	  $("#dialog-message1").dialog("close");
														                    $('#div-costMain').dialog('close');
														                    if (data == 0) {
										                                    	mymsg(dic("Settings.AlreadyOthCost"))
										                                    } else {
										                                    	mymsg(dic("Reports.SuccAddOthCost"))
										                                    }
														              }
														        }); 
							  																        
														        $.ajax({
														              url: twopoint + "/main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km + '&tpoint=' + twopoint,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
								                           }
													},
													"Откажи": function() {
														$( this ).dialog( "close" );
														document.getElementById('km').value = data;
													},
												}
											});
						           		} else { 
						           			if (price != "" && desc != "" && comp != "") {
											     	$.ajax({
											          url: twopoint + "/main/InsertCost.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&loc=" + loc + "&comp=" + comp + "&price=" + price + "&pay=" + pay + '&tpoint=' + twopoint,
											              context: document.body,
											              success: function (data) {
														  $("#dialog-message1").dialog("close");
											                    $('#div-costMain').dialog('close');
												                if (data == 0) {
							                                    	mymsg(dic("Settings.AlreadyOthCost"))
							                                    } else {
							                                    	mymsg(dic("Reports.SuccAddOthCost"))
							                                    }
											              }
											        }); 
				  																        
											        $.ajax({
											              url: twopoint + "/main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km + '&tpoint=' + twopoint,
											              context: document.body,
											              success: function (data) {
											    
											              }
											        }); 
					                           }
						           		}
						           	}
						           });
						           
						           
								
								  } else {
								  	if(testSelected == "0")
								  	{
								  		mymsg(dic("Reports.NotSelCost"));
								  	} else {
								  		
								  		var costtypeid = testSelected;
								  		var dt = document.getElementById("datetime").value;
								  		 var km = (document.getElementById("km").value).replace(/\,/g,'') / metricvalue;
								  		var loc = $($('#searchExe')[0]).attr('class')//document.getElementById("location").value;
								  										  		
								  		var driver = "";
	                		        	if (document.getElementById("searchDri"))
	            		        			//driver = document.getElementById("driver").value;
	            		        			driver = $($('#searchDri')[0]).attr('class');
	            		        		
	                		        	var pay = "";
	            		        		if (document.getElementById("searchPay"))
		            		        		//driver = document.getElementById("driver").value;
		            		        		pay = $($('#searchPay')[0]).attr('class');
	            		        		
                		        		var price = (document.getElementById("price").value).replace(/\,/g,'') * currencyvalue;
                		        		var veh;
										if (document.getElementById("searchVeh_"))
		            		        		//var veh = document.getElementById("vehictype").value;
		            		        		veh = $($('#searchVeh_')[0]).attr('class');
            		        		
                		        		if (price != "") {
                		        			
                		        			$.ajax({
									          url: twopoint + "/main/InsertNewCost.php?costtypeid=" + costtypeid + "&dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&loc=" + loc + "&price=" + price + "&pay=" + pay + '&tpoint=' + twopoint,
									              context: document.body,
									              success: function (data) {
														$("#dialog-message1").dialog("close");
									                   $('#div-costMain').dialog('close');
									                   if (data == 0) {
					                                    	mymsg(dic("Settings.AlreadyCost"))
					                                    } else {
					                                    	mymsg(dic("Reports.SuccAddCost"))
					                                    }
			                                    		//location.reload();
									              }
									        }); 
                		        		}	else {
                		        				alert(dic("Reports.EnterAmount"))
									document.getElementById('price').style.border = "1px solid red"
									if (liters == "") document.getElementById('liters').select()
									else document.getElementById('price').select()
                		        			}
								  	}
								  	
								  }              		        	}
            		        }
                         }
                     },
                     {
                         text: dic("cancel", '<?php echo $cLang ?>'),
                         click: function () {
                             //$('#div-cost').dialog("destroy");
                             $('#div-costMain').dialog('close');
                         }
                     }
                 ]
            });
        }
    });
}

function clearTimeOutAlertView(){
	window.clearTimeout(TimerAlarms);
}
function setTimeOutAlertView(){
	TimerAlarms = window.setTimeout("$('#div-mainalerts').fadeOut('slow');", 3000);
}
function ShowHideMail(){
    document.getElementById('div-showMessage').title = dic("Settings.MessagesNew", lang);
    if($('#div-showMessage').html() == '') {
        $('#div-showMessage').dialog({ modal: true, height: 580, width: 700, zIndex: 10000 });
        $.ajax({
            url: twopoint + '/main/MessageForm.php?l=' + lang + '&tpoint=' + twopoint,
            context: document.body,
            success: function (data) {
                top.HideWait();
                $('#div-showMessage').html(data)
                //document.getElementById('selectBtn').src = twopoint + '/images/selectVeh.png';
            }
        });
    } else {
        $('#div-showMessage').parent().css({display: 'block'});
    }
}
function ShowHideAlerts(){
	if($('#div-mainalerts').css('display') == "block")
	{
		$('#div-mainalerts').fadeOut('slow');
	} else
	{
		$('#div-mainalerts').fadeIn('slow');
		window.clearTimeout(TimerAlarms);
		TimerAlarms = window.setTimeout("$('#div-mainalerts').fadeOut('slow');", 3000);
	}
}
function opacityIn(_num){
	$('#div-alerts_'+_num).css({ opacity: '1' });
}
function opacityOut(_num){
	$('#div-alerts_'+_num).css({ opacity: '0.7' });
}
function AlertEventHide(_num, _dt, _reg, _type, _vehid){
	if (parseInt($('#alertsNew').html(), 10) <= 1)
	{
		//$('#alertsNew').css({ visibility: 'hidden' });
		//$('#alertsNew').val(0);
		//$('#div-alerts_' + _num).fadeOut('slow', function(){ $(this).remove(); });
		//$(document).attr({title: $(document).attr('title').substring($(document).attr('title').indexOf(" ")+1,$(document).attr('title').length) });
		OpenMapAlarm1(_dt , _reg, _type, _vehid, _num);
		return;
	}
	//$('#div-alerts_' + _num).fadeOut('slow', function(){ $(this).remove(); });
	//$('#alertsNew').val(parseInt($('#alertsNew').val(), 10) - 1);
	//$(document).attr({title: '('+parseInt($('#alertsNew').val(), 10)+')' + $(document).attr('title').substring($(document).attr('title').indexOf(" "),$(document).attr('title').length) });
	OpenMapAlarm1(_dt , _reg, _type, _vehid, _num);
}
function AlertEvent(_dt, _reg, _type, _vehid){
	ShowWait();
	$.ajax({
        url: twopoint + "/main/AddAlarm.php?dt=" + _dt + "&type=" + _type + "&reg=" + _reg + '&tpoint=' + twopoint,
        context: document.body,
        success: function (data) {
        	data = data.replace(/\r/g,'').replace(/\n/g,'');
        	if(data.indexOf("NotOk") == -1 || data.indexOf("Ima") != -1)
        	{
	        	_num = "1";
				if(_num == "1"){
					if (Browser() == 'iPad')
						var _op = '1';
					else
						var _op = '0.7';
					$('#div-mainalerts').fadeIn('slow');
					window.clearTimeout(TimerAlarms);
					TimerAlarms = window.setTimeout("$('#div-mainalerts').fadeOut('slow');", 3000);
					if(document.getElementById("alarms") != null)
					{
						var _idC = _vehid+"_"+_dt.split(" ")[0].split("-")[0]+"_"+_dt.split(" ")[0].split("-")[1]+"_"+_dt.split(" ")[0].split("-")[2]+"_"+_dt.split(" ")[1].split(":")[0]+"_"+_dt.split(" ")[1].split(":")[1]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[0]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[1];
						var _dtFormat = _dt.split(" ")[0].split("-")[2] + "-" + _dt.split(" ")[0].split("-")[1] + "-" + _dt.split(" ")[0].split("-")[0] + " " + _dt.split(" ")[1].split(":")[0]+":"+_dt.split(" ")[1].split(":")[1]+":"+_dt.split(" ")[1].split(":")[2].split(".")[0];
						var alertLeftList = '<div id="alarmList" style="overflow: hidden" class="div-one-vehicle-list text3 corner5" onclick="OpenMapAlarm1(\''+_dt+'\', \''+_reg+'\', \''+_type+'\', '+_vehid+', ' + ($('#alarms').children().length+1) + ')">';
						alertLeftList += '<div style="width: 91px; float:left;">';
						alertLeftList += '<div id="alarm-small-'+_idC+'" onMouseOver="ShowPopup(event, \''+dic("Tracking.Read",lang) + '/' +dic("",lang) + ' ' +dic("Tracking.Unread",lang) +' ' + dic("From",lang)+ ' ' + dic("Tracking.User",lang) +'\')" onMouseOut="HidePopup()" style="float:left; width:12px; height:12px; margin-left:5px; background-image: url(\'' + twopoint + '/images/no1.png\'); margin-top:1px; margin-bottom:2px; cursor:pointer"></div>';
						alertLeftList += '<div style="color: #000000; width: 68px; height: 14px; overflow: hidden; float:left; padding-top:2px; padding-left:3px; font-weight:bold; cursor:pointer" >'+_reg+'</div>';
						alertLeftList += '</div>';
						alertLeftList += '<div id="vh-date-" style="width:105px; position: relative; top: 2px; float:right; text-align:right; color:#000000; font-size:10px;">';
						alertLeftList += _dtFormat + '&nbsp;</div>';
						alertLeftList += '<div id="" style="background-color: #fafafa; width:205px; padding-left:5px; padding-right:5px; padding-top:2px; padding-bottom:2px; float:left; color:#333333; font-size:10px; border-top:1px dotted #333">';
						alertLeftList += dic("Tracking.Alarm",lang)+': <span style="font-weight: bold">' + dic(_type, lang) + '</span>';
						alertLeftList += '</div></div>';
						$($('#alarms').children()[0]).before(alertLeftList);
					}
					
					if ($('#alertsNew').css('visibility') == "hidden")
					{
						$('#alertsNew').css({ visibility: 'visible' });
						var mt = '';
						$('#alertsNew').html(parseInt($('#alertsNew').html(), 10) + 1);
						$(document).attr({title: '('+$('#alertsNew').html()+') '+$(document).attr('title') });
						var alertIn = '<div onmouseover="opacityIn('+parseInt($('#alertsNew').html(), 10)+')" onmouseout="opacityOut('+parseInt($('#alertsNew').html(), 10)+')" id="div-alerts_'+parseInt($('#alertsNew').html(), 10)+'" class="corner15 shadowalerts" onclick="AlertEventHide('+parseInt($('#alertsNew').html(), 10) + ',\'' +_dt + '\',\'' + _reg + '\',\'' + _type + '\',\'' + _vehid + '\')" style="display: none; cursor: pointer; color: #fff; float: left; '+mt+'; height: 80px; padding-top: 10px; padding-left: 10px; background-color: #387CB0; position: relative; opacity: ' + _op + '; width: 290px;">';
						alertIn += '<font style="font-family: arial; font-size: 18px; font-weight: bold; top: 7px; left: 35px; position: absolute;">' + _reg + '</font>';
						alertIn += '<div class="ui-icon1 ui-icon-circle-close"></div><br/>';
						if(dic(_type, lang).length > 23)
							var _points = dic(_type, lang).substring(0,23) + "...";
						else
							var _points = dic(_type, lang);
						alertIn += '<div style="font-size: 14px; width: 279px; height: 50px; position: relative; top: -8px;"><strong style="margin-left: 15px;">'+ dic("Tracking.Alarm",lang) +': </strong> <input value="' + _points + '" readonly style="width: 194px; background: transparent; border: 0px none; color: white; font-family: Verdana,Geneva,Arial,Helvetica,sans-serif;"><br />';
						alertIn += '<strong style="margin-left: 15px;position: relative; top: 5px;">'+ dic("Tracking.Date",lang)+': </strong> <font style="position: relative; top: 5px;"> ' + _dt.split(" ")[1].substring(0,_dt.split(" ")[1].indexOf("."))+" "+_dt.split(" ")[0].split("-")[2]+"-"+_dt.split(" ")[0].split("-")[1]+"-"+_dt.split(" ")[0].split("-")[0] + '</font></div></div>';
						$('#div-mainalerts').html($('#div-mainalerts').html() + alertIn);
						$('#div-alerts_'+parseInt($('#alertsNew').html(), 10)).fadeIn('slow');
					} else
					{
						var mt = 'margin-bottom: 15px';
						$('#alertsNew').html(parseInt($('#alertsNew').html(), 10) + 1);
						$(document).attr({title: '('+parseInt($('#alertsNew').html(), 10)+')' + $(document).attr('title').substring($(document).attr('title').indexOf(" "),$(document).attr('title').length) });
						var alertIn = '<div onmouseover="opacityIn('+(parseInt($('#div-mainalerts').children()[0].id.substring($('#div-mainalerts').children()[0].id.lastIndexOf("_")+1,$('#div-mainalerts').children()[0].id.length), 10)+1)+')" onmouseout="opacityOut('+(parseInt($('#div-mainalerts').children()[0].id.substring($('#div-mainalerts').children()[0].id.lastIndexOf("_")+1,$('#div-mainalerts').children()[0].id.length), 10)+1)+')" id="div-alerts_'+(parseInt($('#div-mainalerts').children()[0].id.substring($('#div-mainalerts').children()[0].id.lastIndexOf("_")+1,$('#div-mainalerts').children()[0].id.length), 10)+1)+'" class="corner15 shadowalerts" onclick="AlertEventHide('+(parseInt($('#div-mainalerts').children()[0].id.substring($('#div-mainalerts').children()[0].id.lastIndexOf("_")+1,$('#div-mainalerts').children()[0].id.length), 10)+1) + ',\'' +_dt + '\',\'' + _reg + '\',\'' + _type + '\',\'' + _vehid + '\')" style="display: none; cursor: pointer; color: #fff; float: left; '+mt+'; height: 80px; padding-top: 10px; padding-left: 10px; background-color: #387CB0; position: relative; opacity: ' + _op + '; width: 290px;">';
						alertIn += '<font style="font-family: arial; font-size: 18px; font-weight: bold; top: 7px; left: 35px; position: absolute;">' + _reg + '</font>';
						alertIn += '<div class="ui-icon1 ui-icon-circle-close"></div><br/>';
						if(dic(_type, lang).length > 23)
							var _points = dic(_type, lang).substring(0,23) + "...";
						else
							var _points = dic(_type, lang);
						alertIn += '<div style="font-size: 14px; width: 279px; height: 50px; position: relative; top: -8px;"><strong style="margin-left: 15px;">'+ dic("Tracking.Alarm",lang)+': </strong> <input value="' + _points + '" readonly style="width: 194px; background: transparent; border: 0px none; color: white; font-family: Verdana,Geneva,Arial,Helvetica,sans-serif;"><br />';
						alertIn += '<strong style="margin-left: 15px;position: relative; top: 5px;">'+dic("Tracking.Date",lang)+': </strong> <font style="position: relative; top: 5px;"> ' + _dt.split(" ")[1].substring(0,_dt.split(" ")[1].indexOf("."))+" "+_dt.split(" ")[0].split("-")[2]+"-"+_dt.split(" ")[0].split("-")[1]+"-"+_dt.split(" ")[0].split("-")[0] + '</font></div></div>';
						$('#div-alerts_'+parseInt($('#div-mainalerts').children()[0].id.substring($('#div-mainalerts').children()[0].id.lastIndexOf("_")+1,$('#div-mainalerts').children()[0].id.length), 10)).before(alertIn);
						$('#div-alerts_'+parseInt($('#div-mainalerts').children()[0].id.substring($('#div-mainalerts').children()[0].id.lastIndexOf("_")+1,$('#div-mainalerts').children()[0].id.length), 10)).fadeIn('slow');
					}
				}
			}
			snoozeTmp = snooze*60;
			pulsate10= 0;
        	HideWait();
        }
	});
	
	//startplay();
	//runEffect123('alertsNew');
	/* else
	{
		if (parseInt($('#alertsNew').val(), 10) <= 1)
		{
			$('#alertsNew').css({ visibility: 'hidden' });
			$('#alertsNew').val(0);
			$('#div-alerts_1').fadeOut('slow', function(){ $('#div-alerts_1').remove(); });
			return;
		}
		$('#div-alerts_' + parseInt($('#alertsNew').val(), 10)).fadeOut('slow', function(){ $(this).remove(); });
		$('#alertsNew').val(parseInt($('#alertsNew').val(), 10) - 1);
	}*/
}
function OpenMapAlarm(_dt, _reg, _type, _vehid){
	var _idC = _vehid+"_"+_dt.split(" ")[0].split("-")[0]+"_"+_dt.split(" ")[0].split("-")[1]+"_"+_dt.split(" ")[0].split("-")[2]+"_"+_dt.split(" ")[1].split(":")[0]+"_"+_dt.split(" ")[1].split(":")[1]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[0]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[1];
    $('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; z-index: 9999; border:0px" src=""></iframe>');
    document.getElementById('iframemaps').src = twopoint + '/main/LoadMap.php?datetime=' + _dt + '&reg=' + _reg + '&type=' + _type + '&l=' + lang + '&tpoint=' + twopoint;
    if (Browser() == 'iPad') {
    	_w = 800;
    	_h = 500;
	} else {
		_w = 1000;
    	_h = 700;
	}
    $('#dialog-map').dialog({ modal: true, height: _h, width: _w, zIndex: 9999, beforeClose: function(event, ui) {
    	if(document.getElementById("iframemaps").contentWindow.$("#alarmZabeleska").val() == '')
    	{
    		
			document.getElementById("iframemaps").contentWindow.$('#alarmZabeleska').attr({ className: 'shadow corner5' });
			document.getElementById("iframemaps").contentWindow.$('#alarmZabeleska').css({ borderColor: 'Red' });
			document.getElementById("iframemaps").contentWindow.$('#alarmZabeleska').focus();
    		msgbox("Немате внесено забелешка!!!");
    		return false;
		} else
		{
			var note = document.getElementById("iframemaps").contentWindow.$("#alarmZabeleska").val();
			$.ajax({
		        url: twopoint + "/main/UpdateNoteAndReadStatusForAlarm.php?dt=" + _dt + "&type=" + _type + "&reg=" + _reg + "&note=" + note + '&tpoint=' + twopoint,
		        context: document.body,
		        success: function (data) {
		        	$('#alarm-small-'+_idC).css({ backgroundImage: 'url("' + twopoint + '/images/yes1.png")' });
		        }
			});
		}
	} });
}
function AlertEventHide1(_num, _dt, _reg, _type, _vehid){
	if (parseInt($('#alertsNew').html(), 10) <= 1)
	{
		$('#alertsNew').css({ visibility: 'hidden' });
		$('#alertsNew').html(0);
		$('#div-alerts_' + _num).fadeOut('slow', function(){ $(this).remove(); });
		$(document).attr({title: $(document).attr('title').substring($(document).attr('title').indexOf(" ")+1,$(document).attr('title').length) });
		//OpenMapAlarm(_dt , _reg, _type, _vehid);
		return;
	}
	$('#div-alerts_' + _num).fadeOut('slow', function(){ $(this).remove(); });
	$('#alertsNew').html(parseInt($('#alertsNew').html(), 10) - 1);
	$(document).attr({title: '('+parseInt($('#alertsNew').html(), 10)+')' + $(document).attr('title').substring($(document).attr('title').indexOf(" "),$(document).attr('title').length) });
	//OpenMapAlarm(_dt , _reg, _type, _vehid);
}
function AlertEvent1(_dt, _reg, _type, _vehid, _num){
	if (Browser() == 'iPad')
		var _op = '1';
	else
		var _op = '0.7';
	window.clearTimeout(TimerAlarms);
	$('#div-mainalerts').fadeIn('slow');
	TimerAlarms = window.setTimeout("$('#div-mainalerts').fadeOut('slow');", 3000);
	if ($('#alertsNew').css('visibility') == "hidden")
	{
		$('#alertsNew').css({ visibility: 'visible' });
		var mt = 'margin-bottom: 15px';
		$('#alertsNew').html(parseInt($('#alertsNew').html(), 10) + 1);
		$(document).attr({title: '('+$('#alertsNew').html()+') '+$(document).attr('title') });
		var alertIn = '<div onmouseover="opacityIn('+parseInt(_num, 10)+')" onmouseout="opacityOut('+parseInt(_num, 10)+')" id="div-alerts_'+parseInt(_num, 10)+'" class="corner15 shadowalerts" onclick="AlertEventHide('+parseInt(_num, 10) + ',\'' +_dt + '\',\'' + _reg + '\',\'' + _type + '\',\'' + _vehid + '\')" style="display: none; cursor: pointer; color: #fff; float: left; '+mt+'; height: 80px; padding-top: 10px; padding-left: 10px; background-color: #387CB0; position: relative; opacity: ' + _op + '; width: 290px;">';
		alertIn += '<font style="font-family: arial; font-size: 18px; font-weight: bold; top: 7px; left: 35px; position: absolute;">' + _reg + '</font>';
		alertIn += '<div class="ui-icon1 ui-icon-circle-close"></div><br/>';
		if(dic(_type, lang).length > 23)
			var _points = dic(_type, lang).substring(0,23) + "...";
		else
			var _points = dic(_type, lang);
		alertIn += '<div style="font-size: 14px; width: 279px; height: 50px; position: relative; top: -8px;"><strong style="margin-left: 15px;">'+dic("Tracking.Alarm",lang)+': </strong> <input value="' + _points + '" readonly style="width: 194px; background: transparent; border: 0px none; color: white; font-family: Verdana,Geneva,Arial,Helvetica,sans-serif;"><br />';
		alertIn += '<strong style="margin-left: 15px;position: relative; top: 5px;">'+ dic("Tracking.Date",lang)+': </strong> <font style="position: relative; top: 5px;"> ' + _dt.split(" ")[1].substring(0,_dt.split(" ")[1].indexOf("."))+" "+_dt.split(" ")[0].split("-")[2]+"-"+_dt.split(" ")[0].split("-")[1]+"-"+_dt.split(" ")[0].split("-")[0] + '</font></div></div>';
		$('#div-mainalerts').html($('#div-mainalerts').html() + alertIn);
		$('#div-alerts_'+parseInt(_num, 10)).fadeIn('slow');
	} else
	{
		var mt = 'margin-bottom: 15px';
		$('#alertsNew').html(parseInt($('#alertsNew').html(), 10) + 1);
		$(document).attr({title: '('+parseInt($('#alertsNew').html(), 10)+')' + $(document).attr('title').substring($(document).attr('title').indexOf(" "),$(document).attr('title').length) });
		var alertIn = '<div onmouseover="opacityIn('+parseInt(_num, 10)+')" onmouseout="opacityOut('+parseInt(_num, 10)+')" id="div-alerts_'+parseInt(_num, 10)+'" class="corner15 shadowalerts" onclick="AlertEventHide('+parseInt(_num, 10) + ',\'' +_dt + '\',\'' + _reg + '\',\'' + _type + '\',\'' + _vehid + '\')" style="display: none; cursor: pointer; color: #fff; float: left; '+mt+'; height: 80px; padding-top: 10px; padding-left: 10px; background-color: #387CB0; position: relative; opacity: ' + _op + '; width: 290px;">';
		alertIn += '<font style="font-family: arial; font-size: 18px; font-weight: bold; top: 7px; left: 35px; position: absolute;">' + _reg + '</font>';
		alertIn += '<div class="ui-icon1 ui-icon-circle-close"></div><br/>';
		if(dic(_type, lang).length > 23)
			var _points = dic(_type, lang).substring(0,23) + "...";
		else
			var _points = dic(_type, lang);
		alertIn += '<div style="font-size: 14px; width: 279px; height: 50px; position: relative; top: -8px;"><strong style="margin-left: 15px;">'+dic("Tracking.Alarm",lang)+': </strong> <input value="' + _points +  '" readonly style="width: 194px; background: transparent; border: 0px none; color: white; font-family: Verdana,Geneva,Arial,Helvetica,sans-serif;"><br />';
		alertIn += '<strong style="margin-left: 15px;position: relative; top: 5px;">'+dic("Tracking.Date",lang)+': </strong> <font style="position: relative; top: 5px;"> ' + _dt.split(" ")[1].substring(0,_dt.split(" ")[1].indexOf("."))+" "+_dt.split(" ")[0].split("-")[2]+"-"+_dt.split(" ")[0].split("-")[1]+"-"+_dt.split(" ")[0].split("-")[0] + '</font></div></div>';
		$('#div-alerts_'+(parseInt(_num, 10)+1)).after(alertIn);
		$('#div-alerts_'+parseInt(_num, 10)).fadeIn('slow');
	}
	if(parseInt($('#alertsNew').html(), 10) == 1)
	{
		startplay();
		runEffect123('alertsNew');
	}
}
function AlertEventInit(_dt, _reg, _type, _vehid, _num){
	if (Browser() == 'iPad')
		var _op = '1';
	else
		var _op = '0.7';
	//window.clearTimeout(TimerAlarms);
	//$('#div-mainalerts').fadeIn('slow');
	//TimerAlarms = window.setTimeout("$('#div-mainalerts').fadeOut('slow');", 3000);
	if ($('#alertsNew').css('visibility') == "hidden")
	{
		$('#alertsNew').css({ visibility: 'visible' });
		var mt = 'margin-bottom: 15px';
		$('#alertsNew').html(parseInt($('#alertsNew').html(), 10) + 1);
		$(document).attr({title: '('+$('#alertsNew').html()+') '+$(document).attr('title') });
		var alertIn = '<div onmouseover="opacityIn('+parseInt(_num, 10)+')" onmouseout="opacityOut('+parseInt(_num, 10)+')" id="div-alerts_'+parseInt(_num, 10)+'" class="corner15 shadowalerts" onclick="AlertEventHide('+parseInt(_num, 10) + ',\'' +_dt + '\',\'' + _reg + '\',\'' + _type + '\',\'' + _vehid + '\')" style="display: none; cursor: pointer; color: #fff; float: left; '+mt+'; height: 80px; padding-top: 10px; padding-left: 10px; background-color: #387CB0; position: relative; opacity: ' + _op + '; width: 290px;">';
		alertIn += '<font style="font-family: arial; font-size: 18px; font-weight: bold; top: 7px; left: 35px; position: absolute;">' + _reg + '</font>';
		alertIn += '<div class="ui-icon1 ui-icon-circle-close"></div><br/>';
		if(dic(_type, lang).length > 23)
			var _points = dic(_type, lang).substring(0,23) + "...";
		else
			var _points = dic(_type, lang);
		alertIn += '<div style="font-size: 14px; width: 279px; height: 50px; position: relative; top: -8px;"><strong style="margin-left: 15px;">'+dic("Tracking.Alarm",lang)+': </strong> <input value="' + _points + '" readonly style="width: 194px; background: transparent; border: 0px none; color: white; font-family: Verdana,Geneva,Arial,Helvetica,sans-serif;"><br />';
		alertIn += '<strong style="margin-left: 15px;position: relative; top: 5px;">'+ dic("Tracking.Date",lang)+': </strong> <font style="position: relative; top: 5px;"> ' + _dt.split(" ")[1].substring(0,_dt.split(" ")[1].indexOf("."))+" "+_dt.split(" ")[0].split("-")[2]+"-"+_dt.split(" ")[0].split("-")[1]+"-"+_dt.split(" ")[0].split("-")[0] + '</font></div></div>';
		$('#div-mainalerts').html($('#div-mainalerts').html() + alertIn);
		$('#div-alerts_'+parseInt(_num, 10)).fadeIn('slow');
	} else
	{
		var mt = 'margin-bottom: 15px';
		$('#alertsNew').html(parseInt($('#alertsNew').html(), 10) + 1);
		$(document).attr({title: '('+parseInt($('#alertsNew').html(), 10)+')' + $(document).attr('title').substring($(document).attr('title').indexOf(" "),$(document).attr('title').length) });
		var alertIn = '<div onmouseover="opacityIn('+parseInt(_num, 10)+')" onmouseout="opacityOut('+parseInt(_num, 10)+')" id="div-alerts_'+parseInt(_num, 10)+'" class="corner15 shadowalerts" onclick="AlertEventHide('+parseInt(_num, 10) + ',\'' +_dt + '\',\'' + _reg + '\',\'' + _type + '\',\'' + _vehid + '\')" style="display: none; cursor: pointer; color: #fff; float: left; '+mt+'; height: 80px; padding-top: 10px; padding-left: 10px; background-color: #387CB0; position: relative; opacity: ' + _op + '; width: 290px;">';
		alertIn += '<font style="font-family: arial; font-size: 18px; font-weight: bold; top: 7px; left: 35px; position: absolute;">' + _reg + '</font>';
		alertIn += '<div class="ui-icon1 ui-icon-circle-close"></div><br/>';
		if(dic(_type, lang).length > 23)
			var _points = dic(_type, lang).substring(0,23) + "...";
		else
			var _points = dic(_type, lang);
		alertIn += '<div style="font-size: 14px; width: 279px; height: 50px; position: relative; top: -8px;"><strong style="margin-left: 15px;">'+dic("Tracking.Alarm",lang)+': </strong> <input value="' + _points + '" readonly style="width: 194px; background: transparent; border: 0px none; color: white; font-family: Verdana,Geneva,Arial,Helvetica,sans-serif;"><br />';
		alertIn += '<strong style="margin-left: 15px;position: relative; top: 5px;">'+dic("Tracking.Date",lang)+': </strong> <font style="position: relative; top: 5px;"> ' + _dt.split(" ")[1].substring(0,_dt.split(" ")[1].indexOf("."))+" "+_dt.split(" ")[0].split("-")[2]+"-"+_dt.split(" ")[0].split("-")[1]+"-"+_dt.split(" ")[0].split("-")[0] + '</font></div></div>';
		$('#div-alerts_'+(parseInt(_num, 10)+1)).after(alertIn);
		$('#div-alerts_'+parseInt(_num, 10)).fadeIn('slow');
	}
}
var pulsate10 = 0;
function runEffect123(_id) {
	if(pulsate10 == 1)
	{
		pauseplay();
		return false;
	}
	pulsate10++;
    idOfClickVeh = _id;
    // get effect type from 
    var selectedEffect = 'pulsate';

    // most effect types need no options passed by default
    var options = {};
    // some effects have required parameters
    if (selectedEffect === "scale") {
        options = { percent: 0 };
    } else if (selectedEffect === "transfer") {
        options = { to: "#button", className: "ui-effects-transfer" };
    } else if (selectedEffect === "size") {
        options = { to: { width: 200, height: 60} };
    }

    // run the effect
    $("#" + _id).effect(selectedEffect, options, 500, callback123);
    
};

// callback function to bring a hidden box back
function callback123() {
    runEffect123('alertsNew');
};

function OpenMapAlarm1(_dt, _reg, _type, _vehid, _num, _l){
	if(_l != undefined)
		lang = _l;
	var _idC = _vehid+"_"+_dt.split(" ")[0].split("-")[0]+"_"+_dt.split(" ")[0].split("-")[1]+"_"+_dt.split(" ")[0].split("-")[2]+"_"+_dt.split(" ")[1].split(":")[0]+"_"+_dt.split(" ")[1].split(":")[1]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[0]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[1];
    $('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; z-index: 9999; border:0px" src=""></iframe>');
    document.getElementById('iframemaps').src = twopoint + '/main/LoadMap.php?datetime=' + _dt + '&reg=' + _reg + '&type=' + _type + '&l=' + lang + '&num=' + _num + '&tpoint=' + twopoint;
    var _h = document.body.clientHeight - 50;
	var _w = document.body.clientWidth-200;
    $('#dialog-map').dialog({ modal: true, height: _h, width: _w, zIndex: 9999, beforeClose: function(event, ui) {
    	if(document.getElementById("iframemaps").contentWindow.$("#alarmZabeleska").val() == '')
    	{
    		document.getElementById("iframemaps").contentWindow.$('#alarmZabeleska').attr({ className: 'shadow corner5' });
			document.getElementById("iframemaps").contentWindow.$('#alarmZabeleska').css({ borderColor: 'Red' });
			document.getElementById("iframemaps").contentWindow.$('#alarmZabeleska').focus();
    		msgbox(dic("Tracking.NotEnteredNotice",lang));
    		return false;
		} else
		{
			ShowWait();
			var note = document.getElementById("iframemaps").contentWindow.$("#alarmZabeleska").val();
			$.ajax({
		        url: twopoint + "/main/UpdateNoteAndReadStatusForAlarm.php?dt=" + _dt + "&type=" + _type + "&reg=" + _reg + "&note=" + note + '&tpoint=' + twopoint,
		        context: document.body,
		        success: function (data) {
		        	if(data == "NotOk")
		        		msgbox("Алармот не е внесен прописно во базата!!!");
		        	if(document.getElementById("alarms") != null)
		        	{
			        	var c2 = 0;
			        	var c1 = 0;
			        	for(var i=0; i < $('#alarms').children().length; i++)
			        	{
			        		if($('#alarms').children()[i].children[0].children[0].id == "alarm-small-"+_idC)
			        			c1 = i;
			        		if($('#alarms').children()[i].children[0].children[0].style.backgroundImage.indexOf("yes1") != -1)
			        			c2 = i;
		        			
		        		}
		        		$('#alarms').children()[c1].attributes[0].value = $('#alarms').children()[c1].attributes[0].value.replace("OpenMapAlarm1","OpenMapAlarm2");
		        		if(c2==0)
		        			$($('#alarms').children()[$('#alarms').children().length-1]).after($($('#alarms').children()[c1]));
	        			else
		        			$($('#alarms').children()[c2]).before($($('#alarms').children()[c1]));
			        	$('#alarm-small-'+_idC).css({ backgroundImage: 'url("'+twopoint+'/images/yes1.png")' });
		        	}
		        	AlertEventHide1(_num, _dt, _reg, _type, _vehid);
		        	HideWait();
		        }
			});
		}
	} });
	
}
function OpenMapAlarm2(_dt, _reg, _type, _vehid, _num){
	var _idC = _vehid+"_"+_dt.split(" ")[0].split("-")[0]+"_"+_dt.split(" ")[0].split("-")[1]+"_"+_dt.split(" ")[0].split("-")[2]+"_"+_dt.split(" ")[1].split(":")[0]+"_"+_dt.split(" ")[1].split(":")[1]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[0]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[1];
    $('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; z-index: 9999; border:0px" src=""></iframe>');
    document.getElementById('iframemaps').src = twopoint + '/main/LoadMapZ.php?datetime=' + _dt + '&reg=' + _reg + '&type=' + _type + '&l=' + lang + '&num=' + _num + '&tpoint=' + twopoint;
    var _h = document.body.clientHeight-50;
	var _w = document.body.clientWidth-200;
    $('#dialog-map').dialog({ modal: true, height: _h, width: _w, zIndex: 9999 });
}
function OpenMapAlarm3(_dt, _reg, _type, _vehid, _num, _l){
	if(_l != undefined)
		lang = _l;;
	var _idC = _vehid+"_"+_dt.split(" ")[0].split("-")[0]+"_"+_dt.split(" ")[0].split("-")[1]+"_"+_dt.split(" ")[0].split("-")[2]+"_"+_dt.split(" ")[1].split(":")[0]+"_"+_dt.split(" ")[1].split(":")[1]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[0]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[1];
    $('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; z-index: 9999; border:0px" src=""></iframe>');
    document.getElementById('iframemaps').src = twopoint + '/report/LoadMapAlarm.php?datetime=' + _dt + '&reg=' + _reg + '&type=' + _type + '&l=' + lang + '&num=' + _num + '&tpoint=' + twopoint;
    var _h = document.body.clientHeight-10;
	var _w = document.body.clientWidth-100;
    $('#dialog-map').dialog({ modal: true, height: _h, width: _w, zIndex: 9999 });
}

function snoozeAlarm() {
	if(snoozeTmp == (snooze*60))
	{
		if(parseInt($('#alertsNew').html(), 10) == 0)
		{
			snoozeTmp = 0;
			setTimeout("snoozeAlarm()", 1000);
		} else
		{
			startplay();
			runEffect123('alertsNew');
		}
	} else
	{
		snoozeTmp++;
		setTimeout("snoozeAlarm()", 1000);
	}
}

function pauseplay()
{
	soundHandle = document.getElementById('soundHandle');
  	soundHandle.pause();
  	pulsate10 = 0;
  	snoozeTmp = 0;
  	snoozeAlarm();
}
function startplay()
{
	soundHandle = document.getElementById('soundHandle');
  	soundHandle.src = twopoint + '/tracking/sound/Small_Blink.ogg';
  	soundHandle.play();
}

function closedialog()
{
	$('#dialog-map').dialog('destroy');
}
function msgbox(msg) {
    $("#DivInfoForAll").css({ display: 'none' });
    $('#div-msgbox').html(msg)
    $("#dialog:ui-dialog").dialog("destroy");
    $("#dialog-message").dialog({
        modal: true,
        zIndex: 10003, resizable: false,
        buttons: {
            Ok: function () {
                $(this).dialog("close");
            }
        }
    });
}
function setDates2() {
   /* $('#datetime').datetimepicker({
        dateFormat: 'dd-mm-yy',
        showOn: "button",
        buttonImage: "../images/cal1.png",
        buttonImageOnly: true,
        hourGrid: 4,
        minuteGrid: 10
    });*/
   
   //old
   /*$('#datetime').datepicker({
            dateFormat: 'dd-mm-yy',
            showOn: "button",
            buttonImage: twopoint + "/images/cal1.png",
            buttonImageOnly: true,
	  	    firstDay: 1,
	  		dayNamesMin: [dic("Reports.Su", lang1), dic("Reports.Mo", lang1), dic("Reports.Tu", lang1), dic("Reports.We", lang1), dic("Reports.Th", lang1), dic("Reports.Fr", lang1), dic("Reports.Sa", lang1)], 
	    	monthNames: [dic("Reports.January", lang1), dic("Reports.February", lang1), dic("Reports.March", lang1), dic("Reports.April", lang1), dic("Reports.May", lang1), dic("Reports.June", lang1), dic("Reports.July", lang1), dic("Reports.August", lang1), dic("Reports.September", lang1), dic("Reports.October", lang1), dic("Reports.November", lang1), dic("Reports.December", lang1)],
   });*/
        
   $('#datetime').datetimepicker({
            dateFormat: 'dd-mm-yy',
            timeFormat: 'hh:mm:00',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            monthNames: [dic("Reports.January", lang1), dic("Reports.February", lang1), dic("Reports.March", lang1), dic("Reports.April", lang1), dic("Reports.May", lang1), dic("Reports.June", lang1), dic("Reports.July", lang1), dic("Reports.August", lang1), dic("Reports.September", lang1), dic("Reports.October", lang1), dic("Reports.November", lang1), dic("Reports.December", lang1)], dayNamesMin: [dic("Reports.Su", lang1), dic("Reports.Mo", lang1), dic("Reports.Tu", lang1), dic("Reports.We", lang1), dic("Reports.Th", lang1), dic("Reports.Fr", lang1), dic("Reports.Sa", lang1)], firstDay: 1,
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
   });
}
function CarTypeNotify(_vehid, _reg){
	this.vehid = _vehid
	this.reg = _reg
	this.map0 = true
	this.same = false
	this.alarm = '';
	this.fulldt = '&nbsp;';
}
function ParseCarStrNotify(str) {
    var c = str.split("#");
    for (var i=1; i < c.length; i++){
		var p = c[i].split("|");
		var _car = new CarTypeNotify(p[0], p[1]);
		CarNotify[CarNotify.length] = _car;
	}
}
function ParseCarStrAjaxNotify(str) {
	if(CarNotify.length == 0)
		ParseCarStrNotify(str);
    var c = str.split("#");
	for (var i=1; i < c.length; i++){
		var p = c[i].split("|");
		var _car = new CarTypeNotify(p[0], p[1]);
		_car.alarm = p[2];
		_car.fulldt = p[3];
		for (var j =0; j< CarNotify.length; j++){
			if (CarNotify[j].vehid == p[0]) {
				var m0 = CarNotify[j].map0;
				if (_car.fulldt == CarNotify[j].fulldt){
					_car.same = true;
				} else {
					_car.same = false;
				}
				_car.map0 = m0; 	
				CarNotify[j] = _car;
				break;
			}
		}
	}
}
function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function AjaxNotify() {
    var _page = twopoint + '/main/getNotify.php?tpoint=' + twopoint;
	var xmlHttp;
	var str = '';
	try { xmlHttp = new XMLHttpRequest(); } catch (e) {
		try
	  { xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); }
		catch (e) { try { xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) { alert("Your browser does not support AJAX!"); return false; } }
	}
	xmlHttp.onreadystatechange = function () {
	    if (xmlHttp.readyState == 4) {
	        str = xmlHttp.responseText;
	        ParseCarStrAjaxNotify(str);
	        for (var j = 0; j < CarNotify.length; j++) {
	        	if(AlarmsTypeArray.indexOf("," + CarNotify[j].alarm + ",") != -1)
	        		//if(!CarNotify[j].same)
	        			AlertEvent(CarNotify[j].fulldt, CarNotify[j].reg, CarNotify[j].alarm, CarNotify[j].vehid);
    		}
			setTimeout("AjaxNotify();", 3000);
	    }
	}
	xmlHttp.open("GET", _page, true);
	xmlHttp.send(null);
}

function AjaxMessageNotify() {
	 var _page = twopoint + '/main/getNoUnread.php?tpoint=' + twopoint;
	var xmlHttp;
	var str = '';
	try { xmlHttp = new XMLHttpRequest(); } catch (e) {
		try
	  { xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); }
		catch (e) { try { xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e) { alert("Your browser does not support AJAX!"); return false; } }
	}
	xmlHttp.onreadystatechange = function () {
	    if (xmlHttp.readyState == 4) {
	        str = xmlHttp.responseText;
		if (str == 0) {
			$('#mailNew').css({ visibility: 'hidden' });
            $('#mailNew').html(str.replace(/\n/g, '').replace(/\r/g, ''));
		} else {
		    $('#mailNew').css({ visibility: 'visible' });
		    if(str.replace(/\n/g, '').replace(/\r/g, '') != $('#mailNew').html().replace(/\n/g, '').replace(/\r/g, '')) {
		        $('#mailNew').html(str.replace(/\n/g, '').replace(/\r/g, ''));
	            ReloadIncomingMess();
		    }
		}
	        setTimeout("AjaxMessageNotify();", 3000);
	    }
	}
	xmlHttp.open("GET", _page, true);
	xmlHttp.send(null);
}
function ReloadIncomingMess() {
    if($('#incomingmessages')[0] != undefined) {
        $('#incomingmessages').load('../main/ReloadIncomingMess.php');
    }
}
function ReloadOutgoingMess() {
    if($('#outgoingmessages')[0] != undefined) {
        $('#outgoingmessages').load('../main/ReloadOutgoingMess.php');
    }
}
function HideShowTopPanel(cntTP){
	if (TopPanelVisible==true) {
		var bh = document.body.clientHeight - 55 - 50
		var hStep = bh/5
		if (cntTP!=5){
			cntTP = cntTP + 1
			document.getElementById('top1').style.height= (hStep*cntTP) +'px'
			document.getElementById('topmiddle1').style.height= (hStep*cntTP)+'px'
			setTimeout("HideShowTopPanel("+cntTP+")",20);
		} else {
			document.getElementById('top1').style.height= bh +'px'
			document.getElementById('topmiddle1').style.height= bh+'px'
			document.getElementById('strelkatop').style.backgroundImage='URL(../images/gores.png)'
			TopPanelVisible = false;
			document.getElementById('iFrmS').style.height = (document.getElementById('topmiddle1').offsetHeight) + 'px'
			document.getElementById('iFrmS').style.display = ''
			//document.getElementById('iFrmS').src = document.getElementById('iFrmS').src
		}
	} else {
		var bh = document.body.clientHeight - 55 - 50
		var hStep = bh/5
		if (cntTP!=5){
			cntTP = cntTP + 1
			var tmp = 5-cntTP
			document.getElementById('iFrmS').style.display = 'none'
			document.getElementById('top1').style.height= (hStep*tmp) +'px'
			//document.getElementById('top1').style.height= (hStep*tmp) +'5px'
			document.getElementById('topmiddle1').style.height= (hStep*tmp)+'px'
			setTimeout("HideShowTopPanel("+cntTP+")",20)	
		} else {
			document.getElementById('top1').style.height= '5px'
			document.getElementById('topmiddle1').style.height= '1px'	
			document.getElementById('strelkatop').style.backgroundImage='URL(../images/dolus.png)'
			TopPanelVisible = true;
			
		}
	}
}
