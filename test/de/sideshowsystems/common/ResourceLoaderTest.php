<?php

namespace de\sideshowsystems\common;

use \PHPUnit_Framework_TestCase;

class ResourceLoaderTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var DynamicValueContainer
	 */
	private $dynamicValue;

	/**
	 * @var ResourceLoader
	 */
	private $resourceLoader;

	public function setUp() {
		$jsLibsRessourcePackage = array(
			'fileSystemPath' => dirname(__FILE__) . '/test',
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

		$this->dynamicValue = new DynamicValueContainer();
		$this->dynamicValue->setMemberJsLibs($jsLibsRessourcePackage);

		$this->resourceLoader = new ResourceLoader();
	}

	public function testGetResourcePackages() {
		$dv = $this->dynamicValue->getMemberJsLibs();
		$this->resourceLoader->addResourcePackage($dv);

		$this->assertEquals(array($dv), $this->resourceLoader->getPackages());
	}

	public function testGetResourcePackageByKey() {
		$dv = $this->dynamicValue->getMemberJsLibs();
		$key = 'jsLibs';
		$this->resourceLoader->addResourcePackageByKey($key, $dv);

		$this->assertEquals($dv, $this->resourceLoader->getPackageByKey($key));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testAddResourcePackageThrowsException() {
		$this->resourceLoader->addResourcePackage(false);
	}

}

?>
