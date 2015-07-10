// ******  settings.js  ******


function SettingsMeni(no) { 
	$('#vremence').css({ display: 'none'});
	if ((no==1) && (AllowUSettings=='false')) {return}
	if ((no==2) && (AllowCSettings=='false')) {return}
	if ((no==3) && (AllowCSettings=='false')) {return}
	if ((no==4) && (AllowUSettings=='false')) {return}
	if ((no==5) && (AllowCSettings=='false')) {return}
	if ((no==6) && (AllowCSettings=='false')) {return}
	if ((no==7) && (AllowUSettings=='false')) {return}
	if ((no==8) && (AllowUSettings=='false')) {return}
	if ((no==9) && (AllowUSettings=='false')) {return}
	if ((no==10) && (AllowUSettings=='false')) {return}
	if ((no==11) && (AllowUSettings=='false')) {return}
	//if ((no==3) && (AllowPSettings=='false')) {return}
	
    //del za trganje na iframe i kreiranje na nov div tag///////////
    var elementi = document.getElementById("report-content");
    var brojac = 0;
    if(elementi.childNodes.length > 0){
        for(var i =0; i< elementi.childNodes.length; i++){
            if(elementi.childNodes[i].tagName == 'IFRAME'){
                $("#i-show-poi").remove();
                $("#i-show-geo").remove();
                brojac = 1;
            }
        }
        if(brojac == 1){
            var dete = document.createElement('div');
            dete.setAttribute('id', 'stt-cont1');
            dete.setAttribute('class','corner5');
            document.getElementById("report-content").appendChild(dete);
        }
    }
    
    ///////////////////////////////////////////////////////////////

    for (var i=1;i<=11;i++){
    	if (document.getElementById("menu_set_"+i))
    		document.getElementById("menu_set_"+i).className="repoMenu corner5 text2"
    }
    document.getElementById("menu_set_"+no).className="repoMenuSel corner5 text2"
    if (no == 1) {
        ShowWait()
        document.getElementById('ifrm-cont').src = "USettings.php?l="+lang;

       /* $.ajax({
            url: "USettings.php?l="+lang,
            context: document.body,
            success: function (data) {
                HideWait()
                $('#stt-cont').html(data)
                $("#SaveDataradio").buttonset();
                $('#AM-div').buttonset();
                $('#Def-Lang').buttonset();
                $('#Def-Map').buttonset();
                $('#LiveTracking').buttonset();
                $('#LiveTracking1').buttonset();
                $('#Kilometri').buttonset();
            }
        });*/
    }
    else {
        if(no == 2){
           ShowWait()
           document.getElementById('ifrm-cont').src = "CSettings.php?l="+lang;
            
           /* $.ajax({
                url: "CSettings.php?l="+lang,
                context: document.body,
                success: function (data) {
                    HideWait()
                    //$('#stt-cont').html(data)
                    $('#btnAdd').button({ icons: { primary: "ui-icon-plus"} });
                    $('#btnDelete').button({ icons: { primary: "ui-icon-cancel"} });
                    $('#btnEdit').button({ icons: { primary: "ui-icon-pencil"} });
                    $('#btnVehicles').button({ icons: { primary: "ui-icon-transferthick-e-w"} });
                }
            });*/
        }
        else{
             if(no == 3){
             	ShowWait()
           		   document.getElementById('ifrm-cont').src = "GroupPOI.php?l="+lang;
            
                   /* $.ajax({
                        url: "GroupPOI.php?l="+lang,
                        context: document.body,
                        success: function (data) {
                            HideWait()
                             $('#stt-co10nt').html(data)
                             $('#btnEdit').button({ icons: { primary: "ui-icon-pencil"} });

                        }
                    });*/
                }
      				 else{"Drivers.php?l=" + '<?php echo $cLang ?>';
                if(no == 4){
                    ShowWait()
                    document.getElementById('ifrm-cont').src = "Vehicles.php?l="+lang;
                    /*$.ajax({
                        url: "Vehicles.php?l="+lang,
                        context: document.body,
                        success: function (data) {
                            HideWait()
                             $('#stt-cont').html(data)
                        

                        }
                    });*/
                }
                else{
                if(no == 5){
                    ShowWait()
                     document.getElementById('ifrm-cont').src = "Organisation.php?l="+lang;
                   /* $.ajax({
                        url: "Organisation.php?l="+lang,
                        context: document.body,
                        success: function (data) {
                            HideWait()
                             $('#stt-cont').html(data)
                        

                        }
                    });*/
                }
                
                    else{
                if(no == 6){
                    ShowWait()
                    document.getElementById('ifrm-cont').src = "Drivers.php?l="+lang;
                   /* $.ajax({
                        url: "Drivers.php?l="+lang,
                        context: document.body,
                        success: function (data) {
                            HideWait()
                             $('#stt-cont').html(data)
                        

                        }
                    });*/
                }
                else{
                if(no == 7){
                    ShowWait()
                    document.getElementById('ifrm-cont').src = "WorkTime.php?l="+lang;
                    /*$.ajax({
                        url: "WorkTime.php?l="+lang,
                        context: document.body,
                        success: function (data) {
                            HideWait()
                             $('#stt-cont').html(data)
                        

                        }
                    });*/
                }
                else{
                if(no == 8){
                    ShowWait()
                    document.getElementById('ifrm-cont').src = "Schedulers.php?l="+lang;
                    /*$.ajax({
                        url: "WorkTime.php?l="+lang,
                        context: document.body,
                        success: function (data) {
                            HideWait()
                             $('#stt-cont').html(data)
                        

                        }
                    });*/
                }
                else{
                if(no == 9){
                    ShowWait()
                    document.getElementById('ifrm-cont').src = "AllAlerts.php?l="+lang;
                    /*$.ajax({
                        url: "WorkTime.php?l="+lang,
                        context: document.body,
                        success: function (data) {
                            HideWait()
                             $('#stt-cont').html(data)
                        

                        }
                    });*/
                }
                else{
                if(no == 10){
                	$('#vremence').css({ display: 'block'});
                    ShowWait()
                    document.getElementById('ifrm-cont').src = "LogReport.php?l="+lang;
                    /*$.ajax({
                        url: "WorkTime.php?l="+lang,
                        context: document.body,
                        success: function (data) {
                            HideWait()
                             $('#stt-cont').html(data)
                        

                        }
                    });*/
                }
                else{
                if(no == 11){
                	$('#vremence').css({ display: 'block'});
                    ShowWait()
                    document.getElementById('ifrm-cont').src = "MessageReport.php?l="+lang;
                    /*$.ajax({
                        url: "WorkTime.php?l="+lang,
                        context: document.body,
                        success: function (data) {
                            HideWait()
                             $('#stt-cont').html(data)
                        

                        }
                    });*/
                }
                }
                }
                }
                }
                }
               }
               }
              }
            }
           }
          }
          
