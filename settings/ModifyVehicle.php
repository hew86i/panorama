<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>


<?php
	header("Content-type: text/html; charset=utf-8");
	$ua=getBrowser();

	$cid = session("client_id");
	$uid = session("user_id");

	$yourbrowser = (bool) strpos($ua['userAgent'], "iPad");
	$yourbrowser1 = (bool) strpos($ua['userAgent'], "Macintosh");
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php 
	$id = getQUERY("id");
	$now = now();
	$nowMiliSec = round(microtime('2014-05-06 11:30:00') * 1000);
	?>
	<style>
	.ui-datepicker-next,.ui-datepicker-prev,.ui-datepicker-today {display:block;}
	.ui-datepicker-week-end a {
		   color: red !important;
		   font-weight:bold !important;
		   font-size: 8pt;
	}
	.ui-dialog {
		position: fixed;
	}
	.ui-autocomplete-input {
		margin: 0;
		padding: 0.48em 0 0.47em 0.45em;
		width: 82% !important;;
		height: 25px !important;
	}
	</style>
	
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
	<style type="text/css"> 
 		body{ overflow-y:auto }
 	</style>

	<link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../live/style.css">

	<script type="text/javascript" src="../js/jquery.js"></script>
	<script src="../js/jquery.json-2.2.min.js"></script>
	<script src="../js/jquery.websocket-0.0.1.js"></script>
	<script type="text/javascript" src="../js/roundIE.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/settings.js"></script>
	<script type="text/javascript" src="../js/iScroll.js"></script>
    <script type="text/javascript" src="../pdf/pdf.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
	<script type="text/javascript" src="fm.js"></script>
	<script type="text/javascript" src="../tracking/live.js"></script>
	<script type="text/javascript" src="../tracking/live1.js"></script>
	<script type="text/javascript" src="./js/highcharts.src.js"></script>
  	<style>
	#promeniOdometar
	{
	position:relative;
	bottom:1px;
	}
	</style>
    <link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css" />
    <script src="js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

    <script>


   // var dt = $('#odometarDatum').val();
    var dt1 = $('#odometarDatum1').val();
    var dateOdometar = '<?php echo strtotime('2014-05-06 11:36:10') ?>';

  	//alert(dateOdometar)
     //Fri Apr 04 2014 02:00:00 GMT+0200 (CEST)
     //Wed May 07 2014 10:45:40 GMT+0200 (CEST)
    var vehId = "<?php echo $id?>";
	$(function Odometar() {

	   /*$('#odometarDatum').datetimepicker({
            dateFormat: 'dd-mm-yy',
            timeFormat: 'hh:mm:ss',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
        });*/

       //var queryDate = '2009-11-01 10:15:10';
        $('#odometarDatum1').datetimepicker({
            dateFormat: 'yy-mm-dd',
            timeFormat: 'hh:mm:00',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            monthNames: ['<?= dic_("Reports.January")?>', '<?= dic_("Reports.February")?>', '<?= dic_("Reports.March")?>', '<?= dic_("Reports.April")?>', '<?= dic_("Reports.May")?>', '<?= dic_("Reports.June")?>', '<?= dic_("Reports.July")?>', '<?= dic_("Reports.August")?>', '<?= dic_("Reports.September")?>', '<?= dic_("Reports.October")?>', '<?= dic_("Reports.November")?>', '<?= dic_("Reports.December")?>'],
   			monthNamesShort: ['<?= dic_("Reports.January1")?>', '<?= dic_("Reports.February1")?>', '<?= dic_("Reports.March1")?>', '<?= dic_("Reports.April1")?>', '<?= dic_("Reports.May1")?>', '<?= dic_("Reports.June1")?>', '<?= dic_("Reports.July1")?>', '<?= dic_("Reports.August1")?>', '<?= dic_("Reports.September1")?>', '<?= dic_("Reports.October1")?>', '<?= dic_("Reports.November1")?>', '<?= dic_("Reports.December1")?>'],
            dayNames: ['<?= dic_("Reports.Sunday")?>', '<?= dic_("Reports.Monday")?>', '<?= dic_("Reports.Tuesday")?>', '<?= dic_("Reports.Wednesday")?>', '<?= dic_("Reports.Thursday")?>', '<?= dic_("Reports.Friday")?>', '<?= dic_("Reports.Saturday")?>'],
	    	dayNamesShort: ['<?= mb_substr(dic_("Reports.Sunday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Monday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Tuesday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Wednesday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Thursday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Friday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Saturday"), 0, 2, 'UTF-8')?>'],
	  		dayNamesMin: ['<?= mb_substr(dic_("Reports.Sunday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Monday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Tuesday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Wednesday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Thursday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Friday"), 0, 2, 'UTF-8')?>', '<?= mb_substr(dic_("Reports.Saturday"), 0, 2, 'UTF-8')?>'],
	        firstDay: 1,
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10, 
            onSelect: function () {

            	var newDate = $('#odometarDatum1').val();
            	/*var date_ = newDate.split(" ")[0];
            	date_ = date_.replace(/-/g, " ");
            	var time_ = newDate.split(" ")[1];
            	var selDate = new Date(date_ + " " + time_);
            	$('#odometarDatum1').datetimepicker('setDate', selDate);*/
				$.ajax
				({
			    	url:"CalculateCurrKm.php?dt=" + newDate + "&vehId=" + vehId,
			        context: document.body,
			        success: function(data){
			        	$('#odometarKm').val(data);
			        }
				});
        	}
        });//.datetimepicker("setDate", new Date(queryDate));
      
      	var miliseconds = <?= $nowMiliSec?> ;			
      	$('#odometarDatum1').datetimepicker('setDate',new Date(miliseconds));
      	
	});
	</script>

	<style type="text/css"> 
 		body{ overflow-y:auto }
 		
	</style>
	
	<?php $denes = DatetimeFormat(now("Y-m-d H:i:s"), 'd-m-Y H:i:s'); ?>

	<script>
	var deneska = '<?php echo $denes;?>'
	
	//alert($('#odometarDatum1').attr('class'));
	//return;
	function DatumPocetok() {
	$.ajax
	({
    	url:"CalculateCurrKm.php?dt=" + deneska + "&vehId=" + vehId,
        context: document.body,
        success: function(data){
        	$('#odometarKm').val(data);
        }
	  });
	}
	</script>
	
	<script type="text/javascript">
    (function ($) {
    $.widget("ui.combobox", {
        _create: function () {
                 var self = this,
				 select = this.element.hide(),
				 selected = select.children(":selected"),
				 value = selected.val() ? selected.text() : "";
            	 var input = this.input = $("<input>")
				 .insertAfter(select)
				 .val("")
				 .autocomplete({
				    delay: 0,
				    minLength: 0,
				    source: function (request, response) {
				        var matcher = new RegExp($.ui.autocomplete.escapeRegex(request.term), "i");
				        response(select.children("option").map(function () {
				            var text = $(this).text();
				            if (this.value && (!request.term || matcher.test(text))) {
				                return {
				                    label: text.replace(
										new RegExp(
											"(?![^&;]+;)(?!<[^<>]*)(" +
											$.ui.autocomplete.escapeRegex(request.term) +
											")(?![^<>]*>)(?![^&;]+;)", "gi"
										), "<strong>$1</strong>"),
				                    value: text,
				                    option: this
				                };
				            }
				        }));
				    },
				    select: function (event, ui) {
				        ui.item.option.selected = true;
				        self._trigger("selected", event, {
				            item: ui.item.option
				        });
				        select.trigger("change");
				    },
				    change: function (event, ui) {
							if (!ui.item) {
				            var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex($(this).val()) + "$", "i"),
							valid = false;
				            select.children("option").each(function () {
				                if ($(this).text().match(matcher)) {
				                    this.selected = valid = true;
				                    return false;
				                }
				            });
				            if (!valid) {
				                $(this).val("");
				                select.val("");
				                input.data("autocomplete").term = "";
				                return false;
				            }
				        }
				    }
				})
				.addClass("ui-widget ui-widget-content ui-corner-left");
            	input.data("autocomplete")._renderItem = function (ul, item) {
                input.autocomplete("widget")[0].style.zIndex = '2000';
                input.autocomplete("widget")[0].style.overflowX = 'hidden';
                input.autocomplete("widget")[0].style.overflowY = 'auto';
                input.autocomplete("widget")[0].style.maxHeight = '210px';

                return $("<li></li>")
					.data("item.autocomplete", item)
					.append("<a>" + item.label + "</a>")
					.appendTo(ul);
            	};
				this.button = $("<button type='button'>&nbsp;</button>")
				.attr("tabIndex", -1)
				.attr("title", dic("show", lang) + " " + dic("all", lang) + " " + dic("Pois", lang))
				.insertAfter(input)
				.button({
				    icons: {
				        primary: "ui-icon-triangle-1-s"
				    },
				    text: false
				})
				.removeClass("ui-corner-all")
				.addClass("ui-corner-right ui-button-icon")
				.click(function () {
				    if (input.autocomplete("widget").is(":visible")) {
				        input.autocomplete("close");
				        return;
				    }
					$(this).blur();
					 input.autocomplete("search", "");
				    input.focus();
					input.autocomplete("widget")[0].style.zIndex = '2000';
				    input.autocomplete("widget")[0].style.overflowX = 'hidden';
				    input.autocomplete("widget")[0].style.overflowY = 'auto';
				    input.autocomplete("widget")[0].style.maxHeight = '210px';
				    if (Browser()!='iPad')
				    	input.autocomplete("widget")[0].style.width = '610px';
			    	else
						input.autocomplete("widget")[0].style.width = '500px';
				    });
            },
            setval : function(value) {
				this.input.val(value);
        	},
        	destroy: function () {
	            this.input.remove();
	            this.button.remove();
	            this.element.show();
	            $.Widget.prototype.destroy.call(this);
		  }
       });
	})(jQuery);

	</script>

</head>

<body onload="DatumPocetok()">
<div id="div-tip-praznik" style="display:none" title="<?php echo dic_("Settings.ConfSMS")?>"><br>
	<table align = "center" width = "100%">
	<tr><td colspan = "2" class ="text2" align = "center" style="color:#414141">
		<span class="ui-icon ui-icon-alert" style="position: absolute; top: 25px; left: 15px;"></span>
		<div style="width: 250px; padding-left: 20px; padding-bottom: 10px; text-align: center;"><?php echo dic("dinara5")?></div> </td></tr>
	<tr>
	<td style="color:#414141" class ="text2" width="90px" align = "right"><?php echo dic_("EnterPass")?> </td>
	<td style="color:#414141" class ="text2" width="150px" align = "left">
		<input type="password" class="textboxCalender corner5" id="dodTipPraznik" style="width:150px">
	</td>
	</tr>
	</table>
</div>
    
