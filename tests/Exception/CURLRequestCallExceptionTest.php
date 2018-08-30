<?php

/**
 * This file is part of the curl-library package.
 *
 * (c) 2017 WEBEWEB
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Tests\Exception;

use PHPUnit_Framework_TestCase;
use WBW\Library\CURL\Exception\CURLRequestCallException;
use WBW\Library\CURL\Response\CURLResponse;

/**
 * cURL request call exception test.
 *
 * @author webeweb <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Exception
 * @final
 */
final class CURLRequestCallExceptionTest extends PHPUnit_Framework_TestCase {

    /**
     * Tests the __constructor() method.
     *
     * @return void
     */
    public function testConstruct() {

        $obj = new CURLRequestCallException("exception", 404, new CURLResponse());

        $this->assertEquals(404, $obj->getCode());
        $this->assertEquals("exception", $obj->getMessage());
        $this->assertNull($obj->getResponse()->getRequestBody());
        $this->assertEquals([], $obj->getResponse()->getRequestHeader());
        $this->assertNull($obj->getResponse()->getRequestURL());
        $this->assertNull($obj->getResponse()->getResponseBody());
        $this->assertEquals([], $obj->getResponse()->getResponseHeader());
        $this->assertEquals([], $obj->getResponse()->getResponseInfo());
    }

}
