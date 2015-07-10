


function addAlerts() {
    document.getElementById('div-add-alerts').title = dic("Settings.AddAlerts");
    $('#div-add-alerts').dialog({
        modal: true,
        width: 590,
        height: 500,
        resizable: false,
        buttons: [{
            text: dic('Settings.Add', lang),
            click: function(data) {
                var tipNaAlarm = $('#TipNaAlarm').val();

                var email = $('#emails').val();
                var sms = '';
                if ('<?php echo $clienttypeid ?>' == 6) sms = $('#sms').val();
                var zvukot = $('#zvukot').val();
                var ImeNaTocka = $('#combobox').val();
                var ImeNaTockaProverka = document.getElementById('combobox').selectedIndex;
                var ImeNaZonaIzlez = $('#comboboxIzlez').val();
                var ImeNaZonaIzlezProverka = document.getElementById('comboboxIzlez').selectedIndex;
                var ImeNaZonaVlez = $('#comboboxVlez').val();
                var ImeNaZonaVlezProverka = document.getElementById('comboboxVlez').selectedIndex;
                var orgEdinica = $('#oEdinica').val();
                var odbraniVozila = $("#vozila option:selected").val(); //document.getElementById('vozila').selectedIndex;
                var NadminataBrzina = $('#brzinata').val();
                var vreme = tipNaAlarm;
                var alarmSelect = document.getElementById('TipNaAlarm').selectedIndex;
                var voziloOdbrano = $('#voziloOdbrano').val();
                var dostapno = getCheckedRadio('radio');

                ///////////////////////////

                if (alarmSelect == 28 && ($('#remindKm').is(':checked') === false && $('#remindDays').is(':checked') === false)) {
                    msgboxPetar(dic("Settings.RemindMeMustOne", lang));
                } else {
                    var remindme = '';
                    if (alarmSelect == 27 || alarmSelect == 28 || alarmSelect == 29 || alarmSelect == 30) {
                        var fmvalueDays = "";
                        if (alarmSelect == 28) {
                            if ($('#remindDays').is(':checked')) {
                                fmvalueDays = $('#fmvalueDays').val() + " days";
                            }
                        } else {
                            if ($('#fmvalueDays').val() !== "") {
                                fmvalueDays = $('#fmvalueDays').val() + " days";
                            }
                        }
                        var fmvalueKm = "";
                        if ($('#rmdKm').css('display') != 'none') {
                            if (alarmSelect == 28) {
                                if ($('#remindKm').is(':checked')) {
                                    if (fmvalueDays !== "") fmvalueKm += "; " + Math.round($('#fmvalueKm').val() / Number('<?php echo $value ?>') ) + " Km";
                                    else fmvalueKm = Math.round($('#fmvalueKm').val() / Number('<?php echo $value ?>') ) + " Km";
                                }
                            } else {
                                if ($('#fmvalueKm').val() !== "") {
                                    if (fmvalueKm !== "") fmvalueKm += "; " + Math.round($('#fmvalueKm').val() / Number('<?php echo $value ?>') ) + " Km";
                                    else fmvalueKm = Math.round($('#fmvalueKm').val() / Number('<?php echo $value ?>') ) + " Km";
                                }
                            }
                        }
                        remindme = fmvalueDays + fmvalueKm;
                    }
                    ///////////////////////////////////////
                    if (email === '' && sms === '') {
                        msgboxPetar(dic("Settings.AlertsEmailHaveTo", lang));
                    } else {
                        if (email.length > 0 && !validacija()) {
                            msgboxPetar(dic("uncorrEmail", lang));
                        } else {
                            if (odbraniVozila === 0) {
                                msgboxPetar(dic("Settings.SelectAlert1", lang));
                                    //alert("Треба да одберете за што сакате да внесете аларм");
                            } else {
                                if (alarmSelect == 13) {
                                    if (ImeNaTockaProverka === "") {
                                        msgboxPetar(dic("Settings.SelectPOI2", lang));
                                        exit;
                                    }
                                    if (vreme === "") {
                                        msgboxPetar(dic("Settings.InsertRetTime", lang));
                                        exit;
                                    }
                                    if (sms !== "") {
                                        document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS", lang);
                                        $('#div-tip-praznik').dialog({
                                            modal: true,
                                            width: 300,
                                            height: 230,
                                            resizable: false,
                                            buttons: [{
                                                text: dic("Reports.Confirm"),
                                                click: function() {
                                                    pass = encodeURIComponent($('#dodTipPraznik').val());
                                                    tipPraznikID = document.getElementById("dodTipPraznik");
                                                    if (pass === "") {
                                                        msgboxPetar(dic("Settings.InsertPass", lang));
                                                        tipPraznikID.focus();
                                                    } else {
                                                        $.ajax({
                                                            url: "checkPassword2.php?pass=" + pass + "&l=" + lang,
                                                            context: document.body,
                                                            success: function(data) {
                                                                if (data == 1) {
                                                                    /*alert("AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila)*/
                                                                    msgboxPetar(dic("Settings.VaildPassSucAlert", lang));
                                                                        //alert("AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme)
                                                                    $.ajax({
                                                                        url: "AddAlert2.php?tipNaAlarm=" + tipNaAlarm + "&email=" + email + "&sms=" + sms + "&zvukot=" + zvukot + "&ImeNaTocka=" + ImeNaTocka + "&ImeNaZonaIzlez=" + ImeNaZonaIzlez + "&ImeNaZonaVlez=" + ImeNaZonaVlez + "&NadminataBrzina=" + NadminataBrzina + "&vreme=" + vreme + "&dostapno=" + dostapno + "&orgEdinica=" + orgEdinica + "&odbraniVozila=" + odbraniVozila + "&voziloOdbrano=" + voziloOdbrano + "&remindme=" + remindme,
                                                                        context: document.body,
                                                                        success: function(data) {
                                                                            window.location.reload();
                                                                        }
                                                                    });
                                                                } else {
                                                                    msgboxPetar(dic("Settings.Incorrectpass", lang))
                                                                    exit;
                                                                }
                                                            }
                                                        });
                                                    }
                                                }
                                            }, {
                                                text: dic("Fm.Cancel", lang),
                                                click: function() {
                                                    $(this).dialog("close");
                                                }
                                            }]
                                        })
                                    } else {
                                        $.ajax({
                                            url: "AddAlert2.php?tipNaAlarm=" + tipNaAlarm + "&email=" + email + "&sms=" + sms + "&zvukot=" + zvukot + "&ImeNaTocka=" + ImeNaTocka + "&ImeNaZonaIzlez=" + ImeNaZonaIzlez + "&ImeNaZonaVlez=" + ImeNaZonaVlez + "&NadminataBrzina=" + NadminataBrzina + "&vreme=" + vreme + "&dostapno=" + dostapno + "&orgEdinica=" + orgEdinica + "&odbraniVozila=" + odbraniVozila + "&voziloOdbrano=" + voziloOdbrano + "&remindme=" + remindme,
                                            context: document.body,
                                            success: function(data) {
                                                msgboxPetar(dic("Settings.SuccAdd", lang))
                                                window.location.reload();
                                            }
                                        });
                                    }
                                } else {
                                    if (alarmSelect == 12) {
                                        if (ImeNaZonaIzlezProverka == "") {
                                            msgboxPetar(dic("Settings.SelectExitGeoF", lang))
                                            exit
                                        }
                                        if (sms != "") {
                                            document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS", lang)
                                            $('#div-tip-praznik').dialog({
                                                modal: true,
                                                width: 300,
                                                height: 230,
                                                resizable: false,
                                                buttons: [{
                                                    text: dic("Reports.Confirm"),
                                                    click: function() {
                                                        pass = encodeURIComponent($('#dodTipPraznik').val());
                                                        tipPraznikID = document.getElementById("dodTipPraznik");
                                                        if (pass == "") {
                                                            msgboxPetar(dic("Settings.InsertPass", lang))
                                                            tipPraznikID.focus();
                                                        } else {
                                                            $.ajax({
                                                                url: "checkPassword2.php?pass=" + pass + "&l=" + lang,
                                                                context: document.body,
                                                                success: function(data) {
                                                                    if (data == 1) {
                                                                        msgboxPetar(dic("Settings.VaildPassSucAlert", lang))
                                                                            //alert("AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme)
                                                                        $.ajax({
                                                                            url: "AddAlert2.php?tipNaAlarm=" + tipNaAlarm + "&email=" + email + "&sms=" + sms + "&zvukot=" + zvukot + "&ImeNaTocka=" + ImeNaTocka + "&ImeNaZonaIzlez=" + ImeNaZonaIzlez + "&ImeNaZonaVlez=" + ImeNaZonaVlez + "&NadminataBrzina=" + NadminataBrzina + "&vreme=" + vreme + "&dostapno=" + dostapno + "&orgEdinica=" + orgEdinica + "&odbraniVozila=" + odbraniVozila + "&voziloOdbrano=" + voziloOdbrano + "&remindme=" + remindme,
                                                                            context: document.body,
                                                                            success: function(data) {
                                                                                window.location.reload();
                                                                            }
                                                                        });
                                                                    } else {
                                                                        msgboxPetar(dic("Settings.Incorrectpass", lang));
                                                                        exit;
                                                                    }
                                                                }
                                                            });
                                                        }
                                                    }
                                                }, {
                                                    text: dic("Fm.Cancel", lang),
                                                    click: function() {
                                                        $(this).dialog("close");
                                                    }
                                                }]
                                            })
                                        } else {
                                            $.ajax({
                                                url: "AddAlert2.php?tipNaAlarm=" + tipNaAlarm + "&email=" + email + "&sms=" + sms + "&zvukot=" + zvukot + "&ImeNaTocka=" + ImeNaTocka + "&ImeNaZonaIzlez=" + ImeNaZonaIzlez + "&ImeNaZonaVlez=" + ImeNaZonaVlez + "&NadminataBrzina=" + NadminataBrzina + "&vreme=" + vreme + "&dostapno=" + dostapno + "&orgEdinica=" + orgEdinica + "&odbraniVozila=" + odbraniVozila + "&voziloOdbrano=" + voziloOdbrano + "&remindme=" + remindme,
                                                context: document.body,
                                                success: function(data) {
                                                    msgboxPetar(dic("Settings.SuccAdd", lang));
                                                    window.location.reload();
                                                }
                                            });
                                        }
                                    } else {
                                        if (alarmSelect == 11) {
                                            if (ImeNaZonaVlezProverka == "") {
                                                msgboxPetar(dic("Settings.SelectEnterGeoF", lang));
                                                exit
                                            }
                                            if (sms != "") {
                                                document.getElementById('div-tip-praznik').title = dic(dic("Settings.ConfSMS", lang))
                                                $('#div-tip-praznik').dialog({
                                                    modal: true,
                                                    width: 300,
                                                    height: 230,
                                                    resizable: false,
                                                    buttons: [{
                                                        text: dic("Reports.Confirm"),
                                                        click: function() {
                                                            pass = encodeURIComponent($('#dodTipPraznik').val());
                                                            tipPraznikID = document.getElementById("dodTipPraznik");
                                                            if (pass == "") {
                                                                msgboxPetar(dic("Settings.InsertPass", lang))
                                                                tipPraznikID.focus();
                                                            } else {
                                                                $.ajax({
                                                                    url: "checkPassword2.php?pass=" + pass + "&l=" + lang,
                                                                    context: document.body,
                                                                    success: function(data) {
                                                                        if (data == 1) {
                                                                            msgboxPetar(dic("Settings.VaildPassSucAlert", lang))
                                                                                //alert("AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme)
                                                                            $.ajax({
                                                                                url: "AddAlert2.php?tipNaAlarm=" + tipNaAlarm + "&email=" + email + "&sms=" + sms + "&zvukot=" + zvukot + "&ImeNaTocka=" + ImeNaTocka + "&ImeNaZonaIzlez=" + ImeNaZonaIzlez + "&ImeNaZonaVlez=" + ImeNaZonaVlez + "&NadminataBrzina=" + NadminataBrzina + "&vreme=" + vreme + "&dostapno=" + dostapno + "&orgEdinica=" + orgEdinica + "&odbraniVozila=" + odbraniVozila + "&voziloOdbrano=" + voziloOdbrano + "&remindme=" + remindme,
                                                                                context: document.body,
                                                                                success: function(data) {
                                                                                    window.location.reload();
                                                                                }
                                                                            });
                                                                        } else {
                                                                            msgboxPetar(dic("Settings.Incorrectpass", lang))
                                                                            exit;
                                                                        }
                                                                    }
                                                                });
                                                            }
                                                        }
                                                    }, {
                                                        text: dic("Fm.Cancel", lang),
                                                        click: function() {
                                                            $(this).dialog("close");
                                                        }
                                                    }]
                                                })
                                            } else {
                                                $.ajax({
                                                    url: "AddAlert2.php?tipNaAlarm=" + tipNaAlarm + "&email=" + email + "&sms=" + sms + "&zvukot=" + zvukot + "&ImeNaTocka=" + ImeNaTocka + "&ImeNaZonaIzlez=" + ImeNaZonaIzlez + "&ImeNaZonaVlez=" + ImeNaZonaVlez + "&NadminataBrzina=" + NadminataBrzina + "&vreme=" + vreme + "&dostapno=" + dostapno + "&orgEdinica=" + orgEdinica + "&odbraniVozila=" + odbraniVozila + "&voziloOdbrano=" + voziloOdbrano + "&remindme=" + remindme,
                                                    context: document.body,
                                                    success: function(data) {
                                                        msgboxPetar(dic("Settings.SuccAdd", lang))
                                                        window.location.reload();
                                                    }
                                                });
                                            }
                                        } else {
                                            if (alarmSelect == 10) {
                                                if (NadminataBrzina == "") {
                                                    msgboxPetar(dic("Settings.InsertSpeedOver", lang))
                                                }
                                                if (sms != "") {
                                                    document.getElementById('div-tip-praznik').title = dic("Settings.ConfSMS", lang)
                                                    $('#div-tip-praznik').dialog({
                                                        modal: true,
                                                        width: 300,
                                                        height: 230,
                                                        resizable: false,
                                                        buttons: [{
                                                            text: dic("Reports.Confirm"),
                                                            click: function() {
                                                                pass = encodeURIComponent($('#dodTipPraznik').val());
                                                                tipPraznikID = document.getElementById("dodTipPraznik");
                                                                if (pass == "") {
                                                                    msgboxPetar(dic("Settings.InsertPass", lang))
                                                                    tipPraznikID.focus();
                                                                } else {
                                                                    $.ajax({
                                                                        url: "checkPassword2.php?pass=" + pass + "&l=" + lang,
                                                                        context: document.body,
                                                                        success: function(data) {
                                                                            if (data == 1) {
                                                                                msgboxPetar(dic("Settings.VaildPassSucAlert", lang))
                                                                                    //alert("AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme)
                                                                                $.ajax({
                                                                                    url: "AddAlert2.php?tipNaAlarm=" + tipNaAlarm + "&email=" + email + "&sms=" + sms + "&zvukot=" + zvukot + "&ImeNaTocka=" + ImeNaTocka + "&ImeNaZonaIzlez=" + ImeNaZonaIzlez + "&ImeNaZonaVlez=" + ImeNaZonaVlez + "&NadminataBrzina=" + NadminataBrzina + "&vreme=" + vreme + "&dostapno=" + dostapno + "&orgEdinica=" + orgEdinica + "&odbraniVozila=" + odbraniVozila + "&voziloOdbrano=" + voziloOdbrano + "&remindme=" + remindme,
                                                                                    context: document.body,
                                                                                    success: function(data) {
                                                                                        window.location.reload();
                                                                                    }
                                                                                });
                                                                            } else {
                                                                                msgboxPetar(dic("Settings.Incorrectpass", lang))
                                                                                exit;
                                                                            }
                                                                        }
                                                                    });
                                                                }
                                                            }
                                                        }, {
                                                            text: dic("Fm.Cancel", lang),
                                                            click: function() {
                                                                $(this).dialog("close");
                                                            }
                                                        }]
                                                    })
                                                } else {
                                                    $.ajax({
                                                        url: "AddAlert2.php?tipNaAlarm=" + tipNaAlarm + "&email=" + email + "&sms=" + sms + "&zvukot=" + zvukot + "&ImeNaTocka=" + ImeNaTocka + "&ImeNaZonaIzlez=" + ImeNaZonaIzlez + "&ImeNaZonaVlez=" + ImeNaZonaVlez + "&NadminataBrzina=" + NadminataBrzina + "&vreme=" + vreme + "&dostapno=" + dostapno + "&orgEdinica=" + orgEdinica + "&odbraniVozila=" + odbraniVozila + "&voziloOdbrano=" + voziloOdbrano + "&remindme=" + remindme,
                                                        context: document.body,
                                                        success: function(data) {
                                                            msgboxPetar(dic("Settings.SuccAdd", lang))
                                                            window.location.reload();
                                                        }
                                                    });
                                                }
                                            } else {
                                                if (sms != "") {
                                                    document.getElementById('div-tip-praznik').title = dic(dic("Settings.ConfSMS", lang))
                                                    $('#div-tip-praznik').dialog({
                                                        modal: true,
                                                        width: 300,
                                                        height: 230,
                                                        resizable: false,
                                                        buttons: [{
                                                            text: dic("Reports.Confirm"),
                                                            click: function() {
                                                                pass = encodeURIComponent($('#dodTipPraznik').val());
                                                                tipPraznikID = document.getElementById("dodTipPraznik");
                                                                if (pass == "") {
                                                                    msgboxPetar(dic("Settings.InsertPass", lang))
                                                                    tipPraznikID.focus();
                                                                } else {
                                                                    $.ajax({
                                                                        url: "checkPassword2.php?pass=" + pass + "&l=" + lang,
                                                                        context: document.body,
                                                                        success: function(data) {
                                                                            if (data == 1) {
                                                                                msgboxPetar(dic("Settings.VaildPassSucAlert", lang))
                                                                                    //alert("AddAlert2.php?tipNaAlarm="+tipNaAlarm+"&email="+email+"&sms="+sms+"&zvukot="+zvukot+"&ImeNaTocka="+ImeNaTocka+"&ImeNaZonaIzlez="+ImeNaZonaIzlez+"&ImeNaZonaVlez="+ImeNaZonaVlez+"&NadminataBrzina="+NadminataBrzina+"&vreme="+vreme+"&dostapno="+dostapno+"&orgEdinica="+orgEdinica +"&odbraniVozila="+odbraniVozila+"&voziloOdbrano="+voziloOdbrano+"&remindme="+remindme)
                                                                                $.ajax({
                                                                                    url: "AddAlert2.php?tipNaAlarm=" + tipNaAlarm + "&email=" + email + "&sms=" + sms + "&zvukot=" + zvukot + "&ImeNaTocka=" + ImeNaTocka + "&ImeNaZonaIzlez=" + ImeNaZonaIzlez + "&ImeNaZonaVlez=" + ImeNaZonaVlez + "&NadminataBrzina=" + NadminataBrzina + "&vreme=" + vreme + "&dostapno=" + dostapno + "&orgEdinica=" + orgEdinica + "&odbraniVozila=" + odbraniVozila + "&voziloOdbrano=" + voziloOdbrano + "&remindme=" + remindme,
                                                                                    context: document.body,
                                                                                    success: function(data) {
                                                                                        window.location.reload();
                                                                                    }
                                                                                });
                                                                            } else {
                                                                                msgboxPetar(dic("Settings.Incorrectpass", lang))
                                                                                exit;
                                                                            }
                                                                        }
                                                                    });
                                                                }
                                                            }
                                                        }, {
                                                            text: dic("Fm.Cancel", lang),
                                                            click: function() {
                                                                $(this).dialog("close");
                                                            }
                                                        }]
                                                    })
                                                } else {
                                                    $.ajax({
                                                        url: "AddAlert2.php?tipNaAlarm=" + tipNaAlarm + "&email=" + email + "&sms=" + sms + "&zvukot=" + zvukot + "&ImeNaTocka=" + ImeNaTocka + "&ImeNaZonaIzlez=" + ImeNaZonaIzlez + "&ImeNaZonaVlez=" + ImeNaZonaVlez + "&NadminataBrzina=" + NadminataBrzina + "&vreme=" + vreme + "&dostapno=" + dostapno + "&orgEdinica=" + orgEdinica + "&odbraniVozila=" + odbraniVozila + "&voziloOdbrano=" + voziloOdbrano + "&remindme=" + remindme,
                                                        context: document.body,
                                                        success: function(data) {
                                                            msgboxPetar(dic("Settings.SuccAdd", lang))
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
                }  // els
            }
        }, {
            text: dic('cancel', lang),
            click: function() {
                $(this).dialog("close");
            }
        }, {
            text: "test",
            click: function() {
                console.log($('#TipNaAlarm').val());
            }
        }
        ]
    });
}