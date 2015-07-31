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
	<script type="text/javascript" src="fm.js"></script>
	<script type="text/javascript" src="./js/highcharts.src.js"></script>
	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="./js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
    <script src="../js/jquery-ui.js"></script>
    
	<style type="text/css"> 
 		body{ overflow-y:auto }
	</style>
 <body>
     <?php
         //$LastDay = DateTimeFormat(addDay(-1), "d-m-Y");
         $id = getQUERY("id");
      
      	 opendb();
		
      $datetimeformat = dlookup("select datetimeformat from users where ID = " . session("user_id"));
      $datfor = explode(" ", $datetimeformat);
      $dateformat = $datfor[0];
      $timeformat =  $datfor[1];
      if ($timeformat == 'h:i:s') $timeformat = $timeformat . " A";
      if ($timeformat == "H:i:s") {
        $tf = " H:i";
      } else {
        $tf = " h:i A";
      }
      $datejs = str_replace('d', 'dd', $dateformat);  
      $datejs = str_replace('m', 'mm', $datejs);
      $datejs = str_replace('Y', 'yy', $datejs);
     $americaUser = dlookup("select count(*) from cities where id = (select cityid from users where id=".session("user_id").") and countryid = 4");
     $americaUserStyle = "";
     if ($americaUser == 1) $americaUserStyle = "display: none";

         $fullName = nnull(dlookup("select fullname from drivers where id=" . $id), "");
         $code = nnull(dlookup("select code from drivers where id=" . $id), "");
         $bornDate = DateTimeFormat(nnull(dlookup("select borndate from drivers where id=" . $id), addDay(-1)), $dateformat);
         $dlnumber = nnull(dlookup("select dlnumber from drivers where id=" . $id), "");
         $gender = nnull(dlookup("select gender from drivers where id=" . $id), "");
         $startCom = DateTimeFormat(nnull(dlookup("select startincompany from drivers where id=" . $id), addDay(-1)), $dateformat);
         $contract = nnull(dlookup("select jobcontract from drivers where id=" . $id), "");
         $rfId = nnull(dlookup("select rfid from drivers where id=" . $id), "");
         $licenceCat = nnull(dlookup("select licensetype from drivers where id=" . $id), "");
         $firstLicence = DateTimeFormat(nnull(dlookup("select firstlicense from drivers where id=" . $id), addDay(-1)), $dateformat);
         $licExpir = DateTimeFormat(nnull(dlookup("select licenseexp from drivers where id=" . $id), addDay(-1)), $dateformat);
         $interLicence = nnull(dlookup("select interlicense from drivers where id=" . $id), "0");
         $IntLicExp = DateTimeFormat(nnull(dlookup("select interlicenseexp from drivers where id=" . $id), addDay(-1)), $dateformat);
         $orgUnit = nnull(dlookup("select organisationid from drivers where id=" . $id), "");
         $checkOrg = dlookup("select count(*) from organisation where id=" . $orgUnit);
      ?>
        <div id="div-add" style="display:none" title="<?php dic("Fm.AddAllVehicle") ?>"></div>
        <div id="dialog-message" title="<?php dic("Reports.Message")?>" style="display:none">
             <p>
	             <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
	             <div id="div-msgbox" style="font-size:14px"></div>
             </p>
        </div>
    
    
    <table style="padding-left:40px;" class="text2_">
    <tr>
    <td width="50%" align="left"><div class="textTitle" style="padding-top:10px;"><?php echo dic_("Fm.ModDri")?></div></td>
    <td colspan="5" width="50%" align="right">
    	<div style=" margin-top:15px; ">
              <button id="mod2" onclick="modify()"><?php dic("Fm.Mod") ?></button>
              <button id="cancel2" onclick="cancel()"><?php dic("Fm.Cancel") ?></button>
        </div></td>
    </tr>
    <tr>
    	<td width="50%" align="left"><div class="textTitle" style="padding-top:10px; font-size:16px"><?php echo $fullName ?></div></td>
    	<td width="50%"></td>
    	<td></td>
	    <td></td>
	    <td></td>
	    <td></td>
	    <td></td>
	</tr>
	</table>
    
    <br/>
    <table style="padding-left:40px;" class="text2_">
                  <tr style="height:10px"></tr>
                  <tr>
                      <td width = "210" style="font-weight:bold"><?php dic("Fm.FullName")?>:</td>
                      <td width = "210" style="padding-left:10px"><input id="FullName" type="text" value="<?php echo $fullName ?>" size=22 style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/></td>
                      <td width = "210" style="font-weight:bold; "><?php dic("Fm.DurContract")?>:</td>
                      <td width = "210" style="padding-left:10px">
                         <select id="durContract" style="width: 161px; font-size: 11px; position: relative; top: 0px; z-index: 1; visibility: visible;" class="combobox text2">
                                 <option id="opt0" value="1">1 <?php dic("Fm.Month") ?>  
                                 <option id="opt1" value="3">3 <?php dic("Fm.Months") ?>  
                                 <option id="opt2" value="6">6 <?php dic("Fm.Months") ?>  
                                 <option id="opt3" value="12">1 <?php dic("Fm.Year") ?> 
                                 <option id="opt4" value="0"><?php dic("Fm.Indef") ?> 
                            </select>
                      </td>
                  </tr>
                  <tr>
                      <td width = "210" style="font-weight:bold"><?php dic("Settings.EmployeeID")?>:</td>
                      <td width = "210" style="padding-left:10px"><input id="code" type="text" value="<?php echo $code ?>" size=22 style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/></td>
                      <td width = "210" style="font-weight:bold; "><?php dic("Fm.LicenceType") ?>:</td>
                      <td width = "210" colspan="6" style="padding-left:10px">
                          <input id="cat0" type="checkbox" name="category" value="A" />A
                          <input id="cat1" type="checkbox" name="category" value="B" checked=checked style="margin-left:7px" />B
                          <input id="cat2" type="checkbox" name="category" value="C" style="margin-left:7px" />C
                          <input id="cat3" type="checkbox" name="category" value="D" style="margin-left:7px" />D
                          <input id="cat4" type="checkbox" name="category" value="E" style="margin-left:7px" />E
                      </td>
                 </tr>
                 <tr>
                  	  <td width = "210" style="font-weight:bold;"><?php dic("Fm.OrgUnit")?>:</td>
                      <td width = "210" style="padding-left:10px">
                           <select id="orgUnit" style="width: 161px; font-size: 11px; position: relative; top: 0px; z-index: 999; visibility: visible;" class="combobox text2">
                                 
                                 <?php
                                     $units = "select id, name from organisation where clientid=" . Session("client_id");
                                     $dsUnits = query($units);
									 $c = 0;
									 
									 while ($drUnits = pg_fetch_array($dsUnits)) {
                                  ?>
                                     <option id="opt-<?php echo $c ?>" value="<?php echo $drUnits["id"] ?>"><?php echo $drUnits["name"]?></option>
                                  <?php
                                         $c = $c + 1;
                                  }
                                  ?>   
                                  <option id="opt-0" value="0"><?php dic("Fm.UngroupedDri") ?></option>
                                  
                            </select>
                       </td>                     
				            	<td width = "210" style="font-weight:bold; "><?php dic("Settings.DLNumber")?>:</td>
                      <td width = "210" style="padding-left:10px">
                         <input id="dlnumber" type="text" value="<?php echo $dlnumber ?>" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px" />
                      </td>
                  </tr>
                  <tr>
                 	  <td width = "210" style="font-weight:bold"><?php dic("Fm.DateBorn")?>:</td>
                      <td width = "210" style="padding-left:10px">
                            <input id="dateBorn" type="text" class="textboxCalender1 text2" value="<?php echo $bornDate ?>" />
                      </td>
					  <td width = "210" style="font-weight:bold;"><?php dic("Fm.FirstLicence")?>:</td><td width = "210" style="padding-left:10px">
                            <input id="firstLicence" type="text" class="textboxCalender1 text2" value="<?php echo $firstLicence?>" />
                      </td>
                  </tr>
                  <tr>
                  	  <td width = "210" style="font-weight:bold"><?php dic("Fm.Gender")?>:</td><td width = "210" style="padding-left:10px">
                      	 <?php
                         if($gender == "M")
						 {
                       	 ?>
                         <input type="radio" name="gender" value="M" checked=checked /><?php dic("Fm.Male")?>
                         <input type="radio" name="gender" value="F" style="margin-left:20px"/><?php dic("Fm.Female") ?>
                         <?php
	                     } 
	                     else
						 {
	                     ?>
                            <input type="radio" name="gender" value="M"  /><?php dic("Fm.Male")?>
                            <input type="radio" name="gender" value="F" checked=checked style="margin-left:20px"/><?php dic("Fm.Female") ?>
                             <?php
                         } 
                         ?>
                      </td>
					 <td width = "210" style="font-weight:bold; "><?php dic("Fm.IstekVoz")?>:</td>
                     <td width = "210" style="padding-left:10px">
                        <input id="licenceExpire" type="text" class="textboxCalender1 text2" value="<?php echo $licExpir?>" />
                     </td>
                  </tr>
				  <tr>
					  <td width = "210" style="font-weight:bold">RFID:</td>
            <td width = "210" style="padding-left:10px">
                <input id="RfId" type="text" value="<?php echo $rfId ?>" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px" />
            </td>
            <?php
             if ($americaUser == 1) {
            ?>
             <td width = "210" style="font-weight:bold;"><?php dic("Fm.StartCom")?>:</td>
             <td width = "210" style="padding-left:10px;">
                <input id="startCom" type="text" class="textboxCalender1 text2" value="<?php echo $startCom ?>" style="z-index:999;" />
             </td>
            <?php   

             } else {
            ?>
             <td width = "210" style="font-weight:bold;"><?php dic("Fm.IntLicence")?>:</td>
             <td width = "210" style="padding-left:10px;">
                                           
              <?php
              If($interLicence == 1) 
              {
              ?>
                   <input type="radio" name="interLicence" value="1" onmousedown="ShowHideRow()" /><?php dic("Fm.Yes") ?>
                   <input type="radio" name="interLicence" value="0" checked="checked" style="margin-left:20px" onmousedown="ShowHideRow()" /><?php dic("Fm.No") ?>
              <?php
              } else {
              ?>
                   <input type="radio" name="interLicence" value="1"  onmousedown="ShowHideRow()" /><?php dic("Fm.Yes") ?>
                   <input type="radio" name="interLicence" value="0" checked="checked" style="margin-left:20px" onmousedown="ShowHideRow()" /><?php dic("Fm.No") ?>
              <?
              } 
              ?>
              </td>
            <?php 
             } 
            ?>
                      
                   </tr>


                   <tr style="<?= $americaUserStyle?>">
                     <td width = "210" style="font-weight:bold"><?php dic("Fm.StartCom")?>:</td>
                     <td width = "210" style="padding-left:10px">
                         <input id="startCom" type="text" class="textboxCalender1 text2" value="<?php echo $startCom ?>" style="z-index:999;" />
                      </td>
                     <td id="IntLicExp11" width = "210" style="display:none; font-weight:bold; "><?php echo dic("Settings.ExpiryDrivingLicense")?>:</td>
                     <td id="IntLicExp12" width = "210" style="display:none; padding-left:10px">
                          <input id="IntLicExp" type="text" class="textboxCalender1 text2" value="<?php echo $IntLicExp?>" />
                     </td>
                 </tr>

                   <?php
                   $allowdriverasuser = dlookup("select allowdriverasuser from clients where id=".session("client_id"));
				   if ($allowdriverasuser == '1') {
				   	   $dsDriverAsUser = query("select * from driverasuser where driverid=".$id);
					   $dUsername = ""; 
					   $dPassword = "";
					   if (pg_num_rows($dsDriverAsUser) > 0) {
					   	$dUsername = pg_fetch_result($dsDriverAsUser, 0, "username");
					   	$dPassword = pg_fetch_result($dsDriverAsUser, 0, "password");
					   }
                   ?>
                   <tr>
					  <td width = "210" style="font-weight:bold"><?php echo dic_("Login.Username")?>:</td>
					  <td width = "210" style="padding-left:10px">
                          <input id="dUsername" type="text" value="<?php echo $dUsername ?>" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px" /><span style="color: red;width: 1%; padding-left: 0px"> *</span>
                      </td>
                      <td width = "210" style="font-weight:bold; "><?php echo dic_("Login.Password")?>:</td>
                      <td width = "210" style="padding-left:10px">
                     	 <input id="dPassword" type="text" value="<?php echo $dPassword ?>" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px" /><span style="color: red;width: 1%; padding-left: 0px"> *</span>
                      </td>
                   </tr>
                   <tr>
                   	<td colspan=2></td>
                   	<td colspan=2 style="color: red; font-size: 10px; font-style: italic"><?php echo dic("Settings.PasswordMust")?>.</td>
                   </tr>
                   <?php
                   }
                   ?>
				        
	               
                   <tr style="height:70px;">
                       <td colspan=6><div style="border-bottom:1px solid #bebebe"></div></td>
                   </tr>
                   <tr>
                       <td colspan=4>
                            <table id="allVehicles" style="padding-bottom:15px; padding-right:15px" >
                                 <tr>
                                 	<td colspan=2 class="textTitle" style="font-size:16px;"><?php dic("Fm.AllVehicles") ?></td>
                                 </tr>
                                 
                                 <tr>
                                 <td id="btnAddVehicles" class="textTitle" style="font-size:16px;">
                                      <button id="addAllVeh" style="margin-top:10px;" onclick="addAllVehicle('<?php echo $cLang ?>', <?php echo $id ?>)"><?php dic("Fm.Add") ?></button>
                                 </td>
                                 <td></td>
                                 </tr>
                                 
                                 <tr>
                                 	<td colspan=2 style="height:15px"></td>
                                 </tr>
                                 
  	  <?php

	  $sqlAllVeh = "select * from vehicledriver where driverid = " . $id . " and (select coalesce(active, '0') from vehicles where id = vehicleid) = '1'";
      $dsAV = query($sqlAllVeh);

      $idVehicle = 0;
      $sqlVehicles = "";
      $cnt1 = 0;
      $classTable = "";
    
	  If (pg_num_rows($dsAV) > 0) {
      ?>
      <tr class="text2" style="font-weight:bold; background:#dadada; height:22px">
         <td align=left style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px; width:80px"><?php dic("Fm.Code") ?></td>
         <td align=center style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; width:130px"><?php dic("Fm.Registration") ?></td>
         <td align=left style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px; width:240px"><?php dic("Fm.Desc")?></td>
         <td align=center style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; width:67px; color:#ff6633"><?php dic("Fm.Delete")?></td>
  	  </tr>
                               
      <?php
		 while ($drAv = pg_fetch_array($dsAV)) {

        	  $idVehicle = $drAv["vehicleid"];
         	  $sqlVehicles = "select id, registration, code, model, fueltypeid from vehicles where id=" . $idVehicle;                                                           
          	  $dsVehicles = query($sqlVehicles);
			  
              If ($cnt1 % 2 == 0) {
                  $classTable = "tableCellNeParen1";
              } Else {
                  $classTable = "tableCellParen1";
              }

              If (pg_num_rows($dsVehicles) > 0) {
              
                   $model = dlookup("select model from vehicles where id=" . pg_fetch_result($dsVehicles, 0, "id"));
                   $fuelType = dlookup("select name from fueltypes where id=(select fueltypeid from vehicles where id=" . pg_fetch_result($dsVehicles, 0, "id") . ")");  
               
              ?>
                  <tr id="tr<?php echo $cnt1 ?>" class="<?php echo $classTable ?>" style=" color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px">
                       <td height=22px align=left style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px"><?php echo pg_fetch_result($dsVehicles, 0, "code")?></td>
                       <td height=22px align=center style="background-color:#fff; border:1px dotted #B8B8B8; "><?php echo pg_fetch_result($dsVehicles, 0, "registration")?></td>
                       <td height=22px align=left style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px"><div style="float:left; font-weight:bold"><?php echo pg_fetch_result($dsVehicles, 0, "model")?></div><div style="float:left;"> (<?php echo $fuelType ?>)</div></td>
                       <td height=22px align=center style="background-color:#fff; border:1px dotted #B8B8B8; ">
					   <button id="btn<?php echo $cnt1 ?>" style="height:20px; margin-left:8px; margin-right:8px; width:30px" onclick="removeItem(<?php echo $id ?>, <?php echo $drAv["id"] ?>)"></button>                       </td>
                  </tr>
              <?php
          	  } 
			  else
          	  {
              ?>
              <?php
          	  }
              $cnt1 = $cnt1 + 1;
	      	  }
	  	  }
		  else
		  {
	      ?>
	           <tr><td colspan="3" class="text2" style="font-style:italic"><?php dic("Fm.NoAllVehicles") ?></td></tr>
	      <?php
	      } 
	      ?>
               </table>
            </td>
          </tr>
		  <tr style="height:50px;">
	           <td colspan="6"><div style="border-bottom:1px solid #bebebe"></div></td>
	      </tr>
		  <tr>
		  <td colspan = "4" class="textTitle" style="font-size:16px;"><?php dic("Settings.AddOtherLicense") ?></td>
		  <td></td>
          <td></td>
          <td></td>
		  </tr>
		  <?php
		  $glavnoId = query("select id from drivers where id = " .$id." and clientid=" . Session("client_id"));
		  $pronId = pg_fetch_array($glavnoId);
		  ?>
		  </table>
           <table <?php if($yourbrowser == "1") {?> width="80%"<?php }else{?>width = "50%" <?php }?> style="padding-left:40px;" class="text2">
		  <tr>
		  <td class="textTitle" style="font-size:16px;">
              <button id="add3" style="margin-top:10px;" onclick="AddVehicles('<?php echo $pronId["id"]?>')">&nbsp;<?php dic("Fm.Add") ?></button>
          </td>
		  <td></td>
          <td></td>
          <td></td>
          </tr>
          <tr>
          <td colspan = "4" >&nbsp;</td>
		  <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
          <?php
          $najdi = query("select * from vehicleslicense where userid = " .$id." and clientid=" . Session("client_id") . " and (select coalesce(active, '0') from vehicles where id = vehicleid)='1'");
		  if(pg_num_rows($najdi)==0)
		  {
		  ?>	
		  <tr><td colspan="4" class="text2" style="font-style:italic"><?php dic("Fm.NoAllVehicles") ?></td></tr>
		  <?php
		  }
		  else
		  {
		  ?>
		  <tr class="text2" style="font-weight:bold; background:#dadada; height:22px">
          <td align="center" style="font-weight:bold; width: 200px; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Registration") ?></td>
		  <td align="center" style="font-weight:bold; width: 125px;  background-color:#E5E3E3; border:1px dotted #2f5185; "><?php dic("Settings.BeginDateLic") ?></td>
          <td align="center" style="font-weight:bold; width: 125px; background-color:#E5E3E3; border:1px dotted #2f5185; "><?php dic("Settings.EndDateLic") ?></td>
          <td align="center" style="font-weight:bold; width: 75px; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633 "><?php dic("Settings.Change") ?></td>
          <td align="center" style="font-weight:bold; width: 75px; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633"><?php dic("Settings.Delete") ?></td>
          </tr>
		  <?php
		  $cnt = 1;
		  while($pronajdi = pg_fetch_array($najdi)) {
		  $bitno = dlookup("select vehicleid from vehicleslicense where userid = " .$id." and clientid=" . Session("client_id"));
		  $najdi2 = query("select * from vehicles where clientid=" . Session("client_id")." and id = ".$pronajdi["vehicleid"]."");
		  $pronajdi2 = pg_fetch_array($najdi2);
		  ?>
          <tr>
          <td align="center" height="22px" style="background-color:#fff; width: 200px; border:1px dotted #B8B8B8;"><?php echo $pronajdi2["registration"]?></td>
		  <td align="center" height="22px" style="background-color:#fff; width: 125px; border:1px dotted #B8B8B8;"><?php echo DateTimeFormat($pronajdi["begining"], $dateFormat)?></td>
          <td align="center" height="22px" style="background-color:#fff; width: 125px; border:1px dotted #B8B8B8;"><?php echo DateTimeFormat($pronajdi["ending"], $dateFormat)?></td>
          <td align="center" height="22px" style="background-color:#fff; width: 75px; border:1px dotted #B8B8B8;"><button id="btnEdit<?php echo $cnt?>"  onclick="EditLicense(<?php echo $pronajdi["id"]?>)" style="height:22px; width:30px"></button></td>
          <td align="center" height="22px" style="background-color:#fff; width: 75px; border:1px dotted #B8B8B8;"><button id="DelBtn<?php echo $cnt?>"  onclick="DeleteButtonClick(<?php echo $pronajdi["id"]?>)" style="height:22px; width:30px"></button></td>
          
          <script>
		  var i = <?php echo $cnt?>;
		  $('#btnEdit' + i).button({ icons: { primary: "ui-icon-pencil"} });
		  $('#DelBtn' + i).button({ icons: { primary: "ui-icon-trash"} });
		  </script>
          </tr>
          <?php
          $cnt++;
		  }
		  }
		  ?>
		  <tr>
          <td>&nbsp;</td>
		  <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr> 
          <tr style="height:50px;">
	           <td colspan="6"><div style="border-bottom:1px solid #bebebe"></div></td>
	      </tr>
          <tr>
          	  <td></td>
          	  <td></td>
          	  <td></td>
          	  <td></td>
          </tr>
     
        </table> 
        <br>
         <?php 
	    $proverkaKart = query("select * from clubcards where clientid = ". session("client_id"));
	    if(pg_num_rows($proverkaKart)==0){
		?>
		
		<table <?php if($yourbrowser == "1") {?> width="80%"<?php }else{?>width = "50%" <?php }?> style="padding-left:40px;" class="text2">
		  <tr>
		  <td colspan = "4" class="textTitle" style="font-size:16px;"><?php dic("Settings.AddClubCardAllowence") ?></td>
		  </tr>
		 </table>
		<br><br>
		<div id="noData" style="padding-left:40px; font-size:20px; font-style:italic;" class="text4">
	 	<?php dic("Reports.NoData1")?>
		</div>	
		<br>
		<div style="margin-top:15px;margin-bottom:25px; padding-left: 40px; ">
              <button id="mod1" onclick="modify()"><?php dic("Fm.Mod") ?></button>
              <button id="cancel1" onclick="cancel()"><?php dic("Fm.Cancel") ?></button>
        </div>
   		<br><br><br>
		<?php
		}
		else
		{
		?>
          <table <?php if($yourbrowser == "1") {?> width="80%"<?php }else{?>width = "50%" <?php }?> style="padding-left:40px;" class="text2">
		  <tr>
		  <td colspan = "4" class="textTitle" style="font-size:16px;"><?php dic("Settings.AddClubCardAllowence") ?></td>
		  <td></td>
          <td></td>
          <td></td>
		  </tr>
		  <tr>
		  <td class="textTitle" style="font-size:16px;">
              <button id="addCard" style="margin-top:10px;" onclick="AddClubCards('<?php echo $id?>')">&nbsp;<?php dic("Fm.Add") ?></button>
          </td>
		  <td></td>
          <td></td>
          <td></td>
          </tr>
          <tr>
          <td colspan = "4" >&nbsp;</td>
		  <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
          
          <?php
          $najdi = query("select * from drivercard where driverid = ".$id."order by cardid");
		  
		  if(pg_num_rows($najdi)==0)
		  {
		  ?>	
		  <tr><td colspan="4" class="text2" style="font-style:italic"><?php dic("Settings.NoClubCardForEmployee") ?></td></tr>
		  <?php
		  }
		  else
		  {
		  ?>
		  <tr class="text2" style="font-weight:bold; background:#dadada; height:22px">
          <td align="center" style="font-weight:bold; width: 200px; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.ClubCards")?></td>
		  <td align="center" style="font-weight:bold; width: 75px; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633"><?php dic("Settings.Delete") ?></td>
          </tr>
		  <?php
		  $vozacID = pg_fetch_result($najdi,0, "driverid");
		  $cnt15 = 1;
		  while($cnt15 <= pg_num_rows($najdi))
		  {
		  $dodelenaKart = pg_fetch_array($najdi);
		  $klub = query("select * from clubcards where id = ". $dodelenaKart["cardid"]." order by cardname");
		  while ($row4 = pg_fetch_array($klub))
 		  {
 			$data[] = ($row4);
		  
		  ?>
          <tr>
          <td align="center" height="22px" style="background-color:#fff; width: 200px; border:1px dotted #B8B8B8;"><?php echo $row4["cardname"]?></td>
		  <td align="center" height="22px" style="background-color:#fff; width: 75px; border:1px dotted #B8B8B8;"><button id="DelBtnCard<?php echo $cnt15?>"  onclick="DeleteClubCardAllowClick(<?php echo $row4["id"]?>,<?php echo $vozacID?>)" style="height:22px; width:30px"></button></td>
          </tr>
          <script>
			  var ji = <?php echo $cnt15?>;
			  $('#DelBtnCard' + ji).button({ icons: { primary: "ui-icon-trash"} });
		  </script>
          <?php
          $cnt15++;
		  }
		  }
		  }
		  ?>
		  <tr>
          <td>&nbsp;</td>
		  <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr> 
          <tr style="height:50px;">
	           <td colspan="7"><div style="border-bottom:1px solid #bebebe"></div></td>
	      </tr>
          <tr>
          	  
          	  <?php if($yourbrowser == "1") {?>
          	  <td colspan="7">   
        	  <div style="float:right; margin-top:15px; margin-left:20px">
              <button id="mod1" onclick="modify()"><?php dic("Fm.Mod") ?></button>
              <button id="cancel1" onclick="cancel()"><?php dic("Fm.Cancel") ?></button>
              </div>
              </td>
          	  <?php
			  } 
	          else 
	          { 
	          ?>
	          <td colspan="7">   
        	  <div style="float:right; margin-top:15px; margin-left:20px">
              <button id="mod1" onclick="modify()"><?php dic("Fm.Mod") ?></button>
              <button id="cancel1" onclick="cancel()"><?php dic("Fm.Cancel") ?></button>
              </div>
              </td>
          	  <?php
          	  }
          	  ?>
        </tr>
        <tr><td style="height:50px"></td></tr>
        </table>
        <?php 
        }
        ?>
    
     <div id="div-check-vehicles" style="display:none" title="<?php dic("Settings.AddOtherLicense")?>"></div>
     <div id="div-del-license" style="display:none" title="<?php dic("Settings.DeleteOtherLicense")?>">
        <?php dic("Settings.SureToDelete") ?>?
     </div>
     <div id="div-del-allowed-vehicle" style="display:none" title="<?php dic("Settings.DeleteAllowedVehicle") ?>">
      	<?php dic("Settings.DeleteAllowedVehicleQuestion") ?>
     </div>
     <div id="div-del-clubCards" style="display:none" title="<?php echo dic("Settings.DeleteAllowClubCardEmployee")?>">
        <?php echo dic("Settings.DeleteAllowCardQuestion")?>
     </div>
    
     <div id="div-add-clubCards-allow" style="display:none" title="<?php echo dic("Settings.AddClubCardAllowence") ?>">
     <div align="center">
 	 <table style="padding-top: 10px;">
 	 <tr>
 	 <td width="50%" align="right" style="font-weight:bold" class ="text2"><?php echo dic("Settings.ChooseClubCard")?><td>
 	 <td width="50%" align="left" style="font-weight:bold" class ="text2">   
     
     <select id = "kartickaDozvolena" style="font-size: 11px; position: relative; top: 0px ;width:165px; visibility: visible;" class="combobox text2">
     <?php
 	 $find6 = query("select id,cardname from clubcards where clientid=".session("client_id")."order by cardname");
     while($row6 = pg_fetch_array($find6)){
	 $data6[] = ($row6);
	 }
	 foreach ($data6 as $row6){
	 ?>
	 <option id="<?php echo $row6["id"]?>" value = "<?php echo $row6["id"]?>"><?php echo $row6["cardname"]?>
	 <?php
	 }
	 ?>
	 </option>
     </select>
     </td>
	 </tr>
	 </table>	
	 </div>
	 </div>
 
 	 <div id="dialog-message" title="<?php echo dic("Reports.Message")?>" style="display:none">
	 <p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px"></div>
	 </p>
	 </div>
