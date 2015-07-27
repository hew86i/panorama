﻿<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>


<?php
	header("Content-type: text/html; charset=utf-8");
	opendb();

	$uid = session('user_id');
	$cid = session('client_id');

	// echo $cid . " " . $uid; die();

	$Allow = getPriv("vehicles", session("user_id"));
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);

	addlog(42);
?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../live/style.css">

	<script type="text/javascript" src="../js/jquery-1.5.2.min.js"></script>
	<!-- <script type="text/javascript" src="../js/jquery.js"></script> -->
	<script type="text/javascript" src="../js/roundIE.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
    <script type="text/javascript" src="../pdf/pdf.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="./js/highcharts.src.js"></script>
    <link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />

	<style type="text/css">
		html
		{
		    overflow: auto;
		    -webkit-overflow-scrolling: touch;
		}
		body
		{
		    height: 100%;
		    overflow: auto;
		    -webkit-overflow-scrolling: touch;
		}
		.align-center {
		    margin-left: auto;
		    margin-right: auto;
		    width: 95%;
		}
		.la {
			text-align: left !important;
		}
		.ca {
			text-align: center !important;
		}
		.t-sp {
			margin-top: 30px;
		}
		.input-search {
			color: #2F5185;
			font-family: Arial,Helvetica,sans-serif;
			font-size: 11px;
			height:25px;
			border: 1px solid #CCCCCC;
			border-radius: 5px 5px 5px 5px;
			width:161px; padding-left:5px;
		}

	</style>

 <body>
 	<script> if (!"<?php echo is_numeric(session('user_id')) ?>")
 		top.window.location = "../sessionexpired/?l=" + '<?php echo $cLang ?>';
 	</script>

<!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> DIALOGS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> -->

<div id="div-add" style="display:none" title=""></div>
<div id="div-cost" style="display:none" title="Додавање нов трошок"></div>
<div id="div-costnew" style="display:none" title="Додавање нов тип на трошок"></div>
<div id="div-loc" style="display:none" title="Додавање нов извршител"></div>
<div id="div-comp" style="display:none" title="Додавање новa компонента"></div>
<div id="dialog-message" title="<?php dic("Reports.Message")?>" style="display:none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px"></div>
	</p>
</div>

<div id="dialog-message1" title="<?php dic("Reports.Warning")?>" style="display:none">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox1" style="font-size:14px"></div>
	</p>
</div>
<!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> -->

<?php

 $cnt_ = 1;
 $cnt_1 = 1;

 $americaUser = dlookup("select count(*) from cities where id = (select cityid from users where id=".session("user_id").") and countryid = 4");
 $americaUserStyle = ($americaUser == 1) ? "display: none" : "";

 $currency = dlookup("select currency from users where id=" . $uid);
 $currencyvalue = dlookup("select value from currency where name='" . $currency . "'");
 $liqunit1 = dlookup("select liquidunit from users where id=" . $uid);
	if ($liqunit1 == 'galon')
	{
		$liqvalue = 0.264172;
		$liqunit = "gal";
	}
	else
	{
		$liqvalue = 1;
		$liqunit = "lit";
	}
	$metric = dlookup("select metric from users where id=" . $uid);
	if ($metric == 'mi') $metricvalue = 0.621371;
	else $metricvalue = 1;

$datetimeformat = dlookup("select datetimeformat from users where id=" . $uid);
$datfor = explode(" ", $datetimeformat);
$dateformat = $datfor[0];
$timeformat =  $datfor[1];
if ($timeformat == 'h:i:s') {
	$timeformat = $timeformat . " A";
	$datetimeformat = $datetimeformat . " A";
}

?>

<div class="align-center t-sp" style="margin-bottom: 25px;">
	<table>
		<tr class="text2_">
		  	<td width="80%" class="textTitle la"><?php dic("Fm.Vehicles")?></td>
		    <td width="20%" class="ca" ><?php dic("Settings.SearchVehNum") ?>:</td>
		    <td width="20%" class="ca" style="padding-left:30px" ><?php dic("Fm.SearchReg")?>:</td>
		</tr>
		<tr class="text2">
			<td></td>
		    <td class="ca"><input class="input-search" id="inp1" name="filter" type="text" size="22"/></td>
		    <td class="ca"><input class="input-search" id="inp2" name="filter" type="text" size="22" style="margin-left:30px;"/></td>
		</tr>
	</table>
</div>

<style type="text/css">

	.table-title{
		color:#fff;
		font-weight:bold;
		font-size:14px;
		border:1px solid #ff6633;
		padding-left:7px;
		background-color:#f7962b;
	}
	.table-col-header {
		font-weight:bold;
		background-color:#E5E3E3;
		border:1px dotted #2f5185;
	}

