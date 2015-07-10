<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
	opendb();
	$Allow = getPriv("groupspoi", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
?>
<html>
<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	<script type="text/javascript" src="../tracking/live.js"></script>
	<script type="text/javascript" src="../tracking/live1.js"></script>
	<script src="../js/jquery-ui.js"></script>
	<link rel="stylesheet" href="../js/mlColorPicker.css" type="text/css" media="screen" charset="utf-8" />
	<script type="text/javascript" src="../js/mlColorPicker.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css"> 
 	.menuTable { display:none; width:200px; } 
 	body{ overflow-y:auto }
	</style> 
	
	<style>
		.ui-button { margin-left: -1px; }
		.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
		.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }
	</style>
	
	<script type="text/javascript">
	$(document).ready(
		function changecolor()
    	{
    		$("#Color1").mlColorPicker({ 'onChange': function (val) {
        	$("#Color1").css("background-color", "" + val);
        	$("#FillColor").val("" + val);
    		}
    	});
    });
    </script>
    
    <script type="text/javascript">
    function test(_id){
    	$("#box_"+_id).slideToggle("slow");
    }
    </script>
    <script type="text/javascript">
    cc=0;
    function changeimage()
    {
		if (cc==0) 
		  {
		  cc=1;
		  document.getElementById('myimage').src="../images/down1.png";
		  }
		  else
		  {
		  cc=0;
		  document.getElementById('myimage').src="../images/up1.png";
		  }
	}
    </script>
    <script type="text/javascript">
    ccc=0;
    function changeimage1(id)
    {
		  if(ccc==0) 
		  {
		  ccc=1;
		  document.getElementById('myimage1'+id).src="../images/down1.png";
		  }
		  else
		  {
		  ccc=0;
		  document.getElementById('myimage1'+id).src="../images/up1.png";
		  }
	}
    </script>
    
    <script type="text/javascript">
  		var checked=false;
		var frmname='';
	</script>
	
	<script type="text/javascript">
	function EditGroup(id,lang){
		ShowWait()
		$.ajax({
		    url: "EditColor.php?id="+id+"&l="+lang,
		    context: document.body,
		    success: function(data){
                HideWait()
				$("#colorPicker1").mlColorPicker({ 'onChange': function (val) {
			    $("#colorPicker1").css("background-color", "#" + val);
			    $("#clickAny").val("#" + val);
			    }
			    });
			    $('#NameGroup').val(data.split("$$")[0].replace("\n\n",""));
			    $('#clickAny').val(data.split("$$")[1]);
			    changecolor()
			    document.getElementById('div-edit-user').title = dic("Settings.ChangingGroup")
		        $('#div-edit-user').dialog({ modal: true, width: 350, height: 200, resizable: false,
		             buttons: 
		             [
		             {
		             	text:dic("Settings.Change",lang),
				        click: function() {
		                    var GroupName = $('#NameGroup').val()
		                    var ColorName = encodeURIComponent($('#clickAny').val())
		                    if(GroupName==''){
		                        alert(dic("Settings.noGroupName", lang))  
		                    }else{
		                        if(ColorName==''){
		                            alert(dic("Settings.ChooseColor", lang)) 
		                        }
		                        else{
		                        	
		                            $.ajax({
									url: "UpGroup.php?id1="+id+"&GroupName="+GroupName+"&ColorName="+ColorName,
		                             context: document.body,
		                              success: function(data){
		                              	alert(dic("Settings.GroupSuccessfullyChanged"),lang)
			                            window.location.reload();
										}
		                            });	
		                            $( this ).dialog( "close" );
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
	function AddColor(lang) {
	document.getElementById('div-add-color').title = dic("Reports.AddGroup")
	$('#div-add-color').dialog({ modal: true, width: 350, height: 280, resizable: false,
			buttons: 
            [
            {
            	text:dic("Settings.Add",lang),
				click: function() {
                    
                    var name = $('#GroupNameName').val()
                    var color = $('#FillColor').val()
                   
                    if (name=='')
                    {
                    	alert(dic("Settings.noGroupName", lang))
                    }
                    else
                    {
                        if (color=='')
                        {
                            alert(dic("Settings.ChooseColor", lang))
                        }
                        else
                        {
									  $.ajax({
		                              url: "AddColor.php?name="+name+"&color="+color, 
		                              context: document.body,
		                              success: function(data){
		                              	alert(dic("Settings.AddedGroup"),lang)
			                            window.location.reload();
		                              }
		                            });	
                                    $( this ).dialog( "close" );
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
	function DeleteGroup(id,lang, cntRows) {
	if(cntRows>0){
	document.getElementById('div-del-group').title = dic("Settings.Action");
	$('#div-del-group').dialog({ modal: true, width: 350, height: 300, resizable: false,
	buttons: 
	[
	{
					text:dic("Settings.Delete",lang),
  					click: function() {
  						var groupid = $("#GroupName option:selected").val();
                            $.ajax({
                            	url:"DelGroupPOI.php?id="+id+"&groupid="+groupid,
		                        context: document.body,
		                        success: function(data){
		                        alert(dic("Settings.DeletedGroup"),lang)
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
    else
    {
    document.getElementById('div-del-group1').title = dic("Settings.Action");
	$('#div-del-group1').dialog({ modal: true, width: 350, height: 220, resizable: false,
	buttons: 
	[
	{
					text:dic("Settings.Delete",lang),
  					click: function() {
  						
                            $.ajax({
                            	url:"DelGroupPOI.php?id="+id,
		                        context: document.body,
		                        success: function(data){
		                        alert(dic("Settings.DeletedGroup"),lang)
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
    }
    function DeletePOI(id,lang){
	ShowWait()
	var vehicles = '0'
	$.ajax({
		    url:"ListPOI.php?id="+id+"&l="+lang,
		    context: document.body,
		    success: function(data){
                HideWait()
			$('#div-del-poi').html(data)
			document.getElementById('div-del-poi').title = dic("Reports.DeletePoi");
            $('#div-del-poi').dialog({  modal: true, width: 350, height: 300, resizable: false,
                  buttons:
                  [
                   {
                   	text:dic("Settings.Delete",lang),
                   	 click: function(){
                        var _vehicles = document.getElementById("div-del-poi")
                        
                        if(_vehicles.childNodes.length > 0)
                        {
                            for (var x = 0; x < _vehicles.childNodes.length; x++)
                            {
                                if(_vehicles.childNodes[x].childNodes.length > 0)
                                {
                                    if(_vehicles.childNodes[x].childNodes[0].checked == true)
                                    { 
										vehicles = vehicles + ';' + _vehicles.childNodes[x].childNodes[0].id
									}
                                }
                            }
							
							var id1 = '0'
                            var id12 = document.getElementById("allCheckboxes");
                      		var vkupno = document.getElementById("allCheckboxes").children.length;
                      		var i = 0;
 							
 							while(i<vkupno){
                   			id1 = id12.children[i].attributes.id.nodeValue;
                   			var id123 = document.getElementById("allCheckboxes").children[i];
							
							if($(id123).is(':checked')){
            					 $.ajax({
    							 type: 'POST',
    							 url : "DelPOI.php?id1="+id1,
    							 context: document.body,
		    					 success: function(data){
								 }
  							   });
    						}
							i=i+2;
							}
							alert(dic("Settings.SuccDeleted"),lang)
  							window.location.reload();
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
           })
         }
      });
	}
	function EditPOI1(id,lang)
	{
		ShowWait()
		$.ajax({
		    url:"TransferPOI.php?id="+id+"&l="+lang,
		    context: document.body,
		    success: function(data){
            HideWait()
			$('#div-edit-poi').html(data)
			document.getElementById('div-edit-poi').title = dic("Settings.SwitchPOI")
            $('#div-edit-poi').dialog({  modal: true, width: 350, height: 300, resizable: false,
                  buttons: 
                  [
                  {
                  	text:dic("Settings.Change",lang),
                    click: function(){
                    _vehicles = document.getElementById("div-edit-poi")
                        
                        if(_vehicles.childNodes.length > 0)
                        {
                            for (var x = 0; x < _vehicles.childNodes.length; x++)
                            {
                                if(_vehicles.childNodes[x].childNodes.length > 0)
                                {
                                    if(_vehicles.childNodes[x].childNodes[0].checked == true)
                                    { 
										vehicles = vehicles + ';' + _vehicles.childNodes[x].childNodes[0].id
									}
                                }
                            }
                            var id1 = '0'
                            var id12 = document.getElementById("allCheckboxes2");
                      		var vkupno = document.getElementById("allCheckboxes2").children.length;
                      		var groupidVtoro = $("#GroupName1 option:selected").val();
                      		var i = 0;
                      		
 							while(i<vkupno){
                   			id1 = id12.children[i].attributes.id.nodeValue;
                   			var id123 = document.getElementById("allCheckboxes2").children[i];
							
							if($(id123).is(':checked')){
            					 $.ajax({
    							 type: 'POST',
    							 url : "UpPOI.php?id1="+id1+"&groupidVtoro="+groupidVtoro,
    							 context: document.body,
		    					 success: function(data){
								 }
  							   });
    						}
    						i=i+2;
  							}
  							alert(dic("Settings.SuccSwitched"),lang)
  							window.location.reload();
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
            })
          }
        });
		}
		
		function OpenMapAlarm(lat, lon, reg, dat, time, speed){
	    $('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; border:0px" src=""></iframe>');
	    //alert('LoadMap.php?lon=' + lon + '&lat=' + lat);
	    document.getElementById('iframemaps').src = 'LoadMap.php?lon=' + lon + '&lat=' + lat + '&reg=' + reg + '&dat=' + dat + '&time=' + time + '&speed=' + speed + '&l=' + lang;
	    $('#dialog-map').dialog({ modal: true, height: 650, width: 800 });
	    }

		function OpenMapAlarm1(id, name , type){
	    $('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; border:0px" src=""></iframe>');
	    document.getElementById('iframemaps').src = 'LoadMap.php?id=' + id + '&name=' + name + '&type=' + type;
	    $('#dialog-map').dialog({ modal: true, height: 650, width: 800 });
		}
		
		function OpenMapAlarm2(id, name , type){
		
	    $('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; border:0px" src=""></iframe>');
	    document.getElementById('iframemaps').src = 'LoadMap.php?id=' + id + '&name=' + name + '&type=' + type;
	    $('#dialog-map').dialog({ modal: true, height: 650, width: 800 });
	    	
		}
		
		function OpenMapAlarm3(id){
		
	    $('#dialog-map').html('<iframe id="iframemaps" style="width: 100%; height: 100%; border:0px" src=""></iframe>');
	    document.getElementById('iframemaps').src = 'LoadMap2.php?id=' + id;
	    $('#dialog-map').dialog({ modal: true, height: 650, width: 800 });
	    }
		
		//document.getElementById('dialog-message').title = dic("Reports.Message")
		</script>
		</head>
		<body>
		<?php
   		$ds="SELECT * from pointsofinterestgroups where clientid = " . Session("client_id");
		$dsRez = query($ds);
		$search = "select * from pointsofinterest where clientid = " . Session("client_id");
		$sear = query($search);
		if(pg_num_rows($sear)==0 && pg_num_rows($dsRez) == 0){
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
	<div id="dialog-map" style="display:none" title="<?php echo dic_("Reports.ViewOnMap")?>"></div>
	<span class="textTitle" style="padding-left:5px "><?php echo dic("Settings.Pois")?></span>
	<div align = "center">	
	<table width="70%" style="margin-top:20px; margin-left:30px;padding-left:5px">
	<tr class="text2" >
	<td width = "50%" align = "left" valign = "middle">
	<button id="kopce" onclick="AddColor()" style="margin-left:1px"><?php echo dic("Reports.AddGroup")?></button>
	<td width = "50%" align = "right" valign="middle">
	<input id="inp2" name="filter" onfocus="if(this.value == '<?php echo dic ("search")?>') { this.value = ''; }" onblur="if(this.value == '') { this.value = '<?php echo dic ("search")?>'; }" value="<?php echo dic ("search")?>" onkeyup="searchWords(this, 'chfind_')" type="text" size=22 style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>&nbsp;
	<img src="../images/lupa3.png" width = "22px" height = "20px" style="position: relative; top: 6px; "></img>
	</td>
	</tr>
	<tr>
	<td></td>
	<td align="right">
	<a href = "excel.php"><input align = "top" style="padding-top:3px; " valign = "middle" type="image" width = "25px" height = "25px" src="../images/eExcel3.png"></input></a>
	</td>
	</tr>
	</table>
	</div>
	<?php
	$cnt5 = 1;
	$i = 1;
    $pecati = query("SELECT * from pointsofinterest where groupid = ".$i."");
	$row = pg_fetch_array($pecati);
	?>
	<div align = "center">
	<table id="lbPOI<?php echo $i?>"  width="70%" border="0" cellspacing = "2" cellpadding = "2" style="margin-top:30px; margin-left:35px">
	<tr>
		<td align = "left" valign = "middle" height="40px" width = "100%" class="text2" style="color:#fff; font-weight:bold; font-size:14px;  padding-left:7px; background-color:#f7962b; font-weight:bold;" id="slider_<?php echo $i?>" onclick="test(<?php echo $i?>)"><a href= "#middle"><img id="myimage" onclick="changeimage()" style="position:relative; top:4px" src="../images/up1.png" ></img></a><?php echo dic("Settings.NotGroupedItems")?></td>
	</tr>
	<tr>
  	<td align = "left" colspan="9" width="80%" height="30px" align="left" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
  		<div id="box_<?php echo $i?>">
  		<table width="100%" id="chfind_<?php echo $i?>">
  		<?php
 		
 		$poi = query("select id,type,groupid,name,radius,available from pointsofinterest where groupid = " . $i. " and clientid = " . Session("client_id")." order by name");
		
  		while ($row1 = pg_fetch_array($poi))
 		{
 			if($row1["type"] == 1)
			{
				$lon = dlookup("select st_y(st_transform(geom,4326)) lon from pointsofinterest where id=" . $row1["id"]);
				$lat = dlookup("select st_x(st_transform(geom,4326)) lat from pointsofinterest where id=" . $row1["id"]);
			} else
			{
				$lon = dlookup("select st_y(st_centroid(geom)) lon from pointsofinterest where id=" . $row1["id"]);
				$lat = dlookup("select st_x(st_centroid(geom)) lat from pointsofinterest where id=" . $row1["id"]);
			} 
		?>
		<tr>
			<td width="76%" valign = "middle" colspan="5" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:18px">
				<?php
				if($row1["type"] == 1)
				{
				?>
					<img src = "../images/poi2.png" height="25px" width = "25px"></img>
					
					<?php
				}
				elseif ($row1["type"] == 2) 
				{
				?>
					<img src = "../images/zone.png" height="25px" width = "25px"></img>
				<?php
				}
				?>
				&nbsp;&nbsp;&nbsp;
				<?php echo $row1['name'] ?>
				
			</td>
			<td align = "center" width = "6%" align = "center" colspan="5" height="30px" class="text2" valign = "middle" style="background-color:#fff;border:1px dotted #B8B8B8 ">
			<button id="btnprivilegesz<?php echo $cnt5?>"  onclick="EditPOI1('<?php echo $row1["id"]?>','<?php echo $cLang?>')" style="height:22px; width:30px"></button>
			</td>
			<td align = "center" width = "6%" align = "center" colspan="5" height="30px" class="text2" valign = "middle" style="background-color:#fff;border:1px dotted #B8B8B8 ">
			<button id="btnMapPoiUngroup<?php echo $cnt5?>" <?php  if($row1["type"] ==1){?> onclick = "OpenMapAlarm1('<?php echo $row1["id"]?>', '<?php echo $row1["name"]?>', '<?php echo $row1["type"]?>');" <?php  } if($row1["type"]==2){ ?> onclick = "OpenMapAlarm1('<?php echo $row1["id"]?>', '<?php echo $row1["name"]?>', '<?php echo $row1["type"]?>');" <?php }?> style="height:22px; width:30px"></button>
			</td>
			<td align = "center" width = "6%" align = "center" colspan="5" height="30px" class="text2" valign = "middle" style="background-color:#fff;border:1px dotted #B8B8B8 ">
			<button id="btnEditPoiUngroup<?php echo $cnt5?>" <?php  if($row1["type"] ==1){?> onclick="EditPOI('<?php echo $lon?>','<? echo $lat?>','<?php echo $row1["name"]?>','<?php echo $row1["available"]?>','<?php echo $row1["groupid"]?>','<?php echo $row1["id"]?>','','1','','<?php echo $row1["radius"]?>');" <?php  } if($row1["type"]==2){ ?> onclick = "OpenMapAlarm2('<?php echo $row1["id"]?>', '<?php echo $row1["name"]?>', '<?php echo $row1["type"]?>');" <?php }?>style="height:22px; width:30px"></button>
			</td>
			<td align = "center" width = "6%" align = "center" colspan="5" height="30px" class="text2" valign = "middle" style="background-color:#fff;border:1px dotted #B8B8B8 ">
			<button id="btnDeletez<?php echo $cnt5?>"  onclick="DeletePOI('<?php echo $row1["id"]?>','<?php echo $cLang?>')" style="height:22px; width:30px"></button>
			</td>
		</tr>
		<?php
		$cnt5++;
		}
		?>
		</div>
		</table>
		</td>
		</tr>
	</table>
	<script>
		for (var k=0; k <= <?php echo $cnt5?> -1; k++) {
		$('#btnDeletez' + k).button({ icons: { primary: "ui-icon-trash"} });
		$('#btnprivilegesz' + k).button({ icons: { primary: "ui-icon-refresh"} });
		$('#btnEditPoiUngroup' + k).button({ icons: { primary: "ui-icon-pencil"} });
		$('#btnMapPoiUngroup' + k).button({ icons: { primary: "ui-icon-search"} });
		}
    </script>
	</div>
	<?php
	$cnt = 1;
	$cnt3 = 1;
	$i = 2;
	$pecati = query("SELECT * from pointsofinterestgroups where clientid = " . Session("client_id"));
	
 	while ($row = pg_fetch_array($pecati))
 	{
 		$cntRows = dlookup("select count(*) from pointsofinterest where groupid=" . $row["id"]);	
	?>
	<div align = "center">
	<table id="lbPOI<?php echo $row["id"]?>"  width="70%" border="0" cellspacing = "2" cellpadding = "2" style="margin-top:30px; margin-left:35px">
	<tr>
		<td align = "left" valign = "middle" height="40px" width = "82%" class="text2" style="color:#fff; font-weight:bold; font-size:14px;  padding-left:7px; background-color:#f7962b; font-weight:bold;" id="slider_<?php echo $i?>" onclick="test(<?php echo $i?>)"><a href= "#middle"><img id="myimage1<?php echo $i?>" onclick="changeimage1(<?php echo $i?>)" style="position:relative; top:4px" src="../images/up1.png" ></img></a><?php echo dic("Group")?>&nbsp;<?php echo $row["name"] ?></td>
		<td align = "center" valign = "middle" height="40px" class="text2" width = "6%" style="color:#fff; font-weight:bold; font-size:14px; padding-left:5px; padding-right:5px; background-color:#f7962b; font-weight:bold;" >
			<button id="btnGroupMap<?php echo $cnt?>"  onclick="OpenMapAlarm3('<?php echo $row["id"]?>','<?php echo $cLang?>')" style="height:22px; width:30px"></button>
		</td>
		<td align = "center" valign = "middle" height="40px" class="text2" width = "6%" style="color:#fff; font-weight:bold; font-size:14px; padding-left:5px; padding-right:5px; background-color:#f7962b; font-weight:bold;" >
			<button id="btnEdit<?php echo $cnt?>"  onclick="EditGroup('<?php echo $row["id"]?>','<?php echo $cLang?>')" style="height:22px; width:30px"></button>
		</td>
		<td align = "center" valign = "middle" height="40px" class="text2" width = "6%" style="color:#fff; font-weight:bold; font-size:14px; padding-left:5px; padding-right:5px; background-color:#f7962b; font-weight:bold;" >
			<button id="btnVehicles<?php echo $cnt?>"  onclick="DeleteGroup('<?php echo $row["id"]?>','<?php echo $cLang?>', <?php echo $cntRows?>)" style="height:22px; width:30px"></button>
		</td>
	</tr>
	<tr class="text2">
  		<td align = "left" colspan="9" width="80%" height="30px" align="left" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
  		<div id="box_<?php echo $i?>">
  		<table width="100%" id="chfind_<?php echo $i?>">
  		<?php
  		
		$poi = query("select id,type,groupid,name,radius,available from pointsofinterest where groupid = " . $row["id"]. " and clientid = " . Session("client_id")." order by name");
		
		while ($row1 = pg_fetch_array($poi))
		{
			if($row1["type"] == 1)
			{
				$lon = dlookup("select st_y(st_transform(geom,4326)) lon from pointsofinterest where id=" . $row1["id"]);
				$lat = dlookup("select st_x(st_transform(geom,4326)) lat from pointsofinterest where id=" . $row1["id"]);
			} 
			else
			{
				$lon = dlookup("select st_y(st_centroid(geom)) lon from pointsofinterest where id=" . $row1["id"]);
				$lat = dlookup("select st_x(st_centroid(geom)) lat from pointsofinterest where id=" . $row1["id"]);
			} 
		
		?>
		<tr class="text2">
			<td width="76%" colspan="5" height="30px" class="text2" style="background-color:#fff; padding-left:18px;border:1px dotted #B8B8B8;">
				<?php
				if($row1["type"] == 1){?>
					<img src = "../images/poi2.png" height="25px" width = "25px"></img>
					<?php
				}
				elseif ($row1["type"] == 2) 
				{?>
					<img src = "../images/zone.png" height="20px" width = "20px"></img>
				<?php
				}
				?>
				&nbsp;&nbsp;&nbsp;
				<?php echo $row1['name']?>
			</td>
			<td align = "center" width = "6%" align = "center" colspan="5" height="30px" class="text2" valign = "middle" style="background-color:#fff;border:1px dotted #B8B8B8 ">
			<button id="btnprivileges<?php echo $cnt3?>"  onclick="EditPOI1('<?php echo $row1["id"]?>','<?php echo $cLang?>')" style="height:22px; width:30px"></button>
			</td>
			<td align = "center" width = "6%" align = "center" colspan="5" height="30px" class="text2" valign = "middle" style="background-color:#fff;border:1px dotted #B8B8B8 ">
			<button id="btnMapPoi<?php echo $cnt3?>" <?php  if($row1["type"] ==1){?> onclick = "OpenMapAlarm1('<?php echo $row1["id"]?>', '<?php echo $row1["name"]?>', '<?php echo $row1["type"]?>');" <?php  } if($row1["type"]==2){ ?> onclick = "OpenMapAlarm1('<?php echo $row1["id"]?>', '<?php echo $row1["name"]?>', '<?php echo $row1["type"]?>');" <?php }?> style="height:22px; width:30px"></button>
			</td>
			<td align = "center" width = "6%" align = "center" colspan="5" height="30px" class="text2" valign = "middle" style="background-color:#fff;border:1px dotted #B8B8B8 ">
			<button id="btnEditPoi<?php echo $cnt3?>" <?php  if($row1["type"] ==1){?> onclick="EditPOI('<?php echo $lon?>','<? echo $lat?>','<?php echo $row1["name"]?>','<?php echo $row1["available"]?>','<?php echo $row1["groupid"]?>','<?php echo $row1["id"]?>','','1','','<?php echo $row1["radius"]?>');" <?php  } if($row1["type"]==2){ ?> onclick = "OpenMapAlarm2('<?php echo $row1["id"]?>', '<?php echo $row1["name"]?>', '<?php echo $row1["type"]?>');" <?php }?> style="height:22px; width:30px"></button>    
			</td>	
			<td align = "center" width = "6%" align = "center" colspan="5" height="30px" class="text2" valign = "middle" style="background-color:#fff;border:1px dotted #B8B8B8 ">
			<button id="btnDelete<?php echo $cnt3?>"  onclick="DeletePOI('<?php echo $row1["id"]?>','<?php echo $cLang?>')" style="height:22px; width:30px"></button>
			</td>
		</tr>
		<?php
		$cnt3++;
		}
		?>
		</div>
		</table>
		</td>
		</tr>
	</table>
	</div>	
	</div>
	<?php
	$cnt++;
	$cnt3++;
	$i++;
	}
	}
	?>
	</div>
	<script>
	for (var i=0; i <= <?php echo $cnt3?> -1; i++)
	{
		$('#btnGroupMap' + i).button({ icons: { primary: "ui-icon-search"} });
		$('#btnMapPoi' + i).button({ icons: { primary: "ui-icon-search"} });
		$('#btnEdit' + i).button({ icons: { primary: "ui-icon-pencil"} });
		$('#btnEditPoi' + i).button({ icons: { primary: "ui-icon-pencil"} });
		$('#btnVehicles' + i).button({ icons: { primary: "ui-icon-trash"} });
		$('#btnDelete' + i).button({ icons: { primary: "ui-icon-trash"} });
		$('#btnprivileges' + i).button({ icons: { primary: "ui-icon-refresh"} });
	}
	</script>
	</div>
	</div>
    <div id="div-del-group" style="display:none" title="<?php echo dic("Settings.Action")?>">
    <?php echo dic("Settings.QuestionForDeleteGroup1")?><br><br>
    <?php echo dic("Settings.QuestionForDeleteGroup2")?><br><br>
	<br>
	<label class="text5"> <?php echo dic("Tracking.Group")?>:</label>
    <?php $find = query("SELECT id,name from pointsofinterestgroups where clientid = " . Session("client_id")."order by name");
    $n = 1;
	
    ?>

    <select id="GroupName" class="combobox text2">
    <option id="<?php echo $n ?>" value = "<?php echo $n ?>"><?php echo dic("Settings.NotGroupedItems")?> </option>
    <?php	
		while($row = pg_fetch_array($find)){
			  $data[] = ($row);
			  }
			  foreach ($data as $row){
	?>
	
    <option id="<?php echo $row["id"] ?>" value = "<?php echo $row["id"] ?>"><?php echo $row["name"] ?>
	</div>
				<?php
				}
				?>
				</option>
				</select>
	<div id="div-add-color" style="display:none" title="<?php echo dic("Reports.AddGroup")?>">
    <table>
    	<tr>
        	<td class="text5" style="font-weight:bold"><?php echo dic("Tracking.GroupName")?></td>
            <td>
                	<input id="GroupNameName"  type="text" class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>
           	</td>
        </tr>
        <tr>
            <td class="text5" style="font-weight:bold"><?php echo dic("Settings.ChooseColor")?></td>
            <td>
	   			<div id="Color">
				<span id="Color1" style="cursor: pointer; float:left; border:1px solid black; width:15px; height:15px;margin:5px;"></span>
				<input id="FillColor" type="text" class="textboxCalender corner5" onclick="changecolor()" value="" style="width:175px;height:25px;" />
	   			</div>
			</td>
    	</tr>
	</table>
    </div>		
	<div id="div-del-group1" style="display:none" title="<?php echo dic("Settings.Action")?>">
       <?php echo dic("Settings.QuestionForDeleteGroup1")?><br><br>
    </div>
	</div>
	<div id="div-edit-user" style="display:none" title="<?php echo dic("Settings.ChangingGroup")?>">
	<table>
	        <tr>
	        <td class="text5" style="font-weight:bold"><?php  echo dic("Routes.Name")?></td>
	        <td>
	            <input id="NameGroup" type="text" value="" class="textboxcalender corner5 text5" style="width:200px; height:22px; font-size:11px"/>
	        </td>
		    </tr>
	    	<tr>
	            <td class="text5" style="font-weight:bold"><?php echo dic("Reports.Color")?></td>
	        <td>
			<div id="colorPicker2">
				<span id="colorPicker1" style="cursor: pointer; float:left; border:1px solid black; width:20px; height:20px;margin:5px;"></span>
				<input id="clickAny" type="text" class="textboxCalender corner5" onchange="changecolor()" value="" style="width:120px" />
			</div>
	        </td>
	        </tr>
	</table>
	</div>
	
    <div id="div-del-poi" style="display:none" title="<?php echo dic("Reports.DeletePoi")?>"></div>
    <div id="div-edit-poi" style="display:none" title="<?php echo dic("Settings.SwitchPOI")?>"></div>
    <div id="dialog-message" title="<?php echo dic("Reports.Message")?>" style="display:none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px"></div>
	</p>
	</div>
	<div id="div-Add-POI" style="display: none;">
	<br />
	<table style="font-size: 11px; color: rgb(65, 65, 65); font-family: Arial,Helvetica,sans-serif; margin-left: 20px;" cellpadding="0" cellspacing="0" border="0">
    	<tr>
    		<td width="90px"><?php echo dic("Tracking.Latitude")?></td>
    		<td>
    			<input id="poiLat" type="text" class="textboxCalender corner5" style="width:120px" />
    		</td>
		</tr>
		<tr height="50px">
    		<td width="90px"><?php echo dic("Tracking.Longitude")?></td>
    		<td>
    			<input id="poiLon" type="text" class="textboxCalender corner5" style="width:120px" />
    		</td>
		</tr>
		<tr>
    		<td width="90px"><?php echo dic("Tracking.Address")?></td>
    		<td>
    			<input id="poiAddress" type="text" class="textboxCalender corner5" style="width:269px; position: relative; float: left;" /><img id="loadingAddress" style="visibility: hidden; position: relative; float: left; top: 2px;" width="25px" src="../images/loadingP1.gif" border="0" align="absmiddle" />
    		</td>
		</tr>
		<tr height="50px">
    		<td width="90px"><?php echo dic("Tracking.NamePoi")?></td>
    		<td>
    			<input id="poiName" type="text" class="textboxCalender corner5" style="width:269px" />
    		</td>
		</tr>
		<tr>
    		<td width="90px"><?php echo dic("Tracking.AvailableFor")?></td>
    		<td>
    			<div id="poiAvail" class="corner5" style="font-size: 10px">
			        <input type="radio" id="APcheck1" name="radio" /><label for="APcheck1">Корисник</label>
			        <input type="radio" id="APcheck2" name="radio" /><label for="APcheck2">Организациона единица</label>
			        <input type="radio" id="APcheck3" name="radio" /><label for="APcheck3">Компанија</label>
			    </div>
    		</td>
		</tr>
		<tr height="50px">
    		<td width="90px"><?php echo dic("Tracking.Radius")?></td>
    		<td>
    			<dl id="poiRadius" class="dropdownRadius" style="width: 70px; margin: 0px;">
			        <dt><a href="#middle" title="" class="combobox1"><span><?php echo dic("Tracking.SelectRadius")?></span></a></dt>
			        <dd>
			            <ul>
			                <li><a id="RadiusID_50" href="#middle">50&nbsp;<?php echo dic("Tracking.Meters")?></a></li>
			                <li><a id="RadiusID_70" href="#middle">70&nbsp;<?php echo dic("Tracking.Meters")?></a></li>
			                <li><a id="RadiusID_100" href="#middle">100&nbsp;<?php echo dic("Tracking.Meters")?></a></li>
			                <li><a id="RadiusID_150" href="#middle">150&nbsp;<?php echo dic("Tracking.Meters")?></a></li>
			            </ul>
			        </dd>
			    </dl>
    		</td>
		</tr>
    	<tr>
    		<td width="90px"><?php echo dic("Tracking.Group")?></td>
    		<td>
    			<dl id="poiGroup" class="dropdown" style="width: 150px; position: relative; float: left; padding: 0px; margin: 0px;">
			    <?php
					$dsUG = query("SELECT id, name, fillcolor, '0' image FROM pointsofinterestgroups WHERE id=1");
			        ?>
			        <dt><a href="#middle" title="" id="groupidTEst" class="combobox1"><span><?php echo dic("Tracking.SelectGroup")?></span></a></dt>
			        <dd>
			            <ul>
			                <li><a id="<?php echo pg_fetch_result($dsUG, 0, "id")?>" href="#">&nbsp;&nbsp;<?php echo pg_fetch_result($dsUG, 0, "name")?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 24px; height: 24px; background: url('http://gps.mk/new/pin/?color=<?php echo pg_fetch_result($dsUG, 0, "fillcolor")?>&type=<?php echo pg_fetch_result($dsUG, 0, "image")?>') no-repeat; position: relative; float: left;"></div></a></li>
			                <?php
								$dsGroup1 = query("select id, name, fillcolor, '0' image from pointsofinterestgroups where clientid=".session("client_id"));
			                    while ($row1 = pg_fetch_array($dsGroup1)) {
			                    	$_color = substr($row1["fillcolor"], 1, strlen($row1["fillcolor"]));
			                ?>
			                <li><a id="<?php echo $row1["id"]?>" href="#middle">&nbsp;&nbsp;<?php echo $row1["name"]?><div class="flag" style="margin-top: -3px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; width: 24px; height: 24px; background: url('http://gps.mk/new/pin/?color=<?php echo $_color?>&type=<?php echo $row1["image"]?>') no-repeat; position: relative; float: left;"></div></a></li>
			                <?php
			                    }
			                ?>
			            </ul>
			        </dd>
			    </dl>
    			<input type="button" id="AddGroup" style="left: 20px; top: 1px;" onclick="AddGroup('0')" value="+" />
    		</td>
    	</tr>
	</table>
    <br /><br />
    <input type="hidden" id="idPoi" value="" />
    <input type="hidden" id="numPoi" value="" />
	<div align="right" style="display:block; width:380px; height: 30px; padding-top: 5px; position: relative; float: right; right: 15px;">
        <img id="loading" style="display: none; width: 140px; position: absolute; left: 10px; margin-top: 7px;" src="../images/loading_bar1.gif" alt="" />
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnCancelPOI" value="<?php echo dic("Tracking.Cancel")?>" onclick="$('#div-Add-POI').dialog('destroy');" />        
		<input type="button" style="position: relative; float: right;" class="BlackText corner5" id="btnAddPOI" value="<?php echo dic("Tracking.Add")?>" onclick="ButtonAddEditPOIokClick()" />
		<input type="button" style="display: none; position: relative; float: right; " class="BlackText corner5"  id="btnDeletePOI" value="<?php echo dic("Tracking.Delete")?>" onclick="DeleteGroup()" />
	</div><br /><br />
	</div>
	<br/>
	<br/>
	</body>
    <script>
    top.HideWait();
    </script>
    <script>
    function searchWords (term,_id){

		var suche = term.value.toLowerCase();
        var cnt = 0;
        var i = 0;
        
        cnt = <?php echo $i?>;
        for (var k=1; k < cnt; k++) {
        	i=0;
	        var table = document.getElementById(_id + k);
	        var ele;
	    for (var r = 0; r < table.rows.length; r++){
	        	ele = table.rows[r].cells[0].innerHTML.replace(/<[^>]+>/g,"");
		        if (ele.toLowerCase().indexOf(suche)>=0 )
			        table.rows[r].style.display = '';
		        else table.rows[r].style.display = 'none';
		        if(table.rows[r].style.display!= 'none'){
	        		i++;
	        		}
	        	}
	        	if(i==0){
	        		table.parentElement.parentElement.parentElement.parentElement.parentElement.style.display='none';
	       		}
	       		else{
	       			table.parentElement.parentElement.parentElement.parentElement.parentElement.style.display = 'block';
	       		}
		    }
	    }
   
	   $('#kopce').button({ icons: { primary: "ui-icon-plus"} });
	   document.getElementById('kopce').style.height = "27px";
	   document.getElementById('kopce').style.width = "120px";

	</script>
</html>