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
	<script type="text/javascript" src="../fm/fm.js"></script>
    <script type="text/javascript" src="reports.js"></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
    <script src="js/chosen.jquery.js" type="text/javascript"></script>
    <link rel="stylesheet" href="chosen.css">
    <style type="text/css" media="all">
	    /* fix rtl for demo */
	    .chzn-rtl .chzn-search { left: -9000px; }
	    .chzn-rtl .chzn-drop { left: -9000px; }
    </style>
    <link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="../js/jquery-ui.js"></script>

 <body style="margin:0px 0px 0px 0px; padding:0px 0px 0px 0px" onResize="SetHeightLite()">
 	<div id="div-add-email" style="display:none" title="<?php dic("Reports.SendReport")?>"></div>
  	 <script>
  	 	if (!<?php echo is_numeric(session('user_id')) ?>)
  			top.window.location = "../sessionexpired/?l=" + '<?php echo $cLang ?>';
 	 </script>
 	 
  <?php
   /*function Reverse_Array($array) {
   	    $index = 0; 
	    foreach ($array as $subarray) 
	    {    if (is_array($subarray)) 
	        {    $subarray = array_reverse($subarray); 
	            $arr = Reverse_Array($subarray); 
	            $array[$index] = $arr; 
	        } 
	        else {$array[$index] = $subarray;} 
	        $index++; 
	    } 
	    return $array; 
	} */

   if (nnull(is_numeric(nnull(getQUERY("uid"))), 0)>0){
		$uid = getQUERY("uid");
		$cid = getQUERY("cid");	
	} else {
		$uid = session("user_id");
		$cid = session("client_id");
	}
	
    
	  $cLang = getQUERY("l");
	  opendb();
	 
	$cntAllowFuel = dlookup("select count(*) from vehicles where clientid=" . session("client_id") . " and allowFuel=B'1'");
	$liqunit1 = dlookup("select liquidunit from users where id=" . $uid);
	if ($liqunit1 == 'galon') {
		$liqvalue = 0.264172;
		$liqunit = "gal";
	}
	else {
		$liqvalue = 1;
		$liqunit = "lit";
	}
	$metric = dlookup("select metric from users where id=" . $uid);
	if ($metric == 'mi') $metricvalue = 0.621371;
	else $metricvalue = 1;
	
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
		//permissions
	$noPermSch = "";
	$noPermEmail = "";
	$noPermPdf = "";
	$noPermExc = "";
	
	//scheduler
	$prSch = 0;//getPriv("exportexcel", $uid);
	if ($prSch == true) {
		$schStyle = "style='float:right; cursor:pointer'";
		$schClick = "AddScheduler(6, $uid)";
	} else {
		$schStyle = "style='float:right; opacity:0.5; cursor:default'";
		$schClick = "";
		$noPermSch = dic_("Reports.NoPermiss") . " "; 
	}
	//email
	$prEmail = getPriv("sendmail", $uid);
	if ($prEmail == true) {
		$emailClick = "AddEmail(6, '$uid', 'Distance travelled', '$cLang')";
		$emailStyle = "style='float:right; cursor:pointer'";
	}else {
		$emailClick = "";
		$emailStyle = "style='float:right; opacity:0.5; cursor:default'";
		$noPermEmail = dic_("Reports.NoPermiss") . " "; 
	}
	
	//pdf
	$prPdf = getPriv("exportpdf", $uid);
	if ($prPdf == true) {
		$pdfClick = "createPDF('AnalDistance')";
		$pdfStyle = "style='float:right; cursor:pointer'";
	}else {
		$pdfClick = "";
		$pdfStyle = "style='float:right; opacity:0.5; cursor:default'";
		$noPermPdf = dic_("Reports.NoPermiss") . " "; 
	}
	//excel
	$prExcel = getPriv("exportpdf", $uid);
	if ($prExcel == true) {
		$excHref = //"href='./AnalDistance1.php?l=$cLang&u=$user_id&c=$client_id&vn=$vn&vh=$vh&sd=$sdG&ed=$edG' ";
		$excStyle = "style='float:right; cursor:pointer'";
	}else {
		$excHref = "";
		$excStyle = "style='float:right; opacity:0.5; cursor:default'";
		$noPermExc = dic_("Reports.NoPermiss") . " "; 
	}

	$meseci = array("January1", "February1", "March1", "April1", "May1", "June1", "July1", "August1", "September1", "October1", "November1", "December1");     
	$idUsers = "";
	
	?>
	
  <div id="report-content" style="width:100%; text-align:left; height:500px; background-color:#fff; overflow-y:auto; overflow-x:hidden" class="corner5">
  	<!--<div id="icons" style="position: relative; right:8px">
        	<<div onclick="<?php echo $schClick?>" <?php echo $schStyle?> >
	            <span id="iconSCH"><img id="imgSch" src="../images/sch.png" width="16" height="16" align="absmiddle" title="<?php echo $noPermSch . "" . dic_("Reports.AddScheduler")?>">&nbsp;</span> 
	        </div>

	        <div onclick="AddEmail(13, '<?php echo $uid?>', 'fmOverview', '<?php echo $cLang?>')" <?php echo $emailStyle?>>
	            <span id="iconEMAIL" ><img id="imgEmail" src="../images/eEmail.png" width="16" height="16" align="absmiddle" title="<?php echo $noPermEmail . "" . dic_("Reports.SendToMail")?>">&nbsp;</span>
	       </div>
	       
	        <div onclick="createPDF('fmOverview')" style="float:right">
			    <span id="iconPDF" style="cursor:pointer;" ><img id="imgPdf" src="../images/epdf.png" width="16" height="16" align="absmiddle" title="<?php dic("Reports.ExportPDF")?>">&nbsp;</span>
			</div>
						
	     
	        <div onclick="createXls('fmOverview', 'a')" <?php echo $excStyle?>>
			    <span id="iconCSV" ><img id="imgXls" src="../images/eExcel.png" width="16" height="16" align="absmiddle" title="<?php echo $noPermExc . "" . dic_("Reports.ExportExcel")?>">&nbsp;</span>
		    </div>
	</div>-->
  <br>
  <div class="corner5" style="width:98%; border:1px solid #bbb; background-color:#fafafa; margin-left:1%">
 	 <div style="padding-left:40px; padding-top:10px; width:500px" class="textTitle">
				<?php echo mb_strtoupper(dic_("Reports.Log"), 'UTF-8') ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<div style="font-size:18px" class="textTitle"><?php dic("Reports.AllVehicles")?><br><br></div>
				<span class="text5"> <?php dic("Reports.User")?>: <strong><?php echo session("user_fullname")?></strong></span><br>
				<span class="text5"> <?php dic("Reports.Company")?>: <strong><?php echo session("company")?></strong></span><br>
				<span class="text5"> <?php dic("Reports.CreationDate")?>: <strong><?php echo $CreationDate?></strong></span><br>
				<span class="text5"> <?php dic("Reports.DateTimeRange")?>: <strong><?php echo $sd?></strong> - <strong><?php echo $ed?></strong></span><br><br>
	</div>
		<?php
		
		$sqln_ = "select fullname, id from users where id in (select distinct userid from userlog where 
		datetime between '" . DateTimeFormat($sdG, "Y-m-d 00:00:00") . "' and '" . DateTimeFormat($edG, "Y-m-d 23:59:59") . "' and 
		userid in (select id from users where clientid=" . $cid . ") )";
		
		if (pg_num_rows(query($sqln_)) > 0) {
		$selected = ""	;
						
		?>
	<table width="94%" border="0" cellspacing="2" cellpadding="2" align="center" style="margin-top:-30px;">
    		<tr>
    			<td style="float: right">

    				<div class="side-by-side clearfix" style="float:right">

			           <select id = "TipNaKorisnik" class="chzn-select-no-results" tabindex="10" data-placeholder="Изберете корисник" style="font-size: 11px; position: relative; top: 0px; visibility: visible; float: right; font-family:Arial, Helvetica, sans-serif" onchange="OptionsChange()" class="combobox text2">	
				            <option id="0" value="0" selected ><?php echo dic_("all")?></option>
				            <option style="height: 1px; position: relative; top:-9px" disabled="disabled">------------------------------------------------</option>
				            <?php
	   					
	      				$dsn = query($sqln_);
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
			      
			      
    			<!--	<select id = "TipNaKorisnik" style="font-size: 11px; position: relative; top: 0px ;visibility: visible; float: right;" onchange="OptionsChange()" class="combobox text2">
    					<option value="0" selected>Сите</option>
	      				<option disabled="disabled">--------------------------------------------</option>
	   					<?php
	   					
	      				$dsn = query($sqln_);
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
		     		<span class="text5" style="float: right; position: relative; top: 7px; visibility: visible; right: 11px;"><strong>Корисник:</strong></span>
    			-->
<span class="text5" style="float: right; position: relative; top: 7px; visibility: visible; right: 11px;"><strong><?php echo dic_("Reports.User")?>:</strong></span>
    			</td>
    		</tr>
    	</table>
    		
		<?php
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
            	
                $sql_ = "select datetime, userid, gettreeevent(eventtypeid, '', '') activity, description, ipaddress, notes 
				from userlog where userid in (select id from users where clientid=" . $cid . ") and datetime 
				between '" . DateTimeFormat($_datumCnt, "Y-m-d 00:00:00") . "' and 
				'" . DateTimeFormat($_datumCnt, "Y-m-d 23:59:59") . "' order by userid asc, datetime asc";
				
          		$dsData = query($sql_);
				if (pg_num_rows($dsData) > 0) {
				?>
			<tr >
            	<td valign="bottom" height="29px" style="color:#fff; font-size:14px; border:1px solid #ff6633; background-color:#f7962b; padding-bottom: 5px; padding-left: 10px " class="text2" colspan="6"><strong><?php echo DateTimeFormat($_datumCnt,"d") . " " . dic_("Reports." . $meseci[intval(DateTimeFormat($_datumCnt, "m")) - 1] . "") . " " . DateTimeFormat($_datumCnt,"Y")?></strong></td>
        	</tr>
        	
			<tr class="text2" style="font-weight:bold;">
	        	 <!--<td width=6% height="22px" align="center" style="background-color:#E5E3E3; border:1px dotted #2f5185;" class="text2"><strong>Р. бр.</strong></td>-->
	             <td width=7% height="22px" align="center" style="background-color:#E5E3E3; border:1px dotted #2f5185;" class="text2"><strong><?php echo dic_("Reports.Vreme")?></strong></td>
	             <td width=12% height="22px" align="left" style="background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:7px" class="text2"><strong><?php echo dic_("Reports.User")?></strong></td>
	             <td width=23% height="22px" align="left" style="background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:7px" class="text2"><strong><?php echo dic_("Settings.Action")?></strong></td>
	             <td width=23% height="22px" align="left" style="background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:7px" class="text2"><strong><?php echo dic_("Reports.Description")?></strong></td>
	             <td width=9% height="22px" align="center" style="background-color:#E5E3E3; border:1px dotted #2f5185;" class="text2"><strong><?php echo dic_("Reports.IPaddress")?></strong></td>
	             <td width=26% height="22px" align="left" style="background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:7px" class="text2"><strong><?php echo dic_("Reports.Browser")?></strong></td>
	 		</tr>
				<?php		
				
				while ($drData = pg_fetch_array($dsData)) {              
					
					$tmpIDA = explode(",", $idUsers);
				    $ifNE = true;
				    for($ch=0; $ch < sizeof($tmpIDA); $ch++)
				  	if($drData["userid"] == $tmpIDA[$ch])
					{
						$ifNE = false;
						break;
					}
				    if($ifNE)
					  $idUsers .= $drData["userid"] . ",";
				
					$LastDay = DatetimeFormat(addDay(-1), 'd-m-Y'); 
				    $dt = DateTimeFormat(nnull($LastDay, "01-01-1900"), "Y-m-d". " 00:00:00");
	
					$user = dlookup("select fullname from users where id=" . $drData["userid"]);
					$desc = nnull($drData["description"], "/");
					$act = "";
					if (nnull($drData["activity"], "/") <> "/") {
						$actarr = explode("/", $drData["activity"]);
											
						if (count($actarr) > 1) {
							$actarr = array_reverse($actarr);
							for ($i=0; $i < count($actarr); $i++) {
							   $act .= " -> " . dic_($actarr[$i]);
							}
						} else {
							$act .= " -> " . dic_($drData["activity"]);
						}
						
					}
					$act = substr($act,4);		
                    ?>
                    
             <tr class="<?php echo $drData["userid"]?>" height=22px>
             	<!--<td align="center" style="background-color:#fff; border:1px dotted #B8B8B8;" class="text2" ><?php echo $cnt ?></td>-->
             	<td align="center" style="background-color:#fff; border:1px dotted #B8B8B8;" class="text2" ><?php echo nnull(DateTimeFormat($drData["datetime"], $timeformat), "/") ?></td>
             	<td align="left" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px;" class="text2" ><?php echo nnull($user, "/") ?></td>
                <td align="left" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px;" class="text2" ><?php echo $act ?></td>
                <td align="left" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px" class="text2"><?php echo $desc ?></td>
                <td align="center" style="background-color:#fff; border:1px dotted #B8B8B8;" class="text2"><?php echo nnull($drData["ipaddress"], "/") ?></td>
                <td align="left" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px" class="text2"><?php echo nnull($drData["notes"], "/") ?></td>
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

    </body>
</html>

<script>
	SetHeightLite()
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
	});
</script>
