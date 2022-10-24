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

final class CreateResponse extends AbstractModel
{
    /** @var string */
    public $object;

    /** @var string */
    public $model;

    /** @var string */
    public $search_model;

    /** @var string */
    public $completion;

    /** @var string */
    public $label;

    /** @var \Tectalic\OpenAi\Models\Classifications\CreateResponseSelectedExamplesItem[] */
    public $selected_examples;
}
