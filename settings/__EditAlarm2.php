<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script>
lang = '<?php echo $cLang?>';
</script>
  

<?php
    opendb();  
	$clienttypeid = dlookup("select clienttypeid from clients where id = " . session("client_id"));
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
    $id = str_replace("'", "''", NNull($_GET['id'], ''));
	$dsedit = query("select * from alarms where id=" . $id . " and clientid = " . Session("client_id"));
    $tipotnaAlarmot = pg_fetch_result($dsedit, 0, "poiid");
?>
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
					 .val(value)
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
					        	$('.ui-autocomplete').css({ width: '610px' });
				        	else
				        		$('.ui-autocomplete').css({ width: '500px' });
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
                    	input.autocomplete("widget")[0].style.width = '610px';
                	else
                		input.autocomplete("widget")[0].style.width = '500px';
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
            	destroy: function () {
                this.input.remove();
                this.button.remove();
                this.element.show();
                $.Widget.prototype.destroy.call(this);
			  }
           });
    	})(jQuery);

        $(function () {
        $("#zonaTocka2").combobox();
        $("#toggle").click(function () {
            $("#zonaTocka2").toggle();
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
                	 var input = this.input = $("<input>")
					 .insertAfter(select)
					 .val(value)
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
					        	$('.ui-autocomplete').css({ width: '610px' });
				        	else
				        		$('.ui-autocomplete').css({ width: '500px' });
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
                    	input.autocomplete("widget")[0].style.width = '610px';
                	else
                		input.autocomplete("widget")[0].style.width = '500px';
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
            	destroy: function () {
                this.input.remove();
                this.button.remove();
                this.element.show();
                $.Widget.prototype.destroy.call(this);
			  }
           });
    	})(jQuery);

        $(function () {
        $("#zonataIzlezot").combobox();
        $("#toggle").click(function () {
            $("#zonataIzlezot").toggle();
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
                	 var input = this.input = $("<input>")
					 .insertAfter(select)
					 .val(value)
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
					        	$('.ui-autocomplete').css({ width: '610px' });
				        	else
				        		$('.ui-autocomplete').css({ width: '500px' });
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
                    	input.autocomplete("widget")[0].style.width = '610px';
                	else
                		input.autocomplete("widget")[0].style.width = '500px';
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
            	destroy: function () {
                this.input.remove();
                this.button.remove();
                this.element.show();
                $.Widget.prototype.destroy.call(this);
			  }
           });
    	})(jQuery);

        $(function () {
        $("#zonataVlezot").combobox();
        $("#toggle").click(function () {
            $("#zonataVlezot").toggle();
        });
    });
	</script>
