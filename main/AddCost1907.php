<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
	<script>
			lang = '<?php echo $cLang?>'
	</script>
	<link rel="stylesheet" type="text/css" href="../style.css">

	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="fm.js"></script>
  
    <link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
    <script src="../js/jquery-ui.js"></script>

 <body>
 
  <?php
      $LastDay = DateTimeFormat(addDay(-1), "d-m-Y");
  		$vehID_ = getQUERY("vehid");
	  
	  opendb();
	
      $reg = "";//dlookup("select registration from vehicles where id=" . $vehID);
      
     // $cLang = getQUERY("l");
   ?>

<table class="text2_" width=430px align="center" style="padding-top: 13px; margin-left:60px">
	<tr>
		<td width=160px style="font-size:13px" ><b><?php echo dic_("Reports.ChooseVeh")?>:</b></td>
		<td width=240px style="margin-left:10px">
			<select id="vehictype" onchange="changeVehic()" style="float:left; margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" onchange="changeDriver()">
                <?php
                $dsVehic = query("select * from vehicles where clientid= " . session("client_id") . " order by code asc");
				while ($drVehic = pg_fetch_array($dsVehic)) {
					if($vehID_ == $drVehic["id"])
					{
                ?>
                <option selected id="<?php echo $drVehic["id"]?>" value="<?php echo $drVehic["id"]?>">(<?php echo $drVehic["code"]?>)&nbsp;<?php echo $drVehic["registration"]?></option>
                <?php } else { ?>
                <option id="<?php echo $drVehic["id"]?>" value="<?php echo $drVehic["id"]?>">(<?php echo $drVehic["code"]?>)&nbsp;<?php echo $drVehic["registration"]?></option>
                <?php
				}
				}
                ?>
           </select>
		</td>
	</tr>

	<tr>
		<td width=160px style="font-size:13px" ><b><?php echo dic_("Reports.ChooseCost")?>:</b></td>
		<td width=240px style="margin-left:10px">
			<select id="costtype" onchange="changeCost()" style="float:left; margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" onchange="changeDriver()">
                <option id="0" value="0">- <?php echo dic_("Reports.ChooseCost")?> -</option>
                <option id="Fuel" value="F"><?php echo dic_("Reports.Fuel")?></option>
                <option id="Service" value="S"><?php echo dic_("Fm.Service")?></option>
                <option id="Cost" value="C"><?php echo dic_("Fm.OthCosts")?></option>
                <?php
                $dsCosts = query("select * from fmcosts where clientid= " . session("client_id") . " order by costname asc");

				while ($drCosts = pg_fetch_array($dsCosts)) {

if ($cLang == 'mk') $cost_ = $drCosts["costname"];
else $cost_ = cyr2lat($drCosts["costname"]);
                ?>
                <option id="<?php echo $drCosts["id"]?>" value="<?php echo $cost_?>"><?php echo $cost_?></option>
                <?php
				}
                ?>
           </select>
           &nbsp;&nbsp;<button id="addCost" onClick="addCost()" style="width:30px; height:27px;margin-top:5px" title="<?php echo dic_("Reports.AddingNewCost")?>"></button>
<button id="delCost" onClick="delCost('costtype')" style="width:30px; height:27px;margin-top:5px" title="Remove cost"></button>

		</td>
	</tr>

</table>

  <!--<table style="padding-left:20px;" class="text2_" width=450px>
  	<tr>
		<td width=30% id="tdFuel" style="font-weight: bold; font-size:13px"><input type="radio" name="cost" value="F" checked=checked  onchange="changeRadio('Fuel')"/> Гориво</td>
		<td width=30% id="tdService"><input type="radio" name="cost" value="S" onchange="changeRadio('Service')"/> Сервис</td>
		<td width=40% id="tdCost"><input type="radio" name="cost" value="C" onchange="changeRadio('Cost')"/> Останати трошоци</td>
	</tr>
	
	 
        
  </table>-->

  
  <div id="costContent" align="center">
  	<div class="text2" style="padding-top:40px;color:#5C8CB9; font-weight:bold; font-size:11px">&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/ajax-loader.gif" align="absmiddle">&nbsp;&nbsp;<?php echo dic_('wait')?></div>
  </div>
  

