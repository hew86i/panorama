<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
      
    
	$UserID = str_replace("'", "''", NNull($_GET['uid'], ''));
    $cLang = str_replace("'", "''", NNull($_GET['l'], ''));
	$veh= NNull($_GET['veh'], '');
    $v = $veh."";
	opendb();
    $dsgr = query("select id, name from pointsofinterestgroups where clientid = " . Session("client_id"));
    
    $dsv = query("select id, clientid, registration, code from vehicles where clientid = " . Session("client_id") . " order by code");
   
    $r = NNull(query("select registration from vehicles where id=" . $veh), "");
    $no = NNull(query("select code from vehicles where id=" . $veh), 0);
	$regi = pg_fetch_array($r);
	$broj = pg_fetch_array($no)
?>
<table width="100%">
    
    <tr><td colspan=2 height=30px></td></tr>
    <tr>
        <td align="left" class="text5" style="font-size:12; padding-left:30px"><?php echo dic("Settings.Registration")?>&nbsp;</td>
        <td align="left" class="text5" style="width:200px; font-size:12;">
            <input type="text" id="reg_<?php echo $v?>" value='<?php echo $regi["registration"]?>' class="textboxcalender corner5 text3" style="height:22; width:160;" />
        </td>
    </tr>
    
    <tr>
        <td align="left" class="text5" style="font-size:12; padding-left:30px"><?php echo dic("Settings.NoVeh")?>&nbsp;</td>
        <td align="left" class="text5" style="width:200px; font-size:12;">
            <input type="text" id="no_<?php echo $v?>" value="<?php echo $broj["code"]?>" class="textboxcalender corner5 text3" style="height:22; width:160;" />
        </td>
    </tr>

   
</table>

<div style="float:right; margin-right:42px; margin-top:15px">
    <input type="button" id="change" value="<?php echo dic("Settings.Change")?>" onclick="update()"/>
    
</div>

<script>

    $('#change').button({ icons: { primary: "ui-icon-check"} });

    function update() {
        var newReg = document.getElementById("reg_<?php echo $v?>").value;
        var newNo = document.getElementById("no_<?php echo $v?>").value;

        $.ajax({
            url: "UpdateVeh.php?veh=" + '<?php echo $v?>' + "&reg=" + newReg + "&no=" + newNo,
            context: document.body,
            success: function (data) {
                mymsg('<?php echo  dic("Settings.SuccUpd")?>')
            }
        });

    }

    

</script>
 <?php
     
     $ds = query("select id, name from pointsofinterest where type = '2' and clientid = " . Session("client_id"));
	 closedb();
 ?>
 
<script>

</script>