<body>
	
	<table cellpadding="3" width="100%" style="padding-top: 25px;">
		   <tr>
                <td width="25%" class="text5" style="font-weight:bold; font-size = 15px ;" align="left"><?php dic("Settings.TypeOfAlert") ?></td>
                <td width="75%" class="text5" style="font-weight:bold; font-size = 15px ;">
                <select id = "TipNaAlarm2" disabled="disabled" style="font-size: 11px ;width: 365px; position: relative; top: 0px ;visibility: visible;" onchange="OptionsChange3()" class="combobox text2">
      			<?php
                	$TF = explode(" ", pg_fetch_result($dsedit, 0, "alarmtypeid"));
                    $t1 = "";
                    $t2 = "";
                    $t3 = "";
					$t4 = "";
					$t5 = "";
					$t6 = "";
					$t7 = "";
					$t8 = "";
					$t9 = "";
					$t10 = "";
					$t11 = "";
                    $t12 = "";
                    $t13 = "";
					$t14 = "";
					$t15 = "";
					$t16 = "";
					$t17 = "";
					$t18 = "";
					$t19 = "";
					$t20 = "";
					$t21 = "";
                    $t22 = "";
                    $t23 = "";
					$t24 = "";
					$t25 = "";
					$t37 = "";
					$t38 = "";
					$t48 = "";
					
					If($TF[0] == "01"){
                        $t1 = "selected='selected'";
					}
					If($TF[0] == "02"){
                        $t2 = "selected='selected'";
					}
					If($TF[0] == "03"){
                        $t3 = "selected='selected'";
					}
					If($TF[0] == "04"){
                        $t4 = "selected='selected'";
					}
					If($TF[0] == "05"){
                        $t5 = "selected='selected'";
					}
					If($TF[0] == "06"){
                        $t6 = "selected='selected'";
					}
					If($TF[0] == "07"){
                        $t7 = "selected='selected'";
					}
					If($TF[0] == "08"){
                        $t8 = "selected='selected'";
					}
					If($TF[0] == "09"){
                        $t9 = "selected='selected'";
					}
					If($TF[0] == "10"){
                        $t10 = "selected='selected'";
					}
					If($TF[0] == "11"){
                       $t11 = "selected='selected'";
					}
					If($TF[0] == "12"){
                        $t12 = "selected='selected'";
					}
					If($TF[0] == "13"){
                        $t13 = "selected='selected'";
					}
					If($TF[0] == "14"){
                        $t14 = "selected='selected'";
					}
					If($TF[0] == "15"){
                        $t15 = "selected='selected'";
					}
					If($TF[0] == "16"){
                        $t16 = "selected='selected'";
					}
					If($TF[0] == "17"){
                        $t17 = "selected='selected'";
					}
					If($TF[0] == "18"){
                        $t18 = "selected='selected'";
					}
					If($TF[0] == "19"){
                        $t19 = "selected='selected'";
					}
					If($TF[0] == "20"){
                        $t20 = "selected='selected'";
					}
					If($TF[0] == "21"){
                       $t21 = "selected='selected'";
					}
					If($TF[0] == "22"){
                        $t22 = "selected='selected'";
					}
					If($TF[0] == "23"){
                        $t23 = "selected='selected'";
					}
					If($TF[0] == "24"){
                        $t24 = "selected='selected'";
					}
					If($TF[0] == "25"){
                        $t25 = "selected='selected'";
					}
					If($TF[0] == "37"){
                        $t37 = "selected='selected'";
					}
					If($TF[0] == "38"){
                        $t38 = "selected='selected'";
					}
					If($TF[0] == "48"){
                        $t48 = "selected='selected'";
					}
   				?>
   					<option value="-" disabled="disabled">----------------------<?php dic("Settings.CommonAlerts")?>----------------------</option>
   					<option value="01" <?php echo $t1?>><?php dic("Settings.AlarmPanic")?></option>
		            <option value="02" <?php echo $t2?>><?php dic("Settings.AlarmAssistance")?></option>
		            <option value="03" <?php echo $t3?>><?php dic("Settings.AlarmAcumulator")?></option>
		            <option value="25" <?php echo $t25?>><?php dic("acumulatorPowerSupplyInterruption")?></option>
		            <option value="24" <?php echo $t24?>><?php dic("Settings.AlarmDefect")?></option>
                    <option value="04" <?php echo $t4?>><?php dic("Settings.AlarmVehicle")?></option>
                    <option value="05" <?php echo $t5?>><?php dic("Settings.AlarmFuelCap")?></option>
                    <option value="48" <?php echo $t48?>><?php dic("Settings.FallFuel")?></option>
                    <option value="06" <?php echo $t6?>><?php dic("Settings.AlarmSuddenBraking")?></option>
                    <option value="07" <?php echo $t7?>><?php dic("Settings.AlarmSpeedExcess")?></option>
                    <option value="08" <?php echo $t8?>><?php dic("Settings.AlarmEnterZone")?></option>
                    <option value="09" <?php echo $t9?>><?php dic("Settings.AlarmLeaveZone")?></option>
                    <option value="10" <?php echo $t10?>><?php dic("Settings.AlarmVisitPOI")?></option>
                    <option value="11" <?php echo $t11?>><?php dic("Settings.30MinNoDataIgnON")?></option>
                    <option value="26" style="display: none"><?php dic("prednaleva")?></option>
                    <option value="27" style="display: none"><?php dic("prednadesna")?></option>
                    <option value="28" style="display: none"><?php dic("stranicnavrata")?></option>
                    <option value="29" style="display: none"><?php dic("zadnavrata")?></option>
                    <option value="30" style="display: none"><?php dic("stanatvozac")?></option>
                 	<option value="-" disabled="disabled">-----------------------------<?php dic("Settings.RoutesCombo")?>---------------------------</option>
		            <option value="12" <?php echo $t12?>><?php dic("Settings.AlarmUnOrdered")?></option>
		            <option value="13" <?php echo $t13?>><?php dic("Settings.AlarmStayMoreThanAllowed")?></option>
                    <option value="14" <?php echo $t14?>><?php dic("Settings.AlarmStayOutOfLocation")?></option>
                    <option value="15" <?php echo $t15?>><?php dic("Settings.AlarmLeaveRoute")?></option>
                    <option value="16" <?php echo $t16?>><?php dic("Settings.AlarmPause")?></option>
                    <option value="-" disabled="disabled">-----------------<?php dic("Main.FleetManagement")?>-----------------</option>
                    <option value="17" <?php echo $t17?>><?php dic("Settings.AlarmRegExpire")?></option>
                    <option value="18" <?php echo $t18?>><?php dic("Settings.AlarmService")?></option>
                    <option value="19" <?php echo $t19?>><?php dic("Settings.AlarmGreenCard")?></option>
                    <option value="20" <?php echo $t20?>><?php dic("Settings.AlarmPolnomLicense")?></option>
		            <option value="-" disabled="disabled">-----------------------------RFID-----------------------------</option>
		            <option value="22" <?php echo $t22?>><?php dic("Settings.AlarmUnauthorizedUseVehicle")?></option> 
		            <option value="23" <?php echo $t23?>><?php dic("Settings.AlarmNoRFIDVehicle")?></option>
		            <option disabled="disabled">-----------------------<?php dic("Settings.MotoAlarms")?>--------------------</option>
		            <option value="37" <?php if($clienttypeid!=6){ ?>disabled="disabled" <?php }?> <?php echo $t37?>><?php dic("Settings.Tow")?></option> 
		            <option value="38" <?php if($clienttypeid!=6){ ?>disabled="disabled" <?php }?> <?php echo $t38?>><?php dic("Settings.WeakAcc")?></option>
                </select>
                </td>
            </tr>
     <tr id="zonataTockata1" style="display:none;">
     <td style="font-weight:bold" class ="text2" width="25%" align="left"><?php echo dic_("Settings.SelectPOI2")?></td>
     <td style="font-weight:bold" class ="text2" width="75%">
     <select id="zonaTocka2" style="width: 370px;">
     <option selected = "selected" value="<?php
        	$odbranaTockaID = pg_fetch_result($dsedit,0,"poiid");
        	$odbranata1 = query("select * from pointsofinterest where id = ".$odbranaTockaID." and clientid=" . session("client_id"));
			$imeTocka1 = pg_fetch_result($odbranata1, 0, "name");
			echo $odbranaTockaID;
			?>"><?php echo $imeTocka1;?></option>
        
        <?php
        	$str1 = "";
			$str1 .= "select * from pointsofinterest where clientid=" . session("client_id") ." and type=1 ORDER BY name";
			$dsPP = query($str1);
            while($row = pg_fetch_array($dsPP)) {
        ?>
            <option value="<?php echo $row["id"] ?>"><?php echo $row["name"]?></option>
        <?
          }
        ?>
     </select>
     </td>
     </tr>
     
     <tr id="zonataTockataIzlezot" style="display: none">
     <td style="font-weight:bold" class ="text2" width="25%" align="left"><?php echo dic_("Settings.SelectExitGeoF")?></td>
     <td style="font-weight:bold" class ="text2" width="75%">
     <select id="zonataIzlezot" style="width: 370px;">
     <option selected = "selected" value="<?php
        	$odbranaTockaID2 = pg_fetch_result($dsedit,0,"poiid");
        	$odbranata2 = query("select * from pointsofinterest where id = ".$odbranaTockaID2." and clientid=" . session("client_id"));
			$imeTocka2 = pg_fetch_result($odbranata2, 0, "name");
			echo $odbranaTockaID2;
			?>"><?php echo $imeTocka2;?></option>
        <?php
        	$str2 = "";
			$str2 .= "select * from pointsofinterest where clientid=" . session("client_id") ." and type=2 ORDER BY name";
			$dsPP2 = query($str2);
            while($row2 = pg_fetch_array($dsPP2)) {
        ?>
            <option value="<?php echo $row2["id"] ?>"><?php echo $row2["name"]?></option>
        <?
            }
        ?>
     </select>
     </td>
     </tr>
     
     <tr id="zonataTockata3" style="display: none">
     <td style="font-weight:bold" class ="text2" width="25%" align="left"><?php echo dic_("Settings.SelectEnterGeoF")?></td>
     <td style="font-weight:bold" class ="text2" width="75%">
     <select id="zonataVlezot" style="width: 370px;">
     <option selected = "selected" value="<?php
        	$odbranaTockaID3 = pg_fetch_result($dsedit,0,"poiid");
        	$odbranata3 = query("select * from pointsofinterest where id = ".$odbranaTockaID2." and clientid=" . session("client_id"));
			$imeTocka3 = pg_fetch_result($odbranata3, 0, "name");
			echo $odbranaTockaID3;
			?>"><?php echo $imeTocka3;?></option>
        <?php
        	$str3 = "";
			$str3 .= "select * from pointsofinterest where clientid=" . session("client_id") ." and type=2 ORDER BY name";
			$dsPP3 = query($str3);
            while($row3 = pg_fetch_array($dsPP3)) 
            {
        ?>
            <option value="<?php echo $row3["id"] ?>"><?php echo $row3["name"]?></option>
        <?
            }
        ?>
     </select>
     </td>
     </tr>
     
     <tr id="prikaziVreme" style="display:none;">
     <td style="font-weight:bold" class ="text2" width="25%" align="left"><?php dic("Routes.RetentionTime")?></td>
     <td style="font-weight:bold" class ="text2" width="75%">
     <input id = "vreme2" type="text" class="textboxcalender corner5 text5" value="<?php echo pg_fetch_result($dsedit,0,"timeofpoi")?>" size="5"></input>&nbsp;<?php echo dic("Reports.Minutes")?>
     </td>
     </tr>
     
     <tr id="nadminuvanjeBrzina1" style="display:none;">
     <td width="25%" align = "left" style="font-weight:bold" class ="text2"><?php echo dic("Reports.Speed")?></td>
     <td width="75%" style="font-weight:bold" class ="text2"><input id = "brzinata2" value="<?php echo pg_fetch_result($dsedit,0,"speed")?>" class="textboxcalender corner5 text5" type="text" size="10"></input>&nbsp;kmh</td>
     </tr>
     <tr>
     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Settings.InsertAler")?>:</td>
     <td width = "75%" style="font-weight:bold" class ="text2">
     <div class="ui-widget" style="height: 25px; width: 100%;">
     <select id="vozila2" style="width: 365px;" class="combobox text2" onchange="OptionsChangeVehicle2()">
     <?php $opcijata = pg_fetch_result($dsedit, 0, "typeofgroup");?>
     	<option value="0"><?php echo dic_("Tracking.SelectOption")?></option>
        <option value="1" <?php if ($opcijata==""){ ?> selected = "selected" <?php }?>><?php echo dic_("Tracking.OneVehicle")?></option>
        <option value="2" <?php if ($opcijata=="2"){ ?> selected = "selected" <?php }?>><?php echo dic_("Tracking.VehInOrgU")?></option>
        <option value="3" <?php if ($opcijata=="3"){ ?> selected = "selected" <?php }?>><?php echo dic_("Tracking.AllVehCompany")?></option>
     </select>
	 </div>
	 </td>
     </tr>
       
     <tr id="ednoVozilo2" style="display:none;">
     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Tracking.SelectVeh")?>:</td>
     <td width = "75%" style="font-weight:bold" class ="text2">
     <div class="ui-widget" style="height: 25px; width: 100%;">
     <select id="voziloOdbrano2" style="width: 365px;" class="combobox text2">
     	<?php
        	$str1 = "";
		if ($_SESSION['role_id'] == "2") {
			$str1 = "select * from vehicles where clientID=" . session("client_id") . " and active='1' order by cast(code as integer) asc" ;
		} else {
			$str1 = "select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") and active='1' order by cast(code as integer) asc";
		}
			$dsPP = query($str1);
            while($row = pg_fetch_array($dsPP)) 
            {
            	if($row["id"] == pg_fetch_result($dsedit, 0, "vehicleid"))
				{
		?>
            <option value="<?php echo $row["id"] ?>" selected><?php echo $row["registration"]?>&nbsp;(<?php echo $row["code"]?>)</option>
        <?			
				}else
				{
        ?>
            <option value="<?php echo $row["id"] ?>"><?php echo $row["registration"]?>&nbsp;(<?php echo $row["code"]?>)</option>
        <?
				}
            }
        ?>
     </select>
	 </div>
	 </td>   
     </tr>
     
     <tr id="OrganizacionaEdinica2" style="display:none;">
     <td width = "25%" style="font-weight:bold" class ="text2" align="left"><?php echo dic_("Tracking.SelectOrg.Unit")?>:</td>
     <td width = "75%" style="font-weight:bold" class ="text2">
     <div class="ui-widget" style="height: 25px; width: 100%">
     <select id="oEdinica2" style="width: 365px;" class="combobox text2">
     	<?php
        	$str2 = "";
		if ($_SESSION['role_id'] == "2") {
			$str2 = "select * from organisation where id in (
			select distinct organisationid from vehicles where clientid=" . session("client_id") . " 
			and active='1' and organisationid <> 0) order by code::INTEGER";
		} else {
			$str2 = "select * from organisation where id in (
			select distinct organisationid from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") 
			and active='1' and organisationid <> 0) order by code::INTEGER";
		}
			$dsPP2 = query($str2);
			$brojRedovi = dlookup("select count(*) from organisation where clientid=" . session("client_id"));
            while($row2 = pg_fetch_array($dsPP2)) {
            	if($row2["id"] == pg_fetch_result($dsedit, 0, "settings"))
				{
		?>
            <option selected value="<?php echo $row2["id"] ?>"><?php if ($brojRedovi>0){ echo $row2["name"]?>&nbsp;(<?php echo $row2["code"]?> <?php }else{ echo dic_("Settings.NoOrgU");}?>)</option>
        <?			
				} else {
        ?>
            <option value="<?php echo $row2["id"] ?>"><?php if ($brojRedovi>0){ echo $row2["name"]?>&nbsp;(<?php echo $row2["code"]?> <?php }else{ echo dic_("Settings.NoOrgU");}?>)</option>
        <?
				}
            }
        ?>
     </select>
	 </div>
	 </td>
     </tr>
 <?php
  	$checkedDays = "";
  	$checkedKm = "";
  	$valueDays = 5;
  	$valueKm = 0;
	if (pg_fetch_result($dsedit, 0, "remindme") == "") {
		
	} else {
		$arr = explode("; ", pg_fetch_result($dsedit, 0, "remindme"));
		if(count($arr) == 1) {
			$arr1 = explode(" ", $arr[0]);
			if ($arr1[1] == "days") {
				$valueDays = $arr1[0];
				$checkedDays = "checked";
			} else {
				$valueKm = round($arr1[0] * $value,0);
				$checkedKm = "checked";
			}
		} else {
			$checkedDays = "checked";
			$checkedKm = "checked";
			$arr1 = explode(" ", $arr[0]);
			if ($arr1[1] == "days") {
				$valueDays = $arr1[0];
			} else {
				$valueKm = round($arr1[0] * $value,0);
			}
			$arr2 = explode(" ", $arr[1]);
			if ($arr2[1] == "days") {
				$valueDays = $arr2[0];
			} else {
				$valueKm = round($arr2[0] * $value,0);
			}
		}
	}
    ?> 
   <tr id="fm1" style="display:none;">
	     <td width = "27%" style="font-weight:bold" class ="text2"  align="left"><?= dic_("Settings.RemindMe")?> <?= dic_("Settings.Before")?>:</td>
	     <td width = "73%" style="" class ="text2">
	     	<span id="rmdD1">
	     	 <input id="remindDays1" type="checkbox" name="remindme" value="days" style="position: relative; top:4px;display:none" <?= $checkedDays?>/> 
	     	 <input id = "fmvalueDays1" class="textboxCalender corner5 text5" type="text" style="width:40px" value="<?= $valueDays?>"> <?= dic_("Reports.Days_")?>
	     	</span>
	     	<span id="rmdKm1" style="display: none"> 
	     	 <input id="remindKm1" type="checkbox" name="remindme" value="Km" style="position: relative; top:4px; margin-left: 15px" <?= $checkedKm?>/> 
	     	 <input id = "fmvalueKm1" class="textboxCalender corner5 text5" type="text" style="width:40px" value="<?= $valueKm?>"> <?= $metric?>
	     	</span> 	     	
	     </td>
     </tr>
     
     <tr id="noteFmAlarm1" style="display:none">
	     <td width = "27%"></td>	
	     <td id="textFmAlarm1" width = "73%" class="text2" style="color:#ff0000; font-size: 10px"></td>
     </tr>
     <tr>
     <td style="font-weight:bold" class ="text2" width="25%" align="left"><?php echo dic_("Tracking.Emails")?></td>
     <td style="font-weight:bold" class ="text2" width="75%"><input id = "emails2" type="text" style="width: 365px" class="textboxcalender corner5 text5" value="<?php echo pg_fetch_result($dsedit,0,"emails")?>"></input></td>
     </tr>
     <tr>
     <td width = "25%"></td>	
     <td width = "75%" style="" class ="text2"><font color = RED style="font-size: 10px"><?php echo dic_("Reports.SchNote")?></font></td>
     </tr>
     <?php
     if ($clienttypeid == 6) {
     	?>
     	 <tr>
	     	<td style="font-weight:bold" class ="text2" width="25%" align="left"><?php echo dic_("Settings.SMS")?></td>
	     	<td style="font-weight:bold" class ="text2" width="75%"><input id = "sms2" type="text" style=" width: 365px;" class="textboxcalender corner5 text5" value="<?php echo pg_fetch_result($dsedit,0,"sms")?>"></input></td>
	     </tr>
     	<?php
     }
     ?>
    
     <tr>
     <td valign="middle" style="font-weight:bold" class ="text2" width="25%" align="left"><?php dic("Settings.Sound")?></td>
     <td valign="middle" style="font-weight:bold" class ="text2" width="75%">
     <select id = "zvukot2" style="font-size: 11px; position: relative; top: 0px; visibility: visible; float:left" class="combobox text2">
     	<?php 
     	$TF1 = explode(" ", pg_fetch_result($dsedit, 0, "soundid"));
                    $tt1 = "";
                    /*$tt2 = "";
                    $tt3 = "";
					$tt4 = "";
					$tt5 = "";*/
					
					If($TF1[0] == "1"){
                       $tt1 = "selected='selected'";
					}
					/*If($TF1[0] == "2"){
                        $tt2 = "selected='selected'";
					}
					If($TF1[0] == "3"){
                        $tt3 = "selected='selected'";
					}
					If($TF1[0] == "4"){
                        $tt4 = "selected='selected'";
					}
					If($TF1[0] == "5"){
                        $tt5 = "selected='selected'";
					}*/
					
		?>
     	<option value = "1" <?php echo $tt1?>><?php dic("Settings.Sound")?> 1</option>
     	<!--
     	<option value = "2" <?php echo $tt2?>><?php dic("Settings.Sound")?> 2</option>
     	<option value = "3" <?php echo $tt3?>><?php dic("Settings.Sound")?> 3</option>
     	<option value = "4" <?php echo $tt4?>><?php dic("Settings.Sound")?> 4</option>
     	<option value = "5" <?php echo $tt5?>><?php dic("Settings.Sound")?> 5</option>
     	-->
     	</select>
          <audio id="demo" src="../tracking/sound/bells_alarm.ogg"></audio>
	 	  <button id="play1" onclick="document.getElementById('demo').play()" style="position: relative; width: 35px;height: 28px;margin-left:10px;"></button>
     	  <button id="pause1" onclick="document.getElementById('demo').pause()" style="position: relative; width: 35px;height: 28px;"></button>
     	  <button id="poglasno1" onclick="document.getElementById('demo').volume+=0.1" style="position: relative; width: 35px;height: 28px;"></button>
     	  <button id="potivko1" onclick="document.getElementById('demo').volume-=0.1" style="position: relative; width: 35px;height: 28px;"></button>
	 </td>
	 </tr>
	 <?php 
	 
	 	$dostapnost = pg_fetch_result($dsedit, 0, "available");
	 ?>
	 
	 <tr>
     <td width = "25%" style="font-weight:bold" class ="text2"  align="left"><?php echo dic_("Settings.AvailableFor")?>:</td>
     <td width = "75%" style="font-weight:bold" class ="text2"><div id="dostapno" class="corner5">
        <input type="radio" id="tipKorisnik1" name="radio" <?php if($dostapnost==1){ ?>checked="checked" <?php }?> /><label for="tipKorisnik1"><?php echo dic_("Settings.User")?></label>
        <input type="radio" id="tipKorisnik2" name="radio" <?php if($dostapnost==2){ ?>checked="checked" <?php }?> /><label for="tipKorisnik2"><?php echo dic_("Tracking.OrgU")?></label>
        <input type="radio" id="tipKorisnik3" name="radio" <?php if($dostapnost==3){ ?>checked="checked" <?php }?> /><label for="tipKorisnik3"><?php echo dic_("Settings.Company")?></label>
     </div>
     </td>
     </tr>
    
     </table>
