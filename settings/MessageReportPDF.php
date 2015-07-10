<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
?>
 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script>
		lang = '<?php echo $cLang?>'
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
	
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	<script type="text/javascript" src="reports.js"></script>
	<script type="text/javascript" src="./js/highcharts.src.js"></script>
    <script src="../js/jquery-ui.js"></script>
    
    <script>
  		if (<?php echo nnull(is_numeric(nnull(getQUERY("u"))), 0) ?> == 0){
  			if (<?php echo nnull(is_numeric(nnull(session("user_id"))), 0) ?> == 0)
  				top.window.location = "../sessionexpired/?l=" + '<?php echo $cLang ?>';
  		} 
  	</script>
  
  	
</head>

  <?php
   
  		opendb();
   
		if (nnull(is_numeric(nnull(getQUERY("u"))), 0)>0){
			$uid = getQUERY("u");
			$cid = getQUERY("c");	
		} else {
			$uid = session("user_id");
			$cid = session("client_id");
		}
		$_SESSION["user_fullname"] = dlookup("select fullname from users where id='" . $uid . "'");
		$_SESSION["company"] = dlookup("select name from clients where id in (select clientid from users where id=" . $uid . " limit 1) limit 1");
		
		$_SESSION['role_id'] = nnull(dlookup("select roleid from users where id=" . $uid), 0 );
		$roleid = session("role_id");
	
	$sqlU1 = "select id, fullname from users where clientID=" . $cid;
	
	if ($roleid == "2") {
		$sqlU = "select id from users where clientID=" . $cid;
		
	} else {
		$sqlU = "select id from users where id=" . $uid;
		
	}
    
	  $cLang = getQUERY("l");
	

	$datetimeformat = dlookup("select datetimeformat from users where id=" . $uid); 
	$datfor = explode(" ", $datetimeformat);
	$dateformat = $datfor[0];
	$timeformat =  $datfor[1];
	if ($timeformat == "H:i:s") {
		$e_ = " 23:59";
		$e1_ = "_23:59";
		$s_ = " 00:00";
		$s1_ = "_00:00";
		$tf = " H:i";
	}	else {
		$e_ = " 11:59 PM";
		$e1_ = "_11:59_PM";
		$s_ = " 12:00 AM";
		$s1_ = "_12:00_AM";
		$tf = " h:i a";
	}	 
	
	$sd = DateTimeFormat(getQUERY("sd"), $dateformat) . $s_; //'01-09-2012 00:00';
    $ed = DateTimeFormat(getQUERY("ed"), $dateformat) . $e_; //'01-09-2012 23:59';
    $sdG = DateTimeFormat(getQUERY("sd"), 'd-m-Y H:i:s');
	$edG = DateTimeFormat(getQUERY("ed"), 'd-m-Y H:i:s');
	
	$CreationDate = strtoupper(DateTimeFormat(now(), $datetimeformat));   
	
	$meseci = array("January1", "February1", "March1", "April1", "May1", "June1", "July1", "August1", "September1", "October1", "November1", "December1");     
	$idUsers = "";
	
	?>
