<?php

/**
 * This file is part of the curl-library package.
 *
 * (c) 2017 NdC/WBW
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Request;

use DateTime;
use WBW\Library\Core\Argument\ArgumentValidator;
use WBW\Library\Core\Exception\Argument\StringArgumentException;
use WBW\Library\Core\Exception\HTTP\InvalidHTTPMethodException;
use WBW\Library\Core\HTTP\HTTPMethodInterface;
use WBW\Library\CURL\Configuration\CURLConfiguration;
use WBW\Library\CURL\Exception\CURLRequestCallException;
use WBW\Library\CURL\Response\CURLResponse;

/**
 * Abstract CURL request.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Request
 * @abstract
 */
abstract class AbstractCURLRequest implements HTTPMethodInterface {

	/**
	 * Content-type application/x-www-form-urlencoded
	 *
	 * @var string
	 */
	const CONTENT_TYPE_X_WWW_FORM_URLENCODED = "Content-Type: application/x-www-form-urlencoded";

	/**
	 * Configuration.
	 *
	 * @var CURLConfiguration
	 */
	private $configuration;

	/**
	 * Headers.
	 *
	 * @var array
	 */
	private $headers = [];

	/**
	 * Method.
	 *
	 * @var string
	 */
	private $method = self::METHOD_GET;

	/**
	 * POST data.
	 *
	 * @var array
	 */
	private $postData = [];

	/**
	 * Query data.
	 *
	 * @var array
	 */
	private $queryData = [];

	/**
	 * Resource path.
	 *
	 * @var string
	 */
	private $resourcePath;

	/**
	 * Constructor.
	 *
	 * @param string $method The Method.
	 * @param CURLConfiguration $configuration The configuration.
	 * @param string $resourcePath The resource path.
	 * @throws InvalidHTTPMethodException Throws an invalid HTTP method exception if the method is not implemented.
	 */
	protected function __construct($method, CURLConfiguration $configuration, $resourcePath) {
		$this->setConfiguration($configuration);
		$this->setMethod($method);
		$this->setResourcePath($resourcePath);
	}

	/**
	 * Add an header.
	 *
	 * @param string $name The header name.
	 * @param string $value The header value.
	 * @throws StringArgumentException Throws a string argument exception if the name is not a string.
	 */
	final public function addHeader($name, $value) {
		ArgumentValidator::isValid($name, ArgumentValidator::TYPE_STRING);
		$this->headers[$name] = $value;
	}

	/**
	 * Add a POST data.
	 *
	 * @param string $name The POST data name.
	 * @param string $value The POST data value.
	 * @throws StringArgumentException Throws a string argument exception if the name is not a string.
	 */
	final public function addPostData($name, $value) {
		ArgumentValidator::isValid($name, ArgumentValidator::TYPE_STRING);
		$this->postData[$name] = $value;
	}

	/**
	 * Add a query data.
	 *
	 * @param string $name The query data name.
	 * @param string $value The query data value.
	 * @throws StringArgumentException Throws a string argument exception if the name is not a string.
	 */
	final public function addQueryData($name, $value) {
		ArgumentValidator::isValid($name, ArgumentValidator::TYPE_STRING);
		$this->queryData[$name] = $value;
	}

	/**
	 * Call the request.
	 *
	 * @return CURLResponse Returns the response.
	 * @throws CURLRequestCallException Throws a CURL request call if something failed.
	 */
	final public function call() {

		// Define the necessary argurments.
		$curlHeaders	 = $this->mergeHeaders();
		$curlPOSTData	 = http_build_query($this->getPostData());

		//
		if (in_array("Content-Type: application/json", $curlHeaders)) {
			$curlPOSTData = json_encode($this->getPostData());
		}

		// Initialize the URL.
		$curlURL = $this->mergeURL();
		if (0 < count($this->getQueryData())) {
			$curlURL = implode("?", [$curlURL, http_build_query($this->getQueryData())]);
		}

		// Initialize CURL.
		$curl = curl_init();

		// Set the connect timeout.
		if (0 < $this->getConfiguration()->getConnectTimeout()) {
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->getConfiguration()->getConnectTimeout());
		}

		// Set the encoding.
		if (true === $this->getConfiguration()->getAllowEncoding()) {
			curl_setopt($curl, CURLOPT_ENCODING, "");
		}

		// Set the HTTP headers.
		curl_setopt($curl, CURLOPT_HTTPHEADER, $curlHeaders);

