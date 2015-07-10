<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
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
     $driID = getQUERY("dri");
     $cLang = getQUERY("l");
    ?>
     <!--<div style="font-size:14px; font-weight:bold; padding-top:20px; text-align:left; margin-left:35px" class="text2_">
        <%= dic("Fm.AddAllVehicle")%>
    </div>-->
   
     <?php
         opendb();
         $cnt_1 = 1;
         $cnt_ = 0;

         $cnt = 0;
         $cnt1 = 1;
         $cnt2 = 0;
           
         $sqlOU = "select id, name, code from organisation where clientid=" . Session("client_id");
         $dsOU = query($sqlOU);
         
		 while ($drOU = pg_fetch_array($dsOU)) {  
             $cnt = 0;
             $sqlVeh = "select * from vehicles where active='1' and organisationid = " . $drOU["id"] . " and clientid = " . Session("client_id") . " and id not in (select vehicleid from vehicledriver where driverid= " . intval($driID) . ")";
             $dsVeh = query($sqlVeh);
             			 
             If (pg_num_rows($dsVeh) > 0) {
                 $cnt1 = 1;
           
        ?>

       <table id="tab_<?php echo $drOU["id"] ?>" width=550px style="padding-left:35px">
            
           <tr>
                <td valign="bottom" height="2px" style=" " class="text2" colspan="3">&nbsp;</td>
           </tr> 
            
           <tr >
                <td height="22px" style="color:#fff; font-size:12px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b; font-weight:bold; " class="text2" colspan="5">
                    <?php echo $drOU["code"] ?>. <?php echo $drOU["name"] ?>
                </td>
                <!--<td>
                    <button id="addAll<%=cnt %>" style="height:30px; width:35px;" onclick="addAll1(<%=cnt %>)"></button>
                </td>-->
                <td  class="text2"><input id="addAll_<?php echo $drOU["id"] ?>" type="checkbox" onchange="changeAll(<?php echo $drOU["id"] ?>)" value="*" /></td>
           </tr>
            

         <?php
             $paren = "";
             $id = 0;
             
				 while ($rV = pg_fetch_array($dsVeh)) {
	                 $id = $rV["id"];
	 
	                 $model= dlookup("select model from vehicles where id=" . $rV["id"]);
	                 $fuelType = dlookup("select name from fueltypes where id=(select fueltypeid from vehicles where id=" . $rV["id"] . ")");
	                 
	         ?>
	
	             <tr id="Tr1" style="cursor:pointer" class="text2">
	                <td width=35px></td>
	                <td width=70px id="td-1-<?php echo $cnt ?>" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px; height:25px" class="text2;"><?php echo $rV["code"] ?></td>
	                <td width=120px id="td-2-<?php echo $cnt ?>" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px; " class="text2;"><?php echo $rV["registration"] ?></td>
	              <td width=350px style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px; height:25px"><div style="float:left; font-weight:bold"><?php echo $model ?></div><div style="float:left;">&nbsp;(<?php echo $fuelType ?>)</div></td>
	             
	
	             <td id="Td2" class="text2"><input id="addOne_<?php echo $drOU["id"] ?>_<?php echo $cnt ?>" type="checkbox" value="<?php echo $rV["id"] ?>"/></td>
	            </tr>
	       
	                 <?php
	                    $cnt = $cnt + 1;
	                    $cnt1 = $cnt1 + 1;
	                 } //end while

             	?>

        </table>

        <?php
            $cnt2 = $cnt2 + 1;
        	} //end if
        } //end while

			    $sqlOthV = "select distinct organisationid from vehicles where active='1' and clientid = " . Session("client_id") . " and organisationid not in 
			    (select id from organisation where clientid=" . Session("client_id") . ")";
			    $dsOthV = query($sqlOthV);
		    
		        If (pg_num_rows($dsOthV) > 0) {
         ?>

         <table id="tab_*" width=550px style="padding-left:35px">

           <tr>
                <td valign="bottom" height="2px" style=" " class="text2" colspan="3">&nbsp;</td>
           </tr> 
                      
            <tr >
            
                <td height="22px" style="color:#fff; font-size:12px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b; font-weight:bold; " class="text2" colspan="5">
                   <?php echo dic("Settings.OtherVehicles")?>
                </td>
                <td  class="text2"><input id="addAll-*" type="checkbox" onchange="changeAll1()" value="*" /></td>
           </tr>

                 <?php
                     $sqlOV = "";
                     $paren = "";
                     $id = 0;
                     
                     $cnt_1 = $cnt;
                     
					 while ($drOthV = pg_fetch_array($dsOthV)) {
                         $sqlOV = "select * from vehicles where active='1' and organisationid=" . $drOthV["organisationid"] . " and clientid = " . Session("client_id") . " 
                         and id not in (select vehicleid from vehicledriver where driverid= " . intval($driID) . ")";
                         $dsOV = query($sqlOV);
                         
						 while ($drOV = pg_fetch_array($dsOV)) {
                             $id = $drOV["id"];
                             
                             $model = dlookup("select model from vehicles where id=" . $drOV["id"]);
                             $fuelType = dlookup("select name from fueltypes where id=(select fueltypeid from vehicles where id=" . $drOV["id"] . ")");  
                             
                    ?>
                             
               <tr id="Tr3" style="cursor:pointer" class="text2">
                <td width=35px></td>
                <td width=70px id="td3" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px; height:25px" class="text2;"><?php echo $drOV["code"] ?></td>
                <td width=120px id="td-2-<?php echo $cnt ?>" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px; " class="text2;"><?php echo $drOV["registration"] ?></td>
             <td width=350px style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:7px; height:25px"><div style="float:left; font-weight:bold"><?php echo $model?></div><div style="float:left;">&nbsp;(<?php echo $fuelType ?>)</div></td>
             <td id="Td2" class="text2"><input id="addOne1_*_<?php echo $cnt_ ?>" type="checkbox" value="<?php echo $drOV["id"] ?>"/></td>
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


</body>

<script>
//alert(document.getElementById('orgUnit').options[ocument.getElementById('orgUnit').selectedIndex].value);

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

         debugger;
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
