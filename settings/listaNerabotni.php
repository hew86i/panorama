<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php opendb();?>

<?php 
	header("Content-type: text/html; charset=utf-8");
	opendb();
	$Allow = getPriv("employees", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
	
	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	$yourbrowser1 = (bool) strpos($ua['userAgent'], "Macintosh");
	
	$tipNaKorisnik = query("select * from users where id = ".session("user_id"));
	$korisnikZona = pg_fetch_result($tipNaKorisnik, 0, "datetimeformat");
		
?>
	<html>
	<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css"> 
	.menuTable { display:none; width:200px; } 
	</style>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>

	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
	<script src="../js/jquery-ui.js"></script>
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
	<style type="text/css"> 
 		body{ overflow-y:auto;}
 		body{ overflow-x:auto;}
	</style>
	</head>	
	
	<body>
		
	<table width="94%" style="margin-top:30px; margin-left:35px;">
	<tr>
	<td align = "left" width="50%">
	<div class="textTitle" style="padding-left:<?php if($yourbrowser == "1") { echo '10px'; } else { echo '10px'; } ?>;"><?php dic("Settings.NonWorkingDays") ?><br />
	</div>
	</td>
	<td align = "right" width="50%">
		<div align = "right" ><!--button id="cancel" onclick="cancel()"><?php dic("Fm.Cancel") ?></button--></div>
	</td>
	</tr>
	</table>
	
	<div align = "left" style="padding-left: 10px ; padding-top: 10px">

	<?php
	
		$firstDayCurrentYear = DateTimeFormat(now(), 'Y') . '-01-01';
				
		$cnt = 1;
		$i = 1;
		$Denovi = query("select * from companydays where clientid =" . Session("client_id")." and datum >= '".$firstDayCurrentYear."' order by companyholiday asc, datum asc");
		if(pg_num_rows($Denovi)==0){
		?>
		<br><br>
		<div id="noData" style="padding-left:40px; font-size:20px; font-style:italic; padding-bottom:40px" class="text4">
 		<?php dic("Reports.NoData1")?>
		</div>
		<?php
		}
		else
		{
		?>	
		
	<table width="94%" border="0" cellspacing = "2" cellpadding = "2" style="margin-top:30px; margin-left:35px; margin-bottom:35px">
	<tr>
		<td align = "center" width="3%" height="25px" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;">&nbsp;</td>
		<td align = "left" width="20%" height="25px" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:5px"><?php dic("Settings.NameOfTheDay") ?><br /></td>
		<td align = "left" width="14%" height="25px" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:5px"><?php dic("Tracking.Date") ?> </td>
		<td align = "left" width="14%" height="25px" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left: 5px"><?php dic("Settings.TypeOfDay") ?></td>
		<td align = "center" width="9%" height="25px" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Reports.Color")?></td>
		<td align = "center" width="8%" height="25px" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Change")?> </td> 
		<td align = "center" width="8%" height="25px" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Tracking.Delete")?> </td>
	</tr>
	<?php
		$brojRedovi = 0;
		while ($row1 = pg_fetch_array($Denovi))
 		{
 			$data[] = ($row1);
		}
		foreach ($data as $row1)
		{
		$brojRedovi = $brojRedovi +1;
		$dayOfWeek = '';
		if ($row1["typeofday"] == "1"){
			$dayOfWeek = dic_("Settings.Monday");
		}
		if ($row1["typeofday"] == "2"){
			$dayOfWeek = dic_("Settings.Tuesday");
		}
		if ($row1["typeofday"] == "3"){
			$dayOfWeek = dic_("Settings.Wednesday");
		}
		if ($row1["typeofday"] == "4"){
			$dayOfWeek = dic_("Settings.Thursday");
		}
		if ($row1["typeofday"] == "5"){
			$dayOfWeek = dic_("Settings.Friday");
		}
		if ($row1["typeofday"] == "6"){
			$dayOfWeek = dic_("Settings.Saturday");
		}
		if ($row1["typeofday"] == "7"){
			$dayOfWeek = dic_("Reports.Sunday");
		}
		if ($row1["typeofday"] == "8"){
			$dayOfWeek = dic_("Settings.Holiday");
		}
				
	?>	
	<tr>	
    
		<td width="3%" align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"> 
		<?php echo $brojRedovi?>
		</td>
		<td width="20%" align = "left" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left: 5px"> 
			<?php echo $row1['dayname'] ?>	
		</td>
		
		<td width="14%" align = "left" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left: 5px">
			<?php  
				if($korisnikZona =="m-d-Y h:i:s A"){
			 		echo $datum = DateTimeFormat($row1['datum'], 'm-d-Y') . ", ".$dayOfWeek."";
				}
				else {
					echo $datum = DateTimeFormat($row1['datum'], 'd-m-Y') . ", ".$dayOfWeek."";
				}
			?>	
		</td>
		<td width="14%" align = "left" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left: 5px">
			<?php 
				if ($row1["companyholiday"] == "8"){
					dic("Settings.Holiday");
				}
				if ($row1["companyholiday"] == "9"){
					dic("Settings.NonWorkingForCompany");?>
				<?php
				}
				?>
		</td>
		<td width="9%" align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">	
			<span id="color-<?= $cnt?>" style="background-color:<?php echo $row1['cellcolor']?>; border: 1px solid black">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			</span>		
		</td>
				
		<td width="8%" align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
			<button id="btnEdit<?php echo $cnt?>"  onclick="EditDay(<?php echo $row1["id"]?>)" style="height:22px; width:30px"></button>	
		</td>
		<td width="8%" align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
			<button id="DelBtn<?php echo $cnt?>"  onclick="DeleteButtonClick(<?php echo $row1["id"]?>, '<?php echo $row1["datum"]?>')" style="height:22px; width:30px"></button>
		</td>
	</tr>
	<script>
		var i = <?php echo $cnt?>;
		$('#btnEdit' + i).button({ icons: { primary: "ui-icon-pencil"} });
		$('#DelBtn' + i).button({ icons: { primary: "ui-icon-trash"} });
	</script>
	<?php 
	$cnt++;
	}
	}
	?>
	</table>
	
	<br>
	<!--table width="94%" style="margin-top:30px; margin-left:25px;">
	<tr>
	<td align = "left" width="50%">
	<div class="textTitle" style="padding-left:<?php if($yourbrowser == "1") { echo '10px'; } else { echo '10px'; } ?>;"><?php dic("Settings.Holidays")?><br />
	</div>
	</td>
	</tr>
	</table-->
	
	<?php
		/*$cnt2 = 1;
		$i = 1;
		$praznicite = query("select * from companydaysholiday where clientid =" . Session("client_id")." order by nameholiday");
		if(pg_num_rows($praznicite)==0){
		?>
		<br><br>
		<div id="noData" style="padding-left:40px; font-size:20; font-style:italic; padding-bottom:40px" class="text4">
 		<?php dic("Reports.NoData1")?>
		</div>
		<?php
		}
		else
		{
		?>	
	
	<table width="30%" border="0" cellspacing = "2" cellpadding = "2" style="margin-top:30px; margin-left:35px; margin-bottom:35px">
	<tr>
		<td align = "center" width="5%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"></td>
		<td align = "center" width="45%" 	
    height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.TypeOfHoliday")?></td>
		<td align = "center" width="25%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Change")?></td>
		<td align = "center" width="25%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Delete")?></td>
	</tr>
	<?php
		$brojNaRedovi2 = 0;
		while ($row2 = pg_fetch_array($praznicite))
 		{
 			$data2[] = ($row2);
		}
		foreach ($data2 as $row2)
		{
			$brojNaRedovi2 = $brojNaRedovi2 + 1;
	?>	
	<tr>
		<td width="10%" align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"> 
			<?php echo $brojNaRedovi2?>	
		</td>
		<td width="40%" align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"> 
			<?php echo $row2['nameholiday'] ?>	
		</td>
		<td width="20%" align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
			<button id="promeni<?php echo $cnt2?>"  onclick="ChangeHoliday(<?php echo $row2["id"]?>)" style="height:22px; width:30px"></button>
		</td>	
    
		<td width="20%" align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
			<button id="izbrisi<?php echo $cnt2?>"  onclick="DeleteHoliday(<?php echo $row2["id"]?>)" style="height:22px; width:30px"></button>
		</td>	
	</tr>
	<script>
		var z = <?php echo $cnt2?>;
		$('#promeni' + z).button({ icons: { primary: "ui-icon-pencil"} });
		$('#izbrisi' + z).button({ icons: { primary: "ui-icon-trash"} });
	</script>
		<?php
		$cnt2++;
		}
		
		?>
	</table>
	<?php
	}*/
	?>
	
	</div>
	
	<div valign = "bottom" align = "right" style="padding-right: 47px ; padding-top: 10px ;padding-bottom: 30px"><button id="cancel2" onclick="cancel()"><?php dic("Fm.Cancel") ?></button></div>
	
	<div id="div-del-holiday" style="display:none" title="<?php dic("Settings.DeletingNonWorkingDay")?>">
    	<?php dic("Settings.SureDeletingNonWorking")?>
    </div>
    
    <div id="div-del-day-holiday" style="display:none" title="<?php dic("Settings.DeletingHoliday")?>">
    	<?php dic("Settings.SureDeleteHoliday")?>
    </div>
    
    <div id="div-edit-day" style="display:none" title="<?php dic("Settings.ChangeNonWorkingDay")?>"></div>
    
    <div id="div-edit-praznik" style="display:none" title="<?php dic("Settings.ChangeHolidayName")?>" ></div>
    
    <div id="dialog-message" title="<?php echo dic("Reports.Message")?>" style="display:none">
	 <p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px"></div>
	 </p>
	</div>
	
    </body>	
    
	
	</html>
	
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
		top.HideWait();
		$('#cancel').button({ icons: { primary: "ui-icon-arrowreturnthick-1-w"} })
		$('#cancel2').button({ icons: { primary: "ui-icon-arrowreturnthick-1-w"} })
		
		function cancel() {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "WorkTime.php?l=" + '<?php echo $cLang ?>';
    	}
    
    
    	
    	function DeleteButtonClick(id, _date) {
    	          	
		$('#div-del-holiday').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: 
                [
                {
                	text:dic("Settings.Yes"),
				    click: function() {
                            $.ajax({
		                        url: "DelHoliday.php?id="+id+"&l="+lang,
		                        context: document.body,
		                        success: function(data){
	                            	msgboxPetar(dic('Settings.DeleteRecache'), lang);
	                            	setTimeout(function(){
	                            		window.location.reload();
	                            		$.ajax({
				                            url: "cachereports_sett.php?date="+_date+"&cid="+'<?= session("client_id")?>',
				                            context: document.body,
				                            success: function(data){}
		                          	 	});
	                            	}, 3000);
	                            }
		                        /*success: function(data){
		                        msgboxPetar(dic("Settings.SuccDeleted",lang));
		                        window.location.reload();
								}*/
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
    	
    	function DeleteHoliday(id) {
    	$.ajax({
		url: "CheckDelHoliday.php?id="+id+"&l="+lang,
		context: document.body,
		success: function(data){
		if(data == 1)
        {
       		 msgboxPetar(dic("Settings.CantEraseHoliday",lang));
        }
        else
        {	
    	$('#div-del-day-holiday').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: 
                [
                {
                	text:dic("Settings.Yes"),
				    click: function() {
                            $.ajax({
		                        url: "DelDayHoliday.php?id="+id+"&l="+lang,
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
				    	text:dic("Settings.No",lang),
                    click: function() {
					    $( this ).dialog( "close" );
				    }
			      }
                 ]
               });
             }
           }
		 });
   		}
   		
   		
   		/*function ChangeHoliday(id){
   		ShowWait()
        $.ajax({
		    url: "EditHolidayName.php?id="+id+"&l="+lang,
		    context: document.body,
		    success: function(data){
                HideWait()
                $('#div-edit-praznik').html(data)
			    $('#div-edit-praznik').dialog({ modal: true, width: 400, height: 250, resizable: false,

                     buttons: 	
    
                     [
                     {
                     	text:dic("Settings.Change",lang),
				        click: function() {
                             
                             var imePraznik = $('#promeniTipPraznik').val();
                             
                             if(imePraznik=="")
                             {
                             	msgboxPetar(dic("Settings.EnterNameForHoliday"),lang)
                             }
                             else{
                       	
                                      $.ajax({
		                              url: "UpdateDayName.php?id="+id+"&imePraznik="+imePraznik,
		                              context: document.body,
		                              success: function(data){
		                              if(data == 1)
		                              {
		                       			msgboxPetar(dic("Settings.EditTimeAlreadyCombination"),lang)
		                              }
		                              else	
    
		                              {
		                              	msgboxPetar(dic("Settings.SuccessChangeNameHol"),lang);
					    			 	window.location.reload();
			                          }
		                              }
		                            });	
		                           }
                                }
                        	},
                        {
                        	text:dic("cancel",lang),
                        click: function() {
					        $( this ).dialog( "close" );
				        },
                     }       
                     ]
                });
		    }
		});
  		}*/
   	
   	
    	
    	function EditDay(id){
        ShowWait()
        $.ajax({
		    url: "EditDay.php?id="+id+"&l="+lang,
		    context: document.body,
		    success: function(data){
                HideWait()
                $('#div-edit-day').html(data)
			    $('#div-edit-day').dialog({ modal: true, width: 470, height: 270, resizable: false,

                     buttons: 
                     [
                     {
                     	text:dic("Settings.Change",lang),
				        click: function() {
                             
                             var imePraznik = $('#imePraznik').val();
                             var boja = $('#FillColor').val();
                             boja = boja.replace("#", "");
                             var tipDen = 9;//document.getElementById("tipDen").value
                             var den = 0;//document.getElementById("den").value  
                             var tipPraznik = 0;//document.getElementById("tipPraznik").value
                             var imePraznikID = 0;//document.getElementById("imePraznik");
                             var bojaFokus = document.getElementById("FillColor");  
                             var datum = $('#datumot').val();		
                             
                             if(imePraznik=="")
                             {
                             	msgboxPetar(dic("Settings.EnterNameForHoliday"),lang)
                             	imePraznikID.focus();
                             }
                             else
                             {
                               if(boja=="")
                               {
                               		msgboxPetar(dic("Settings.ChooseColor", lang))
				                    bojaFokus.focus();
                               }
                               else{
                              // 	debugger;
                               //	alert("UpdateDay.php?id="+id+"&imePraznik="+imePraznik+"&boja="+boja+"&tipDen="+tipDen+"&den="+den+"&tipPraznik="+tipPraznik+"&datum="+datum)
                                     $.ajax({
		                              url: "UpdateDay.php?id="+id+"&imePraznik="+imePraznik+"&boja="+boja+"&tipDen="+tipDen+"&den="+den+"&tipPraznik="+tipPraznik,
		                              context: document.body,
		                              success: function(data){
		                              if(data == 1)
		                              {
		                       			msgboxPetar(dic("Settings.EditTimeAlreadyCombination"),lang)
		                              }
		                              else
		                              {
		                              	msgboxPetar(dic("Settings.SuccChangedNonWorkingDay"),lang)
					    			 	window.location.reload();
			                          }
		                              }
		                            });	
		                            }
		                           }
                                }
                        	},
                        {
                        	text:dic("cancel",lang),
                       		click: function() {
					        $( this ).dialog( "close" );
				        },
                     }       
                     ]
                });
		    }
		});
    }
    </script>
	
	<?php
		closedb();
	?>

