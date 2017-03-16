<?php
/**
 * Create/use a colormap
 */
class ColorMap {
	public static function rainbow() {
		$rainbow = array();
		$rainbow[] = new Color(255, 0, 0);
		$rainbow[] = new Color(255, 127, 0);
		$rainbow[] = new Color(255, 255, 0);
		$rainbow[] = new Color(0, 255, 0);
		$rainbow[] = new Color(0, 0, 255);
		$rainbow[] = new Color(75, 0, 130);
		$rainbow[] = new Color(143, 0, 255);
		return $rainbow;
	}
}
?>