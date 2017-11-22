<?php

/**
 * This file is part of the curl-library package.
 *
 * (c) 2017 NdC/WBW
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Response;

use PHPUnit_Framework_TestCase;

/**
 * CURL response test.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Response
 * @final
 */
final class CURLResponseTest extends PHPUnit_Framework_TestCase {

	/**
	 * Tests the __constructor() method.
	 *
	 * @return void
	 */
	public function testConstructor() {

		$obj = new CURLResponse();

		$this->assertEquals(null, $obj->getRequestBody());
		$this->assertEquals([], $obj->getRequestHeader());
		$this->assertEquals(null, $obj->getRequestURL());
		$this->assertEquals(null, $obj->getResponseBody());
		$this->assertEquals([], $obj->getResponseHeader());
		$this->assertEquals([], $obj->getResponseInfo());
	}

	/**
	 * Tests the setX() method.
	 *
	 * @return void
	 */
	public function testSetX() {

		$obj = new CURLResponse();

		$obj->setRequestBody("requestBody");
		$this->assertEquals("requestBody", $obj->getRequestBody());

		$obj->setRequestHeader(["requestHeader" => "requestHeader"]);
		$this->assertEquals(["requestHeader" => "requestHeader"], $obj->getRequestHeader());

		$obj->setRequestURL("requestURL");
		$this->assertEquals("requestURL", $obj->getRequestURL());

		$obj->setResponseBody("responseBody");
		$this->assertEquals("responseBody", $obj->getResponseBody());

		$obj->setResponseHeader(["responseHeader" => "responseHeader"]);
		$this->assertEquals(["responseHeader" => "responseHeader"], $obj->getResponseHeader());

		$obj->setResponseInfo(["responseInfo" => "responseInfo"]);
		$this->assertEquals(["responseInfo" => "responseInfo"], $obj->getResponseInfo());
	}

}
