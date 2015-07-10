<?php include "./include/functions.php" ?>
<?php include "./include/db.php" ?>
<?php include "./include/params.php" ?>
<?php include "./include/dictionary1.php" ?>

<?php header("Content-type: text/html; charset=utf-8")?>
<?php
	
	opendb();
	$uid = getQUERY("uid");
	if(is_numeric($uid))
	{
		$ruser = query("select u.id, u.roleid, u.clientid, u.fullname, (select name from clients where id=u.clientid) clientname from users u where u.id=".$uid);
		
		$_SESSION['user_id']= pg_fetch_result($ruser, 0, 'id');
		$_SESSION['role_id']= pg_fetch_result($ruser, 0, 'roleid');
		$_SESSION['client_id']= pg_fetch_result($ruser, 0, 'clientid');
		$_SESSION['user_fullname']= pg_fetch_result($ruser, 0, 'fullname');
		$_SESSION['company']= pg_fetch_result($ruser, 0, 'clientname');
		$_SESSION['emailflag'] = dlookup("select emailflag from users where id=" . $uid); // novo
		echo header('Location: ./?l=' . $cLang);
	}
	
	//header("Content-type: text/html; charset=utf-8");
	if (session('user_id') == "261" or session('user_id') == "779" or session('user_id') == "780" or session('user_id') == "781" or session('user_id') == "776" or session('user_id') == "777" or session('user_id') == "782" or session('user_id') == "778") echo header( 'Location: ./sessionexpired/?l='.$cLang);
	//Ispituvame dali ima najaven korisnik. Ako nema mora da se odi na Login
	
	if (!is_numeric(session('user_id'))) echo header( 'Location: ./login/?l='.$cLang);
	
	$directlive = 0;//dlookup("select directlive from users where id=" . session("user_id"));

	
	$sql_ = "";
	$sqlV = "";
	if ($_SESSION['role_id'] == "2") {
		$sql_ = "select * from vehicles where id in (select id from vehicles where clientID=" . session("client_id") .  ") order by code asc";
		$sqlV = "select id from vehicles where clientID=" . session("client_id") ;
	} else {
		$sql_ = "select * from vehicles where id in (select vehicleid from uservehicles where userid=" . session("user_id") . ") order by code asc";
		$sqlV = "select vehicleID from uservehicles where userID=" . session("user_id") . "" ;
	}
    $firstVehId = pg_fetch_result(query($sql_), 0, "id");
	
	$err = getQUERY("err");
	

	$snooze = dlookup("select snooze from users where id=" . session("user_id"));
	
	$filename = './images/upload/' . session("client_id") . '.png';
	$picload = 'profile.png';
	if (file_exists($filename)) {
	    $picload = session("client_id") . '.png';
	}
	$AllowViewLiveTracking = getPriv("livetracking", session("user_id"));
	$AllowViewFm = getPriv("fm", session("user_id"));
	$AllowViewRoutes = getPriv("routes", session("user_id"));
	$AllowViewReports = getPriv("reports", session("user_id"));
	$AllowViewSettings = getPriv("settings", session("user_id"));
	
	$ds = query("select  allowedrouting, allowedfm, allowedmess, allowedalarms, clienttypeid from clients where id=" . session("client_id"));
	$allowedR = pg_fetch_result($ds, 0, "allowedrouting");
	
	$allowedFM = pg_fetch_result($ds, 0, "allowedfm");
	$allowedMess = pg_fetch_result($ds, 0, "allowedmess");
	$allowedAlarms = pg_fetch_result($ds, 0, "allowedalarms");
		
	$tv = '';
	$tv1 = '';
	$tv2 = 'display: none;';
	$mess = '';
	$mess1 = '';
	$al = '';
	$al1 = '';
	$al2 = '';
	
	$lt = '';
	$lt1 = '';
	$fm = '';
	$fm1 = '';
	
	$reports = '';
	$reports1 = '';
	$settings = '';
	$settings1 = '';
	$routes = '';
	$routes1 = '';
	$routes2 = 'display: none;';
	
	if(true)
	{
		$tv = 'return false;';
		$tv1 = 'opacity: 0.4;';
		$tv2 = 'display: block;';
	}
	
	if(!$AllowViewLiveTracking)
	{
		$lt = 'return false;';
		$lt1 = 'opacity: 0.5;';
	}
	if(!$AllowViewReports)
	{
		$reports = 'return false;';
		$reports1 = 'opacity: 0.5;';
	}
	if(!$AllowViewSettings)
	{
		$settings = 'return false;';
		$settings1 = 'opacity: 0.5;';
	}
	
	if(!$allowedFM)
	{
		$fm = 'return false;';
		$fm1 = 'opacity: 0.5;';
	}
	
	if(!$allowedMess)
	{
		$mess = 'return false;';
		$mess1 = 'opacity: 0.4;';
	}
	if(!$allowedAlarms)
	{
		$al = 'return false;';
		$al1 = 'opacity: 0.4;';
		$al2 = 'display: none;';
	}
	
	if(!$allowedR)
	{
		$routes = 'return false;';
		$routes1 = 'opacity: 0.5;';
		$routes2 = 'display: block;';
	}
	
	if($cLang == "al")
		$language = 'Shqip';
	else
		if($cLang == "en")
			$language = 'English';
		else
			if($cLang == "fr")
				$language = 'Français';
			else
				$language = 'Македонски';
	
	
