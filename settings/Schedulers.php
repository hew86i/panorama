<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>


<?php 
	header("Content-type: text/html; charset=utf-8");
	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	$yourbrowser1 = (bool) strpos($ua['userAgent'], "Macintosh");
	
	addlog(46);
	
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<style type="text/css">
	<?php
	if($yourbrowser == "1")
	{?>
		html { 
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch; 
		}
		body {
		    height: 100%;
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch;
		}
	<?php
	}
	?>
	</style>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

	<script>
	function msgboxPetar(msg) {
    $("#DivInfoForAll").css({ display: 'none' });
    $('#div-msgbox').html(msg)
    $("#dialog-message").dialog({
        modal: true,
        zIndex: 9999, resizable: false,
        buttons: {
            Ok: function () {
                $(this).dialog("close");
        	}
        }
    });
	}
	</script>
	
	<script>
	function modifyDriver(index, userID, l) {
    var l = document.location.href.split("?")[1].split("&")[0].split("=")[1];
	document.getElementById("div-add-schedule").title = dic("Reports.AddSchedule", l);
	
    var path = document.location.href.split("/")[2];
    if (path.indexOf("gps.mk") != -1 || path.indexOf("localhost") != -1) {
        path = "gps"
    }

    if (path.indexOf("app.pan") != -1) {
        path = "app"
    }
    /*if (path == "gps.mk" || path == "localhost") {
        path = "gps"
    }
    else
        if (path == "app.panopticsoft.com") {
            path = "app"
        }*/

          $.ajax({
               url: 'scheduler.php?index=' + index + '&lang=' + l,
               context: document.body,
               success: function (data) {
                   $('#div-add-schedule').html(data)
                  // document.getElementById('cbReports').selectedIndex = index
                   $('#div-add-schedule').dialog({ modal: true, height: 380, width: 430,
                       buttons: [
                       
                       {
                             text: dic("add", l),
                             click: function () {
                                 var rep = ''
                               var report = $('#cbReports').val()
                              
                               if (report == "Dashboard") { rep = "overview" }
                               if (report == "FleetReport") { rep = "FleetReport" }
                               if (report == "SummTaxi") { rep = "SummTaxiReport" }
                               if (report == "Overview") { rep = "OverviewV" }
                               if (report == "ShortReport") { rep = "ShortReport" }
                               if (report == "DetailReport") { rep = "Detail" }
                               if (report == "VisitedPointsOfInterest") { rep = "VehiclePOI" }
                               if (report == "Reconstruction") { rep = "Reconstruction" }
                               if (report == "TaxiReport") { rep = "TaxiReport" }
                               if (report == "GeoFenceReport") { rep = "GeofenceReport" }
                               if (report == "IdlingReport") { rep = "IdlingReport" }
                               if (report == "DistanceTravelled") { rep = "AnalDistance" }
                               if (report == "Activity") { rep = "AnalActivity" }
                               if (report == "MaxSpeed") { rep = "AnalSpeed" }
                               if (report == "SpeedLimitExcess") { rep = "AnalSpeedEx" }

                              // var veh = $('#cbVehicles').val()
                            
                               var veh = $('#cbVehicles').val().split(" ")[0]
							   //var veh = $('#cbVehicles').val()
								
                               var range = $('#cbRange').val()
                               var per = $('#cbPeriod').val()
                               var day = $('#cbDay').val()
                               var date = $('#cbDate1').val()
                               var saati = $('#cbTimeHours').val()
                               //var minuti = $('#cbTimeMinutes').val()
                               //var uid = '<%=Session("user_id") %>'
                               _list = document.getElementById('div-email')
                               var email = ''
                               var emailID = ''
                               if (_list.childNodes.length > 0) {
                                   for (var k = 0; k < _list.childNodes.length; k++) {
                                       if (_list.childNodes[k].checked == true) {
                                           emailID = _list.childNodes[k].alt
                                           email += document.getElementById('email_' + emailID).value + ';'
                                       }
                                }
                            }
                            //alert(email)
                            var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
                            if (email == ";") {
                                document.getElementById('sNote').innerHTML = dic("noEmail", l);
                            }
                            else {
                                var emailArr = email.split(";")
                                var cntEmail = 0
                                for (var i = 0; i < emailArr.length - 1; i++) {
                                    if (emailArr[i].match(emailExp)) {
                                        cntEmail = cntEmail + 1;
                                    }
                                }


                                if (cntEmail != emailArr.length - 1) {
                                    document.getElementById('sNote').innerHTML = dic("uncorrEmail", l);
                                }
                                else {
                                    $.ajax({
                                        url: "schedulerSave.php?rep=" + rep + "&veh=" + veh + "&range=" + range + "&per=" + per + "&day=" + day + "&date1=" + date + "&saati=" + saati + "&email=" + email + "&uid=" + userID + "&path=" + path,
                                        context: document.body,
                                        success: function (data) {
                                        	//alert(data)
                                            msgboxPetar(dic("SucAddSch", lang));
                                            document.getElementById('sNote').innerHTML = dic("SchNote", l);
                                            
                                        }
                                    });
                                }
                            }
                             }
                         },
                      ]
                   });
               }
           });
          }
          
          function DelSchedulers(id) {
          document.getElementById('div-del-schedule').title = dic("Settings.DelSch1")
		  $('#div-del-schedule').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: 
                [
                {
                	text:dic("Settings.Yes",lang),
				    click: function() {
                            $.ajax({
		                        url: "DelSchedulers.php?id="+ id ,
		                        context: document.body,
		                        success: function(data){
		                        window.location.reload();
								}
		                    });	
                            $( this ).dialog( "close" );
                           }
				    },
				    {
				    	text:dic("Settings.No",lang),
                    click: function() {
					    $( this ).dialog( "close" );
				    }
               }
               ]
          });
          }
          function modifyDriver1(id,i) {
         	ShowWait();
          $.ajax({
		  url: "scheduler.php?id="+id+"&l="+lang,
		  
		  context: document.body,
		  success: function(data){
                HideWait()
			    $('#div-edit-schedule').html(data)
			    document.getElementById('div-edit-schedule').title = dic("Settings.EditSchedule")
                $('#div-edit-schedule').dialog({ modal: true, width: 450, height: 450, resizable: false,
           			buttons:
           			[
           			 {
           			 	text:dic("Fm.Save",lang),
				        click: function() {
				        	
				        	var uid = '<?php echo Session("user_id") ?>'
				        	var izvestaj=0 
				            izvestaj = $('#cbReports').val()
				            var vozilo = 0
		                    vozilo = $('#cbVehicles').val()
		                    var razmerPristig = 0
		                    razmerPristig = $('#cbRange').val()
		                    var perPristig = 0
		                    perPristig = $('#cbPeriod').val()
		                    var denPristig = 0
		                    denPristig = $('#cbDay').val()
		                    var vremePristig = 0
		                    vremePristig = $('#cbTimeHours').val()
		                    
		                 	var email = $('#email').val();
		                    var input = $('input[name=doc]:radio:checked').val();
		                   
		                    $.ajax({
                            	url: "UpScheduler.php?id="+id + "&uid=" + uid+ "&izvestaj=" + izvestaj+ "&vozilo=" + vozilo+ "&razmerPristig=" + razmerPristig+ "&perPristig=" + perPristig+ "&denPristig=" + denPristig + "&vremePristig=" + vremePristig+ "&email=" + email+ "&input=" + input,
		                        context: document.body,
		                        success: function(data){
		                        msgboxPetar(dic("Settings.SuccChanged",lang))
		                        window.location.reload();
								}
		                    });	
                            $( this ).dialog( "close" );
                           }
				    },
				    {
				    	text:dic("cancel",lang),
                    click: function() {
					    $( this ).dialog( "close" );
				    }
               }
               ]
          });
          }
          });
          }
	</script>
	<link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../live/style.css">

	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/roundIE.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
    <script type="text/javascript" src="../pdf/pdf.js"></script>
	<script type="text/javascript" src="fm.js"></script>
	<script type="text/javascript" src="./js/highcharts.src.js"></script>
  
    <link href="../css/ui-lightness/jquery-ui-1.8.1	4.custom.css" rel="stylesheet" type="text/css" />
    <script src="../js/jquery-ui.js"></script>
	<style type="text/css"> 
 		body{ overflow-y:auto }
	</style>
