<?php
namespace de\sideshowsystems\exception;

use \Exception;

/**
 * An exception class to indicate io errors.
 */
class IOException extends Exception {

	public function __construct($message = null, $code = null, $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}