</body>    
<script>

	
function OptionsChange3() {
	document.getElementById('noteFmAlarm1').style.display = "none";
    document.getElementById('textFmAlarm1').innerHTML = "";
	var zonaTockata1 = document.getElementById('TipNaAlarm2').selectedIndex;
	
    if (zonaTockata1 == "13")
    {
    	document.getElementById('prikaziVreme').style.display = '';
        document.getElementById('zonataTockata1').style.display = '';
    }
    if (zonaTockata1 == "12")
    {
    	document.getElementById('zonataTockataIzlezot').style.display = '';
    }
    if (zonaTockata1 == "11")
    {
    	document.getElementById('zonataTockata3').style.display = '';
    }
    if (zonaTockata1 == "10")
    {
        document.getElementById('nadminuvanjeBrzina1').style.display = '';
    } 
if (zonaTockata1 == "27" || zonaTockata1 == "28" || zonaTockata1 == "29" || zonaTockata1 == "30")
    {
        document.getElementById('fm1').style.display = '';
        document.getElementById('rmdD1').style.display = '';
        
        if (zonaTockata1 == "28") {
        	document.getElementById('rmdKm1').style.display = '';
        	document.getElementById('remindDays1').style.display = '';
        	
        	if ($('#remindDays1').is(':checked') == false && $('#remindKm1').is(':checked') == false) {
        		$('#remindDays1').attr("checked","checked");
        	}
        } else {
        	document.getElementById('rmdKm1').style.display = 'none';
        	document.getElementById('remindDays1').style.display = 'none';
        }
       
		document.getElementById('noteFmAlarm1').style.display="";
        if (zonaTockata1 == "27") {
	    	document.getElementById('textFmAlarm1').innerHTML = "* " + dic("Settings.FmAlarmInfo1", lang);
	    }
	    if (zonaTockata1 == "28") {
	       	document.getElementById('textFmAlarm1').innerHTML = "* " + dic("Settings.FmAlarmInfo2", lang);
	    }
	    if (zonaTockata1 == "29") {
	       	document.getElementById('textFmAlarm1').innerHTML = "* " + dic("Settings.FmAlarmInfo3", lang);
	    }
    } 
    if (zonaTockata1 != "13")
    {
    	document.getElementById('prikaziVreme').style.display = 'none';
        document.getElementById('zonataTockata1').style.display = 'none';
    }
    if (zonaTockata1 != "12")
    {	
        document.getElementById('zonataTockataIzlezot').style.display = 'none';
	}
	if (zonaTockata1 != "11")
    {
        document.getElementById('zonataTockata3').style.display = 'none';
	}
	if (zonaTockata1 != "10")
    {
        document.getElementById('nadminuvanjeBrzina1').style.display = 'none';
	}
if(zonaTockata1 != "27" && zonaTockata1 != "28" && zonaTockata1 != "29" && zonaTockata1 != "30")
    {
        document.getElementById('fm1').style.display = 'none';
        document.getElementById('rmdKm1').style.display = 'none';
	}
	}
	
	function OptionsChangeVehicle2() {

	 var odberi2 = document.getElementById('vozila2').selectedIndex;
	
	    if (odberi2 == "1")
	    {
	        document.getElementById('ednoVozilo2').style.display = '';
	    }
	    if (odberi2 == "2")
	    {
	        document.getElementById('OrganizacionaEdinica2').style.display = '';
	    }
	    if(odberi2 != "1")
	    {
	        document.getElementById('ednoVozilo2').style.display = 'none';
	  	}
	  	if(odberi2 != "2")
	    {
	        document.getElementById('OrganizacionaEdinica2').style.display = 'none';
		}
	
	}
	
	
	
	$(document).ready(function () {
		OptionsChange3();
		OptionsChangeVehicle2();
	});
	
	$('#play1').button({ icons: { primary: "ui-icon-play"} })
    $('#pause1').button({ icons: { primary: "ui-icon-pause"} })
    $('#poglasno1').button({ icons: { primary: "ui-icon-plus"} })
    $('#potivko1').button({ icons: { primary: "ui-icon-minus"} })
    $('#dostapno').buttonset();
</script>
     
     <script>
     
   	 
     </script>

<?php
	closedb();
?>