function createPDF(page, uid_, cid_) {
	document.getElementById('imgPdf').src = "../images/LoadingM.gif";
	//top.ShowWait();
	
	var url_ = "";
	if (page == "LogReport") {
		url_ = "../settings/pdf/index.php?page=" + page + "&c=" + cid_ + "&u=" + uid_ + "&req=" + document.location.href.split("?")[1].replace(/&/g, "**") + "&foruser=" + seluser;
	} else {
		url_ = "../settings/pdf/index.php?page=" + page + "&c=" + cid_ + "&u=" + uid_ + "&req=" + document.location.href.split("?")[1].replace(/&/g, "**");	
	}
	$.ajax({
       url: url_,
       context: document.body,
       success: function (data) {
       	//top.HideWait();

	document.getElementById('imgPdf').src = "../images/epdf.png";
	//alert(data)
	//alert('../savePDF/' + data)
 	document.location.href = '../savePDF/' + data;
       }
   });
}   


 function AddEmail(index, _uid, _report, l, _cid) {

				document.getElementById('imgEmail').src = "../images/LoadingM.gif";
			       var path = document.location.href.split("/")[2];

			       if (path.indexOf("gps.mk") != -1 || path.indexOf("localhost") != -1) {
			           path = "gps"
			       }

			       if (path.indexOf("app.pan") != -1) {
			           path = "app"
			       }

			       $.ajax({
			           url: '../settings/email1.php?l=' + l,
			           context: document.body,
			           success: function (data) {
					document.getElementById('imgEmail').src = "../images/eEmail.png";
			               $('#div-add-email').html(data)

			               $('#div-add-email').dialog({ modal: true, height: 235, width: 400,
			                   buttons: [
			                   {
		                             text: dic("send", l),
		                             click: function () {
		                                 var email = document.getElementById('toEmail').value;
			                           var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
			                           var link = document.location.href;


			                           var xmlHttp; var str = ''
			                           try { xmlHttp = new XMLHttpRequest(); } catch (e) {
			                               try
									        { xmlHttp = new ActiveXObject("Msxml2.XMLHTTP"); }
									                               catch (e) {
									                                   try
						                    { xmlHttp = new ActiveXObject("Microsoft.XMLHTTP"); } catch (e)
						                    { alert("Your browser does not support AJAX!"); return false; }
			                               }
			                           }
			                           tttt = this;

			                           xmlHttp.onreadystatechange = function () {
			                               if (xmlHttp.readyState == 4) {
			                                   str = xmlHttp.responseText
			                                   if (str == 1) {
			                                       document.getElementById("notification").innerHTML = dic("EmailSucSend", l);
			                                       document.getElementById("notification").style.visibility = "visible";
			                                       setTimeout("closeDialog()", 2000);
			                                   }
			                                   else {
			                                       document.getElementById("notification").innerHTML = dic("EmailNotSend", l);
			                                       document.getElementById("notification").style.visibility = "visible";
			                                       setTimeout("closeDialog()", 2000);
			                                   }
			                               }
			                           }


                                       if (document.getElementById('toEmail').value == "") {
                                        document.getElementById("notification").innerHTML = dic("noEmail1", l);
                                        document.getElementById("notification").style.visibility = "visible";
                                        document.getElementById('toEmail').focus();
                                       }
                                       else {
			                           if (document.getElementById('toEmail').value.match(emailExp)) {
                                           document.getElementById("notification").innerHTML = "<img src='../images/ajax-loader.gif' border='0' align='absmiddle' width='31' height='31' />&nbsp;<span class='text1' style='color:#5C8CB9; font-weight:bold; font-size:11px'>" + dic("Reports.GeneratePDF",l) + "</span>"
			                               document.getElementById("notification").style.visibility = "visible";
			                               //ShowWait()
			                               var x = "";

			                               x = encodeURI(link)

			                               var index = x.indexOf("&");
			                               while (index != -1) {
			                                   x = x.replace("&", "*");
			                                   index = x.indexOf("&");
			                               }

			                               var pageHeight
			                               if (document.getElementById('report-content') != null) {
			                                   pageHeight = document.getElementById('report-content').scrollHeight + 50;
			                               }
			                               else {
			                                   pageHeight = document.body.scrollHeight + 50;
			                               }
			    //  alert('../settings/sendmail.php?_user=' + _uid + '&cid=' + _cid + '&email=' + email + '&subject=' + _report + '&link=' + x)                     
xmlHttp.open("GET", '../settings/sendmail.php?_user=' + _uid + '&cid=' + _cid + '&email=' + email + '&subject=' + _report + '&link=' + x + '&l=' + l, true);
			                               xmlHttp.send(null);
			                           }
			                           else {
			                              
                                           document.getElementById('notification').innerHTML = dic("uncorrEmail", l);
                                           document.getElementById("notification").style.visibility = "visible";
			                           }
                                       }
		                             }
		                       },
			                       {
		                             text: dic("cancel", l),
		                             click: function () {
		                             	$(this).dialog("close");
		                             }
		                           }
			                   ]
			                   
			                   
			               });
			           }
			       });
			   }
			   
			   function closeDialog() {
                   $(tttt).dialog("close")
			   } 
