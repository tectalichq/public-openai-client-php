# Tectalic OpenAI REST API Client

## Introduction

The **Tectalic OpenAI REST API Client** is a package that provides a convenient and straightforward way to interact with the **OpenAI API** from your PHP application.

More information is available from [https://tectalic.com/apis/openai](https://tectalic.com/apis/openai).

## Installation

Need help getting started? See our guide: [how to build an app using the OpenAI API](https://tectalic.com/blog/build-an-app-using-openai-api).

### System Requirements

- PHP version 7.2.5 or newer (including PHP 8.0 and 8.1)
- [PHP JSON extension](https://www.php.net/manual/en/json.installation.php) installed if using PHP 7.x. As of PHP 8.0, this extension became a core PHP extension so is always enabled.
- A [PSR-18](https://www.php-fig.org/psr/psr-18/) compatible HTTP client such as 'Guzzle' or the 'Symfony HTTP Client'.

### Composer Installation

Install the package into your project:

```shell
composer require tectalic/openai
```

## Usage

After installing the **Tectalic OpenAI REST API Client** package into your project, ensure you also have a [compatible PSR-18 HTTP client](https://packagist.org/providers/psr/http-client-implementation) such as 'Guzzle' or the Symfony 'HTTP Client'.

You can use the following code sample and customize it to suit your application.

```php
// Load your project's composer autoloader (if you aren't already doing so).
require_once(__DIR__ . '/vendor/autoload.php');
```

```php
use Symfony\Component\HttpClient\Psr18Client;
use Tectalic\OpenAi\Authentication;
use Tectalic\OpenAi\Client;
use Tectalic\OpenAi\Manager;

// Build a Tectalic OpenAI REST API Client globally.
$auth = new Authentication('token');
$httpClient = new Psr18Client();
Manager::build($httpClient, $auth);

// or

// Build a Tectalic OpenAI REST API Client manually.
$auth = new Authentication('token');
$httpClient = new Psr18Client();
$client = new Client($httpClient, $auth, Manager::BASE_URI);
```

### Authentication
To authenticate your API requests, you will need to provide an `Authentication` (`$auth`) object when calling `Manager::build()`.

Authentication to the **OpenAI API** is by HTTP Bearer authentication.

Please see the OpenAI API documentation for more details on obtaining your authentication credentials.

In the **Usage** code above, customize the `Authentication` constructor to your needs. For example, you may wish to define your credentials in an environment variable and pass it to the constructor.

### Client Class

The primary class you will interact with is the `Client` class (`Tectalic\OpenAi\Client`).

This `Client` class also contains the helper methods that let you quickly access the 10 API Handlers.

Please see below for a complete list of supported handlers and methods.

### Supported API Handlers and Methods

This package supports 17 API Methods, which are grouped into 10 API Handlers.

See the table below for a full list of API Handlers and Methods.


| API Handler Class and Method Name | Description | API Verb and URL |
| --------------------------------- | ----------- | ---------------- |
|`Completions::create()`|Creates a completion for the provided prompt and parameters|`POST` `/completions`|
|`Edits::create()`|Creates a new edit for the provided input, instruction, and parameters|`POST` `/edits`|
|`Embeddings::create()`|Creates an embedding vector representing the input text.|`POST` `/embeddings`|
|`Files::list()`|Returns a list of files that belong to the user's organization.|`GET` `/files`|
|`Files::create()`|Upload a file that contains document(s) to be used across various endpoints/features. Currently, the size of all the files uploaded by one organization can be up to 1 GB. Please contact us if you need to increase the storage limit.|`POST` `/files`|
|`Files::retrieve()`|Returns information about a specific file.|`GET` `/files/{file_id}`|
|`Files::delete()`|Delete a file.|`DELETE` `/files/{file_id}`|
|`FilesContent::download()`|Returns the contents of the specified file|`GET` `/files/{file_id}/content`|
|`FineTunes::list()`|List your organization's fine-tuning jobs|`GET` `/fine-tunes`|
|`FineTunes::create()`|Creates a job that fine-tunes a specified model from a given dataset.<br />Response includes details of the enqueued job including job status and the name of the fine-tuned models once complete.<br />Learn more about Fine-tuning|`POST` `/fine-tunes`|
|`FineTunes::retrieve()`|Gets info about the fine-tune job.<br />Learn more about Fine-tuning|`GET` `/fine-tunes/{fine_tune_id}`|
|`FineTunesCancel::cancelFineTune()`|Immediately cancel a fine-tune job.|`POST` `/fine-tunes/{fine_tune_id}/cancel`|
|`FineTunesEvents::listFineTune()`|Get fine-grained status updates for a fine-tune job.|`GET` `/fine-tunes/{fine_tune_id}/events`|
|`Models::list()`|Lists the currently available models, and provides basic information about each one such as the owner and availability.|`GET` `/models`|
|`Models::retrieve()`|Retrieves a model instance, providing basic information about the model such as the owner and permissioning.|`GET` `/models/{model}`|
|`Models::delete()`|Delete a fine-tuned model. You must have the Owner role in your organization.|`DELETE` `/models/{model}`|
|`Moderations::create()`|Classifies if text violates OpenAI's Content Policy|`POST` `/moderations`|

### Making a Request

There are two ways to make a request to the nominated API Handler and API Method:

If you built the client to be accessible globally, you can use the relevant API Handler Class directly:

```php
use Tectalic\OpenAi\Handlers\Completions;

(new Completions())->create();
```

Alternatively, you can access all API Handlers from the client class using the Client class:

```php
$client->completions()->create();
```

### Retrieving the Response

Once you have made a request using one of the two methods outlined above, the next step is to access the response.

You can access the response in different ways. Please choose your preferred one.

#### Model Responses

Model responses are Data Transfer Object (DTO) style PHP classes, with public properties for each API property.

They offer a structured way of retrieving the response from an API request.

All Response Models are an instance of `Tectalic\OpenAi\Models\AbstractModel` or `Tectalic\OpenAi\Models\AbstractModelCollection`.

After [performing the request](#making-a-request), use the `->toModel()` fluent method to the API Method:

```php
use Tectalic\OpenAi\Handlers\Completions;

$model = (new Completions())->create()->toModel();
```

Each API Method's `toModel()` call will return the appropriate Model class type for the API Method you have just called.

#### Associative Array Responses

After performing the request, use the `->toArray()` fluent method to the API Method:

```php
use Tectalic\OpenAi\Handlers\Completions;

$array = (new Completions())->create()->toArray();
```

In the resulting associative array, the array keys will match the names of the public properties in the relevant Model class.

#### PSR 7 Response Objects

If you need to access the raw response or inspect the HTTP headers, use the `->getResponse()` fluent method to the API Method. It will return a `Psr\Http\Message\ResponseInterface`:

```php
use Tectalic\OpenAi\Handlers\Completions;

$response = (new Completions())->create()->getResponse();
```

### Errors

When performing requests with **Tectalic OpenAI REST API Client**, specific scenarios will cause a `Tectalic\OpenAi\Exception\ClientException` to be thrown. Please see below for details.

#### Invalid Usage of the `Manager` Class

A `\LogicException` will be thrown if the `Manager::build()` function is called multiple times, or if `Manager::access()` is called before calling `Manager::build()`.

#### Unsuccessful HTTP Response Codes

The **Tectalic OpenAI REST API Client** depends on a PSR-18 compatible HTTP client, and that HTTP client should not throw an exception for [unsuccessful HTTP response codes](https://www.php-fig.org/psr/psr-18/#error-handling).

An unsuccessful response code is classified as one that is not in the range `200`-`299` (inclusive). Examples of unsuccessful response codes include:

- Informational responses (`100`-`199`)
- Redirection responses (`300`-`399`)
- Client error responses (`400`-`499`)
- Server error responses (`500`-`599`)

If an unsuccessful response code does occur:

- your HTTP Client will *not* throw an Exception.
- the API Handler's `toModel()` method will throw a `ClientException`.
- the API Handler's `toArray()` method will return the response body and not throw a `ClientException`.
- The API Handler's `getResponse()` method will return the raw response and not throw a `ClientException`.

Below is an example of how you may wish to use a `try`/`catch` block when performing a request so that you can detect and handle unexpected errors.

```php
use Tectalic\OpenAi\Authentication;
use Tectalic\OpenAi\Client;
use Tectalic\OpenAi\ClientException;
use Tectalic\OpenAi\Manager;

// Build a Tectalic OpenAI REST API Client globally.
$auth = new Authentication('token');
Manager::build($httpClient, $auth);
$handler = new Completions();

// Perform a request
try {
    $model = $handler->create()->toModel();
    // Do something with the response model...
} catch (ClientException $e) {
    // Error response received. Retrieve the HTTP response code and response body.
    $responseBody = $handler->toArray();
    $rawResponse  = $handler->getResponse()->getResponse();
    $responseCode = $handler->getResponse()->getStatusCode();
    // Handle the error...
}
```

#### HTTP Client Exceptions

If your HTTP client of choice throws an exception other than `ClientException`, the **Tectalic OpenAI REST API Client** `Client` and its API Handler classes will let these exceptions bubble up.

Consult your HTTP client's documentation for more details on exception handling.

## Tests

The **Tectalic OpenAI REST API Client** package includes several types of automated PHPUnit tests to verify the correct operation:

- Unit Tests
- Integration Tests

To run these tests, you will need to have installed the **Tectalic OpenAI REST API Client** package with its dev dependencies (i.e. not using the `--no-dev` flag when running composer).

### Unit Tests

These PHPUnit tests are designed to:

- confirm that each API Method assembles a valid request that matches the OpenAI API OpenAPI specification.
- verify the behaviour of other parts of the package, such as the `Client` and `Manager` classes.

The unit tests can be run using the following command, which needs to be run from this package's root directory.

```shell
composer test:unit
```

Unit tests do *not* perform any real requests against the OpenAI API.

Unit tests are located in the `tests/Unit` directory.

### Integration Tests

Integration tests are located in the `tests/Integration` directory.

These PHPUnit tests are designed to confirm that each API Method parses a valid response, according to the OpenAI API OpenAPI specification. Out of the box the integration tests are designed to work with the [Prism Mock Server](https://meta.stoplight.io/docs/prism/).

#### Using Prism as the Target

Make sure Prism is installed. Please see the [Prism documentation](https://meta.stoplight.io/docs/prism/) for details on how to install Prism.

Once Prism is installed, you can run prism and the integration tests side by side in separate terminal windows, or using the following command, which need to be run from this package's root directory.

```shell
echo "> Starting Prism server"
prism mock tests/openapi.yaml >/dev/null 2>&1 &
PRISM_PID=$!
sleep 2
echo "  => Started"
composer test:integration
kill $PRISM_PID
```

Those commands will start the Prism mock server, then run the integration tests, and then stop the Prism mock server when the tests are completed.

In this case the integration tests do *not* perform any real requests against the OpenAI API.

#### Using a Different Target

By setting the `OPENAI_CLIENT_TEST_BASE_URI` environment variable, you can set a different API endpoint target for the integration tests.

For example, instead of using Prism, you can use a different mocking/staging/test server of your choice, or you can use the OpenAI API's live endpoints.

Do not forget to set the appropriate credentials in the `OPENAI_CLIENT_TEST_AUTH_USERNAME` `OPENAI_CLIENT_TEST_AUTH_PASSWORD` environment variables.

After your setup is complete simply run the following command.

```shell
composer test:integration
```

We do not recommend running integration tests against the live OpenAI API endpoints. This is because the tests will send example data to all endpoints, which can result in new data being created, or existing data being deleted.

## Support

If you have any questions or feedback, please use the [discussion board](https://github.com/tectalichq/public-openai-client-php/discussions).

## License

This software is copyright (c) 2022 [Tectalic](https://tectalic.com).

For copyright and license information, please view the [LICENSE](LICENSE) file.
