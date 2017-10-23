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
use WBW\Library\Core\HTTP\HTTPCodeInterface;
use WBW\Library\CURL\Exception\CURLRequestCallException;
use WBW\Library\CURL\Request\CURLGetRequest;

/**
 * CURL GET request test.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Request
 * @final
 */
final class CURLGetRequestTest extends AbstractCURLRequestTest {

    /**
     * Test __construct() method.
     *
     * @return void
     */
    public function testConstructor() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        $this->assertEquals($this->configuration, $obj->getConfiguration(), "The method getConfiguration() does not return the expected value");
        $this->assertEquals([], $obj->getHeaders(), "The method getHeaders() does not return the expecetd value");
        $this->assertEquals(CURLGetRequest::METHOD_GET, $obj->getMethod(), "The method getMethod() does not return the expecetd value");
        $this->assertEquals([], $obj->getPostData(), "The method getPostData() does not return the expecetd value");
        $this->assertEquals([], $obj->getQueryData(), "The method getQueryData() does not return the expecetd value");
        $this->assertEquals(self::RESOURCE_PATH, $obj->getResourcePath(), "The method getResourcePath() does not return the expecetd value");
    }

    /**
     * Test addHeader() method.
     *
     * @return void
     */
    public function testAddHeader() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        try {
            $obj->addHeader(1, "header");
        } catch (Exception $ex) {
            $this->assertInstanceOf(StringArgumentException::class, $ex, "The method addHeader() dos not throw the expected exception");
            $this->assertEquals("The argument \"1\" is not a string", $ex->getMessage(), "The getMessage() does not return the expecetd string");
        }

        $obj->addHeader("header", "header");

        $res = ["header" => "header"];
        $this->assertEquals($res, $obj->getHeaders(), "The method getHeaders() does not return the expected value");
    }

    /**
     * Test addQueryData() method.
     *
     * @return void
     */
    public function testAddPostData() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        try {
            $obj->addQueryData(1, "queryData");
        } catch (Exception $ex) {
            $this->assertInstanceOf(StringArgumentException::class, $ex, "The method addQueryData() dos not throw the expected exception");
            $this->assertEquals("The argument \"1\" is not a string", $ex->getMessage(), "The getMessage() does not return the expecetd string");
        }

        $obj->addQueryData("queryData", "queryData");

        $res = ["queryData" => "queryData"];
        $this->assertEquals($res, $obj->getQueryData(), "The method getQueryData() does not return the expected value");
    }

    /**
     * Test call() method.
     *
     * @return void
     */
    public function testCall() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        $obj->addHeader("header", "header");
        $obj->addQueryData("queryData", "queryData");
        $obj->getConfiguration()->setVerbose(true);

        $res = $obj->call();

        $this->assertContains("header: header", $res->getRequestHeader(), "The method getRequestHeader() does not return the expecetd value");
        $this->assertContains("queryData=queryData", $res->getRequestURL(), "The method getRequestURL() does not return the expected value");
        $this->assertEquals(CURLGetRequest::METHOD_GET, json_decode($res->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res->getResponseInfo()["http_code"], "The method getResponseInfo() does not return the expected value");

        $obj->getConfiguration()->setVerbose(false);

        // Handle each code.
        foreach (HTTPCodeInterface::CODES as $code) {

            try {

                $obj->removeQueryData("code");
                $obj->addQueryData("code", $code);

                $rslt = $obj->call();

                $this->assertEquals($code, $rslt->getResponseInfo()["http_code"], "The method getResponseInfo() does not return the expected value with code " . $code);
                $this->assertGreaterThanOrEqual(200, $rslt->getResponseInfo()["http_code"]);
                $this->assertLessThanOrEqual(299, $rslt->getResponseInfo()["http_code"]);
            } catch (Exception $ex) {
                $this->assertInstanceOf(CURLRequestCallException::class, $ex, "The method call() does not throw the expected exception");
                $this->assertEquals($code, $ex->getResponse()->getResponseInfo()["http_code"], "The method getResponseInfo() does not return the expected value with code " . $code);
            }
        }
    }

    /**
     * Test removeHeader() method.
     *
     * @return void
     */
    public function testRemoveHeader() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        $obj->addHeader("header", "header");
        $this->assertCount(1, $obj->getHeaders(), "The method getHeaders() does not return the expected value");

        $obj->removeHeader("Header");
        $this->assertCount(1, $obj->getHeaders(), "The method removeHeader() does not remove the expected value");

        $obj->removeHeader("header");
        $this->assertCount(0, $obj->getHeaders(), "The method removeHeader() does not return the expected value");
    }

    /**
     * Test removeQueryData() method.
     *
     * @return void
     */
    public function testRemoveQueryData() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        $obj->addQueryData("queryData", "queryData");
        $this->assertCount(1, $obj->getQueryData(), "The method getQueryData() does not return the expected value");

        $obj->removeQueryData("QueryData");
        $this->assertCount(1, $obj->getQueryData(), "The method removeQueryData() does not remove the expected value");

        $obj->removeQueryData("queryData");
        $this->assertCount(0, $obj->getQueryData(), "The method removeQueryData() does not return the expected value");
    }

}
