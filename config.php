<?php

// Load autoload.php from composer directory
include_once ('vendor/autoload.php');

$config = new de\sideshowsystems\filesharer\FileSharerConfig();
$config->setDataDir('data');
$config->setVersion('0.1 beta');

// TODO: put this to config
$config->setJsLibResources(
	array(
		'fileSystemPath' => dirname(__FILE__) . '/misc/js/vendor/',
		'libs' => array(
			array(
				'lib' => 'jquery-1.10.2.min.js',
				'downloadUrl' => 'http://code.jquery.com/jquery-1.10.2.min.js'
			),
			array(
				'lib' => 'less-1.4.1.min.js',
				'downloadUrl' => 'https://raw.github.com/less/less.js/master/dist/less-1.4.1.min.js'
			),
			array(
				'lib' => 'dropzone.js',
				'downloadUrl' => 'https://raw.github.com/enyo/dropzone/master/downloads/dropzone.js'
			)
		)
	)
);

return $config;
