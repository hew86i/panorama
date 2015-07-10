<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php 
	header("Content-type: text/html; charset=utf-8");
?>
<?php
	require_once '/usr/share/php/swift_required.php';

	//getQUERY
	$user = getQUERY("_user");
	$email = getQUERY("email");
	$cid = getQUERY("cid");
	$subject = getQUERY("subject");
	$link = getQUERY("link");
	$link = str_replace("*", "&", $link);
	$link = str_replace(".php", "PDF.php", $link);
	
	$temp1 = explode("?l=", $link);
	$temp = explode("&", $temp1[1]);
	$sd1 = explode("%20", substr($temp[1], 3));
	$sd = $sd1[0];
	$ed1 = explode("%20", substr($temp[2], 3));
	$ed = $ed1[0];

	$uid = substr($temp[1], 4);
	opendb();
	
	$page = str_replace(" ", "_", $subject);


	$name = $page. '_' . $cid . '_' . $sd . '_00:00_' . $ed . '_23:59.pdf';
	$link .= "&u=" . $user . "&c=" . $cid;

	//$name = str_replace($cyr, $lat, $name);

	$output = shell_exec('xvfb-run --server-args="-screen 0, 1200x800x24" wkhtmltopdf --dpi 300 "' . $link . '" --redirect-delay 10000 ../savePDF/' . $name);


	// Create the Transport
	// $transport = Swift_SmtpTransport::newInstance('mail.gps.mk', 25);
	$transport = Swift_SmtpTransport::newInstance('mail.gps.mk', 25)
  	->setUsername('sysinfo@gps.mk')
 	->setPassword('sysinfo')
 	;

	// Create the Mailer using your created Transport
	$mailer = Swift_Mailer::newInstance($transport);

	// Create a message
	$message = Swift_Message::newInstance($subject)
	  ->setFrom(array('sysinfo@gps.mk' => 'Geonet GPS Solutions'))
	  ->setBody('Geonet GPS')
	  ->addPart('<div style="font-size:14px; color:#364A78">' . dic_("Reports.Dear") . ',<br><br>' . dic_("Reports.AutMess") . '<br>' . dic_("Reports.AttachMess") . '<br><br>' . dic_("Reports.Regards") . ',<br>Geonet GPS Solutions.<br><br><span style="color:red; font-size:11px">* ' . dic_("Reports.NoReply") . ' suport@gps.mk</span></div>', 'text/html')
	  ->attach(Swift_Attachment::fromPath('../savePDF/' . $name))
	  ;

	// Send the message
	$failedRecipients = array();
	$numSent = 0;
	$to = array($email);

	foreach ($to as $address => $name)
	{
	  if (is_int($address)) {
	    $message->setTo($name);
	  } else {
	    $message->setTo(array($address => $name));
	  }
	  $numSent += $mailer->send($message, $failedRecipients);
	}
	

	echo 1;

 ?>