?>

<html>
<head>

	<script>
		lang = '<?php echo $cLang?>';
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Panorama - Geonet GPS Fleet Management Solution</title>
	<link rel="stylesheet" type="text/css" href="./style.css">
	<link rel="stylesheet" type="text/css" href="./css/ui-lightness/jquery-ui-1.8.14.custom.css">
	<LINK REL="SHORTCUT ICON" HREF="./images/icon.ico">
	<link rel="apple-touch-icon" href="panoramaIcon.png" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="./js/share.js"></script>
	<script type="text/javascript" src="./js/roundIE.js"></script>
	<script type="text/javascript" src="./js/jquery-ui.js"></script>
	<script type="text/javascript" src="./js/core.js"></script>
	<script type="text/javascript" src="./js/csscoordinates.js"></script>
	<script type="text/javascript" src="./js/displaycontroller.js"></script>
	<script type="text/javascript" src="./js/placementcalculator.js"></script>
	<script type="text/javascript" src="./js/tooltipcontroller.js"></script>
	<script type="text/javascript" src="./js/utility.js"></script>
	<script type="text/javascript" src="./main/main.js"></script>
	<script type="text/javascript" src="./tracking/live.js"></script>
	<script type="text/javascript" src="./tracking/live1.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/jquery.powertip-blue.css" />
	<script src="./js/jquery-ui-timepicker-addon.js" type="text/javascript"></script>

	<script type="text/javascript" src="./js/toastr.js"></script>
	<link rel="stylesheet" type="text/css" href="./css/toastr.css" />

</head>
<body onResize="setElementToCenter()">
	
	<div id="dialog-map" style="display:none; z-index: 9999" title="<?php echo dic_("Reports.ViewOnMap")?>"></div>
