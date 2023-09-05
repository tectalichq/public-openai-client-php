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

final class CreateRequestFunctionsItem extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = ['name', 'parameters'];

    /**
     * The name of the function to be called. Must be a-z, A-Z, 0-9, or contain
     * underscores and dashes, with a maximum length of 64.
     *
     * @var string
     */
    public $name;

    /**
     * A description of what the function does, used by the model to choose when and
     * how to call the function.
     *
     * @var string
     */
    public $description;

    /**
     * The parameters the functions accepts, described as a JSON Schema object. See the
     * guide for examples, and the JSON Schema reference for documentation about the
     * format.
     * To describe a function that accepts no parameters, provide the value {"type":
     * "object", "properties": {}}.
     *
     * @var \Tectalic\OpenAi\Models\ChatCompletions\CreateRequestFunctionsItemParameters
     */
    public $parameters;
}
