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

	<script type="text/javascript" src="../js/jquery.js"></script>
	
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
	
	<script type="text/javascript" src="routes.js"></script>
	<script type="text/javascript" src="./js/highcharts.src.js"></script>

	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="../js/jquery-ui.js"></script>
	<script src="../report/js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src="../tracking/live.js"></script>
	<script type="text/javascript" src="../tracking/live1.js"></script>
    <script type="text/javascript" src="../js/OpenLayers.js"></script>
	<script src="../js/jsxcompressor.js"></script>
</head>

<?php

	opendb();
	$Allow = getPriv("routespredefined", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);
	$user_id = Session("user_id");
	
	$dsAll = query("select defaultmap, datetimeformat, timezone, metric, cl.clienttypeid, ci.latitude, ci.longitude from users u left outer join clients cl on cl.id = u.clientid left outer join cities ci on ci.id = cl.cityid where u.id = " . $user_id);

	$datetimeformat = pg_fetch_result($dsAll, 0, 'datetimeformat');
	$datfor = explode(" ", $datetimeformat);
	$dateformat = $datfor[0];
	$timeformat =  $datfor[1];
	if ($timeformat == 'h:i:s') $timeformat = $timeformat . " A";
	if ($timeformat == "H:i:s") {
		$tf = " H:i";
	}	else {
		$tf = " h:i A";
	}
	$datejs = str_replace('d', 'dd', $dateformat);	
	$datejs = str_replace('m', 'mm', $datejs);
	$datejs = str_replace('Y', 'yy', $datejs);
    $clientType = pg_fetch_result($dsAll, 0, "clienttypeid");
    $clientUnit = pg_fetch_result($dsAll, 0, "metric");
    
    //dim allPOI as integer = dlookup("select count(*) from pinpoints where clientID=" & session("client_id"))
    //Dim allPOIs As String = "false"
    //If allPOI < 1000 Then allPOIs = "true"
	
    $DefMap = pg_fetch_result($dsAll, 0, "defaultmap");
    
	$currDateTime = new Datetime();
    $currDateTime = $currDateTime->format("d-m-Y H:i");
	$currDateTime1 = new Datetime();
	$currDateTime1 = $currDateTime1->format("d-m-Y");
	
    $AllowedMaps = "11111";

    $cntz = dlookup("select count(*) from pointsofinterest where active='1' and type=2 and clientid=" . Session("client_id"));
    //$CurrentTime = DlookUP("select Convert(nvarchar(20), DATEADD(HOUR,(select timeZone from clients where ID=" . Session("client_id") . ") - 1,GETDATE()), 120) DateTime");
    $tzone = pg_fetch_result($dsAll, 0, "timezone");
    $tzone = $tzone - 1;

    $ua=getBrowser();
	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
    
    addlog(33, '');
	
?>



<style>
	.ui-autocomplete {
		max-height: 100px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
		/* add padding to account for vertical scrollbar */
		padding-right: 20px;
		width:300px;
	}
</style>
<script>
	function brisi(_id){
		if (confirm(dic("Routes.DeleteOrderQuestion",lang))==true) {
			$('#div-nalog-'+_id).hide( 'drop', {}, 1000);
			$.ajax({
				  url: 'delNalog.php?id=' + _id + '&pred=1',	
				   success: function(data) {
						
				   }									
			});		
		}
	}
	function promeni(_id){
		document.getElementById('frm-promeni').src = 'EditNalogPre.php?l='+lang +'&id='+_id
		//$('#div-promeni').dialog({ width: document.body.offsetWidth - 10, height: document.body.offsetHeight - 10 });
		$('#div-promeni').dialog({ width: '100%', height: document.body.offsetHeight - 10 });
	}
</script>	
<body style="margin:0px 0px 0px 0px; padding:0px 0px 0px 0px" onResize="SetHeightLite()">

