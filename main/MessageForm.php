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
      $tpoint = getQUERY("tpoint");
   ?>


             		
<table width=600px height=460px style="margin:10px">
	<tr>
		<td width=35% style="border-right:1px dotted #bebebe;" valign="top">
			<table width=100%>
				<tr>
					<td>
<button title="Compose" style="font-size:11px; width:85px; height:27px;margin-top:10px; margin-right:10px; position: relative; float: right" onclick="compose()" id="addMess" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon-primary" role="button" aria-disabled="false"><span class="ui-button-icon-primary ui-icon ui-icon-pencil"></span><span class="ui-button-text"><?php echo dic_("reports.Compose")?></span></button>

						
					</td>
				</tr>
				<tr>	
					<td>
						<input onkeyup="searchMess(this)" type="text" style="font-size:11px; margin-top:10px; margin-right:5px; margin-left:10px; background: url('<?php echo $tpoint?>/images/chosen-sprite.png') no-repeat 100% -20px; border: 1px solid #CCCCCC; height:27px; width:238px; padding-left:5px" class="text2_ corner5"/>
					</td>
					
				</tr>
				
                 
                 <tr style="height:10px;">
                    <td></td>
              </tr>
             
                <?php
				$totalInbox = dlookup("select count(*) from messages where clientid=" . session("client_id") . " and toid=" . session("user_id"));
				$totalUnreadInbox = dlookup("select count(*) from messages where  clientid=" . session("client_id") . " and checked='0' and toid=" . session("user_id"));
				?>
  
                <tr><td> 
<div style="height: 175px; width: 250px; margin-top: 5px; overflow-x:hidden;overflow-y:auto;">

            	<table id="incomingmessages" width=100%>
            		<thead style="position: fixed; margin-top: -7px; z-index: 1"><tr><td><div id="countincomingmess" style="width:238px; height:20px; font-size:14px; border:1px solid #CCCCCC; margin-left:5px; margin-right:0px" class="textSubTitle subtitle corner5">&nbsp;<?php echo dic_("Reports.Inbox")?> [<span id="spanUnread"><?php echo $totalUnreadInbox?></span>/<?php echo $totalInbox?>]</div></td></tr></thead>
            		<tbody style="position: relative; display: block; margin-top: 25px;">
                 <?php
                $messinbox = "select * from messages where toid=" . session("user_id") . " and  clientid=" . session("client_id") . " order by checked asc, datetime desc";

				$dsMessInbox = query($messinbox);   
				$c = 0;
			    while ($drMessInbox = pg_fetch_array($dsMessInbox)) {
				  ?>
				  <tr id="inbox-tr-<?php echo $c?>"><td>
				  	<table class="text2_ garminmessclick" onclick="rowclickgarmin(this)" style="margin-left: 5px; width: 237px">
				  	
				  		<?php
				  			if($drMessInbox["toobject"] == 'colleague') {
				  				$from = dlookup("select fullname from users where id=" . $drMessInbox["fromid"]);
				  			} else {
				  				$from = dlookup("select registration from vehicles where id=" . $drMessInbox["fromid"]);
							}
				  		?>
						<?php
						$img = $tpoint . "/images/messageunread.png";
						$size = "width=14px height=14px";
						if ($drMessInbox["checked"] == 1) {
							$img = $tpoint . "/images/messageread.png";
							$size = "width=12px height=12px";
						}	
						$color = "color:#8c8c8c";
						if ($drMessInbox["checked"] == 0) $color = "color:blue";
						
						?>
				  		<tr style="cursor:pointer" onclick="loadMess(<?= $drMessInbox["id"]?>, 'inbox', '<?= $drMessInbox["toobject"]?>')">
				  			<td style="color: #8c8c8c"><?=$totalInbox?></td>
				  			<td>
				  				<table class="text2_" width=100% id="table-<?php echo $drMessInbox["id"]?>" style="<?php echo $color?>">
				  					<tr >
										<td width=5% valign="top">
											<img id="img-<?php echo $drMessInbox["id"]?>" <?php echo $size?> src="<?php echo $img?>" style="">
										</td>
							  			<td width=65% ><strong id="inbox-name-<?php echo $c?>"><?php echo $from?></strong></td>
							  			<td width=35% id="inbox-datetime-<?php echo $c?>"><?php echo DateTimeFormat($drMessInbox["datetime"], $dateformat)?></td>
							  		</tr>
							  		<!--<tr><td colspan=3 id="inbox-subject-<?php echo $c?>"><?php echo $drMessInbox["subject"]?></td></tr>-->
							  		<tr><td colspan=3 style="font-style:italic" id="inbox-body-<?php echo $c?>"><?php echo substr($drMessInbox["body"], 0, 70)?> ...</td></tr>
				  				</table>
				  			</td>
				  		</tr>
				  	</table>
				  </td></tr>
				  
				 <tr id="inbox-trr-<?php echo $c?>" style="height:1px;">
                    <td><div style="border-bottom:1px dotted #bebebe; width:93%; margin-left:8px"></div></td>
              </tr>
				  <?php			
				  $c ++;
				  $totalInbox--;
				}   
