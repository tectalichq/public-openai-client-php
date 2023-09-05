<?php

/**
 * Copyright (c) 2022-present Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tectalic\OpenAi\Models\ImagesVariations;

use Tectalic\OpenAi\Models\AbstractModel;

final class CreateImageResponseDataItem extends AbstractModel
{
    /**
     * The URL of the generated image, if response_format is url (default).
     *
     * @var string
     */
    public $url;

    /**
     * The base64-encoded JSON of the generated image, if response_format is b64_json.
     *
     * @var string
     */
    public $b64_json;
}
