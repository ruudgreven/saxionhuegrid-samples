<?php
/**
 * RGB color data class
 */
class Color {
	private $r = 0;
	private $g = 0;
	private $b = 0;

	function __construct($r=0, $g=0, $b=0) {
		$this->r = $r;
		$this->g = $g;
		$this->b = $b;
	}

	public function getRed(){
		return $this->r;
	}

	public function setRed($r){
		$this->r = $r;
	}

	public function getGreen(){
		return $this->g;
	}

	public function setGreen($g){
		$this->g = $g;
	}

	public function getBlue(){
		return $this->b;
	}

	public function setBlue($b){
		$this->b = $b;
	}

	/**
	 * Exports the class to a php associative array
	 */
	public function toArray() {
		return array("r" => $this->r,
					"g" => $this->g,
					"b" => $this->b);
	}

	public function __clone() {
		return new Color($this->r, $this->g, $this->b);
	}
}
?>