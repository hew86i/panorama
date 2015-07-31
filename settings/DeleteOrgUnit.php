<?php include "../include/db.php" ?>
<?php include "../include/functions.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>

<?php

  header("Content-type: text/html; charset=utf-8");

  opendb();

  $validation =array();

  $id = getQUERY('id');
  $delete = (isset($_GET['delete'])) ? true : false;

  $cid = session('client_id');
  $uid = session('user_id');

  $haveAlarms = query("select * from alarms where clientid=". $cid ." and settings='". $id ."'");
  $validation['haveAlarms'] = pg_num_rows($haveAlarms);

  $haveVehicles = query("select * from vehicles where clientid=". $cid ." and organisationid=". $id );
  $validation['haveVehicles'] = pg_num_rows($haveVehicles);


  echo json_encode($validation);

  if($delete) {
    if($validation['haveAlarms'] > 0) {
      // izbrisi gi alarmite
      RunSQL("delete from alarms where clientid=". $cid ." and settings='". $id ."'");
    }
     if($validation['haveVehicles'] > 0) {
      // prefrli gi vozilata vo negrupirani /0
      RunSQL("update vehicles set organisationid=0 where clientid=". $cid ." and organisationid=". $id);

    }
    RunSQL("delete from organisation where id=". $id ." and clientid=". $cid);
  }

  closedb();

?>