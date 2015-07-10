// JavaScript Document

var TimerAlarms;
var snooze = 10;
var CarNotify = [];
var AlarmsTypeArray = ",assistance,acumulator,vehicleAlarm,fuelCap,suddenBraking,speedExcess,enterZone,leaveZone,visitPOI,stayMoreThanAllow,stayOutOfLocat,leaveRoute,pause,regExpire,service,greenCard,polnomLicense,agreement,unauthorizedUseVehicle,NoRFIDVehicle,VehicleDefect,unOrdered,alarmpanic,HalfHourNoDataIgnON,acumulatorPowerSupplyInterruption,";

function costVehicleW (i, id, reg) {
	document.getElementById('div-costMain').title = "Додавање трошок - " + reg;
	ShowWait()
	$.ajax({
        url: '../main/AddCostW.php?l=' + lang + '&vehid=' + id,
        context: document.body,
        success: function (data) {
        	HideWait();
            $('#div-costMain').html(data);
            $('#div-costMain').dialog({ modal: true, height: 680, width: 510,
							zIndex: 10000 ,
                buttons:
                 [
                     {
                         text: dic("add", '<?php echo $cLang ?>'),
                         click: function () {
                         	
                         	if($("#costtype").children(":selected").attr("id") == "0")
						  	{
						  		mymsg("Немате избрано ниту еден трошок за внес !!!");
						  		return false;
						  	}
						  	
            		        if($("#costtype").children(":selected").attr("id") == "Fuel") {
            		        	var dt = document.getElementById("datetime").value;
            		        	var driver = "";
            		        	if (document.getElementById("driver"))
            		        		driver = document.getElementById("driver").value;
	                            var km = (document.getElementById("km").value).replace(",", "");
	                            var liters = document.getElementById("liters").value;
	                            var litersLast = document.getElementById("litersLast").value;
	                            var price = (document.getElementById("price").value).replace(",", "");
								var veh = id;
								var pay = document.getElementById("pay").value;
								var loc = document.getElementById("location").value;
								
								//alert("InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&price=" + price + "&vehID=" + veh)
								document.getElementById('liters').style.border = "1px solid #cccccc"
								document.getElementById('price').style.border = "1px solid #cccccc"
								
								if (liters == "") {
									alert("Внесете дотур на гориво !!!")
									document.getElementById('liters').style.border = "1px solid red"
									document.getElementById('liters').select()
								}
								if (price == "") {
									alert("Внесете износ на трошокот за гориво !!!")
									document.getElementById('price').style.border = "1px solid red"
									if (liters == "") document.getElementById('liters').select()
									else document.getElementById('price').select()
								}
								
								
								
	                          
	                          $.ajax({
						           url: '../main/CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt,
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
														if (price != "" && liters != "") {
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														      $.ajax({
		                                url: "../main/InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&loc=" + loc + "&price=" + price + "&vehID=" + veh + '&pay=' + pay,
		                                context: document.body,
		                                success: function (data) {
		                                    $(this).dialog("close");
		                                    mymsg("Успешно додадовте трошок за гориво !!!")
		                                    location.reload();
		                                }
		                            });
														        
														        $.ajax({
														              url: "../main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
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
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														     $.ajax({
		                                url: "../main/InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&loc=" + loc + "&price=" + price + "&vehID=" + veh + '&pay=' + pay,
		                                context: document.body,
		                                success: function (data) {
		                                    $(this).dialog("close");
		                                    mymsg("Успешно додадовте трошок за гориво !!!")
		                                    location.reload();
		                                }
		                            }); 
														        
														        $.ajax({
														              url: "../main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
						           		}
						           		
						           	}
						           });
	                          
	                          
	                          
            		        } else {
            		        	if ($("#costtype").children(":selected").attr("id") == "Service") {
            		        		var dt = document.getElementById("datetime").value;
            		        		var driver = "";
                		        	if (document.getElementById("driver"))
                		        		driver = document.getElementById("driver").value;
							        var veh = id;
							        var km = (document.getElementById("km").value).replace(",", "");
							        var type = $('input[name=type]:radio:checked').val();
							        var loc = document.getElementById("location").value;
							        var desc = document.getElementById("desc").value;
							        //var comp = document.getElementById("components").value;
							        var comp= "";
							        for (var i=0; i < $('#components-').children().length; i++) {
										comp += ($('#components-').children()[i].id).split("li-")[1] + ";";
									}
							        var price = (document.getElementById("price").value).replace(",", "");
							        var pay = document.getElementById("pay").value;
							        
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
						           url: '../main/CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt,
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
														              url: "../main/InsertService.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
														              context: document.body,
														              success: function (data) {
														                $(this).dialog("close");
														                mymsg("Успешно додадовте трошок за сервис !!!")
								                                    	location.reload();   
														              }
														        }); 
														        
														        $.ajax({
														              url: "../main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
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
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														      $.ajax({
														              url: "../main/InsertService.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
														              context: document.body,
														              success: function (data) {
														                $(this).dialog("close");
														                mymsg("Успешно додадовте трошок за сервис !!!")
								                                    	location.reload();   
														              }
														        }); 
														        
														        $.ajax({
														              url: "../main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
						           		}
						           		
						           	}
						           });
	           	
																		
								
            		        	} else {
            		        		 if($("#costtype").children(":selected").attr("id") == "Cost") {
            		        		var dt = document.getElementById("datetime").value;
            		        		var driver = "";
                		        	if (document.getElementById("driver"))
                		        		driver = document.getElementById("driver").value;
							        var veh = id;
							        var km = (document.getElementById("km").value).replace(",", "");
							        var desc = document.getElementById("desc").value;
							        var comp = "";//document.getElementById("components").value;
							        for (var i=0; i < $('#components-').children().length; i++) {
										comp += ($('#components-').children()[i].id).split("li-")[1] + ";";
									}
									
							        var price = (document.getElementById("price").value).replace(",", "");
							        var pay = document.getElementById("pay").value;
							        var loc = document.getElementById("location").value;
							        
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
						           url: '../main/CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt,
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
																																
																//alert("InsertCost.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&comp=" + htmlstring + "&price=" + price + "&pay=" + pay)
														     	$.ajax({
														          url: "../main/InsertCost.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&loc=" + loc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
														              context: document.body,
														              success: function (data) {
														                    $(this).dialog("close");
														                    mymsg("Успешно додадовте останат трошок !!!")
								                                    		location.reload();
														              }
														        }); 
							  																        
														        $.ajax({
														              url: "../main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
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
																																
													//alert("InsertCost.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&comp=" + htmlstring + "&price=" + price + "&pay=" + pay)
											     	$.ajax({
											          url: "../main/InsertCost.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&loc=" + loc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
											              context: document.body,
											              success: function (data) {
											                    $(this).dialog("close");
											                    mymsg("Успешно додадовте останат трошок !!!")
					                                    		location.reload();
											              }
											        }); 
				  																        
											        $.ajax({
											              url: "../main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
											              context: document.body,
											              success: function (data) {
											    
											              }
											        }); 
											        
					                           }
						           		}
						           		
						           	}
						           });
						           
						           
								
								  } else {
								  	if($("#costtype").children(":selected").attr("id") == "0")
								  	{
								  		mymsg("Немате избрано ниту еден трошок за внес !!!");
								  	} else {
								  		var costtypeid = $("#costtype").children(":selected").attr("id");
								  		var dt = document.getElementById("datetime").value;
								  		var km = (document.getElementById("km").value).replace(",", "");
								  		var loc = document.getElementById("location").value;
								  		var driver = "";
	                		        	if (document.getElementById("driver"))
	                		        		driver = document.getElementById("driver").value;
	                		        	var pay = document.getElementById("pay").value;
                		        		var price = (document.getElementById("price").value).replace(",", "");
                		        		var veh = id;
                		        		if (price != "") {
                		        			$.ajax({
									          url: "../main/InsertNewCost.php?costtypeid=" + costtypeid + "&dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&loc=" + loc + "&price=" + price + "&pay=" + pay,
									              context: document.body,
									              success: function (data) {
									                    $(this).dialog("close");
									                    mymsg("Успешно додадовте трошок !!!")
			                                    		location.reload();
									              }
									        }); 
                		        		}	else {
                		        			alert("Внесете износ на трошокот !!!")
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
	document.getElementById('div-costMain').title = "Додавање трошок";
	ShowWait();
	$.ajax({
        url: '../main/AddCost.php?l=' + lang + '&vehid=' + id,
        context: document.body,
        success: function (data) {
        	HideWait();
            $('#div-costMain').html(data);
            $('#div-costMain').dialog({ modal: true, height: 680, width: 510,
							zIndex: 10000 ,
                buttons:
                 [
                     {
                         text: dic("add", '<?php echo $cLang ?>'),
                         click: function () {
                         	if($("#costtype").children(":selected").attr("id") == "0")
						  	{
						  		mymsg("Немате избрано ниту еден трошок за внес !!!");
						  		return false;
						  	}
            		        if($("#costtype").children(":selected").attr("id") == "Fuel") {
            		        	var dt = document.getElementById("datetime").value;
            		        	var driver = "";
            		        	if (document.getElementById("driver"))
            		        		driver = document.getElementById("driver").value;
	                            var km = (document.getElementById("km").value).replace(",", "");
	                            var liters = document.getElementById("liters").value;
	                            var litersLast = document.getElementById("litersLast").value;
	                            var price = (document.getElementById("price").value).replace(",", "");
								var veh = document.getElementById("vehictype").value;
								
								var pay = document.getElementById("pay").value;
								var loc = document.getElementById("location").value;
								
								//alert("InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&price=" + price + "&vehID=" + veh)
								document.getElementById('liters').style.border = "1px solid #cccccc"
								document.getElementById('price').style.border = "1px solid #cccccc"
								
								if (liters == "") {
									alert("Внесете дотур на гориво !!!")
									document.getElementById('liters').style.border = "1px solid red"
									document.getElementById('liters').select()
								}
								if (price == "") {
									alert("Внесете износ на трошокот за гориво !!!")
									document.getElementById('price').style.border = "1px solid red"
									if (liters == "") document.getElementById('liters').select()
									else document.getElementById('price').select()
								}
								
								
								
	                          
	                          $.ajax({
						           url: '../main/CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt,
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
														if (price != "" && liters != "") {
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														      $.ajax({
		                                url: "../main/InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&loc=" + loc + "&price=" + price + "&vehID=" + veh + '&pay=' + pay,
		                                context: document.body,
		                                success: function (data) {
		                                    $(this).dialog("close");
		                                    mymsg("Успешно додадовте трошок за гориво !!!")
		                                    location.reload();
		                                }
		                            });
														        
														        $.ajax({
														              url: "../main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
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
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														     $.ajax({
		                                url: "../main/InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&loc=" + loc + "&price=" + price + "&vehID=" + veh + '&pay=' + pay,
		                                context: document.body,
		                                success: function (data) {
		                                    $(this).dialog("close");
		                                    mymsg("Успешно додадовте трошок за гориво !!!")
		                                    location.reload();
		                                }
		                            }); 
														        
														        $.ajax({
														              url: "../main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
						           		}
						           		
						           	}
						           });
	                          
	                          
	                          
            		        } else {
            		        	if ($("#costtype").children(":selected").attr("id") == "Service") {
            		        		var dt = document.getElementById("datetime").value;
            		        		var driver = "";
                		        	if (document.getElementById("driver"))
                		        		driver = document.getElementById("driver").value;
							        var veh = id;
							        var km = (document.getElementById("km").value).replace(",", "");
							        var type = $('input[name=type]:radio:checked').val();
							        var loc = document.getElementById("location").value;
							        var desc = document.getElementById("desc").value;
							        //var comp = document.getElementById("components").value;
							        var comp= "";
							        for (var i=0; i < $('#components-').children().length; i++) {
										comp += ($('#components-').children()[i].id).split("li-")[1] + ";";
									}
							        var price = (document.getElementById("price").value).replace(",", "");
							        var pay = document.getElementById("pay").value;
							        
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
						           url: '../main/CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt,
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
														              url: "../main/InsertService.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
														              context: document.body,
														              success: function (data) {
														                $(this).dialog("close");
														                mymsg("Успешно додадовте трошок за сервис !!!")
								                                    	location.reload();   
														              }
														        }); 
														        
														        $.ajax({
														              url: "../main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
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
																
														      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
														      $.ajax({
														              url: "../main/InsertService.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
														              context: document.body,
														              success: function (data) {
														                $(this).dialog("close");
														                mymsg("Успешно додадовте трошок за сервис !!!")
								                                    	location.reload();   
														              }
														        }); 
														        
														        $.ajax({
														              url: "../main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
														              context: document.body,
														              success: function (data) {
														    
														              }
														        }); 
														        
								                           }
						           		}
						           		
						           	}
						           });
	           	
																		
								
            		        	} else {
            		        		 if($("#costtype").children(":selected").attr("id") == "Cost") {
            		        		var dt = document.getElementById("datetime").value;
            		        		var driver = "";
                		        	if (document.getElementById("driver"))
                		        		driver = document.getElementById("driver").value;
							        var veh = id;
							        var km = (document.getElementById("km").value).replace(",", "");
							        var desc = document.getElementById("desc").value;
							        var comp = "";//document.getElementById("components").value;
							        for (var i=0; i < $('#components-').children().length; i++) {
										comp += ($('#components-').children()[i].id).split("li-")[1] + ";";
									}
									
							        var price = (document.getElementById("price").value).replace(",", "");
							        var pay = document.getElementById("pay").value;
							        var loc = document.getElementById("location").value;
							        
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
						           url: '../main/CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt,
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
																																
																//alert("InsertCost.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&comp=" + htmlstring + "&price=" + price + "&pay=" + pay)
														     	$.ajax({
														          url: "../main/InsertCost.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&loc=" + loc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
														              context: document.body,
														              success: function (data) {
														                    $(this).dialog("close");
														                    mymsg("Успешно додадовте останат трошок !!!")
								                                    		location.reload();
														              }
														        }); 
							  																        
														        $.ajax({
														              url: "../main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
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
																																
													//alert("InsertCost.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&comp=" + htmlstring + "&price=" + price + "&pay=" + pay)
											     	$.ajax({
											          url: "../main/InsertCost.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&loc=" + loc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
											              context: document.body,
											              success: function (data) {
											                    $(this).dialog("close");
											                    mymsg("Успешно додадовте останат трошок !!!")
					                                    		location.reload();
											              }
											        }); 
				  																        
											        $.ajax({
											              url: "../main/SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
											              context: document.body,
											              success: function (data) {
											    
											              }
											        }); 
											        
					                           }
						           		}
						           		
						           	}
						           });
						           
						           
								
								  } else {
								  	if($("#costtype").children(":selected").attr("id") == "0")
								  	{
								  		mymsg("Немате избрано ниту еден трошок за внес !!!");
								  	} else {
								  		var costtypeid = $("#costtype").children(":selected").attr("id");
								  		var dt = document.getElementById("datetime").value;
								  		var km = (document.getElementById("km").value).replace(",", "");
								  		var loc = document.getElementById("location").value;
								  		var driver = "";
	                		        	if (document.getElementById("driver"))
	                		        		driver = document.getElementById("driver").value;
	                		        	var pay = document.getElementById("pay").value;
                		        		var price = (document.getElementById("price").value).replace(",", "");
                		        		var veh = id;
                		        		if (price != "") {
                		        			$.ajax({
									          url: "../main/InsertNewCost.php?costtypeid=" + costtypeid + "&dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&loc=" + loc + "&price=" + price + "&pay=" + pay,
									              context: document.body,
									              success: function (data) {
									                    $(this).dialog("close");
									                    mymsg("Успешно додадовте трошок !!!")
			                                    		location.reload();
									              }
									        }); 
                		        		}	else {
                		        			alert("Внесете износ на трошокот !!!")
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

function clearTimeOutAlertView(){
	window.clearTimeout(TimerAlarms);
}
function setTimeOutAlertView(){
	TimerAlarms = window.setTimeout("$('#div-mainalerts').fadeOut('slow');", 3000);
}
function ShowHideMail(){
	
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
	if (parseInt($('#alertsNew').val(), 10) <= 1)
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
        url: "../main/AddAlarm.php?dt=" + _dt + "&type=" + _type + "&reg=" + _reg,
        context: document.body,
        success: function (data) {
        	if(data.indexOf("NotOk") == -1)
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
						alertLeftList += '<div id="alarm-small-'+_idC+'" onMouseOver="ShowPopup(event, \''+dic("Tracking.Read",lang) + '/' +dic("",lang) + ' ' +dic("Tracking.Unread",lang) +' ' + dic("From",lang)+ ' ' + dic("Tracking.User",lang) +'\')" onMouseOut="HidePopup()" style="float:left; width:12px; height:12px; margin-left:5px; background-image: url(\'../images/no1.png\'); margin-top:1px; margin-bottom:2px; cursor:pointer"></div>';
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
						$('#alertsNew').val(parseInt($('#alertsNew').val(), 10) + 1);
						$(document).attr({title: '('+$('#alertsNew').val()+') '+$(document).attr('title') });
						var alertIn = '<div onmouseover="opacityIn('+parseInt($('#alertsNew').val(), 10)+')" onmouseout="opacityOut('+parseInt($('#alertsNew').val(), 10)+')" id="div-alerts_'+parseInt($('#alertsNew').val(), 10)+'" class="corner15 shadowalerts" onclick="AlertEventHide('+parseInt($('#alertsNew').val(), 10) + ',\'' +_dt + '\',\'' + _reg + '\',\'' + _type + '\',\'' + _vehid + '\')" style="display: none; cursor: pointer; color: #fff; float: left; '+mt+'; height: 80px; padding-top: 10px; padding-left: 10px; background-color: #387CB0; position: relative; opacity: ' + _op + '; width: 290px;">';
						alertIn += '<font style="font-family: arial; font-size: 18px; font-weight: bold; top: 7px; left: 35px; position: absolute;">' + _reg + '</font>';
						alertIn += '<div class="ui-icon1 ui-icon-circle-close"></div><br/>';
						alertIn += '<div style="font-size: 14px; width: 279px; height: 50px; position: relative; top: -8px;"><strong style="margin-left: 15px;">'+ dic("Tracking.Alarm",lang) +': </strong> <input value="' + dic(_type, lang) + '" readonly style="width: 181px; background: transparent; border: 0px none; color: white; font-family: Verdana,Geneva,Arial,Helvetica,sans-serif;"><br />';
						alertIn += '<strong style="margin-left: 15px;position: relative; top: 5px;">'+ dic("Tracking.Date",lang)+': </strong> <font style="position: relative; top: 5px;"> ' + _dt.split(" ")[1].substring(0,_dt.split(" ")[1].indexOf("."))+" "+_dt.split(" ")[0].split("-")[2]+"-"+_dt.split(" ")[0].split("-")[1]+"-"+_dt.split(" ")[0].split("-")[0] + '</font></div></div>';
						$('#div-mainalerts').html($('#div-mainalerts').html() + alertIn);
						$('#div-alerts_'+parseInt($('#alertsNew').val(), 10)).fadeIn('slow');
					} else
					{
						var mt = 'margin-bottom: 15px';
						$('#alertsNew').val(parseInt($('#alertsNew').val(), 10) + 1);
						$(document).attr({title: '('+parseInt($('#alertsNew').val(), 10)+')' + $(document).attr('title').substring($(document).attr('title').indexOf(" "),$(document).attr('title').length) });
						var alertIn = '<div onmouseover="opacityIn('+(parseInt($('#div-mainalerts').children()[0].id.substring($('#div-mainalerts').children()[0].id.lastIndexOf("_")+1,$('#div-mainalerts').children()[0].id.length), 10)+1)+')" onmouseout="opacityOut('+(parseInt($('#div-mainalerts').children()[0].id.substring($('#div-mainalerts').children()[0].id.lastIndexOf("_")+1,$('#div-mainalerts').children()[0].id.length), 10)+1)+')" id="div-alerts_'+(parseInt($('#div-mainalerts').children()[0].id.substring($('#div-mainalerts').children()[0].id.lastIndexOf("_")+1,$('#div-mainalerts').children()[0].id.length), 10)+1)+'" class="corner15 shadowalerts" onclick="AlertEventHide('+(parseInt($('#div-mainalerts').children()[0].id.substring($('#div-mainalerts').children()[0].id.lastIndexOf("_")+1,$('#div-mainalerts').children()[0].id.length), 10)+1) + ',\'' +_dt + '\',\'' + _reg + '\',\'' + _type + '\',\'' + _vehid + '\')" style="display: none; cursor: pointer; color: #fff; float: left; '+mt+'; height: 80px; padding-top: 10px; padding-left: 10px; background-color: #387CB0; position: relative; opacity: ' + _op + '; width: 290px;">';
						alertIn += '<font style="font-family: arial; font-size: 18px; font-weight: bold; top: 7px; left: 35px; position: absolute;">' + _reg + '</font>';
						alertIn += '<div class="ui-icon1 ui-icon-circle-close"></div><br/>';
						alertIn += '<div style="font-size: 14px; width: 279px; height: 50px; position: relative; top: -8px;"><strong style="margin-left: 15px;">Аларм: </strong> <input value="' + dic(_type, lang) + '" readonly style="width: 181px; background: transparent; border: 0px none; color: white; font-family: Verdana,Geneva,Arial,Helvetica,sans-serif;"><br />';
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
    document.getElementById('iframemaps').src = '../main/LoadMap.php?datetime=' + _dt + '&reg=' + _reg + '&type=' + _type + '&l=' + lang;
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
		        url: "../main/UpdateNoteAndReadStatusForAlarm.php?dt=" + _dt + "&type=" + _type + "&reg=" + _reg + "&note=" + note,
		        context: document.body,
		        success: function (data) {
		        	$('#alarm-small-'+_idC).css({ backgroundImage: 'url("../images/yes1.png")' });
		        }
			});
		}
	} });
}
function AlertEventHide1(_num, _dt, _reg, _type, _vehid){
	if (parseInt($('#alertsNew').val(), 10) <= 1)
	{
		$('#alertsNew').css({ visibility: 'hidden' });
		$('#alertsNew').val(0);
		$('#div-alerts_' + _num).fadeOut('slow', function(){ $(this).remove(); });
		$(document).attr({title: $(document).attr('title').substring($(document).attr('title').indexOf(" ")+1,$(document).attr('title').length) });
		//OpenMapAlarm(_dt , _reg, _type, _vehid);
		return;
	}
	$('#div-alerts_' + _num).fadeOut('slow', function(){ $(this).remove(); });
	$('#alertsNew').val(parseInt($('#alertsNew').val(), 10) - 1);
	$(document).attr({title: '('+parseInt($('#alertsNew').val(), 10)+')' + $(document).attr('title').substring($(document).attr('title').indexOf(" "),$(document).attr('title').length) });
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
		$('#alertsNew').val(parseInt($('#alertsNew').val(), 10) + 1);
		$(document).attr({title: '('+$('#alertsNew').val()+') '+$(document).attr('title') });
		var alertIn = '<div onmouseover="opacityIn('+parseInt(_num, 10)+')" onmouseout="opacityOut('+parseInt(_num, 10)+')" id="div-alerts_'+parseInt(_num, 10)+'" class="corner15 shadowalerts" onclick="AlertEventHide('+parseInt(_num, 10) + ',\'' +_dt + '\',\'' + _reg + '\',\'' + _type + '\',\'' + _vehid + '\')" style="display: none; cursor: pointer; color: #fff; float: left; '+mt+'; height: 80px; padding-top: 10px; padding-left: 10px; background-color: #387CB0; position: relative; opacity: ' + _op + '; width: 290px;">';
		alertIn += '<font style="font-family: arial; font-size: 18px; font-weight: bold; top: 7px; left: 35px; position: absolute;">' + _reg + '</font>';
		alertIn += '<div class="ui-icon1 ui-icon-circle-close"></div><br/>';
		alertIn += '<div style="font-size: 14px; width: 279px; height: 50px; position: relative; top: -8px;"><strong style="margin-left: 15px;">'+dic("Tracking.Alarm",lang)+': </strong> <input value="' + dic(_type, lang) + '" readonly style="width: 181px; background: transparent; border: 0px none; color: white; font-family: Verdana,Geneva,Arial,Helvetica,sans-serif;"><br />';
		alertIn += '<strong style="margin-left: 15px;position: relative; top: 5px;">'+ dic("Tracking.Date",lang)+': </strong> <font style="position: relative; top: 5px;"> ' + _dt.split(" ")[1].substring(0,_dt.split(" ")[1].indexOf("."))+" "+_dt.split(" ")[0].split("-")[2]+"-"+_dt.split(" ")[0].split("-")[1]+"-"+_dt.split(" ")[0].split("-")[0] + '</font></div></div>';
		$('#div-mainalerts').html($('#div-mainalerts').html() + alertIn);
		$('#div-alerts_'+parseInt(_num, 10)).fadeIn('slow');
	} else
	{
		var mt = 'margin-bottom: 15px';
		$('#alertsNew').val(parseInt($('#alertsNew').val(), 10) + 1);
		$(document).attr({title: '('+parseInt($('#alertsNew').val(), 10)+')' + $(document).attr('title').substring($(document).attr('title').indexOf(" "),$(document).attr('title').length) });
		var alertIn = '<div onmouseover="opacityIn('+parseInt(_num, 10)+')" onmouseout="opacityOut('+parseInt(_num, 10)+')" id="div-alerts_'+parseInt(_num, 10)+'" class="corner15 shadowalerts" onclick="AlertEventHide('+parseInt(_num, 10) + ',\'' +_dt + '\',\'' + _reg + '\',\'' + _type + '\',\'' + _vehid + '\')" style="display: none; cursor: pointer; color: #fff; float: left; '+mt+'; height: 80px; padding-top: 10px; padding-left: 10px; background-color: #387CB0; position: relative; opacity: ' + _op + '; width: 290px;">';
		alertIn += '<font style="font-family: arial; font-size: 18px; font-weight: bold; top: 7px; left: 35px; position: absolute;">' + _reg + '</font>';
		alertIn += '<div class="ui-icon1 ui-icon-circle-close"></div><br/>';
		alertIn += '<div style="font-size: 14px; width: 279px; height: 50px; position: relative; top: -8px;"><strong style="margin-left: 15px;">'+dic("Tracking.Alarm",lang)+': </strong> <input value="' + dic(_type, lang) + '" readonly style="width: 181px; background: transparent; border: 0px none; color: white; font-family: Verdana,Geneva,Arial,Helvetica,sans-serif;"><br />';
		alertIn += '<strong style="margin-left: 15px;position: relative; top: 5px;">'+dic("Tracking.Date",lang)+': </strong> <font style="position: relative; top: 5px;"> ' + _dt.split(" ")[1].substring(0,_dt.split(" ")[1].indexOf("."))+" "+_dt.split(" ")[0].split("-")[2]+"-"+_dt.split(" ")[0].split("-")[1]+"-"+_dt.split(" ")[0].split("-")[0] + '</font></div></div>';
		$('#div-alerts_'+(parseInt(_num, 10)+1)).after(alertIn);
		$('#div-alerts_'+parseInt(_num, 10)).fadeIn('slow');
	}
	if(parseInt($('#alertsNew').val(), 10) == 1)
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
		$('#alertsNew').val(parseInt($('#alertsNew').val(), 10) + 1);
		$(document).attr({title: '('+$('#alertsNew').val()+') '+$(document).attr('title') });
		var alertIn = '<div onmouseover="opacityIn('+parseInt(_num, 10)+')" onmouseout="opacityOut('+parseInt(_num, 10)+')" id="div-alerts_'+parseInt(_num, 10)+'" class="corner15 shadowalerts" onclick="AlertEventHide('+parseInt(_num, 10) + ',\'' +_dt + '\',\'' + _reg + '\',\'' + _type + '\',\'' + _vehid + '\')" style="display: none; cursor: pointer; color: #fff; float: left; '+mt+'; height: 80px; padding-top: 10px; padding-left: 10px; background-color: #387CB0; position: relative; opacity: ' + _op + '; width: 290px;">';
		alertIn += '<font style="font-family: arial; font-size: 18px; font-weight: bold; top: 7px; left: 35px; position: absolute;">' + _reg + '</font>';
		alertIn += '<div class="ui-icon1 ui-icon-circle-close"></div><br/>';
		alertIn += '<div style="font-size: 14px; width: 279px; height: 50px; position: relative; top: -8px;"><strong style="margin-left: 15px;">'+dic("Tracking.Alarm",lang)+': </strong> <input value="' + dic(_type, lang) + '" readonly style="width: 181px; background: transparent; border: 0px none; color: white; font-family: Verdana,Geneva,Arial,Helvetica,sans-serif;"><br />';
		alertIn += '<strong style="margin-left: 15px;position: relative; top: 5px;">'+ dic("Tracking.Date",lang)+': </strong> <font style="position: relative; top: 5px;"> ' + _dt.split(" ")[1].substring(0,_dt.split(" ")[1].indexOf("."))+" "+_dt.split(" ")[0].split("-")[2]+"-"+_dt.split(" ")[0].split("-")[1]+"-"+_dt.split(" ")[0].split("-")[0] + '</font></div></div>';
		$('#div-mainalerts').html($('#div-mainalerts').html() + alertIn);
		$('#div-alerts_'+parseInt(_num, 10)).fadeIn('slow');
	} else
	{
		var mt = 'margin-bottom: 15px';
		$('#alertsNew').val(parseInt($('#alertsNew').val(), 10) + 1);
		$(document).attr({title: '('+parseInt($('#alertsNew').val(), 10)+')' + $(document).attr('title').substring($(document).attr('title').indexOf(" "),$(document).attr('title').length) });
		var alertIn = '<div onmouseover="opacityIn('+parseInt(_num, 10)+')" onmouseout="opacityOut('+parseInt(_num, 10)+')" id="div-alerts_'+parseInt(_num, 10)+'" class="corner15 shadowalerts" onclick="AlertEventHide('+parseInt(_num, 10) + ',\'' +_dt + '\',\'' + _reg + '\',\'' + _type + '\',\'' + _vehid + '\')" style="display: none; cursor: pointer; color: #fff; float: left; '+mt+'; height: 80px; padding-top: 10px; padding-left: 10px; background-color: #387CB0; position: relative; opacity: ' + _op + '; width: 290px;">';
		alertIn += '<font style="font-family: arial; font-size: 18px; font-weight: bold; top: 7px; left: 35px; position: absolute;">' + _reg + '</font>';
		alertIn += '<div class="ui-icon1 ui-icon-circle-close"></div><br/>';
		alertIn += '<div style="font-size: 14px; width: 279px; height: 50px; position: relative; top: -8px;"><strong style="margin-left: 15px;">'+dic("Tracking.Alarm",lang)+': </strong> <input value="' + dic(_type, lang) + '" readonly style="width: 181px; background: transparent; border: 0px none; color: white; font-family: Verdana,Geneva,Arial,Helvetica,sans-serif;"><br />';
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

function OpenMapAlarm1(_dt, _reg, _type, _vehid, _num){
	var _idC = _vehid+"_"+_dt.split(" ")[0].split("-")[0]+"_"+_dt.split(" ")[0].split("-")[1]+"_"+_dt.split(" ")[0].split("-")[2]+"_"+_dt.split(" ")[1].split(":")[0]+"_"+_dt.split(" ")[1].split(":")[1]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[0]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[1];
    $('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; z-index: 9999; border:0px" src=""></iframe>');
    document.getElementById('iframemaps').src = '../main/LoadMap.php?datetime=' + _dt + '&reg=' + _reg + '&type=' + _type + '&l=' + lang + '&num=' + _num;
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
    		msgbox(dic("Tracking.NotEnteredNotice",lang));
    		return false;
		} else
		{
			ShowWait();
			var note = document.getElementById("iframemaps").contentWindow.$("#alarmZabeleska").val();
			$.ajax({
		        url: "../main/UpdateNoteAndReadStatusForAlarm.php?dt=" + _dt + "&type=" + _type + "&reg=" + _reg + "&note=" + note,
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
			        	$('#alarm-small-'+_idC).css({ backgroundImage: 'url("../images/yes1.png")' });
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
    document.getElementById('iframemaps').src = '../main/LoadMapZ.php?datetime=' + _dt + '&reg=' + _reg + '&type=' + _type + '&l=' + lang + '&num=' + _num;
    if (Browser() == 'iPad') {
    	_w = 800;
    	_h = 500;
	} else {
		_w = 1000;
    	_h = 700;
	}
    $('#dialog-map').dialog({ modal: true, height: _h, width: _w, zIndex: 9999 });
}
function OpenMapAlarm3(_dt, _reg, _type, _vehid, _num){
	var _idC = _vehid+"_"+_dt.split(" ")[0].split("-")[0]+"_"+_dt.split(" ")[0].split("-")[1]+"_"+_dt.split(" ")[0].split("-")[2]+"_"+_dt.split(" ")[1].split(":")[0]+"_"+_dt.split(" ")[1].split(":")[1]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[0]+"_"+_dt.split(" ")[1].split(":")[2].split(".")[1];
    $('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; z-index: 9999; border:0px" src=""></iframe>');
    document.getElementById('iframemaps').src = '../report/LoadMapAlarm.php?datetime=' + _dt + '&reg=' + _reg + '&type=' + _type + '&l=' + lang + '&num=' + _num;
    if (Browser() == 'iPad') {
    	_w = 800;
    	_h = 500;
	} else {
		_w = 1000;
    	_h = 700;
	}
    $('#dialog-map').dialog({ modal: true, height: _h, width: _w, zIndex: 9999 });
}

function snoozeAlarm() {
	if(snoozeTmp == (snooze*60))
	{
		if(parseInt($('#alertsNew').val(), 10) == 0)
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
  	soundHandle.src = '../tracking/sound/Small_Blink.ogg';
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
    $('#datetime').datetimepicker({
        dateFormat: 'dd-mm-yy',
        showOn: "button",
        buttonImage: "../images/cal1.png",
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
function AjaxNotify() {
    var _page = '../main/getNotify.php'
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
