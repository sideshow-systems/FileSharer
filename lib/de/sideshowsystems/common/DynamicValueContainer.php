<?php
namespace de\sideshowsystems\common;

class DynamicValueContainer {

	private $configStore;

	/**
	 * Magic method for dynamic getter and setter method calls.
	 *
	 * @param String $name
	 * @param Array $arguments
	 * @throws \InvalidArgumentException
	 * @throws \BadMethodCallException
	 */
	public function __call($name, $arguments) {
		if (preg_match('/^set([A-Z][a-zA-Z0-9]*)$/', $name, $target)) {
			if (count($arguments) != 1) {
				throw new \InvalidArgumentException("Method " . $name + " only takes one argument!");
			} else {
				$member = $this->buildMemberName($target[1]);
				$this->configStore[$member] = $arguments[0];
			}
		} elseif (preg_match('/^get([A-Z][a-zA-Z0-9]*)$/', $name, $target)) {
			if (count($arguments) > 0) {
				throw new \InvalidArgumentException("Method " . $name + " does not accept arguments!");
			} else {
				$member = $this->buildMemberName($target[1]);
				$result = null;
				if (isset($this->configStore[$member])) {
					$result = $this->configStore[$member];
				}
				return $result;
			}
		} else {
			throw new \BadMethodCallException("Method " . $name . " is invalid on class " . __CLASS__ . "!");
		}
	}

	private function buildMemberName($string) {
		// convert first char to lower case
		return lcfirst($string);
	}
}