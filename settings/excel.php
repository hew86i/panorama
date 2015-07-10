<?php include "../include/functions.php" ?>
<?php include "../include/db.php" ?>
<?php include "../include/params.php" ?>
<?php include "../include/dictionary2.php" ?>
<?php
opendb();

$denes = now();  
$klientID= Session("client_id");
$klient = query("select * from clients where id = ".$klientID);
$imeKlient = pg_fetch_result($klient, 0, "name");
$jazik = str_replace("'", "''", NNull($_GET['l'], ''));

header("Content-type: application/x-msdownload"); 
header("Content-Disposition: attachment; filename=$imeKlient - POI - $denes.xls"); 
header("Pragma: no-cache"); 
header("Expires: 0");

?>

<html>
<head>
	<script type="application/javascript">
		lang = '<?php echo $jazik?>';
	</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

	<?php
	$ds=query("SELECT * from pointsofinterestgroups where clientid = " . Session("client_id"));
	$search = "select * from pointsofinterest where clientid = " . Session("client_id") ;
	$sear = query($search);
	
	if(pg_num_rows($sear)==0){
		echo dic("Reports.NoData1");
	}
	else
	{
	?>
	
	<body>
	<br><br>		
	<table border="1" width="95%" cellspacing="10" cellpadding="10" style="margin-top:30px; margin-left:35px">
	<tr></tr>
	<tr>
	<td colspan = "14" align = "center" height="40px" class="text2"  style="color:#fff; font-weight:bold; font-size:14px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b; font-weight:bold;">
	<b><font size = "3"><?php echo dic("Settings.NotGroupedItems")?></font></b>	
	</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
	<td colspan="4" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Reports.NamePoi")?></b></font></td> 
	<td colspan="1" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Tracking.Radius")?></b></font></td>
	<td colspan="1" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Settings.TypeOfPoi")?></b></font></td>
	<td colspan="2" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Settings.AvailableFor1")?></b></font></td>
	<td colspan="2" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Routes.CreatedBy")?></b></font></td>
	<td colspan="2" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Settings.LongitudeName")?></b></font></td>
	<td colspan="2" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Settings.LatitudeName")?></b></font></td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	
	<?php
	
	$poi1 = query("select id,clientid,groupid,name,type,radius,available,userid from pointsofinterest where groupid = 1 and active = '1' and clientid = " . Session("client_id"));		
	
	while ($row2 = pg_fetch_array($poi1))
	{
			if($row2["type"] == 1)
			{
				$lat = dlookup("select st_y(st_transform(geom,4326)) lat from pointsofinterest where id=" . $row2["id"]);
				$lon = dlookup("select st_x(st_transform(geom,4326)) lon from pointsofinterest where id=" . $row2["id"]);
			} 
			else
			{
				$lon = dlookup("select st_y(st_centroid(geom)) lon from pointsofinterest where id=" . $row2["id"]);
				$lat = dlookup("select st_x(st_centroid(geom)) lat from pointsofinterest where id=" . $row2["id"]);
			} 
	?>
	<tr>
		<td colspan="4" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
		<font color = "red"><b><?php echo $row2['name'] ?></b></font>
		</td>
		<td colspan="1" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
		<font color = "red"><b><?php echo $row2['radius'] ?></b></font>
		</td>
		<td colspan="1" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
			
				<?php 
				if($row2["type"] == 1)
				{
				?>	
				<font color = "red"><b><?php echo dic("Settings.POI")?></b></font>
				<?php
				}
				if($row2["type"] == 2)
				{
				?>
				<font color = "red"><b><?php echo dic("Reports.GeoFence")?></b></font>
				<?php
				}
				if($row2["type"] == 3)
				{
				?>
				<font color = "red"><b><?php echo dic("Settings.Polygon")?></b></font>
				<?php
				}
				?><br>
		</td>
		<td colspan="2" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
				<?php 
				if($row2["available"] == 1)
				{
				?>	
				<font color = "red"><b><?php echo dic("Routes.User")?></b></font>
				<?php
				}
				if($row2["available"] == 2)
				{
				?>
				<font color = "red"><b><?php echo dic("Reports.OrgUnit")?></b></font>
				<?php
				}
				if($row2["available"] == 3)
				{
				?>
				<font color = "red"><b><?php echo dic("Settings.Company")?></b></font>
				<?php
				}
				?>
		</td>
		<td colspan="2" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
		<b>
		<br>
				<?php 
				if($row2["userid"] == "")
				{
				?>
					( <?php echo "/";?> )
				<?php
				}
				else
				{
					$najdiKreator = query("select * from users where id = ".$row2["userid"]);
					$imeto = pg_fetch_array($najdiKreator);
				?>
			    (<?php echo $imeto["fullname"];?>)
			    
			    <?php 
				}
			    ?>
		</b>
		</td>
		<td colspan="2" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
		<b>
		<?php 
					echo number_format($lon, 6, '.', '' );
		?>
		</b>
		</td>
		<td colspan="2" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
		<b>
		<?php 
					echo number_format($lat, 6, '.', '' );
		?>
		</b>
		</td>
	</tr>
	<?php
	}
	?>
		
	<tr><td>&nbsp;</td></tr>
	</table>
	<br><br>
	<?php
	$i = 1;
    $pecati = query("SELECT * from pointsofinterestgroups where clientid = " . Session("client_id"));
 	while ($row = pg_fetch_array($pecati))
 	{
 		
	 ?>
	<br><br>
	<table border="1" width="95%" cellspacing="10" cellpadding="10" style="margin-top:30px; margin-left:35px">
	<tr></tr>
	<tr>
	<td colspan = "14" align = "center" height="40px" class="text2"  style="color:#fff; font-weight:bold; font-size:14px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b; font-weight:bold;">
	<b><font size = "3"><?php echo dic("Reports.Group")?> <?php echo $row["name"] ?></font></b>
	</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
	<td colspan="4" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Reports.NamePoi")?></b></font></td> 
	<td colspan="1" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Tracking.Radius")?></b></font></td>
	<td colspan="1" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Settings.TypeOfPoi")?></b></font></td>
	<td colspan="2" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Settings.AvailableFor1")?></b></font></td>
	<td colspan="2" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Routes.CreatedBy")?></b></font></td>
	<td colspan="2" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Settings.LongitudeName")?></b></font></td>
	<td colspan="2" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Settings.LatitudeName")?></b></font></td>
	</tr>
	<tr></tr>
		<?php
		$poi = query("select id,clientid,groupid,name,type,radius,available,userid from pointsofinterest where groupid = " . $row["id"] . " and active = '1' and clientid = " . Session("client_id"));
		while ($row1 = pg_fetch_array($poi))
 		{
 			if($row1["type"] == 1)
			{
				$lat = dlookup("select st_y(st_transform(geom,4326)) lat from pointsofinterest where id=" . $row1["id"]);
				$lon = dlookup("select st_x(st_transform(geom,4326)) lon from pointsofinterest where id=" . $row1["id"]);
			} 
			else
			{
				$lon = dlookup("select st_y(st_centroid(geom)) lon from pointsofinterest where id=" . $row1["id"]);
				$lat = dlookup("select st_x(st_centroid(geom)) lat from pointsofinterest where id=" . $row1["id"]);
			}	
		?>
		<tr>
			<td colspan="4" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
		<font color = "red"><b><?php echo $row1['name'] ?></b></font>
		</td>
		<td colspan="1" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
		<font color = "red"><b><?php echo $row1['radius'] ?></b></font>
		</td>
		<td colspan="1" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
				<?php 
				if($row1["type"] == 1)
				{
				?>	
				<font color = "red"><b><?php echo dic("Settings.POI")?></b></font>
				<?php
				}
				if($row1["type"] == 2)
				{
				?>
				<font color = "red"><b><?php echo dic("Reports.GeoFence")?></b></font>
				<?php
				}
				if($row1["type"] == 3)
				{
				?>
				<font color = "red"><b><?php echo dic("Settings.Polygon")?></b></font>
				<?php
				}
				?><br>
		</td>
		<td colspan="2" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
				<?php 
				if($row1["available"] == 1)
				{
				?>	
				<font color = "red"><b><?php echo dic("Routes.User")?></b></font>
				<?php
				}
				if($row1["available"] == 2)
				{
				?>
				<font color = "red"><b><?php echo dic("Reports.OrgUnit")?></b></font>
				<?php
				}
				if($row1["available"] == 3)
				{
				?>
				<font color = "red"><b><?php echo dic("Settings.Company")?></b></font>
				<?php
				}
				?>
		</td>
		<td colspan="2" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
		<b>
		<br>
				<?php 
				if($row1["userid"] == "")
				{
				?>
					( <?php echo "/";?> )
				<?php
				}
				else
				{
					$najdiKreator = query("select * from users where id = ".$row1["userid"]);
					$imeto = pg_fetch_array($najdiKreator);
				?>
			    (<?php echo $imeto["fullname"];?>)
			    
			    <?php 
				}
			    ?>
		</b>
		</td>
		<td colspan="2" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
		<b>
		<?php 
					echo number_format($lon, 6, '.', '' );
		?>
			    
		</b>
		</td>
		<td colspan="2" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
		<b>
		<?php 
					echo number_format($lat, 6, '.', '' );
		?>
			    
		</b>
		</td>
		</tr>
		<?php
		}
		?>
		<tr><td>&nbsp;</td></tr>
	</table>	
<?php
$i++;
}
}

