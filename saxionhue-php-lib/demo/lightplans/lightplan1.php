<?php
/**
 * Demo light plan 1: Change the lights rows by row. When the last row is reached, start over with the next color in opposite direction
 */
function lightPlan1($ignoreLastRow=true, $colors, $fadeduration=5, $timeout=6) {
	// Make global variables available in the function
	global $communicator, $grid;

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
			$grid->changeRow($currentRow, array("duration" => $fadeduration, "color" => $colors[$currentColorIndex]));

			// Send request
			$communicator->updateGrid($grid);

			// Sleep
			sleep($timeout);	
		}

		// Goto next color
		$currentColorIndex = ($currentColorIndex + 1) % count($colors);

		// Change direction
		$moveForward = !$moveForward;
	}
}
?>