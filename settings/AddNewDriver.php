﻿<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>


<?php 
	header("Content-type: text/html; charset=utf-8");
?>
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
    <style type="text/css"> 
 		body{ overflow-y:auto }
	</style>
    <link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="./js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
    <script src="../js/jquery-ui.js"></script>
    <script type="text/javascript">
	$(document).ready(function () {
	
	jQuery('body').bind('touchmove', function(e){e.preventDefault()});
	
	});
</script>
<body>
	<div id="dialog-message" title="<?php dic("Reports.Message")?>" style="display:none">
         <p>
             <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
             <div id="div-msgbox" style="font-size:14px"></div>
         </p>
    </div>
  <?php
      
  ?>

   <?php if($yourbrowser == "1") {?><div class="textTitle" style="padding-left:8px; padding-top:15px;" ><?php }else{?><div class="textTitle"style="padding-left:40px; padding-top:20px;"> <?php };?><?php echo dic_("Fm.AddDri")?></div><br />

  <table <?php if($yourbrowser == "1") {?>style="padding-left:8px;" <?php }else{?>style="padding-left:40px;" <?php }?> class="text2_">

      <tr style="height:10px"></tr>
	  <tr >
          <td style="font-weight:bold"><?php dic("Fm.FullName") ?>:</td>
          <td style=""><input id="FullName" type="text" size=22 style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/></td>
          <td style="font-weight:bold; padding-left:60px"><?php dic("Fm.DurContract")?>:</td>
          <td style="">
              <select id="durContract" style="width: 161px; font-size: 11px; position: relative; top: 0px; z-index: 1; visibility: visible; " class="combobox text2">
                        <option value="1">1 <?php dic("Fm.Month") ?>  
                        <option value="3">3 <?php dic("Fm.Months") ?>  
                        <option value="6">6 <?php dic("Fm.Months") ?>  
                        <option value="12">1 <?php dic("Fm.Year") ?> 
                        <option value="0"><?php dic("Fm.Indef")?> 
            </select>
          </td>
      </tr>

      <tr>
      <td style="font-weight:bold"><?php dic("Settings.EmployeeID") ?>:</td>
          <td style=""><input id="code" type="text" size=22 style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/></td>
          
          <td style="font-weight:bold; padding-left:60px"><?php dic("Fm.LicenceType") ?>:</td>
          <td style="">
            <input type="checkbox" name="category" value="A" />A
            <input type="checkbox" name="category" value="B" checked=checked style="margin-left:7px" />B
            <input type="checkbox" name="category" value="C" style="margin-left:7px" />C
            <input type="checkbox" name="category" value="D" style="margin-left:7px" />D
            <input type="checkbox" name="category" value="E" style="margin-left:7px" />E
      	  </td>
      </tr>
<?php
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
  $LastDay = DateTimeFormat(addDay(-1), $dateformat);

