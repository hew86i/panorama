
<?php
session_start();

function ReturnDate($strDat){
	list($d, $m, $y) = explode('-', $strDat);
	$mk = mktime(0, 0, 0, $m, $d, $y);
	return strftime('%Y-%m-%d',$mk);
}

function ReturnDateInDate($strDat){
	list($d, $m, $y) = explode('-', $strDat);
	$mk = mktime(0, 0, 0, $m, $d, $y);
	return $mk;
}

function ReturnDateInDate1($strDat){
	list($d, $m, $y) = explode('-', $strDat);
	$a = explode(" ", $y);
	$d1 = explode(":", $a[1]);
	$mk = mktime($d1[0], $d[1], 0, $m, $d, $a[0]);
	return $mk;
}

function cyr2lat ($str) {
	$cyr  = array('а','б','в','г','д','ѓ','е','ж','з','ѕ','и','ј','к','л','љ','м','н','њ','о','п','р','с','т','ќ','у','ф','х','ц','ч','џ','ш',
	'А','Б','В','Г','Д','Ѓ','Е','Ж','З','Ѕ','И','Ј','К','Л','Љ','М','Н','Њ','О','П','Р','С','Т','Ќ','У','Ф','Х','Ц','Ч','Џ','Ш');
	$lat = array('a','b','v','g','d','gj','e','zh','z','dz','i','j','k','l','lj','m','n','nj','o','p','r','s','t','kj','u','f','h','c','ch','dj','sh',
	'A','B','V','G','D','DJ','E','ZH','Z','DZ','I','J','K','L','LJ','M','N','NJ','O','P','R','S','T','KJ','U','F','H','C','CH','DJ','SH');
	$str = str_replace($cyr, $lat, $str);
	return $str;
}
function lat2cyr ($str) {
	$cyr  = array('а','б','в','г','д','ѓ','е','ж','з','ѕ','и','ј','к','л','љ','м','н','њ','о','п','р','с','т','ќ','у','ф','х','ц','ч','џ','ш',
	'А','Б','В','Г','Д','Ѓ','Е','Ж','З','Ѕ','И','Ј','К','Л','Љ','М','Н','Њ','О','П','Р','С','Т','Ќ','У','Ф','Х','Ц','Ч','Џ','Ш');
	$lat = array('a','b','v','g','d','gj','e','zh','z','dz','i','j','k','l','lj','m','n','nj','o','p','r','s','t','kj','u','f','h','c','ch','dj','sh',
	'A','B','V','G','D','DJ','E','ZH','Z','DZ','I','J','K','L','LJ','M','N','NJ','O','P','R','S','T','KJ','U','F','H','C','CH','DJ','SH');
	$str = str_replace($lat, $cyr, $str);
	return $str;
}
	function transliterate($word, $lang){
	if ($lang!="mk"){
		if(ctype_alpha($word))
		{
			return $word;
		}
		echo cyr2lat ($word);
	}
	else{
		if(ctype_alpha($word))
		{
			return $word;
		}
		echo lat2cyr($word);

	}

}

function ReturnDateRec($strDat, $m, $h){
	$den = intval(substr($strDat, 0, 2));
	$mesec = intval(substr($strDat, 3, 2));
	$godina = intval(substr($strDat, 6, 4));
	$d = new DateTime($den . "-" . $mesec . "-" . $godina . " " . $m . ":" . $h);
	$dat = $d->format("Y-m-d H:i");
	return $dat;
}
function ReturnDateM1($strDat, $m, $h){
	$den = intval(substr($strDat, 8, 2));
	$mesec = intval(substr($strDat, 5, 2));
	$godina = intval(substr($strDat, 0, 4));
	$d = new DateTime($den . "-" . $mesec . "-" . $godina . " " . $m . ":" . $h);
	$dat = $d->format("Y-m-d H:i:59");
	return $dat;
}
function ReturnDateN($strDat){
	
	$den = intval(substr($strDat, 0, 2));
	$mesec = intval(substr($strDat, 3, 2));
	$godina = intval(substr($strDat, 6, 4));
	$hour = intval(substr($strDat, 11, 2));
	$min = intval(substr($strDat, 14, 2));
	$sec = intval(substr($strDat, 17, 2));
	$d = new DateTime($den."-".$mesec."-".$godina." ".$hour.":".$min.":".$sec);
	$dat = $d->format("Y-m-d H:i:s");
	return $dat;
}
function ReturnDateT($strDat){
	
	$den = intval(substr($strDat, 0, 2));
	$mesec = intval(substr($strDat, 3, 2));
	$godina = intval(substr($strDat, 6, 4));
	$d = new DateTime($den."-".$mesec."-".$godina);
	$dat = $d->format("n/j/Y");
	return $dat;
}
function ReturnDateInDateM($strDat){
	
	$den = intval(substr($strDat, 0, 2));
	$mesec = intval(substr($strDat, 3, 2));
	$godina = intval(substr($strDat, 6, 4));
	$d = new DateTime($den."-".$mesec."-".$godina);
	$dat = $d->format("n/j/Y");
	return $dat;
}
function ReturnDateInTimeM1($date, $sec){
	list($d, $m, $y) = explode('-', $date);
	$a = explode(" ", $y);
	$d1 = explode(":", $a[1]);
	$mk = mktime($d1[0], $d1[1], $sec, $m, $d, $a[0]);
	return $mk;
}
function ReturnDateInTime($date, $sec){
	list($d, $m, $y) = explode('-', $date);
	$a = explode(" ", $y);
	$d1 = explode(":", $a[1]);
	$mk = mktime($d1[0], $d1[1], $sec, $m, $d, $a[0]);
	return $mk;
}

