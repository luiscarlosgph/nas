#!/usr/bin/php
<?php

// Failover Internet connection through the mobile phone network

// Constants
$wifi_ssid = 'virginmedia4466099';
$wifi_bssid = urlencode('74:44:01:68:be:b5');
$wifi_pass = 'radiohead';
$mobile_ssid1 = 'SKY6B23A';
$mobile_bssid1 = urlencode('38:0b:40:d6:a7:45');
$mobile_pass1 = 'gofiopicon';
$mobile_ssid2 = 'yupizone';	
$mobile_bssid2 = urlencode('bc:b1:f3:d9:bc:0d');
$mobile_pass2 = 'demiparati';	
$curl = curl_init();
// $mobile_bssid2 = urlencode('c8:14:79:16:77:eb'); Stolen phone v2!
// $mobile_bssid1 = urlencode('04:46:65:9e:7b:31'); Galaxy S2
// $mobile_bssid2 = urlencode('e8:4e:84:bb:d0:e5'); Stolen phone!
// $mobile_bssid2 = urlencode('bc:b1:f3:d9:bc:0d'); Old and tiny Marta's phone!

// Parsing state machine
abstract class parsingState {
    const get_essid   = 0;
    const get_channel = 1;
}

// Functions

/**
 * Deassociates Tenda router from AP.
 * Input: global variable $curl is used.
 * Output: nothing.
 */
function deassociateTenda() {
	global $curl;
	curl_setopt($curl, CURLOPT_COOKIE, 'admin:language=zh-cn');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_URL, 'http://tenda/goform/SysStatusHandle?CMD=WAN_CON&GO=system_status.asp&action=1');
	curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
	$buffer = curl_exec($curl);	
}

/**
 * Clean all previous configurations.
 * Input: nothing.
 * Output: nothing.
 */
/*
function resetConfig() {
	system('iptables-restore < /etc/iptables.rules');
} 
*/

/**
 * Scan WiFi networks using local wifi usb dongle. 
 * Input: nothing.
 * Output: return a hash (ssid, channel) with all the networks detected by the router.
 */
function scanAps() {	
	global $curl;
	$netarray = '';

	// Scan APs - 3 times
	for($i = 3; $i > 0; $i--) {
		curl_setopt($curl, CURLOPT_URL, 'http://tenda/goform/GetScanStr');
		curl_setopt($curl, CURLOPT_COOKIE, 'admin:language=zh-cn');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
		$buffer = curl_exec($curl);
		$netarray .= $buffer;
	}	

	$netarray = preg_split("/[\r]/", $netarray);
	foreach($netarray as $net) {
		$split = preg_split('/[;]/', $net);
		if(count($split) == 7)
			$networks[$split[0]] = $split[2];
	} 
	
	/*	
	$wireless_if = 'wlan0';
	$shell_out = shell_exec("iwlist $wireless_if scan | grep -P 'ESSID|Channel' | tr -d ' '");

	// Parsing output to create the hash (essid, channel)
	$networks = array();
	$parsing_state = parsingState::get_essid;
	foreach(preg_split("/((\r?\n)|(\r\n?))/", $shell_out) as $line) {
		if($parsing_state == parsingState::get_essid) {
			if(preg_match("/ESSID:\"(.+)\"/", $line, $parsing_vector)) {			
				$essid = $parsing_vector[1];
				$parsing_state = parsingState::get_channel;
			}
		}
		else {
			preg_match("/\(Channel(.+)\)/", $line, $parsing_vector);			
			$channel = $parsing_vector[1];
			$parsing_state = parsingState::get_essid;
			$networks[$essid] = $channel;
		}
	}
	*/
	return $networks; 
}

// Returns true if Tenda is associated to other AP, either the WiFi or the 3G
function is_tenda_associated() {
	global $curl;
	$is_conn = false;
	curl_setopt($curl, CURLOPT_COOKIE, 'admin:language=zh-cn');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_URL, 'http://tenda/system_status.asp');
	curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
	
	$buffer = curl_exec($curl);	
	if(preg_match('/cableDSL="3";/', $buffer)) {
		$is_conn = true;
	}
	else {
		$is_conn = false;
	}
		
	return $is_conn;
}

/**
 * Send new config to Tenda. It waits until Tenda is connected to other AP.
 * Input: 
 *    essid: name of the network to connect to.
 *    pass: WPA key of the access point. 
 * Output: 
 * 	It waits only for a certain timeout and then returns false if
 * 	Tenda did not associate within that time. Otherwise returns false.
 */