</body>


<script>

 	$("#costContent").load('../main/ChangeCost1907.php?cost=0&vehid=' + <?php echo $vehID_?> + '&dt=' + '<?php echo $LastDay?>&l=' + '<?php echo $cLang?>')
 	$('#addCost').button({ icons: { primary: "ui-icon-plus"} })
 	$('#delCost').button({ icons: { primary: "ui-icon-minus"} })

 	function changeCost() {
 			
 		var dt = document.getElementById('datetime').value;
 		var strC = $("#costtype").children(":selected").attr("id");
 		var strV = $("#vehictype").children(":selected").attr("id");
		document.getElementById('costContent').innerHTML = "<div class='text2' style='padding-top:40px;color:#5C8CB9; font-weight:bold; font-size:11px'>&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/ajax-loader.gif' align='absmiddle'>&nbsp;&nbsp;<?php echo dic_('wait')?></div>"
		$("#costContent").load('../main/ChangeCost1907.php?cost=' + strC + '&vehid=' + strV + '&dt=' + dt + '&l=' + '<?php echo $cLang?>')
	}
	function changeVehic() {
 		var dt = document.getElementById('datetime').value;
 		var strV = $("#vehictype").children(":selected").attr("id");
 		var strC = $("#costtype").children(":selected").attr("id");
		document.getElementById('costContent').innerHTML = "<div class='text2' style='padding-top:40px;color:#5C8CB9; font-weight:bold; font-size:11px'>&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/ajax-loader.gif' align='absmiddle'>&nbsp;&nbsp;<?php echo dic_('wait')?></div>"
		$("#costContent").load('../main/ChangeCost1907.php?cost=' + strC + '&vehid=' + strV + '&dt=' + dt + '&l=' + '<?php echo $cLang?>')
	}
	/*function changeRadio(str) {
		document.getElementById('costContent').innerHTML = "<div class='text2' style='padding-top:40px;color:#5C8CB9; font-weight:bold; font-size:11px'>&nbsp;&nbsp;&nbsp;&nbsp;<img src='../images/ajax-loader.gif' align='absmiddle'>&nbsp;&nbsp;Ве молиме почекајте...</div>"
		document.getElementById('tdFuel').style.fontSize = "11px";
		document.getElementById('tdService').style.fontSize = "11px";
		document.getElementById('tdCost').style.fontSize = "11px";
		document.getElementById('tdFuel').style.fontWeight = "normal";
		document.getElementById('tdService').style.fontWeight = "normal";
		document.getElementById('tdCost').style.fontWeight = "normal";
		
		document.getElementById('td' + str).style.fontSize = "13px";
		document.getElementById('td' + str).style.fontWeight = "bold";
		
		$("#costContent").load('ChangeCost.php?cost=' + str + '&vehid=' + <php echo $vehID_?>)
	}*/
	
    function changeKm(dt, veh) {
    	if (dt == "") dt =  document.getElementById('datetime').value;
    	veh = <?php echo $vehID_?>; //$('#cbVehicles').children(":selected").attr("id");
        $.ajax({
            url: "../main/CalculateCurrKm.php?vehId=" + veh + "&dt=" + '' + dt + '',
            context: document.body,
            success: function (data) {
                document.getElementById('km').value = data;
            }
        });
		
		$.ajax({
            url: "../main/CalculateDrivers.php?vehId=" + veh + '',
            context: document.body,
            success: function (data) {
                document.getElementById('driver').innerHTML = data;
            }
        });
        
    }

