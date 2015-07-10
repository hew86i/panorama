	
//keti
var UserCount = 0;
var PrevHash='';
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


function ShowAddClient(){
	ShowWait()
	wnd = 'client'
	_clientID = -1
	top.document.getElementById('ifr-map').src ='_addClient.php';
}
function ShowAddTemplate(){
	ShowWait()
	top.document.getElementById('ifr-map').src ='_addTemplate.php';
}

function ShowEditClient(client_id,cl_name){
		ShowWait()
		_clientID = client_id	
		top.document.getElementById('ifr-map').src = '_editClient.php?id='+_clientID;
}
function ShowAllVehicles(client_id, client_name)
{
	ShowWait()
	_clientID = client_id
	top.document.getElementById('ifr-map').src = '_show_Vehicle.php?id='+_clientID;
}
function ShowAllUsers(_cl_id, _cl_name)
{
	ShowWait()
	_clientID = -1
	top.document.getElementById('ifr-map').src ='_show_Users.php?id='+_cl_id;
}
function AddUser(_cl_id)
{
	ShowWait()
	_clientID = -1
	top.document.getElementById('ifr-map').src ='_admin_add_user.php?id='+_cl_id;
}
function EditUser(user_id)
{
	ShowWait()
	top.document.getElementById('ifr-map').src ='_admin_edit_user.php?id='+user_id;
}
function EditVehicle(vehicle_id)
{
	ShowWait()
	top.document.getElementById('ifr-map').src ='_admin_edit_vehicle.php?id='+vehicle_id;
}
function EditPorts(vehicle_id)
{
	ShowWait()
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
                    Прати: function(){
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
                    Откажи: function() {
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
	            top.$('#div-comm-vehicle').dialog({  modal: true, width: 400, height: 380, resizable: false,
	                buttons: {
	                    Прати: function(){
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
	                    Откажи: function() {
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
	            top.$('#div-confiv-vehicle').dialog({  modal: true, width: 1000, height: 650, resizable: false,
	                buttons: {
	                    Додади: function(){
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
	                    Откажи: function() {
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
	                    Промени: function(){
	                    	var ime=top.$("#name").val();
	                    	var opis=top.$("#description").val();
	                    	if(ime=='')
                    	{
	                    	alert("Треба да внесете име на порта")
	                    	return false;
	                    }
	                    else{
	                    	//alert("EditPorts_glavna.php?id="+_pn_id+"&ime="+ime+"&opis="+opis)
	                    	//return false;
	                            $.ajax({
			                        url: "EditPorts_glavna.php?id="+_pn_id+"&ime="+ime+"&opis="+opis,
			                        context: document.body,
			                        success: function(){
	                                   // alert("Успешно променета порта!");
	                                     //$('#stt-cont').load('Admin2.php?')
	                                    //window.location.reload();
	                                     top.document.getElementById('ifr-map').src = 'Admin2.php';
			                        }
			                    });	
	                         top.$( this ).dialog( "close" );
	                        }
	                    },
	                    Откажи: function() {
						    top.$( this ).dialog( "close" );
					    },
	                }
	            })
	        }
	    });
}  
function ShowEditTemplate(_t_id)
{
	ShowWait()
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
                    Додади: function(){
                    	var ime=top.$("#name").val();
                    	var opis=top.$("#description").val();
                    	if(ime=='')
                    	{
	                    	alert("Треба да внесете име на порта")
	                    	return false;
	                    }
	                    else{
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
                        }
                    },
                    Откажи: function() {
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
top.$('#123123').html('<div id="div-vehicles-user "></div>');
    var vehicles = '0'
    ShowWait()
    $.ajax({
        url: "_User_add_vehicle.php?cid="+cid+"&uid="+uid,
        context: document.body,
        success: function(data){
            HideWait();
            top.$('#div-vehicles-user').html(data)
            top.$('#div-vehicles-user').dialog({  modal: true, width: 500, height: 380, resizable: false,
                buttons: {
                    Додади: function(){
                    	 var vozila=[];
                        top.$.each(top.$("input[name='user_group[]']:checked"), function() {
  						vozila.push(top.$(this).val());
							});
							//alert("AddUserVehicles.php?ve="+vozila+"&cid="+cid+"&uid=" + uid)
							//return false;
                            $.ajax({
		                        url: "AddUserVehicles.php?ve="+vozila+"&cid="+cid+"&uid=" + uid,
		                        context: document.body,
		                        success: function(){
                                 //top.$('#div-vehicles-user').remove();
                                 top.document.getElementById('ifr-map').src ='_admin_edit_user.php?id='+uid;
		                         window.location.reload()
                                    //top.$('#div-vehicles-user').add()

		                        }
		                    });	
                         top.$( this ).dialog( "close" );
                    },
                    Откажи: function() {
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
    ShowWait()
    $.ajax({
        url: "_vehicle_add_user.php?cid="+cid+"&vid="+vid,
        context: document.body,
        success: function(data){
            HideWait()
            top.$('#div-user-vehicle').html(data)
            top.$('#div-user-vehicle').dialog({  modal: true, width: 300, height: 280, resizable: false,
                buttons: {
                    Додади: function(){
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
		                	     //top.$('#v-'+ i).html();
                                    //top.$('#div-user-vehicle').remove();
                                    //top.document.getElementById('ifr-map').src ='_admin_edit_vehicle.php?id='+vid;
                                    window.location.reload()
                                    top.$('#div-user-vehicle').add()
		                        }
		                    });	
                        top.$( this ).dialog( "close" );
                    },
                    Откажи: function() {
					    top.$( this ).dialog( "close" );
				    },
                }
            })
        }
    });
}  

function AddVehicle(_cl_id)
{
	ShowWait()
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
				    Да: function() {
                       // var id = $('#tabId1').val()
                            $.ajax({
		                        url: "DeleteUser.php?id="+id+"&i="+i,
		                        context: document.body,
		                        success: function(data){
			                       $('#r-'+i).remove();
			                       window.location.reload();
		                        }
		                        
		                    });	
                            top.$( this ).dialog( "close" );
				    },
                    Не: function() {
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
				    Да: function() {
                       // var id = $('#tabId1').val()
                            $.ajax({
		                        url: "DeleteVehicle.php?id="+id+"&i="+i,
		                        context: document.body,
		                        success: function(data){
			                       $('#vehicle-'+i).remove();
			                       window.location.reload();
			                        //top.document.getElementById('ifr-map').src ='_show_Vehicle.php?id='+vid;
		                        }
		                        
		                    });	
                            top.$( this ).dialog( "close" );
				    },
                    Не: function() {
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
				    Да: function() {
		//alert("DeleteVehicleORUser.php?vehicleid="+vehicleid + "&userid=" + userid + "&i="+i)
		//return false;
							$.ajax({
								url: "DeleteVehicleORUser.php?vehicleid="+vehicleid + "&userid=" + userid + "&i=" + i,
								context: document.body,
								success: function (data) { 
										   $('#v-'+i).remove();
										   // alert("Избришано!")
										   window.location.reload();
								 }
					
							});
							top.$( this ).dialog( "close" );
							    },
                    Не: function() {
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
                    Додади: function(){
                    	var ime= top.$("#name").val();
                    	var komanda=top.$('#comm').val();
                    	if(ime=='')
                    	{
                    		 alert("Треба да внесете име на команда!")
                    	   	 return false;
                    	 }
                    	if(komanda=='')
                    	{
                    		alert("Треба да внесете команда!")
                    		return false;
                    	}
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
                    Откажи: function() {
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
                    Промени: function(){
                    	var ime= top.$("#name").val();
                    	var komanda= top.$('#comm').val();
                    	if(ime=='')
                    	{
                    		 alert("Треба да внесете име на команда!")
                    	   	 return false;
                    	 }
                    	if(komanda=='')
                    	{
                    		alert("Треба да внесете команда!")
                    		return false;
                    	}
                    	//alert("EditCommand_glavna.php?id="+_cm_id+"&ime="+ime+"&comm="+komanda)
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
                    Откажи: function() {
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
				    Да: function() {
				    //	alert("DeleteCommand.php?id="+_cm_id+"&i="+i)
				    //	return false;
                            $.ajax({
		                        url: "DeleteCommand.php?id="+_cm_id+"&i="+i,
		                        context: document.body,
		                        success: function(data){
			                       $('#comm-'+i).remove();
			                       window.location.reload();
		                        }
		                        
		                    });	
                            top.$( this ).dialog( "close" );
				    },
                    Не: function() {
					    top.$( this ).dialog( "close" );
				    }
               }
         }); 
    }
    });
   } 
   ///keti
function DelLang(_no){
		ShowWait()
		$.ajax({
        url: "DeleteLangQuestion.php?l="+ lang,
    	  context: document.body,
         success: function(data){
            HideWait();
            top.$('#div-delete-lang').html(data)
            top.$('#div-delete-lang').dialog({  modal: true, width: 350, height: 170, resizable: false,
                buttons: {
                    Да: function(){
						$.ajax({
				            url: "deleteLang.php?num=" + _no+ "&l="+lang,
				            context: document.body,
				            success: function (data) {
				            	if(data == "notok")
				            	{
			                		alert("Неуспешно избришан превод!");
				                } else
			                   {
				                	alert("Успешно избришан превод!");
				                	window.location.reload();
				                }
				            }
				        });
				       top.$( this ).dialog( "close" );
                    },
                    Не: function() {
					   top.$( this ).dialog( "close" );
				    },
                }
            })
       }
    });
}  
////
function checkHash() {
	//alert(window.location.hash)

    var ifEqual = 0
    var ifFirst = 1
    var h = location.hash
    if (h == null) { h = '' }
    if (PrevHash == null) { PrevHash = '' }
    h = h.replace('#admin/', '')
    PrevHash = PrevHash.replace('#admin/', '')
    //alert("h"+h)
    //alert("prev"+PrevHash)
    if ((h != '') && (h != PrevHash)) {
        //alert(1)
        var objPrev = null
        var objCurr = null
        objPrev = document.getElementById(PrevHash)
        objCurr = document.getElementById(h)
        //alert("curr"+objCurr)
       // alert("prev"+objPrev)

                if (objPrev != null) {
                    //if (objPrev.className != 'repoMenu corner5 text2')
                        if (objPrev != null) {
                            //alert(13);
                            ifFirst = 0;
                            var prev = ""
                            prev = document.getElementById(PrevHash).attributes[2].nodeValue.split("_")[2]
                            var curr = ""
                            curr = document.getElementById(h).attributes[2].nodeValue.split("_")[2]
                            if (prev == curr) {
                                ifEqual = 1
                            }

                            objPrev.className = 'repoMenu corner5 text2'
                        }
                }
                if (objCurr != null) {
                   // if (objCurr.className != 'repoMenu corner5 text2')
                        if (objCurr != null) {
                            //alert(14);
                            objCurr.className = 'repoMenuSel corner5 text2'
                        }
                }
        PrevHash = h
    }
    if ((h == '') && (h == PrevHash)) {
        //alert(2)
        ifFirst = 1;
        PrevHash = 'menu_set_1';
        location.hash = '#admin/' + PrevHash
        var objCurr = null
        objCurr = document.getElementById(PrevHash)
        if (objCurr != null) {
            //alert(21);
            objCurr.className = 'repoMenuSel corner5 text2'
        }
    }

    LoadData(1, 1, ifEqual, ifFirst)
   // alert(LoadData(1, 1, ifEqual, ifFirst))
}

$(window).bind('hashchange', function (event) {
    if (event.target.location.pathname.indexOf("index.php") != -1)
        return false;
    checkHash()

    //LoadData()
});
function LoadData(_i, _j, _equal, _first){
	//alert(1)
    //ShowWait();	

    var recTest = 0
	//var Vhc = $('#txtVehicles').val().split('#')[0]
	
	$('#stt-cont').css({display: 'none'});
    $('#ifr-map').css({display: 'block'});
	//document.getElementById('lbl-end-date').style.display=''

	var page = ''
	//alert(PrevHash)
	if (PrevHash == 'menu_set_1') {
	    page = 'Admin1.php'
	    document.getElementById('ifr-map').src = './Admin1.php';
	    
	}

	if (PrevHash == 'menu_set_2') {
	    page = 'Admin2.php'
	     document.getElementById('ifr-map').src = './Admin2.php';
	}
	if(PrevHash=='menu_set_3')
	{
		page='Admin3.php'
		document.getElementById('ifr-map').src = './Admin3.php';
	}
	if(PrevHash=='menu_set_4')
	{
		page='Admin4.php'
		document.getElementById('ifr-map').src = './Admin4.php';
	}
	if(PrevHash=='menu_set_5')
	{
		page='Admin5.php'
		document.getElementById('ifr-map').src = './Admin5.php';
	}
}