</style>

<?php

$qGetUser = pg_fetch_assoc(query("select * from users where id=" . $uid));

$role_id = $qGetUser['roleid'];

$dsOU = query("select id, name, code from organisation where clientid=".$cid);

$AllOU = pg_fetch_all($dsOU);
$ungroupedVeh = array('id' => 0, 'name' => dic_("Fm.UngroupedVeh"), 'code' => 'uv000' );
array_push($AllOU,$ungroupedVeh);  // za sekogas da bide posledna

// print_r($AllOU);die();

// while($rowOU = pg_fetch_assoc($dsOU)) {
foreach ($AllOU	as $rowOU) {

	if($role_id == 2) $dsVh = query("select * from vehicles where active='1' and organisationid = " . $rowOU["id"] . " and clientid = " . $cid . " order by code::INTEGER");
	else 			  $dsVh = query("select * from vehicles where active='1' and organisationid = " . $rowOU["id"] . " and id in(select vehicleid from uservehicles where userid = ".$uid.") and clientid = " . $cid. " ORDER BY code::INTEGER");

	$cnt = 1;
	$cnt1 = 1;
	$cnt2 = 1;

	if(pg_num_rows($dsVh) > 0){ ?>

	<table id="tabId<?php echo $cnt2 ?>" class="align-center t-sp">
		<!-- >>> TABLE HEADER >>>>>>>>>>>>>>>>>>>>>>>>>>> -->
		<tr>
		    <td height="22px" class="text2_ table-title" colspan=10>
		        <?php echo ($rowOU["code"] != "uv000") ? $rowOU['code'].". ".$rowOU['name'] : $rowOU['name']?>
		    </td>
		</tr>

		<tr>
		    <td width="10%"  height="22px" align="center" class="text2 table-col-header"><?php dic("VehicleNumber") ?></td>
		    <td width="17%" height="22px" align="center" class="text2 table-col-header"><?php dic("Fm.Registration")?></td>
		    <?php
		    if (session("client_id") == 259) {
		    	?>
		    	<td width="11%" height="22px" align="center" class="text2 table-col-header" style="" class="text2"><?php dic("Admin.GSMnumber")?></td>
		    	<?php
		    }
		    ?>

		    <td width="15%" height="22px" align="center" class="text2 table-col-header"><?php dic("Fm.Model") ?></td>
		    <td width="16%" height="22px" align="center" class="text2 table-col-header">
		    	<table width=100%>
		    		<tr class="text2" style="font-weight:bold;"><td colspan=2 align="center"><? echo dic_("Settings.Registration")?></td></tr>
		    		<tr class="text2" style="font-weight:bold;">
		    			<td align="center"><? echo dic_("Settings.Last")?></td>
		    			<td align="center"><? echo dic_("Settings.Next")?></td>
		    		</tr>
		    	</table>
		    </td>
		    <td width="11%"  height="22px" align="center" class="text2 table-col-header" style="<?=$americaUserStyle?>; "><?php echo dic("Settings.GreenCard")?></td>
		    <td width="13%" height="22px" align="center" class="text2 table-col-header" ><?php echo dic("Settings.LastData")?></td>
		    <!--<td width="8%"  height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; color:#ff6633" class="text2"><?php echo dic_("Reports.Costs")?></td>-->
			<td width="9%"  height="22px" align="center" class="text2 table-col-header" style="color:#ff6633"><?php dic("Settings.VisibleLive")?></td>
			<td width="9%"  height="22px" align="center" class="text2 table-col-header" style="color:#ff6633"><?php dic("Fm.Mod") ?></td>
		</tr>

		<!-- >>> TABLE DATA >>>>>>>>>>>>>>>>>>>>>>>>>>> -->
		<?php

	    $paren = "";
        $greenCard = "";
		$activity = "";
        $actYN = 0;
        $id = 0;
         
		 while ($rV = pg_fetch_array($dsVh)){
		 	$zaAlias = dlookup("select count(*) from vehicles where alias <> '' and id=" . $rV["id"]);
							 
             $id = $rV["id"];
			 
             If ($rV["greencard"] == 1)
			 {
                 $greenCard = "../images/stikla2.png";
                 $actYN = 1;
             } 
             else
			 {
                 $greenCard = "../images/stikla3.png";
                 $actYN = 0;
             }
			 
			 If ($rV["visible"] == 1)
			 {
                 $activity = "../images/stikla2.png";
             } 
             else
			 {
                 $activity = "../images/stikla3.png";
             }
                            
            $_lastReg = explode(" ", DateTimeFormat($rV["lastregistration"], "d-m-Y"));
      		$lastReg = $_lastReg[0];
	   		$fuelType = query("select name from fueltypes where id = (select fueltypeid from vehicles where id=" . $rV["id"] . ")");
			$row1 = pg_fetch_array($fuelType);
			//$lastDate = nnull(dlookup('select "DateTime" from currentposition where vehicleid=' . $rV["id"]), '/');	
			$ld = query('select "DateTime" from currentposition where vehicleid=' . $rV["id"]);
			if (pg_num_rows($ld) > 0)
				$lastDate = nnull(pg_fetch_result($ld, 0, 0), "/");
			else 
				$lastDate = "/";
			
			if ($lastDate <> "/") $lastDate = DateTimeFormat($lastDate, 'd-m-Y H:i:s');
			$color = "";
			
							
			if ($lastDate <> "/") {
				if (round(abs(strtotime(now())-strtotime($lastDate))/60) > 1440) $color = "red";	
				else $color = "green";
			}
			
            ?>
             
            <tr id="veh<?php echo $cnt ?>" style="" onmouseover="over(<?php echo $cnt ?>, 0, <?php echo $actYN ?>)" onmouseout="out(<?php echo $cnt ?>, 0, <?php echo $actYN ?>)">
            
            <td id="td-1-<?php echo $cnt ?>" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; "><?php echo $rV["code"]?></td>
            <td id="td-2-<?php echo $cnt ?>" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;"><strong><?php echo $rV["registration"] ?></strong><br><?php if($zaAlias>0){?><font style="font-size:10px">(<?php echo $rV["alias"];?>)</font><?php }else{ echo "";}?></td>
            <?php
            if (session("client_id") == 259) {
            ?>
            <td id="" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; "><?php echo $rV["gsmnumber"]?></td>
            <?php
        	}
            ?>
            <td id="td-3-<?php echo $cnt ?>" height="30px" align="center" class="text2 <?php echo $paren ?>" style="background-color:#fff; border:1px dotted #B8B8B8;" >
        	<b><?php echo $rV["model"]?></b><br>
        	<?php if($row1["name"]=="Бензин")
            {
            ?>
            &nbsp;(<font style="font-size:10px"><?php echo dic("Settings.Petrol")?></font>)
            <?php
            }
            if($row1["name"]=="Дизел")
			{
			?>
			&nbsp;(<font style="font-size:10px"><?php echo dic("Settings.Diesel")?></font>)
		 	<?php
			}
			if($row1["name"]=="LPG")
			{
			?>
			&nbsp;(<font style="font-size:10px"><?php echo dic("Settings.Gas")?></font>)
		 	<?php
			}
			?>
			</div>
			</td>
            <td id="td-4-<?php echo $cnt?>" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
            	<table width=100%>
            		<tr class="text2">
            			<td align="center"><?php echo DateTimeFormat($rV["lastregistration"], $dateformat) ?></td>
            			<?php
            			//$totalDaysOfYear = date("z", mktime(0,0,0,12,31,DateTimeFormat($lastReg, 'Y'))) + 1;
            			$nextReg = DateTimeFormat(date('Y-m-d', strtotime($lastReg. ' + 1 year')), $dateformat);
						$diffDays = DateDiffDays(DateTimeFormat(now(), 'Y-m-d'), date('Y-m-d', strtotime($lastReg. ' + 1 year')));
						$colorReg = "";
						$titleReg = "";

						if ($diffDays < 0) {
							$colorReg = "#FF0000";
							$titleReg = dic_("Fm.RegLess") . " " . number_format(abs($diffDays)) . " " . dic_("Fm.Days_"). ".";
						} else {
							if ($diffDays < 14 and $diffDays > 0) {
								$colorReg = "#F7962B";
								$titleReg = dic_("Fm.VehMore") . (number_format($diffDays) - 1) . " " . dic_("Fm.DaysReg");
							} else {
								if ($diffDays == 0) {
									$colorReg = "#F7962B";
									$titleReg = dic_("Fm.RegToday");
								} else {
									$colorReg = "#008000";
									$titleReg = dic_("Fm.VehMore") . (number_format($diffDays) - 1) . " " . dic_("Fm.DaysReg");
								}
							}
						}

            			?>
            			<td align="center" style="color: <?php echo $colorReg?>" title="<?php echo $titleReg?>"><?php echo $nextReg ?></td>
            		</tr>
            	</table>
            </td>
            <td id="td-5-<?php echo $cnt?>" height="30px" align="center" class="text2" style="<?=$americaUserStyle?>; background-color:#fff; border:1px dotted #B8B8B8;">
                  <img id="act<?php echo $cnt?>" width= "11px" height = "11px" src="<?php echo $greenCard?>"  />
            </td>
            <td id="td-6-<?php echo $cnt?>" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; color:<?php echo $color?>"><?php echo DateTimeFormat($lastDate, $datetimeformat)?></td>
            <!--
            <td id="td-7-<?php echo $cnt ?>" width="8%" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                <button id="costBtn<?php echo $cnt ?>" onclick="costVehicle(<?php echo $cnt ?>, <?php echo $id ?>, '<?php echo $rV["registration"] ?> (<?php echo $rV["code"] ?>) <?php echo $rV["alias"] ?>')" style="height:22px; width:30px"></button>
            </td>
            -->
			<td id="td-9-<?php echo $cnt?>" height="30px" align="center" class="text2 <?php echo $paren?>" style="background-color:#fff; border:1px dotted #B8B8B8;">
                 <img id="act<?php echo $cnt?>" width= "11px" height = "11px" src="<?php echo $activity?>"  />
                 <!--<button id="delBtn<?php echo $cnt ?>" onclick="del(<?php echo $rV["id"] ?>, '<?php echo $cLang ?>', 'vehicles')" style="height:22px; width:30px"></button>-->
            </td>

			<td id="td-8-<?php echo $cnt?>" height="30px" align="center" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
                <button id="modBtn<?php echo $cnt ?>" onclick="modifyVehicle(<?php echo $cnt ?>, <?php echo $id ?>)" style="height:22px; width:30px"></button>
            </td>

        </tr>

		<?php
			$cnt = $cnt + 1;
			$cnt1 = $cnt1 + 1;
            }//end while
        ?>
		<!-- >>> [END] TABLE DATA >>>>>>>>>>>>>>>>>>>>> -->
	</table>

<?php

	} // [end] if have data

	$cnt2++;

} // [end] while za grupirani
?>


