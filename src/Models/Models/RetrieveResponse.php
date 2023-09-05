<?php

/**
 * Copyright (c) 2022-present Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tectalic\OpenAi\Models\Models;

use Tectalic\OpenAi\Models\AbstractModel;

final class RetrieveResponse extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = ['id', 'object', 'created', 'owned_by'];

    /**
     * The model identifier, which can be referenced in the API endpoints.
     *
     * @var string
     */
    public $id;

    /**
     * The object type, which is always "model".
     *
     * @var string
     */
    public $object;

    /**
     * The Unix timestamp (in seconds) when the model was created.
     *
     * @var int
     */
    public $created;

    /**
     * The organization that owns the model.
     *
     * @var string
     */
    public $owned_by;
}
