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

final class ListPaginatedResponseDataItemHyperparameters extends AbstractModel
{
    /**
     * The number of epochs to train the model for. An epoch refers to one full cycle
     * through the training dataset.
     * "Auto" decides the optimal number of epochs based on the size of the dataset. If
     * setting the number manually, we support any number between 1 and 50 epochs.
     *
     * Default Value: 'auto'
     *
     * @var mixed
     */
    public $n_epochs;
}
