<?php

/**
 * Copyright (c) 2022 Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tests\Unit\Handlers;

use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Tectalic\OpenAi\Authentication;
use Tectalic\OpenAi\ClientException;
use Tectalic\OpenAi\Handlers\FineTunesCancel;
use Tectalic\OpenAi\Manager;
use Tests\AssertValidateTrait;
use Tests\MockHttpClient;

final class FineTunesCancelTest extends TestCase
{
    use AssertValidateTrait;

    /** @var MockHttpClient */
    private $mockClient;

    protected function setUp(): void
    {
        $this->mockClient = new MockHttpClient();
        Manager::build(
            $this->mockClient,
            new Authentication('token')
        );
    }

    protected function tearDown(): void
    {
        $reflectionClass = new ReflectionClass(Manager::class);
        $reflectionProperty = $reflectionClass->getProperty('client');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue(null);
    }

    public function testMissingRequest(): void
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Request not configured.');
        (new FineTunesCancel())->getRequest();
    }

    public function testUnsupportedContentTypeResponse(): void
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Unsupported content type: text/plain');

        $this->mockClient->makeResponse(
            new Response(
                200,
                ['Content-Type' => 'text/plain'],
                null
            )
        );
        (new FineTunesCancel())->cancelFineTune('ft-AF1WoRqd3aJAHsqc9NY7iL8F')->toArray();
    }

    public function testInvalidJsonResponse(): void
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Failed to parse JSON response body: Syntax error');

        $this->mockClient->makeResponse(
            new Response(
                200,
                ['Content-Type' => 'application/json'],
                'invalidJson'
            )
        );
        (new FineTunesCancel())->cancelFineTune('ft-AF1WoRqd3aJAHsqc9NY7iL8F')->toArray();
    }

    public function testUnsuccessfulResponseCode(): void
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Unsuccessful response. HTTP status code: 418 (I'm a teapot).");

        $this->mockClient->makeResponse(new Response(418));
        (new FineTunesCancel())->cancelFineTune('ft-AF1WoRqd3aJAHsqc9NY7iL8F')->toModel();
    }

    public function testCancelFineTuneMethod(): void
    {
        $request = (new FineTunesCancel())
            ->cancelFineTune('ft-AF1WoRqd3aJAHsqc9NY7iL8F')
            ->getRequest();
        $this->assertValidate($request);
    }
}
