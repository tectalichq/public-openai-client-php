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

final class RetrieveResponseTrainingFilesItem extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = ['id', 'object', 'bytes', 'created_at', 'filename', 'purpose', 'format'];

    /**
     * The file identifier, which can be referenced in the API endpoints.
     *
     * @var string
     */
    public $id;

    /**
     * The object type, which is always "file".
     *
     * @var string
     */
    public $object;

    /**
     * The size of the file in bytes.
     *
     * @var int
     */
    public $bytes;

    /**
     * The Unix timestamp (in seconds) for when the file was created.
     *
     * @var int
     */
    public $created_at;

    /**
     * The name of the file.
     *
     * @var string
     */
    public $filename;

    /**
     * The intended purpose of the file. Currently, only "fine-tune" is supported.
     *
     * @var string
     */
    public $purpose;

    /**
     * The current status of the file, which can be either uploaded, processed,
     * pending, error, deleting or deleted.
     *
     * @var string
     */
    public $status;

    /**
     * Additional details about the status of the file. If the file is in the error
     * state, this will include a message describing the error.
     *
     * @var string|null
     */
    public $status_details;
}
