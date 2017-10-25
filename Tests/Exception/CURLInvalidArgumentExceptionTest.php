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
use WBW\Library\CURL\Exception\CURLInvalidArgumentException;

/**
 * CURL invalid argument exception test.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Exception
 * @final
 */
final class CURLInvalidArgumentExceptionTest extends PHPUnit_Framework_TestCase {

    /**
     * Tests the __construct() method.
     */
    public function testConstruct() {

        $ex = new CURLInvalidArgumentException("");

        $res = "";
        $this->assertEquals($res, $ex->getMessage(), "The method getMessage() does not return the expected string");
    }

}
