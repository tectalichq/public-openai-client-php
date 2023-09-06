<?php

/**
 * Copyright (c) 2022-present Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tests\Integration\Handlers;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Psr18Client;
use Tectalic\OpenAi\Authentication;
use Tectalic\OpenAi\Client;
use Tectalic\OpenAi\Models\Models\DeleteResponse;
use Tectalic\OpenAi\Models\Models\ListResponse;
use Tectalic\OpenAi\Models\Models\RetrieveResponse;
use Tests\MockUri;

final class ModelsTest extends TestCase
{
    /** @var Client */
    public $client;

    public function setUp(): void
    {
        $this->client = new Client(
            new Psr18Client(),
            new Authentication(getenv('OPENAI_CLIENT_TEST_AUTH_TOKEN') ?: 'token'),
            (new MockUri())->base
        );
    }

    public function testListMethod(): void
    {
        $list = $this->client->models()->list();
        $response = $list->getResponse();
        $this->assertGreaterThanOrEqual(200, $response->getStatusCode());
        $this->assertLessThan(300, $response->getStatusCode());
        $model = $list->toModel();
        $model->jsonSerialize();
        $this->assertInstanceOf(ListResponse::class, $model);
    }

    public function testRetrieveMethod(): void
    {
        $retrieve = $this->client->models()->retrieve('gpt-3.5-turbo');
        $response = $retrieve->getResponse();
        $this->assertGreaterThanOrEqual(200, $response->getStatusCode());
        $this->assertLessThan(300, $response->getStatusCode());
        $model = $retrieve->toModel();
        $model->jsonSerialize();
        $this->assertInstanceOf(RetrieveResponse::class, $model);
    }

    public function testDeleteMethod(): void
    {
        $delete = $this->client->models()->delete('ft:gpt-3.5-turbo:acemeco:suffix:abc123');
        $response = $delete->getResponse();
        $this->assertGreaterThanOrEqual(200, $response->getStatusCode());
        $this->assertLessThan(300, $response->getStatusCode());
        $model = $delete->toModel();
        $model->jsonSerialize();
        $this->assertInstanceOf(DeleteResponse::class, $model);
    }
}
