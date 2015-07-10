<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
	opendb();
	$Allow = getPriv("vehicles", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
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
	<script type="text/javascript" src="../js/iScroll.js"></script>
    <script type="text/javascript" src="../pdf/pdf.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="fm.js"></script>
	<script type="text/javascript" src="./js/highcharts.src.js"></script>
  
    <link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    
	<style>
		body{ overflow-y:auto }
	</style>
 <body>
 <div id="div-add" style="display:none" title=""></div>
    <div id="dialog-message" title="<?php dic("Reports.Message")?>" style="display:none">
         <p>
	        <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
	        <div id="div-msgbox" style="font-size:14px"></div>
        </p>
    </div>
    
 <?php
 	 
	 $cnt_ = 1;
     $cnt_1 = 1;
     
     /*$cntVeh = nnull(dlookup("select COUNT(*) from Vehicles where ClientID = " . Session("client_id")), 0);
	 
     $cntfmVeh = NNull(DlookUP("select COUNT(*) from fmVehicles where Client_id = " & Session("client_id")), 0)
     Dim testDown As String = ""
     Dim cnt_ As Integer = 1
     Dim cnt_1 As Integer = 1
     
     If cntVeh <= cntfmVeh Then
         testDown = "style='display:none'"
     End If*/

     ?>
    

	    <div class="textTitle" style="padding-left:36px; padding-top:25px;"><?php echo mb_strtoupper(dic_("Fm.Vehicles"), 'UTF-8') ?><br />
		    <span class="text5"> <?php dic("Reports.User")?>: <strong><?php echo session("user_fullname")?></strong></span><br />
		    <span class="text5"> <?php dic("Reports.Company")?>: <strong><?php echo session("company")?></strong></span><br />
	    </div>

        <div style="float:left; margin-left:32px; margin-top:20px; margin-bottom:10px;">
            <table >
                <tr><td></td><td></td></tr>
                <tr class="text2" >
                     <td><!--<button id="addBtn" onclick="addVehicle()" ><%=dic("Fm.AddVeh") %></button>--></td>
                     <td><!--<button id="downVeh" <%=testDown %> onclick="downVehicles(<%=Session("client_id") %>)" style="position:relative; left:30px" ><%=dic("Fm.DownloadVeh") %></button>--></td>
                </tr>
            </table>
        </div>

        <div style="float:right; margin-right:36px; margin-bottom:25px; margin-top:10px">
             <table>
                <tr class="text2_" >
                 <td ><?php dic("Fm.SearchCode") ?>:</td>
                 <td style="padding-left:30px"><?php dic("Fm.SearchReg") ?>:</td>
             </tr>

            <tr class="text2" >
                 <td><input id="inp1" name="filter" onkeyup="filter(this, 'tabId', 1)" type="text" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px;"/></td>
                <td><input id="inp2" name="filter" onkeyup="filter(this, 'tabId', 2)" type="text" size="22" style="margin-left:30px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px" /></td>
            </tr>
            </table>
        </div>

       <?php
       
           $cnt = 1;
           $cnt1 = 1;
           $cnt2 = 1;
           
           $sqlOU = "select id, name, code from organisation where clientID=" . Session("client_id");
           $dsOU = query($sqlOU);

		   while ($drOU = pg_fetch_array($dsOU)){
               $sqlVeh = "select * from vehicles where organisationid = " . $drOU["id"] . " and clientid = " . Session("client_id"); 
               $dsVh = query($sqlVeh);
	
               If (pg_num_rows($dsVh) > 0) {
                   $cnt1 = 1;
           
        ?>
       
        <table id="tabId<?php echo $cnt2 ?>" width="94%" border="0" cellspacing="2" cellpadding="2" align="center" style="margin-top:30px; margin-left:35px">
            <tr>
            <td height="22px" class="text2" colspan=9 style="color:#fff; font-weight:bold; font-size:14px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b;">
                <?php echo $drOU["code"]?>. <?php echo $drOU["name"] ?>
            </td>
            
            </tr>

            <tr>
                <td width="3%"></td>
                <td width="7%"  height="22px" align="left" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px;" class="text2"><?php dic("Fm.Code") ?></td>
                <td width="12%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;" class="text2"><?php dic("Fm.Registration")?></td> 
                <td width="30%"  height="22px" align="left" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px" class="text2"><?php dic("Fm.Model") ?></td>
                <td width="16%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;" class="text2"><?php dic("Fm.LastReg") ?></td>
                <td width="8%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;" class="text2"><?php echo dic("Settings.GreenCard")?></td>
                <td width="8%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633" class="text2"><?php dic("Fm.Mod") ?></td>
                <td width="8%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:ff6633" class="text2"><?php dic("Fm.Delete") ?></td>
            </tr>

         <?php

             $paren = "";
             $greenCard = "";
             $actYN = 0;
             $id = 0;
             
			 while ($rV = pg_fetch_array($dsVh)){
                 $id = $rV["id"];
				 
                 If ($rV["greencard"] == 1) {
                     $greenCard = "../images/yes3.png";
                     $actYN = 1;
                 } else {
                     $greenCard = "../images/no3.png";
                     $actYN = 0;
                 }
                                
                $_lastReg = explode(" ", DateTimeFormat($rV["lastregistration"], "d-m-Y"));
          		$lastReg = $_lastReg[0];
		   
                 ?>
                 
             <tr id="veh<?php echo $cnt ?>" style="cursor:pointer" onmouseover="over(<?php echo $cnt ?>, 0, <?php echo $actYN ?>)" onmouseout="out(<?php echo $cnt ?>, 0, <?php echo $actYN ?>)">
                <td width="3%"></td>
                <td id="td-1-<?php echo $cnt ?>" width="7%" height="30px" align="left" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px"><?php echo $rV["code"]?></td>
                <td id="td-2-<?php echo $cnt ?>" width="12%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo $rV["registration"] ?></td>
                <td id="td-3-<?php echo $cnt ?>" width="30%" height="30px" align="left" class="text2 <?php echo $paren ?>" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px" ><div style="float:left; font-weight:bold"><?php echo $rV["model"] ?></div></td>          
                <td id="td-4-<?php echo $cnt ?>" width="16%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo $lastReg ?></td>
                <td id="td-5-<?php echo $cnt ?>" width="8%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                     <img id="act<?php echo $cnt ?>" src="<?php echo $greenCard ?>"  />
                </td>
                <td id="td-6-<?php echo $cnt ?>" width="8%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                    <button id="modBtn<?php echo $cnt ?>" onclick="modifyVehicle(<?php echo $cnt ?>, <?php echo $id ?>)" style="height:22px; width:30px"></button>
                </td>
                <td id="td-7-<?php echo $cnt ?>" width="8%" height="30px" align="center" class="text2 <?php echo $paren?>" style="background-color:#fff; border:1px dotted #B8B8B8;">
                    <button id="delBtn<?php echo $cnt ?>" onclick="del(<?php echo $rV["id"] ?>, '<?php echo $cLang ?>', 'vehicles')" style="height:22px; width:30px"></button>
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
        }//end if
        }//end while
      
     	  
             $sqlOthV = "select distinct organisationid from vehicles where clientid = " . Session("client_id") . " and organisationid not in (select id from organisation where clientid=" . Session("client_id") . ")";
             $dsOthV = query($sqlOthV);

             If (pg_num_rows($dsOthV) > 0) {

                 ?>
                 <table id="tabId<?php echo $cnt2?>" width="94%" border="0" cellspacing="2" cellpadding="2" align="center" style="margin-top:30px; margin-left:35px">
            <tr><td height="22px" class="text2" colspan=9 style="color:#fff; font-weight:bold; font-size:14px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b;"><?php dic("Fm.UngroupedVeh") ?></td></tr>
          

            <tr>
                <td width="3%"></td>
                <td width="7%"  height="22px" align="left" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px;"><?php dic("Fm.Code")?></td>
                <td width="12%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.Registration") ?></td> 
                <td width="30%"  height="22px" align="left" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><?php dic("Fm.Model") ?></td>
                <td width="16%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;" ><?php dic("Fm.LastReg")?></td>
                <td width="8%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;" ><?php echo dic("Settings.GreenCard")?></td>
                <td width="8%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633"><?php dic("Fm.Mod")?></td>
                <td width="8%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633"><?php dic("Fm.Delete") ?></td>
            </tr>

                 <?php
                 
                     $sqlOV = "";
                     
                     $paren = "";
                     $greenCard = "";
                     $actYN = 0;
                     $id = 0;
                     $lastReg = "";
                     
                     $cnt_1 = $cnt;
                     
					 while ($drOthV = pg_fetch_array($dsOthV)){
					 	
                         $sqlOV = "select * from vehicles where organisationid=" . $drOthV["organisationid"] . " and clientid=" . Session("client_id");
                         $dsOV = query($sqlOV);
                         				 
						 while ($drOV= pg_fetch_array($dsOV)){
                             $id = $drOV["id"];
                             
                             If ($drOV["greencard"] == 1) {
                                 $greenCard = "../images/yes3.png";
                                 $actYN = 1;
                             } else {
                                 $greenCard = "../images/no3.png";
                                 $actYN = 0;
                             }
                                   
																          
							 $_lastReg = explode(" ", DateTimeFormat($drOV["lastregistration"], "d-m-Y"));
			          		 $lastReg = $_lastReg[0];
				             	
                             ?>
                             <tr id="veh<?php echo $cnt_1 ?>" style="cursor:pointer" onmouseover="over(<?php echo $cnt_ ?>, 1, <?php echo $actYN ?>)" onmouseout="out(<?php echo $cnt_ ?>, 1, <?php echo $actYN ?>)">
                                <td width="3%"></td>
                                <td id="_td-1-<?php echo $cnt_ ?>" width="7%" height="30px" align="left" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px"><?php echo $drOV["code"] ?></td>
                                <td id="_td-2-<?php echo $cnt_ ?>" width="12%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo $drOV["registration"] ?></td>
                                <td id="_td-3-<?php echo $cnt_ ?>" width="30%" height="30px" align="left" class="text2 <%=paren%>" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px"><div style="float:left; font-weight:bold"><?php echo $drOV["model"]?></div></td>
                                <td id="_td-4-<?php echo $cnt_ ?>" width="16%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo $lastReg ?></td>
                                <td id="_td-5-<?php echo $cnt_ ?>" width="8%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><img id="_act<?php echo $cnt_?>" src=<?php echo $greenCard ?> /></td>
                                <td id="_td-6-<?php echo $cnt_ ?>" width="8%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                                    <button id="_modBtn-<?php echo $cnt_?>" onclick="modifyVehicle(<?php echo $cnt_1 ?>, <?php echo $id ?>)" style="height:22px; width:30px"></button>
                                </td>
                                <td id="_td-7-<?php echo $cnt_ ?>" width="8%" height="30px" align="center" class="text2 <?php echo $paren ?>" style="background-color:#fff; border:1px dotted #B8B8B8;">
                                    <button id="_delBtn-<?php echo $cnt_ ?>" onclick="del(<?php echo $drOV["id"] ?>, '<?php echo $cLang ?>', 'vehicles')" style="height:22px; width:30px"></button>
                                </td>
                             </tr>
                             <?php
                                 $cnt_ = $cnt_ + 1;
                                 $cnt_1 = $cnt_1 + 1;
								 
                                 } //end while
                     } //end while
             } //end if
                                                
                 ?>
                 </table>
      
         <div style="height:40px">&nbsp;</div>
</body>

<?php 
   $cLang = getQUERY("l");
?>

<script>

	lang = '<?php echo $cLang?>';
	
    for(var i = 0; i < <?php echo $cnt ?>; i ++) {
        $('#modBtn' + i).button({ icons: { primary: "ui-icon-pencil"} });
        $('#delBtn' + i).button({ icons: { primary: "ui-icon-trash"} });
    }

    for(var i = 0; i < <?php echo $cnt_ ?>; i ++) {
        $('#_modBtn-' + i).button({ icons: { primary: "ui-icon-pencil"} });
        $('#_delBtn-' + i).button({ icons: { primary: "ui-icon-trash"} });
    }

    function over(i, x, act) {
        if (x == 1) {
             for (var j = 1; j < 5; j++) {
                document.getElementById("_td-" + j + "-" + i).style.color = "blue";
            }

            if (act == "0") {document.getElementById("_act" + i).src = "../images/noOver.png";}
            else {document.getElementById("_act" + i).src = "../images/yesOver.png";}

            document.getElementById("_modBtn-" + i).style.border = "1px solid #0000ff";
            document.getElementById("_delBtn-" + i).style.border = "1px solid #0000ff";
        }
        else {
            for (var j = 1; j < 5; j++) {
                document.getElementById("td-" + j + "-" + i).style.color = "blue";
            }

            if (act == "0") {document.getElementById("act" + i).src = "../images/noOver.png";}
            else {document.getElementById("act" + i).src = "../images/yesOver.png";}

            document.getElementById("modBtn" + i).style.border = "1px solid #0000ff";
            document.getElementById("delBtn" + i).style.border = "1px solid #0000ff";
        }
    }

    function out(i, x, act) {
        if (x == 1) {
             for (var j = 1; j < 8; j++) {
                document.getElementById("_td-" + j + "-" + i).style.color = "#2f5185";
            }

            if (act == "0") {document.getElementById("_act" + i).src = "../images/no3.png";}
            else {document.getElementById("_act" + i).src = "../images/yes3.png";}

            document.getElementById("_modBtn-" + i).style.border = "";
            document.getElementById("_delBtn-" + i).style.border = "";
        }
        else{
             for (var j = 1; j < 8; j++) {
                document.getElementById("td-" + j + "-" + i).style.color = "#2f5185";
            }

            if (act == "0") {document.getElementById("act" + i).src = "../images/no3.png";}
            else {document.getElementById("act" + i).src = "../images/yes3.png";}

            document.getElementById("modBtn" + i).style.border = "";
            document.getElementById("delBtn" + i).style.border = "";
        }
    }

    function modifyVehicle(i, id) {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "ModifyVehicle.php?id=" + id + "&l=" + lang;
        
    	
    	      
    }

    function filter (term, _id, cellNr){
         if (cellNr == 1) {
            document.getElementById('inp2').value="";
         }
         else {
            document.getElementById('inp1').value="";
         }

	    var suche = term.value.toLowerCase();

        var cnt = 0;
        if (<?php echo pg_num_rows($dsOthV)?> > 0) {
            cnt  = <?php echo $cnt2 ?>
        }
        else {
            cnt = <?php echo $cnt2 ?> - 1
        }

        for (var k=1; k <= cnt; k++) {
	        var table = document.getElementById(_id + k);
	        var ele;

	        for (var r = 2; r < table.rows.length; r++){
		        ele = table.rows[r].cells[cellNr].innerHTML.replace(/<[^>]+>/g,"");
		        if (ele.toLowerCase().indexOf(suche)>=0 )
			        table.rows[r].style.display = '';
		        else table.rows[r].style.display = 'none';
	        }
        }
    }

   
    

    lang1 = '<?php echo $cLang?>';

    $('#addBtn').button({ icons: { primary: "ui-icon-plusthick"} });
    $('#downVeh').button({ icons: { primary: "ui-icon-arrowreturnthick-1-s"} });

    top.HideWait();
    SetHeightLite();
    iPadSettingsLite();

</script>

</html>
