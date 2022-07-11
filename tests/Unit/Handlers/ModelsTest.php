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
use Tectalic\OpenAi\Handlers\Models;
use Tectalic\OpenAi\Manager;
use Tests\AssertValidateTrait;
use Tests\MockHttpClient;

final class ModelsTest extends TestCase
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
        (new Models())->getRequest();
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
        (new Models())->list()->toArray();
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
        (new Models())->list()->toArray();
    }

    public function testUnsuccessfulResponseCode(): void
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Unsuccessful response. HTTP status code: 418 (I'm a teapot).");

        $this->mockClient->makeResponse(new Response(418));
        (new Models())->list()->toModel();
    }

    public function testListMethod(): void
    {
        $request = (new Models())
            ->list()
            ->getRequest();
        $this->assertValidate($request);
    }

    public function testRetrieveMethod(): void
    {
        $request = (new Models())
            ->retrieve('text-davinci-001')
            ->getRequest();
        $this->assertValidate($request);
    }

    public function testDeleteMethod(): void
    {
        $request = (new Models())
            ->delete('curie:ft-acmeco-2021-03-03-21-44-20')
            ->getRequest();
        $this->assertValidate($request);
    }
}
