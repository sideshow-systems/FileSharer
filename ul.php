<?php

$config = require_once('config.php');

$ds = DIRECTORY_SEPARATOR;  //1

$storeFolder = 'data';   //2

if (!empty($_FILES)) {
	$keys = array();
	
	$helper = new de\sideshowsystems\filesharer\FileSharerHelper($config);
	
	foreach($_FILES as $file) {
		$tempFile = $file['tmp_name']; //3
		$realName = $file['name'];
		$mimeType = $file['type'];

		$key = $helper->consumeUpload($tempFile, $realName, $mimeType);
		
		$keys[$realName] = $key;
		echo(dirname($_SERVER['PHP_SELF']) . '/?' . $key . "\n");
	}

	//print_r($keys);//"http://fs.example.com/?1j1239198jkjkjlsid212";
}
