<?php

/**
 * Copyright (c) 2022-present Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tests\Unit\Handlers;

use Http\Mock\Client;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionObject;
use Tectalic\OpenAi\Authentication;
use Tectalic\OpenAi\ClientException;
use Tectalic\OpenAi\Handlers\FineTuningJobs;
use Tectalic\OpenAi\Manager;
use Tectalic\OpenAi\Models\FineTuningJobs\CreateRequest;
use Tests\AssertValidateTrait;

final class FineTuningJobsTest extends TestCase
{
    use AssertValidateTrait;

    /** @var Client */
    private $mockClient;

    protected function setUp(): void
    {
        $this->mockClient = new Client();
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
        (new FineTuningJobs())->getRequest();
    }

    public function testUnsupportedContentTypeResponse(): void
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Unsupported content type: text/plain');

        $handler = new FineTuningJobs();
        $method = (new ReflectionObject($handler))->getMethod('parseResponse');
        $method->setAccessible(true);
        $method->invoke($handler, new Response(
            200,
            ['Content-Type' => 'text/plain'],
            null
        ));
    }

    public function testInvalidJsonResponse(): void
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Failed to parse JSON response body: Syntax error');

        $handler = new FineTuningJobs();
        $method = (new ReflectionObject($handler))->getMethod('parseResponse');
        $method->setAccessible(true);
        $method->invoke($handler, new Response(
            200,
            ['Content-Type' => 'application/json'],
            'invalidJson'
        ));
    }

    public function testUnsuccessfulResponseCode(): void
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage("Unsuccessful response. HTTP status code: 418 (I'm a teapot).");

        $handler = new FineTuningJobs();
        $property = (new ReflectionObject($handler))->getProperty('response');
        $property->setAccessible(true);
        $property->setValue($handler, new Response(418));
        $handler->toModel();
    }

    public static function toArrayDataProvider(): array
    {
        return [
            ['{}', []],
            ['[]', []],
            ['{"a": "b"}', ['a' => 'b']],
        ];
    }

    /**
     * @dataProvider toArrayDataProvider
     */
    public function testToArray(string $rawJsonResponse, array $expected): void
    {
        $handler = new FineTuningJobs();
        $property = (new ReflectionObject($handler))->getProperty('response');
        $property->setAccessible(true);
        $property->setValue($handler, new Response(
            200,
            ['Content-Type' => 'application/json'],
            $rawJsonResponse
        ));
        $this->assertSame($expected, $handler->toArray());
    }

    public function testListPaginatedMethod(): void
    {
        $request = (new FineTuningJobs())
            ->listPaginated(['after' => 'alpha0', 'limit' => 20])
            ->getRequest();
        $this->assertValidate($request);
    }

    public function testCreateMethod(): void
    {
        $request = (new FineTuningJobs())
            ->create(new CreateRequest([
            'training_file' => 'file-abc123',
            'model' => 'gpt-3.5-turbo',
        ]))
            ->getRequest();
        $this->assertValidate($request);
    }

    public function testRetrieveMethod(): void
    {
        $request = (new FineTuningJobs())
            ->retrieve('ft-AF1WoRqd3aJAHsqc9NY7iL8F')
            ->getRequest();
        $this->assertValidate($request);
    }
}
