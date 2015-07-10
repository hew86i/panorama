<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
      
   
	$id = str_replace("'", "''", NNull($_GET['id'], ''));
	
	opendb();
	$dsedit = query("select * from worktime where id=" . $id . " and clientid = " . Session("client_id"));
	$TF = pg_fetch_result($dsedit, 0, "timefrom");
	$saat1 = strstr($TF, ':', true);
	
	
					$t1 = "";
                    $t2 = "";
                    $t3 = "";
					$t4 = "";
					$t5 = "";
					$t6 = "";
					$t7 = "";
					$t8 = "";
					$t9 = "";
					$t10 = "";
					$t11 = "";
                    $t12 = "";
                    $t13 = "";
					$t14 = "";
					$t15 = "";
					$t16 = "";
					$t17 = "";
					$t18 = "";
					$t19 = "";
					$t20 = "";
					$t21 = "";
                    $t22 = "";
                    $t23 = "";
					$t24 = "";
					
					If($saat1 == "01"){
                       $t1 = "selected='selected'";
					}
					If($saat1 == "02"){
                        $t2 = "selected='selected'";
					}
					If($saat1 == "03"){
                        $t3 = "selected='selected'";
					}
					If($saat1 == "04"){
                        $t4 = "selected='selected'";
					}
					If($saat1 == "05"){
                        $t5 = "selected='selected'";
					}
					If($saat1 == "06"){
                        $t6 = "selected='selected'";
					}
					If($saat1 == "07"){
                        $t7 = "selected='selected'";
					}
					If($saat1 == "08"){
                        $t8 = "selected='selected'";
					}
					If($saat1 == "09"){
                        $t9 = "selected='selected'";
					}
					If($saat1 == "10"){
                        $t10 = "selected='selected'";
					}
					If($saat1 == "11"){
                       $t11 = "selected='selected'";
					}
					If($saat1 == "12"){
                        $t12 = "selected='selected'";
					}
					If($saat1 == "13"){
                        $t13 = "selected='selected'";
					}
					If($saat1 == "14"){
                        $t14 = "selected='selected'";
					}
					If($saat1 == "15"){
                        $t15 = "selected='selected'";
					}
					If($saat1 == "16"){
                        $t16 = "selected='selected'";
					}
					If($saat1 == "17"){
                        $t17 = "selected='selected'";
					}
					If($saat1 == "18"){
                        $t18 = "selected='selected'";
					}
					If($saat1 == "19"){
                        $t19 = "selected='selected'";
					}
					If($saat1 == "20"){
                        $t20 = "selected='selected'";
					}
					If($saat1 == "21"){
						$t21 = "selected='selected'";
					}
					If($saat1 == "22"){
                        $t22 = "selected='selected'";
					}
					If($saat1 == "23"){
                        $t23 = "selected='selected'";
					}
					If($saat1 == "00"){
                        $t24 = "selected='selected'";
					}
			?>
			<table align = "center" cellpadding="3" cellspacing="3" style="padding-top: 10px">
            <tr>
                <td class="text5" style="font-weight:bold"><?php echo dic_("From")?>:</td>
                <td class="text5" style="font-weight:bold">
                   
				<select id="TimeFrom3" class="combobox text2">
                <?php?>
   					<option value="01" <?php echo $t1?>>01</option>
		            <option value="02" <?php echo $t2?>>02</option>
		            <option value="03" <?php echo $t3?>>03</option>
                    <option value="04" <?php echo $t4?>>04</option>
                    <option value="05" <?php echo $t5?>>05</option>
                    <option value="06" <?php echo $t6?>>06</option>
                    <option value="07" <?php echo $t7?>>07</option>
                    <option value="08" <?php echo $t8?>>08</option>
                    <option value="09" <?php echo $t9?>>09</option>
                    <option value="10" <?php echo $t10?>>10</option>
                    <option value="11" <?php echo $t11?>>11</option>
		            <option value="12" <?php echo $t12?>>12</option>
		            <option value="13" <?php echo $t13?>>13</option>
                    <option value="14" <?php echo $t14?>>14</option>
                    <option value="15" <?php echo $t15?>>15</option>
                    <option value="16" <?php echo $t16?>>16</option>
                    <option value="17" <?php echo $t17?>>17</option>
                    <option value="18" <?php echo $t18?>>18</option>
                    <option value="19" <?php echo $t19?>>19</option>
                    <option value="20" <?php echo $t20?>>20</option>
                    <option value="21" <?php echo $t21?>>21</option>
		            <option value="22" <?php echo $t22?>>22</option>
		            <option value="23" <?php echo $t23?>>23</option>
                    <option value="00" <?php echo $t24?>>00</option>
               </select>
               <select id="TimeFrom4" class="combobox text2">
                <?php
                $TFP = pg_fetch_result($dsedit, 0, "timefrom"); 
				$minuti1 = strstr($TFP, ':');
                    $tfp1 = "";
                    $tfp2 = "";
                    $tfp3 = "";
					$tfp4 = "";
					
					If($minuti1 == ":00"){
                       $tfp1 = "selected='selected'";
					}
					If($minuti1 == ":15"){
                       $tfp2 = "selected='selected'";
					}
					If($minuti1 == ":30"){
                       $tfp3 = "selected='selected'";
					}
					If($minuti1 == ":45"){
                       $tfp4 = "selected='selected'";
					}
               	?>
               	<option value=":00" <?php echo $tfp1?>>:00</option>
               	<option value=":15" <?php echo $tfp2?>>:15</option>
               	<option value=":30" <?php echo $tfp3?>>:30</option>
               	<option value=":45" <?php echo $tfp4?>>:45</option>
               	</select>
                 </td>
                 
            </tr>
            <tr>
                <td class="text5" style="font-weight:bold"><?php echo dic_("To")?> :</td>
                <td class="text5" style="font-weight:bold">
             	
             	<select id="TimeTo2" class="combobox text2">
                <?php
                
                	$TT = pg_fetch_result($dsedit, 0, "timeto");
					$vremeDoSaat = strstr($TT, ':', true);
	
					$tt1 = "";
                    $tt2 = "";
                    $tt3 = "";
					$tt4 = "";
					$tt5 = "";
					$tt6 = "";
					$tt7 = "";
					$tt8 = "";
					$tt9 = "";
					$tt10 = "";
					$tt11 = "";
                    $tt12 = "";
                    $tt13 = "";
					$tt14 = "";
					$tt15 = "";
					$tt16 = "";
					$tt17 = "";
					$tt18 = "";
					$tt19 = "";
					$tt20 = "";
					$tt21 = "";
                    $tt22 = "";
                    $tt23 = "";
					$tt24 = "";
					
					If($vremeDoSaat == "01"){
                       $tt1 = "selected='selected'";
					}
					If($vremeDoSaat == "02"){
                        $tt2 = "selected='selected'";
					}
					If($vremeDoSaat == "03"){
                        $tt3 = "selected='selected'";
					}
					If($vremeDoSaat == "04"){
                        $tt4 = "selected='selected'";
					}
					If($vremeDoSaat == "05"){
                        $tt5 = "selected='selected'";
					}
					If($vremeDoSaat == "06"){
                        $tt6 = "selected='selected'";
					}
					If($vremeDoSaat == "07"){
                        $tt7 = "selected='selected'";
					}
					If($vremeDoSaat == "08"){
                        $tt8 = "selected='selected'";
					}
					If($vremeDoSaat == "09"){
                        $tt9 = "selected='selected'";
					}
					If($vremeDoSaat == "10"){
                        $tt10 = "selected='selected'";
					}
					If($vremeDoSaat == "11"){
                       $tt11 = "selected='selected'";
					}
					If($vremeDoSaat == "12"){
                        $tt12 = "selected='selected'";
					}
					If($vremeDoSaat == "13"){
                        $tt13 = "selected='selected'";
					}
					If($vremeDoSaat == "14"){
                        $tt14 = "selected='selected'";
					}
					If($vremeDoSaat == "15"){
                        $tt15 = "selected='selected'";
					}
					If($vremeDoSaat == "16"){
                        $tt16 = "selected='selected'";
					}
					If($vremeDoSaat == "17"){
                        $tt17 = "selected='selected'";
					}
					If($vremeDoSaat == "18"){
                        $tt18 = "selected='selected'";
					}
					If($vremeDoSaat == "19"){
                        $tt19 = "selected='selected'";
					}
					If($vremeDoSaat == "20"){
                        $tt20 = "selected='selected'";
					}
					If($vremeDoSaat == "21"){
						$tt21 = "selected='selected'";
					}
					If($vremeDoSaat == "22"){
                        $tt22 = "selected='selected'";
					}
					If($vremeDoSaat == "23"){
                        $tt23 = "selected='selected'";
					}
					If($vremeDoSaat == "00"){
                        $tt24 = "selected='selected'";
					}
   					?>
   					
				    <option value="01" <?php echo $tt1?>>01</option>
		            <option value="02" <?php echo $tt2?>>02</option>
		            <option value="03" <?php echo $tt3?>>03</option>
                    <option value="04" <?php echo $tt4?>>04</option>
                    <option value="05" <?php echo $tt5?>>05</option>
                    <option value="06" <?php echo $tt6?>>06</option>
                    <option value="07" <?php echo $tt7?>>07</option>
                    <option value="08" <?php echo $tt8?>>08</option>
                    <option value="09" <?php echo $tt9?>>09</option>
                    <option value="10" <?php echo $tt10?>>10</option>
                    <option value="11" <?php echo $tt11?>>11</option>
		            <option value="12" <?php echo $tt12?>>12</option>
		            <option value="13" <?php echo $tt13?>>13</option>
                    <option value="14" <?php echo $tt14?>>14</option>
                    <option value="15" <?php echo $tt15?>>15</option>
                    <option value="16" <?php echo $tt16?>>16</option>
                    <option value="17" <?php echo $tt17?>>17</option>
                    <option value="18" <?php echo $tt18?>>18</option>
                    <option value="19" <?php echo $tt19?>>19</option>
                    <option value="20" <?php echo $tt20?>>20</option>
                    <option value="21" <?php echo $tt21?>>21</option>
		            <option value="22" <?php echo $tt22?>>22</option>
		            <option value="23" <?php echo $tt23?>>23</option>
                    <option value="00" <?php echo $tt24?>>00</option>
               </select>
               <select id="TimeTo4" class="combobox text2">
               	<?php
	                $TTT = pg_fetch_result($dsedit, 0, "timeto"); 
					$vremeDoMinuti = strstr($TTT, ':');
                    
                    $ttn1 = "";
                    $ttn2 = "";
                    $ttn3 = "";
					$ttn4 = "";
					
					If($vremeDoMinuti == ":00"){
                       $ttn1 = "selected='selected'";
					}
					If($vremeDoMinuti == ":15"){
                       $ttn2 = "selected='selected'";
					}
					If($vremeDoMinuti == ":30"){
                       $ttn3 = "selected='selected'";
					}
					If($vremeDoMinuti == ":45"){
                       $ttn4 = "selected='selected'";
					}
               	?>
               	<option value=":00" <?php echo $ttn1?>>:00</option>
               	<option value=":15" <?php echo $ttn2?>>:15</option>
               	<option value=":30" <?php echo $ttn3?>>:30</option>
               	<option value=":45" <?php echo $ttn4?>>:45</option>
               	</select>
				</td>
            </tr>
            <tr>
                <td class="text5" style="font-weight:bold"><?php dic("Settings.Day")?>:</td>
                <td class="text5" style="font-weight:bold">
                 <select id="TimeType2" class="combobox text2">
                <?php
                	$TD = explode(" ", pg_fetch_result($dsedit, 0, "daytype"));
                    $ttd1 = "";
                    $ttd2 = "";
                    $ttd3 = "";
					$ttd4 = "";
					$ttd5 = "";
                    $ttd6 = "";
					$ttd7 = "";
					$ttd8 = "";
				
					If($TD[0] == "1"){
                       $ttd1 = "selected='selected'";
					}
					If($TD[0] == "2"){
                        $ttd2 = "selected='selected'";
					}
					If($TD[0] == "3"){
                        $ttd3 = "selected='selected'";
					}
					If($TD[0] == "4"){
                        $ttd4 = "selected='selected'";
					}
					If($TD[0] == "5"){
                        $ttd5 = "selected='selected'";
					}
					If($TD[0] == "6"){
                        $ttd6 = "selected='selected'";
					}
					If($TD[0] == "7"){
                        $ttd7 = "selected='selected'";
					}
					If($TD[0] == "8"){
                        $ttd8 = "selected='selected'";
					}
					?>
					<option value="1" <?php echo $ttd1?>><?php dic("Settings.Monday")?></option>
		            <option value="2" <?php echo $ttd2?>><?php dic("Settings.Tuesday")?></option>
		            <option value="3" <?php echo $ttd3?>><?php dic("Settings.Wednesday")?></option>
                    <option value="4" <?php echo $ttd4?>><?php dic("Settings.Thursday")?></option>
                    <option value="5" <?php echo $ttd5?>><?php dic("Settings.Friday")?></option>
                    <option value="6" <?php echo $ttd6?>><?php dic("Settings.Saturday")?></option>
                    <option value="7" <?php echo $ttd7?>><?php dic("Reports.Sunday")?></option>
                    <option value="8" <?php echo $ttd8?>><?php dic("Settings.Holiday")?></option>
           </select>
           </td>
            </tr>
            <tr>
                <td class="text5" style="font-weight:bold"><?php dic("Settings.Shift")?>:</td>
                <td class="text5" style="font-weight:bold">
                   <select id="TimeShift2" class="combobox text2">
                <?php
                	$TS = explode(" ", pg_fetch_result($dsedit, 0, "shift"));
                    $tts1 = "";
                    $tts2 = "";
                    $tts3 = "";
					$tts4 = "";

					If($TS[0] == "1"){
                       $tts1 = "selected='selected'";
					}
					If($TS[0] == "2"){
                        $tts2 = "selected='selected'";
					}
					If($TS[0] == "3"){
                        $tts3 = "selected='selected'";
					}
					If($TS[0] == "4"){
                        $tts4 = "selected='selected'";
					}

                ?>
					<option value="1" <?php echo $tts1?>>1</option>
		            <option value="2" <?php echo $tts2?>>2</option>
		            <option value="3" <?php echo $tts3?>>3</option>
                    <option value="4" <?php echo $tts4?>>4</option>
               </select>
               </td>
            </tr>
</table>
<script>
lang = '<?php echo $cLang?>';
</script>
<?php
	closedb();
?>
