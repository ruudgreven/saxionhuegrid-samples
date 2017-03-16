<?php
/**
 * Basic implementation of a light plan with simple PHP class library
 * Author: Evert Duipmans
 * Date: 13-03-2017
 */
require_once("../classes/Communicator.php");
require_once("../classes/Grid.php");
require_once("../classes/Light.php");
require_once("../classes/ColorMap.php");

// Use rainbow colors
$rainbow = ColorMap::rainbow();

// Object for communicating with the REST API
$communicator = new Communicator("http://localhost:3000");

// Initialize default grid
$grid = new Grid();

// Turn off all lights
$grid->turnOff();

// Send signal to hue grid (API call)
$communicator->updateGrid($grid);

// Execute light plan (ignore last row with the single light)
lightPlan1(true);

/**
 * Demo light plan 1: Change the lights rows by row. When the last row is reached, start over with the next color in opposite direction
 */
function lightPlan1($ignoreLastRow=true) {
	// Make global variables available in the function
	global $communicator, $grid, $rainbow;

	// Variable indicating the direction of the animation
	$moveForward = true;

	// Determine grid size
	$gridLength = $grid->getHeight() - (($ignoreLastRow) ? 1 : 0);

	$currentRow = 0;
	$currentColorIndex = 0;

	while (true) {

		// Update each row, until the whole grid is filled
		for ($i=0; $i<$gridLength; $i++) {
			// Determine the current row (based on direction)
			$currentRow = (($moveForward) ? $i : $gridLength-1 -$i);

			// Update row
			$grid->changeRow($currentRow, array("duration" => 8, "color" => $rainbow[$currentColorIndex]));

			// Send request
			$communicator->updateGrid($grid);

			// Sleep for 10 seconds
			sleep(10);	
		}

		// Goto next color
		$currentColorIndex = ($currentColorIndex + 1) % count($rainbow);

		// Change direction
		$moveForward = !$moveForward;
	}
}


/**
 Example of changing light with the grid bit pattern
 */
// Get structure of the grid and set all bits to true
//$gridBitArray = $grid->getGridBitArray(true);

// New settings that should be applied for every light that has been selected in the bit array
//$newSetting = array("on" => false, "color" => new Color(255, 255, 0));

// Change the pattern
//$grid->changePattern($gridBitArray, $newSetting);

?>