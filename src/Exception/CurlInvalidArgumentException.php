<?php

/*
 * This file is part of the curl-library package.
 *
 * (c) 2017 WEBEWEB
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\Curl\Exception;

/**
 * cURL invalid argument exception.
 *
 * @author webeweb <https://github.com/webeweb/>
 * @package WBW\Library\Curl\Exception
 */
class CurlInvalidArgumentException extends AbstractCurlException {

    /**
     * Constructor.
     *
     * @param string $message The message.
     */
    public function __construct(string $message) {
        parent::__construct($message);
    }
}
