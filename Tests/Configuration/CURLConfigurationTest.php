<?php

/*
 * This file is part of the WBWCURLLibrary package.
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
 * CURL configuration test.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Configuration
 * @final
 */
final class CURLConfigurationTest extends PHPUnit_Framework_TestCase {

    /**
     * Test the __constructor() method.
     *
     * @return void
     */
    public function testConstructor() {

        $obj = new CURLConfiguration();

        $this->assertEquals(false, $obj->getAllowEncoding(), "The method getAllowEncoding() does not return the expected value");
        $this->assertEquals(0, $obj->getConnectTimeout(), "The method getConnectTimeout() does not return the expected value");
        $this->assertEquals(false, $obj->getDebug(), "The method getDebug() does not return the expected value");
        $this->assertEquals("php://output", $obj->getDebugFile(), "The method getDebugFile() does not return the expected value");
        $this->assertEquals([], $obj->getHeaders(), "The method getHeaders() does not return the expected value");
        $this->assertEquals(null, $obj->getHost(), "The method getHost() does not return the expected value");
        $this->assertEquals(null, $obj->getHttpPassword(), "The method getHttpPassword() does not return the expected value");
        $this->assertEquals(null, $obj->getHttpUsername(), "The method getHttpUsername() does not return the expected value");
        $this->assertEquals(null, $obj->getProxyHost(), "The method getProxyHost() does not return the expected value");
        $this->assertEquals(null, $obj->getProxyPassword(), "The method getProxyPassword() does not return the expected value");
        $this->assertEquals(null, $obj->getProxyPort(), "The method getProxyPort() does not return the expected value");
        $this->assertEquals(null, $obj->getProxyType(), "The method getProxyType() does not return the expected value");
        $this->assertEquals(null, $obj->getProxyUsername(), "The method getProxyUsername() does not return the expected value");
        $this->assertEquals(0, $obj->getRequestTimeout(), "The method getRequestTimeout() does not return the expected value");
        $this->assertEquals(true, $obj->getSslVerification(), "The method getSslVerification() does not return the expected value");
        $this->assertEquals("cURLLibrary/1.0", $obj->getUserAgent(), "The method getUserAgent() does not return the expected value");
    }

    /**
     * Test the addHeader() method.
     *
     * @return void
     */
    public function testAddHeader() {

        $obj = new CURLConfiguration();

        $obj->addHeader("name", "value");
        $res1 = ["name" => "value"];
        $this->assertEquals($res1, $obj->getHeaders(), "The method getHeaders() does not return the expected headers with name");

        try {
            $obj->addHeader(1, "value");
        } catch (Exception $ex) {
            $this->assertInstanceOf(StringArgumentException::class, $ex, "The method addHeader() does not throws the expected exception");
            $this->assertEquals("The argument \"1\" is not a string", $ex->getMessage(), "The method addHeader() does not return the exepected exception message");
        }
    }

    /**
     * Test the clearHeader() method.
     *
     * @return void
     */
    public function testClearHeaders() {

        $obj = new CURLConfiguration();

        $obj->addHeader("name", "value");
        $this->assertCount(1, $obj->getHeaders(), "The method getHeaders() does not return the expected headers count");

        $obj->clearHeaders();
        $this->assertCount(0, $obj->getHeaders(), "The method getHeaders() does not return the expected headers count");
    }

    /**
     * Test the removeHeader() method.
     *
     * @return void
     */
    public function testRemoveHeader() {

        $obj = new CURLConfiguration();
        $obj->addHeader("name", "value");

        $obj->removeHeader("");
        $res1 = ["name" => "value"];
        $this->assertEquals($res1, $obj->getHeaders(), "The method getHeaders() does not return the expected headers");

        $obj->removeHeader("name");
        $res2 = [];
        $this->assertEquals($res2, $obj->getHeaders(), "The method getHeaders() does not return the expected headers with name");
    }

    /**
     * Test the set() method.
     *
     * @return void
     */
    public function testSet() {

        $obj = new CURLConfiguration();


        $obj->setAllowEncoding(true);
        $this->assertEquals(true, $obj->getAllowEncoding(), "The method getAllowEncoding() does not return the expected value");

        $obj->setConnectTimeout(1);
        $this->assertEquals(1, $obj->getConnectTimeout(), "The method getConnectTimeout() does not return the expected value");

        $obj->setDebug(true);
        $this->assertEquals(true, $obj->getDebug(), "The method getDebug() does not return the expected value");

        $obj->setDebugFile("./debugfile.log");
        $this->assertEquals("./debugfile.log", $obj->getDebugFile(), "The method getDebugFile() does not return the expected value");

        $obj->setHost("host");
        $this->assertEquals("host", $obj->getHost(), "The method getHost() does not return the expected value");

        $obj->setHttpPassword("httpPassword");
        $this->assertEquals("httpPassword", $obj->getHttpPassword(), "The method getHttpPassword() does not return the expected value");

        $obj->setHttpUsername("httpUsername");
        $this->assertEquals("httpUsername", $obj->getHttpUsername(), "The method getHttpUsername() does not return the expected value");

        $obj->setProxyHost("proxyHost");
        $this->assertEquals("proxyHost", $obj->getProxyHost(), "The method getProxyHost() does not return the expected value");

        $obj->setProxyPassword("proxyPassword");
        $this->assertEquals("proxyPassword", $obj->getProxyPassword(), "The method getProxyPassword() does not return the expected value");

        $obj->setProxyPort("proxyPort");
        $this->assertEquals("proxyPort", $obj->getProxyPort(), "The method getProxyPort() does not return the expected value");

        $obj->setProxyType(1);
        $this->assertEquals(1, $obj->getProxyType(), "The method getProxyType() does not return the expected value");

        $obj->setProxyUsername("proxyUsername");
        $this->assertEquals("proxyUsername", $obj->getProxyUsername(), "The method getProxyUsername() does not return the expected value");

        $obj->setRequestTimeout(1);
        $this->assertEquals(1, $obj->getRequestTimeout(), "The method getRequestTimeout() does not return the expected value");

        $obj->setSslVerification(false);
        $this->assertEquals(false, $obj->getSslVerification(), "The method getSslVerification() does not return the expected value");

        $obj->setUserAgent("userAgent");
        $this->assertEquals("userAgent", $obj->getUserAgent(), "The method getUserAgent() does not return the expected value");
    }

}
