<?php

/**
 * Copyright (c) 2022 Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tectalic\OpenAi;

use Http\Message\MultipartStream\MultipartStreamBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Tectalic\OpenAi\Handlers\Answers;
use Tectalic\OpenAi\Handlers\Classifications;
use Tectalic\OpenAi\Handlers\Completions;
use Tectalic\OpenAi\Handlers\Edits;
use Tectalic\OpenAi\Handlers\Embeddings;
use Tectalic\OpenAi\Handlers\Engines;
use Tectalic\OpenAi\Handlers\EnginesSearch;
use Tectalic\OpenAi\Handlers\Files;
use Tectalic\OpenAi\Handlers\FilesContent;
use Tectalic\OpenAi\Handlers\FineTunes;
use Tectalic\OpenAi\Handlers\FineTunesCancel;
use Tectalic\OpenAi\Handlers\FineTunesEvents;
use Tectalic\OpenAi\Handlers\Models;
use Tectalic\OpenAi\Models\AbstractModel;
use Tectalic\OpenAi\Models\AbstractModelCollection;
use Throwable;

/**
 * Holds and interacts with the Http Client.
 */
final class Client implements ClientInterface
{
    /** @var Authentication */
    private $auth;

    /** @var string */
    private $baseUri;

    /** @var ClientInterface */
    private $httpClient;

    /** @var Psr17Factory */
    private $psr17Factory;

    /**
     * List of open file pointers.
     * @var resource[]
     */
    private $fileHandles = [];

    public function __construct(ClientInterface $httpClient, Authentication $auth, string $baseUri)
    {
        $this->auth = $auth;
        $this->baseUri = $baseUri;
        $this->httpClient = $httpClient;
        $this->psr17Factory = new Psr17Factory();
    }

    /**
     * Access to the engines handler.
     *
     * @api
     * @return Engines
     */
    public function engines(): Engines
    {
        return new \Tectalic\OpenAi\Handlers\Engines($this);
    }

    /**
     * Access to the completions handler.
     *
     * @api
     * @return Completions
     */
    public function completions(): Completions
    {
        return new \Tectalic\OpenAi\Handlers\Completions($this);
    }

    /**
     * Access to the edits handler.
     *
     * @api
     * @return Edits
     */
    public function edits(): Edits
    {
        return new \Tectalic\OpenAi\Handlers\Edits($this);
    }

    /**
     * Access to the embeddings handler.
     *
     * @api
     * @return Embeddings
     */
    public function embeddings(): Embeddings
    {
        return new \Tectalic\OpenAi\Handlers\Embeddings($this);
    }

    /**
     * Access to the enginesSearch handler.
     *
     * @api
     * @return EnginesSearch
     */
    public function enginesSearch(): EnginesSearch
    {
        return new \Tectalic\OpenAi\Handlers\EnginesSearch($this);
    }

    /**
     * Access to the files handler.
     *
     * @api
     * @return Files
     */
    public function files(): Files
    {
        return new \Tectalic\OpenAi\Handlers\Files($this);
    }

    /**
     * Access to the filesContent handler.
     *
     * @api
     * @return FilesContent
     */
    public function filesContent(): FilesContent
    {
        return new \Tectalic\OpenAi\Handlers\FilesContent($this);
    }

    /**
     * Access to the answers handler.
     *
     * @api
     * @return Answers
     */
    public function answers(): Answers
    {
        return new \Tectalic\OpenAi\Handlers\Answers($this);
    }

    /**
     * Access to the classifications handler.
     *
     * @api
     * @return Classifications
     */
    public function classifications(): Classifications
    {
        return new \Tectalic\OpenAi\Handlers\Classifications($this);
    }

    /**
     * Access to the fineTunes handler.
     *
     * @api
     * @return FineTunes
     */
    public function fineTunes(): FineTunes
    {
        return new \Tectalic\OpenAi\Handlers\FineTunes($this);
    }

    /**
     * Access to the fineTunesCancel handler.
     *
     * @api
     * @return FineTunesCancel
     */
    public function fineTunesCancel(): FineTunesCancel
    {
        return new \Tectalic\OpenAi\Handlers\FineTunesCancel($this);
    }

    /**
     * Access to the fineTunesEvents handler.
     *
     * @api
     * @return FineTunesEvents
     */
    public function fineTunesEvents(): FineTunesEvents
    {
        return new \Tectalic\OpenAi\Handlers\FineTunesEvents($this);
    }

    /**
     * Access to the models handler.
     *
     * @api
     * @return Models
     */
    public function models(): Models
    {
        return new \Tectalic\OpenAi\Handlers\Models($this);
    }

