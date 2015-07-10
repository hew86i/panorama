<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<html >
<head>
	<script>
		lang = '<?php echo $cLang?>'
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	<script type="text/javascript" src="reports.js"></script>
	
	<script>
  		if (<?php echo nnull(is_numeric(nnull(getQUERY("u"))), 0) ?> == 0){
  			if (<?php echo nnull(is_numeric(nnull(session("user_id"))), 0) ?> == 0)
  				top.window.location = "../sessionexpired/?l=" + '<?php echo $cLang ?>';
  		} 
  	</script>
  	
</head>
<?php			

	if (nnull(is_numeric(nnull(getQUERY("u"))), 0)>0){
		$uid = getQUERY("u");
		$cid = getQUERY("c");	
	} else {
		$uid = session("user_id");
		$cid = session("client_id");
	}
	
	opendb();
	
	/*format na datum*/
	$datetimeformat = dlookup("select datetimeformat from users where id=" . $uid);
	$datfor = explode(" ", $datetimeformat);
	$dateformat = $datfor[0];
	$timeformat =  $datfor[1];
	if ($timeformat == 'h:i:s') $timeformat = $timeformat . " a";
	
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
	
	//$_SESSION['role_id'] = nnull(dlookup("select roleid from users where id=" . $user_id), 0 );
	$role_id = nnull(dlookup("select roleid from users where id=" . $uid), 0 );
	
    $vh = nnull(getQUERY("vh"), "0"); //645;//
    $sdG = DateTimeFormat(getQUERY("sd"), 'd-m-Y H:i:s');
	$edG = DateTimeFormat(getQUERY("ed"), 'd-m-Y H:i:s');
	
    $sd = DateTimeFormat(getQUERY("sd"), $dateformat) . $s_; //'01-09-2012 00:00';
    $ed = DateTimeFormat(getQUERY("ed"), $dateformat) . $e_; //'01-09-2012 23:59';
	
	$tzone = dlookup("select tzone from users where id=" . $uid);  
	$CreationDate = strtoupper(DateTimeFormat(addToDateU(now(), $tzone, "hour", "Y-m-d H:i"), $datetimeformat));  
	/*format na datum*/
	
	$_SESSION["user_fullname"] = dlookup("select fullname from users where id='" . $uid . "'");
	$_SESSION["company"] = dlookup("select name from clients where id in (select clientid from users where id=" . $uid . " limit 1) limit 1");
	
	    
    $langArr = explode("?", getQUERY("l"));
	$cLang = $langArr[0];
	
    
    $vh = getQUERY("vh");
	 
	$sqlU1 = "select id, fullname from users where clientID=" . $cid;
	
	if ($role_id == "2") {
		$sqlU = "select id from users where clientID=" . $cid;
		
	} else {
		$sqlU = "select id from users where id=" . $uid;
		
	}	 
	
	$meseci = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	$countALL = 0;				
		
	$langArr = explode("?", getQUERY("l"));
	$cLang = $langArr[0];
		
	
?>

<?php	
	if (getQUERY("from") == "a") {
		$filename = "Message_report_" . $cid . "_" . DateTimeFormat($sdG, $dateformat) . $s1_ . "_" . DateTimeFormat($edG, $dateformat) . $e1_ . ".xls";
		header('Content-type: application/ms-excel; charset=utf-8');
		header('Content-Disposition: attachment; filename='.$filename);
	}
