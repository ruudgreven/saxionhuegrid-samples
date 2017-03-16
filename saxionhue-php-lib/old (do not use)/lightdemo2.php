<?php
/**
 * Very hacky, very ugly implementation of a light plan
 */

// URL of the webserver
$url = "http://localhost:3000";

// Hard coded colors
$colors = array();
$colors[] = array("r" => 255, "g" => 0, "b" => 0);
$colors[] = array("r" => 255, "g" => 127, "b" => 0);
$colors[] = array("r" => 255, "g" => 255, "b" => 0);
$colors[] = array("r" => 0, "g" => 255, "b" => 0);
$colors[] = array("r" => 0, "g" => 0, "b" => 255);
$colors[] = array("r" => 75, "g" => 0, "b" => 130);
$colors[] = array("r" => 143, "g" => 0, "b" => 255);

// Default light settings
$basicLightSetting = array("x" => 0, 
						   "y" => 0, 
						   "bri" => 255, 
						   "on" => true, 
						   "duration" => 0,
						   "color" => array("r" => 255, "g" => 0, "b" => 0));

// Turn all lights off
$basicLightSetting["on"] = false;
for ($y=0; $y<=5; $y++) {
	changeRow($y, $basicLightSetting);
}

// Light plan
$basicLightSetting["on"] = true;
$currentRow = 0;
while (true) {
	for ($i=$currentRow; $i>=0; $i--) {
		$basicLightSetting["color"] = $colors[$currentRow-$i];
		changeRow($i+1, $basicLightSetting);
	}
	sleep(3);
	$currentRow = ($currentRow + 1) % 5;
}

// Turn on a row
function changeRow($y, $lightSetting) {
	for ($x=0; $x<3; $x++) {
		$lightSetting["y"] = $y;
		$lightSetting["x"] = $x;
		changeLight($lightSetting);
	}
}

// Change status of single light
function changeLight($data) {
	global $url;
	$data_string = json_encode($data);                                                                                   
	                                                                                                                     
	$ch = curl_init($url . "/light");                                                                      
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
	    'Content-Type: application/json',                                                                                
	    'Content-Length: ' . strlen($data_string))                                                                       
	);                                                                                                                   
	                                                                                                                     
	$result = curl_exec($ch);
	return $result;
}

?>