<?php

  	  opendb();
	  $ds = query("select * from clients where id=" . session("client_id"));
	  $clienttypeid = pg_fetch_result($ds, 0, "clienttypeid");

	  $allowedalarms = pg_fetch_result($ds, 0, "allowedalarms");
	  $allowedfm = pg_fetch_result($ds, 0, "allowedfm");
      $allowedrouting = pg_fetch_result($ds, 0, "allowedrouting");
	  $allowedRFID = nnull(dlookup("select allowrfid from vehicles where id=" . $id), "0");
	  $allowgarmin = nnull(dlookup("select allowgarmin from vehicles where id=" . $id), "0");
	  $gsmnum = nnull(dlookup("select gsmnumber from vehicles where id=" . $id), "0");
	  $allowedCapace = dlookup("select count(*) from vehicleport where vehicleid=".$id." and porttypeid=17");
	  $allowFuel = nnull(dlookup("select allowfuel from vehicles where id=" . $id), "");

	  $metric = nnull(dlookup("select metric from users where id = " . session("user_id")), "1");	
	$datetimeformat = dlookup("select datetimeformat from users where id = " . session("user_id"));
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
	  $americaUser = dlookup("select count(*) from cities where id = (select cityid from users where id=".session("user_id").") and countryid = 4");
      $americaUserStyle = "";
      if ($americaUser == 1) $americaUserStyle = "display: none";
	  if ($metric == 'mi') {
		$value = 0.621371;
	  }	else {
		$value = 1;
	  }
	  If ($metric == "Km" or $metric == 'km') {
          $unitSpeed = "Km/h";
      } Else {
          $unitSpeed = "mph";
      }
						   
      $LastDay = DatetimeFormat(addDay(-1), 'd-m-Y');
      $reg = nnull(dlookup("select registration from vehicles where id=" . $id), "");
      $code = nnull(dlookup("select code from vehicles where id=" . $id), "");
	  $aliasName = "select alias from vehicles where id=" . $id;
      $model = nnull(dlookup("select model from vehicles where id=" . $id), "");
	  $brand = nnull(dlookup("select brand from vehicles where id=" . $id), "");
	  $yearmanuf = nnull(dlookup("select pyear from vehicles where id=" . $id), "");
	  
      $orgUnit = nnull(dlookup("select organisationid from vehicles where id=" . $id), "");
      $checkOrg = dlookup("select count(*) from organisation where id=" . $orgUnit);    

      $lastReg = nnull(DateTimeFormat(dlookup("select lastregistration from vehicles where id=" . $id), $dateformat), "");
        
      $greenCard = nnull(dlookup("select greencard from vehicles where id=" . $id), "");
	  $activity = nnull(dlookup("select visible from vehicles where id=" . $id), "");
   
      If ($greenCard == false) {
          $greenCard = 0;
      } else{
          $greenCard = 1;
      }
	  
	  If ($activity == false) {
          $activity = 0;
      } else{
          $activity = 1;
      }
            
      $chassis = nnull(dlookup("select chassisnumber from vehicles where id=" . $id), "");
      $motor = nnull(dlookup("select motornumber from vehicles where id=" . $id), "");
      $capacity = nnull(dlookup("select fuelcapacity from vehicles where id=" . $id), "0");
      $firstReg = DateTimeFormat(nnull(dlookup("select firstregistration from vehicles where id=" . $id), now()), $dateformat);

      $kmPerYear = nnull(dlookup("select kmperyear from vehicles where id=" . $id), "0"); //godisno dozvoleni km
      $springT = nnull(dlookup("select springtires from vehicles where id=" . $id), "30000"); //predvideni km za letni gumi
      $winterT = nnull(dlookup("select wintertires from vehicles where id=" . $id), "30000"); //predvideni km za zimski gumi
      $nextService= nnull(dlookup("select nextservice from vehicles where id=" . $id), "10000"); //na kolku km se vrsi servis
      if ($metric == 'mi') {
			$nextService = $nextService / 1.609344498;
		}
      $nextServiceMonths= nnull(dlookup("select nextservicemonths from vehicles where id=" . $id), "12"); //na kolku meseci se vrsi servis

      $gorivo = nnull(dlookup("select fueltypeid from vehicles where id=" . $id), "");

	  $range = 0;
	  if($clienttypeid == 4)
	  {
	  		$cntrange = dlookup("select count(*) from vehiclerange where vehicleid = " . $id);
	  		if($cntrange > 0)
	  			$range = dlookup("select range from vehiclerange where vehicleid = " . $id);
	  }
     // $cLang = getQUERY("lang");
     // // >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
 	$alarmTypes = pg_fetch_all(query("select * from alarmtypes where isactive='1' order by substring(alarmgroup FROM '^[0-9]+')::int asc"));
 	$qGetMobileOperators = query("select * from operators order by name");
	$getFullOperators = pg_fetch_all($qGetMobileOperators);
	    
    ?>
    
    <table class="text2_"  width="75%" style="min-width:900px;">
    <tr>
    <td width="50%" align="left"><div class="textTitle" <?php if($yourbrowser == "1") {?>style="padding-left:10px; padding-top:10px;" <?php }else {?>style="padding-left:40px; padding-top:10px;"<?php };?>><?php echo dic_("Fm.ModVeh")?></div></td>
    <td colspan="5" width="50%" align="right">
    	<div style=" margin-top:15px; ">
              <button id="mod2" onclick="modify()"><?php dic("Fm.Mod") ?></button>
        	  <button id="cancel2" onclick="cancel()"><?php dic("Fm.Cancel") ?></button>
        </div></td>
    </tr>
    <tr>
    	<td width="50%" align="left"><div class="textTitle" <?php if($yourbrowser == "1") {?>style="padding-left:10px; padding-top:10px; font-size:16px"<?php }else {?>style="padding-left:40px; padding-top:10px; font-size:16px"<?php };?>><?php echo $reg ?></div></td>
    	<td width="50%"></td>
    	<td></td>
	    <td></td>
	    <td></td>
	    <td></td>
	    <td></td>
	</tr>
	</table>	
            
            <br/>
			<table  width="75%" <?php if($yourbrowser == "1") {?>style="min-width:900px; padding-left:10px;"<?php }else {?>style="min-width:900px; padding-left:40px;"<?php };?> class="text2_">
                  <tr style="height:10px"></tr>
                  <tr >
                      <td style="font-weight:bold"><?php dic("Fm.Registration")?>:</td>
                      <td style="">
                      	<input type="text" id="registration" value="<?php echo $reg ?>"  size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                      	<span style="color:red; font-size:14px;">&nbsp;*</span>
                      </td>
					<td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"><?php dic("Fm.Sasija")?>:</td>
                      	<td style="min-width:341px; ">
                      		<input id="chassis" type="text" value="<?php echo $chassis ?>" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                     </td>
                  </tr>
                  <tr>
                      <td style="font-weight:bold"><?php dic("VehicleNumber")?>:</td>
                      <td style="">
                      	<input id="code" value="<?php echo $code ?>" type="text" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                      	<span style="color:red; font-size:14px;">&nbsp;*</span>
                      </td>
                      <td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?> <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?><?php } ;?>"><?php dic("Fm.FirstReg")?>:</td>
                      <td style="">
                             <input id="firstReg" type="text" class="textboxCalender1 text2" value="<?php echo $firstReg?>" />
                      </td>
                       
                      
                  </tr>
                  <tr>
                  <?php
                  $alias = query($aliasName);
                  $aliasot = pg_fetch_array($alias)
                  ?>
                     <td style="font-weight:bold;"><?php dic("Reports.Alias") ?>:</td>
                     <td style="">
                     <input id="aliasName" type="text" value="<?php echo $aliasot["alias"] ?>" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                     </td>
                      
                      <td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"><?php dic("Fm.LastReg") ?>:</td><td style="">
                            <input id="lastReg" type="text" class="textboxCalender1 text2" value="<?php echo $lastReg ?>" style = "z-index: 999"/>
                            <!--img src='../images/alarm1.png' width=16px height=16px style="opacity:0.7; position:relative; left:-14px; top:4px; cursor: pointer" title="Додади алерт за истекување на регистрација" onclick="addAlerts(26)"/-->
                      		<?php
                      		if ($allowedalarms == '1') {
                      		?>
                      		<span onclick="storeAlerts(false,17)" title="<?= dic_("Settings.AlertRegTitle")?>" style="background-image: url('../images/icons.png'); background-position: -204px -50px; width: 16px; height: 16px; cursor: pointer; display: inline-block; position:relative; top:4px; left:-16px"></span>
                      		<?php
							}
                      		?>
                      </td>

                  </tr>
                  <tr>
                  <td style="font-weight:bold"></td><td style="">
                      </td>
                      <td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"></td>
                      <td style="">
                      </td>
                  </tr>
                  <tr>
                   <td style="font-weight:bold"><?php dic("Fm.Model")?>:</td>
                      <td style="">
                            <input id="model" type="text" value="<?php echo $model ?>" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                      </td>

<td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"><?php echo dic_("Allowed") . " " . $metric . " " . dic_("yearly") ?>:</td>
                     <td style="">
                            <input id="kmPerYear" type="text" value="<?php echo number_format($kmPerYear*$value) ?>" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                     </td>
                     
                     
                 </tr>
                 
                 <tr>
                   <td style="font-weight:bold"><?=dic_("Brand")?>:</td>
                      <td>
                           <input id="brand" type="text" value="<?php echo $brand ?>" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                      </td>
                     
 <td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"><?php echo dic_("Predicted") . " " . $metric . " " . dic_("Reports.email3") . " " . dic_("Fm.SummTires")?>:</td>
                      <td style="">
                            <input id="sprTires" type="text" size="22" value="<?php echo number_format($springT*$value) ?>" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                      </td>

                 </tr>
                 <tr>
                 	 <td style="font-weight:bold"><?=dic_("YearManuf")?>:</td>
                     <td style="">
                     <input id="yearmanuf" type="text" size="22" value="<?php echo $yearmanuf ?>" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                      </td>
                

                <td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"><?php echo dic_("Predicted") . " " . $metric . " " . dic_("Reports.email3") . " " . dic_("Fm.WinTires")?>:</td>
                      <td style="">
                            <input id="winTires" type="text" value = "<?php echo number_format($winterT*$value) ?>" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                      </td>
                
                      
                </tr>
                  <tr>
                  	<td style="font-weight:bold"><?php dic("Fm.FuelType")?>:</td>
                      <td>
                           <select id="fuelType" style="width: 161px; font-size: 11px; position: relative; top: 0px; z-index: 999; " class="combobox text2">
                            <?php
                                $fuelTip = "select trans from fueltypes order by id asc";
                                $dsfuelTip = query($fuelTip);
								while ($drfuelTip = pg_fetch_array($dsfuelTip))
								{       
                                ?>
                                    <option><?php echo dic_($drfuelTip["trans"]) ?></option>
                                <?php
                                }
                                ?>      
                       		</select>
                      </td>


                      <td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"><?php echo dic("Settings.NextService")?>:</td>
                      <td style="">
                      		<div style="width:161px; float:left;">
	                      		<?php 
	                      		if($nextService <> -1) {
	                      			$chSerInt1 = "checked"; 
									$valSerInt1 = number_format($nextService);
	                      		} else {
	                      			$chSerInt1 = "";
									$valSerInt1 = "";
								}
	                      		?>
	                      		<!--input id="serIntervalKm"" type="checkbox" name="remindme" value="days" style="position: relative; top:4px" <?php echo $chSerInt1?> /--> 
	                            <input id="nextService" value= "<?php echo $valSerInt1 ?>" type="text" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px;  border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:55px; padding-left:2px"/> <?php echo $metric?>&nbsp;&nbsp;&nbsp;
	                            <?php 
	                      		if($nextServiceMonths <> -1) {
	                      			$chSerInt2 = "checked"; 
									$valSerInt2 = number_format($nextServiceMonths);
	                      		}else {
	                      			$chSerInt2 = "";
									$valSerInt2 = "";
								}
	                      		?>
	                            <!--input id="serIntervalDays" type="checkbox" name="remindme" value="days" style="position: relative; top:4px" <?php echo $chSerInt2?> /--> 
	                            <input id="nextServiceMonths" value= "<?php echo $valSerInt2 ?>" type="text" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px;  border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:40px; padding-left:2px"/> <?php echo dic_("Settings.Months")?>
                            </div>
                      		<!--img src='../images/alarm1.png' width=16px height=16px style="opacity:0.7; position:relative; left:2px; top:4px; cursor: pointer" title="Додади алерт за сервис" onclick="addAlerts(27)"/-->
                      		<?php
                      		if ($allowedalarms == '1') {
                      		?>
                      		<span onclick="storeAlerts(false,18)" title="<?= dic_("Settings.AlertServiceTitle")?>" style="background-image: url('../images/icons.png'); background-position: -204px -50px; width: 16px; height: 16px; cursor: pointer; display: inline-block; position:relative; top:4px; left:0px"></span>
                      		<?php
							}
                      		?>
                      </td>
                      
                  </tr>
                  <tr>
                  	  <td style="font-weight:bold;"><?php dic("Fm.OrgUnit")?>:</td>
                      <td style="">
                         <select id="orgUnit" style="width: 161px; font-size: 11px; position: relative; top: 0px; z-index: 1; visibility: visible;" class="combobox text2">
                        
                        <?php
                        // Ako pripaga vo negrupirani vozila
				        if($orgUnit==0)
				        {
					         	?>
					        	<option value = "<?php echo $orgUnit;?>" selected = "selected"><?php dic("Fm.UngroupedVeh")?></option>
					         	<?php
					         	$str2 = "";
								$str2 .= "select id, name from organisation where clientid=" . session("client_id");
								$dsPP2 = query($str2);
					            while($row2 = pg_fetch_array($dsPP2))
								{
					         	?>
					            <option value="<?php echo $row2["id"] ?>"><?php echo $row2["name"]?></option>
					         	<?
					         }
				        }
						// Ako pripaga vo nekoja druga grupa
						else 
						{
							 	$odbrana = query("select id,name from organisation where id = ".$orgUnit." and clientid=" . session("client_id"));
							 	$vrednostiEdinica = pg_fetch_array($odbrana);
							 	?>
							 	<option selected="selected" value="<?php echo $vrednostiEdinica["id"] ?>"><?php echo $vrednostiEdinica["name"]?></option>
							 	
							 	<?php
								$str2 = "";
								$str2 .= "select id, name from organisation where clientid=" . session("client_id")." and id not in($orgUnit)";
								$dsPP2 = query($str2);
					            while($row2 = pg_fetch_array($dsPP2))
								{
					         	?>
					            <option value="<?php echo $row2["id"] ?>"><?php echo $row2["name"]?></option>
					         	<?
					            }
								?>
								<option value="0"><?php dic("Fm.UngroupedVeh") ?></option>
							 	<?php	
						}
				        ?>
				        </select>
                      </td>

                      <td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"><?php dic("Reports.Odometer")?> (<?php echo $metric?>):</td>
                      	<td style="min-width:341px; ">
                      		<input type="text" id="odometarDatum1" style="opacity:0; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px" value = ""></input>
                     		<input id="odometarKm" type="text" value="" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px; position:relative; left:-179px">
                     </td>	
                      

                      
                  </tr>

                  <tr>
                  	<td style="font-weight:bold"><?php dic("Fm.Motor")?>:</td>
                      <td style="">
                        <input id="motor" type="text" value="<?php echo $motor ?>" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                      </td>
                      <?php
                      if ($activity == 1)
					  {
                      ?>
	                      <td style="font-weight:bold;<?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"><font color = ""><?php dic("Settings.VisibleLive")?></font>:</td>
	                      <td style="">
	                           
	                           <input type="radio" name="activity" value="1" checked="checked" style="margin-left:0px"/><?php dic("Fm.Yes") ?>
	                           <input type="radio" name="activity" value="0" style="margin-left:20px"/><?php dic("Fm.No") ?>
	                  	  </td>
	                  <?php
                      }
					  else
					  {
                      ?>
	                      <td style="font-weight:bold;<?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"><font color = ""><?php dic("Settings.VisibleLive")?></font>:</td>
	                      <td style="">
	                     	     	
	                           <input type="radio" name="activity" value="1" style="margin-left:0px" /><?php dic("Fm.Yes") ?>
	                           <input type="radio" name="activity" value="0" checked="checked" style="margin-left:20px"/><?php dic("Fm.No") ?>
		                  </td>
                      <?php
	                  }
	                  ?> 
                  </tr>

                  <tr>
                  	<td style="font-weight:bold"><?php dic("Fm.FuelCap")?>:</td>
                      <td style="">
                            <input id="capacity" type="text" value="<?php echo $capacity ?>" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px;  border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px" />
                      </td>
                    	
                      <td style="<?=$americaUserStyle?>; font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"><?php echo dic("Settings.GreenCard")?>:</td>
                      <td style="<?=$americaUserStyle?>; ">
                      	<table width=100% class="text2">
                      		<tr>
                      			<td width=158px>
                      				<?php
			                          If ($greenCard == 1) {
			                       ?>
			                           <input type="radio" name="greenCard" value="1" checked="checked" style="margin-left:-3px" /><?php dic("Fm.Yes") ?>
			                           <input type="radio" name="greenCard" value="0" style="margin-left:20px"/><?php dic("Fm.No") ?>
			                       <?php
			                          } Else {
			                           ?>
			                           <input type="radio" name="greenCard" value="1" style="margin-left:-3px" /><?php dic("Fm.Yes") ?>
			                           <input type="radio" name="greenCard" value="0" checked="checked" style="margin-left:20px"/><?php dic("Fm.No") ?>
			                           <?php
			                          }
			                       ?>
                      			</td>
                      			<td>
                      				 <!--img src='../images/alarm1.png' width=16px height=16px style="opacity:0.7; position:relative; left:75px; cursor: pointer" title="Додади алерт за зелен картон" onclick="addAlerts(28)"/-->
                      				 <!--span onclick="addAlerts(28)" title="<?= dic_("Settings.AlertGreenCardTitle")?>" style="background-image: url('../images/icons.png'); background-position: -204px -50px; width: 16px; height: 16px; cursor: pointer; display: inline-block; position:relative;"></span-->
                      			</td>
                      		</tr>
                      	</table>
                      </td>		
					
                  </tr>
                                
                  <?php
                  if ($clienttypeid == 4) {
                  ?>
                  <tr>
                  	<td style="font-weight:bold"><?php echo dic_("Reports.Range")?> (<?php echo dic_("Reports.Meters")?>) :</td>
                      <td style="">
                            <input id="range" type="text" value="<?php echo $range ?>" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:6px"/>
                      </td>
                      <td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"></td>
	                  <td style="">
	                  		
	                  </td>
                  </tr>
                  <?php
                  }
                  ?>
                  <tr>
                  	<td style="font-weight:bold;">&nbsp;</td>
                  	<td style=";">&nbsp;</td>
                    <td style="font-weight:bold;<?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>">&nbsp;</td>
					<td style="">&nbsp;</td>
                  </tr>
                 
                  <!--tr>
                  <td colspan="4">
                  <table cellpadding="5" <?php if($yourbrowser == "1") {?>style="padding-left:20px;border:1px solid #2F5185;"<?php }else {?>style="padding-right:5px;border:1px solid #2F5185;"<?php };?> class="text2_">	
                  <tr style="display: block; ">	
                  	<td style="font-weight:bold;">(<?php dic("Reports.Odometer")?>) <?php dic("Settigns.SelectDate")?>:&nbsp;&nbsp; </td>
                  	<td style="font-weight:bold;">
                    	<input type="text" id="odometarDatum" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px" value = "<?php echo $denes;?>"></input>
                    </td>
                    <td style="font-weight:bold;<?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>">
                    	<?php dic("Settings.PastKm")?>: (km)
                    </td>
                   	<td style="font-weight:bold;">
                   		<input type="text" id="odometarVrednost" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                    </td>
                    <td style="font-weight:bold;">
                   		 <button id="promeniOdometar" onclick="promeniOdometar(<?php echo $id ?>)"><?php dic("Fm.Change")?></button>
                    </td>
                   </td>
                   </tr>
                   </table>
                  </tr-->



