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

final class CreateRequestHyperparameters extends AbstractModel
{
    /**
     * The number of epochs to train the model for. An epoch refers to one
     * full cycle through the training dataset.
     *
     * Default Value: 'auto'
     *
     * @var mixed
     */
    public $n_epochs;
}
