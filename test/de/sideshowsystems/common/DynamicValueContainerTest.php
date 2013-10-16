<?php
namespace de\sideshowsystems\common;

use \PHPUnit_Framework_TestCase;

class DynamicValueContainerTest extends PHPUnit_Framework_TestCase {

	public function testEmptyResult1() {
		$obj = new DynamicValueContainer();
		$res = $obj->getMember1();
		$this->assertNull($res);
	}

	public function testValue1Null() {
		$obj = new DynamicValueContainer();
		$obj->setMember1(null);
		$res = $obj->getMember1();
		$this->assertNull($res);
	}

	public function testValue1() {
		$obj = new DynamicValueContainer();
		$obj->setMember1(1);
		$res = $obj->getMember1();
		$this->assertEquals(1, $res);
	}

	public function testValue1Array() {
		$testArray = array(
			1,
			2,
			3
		);
		$obj = new DynamicValueContainer();
		$obj->setMember1($testArray);
		$res = $obj->getMember1();
		$this->assertEquals($testArray, $res);
	}

	public function testValue1SameObject() {
		$obj = new DynamicValueContainer();
		// set the object member to itself :)
		$obj->setMember1($obj);
		$res = $obj->getMember1();
		$this->assertSame($obj, $res);
	}

	public function testValue1NotSameObject() {
		$obj = new DynamicValueContainer();
		$obj2 = new DynamicValueContainer();
		// set the object member to itself :)
		$obj->setMember1($obj);
		// and again for the second object
		$obj2->setMember1($obj);
		$res = $obj->getMember1();
		
		// value are equal ..,
		$this->assertEquals($obj2, $res);
		
		// ... but not the same object!
		$this->assertNotSame($obj2, $res);
	}
}