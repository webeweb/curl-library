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
use WBW\Library\CURL\Configuration\CURLConfiguration;
use WBW\Library\CURL\Exception\CURLInvalidArgumentException;

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
            $this->assertInstanceOf(CURLInvalidArgumentException::class, $ex, "The method addHeader() does not throws the expected exception");
            $this->assertEquals("The header name must be a string", $ex->getMessage(), "The method addHeader() does not return the exepected exception message");
        }
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

}
