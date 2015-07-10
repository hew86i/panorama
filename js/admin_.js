
//keti
var UserCount = 0;
function _searchUsers(){
	var btn=$('#btnSerach').valueOf();
	var _txt = $('#txt_search').val()
	if (_txt==''){
		for (var i=0; i<UserCount; i++){
			$('#r-'+i).css({display:''})
		}

		return
		
	}
	for (var i=0; i<UserCount; i++){
		var _cl = $('#user_'+i).html()
		if (_cl.toUpperCase().indexOf(_txt.toUpperCase())>-1){
			$('#r-'+i).css({display:''})
		} else {
			$('#r-'+i).css({display:'none'})
		}
	}
	btn=="disable";
}
var ClientCount = 0;
function _searchClients(){
	var btn=$('#btnSerach').valueOf();
	var _txt = $('#txt_search').val()

	if (_txt==''){
		for (var i=0; i<ClientCount; i++){
			$('#div-cl-'+i).css({display:''})
		}
		return
	}
	for (var i=0; i<ClientCount; i++){
		var _cl = $('#client_'+i).html()
		if (_cl.toUpperCase().indexOf(_txt.toUpperCase())>-1){
			$('#div-cl-'+i).css({display:''})
		} else {
			$('#div-cl-'+i).css({display:'none'})
		}
	}
	btn=="disable";
}
var VehicleCount = 0;
function _searchVehicle(){
	var btn=$('#btnSerach').valueOf();
	var _txt = $('#txt_search').val()
	if (_txt==''){
		for (var i=0; i<VehicleCount; i++){
			$('#vehicle-'+i).css({display:''})
		}

		return
		
	}
	for (var i=0; i<VehicleCount; i++){
		var _cl = $('#vehicle_'+i).html()
		if (_cl.toUpperCase().indexOf(_txt.toUpperCase())>-1){
			$('#vehicle-'+i).css({display:''})
		} else {
			$('#vehicle-'+i).css({display:'none'})
		}
	}
	btn=="disable";
}

function ShowAddClient(){
	wnd = 'client'
	_clientID = -1
	//$('#div-wnd-t').html('Додади нов клиент')
	//$('#stt-cont').load('_addClient.php?id=-1')
	
	top.document.getElementById('ifr-map').src ='_addClient.php';
}
function ShowAddTemplate(){
	wnd = 'client'
	_clientID = -1
	//$('#div-wnd-t').html('Додади нов клиент')
	//$('#stt-cont').load('_addClient.php?id=-1')
	
	top.document.getElementById('ifr-map').src ='_addTemplate.php';
}

