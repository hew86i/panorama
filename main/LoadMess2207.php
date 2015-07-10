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
	<script>
			lang = '<?php echo $cLang?>'
	</script>
 
<?php

	$messid = getQUERY("messid");
	$fromto = getQUERY("fromto");

	opendb();

      $datetimeformat = dlookup("select datetimeformat from users where id=" . session("user_id"));
      $datfor = explode(" ", $datetimeformat);
      $dateformat = $datfor[0];
      $timeformat =  $datfor[1];
      if ($timeformat == 'h:i:s') $timeformat = $timeformat . " a";
?>
 <body>
 
  <?php
  
  $mess = query("select * from messages where id= " . $messid); 
  if ($fromto == 'inbox') {
	RunSQL("update messages set checked='1' where id= " . $messid); 
  }
  	
  $totalUnreadInbox = dlookup("select count(*) from messages where checked='0' and toid=" . session("user_id"));
  ?>
 
 <table class="text2_" width=95% style="margin:35px">
 <tr>
 	<td width=20% style="font-size:16px; font-weight: bold"><!--<?php echo pg_fetch_result($mess, 0, "subject") ?>--></td>
 	<td width=80% style="text-align: right; font-size:11px">
 	<?php
 	if ($fromto == "inbox") {
 		$from = dlookup("select fullname from users where id=" . pg_fetch_result($mess, 0, "fromid"));
 		?>
 		<?php echo dic_("Reports.From")?>: <strong><?php echo $from ?></strong>
 		<?php
 	} else {
 		if (pg_fetch_result($mess, 0, "toobject") == 'user') {
  			$to = dlookup("select fullname from users where id=" . pg_fetch_result($mess, 0, "toid"));
  		} else {
  			$to = dlookup("select registration from vehicles where id=" . pg_fetch_result($mess, 0, "toid"));
  		}
 		?>
 		<?php echo dic_("Reports.To")?>: <strong><?php echo $to?></strong>
		<?php
 	}
 	?>
 		<br>
 		<?php echo dic_("Reports.DateTime")?>: <strong><?php echo DateTimeFormat(pg_fetch_result($mess, 0, "datetime"), $datetimeformat) ?></strong>
 	</td>
 </tr>
 
 <tr>
 	<td colspan=2 style="padding-top:25px">
 		<?php echo pg_fetch_result($mess, 0, "body") ?>
 	</td>
 </tr>
 </table>
 
  <?php
  
  closedb();
?>
</body>


<script>
	if (top.document.getElementById('img-' + '<?php echo $messid?>')) {
		top.document.getElementById('img-' + '<?php echo $messid?>').src = "../images/messageread.png";
		top.document.getElementById('img-' + '<?php echo $messid?>').style.width = "12px";
		top.document.getElementById('img-' + '<?php echo $messid?>').style.height = "12px";
	    top.document.getElementById('table-' + '<?php echo $messid?>').style.color = "#8c8c8c";
		top.document.getElementById('spanUnread').innerHTML = "<?php echo $totalUnreadInbox?>";
		} 
	top.HideWait();

</script>


</html>
