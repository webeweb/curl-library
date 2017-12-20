<?php

/**
 * This file is part of the curl-library package.
 *
 * (c) 2017 NdC/WBW
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WBW\Library\CURL\Tests\Request;

use PHPUnit_Framework_TestCase;
use WBW\Library\CURL\Configuration\CURLConfiguration;

/**
 * Abstract CURL request test.
 *
 * @author NdC/WBW <https://github.com/webeweb/>
 * @package WBW\Library\CURL\Tests\Request
 * @abstract
 */
abstract class AbstractCURLRequestTest extends PHPUnit_Framework_TestCase {

	/**
	 * Resource path.
	 */
	const RESOURCE_PATH = "/testCall.php";

	/**
	 * CURL configuration.
	 *
	 * @var CURLConfiguration
	 */
	protected $configuration;

	/**
	 * {@inheritdoc}
	 */
	protected function setUp() {

		//
		parent::setUp();

		// Set the CURL configuration.
		$this->configuration = new CURLConfiguration();
		$this->configuration->setHost("https://webeweb.fr/");
	}

}
