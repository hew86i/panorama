<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php
        session_destroy();
        WriteCookies("LogedIn14Days", "off", 14);
        header('Location: ../login/?l='.$cLang) ;
        exit;
?>
