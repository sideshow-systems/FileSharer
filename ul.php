<?php

$config = require_once('config.php');

$ds = DIRECTORY_SEPARATOR;  //1

$storeFolder = 'data';   //2

if (!empty($_FILES)) {
	$keys = array();

	$helper = new de\sideshowsystems\filesharer\FileSharerHelper($config);
	
	//error_log(print_r($_FILES, true));
	
	// Multiple files
	foreach ($_FILES as $array) {
		
		$archive = $helper->generateArchiveForMultipleFiles($array);
		
		
	}
	
	
	// Single file
//	foreach ($_FILES as $file) {
//		$tempFile = $file['tmp_name']; //3
//		$realName = $file['name'];
//		$mimeType = $file['type'];
//
//		$key = $helper->consumeUpload($tempFile, $realName, $mimeType);
//
//		$keys[$realName] = $key;
//		echo('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/?' . $key . "\n");
//	}

	//print_r($keys);//"http://fs.example.com/?1j1239198jkjkjlsid212";
}