<?php
                  
                  if ($clienttypeid == 5) {
                  	$dsVehicle = query("select * from vehicles where id = " . $id);
                  ?>
                	
                 <?php
                 if (pg_fetch_result($dsVehicle, 0, "showrpm") == "rpm") {
                 ?>
                 <tr style="height:70px;">
                      <td colspan="4"><div style="border-bottom:1px solid #bebebe"></div></td>
                  </tr>
                 <tr>
                  <td colspan="4">
                 	 <table width=80% cellpadding="5" <?php if($yourbrowser == "1") {?>style="padding-left:10px;"<?php }else {?>style="padding-right:5px;"<?php };?> class="text2_">
                		<tr ><td colspan=2 class="textTitle" style="font-size:16px;"><?php dic("Reports.ActiveHours") ?></td></tr>
                		<tr width=100% style="">	
	                  		<td width=29% align="left" style="vertical-align:top"><strong><?php echo dic_("Reports.MinRPM")?>:</strong> <input type="text" value="<?php echo pg_fetch_result($dsVehicle, 0, "rpm_min") ?>" disabled="" style="width:41px; height:25px" class="text2"/></td>
	                  		<td width=29% align="center" style="vertical-align:top"><strong><?php echo dic_("Reports.MaxRPM")?>:</strong> <input type="text" value="<?php echo pg_fetch_result($dsVehicle, 0, "rpm_max") ?>" disabled="" style="width:41px; height:25px" class="text2"/></td>
	                  		<?php
	                  		if (pg_fetch_result($dsVehicle, 0, "calcactivehours") == "rpmspeed") {
	                  		?>
	                  			<td width=24% align="right"><strong><?php echo dic_("Reports.RpmLimit")?>:</strong> <input type="text" value="<?php echo pg_fetch_result($dsVehicle, 0, "rpmlimit") ?>" disabled="" style="width:41px; height:25px" class="text2"/><br><strong><?php echo dic_("Reports.SpeedLimit")?>:</strong> <input type="text" value="<?php echo pg_fetch_result($dsVehicle, 0, "speedlimit") ?> Km/h" disabled="" style="width:51px; height:25px; margin-top:5px" class="text2"/></td>
	                  		<?php	
							} else {
							?>
								<td width=24% align="right"><strong><?php echo dic_("Reports.RpmLimit")?>:</strong> <input type="text" value="<?php echo pg_fetch_result($dsVehicle, 0, "rpmlimit") ?>" disabled="" style="width:41px; height:25px" class="text2"/></td>
							<?php	
							}
	                  		?>
	                  		
                 		</tr>
                 	</table>
 			   	  </td>
                </tr>
                  <?php
                  }
				  ?>
 				
				<?php
				if (pg_fetch_result($dsVehicle, 0, "showrpm") == "percent") {
                 ?>
                 <tr style="height:70px;">
                      <td colspan="4"><div style="border-bottom:1px solid #bebebe"></div></td>
                  </tr>
                  <tr>
                 	 <td colspan="4">
                 		 <table width=80% cellpadding="5" <?php if($yourbrowser == "1") {?>style="padding-left:10px;"<?php }else {?>style="padding-right:5px;"<?php };?> class="text2_">
                			 <tr ><td colspan=2 class="textTitle" style="font-size:16px;"><?php dic("Reports.ActiveHours") ?></td></tr>
                			 <tr width=100% style="">
								<td colspan=2 width=45%></td>
		                  		<?php
		                  		if (pg_fetch_result($dsVehicle, 0, "calcactivehours") == "rpmspeed") {
		                  		?>
		                  			<td width=27% align="right"><strong><?php echo dic_("Reports.RpmLimit")?>:</strong> <input type="text" value="<?php echo pg_fetch_result($dsVehicle, 0, "rpmlimit") ?> %" disabled="" style="width:41px; height:25px; " class="text2"/><br><strong><?php echo dic_("Reports.SpeedLimit")?>:</strong> <input type="text" value="<?php echo pg_fetch_result($dsVehicle, 0, "speedlimit") ?> Km/h" disabled="" style="width:41px; height:25px; margin-top:5px" class="text2"/></td>
		                  		<?php	
								} else {
								?>
									<td width=27% align="right"><strong><?php echo dic_("Reports.RpmLimit")?>:</strong> <input type="text" value="<?php echo pg_fetch_result($dsVehicle, 0, "rpmlimit") ?> %" disabled="" style="width:41px; height:25px" class="text2"/></td>
								<?php	
								}
		                  		?>
		                  		
		                  		
                  	 		 </tr>
                  	 		 
                  		</table>
 			   	 	</td>
                 </tr>
                  <?php
                  }

				  }
                  ?>


                  <tr>
                  	<td style="font-weight:bold;"></td>
                  	<td style=";">
                    </td>
                    <td style="font-weight:bold;padding-left:30px"></td>
                   	<td style="">
                    </td>
                  </tr>
				  <tr style="height:70px;">
                      <td colspan=4><div style="border-bottom:1px solid #bebebe"></div></td>
                  </tr>
                  <tr>
                      <td colspan=4>
                         <table id="allVehicles" style="padding-bottom:15px; padding-right:15px" >
                             <tr ><td colspan=2 class="textTitle" style="font-size:16px;"><?php dic("Fm.AllDrivers") ?></td></tr>
                             <tr>
                                 <td  id="btnAddDrivers" class="textTitle" style="font-size:16px;">
                                    <button id="addAllDri" style="margin-top:10px;" onclick="addAllDriver('<?php echo $cLang ?>', <?php echo $id ?>)"><?php dic("Fm.Add")?></button>
                                 </td>
                                 <td></td>
                             </tr>
                             <tr><td colspan=2 style="height:10px"></td></tr>
                             
  <?php
	 
	  $totalDr = dlookup("select count(*) from drivers where clientid=" . session("client_id"));
	  $totalAlDr = dlookup("select count(*) from vehicledriver where vehicleid =" . $id);
		
      $sqlAllDri = "select * from vehicledriver where vehicleid =" . $id;
      $dsAD = query($sqlAllDri);
	  
      $idDriver = 0;
      $sqlDrivers = "";
      $cnt = 0;     
            
      If (pg_num_rows($dsAD) > 0) {
          ?>

          <tr class="text2" style="font-weight:bold; background:#dadada; height:25px">
             <td align=left style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:10px; width:80px"><?php dic("Fm.Code") ?></td>
             <td align=left style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:10px; width:200px"><?php dic("Fm.FullName") ?></td>
             <td align=center style="background-color:#E5E3E3; border:1px dotted #2f5185; width:67px; color:#ff6633; font-weight:bold;"><?php dic("Fm.Delete") ?></td>
          </tr>

          <?php

          while ($drAd=pg_fetch_array($dsAD)) {
         		 $idDriver = $drAd["driverid"];
                 $cntDr = dlookup("select count(*) from drivers where ID=" . $idDriver);
         		 $sqlDrivers = "select fullname, code from drivers where id=" . $idDriver;
          		 $dsDrivers = query($sqlDrivers);
                 If ($cntDr > 0) {
          			//drDrivers = dsDrivers.Tables(0).Rows(0)
               ?>
                 <tr id="tr<?php echo $cnt ?>"  style=" color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; ">
                     <td height=25px align=left style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:10px"><?php echo nnull(pg_fetch_result($dsDrivers, 0, "code"), "/") ?></td>
                     <td height=25px align=left style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:10px; width:200px"><?php echo nnull(pg_fetch_result($dsDrivers, 0, "fullname"), "/") ?></td>
                     <td height=25px  align=center style="background-color:#fff; border:1px dotted #B8B8B8; ">
                         <button id="btn<?php echo $cnt ?>" class="btn-driver" style="height:27px; margin-left:8px; margin-right:8px; width:30px" onclick="DelAllowedDriver(<?php echo $cnt ?>, <?php echo $drAd["id"] ?>)"></button>
                     </td>
                 </tr>
          <?php
              		$cnt = $cnt + 1;
     			 } //end if
             } //end while
      	}
		else
		{
        ?>

               <tr><td colspan=3 class="text2" style="font-style:italic"><?php dic("Fm.NoAllDrivers") ?></td></tr>
		<?php
        } //end if
                 //$cLang = getQUERY("lang");
        ?>

                </table>

            </td>
        </tr>

		<?php
		if ( $allowgarmin == "1")
        { ?>

        <tr style="height:50px;">
             <td colspan=6><div style="border-bottom:1px solid #bebebe"></div></td>
        </tr>
        <tr><td colspan=6><div class="textTitle" style="font-size:16px;"><?=dic_("Settings.GarminComm")?></div><br><br></td></tr>
        <tr>
        	<td colspan=6 class="textTitle" style="font-size:16px;">
        		<table width="99%" height="99%" class="text2_" style="margin:5px; overflow: hidden;">
					<tr>
				    	<td height="90px">
							<font class="text2_" style="font-size:16px;"><?=dic_("Settings.PredefMess")?></font><br><br><br>
							<input id="txtCanned" class="corner5" style="width: 233px; height: 28px; padding: 5px; margin-left: 8px; color: #2f5185; border: 1px solid #ccc;" type="text" value="" placeholder="<?=dic_('Settings.EnterPredefMess')?>" />
							<button id="addquickmess" style="margin-left: 20px; cursor: pointer;" onclick="ShowWait(); ButtonAddCanned(<?=$id?>, '<?=$gsmnum?>', '0')"><?php dic("Settings.Add") ?></button><br>
							<input id="txtCannedToAll" type="checkbox" style="margin-left: 8px; color: #2f5185;" />&nbsp;<?=dic_("Settings.ForAllVehicles")?>
							<br><br>
							<script>
				    			$('#addquickmess').button({ icons: { primary: "ui-icon-plusthick"} })
				    		</script>
						</td>
				    </tr>
				   	<tr>
				    	<td>
							<font class="text2_" style="font-size:16px;"><?=dic_("Settings.VehGarminComm")?></font><br><br><br>
							<select id="txtCannedReg" data-placeholder="" style="margin-right:5px; margin-left:8px; width: 235px; font-size: 11px; position: relative; top: 0px; z-index: 0; visibility: visible; background-color:white" class="combobox text2_">
								<option id="0" selected value="<?=dic_('SelectVeh')?>"><?=dic_("SelectVeh")?></option>
								<?php
								if (session("role_id")."" == "2") {
									$tovehicles = "select * from vehicles where clientid=" . session("client_id") . " and allowgarmin='1' and id <> " . $id . " and id not in (select toid from quickmessage where vehicleid=" . $id . " and toid is not null)";
								} else {
									$tovehicles = "select * from vehicles where id in (select distinct vehicleid from uservehicles where userid=(" . session("user_id") . ")) and allowgarmin='1' and id <> " . $id . " and id not in (select toid from quickmessage where vehicleid=" . $id . " and toid is not null)";
								}
					          	$dsVehicles = query($tovehicles);
					          	while ($drVehicles = pg_fetch_array($dsVehicles)) {
					          	?>
					                  <option id="<?= $drVehicles["id"] ?>" value="<?=$drVehicles["registration"]?>"><?= $drVehicles["registration"]?> (<?= $drVehicles["code"]?>)</option>
					           	<?php } //end while ?>
				            </select>
				            <button id="addquickmess2" style="margin-left: 20px; cursor: pointer;" onclick="ShowWait(); ButtonAddCanned(<?=$id?>, '<?=$gsmnum?>', '1')"><?php dic("Settings.Add") ?></button>
							<script>
				    			$('#addquickmess2').button({ icons: { primary: "ui-icon-plusthick"} })
				    		</script>
				    	</td>
				    </tr>
				    <tr>
				    	<td>
				    		<br><br>
						<?php
						    $quckmess = query("select * from quickmessage where vehicleid = ".$id." order by messageid asc"); ?>
							
							<table style="width: 100%; position: relative; display: block; overflow-x: hidden; overflow-y: auto; min-height: 60px;">
								<tr>
						        	<td align = "left" width="10%" height="25px" align="center" class="text2_" style="padding-left:10px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?=dic_("Settings.MessNo")?></td>
									<td align = "left" width="80%" height="25px" align="center" class="text2_" style="padding-left:10px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?=dic_("Message")?></td>
									<!--td align = "center" width="8%" height="25px" align="center" class="text2_" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><font color = "#ff6633"><?php dic("Settings.Change")?></font></td--> 
									<td align = "center" width="10%" height="25px" align="center" class="text2_" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><font color = "#ff6633"><?php dic("Tracking.Delete")?></font></td>
						        </tr>
						        <tbody id="predefmess">
					  			<?php
					  			if(pg_num_rows($quckmess) == 0)
								{
								?>
									<tr><td colspan=2>
										<div id="noDataquickmess" style="padding: 10px; font-size:20px; font-style:italic;" class="text4">
											<?php dic("Reports.NoData1")?>
										</div>
									</td></tr>
								<?php
								}
								else
								{
								?>
								<?php
								while ($row3 = pg_fetch_array($quckmess)) {
									$opac = '1';
									$dis = 'none';
									if($row3["flag"] == "0") {
										$opac = '0.5';
										$dis = 'block';
									}
						 		?>
								<tr style="opacity: <?=$opac?>">
									<td align="left" width="53px" height="30px" class="text2_" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:10px">
										<img title="" style="display: <?=$dis?>; position: absolute; margin-left: 18px;" width="13px" src="../images/nosignal.png" />
										<?= $row3["messageid"] ?>
									</td>
									<td align="left" width="80%" height="30px" class="text2_" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8;">
										<?= $row3["body"] ?>
									</td>

									<td align="center" width="10%" height="30px" class="text2_" style="background-color:#fff; border:1px dotted #B8B8B8; ">
										<button id="DelBtnQM<?= $row3["id"] ?>"  onclick="DeleteQuickmessClick(<?= $row3["messageid"]?>, '<?= $gsmnum?>')" style="height:25px; width:30px"></button>
									</td>
									 <script>
								   		$('#DelBtnQM' + '<?= $row3["id"] ?>').button({ icons: { primary: "ui-icon-trash"} })
									 </script>
								 </tr>
								<?php } } ?>
								</tbody>
							</table>
				    	</td>
					</tr>
				</table>
			</td>
        </tr>
       	
        
        <?php
        
        } ?>
        
        <tr style="height:50px;">
             <td colspan=6><div style="border-bottom:1px solid #bebebe"></div></td>
        </tr>
        

