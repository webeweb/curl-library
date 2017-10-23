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

use PHPUnit_Framework_TestCase;
use WBW\Library\CURL\Request\CURLRequestInterface;

/**
 * CURL request interface test.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Request
 * @final
 */
final class CURLRequestInterfaceTest extends PHPUnit_Framework_TestCase {

    /**
     * Test the __constructor() method.
     *
     * @return void
     */
    public function testConstructor() {

        $this->assertEquals("DELETE", CURLRequestInterface::METHOD_DELETE, "The constant METHOD_DELETE does not return the expected value");
        $this->assertEquals("GET", CURLRequestInterface::METHOD_GET, "The constant METHOD_GET does not return the expected value");
        $this->assertEquals("HEAD", CURLRequestInterface::METHOD_HEAD, "The constant METHOD_HEAD does not return the expected value");
        $this->assertEquals("OPTIONS", CURLRequestInterface::METHOD_OPTIONS, "The constant METHOD_OPTIONS does not return the expected value");
        $this->assertEquals("PATCH", CURLRequestInterface::METHOD_PATCH, "The constant METHOD_PATCH does not return the expected value");
        $this->assertEquals("POST", CURLRequestInterface::METHOD_POST, "The constant METHOD_POST does not return the expected value");
        $this->assertEquals("PUT", CURLRequestInterface::METHOD_PUT, "The constant METHOD_PUT does not return the expected value");
    }

}
