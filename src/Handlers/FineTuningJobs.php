<?php

/**
 * Copyright (c) 2022-present Tectalic (https://tectalic.com)
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
use Tectalic\OpenAi\Models\FineTuningJobs\CreateRequest;
use Tectalic\OpenAi\Models\FineTuningJobs\CreateResponse;
use Tectalic\OpenAi\Models\FineTuningJobs\ListPaginatedResponse;
use Tectalic\OpenAi\Models\FineTuningJobs\RetrieveResponse;
use Throwable;

final class FineTuningJobs
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
     * List your organization's fine-tuning jobs
     *
     * Operation URL: GET /fine_tuning/jobs
     * Operation ID:  listPaginatedFineTuningJobs
     *
     * @param array $queryParams
     * - after:  Identifier for the last job from the previous pagination request.
     * - limit:  Number of fine-tuning jobs to retrieve.
     *
     * @api
     * @return self
     */
    public function listPaginated($queryParams = []): self
    {
        $url = '/fine_tuning/jobs';
        $this->setRequest($this->client->get(
            $url,
            null,
            [],
            $queryParams
        ));
        $this->modelType = ListPaginatedResponse::class;
        return $this;
    }

    /**
     * Creates a job that fine-tunes a specified model from a given dataset.
     * Response includes details of the enqueued job including job status and the name
     * of the fine-tuned models once complete.
     * Learn more about fine-tuning
     *
     * Operation URL: POST /fine_tuning/jobs
     * Operation ID:  createFineTuningJob
     *
     * @param CreateRequest|array $body
     *
     * @api
     * @return self
     */
    public function create($body): self
    {
        $url = '/fine_tuning/jobs';
        $this->setRequest($this->client->post(
            $url,
            \is_array($body) ? new CreateRequest($body) : $body,
            ['Content-Type' => 'application/json']
        ));
        $this->modelType = CreateResponse::class;
        return $this;
    }

    /**
     * Get info about a fine-tuning job.
     * Learn more about fine-tuning
     *
     * Operation URL: GET /fine_tuning/jobs/{fine_tuning_job_id}
     * Operation ID:  retrieveFineTuningJob
     *
     * @param string $fineTuningJobId The ID of the fine-tuning job.
     *
     * @api
     * @return self
     */
    public function retrieve($fineTuningJobId): self
    {
        $url = sprintf('/fine_tuning/jobs/%s', $fineTuningJobId);
        $this->setRequest($this->client->get(
            $url,
            null,
            []
        ));
        $this->modelType = RetrieveResponse::class;
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