<audio id="soundHandle" loop="loop" style="display: none;"></audio>
<div id="div-costMain" style="display:none" title="<?php echo dic("Reports.AddingCost")?>"></div>
<div id="div-showMessage" style="display:none" title="<?php echo dic("Routes.ShowMessages")?>"></div>
<div id="div-costnewMain" style="display:none" title="<?php echo dic("Reports.AddingNewCost")?>"></div>
<div id="div-locMain" style="display:none" title="<?php echo dic("Reports.AddNewExecutor")?>"></div>
<div id="div-compMain" style="display:none" title="<?php echo dic("Reports.AddNewComponent")?>"></div>
<div id="div-mainalerts" onMouseOver="clearTimeOutAlertView()" onMouseOut="setTimeOutAlertView()" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; border: 0px; right: 35px; float: right; position: absolute; z-index: 9999; top: 43px; width: 315px; overflow-x: hidden; overflow-y: auto;"></div>
<div id="div-delComp" style="display:none" title="<?php echo dic("Reports.DelComp")?>"></div>
<div id="div-del-cost" style="display:none" title="Бришење на трошок"></div>
	
	<div id="main-blue-track"></div>
	<div id="main-container">
		<img id="img-logo" src="./images/GeonetLogo.png" style="margin-top: 20px;" alt="" />
		<div id="div-advert" class="textTitle">
			<img id="img-log1" src="./images/PanoramaLogo.1.png" align="right" style="" alt="" /><br><br><br>
			<div style="line-height: 25px; position: relative; top: -7;"><?php dic("Login.Title")?><br>
		    <span class="text1"><?php dic("Login.Description")?></span></div>
		</div>
		<div id="div-lang">
			<!--a id="icon-mk" href="./?l=mk"><img src="./images/mk.png" width="30" height="30" border="0" align="absmiddle" style=""/></a>&nbsp;&nbsp;&nbsp;
			<a id="icon-en" href="./?l=en"><img src="./images/en.png" width="30" height="30" border="0" align="absmiddle"/></a>&nbsp;&nbsp;&nbsp;
			<a id="icon-fr" href="./?l=fr"><img src="./images/fr.png" width="30" height="30" border="0" align="absmiddle"/></a>&nbsp;&nbsp;&nbsp;
			<a id="icon-al" href="./?l=al"><img src="./images/al.png" width="30" height="30" border="0" align="absmiddle"/></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-->
			<a id="icon-alert" style="position: relative; left: 15px; margin-left: -10px;<?php echo $al1?>">
				<img width="30" height="30" src="./images/warning2.png" onclick="<?php echo $al?>ShowHideAlerts()" border="0" align="absmiddle" style="cursor: pointer;" />
				<span id="alertsNew" class="notify corner5"  style="visibility: hidden; top: -11px"  disabled onclick="<?php echo $al?>ShowHideAlerts()">0</span>
				<!--input id="alertsNew" class="notify corner5" onclick="ShowHideAlerts()" style="visibility: hidden;" value="0" disabled /-->
			</a>&nbsp;
			<a id="icon-mail" style="position: relative; left: 15px; margin-left: -10px;<?php echo $mess1?>">
				<img width="30" height="30" src="./images/mail2.png" onclick="<?php echo $mess?>ShowHideMail()" border="0" align="absmiddle" style="cursor: pointer;" />
				<span id="mailNew" class="notify corner5"  style="visibility: hidden; top: -11px"  disabled onclick="ShowHideMail()">0</span>
				<!--input id="mailNew" class="notify corner5" onclick="ShowHideMail()" style="visibility: hidden;" value="0" disabled /-->
			</a>&nbsp;
			<a id="icon-costs" style="position: relative; left: 15px; margin-left: -10px;<?php echo $fm1?>">
				<img width="30" height="30" src="./images/cost.png" onclick="<?php echo $fm?>costVehicle123('1', '<?php echo $firstVehId?>', 'SK-0001-AB')" border="0" align="absmiddle" style="cursor: pointer;" />
				<input readonly id="costNew" class="notify corner5" onclick="ShowHideMail()" style="visibility: hidden; top: -11px" value="0" disabled />
			</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a id="icon-sett" href="./settings/?l=<?php echo $cLang?>"><img src="./images/settings.png" width="30" height="30" border="0" align="absmiddle"/></a>&nbsp;&nbsp;&nbsp;
			<a id="icon-help"><img src="./images/help.png" width="30" height="30" border="0" align="absmiddle"/></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a id="icon-logout" href="./logout/?l=<?php echo $cLang?>"><img src="./images/exitNew1.png" width="30" height="30" border="0" align="absmiddle"/></a>&nbsp;<br>
		</div>
		<div id="div-profile" style=" height:180px;">
            <div id="divUploadProgress" style="padding-top:4px;display:block; height: 93px; width: 107px; background: transparent url('./images/upload/<?php echo $picload?>') no-repeat scroll 0 0;" class="text3">
            </div>
            <div id="loged-user" class="textTitle"><?php echo session("user_fullname")?></div>
			<div id="loged-company" class="text1"><strong><?php echo session("company")?></strong></div>

		</div>
		<a href="./tracking/?l=<?php echo $cLang?>" onclick="<?php echo $lt?>" class="menu corner15" style="left:10px; top:270px;<?php echo $lt1?>">
			<img class="imgMenu" src="./images/map.png" width="64" height="64" border="0" align="absmiddle"/>
			<span class="lbl-menu-text textTitle"><?php echo dic("Main.LiveTitle")?></span>
			<span class="lbl-menu-desc text1"><?php echo dic("Main.Live")?></span>
		</a>
		<a href="./report/?l=<?php echo $cLang?>#rep/menu_1_1" onclick="<?php echo $reports?>" class="menu corner15" style="left:540px; top:270px;<?php echo $reports1?>">
			<img class="imgMenu" src="./images/document.png" width="64" height="64" border="0" align="absmiddle"/>
			<span class="lbl-menu-text textTitle"><?php echo dic("Main.ReportsTitle")?></span>
			<span class="lbl-menu-desc text1"><?php echo dic("Main.Reports")?></span>
		</a>
		<!--a href="./settings/?l=<?php echo $cLang?>" onclick="<?php echo $settings?>" class="menu corner15" style="left:10px; top:370px;<?php echo $settings1?>">
			<img class="imgMenu" src="./images/settings.png" width="64" height="64" border="0" align="absmiddle"/>
			<span class="lbl-menu-text textTitle"><?php echo dic("Main.SettingsTitle")?></span>
			<span class="lbl-menu-desc text1"><?php echo dic("Main.Settings")?></span>
		</a>
		<a href="<?php echo $RootPath?>texts/help.php?l=<?php echo $cLang?>" class="menu corner15" style="left:540px; top:370px;">
			<img class="imgMenu" src="./images/help.png" width="64" height="64" border="0" align="absmiddle"/>
			<span class="lbl-menu-text textTitle"><?php echo dic("Main.HelpTitle")?></span>
			<span class="lbl-menu-desc text1"><?php echo dic("Main.Help")?></span>
		</a-->

		<?php
		//if($allowedF == '1')
		//{
			?>
		<a href="./fm/?l=<?php echo $cLang?>#fm/menu_2_1" onclick="<?php echo $tv?>" class="menu corner15" style="left:540px; top:370px;">
			<img class="imgMenu" src="./images/TV.1.png" width="64" height="64" border="0" align="absmiddle" style="<?php echo $tv1?>" />
			<span class="lbl-menu-text textTitle" style="<?php echo $tv1?>"><?php echo dic_("Panorama.Channel")?></span>
			<span class="lbl-menu-desc text1" style="<?php echo $tv1?>"><?php echo dic_("Panorama.VideoPresentation")?></span>
			<span class="corner5 shadowsmall" style="<?php echo $tv2?>position: relative; float: right; color: white; background-color: green; width: 85px; top: 10px; font-size:12px; font-weight:bold; font-family:Arial; right: -2px; text-align: center;"><?php echo dic_("Comming.Soon")?></span>
		</a>

		<script>
		 	var pass_strength = '<?php echo json_encode($_SESSION["pass_strength"]); ?>';
		 	if (Number(pass_strength) <= 6) {

		 		//$.notify("Ве молиме да ја промените вашата лозика", "info");  #95b1d7

		 		toastr.options ={  "positionClass": "toast-top-right"};
		 		toastr.info("<?php echo dic('Reports.PasswordChange')?>");

		 	}
		</script>



		<a href="./routes/?l=<?php echo $cLang?>" onclick="<?php echo $routes?>" class="menu corner15" style="left:10px; top:370px;">
			<img class="imgMenu" src="./images/Routing.png" width="64" height="64" border="0" align="absmiddle" style="<?php echo $routes1?>" />
			<span class="lbl-menu-text textTitle" style="<?php echo $routes1?>"><?php echo dic("Main.routess")?></span>
			<span class="lbl-menu-desc text1" style="<?php echo $routes1?>"><?php echo dic("Main.routess1")?></span>
			<!--span class="corner5 rotate shadowsmall" style="<?php echo $routes2?>position: relative; float: right; color: white; background-color: red; width: 80px; top: 10px; right: -20px; text-align: center;"><?php echo dic_("Login.PRo")?></span-->
		</a>
		<?php
		//}
		?>
	</div>
	
	<div id="footer-rights" class="textFooter"><a href="<?php echo $CopyrightLink?>" class="textFooter" target="_blank"><?php echo $CopyrightString?></a></div>
	<div id="footer-legacy" class="textFooter">
		<a href="#" class="textFooter"><?php echo dic("Login.Legal")?></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href="#" class="textFooter"><?php echo dic("Login.Privacy")?></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href="#" class="textFooter"><?php echo dic("Login.Help")?></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href="#"  class="textFooter"><?php echo dic("Login.Support")?></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href="#" class="textFooter languageNew"><?php echo $language?></a>
	</div>

	<div id="dialog-message" title="<?php echo  dic("alerttGF")?>" style="display:none">
		<p>
			<span class="ui-icon ui-icon-circle-minus" style="float:left; margin:0 7px 20px 0;"></span>
			<div id="div-msgbox" style="font-size:14px"></div>
		</p>
	</div>
	<div id="dialog-message1" title="<?php dic("Reports.Warning")?>" style="display:none">
		 <p>
			<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
			<div id="div-msgbox1" style="font-size:14px"></div>
		</p>
	</div>

	<!-- modal dialog jquery ui sto ne se prikazuva -->

	<div id="dialog-promena-email" title="<?php dic("Admin.Notification")?>" style="display:none">
	  <p>
	    <span class="ui-icon ui-icon-info" style="float:left; margin:0 7px 50px 0;"></span>
	    <?php echo dic("Reports.ModalInfo")?>
	  </p>
	  <div id="remaining-days-div" style="margin-bottom: 10px">
	  	<p><?php echo dic("Reports.ModalInfoAlertT1")?> <strong><span id="remaining-days" class="text5" style="font-weight:bold; font-size:13px"></span></strong> <?php echo dic("Reports.ModalInfoAlertT2")?></p>
	  </div>
	  <div style="margin-left:23px">
	  <div id="dialog-promena-email-input"></div>
	  	<p class="validateTips" style="color:red"></p>
	  </div>
	</div>