<!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>.>>>   ALERTS    >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> -->

	<tr>
    	<td colspan=6 class="textTitle" style="font-size:16px;"><?php dic("Settings.Alerts") ?></td>
    </tr>

	<tr colspan=6>
    <td>
    	<button id="add5" style="margin-top:10px" onclick="storeAlerts()"><?php dic("Settings.Add") ?></button>
        <script>
        if (<?php echo $allowedalarms?> == 0)
        {
        	document.getElementById('add5').disabled="disabled";
        }
        else
        {
        	document.getElementById('add5').disabled="";
        }
        </script>
    </td>
    </tr>
    <tr><td height=10px colspan=6></td></tr>

    <?php

    if($allowedalarms!=0)
    {

    $cnt7 = 1;

	$getQueryUser = pg_fetch_array(query("select * from users where id=" .session("user_id")));
	$allowedSMSvEmail = $getQueryUser["allowsmsvemail"];
	$snooze = $getQueryUser["snooze"];
	$all_alerts = [];

	$alertD = query("select a.*,at.name, at.description, v.registration, cast(v.code as integer) code, v.id vid from alarms a left join alarmtypes at on a.alarmtypeid=at.id left join vehicles v on a.vehicleid=v.id
				where a.clientid=" .session("client_id"). " and at.id <> 11 and a.vehicleid = ".$id."
				order by cast(a.uniqid as integer) desc, alarmtypeid, code asc");

	$rowCnt = 0;

		if(pg_num_rows($alertD)==0)
		{
		?>
		<tr>
			<td colspan=6>
				<div id="noData" style="padding-left:43px; font-size:25px; font-style:italic; padding-bottom:40px" class="text4">
		 		<?php dic("Reports.NoData1")?>
				</div>
			</td>
		</tr>

		<?php
		}
		else
		{
		?>
		<table  <?php if($yourbrowser == "1") { ?> width="98%" style="min-width:900px;padding-left:10px;" <?php } else { ?> width="75%"  style="min-width:900px;padding-left:40px;" <?php } ?> class="text2">
		<tr>
	        <td align = "left" width="26%" height="25px" align="center" class="text2" style="padding-left:10px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.TypeOfAlert") ?></td>
			<td align = "left" width="30%" height="25px" align="center" class="text2" style="padding-left:10px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?= dic_("Settings.Email")?></td>
			<?php
			if ($clienttypeid == 6) {
				?>
				<td align = "left" width="20%" height="25px" align="center" class="text2" style="padding-left:10px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php echo dic_("Settings.SMS")?></td>
				<?php
			}
			?>
			<td align = "left" width="13%" height="25px" align="center" class="text2" style="padding-left:10px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.Sound") ?> (Snooze)</td>
	        <td align = "left" width="15%" height="25px" align="center" class="text2" style="padding-left:10px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><?php dic("Settings.AvailableFor1")?></td>
	        <td align = "center" width="8%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><font color = "#ff6633"><?php dic("Settings.Change")?></font></td> 
			<td align = "center" width="8%" height="25px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><font color = "#ff6633"><?php dic("Tracking.Delete")?></font></td>
        </tr>

		<?php
		while($alert_row = pg_fetch_assoc($alertD))
 		{
 			$rowCnt++;
 			array_push($all_alerts, $alert_row);
 			?>
 			<tr id="<?php echo $alert_row["id"]?>">
				<td align = "left" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:10px">
					<?php dic($alert_row['name']) ?>&nbsp;
					<?php
					if ($alert_row["alarmtypeid"] == 17){
						if ($alert_row["remindme"] != "") {
							$arr = explode(" ", $alert_row["remindme"]);
							if ($arr[1] == "days") $remindme = $arr[0] . " " . dic_("Reports.Days_");
							else {
								$remindme = round($arr[0] * $value,0) . " " . $metric;
							}
							echo " (". $remindme ." " . dic_("Settings.Before") . ")";
						}

					}

					if ($alert_row["alarmtypeid"] == 18){
						if ($alert_row["remindme"] != "") {

							$arr = explode("; ", $alert_row["remindme"]);
							if(count($arr) == 1) {
								$arr1 = explode(" ", $arr[0]);
								if ($arr1[1] == "days") $remindme = $arr1[0] . " " . dic_("Reports.Days_");
								else $remindme = round($arr1[0] * $value,0) . " " . $metric;
								echo " (". $remindme ." " . dic_("Settings.Before") . ")";
							} else {
								$arr1 = explode(" ", $arr[0]);
								if ($arr1[1] == "days") $remindme = $arr1[0] . " " . dic_("Reports.Days_");
								else $remindme = round($arr1[0] * $value,0) . " " . $metric;

								$arr2 = explode(" ", $arr[1]);
								if ($arr2[1] == "days") $remindme1 = $arr2[0] . " " . dic_("Reports.Days_");
								else $remindme1 = round($arr2[0] * $value,0) . " " . $metric;

								echo " (". $remindme .", " . $remindme1 . " " . dic_("Settings.Before") . ")";
							}
						}

					}

					if ($alert_row["alarmtypeid"] == 20){
						if ($alert_row["remindme"] != "") {

						$arr = explode(" ", $alert_row["remindme"]);
							if ($arr[1] == "days") $remindme = $arr[0] . " " . dic_("Reports.Days_");
							else {
								$remindme = round($arr[0] * $value,0) . " " . $metric;
							}
							echo " (". $remindme ." " . dic_("Settings.Before") . ")";
						}
					}

					if ($alert_row["alarmtypeid"] == 7){
						echo "(". round($alert_row['speed'] * $value) . " " .$unitSpeed.")";
					}

					if ($alert_row["alarmtypeid"] == 10){
						echo "(" . dlookup("select name from pointsofinterest where id = ".$alert_row["poiid"]) . ")<br>(" . $alert_row['timeofpoi'] . " " . dic_("Settings.minutes") . ")";
					}

					if ($alert_row["alarmtypeid"] == 9){
						echo "(" . dlookup("select name from pointsofinterest where id = ".$alert_row["poiid"]) . ")";
					}

					if ($alert_row["alarmtypeid"] == 8){
						echo "(" . dlookup("select name from pointsofinterest where id = " . $alert_row["poiid"]) . ")";

					}
					?>
				</td>

				<td align = "left" height="30px" class="text2" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8;">
					<?php
						if($alert_row["emails"]!="") echo $alert_row["emails"];
					?>
				</td>
				<?php
				if ($allowedSMSvEmail == 1) { ?>
					<td class="text2 td-row la">
					<?php
						if($alert_row["smsviaemail"] != null) {
							echo str_replace(',', '<br>', $alert_row["smsviaemail"]);
						} else echo "/";
					?>
					</td>
				<?php
				}
				?>
				<td align = "left" cheight="30px" class="text2" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8; ">
					<?php echo dic_("Settings.Sound") . "  " . $alert_row["soundid"];
					echo (($snooze == 0) ? dic("Settings.NoRepetition") : " (" . $snooze . " " . dic_("Reports.Minutes") . ")"); ?>
				</td>
					<td align = "left" cheight="30px" class="text2" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8; ">
					<?php
						if($alert_row["available"] == 1) {
							echo dic_("Settings.User");
						} else
						if($alert_row["available"] == 2) {
							echo dic_("Reports.OrgUnit");
						} else
						if($alert_row["available"] == 3) {
							echo dic_("Settings.Company");
						} else {
							?> / <?php
						}
					?>
				</td>

				<td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
					<button id="btnEditA<?php echo $rowCnt?>" class="edit-btn" onclick="storeAlerts(true,<?php echo $alert_row["id"]?>)" style="height:22px; width:30px"></button>
				</td>
				<td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
					<button id="DelBtnA<?php echo $rowCnt?>" class="del-btn" onclick="DeleteAlertClick(<?php echo $alert_row["id"]?>)" style="height:22px; width:30px"></button>
				</td>

 			</tr>
 		<?php } ?>

 		</table>

	<?php
		 }?>

	<script type="text/javascript">
		row_array = <?php echo json_encode($all_alerts); ?>;
		getMO = <?php echo json_encode($getFullOperators); ?>;
	</script>

	<!-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>> [END] ALERTS TABLE   >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>><  -->


     <div id="div-del-allowed-driver" style="display:none" title="<?php dic("Settings.DeletingAllowedDriver") ?>">
      	<?php dic("Settings.DeletingAllowedDriverQuestion") ?>
     </div>

     <?php
     }
     ?>
     <table style="padding-left:40px;min-width:900px;" class="text2"  width="75%">
		<tr style="height:50px;">
			 <td colspan=4><div style="border-bottom:1px solid #bebebe"></div></td>
        </tr>

        <tr>
        <td colspan=6 align="right">
	       	 <button id="mod1" onclick="modify()"><?php dic("Fm.Mod") ?></button>
	         <button id="cancel1" onclick="cancel()"><?php dic("Fm.Cancel") ?></button>
    	 </td>

     </tr>
     <tr><td colspan=4 style="height:50px"></td></tr>
     </table>

