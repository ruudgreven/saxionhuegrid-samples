<?php
/**
 * Represents the whole light grid at Saxion
 * Author: Evert Duipmans
 * Date: 13-03-2017
 */
class Grid {
	private $lights = array();

	// TODO: Fix this contructor. Currently only working with the grid at Saxion (not flexible)
	function __construct() {
		$defaultLightSetting = new Light(0, 0);
		$defaultLightSetting->setOn(false);

		for ($y = 0; $y < 5; $y++) {
			$newRow = array();
			for ($x = 0; $x < 3; $x++) {
				$newLight = clone $defaultLightSetting;
				$newLight->setX($x);
				$newLight->setY($y);

				$newRow[] = $newLight;
			}
			$this->lights[] = $newRow;
		}

		// Last row only has one light
		$this->lights[] = array(clone $defaultLightSetting);
	}

	/**
	 * Change light settings for a column
	 */
	public function changeOne($x, $y, $settingsMap) {
		$light = $this->lights[$y][$x];
		$light->update($settingsMap);
	}

	/**
	 * Change light settings for a row
	 */
	public function changeRow($row, $settingsMap) {
		for ($x=0; $x<count($this->lights[$row]); $x++) {
			$this->changeOne($x, $row, $settingsMap);
		}
	}

	/**
	 * Change light settings for a column
	 */
	public function changeColumn($column, $settingsMap) {
		for ($y=0; $y<count($this->lights[1]); $y++) {
			$this->changeOne($column, $y, $settingsMap);
		}
	}

	/**
	 * Change light settings in the grid.
	 * The first array is a boolean array which indicates which lights should be changed.
	 * The second associative array contains the properties that should be applied to the lights
	 */
	public function changePattern($gridBitArray, $settingsMap) {
		for ($y=0; $y<count($gridBitArray); $y++) {
			for ($x=0; $x<count($gridBitArray[$y]); $x++) {
				if ($gridBitArray[$y][$x]) {
					$light = $this->lights[$y][$x];
					$light->update($settingsMap);
				}
			}
		}
	}

	/**
	 * Turn off all lights
	 */
	public function turnOff() {
		for ($y=0; $y<count($this->lights); $y++) {
			for ($x=0; $x<count($this->lights[$y]); $x++) {
				$this->lights[$y][$x]->setOn(false);
			}
		}
	}

	/**
	 * Turn on all lights
	 */
	public function turnOn() {
		for ($y=0; $y<count($this->lights); $y++) {
			for ($x=0; $x<count($this->lights[$y]); $x++) {
				$this->lights[$y][$x]->setOn(true);
			}
		}
	}

	/**
	 * Exports the class to a php associative array
	 */
	public function toArray() {
		$rows = array();
		for ($y=0; $y<count($this->lights); $y++) {
			$column = array();
			for ($x=0; $x<count($this->lights[$y]); $x++) {
				$column[] = $this->lights[$y][$x]->toArray();
			}
			$rows[] = $column;
		}

		return array("grid" => $rows);
	}

	/**
	 * Returns a boolean array with the structure of the current grid.
	 * This method can be used with the change function (for indicating which lights you want to change)
	 */
	public function getGridBitArray($default = false) {
		$rows = array();
		for ($y=0; $y<count($this->lights); $y++) {
			$column = array();
			for ($x=0; $x<count($this->lights[$y]); $x++) {
				$column[] = $default;
			}
			$rows[] = $column;
		}
		return $rows;
	}
}
?>