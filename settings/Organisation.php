<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
	opendb();
	$Allow = getPriv("ounits", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
	
	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	$yourbrowser1 = (bool) strpos($ua['userAgent'], "Macintosh");
	
	addlog(43);
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
    <script src="../js/jquery-ui.js"></script>
    <script type="text/javascript">
	$(document).ready(function () {
	
	jQuery('body').bind('touchmove', function(e){e.preventDefault()});
	
	});
	</script>
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

	<style type="text/css"> 
 		body{ overflow-y:auto }
	</style>
 <body>

 	<div id="div-add" style="display:none" title="<?php dic("Fm.AddOrgUnit") ?>">
		<table style="padding-left:20px;" class="text2_" width=50%>
		  <tr style="height:10px"></tr>
		   <tr>
		      <td width=20% style="font-weight:bold;"><?php dic("Fm.Code") ?>:</td>
		      <td width=30% style="padding-left:10px">
		      		<input id="code" type="text" size=22 style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px;  border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:150px; padding-left:5px" />
		      		<span style="color:red; font-size:14px;cursor: default;">&nbsp;*</span>
		      </td>
		  </tr>
		 <tr>
		 <td width=20% style="font-weight:bold;"><?php dic("Fm.OrgUnit") ?>:</td>
		        <td width=30% style="padding-left:10px">
		        	<input id="orgUnit" type="text" size=22 style="margin-top:1px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px;  border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:300px; padding-left:5px" />
		        </td>
		        <td><span style="color:red; font-size:14px;cursor: default;">&nbsp;*</span></td>
				
		 </tr>
		  <tr>
		      <td width=20% style="font-weight:bold; padding-bottom:56px"><?php dic("Fm.Note") ?>:</td>
		      <td  style="padding-left:10px">
		         <textarea id="desc" style=" border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; width:100%; height:80px; padding:5px; overflow-Y:auto"></textarea>
		      </td>

		  </tr>
		</table>
 	</div>

    <div id="dialog-message" title="<?php dic("Reports.Message")?>" style="display:none">
         <p>
	        <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
	        <div id="div-msgbox" style="font-size:14px"></div>
        </p>
    </div>

    <!--div id="report-content" style="width:100%; background-color:#fafafa; margin-bottom:50px; overflow-y:auto; overflow-x:hidden" class="corner5"-->

       <table width="94%" style="margin-top:30px; margin-left:35px">
                <tr class="text2">
                     <td width="65%" class="textTitle"><?php echo dic_("Fm.OrgUnits") ?></td>
                     <td width="35%" align="right"><button id="addUnit" onclick="addOrgUnit('<?php echo $cLang ?>')" ><?php dic("Fm.AddOrgUnit") ?></button></td>
                </tr>
            </table>

		<br>
		 <?php
		    $proverkaOrg = query("select * from organisation where clientid = ". session("client_id"));
		    if(pg_num_rows($proverkaOrg)==0){
		    	$allOrg = array();
			?>
			<br>
			<div id="noData" style="padding-left:40px; font-size:20px; font-style:italic;" class="text4">
		 	<?php dic("Reports.NoData1")?>
			</div>
			<?php
			}
			else
			{
			?>
        <table id="tabId" width="94%" border="0" cellspacing="2" cellpadding="2" align="center" style="margin-top:30px; margin-left:35px">
            <tr><td height="22px" class="text2" colspan=6 style="color:#fff; font-weight:bold; font-size:14px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b;"><?php dic("Fm.OrgUnits") ?></td></tr>
          	<tr>
                <td width="5%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;" class="text2"><?php dic("Fm.Rbr")?></td>
                <td width="8%" height="22px" align="left" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px" class="text2"><?php dic("Fm.Code")?></td> 
                <td width="26%"  height="22px" align="left" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px;" class="text2"><?php dic("Fm.OrgUnit")?></td>
                <td width="45%"  height="22px" align="left" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px;" class="text2"><?php dic("Fm.Note")?></td>
                <td width="8%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633" class="text2"><?php dic("Fm.Mod")?></td>
                <td width="8%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633" class="text2"><?php dic("Fm.Delete")?></td>
            </tr>

         <?php
             $sqlOrg = "select * from organisation where clientID = " . session("client_id")."";
             $dsOrg = query($sqlOrg);
             $allOrg = pg_fetch_all(query($sqlOrg));
			 $cnt = 1;
             $id = 0 ;

			 //gi vrti site organizacioni edinici zapisani vo tabelata organisation
			 while ($rO=pg_fetch_array($dsOrg)) {
                 $id = $rO["id"];
                 ?>

             <tr id="unit<?php echo $cnt?>" style="cursor:pointer" onmouseover="over(<?php echo $cnt ?>)" onmouseout="out(<?php echo $cnt ?>)" value="1">
                <td id="td-1-<?php echo $cnt?>" width="5%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><?php echo $cnt ?></td>
                <td id="td-2-<?php echo $cnt?>" width="8%" height="30px" align="left" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px"><?php echo nnull($rO["code"], "/")?></td>
                <td id="td-3-<?php echo $cnt?>" width="26%" height="30px" align="left" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px"><?php echo nnull($rO["name"], "/") ?></td>
                <td id="td-4-<?php echo $cnt?>" width="45%" height="30px" align="left" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px" ><?php echo nnull($rO["description"], "/") ?></td>
                <td id="td-5-<?php echo $cnt?>" width="8%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                    <button id="modBtn<?php echo $cnt?>" onclick="modifyUnit(<?php echo $cnt ?>, <?php echo $id ?>, '<?php echo $cLang ?>')" style="height:22px; width:30px"></button>
                </td>
                <td id="td-6-<?php echo $cnt?>" width="8%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                    <button id="delBtn<?php echo $cnt?>" onclick="del(<?php echo $rO["id"] ?>, '<?php echo $cLang ?>', 'organisation')" style="height:22px; width:30px"></button>
                </td>
             </tr>

             <?php
                  $cnt = $cnt + 1;
             }
             ?>
             <tr style="height:40px"></tr>

        </table>
        <?php
        }
        ?>
</body>

<script>

(function(){
	allorgs = JSON.parse('<?php echo json_encode($allOrg) ?>');
})();

$('#addUnit').button({ icons: { primary: "ui-icon-plusthick"} });
top.HideWait();
	lang = '<?php echo $cLang?>';
    for(var i = 0; i <= <?php echo pg_num_rows($proverkaOrg) ?>; i ++) {
        $('#modBtn' + i).button({ icons: { primary: "ui-icon-pencil"} });
        $('#delBtn' + i).button({ icons: { primary: "ui-icon-trash"} });
    }

	//onmouseover na red od sifrarnikot
    function over(i) {
        for (var j = 1; j < 6; j++) {
            document.getElementById("td-" + j + "-" + i).style.color = "blue";
        }
    }

	//onmouseout na red od sifrarnikot
    function out(i) {
         for (var j = 1; j < 6; j++) {
            document.getElementById("td-" + j + "-" + i).style.color  = "#2f5185";
        }
    }

	lang = '<?php echo $cLang?>';

    //SetHeightLite();
    //iPadSettingsLite();


function get_index(obj_arr, value) {
	var rez = -1;
	for (var i = 0; i < obj_arr.length; i++) {
		if (obj_arr[i].id == value) rez = i;
	}
	return rez;
}

var validation = [];

function msgboxnew(msg) {
	$('#div-msgbox').html(msg);
	$("#dialog:ui-dialog").dialog("destroy");
	$("#dialog-message").dialog({
		modal: true,
		zIndex: 9999,
		resizable: false,
		buttons: {
			Ok: function() {
				if ($("#InfoForAll").checked)
					setCookie(_userId + "_poiinfo", "1", 14);
				else
					$("#InfoForAll").checked = false;
				$(this).dialog("close");
			}
		}
	});
}

function isNum( obj ) {
    return !jQuery.isArray( obj ) && (obj - parseFloat( obj ) + 1) >= 0;
}

function addOrgUnit(l) {
    $('#div-add').dialog({ modal: true, height: 280, width: 480, title: dic("addOrgUnit", lang),
        buttons:
         [
         {
             text: dic("add", lang),
             click: function () {

             	validation = [];

                 var kod = document.getElementById("code").value;
                 var orgUnit = document.getElementById("orgUnit").value;
                 var desc = document.getElementById("desc").value;

                 if(!isNum(kod)) validation.push("Settings.InvalidCode");
                 if(orgUnit === '') validation.push("ReqFields");

                 console.log(validation);

                 if(validation.length != 0) {
	                	msgboxnew(dic(validation[0],lang));
                 } else {

	                 $.ajax({
	                     url: "InsertOrgUnit.php?kod=" + kod + "&orgUnit=" + orgUnit + "&desc=" + desc,
	                     context: document.body,
	                     success: function (data) {
	                         // top.document.getElementById('ifrm-cont').src = "Organisation.php?l=" + '<?php echo $cLang?>';
	                         window.location.reload();
	                     }
	                 });

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

function modifyUnit(i, id, l) {

	var org_unit = allorgs[get_index(allorgs,id)];

	$('#div-add').dialog({ modal: true, height: 280, width: 480, title: dic("modOrgUnit", lang),
		open: function(){
			$('#code').val(org_unit.code);
			$('#orgUnit').val(org_unit.name);
			$('#desc').val(org_unit.description);
		},
        buttons:
         [
         {
             text: dic("change", lang),
             click: function () {

             	validation = [];

                 var kod = $('#code').val();
                 var orgUnit = $('#orgUnit').val();
                 var desc = $('#desc').val();

                 if(!isNum(kod)) validation.push("Settings.InvalidCode");
                 if(orgUnit === '') validation.push("ReqFields");

                 console.log(validation);

                 if(validation.length != 0) {
	                	msgboxnew(dic(validation[0],lang));
                 } else {

	                 $.ajax({
	                     url: "UpdateOrgUnit.php?code=" + kod + "&name=" + orgUnit + "&desc=" + desc + "&id=" + id,
	                     context: document.body,
	                     success: function (data) {
	                         // top.document.getElementById('ifrm-cont').src = "Organisation.php?l=" + '<?php echo $cLang?>';
	                         window.location.reload();
	                     }
	                 });

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

function deleteOrgUnit(id) {
	$.ajax({
		url: "DeleteOrgUnit.php?id=" + id,
		context: document.body,
		success:function(){

		}
	});
}


</script>

<?php closedb();?>

</html>