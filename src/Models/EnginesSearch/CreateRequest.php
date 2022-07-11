<?php

/**
 * Copyright (c) 2022 Tectalic (https://tectalic.com)
 *
 * For copyright and license information, please view the LICENSE file that was distributed with this source code.
 *
 * Please see the README.md file for usage instructions.
 */

declare(strict_types=1);

namespace Tectalic\OpenAi\Models\EnginesSearch;

use Tectalic\OpenAi\Models\AbstractModel;

final class CreateRequest extends AbstractModel
{
    /**
     * List of required property names.
     *
     * These properties must all be set when this Model is instantiated.
     */
    protected const REQUIRED = ['query'];

    /**
     * Query to search against the documents.
     *
     * Example: 'the president'
     *
     * @var string
     */
    public $query;

    /**
     * Up to 200 documents to search over, provided as a list of strings.
     * The maximum document length (in tokens) is 2034 minus the number of tokens in
     * the query.
     * You should specify either documents or a file, but not both.
     *
     * @var string[]|null
     */
    public $documents;

    /**
     * The ID of an uploaded file that contains documents to search over.
     * You should specify either documents or a file, but not both.
     *
     * @var string|null
     */
    public $file;

    /**
     * The maximum number of documents to be re-ranked and returned by search.
     * This flag only takes effect when file is set.
     *
     * Default Value: 200
     *
     * @var int|null
     */
    public $max_rerank;

    /**
     * A special boolean flag for showing metadata. If set to true, each document entry
     * in the returned JSON will contain a "metadata" field.
     * This flag only takes effect when file is set.
     *
     * Default Value: false
     *
     * @var bool|null
     */
    public $return_metadata;

    /**
     * A unique identifier representing your end-user, which will help OpenAI to
     * monitor and detect abuse.
     *
     * Example: 'user-1234'
     *
     * @var string
     */
    public $user;
}
