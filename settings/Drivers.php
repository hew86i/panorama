<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php opendb();?>

<?php 
	header("Content-type: text/html; charset=utf-8");
	opendb();
	$Allow = getPriv("employees", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
	
	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	$yourbrowser1 = (bool) strpos($ua['userAgent'], "Macintosh");
	
	addlog(44);
	
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
	<script type="text/javascript" src="fm.js"></script>
	<script type="text/javascript" src="./js/highcharts.src.js"></script>

  
    <link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="../js/jquery-ui.js"></script>
    <style type="text/css">
	<?php
	if($yourbrowser == "1")
	{
	?>
		html { 
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch; 
		}
		body {
		    height: 100%;
		    overflow: auto; 
		    -webkit-overflow-scrolling: touch;
		}
	<?php
	}
	?>
	</style>
	<style type="text/css"> 
 		body{ overflow-y:auto }
	</style>
	
	
 <body>
 	
 <?php
     $cnt_1 = 1;
     $cnt_ = 1;
 ?>
 <div id="div-add" style="display:none" title=""></div>
    <div id="dialog-message" title="<?php dic("Reports.Message")?>" style="display:none">
         <p>
	        <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
	        <div id="div-msgbox" style="font-size:14px"></div>
        </p>
    </div>
    <!--div id="report-content" style="width:100%; background-color:#fafafa; margin-bottom:50px; overflow-y:hidden; overflow-x:hidden" class="corner5"-->
	    <div class="textTitle" style="padding-left:35px; padding-top:30px;"><?php echo dic_("Fm.Employees")?><br /></div>
			<table width="94%" style="margin-left:32px; margin-top:30px; ">
				<tr class="text2" >
                     <td align = "center" width="80%"></td>
                     <td align = "center" width="10%"><?php dic("SearchEmployeeID") ?>:</td>
                	 <td align = "center" width="10%"><?php dic("Fm.SearchName") ?>:</td>
                </tr>
	       		<tr class="text2" >
				     <td align = "left"><button id="addBtn" onclick="addDriver()" ><?php dic("Fm.AddDri") ?></button></td>
	                 <td align = "center"><input id="inp1" name="filter" onkeyup="filter(this, 'tabId', 0)" type="text" size=22 style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/></td>
	                 <td align = "center"><input id="inp2" name="filter" onkeyup="filter(this, 'tabId', 1)" type="text" size=22 style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/></td>
	            </tr>
            </table>

		<?php
            $datetimeformat = dlookup("select datetimeformat from users where id=" . session('user_id'));
            $datfor = explode(" ", $datetimeformat);
            $dateformat = $datfor[0];
            $timeformat =  $datfor[1];
            if ($timeformat == 'h:i:s') {
                $timeformat = $timeformat . " A";
                $datetimeformat = $datetimeformat . " A";
            }
		   $cnt  = 1;
           $cnt1 = 1;
           $cnt2 = 1;
           
           $sqlOU = "select id, name, code from organisation where clientid=" . Session("client_id");
           $dsOU = query($sqlOU);
           
		   while ($drOU = pg_fetch_array($dsOU)) { 
         		$sqlDri = "select * from drivers where organisationid = " . $drOU["id"] . " and clientid = " . Session("client_id")." order by code";
                $dsDri = query($sqlDri);
				
               If (pg_num_rows($dsDri) > 0) {
                   $cnt1 = 1;
           
        ?>
       
        <table id="tabId<?php echo $cnt2 ?>" width="94%" border="0" cellspacing="2" cellpadding="2" style="margin-top:30px; margin-left:35px">
            <tr>
            <td height="22px" class="text2" colspan=9 style="color:#fff; font-weight:bold; font-size:14px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b; font-weight:bold;"><?php echo $drOU["code"] ?> . <?php echo $drOU["name"] ?></td>
            </tr>
           
            <tr>
         		<td width="7%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;" ><?php dic("Settings.EmployeeID")?></td>
                <td width="16%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.FullName")?></td> 
                <td width="16%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.OrgUnit")?></td>
                <td width="16%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.DateBorn")?></td>
                <td width="12%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.LicenceType")?></td>
                <td width="15%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.IstekVoz")?></td>
                <td width="8%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633"><?php dic("Fm.Mod")?></td>
                <td width="8%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633"><?php dic("Fm.Delete")?></td>
            </tr>

         <?php

             $paren = "";
             $id = 0;
             
			 while ($rD = pg_fetch_array($dsDri)) { 
                 $id = $rD["id"];
 
                 ?>
                 
             <tr id="veh<?php echo $cnt ?>" style="cursor:pointer" onmouseover="over(<?php echo $cnt ?>)" onmouseout="out(<?php echo $cnt ?>)">
               
                <td id="td-1-<?php echo $cnt ?>" width="6%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo nnull($rD["code"], "/") ?></td>
                <td id="td-2-<?php echo $cnt ?>" width="16%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo nnull($rD["fullname"], "/") ?></td>
                <td id="td-3-<?php echo $cnt ?>" width="16%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo $drOU["name"]?></td>          
                <td id="td-4-<?php echo $cnt ?>" width="16%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo DateTimeFormat($rD["borndate"], $dateformat)?></td>
                <td id="td-5-<?php echo $cnt ?>" width="12%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo nnull($rD["licensetype"], "/")?></td>
                <td id="td-6-<?php echo $cnt ?>" width="15%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo DateTimeFormat($rD["licenseexp"], $dateformat) ?></td>
                <td id="td-7-<?php echo $cnt ?>" width="8%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                    <button id="modBtn<?php echo $cnt ?>" onclick="modifyDriver(<?php echo $cnt ?>, <?php echo $id ?>)" style="height:22px; width:30px"></button>
                </td>
                <td id="td-8-<?php echo $cnt ?>" width="8%" height="30px" align="center" class="text2 <?php echo $paren ?>" style="background-color:#fff; border:1px dotted #B8B8B8;">
                    <button id="delBtn<?php echo $cnt ?>" onclick="del(<?php echo $rD["id"] ?>, '<?php echo $cLang ?>', 'drivers')" style="height:22px; width:30px"></button>
                </td>
            </tr>

                 <?php
                     $cnt = $cnt + 1;
                     $cnt1 = $cnt1 + 1;
                 } //end while
               ?>
             
        </table>

        <?php
            $cnt2 = $cnt2 + 1;
        } 
        } //end while
 
        
    $sqlOthD = "select distinct organisationid from drivers where clientid = " . Session("client_id") . " and organisationid not in 
    (select id from organisation where clientid=" . Session("client_id") . ")";
    $dsOthD = query($sqlOthD);
		
	
            If (pg_num_rows($dsOthD) > 0) {
            ?>
			<table id="tabId<?php echo $cnt2 ?>" width="94%" border="0" cellspacing="2" cellpadding="2" style="margin-top:30px; margin-left:35px">
            <tr><td height="22px" class="text2" colspan=9 style="color:#fff; font-weight:bold; font-size:14px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b;"><?php dic("Fm.UngroupedDri") ?></td></tr>
         
			<tr>
          	    <td width="7%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.EmployeeID") ?></td>
                <td width="16%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.FullName") ?></td> 
                <td width="16%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.OrgUnit") ?></td>
                <td width="16%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.DateBorn") ?></td>
                <td width="12%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.LicenceType") ?></td>
                <td width="15%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Fm.IstekVoz") ?></td>
                <td width="8%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633"><?php dic("Fm.Mod") ?></td>
                <td width="8%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633"><?php dic("Fm.Delete")?></td>
           </tr>

				 <?php
                     $sqlOD = "";
                     
                     $paren = "";
                     $id = 0;
                     
                     $cnt_1 = $cnt;
                     					 
					 while ($drOthD = pg_fetch_array($dsOthD)) {
                         $sqlOD = "select * from drivers where organisationid=" . $drOthD["organisationid"] . " and clientid=" . Session("client_id");
                         $dsOD = query($sqlOD);
                         
                      	 while ($drOD = pg_fetch_array($dsOD)) {
                             $id = $drOD["id"];
                          ?>
                             
              	<tr id="veh<?php echo $cnt_1 ?>" style="cursor:pointer" onmouseover="over(<?php echo $cnt_ ?>, 1)" onmouseout="out(<?php echo $cnt_ ?>, 1)">
       			<td id="_td-1-<?php echo $cnt_ ?>" width="6%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo $drOD["code"] ?></td>
                <td id="_td-2-<?php echo $cnt_ ?>" width="16%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo $drOD["fullname"] ?></td>
                <td id="_td-3-<?php echo $cnt_ ?>" width="16%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo nnull($drOU["name"], "/") ?></td>          
                <td id="_td-4-<?php echo $cnt_ ?>" width="16%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo DateTimeFormat($drOD["borndate"], $dateformat) ?></td>
                <td id="_td-5-<?php echo $cnt_ ?>" width="12%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo nnull($drOD["licensetype"], "/")?></td>
                <td id="_td-6-<?php echo $cnt_ ?>" width="15%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo DateTimeFormat($drOD["licenseexp"], $dateformat) ?></td>
                <td id="_td-7-<?php echo $cnt_ ?>" width="8%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                    <button id="_modBtn-<?php echo $cnt_ ?>" onclick="modifyDriver(<?php echo $cnt_1 ?>, <?php echo $id ?>)" style="height:22px; width:30px"></button>
                </td>
                <td id="td-8-<?php echo $cnt ?>" width="8%" height="30px" align="center" class="text2 <?php echo $paren ?>" style="background-color:#fff; border:1px dotted #B8B8B8;">
                    <button id="_delBtn-<?php echo $cnt_ ?>" onclick="del(<?php echo $drOD["id"] ?>, '<?php echo $cLang ?>', 'drivers')" style="height:22px; width:30px"></button>
                </td>
            </tr>

                             <?php
                                 $cnt_ = $cnt_ + 1;
                                 $cnt_1 = $cnt_1 + 1;
                         } //end while
                     } //end while
             	 } //end if
                   
				 closedb();
                 ?>
                 </table>
      
        <br /><br />
   
