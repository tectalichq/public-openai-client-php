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

final class RetrieveResponseHyperparams extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = ['n_epochs', 'batch_size', 'prompt_loss_weight', 'learning_rate_multiplier'];

    /**
     * The number of epochs to train the model for. An epoch refers to one
     * full cycle through the training dataset.
     *
     * @var int
     */
    public $n_epochs;

    /**
     * The batch size to use for training. The batch size is the number of
     * training examples used to train a single forward and backward pass.
     *
     * @var int
     */
    public $batch_size;

    /**
     * The weight to use for loss on the prompt tokens.
     *
     * @var float|int
     */
    public $prompt_loss_weight;

    /**
     * The learning rate multiplier to use for training.
     *
     * @var float|int
     */
    public $learning_rate_multiplier;

    /**
     * The classification metrics to compute using the validation dataset at the end of
     * every epoch.
     *
     * @var bool
     */
    public $compute_classification_metrics;

    /**
     * The positive class to use for computing classification metrics.
     *
     * @var string
     */
    public $classification_positive_class;

    /**
     * The number of classes to use for computing classification metrics.
     *
     * @var int
     */
    public $classification_n_classes;
}