function addCost() {
	
	document.getElementById('div-costnewMain').title = dic("Reports.AddingNewCost")
	 $.ajax({
            url: "../main/AddNewCostType.php?l=" + lang,
            context: document.body,
            success: function (data) {
          
               $('#div-costnewMain').html(data);
               $('#div-costnewMain').dialog({ modal: true, height: 235, width: 400,
               	zIndex: 10002 ,
                   buttons: [
                   {
                         text:  dic("add"),
                         click: function () {
                         	var newcost = document.getElementById('newcost').value;	
                         		
                   			$.ajax({
                                url: "../main/InsertNewCostType.php?newcost=" + newcost + "&l=" + lang,
                                context: document.body,
                                success: function (data) {
                                	if (data != 0) {
                                	//mymsg("Успешно додадовте нов тип на трошок !!!")
                                    $('#div-costnewMain').dialog('destroy');
                                    $.ajax({
		                                url: "../main/CalculateCostTypes.php?newcost=" + newcost + "&l=" + lang,
		                                context: document.body,
		                                success: function (data) {
		                                    document.getElementById('costtype').innerHTML = data;
		                                }
		                            });
                            } else {
                            	alert(dic("Reports.AlreadyCost") + " '" + newcost + "' !!!")
                            }
                                }
                            });
                         }
                   },
                       {
                         text: dic("cancel"),
                         click: function () {
                         	$(this).dialog("close");
                         	 //$('#div-cost').parent().css('z-Index', 1002);
                         }
                       }
                   ]
                   
                   
               });
            }
        });
}


    function add() {
        top.ShowWait();

        var dt = document.getElementById("datetime").value;
        var driver = document.getElementById("driver").value;
        var km = document.getElementById("km").value;
        var liters = document.getElementById("liters").value;
        var litersKLast = document.getElementById("litersLast").value;
        var price = document.getElementById("price").value;
      
   
        /*$.ajax({
            url: "InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast" + litersKLast + "&price=" + price + "&vehID=" + <php echo $vehID ?>,
            context: document.body,
            success: function (data) {
                top.document.getElementById('ifrm-cont').src = "Fuel.php?l=" + '<php echo $cLang ?>';
            }
        });*/
    }

function delCost(idSelect) {



	//top.document.getElementById('div-del-vehicle').title=dic("Delete",lang);	
    //ShowWait()
        $.ajax({
		    url: "../main/DelCostQuestion.php?l="+lang + "&id=2",
		    context: document.body,
		    success: function(data){
               // HideWait()
   				top.$('#div-costMain').html(data)
   				top.$('#div-costMain').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons:
				[
				{
				   text:dic("yes",lang),
                    click: function() {
                       // var id = $('#tabId1').val()
                          /*  $.ajax({
		                        url: "DeleteVehicle.php?l="+lang + "&id="+id+"&i="+i,
		                        context: document.body,
		                        success: function(data){
			                       $('#vehicle-'+i).remove();
			                       if(i==0)
			                       {
			                       		window.location.reload();
			                       	}
			                        //top.document.getElementById('ifr-map').src ='_show_Vehicle.php?l='+lang+'&id='+vid;
		                        }
		                        
		                    });	*/
                            top.$( this ).dialog( "close" );
							}
				    },
					{
                    text:dic("no",lang),
                    click: function() {
					    top.$( this ).dialog( "close" );
				    }
					}
					]
         }); 
    }
    });


	if(document.getElementById(idSelect).selectedIndex<4) {
		if(document.getElementById(idSelect).selectedIndex == 0) {
			alert('Изберете трошок кој сакате да го избришете !!!');
		} else {
			alert('Преддефинираните трошоци не може да ги избришете !!!');
		}
	} else {
	alert("дали сте сигурни???? ако да - >")
	var id = $("#" + idSelect + " option:selected").attr("id");
		/* $.ajax({
		        url: "../main/Delete.php?table=fmCosts&id=" + id,
		        context: document.body,
		        success: function (data) {
		            //document.getElementById('costtype').innerHTML = data;	
				alert("Успешно избришавте тип на трошок !!!")
				 $.ajax({
                                url: "../main/CalculateCostTypes.php?l=" + lang,
                                context: document.body,
                                success: function (data) {
                                    document.getElementById('costtype').innerHTML = data;
                                }
                            });
		        }
		    });*/
	}
}

    function cancel() {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "../main/Fuel.php?l=" + '<?php echo $cLang ?>';
    }
	  
    setDates2();
    top.HideWait();

</script>


    <script>
        $('#add1').button({ icons: { primary: "ui-icon-plus"} })
        $('#cancel1').button({ icons: { primary: "ui-icon-arrowreturnthick-1-w"} })
    </script>
    
    <?php 
   	closedb();
   	?> 

</html>
