<?php

$config = require_once('config.php');

if (!empty($_FILES)) {
	$keys = array();

	$helper = new de\sideshowsystems\filesharer\FileSharerHelper($config);
	
	error_log(print_r($_FILES, true));
	
	$multiple = false;
	
	if (!empty($_FILES) && !empty($_FILES['file']) && !empty($_FILES['file']['name']) && count($_FILES['file']['name']) > 1) {
		$multiple = true;
	}

	error_log(print_r($multiple, true));
	
	// Single file
	if (!$multiple) {
		error_log('SINGLE');
		foreach ($_FILES as $file) {
			error_log(print_r($file, true));
			$tempFile = $file['tmp_name'][0]; //3
			$realName = $file['name'][0];
			$mimeType = $file['type'][0];

			$key = $helper->consumeUpload($tempFile, $realName, $mimeType);

			$keys[$realName] = $key;
			echo('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/?' . $key . "\n");
		}
	}
	
	// Multiple files
	if ($multiple) {
		foreach ($_FILES as $array) {
			$archive = $helper->generateArchiveForMultipleFiles($array);
			$realName = 'archive.zip';
			$mimeType = mime_content_type($archive);

			$key = $helper->consumeUpload($archive, $realName, $mimeType, null, false);

			$keys[$realName] = $key;
			echo('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/?' . $key . "\n");

			exec("rm -rf " . str_replace("/" . $realName, "", $archive));
		}
	}
}
