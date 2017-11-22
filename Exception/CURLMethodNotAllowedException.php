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

/**
 * CURL method not allowed exception.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Exception
 * @final
 */
final class CURLMethodNotAllowedException extends AbstractCURLException {

	/**
	 * Constructor.
	 *
	 * @param string $method The method.
	 */
	public function __construct($method) {
		parent::__construct("The method \"" . $method . "\" is not allowed");
	}

}
