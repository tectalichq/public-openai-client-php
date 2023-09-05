<?php

/**
 * Copyright (c) 2022-present Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tectalic\OpenAi\Models\Moderations;

use Tectalic\OpenAi\Models\AbstractModel;

final class CreateResponse extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = ['id', 'model', 'results'];

    /**
     * The unique identifier for the moderation request.
     *
     * @var string
     */
    public $id;

    /**
     * The model used to generate the moderation results.
     *
     * @var string
     */
    public $model;

    /**
     * A list of moderation objects.
     *
     * @var \Tectalic\OpenAi\Models\Moderations\CreateResponseResultsItem[]
     */
    public $results;
}
