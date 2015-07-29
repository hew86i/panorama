<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	$yourbrowser1 = (bool) strpos($ua['userAgent'], "Macintosh");
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
	<script type="text/javascript" src="../js/settings.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	<style type="text/css">
	<?php
	if($yourbrowser == "1")
	{?>
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
    <script type="text/javascript" src="../pdf/pdf.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="fm.js"></script>
	<script type="text/javascript" src="./js/highcharts.src.js"></script>
  
    <link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
    <script src="../js/jquery-ui.js"></script>
	<style type="text/css"> 
 		body{ overflow-y:auto }
	</style>
 <body>
 
    <?php
        $vehID = getQUERY("veh");
        $cLang = getQUERY("l");
     
        $cnt_1 = 1;
        $cnt_ = 0;

        $cnt = 0;
        $cnt1 = 1;
        $cnt2 = 0;
           
        opendb();
           
        $sqlOU = "select id, name, code from organisation where clientid=" . Session("client_id");
        $dsOU = query($sqlOU);
         
        while ($drOU = pg_fetch_array($dsOU)) {  
             $cnt = 0;
             $sqlDri = "select * from drivers where organisationid = " . $drOU["id"] . " and clientid = " . Session("client_id") . " 
             and id not in (select driverid from vehicledriver where vehicleid= " . intval($vehID) . ")";
                       
             $dsDri = query($sqlDri);
             If (pg_num_rows($dsDri) > 0) {
                 $cnt1 = 1;
        ?>

       <table id="tab_<?php echo $drOU["id"] ?>" width=350px style="padding-left:35px">
            
           <tr>
                <td valign="bottom" height="2px" style=" " class="text2" colspan="3">&nbsp;</td>
           </tr> 
            
           <tr >
                <td height="22px" style="color:#fff; font-size:12px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b; font-weight:bold; " class="text2" colspan="4">
                    <?php echo nnull($drOU["code"], "/") ?>. <?php echo nnull($drOU["name"], "/") ?>
                </td>
                
                <td  class="text2"><input id="addAll_<?php echo $drOU["id"] ?>" type="checkbox" onchange="changeAll(<?php echo $drOU["id"] ?>)" value="*" /></td>
           </tr>
            
         <?php
             $paren = "";
             $id = 0;
             
			 while ($rD = pg_fetch_array($dsDri)) {  
                 $id = $rD["id"];
 
             ?>

             <tr id="Tr1" style="cursor:pointer" class="text2">
                <td width=35px></td>
                <td width=70px id="td-1-<?php echo $cnt ?>" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px; height:25px" class="text2;"><?php echo nnull($rD["code"], "/")?></td>
                <td width=140px id="td-2-<?php echo $cnt ?>" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px; " class="text2;"><?php echo nnull($rD["fullname"], "/")?></td>
             <td id="Td2" class="text2"><input id="addOne_<?php echo $drOU["id"] ?>_<?php echo $cnt ?>" type="checkbox" value="<?php echo $rD["id"] ?>"/></td>
            </tr>

       
                 <?php
                     $cnt = $cnt + 1;
                     $cnt1 = $cnt1 + 1;
                 } // end while
               ?>

        </table>

        <?php
            $cnt2 = $cnt2 + 1;
        } //end if
        } //end while

        $sqlOthD = "select distinct organisationid from drivers where clientid = " . Session("client_id") . " 
        and organisationid not in (select id from organisation where clientid=" . Session("client_id") . ")";
		$dsOthD = query($sqlOthD);
		
		
		//new!
		$cntOthD = "select count(*) from drivers where organisationid in (
		select distinct organisationid from drivers where clientid = " . Session("client_id") . " and 
		organisationid not in (select id from organisation where clientid=" . Session("client_id") . ") )
		and clientid = " . Session("client_id") . " and id not in (select driverid from vehicledriver where vehicleid= " . $vehID . ") ";
   		$cntOthDrivers = dlookup($cntOthD);
        //new!	
		
		//if(pg_num_rows($dsOthD) > 0) {				
        If ($cntOthDrivers > 0) {
        	
       ?>

         <table id="tab_*" width=350px style="padding-left:35px">

           <tr>
                <td valign="bottom" height="2px" style=" " class="text2" colspan="3">&nbsp;</td>
           </tr> 
                      
            <tr >
            
                <td height="22px" style="color:#fff; font-size:12px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b; font-weight:bold; " class="text2" colspan="4">
                   <?php echo dic("Settings.OtherDrivers")?>
                </td>
                <td  class="text2"><input id="addAll-*" type="checkbox" onchange="changeAll1()" value="*" /></td>
           </tr>

                 <?php
                     $sqlOD = "";
                     $paren = "";
                     $id = 0;
                     
                     $cnt_1 = $cnt;
                     
					 while ($drOthD = pg_fetch_array($dsOthD)) {  
                         $sqlOD = "select * from drivers where organisationid=" . $drOthD["organisationid"] . " and clientid = " . Session("client_id") . 
                         " and id not in (select driverid from vehicledriver where vehicleid= " . intval($vehID) . ")";
                         $dsOD = query($sqlOD);
                        
						 while ($drOD = pg_fetch_array($dsOD)) {
                             $id = $drOD["id"];
                            
                    ?>
                             
               <tr id="Tr3" style="cursor:pointer" class="text2">
                <td width=35px></td>
                <td width=70px id="td3" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px; height:25px" class="text2;"><?php echo $drOD["code"]?></td>
                <td width=140px id="td-2-<?php echo $cnt ?>" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px; " class="text2;"><?php echo $drOD["fullname"]?></td>
             <td id="Td2" class="text2"><input id="addOne1_*_<?php echo $cnt_ ?>" type="checkbox" value="<?php echo $drOD["id"] ?>"/></td>
            </tr>
                           
                             <?php
                                 $cnt_ = $cnt_ + 1;
                                 $cnt_1 = $cnt_1 + 1;
                         } //end while
                     } //end while
             }
                                                
                 ?>
                 </table>
   
    
    <?php
    	closedb();
    ?>