</body>

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

    function over(i, x, act, gps) {
        if (x == 1) {
             for (var j = 1; j < 5; j++) {
                document.getElementById("_td-" + j + "-" + i).style.color = "blue";
            }
			document.getElementById("_modBtn-" + i).style.border = "1px solid #0000ff";
            document.getElementById("_delBtn-" + i).style.border = "1px solid #0000ff";
        }
        else {
            for (var j = 1; j < 5; j++) {
                document.getElementById("td-" + j + "-" + i).style.color = "blue";
            }

           
            document.getElementById("modBtn" + i).style.border = "1px solid #0000ff";
            document.getElementById("delBtn" + i).style.border = "1px solid #0000ff";
        }
    }

    function out(i, x, act, gps) {
        if (x == 1) {
             for (var j = 1; j < 8; j++) {
                document.getElementById("_td-" + j + "-" + i).style.color = "#2f5185";
            }

            document.getElementById("_modBtn-" + i).style.border = "";
            document.getElementById("_delBtn-" + i).style.border = "";
        }
        else{
             for (var j = 1; j < 8; j++) {
                document.getElementById("td-" + j + "-" + i).style.color = "#2f5185";
            }

            document.getElementById("modBtn" + i).style.border = "";
            document.getElementById("delBtn" + i).style.border = "";
        }
    }

    function modifyDriver(i, id) {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "ModifyDriver.php?id=" + id + "&l=" + lang;
    }

    function filter (term, _id, cellNr){
         if (cellNr == 0) {
            document.getElementById('inp2').value="";
         }
         else {
            document.getElementById('inp1').value="";
         }

	    var suche = term.value.toLowerCase();

        var cnt = 0;
        if (<?php echo pg_num_rows($dsOthD) ?> > 0) {
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

    
    lang1 = '<?php echo $cLang ?>';

    $('#addBtn').button({ icons: { primary: "ui-icon-plusthick"} });


    top.HideWait();
    SetHeightLite();
    iPadSettingsLite();

</script>


</html>