    /**
     * Encode the request body.
     *
     * @param RequestInterface $request
     * @param AbstractModel|AbstractModelCollection $body
     *
     * @return RequestInterface
     * @throws ClientException
     */
    private function encodeBody(RequestInterface $request, $body): RequestInterface
    {
        $contentType = \strtolower($request->getHeaderLine('Content-Type'));
        if ($contentType === '') {
            throw new ClientException('Unable to encode body. Content-Type request header must be set.');
        }
        if (\strpos($contentType, 'application/json') !== false) {
            return $request->withBody($this->encodeJsonBody($body));
        }
        if (\strpos($contentType, 'application/x-www-form-urlencoded') !== false) {
            return $request->withBody($this->encodeFormBody($body));
        }
        if (\strpos($contentType, 'multipart/form-data') !== false) {
            $builder = new MultipartStreamBuilder($this->psr17Factory);
            $request = $request->withBody($this->encodeMultipart($builder, $body));
            // Add multipart boundary to Content-Type header.
            $request = $request->withoutHeader('Content-Type');
            return $request->withHeader('Content-Type', 'multipart/form-data; boundary=' . $builder->getBoundary());
        }
        throw new ClientException(\sprintf('Unexpected Content-Type header value: %s', $contentType));
    }

    /**
     * Encode a JSON request body.
     *
     * @param AbstractModel|AbstractModelCollection $body
     *
     * @return StreamInterface
     * @throws ClientException
     */
    private function encodeJsonBody($body): StreamInterface
    {
        $body = \json_encode($body->jsonSerialize());
        if (\json_last_error() !== \JSON_ERROR_NONE || $body === false) {
            throw new ClientException(
                'Unable to encode body as JSON: ' . \json_last_error_msg()
            );
        }
        return $this->psr17Factory->createStream($body);
    }

    /**
     * Encode a Form Parameter request body.
     *
     * @param AbstractModel|AbstractModelCollection $body
     *
     * @return StreamInterface
     */
    private function encodeFormBody($body): StreamInterface
    {
        $body = $body->jsonSerialize();
        if (!\is_array($body) && !\is_object($body)) {
            throw new ClientException(
                'Unable to encode body. Could not serialize data.'
            );
        }
        return $this->psr17Factory->createStream(\http_build_query($body, '', '&'));
    }

    /**
     * Encode a Multipart (file upload) request body.
     *
     * @param MultipartStreamBuilder $builder
     * @param AbstractModel|AbstractModelCollection $body
     *
     * @return StreamInterface
     * @throws ClientException
     */
    private function encodeMultipart(MultipartStreamBuilder $builder, $body): StreamInterface
    {
        $modelClass = \get_class($body);
        $body = $body->jsonSerialize();
        if (!\is_object($body)) {
            throw new ClientException(
                'Unable to encode body. Could not serialize data.'
            );
        }
        foreach (\get_object_vars($body) as $propertyName => $value) {
            if (defined("\\$modelClass::FILE_UPLOADS") && \in_array($propertyName, $modelClass::FILE_UPLOADS)) {
                // Property is a full path to a file.
                // Attempt to open the file.
                /** @var string $value */
                \set_error_handler(function ($t, $m) use ($value) {
                    throw new ClientException(\sprintf('Unable to read file: %s', $value));
                });
                try {
                    /** @var resource $file */
                    $file = \fopen($value, 'r');
                    $this->fileHandles[] = $file;
                } finally {
                    \restore_error_handler();
                }
                $builder->addResource($propertyName, $file, ['filename' => \basename($value)]);
                continue;
            }

            // Property is not a file.
            try {
                // @phpstan-ignore-next-line Reason: errors handled by try/catch.
                $stringValue = (string) $value;
                $builder->addResource($propertyName, $stringValue, ['headers' => ['Content-Type' => 'text/plain']]);
            } catch (Throwable $e) {
                throw new ClientException(
                    \sprintf(
                        'Unable to convert %s value of %s::%s to a string.',
                        \gettype($value),
                        $modelClass,
                        $propertyName
                    )
                );
            }
        }

        return $builder->build();
    }

