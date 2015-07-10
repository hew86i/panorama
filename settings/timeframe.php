<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
	
	$TodayDayOfWeek = date("w");
    if (intval($TodayDayOfWeek) == 0) {
		$TodayDayOfWeek = "7";
	}
	$EndOfPrevWeek = DatetimeFormat(addDay("-" . $TodayDayOfWeek), 'd-m-Y');
	$CurrentMonth = date('m');
	$CurrentYear = date('Y');
	$LastMonth = $CurrentMonth - 1;
	$YearOfPrevMonth = $CurrentYear;
	if ($LastMonth == 0) {
		$LastMonth = 12;
		$YearOfPrevMonth = $CurrentYear - 1;
	}
	$LastDateOfMonth = cal_days_in_month(CAL_GREGORIAN, $LastMonth, $YearOfPrevMonth); //Kolku dena ima prethodniot mesec
	
	$Today = DateTimeFormat(now(), 'd-m-Y');
	$LastDay = DatetimeFormat(addDay(-1), 'd-m-Y');
	$LastWeek = DatetimeFormat(addDay(-7), 'd-m-Y');
	$LastWeek1 = DatetimeFormat(addDay("-" . ($TodayDayOfWeek + 6)), 'd-m-Y');
	$startLastMonth = "01-" . leadingZero($LastMonth) . "-" . $CurrentYear;
	$endLastMonth = $LastDateOfMonth . "-" . leadingZero($LastMonth) . "-" . $CurrentYear;
	$currentWeek = DatetimeFormat(addDay("-" . ($TodayDayOfWeek + 6) + 7), 'd-m-Y');
	$startCurrYear = "01-01-" . $CurrentYear;
	$Last10 = DatetimeFormat(addDay(-10), 'd-m-Y');

