<?php

/**
 * Copyright (c) 2022 Tectalic (https://tectalic.com)
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
use Tectalic\OpenAi\Models\Answers\CreateRequest;
use Tectalic\OpenAi\Models\Answers\CreateResponse;
use Tests\MockUri;

final class AnswersTest extends TestCase
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

    public function testCreateMethod(): void
    {
        $create = $this->client->answers()->create(new CreateRequest([
            'model' => 'alpha0',
            'question' => 'What is the capital of Japan?',
            'examples' => [['What is the capital of Canada?', 'Ottawa'], ['Which province is Ottawa in?', 'Ontario']],
            'examples_context' => 'Ottawa, Canada\'s capital, is located in the east of southern Ontario, near the city of Montréal and the U.S. border.',
        ]));
        $response = $create->getResponse();
        $this->assertGreaterThanOrEqual(200, $response->getStatusCode());
        $this->assertLessThan(300, $response->getStatusCode());
        $model = $create->toModel();
        $model->jsonSerialize();
        $this->assertInstanceOf(CreateResponse::class, $model);
    }
}
