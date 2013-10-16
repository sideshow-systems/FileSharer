<?php
$config = require_once '../config.php';

// TODO: put this in own class and add unit tests!
$jsLibs = array(
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
);
foreach ($jsLibs as $libData) {
	$libFile = str_replace('/uploadr', '', dirname(__FILE__)) . '/misc/js/vendor/' . $libData['lib'];
	if (!file_exists($libFile)) {
		file_put_contents($libFile, file_get_contents($libData['downloadUrl']));
	}
}
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
				<form id="dropzone-form" action="/file-upload" class="dropzone">
					<div class="fallback">
						<input name="file" type="file" multiple />
					</div>
				</form>
			</div>
		</div>

	</body>
</html>
