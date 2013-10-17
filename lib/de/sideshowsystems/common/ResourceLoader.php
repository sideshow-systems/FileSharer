<?php

namespace de\sideshowsystems\common;

use InvalidArgumentException;
use OutOfRangeException;

class ResourceLoader {

	private $resources = array();

	public function __construct() {

	}

	public function addResourcePackage($package) {
		$this->addResourcePackageToStack(null, $package);
	}

	public function addResourcePackageByKey($key, $package) {
		$this->addResourcePackageToStack($key, $package);
	}

	private function addResourcePackageToStack($key, $package) {
		if (!is_array($package)) {
			throw new InvalidArgumentException('Wrong argument type!');
		}

		if (empty($key)) {
			$this->resources[] = $package;
		} else {
			$this->resources[$key] = $package;
		}
	}

	public function getPackages() {
		return $this->resources;
	}

	public function getPackageByKey($key) {
		if (empty($this->resources[$key])) {
			throw new OutOfRangeException('No value found by this key');
		}

		return $this->resources[$key];
	}

}

?>
