WBWCURLLibrary
====================

[![Build Status](https://travis-ci.org/webeweb/WBWCURLLibrary.svg?branch=master)](https://travis-ci.org/webeweb/WBWCURLLibrary) [![Coverage Status](https://coveralls.io/repos/github/webeweb/WBWCURLLibrary/badge.svg?branch=master)](https://coveralls.io/github/webeweb/WBWCURLLibrary?branch=master) [![Latest Stable Version](https://poser.pugx.org/webeweb/curl-library/v/stable)](https://packagist.org/packages/webeweb/curl-library) [![Latest Unstable Version](https://poser.pugx.org/webeweb/curl-library/v/unstable)](https://packagist.org/packages/webeweb/curl-library) [![License](https://poser.pugx.org/webeweb/curl-library/license)](https://packagist.org/packages/webeweb/curl-library) [![composer.lock](https://poser.pugx.org/webeweb/curl-library/composerlock)](https://packagist.org/packages/webeweb/curl-library) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/1e7bc269-53c0-40ec-a905-4eb061afaab1/mini.png)](https://insight.sensiolabs.com/projects/1e7bc269-53c0-40ec-a905-4eb061afaab1)

cURL library

---

## Installation

Edit `composer.json` file to add this library package:

```yml
"require": {
    ...
    "webeweb/curl-library": "~1.0@dev"
},
```

Run `php composer.phar update webeweb/curl-library`

---

## Usage

```php

	// Initialize the POST request.
	$request = new CURLPostRequest(new CURLConfiguration(), "/resource-path");
	$request->getConfiguration()->setHost("http://domain.tld");
	$request->addQueryData("id", 1);
	$request->addPostData("firstname", "John");
	$request->addPostData("lastname", "DOE");
	...

	// Call the POST request.
	$response = $request->call();

	// Make something with the response.
	...

```

Requests available :

- CURLDeleteRequest
- CURLGetRequest
- CURLHeadRequest
- CURLOptionsRequest
- CURLPatchRequest
- CURLPostRequest
- CURLPutRequest

---

## Customize

```php

class MyCustomRequest extends  extends AbstractCURLRequest {

	/**
	 * Constructor.
	 *
	 * @param CURLConfiguration $configuration The configuration.
	 * @param string $resourcePath The resource path.
	 * @throws InvalidHTTPMethodException Throws an invalid HTTP method exception if the method is not implemented.
	 */
	public function __construct(CURLConfiguration $configuration, $resourcePath) {
		parent::__construct(self::METHOD_GET, $configuration, $resourcePath); //
	}

	...

}

```

---

## Testing

To test the package, is better to clone this repository on your computer. After, go to the package folder and do
the following (assuming you have `composer` installed on your computer):

```bash
$ composer install --no-interaction --prefer-source --dev
```
Once all required libraries are installed then do:

```bash
$ vendor/bin/phpunit
```

---

## License

WBWCURLLibrary is released under the LGPL License. See the bundled [LICENSE](LICENSE) file for details.