?>
<html>
	<script type="text/javascript">
		lang = '<?php echo $cLang?>';
	</script>
	<head>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="stylesheet" type="text/css" href="./gui.css">
	<link rel="stylesheet" type="text/css" href="./timeframe.css">
	<link rel="stylesheet" type="text/css" href="../css/ui-lightness/jquery-ui-1.8.14.custom.css">
	<script type="text/javascript" src="prototype.js"></script>
	<script type="text/javascript" src="timeframe.js"></script>
	
	
	</head>
	<body>
	<div id="calendars" style="margin-left: 25px; margin-top: 10px;"></div>
	<a href="#" onClick="unfocus(this); return false;" id="prev" style="position: absolute; top: 11px; background-color: #FFB03B; width: 16px; height: 19px; left: 10px;">
		<span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-w" style="position: relative; float: left;">
	</a>
	<a href="#" onClick="unfocus(this); return false;" id="next" style="position: absolute; top: 11px; background-color: #FFB03B; width: 16px; height: 19px; left: 370px;">
		<span class="ui-button-icon-primary ui-icon ui-icon-triangle-1-e" style="position: relative; float: left;">
	</a>
	<a href="#" onClick="unfocus(this); return false;" id="reset" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" style="position: absolute; top: 99px; left: 455px; width: auto; min-width: 65px; padding: 2px;">
		<span class="ui-button-icon-primary ui-icon ui-icon-refresh" style="position: relative; float: left;"></span>
		<span class="ui-button-text" style="float: right; position: relative; top: 1px; margin: 0px; padding: 0px; right: 5px;">Reset</span>
	</a>
	<a href="#" onClick="unfocus(this); return false;" id="today" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button" style="position: absolute; top: 99px; left: 539px; width: auto; min-width: 65px; padding: 2px;">
		<span class="ui-button-icon-primary ui-icon ui-icon-home" style="position: relative; float: left;"></span>
		<span class="ui-button-text" style="float: right; position: relative; top: 1px; margin: 0px; padding: 0px; right: 5px;"><?php echo dic("Reports.Today")?></span>
	</a>
    <div id="calendar_form">
        <div id="labels" style="display: none;">
          <a href="#" onClick="return false;" id="reset">R</a>
          <a href="#" onClick="return false;" id="prev">P</a>
          <a href="#" onClick="return false;" id="next">N</a>
          <a href="#" onClick="return false;" id="today">T</a>
          
        </div>
        <div id="fields" style="">
			<span>
          		<input id="start" type="text" width="80px" style="display: inline; position: absolute; top: 60px; left: 400px; width: 100px;" class="textboxCalender corner5 text2" value="" />
				<input id="end" type="text" width="80px" style="display: inline; position: absolute; top: 60px; left: 510px; width: 100px;" class="textboxCalender corner5 text2" value="" />
			</span>
        </div>
    </div>
    <div class="text2" id="dateRange" style="width: 80px; position: absolute; left: 397px; text-align: right; top: 17px; "><?php dic("Reports.DateRange")?>: </div>
    <!--select id="dateRange" name="dateRange" style="display: inline; position: absolute; top: 10px; left: 485px;"></select-->
    <select name="txtDateRange" id="txtDateRange" class="combobox text2" style="display: inline; position: absolute; top: 10px; left: 485px;" onChange="setRange(this.value)">		
        <option id="opt0" value="0"><?php echo dic("Reports.Yesterday")?></option>
		<option id="opt1" value="1"><?php echo dic("Reports.Today")?></option>
		<option id="opt3" value="2"><?php echo dic("Reports.CurrentWeek")?></option>
		<option id="opt3" value="3"><?php echo dic("Reports.LastWeek")?></option>
        <option id="opt4" value="4"><?php echo dic("Reports.Last10Days")?></option>
		<option id="opt5" value="5"><?php echo dic("Reports.CurrentMonth")?></option>
        <option id="opt6" value="6"><?php echo dic("Reports.LastMonth")?></option>
        <option id="opt7" value="7"><?php echo dic("Tracking.CurrentYear")?></option>
        <option id="opt8" value="8"><?php echo dic("Reports.Custom")?></option>
	</select>
	<div onClick="defaultKalendar('s');" style="font-size: 11px; top: 132px; left: 455px; position: absolute; padding: 2px; width: auto; min-width: 65px;" id="ApplyBtn" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button"><span class="ui-button-icon-primary ui-icon ui-icon-check" style="position: relative; float: left;"></span><span class="ui-button-text" style="float: right; position: relative; top: 1px; margin: 0px; padding: 0px; right: 5px;"><?php echo dic("Fm.Save")?></span></div>
	<div onClick="defaultKalendar('o');" style="font-size: 11px; top: 132px; left: 539px; position: absolute; text-align: center; width: auto; min-width: 65px; padding: 2px;" id="CancelBtn" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" role="button"><span class="ui-button-icon-primary ui-icon ui-icon-closethick" style="position: relative; float: left;"></span><span class="ui-button-text" style="float: right; position: relative; margin: 0px; padding: 0px; top: 1px; right: 5px;"><?php echo dic("Reports.Cancel")?></span></div>
