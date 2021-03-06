curl-library
============

[![Build Status](https://travis-ci.org/webeweb/curl-library.svg?branch=master)](https://travis-ci.org/webeweb/curl-library) [![Coverage Status](https://coveralls.io/repos/github/webeweb/curl-library/badge.svg?branch=master)](https://coveralls.io/github/webeweb/curl-library?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/webeweb/curl-library/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/webeweb/curl-library/?branch=master) [![Latest Stable Version](https://poser.pugx.org/webeweb/curl-library/v/stable)](https://packagist.org/packages/webeweb/curl-library) [![Latest Unstable Version](https://poser.pugx.org/webeweb/curl-library/v/unstable)](https://packagist.org/packages/webeweb/curl-library) [![License](https://poser.pugx.org/webeweb/curl-library/license)](https://packagist.org/packages/webeweb/curl-library) [![composer.lock](https://poser.pugx.org/webeweb/curl-library/composerlock)](https://packagist.org/packages/webeweb/curl-library)

Integrate web API with your projects.

> IMPORTANT NOTICE: This package is no longer maintained and its classes have
> been migrated into package "core-library" (available into version up to 4.3.0
> and more) [Core library](https://github.com/webeweb/core-library/)

---

## Compatibility

[![PHP](https://img.shields.io/badge/PHP-%5E5.6%7C%5E7.0-blue.svg)](http://php.net) [![HHVM](https://img.shields.io/badge/HHVM-ready-orange.svg)](https://hhvm.com/)

Requires:

[![ext-curl](https://img.shields.io/badge/PHP-ext--curl-blue.svg)](http://php.net/manual/en/book.curl.php)

---

## Installation

Open a command console, enter your project directory and execute the following
command to download the latest stable version of this package:

```bash
$ composer require webeweb/curl-library "^1.0"
```

This command requires you to have Composer installed globally, as explained in
the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the
Composer documentation.

---

## Usage

```php
     // Initialize the POST request.
     $request = new CURLPostRequest(new CURLConfiguration(), "/resource-path");
     $request->getConfiguration()->setHost("http://domain.tld");
     $request->addQueryData("id", 1);
     $request->addPostData("firstname", "John");
     $request->addPostData("lastname", "DOE");
     // ...

     // Call the POST request.
     $response = $request->call();

     // Make something with the response.
     // ...
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
class MyCustomRequest extends AbstractCURLRequest {

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

To test the package, is better to clone this repository on your computer.
Open a command console and execute the following commands to download the latest
stable version of this package:

```bash
$ mkdir curl-library
$ cd curl-library
$ git clone git@github.com:webeweb/curl-library.git .
$ composer install
```

Once all required libraries are installed then do:

```bash
$ vendor/bin/phpunit
```

---

## License

`curl-library` is released under the LGPL License. See the bundled [LICENSE](LICENSE)
file for details.
