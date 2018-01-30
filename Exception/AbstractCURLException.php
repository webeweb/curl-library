<?php

/**
 * This file is part of the curl-library package.
 *
 * (c) 2017 NdC/WBW
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Exception;

use Exception;

/**
 * Abstract cURL exception.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Exception
 * @abstract
 */
abstract class AbstractCURLException extends Exception {

    /**
     * Constructor.
     *
     * @param string $message The message.
     * @param Exception $previous The previous exception.
     */
    public function __construct($message, Exception $previous = null) {
        parent::__construct($message, 500, $previous);
    }

}