?>
<br><br>


<?php 

	$proverkaNeaktivni = dlookup("select count(*) from pointsofinterest where active = '0' and clientid = " . Session("client_id")."");
	if($proverkaNeaktivni>0)
	{

?>
<table border="1" width="95%" cellspacing="10" cellpadding="10" style="margin-top:30px; margin-left:35px">
	<tr></tr>
	<tr>
	<td colspan = "14" align = "center" height="40px" class="text2"  style="color:#fff; font-weight:bold; font-size:14px; border:1px solid #ff6633; padding-left:7px; background-color:#f7962b; font-weight:bold;">
	<b><font size = "3"><?php dic("Settings.InactivePOIHeader")?></font></b>	
	</td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	<tr>
	<td colspan="4" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Reports.NamePoi")?></b></font></td> 
	<td colspan="1" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Tracking.Radius")?></b></font></td>
	<td colspan="1" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Settings.TypeOfPoi")?></b></font></td>
	<td colspan="2" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Settings.AvailableFor1")?></b></font></td>
	<td colspan="2" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Routes.CreatedBy")?></b></font></td>
	<td colspan="2" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Settings.LongitudeName")?></b></font></td>
	<td colspan="2" align = "center" width="85%" height="22px" align="center" class="text2" style="font-weight:bold; background-color:#E5E3E3; border:1px dotted #2f5185; padding-left:20px"><font color = "blue"><b><?php dic("Settings.LatitudeName")?></b></font></td>
	</tr>
	<tr><td>&nbsp;</td></tr>
	
	<?php
	
	$poi1 = query("select id,clientid,groupid,name,type,radius,available,userid from pointsofinterest where active = '0' and clientid = " . Session("client_id"));		
	
	while ($row2 = pg_fetch_array($poi1))
	{
		
			if($row2["type"] == 1)
			{
				$lat = dlookup("select st_y(st_transform(geom,4326)) lat from pointsofinterest where id=" . $row2["id"]);
				$lon = dlookup("select st_x(st_transform(geom,4326)) lon from pointsofinterest where id=" . $row2["id"]);
			} 
			else
			{
				$lon = dlookup("select st_y(st_centroid(geom)) lon from pointsofinterest where id=" . $row2["id"]);
				$lat = dlookup("select st_x(st_centroid(geom)) lat from pointsofinterest where id=" . $row2["id"]);
			} 
	?>
	
	<tr>
		<td colspan="4" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
		<font color = "red"><b><?php echo $row2['name'] ?></b></font>
		</td>
		<td colspan="1" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
		<font color = "red"><b><?php echo $row2['radius'] ?></b></font>
		</td>
		<td colspan="1" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
				<?php 
				if($row2["type"] == 1)
				{
				?>	
				<font color = "red"><b><?php echo dic("Settings.POI")?></b></font>
				<?php
				}
				if($row2["type"] == 2)
				{
				?>
				<font color = "red"><b><?php echo dic("Reports.GeoFence")?></b></font>
				<?php
				}
				if($row2["type"] == 3)
				{
				?>
				<font color = "red"><b><?php echo dic("Settings.Polygon")?></b></font>
				<?php
				}
				?><br>
		</td>
		<td colspan="2" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
				<?php 
				if($row2["available"] == 1)
				{
				?>	
				<font color = "red"><b><?php echo dic("Routes.User")?></b></font>
				<?php
				}
				if($row2["available"] == 2)
				{
				?>
				<font color = "red"><b><?php echo dic("Reports.OrgUnit")?></b></font>
				<?php
				}
				if($row2["available"] == 3)
				{
				?>
				<font color = "red"><b><?php echo dic("Settings.Company")?></b></font>
				<?php
				}
				?>
		</td>
		<td colspan="2" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
		<b>
		<br>
				<?php 
				if($row1["userid"] == "")
				{
				?>
						
					( <?php echo "/";?> )
				<?php
				}
				else
				{
					$najdiKreator = query("select * from users where id = ".$row1["userid"]);
					$imeto = pg_fetch_array($najdiKreator);
				?>
				
			    (<?php echo $imeto["fullname"];?>)
			    <?php }?>
		</b>
		</td>
		<td colspan="2" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
		<b>
		<?php 
					echo number_format($lon, 6, '.', '' );
		?>
		</b>
		</td>
		<td colspan="2" align = "center" width="50px" height="30px" class="text2" style="background-color:#fff; border:1px dotted #B8B8B8; padding-left:20px">
		<b>
		<?php 
					echo number_format($lat, 6, '.', '' );
		?>
		</b>
		</td>
		
		
	</tr>
	<?php
	}
	?>
		
	<tr><td>&nbsp;</td></tr>
	</table>

	<?php 
	}
	closedb();
	?>

</body>
</html>