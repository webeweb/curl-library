<?php

/*
 * This file is part of the WBWCURLLibrary package.
 *
 * (c) 2017 NdC/WBW
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Exception;

use WBW\Library\CURL\Response\CURLResponse;

/**
 * CURL request call exception.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Exception
 * @final
 */
final class CURLRequestCallException extends AbstractCURLException {

	/**
	 * CURL response.
	 *
	 * @var CURLResponse
	 */
	private $response;

	/**
	 * Constructor.
	 *
	 * @param string $message The message.
	 */
	public function __construct($message, CURLResponse $cURLResponse) {
		parent::__construct($message);
		$this->response = $cURLResponse;
	}

	/**
	 * Get the response.
	 *
	 * @return CURLResponse Returns the cURL response.
	 */
	public function getResponse() {
		return $this->response;
	}

}