<body>
 	
 <?php
     $cnt_1 = 1;
     $cnt_ = 1; 
	 opendb();
 ?>
  
  <script>
	if (!<?php echo is_numeric(session('user_id')) ?>)
	top.window.location = "../sessionexpired/?l=" + '<?php echo $cLang ?>';
  </script>
  
 <div id="div-add" style="display:none" title=""></div>
    <div id="dialog-message" title="<?php dic("Reports.Message")?>" style="display:none">
         <p>
	        <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
	        <div id="div-msgbox" style="font-size:14px"></div>
        </p>
    </div>

    <!--<div id="report-content" style="width:100%; background-color:#fafafa; margin-bottom:50px; overflow-y:auto; overflow-x:hidden" class="corner5">
-->
	    <div class="textTitle" style="padding-left:<?php if($yourbrowser == "1") { echo '20px'; } else { echo '35px'; } ?>; padding-top:30px;"><?php echo dic_("Settings.Scheduler")?><br />
		</div>
		<?php
             $cnt  = 1;
       		 $cnt1 = 1;
       		 $cnt2 = 1;
             $proverka = "select * from scheduler where clientid=" . $_SESSION['client_id'];
             $prov = query($proverka);
			 if(pg_num_rows($prov)==0)
			 {
			 ?>
			 <br><br>
			 <div id="noData" style="padding-left:40px; font-size:30px; font-style:italic; padding-bottom:40px" class="text4">
     		 <?php dic("Reports.NoData1")?>
			 </div>	
			 <?php	
			 }
			 else
			 {
             ?>
		<br>
        <table id="tabId<?php echo $cnt2 ?>" width="<?php if($yourbrowser == "1") { echo '94%'; } else { echo '94%'; } ?>;" border="0"  style="<?php if($yourbrowser == "1") {?>padding-bottom:30px;<?php }?> margin-top:30px; margin-left:<?php if($yourbrowser == "1") { echo '20px'; } else { echo '35px'; } ?>;">
        <tr>
			<td align = "left" colspan = "11" valign = "middle" height="<?php if($yourbrowser == "1") { echo '30px'; } else { echo '30px'; } ?>" width = "90%" class="text2" style="color:#fff; font-weight:bold; font-size:14px;  padding-left:5px; background-color:#f7962b; font-weight:bold;" ><?php echo dic_("Settings.AutomaticSendReports")?></td>
		</tr>
	    <tr>
            <td height="<?php if($yourbrowser == "1") { echo '40px'; } else { echo '30px'; } ?>;" align="left" class="text2" style="font-weight:bold;font-size:<?php if($yourbrowser == "1") { echo '9px'; } else { echo '11px'; } ?>;; background-color:#E5E3E3; border:1px dotted #2f5185;">&nbsp;</td>
            <td width="30%" height="<?php if($yourbrowser == "1") { echo '40px'; } else { echo '30px'; } ?>;" align="left" class="text2" style="font-weight:bold;font-size:<?php if($yourbrowser == "1") { echo '9px'; } else { echo '11px'; } ?>;; background-color:#E5E3E3; border:1px dotted #2f5185;">&nbsp;&nbsp;<?php echo dic_("Reports.Report")?></td>
            <td width="19%" height="<?php if($yourbrowser == "1") { echo '40px'; } else { echo '30px'; } ?>;" align="center" class="text2" style="font-weight:bold;font-size:<?php if($yourbrowser == "1") { echo '9px'; } else { echo '11px'; } ?>;; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php echo dic_("Settings.Vehicle")?></td> 
            <td width="18%" height="<?php if($yourbrowser == "1") { echo '40px'; } else { echo '30px'; } ?>;" align="center" class="text2" style="font-weight:bold;font-size:<?php if($yourbrowser == "1") { echo '9px'; } else { echo '11px'; } ?>;; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php echo dic("Reports.PeriodRec")?></td>
            <td width="15%" height="<?php if($yourbrowser == "1") { echo '40px'; } else { echo '30px'; } ?>;" align="left" class="text2" style="font-weight:bold;font-size:<?php if($yourbrowser == "1") { echo '9px'; } else { echo '11px'; } ?>;; background-color:#E5E3E3; border:1px dotted #2f5185;">&nbsp;&nbsp;<?php echo dic("Reports.Email")?></td>
            <td width="10%" height="<?php if($yourbrowser == "1") { echo '40px'; } else { echo '30px'; } ?>;" align="center" class="text2" style="font-weight:bold; font-size:<?php if($yourbrowser == "1") { echo '9px'; } else { echo '11px'; } ?>;;background-color:#E5E3E3; border:1px dotted #2f5185;"><?php echo dic("Reports.DateTimeRange")?></td>
            <td width="5%" height="<?php if($yourbrowser == "1") { echo '40px'; } else { echo '30px'; } ?>;" align="center" class="text2" style="font-weight:bold;font-size:<?php if($yourbrowser == "1") { echo '9px'; } else { echo '11px'; } ?>;; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php echo dic_("Settings.DocumentType")?></td>
            <td width="8%" height="<?php if($yourbrowser == "1") { echo '40px'; } else { echo '30px'; } ?>;" align="center" class="text2" style="font-weight:bold;font-size:<?php if($yourbrowser == "1") { echo '9px'; } else { echo '11px'; } ?>;;background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633"><?php dic("Fm.Mod") ?></td>
            <td width="8%" height="<?php if($yourbrowser == "1") { echo '40px'; } else { echo '30px'; } ?>;" align="center" class="text2" style="font-weight:bold; font-size:<?php if($yourbrowser == "1") { echo '9px'; } else { echo '11px'; } ?>;;background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633"><?php dic("Fm.Delete")?></td>
        </tr>


                 <?php
                     $sqlSch = "";
                     $paren = "";
                     $id = 0;
                     $cnt_1 = $cnt;
                     $sqlSch = "select * from scheduler where clientid=" . $_SESSION['client_id'];
                     $dsSch = query($sqlSch);
                         $cntN = 0;
                      	 while ($drSch = pg_fetch_array($dsSch)) {
                      	 	$cntN = $cntN +1;
                             $veh = $drSch["vehicle"]; 
							 if ($veh == "0") $veh = dic_("Reports.AllVehicles");
							 $period = dic_("Reports." . $drSch["period"] . "");
							 $day = "";
							 if ($drSch["day"] <> "") $day = dic_("Reports." . $drSch["day"] . "");
							 $ranArr = explode("Last", $drSch["range"]);
							 
							 if ($ranArr[1] > 1) $range = $ranArr[1] . " " . dic_("Reports.Days_");
							 else $range =$ranArr[1] . " " . dic_("Reports.Day_");
							 
							 $report = dic_("Reports." . $drSch["report"]);	
							 if($drSch["report"] == "CustomizedReport")
							 {
							 	$report = dlookup("select name from reportgenerator where id = ".$drSch["repid"]);
							 }						 
                ?>                                                        
              
             	<tr id="veh<?php echo $cnt_1 ?>" style="cursor:pointer" onmouseover="over(<?php echo $cnt_ ?>, 1)" onmouseout="out(<?php echo $cnt_ ?>, 1)">
					<td align="center" class="text2" style="padding-left:10px; padding-right:10px; background-color:#fff; border:1px dotted #B8B8B8; "><?php echo $cntN ?></td>	               
	                <td id="_td-1-<?php echo $cnt_ ?>" height="<?php if($yourbrowser == "1") { echo '40px'; } else { echo '15px'; } ?>" align="left" class="text2" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8; "><?php echo $report?></td>
	                <td id="_td-2-<?php echo $cnt_ ?>" height="<?php if($yourbrowser == "1") { echo '40px'; } else { echo '15px'; } ?>" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo $veh?></td>
	                <td id="_td-3-<?php echo $cnt_ ?>" height="<?php if($yourbrowser == "1") { echo '40px'; } else { echo '15px'; } ?>" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo $period?>&nbsp;<?php if($day != ""){?>(<font color = "#ff6633"><?php echo ($day)?></font>)<?php }?><br><b>(<?php echo $drSch["time"]?>)</b></td>          
	                <td id="_td-4-<?php echo $cnt_ ?>" height="<?php if($yourbrowser == "1") { echo '40px'; } else { echo '15px'; } ?>" align="left" class="text2" style="padding-left:10px; background-color:#fff; line-height:16px; border:1px dotted #B8B8B8;">	                	
						<?php 
						$emls = $drSch["email"];
	                	$emls = str_replace(';','<br>',$emls);
						echo $emls 
						?>
					</td>
	                <td id="_td-5-<?php echo $cnt_ ?>" height="<?php if($yourbrowser == "1") { echo '40px'; } else { echo '15px'; } ?>" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo $range?></td>
	                <td id="_td-6-<?php echo $cnt_ ?>" height="<?php if($yourbrowser == "1") { echo '40px'; } else { echo '15px'; } ?>" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
	                <?php 
	                	if ($drSch["doctype"]=='pdf') {
	                		echo '<img src="../images/pdf-ext.png" align="absmiddle">';
	                	} else {
	                		echo '<img src="../images/xls-ext.png" align="absmiddle">';	                	
	                	};

	                ?>
	                </td>
	                <td id="_td-7-<?php echo $cnt_ ?>" height="<?php if($yourbrowser == "1") { echo '40px'; } else { echo '15px'; } ?>" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
	                    <button id="_modBtn-<?php echo $cnt_ ?>" onclick="modifyDriver1(<?php echo $drSch["id"] ?>,<?php echo $cnt_1 ?> )" style="height:22px; width:30px"></button>
	                </td>
	                <td id="td-8-<?php echo $cnt ?>" height="40px" align="center" class="text2 <?php echo $paren ?>" style="background-color:#fff; border:1px dotted #B8B8B8;">
	                    <button id="_delBtn-<?php echo $cnt_ ?>" onclick="DelSchedulers(<?php echo $drSch["id"] ?>, '<?php echo $cLang ?>', 'drivers')" style="height:22px; width:30px"></button>
	                </td>
           		</tr>

             <?php
                              $cnt_ = $cnt_ + 1;
                              $cnt_1 = $cnt_1 + 1;
                   } 
             } 
                 
			closedb();
                            
            ?>
   </table>
  <!-- </div>-->
  <br><br>
   <div id="div-add-schedule" style="display:none" title="<?php echo dic("Settings.EditSchedule")?>"></div>
   <div id="div-del-schedule" style="display:none" title="<?php echo dic("Settings.DelSch1")?>">
        <?php echo dic("Settings.DelSch")?>
    </div>
    <div id="div-edit-schedule" style="display:none" title="<?php echo dic("Settings.EditSchedule")?>">
        
    </div>
    
    <div id="dialog-message" title="<?php echo dic("Reports.Message")?>" style="display:none">
	 <p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px"></div>
	 </p>
	</div>
	
