<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<html>
<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
	<script type="application/javascript">
		lang = '<?php echo $cLang?>';
	</script>
<style>
	.ui-button { margin-left: -1px; }
	.ui-button-icon-only .ui-button-text { padding: 0.35em; } 
	.ui-autocomplete-input { margin: 0; padding: 0.48em 0 0.47em 0.45em; }
</style>
<?php
    $ClientType = "";
    opendb();
    $dsCT = query("select ClientTypeID from Clients where id = " . Session("client_id"));
    
    if(pg_num_rows($dsCT) > 0)
        $ClientType = NNull(pg_result($dsCT,"ClientTypeID"), "1");
    
	if (!is_numeric(session('user_id'))) echo header( 'Location: ../sessionexpired/?l='.$cLang);
	
	$sqlV = "";
	if (session("role_id")."" == "2"){
		$sqlV = "select id from draft.dbo.vehicles where clientID=".session("client_id");
	} else {
		$sqlV = "select vehicleID from draft.dbo.UserVehicles where userID=".session("user_id"); 
	}
       
	$vehicles = "select * from vehicles where clientid=" . Session("client_id")."order by code ";
    $dsVeh = query($vehicles);
    
?>
<body>


<div class="textTitle" style="padding:5px"><?php echo dic("Settings.VehicleSettings")?></div>
<table width="250px" border="0px" style="margin-top:10px">
   <?php
        $cnt = 1;
        $cl = "";
        $cl1 = "";
		while($row = pg_fetch_array($dsVeh))
		{
            if($cnt++ % 2 == 0)
            {
                $cl = "background-color:#f7f7f7;";
                $cl1 =  "color:#4f72a8; padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:10px;font-size:12px";
            } else
			{
                $cl =  "background-color:#ededed;";
                $cl1 =  "color:#2f5185; padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:10px;font-size:12px";
            }
            
            ?>
            
            
            <tr style="<?php echo $cl?>" >
            <td class="text2" style="<?php echo $cl1 ?>" >
                <?php echo $row["registration"]?> (<?php echo $row["code"]?>)
            </td>
            <td class="text2" width="27px"><button id="vId_<?php echo $row["id"]?>" onclick="ChangeVehicle(<?php echo $row["id"]?>)" title="<?php echo dic("Settings.EditVeh") ?>" style="margin-left:1px"></button>
            	</td>
            </tr>
            
            <script>
                $('#vId_<?php echo $row["id"]?>').button({ icons: { primary: "ui-icon-pencil"} });
                document.getElementById('vId_<?php echo $row["id"] ?>').style.height = "27px";
                document.getElementById('vId_<?php echo $row["id"] ?>').style.width = "27px";
            </script>
           

    
        <?php
		}
		?>
		 </table>
		  <div id="div-vehicle" style="display:none" title="<?php dic("Settings.ChangeVehSett") ?>">
</body>

</html>

<script>
    lang = '<?php echo $cLang?>';
    $(function () {

        $('#btnSave').button({ icons: { primary: "ui-icon-check"} });

    });


    function ChangeVehicle(vid) {
        var uid = '<?php echo session("user_id")?>';
        $.ajax({
            url: "ChangeVehicle.php?uid=" + uid + "&l=" + '<?php echo $cLang?>' + "&veh=" + vid,
            context: document.body,
            success: function (data) {	
                $('#div-vehicle').html(data);
                $('#div-vehicle').dialog({ modal: true, height: 200, width: 370, resizable: false });
            }
        });
    }

</script>
<?php
	closedb();
?>
