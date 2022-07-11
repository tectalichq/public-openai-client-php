<?php

/**
 * Copyright (c) 2022 Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tectalic\OpenAi\Handlers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Tectalic\OpenAi\Client;
use Tectalic\OpenAi\ClientException;
use Tectalic\OpenAi\Manager;
use Tectalic\OpenAi\Models\AbstractModel;
use Tectalic\OpenAi\Models\AbstractModelCollection;
use Tectalic\OpenAi\Models\EnginesSearch\CreateRequest;
use Tectalic\OpenAi\Models\EnginesSearch\CreateResponse;
use Throwable;

final class EnginesSearch
{
    /** @var Client */
    private $client;

    /** @var RequestInterface|null */
    private $request = null;

    /** @var ResponseInterface|null */
    private $response = null;

    /** @var class-string<AbstractModel|AbstractModelCollection> */
    private $modelType;

    public function __construct(?Client $client = null)
    {
        $this->client = $client ?? Manager::access();
    }

    /**
     * The search endpoint computes similarity scores between provided query and
     * documents. Documents can be passed directly to the API if there are no more than
     * 200 of them.
     * To go beyond the 200 document limit, documents can be processed offline and then
     * used for efficient retrieval at query time. When file is set, the search
     * endpoint searches over all the documents in the given file and returns up to the
     * max_rerank number of documents. These documents will be returned along with
     * their search scores.
     * The similarity score is a positive score that usually ranges from 0 to 300 (but
     * can sometimes go higher), where a score above 200 usually means the document is
     * semantically similar to the query.
     *
     * Operation URL: POST /engines/{engine_id}/search
     * Operation ID:  createSearch
     *
     * @param string $engineId The ID of the engine to use for this request.  You can select one of ada,
     * babbage, curie, or davinci.
     * @param CreateRequest|array $body
     *
     * @api
     * @return self
     */
    public function create($engineId, $body): self
    {
        $url = sprintf('/engines/%s/search', $engineId);
        $this->setRequest($this->client->post(
            $url,
            \is_array($body) ? new CreateRequest($body) : $body,
            ['Content-Type' => 'application/json']
        ));
        $this->modelType = CreateResponse::class;
        return $this;
    }

    /**
     * Convert response body to an array.
     *
     * @return array
     * @throws ClientException
     */
    private function parseResponse(ResponseInterface $response): array
    {
        $contentType = \strtolower($response->getHeaderLine('Content-Type'));
        if (substr($contentType, 0, 16) !== 'application/json' && \strlen($contentType) !== 0) {
            throw new ClientException(\sprintf('Unsupported content type: %s', $contentType));
        }

        $body = (string) $response->getBody();
        $body = \strlen($body) === 0 ? '[]' : $body;
        $data = (array) \json_decode($body, true);

        if (\json_last_error()) {
            throw new ClientException(
                'Failed to parse JSON response body: ' . \json_last_error_msg()
            );
        }
        return $data;
    }

    /**
     * Sets the PSR 7 Response object.
     * Also removes the previous response.
     *
     * @param  RequestInterface  $request
     *
     * @return void
     */
    private function setRequest(RequestInterface $request): void
    {
        $this->request = $request;
        $this->response = null;
    }

    /**
     * Returns the PSR 7 Response object.
     *
     * @internal
     * @return RequestInterface
     * @throws ClientException
     */
    public function getRequest(): RequestInterface
    {
        if (\is_null($this->request)) {
            throw new ClientException('Request not configured.');
        }
        return $this->request;
    }

    /**
     * Returns the PSR 7 Response object.
     *
     * @api
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        if (!\is_null($this->response)) {
            return $this->response;
        }

        $this->response = $this->client->sendRequest($this->getRequest());
        $this->request = null;
        return $this->response;
    }

    /**
     * Returns the response body as a model/DTO.
     *
     * @api
     * @return AbstractModel|AbstractModelCollection
     * @throws ClientException if an unsuccessful HTTP response occurs.
     * @throws ClientException if the response body cannot be parsed.
     */
    public function toModel(): object
    {
        if ($this->getResponse()->getStatusCode() < 200 || $this->getResponse()->getStatusCode() >= 300) {
            throw new ClientException(
                \sprintf(
                    'Unsuccessful response. HTTP status code: %s (%s).',
                    $this->getResponse()->getStatusCode(),
                    $this->getResponse()->getReasonPhrase()
                )
            );
        }
        $class = $this->modelType;
        try {
            return new $class($this->parseResponse($this->getResponse()));
        } catch (Throwable $e) {
            throw new ClientException(
                'Response body parse failed. See previous exception for details.',
                0,
                $e
            );
        }
    }

    /**
     * Returns the response body as an associative array.
     *
     * @api
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return $this->parseResponse($this->getResponse());
    }
}
