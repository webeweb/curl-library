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
use WBW\Library\Core\Network\HTTP\HttpHelper;
use WBW\Library\Curl\Exception\CurlRequestCallException;
use WBW\Library\Curl\Helper\CurlHelper;
use WBW\Library\Curl\Request\CurlGetRequest;
use WBW\Library\Curl\Tests\AbstractTestCase;

/**
 * cURL "GET" request test.
 *
 * @author webeweb <https://github.com/webeweb/>
 * @package WBW\Library\Curl\Tests\Request
 */
class CurlGetRequestTest extends AbstractTestCase {

    /**
     * Tests call() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testCallWithAllowEncoding(): void {

        $obj = new CurlGetRequest($this->curlConfiguration, $this->curlResourcePath);
        $obj->getConfiguration()->setAllowEncoding(true);

        $res = $obj->call();
        $this->assertEquals(CurlGetRequest::CURL_REQUEST_GET, json_decode($res->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res->getResponseInfo()["http_code"]);
    }

    /**
     * Tests call() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testCallWithConnectTimeout(): void {

        $obj = new CurlGetRequest($this->curlConfiguration, $this->curlResourcePath);
        $obj->getConfiguration()->setConnectTimeout(30);

        $res = $obj->call();
        $this->assertEquals(CurlGetRequest::CURL_REQUEST_GET, json_decode($res->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res->getResponseInfo()["http_code"]);
    }

    /**
     * Tests call() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testCallWithDebug(): void {

        $obj = new CurlGetRequest($this->curlConfiguration, $this->curlResourcePath);
        $obj->getConfiguration()->setDebug(true);

        $res = $obj->call();
        $this->assertEquals(CurlGetRequest::CURL_REQUEST_GET, json_decode($res->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res->getResponseInfo()["http_code"]);
    }

    /**
     * Tests call() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testCallWithHTTPCodes(): void {

        $obj = new CurlGetRequest($this->curlConfiguration, $this->curlResourcePath);

        foreach (CurlHelper::enumCurlResponses() as $code) {

            try {

                $obj->addQueryData("code", $code);

                $res = $obj->call();
                $this->assertEquals($code, $res->getResponseInfo()["http_code"]);
                $this->assertGreaterThanOrEqual(200, $res->getResponseInfo()["http_code"]);
                $this->assertLessThanOrEqual(299, $res->getResponseInfo()["http_code"]);
            } catch (Exception $ex) {

                $this->assertInstanceOf(CurlRequestCallException::class, $ex);

                /** @var CurlRequestCallException $ex */
                $this->assertEquals($code, $ex->getCode());
                $this->assertEquals($code, $ex->getResponse()->getResponseInfo()["http_code"]);
            }
        }
    }

    /**
     * Tests call() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testCallWithHeader(): void {

        $obj = new CurlGetRequest($this->curlConfiguration, $this->curlResourcePath);
        $obj->addHeader("h", "v");

        $res = $obj->call();
        $this->assertEquals("h: v", $res->getRequestHeader()[0]);
        $this->assertEquals(CurlGetRequest::CURL_REQUEST_GET, json_decode($res->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res->getResponseInfo()["http_code"]);
    }

    /**
     * Tests call() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testCallWithHeaderApplicationJSON(): void {

        $obj = new CurlGetRequest($this->curlConfiguration, $this->curlResourcePath);
        $obj->addHeader("Content-Type", "application/json");
        $obj->addPostData("name", "value");

        $res = $obj->call();
        $this->assertEquals("Content-Type: application/json", $res->getRequestHeader()[0]);
        $this->assertStringContainsString('{"name":"value"}', $res->getRequestBody());
        $this->assertEquals(200, $res->getResponseInfo()["http_code"]);
    }

    /**
     * Tests call() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testCallWithRequestTimeout(): void {

        $obj = new CurlGetRequest($this->curlConfiguration, $this->curlResourcePath);
        $obj->getConfiguration()->setRequestTimeout(30);

        $res = $obj->call();
        $this->assertEquals(CurlGetRequest::CURL_REQUEST_GET, json_decode($res->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res->getResponseInfo()["http_code"]);
    }

    /**
     * Tests call() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testCallWithRequestTimeoutException(): void {

        $obj = new CurlGetRequest($this->curlConfiguration, $this->curlResourcePath);
        $obj->getConfiguration()->setRequestTimeout(10);
        $obj->addQueryData("sleep", 60);

        try {

            $obj->call();
        } catch (Exception $ex) {

            $this->assertInstanceOf(CurlRequestCallException::class, $ex);

            /** @var CurlRequestCallException $ex */
            $this->assertStringContainsString("Call to ", $ex->getMessage());
            $this->assertEquals(0, $ex->getResponse()->getResponseInfo()["http_code"]);
        }
    }

    /**
     * Tests call() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testCallWithSSLVerification(): void {

        $obj = new CurlGetRequest($this->curlConfiguration, $this->curlResourcePath);
        $obj->getConfiguration()->setSslVerification(false);

        $res = $obj->call();
        $this->assertEquals(CurlGetRequest::CURL_REQUEST_GET, json_decode($res->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res->getResponseInfo()["http_code"]);
    }

    /**
     * Tests call() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testCallWithVerbose(): void {

        $obj = new CurlGetRequest($this->curlConfiguration, $this->curlResourcePath);
        $obj->getConfiguration()->setVerbose(true);

        $res = $obj->call();
        $this->assertEquals(CurlGetRequest::CURL_REQUEST_GET, json_decode($res->getResponseBody(), true)["method"]);
        $this->assertEquals(200, $res->getResponseInfo()["http_code"]);
    }

    /**
     * Tests the clearHeader() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testClearHeaders(): void {

        $obj = new CurlGetRequest($this->curlConfiguration, $this->curlResourcePath);

        $obj->addHeader("name", "value");
        $this->assertCount(1, $obj->getHeaders());

        $obj->clearHeaders();
        $this->assertCount(0, $obj->getHeaders());
    }

    /**
     * Tests the clearQueryData() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testClearQueryData(): void {

        $obj = new CurlGetRequest($this->curlConfiguration, $this->curlResourcePath);

        $obj->addQueryData("name", "value");
        $this->assertCount(1, $obj->getQueryData());

        $obj->clearQueryData();
        $this->assertCount(0, $obj->getQueryData());
    }

    /**
     * Tests removeHeader() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testRemoveHeader(): void {

        $obj = new CurlGetRequest($this->curlConfiguration, $this->curlResourcePath);

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
     * @throws Exception Throws an exception if an error occurs.
     */
    public function testRemoveQueryData(): void {

        $obj = new CurlGetRequest($this->curlConfiguration, $this->curlResourcePath);

        $obj->addQueryData("name", "value");
        $this->assertCount(1, $obj->getQueryData());

        $obj->removeQueryData("Name");
        $this->assertCount(1, $obj->getQueryData());

        $obj->removeQueryData("name");
        $this->assertCount(0, $obj->getQueryData());
    }

    /**
     * Tests __construct() method.
     *
     * @return void
     * @throws Exception Throws an exception if an error occurs.
     */
    public function test__construct(): void {

        $obj = new CurlGetRequest($this->curlConfiguration, $this->curlResourcePath);

        $this->assertSame($this->curlConfiguration, $obj->getConfiguration());
        $this->assertEquals([], $obj->getHeaders());
        $this->assertEquals(CurlGetRequest::CURL_REQUEST_GET, $obj->getMethod());
        $this->assertEquals([], $obj->getPostData());
        $this->assertEquals([], $obj->getQueryData());
        $this->assertEquals($this->curlResourcePath, $obj->getResourcePath());
    }
}