if (pg_num_rows($dsMessInbox) == 0) {
	?>
	 <tr style="height:10px;">
          <td><div class="text2_" style="margin-left:8px">- <?php echo dic_("Reports.Empty")?> -</div></td>
     </tr>
	<?php
}      
                ?>
                </tbody>
                </table>
                </div>
                </td>
                </tr> 
				<?php
				$totalSent = dlookup("select count(*) from messages where  clientid=" . session("client_id") . " and fromid=" . session("user_id"));
				?>
                  
            <tr><td> 
<div style="height:175px;width:250px; margin-top: 10px; overflow-x:hidden;overflow-y:auto;">

            	<table id="outgoingmessages" width=100%>
            		<thead style="position: fixed; margin-top: -7px; z-index: 1"><tr><td><div style="width:238px; height:20px; font-size:14px; border:1px solid #CCCCCC; margin-left:5px; margin-right:0px; margin-top:2px" class="textSubTitle subtitle corner5">&nbsp;<?php echo dic_("Reports.Sentbox")?> [<?php echo $totalSent?>]</div></td></tr></thead>
            		<tbody style="position: relative; display: block; margin-top: 25px;">
                 <?php
                $messinbox = "select * from messages where  clientid=" . session("client_id") . " and fromid=" . session("user_id") . " order by datetime desc";   
				$dsMessInbox = query($messinbox);   
				$cc = 0;
			    while ($drMessInbox = pg_fetch_array($dsMessInbox)) {
			    	if($drMessInbox["flag"] == "0")
					{
						$opac = '0.5';
						$img = 'nosignal.png';
						$imgwidth = '13';
						$imgheight = '13';
					} else {
						$opac = '1';
						$img = 'messagesent.png';
						$imgwidth = '17';
						$imgheight = '11';
					}
					
				  ?>
				  <tr id="sent-tr-<?php echo $cc?>"><td>
				  	<table id="tbl-<?php echo $drMessInbox["garminid"]?>" class="text2_ garminmessclick" onclick="rowclickgarmin(this)" style="margin-left: 5px; width: 237px; opacity: <?=$opac?>">
				  	
				  		<?php
				  		if ($drMessInbox["toobject"] == 'user' || $drMessInbox["toobject"] == 'colleague') {
				  			$to = dlookup("select fullname from users where id=" . $drMessInbox["toid"]);
				  		} else {
				  			$to = dlookup("select registration from vehicles where id=" . $drMessInbox["toid"]);
				  		}
				  		
				  		?>
				  		<tr style="cursor:pointer;" onclick="loadMess(<?php echo $drMessInbox["id"]?>, 'sentbox', '<?= $drMessInbox["toobject"]?>')" >
				  			<td style="color: #8c8c8c"><?=$totalSent?></td>
				  			<td>
				  				<table class="text2_" width=100%>
				  					<tr style="color:#8c8c8c;">
										<td width=5% valign="top">
											<img id="img-<?php echo $drMessInbox["garminid"]?>" width="<?=$imgwidth?>px" height="<?=$imgheight?>px" src="<?php echo $tpoint?>/images/<?=$img?>" style="">
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
				  
				<tr id="sent-trr-<?php echo $cc?>" style="height:1px;">
                    <td><div style="border-bottom:1px dotted #bebebe; width:93%; margin-left:8px"></div></td>
              	</tr>
				  <?php		
				  $cc ++;
				  $totalSent--;
				}       

			if (pg_num_rows($dsMessInbox) == 0) {
				?>
				 <tr style="height:10px;">
			          <td><div class="text2_" style="margin-left:8px">- <?php echo dic_("Reports.Empty")?> -</div></td>
			     </tr>
				<?php
			}   
                ?> 
                </tbody>
                </table>
                </div>
               </tr></td> 
                
			</table>
		</td>
		<td width=65% valign="top" align="center" ">
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
	
	function rowclickgarmin(obj) {
		$(".garminmessclick").removeClass("selectedgarmin");
	    $(obj).addClass("selectedgarmin");
	}
	
	var tpoint = '<?php echo $tpoint?>';

	function loadMess(messid, fromto, toobject) {
		//document.getElementById("messcontent").innerHTML = "<div style='padding-top:250px'><img src='../images/ajax-loader.gif' border='0' align='absmiddle' width='31' height='31' />&nbsp;<span class='text1' style='color:#5C8CB9; font-weight:bold; font-size:11px'>Loading message...</span></div>"
		ShowWait();
		$("#messcontent").load(tpoint+'/main/LoadMess.php?messid=' + messid + '&toobject=' + toobject + '&fromto=' + fromto + '&l=' + lang + '&tpoint=' + tpoint, function(){
			HideWait();
		});
	}
  
	function compose(messid, fromto) {
  		ShowWait();
  	 	$("#messcontent").load(tpoint+'/main/ComposeMess.php?l=' + lang + '&tpoint=' + tpoint, function(){
  	 		HideWait();
  	 	});
	}
  
  function searchMess(term) {
  	var suche = term.value.toLowerCase();
  	for (var i=0; i< <?php echo $c?>; i++) {
  		if (document.getElementById("inbox-name-" + i).innerHTML.toLowerCase().indexOf(suche) >= 0 || 
  		document.getElementById("inbox-datetime-" + i).innerHTML.toLowerCase().indexOf(suche) >= 0 ||
  		document.getElementById("inbox-body-" + i).innerHTML.toLowerCase().indexOf(suche) >= 0)
	        {
	        document.getElementById("inbox-trr-" + i).style.display = '';	
			document.getElementById("inbox-tr-" + i).style.display = '';
        } else  {
        	document.getElementById("inbox-trr-" + i).style.display = 'none';
        	document.getElementById("inbox-tr-" + i).style.display = 'none';
        }
  	}
  	
  	for (var i=0; i< <?php echo $cc?>; i++) {
  		if (document.getElementById("sent-name-" + i).innerHTML.toLowerCase().indexOf(suche) >= 0 || 
  		document.getElementById("sent-datetime-" + i).innerHTML.toLowerCase().indexOf(suche) >= 0 ||
  		document.getElementById("sent-body-" + i).innerHTML.toLowerCase().indexOf(suche) >= 0) {
	        document.getElementById("sent-trr-" + i).style.display = '';
	        document.getElementById("sent-tr-" + i).style.display = '';
        } else {
        	document.getElementById("sent-trr-" + i).style.display = 'none';
        	document.getElementById("sent-tr-" + i).style.display = 'none';
        }
  	}
  }
  
  compose();
</script>


    <script>
        //$('#addMess').button({ icons: { primary: "ui-icon-pencil"} })
       // $('#cancel1').button({ icons: { primary: "ui-icon-arrowreturnthick-1-w"} })
    </script>

</html>