<div id="report-content" style="width:100%; text-align:left; height:500px; background-color:#fff; overflow-y:auto; overflow-x:hidden" class="corner5">
	<div style="padding-left:40px; padding-top:10px; width:500px" class="textTitle">
		<?php echo dic("Routes.PredefinedOrders")?>&nbsp;&nbsp;&nbsp;&nbsp;
	</div><br>
    <div id="likeapopup" style="visibility: hidden; position: absolute; left: -1000px; border: 2px solid Orange; z-index: 100;  width: 452px; height: 450px; background: none repeat scroll 0% 0% white;">
        <div id="div-map" style="width: 450px; height: 400px; border:1px dotted #2f5185; z-index: 1; position: relative;"></div>
	    <div id="radioBtnDiv" style="position: relative; float: left; width: 350px; top: 10px; left: 10px;">
            <input type="radio" runat="server" name="testGroup" value="1" id="test1" style="cursor:hand;width: 70px;" checked /><label id="Label1" for="test1" style="cursor:hand;" runat="server"><?php echo dic("Routes.Normal")?></label>
            <input type="radio" runat="server" name="testGroup" value="2" id="test2" style="cursor:hand;width: 70px;" /><label id="Label2" for="test2" style="cursor:hand;" runat="server"><?php echo dic("Routes.Fast")?></label>
        </div>
        <div style="position: relative; float: right; width: 70px; top: 10px; right: 10px;" onclick="closwin()">
        	<input type="text" id="Close" value="<?php echo dic("Settings.Close")?>" style="width: 70px" />
    	</div>
    </div>
    <script type="text/javascript">
        $('#test1').button();
        $('#test2').button();
        $('#Close').button();
        $("input[name='testGroup']", $('#radioBtnDiv')).change(
            function (e) {
                // your stuffs go here
                //if ($('#MarkersIN')[0].children.length > 1) {
                ReDrawRoute($(this).val());
                //}
            });
            
    </script>
	<div class="corner5" style="position: relative; z-index: 99; width:95%; padding:10px 10px 10px 10px; border:1px solid #bbb; background-color:#fafafa; margin-left:1%">
			<?php
				
				$dsPre = query("select h.id, h.name, u.fullname, h.datetime from rNaloghederpre h left outer join users u on u.id=h.userID where Name<>'' and h.clientID=" . session("client_id") . " order by h.datetime desc");
				$cnt = 0;
				
				if (pg_num_rows($dsPre) > 0) {
				while($row = pg_fetch_array($dsPre))
				{
					$dtTmp = new Datetime($row["datetime"]);
					$dtTmp = $dtTmp->format($tf . " " . $dateformat);
			?>
			<div id="div-nalog-<?php echo $row["id"]?>">
			<div class="corner5 text5" style="font-size:16px; height:21px; width:600; padding:5px 5px 5px 10px; border:1px solid #009900; background-color:#DBFDEA; margin-left:20px;">
				<div style="position: relative; float:left; width: 410px;  white-space: nowrap;  overflow: hidden;  text-overflow: ellipsis;" onmousemove="isEllipsisActive(this, event, '<strong><?php echo $row["name"]?></strong> (<?php echo $row["fullname"]?> <?php echo $dtTmp?>)'); " onmouseout="HidePopup()">
					<button style="border:0; background-color:transparent; position: relative; left:-9px; top: -1px; width: 15px" id="btn-hide<?= $cnt?>" value="+" onclick="hideDiv(<?= $cnt?>)">&nbsp;</button>
					<strong><?php echo $row["name"]?></strong> 
					<span style="font-size:11px">(<?php echo $row["fullname"]?> <?php echo $dtTmp?>)</span>
				</div>
				<button onClick="resizeDiv(event);LoadRoutePre(<?php echo $row["id"]?>)" class="text5" style="font-size:11px; float:right"><?php echo dic("Routes.Map")?></button>
				<button onClick="brisi(<?php echo $row["id"]?>)" class="text5" style="font-size:11px; float:right"><?php echo dic("Routes.Delete")?></button>
				<button onClick="promeni(<?php echo $row["id"]?>)" class="text5" style="font-size:11px; float:right"><?php echo dic("Routes.Mod")?></button>
			</div>
			<div id="detail<?= $cnt?>">
			<?php
				
				$dsPreD = query("select opis, rbr from rNalogDetailpre nd left outer join pointsofinterest poi on poi.id=nd.ppid where nd.hederid=" . $row["id"] . " and poi.active='1' order by rbr asc");
				
				while($row1 = pg_fetch_array($dsPreD))
				{
			?>
			<div class="corner5 text5" style="font-size:12px; width:500; padding:2px 2px 2px 10px; border:1px solid #CCCCCC; background-color:#F3F3F3; margin-left:50px; margin-top:5px">
				<?php echo $row1["rbr"]?>.&nbsp;&nbsp;&nbsp;<?php echo $row1["opis"]?>
			</div>
			<?php
			
				}
			?>
			</div>
			
			<br>
			</div>
			<?php
			$cnt++;
				}
			 } else {
			?>
            
            <div id="noData" style="padding:10px; font-size:30px; font-style:italic;" class="text4">
	        	<?php echo dic_("Routes.NotCreatedPreOrders")?>
	   		</div>
            <?php
				}
			?>
	</div>
	
	<br><br>
	<div id="div-promeni" title="<?php echo dic("Routes.MOrder")?>" style="display:none">
		<iframe id="frm-promeni" frameborder="0" scrolling="yes" style="width:100%; height:100%; overflow-y: auto; overflow-x: hidden"></iframe>
	</div>
	<br>
	<div id="footer-rights-new" class="textFooter" style="padding:10px 10px 10px 10px">

	</div>
	<br>    
	
		
