# OpenAI REST API Client

## Introduction

The **OpenAI REST API Client** is a package that provides a simple and convenient way to interact with the **OpenAI API** from your PHP application.

This package can be purchased from [https://tectalic.com/apis/openai](https://tectalic.com/apis/openai).

## License

This software is copyright (c) [Tectalic](https://tectalic.com).

For the full copyright and license information, please view the *LICENSE* file that was distributed with the source code.

## System Requirements

- PHP version 7.2.5 or newer.
- [PHP JSON extension](https://www.php.net/manual/en/json.installation.php) installed.
- A PSR-18 compatible HTTP client such as Guzzle or the Symfony HttpClient.

## Installation

To install this package into your PHP project, we recommend using [Composer](http://getcomposer.org/).

Please [see here for detailed instructions on how to configure your project to access the Tectalic Composer repository](https://tectalic.com/products/openai#composer-integration). You will need to log into the Tectalic account that purchased the **OpenAI REST API Client** package in order to access these instructions.

Once you have authenticated composer using the above instructions, run the following command:

`composer require tectalic/openai ^TODO`

Then run the following command to install the *OpenAI REST API Client* into your project:

`composer install`

Ensure you have also installed into your project a [compatible PSR-18 HTTP Client](https://packagist.org/providers/psr/http-client-implementation) such as Guzzle or the Symfony HttpClient.

### Manual Installation

TODO: Finalise instructions for manual installation. How does it work as the downloaded zip file does not include the product's dependencies?

[Download the latest release from here](https://tectalic.com/products/openai) and extract it into your PHP project.

Then include the OpenAI REST API Client `autoload.php` file:

```php
require_once('/path/to/your-project/openai/autoload.php');
```

## Getting Started

After installing the package into your project, you can use the following code sample and customize it to suit your application.

```php
// Load your project's composer autoloader (if you aren't already doing so).
require_once(__DIR__ . '/vendor/autoload.php');
```

```php
use Tectalic\OpenAI\Authentication;
use Tectalic\OpenAI\Client;
use Tectalic\OpenAI\Manager;

// Fluent interface
$auth = new Authentication(TODO: auth params);
$client = Manager::build($httpClient, $auth);
// TODO: method parameters, use only a get() method?
$client->answers()->create()->toModel();
```

## Authentication
To authenticate your API requests, you will need to provide an `Authentication` (`$auth`) object when calling `Manager::build()`.

Authentication to the **OpenAI API** is by TODO auth type.

In the **Getting Started** code above, customize the `Authentication` constructor to your needs. For example, you may wish to define your API key in an environment variable, and pass it to the constructor.

## Client Class

The primary class that you will interact with is the `Client` class (`Tectalic\OpenAI\Client`).

This `Client` class also contains the helper methods that lets you easily access the 6 handler(s).

Please see below for a full list of supported handlers and methods.

## Supported Handlers and Methods

This package supports 6 handlers(s) and a total of 10 method(s). See the following table for details.

 TODO: add parameter(s) to Method Name column

| Handler Class Name | Handler URL | HTTP Verb | Method Name | Description | PHP Code |
| ------------------- | ------------ | --------- | ----------- | ----------- | -------- |
|`Tectalic\OpenAI\Handler\Answers`|`/answers`|`post`|`create()`|Create answer<br /><br />Answers the specified question using the provided documents and examples.<br /><br />The endpoint first [searches](https://beta.openai.com/docs/api-reference/searches) over provided documents or files to find relevant context.<br />The relevant context is combined with the provided examples and question to create the prompt for [completion](https://beta.openai.com/docs/api-reference/completions).<br /><br />[See More](https://beta.openai.com/docs/api-reference/classifications/create)|`$client->answers()->create()->toModel()`|
|`Tectalic\OpenAI\Handler\Classifications`|`/classifications`|`post`|`create()`|Create classification<br /><br />Classifies the specified query using provided examples.<br /><br />The endpoint first [searches](https://beta.openai.com/docs/api-reference/searches) over the labeled examples to select the ones most relevant for the particular query.<br />Then, the relevant examples are combined with the query to construct a prompt to produce the final label via the [completions](https://beta.openai.com/docs/api-reference/completions) endpoint.<br /><br />Labeled examples can be provided via an uploaded file, or explicitly listed in the request using the examples parameter for quick tests and small scale use cases.<br /><br />[See More](https://beta.openai.com/docs/api-reference/classifications/create)|`$client->classifications()->create()->toModel()`|
|`Tectalic\OpenAI\Handler\Engines`|`/engines`|`get`|`list()`|List engines<br /><br />Lists the currently available engines, and provides basic information about each one such as the owner and availability.<br /><br />[See More](https://beta.openai.com/docs/api-reference/engines/list)|`$client->engines()->list()->toModel()`|
|`Tectalic\OpenAI\Handler\Engines`|`/engines/{engineId}`|`get`|`get()`|Retrieve engine<br /><br />Retrieves an engine instance, providing basic information about the engine such as the owner and availability.<br /><br />[See More](https://beta.openai.com/docs/api-reference/engines/retrieve)|`$client->engines()->get()->toModel()`|
|`Tectalic\OpenAI\Handler\EnginesCompletions`|`/engines/{engineId}/completions`|`post`|`create()`|Create completion<br /><br />Creates a new completion for the provided prompt and parameters.<br /><br />[See More](https://beta.openai.com/docs/api-reference/completions/create)|`$client->enginesCompletions()->create()->toModel()`|
|`Tectalic\OpenAI\Handler\EnginesSearch`|`/engines/{engineId}/search`|`post`|`esCreate()`|Create search<br /><br />The search endpoint computes similarity scores between provided query and documents.<br />Documents can be passed directly to the API if there are no more than 200 of them.<br /><br />To go beyond the 200 document limit, documents can be processed offline and then used for efficient retrieval at query time.<br />When `file` is set, the search endpoint searches over all the documents in the given file and returns up to the `max_rerank` number of documents.<br />These documents will be returned along with their search scores.<br /><br />The similarity score is a positive score that usually ranges from 0 to 300 (but can sometimes go higher), where a score above 200 usually means the document is semantically similar to the query.<br /><br />[See More](https://beta.openai.com/docs/api-reference/searches/create)|`$client->enginesSearch()->esCreate()->toModel()`|
|`Tectalic\OpenAI\Handler\Files`|`/files`|`get`|`list()`|List files<br /><br />Returns a list of files that belong to the user's organization.<br /><br />[See More](https://beta.openai.com/docs/api-reference/files/list)|`$client->files()->list()->toModel()`|
|`Tectalic\OpenAI\Handler\Files`|`/files`|`post`|`upload()`|Upload file<br /><br />Upload a file that contains document(s) to be used across various endpoints/features.<br />Currently, the size of all the files uploaded by one organization can be up to 1 GB.<br />Please contact us if you need to increase the storage limit.<br /><br />[See More](https://beta.openai.com/docs/api-reference/files/upload)|`$client->files()->upload()->toModel()`|
|`Tectalic\OpenAI\Handler\Files`|`/files/{fileId}`|`get`|`get()`|Retrieve file<br /><br />Returns information about a specific file.<br /><br />[See More](https://beta.openai.com/docs/api-reference/files/retrieve)|`$client->files()->get()->toModel()`|
|`Tectalic\OpenAI\Handler\Files`|`/files/{fileId}`|`delete`|`remove()`|Delete file<br /><br />Delete a file.<br /><br />[See More](https://beta.openai.com/docs/api-reference/files/delete)|`$client->files()->remove()->toModel()`|


## Models (if DTO enabled)
TODO: Add models if they are part of MVP
```
Tectalic\OpenAI\Model\User (primary for the `get()` method)
Tectalic\OpenAI\Model\UserList (Collection, ArrayAccess)
Tectalic\OpenAI\Model\UserCreate (if different from User)
Tectalic\OpenAI\Model\UserUpdate (if different from User)
Tectalic\OpenAI\Model\UserDelete (if different from User)
Tectalic\OpenAI\Model\UserTrace (only if exotic HTTP method defined and different from User)
```

## Errors

When using **OpenAI REST API Client**, certain types of errors will cause an `Tectalic\OpenAI\Exception\ClientException` to be thrown. For example, if the request cannot be encoded into valid JSON.

Your HTTP client of choice may also throw various exceptions, such as `GuzzleHttp\Exception\ClientException`. Consult your HTTP client's documentation for more details.
