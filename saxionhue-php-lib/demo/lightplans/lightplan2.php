<?php
/**
 * Demo light plan 2: Change the whole grid
 */
function lightPlan2($ignoreLastRow=true, $fadeduration=5, $timeout=6, $colorMap) {
	// Make global variables available in the function
	global $communicator, $grid;

	// Determine grid size
	$gridLength = $grid->getHeight() - (($ignoreLastRow) ? 1 : 0);

	$currentColorIndex = 0;

	while (true) {
		$grid->changeAll(array("duration" => $fadeduration, "color" => $colorMap[$currentColorIndex]));

		// Send request
		$communicator->updateGrid($grid);

		// Sleep for 10 seconds
		sleep($timeout);	

		// Goto next color
		$currentColorIndex = ($currentColorIndex + 1) % count($colorMap);
	}
}
?>