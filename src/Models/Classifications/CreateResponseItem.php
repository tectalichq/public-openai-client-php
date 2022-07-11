<?php

/**
 * Copyright (c) 2022 Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tectalic\OpenAi\Models\Classifications;

use Tectalic\OpenAi\Models\AbstractModel;

final class CreateResponseItem extends AbstractModel
{
    /** @var int */
    public $document;

    /** @var string */
    public $text;

    /** @var string */
    public $label;
}
