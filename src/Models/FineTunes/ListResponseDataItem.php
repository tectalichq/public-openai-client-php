<?php

/**
 * Copyright (c) 2022-present Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tectalic\OpenAi\Models\FineTunes;

use Tectalic\OpenAi\Models\AbstractModel;

final class ListResponseDataItem extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = [
        'id',
        'object',
        'created_at',
        'updated_at',
        'model',
        'fine_tuned_model',
        'organization_id',
        'status',
        'hyperparams',
        'training_files',
        'validation_files',
        'result_files',
    ];

    /**
     * The object identifier, which can be referenced in the API endpoints.
     *
     * @var string
     */
    public $id;

    /**
     * The object type, which is always "fine-tune".
     *
     * @var string
     */
    public $object;

    /**
     * The Unix timestamp (in seconds) for when the fine-tuning job was created.
     *
     * @var int
     */
    public $created_at;

    /**
     * The Unix timestamp (in seconds) for when the fine-tuning job was last updated.
     *
     * @var int
     */
    public $updated_at;

    /**
     * The base model that is being fine-tuned.
     *
     * @var string
     */
    public $model;

    /**
     * The name of the fine-tuned model that is being created.
     *
     * @var string|null
     */
    public $fine_tuned_model;

    /**
     * The organization that owns the fine-tuning job.
     *
     * @var string
     */
    public $organization_id;

    /**
     * The current status of the fine-tuning job, which can be either created, running,
     * succeeded, failed, or cancelled.
     *
     * @var string
     */
    public $status;

    /**
     * The hyperparameters used for the fine-tuning job. See the fine-tuning guide for
     * more details.
     *
     * @var \Tectalic\OpenAi\Models\FineTunes\ListResponseDataItemHyperparams
     */
    public $hyperparams;

    /**
     * The list of files used for training.
     *
     * @var \Tectalic\OpenAi\Models\FineTunes\ListResponseDataItemTrainingFilesItem[]
     */
    public $training_files;

    /**
     * The list of files used for validation.
     *
     * @var \Tectalic\OpenAi\Models\FineTunes\ListResponseDataItemValidationFilesItem[]
     */
    public $validation_files;

    /**
     * The compiled results files for the fine-tuning job.
     *
     * @var \Tectalic\OpenAi\Models\FineTunes\ListResponseDataItemResultFilesItem[]
     */
    public $result_files;

    /**
     * The list of events that have been observed in the lifecycle of the FineTune job.
     *
     * @var \Tectalic\OpenAi\Models\FineTunes\ListResponseDataItemEventsItem[]
     */
    public $events;
}
