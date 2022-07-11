<?php

/**
 * Copyright (c) 2022 Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tests;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

final class MockHttpClient implements ClientInterface
{
    /** @var Throwable|null */
    private $exception;

    /** @var ResponseInterface|null */
    private $response;

    public function __construct(Throwable $exception = null)
    {
        $this->exception = $exception;
    }

    public function makeResponse(ResponseInterface $response): void
    {
        $this->response = $response;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        if (!\is_null($this->exception)) {
            throw $this->exception;
        }

        return $this->response ?? (new Psr17Factory())->createResponse();
    }
}