		// Set the post.
		switch ($this->getMethod()) {

			case self::METHOD_DELETE:
			case self::METHOD_OPTIONS:
			case self::METHOD_PATCH:
			case self::METHOD_PUT:
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->getMethod());
				curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPOSTData);
				break;

			case self::METHOD_HEAD:
				curl_setopt($curl, CURLOPT_NOBODY, true);
				break;

			case self::METHOD_POST:
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPOSTData);
				break;
		}

		// Set the proxy.
		if (!is_null($this->getConfiguration()->getProxyHost())) {
			curl_setopt($curl, CURLOPT_PROXY, $this->getConfiguration()->getProxyHost());
		}
		if (!is_null($this->getConfiguration()->getProxyPort())) {
			curl_setopt($curl, CURLOPT_PROXYPORT, $this->getConfiguration()->getProxyPort());
		}
		if (!is_null($this->getConfiguration()->getProxyType())) {
			curl_setopt($curl, CURLOPT_PROXYTYPE, $this->getConfiguration()->getProxyType());
		}
		if (!is_null($this->getConfiguration()->getProxyUsername())) {
			curl_setopt($curl, CURLOPT_PROXYUSERPWD, implode(":", [$this->getConfiguration()->getProxyUsername(), $this->getConfiguration()->getProxyPassword()]));
		}

		// Set the return.
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		// Set the SSL verification.
		if (false === $this->getConfiguration()->getSslVerification()) {
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		}

		// Set the request timeout.
		if (0 < $this->getConfiguration()->getRequestTimeout()) {
			curl_setopt($curl, CURLOPT_TIMEOUT, $this->getConfiguration()->getRequestTimeout());
		}

		// Set the URL.
		curl_setopt($curl, CURLOPT_URL, $curlURL);

		// Set the user agent.
		curl_setopt($curl, CURLOPT_USERAGENT, $this->getConfiguration()->getUserAgent());

		// Get the HTTP response headers.
		curl_setopt($curl, CURLOPT_HEADER, 1);

		// Set the verbose.
		if (true === $this->getConfiguration()->getDebug()) {
			curl_setopt($curl, CURLOPT_STDERR, fopen($this->getConfiguration()->getDebugFile(), "a"));
			curl_setopt($curl, CURLOPT_VERBOSE, 0);

			$msg = (new DateTime())->format("c") . " [DEBUG] " . $curlURL . PHP_EOL . "HTTP request body ~BEGIN~" . PHP_EOL . print_r($curlPOSTData, true) . PHP_EOL . "~END~" . PHP_EOL;
			error_log($msg, 3, $this->getConfiguration()->getDebugFile());
		} else {
			if (true === $this->getConfiguration()->getVerbose()) {
				curl_setopt($curl, CURLOPT_VERBOSE, 1);
			} else {
				curl_setopt($curl, CURLOPT_VERBOSE, 0);
			}
		}

		// Make the request.
		$curlExec		 = curl_exec($curl);
		$httpHeadSize	 = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$httpHead		 = $this->parseheader(substr($curlExec, 0, $httpHeadSize));
		$httpBody		 = substr($curlExec, $httpHeadSize);
		$curlInfo		 = curl_getinfo($curl);

		//
		if (true === $this->getConfiguration()->getDebug()) {
			$msg = (new DateTime())->format("c") . " [DEBUG] " . $curlURL . PHP_EOL . "HTTP response body ~BEGIN~" . PHP_EOL . print_r($httpBody, true) . PHP_EOL . "~END~" . PHP_EOL;
			error_log($msg, 3, $this->getConfiguration()->getDebugFile());
		}

		// Initialize the response.
		$response = new CURLResponse();
		$response->setRequestBody($curlPOSTData);
		$response->setRequestHeader($curlHeaders);
		$response->setRequestURL($curlURL);
		$response->setResponseBody($httpBody);
		$response->setResponseHeader($httpHead);
		$response->setResponseInfo($curlInfo);

		// Check HTTP code.
		if (200 <= $curlInfo["http_code"] && $curlInfo["http_code"] <= 299) {

			// Return the response.
			return $response;
		}

		// Initialize the message.
		$msg = curl_errno($curl);

		// Check the HTTP code.
		if (0 === $curlInfo["http_code"]) {
			if (!empty(curl_error($curl))) {
				$msg = "Call to " . $curlURL . " failed : " . curl_error($curl);
			} else {
				$msg = "Call to " . $curlURL . " failed, but for an unknown reason. This could happen if you are disconnected from the network.";
			}
		}

		// Throw the exception.
		throw new CURLRequestCallException($msg, $response);
	}

	/**
	 * Clear headers.
	 *
	 * @return AbstractCURLRequest Return the CURL request.
	 */
	final public function clearHeaders() {
		return $this->setHeaders();
	}

	/**
	 * Clear post data.
	 *
	 * @return AbstractCURLRequest Return the CURL request.
	 */
	final public function clearPostData() {
		return $this->setPostData();
	}

	/**
	 * Clear query data.
	 *
	 * @return AbstractCURLRequest Return the CURL request.
	 */
	final public function clearQueryData() {
		return $this->setQueryData();
	}

	/**
	 * Get the configuration.
	 *
	 * @return CURLConfiguration Returns the configuration.
	 */
	final public function getConfiguration() {
		return $this->configuration;
	}

	/**
	 * Get the headers.
	 *
	 * @return array Returns the headers.
	 */
	final public function getHeaders() {
		return $this->headers;
	}

	/**
	 * Get the method.
	 *
	 * @return string Returns the method.
	 */
	final public function getMethod() {
		return $this->method;
	}

	/**
	 * Get the POST data.
	 *
	 * @return array Returns the POST data.
	 */
	final public function getPostData() {
		return $this->postData;
	}

	/**
	 * Get the query data.
	 *
	 * @return array Returns the query data.
	 */
	final public function getQueryData() {
		return $this->queryData;
	}

	/**
	 * Get the resource path.
	 *
	 * @return string Return the resource path.
	 */
	final public function getResourcePath() {
		return $this->resourcePath;
	}

	/**
	 * Merge the headers.
	 *
	 * @return array Returns the meged headers.
	 */
	private function mergeHeaders() {

		// Initialize the merged headers.
		$mergedHeaders = [];

		// Handle each header.
		foreach (array_merge($this->getConfiguration()->getHeaders(), $this->getHeaders()) as $key => $value) {
			$mergedHeaders[] = implode(": ", [$key, $value]);
		}

		// Return the merged headers.
		return $mergedHeaders;
	}

	/**
	 * Merge the URL.
	 *
	 * @return string Returns the merged URL.
	 */
	private function mergeURL() {

		// Initialize the merged URL.
		$mergedURL	 = [];
		$mergedURL[] = $this->getConfiguration()->getHost();
		if (null !== $this->getResourcePath() && "" !== $this->getResourcePath()) {
			$mergedURL[] = $this->getResourcePath();
		}

		// Return the merged URL.
		return implode("/", $mergedURL);
	}

	/**
	 * Parse the raw header.
	 *
	 * @param string $rawHeader The raw header.
	 * @return array Returns the headers.
	 */
	private function parseHeader($rawHeader) {

		// Initialize the headers.
		$headers = [];
		$key	 = "";

		// Handle each header.
		foreach (explode("\n", $rawHeader) as $h) {
			$h = explode(":", $h, 2);
			if (isset($h[1])) {
				if (false === isset($headers[$h[0]])) {
					$headers[$h[0]] = trim($h[1]);
				} elseif (true === is_array($headers[$h[0]])) {
					$headers[$h[0]] = array_merge($headers[$h[0]], [trim($h[1])]);
				} else {
					$headers[$h[0]] = array_merge([$headers[$h[0]]], [trim($h[1])]);
				}
				$key = $h[0];
			} else {
				if ("\t" === substr($h[0], 0, 1)) {
					$headers[$key] .= "\r\n\t" . trim($h[0]);
				} elseif (!$key) {
					$headers[0] = trim($h[0]);
				}
				trim($h[0]);
			}
		}

		// Return the headers.
		return $headers;
	}

	/**
	 * Remove an header.
	 *
	 * @param string $name The header name.
	 */
	final public function removeHeader($name) {
		if (array_key_exists($name, $this->headers)) {
			unset($this->headers[$name]);
		}
	}

	/**
	 * Remove a POST data.
	 *
	 * @param string $name The POST data name.
	 */
	final public function removePostData($name) {
		if (array_key_exists($name, $this->postData)) {
			unset($this->postData[$name]);
		}
	}

	/**
	 * Remove a query data.
	 *
	 * @param string $name The query data name.
	 */
	final public function removeQueryData($name) {
		if (array_key_exists($name, $this->queryData)) {
			unset($this->queryData[$name]);
		}
	}

	/**
	 * Set the configuration.
	 *
	 * @param CURLConfiguration $configuration The configuration.
	 * @return AbstractCURLRequest Return the CURL request.
	 */
	final protected function setConfiguration(CURLConfiguration $configuration) {
		$this->configuration = $configuration;
		return $this;
	}

	/**
	 * Set the headers.
	 *
	 * @param array $headers The headers.
	 * @return AbstractCURLRequest Return the CURL request.
	 */
	final protected function setHeaders(array $headers = []) {
		$this->headers = $headers;
		return $this;
	}

	/**
	 * Set the method.
	 *
	 * @param string $method The method.
	 * @return AbstractCURLRequest Return the CURL request.
	 * @throws InvalidHTTPMethodException Throws an invalid HTTP method exception if the method is not implemented.
	 */
	final protected function setMethod($method) {
		switch ($method) {
			case self::METHOD_DELETE:
			case self::METHOD_GET:
			case self::METHOD_HEAD:
			case self::METHOD_OPTIONS:
			case self::METHOD_PATCH:
			case self::METHOD_POST:
			case self::METHOD_PUT:
				$this->method = $method;
				break;
			default:
				throw new InvalidHTTPMethodException($method);
		}
		return $this;
	}

	/**
	 * Set the POST data.
	 *
	 * @param array $postData The POST data.
	 * @return AbstractCURLRequest Return the CURL request.
	 */
	final protected function setPostData(array $postData = []) {
		$this->postData = $postData;
		return $this;
	}

	/**
	 * Set the query data.
	 *
	 * @param array $queryData The query data.
	 * @return AbstractCURLRequest Return the CURL request.
	 */
	final protected function setQueryData(array $queryData = []) {
		$this->queryData = $queryData;
		return $this;
	}

	/**
	 * Set the resource path.
	 *
	 * @param string $resourcePath The resource path.
	 * @return AbstractCURLRequest Return the CURL request.
	 */
	final public function setResourcePath($resourcePath) {
		$this->resourcePath = preg_replace("/^\//", "", trim($resourcePath));
		return $this;
	}

}
