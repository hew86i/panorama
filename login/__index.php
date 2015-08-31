<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php header("Content-type: text/html; charset=utf-8");?>
<html>
<head>
	<script>
		lang = "<?php echo $cLang?>";
	</script>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Panorama - Geonet GPS Fleet Management Solution</title>
	<link rel="stylesheet" type="text/css" href="../style.css">
	<LINK REL="SHORTCUT ICON" HREF="../images/icon.ico">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="../js/roundIE.js"></script>
	<script type="text/javascript" src="../js/share.js"></script>
	<script type="text/javascript" src="../js/core.js"></script>
	<script type="text/javascript" src="../js/csscoordinates.js"></script>
	<script type="text/javascript" src="../js/displaycontroller.js"></script>
	<script type="text/javascript" src="../js/placementcalculator.js"></script>
	<script type="text/javascript" src="../js/tooltipcontroller.js"></script>
	<script type="text/javascript" src="../js/utility.js"></script>
	<link rel="apple-touch-icon" href="../panoramaIcon.png" />
	<link rel="stylesheet" type="text/css" href="../css/jquery.powertip-blue.css" />

	<!-- my links -->
  	<link href="../css/ui-lightness/jquery-ui-1.8.14.custom.css" rel="stylesheet" type="text/css"/>
    <script src="../js/jquery-ui.js"></script>

	<script type="text/javascript" src="../js/toastr.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/toastr.css" />
	<!-- <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css" /> -->


</head>
<?php

	$errorString = "";
	$r14Chk = "";
	$un = getPOST("txtusername");
	$pass = getPOST("txtpassword");
	$rem14 = getPOST("chkRememberMe");
	$ShowMessage = "False";
	$cnt = 0;
	$HaveUser = 0;
	// my custom vars
	$pass_strength = 1;
	$username ="";

	opendb();

//echo $_GET['sendMail'] . "***";

	// *****************************************************
	//				sendEmail promenliva i zapis
	//******************************************************

	if(isset($_GET['sendMail'])/* && isset($_SESSION['user_id'])*/) {

		// update the user with the new username
    	$username = encrypt_decrypt('decrypt', $_GET['sendMail'], '0123456789abcdefg');
		$userid = encrypt_decrypt('decrypt', $_GET['uid'], '0123456789abcdefg');

		//$userid = $_SESSION['user_id'];

		$updateEmail = query("update users set username = '" . $username . "', emailflag='1' where id = " . $userid);


	};


	if (($un!="") || ($pass!="")) {
		$loggedClient = dlookup("select clientid from users where username='".$un."' and password='".$pass."'");
		if((($un == "admin") || ($un == "kikigps") || ($un == "gorangps") || ($un == "marjangps") || ($un == "aleksgps") || ($un == "alekgps") || ($un == "igorgps") || ($un == "cvetangps")) && $loggedClient == 1)
		{
			if($pass[0] == "\"")
				$pass = str_replace('"', '', $pass);
			$cnt = dlookup("select count(*) from users where username='".$un."' and password = '".$pass."' and active='1'");
			if ($cnt==0){
				$ShowMessage = "True";
				session_destroy();
			} else {
				$HaveUser = 1;
				$ruser = query("select * from users where username='".$un."' and password = '".$pass."' and active='1'");
				$pass_strength = strlen($pass);
				$_SESSION['user_id']= pg_fetch_result($ruser, 0, 'id');
				$_SESSION['role_id']= pg_fetch_result($ruser, 0, 'roleid');
				$_SESSION['client_id']= pg_fetch_result($ruser, 0, 'clientid');
				$_SESSION['user_fullname']= pg_fetch_result($ruser, 0, 'fullname');
				$_SESSION['emailflag'] = pg_fetch_result($ruser, 0, 'emailflag');
				$_SESSION['company']=dlookup("select name from clients where id in (select clientID from users where id=".pg_fetch_result($ruser, 0, 'id')." limit 1) limit 1");
				$_SESSION['pass_strength'] = $pass_strength;
				$ShowMessage = "False";
			};
			if ($HaveUser==1) header( 'Location: ../admin/?l='.$cLang);

		}else
		{
			if($pass[0] == "\"")
				$pass = str_replace('"', '', $pass);
				$pass_strength = strlen($pass);
			$cnt = dlookup("select count(*) from users where username='".$un."' and password = '".$pass."' and active='1'");
			if ($cnt==0){
				$ShowMessage = "True";
				session_destroy();
			} else {
				$HaveUser = 1;
				$ruser = query("select * from users where username='".$un."' and password = '".$pass."' and active='1'");

				$_SESSION['user_id'] = pg_fetch_result($ruser, 0, 'id');
				$_SESSION['role_id'] = pg_fetch_result($ruser, 0, 'roleid');
				$_SESSION['client_id'] = pg_fetch_result($ruser, 0, 'clientid');
				$_SESSION['user_fullname'] = pg_fetch_result($ruser, 0, 'fullname');
				$_SESSION['emailflag'] = pg_fetch_result($ruser, 0, 'emailflag');
				// pass strength specific
				$_SESSION['pass_strength'] = $pass_strength;
				$directlive = 0;// pg_fetch_result($ruser, 0, 'directlive');

				//echo odbc_result($ruser,"FullName");
				//exit();
				//die();
				//flush();
				$_SESSION['company']=dlookup("select name from clients where id in (select clientID from users where id=".pg_fetch_result($ruser, 0, 'id')." limit 1) limit 1");
				$ShowMessage = "False";
				if ($rem14 == "on"){
					WriteCookies("LogedIn14Days", "on", 14);
					WriteCookies("LogedIn14DaysChecked", "on", 14);
					
					WriteCookies("user_id", $_SESSION['user_id'], 14);
					WriteCookies("role_id", $_SESSION['role_id'], 14);
					WriteCookies("client_id", $_SESSION['client_id'], 14);
					WriteCookies("user_fullname", $_SESSION['user_fullname'], 14);
					WriteCookies("company", $_SESSION['company'], 14);
					
				}
			};
			if ($HaveUser==1)
			{
				addlog(1, '');
				if($directlive == '0')
					header( 'Location: ../?l='.$cLang);
				else
					header( 'Location: ../tracking/?l='.$cLang);
			}
		} 
	}
	closedb();
	if ($ShowMessage == "False") ($errorString = "style=\"display:none\"");

	if(ReadCookies("LogedIn14DaysChecked") == "on")
		$r14Chk = "Checked='checked'";
		
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