function createXls(page, from_, uid_, cid_) {
	document.getElementById('imgXls').src = "../images/LoadingM.gif";	
	top.ShowWait();
	var url_ = "";
	//create excel from scheduler
	if (from_ == 's') {
		
		var t = document.location.href.split("?")[1];
		url_ = "createXls.php?page=" + page + "&req=" + t.replace(/&/g, "**") + "&u=" + uid_ + "&c=" + cid_ + "&from=s";
		$.ajax({
	       		url: url_,
	      		context: document.body,
	       		success: function (data) {
	      		//alert(data)
				document.getElementById('imgXls').src = "../images/eExcel.png";	
	       		top.HideWait();
				//alert('../savePDF/' + data)
	       		document.location.href = '../savePDF/' + data;
	       }
	   });
	//create excel from app   
 	} else {
 		top.HideWait();
 		var u_ = document.location.href.split("?")[1];
	 	var l = (u_.split("&")[0]).split("=")[1];
	 	var sd = (u_.split("&")[1]).split("=")[1];
	 	var ed = (u_.split("&")[2]).split("=")[1];
	 	//http://panorama.gps.mk/settings/MessageReport.php?l=en&sd=22-07-2013%2000:00&ed=22-07-2013%2023:59
	 	var t = "";
	 	if (page == 'LogReport') {
	 		t = "./" + page + "1.php?l=" + l + "&sd=" + sd + "&ed=" + ed + "&u=" + uid_ + "&c=" + cid_ + "&from=a&foruser=" + seluser;
	 	} else {
	 		t = "./" + page + "1.php?l=" + l + "&sd=" + sd + "&ed=" + ed + "&u=" + uid_ + "&c=" + cid_ + "&from=a";
	 	}

//alert(t)
		document.getElementById('imgXls').src = "../images/eExcel.png";	
	 	document.location.href = "./" + t
	}
}   


function EditUserClick(id){
    ShowWait()
    $.ajax({
	    url: "EditUser.php?id="+id+"&l="+lang,
	    context: document.body,
	    success: function(data){
            HideWait()
		    $('#div-edit-user').html(data)
		    document.getElementById('div-edit-user').title = dic("Settings.EditUser")
            $('#div-edit-user').dialog({ modal: true, width: 430, height: 460, resizable: false,
                 buttons: 
			        [
                    {
			        text: dic("Fm.Mod", lang),
                        click: function() {
                        
			        	var name = $('#CEName').val()
                        var lastname = $('#CELastName').val()
                        var email = $('#CEEmail').val()
                        var phone = $('#CEPhone').val()
                        var username = $('#CEUserName').val()
	                    var passwordstar = encodeURIComponent($('#PasswordStar').val())
	                    var passwordNov = encodeURIComponent($('#txtNewPassword').val())
	                    var passwordPotvrda = encodeURIComponent($('#txtConfirmPassword').val())
	                    var pomosno = $('#pomosno').val();
	                    var sovpaganje = $('#divCheckPasswordMatch').val();
	                    
	                    var golemaBukva = /[A-Z]/.test(passwordstar)
	                    var malaBukva = /[a-z]/.test(passwordstar)
	                    var golemaKirilica = /[А-Ш]/.test(passwordstar)
	                    var malaKirilica = /[а-ш]/.test(passwordstar)
	                    var specijalenZnak = /[*\W]/.test(passwordstar)
	                    
	                    var golemaBukva1 = /[A-Z]/.test(passwordNov)
	                    var malaBukva1 = /[a-z]/.test(passwordNov)
	                    var golemaKirilica1 = /[А-Ш]/.test(passwordNov)
	                    var malaKirilica1 = /[а-ш]/.test(passwordNov)
	                    var specijalenZnak1 = /[*\W]/.test(passwordNov)
                        
                        if(name==''){
                               msgboxPetar(dic("Settings.EnterName", lang))
                            }else{
                                if(lastname==''){
                                  msgboxPetar(dic("Settings.EnterLastName", lang))  
                                }
                                else{
                                    if(email==''){
                                        		msgboxPetar(dic("Reports.EnterEmail",lang)) 
                                    }
                                     else  
										{
										if(username==''){
                                           	msgboxPetar(dic("enterUser",lang));  
                                        }
                                        else{
	                                    if(pomosno==1){
	                                    $.ajax({
				                            url: "UpUser.php?name="+name+"&lastname="+lastname+"&email="+email+"&username="+username+"&id="+id+"&passwordstar="+passwordstar+"&phone="+phone+"&pomosno="+pomosno,
				                            context: document.body,         
				                            success: function(data){
				                            if(data == 1)
					                              {
					                              	msgboxPetar(dic("Settings.PasswordUser",lang));
					                              }
					                              else
					                              {
					                              	msgboxPetar(dic("Settings.SuccChanged",lang))
					                        	  	window.location.reload();
								    	       	  }
								    	       }
				                            });    
                                        }
	                                    else{
	                                    if(passwordNov==''){
	                                      		msgboxPetar(dic("Settings.NewPasswordMust",lang));
	                                    }
	                                    else{
	                                    if(passwordPotvrda==''){
	                                        	msgboxPetar(dic("Settings.NewPasswordRepeat",lang));  
	                                    }
	                                    else{
                                    	if(passwordNov.length<6 || golemaBukva1==0 || specijalenZnak1==0)
                                        {
                                            	msgboxPetar(dic("Settings.PasswordMust",lang))
                                        }
	                                    else{
	                                    if(passwordNov!=passwordPotvrda){
	                                        	msgboxPetar(dic("Settings.NewPasswordDontMatch",lang));  
	                                    }
	                                    else{ 
										if(golemaKirilica1>0 || malaKirilica1>0)  
										{ 
											msgboxPetar(dic('Settings.PasswordLatin',lang));  
										}
	                                  	else{ 
		                                $.ajax({
			                            url: "UpUser.php?name="+name+"&lastname="+lastname+"&email="+email+"&username="+username+"&id="+id+"&passwordNov="+passwordNov+"&phone="+phone+"&pomosno="+pomosno,
			                            context: document.body,         
			                            success: function(data){
			                            if(data == 1)
				                              {
				                              	msgboxPetar(dic("Settings.PasswordUser",lang));
				                              }
				                              else
				                              {
				                              	msgboxPetar(dic("Settings.SuccChanged",lang))
				                              	$( this ).dialog( "close" );
				                        	  	window.location.reload();
							    		      }
							    		     }
			                                });	
			                               }
	                                      } 
	                                     }
	                                    }
	                                   }
	                                  }
	                                 }
	                                }
	                               }
	                              }
	                             }
	                            },
                    {
                    text: dic("Fm.Cancel", lang),
                         click: function() {
				        $( this ).dialog( "close" );
			        },
                 }
               ]       
            });
	    }
	});
}

