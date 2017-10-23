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

use DateTime;
use WBW\Library\Core\Argument\ArgumentValidator;
use WBW\Library\Core\Exception\Argument\StringArgumentException;
use WBW\Library\Core\HTTP\HTTPMethodInterface;
use WBW\Library\CURL\Configuration\CURLConfiguration;
use WBW\Library\CURL\Exception\CURLMethodNotAllowedException;
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
    public final function addHeader($name, $value) {
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
    public final function addPostData($name, $value) {
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
    public final function addQueryData($name, $value) {
        ArgumentValidator::isValid($name, ArgumentValidator::TYPE_STRING);
        $this->queryData[$name] = $value;
    }

    /**
     * Call the request.
     *
     * @return CURLResponse Returns the response.
     * @throws CURLRequestCallException Throws a CURL request call if something failed.
     */
    public final function call() {

        // Define the necessary argurments.
        $curlHeaders  = [];
        $curlPOSTData = http_build_query($this->getPostData());

        // Merge the headers.
        $mergedHeaders = array_merge($this->getConfiguration()->getHeaders(), $this->getHeaders());

        // Handle each merge header.
        foreach ($mergedHeaders as $key => $value) {
            $curlHeaders[] = implode(": ", [$key, $value]);
        }

        // Initialize the URL.
        $curlURL = implode("/", [$this->getConfiguration()->getHost(), $this->getResourcePath()]);
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
        if ($this->getConfiguration()->getAllowEncoding() === true) {
            curl_setopt($curl, CURLOPT_ENCODING, "");
        }

        // Set the HTTP headers.
        curl_setopt($curl, CURLOPT_HTTPHEADER, $curlHeaders);

        // Set the post.
        switch ($this->getMethod()) {

            case self::METHOD_DELETE:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->getMethod());
                curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPOSTData);
                break;

            case self::METHOD_GET:
                // NOTHING TO DO.
                break;

            case self::METHOD_HEAD:
                curl_setopt($curl, CURLOPT_NOBODY, true);
                break;

            case self::METHOD_OPTIONS:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->getMethod());
                curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPOSTData);
                break;

            case self::METHOD_PATCH:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->getMethod());
                curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPOSTData);
                break;

            case self::METHOD_POST:
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPOSTData);
                break;

            case self::METHOD_PUT:
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->getMethod());
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
        if ($this->getConfiguration()->getSslVerification() === false) {
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
        if ($this->getConfiguration()->getDebug() === true) {
            curl_setopt($curl, CURLOPT_STDERR, fopen($this->getConfiguration()->getDebugFile(), "a"));
            curl_setopt($curl, CURLOPT_VERBOSE, 0);

            $msg = (new DateTime())->format("c") . " [DEBUG] " . $curlURL . PHP_EOL . "HTTP request body ~BEGIN~" . PHP_EOL . print_r($curlPOSTData, true) . PHP_EOL . "~END~" . PHP_EOL;
            error_log($msg, 3, $this->getConfiguration()->getDebugFile());
        } else if ($this->getConfiguration()->getVerbose() === true) {
            curl_setopt($curl, CURLOPT_VERBOSE, 1);
        } else {
            curl_setopt($curl, CURLOPT_VERBOSE, 0);
        }

        // Make the request.
        $curlExec     = curl_exec($curl);
        $httpHeadSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $httpHead     = $this->parseheader(substr($curlExec, 0, $httpHeadSize));
        $httpBody     = substr($curlExec, $httpHeadSize);
        $curlInfo     = curl_getinfo($curl);

        //
        if ($this->getConfiguration()->getDebug() === true) {
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
        if ($curlInfo["http_code"] === 0) {
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
     * Get the configuration.
     *
     * @return CURLConfiguration Returns the configuration.
     */
    public final function getConfiguration() {
        return $this->configuration;
    }

    /**
     * Get the headers.
     *
     * @return array Returns the headers.
     */
    public final function getHeaders() {
        return $this->headers;
    }

    /**
     * Get the method.
     *
     * @return string Returns the method.
     */
    public final function getMethod() {
        return $this->method;
    }

    /**
     * Get the POST data.
     *
     * @return array Returns the POST data.
     */
    public final function getPostData() {
        return $this->postData;
    }

    /**
     * Get the query data.
     *
     * @return array Returns the query data.
     */
    public final function getQueryData() {
        return $this->queryData;
    }

    /**
     * Get the resource path.
     *
     * @return string Return the resource path.
     */
    public final function getResourcePath() {
        return $this->resourcePath;
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
        $key     = "";

        // Handle each header.
        foreach (explode("\n", $rawHeader) as $h) {
            $h = explode(":", $h, 2);
            if (isset($h[1])) {
                if (!isset($headers[$h[0]])) {
                    $headers[$h[0]] = trim($h[1]);
                } elseif (is_array($headers[$h[0]])) {
                    $headers[$h[0]] = array_merge($headers[$h[0]], [trim($h[1])]);
                } else {
                    $headers[$h[0]] = array_merge([$headers[$h[0]]], [trim($h[1])]);
                }
                $key = $h[0];
            } else {
                if (substr($h[0], 0, 1) === "\t") {
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
    public final function removeHeader($name) {
        if (array_key_exists($name, $this->headers)) {
            unset($this->headers[$name]);
        }
    }

    /**
     * Remove a POST data.
     *
     * @param string $name The POST data name.
     */
    public final function removePostData($name) {
        if (array_key_exists($name, $this->postData)) {
            unset($this->postData[$name]);
        }
    }

    /**
     * Remove a query data.
     *
     * @param string $name The query data name.
     */
    public final function removeQueryData($name) {
        if (array_key_exists($name, $this->queryData)) {
            unset($this->queryData[$name]);
        }
    }

    /**
     * Set the configuration.
     *
     * @param CURLConfiguration $configuration The configuration.
     */
    protected final function setConfiguration(CURLConfiguration $configuration) {
        $this->configuration = $configuration;
    }

    /**
     * Set the headers.
     *
     * @param array $headers The headers.
     */
    protected final function setHeaders(array $headers = []) {
        $this->headers = $headers;
    }

    /**
     * Set the method.
     *
     * @param string $method The method.
     * @throws CURLMethodNotAllowedException Throws a CURL method not allowed exception if the method is not implemented.
     */
    protected final function setMethod($method) {
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
                throw new CURLMethodNotAllowedException($method);
        }
    }

    /**
     * Set the POST data.
     *
     * @param array $postData The POST data.
     */
    protected final function setPostData(array $postData = []) {
        $this->postData = $postData;
    }

    /**
     * Set the query data.
     *
     * @param array $queryData The query data.
     */
    protected final function setQueryData(array $queryData = []) {
        $this->queryData = $queryData;
    }

    /**
     * Set the resource path.
     *
     * @param string $resourcePath The resource path.
     */
    protected final function setResourcePath($resourcePath) {
        $this->resourcePath = $resourcePath;
    }

}