function ShowEditClient(client_id,cl_name){
		_clientID = client_id	
		//$('#stt-cont').load('_editClient.php?id='+_clientID)	
		top.document.getElementById('ifr-map').src = '_editClient.php?id='+_clientID;
}
function ShowAllVehicles(client_id, client_name)
{
	_clientID = client_id
	//$('#stt-cont').load('_show_Vehicle.php?id='+_clientID)
	top.document.getElementById('ifr-map').src = '_show_Vehicle.php?id='+_clientID;
}
function ShowAllUsers(_cl_id, _cl_name)
{
	_clientID = -1
	//$('#stt-cont').load('_show_Users.php?id='+_cl_id)
	top.document.getElementById('ifr-map').src ='_show_Users.php?id='+_cl_id;
}
function AddUser(_cl_id)
{
	_clientID = -1
	//$('#stt-cont').load('_admin_add_user.php?id='+_cl_id)
	top.document.getElementById('ifr-map').src ='_admin_add_user.php?id='+_cl_id;
}
function EditUser(user_id)
{
	//$('#report-content1').load('_admin_edit_user.php?id='+user_id)
	top.document.getElementById('ifr-map').src ='_admin_edit_user.php?id='+user_id;
}
function EditVehicle(vehicle_id)
{
	//$('#report-content1').load('_admin_edit_vehicle.php?id='+vehicle_id)
	top.document.getElementById('ifr-map').src ='_admin_edit_vehicle.php?id='+vehicle_id;
}
function EditPorts(vehicle_id)
{
	
	//$('#stt-cont').load('_admin_edit_port.php?id='+vehicle_id)
//	$('#stt-cont').load('getusers.php?id='+vehicle_id)
	top.document.getElementById('ifr-map').src ='_admin_edit_port.php?id='+vehicle_id;

}
function promeni()
{
	var odgrad=$("#city option:selected").val();
	//var gradovi = document.getElementById('city');
	var drzava=document.getElementById('country');
	drzava.disabled=false;
 	//gradoviniza[i] = gradovi.options[i].value;
 	  for(var j=0;j<drzava.options.length;j++)
 	  {
	 	  if(odgrad==drzava.options[j].value)
	 	  {
	 	  	drzava.options[j].selected = true; //.setAttribute("selected", "selected",true);
			
	 	  }
	 }
	 drzava.disabled=true;
}
function SendComm(_v_id)
{
    ShowWait()
    $.ajax({
        url: "_showComm.php?id="+_v_id,
        context: document.body,
        success: function(data){
            HideWait();
           top.$('#div-comm-vehicle').html(data)
            top.$('#div-comm-vehicle').dialog({  modal: true, width: 300, height: 280, resizable: false,
                buttons: {
                    OK: function(){
                    	//alert("EditPorts_glavna.php?id="+_pn_id+"&ime="+ime+"&opis="+opis)
                    	//return false;
                        //    $.ajax({
		                       // url: "EditPorts_glavna.php?id="+_pn_id+"&ime="+ime+"&opis="+opis,
		                        //context: document.body,
		                        //success: function(){
                                //    alert("Успешно променета порта!");
                                    // $('#stt-cont').load('Admin2.php?')
		                      //  }
		                    //});	
                         top.$( this ).dialog( "close" );
                    },
                    Cancel: function() {
					    top.$( this ).dialog( "close" );
				    },
                }
            })
        }
    });
} 
function toAllVehicleSendComm(_v_id)
{
	 var vozila=[];
     $.each($("input[name='vehicle_group[]']:checked"), function() {
  	 vozila.push($(this).val());
	});
	if(vozila!="")	{		
		ShowWait()
	    	$.ajax({
	        url: "_showCommVehicle.php?vozilaid="+vozila,
	        context: document.body,
	        success: function(data){
	            HideWait();
	           top.$('#div-comm-vehicle').html(data)
	            top.$('#div-comm-vehicle').dialog({  modal: true, width: 300, height: 280, resizable: false,
	                buttons: {
	                    OK: function(){
	                    	//alert("EditPorts_glavna.php?id="+_pn_id+"&ime="+ime+"&opis="+opis)
	                    	//return false;
	                        //    $.ajax({
			                       // url: "EditPorts_glavna.php?id="+_pn_id+"&ime="+ime+"&opis="+opis,
			                        //context: document.body,
			                        //success: function(){
	                                //    alert("Успешно променета порта!");
	                                    // $('#stt-cont').load('Admin2.php?')
			                      //  }
			                    //});	
	                         top.$( this ).dialog( "close" );
	                    },
	                    Cancel: function() {
						    top.$( this ).dialog( "close" );
					    },
	                }
	            })
	        }
	    });
	    }
	    else
	    {
	    	alert("Немате означено возило!");
	    }
} 	
function ConficVehicle(_v_id)
{
	  ShowWait()
	    	$.ajax({
	        url: "_showConfVehicle.php?id="+_v_id,
	        context: document.body,
	        success: function(data){
	            HideWait();
	           top.$('#div-confiv-vehicle').html(data)
	            top.$('#div-confiv-vehicle').dialog({  modal: true, width: 380, height: 350, resizable: false,
	                buttons: {
	                    OK: function(){
	                    	var textarea=top.document.getElementById('confic').value;
	                       // alert("AddConf.php?id="+_v_id+"&textarea="+textarea)
	                    	//return false;
	                            $.ajax({
			                        url: "AddConf.php?id="+_v_id+"&textarea="+textarea,
			                        context: document.body,
			                        success: function(){
	                                    //alert("Успешно променета порта!");
	                                   //  $('#stt-cont').load('Admin2.php?')
			                        }
			                    });	
	                         top.$( this ).dialog( "close" );
	                    },
	                    Cancel: function() {
						    top.$( this ).dialog( "close" );
					    },
	                }
	            })
	        }
	    });
}
function ShowEditPorts(_pn_id)
{
		//$('#stt-cont').load('PortnameEdit.php?id=' + _pn_id)
	    ShowWait()
	    $.ajax({
	        url: "_editPort.php?id="+_pn_id,
	        context: document.body,
	        success: function(data){
	            HideWait();
	            top.$('#div-edit-ports').html(data)
	            top.$('#div-edit-ports').dialog({  modal: true, width: 300, height: 280, resizable: false,
	                buttons: {
	                    OK: function(){
	                    	var ime=top.$("#name").val();
	                    	var opis=top.$("#description").val();
	                    	//alert("EditPorts_glavna.php?id="+_pn_id+"&ime="+ime+"&opis="+opis)
	                    	//return false;
	                            $.ajax({
			                        url: "EditPorts_glavna.php?id="+_pn_id+"&ime="+ime+"&opis="+opis,
			                        context: document.body,
			                        success: function(){
	                                   // alert("Успешно променета порта!");
	                                     //$('#stt-cont').load('Admin2.php?')
	                                     top.document.getElementById('ifr-map').src = 'Admin2.php';
			                        }
			                    });	
	                         top.$( this ).dialog( "close" );
	                    },
	                    Cancel: function() {
						    top.$( this ).dialog( "close" );
					    },
	                }
	            })
	        }
	    });
}  
function ShowEditTemplate(_t_id)
{
   top.document.getElementById('ifr-map').src = '_editTemplate.php?id='+_t_id;
}
function ShowAddPorts()
{
    ShowWait()
    $.ajax({
        url: "_addPort.php",
        context: document.body,
        success: function(data){
            HideWait();
            top.$('#div-add-ports').html(data)
            top.$('#div-add-ports').dialog({  modal: true, width: 300, height: 280, resizable: false,
                buttons: {
                    OK: function(){
                    	var ime=top.$("#name").val();
                    	var opis=top.$("#description").val();
                    	//alert("AddPorts.php?ime="+ime+"&opis="+opis)
                    	//return false;
                            $.ajax({
		                        url: "AddPorts.php?ime="+ime+"&opis="+opis,
		                        context: document.body,
		                        success: function(data){
		                         //alert("Успешно додадена порта!");
		                       top.document.getElementById('ifr-map').src = 'Admin2.php';
		                        }
		                    });	
                         top.$( this ).dialog( "close" );
                    },
                    Cancel: function() {
					    top.$( this ).dialog( "close" );
				    },
                }
            })
        }
    });
}  
var GlobalFN = '';
function AddUserVehicle(cid, uid){
 //   var uid = $('#red').val()
top.$('#123123').html('<div id="div-vehicles-user"></div>');
    var vehicles = '0'
    ShowWait()
    $.ajax({
        url: "_User_add_vehicle.php?cid="+cid+"&uid="+uid,
        context: document.body,
        success: function(data){
            HideWait();
            top.$('#div-vehicles-user').html(data)
            top.$('#div-vehicles-user').dialog({  modal: true, width: 300, height: 280, resizable: false,
                buttons: {
                    OK: function(){
                    	 var vozila=[];
                    	 //debugger;
                    	 /*for(var i= 0; i< $('#vehiclelistcheck')[0].children[0].children.length;i++)
                    	 {
                    	 	if($('#vehiclelistcheck')[0].children[0].children[i].children.length > 1)
                    	 		if($('#vehiclelistcheck')[0].children[0].children[i].children[0].children[0].checked)
                    	 			vozila += $('#vehiclelistcheck')[0].children[0].children[i].children[0].children[0].value + ',';
                    	 }*/
                        top.$.each(top.$("input[name='user_group[]']:checked"), function() {
                        	//debugger;
  						vozila.push(top.$(this).val());
							});
                            $.ajax({
		                        url: "AddUserVehicles.php?ve="+vozila+"&cid="+cid+"&uid=" + uid,
		                        context: document.body,
		                        success: function(){
		                        	//$('#tabId1'+data).html($('#tabId1'+data).html()+data)
                                  //  alert("Успешно додадено возило на корисникот!");
                                  top.$('#div-vehicles-user').remove();
                                  top.document.getElementById('ifr-map').src ='_admin_edit_user.php?id='+uid;
		                        }
		                    });	
                         //$( this ).dialog( "close" );
                    },
                    Cancel: function() {
					    top.$( this ).dialog( "close" );
				    },
                }
            })
        }
    });
}  
var GlobalFN = '';
function AddVehicleUser(cid,vid, i){
top.$('#div-user-prv').html('<div id="div-user"></div>');
    var vehicles = '0'
    ShowWait()
    $.ajax({
        url: "_vehicle_add_user.php?cid="+cid+"&vid="+vid,
        context: document.body,
        success: function(data){
            HideWait()
            top.$('#div-user').html(data)
            top.$('#div-user').dialog({  modal: true, width: 300, height: 280, resizable: false,
                buttons: {
                    OK: function(){
                         var users=[];
                        top.$.each(top.$("input[name='user_group[]']:checked"), function() {
  						users.push(top.$(this).val());
							});
                       // alert("AddVehicleUser.php?cid="+cid+"&vid="+vid+ "&users="+ users)
                    	//return false;

                            $.ajax({
		                        url: "AddVehicleUser.php?cid="+cid+"&vid="+vid+ "&users="+ users+ "&i="+i,
		                        context: document.body,
		                        success: function(data){
		                	     top.$('#v-'+ i).html();
		                	     //location.reload();
		                        //	 $('#tabId2').html($('#tabId2').html() + "my next row of html code");
                                   // alert("Успешно внесен корисник!")
                                    top.$('#div-user').remove();
                                    top.document.getElementById('ifr-map').src ='_admin_edit_vehicle.php?id='+vid;
                                    
		                        }
		                    });	
                        top.$( this ).dialog( "close" );
                    },
                    Cancel: function() {
					    top.$( this ).dialog( "close" );
				    },
                }
            })
        }
    });
}  

