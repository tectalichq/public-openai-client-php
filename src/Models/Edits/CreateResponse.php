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

final class CreateResponse extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = ['object', 'created', 'choices', 'usage'];

    /**
     * The object type, which is always edit.
     *
     * @var string
     */
    public $object;

    /**
     * The Unix timestamp (in seconds) of when the edit was created.
     *
     * @var int
     */
    public $created;

    /**
     * A list of edit choices. Can be more than one if n is greater than 1.
     *
     * @var \Tectalic\OpenAi\Models\Edits\CreateResponseChoicesItem[]
     */
    public $choices;

    /**
     * Usage statistics for the completion request.
     *
     * @var \Tectalic\OpenAi\Models\Edits\CreateResponseUsage
     */
    public $usage;
}
