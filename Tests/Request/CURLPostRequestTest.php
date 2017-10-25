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

use Exception;
use WBW\Library\Core\Exception\Argument\StringArgumentException;
use WBW\Library\CURL\Request\CURLPostRequest;

/**
 * CURL POST request test.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Request
 * @final
 */
final class CURLPostRequestTest extends AbstractCURLRequestTest {

    /**
     * Tests __construct() method.
     *
     * @return void
     */
    public function testConstructor() {

        $obj = new CURLPostRequest($this->configuration, self::RESOURCE_PATH);

        $this->assertEquals($this->configuration, $obj->getConfiguration(), "The method getConfiguration() does not return the expected value");
        $this->assertEquals([], $obj->getHeaders(), "The method getHeaders() does not return the expecetd value");
        $this->assertEquals(CURLPostRequest::METHOD_POST, $obj->getMethod(), "The method getMethod() does not return the expecetd value");
        $this->assertEquals([], $obj->getPostData(), "The method getPostData() does not return the expecetd value");
        $this->assertEquals([], $obj->getQueryData(), "The method getQueryData() does not return the expecetd value");
        $this->assertEquals(self::RESOURCE_PATH, $obj->getResourcePath(), "The method getResourcePath() does not return the expecetd value");
    }

    /**
     * Tests addPostData() method.
     *
     * @return void
     */
    public function testAddPostData() {

        $obj = new CURLPostRequest($this->configuration, self::RESOURCE_PATH);

        try {
            $obj->addPostData(1, "value");
        } catch (Exception $ex) {
            $this->assertInstanceOf(StringArgumentException::class, $ex, "The method addPostData() dos not throw the expected exception");
            $this->assertEquals("The argument \"1\" is not a string", $ex->getMessage(), "The getMessage() does not return the expecetd string");
        }

        $obj->addPostData("name", "value");

        $res = ["name" => "value"];
        $this->assertEquals($res, $obj->getPostData(), "The method getPostData() does not return the expected value");
    }

    /**
     * Tests call() method.
     *
     * @return void
     */
    public function testCall() {

        $obj = new CURLPostRequest($this->configuration, self::RESOURCE_PATH);

        $obj->addHeader("header", "header");
        $obj->addQueryData("queryData", "queryData");

        $res = $obj->call();

        $this->assertContains("header: header", $res->getRequestHeader(), "The method getRequestHeader() does not return the expecetd value");
        $this->assertContains("queryData=queryData", $res->getRequestURL(), "The method getRequestURL() does not return the expected value");
        $this->assertEquals(CURLPostRequest::METHOD_POST, json_decode($res->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res->getResponseInfo()["http_code"], "The method getResponseInfo() does not return the expected value");
    }

    /**
     * Tests the clearPostData() method.
     *
     * @return void
     */
    public function testClearPostData() {

        $obj = new CURLPostRequest($this->configuration, self::RESOURCE_PATH);

        $obj->addPostData("name", "value");
        $this->assertCount(1, $obj->getPostData(), "The method getPostData() does not return the expected post data count");

        $obj->clearPostData();
        $this->assertCount(0, $obj->getPostData(), "The method getPostData() does not return the expected post data count");
    }

    /**
     * Tests removePostData() method.
     *
     * @return void
     */
    public function testRemovePostData() {

        $obj = new CURLPostRequest($this->configuration, self::RESOURCE_PATH);

        $obj->addPostData("name", "value");
        $this->assertCount(1, $obj->getPostData(), "The method getPostData() does not return the expected value");

        $obj->removePostData("Name");
        $this->assertCount(1, $obj->getPostData(), "The method removePostData() does not remove the expected value");

        $obj->removePostData("name");
        $this->assertCount(0, $obj->getPostData(), "The method removePostData() does not return the expected value");
    }

}