<body onResize="setElementToCenter()">

	<div id="main-blue-track"></div>

	<div id="main-container">
		<img id="img-logo" src="../images/GeonetLogo.png" style="margin-top: 20px;" alt="" />
		<img id="img-advert" src="../images/advert.png" width="450" height="331" alt="" />
		<div id="div-advertNew" class="textTitle">
			<img id="img-log1" src="../images/PanoramaLogo.1.png" align="right" style="" alt="" /><br><br><br>
			<div style="line-height: 25px; position: relative; top: -7;"><?php dic("Login.Title")?><br>
		    <span class="text1"><?php dic("Login.Description")?></span></div>
		</div>
		<!--div id="div-lang">
			<a href="./?l=mk"><img src="../images/mk.png" width="30" height="30" border="0" align="absmiddle"/></a>&nbsp;&nbsp;&nbsp;
			<a href="./?l=en"><img src="../images/en.png" width="30" height="30" border="0" align="absmiddle"/></a>&nbsp;&nbsp;&nbsp;
			<a href="./?l=fr"><img src="../images/fr.png" width="30" height="30" border="0" align="absmiddle"/></a>&nbsp;&nbsp;&nbsp;
			<a href="./?l=al"><img src="../images/al.png" width="30" height="30" border="0" align="absmiddle"/></a>
		</div-->
		<form id="frmlogin" name="frmlogin" method="post" action="../login/?l=<?php echo $cLang?>" onSubmit="gloob()">
			<span id="lblusername" class="BlackText2"><?php dic("Login.Username")?></span>
			<span id="lblpassword" class="BlackText2"><?php dic("Login.Password")?></span>
			
			<input id="txtusername" type="text" name="txtusername" class="BlackText corner5" value="<?PHP echo $username; ?>">
			<input id="txtpassword" type="password" name="txtpassword" class="BlackText corner5">
			<input type="submit" class="BlackText corner5" id="btnlogin" name="btnlogin" value="<?php dic("Login.Button")?>">
			<span id="lbl-error-login-msg" class="BlackText2" <?php echo $errorString?>><?php dic("Login.WrongPassword")?> !!!</span>
			<label id="lbl-remember-me" class="BlackText1" style="position:absolute; left:190px; top:65px; color:#000; font-weight:bold; width:200px"><input name="chkRememberMe" id="chkRememberMe" type="checkbox" <?php echo $r14Chk?>><?php  dic("Login.keepLogged")?></label>

		</form>
	</div>
	
	<div id="footer-rights" class="textFooter"><a href="<?php echo $CopyrightLink?>" class="textFooter" target="_blank"><?php echo $CopyrightString?></a></div>
	<div id="footer-legacy" class="textFooter"> <a href="#" class="textFooter"><?php echo dic("Login.Legal")?></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="#" class="textFooter"><?php echo dic("Login.Privacy")?></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="#" class="textFooter"><?php echo dic("Login.Help")?></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="#"  class="textFooter"><?php echo dic("Login.Support")?></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href="#" class="textFooter languageNew"><?php echo $language?></a>
	</div>

</body>
<script>
function kiklopSetCookie (c_name,value,expiredays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays===null) ? "" : ";expires="+exdate.toGMTString());
}
	$(document).ready(function () {
		var usernameField = '<?php echo $username; ?>';
		if(usernameField!==""){
			$('#txtpassword').focus();
			toastr.info('<?php echo dic("Settings.InsertPass"); ?>');
		}
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
		//var tipContent = $('<table id="tablelang" style="display: block"><tr><td style="height: 20px" onmousemove="ShowPopup(event, \'Macedonian\')" onmouseout="HidePopup()"><a href="./?l=mk" class="textFooter">Македонски</a></td></tr><tr><td style="height: 20px" onmousemove="ShowPopup(event, \'English\')" onmouseout="HidePopup()"><a href="./?l=en" class="textFooter">English</a></td></tr><tr><td style="height: 20px" onmousemove="ShowPopup(event, \'French\')" onmouseout="HidePopup()"><a href="./?l=fr" class="textFooter">Français</a></td></tr><tr><td style="height: 20px" onmousemove="ShowPopup(event, \'Albanian\')" onmouseout="HidePopup()"><a href="./?l=al" class="textFooter">Shqip</a></td></tr></table>');
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
    });
</script>
</html>
