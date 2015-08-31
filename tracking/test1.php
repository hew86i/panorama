<?php
	define( 'NM', "org.freedesktop.NetworkManager" );
	$d = new Dbus( Dbus::BUS_SYSTEM, true );
	$n = $d->createProxy( NM, "/org/freedesktop/NetworkManager", NM);
	$wifi = array();
	foreach ($n->GetDevices()->getData() as $device)
	{
		$device = $device->getData();
		$dev = $d->createProxy( NM, $device, "org.freedesktop.DBus.Properties");
		$type = $dev->Get(NM . ".Device", "DeviceType")->getData();
		if ( $type == 2 ) // WI-FI
		{
			$wifiDev = $d->createProxy(NM, $device, NM . ".Device.Wireless");
			foreach( $wifiDev->GetAccessPoints()->getData() as $ap )
			{
				$apDev = $d->createProxy(NM, $ap->getData(), "org.freedesktop.DBus.Properties");
				$props = $apDev->GetAll(NM . ".AccessPoint")->getData();
				$ssid = '';
				foreach( $props['Ssid']->getData()->getData() as $n )
				{
					$ssid .= chr($n);
				}
				$wifi[] = array('ssid' => $ssid, "mac_address" => $props['HwAddress']->getData() );
			}
		}
	}
	$request = array( 'version' => '1.1.0', 'host' => 'example.com', 'wifi_towers' => $wifi );
	$c = curl_init();
	curl_setopt( $c, CURLOPT_URL, 'https://www.google.com/loc/json' );
	curl_setopt( $c, CURLOPT_POST, 1 );
	curl_setopt( $c, CURLOPT_POSTFIELDS, json_encode( $request ) );
	curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
	$result = json_decode( curl_exec( $c ) )->location;
	echo "<a href='http://openstreetmap.org/?lat={$result->latitude}&amp;lon={$result->longitude}&amp;zoom=18'>here</a>\n";
?>