function isMobileBrowser(){
	return FALSE;
}


//komentar
function getPOST($ParamName){
	$retValue = "";
	if (isset($_POST[$ParamName])==true) {
		$retValue = $_POST[$ParamName] ;
		$retValue= str_replace("'", "''", $retValue);
	};
	
	return $retValue;
	
}


function getQUERY($ParamName){
	$retValue = "";
	if (isset($_GET[$ParamName])==true) {
		$retValue = $_GET[$ParamName] ;
		$retValue= str_replace("'", "''", $retValue);
	};
	return $retValue;
}

function WriteCookies($name, $value, $days){
	$expire=time()+60*60*24*$days;
	setcookie($name, $value, $expire, "/");
}
function ReadCookies($name){
	if (isset($_COOKIE[$name]))
  		return $_COOKIE[$name];
	else
  		return "";
	
}

function session($name){
	if (isset($_SESSION[$name]))
  		return $_SESSION[$name];
	else
  		return "";
	
}

function nnull($value, $defVal=""){
	if ($value==NULL) return $defVal;
	
	if (isset($value)) {
		return $value;
	} else {
		return $defVal;
	}
}

function getPriv($key, $userID){
	$rid = dlookup("select roleid from users where id=".$userID);
	if ($rid==2) {return 1;}
	$ret = nnull(dlookup("select ".$key." from privilegessettings where userid=".$userID),1);
	return $ret;
}

function Sec2Str($_sec){
    $h = intval($_sec/3600);
    $_sec = $_sec % 3600;
    $m = intval($_sec/60.0);
    $_sec = $_sec % 60;
    $str = "";
    if($h > 0)
        $str = $h . "h " . $m . "min ";// . $_sec . "s";
    else
        if($m > 0)
            $str = $m . "min ";// & _sec & "s"
        else
            $str = $_sec . "sec";

    Return $str;
}
function Sec2Str1($_sec){
    $h = intval($_sec/3600);
    $_sec = $_sec % 3600;
    $m = intval($_sec/60.0);
    $_sec = $_sec % 60;
    $str = "";
    if($h > 0)
        $str = $h . " h " . $m . " min " . $_sec . " sec";
    else
        if($m > 0)
            $str = $m . " min " . $_sec . " sec";
        else
            $str = $_sec . " sec";

    Return $str;
}
function Sec2Str2($_sec){
    $h = intval($_sec/3600);
    $_sec = $_sec % 3600;
    $m = intval($_sec/60.0);
    $_sec = $_sec % 60;
    $str = "";
    if($h > 0)
        $str = $h . "h " . $m . "min ";// . $_sec . "s";
    else
        if($m > 0)
            $str = $m . "min " . $_sec . "sec";
        else
            $str = $_sec . "sec";

    Return $str;
}
function Sec2Str2_($_sec){
    $h = intval($_sec/3600);
    $_sec = $_sec % 3600;
    $m = intval($_sec/60.0);
    $_sec = $_sec % 60;
    $str = "";
    if($h > 0)
        $str = $h . "h<br>" . $m . "min ";// . $_sec . "s";
    else
        if($m > 0)
            $str = $m . "min<br>" . $_sec . "sec";
        else
            $str = $_sec . "sec";

    Return $str;
}
function Time2Str($_sec){
	$pos = strrpos($_sec, ":");
	if($pos === false)
		Return "0 sec";
	$a = explode(":", $_sec);
	$str = "";
	if(intval($a[0]) != 0)
		$str = intval($a[0]) . " h " . intval($a[1]) . " min ";
	else
		if(intval($a[1]) != 0)
            $str = intval($a[1]) . " min " . intval($a[2]) . " sec";
        else
            $str = intval($a[2]) . " sec";
	
    Return $str;
}

