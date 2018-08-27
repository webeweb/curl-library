<?php

/**
 * This file is part of the curl-library package.
 *
 * (c) 2017 WEBEWEB
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Response;

use PHPUnit_Framework_TestCase;

/**
 * cURL response test.
 *
 * @author webeweb <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Response
 * @final
 */
final class CURLResponseTest extends PHPUnit_Framework_TestCase {

    /**
     * Tests the __constructor() method.
     *
     * @return void
     */
    public function testConstruct() {

        $obj = new CURLResponse();

        $this->assertNull($obj->getRequestBody());
        $this->assertEquals([], $obj->getRequestHeader());
        $this->assertNull($obj->getRequestURL());
        $this->assertNull($obj->getResponseBody());
        $this->assertEquals([], $obj->getResponseHeader());
        $this->assertEquals([], $obj->getResponseInfo());
    }

    /**
     * Tests the setRequestBody() method.
     *
     * @return void
     */
    public function testSetRequestBody() {

        $obj = new CURLResponse();

        $obj->setRequestBody("requestBody");
        $this->assertEquals("requestBody", $obj->getRequestBody());
    }

    /**
     * Tests the setRequestHeader() method.
     *
     * @return void
     */
    public function testSetRequestHeader() {

        $obj = new CURLResponse();

        $obj->setRequestHeader(["requestHeader" => "requestHeader"]);
        $this->assertEquals(["requestHeader" => "requestHeader"], $obj->getRequestHeader());
    }

    /**
     * Tests the setRequestURL() method.
     *
     * @return void
     */
    public function testSetRequestURL() {

        $obj = new CURLResponse();

        $obj->setRequestURL("requestURL");
        $this->assertEquals("requestURL", $obj->getRequestURL());
    }

    /**
     * Tests the setResponseBody() method.
     *
     * @return void
     */
    public function testSetResponseBody() {

        $obj = new CURLResponse();

        $obj->setResponseBody("responseBody");
        $this->assertEquals("responseBody", $obj->getResponseBody());
    }

    /**
     * Tests the setResponseHeader() method.
     *
     * @return void
     */
    public function testSetResponseHeader() {

        $obj = new CURLResponse();

        $obj->setResponseHeader(["responseHeader" => "responseHeader"]);
        $this->assertEquals(["responseHeader" => "responseHeader"], $obj->getResponseHeader());
    }

    /**
     * Tests the setResponseInfo() method.
     *
     * @return void
     */
    public function testSetResponseInfo() {

        $obj = new CURLResponse();

        $obj->setResponseInfo(["responseInfo" => "responseInfo"]);
        $this->assertEquals(["responseInfo" => "responseInfo"], $obj->getResponseInfo());
    }

}
