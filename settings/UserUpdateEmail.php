<?php
include "../include/functions.php" ;
include "../include/db.php" ;

include "../include/params.php" ;
include "../include/dictionary2.php" ;

    opendb();

    $userfirstlogin = 0;
	$recordExists = 0;   // za dlookup i count(1)
	$mailVerified = 0;

	/*if(!isset($_POST['newEmail']) || !isset($_SESSION['user_id'])) {
		echo json_encode("no email in POST");
		exit();
	};*/

	$email = $_POST['newEmail'];
	$userid = Session('user_id');

	// if(isset($_GET['sendMail']) && isset($_SESSION['user_id'])) {

	// 	// update the user with the new username
	// 	$username = str_replace("'", "''", NNull($_GET['sendMail'], ''));

	// 	$updateEmail = query("update users set username = '" . $username . "', emailflag='1' where id = " . $userid);
	// 	echo json_encode("username was changed!");
	// 	exit();
	// };

	$count_query = "select count(1) from userfirstlogin where userid=" . $userid;
    $recordExists = dlookup($count_query);

    if($recordExists>0){
    	// sporedi so denesen datum (15 dena) i ne ja menuvaj tabelata userfirstlogin
    } elseif($recordExists==0){
    	// korinikot prv pat se logira posle update  (za nedaj boze ako toa pogore ne uspee)
    	// kreiraj zapis
    	$userfirstlogin = query("insert into userfirstlogin (userid, firstlogin) values (" . $userid . ", now())");
    }

    //ZA VALIDATOROT - DA SE PROMENI !
	/*$from = 'sysinfo@gps.mk'; // da se promeni so nekoj drug !!!!!1

	$validator = new SMTP_Validate_Email($email, $from);
	$smtp_results = $validator->validate();

	$isExistingMail = nnull($smtp_results[$email],0);
	if($isExistingMail) {
		$mailVerified = 1;   // podole se encodira vo json
	} else{
		/*echo json_encode(array('message_email' => dic_("Settings.EmailValidationFailed"),
							   'status' => 0));*/
	/*	echo 0;
		exit();
	}*/

    ///////////////// EMAIL SEND ///////////////////////
    ////											////
    ////		     								////
    ////											////
    ////////////////////////////////////////////////////


    // *******************************************************************
    // 			ENCRYPTION

    $encrypted_mail = encrypt_decrypt('encrypt', $email, '0123456789abcdefg');
	$encrypted_userid = encrypt_decrypt('encrypt', $userid, '0123456789abcdefg');

	$blagodarnost = dic_("Settings.EmailChangeSuccess");
	$comlpetion = dic_("Settings.EmailBodyLink");
	$confiramtion_link = "http://panorama.gps.mk/login/?l=". $cLang . "&sendMail=" . $encrypted_mail . "&uid=" . $encrypted_userid;

	//***************************************************************************//
	//***************************************************************************//
	//				CREATE MESSAGE USING DATABASE TABLE 						 //
	//																			 //
	//***************************************************************************//
	//

	$messageFrom = 'sysinfo@gps.mk';
	$messageTo	 = $email;
	$messageSubject = 'Geonet GPS Solutions - ' . dic_("Login.ActProfile");
	$messageBody = '<div style="font-size:14px; color:#364A78">' . dic_("Reports.Dear") . ',<br><br>' . $blagodarnost . '<br>' . $comlpetion . '<br><a href="' . $confiramtion_link . '">' . dic_("Login.Button") . '</a><br><br>' . dic_("Reports.Regards") . ',<br>Geonet GPS Solutions.<br><br><span style="color:red; font-size:11px">* ' . dic_("Reports.NoReply") . ' suport@gps.mk</span></div>';

	$query = "insert into send_mail (datetime, frommail, tomail, subject, body, flag) values (now(), '" . $messageFrom . "', '" . $messageTo . "', '" . $messageSubject . "', '" . $messageBody  . "' ,'0')";

	$send_mail = query($query);

	// *****************************  END USING DATABASE  ************************

	echo 'Ok';
    closedb();

?>
