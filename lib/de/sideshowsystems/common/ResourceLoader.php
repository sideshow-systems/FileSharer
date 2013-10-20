<?php

namespace de\sideshowsystems\common;

use InvalidArgumentException;
use OutOfRangeException;

/**
 * Resource loader class
 */
class ResourceLoader {

	private $resources = array();

	public function __construct() {

	}

	/**
	 * Add a resource package array.
	 *
	 * @param array $package
	 * @return void
	 */
	public function addResourcePackage($package) {
		$this->addResourcePackageToStack(null, $package);
	}

	/**
	 * Add a resource package array by key.
	 *
	 * @param string $key
	 * @param array $package
	 * @return void
	 */
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

	/**
	 * Get all packages.
	 *
	 * @return array
	 */
	public function getPackages() {
		return $this->resources;
	}

	/**
	 * Get package by key.
	 *
	 * @param string $key
	 * @return array
	 * @throws OutOfRangeException
	 */
	public function getPackageByKey($key) {
		if (empty($this->resources[$key])) {
			throw new OutOfRangeException('No value found by this key');
		}

		return $this->resources[$key];
	}

	public function loadAllResources() {
		foreach ($this->resources as $package) {
			$path = $package['fileSystemPath'];
			$this->checkAndCreateFileSystemPath($path);

			foreach ($package['libs'] as $downloadData) {
				$this->downloadAndSaveResource($downloadData['downloadUrl'], $downloadData['lib'], $path);
			}
		}
	}

	private function checkAndCreateFileSystemPath($path) {
		if (!file_exists($path)) {
			return mkdir($path, 0777, true);
		}
		return true;
	}

	private function downloadAndSaveResource($source, $name, $path) {
		$destinationFile = $path . '/' . $name;
		if (!file_exists($destinationFile)) {
			file_put_contents($destinationFile, file_get_contents($source));
		}
	}

}
?>
