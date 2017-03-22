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

// Load light plans
require_once("lightplans/lightplan1.php");
require_once("lightplans/lightplan2.php");
require_once("lightplans/snake.php");

// Use rainbow colors
$colors = ColorMap::rainbow();

// Object for communicating with the REST API
$communicator = new Communicator("http://localhost:3000");

// Initialize default grid
$grid = new Grid();

// Turn off all lights
$grid->turnOff();

// Send signal to hue grid (API call)
$communicator->updateGrid($grid);

// Color lights per row
lightPlan1(false, $colors);

// Color whole grid
//lightPlan2(false, 2, 3, $colors);

//snake();

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