</body>
</html>
<script>

function IsEmail(email) {
  // var regex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;
  var regex = /^[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])+/;
  return regex.test(email);
}

function ValidationMessages( t ) {

      $('.validateTips')
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
       $('.validateTips').removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }

function modalNajava () {

var email_check_status = 0;
var daysToActivate = 15;
var buttonOkStatus = 0;  // za ok kopceto da iskluci ako vednas se klikne
var email_falg = '<?php echo session("emailflag") ?>';
var userid = '<?php echo session("user_id")?>';
console.log("email flag: "+email_falg);
	if(Number(email_falg)===0){
	  $(function() {
	  	// povik do UserFirstLogin.php - za creiranje na zapis
	  	// korisnikot prv pat kliknal
	  	ShowWait();
	  	$.ajax({
			url: "./settings/UserFirstLogin.php?l="+'<?php echo $cLang; ?>',
			async: false
			})
			.done(function(response){
				HideWait();
				daysToActivate = 15-Number(response);
				if(daysToActivate <= 0){
					$('#remaining-days-div').html("<strong><span id=\"remaining-days\" class=\"text5\" style=\"font-weight:bold; font-size:13px; color: red;\">"+" "+'<?php echo dic("Reports.NotificationEmail");?>'+"</span></strong>");
				} else if(daysToActivate == 1){
					$('#remaining-days-div').html("<strong><span id=\"remaining-days\" class=\"text5\" style=\"font-weight:bold; font-size:13px; color: red;\">"+" "+'<?php echo dic("Reports.ModalInfoAlertLastDay");?>'+"</span></strong>");
				} else {
					$('#remaining-days').append(daysToActivate);
				}
			});

	    $( "#dialog-promena-email" ).dialog({
	    	resizable: false,
	      	modal: true,
	      	draggable: false,
	      	height: 275,
	      	closeOnEscape: false,
	      	open: function( event, ui ) {

	      		if(daysToActivate <= 0){
	      			console.log("pomalo od nula!");
	      			$(':button:contains("Ok")').attr('disabled','disabled').hide();
	      			$(".ui-dialog-titlebar-close").hide();
	      		}
	      	},
	      	buttons:
		      [
			    {
			      	text: "Ok",
			      	click: function() {
			      		if (buttonOkStatus===0){
			      			$( this ).dialog( "close" );
			      		} else {
			      		buttonOkStatus=1;

			      		var thisval = $('#nov_email').val();
			      		// console.log(thisval);
			      		if(IsEmail(thisval)===true){
			      			// console.log("-- valid email entered...");
			      			// UPDAТЕ user by sending email
			      			// ============================================
			      			ShowWait();
			      			$.ajax({
								url: "./settings/UserUpdateEmail.php?l="+'<?php echo $cLang; ?>' ,
								type: 'POST',
								/*dataType: 'json',*/
								async: true,
								data :{ newEmail: thisval },
								})
			      				.done(function(response){
			      					HideWait();
			      					if(response==0){
  										// status vrakja samo koga nema da moze da se verificira email-ot
			      						// toastr.error(response.message_email);
			      						toastr.error('<?php echo dic("Settings.EmailValidationFailed"); ?>');
			      						$('#nov_email').val("");
									$('#nov_email').focus();
			      					} else {
			      						email_check_status = 1;
			      						toastr.success('<?php echo dic("Reports.NotificationEmailSuccess"); ?>');
			      						console.log("sega treba da se zatvori");
			      						$("#dialog-promena-email").dialog( "close" );
			      					}
			      					console.log(response);
			      				});
			      				if(email_check_status !== 0) {
			      					$("#dialog-promena-email").dialog( "close" );
			      				}
			      		} else {

			      			var $input = $('#nov_email').css("background-color", 'red').fadeTo( "fast", 0.45 );
			      			$('.validateTips').text('<?php echo dic("Reports.NotificationEmailValid"); ?>');   // i ova treba za prevod
	    					setTimeout(function() {
	    						$input.val('').css("background-color", '').fadeTo( "fast", 1);
	    					}, 1100);
	    					$input.focus();
						}

			          	//$( this ).dialog( "close" );
			          } // end else (button status)
			    	} // end function click()
				},
			    {
			    	text: '<?php echo dic("Settings.ModalButtonChange")?>',
			    	click: function () {
			    		console.log($(':button::nth-child(2)'));
			    		buttonOkStatus=1;
			    		$(':button:contains("Ok")').removeAttr("disabled").show();
			    		// $(':button:contains("Промени")').attr('disabled','disabled').hide();
			    		$(':button::nth-child(2)').attr('disabled','disabled').hide();
						$( "#dialog-promena-email-input" )
					    	.append("<label class=\"item item-input\">"+
					    			" <span class=\"text5\" style=\"font-weight:bold; font-size:14px\">Email </span>"+
					    			" <input type=\"email\" class=\"textboxcalender corner5 text5\" style=\"width:200px; height:22px; font-size:12px\" id=\"nov_email\" required>"+
					    			"</label>"
					    	);
$('#nov_email').focus();
			    	}
			    }
		      ] //end buttons

		    });
		  });

	} // glavna funkcija

}

