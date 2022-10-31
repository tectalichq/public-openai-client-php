<?php

/**
 * Copyright (c) 2022 Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tectalic\OpenAi\Models\Edits;

use Tectalic\OpenAi\Models\AbstractModel;

final class CreateResponseChoicesItemLogprobs extends AbstractModel
{
    /** @var string[] */
    public $tokens;

    /** @var int[]|float[] */
    public $token_logprobs;

    /** @var \Tectalic\OpenAi\Models\Edits\CreateResponseChoicesItemLogprobsTopLogprobsItem[] */
    public $top_logprobs;

    /** @var integer[] */
    public $text_offset;
}