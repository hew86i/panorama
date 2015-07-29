<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>


<?php
	header("Content-type: text/html; charset=utf-8");
	opendb();

	$uid = session('user_id');
	$cid = session('client_id');

	$Allow = getPriv("vehicles", $uid);
	if ($Allow == False) echo header ('Location: ../permission/?l=' . $cLang);

	addlog(42);
?>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>
	<script type="application/javascript"> lang = '<?php echo $cLang?>'; </script>
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

		html {
		    overflow:auto;
		    -webkit-overflow-scrolling:touch
		}

		body {
		    height:100%;
		    overflow:auto;
		    -webkit-overflow-scrolling:touch
		}

		.align-center {
		    margin-left:auto;
		    margin-right:auto;
		    width:95%
		}

		.la {
		    text-align:left!important
		}

		.ca {
		    text-align:center!important
		}

		.t-sp {
		    margin-top:30px
		}

		.input-search {
		    color:#2F5185;
		    font-family:Arial,Helvetica,sans-serif;
		    font-size:11px;
		    height:25px;
		    border:1px solid #CCC;
		    border-radius:5px 5px 5px 5px;
		    width:161px;
		    padding-left:5px
		}

		.table-title {
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
		.td-row {
			background-color:#fff;
			border:1px dotted #B8B8B8;
			height: 30px;
		}

	</style>

<body>

 	<script> if (!"<?php echo is_numeric($uid) ?>")
 		top.window.location = "../sessionexpired/?l=" + '<?php echo $cLang ?>';
 	</script>

<!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> DIALOGS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> -->

<!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> -->

<?php

 $americaUser = dlookup("select count(*) from cities where id = (select cityid from users where id=".$uid.") and countryid = 4");
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

<?php

$qGetUser = pg_fetch_assoc(query("select * from users where id=" . $uid));
$role_id = $qGetUser['roleid'];

$dsOU = query("select id, name, code from organisation where clientid=".$cid);
$AllOU = pg_fetch_all($dsOU);

$ungroupedVeh = array('id' => 0, 'name' => dic_("Fm.UngroupedVeh"), 'code' => 'uv000' );
if(pg_num_rows($dsOU) > 0) {
	array_push($AllOU,$ungroupedVeh);  // za sekogas da bide posledna
} else {
	$AllOU = array($ungroupedVeh); // ako ima samo negrupirani vozila
}

$cnt = 1;   // counter za vozilata
$cnt2 = 1;  // counter za grupa (organizaciona edinica)

foreach ($AllOU	as $rowOU) {

	if($role_id == 2) $dsVh = query("select * from vehicles where active='1' and organisationid = " . $rowOU["id"] . " and clientid = " . $cid . " order by code::INTEGER");
	else 			  $dsVh = query("select * from vehicles where active='1' and organisationid = " . $rowOU["id"] . " and id in(select vehicleid from uservehicles where userid = ".$uid.") and clientid = " . $cid. " ORDER BY code::INTEGER");

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
		    if ($cid == 259) {
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

		 while ($rV = pg_fetch_array($dsVh)) {

			$zaAlias = dlookup("select count(*) from vehicles where alias <> '' and id=" . $rV["id"]);

			$id = $rV["id"];

			if($rV["greencard"] == 1) {
				$greenCard = "../images/stikla2.png";
				$actYN = 1;
			}
			else {
				$greenCard = "../images/stikla3.png";
				$actYN = 0;
			}

			if($rV["visible"] == 1) {
				$activity = "../images/stikla2.png";
			}
			else {
				$activity = "../images/stikla3.png";
			}

			$_lastReg = explode(" ", DateTimeFormat($rV["lastregistration"], "d-m-Y"));
			$lastReg = $_lastReg[0];
			$fuelType = query("select name from fueltypes where id = (select fueltypeid from vehicles where id=" . $rV["id"] . ")");
			$row1 = pg_fetch_array($fuelType);

			$ld = query('select "DateTime" from currentposition where vehicleid=' . $rV["id"]);
			if (pg_num_rows($ld) > 0) $lastDate = nnull(pg_fetch_result($ld, 0, 0), "/");
			else $lastDate = "/";

			if ($lastDate <> "/") $lastDate = DateTimeFormat($lastDate, 'd-m-Y H:i:s');
			$color = "";

			if ($lastDate <> "/") {
				if (round(abs(strtotime(now())-strtotime($lastDate))/60) > 1440) $color = "red";
				else $color = "green";
			}

			?>

				<tr id="veh<?php echo $cnt ?>" style="" onmouseover="over(<?php echo $cnt ?>, 0, <?php echo $actYN ?>)" onmouseout="out(<?php echo $cnt ?>, 0, <?php echo $actYN ?>)">

					<td id="td-1-<?php echo $cnt ?>" align="center" class="td-row text2"><?php echo $rV["code"]?></td>
					<td id="td-2-<?php echo $cnt ?>" align="center" class="td-row text2"><strong><?php echo $rV["registration"] ?></strong><br><?php if($zaAlias>0){?><font style="font-size:10px">(<?php echo $rV["alias"];?>)</font><?php }else{ echo "";}?></td>
					<?php
					if ($cid == 259) {
					?>
					<td id="" align="center" class="td-row text2"><?php echo $rV["gsmnumber"]?></td>
					<?php }	?>
					<td id="td-3-<?php echo $cnt ?>" align="center" class="td-row text2 <?php echo $paren ?>">
					<b><?php echo $rV["model"]?></b><br>

				<?php if($row1["name"]=="Бензин") {	?> &nbsp;(<font style="font-size:10px"><?php echo dic("Settings.Petrol")?></font>) <?php }
					  if($row1["name"]=="Дизел")  {	?> &nbsp;(<font style="font-size:10px"><?php echo dic("Settings.Diesel")?></font>) <?php }
					  if($row1["name"]=="LPG")    { ?>&nbsp;(<font style="font-size:10px"><?php echo dic("Settings.Gas")?></font>)	   <?php }
				?>

				</div></td>

					<td id="td-4-<?php echo $cnt?>" align="center" class="td-row text2">
			        	<table width=100%>
			        		<tr class="text2">
			        			<td align="center"><?php echo DateTimeFormat($rV["lastregistration"], $dateformat) ?></td>
			        			<?php
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
			        <td id="td-5-<?php echo $cnt?>" align="center" class="td-row text2" style="<?=$americaUserStyle?>;">
			              <img id="act<?php echo $cnt?>" width= "11px" height = "11px" src="<?php echo $greenCard?>"  />
			        </td>
			        <td id="td-6-<?php echo $cnt?>" align="center" class="td-row text2" style="color:<?php echo $color?>"><?php echo DateTimeFormat($lastDate, $datetimeformat)?></td>

					<td id="td-9-<?php echo $cnt?>" align="center" class="td-row text2 <?php echo $paren?>">
			             <img id="act<?php echo $cnt?>" width= "11px" height = "11px" src="<?php echo $activity?>"  />
			        </td>
					<td id="td-8-<?php echo $cnt?>" align="center" class="td-row text2">
			            <button id="modBtn<?php echo $cnt ?>" class="editBtn" onclick="modifyVehicle(<?php echo $cnt ?>, <?php echo $id ?>)" style="height:22px; width:30px"></button>
			        </td>

	    		</tr>

		<?php

			$cnt++;
            }//end while
        ?>
		<!-- >>> [END] TABLE DATA >>>>>>>>>>>>>>>>>>>>> -->
	</table>

<?php
	$cnt2++;

	} // [end] if have data

} // [end]  for each

?>


<div style="height:40px">&nbsp;</div>

</body>

<script>

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
	}
	else
	{
	        for (var j = 1; j < 6; j++) {
	            document.getElementById("td-" + j + "-" + i).style.color = "blue";
	        }

	        if (act == "0") {document.getElementById("act" + i).src = "../images/stikla3.png";}
	        else {document.getElementById("act" + i).src = "../images/stikla2.png";}

	        document.getElementById("modBtn" + i).style.border = "1px solid #0000ff";
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

    }
    else{
         for (var j = 1; j < 6; j++) {
            document.getElementById("td-" + j + "-" + i).style.color = "#2f5185";
        }

        if (act == "0") {document.getElementById("act" + i).src = "../images/stikla3.png";}
        else {document.getElementById("act" + i).src = "../images/stikla2.png";}

        document.getElementById("modBtn" + i).style.border = "";

    }
}

function modifyVehicle(i, id) {
    top.ShowWait();
    if( top.document.getElementById('ifrm-cont') != null) top.document.getElementById('ifrm-cont').src = "ModifyVehicle.php?id=" + id + "&l=" + lang;
    else window.location.replace("ModifyVehicle.php?id=" + id + "&l=" + lang);
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

    var cnt = Number('<?php echo $cnt2; ?>');

    for (var k=1; k < cnt; k++) {
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
     	for (r = 2; r < table.rows.length; r++){
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

    // lang1 = '<?php echo $cLang?>';

    $('#addBtn').button({ icons: { primary: "ui-icon-plusthick"} });
    $('#downVeh').button({ icons: { primary: "ui-icon-arrowreturnthick-1-s"} });
    top.HideWait();

    allGroups = JSON.parse('<?php echo json_encode($AllOU); ?>');

    $('.editBtn').button({ icons: { primary: "ui-icon-pencil"} });

    /**
     * EVENT Binding ---------------------------------------------------------------
     */

    $('#inp2').bind("input", function(){
    	filter(this, 'tabId', 1);
    });
    $('#inp1').bind("input", function(){
    	filter(this, 'tabId', 0);
    });


});


</script>

<?php closedb();?>

</html>