</body>
	<script type="text/javascript" charset="utf-8">
		var defDatetime = '';
		var defStart = '';
		var defEnd = '';
		//$('#ApplyBtn').button({ icons: { primary: "ui-icon-search"} });
		//$('#CancelBtn').button({ icons: { primary: "ui-icon-search"} });
		
		today = '<?php echo $Today;?>';
		yesterday = '<?php echo $LastDay;?>';
		lastWeek = '<?php echo $LastWeek;?>';
		lastWeek1 = '<?php echo $LastWeek1?>'
		endOfPrevWeek = '<?php echo $EndOfPrevWeek;?>';
		startLastMonth = '<?php echo $startLastMonth;?>';
		endLastMonth = '<?php echo $endLastMonth;?>';
		currentWeek = '<?php echo $currentWeek;?>';
		lastMonth = '<?php echo $LastMonth;?>';
		currentMonth = '<?php echo $CurrentMonth?>'
		currentYear = '<?php echo $CurrentYear?>'
		startCurrYear = '<?php echo $startCurrYear?>'
		last10 = '<?php echo $Last10?>'
	
    //<![CDATA[
      var tf = new Timeframe('calendars', {
        startField: 'start',
        endField: 'end',
        months: 2,
        format: '%d-%m-%Y',
        latest: new Date(),
        previousButton: 'prev', 
        todayButton: 'today',
        nextButton: 'next',
        resetButton: 'reset' });
    //]]>
    	setRange(0);
	if(parent.$('#txtNewDate').length > 0)
	    {	
	    	parent.$('#txtNewDate').val(" " + yesterday.split("-")[0] + " " + tf.monthNames[parseInt(yesterday.split("-")[1], 10)-1].substring(0, 3) + " " + yesterday.split("-")[2] + " - " + yesterday.split("-")[0] + " " + tf.monthNames[parseInt(yesterday.split("-")[1], 10)-1].substring(0, 3) + " " + yesterday.split("-")[2]);
			defDatetime = parent.$('#txtNewDate').val();
		}
    	//if(parent.txtNewDate != undefined)
	    //{	
	    	//parent.txtNewDate.value = " " + yesterday.split("-")[0] + " " + tf.monthNames[parseInt(yesterday.split("-")[1], 10)-1].substring(0, 3) + " " + yesterday.split("-")[2] + " - " + yesterday.split("-")[0] + " " + tf.monthNames[parseInt(yesterday.split("-")[1], 10)-1].substring(0, 3) + " " + yesterday.split("-")[2];
			//defDatetime = parent.txtNewDate.value;
		//}
		defStart = start.value;
		defEnd = end.value;
		parent.$('#txtSDate').val(start.value);
		parent.$('#txtEDate').val(end.value);
		tf.fields.get('start').style.border = '2px solid #FFB03B';
      	tf.fields.get('start').classList.add('shadow');
		function setRange(_val) {
			setDateRange(_val);
			var dtS = new Date(parseInt(start.value.split("-")[2], 10), parseInt(start.value.split("-")[1], 10)-1, parseInt(start.value.split("-")[0], 10), 12);
			tf.range.set('start', dtS);
			var dtE = new Date(parseInt(end.value.split("-")[2], 10), parseInt(end.value.split("-")[1], 10)-1, parseInt(end.value.split("-")[0], 10), 12);
			tf.range.set('end', dtE);
	  		tf.refreshRange();
	  		
	  	}
	  	function setRangeByValue(_start, _end) {
			start.value = _start;
			end.value = _end;
			var dtS = new Date(parseInt(start.value.split("-")[2], 10), parseInt(start.value.split("-")[1], 10)-1, parseInt(start.value.split("-")[0], 10), 12);
			tf.range.set('start', dtS);
			var dtE = new Date(parseInt(end.value.split("-")[2], 10), parseInt(end.value.split("-")[1], 10)-1, parseInt(end.value.split("-")[0], 10), 12);
			tf.range.set('end', dtE);
	  		tf.refreshRange()
	  	}
	  	function setDateRange(_val) {
			var dr = _val;
			switch (parseInt(_val))
			{
				case 0:
					start.value = yesterday;
					end.value = yesterday;
					if(parent.$('#txtNewDate').length > 0)
						parent.$('#txtNewDate').val(" " + yesterday.split("-")[0] + " " + tf.monthNames[parseInt(yesterday.split("-")[1], 10)-1].substring(0, 3) + " " + yesterday.split("-")[2] + " - " + yesterday.split("-")[0] + " " + tf.monthNames[parseInt(yesterday.split("-")[1], 10)-1].substring(0, 3) + " " + yesterday.split("-")[2]);
						//parent.txtNewDate.value = " " + yesterday.split("-")[0] + " " + tf.monthNames[parseInt(yesterday.split("-")[1], 10)-1].substring(0, 3) + " " + yesterday.split("-")[2] + " - " + yesterday.split("-")[0] + " " + tf.monthNames[parseInt(yesterday.split("-")[1], 10)-1].substring(0, 3) + " " + yesterday.split("-")[2];
				break;
				case 1:
					start.value = today;
					end.value = today;
					if(parent.$('#txtNewDate').length > 0)
						parent.$('#txtNewDate').val(" " + today.split("-")[0] + " " + tf.monthNames[parseInt(today.split("-")[1], 10)-1].substring(0, 3) + " " + today.split("-")[2] + " - " + today.split("-")[0] + " " + tf.monthNames[parseInt(today.split("-")[1], 10)-1].substring(0, 3) + " " + today.split("-")[2]);
						//parent.txtNewDate.value = " " + today.split("-")[0] + " " + tf.monthNames[parseInt(today.split("-")[1], 10)-1].substring(0, 3) + " " + today.split("-")[2] + " - " + today.split("-")[0] + " " + tf.monthNames[parseInt(today.split("-")[1], 10)-1].substring(0, 3) + " " + today.split("-")[2];
				break;
				case 2:
					start.value = currentWeek;
					end.value = today;
					if(parent.$('#txtNewDate').length > 0)
						parent.$('#txtNewDate').val(" " + currentWeek.split("-")[0] + " " + tf.monthNames[parseInt(currentWeek.split("-")[1], 10)-1].substring(0, 3) + " " + currentWeek.split("-")[2] + " - " + today.split("-")[0] + " " + tf.monthNames[parseInt(today.split("-")[1], 10)-1].substring(0, 3) + " " + today.split("-")[2]);
						//parent.txtNewDate.value = " " + currentWeek.split("-")[0] + " " + tf.monthNames[parseInt(currentWeek.split("-")[1], 10)-1].substring(0, 3) + " " + currentWeek.split("-")[2] + " - " + today.split("-")[0] + " " + tf.monthNames[parseInt(today.split("-")[1], 10)-1].substring(0, 3) + " " + today.split("-")[2];
				break;
				case 3:
					start.value = lastWeek1;
					end.value = endOfPrevWeek;
					if(parent.$('#txtNewDate').length > 0)
						parent.$('#txtNewDate').val(" " + lastWeek1.split("-")[0] + " " + tf.monthNames[parseInt(lastWeek1.split("-")[1], 10)-1].substring(0, 3) + " " + lastWeek1.split("-")[2] + " - " + endOfPrevWeek.split("-")[0] + " " + tf.monthNames[parseInt(endOfPrevWeek.split("-")[1], 10)-1].substring(0, 3) + " " + endOfPrevWeek.split("-")[2]);
						//parent.txtNewDate.value = " " + lastWeek1.split("-")[0] + " " + tf.monthNames[parseInt(lastWeek1.split("-")[1], 10)-1].substring(0, 3) + " " + lastWeek1.split("-")[2] + " - " + endOfPrevWeek.split("-")[0] + " " + tf.monthNames[parseInt(endOfPrevWeek.split("-")[1], 10)-1].substring(0, 3) + " " + endOfPrevWeek.split("-")[2];
				break;
				case 4:
					start.value = last10;
					end.value = yesterday;
					if(parent.$('#txtNewDate').length > 0)
						parent.$('#txtNewDate').val(" " + last10.split("-")[0] + " " + tf.monthNames[parseInt(last10.split("-")[1], 10)-1].substring(0, 3) + " " + last10.split("-")[2] + " - " + yesterday.split("-")[0] + " " + tf.monthNames[parseInt(yesterday.split("-")[1], 10)-1].substring(0, 3) + " " + yesterday.split("-")[2]);
						//parent.txtNewDate.value = " " + last10.split("-")[0] + " " + tf.monthNames[parseInt(last10.split("-")[1], 10)-1].substring(0, 3) + " " + last10.split("-")[2] + " - " + yesterday.split("-")[0] + " " + tf.monthNames[parseInt(yesterday.split("-")[1], 10)-1].substring(0, 3) + " " + yesterday.split("-")[2];
				break;
				case 5:
					start.value = '01-' + currentMonth + '-' + currentYear;
					end.value = today;
					if(parent.$('#txtNewDate').length > 0)
						parent.$('#txtNewDate').val(' ' + '01 ' + tf.monthNames[parseInt(currentMonth, 10)-1].substring(0, 3) + ' ' + currentYear + ' - ' + today.split("-")[0] + " " + tf.monthNames[parseInt(today.split("-")[1], 10)-1].substring(0, 3) + " " + today.split("-")[2]);
						//parent.txtNewDate.value = ' ' + '01 ' + tf.monthNames[parseInt(currentMonth, 10)-1].substring(0, 3) + ' ' + currentYear + ' - ' + today.split("-")[0] + " " + tf.monthNames[parseInt(today.split("-")[1], 10)-1].substring(0, 3) + " " + today.split("-")[2];
				break;
				case 6:
					start.value = startLastMonth;
					end.value = endLastMonth;
					if(parent.$('#txtNewDate').length > 0)
						parent.$('#txtNewDate').val(" " + startLastMonth.split("-")[0] + " " + tf.monthNames[parseInt(startLastMonth.split("-")[1], 10)-1].substring(0, 3) + " " + startLastMonth.split("-")[2] + " - " + endLastMonth.split("-")[0] + " " + tf.monthNames[parseInt(endLastMonth.split("-")[1], 10)-1].substring(0, 3) + " " + endLastMonth.split("-")[2]);						
						//parent.txtNewDate.value = " " + startLastMonth.split("-")[0] + " " + tf.monthNames[parseInt(startLastMonth.split("-")[1], 10)-1].substring(0, 3) + " " + startLastMonth.split("-")[2] + " - " + endLastMonth.split("-")[0] + " " + tf.monthNames[parseInt(endLastMonth.split("-")[1], 10)-1].substring(0, 3) + " " + endLastMonth.split("-")[2];
				break;
				case 7:
					start.value = startCurrYear;
					end.value = yesterday;
					if(parent.$('#txtNewDate').length > 0)
						parent.$('#txtNewDate').val(" " + startCurrYear.split("-")[0] + " " + tf.monthNames[parseInt(startCurrYear.split("-")[1], 10)-1].substring(0, 3) + " " + startCurrYear.split("-")[2] + " - " + yesterday.split("-")[0] + " " + tf.monthNames[parseInt(yesterday.split("-")[1], 10)-1].substring(0, 3) + " " + yesterday.split("-")[2]);
						//parent.txtNewDate.value = " " + startCurrYear.split("-")[0] + " " + tf.monthNames[parseInt(startCurrYear.split("-")[1], 10)-1].substring(0, 3) + " " + startCurrYear.split("-")[2] + " - " + yesterday.split("-")[0] + " " + tf.monthNames[parseInt(yesterday.split("-")[1], 10)-1].substring(0, 3) + " " + yesterday.split("-")[2];
				break;
			}
			document.getElementById('txtDateRange').selectedIndex = _val;
		}
		function defaultKalendar(_bool)
		{
			if(_bool == 's')
			{
				if(parent.$('#txtNewDate').length > 0)
					defDatetime = parent.$('#txtNewDate').val();
				defStart = start.value;
				defEnd = end.value;
				parent.$('#txtSDate').val(start.value);
				parent.$('#txtEDate').val(end.value);
			}
			if(parent.$('#txtNewDate').length > 0)
				parent.$('#txtNewDate').val(defDatetime);
			setRangeByValue(defStart, defEnd);
			parent.$('#kalendarM').css({display:'none'});
		}
		function unfocus(_this)
		{
			document.getElementById(_this.id).blur();
		}
	</script>
	
</html>	
