DOCUMENTATION
=============

```php
// Create a POST request.
$request = CurlFactory::newCurlRequest(CurlRequestInterface::CURL_REQUEST_POST);;
$request->getConfiguration()->setHost("http://domain.tld");
$request->setRessourcePath("/resource-path");
$request->addQueryData("id", 1);
$request->addPostData("firstname", "John");
$request->addPostData("lastname", "DOE");
// ...

// Call the POST request.
$response = $request->call();

// Handle the response.
// ...
```