</body>

	<script>
	function msgboxPetar(msg) {
    $("#DivInfoForAll").css({ display: 'none' });
    $('#div-msgbox').html(msg)
    $("#dialog-message").dialog({
        modal: true,
        zIndex: 9999, resizable: false,
        buttons: {
            Ok: function () {
                $(this).dialog("close");
        	}
        }
    });
	}
	</script>

<script>
	
	$('#add3').button({ icons: { primary: "ui-icon-plusthick"} })
	$('#addCard').button({ icons: { primary: "ui-icon-plusthick"} })
	
	function AddClubCards(id) {
	$('#div-add-clubCards-allow').dialog({ modal: true, width: 350, height: 200, resizable: false,
	        buttons: 
	        [
            {
            	text:dic("Settings.Add",lang),
				click: function() {
					
                    var kartickataID = $('#kartickaDozvolena').val()
                    
   					$.ajax({
                      url: "AddDriverClubCard.php?kartickataID="+kartickataID+ "&id="+id,
                      context: document.body,
                      success: function(data){
              
                      if(data == 1)
                      {
               			msgboxPetar(dic("Settings.ClubCardAlreadyAllowed"),lang)
                      }
                      else
                      {
                      	msgboxPetar(dic("Settings.ClubCardSuccAdded"),lang)
	    			 	window.location.reload();
                      }
                      }
                     });	
                    }
                  },
				{
					text:dic("cancel",lang),
                click: function() {
					$( this ).dialog( "close" );
				},
			}
		]

    });
    }
   
	function DeleteClubCardAllowClick(id,vozacId) {
          document.getElementById('div-del-clubCards').title = dic("Settings.DeleteAllowClubCardEmployee")
		  $('#div-del-clubCards').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: 
                [
                {
                	text:dic("Settings.Yes",lang),
				    click: function() {
                            $.ajax({
		                        url: "DelClubCardsAllow.php?id="+ id+ "&vozacId="+vozacId ,
		                        context: document.body,
		                        success: function(data){
		                        msgboxPetar(dic("Settings.SuccDeleted",lang))
		                        window.location.reload();
								}
		                    });	
                            $( this ).dialog( "close" );
                           }
				    },
				    {
				    	text:dic("Settings.No",lang),
                    click: function() {
					    $( this ).dialog( "close" );
				    }
               }
               ]
          });
    }
    
	function AddVehicles(id)
	{
    ShowWait()
    $.ajax({
        url: "UseOtherVehicle2.php?id="+id+ "&l="+lang,
        context: document.body,
        success: function(data){
            HideWait()
            $('#div-check-vehicles').html(data)
            document.getElementById('div-check-vehicles').title = dic("Settings.AddOtherLicense")
            $('#div-check-vehicles').dialog({  modal: true, width: 450, height: 450, resizable: false,
                 buttons: 
                 [
                 {
                 	text:dic("Settings.Add",lang),
				    click: function() {
				    	
				       var pocetok = document.getElementById("pocetok").value;
              		   var kraj = document.getElementById("kraj").value;
              		   var input = $('input[name=edno]:radio:checked').val();
              		   
              		
					   if (!$("input[@name='edno']:checked").val()) {
					       msgboxPetar("Одберете возило");
					        return false;
					   }
					   else{
					    		$.ajax({
                                url: "AddUserVehicleLic2.php?id=" + id + "&pocetok=" + pocetok + "&kraj=" + kraj + "&input=" + input,
                                context: document.body,
		                        success: function(data){
		                        	if(data == 1)
		                            {
		                            	msgboxPetar(dic("Settings.AlreadyLicenseUsed",lang));
		                            }
		                            else
		                            {
		                            	msgboxPetar(dic("Settings.LicenseAddedSucc",lang));
                                    	window.location.reload();
		                        	}
		                         }
		                      })
		                   }
		                }
		             },
		             {
		             	text:dic("cancel",lang),
                    click: function() {
					    $( this ).dialog( "close" );
				      },
                   }
                ]
             })
          }
       });
	}
	function addAllVehicle(l, driId) {
       	ShowWait();
        var selected = "";
        $.ajax({
            url: 'AddAllowedVehicle.php?l=' + l + "&dri=" + driId,
            context: document.body,
            success: function (data) {
            	HideWait()
                $('#div-add').html(data)
                document.getElementById('div-add').title = dic("Fm.AddAllVehicle")
                $('#div-add').dialog({ modal: true, height: 400, width: 600,
                    buttons:
                     [
                       {
                         text: dic("add", l),
                         click: function () {

                             var inputs = document.getElementsByTagName("input");

                             for (var i = 0; i < inputs.length; i++) {
                                 if (inputs[i].type == "checkbox") {

                                     if (inputs[i].checked && inputs[i].value != "*") {
                                         selected += inputs[i].value + "*"
                                     }
                                 }
                             }

                             if (selected != "") {
                                 $.ajax({
                                     url: "InsertAllowedVehicle.php?selected=" + selected + "&driID=" + driId,
                                     context: document.body,
                                     success: function (data) {
                                         $(this).dialog("close");
                                         top.document.getElementById('ifrm-cont').src = "ModifyDriver.php?id=" + driId + "&l=" + "" + l + "";
                                     }
                                 });
                             }
                             else {
                                 mymsg(dic("oneDriver", l));
                             }
                         }
                     },
                         {
                             text: dic("cancel", l),
                             click: function () {
                                 $(this).dialog("close");
                             }
                         }
                     ]
                });
            }
        });
    }
	function EditLicense(id){
        ShowWait()
        $.ajax({
		    url: "UseOtherVehicle.php?id="+id,
		    context: document.body,
		    success: function(data){
                HideWait()
			    $('#div-check-vehicles').html(data)
			    document.getElementById('div-check-vehicles').title = dic("Settings.EditLicense")
                $('#div-check-vehicles').dialog({ modal: true, width: 450, height: 450, resizable: false,
                 buttons: 
              	 [
                	{
                	text:dic("Settings.Change",lang),
				    click: function() {
				    	
				       var pocetok = document.getElementById("pocetok").value;
              		   var kraj = document.getElementById("kraj").value;
              		   var input = $('input[name=edno]:radio:checked').val();
              		   
              		   /*if( $('input[type=radio][name=edno]:selected').length == 0)
              		   {
              		   		alert("Мора да одберете возило");
              		   }
              		   else
              		   {*/
					    		$.ajax({
                                url: "EditUserVehicleLic.php?id=" + id + "&pocetok=" + pocetok + "&kraj=" + kraj + "&input=" + input,
                                context: document.body,
		                        success: function(data){
			                        	msgboxPetar(dic("Settings.EditLicenseSucc",lang));
                                    	window.location.reload();
		                        }
		                    })	
		                 //}   
                         $( this ).dialog( "close" );
                        }
                    },
                    {
                    	text:dic("cancel",lang),
                    click: function() {
					    $( this ).dialog( "close" );
				    },
                }
                ]
                });
		    }
		});
       
	}
	function DeleteButtonClick(id) {
		$('#div-del-license').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: 
                [
                {
                	text:dic("Settings.Yes",lang),
				    click: function() {
                            $.ajax({
		                        url: "DelLicenseVehicle.php?id="+id,
		                        context: document.body,
		                        success: function(data){
		                        msgboxPetar(dic("Settings.SuccDeletedLicense",lang));
		                        window.location.reload();
								}
		                    });	
                            $( this ).dialog( "close" );
                           }
				    },
				    {
				    	text:dic("Settings.No",lang),
                	    click: function() {
					    $( this ).dialog( "close" );
				    }
               }
               ]
         });
        }
        
	function CheckVehicles()
	{
    ShowWait()
    $.ajax({
        url: "UseOtherVehicle.php?l=" + lang,
        context: document.body,
        success: function(data){
            HideWait()
            $('#div-check-vehicles').html(data)
            document.getElementById('div-check-vehicles').title = dic("Settings.AddOtherLicense")
            $('#div-check-vehicles').dialog({  modal: true, width: 800, height: 600, resizable: false,
              buttons: 
                [
                {
                	text:dic("Settings.Add",lang),
				    click: function() {
				       var pocetok = document.getElementById("pocetok").value;
              		   var kraj = document.getElementById("kraj").value;
              		   var input = $('input[name=edno]:radio:checked').val();
					    
					      		$.ajax({
                                url: "AddUserVehicleLic.php?pocetok=" + pocetok + "&kraj=" + kraj + "&input=" + input,
                                context: document.body,
		                        success: function(data){
		                        	if(data == 1)
		                            {
		                            	msgboxPetar(dic("Settings.AlreadyLicenseUsed",lang));
		                            }
		                            else
		                            {
		                        		msgboxPetar(dic("Settings.LicenseAddedSucc",lang));
                                    	window.location.reload();
		                        	}
		                        }
		                    });	
                         $( this ).dialog( "close" );
                        }
                    },
                    {
                    	text:dic("cancel",lang),
                    click: function() {
					    $( this ).dialog( "close" );
				    },
                }
                ]
            })
        }
    });
	}


 

