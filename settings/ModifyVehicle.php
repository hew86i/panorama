﻿<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>


<?php 
	header("Content-type: text/html; charset=utf-8");
	$ua=getBrowser();
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
                	 var input = this.input = $("<input style='height:26px; padding-left: 5px; color: #2F5185'>")
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
					        if (Browser()!='iPad')
					        	$('.ui-autocomplete').css({ width: '340px' });
				        	else
				        		$('.ui-autocomplete').css({ width: '230px' });
					    },
					    select: function (event, ui) {
					        ui.item.option.selected = true;
					        self._trigger("selected", event, {
					            item: ui.item.option
					        });
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
                    if (Browser()!='iPad')
                    	input.autocomplete("widget")[0].style.width = '340px';
                	else
                		input.autocomplete("widget")[0].style.width = '230px';
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
					    	input.autocomplete("widget")[0].style.width = '340px';
				    	else
							input.autocomplete("widget")[0].style.width = '230px';
					    });
	            },
            	destroy: function () {
                this.input.remove();
                this.button.remove();
                this.element.show();
                $.Widget.prototype.destroy.call(this);
			  }
           });
    	})(jQuery);

        $(function () {
        $("#combobox").combobox();
        $("#toggle").click(function () {
            $("#combobox").toggle();
        });
    });
	</script>
	
	<script type="text/javascript">
    (function ($) {
        $.widget("ui.combobox", {
            _create: function () {
                     var self = this,
					 select = this.element.hide(),
					 selected = select.children(":selected"),
					 value = selected.val() ? selected.text() : "";
                	 var input = this.input = $("<input style='height:26px; padding-left: 5px; color: #2F5185'>")
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
					        if (Browser()!='iPad')
					        	$('.ui-autocomplete').css({ width: '340px' });
				        	else
				        		$('.ui-autocomplete').css({ width: '230px' });
					    },
					    select: function (event, ui) {
					        ui.item.option.selected = true;
					        self._trigger("selected", event, {
					            item: ui.item.option
					        });
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
                    if (Browser()!='iPad')
                    	input.autocomplete("widget")[0].style.width = '340px';
                	else
                		input.autocomplete("widget")[0].style.width = '230px';
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
					    	input.autocomplete("widget")[0].style.width = '340px';
				    	else
							input.autocomplete("widget")[0].style.width = '230px';
					    });
	            },
            	destroy: function () {
                this.input.remove();
                this.button.remove();
                this.element.show();
                $.Widget.prototype.destroy.call(this);
			  }
           });
    	})(jQuery);

        $(function () {
        $("#comboboxVlez").combobox();
        $("#toggle").click(function () {
            $("#comboboxVlez").toggle();
        });
    });
	</script>
	
	<script type="text/javascript">
    (function ($) {
        $.widget("ui.combobox", {
            _create: function () {
                     var self = this,
					 select = this.element.hide(),
					 selected = select.children(":selected"),
					 value = selected.val() ? selected.text() : "";
                	 var input = this.input = $("<input style='height:26px; padding-left: 5px; color: #2F5185'>")
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
					        if (Browser()!='iPad')
					        	$('.ui-autocomplete').css({ width: '340px' });
				        	else
				        		$('.ui-autocomplete').css({ width: '230px' });
					    },
					    select: function (event, ui) {
					        ui.item.option.selected = true;
					        self._trigger("selected", event, {
					            item: ui.item.option
					        });
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
                    if (Browser()!='iPad')
                    	input.autocomplete("widget")[0].style.width = '340px';
                	else
                		input.autocomplete("widget")[0].style.width = '230px';
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
					    	input.autocomplete("widget")[0].style.width = '340px';
				    	else
							input.autocomplete("widget")[0].style.width = '230px';
					    });
	            },
            	destroy: function () {
                this.input.remove();
                this.button.remove();
                this.element.show();
                $.Widget.prototype.destroy.call(this);
			  }
           });
    	})(jQuery);

        $(function () {
        $("#comboboxIzlez").combobox();
        $("#toggle").click(function () {
            $("#comboboxIzlez").toggle();
        });
    });
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
	  $allowedrfid = nnull(dlookup("select allowrfid from vehicles where id=" . $id), "0");
	  $allowgarmin = nnull(dlookup("select allowgarmin from vehicles where id=" . $id), "0");
	  $gsmnum = nnull(dlookup("select gsmnumber from vehicles where id=" . $id), "0");
	  $allowedcapace = dlookup("select count(*) from vehicleport where vehicleid=".$id." and porttypeid=17");
	  $allowFuel = nnull(dlookup("select allowfuel from vehicles where id=" . $id), "");
	  	
	  $metric = nnull(dlookup("select metric from users where id = " . session("user_id")), "1");	
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
	  
      $orgUnit = nnull(dlookup("select organisationid from vehicles where id=" . $id), "");
      $checkOrg = dlookup("select count(*) from organisation where id=" . $orgUnit);    

      $lastReg = nnull(DateTimeFormat(dlookup("select lastregistration from vehicles where id=" . $id), "d-m-Y"), "");
        
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
      $firstReg = DateTimeFormat(nnull(dlookup("select firstregistration from vehicles where id=" . $id), now()), "d-m-Y");

      $kmPerYear = nnull(dlookup("select kmperyear from vehicles where id=" . $id), "0"); //godisno dozvoleni km
      $springT = nnull(dlookup("select springtires from vehicles where id=" . $id), "30000"); //predvideni km za letni gumi
      $winterT = nnull(dlookup("select wintertires from vehicles where id=" . $id), "30000"); //predvideni km za zimski gumi
      $nextService= nnull(dlookup("select nextservice from vehicles where id=" . $id), "10000"); //na kolku km se vrsi servis
      if ($metric == 'mi') {
			$nextService = $nextService / 1.609344498;
		}
      $nextServiceMonths= nnull(dlookup("select nextservicemonths from vehicles where id=" . $id), "12"); //na kolku meseci se vrsi servis
      
      $gorivo = nnull(dlookup("select fueltypeid from vehicles where id=" . $id), "");
	  
	  //$clienttypeid = dlookup("select clienttypeid from clients where id = (select clientid from vehicles where id = " . $id . ")");
	  $range = 0;
	  if($clienttypeid == 4)
	  {
	  		$cntrange = dlookup("select count(*) from vehiclerange where vehicleid = " . $id);
	  		if($cntrange > 0)
	  			$range = dlookup("select range from vehiclerange where vehicleid = " . $id);
	  }
     // $cLang = getQUERY("lang");
	    
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
                      <td style=""><input type="text" id="registration" value="<?php echo $reg ?>"  size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/></td>
                      <td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?> <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?><?php } ;?>"><?php dic("Fm.FirstReg")?>:</td>
                      <td style="">
                             <input id="firstReg" type="text" class="textboxCalender1 text2" value="<?php echo $firstReg?>" />
                      </td>
                  </tr>
                  <tr>
                      <td style="font-weight:bold"><?php dic("Fm.Code")?>:</td>
                      <td style=""><input id="code" value="<?php echo $code ?>" type="text" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/></td>
                      <td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"><?php dic("Fm.LastReg") ?>:</td><td style="">
                            <input id="lastReg" type="text" class="textboxCalender1 text2" value="<?php echo $lastReg ?>" style = "z-index: 999"/>
                            <!--img src='../images/alarm1.png' width=16px height=16px style="opacity:0.7; position:relative; left:-14px; top:4px; cursor: pointer" title="Додади алерт за истекување на регистрација" onclick="addAlerts(26)"/-->
                      		<?php
                      		if ($allowedalarms == '1') {
                      		?>
                      		<span onclick="addAlerts(26)" title="<?= dic_("Settings.AlertRegTitle")?>" style="background-image: url('../images/icons.png'); background-position: -204px -50px; width: 16px; height: 16px; cursor: pointer; display: inline-block; position:relative; top:4px; left:-16px"></span>
                      		<?php
							}
                      		?>
                      </td>
                  </tr>
                  <tr>
                  <?php
                  $alias = query($aliasName);
                  $aliasot = pg_fetch_array($alias)
                  ?>
                     <td style="font-weight:bold;"><?php dic("Reports.Alias") ?></td>
                     <td style="">
                     <input id="aliasName" type="text" value="<?php echo $aliasot["alias"] ?>" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                     </td>
                     <td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"><?php dic("Fm.YearKm")?>:</td>
                     <td style="">
                            <input id="kmPerYear" type="text" value="<?php echo number_format($kmPerYear) ?>" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
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
                      <td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"><?php dic("Fm.SummTir")?>:</td>
                      <td style="">
                            <input id="sprTires" type="text" size="22" value="<?php echo number_format($springT) ?>" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                      </td>
                 </tr>
                 
                 <tr>
                   <td style="font-weight:bold"><?php dic("Fm.FuelType")?>:</td>
                      <td>
                            <select id="fuelType" style="width: 161px; font-size: 11px; position: relative; top: 0px; z-index: 999; " class="combobox text2">
                            <?php
                                $fuelTip = "select name from fueltypes";
                                $dsfuelTip = query($fuelTip);
								while ($drfuelTip = pg_fetch_array($dsfuelTip))
								{       
                                ?>
                                    <option><?php echo $drfuelTip["name"] ?></option>
                                <?php
                                }
                                ?>      
                       		</select>
                      </td>
                     
                      <td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"><?php dic("Fm.WinTir")?>:</td>
                      <td style="">
                            <input id="winTires" type="text" value = "<?php echo number_format($winterT) ?>" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                      </td>
                 </tr>
                 <tr>
                 	 <td style="font-weight:bold"><?php dic("Fm.OrgUnit")?>:</td>
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
                      		<span onclick="addAlerts(27)" title="<?= dic_("Settings.AlertServiceTitle")?>" style="background-image: url('../images/icons.png'); background-position: -204px -50px; width: 16px; height: 16px; cursor: pointer; display: inline-block; position:relative; top:4px; left:0px"></span>
                      		<?php
							}
                      		?>
                      </td>
                </tr>
                  <tr>
                  	<td style="font-weight:bold"><?php dic("Fm.Motor")?>:</td>
                      <td style="">
                            <input id="motor" type="text" value="<?php echo $motor ?>" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                      </td>
                      <td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"><?php echo dic("Settings.GreenCard")?>:</td>
                      <td style="">
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
                  <tr>
                  	  <td style="font-weight:bold;"><?php dic("Fm.FuelCap")?>:</td>
                      <td style="">
                            <input id="capacity" type="text" value="<?php echo $capacity ?>" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px;  border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px" />
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
                  	<td style="font-weight:bold"><?php dic("Fm.Sasija")?>:</td>
                      <td style="">
                            <input id="chassis" type="text" value="<?php echo $chassis ?>" size="22" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px"/>
                      </td>
                    	<td style="font-weight:bold; <?php if($yourbrowser == "1") {?> <?php }else{?>padding-left:30px<?php } ;?>"><?php dic("Reports.Odometer")?> (<?php echo $metric?>):</td>
	                      	<td style="min-width:341px; ">
	                      		<input type="text" id="odometarDatum1" style="opacity:0; color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px" value = ""></input>
	                     		<input id="odometarKm" type="text" value="" style="color: #2F5185; font-family: Arial,Helvetica,sans-serif; font-size: 11px; height:25px; border: 1px solid #CCCCCC; border-radius: 5px 5px 5px 5px; width:161px; padding-left:5px; position:relative; left:-179px">
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
                         <button id="btn<?php echo $cnt ?>" style="height:27px; margin-left:8px; margin-right:8px; width:30px" onclick="DelAllowedDriver(<?php echo $cnt ?>, <?php echo $drAd["id"] ?>)"></button>
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
        <tr><td colspan=6><div class="textTitle" style="font-size:16px;">Гармин комуникација</div><br><br></td></tr>
        <tr>
        	<td colspan=6 class="textTitle" style="font-size:16px;">
        		<table width="99%" height="99%" class="text2_" style="margin:5px; overflow: hidden;">
					<tr>
				    	<td height="90px">
							<font class="text2_" style="font-size:16px;">Предефинирани пораки</font><br><br><br>
							<input id="txtCanned" class="corner5" style="width: 233px; height: 28px; padding: 5px; margin-left: 8px; color: #2f5185; border: 1px solid #ccc;" type="text" value="" placeholder="Внесете предефинирана порака" />
							<button id="addquickmess" style="margin-left: 20px; cursor: pointer;" onclick="ShowWait(); ButtonAddCanned(<?=$id?>, '<?=$gsmnum?>', '0')"><?php dic("Settings.Add") ?></button><br>
							<input id="txtCannedToAll" type="checkbox" style="margin-left: 8px; color: #2f5185;" />&nbsp;За сите возила
							<br><br>
							<script>
				    			$('#addquickmess').button({ icons: { primary: "ui-icon-plusthick"} })
				    		</script>
						</td>
				    </tr>
				   	<tr>
				    	<td>
							<font class="text2_" style="font-size:16px;">Изберете возило за комуникација преку гармин</font><br><br><br>
							<select id="txtCannedReg" data-placeholder="" style="margin-right:5px; margin-left:8px; width: 235px; font-size: 11px; position: relative; top: 0px; z-index: 0; visibility: visible; background-color:white" class="combobox text2_">
								<option id="0" selected value="Изберете возило">Изберете возило</option>
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
						        	<td align = "left" width="10%" height="25px" align="center" class="text2_" style="padding-left:10px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;">Број на порака</td>
									<td align = "left" width="80%" height="25px" align="center" class="text2_" style="padding-left:10px; font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;">Порака</td>
									<!--td align = "center" width="8%" height="25px" align="center" class="text2_" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><font color = "#ff6633"><?php dic("Settings.Change")?></font></td--> 
									<td align = "center" width="10%" height="25px" align="center" class="text2_" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185;"><font color = "#ff6633"><?php dic("Tracking.Delete")?></font></td>
						        </tr>
						        <tbody id="predefmess">
					  			<?php
					  			if(pg_num_rows($quckmess) == 0)
								{
								?>
									<tr><td>
										<div id="noDataquickmess" style="padding: 40px; font-size:20px; font-style:italic;" class="text4">
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
									<!--td align = "center" height="30px" class="text2_" style="background-color:#fff; border:1px dotted #B8B8B8; ">
										<button id="btnEditQM<?= $row3["id"] ?>"  onclick="EditQuickMessClick('<?= $row3["body"]?>', <?= $row3["id"]?>, <?= $row3["messageid"]?>, '<?= $gsmnum?>')" style="height:25px; width:30px"></button>
									</td-->
									<td align="center" width="10%" height="30px" class="text2_" style="background-color:#fff; border:1px dotted #B8B8B8; ">
										<button id="DelBtnQM<?= $row3["id"] ?>"  onclick="DeleteQuickmessClick(<?= $row3["messageid"]?>, '<?= $gsmnum?>')" style="height:25px; width:30px"></button>
									</td>
									 <script>
										//$('#btnEditQM' + '<?= $row3["id"] ?>').button({ icons: { primary: "ui-icon-pencil"} })
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
        
       
        
		<!-- OD OVDE POCNUVAAT ALERTITE !!! -->
			  
		<tr>
        	<td colspan=6 class="textTitle" style="font-size:16px;"><?php dic("Settings.Alerts") ?></td>
        </tr>
       
		<tr colspan=6>
        <td>
        	<button id="add5" style="margin-top:10px" onclick="addAlerts(1)"><?php dic("Settings.Add") ?></button>
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
	//zakomentirano na 29.08.2014 - poradi zabelska od polyesterday
        //$alerts = query("select * from alarms where clientid= " .session("client_id"). " and vehicleid = ".$id." order by id");
	$alerts = query("select * from alarms where clientid= " .session("client_id"). " and vehicleid = ".$id." and alarmtypeid <> 11 order by id");

		if(pg_num_rows($alerts)==0)
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
  
        <tr>	
		<?php
		while($row3 = pg_fetch_array($alerts))
 		{
 			$data[] = ($row3);
		}
		foreach ($data as $row3)
		{
		?>
		<tr>
		<td align = "left" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:10px">
			<?php 
		
				if ($row3["alarmtypeid"] == "1"){
					dic("Settings.AlarmPanic");
				}
				if ($row3["alarmtypeid"] == "2"){
					dic("Settings.AlarmAssistance");
				}
				if ($row3["alarmtypeid"] == "3"){
					dic("Settings.AlarmAcumulator");
				}
				if ($row3["alarmtypeid"] == "4"){
					dic("Settings.AlarmVehicle");
				}
				if ($row3["alarmtypeid"] == "5"){
					dic("Settings.AlarmFuelCap");
				}
				if ($row3["alarmtypeid"] == "6"){
					dic("Settings.AlarmSuddenBraking");
				}
				if ($row3["alarmtypeid"] == "7"){
					dic("Settings.AlarmSpeedExcess");
				}
				if ($row3["alarmtypeid"] == "8"){
					dic("Settings.AlarmEnterZone");
				}
				if ($row3["alarmtypeid"] == "9"){
					dic("Settings.AlarmLeaveZone");
				}
				if ($row3["alarmtypeid"] == "10"){
					dic("Settings.AlarmVisitPOI");
				}
				if ($row3["alarmtypeid"] == "11"){
					dic("Settings.30MinNoDataIgnON");
				}
				if ($row3["alarmtypeid"] == "37"){
					dic("Settings.Tow");
				}
				if ($row3["alarmtypeid"] == "38"){
					dic("Settings.WeakAcc");
				}
				if ($row3["alarmtypeid"] == "48"){
					dic("Settings.FallFuel");
				}
				if ($row3["alarmtypeid"] == "12"){
					dic("Settings.AlarmUnOrdered");
				}
				if ($row3["alarmtypeid"] == "13"){
					dic("Settings.AlarmStayMoreThanAllowed");
				}
				if ($row3["alarmtypeid"] == "14"){
					dic("Settings.AlarmStayOutOfLocation");
				}
				if ($row3["alarmtypeid"] == "15"){
					dic("Settings.AlarmLeaveRoute");
				}
				if ($row3["alarmtypeid"] == "16"){
					dic("Settings.AlarmPause");
				}
				if ($row3["alarmtypeid"] == "17"){
					if ($row3["remindme"] == "") {
						echo dic_("Settings.AlarmRegExpire");
					} else {
						$arr = explode(" ", $row3["remindme"]);
						if ($arr[1] == "days") $remindme = $arr[0] . " " . dic_("Reports.Days_");
						else {
							$remindme = round($arr[0] * $value,0) . " " . $metric;
						}
						echo dic_("Settings.AlarmRegExpire") . " (". $remindme ." " . dic_("Settings.Before") . ")";
					}
				}
				if ($row3["alarmtypeid"] == "18"){
					if ($row3["remindme"] == "") {
						echo dic_("Settings.AlarmService");
					} else {
						$arr = explode("; ", $row3["remindme"]);
						if(count($arr) == 1) {
							$arr1 = explode(" ", $arr[0]);
							if ($arr1[1] == "days") $remindme = $arr1[0] . " " . dic_("Reports.Days_");
							else $remindme = round($arr1[0] * $value,0) . " " . $metric;
							echo dic_("Settings.AlarmService") . " (". $remindme ." " . dic_("Settings.Before") . ")";
						} else {
							$arr1 = explode(" ", $arr[0]);
							if ($arr1[1] == "days") $remindme = $arr1[0] . " " . dic_("Reports.Days_");
							else $remindme = round($arr1[0] * $value,0) . " " . $metric;
							
							$arr2 = explode(" ", $arr[1]);
							if ($arr2[1] == "days") $remindme1 = $arr2[0] . " " . dic_("Reports.Days_");
							else $remindme1 = round($arr2[0] * $value,0) . " " . $metric;
							
							echo dic_("Settings.AlarmService") . " (". $remindme .", " . $remindme1 . " " . dic_("Settings.Before") . ")";
						}
						
						/*if ($arr[1] == "days") $remindme = $arr[0] . " " . dic_("Reports.Days_");
						else {
							$remindme = round($arr[0] * $value,0) . " " . $metric;
						}
						echo dic_("Settings.AlarmService") . " (". $remindme ." " . dic_("Settings.Before") . ")";*/
					}
					
				}
				/*if ($row3["alarmtypeid"] == "19"){
					if ($row3["remindme"] == "") {
						echo dic_("Settings.AlarmGreenCard");
					} else {
						$arr = explode(" ", $row3["remindme"]);
						if ($arr[1] == "days") $remindme = $arr[0] . " " . dic_("Reports.Days_");
						else {
							$remindme = round($arr[0] * $value,0) . " " . $metric;
						}
						echo dic_("Settings.AlarmGreenCard") . " (". $remindme ." " . dic_("Settings.Before") . ")";
					}
				}*/
				if ($row3["alarmtypeid"] == "20"){
					if ($row3["remindme"] == "") {
						echo dic_("Settings.AlarmPolnomLicense");
					} else {
						$arr = explode(" ", $row3["remindme"]);
						if ($arr[1] == "days") $remindme = $arr[0] . " " . dic_("Reports.Days_");
						else {
							$remindme = round($arr[0] * $value,0) . " " . $metric;
						}
						echo dic_("Settings.AlarmPolnomLicense") . " (". $remindme ." " . dic_("Settings.Before") . ")";
					}
				}
				if ($row3["alarmtypeid"] == "21"){
					dic("Settings.AlarmAgreement");
				}
				if ($row3["alarmtypeid"] == "22"){
					dic("Settings.AlarmUnauthorizedUseVehicle");
				}
				if ($row3["alarmtypeid"] == "23"){
					dic("Settings.AlarmNoRFIDVehicle");
				}
				if ($row3["alarmtypeid"] == "24"){
					dic("Settings.AlarmDefect");
				}
				if ($row3["alarmtypeid"] == "25"){
					dic("acumulatorPowerSupplyInterruption");
				}
			
			?>
			
			<?php if ($row3["alarmtypeid"] == "7"){
					?>(<?php echo round($row3['speed']*$value,0);?> <?= $unitSpeed?>)<?php
				}
			?>
			<?php if ($row3["alarmtypeid"] == "10"){
					?>(<?php 
						
						$najdiIme = query("select * from pointsofinterest where id = ".$row3["poiid"]);
						$imeto = pg_fetch_result($najdiIme, 0, "name");
						echo $imeto;
					?>)<br>
			(<?php echo $row3['timeofpoi']; dic("Settings.minutes");?> )		
					
			<?php }?>	
			
			<?php if ($row3["alarmtypeid"] == "9" || $row3["alarmtypeid"] == "8"){
					?>(<?php 
						
						$najdiIme = query("select * from pointsofinterest where id = ".$row3["poiid"]);
						$imeto = pg_fetch_result($najdiIme, 0, "name");
						echo $imeto;
					
					?>)<?php }?>
				
		</td>
		<td align = "left" height="30px" class="text2" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8;">
			<?php 
			if($row3["emails"]!="")
			{
				echo $row3["emails"];
			}
			else
			{
			?> &nbsp;
			<?php
			}
			?>
		</td>
		<?php
		if ($clienttypeid == 6) {
			?>
			<td width="20%"  align = "left" height="30px" class="text2" style="padding-left:10px;background-color:#fff; border:1px dotted #B8B8B8;">
				<?= nnull($row3["sms"], "/")?>
			</td>	
			<?php
		}
		?>
		<!--td width="20%"  align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8;">
			<?php 
			if($row3["sms"]>0)
			{
				echo $row3["sms"];
			}
			else
			{
			?> &nbsp;
			<?php
			}
			?>
		</td-->  
		<td align = "left" cheight="30px" class="text2" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8; ">
			<?php echo dic_("Settings.Sound") . " " . $row3["soundid"]; ?>		
			<?php 
			$snoozeNajdi = query("select * from users where id=" . session("user_id") ."");
			$snoozot = pg_fetch_result($snoozeNajdi, 0, "snooze");
			
			if($snoozot==0)
			{
				echo dic("Settings.NoRepetition");
			}
			else 
			{
				?> 
			<?php
				echo "(" . $snoozot . " " . dic_("Reports.Minutes") . ")";
			}
			?>
			
		</td>
		<td align = "left" cheight="30px" class="text2" style="padding-left:10px; background-color:#fff; border:1px dotted #B8B8B8; ">
			<?php
			
			if($row3["available"] ==1)
			{
			?>
				<?php echo dic_("Settings.User")?>
			<?php
			}
			else if($row3["available"]==2)
			{
			?>
				<?php echo dic_("Reports.OrgUnit")?>
			<?php
			}
			else if($row3["available"]==3)
			{
			?>
				<?php echo dic_("Settings.Company")?>
			<?php
			}
			else {
				?>
				/
			<?php
			}
			?>
			
		</td>
		    
		<td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
			<button id="btnEditA<?php echo $cnt7?>"  onclick="EditAlertClick(<?php echo $row3["id"]?>)" style="height:25px; width:30px"></button>
		</td>
		<td align = "center" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; ">
			<button id="DelBtnA<?php echo $cnt7?>"  onclick="DeleteAlertClick(<?php echo $row3["id"]?>)" style="height:25px; width:30px"></button>
		</td>
		</tr>
		<?php
		$cnt7++;
		}
		}
		?>
        </table>
		
		
     <div id="div-del-allowed-driver" style="display:none" title="<?php dic("Settings.DeletingAllowedDriver") ?>">
      	<?php dic("Settings.DeletingAllowedDriverQuestion") ?>
     </div>
     <script>
     for (var k=0; k < <?php echo $cnt7 ?>; k++) {
		$('#btnEditA'+k).button({ icons: { primary: "ui-icon-pencil"} })
   		$('#DelBtnA' + k).button({ icons: { primary: "ui-icon-trash"} })
	 }
	 </script>
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
     <div id="div-add-alerts" style="display:none" title="<?php dic("Settings.AddAlerts") ?>">
     <div align = "center">
     <table cellpadding="3" width="100%" style="padding-top: 25px;">
     <tr>
     <td width = "27%" style="font-weight:bold" class ="text2" align="left"><?php dic("Settings.TypeOfAlert") ?>:</td>
     <td width = "73%">
     <select id = "TipNaAlarm" style="font-size: 11px; width:373px; position: relative; top: 0px ;visibility: visible;" onchange="OptionsChange()" class="combobox text2">
      		
      				<option disabled="disabled">----------------------<?php dic("Settings.CommonAlerts")?>----------------------</option>
   					<option value="01" selected="selected" <?php echo $t1?>><?php dic("Settings.AlarmPanic")?></option>
		            <option value="02" <?php echo $t2?>><?php dic("Settings.AlarmAssistance")?></option>
		            <option value="03" <?php echo $t3?>><?php dic("Settings.AlarmAcumulator")?></option>
		            <option value="25" <?php echo $t25?>><?php dic("acumulatorPowerSupplyInterruption")?></option>
		            <option value="24" <?php echo $t24?>><?php dic("Settings.AlarmDefect")?></option>
                    <option value="04" <?php echo $t4?>><?php dic("Settings.AlarmVehicle")?></option>
                    <option value="05" <?php if($allowedcapace==0){ ?>disabled="disabled" <?php }?> <?php echo $t5?>><?php dic("Settings.AlarmFuelCap")?></option>
                    <option value="48" <?php if($allowFuel==0){ ?>disabled="disabled" <?php }?>><?php dic("Settings.FallFuel")?></option>
                    <option value="06" <?php echo $t6?>><?php dic("Settings.AlarmSuddenBraking")?></option>
                    <option value="07" <?php echo $t7?>><?php dic("Settings.AlarmSpeedExcess")?></option>
                    <option value="08" <?php echo $t8?>><?php dic("Settings.AlarmEnterZone")?></option>
                    <option value="09" <?php echo $t9?>><?php dic("Settings.AlarmLeaveZone")?></option>
                    <option value="10" <?php echo $t10?>><?php dic("Settings.AlarmVisitPOI")?></option>
		    <!--display: none na 29.08.2014 - poradi zabelska od polyesterday-->
                    <option value="11" <?php echo $t11?> style="display:none"><?php dic("Settings.30MinNoDataIgnON")?></option>
                    <option value="26" style="display: none"><?php dic("prednaleva")?></option>
                    <option value="27" style="display: none"><?php dic("prednadesna")?></option>
                    <option value="28" style="display: none"><?php dic("stranicnavrata")?></option>
                    <option value="29" style="display: none"><?php dic("zadnavrata")?></option>
                    <option value="30" style="display: none"><?php dic("stanatvozac")?></option>
                 	<option disabled="disabled">-----------------------------<?php dic("Settings.RoutesCombo")?>---------------------------</option>
		            <option value="12" <?php if($allowedrouting==0){ ?>disabled="disabled" <?php }?> <?php echo $t12?>><?php dic("Settings.AlarmUnOrdered")?></option>
		            <option value="13" <?php if($allowedrouting==0){ ?>disabled="disabled" <?php }?> <?php echo $t13?>><?php dic("Settings.AlarmStayMoreThanAllowed")?></option>
                    <option value="14" <?php if($allowedrouting==0){ ?>disabled="disabled" <?php }?> <?php echo $t14?>><?php dic("Settings.AlarmStayOutOfLocation")?></option>
                    <option value="15" <?php if($allowedrouting==0){ ?>disabled="disabled" <?php }?> <?php echo $t15?>><?php dic("Settings.AlarmLeaveRoute")?></option>
                    <option value="16" <?php if($allowedrouting==0){ ?>disabled="disabled" <?php }?> <?php echo $t16?>><?php dic("Settings.AlarmPause")?></option>
                    <option disabled="disabled">-----------------<?php dic("Main.FleetManagement")?>-----------------</option>
                    <option value="17" <?php if($allowedfm==0){ ?>disabled="disabled" <?php }?> <?php echo $t17?>><?php dic("Settings.AlarmRegExpire")?></option>
                    <option value="18" <?php if($allowedfm==0){ ?>disabled="disabled" <?php }?> <?php echo $t18?>><?php dic("Settings.AlarmService")?></option>
                    <!--option value="19" <?php if($allowedfm==0){ ?>disabled="disabled" <?php }?> <?php echo $t19?>><?php dic("Settings.AlarmGreenCard")?></option-->
                    <option value="20" <?php if($allowedfm==0){ ?>disabled="disabled" <?php }?> <?php echo $t20?>><?php dic("Settings.AlarmPolnomLicense")?></option>
		            <option disabled="disabled">-----------------------------RFID-----------------------------</option>
		            <option value="22" <?php if($allowedrfid==0){ ?>disabled="disabled" <?php }?> <?php echo $t22?>><?php dic("Settings.AlarmUnauthorizedUseVehicle")?></option> 
		            <option value="23" <?php if($allowedrfid==0){ ?>disabled="disabled" <?php }?> <?php echo $t23?>><?php dic("Settings.AlarmNoRFIDVehicle")?></option>
     				<option disabled="disabled">-------------------------<?php dic("Settings.MotoAlarms")?>-----------------------</option>
		            <option value="37" <?php if($clienttypeid!=6){ ?>disabled="disabled" <?php }?> <?php echo $t37?>><?php dic("Settings.Tow")?></option> 
		            <option value="38" <?php if($clienttypeid!=6){ ?>disabled="disabled" <?php }?> <?php echo $t38?>><?php dic("Settings.WeakAcc")?></option>
     </select>
     </td>
     </tr>
     <tr id="zonataTockata" style="display:none;">
     <td width = "27%" style="font-weight:bold" class ="text2" align="left">Избери точка:</td>
     <td width = "73%" style="font-weight:bold" class ="text2">
     <div class="ui-widget" style="height: 25px; width: 100%;">
     <select id="combobox" style="width: 370px;">
        <option value="">Select one...</option>
        <?php
        	$str1 = "";
			$str1 .= "select * from pointsofinterest where clientid=" . session("client_id") ." and type=1 and active = '1' ORDER BY name";
			$dsPP = query($str1);
            while($row = pg_fetch_array($dsPP)) {
       	    ?>
            <option value="<?php echo $row["id"] ?>"><?php echo $row["name"]?></option>
        	<?
            }
        ?>
     </select>
	 </div>
	 </td>
     </tr>
     <tr id="zonataTockata2" style="display:none;">
     <td style="font-weight:bold" class ="text2" width="27%" align="left"><?php dic("Routes.RetentionTime")?>:</td>
     <td style="font-weight:bold" class ="text2" width="73%">
     <input id = "vreme" class="textboxcalender corner5 text5" type="text" size="5"></input>&nbsp;<?php echo dic("Reports.Minutes")?></td>
     </tr>
     <tr id="zonaVlez" style="display:none;">
     <td width = "27%" style="font-weight:bold" class ="text2" align="left">Избери зона за влез:</td>
     <td width = "73%" style="font-weight:bold" class ="text2">
     <div class="ui-widget" style="height: 25px; width: 100%;">
     <select id="comboboxVlez" style="width: 370px">
        <option value="">Select one...</option>
        <?php
        	$str2 = "";
			$str2 .= "select * from pointsofinterest where clientid=" . session("client_id") ." and type=2 and active = '1' ORDER BY name";
			$dsPP2 = query($str2);
            while($row2 = pg_fetch_array($dsPP2)) {
        ?>
            <option value="<?php echo $row2["id"] ?>"><?php echo $row2["name"]?></option>
        <?
            }
        ?>
     </select>
	 </div>
	 </td>
     </tr>
     <tr id="zonaIzlez" style="display:none;">
     <td width = "27%" style="font-weight:bold" class ="text2" align="left">Избери зона за излез:</td>
     <td width = "73%" style="font-weight:bold" class ="text2">
     <div class="ui-widget" style="height: 25px; width: 100%;">
     <select id="comboboxIzlez" style="width: 370px">
        <option value="">Select one...</option>
        <?php
        	$str3 = "";
			$str3 .= "select * from pointsofinterest where clientid=" . session("client_id") ." and type=2 and active = '1' ORDER BY name";
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
     <td width = "27%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic("Reports.Speed")?>:</td>
     <td width = "73%" style="font-weight:bold" class ="text2"><input id = "brzinata" class="textboxcalender corner5 text5" type="text" size="10"></input>&nbsp;<?= $unitSpeed?></td>
     </tr>
    
    <?php
    if ($clienttypeid == 6) {
    	?>
    	<tr>
	     <td width = "27%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic_("Settings.SMS")?></td>
	     <td width = "73%" style="font-weight:bold" class ="text2"><input id = "sms" class="textboxcalender corner5 text5" type="text" style = "width:373px"></input></td>
	    </tr>
    	<?php
    }
    ?>
     <tr>
     <td width = "27%" valign="middle" style="font-weight:bold" class ="text2" align="left"><?php dic("Settings.Sound")?>:</td>
     <td width = "73%" valign="middle">
     <select id = "zvukot" style="font-size: 11px; position: relative; top: 0px ;visibility: visible; float:left" class="combobox text2">
     <option value = "1"><?php dic("Settings.Sound")?> 1</option>
     <!--
     <option value = "2"><?php dic("Settings.Sound")?> 2</option>
     <option value = "3"><?php dic("Settings.Sound")?> 3</option>
     <option value = "4"><?php dic("Settings.Sound")?> 4</option>
     <option value = "5"><?php dic("Settings.Sound")?> 5</option>
     -->
     </select>
     <audio id="demo" src="../tracking/sound/bells_alarm.ogg"></audio>
	 <button id="play" onclick="document.getElementById('demo').play()" title="<?= dic_("Settings.Play") ?>" style="width: 35px;height: 27px; position: relative; margin-left:10px"></button>
     <button id="pause" onclick="document.getElementById('demo').pause()" title="<?= dic_("Settings.Stop") ?>" style="width: 35px;height: 27px; position: relative;"></button>
     <button id="poglasno" onclick="poglasno()" title="<?= dic_("Settings.Louder") ?>" style="width: 35px;height: 27px; position: relative;"></button>
     <button id="potivko" onclick="potivko()" title="<?= dic_("Settings.Quieter") ?>" style="width: 35px;height: 27px; position: relative;"></button>
	 </td>
	 </tr>
	 <tr>
     <td width = "27%" style="font-weight:bold" class ="text2"  align="left"><?php dic("Settings.AvailableFor1")?>:</td>
     <td width = "73%" style="font-weight:bold" class ="text2"><div id="gfAvail" class="corner5">
        <input type="radio" id="GFcheck1" name="radio" checked="checked" /><label for="GFcheck1"><?php echo dic_("Settings.User")?></label>
        <input type="radio" id="GFcheck2" name="radio" /><label for="GFcheck2"><?php echo dic_("Reports.OrgUnit")?></label>
        <input type="radio" id="GFcheck3" name="radio" /><label for="GFcheck3"><?php echo dic_("Settings.Company")?></label>
     </div>
     </td>
     </tr>
     
     <tr id="fm" style="display:none;">
	     <td width = "27%" style="font-weight:bold" class ="text2"  align="left"><?= dic_("Settings.RemindMe")?> <?= dic_("Settings.Before")?>:</td>
	     <td width = "73%" style="" class ="text2">
	     	<span id="rmdD">
	     	 <input id="remindDays" type="checkbox" name="remindme" value="days" style="position: relative; top:4px; display:none" checked /> 
	     	 <input id = "fmvalueDays" class="textboxCalender corner5 text5" type="text" style="width:40px" value="5"> <?= dic_("Reports.Days_")?>
	     	</span>
	     	<span id="rmdKm" style="display: none"> 
	     	 <input id="remindKm" type="checkbox" name="remindme" value="Km" style="position: relative; top:4px; margin-left: 15px" /> 
	     	 <input id = "fmvalueKm" class="textboxCalender corner5 text5" type="text" style="width:40px" value="0"> <?= $metric?>
	     	</span> 	     	
	     	<!--input id = "fmvalue" class="textboxCalender corner5 text5" type="text" style="width:40px" value="0">
	     	<select id="remindfm" style="font-size: 11px; width:65px" class="combobox text2">
	     		<option value="days"><?= dic_("Reports.Days_")?></option>
	     		<option value="Km"><?= $metric?></option>
	     	</select-->
	     	<!--font style="font-weight: normal;"><?= dic_("Settings.Before")?></font-->
	     </td>
     </tr>
     
     <tr id="noteFmAlarm" style="display:none">
	     <td width = "27%"></td>	
	     <td id="textFmAlarm" width = "73%" class="text2" style="color:#ff0000; font-size: 10px"></td>
     </tr>
     
      <tr>
     <td width = "27%" style="font-weight:bold" class ="text2"  align="left"><?= dic_("Settings.Email")?>:</td>
     <td width = "73%" style="font-weight:bold" class ="text2"><input id = "emails" class="textboxcalender corner5 text5" type="text" style = "width:373px"></input></td>
     </tr>
     <tr>
     <td width = "27%"></td>	
     <td width = "73%" style="color:#ff0000; font-size: 10px" class ="text2"><?php echo dic_("Reports.SchNote")?>:</td>
     </tr>
   	 </table> 	
     </div>
     
   	 </div>
     <!-- OVDE ZAVRSUVAAT ALERTITE !!!-->
     <div id="div-del-alert" style="display:none" title="<?php echo dic("Settings.AlertDeleteQuestion")?>">
        <?php echo dic("Settings.DelAlert")?>
     </div>
     <div id="div-edit-alert" style="display:none" title="<?php dic("Settings.ChangeAlert")?>"></div>
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
	<div id="addCanned" title="Гармин комуникација" style="display:none">
		 <p>
			<div align="center" style="font-size:14px">
				Изберете возило за комуникација преку гармин
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
	</script>
	
	<script>
	function promeniOdometar(id){

	var odometarVrednost = $('#odometarKm').val().replace(/\,/g,'').replace(/\./g,'');
	if ('<?php echo $metric?>' == 'mi') {
		odometarVrednost = odometarVrednost * 1.609344498;
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
	</script>

<script>
	
	function OptionsChange() {

	document.getElementById('noteFmAlarm').style.display = "none";
    document.getElementById('textFmAlarm').innerHTML = "";
        
	var zonaTockata = document.getElementById('TipNaAlarm').selectedIndex;
    if (zonaTockata == "13")
    {
        document.getElementById('zonataTockata').style.display = '';
        document.getElementById('zonataTockata2').style.display = '';
        
    }
    if (zonaTockata == "12")
    {
        document.getElementById('zonaIzlez').style.display = '';
    }
    if (zonaTockata == "11")
    {
        document.getElementById('zonaVlez').style.display = '';
    }
    if (zonaTockata == "10")
    {
        document.getElementById('nadminuvanjeBrzina').style.display = '';
    } 
    if (zonaTockata == "27" || zonaTockata == "28" || zonaTockata == "29" || zonaTockata == "30")
    {
        document.getElementById('fm').style.display = '';
        document.getElementById('rmdD').style.display = '';
        
        if (zonaTockata == "28") {
        	document.getElementById('rmdKm').style.display = '';
        	document.getElementById('remindDays').style.display = '';
        } else {
        	document.getElementById('rmdKm').style.display = 'none';
        	document.getElementById('remindDays').style.display = 'none';
        }
        document.getElementById('noteFmAlarm').style.display="";
        if (zonaTockata == "27") {
       		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo1", lang);
        }
        if (zonaTockata == "28") {
       		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo2", lang);
        }
        if (zonaTockata == "29") {
       		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo3", lang);
        }
    } 
    if(zonaTockata != "13")
    {
        document.getElementById('zonataTockata').style.display = 'none';
        document.getElementById('zonataTockata2').style.display = 'none';
  	}
  	if(zonaTockata != "12")
    {
        document.getElementById('zonaIzlez').style.display = 'none';
	}
	if(zonaTockata != "11")
    {
        document.getElementById('zonaVlez').style.display = 'none';
	}
	if(zonaTockata != "10")
    {
        document.getElementById('nadminuvanjeBrzina').style.display = 'none';
	}
	if(zonaTockata != "27" && zonaTockata != "28" && zonaTockata != "29" && zonaTockata != "30")
    {
        document.getElementById('fm').style.display = 'none';
        document.getElementById('rmdKm').style.display = 'none';
	}
	}
	
	var vehicleid2 = "<?php echo $id?>";
	var tipNaAlarm = document.getElementById('TipNaAlarm').selectedIndex;
	
	
	function EditAlertClick(id){
    ShowWait()
    $.ajax({
	    url: "EditAlarm.php?id="+id+"&tipNaAlarm="+tipNaAlarm+"&l="+lang,
	    context: document.body,
	    success: function(data){
            HideWait()
            $('#div-edit-alert').html(data)
		    document.getElementById('div-edit-alert').title = dic("Settings.ChangeAlert")
		    document.getElementById('noteFmAlarm1').style.display = "none";
    		document.getElementById('textFmAlarm1').innerHTML = "";
    		
	        if (document.getElementById('TipNaAlarm2').selectedIndex == "27") {
	        	document.getElementById('noteFmAlarm1').style.display="";
	       		document.getElementById('textFmAlarm1').innerHTML = "* " + dic("Settings.FmAlarmInfo1", lang);
	        }
	        if (document.getElementById('TipNaAlarm2').selectedIndex == "28") {
	        	document.getElementById('noteFmAlarm1').style.display="";
	       		document.getElementById('textFmAlarm1').innerHTML = "* " + dic("Settings.FmAlarmInfo2", lang);
	        }
	        if (document.getElementById('TipNaAlarm2').selectedIndex == "29") {
	        	document.getElementById('noteFmAlarm1').style.display="";
	       		document.getElementById('textFmAlarm1').innerHTML = "* " + dic("Settings.FmAlarmInfo3", lang);
	        }
			var oldsms2 = $('#sms2').val();		        
            $('#div-edit-alert').dialog({ modal: true, width: 550, height: 450, resizable: false,
                 buttons: 
			        [
                    {
			        text: dic("Fm.Mod", lang),
                        click: function() {
			        	var tipNaAlarm2 = $('#TipNaAlarm2').val()
	                    var email2 = $('#emails2').val()
	                    var sms2 = '';//$('#sms2').val()
	                    if (<?= $clienttypeid?> == 6)
	                    	sms2 = $('#sms2').val();
	                 	                    
	                    var zvukot2 = $('#zvukot2').val()
	                    var vehicleid2 = "<?php echo $id?>";
                    	var ImeNaTocka2 = $('#zonaTocka2').val()
                    	var NadminataBrzina2 = $('#brzinata2').val()
                    	NadminataBrzina2 = Math.round(NadminataBrzina2/'<?php echo $value?>')
                    	var odbranataOpcija2 = document.getElementById('TipNaAlarm2').selectedIndex;
                    	if (odbranataOpcija2 == 28 && ($('#remindKm1').is(':checked') == false && $('#remindDays1').is(':checked') == false)) {
				  			msgboxPetar(dic("Settings.RemindMeMustOne",lang));
				  		} else {
                    	
                    	var remindme1 = '';
					  	if (odbranataOpcija2 == 27 || odbranataOpcija2 == 28 || odbranataOpcija2 == 29 || odbranataOpcija2 == 30) {
					  		var fmvalueDays1 = "";
					  		if ($('#remindDays1').is(':checked')) {
					  			fmvalueDays1 = $('#fmvalueDays1').val() + " days";
					  		}
					  						  		
						  	var fmvalueKm1 = "";
						  	if ($('#rmdKm1').css('display') != 'none') {
						  		if ($('#remindKm1').is(':checked')) {
						  			if (fmvalueDays1 != "")
						  				fmvalueKm1 += "; " + Math.round($('#fmvalueKm1').val()/ <?= $value?>) + " Km";
						  			else
						  				fmvalueKm1 = Math.round($('#fmvalueKm1').val()/ <?= $value?>) + " Km";	
						  		}
						  	}
					  		remindme1 = fmvalueDays1 + fmvalueKm1;
					  	}
							  					  					  	
                    	var vreme2 = $('#vreme2').val()
                    	
                    	var ImeNaTocka2 = $('#zonaTocka2').val()
                    	var ImeNaZonaIzlez2 = $('#zonataIzlezot').val()
                    	var ImeNaZonaVlez2 = $('#zonataVlezot').val()
                
                		var dostapno2 = '1';
					    if(document.getElementById("tipKorisnik1").checked == true){dostapno2='1'}
				    	if(document.getElementById("tipKorisnik2").checked == true){dostapno2='2'}
				    	if(document.getElementById("tipKorisnik3").checked == true){dostapno2='3'}
                    	
                    	
	                    
	                    function validacija2(){
						var emails2 = $('#emails2').val();
						var emailovi2 = emails2.split(",");
						var izlez2;
						emailovi2.forEach(function (mejl2) {
						var filter2 = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
						izlez2 = filter2.test(mejl2.trim());
						});
						return izlez2;
						}
	                    
	                    if(email2==''){
                        msgboxPetar(dic("Settings.AlertsEmailHaveTo",lang))
                            }else{
                            	if(email2.length>0 && !validacija2())
                          			{
									msgboxPetar(dic("uncorrEmail",lang))
									}
								else{
							 		if(odbranataOpcija2==13){
							 		if(vreme2==""){
							 			msgboxPetar(dic("Settings.InsertRetTime",lang))
							 		}
							 		else{
							 			if(sms2!="" && (oldsms2 != sms2)) {
						   		document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
						        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
					                  buttons: 
					                  [
					                  {
					                  text:dic("Reports.Confirm"),
									  click: function() {
									    	
									    	pass = encodeURIComponent($('#dodTipPraznik').val());
									    	tipPraznikID = document.getElementById("dodTipPraznik");
									    	if(pass=="")
									    	{
									    		msgboxPetar(dic("Settings.InsertPass",lang))
									    		tipPraznikID.focus();
									    	}
									    	else
					                        {   
					                            $.ajax({
							                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
							                        context: document.body,
							                        success: function(data){
							                        
							                        if(data==1)	
							                        {
							                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
							                        	 $.ajax({
	                              url: "UpAlert.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&vehicleid2="+vehicleid2+"&id="+id+"&ImeNaTocka2="+ImeNaTocka2+"&vreme2="+vreme2+"&dostapno2="+dostapno2+"&remindme="+remindme1,
	                              context: document.body,
	                              success: function(data){
	                              msgboxPetar(dic("Settings.SuccChanged",lang))
				    			  window.location.reload();
		                          }
	                             });	 
							                        }
							                        else
							                        {
							                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
							                        	exit;
							                        }
							                      }
							                    });	
							                   }
					                         }
									      },
									    {
									    	text:dic("Fm.Cancel",lang),
					                   		click: function() {
										    $( this ).dialog( "close" );
									    }
					               }
					              ]
					   		  })
					   		  return;
							} else {
								$.ajax({
	                              url: "UpAlert.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&vehicleid2="+vehicleid2+"&id="+id+"&ImeNaTocka2="+ImeNaTocka2+"&vreme2="+vreme2+"&dostapno2="+dostapno2+"&remindme="+remindme1,
	                              context: document.body,
	                              success: function(data){
	                              msgboxPetar(dic("Settings.SuccChanged",lang))
				    			  window.location.reload();
		                          }
	                             });
							}
                               	 
                             }
                             }else{
					 		 if(odbranataOpcija2==12){
					 		 	if(sms2!="" && (oldsms2 != sms2)) {
						   		document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
						        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
					                  buttons: 
					                  [
					                  {
					                  text:dic("Reports.Confirm"),
									  click: function() {
									    	
									    	pass = encodeURIComponent($('#dodTipPraznik').val());
									    	tipPraznikID = document.getElementById("dodTipPraznik");
									    	if(pass=="")
									    	{
									    		msgboxPetar(dic("Settings.InsertPass",lang))
									    		tipPraznikID.focus();
									    	}
									    	else
					                        {   
					                            $.ajax({
							                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
							                        context: document.body,
							                        success: function(data){
							                        
							                        if(data==1)	
							                        {
							                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
							                        	 $.ajax({
	                              url: "UpAlert.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&vehicleid2="+vehicleid2+"&id="+id+"&ImeNaZonaIzlez2="+ImeNaZonaIzlez2+"&dostapno2="+dostapno2+"&remindme="+remindme1,
	                              context: document.body,
	                              success: function(data){
	                              msgboxPetar(dic("Settings.SuccChanged",lang))
				    			  window.location.reload();
		                          }
	                            });	 
                             }
							                        else
							                        {
							                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
							                        	exit;
							                        }
							                      }
							                    });	
							                   }
					                         }
									      },
									    {
									    	text:dic("Fm.Cancel",lang),
					                   		click: function() {
										    $( this ).dialog( "close" );
									    }
					               }
					              ]
					   		  })
					   		  return;
							} else {
								$.ajax({
	                              url: "UpAlert.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&vehicleid2="+vehicleid2+"&id="+id+"&ImeNaZonaIzlez2="+ImeNaZonaIzlez2+"&dostapno2="+dostapno2+"&remindme="+remindme1,
	                              context: document.body,
	                              success: function(data){
	                              msgboxPetar(dic("Settings.SuccChanged",lang))
				    			  window.location.reload();
		                          }
	                            });
							}
					 				 
                             }
                             else{
					 		 if(odbranataOpcija2==11){
					 			if(sms2!="" && (oldsms2 != sms2)) {
						   		document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
						        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
					                  buttons: 
					                  [
					                  {
					                  text:dic("Reports.Confirm"),
									  click: function() {
									    	
									    	pass = encodeURIComponent($('#dodTipPraznik').val());
									    	tipPraznikID = document.getElementById("dodTipPraznik");
									    	if(pass=="")
									    	{
									    		msgboxPetar(dic("Settings.InsertPass",lang))
									    		tipPraznikID.focus();
									    	}
									    	else
					                        {   
					                            $.ajax({
							                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
							                        context: document.body,
							                        success: function(data){
							                        
							                        if(data==1)	
							                        {
							                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
							                        	 $.ajax({
	                              url: "UpAlert.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&vehicleid2="+vehicleid2+"&id="+id+"&ImeNaZonaVlez2="+ImeNaZonaVlez2+"&dostapno2="+dostapno2+"&remindme="+remindme1,
	                              context: document.body,
	                              success: function(data){
	                              msgboxPetar(dic("Settings.SuccChanged",lang))
				    			  window.location.reload();
		                          }
	                            });	 
							                        }
							                        else
							                        {
							                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
							                        	exit;
							                        }
							                      }
							                    });	
							                   }
					                         }
									      },
									    {
									    	text:dic("Fm.Cancel",lang),
					                   		click: function() {
										    $( this ).dialog( "close" );
									    }
					               }
					              ]
					   		  })
					   		  return;
							} else {
								$.ajax({
	                              url: "UpAlert.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&vehicleid2="+vehicleid2+"&id="+id+"&ImeNaZonaVlez2="+ImeNaZonaVlez2+"&dostapno2="+dostapno2+"&remindme="+remindme1,
	                              context: document.body,
	                              success: function(data){
	                              msgboxPetar(dic("Settings.SuccChanged",lang))
				    			  window.location.reload();
		                          }
	                            });	 
							}
                             }else  
					 		 {
							 if(odbranataOpcija2==10){
							 if(NadminataBrzina2==""){
							 		msgboxPetar(dic("Settings.InsertSpeedOver",lang))
							 }
							 else{
							 	if(sms2!="" && (oldsms2 != sms2)) {
						   		document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
						        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
					                  buttons: 
					                  [
					                  {
					                  text:dic("Reports.Confirm"),
									  click: function() {
									    	
									    	pass = encodeURIComponent($('#dodTipPraznik').val());
									    	tipPraznikID = document.getElementById("dodTipPraznik");
									    	if(pass=="")
									    	{
									    		msgboxPetar(dic("Settings.InsertPass",lang))
									    		tipPraznikID.focus();
									    	}
									    	else
					                        {   
					                            $.ajax({
							                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
							                        context: document.body,
							                        success: function(data){
							                        
							                        if(data==1)	
							                        {
							                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
							                        	 $.ajax({
	                              url: "UpAlert.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&vehicleid2="+vehicleid2+"&id="+id+"&NadminataBrzina2="+NadminataBrzina2+"&dostapno2="+dostapno2+"&remindme="+remindme1,
	                              context: document.body,
	                              success: function(data){
	                              msgboxPetar(dic("Settings.SuccChanged",lang))
				    			  window.location.reload();
		                          }
	                             });	
                               }
							                        else
							                        {
							                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
							                        	exit;
							                        }
							                      }
							                    });	
							                   }
					                         }
									      },
									    {
									    	text:dic("Fm.Cancel",lang),
					                   		click: function() {
										    $( this ).dialog( "close" );
									    }
					               }
					              ]
					   		  })
					   		  return;
							} else {
								$.ajax({
	                              url: "UpAlert.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&vehicleid2="+vehicleid2+"&id="+id+"&NadminataBrzina2="+NadminataBrzina2+"&dostapno2="+dostapno2+"&remindme="+remindme1,
	                              context: document.body,
	                              success: function(data){
	                              msgboxPetar(dic("Settings.SuccChanged",lang))
				    			  window.location.reload();
		                          }
	                             });	
							}
                             
                               }
                             }else{
                             	if(sms2!="" && (oldsms2 != sms2)) {
						   		document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
						        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
					                  buttons: 
					                  [
					                  {
					                  text:dic("Reports.Confirm"),
									  click: function() {
									    	
									    	pass = encodeURIComponent($('#dodTipPraznik').val());
									    	tipPraznikID = document.getElementById("dodTipPraznik");
									    	if(pass=="")
									    	{
									    		msgboxPetar(dic("Settings.InsertPass",lang))
									    		tipPraznikID.focus();
									    	}
									    	else
					                        {   
					                            $.ajax({
							                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
							                        context: document.body,
							                        success: function(data){
							                        
							                        if(data==1)	
							                        {
							                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
							                        	$.ajax({
	                         url: "UpAlert.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&vehicleid2="+vehicleid2+"&id="+id+"&dostapno2="+dostapno2+"&remindme="+remindme1,
	                         context: document.body,
	                         success: function(data){
	                         msgboxPetar(dic("Settings.SuccChanged",lang))
		                     window.location.reload();
					    	         }
	                                });
							                        }
							                        else
							                        {
							                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
							                        	exit;
							                        }
							                      }
							                    });	
							                   }
					                         }
									      },
									    {
									    	text:dic("Fm.Cancel",lang),
					                   		click: function() {
										    $( this ).dialog( "close" );
									    }
					               }
					              ]
					   		  })
					   		  return;
                             }else{
                		     $.ajax({
	                         url: "UpAlert.php?tipNaAlarm2="+tipNaAlarm2+"&email2="+email2+"&sms2="+sms2+"&zvukot2="+zvukot2+"&vehicleid2="+vehicleid2+"&id="+id+"&dostapno2="+dostapno2+"&remindme="+remindme1,
	                         context: document.body,
	                         success: function(data){
	                         msgboxPetar(dic("Settings.SuccChanged",lang))
		                     window.location.reload();
					    	         }
	                                });
							}
	                               }
    	                          }
    	                         }
    	                        }
    	                       }
                              }
                            }
                           }
                          },
                    	{
                    text: dic("Fm.Cancel", lang),
                         click: function() {
				        $( this ).dialog( "close" );
			            }
                      }
                    ] 
                  })
                }      
              });
			}
	function DeleteAlertClick(id) {
          document.getElementById('div-del-alert').title = dic("Settings.AlertDeleteQuestion")
		  $('#div-del-alert').dialog({ modal: true, width: 350, height: 170, resizable: false,
                buttons: 
                [
                {
                	text:dic("Settings.Yes",lang),
				    click: function() {
                            $.ajax({
		                        url: "DelAlerts.php?id="+ id ,
		                        context: document.body,
		                        success: function(data){
		                        msgboxPetar(dic("Settings.SuccDeleted",lang))
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
    </script>
    
    <script>      
   
    function addAlerts(_id) {
    	document.getElementById('noteFmAlarm').style.display = "none";
    	document.getElementById('textFmAlarm').innerHTML = "";
    	
 	document.getElementById('div-add-alerts').title = dic("Settings.AddAlerts")	

 	document.getElementById('TipNaAlarm').selectedIndex = _id;

 	if(_id == 27 || _id == 28) {
 		document.getElementById('fm').style.display = '';
 		document.getElementById('rmdD').style.display = '';
 		if (_id == 28) {
 			document.getElementById('remindDays').style.display = '';
 		} else {
 			document.getElementById('remindDays').style.display = 'none';
 		}
 	} else {
 		document.getElementById('fm').style.display = 'none';
 		document.getElementById('rmdD').style.display = 'none';
 		document.getElementById('remindDays').style.display = 'none';
 	}
 	
 	if (_id == 28) {
 		document.getElementById('rmdKm').style.display = '';
 	} else {
 		document.getElementById('rmdKm').style.display = 'none';
 	}
 	
 	 if (_id == "27") {
 	 	document.getElementById('noteFmAlarm').style.display = "";
   		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo1", lang);
    }
    if (_id == "28") {
    	document.getElementById('noteFmAlarm').style.display = "";
   		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo2", lang);
    }
    if (_id == "29") {
    	document.getElementById('noteFmAlarm').style.display = "";
   		document.getElementById('textFmAlarm').innerHTML = "* " + dic("Settings.FmAlarmInfo3", lang);
    }
        
 	$('#div-add-alerts').dialog({ modal: true, width: 550, height: 450, resizable: false,
            buttons: 
            [
            {
             	text: dic('Settings.Add',lang),
				click: function(data) {
					
                    var tipNaAlarm = $('#TipNaAlarm').val()
                    var email = $('#emails').val()
                    var sms = '';//$('#sms').val()
                    if (<?=$clienttypeid?> == 6)
                    	sms = $('#sms').val();
                    var zvukot = $('#zvukot').val()
                    var vehicleid = "<?php echo $id?>";
                    var ImeNaTocka = $('#combobox').val()
                    var ImeNaZonaIzlez = $('#comboboxIzlez').val()
                    var ImeNaZonaVlez = $('#comboboxVlez').val()
                    var NadminataBrzina = $('#brzinata').val()
                    NadminataBrzina = Math.round(NadminataBrzina/'<?php echo $value?>')
                    var vreme = $('#vreme').val()
                    var odbranataOpcija = document.getElementById('TipNaAlarm').selectedIndex;
                    var dostapno = '1'
				    if(document.getElementById("GFcheck1").checked == true){dostapno='1'}
				    if(document.getElementById("GFcheck2").checked == true){dostapno='2'}
				    if(document.getElementById("GFcheck3").checked == true){dostapno='3'}
				  	
				  	if (odbranataOpcija == 28 && ($('#remindKm').is(':checked') == false && $('#remindDays').is(':checked') == false)) {
				  		msgboxPetar(dic("Settings.RemindMeMustOne",lang));
				  	} else {			  	
					  	var remindme = '';
					  	if (odbranataOpcija == 27 || odbranataOpcija == 28 || odbranataOpcija == 29 || odbranataOpcija == 30) {
					  		var fmvalueDays = "";
					  		
					  		if (odbranataOpcija == 28) {
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
						  		if (odbranataOpcija == 28) {
						  			if ($('#remindKm').is(':checked')) {	
						  				if (fmvalueKm != "")
						  					fmvalueKm += "; " + Math.round($('#fmvalueKm').val()/ <?= $value?>) + " Km";
						  				else
						  					fmvalueKm = Math.round($('#fmvalueKm').val()/ <?= $value?>) + " Km";
						  			}
						  		} else {
						  			if ($('#fmvalueKm').val() != "") {
							  			if (fmvalueKm != "")
							  				fmvalueKm += "; " + Math.round($('#fmvalueKm').val()/ <?= $value?>) + " Km";
							  			else
							  				fmvalueKm = Math.round($('#fmvalueKm').val()/ <?= $value?>) + " Km";
							  		}
						  		}							  		
						  	}
					  		remindme = fmvalueDays + fmvalueKm;
					  	}
					  					                     
						function validacija(){
						var emails = $('#emails').val();
						var emailovi = emails.split(",");
						var izlez;
						emailovi.forEach(function (mejl) {
						var filter = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
						izlez = filter.test(mejl.trim());
						});
						return izlez;
						}
											
	                    if(email==''){
	                        msgboxPetar(dic("Settings.AlertsEmailHaveTo",lang))
	                        }else{
	                   
	                          	 if(email.length>0 && !validacija())
	                          	 {
								 msgboxPetar(dic("uncorrEmail",lang))
								 }
								 	else{
								 		if(odbranataOpcija==13){
								 		
								 		if(vreme==""){
								 			msgboxPetar(dic("Settings.InsertRetTime",lang))
								 		}
								 		//
								 		if(sms!="")
		                          	 {
									   	document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
									        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
									                  buttons: 
									                  [
									                  {
									                  text:dic("Reports.Confirm"),
													  click: function() {
													    	
													    	pass = encodeURIComponent($('#dodTipPraznik').val());
													    	tipPraznikID = document.getElementById("dodTipPraznik");
													    	if(pass=="")
													    	{
													    		msgboxPetar(dic("Settings.InsertPass",lang))
													    		tipPraznikID.focus();
													    	}
													    	else
									                        {   
									                            $.ajax({
											                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
											                        context: document.body,
											                        success: function(data){
											                        if(data==1)	
											                        {
											                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
											                             $.ajax({
											                              url: "AddAlert.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&vehicleid="+vehicleid+"&ImeNaTocka="+ImeNaTocka+"&vreme="+vreme+"&dostapno="+dostapno+"&remindme="+remindme,
											                              context: document.body,
											                              success: function(data){
											                              msgboxPetar(dic("Settings.SuccAdd",lang))
														    			  window.location.reload();
												                          }
											                              });	
																	}
											                        else
											                        {
											                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
											                        	exit;
											                        }
											                      }
											                    });	
											                   }
									                         }
													      },
													    {
													    	text:dic("Fm.Cancel",lang),
									                    click: function() {
														    $( this ).dialog( "close" );
													    }
									               }
									              ]
									   		  })
										}
								 		//
								 		else{
	                                    $.ajax({
				                              url: "AddAlert.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&vehicleid="+vehicleid+"&ImeNaTocka="+ImeNaTocka+"&vreme="+vreme+"&dostapno="+dostapno+"&remindme="+remindme,
				                              context: document.body,
				                              success: function(data){
				                              msgboxPetar(dic("Settings.SuccAdd",lang))
							    			  window.location.reload();
					                          }
				                              });	 
	                                    }
	                                    }else{
								 			if(odbranataOpcija==12){
								 				if(sms!="")
		                          	 {
									   	document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
									        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
									                  buttons: 
									                  [
									                  {
									                  text:dic("Reports.Confirm"),
													  click: function() {
													    	
													    	pass = encodeURIComponent($('#dodTipPraznik').val());
													    	tipPraznikID = document.getElementById("dodTipPraznik");
													    	if(pass=="")
													    	{
													    		msgboxPetar(dic("Settings.InsertPass",lang))
													    		tipPraznikID.focus();
													    	}
													    	else
									                        {   
									                            $.ajax({
											                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
											                        context: document.body,
											                        success: function(data){
											                        if(data==1)	
											                        {
											                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
											                            $.ajax({
				                              url: "AddAlert.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&vehicleid="+vehicleid+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&dostapno="+dostapno+"&remindme="+remindme,
				                              context: document.body,
				                              success: function(data){
				                              msgboxPetar(dic("Settings.SuccAdd",lang))
							    			  window.location.reload();
					                          }
				                              });	
																	}
											                        else
											                        {
											                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
											                        	exit;
											                        }
											                      }
											                    });	
											                   }
									                         }
													      },
													    {
													    	text:dic("Fm.Cancel",lang),
									                    click: function() {
														    $( this ).dialog( "close" );
													    }
									               }
									              ]
									   		  })
										} else {
	                                   		  $.ajax({
				                              url: "AddAlert.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&vehicleid="+vehicleid+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&dostapno="+dostapno+"&remindme="+remindme,
				                              context: document.body,
				                              success: function(data){
				                              msgboxPetar(dic("Settings.SuccAdd",lang))
							    			  window.location.reload();
					                          }
				                              });	
				                          }
	                                    }else{
								 			if(odbranataOpcija==11){	
								 				if(sms!="")
		                          	 {
									   	document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
									        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
									                  buttons: 
									                  [
									                  {
									                  text:dic("Reports.Confirm"),
													  click: function() {
													    	
													    	pass = encodeURIComponent($('#dodTipPraznik').val());
													    	tipPraznikID = document.getElementById("dodTipPraznik");
													    	if(pass=="")
													    	{
													    		msgboxPetar(dic("Settings.InsertPass",lang))
													    		tipPraznikID.focus();
													    	}
													    	else
									                        {   
									                            $.ajax({
											                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
											                        context: document.body,
											                        success: function(data){
											                        if(data==1)	
											                        {
											                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
											                           $.ajax({
										                              url: "AddAlert.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&vehicleid="+vehicleid+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&dostapno="+dostapno+"&remindme="+remindme,
										                              context: document.body,
										                              success: function(data){
										                              msgboxPetar(dic("Settings.SuccAdd",lang))
													    			  window.location.reload();
											                          }
										                              });			
																	}
											                        else
											                        {
											                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
											                        	exit;
											                        }
											                      }
											                    });	
											                   }
									                         }
													      },
													    {
													    	text:dic("Fm.Cancel",lang),
									                    click: function() {
														    $( this ).dialog( "close" );
													    }
									               }
									              ]
									   		  })
										} else {	
								 			  $.ajax({
				                              url: "AddAlert.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&vehicleid="+vehicleid+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&dostapno="+dostapno+"&remindme="+remindme,
				                              context: document.body,
				                              success: function(data){
				                              msgboxPetar(dic("Settings.SuccAdd",lang))
							    			  window.location.reload();
					                          }
				                              });	
				                             }
	                                    }
	                                    else{
								 			if(odbranataOpcija==10){
								 			if(NadminataBrzina==""){
								 			msgboxPetar(dic("Settings.InsertSpeedOver",lang))
								 			}
								 			if(sms!="")
		                          	 {
									   	document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
									        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
									                  buttons: 
									                  [
									                  {
									                  text:dic("Reports.Confirm"),
													  click: function() {
													    	
													    	pass = encodeURIComponent($('#dodTipPraznik').val());
													    	tipPraznikID = document.getElementById("dodTipPraznik");
													    	if(pass=="")
													    	{
													    		msgboxPetar(dic("Settings.InsertPass",lang))
													    		tipPraznikID.focus();
													    	}
													    	else
									                        {   
									                            $.ajax({
											                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
											                        context: document.body,
											                        success: function(data){
											                        if(data==1)	
											                        {
											                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
											                           $.ajax({
										                              url: "AddAlert.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&vehicleid="+vehicleid+"&NadminataBrzina="+NadminataBrzina+"&dostapno="+dostapno+"&remindme="+remindme,
										                              context: document.body,
										                              success: function(data){
										                              msgboxPetar(dic("Settings.SuccAdd",lang))
													    			  window.location.reload();
											                          }
										                              });		
																	}
											                        else
											                        {
											                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
											                        	exit;
											                        }
											                      }
											                    });	
											                   }
									                         }
													      },
													    {
													    	text:dic("Fm.Cancel",lang),
									                    click: function() {
														    $( this ).dialog( "close" );
													    }
									               }
									              ]
									   		  })
								 			}
								 			else{	
								 			  $.ajax({
				                              url: "AddAlert.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&vehicleid="+vehicleid+"&NadminataBrzina="+NadminataBrzina+"&dostapno="+dostapno+"&remindme="+remindme,
				                              context: document.body,
				                              success: function(data){
				                              msgboxPetar(dic("Settings.SuccAdd",lang))
							    			  window.location.reload();
					                          }
				                              });	
	                                    }
	                                    }else{
	                                    	if(sms!="")
		                          	 {
									   	document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS",lang)
									        $('#div-tip-praznik').dialog({ modal: true, width: 300, height: 230, resizable: false,
									                  buttons: 
									                  [
									                  {
									                  text:dic("Reports.Confirm"),
													  click: function() {
													    	
													    	pass = encodeURIComponent($('#dodTipPraznik').val());
													    	tipPraznikID = document.getElementById("dodTipPraznik");
													    	if(pass=="")
													    	{
													    		msgboxPetar(dic("Settings.InsertPass",lang))
													    		tipPraznikID.focus();
													    	}
													    	else
									                        {   
									                            $.ajax({
											                        url: "checkPassword2.php?pass="+pass+"&l="+lang,
											                        context: document.body,
											                        success: function(data){
											                        if(data==1)	
											                        {
											                        	msgboxPetar(dic("Settings.VaildPassSucAlert",lang))
											                           $.ajax({
											                              url: "AddAlert.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&vehicleid="+vehicleid+"&dostapno="+dostapno+"&remindme="+remindme,
											                              context: document.body,
											                              success: function(data){
											                              msgboxPetar(dic("Settings.SuccAdd",lang))
														    			  window.location.reload();
												                          }
											                              });	
																	}
											                        else
											                        {
											                        	msgboxPetar(dic("Settings.Incorrectpass",lang))
											                        	exit;
											                        }
											                      }
											                    });	
											                   }
									                         }
													      },
													    {
													    	text:dic("Fm.Cancel",lang),
									                    click: function() {
														    $( this ).dialog( "close" );
													    }
									               }
									              ]
									   		  })
										} else {
	                                    	$.ajax({
				                              url: "AddAlert.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&vehicleid="+vehicleid+"&dostapno="+dostapno+"&remindme="+remindme,
				                              context: document.body,
				                              success: function(data){
				                              msgboxPetar(dic("Settings.SuccAdd",lang))
							    			  window.location.reload();
					                          }
				                              });	
				                             }
		                                     }
	    	                                }
	    	                              }
	    	                             }
	    	                           }
	    	                          }
	                               }
                              }
                           },
                           {
                         	text:dic('cancel',lang),
       			 			click:function() {
					    $( this ).dialog( "close" );
				    }
                  }
               ]
             
            });    
   		 }  
	</script>
	<script>
	
clientid = '<?=session("client_id")?>';
	    lang = '<?php echo $cLang?>';
    var allRemoved = "";

    document.getElementById("registration").focus();
    document.getElementById('fuelType').selectedIndex = <?php echo $gorivo?>-1;
     
   	if (<?php echo $totalAlDr ?> == <?php echo $totalDr ?>) document.getElementById('addAllDri').disabled="disabled";
    else document.getElementById('addAllDri').disabled="";
    
     
   
    //    if (document.getElementById("opt-" + i).value == "<php echo $orgUnit ?>") {
    //        document.getElementById("orgUnit").selectedIndex = i;
    //    }
    //}
      
     /* if (<php echo $checkOrg ?> == 0) {
            document.getElementById("orgUnit").selectedIndex = -1;
      }*/
      
      
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
         //var element = document.getElementById("tr" + i);
       //  element.parentNode.removeChild(element);
       //  allRemoved += id + ";";
    }
    function modify() {
    	
    	
        var reg = document.getElementById("registration").value;
        var code = document.getElementById("code").value;
        if(!(code % 1 === 0))
        {
        	msgboxPetar("Невалиден код!<br>Кодот мора да биде бројка.",lang);
        	return false;
        }
        var model = document.getElementById("model").value;
        var prekar = document.getElementById("aliasName").value;
        var chassis = document.getElementById("chassis").value;
        var motor = document.getElementById("motor").value;
        var fuelType = document.getElementById("fuelType").selectedIndex + 1;
        
        var capacity = document.getElementById("capacity").value.replace(",", "");
        var orgUnit = document.getElementById("orgUnit").value;
        var firstReg = document.getElementById("firstReg").value;
        var lastReg = document.getElementById("lastReg").value;
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
				
		//if (nextService == "" || nextServiceMonths == "") {
        //	msgboxPetar(dic("Settings.MustServiceInterval"),lang)
      // } else {
       		top.ShowWait();
       		promeniOdometar(<?php echo $id ?>)
			$.ajax({
              url: "UpdateVehicle.php?reg=" + reg + "&code=" + code + "&model=" + model + "&range=" + range + "&chassis=" + chassis + "&motor=" + motor + "&fuelType=" + fuelType + "&capacity=" + capacity + "&orgUnit=" + orgUnit + "&firstReg=" + firstReg + "&lastReg=" + lastReg + "&kmPerYear=" + kmPerYear + "&sprTires=" + sprTires + "&winTires=" + winTires + "&nextService=" + nextService + "&nextServiceMonths=" + nextServiceMonths + "&greenCard=" + greenCard + "&id=" + <?php echo $id ?> + "&removed=" + allRemoved+ "&prekar=" + prekar+ "&activity=" + activity,
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
	
    for (var i=0; i < <?php echo $cnt?>; i++) {
        $('#btn' + i).button({ icons: { primary: "ui-icon-trash"} })
    }
    
	
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
    
	setDates();
    top.HideWait();
    SetHeightLite();
    iPadSettingsLite();
    livetracking = false;
    IsConnected()   
   
</script>

	<?php
		closedb();
	?>
</html>