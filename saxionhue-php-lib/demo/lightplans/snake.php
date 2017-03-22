<?php
/**
 * Demo light plan 2: Change the whole grid
 */
function snake() {
	// Make global variables available in the function
	global $communicator, $grid;

	// Determine grid size
	$gridLength = $grid->getHeight() - 1;

	// Color of the snake
	$color = new Color(255, 0, 0);

	$rowId = 1;
 	while (true) {
		$grid->changeOne(0, $rowId - 1, array("duration" => 1, "color" => $color));
		$grid->changeOne(0, $rowId, array("duration" => 1, "color" => $color));

		// Send request
		$communicator->updateGrid($grid);

		// Sleep for 10 seconds
		sleep(3);
		$rowId++;
	}
}
?>