<!-- >>>>>>>>>>>>>>>>>>>>> OLD DIALOG ADD ALERTS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>   -->

<!-- **************************************   ADD DIALOG   ******************************************** -->

<div id="dialog-alerts" style="display:none" title="<?php dic("Settings.AddAlerts") ?>">
	<div align = "center">

	<table cellpadding="3" width="100%" style="padding-top: 25px;">
		<tr>
			<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php dic("Settings.TypeOfAlert") ?></td>
			<td width = "75%">
			<select id = "TipNaAlarm" style="font-size: 11px; width:365px; position: relative; top: 0px ;visibility: visible;" onchange="OptionsChangeAlarmType()" class="combobox text2">
			<?php

			$alarmgroup = "";
			foreach ($alarmTypes as $index => $alarmRow) {

				// proverki za koi opcii da bidat dozvoleni
				$alarmRow['check'] = 0;
				$alarmRow['jump'] = 1;

				if($alarmRow['id'] == 48 && $allowFuel == 0) $alarmRow['check'] = 1;	// alarm za dozvoleno gorivo
				if(($alarmRow['id'] == 23 || $alarmRow['id'] == 22) && $allowedRFID == 0) $alarmRow['check'] = 1;	// alarm za RFID
				if($alarmRow['id'] == 5  && $allowedCapace == 0) $alarmRow['check'] = 1;  // za dali e dozvoleno kapace za korivo

				if($alarmRow['alarmgroup'] == "3-RoutesCombo" && $allowedrouting == 0) $alarmRow['check'] = 1;
				if($alarmRow['alarmgroup'] == "4-FleetManagement"  && $allowedfm == 0) $alarmRow['check'] = 1;
				if($alarmRow['alarmgroup'] == "6-MotoAlarms"  && $clienttypeid != 6) $alarmRow['check'] = 1;
				if($alarmRow['alarmgroup'] == "8-AssetAlerts"  && $clienttypeid != 7) $alarmRow['jump'] = 0;
				if($alarmRow['alarmgroup'] == "7-SecurityAlerts"  && $clienttypeid != 8) $alarmRow['jump'] = 0;
				if($alarmRow['alarmgroup'] == "9-OBDAlerts"  && $clienttypeid != 9) $alarmRow['jump'] = 0;
				if($alarmRow['alarmgroup'] == "10-PersonalAlerts"  && $clienttypeid != 3) $alarmRow['jump'] = 0;

				// [END]. proverki --------------------------------------------------------------------------------------
				if($alarmRow["jump"]==1) {
					if($alarmRow["alarmgroup"] == $alarmgroup) {
						// prikazi gi site od ist alarmgroup
						?>
							<option value="<?php echo $alarmRow['id'] ?>" <?php if($alarmRow["check"]==1) echo "disabled='disabled'" ?>><?php dic($alarmRow['name']) ?></option>
						<?php
					} else {
						// promeni go
						$alarmgroup = $alarmRow["alarmgroup"];
						$alarmgroupShow = explode('-', $alarmgroup);
						// prikazi ja taa grupa kako disabled vo option
						?>
							<option disabled="disabled">----------------------<?php dic("Settings." . $alarmgroupShow[1]) ?>----------------------</option>
							<option value="<?php echo $alarmRow['id'] ?>" <?php if($alarmRow["check"]==1) echo "disabled='disabled'" ?>><?php dic($alarmRow['name']) ?></option>
						<?php
					}
				}
			}
			?>
			</select>
			</td>
		</tr>
		<tr id="toi-div" style="display:none;">
			<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("select")?> <?php echo dic_("Tracking.POI")?></td>
			<td width = "75%" style="font-weight:bold" class ="text2">
				<div class="ui-widget" style="height: 25px; width: 100%;">
					<select id="combobox" style="width: 370px;">
						<?php
						$str1 = "";
						$str1 .= "select * from pointsofinterest where clientid=" . $cid ." and type=1 and active = '1' ORDER BY name";
						$dsPP = query($str1);
						while($row = pg_fetch_array($dsPP))
						{
						?>
							<option value="<?php echo $row["id"] ?>"><?php echo $row["name"]?></option>
						<?
						}
						?>
					</select>
				</div>
			</td>
		</tr>
		<tr id="toi-div-2" style="display:none;">
			<td style="font-weight:bold" class ="text2" width="25%" align="left"><?php dic("Routes.RetentionTime")?></td>
			<td style="font-weight:bold" class ="text2" width="75%">
				<input id = "vreme" class="textboxcalender corner5 text5" type="text" size="5"></input>&nbsp;<?php echo dic("Reports.Minutes")?>
			</td>
		</tr>
		<tr id="zv-div" style="display:none;">
			<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Settings.SelectEnterGeoF")?></td>
			<td width = "75%" style="font-weight:bold" class ="text2">
				<div class="ui-widget" style="height: 25px; width: 100%;">
					<select id="comboboxVlez" style="width: 365px">
						<?php
						$str2 = "";
						$str2 .= "select * from pointsofinterest where clientid=" . $cid ." and (type=2 or type=3) and active = '1' ORDER BY name";
						$dsPP2 = query($str2);

						while($row2 = pg_fetch_array($dsPP2)) {
						?>
							<option value="<?php echo $row2["id"] ?>" ><?php echo $row2["name"]?></option>
						<?
						}
						?>
					</select>
				</div>
			</td>
		</tr>
		<tr id="zi-div" style="display:none;">
			<td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Settings.SelectExitGeoF")?></td>
			<td width = "75%" style="font-weight:bold" class ="text2">
				<div class="ui-widget" style="height: 25px; width: 100%;">
					<select id="comboboxIzlez" style="width: 370px">
						<?php
						$str3 = "";
						$str3 .= "select * from pointsofinterest where clientid=" . $cid ." and (type=2 or type=3) and active = '1' ORDER BY name";
						$dsPP3 = query($str3);
						while($row3 = pg_fetch_array($dsPP3)) {
						?>
							<option value="<?php echo $row3["id"] ?>"><?php echo $row3["name"]?></option>
						<?
						}
						?>
					</select>
				</div>
			</td>
		</tr>
		<tr id="nadminuvanjeBrzina" style="display:none;">
			<td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic("Reports.Speed")?></td>
			<td width = "75%" style="font-weight:bold" class ="text2"><input id = "brzinata" class="textboxcalender corner5 text5" type="text" size="10"></input>&nbsp;<?php echo $unitSpeed ?></td>
		</tr>

		<tr id="fm" style="display:none;">
			<td width = "27%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic_("Settings.RemindMe")?> <?php echo dic_("Settings.Before")?>:</td>
			<td width = "73%" style="" class ="text2">
				<span id="rmdD">
				 <input id="remindDays" type="checkbox" name="remindme" value="days" style="position: relative; top:4px; display:none" checked /> 
				 <input id = "fmvalueDays" class="textboxCalender corner5 text5" type="text" style="width:40px" value="5"> <?php echo dic_("Reports.Days_")?>
				</span>
				<span id="rmdKm" style="display: none">
				 <input id="remindKm" type="checkbox" name="remindme" value="Km" style="position: relative; top:4px; margin-left: 15px" /> 
				 <input id = "fmvalueKm" class="textboxCalender corner5 text5" type="text" style="width:40px" value="0"> <?php echo $metric?>
				</span>
			</td>
		</tr>
		<tr id="noteFmAlarm" style="display:none">
			<td width = "27%"></td>
			<td id="textFmAlarm" width = "73%" class="text2" style="color:#ff0000; font-size: 10px"></td>
		</tr>
		<tr>
			<td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic_("Tracking.Emails")?></td>
			<td width = "75%" style="font-weight:bold" class ="text2"><input id = "emails" class="textboxcalender corner5 text5" type="text" style = "width:365px"></input></td>
		</tr>
		<tr>
			<td width = "25%"></td>
			<td width = "75%" class ="text2" style="font-size:10px"><font color = "red" ><?php echo dic_("Reports.SchNote")?></font></td>
		</tr>

		<!-- *************************** SMS VIA EMAIL ******************************************* -->

		<tr class="SMSemail" style="display:none">
			<td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic_("Tracking.SMSEmails")?></td>
			<td width = "75%" style="font-weight:bold" class ="text2"><input id = "smsviaemail" class="textboxcalender corner5 text5" type="text" style = "width:365px"></input></td>
		</tr>

		<tr class="SMSemail" style="display:none">
			<td width = "25%" ></td>
			<td width = "75%" class ="text2" style="font-size:10px"><font color = "red" ><?php echo dic_("Reports.SchNoteSms")?></font></td>
		</tr>

		<!-- *************************** SMS VIA EMAIL ******************************************* -->
		<tr>
			<td width = "25%" valign="middle" style="font-weight:bold" class ="text2" align="left"><?php dic("Settings.Sound")?></td>
			<td width = "75%" valign="middle">
			<select id = "zvukot" style="font-size: 11px; position: relative; top: 0px ;visibility: visible; float:left" class="combobox text2">
			<option value = "1"><?php dic("Settings.Sound")?> 1</option>

			<option value = "2"><?php dic("Settings.Sound")?> 2</option>
			<option value = "3"><?php dic("Settings.Sound")?> 3</option>
			<option value = "4"><?php dic("Settings.Sound")?> 4</option>
			<option value = "5"><?php dic("Settings.Sound")?> 5</option>

			</select>
			<audio id="demo" src="../tracking/sound/bells_alarm.ogg"></audio>
			<button id="play" onclick="document.getElementById('demo').play()" style="position: relative; width: 35px;height: 28px; margin-left:10px;"></button>
			<button id="pause" onclick="document.getElementById('demo').pause()" style="position: relative; width: 35px;height: 28px;"></button>
			<button id="poglasno" onclick="document.getElementById('demo').volume+=0.1" style="position: relative; width: 35px;height: 28px;"></button>
			<button id="potivko" onclick="document.getElementById('demo').volume-=0.1" style="position: relative; width: 35px;height: 28px;"></button>
			</td>
		</tr>
		<tr>
			<td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic_("Settings.AvailableFor1")?>:</td>
			<td width = "75%" style="font-weight:bold" class ="text2"><div id="gfAvail" class="corner5">
			<input type="radio" value="1" id="GFcheck1" name="radio" checked="checked" /><label for="GFcheck1"><?php echo dic_("Settings.User")?></label>
			<input type="radio" value="2" id="GFcheck2" name="radio" /><label for="GFcheck2"><?php echo dic_("Reports.OrgUnit")?></label>
			<input type="radio" value="3" id="GFcheck3" name="radio" /><label for="GFcheck3"><?php echo dic_("Settings.Company")?></label>
			</div>
			</td>
		</tr>
		</table>
	</div>
