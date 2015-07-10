<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<?php

	$userID = str_replace("'", "''", NNull($_GET['uid'], ''));
	opendb();

    $dsve = query("select id, registration, code from vehicles where clientid = " . Session("client_id") . " order by code");
?>
    <input type="checkbox" id="SelectAll" onchange="SelectAllVehicles()" /><label class="text5" style="font-weight:bold; font-size:12;"><?php echo dic("Settings.SelectAll")?></label><p />

    <?php
        while($row = pg_fetch_array($dsve))
		{
            $count = dlookup("select count(*) from uservehicles where vehicleid= " . $row["id"] . " and userid = ". $userID ."");
			
            if($count == 1)
			{
	            ?>
	            <label><input type="checkbox" checked="checked" id="<?php echo $row["id"]?>" /><?php echo $row["registration"]?> (<?php echo $row["code"]?>)<br /></label> 
	            <?php
			} else
			{
	            ?>
	            <label><input type="checkbox" id="<?php echo $row["id"]?>" /><?php echo $row["registration"]?> (<?php echo $row["code"]?>)<br /></label> 
	            <?php
	        }
    	}
    closedb();
?>
<script>
    lang = '<?php echo $cLang?>';
    function SelectAllVehicles() {
        var _vehicles = document.getElementById("div-vehicles-user");
        var selectirano = document.getElementById("SelectAll").checked
        if (_vehicles.childNodes.length > 0) {
            for (var x = 0; x < _vehicles.childNodes.length; x++) {
                if (_vehicles.childNodes[x].childNodes.length > 0) {
                    _vehicles.childNodes[x].childNodes[0].checked = selectirano;
                }
            }
        }
    }
</script>