<div style="height:40px">&nbsp;</div>

</body>

<?php $cLang = getQUERY("l"); ?>

<script>

	<?php 
	$ds = query("select allowedfm from clients where id=" . session("client_id"));
	$allowedFM = pg_fetch_result($ds, 0, "allowedfm");
	 
	if($allowedFM==0)
	{
	?>
	    for(var i = 0; i < <?php echo $cnt ?>; i ++) 
	    {
	    	   	/*$('#costBtn' + i).button({ icons: { primary: "ui-icon-script"} }).button("disable");*/
		    	$('#modBtn' + i).button({ icons: { primary: "ui-icon-pencil"} });
		    	/*$('#delBtn' + i).button({ icons: { primary: "ui-icon-trash"} });*/
		}
	<?php 
	}
	else
	{
	?>
		for(var i = 0; i < <?php echo $cnt ?>; i ++) 
	    {
				/*$('#costBtn' + i).button({ icons: { primary: "ui-icon-script"} });*/
		    	$('#modBtn' + i).button({ icons: { primary: "ui-icon-pencil"} });
		    	/*$('#delBtn' + i).button({ icons: { primary: "ui-icon-trash"} });*/
		}
	<?php
	}
	?>
    <?php
	
	if($allowedFM==0)
	{
	?>
	    for(var z = 0; z < <?php echo $cnt_ ?>; z++)
	    {
	    	 
				/*$('#_costBtn-' + z).button({ icons: { primary: "ui-icon-script"} }).button("disable");*/
				$('#_modBtn-' + z).button({ icons: { primary: "ui-icon-pencil"} });
		        /*$('#_delBtn-' + z).button({ icons: { primary: "ui-icon-trash"} });*/
		}
	<?php 
	}
	else
	{
	?>
		for(var z = 0; z < <?php echo $cnt_ ?>; z++)
	    {
				/*$('#_costBtn-' + z).button({ icons: { primary: "ui-icon-script"} });*/
		        $('#_modBtn-' + z).button({ icons: { primary: "ui-icon-pencil"} });
		       /* $('#_delBtn-' + z).button({ icons: { primary: "ui-icon-trash"} });*/
	    }
    <?php
	}
    ?>


    function over(i, x, act) 
    {
		if (x == 1)
		{
		         for (var j = 1; j < 6; j++) {
		            document.getElementById("_td-" + j + "-" + i).style.color = "blue";
		        }
		
		        if (act == "0") {document.getElementById("_act" + i).src = "../images/stikla3.png";}
		        else {document.getElementById("_act" + i).src = "../images/stikla2.png";}
		
		        document.getElementById("_modBtn-" + i).style.border = "1px solid #0000ff";
		        //document.getElementById("_delBtn-" + i).style.border = "1px solid #0000ff";
		        /*if (document.getElementById("_costBtn-" + i))
		        	document.getElementById("_costBtn-" + i).style.border = "1px solid #0000ff";*/
		}
		else
		{
		        for (var j = 1; j < 6; j++) {
		            document.getElementById("td-" + j + "-" + i).style.color = "blue";
		        }
		
		        if (act == "0") {document.getElementById("act" + i).src = "../images/stikla3.png";}
		        else {document.getElementById("act" + i).src = "../images/stikla2.png";}
		
		        document.getElementById("modBtn" + i).style.border = "1px solid #0000ff";
		        //document.getElementById("delBtn" + i).style.border = "1px solid #0000ff";
		        /*if (document.getElementById("costBtn" + i))
		        	document.getElementById("costBtn" + i).style.border = "1px solid #0000ff";*/
		 }
     }

     function out(i, x, act) {
        if (x == 1) {
             for (var j = 1; j < 6; j++) {
                document.getElementById("_td-" + j + "-" + i).style.color = "#2f5185";
            }

            if (act == "0") {document.getElementById("_act" + i).src = "../images/stikla3.png";}
            else {document.getElementById("_act" + i).src = "../images/stikla2.png";}

           document.getElementById("_modBtn-" + i).style.border = "";
           /* document.getElementById("_delBtn-" + i).style.border = "";
            if (document.getElementById("_costBtn-" + i))
            	document.getElementById("_costBtn-" + i).style.border = "";*/
        }
        else{
             for (var j = 1; j < 6; j++) {
                document.getElementById("td-" + j + "-" + i).style.color = "#2f5185";
            }

            if (act == "0") {document.getElementById("act" + i).src = "../images/stikla3.png";}
            else {document.getElementById("act" + i).src = "../images/stikla2.png";}

            document.getElementById("modBtn" + i).style.border = "";
           /* document.getElementById("delBtn" + i).style.border = "";
            if (document.getElementById("costBtn" + i))
            	document.getElementById("costBtn" + i).style.border = "";*/
        }
    }

    function modifyVehicle(i, id) {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "ModifyVehicle.php?id=" + id + "&l=" + lang;
    }
	function costVehicle (i, id, reg) {
		document.getElementById('div-cost').title = dic("Reports.AddingCost") + " - " + reg;
		$.ajax({
	            url: 'AddCost.php?l=' + '<?php echo $cLang?>' + '&vehid=' + id,
	            context: document.body,
	            success: function (data) {
	            	top.HideWait();
	                $('#div-cost').html(data)
	              
	                $('#div-cost').dialog({ modal: true, height: 650, width: 540,
									zIndex: 1001,
	                    buttons:
	                     [
	                         {
	                             text: dic("add", '<?php echo $cLang ?>'),
	                             click: function () {
	                		        if($("#costtype").children(":selected").attr("id") == "Fuel") {
	                		        	var dt = document.getElementById("datetime").value;
	                		        	var driver = "";
	                		        	if (document.getElementById("driver"))
	                		        	driver = document.getElementById("driver").value;
			                            var km = (document.getElementById("km").value).replace(/\,/g,'') / <?php echo $metricvalue?>;
									    var price = (document.getElementById("price").value).replace(/\,/g,'') * <?php echo $currencyvalue?>;
									    var liters = document.getElementById("liters").value / <?php echo $liqvalue?>;
									    var litersLast = document.getElementById("litersLast").value /  <?php echo $liqvalue?>;

										var veh = id;
										var pay = document.getElementById("pay").value;
										var loc = document.getElementById("location").value;
										
										//alert("InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&price=" + price + "&vehID=" + veh)
										document.getElementById('liters').style.border = "1px solid #cccccc"
										document.getElementById('price').style.border = "1px solid #cccccc"
										
										if (liters == "") {
											alert(dic("Reports.EnterFuelSupply"))
											document.getElementById('liters').style.border = "1px solid red"
											document.getElementById('liters').select()
										}
										if (price == "") {
											alert(dic("Reports.EnterFuelCost"))
											document.getElementById('price').style.border = "1px solid red"
											if (liters == "") document.getElementById('liters').select()
											else document.getElementById('price').select()
										}
										
										$.ajax({
								           url: 'CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt,
								           context: document.body,
								           success: function (data) {
								           		if (Math.abs(km - data.replace(",", "")) > (data.replace(",", "") * 20/100)) {
							           			var msg = "<div><?php dic('Reports.KmOdometer')?> (" + document.getElementById("km").value + " " + '<?php echo $metric?>' + ") <?php dic('Reports.KmDifferent')?> (" + addCommas(parseInt(data.replace(",", "") * '<?php echo $metricvalue?>')) + " " + '<?php echo $metric?>' + ").<br><?php dic('Reports.SureKm')?> <font style='color:#FF6633;font-weight:bold'>" + document.getElementById("km").value + " " + '<?php echo $metric?>' + "</font>?</div>";
							           			$('#div-msgbox1').html(msg)
													$( "#dialog:ui-dialog" ).dialog( "destroy" );	
													$( "#dialog-message1" ).dialog({ height: 220, width: 440,
														modal: true,
												        resizable: false,
														zIndex: 9999 ,
														buttons: [{
															text:  dic("add"),
															 click: function () {
																if (price != "" && liters != "") {
																		
																      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
																      $.ajax({
				                                url: "InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&loc=" + loc + "&price=" + price + "&vehID=" + veh + '&pay=' + pay,
				                                context: document.body,
				                                success: function (data) {
				                                    $(this).dialog("close");
				                                    mymsg(dic("Reports.SuccAddFuel"))
				                                    location.reload();
					                                }
					                            });
																        
																        $.ajax({
																              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
																              context: document.body,
																              success: function (data) {
																    
																              }
																        }); 
																        
										                           }
															}},
															{
																text:  dic("cancel"),
																 click: function () {
																$( this ).dialog( "close" );
																document.getElementById('km').value = data;
															},
														}
														]
													});
								           		} else {
								           				if (price != "" && liters != "") {
																		
																      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
																     $.ajax({
				                                url: "InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&loc=" + loc + "&price=" + price + "&vehID=" + veh + '&pay=' + pay,
				                                context: document.body,
				                                success: function (data) {
				                                    $(this).dialog("close");
				                                    mymsg(dic("Reports.SuccAddFuel"))
				                                    location.reload();
				                                }
				                            }); 
																        
																        $.ajax({
																              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
																              context: document.body,
																              success: function (data) {
																    
																              }
																        }); 
																        
										                           }
								           		}
								           		
								           	}
								           });
			                          
			                          
			                          
	                		        } else {
	                		        	if ($("#costtype").children(":selected").attr("id") == "Service") {
	                		        		var dt = document.getElementById("datetime").value;
	                		        		var driver = "";
		                		        	if (document.getElementById("driver"))
		                		        		driver = document.getElementById("driver").value;
									        var veh = id;
									        var km = (document.getElementById("km").value).replace(/\,/g,'') / <?php echo $metricvalue?>;
									        var type = $('input[name=type]:radio:checked').val();
									        var loc = document.getElementById("location").value;
									        var desc = document.getElementById("desc").value;
									        //var comp = document.getElementById("components").value;
									        var comp= "";
									        for (var i=0; i < $('#components-').children().length; i++) {
												comp += ($('#components-').children()[i].id).split("li-")[1] + ";";
											}
									         var price = (document.getElementById("price").value).replace(/\,/g,'') * <?php echo $currencyvalue?>;
									        var pay = document.getElementById("pay").value;
									       
									        document.getElementById('desc').style.border = "1px solid #cccccc"
											document.getElementById('price').style.border = "1px solid #cccccc"
										
										if (desc == "") {
											alert(dic("Reports.EnterDescServ"))
											document.getElementById('desc').style.border = "1px solid red"
											document.getElementById('desc').select()
										}
										if (comp == "") {
										alert(dic("Reports.EnterLeastComp"))
										document.getElementById('div-addcomp').style.border = "1px solid red"
										}
										if (price == "") {
											alert(dic("Reports.EnterServCost"))
											document.getElementById('price').style.border = "1px solid red"
											if (liters == "") document.getElementById('liters').select()
											else document.getElementById('price').select()
										}
										
										
										$.ajax({
								           url: 'CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt,
								           context: document.body,
								           success: function (data) {
								           		if (Math.abs(km - data.replace(",", "")) > (data.replace(",", "") * 20/100)) {
						           			var msg = "<div>" + dic('Reports.KmOdometer') + " (" + document.getElementById("km").value + " " + "<?php echo $metric?>" + ") " + dic('Reports.KmDifferent') + " (" + addCommas(parseInt(data.replace(",", "") * "<?php echo $metricvalue?>")) + " " + "<?php echo $metric?>" + ").<br>" + dic('Reports.SureKm') + "<font style='color:#FF6633;font-weight:bold'> " + document.getElementById("km").value + " " + "<?php echo $metric?>" + "</font>?</div>";
						           			$('#div-msgbox1').html(msg)
													$( "#dialog:ui-dialog" ).dialog( "destroy" );	
													$( "#dialog-message1" ).dialog({ height: 220, width: 440,
														modal: true,
												        resizable: false,
														zIndex: 9999 ,
														buttons: [{
															text:  dic("add"),
															click: function () {
																if (price != "" && desc != "" && comp != "") {
																		
																      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
																      $.ajax({
																              url: "InsertService.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
																              context: document.body,
																              success: function (data) {
																                $(this).dialog("close");
																                 mymsg(dic("Reports.SuccAddServ"))
										                                    	location.reload();   
																              }
																        }); 
																        
																        $.ajax({
																              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
																              context: document.body,
																              success: function (data) {
																    
																              }
																        }); 
																        
										                           }
															}},
															{
																text:  dic("cancel"),
																click: function () {
																$( this ).dialog( "close" );
																document.getElementById('km').value = data;
															}
														}
														]
													});
								           		} else {
								           				if (price != "" && desc != "" && comp != "") {
																		
																      // alert("InsertService.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price)
																      $.ajax({
																              url: "InsertService.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&type=" + type + "&loc=" + loc + "&desc=" + desc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
																              context: document.body,
																              success: function (data) {
																                $(this).dialog("close");
																                 mymsg(dic("Reports.SuccAddServ"))
										                                    	location.reload();   
																              }
																        }); 
																        
																        $.ajax({
																              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
																              context: document.body,
																              success: function (data) {
																    
																              }
																        }); 
																        
										                           }
								           		}
								           		
								           	}
								           });
			           	
																				
										
	                		        	} else {
	                		        		 if($("#costtype").children(":selected").attr("id") == "Cost") {
	                		        		var dt = document.getElementById("datetime").value;
	                		        		var driver = "";
		                		        	if (document.getElementById("driver"))
		                		        		driver = document.getElementById("driver").value;
									        var veh = id;
									        var km = (document.getElementById("km").value).replace(/\,/g,'') / <?php echo $metricvalue?>;
									        var desc = document.getElementById("desc").value;
									        var comp = "";//document.getElementById("components").value;
									        for (var i=0; i < $('#components-').children().length; i++) {
												comp += ($('#components-').children()[i].id).split("li-")[1] + ";";
											}
											
									        var price = (document.getElementById("price").value).replace(/\,/g,'') * <?php echo $currencyvalue?>;
									        var pay = document.getElementById("pay").value;
									        var loc = document.getElementById("location").value;
									        
									    document.getElementById('desc').style.border = "1px solid #cccccc"
											document.getElementById('price').style.border = "1px solid #cccccc"
										
										if (desc == "") {
											alert(dic("Reports.EnterDescOthCost"))
											document.getElementById('desc').style.border = "1px solid red"
											document.getElementById('desc').select()
										}
										if (comp == "") {
										alert(dic("Reports.EnterLeastOthCost"))
										document.getElementById('div-addcomp').style.border = "1px solid red"
										}
										if (price == "") {
											alert(dic("Reports.EnterAmountOthCost"))
											document.getElementById('price').style.border = "1px solid red"
											if (liters == "") document.getElementById('liters').select()
											else document.getElementById('price').select()
										}
										
										$.ajax({
								           url: 'CalculateCurrKm.php?vehId=' + veh + "&dt=" + dt,
								           context: document.body,
								           success: function (data) {
								           		if (Math.abs(km - data.replace(",", "")) > (data.replace(",", "") * 20/100)) {
							           			var msg = "<div><?php dic('Reports.KmOdometer')?> (" + document.getElementById("km").value + " " + '<?php echo $metric?>' + ") <?php dic('Reports.KmDifferent')?> (" + addCommas(parseInt(data.replace(",", "") * '<?php echo $metricvalue?>')) + " " + '<?php echo $metric?>' + ").<br><?php dic('Reports.SureKm')?> <font style='color:#FF6633;font-weight:bold'>" + document.getElementById("km").value + " " + '<?php echo $metric?>' + "</font>?</div>";
							           			$('#div-msgbox1').html(msg)
													$( "#dialog:ui-dialog" ).dialog( "destroy" );	
													$( "#dialog-message1" ).dialog({ height: 220, width: 440,
														modal: true,
												        resizable: false,
														zIndex: 9999 ,
														buttons: {
															"Да": function() {
																if (price != "" && desc != "" && comp != "") {
																																		
																		//alert("InsertCost.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&comp=" + htmlstring + "&price=" + price + "&pay=" + pay)
																     	$.ajax({
																          url: "InsertCost.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&loc=" + loc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
																              context: document.body,
																              success: function (data) {
																                    $(this).dialog("close");
																                    mymsg(dic("Reports.SuccAddOthCost"))
										                                    		location.reload();
																              }
																        }); 
									  																        
																        $.ajax({
																              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
																              context: document.body,
																              success: function (data) {
																    
																              }
																        }); 
																        
										                           }
															},
															"Откажи": function() {
																$( this ).dialog( "close" );
																document.getElementById('km').value = data;
															},
														}
													});
								           		} else {
								           			if (price != "" && desc != "" && comp != "") {
																																		
															//alert("InsertCost.php?dt=" + dt + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&comp=" + htmlstring + "&price=" + price + "&pay=" + pay)
													     	$.ajax({
													          url: "InsertCost.php?dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&desc=" + desc + "&loc=" + loc + "&comp=" + comp + "&price=" + price + "&pay=" + pay,
													              context: document.body,
													              success: function (data) {
													                    $(this).dialog("close");
													                    mymsg(dic("Reports.SuccAddOthCost"))
							                                    		location.reload();
													              }
													        }); 
						  																        
													        $.ajax({
													              url: "SaveCurrKm.php?dt=" + dt + "&veh=" + veh + "&km=" + km,
													              context: document.body,
													              success: function (data) {
													    
													              }
													        }); 
													        
							                           }
								           		}
								           		
								           	}
								           });
								         }
								         else {
										  	if($("#costtype").children(":selected").attr("id") == "0")
										  	{
										  		mymsg(dic("Reports.NotSelCost"));
										  	} else {
										  		var costtypeid = $("#costtype").children(":selected").attr("id");
										  		var dt = document.getElementById("datetime").value;
										  		var km = (document.getElementById("km").value).replace(/\,/g,'') / <?php echo $metricvalue?>;
										  		var loc = document.getElementById("location").value;
										  		var driver = "";
			                		        	if (document.getElementById("driver"))
			                		        	driver = document.getElementById("driver").value;
			                		        	var pay = document.getElementById("pay").value;
		                		        		var price = (document.getElementById("price").value).replace(/\,/g,'') * <?php echo $currencyvalue?>;
		                		        		var veh = id;
		                		        		if (price != "") {
		                		        			$.ajax({
											          url: "InsertNewCost.php?costtypeid=" + costtypeid + "&dt=" + dt + "&driver=" + driver + "&veh=" + veh + "&km=" + km + "&loc=" + loc + "&price=" + price + "&pay=" + pay,
											              context: document.body,
											              success: function (data) {
											                    $(this).dialog("close");
											                    mymsg(dic("Reports.SuccAddCost"))
					                                    		location.reload();
											              }
											        }); 
		                		        		}	else {
		                		        			alert(dic("Reports.EnterAmount"))
													document.getElementById('price').style.border = "1px solid red"
													if (liters == "") document.getElementById('liters').select()
													else document.getElementById('price').select()
		                		          		}
										     }
										  }
									   }
	                		        }
	                             }
	                         },
	                         {
	                             text: dic("cancel", '<?php echo $cLang ?>'),
	                             click: function () {
	                                 //$('#div-cost').dialog("destroy");
	                                 $( this ).dialog( "close" );
	                             }
	                         }
	                     ]
	                });
	            }
	        });
}