</div>

<!-- ************************************************************************************************** -->


     <div id="div-add" style="display:none" title="<?php dic("Fm.AddAllDriver")?>"></div>

     <div id="div-ask-confirmation" style="display:none" title="<?php echo dic("Settings.Action")?>">
    	Постои веќе внесен податок со понов датум од тој што го имате Вие одбрано.Дали сте сигурни дека
    	сакате да го внесете овој датум со оваа вредност за одометар како последен запис ?
     </div>
     <div id="dialog-message" title="<?php echo dic("Reports.Message")?>" style="display:none">
	 <p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		<div id="div-msgbox" style="font-size:14px"></div>
	 </p>
	</div>
	<div id="addCanned" title="<?=dic_('Settings.GarminComm')?>" style="display:none">
		 <p>
			<div align="center" style="font-size:14px">
				<?=dic_("Settings.VehGarminComm")?>
				<br><br>
				<select id="sendto" data-placeholder="" style="margin-right:5px; margin-left:8px; width: 235px; font-size: 11px; position: relative; top: 0px; z-index: 0; visibility: visible; background-color:white" class="combobox text2">
				<!--input id="txtCanned" type="text" class="textboxCalender corner5" style="width:300px" /-->
				<?php
				$tovehicles = "select * from vehicles where id in (select distinct vehicleid from uservehicles where userid=(" . session("user_id") . ")) and allowgarmin='1'";
              	$dsVehicles = query($tovehicles);

              	while ($drVehicles = pg_fetch_array($dsVehicles)) {
              	?>
                      <option id="<?= $drVehicles["id"] ?>" value="<?=$drVehicles["registration"]?>"><?= $drVehicles["registration"]?> (<?= $drVehicles["code"]?>)</option>
               	<?php } //end while ?>
                </select>
			</div>
		</p>
	</div>
</body>

<script>

vehicleID = <?php echo $id; ?>

function DeleteQuickmessClick(_messid, _gsmnum){
	if(ws != null) {
		if (confirm("Дали сте сигурни дека сакате да ја избришете оваа предефинирана порака?") == true) {
			ShowWait();
			ws.send('quickmessdel', _gsmnum + '$*^' + _messid);
	   	}
   	}
}
function EditQuickMessClick(_text, _id, _messid, _gsmnum){
	$('#txtCanned').val(_text);
    $('#addCanned').dialog({ modal: true, width: 370, height: 200, resizable: false, zIndex: 9998,
        buttons:
        [{
            text:dic("Insert"),
            click: function() {
                ButtonEditCanned(_id, _messid, _gsmnum);
                $(this).dialog("close");
            }
        }]
    });
}
function ButtonEditCanned(_id, _messid, _gsmnum) {
	if(ws != null) {
	    $.ajax({
	        url: "../main/AddCanned.php?action=edit&id=" +_id + "&name=" + kescape($('#txtCanned').val()) + "&tpoint=..",
	        context: document.body,
	        success: function (data) {
                ws.send('quickmess', _gsmnum + '$*^' + $('#txtCanned').val() + '$*^' + _messid);
                window.location.reload();
	        }
	    });
   	}
}

function msgboxPetar(msg) {
$("#DivInfoForAll").css({ display: 'none' });
$('#div-msgbox').html(msg)
$("#dialog-message").dialog({
    modal: true,
    zIndex: 9999, resizable: false,
    buttons: {
        Ok: function () {
            $(this).dialog("close");
    	}
    }
});
}

function promeniOdometar(id){

var odometarVrednost = $('#odometarKm').val().replace(/\,/g,'').replace(/\./g,'');
if ('<?php echo $metric?>' == 'mi') {
	odometarVrednost = parseInt(odometarVrednost * 1.609344498);
}
var datumce = $('#odometarDatum1').val();
//var datumce1 = $('#odometarDatum1').val();

if(odometarVrednost=="")
{
	msgboxPetar("Мора да внесете километри за одометарот.")
}
else
{
//top.ShowWait();
$.ajax({
    url: "UpdateOdometar.php?id="+ id+"&odometarVrednost="+odometarVrednost+"&datumce="+datumce,
    context: document.body,
    success: function(data){
    if(data == 1)
    {
	    $('#div-ask-confirmation').dialog({ modal: true, width: 370, height: 190, resizable: false,
        buttons: 
        [
        {
            	text:dic("Settings.Yes"),
			    click: function() {
                        $.ajax({
				        url: "UpdateOdometar2.php?id="+ id+"&odometarVrednost="+odometarVrednost+"&datumce="+datumce,
				        context: document.body,
				        success: function(data){
				        msgboxPetar(dic("Settings.SuccChanged",lang))
				        window.location.reload();
			    		}
		       	       });	
                      $( this ).dialog( "close" );
                    }
			      },
			    {
			    text:dic("Settings.No",lang),
                click: function() {
				    $( this ).dialog( "close" );
			    }
             }
          ]
       });
    }

    if(data == 0)
    {
    	$.ajax({
	        url: "UpdateOdometar2.php?id="+ id+"&odometarVrednost="+odometarVrednost+"&datumce="+datumce,
	        context: document.body,
	        success: function(data){
	        msgboxPetar(dic("Settings.SuccChanged",lang))
	        window.location.reload();
		}
       });
    }
    //top.HideWait();
    }
   });
  }
}

function DeleteAlertClick(id) {
	$('<div></div>').dialog({
	modal: true,
	width: 350,
	height: 170,
	resizable: false,
	title: dic("Settings.AlertDeleteQuestion"),
	open: function() {
      $(this).html(dic("Settings.DelAlert"));
    },
	    buttons:
	    [
	    {
	    	text:dic("Settings.Yes",lang),
		    click: function() {
	                $.ajax({
	                    url: "DelAlerts.php?id="+ id ,
	                    context: document.body,
	                    success: function(data){
	                    $('#' + id).fadeOut(400, function(){
	                    	$(this).remove();
	                    	});
						}
	                });
	                $( this ).dialog( "close" );
	               }
		    },
		    {
		    text:dic("Settings.No",lang),
	        click: function() {
			    $( this ).dialog( "close" );
		    }
	   }
	   ]
	});
}

var allRemoved = "";

/*
	>>>>>>>>>>>>>>>>>>>>  DODADENI FUNKCII  >>>>>>>>>>>>>>>>>>>>
 */

// koga nasokata e zapis vo baza (klient - > server)
function convertMetric( edinica, vrednost) {
	return (edinica.toLowerCase() == 'mi') ?  (Number(vrednost) * 1.60934) : Number(vrednost);
}

function email_validate(value) {
    var emailovi = value.split(",");
    var izlez;
    emailovi.forEach(function(mejl) {
        var filter = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
        izlez = filter.test(mejl.trim());
    });
    return izlez;
}

function validate_smsvemails(value, operators) {
	var mails = value.split(',');
	var ret = true;
	var new_data = "";
	mails.forEach(function(data){
		var filter = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
		ret = ret && filter.test(data.trim());
		new_data+=data.trim()+",";
		var cell_numb = data.split('@');
		ret = ret && validate_phone(Number(cell_numb[0]));
	    var op = cell_numb[1];
	    validate_smsvemails.check = check_operator(operators,op);
	});
	validate_smsvemails.v = new_data.slice(0,-1); // za poslednata zapirka
	return ret;
}

function check_operator(operators,value){
	var ret = false;
	operators.forEach(function(data){
		if(data.email == value) ret = ret || true;
	});
	return ret;
}

function timed_refresh (delay) {
	setTimeout(function(){
	   	window.location.reload(1);
	}, delay);
}

function isNum( obj ) {
    return !jQuery.isArray( obj ) && (obj - parseFloat( obj ) + 1) >= 0;
}

function isNormalInteger(str) {
    var n = ~~Number(str);
    return String(n) === str && n > 0;
}

function isChecked( obj ) {		// samo za id
	return ($('#'+obj).is(':checked'));
}

function hideVeh(id) {
	$('#'+ id + " td:nth-child(3) div").slideToggle(280);
}

function get_operator_id (obj_arr, mobilenoperator) {
	for(i=0; i<obj_arr.length; ++i){
		if(obj_arr[i].id == mobilenoperator) {
			return i;
		}
	}
}

function get_operator_email (obj_arr, operatoremail) {
	for(i=0; i<obj_arr.length; ++i){
		if(obj_arr[i].email === operatoremail) {
			return i;
		}
	}
}


/**
 *     |----------------------------------------------|
 * 	   |>>>>>>>>>   MAIN FUNCTION STORE/EDIT   >>>>>>>|
 * 	   |----------------------------------------------|
 */