function kiklopSetCookie (c_name,value,expiredays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays===null) ? "" : ";expires="+exdate.toGMTString());
}

	lang = '<?php echo $cLang?>';
	$(document).ready(function () {
		// alert('<?php echo dic("Reports.NotificationEmailValid"); ?>');
    	$(document.body).click(function(event) {
			var hide = true;

			for(var i=0; i<event.target.attributes.length; i++)
				if(event.target.attributes[i].value.indexOf("languageNew") != -1)
				{
					hide = false;
				}
			if(hide)
			{
				$.powerTip.hide();
				test = 1;
			}
		});
		jQuery('body').bind('touchmove', function(e){e.preventDefault()});
    	var test = 1;
    	// mouse-on example
		var mouseOnDiv = $('.languageNew');
		var tipContent = $('<table id="tablelang" style="display: block"><tr><td style="height: 20px" onmousemove="ShowPopup(event, \'Macedonian\')" onmouseout="HidePopup()"><a href="./?l=mk" onclick="kiklopSetCookie(\'DefaultLanguage\', \'mk\', 14)" class="textFooter">Македонски</a></td></tr><tr><td style="height: 20px" onmousemove="ShowPopup(event, \'English\')" onmouseout="HidePopup()"><a href="./?l=en" onclick="kiklopSetCookie(\'DefaultLanguage\', \'en\', 14)" class="textFooter">English</a></td></tr><tr><td style="height: 20px" onmousemove="ShowPopup(event, \'French\')" onmouseout="HidePopup()"><a href="./?l=fr" onclick="kiklopSetCookie(\'DefaultLanguage\', \'fr\', 14)" class="textFooter">Français</a></td></tr><tr><td style="height: 20px" onmousemove="ShowPopup(event, \'Albanian\')" onmouseout="HidePopup()"><a href="./?l=al" onclick="kiklopSetCookie(\'DefaultLanguage\', \'al\', 14)" class="textFooter">Shqip</a></td></tr></table>');
		mouseOnDiv.data('powertipjq', tipContent);
		mouseOnDiv.powerTip({
			placement: 'n'
		});
		// api examples
		$('.languageNew').on('click', function() {
			if(test == 1)
			{
				$.powerTip.show($('.languageNew'));
				test = 0;
			} else
			{
				$.powerTip.hide();
				test = 1;
			}
		});

		modalNajava();

    });
    if ('<?php echo $err?>' == 'permission') { mymsg('<?php echo dic("Login.PermMenu")?>'); }

    var allowedMess = '<?php echo $allowedMess?>';
	var allowedAlarms = '<?php echo $allowedAlarms?>';