function loadReport()
{
	if($("#kalendarM").css('display') == "block")
		if($('#ifrmkal')[0].contentWindow.document.URL.indexOf("blank") == -1)
			$('#ifrmkal')[0].contentWindow.defaultKalendar('s');
	
    var recTest = 0;
	var sDate = $('#txtSDate').val();
	var eDate = $('#txtEDate').val();
   
	if (PrevHash == 'menu_set_10') {
		
		$('#txtSDate').val(sDate + " 00:00")
    	$('#txtEDate').val(eDate + " 23:59")
		var sDate = $('#txtSDate').val()
	    var eDate = $('#txtEDate').val()    
 	   
		page = 'LogReport.php';
	}
	if (PrevHash == 'menu_set_11') {
		
	    
		$('#txtSDate').val(sDate + " 00:00")
    	$('#txtEDate').val(eDate + " 23:59")
		var sDate = $('#txtSDate').val()
	    var eDate = $('#txtEDate').val()    
 	   
		page = 'MessageReport.php';
	}
	//alert(page + '?l=' + lang + '&sd=' + sDate + '&ed=' + eDate);
	document.getElementById('ifrm-cont').src = page + '?l=' + lang + '&sd=' + sDate + '&ed=' + eDate;
}

function AddButtonClick() {
document.getElementById('div-add-user').title = dic("Settings.AddUser")	
$('#div-add-user').dialog({ modal: true, width: 375, height: 390, resizable: false,
            buttons: 
            [
            {
             	text: dic('Settings.Add',lang),
				click: function(data) {
                    
                    var ime = $('#ime').val()
                    var prezime = $('#prezime').val()
                    var email = $('#email2').val()
                    var telefon = $('#phone2').val()
                    var username = $('#korisnicko').val()
                    var password1 = encodeURIComponent($('#password3').val())
                    var password2 = encodeURIComponent($('#password4').val())
                    
                    
                    var golemaBukva = /[A-Z]/.test(password1)
                    var malaBukva = /[a-z]/.test(password1)
                    var golemaKirilica = /[А-Ш]/.test(password1)
                    var malaKirilica = /[а-ш]/.test(password1)
                    var specijalenZnak = /[*\W]/.test(password1)
                    
                    
                    	if(ime==''){
                                  msgboxPetar(dic("Settings.EnterName", lang))
                            }else{
                                if(prezime==''){
                                  msgboxPetar(dic("Settings.EnterLastName", lang))  
                                }
                                else{
                                if(email==''){
                                  msgboxPetar(dic("Reports.EnterEmail", lang))  
                                }
                                else{
                                if(username==''){
                                  msgboxPetar(dic("enterUser",lang));  
                                }
                                else{
                                if(password1==''){
                                     msgboxPetar(dic("enterPass", lang))
                                }
                                else{
                                if(password2==''){
                                     msgboxPetar(dic("Settings.NewPasswordRepeat", lang))
                                }
                                else{
                                if(password1.length<6 || golemaBukva==0 || specijalenZnak==0)
                                        {
                                        	msgboxPetar(dic("Settings.PasswordMust",lang))
                                        }
                                else{
                                if(password2.length<6 || golemaBukva==0 || specijalenZnak==0)
                                        {
                                        	msgboxPetar(dic("Settings.PasswordMust",lang))
                                        }        
                                else{
                                if(password1!=password2){
                                    	msgboxPetar(dic("Settings.NewPasswordDontMatch",lang));  
                                }
                                else{ 
								if(golemaKirilica>0 || malaKirilica>0)  
								{ 
									msgboxPetar(dic('Settings.PasswordLatin',lang));  
								}
                                else{
                                    $.ajax({
		                              url: "AddUser.php?ime="+ime+"&prezime="+prezime+"&email="+email+"&telefon="+telefon+"&username="+username+"&password1="+password1,
		                              context: document.body,
		                              success: function(data){
		                              if(data == 1)
		                              {
		                              	msgboxPetar(dic("Settings.PasswordUser",lang));
		                              }
		                              else
		                              {
		                              	msgboxPetar(dic("Settings.SuccAdd",lang))
					    			  	$( this ).dialog( "close" );
					    			  	window.location.reload();
			                            }
			                            }
		                               });	
                                      }
                                     }
                                    }
                                   }
                                  }
                                 }
                                }
                               }
                 			  }
                             }
                            }
                           },
                           {
                         	text:dic('cancel',lang),
       			 			click:function() {
					    $( this ).dialog( "close" );
				    }
                }
            ]
        });    
    }  
   
