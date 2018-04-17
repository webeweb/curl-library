<?php

/**
  /*
 * This file is part of the curl-library package.
 *
 * (c) 2017 WEBEWEB
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Tests\Request;

use WBW\Library\CURL\Request\CURLPatchRequest;

/**
 * cURL PATCH request test.
 *
 * @author webeweb <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Request
 * @final
 */
final class CURLPatchRequestTest extends AbstractCURLRequestTest {

    /**
     * Tests __construct() method.
     *
     * @return void
     */
    public function testConstructor() {

        $obj = new CURLPatchRequest($this->configuration, self::RESOURCE_PATH);

        $this->assertEquals($this->configuration, $obj->getConfiguration());
        $this->assertEquals([], $obj->getHeaders());
        $this->assertEquals(CURLPatchRequest::HTTP_METHOD_PATCH, $obj->getMethod());
        $this->assertEquals([], $obj->getPostData());
        $this->assertEquals([], $obj->getQueryData());
        $this->assertEquals("testCall.php", $obj->getResourcePath());
    }

    /**
     * Tests call() method.
     *
     * @return void
     */
    public function testCall() {

        $obj = new CURLPatchRequest($this->configuration, self::RESOURCE_PATH);

        $obj->addHeader("header", "header");
        $obj->addQueryData("queryData", "queryData");

        $res = $obj->call();

        $this->assertContains("header: header", $res->getRequestHeader());
        $this->assertContains("queryData=queryData", $res->getRequestURL());
        $this->assertEquals(CURLPatchRequest::HTTP_METHOD_PATCH, json_decode($res->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res->getResponseInfo()["http_code"]);
    }

}
