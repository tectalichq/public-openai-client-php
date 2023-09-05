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

final class CreateResponse extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = ['id', 'object', 'created', 'model', 'choices'];

    /**
     * A unique identifier for the completion.
     *
     * @var string
     */
    public $id;

    /**
     * The object type, which is always "text_completion"
     *
     * @var string
     */
    public $object;

    /**
     * The Unix timestamp (in seconds) of when the completion was created.
     *
     * @var int
     */
    public $created;

    /**
     * The model used for completion.
     *
     * @var string
     */
    public $model;

    /**
     * The list of completion choices the model generated for the input prompt.
     *
     * @var \Tectalic\OpenAi\Models\Completions\CreateResponseChoicesItem[]
     */
    public $choices;

    /**
     * Usage statistics for the completion request.
     *
     * @var \Tectalic\OpenAi\Models\Completions\CreateResponseUsage
     */
    public $usage;
}
