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
  <script src="../report/js/chosen.jquery.js" type="text/javascript"></script>
  <link rel="stylesheet" href="../report/chosen.css">
<?php

	$messid = getQUERY("messid");
	$fromto = getQUERY("fromto");

?>
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
								
			<select id="sendto" onchange="" style="margin-right:5px; margin-left:8px; width: 235px; font-size: 11px; position: relative; top: 0px; z-index: 0; visibility: visible; background-color:white" class="combobox text2">
				              <option id="0" value="0" selected ></option>
				              
				              <?php
				                  $tousers = "select * from users where clientid=357 and id not in (" . session("user_id") . ")";
				                  $dsUsers = query($tousers);
						
								  while ($drUsers = pg_fetch_array($dsUsers)) {
				              ?>
				                          <option id="<?php echo $drUsers["id"] ?>" value="user"><?php echo $drUsers["fullname"]?></option>
				               <?php
				                  } //end while
				                  
				                  $tovehicles = "select * from vehicles where id in (select distinct vehicleid from uservehicles 
				                  where userid=(" . session("user_id") . ")) and allowgarmin='1'";
				                  $dsVehicles = query($tovehicles);
								  
				                  while ($drVehicles = pg_fetch_array($dsVehicles)) {
				              ?>
				                          <option id="<?php echo $drVehicles["id"] ?>" value="vehicle"><?php echo $drVehicles["registration"]?></option>
				               <?php
				                  } //end while   
				                 
				                ?>  
				                 
				           </select>
				           
			
		</td>
<td style="color:red; vertical-align:top">*</td>
	</tr>
	<!--<tr>
		<td width=40px style="padding-left: 15px"><strong>Subject:</strong></td>
		<td>
			<input id="subject" type="text" style="margin-top:10px; margin-right:5px; margin-left:8px;border: 1px solid #CCCCCC; height:27px; width:235px; padding-left:5px" class="text2 corner5"/>
		</td>
	</tr>-->
	<tr>
		<td colspan=2 >
			
<textarea id="body" rows="10" style="padding-left:12px; padding-top:1px; max-height: 200px; width: 280px; min-width:280px; max-width: 280px; margin-top:10px; border:1px solid #ccc;" class="corner5 text2_">

</textarea>
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
 </table>
 
  <?php
  
  closedb();
?>
</body>


<script>
	if (top.document.getElementById('img-' + '<?php echo $messid?>'))
		top.document.getElementById('img-' + '<?php echo $messid?>').src = "../images/eopen1.png";
	
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
    
	$('#sendMess').button({ icons: { primary: "ui-icon-mail-closed"} })
	
	function sendMess() {
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
				$.ajax({
			    url: "../main/SendMess.php?toid=" + toid + "&toobj=" + toobj + "&subject=" + subject + "&body=" + body,
			    context: document.body,
			    success: function (data) { 
				document.getElementById('succMess').style.display = 'block'; 
				setTimeout(function(){$("#div-showMessage").load('../main/MessageForm.php?l=' + lang)}, 2000); 
			    }
			});
		}
		
	}    
	top.HideWait();

</script>


</html>
