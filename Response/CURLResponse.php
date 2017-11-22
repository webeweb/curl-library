<?php

/**
 * This file is part of the curl-library package.
 *
 * (c) 2017 NdC/WBW
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Response;

/**
 * CURL response.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Response
 * @final
 */
final class CURLResponse {

	/**
	 * Request body.
	 *
	 * @var string
	 */
	private $requestBody;

	/**
	 * Request header.
	 *
	 * @var array
	 */
	private $requestHeader = [];

	/**
	 * Request URL.
	 *
	 * @var string
	 */
	private $requestURL;

	/**
	 * Response body.
	 *
	 * @var string
	 */
	private $responseBody;

	/**
	 * Response header.
	 *
	 * @var array
	 */
	private $responseHeader = [];

	/**
	 * Response info.
	 *
	 * @var array
	 */
	private $responseInfo = [];

	/**
	 * Constructor.
	 */
	public function __construct() {
		// NOTHING TO DO.
	}

	/**
	 * Get the request body.
	 *
	 * @return string Returns the request body.
	 */
	public function getRequestBody() {
		return $this->requestBody;
	}

	/**
	 * Get the request header.
	 *
	 * @return array Returns the request header.
	 */
	public function getRequestHeader() {
		return $this->requestHeader;
	}

	/**
	 * Get the request URL.
	 *
	 * @return string Returns the request URL.
	 */
	public function getRequestURL() {
		return $this->requestURL;
	}

	/**
	 * Get the response body.
	 *
	 * @return string The response body.
	 */
	public function getResponseBody() {
		return $this->responseBody;
	}

	/**
	 * Get the response header.
	 *
	 * @return array Returns the response header.
	 */
	public function getResponseHeader() {
		return $this->responseHeader;
	}

	/**
	 * Get the response info.
	 *
	 * @return array Returns the response info.
	 */
	public function getResponseInfo() {
		return $this->responseInfo;
	}

	/**
	 * Set the request body.
	 *
	 * @param string $requestBody The request body.
	 * @return CURLResponse Returns the CURL response.
	 */
	public function setRequestBody($requestBody) {
		$this->requestBody = $requestBody;
		return $this;
	}

	/**
	 * Set the request header.
	 *
	 * @param array $requestHeader The request header.
	 * @return CURLResponse Returns the CURL response.
	 */
	public function setRequestHeader(array $requestHeader = []) {
		$this->requestHeader = $requestHeader;
		return $this;
	}

	/**
	 * Set the request URL.
	 *
	 * @param string $requestURL The request URL.
	 * @return CURLResponse Returns the CURL response.
	 */
	public function setRequestURL($requestURL) {
		$this->requestURL = $requestURL;
		return $this;
	}

	/**
	 * Set the response body.
	 *
	 * @param string $responseBody The response body.
	 * @return CURLResponse Returns the CURL response.
	 */
	public function setResponseBody($responseBody) {
		$this->responseBody = $responseBody;
		return $this;
	}

	/**
	 * Set the response header.
	 *
	 * @param array $responseHeader The response header.
	 * @return CURLResponse Returns the CURL response.
	 */
	public function setResponseHeader(array $responseHeader = []) {
		$this->responseHeader = $responseHeader;
		return $this;
	}

	/**
	 * Set the response info.
	 *
	 * @param array $responseInfo The response info.
	 * @return CURLResponse Returns the CURL response.
	 */
	public function setResponseInfo(array $responseInfo = []) {
		$this->responseInfo = $responseInfo;
		return $this;
	}

}
