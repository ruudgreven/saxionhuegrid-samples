<?php
/**
 * Basic implementation of a light plan with simple PHP class library
 * Author: Evert Duipmans
 * Date: 13-03-2017
 */

/*******************************************************************
 * TODO: TEST CODE!!! HAS NOT BEEN EXECUTED ON THE REAL SETUP YET!!!
 *******************************************************************/

require_once("classes/Communicator.php");
require_once("classes/Grid.php");
require_once("classes/Light.php");

/**
 * Rainbow colors
 */
$rainbow = array();
$rainbow[] = new Color(255, 0, 0);
$rainbow[] = new Color(255, 127, 0);
$rainbow[] = new Color(255, 255, 0);
$rainbow[] = new Color(0, 255, 0);
$rainbow[] = new Color(0, 0, 255);
$rainbow[] = new Color(75, 0, 130);
$rainbow[] = new Color(143, 0, 255);

/**
 * Initialize components
 */
// Object for communicating with the REST API
$communicator = new Communicator("http://localhost:3000");

// Initialize default grid
$grid = new Grid();

// Turn off all lights
$grid->turnOff();

// Execute light plan
lightPlan1();


/**
 * Demo light plan 1: Change the lights rows by row. When the last row is reached, start over with the next color
 */
function lightPlan1() {
	// Make global variables available in the function
	global $communicator, $grid, $rainbow;

	// Forward = 0, backward = 1
	$direction = 0;

	$currentRow = 0;
	$currentColorIndex = 0;

	while (true) {

		// Update each row, until the whole grid is filled
		for ($i=0; $i<5; $i++) {
			// Determine the current row (based on direction)
			$currentRow = (($direction == 0) ? $i : 5-$i);

			// Update row
			$grid->changeRow($currentRow, array("duration" => 3, "color" => $rainbow[$currentColorIndex]));

			// Send request
			$communicator->updateGrid($grid);

			// Sleep for 5 seconds
			sleep(5);	
		}

		// Goto next color
		$currentColorIndex = ($currentColorIndex + 1) % count($rainbow);

		// Change direction
		$direction = ($direction + 1) % 2;
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