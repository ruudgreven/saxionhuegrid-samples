<?php
/**
 * Very hacky, very ugly implementation of a simple light plan (moving from beginning till end)
 */

// Url of the REST api
$url = "http://localhost:3000";

// Rainbow colors
$colors = array();
$colors[] = array("r" => 255, "g" => 127, "b" => 0);
$colors[] = array("r" => 255, "g" => 255, "b" => 0);
$colors[] = array("r" => 0, "g" => 255, "b" => 0);
$colors[] = array("r" => 0, "g" => 0, "b" => 255);
$colors[] = array("r" => 75, "g" => 0, "b" => 130);
$colors[] = array("r" => 143, "g" => 0, "b" => 255);
$colors[] = array("r" => 255, "g" => 0, "b" => 0);

$basicLightSetting = array("x" => 0, 
						   "y" => 0, 
						   "bri" => 255, 
						   "on" => true, 
						   "duration" => 3,
						   "color" => array("r" => 255, "g" => 0, "b" => 0));

// Simple moving light
$direction = 1;
while (true) {
	foreach ($colors as $cIndex => $colors) {
		changeLightGridWithDirection($colors, $direction);
		$direction = ($direction + 1) %2;
	}
}

// Function for moving light with direction (ugly and fast programming with some beers :-) )
function changeLightGridWithDirection($color, $direction = 1) {
	global $basicLightSetting;
	$basicLightSetting["color"] = $color;
	if ($direction == 1) {
		for ($i=0; $i<5; $i++) {
			changeRow($i, $basicLightSetting);
			sleep(3);
		}
	} else {
		for ($i=5; $i>=0; $i--) {
			changeRow($i, $basicLightSetting);
			sleep(3);
		}
	}	
}

// Change rows
function changeRow($y, $lightSetting) {
	for ($x=0; $x<3; $x++) {
		$lightSetting["y"] = $y;
		$lightSetting["x"] = $x;
		echo changeLight($lightSetting);
	}
}

// Change a single light
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