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
			'fileSystemPath' => dirname(__FILE__) . '/_tmp',
			'libs' => array(
				array(
					'lib' => 'jquery-1.10.2.min.js',
					'downloadUrl' => 'http://code.jquery.com/jquery-1.10.2.min.js'
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

	public function testLoadResources() {
		$dv = $this->dynamicValue->getMemberJsLibs();
		$this->resourceLoader->addResourcePackage($dv);
		$this->resourceLoader->loadAllResources();

		$fileExists = file_exists($dv['fileSystemPath'] . '/' . $dv['libs'][0]['lib']);
		$this->assertTrue($fileExists);

		if (file_exists($dv['fileSystemPath'])) {
			exec('rm -rf ' . $dv['fileSystemPath']);
		}
	}

}

?>
