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
use Tectalic\OpenAi\Models\FineTuningJobsEvents\ListFineTuningResponse;
use Tests\MockUri;

final class FineTuningJobsEventsTest extends TestCase
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

    public function testListFineTuningMethod(): void
    {
        $listFineTuning = $this->client->fineTuningJobsEvents()->listFineTuning('ft-AF1WoRqd3aJAHsqc9NY7iL8F', ['after' => 'alpha0', 'limit' => 20]);
        $response = $listFineTuning->getResponse();
        $this->assertGreaterThanOrEqual(200, $response->getStatusCode());
        $this->assertLessThan(300, $response->getStatusCode());
        $model = $listFineTuning->toModel();
        $model->jsonSerialize();
        $this->assertInstanceOf(ListFineTuningResponse::class, $model);
    }
}
