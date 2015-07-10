<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>


<?php 

	

	header("Content-type: text/html; charset=utf-8");
	opendb();
	$Allow = getPriv("vehicles", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
	
	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	$yourbrowser1 = (bool) strpos($ua['userAgent'], "Macintosh");
	
	addlog(42);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>	
	<link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../live/style.css">

	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/roundIE.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
    <script type="text/javascript" src="../pdf/pdf.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="./js/highcharts.src.js"></script>
    <link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    
	<style type="text/css">
	<?php
	if($yourbrowser == "1")
	{?>
		html
		{ 
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch; 
		}
		body
		{
		    height: 100%;
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch;
		    
		}
	<?php
	}
	?>
	</style>
	<style type="text/css"> 
 		body{ overflow-y:auto}
	</style>
 <body>
 	
 	<script>
  		if (!<?php echo is_numeric(session('user_id')) ?>)
  			top.window.location = "../sessionexpired/?l=" + '<?php echo $cLang ?>';
 	</script>
  
 <div id="div-add" style="display:none" title=""></div>
 <div id="div-cost" style="display:none" title="Додавање нов трошок"></div>
 <div id="div-costnew" style="display:none" title="Додавање нов тип на трошок"></div>
 <div id="div-loc" style="display:none" title="Додавање нов извршител"></div>
 <div id="div-comp" style="display:none" title="Додавање новa компонента"></div>
    <div id="dialog-message" title="<?php dic("Reports.Message")?>" style="display:none">
         <p>
	        <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
	        <div id="div-msgbox" style="font-size:14px"></div>
        </p>
    </div>
    
    <div id="dialog-message1" title="<?php dic("Reports.Warning")?>" style="display:none">
         <p>
	        <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
	        <div id="div-msgbox1" style="font-size:14px"></div>
        </p>
    </div>
 	<?php
 	 
	 $cnt_ = 1;
     $cnt_1 = 1;
     
	 $currency = dlookup("select currency from users where id=" . session('user_id')); 
	 $currencyvalue = dlookup("select value from currency where name='" . $currency . "'"); 
	 $liqunit1 = dlookup("select liquidunit from users where id=" . session('user_id'));
		if ($liqunit1 == 'galon') 
		{
			$liqvalue = 0.264172;
			$liqunit = "gal";
		}
		else 
		{
			$liqvalue = 1;
			$liqunit = "lit";
		}
		$metric = dlookup("select metric from users where id=" . session('user_id'));
		if ($metric == 'mi') $metricvalue = 0.621371;
		else $metricvalue = 1;

	$datetimeformat = dlookup("select datetimeformat from users where id=" . session('user_id'));
	$datfor = explode(" ", $datetimeformat);
	$dateformat = $datfor[0];
	$timeformat =  $datfor[1];
	if ($timeformat == 'h:i:s') $timeformat = $timeformat . " a";
	
     /*$cntVeh = nnull(dlookup("select COUNT(*) from Vehicles where ClientID = " . Session("client_id")), 0);
	 
     $cntfmVeh = NNull(DlookUP("select COUNT(*) from fmVehicles where Client_id = " & Session("client_id")), 0)
     Dim testDown As String = ""
     Dim cnt_ As Integer = 1
     Dim cnt_1 As Integer = 1
     
     If cntVeh <= cntfmVeh Then
         testDown = "style='display:none'"
     End If*/

     ?>
     
     <div id="report-content" style="width:100%; background-color:#fafafa; margin-bottom:50px; overflow-y:auto; overflow-x:hidden" class="corner5">
	 
    
    	 <div style="margin-bottom:25px; margin-top:30px; width:94%; margin-left:35px" align="right">
         <!--<div style="float:right; margin-right:36px; margin-bottom:25px; margin-top:10px"> -->
         <table width="100%">
         <tr class="text2_">
              	<td width="80%" align = "left" class="textTitle"><?php echo dic_("Fm.Vehicles")?></td>
                <td width="20%" align = "center" ><?php dic("Fm.SearchCode") ?>:</td>
                <td width="20%" align = "center"  style="padding-left:30px" ><?php dic("Fm.SearchReg")?>:</td>
         </tr>
	     <tr class="text2">
	     		<td align = "center">&nbsp;</td>
                <td align = "center"><input id="inp1" name="filter" onkeyup="filter(this, 'tabId', 0)" type="text" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px;"/></td>
                <td align = "center"><input id="inp2" name="filter" onkeyup="filter(this, 'tabId', 1)" type="text" size="22" style="margin-left:30px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px" /></td>
         </tr>
        </table>
       </div> 
       <?php 
       
       $korisnici = query("select * from users where id=" . Session("user_id")); 
       $tipKorisnik = pg_fetch_result($korisnici, 0, "roleid");
	   
	   if($tipKorisnik==2)
	   {
       ?>
       <?php
       
           $cnt = 1;
           $cnt1 = 1;
           $cnt2 = 1;
           
           $sqlOU = "select id, name, code from organisation where clientID=" . Session("client_id");
           $dsOU = query($sqlOU);
		  // $zaAlias = query("select count(*) from vehicles where alias <> '' and clientID=" . Session("client_id"));
		   
		   while ($drOU = pg_fetch_array($dsOU)){
               $sqlVeh = "select * from vehicles where active='1' and organisationid = " . $drOU["id"] . " and clientid = " . Session("client_id")."order by code::INTEGER"; 
               $dsVh = query($sqlVeh);
				
               If (pg_num_rows($dsVh) > 0) {
                   $cnt1 = 1;
				   
        ?>
		<table id="tabId<?php echo $cnt2 ?>" width="94%" border="0" cellspacing="2" cellpadding="2" style="margin-top:30px; margin-left:35px">
            <tr>
	            <td height="22px" class="text2" colspan=10 style="color:#fff; font-weight:bold; font-size:14px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b;">
	                <?php echo $drOU["code"]?>. <?php echo $drOU["name"] ?>
	            </td>
            </tr>

            <tr>
                <td width="6%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; ;" class="text2"><?php dic("Fm.Code") ?></td>
                <td width="12%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;" class="text2"><?php dic("Fm.Registration")?></td> 
                <td width="14%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; " class="text2"><?php dic("Fm.Model") ?></td>
                <td width="11%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;" class="text2">
                	<table width=100%>
                		<tr class="text2" style="font-weight:bold;"><td colspan=2 align="center"><? echo dic_("Settings.Registration")?></td></tr>
                		<tr class="text2" style="font-weight:bold;">
                			<td align="center"><? echo dic_("Settings.Last")?></td>
                			<td align="center"><? echo dic_("Settings.Next")?></td>
                		</tr>
                	</table>
                </td>
                <td width="8%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;" class="text2"><?php echo dic("Settings.GreenCard")?></td>
                <td width="12%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;" class="text2"><?php echo dic("Settings.LastData")?></td>
                <!--<td width="8%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633" class="text2"><?php echo dic_("Reports.Costs")?></td>-->
				<td width="8%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:ff6633" class="text2"><?php dic("Settings.VisibleLive")?></td>
				<td width="8%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633" class="text2"><?php dic("Fm.Mod") ?></td>
            </tr>

         <?php

             $paren = "";
             $greenCard = "";
			 $activity = "";
             $actYN = 0;
             $id = 0;
             
			 while ($rV = pg_fetch_array($dsVh)){
			 	$zaAlias = dlookup("select count(*) from vehicles where alias <> '' and id=" . $rV["id"]);
								 
                 $id = $rV["id"];
				 
                 If ($rV["greencard"] == 1)
				 {
                     $greenCard = "../images/stikla2.png";
                     $actYN = 1;
                 } 
                 else
				 {
                     $greenCard = "../images/stikla3.png";
                     $actYN = 0;
                 }
				 
				 If ($rV["visible"] == 1)
				 {
                     $activity = "../images/stikla2.png";
                 } 
                 else
				 {
                     $activity = "../images/stikla3.png";
                 }
                                
                $_lastReg = explode(" ", DateTimeFormat($rV["lastregistration"], "d-m-Y"));
          		$lastReg = $_lastReg[0];
		   		$fuelType = query("select name from fueltypes where id = (select fueltypeid from vehicles where id=" . $rV["id"] . ")");
				$row1 = pg_fetch_array($fuelType);
				//$lastDate = nnull(dlookup('select "DateTime" from currentposition where vehicleid=' . $rV["id"]), '/');	
				$ld = query('select "DateTime" from currentposition where vehicleid=' . $rV["id"]);
				if (pg_num_rows($ld) > 0)
					$lastDate = nnull(pg_fetch_result($ld, 0, 0), "/");
				else 
					$lastDate = "/";
				
				if ($lastDate <> "/") $lastDate = DateTimeFormat($lastDate, 'd-m-Y H:i:s');
				$color = "";
				
								
				if ($lastDate <> "/") {
					if (round(abs(strtotime(now())-strtotime($lastDate))/60) > 1440) $color = "red";	
					else $color = "green";
				}
				
                ?>
                 
                <tr id="veh<?php echo $cnt ?>" style="" onmouseover="over(<?php echo $cnt ?>, 0, <?php echo $actYN ?>)" onmouseout="out(<?php echo $cnt ?>, 0, <?php echo $actYN ?>)">
                
                <td id="td-1-<?php echo $cnt ?>" width="6%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; "><?php echo $rV["code"]?></td>
                <td id="td-2-<?php echo $cnt ?>" width="13%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><strong><?php echo $rV["registration"] ?></strong><br><?php if($zaAlias>0){?><font style="font-size:10px">(<?php echo $rV["alias"];?>)</font><?php }else{ echo "";}?></td>
                <td id="td-3-<?php echo $cnt ?>" width="16%" height="30px" align="center" class="text2 <?php echo $paren ?>" style="background-color:#fff; border:1px dotted #B8B8B8;" >
            	<b><?php echo $rV["model"]?></b><br>
            	<?php if($row1["name"]=="Бензин")
	            {
	            ?>
	            &nbsp;(<font style="font-size:10px"><?php echo dic("Settings.Petrol")?></font>)
	            <?php
	            }
	            if($row1["name"]=="Дизел")
				{
				?>
				&nbsp;(<font style="font-size:10px"><?php echo dic("Settings.Diesel")?></font>)
			 	<?php
				}
				if($row1["name"]=="LPG")
				{
				?>
				&nbsp;(<font style="font-size:10px"><?php echo dic("Settings.Gas")?></font>)
			 	<?php
				}
				?>
				</div>
				</td> 				         
                <td id="td-4-<?php echo $cnt?>" width="11%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                	<table width=100%>
                		<tr class="text2">
                			<td align="center"><?php echo $lastReg ?></td>
                			<?php
                			//$totalDaysOfYear = date("z", mktime(0,0,0,12,31,DateTimeFormat($lastReg, 'Y'))) + 1;
                			$nextReg = DateTimeFormat(date('Y-m-d', strtotime($lastReg. ' + 1 year')), $dateformat);
							$diffDays = DateDiffDays(DateTimeFormat(now(), 'Y-m-d'), date('Y-m-d', strtotime($lastReg. ' + 1 year')));
							$colorReg = "";
							$titleReg = "";
							
							if ($diffDays < 0) {
								$colorReg = "#FF0000";
								$titleReg = dic_("Fm.RegLess") . " " . number_format(abs($diffDays)) . " " . dic_("Fm.Days_"). ".";
							} else {
								if ($diffDays < 14 and $diffDays > 0) {
									$colorReg = "#F7962B";
									$titleReg = dic_("Fm.VehMore") . (number_format($diffDays) - 1) . " " . dic_("Fm.DaysReg");
								} else {
									if ($diffDays == 0) {
										$colorReg = "#F7962B";
										$titleReg = dic_("Fm.RegToday");
									} else {
										$colorReg = "#008000";
										$titleReg = dic_("Fm.VehMore") . (number_format($diffDays) - 1) . " " . dic_("Fm.DaysReg");
									}
								}
							}						
							
                			?>
                			<td align="center" style="color: <?php echo $colorReg?>" title="<?php echo $titleReg?>"><?php echo $nextReg ?></td>
                		</tr>
                	</table>
                </td>
                <td id="td-5-<?php echo $cnt?>" width="5%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                      <img id="act<?php echo $cnt?>" width= "11px" height = "11px" src="<?php echo $greenCard?>"  />
                </td>
                <td id="td-6-<?php echo $cnt?>" width="12%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; color:<?php echo $color?>"><?php echo $lastDate?></td>
                
                                <?php
				                	$fm = dlookup("select allowedfm from clients where id=" . session("client_id"));
									if ($fm == '1' and session("role_id") == 2) {          ?>
				                <td id="_td-7-<?php echo $cnt_ ?>" width="8%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                                    <button id="_costBtn-<?php echo $cnt_?>" onclick="costVehicle(<?php echo $cnt_1 ?>, <?php echo $id ?>, '<?php echo $drOV["registration"] ?> (<?php echo $drOV["code"] ?>) <?php echo $drOV["alias"] ?>')" style="height:22px; width:30px"></button>
                                </td>
			                   <?
								}
								?>
								
				<td id="td-9-<?php echo $cnt?>" width="8%" height="30px" align="center" class="text2 <?php echo $paren?>" style="background-color:#fff; border:1px dotted #B8B8B8;">
             <!--         <img id="act<?php echo $cnt?>" width= "11px" height = "11px" src="<?php echo $activity?>"  />
                   		 <button id="delBtn<?php echo $cnt ?>" onclick="del(<?php echo $rV["id"] ?>, '<?php echo $cLang ?>', 'vehicles')" style="height:22px; width:30px"></button> -->
                </td>
				
				<td id="td-8-<?php echo $cnt?>" width="8%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                    <button id="modBtn<?php echo $cnt ?>" onclick="modifyVehicle(<?php echo $cnt ?>, <?php echo $id ?>)" style="height:22px; width:30px"></button>
                </td>
                
            </tr>

                 <?php
                     $cnt = $cnt + 1;
                     $cnt1 = $cnt1 + 1;
             }//end while
             ?>
             
        </table>

        <?php
            $cnt2 = $cnt2 + 1;
			$cnt1 = $cnt1 + 1;
	        }//end if
	       		
	        }//end while
      
     	  
             $sqlOthV = "select distinct organisationid from vehicles where active='1' and clientid = " . Session("client_id") . " and organisationid not in (select id from organisation where clientid=" . Session("client_id") . ")";
             $dsOthV = query($sqlOthV);

             If (pg_num_rows($dsOthV) > 0) {
?>
<table id="tabId<?php echo $cnt2 ?>" width="94%" border="0" cellspacing="2" cellpadding="2" style="margin-top:30px; margin-left:35px"> 	
            <tr><td height="22px" class="text2" colspan=10 style="color:#fff; font-weight:bold; font-size:14px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b;"><?php dic("Fm.UngroupedVeh") ?></td></tr>
          
            <tr>
                <td width="6%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;;"><?php dic("Fm.Code")?></td>
                <td width="12%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.Registration") ?></td> 
                <td width="14%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; "><?php dic("Fm.Model") ?></td>
                <td width="11%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;" >
                	<table width=100%>
                		<tr class="text2" style="font-weight:bold;"><td colspan=2 align="center"><? echo dic_("Settings.Registration")?></td></tr>
                		<tr class="text2" style="font-weight:bold;">
                			<td align="center"><? echo dic_("Settings.Last")?></td>
                			<td align="center"><? echo dic_("Settings.Next")?></td>
                		</tr>
                	</table>
                </td>
                <td width="8%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;" ><?php echo dic("Settings.GreenCard")?></td>
                <td width="12%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;" class="text2"><?php echo dic("Settings.LastData")?></td>
                <td width="8%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633"><?php dic("Settings.VisibleLive")?></td>
                <td width="8%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633"><?php dic("Fm.Mod")?></td>
            </tr>

                 <?php
                 
                     $sqlOV = "";
                     
                     $paren = "";
                     $greenCard = "";
					 $activity = "";
                     $actYN = 0;
                     $id = 0;
                     $lastReg = "";
                     
                     $cnt_1 = $cnt;
                     
					 while ($drOthV = pg_fetch_array($dsOthV)){
					 	
                         $sqlOV = "select * from vehicles where active='1' and organisationid=" . $drOthV["organisationid"] . " and clientid=" . Session("client_id")." ORDER BY code::INTEGER";
                         $dsOV = query($sqlOV);
                         			 
						 while ($drOV= pg_fetch_array($dsOV)){
						 	 $zaAlias = dlookup("select count(*) from vehicles where alias <> '' and id=" . $drOV["id"]);
							 
                             $id = $drOV["id"];
                             
                             If ($drOV["greencard"] == 1) {
                                 $greenCard = "../images/stikla2.png";
                                 $actYN = 1;
                             } else {
                                 $greenCard = "../images/stikla3.png";
                                 $actYN = 0;
                             } 
                             
							 If ($drOV["visible"] == 1)
							 {
			                     $activity = "../images/stikla2.png";
			                 } 
			                 else
							 {
			                     $activity = "../images/stikla3.png";
			                 }
																          
							 $_lastReg = explode(" ", DateTimeFormat($drOV["lastregistration"], "d-m-Y"));
			          		 $lastReg = $_lastReg[0];
				             $fuelType1 = query("select name from fueltypes where id = (select fueltypeid from vehicles where id=" . $drOV["id"] . ")");	
                             $row2 = pg_fetch_array($fuelType1);
                             //$lastDate = nnull(dlookup('select "DateTime" from currentposition where vehicleid=' . $drOV["id"]), "/");

							 $ld = query('select "DateTime" from currentposition where vehicleid=' . $drOV["id"]);
							 if (pg_num_rows($ld) > 0)
								$lastDate = nnull(pg_fetch_result($ld, 0, 0), "/");
							 else 
								$lastDate = "/";
				
                             if ($lastDate <> "/") $lastDate = DateTimeFormat($lastDate, 'd-m-Y H:i:s');
                         		$color = "";					
							 if ($lastDate <> "/") {
								if (round(abs(strtotime(now())-strtotime($lastDate))/60) > 1440) $color = "red";	
								else $color = "green";
							 }

							 ?>
                             <tr id="veh<?php echo $cnt_1 ?>" style="" onmouseover="over(<?php echo $cnt_ ?>, 1, <?php echo $actYN ?>)" onmouseout="out(<?php echo $cnt_ ?>, 1, <?php echo $actYN ?>)">
                             
                                <td id="_td-1-<?php echo $cnt_ ?>" width="6%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; "><?php echo $drOV["code"] ?></td>  
                                <td id="_td-2-<?php echo $cnt_ ?>" width="13%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><strong><?php echo $drOV["registration"] ?></strong><br> <?php if($zaAlias>0){?><font style="font-size:10px">(<?php echo $drOV["alias"];?>)</font><?php }else{ echo "";}?></td>
                                <td id="_td-3-<?php echo $cnt_ ?>" width="16%" height="30px" align="center" class="text2 <?php echo $paren?>" style="background-color:#fff; border:1px dotted #B8B8B8;">
                                <b><?php echo $drOV["model"]?></b><br>
                                <?php 
                                if($row2["name"]=="Бензин")
			                    {
			                    ?>
			                    &nbsp;(<font style="font-size: 10px"><?php echo dic("Settings.Petrol")?></font>)
			                    <?php
			                    }
			                    if($row2["name"]=="Дизел")
								{	
								?>
								&nbsp;(<font style="font-size:10px"><?php echo dic("Settings.Diesel")?></font>)
			    			 	<?php
								}
								if($row2["name"]=="LPG")
								{
								?>
								&nbsp;(<font style= "font-size: 10px"><?php echo dic("Settings.Gas")?></font>)
			    			 	<?php
								}
								?>
								</td>
                                <td id="_td-4-<?php echo $cnt_ ?>" width="11%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                                	<table width=100%>
				                		<tr class="text2">
				                			<td align="center"><?php echo $lastReg ?></td>
				                			<?php
				                			//$totalDaysOfYear = date("z", mktime(0,0,0,12,31,DateTimeFormat($lastReg, 'Y'))) + 1;
				                			$nextReg = DateTimeFormat(date('Y-m-d', strtotime($lastReg. ' + 1 year')), $dateformat);
											$diffDays = DateDiffDays(DateTimeFormat(now(), 'Y-m-d'), date('Y-m-d', strtotime($lastReg. ' + 1 year')));
											$colorReg = "";
											$titleReg = "";

											if ($diffDays < 0) {
												$colorReg = "#FF0000";
												$titleReg = dic_("Fm.RegLess") . " " . number_format(abs($diffDays)) . " " . dic_("Fm.Days_"). ".";
											} else {
												if ($diffDays < 14 and $diffDays > 0) {
													$colorReg = "#F7962B";
													$titleReg = dic_("Fm.VehMore") . (number_format($diffDays) - 1) . " " . dic_("Fm.DaysReg");
												} else {
													if ($diffDays == 0) {
														$colorReg = "#F7962B";
														$titleReg = dic_("Fm.RegToday");
													} else {
														$colorReg = "#008000";
														$titleReg = dic_("Fm.VehMore") . (number_format($diffDays) - 1) . " " . dic_("Fm.DaysReg");
													}
												}
											}							
											
				                			?>
				                			<td align="center" style="color: <?php echo $colorReg?>" title="<?php echo $titleReg?>"><?php echo $nextReg ?></td>
				                		</tr>
				                	</table>
                                </td>
                                <td id="_td-5-<?php echo $cnt_ ?>" width="5%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><img id="_act<?php echo $cnt_?>" src=<?php echo $greenCard ?>  width = "11px" height = "11px"/></td>
                                <td id="_td-6-<?php echo $cnt_ ?>" width="12%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; color:<?php echo $color?>"><?php echo $lastDate?></td>
                            
								<td id="_td-9-<?php echo $cnt_ ?>" width="8%" height="30px" align="center" class="text2 <?php echo $paren ?>" style="background-color:#fff; border:1px dotted #B8B8B8;">
                                    <img id="_act<?php echo $cnt_?>" src=<?php echo $activity?>  width = "11px" height = "11px"/>
                                    <!--<button id="_delBtn-<?php echo $cnt_ ?>" onclick="del(<?php echo $drOV["id"] ?>, '<?php echo $cLang ?>', 'vehicles')" style="height:22px; width:30px"></button>-->
                                </td>                              
							
								<td id="_td-8-<?php echo $cnt_ ?>" width="8%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                                    <button id="_modBtn-<?php echo $cnt_?>" onclick="modifyVehicle(<?php echo $cnt_1 ?>, <?php echo $id ?>)" style="height:22px; width:30px"></button>
                                </td>
                             </tr>
                             <?php
                                 $cnt_ = $cnt_ + 1;
                                 $cnt_1 = $cnt_1 + 1;
								 
                             } //end while
                       } //end while
                       ?>
                       </table>
                     <?php  
             } //end if
                 ?>                 
                 
                 <?php 
                 }
   $cLang = getQUERY("l");
closedb(); 
                  ?>

         <div style="height:40px">&nbsp;</div>
   </div>
</body>



</html>