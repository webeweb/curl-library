<?php

/*
 * This file is part of the WBWCURLLibrary package.
 *
 * (c) 2017 NdC/WBW
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Response;

use PHPUnit_Framework_TestCase;

/**
 * CURLResponseTest
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Response
 * @final
 */
final class CURLResponseTest extends PHPUnit_Framework_TestCase {

    /**
     * Test the __constructor() method.
     *
     * @return void
     */
    public function testConstructor() {

        $obj = new CURLResponse();

        $this->assertEquals(null, $obj->getRequestBody(), "The method getRequestBody() does not return the expected value");
        $this->assertEquals([], $obj->getRequestHeader(), "The method getRequestHeader() does not return the expected value");
        $this->assertEquals(null, $obj->getRequestURL(), "The method getRequestURL() does not return the expected value");
        $this->assertEquals(null, $obj->getResponseBody(), "The method getResponseBody() does not return the expected value");
        $this->assertEquals([], $obj->getResponseHeader(), "The method getResponseHeader() does not return the expected value");
        $this->assertEquals([], $obj->getResponseInfo(), "The method getResponseInfo() does not return the expected value");
    }

    /**
     * Test the setX() method.
     *
     * @return void
     */
    public function testSetX() {

        $obj = new CURLResponse();

        $obj->setRequestBody("requestBody");
        $this->assertEquals("requestBody", $obj->getRequestBody(), "The method getRequestBody() does not return the expected value");

        $obj->setRequestHeader(["requestHeader" => "requestHeader"]);
        $this->assertEquals(["requestHeader" => "requestHeader"], $obj->getRequestHeader(), "The method getRequestHeader() does not return the expected value");

        $obj->setRequestURL("requestURL");
        $this->assertEquals("requestURL", $obj->getRequestURL(), "The method getRequestURL() does not return the expected value");

        $obj->setResponseBody("responseBody");
        $this->assertEquals("responseBody", $obj->getResponseBody(), "The method getResponseBody() does not return the expected value");

        $obj->setResponseHeader(["responseHeader" => "responseHeader"]);
        $this->assertEquals(["responseHeader" => "responseHeader"], $obj->getResponseHeader(), "The method getResponseHeader() does not return the expected value");

        $obj->setResponseInfo(["responseInfo" => "responseInfo"]);
        $this->assertEquals(["responseInfo" => "responseInfo"], $obj->getResponseInfo(), "The method getResponseInfo() does not return the expected value");
    }

}
