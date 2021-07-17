<?php

/*
 * This file is part of the curl-library package.
 *
 * (c) 2018 WEBEWEB
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\Curl\Tests\Request;

use Exception;
use WBW\Library\Curl\Request\CurlOptionsRequest;
use WBW\Library\Curl\Tests\AbstractTestCase;

/**
 * cURL "OPTIONS" request test.
 *
 * @author webeweb <https://github.com/webeweb/>
 * @package WBW\Library\Curl\Tests\Request
 */
class CurlOptionsRequestTest extends AbstractTestCase {

    /**
     * Tests call() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testCall(): void {

        $obj = new CurlOptionsRequest($this->curlConfiguration, $this->curlResourcePath);
        $obj->addHeader("header", "header");
        $obj->addQueryData("queryData", "queryData");

        $res = $obj->call();
        $this->assertEquals("header: header", $res->getRequestHeader()[0]);
        $this->assertStringContainsString("queryData=queryData", $res->getRequestUrl());
        $this->assertEquals(CurlOptionsRequest::CURL_REQUEST_OPTIONS, json_decode($res->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res->getResponseInfo()["http_code"]);
    }

    /**
     * Tests __construct() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function test__construct(): void {

        $obj = new CurlOptionsRequest($this->curlConfiguration, $this->curlResourcePath);

        $this->assertSame($this->curlConfiguration, $obj->getConfiguration());
        $this->assertEquals([], $obj->getHeaders());
        $this->assertEquals(CurlOptionsRequest::CURL_REQUEST_OPTIONS, $obj->getMethod());
        $this->assertEquals([], $obj->getPostData());
        $this->assertEquals([], $obj->getQueryData());
        $this->assertEquals($this->curlResourcePath, $obj->getResourcePath());
    }
}
