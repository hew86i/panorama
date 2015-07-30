<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

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
	<script type="text/javascript" src="fm.js"></script>
	<script type="text/javascript" src="./js/highcharts.src.js"></script>
  
    <link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="../js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
    <script src="../js/jquery-ui.js"></script>

 <body>
 	 <?php
      $LastDay = DatetimeFormat(addDay(-1), 'd-m-Y');

      $cLang = getQUERY('lang');
      ?>

  <table style="padding-left:20px;" class="text2_" width=50%>

  <tr style="height:10px"></tr>

  
   <tr>
      <td width=20% style="font-weight:bold;"><?php dic("Fm.Code") ?>:</td>
      <td width=30% style="padding-left:10px"><input id="code" type="text" size=22 style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px;  border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:150px; padding-left:5px" /></td>
  </tr>

 <tr>
 <td width=20% style="font-weight:bold;"><?php dic("Fm.OrgUnit") ?>:</td>
        <td width=30% style="padding-left:10px"><input id="orgUnit" type="text" size=22 style="margin-top:1px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px;  border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:300px; padding-left:5px" /></td>
      
 </tr>

  <tr>
      <td width=20% style="font-weight:bold; padding-bottom:56px"><?php dic("Fm.Note") ?>:</td>
      <td  style="padding-left:10px">
         <textarea id="desc" style=" border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; width:100%; height:80px; padding:5px; overflow-Y:auto"></textarea>
      </td>
     
  </tr>

  </table>

</body>


<script>
    lang = '<?php echo $cLang?>';
    setDates();
    top.HideWait();

    $('#add1').button({ icons: { primary: "ui-icon-plus"} });
    $('#cancel1').button({ icons: { primary: "ui-icon-arrowreturnthick-1-w"} });


</script>

</html>