function AddVehicle(_cl_id)
{
	//$('#stt-cont').load('_admin_add_vehicle.php?id='+_cl_id)
	top.document.getElementById('ifr-map').src ='_admin_add_vehicle.php?id='+_cl_id;
}

function DeleteUser(id,i) {
    ShowWait()
        $.ajax({
		    url: "DelUserQuestion.php?id="+id,
		    context: document.body,
		    success: function(data){
                HideWait()
    top.$('#div-del-user').html(data)
    top.$('#div-del-user').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: {
				    Yes: function() {
                       // var id = $('#tabId1').val()
                            $.ajax({
		                        url: "DeleteUser.php?id="+id+"&i="+i,
		                        context: document.body,
		                        success: function(data){
			                       $('#r-'+i).remove();
		                        }
		                        
		                    });	
                            top.$( this ).dialog( "close" );
				    },
                    No: function() {
					    top.$( this ).dialog( "close" );
				    }
               }
         }); 
    }
    });
   }
 function DeleteVehicle(id,i) {
    ShowWait()
        $.ajax({
		    url: "DelVehicleQuestion.php?id="+id,
		    context: document.body,
		    success: function(data){
                HideWait()
    top.$('#div-del-vehicle').html(data)
    top.$('#div-del-vehicle').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: {
				    Yes: function() {
                       // var id = $('#tabId1').val()
                            $.ajax({
		                        url: "DeleteVehicle.php?id="+id+"&i="+i,
		                        context: document.body,
		                        success: function(data){
			                       $('#vehicle-'+i).remove();
			                        //top.document.getElementById('ifr-map').src ='_show_Vehicle.php?id='+vid;
		                        }
		                        
		                    });	
                            top.$( this ).dialog( "close" );
				    },
                    No: function() {
					    top.$( this ).dialog( "close" );
				    }
               }
         }); 
    }
    });
   }
