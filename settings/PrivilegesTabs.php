<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php session_start()?>
<?php 
	header("Content-type: text/html; charset=utf-8");

	opendb();
	$Allow = getPriv("privilegesuser", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);

	if(is_numeric(nnull(session("user_id"))) == false){ 
	echo header ("Location: ../sessionexpired/?l=" . $cLang);
	}	

	$dsUsers = query("select id, fullname from users where clientid=" . session("client_id"));

?>
<html>
<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="../js/jquery-ui.js"></script>
    <style type="text/css">
 		body{ overflow-y:auto }
	</style>
	<script>
    $(function() {
        $( "#tabs" ).tabs({
            beforeLoad: function( event, ui ) {
                ui.jqXHR.error(function() {
                    ui.panel.html(
                        "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                        "If this wouldn't be a demo." );
                });
            }
        });
    });
    </script>
</head>
<body>
    <div class="textTitle" style="width: 200px; position: relative; float: left; padding-left:36px; padding-top:25px;"><?php echo dic("Settings.Privileges")?></div>
	<div id="legend" class="textTitle" style="width: 300px; position: relative; float: right; right: 65px; padding-top:25px;">
    	<div class="ui-button ui-state-default ui-widget-content" style="font-size: 11px; float: right; padding-top: 5px; width: 80px; text-align: center; height: 20px; cursor: default;"><?php echo dic("Settings.UnMarked")?></div>
    	<div class="ui-button ui-state-active ui-widget-content" style="font-size: 11px; float: right; padding-top: 5px; width: 80px; text-align: center; height: 20px; cursor: default;"><?php echo dic("Settings.Marked")?></div>
    	<div style="float: right; padding-top: 2px; position: relative; width: 85px; font-size: 17px;"><?php echo dic("Reports.Legend")?>:</div>
    </div>
	<br /><br /><br />
    <p></p>
    
    <div id="tabs" style="width: 94%; left: 30px;">
	    <ul>
	    	<?php
	    	$i = 1;
	    	while ($row = pg_fetch_array($dsUsers)) {
    		?>  
	        	<li><a href="PrivilegesAjax.php?uid=<?php echo $row["id"]?>&l=<?php echo $cLang?>"><font style="font-size: 10px;"><?php echo $row["fullname"]?></font></a></li>
        	<?php
        		$i = $i + 1; 
			}
			?>
	        
	    </ul>
	</div>
	<br />
	<br />
</body>

</html>
  <?php
	closedb();
?>