</body>

<script>

	lang = '<?php echo $cLang?>';
for (var i=0; i < <?php echo $cnt ?>; i++) {
        $('#addOne' + i).button({ icons: { primary: "ui-icon-plusthick"} })
       $('#addAll' + i).button({ icons: { primary: "ui-icon-plusthick"} }) 
        }

        if (<?php echo $cnt_ ?> > 0) {
            for (var i=0; i < <?php echo $cnt_ ?>; i++) {
                $('#addOne-' + i).button({ icons: { primary: "ui-icon-plusthick"} })
                $('#addAll-' + i).button({ icons: { primary: "ui-icon-plusthick"} }) 
            }
        }

        var cntTimes = 0
        function addAll1(cnt) {
           
            if (cntTimes % 2 == 0) {
                 $('#addAll' + cnt).button({ icons: { primary: "ui-icon-check"} }) 
            }
            else {
                 $('#addAll' + cnt).button({ icons: { primary: "ui-icon-plusthick"} }) 
            }
            cntTimes = cntTimes + 1

           
        }


         if (document.getElementById('addAll_' + (parseInt(document.getElementById('orgUnit').options[document.getElementById('orgUnit').selectedIndex].value))) != null) {
           document.getElementById('addAll_' + (parseInt(document.getElementById('orgUnit').options[document.getElementById('orgUnit').selectedIndex].value))).checked = "checked"


              for (var i = 0; i < document.getElementById('tab_' + parseInt(document.getElementById('orgUnit').options[document.getElementById('orgUnit').selectedIndex].value)).children[0].children.length - 2; i++) {
                   if (document.getElementById("addOne_" + parseInt(document.getElementById('orgUnit').options[document.getElementById('orgUnit').selectedIndex].value) + "_" + i) != null) {
                   document.getElementById("addOne_" + parseInt(document.getElementById('orgUnit').options[document.getElementById('orgUnit').selectedIndex].value) + "_" + i).checked = "checked";
                   }
                }
      }
      
  
      
      function changeAll(c) {
            var id = "addAll_" + c;
          
            if (document.getElementById('' + id).checked == true) {
            	
                for (var i = 0; i < document.getElementById('tab_' + c).children[0].children.length - 2; i++) {      
                    document.getElementById("addOne_" + c + "_" + i).checked = "checked";
                }
            }

           if (document.getElementById('' + id).checked == false) {
                for (var i = 0; i < document.getElementById('tab_' + c).children[0].children.length - 2; i++) {     
                         document.getElementById("addOne_" + c + "_" + i).checked = false;
                    }
            }
            
      }

        function changeAll1() {
            var id = "addAll-*";

            if (document.getElementById("" + id).checked == true) {
                for (var i = 0; i < document.getElementById('tab_*').children[0].children.length - 2; i++) {    
                     document.getElementById("addOne1_*_" + i).checked = "checked";
                }
            }

           if (document.getElementById('' + id).checked == false) {
                for (var i = 0; i < document.getElementById('tab_*').children[0].children.length - 2; i++) {     
                         document.getElementById("addOne1_*_" + i).checked = false;
                    }
            }
        }

</script>
</html>
