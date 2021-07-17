<?php

/*
 * This file is part of the curl-library package.
 *
 * (c) 2017 WEBEWEB
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\Curl\Tests\Request;

use Exception;
use WBW\Library\Curl\Request\CurlPostRequest;
use WBW\Library\Curl\Tests\AbstractTestCase;

/**
 * cURL "POST" request test.
 *
 * @author webeweb <https://github.com/webeweb/>
 * @package WBW\Library\Curl\Tests\Request
 */
class CurlPostRequestTest extends AbstractTestCase {

    /**
     * Tests addPostData() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testAddPostData(): void {

        $obj = new CurlPostRequest($this->curlConfiguration, $this->curlResourcePath);

        $obj->addPostData("name", "value");
        $res = ["name" => "value"];
        $this->assertEquals($res, $obj->getPostData());
    }

    /**
     * Tests call() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testCall(): void {

        $obj = new CurlPostRequest($this->curlConfiguration, $this->curlResourcePath);
        $obj->addHeader("header", "header");
        $obj->addQueryData("queryData", "queryData");

        $res = $obj->call();
        $this->assertEquals("header: header", $res->getRequestHeader()[0]);
        $this->assertStringContainsString("queryData=queryData", $res->getRequestUrl());
        $this->assertEquals(CurlPostRequest::CURL_REQUEST_POST, json_decode($res->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res->getResponseInfo()["http_code"]);
    }

    /**
     * Tests the clearPostData() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testClearPostData(): void {

        $obj = new CurlPostRequest($this->curlConfiguration, $this->curlResourcePath);

        $obj->addPostData("name", "value");
        $this->assertCount(1, $obj->getPostData());

        $obj->clearPostData();
        $this->assertCount(0, $obj->getPostData());
    }

    /**
     * Tests removePostData() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testRemovePostData(): void {

        $obj = new CurlPostRequest($this->curlConfiguration, $this->curlResourcePath);

        $obj->addPostData("name", "value");
        $this->assertCount(1, $obj->getPostData());

        $obj->removePostData("Name");
        $this->assertCount(1, $obj->getPostData());

        $obj->removePostData("name");
        $this->assertCount(0, $obj->getPostData());
    }

    /**
     * Tests __construct() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function test__construct(): void {

        $obj = new CurlPostRequest($this->curlConfiguration, $this->curlResourcePath);

        $this->assertSame($this->curlConfiguration, $obj->getConfiguration());
        $this->assertEquals([], $obj->getHeaders());
        $this->assertEquals(CurlPostRequest::CURL_REQUEST_POST, $obj->getMethod());
        $this->assertEquals([], $obj->getPostData());
        $this->assertEquals([], $obj->getQueryData());
        $this->assertEquals($this->curlResourcePath, $obj->getResourcePath());
    }
}
