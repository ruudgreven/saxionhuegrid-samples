<?php
require_once("Light.php");
require_once("Grid.php");

/**
 * Class for communicating with the REST api
 * Author: Evert Duipmans
 * Date: 13-03-2017
 */
class Communicator {
	private $baseUrl;

	/**
	 * Create communicator with base url of the REST API
	 */
	function __construct($baseUrl) {
		$this->baseUrl = $baseUrl;
	}

	/**
	 * Change status of one specific light
	 */
	public function updateLight(Light $light) {
		$this->executeRequest("/light", "POST", $light->toArray());
	}

	/**
	 * Change status of the whole grid
	 */
	public function updateGrid(Grid $grid) {
		$this->executeRequest("/grid", "POST", $grid->toArray());
	}

	/**
	 * Executes the request using Curl
	 */
	private function executeRequest($path, $method = "POST", $data) {
		$data_string = json_encode($data);
		$ch = curl_init($this->baseUrl . $path);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Content-Length: ' . strlen($data_string))
		);
		$result = curl_exec($ch);
		return $result;
	}
}

?>