<body style="margin:0px 0px 0px 0px; padding:0px 0px 0px 0px; overflow:auto">
  	<div id="report-content" style="width:100%; text-align:left; height:500px; background-color:#fff;" class="corner5">

  <div class="corner5" style="width:98%; border:1px solid #bbb; background-color:#fafafa; margin-left:1%">
 	 <div style="padding-left:40px; padding-top:10px; width:500px" class="textTitle">
				<?php echo mb_strtoupper(dic_("Reports.ReportFor") . '  ' . dic_("Settings.MessagesNew"), 'UTF-8') ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<br><br>
				<span class="text5"> <?php dic("Reports.User")?>: <strong><?php echo session("user_fullname")?></strong></span><br>
				<span class="text5"> <?php dic("Reports.Company")?>: <strong><?php echo session("company")?></strong></span><br>
				<span class="text5"> <?php dic("Reports.CreationDate")?>: <strong><?php echo $CreationDate?></strong></span><br>
				<span class="text5"> <?php dic("Reports.DateTimeRange")?>: <strong><?php echo $sd?></strong> - <strong><?php echo $ed?></strong></span><br><br>
	</div>
		<?php

		$sqln_ = "select * from messages where (fromid in (" . $sqlU . ") or toid in (" . $sqlU . ")) and datetime between '" . DateTimeFormat($sdG, "Y-m-d 00:00:00") . "' and '" . DateTimeFormat($edG, "Y-m-d 23:59:59") . "' order by fromid,checked";
		
		if (pg_num_rows(query($sqln_)) > 0) {
		$selected = ""	;
		if ($roleid == "12") {	
		?>
	<table width="94%" border="0" cellspacing="2" cellpadding="2" align="center" style="margin-top:-30px;">
    		<tr>
    			<td style="float: right">

    				<div class="side-by-side clearfix" style="float:right">

			           <select id = "TipNaKorisnik" class="chzn-select-no-results" tabindex="10" data-placeholder="Изберете корисник" style="font-size: 11px; position: relative; top: 0px; visibility: visible; float: right; font-family:Arial, Helvetica, sans-serif" onchange="OptionsChange()" class="combobox text2">	
				            <option id="0" value="0" selected ><?php echo dic_("all")?></option>
				            <option style="height: 1px; position: relative; top:-9px" disabled="disabled">------------------------------------------------</option>
				            <?php
	   					
	      				$dsn = query($sqlU1);
	      				$cnt = 1;
	      				while ($dr = pg_fetch_array($dsn)) {
	      					if ($dr["id"] == $uid) $selected = "selected";
							else $selected = "";
	      					?>
	      					<option <?php echo $selected?> value="<?php echo $dr["id"]?>"><?php echo $dr["fullname"]?></option>
	      				<?php
	      					$cnt ++;
	      				}

	      				?>
				       </select>

			      	</div>
					<span class="text5" style="float: right; position: relative; top: 7px; visibility: visible; right: 11px;"><strong><?php echo dic_("Reports.User")?>:</strong></span>
    			</td>
    		</tr>
    	</table>
    		
		<?php
		}
		}
		 $meseci = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		?>
		
	<?php
        $_datumCnt  = $sdG;
		
		while (DateDiffDays($edG, $_datumCnt) < 0) {
			$cnt = 1;
			?>
		<table width=97% style="padding-left:36px">
            
	        <tr>
	            <td valign="bottom" height="10px" style=" " class="text2" colspan="6">&nbsp;</td>
	        </tr> 

            <?php
            	
                $sqln_ = "select * from messages where (fromid in (" . $sqlU . ") or toid in (" . $sqlU . ")) and datetime between '" . DateTimeFormat($_datumCnt, "Y-m-d 00:00:00") . "' and '" . DateTimeFormat($_datumCnt, "Y-m-d 23:59:59") . "' order by fromid,checked";
				
          		$dsData = query($sqln_);
				if (pg_num_rows($dsData) > 0) {
				?>
			<tr >
            	<td valign="bottom" height="29px" style="color:#fff; font-size:14px; border:1px solid #ff6633; background-color:#f7962b; padding-bottom: 5px; padding-left: 10px " class="text2" colspan="6"><strong><?php echo DateTimeFormat($_datumCnt,"d") . " " . dic_("Reports." . $meseci[intval(DateTimeFormat($_datumCnt, "m")) - 1] . "") . " " . DateTimeFormat($_datumCnt,"Y")?></strong></td>
        	</tr>
        	
			<tr class="text2" style="font-weight:bold;">
	        	 <!--<td width=6% height="22px" align="center" style="background-color:#E5E3E3; border:1px dotted #2f5185;" class="text2"><strong>Р. бр.</strong></td>-->
				 <td width=5% height="22px" align="center" style="background-color:#E5E3E3; border:1px dotted #2f5185;" class="text2"><strong><?php echo dic_("Reports.Viewed")?></strong></td>
	             <td width=9% height="22px" align="center" style="background-color:#E5E3E3; border:1px dotted #2f5185;" class="text2"><strong><?php echo dic_("Reports.Vreme")?></strong></td>
	             <td width=18% height="22px" align="left" style="background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:7px" class="text2"><strong><?php echo dic_("From")?></strong></td>
	             <td width=18% height="22px" align="left" style="background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:7px" class="text2"><strong><?php echo dic_("To")?></strong></td>
	             <td width=40% height="22px" align="left" style="background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:7px" class="text2"><strong><?php echo dic_("Message")?></strong></td>
	 		</tr>
				<?php		
				
				while ($drData = pg_fetch_array($dsData)) {              
					
					if($drData["checked"] == "1") {
						$viewed = "../images/messageread.png";
						$style = "style='position:relative; left:-2px'";
					}
					else {
						$viewed = "../images/messageunread.png";
						$style = "style='height:14px'";
					}
					$from = dlookup("select fullname from users where id=" . $drData["fromid"]);
					if ($drData["toobject"] == 'user') {
			  			$to = dlookup("select fullname from users where id=" . $drData["toid"]);
			  		} else {
			  			$to = dlookup("select registration from vehicles where id=" . $drData["toid"]);
			  		}
					
					
                    ?>
                    
             <tr class="<?php echo $drData["userid"]?>" height=22px>
             	<!--<td align="center" style="background-color:#fff; border:1px dotted #B8B8B8;" class="text2" ><?php echo $cnt ?></td>-->
             	<td align="center" style="background-color:#fff; border:1px dotted #B8B8B8;" class="text2" ><img src=<?php echo $viewed ?> <?php echo $style?>/></td>
             	<td align="center" style="background-color:#fff; border:1px dotted #B8B8B8;" class="text2" ><?php echo DateTimeFormat($drData["datetime"], $timeformat) ?></td>
                <td align="left" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px;" class="text2" ><?php echo $from?></td>
                <td align="left" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px" class="text2"><?php echo $to?></td>
                <td align="left" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px" class="text2"><?php echo $drData["body"]?></td>
                
       </tr>
                    <?php
                    $cnt ++;
                    } //end while
                    
                    } else {
                    	?>
                    	
                    	<tr>
                    		<td valign="bottom" height="31px" style="color:#fff; font-size:14px; border:1px solid #ff6633; background-color:#f7962b;padding-bottom: 6px; padding-left: 10px " class="text2" colspan=6><strong><?php echo DateTimeFormat($_datumCnt,"d") . " " . dic_("Reports." . $meseci[intval(DateTimeFormat($_datumCnt, "m")) - 1] . "") . " " . DateTimeFormat($_datumCnt,"Y")?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="text2" style="font-style:italic; color:#153B75; font-size:12px"><?php echo dic_("Reports.NoDataDay")?></span></strong></td>
                    	</tr>
                    	<?php
                    }

             ?>

          </table>
			
			<?php
			$_datumCnt = addToDate($_datumCnt, 1, "days");	
		}
         
 			closedb();        
          ?>
          <br /><br />
          </div><br>
        <div id="footer-rights-new" class="textFooter" style="padding:10px 10px 10px 10px">
			<?php echo $CopyrightString ?>&nbsp;|&nbsp;<?php echo session("company")?>&nbsp;|&nbsp;<?php echo session("user_fullname")?>&nbsp;|&nbsp;<?php echo $CreationDate?>&nbsp;|&nbsp;<?php dic("Reports.From")?>: <?php echo $sd?>&nbsp;-&nbsp;<?php dic("Reports.To")?>: <?php echo $ed?>
		</div><br>   
	
	</div>
