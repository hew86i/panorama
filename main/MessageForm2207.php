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
    
   

<style type="text/css">
	/*#divInbox { overflow-y:hidden;}
	#divInbox:hover { overflow-y:scroll; }
	#divSent { overflow-y:hidden;}
	#divSent:scroll { overflow-y:scroll; }*/
	
</style>

 <body>

  <?php
 
      $LastDay = DateTimeFormat(addDay(-1), "d-m-Y");
  	//	$vehID_ = getQUERY("vehid");
	  
	  opendb();
	
      $datetimeformat = dlookup("select datetimeformat from users where id=" . session("user_id"));
      $datfor = explode(" ", $datetimeformat);
      $dateformat = $datfor[0];
      $timeformat =  $datfor[1];
      if ($timeformat == 'h:i:s') $timeformat = $timeformat . " a";

      $cLang = getQUERY("l");
   ?>


             		
<table width=600px height=460px style="margin:10px">
	<tr>
		<td width=35% style="border-right:1px dotted #bebebe;" valign="top">
			<table width=100%>
				<tr>
					<td>
<button title="Compose" style="font-size:11px; width:85px; height:27px;margin-top:10px; margin-right:10px; position: relative; float: right" 
onclick="compose()" id="addMess" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" 
role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-pencil"></span><span class="ui-button-text"><?php echo dic_("reports.Compose")?></span></button>

						
					</td>
				</tr>
				<tr>	
					<td class="text2_">
						<input id="txtSearch" onmouseover="changeSearch(1)" onmouseout="changeSearch(2)" onkeyup="searchMess(this)" type="text" style="font-size:11px; margin-top:10px; margin-right:5px; margin-left:10px; background: url('../images/chosen-sprite.png') no-repeat 100% -20px; border: 0px solid #CCCCCC; height:27px; width:238px; padding-left:5px" class="text2_ corner5"/>
						<!--<div id="changeSearch" onmouseover="changeSearch(1)" onmouseout="changeSearch(2)">
							<div style="position:relative; margin-right:13px;float: right; cursor:pointer; background: url('../images/chosen-sprite.png') no-repeat 100% -20px; height:27px; width:18px; margin-top:15px"></div>	
						</div>-->
						
					</td>
					
				</tr>
				
                 
                 <tr style="height:10px;">
                    <td></td>
              </tr>
             
                <?php
				$totalInbox = dlookup("select count(*) from messages where toid=" . session("user_id"));
				$totalUnreadInbox = dlookup("select count(*) from messages where checked='0' and toid=" . session("user_id"));
				?>
  <tr><td><div style="padding-top:10px; width:238px; height:26px; font-size:14px; border:1px solid #CCCCCC; margin-left:10px; margin-right:10px" class="textSubTitle subtitle corner5">&nbsp;<?php echo dic_("Reports.Inbox")?> [<span id="spanUnread"><?php echo $totalUnreadInbox?></span>/<?php echo $totalInbox?>]
  	<button id="optionsInbox" title="Compose" style="font-size:11px; width:30px; height:26px;margin-top:-5px; margin-right:5px; position: relative; float: right" 
onclick="" id="" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" 
role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-pencil"></span></button>
  	</div></td></tr>
                <tr><td> 
<div id="divInbox" style="height:140px;width:250px;overflow-x:hidden; overflow-y:auto" >

            	<table width=100%>  
                 <?php
                $messinbox = "select * from messages where toid=" . session("user_id") . " order by checked asc, datetime desc";
 
				$dsMessInbox = query($messinbox);   
				$c = 0;
			    while ($drMessInbox = pg_fetch_array($dsMessInbox)) {
				  ?>
				  <tr id="inbox-tr-<?php echo $c?>" ><td>
				  	<table class="text2_" style="margin-left: 5px" width=98%>
				  	
				  		<?php
				  			$from = dlookup("select fullname from users where id=" . $drMessInbox["fromid"]);
				  		?>
						<?php
						$img = "../images/messageunread.png";
						$size = "width=14px height=14px";
						if ($drMessInbox["checked"] == 1) {
							$img = "../images/messageread.png";
							$size = "width=12px height=12px";
						}	
						$color = "#8c8c8c";
						if ($drMessInbox["checked"] == 0) $color = "blue";
						
						?>
				  		<tr  style="cursor:pointer" onclick="loadMess(<?php echo $drMessInbox["id"]?>, 'inbox')">
				  			
				  			<td>
				  				<table width=100% id="table-<?php echo $drMessInbox["id"]?>" class="text2_" style="color:<?php echo $color?>" onmouseover="changeTable(this.id, 0, '<?php echo $color?>')" onmouseout="changeTable(this.id, 1, '<?php echo $color?>')">
				  					<tr >
										<td width=5% valign="top" >
											
											<img id="img-<?php echo $drMessInbox["id"]?>" <?php echo $size?> src="<?php echo $img?>" style="">
										</td>
							  			<td  width=65% ><strong id="inbox-name-<?php echo $c?>"><?php echo $from?></strong></td>
							  			<td width=35% id="inbox-datetime-<?php echo $c?>"><?php echo DateTimeFormat($drMessInbox["datetime"], $dateformat)?></td>
							  		</tr>
							  		<!--<tr><td colspan=3 id="inbox-subject-<?php echo $c?>"><?php echo $drMessInbox["subject"]?></td></tr>-->
							  		<tr><td colspan=3 style="font-style:italic" id="inbox-body-<?php echo $c?>"><?php echo substr($drMessInbox["body"], 0, 70)?> ...</td></tr>
				  				</table>
				  			</td>
				  			
				  		</tr>

				  	</table>
				  </td></tr>
				  
				<!-- <tr id="inbox-trr-<?php echo $c?>" style="height:1px;">
                    <td><div style="border-bottom:1px dotted #bebebe; width:93%; margin-left:8px"></div></td>
           </tr>-->
				  <?php			
				  $c ++;	  	
				}      
