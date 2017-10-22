<?php

/*
 * This file is part of the SDKBundle.
 *
 * © 2017 SDKBundle
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Configuration;

use WBW\Library\CURL\Exception\CURLInvalidArgumentException;

/**
 * CURL configuration.
 *
 *
 * @package SDKBundle\Web\API\CURL\Configuration
 */
final class CURLConfiguration {

    /**
     * Allow encoding.
     *
     * @var boolean
     */
    private $allowEncoding = false;

    /**
     * HTTP connect timeout.
     *
     * @var integer
     */
    private $connectTimeout = 0;

    /**
     * Debug.
     *
     * @var boolean
     */
    private $debug = false;

    /**
     * Debug file.
     *
     * @var string
     */
    private $debugFile = "php://output";

    /**
     * Headers.
     *
     * @var array
     */
    private $headers = [];

    /**
     * Host.
     *
     * @var string
     */
    private $host;

    /**
     * HTTP basic password.
     *
     * @var string
     */
    private $httpPassword;

    /**
     * HTTP basic username.
     *
     * @var string
     */
    private $httpUsername;

    /**
     * Proxy host.
     *
     * @var string
     */
    private $proxyHost;

    /**
     * Proxy password.
     *
     * @var string
     */
    private $proxyPassword;

    /**
     * Proxy port.
     *
     * @var integer
     */
    private $proxyPort;

    /**
     * Proxy type.
     *
     * @var integer
     */
    private $proxyType;

    /**
     * Proxy username.
     *
     * @var string
     */
    private $proxyUsername;

    /**
     * HTTP request timeout.
     *
     * @var integer
     */
    private $requestTimeout = 0;

    /**
     * SSL verification.
     *
     * @var boolean
     */
    private $sslVerification = true;

    /**
     * User agent.
     *
     * @var string
     */
    private $userAgent = "SDKBundle/API/CURL/1.0.0";

    /**
     * Constructor.
     */
    public function __construct() {
        // NOTHING TO DO.
    }

    /**
     * Add an header.
     *
     * @param string $name The header name.
     * @param string $value The header value.
     * @throws CURLInvalidArgumentException Throws a CURL invalid argument exception if the argument is not a string.
     */
    public function addHeader($name, $value) {
        if (!is_string($name)) {
            throw new CURLInvalidArgumentException("The header name must be a string");
        }
        $this->headers[$name] = $value;
    }

    /**
     * Get the allow encoding.
     *
     * @return boolean Returns the allow encoding.
     */
    public function getAllowEncoding() {
        return $this->allowEncoding;
    }

    /**
     * Get the connect timeout.
     *
     * @return integer Returns the connect timeout.
     */
    public function getConnectTimeout() {
        return $this->connectTimeout;
    }

    /**
     * Ge the debug.
     *
     * @return boolen Returns the debug.
     */
    public function getDebug() {
        return $this->debug;
    }

    /**
     * Get the debug file.
     *
     * @return string Returns the debug file.
     */
    public function getDebugFile() {
        return $this->debugFile;
    }

    /**
     * Get the headers.
     *
     * @return array Returns the headers.
     */
    public function getHeaders() {
        return $this->headers;
    }

    /**
     * Get the host.
     *
     * @return string Returns the host.
     */
    public function getHost() {
        return $this->host;
    }

    /**
     * Get the HTTP password.
     *
     * @return string Returns the HTTP password.
     */
    public function getHttpPassword() {
        return $this->httpPassword;
    }

    /**
     * Get the HTTP username.
     *
     * @return string Returns the HTTP username.
     */
    public function getHttpUsername() {
        return $this->httpUsername;
    }

    /**
     * Get the proxy host.
     *
     * @return string Returns the proxy host.
     */
    public function getProxyHost() {
        return $this->proxyHost;
    }

    /**
     * Get the proxy password.
     *
     * @return string Returns the proxy password.
     */
    public function getProxyPassword() {
        return $this->proxyPassword;
    }

    /**
     * Get the proxy port.
     *
     * @return integer Returns the proxy port.
     */
    public function getProxyPort() {
        return $this->proxyPort;
    }

