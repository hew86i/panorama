// JavaScript Document

    var myScrollMenu;
    var myScrollContainer;
    var PrevHash = '';
    var cLang = '';
    var guidC = '';
    var guidU = '';
    var lang1 = '';
    var user_id = '';

    function SetHeight(){
        var _h = document.body.clientHeight;
        var _l = (document.body.clientWidth - 100) / 2;
        $('#report-content').css({ height: (_h - 95) + 'px' });
        $('#ifrm-cont').css({ height: (_h - 95) + 'px' });
        $('#div-menu').css({ height: (_h - 32) + 'px' });
        $('#div-loading').css({ left: (_l) + 'px' });
    }

    function SetHeightRec(){
        var _h = document.body.clientHeight;
        $('#speed-graph').css({ top: (_h - 100) + 'px' });
    }

    function SetHeightLite() {
	    try{
	        var ifrm = top.document.getElementById('ifrm-cont');
	        var _h = 0;
	        if (ifrm!=null){
	            _h = ifrm.offsetHeight;
	        } else {
	        _h = document.body.clientHeight;
	        }
	        var _w = document.body.clientWidth;
	        $('#report-content').css({ height: (_h) + 'px' });
        }
        catch(e){}
    }

    function setDates() {
        $('#firstReg').datepicker({
            dateFormat: 'dd-mm-yy',
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
            dateFormat: 'dd-mm-yy',
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
            dateFormat: 'dd-mm-yy',
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

    function setDates1() {
        $('#dateBorn').datetimepicker({
            dateFormat: 'dd-mm-yy',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
        });

        $('#firstLicence').datetimepicker({
            dateFormat: 'dd-mm-yy',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
        });

        $('#licenceExpire').datetimepicker({
            dateFormat: 'dd-mm-yy',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
        });

        $('#startCom').datetimepicker({
            dateFormat: 'dd-mm-yy',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
        });   
        $('#IntLicExp').datetimepicker({
            dateFormat: 'dd-mm-yy',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
        });
    }

    function setDates2() {
        $('#datetime').datetimepicker({
            dateFormat: 'dd-mm-yy',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
        });
    }

    function setDates7() {
        $('#sd').datetimepicker({
            dateFormat: 'dd-mm-yy',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
        });
        $('#ed').datetimepicker({
            dateFormat: 'dd-mm-yy',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
        });
    }

    function setDates4() {
        $('#datetime_').datetimepicker({
            dateFormat: 'dd-mm-yy',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
        });
    }

    function setDates5() {
        $('#datetime1_').datetimepicker({
            dateFormat: 'dd-mm-yy',
            showOn: "button",
            buttonImage: "../images/cal1.png",
            buttonImageOnly: true,
            hourGrid: 4,
            minuteGrid: 10
        });
    }

    function setDates3(arr) {
        var a = arr.split("*");
       
        for (var c = 0; c < a.length; c++) {
            $('#dt1_' + a[c]).datetimepicker({
                dateFormat: 'dd-mm-yy',
                showOn: "button",
                buttonImage: "../images/cal1.png",
                buttonImageOnly: true,
                hourGrid: 4,
                minuteGrid: 10
            });
        }
    }


    function iPadSettingsLite(){
	    if (Browser()!='iPad') {
		    //document.getElementById('div-menu').className = 'scrollY'
	    } else {
	        var RepCont = $('#report-content').html();
	        $('#report-content').html('<div id="scroll-cont-div"></div>');
	        $('#scroll-cont-div').html(RepCont);
			
	        myScrollContainer = new iScroll('scroll-cont-div');
	        iPad_Refresh();
	    }	
    }

    function iPadSettings(){
	    if (Browser() != 'iPad') {
	        document.getElementById('div-menu').className = 'scrollY';
	    } else {
	        var menuCont = $('#div-menu').html();
	        $('#div-menu').html('<div id="scroll-menu-div"></div>');
	        $('#scroll-menu-div').html(menuCont);	

		    myScrollMenu = new iScroll('scroll-menu-div');
		    var RepCont = $('#report-content').html();

		    $('#report-content').html('<div id="scroll-cont-div"></div>');
		    $('#scroll-cont-div').html(RepCont);
			
		    myScrollContainer = new iScroll('scroll-cont-div');
		    iPad_Refresh();
	    }	
    }

    function iPad_Refresh(){
	    if (Browser() == 'iPad') {
		    setTimeout(function () {myScrollMenu.refresh(); myScrollContainer.refresh()}, 0);
	    }
    }

    function checkHash(_tf) {
        var ifEqual = 0;
        var ifFirst = 1;
        var h = location.hash;
        if (h == null) { h = '' }
        if (PrevHash == null) { PrevHash = '' }
        h = h.replace('#fm/', '');
        PrevHash = PrevHash.replace('#fm/', '');

        if ((h != '') && (h != PrevHash)) {
            var objPrev = null;
            var objCurr = null;
            objPrev = document.getElementById(PrevHash);
            objCurr = document.getElementById(h);

            if (_tf == 'False') {
                if (objPrev != null) { objPrev.className = 'repoMenu1 corner5 text2' }
                if (objCurr != null) { objCurr.className = 'repoMenu1 corner5 text2' }
            }
            else {
                if (_tf == 'True') {
                    if (objPrev != null) { objPrev.className = 'repoMenu corner5 text2' }
                    if (objCurr != null) { objCurr.className = 'repoMenuSel corner5 text2' }
                }
                else {
                    if (objPrev != null) {
                        if (objPrev.className != 'repoMenu1 corner5 text2')
                            if (objPrev != null) {
                                ifFirst = 0;
                                var prev = "";
                                prev = document.getElementById(PrevHash).attributes[2].nodeValue.split("_")[1];
                                var curr = "";
                                curr = document.getElementById(h).attributes[2].nodeValue.split("_")[1];
                                if (prev == curr) {
                                    ifEqual = 1;
                                }
                                objPrev.className = 'repoMenu corner5 text2';
                            }
                    }
                    if (objCurr != null) {
                        if (objCurr.className != 'repoMenu1 corner5 text2')
                            if (objCurr != null) {
                                objCurr.className = 'repoMenuSel corner5 text2';
                            }
                    }
                }
            }
            PrevHash = h;
        }
        if ((h == '') && (h == PrevHash)) {
            ifFirst = 1;
            PrevHash = 'menu_1_1';
            location.hash = '#fm/' + PrevHash;
            var objCurr = null;
            objCurr = document.getElementById(PrevHash);
            if (objCurr != null) {
                objCurr.className = 'repoMenuSel corner5 text2';
            }
        }
        LoadData(1, 1, ifEqual, ifFirst)
    }

    $(window).bind('hashchange', function (event) {
        if (event.target.location.pathname.indexOf("LoadMap.php") != -1)
            return false;
        checkHash();
        //LoadData()
    });

    function ShowLoading(){
        $('#div-loading').show('fast');
    }

    function HideLoading(){
        $('#div-loading').hide('fast');
    }

    function backCost(l, id) {
        top.document.getElementById('ifrm-cont').src = "Costs.php?l=" + l + "&id=" + id;
    }

    function enterCost(l) {
        var myRadio = $('input[name=cost]');
        var checkedValue = myRadio.filter(':checked').val();
        top.ShowWait()

        var page
        if (checkedValue == "fuel") {
            page = 'Fuel.php?l=' + l + '&cost=1';
        }
        else {
            if (checkedValue == "service") {
                page = 'Service.php?l=' + l + '&cost=1';
            }
            else {
                page = 'OtherCosts.php?l=' + l + '&cost=1';
            }
        }

        top.document.getElementById('ifrm-cont').src = page;
    }
    function LoadData(_i, _j, _equal, _first){
        ShowWait();
        var recTest = 0;

        var page = '';
        var report = '';

	    if (PrevHash == 'menu_1_1') {
	        page = 'Organisation.php?l=' + lang1;
	        report = "";
	    }

	    if (PrevHash == 'menu_1_2') {
	        page = 'Vehicles.php?l=' + lang1;
	        report = "";
	    }

	    if (PrevHash == 'menu_1_3') {
	        page = 'Drivers.php?l=' + lang1;
	        report = "";
	    }

	    if (PrevHash == 'menu_2_1') {
	        page = 'Tires.php?l=' + lang1;
	        report = "";
	    }

	    if (PrevHash == 'menu_2_2') {
	        page = 'CurrKm.php?l=' + lang1;
	        report = "";
	    }

	    if (PrevHash == 'menu_2_3') {
	        page = 'Costs.php?l=' + lang1;
	        report = "";
	    }

	    if (PrevHash == 'menu_3_1') {
	        page = 'ReportTires.php?l=' + lang1;
	        report = "";
	    }

	    if (PrevHash == 'menu_3_2') {
	        page = 'ReportServices.php?l=' + lang1;
	        report = "";
	    }

	    if (PrevHash == 'menu_3_3') {
	        page = 'ReportCosts.php?l=' + lang1;
	        report = "";
	    }

	    if (PrevHash == 'menu_3_4') {
	        page = 'ReportFuel.php?l=' + lang1;
	        report = "";
	    }

	    if (PrevHash == 'menu_3_5') {
	        page = 'Dashboard.php?l=' + lang1;
	        report = "";
	    }

	    if (PrevHash == 'menu_3_6') {
	        page = 'Overview.php?l=' + lang1;
	        report = "";
	    }
	    if (PrevHash == 'menu_4_1') {
	        page = 'AlertTires.php?l=' + lang1;
	        report = "";
	    }

	    if (PrevHash == 'menu_4_2') {
	        page = 'AlertService.php?l=' + lang1;
	        report = "";
	    }

	    if (PrevHash == 'menu_4_3') {
	        page = 'AlertRegistration.php?l=' + lang1;
	        report = "";
	    }

	    var _elID = '#report-content';
	    if (Browser()=='iPad') {_elID='#scroll-cont-div'}

	    document.getElementById('ifrm-cont').src = page;

	    //HideWait();
    }
      
    //add new vehicle (in fmVehicles table)
    function addVehicle() {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "AddNewVehicle.php?lang=" + lang1;
    }

    //add new tires
    function addTires() {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "AddNewTires.php?lang=" + lang1;
    }

    //add new refueling
    function addFuel() {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "AddNewFuel.php?lang=" + lang1;
    }

    //add new service
    function addService(cost) {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "AddNewService.php?lang=" + lang1 + "&cost=" + cost;
    }

    //add new other costs
    function addCost(cost) {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "AddNewCost.php?lang=" + lang1 + "&cost=" + cost;
    }

    //add new al unit
    function addOrgUnit() {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "AddNewOrgUnit.php?lang=" + lang1;
    }

    //add new driver
    function addDriver() {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "AddNewDriver.php?l=" + lang;
    }

    //save changes from Current Km
    function saveChanges1(l) {
        var changes = ""
        var vArr = chVeh.split("*");
        var sorted_arr = vArr.sort();
        var vehNoDupl = [];
        var check = 0;

        for (var i = 0; i < vArr.length - 1; i++) {
            if (sorted_arr[i + 1] != sorted_arr[i]) {
                vehNoDupl.push(sorted_arr[i + 1]);
                changes += sorted_arr[i + 1] + "*" + document.getElementById("txt" + sorted_arr[i + 1]).value + "*" + document.getElementById("dt1_" + sorted_arr[i + 1]).value + ";";
                if (parseInt(document.getElementById("txt" + sorted_arr[i + 1]).value) > 0 && check == 0) {
                    check = 1;
                }
            }
        }

       // if (check == 1) {
	
            top.ShowWait();
            $.ajax({
                url: 'SaveChanges.php?l=' + l + "&changes=" + changes,
                context: document.body,
                success: function (data) {
                    top.document.getElementById('ifrm-cont').src = "CurrKm.php?l=" + l;
                }
            });
      //  }
      //  else {
        //    mymsg(dic("currKm", l))    
//}
    }

    //add allowed driver (in fmVehicleDriver table)
    function del(id, l, table) {
        document.getElementById('div-add').title = dic("delEnt", l);

        var selected = "";

        $.ajax({
            url: 'Delete.php?l=' + lang,
            context: document.body,
            success: function (data) {
                $('#div-add').html(data)
                $('#div-add').dialog({ modal: true, height: 160, width: 330,
                    buttons:
                     [
                     {
                         text: dic("yes", l),
                         click: function () {
                             $.ajax({
                                 url: "DeleteItem.php?id=" + id + "&table=" + "" + table + "",
                                 context: document.body,
                                 success: function (data) {
                                     $(this).dialog("close");
                                     if (table == "organisation") {
                                         top.document.getElementById('ifrm-cont').src = "Organisation.php?l=" + l;
                                     }
                                     if (table == "vehicles") {
                                         top.document.getElementById('ifrm-cont').src = "Vehicles.php?l=" + l;
                                     }
                                     if (table == "drivers") {
                                         top.document.getElementById('ifrm-cont').src = "Drivers.php?l=" + l;
                                     }
                                     if (table == "service") {
                                         top.document.getElementById('ifrm-cont').src = "Service.php?l=" + l;
                                     }
                                     if (table == "costs") {
                                         top.document.getElementById('ifrm-cont').src = "OtherCosts.php?l=" + l;
                                     }
                                 }
                             });
                         }
                     },
                         {
                             text: dic("no", l),
                             click: function () {
                                 $(this).dialog("close");
                             }
                         }

                     ]
                });
            }
        });
   }

   //promena na gumi (letni->zimski; zimski->letni)
   function changeTires(vehID, l, reg) {
       document.getElementById('div-add').title = reg;

       $.ajax({
           url: 'ChangeTires.php?l=' + l + '&vehID=' + vehID,
           context: document.body,
           success: function (data) {
               $('#div-add').html(data)
               $('#div-add').dialog({ modal: true, height: 370, width: 420,
                   buttons:
                     [
                     {
                         text: dic("yes", l),
                         click: function () {
                         var currCum;
                         if (isNaN(parseInt(document.getElementById('currKm' + vehID).value))) {
                            currKm = 0;
                         }
                         else {
                            currKm = document.getElementById('currKm' + vehID).value
                         }

                        var datetime_ = document.getElementById("datetime1_").value;
                        var note = document.getElementById("note").value;
                      
                             $.ajax({
                             url: "UpdateTires.php?vehID=" + vehID + "&currKm=" + currKm + "&datetime_=" + datetime_ + "&note=" + note,
                             context: document.body,
                             success: function (data) {
                                 $(this).dialog("close");
                                 top.document.getElementById('ifrm-cont').src = "Tires.php?l=" + l;
                             }
                             });
                            
                            
                         }
                     },
                         {
                             text: dic("no", l),
                             click: function () {
                                 $(this).dialog("close");
                             }
                         }

                     ]
               });
           }
       });
         }

         //refueling
         function refuel(id, reg, l) {

             document.getElementById('div-add').title = reg;

             $.ajax({
                 url: 'AddFuel.php?l=' + l + '&id=' + id,
                 context: document.body,
                 success: function (data) {
                     $('#div-add').html(data)
                     $('#div-add').dialog({ modal: true, height: 320, width: 450,
                         buttons:
                     [
                     {
                         text: dic("add", l),
                         click: function () {
                             top.ShowWait();

                            var dt = document.getElementById("datetime").value;
                            var driver = document.getElementById("driver").value;
                            var km = document.getElementById("km").value;
                            var liters = document.getElementById("liters").value;
                            var litersLast = document.getElementById("litersLast").value;
                            var price = document.getElementById("price").value;

                          
                            $.ajax({
                                url: "InsertFuel.php?dt=" + dt + "&driver=" + driver + "&km=" + km + "&liters=" + liters + "&litersLast=" + litersLast + "&price=" + price + "&vehID=" + id,
                                context: document.body,
                                success: function (data) {
                                    top.document.getElementById('ifrm-cont').src = "Fuel.php?l=" + l;
                                }
                            });

                         }
                     },
                         {
                             text: dic("cancel", l),
                             click: function () {
                                 $(this).dialog("close");
                                 top.ShowWait();
                                 top.document.getElementById('ifrm-cont').src = "Fuel.php?l=" + l;
                             }
                         }

                     ]
                     });
                 }
             });
         }
         //stavanje na novi gumi (tires = 0 -> zimski; tires = 1 -> letni)
         function newTires(vehID, l, tires, reg) {

             document.getElementById('div-add').title = reg;

             $.ajax({
                 url: 'NewTires.php?l=' + l + '&vehID=' + vehID + "&tires=" + tires,
                 context: document.body,
                 success: function (data) {
                     $('#div-add').html(data)
                     $('#div-add').dialog({ modal: true, height: 340, width: 420,
                         buttons:
                     [
                     {
                         text: dic("yes", l),
                         click: function () {
                             var currCum;
                             if (isNaN(parseInt(document.getElementById('currKmNew' + vehID).value))) {
                                 currKm = 0;
                             }
                             else {
                                 currKm = document.getElementById('currKmNew' + vehID).value
                             }

                             var datetime_ = document.getElementById("datetime_").value;
                             var note = document.getElementById('note').value;
                         
                             $.ajax({    	
                                 url: "InsertTires.php?vehID=" + vehID + "&tires=" + tires + "&currKmNew=" + currKm + "&datetime_=" + datetime_ + "&note=" + note,
                                 context: document.body,
                                 success: function (data) {
                                     $(this).dialog("close");
                                     top.document.getElementById('ifrm-cont').src = "Tires.php?l=" + l;
                                 }
                             });


                         }
                     },
                         {
                             text: dic("no", l),
                             click: function () {
                                 $(this).dialog("close");
                             }
                         }

                     ]
                     });
                 }
             });
         }

    //add new driver (in fmDrivers table)
    function addDriver() {
        top.ShowWait();
        top.document.getElementById('ifrm-cont').src = "AddNewDriver.php?l=" + lang;
    }
    //add new al unit
    function addOrgUnit_(l) {
        document.getElementById('div-add').title = dic("addOrgUnit", l);
        $.ajax({
            url: 'AddNewOrgUnit.php?l=' + l,
            context: document.body,
            success: function (data) {
                $('#div-add').html(data)
                $('#div-add').dialog({ modal: true, height: 280, width: 455,
                    buttons:
                     [
                     {
                         text: dic("add", l),
                         click: function () {
                             top.ShowWait();

                             var kod = document.getElementById("code").value;
                             var orgUnit = document.getElementById("orgUnit").value;
                             var desc = document.getElementById("desc").value;

                             $.ajax({
                                 url: "InsertOrgUnit.php?kod=" + kod + "&orgUnit=" + orgUnit + "&desc=" + desc,
                                 context: document.body,
                                 success: function (data) {
                                     top.document.getElementById('ifrm-cont').src = "Organisation.php?l=" + '<?php echo $cLang?>';
                                 }
                             }); 
                         }
                     },
                         {
                             text: dic("cancel", l),
                             click: function () {

                                 top.ShowWait();
                                 top.document.getElementById('ifrm-cont').src = "Organisation.php?l=" + l;

                                 $(this).dialog("close");
                             }
                         }

                     ]
                });
            }
        });
    }

    //modify al unit
    function modifyUnit_(i, id, l) {
        document.getElementById('div-add').title = dic("modOrgUnit", l);
        
        $.ajax({
            url: 'ModifyOrgUnit.php?id=' + id + '&l=' + l, 
            context: document.body,
            success: function (data) {
                $('#div-add').html(data)
                $('#div-add').dialog({ modal: true, height: 280, width: 455,
                    buttons:
                     [
                     {
                         text: dic("change", l),
                         click: function () {
                             top.ShowWait();

                             var code = document.getElementById("code").value;
                             var name = document.getElementById("name").value;
                             var desc = document.getElementById("desc").value;

                             
                             $.ajax({
                                 url: "UpdateOrgUnit.php?code=" + code + "&name=" + name + "&desc=" + desc + "&id=" + id,
                                 context: document.body,
                                 success: function (data) {
                                     top.document.getElementById('ifrm-cont').src = "Organisation.php?l=" + '<?php echo $cLang?>';
                                 }
                             }); 
                         }
                     },
                         {
                             text: dic("cancel", l),
                             click: function () {

                                 top.ShowWait();
                                 top.document.getElementById('ifrm-cont').src = "Organisation.php?l=" + l;

                                 $(this).dialog("close");
                             }
                         }

                     ]
                });
            }
        });
         }
   
    
   
