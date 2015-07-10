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

	<style type="text/css">
	.list-item-select{background-color: #14a3bc; color:#FFFFFF; cursor:pointer }
	.div-select {background-color: #F57A49; color:#FFFFFF;}
	.comp {
		display: inline-block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 120px; 
	}
	</style>
  

 <body>
 
  <?php
      $LastDay = DateTimeFormat(addDay(-1), "d-m-Y");
  		$vehID_ = getQUERY("vehid");
	  
	  $tpoint = getQUERY("tpoint");
	  
	  opendb();
	
      $reg = "";//dlookup("select registration from vehicles where id=" . $vehID);
      
      $cLang = getQUERY("l");
   ?>

<table class="text2_" width=430px align="center" style="padding-top: 13px; margin-left:60px">
	<tr>
		<td width=160px style="font-size:13px" ><b><?php echo dic_("Reports.ChooseVeh")?>:</b></td>
		<td width=240px style="margin-left:10px">
			<?php
			$dsVehic = query("select * from vehicles where clientid= " . session("client_id") . " order by cast(code as integer) asc");
			?>
			<input id="searchVeh_" class="<?php echo pg_fetch_result($dsVehic, 0, "id")?>" type="text" onkeyup="OnKeyPressSearchVeh(event.keyCode)" onclick="OnKeyPressSearchVeh()" onblur="hideSearchVeh()" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px" value="<?php echo '(' . pg_fetch_result($dsVehic, 0, "code") .') ' . pg_fetch_result($dsVehic, 0, "registration")?>"/>
	    	 <div class="corner5" style="color:#2F5185; opacity:1; padding:5px; background-color:#fff; display:none; position:absolute; border:1px solid #CCCCCC; width:170px;height: 74px; float:left; overflow-y: auto; z-index:9999" id="listVeh">
			<?php
			 
			//while ($drVehic = pg_fetch_array($dsVehic)) {
					//if($vehID_ == $drVehic["id"])
                ?>
                <a id="a-v<?php echo pg_fetch_result($dsVehic, 0, "id")?>" class="" onmouseover="overDiv('v<?php echo pg_fetch_result($dsVehic, 0, "id")?>')" onmouseout="outDiv('v<?php echo pg_fetch_result($dsVehic, 0, "id")?>')" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
					<span onclick="OnCLickVeh('v<?php echo pg_fetch_result($dsVehic, 0, "id")?>')">(<?php echo pg_fetch_result($dsVehic, 0, "code")?>)&nbsp;<?php echo pg_fetch_result($dsVehic, 0, "registration")?></span>
				</a>
				<br>
			<?php	
			//}
			?>
				
			<!--select id="vehictype" data-placeholder="" onchange="changeVehic()" style="float:left; margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" onchange="changeDriver()">
                <?php
                $dsVehic = query("select * from vehicles where clientid= " . session("client_id") . " order by cast(code as integer) asc");
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
           </select-->
		</td>
	</tr>

	<tr>
  <td width=160px style="font-size:13px" ><b><?php echo dic_("Reports.ChooseCost")?>:</b></td>
      <td style="padding-left:0px">      
       <input id="searchCost" type="text" onkeyup="OnKeyPressSearchCost(event.keyCode)" onclick="OnKeyPressSearchCost()" onblur="hideSearchCost()" style="margin-top:5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:180px; padding-left:5px"/>
    	 <div class="corner5" style="color:#2F5185; opacity:1; padding:5px; background-color:#fff; display:none; position:absolute; border:1px solid #CCCCCC; width:170px;height: 74px; float:left; overflow-y: auto; z-index:9999" id="listCost">
		<a id="a-F" class="" onmouseover="overDiv('F')" onmouseout="outDiv('F')" style="cursor:pointer; color:#2F5185; width:90%; display: inline-block;  float:left; padding-left:3px" onclick="">
			<span onclick="OnCLickCost('F')"><?php echo dic_("Reports.Fuel")?></span>
		</a>
		<br>
		<a id="a-S" class="" onmouseover="overDiv('S')" onmouseout="outDiv('S')" style="cursor:pointer; color:#2F5185; width:90%; display: inline-block;  float:left; padding-left:3px" onclick="">
			<span onclick="OnCLickCost('S')"><?php echo dic_("Fm.Service")?></span>
		</a>
		<br>
		<a id="a-C" class="" onmouseover="overDiv('C')" onmouseout="outDiv('C')" style="cursor:pointer; color:#2F5185; width:90%; display: inline-block;  float:left; padding-left:3px" onclick="">
			<span onclick="OnCLickCost('C')"><?php echo dic_("Fm.OthCosts")?></span>
		</a>
		<br>
      	<?php
      	/*$dsComp = query("select * from fmcomponents where clientid=" . session("client_id"));
		while ($drComp = pg_fetch_array($dsComp)) {
			?>
			<a id="a-<?php echo $drComp["id"]?>" class="" onmouseover="overDiv(<?php echo $drComp["id"]?>)" onmouseout="outDiv(<?php echo $drComp["id"]?>)" style="cursor:pointer; color:#2F5185; width:100%; display: inline-block;  float:left; padding-left:3px" onclick="">
				<span onclick="OnCLickComp('<?php echo $drComp["id"]?>')"><?php echo mb_strtolower($drComp["componentname"], 'UTF-8')?></span><span id="x-<?php echo $drComp["id"]?>" onclick="deleteCost(<?php echo $drComp["id"]?>)" title="<?php echo dic_("Reports.DelComp1")?>" style="margin-right: 3px; margin-top: 2px; float:right; width: 9px; height: 9px; background-image: url('<?php echo $tpoint?>/images/x-mark1.png'); display:none;" />
			</a>
			<br>
			<?php
		}*/
      	?>
    	</div>
       &nbsp;&nbsp;<button id="addCost" onClick="addCost()" style="margin-top:5px; width:30px; height:27px;vertical-align:top" title="<?php echo dic_("Reports.AddingNewCost")?>"></button>
      </td>
  </tr>



  
  
	<!--tr>
		<td width=160px style="font-size:13px" ><b><?php echo dic_("Reports.ChooseCost")?>:</b></td>
		<td width=240px style="margin-left:10px">
			<select data-placeholder="" id="costtype" onchange="changeCost()" style="float:left; margin-top:5px; width: 180px; font-size: 11px; position: relative; top: 0px; z-index: 99999; visibility: visible;" class="combobox text2" onchange="changeDriver()">
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
<button id="delCost" onClick="delCost('costtype')" style="display:none; width:30px; height:27px;margin-top:5px" title="Remove cost"></button>

		</td>
	</tr-->

</table>

  <!--<table style="padding-left:20px;" class="text2_" width=450px>
  	<tr>
		<td width=30% id="tdFuel" style="font-weight: bold; font-size:13px"><input type="radio" name="cost" value="F" checked=checked  onchange="changeRadio('Fuel')"/> Гориво</td>
		<td width=30% id="tdService"><input type="radio" name="cost" value="S" onchange="changeRadio('Service')"/> Сервис</td>
		<td width=40% id="tdCost"><input type="radio" name="cost" value="C" onchange="changeRadio('Cost')"/> Останати трошоци</td>
	</tr>
	
	 
        
  </table>-->

  
  <div id="costContent" align="center">
  	<div class="text2" style="padding-top:40px;color:#5C8CB9; font-weight:bold; font-size:11px">&nbsp;&nbsp;&nbsp;&nbsp;<img src="<?php echo $tpoint?>/images/ajax-loader.gif" align="absmiddle">&nbsp;&nbsp;<?php echo dic_('wait')?></div>
  </div>
  

</body>


<script>

var vehid_ = <?php echo $vehID_?>;
var costid_ = 0;

 	$("#costContent").load('<?php echo $tpoint?>/main/ChangeCost.php?cost=0&vehid=' + <?php echo $vehID_?> + '&dt=' + '<?php echo $LastDay?>&l=' + '<?php echo $cLang?>' + '&tpoint=<?php echo $tpoint?>')
 	$('#addCost').button({ icons: { primary: "ui-icon-plus"} })
 	$('#delCost').button({ icons: { primary: "ui-icon-minus"} })
 
 	/*function changeCost() {	
		if(document.getElementById('costtype').selectedIndex < 4) {
			$('#delCost').hide();
		} else {
			$('#delCost').show();
		}	
 		var dt = document.getElementById('datetime').value;
 		var strC = $("#costtype").children(":selected").attr("id");
 		var strV = $("#vehictype").children(":selected").attr("id");
		document.getElementById('costContent').innerHTML = "<div class='text2' style='padding-top:40px;color:#5C8CB9; font-weight:bold; font-size:11px'>&nbsp;&nbsp;&nbsp;&nbsp;<img src='<php echo $tpoint?>/images/ajax-loader.gif' align='absmiddle'>&nbsp;&nbsp;<php echo dic_('wait')?></div>"
		$("#costContent").load('<php echo $tpoint?>/main/ChangeCost.php?cost=' + strC + '&vehid=' + strV + '&dt=' + dt + '&l=' + '<php echo $cLang?>' + '&tpoint=<php echo $tpoint?>')
	}*/
	
 	function changeCost(costName) {	
//alert('cost' + costid_ + ' veh' + vehid_);
		//alert(document.getElementById("searchVeh").getAttribute('class'))
 		var dt = document.getElementById('datetime').value;
 		var strC = costid_; //costName;//costName.replace(" ", "_");//$("#costtype").children(":selected").attr("id");	
		var strV = vehid_; //document.getElementById("searchVeh").getAttribute('class'); //$('#searchVeh').attr('class'); //($($('#listVeh .div-select')[0]).attr("id")).split("-v")[1]; //$("#vehictype").children(":selected").attr("id");
		document.getElementById('costContent').innerHTML = "<div class='text2' style='padding-top:40px;color:#5C8CB9; font-weight:bold; font-size:11px'>&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo $tpoint?>/images/ajax-loader.gif' align='absmiddle'>&nbsp;&nbsp;<?php echo dic_('wait')?></div>"
		$("#costContent").load('<?php echo $tpoint?>/main/ChangeCost.php?cost=' + strC + '&vehid=' + strV + '&dt=' + dt + '&l=' + '<?php echo $cLang?>' + '&tpoint=<?php echo $tpoint?>')
	}
	function changeVehic() {
//alert('cost' + costid_ + ' veh' + vehid_);
		//alert(document.getElementById("searchVeh").getAttribute('class'))
 		var dt = document.getElementById('datetime').value;
 		var strV = vehid_; //document.getElementById("searchVeh").getAttribute('class'); //($($('#listVeh .div-select')[0]).attr("id")).split("-v")[1]; //$("#vehictype").children(":selected").attr("id");
 		var strC = costid_; //$('#searchCost').attr('class'); //$('#searchCost').val();//$("#costtype").children(":selected").attr("id");
		document.getElementById('costContent').innerHTML = "<div class='text2' style='padding-top:40px;color:#5C8CB9; font-weight:bold; font-size:11px'>&nbsp;&nbsp;&nbsp;&nbsp;<img src='<?php echo $tpoint?>/images/ajax-loader.gif' align='absmiddle'>&nbsp;&nbsp;<?php echo dic_('wait')?></div>";
		$("#costContent").load('<?php echo $tpoint?>/main/ChangeCost.php?cost=' + strC + '&vehid=' + strV + '&dt=' + dt + '&l=' + '<?php echo $cLang?>' + '&tpoint=<?php echo $tpoint?>')
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
            url: "<?php echo $tpoint?>/main/CalculateCurrKm.php?vehId=" + veh + "&dt=" + '' + dt + '' + '&tpoint=<?php echo $tpoint?>',
            context: document.body,
            success: function (data) {
                document.getElementById('km').value = data;
            }
        });
		
		$.ajax({
            url: "<?php echo $tpoint?>/main/CalculateDrivers.php?vehId=" + veh + '' + '&tpoint=<?php echo $tpoint?>',
            context: document.body,
            success: function (data) {
                document.getElementById('driver').innerHTML = data;
            }
        });
        
    }