<div id="kalendarM" style="display: none; width: 625px; height: 168px; background-color: White; position: absolute;" class="shadow">
	<iframe id="ifrmkal" src="timeframe.php?l=<?php echo $cLang?>" style="width:100%; border: 0px; height: 100%" scrolling="no"></iframe>
</div>

    </body>
</html>

<script>
	//SetHeightLite()
	iPadSettingsLite()
	top.HideLoading()
	if (Browser()=='iPad') {top.iPad_Refresh()}
		
	 var config = {
      '.chzn-select'           : {},
      '.chzn-select-deselect'  : {allow_single_deselect:true},
      '.chzn-select-no-single' : {disable_search_threshold:10},
      '.chzn-select-no-results': {no_results_text:'<?php echo dic_("Reports.UserNotFound")?>'},
      '.chzn-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
	function OptionsChange(){
		var _id = $("#TipNaKorisnik").find('option:selected').val();
		if(_id == "0")
		{
			for(var i=0;i<idUsers.split(",").length-1;i++)
				$("." + idUsers.split(",")[i]).show();
		} else
		{
			for(var i=0;i<idUsers.split(",").length-1;i++)
				if(idUsers.split(",")[i] != _id)
					$("." + idUsers.split(",")[i]).hide();
				else
					$("." + idUsers.split(",")[i]).show();
		}
	}

	var idUsers = '<?php echo $idUsers?>';
		
	
	$(document).ready(function () {
  	 	top.HideWait();
    	OptionsChange();
    	top.$('#vremence').css({ display: 'block' });
	});
	function opencal(e)
	{
		
		//$('#kalendarM').css({ top: (e.clientY + 15) + 'px', left: (e.clientX - parseInt($('#kalendarM').css('width'), 10)) + 'px'});
		if($('#kalendarM').css('display') == 'none')
			$('#kalendarM').css({display:'block'});
		else
			$('#kalendarM').css({display:'none'});
		document.getElementById("txtNewDate").blur();
	}
</script>
