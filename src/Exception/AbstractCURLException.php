<?php

/**
 * This file is part of the curl-library package.
 *
 * (c) 2017 WEBEWEB
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Exception;

use Exception;

/**
 * Abstract cURL exception.
 *
 * @author webeweb <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Exception
 * @abstract
 */
abstract class AbstractCURLException extends Exception {

    /**
     * Constructor.
     *
     * @param string $message The message.
     * @param int $code The code.
     * @param Exception $previous The previous exception.
     */
    public function __construct($message, $code = 500, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

}
