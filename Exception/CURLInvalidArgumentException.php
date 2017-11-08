<?php

/*
 * This file is part of the curl-library package.
 *
 * (c) 2017 NdC/WBW
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Exception;

/**
 * CURL invalid argument exception.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Exception
 * @final
 */
final class CURLInvalidArgumentException extends AbstractCURLException {

	/**
	 * Constructor.
	 *
	 * @param string $masseg The message.
	 */
	public function __construct($message) {
		parent::__construct($message);
	}

}