function DeletVehicleORUser(vehicleid,userid,i)
	{
	ShowWait()
        $.ajax({
		    url: "DelVehicleORUserQuestion.php?",
		    context: document.body,
		    success: function(data){
    HideWait()
   			 top.$('#div-del-vORu').html(data)
    		 top.$('#div-del-vORu').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: {
				    Yes: function() {
		//alert("DeleteVehicleORUser.php?vehicleid="+vehicleid + "&userid=" + userid + "&i="+i)
		//return false;
							$.ajax({
								url: "DeleteVehicleORUser.php?vehicleid="+vehicleid + "&userid=" + userid + "&i=" + i,
								context: document.body,
								success: function (data) { 
										   $('#v-'+i).remove();
										   // alert("Избришано!")
								 }
					
							});
							    },
                    No: function() {
					    top.$( this ).dialog( "close" );
				    }
               }
         }); 
    }
    });
   }
function addCommand()
{
    ShowWait()
    $.ajax({
        url: "_addCommand.php",
        context: document.body,
        success: function(data){
            HideWait();
            top.$('#div-add-comm').html(data)
            top.$('#div-add-comm').dialog({  modal: true, width: 300, height: 280, resizable: false,
                buttons: {
                    OK: function(){
                    	var ime= top.$("#name").val();
                    	var komanda=top.$('#comm').val();
                    //	alert("AddCommand_glavna.php?ime="+ime+"&comm="+komanda)
                    //	return false;
                            $.ajax({
		                        url: "AddCommand_glavna.php?ime="+ime+"&comm="+komanda,
		                        context: document.body,
		                        success: function(){
                                   // alert("Успешно додадена команда!");
                                    top.document.getElementById('ifr-map').src = 'Admin4.php';
		                        }
		                    });	
                        top.$( this ).dialog( "close" );
                    },
                    Cancel: function() {
					    top.$( this ).dialog( "close" );
				    },
                }
            })
        }
    });
}  
function editCommand(_cm_id)
{
    ShowWait()
    $.ajax({
        url: "_editCommand.php?id="+_cm_id,
        context: document.body,
        success: function(data){
            HideWait();
            top.$('#div-edit-comm').html(data)
            top.$('#div-edit-comm').dialog({  modal: true, width: 300, height: 280, resizable: false,
                buttons: {
                    OK: function(){
                    	var ime= top.$("#name").val();
                    	var komanda= top.$('#comm').val();
                    	//alert("EditCommand_glavna.php?id="+_cm_id+"&ime="+ime)
                    	//return false;
                            $.ajax({
		                        url: "EditCommand_glavna.php?id="+_cm_id+"&ime="+ime+"&comm="+komanda,
		                        context: document.body,
		                        success: function(){
                                    //alert("Успешно променета команда!");
                               		top.document.getElementById('ifr-map').src = 'Admin4.php';
		                        }
		                    });	
                         top.$( this ).dialog( "close" );
                    },
                    Cancel: function() {
					    top.$( this ).dialog( "close" );
				    },
                }
            })
        }
    });
}  
function deleteCommand(_cm_id,i)
{
   ShowWait()
        $.ajax({
		    url: "DelCommQuestion.php?id="+_cm_id,
		    context: document.body,
		    success: function(data){
                HideWait()
    			top.$('#div-delete-comm').html(data)
    			top.$('#div-delete-comm').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: {
				    Yes: function() {
				    //	alert("DeleteCommand.php?id="+_cm_id+"&i="+i)
				    //	return false;
                            $.ajax({
		                        url: "DeleteCommand.php?id="+_cm_id+"&i="+i,
		                        context: document.body,
		                        success: function(data){
			                       $('#comm-'+i).remove();
		                        }
		                        
		                    });	
                            top.$( this ).dialog( "close" );
				    },
                    No: function() {
					    top.$( this ).dialog( "close" );
				    }
               }
         }); 
    }
    });
   } 
   ///keti