    /**
     * Merge various parts to the request.
     *
     * @param RequestInterface $request
     * @param array<string,string> $headers
     * @param array<string,mixed> $params
     * @param AbstractModel|AbstractModelCollection|null $body
     *
     * @return RequestInterface
     */
    private function mergeRequestParts(
        RequestInterface $request,
        array $headers,
        array $params,
        $body
    ): RequestInterface {
        if (!empty($params)) {
            $uri = $request->getUri();
            $query = $uri->getQuery();
            \parse_str($query, $parsed);
            $parsed = \array_merge($parsed, $params);
            // Ensure bool values are sent as 'true' and 'false' rather than '1' or '0'.
            \array_walk_recursive($parsed, function (&$value) {
                if (\is_bool($value)) {
                    $value = $value ? 'true' : 'false';
                }
            });
            $query = \http_build_query($parsed, '', '&', \PHP_QUERY_RFC3986);
            $uri = $uri->withQuery($query);
            $request = $request->withUri($uri);
        }

        $request = $request->withHeader(
            'User-Agent',
            'Tectalic OpenAI REST API Client'
        );

        // Merge Headers.
        if (!empty($headers)) {
            foreach ($headers as $name => $value) {
                $request = $request->withHeader($name, $value);
            }
        }

        // Merge Body.
        if (!\is_null($body)) {
            $request = $this->encodeBody($request, $body);
        }

        // Merge Authentication and return.
        return $this->auth->authenticate($request);
    }

    /**
     * Build a GET request.
     *
     * @internal
     * @param string $path
     * @param AbstractModel|AbstractModelCollection|null $body
     * @param array<string,string> $headers
     * @param array<string,mixed> $params
     *
     * @return RequestInterface
     */
    public function get(string $path, $body = null, array $headers = [], array $params = []): RequestInterface
    {
        $request = $this->psr17Factory->createRequest('GET', $this->baseUri . $path);
        return $this->mergeRequestParts($request, $headers, $params, $body);
    }

    /**
     * Build a POST request.
     *
     * @internal
     * @param string $path
     * @param AbstractModel|AbstractModelCollection|null $body
     * @param array<string,string> $headers
     * @param array<string,mixed> $params
     *
     * @return RequestInterface
     */
    public function post(string $path, $body = null, array $headers = [], array $params = []): RequestInterface
    {
        $request = $this->psr17Factory->createRequest('POST', $this->baseUri . $path);
        return $this->mergeRequestParts($request, $headers, $params, $body);
    }

    /**
     * Build a PUT request.
     *
     * @internal
     * @param string $path
     * @param AbstractModel|AbstractModelCollection|null $body
     * @param array<string,string> $headers
     * @param array<string,mixed> $params
     *
     * @return RequestInterface
     */
    public function put(string $path, $body = null, array $headers = [], array $params = []): RequestInterface
    {
        $request = $this->psr17Factory->createRequest('PUT', $this->baseUri . $path);
        return $this->mergeRequestParts($request, $headers, $params, $body);
    }

    /**
     * Build a PATCH request.
     *
     * @internal
     * @param string $path
     * @param AbstractModel|AbstractModelCollection|null $body
     * @param array<string,string> $headers
     * @param array<string,mixed> $params
     *
     * @return RequestInterface
     */
    public function patch(string $path, $body = null, array $headers = [], array $params = []): RequestInterface
    {
        $request = $this->psr17Factory->createRequest('PATCH', $this->baseUri . $path);
        return $this->mergeRequestParts($request, $headers, $params, $body);
    }

    /**
     * Build a DELETE request.
     *
     * @internal
     * @param string $path
     * @param AbstractModel|AbstractModelCollection|null $body
     * @param array<string,string> $headers
     * @param array<string,mixed> $params
     *
     * @return RequestInterface
     */
    public function delete(string $path, $body = null, array $headers = [], array $params = []): RequestInterface
    {
        $request = $this->psr17Factory->createRequest('DELETE', $this->baseUri . $path);
        return $this->mergeRequestParts($request, $headers, $params, $body);
    }

    /**
     * Build an OPTIONS request.
     *
     * @internal
     * @param string $path
     * @param AbstractModel|AbstractModelCollection|null $body
     * @param array<string,string> $headers
     * @param array<string,mixed> $params
     *
     * @return RequestInterface
     */
    public function options(string $path, $body = null, array $headers = [], array $params = []): RequestInterface
    {
        $request = $this->psr17Factory->createRequest('OPTIONS', $this->baseUri . $path);
        return $this->mergeRequestParts($request, $headers, $params, $body);
    }

    /**
     * Sends a PSR-7 request and returns a PSR-7 response.
     *
     * @internal
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     * @throws ClientException
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->httpClient->sendRequest($request);
        } catch (Throwable $e) {
            if ($e instanceof ClientExceptionInterface) {
                throw $e;
            }
            throw new ClientException(
                'Unexpected error. See previous exception for details.',
                0,
                $e
            );
        } finally {
            // Close any open file pointers from the request.
            foreach ($this->fileHandles as $file) {
                \set_error_handler(function ($t, $m) {
                    throw new ClientException();
                });
                try {
                    \fclose($file);
                } catch (Throwable $e) {
                    // File pointer is already closed. Silence error.
                } finally {
                    \restore_error_handler();
                }
            }
            $this->fileHandles = [];
        }
    }
}