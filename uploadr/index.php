<?php

namespace de\sideshowsystems\common;

require '../vendor/autoload.php';

$config = require_once '../config.php';

// TODO: put this to config
$jsLibsRessourcePackage = array(
	'fileSystemPath' => str_replace('/uploadr', '', dirname(__FILE__)) . '/misc/js/vendor/',
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
);

$resourceLoader = new ResourceLoader();
$resourceLoader->addResourcePackage($jsLibsRessourcePackage);
$resourceLoader->loadAllResources();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>FileSharer v<?php echo $config['version']; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="shortcut icon" href="../misc/pics/favicon.ico" />
		<link rel="apple-touch-icon" href="../misc/pics/icon.png" />

		<link rel="stylesheet" href="../misc/css/dropzone.css">
		<link rel="stylesheet/less" type="text/css" href="../misc/less/master.less" />
		<script src="../misc/js/vendor/less-1.4.1.min.js"></script>
		<script src="../misc/js/vendor/jquery-1.10.2.min.js"></script>
		<script src="../misc/js/vendor/dropzone.js"></script>
		<script src="../misc/js/master.js"></script>
	</head>
	<body>
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

		<div id="main_container">
			<div id="upload_wrapper">
				<h1>FileSharer</h1>
				<form id="dropzone-form" action="<?php echo str_replace('uploadr/index.php', 'ul.php', $_SERVER['PHP_SELF']); ?>" class="dropzone">
					<div class="fallback">
						<input name="file" type="file" multiple />
					</div>
				</form>
			</div>

			<div id="url_viewbox" class="notify" style="display: none;">
				<h3 class="url_val"></h3>
				<div class="info">
					Please copy the URL to your clipboard and use it (or mail it... ???)
				</div>
			</div>
		</div>

	</body>
</html>