function storeAlerts(isEdit, _id) {

	var args = arguments.length

	if (typeof(isEdit)==='undefined') isEdit = false;	// default value for addAlert
   	if (typeof(_id)==='undefined') _id = 0;

   	dialogPosition = $(window).scrollTop();

   	if(isEdit){

		for(i=0; i<row_array.length; ++i){
			if(row_array[i].id == Number(_id)) {
				objID = i;
			}
		}
   		// console.log(row_array[objID]);
   	}

    $('#dialog-alerts').dialog({
        modal: true,
        width: 590,
        height: 525,
        resizable: false,
        title: (isEdit) ? dic("Settings.ChangeAlert",lang) : dic("Settings.AddAlerts",lang) ,
        open: function() {
        	window.scrollTo(0,0);
        	var win = $(window);
            $(this).parent().css({   position:'absolute',
            	left: (win.width() - $(this).parent().outerWidth())/2,
            	top: (win.height() - $(this).parent().outerHeight())/2
            });

        	allowedSMSviaEmail = Number('<?php echo $allowedSMSvEmail; ?>');
   			if(allowedSMSviaEmail == 1) {
   				$('.SMSemail').show();
   			}

    	    $(function () {
		        $("#combobox").combobox();
		        if(isEdit) {
		        	$("#combobox").combobox('setval',$('#combobox option[value="'+ row_array[objID].poiid +'"]').text());
		        	$("select#combobox").val(row_array[objID].poiid);
		    	}
		        $("#toggle").click(function () {
		            $("#combobox").toggle();
		        });
		    });
		    $(function () {
		        $("#comboboxVlez").combobox();
		        if(isEdit) {
		        	$("#comboboxVlez").combobox('setval',$('#comboboxVlez option[value="'+ row_array[objID].poiid +'"]').text());
		        	$("select#comboboxVlez").val(row_array[objID].poiid);
		        }
		        $("#toggle").click(function () {
		            $("#comboboxVlez").toggle();
		        });
		    });
		    $(function () {
		        $("#comboboxIzlez").combobox();
		        if(isEdit) {
		        	$("#comboboxIzlez").combobox('setval',$('#comboboxIzlez option[value="'+ row_array[objID].poiid +'"]').text());
		        	$("select#comboboxIzlez").val(row_array[objID].poiid);
		        }
		        $("#toggle").click(function () {
		            $("#comboboxIzlez").toggle();
		        });
		    });
  			if(isEdit) {

  				$("#TipNaAlarm option[value="+row_array[objID].alarmtypeid+"]").attr('selected','selected');
		    	$('#TipNaAlarm').attr('disabled', 'disabled');
		    	OptionsChangeAlarmType();
		    	$('#brzinata').val(Math.round(row_array[objID].speed * Number('<?php echo $value ?>')));
		    	$('#vreme').val(row_array[objID].timeofpoi);

		    	$("#oEdinica option[value="+row_array[objID].settings+"]").attr('selected','selected');

		    	if(row_array[objID].remindme !== null){

		    		if(row_array[objID].remindme.indexOf(";") != -1){ // ako ima ";"
		    			var gservice = row_array[objID].remindme.split(";");
		    			$("#fmvalueDays").val(gservice[0].split(" ")[0]);
		    			var fmvaluemetric = gservice[1].trim().split(" ")[0];
		    			$('#fmvalueKm').val(Math.round(fmvaluemetric * Number('<?php echo $value ?>')));
		    			$('#remindDays').attr('checked',true);
		    			$('#remindKm').attr('checked',true);
		    		} else {
		    			if(row_array[objID].remindme.indexOf("days") != -1) { // ima samo denovi
		    				$("#fmvalueDays").val(row_array[objID].remindme.split(" ")[0]);
		    				$('#remindDays').attr('checked',true);
		    			}
		    			if(row_array[objID].remindme.indexOf("Km") != -1) { // ima samo Km
		    				var fmvaluemetric2 = row_array[objID].remindme.split(" ")[0];
		    				$('#fmvalueKm').val(Math.round(fmvaluemetric2 * Number('<?php echo $value ?>')));
							$('#remindKm').attr('checked',true);
							$('#remindDays').attr('checked',false);
							$("#fmvalueDays").val("");
		    			}
		    		}
		    	}

		    	$('#emails').val(row_array[objID].emails);

		    	// ako e dozvolena ovaa opcija
		    	if(allowedSMSviaEmail == 1 && row_array[objID].smsviaemail != null && row_array[objID].smsviaemail != "") {
		    		$('#smsviaemail').val(row_array[objID].smsviaemail);
		    	}

		    	$('#GFcheck' + row_array[objID].available).attr('checked',true);
		    	$('input:radio[name=radio]').button('refresh');
  			}

  			else {	// ako ne e edit (dodavanje / specificno dodavanje)
  				if(!isEdit && args == 2) {

  					// console.log("arguments : "+isEdit+"-"+_id);
  					$("#TipNaAlarm option[value="+_id+"]").attr('selected','selected');
			    	$('#TipNaAlarm').attr('disabled', 'disabled');

			    	OptionsChangeAlarmType();
			    	$("#fmvalueDays").val(5);

  				} else ClearDialog();	// se povukuva za da se iscisti od prethodno ako ne e povikano window.reload
   			}
        },
        close: function() {
        	$("#combobox").combobox('destroy');
        	$("#comboboxVlez").combobox('destroy');
        	$("#comboboxIzlez").combobox('destroy');
        	ClearDialog();
        	// console.log("destroyed...");
			window.scrollTo(0,dialogPosition);
        },
        buttons: [{
            text: (isEdit) ? dic('Fm.Mod', lang) : dic('Settings.Add', lang),
            click: function(data) {

                var tipNaAlarm = $('#TipNaAlarm').val();
                var email = $.map($('#emails').val().split(","), $.trim);	//clear the whitespaces in between
                var sms = '';
                if (Number('<?php echo $clienttypeid ?>') == 6) sms = $('#sms').val();
                var zvukot = $('#zvukot').val();
                var ImeNaTocka = $('#combobox').val();
                var ImeNaTockaProverka = document.getElementById('combobox').selectedIndex;
                var ImeNaZonaIzlez = $('#comboboxIzlez').val();
                var ImeNaZonaIzlezProverka = document.getElementById('comboboxIzlez').selectedIndex;
                var ImeNaZonaVlez = $('#comboboxVlez').val();
                var ImeNaZonaVlezProverka = document.getElementById('comboboxVlez').selectedIndex;
                var orgEdinica = '';
                var NadminataBrzina = convertMetric('<?php echo $metric ?>', $('#brzinata').val());
                var vreme = $('#vreme').val();
                var alarmSelect = document.getElementById('TipNaAlarm').selectedIndex;
                var voziloOdbrano = vehicleID;
                var dostapno = getCheckedRadio('radio');
                var valueDays = $('#fmvalueDays').val();
                var valueKm = convertMetric('<?php echo $metric ?>', $('#fmvalueKm').val());

                var smsviaemail = (allowedSMSviaEmail == 1) ? $('#smsviaemail').val(): "";

                //------------------------------------------------------------------------//
                ////////////////////////////////////////////////////////////////////////////


                var validation = [];

                if(email === '') validation.push("Settings.AlertsEmailHaveTo");
                if(email.length > 0 && !email_validate($('#emails').val())) validation.push("uncorrEmail");

                // validate sms via email multi
                if(allowedSMSviaEmail == 1 && smsviaemail !== "") {
                	if(!validate_smsvemails(smsviaemail,getMO)) validation.push("Settings.InvalidSMSEmailFormat");
                	if(!validate_smsvemails.check) validation.push("Settings.ValidMobileOperator");
                }

	 			if(tipNaAlarm == 7 && !isNormalInteger(Math.round(NadminataBrzina).toString())){
	 				validation.push("Settings.InsertSpeedOver");
	 			}
	 			if(tipNaAlarm == 8 && ImeNaZonaVlezProverka == ""){
	 				validation.push("Settings.SelectEnterGeoF");
	 			}
	 			if(tipNaAlarm === 9 && ImeNaZonaIzlezProverka == ""){
	 				validation.push("Settings.SelectExitGeoF");
				}
	 			if(tipNaAlarm == 10){
	 				if (ImeNaTockaProverka == "") validation.push("Settings.SelectPOI2");
	 				else {
		 				if(!isNum(vreme)) validation.push("Settings.InsertRetTime");
	 				}
	 			}
	 			if((tipNaAlarm == 17 || tipNaAlarm == 20) && !isNormalInteger(valueDays)){
	 				validation.push("Settings.InsertValidTime");
	 			}

	 			if(tipNaAlarm == 18) {
	 				if(isChecked("remindKm") === false && isChecked("remindDays") === false) validation.push("Settings.RemindMeMustOne");
	 				if(isChecked("remindDays") === true && !isNormalInteger(Math.round(valueDays).toString())) validation.push("Settings.InsertValidTime");
	 				if(isChecked("remindKm") === true && !isNormalInteger(Math.round(valueKm).toString())) validation.push("Settings.InsertValidLength");
	 			}

	 			//------------------------------[END] validation ------------------------------------//
                ///////////////////////////////////////////////////////////////////////////////////////

	 			console.log(validation);
	 			// console.log(validation.length);

				var remindme = '';
			  	if (tipNaAlarm == 17 || tipNaAlarm == 18 || tipNaAlarm == 20) {
			  		var fmvalueDays = "";

			  		if (tipNaAlarm == 18) {
			  			if ($('#remindDays').is(':checked')) {
			  				fmvalueDays = $('#fmvalueDays').val() + " days";
			  			}
			  		} else {
			  			if ($('#fmvalueDays').val() != "") {
				  			fmvalueDays = $('#fmvalueDays').val() + " days";
				  		}
			  		}

				  	var fmvalueKm = "";
				  	if ($('#rmdKm').css('display') != 'none') {
				  		if (tipNaAlarm == 18) {
				  			if ($('#remindKm').is(':checked')) {
				  				if (fmvalueDays != "")
				  					fmvalueKm += "; " + Math.round($('#fmvalueKm').val()/ Number('<?php echo $value?>')) + " Km";
				  				else
				  					fmvalueKm = Math.round($('#fmvalueKm').val()/ Number('<?php echo $value?>')) + " Km";
				  			}
				  		} else {
				  			if ($('#fmvalueKm').val() != "") {
					  			if (fmvalueKm != "")
					  				fmvalueKm += "; " + Math.round($('#fmvalueKm').val()/ Number('<?php echo $value?>')) + " Km";
					  			else
					  				fmvalueKm = Math.round($('#fmvalueKm').val()/ Number('<?php echo $value?>')) + " Km";
					  		}
				  		}
				  	}
			  		remindme = fmvalueDays + fmvalueKm;
			  	}

	 			// get and construct the sms via email format
	 			var sendSMS = '';
	 			validate_smsvemails($('#smsviaemail').val(),getMO);
	 			smsviaemail = validate_smsvemails.v;
	 			if(validation.length === 0 && allowedSMSviaEmail == 1 && smsviaemail != "") sendSMS = smsviaemail;
				// console.log("SEND SMS: " + sendSMS);

			  	var qurl = "storeAlert.php?tipNaAlarm=" + tipNaAlarm + "&email=" + email + "&sms=" + sms + "&zvukot=" + zvukot + "&ImeNaTocka=" + ImeNaTocka + "&ImeNaZonaIzlez=" + ImeNaZonaIzlez + "&ImeNaZonaVlez=" + ImeNaZonaVlez + "&NadminataBrzina=" + NadminataBrzina + "&vreme=" + vreme + "&dostapno=" + dostapno + "&orgEdinica=" + orgEdinica + "&odbraniVozila=1" + "&voziloOdbrano=" + voziloOdbrano + "&remindme=" + remindme + "&sendviaEmail=" + sendSMS;

			  	if(isEdit) {
			  		var uniqid = row_array[objID].uniqid;
			  		qurl += "&isEdit=true&uniqid=" + uniqid + "&id=" + _id;
			  	}

	 			if (validation.length === 0) {

			  		console.log(qurl);
		 			$.ajax({
		                    url: qurl,
		                    context: document.body,
		                    success: function(data) {
		                    	console.log(data);
		                    	var t;
		                    	if (isEdit) t = dic("Admin.SuccUpdate", lang);
		                    	else t = dic("Settings.SuccAdd", lang);	
		                    	t = t.substr(0,1).toUpperCase() + t.substr(1);

		                    	msgboxPetar(t);

		                        timed_refresh(1600);
		                    }
		                });
	 			} else {
	 				msgboxPetar(dic(validation[0],lang));
	 			}

             }
        }, {
            text: dic('cancel', lang),
            click: function() {
                $(this).dialog("close");
            }
        }
        ]
    });
}

function ClearDialog() {
	$("#TipNaAlarm option[value='1']").attr('selected','selected');
	OptionsChangeAlarmType();
	$('#TipNaAlarm').attr('disabled', false);
	$('#oEdinica option').attr('selected',false);
	$('#vreme').val("");
	$("#fmvalueDays").val("5");
	$("#fmvalueKm").val("");
	$('#emails').val("");
	$('#remindKm').attr('checked',false);
	$('#brzinata').val("");

	$("#smsviaemail").val("");

	$('#GFcheck1').attr('checked',true);
	$('input:radio[name=radio]').button('refresh');
}

function OptionsChangeAlarmType() {

	  	var tipNaAlarm = $('#TipNaAlarm').val();
		// console.log("tip na alarm: " + tipNaAlarm);

		document.getElementById('noteFmAlarm').style.display = "none";
   		document.getElementById('textFmAlarm').innerHTML = "";

	    if (tipNaAlarm == 10) {
	        document.getElementById('toi-div').style.display = '';
	        document.getElementById('toi-div-2').style.display = '';
	    }
	    if (tipNaAlarm == 9) {
	        document.getElementById('zi-div').style.display = '';
	    }
	    if (tipNaAlarm == 8) {
	        document.getElementById('zv-div').style.display = '';
	    }
	    if (tipNaAlarm == 7)  {
	        document.getElementById('nadminuvanjeBrzina').style.display = '';
	    }
		if (tipNaAlarm == 17 || tipNaAlarm == 18 || tipNaAlarm == 20) {
	        document.getElementById('fm').style.display = '';
	        document.getElementById('rmdD').style.display = '';

	        if (tipNaAlarm == 18) {
	        	document.getElementById('rmdKm').style.display = '';
	        	document.getElementById('remindDays').style.display = '';
	        } else {
	        	document.getElementById('rmdKm').style.display = 'none';
	        	document.getElementById('remindDays').style.display = 'none';
	        }
	        document.getElementById('noteFmAlarm').style.display="";
	        if (tipNaAlarm == 17) {
	       		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo1", lang);
	        }
	        if (tipNaAlarm == 18) {
	       		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo2", lang);
	        }
	        if (tipNaAlarm == 20) {
	       		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo3", lang);
	        }
   		}

	    if(tipNaAlarm != 10) {
	        document.getElementById('toi-div').style.display = 'none';
	        document.getElementById('toi-div-2').style.display = 'none';
	  	}
	  	if(tipNaAlarm != 09) {
	        document.getElementById('zi-div').style.display = 'none';
		}
		if(tipNaAlarm != 08) {
	        document.getElementById('zv-div').style.display = 'none';
		}
		if(tipNaAlarm != 07) {
	        document.getElementById('nadminuvanjeBrzina').style.display = 'none';
		}
		if(tipNaAlarm != 17 && tipNaAlarm != 18 && tipNaAlarm != 20) {
	        document.getElementById('fm').style.display = 'none';
	        document.getElementById('rmdKm').style.display = 'none';
		}

}

function DelAllowedDriver(i, id) {
	$('#div-del-allowed-driver').dialog({ modal: true, width: 350, height: 170, resizable: false,
	    buttons: 
	    [
	    {
	    	text:dic("Settings.Yes",lang),
		    click: function(){
	                $.ajax({
	                    url: "DelAllowedDriver.php?id="+id+ "&i=" + i,
	                    context: document.body,
	                    success: function(data){
	                    msgboxPetar(dic("Settings.DeleteAllowenceSuccess",lang));
	                    window.location.reload();
						}
	                });	
	                $( this ).dialog( "close" );
	               }
		    },
		    {
		    	text:dic("Settings.No",lang),
	        click: function() {
			    $( this ).dialog( "close" );
		    }
	   }
	   ]
	});

}

