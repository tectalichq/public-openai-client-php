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
use Tectalic\OpenAi\Handlers\Files;
use Tectalic\OpenAi\Manager;
use Tectalic\OpenAi\Models\Files\CreateRequest;
use Tests\AssertValidateTrait;
use Tests\MockHttpClient;
use org\bovigo\vfs\content\LargeFileContent;
use org\bovigo\vfs\vfsStream;

final class FilesTest extends TestCase
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
        (new Files())->getRequest();
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
        (new Files())->list()->toArray();
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
        (new Files())->list()->toArray();
    }

    public function testUnsuccessfulResponseCode(): void
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Unsuccessful response. HTTP status code: 418 (I'm a teapot).");

        $this->mockClient->makeResponse(new Response(418));
        (new Files())->list()->toModel();
    }

    public function testListMethod(): void
    {
        $request = (new Files())
            ->list()
            ->getRequest();
        $this->assertValidate($request);
    }

    public function testCreateMethod(): void
    {
        $filesystem = vfsStream::setup();
        // Create the file(s) to be uploaded.
        $files = ['file'];
        foreach ($files as $file) {
            vfsStream::newFile($file)
                ->withContent(LargeFileContent::withKilobytes(1))
                ->at($filesystem);
        }
        $request = (new Files())
            ->create(new CreateRequest(['file' => 'vfs://root/file', 'purpose' => 'fine-tune']))
            ->getRequest();
        $this->assertValidate($request);
    }

    public function testRetrieveMethod(): void
    {
        $request = (new Files())
            ->retrieve('alpha0')
            ->getRequest();
        $this->assertValidate($request);
    }

    public function testDeleteMethod(): void
    {
        $request = (new Files())
            ->delete('alpha0')
            ->getRequest();
        $this->assertValidate($request);
    }
}