</script>
<script>
		var i = <?php echo $cnt1?>;
		$('#btnEdit' + i).button({ icons: { primary: "ui-icon-pencil"} });    
        $('#DelBtn' + i).button({ icons: { primary: "ui-icon-trash"} });
		</script>
<script>
    lang = '<?php echo $cLang?>';
    for (var i = 0; i < 5; i++) {
        if (document.getElementById("opt" + i).value == "<?php echo $contract ?>") {
            document.getElementById("durContract").selectedIndex = i;
        }
    }

    var licenceCat = '<?php echo $licenceCat ?>'
    var catArr = licenceCat.split(",")
    for (var j = 0; j < 5; j++) {
            document.getElementById("cat" + j).checked = "";
    }
    for (var i = 0; i < catArr.length; i++) {
        for (var j = 0; j < 5; j++) {
            if (document.getElementById("cat" + j).value == catArr[i]) {
                document.getElementById("cat" + j).checked = "checked";
            }
        }
    }

    var allRemoved = "";

    var il = $('input[name=interLicence]:radio:checked').val()
    if (il == "1") {
            document.getElementById('IntLicExp11').style.display = "";
            document.getElementById('IntLicExp12').style.display = "";
    }
    else {
            document.getElementById('IntLicExp11').style.display = "none";
            document.getElementById('IntLicExp12').style.display = "none";
    }

    function ShowHideRow() {
        var il = $('input[name=interLicence]:radio:checked').val()
        if (il == "0") {
            document.getElementById('IntLicExp11').style.display = "";
            document.getElementById('IntLicExp12').style.display = "";
        }
        else {
            document.getElementById('IntLicExp11').style.display = "none";
            document.getElementById('IntLicExp12').style.display = "none";
        }
    }
    
    function checkForm() {
    	var _tmp = true;
    	if($("#dUsername").val()=='')
		{
			mymsg(dic("Admin.HaveToEnter",lang)+ " " + dic("Login.Username",lang)+"!!!")
			_tmp = false;
			return false;
		}
	  	var password=$("#dPassword").val();
	  	if(password == '') { 
	  	 	mymsg(dic("Admin.HaveToEnter",lang)+ " " + dic("Login.Password").toLowerCase() + "!!!");
	  	 	_tmp = false;
		 	return false;
	  	} 
  	 	var i=/(?=.*[!@#$%^&*-])/;
  	 	var re = /(?=.*[A-Z])/;
  	 	if(!i.test(password)) {
  	 	 	mymsg(dic("Admin.HaveToEnter",lang)+ " " + dic("Admin.OneSpecChar")+ "(!@#$%^&*)")
  	 	 	_tmp = false;
  	 	 	return false;
  	 	}
  	 	if(password.length<6) {
  	 	 	mymsg(dic("Admin.SixChar",lang))
  	 	 	_tmp = false;
  	 	 	return false;
  	 	}
  	 	if( !re.test(password)) {
  	 	  	mymsg(dic("Admin.HaveToEnter",lang)+ " " + dic("Admin.onecapitalLetter",lang))
  	 	  	_tmp = false;
    		return false;
  	 	}	
  	 	return _tmp; 	
    }
    function modify() {
    	if (document.getElementById('dUsername')) {
	        var tt=checkForm()
			if(!tt)
				return false;
		}	
        top.ShowWait();

        var fullName = document.getElementById("FullName").value;
        var code = document.getElementById("code").value;
        var bornDate = formatdate13(document.getElementById("dateBorn").value, '<?=$dateformat?>');
        var dlnumber = document.getElementById("dlnumber").value;
        var gender = $('input[name=gender]:radio:checked').val();
        var rfId = document.getElementById("RfId").value;
        var contract = document.getElementById("opt" + document.getElementById("durContract").selectedIndex).value;

        var categories = ""
        for (var i = 0; i < 5; i++) {
            if (document.getElementById("cat" + i).checked) {
                categories += document.getElementById("cat" + i).value + ","
            }
        }
        var catLen = categories.length;
        categories = categories.slice(0, catLen - 1);

        var startCom = formatdate13(document.getElementById("startCom").value, '<?=$dateformat?>');
        var firstLic = formatdate13(document.getElementById("firstLicence").value, '<?=$dateformat?>');
        var licExp = formatdate13(document.getElementById("licenceExpire").value, '<?=$dateformat?>');

        var interLic = 0;
        if (<?=$americaUser?> == 0) 
          interLic = $('input[name=interLicence]:radio:checked').val();

        var IntLicExp = document.getElementById("IntLicExp").value;
        var orgUnit = document.getElementById("orgUnit").value;

    		var dUsername = "";
    		var dPassword = "";
		if (document.getElementById('dUsername')) {
    			dUsername = document.getElementById('dUsername').value;
    			dPassword = document.getElementById('dPassword').value;
    			dPassword = encodeURIComponent(dPassword);
    		}

       $.ajax({
            url: "UpdateDriver.php?name=" + fullName + "&code=" + code + "&bornDate=" + bornDate + "&gender=" + gender + "&rfId=" + rfId + "&contract=" + contract + "&startCom=" + startCom + "&categories=" + categories + "&firstLic=" + firstLic + "&licExp=" + licExp + "&interLic=" + interLic + "&IntLicExp=" + IntLicExp + "&id=" + <?php echo $id ?> + "&removed=" + allRemoved + "&orgUnit=" + orgUnit + "&dUsername=" + dUsername + "&dPassword=" + dPassword + "&dlnumber=" + dlnumber,
            context: document.body,
            success: function (data) {
            	if(data == 1)
                  {
           			msgboxPetar(dic("Settings.AlreadyCodeEmployee"),lang)
           			top.HideWait();
                  }
                  else
                  {
                  	top.document.getElementById('ifrm-cont').src = "Drivers.php?l=" + '<?php echo $cLang ?>';
                  }
              	  }
        	}); 
    }
        
    function cancel() {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "Drivers.php?l=" + '<?php echo $cLang ?>';
    }

    function removeItem(i, id) {
    $('#div-del-allowed-vehicle').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: 
                [
                {
                	text:dic("Settings.Yes",lang),
				    click: function() {
                            $.ajax({
		                        url: "DelAllowedVehicle.php?id="+id+ "&i=" + i,
		                        context: document.body,
		                        success: function(data){
		                        msgboxPetar(dic("Settings.DeleteAllowenceSuccess",lang));
		                        window.location.reload();
								}
		                    });	
                            $( this ).dialog( "close" );
                           }
				    },
				    {
				    	text:dic("Settings.No",lang),
                    click: function() {
					    $( this ).dialog( "close" );
				    }
               }
               ]
         });
         //var element = document.getElementById("tr" + i);
       //  element.parentNode.removeChild(element);
       //  allRemoved += id + ";";
    }

 
    $('#mod1').button({ icons: { primary: "ui-icon-pencil"} })
    $('#cancel1').button({ icons: { primary: "ui-icon-arrowreturnthick-1-w"} })
    $('#mod2').button({ icons: { primary: "ui-icon-pencil"} })
    $('#cancel2').button({ icons: { primary: "ui-icon-arrowreturnthick-1-w"} })
    $('#addAllVeh').button({ icons: { primary: "ui-icon-plusthick"} })

    for (var i = 0; i < <?php echo $cnt1 ?>; i++) {
        $('#btn' + i).button({ icons: { primary: "ui-icon-trash"} })
    }

    for (var i = 0; i < <?php echo pg_num_rows($dsUnits) ?>; i++) {
	    if ('<?php echo $orgUnit ?>' == "") {
	     	document.getElementById("orgUnit").selectedIndex = -1;
	    }
	    else {
	        if (document.getElementById("opt-" + i).value == "<?php echo $orgUnit?>") {
	            document.getElementById("orgUnit").selectedIndex = i;
	        }
	      }
    }
    function setDates1() {
        $('#dateBorn').datetimepicker({
            dateFormat: '<?=$datejs?>',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
        });
        $('#firstLicence').datetimepicker({
            dateFormat: '<?=$datejs?>',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
        });
        $('#licenceExpire').datetimepicker({
            dateFormat: '<?=$datejs?>',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
        });
        $('#startCom').datetimepicker({
            dateFormat: '<?=$datejs?>',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
        });   
        $('#IntLicExp').datetimepicker({
            dateFormat: '<?=$datejs?>',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
        });
    }
    setDates1();
    top.HideWait();
    SetHeightLite();
    iPadSettingsLite();

</script>
   <?php closedb();?>
</html>