function DelButtonClick(id) {
    var _role = document.getElementById("usr_"+id).title;
    if(_role == "3"){
    	document.getElementById('div-del-user').title = dic("Settings.DelUser")
        $('#div-del-user').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: 
                [
                 {
                 	text:dic('Settings.Yes',lang),
				    click:  function(lang) {
                      		$.ajax({
		                        url: "DelUser.php?id="+id,
		                        context: document.body,
		                        success: function(data){
		                        msgboxPetar(dic("Settings.SuccDeleted",lang));
		                        window.location.reload();
								}
		                    });	
                            $( this ).dialog( "close" );
				    	}
				    },
				    {
				    	text:dic('Settings.No',lang),
                    	click:function() {
					    $( this ).dialog( "close" );
			            }
                   }
               ]
           });
    	} 
    	else {
    	document.getElementById('div-del-admin').title = dic("Settings.Action")
        $('#div-del-admin').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: 
                [
                {
                	text:dic('Tracking.Cancel',lang),
                    click: function() {
					    $( this ).dialog( "close" );
			 	    }
                  }
                ]
             });    
          }
       }
       
function AddUserSettings(){
	var resetdrivertypeid = ($("#resetdriver option:selected").attr("value"));
	
   /* var AppSettings = '0'
    if( document.getElementById("SDradio1").checked == true){AppSettings=1}
    if( document.getElementById("SDradio2").checked == true){AppSettings=2}
    if( document.getElementById("SDradio3").checked == true){AppSettings=3}
    var DefLanguage = '0'
    if( document.getElementById("DLRadio1").checked == true){DefLanguage=1}
    if( document.getElementById("DLRadio2").checked == true){DefLanguage=2}
    if( document.getElementById("DLRadio3").checked == true){DefLanguage=3}*/
    /*var AMapsGoogle='0'
    if(document.getElementById("AMcheck1").checked == true){AMapsGoogle='1'}
    var AMapsOMS='0'
    if(document.getElementById("AMcheck2").checked == true){AMapsOMS='1'}
    var AMapsBing='0'
    if(document.getElementById("AMcheck3").checked == true){AMapsBing='1'}
    var AMapsYahoo='0'
    if(document.getElementById("AMcheck4").checked == true){AMapsYahoo='1'}
    var Satellite='0'
    if(document.getElementById("AMcheck5").checked == true){Satellite='1'}*/
   // debugger;
    var DateFormat = 'd-m-Y'
    DateFormat= $('#cbDate').val()
    var datetimeformat="";
    if($('#cbTime').val() == "24 Hour Time")
    	var _t = "H:i:s";
	else
		var _t = "h:i:s A";
	datetimeformat = $('#cbDate').val() + " " + _t;
 	
    var DefMap = '0'
    if(document.getElementById("DMRadio1").checked == true){DefMap='GOOGLEM'}
    if(document.getElementById("DMRadio2").checked == true){DefMap='OSMM'}
    if(document.getElementById("DMRadio3").checked == true){DefMap='BINGM'}
    if(document.getElementById("DMRadio4").checked == true){DefMap='YAHOOM'}
    if(document.getElementById("DMRadio5").checked == true){DefMap='GOOGLES'}
    //if(document.getElementById("DMRadio5").checked == true){DefMap=5}
    //var TimeFormat = '24 Hour Time'
    //TimeFormat= $('#cbTime').val()*/
    
    var EngineON=0
    EngineON = $('#EONColor').val()
    var EngineOFF=0
    EngineOFF = $('#EOFFColor').val()
    var EngineOFFPassengerON=0
    EngineOFFPassengerON = $('#EOFF-PON-Color').val()
    var SatelliteOFF=0
    SatelliteOFF = $('#LSColor').val()
    var taximeteron=0
    taximeteron = $('#TONColor').val()
    var TaximeterOFFPassengerON=0
    TaximeterOFFPassengerON = $('#TOFF-PON-Color').val()
    var PassiveON=0
    PassiveON = $('#EColor').val()
    var snooze=0
    snooze = $('#Snooze').val()
    
    //novite setinzi so se vo sredina
    var datetime='0'
    if( document.getElementById("datetime").checked == true){datetime=1}
    var speed='0'
    if( document.getElementById("speed").checked == true){speed=1}
    var location='0'
    if( document.getElementById("location").checked == true){location=1}
    var poi='0'
    if( document.getElementById("poi").checked == true){poi=1}
    var zone='0'
    if( document.getElementById("zone").checked == true){zone=1}
    
    
    var tipKlient=0
    tipKlient = $('#klienttip').val()
    if(tipKlient==2){
    	var passengers='0'
   		if( document.getElementById("passengers").checked == true){passengers=1}
    }
    else
    {
    	var passengers='0'
    }
    
    var taximeter='0'
    if( document.getElementById("taximeter").checked == true){taximeter=1}
    var fuel='0'
    if( document.getElementById("fuel").checked == true){fuel=1}
    var active='1'
    //var active='0'
    //if( document.getElementById("cbOnOff").checked == true){active=1}
    
    
    var canbasIma=0
    canbasIma = $('#canbasIma').val()
    if(canbasIma>0){
	    var cbfuel='0'
	    if( document.getElementById("cbFuel").checked == true){cbfuel=1}
	    var cbRpm='0'
	    if( document.getElementById("RPM").checked == true){cbRpm=1}
	    var cbTemperature='0'
	    if( document.getElementById("Temperature").checked == true){cbTemperature=1}
	    var cbDistance='0'
	    if( document.getElementById("Distance1").checked == true){cbDistance=1}
	}
	
	var trace =0
    trace = $('#TimeTrack').val()
    var idleOver =0
    idleOver = $('#idleOverTime').val()
    
    var Kilometri ='0'
	Kilometri = $('#Kilometri').val()

    var show = '1'
    if(document.getElementById("cbOnOff").checked == true){show = '1'} else {show = '0'}
	var start='0'
	start = $('#start').val()
    var km_start='0'
    km_start = $('#km_start').val()
    var cena_km='0'
    cena_km = $('#cena_km').val()
    var valutata=0
    valutata = $('#valuta').val()
    var tecnost=0
    tecnost = $('#tecnost').val()
    var tarifa=0
    tarifa = $('#tarifa').val()

	var city = $("#city option:selected")[0].id;
    if(city == 0)
	{
		mymsg("Треба да внесете град");
		return false;
	}
	
	if(canbasIma>0){
    	var string = "SaveUserSettings.php?datetimeformat="+datetimeformat+"&cbfuel="+cbfuel+"&cbRpm="+cbRpm+"&cbTemperature="+cbTemperature+"&cbDistance="+cbDistance+"&DefMap="+DefMap+"&EngineON="+EngineON+"&EngineOFF="+EngineOFF+"&EngineOFFPassengerON="+EngineOFFPassengerON+"&SatelliteOFF="+SatelliteOFF+"&taximeteron="+taximeteron+"&TaximeterOFFPassengerON="+TaximeterOFFPassengerON+"&datetime="+datetime+"&PassiveON="+PassiveON+"&speed="+speed+"&location="+location+"&poi="+poi+"&zone="+zone+"&passengers="+passengers+"&taximeter="+taximeter+"&fuel="+fuel+"&trace="+trace+"&idleOver="+idleOver+"&metric="+Kilometri+"&active="+active+"&start="+start+"&km_start="+km_start+"&cena_km="+cena_km+"&valutata="+valutata+"&tecnost="+tecnost+"&tarifa="+tarifa+"&snooze="+snooze + "&city=" + city + "&resetdrivertypeid=" + resetdrivertypeid;
    }
    else{
    	var string = "SaveUserSettings.php?datetimeformat="+datetimeformat+"&DefMap="+DefMap+"&EngineON="+EngineON+"&EngineOFF="+EngineOFF+"&EngineOFFPassengerON="+EngineOFFPassengerON+"&SatelliteOFF="+SatelliteOFF+"&taximeteron="+taximeteron+"&TaximeterOFFPassengerON="+TaximeterOFFPassengerON+"&datetime="+datetime+"&PassiveON="+PassiveON+"&speed="+speed+"&location="+location+"&poi="+poi+"&zone="+zone+"&passengers="+passengers+"&taximeter="+taximeter+"&fuel="+fuel+"&trace="+trace+"&idleOver="+idleOver+"&metric="+Kilometri+"&active="+active+"&start="+start+"&km_start="+km_start+"&cena_km="+cena_km+"&valutata="+valutata+"&tecnost="+tecnost+"&tarifa="+tarifa+"&snooze="+snooze + "&city=" + city + "&resetdrivertypeid=" + resetdrivertypeid;
    }
    
    function timedRefresh(timeoutPeriod) {
		setTimeout("location.reload(true);",timeoutPeriod);
	}
	
    $.ajax({
    	url: string,
        context: document.body,
        success: function(data){
        	msgboxPetar(dic("succSaved", lang));
        	timedRefresh(2000);
        }
    });
  }
 
