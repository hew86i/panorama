<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");
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
    <script src="../js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
    <script src="../js/jquery-ui.js"></script>

 <body>
     <?php
         //$cLang = getQUERY('lang');
      ?>
    <div id="div-add" style="display:none" title=""></div>
    <div id="dialog-message" title="<?php echo dic("Reports.Message")?>" style="display:none">
         <p>
	        <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
	        <div id="div-msgbox" style="font-size:14px"></div>
        </p>
    </div>
  <?php
      $id = getQUERY('id');
	  
	  opendb();
	  
      $code = NNull(DlookUP("select Code from organisation where id=" . $id), "");
      $name = NNull(DlookUP("select Name from organisation where id=" . $id), "");
      $desc = NNull(DlookUP("select Description from organisation where id=" . $id), "");
   
  ?>

              
             <table style="padding-left:20px;" class="text2_" width=50%>
                  <tr style="height:10px"></tr>
                  <tr >
                      <td width=20% style="font-weight:bold"><?php dic("Fm.Code")?>:</td>
                      <td width=30% style="padding-left:10px"><input id="code" value="<?php echo $code ?>" type="text" size=22 style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/></td>
                  </tr>
                  <tr>
                      <td width=20% style="font-weight:bold;"><?php dic("Settings.TitleOrg")?>:</td>
                      <td width=30% style="padding-left:10px"><input id="name" value="<?php echo $name ?>" type="text" size=22 style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:300px; padding-left:5px"/></td>
                      
                  </tr>
                  <tr>
                     
                      <td  width=20% style="font-weight:bold; padding-bottom:56px"><?php dic("Fm.Note") ?>:</td>
                      <td style="padding-left:10px">
                           <textarea id="desc" style=" border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; width:99%; height:80px; padding:5px"><?php echo $desc ?></textarea> 
                      </td>
                  </tr>
              
     </table>

</body>


<script>
//top.ShowWait();

    lang = '<?php echo $cLang?>';
    var allRemoved = "";
     
    function modify() {
		var code = document.getElementById("code").value;
        var name = document.getElementById("name").value;
        var desc = document.getElementById("desc").value;

        $.ajax({
              url: "UpdateOrgUnit.aspx?code=" + code + "&name=" + name + "&desc=" + desc + "&id=" + '<?php echo $id ?>',
              context: document.body,
              success: function (data) {
                     top.document.getElementById('ifrm-cont').src = "Organisation.php?l=" + '<?php echo $cLang ?>';     
              }
        }); 
    }

   function removeItem(i, id) {
         var element = document.getElementById("tr" + i);
         element.parentNode.removeChild(element);
         allRemoved += id + ";";
    }

    function cancel() {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "Organisation.php?l=" + '<?php echo $cLang ?>';
    }

    //setDates();
    top.HideWait();
  //  SetHeightLite();
   // iPadSettingsLite();
      

    $('#mod1').button({ icons: { primary: "ui-icon-pencil"} })
    $('#ok').button({ icons: { primary: "ui-icon-check"} })
    $('#addAllDri').button({ icons: { primary: "ui-icon-plusthick"} })
    $('#cancel1').button({ icons: { primary: "ui-icon-arrowreturnthick-1-w"} })

</script>

<?php
	closedb();
?>
</html>
