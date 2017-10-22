<?php

/*
 * This file is part of the WBWCURLLibrary package.
 *
 * (c) 2017 NdC/WBW
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Request;

use Exception;
use PHPUnit_Framework_TestCase;
use WBW\Library\CURL\Configuration\CURLConfiguration;
use WBW\Library\CURL\Exception\CURLInvalidArgumentException;

/**
 * CURL HEAD request test.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Request
 * @final
 */
final class CURLHeadRequestTest extends PHPUnit_Framework_TestCase {

    /**
     * Test the addHeader() method.
     */
    public function testAddHeader() {

        $obj = new CURLHeadRequest(new CURLConfiguration(), '');

        $obj->addHeader('name', 'value');
        $res1 = ['name' => 'value'];
        $this->assertEquals($res1, $obj->getHeaders(), 'The method getHeaders() does not return the expected headers with name');

        try {
            $obj->addHeader(1, 'value');
        } catch (Exception $ex) {
            $this->assertInstanceOf(CURLInvalidArgumentException::class, $ex, 'The method addHeader() does not throws the expected exception');
            $this->assertEquals('The header name must be a string', $ex->getMessage(), 'The method addHeader() does not return the exepected exception message');
        }
    }

    /**
     * Test the removeHeader() method.
     */
    public function testRemoveHeader() {

        $obj = new CURLHeadRequest(new CURLConfiguration(), '');
        $obj->addHeader('name', 'value');

        $obj->removeHeader('');
        $res1 = ['name' => 'value'];
        $this->assertEquals($res1, $obj->getHeaders(), 'The method getHeaders() does not return the expected headers with name');

        $obj->removeHeader('name');
        $res2 = [];
        $this->assertEquals($res2, $obj->getHeaders(), 'The method getHeaders() does not return the expected headers');
    }

    /**
     * Test the addQueryData() method.
     */
    public function testAddQueryData() {

        $obj = new CURLHeadRequest(new CURLConfiguration(), '');

        $obj->addQueryData('name', 'value');
        $res1 = ['name' => 'value'];
        $this->assertEquals($res1, $obj->getQueryData(), 'The method getQueryData() does not return the expected query data with name');

        try {
            $obj->addQueryData(1, 'value');
        } catch (Exception $ex) {
            $this->assertInstanceOf(CURLInvalidArgumentException::class, $ex, 'The method addQueryData() does not throws the expected exception');
            $this->assertEquals('The query data name must be a string', $ex->getMessage(), 'The method addQueryData() does not return the exepected exception message');
        }
    }

    /**
     * Test the removeQueryData() method.
     */
    public function testRemoveQueryData() {

        $obj = new CURLHeadRequest(new CURLConfiguration(), '');
        $obj->addQueryData('name', 'value');

        $obj->removeQueryData('');
        $res1 = ['name' => 'value'];
        $this->assertEquals($res1, $obj->getQueryData(), 'The method getQueryData() does not return the expected query data with name');

        $obj->removeQueryData('name');
        $res2 = [];
        $this->assertEquals($res2, $obj->getQueryData(), 'The method getQueryData() does not return the expected query data');
    }

    /**
     * Test the addPostData() method.
     */
    public function testAddPostData() {

        $obj = new CURLHeadRequest(new CURLConfiguration(), '');

        $obj->addPostData('name', 'value');
        $res1 = ['name' => 'value'];
        $this->assertEquals($res1, $obj->getPostData(), 'The method getPostData() does not return the expected post data with name');

        try {
            $obj->addPostData(1, 'value');
        } catch (Exception $ex) {
            $this->assertInstanceOf(CURLInvalidArgumentException::class, $ex, 'The method addPostData() does not throws the expected exception');
            $this->assertEquals('The POST data name must be a string', $ex->getMessage(), 'The method addPostData() does not return the exepected exception message');
        }
    }

    /**
     * Test the removePostData() method.
     */
    public function testRemovePostData() {

        $obj = new CURLHeadRequest(new CURLConfiguration(), '');
        $obj->addPostData('name', 'value');

        $obj->removePostData('');
        $res1 = ['name' => 'value'];
        $this->assertEquals($res1, $obj->getPostData(), 'The method getPostData() does not return the expected post data with name');

        $obj->removePostData('name');
        $res2 = [];
        $this->assertEquals($res2, $obj->getPostData(), 'The method getPostData() does not return the expected post data');
    }

}
