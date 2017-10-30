<?php

/*
 * This file is part of the WBWCURLLibrary package.
 *
 * (c) 2017 NdC/WBW
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Tests\Request;

use WBW\Library\CURL\Request\CURLOptionsRequest;

/**
 * CURL Options request test.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Request
 * @final
 */
final class CURLOptionsRequestTest extends AbstractCURLRequestTest {

	/**
	 * Tests __construct() method.
	 *
	 * @return void
	 */
	public function testConstructor() {

		$obj = new CURLOptionsRequest($this->configuration, self::RESOURCE_PATH);

		$this->assertEquals($this->configuration, $obj->getConfiguration(), "The method getConfiguration() does not return the expected value");
		$this->assertEquals([], $obj->getHeaders(), "The method getHeaders() does not return the expecetd value");
		$this->assertEquals(CURLOptionsRequest::METHOD_OPTIONS, $obj->getMethod(), "The method getMethod() does not return the expecetd value");
		$this->assertEquals([], $obj->getPostData(), "The method getPostData() does not return the expecetd value");
		$this->assertEquals([], $obj->getQueryData(), "The method getQueryData() does not return the expecetd value");
		$this->assertEquals(self::RESOURCE_PATH, $obj->getResourcePath(), "The method getResourcePath() does not return the expecetd value");
	}

	/**
	 * Tests call() method.
	 *
	 * @return void
	 */
	public function testCall() {

		$obj = new CURLOptionsRequest($this->configuration, self::RESOURCE_PATH);

		$obj->addHeader("header", "header");
		$obj->addQueryData("queryData", "queryData");

		$res = $obj->call();

		$this->assertContains("header: header", $res->getRequestHeader(), "The method getRequestHeader() does not return the expecetd value");
		$this->assertContains("queryData=queryData", $res->getRequestURL(), "The method getRequestURL() does not return the expected value");
		$this->assertEquals(CURLOptionsRequest::METHOD_OPTIONS, json_decode($res->getResponseBody(), true)["method"]);
		$this->assertEquals(200, $res->getResponseInfo()["http_code"], "The method getResponseInfo() does not return the expected value");
	}

}
