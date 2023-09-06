<?php

/**
 * Copyright (c) 2022-present Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tectalic\OpenAi\Models\FineTuningJobsEvents;

use Tectalic\OpenAi\Models\AbstractModel;

final class ListFineTuningResponseDataItem extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = ['id', 'object', 'created_at', 'level', 'message'];

    /** @var string */
    public $id;

    /** @var string */
    public $object;

    /** @var int */
    public $created_at;

    /**
     * Allowed values: 'info', 'warn', 'error'
     *
     * @var string
     */
    public $level;

    /** @var string */
    public $message;
}
