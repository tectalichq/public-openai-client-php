<?php

/**
 * Copyright (c) 2022-present Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tectalic\OpenAi\Models\Completions;

use Tectalic\OpenAi\Models\AbstractModel;

final class CreateResponseChoicesItem extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = ['text', 'index', 'logprobs', 'finish_reason'];

    /** @var string */
    public $text;

    /** @var int */
    public $index;

    /** @var \Tectalic\OpenAi\Models\Completions\CreateResponseChoicesItemLogprobs|null */
    public $logprobs;

    /**
     * The reason the model stopped generating tokens. This will be stop if the model
     * hit a natural stop point or a provided stop sequence,
     * or length if the maximum number of tokens specified in the request was reached.
     *
     * Allowed values: 'stop', 'length'
     *
     * @var string
     */
    public $finish_reason;
}
