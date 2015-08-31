<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>

<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php session_start()?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php //response.ContentType="application/vnd.ms-excel" ?>
<?php //response.AppendHeader("content-disposition", "attachment;filename=Nalog.xls") ?>
<?php

	$id = getQUERY("id");
	opendb();
	$sqlP = "";
	$sqlP .= "select v.Code ||'-'|| v.Registration vozilo, d1.FullName sofer1, d2.FullName sofer2, d3.FullName sofer3, h.Datetime, u.FullName korisnik ";
	$sqlP .= "from rNalogHeder h ";
	$sqlP .= "left outer join Vehicles v on v.ID=h.vehicleID ";
	$sqlP .= "left outer join Drivers d1 on h.DriverId1=d1.ID ";
	$sqlP .= "left outer join Drivers d2 on h.DriverId2=d2.ID ";
	$sqlP .= "left outer join Drivers d3 on h.DriverId3=d3.ID ";
	$sqlP .= "left outer join Users u on u.id=h.userID ";
	$sqlP .= "where h.id=" . $id;
	$dsNalog = query($sqlP);	
	
	//echo pg_fetch_result($dsNalog, 0, "vozilo");
	//exit;
?>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif; font-size: 16px;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif; font-size: 12px;
}
.style3 {
	font-family: Arial, Helvetica, sans-serif; font-size: 14px;
}

-->
</style>
<body style="background-color:#FFFFFF">
<br />
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td style="border:1px solid #999999;" height="1000px" align="center" valign="top">
			<table width="700" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td colspan="2" align="center" valign="middle" class="style1">Патен налог број: <strong style="font-size:36px"><?php echo $id?></strong></td>
			  </tr>
			  <tr>
				<td colspan="2" align="center" valign="middle" class="style1">&nbsp;</td>
			  </tr>
			  <tr>
				<td height="30px" width="50%" align="left" valign="middle" class="style2">Возило: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "vozilo")?></strong></td>
				<td height="30px" width="50%" align="right" valign="middle" class="style2">Датум на изработка: <strong><?php echo pg_fetch_result($dsNalog, 0, "datetime")?></strong> </td>
			  </tr>
			  			  <tr>
				<td height="30px" align="left" valign="middle" class="style2">Прв возач: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "sofer1")?></strong></td>
				<td height="30px" align="right" valign="middle" class="style2">Приготвил: <strong><?php echo pg_fetch_result($dsNalog, 0, "korisnik")?></strong></td>
			  </tr>
			  <tr>
				<td height="30px" align="left" valign="middle" class="style2">Втор возач: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "sofer2")?></strong></td>
				<td height="30px" align="right" valign="middle" class="style2">&nbsp;</td>
			  </tr>
			  <tr>
				<td height="30px" align="left" valign="middle" class="style2">Трет возач: <strong class="style3"><?php echo pg_fetch_result($dsNalog, 0, "sofer3")?></strong></td>
				<td height="30px" align="right" valign="middle" class="style2">&nbsp;</td>
			  </tr>
			  <tr>
			    <td height="30px" colspan="2" align="center" valign="middle" class="style2">
					<strong class="style2">Локаци за посета</strong><br />
					<table width="650" border="0">
						<tr>
							<td width="50px" height="22px" class="style2" style="border:1px solid #666666; background-color:#CCCCCC" align="center"><strong>Р. Бр.</strong></td>
							<td width="300px" height="22px" class="style2" style="border:1px solid #666666; background-color:#CCCCCC">&nbsp;<strong>Локација</strong></td>
							<td width="300px" height="22px" class="style2" style="border:1px solid #666666; background-color:#CCCCCC">&nbsp;<strong>Забелешка</strong></td>							
						</tr>					
						<?php
							
							$dsDet = query("select * from rNalogDetail where HederID=" . $id . " order by rbr");
							
							while($row = pg_fetch_array($dsDet))
							{
						?>
						<tr>
							<td width="50px" height="22px" class="style2" style="border:1px solid #666666" align="center"><?php echo $row["rbr"]?></td>
							<td width="300px" height="22px" class="style2" style="border:1px solid #666666">&nbsp;<?php echo $row["opis"]?></td>
							<td width="300px" height="22px" class="style2" style="border:1px solid #666666">&nbsp;</td>							
						</tr>											
						<?php
							}
						?>
						
				  </table><br />&nbsp;				</td>
		      </tr>
			  <tr>
			    <td height="30px" align="center" valign="middle" class="style2">
				</td>
				<td height="30px" align="center" valign="middle" class="style2">
				  ________________________________<br />Потпис 
				</td>
				
		      </tr>
			  <tr>
			    <td height="30px" colspan="2" align="center" valign="middle" class="style2">&nbsp;</td>
		      </tr>
			</table>
		</td>
	</tr>
</table>
</body>