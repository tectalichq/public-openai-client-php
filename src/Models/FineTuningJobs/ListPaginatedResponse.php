<?php

/**
 * Copyright (c) 2022-present Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tectalic\OpenAi\Models\FineTuningJobs;

use Tectalic\OpenAi\Models\AbstractModel;

final class ListPaginatedResponse extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = ['object', 'data', 'has_more'];

    /** @var string */
    public $object;

    /** @var \Tectalic\OpenAi\Models\FineTuningJobs\ListPaginatedResponseDataItem[] */
    public $data;

    /** @var bool */
    public $has_more;
}