function modify() {

    var reg = document.getElementById("registration").value;
    var code = document.getElementById("code").value;
    if(reg == "")
    {
    	msgboxPetar(dic("Settings.MustReg"),lang);
    	return false;
    }
    if(code == "")
    {
    	msgboxPetar(dic("Settings.MustCode"),lang);
    	return false;
    }
    if(!(code % 1 === 0))
    {
    	msgboxPetar(dic("Settings.InvalidCode", lang)+"<br>"+dic("Settings.CodeMustNo", lang),lang);
    	return false;
    }
    var model = document.getElementById("model").value;
    var brand = document.getElementById("brand").value;
    var yearmanuf = document.getElementById("yearmanuf").value;

    var prekar = document.getElementById("aliasName").value;
    var chassis = document.getElementById("chassis").value;
    var motor = document.getElementById("motor").value;
    var fuelType = document.getElementById("fuelType").selectedIndex + 1;

    var capacity = document.getElementById("capacity").value.replace(",", "");
    var orgUnit = document.getElementById("orgUnit").value;
    var firstReg = formatdate13(document.getElementById("firstReg").value, '<?=$dateformat?>');
    var lastReg = formatdate13(document.getElementById("lastReg").value, '<?=$dateformat?>');
    var kmPerYear = document.getElementById("kmPerYear").value.replace(",", "");
    var sprTires = document.getElementById("sprTires").value.replace(",", ""); //sumTir
    var winTires = document.getElementById("winTires").value.replace(",", "");
    var nextService = document.getElementById("nextService").value.replace(",", "");
    if ('<?php echo $metric?>' == 'mi') {
		nextService = nextService * 1.609344498;
	}
    var nextServiceMonths = document.getElementById("nextServiceMonths").value.replace(",", "");

    var greenCard = $('input[name=greenCard]:radio:checked').val();
    var activity = $('input[name=activity]:radio:checked').val();
	var range = 0;

	if (document.getElementById("range"))
    	range = document.getElementById("range").value;

	if (nextService == "") {
		nextService = 10000;
	}
	if (nextServiceMonths == "") {
		nextServiceMonths = 12;
	}

   		top.ShowWait();
   		promeniOdometar(<?php echo $id ?>)
   		console.log("UpdateVehicle.php?reg=" + reg + "&code=" + code + "&model=" + model + "&range=" + range + "&chassis=" + chassis + "&motor=" + motor + "&fuelType=" + fuelType + "&capacity=" + capacity + "&orgUnit=" + orgUnit + "&firstReg=" + firstReg + "&lastReg=" + lastReg + "&kmPerYear=" + kmPerYear + "&sprTires=" + sprTires + "&winTires=" + winTires + "&nextService=" + nextService + "&nextServiceMonths=" + nextServiceMonths + "&greenCard=" + greenCard + "&id=" + <?php echo $id ?> + "&removed=" + allRemoved+ "&prekar=" + prekar+ "&activity=" + activity + "&brand=" + brand + "&yearmanuf=" + yearmanuf);
		$.ajax({
          url: "UpdateVehicle.php?reg=" + reg + "&code=" + code + "&model=" + model + "&range=" + range + "&chassis=" + chassis + "&motor=" + motor + "&fuelType=" + fuelType + "&capacity=" + capacity + "&orgUnit=" + orgUnit + "&firstReg=" + firstReg + "&lastReg=" + lastReg + "&kmPerYear=" + kmPerYear + "&sprTires=" + sprTires + "&winTires=" + winTires + "&nextService=" + nextService + "&nextServiceMonths=" + nextServiceMonths + "&greenCard=" + greenCard + "&id=" + <?php echo $id ?> + "&removed=" + allRemoved+ "&prekar=" + prekar+ "&activity=" + activity + "&brand=" + brand + "&yearmanuf=" + yearmanuf,
          context: document.body,
          success: function(data) {
          		if(data == 1)
                {
       				msgboxPetar(dic("Settings.VehicleAlreadyCode"),lang);
       				top.HideWait();
                }
                else
                {
                	top.document.getElementById('ifrm-cont').src = "Vehicles.php?l=" + '<?php echo $cLang ?>';   
                	//top.HideWait();
                }
          	}
    	});
  // }
}

function removeItem(i, id) {
     var element = document.getElementById("tr" + i);
     element.parentNode.removeChild(element);
     allRemoved += id + ";";
}

function cancel() {
    top.ShowWait();
    top.document.getElementById('ifrm-cont').src = "Vehicles.php?l=" + '<?php echo $cLang ?>';
}

function poglasno () {
	document.getElementById('potivko').disabled = false;
	document.getElementById('potivko').style.opacity = 1;

	if ((document.getElementById('demo').volume + 0.1) > 1) {
		document.getElementById('poglasno').disabled = true;
		document.getElementById('poglasno').style.opacity = 0.5;
		$("#poglasno").removeClass("ui-state-focus ui-state-hover")
	} else {
		document.getElementById('demo').volume += 0.1;
		document.getElementById('poglasno').disabled = false;
		document.getElementById('poglasno').style.opacity = 1;
	}
}
function potivko () {
	document.getElementById('poglasno').disabled = false;
	document.getElementById('poglasno').style.opacity = 1;

	if ((document.getElementById('demo').volume - 0.1) < 0) {
		document.getElementById('potivko').disabled = true;
		document.getElementById('potivko').style.opacity = 0.5;
		$("#potivko").removeClass("ui-state-focus ui-state-hover")
	} else {
		document.getElementById('demo').volume -= 0.1;
		document.getElementById('potivko').disabled = false;
		document.getElementById('potivko').style.opacity = 1;
	}
}

function setDates() {
    $('#firstReg').datepicker({
        dateFormat: '<?=$datejs?>',
        showOn: "button",
        buttonImage: "../images/cal1.png",
        buttonImageOnly: true,
        monthNames: [dic("Reports.January", lang), dic("Reports.February", lang), dic("Reports.March", lang), dic("Reports.April", lang), dic("Reports.May", lang), dic("Reports.June", lang), dic("Reports.July", lang), dic("Reports.August", lang), dic("Reports.September", lang), dic("Reports.October", lang), dic("Reports.November", lang), dic("Reports.December", lang)],
        monthNamesShort: [dic("Reports.January", lang), dic("Reports.February", lang), dic("Reports.March", lang), dic("Reports.April", lang), dic("Reports.May", lang), dic("Reports.June", lang), dic("Reports.July", lang), dic("Reports.August", lang), dic("Reports.September", lang), dic("Reports.October", lang), dic("Reports.November", lang), dic("Reports.December", lang)],
        dayNames: [dic("Reports.Sunday", lang), dic("Reports.Monday", lang), dic("Reports.Tuesday", lang), dic("Reports.Wednesday", lang), dic("Reports.Thursday", lang), dic("Reports.Friday", lang), dic("Reports.Saturday", lang)],
        dayNamesShort: [dic("Reports.Sunday", lang).substring(0, 2), dic("Reports.Monday", lang).substring(0, 2), dic("Reports.Tuesday", lang).substring(0, 2), dic("Reports.Wednesday", lang).substring(0, 2), dic("Reports.Thursday", lang).substring(0, 2), dic("Reports.Friday", lang).substring(0, 2), dic("Reports.Saturday", lang).substring(0, 2)],
        dayNamesMin: [dic("Reports.Sunday", lang).substring(0, 2), dic("Reports.Monday", lang).substring(0, 2), dic("Reports.Tuesday", lang).substring(0, 2), dic("Reports.Wednesday", lang).substring(0, 2), dic("Reports.Thursday", lang).substring(0, 2), dic("Reports.Friday", lang).substring(0, 2), dic("Reports.Saturday", lang).substring(0, 2)],
        hourGrid: 4,
        firstDay: 1,
        minuteGrid: 10
    });
    $('#lastReg').datepicker({
        dateFormat: '<?=$datejs?>',
        showOn: "button",
        buttonImage: "../images/cal1.png",
        buttonImageOnly: true,
        monthNames: [dic("Reports.January", lang), dic("Reports.February", lang), dic("Reports.March", lang), dic("Reports.April", lang), dic("Reports.May", lang), dic("Reports.June", lang), dic("Reports.July", lang), dic("Reports.August", lang), dic("Reports.September", lang), dic("Reports.October", lang), dic("Reports.November", lang), dic("Reports.December", lang)],
        monthNamesShort: [dic("Reports.January", lang), dic("Reports.February", lang), dic("Reports.March", lang), dic("Reports.April", lang), dic("Reports.May", lang), dic("Reports.June", lang), dic("Reports.July", lang), dic("Reports.August", lang), dic("Reports.September", lang), dic("Reports.October", lang), dic("Reports.November", lang), dic("Reports.December", lang)],
        dayNames: [dic("Reports.Sunday", lang), dic("Reports.Monday", lang), dic("Reports.Tuesday", lang), dic("Reports.Wednesday", lang), dic("Reports.Thursday", lang), dic("Reports.Friday", lang), dic("Reports.Saturday", lang)],
        dayNamesShort: [dic("Reports.Sunday", lang).substring(0, 2), dic("Reports.Monday", lang).substring(0, 2), dic("Reports.Tuesday", lang).substring(0, 2), dic("Reports.Wednesday", lang).substring(0, 2), dic("Reports.Thursday", lang).substring(0, 2), dic("Reports.Friday", lang).substring(0, 2), dic("Reports.Saturday", lang).substring(0, 2)],
        dayNamesMin: [dic("Reports.Sunday", lang).substring(0, 2), dic("Reports.Monday", lang).substring(0, 2), dic("Reports.Tuesday", lang).substring(0, 2), dic("Reports.Wednesday", lang).substring(0, 2), dic("Reports.Thursday", lang).substring(0, 2), dic("Reports.Friday", lang).substring(0, 2), dic("Reports.Saturday", lang).substring(0, 2)],
        hourGrid: 4,
        firstDay: 1,
        minuteGrid: 10
    });
    $('#startUse').datepicker({
        dateFormat: '<?=$datejs?>',
        showOn: "button",
        buttonImage: "../images/cal1.png",
        buttonImageOnly: true,
        monthNames: [dic("Reports.January", lang), dic("Reports.February", lang), dic("Reports.March", lang), dic("Reports.April", lang), dic("Reports.May", lang), dic("Reports.June", lang), dic("Reports.July", lang), dic("Reports.August", lang), dic("Reports.September", lang), dic("Reports.October", lang), dic("Reports.November", lang), dic("Reports.December", lang)],
        monthNamesShort: [dic("Reports.January", lang), dic("Reports.February", lang), dic("Reports.March", lang), dic("Reports.April", lang), dic("Reports.May", lang), dic("Reports.June", lang), dic("Reports.July", lang), dic("Reports.August", lang), dic("Reports.September", lang), dic("Reports.October", lang), dic("Reports.November", lang), dic("Reports.December", lang)],
        dayNames: [dic("Reports.Sunday", lang), dic("Reports.Monday", lang), dic("Reports.Tuesday", lang), dic("Reports.Wednesday", lang), dic("Reports.Thursday", lang), dic("Reports.Friday", lang), dic("Reports.Saturday", lang)],
        dayNamesShort: [dic("Reports.Sunday", lang).substring(0, 2), dic("Reports.Monday", lang).substring(0, 2), dic("Reports.Tuesday", lang).substring(0, 2), dic("Reports.Wednesday", lang).substring(0, 2), dic("Reports.Thursday", lang).substring(0, 2), dic("Reports.Friday", lang).substring(0, 2), dic("Reports.Saturday", lang).substring(0, 2)],
        dayNamesMin: [dic("Reports.Sunday", lang).substring(0, 2), dic("Reports.Monday", lang).substring(0, 2), dic("Reports.Tuesday", lang).substring(0, 2), dic("Reports.Wednesday", lang).substring(0, 2), dic("Reports.Thursday", lang).substring(0, 2), dic("Reports.Friday", lang).substring(0, 2), dic("Reports.Saturday", lang).substring(0, 2)],
        hourGrid: 4,
        firstDay: 1,
        minuteGrid: 10
    });
}

$(document).ready(function(){

document.getElementById("registration").focus();
document.getElementById('fuelType').selectedIndex = <?php echo $gorivo?>-1;

if (<?php echo $totalAlDr ?> == <?php echo $totalDr ?>) document.getElementById('addAllDri').disabled="disabled";
else document.getElementById('addAllDri').disabled="";


$('#mod1').button({ icons: { primary: "ui-icon-pencil"} })
$('#mod2').button({ icons: { primary: "ui-icon-pencil"} })
$('#ok').button({ icons: { primary: "ui-icon-check"} })
$('#addAllDri').button({ icons: { primary: "ui-icon-plusthick"} })
$('#add5').button({ icons: { primary: "ui-icon-plusthick"} })
$('#cancel1').button({ icons: { primary: "ui-icon-arrowreturnthick-1-w"} })
$('#cancel2').button({ icons: { primary: "ui-icon-arrowreturnthick-1-w"} })
$('#play').button({ icons: { primary: "ui-icon-play"} })
$('#pause').button({ icons: { primary: "ui-icon-pause"} })
$('#poglasno').button({ icons: { primary: "ui-icon-plus"} })
$('#potivko').button({ icons: { primary: "ui-icon-minus"} })
$('#gfAvail').buttonset();
$('#promeniOdometar').button({ icons: { primary: "ui-icon-pencil"} })

$('.del-btn').button({ icons: { primary: "ui-icon-trash"} });
$('.edit-btn').button({ icons: { primary: "ui-icon-pencil"} });
$('.btn-driver').button({ icons: { primary: "ui-icon-trash"} });


setDates();
top.HideWait();
SetHeightLite();
iPadSettingsLite();
livetracking = false;
var allowgarmin = '<?=$allowgarmin?>';
if(allowgarmin == '1')
IsConnected();

});

</script>

	<?php
		closedb();
	?>
</html>