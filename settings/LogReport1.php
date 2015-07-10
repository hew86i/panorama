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
	
	$forUser = getQUERY("foruser");
	
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

	$meseci = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
	$countALL = 0;				
		
	$langArr = explode("?", getQUERY("l"));
	$cLang = $langArr[0];
		
	
?>

<?php	
	if (getQUERY("from") == "a") {
		$filename = "Log_report_" . $cid . "_" . DateTimeFormat($sdG, $dateformat) . $s1_ . "_" . DateTimeFormat($edG, $dateformat) . $e1_ . ".xls";
		header('Content-type: application/ms-excel; charset=utf-8');
		header('Content-Disposition: attachment; filename='.$filename);
	}
?>

 <body>

 	
	 <table>
        <tr><td colspan=13 style="border:1px solid #000000; font-weight:bold"><strong><?php echo mb_strtoupper(dic_("Reports.Log"), 'UTF-8') ?></strong></td></tr>
        <tr><td colspan=13></td></tr>
        <tr><td colspan=2 style="border:1px solid #bebebe; font-weight:bold"><strong><?php dic("Reports.User") ?>:</strong></td><td style="border:1px solid #bebebe;" colspan="11"><?php echo session("user_fullname")?></td></tr>
        <tr><td colspan=2 style="border:1px solid #bebebe; font-weight:bold"><strong><?php dic("Reports.Company")?>:</strong></td><td style="border:1px solid #bebebe;" colspan="11"><?php echo session("company")?></td></tr>
 		<tr><td colspan=2 style="border:1px solid #bebebe; font-weight:bold"><strong><?php dic("Reports.CreationDate")?>:</strong></td><td align="left" style="border:1px solid #bebebe;" colspan="11"><?php echo $CreationDate?></td></tr>
        <tr><td colspan=2 style="border:1px solid #bebebe; font-weight:bold"><strong><?php dic("Reports.DateTimeRange") ?>:</strong></td><td style="border:1px solid #bebebe;" colspan="11"><?php echo $sd?> - <?php echo $ed?></td></tr>
        <tr><td colspan=13></td></tr>
    </table>
    
	<?php
        $_datumCnt  = $sdG;
		
		while (DateDiffDays($edG, $_datumCnt) < 0) {
			$cnt = 1;
			?>
		<table>
           
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
            	<td colspan="13"><strong><?php echo DateTimeFormat($_datumCnt,"d") . " " . dic_("Reports." . $meseci[intval(DateTimeFormat($_datumCnt, "m")) - 1] . "") . " " . DateTimeFormat($_datumCnt,"Y")?></strong></td>
        	</tr>
        	
			<tr>
	             <td><strong><?php echo dic_("Reports.Vreme")?></strong></td>
	             <td><strong><?php echo dic_("Reports.User")?></strong></td>
	             <td colspan=2><strong><?php echo dic_("Settings.Action")?></strong></td>
	             <td colspan=2><strong><?php echo dic_("Reports.Description")?></strong></td>
	             <td><strong><?php echo dic_("Reports.IPaddress")?></strong></td>
	             <td colspan=6><strong><?php echo dic_("Reports.Browser")?></strong></td>
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
                    
             <tr>
             	<td><?php echo nnull(DateTimeFormat($drData["datetime"], $timeformat), "/") ?></td>
             	<td><?php echo nnull($user, "/") ?></td>
                <td colspan=2><?php echo $act ?></td>
                <td colspan=2><?php echo $desc ?></td>
                <td><?php echo nnull($drData["ipaddress"], "/") ?></td>
                <td colspan=6><?php echo nnull($drData["notes"], "/") ?></td>
       </tr>
                    <?php
                    $cnt ++;
                    } //end while
                    
                    } else {
                    	?>
                    	
                    	<tr>
                    		<td colspan=13><strong><?php echo DateTimeFormat($_datumCnt,"d") . " " . dic_("Reports." . $meseci[intval(DateTimeFormat($_datumCnt, "m")) - 1] . "") . " " . DateTimeFormat($_datumCnt,"Y")?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo dic_("Reports.NoDataDay")?></strong></td>
                    	</tr>
                    	<?php
                    }

             ?>
<tr><td colspan=13></td></tr>
          </table>
			
			<?php
			$_datumCnt = addToDate($_datumCnt, 1, "days");	
			
			
		}
         
 			closedb();        
          ?>
   

    </body>
</html>