</div>

</body>
</html>



<script type="text/javascript">
	function hideDiv(_cnt) {
		if($('#detail'+_cnt).css('display') == 'none') {
			$('#detail'+_cnt).fadeIn("slow", function() {});
			$("#btn-hide"+_cnt).button({
	            icons: {primary: "ui-icon-triangle-1-s"}
        	});
		} else {
       		$('#detail'+_cnt).fadeOut("slow", function() {});
			$("#btn-hide"+_cnt).button({
	            icons: {primary: "ui-icon-triangle-1-e"}
       		});
		}
		$("#btn-hide"+_cnt).removeClass("ui-state-focus");
	}
	function isEllipsisActive(d, event, _txt) {
	     if (d.offsetWidth < d.scrollWidth) {
	     	ShowPopup(event, _txt)
	     }
	}

	top.changeItem = false;

	pause1 = '0';
	pause2 = '0';
	pause3 = '0';
	pause4 = '0';
	pause5 = '0';
	allowbuttons = false;
	tostay = '0';

    lang = '<?php echo $cLang?>';

    var clientUnit = '<?php echo $clientUnit?>';

    AllowedMaps = '<?php echo $AllowedMaps?>';
    DefMapType = '<?php echo $DefMap?>';
    var cntz = parseInt('<?php echo ($cntz-1)?>');

    LoadCurrentPosition = false;
    JustSave = false;

    ShowAreaIcons = true
    OpenForDrawing = false;
    ShowVehiclesMenu = false;
    ShowPOIBtn = true;
    ShowGFBtn = true;
    var RecOn = false;
    var RecOnNew = false;
    var PointsOfRoute = [];
    CreateBoards();
		
    SetHeightLite()
    iPadSettingsLite()
    top.HideLoading()
    $('#txtSDate').datepicker({
			    dateFormat: 'dd-mm-yy',
			    showOn: "button",
			    buttonImage: "../images/cal1.png",
			    buttonImageOnly: true
		    });

    if (Browser()=='iPad') {top.iPad_Refresh()}

    //stoenje
    $(document).ready(function () {
        $('#div-map').css({ height: '402px' });
        //$('#likeapopup111').css({ display: 'none' });
        for (var i = 0; i < <?= $cnt?>; i++) {
        	$('#btn-hide' + i).button({icons: {primary: "ui-icon-triangle-1-s "}});
        }
        top.HideWait();
    });
    function resizeDiv(e) {
        //if (parseInt($('#likeapopup').css('width'), 10) - 100 > e.clientY)
            //$('#likeapopup').css({ top: e.clientY + 'px' });
        //else
            //$('#likeapopup').css({ top: e.clientY - (parseInt($('#likeapopup').css('width'), 10) - e.clientY + 100) + 'px' });
        //$('#likeapopup').css({ left: (e.clientX + 50) + 'px' });
        $('#likeapopup').css({ top: ((document.body.offsetHeight / 2) - ((parseInt($('#likeapopup').css('height'), 10) / 2))) + 'px' });
        $('#likeapopup').css({ left: ((document.body.offsetWidth / 2) - ((parseInt($('#likeapopup').css('width'), 10) / 2))) + 'px' });
        //$('#likeapopup111').css({ display: 'block' });
        //document.getElementById('likeapopup111').style.visibility = 'visible';
        $('#likeapopup').css({ visibility: 'visible' });
        $('#div-map').css({ display: 'block' });
    }
    setTimeout("LoadMaps();", 1000);
</script>