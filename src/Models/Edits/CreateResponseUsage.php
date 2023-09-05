<?php

/**
 * Copyright (c) 2022-present Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tectalic\OpenAi\Models\Edits;

use Tectalic\OpenAi\Models\AbstractModel;

final class CreateResponseUsage extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = ['prompt_tokens', 'completion_tokens', 'total_tokens'];

    /**
     * Number of tokens in the prompt.
     *
     * @var int
     */
    public $prompt_tokens;

    /**
     * Number of tokens in the generated completion.
     *
     * @var int
     */
    public $completion_tokens;

    /**
     * Total number of tokens used in the request (prompt + completion).
     *
     * @var int
     */
    public $total_tokens;
}