//function OnOffChange(){
//    if(document.getElementById("cbOnOff").checked == true){
//        document.getElementById("laOnOff").InnerHTML = 'ON';
//    }   
//    if(document.getElementById("cbOnOff").checked == false){
//        document.getElementById("laOnOff").InnerHTML = 'OFF';
//    }  
//}


function ShowVehicles(_uid)
{
	//alert(_uid)
    var uid = _uid;
    var selected = ''
    ShowWait()
    $.ajax({
        url: "UserVehicles.php?uid="+uid+"&l=" + lang,
        context: document.body,
        success: function(data){
            HideWait()
            $('#div-vehicles-user').html(data)
            $('#div-vehicles-user').dialog({  modal: true, width: 450, height: 400, resizable: true,
                 buttons: 
                 [
                 {
                 	text: dic("Settings.Add", lang),
				    click: function() {
              		 
              		   var inputs = document.getElementsByTagName("input");
					         for (var i = 0; i < inputs.length; i++) {
                                 if (inputs[i].type == "checkbox") {
									if (inputs[i].checked && inputs[i].value != "*") {
                                         selected += inputs[i].value + "*"
                                     }
                                 }
                             }
                      		 $.ajax({
                                    url: "InsertUserVehicles.php?selected=" + selected + "&uid="+uid,
                                	context: document.body,
		                        	success: function(){
		                        	alert(dic("succSaved",lang))
                                    window.location.reload();
		                        }
		                    });	
                         $( this ).dialog( "close" );
                        
                       }
                    },
                    {
                    text: dic("Fm.Cancel", lang),
                    click: function() {
                    	//window.location.reload();
					    $( this ).dialog( "close" );
					},
                }
                ]
               
            })
        }
    });
}

function SetHeightSettingsPetar(){
	var _h = document.body.clientHeight;
	var _l = (document.body.clientWidth-100)/2;
	$('#report-content').css({height:(_h-60)+'px'});
	$('#ifrm-cont').css({height:(_h-60)+'px'});
	$('#div-menu').css({height:(_h-32)+'px'});
	$('#div-loading').css({left:(_l)+'px'});
    $('#optimizedNarrative').css({left: (document.body.clientWidth - parseInt($('#optimizedNarrative').css('width'), 10) - 12)+'px'});
    $('#advancedNarrative').css({left: (document.body.clientWidth - parseInt($('#advancedNarrative').css('width'), 10) - 12)+'px'});
    $('#showElevationChart').css({left: (document.body.clientWidth - parseInt($('#showElevationChart').css('width'), 10) - 12)+'px'});
    $('#showElevationChart').css({top: '440px'});
}

