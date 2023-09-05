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

final class CreateRequest extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = ['training_file', 'model'];

    /**
     * The ID of an uploaded file that contains training data.
     * See upload file for how to upload a file.
     * Your dataset must be formatted as a JSONL file. Additionally, you must upload
     * your file with the purpose fine-tune.
     * See the fine-tuning guide for more details.
     *
     * Example: 'file-abc123'
     *
     * @var string
     */
    public $training_file;

    /**
     * The ID of an uploaded file that contains validation data.
     * If you provide this file, the data is used to generate validation
     * metrics periodically during fine-tuning. These metrics can be viewed in
     * the fine-tuning results file.
     * The same data should not be present in both train and validation files.
     * Your dataset must be formatted as a JSONL file. You must upload your file with
     * the purpose fine-tune.
     * See the fine-tuning guide for more details.
     *
     * Example: 'file-abc123'
     *
     * @var string|null
     */
    public $validation_file;

    /**
     * The name of the model to fine-tune. You can select one of the
     * supported models.
     *
     * Example: 'gpt-3.5-turbo'
     *
     * @var mixed
     */
    public $model;

    /**
     * The hyperparameters used for the fine-tuning job.
     *
     * @var \Tectalic\OpenAi\Models\FineTuningJobs\CreateRequestHyperparameters
     */
    public $hyperparameters;

    /**
     * A string of up to 40 characters that will be added to your fine-tuned model
     * name.
     * For example, a suffix of "custom-model-name" would produce a model name like
     * ft:gpt-3.5-turbo:openai:custom-model-name:7p4lURel.
     *
     * Default Value: null
     *
     * @var string|null
     */
    public $suffix;
}
