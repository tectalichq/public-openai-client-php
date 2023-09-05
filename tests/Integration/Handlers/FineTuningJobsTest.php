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
use Tectalic\OpenAi\Models\FineTuningJobs\CreateRequest;
use Tectalic\OpenAi\Models\FineTuningJobs\CreateResponse;
use Tectalic\OpenAi\Models\FineTuningJobs\ListPaginatedResponse;
use Tectalic\OpenAi\Models\FineTuningJobs\RetrieveResponse;
use Tests\MockUri;

final class FineTuningJobsTest extends TestCase
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

    public function testListPaginatedMethod(): void
    {
        $listPaginated = $this->client->fineTuningJobs()->listPaginated(['after' => 'alpha0', 'limit' => 20]);
        $response = $listPaginated->getResponse();
        $this->assertGreaterThanOrEqual(200, $response->getStatusCode());
        $this->assertLessThan(300, $response->getStatusCode());
        $model = $listPaginated->toModel();
        $model->jsonSerialize();
        $this->assertInstanceOf(ListPaginatedResponse::class, $model);
    }

    public function testCreateMethod(): void
    {
        $create = $this->client->fineTuningJobs()->create(new CreateRequest([
            'training_file' => 'file-abc123',
            'model' => 'gpt-3.5-turbo',
        ]));
        $response = $create->getResponse();
        $this->assertGreaterThanOrEqual(200, $response->getStatusCode());
        $this->assertLessThan(300, $response->getStatusCode());
        $model = $create->toModel();
        $model->jsonSerialize();
        $this->assertInstanceOf(CreateResponse::class, $model);
    }

    public function testRetrieveMethod(): void
    {
        $retrieve = $this->client->fineTuningJobs()->retrieve('ft-AF1WoRqd3aJAHsqc9NY7iL8F');
        $response = $retrieve->getResponse();
        $this->assertGreaterThanOrEqual(200, $response->getStatusCode());
        $this->assertLessThan(300, $response->getStatusCode());
        $model = $retrieve->toModel();
        $model->jsonSerialize();
        $this->assertInstanceOf(RetrieveResponse::class, $model);
    }
}