function SendMail($MailTo, $Subject, $BodySTR)
{
	extract($GLOBALS, EXTR_REFS);

	$SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $SmtpUser, $MailTo, $Subject, $BodySTR);
	$SMTPChat = $SMTPMail->SendMail();
	
	return true;
}

//razlika vo denovi megu dva datumi ($date1 i $date2)
function DateDiffDays($date1, $date2) {
	$diff = round(abs(strtotime($date1)-strtotime($date2))/86400);	
	if (strtotime($date1) > strtotime($date2)) $diff = $diff * -1;
	return $diff;
}
function DateDiffHours($date1, $date2) {
	$diff = round(abs(strtotime($date1)-strtotime($date2))/3600);	
	if (strtotime($date1) > strtotime($date2)) $diff = $diff * -1;
	return $diff;
}


//go vraka denesniot den
function now() {
	return date("Y-m-d H:i:s");
}

//formatiranje na datum; $date e datum; $format e formatot vo koj treba da se formatira $date
function DateTimeFormat($date, $format) {
	return date_format(new Datetime(nnull($date, date($format))), $format);
}

//dodava/odzema denovi od denesniot den; $int e brojot na denovi koi treba da se dodade ili odzeme; za vcerasniot den $int = -1
function addDay($int){
	$resultDate = Date("d-m-Y", strtotime($int . " days"));
	return $resultDate;
}

//dodava nula napred samo pred broevite pomali od 10; $int e brojot pred koj treba da se dodade 0
function leadingZero($int) {
	return sprintf('%02d', $int, 0);
}
function addToDate($datetime, $int, $part){
	$resultDate = date('Y-m-d H:i:s', strtotime("$int " . $part, strtotime($datetime)));
	return $resultDate;
}
function addToDateM($datetime, $int, $part){
	$resultDate = date('Y-m-d H:i:s', strtotime("$int " . $part, strtotime($datetime)));
	return $resultDate;
}
function addToDateU($datetime, $int, $part, $format){
	$resultDate = date($format, strtotime("$int " . $part, strtotime($datetime)));
	return $resultDate;
}

function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
   
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
   
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
   
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
   
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
   
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

CheckCookies();
function CheckCookies()
{
	if (!is_numeric(session('user_id')))
	{
		if(ReadCookies("LogedIn14Days") == "on")
		{
			
			$_SESSION['user_id'] = ReadCookies("user_id");
			$_SESSION['role_id'] = ReadCookies("role_id");
			$_SESSION['client_id'] = ReadCookies("client_id");
			$_SESSION['user_fullname'] = ReadCookies("user_fullname");
			$_SESSION['company'] = ReadCookies("company");
		}
    }
}

function addlog($idevent, $desc='')
{
	opendb();
	$ipa = getIP();
	
	$currDateTime = new Datetime();
	$currDateTime = $currDateTime->format("Y-m-d H:i:s");
	
	$ua=getBrowser();
	
	$sqlInsert = "";
	$sqlInsert .= "insert into userlog (datetime, userid, eventtypeid, description, ipaddress, notes) values ";
	$sqlInsert .= "('" . $currDateTime . "', '" . Session("user_id") . "', '" . $idevent . "', '" . $desc . "', '" . $ipa . "','" . $ua['userAgent'] . "/" . $ua['platform'] . "')";
	
	RunSQL($sqlInsert);
}

function utf8_urldecode($str) {
		$txt=html_entity_decode(preg_replace("/%u([0-9a-f]{3,4})/i", "&#x\\1;", urldecode($str)), null, 'UTF-8');
		$txt = str_replace("%plus%", "+",$txt);
		//$txt = str_replace("%plus%", "+",$txt);
		return $txt;
}

// ENCRYPTION AND DECRYPTION USED FOR EMAL SEND LINK

function encrypt_decrypt($action, $string, $my_key) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = $my_key;
    $secret_iv = '^^0@$$$4770-4$%^^4';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}


?>
