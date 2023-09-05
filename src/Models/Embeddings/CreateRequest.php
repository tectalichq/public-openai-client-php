<?php

/**
 * Copyright (c) 2022-present Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tectalic\OpenAi\Models\Embeddings;

use Tectalic\OpenAi\Models\AbstractModel;

final class CreateRequest extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = ['model', 'input'];

    /** @var bool */
    protected $ignoreMissing = false;

    /**
     * ID of the model to use. You can use the List models API to see all of your
     * available models, or see our Model overview for descriptions of them.
     *
     * Example: 'text-embedding-ada-002'
     *
     * @var mixed
     */
    public $model;

    /**
     * Input text to embed, encoded as a string or array of tokens. To embed multiple
     * inputs in a single request, pass an array of strings or array of token arrays.
     * Each input must not exceed the max input tokens for the model (8191 tokens for
     * text-embedding-ada-002). Example Python code for counting tokens.
     *
     * Example: 'The quick brown fox jumped over the lazy dog'
     *
     * @var mixed
     */
    public $input;

    /**
     * A unique identifier representing your end-user, which can help OpenAI to monitor
     * and detect abuse. Learn more.
     *
     * Example: 'user-1234'
     *
     * @var string
     */
    public $user;
}
