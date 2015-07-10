<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="../style.css">

	<link rel="stylesheet" href="./css/jquery-ui.css">
	<script src="./js/jquery-1.10.2.js"></script>
	<script src="./js/jquery-ui.js"></script>

	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>

	<script type="text/javascript" src="../routes/routes.js"></script>
	
    <script type="text/javascript" src="live.js"></script>
	<script type="text/javascript" src="live1.js"></script>
    

</head>
<?php
	if (session('user_id') == "261") echo header( 'Location: ../sessionexpired/?l='.$cLang);
	opendb();
	$user_id = Session("user_id");
	$client_id = Session("client_id");
	$roleid = Session("role_id");
	$currDateTime = new Datetime();
	$currDateTime = $currDateTime->format("d-m-Y H:i");
	$currDateTime1 = new Datetime();
	$currDateTime1 = $currDateTime1->format("d-m-Y");
	
	$clientUnit = dlookup("select metric from users where id=" . session("user_id"));
	
	$ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	
	$allowedrouting = dlookup("select allowedrouting from clients where id=" . session("client_id"));
	if(!$allowedrouting)
	{
		$routes = 'return false;';
	}
?>
<body style="margin:0px 0px 0px 0px; padding:0px 0px 0px 0px" onResize="SetHeightLite()">

<div id="report-content" style="width:100%; text-align:left; height:500px; background-color:#fafafa; overflow-y:auto; overflow-x:hidden" class="corner5">
	<div id="tabs" style="width: 100%; height:0px; left:0px; position:absolute; z-index:9999; background:none; border:none;">
		<ul style="background: none repeat scroll 0% 0% transparent; border-width: medium medium 1px; border-style: none none solid; border-color: -moz-use-text-color -moz-use-text-color rgb(204, 204, 204); -moz-border-top-colors: none; -moz-border-right-colors: none; -moz-border-bottom-colors: none; -moz-border-left-colors: none; border-image: none; padding-right: 0px; margin-left: -10px; padding-left: 20px; z-index: 8; padding-top: 3px;">
			<li><a href="./NaloziDenes.php" style="color: #2f5185; font-family: Arial, Helvetica, sans-serif;font-size: 13px;"><?=dic("Routes.Orders")?></a><img onclick="<?php echo $routes?>OpenNewTab('../CurrentOrders/')" onmousemove="ShowPopup(event, 'Отвори денешни налози во нов таб')" onmouseout="HidePopup()" style="cursor: pointer; opacity: 0.25; margin-right: 5px; margin-top: 5px;" src="../images/newtab1.png" width="17px" /></li>
			<li><a href="./CurrentData1.php" style="color: #2f5185; font-family: Arial, Helvetica, sans-serif;font-size: 13px;"><?=dic("Tracking.VehDetails")?></a><img onclick="OpenNewTab('../detail/')" onmousemove="ShowPopup(event, 'Отвори детали за возила во нов таб')" onmouseout="HidePopup()" style="cursor: pointer; opacity: 0.25; margin-right: 5px; margin-top: 5px;" src="../images/newtab1.png" width="17px" /></li>
		</ul>
	</div>
</div>
	<div id="div-promeni" style="display:none">
		<iframe id="frm-promeni" frameborder="0" scrolling="yes" style="width:100%; height:100%; overflow: hidden"></iframe>
	</div>
	<div id="div-print" style="display:none">
		<iframe id="frm-print" frameborder="0" scrolling="no" style="width:800px; height:1200px"></iframe>
	</div>
	<iframe id="frm-excel" frameborder="0" scrolling="no" style="display:none"></iframe>
</body>
</html>

<script type="text/javascript">
	var ar = '<?= $allowedrouting?>';
	if(ar == "1")
	{
		$("#tabs").tabs({
			load: function( event, ui ) {
				$(ui.panel).css({height: (top.$('body').height() - 560) + 'px'});
			},
			active: 1
		});
	} else {
		$("#tabs").tabs({
			load: function( event, ui ) {
				$(ui.panel).css({height: (top.$('body').height() - 560) + 'px'});
			},
			active: 1,
			"disabled": [0]
		});
	}
	
	var _w = $('body').width();
	$("#tabs-1").css({ width: (_w - 14) + 'px' });
	$("#tabs-1").css({ width: (_w - 14) + 'px' });
    lang = '<?php echo $cLang?>';
    $(document).ready(function () {
		SetHeightLite();
    });
	
	iPadSettingsLite()
	if (Browser()=='iPad') {top.iPad_Refresh()}
	//setTimeout("LoadMaps();", 1000);
	function OpenNewTab(_page) {
		//var url ='http://localhost/panorama/'+_page;
		var win = window.open(_page + '?l=' + lang, '_blank');
  		win.focus();
	}
</script>
