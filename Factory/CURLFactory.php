<?php

/**
 * This file is part of the curl-library package.
 *
 * (c) 2017 WEBEWEB
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Factory;

use WBW\Library\Core\Exception\IO\InvalidHTTPMethodException;
use WBW\Library\Core\IO\HTTPInterface;
use WBW\Library\CURL\Configuration\CURLConfiguration;
use WBW\Library\CURL\Request\CURLDeleteRequest;
use WBW\Library\CURL\Request\CURLGetRequest;
use WBW\Library\CURL\Request\CURLHeadRequest;
use WBW\Library\CURL\Request\CURLOptionsRequest;
use WBW\Library\CURL\Request\CURLPatchRequest;
use WBW\Library\CURL\Request\CURLPostRequest;
use WBW\Library\CURL\Request\CURLPutRequest;
use WBW\Library\CURL\Request\CURLRequestInterface;

/**
 * cURL factory.
 *
 * @author webeweb <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Factory
 */
class CURLFactory implements HTTPInterface {

    /**
     * Constructor.
     */
    private function __construct() {
        // NOTHING TO DO.
    }

    /**
     * Get an instance.
     *
     * @param string $method The method.
     * @param CURLConfiguration $configuration The configuration.
     * @return CURLRequestInterface Returns this cURL request.
     * @throws InvalidHTTPMethodException Throws an invalid HTTP method exception if the method is not implemented.
     */
    public static function getInstance($method, CURLConfiguration $configuration = null, $resourcePath = null) {

        // Check the configuration.
        if (null === $configuration) {
            $configuration = new CURLConfiguration();
        }

        // Switch into $method.
        switch ($method) {

            case self::HTTP_METHOD_DELETE:
                return new CURLDeleteRequest($configuration, $resourcePath);

            case self::HTTP_METHOD_GET:
                return new CURLGetRequest($configuration, $resourcePath);

            case self::HTTP_METHOD_HEAD:
                return new CURLHeadRequest($configuration, $resourcePath);

            case self::HTTP_METHOD_OPTIONS:
                return new CURLOptionsRequest($configuration, $resourcePath);

            case self::HTTP_METHOD_PATCH:
                return new CURLPatchRequest($configuration, $resourcePath);

            case self::HTTP_METHOD_POST:
                return new CURLPostRequest($configuration, $resourcePath);

            case self::HTTP_METHOD_PUT:
                return new CURLPutRequest($configuration, $resourcePath);

            default:
                throw new InvalidHTTPMethodException($method);
        }
    }

}