?>
      <tr>
      <td style="font-weight:bold;"><?php dic("Fm.OrgUnit")?>:</td>
         <td style="">
                  <select id="orgUnit" style="width: 161px; font-size: 11px; position: relative; top: 0px; z-index: 1; visibility: visible;" class="combobox text2">
                             <?php
                                 $units = "select name, id from organisation where clientid=" . Session("client_id");
                                 $dsUnits = query($units);
                                 
                                 while ($drUnits = pg_fetch_array($dsUnits)) {
                              ?>
                                     <option value="<?php echo $drUnits["id"] ?>"><?php echo $drUnits["name"] ?></option>
                               <?php
                                 } //end while
                                        
                                   $cLang = getQUERY("lang");
                                ?>   
                                <option value="0"><?php dic("Fm.UngroupedVeh") ?></option>
                  </select>
         </td>

         

        <td style="font-weight:bold; padding-left:60px"><?php dic("Settings.DLNumber")?>:</td>
        <td style="">
          <input id="dlnumber" type="text" value="" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px" />        
        </td>
          
      </tr>

      <tr>

      <td style="font-weight:bold"><?php dic("Fm.DateBorn") ?>:</td>
          <td style="">
          <input id="dateBorn" type="text" class="textboxCalender1 text2" value="<?php echo $LastDay ?>" />
          </td>

          
       
      <td style="font-weight:bold; padding-left:60px"><?php dic("Fm.FirstLicence") ?>:</td><td style="">
                <input id="firstLicence" type="text" class="textboxCalender1 text2" value="<?php echo $LastDay ?>" />
          </td>

      </tr>

      <tr>
      <td style="font-weight:bold"><?php dic("Fm.Gender") ?>:</td><td style="">
            <input type="radio" name="gender" value="M" checked=checked /><?php dic("Fm.Male") ?>
             <input type="radio" name="gender" value="F" style="margin-left:20px"/><?php dic("Fm.Female") ?>
          </td>

          <td style="font-weight:bold; padding-left:60px"><?php dic("Fm.IstekVoz")?>:</td>
          <td style="">
                <input id="licenceExpire" type="text" class="textboxCalender1 text2" value="<?php echo $LastDay ?>" />
          </td>

          </tr>

      <tr>

          <td style="font-weight:bold">RFID:</td><td style="">
            <input id="RfId" type="text" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px" />
          </td>

          <?php
          if ($americaUser == 1) {
          ?>  
             <td style="font-weight:bold; padding-left:60px;"><?php dic("Fm.StartCom") ?>:</td>
            <td style="">
               <input id="startCom" type="text" class="textboxCalender1 text2" value="<?php echo $LastDay ?>" />
            </td>
          <?php  
          } else {
          ?>
            <td style="font-weight:bold; padding-left:60px;"><?php dic("Fm.IntLicence")?>:</td>
            <td style="">
               <input type="radio" name="IntLic" value="1"  onmouseup="ShowHideRow()" /><?php dic("Fm.Yes") ?>
               <input type="radio" name="IntLic" value="0" style="margin-left:20px" checked=checked onmouseup="ShowHideRow()" /><?php dic("Fm.No") ?>
            </td>
          <?php  
          }
          ?>
         
     </tr>

     <tr style="<?= $americaUserStyle?>">
         <td width = "210" style="font-weight:bold"><?php dic("Fm.StartCom")?>:</td>
         <td width = "210" style="">
             <input id="startCom" type="text" class="textboxCalender1 text2" value="<?php echo $LastDay ?>" style="z-index:999;" />
          </td>
         <td id="IntLicExp11" width = "210" style="display:none; font-weight:bold; padding-left:60px;"><?php echo dic("Settings.ExpiryDrivingLicense")?>:</td>
         <td id="IntLicExp12" width = "210" style="display:none;">
              <input id="IntLicExp" type="text" class="textboxCalender1 text2" value="<?php echo $LastDay?>" />
         </td>
     </tr>

	 <?php
       $allowdriverasuser = dlookup("select allowdriverasuser from clients where id=".session("client_id"));
	   if ($allowdriverasuser == '1') {
       ?>
       <tr>
		  <td style="font-weight:bold"><?php echo dic_("Login.Username")?>:</td>
		  <td>
              <input id="dUsername" type="text" value="" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px" /><span style="color: red;width: 1%; padding-left: 0px"> *</span>
          </td>
          <td style="font-weight:bold; padding-left:60px"><?php echo dic_("Login.Password")?>:</td>
          <td>
         	 <input id="dPassword" type="text" value="" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px" /><span style="color: red;width: 1%; padding-left: 0px"> *</span>
          </td>
       </tr>
       <tr>
       	<td colspan=2></td>
       	<td colspan=2 style="padding-left:60px; color: red; font-size: 10px; font-style: italic"><?php echo dic("Settings.PasswordMust")?>.</td>
       </tr>
       <?php
       }
     ?>
     

      <tr style="height:70px;">
         <td colspan=4><div style="border-bottom:1px solid #bebebe"></div></td>
     </tr>
 	
      <tr>
          <td>
          	<!--<button id="add3" onclick="CheckVehicles('<?php echo $cLang ?>')">&nbsp;<?php dic("Fm.Add") ?> дозвола за управување со туѓо моторно возило</button>-->
 			
          </td>
          <td></td>
          <td></td>
          <td>
              <div style="float:left; margin-top:0px; margin-left:10px">
                    <button id="add1" onclick="add()"><?php dic("Fm.Add") ?></button>
              </div>

              <div style="margin-top:0px; margin-left:100px">
                    <button id="cancel1" onclick="cancel()"><?php dic("Fm.Cancel") ?></button>
              </div>
          </td>
      </tr>
  </table>

	<!--<div id="div-check-vehicles" style="display:none" title="Додавање дозвола за користење туѓо возило"></div>-->
</body>