if (pg_num_rows($dsMessInbox) == 0) {
	?>
	 <tr style="height:10px;">
          <td><div class="text2_" style="margin-left:8px">- <?php echo dic_("Reports.Empty")?> -</div></td>
     </tr>
	<?php
}      
                ?>
                </table>
                </div>
                </td>
                </tr> 
				<?php
				$totalSent = dlookup("select count(*) from messages where fromid=" . session("user_id"));
				?>
  <tr><td><div style="width:238px; padding-top:10px; height:26px; font-size:14px; border:1px solid #CCCCCC; margin-left:8px; margin-right:10px; margin-top:15px" class="textSubTitle subtitle corner5">&nbsp;<?php echo dic_("Reports.Sentbox")?> [<?php echo $totalSent?>]
  	<button id="optionsSent" title="Compose" style="font-size:11px; width:30px; height:26px;margin-top:-5px; margin-right:5px; position: relative; float: right" 
onclick="" id="" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" 
role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-pencil"></span></button>
  	</div></td></tr>
                         
            <tr><td> 
<div id="divSent" style="height:140px;width:250px;overflow-x:hidden; overflow-y:auto">

            	<table width=100%>
                 <?php
                $messinbox = "select * from messages where fromid=" . session("user_id") . " order by datetime desc";   
				$dsMessInbox = query($messinbox);   
				$cc = 0;
			    while ($drMessInbox = pg_fetch_array($dsMessInbox)) {
				  ?>
				  <tr id="sent-tr-<?php echo $cc?>"><td>
				  	<table class="text2_" width=98% style="margin-left: 5px">
				  	
				  		<?php
				  		if ($drMessInbox["toobject"] == 'user') {
				  			$to = dlookup("select fullname from users where id=" . $drMessInbox["toid"]);
				  		} else {
				  			$to = dlookup("select registration from vehicles where id=" . $drMessInbox["toid"]);
				  		}
				  		
						if ($drMessInbox["checked"] == 1) {
							$img = "../images/messageread.png";
							$size = "width=12px height=12px";
						}	
						$color = "#8c8c8c";
						//if ($drMessInbox["checked"] == 0) $color = "#0290B0";
						
				  		?>
				  		<tr  style="cursor:pointer;" onclick="loadMess(<?php echo $drMessInbox["id"]?>, 'sentbox')" >
				  			
				  			<td>
				  				<table id="table1-<?php echo $drMessInbox["id"]?>" class="text2_" width=100% style="color:<?php echo $color?>" onmouseover="changeTable(this.id, 0, '<?php echo $color?>')" onmouseout="changeTable(this.id, 1, '<?php echo $color?>')">
				  					<tr style="color:#8c8c8c;">
										<td width=5% valign="top">
											<img width="17px" height="11px" src="../images/messagesent.png" style="">
										</td>
							  			<td width=65%><strong id="sent-name-<?php echo $cc?>"><?php echo $to?></strong></td>
							  			<td width=35% id="sent-datetime-<?php echo $cc?>"><?php echo DateTimeFormat($drMessInbox["datetime"], $dateformat)?></td>
							  		</tr>
							  		<!--<tr style="color:#8c8c8c"><td id="sent-subject-<?php echo $cc?>" colspan=3 ><?php echo $drMessInbox["subject"]?></td></tr>-->
							  		<tr style="color:#8c8c8c"><td id="sent-body-<?php echo $cc?>" colspan=3 style="font-style:italic;"><?php echo substr($drMessInbox["body"], 0, 70)?> ...</td></tr>
				  				</table>
				  			</td>
				  		</tr>
				  		
				  	</table>
				  </td></tr>
				  
				<!--<tr id="sent-trr-<?php echo $cc?>" style="height:1px;">
                    <td><div style="border-bottom:1px dotted #bebebe; width:93%; margin-left:8px"></div></td>
           </tr>-->
				  <?php		
				  $cc ++;		  	
				}       

			if (pg_num_rows($dsMessInbox) == 0) {
				?>
				 <tr style="height:10px;">
			          <td><div class="text2_" style="margin-left:8px">- <?php echo dic_("Reports.Empty")?> -</div></td>
			     </tr>
				<?php
			}   
                ?> 
                </div>
                </table>
               </tr></td> 
                
			</table>
		</td>
		<td width=65% valign="top" align="center" >
			<div id ="messcontent">
				
			</div>
		</td>
	</tr>
