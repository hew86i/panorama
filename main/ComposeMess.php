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

	<script>
			lang = '<?php echo $cLang?>'
	</script>
  
<?php

	$messid = getQUERY("messid");
	$fromto = getQUERY("fromto");

	$tpoint = getQUERY("tpoint");
	
	if($tpoint == '.')
	{
		?>
		<script src="./report/js/chosen.jquery.js" type="text/javascript"></script>
  		<link rel="stylesheet" href="./report/chosen.css">
  		<?php
	} else {
		?>
		<script src="../report/js/chosen.jquery.js" type="text/javascript"></script>
  		<link rel="stylesheet" href="../report/chosen.css">
  		<?php
	}
?>

</head>

 <body>
 
  <?php
  opendb();
  
  
  ?>
 
 <table class="text2_" width=75% style="margin:35px" align="center">
 	<tr><td colspan=3 style="font-size:16px; font-weight: bold; text-align: center"><?php echo dic_("Reports.ComposeMess")?></td></tr>
 	<tr style="height:40px;">
	     <td colspan=3><div style="border-bottom:1px solid #bebebe; width:93%; margin-left:8px"></div></td>
	</tr>
           <tr><td height=15px></td></tr>
	<tr>
		<td width=40px style="padding-left: 15px"><strong><?php echo dic_("Reports.To")?>:</strong></td>
		<td>
								
			<select onclick="changeArea('sendto', 1)" onblur="changeArea('sendto', 0)" id="sendto" data-placeholder="" onchange="ShowHideDirect()" style="margin-right:5px; margin-left:8px; width: 235px; font-size: 11px; position: relative; top: 0px; z-index: 0; visibility: visible; background-color:white" class="combobox text2">
	              <option id="0" value="0" selected ></option>
	              
	              <?php
	                  $tousers = "select * from users where clientid=" . session("client_id") . " and id not in (" . session("user_id") . ")";
	                  $dsUsers = query($tousers);
			
					  while ($drUsers = pg_fetch_array($dsUsers)) {
	              ?>
	                          <option id="<?php echo $drUsers["id"] ?>" value="colleague"><?php echo $drUsers["fullname"]?></option>
	               <?php
	                  } //end while
	                  if ($_SESSION['role_id'] == "2") {
		                  $tovehicles = "select * from vehicles where clientid = " . session("client_id") . " and allowgarmin='1'";
					  } else {
					  	  $tovehicles = "select * from vehicles where id in (select distinct vehicleid from uservehicles 
					  	  where userid=(" . session("user_id") . ")) and allowgarmin='1'";
					  }
	                  $dsVehicles = query($tovehicles);
					  
	                  while ($drVehicles = pg_fetch_array($dsVehicles)) {
	              ?>
	                          <option id="<?php echo $drVehicles["gsmnumber"] ?>" value="vehicle"><?php echo $drVehicles["registration"]?> (<?= $drVehicles["code"]?>)</option>
	               <?php
	                  } //end while   
	                 
	                ?>  
	                 
	           </select>
				           
			
		</td>
		<td style="color:red; vertical-align:top">*</td>
	</tr>
	<tr>
		<td width=40px style="padding-left: 15px"><input id="direktno" style="visibility: hidden;" type="checkbox" class="text2 corner5 showhidedir"/></td>
		<td>
			<strong class="showhidedir" style="margin-left: 9px; visibility: hidden;">Директно на екран:</strong>			
		</td>
	</tr>
	<tr>
		<td colspan=2 >
			
<textarea id="body" type="text" maxlength="200" data-CountElem="InputCharCount2" rows="10" style="padding: 10px; max-height: 200px; width: 280px; min-width:280px; max-width: 280px; margin-top:10px; border:1px solid #ccc;" class="corner5 text2_"></textarea>
<div id="textarea_feedback"></div

		</td>
<td style="color:red; vertical-align:top; padding-top:10px">*</td>
	</tr>


	<tr>
		<td colspan=3 width=290px>
			<button id="sendMess" onClick="sendMess()" style="width:73px; height:27px;margin-top:15px; margin-right:5px; position: relative; float: right" title='Compose'><?php echo dic_("send")?></button>
		</td>
	</tr>
	
	<tr>
		<td colspan=3>
			<div id="succMess" class="text2_" style="display:none; padding-right:5px; text-align:right; font-size:11px; margin:0 auto; color:#2F5185; font-style:italic; padding-top:10px; padding-left:20px"><?php echo dic_("Reports.SuccMess")?> !</div>
		</td>
	</tr>
	<tr>
		<td colspan=3>
			<div id="errMess" class="text2_" style="display:none; padding-right:5px; text-align:right; font-size:11px; margin:0 auto; color:#2F5185; font-style:italic; padding-top:10px; padding-left:20px"></div>
		</td>
	</tr>
 </table>
 
  <?php
  
  closedb();
?>
</body>