?>


 <body>
 
	
	 <table>
        <tr><td colspan=6 style="border:1px solid #000000; font-weight:bold"><strong><?php echo mb_strtoupper(dic_("Reports.ReportFor") . '  ' . dic_("Settings.MessagesNew"), 'UTF-8') ?></strong></td></tr>
        <tr><td colspan=6></td></tr>
        <tr><td colspan=2 style="border:1px solid #bebebe; font-weight:bold"><strong><?php dic("Reports.User") ?>:</strong></td><td style="border:1px solid #bebebe;" colspan="4"><?php echo session("user_fullname")?></td></tr>
        <tr><td colspan=2 style="border:1px solid #bebebe; font-weight:bold"><strong><?php dic("Reports.Company")?>:</strong></td><td style="border:1px solid #bebebe;" colspan="4"><?php echo session("company")?></td></tr>
 		<tr><td colspan=2 style="border:1px solid #bebebe; font-weight:bold"><strong><?php dic("Reports.CreationDate")?>:</strong></td><td align="left" style="border:1px solid #bebebe;" colspan="4"><?php echo $CreationDate?></td></tr>
        <tr><td colspan=2 style="border:1px solid #bebebe; font-weight:bold"><strong><?php dic("Reports.DateTimeRange") ?>:</strong></td><td style="border:1px solid #bebebe;" colspan="4"><?php echo $sd?> - <?php echo $ed?></td></tr>
        <tr><td colspan=6></td></tr>
    </table>
    
    
		<?php

		$sqln_ = "select * from messages where (fromid in (" . $sqlU . ") or toid in (" . $sqlU . ")) and datetime between '" . DateTimeFormat($sdG, "Y-m-d 00:00:00") . "' and '" . DateTimeFormat($edG, "Y-m-d 23:59:59") . "' order by fromid,checked";
	
		$meseci = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
		?>
		
	<?php
        $_datumCnt  = $sdG;
		
		while (DateDiffDays($edG, $_datumCnt) < 0) {
			$cnt = 1;
			?>
		<table>
           
            <?php
            	
                $sqln_ = "select * from messages where (fromid in (" . $sqlU . ") or toid in (" . $sqlU . ")) and datetime between '" . DateTimeFormat($_datumCnt, "Y-m-d 00:00:00") . "' and '" . DateTimeFormat($_datumCnt, "Y-m-d 23:59:59") . "' order by fromid,checked";
				
          		$dsData = query($sqln_);
				if (pg_num_rows($dsData) > 0) {
				?>
			<tr >
            	<td colspan="6"><strong><?php echo DateTimeFormat($_datumCnt,"d") . " " . dic_("Reports." . $meseci[intval(DateTimeFormat($_datumCnt, "m")) - 1] . "") . " " . DateTimeFormat($_datumCnt,"Y")?></strong></td>
        	</tr>
        	
			<tr>
				 <td><strong><?php echo dic_("Reports.Viewed")?></strong></td>
	             <td><strong><?php echo dic_("Reports.Vreme")?></strong></td>
	             <td><strong><?php echo dic_("From")?></strong></td>
	             <td><strong><?php echo dic_("To")?></strong></td>
	             <td colspan="2"><strong><?php echo dic_("Message")?></strong></td>
	 		</tr>
				<?php		
				
				while ($drData = pg_fetch_array($dsData)) {              
					
					if($drData["checked"] == "1") {
						$viewed = dic_("Reports.Yes");
					}
					else {
						$viewed = dic_("Reports.No");
					}
					$from = dlookup("select fullname from users where id=" . $drData["fromid"]);
					if ($drData["toobject"] == 'user') {
			  			$to = dlookup("select fullname from users where id=" . $drData["toid"]);
			  		} else {
			  			$to = dlookup("select registration from vehicles where id=" . $drData["toid"]);
			  		}
					
					
                    ?>
                    
             <tr>
             	<td><?php echo $viewed ?></td>
             	<td><?php echo DateTimeFormat($drData["datetime"], $timeformat) ?></td>
                <td><?php echo $from?></td>
                <td><?php echo $to?></td>
                <td colspan="2"><?php echo $drData["body"]?></td> 
      		 </tr>
                    <?php
                    $cnt ++;
                    } //end while
                    
                    } else {
                    	?>
                    	
                    	<tr>
                    		<td colspan="6"><strong><?php echo DateTimeFormat($_datumCnt,"d") . " " . dic_("Reports." . $meseci[intval(DateTimeFormat($_datumCnt, "m")) - 1] . "") . " " . DateTimeFormat($_datumCnt,"Y")?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo dic_("Reports.NoDataDay")?></strong></td>
                    	</tr>
                    	
                    	<?php
                    }

             ?>
				<tr>
                    <td colspan="6"></td>
                 </tr>
          </table>
			
			<?php
			$_datumCnt = addToDate($_datumCnt, 1, "days");	
		}
         
 			closedb();        
          ?>
        
    </body>
</html>
