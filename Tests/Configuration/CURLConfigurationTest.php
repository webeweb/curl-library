<?php

/**
 * This file is part of the curl-library package.
 *
 * (c) 2017 NdC/WBW
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Tests\Configuration;

use Exception;
use PHPUnit_Framework_TestCase;
use WBW\Library\Core\Exception\Argument\StringArgumentException;
use WBW\Library\CURL\Configuration\CURLConfiguration;

/**
 * cURL configuration test.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Configuration
 * @final
 */
final class CURLConfigurationTest extends PHPUnit_Framework_TestCase {

	/**
	 * Tests the __constructor() method.
	 *
	 * @return void
	 */
	public function testConstructor() {

		$obj = new CURLConfiguration();

		$this->assertEquals(false, $obj->getAllowEncoding());
		$this->assertEquals(0, $obj->getConnectTimeout());
		$this->assertEquals(false, $obj->getDebug());
		$this->assertEquals("php://output", $obj->getDebugFile());
		$this->assertEquals([], $obj->getHeaders());
		$this->assertEquals(null, $obj->getHost());
		$this->assertEquals(null, $obj->getHttpPassword());
		$this->assertEquals(null, $obj->getHttpUsername());
		$this->assertEquals(null, $obj->getProxyHost());
		$this->assertEquals(null, $obj->getProxyPassword());
		$this->assertEquals(null, $obj->getProxyPort());
		$this->assertEquals(null, $obj->getProxyType());
		$this->assertEquals(null, $obj->getProxyUsername());
		$this->assertEquals(0, $obj->getRequestTimeout());
		$this->assertEquals(true, $obj->getSslVerification());
		$this->assertEquals("cURLLibrary/1.0", $obj->getUserAgent());
		$this->assertEquals(false, $obj->getVerbose());
	}

	/**
	 * Tests the addHeader() method.
	 *
	 * @return void
	 */
	public function testAddHeader() {

		$obj = new CURLConfiguration();

		$obj->addHeader("name", "value");
		$res1 = ["name" => "value"];
		$this->assertEquals($res1, $obj->getHeaders());

		try {
			$obj->addHeader(1, "value");
		} catch (Exception $ex) {
			$this->assertInstanceOf(StringArgumentException::class, $ex);
			$this->assertEquals("The argument \"1\" is not a string", $ex->getMessage());
		}
	}

	/**
	 * Tests the clearHeader() method.
	 *
	 * @return void
	 */
	public function testClearHeaders() {

		$obj = new CURLConfiguration();

		$obj->addHeader("name", "value");
		$this->assertCount(1, $obj->getHeaders());

		$obj->clearHeaders();
		$this->assertCount(0, $obj->getHeaders());
	}

	/**
	 * Tests the removeHeader() method.
	 *
	 * @return void
	 */
	public function testRemoveHeader() {

		$obj = new CURLConfiguration();
		$obj->addHeader("name", "value");

		$obj->removeHeader("");
		$res1 = ["name" => "value"];
		$this->assertEquals($res1, $obj->getHeaders());

		$obj->removeHeader("name");
		$res2 = [];
		$this->assertEquals($res2, $obj->getHeaders());
	}

	/**
	 * Tests the setX() method.
	 *
	 * @return void
	 */
	public function testSetX() {

		$obj = new CURLConfiguration();


		$obj->setAllowEncoding(true);
		$this->assertEquals(true, $obj->getAllowEncoding());

		$obj->setConnectTimeout(1);
		$this->assertEquals(1, $obj->getConnectTimeout());

		$obj->setDebug(true);
		$this->assertEquals(true, $obj->getDebug());

		$obj->setDebugFile("./debugfile.log");
		$this->assertEquals("./debugfile.log", $obj->getDebugFile());

		$obj->setHost("host");
		$this->assertEquals("host", $obj->getHost());

		$obj->setHttpPassword("httpPassword");
		$this->assertEquals("httpPassword", $obj->getHttpPassword());

		$obj->setHttpUsername("httpUsername");
		$this->assertEquals("httpUsername", $obj->getHttpUsername());

		$obj->setProxyHost("proxyHost");
		$this->assertEquals("proxyHost", $obj->getProxyHost());

		$obj->setProxyPassword("proxyPassword");
		$this->assertEquals("proxyPassword", $obj->getProxyPassword());

		$obj->setProxyPort("proxyPort");
		$this->assertEquals("proxyPort", $obj->getProxyPort());

		$obj->setProxyType(1);
		$this->assertEquals(1, $obj->getProxyType());

		$obj->setProxyUsername("proxyUsername");
		$this->assertEquals("proxyUsername", $obj->getProxyUsername());

		$obj->setRequestTimeout(1);
		$this->assertEquals(1, $obj->getRequestTimeout());

		$obj->setSslVerification(false);
		$this->assertEquals(false, $obj->getSslVerification());

		$obj->setUserAgent("userAgent");
		$this->assertEquals("userAgent", $obj->getUserAgent());

		$obj->setVerbose(true);
		$this->assertEquals(true, $obj->getVerbose());
	}

}
