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

final class CreateResponseDataItem extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = ['index', 'object', 'embedding'];

    /**
     * The index of the embedding in the list of embeddings.
     *
     * @var int
     */
    public $index;

    /**
     * The object type, which is always "embedding".
     *
     * @var string
     */
    public $object;

    /**
     * The embedding vector, which is a list of floats. The length of vector depends on
     * the model as listed in the embedding guide.
     *
     * @var int[]|float[]
     */
    public $embedding;
}
