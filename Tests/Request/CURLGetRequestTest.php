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
            $obj->addHeader(1, "value");
        } catch (Exception $ex) {
            $this->assertInstanceOf(StringArgumentException::class, $ex, "The method addHeader() dos not throw the expected exception");
            $this->assertEquals("The argument \"1\" is not a string", $ex->getMessage(), "The getMessage() does not return the expecetd string");
        }

        $obj->addHeader("name", "value");

        $res = ["name" => "value"];
        $this->assertEquals($res, $obj->getHeaders(), "The method getHeaders() does not return the expected value");
    }

    /**
     * Test addQueryData() method.
     *
     * @return void
     */
    public function testAddQueryData() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        try {
            $obj->addQueryData(1, "value");
        } catch (Exception $ex) {
            $this->assertInstanceOf(StringArgumentException::class, $ex, "The method addQueryData() dos not throw the expected exception");
            $this->assertEquals("The argument \"1\" is not a string", $ex->getMessage(), "The getMessage() does not return the expecetd string");
        }

        $obj->addQueryData("name", "value");

        $res = ["name" => "value"];
        $this->assertEquals($res, $obj->getQueryData(), "The method getQueryData() does not return the expected value");
    }

    /**
     * Test call() method.
     *
     * @return void
     */
    public function testCall() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        /* === Allow encoding ============================================== */
        $obj->getConfiguration()->setAllowEncoding(true);

        $res1 = $obj->call();

        $this->assertEquals(CURLGetRequest::METHOD_GET, json_decode($res1->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res1->getResponseInfo()["http_code"], "The method getResponseInfo() does not return the expected value");

        /* === Connect timeout ============================================= */
        $obj->getConfiguration()->setAllowEncoding(false);
        $obj->getConfiguration()->setConnectTimeout(30);

        $res2 = $obj->call();

        $this->assertEquals(CURLGetRequest::METHOD_GET, json_decode($res2->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res2->getResponseInfo()["http_code"], "The method getResponseInfo() does not return the expected value");

        /* === Debug ======================================================= */
        $obj->getConfiguration()->setConnectTimeout(0);
        $obj->getConfiguration()->setDebug(true);

        $res3 = $obj->call();

        $this->assertEquals(CURLGetRequest::METHOD_GET, json_decode($res3->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res3->getResponseInfo()["http_code"], "The method getResponseInfo() does not return the expected value");

        /* === Headers ===================================================== */
        $obj->getConfiguration()->setDebug(false);
        $obj->addHeader("h", "v");

        $res4 = $obj->call();

        $this->assertContains("h: v", $res4->getRequestHeader(), "The method getRequestHeader() does not return the expecetd value");
        $this->assertEquals(CURLGetRequest::METHOD_GET, json_decode($res4->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res4->getResponseInfo()["http_code"], "The method getResponseInfo() does not return the expected value");

        /* === Request timeout ============================================= */
        $obj->getConfiguration()->setRequestTimeout(30);

        $res5 = $obj->call();

        $this->assertEquals(CURLGetRequest::METHOD_GET, json_decode($res5->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res5->getResponseInfo()["http_code"], "The method getResponseInfo() does not return the expected value");

        /* === SSL verification ============================================ */
        $obj->getConfiguration()->setRequestTimeout(0);
        $obj->getConfiguration()->setSslVerification(false);

        $res6 = $obj->call();

        $this->assertEquals(CURLGetRequest::METHOD_GET, json_decode($res6->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res6->getResponseInfo()["http_code"], "The method getResponseInfo() does not return the expected value");

        /* === Verbose ===================================================== */
        $obj->getConfiguration()->setSslVerification(true);
        $obj->getConfiguration()->setVerbose(true);

        $res7 = $obj->call();

        $this->assertEquals(CURLGetRequest::METHOD_GET, json_decode($res7->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res7->getResponseInfo()["http_code"], "The method getResponseInfo() does not return the expected value");

        /* === HTTP codes ================================================== */
        $obj->getConfiguration()->setVerbose(false);

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
        /* ================================================================= */
    }

    /**
     * Test the clearHeader() method.
     *
     * @return void
     */
    public function testClearHeaders() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        $obj->addHeader("name", "value");
        $this->assertCount(1, $obj->getHeaders(), "The method getHeaders() does not return the expected headers count");

        $obj->clearHeaders();
        $this->assertCount(0, $obj->getHeaders(), "The method getHeaders() does not return the expected headers count");
    }

    /**
     * Test the clearQueryData() method.
     *
     * @return void
     */
    public function testClearQueryData() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        $obj->addQueryData("name", "value");
        $this->assertCount(1, $obj->getQueryData(), "The method getQueryData() does not return the expected query data count");

        $obj->clearQueryData();
        $this->assertCount(0, $obj->getQueryData(), "The method getQueryData() does not return the expected query data count");
    }

    /**
     * Test removeHeader() method.
     *
     * @return void
     */
    public function testRemoveHeader() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        $obj->addHeader("name", "value");
        $this->assertCount(1, $obj->getHeaders(), "The method getHeaders() does not return the expected value");

        $obj->removeHeader("Name");
        $this->assertCount(1, $obj->getHeaders(), "The method removeHeader() does not remove the expected value");

        $obj->removeHeader("name");
        $this->assertCount(0, $obj->getHeaders(), "The method removeHeader() does not return the expected value");
    }

    /**
     * Test removeQueryData() method.
     *
     * @return void
     */
    public function testRemoveQueryData() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        $obj->addQueryData("name", "value");
        $this->assertCount(1, $obj->getQueryData(), "The method getQueryData() does not return the expected value");

        $obj->removeQueryData("Name");
        $this->assertCount(1, $obj->getQueryData(), "The method removeQueryData() does not remove the expected value");

        $obj->removeQueryData("name");
        $this->assertCount(0, $obj->getQueryData(), "The method removeQueryData() does not return the expected value");
    }

}