    /**
     * Get the proxy type.
     *
     * @return integer Returns the proxy type.
     */
    public function getProxyType() {
        return $this->proxyType;
    }

    /**
     * Get the proxy username.
     *
     * @return string Returns the proxy username.
     */
    public function getProxyUsername() {
        return $this->proxyUsername;
    }

    /**
     * Get the request timeout.
     *
     * @return integer Returns the request timeout.
     */
    public function getRequestTimeout() {
        return $this->requestTimeout;
    }

    /**
     * Get the SSL verification.
     *
     * @return boolean Returns the SSL verification.
     */
    public function getSslVerification() {
        return $this->sslVerification;
    }

    /**
     * Get the user agent.
     *
     * @return string Returns the user agent.
     */
    public function getUserAgent() {
        return $this->userAgent;
    }

    /**
     * Remove an header.
     *
     * @param string $name The header name.
     */
    public function removeHeader($name) {
        if (array_key_exists($name, $this->headers)) {
            unset($this->headers[$name]);
        }
    }

    /**
     * Set the allow encoding.
     *
     * @param boolean $allowEncoding The allow encoding.
     */
    public function setAllowEncoding($allowEncoding = false) {
        $this->allowEncoding = $allowEncoding;
    }

    /**
     * Set the connect timeout.
     *
     * @param integer $connectTimeout The connect timeout.
     */
    public function setConnectTimeout($connectTimeout = 0) {
        $this->connectTimeout = $connectTimeout;
    }

    /**
     * Set the debug.
     *
     * @param boolean $debug The debug.
     */
    public function setDebug($debug) {
        $this->debug = $debug;
    }

    /**
     * Set the debug file.
     *
     * @param string $debugFile The debug file.
     */
    public function setDebugFile($debugFile) {
        $this->debugFile = $debugFile;
    }

    /**
     * Set the headers.
     *
     * @param array $headers The headers
     */
    protected function setHeaders(array $headers = []) {
        $this->headers = $headers;
    }

    /**
     * Set the host.
     *
     * @param string $host The host.
     */
    public function setHost($host) {
        $this->host = $host;
    }

    /**
     * Set the HTTP basic password.
     *
     * @param string $httpPassword The HTTP basic password.
     */
    public function setHttpPassword($httpPassword) {
        $this->httpPassword = $httpPassword;
    }

    /**
     * Set the HTTP basic username.
     *
     * @param string $httpUsername The HTTP basic username.
     */
    public function setHttpUsername($httpUsername) {
        $this->httpUsername = $httpUsername;
    }

    /**
     * Set the proxy host.
     *
     * @param string $proxyHost The proxy host.
     */
    public function setProxyHost($proxyHost) {
        $this->proxyHost = $proxyHost;
    }

    /**
     * Set the proxy password.
     *
     * @param string $proxyPassword The proxy password.
     */
    public function setProxyPassword($proxyPassword) {
        $this->proxyPassword = $proxyPassword;
    }

    /**
     * Set the proxy port.
     *
     * @param integer $proxyPort The proxy port.
     */
    public function setProxyPort($proxyPort) {
        $this->proxyPort = $proxyPort;
    }

    /**
     * Set the proxy type.
     *
     * @param integer $proxyType The proxy type.
     */
    public function setProxyType($proxyType) {
        $this->proxyType = $proxyType;
    }

    /**
     * Set the proxy username.
     *
     * @param string $proxyUsername The proxy username.
     */
    public function setProxyUsername($proxyUsername) {
        $this->proxyUsername = $proxyUsername;
    }

    /**
     * Set the request timeout.
     *
     * @param integer $requestTimeout The request timeout.
     */
    public function setRequestTimeout($requestTimeout = 0) {
        $this->requestTimeout = $requestTimeout;
    }

    /**
     * Set the SSL verification.
     *
     * @param boolean $sslVerification The SSL verrification.
     */
    public function setSslVerification($sslVerification = true) {
        $this->sslVerification = $sslVerification;
    }

    /**
     * Set the user agent.
     *
     * @param string $userAgent The user agent.
     */
    public function setUserAgent($userAgent) {
        $this->userAgent = $userAgent;
    }

}