<script>
	$(document).ready(function () {
		var text_max = 200;
	    $('#textarea_feedback').html(text_max + ' characters remaining');
	    $('#body').keyup(function() {
	    	$('#body').val(transliterate($('#body').val()));
	    });
	    $('#body').keydown(function() {
	    	$('#body').val(transliterate($('#body').val()));
	        var text_length = $('#body').val().length;
	        var text_remaining = text_max - text_length;
	
	        $('#textarea_feedback').html(text_remaining + ' characters remaining');
	    });
	});
	function transliterate(word){
	    var answer = ""
	      , a = {};
	
	   a["Љ"]="Lj";a["Њ"]="Nj";a["Ц"]="C";a["У"]="U";a["К"]="K";a["Е"]="E";a["Н"]="N";a["Г"]="G";a["Ш"]="S";a["Щ"]="SCH";a["З"]="Z";a["Х"]="H";a["Ъ"]="'";
	   a["љ"]="lj";a["њ"]="nj";a["ц"]="c";a["у"]="u";a["к"]="k";a["е"]="e";a["н"]="n";a["г"]="g";a["ш"]="s";a["щ"]="sch";a["з"]="z";a["х"]="h";a["ъ"]="'";
	   a["Ф"]="F";a["Ы"]="I";a["В"]="V";a["А"]="a";a["П"]="P";a["Р"]="R";a["О"]="O";a["Л"]="L";a["Д"]="D";a["Ж"]="Z";a["Ѓ"]="Gj";
	   a["ф"]="f";a["ы"]="i";a["в"]="v";a["а"]="a";a["п"]="p";a["р"]="r";a["о"]="o";a["л"]="l";a["д"]="d";a["ж"]="z";a["ѓ"]="gj";
	   a["S"]="Dz";a["Ч"]="CH";a["С"]="S";a["М"]="M";a["И"]="I";a["Т"]="T";a["Ь"]="'";a["Б"]="B";a["Џ"]="Dj";
	   a["ѕ"]="dz";a["ч"]="ch";a["с"]="s";a["м"]="m";a["и"]="i";a["т"]="t";a["ь"]="'";a["б"]="b";a["џ"]="dj";
	
	   for (i in word){
	     if (word.hasOwnProperty(i)) {
	       if (a[word[i]] === undefined){
	         answer += word[i];
	       } else {
	         answer += a[word[i]];
	       }
	     }
	   }
	   return answer;
	}
	
	function ShowHideDirect() {
		if($("#sendto").find('option:selected').val() == 'vehicle')
			$('.showhidedir').css({visibility: 'visible'});
		else
			$('.showhidedir').css({visibility: 'hidden'});
	}
	
	function changeArea(id, i) {
		/*if (i == 1)
			$('#' + id).css({border:'2px solid #2F5185'});
		else
			$('#' + id).css({border:'1px solid #CCCCCC'});*/
	}
	var tpoint = '<?php echo $tpoint?>';
	
	$('#sendMess').button({ icons: { primary: "ui-icon-mail-closed"} })
	
	if (top.document.getElementById('img-' + '<?php echo $messid?>'))
		top.document.getElementById('img-' + '<?php echo $messid?>').src = tpoint + "/images/eopen1.png";
	
	 var config = {
      '.chzn-select'           : {},
      '.chzn-select-deselect'  : {allow_single_deselect:true},
      '.chzn-select-no-single' : {disable_search_threshold:10},
      '.chzn-select-no-results': {no_results_text:'Not found'},
      '.chzn-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
    
	
	
	function sendMess() {
		ShowWait();
		if($("#sendto").find('option:selected').attr("id") == 0) {
			alert(dic("Reports.NotReceiver") + " !!!");
			$('#sendto').css({border:'1px solid red'});
		} else {
			$('#sendto').css({border:'1px solid #cccccc'});
		}

		if(document.getElementById("body").value == "\n") {
			alert(dic("Reports.NotMessage") + " !!!");
			$('#body').css({border:'1px solid red'});
		} else {
			$('#body').css({border:'1px solid #cccccc'});
		}
		
		if($("#sendto").find('option:selected').attr("id") != 0 && document.getElementById("body").value != '\n') {
			var toobj = $("#sendto").find('option:selected').val();
			var toid = $("#sendto").find('option:selected').attr("id");
			var subject = '';//document.getElementById("subject").value;
			var body = document.getElementById("body").value;
			if(toobj == "vehicle") {
				if(ws != null) {
					$.ajax({
		        		url: tpoint + "/main/SendMess.php?action=user&toid=" + toid + "&toobj=" + toobj + "&subject=" + subject + "&body=" + kescape(body),
					    context: document.body,
					    success: function (data) {
						 	ws.send('garminruptela', toid + '$*^' + body.replace(/\n/g, '') + '$*^' + data.replace(/\r/g, '').replace(/\n/g, '') + '$*^' + ($("#direktno").attr('checked') ? '1' : '0'));
				    	}
					});
				}
			} else {
				$.ajax({
	        		url: tpoint + "/main/SendMess.php?action=user&toid=" + toid + "&toobj=" + toobj + "&subject=" + subject + "&body=" + kescape(body),
				    context: document.body,
				    success: function (data) { 
						document.getElementById('succMess').style.display = 'block'; 
						setTimeout(function(){$("#div-showMessage").load(tpoint + '/main/MessageForm.php?l=' + lang + '&tpoint=' + tpoint)}, 2000); 
			    	}
				});
			}
		}
		
	}    
	top.HideWait();

</script>


</html>
