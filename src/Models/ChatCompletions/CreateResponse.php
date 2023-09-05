<?php

/**
 * Copyright (c) 2022-present Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tectalic\OpenAi\Models\ChatCompletions;

use Tectalic\OpenAi\Models\AbstractModel;

final class CreateResponse extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = ['id', 'object', 'created', 'model', 'choices'];

    /**
     * A unique identifier for the chat completion.
     *
     * @var string
     */
    public $id;

    /**
     * The object type, which is always chat.completion.
     *
     * @var string
     */
    public $object;

    /**
     * The Unix timestamp (in seconds) of when the chat completion was created.
     *
     * @var int
     */
    public $created;

    /**
     * The model used for the chat completion.
     *
     * @var string
     */
    public $model;

    /**
     * A list of chat completion choices. Can be more than one if n is greater than 1.
     *
     * @var \Tectalic\OpenAi\Models\ChatCompletions\CreateResponseChoicesItem[]
     */
    public $choices;

    /**
     * Usage statistics for the completion request.
     *
     * @var \Tectalic\OpenAi\Models\ChatCompletions\CreateResponseUsage
     */
    public $usage;
}
