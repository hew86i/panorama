<?php
include "../include/functions.php" ;
include "../include/db.php" ;

include "../include/params.php" ;
include "../include/dictionary2.php"; 

opendb();
$userid = Session('user_id');
$recordExists = dlookup("select count(1) from userfirstlogin where userid=" . $userid);

if ($recordExists==0){
		$userfirstlogin = query("insert into userfirstlogin (userid, firstlogin) values (" . $userid . ", now())");

}
// return the sotored first login date

$recordDate = dlookup("select firstlogin from userfirstlogin where userid=" . $userid);
$days = DateDiffDays($recordDate, now());
echo json_encode($days);
closedb();
exit(); 

?>