</body>

<script>
 top.HideWait();
 
  
    for(var i = 0; i < <?php echo $cnt_ ?>; i ++) {
        $('#_modBtn-' + i).button({ icons: { primary: "ui-icon-pencil"} });
        $('#_delBtn-' + i).button({ icons: { primary: "ui-icon-trash"} });
    }

    function over(i, x, act, gps) {
        if (x == 1) {
             for (var j = 1; j < 5; j++) {
                document.getElementById("_td-" + j + "-" + i).style.color = "blue";
            }

            document.getElementById("_modBtn-" + i).style.border = "1px solid #0000ff";
            document.getElementById("_delBtn-" + i).style.border = "1px solid #0000ff";
        }
        else {
            for (var j = 1; j < 5; j++) {
                document.getElementById("td-" + j + "-" + i).style.color = "blue";
            }
           
            document.getElementById("modBtn" + i).style.border = "1px solid #0000ff";
            document.getElementById("delBtn" + i).style.border = "1px solid #0000ff";
        }
    }

    function out(i, x, act, gps) {
        if (x == 1) {
             for (var j = 1; j < 8; j++) {
                document.getElementById("_td-" + j + "-" + i).style.color = "#2f5185";
            }

            document.getElementById("_modBtn-" + i).style.border = "";
            document.getElementById("_delBtn-" + i).style.border = "";
        }
        else{
             for (var j = 1; j < 8; j++) {
                document.getElementById("td-" + j + "-" + i).style.color = "#2f5185";
            }

            document.getElementById("modBtn" + i).style.border = "";
            document.getElementById("delBtn" + i).style.border = "";
        }
    }

    

    function filter (term, _id, cellNr){
         if (cellNr == 1) {
            document.getElementById('inp2').value="";
         }
         else {
            document.getElementById('inp1').value="";
         }

	    var suche = term.value.toLowerCase();

        var cnt = 0;
        if (<?php echo pg_num_rows($prov)?> > 0) {
            cnt  = <?php echo $cnt2 ?>
        }
        else {
            cnt = <?php echo $cnt2 ?> - 1
        }

        for (var k=1; k <= cnt; k++) {
	        var table = document.getElementById(_id + k);
	        var ele;

	        for (var r = 2; r < table.rows.length; r++){
		        ele = table.rows[r].cells[cellNr].innerHTML.replace(/<[^>]+>/g,"");
		        if (ele.toLowerCase().indexOf(suche)>=0 )
			        table.rows[r].style.display = '';
		        else table.rows[r].style.display = 'none';
	        }
	        
	        //da se krijat celite tabeli koi nemaat nieden red
	        var cnt11 = 0;
         	for (var r = 2; r < table.rows.length; r++){
         	 	if (table.rows[r].style.display != 'none') {
         	 		cnt11 += 1;
         	 	}
         	}
         	if(cnt11 == 0) {
         	 	$('#' + (_id + k)).hide();
         	}
         	else {
         		if (table.style.display == 'none') {
         	 		$('#' + (_id + k)).show();
         	 	}
         	}
         	//
        }
    }
    
    lang = '<?php echo $cLang ?>';

    $('#addBtn').button({ icons: { primary: "ui-icon-plusthick"} });

   
    SetHeightLite();
    iPadSettingsLite();

</script>


</html>
