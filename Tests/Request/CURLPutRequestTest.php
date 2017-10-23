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

use WBW\Library\CURL\Request\CURLPutRequest;

/**
 * CURL PUT request test.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Request
 * @final
 */
final class CURLPutRequestTest extends AbstractCURLRequestTest {

    /**
     * Test __construct() method.
     *
     * @return void
     */
    public function testConstructor() {

        $obj = new CURLPutRequest($this->configuration, self::RESOURCE_PATH);

        $this->assertEquals($this->configuration, $obj->getConfiguration(), "The method getConfiguration() does not return the expected value");
        $this->assertEquals([], $obj->getHeaders(), "The method getHeaders() does not return the expecetd value");
        $this->assertEquals(CURLPutRequest::METHOD_PUT, $obj->getMethod(), "The method getMethod() does not return the expecetd value");
        $this->assertEquals([], $obj->getPostData(), "The method getPostData() does not return the expecetd value");
        $this->assertEquals([], $obj->getQueryData(), "The method getQueryData() does not return the expecetd value");
        $this->assertEquals(self::RESOURCE_PATH, $obj->getResourcePath(), "The method getResourcePath() does not return the expecetd value");
    }

}
