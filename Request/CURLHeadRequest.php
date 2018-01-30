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

use WBW\Library\CURL\Configuration\CURLConfiguration;

/**
 * cURL HEAD request.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Request
 * @final
 */
final class CURLHeadRequest extends AbstractCURLRequest {

    /**
     * Constructor.
     *
     * @param CURLConfiguration $configuration The configuration.
     * @param string $resourcePath The resource path.
     */
    public function __construct(CURLConfiguration $configuration, $resourcePath) {
        parent::__construct(self::METHOD_HEAD, $configuration, $resourcePath);
    }

}