function connectToAp($essid, $bssid, $pass, $channel) {
	global $curl;
	global $wifi_ssid;

	$safe_setting = $essid == $wifi_ssid ? 2 : 3;
	$post_fields = "mode=wisp&SSID10=SKY91546&channel10=1&safe_setting10=WPA2PSK&type_wep10=OPEN&defaultKey10=1&key1_10=12345&key1_format10=1&key2_10=12345&key2_format10=1&key3_10=12345&key3_format10=1&key4_10=12345&key4_format10=1&algorithm10=AES&psk_password10=putoncillo&AP_SSID11=$essid&AP_MACAddr11=$bssid&ext_channel11=NONE&channel11=$channel&safe_setting11=$safe_setting&type_wep11=0&defaultKey11=1&key_format11=1&key1_11=Micklemak1989&key2_11=&key3_11=&key4_11=&algorithm11=1&psk_password11=$pass&scanTbl_row=on&connectWay20=1&userName20=&password20=&ipAddr20=10.22.10.2&subMask20=255.255.255.0&defaultGateway20=10.22.10.1&firstDnsServer20=10.22.10.1&spareDnsServer20=10.22.10.1&macAddr20=C8%3A3A%3A35%3AFE%3A01%3A11";

	curl_setopt($curl, CURLOPT_COOKIE, 'admin:language=zh-cn');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_URL, 'http://tenda/goform/SetFastSetting');
	curl_setopt($curl, CURLOPT_POST, 40);	
	curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);
	curl_exec($curl);
	curl_setopt($curl, CURLOPT_URL, 'http://tenda/goform/DhcpSetSer?GO=lan_dhcps.asp&dhcpEn=0&dips=192.168.2.3&dipe=192.168.2.10&DHLT=3600');
	curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
	$buffer = curl_exec($curl);
	
	// Wait for Tenda to connect the other AP (WiFi or 3G)
	$timeout = 30; // seconds
	while(!is_tenda_associated() && $timeout > 0) {
		sleep(1);
		$timeout--;
	}	
} 

/**
 * Connects to the WiFi network.
 * Input: SSID, password and channel of the wireless network we want to connect to.
 * Output: nothing.
 */
function connectToWifi($wifi_ssid, $wifi_bssid, $wifi_pass, $wifi_chan) {
	connectToAp($wifi_ssid, $wifi_bssid, $wifi_pass, $wifi_chan);
}

/**
 * Connects to the 3G network available. 
 * Input: nothing.
 * Output: true if any of the 3G networks is detected, otherwirse false is returned.
 */
function connectTo3g($mobile_ssid, $mobile_bssid, $mobile_pass, $mobile_chan) {
	print("Connecting to $mobile_ssid...");
	connectToAp($mobile_ssid, $mobile_bssid, $mobile_pass, $mobile_chan);
	print(" OK\n");
}

// Returns true if we are connected to the Internet. 
/*
function is_connected() {
	global $curl;
	$is_conn = false;
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_URL, 'http://www.google.com');
	curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
	
	$buffer = curl_exec($curl);	
	if($buffer === FALSE) {
		$is_conn = FALSE;
	}
	else {
		$is_conn = TRUE;
	}
		
	return $is_conn;

}
*/

// Returns true if we are connected to Virgin.
/*
function is_connected_to_wifi() {
	global $curl;
	$is_conn = false;
	curl_setopt($curl, CURLOPT_COOKIE, 'admin:language=zh-cn');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($curl, CURLOPT_URL, 'http://tenda/system_status.asp');
	curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
	
	$buffer = curl_exec($curl);	
	if(preg_match('/gateWay="192.168.0.1";/', $buffer)) {
		$is_conn = TRUE;
	}
	else {
		$is_conn = FALSE;
	}
		
	return $is_conn;
}
*/

// Main code

// print('Discovering if we have Internet connection...');
deassociateTenda(); 
/*
if (is_connected()) { // Connected to the Internet
	print(" YES\nDiscovering if we are connected to WiFi...");

	if (!is_connected_to_wifi()) {
		print(" NO\nScanning wireless networks...");
		$aps = scanAps();
		print_r(" OK\nDiscovered networks:\n");
		var_dump($aps);

		if(array_key_exists($wifi_ssid, $aps)) { // If WiFi detected we connect to it
			print("Connecting to WiFi...\n");
			resetConfig();
			connectToWifi($wifi_ssid, $wifi_bssid, $wifi_pass, 1);
		}
	}
}
else { // Not connected to the Internet
*/

print("\nScanning wireless networks...");
$aps = scanAps();
print_r(" OK\nDiscovered networks:\n");
var_dump($aps);

/* Debugging
resetConfig();
connectTo3g($mobile_ssid1, $mobile_bssid1, $mobile_pass1, $aps[$mobile_ssid1]);
exit();
*/

/*
if(array_key_exists($wifi_ssid, $aps)) { // If WiFi detected we connect to it
	print("Connecting to WiFi...\n");
	resetConfig();
	connectToWifi($wifi_ssid, $wifi_bssid, $wifi_pass, 1);
}
else if(array_key_exists($mobile_ssid1, $aps)) { // If 3g hotspot 1 detected 
*/
if(array_key_exists($mobile_ssid1, $aps)) { // If 3g hotspot 1 detected 
	print("Connecting to mobile network 1...\n");
	// resetConfig();
	connectTo3g($mobile_ssid1, $mobile_bssid1, $mobile_pass1, 1);
}
else if(array_key_exists($mobile_ssid2, $aps)) { // If 3g hotspot 2 detected
	print("Connecting to mobile network 2...\n");
	// resetConfig();
	connectTo3g($mobile_ssid2, $mobile_bssid2, $mobile_pass2, $aps[$mobile_ssid2]);
}
// }

?>
