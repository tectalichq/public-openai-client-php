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

final class ListPaginatedResponseDataItem extends AbstractModel
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
        'hyperparameters',
        'training_file',
        'trained_tokens',
        'validation_file',
        'result_files',
    ];

    /**
     * The object identifier, which can be referenced in the API endpoints.
     *
     * @var string
     */
    public $id;

    /**
     * The object type, which is always "fine_tuning.job".
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
     * The Unix timestamp (in seconds) for when the fine-tuning job was finished. The
     * value will be null if the fine-tuning job is still running.
     *
     * @var int|null
     */
    public $finished_at;

    /**
     * The base model that is being fine-tuned.
     *
     * @var string
     */
    public $model;

    /**
     * The name of the fine-tuned model that is being created. The value will be null
     * if the fine-tuning job is still running.
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
     * The current status of the fine-tuning job, which can be either created, pending,
     * running, succeeded, failed, or cancelled.
     *
     * @var string
     */
    public $status;

    /**
     * The hyperparameters used for the fine-tuning job. See the fine-tuning guide for
     * more details.
     *
     * @var \Tectalic\OpenAi\Models\FineTuningJobs\ListPaginatedResponseDataItemHyperparameters
     */
    public $hyperparameters;

    /**
     * The file ID used for training. You can retrieve the training data with the Files
     * API.
     *
     * @var string
     */
    public $training_file;

    /**
     * The file ID used for validation. You can retrieve the validation results with
     * the Files API.
     *
     * @var string|null
     */
    public $validation_file;

    /**
     * The compiled results file ID(s) for the fine-tuning job. You can retrieve the
     * results with the Files API.
     *
     * @var string[]
     */
    public $result_files;

    /**
     * The total number of billable tokens processed by this fine-tuning job. The value
     * will be null if the fine-tuning job is still running.
     *
     * @var int|null
     */
    public $trained_tokens;
}
