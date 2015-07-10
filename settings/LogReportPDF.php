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


<body style="margin:0px 0px 0px 0px; padding:0px 0px 0px 0px; overflow:auto">
 	<div id="div-add-email" style="display:none" title="<?php dic("Reports.SendReport")?>"></div>
  	 <script>
  	 	if (!<?php echo is_numeric(session('user_id')) ?>)
  			top.window.location = "../sessionexpired/?l=" + '<?php echo $cLang ?>';
 	 </script>
 	 
  <?php
   
	opendb();
	$forUser = getQUERY("foruser");
	
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
	
  <div id="report-content" style="width:100%; text-align:left; height:500px; background-color:#fff;" class="corner5">

  <br>
  <div class="corner5" style="width:98%; border:1px solid #bbb; background-color:#fafafa; margin-left:1%">
 	 <div style="padding-left:40px; padding-top:10px; width:500px" class="textTitle">
				<?php echo mb_strtoupper(dic_("Reports.Log"), 'UTF-8') ?>&nbsp;&nbsp;&nbsp;&nbsp;
				<br><br>
				<span class="text5"> <?php dic("Reports.User")?>: <strong><?php echo session("user_fullname")?></strong></span><br>
				<span class="text5"> <?php dic("Reports.Company")?>: <strong><?php echo session("company")?></strong></span><br>
				<span class="text5"> <?php dic("Reports.CreationDate")?>: <strong><?php echo $CreationDate?></strong></span><br>
				<span class="text5"> <?php dic("Reports.DateTimeRange")?>: <strong><?php echo $sd?></strong> - <strong><?php echo $ed?></strong></span><br><br>
	</div>
		
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
            	if ($forUser == 0) {
            		$forusersql = "select id from users where clientid=" . $cid;
            	} else {
            		$forusersql = $forUser;
            	}
				
                $sql_ = "select datetime, userid, gettreeevent(eventtypeid, '', '') activity, description, ipaddress, notes 
				from userlog where userid in (" . $forusersql . ") and datetime 
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


</script>