var PrevHash = '';
function checkHash() {
	//alert(window.location.hash)

    var ifEqual = 0
    var ifFirst = 1
    var h = location.hash
    if (h == null) { h = '' }
    if (PrevHash == null) { PrevHash = '' }
    h = h.replace('#settings/', '')
    PrevHash = PrevHash.replace('#settings/', '')
    //alert("h"+h)
    //alert("prev"+PrevHash)
    if ((h != '') && (h != PrevHash)) {
        //alert(1)
        var objPrev = null
        var objCurr = null
        objPrev = document.getElementById(PrevHash)
        objCurr = document.getElementById(h)
        //alert("curr"+objCurr)
        //alert("prev"+objPrev)

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
                    //if (objCurr.className != 'repoMenu1 corner5 text2')
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
        location.hash = '#settings/' + PrevHash
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
    if (event.target.location.pathname.indexOf("LoadMap.php") != -1)
        return false;
    checkHash()

    //LoadData()
});

function LoadData(_i, _j, _equal, _first){
	//alert(1)
    //ShowWait();	
    var recTest = 0
	//var Vhc = $('#txtVehicles').val().split('#')[0]
	
	//$('#stt-cont').css({display: 'none'});
    $('#ifrm-cont').css({display: 'block'});
	//document.getElementById('lbl-end-date').style.display=''
	
	var page = ''
	//alert(PrevHash)
	if (PrevHash == 'menu_set_1') {
	    page = 'USettings.php'
	    document.getElementById('ifrm-cont').src = './USettings.php?l='+lang;
	    
	}

	if (PrevHash == 'menu_set_2') {
	    page = 'CSettings.php'
	     document.getElementById('ifrm-cont').src = './CSettings.php?l='+lang;
	}
	if(PrevHash=='menu_set_3')
	{
		page='GroupPOI.php'
		document.getElementById('ifrm-cont').src = './GroupPOI.php?l='+lang;
	}
	if(PrevHash=='menu_set_4')
	{
		page='Vehicles.php'
		document.getElementById('ifrm-cont').src = './Vehicles.php?l='+lang;
	}
	if(PrevHash=='menu_set_5')
	{
		page='Organisation.php'
		document.getElementById('ifrm-cont').src = './Organisation.php?l='+lang;
	}
	if(PrevHash=='menu_set_6')
	{
		page='Drivers.php'
		document.getElementById('ifrm-cont').src='./Drivers.php?l='+lang;
	}
	if(PrevHash=='menu_set_7')
	{
		page='WorkTime.php'
		document.getElementById('ifrm-cont').src='./WorkTime.php?l='+lang;
	}
	if(PrevHash=='menu_set_8')
	{
		page='Schedulers.php'
		document.getElementById('ifrm-cont').src='./Schedulers.php?l='+lang;
	}
	if(PrevHash=='menu_set_9')
	{
		page='AllAlerts.php'
		document.getElementById('ifrm-cont').src='./AllAlerts.php?l='+lang;
	}
	if(PrevHash=='menu_set_10')
	{
		page='LogReport.php'
		document.getElementById('ifrm-cont').src='./LogReport.php?l='+lang;
		loadReport();
	}
	if(PrevHash=='menu_set_11')
	{
		page='MessageReport.php'
		document.getElementById('ifrm-cont').src='./MessageReport.php?l='+lang;
		loadReport();
	}
}
 function modifyUnit_(i, id, l) {
        top.ShowWait();
        document.getElementById('div-add').title = dic("modOrgUnit", l);
        
        $.ajax({
            url: 'ModifyOrgUnit.php?id=' + id + '&l=' + l, 
            context: document.body,
            success: function (data) {
                $('#div-add').html(data)
                $('#div-add').dialog({ modal: true, height: 280, width: 455,
                    buttons:
                     [
                     {
                         text: dic("change", l),
                         click: function () {
                             top.ShowWait();

                             var code = document.getElementById("code").value;
                             var name = document.getElementById("name").value;
                             var desc = document.getElementById("desc").value;

                             
                             $.ajax({
                                 url: "UpdateOrgUnit.php?code=" + code + "&name=" + name + "&desc=" + desc + "&id=" + id,
                                 context: document.body,
                                 success: function (data) {
                                     top.document.getElementById('ifrm-cont').src = "Organisation.php?l=" + '<?php echo $cLang?>';
                                 }
                             }); 
                         }
                     },
                         {
                             text: dic("cancel", l),
                             click: function () {

                                 top.ShowWait();
                                 top.document.getElementById('ifrm-cont').src = "Organisation.php?l=" + l;

                                 $(this).dialog("close");
                             }
                         }

                     ]
                });
            }
        });
         }
 function addOrgUnit_(l) {
        ShowWait();
        document.getElementById('div-add').title = dic("addOrgUnit", l);
        $.ajax({
            url: 'AddNewOrgUnit.php?l=' + l,
            context: document.body,
            success: function (data) {
            	HideWait()
                $('#div-add').html(data)
                $('#div-add').dialog({ modal: true, height: 280, width: 455,
                    buttons:
                     [
                     {
                         text: dic("add", l),
                         click: function () {
                             top.ShowWait();

                             var kod = document.getElementById("code").value;
                             var orgUnit = document.getElementById("orgUnit").value;
                             var desc = document.getElementById("desc").value;

                             $.ajax({
                                 url: "InsertOrgUnit.php?kod=" + kod + "&orgUnit=" + orgUnit + "&desc=" + desc,
                                 context: document.body,
                                 success: function (data) {
                                     top.document.getElementById('ifrm-cont').src = "Organisation.php?l=" + '<?php echo $cLang?>';
                                 }
                             }); 
                         }
                     },
                         {
                             text: dic("cancel", l),
                             click: function () {

                                 top.ShowWait();
                                 top.document.getElementById('ifrm-cont').src = "Organisation.php?l=" + l;

                                 $(this).dialog("close");
                             }
                         }

                     ]
                });
            }
        });
    }

