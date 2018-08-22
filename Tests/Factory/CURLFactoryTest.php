<?php

/**
 * This file is part of the curl-library package.
 *
 * (c) 2017 WEBEWEB
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Tests\Factory;

use Exception;
use PHPUnit_Framework_TestCase;
use WBW\Library\Core\Exception\IO\InvalidHTTPMethodException;
use WBW\Library\Core\IO\HTTPInterface;
use WBW\Library\CURL\Factory\CURLFactory;
use WBW\Library\CURL\Request\CURLDeleteRequest;
use WBW\Library\CURL\Request\CURLGetRequest;
use WBW\Library\CURL\Request\CURLHeadRequest;
use WBW\Library\CURL\Request\CURLOptionsRequest;
use WBW\Library\CURL\Request\CURLPatchRequest;
use WBW\Library\CURL\Request\CURLPostRequest;
use WBW\Library\CURL\Request\CURLPutRequest;

/**
 * cURL factory test.
 *
 * @author webeweb <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Factory
 * @final
 */
final class CURLFactoryTest extends PHPUnit_Framework_TestCase {

    /**
     * Tests the getInstance() method.
     *
     * @return void
     */
    public function testGetInstance() {

        try {
            CURLFactory::getInstance("exception");
        } catch (Exception $ex) {
            $this->assertInstanceOf(InvalidHTTPMethodException::class, $ex);
            $this->assertEquals("The HTTP method \"exception\" is invalid", $ex->getMessage());
        }

        $res1 = CURLFactory::getInstance(HTTPInterface::HTTP_METHOD_DELETE);
        $this->assertInstanceOf(CURLDeleteRequest::class, $res1);

        $res2 = CURLFactory::getInstance(HTTPInterface::HTTP_METHOD_GET);
        $this->assertInstanceOf(CURLGetRequest::class, $res2);

        $res3 = CURLFactory::getInstance(HTTPInterface::HTTP_METHOD_HEAD);
        $this->assertInstanceOf(CURLHeadRequest::class, $res3);

        $res4 = CURLFactory::getInstance(HTTPInterface::HTTP_METHOD_OPTIONS);
        $this->assertInstanceOf(CURLOptionsRequest::class, $res4);

        $res5 = CURLFactory::getInstance(HTTPInterface::HTTP_METHOD_PATCH);
        $this->assertInstanceOf(CURLPatchRequest::class, $res5);

        $res6 = CURLFactory::getInstance(HTTPInterface::HTTP_METHOD_POST);
        $this->assertInstanceOf(CURLPostRequest::class, $res6);

        $res7 = CURLFactory::getInstance(HTTPInterface::HTTP_METHOD_PUT);
        $this->assertInstanceOf(CURLPutRequest::class, $res7);
    }

}
