<?php
$config = require_once ('config.php');
// $test = new \Zend\Log\Writer\ZendMonitor();

// fetch "anonymous" key parameter
$inputKeys = array_keys($_REQUEST);
if (! empty($inputKeys)) {
	$key = $inputKeys[0];
	
	if (! empty($key)) {
		
		$helper = new de\sideshowsystems\filesharer\FileSharerHelper($config);
		
		$helper->deliverContent($key);
	}
}