function del(id, l, table) {
        document.getElementById('div-add').title = dic("delEnt", l);

        var selected = "";

        $.ajax({
            url: 'Delete.php?l=' + lang,
            context: document.body,
            success: function (data) {
                $('#div-add').html(data)
                $('#div-add').dialog({ modal: true, height: 200, width: 330,
                    buttons:
                     [
                     {
                         text: dic("yes", l),
                         click: function () {
                             $.ajax({
                                 url: "DeleteItem.php?id=" + id + "&table=" + "" + table + "",
                                 context: document.body,
                                 success: function (data) {
                                     $(this).dialog("close");
                                     if (table == "organisation") {
                                         top.document.getElementById('ifrm-cont').src = "Organisation.php?l=" + l;
                                     }
                                     if (table == "vehicles") {
                                         top.document.getElementById('ifrm-cont').src = "Vehicles.php?l=" + l;
                                     }
                                     if (table == "drivers") {
                                         top.document.getElementById('ifrm-cont').src = "Drivers.php?l=" + l;
                                     }
                                     if (table == "service") {
                                         top.document.getElementById('ifrm-cont').src = "Service.php?l=" + l;
                                     }
                                     if (table == "costs") {
                                         top.document.getElementById('ifrm-cont').src = "OtherCosts.php?l=" + l;
                                     }
                                 }
                             });
                         }
                     },
                         {
                             text: dic("no", l),
                             click: function () {
                                 $(this).dialog("close");
                             }
                         }

                     ]
                });
            }
        });
   }
function addAllDriver(lang, vehId) {
	
		ShowWait()
		var selected = "";
    	$.ajax({
	    url: "AddAllowedDriver.php?lang=" + lang + "&veh=" + vehId,
	    context: document.body,
	    success: function(data){
            HideWait()
		    $('#div-add').html(data)
		    document.getElementById('div-add').title = dic("Fm.AddAllDriver")
            $('#div-add').dialog({ modal: true, width: 400, height: 400, resizable: false,
	            buttons:
                     [
                     {
                         text: dic("add", lang),
                         click: function () {

                         var inputs = document.getElementsByTagName("input");  
                                                 
                             for (var i = 0; i < inputs.length; i++) {
                                 if (inputs[i].type == "checkbox") {

                                     if (inputs[i].checked && inputs[i].value != "*") {
                                         selected += inputs[i].value + "*"
                                     }
                                 }
                             }
                                                   
                             if (selected != "") {
                                 $.ajax({
                                     url: "InsertAllowedDriver.php?selected=" + selected + "&vehID=" + vehId,
                                     context: document.body,
                                     success: function (data) {
                                     $(this).dialog("close");
                                     top.document.getElementById('ifrm-cont').src = "ModifyVehicle.php?id=" + vehId + "&lang=" + "" + lang + "";
                                     }
                                 });
                             }
                             else {
                                 mymsg(dic("oneDriver", lang));
                             }
                         }
                     },
                         {
                             text: dic("cancel", lang),
                             click: function () {
                                 $(this).dialog("close");
                             }
                         }

                     ]
                });
            }
        });
    }   

/*     КОД ОД LIVE1.JS*/

function DrawZoneOnLiveSettings(areaID, _color){
    var tf = 0;
    if (ArrAreasId != "") {
        for (var z = 0; z < Maps.length; z++) {
            if (ArrAreasId[z] != undefined) {
                for (var i = 0; i < ArrAreasId[z].length; i++) {
                    if (ArrAreasId[z][i] == areaID) {
                        vectors[z].addFeatures([ArrAreasPoly[z][i]]);
                        controls[z].select.activate();
                        ArrAreasCheck[z][i] = 1;
                        tf = 1;
                        Maps[z].zoomToExtent(ArrAreasPoly[z][i].layer.getDataExtent());
                    }
                }
            }
        }
        HideWait();
    }
    if (tf == 0) { PleaseDrawAreaAgain(areaID, _color) }
}

function PleaseDrawAreaAgainSettings(areaID, _color) {
    GlobalTempArea = areaID;
    $.ajax({
        url: "getAreaPoints.php?id=" + areaID,
        context: document.body,
        success: function (data) {
            var d = data.split("%^")[0];
            d = d.substring(d.indexOf("((")+2, d.indexOf("))")).split(",");
            var _lon = ""; var _lat = "";
            for(var i=0; i<d.length; i++)
            {
            	_lon += d[i].split(" ")[1] + (i == (d.length-1) ? "" : ",");
            	_lat += d[i].split(" ")[0] + (i == (d.length-1) ? "" : ",");
            }
            var _name = data.split("%^")[1];
            var _avail = data.split("%^")[2];
            var _cant = data.split("%^")[3];
            var _gfgid = data.split("%^")[4];
            var _alarmsH = data.split("%^")[5];
            var _alarmsVeh = data.split("%^")[6];
            var ret = DrawPolygon(_lon, _lat, false, _color, _name, areaID, _avail, _cant, _gfgid, _alarmsH, _alarmsVeh);
            AddAreaToArray(ret, areaID);
            onFeatureSelect(ret[0].layer.features[0]);
            EditPoly();
            //var bounds = new OpenLayers.Bounds();
            //bounds.extend(ret[0].layer.getDataExtent());
            map.zoomToExtent(ret[0].layer.getDataExtent());
            HideWait();
        }
    });
}

function SetHeightLite(){
	try{
		
	var ifrm =top.document.getElementById('ifrm-cont') 
	var _h = 0
	if (ifrm!=null){
		_h = ifrm.offsetHeight
	} else {
		_h = document.body.clientHeight
	}
	var _w = document.body.clientWidth
	$('#report-content').css({height:(_h)+'px'})
	
	
}
catch(e){

}
	
}

function iPadSettingsLite(){
	if (Browser()!='iPad') {
		//document.getElementById('div-menu').className = 'scrollY'
	} else {

		
		var RepCont = $('#report-content').html()
		$('#report-content').html('<div id="scroll-cont-div"></div>')
		$('#scroll-cont-div').html(RepCont)
			
		myScrollContainer = new iScroll('scroll-cont-div');
		iPad_Refresh();
	}	
}
function HideLoading(){
	$('#div-loading').hide('fast')
}


// =======================