if(allowedAlarms == '1')
{
	var snoozeTmp = 0;
	snooze = '<?php echo $snooze?>';

	$('#alertsNew').val('0');
	$('#div-mainalerts').css({ height: (document.body.clientHeight - 75) + 'px' });
}

if(allowedAlarms == '1')
{
	ShowHideAlerts();
	//ShowHideMail();
	snoozeAlarm();
	AjaxNotify();
}
if(allowedMess == '1')
	AjaxMessageNotify();

</script>


<?php

	if($allowedAlarms)
	{
		$sqlAlarm = "";
		$sqlAlarm .= "select ah.*, v.registration from alarmshistory ah left join vehicles v on v.id=ah.vehicleid ";
		$sqlAlarm .= " where ah.vehicleid in (" . $sqlV . ") ";
		$sqlAlarm .= " and ah.datetime > cast((select now()) as date) + cast('-1 day' as interval) ";
		$sqlAlarm .= " order by read asc, datetime desc";
		$dsAlarms = query($sqlAlarm);
		$brojac = 1;
		$brojac1 = dlookup("select count(*) from alarmshistory where vehicleid in (" . $sqlV . ") and datetime > cast((select now()) as date) + cast('-1 day' as interval) and read='0'");
		while($row = pg_fetch_array($dsAlarms))
		{
			$tzDatetime = new DateTime($row["datetime"]);
			list($d, $m, $y) = explode('-', $row["datetime"]);
			$a = explode(" ", $y);
			$d1 = explode(":", $a[1]);
			$d2 = explode(".", $d1[2]);
			$idCreate = $row["vehicleid"] . "_" . $d . "_" . $m . "_" . $a[0] . "_" . $d1[0] . "_" . $d1[1] . "_" . $d2[0] . "_" . $d2[1];
			if($row["read"] == "0")
			{
				?>
				<script>
					AlertEventInit('<?php echo $row["datetime"]?>', '<?php echo $row["registration"]?>', '<?php echo $row["name"]?>', '<?php echo $row["vehicleid"]?>', '<?php echo $brojac1?>');
				</script>
				<?php
				$brojac1--;
			}

			$brojac++;
		}

	}
	closedb();


?>