</table>

</body>
<?php
closedb();
?>

<script>

    top.HideWait();
	var val = "";

$('#divInbox').tinyscrollbar();

function changeTable(idTab, i, color) {
	if (i == 0) {
		if (color != "blue") {
			$('#' + idTab).css({color:"#8C8C8C"})
			$('#' + idTab).css({backgroundColor:"#f2f2f2"})		
		} else {
			$('#' + idTab).css({color:"blue"})
			$('#' + idTab).css({backgroundColor:"#fff"})		
		}
	} else {
		$('#' + idTab).css({backgroundColor:""})	
		$('#' + idTab).css({color: color})	
	}
}

function hoverDiv(idDiv) {
	$('#' + idDiv).css({ overflowY: 'auto' });
}

function outDiv(idDiv) {
	$('#' + idDiv).css({ overflowY: 'hidden' });
}

function changeSearch(i){
	var img = "../images/chosen-sprite.png";
	if (i == 1) {
		//document.getElementById('changeSearch').innerHTML = "<input id='txtSearch' onkeyup='searchMess(this)' type='text' style='font-size:11px; margin-top:10px; margin-right:5px; margin-left:10px; background: url(" + img + ") no-repeat 100% -20px; border: 1px solid #CCCCCC; height:27px; width:238px; padding-left:5px' class='text2_ corner5'/>";
		document.getElementById('txtSearch').style.border = "1px solid #cccccc";
		document.getElementById('txtSearch').value = val;
		$('#txtSearch').focus();
	} else {
		document.getElementById('txtSearch').style.border = "0px solid #cccccc";
		val = document.getElementById('txtSearch').value;
		document.getElementById('txtSearch').value = "";
		$('#txtSearch').blur(); 
	}
		//document.getElementById('changeSearch').innerHTML = "<div style='position:relative; margin-right:13px;float: right; cursor:pointer; background: url(" + img + ") no-repeat 100% -20px; height:27px; width:18px; margin-top:15px'></div>";	
}
  function loadMess(messid, fromto) {
  	//document.getElementById("messcontent").innerHTML = "<div style='padding-top:250px'><img src='../images/ajax-loader.gif' border='0' align='absmiddle' width='31' height='31' />&nbsp;<span class='text1' style='color:#5C8CB9; font-weight:bold; font-size:11px'>Loading message...</span></div>"
  	 $("#messcontent").load('../main/LoadMess2207.php?messid=' + messid + '&fromto=' + fromto + '&l=' + lang);
  }
  
  function compose(messid, fromto) {
  	 $("#messcontent").load('../main/ComposeMess2207.php?l=' + lang);
  }
  
  function searchMess(term) {
  	var suche = term.value.toLowerCase();
  	for (var i=0; i< <?php echo $c?>; i++) {
  		if (document.getElementById("inbox-name-" + i).innerHTML.toLowerCase().indexOf(suche) >= 0 || 
  		document.getElementById("inbox-datetime-" + i).innerHTML.toLowerCase().indexOf(suche) >= 0 ||
  		document.getElementById("inbox-body-" + i).innerHTML.toLowerCase().indexOf(suche) >= 0)
	        {
	        //document.getElementById("inbox-trr-" + i).style.display = '';	
			document.getElementById("inbox-tr-" + i).style.display = '';
        } else  {
        	//document.getElementById("inbox-trr-" + i).style.display = 'none';
        	document.getElementById("inbox-tr-" + i).style.display = 'none';
        }
  	}
  	
  	for (var i=0; i< <?php echo $cc?>; i++) {
  		if (document.getElementById("sent-name-" + i).innerHTML.toLowerCase().indexOf(suche) >= 0 || 
  		document.getElementById("sent-datetime-" + i).innerHTML.toLowerCase().indexOf(suche) >= 0 ||
  		document.getElementById("sent-body-" + i).innerHTML.toLowerCase().indexOf(suche) >= 0) {
	        //document.getElementById("sent-trr-" + i).style.display = '';
	        document.getElementById("sent-tr-" + i).style.display = '';
        } else {
        	//document.getElementById("sent-trr-" + i).style.display = 'none';
        	document.getElementById("sent-tr-" + i).style.display = 'none';
        }
  	}
  }
  
  compose();
</script>


    <script>
        $('#optionsInbox').button({ icons: { primary: "ui-icon-gear"} })
        $('#optionsSent').button({ icons: { primary: "ui-icon-gear"} })
       // $('#cancel1').button({ icons: { primary: "ui-icon-arrowreturnthick-1-w"} })
    </script>

</html>