<script>
	function CheckVehicles()
	{
    ShowWait()
    $.ajax({
        url: "UseOtherVehicle.php?l=" + lang,
        context: document.body,
        success: function(data){
            HideWait()
            $('#div-check-vehicles').html(data)
            $('#div-check-vehicles').dialog({  modal: true, width: 800, height: 600, resizable: false,
                 buttons: 
                 [
                 {
                 	text:dic("Yes",lang),
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
		                            	alert(dic("Settings.LicenseAlreadyCreated",lang))
		                            }
		                            else
		                            {
		                            	alert(dic("Settings.SuccEnteredLicenseUseVehicle",lang))
		                        		window.location.reload();
		                        	}
		                        }
		                    });	
                         $( this ).dialog( "close" );
                        }
                    },
                    {
                   	text:dic("no",lang),
				    click: function() {
					    $( this ).dialog( "close" );
				    }
                }
                ]
            })
        }
    });
}
</script>

<script>
    //lang = '<?php echo $cLang?>'; 	
    document.getElementById("FullName").focus();

    var il = $('input[name=IntLic]:radio:checked').val()
    if (il == "1") {
        document.getElementById('IntLicExp11').style.display = "";
        document.getElementById('IntLicExp12').style.display = "";
    }
    else {
        document.getElementById('IntLicExp11').style.display = "none";
        document.getElementById('IntLicExp12').style.display = "none";
    }

    function ShowHideRow() {
        var il = $('input[name=IntLic]:radio:checked').val()
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
    function add() {
        if (document.getElementById('dUsername')) {
	        var tt=checkForm()
			if(!tt)
				return false;
		}	
        top.ShowWait();

        var name = document.getElementById("FullName").value;
        var code = document.getElementById("code").value;
        var orgUnit = document.getElementById("orgUnit").value;
        var dateBorn = formatdate13(document.getElementById("dateBorn").value, '<?=$dateformat?>');

        var dlnumber = document.getElementById("dlnumber").value;
        var gender = $('input[name=gender]:radio:checked').val();
        var rfId = document.getElementById("RfId").value;
        var durContract = document.getElementById("durContract").value;

        var firstLicence = formatdate13(document.getElementById("firstLicence").value, '<?=$dateformat?>');
        var licenceExpire = formatdate13(document.getElementById("licenceExpire").value, '<?=$dateformat?>');
        var startCom = formatdate13(document.getElementById("startCom").value, '<?=$dateformat?>');

        var interLicence = 0;
        if (<?=$americaUser?> == 0) 
          interLicence = $('input[name=IntLic]:radio:checked').val();

        var IntLicExp = formatdate13(document.getElementById("IntLicExp").value, '<?=$dateformat?>');

        var dUsername = "";
		var dPassword = "";
		if (document.getElementById('dUsername')) {
			dUsername = document.getElementById('dUsername').value;
			dPassword = document.getElementById('dPassword').value;
			dPassword = encodeURIComponent(dPassword);
		}
        var categories = new Array();
        $("input:checkbox[name=category]:checked").each(function () {
            categories.push($(this).val());
        });

        $.ajax({
            url: "InsertDriver.php?name=" + name + "&dateBorn=" + dateBorn + "&code=" + code + "&gender=" + gender + "&rfId=" + rfId + "&startCom=" + startCom + "&durContract=" + durContract + "&firstLicence=" + firstLicence + "&licenceExpire=" + licenceExpire + "&interLicence=" + interLicence + "&IntLicExp=" + IntLicExp + "&categories=" + categories + "&orgUnit=" + orgUnit + "&dUsername=" + dUsername + "&dPassword=" + dPassword + "&dlnumber=" + dlnumber,
              context: document.body,
              success: function (data) {
              	//alert(data.indexOf("1"))
              	
              	  if(data.indexOf("existcode") != -1)
                  {
           			alert(dic("Settings.AlreadyCodeEmployee"),lang)
           			top.HideWait();
				return false;
                  } else {
                  			alert(dic("Settings.SuccAdd"),lang)
					top.document.getElementById('ifrm-cont').src = "Drivers.php?l=" + lang;
				  }
             }
        }); 
    }
	
	function cancel() {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "Drivers.php?l=" + lang;
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

</script>


<script>
	$('#add3').button({ icons: { primary: "ui-icon-circle-plus"} })
    $('#add1').button({ icons: { primary: "ui-icon-plus"} })
    $('#cancel1').button({ icons: { primary: "ui-icon-arrowreturnthick-1-w"} })

</script>

<?php
	closedb();
?>
</html>
