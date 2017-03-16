<?php
require_once("Color.php");

/**
 * Model for a single LED light in the saxion hue grid
 * Author: Evert Duipmans
 * Date: 13-03-2017
 */
class Light {
	/**
	 * Position in the grid
	 */
	private $x = 0;

	/**
	 * Position in the grid
	 */
	private $y = 0;

	/**
	 * Brightness of the light (0..255)
	 */
	private $bri = 255;

	/**
	 * State of the light
	 */
	private $on = true;

	/**
	 * Fade duration for the light
	 */
	private $duration = 0;

	/**
	 * Current RGB color (color object)
	 */
	private $color;

	/**
	 * Create a light object that corresponds to a light in the Saxion Hue Grid.
	 * By default full brightness, light on, no fade and color is black. Only x and y position are mandatory parameters
	 */
	function __construct($x, $y, $bri=255, $on=true, $duration=0, $color = null) {
		$this->x = $x;
		$this->y = $y;
		$this->bri = $bri;
		$this->on = $on;
		$this->duration = $duration;
		$this->color = $color;

		// Set default color (not allowed as default parameter)
		if ($color === null) {
			$this->color = new Color(0, 0, 0);
		}
	}

	/**
	 * Update some properties (by sending a associative array with settings)
	 */
	public function update($settingsMap) {
		foreach ($settingsMap as $key => $value) {
			if (property_exists('Light', $key)) {
				// Clone value in case of reference type
				$this->$key = (!is_scalar($value) ? clone $value : $value);
			}
		}
	}

	/**
	 * Exports the class to a php associative array
	 */
	public function toArray() {
		return array("x" => $this->x,
					"y" => $this->y,
					"bri" => $this->bri,
					"on" => $this->on,
					"duration" => $this->duration,
					"color" => $this->color->toArray());
	}

	/**
	 * Clones the light object
	 */
	public function __clone() {
		return new Light($this->x, $this->y, $this->bri, $this->on, $this->duration, clone $this->color);
	}

	public function getX(){
		return $this->x;
	}

	public function setX($x){
		$this->x = $x;
	}

	public function getY(){
		return $this->y;
	}

	public function setY($y){
		$this->y = $y;
	}

	public function getBri(){
		return $this->bri;
	}

	public function setBri($bri){
		$this->bri = $bri;
	}

	public function getOn(){
		return $this->on;
	}

	public function setOn($on){
		$this->on = $on;
	}

	public function getDuration(){
		return $this->duration;
	}

	public function setDuration($duration){
		$this->duration = $duration;
	}

	public function getColor(){
		return $this->color;
	}

	public function setColor($color){
		$this->color = $color;
	}
}
?>