function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}


    function filter (term, _id, cellNr){
         if (cellNr == 0) {
            document.getElementById('inp2').value="";
         }
         else {
            document.getElementById('inp1').value="";
         }

	    var suche = term.value.toLowerCase();

        var cnt = 0;
        if (<?php echo pg_num_rows($dsOthV)?> > 0) {
            cnt  = <?php echo $cnt2 ?>
        }
        else {
            cnt = <?php echo $cnt2 ?> - 1
        }

        for (var k=1; k <= cnt; k++) {
	        var table = document.getElementById(_id + k);
	        var ele;

	        for (var r = 2; r < table.rows.length; r++){
		        ele = table.rows[r].cells[cellNr].innerHTML.replace(/<[^>]+>/g,"");
		        if (ele.toLowerCase().indexOf(suche) >= 0)
			        table.rows[r].style.display = '';
		        else
		        	table.rows[r].style.display = 'none';
	        }

	        //da se krijat celite tabeli koi nemaat nieden red
	        var cnt11 = 0;
         	for (var r = 2; r < table.rows.length; r++){
         	 	if (table.rows[r].style.display != 'none') {
         	 		cnt11 += 1;
         	 	}
         	}
         	if(cnt11 == 0) {
         	 	$('#' + (_id + k)).hide();
         	}
         	else {
         		if (table.style.display == 'none') {
         	 		$('#' + (_id + k)).show();
         	 	}
         	}
         	//
        }
    }




$(document).ready(function(){

    lang1 = '<?php echo $cLang?>';

    $('#addBtn').button({ icons: { primary: "ui-icon-plusthick"} });
    $('#downVeh').button({ icons: { primary: "ui-icon-arrowreturnthick-1-s"} });
    top.HideWait();

    /**
     * EVENT Binding ---------------------------------------------------------------
     */

    $('#inp2').bind("input", function(){
    	filter(this, 'tabId', 1)
    });
    $('#inp1').bind("input", function(){
    	filter(this, 'tabId', 0)
    });


});


</script>

<?php closedb();?>

</html>
