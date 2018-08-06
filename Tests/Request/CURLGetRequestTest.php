<?php

/**
 * This file is part of the curl-library package.
 *
 * (c) 2017 WEBEWEB
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Tests\Request;

use Exception;
use WBW\Library\Core\Exception\Argument\StringArgumentException;
use WBW\Library\Core\Utility\IO\HTTPUtility;
use WBW\Library\CURL\Exception\CURLRequestCallException;
use WBW\Library\CURL\Request\CURLGetRequest;

/**
 * cURL GET request test.
 *
 * @author webeweb <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Request
 * @final
 */
final class CURLGetRequestTest extends AbstractCURLRequestTest {

    /**
     * Tests __construct() method.
     *
     * @return void
     */
    public function testConstruct() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        $this->assertSame($this->configuration, $obj->getConfiguration());
        $this->assertEquals([], $obj->getHeaders());
        $this->assertEquals(CURLGetRequest::HTTP_METHOD_GET, $obj->getMethod());
        $this->assertEquals([], $obj->getPostData());
        $this->assertEquals([], $obj->getQueryData());
        $this->assertEquals("testCall.php", $obj->getResourcePath());
    }

    /**
     * Tests addHeader() method.
     *
     * @return void
     */
    public function testAddHeader() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        try {
            $obj->addHeader(1, "value");
        } catch (Exception $ex) {
            $this->assertInstanceOf(StringArgumentException::class, $ex);
            $this->assertEquals("The argument \"1\" is not a string", $ex->getMessage());
        }

        $obj->addHeader("name", "value");

        $res = ["name" => "value"];
        $this->assertEquals($res, $obj->getHeaders());
    }

    /**
     * Tests addQueryData() method.
     *
     * @return void
     */
    public function testAddQueryData() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        try {
            $obj->addQueryData(1, "value");
        } catch (Exception $ex) {
            $this->assertInstanceOf(StringArgumentException::class, $ex);
            $this->assertEquals("The argument \"1\" is not a string", $ex->getMessage());
        }

        $obj->addQueryData("name", "value");

        $res = ["name" => "value"];
        $this->assertEquals($res, $obj->getQueryData());
    }

    /**
     * Tests call() method.
     *
     * @return void
     */
    public function testCall() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        /* === Allow encoding ============================================== */
        $obj->getConfiguration()->setAllowEncoding(true);

        $resAE = $obj->call();

        $this->assertEquals(CURLGetRequest::HTTP_METHOD_GET, json_decode($resAE->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $resAE->getResponseInfo()["http_code"]);

        $obj->getConfiguration()->setAllowEncoding(false);

        /* === Connect timeout ============================================= */
        $obj->getConfiguration()->setConnectTimeout(30);

        $resCT = $obj->call();

        $this->assertEquals(CURLGetRequest::HTTP_METHOD_GET, json_decode($resCT->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $resCT->getResponseInfo()["http_code"]);

        $obj->getConfiguration()->setConnectTimeout(0);

        /* === Debug ======================================================= */
        $obj->getConfiguration()->setDebug(true);

        $resD = $obj->call();

        $this->assertEquals(CURLGetRequest::HTTP_METHOD_GET, json_decode($resD->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $resD->getResponseInfo()["http_code"]);

        $obj->getConfiguration()->setDebug(false);

        /* === Headers ===================================================== */
        $obj->addHeader("h", "v");

        $resH = $obj->call();

        $this->assertContains("h: v", $resH->getRequestHeader());
        $this->assertEquals(CURLGetRequest::HTTP_METHOD_GET, json_decode($resH->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $resH->getResponseInfo()["http_code"]);

        $obj->removeHeader("h");

        /* === JSON ======================================================== */
        $obj->addHeader("Content-Type", "application/json");
        $obj->addPostData("name", "value");

        $resJSON = $obj->call();

        $this->assertContains("Content-Type: application/json", $resJSON->getRequestHeader());
        $this->assertContains('{"name":"value"}', $resJSON->getRequestBody());
        $this->assertEquals(CURLGetRequest::HTTP_METHOD_GET, json_decode($resH->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $resH->getResponseInfo()["http_code"]);

        $obj->removeHeader("Content-Type");
        $obj->removePostData("name");

        /* === Request timeout ============================================= */
        $obj->getConfiguration()->setRequestTimeout(30);

        $resRT = $obj->call();

        $this->assertEquals(CURLGetRequest::HTTP_METHOD_GET, json_decode($resRT->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $resRT->getResponseInfo()["http_code"]);

        $obj->getConfiguration()->setRequestTimeout(0);

        /* === SSL verification ============================================ */
        $obj->getConfiguration()->setSslVerification(false);

        $resSSL = $obj->call();

        $this->assertEquals(CURLGetRequest::HTTP_METHOD_GET, json_decode($resSSL->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $resSSL->getResponseInfo()["http_code"]);

        $obj->getConfiguration()->setSslVerification(true);

        /* === Verbose ===================================================== */
        $obj->getConfiguration()->setVerbose(true);

        $resV = $obj->call();

        $this->assertEquals(CURLGetRequest::HTTP_METHOD_GET, json_decode($resV->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $resV->getResponseInfo()["http_code"]);

        $obj->getConfiguration()->setVerbose(false);
        /* === HTTP code 0 ================================================= */
        $obj->getConfiguration()->setRequestTimeout(10);
        $obj->addQueryData("sleep", 60);

        try {
            $obj->call();
        } catch (Exception $ex) {

            $this->assertInstanceOf(CURLRequestCallException::class, $ex);
            $this->assertContains("Call to ", $ex->getMessage());
            $this->assertEquals(0, $ex->getResponse()->getResponseInfo()["http_code"]);
        }

        $obj->getConfiguration()->setRequestTimeout(0);
        $obj->removeQueryData("sleep");

        /* === HTTP codes ================================================== */
        foreach (HTTPUtility::getHTTPStatus() as $code) {
            try {

                $obj->addQueryData("code", $code);

                $rslt = $obj->call();

                $this->assertEquals($code, $rslt->getResponseInfo()["http_code"], "The method getResponseInfo() does not return the expected value with code " . $code);
                $this->assertGreaterThanOrEqual(200, $rslt->getResponseInfo()["http_code"]);
                $this->assertLessThanOrEqual(299, $rslt->getResponseInfo()["http_code"]);
            } catch (Exception $ex) {

                $this->assertInstanceOf(CURLRequestCallException::class, $ex);
                $this->assertEquals($code, $ex->getResponse()->getResponseInfo()["http_code"], "The method getResponseInfo() does not return the expected value with code " . $code);
            }
        }

        /* ================================================================= */
    }

    /**
     * Tests the clearHeader() method.
     *
     * @return void
     */
    public function testClearHeaders() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        $obj->addHeader("name", "value");
        $this->assertCount(1, $obj->getHeaders());

        $obj->clearHeaders();
        $this->assertCount(0, $obj->getHeaders());
    }

    /**
     * Tests the clearQueryData() method.
     *
     * @return void
     */
    public function testClearQueryData() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        $obj->addQueryData("name", "value");
        $this->assertCount(1, $obj->getQueryData());

        $obj->clearQueryData();
        $this->assertCount(0, $obj->getQueryData());
    }

    /**
     * Tests removeHeader() method.
     *
     * @return void
     */
    public function testRemoveHeader() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        $obj->addHeader("name", "value");
        $this->assertCount(1, $obj->getHeaders());

        $obj->removeHeader("Name");
        $this->assertCount(1, $obj->getHeaders());

        $obj->removeHeader("name");
        $this->assertCount(0, $obj->getHeaders());
    }

    /**
     * Tests removeQueryData() method.
     *
     * @return void
     */
    public function testRemoveQueryData() {

        $obj = new CURLGetRequest($this->configuration, self::RESOURCE_PATH);

        $obj->addQueryData("name", "value");
        $this->assertCount(1, $obj->getQueryData());

        $obj->removeQueryData("Name");
        $this->assertCount(1, $obj->getQueryData());

        $obj->removeQueryData("name");
        $this->assertCount(0, $obj->getQueryData());
    }

}