function addCost() {
	$('#listCost').hide();
	document.getElementById('div-costnewMain').title = dic("Reports.AddingNewCost")
	 $.ajax({
            url: "<?php echo $tpoint?>/main/AddNewCostType.php?l=" + lang + '&tpoint=<?php echo $tpoint?>',
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
                         		if(newcost == "") {
                         			alert(dic('Reports.EnterNameCost', lang) + " !!!")
                         			$('#newcost').css({border:'1px solid red'});
                         			document.getElementById('newcost').focus();	
                         		} else {
                   			$.ajax({
                                url: "<?php echo $tpoint?>/main/InsertNewCostType.php?newcost=" + newcost + "&l=" + lang + '&tpoint=<?php echo $tpoint?>',
                                context: document.body,
                                success: function (data) {
                                	if (data != 0) {
                                		//mymsg("Успешно додадовте нов тип на трошок !!!")
                                		$('#div-costnewMain').dialog('destroy');
                                		$('#searchCost').val(data.split("-")[1]);
                                		changeCost(data.split("-")[1]);
                                		$("#searchCost").attr('class', '');
										$('#searchCost').addClass(data.split("-")[0]);
                                		
                                	//mymsg("Успешно додадовте нов тип на трошок !!!")
                                    /*$('#div-costnewMain').dialog('destroy');
                                    $.ajax({
		                                url: "<php echo $tpoint?>/main/CalculateCostTypes.php?newcost=" + newcost + "&l=" + lang + '&tpoint=<php echo $tpoint?>',
		                                context: document.body,
		                                success: function (data) {
		                                    document.getElementById('costtype').innerHTML = data;
						   					changeCost();
		                                }
		                            });*/
		                            } else {
		                            	alert(dic("Reports.AlreadyCost") + " '" + newcost + "' !!!")
		                            }
                                }
                            });
                          }
                         }
                   },
                       {
                         text: dic("cancel"),
                         click: function () {
                         	$(this).dialog('close');
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

function deleteCost(idSelect, selectName) {
	var val = selectName;

	top.document.getElementById('div-del-cost').title = dic('Reports.DeleteCostType', lang);	
		
        $.ajax({
		    url: "<?php echo $tpoint?>/main/DelCostQuestion.php?l="+lang + "&cost=" + val + "&tpoint=<?php echo $tpoint?>",
		    context: document.body,
		    success: function(data){
   				top.$('#div-del-cost').html(data)
   				top.$('#div-del-cost').dialog({ modal: true, width: 350, height: 170, resizable: false,
               		 buttons:
				[
				{
				   text:dic("yes",lang),
                    click: function() {
                       // var id = $('#tabId1').val()
                      
                       $.ajax({
		        url: "<?php echo $tpoint?>/main/Delete.php?table=fmCosts&id=" + idSelect + '&tpoint=<?php echo $tpoint?>',
		        context: document.body,
		        success: function (data) {
		        	 $('#a-'+idSelect).remove();
		        	 $('#searchCost').val('');
                     changeCost('');
		        	 $("#searchCost").attr('class', '');
		        	 $('#listCost').hide();
		        	 
		            //document.getElementById('costtype').innerHTML = data;	
				//alert(dic('Reports.TheCost', lang) + ' "' + val + '" ' + dic('Reports.SuccDelCost', lang) + " !!!")
				
				 /*$.ajax({
                                url: "<php echo $tpoint?>/main/CalculateCostTypes.php?l=" + lang + '&tpoint=<php echo $tpoint?>',
                                context: document.body,
                                success: function (data) {
                                    document.getElementById('costtype').innerHTML = data;
                                }
                            });*/
		        }
		    });
                            top.$( this ).dialog("destroy");
				
							}
				    },
					{
                    text:dic("no",lang),
                    click: function() {
					    top.$( this ).dialog("destroy");
				    }
					}
					],
		close: function (e) {
           		$(this).empty();
            		$(this).dialog('destroy');
       		}
         }); 
    }
    });
}

    function cancel() {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "<?php echo $tpoint?>/main/Fuel.php?l=" + '<?php echo $cLang ?>' + '&tpoint=<?php echo $tpoint?>';
    }
	  
function hideSearchCost() {
	$('#listCost').hide();
}
var selectedElement = -1;
var selectedCost = '';
function OnKeyPressSearchCost(_key){
	if(_key == 40 || _key == 38 || _key == 13)
		{
			if($('#listCost').children().length > 0)
			{
				if(_key == 40 && selectedElement < $('#listCost').children().length-1)
				{
					$('#listCost .list-item-select').removeClass('list-item-select');
					$($('#listCost').children()[selectedElement-1]).removeClass('div-select')
					$($('#listCost').children()[selectedElement+1]).addClass('div-select')
					$($($('#listCost').children()[selectedElement+1]).children()[0]).show();
					$('#listCost').children()[selectedElement+1].scrollIntoView(false);
					selectedElement=selectedElement+2;
				}
				if(_key == 38 && selectedElement > 0)
				{
					$('#listCost .list-item-select').removeClass('list-item-select');
					$($('#listCost').children()[selectedElement-1]).addClass('div-select')
					$($('#listCost').children()[selectedElement+1]).removeClass('div-select')
					$($($('#listCost').children()[selectedElement-1]).children()[0]).show();
					$('#listCost').children()[selectedElement-1].scrollIntoView(true);
					selectedElement=selectedElement-2;
				}
				if(_key == 13)
				{
					var costName = $($('#listCost .div-select')[0]).children()[0].innerHTML;
					costName = costName.replace('<b style="color: rgb(255, 0, 0);">','')
					costName = costName.replace('<b style="color: #FF0000">','')
					costName = costName.replace('</b>','')
					costName = costName.replace('<b style="color: #FF0000">','')
					costName = costName.replace('</b>','')
					$('#searchCost').val(costName);
					$('#listCost').hide();
										
					var _id = ($($('#listCost .div-select')[0]).attr("id")).split("-");
					_CostId = _id[1];
					if (_id[1] == "01") _CostId = "Fuel";
					if (_id[1] == "02") _CostId = "Service";
					if (_id[1] == "03") _CostId = "Cost";

					$("#searchCost").attr('class', '');
					$('#searchCost').addClass(_CostId);
					costid_ = _CostId;	
					changeCost(costName)
				}
			} else
			{
			}
		} else
		{
			var txt = $('#searchCost').val()
			if(txt == '')
			{
				$.ajax({
			        url: "<?php echo $tpoint?>/main/SearchCosts.php?txt=" + txt + '&l=' + lang + '&selCost=' + selectedCost + '&tpoint=<?php echo $tpoint?>',
			        context: document.body,
			        success: function (data) {
			           $('#listCost').html(data)
			           $('#listCost').css({display:'block'});
			        }
			    });
			} else
			{
				$.ajax({
			        url: "<?php echo $tpoint?>/main/SearchCosts.php?txt=" + txt + '&l=' + lang + '&selCost=' + selectedCost + '&tpoint=<?php echo $tpoint?>',
			        context: document.body,
			        success: function (data) {
			           $('#listCost').html(data)
			           $('#listCost').css({display:'block'});
			        }
			    });
			}
			selectedElement = -1;
		}
} 

function OnCLickCost(_id) {
	var costName = $($('#listCost .div-select')[0]).children()[0].innerHTML;
	costName = costName.replace(/<b style="color: rgb(255, 0, 0);">/g,'')
	costName = costName.replace(/<b style="color: #FF0000">/g,'')
	costName = costName.replace(/<\/b>/g,'')
	costName = costName.replace(/<b style="color: #FF0000">/g,'')
	costName = costName.replace(/<\/b>/g,'')
	
	$('#searchCost').val(costName);
	$('#listCost').hide();
		
	var _id = ($($('#listCost .div-select')[0]).attr("id")).split("-");
	_CostId = _id[1];
	if (_id[1] == "01") _CostId = "Fuel";
	if (_id[1] == "02") _CostId = "Service";
	if (_id[1] == "03") _CostId = "Cost";
	//alert(_CostId)
	$("#searchCost").attr('class', '');
	$('#searchCost').addClass(_CostId);
	costid_ = _CostId;
	changeCost(_CostId);
}
function hideSearchVeh() {
	$('#listVeh').hide();
}
var selectedElement1 = -1;
var selectedCost = '';
function OnKeyPressSearchVeh(_key){
	if(_key == 40 || _key == 38 || _key == 13)
		{
			if($('#listVeh').children().length > 0)
			{
				if(_key == 40 && selectedElement1 < $('#listVeh').children().length-1)
				{
					$('#listVeh .list-item-select').removeClass('list-item-select');
					$($('#listVeh').children()[selectedElement1-1]).removeClass('div-select')
					$($('#listVeh').children()[selectedElement1+1]).addClass('div-select')
					$($($('#listVeh').children()[selectedElement1+1]).children()[0]).show();
					$('#listVeh').children()[selectedElement1+1].scrollIntoView(false);
					selectedElement1=selectedElement1+2;
				}
				if(_key == 38 && selectedElement1 > 0)
				{
					$('#listVeh .list-item-select').removeClass('list-item-select');
					$($('#listVeh').children()[selectedElement1-1]).addClass('div-select')
					$($('#listVeh').children()[selectedElement1+1]).removeClass('div-select')
					$($($('#listVeh').children()[selectedElement1-1]).children()[0]).show();
					$('#listVeh').children()[selectedElement1-1].scrollIntoView(true);
					selectedElement1=selectedElement1-2;
				}
				if(_key == 13)
				{
					var costName = $($('#listVeh .div-select')[0]).children()[0].innerHTML;
					costName = costName.replace(/<b style="COLOR: rgb(255, 0, 0);">/g,'')
					costName = costName.replace(/<b style="COLOR: #FF0000">/g,'')
					costName = costName.replace(/<\/b>/g,'')
					costName = costName.replace(/<b style="COLOR: #FF0000">/g,'')
					costName = costName.replace(/<\/b>/g,'')
					$('#searchVeh_').val(costName);
					$('#listVeh').hide();
					//changeCost(costName)
					
					var _id = ($($('#listVeh .div-select')[0]).attr("id")).split("-v");
					_CostId = _id[1];
					
					$("#searchVeh_").attr('class', '');
					$('#searchVeh_').addClass(_CostId);
					vehid_ = _CostId;
					changeVehic()
				}
			} else
			{
			}
		} else
		{
			var txt = $('#searchVeh_').val()
debugger;
			if(txt == '')
			{
				$.ajax({
			        url: "<?php echo $tpoint?>/main/SearchVeh.php?txt=" + txt + '&l=' + lang + '&selCost=' + selectedCost + '&tpoint=<?php echo $tpoint?>',
			        context: document.body,
			        success: function (data) {
			           $("#searchVeh_").attr('class', ''); 	
			           $('#listVeh').html(data)
			           $('#listVeh').css({display:'block'});
			        }
			    });
			} else
			{
				txt = txt.replace(/ /g,'%20');
				$.ajax({
			        url: "<?php echo $tpoint?>/main/SearchVeh.php?txt=" + txt + "&l=" + lang + "&selCost=" + selectedCost + "&tpoint=<?php echo $tpoint?>",
			        context: document.body,
			        success: function (data) {
			           //alert(data)
			           $('#listVeh').html(data)
			           $('#listVeh').css({display:'block'});
			        }
			    });
			}
			selectedElement = -1;
		}
} 

function OnCLickVeh(_id) {	
	var costName = $($('#listVeh .div-select')[0]).children()[0].innerHTML;
	costName = costName.replace(/<b style="COLOR: rgb(255, 0, 0);">/g,'')
	costName = costName.replace(/<b style="COLOR: #FF0000">/g,'')
	costName = costName.replace(/<\/b>/g,'')
	costName = costName.replace(/<b style="COLOR: #FF0000">/g,'')
	costName = costName.replace(/<\/b>/g,'')
	$('#searchVeh_').val(costName);
	$('#listVeh').hide();
	//changeCost(costName);
	
	var _id = ($($('#listVeh .div-select')[0]).attr("id")).split("-v");
	_CostId = _id[1];
	
	$("#searchVeh_").attr('class', '');
	$('#searchVeh_').addClass(_CostId);
	vehid_ = _CostId;
	changeVehic()	
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
