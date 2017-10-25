<?php

/*
 * This file is part of the WBWCURLLibrary package.
 *
 * (c) 2017 NdC/WBW
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Tests\Exception;

use PHPUnit_Framework_TestCase;
use WBW\Library\CURL\Exception\CURLRequestCallException;
use WBW\Library\CURL\Response\CURLResponse;

/**
 * CURL request call exception test.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Exception
 * @final
 */
final class CURLRequestCallExceptionTest extends PHPUnit_Framework_TestCase {

    /**
     * Tests the __constructor() method.
     *
     * @return void
     */
    public function testConstructor() {

        $obj = new CURLRequestCallException("", new CURLResponse());

        $this->assertEquals("", $obj->getMessage(), "The method getMessage() does not return the expecetd string");
        $this->assertEquals(null, $obj->getResponse()->getRequestBody(), "The method getRequestBody() does not return the expected value");
        $this->assertEquals([], $obj->getResponse()->getRequestHeader(), "The method getRequestHeader() does not return the expected value");
        $this->assertEquals(null, $obj->getResponse()->getRequestURL(), "The method getRequestURL() does not return the expected value");
        $this->assertEquals(null, $obj->getResponse()->getResponseBody(), "The method getResponseBody() does not return the expected value");
        $this->assertEquals([], $obj->getResponse()->getResponseHeader(), "The method getResponseHeader() does not return the expected value");
        $this->assertEquals([], $obj->getResponse()->getResponseInfo(), "The method getResponseInfo() does not return the expected value");
    }

}
